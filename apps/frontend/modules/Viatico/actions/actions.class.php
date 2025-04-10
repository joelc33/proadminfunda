<?php

/**
 * autoViatico actions.
 * NombreClaseModel(Tb108Viatico)
 * NombreTabla(tb108_viatico)
 * @package    ##PROJECT_NAME##
 * @subpackage autoViatico
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class ViaticoActions extends sfActions
{

    public function executeIndex(sfWebRequest $request)
    {
        $this->forward('Viaticoss', 'lista');
    }

    public function executeAgregar(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_detalle_viatico");
        $c = new Criteria();
        $c->add(Tb117DetalleViaticoPeer::CO_DETALLE_VIATICO, $codigo);
        $stmt = Tb117DetalleViaticoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
            "co_detalle_viatico"    => $campos["co_detalle_viatico"],
            "co_solicitud"          => $campos["co_solicitud"],
            "co_item_viatico"       => $campos["co_item_viatico"],
            "tx_observacion"        => $campos["tx_observacion"],
            "mo_dia"                => $campos["mo_dia"],
            "mo_total"              => $campos["mo_total"],
            "cant_dia"              => $campos["cant_dia"],
            "cant_ut"               => $campos["cant_ut"],
            "mo_ut"                 => $campos["mo_ut"],
            "co_solicitud_anular"   => $campos["co_solicitud_anular"],
            "in_anular"             => $campos["in_anular"]
        ));

        //var_dump($this->data); exit();
    }

    public function executeNuevo(sfWebRequest $request)
    {
        $this->forward('Viaticoss', 'editar');
    }

    public function executeFiltro(sfWebRequest $request)
    {
    }


    public function executeGuardarDetalleViatico(sfWebRequest $request)
    {

        $co_detalle_viatico = $this->getRequestParameter("co_detalle_viatico");
        $mo_total           = $this->getRequestParameter("mo_total");

        $con = Propel::getConnection();
        $tb117_detalle_viatico = Tb117DetalleViaticoPeer::retrieveByPk($co_detalle_viatico);
        $tb117_detalle_viatico->setMoTotal($mo_total);
        $tb117_detalle_viatico->save($con);
        $this->data = json_encode(array(
            "success" => true,
            "msg" => 'Modificación realizada exitosamente'
        ));

        $con->commit();

        $this->setTemplate('guardar');
    }

    public function executeEditar(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");
        if ($codigo != '' || $codigo != null) {
            $c = new Criteria();
            $c->add(Tb108ViaticoPeer::CO_SOLICITUD, $codigo);

            $stmt = Tb108ViaticoPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $datos = Tb026SolicitudPeer::retrieveByPK($codigo);


            $this->data = json_encode(array(
                "co_viatico"                => $campos["co_viatico"],
                "co_tipo_viatico"           => $campos["co_tipo_viatico"],
                "tx_evento"                 => $campos["tx_evento"],
                "tx_direccion"              => $campos["tx_direccion"],
                "in_empleado"               => $campos["in_empleado"],
                "co_origen"                 => $campos["co_origen"],
                "co_destino"                => $campos["co_destino"],
                "fe_desde"                  => $campos["fe_desde"],
                "fe_hasta"                  => $campos["fe_hasta"],
                "in_hospedaje"              => $campos["in_hospedaje"],
                "tx_observacion_hospedaje"  => $campos["tx_observacion_hospedaje"],
                "co_tipo_traslado"          => $campos["co_tipo_traslado"],
                "co_solicitud"              => $this->getRequestParameter("co_solicitud"),
                "co_proveedor"              => $campos["co_proveedor"],
                "co_categoria"              => $campos["co_categoria"],
                "co_ente"                   => $campos["co_ente"],
                "fecha"                     => $datos->getFeRegistro()
            ));
        } else {
            $this->data = json_encode(array(
                "co_viatico"                => "",
                "co_tipo_viatico"           => "",
                "tx_evento"                 => "",
                "tx_direccion"              => "",
                "in_empleado"               => "",
                "co_origen"                 => "",
                "co_destino"                => "",
                "fe_desde"                  => "",
                "fe_hasta"                  => "",
                "in_hospedaje"              => "",
                "tx_observacion_hospedaje"  => "",
                "co_tipo_traslado"          => "",
                "co_proveedor"              => "",
                "co_solicitud"              => $this->getRequestParameter("co_solicitud"),
                "co_categoria"              => "",
                "co_ente"                   => ""
            ));
        }
    }

    protected function dateDiff($start, $end)
    {

        $start_ts = strtotime($start);

        $end_ts = strtotime($end);

        $diff = $end_ts - $start_ts;

        $cant = round($diff / 86400);

        return ($cant == 0) ? 1 : $cant;
    }

    public function executeGuardar(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("co_viatico");
        $co_proveedor = $this->getRequestParameter("co_proveedor");
        $json_detalle = $this->getRequestParameter("json_detalle");
        $tb109_personaForm = $this->getRequestParameter('tb109_persona');
        $tb008_proveedor = Tb008ProveedorPeer::retrieveByPk($co_proveedor);
        $tb108_viaticoForm = $this->getRequestParameter('tb108_viatico');

        //list($dia,$mes,$anio) = explode("/",$tb109_personaForm["fecha"]);
        $fecha = $tb109_personaForm["fecha"];

        $con = Propel::getConnection();
        if ($codigo != '' || $codigo != null) {
            $tb108_viatico = Tb108ViaticoPeer::retrieveByPk($codigo);
        } else {
            $tb108_viatico = new Tb108Viatico();

            if (empty($tb108_viaticoForm["co_solicitud"])) {               

                $tb026_solicitudForm = array(
                    "co_tipo_solicitud"   => 22,
                    "ejercicio"           => $this->getUser()->getAttribute('ejercicio'),
                    "fe_solicitud"        => $fecha,
                    "observacion"         => $tb108_viaticoForm["tx_evento"],
                    "codigo"              => $this->getUser()->getAttribute('codigo')
                );

                $resp = Tb026SolicitudPeer::setSolicitud($tb026_solicitudForm,$con);
              
                if ($resp["success"] == true) {
                    $tb108_viaticoForm["co_solicitud"] = $resp["co_solicitud"];
                }
            }
        }
        try {
            $con->beginTransaction();

            if ($tb108_viaticoForm["co_origen"] == $tb108_viaticoForm["co_destino"]) {
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El Origen y el Destino no pueden ser el mismo, por favor verifique'
                ));

                return;
            }

            $cp = new Criteria();
            $cp->add(Tb109PersonaPeer::CO_PROVEEDOR, $co_proveedor);
            $cant = Tb109PersonaPeer::doCount($cp);

            if ($cant == 0) {
                $tb109_persona   = new Tb109Persona();
            } else {
                $tb109_persona   = Tb109PersonaPeer::retrieveByPk($co_proveedor);
            }

            $tb109_persona->setCoProveedor($tb008_proveedor->getCoProveedor());
            $tb109_persona->setCoCargo($tb109_personaForm["co_cargo"]);
            $tb109_persona->setNuCelular($tb109_personaForm["nu_celular"]);
            $tb109_persona->setNuExtension($tb109_personaForm["nu_extension"]);
            $tb109_persona->save($con);


            $tb108_viatico->setCoTipoViatico($tb108_viaticoForm["co_tipo_viatico"]);
            $tb108_viatico->setTxEvento($tb108_viaticoForm["tx_evento"]);
            $tb108_viatico->setTxDireccion($tb108_viaticoForm["tx_direccion"]);
            $tb108_viatico->setCoEnte($tb108_viaticoForm["co_ente"]);

            if (array_key_exists("in_empleado", $tb108_viaticoForm)) {
                $tb108_viatico->setInEmpleado(true);
            } else {
                $tb108_viatico->setInEmpleado(false);
            }

            $tb108_viatico->setCoOrigen($tb108_viaticoForm["co_origen"]);
            $tb108_viatico->setCoDestino($tb108_viaticoForm["co_destino"]);

            list($dia, $mes, $anio) = explode("/", $tb108_viaticoForm["fe_desde"]);
            $fecha_desde = $anio . "-" . $mes . "-" . $dia;
            $tb108_viatico->setFeDesde($fecha_desde);

            list($dia, $mes, $anio) = explode("/", $tb108_viaticoForm["fe_hasta"]);
            $fecha_hasta = $anio . "-" . $mes . "-" . $dia;
            $tb108_viatico->setFeHasta($fecha_hasta);
            $tb108_viatico->setCoSolicitud($tb108_viaticoForm["co_solicitud"]);
            $tb108_viatico->setCoCategoria($tb108_viaticoForm["co_categoria"]);
            $tb108_viatico->setCoUsuario($this->getUser()->getAttribute('codigo'));
            $tb108_viatico->setCoProveedor($co_proveedor);

            list($dia,$mes,$anio) = explode("/",$tb109_personaForm["fecha"]);
            $fecha = $anio."-".$mes."-".$dia;

            $tb026_solicitud = Tb026SolicitudPeer::retrieveByPK($tb108_viaticoForm["co_solicitud"]);
            $tb026_solicitud->setFeRegistro($fecha);
            $tb026_solicitud->setCoProveedor($tb008_proveedor->getCoProveedor())->save($con);

            $wherec = new Criteria();
            $wherec->add(Tb117DetalleViaticoPeer::CO_SOLICITUD, $tb108_viaticoForm["co_solicitud"], Criteria::EQUAL);
            BasePeer::doDelete($wherec, $con);


            $listaItem  = json_decode($json_detalle, true);
            $array = array();
            $i = 0;
            foreach ($listaItem  as $v) {


                $Tb117DetalleViatico = new Tb117DetalleViatico();
                $cant_dia = $this->dateDiff($fecha_desde, $fecha_hasta);
                $valor_ut = Tb118UnidadTributariaPeer::getUT();

                $mo_total = 0; //$v["cant_ut"] * $cant_dia * $valor_ut;

                $Tb117DetalleViatico->setCoSolicitud($tb108_viaticoForm["co_solicitud"])
                    ->setCoItemViatico($v["co_item_viatico"])
                    ->setTxObservacion($v["tx_observacion"])
                    ->setCantDia($cant_dia)
                    ->setCantUt($v["cant_ut"])
                    ->setMoTotal($mo_total)
                    ->save($con);
                $i++;
            }

            if ($i > 0) {
                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb108_viaticoForm["co_solicitud"]));
                $co_ruta = $ruta->getCoRuta();
                $ruta->setInCargarDato(true)->save($con);
            } else {
                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb108_viaticoForm["co_solicitud"]));
                $ruta->setInCargarDato(false)->save($con);
            }


            $tb108_viatico->save($con);
            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Modificación realizada exitosamente'
            ));

            $con->commit();
            Tb030RutaPeer::getGenerarReporte($co_ruta);
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }
    }


    public function executeEliminar(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_detalle_viatico");
        $con = Propel::getConnection();
        try {
            $con->beginTransaction();
            /*CAMPOS*/
            $Tb117DetalleViatico = Tb117DetalleViaticoPeer::retrieveByPk($codigo);
            $Tb117DetalleViatico->delete($con);
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
        $this->data = json_encode(array(
            "co_rol"            => $this->getUser()->getAttribute('rol'),
            "co_usuario"        => $this->getUser()->getAttribute('codigo'),
            "in_activo"         => $this->getUser()->getAttribute('in_activo'),
            "tx_tipo_solicitud" => $this->getRequestParameter("tx_tipo_solicitud"),
            "co_tipo_solicitud" => 22,
            "tx_url"            => $this->getRequestParameter("tx_url"),

        ));

        $this->getRequest()->setAttribute('in_activo', $this->getUser()->getAttribute('in_activo'));
    }

    public function executeAgregarAsignacion(sfWebRequest $request)
    {
    }

    public function executeEliminarAsignacion(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("co_detalle_compras");

        $con = Propel::getConnection();
        try {
            $con->beginTransaction();
            /*CAMPOS*/
            $Tb053DetalleCompra = Tb053DetalleComprasPeer::retrieveByPk($codigo);
            $co_compras = $Tb053DetalleCompra->getCoCompras();
            $montod = $Tb053DetalleCompra->getMonto();
            $co_partida = $Tb053DetalleCompra->getCoPresupuesto();


//            Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $Tb053DetalleCompra->getCoPresupuesto(), 4, $Tb053DetalleCompra->getMonto(), '', $Tb053DetalleCompra->getCoDetalleCompras());
//            Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $Tb053DetalleCompra->getCoPresupuesto(), 13, $Tb053DetalleCompra->getMonto(), '', $Tb053DetalleCompra->getCoDetalleCompras());

            $wherec = new Criteria();
            $wherec->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $codigo, Criteria::EQUAL);
            BasePeer::doDelete($wherec, $con);
            
            $Tb053DetalleCompra->setCoPresupuesto(null);
            $Tb053DetalleCompra->save($con);



          /*  $montod = $montod * (-1);

            $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
            $tb087_presupuesto_movimiento->setCoPartida($co_partida)
                ->setCoTipoMovimiento(4)
                ->setNuMonto($montod)
                //->setNuAnio(date('Y'))
                ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                ->setCoDetalleCompra($codigo)
                ->setInActivo(true)
                ->save($con);
            */


            $c = new Criteria();
            $c->add(Tb053DetalleComprasPeer::CO_COMPRAS, $co_compras);
            $c->add(Tb053DetalleComprasPeer::CO_PRESUPUESTO, null, Criteria::ISNOTNULL);
            $cant = Tb053DetalleComprasPeer::doCount($c);

            $Tb052Compra = Tb052ComprasPeer::retrieveByPk($co_compras);

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($Tb052Compra->getCoSolicitud()));

            if ($cant > 0) {
                $ruta->setInCargarDato(true)->save($con);
            } else {
                $ruta->setInCargarDato(false)->save($con);
            }


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
                "msg" => 'Este registro no se puede borrar'
            ));
        }

        $this->setTemplate('eliminar');
    }

    public function executeStorelistaDetalle(sfWebRequest $request)
    {

        $co_solicitud      = $this->getRequestParameter("co_solicitud");
        $co_tipo_viatico = $this->getRequestParameter("co_tipo_viatico");
        $co_categoria      = $this->getRequestParameter("co_categoria");

        if ($co_solicitud == '') {
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb114ItemViaticoPeer::CO_ITEM_VIATICO);
            $c->addSelectColumn(Tb114ItemViaticoPeer::TX_ITEM_VIATICO);
            $c->addSelectColumn(Tb119CategoriaItemViaticoPeer::CANT_UT);
            $c->addJoin(Tb119CategoriaItemViaticoPeer::CO_ITEM_VIATICO, Tb114ItemViaticoPeer::CO_ITEM_VIATICO);
            $c->add(Tb119CategoriaItemViaticoPeer::CO_CATEGORIA, $co_categoria);
            $c->add(Tb119CategoriaItemViaticoPeer::CO_TIPO_VIATICO, $co_tipo_viatico);

            $c->addAscendingOrderByColumn(Tb114ItemViaticoPeer::CO_ITEM_VIATICO);

            $stmt = Tb114ItemViaticoPeer::doSelectStmt($c);
            $registros = "";
            while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $registros[] = $res;
            }
        } else {
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb117DetalleViaticoPeer::CO_DETALLE_VIATICO);
            $c->addSelectColumn(Tb114ItemViaticoPeer::CO_ITEM_VIATICO);
            $c->addSelectColumn(Tb114ItemViaticoPeer::TX_ITEM_VIATICO);
            $c->addSelectColumn(Tb117DetalleViaticoPeer::TX_OBSERVACION);
            $c->addSelectColumn(Tb117DetalleViaticoPeer::CANT_UT);
            $c->addSelectColumn(Tb117DetalleViaticoPeer::CANT_DIA);
            $c->addSelectColumn(Tb117DetalleViaticoPeer::MO_TOTAL);
            $c->addJoin(Tb117DetalleViaticoPeer::CO_ITEM_VIATICO, Tb114ItemViaticoPeer::CO_ITEM_VIATICO);
            $c->add(Tb117DetalleViaticoPeer::CO_SOLICITUD, $co_solicitud);
            $cantidadTotal = Tb117DetalleViaticoPeer::doCount($c);

            $c->addAscendingOrderByColumn(Tb114ItemViaticoPeer::CO_ITEM_VIATICO);

            $stmt = Tb114ItemViaticoPeer::doSelectStmt($c);
            $registros = "";
            $valor_ut = Tb118UnidadTributariaPeer::getUT();
            while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

                //  $res["mo_total"] = $res["mo_total"]; //$res["cant_ut"] * $res["cant_dia"] * $valor_ut;

                $registros[] = $res;
            }
        }



        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));

        $this->setTemplate("storelista");
    }

    public function executeStorelistaviatico(sfWebRequest $request)
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
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb030RutaPeer::TX_RUTA_REPORTE);
        $c->addSelectColumn(Tb107TipoViaticoPeer::TX_TIPO_VIATICO);


        // $c->addJoin(Tb026SolicitudPeer::CO_PERSONA, Tb109PersonaPeer::CO_PERSONA,   Criteria::LEFT_JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR,   Criteria::LEFT_JOIN);
        $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO,  Tb007DocumentoPeer::CO_DOCUMENTO,   Criteria::LEFT_JOIN);
        // $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb060OrdenPagoPeer::CO_SOLICITUD,   Criteria::LEFT_JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD,  Criteria::JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD,  Criteria::JOIN);
        $c->addJoin(Tb030RutaPeer::CO_PROCESO, Tb028ProcesoPeer::CO_PROCESO,   Criteria::JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO,  Criteria::JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb108ViaticoPeer::CO_SOLICITUD,  Criteria::JOIN);
        $c->addJoin(Tb108ViaticoPeer::CO_TIPO_VIATICO, Tb107TipoViaticoPeer::CO_TIPO_VIATICO,  Criteria::JOIN);

        $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, 22);
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
                "tx_concepto"       => strtoupper(trim($res["tx_tipo_viatico"])),
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



    public function executeStorelista(sfWebRequest $request)
    {
        $paginar    =   $this->getRequestParameter("paginar");
        $limit      =   $this->getRequestParameter("limit", 20);
        $start      =   $this->getRequestParameter("start", 0);
        $co_tipo_viatico      =   $this->getRequestParameter("co_tipo_viatico");
        $tx_evento      =   $this->getRequestParameter("tx_evento");
        $tx_direccion      =   $this->getRequestParameter("tx_direccion");
        $in_empleado      =   $this->getRequestParameter("in_empleado");
        $co_origen      =   $this->getRequestParameter("co_origen");
        $co_destino      =   $this->getRequestParameter("co_destino");
        $fe_desde      =   $this->getRequestParameter("fe_desde");
        $fe_hasta      =   $this->getRequestParameter("fe_hasta");
        $in_hospedaje      =   $this->getRequestParameter("in_hospedaje");
        $tx_observacion_hospedaje      =   $this->getRequestParameter("tx_observacion_hospedaje");
        $co_tipo_traslado      =   $this->getRequestParameter("co_tipo_traslado");


        $c = new Criteria();

        if ($this->getRequestParameter("BuscarBy") == "true") {
            if ($co_tipo_viatico != "") {
                $c->add(Tb108ViaticoPeer::co_tipo_viatico, $co_tipo_viatico);
            }

            if ($tx_evento != "") {
                $c->add(Tb108ViaticoPeer::tx_evento, '%' . $tx_evento . '%', Criteria::LIKE);
            }

            if ($tx_direccion != "") {
                $c->add(Tb108ViaticoPeer::tx_direccion, '%' . $tx_direccion . '%', Criteria::LIKE);
            }


            if ($co_origen != "") {
                $c->add(Tb108ViaticoPeer::co_origen, $co_origen);
            }

            if ($co_destino != "") {
                $c->add(Tb108ViaticoPeer::co_destino, $co_destino);
            }


            if ($fe_desde != "") {
                list($dia, $mes, $anio) = explode("/", $fe_desde);
                $fecha = $anio . "-" . $mes . "-" . $dia;
                $c->add(Tb108ViaticoPeer::fe_desde, $fecha);
            }

            if ($fe_hasta != "") {
                list($dia, $mes, $anio) = explode("/", $fe_hasta);
                $fecha = $anio . "-" . $mes . "-" . $dia;
                $c->add(Tb108ViaticoPeer::fe_hasta, $fecha);
            }

            if ($tx_observacion_hospedaje != "") {
                $c->add(Tb108ViaticoPeer::tx_observacion_hospedaje, '%' . $tx_observacion_hospedaje . '%', Criteria::LIKE);
            }

            if ($co_tipo_traslado != "") {
                $c->add(Tb108ViaticoPeer::co_tipo_traslado, $co_tipo_traslado);
            }
        }
        $c->setIgnoreCase(true);
        $cantidadTotal = Tb108ViaticoPeer::doCount($c);

        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb108ViaticoPeer::CO_VIATICO);

        $stmt = Tb108ViaticoPeer::doSelectStmt($c);
        $registros = "";
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = array(
                "co_viatico"     => trim($res["co_viatico"]),
                "co_tipo_viatico"     => trim($res["co_tipo_viatico"]),
                "tx_evento"     => trim($res["tx_evento"]),
                "tx_direccion"     => trim($res["tx_direccion"]),
                "in_empleado"     => trim($res["in_empleado"]),
                "co_origen"     => trim($res["co_origen"]),
                "co_destino"     => trim($res["co_destino"]),
                "fe_desde"     => trim($res["fe_desde"]),
                "fe_hasta"     => trim($res["fe_hasta"]),
                "in_hospedaje"     => trim($res["in_hospedaje"]),
                "tx_observacion_hospedaje"     => trim($res["tx_observacion_hospedaje"]),
                "co_tipo_traslado"     => trim($res["co_tipo_traslado"]),
            );
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));
    }

    //modelo fk tb107_tipo_viatico.CO_TIPO_VIATICO
    public function executeStorefkcotipoviatico(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb107TipoViaticoPeer::doSelectStmt($c);
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
    //modelo fk tb110_origen_viatico.CO_ORIGEN_VIATICO
    public function executeStorefkcoorigen(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tb110OrigenViaticoPeer::CO_TIPO_VIATICO, $this->getRequestParameter("co_tipo_viatico"));
        $c->addAscendingOrderByColumn(Tb110OrigenViaticoPeer::TX_ORIGEN_VIATICO);
        $stmt = Tb110OrigenViaticoPeer::doSelectStmt($c);
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
    //modelo fk tb110_origen_viatico.CO_ORIGEN_VIATICO
    public function executeStorefkcodestino(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb110OrigenViaticoPeer::doSelectStmt($c);
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
    //modelo fk tb113_tipo_traslado.CO_TIPO_TRASLADO
    public function executeStorefkcocategoria(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb113CategoriaPeer::doSelectStmt($c);
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

    public function executeStorefkcoitemviatico(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb114ItemViaticoPeer::doSelectStmt($c);
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

    public function executeVerificarSolicitante(sfWebRequest $request)
    {

        $co_documento  = $this->getRequestParameter('co_documento');
        $tx_rif        = $this->getRequestParameter('tx_rif');
        $co_proveedor        = $this->getRequestParameter('co_proveedor');

        $c = new Criteria();
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb109PersonaPeer::CO_CARGO);
        $c->addSelectColumn(Tb109PersonaPeer::NU_CELULAR);
        $c->addSelectColumn(Tb109PersonaPeer::NU_EXTENSION);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb109PersonaPeer::CO_PROVEEDOR, Criteria::LEFT_JOIN);


        if ($co_documento != '' && $tx_rif != '') {
            $c->add(Tb008ProveedorPeer::CO_DOCUMENTO, $co_documento);
            $c->add(Tb008ProveedorPeer::TX_RIF, $tx_rif);
            $stmt = Tb008ProveedorPeer::doSelectStmt($c);
            $registros = $stmt->fetch(PDO::FETCH_ASSOC);
        } else if ($co_proveedor != '') {
            $c->add(Tb008ProveedorPeer::CO_PROVEEDOR, $co_proveedor);
            $stmt = Tb008ProveedorPeer::doSelectStmt($c);
            $registros = $stmt->fetch(PDO::FETCH_ASSOC);
        }



        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));

        $this->setTemplate('store');
    }

    public function executeStorefkcodocumento(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tb007DocumentoPeer::CO_DOCUMENTO, array(1,8), Criteria::IN);
        $stmt = Tb007DocumentoPeer::doSelectStmt($c);
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
}
