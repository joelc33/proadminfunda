<?php

/**
 * Presupuesto actions.
 *
 * @package    gobel
 * @subpackage Presupuesto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class PresupuestoActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeMateriales(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb007DocumentoPeer::TIPO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_INICIO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_FIN);
        $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);
        $c->addSelectColumn(Tb038RamoPeer::TX_RAMO);
        $c->addSelectColumn(Tb038RamoPeer::CO_RAMO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::MONTO);
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addAsColumn('nu_iva_retencion', Tb044IvaRetencionPeer::NU_VALOR);
        $c->addSelectColumn(Tb082EjecutorPeer::NU_EJECUTOR);
        $c->addSelectColumn(Tb082EjecutorPeer::DE_EJECUTOR);
        //$c->addJoin(Tb052ComprasPeer::CO_EJECUTOR, Tb082EjecutorPeer::ID);
        $c->addJoin(Tb044IvaRetencionPeer::CO_IVA_RETENCION, Tb008ProveedorPeer::CO_IVA_RETENCION);
        $c->addJoin(Tb056ContratoComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
        $c->addJoin(Tb052ComprasPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
        $c->addJoin(Tb056ContratoComprasPeer::CO_RAMO, Tb038RamoPeer::CO_RAMO, Criteria::LEFT_JOIN);
        $c->addJoin(Tb052ComprasPeer::CO_EJECUTOR, Tb082EjecutorPeer::ID, Criteria::LEFT_JOIN);
        $c->add(Tb052ComprasPeer::IN_ANULAR, NULL, Criteria::ISNULL);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);


        //echo $c->toString(); exit();

        $stmt = Tb056ContratoComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
            "de_ejecutor"           => $campos["nu_ejecutor"] . '-' . strtoupper($campos["de_ejecutor"]),
            "de_proyecto_ac"        => $campos["nu_proyecto_ac"] . '-' . strtoupper($campos["de_proyecto_ac"]),
            "de_accion_especifica"  => $campos["nu_accion_especifica"] . '-' . strtoupper($campos["de_accion_especifica"]),
            "co_accion_especifica"  => $campos["co_accion_especifica"],
            "co_proveedor"          => $campos["co_proveedor"],
            "nu_iva_retencion"      => $campos["nu_iva_retencion"],
            "co_compras"            => $campos["co_compras"],
            "co_solicitud"          => $this->getRequestParameter("co_solicitud"),
            "co_documento"          => $campos["co_documento"],
            "co_ramo"               => $campos["co_ramo"],
            "tx_razon_social"       => $campos["tx_razon_social"],
            "tx_rif"                => $campos["tx_rif"],
            "tipo"                  => $campos["tipo"],
            "tx_direccion"          => $campos["tx_direccion"],
            "fe_inicio"             => $campos["fecha_inicio"],
            "fe_fin"                => $campos["fecha_fin"],
            "tx_ramo"               => $campos["tx_ramo"],
            "monto"                 => $campos["monto"],
            "nu_iva"                 => $campos["nu_iva"]
        ));
    }

    public function executeStorelistaodp(sfWebRequest $request)
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

        /*if ($in_ventanilla == 'true') {
            $c->add(Tb030RutaPeer::NU_ORDEN, 1);
        } else {
            $c->add(Tb030RutaPeer::NU_ORDEN, 1,  Criteria::GREATER_THAN);

            if ($co_proceso != '') {
                $c->add(Tb028ProcesoPeer::CO_PROCESO, $co_proceso);
            } else {

                $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));


                $c->addAnd(Tb030RutaPeer::CO_PROCESO, $registro_proceso, Criteria::IN);
            }
        }*/


        $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));
        $registro_tramite = Tb006TipoSolicitudUsuarioPeer::getListaTramiteAsignado($this->getUser()->getAttribute('codigo'));


        $c->setIgnoreCase(true);
        $c->addSelectColumn(Tb030RutaPeer::CO_PROCESO);
        $c->addSelectColumn(Tb030RutaPeer::CO_RUTA);
        $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
        $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb001UsuarioPeer::TX_LOGIN);
        $c->addSelectColumn(Tb026SolicitudPeer::FE_REGISTRO);
        $c->addSelectColumn(Tb026SolicitudPeer::CO_PERSONA);
        //  $c->addSelectColumn(Tb060OrdenPagoPeer::TX_SERIAL);
        $c->addSelectColumn(Tb052ComprasPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_TOTAL);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb030RutaPeer::TX_RUTA_REPORTE);
        

        // $c->addJoin(Tb026SolicitudPeer::CO_PERSONA, Tb109PersonaPeer::CO_PERSONA,   Criteria::LEFT_JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR,   Criteria::LEFT_JOIN);
        $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO,  Tb007DocumentoPeer::CO_DOCUMENTO,   Criteria::LEFT_JOIN);
        // $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb060OrdenPagoPeer::CO_SOLICITUD,   Criteria::LEFT_JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD,  Criteria::JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD,  Criteria::JOIN);
        $c->addJoin(Tb030RutaPeer::CO_PROCESO, Tb028ProcesoPeer::CO_PROCESO,   Criteria::JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO,  Criteria::JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD,  Criteria::LEFT_JOIN);

       
        $c->addAnd(Tb030RutaPeer::CO_PROCESO, 10);

        $c->addAnd(Tb030RutaPeer::IN_ANULAR, NULL, Criteria::ISNULL);
        $c->addAnd(Tb026SolicitudPeer::CO_ESTATUS, array(1, 2), Criteria::IN);
        $c->addAnd(Tb030RutaPeer::CO_ESTATUS_RUTA, 1);
        $c->addAnd(Tb030RutaPeer::IN_ACTUAL, true);
        $c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));


      //  echo $c->toString(); exit();

        $cantidadTotal = Tb026SolicitudPeer::doCount($c);

        $c->setLimit($limit)->setOffset($start);
        $c->addDescendingOrderByColumn(Tb026SolicitudPeer::CO_SOLICITUD);

        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $registros = array();
        $encrip = new myConfig();
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $cantidad = Tb026SolicitudPeer::getCantRevision($res["co_solicitud"]);

            $tx_rif = $res["inicial"] . "-" . $res["tx_rif"];
            $tx_razon_social = strtoupper($res["tx_razon_social"]);


            list($anio, $mes, $dia) = explode('-', $res["fe_registro"]);
            $registros[] = array(
                "tx_proceso"        => trim($res["tx_proceso"]),
                "tx_concepto"       => strtoupper(trim($res["tx_concepto"])),
                "co_proceso"        => trim($res["co_proceso"]),
                "tx_tipo_solicitud" => trim($res["tx_tipo_solicitud"]),
                "co_tipo_solicitud" => trim($res["co_tipo_solicitud"]),
                "co_solicitud"      => trim($res["co_solicitud"]),
                "tx_login"          => trim($res["tx_login"]),
                "tx_serial"         => Tb060OrdenPagoPeer::getODP($res["co_solicitud"]),
                "in_reporte"        => ($res["tx_ruta_reporte"] == null) ? '' : $res["co_ruta"],
                "co_ruta"           => $encrip->encrypt($res["co_ruta"]),
                "tx_rif"            => $tx_rif,
                "tx_razon_social"   => $tx_razon_social,
                "fe_creacion"       => $dia . '-' . $mes . '-' . $anio,
                "cant_revision"     => $cantidad
            );
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));

        $this->setTemplate('storelista');
    }

    public function executeListaOdp(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "co_rol"            => $this->getUser()->getAttribute('rol'),
            "co_usuario"        => $this->getUser()->getAttribute('codigo'),
            "in_activo"         => $this->getUser()->getAttribute('in_activo'),
            "tx_tipo_solicitud" => $this->getRequestParameter("tx_tipo_solicitud"),
            "co_tipo_solicitud" => 1,
            "tx_url"            => $this->getRequestParameter("tx_url"),

        ));

        $this->getRequest()->setAttribute('in_activo', $this->getUser()->getAttribute('in_activo'));
    }



    public function executeVerResumen(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "co_compras"  => $this->getRequestParameter("co_compras")
        ));
    }

    public function executeGenerarODP(sfWebRequest $request)
    {

        $co_solicitud = $this->getRequestParameter("co_solicitud");
        $tx_concepto = $this->getRequestParameter("tx_concepto");


        $con = Propel::getConnection();
        try {
            $con->beginTransaction();

            $co_odp = Tb060OrdenPagoPeer::generarODP($co_solicitud, $con, $this->getUser()->getAttribute('ejercicio'));

            echo "odp=".$co_odp; exit();

            $wherec = new Criteria();
            $wherec->add(Tb046FacturaRetencionPeer::CO_SOLICITUD, $co_solicitud);

            $updc = new Criteria();
            $updc->add(Tb046FacturaRetencionPeer::CO_ODP, $co_odp);

            BasePeer::doUpdate($wherec, $updc, $con);

            $wherec = new Criteria();
            $wherec->add(Tb045FacturaPeer::CO_SOLICITUD, $co_solicitud);

            $updc = new Criteria();
            $updc->add(Tb045FacturaPeer::CO_ODP, $co_odp);

            BasePeer::doUpdate($wherec, $updc, $con);

            $tb060_orden_pago = Tb060OrdenPagoPeer::retrieveByPK($co_odp);

            $tb060_orden_pago->setTxConcepto($tx_concepto);
            $tb060_orden_pago->save();

            $con->commit();

            //$co_odp = Tb060OrdenPagoPeer::generarODP($co_solicitud,$con,$this->getUser()->getAttribute('ejercicio'));


            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
            $ruta->setInCargarDato(true)->setCoEstatusRuta(2)->setCoUsuario($this->getUser()->getAttribute('codigo'))->save();
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());


            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Modificación realizada exitosamente'
            ));
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  "Ocurri un error al Generar la Orden de Pago"
            ));
        }
    }

    public function executeGenerarODPGenerico(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("co_solicitud");

        $con = Propel::getConnection();
        try {
            $con->beginTransaction();

            $c = new Criteria();
            $c->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
            $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);

            $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);

            while ($campos = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $datos_presupuesto = $this->getVerificaPresupuesto($campos["co_presupuesto"]);


                //                if($datos_presupuesto["mo_disponible"]<$campos["monto"]){
                //                    
                //                    $con->rollback();
                //                    $this->data = json_encode(array(
                //                        "success" => false,
                //                        "msg" =>  "La partida ".$datos_presupuesto["nu_partida"]."-".$datos_presupuesto["de_partida"]." no cuenta con fondo suficiente"
                //                    ));
                //                    
                //                    echo $this->data;
                //                    return sfView::NONE;
                //                    
                //                }

                $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                $tb087_presupuesto_movimiento->setCoPartida($campos["co_presupuesto"])
                    ->setCoTipoMovimiento(2)
                    ->setNuMonto($campos["monto"])
                    //->setNuAnio(date('Y'))
                    ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                    ->setCoDetalleCompra($campos["co_detalle_compras"])
                    ->setInActivo(true)
                    ->save($con);
            }


            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($codigo));
            $ruta->setInCargarDato(true)->save($con);
            $co_odp = Tb060OrdenPagoPeer::generarODP($codigo, $con, $this->getUser()->getAttribute('ejercicio'));
            $con->commit();

            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

            $this->data = json_encode(array(
                "success" => true,
                "msg"     => 'Orden de Pago Generada Exitosamente!',
                "co_odp"  => $co_odp
            ));
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage() . '-' . $i
            ));
        }

        echo $this->data;
        return sfView::NONE;
    }

    protected function getVerificaPresupuesto($co_presupuesto)
    {
        $c = new Criteria();
        $c->add(Tb085PresupuestoPeer::ID, $co_presupuesto);
        $c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
        //$c->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);
        $c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
    }

    public function executeGenerarODPServicio(sfWebRequest $request)
    {

        $co_solicitud = $this->getRequestParameter("co_solicitud");
        $tx_concepto = $this->getRequestParameter("tx_concepto");

        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
        $con = Propel::getConnection();
        $co_odp = Tb060OrdenPagoPeer::generarODP($co_solicitud, $con, $this->getUser()->getAttribute('ejercicio'));
        $con->commit();

        $wherec = new Criteria();
        $wherec->add(Tb045FacturaPeer::CO_SOLICITUD, $co_solicitud);

        $updc = new Criteria();
        $updc->add(Tb045FacturaPeer::CO_ODP, $co_odp);

        BasePeer::doUpdate($wherec, $updc, $con);


        $c = new Criteria();
        $c->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $co_solicitud);

        $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);

        while ($campos = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
            $tb087_presupuesto_movimiento->setCoPartida($campos["co_presupuesto"])
                ->setCoTipoMovimiento(2)
                ->setNuMonto($campos["monto"])
                //->setNuAnio(date('Y'))
                ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                ->setCoDetalleCompra($campos["co_detalle_compras"])
                ->setInActivo(true)
                ->save($con);
        }


        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
        $ruta->setInCargarDato(true)->save($con);
        $co_odp = Tb060OrdenPagoPeer::generarODP($co_solicitud, $con, $this->getUser()->getAttribute('ejercicio'));

        $tb060_orden_pago = Tb060OrdenPagoPeer::retrieveByPK($co_odp);
        $tb060_orden_pago->setCoTipoOdp(1);
        $tb060_orden_pago->setTxConcepto($tx_concepto);
        $tb060_orden_pago->save();


        $con->commit();

        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

        $this->data = json_encode(array(
            "success" => true,
            "msg" => 'Modificación realizada exitosamente'
        ));


        $this->setTemplate('generarODP');
    }

    public function executeOdpDirecto(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addSelectColumn(Tb052ComprasPeer::FECHA_COMPRA);
        $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_IVA);
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_SUB_TOTAL);
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_TOTAL);
        $c->addSelectColumn(Tb052ComprasPeer::NUMERO_COMPRA);
        $c->addSelectColumn(Tb045FacturaPeer::NU_TOTAL);
        $c->addSelectColumn(Tb045FacturaPeer::NU_TOTAL_RETENCION);
        $c->addSelectColumn(Tb045FacturaPeer::TOTAL_PAGAR);
        $c->addSelectColumn(Tb052ComprasPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tb052ComprasPeer::TX_OBSERVACION);
        $c->addSelectColumn(Tb030RutaPeer::CO_RUTA);
                
        $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);

       // $c->addAsColumn('nu_iva_retencion', Tb044IvaRetencionPeer::NU_VALOR);
        $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD, Tb026SolicitudPeer::CO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb045FacturaPeer::CO_COMPRA, Criteria::LEFT_JOIN);        
        $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
        $c->addJoin(Tb030RutaPeer::CO_SOLICITUD,Tb026SolicitudPeer::CO_SOLICITUD);
        $c->add(Tb030RutaPeer::CO_ESTATUS_RUTA,1);
        /******JOEL MODIFICACION VALUACION***/

       // $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb045FacturaPeer::CO_COMPRA,Criteria::LEFT_JOIN);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);

        /************************************/

        // $c->add(Tb052ComprasPeer::CO_SOLICITUD,$codigo);        

        $stmt = Tb052ComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $c1 = new Criteria();
        $c1->clearSelectColumns();
        $c1->addSelectColumn(Tb060OrdenPagoPeer::TX_CONCEPTO);
        $c1->add(Tb060OrdenPagoPeer::IN_ANULAR, NULL, Criteria::ISNULL);
        $c1->add(Tb060OrdenPagoPeer::CO_SOLICITUD, $codigo);

        $stmt1 = Tb052ComprasPeer::doSelectStmt($c1);
        $campos1 = $stmt1->fetch(PDO::FETCH_ASSOC);

        list($anio,$mes,$dia) = explode("-",$campos["fecha_compra"]);

        $encrip = new myConfig();

        $this->data = json_encode(array(
            "co_proveedor"          => $campos["co_proveedor"],
            "co_ruta"               => $encrip->encrypt($campos["co_ruta"]),
            "nu_iva_retencion"      => $campos["nu_iva_retencion"],
            "co_compras"            => $campos["co_compras"],
            "co_solicitud"          => $this->getRequestParameter("co_solicitud"),
            "co_documento"          => $campos["co_documento"],
            "co_ramo"               => $campos["co_ramo"],
            "tx_razon_social"       => $campos["tx_razon_social"],
            "tx_rif"                => $campos["tx_rif"],
            "tipo"                  => $campos["inicial"],
            "tipo_solicitud"        => $campos["tx_tipo_solicitud"],
            "tx_direccion"          => $campos["tx_direccion"],
            "fecha"                 => $dia.'/'.$mes.'/'.$anio,
            "fe_fin"                => $campos["fecha_fin"],
            "tx_ramo"               => $campos["tx_ramo"],
            "monto"                 => ($campos["nu_total"]==null)?$campos["monto_total"]:$campos["nu_total"],
            "monto_retenciones"     => $campos["nu_total_retencion"],
            "total_pagar"           => ($campos["total_pagar"]==null)?$campos["monto_total"]:$campos["total_pagar"],
            "nu_iva"                => $campos["nu_iva"],
            "co_tipo_odp"           => $this->getCoTipoOdp($codigo),
            "tx_concepto"           => $campos1["tx_concepto"],
            "numero_compra"         => $campos["numero_compra"],
            "tx_observacion"         => ($campos["tx_concepto"]==null)?($campos["tx_observacion"]!=null)?$campos["tx_observacion"]:'':$campos["tx_concepto"],
        ));
    }

    public function executeOdp(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb007DocumentoPeer::TIPO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_INICIO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_FIN);
        $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);
        $c->addSelectColumn(Tb038RamoPeer::TX_RAMO);
        $c->addSelectColumn(Tb038RamoPeer::CO_RAMO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::MONTO);
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addAsColumn('nu_iva_retencion', Tb044IvaRetencionPeer::NU_VALOR);

        $c->addJoin(Tb044IvaRetencionPeer::CO_IVA_RETENCION, Tb008ProveedorPeer::CO_IVA_RETENCION);
        //$c->addJoin(Tb056ContratoComprasPeer::CO_RAMO, Tb038RamoPeer::CO_RAMO);
        $c->addJoin(Tb056ContratoComprasPeer::CO_RAMO, Tb038RamoPeer::CO_RAMO, Criteria::LEFT_JOIN);
        $c->addJoin(Tb056ContratoComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
        $c->addJoin(Tb052ComprasPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
        /******JOEL MODIFICACION VALUACION***/

        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb045FacturaPeer::CO_COMPRA);
        $c->add(Tb045FacturaPeer::CO_SOLICITUD, $codigo);

        /************************************/

        // $c->add(Tb052ComprasPeer::CO_SOLICITUD,$codigo);        

        $stmt = Tb056ContratoComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $c1 = new Criteria();
        $c1->clearSelectColumns();
        $c1->addSelectColumn(Tb060OrdenPagoPeer::TX_CONCEPTO);
        $c1->add(Tb060OrdenPagoPeer::IN_ANULAR, NULL, Criteria::ISNULL);
        $c1->add(Tb060OrdenPagoPeer::CO_SOLICITUD, $codigo);

        $stmt1 = Tb056ContratoComprasPeer::doSelectStmt($c1);
        $campos1 = $stmt1->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
            "co_proveedor"          => $campos["co_proveedor"],
            "nu_iva_retencion"      => $campos["nu_iva_retencion"],
            "co_compras"            => $campos["co_compras"],
            "co_solicitud"          => $this->getRequestParameter("co_solicitud"),
            "co_documento"          => $campos["co_documento"],
            "co_ramo"               => $campos["co_ramo"],
            "tx_razon_social"       => $campos["tx_razon_social"],
            "tx_rif"                => $campos["tx_rif"],
            "tipo"                  => $campos["tipo"],
            "tx_direccion"          => $campos["tx_direccion"],
            "fe_inicio"             => $campos["fecha_inicio"],
            "fe_fin"                => $campos["fecha_fin"],
            "tx_ramo"               => $campos["tx_ramo"],
            "monto"                 => $campos["monto"],
            "nu_iva"                => $campos["nu_iva"],
            "co_tipo_odp"           => $this->getCoTipoOdp($codigo),
            "tx_concepto"           => $campos1["tx_concepto"]
            //        "nu_orden_pago"         => $this->getNuOrdenPago($this->getRequestParameter("co_solicitud"))
        ));
    }


    public function executeOdpAyuda(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_TOTAL);
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addSelectColumn(Tb052ComprasPeer::TX_OBSERVACION);
        $c->addSelectColumn(Tb060OrdenPagoPeer::CO_ORDEN_PAGO);

        $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD, Tb026SolicitudPeer::CO_SOLICITUD);
        $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb060OrdenPagoPeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb052ComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $c2 = new Criteria();
        $c2->clearSelectColumns();
        $c2->addSelectColumn(Tb045FacturaPeer::TX_CONCEPTO);
        $c2->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        $c2->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);

        $c2->addJoin(Tb048ProductoPeer::CO_PRODUCTO, Tb045FacturaPeer::ID_TB048_PRODUCTO);
        $c2->add(Tb045FacturaPeer::CO_SOLICITUD, $codigo);

        $stmt2 = Tb045FacturaPeer::doSelectStmt($c2);
        $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
            "co_proveedor"          => $campos["co_proveedor"],
            "nu_iva_retencion"      => $campos["nu_iva_retencion"],
            "co_compras"            => $campos["co_compras"],
            "co_solicitud"          => $this->getRequestParameter("co_solicitud"),
            "co_documento"          => $campos["co_documento"],
            "co_ramo"               => $campos["co_ramo"],
            "tx_razon_social"       => $campos["tx_razon_social"],
            "tx_rif"                => $campos["tx_rif"],
            "tipo"                  => $campos["inicial"],
            "tx_direccion"          => $campos["tx_direccion"],
            "fe_inicio"             => $campos["fecha_inicio"],
            "fe_fin"                => $campos["fecha_fin"],
            "tx_ramo"               => $campos["tx_ramo"],
            "monto"                 => $campos["monto_total"],
            "tx_observacion"        => $campos["tx_observacion"],
            "tx_concepto"           => $campos2["tx_concepto"],
            "cod_producto"          => $campos2["cod_producto"],
            "tx_producto"           => $campos2["tx_producto"],
            "co_orden_pago"         => ($campos["co_orden_pago"] == null) ? '' : $campos["co_orden_pago"],
            "co_tipo_odp"           => $this->getCoTipoOdp($codigo)
            //        "nu_orden_pago"         => $this->getNuOrdenPago($this->getRequestParameter("co_solicitud"))
        ));
    }

    protected function getCoTipoOdp($codigo)
    {

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb060OrdenPagoPeer::CO_TIPO_ODP);
        $c->add(Tb060OrdenPagoPeer::IN_ANULAR, NULL, Criteria::ISNULL);
        $c->add(Tb060OrdenPagoPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb060OrdenPagoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos["co_tipo_odp"];
    }


    public function executeOdpServicioBasico(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_TOTAL);
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addSelectColumn(Tb052ComprasPeer::TX_OBSERVACION);

        $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD, Tb026SolicitudPeer::CO_SOLICITUD);
        $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
        $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD, Tb060OrdenPagoPeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb052ComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $c2 = new Criteria();
        $c2->clearSelectColumns();
        $c2->addSelectColumn(Tb045FacturaPeer::TX_CONCEPTO);
        $c2->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        $c2->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);

        $c2->addJoin(Tb048ProductoPeer::CO_PRODUCTO, Tb045FacturaPeer::ID_TB048_PRODUCTO);
        $c2->add(Tb045FacturaPeer::CO_SOLICITUD, $codigo);

        $stmt2 = Tb045FacturaPeer::doSelectStmt($c2);
        $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);




        $this->data = json_encode(array(
            "co_proveedor"          => $campos["co_proveedor"],
            "nu_iva_retencion"      => $campos["nu_iva_retencion"],
            "co_compras"            => $campos["co_compras"],
            "co_solicitud"          => $this->getRequestParameter("co_solicitud"),
            "co_documento"          => $campos["co_documento"],
            "co_ramo"               => $campos["co_ramo"],
            "tx_razon_social"       => $campos["tx_razon_social"],
            "tx_rif"                => $campos["tx_rif"],
            "tipo"                  => $campos["inicial"],
            "tx_direccion"          => $campos["tx_direccion"],
            "fe_inicio"             => $campos["fecha_inicio"],
            "fe_fin"                => $campos["fecha_fin"],
            "tx_ramo"               => $campos["tx_ramo"],
            "monto"                 => $campos["monto_total"],
            "tx_observacion"        => $campos["tx_observacion"],
            "tx_concepto"           => $campos2["tx_concepto"],
            "cod_producto"          => $campos2["cod_producto"],
            "tx_producto"           => $campos2["tx_producto"],
            "co_tipo_odp"           => $this->getCoTipoOdp($codigo)
            //        "nu_orden_pago"         => $this->getNuOrdenPago($this->getRequestParameter("co_solicitud"))
        ));
    }

    public function executeServiciosBasicos(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");
        if ($codigo != '' || $codigo != null) {
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb135PagoServicioPeer::CO_PAGO_SERVICIO);
            $c->addSelectColumn(Tb135PagoServicioPeer::CO_SOLICITUD);
            $c->addSelectColumn(Tb135PagoServicioPeer::CO_TIPO_SERVICIO);
            $c->addSelectColumn(Tb135PagoServicioPeer::NU_FACTURA);
            $c->addSelectColumn(Tb135PagoServicioPeer::NU_CONTROL);
            $c->addSelectColumn(Tb135PagoServicioPeer::MO_FACTURA);
            $c->addSelectColumn(Tb135PagoServicioPeer::FE_DESDE);
            $c->addSelectColumn(Tb135PagoServicioPeer::FE_HASTA);
            $c->addSelectColumn(Tb135PagoServicioPeer::TX_OBSERVACION);
            $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
            $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
            $c->addJoin(Tb135PagoServicioPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR, Criteria::LEFT_JOIN);
            $c->add(Tb135PagoServicioPeer::CO_SOLICITUD, $codigo);



            $stmt = Tb135PagoServicioPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->data = json_encode(array(
                "co_pago_servicio"     => $campos["co_pago_servicio"],
                "co_solicitud"         => $codigo,
                "co_tipo_servicio"     => $campos["co_tipo_servicio"],
                "nu_factura"           => $campos["nu_factura"],
                "nu_control"           => $campos["nu_control"],
                "mo_factura"           => $campos["mo_factura"],
                "fe_desde"             => $campos["fe_desde"],
                "fe_hasta"             => $campos["fe_hasta"],
                "tx_observacion"       => $campos["tx_observacion"],
                "co_proveedor"         => $campos["co_proveedor"],
                "co_documento"         => $campos["co_documento"],
                "tx_razon_social"      => $campos["tx_razon_social"],
                "tx_rif"               => $campos["tx_rif"],
                "tx_direccion"         => $campos["tx_direccion"]
            ));
        } else {
            $this->data = json_encode(array(
                "co_pago_servicio"     => "",
                "co_solicitud"         => "",
                "co_tipo_servicio"     => "",
                "nu_factura"           => "",
                "nu_control"           => "",
                "mo_factura"           => "",
                "fe_desde"             => "",
                "fe_hasta"             => "",
                "tx_observacion"       => "",
                "co_proveedor"         => "",
                "co_documento"         => "",
                "tx_razon_social"      => "",
                "tx_rif"               => "",
                "tx_direccion"         => ""
            ));
        }
    }

    public function executeOdpGenerico(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "co_tipo_odp"        => $this->getCoTipoOdp($this->getRequestParameter("co_solicitud")),
            "co_solicitud"       => $this->getRequestParameter("co_solicitud")
        ));
    }


    public function executeNominaodp(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");
        if ($codigo != '' || $codigo != null) {
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb122PagoNominaPeer::CO_PAGO_NOMINA);
            $c->addSelectColumn(Tb122PagoNominaPeer::CO_TIPO_TRABAJADOR);
            $c->addSelectColumn(Tb122PagoNominaPeer::CO_TIPO_NOMINA);
            $c->addSelectColumn(Tb122PagoNominaPeer::TX_CONCEPTO);
            $c->addSelectColumn(Tb122PagoNominaPeer::FE_PAGO);
            $c->addSelectColumn(Tb122PagoNominaPeer::CO_SOLICITUD);
            $c->addSelectColumn(Tb122PagoNominaPeer::CO_USUARIO);
            $c->addSelectColumn(Tb122PagoNominaPeer::CREATED_AT);
            $c->addSelectColumn(Tb122PagoNominaPeer::CO_EJECUTOR);
            $c->addSelectColumn(Tb060OrdenPagoPeer::CO_ORDEN_PAGO);
            $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
            $c->addJoin(Tb122PagoNominaPeer::CO_SOLICITUD, Tb060OrdenPagoPeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
            $c->addJoin(Tb122PagoNominaPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD);
            $c->add(Tb122PagoNominaPeer::CO_SOLICITUD, $codigo);

            $stmt = Tb122PagoNominaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->data = json_encode(array(
                "co_pago_nomina"     => $campos["co_pago_nomina"],
                "co_tipo_trabajador" => $campos["co_tipo_trabajador"],
                "co_tipo_nomina"     => $campos["co_tipo_nomina"],
                "tx_concepto"        => $campos["tx_concepto"],
                "fe_pago"            => $campos["fe_pago"],
                "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                "co_usuario"         => $campos["co_usuario"],
                "created_at"         => $campos["created_at"],
                "co_ejecutor"        => $campos["co_ejecutor"],
                "co_odp"             => $campos["co_orden_pago"],
                "co_compras"         => $campos["co_compras"],
                "co_tipo_odp"        => $this->getCoTipoOdp($codigo)

            ));
        } else {
            $this->data = json_encode(array(
                "co_pago_nomina"     => "",
                "co_tipo_trabajador" => "",
                "co_tipo_nomina"     => "",
                "tx_concepto"        => "",
                "fe_pago"            => "",
                "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                "co_usuario"         => "",
                "created_at"         => "",
                "co_ejecutor"   => ""
            ));
        }
    }

    public function executeAsignarPartidaGenerico(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $datos_compra           = $this->getCoCompras($codigo);
        $campos["co_compras"]   = $datos_compra["co_compras"];
        $campos["co_solicitud"] = $codigo;

        $datos_detalle          = $this->getDetallesCompra($campos["co_compras"]);
        $campos["co_partida"]   = $datos_detalle["co_partida"];

        $this->data = json_encode($campos);
    }

    public function executeAsignarPartidaViatico(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb108ViaticoPeer::CO_VIATICO);
        $c->addSelectColumn(Tb107TipoViaticoPeer::TX_TIPO_VIATICO);
        $c->addSelectColumn(Tb108ViaticoPeer::TX_EVENTO);
        $c->addSelectColumn(Tb108ViaticoPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb108ViaticoPeer::FE_DESDE);
        $c->addSelectColumn(Tb108ViaticoPeer::FE_HASTA);
        $c->addSelectColumn(Tb108ViaticoPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb108ViaticoPeer::CO_ORIGEN);
        $c->addSelectColumn(Tb108ViaticoPeer::CO_DESTINO);
        $c->addSelectColumn(Tb109PersonaPeer::CO_DOCUMENTO);

        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb110CargoPeer::TX_CARGO);
        $c->addSelectColumn(Tb109PersonaPeer::NU_CELULAR);
        $c->addSelectColumn(Tb052ComprasPeer::CO_EJECUTOR);

        $c->addJoin(Tb108ViaticoPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD);
        $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addJoin(Tb107TipoViaticoPeer::CO_TIPO_VIATICO,  Tb108ViaticoPeer::CO_TIPO_VIATICO);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR,  Tb108ViaticoPeer::CO_PROVEEDOR);
        $c->addJoin(Tb109PersonaPeer::CO_CARGO, Tb110CargoPeer::CO_CARGO);
        $c->add(Tb108ViaticoPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb108ViaticoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $campos["tx_origen"]  = $this->getOrigenDestino($campos["co_origen"]);
        $campos["tx_destino"] = $this->getOrigenDestino($campos["co_destino"]);
        $campos["fe_desde"]   = date('d-m-Y', strtotime($campos["fe_desde"]));
        $campos["fe_hasta"]   = date('d-m-Y', strtotime($campos["fe_hasta"]));
        $campos["nu_cedula"]  = $campos["inicial"] . '-' . $campos["tx_rif"];
        $campos["nb_persona"] = $campos["tx_razon_social"];
        $datos_compra         = $this->getCoCompras($codigo);
        $campos["co_compras"] = $datos_compra["co_compras"];

        $datos_detalle = $this->getDetallesCompra($campos["co_compras"]);
        $campos["co_partida"] = $datos_detalle["co_partida"];

        $this->data = json_encode($campos);
    }

    public function executeAsignarPartidaAyuda(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_SOLICITUD_AYUDA);
        $c->addSelectColumn(Tb127TipoAyudaPeer::TX_TIPO_AYUDA);
        $c->addSelectColumn(Tb109PersonaPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb109PersonaPeer::NU_CELULAR);

        $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR,  Tb126SolicitudAyudaPeer::CO_PROVEEDOR);
        $c->addJoin(Tb127TipoAyudaPeer::CO_TIPO_AYUDA, Tb126SolicitudAyudaPeer::CO_TIPO_AYUDA);
        $c->add(Tb126SolicitudAyudaPeer::CO_SOLICITUD, $codigo);


        $stmt = Tb108ViaticoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);


        $campos["nu_cedula"]  = $campos["inicial"] . '-' . $campos["tx_rif"];
        $campos["nb_persona"] = $campos["tx_razon_social"];

        $datos_compra          = $this->getCoCompras($codigo);
        $campos["co_compras"]  = $datos_compra["co_compras"];
        $campos["co_ejecutor"] = $datos_compra["co_ejecutor"];

        $datos_detalle = $this->getDetallesCompra($campos["co_compras"]);
        $campos["co_partida"] = $datos_detalle["co_partida"];
        $campos["detalle"]    = $datos_detalle["detalle"];
        $campos["co_solicitud"]    = $codigo;

        $this->data = json_encode($campos);
    }

    public function executeAsignarPartidaServicio(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb045FacturaPeer::CO_SOLICITUD);
        //        $c->addSelectColumn(Tb045FacturaPeer::ID_TB048_PRODUCTO);
        //        $c->addSelectColumn(Tb045FacturaPeer::TX_CONCEPTO);
        //        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        //        $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_NUM_CELULAR);

        $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR,  Tb045FacturaPeer::CO_PROVEEDOR);
        //$c->addJoin(Tb048ProductoPeer::CO_PRODUCTO, Tb045FacturaPeer::ID_TB048_PRODUCTO);
        $c->add(Tb045FacturaPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb045FacturaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);


        $campos["nu_cedula"]  = $campos["inicial"] . '-' . $campos["tx_rif"];
        $campos["nb_persona"] = $campos["tx_razon_social"];
        $campos["tx_num_celular"] = $campos["tx_num_celular"];
        $campos["tx_producto"] = $campos["tx_producto"];
        $campos["tx_concepto"] = $campos["tx_concepto"];
        $campos["co_producto"] = $campos["id_tb048_producto"];

        $datos_compra          = $this->getCoCompras($codigo);
        $campos["co_compras"]  = $datos_compra["co_compras"];
        $campos["co_ejecutor"] = $datos_compra["co_ejecutor"];

        $datos_detalle = $this->getDetallesCompra($campos["co_compras"]);
        $campos["co_partida"] = $datos_detalle["co_partida"];
        $campos["detalle"]    = $datos_detalle["detalle"];

        $this->data = json_encode($campos);
    }

    public function executeAsignarPartidaPb(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb206CotizacionPeer::NU_IVA);
        $c->addSelectColumn(Tb206CotizacionPeer::TX_SERIAL_COTIZACION);
        $c->addSelectColumn(Tb206CotizacionPeer::TX_OBSERVACION);
        $c->addSelectColumn(Tb206CotizacionPeer::MONTO_SUB_TOTAL);
        $c->addSelectColumn(Tb206CotizacionPeer::MONTO_IVA);
        $c->addSelectColumn(Tb206CotizacionPeer::MONTO_TOTAL);
        $c->addSelectColumn(Tb206CotizacionPeer::CO_COTIZACION);

        $c->add(Tb206CotizacionPeer::CO_SOLICITUD, $codigo);

        //echo "query= ".$c->toString(); exit();

        $stmt = Tb056ContratoComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
            "nu_iva"                   => $campos["nu_iva"],
            "tx_serial_cotizacion"     => $campos["tx_serial_cotizacion"],
            "tx_observacion"           => $campos["tx_observacion"],
            "monto_sub_total"          => $campos["monto_sub_total"],
            "co_solicitud"             => $this->getRequestParameter("co_solicitud"),
            "monto_iva"                => $campos["monto_iva"],
            "monto_total"              => $campos["monto_total"],
            "co_cotizacion"            => $campos["co_cotizacion"]
        ));
    }

    public function executeAsignarPartida(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb007DocumentoPeer::TIPO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_INICIO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_FIN);
        $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);
        $c->addSelectColumn(Tb038RamoPeer::TX_RAMO);
        $c->addSelectColumn(Tb038RamoPeer::CO_RAMO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::MONTO);
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addAsColumn('nu_iva_retencion', Tb044IvaRetencionPeer::NU_VALOR);
        $c->addSelectColumn(Tb052ComprasPeer::CO_EJECUTOR);
        $c->addSelectColumn(Tb056ContratoComprasPeer::CO_FUENTE_FINANCIAMIENTO);


        $c->addJoin(Tb044IvaRetencionPeer::CO_IVA_RETENCION, Tb008ProveedorPeer::CO_IVA_RETENCION);
        //$c->addJoin(Tb056ContratoComprasPeer::CO_RAMO, Tb038RamoPeer::CO_RAMO);
        $c->addJoin(Tb056ContratoComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
        $c->addJoin(Tb052ComprasPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
        $c->addJoin(Tb056ContratoComprasPeer::CO_RAMO, Tb038RamoPeer::CO_RAMO, Criteria::LEFT_JOIN);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);

        //echo "query= ".$c->toString(); exit();

        $stmt = Tb056ContratoComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
            "co_ejecutor"              => ($campos["co_ejecutor"] == null) ? '' : $campos["co_ejecutor"],
            "co_proveedor"             => $campos["co_proveedor"],
            "nu_iva_retencion"         => $campos["nu_iva_retencion"],
            "co_compras"               => $campos["co_compras"],
            "co_solicitud"             => $this->getRequestParameter("co_solicitud"),
            "co_documento"             => $campos["co_documento"],
            "co_ramo"                  => $campos["co_ramo"],
            "tx_razon_social"          => $campos["tx_razon_social"],
            "tx_rif"                   => $campos["tx_rif"],
            "tipo"                     => $campos["tipo"],
            "tx_direccion"             => $campos["tx_direccion"],
            "fe_inicio"                => $campos["fecha_inicio"],
            "fe_fin"                   => $campos["fecha_fin"],
            "tx_ramo"                  => $campos["tx_ramo"],
            "monto"                    => $campos["monto"],
            "nu_iva"                   => $campos["nu_iva"],
            "co_fuente_financiamiento" => $campos["co_fuente_financiamiento"]
        ));
    }

    public function executeReintegro(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $this->data = json_encode(array(
            "co_solicitud"             => $this->getRequestParameter("co_solicitud")
        ));
    }


    public function executeAgregarReintegro(sfWebRequest $request)
    {

        $this->data = json_encode(array(
            "co_solicitud"   => $this->getRequestParameter("co_solicitud")
        ));
    }

    public function executeNominaComprometer(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addSelectColumn(Tb082EjecutorPeer::ID);
        $c->addSelectColumn(Tb082EjecutorPeer::NU_EJECUTOR);
        $c->addSelectColumn(Tb082EjecutorPeer::DE_EJECUTOR);
        $c->addJoin(Tb122PagoNominaPeer::CO_EJECUTOR, Tb082EjecutorPeer::ID);
        $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD, Tb122PagoNominaPeer::CO_SOLICITUD);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);
        $stmt = Tb052ComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
            "co_ejecutor"           => $campos["id"],
            "de_ejecutor"           => $campos["nu_ejecutor"] . '-' . strtoupper($campos["de_ejecutor"]),
            "co_compras"            => $campos["co_compras"],
            "co_solicitud"          => $this->getRequestParameter("co_solicitud")
        ));
    }

    public function executeComprometerGenerico(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addSelectColumn(Tb082EjecutorPeer::ID);
        $c->addSelectColumn(Tb082EjecutorPeer::NU_EJECUTOR);
        $c->addSelectColumn(Tb082EjecutorPeer::DE_EJECUTOR);
        $c->addJoin(Tb052ComprasPeer::CO_EJECUTOR, Tb082EjecutorPeer::ID);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);
        $stmt = Tb052ComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
            "co_ejecutor"           => $campos["id"],
            "de_ejecutor"           => $campos["nu_ejecutor"] . '-' . strtoupper($campos["de_ejecutor"]),
            "co_compras"            => $campos["co_compras"],
            "co_solicitud"          => $this->getRequestParameter("co_solicitud")
        ));
    }

    public function executeComprometerSinCambio(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addSelectColumn(Tb082EjecutorPeer::ID);
        $c->addSelectColumn(Tb082EjecutorPeer::NU_EJECUTOR);
        $c->addSelectColumn(Tb082EjecutorPeer::DE_EJECUTOR);
        $c->addJoin(Tb052ComprasPeer::CO_EJECUTOR, Tb082EjecutorPeer::ID, Criteria::LEFT_JOIN);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);
        $stmt = Tb052ComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
            "co_ejecutor"           => $campos["id"],
            "de_ejecutor"           => $campos["nu_ejecutor"] . '-' . strtoupper($campos["de_ejecutor"]),
            "co_compras"            => $campos["co_compras"],
            "co_solicitud"          => $this->getRequestParameter("co_solicitud")
        ));
    }

    protected function getOrigenDestino($codigo)
    {
        $c = new Criteria();
        $c->add(Tb110OrigenViaticoPeer::CO_ORIGEN_VIATICO, $codigo);

        $stmt = Tb110OrigenViaticoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos["tx_origen_viatico"];
    }


    protected function getDetallesCompra($co_compra)
    {
        $cd = new Criteria();
        $cd->add(Tb053DetalleComprasPeer::CO_COMPRAS, $co_compra);
        $stmt = Tb053DetalleComprasPeer::doSelectStmt($cd);
        $datos_detalle = $stmt->fetch(PDO::FETCH_ASSOC);

        return $datos_detalle;
    }

    protected function getCoCompras($codigo)
    {
        $c = new Criteria();
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);
        $stmt = Tb052ComprasPeer::doSelectStmt($c);
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function executeAyudaComprometer(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_SOLICITUD_AYUDA);
        $c->addSelectColumn(Tb127TipoAyudaPeer::TX_TIPO_AYUDA);
        $c->addSelectColumn(Tb109PersonaPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb109PersonaPeer::NU_CELULAR);

        $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR,  Tb126SolicitudAyudaPeer::CO_PROVEEDOR);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb109PersonaPeer::CO_PROVEEDOR);
        $c->addJoin(Tb127TipoAyudaPeer::CO_TIPO_AYUDA, Tb126SolicitudAyudaPeer::CO_TIPO_AYUDA);
        $c->add(Tb126SolicitudAyudaPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb108ViaticoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $campos["nu_cedula"]  = $campos["inicial"] . '-' . $campos["tx_rif"];
        $campos["nb_persona"] = $campos["tx_razon_social"];

        $datos_compra          = $this->getCoCompras($codigo);
        $campos["co_compras"]  = $datos_compra["co_compras"];
        $campos["co_ejecutor"] = $datos_compra["co_ejecutor"];

        $datos_detalle = $this->getDetallesCompra($campos["co_compras"]);
        $campos["co_partida"] = $datos_detalle["co_partida"];
        $campos["detalle"]    = $datos_detalle["detalle"];
        $campos["co_solicitud"]    = $codigo;

        $this->data = json_encode($campos);
    }

    public function executeServicioBasicoComprometer(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb045FacturaPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb045FacturaPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tb109PersonaPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        //            $c->addSelectColumn(Tb045FacturaPeer::TX_CONCEPTO);
        //            $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        //            $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
        //                
        //            $c->addJoin(Tb048ProductoPeer::CO_PRODUCTO, Tb045FacturaPeer::ID_TB048_PRODUCTO);
        $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR,  Tb045FacturaPeer::CO_PROVEEDOR);
        $c->add(Tb045FacturaPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb045FacturaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $campos["nu_cedula"]  = $campos["inicial"] . '-' . $campos["tx_rif"];
        $campos["nb_persona"] = $campos["tx_razon_social"];

        $datos_compra          = $this->getCoCompras($codigo);
        $campos["co_compras"]  = $datos_compra["co_compras"];
        $campos["co_ejecutor"] = $datos_compra["co_ejecutor"];

        $datos_detalle = $this->getDetallesCompra($campos["co_compras"]);
        $campos["co_partida"] = $datos_detalle["co_partida"];
        $campos["detalle"]    = $datos_detalle["detalle"];

        $this->data = json_encode($campos);
    }

    public function executeAyudaCausar(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_SOLICITUD_AYUDA);
        $c->addSelectColumn(Tb127TipoAyudaPeer::TX_TIPO_AYUDA);
        $c->addSelectColumn(Tb109PersonaPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb109PersonaPeer::NU_CELULAR);

        $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR,  Tb126SolicitudAyudaPeer::CO_PROVEEDOR);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb109PersonaPeer::CO_PROVEEDOR);
        $c->addJoin(Tb127TipoAyudaPeer::CO_TIPO_AYUDA, Tb126SolicitudAyudaPeer::CO_TIPO_AYUDA);
        $c->add(Tb126SolicitudAyudaPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb108ViaticoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $campos["nu_cedula"]  = $campos["inicial"] . '-' . $campos["tx_rif"];
        $campos["nb_persona"] = $campos["tx_razon_social"];

        $datos_compra          = $this->getCoCompras($codigo);
        $campos["co_compras"]  = $datos_compra["co_compras"];
        $campos["co_ejecutor"] = $datos_compra["co_ejecutor"];

        $datos_detalle = $this->getDetallesCompra($campos["co_compras"]);
        $campos["co_partida"] = $datos_detalle["co_partida"];
        $campos["detalle"]    = $datos_detalle["detalle"];

        $this->data = json_encode($campos);
    }

    public function executeServicioBasicoCausar(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb045FacturaPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb045FacturaPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tb109PersonaPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        //          $c->addSelectColumn(Tb045FacturaPeer::TX_CONCEPTO);
        //          $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        //          $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);

        //          $c->addJoin(Tb048ProductoPeer::CO_PRODUCTO, Tb045FacturaPeer::ID_TB048_PRODUCTO);
        $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR,  Tb045FacturaPeer::CO_PROVEEDOR);
        $c->add(Tb045FacturaPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb045FacturaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $campos["nu_cedula"]  = $campos["inicial"] . '-' . $campos["tx_rif"];
        $campos["nb_persona"] = $campos["tx_razon_social"];

        $datos_compra          = $this->getCoCompras($codigo);
        $campos["co_compras"]  = $datos_compra["co_compras"];
        $campos["co_ejecutor"] = $datos_compra["co_ejecutor"];

        $datos_detalle = $this->getDetallesCompra($campos["co_compras"]);
        $campos["co_partida"] = $datos_detalle["co_partida"];
        $campos["detalle"]    = $datos_detalle["detalle"];

        $this->data = json_encode($campos);
    }

    public function executeViaticoComprometer(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb108ViaticoPeer::CO_VIATICO);
        $c->addSelectColumn(Tb107TipoViaticoPeer::TX_TIPO_VIATICO);
        $c->addSelectColumn(Tb108ViaticoPeer::TX_EVENTO);
        $c->addSelectColumn(Tb108ViaticoPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb108ViaticoPeer::FE_DESDE);
        $c->addSelectColumn(Tb108ViaticoPeer::FE_HASTA);
        $c->addSelectColumn(Tb108ViaticoPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb108ViaticoPeer::CO_ORIGEN);
        $c->addSelectColumn(Tb108ViaticoPeer::CO_DESTINO);
        $c->addSelectColumn(Tb109PersonaPeer::CO_DOCUMENTO);

        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb110CargoPeer::TX_CARGO);
        $c->addSelectColumn(Tb109PersonaPeer::NU_CELULAR);

        $c->addJoin(Tb108ViaticoPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD);
        $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addJoin(Tb107TipoViaticoPeer::CO_TIPO_VIATICO,  Tb108ViaticoPeer::CO_TIPO_VIATICO);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR,  Tb108ViaticoPeer::CO_PROVEEDOR);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb109PersonaPeer::CO_PROVEEDOR);
        $c->addJoin(Tb109PersonaPeer::CO_CARGO, Tb110CargoPeer::CO_CARGO);
        $c->add(Tb108ViaticoPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb108ViaticoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $campos["tx_origen"]  = $this->getOrigenDestino($campos["co_origen"]);
        $campos["tx_destino"] = $this->getOrigenDestino($campos["co_destino"]);
        $campos["fe_desde"]   = date('d-m-Y', strtotime($campos["fe_desde"]));
        $campos["fe_hasta"]   = date('d-m-Y', strtotime($campos["fe_hasta"]));
        $campos["nu_cedula"]  = $campos["inicial"] . '-' . $campos["tx_rif"];
        $campos["nb_persona"] = $campos["tx_razon_social"];
        $datos_compra         = $this->getCoCompras($codigo);
        $campos["co_compras"] = $datos_compra["co_compras"];

        $datos_detalle = $this->getDetallesCompra($campos["co_compras"]);
        $campos["co_partida"] = $datos_detalle["co_partida"];

        $this->data = json_encode($campos);
    }

    public function executeViaticoCausar(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb108ViaticoPeer::CO_VIATICO);
        $c->addSelectColumn(Tb107TipoViaticoPeer::TX_TIPO_VIATICO);
        $c->addSelectColumn(Tb108ViaticoPeer::TX_EVENTO);
        $c->addSelectColumn(Tb108ViaticoPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb108ViaticoPeer::FE_DESDE);
        $c->addSelectColumn(Tb108ViaticoPeer::FE_HASTA);
        $c->addSelectColumn(Tb108ViaticoPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb108ViaticoPeer::CO_ORIGEN);
        $c->addSelectColumn(Tb108ViaticoPeer::CO_DESTINO);
        $c->addSelectColumn(Tb109PersonaPeer::CO_DOCUMENTO);

        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        //    $c->addSelectColumn(Tb110CargoPeer::TX_CARGO);
        $c->addSelectColumn(Tb109PersonaPeer::NU_CELULAR);

        $c->addJoin(Tb108ViaticoPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD);
        $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addJoin(Tb107TipoViaticoPeer::CO_TIPO_VIATICO,  Tb108ViaticoPeer::CO_TIPO_VIATICO);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR,  Tb108ViaticoPeer::CO_PROVEEDOR);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb109PersonaPeer::CO_PROVEEDOR);
        //$c->addJoin(Tb109PersonaPeer::CO_CARGO, Tb110CargoPeer::CO_CARGO);
        $c->add(Tb108ViaticoPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb108ViaticoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $campos["tx_origen"]  = $this->getOrigenDestino($campos["co_origen"]);
        $campos["tx_destino"] = $this->getOrigenDestino($campos["co_destino"]);
        $campos["fe_desde"]   = date('d-m-Y', strtotime($campos["fe_desde"]));
        $campos["fe_hasta"]   = date('d-m-Y', strtotime($campos["fe_hasta"]));
        $campos["nu_cedula"]  = $campos["inicial"] . '-' . $campos["nu_cedula"];
        $campos["nb_persona"] = $campos["nb_persona"] . ' ' . $campos["ap_persona"];
        $datos_compra         = $this->getCoCompras($codigo);
        $campos["co_compras"] = $datos_compra["co_compras"];

        $datos_detalle = $this->getDetallesCompra($campos["co_compras"]);
        $campos["co_partida"] = $datos_detalle["co_partida"];

        $this->data = json_encode($campos);
    }

    public function executeEditarOdp(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb108ViaticoPeer::CO_VIATICO);
        $c->addSelectColumn(Tb107TipoViaticoPeer::TX_TIPO_VIATICO);
        $c->addSelectColumn(Tb109PersonaPeer::CO_DOCUMENTO);

        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        //    $c->addSelectColumn(Tb110CargoPeer::TX_CARGO);
        $c->addSelectColumn(Tb109PersonaPeer::NU_CELULAR);

        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD);
        $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addJoin(Tb107TipoViaticoPeer::CO_TIPO_VIATICO,  Tb108ViaticoPeer::CO_TIPO_VIATICO);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR,  Tb026SolicitudPeer::CO_PROVEEDOR);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb109PersonaPeer::CO_PROVEEDOR);
        //$c->addJoin(Tb109PersonaPeer::CO_CARGO, Tb110CargoPeer::CO_CARGO);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb052ComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $campos["nu_cedula"]  = $campos["inicial"] . '-' . $campos["nu_cedula"];
        $campos["nb_persona"] = $campos["nb_persona"] . ' ' . $campos["ap_persona"];
        $datos_compra         = $this->getCoCompras($codigo);
        $campos["co_compras"] = $datos_compra["co_compras"];

        $datos_detalle = $this->getDetallesCompra($campos["co_compras"]);
        $campos["co_partida"] = $datos_detalle["co_partida"];

        $this->data = json_encode($campos);
    }

    public function executeNominaCausar(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addSelectColumn(Tb082EjecutorPeer::NU_EJECUTOR);
        $c->addSelectColumn(Tb082EjecutorPeer::DE_EJECUTOR);
        $c->addJoin(Tb122PagoNominaPeer::CO_EJECUTOR, Tb082EjecutorPeer::ID);
        $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD, Tb122PagoNominaPeer::CO_SOLICITUD);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb056ContratoComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
            "de_ejecutor"           => $campos["nu_ejecutor"] . '-' . strtoupper($campos["de_ejecutor"]),
            "de_proyecto_ac"        => $campos["nu_proyecto_ac"] . '-' . strtoupper($campos["de_proyecto_ac"]),
            "de_accion_especifica"  => $campos["nu_accion_especifica"] . '-' . strtoupper($campos["de_accion_especifica"]),
            "co_accion_especifica"  => $campos["co_accion_especifica"],
            "co_compras"            => $campos["co_compras"],
            "co_solicitud"          => $this->getRequestParameter("co_solicitud"),
            "tx_concepto"           => 'PAGO DE NOMINA'
        ));
    }



    public function executeCausar(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb007DocumentoPeer::TIPO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_INICIO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_FIN);
        $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);
        $c->addSelectColumn(Tb038RamoPeer::TX_RAMO);
        $c->addSelectColumn(Tb038RamoPeer::CO_RAMO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::MONTO);
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addAsColumn('nu_iva_retencion', Tb044IvaRetencionPeer::NU_VALOR);
        $c->addSelectColumn(Tb082EjecutorPeer::NU_EJECUTOR);
        $c->addSelectColumn(Tb082EjecutorPeer::DE_EJECUTOR);

        $c->addJoin(Tb052ComprasPeer::CO_EJECUTOR, Tb082EjecutorPeer::ID);
        $c->addJoin(Tb044IvaRetencionPeer::CO_IVA_RETENCION, Tb008ProveedorPeer::CO_IVA_RETENCION);
        $c->addJoin(Tb056ContratoComprasPeer::CO_RAMO, Tb038RamoPeer::CO_RAMO);
        $c->addJoin(Tb056ContratoComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
        $c->addJoin(Tb052ComprasPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);



        $stmt = Tb056ContratoComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
            "de_ejecutor"           => $campos["nu_ejecutor"] . '-' . strtoupper($campos["de_ejecutor"]),
            "de_proyecto_ac"        => $campos["nu_proyecto_ac"] . '-' . strtoupper($campos["de_proyecto_ac"]),
            "de_accion_especifica"  => $campos["nu_accion_especifica"] . '-' . strtoupper($campos["de_accion_especifica"]),
            "co_accion_especifica"  => $campos["co_accion_especifica"],
            "co_proveedor"          => $campos["co_proveedor"],
            "nu_iva_retencion"      => $campos["nu_iva_retencion"],
            "co_compras"            => $campos["co_compras"],
            "co_solicitud"          => $this->getRequestParameter("co_solicitud"),
            "co_documento"          => $campos["co_documento"],
            "co_ramo"               => $campos["co_ramo"],
            "tx_razon_social"       => $campos["tx_razon_social"],
            "tx_rif"                => $campos["tx_rif"],
            "tipo"                  => $campos["tipo"],
            "tx_direccion"          => $campos["tx_direccion"],
            "fe_inicio"             => $campos["fecha_inicio"],
            "fe_fin"                => $campos["fecha_fin"],
            "tx_ramo"               => $campos["tx_ramo"],
            "monto"                 => $campos["monto"],
            "nu_iva"                 => $campos["nu_iva"]
        ));
    }

    protected function getCoAsiento($co_producto, $co_solicitud)
    {

        $c = new Criteria();
        $c->add(Tb061AsientoContablePeer::CO_SOLICITUD, $co_solicitud);
        $c->add(Tb061AsientoContablePeer::CO_PRODUCTO, $co_producto);
        $stmt = Tb061AsientoContablePeer::doSelectStmt($c);
        $reg = $stmt->fetch(PDO::FETCH_ASSOC);

        return $reg["co_asiento_contable"];
    }

    public function getIVARetencion($mo_iva, $codigo)
    {
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb044IvaRetencionPeer::NU_VALOR);
        $c->addJoin(Tb008ProveedorPeer::CO_IVA_RETENCION, Tb044IvaRetencionPeer::CO_IVA_RETENCION);
        $c->add(Tb008ProveedorPeer::CO_PROVEEDOR, $codigo);
        $stmt = Tb039RequisicionesPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $valor_iva = $campos['nu_valor'] / 100;

        return $mo_iva * $valor_iva;
    }


    public function getProgramatica($co_presupuesto)
    {

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb083ProyectoAcPeer::ID_TB082_EJECUTOR);
        $c->addSelectColumn(Tb084AccionEspecificaPeer::ID_TB083_PROYECTO_AC);
        $c->addSelectColumn(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA);
        $c->addJoin(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA, Tb084AccionEspecificaPeer::ID);
        $c->addJoin(Tb084AccionEspecificaPeer::ID_TB083_PROYECTO_AC, Tb083ProyectoAcPeer::ID);
        $c->addJoin(Tb083ProyectoAcPeer::ID_TB082_EJECUTOR, Tb082EjecutorPeer::ID);
        $c->add(Tb085PresupuestoPeer::ID, $co_presupuesto);
        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
    }

    public function executeGuardarCambioPb()
    {

        $co_partida                = $this->getRequestParameter('co_partida');
        $co_presupuesto            = $this->getRequestParameter('co_presupuesto');
        $co_detalle_cotizacion     = $this->getRequestParameter('co_detalle_cotizacion');
        $co_proyecto               = $this->getRequestParameter("co_proyecto");
        $co_accion                 = $this->getRequestParameter("co_accion");
        $co_cotizacion             = $this->getRequestParameter("co_cotizacion");
        $co_ejecutor               = $this->getRequestParameter("co_ejecutor");
        $co_solicitud              = $this->getRequestParameter("co_solicitud");
        $mo_disponible             = $this->getRequestParameter("monto");
        $co_fuente_financiamiento  = $this->getRequestParameter("co_fuente_financiamiento");
        $monto                     = $this->getRequestParameter("monto");


        $con = Propel::getConnection();

        try {
            $con->beginTransaction();

            $Tb207DetalleCotizacion = Tb207DetalleCotizacionPeer::retrieveByPK($co_detalle_cotizacion);

            if ($monto < $Tb207DetalleCotizacion->getMonto()) {

                $this->data = json_encode(array(
                    "success" => false,
                    "msg" =>  "El Monto Disponible de la partida es menor al monto total"
                ));
            } else {

                $programatica = $this->getProgramatica($co_presupuesto);


                if ($Tb207DetalleCotizacion->getCoPresupuesto() != '') {


                    $montod = $Tb207DetalleCotizacion->getMonto();
                    $montod = $montod * (-1);

                    $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                    $tb087_presupuesto_movimiento->setCoPartida($Tb207DetalleCotizacion->getCoPresupuesto())
                        ->setCoTipoMovimiento(4)
                        ->setNuMonto($montod)
                        //->setNuAnio(date('Y'))
                        ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                        ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                        ->setCoDetallePresuBase($co_detalle_cotizacion)
                        ->setInActivo(true)
                        ->save($con);
                }


                $Tb207DetalleCotizacion->setCoPresupuesto($co_presupuesto)
                    ->save($con);


                $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                $tb087_presupuesto_movimiento->setCoPartida($co_presupuesto)
                    ->setCoTipoMovimiento(1)
                    ->setNuMonto($Tb207DetalleCotizacion->getMonto())
                    //->setNuAnio(date('Y'))
                    ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                    ->setCoDetallePresuBase($co_detalle_cotizacion)
                    ->setInActivo(true)
                    ->save($con);


                $c = new Criteria();
                $c->clearSelectColumns();
                $c->addSelectColumn(Tb206CotizacionPeer::MONTO_IVA);
                $c->addSelectColumn(Tb207DetalleCotizacionPeer::MONTO);
                $c->addSelectColumn(Tb207DetalleCotizacionPeer::IN_CALCULAR_IVA);
                $c->addSelectColumn(Tb207DetalleCotizacionPeer::CO_PRODUCTO);
                $c->addSelectColumn(Tb206CotizacionPeer::NU_IVA);
                $c->addSelectColumn(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA);
                $c->addSelectColumn(Tb085PresupuestoPeer::NU_PA);
                $c->addSelectColumn(Tb085PresupuestoPeer::NU_GE);
                $c->addSelectColumn(Tb085PresupuestoPeer::NU_ES);
                $c->addSelectColumn(Tb085PresupuestoPeer::NU_SE);
                $c->addSelectColumn(Tb085PresupuestoPeer::CO_CUENTA_CONTABLE);

                $c->addJoin(Tb207DetalleCotizacionPeer::CO_PRESUPUESTO,  Tb085PresupuestoPeer::ID);
                $c->addJoin(Tb206CotizacionPeer::CO_COTIZACION,  Tb207DetalleCotizacionPeer::CO_COTIZACION);
                $c->add(Tb206CotizacionPeer::CO_SOLICITUD, $co_solicitud);
                $c->add(Tb207DetalleCotizacionPeer::CO_PRODUCTO, $Tb207DetalleCotizacion->getCoProducto());

                $stmt = Tb085PresupuestoPeer::doSelectStmt($c);

                while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {


                    $co_cuenta_contable = $reg["co_cuenta_contable"];

                    if ($co_cuenta_contable == '') {
                        $this->data = json_encode(array(
                            "success" => false,
                            "msg" => 'La Partida Presupuestaria seleccionada, no posee una cuenta contable asociada'
                        ));

                        $con->rollback();

                        return;
                    }
                }

                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));

                $c1 = new Criteria();
                $c1->add(Tb207DetalleCotizacionPeer::CO_COTIZACION, $co_cotizacion);
                $c1->add(Tb207DetalleCotizacionPeer::CO_PRESUPUESTO, NULL);
                $c1->add(Tb207DetalleCotizacionPeer::IN_PRESUPUESTO, TRUE);
                $cant = Tb207DetalleCotizacionPeer::doCount($c1);

                if ($cant == 0) {
                    $ruta->setInCargarDato(true)->save($con);
                }

                $con->commit();
                Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

                $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente'
                ));
                $con->commit();
            }
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }

        $this->setTemplate('guardarCambio');
    }

    public function executeGuardarCambio()
    {

        $co_partida        = $this->getRequestParameter('co_partida');
        $co_presupuesto    = $this->getRequestParameter('co_presupuesto');
        $co_detalle_compra = $this->getRequestParameter('co_detalle_compra');
        $co_proyecto       = $this->getRequestParameter("co_proyecto");
        $co_accion         = $this->getRequestParameter("co_accion");
        $co_compras        = $this->getRequestParameter("co_compras");
        $co_ejecutor       = $this->getRequestParameter("co_ejecutor");
        $co_solicitud      = $this->getRequestParameter("co_solicitud");
        $mo_disponible      = $this->getRequestParameter("monto");
        $co_fuente_financiamiento  = $this->getRequestParameter("co_fuente_financiamiento");


        $con = Propel::getConnection();

        try {
            $con->beginTransaction();

            $Tb053DetalleCompra = Tb053DetalleComprasPeer::retrieveByPK($co_detalle_compra);
            $co_partida_ant     = $Tb053DetalleCompra->getCoPartida();
            $co_presupuesto_ant     = $Tb053DetalleCompra->getCoPresupuesto();

            if ($mo_disponible < $Tb053DetalleCompra->getMonto()) {

                $this->data = json_encode(array(
                    "success" => false,
                    "msg" =>  "El Monto Disponible de la partida es menor al monto total"
                ));
            } else {

                $Tb053DetalleCompra->setCoPresupuesto($co_presupuesto)
                    ->setCoProyectoAc($co_proyecto)
                    ->setCoAccionEspecifica($co_accion)
                    ->save($con);

                Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $Tb053DetalleCompra->getCoPresupuesto(), 1, $Tb053DetalleCompra->getMonto(), '', $Tb053DetalleCompra->getCoDetalleCompras());
                Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $Tb053DetalleCompra->getCoPresupuesto(), 2, $Tb053DetalleCompra->getMonto(), '', $Tb053DetalleCompra->getCoDetalleCompras());

                $c = new Criteria();
                $c->clearSelectColumns();
                $c->addSelectColumn(Tb052ComprasPeer::MONTO_IVA);
                $c->addSelectColumn(Tb052ComprasPeer::CO_PROVEEDOR);
                $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
                $c->addSelectColumn(Tb053DetalleComprasPeer::IN_CALCULAR_IVA);
                $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRODUCTO);
                $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);
                $c->addSelectColumn(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA);
                $c->addSelectColumn(Tb085PresupuestoPeer::NU_PA);
                $c->addSelectColumn(Tb085PresupuestoPeer::NU_GE);
                $c->addSelectColumn(Tb085PresupuestoPeer::NU_ES);
                $c->addSelectColumn(Tb085PresupuestoPeer::NU_SE);

                $c->addJoin(Tb053DetalleComprasPeer::CO_PRESUPUESTO,  Tb085PresupuestoPeer::ID);
                $c->addJoin(Tb052ComprasPeer::CO_COMPRAS,  Tb053DetalleComprasPeer::CO_COMPRAS);
                $c->add(Tb052ComprasPeer::CO_SOLICITUD, $co_solicitud);
                $c->add(Tb053DetalleComprasPeer::CO_PRODUCTO, $Tb053DetalleCompra->getCoProducto());

                $stmt = Tb085PresupuestoPeer::doSelectStmt($c);

                while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {


                    $co_cuenta_contable = $this->getCuentaContable($reg["id_tb084_accion_especifica"], $reg["nu_pa"], $reg["nu_ge"], $reg["nu_es"], $reg["nu_se"]);

                    if ($co_cuenta_contable == '') {
                        $this->data = json_encode(array(
                            "success" => false,
                            "msg" => 'La Partida Presupuestaria seleccionada, no posee una cuenta contable asociada'
                        ));

                        $con->rollback();

                        return;
                    }
                }


                if ($co_compras != '') {
                    $Tb052Compras = Tb052ComprasPeer::retrieveByPK($co_compras);
                    $Tb052Compras->setCoEjecutor($co_ejecutor)
                        ->save($con);

                    if ($co_fuente_financiamiento != '') {
                        $wherec = new Criteria();
                        $wherec->add(Tb056ContratoComprasPeer::CO_COMPRAS, $co_compras);

                        $updc = new Criteria();
                        $updc->add(Tb056ContratoComprasPeer::CO_FUENTE_FINANCIAMIENTO, $co_fuente_financiamiento);

                        BasePeer::doUpdate($wherec, $updc, $con);
                    }
                }


                $Tb059CambioPartidaCompra = new Tb059CambioPartidaCompra();
                $Tb059CambioPartidaCompra->setCoPartidaActual($co_partida)
                    ->setCoPresupuestoActual($co_presupuesto)
                    ->setCoDetalleCompra($co_detalle_compra)
                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                    ->setTxMotivo($tx_motivo)
                    ->save($con);


                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($Tb052Compras->getCoSolicitud()));

                $c1 = new Criteria();
                $c1->add(Tb053DetalleComprasPeer::CO_COMPRAS, $co_compras);
                $c1->add(Tb053DetalleComprasPeer::CO_PRESUPUESTO, NULL);
                $c1->add(Tb053DetalleComprasPeer::IN_PRESUPUESTO, TRUE);
                $cant = Tb053DetalleComprasPeer::doCount($c1);

                if ($cant == 0) {
                    $ruta->setInCargarDato(true)->save($con);
                }

                $con->commit();
                Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());



                $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente'
                ));
                $con->commit();
            }
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }
    }

    public function executeGuardarCambioServicio()
    {

        $co_partida        = $this->getRequestParameter('co_partida');
        $co_presupuesto    = $this->getRequestParameter('co_presupuesto');
        $co_detalle_compra = $this->getRequestParameter('co_detalle_compra');
        $co_proyecto       = $this->getRequestParameter("co_proyecto");
        $co_accion         = $this->getRequestParameter("co_accion");
        $co_compras        = $this->getRequestParameter("co_compras");
        $co_ejecutor       = $this->getRequestParameter("co_ejecutor");
        $co_solicitud      = $this->getRequestParameter("co_solicitud");
        $mo_disponible      = $this->getRequestParameter("monto");
        $co_fuente_financiamiento  = $this->getRequestParameter("co_fuente_financiamiento");


        $con = Propel::getConnection();

        try {
            $con->beginTransaction();

            $Tb053DetalleCompra = Tb053DetalleComprasPeer::retrieveByPK($co_detalle_compra);
            $co_partida_ant     = $Tb053DetalleCompra->getCoPartida();
            $co_presupuesto_ant     = $Tb053DetalleCompra->getCoPresupuesto();

            if ($mo_disponible < $Tb053DetalleCompra->getMonto()) {

                $this->data = json_encode(array(
                    "success" => false,
                    "msg" =>  "El Monto Disponible de la partida es menor al monto total"
                ));
            } else {

                $Tb053DetalleCompra->setCoPartida($co_partida)
                    ->setCoPresupuesto($co_presupuesto)
                    ->setCoProyectoAc($co_proyecto)
                    ->setCoAccionEspecifica($co_accion)
                    ->save($con);

                $c = new Criteria();
                $c->clearSelectColumns();
                $c->addSelectColumn(Tb052ComprasPeer::MONTO_IVA);
                $c->addSelectColumn(Tb052ComprasPeer::CO_PROVEEDOR);
                $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
                $c->addSelectColumn(Tb053DetalleComprasPeer::IN_CALCULAR_IVA);
                $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRODUCTO);
                $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);
                $c->addSelectColumn(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA);
                $c->addSelectColumn(Tb085PresupuestoPeer::NU_PA);
                $c->addSelectColumn(Tb085PresupuestoPeer::NU_GE);
                $c->addSelectColumn(Tb085PresupuestoPeer::NU_ES);
                $c->addSelectColumn(Tb085PresupuestoPeer::NU_SE);

                $c->addJoin(Tb053DetalleComprasPeer::CO_PRESUPUESTO,  Tb085PresupuestoPeer::ID);
                $c->addJoin(Tb052ComprasPeer::CO_COMPRAS,  Tb053DetalleComprasPeer::CO_COMPRAS);
                $c->add(Tb052ComprasPeer::CO_SOLICITUD, $co_solicitud);
                $c->add(Tb053DetalleComprasPeer::CO_PRODUCTO, $Tb053DetalleCompra->getCoProducto());

                $stmt = Tb085PresupuestoPeer::doSelectStmt($c);

                while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {


                    $co_cuenta_contable = $this->getCuentaContable($reg["id_tb084_accion_especifica"], $reg["nu_pa"], $reg["nu_ge"], $reg["nu_es"], $reg["nu_se"]);

                    if ($co_cuenta_contable == '') {
                        $this->data = json_encode(array(
                            "success" => false,
                            "msg" => 'La Partida Presupuestaria seleccionada, no posee una cuenta contable asociada'
                        ));

                        $con->rollback();

                        return;
                    }
                }


                if ($co_compras != '') {
                    $Tb052Compras = Tb052ComprasPeer::retrieveByPK($co_compras);
                    $Tb052Compras->setCoEjecutor($co_ejecutor)
                        ->save($con);

                    if ($co_fuente_financiamiento != '') {
                        $wherec = new Criteria();
                        $wherec->add(Tb056ContratoComprasPeer::CO_COMPRAS, $co_compras);

                        $updc = new Criteria();
                        $updc->add(Tb056ContratoComprasPeer::CO_FUENTE_FINANCIAMIENTO, $co_fuente_financiamiento);

                        BasePeer::doUpdate($wherec, $updc, $con);
                    }
                }


                $Tb059CambioPartidaCompra = new Tb059CambioPartidaCompra();
                $Tb059CambioPartidaCompra->setCoPartidaAnterior($co_partida_ant)
                    ->setCoPartidaActual($co_partida)
                    ->setCoPartidaAnterior($co_partida_ant)
                    ->setCoPresupuestoActual($co_presupuesto)
                    ->setCoPresupuestoAnterior($co_presupuesto_ant)
                    ->setCoDetalleCompra($co_detalle_compra)
                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                    ->setTxMotivo($tx_motivo)
                    ->save($con);


                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($Tb052Compras->getCoSolicitud()));
                $c1 = new Criteria();
                $c1->add(Tb053DetalleComprasPeer::CO_COMPRAS, $co_compras);
                $c1->add(Tb053DetalleComprasPeer::CO_PRESUPUESTO, NULL);
                $cant = Tb053DetalleComprasPeer::doCount($c1);

                if ($cant == 0) {
                    $ruta->setInCargarDato(true)->save($con);
                }

                $con->commit();
                Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());



                $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente'
                ));
                $con->commit();
            }
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }
    }

    public function executeGuardarCambioPartida()
    {

        $co_partida        = $this->getRequestParameter('co_partida');
        $co_presupuesto    = $this->getRequestParameter('co_presupuesto');
        $co_detalle_compra = $this->getRequestParameter('co_detalle_compra');
        $co_proyecto       = $this->getRequestParameter("co_proyecto");
        $co_accion         = $this->getRequestParameter("co_accion");
        $co_ejecutor       = $this->getRequestParameter("co_ejecutor");
        $co_solicitud      = $this->getRequestParameter("co_solicitud");
        $mo_disponible      = $this->getRequestParameter("monto");
        $co_fuente_financiamiento  = $this->getRequestParameter("co_fuente_financiamiento");


        $con = Propel::getConnection();

        try {
            $con->beginTransaction();

            $Tb053DetalleCompra = Tb053DetalleComprasPeer::retrieveByPK($co_detalle_compra);
            $co_partida_ant     = $Tb053DetalleCompra->getCoPartida();
            $co_presupuesto_ant     = $Tb053DetalleCompra->getCoPresupuesto();
            $co_compras        = $Tb053DetalleCompra->getCoCompras();

            if ($mo_disponible < $Tb053DetalleCompra->getMonto()) {

                $this->data = json_encode(array(
                    "success" => false,
                    "msg" =>  "El Monto Disponible de la partida es menor al monto total"
                ));
            } else {

                $Tb053DetalleCompra->setCoPartida($co_partida)
                    ->setCoPresupuesto($co_presupuesto)
                    ->setCoProyectoAc($co_proyecto)
                    ->setCoAccionEspecifica($co_accion)
                    ->save($con);

                $c = new Criteria();
                $c->clearSelectColumns();
                $c->addSelectColumn(Tb052ComprasPeer::MONTO_IVA);
                $c->addSelectColumn(Tb052ComprasPeer::CO_PROVEEDOR);
                $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
                $c->addSelectColumn(Tb053DetalleComprasPeer::IN_CALCULAR_IVA);
                $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRODUCTO);
                $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);
                $c->addSelectColumn(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA);
                $c->addSelectColumn(Tb085PresupuestoPeer::NU_PA);
                $c->addSelectColumn(Tb085PresupuestoPeer::NU_GE);
                $c->addSelectColumn(Tb085PresupuestoPeer::NU_ES);
                $c->addSelectColumn(Tb085PresupuestoPeer::NU_SE);

                $c->addJoin(Tb053DetalleComprasPeer::CO_PRESUPUESTO,  Tb085PresupuestoPeer::ID);
                $c->addJoin(Tb052ComprasPeer::CO_COMPRAS,  Tb053DetalleComprasPeer::CO_COMPRAS);
                $c->add(Tb052ComprasPeer::CO_COMPRAS, $co_compras);
                $c->add(Tb053DetalleComprasPeer::CO_PRODUCTO, $Tb053DetalleCompra->getCoProducto());

                $stmt = Tb085PresupuestoPeer::doSelectStmt($c);

                while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {


                    $co_cuenta_contable = $this->getCuentaContable($reg["id_tb084_accion_especifica"], $reg["nu_pa"], $reg["nu_ge"], $reg["nu_es"], $reg["nu_se"]);

                    if ($co_cuenta_contable == '') {
                        $this->data = json_encode(array(
                            "success" => false,
                            "msg" => 'La Partida Presupuestaria seleccionada, no posee una cuenta contable asociada'
                        ));

                        $con->rollback();

                        return;
                    }
                }


                if ($co_compras != '') {
                    $Tb052Compras = Tb052ComprasPeer::retrieveByPK($co_compras);
                    $Tb052Compras->setCoEjecutor($co_ejecutor)
                        ->save($con);

                    if ($co_fuente_financiamiento != '') {
                        $wherec = new Criteria();
                        $wherec->add(Tb056ContratoComprasPeer::CO_COMPRAS, $co_compras);

                        $updc = new Criteria();
                        $updc->add(Tb056ContratoComprasPeer::CO_FUENTE_FINANCIAMIENTO, $co_fuente_financiamiento);

                        BasePeer::doUpdate($wherec, $updc, $con);
                    }
                }


                $Tb059CambioPartidaCompra = new Tb059CambioPartidaCompra();
                $Tb059CambioPartidaCompra->setCoPartidaAnterior($co_partida_ant)
                    ->setCoPartidaActual($co_partida)
                    ->setCoPartidaAnterior($co_partida_ant)
                    ->setCoPresupuestoActual($co_presupuesto)
                    ->setCoPresupuestoAnterior($co_presupuesto_ant)
                    ->setCoDetalleCompra($co_detalle_compra)
                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                    ->setTxMotivo($tx_motivo)
                    ->save($con);


                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($Tb052Compras->getCoSolicitud()));
                $c1 = new Criteria();
                $c1->add(Tb053DetalleComprasPeer::CO_COMPRAS, $co_compras);
                $c1->add(Tb053DetalleComprasPeer::CO_PRESUPUESTO, NULL);
                $cant = Tb053DetalleComprasPeer::doCount($c1);

                if ($cant == 0) {
                    $ruta->setInCargarDato(true)->save($con);
                }

                $con->commit();
                Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());



                $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente'
                ));
                $con->commit();
            }
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }
    }

    protected function getCuentaContable($co_accion, $nu_pa, $nu_ge, $nu_es, $nu_se)
    {

        $nu_partida = $nu_pa . $nu_ge . $nu_es . $nu_se;

        $c = new Criteria();
        $c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA, $co_accion);
        $c->add(Tb085PresupuestoPeer::NU_PA, $nu_pa);
        $c->add(Tb085PresupuestoPeer::NU_GE, $nu_ge);
        $c->add(Tb085PresupuestoPeer::NU_ES, $nu_es);
        $c->add(Tb085PresupuestoPeer::NU_SE, $nu_se);

        $c->setLimit(1);

        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);

        $registros = $stmt->fetch(PDO::FETCH_ASSOC);

        return $registros["co_cuenta_contable"];
    }


    public function executeCargarDisponible(sfWebRequest $request)
    {

        $co_partida = $this->getRequestParameter('co_partida');

        $c = new Criteria();
        $c->add(Tb085PresupuestoPeer::ID, $co_partida);
        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);

        $registros = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        $this->setTemplate('store');
    }

    public function executeAgregarPartida(sfWebRequest $request)
    {

        $this->data = json_encode(array(
            "de_ejecutor"           => $this->getRequestParameter("de_ejecutor"),
            "co_ejecutor"           => $this->getRequestParameter("co_ejecutor"),
            "co_detalle_compra"     => $this->getRequestParameter("co_detalle_compras"),
            "monto"                 => $this->getRequestParameter("monto"),
            "tx_producto"           => $this->getRequestParameter("tx_producto"),
            "co_clase_producto"     => 4,
            "co_compras"            => $this->getRequestParameter("co_compras")
        ));
    }

    public function executeAgregarPartidaCompra(sfWebRequest $request)
    {

        $this->data = json_encode(array(
            "de_ejecutor"              => $this->getRequestParameter("de_ejecutor"),
            "co_ejecutor"              => $this->getRequestParameter("co_ejecutor"),
            "co_detalle_compra"        => $this->getRequestParameter("co_detalle_compras"),
            "monto"                    => $this->getRequestParameter("monto"),
            "tx_producto"              => $this->getRequestParameter("tx_producto"),
            "co_clase_producto"        => 4,
            "co_compras"               => $this->getRequestParameter("co_compras"),
            "co_partida"               => $this->getRequestParameter("co_partida"),
            "co_producto"              => $this->getRequestParameter("co_producto"),
            "co_solicitud"             => $this->getRequestParameter("co_solicitud"),
            "co_fuente_financiamiento" => $this->getRequestParameter("co_fuente_financiamiento")
        ));
    }

    public function executeListaDesagregadaTodas(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "nu_partida" => $this->getRequestParameter("nu_partida"),
            "co_accion_especifica" => $this->getRequestParameter("co_accion_especifica"),
            "ejercicio" => $this->getUser()->getAttribute('ejercicio'),
            "de_ejecutor"              => $this->getRequestParameter("de_ejecutor"),
            "co_ejecutor"              => $this->getRequestParameter("co_ejecutor"),
            "co_detalle_compra"        => $this->getRequestParameter("co_detalle_compras"),
            "monto"                    => $this->getRequestParameter("monto"),
            "tx_producto"              => $this->getRequestParameter("tx_producto"),
            "co_clase_producto"        => 4,
            "co_compras"               => $this->getRequestParameter("co_compras"),
            "co_partida"               => $this->getRequestParameter("co_partida"),
            "co_producto"              => $this->getRequestParameter("co_producto"),
            "co_solicitud"             => $this->getRequestParameter("co_solicitud"),
            "co_fuente_financiamiento" => $this->getRequestParameter("co_fuente_financiamiento")
        ));
    }

    public function executeListaDesagregadaTodasPb(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "nu_partida"                     => $this->getRequestParameter("nu_partida"),
            "co_accion_especifica"           => $this->getRequestParameter("co_accion_especifica"),
            "ejercicio"                      => $this->getUser()->getAttribute('ejercicio'),
            "de_ejecutor"                    => $this->getRequestParameter("de_ejecutor"),
            "co_ejecutor"                    => $this->getRequestParameter("co_ejecutor"),
            "co_detalle_cotizacion"          => $this->getRequestParameter("co_detalle_cotizacion"),
            "monto"                          => $this->getRequestParameter("monto"),
            "tx_producto"                    => $this->getRequestParameter("tx_producto"),
            "co_clase_producto"              => 4,
            "co_cotizacion"                  => $this->getRequestParameter("co_cotizacion"),
            "co_partida"                     => $this->getRequestParameter("co_partida"),
            "co_producto"                    => $this->getRequestParameter("co_producto"),
            "co_solicitud"                   => $this->getRequestParameter("co_solicitud"),
            "co_fuente_financiamiento"       => $this->getRequestParameter("co_fuente_financiamiento")
        ));
    }

    public function executeAgregarPartidaNomina(sfWebRequest $request)
    {

        $this->data = json_encode(array(
            "de_ejecutor"              => $this->getRequestParameter("de_ejecutor"),
            "co_ejecutor"              => $this->getRequestParameter("co_ejecutor"),
            "co_detalle_compra"        => $this->getRequestParameter("co_detalle_compras"),
            "monto"                    => $this->getRequestParameter("monto"),
            "tx_producto"              => $this->getRequestParameter("tx_producto"),
            "co_clase_producto"        => 4,
            "co_compras"               => $this->getRequestParameter("co_compras"),
            "co_partida"               => $this->getRequestParameter("co_partida"),
            "co_producto"              => $this->getRequestParameter("co_producto"),
            "co_solicitud"             => $this->getRequestParameter("co_solicitud"),
            "co_fuente_financiamiento" => $this->getRequestParameter("co_fuente_financiamiento")
        ));
    }

    public function executeAgregarPartidaServicio(sfWebRequest $request)
    {

        $this->data = json_encode(array(
            "de_ejecutor"              => $this->getRequestParameter("de_ejecutor"),
            "co_ejecutor"              => $this->getRequestParameter("co_ejecutor"),
            "co_detalle_compra"        => $this->getRequestParameter("co_detalle_compras"),
            "monto"                    => $this->getRequestParameter("monto"),
            "tx_producto"              => $this->getRequestParameter("tx_producto"),
            "co_clase_producto"        => 4,
            "co_compras"               => $this->getRequestParameter("co_compras"),
            "co_partida"               => $this->getRequestParameter("co_partida"),
            "co_producto"              => $this->getRequestParameter("co_producto"),
            "co_solicitud"             => $this->getRequestParameter("co_solicitud"),
            "co_fuente_financiamiento" => $this->getRequestParameter("co_fuente_financiamiento")
        ));
    }

    public function executeCambiarPartidaPresupuesto(sfWebRequest $request)
    {

        $this->data = json_encode(array(
            "co_producto"              => $this->getRequestParameter("co_producto"),
            "co_partida"              => $this->getRequestParameter("co_partida"),
            "co_detalle_compra"        => $this->getRequestParameter("co_detalle_compras")
        ));
    }

    public function executeCambiarPartida(sfWebRequest $request)
    {

        $this->data = json_encode(array(
            "de_ejecutor"           => $this->getRequestParameter("de_ejecutor"),
            "de_proyecto_ac"        => $this->getRequestParameter("de_proyecto_ac"),
            "de_accion_especifica"  => $this->getRequestParameter("de_accion_especifica"),
            "co_accion_especifica"  => $this->getRequestParameter("co_accion_especifica"),
            "co_detalle_compra"     => $this->getRequestParameter("co_detalle_compra"),
            "monto"                 => $this->getRequestParameter("monto"),
            "tx_producto"           => $this->getRequestParameter("tx_producto")
        ));
    }

    public function executeCambiarEstado(sfWebRequest $request)
    {

        $co_detalle_compras = $this->getRequestParameter("co_detalle_compras");
        $co_solicitud = $this->getRequestParameter("co_solicitud");
        $id_partida = $this->getRequestParameter("id_partida");
        $co_compra = $this->getRequestParameter("co_compra");
        $monto = $this->getRequestParameter("monto");
        $nu_partida = $this->getRequestParameter("nu_partida");
        $co_tipo_movimiento = $this->getRequestParameter("co_tipo_movimiento");
        $co_presupuesto_movimiento = $this->getRequestParameter("co_presupuesto_movimiento");


        $con = Propel::getConnection();
        try {
            $con->beginTransaction();


            if ($co_tipo_movimiento == 0 || $co_tipo_movimiento == 4 || $co_tipo_movimiento == 5) {
                $co_tipo_movimiento = 1;
                $mensaje = 'La partida presupuestaria se comprometio con exito!';
            } else if ($co_tipo_movimiento == 1) {
                $co_tipo_movimiento = 4;
                $mensaje = 'La partida presupuestaria se descomprometio con exito!';
            }


            $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
            $tb087_presupuesto_movimiento->setCoPartida($id_partida)
                ->setCoTipoMovimiento($co_tipo_movimiento)
                ->setNuMonto($monto)
                //->setNuAnio(date('Y'))
                ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                ->setCoDetalleCompra($co_detalle_compras)
                ->setInActivo(true)
                ->save($con);


            $c = new Criteria();
            $c->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $co_detalle_compras);
            $c->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO, 1);
            $c->add(Tb087PresupuestoMovimientoPeer::IN_ACTIVO, true);

            $cant = Tb087PresupuestoMovimientoPeer::doCount($c);

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));

            $con->commit();

            $tb052_compras = Tb052ComprasPeer::retrieveByPK($co_compra);

            if ($cant > 0) {
                $ruta->setInCargarDato(true)->save($con);
                Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

                $tb052_compras->setCoTipoMovimiento(1)->save($con);
            } else {
                $ruta->setInCargarDato(false)->save($con);

                $tb052_compras->setCoTipoMovimiento(0)->save($con);
            }

            $con->commit();



            $this->data = json_encode(array(
                "success" => true,
                "msg" => $mensaje
            ));
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage()
            ));
        }
    }

    public function executeCambiarEstadoCompra(sfWebRequest $request)
    {

        $co_detalle_compras = $this->getRequestParameter("co_detalle_compras");
        $co_solicitud = $this->getRequestParameter("co_solicitud");
        $id_partida = $this->getRequestParameter("id_partida");
        $co_compra = $this->getRequestParameter("co_compra");
        $monto = $this->getRequestParameter("monto");
        $nu_partida = $this->getRequestParameter("nu_partida");
        $co_tipo_movimiento = $this->getRequestParameter("co_tipo_movimiento");
        $co_presupuesto_movimiento = $this->getRequestParameter("co_presupuesto_movimiento");


        $con = Propel::getConnection();
        try {
            $con->beginTransaction();

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
            $c->addAsColumn('co_partida', Tb085PresupuestoPeer::ID);
            $c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
            $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
            $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
            $c->addSelectColumn(Tb053DetalleComprasPeer::IN_CALCULAR_IVA);
            $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);
            $c->addSelectColumn(Tb052ComprasPeer::CO_PROVEEDOR);

            $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
            //$c->addJoin(Tb048ProductoPeer::CO_PRODUCTO, Tb053DetalleComprasPeer::CO_PRODUCTO, Criteria::LEFT_JOIN);
            $c->addJoin(Tb053DetalleComprasPeer::CO_PRESUPUESTO, Tb085PresupuestoPeer::ID, Criteria::LEFT_JOIN);

            $c->add(Tb053DetalleComprasPeer::CO_COMPRAS, $co_compra);
            $c->add(Tb053DetalleComprasPeer::IN_PRESUPUESTO, TRUE);

            $cantidadTotal = Tb053DetalleComprasPeer::doCount($c);

            $c->addAscendingOrderByColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);

            $i = 0;

            $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);

            while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

                if ($reg["mo_disponible"] < $reg["monto"]) {

                    $resta = $reg["monto"] - $reg["mo_disponible"];

                    $this->data = json_encode(array(
                        'success' => false,
                        'msg' => '<span style="color:red;font-size:13px,"><b>La partida: ' . $reg["nu_partida"] . ' - ' . $reg["de_partida"] . ' no dispone de saldo suficiente!<br></b></span>Diferencia: <b>' . $resta . '</b>'
                    ));

                    return $this->setTemplate('store');
                }

                $datos = $this->getTipoMovimiento($reg["co_detalle_compras"]);

                $reg['co_presupuesto_movimiento'] = $datos["co_presupuesto_movimiento"];
                $co_detalle_compras = $reg["co_detalle_compras"];
                $id_partida         = $reg["co_partida"];
                $monto              = $reg["monto"];

                if ($reg["co_presupuesto_movimiento"] == '') {
                    $co_tipo_movimiento = 0;
                } else {
                    $co_tipo_movimiento = $datos["id"];
                }


                if ($co_tipo_movimiento == 0 || $co_tipo_movimiento == 4 || $co_tipo_movimiento == 5) {
                    $co_tipo_movimiento = 1;
                    $mensaje = 'Las partidas presupuestarias se comprometio con exito!';
                } else if ($co_tipo_movimiento == 1) {
                    $co_tipo_movimiento = 4;
                    $mensaje = 'Las partida presupuestarias se descomprometio con exito!';
                    $monto = $monto * (-1);
                }


                $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                $tb087_presupuesto_movimiento->setCoPartida($id_partida)
                    ->setCoTipoMovimiento($co_tipo_movimiento)
                    ->setNuMonto($monto)
                    //->setNuAnio(date('Y'))
                    ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                    ->setCoDetalleCompra($co_detalle_compras)
                    ->setInActivo(true)
                    ->save($con);


                $c = new Criteria();
                $c->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $co_detalle_compras);
                $c->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO, 1);
                $c->add(Tb087PresupuestoMovimientoPeer::IN_ACTIVO, true);

                $cant = Tb087PresupuestoMovimientoPeer::doCount($c);
            }

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));

            $con->commit();

            $tb052_compras = Tb052ComprasPeer::retrieveByPK($co_compra);

            if ($cant > 0) {
                $ruta->setInCargarDato(true)->save($con);
                Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

                $tb052_compras->setCoTipoMovimiento(1)->save($con);
            } else {
                $ruta->setInCargarDato(false)->save($con);

                $tb052_compras->setCoTipoMovimiento(0)->save($con);
            }

            $con->commit();



            $this->data = json_encode(array(
                "success" => true,
                "msg" => $mensaje
            ));
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => 'Ocurrio un error durante la transacción con la partida'
            ));
        }

        $this->setTemplate('cambiarEstado');
    }

    public function executeCambiarEstadoCausadoViatico(sfWebRequest $request)
    {

        $co_detalle_compras = $this->getRequestParameter("co_detalle_compras");
        $co_solicitud = $this->getRequestParameter("co_solicitud");
        $id_partida = $this->getRequestParameter("id_partida");
        $co_compra = $this->getRequestParameter("co_compra");
        $monto = $this->getRequestParameter("monto");
        $nu_partida = $this->getRequestParameter("nu_partida");
        $co_tipo_movimiento = $this->getRequestParameter("co_tipo_movimiento");
        $co_presupuesto_movimiento = $this->getRequestParameter("co_presupuesto_movimiento");


        $con = Propel::getConnection();
        try {
            $con->beginTransaction();

            // $detalle_compra = $this->getDetalleCompra($co_detalle_compras);

          /*  if ($co_tipo_movimiento == 1 || $co_tipo_movimiento == 6) {
                $co_tipo_movimiento = 2;
                $mensaje = 'La Orden de Pago se generó con exito!';
            } else if ($co_tipo_movimiento == 2) {
                $co_tipo_movimiento = 1;
                $mensaje = 'La partida presupuestaria se descauso con exito!';
            }*/


            /*  $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
            $tb087_presupuesto_movimiento->setCoPartida($id_partida)
                ->setCoTipoMovimiento($co_tipo_movimiento)
                ->setNuMonto($monto)
                //->setNuAnio(date('Y'))
                ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                ->setCoDetalleCompra($co_detalle_compras)
                ->setInActivo(true)
                ->save($con);*/


            $c = new Criteria();
            $c->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $co_detalle_compras);
            $c->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO, 2);
            $c->add(Tb087PresupuestoMovimientoPeer::IN_ACTIVO, true);

            $cant = Tb087PresupuestoMovimientoPeer::doCount($c);

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));


            $con->commit();

            $tb052_compras = Tb052ComprasPeer::retrieveByPK($co_compra);

            if ($cant > 0) {
                if (!$ruta->getInCargarDato()) {
                    $ruta->setInCargarDato(true)->save($con);

                    Tb060OrdenPagoPeer::generarODP($co_solicitud, $con, $this->getUser()->getAttribute('ejercicio'));
                    Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());
                }


                $tb052_compras->setCoTipoMovimiento(2)->save($con);
            } else {

                //                $wherec = new Criteria();
                //                $wherec->add(Tb060OrdenPagoPeer::CO_SOLICITUD, $co_solicitud);
                //                BasePeer::doDelete($wherec, $con);

                $ruta->setInCargarDato(false)->save($con);

                $tb052_compras->setCoTipoMovimiento(1)->save($con);
            }

            $con->commit();

            //  Tb060OrdenPagoPeer::generarODP($co_solicitud, $con);

            $con->commit();

            $this->data = json_encode(array(
                "success"   => true,
                "msg"       => "La Orden de Pago se generó con exito!"
            ));
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => 'Ocurrio un error durante la transacción con la partida'
            ));
        }

        $this->setTemplate('cambiarEstado');
    }

    public function executeStorefkcopartidacatalogo(sfWebRequest $request)
    {

        $co_producto = $this->getRequestParameter('co_producto');

        $c = new Criteria();
        $c->addSelectColumn(Tb091PartidaPeer::ID);
        $c->addSelectColumn(Tb091PartidaPeer::NU_PARTIDA);
        $c->addSelectColumn(Tb091PartidaPeer::DE_PARTIDA);
        $c->add(Tb091PartidaPeer::ID_TIPO_PARTIDA, 2);
        $c->add(Tb091PartidaPeer::IN_MOVIMIENTO, true);
        $c->add(Tb091PartidaPeer::NU_NIVEL, 4);
        $c->addAscendingOrderByColumn(Tb091PartidaPeer::NU_PARTIDA);
        /*$c->addJoin(Tb094PartidaProductoPeer::NU_PARTIDA,  Tb091PartidaPeer::NU_PARTIDA);
        $c->addJoin(Tb094PartidaProductoPeer::ID_TB092_CLASE_PRODUCTO,  Tb048ProductoPeer::CO_CLASE);
        
        if($co_producto!=''){
            $c->add(Tb048ProductoPeer::CO_PRODUCTO,$co_producto);
        }
        
        if(Tb048ProductoPeer::doCount($c)==0){
            $c = new Criteria();
            $c->addSelectColumn(Tb091PartidaPeer::ID);
            $c->addSelectColumn(Tb091PartidaPeer::NU_PARTIDA);
            $c->addSelectColumn(Tb091PartidaPeer::DE_PARTIDA);
            $c->addJoin(Tb094PartidaProductoPeer::NU_PARTIDA,  Tb091PartidaPeer::NU_PARTIDA);
            $c->addJoin(Tb094PartidaProductoPeer::ID_TB092_CLASE_PRODUCTO,  Tb048ProductoPeer::CO_CLASE);
        }*/

        $cantidad = 0;

        $stmt = Tb091PartidaPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $reg["nu_partida"] = Tb085PresupuestoPeer::mascaraNomina($reg["nu_partida"]);

            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
        ));
        $this->setTemplate('store');
    }

    public function executeCambiarEstadoCausado(sfWebRequest $request)
    {

        $co_detalle_compras = $this->getRequestParameter("co_detalle_compras");
        $co_solicitud = $this->getRequestParameter("co_solicitud");
        $id_partida = $this->getRequestParameter("id_partida");
        $co_compra = $this->getRequestParameter("co_compra");
        $monto = $this->getRequestParameter("monto");
        $nu_partida = $this->getRequestParameter("nu_partida");
        $co_tipo_movimiento = $this->getRequestParameter("co_tipo_movimiento");
        $co_presupuesto_movimiento = $this->getRequestParameter("co_presupuesto_movimiento");


        $con = Propel::getConnection();
        try {
            $con->beginTransaction();

            // $detalle_compra = $this->getDetalleCompra($co_detalle_compras);

            if ($co_tipo_movimiento == 1 || $co_tipo_movimiento == 6) {
                $co_tipo_movimiento = 2;
                $mensaje = 'La partida presupuestaria se causo con exito!';
            } else if ($co_tipo_movimiento == 2) {
                $co_tipo_movimiento = 6;
                $mensaje = 'La partida presupuestaria se descauso con exito!';
            }


            $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
            $tb087_presupuesto_movimiento->setCoPartida($id_partida)
                ->setCoTipoMovimiento($co_tipo_movimiento)
                ->setNuMonto($monto)
                //->setNuAnio(date('Y'))
                ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                ->setCoDetalleCompra($co_detalle_compras)
                ->setInActivo(true)
                ->save($con);


            $c = new Criteria();
            $c->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $co_detalle_compras);
            $c->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO, 2);
            $c->add(Tb087PresupuestoMovimientoPeer::IN_ACTIVO, true);

            $cant = Tb087PresupuestoMovimientoPeer::doCount($c);

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));


            $con->commit();

            $tb052_compras = Tb052ComprasPeer::retrieveByPK($co_compra);

            if ($cant > 0) {
                $ruta->setInCargarDato(true)->save($con);

                Tb060OrdenPagoPeer::generarODP($co_solicitud, $con, $this->getUser()->getAttribute('ejercicio'));
                Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

                $tb052_compras->setCoTipoMovimiento(2)->save($con);
            } else {

                $wherec = new Criteria();
                $wherec->add(Tb060OrdenPagoPeer::CO_SOLICITUD, $co_solicitud);
                BasePeer::doDelete($wherec, $con);

                $ruta->setInCargarDato(false)->save($con);

                $tb052_compras->setCoTipoMovimiento(1)->save($con);
            }

            $con->commit();

            $this->data = json_encode(array(
                "success" => true,
                "msg" => $mensaje
            ));
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => 'Ocurrio un error durante la transacción con la partida'
            ));
        }

        $this->setTemplate('cambiarEstado');
    }

    protected function getTipoMovimiento($co_detalle_compra)
    {

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb087PresupuestoMovimientoPeer::CO_PRESUPUESTO_MOVIMIENTO);
        $c->addSelectColumn(Tb088TipoMovimientoPeer::ID);
        $c->addSelectColumn(Tb088TipoMovimientoPeer::DE_TIPO_MOVIMIENTO);

        $c->addJoin(Tb088TipoMovimientoPeer::ID, Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO);
        $c->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $co_detalle_compra);
        $c->add(Tb087PresupuestoMovimientoPeer::IN_ACTIVO, true);
        $c->add(Tb087PresupuestoMovimientoPeer::IN_ANULAR, NULL, Criteria::ISNULL);
        $stmt = Tb087PresupuestoMovimientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
    }

    protected function getTipoMovimientoServicio($co_compra)
    {

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb087PresupuestoMovimientoPeer::CO_PRESUPUESTO_MOVIMIENTO);
        $c->addSelectColumn(Tb088TipoMovimientoPeer::ID);
        $c->addSelectColumn(Tb088TipoMovimientoPeer::DE_TIPO_MOVIMIENTO);

        $c->addJoin(Tb088TipoMovimientoPeer::ID, Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO);
        $c->add(Tb087PresupuestoMovimientoPeer::CO_COMPRA_SERVICIO, $co_compra);
        $c->add(Tb087PresupuestoMovimientoPeer::IN_ACTIVO, true);
        $stmt = Tb087PresupuestoMovimientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
    }

    public function executeStorelistacausar(sfWebRequest $request)
    {
        $paginar    =   $this->getRequestParameter("paginar");
        $co_compra      =   $this->getRequestParameter("co_compra");


        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        $c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
        $c->addAsColumn('co_partida', Tb085PresupuestoPeer::ID);
        $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
        $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
        $c->addSelectColumn(Tb053DetalleComprasPeer::IN_CALCULAR_IVA);
        $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);
        $c->addSelectColumn(Tb052ComprasPeer::CO_PROVEEDOR);

        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
        $c->addJoin(Tb085PresupuestoPeer::ID, Tb053DetalleComprasPeer::CO_PRESUPUESTO);
        $c->addJoin(Tb048ProductoPeer::CO_PRODUCTO, Tb053DetalleComprasPeer::CO_PRODUCTO);
        $c->addJoin(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA,  Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS, Criteria::LEFT_JOIN);

        $c->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO, array('1', '2', '6'), Criteria::IN);
        $c->add(Tb087PresupuestoMovimientoPeer::IN_ACTIVO, true);

        $c->add(Tb053DetalleComprasPeer::CO_COMPRAS, $co_compra);

        //    echo $c->toString(); exit();

        $cantidadTotal = Tb053DetalleComprasPeer::doCount($c);

        $c->addAscendingOrderByColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);

        $i = 0;

        $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);

        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $datos = $this->getTipoMovimiento($reg["co_detalle_compras"]);

            $reg['co_presupuesto_movimiento'] = $datos["co_presupuesto_movimiento"];

            if ($reg["co_presupuesto_movimiento"] == '') {
                $reg["co_tipo_movimiento"] = 0;
                $reg["tx_tipo_movimiento"] = 'PRE-COMPROMETIDO';
            } else {
                $reg["co_tipo_movimiento"] = $datos["id"];
                $reg["tx_tipo_movimiento"] = strtoupper($datos["de_tipo_movimiento"]);
            }

            $mo_iva = $this->getIVA($reg["monto"], $reg["nu_iva"]);
            $mo_retencion = $this->getIVARetencion($mo_iva, $reg["co_proveedor"]);

            if ($reg["in_calcular_iva"] == true)
                $reg["monto"] = $reg["monto"] + $mo_retencion;

            $registros[] = $reg;
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
        $paginar    =   $this->getRequestParameter("paginar");
        $co_compra      =   $this->getRequestParameter("co_compra");


        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
        $c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
        $c->addAsColumn('co_partida', Tb085PresupuestoPeer::ID);
        $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
        $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
        $c->addSelectColumn(Tb053DetalleComprasPeer::DETALLE);
        $c->addSelectColumn(Tb053DetalleComprasPeer::IN_CALCULAR_IVA);
        $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);
        $c->addSelectColumn(Tb052ComprasPeer::CO_PROVEEDOR);

        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
        //$c->addJoin(Tb048ProductoPeer::CO_PRODUCTO, Tb053DetalleComprasPeer::CO_PRODUCTO);
        $c->addJoin(Tb053DetalleComprasPeer::CO_PRODUCTO, Tb048ProductoPeer::CO_PRODUCTO, Criteria::LEFT_JOIN);
        $c->addJoin(Tb053DetalleComprasPeer::CO_PRESUPUESTO, Tb085PresupuestoPeer::ID, Criteria::LEFT_JOIN);

        $c->add(Tb053DetalleComprasPeer::CO_COMPRAS, $co_compra);
        $c->add(Tb053DetalleComprasPeer::IN_PRESUPUESTO, TRUE);

        $cantidadTotal = Tb053DetalleComprasPeer::doCount($c);

        $c->addAscendingOrderByColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);

        $i = 0;

        $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);

        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $datos = $this->getTipoMovimiento($reg["co_detalle_compras"]);

            $reg['co_presupuesto_movimiento'] = $datos["co_presupuesto_movimiento"];

            if ($reg["co_presupuesto_movimiento"] == '') {
                $reg["co_tipo_movimiento"] = 0;
                $reg["tx_tipo_movimiento"] = 'PRE-COMPROMETIDO';
            } else {
                $reg["co_tipo_movimiento"] = $datos["id"];
                $reg["tx_tipo_movimiento"] = strtoupper($datos["de_tipo_movimiento"]);
            }

            $mo_iva = $this->getIVA($reg["monto"], $reg["nu_iva"]);
            $mo_retencion = $this->getIVARetencion($mo_iva, $reg["co_proveedor"]);

            if ($reg["in_calcular_iva"] == true)
                $reg["monto"] = $reg["monto"]; //+$mo_retencion;

            $reg["nu_partida"]               = ($reg["nu_partida"] == null) ? '' : Tb085PresupuestoPeer::mascaraNomina($reg["nu_partida"]);
            $reg["de_partida"]               = ($reg["de_partida"] == null) ? '' : $reg["de_partida"];
            $reg["mo_disponible"]            = ($reg["mo_disponible"] == null) ? '' : $reg["mo_disponible"];
            $reg["co_partida"]               = ($reg["co_partida"] == null) ? '' : $reg["co_partida"];
            $reg["co_presupuesto_movimiento"] = ($reg["co_presupuesto_movimiento"] == null) ? '' : $reg["co_presupuesto_movimiento"];

            $registros[] = $reg;
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));
    }

    protected function getIVA($monto, $nu_iva)
    {

        $valor_iva = ($nu_iva) / 100;

        return $monto * $valor_iva;
    }

    public function executeStorelistaCompra(sfWebRequest $request)
    {
        $paginar    =   $this->getRequestParameter("paginar");
        $co_compra      =   $this->getRequestParameter("co_compra");


        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
        $c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PARTIDA);
        $c->addAsColumn('co_presupuesto', Tb085PresupuestoPeer::ID);
        $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
        $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_ASIENTO_CONTABLE);
        $c->addSelectColumn(Tb053DetalleComprasPeer::IN_CALCULAR_IVA);
        $c->addSelectColumn(Tb052ComprasPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);
        $c->addSelectColumn(Tb053DetalleComprasPeer::DETALLE);

        $c->addSelectColumn(Tb045FacturaPeer::NU_FACTURA);

        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
        $c->addJoin(Tb053DetalleComprasPeer::CO_PRODUCTO, Tb048ProductoPeer::CO_PRODUCTO,  Criteria::LEFT_JOIN);
        $c->addJoin(Tb053DetalleComprasPeer::CO_PARTIDA, Tb091PartidaPeer::ID, Criteria::LEFT_JOIN);
        $c->addJoin(Tb053DetalleComprasPeer::CO_PRESUPUESTO, Tb085PresupuestoPeer::ID, Criteria::LEFT_JOIN);
        $c->addJoin(Tb053DetalleComprasPeer::CO_FACTURA, Tb045FacturaPeer::CO_FACTURA, Criteria::LEFT_JOIN);

        $c->add(Tb053DetalleComprasPeer::CO_COMPRAS, $co_compra);
        $c->add(Tb053DetalleComprasPeer::IN_PRESUPUESTO, TRUE);


        $cantidadTotal = Tb053DetalleComprasPeer::doCount($c);

        $c->addAscendingOrderByColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);

        //echo $c->toString(); exit();

        $i = 0;

        $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);

        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $datos = $this->getTipoMovimiento($reg["co_detalle_compras"]);

            $reg['co_presupuesto_movimiento'] = $datos["co_presupuesto_movimiento"];

            if ($reg["co_presupuesto_movimiento"] == '') {
                $reg["co_tipo_movimiento"] = 0;
                $reg["tx_tipo_movimiento"] = 'PRE-COMPROMETIDO';
            } else {
                $reg["co_tipo_movimiento"] = $datos["id"];
                $reg["tx_tipo_movimiento"] = strtoupper($datos["de_tipo_movimiento"]);
            }

            $reg["nu_partida"]               = ($reg["nu_partida"] == null) ? '' : $reg["nu_partida"];
            $reg["de_partida"]               = ($reg["de_partida"] == null) ? '' : $reg["de_partida"];
            $reg["mo_disponible"]            = ($reg["mo_disponible"] == null) ? '' : $reg["mo_disponible"];
            $reg["co_partida"]               = ($reg["co_partida"] == null) ? '' : $reg["co_partida"];
            $reg["co_presupuesto_movimiento"] = ($reg["co_presupuesto_movimiento"] == null) ? '' : $reg["co_presupuesto_movimiento"];

            $mo_iva = $this->getIVA($reg["monto"], $reg["nu_iva"]);
            $mo_retencion = $this->getIVARetencion($mo_iva, $reg["co_proveedor"]);

            if ($reg["in_calcular_iva"] == true)
                $reg["monto"] = $reg["monto"]; //+$mo_retencion;

            $registros[] = $reg;
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));
    }


    public function executeStorelistaCompraPb(sfWebRequest $request)
    {
        $paginar    =   $this->getRequestParameter("paginar");
        $codigo    =   $this->getRequestParameter("co_cotizacion");


        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb207DetalleCotizacionPeer::CO_DETALLE_COTIZACION);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
        $c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::CO_CATEGORIA);
        $c->addSelectColumn(Tb207DetalleCotizacionPeer::CO_PARTIDA);
        $c->addAsColumn('co_presupuesto', Tb085PresupuestoPeer::ID);
        $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
        $c->addSelectColumn(Tb207DetalleCotizacionPeer::MONTO);
        $c->addSelectColumn(Tb207DetalleCotizacionPeer::CO_ASIENTO_CONTABLE);
        $c->addSelectColumn(Tb207DetalleCotizacionPeer::IN_CALCULAR_IVA);
        $c->addSelectColumn(Tb206CotizacionPeer::NU_IVA);
        $c->addSelectColumn(Tb207DetalleCotizacionPeer::DETALLE);


        $c->addJoin(Tb206CotizacionPeer::CO_COTIZACION, Tb207DetalleCotizacionPeer::CO_COTIZACION);
        $c->addJoin(Tb207DetalleCotizacionPeer::CO_PRODUCTO, Tb048ProductoPeer::CO_PRODUCTO,  Criteria::LEFT_JOIN);
        // $c->addJoin(Tb207DetalleCotizacionPeer::CO_PARTIDA, Tb091PartidaPeer::ID, Criteria::LEFT_JOIN);
        $c->addJoin(Tb207DetalleCotizacionPeer::CO_PRESUPUESTO, Tb085PresupuestoPeer::ID, Criteria::LEFT_JOIN);

        $c->add(Tb207DetalleCotizacionPeer::CO_COTIZACION, $codigo);
        $c->add(Tb207DetalleCotizacionPeer::IN_PRESUPUESTO, TRUE);




        $cantidadTotal = Tb053DetalleComprasPeer::doCount($c);

        $c->addAscendingOrderByColumn(Tb207DetalleCotizacionPeer::CO_DETALLE_COTIZACION);

        //echo $c->toString(); exit();

        $i = 0;

        $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);

        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $datos = $this->getTipoMovimiento($reg["co_detalle_cotizacion"]);

            $reg['co_presupuesto_movimiento'] = $datos["co_presupuesto_movimiento"];

            if ($reg["co_presupuesto_movimiento"] == '') {
                $reg["co_tipo_movimiento"] = 0;
                $reg["tx_tipo_movimiento"] = 'PRE-COMPROMETIDO';
            } else {
                $reg["co_tipo_movimiento"] = $datos["id"];
                $reg["tx_tipo_movimiento"] = strtoupper($datos["de_tipo_movimiento"]);
            }

            $reg["nu_partida"]               = ($reg["co_categoria"] == null) ? '' : $reg["co_categoria"];
            $reg["de_partida"]               = ($reg["de_partida"] == null) ? '' : $reg["de_partida"];
            $reg["mo_disponible"]            = ($reg["mo_disponible"] == null) ? '' : $reg["mo_disponible"];
            $reg["co_partida"]               = ($reg["co_partida"] == null) ? '' : $reg["co_partida"];
            $reg["co_presupuesto_movimiento"] = ($reg["co_presupuesto_movimiento"] == null) ? '' : $reg["co_presupuesto_movimiento"];

            $mo_iva = $this->getIVA($reg["monto"], $reg["nu_iva"]);
            // $mo_retencion = $this->getIVARetencion($mo_iva, $reg["co_proveedor"]);

            if ($reg["in_calcular_iva"] == true)
                $reg["monto"] = $reg["monto"]; //+$mo_retencion;

            $registros[] = $reg;
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));


        $this->setTemplate('storelista');
    }


    public function executeStorelistaResumen(sfWebRequest $request)
    {
        $paginar    =   $this->getRequestParameter("paginar");
        $co_compra      =   $this->getRequestParameter("co_compra");


        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb085PresupuestoPeer::ID);
        $c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
        $c->addSelectColumn('SUM(' . Tb053DetalleComprasPeer::MONTO . ') as monto');

        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
        $c->addJoin(Tb085PresupuestoPeer::ID, Tb053DetalleComprasPeer::CO_PRESUPUESTO,  Criteria::LEFT_JOIN);

        $c->add(Tb053DetalleComprasPeer::CO_COMPRAS, $co_compra);

        $c->addGroupByColumn(Tb085PresupuestoPeer::ID);
        $c->addGroupByColumn(Tb085PresupuestoPeer::NU_PARTIDA);
        $c->addGroupByColumn(Tb085PresupuestoPeer::DE_PARTIDA);
        $c->addGroupByColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);


        $cantidadTotal = Tb053DetalleComprasPeer::doCount($c);

        $i = 0;

        $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);

        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $reg["nu_partida"] = Tb085PresupuestoPeer::mascaraNomina($reg["nu_partida"]);

            $registros[] = $reg;
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));

        $this->setTemplate('storelista');
    }

    public function executeQuitarPartidaPb(sfWebRequest $request)
    {

        $co_detalle_cotizacion = $this->getRequestParameter("co_detalle_cotizacion");
        $co_compras = $this->getRequestParameter("co_compras");
        $co_asiento_contable = $this->getRequestParameter("co_asiento_contable");

        $con = Propel::getConnection();
        try {
            $con->beginTransaction();

            $tb207_detalle_cotizacion = Tb207DetalleCotizacionPeer::retrieveByPK($co_detalle_cotizacion);

            $monto = $tb207_detalle_cotizacion->getMonto();
            $monto = $monto * (-1);

            $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
            $tb087_presupuesto_movimiento->setCoPartida($tb207_detalle_cotizacion->getCoPresupuesto())
                ->setCoTipoMovimiento(4)
                ->setNuMonto($monto)
                //->setNuAnio(date('Y'))
                ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                ->setCoDetallePresuBase($co_detalle_cotizacion)
                ->setInActivo(true)
                ->save($con);




            $tb207_detalle_cotizacion->setCoPresupuesto(null)
                ->save($con);

            $c = new Criteria();
            $c->add(Tb207DetalleCotizacionPeer::CO_DETALLE_COTIZACION, $co_detalle_cotizacion);
            $c->addJoin(Tb206CotizacionPeer::CO_COTIZACION, Tb207DetalleCotizacionPeer::CO_COTIZACION);
            $stmt = Tb206CotizacionPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);


            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($campos["co_solicitud"]));
            $ruta->setInCargarDato(false)->save($con);

            $con->commit();



            $this->data = json_encode(array(
                "success" => true,
                "msg" => "La transacción con la partida se realizó exitosamente"
            ));
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage()
            ));
        }


        $this->setTemplate('cambiarEstado');
    }


    public function executeQuitarPartida(sfWebRequest $request)
    {

        $co_detalle_compras = $this->getRequestParameter("co_detalle_compras");
        $co_compras = $this->getRequestParameter("co_compras");
        $co_asiento_contable = $this->getRequestParameter("co_asiento_contable");

        $con = Propel::getConnection();
        try {
            $con->beginTransaction();

            $tb053_detalle_compras = Tb053DetalleComprasPeer::retrieveByPK($co_detalle_compras);

            Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $tb053_detalle_compras->getCoPresupuesto(), 4, $tb053_detalle_compras->getMonto(), '', $tb053_detalle_compras->getCoDetalleCompras());
            Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $tb053_detalle_compras->getCoPresupuesto(), 13, $tb053_detalle_compras->getMonto(), '', $tb053_detalle_compras->getCoDetalleCompras());


            $tb053_detalle_compras->setCoPresupuesto(null)
                ->setCoAccionEspecifica(null)
                ->setCoProyectoAc(null)
                ->setCoAsientoContable(null)
                ->save($con);


            $tb052_compras = Tb052ComprasPeer::retrieveByPK($co_compras);
            $tb052_compras->setCoEjecutor(NULL)->save($con);

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb052_compras->getCoSolicitud()));
            $ruta->setInCargarDato(false)->save($con);

            $con->commit();



            $this->data = json_encode(array(
                "success" => true,
                "msg" => "La transacción con la partida se realizó exitosamente"
            ));
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage()
            ));
        }


        $this->setTemplate('cambiarEstado');
    }


    public function executeStorefkcopartida(sfWebRequest $request)
    {

        $co_accion = $this->getRequestParameter('co_accion');
        $co_partida = $this->getRequestParameter('co_partida');

        $c = new Criteria();
        $c->addSelectColumn(Tb085PresupuestoPeer::ID);
        $c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);

        $c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
        //$c->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);
        $c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));

        if ($co_accion != '') {
            $c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA, $co_accion);
        }

        //        if($co_partida!=''){
        //            $cp = new Criteria();
        //            $cp->clearSelectColumns();
        //            $cp->addSelectColumn(Tb091PartidaPeer::NU_PARTIDA);
        //            $cp->add(Tb091PartidaPeer::ID,$co_partida);
        //            
        //            $stmtp = Tb091PartidaPeer::doSelectStmt($cp);
        //            while($list = $stmtp->fetch(PDO::FETCH_ASSOC)){
        //                 $c->addOr(Tb085PresupuestoPeer::CO_PARTIDA,$list["nu_partida"].'%',Criteria::LIKE);
        //            }
        //            
        //
        //           
        //        }


        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

            //$reg["nu_partida"] = Tb085PresupuestoPeer::mascaraNomina($reg["nu_partida"]);

            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
        ));
        $this->setTemplate('store');
    }

    public function executeStorefkcoejecutor(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tb082EjecutorPeer::IN_ACTIVO, TRUE);
        $c->addAscendingOrderByColumn(Tb082EjecutorPeer::NU_EJECUTOR);
        $stmt = Tb082EjecutorPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
        ));
        $this->setTemplate('store');
    }

    public function executeStorefkcotipoodp(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb171TipoOdpPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
        ));
        $this->setTemplate('store');
    }

    public function executeStorefkcoejecutororgano(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tb082EjecutorPeer::IN_ACTIVO, TRUE);
        $c->add(Tb082EjecutorPeer::ID_TB151_TIPO_EJECUTOR, 1);
        $c->addAscendingOrderByColumn(Tb082EjecutorPeer::NU_EJECUTOR);
        $stmt = Tb082EjecutorPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
        ));
        $this->setTemplate('store');
    }

    public function executeStorefkcoejecutorente(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tb082EjecutorPeer::IN_ACTIVO, TRUE);
        $c->add(Tb082EjecutorPeer::ID_TB151_TIPO_EJECUTOR, 2);
        $c->addAscendingOrderByColumn(Tb082EjecutorPeer::NU_EJECUTOR);
        $stmt = Tb082EjecutorPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
        ));
        $this->setTemplate('store');
    }

    public function executeDesafectacion(sfWebRequest $request)
    {


        $this->data = json_encode(array(
            "co_solicitud"             => $this->getRequestParameter("co_solicitud")
        ));
    }

    public function executeStorelistaDesafectacion(sfWebRequest $request)
    {

        $fe_desde     =   $this->getRequestParameter('fe_desde');
        $fe_hasta     =   $this->getRequestParameter('fe_hasta');

        list($dia_desde, $mes_desde, $anio_desde) = explode("/", $fe_desde);
        list($dia_hasta, $mes_hasta, $anio_hasta) = explode("/", $fe_hasta);

        $desde = $anio_desde . '-' . $mes_desde . '-' . $dia_desde;
        $hasta = $anio_hasta . '-' . $mes_hasta . '-' . $dia_hasta;

        $con = Propel::getConnection();

        $sql = "select inicial||'-'||tx_rif as tx_rif,tx_razon_social,co_orden_pago,tb060.tx_serial,tb062.mo_pendiente
                from tb060_orden_pago tb060
                join tb062_liquidacion_pago tb062 on (tb062.co_solicitud = tb060.co_solicitud)
                left join tb026_solicitud tb026 on tb026.co_solicitud = tb060.co_solicitud
                left join tb008_proveedor tb008 on tb008.co_proveedor = tb026.co_proveedor
                left join tb007_documento tb007 on tb007.co_documento = tb008.co_documento
               where cast(tb060.fe_emision as date) between '$desde' and '$hasta' and tb062.mo_pendiente >0 and tb060.tx_serial != '' and in_desafectado = false and tb060.in_anular is not true
               order by co_orden_pago";

        $stmt = $con->prepare($sql);
        $stmt->execute();

        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  0,
            "data"      =>  $registros
        ));
    }


    public function executeGuardarDesafectacion(sfWebRequest $request)
    {

        $json_movimiento     =   $this->getRequestParameter("json_movimiento");
        $co_solicitud     =   $this->getRequestParameter("co_solicitud");

        $con = Propel::getConnection();

        try {
            $con->beginTransaction();



            $codigo = explode(',', $json_movimiento);
            $listaMovimiento  = json_decode($json_movimiento, true);
            if (count($listaMovimiento) > 0) {

                $c1  = new Criteria();
                $c1->add(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, $codigo, Criteria::IN);
                $stmt1 = Tb060OrdenPagoPeer::doSelectStmt($c1);
                while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {

                    $tb060_orden_pago = Tb060OrdenPagoPeer::retrieveByPK($row["co_orden_pago"]);
                    $tb060_orden_pago->setInDesafectado(true);
                    $tb060_orden_pago->save($con);


                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
                    $c->addSelectColumn(Tb052ComprasPeer::CO_SOLICITUD);
                    $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
                    $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
                    $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD, Tb060OrdenPagoPeer::CO_SOLICITUD);
                    $c->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
                    $c->add(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, $row["co_orden_pago"]);

                    $stmt = Tb060OrdenPagoPeer::doSelectStmt($c);
                    while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

                        $c2 = new Criteria();
                        $c2->clearSelectColumns();
                        $c2->addSelectColumn('SUM(' . Tb087PresupuestoMovimientoPeer::NU_MONTO . ') as mo_pagado');
                        $c2->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $reg["co_detalle_compras"]);
                        $c2->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO, 3);
                        $c2->addGroupByColumn(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA);
                        $stmt2 = Tb087PresupuestoMovimientoPeer::doSelectStmt($c2);
                        $campo = $stmt2->fetch(PDO::FETCH_ASSOC);



                        if ($campo["mo_pagado"] > 0) {
                            $mo_disponible = $reg["monto"] -  $campo["mo_pagado"];
                        } else {
                            $mo_disponible = $reg["monto"];
                        }

                        $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                        $tb087_presupuesto_movimiento->setCoPartida($reg["co_presupuesto"])
                            ->setCoTipoMovimiento(1)
                            ->setNuMonto(-$mo_disponible)
                            ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                            ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                            ->setCoDetalleCompra($reg["co_detalle_compras"])
                            ->setInActivo(true)
                            ->save($con);

                        $tb087_presupuesto_movimiento2 = new Tb087PresupuestoMovimiento();
                        $tb087_presupuesto_movimiento2->setCoPartida($reg["co_presupuesto"])
                            ->setCoTipoMovimiento(2)
                            ->setNuMonto(-$mo_disponible)
                            ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                            ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                            ->setCoDetalleCompra($reg["co_detalle_compras"])
                            ->setInActivo(true)
                            ->save($con);

                        $tb085_presupuesto = Tb085PresupuestoPeer::retrieveByPK($reg["co_presupuesto"]);

                        $mo_comprometido = $tb085_presupuesto->getMoComprometido() - $mo_disponible;
                        $mo_causado = $tb085_presupuesto->getMoCausado() - $mo_disponible;

                        $tb085_presupuesto->setMoComprometido($mo_comprometido);
                        $tb085_presupuesto->setMoCausado($mo_causado);

                        $tb085_presupuesto->save($con);

                        $co_cuenta_por_pagar = Tb130CuentaDocumentoPeer::getCoCuentaContable($reg["co_solicitud"]);

                        $tb061_asiento_contable = new Tb061AsientoContable();
                        $tb061_asiento_contable->setMoHaber($mo_disponible)
                            ->setCoCuentaContable($tb085_presupuesto->getCoCuentaContable())
                            ->setCoSolicitud($co_solicitud)
                            ->setCoTipoAsiento(2)
                            ->save($con);

                        $tb061_asiento_contable2 = new Tb061AsientoContable();
                        $tb061_asiento_contable2->setMoDebe($mo_disponible)
                            ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_orden_pago"])
                            ->setCoSolicitud($co_solicitud)
                            ->setCoTipoAsiento(2)
                            ->save($con);
                    }

                    $tb205_desafectacion = new Tb205Desafectacion();
                    $tb205_desafectacion->setCoSolicitud($co_solicitud)
                        ->setCoOrdenPago($row["co_orden_pago"])
                        ->setFeDesafectacion(date('Y-m-d'))
                        ->save($con);
                }



                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
                $ruta->setInCargarDato(true)->save();
                Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());
                $con->commit();

                $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Proceso realizado Exitosamente'
                ));
            } else {
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'Debe seleccionar al menos un registro'
                ));
            }
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }
    }

    public function executeGuardarReintegro(sfWebRequest $request)
    {
        $co_solicitud = $this->getRequestParameter('co_solicitud');
        $json_cuenta                 = $this->getRequestParameter('json_cuenta');

        $con = Propel::getConnection();

        try {
            $con->beginTransaction();


            $listaCuenta  = json_decode($json_cuenta, true);

            foreach ($listaCuenta  as $v) {

                if ($v["co_reintegro_presupuesto"] == '') {
                    $tb201_reintegro_presupuesto = new Tb201ReintegroPresupuesto();
                    $tb201_reintegro_presupuesto->setCoSolicitud($co_solicitud)
                        ->setIdPartida($v["id_partida"])
                        ->setMonto($v["monto"])
                        ->setFecha($v["fecha"])
                        ->setDescripcion($v["descripcion"])
                        ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                        ->setInRechazado(false)
                        ->save($con);
                }
            }

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
            $ruta->setInCargarDato(true)->save($con);
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());



            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Proceso realizado exitosamente'
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

    public function executeBuscarPartida(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "nu_partida" => $this->getRequestParameter("nu_partida"),
            "co_accion_especifica" => $this->getRequestParameter("co_accion_especifica"),
            "ejercicio" => $this->getUser()->getAttribute('ejercicio'),
            "de_ejecutor"              => $this->getRequestParameter("de_ejecutor"),
            "co_ejecutor"              => $this->getRequestParameter("co_ejecutor"),
            "co_detalle_compra"        => $this->getRequestParameter("co_detalle_compras"),
            "monto"                    => $this->getRequestParameter("monto"),
            "tx_producto"              => $this->getRequestParameter("tx_producto"),
            "co_clase_producto"        => 4,
            "co_compras"               => $this->getRequestParameter("co_compras"),
            "co_partida"               => $this->getRequestParameter("co_partida"),
            "co_producto"              => $this->getRequestParameter("co_producto"),
            "co_solicitud"             => $this->getRequestParameter("co_solicitud"),
            "co_fuente_financiamiento" => $this->getRequestParameter("co_fuente_financiamiento")
        ));
    }
}
