<?php

/**
 * TransferenciaCuenta actions.
 *
 * @package    gobel
 * @subpackage TransferenciaCuenta
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class TransferenciaCuentaActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */

    protected function getDatosCuenta($codigo)
    {

        $c = new Criteria();
        $c->addSelectColumn(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE);
        $c->addSelectColumn(Tb024CuentaContablePeer::TX_DESCRIPCION);
        $c->addSelectColumn(Tb024CuentaContablePeer::NU_CUENTA_CONTABLE);
        $c->addSelectColumn(Tb024CuentaContablePeer::TX_CUENTA);
        $c->addSelectColumn(Tb010BancoPeer::TX_BANCO);
        $c->addSelectColumn(Tb010BancoPeer::CO_BANCO);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::MO_DISPONIBLE);

        //$c->addJoin(Tb100BancoLibroPeer::ID, Tb103LibroDetallePeer::ID_TB100_BANCO_LIBRO);
        //    $c->addJoin(Tb100BancoLibroPeer::ID_TB011_CUENTA_BANCARIA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addJoin(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Tb011CuentaBancariaPeer::CO_CUENTA_CONTABLE);
        $c->addJoin(Tb010BancoPeer::CO_BANCO, Tb011CuentaBancariaPeer::CO_BANCO);


        $c->add(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, $codigo);

        $stmt = Tb024CuentaContablePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
    }

    protected function getLibroContable($co_cuenta)
    {


        $c = new Criteria();
        $c->addJoin(Tb100BancoLibroPeer::ID, Tb103LibroDetallePeer::ID_TB100_BANCO_LIBRO);
        $c->addJoin(Tb100BancoLibroPeer::ID_TB011_CUENTA_BANCARIA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addJoin(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Tb011CuentaBancariaPeer::CO_CUENTA_CONTABLE);
        $c->addJoin(Tb010BancoPeer::CO_BANCO, Tb011CuentaBancariaPeer::CO_BANCO);
        $c->add(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, $co_cuenta);
        $c->add(Tb103LibroDetallePeer::IN_ACTIVO, true);

        $stmt = Tb103LibroDetallePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos["id"];
    }

    public function executeLista(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "co_rol"            => $this->getUser()->getAttribute('rol'),
            "co_usuario"        => $this->getUser()->getAttribute('codigo'),
            "in_activo"         => $this->getUser()->getAttribute('in_activo'),
            "tx_tipo_solicitud" => $this->getRequestParameter("tx_tipo_solicitud"),
            "co_tipo_solicitud" => 18,
            "tx_url"            => $this->getRequestParameter("tx_url"),

        ));

        $this->getRequest()->setAttribute('in_activo', $this->getUser()->getAttribute('in_activo'));
    }

    public function executeCambiarEstado(sfWebRequest $request)
    {
        $co_estado               = $this->getRequestParameter("co_estado");
        $co_transferencia_cuenta = $this->getRequestParameter("co_transferencia_cuenta");
        $mo_debitar              = $this->getRequestParameter("mo_debitar");
        $co_cuenta_debita        = $this->getRequestParameter("co_cuenta_debita");
        $co_cuenta_creditar      = $this->getRequestParameter("co_cuenta_creditar");

        $CuentaDebitar           = Tb024CuentaContablePeer::retrieveByPK($co_cuenta_debita);
        $CuentaCreditar          = Tb024CuentaContablePeer::retrieveByPK($co_cuenta_creditar);


        $con = Propel::getConnection();
        try {
            $con->beginTransaction();

            $tb066_transferencia_cuenta = Tb066TransferenciaCuentaPeer::retrieveByPk($co_transferencia_cuenta);

            $tb066_transferencia_cuenta->setCoEstado($co_estado)
                ->setCoUsuarioCambioEstado($this->getUser()->getAttribute('codigo'))
                ->save($con);

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb066_transferencia_cuenta->getCoSolicitud()));

            if ($co_estado == 2) {


                $tb066_transferencia_cuenta->setCoEstado($co_estado)
                    ->setCoUsuarioCambioEstado($this->getUser()->getAttribute('codigo'))
                    ->save($con);

                $tb061_asiento_contable = new Tb061AsientoContable();
                $tb061_asiento_contable->setCoCuentaContable($co_cuenta_debita)
                    ->setMoHaber($mo_debitar)
                    ->setCoTipoAsiento(7)
                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                    ->setCoRuta($ruta->getCoRuta())
                    ->setCoSolicitud($tb066_transferencia_cuenta->getCoSolicitud())
                    ->save($con);

                if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                    $FeMovimiento = $this->getUser()->getAttribute('fe_cierre');
                } else {
                    $FeMovimiento = date("Y-m-d");
                }

                $tb134_movimiento_contable = new Tb134MovimientoContable();
                $tb134_movimiento_contable->setMoAnterior($CuentaDebitar->getMoDisponible())
                    ->setMoDebito($mo_debitar)
                    ->setMoDisponible($CuentaDebitar->getMoDisponible() - $mo_debitar)
                    ->setCoCuentaContable($co_cuenta_debita)
                    //->setFeMovimiento(date("Y-m-d"))
                    ->setFeMovimiento($FeMovimiento)
                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                    ->setCoSolicitud($tb066_transferencia_cuenta->getCoSolicitud())
                    ->save($con);

                $tb061_asiento_contable = new Tb061AsientoContable();
                $tb061_asiento_contable->setCoCuentaContable($co_cuenta_creditar)
                    ->setMoDebe($mo_debitar)
                    ->setCoTipoAsiento(7)
                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                    ->setCoRuta($ruta->getCoRuta())
                    ->setCoSolicitud($tb066_transferencia_cuenta->getCoSolicitud())
                    ->save($con);
                if ($tb066_transferencia_cuenta->getCoTipoRetencion() != '' || $tb066_transferencia_cuenta->getCoTipoRetencion() != null) {
                    $co_tipo_retencion = Tb041TipoRetencionPeer::retrieveByPK($tb066_transferencia_cuenta->getCoTipoRetencion());

                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setCoCuentaContable($co_tipo_retencion->getCoCuentaContable())
                        ->setMoDebe($mo_debitar)
                        ->setCoTipoAsiento(14)
                        ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                        ->setCoRuta($ruta->getCoRuta())
                        ->setCoSolicitud($tb066_transferencia_cuenta->getCoSolicitud())
                        ->save($con);

                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setCoCuentaContable($co_tipo_retencion->getCoCuentaTercero())
                        ->setMoHaber($mo_debitar)
                        ->setCoTipoAsiento(14)
                        ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                        ->setCoRuta($ruta->getCoRuta())
                        ->setCoSolicitud($tb066_transferencia_cuenta->getCoSolicitud())
                        ->save($con);
                }

                $tb134_movimiento_contable = new Tb134MovimientoContable();
                $tb134_movimiento_contable->setMoAnterior($CuentaCreditar->getMoDisponible())
                    ->setMoCredito($mo_debitar)
                    ->setMoDisponible($CuentaCreditar->getMoDisponible() + $mo_debitar)
                    ->setCoCuentaContable($co_cuenta_creditar)
                    //->setFeMovimiento(date("Y-m-d"))
                    ->setFeMovimiento($FeMovimiento)
                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                    ->setCoSolicitud($tb066_transferencia_cuenta->getCoSolicitud())
                    ->save($con);



                $CuentaDebitar->setMoDisponible($CuentaDebitar->getMoDisponible() - $mo_debitar)->save($con);
                $CuentaCreditar->setMoDisponible($CuentaCreditar->getMoDisponible() + $mo_debitar)->save($con);

                $tb011_transferencia_debito = Tb011CuentaBancariaPeer::retrieveByPk($tb066_transferencia_cuenta->getCoCuentaBancariaDebito());

                if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                    $nu_transaccion =  date("Ym", strtotime($this->getUser()->getAttribute('fe_cierre'))) . '-' . $tb066_transferencia_cuenta->getCoTransferenciaCuenta();
                } else {
                    $nu_transaccion = date("Ym") . '-' . $tb066_transferencia_cuenta->getCoTransferenciaCuenta();
                }

                $tb155_cuenta_bancaria_historico = new Tb155CuentaBancariaHistorico();
                $tb155_cuenta_bancaria_historico->setInActivo(true);
                $tb155_cuenta_bancaria_historico->setIdTb011CuentaBancaria($tb066_transferencia_cuenta->getCoCuentaBancariaDebito());
                $tb155_cuenta_bancaria_historico->setMoTransaccion($tb066_transferencia_cuenta->getMoDebito());
                $tb155_cuenta_bancaria_historico->setFeTransaccion($tb066_transferencia_cuenta->getCreatedAt('Y-m-d'));
                $tb155_cuenta_bancaria_historico->setDeObservacion('Transferencia entre Cuentas: solicitud Nº:' . $tb066_transferencia_cuenta->getCoSolicitud());
                $tb155_cuenta_bancaria_historico->setIdTb010Banco($tb066_transferencia_cuenta->getCoBancoDebito());
                $tb155_cuenta_bancaria_historico->setIdTb154TipoCuentaMovimiento(3);
                $tb155_cuenta_bancaria_historico->setIdTb153TipoDocumentoCuenta(3);
                $tb155_cuenta_bancaria_historico->setIdTb156SubtipoDocumento(20);
                $tb155_cuenta_bancaria_historico->setMoSaldoNuevo($tb011_transferencia_debito->getMoDisponible() - $mo_debitar);
                $tb155_cuenta_bancaria_historico->setMoSaldoAnterior($tb011_transferencia_debito->getMoDisponible());
                $tb155_cuenta_bancaria_historico->setNuTransaccion('OT-' . $nu_transaccion);
                $tb155_cuenta_bancaria_historico->setCoSolicitud($tb066_transferencia_cuenta->getCoSolicitud());
                $tb155_cuenta_bancaria_historico->save($con);


                $tb011_transferencia_debito->setMoDisponible($tb011_transferencia_debito->getMoDisponible() - $mo_debitar);
                $tb011_transferencia_debito->save($con);

                $tb011_transferencia_credito = Tb011CuentaBancariaPeer::retrieveByPk($tb066_transferencia_cuenta->getCoCuentaBancariaCredito());

                $tb155_cuenta_bancaria_historico_credito = new Tb155CuentaBancariaHistorico();
                $tb155_cuenta_bancaria_historico_credito->setInActivo(true);
                $tb155_cuenta_bancaria_historico_credito->setIdTb011CuentaBancaria($tb066_transferencia_cuenta->getCoCuentaBancariaCredito());
                $tb155_cuenta_bancaria_historico_credito->setMoTransaccion($tb066_transferencia_cuenta->getMoDebito());
                $tb155_cuenta_bancaria_historico_credito->setFeTransaccion($tb066_transferencia_cuenta->getCreatedAt('Y-m-d'));
                $tb155_cuenta_bancaria_historico_credito->setDeObservacion('Transferencia entre Cuentas: solicitud Nº:' . $tb066_transferencia_cuenta->getCoSolicitud());
                $tb155_cuenta_bancaria_historico_credito->setIdTb010Banco($tb066_transferencia_cuenta->getCoBancoCredito());
                $tb155_cuenta_bancaria_historico_credito->setIdTb154TipoCuentaMovimiento(6);
                $tb155_cuenta_bancaria_historico_credito->setIdTb153TipoDocumentoCuenta(2);
                $tb155_cuenta_bancaria_historico_credito->setIdTb156SubtipoDocumento(20);
                $tb155_cuenta_bancaria_historico_credito->setMoSaldoNuevo($tb011_transferencia_credito->getMoDisponible() + $mo_debitar);
                $tb155_cuenta_bancaria_historico_credito->setMoSaldoAnterior($tb011_transferencia_credito->getMoDisponible());
                $tb155_cuenta_bancaria_historico_credito->setNuTransaccion('OT-' . $nu_transaccion);
                $tb155_cuenta_bancaria_historico_credito->setCoSolicitud($tb066_transferencia_cuenta->getCoSolicitud());
                $tb155_cuenta_bancaria_historico_credito->save($con);

                $tb011_transferencia_credito->setMoDisponible($tb011_transferencia_credito->getMoDisponible() + $mo_debitar);
                $tb011_transferencia_credito->save($con);


                $estado = 'Aprobo';
            } else {
                $estado = 'Rechazó';
            }

            $con->commit();

            $ruta->setInCargarDato(true)->save($con);
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

            $con->commit();


            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'La transferencia se ' . $estado . ' con exito!'
            ));
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage()
            ));
        }
    }

    public function executeAprobacion(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::CO_TRANSFERENCIA_CUENTA);
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::MO_DEBITO);
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::CO_CUENTA_CONTABLE_CREDITO);
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::CO_CUENTA_CONTABLE_DEBITO);
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::CO_TIPO_RETENCION);
        $c->addSelectColumn(Tb031EstatusRutaPeer::TX_DESCRIPCION);
        $c->addSelectColumn(Tb031EstatusRutaPeer::CO_ESTATUS_RUTA);

        $c->addJoin(Tb031EstatusRutaPeer::CO_ESTATUS_RUTA, Tb066TransferenciaCuentaPeer::CO_ESTADO);
        $c->add(Tb066TransferenciaCuentaPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb056ContratoComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $datos_debito = $this->getDatosCuenta($campos["co_cuenta_contable_debito"]);
        $datos_credito = $this->getDatosCuenta($campos["co_cuenta_contable_credito"]);

        $this->data = json_encode(array(
            "co_solicitud" => $this->getRequestParameter("co_solicitud"),
            "co_cuenta_debitar" => $datos_debito["co_cuenta_contable"],
            "co_banco_debitar" => $datos_debito["co_banco"],
            "co_cuenta_bancaria_debitar" => $datos_debito["co_cuenta_bancaria"],
            "saldo_disponible" => $datos_debito["mo_saldo"],
            "tx_cuenta_debitar" => $datos_debito["tx_cuenta"],
            "tx_cuenta_bancaria_debitar"  => $datos_debito["tx_cuenta_bancaria"],
            "mo_debitar" => $campos["mo_debito"],
            "tx_descripcion_debitar" => $datos_debito["tx_descripcion"],
            "tx_banco_debitar" => $datos_debito["tx_banco"],
            "nu_saldo_debitar" => number_format($datos_debito["mo_disponible"], 0, ',', '.'),
            "tx_cuenta_bancaria_creditar" => $datos_credito["tx_cuenta_bancaria"],
            "co_cuenta_credito" => $datos_credito["co_cuenta_contable"],
            "co_banco_creditar" => $datos_credito["co_banco"],
            "co_cuenta_bancaria_creditar" => $datos_credito["co_cuenta_bancaria"],
            "tx_cuenta_creditar" => $datos_credito["tx_cuenta"],
            "tx_descripcion_creditar" => $datos_credito["tx_descripcion"],
            "tx_banco_creditar" => $datos_credito["tx_banco"],
            "nu_saldo_creditar" => number_format($datos_credito["mo_disponible"], 0, ',', '.'),
            "co_transferencia_cuenta" => $campos["co_transferencia_cuenta"],
            "co_tipo_retencion" => $campos["co_tipo_retencion"],
            "tx_estado_transferencia" => $campos["tx_descripcion"],
            "co_estado" => $campos["co_estatus_ruta"]
        ));
    }

    public function executeAgregar(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::CO_TRANSFERENCIA_CUENTA);
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::MO_DEBITO);
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::CO_CUENTA_CONTABLE_CREDITO);
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::CO_CUENTA_CONTABLE_DEBITO);
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::CO_TIPO_RETENCION);

        $c->add(Tb066TransferenciaCuentaPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb056ContratoComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $datos_debito = $this->getDatosCuenta($campos["co_cuenta_contable_debito"]);
        $datos_credito = $this->getDatosCuenta($campos["co_cuenta_contable_credito"]);

        $this->data = json_encode(array(
            "co_solicitud" => $this->getRequestParameter("co_solicitud"),
            "co_cuenta_debitar" => $datos_debito["co_cuenta_contable"],
            "co_banco_debitar" => $datos_debito["co_banco"],
            "co_cuenta_bancaria_debitar" => $datos_debito["co_cuenta_bancaria"],
            "saldo_disponible" => $datos_debito["mo_disponible"],
            "tx_cuenta_debitar" => $datos_debito["nu_cuenta_contable"],
            "tx_cuenta_bancaria_debitar"  => $datos_debito["tx_cuenta_bancaria"],
            "mo_debitar" => $campos["mo_debito"],
            "tx_descripcion_debitar" => $datos_debito["tx_descripcion"],
            "tx_banco_debitar" => $datos_debito["tx_banco"],
            "nu_saldo_debitar" => number_format($datos_debito["mo_disponible"], 0, ',', '.'),
            "tx_cuenta_bancaria_creditar" => $datos_credito["tx_cuenta_bancaria"],
            "co_cuenta_credito" => $datos_credito["co_cuenta_contable"],
            "co_banco_creditar" => $datos_credito["co_banco"],
            "co_cuenta_bancaria_creditar" => $datos_credito["co_cuenta_bancaria"],
            "tx_cuenta_creditar" => $datos_credito["nu_cuenta_contable"],
            "tx_descripcion_creditar" => $datos_credito["tx_descripcion"],
            "tx_banco_creditar" => $datos_credito["tx_banco"],
            "nu_saldo_creditar" => number_format($datos_credito["mo_disponible"], 0, ',', '.'),
            "co_transferencia_cuenta" => $campos["co_transferencia_cuenta"],
            "co_tipo_retencion" => $campos["co_tipo_retencion"]
        ));
    }

    public function executeBuscarDebitar(sfWebRequest $request)
    {
    }

    public function executeBuscarCreditar(sfWebRequest $request)
    {
    }

    public function executeGuardar(sfWebRequest $request)
    {
        $co_cuenta_debitar            =   $this->getRequestParameter("co_cuenta_debitar");
        $co_cuenta_creditar           =   $this->getRequestParameter("co_cuenta_creditar");
        $co_banco_creditar            =   $this->getRequestParameter("co_banco_creditar");
        $co_cuenta_bancaria_creditar  =   $this->getRequestParameter("co_cuenta_bancaria_creditar");
        $co_banco_debitar             =   $this->getRequestParameter("co_banco_debitar");
        $co_cuenta_bancaria_debitar   =   $this->getRequestParameter("co_cuenta_bancaria_debitar");
        $saldo_disponible             =   $this->getRequestParameter("saldo_disponible");

        $tx_cuenta_debitar            =   $this->getRequestParameter("tx_cuenta_debitar");
        $tx_cuenta_bancaria_debitar   =   $this->getRequestParameter("tx_cuenta_bancaria_debitar");
        $mo_debitar                   =   $this->getRequestParameter("mo_debitar");
        $tx_descripcion_debitar       =   $this->getRequestParameter("tx_descripcion_debitar");
        $tx_banco_debitar             =   $this->getRequestParameter("tx_banco_debitar");
        $tx_cuenta_bancaria_creditar  =   $this->getRequestParameter("tx_cuenta_bancaria_creditar");

        $nu_saldo_debitar             =   $this->getRequestParameter("nu_saldo_debitar");
        $tx_cuenta_creditar           =   $this->getRequestParameter("tx_cuenta_creditar");
        $tx_descripcion_creditar      =   $this->getRequestParameter("tx_descripcion_creditar");

        $tx_banco_creditar            =   $this->getRequestParameter("tx_banco_creditar");
        $nu_saldo_creditar            =   $this->getRequestParameter("nu_saldo_creditar");

        $co_solicitud                 =   $this->getRequestParameter("co_solicitud");
        $co_transferencia_cuenta      =   $this->getRequestParameter("co_transferencia_cuenta");
        $co_tipo_retencion      =   $this->getRequestParameter("co_tipo_retencion");

        $con = Propel::getConnection();

        try {
            $con->beginTransaction();

            if ($co_transferencia_cuenta == '') {

                $tb026_solicitudForm = array(
                    "co_tipo_solicitud"   => 18,
                    "ejercicio"           => $this->getUser()->getAttribute('ejercicio'),
                    "fe_solicitud"        => date("d/m/Y"),
                    "observacion"         => "Transferencia entre cuentas",
                    "codigo"              =>  $this->getUser()->getAttribute('codigo')
                );
    
                $resp = Tb026SolicitudPeer::setSolicitud($tb026_solicitudForm, $con);
    
                if ($resp["success"] == true) {
                    $co_solicitud = $resp["co_solicitud"];
                } else {
                    $this->data = json_encode(array(
                        "success" => false,
                        "msg" =>  $resp["msg"]
                    ));
    
                    return;
                }



                $tb066_transferencia_cuenta = new Tb066TransferenciaCuenta();
                $tb066_transferencia_cuenta->setCoUsuario($this->getUser()->getAttribute('codigo'))->setCoSolicitud($co_solicitud);
            } else {
                $tb066_transferencia_cuenta = Tb066TransferenciaCuentaPeer::retrieveByPK($co_transferencia_cuenta);
            }

            $tb066_transferencia_cuenta->setCoBancoCredito($co_banco_creditar)
                ->setCoBancoDebito($co_banco_debitar)
                ->setCoCuentaBancariaCredito($co_cuenta_bancaria_creditar)
                ->setCoCuentaBancariaDebito($co_cuenta_bancaria_debitar)
                ->setCoCuentaContableCredito($co_cuenta_creditar)
                ->setCoCuentaContableDebito($co_cuenta_debitar)
                ->setMoDebito($mo_debitar)
                ->setCoEstado(1)
                ->setCoTipoRetencion($co_tipo_retencion == NULL ? NULL : $co_tipo_retencion)
                ->save($con);
            
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb066_transferencia_cuenta->getCoSolicitud()));
            
            $tb011_cuenta_bancaria_debito = Tb011CuentaBancariaPeer::retrieveByPK($co_cuenta_bancaria_debitar);
            $tb011_cuenta_bancaria_credito = Tb011CuentaBancariaPeer::retrieveByPK($co_cuenta_bancaria_creditar);
            
                $tb061_asiento_contable = new Tb061AsientoContable();
                $tb061_asiento_contable->setCoCuentaContable($tb011_cuenta_bancaria_debito->getCoCuentaContable())
                    ->setMoHaber($mo_debitar)
                    ->setCoTipoAsiento(7)
                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                    ->setCoRuta($ruta->getCoRuta())
                    ->setCoSolicitud($tb066_transferencia_cuenta->getCoSolicitud())
                    ->save($con);

                if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                    $FeMovimiento = $this->getUser()->getAttribute('fe_cierre');
                } else {
                    $FeMovimiento = date("Y-m-d");
                }

                $tb061_asiento_contable = new Tb061AsientoContable();
                $tb061_asiento_contable->setCoCuentaContable($tb011_cuenta_bancaria_credito->getCoCuentaContable())
                    ->setMoDebe($mo_debitar)
                    ->setCoTipoAsiento(7)
                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                    ->setCoRuta($ruta->getCoRuta())
                    ->setCoSolicitud($tb066_transferencia_cuenta->getCoSolicitud())
                    ->save($con);
                
                
//                if ($tb066_transferencia_cuenta->getCoTipoRetencion() != '' || $tb066_transferencia_cuenta->getCoTipoRetencion() != null) {
//                    $co_tipo_retencion = Tb041TipoRetencionPeer::retrieveByPK($tb066_transferencia_cuenta->getCoTipoRetencion());
//
//                    $tb061_asiento_contable = new Tb061AsientoContable();
//                    $tb061_asiento_contable->setCoCuentaContable($co_tipo_retencion->getCoCuentaContable())
//                        ->setMoDebe($mo_debitar)
//                        ->setCoTipoAsiento(14)
//                        ->setCoUsuario($this->getUser()->getAttribute('codigo'))
//                        ->setCoRuta($ruta->getCoRuta())
//                        ->setCoSolicitud($tb066_transferencia_cuenta->getCoSolicitud())
//                        ->save($con);
//
//                    $tb061_asiento_contable = new Tb061AsientoContable();
//                    $tb061_asiento_contable->setCoCuentaContable($co_tipo_retencion->getCoCuentaTercero())
//                        ->setMoHaber($mo_debitar)
//                        ->setCoTipoAsiento(14)
//                        ->setCoUsuario($this->getUser()->getAttribute('codigo'))
//                        ->setCoRuta($ruta->getCoRuta())
//                        ->setCoSolicitud($tb066_transferencia_cuenta->getCoSolicitud())
//                        ->save($con);
//                }




//                $CuentaDebitar->setMoDisponible($CuentaDebitar->getMoDisponible() - $mo_debitar)->save($con);
//                $CuentaCreditar->setMoDisponible($CuentaCreditar->getMoDisponible() + $mo_debitar)->save($con);

                $tb011_transferencia_debito = Tb011CuentaBancariaPeer::retrieveByPk($tb066_transferencia_cuenta->getCoCuentaBancariaDebito());

                if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                    $nu_transaccion =  date("Ym", strtotime($this->getUser()->getAttribute('fe_cierre'))) . '-' . $tb066_transferencia_cuenta->getCoTransferenciaCuenta();
                } else {
                    $nu_transaccion = date("Ym") . '-' . $tb066_transferencia_cuenta->getCoTransferenciaCuenta();
                }

                $tb155_cuenta_bancaria_historico = new Tb155CuentaBancariaHistorico();
                $tb155_cuenta_bancaria_historico->setInActivo(true);
                $tb155_cuenta_bancaria_historico->setIdTb011CuentaBancaria($tb066_transferencia_cuenta->getCoCuentaBancariaDebito());
                $tb155_cuenta_bancaria_historico->setMoTransaccion($tb066_transferencia_cuenta->getMoDebito());
                $tb155_cuenta_bancaria_historico->setFeTransaccion($tb066_transferencia_cuenta->getCreatedAt('Y-m-d'));
                $tb155_cuenta_bancaria_historico->setDeObservacion('Transferencia entre Cuentas: solicitud Nº:' . $tb066_transferencia_cuenta->getCoSolicitud());
                $tb155_cuenta_bancaria_historico->setIdTb010Banco($tb066_transferencia_cuenta->getCoBancoDebito());
                $tb155_cuenta_bancaria_historico->setIdTb154TipoCuentaMovimiento(3);
                $tb155_cuenta_bancaria_historico->setIdTb153TipoDocumentoCuenta(3);
                $tb155_cuenta_bancaria_historico->setIdTb156SubtipoDocumento(1);
                $tb155_cuenta_bancaria_historico->setMoSaldoNuevo($tb011_transferencia_debito->getMoDisponible() - $mo_debitar);
                $tb155_cuenta_bancaria_historico->setMoSaldoAnterior($tb011_transferencia_debito->getMoDisponible());
                $tb155_cuenta_bancaria_historico->setNuTransaccion('OT-' . $nu_transaccion);
                $tb155_cuenta_bancaria_historico->setCoSolicitud($tb066_transferencia_cuenta->getCoSolicitud());
                $tb155_cuenta_bancaria_historico->save($con);


                $tb011_transferencia_debito->setMoDisponible($tb011_transferencia_debito->getMoDisponible() - $mo_debitar);
                $tb011_transferencia_debito->save($con);

                $tb011_transferencia_credito = Tb011CuentaBancariaPeer::retrieveByPk($tb066_transferencia_cuenta->getCoCuentaBancariaCredito());

                $tb155_cuenta_bancaria_historico_credito = new Tb155CuentaBancariaHistorico();
                $tb155_cuenta_bancaria_historico_credito->setInActivo(true);
                $tb155_cuenta_bancaria_historico_credito->setIdTb011CuentaBancaria($tb066_transferencia_cuenta->getCoCuentaBancariaCredito());
                $tb155_cuenta_bancaria_historico_credito->setMoTransaccion($tb066_transferencia_cuenta->getMoDebito());
                $tb155_cuenta_bancaria_historico_credito->setFeTransaccion($tb066_transferencia_cuenta->getCreatedAt('Y-m-d'));
                $tb155_cuenta_bancaria_historico_credito->setDeObservacion('Transferencia entre Cuentas: solicitud Nº:' . $tb066_transferencia_cuenta->getCoSolicitud());
                $tb155_cuenta_bancaria_historico_credito->setIdTb010Banco($tb066_transferencia_cuenta->getCoBancoCredito());
                $tb155_cuenta_bancaria_historico_credito->setIdTb154TipoCuentaMovimiento(6);
                $tb155_cuenta_bancaria_historico_credito->setIdTb153TipoDocumentoCuenta(2);
                $tb155_cuenta_bancaria_historico_credito->setIdTb156SubtipoDocumento(1);
                $tb155_cuenta_bancaria_historico_credito->setMoSaldoNuevo($tb011_transferencia_credito->getMoDisponible() + $mo_debitar);
                $tb155_cuenta_bancaria_historico_credito->setMoSaldoAnterior($tb011_transferencia_credito->getMoDisponible());
                $tb155_cuenta_bancaria_historico_credito->setNuTransaccion('OT-' . $nu_transaccion);
                $tb155_cuenta_bancaria_historico_credito->setCoSolicitud($tb066_transferencia_cuenta->getCoSolicitud());
                $tb155_cuenta_bancaria_historico_credito->save($con);

                $tb011_transferencia_credito->setMoDisponible($tb011_transferencia_credito->getMoDisponible() + $mo_debitar);
                $tb011_transferencia_credito->save($con);            


            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
            $con->commit();

            $ruta->setInCargarDato(true)->save($con);
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

            $con->commit();

            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Modificación realizada exitosamente'
            ));
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }
    }

    public function executeCargarDisponible(sfWebRequest $request)
    {

        $id  =  $this->getRequestParameter("id");

        $c = new Criteria();
        $c->addSelectColumn(Tb011CuentaBancariaPeer::MO_DISPONIBLE);
        $c->addSelectColumn(Tb024CuentaContablePeer::NU_CUENTA_CONTABLE);
        $c->addSelectColumn(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE);
        $c->addJoin(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Tb011CuentaBancariaPeer::CO_CUENTA_CONTABLE);
        $c->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA, $id);
        $stmt = Tb024CuentaContablePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
            "success"   =>  true,
            "data"      =>  $campos
        ));

        $this->setTemplate('storelista');
    }

    public function executeStorelistaCuentaBancaria(sfWebRequest $request)
    {
        $paginar        =   $this->getRequestParameter("paginar");
        $limit          =   $this->getRequestParameter("limit", 15);
        $start          =   $this->getRequestParameter("start", 0);
        $tx_cuenta      =   $this->getRequestParameter("tx_cuenta");
        $tx_descripcion =   $this->getRequestParameter("tx_descripcion");
        $co_cuenta_contable_creditar = $this->getRequestParameter("co_cuenta_contable_creditar");
        $co_cuenta_contable_debitar = $this->getRequestParameter("co_cuenta_contable_debitar");

        $c = new Criteria();

        if ($tx_cuenta != '')
            $c->add(Tb024CuentaContablePeer::NU_CUENTA_CONTABLE, '%' . $tx_cuenta . '%', Criteria::ILIKE);

        if ($tx_descripcion != '')
            $c->add(Tb024CuentaContablePeer::TX_DESCRIPCION, '%' . $tx_descripcion . '%', Criteria::ILIKE);

        if ($co_cuenta_contable_creditar != '')
            $c->add(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, $co_cuenta_contable_creditar, Criteria::NOT_EQUAL);

        if ($co_cuenta_contable_debitar != '')
            $c->add(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, $co_cuenta_contable_debitar, Criteria::NOT_EQUAL);


        $c->clearSelectColumns();
        $c->addSelectColumn(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE);
        $c->addSelectColumn(Tb024CuentaContablePeer::TX_DESCRIPCION);
        $c->addSelectColumn(Tb024CuentaContablePeer::NU_CUENTA_CONTABLE);
        $c->addSelectColumn(Tb024CuentaContablePeer::TX_CUENTA);
        $c->addSelectColumn(Tb010BancoPeer::TX_BANCO);
        $c->addSelectColumn(Tb010BancoPeer::CO_BANCO);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::MO_DISPONIBLE);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::IN_FONDO_TERCERO);

        //$c->addJoin(Tb100BancoLibroPeer::ID, Tb103LibroDetallePeer::ID_TB100_BANCO_LIBRO);
        //    $c->addJoin(Tb100BancoLibroPeer::ID_TB011_CUENTA_BANCARIA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addJoin(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Tb011CuentaBancariaPeer::CO_CUENTA_CONTABLE);
        $c->addJoin(Tb010BancoPeer::CO_BANCO, Tb011CuentaBancariaPeer::CO_BANCO);
        //$c->add(Tb103LibroDetallePeer::IN_ACTIVO,true);

        $cantidadTotal = Tb024CuentaContablePeer::doCount($c);

        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE);

        $stmt = Tb024CuentaContablePeer::doSelectStmt($c);
        $registros = "";
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res["mo_saldo"] = $res["mo_disponible"];
            $registros[] = $res;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));

        $this->setTemplate('storelista');
    }

    public function executeStorefkcotiporetencion(sfWebRequest $request)
    {


        $c = new Criteria();
        $c->clearSelectColumns();
        $c->add(Tb041TipoRetencionPeer::IN_ACTIVO, true);
        //    $c->addSelectColumn(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE);
        //    $c->addSelectColumn(Tb024CuentaContablePeer::TX_DESCRIPCION);
        //    $c->addJoin(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Tb041TipoRetencionPeer::CO_CUENTA_CONTABLE);
        $c->addAscendingOrderByColumn(Tb041TipoRetencionPeer::CO_TIPO_RETENCION);

        $stmt = Tb041TipoRetencionPeer::doSelectStmt($c);
        $registros = "";
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $res;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));

        $this->setTemplate('storelista');
    }

    public function executeStorelista(sfWebRequest $request)
    {

        $limit         =   $this->getRequestParameter("limit", 15);
        $start         =   $this->getRequestParameter("start", 0);
        $in_ventanilla =   $this->getRequestParameter("in_ventanilla");
        $co_proceso    =   $this->getRequestParameter("co_proceso");
        $co_solicitud  =   $this->getRequestParameter("co_solicitud");

        $co_documento     =   $this->getRequestParameter("co_documento");
        $nu_cedula_rif    =   $this->getRequestParameter("nu_cedula_rif");
        $tx_razon_social  =   $this->getRequestParameter("tx_razon_social");

        $c = new Criteria();
        $c->clearSelectColumns();

        if ($co_documento != '') {
            $c->add(Tb007DocumentoPeer::CO_DOCUMENTO, $co_documento);
        }

        if ($nu_cedula_rif != '') {
            $c->add(Tb008ProveedorPeer::TX_RIF, $nu_cedula_rif);
        }

        if ($tx_razon_social != '') {
            $c->add(Tb008ProveedorPeer::TX_RAZON_SOCIAL, '%' . $tx_razon_social . '%', Criteria::LIKE);
        }




        if ($co_solicitud != '') {
            $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $co_solicitud);
        }

        if ($in_ventanilla == 'true') {
            $c->add(Tb030RutaPeer::NU_ORDEN, 1);
        } else {
            $c->add(Tb030RutaPeer::NU_ORDEN, 1,  Criteria::GREATER_THAN);

            if ($co_proceso != '') {
                $c->add(Tb028ProcesoPeer::CO_PROCESO, $co_proceso);
            } else {

                $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));


                $c->addAnd(Tb030RutaPeer::CO_PROCESO, $registro_proceso, Criteria::IN);
            }
        }


        $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));
        $registro_tramite = Tb006TipoSolicitudUsuarioPeer::getListaTramiteAsignado($this->getUser()->getAttribute('codigo'));


        $c->setIgnoreCase(true);
        $c->addSelectColumn(Tb030RutaPeer::CO_PROCESO);
        $c->addSelectColumn(Tb030RutaPeer::CO_RUTA);
        $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);     
        $c->addSelectColumn(Tb026SolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb001UsuarioPeer::TX_LOGIN);
        $c->addSelectColumn(Tb026SolicitudPeer::FE_REGISTRO);
        $c->addSelectColumn(Tb026SolicitudPeer::CO_PERSONA);

        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::CO_TRANSFERENCIA_CUENTA);
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::CO_CUENTA_BANCARIA_CREDITO);
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::CO_CUENTA_BANCARIA_DEBITO);
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::CO_BANCO_DEBITO);
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::CO_BANCO_CREDITO);
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::MO_DEBITO);
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::CO_CUENTA_CONTABLE_CREDITO);
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::CO_CUENTA_CONTABLE_DEBITO);
        $c->addSelectColumn(Tb066TransferenciaCuentaPeer::CREATED_AT);
        
        $c->addSelectColumn(Tb030RutaPeer::TX_RUTA_REPORTE);
        

        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD,  Criteria::JOIN);
        $c->addJoin(Tb030RutaPeer::CO_PROCESO, Tb028ProcesoPeer::CO_PROCESO,   Criteria::JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO,  Criteria::JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb066TransferenciaCuentaPeer::CO_SOLICITUD);

        $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, array(18),Criteria::IN);
        $c->addAnd(Tb030RutaPeer::CO_PROCESO, $registro_proceso, Criteria::IN);

        $c->addAnd(Tb030RutaPeer::IN_ANULAR, NULL, Criteria::ISNULL);
        $c->addAnd(Tb026SolicitudPeer::CO_ESTATUS, array(1, 2), Criteria::IN);
        $c->addAnd(Tb030RutaPeer::CO_ESTATUS_RUTA, 1);
        $c->addAnd(Tb030RutaPeer::IN_ACTUAL, true);
        $c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));

        $cantidadTotal = Tb026SolicitudPeer::doCount($c);

        $c->setLimit($limit)->setOffset($start);
        $c->addDescendingOrderByColumn(Tb026SolicitudPeer::CO_SOLICITUD);

        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $registros = array();
        $encrip = new myConfig();
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $cantidad = Tb026SolicitudPeer::getCantRevision($res["co_solicitud"]);

            list($anio, $mes, $dia) = explode('-', $res["created_at"]);

            list($anio, $mes, $dia) = explode('-', $res["fe_registro"]);
            $registros[] = array(
                "tx_proceso"                    => trim($res["tx_proceso"]),
                "fecha_creacion"                => $dia.'/'.$mes.'/'.$anio,
                "co_proceso"                    => trim($res["co_proceso"]),
                "tx_tipo_solicitud"             => trim($res["tx_tipo_solicitud"]),
                "co_tipo_solicitud"             => trim($res["co_tipo_solicitud"]),
                "co_solicitud"                  => trim($res["co_solicitud"]),
                "tx_login"                      => trim($res["tx_login"]),
                "tx_serial"                     => Tb060OrdenPagoPeer::getODP($res["co_solicitud"]),
                "in_reporte"                    => ($res["tx_ruta_reporte"] == null) ? '' : $res["co_ruta"],
                "co_ruta"                       => $encrip->encrypt($res["co_ruta"]),
                "cant_revision"                 => $cantidad,
                "co_cuenta_contable_debito"     => Tb024CuentaContablePeer::retrieveByPK($res["co_cuenta_contable_debito"])->getNuCuentaContable(),
                "co_cuenta_bancaria_debito"     => Tb011CuentaBancariaPeer::retrieveByPK($res["co_cuenta_bancaria_debito"])->getTxCuentaBancaria(),
                "co_banco_debito"               => Tb010BancoPeer::retrieveByPK($res["co_banco_debito"])->getTxBanco(),
                "mo_debito"                     => $res["mo_debito"],
                "co_cuenta_contable_credito"    =>Tb024CuentaContablePeer::retrieveByPK($res["co_cuenta_contable_credito"])->getNuCuentaContable(),
                "co_cuenta_bancaria_credito"    =>Tb011CuentaBancariaPeer::retrieveByPK($res["co_cuenta_bancaria_credito"])->getTxCuentaBancaria(),
                "co_banco_credito"              =>Tb010BancoPeer::retrieveByPK($res["co_banco_credito"])->getTxBanco(),
            );
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));
    }
}
