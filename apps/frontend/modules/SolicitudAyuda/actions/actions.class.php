<?php

/**
 * autoSolicitudAyuda actions.
 * NombreClaseModel(Tb126SolicitudAyuda)
 * NombreTabla(tb126_solicitud_ayuda)
 * @package    ##PROJECT_NAME##
 * @subpackage autoSolicitudAyuda
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class SolicitudAyudaActions extends sfActions
{

    public function executeIndex(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "co_rol" => $this->getUser()->getAttribute('rol'),
            "co_usuario" => $this->getUser()->getAttribute('codigo'),
            "in_activo" => $this->getUser()->getAttribute('in_activo'),
            "co_tipo_solicitud" => 26

        ));

        $this->getRequest()->setAttribute('in_activo', $this->getUser()->getAttribute('in_activo'));
    }

    public function executeIndexsinfactura(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "co_rol" => $this->getUser()->getAttribute('rol'),
            "co_usuario" => $this->getUser()->getAttribute('codigo'),
            "in_activo" => $this->getUser()->getAttribute('in_activo'),
            "co_tipo_solicitud" => 26

        ));

        $this->getRequest()->setAttribute('in_activo', $this->getUser()->getAttribute('in_activo'));
    }


    public function executeNuevo(sfWebRequest $request)
    {
        $this->forward('SolicitudAyuda', 'editar');
    }

    public function executeFiltro(sfWebRequest $request)
    {

    }

    public function executeFactura(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("co_solicitud");
        if ($codigo != '' || $codigo != null) {
            $c = new Criteria();
            $c->setIgnoreCase(true);
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
            $c->addSelectColumn(Tb052ComprasPeer::CO_SOLICITUD);
            $c->addSelectColumn(Tb052ComprasPeer::CO_PROVEEDOR);
            $c->addSelectColumn(Tb052ComprasPeer::TX_OBSERVACION);
            $c->addSelectColumn(Tb052ComprasPeer::CO_RAMO);
            $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
            $c->addSelectColumn(Tb008ProveedorPeer::CO_IVA_RETENCION);
            $c->addSelectColumn(Tb026SolicitudPeer::CO_TIPO_SOLICITUD);


            $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_SOLICITUD_AYUDA);
            $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_PROVEEDOR_SOLICITANTE);
            $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_TIPO_AYUDA);

            $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);
            $c->addJoin(Tb052ComprasPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
            $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD, Tb026SolicitudPeer::CO_SOLICITUD);
            $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD, Tb126SolicitudAyudaPeer::CO_SOLICITUD);


            $stmt = Tb052ComprasPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->data = json_encode(array(
                "co_solicitud_ayuda" => $campos["co_solicitud_ayuda"],
                "co_proveedor_solicitante" => $campos["co_proveedor_solicitante"],
                "co_tipo_ayuda" => $campos["co_tipo_ayuda"],
                "co_solicitud" => $this->getRequestParameter("co_solicitud"),
                "co_usuario" => $this->getUser()->getAttribute('codigo'),
                "fe_emision" => $campos["fe_emision"],
                "nu_base_imponible" => $campos["nu_base_imponible"],
                "co_iva_factura" => $campos["co_iva_factura"],
                "nu_iva_factura" => $campos["nu_iva_factura"],
                "nu_total" => $campos["nu_total"],
                "co_iva_retencion" => $campos["co_iva_retencion"],
                "nu_iva_retencion" => $campos["nu_iva_retencion"],
                "nu_total_retencion" => $campos["nu_total_retencion"],
                "total_pagar" => $campos["total_pagar"],
                "tx_concepto" => $campos["tx_concepto"],
                "co_compra" => $campos["co_compras"],
                //"co_solicitud"          => $campos["co_solicitud"],
                "co_proveedor" => $campos["co_proveedor"],
                "co_ramo" => $campos["co_ramo"],
                "co_iva" => $campos["co_iva"],
                "co_odp" => $campos["co_odp"],
                "nu_control" => $campos["nu_control"],
                "co_documento" => $campos["co_documento"],
                "tx_rif" => $campos["tx_rif"],
                "tx_razon_social" => $campos["tx_razon_social"],
                "tx_direccion" => $campos["tx_direccion"],
                "co_iva_retencion" => $campos["co_iva_retencion"],
                "id_tb048_producto" => $campos["id_tb048_producto"],
                "co_detalle_compras" => $campos["co_detalle_compras"],
                //"co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                "tx_observacion" => $campos["tx_observacion"],
                "co_ramo" => $campos["co_ramo"],
                "co_solicitud" => $this->getRequestParameter("co_solicitud"),
                "co_tipo_solicitud" => $this->getRequestParameter("co_tipo_solicitud"),
                "co_proceso" => $this->getRequestParameter("co_proceso")
            ));
        } else {

            $this->data = json_encode(array(
                "co_solicitud" => $this->getRequestParameter("co_solicitud"),
                "co_tipo_solicitud" => $this->getRequestParameter("co_tipo_solicitud"),
                "co_proceso" => $this->getRequestParameter("co_proceso")
            ));

        }

    }


    public function executeEditarResponsabilidad(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");
        $c = new Criteria();
        $c->add(Tb126SolicitudAyudaPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb126SolicitudAyudaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
            "co_solicitud_ayuda" => $campos["co_solicitud_ayuda"],
            "co_proveedor" => $campos["co_proveedor"],
            "co_proveedor_solicitante" => $campos["co_proveedor_solicitante"],
            "co_tipo_ayuda" => $campos["co_tipo_ayuda"],
            "tx_observacion" => $campos["tx_observacion"],
            "co_solicitud" => $this->getRequestParameter("co_solicitud"),
            "co_usuario" => $this->getUser()->getAttribute('codigo'),
            "fecha" => $campos["fe_resolucion"],
            "monto" => $campos["mo_total_ayuda"]
        ));

    }



    public function executeEditar(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");
        $c = new Criteria();
        $c->add(Tb126SolicitudAyudaPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb126SolicitudAyudaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
            "co_solicitud_ayuda" => $campos["co_solicitud_ayuda"],
            "co_proveedor" => $campos["co_proveedor"],
            "co_proveedor_solicitante" => $campos["co_proveedor_solicitante"],
            "co_tipo_ayuda" => $campos["co_tipo_ayuda"],
            "tx_observacion" => $campos["tx_observacion"],
            "co_solicitud" => $this->getRequestParameter("co_solicitud"),
            "co_usuario" => $this->getUser()->getAttribute('codigo')
        ));


    }

    protected function getProveedor($datos)
    {

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->add(Tb008ProveedorPeer::CO_DOCUMENTO, $datos["co_documento"]);
        $c->add(Tb008ProveedorPeer::TX_RIF, $datos["nu_cedula"]);
        $stmt = Tb008ProveedorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($campos["co_proveedor"] != '' || $campos["co_proveedor"] != null) {

            $tb008_proveedor = Tb008ProveedorPeer::retrieveByPk($campos["co_proveedor"]);

            $cp = new Criteria();
            $cp->add(Tb109PersonaPeer::CO_PROVEEDOR, $campos["co_proveedor"]);
            $cant = Tb109PersonaPeer::doCount($cp);

            if ($cant == 0) {
                $tb109_persona = new Tb109Persona();
            } else {
                $tb109_persona = Tb109PersonaPeer::retrieveByPk($campos["co_proveedor"]);
            }

            $co_proveedor = $tb008_proveedor->getCoProveedor();

        } else {
            $tb008_proveedor = new Tb008Proveedor();
            $tb109_persona = new Tb109Persona();

            $co_proveedor = $tb008_proveedor->getCoProveedor();

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn("MAX(" . Tb008ProveedorPeer::NU_CODIGO . ") as nu_proveedor");
            $stmt = Tb008ProveedorPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $correlativo = $campos["nu_proveedor"] + 1;
            $nu_codigo = str_pad($correlativo, 6, "0", STR_PAD_LEFT);
            ;

            $tb008_proveedor->setNuCodigo($nu_codigo);

        }


        $tb008_proveedor->setCoDocumento($datos["co_documento"]);
        $tb008_proveedor->setTxRazonSocial(strtoupper($datos["nb_persona"]));
        $tb008_proveedor->setTxRif($datos["nu_cedula"]);
        $tb008_proveedor->save($con);

        $tb109_persona->setCoProveedor($tb008_proveedor->getCoProveedor());
        $tb109_persona->setNuCedula($datos["nu_cedula"]);
        $tb109_persona->setCoDocumento($datos["co_documento"]);
        $tb109_persona->setNuCelular($datos["nu_celular"]);
        $tb109_persona->save($con);

        return $tb008_proveedor->getCoProveedor();
    }


    public function executeGuardar(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("co_solicitud_ayuda");
        $tb126_solicitud_ayudaForm = $this->getRequestParameter('tb126_solicitud_ayuda');

        $con = Propel::getConnection();
        if ($codigo != '' || $codigo != null) {
            $tb126_solicitud_ayuda = Tb126SolicitudAyudaPeer::retrieveByPk($codigo);
        } else {
            $tb126_solicitud_ayuda = new Tb126SolicitudAyuda();

            $tb026_solicitudForm = array(
                "co_tipo_solicitud" => 51,
                "ejercicio" => $this->getUser()->getAttribute('ejercicio'),
                "fe_solicitud" => date("d/m/Y"),
                "observacion" => $tb126_solicitud_ayudaForm["tx_observacion"],
                "codigo" => $this->getUser()->getAttribute('codigo')
            );

            $resp = Tb026SolicitudPeer::setSolicitud($tb026_solicitudForm, $con);

            if ($resp["success"] == true) {
                $tb126_solicitud_ayudaForm["co_solicitud"] = $resp["co_solicitud"];
            } else {
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => $resp["msg"]
                ));

                return;
            }
        }
        try {
            $con->beginTransaction();


            $receptorForm = $this->getRequestParameter('receptor');
            $solicitanteForm = $this->getRequestParameter('solicitante');

            $co_proveedor = $this->getProveedor($receptorForm, $con);
            $co_proveedor_solicitante = $this->getProveedor($solicitanteForm, $con);

            //Datos Receptor Cheque               
            $tb126_solicitud_ayuda->setCoProveedor($co_proveedor);
            $tb126_solicitud_ayuda->setCoProveedorSolicitante($co_proveedor_solicitante);
            $tb126_solicitud_ayuda->setCoTipoAyuda($tb126_solicitud_ayudaForm["co_tipo_ayuda"]);
            $tb126_solicitud_ayuda->setTxObservacion($tb126_solicitud_ayudaForm["tx_observacion"]);
            $tb126_solicitud_ayuda->setCoSolicitud($tb126_solicitud_ayudaForm["co_solicitud"]);
            $tb126_solicitud_ayuda->setCoUsuario($tb126_solicitud_ayudaForm["co_usuario"]);
            $tb126_solicitud_ayuda->setIdTb013AnioFiscal($this->getUser()->getAttribute('ejercicio'));

            $tb126_solicitud_ayuda->save($con);

            $solicitud = Tb026SolicitudPeer::retrieveByPk($tb126_solicitud_ayudaForm["co_solicitud"]);
            $solicitud->setCoProveedor($co_proveedor)->setCoProveedor($co_proveedor)->save($con);

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb126_solicitud_ayudaForm["co_solicitud"]));
            $ruta->setInCargarDato(true)->save($con);

            $con->commit();
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Modificación realizada exitosamente'
            ));
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage()
            ));
        }
    }

    public function executeGuardarSolicitud(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("co_solicitud_ayuda");
        $tb126_solicitud_ayudaForm = $this->getRequestParameter('tb126_solicitud_ayuda');

        $con = Propel::getConnection();
        if ($codigo != '' || $codigo != null) {
            $tb126_solicitud_ayuda = Tb126SolicitudAyudaPeer::retrieveByPk($codigo);
            
            $cc = new Criteria();
            $cc->add(Tb052ComprasPeer::CO_SOLICITUD, $tb126_solicitud_ayuda->getCoSolicitud());
            $stmt = Tb052ComprasPeer::doSelectStmt($cc);
            $datosCompra = $stmt->fetch(PDO::FETCH_ASSOC);

            $tb052_compras = Tb052ComprasPeer::retrieveByPK($datosCompra["co_compras"]);

            $cdc = new Criteria();
            $cdc->add(Tb053DetalleComprasPeer::CO_COMPRAS, $datosCompra["co_compras"]);
            $stmt = Tb053DetalleComprasPeer::doSelectStmt($cdc);
            $datosDetalleCompra = $stmt->fetch(PDO::FETCH_ASSOC);

            $tb053_detalle_compras =  Tb053DetalleComprasPeer::retrieveByPK($datosDetalleCompra["co_detalle_compras"]);

        } else {
            $tb126_solicitud_ayuda = new Tb126SolicitudAyuda();

            $tb026_solicitudForm = array(
                "co_tipo_solicitud" => 25,
                "ejercicio" => $this->getUser()->getAttribute('ejercicio'),
                "fe_solicitud" => $tb126_solicitud_ayudaForm["fe_solicitud"],
                "observacion" => $tb126_solicitud_ayudaForm["tx_observacion"],
                "codigo" => $this->getUser()->getAttribute('codigo')
            );

            $resp = Tb026SolicitudPeer::setSolicitud($tb026_solicitudForm, $con);

            if ($resp["success"] == true) {
                $tb126_solicitud_ayudaForm["co_solicitud"] = $resp["co_solicitud"];
                $tb052_compras = new Tb052Compras();
                $tb053_detalle_compras = new Tb053DetalleCompras();
            } else {
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => $resp["msg"]
                ));

                return;
            }
        }
        try {
            $con->beginTransaction();

            $receptorForm = $this->getRequestParameter('receptor');
            $solicitanteForm = $this->getRequestParameter('solicitante');

            $co_proveedor = $this->getProveedor($receptorForm, $con);
            $co_proveedor_solicitante = $this->getProveedor($solicitanteForm, $con);

            $mo_total = $tb126_solicitud_ayudaForm["monto"];

            list($dia, $mes, $anio) = explode("/", $tb126_solicitud_ayudaForm["fe_solicitud"]);
            $fecha = $anio . '-' . $mes . '-' . $dia;
            //Datos Receptor Cheque               
            $tb126_solicitud_ayuda->setCoProveedor($co_proveedor);
            $tb126_solicitud_ayuda->setCoProveedorSolicitante($co_proveedor_solicitante);
            $tb126_solicitud_ayuda->setCoTipoAyuda($tb126_solicitud_ayudaForm["co_tipo_ayuda"]);
            $tb126_solicitud_ayuda->setTxObservacion($tb126_solicitud_ayudaForm["tx_observacion"]);
            $tb126_solicitud_ayuda->setCoSolicitud($tb126_solicitud_ayudaForm["co_solicitud"]);
            $tb126_solicitud_ayuda->setCoUsuario($tb126_solicitud_ayudaForm["co_usuario"]);
            $tb126_solicitud_ayuda->setIdTb013AnioFiscal($this->getUser()->getAttribute('ejercicio'));
            $tb126_solicitud_ayuda->setMoTotalAyuda($mo_total);
            $tb126_solicitud_ayuda->setFeResolucion($fecha);
            $tb126_solicitud_ayuda->save($con);

            
            $tb052_compras->setCoUsuario($this->getUser()->getAttribute('codigo'));
            $tb052_compras->setFechaCompra($fecha);
            $tb052_compras->setTxObservacion($tb126_solicitud_ayudaForm["tx_observacion"]);
            $tb052_compras->setCoSolicitud($tb126_solicitud_ayudaForm["co_solicitud"]);
            $tb052_compras->setCoTipoSolicitud(25);
            $tb052_compras->setAnio($this->getUser()->getAttribute('ejercicio'));
            $tb052_compras->setNuIva(0);
            $tb052_compras->setMontoIva(0);
            $tb052_compras->setMontoSubTotal(0);
            $tb052_compras->setMontoTotal($tb126_solicitud_ayudaForm["monto"]);
            $tb052_compras->setCoTipoMovimiento(0);
            $tb052_compras->save($con);


            $tb053_detalle_compras->setCoCompras($tb052_compras->getCoCompras());
            $tb053_detalle_compras->setNuCantidad(1);
            $tb053_detalle_compras->setCoProducto(18554);
            $tb053_detalle_compras->setDetalle($tb126_solicitud_ayudaForm["tx_observacion"]);
            $tb053_detalle_compras->setPrecioUnitario($mo_total);
            $tb053_detalle_compras->setMonto($mo_total);
            $tb053_detalle_compras->save($con);

            Tb209PresupuestoDetalleCompraPeer::setInsertPresupuestoDetalleCompra(
                $tb053_detalle_compras->getCoDetalleCompras(),
                $mo_total,
                $this->getUser()->getAttribute('codigo'),
                $con
            );


            $solicitud = Tb026SolicitudPeer::retrieveByPk($tb126_solicitud_ayudaForm["co_solicitud"]);
            $solicitud->setTxObservacion($tb126_solicitud_ayudaForm["tx_observacion"]);
            $solicitud->setCoProveedor($co_proveedor)->setFeRegistro($fecha)->save($con);

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb126_solicitud_ayudaForm["co_solicitud"]));
            $ruta->setObservacion($tb126_solicitud_ayudaForm["tx_observacion"]);
            $ruta->setInCargarDato(true)->save($con);

            $con->commit();
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Modificación realizada exitosamente'
            ));
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage()
            ));
        }
    }


    public function executeEliminar(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud_ayuda");
        $con = Propel::getConnection();
        try {
            $con->beginTransaction();
            /*CAMPOS*/
            $tb126_solicitud_ayuda = Tb126SolicitudAyudaPeer::retrieveByPk($codigo);
            $tb126_solicitud_ayuda->delete($con);
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
        $paginar = $this->getRequestParameter("paginar");
        $limit = $this->getRequestParameter("limit", 20);
        $start = $this->getRequestParameter("start", 0);

        $co_persona = $this->getRequestParameter("co_persona");
        $co_tipo_ayuda = $this->getRequestParameter("co_tipo_ayuda");
        $tx_observacion = $this->getRequestParameter("tx_observacion");
        $co_solicitud = $this->getRequestParameter("co_solicitud");
        $co_usuario = $this->getRequestParameter("co_usuario");
        $created_at = $this->getRequestParameter("created_at");


        $c = new Criteria();

        if ($this->getRequestParameter("BuscarBy") == "true") {
            if ($co_persona != "") {
                $c->add(Tb126SolicitudAyudaPeer::co_persona, $co_persona);
            }

            if ($co_tipo_ayuda != "") {
                $c->add(Tb126SolicitudAyudaPeer::co_tipo_ayuda, $co_tipo_ayuda);
            }

            if ($tx_observacion != "") {
                $c->add(Tb126SolicitudAyudaPeer::tx_observacion, '%' . $tx_observacion . '%', Criteria::LIKE);
            }

            if ($co_solicitud != "") {
                $c->add(Tb126SolicitudAyudaPeer::co_solicitud, $co_solicitud);
            }

            if ($co_usuario != "") {
                $c->add(Tb126SolicitudAyudaPeer::co_usuario, $co_usuario);
            }


            if ($created_at != "") {
                list($dia, $mes, $anio) = explode("/", $created_at);
                $fecha = $anio . "-" . $mes . "-" . $dia;
                $c->add(Tb126SolicitudAyudaPeer::created_at, $fecha);
            }
        }
        $c->setIgnoreCase(true);
        $cantidadTotal = Tb126SolicitudAyudaPeer::doCount($c);

        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb126SolicitudAyudaPeer::CO_SOLICITUD_AYUDA);

        $stmt = Tb126SolicitudAyudaPeer::doSelectStmt($c);
        $registros = "";
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = array(
                "co_solicitud_ayuda" => trim($res["co_solicitud_ayuda"]),
                "co_persona" => trim($res["co_persona"]),
                "co_tipo_ayuda" => trim($res["co_tipo_ayuda"]),
                "tx_observacion" => trim($res["tx_observacion"]),
                "co_solicitud" => trim($res["co_solicitud"]),
                "co_usuario" => trim($res["co_usuario"]),
                "created_at" => trim($res["created_at"]),
            );
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros
        ));
    }

    public function executeStorelistaayudasinfactura(sfWebRequest $request)
    {
        $limit = $this->getRequestParameter("limit", 15);
        $start = $this->getRequestParameter("start", 0);
        $in_ventanilla = $this->getRequestParameter("in_ventanilla");
        $co_proceso = $this->getRequestParameter("co_proceso");
        $co_solicitud = $this->getRequestParameter("co_solicitud");

        $co_documento = $this->getRequestParameter("co_documento");
        $nu_cedula_rif = $this->getRequestParameter("nu_cedula_rif");
        $tx_razon_social = $this->getRequestParameter("tx_razon_social");

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
            $c->add(Tb030RutaPeer::NU_ORDEN, 1, Criteria::GREATER_THAN);

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
        $c->addSelectColumn(Tb026SolicitudPeer::TX_OBSERVACION);
        // $c->addSelectColumn(Tb052ComprasPeer::MONTO_TOTAL);
        //  $c->addSelectColumn(Tb052ComprasPeer::NUMERO_COMPRA);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb030RutaPeer::TX_RUTA_REPORTE);

        // $c->addJoin(Tb026SolicitudPeer::CO_PERSONA, Tb109PersonaPeer::CO_PERSONA,   Criteria::LEFT_JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR, Criteria::LEFT_JOIN);
        $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO, Criteria::LEFT_JOIN);
        // $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb060OrdenPagoPeer::CO_SOLICITUD,   Criteria::LEFT_JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD, Criteria::JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD, Criteria::JOIN);
        $c->addJoin(Tb030RutaPeer::CO_PROCESO, Tb028ProcesoPeer::CO_PROCESO, Criteria::JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO, Criteria::JOIN);
        //  $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD,  Criteria::JOIN);

        $c->addAnd(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD, 25);
        $c->addAnd(Tb030RutaPeer::CO_PROCESO, $registro_proceso, Criteria::IN);

        $c->addAnd(Tb030RutaPeer::IN_ANULAR, NULL, Criteria::ISNULL);
        $c->addAnd(Tb026SolicitudPeer::CO_ESTATUS, array(1, 2), Criteria::IN);
        $c->addAnd(Tb030RutaPeer::CO_ESTATUS_RUTA, 1);
        $c->addAnd(Tb030RutaPeer::NU_ORDEN, 1);
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
                "tx_proceso" => trim($res["tx_proceso"]),
                "tx_observacion" => strtoupper(trim($res["tx_observacion"])),
                "co_proceso" => trim($res["co_proceso"]),
                "numero_compra" => trim($res["numero_compra"]),
                "tx_tipo_solicitud" => trim($res["tx_tipo_solicitud"]),
                "co_tipo_solicitud" => trim($res["co_tipo_solicitud"]),
                "co_solicitud" => trim($res["co_solicitud"]),
                "tx_login" => trim($res["tx_login"]),
                "tx_serial" => Tb060OrdenPagoPeer::getODP($res["co_solicitud"]),
                "in_reporte" => ($res["tx_ruta_reporte"] == null) ? '' : $res["co_ruta"],
                "co_ruta" => $encrip->encrypt($res["co_ruta"]),
                "tx_rif" => $tx_rif,
                "tx_razon_social" => $tx_razon_social,
                "fe_creacion" => $dia . '-' . $mes . '-' . $anio,
                "cant_revision" => $cantidad
            );
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros
        ));

        $this->setTemplate('store');
    }

    public function executeStorelistaayuda(sfWebRequest $request)
    {
        $limit = $this->getRequestParameter("limit", 15);
        $start = $this->getRequestParameter("start", 0);
        $in_ventanilla = $this->getRequestParameter("in_ventanilla");
        $co_proceso = $this->getRequestParameter("co_proceso");
        $co_solicitud = $this->getRequestParameter("co_solicitud");

        $co_documento = $this->getRequestParameter("co_documento");
        $nu_cedula_rif = $this->getRequestParameter("nu_cedula_rif");
        $tx_razon_social = $this->getRequestParameter("tx_razon_social");

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
            $c->add(Tb030RutaPeer::NU_ORDEN, 1, Criteria::GREATER_THAN);

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
        $c->addSelectColumn(Tb026SolicitudPeer::TX_OBSERVACION);
        // $c->addSelectColumn(Tb052ComprasPeer::MONTO_TOTAL);
        //  $c->addSelectColumn(Tb052ComprasPeer::NUMERO_COMPRA);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb030RutaPeer::TX_RUTA_REPORTE);

        // $c->addJoin(Tb026SolicitudPeer::CO_PERSONA, Tb109PersonaPeer::CO_PERSONA,   Criteria::LEFT_JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR, Criteria::LEFT_JOIN);
        $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO, Criteria::LEFT_JOIN);
        // $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb060OrdenPagoPeer::CO_SOLICITUD,   Criteria::LEFT_JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD, Criteria::JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD, Criteria::JOIN);
        $c->addJoin(Tb030RutaPeer::CO_PROCESO, Tb028ProcesoPeer::CO_PROCESO, Criteria::JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO, Criteria::JOIN);
        //  $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD,  Criteria::JOIN);

        $c->addAnd(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD, 51);
        $c->addAnd(Tb030RutaPeer::CO_PROCESO, $registro_proceso, Criteria::IN);

        $c->addAnd(Tb030RutaPeer::IN_ANULAR, NULL, Criteria::ISNULL);
        $c->addAnd(Tb026SolicitudPeer::CO_ESTATUS, array(1, 2), Criteria::IN);
        $c->addAnd(Tb030RutaPeer::CO_ESTATUS_RUTA, 1);
        $c->addAnd(Tb030RutaPeer::NU_ORDEN, 1);
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
                "tx_proceso" => trim($res["tx_proceso"]),
                "tx_observacion" => strtoupper(trim($res["tx_observacion"])),
                "co_proceso" => trim($res["co_proceso"]),
                "numero_compra" => trim($res["numero_compra"]),
                "tx_tipo_solicitud" => trim($res["tx_tipo_solicitud"]),
                "co_tipo_solicitud" => trim($res["co_tipo_solicitud"]),
                "co_solicitud" => trim($res["co_solicitud"]),
                "tx_login" => trim($res["tx_login"]),
                "tx_serial" => Tb060OrdenPagoPeer::getODP($res["co_solicitud"]),
                "in_reporte" => ($res["tx_ruta_reporte"] == null) ? '' : $res["co_ruta"],
                "co_ruta" => $encrip->encrypt($res["co_ruta"]),
                "tx_rif" => $tx_rif,
                "tx_razon_social" => $tx_razon_social,
                "fe_creacion" => $dia . '-' . $mes . '-' . $anio,
                "cant_revision" => $cantidad
            );
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros
        ));

        $this->setTemplate('store');
    }

    //modelo fk tb109_persona.CO_PERSONA
    public function executeStorefkcopersona(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb109PersonaPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros
        ));
        $this->setTemplate('store');
    }
    //modelo fk tb127_tipo_ayuda.CO_TIPO_AYUDA
    public function executeStorefkcotipoayuda(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb127TipoAyudaPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros
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
            "success" => true,
            "total" => count($registros),
            "data" => $registros
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
            "success" => true,
            "total" => count($registros),
            "data" => $registros
        ));
        $this->setTemplate('store');
    }

    public function executeVerificarSolicitante(sfWebRequest $request)
    {

        $co_documento = $this->getRequestParameter('co_documento');
        $nu_cedula = $this->getRequestParameter('nu_cedula');
        $co_persona = $this->getRequestParameter('co_persona');

        $c = new Criteria();

        if ($co_persona != '') {
            $c->add(Tb109PersonaPeer::CO_PERSONA, $co_persona);
        } else {
            $c->add(Tb109PersonaPeer::CO_DOCUMENTO, $co_documento);
            $c->add(Tb109PersonaPeer::NU_CEDULA, $nu_cedula);
        }


        $stmt = Tb109PersonaPeer::doSelectStmt($c);

        $registros = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
            "success" => true,
            "data" => $registros
        ));

        $this->setTemplate('store');

    }


    public function executeGuardarFactura(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("co_factura");
        $codigo_solicitud = $this->getRequestParameter("co_solicitud_ayuda");
        $co_pago_servicio = $this->getRequestParameter("co_pago_servicio");
        $co_detalle_compras = $this->getRequestParameter("co_detalle_compras");
        $tb045_facturaForm = $this->getRequestParameter('tb045_factura');
        $tb008_proveedorForm = $this->getRequestParameter('tb008_proveedor');

        $json_factura = $this->getRequestParameter("json_factura");

        $listaFactura = json_decode($json_factura, true);

        $con = Propel::getConnection();

        if ($codigo_solicitud != '' || $codigo_solicitud != null) {
            $tb126_solicitud_ayuda = Tb126SolicitudAyudaPeer::retrieveByPk($codigo_solicitud);
        } else {
            $tb126_solicitud_ayuda = new Tb126SolicitudAyuda();

            $tb026_solicitudForm = array(
                "co_tipo_solicitud" => 51,
                "ejercicio" => $this->getUser()->getAttribute('ejercicio'),
                "fe_solicitud" => date("d/m/Y"),
                "observacion" => $tb008_proveedorForm["tx_observacion"],
                "codigo" => $this->getUser()->getAttribute('codigo')
            );

            $resp = Tb026SolicitudPeer::setSolicitud($tb026_solicitudForm, $con);

            if ($resp["success"] == true) {
                $tb045_facturaForm["co_solicitud"] = $resp["co_solicitud"];
            } else {
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => $resp["msg"]
                ));

                return;
            }
        }


        try {
            $con->beginTransaction();



            $solicitanteForm = $this->getRequestParameter('solicitante');
            $co_proveedor_solicitante = $this->getProveedor($solicitanteForm, $con);



            // echo $tb126_solicitud_ayudaForm["co_usuario"]; exit();



            //Datos Receptor Cheque               
            $tb126_solicitud_ayuda->setCoProveedor($tb045_facturaForm["co_proveedor"]);
            $tb126_solicitud_ayuda->setCoProveedorSolicitante($co_proveedor_solicitante);
            //   $tb126_solicitud_ayuda->setCoTipoAyuda($tb126_solicitud_ayudaForm["co_tipo_ayuda"]);
            $tb126_solicitud_ayuda->setTxObservacion($tb126_solicitud_ayudaForm["tx_observacion"]);
            $tb126_solicitud_ayuda->setCoSolicitud($tb045_facturaForm["co_solicitud"]);
            $tb126_solicitud_ayuda->setCoUsuario($tb126_solicitud_ayudaForm["co_usuario"]);
            $tb126_solicitud_ayuda->setIdTb013AnioFiscal($this->getUser()->getAttribute('ejercicio'));

            $tb126_solicitud_ayuda->save($con);

            $solicitud = Tb026SolicitudPeer::retrieveByPk($tb045_facturaForm["co_solicitud"]);
            $solicitud->setCoProveedor($tb045_facturaForm["co_proveedor"])->save($con);

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb045_facturaForm["co_solicitud"]));
            $ruta->setInCargarDato(true)->save($con);





            //echo "llego"; exit();

            /*CAMPOS*/

            $co_compra = $tb045_facturaForm["co_compra"];

            if ($co_compra != '' || $co_compra != null) {
                $tb052_compras = Tb052ComprasPeer::retrieveByPk($co_compra);
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
            //$tb052_compras->setTxObservacion($tb045_facturaForm["tx_concepto"]);
            $tb052_compras->setCoSolicitud($tb045_facturaForm["co_solicitud"]);
            $tb052_compras->setCoTipoSolicitud(26);

            $tb052_compras->setTxObservacion($tb008_proveedorForm["tx_observacion"]);
            //$tb052_compras->setAnio(date('Y'));   
            $tb052_compras->setAnio($this->getUser()->getAttribute('ejercicio'));
            $tb052_compras->setNuIva(0);
            $tb052_compras->setMontoIva(0);
            $tb052_compras->setMontoSubTotal(0);
            $tb052_compras->setCoProveedor($tb045_facturaForm["co_proveedor"]);
            $tb052_compras->setCoTipoMovimiento(0);
            $tb052_compras->setCoRamo($tb045_facturaForm["co_ramo"]);
            $tb052_compras->save($con);

            $total_pagar = 0;

            foreach ($listaFactura as $v) {

                if ($v["co_detalle_compras"] == '') {

                    $tb045_factura = new Tb045Factura();
                    $tb045_factura->setNuFactura($v["nu_factura"]);

                    if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                        $fe_cierre = $this->getUser()->getAttribute('fe_cierre');
                    } else {
                        $fe_cierre = date("Y-m-d");
                    }

                    list($dia, $mes, $anio) = explode("/", $v["fe_emision"]);
                    $fecha = $anio . "-" . $mes . "-" . $dia;
                    $tb045_factura->setFeEmision($fecha);


                    $tb045_factura->setNuBaseImponible($v["nu_base_imponible"]);
                    $tb045_factura->setNuTotal($v["nu_total"]);
                    $tb045_factura->setTotalPagar($v["nu_total_pagar"]);
                    $tb045_factura->setCoSolicitud($tb045_facturaForm["co_solicitud"]);
                    $tb045_factura->setCoProveedor($tb045_facturaForm["co_proveedor"]);
                    $tb045_factura->setCoRamo($tb045_facturaForm["co_ramo"]);
                    $tb045_factura->setNuControl($v["nu_control"]);
                    $tb045_factura->setCoCompra($tb052_compras->getCoCompras());

                    /*Campo tipo NUMERIC */
                    $tb045_factura->setCoIvaFactura($v["co_iva_factura"]);
                    $tb045_factura->setNuIvaFactura($v["nu_iva_factura"]);
                    $tb045_factura->setCoIvaRetencion($v["co_iva_retencion"]);
                    $tb045_factura->setNuIvaRetencion($v["nu_iva_retencion"]);
                    $tb045_factura->setNuTotalRetencion($v["nu_total_retencion"]);
                    $tb045_factura->setTxConcepto($v["tx_concepto"]);
                    $tb045_factura->setFeRegistro($fe_cierre);

                    /*CAMPOS*/
                    $tb045_factura->save($con);


                    $tb053_detalle_compras = new Tb053DetalleCompras();
                    $tb053_detalle_compras->setCoCompras($tb052_compras->getCoCompras());
                    $tb053_detalle_compras->setNuCantidad(1);
                    $tb053_detalle_compras->setCoProducto($v["co_producto"]);
                    $tb053_detalle_compras->setDetalle($tb008_proveedorForm["tx_observacion"]);
                    $tb053_detalle_compras->setPrecioUnitario($v["total_pagar"]);
                    //$tb053_detalle_compras->setMonto($v["total_pagar"]);
                    $tb053_detalle_compras->setMonto($v["nu_base_imponible"]);
                    $tb053_detalle_compras->setInCalcularIva(true);
                    $tb053_detalle_compras->setCoFactura($tb045_factura->getCoFactura());
                    $tb053_detalle_compras->save($con);


                    Tb209PresupuestoDetalleCompraPeer::setInsertPresupuestoDetalleCompra(
                        $tb053_detalle_compras->getCoDetalleCompras(),
                        round($monto_iva, 2),
                        $this->getUser()->getAttribute('codigo'),
                        $con
                    );

                  
                    if ($v["nu_iva_retencion"] > 0) {
                        $tb046_factura_retencion = new Tb046FacturaRetencion();
                        $tb046_factura_retencion->setCoFactura($tb045_factura->getCoFactura());
                        $tb046_factura_retencion->setCoTipoRetencion(92);
                        $tb046_factura_retencion->setMoRetencion($v["nu_iva_retencion"]);
                        $tb046_factura_retencion->setPoRetencion($v["co_iva_retencion"]);
                        $tb046_factura_retencion->setCoSolicitud($tb045_facturaForm["co_solicitud"]);
                        $tb046_factura_retencion->save($con);

                        $listaDetalleFactura = json_decode($v["json_detalle_retencion"], true);

                        foreach ($listaDetalleFactura as $vp) {
                            $tb046_factura_retencion_dos = new Tb046FacturaRetencion();
                            $tb046_factura_retencion_dos->setCoFactura($tb045_factura->getCoFactura());
                            $tb046_factura_retencion_dos->setCoTipoRetencion($vp["co_tipo_retencion"]);
                            $tb046_factura_retencion_dos->setMoRetencion($vp["nu_valor"]);
                            $tb046_factura_retencion_dos->setPoRetencion($vp["po_deduccion"]);
                            $tb046_factura_retencion_dos->setCoSolicitud($tb045_facturaForm["co_solicitud"]);
                            $tb046_factura_retencion_dos->save($con);
                        }

                    }

                    $monto_iva = $v["nu_iva_factura"];

                    /*$wherec = new Criteria();
                    $wherec->add(Tb053DetalleComprasPeer::CO_COMPRAS, $tb052_compras->getCoCompras());
                    $wherec->add(Tb053DetalleComprasPeer::CO_PRODUCTO, 19336);
                    BasePeer::doDelete($wherec, $con);*/

                    if ($monto_iva > 0) {
                        $tb053_detalle_compras = new Tb053DetalleCompras();
                        $tb053_detalle_compras->setCoCompras($tb052_compras->getCoCompras());
                        $tb053_detalle_compras->setCoProducto(19336); //IMPUESTO AL VALOR AGREGADO (IVA)
                        $tb053_detalle_compras->setNuCantidad(1);
                        $tb053_detalle_compras->setPrecioUnitario(round($monto_iva, 2));
                        $tb053_detalle_compras->setMonto(round($monto_iva, 2));
                        $tb053_detalle_compras->setDetalle('IMPUESTO AL VALOR AGREGADO (IVA)');
                        $tb053_detalle_compras->setCoPartida($tb052_comprasForm["co_partida_iva"]);
                        $tb053_detalle_compras->setCoUnidadProducto(638);
                        $tb053_detalle_compras->setInCalcularIva(false);
                        $tb053_detalle_compras->setCoFactura($tb045_factura->getCoFactura());
                        $tb053_detalle_compras->save($con);

                        Tb209PresupuestoDetalleCompraPeer::setInsertPresupuestoDetalleCompra(
                            $tb053_detalle_compras->getCoDetalleCompras(),
                            round($monto_iva, 2),
                            $this->getUser()->getAttribute('codigo'),
                            $con
                        );
                    }

                }

            }



            foreach ($listaFactura as $v) {
                $total_pagar = $total_pagar + $v["total_pagar"];
            }

            $tb052_compras->setMontoTotal($total_pagar);
            $tb052_compras->save($con);

            $solicitud = Tb026SolicitudPeer::retrieveByPk($tb045_facturaForm["co_proveedor"]);
            $solicitud->setCoProveedor($tb045_facturaForm["co_proveedor"])->save($con);

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb045_facturaForm["co_solicitud"]));
            $ruta->setInCargarDato(true)->save($con);

            $con->commit();

            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Factura cargada exitosamente!'
            ));



        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage()
            ));
        }
    }


    public function executeAgregarFacturaDV(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "co_documento" => $this->getRequestParameter('co_documento'),
            "co_proveedor" => $this->getRequestParameter('co_proveedor'),
            "co_ramo" => $this->getRequestParameter('co_ramo'),
            "co_solicitud" => $this->getRequestParameter('co_solicitud'),
            "co_iva_factura" => $this->getRequestParameter('co_iva_factura'),
            "co_iva_retencion" => $this->getRequestParameter('co_iva_retencion'),
            "co_tipo_solicitud" => $this->getRequestParameter('co_tipo_solicitud'),
            "mo_exento" => 0
        ));
    }

    public function executeStorefkcoproducto(sfWebRequest $request)
    {

        $de_variable = $this->getRequestParameter("variable");
        $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
        $co_documento = $this->getRequestParameter("co_documento");

        $co_clase = array(841016);

        $c = new Criteria();

        if ($co_tipo_solicitud == 51) {
            //Servicios Varios (Servicios Basicos)
            //$c->add(Tb048ProductoPeer::CO_PRODUCTO, array(19500,19499,19498), Criteria::IN); 

        }

        $c->clearSelectColumns();
        $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        //$c->add(Tb048ProductoPeer::CO_CLASE, $co_clase);
        $c->add(Tb048ProductoPeer::CO_CLASE, $co_clase, Criteria::IN);

        $cantidadTotal = Tb048ProductoPeer::doCount($c);

        $c->addAscendingOrderByColumn(Tb048ProductoPeer::COD_PRODUCTO);

        $stmt = Tb048ProductoPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros
        ));

        $this->setTemplate('store');
    }

}