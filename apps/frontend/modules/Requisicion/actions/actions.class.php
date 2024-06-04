<?php

/**
 * autoRequisicion actions.
 * NombreClaseModel(Tb039Requisiciones)
 * NombreTabla(tb039_requisiciones)
 * @package    ##PROJECT_NAME##
 * @subpackage autoRequisicion
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class RequisicionActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "co_rol"            => $this->getUser()->getAttribute('rol'),
            "co_usuario"        => $this->getUser()->getAttribute('codigo'),
            "in_activo"         => $this->getUser()->getAttribute('in_activo'),
            "tx_tipo_solicitud" => $this->getRequestParameter("tx_tipo_solicitud"),
            "co_tipo_solicitud" => $this->getRequestParameter("co_tipo_solicitud"),
            "tx_url"            => $this->getRequestParameter("tx_url"),

        ));

        $this->getRequest()->setAttribute('in_activo', $this->getUser()->getAttribute('in_activo'));
    }

    public function executeNuevo(sfWebRequest $request)
    {
        $this->forward('Requisicion', 'editar');
    }

    public function executeFiltro(sfWebRequest $request)
    {
    }

    public function executeAgregarProducto(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("codigo");
        if ($codigo != '' || $codigo != null) {
            $c = new Criteria();
            $c->add(Tb039RequisicionesPeer::CO_REQUISICION, $codigo);

            $stmt = Tb039RequisicionesPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->data = json_encode(array(
                "co_requisicion"     => $campos["co_requisicion"],
                "co_tipo_solicitud"  => $campos["co_tipo_solicitud"],
                "co_usuario"         => $campos["co_usuario"],
                "co_ente"            => $campos["co_ente"],
                "created_at"         => $campos["created_at"],
                "tx_concepto"        => $campos["tx_concepto"],
                "tx_observacion"     => $campos["tx_observacion"],
            ));
        } else {
            $this->data = json_encode(array(
                "co_requisicion"     => "",
                "co_tipo_solicitud"  => "",
                "co_usuario"         => "",
                "co_ente"            => "",
                "fe_registro"        => date("d-m-Y"),
                "tx_concepto"        => "",
                "tx_observacion"     => "",
            ));
        }
    }

    public function getDatosSolicitante($codigo)
    {

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb001UsuarioPeer::CO_USUARIO);
        $c->addSelectColumn(Tb001UsuarioPeer::NB_USUARIO);
        $c->addSelectColumn(Tb047EntePeer::TX_ENTE);
        $c->addSelectColumn(Tb047EntePeer::CO_ENTE);
        $c->addJoin(Tb001UsuarioPeer::CO_ENTE, Tb047EntePeer::CO_ENTE);
        $c->add(Tb001UsuarioPeer::CO_USUARIO, $codigo);
        $stmt = Tb001UsuarioPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
    }


    public function getDatosSolicitud($codigo)
    {

        $c = new Criteria();
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $codigo);
        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
    }


    public function executeServicio(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->add(Tb039RequisicionesPeer::CO_SOLICITUD, $codigo);
        $stmt = Tb039RequisicionesPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($campos["co_requisicion"] != '') {

            $datos = $this->getDatosSolicitante($campos["co_usuario"]);

            list($anio, $mes, $dia) = explode("-", $campos["created_at"]);

            $this->data = json_encode(array(
                "co_requisicion"     => $campos["co_requisicion"],
                "co_solicitud"       => $campos["co_solicitud"],
                "nb_solicitante"     => $datos["nb_usuario"],
                "co_servicio"        => $campos["co_servicio"],
                "tx_entidad"         => $datos["tx_ente"],
                "co_tipo_solicitud"  => $campos["co_tipo_solicitud"],
                "co_usuario"         => $campos["co_usuario"],
                "co_ente"            => $campos["co_ente"],
                "fe_registro"        => $dia . '-' . $mes . '-' . $anio,
                "tx_concepto"        => $campos["tx_concepto"],
                "tx_observacion"     => $campos["tx_observacion"],
            ));
        } else {


            $datos = $this->getDatosSolicitante($this->getUser()->getAttribute('codigo'));


            $this->data = json_encode(array(
                "co_requisicion"     => "",
                "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                "nb_solicitante"     => $datos["nb_usuario"],
                "tx_entidad"         => $datos["tx_ente"],
                "fe_registro"        => date("d-m-Y"),
                "co_usuario"         => $datos["co_usuario"],
                "tx_concepto"        => "",
                "co_servicio"        => "",
                "tx_observacion"     => "",
                "co_ente"            =>  $datos["co_ente"]
            ));
        }
    }

    public function executeEditar(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");

        $co_solicitud = $this->getDatosSolicitud($this->getRequestParameter("co_solicitud"));

        $c = new Criteria();
        $c->add(Tb039RequisicionesPeer::CO_SOLICITUD, $codigo);
        $stmt = Tb039RequisicionesPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($campos["co_requisicion"])) {

            $datos = $this->getDatosSolicitante($campos["co_usuario"]);

            list($anio, $mes, $dia) = explode("-", $campos["fe_registro"]);

            $this->data = json_encode(array(
                "co_requisicion"     => $campos["co_requisicion"],
                "co_solicitud"       => $campos["co_solicitud"],
                "nb_solicitante"     => $datos["nb_usuario"],
                "tx_entidad"         => $datos["tx_ente"],
                "co_tipo_solicitud"  => $campos["co_tipo_solicitud"],
                "co_usuario"         => $campos["co_usuario"],
                "co_ente"            => $campos["co_ente"],
                "fe_registro"        => $dia . '-' . $mes . '-' . $anio,
                "tx_concepto"        => $campos["tx_concepto"],
                "tx_observacion"     => $campos["tx_observacion"],
                "nu_requisicion"     => $campos["nu_requisicion"],
                "nu_iva"             => $campos["nu_iva"],
            ));
        } else {


            $datos = $this->getDatosSolicitante($this->getUser()->getAttribute('codigo'));

            list($anio, $mes, $dia) = explode("-", $co_solicitud["fe_registro"]);

            $this->data = json_encode(array(
                "co_requisicion"     => "",
                "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                "nb_solicitante"     => $datos["nb_usuario"],
                "tx_entidad"         => $datos["tx_ente"],
                "fe_registro"        => date("Y-m-d"),
//                "fe_registro"        => $dia . '-' . $mes . '-' . $anio,
                "co_usuario"         => $datos["co_usuario"],
                "tx_concepto"        => $co_solicitud["tx_observacion"],
                "tx_observacion"     => "",
                "co_ente"            =>  $datos["co_ente"],
                "nu_requisicion"     => ""
            ));
        }
    }

    public function executeGuardar(sfWebRequest $request)
    {

        $codigo         = $this->getRequestParameter("co_requisicion");
        $json_producto  = $this->getRequestParameter("json_producto");

        $tb039_requisicionesForm = $this->getRequestParameter('tb039_requisiciones');

        $con = Propel::getConnection();
        if ($codigo != '' || $codigo != null) {
            $tb039_requisiciones = Tb039RequisicionesPeer::retrieveByPk($codigo);
        } else {

            $tb026_solicitudForm = array(
                "co_tipo_solicitud"   => 61,
                "ejercicio"           => $this->getUser()->getAttribute('ejercicio'),
                "fe_solicitud"        => date("d/m/Y"),
                "observacion"         => $tb039_requisicionesForm["tx_observacion"],
                "codigo"              =>  $this->getUser()->getAttribute('codigo')
            );

            $resp = Tb026SolicitudPeer::setSolicitud($tb026_solicitudForm);

            if ($resp["success"] == true) {
                $tb039_requisicionesForm["co_solicitud"]        = $resp["co_solicitud"];
                $tb039_requisicionesForm["co_tipo_solicitud"]   = 61;
            }


            $tb039_requisiciones = new Tb039Requisiciones();
            $tb039_requisiciones->setCoUsuario($this->getUser()->getAttribute('codigo'));
            $tb039_requisiciones->setCoEnte($tb039_requisicionesForm["co_ente"]);
            $tb039_requisiciones->setCoTipoSolicitud($tb039_requisicionesForm["co_tipo_solicitud"]);
            $tb039_requisiciones->setCoSolicitud($tb039_requisicionesForm["co_solicitud"]);


            $c = new Criteria();
            //$c->add(Tb039RequisicionesPeer::NU_ANIO,date('Y'));
            $c->add(Tb039RequisicionesPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));
            $cantidad = Tb039RequisicionesPeer::doCount($c);
            $cantidad += 1;

            //$tb039_requisiciones->setNuAnio(date('Y'));
            $tb039_requisiciones->setNuAnio($this->getUser()->getAttribute('ejercicio'));
            //$tb039_requisiciones->setNuRequisicion(date('Y').$cantidad);
            $tb039_requisiciones->setNuRequisicion($this->getUser()->getAttribute('ejercicio') . $cantidad);
            //$tb039_requisiciones->setFeRegistro($tb039_requisicionesForm["fe_registro"]); 
            if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                //$tb039_requisiciones->setFeRegistro($this->getUser()->getAttribute('fe_cierre')); 
                $tb039_requisiciones->setFeRegistro($tb039_requisicionesForm["fe_registro"]);
            } else {
                $tb039_requisiciones->setFeRegistro(date("Y-m-d"));
            }
        }
        try {
            $con->beginTransaction();

            $tb039_requisiciones->setTxConcepto($tb039_requisicionesForm["tx_concepto"]);
            $tb039_requisiciones->setTxObservacion($tb039_requisicionesForm["tx_observacion"]);
            $tb039_requisiciones->setCoServicio($tb039_requisicionesForm["co_servicio"]);
            $tb039_requisiciones->save($con);

            $listaProducto  = json_decode($json_producto, true);
            $array_producto = array();
            $i = 0;

            foreach ($listaProducto  as $productoForm) {

                if ($productoForm["co_detalle_requisicion"] == '') {

                    $tb051_detalle_requision_producto = new Tb051DetalleRequisionProducto();
                    $tb051_detalle_requision_producto->setCoProducto($productoForm["co_producto"])
                        ->setCoRequisicion($tb039_requisiciones->getCoRequisicion())
                        ->setNuCantidad($productoForm["nu_cantidad"])
                        ->setCoUnidadProducto($productoForm["co_unidad_producto"])
                        ->setTxObservacion($productoForm["tx_observacion"])
                        ->save($con);
                }
            }


            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb039_requisicionesForm["co_solicitud"]));
            $ruta->setInCargarDato(true)->save($con);
            $con->commit();

            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Modificación realizada exitosamente'

            ));
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
        $codigo = $this->getRequestParameter("co_requisicion");
        $con = Propel::getConnection();
        try {
            $con->beginTransaction();
            /*CAMPOS*/
            $tb039_requisiciones = Tb039RequisicionesPeer::retrieveByPk($codigo);
            $tb039_requisiciones->delete($con);
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
        $c->addSelectColumn(Tb039RequisicionesPeer::TX_CONCEPTO);
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
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb039RequisicionesPeer::CO_SOLICITUD,  Criteria::JOIN);

        $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, 61);
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

    //modelo fk tb027_tipo_solicitud.CO_TIPO_SOLICITUD
    public function executeStorefkcoservicio(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb050ServicioPeer::doSelectStmt($c);
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

    public function executeEliminarMaterial(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("co_detalle_requisicion");
        $co_solicitud = $this->getRequestParameter("co_solicitud");

        $con = Propel::getConnection();
        try {
            $con->beginTransaction();
            /*CAMPOS*/
            $Tb051DetalleRequisionProducto = Tb051DetalleRequisionProductoPeer::retrieveByPk($codigo);
            $co_requisicion = $Tb051DetalleRequisionProducto->getCoRequisicion();
            $Tb051DetalleRequisionProducto->delete($con);


            $c = new Criteria();
            $c->add(Tb051DetalleRequisionProductoPeer::CO_REQUISICION, $co_requisicion);
            $cant = Tb051DetalleRequisionProductoPeer::doCount($c);

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));

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

    public function executeStorelistamateriales(sfWebRequest $request)
    {

        $co_requisicion   =   $this->getRequestParameter("co_requisicion");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb051DetalleRequisionProductoPeer::CO_DETALLE_REQUISICION);
        $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        $c->addSelectColumn(Tb051DetalleRequisionProductoPeer::TX_OBSERVACION);
        $c->addSelectColumn(Tb051DetalleRequisionProductoPeer::NU_CANTIDAD);
        $c->addSelectColumn(Tb057UnidadProductoPeer::TX_UNIDAD_PRODUCTO);

        $c->addJoin(Tb051DetalleRequisionProductoPeer::CO_UNIDAD_PRODUCTO, Tb057UnidadProductoPeer::CO_UNIDAD_PRODUCTO);
        $c->addJoin(Tb051DetalleRequisionProductoPeer::CO_PRODUCTO, Tb048ProductoPeer::CO_PRODUCTO);
        $c->add(Tb051DetalleRequisionProductoPeer::CO_REQUISICION, $co_requisicion);

        $cantidadTotal = Tb051DetalleRequisionProductoPeer::doCount($c);

        $c->addAscendingOrderByColumn(Tb048ProductoPeer::TX_PRODUCTO);


        $stmt = Tb048ProductoPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $reg["tx_observacion"] = strtoupper($reg["tx_observacion"]);
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));

        $this->setTemplate('store');
    }

    public function executeStorefkcoproducto(sfWebRequest $request)
    {

        $limit      =   $this->getRequestParameter("limit", 5);
        $start      =   $this->getRequestParameter("start", 0);
        $codigo     =   $this->getRequestParameter("codigo");
        $producto   =   $this->getRequestParameter("producto");

        $json_producto  = $this->getRequestParameter("lista_producto");


        $listaProducto  = json_decode($json_producto, true);
        $array_producto = array();
        $i = 0;
        foreach ($listaProducto  as $productoForm) {
            $array_producto[$i] = $productoForm["co_producto"];
            $i++;
        }

        $c = new Criteria();
        $c->setIgnoreCase(true);
        $c->add(Tb048ProductoPeer::CO_PRODUCTO, $array_producto,  Criteria::NOT_IN);

        if ($codigo != '') {
            $c->add(Tb048ProductoPeer::COD_PRODUCTO, '%' . $codigo . '%', Criteria::LIKE);
        }
        if ($producto != '') {
        $multiple_producto = preg_split('/\s+/', $producto, -1, PREG_SPLIT_NO_EMPTY); 


          foreach ($multiple_producto as $value) {
            $c->addOr(Tb048ProductoPeer::TX_PRODUCTO, '%' . $value . '%', Criteria::ILIKE);
          }        
        }
        $cantidadTotal = Tb048ProductoPeer::doCount($c);

        $c->clearSelectColumns();
        $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        //$c->addSelectColumn(Tb057UnidadProductoPeer::TX_UNIDAD_PRODUCTO);        
        // $c->addJoin(Tb048ProductoPeer::CO_UNIDAD_PRODUCTO, Tb057UnidadProductoPeer::CO_UNIDAD_PRODUCTO);
        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb048ProductoPeer::TX_PRODUCTO);


        $stmt = Tb048ProductoPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));
        $this->setTemplate('store');
    }

    //modelo fk tb012_tipo_cuenta_bancaria.CO_TIPO_CUENTA
    public function executeStorefkcounidadproducto(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb057UnidadProductoPeer::TX_UNIDAD_PRODUCTO);
        $stmt = Tb057UnidadProductoPeer::doSelectStmt($c);
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
