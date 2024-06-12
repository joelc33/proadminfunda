<?php

/**
 * autoPagoNomina actions.
 * NombreClaseModel(Tb122PagoNomina)
 * NombreTabla(tb122_pago_nomina)
 * @package    ##PROJECT_NAME##
 * @subpackage autoPagoNomina
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class PagoNominaActions extends sfActions
{

    public function executeIndex(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "co_rol"            => $this->getUser()->getAttribute('rol'),
            "co_usuario"        => $this->getUser()->getAttribute('codigo'),
            "in_activo"         => $this->getUser()->getAttribute('in_activo'),
            "tx_tipo_solicitud" => $this->getRequestParameter("tx_tipo_solicitud"),
            "co_tipo_solicitud" => 23,
            "tx_url"            => $this->getRequestParameter("tx_url"),

        ));

        $this->getRequest()->setAttribute('in_activo', $this->getUser()->getAttribute('in_activo'));
    }

    public function executeNuevo(sfWebRequest $request)
    {
        $this->forward('PagoNomina', 'editar');
    }

    public function executeGenerarNomina(sfWebRequest $request)
    {

        $this->data = json_encode(array(
            "ejercicio"        => $this->getUser()->getAttribute('ejercicio')
        ));
    }

    public function executeFiltro(sfWebRequest $request)
    {
    }

    protected function getMoNominaMasivo($codigo)
    {
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb052ComprasPeer::CO_EJECUTOR);
        $c->addSelectColumn('SUM(' . Tb132PagoNominaMasivoPeer::NU_MONTO . ') as monto_total');
        $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD, Tb132PagoNominaMasivoPeer::CO_SOLICITUD);
        $c->add(Tb132PagoNominaMasivoPeer::CO_SOLICITUD, $codigo);
        $c->add(Tb132PagoNominaMasivoPeer::TX_TIPO_MOVIMIENTO, "A");
        $c->addGroupByColumn(Tb052ComprasPeer::CO_EJECUTOR);

        $stmt = Tb132PagoNominaMasivoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $cd = new Criteria();
        $cd->clearSelectColumns();
        $cd->addSelectColumn(Tb052ComprasPeer::CO_EJECUTOR);
        $cd->addSelectColumn('SUM(' . Tb132PagoNominaMasivoPeer::NU_MONTO . ') as monto_total');
        $cd->addJoin(Tb052ComprasPeer::CO_SOLICITUD, Tb132PagoNominaMasivoPeer::CO_SOLICITUD);
        $cd->add(Tb132PagoNominaMasivoPeer::CO_SOLICITUD, $codigo);
        $cd->add(Tb132PagoNominaMasivoPeer::TX_TIPO_MOVIMIENTO, "D");
        $cd->addGroupByColumn(Tb052ComprasPeer::CO_EJECUTOR);

        $stmtd = Tb052ComprasPeer::doSelectStmt($cd);
        $campos_deducciones = $stmtd->fetch(PDO::FETCH_ASSOC);

        $campos["monto_total"] = $campos["monto_total"] - $campos_deducciones["monto_total"];

        return $campos;
    }

    protected function getMoNomina($codigo)
    {
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn('SUM(' . Tb123ArchivoPagoPeer::NU_MONTO . ') as monto');
        $c->addJoin(Tb122PagoNominaPeer::CO_PAGO_NOMINA, Tb123ArchivoPagoPeer::CO_PAGO_NOMINA);
        $c->add(Tb122PagoNominaPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb122PagoNominaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
    }

    public function executeEditar(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");
        if ($codigo != '' || $codigo != null) {
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb122PagoNominaPeer::CO_PAGO_NOMINA);
            $c->addSelectColumn(Tb122PagoNominaPeer::CO_TIPO_NOMINA);
            $c->addSelectColumn(Tb122PagoNominaPeer::CO_TIPO_TRABAJADOR);
            $c->addSelectColumn(Tb122PagoNominaPeer::TX_CONCEPTO);
            $c->addSelectColumn(Tb122PagoNominaPeer::FE_PAGO);
            $c->addSelectColumn(Tb122PagoNominaPeer::CO_SOLICITUD);
            $c->addSelectColumn(Tb122PagoNominaPeer::CO_USUARIO);
            $c->addSelectColumn(Tb122PagoNominaPeer::CREATED_AT);
            $c->addSelectColumn(Tb122PagoNominaPeer::CO_EJECUTOR);
            $c->addSelectColumn(Tb122PagoNominaPeer::MO_TOTAL);

            $c->addSelectColumn(Tb052ComprasPeer::MONTO_TOTAL);

            $c->add(Tb122PagoNominaPeer::CO_SOLICITUD, $codigo);

            $datos_nomina = $this->getMoNominaMasivo($codigo);

            $stmt = Tb122PagoNominaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $diferencia = $campos["mo_total"] - $datos_nomina["monto_total"];

            $this->data = json_encode(array(
                "co_pago_nomina"     => $campos["co_pago_nomina"],
                "co_tipo_trabajador" => $campos["co_tipo_trabajador"],
                "co_tipo_nomina"     => $campos["co_tipo_nomina"],
                "tx_concepto"        => $campos["tx_concepto"],
                "fe_pago"            => $campos["fe_pago"],
                "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                "co_usuario"         => $campos["co_usuario"],
                "created_at"         => $campos["created_at"],
                "co_ejecutor"        => $datos_nomina["co_ejecutor"],
                "mo_nomina"          => $datos_nomina["monto_total"],
                "mo_total"           => $campos["mo_total"],
                "mo_diferencia"      => $diferencia,
                "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
                "fe_fin"   => $this->getUser()->getAttribute('fe_cierre')
            ));
        } else {

            $datos_nomina = $this->getMoNomina($codigo);

            $this->data = json_encode(array(
                "co_pago_nomina"     => "",
                "co_tipo_trabajador" => "",
                "co_tipo_nomina"     => "",
                "tx_concepto"        => "",
                "fe_pago"            => "",
                "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                "co_usuario"         => "",
                "created_at"         => "",
                "co_ejecutor"        => $datos_nomina["co_ejecutor"],
                "mo_nomina"          => $datos_nomina["monto_total"],
                "mo_total"           => "",
                "mo_diferencia"      => "",
                "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
                "fe_fin"   => $this->getUser()->getAttribute('fe_cierre')
            ));
        }
    }

    public function executeCargarMaestro(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");
        if ($codigo != '' || $codigo != null) {
            $c = new Criteria();
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
                "co_ejecutor"   => $campos["co_ejecutor"],
                "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
                "fe_fin"   => $this->getUser()->getAttribute('fe_cierre')
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
                "co_ejecutor"   => "",
                "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
                "fe_fin"   => $this->getUser()->getAttribute('fe_cierre')
            ));
        }
    }

    protected function getCoPartida($tx_partida, $tx_ente)
    {
        $c = new Criteria();
        $c->addJoin(Tb082EjecutorPeer::ID, Tb085PresupuestoPeer::CO_ENTE);
        $c->add(Tb085PresupuestoPeer::NU_PARTIDA, $tx_partida);
        $c->add(Tb082EjecutorPeer::NU_EJECUTOR, $tx_ente);
        $c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
        //$c->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);
        $c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));


        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
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

    public function executeGenerarODP(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("co_solicitud");

        $tb132_pago_nomina_masivoForm = $this->getRequestParameter('tb132_pago_nomina_masivo');

        //$fe_pago = $tb132_pago_nomina_masivoForm["fe_pago"];
        list($dia, $mes, $anio) = explode("/", $tb132_pago_nomina_masivoForm["fe_pago"]);
        $fe_pago = $anio . "-" . $mes . "-" . $dia;

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
                    ->setCoTipoMovimiento(1)
                    ->setNuMonto($campos["monto"])
                    //->setNuAnio(date('Y'))
                    ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                    ->setCoDetalleCompra($campos["co_detalle_compras"])
                    ->setInActivo(true)
                    ->save($con);

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

            //$co_odp = Tb060OrdenPagoPeer::generarODP($codigo,$con,$this->getUser()->getAttribute('ejercicio'));
            $co_odp = Tb060OrdenPagoPeer::generarODP($codigo, $con, $this->getUser()->getAttribute('ejercicio'), $nu_orden_pago = NULL, $fe_pago);

            $Tb060OrdenPago = Tb060OrdenPagoPeer::retrieveByPK($co_odp);
            $Tb060OrdenPago->setCoTipoOdp($this->getRequestParameter("co_tipo_odp"))->save($con);

            $con->commit();

            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

            $this->data = json_encode(array(
                "success" => true,
                "msg"     => 'Modificación realizada exitosamente ',
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


    public function executeGuardarMaestro(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("co_pago_nomina");

        $con = Propel::getConnection();
        if ($codigo != '' || $codigo != null) {
            $tb122_pago_nomina = Tb122PagoNominaPeer::retrieveByPk($codigo);
        } else {
            $tb122_pago_nomina = new Tb122PagoNomina();

            $tb132_pago_nomina_masivoForm = $this->getRequestParameter('tb132_pago_nomina_masivo');

            $tb026_solicitudForm = array(
                "co_tipo_solicitud"   => 23,
                "ejercicio"           => $this->getUser()->getAttribute('ejercicio'),
                "fe_solicitud"        => $tb132_pago_nomina_masivoForm["fe_pago"], 
                "observacion"         => strtoupper($tb132_pago_nomina_masivoForm["tx_concepto"]),
                "codigo"              => $this->getUser()->getAttribute('codigo')
            );

            $resp = Tb026SolicitudPeer::setSolicitud($tb026_solicitudForm);

            if($resp["success"]==true){
                $tb132_pago_nomina_masivoForm["co_solicitud"] = $resp["co_solicitud"];
            }

        }
        

        try {
            $con->beginTransaction();

            $tb122_pago_nomina->setTxConcepto($tb132_pago_nomina_masivoForm["tx_concepto"]);

            list($dia, $mes, $anio) = explode("/", $tb132_pago_nomina_masivoForm["fe_pago"]);
            $fecha = $anio . "-" . $mes . "-" . $dia;
            $tb122_pago_nomina->setFePago($fecha);


            $tb122_pago_nomina->setCoSolicitud($tb132_pago_nomina_masivoForm["co_solicitud"]);
            $tb122_pago_nomina->setCoUsuario($this->getUser()->getAttribute('codigo'));
            $tb122_pago_nomina->save($con);

            $tb026_solicitud = Tb026SolicitudPeer::retrieveByPK($tb132_pago_nomina_masivoForm["co_solicitud"]);
            //$tb026_solicitud->setCoProveedor(12276); //Direccion de Recursos Humanos
            $tb026_solicitud->setCoProveedor(Tb008ProveedorPeer::getProveedorDefecto()); //Direccion de Recursos Humanos
            $tb026_solicitud->save($con);


            if ($_FILES['form-file']['tmp_name'] == '') {
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" =>  "Debe Seleccionar un archivo xlsx"
                ));

                echo $this->data;
                return sfView::NONE;
            }


            $lines = file($_FILES['form-file']['tmp_name']);
            $i = 0;
            $cadena = '';

            $wherec = new Criteria();
            $wherec->add(Tb132PagoNominaMasivoPeer::CO_PAGO, $tb122_pago_nomina->getCoPagoNomina(), Criteria::EQUAL);
            BasePeer::doDelete($wherec, $con);

            $wherecTb046 = new Criteria();
            $wherecTb046->add(Tb046FacturaRetencionPeer::CO_SOLICITUD, $tb132_pago_nomina_masivoForm["co_solicitud"], Criteria::EQUAL);
            BasePeer::doDelete($wherecTb046, $con);

            $mo_total = 0;
            $i = 0;
            $co_ejecutor = '';

            $data = new Spreadsheet_Excel_Reader();
            $data->setOutputEncoding('CP1251');
            $data->read($_FILES['form-file']['tmp_name']);

            for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {

                $tx_descripcion =  utf8_decode($data->sheets[0]['cells'][$i][3]);


                $Tb132PagoNominaMasivo = new Tb132PagoNominaMasivo();
                $Tb132PagoNominaMasivo->setTxTipoMovimiento(trim($data->sheets[0]['cells'][$i][1]))
                    ->setTxMovimiento(trim($data->sheets[0]['cells'][$i][2]))
                    ->setTxDescripcion(trim($tx_descripcion))
                    ->setNuMonto(trim($data->sheets[0]['cells'][$i][4]))
                    ->setTxPartida(trim($data->sheets[0]['cells'][$i][5]))
                    ->setTxCodigoBanco(trim($data->sheets[0]['cells'][$i][6]))
                    ->setCoSolicitud($tb132_pago_nomina_masivoForm["co_solicitud"])
                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                    ->setCoPago($tb122_pago_nomina->getCoPagoNomina())
                    ->save($con);

                /*****************Joel Codigo de Aporte********************/

                $tb137_control_serial = Tb137ControlSerialPeer::retrieveByPK(9);
                $serial = $tb137_control_serial->getNuSerial();
                $tb137_control_serial->setNuSerial($serial + 1);
                $tb137_control_serial->save($con);

                $tb137_control_serial = new Tb159AportePatronalNomina();
                $tb137_control_serial->setTxTipoNomina($tb122_pago_nomina->getTxConcepto());
                $tb137_control_serial->setTxSerialNomina(date('Y-m') . '-' . $serial);
                $tb137_control_serial->setMoAporte(trim($data->sheets[0]['cells'][$i][4]));
                $tb137_control_serial->setTxTipoAporte(trim($data->sheets[0]['cells'][$i][2]));
                $tb137_control_serial->setCoSolicitud($tb132_pago_nomina_masivoForm["co_solicitud"]);
                $tb137_control_serial->setFeAporte($fecha);
                $tb137_control_serial->save($con);




                /*********************Joel Codigo de Aporte***********************/

                $mo_total += trim($data->sheets[0]['cells'][$i][4]);

                if ($co_ejecutor == '')
                    $co_ejecutor = Tb082EjecutorPeer::getCoEjecutor(trim($data->sheets[0]['cells'][$i][1]));

                //$i++;           

            }

            $tb122_pago_nomina->setMoTotal($mo_total)->save($con);

            $c = new Criteria();
            //$c->add(Tb052ComprasPeer::ANIO, date('Y'));
            $c->add(Tb052ComprasPeer::ANIO, $this->getUser()->getAttribute('ejercicio'));
            $c->add(Tb052ComprasPeer::CO_TIPO_SOLICITUD, 23);
            $total = Tb052ComprasPeer::doCount($c);
            $correlativo = $total + 1;

            $co_compra = Tb052ComprasPeer::getCompra($tb132_pago_nomina_masivoForm["co_solicitud"]);

            if ($co_compra["co_compras"] != '') {
                $tb052_compras = Tb052ComprasPeer::retrieveByPk($co_compra["co_compras"]);
            } else {
                $tb052_compras = new Tb052Compras();
            }

            $tb052_compras->setCoUsuario($this->getUser()->getAttribute('codigo'));
            //$tb052_compras->setFechaCompra(date("Y-m-d"));
            if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                $tb052_compras->setFechaCompra($this->getUser()->getAttribute('fe_cierre'));
            } else {
                $tb052_compras->setFechaCompra(date("Y-m-d"));
            }
            $tb052_compras->setCoSolicitud($tb132_pago_nomina_masivoForm["co_solicitud"]);
            $tb052_compras->setCoTipoSolicitud(23);
            //$tb052_compras->setAnio(date('Y'));
            $tb052_compras->setAnio($this->getUser()->getAttribute('ejercicio'));
            $tb052_compras->setNuIva(0);
            $tb052_compras->setMontoIva(0);
            $tb052_compras->setMontoSubTotal(0);
            $tb052_compras->setMontoTotal($mo_total);
            $tb052_compras->setCoTipoMovimiento(0);
            $tb052_compras->setCoEjecutor($co_ejecutor);
            // $tb052_compras->setCoEjecutor($tb122_pago_nominaForm["co_ejecutor"]);
            $tb052_compras->save($con);

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn('SUM(' . Tb132PagoNominaMasivoPeer::NU_MONTO . ') as total');
            $c->addSelectColumn(Tb132PagoNominaMasivoPeer::TX_PARTIDA);
            $c->addSelectColumn(Tb132PagoNominaMasivoPeer::TX_DESCRIPCION);
            $c->addSelectColumn(Tb132PagoNominaMasivoPeer::TX_ENTE);
            $c->addSelectColumn(Tb132PagoNominaMasivoPeer::TX_TIPO_MOVIMIENTO);
            $c->addSelectColumn(Tb132PagoNominaMasivoPeer::TX_MOVIMIENTO);
            $c->add(Tb132PagoNominaMasivoPeer::CO_PAGO, $tb122_pago_nomina->getCoPagoNomina());
            $c->addGroupByColumn(Tb132PagoNominaMasivoPeer::TX_PARTIDA);
            $c->addGroupByColumn(Tb132PagoNominaMasivoPeer::TX_DESCRIPCION);
            $c->addGroupByColumn(Tb132PagoNominaMasivoPeer::TX_ENTE);
            $c->addGroupByColumn(Tb132PagoNominaMasivoPeer::TX_TIPO_MOVIMIENTO);
            $c->addGroupByColumn(Tb132PagoNominaMasivoPeer::TX_MOVIMIENTO);
            $c->addGroupByColumn(Tb132PagoNominaMasivoPeer::TX_CORRELATIVO);


            //        echo $c->toString(); exit();


            $stmt = Tb132PagoNominaMasivoPeer::doSelectStmt($c);
            $registros = "";

            $i = 0;

            $wherec = new Criteria();
            $wherec->add(Tb053DetalleComprasPeer::CO_COMPRAS, $tb052_compras->getCoCompras(), Criteria::EQUAL);
            $stmtw = Tb053DetalleComprasPeer::doSelectStmt($wherec);
            while ($resw = $stmtw->fetch(PDO::FETCH_ASSOC)) {
                $wherem = new Criteria();
                $wherem->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $resw["co_detalle_compras"], Criteria::EQUAL);
                BasePeer::doDelete($wherem, $con);
            }

            BasePeer::doDelete($wherec, $con);


            while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

                if ($res["tx_tipo_movimiento"] == 'A') {
                    $reg = $this->getCoPartida($res["tx_partida"], $res["tx_ente"]);

                    //                echo "id=".$reg["id"].$res["tx_partida"].",".$res["tx_ente"]; exit();

                    $tb053_detalle_compras = new Tb053DetalleCompras();
                    $tb053_detalle_compras->setCoCompras($tb052_compras->getCoCompras());
                    $tb053_detalle_compras->setNuCantidad(1);
                    $tb053_detalle_compras->setPrecioUnitario($res["total"]);
                    $tb053_detalle_compras->setMonto($res["total"]);
                    $tb053_detalle_compras->setDetalle($res["tx_descripcion"]);
                    $tb053_detalle_compras->setCoPresupuesto($reg["id"]);

                    $tb053_detalle_compras->setDetalle($res["tx_descripcion"]);
                    $tb053_detalle_compras->save($con);
                } else {
                    if ($res["tx_tipo_movimiento"] == 'D') {

                        $co_tipo_retencion = $this->getCoTipoRetencion($res["tx_movimiento"]);

                        $tb046_factura_retencion = new Tb046FacturaRetencion();
                        $tb046_factura_retencion->setCoTipoRetencion($co_tipo_retencion)
                            ->setMoRetencion($res["total"])
                            ->setCoSolicitud($tb132_pago_nomina_masivoForm["co_solicitud"])
                            ->save($con);
                    }
                }
                $i++;
            }


            if ($i > 0) {

                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb132_pago_nomina_masivoForm["co_solicitud"]));
                $ruta->setInCargarDato(true)->save($con);
                $con->commit();
                //            Tb060OrdenPagoPeer::generarODP($tb132_pago_nomina_masivoForm["co_solicitud"],$con);
                Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());
            } else {
                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb132_pago_nomina_masivoForm["co_solicitud"]));
                $ruta->setInCargarDato(false)->save($con);
            }

            $this->data = json_encode(array(
                "success" => true,
                "co_pago_nomina" => $tb122_pago_nomina->getCoPagoNomina(),
                "co_solicitud" => $tb122_pago_nomina->getCoSolicitud(),
                "msg" => 'Modificación realizada exitosamente '
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

    protected function getCoTipoRetencion($tx_movimiento)
    {
        $c = new Criteria();
        $c->add(Tb041TipoRetencionPeer::TX_MOVIMIENTO, $tx_movimiento);
        $stmt = Tb041TipoRetencionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos["co_tipo_retencion"];
    }


    public function executeGuardar(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("co_pago_nomina");

        $con = Propel::getConnection();
        if ($codigo != '' || $codigo != null) {
            $tb122_pago_nomina = Tb122PagoNominaPeer::retrieveByPk($codigo);
        } else {
            $tb122_pago_nomina = new Tb122PagoNomina();
        }
        try {
            $con->beginTransaction();

            $tb122_pago_nominaForm = $this->getRequestParameter('tb122_pago_nomina');
            $tb122_pago_nomina->setCoTipoTrabajador($tb122_pago_nominaForm["co_tipo_trabajador"]);
            $tb122_pago_nomina->setCoTipoNomina($tb122_pago_nominaForm["co_tipo_nomina"]);
            $tb122_pago_nomina->setTxConcepto($tb122_pago_nominaForm["tx_concepto"]);
            $tb122_pago_nomina->setCoEjecutor($tb122_pago_nominaForm["co_ejecutor"]);

            list($dia, $mes, $anio) = explode("/", $tb122_pago_nominaForm["fe_pago"]);
            $fecha = $anio . "-" . $mes . "-" . $dia;
            $tb122_pago_nomina->setFePago($fecha);


            $tb122_pago_nomina->setCoSolicitud($tb122_pago_nominaForm["co_solicitud"]);
            $tb122_pago_nomina->setCoUsuario($this->getUser()->getAttribute('codigo'));
            $tb122_pago_nomina->save($con);

            $lines = file($_FILES['form-file']['tmp_name']);
            $i = 0;
            $cadena = '';

            $wherec = new Criteria();
            $wherec->add(Tb123ArchivoPagoPeer::CO_PAGO_NOMINA, $tb122_pago_nomina->getCoPagoNomina(), Criteria::EQUAL);
            BasePeer::doDelete($wherec, $con);

            $mo_total = 0;

            foreach ($lines as $line) {
                $cadena = str_replace("|", "", $line);
                $array = explode(",", $cadena);

                if (!is_numeric(trim($array[0]))) {
                    $this->data = json_encode(array(
                        "success" => false,
                        "msg" => 'El código de persona  ' . $array[0] . ' debe ser númerico ' . $array[1] . 'linea ' . $i
                    ));
                    echo $this->data;
                    return sfView::NONE;
                }

                if (strlen(trim($array[1])) > 9) {
                    $this->data = json_encode(array(
                        "success" => false,
                        "msg" => 'El número de cédula  ' . trim($array[1]) . ' debe tener una longitud de 9 caracteres '
                    ));
                    echo $this->data;
                    return sfView::NONE;
                }

                if (strlen(trim($array[3])) == '') {
                    $this->data = json_encode(array(
                        "success" => false,
                        "msg" => 'El número de cuenta  ' . trim($array[3]) . ' debe tener una longitud de menos 10 digitos'
                    ));
                    echo $this->data;
                    return sfView::NONE;
                }

                /*if(trim($array[5]) == '06'){
               $co_banco = '0108'; 
            }
            
            if(trim($array[5]) == '10'){
                $co_banco = '0102';
            }
            
            if(trim($array[5]) == '20'){
                $co_banco = '0116';
            }*/

                /*if( trim($array[5]) == '06'){
                $co_banco = '0108';
            }elseif( trim($array[5]) == '10'){
                $co_banco = '0102';
            }elseif( trim($array[5]) == '20'){
                $co_banco = '0116';
            }*/

                $co_banco = Tb010BancoPeer::getCodigo(trim($array[5]));
                $co_modo = Tb010BancoPeer::getModoPago(trim($array[3]), trim($array[5]));

                $Tb123ArchivoPago = new Tb123ArchivoPago();
                $Tb123ArchivoPago->setCoPagoNomina($tb122_pago_nomina->getCoPagoNomina())
                    ->setCoPersona(trim(utf8_decode($array[0])))
                    ->setTxCedula(trim(utf8_decode($array[1])))
                    ->setNbPersona(utf8_decode($array[2]))
                    ->setTxCuentaBancaria(trim(utf8_decode($array[3])))
                    ->setNuMonto(trim(utf8_decode($array[4])))
                    ->setCodBanco($co_banco)
                    ->setIdTb163ModoPago($co_modo)
                    ->setCoUbicacion(trim(utf8_decode($array[6])))
                    ->save($con);

                $mo_total += trim($array[4]);
                $cadena = $array[2];
                $i++;
            }


            if ($i == 0) {
                $con->rollback();
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" =>  "Debe Seleccionar un archivo de nomina",
                ));

                echo $this->data;
                return sfView::NONE;
            }



            $tb122_pago_nomina->setMoTotal($mo_total)->save($con);

            $datos_masivo = $this->getMoNominaMasivo($tb122_pago_nominaForm["co_solicitud"]);
            $diferencia = (float)$mo_total - (float)$datos_masivo["monto_total"];
            $mo_total = $datos_masivo["monto_total"];
            if ((float)$mo_total != (float)$mo_total) {

                $con->rollback();
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" =>  "El monto de la nomina debe ser igual al monto total cargado " . $mo_total . "!=" . $datos_masivo["monto_total"] . 'diferencia=' . $diferencia,
                    "monto" => $mo_total,
                    "diferencia" => $diferencia
                ));

                echo $this->data;
                return sfView::NONE;
            }


            if ($i > 0) {
                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb122_pago_nominaForm["co_solicitud"]));
                $ruta->setInCargarDato(true)->save($con);
            } else {
                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb122_pago_nominaForm["co_solicitud"]));
                $ruta->setInCargarDato(false)->save($con);
            }

            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Modificación realizada exitosamente ',
                "monto" => $mo_total,
                "diferencia" => $diferencia
            ));

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage() . '---' . $i . '----' . $cadena
            ));
        }

        echo $this->data;
        return sfView::NONE;
    }


    public function executeEliminar(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_pago_nomina");
        $con = Propel::getConnection();
        try {
            $con->beginTransaction();
            /*CAMPOS*/
            $tb122_pago_nomina = Tb122PagoNominaPeer::retrieveByPk($codigo);
            $tb122_pago_nomina->delete($con);
            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Registro Borrado con exito!'
            ));
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                //		    "msg" =>  $e->getMessage()
                "msg" => 'Este registro no se puede borrar porque <br>se encuentra asociado a otros registros'
            ));
        }
    }

    public function executeLista(sfWebRequest $request)
    {
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
        $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb001UsuarioPeer::TX_LOGIN);
        $c->addSelectColumn(Tb026SolicitudPeer::FE_REGISTRO);
        $c->addSelectColumn(Tb026SolicitudPeer::CO_PERSONA);
        //  $c->addSelectColumn(Tb060OrdenPagoPeer::TX_SERIAL);
        $c->addSelectColumn(Tb122PagoNominaPeer::TX_CONCEPTO);
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
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb122PagoNominaPeer::CO_SOLICITUD,  Criteria::JOIN);

        $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, 23);
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
    }

    //modelo fk tb120_tipo_trabajador.CO_TIPO_TRABAJADOR
    public function executeStorefkcotipotrabajador(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb120TipoTrabajadorPeer::doSelectStmt($c);
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
    //modelo fk tb121_tipo_nomina.CO_TIPO_NOMINA
    public function executeStorefkcotiponomina(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb121TipoNominaPeer::doSelectStmt($c);
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
    //modelo fk tb026_solicitud.CO_SOLICITUD
    public function executeStorefkcosolicitud(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
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
    //modelo fk tb001_usuario.CO_USUARIO
    public function executeStorefkcousuario(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb001UsuarioPeer::doSelectStmt($c);
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

    public function executeStorefkcoejecutor(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tb082EjecutorPeer::IN_ACTIVO, TRUE);
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

    protected function getDatosPartida($tx_ente, $tx_partida)
    {


        $c = new Criteria();
        $c->addJoin(Tb132PagoNominaMasivoPeer::TX_PARTIDA, Tb085PresupuestoPeer::NU_PARTIDA);
        //$c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
        $c->addJoin(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA, Tb084AccionEspecificaPeer::ID);
        $c->addJoin(Tb084AccionEspecificaPeer::ID_TB083_PROYECTO_AC, Tb083ProyectoAcPeer::ID);
        $c->addJoin(Tb083ProyectoAcPeer::ID_TB082_EJECUTOR, Tb082EjecutorPeer::ID);
        $c->add(Tb082EjecutorPeer::NU_EJECUTOR, $tx_ente);
        $c->add(Tb085PresupuestoPeer::NU_PARTIDA, $tx_partida);
        //$c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
        //$c->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);
        //$c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
        $c->add(Tb085PresupuestoPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));

        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
        $reg = $stmt->fetch(PDO::FETCH_ASSOC);

        return $reg;
    }


    public function executeStorelistaConcepto(sfWebRequest $request)
    {
        $paginar           =   $this->getRequestParameter("paginar");
        $co_solicitud      =   $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb132PagoNominaMasivoPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb132PagoNominaMasivoPeer::TX_PARTIDA);
        $c->addSelectColumn(Tb132PagoNominaMasivoPeer::TX_ENTE);
        //$c->addSelectColumn(Tb132PagoNominaMasivoPeer::TX_DESCRIPCION);
        //$c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
        $c->addSelectColumn(Tb132PagoNominaMasivoPeer::NU_MONTO);
        $c->addSelectColumn(Tb132PagoNominaMasivoPeer::TX_DESCRIPCION);


        $c->add(Tb132PagoNominaMasivoPeer::CO_SOLICITUD, $co_solicitud);
        $c->add(Tb132PagoNominaMasivoPeer::TX_TIPO_MOVIMIENTO, 'A');

        //echo $c->toString(); exit();

        $cantidadTotal = Tb132PagoNominaMasivoPeer::doCount($c);

        $c->addAscendingOrderByColumn(Tb132PagoNominaMasivoPeer::CO_PAGO_NOMINA);

        $i = 0;
        $mo_disponible = 0;

        $stmt = Tb132PagoNominaMasivoPeer::doSelectStmt($c);


        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $datos_partida = $this->getDatosPartida(trim($reg["tx_ente"]), trim($reg["tx_partida"]));
            $reg["mo_disponible"] = ($datos_partida["mo_disponible"] == '') ? 0 : $datos_partida["mo_disponible"];
            $reg["de_partida"] = $datos_partida["de_partida"];

            $registros[] = $reg;
            $i++;
        }

        if ($i == 0) {
            $registros[] = array(
                "co_solicitud"       => "",
                "tx_partida"         => "",
                "de_partida"         => "",
                "mo_disponible"      => "",
                "nu_monto"           => "",
                "tx_descripcion"     => ""
            );
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));

        $this->setTemplate('storelista');
    }

    public function executeStorelistaConceptoODP(sfWebRequest $request)
    {
        $paginar           =   $this->getRequestParameter("paginar");
        $co_solicitud      =   $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb052ComprasPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
        //$c->addSelectColumn(Tb132PagoNominaMasivoPeer::TX_ENTE);
        //$c->addSelectColumn(Tb132PagoNominaMasivoPeer::TX_DESCRIPCION);
        $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
        $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);

        $c->addJoin(Tb053DetalleComprasPeer::CO_PRESUPUESTO, Tb085PresupuestoPeer::ID);
        $c->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $co_solicitud);

        $c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
        $c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
        //$c->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);
        //echo $c->toString(); exit();

        $cantidadTotal = Tb053DetalleComprasPeer::doCount($c);

        $c->addAscendingOrderByColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);

        $i = 0;
        $mo_disponible = 0;

        $stmt = Tb132PagoNominaMasivoPeer::doSelectStmt($c);


        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

            //            //$datos_partida = $this->getDatosPartida($reg["tx_ente"], $reg["tx_partida"]);
            //            $reg["mo_disponible"] = ($datos_partida["mo_disponible"]=='')?0:$datos_partida["mo_disponible"];


            $reg["tx_partida"] = Tb085PresupuestoPeer::mascaraNomina($reg["nu_partida"]);
            $reg["nu_monto"] = $reg["monto"];
            $reg["tx_descripcion"] = $reg["de_partida"];

            $registros[] = $reg;
            $i++;
        }

        if ($i == 0) {
            $registros[] = array(
                "co_solicitud"       => "",
                "tx_partida"         => "",
                "de_partida"         => "",
                "mo_disponible"      => "",
                "nu_monto"           => "",
                "tx_descripcion"     => ""
            );
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));

        $this->setTemplate('storelista');
    }

    public function executeStorelistaDeducciones(sfWebRequest $request)
    {
        $paginar           =   $this->getRequestParameter("paginar");
        $co_solicitud      =   $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb132PagoNominaMasivoPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb132PagoNominaMasivoPeer::NU_MONTO);
        $c->addSelectColumn(Tb132PagoNominaMasivoPeer::TX_DESCRIPCION);

        $c->add(Tb132PagoNominaMasivoPeer::CO_SOLICITUD, $co_solicitud);
        $c->add(Tb132PagoNominaMasivoPeer::TX_TIPO_MOVIMIENTO, 'D');

        $cantidadTotal = Tb132PagoNominaMasivoPeer::doCount($c);

        $c->addAscendingOrderByColumn(Tb132PagoNominaMasivoPeer::CO_PAGO_NOMINA);

        $i = 0;
        $mo_disponible = 0;

        $stmt = Tb132PagoNominaMasivoPeer::doSelectStmt($c);


        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
            $i++;
        }

        if ($i == 0) {
            $registros[] = array(
                "co_solicitud"       => "",
                "nu_monto"           => "",
                "tx_descripcion"     => "",
            );
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));

        $this->setTemplate('storelista');
    }

    public function executeStorelistaNomina(sfWebRequest $request)
    {

        $co_solicitud      =   $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn('COUNT(' . Tb123ArchivoPagoPeer::COD_BANCO . ') as cant');
        $c->addSelectColumn(Tb010BancoPeer::TX_BANCO);
        $c->addSelectColumn('SUM(' . Tb123ArchivoPagoPeer::NU_MONTO . ') as total');

        $c->addJoin(Tb122PagoNominaPeer::CO_PAGO_NOMINA, Tb123ArchivoPagoPeer::CO_PAGO_NOMINA);
        $c->addJoin(Tb123ArchivoPagoPeer::COD_BANCO, Tb010BancoPeer::NU_CODIGO);
        $c->add(Tb122PagoNominaPeer::CO_SOLICITUD, $co_solicitud);
        $c->addGroupByColumn(Tb010BancoPeer::TX_BANCO);

        $cantidadTotal = Tb123ArchivoPagoPeer::doCount($c);

        $c->addAscendingOrderByColumn(Tb010BancoPeer::TX_BANCO);

        $i = 0;
        $mo_disponible = 0;

        $stmt = Tb132PagoNominaMasivoPeer::doSelectStmt($c);


        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
            $i++;
        }

        if ($i == 0) {
            $registros[] = array(
                "cant"       => "",
                "tx_banco"           => "",
                "total"     => "",
            );
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));

        $this->setTemplate('storelista');
    }

    public function executeStorelistaAporte(sfWebRequest $request)
    {
        $paginar           =   $this->getRequestParameter("paginar");
        $co_solicitud      =   $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb132PagoNominaMasivoPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb132PagoNominaMasivoPeer::NU_MONTO);
        $c->addSelectColumn(Tb132PagoNominaMasivoPeer::TX_DESCRIPCION);

        $c->add(Tb132PagoNominaMasivoPeer::CO_SOLICITUD, $co_solicitud);
        $c->add(Tb132PagoNominaMasivoPeer::TX_TIPO_MOVIMIENTO, 'P');

        $cantidadTotal = Tb132PagoNominaMasivoPeer::doCount($c);

        $c->addAscendingOrderByColumn(Tb132PagoNominaMasivoPeer::CO_PAGO_NOMINA);

        $i = 0;
        $mo_disponible = 0;

        $stmt = Tb132PagoNominaMasivoPeer::doSelectStmt($c);


        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
            $i++;
        }

        if ($i == 0) {
            $registros[] = array(
                "co_solicitud"       => "",
                "nu_monto"           => "",
                "tx_descripcion"     => "",
            );
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));

        $this->setTemplate('storelista');
    }


    public function executeStorelistagenerar(sfWebRequest $request)
    {

        $co_tipo      =   $this->getRequestParameter("co_tipo");

        $sql = "select q1.fictra as cedula ,q1.nombre, q1.asignaciones,coalesce(q2.deducciones,0) as deducciones , round(q1.asignaciones - coalesce(q2.deducciones,0),2) as monto_pago from (
            select fictra,nombr1 ||' '||apell1 as nombre, round( asignacion_1 + asignacion_5 + asignacion_11 + asignacion_15 + asignacion_21 + asignacion_86 + asignacion_90 + asignacion_73

             ,2) as asignaciones  from tmp_maestro 
            where tnom in('96O3') --and fictra = '16612220'
            )
            as q1
            left join (

            select tmp_deducion_obrero.fictra,round(sum(
            case
            --when co_descto::numeric= 102 then coalesce(monto::numeric,0) --bono fin de año(no esta en el maestro)
            when tmp_deducion_obrero.co_descto::numeric= 103 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)
            when tmp_deducion_obrero.co_descto::numeric= 109 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)
            --when tmp_deducion_obrero.co_descto::numeric= 111 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)--excepcion(sueldo_int - deducciones * factor de calculo) o sueldo sin deducciones * factor (SE CALCULA AFUERA)
            when tmp_deducion_obrero.co_descto::numeric= 114 then coalesce(monto::numeric,0)
            when tmp_deducion_obrero.co_descto::numeric= 124 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)
            when tmp_deducion_obrero.co_descto::numeric= 127 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)
            when tmp_deducion_obrero.co_descto::numeric= 128 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)
            when tmp_deducion_obrero.co_descto::numeric= 137 then (asignacion_1*coalesce(cantidad::numeric,0))/100 --sueldo basico porcentaje = af11
            when tmp_deducion_obrero.co_descto::numeric= 138 then (asignacion_1*coalesce(cantidad::numeric,0))/100 --sueldo basico porcentaje
            when tmp_deducion_obrero.co_descto::numeric= 146 then (asignacion_1*coalesce(cantidad::numeric,0))/100 --sueldo basico porcentaje
            when tmp_deducion_obrero.co_descto::numeric= 148 then (asignacion_1*coalesce(cantidad::numeric,0))/100 --sueldo basico porcentaje
            when tmp_deducion_obrero.co_descto::numeric= 149 then (asignacion_1*coalesce(cantidad::numeric,0))/100 --sueldo basico porcentaje
            when tmp_deducion_obrero.co_descto::numeric= 150 then (asignacion_1*coalesce(cantidad::numeric,0))/100 --sueldo basico porcentaje
            when tmp_deducion_obrero.co_descto::numeric= 151 then (asignacion_1*coalesce(cantidad::numeric,0))/100 --sueldo basico porcentaje
            when tmp_deducion_obrero.co_descto::numeric= 188 then coalesce(monto::numeric,0)
            when tmp_deducion_obrero.co_descto::numeric= 189 then coalesce(monto::numeric,0)
            when tmp_deducion_obrero.co_descto::numeric= 197 then (asignacion_1*coalesce(cantidad::numeric,0))/100 --sueldo basico porcentaje
            when tmp_deducion_obrero.co_descto::numeric= 221 then coalesce(monto::numeric,0)--total neto
            when tmp_deducion_obrero.co_descto::numeric= 230 then coalesce(monto::numeric,0)
            when tmp_deducion_obrero.co_descto::numeric= 298 then coalesce(monto::numeric,0)
            when tmp_deducion_obrero.co_descto::numeric= 311 then (asignacion_1*coalesce(cantidad::numeric,0))/100 --sueldo basico porcentaje
            when tmp_deducion_obrero.co_descto::numeric= 319 then (asignacion_1*coalesce(cantidad::numeric,0))/100 --sueldo basico porcentaje
            when tmp_deducion_obrero.co_descto::numeric= 350 then (asignacion_1*coalesce(cantidad::numeric,0))/100 --sueldo basico porcentaje
            when tmp_deducion_obrero.co_descto::numeric= 381 then (asignacion_1*coalesce(cantidad::numeric,0))/100 --sueldo basico porcentaje
            when tmp_deducion_obrero.co_descto::numeric= 382 then (asignacion_1*coalesce(cantidad::numeric,0))/100 --sueldo basico porcentaje
            when tmp_deducion_obrero.co_descto::numeric= 384 then coalesce(monto::numeric,0)
            when tmp_deducion_obrero.co_descto::numeric= 507 then (asignacion_1*coalesce(cantidad::numeric,0))/100 --sueldo basico porcentaje
            --when tmp_deducion_obrero.co_descto::numeric= 911 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)--excepcion(vacasiones no esta en el maestro)
            when tmp_deducion_obrero.co_descto::numeric= 1109 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)
            --when tmp_deducion_obrero.co_descto::numeric= 1111 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)--excepcion(igual que el 111
            --when tmp_deducion_obrero.co_descto::numeric= 1113 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)--valor(texto escolares)
            --when tmp_deducion_obrero.co_descto::numeric= 1114 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)--valor(juguetes)
            --when tmp_deducion_obrero.co_descto::numeric= 1115 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)--monto retroactivo(sumar gn801)
            --when tmp_deducion_obrero.co_descto::numeric= 1116 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)--excepcion(embargo bono especial no esta en el maestro)
            --when tmp_deducion_obrero.co_descto::numeric= 1666 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)--excepcion(fideicomiso no esta en el maestro)
            --when tmp_deducion_obrero.co_descto::numeric= 2102 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)--monto bono fin de año mismo 102
            --when tmp_deducion_obrero.co_descto::numeric= 2113 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)--valor mismo 1113
            --when tmp_deducion_obrero.co_descto::numeric= 2114 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)--valor mismo 1114
            --when tmp_deducion_obrero.co_descto::numeric= 2115 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)--monto retroactivo--mismo que 1115
            --when tmp_deducion_obrero.co_descto::numeric= 2911 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)--monto vacasiones = fn1 28
            when tmp_deducion_obrero.co_descto::numeric= 9112 then coalesce(monto::numeric,0)
            --when tmp_deducion_obrero.co_descto::numeric= 9650 then coalesce(monto::numeric,0)*coalesce(cantidad::numeric,0)--monto cestaticket no esta en el maestro

            else
            coalesce(0,0)

            end 


            ),2) + (select round(  --((asignacion_1 + asignacion_15 * 2)/100) + 
            (((asignacion_1 + asignacion_15) * 0.5)/100) + 
            (((asignacion_1 + asignacion_15)* 4)/100) ,2) from tmp_maestro tmp where tmp.fictra = tmp_deducion_obrero.fictra) 
            as deducciones from tmp_deducion_obrero 
            left join tmp_maestro on tmp_maestro.fictra = tmp_deducion_obrero.fictra 
            --where tmp_deducion_obrero.fictra = '18247360'
            group by  tmp_deducion_obrero.fictra

            )
            as q2 on q1.fictra = q2.fictra";

        $con = Propel::getConnection();
        $stmt = $con->prepare($sql);
        $stmt->execute();

        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
            $i++;
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "data"      =>  $registros
        ));

        $this->setTemplate('storelista');
    }
}
