<?php

/**
 * autoCompromisoAsignacion actions.
 * NombreClaseModel(Tb146CompromisoAsignacion)
 * NombreTabla(tb146_compromiso_asignacion)
 * @package    ##PROJECT_NAME##
 * @subpackage autoCompromisoAsignacion
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class CompromisoAsignacionActions extends sfActions
{

    public function executeIndex(sfWebRequest $request)
    {
        $this->forward('CompromisoAsignacion', 'lista');
    }

    public function executeNuevo(sfWebRequest $request)
    {
        $this->forward('CompromisoAsignacion', 'editar');
    }

    public function executeFiltro(sfWebRequest $request)
    {
    }

    public function executeAgregarAsignacion(sfWebRequest $request)
    {
    }

    public function executeAgregarCompromiso(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_compras");
        if ($codigo != '' || $codigo != null) {
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
            $c->addSelectColumn(Tb146CompromisoAsignacionPeer::CO_SOLICITUD);
            $c->addSelectColumn(Tb146CompromisoAsignacionPeer::CO_COMPROMISO_ASIGNACION);
            $c->addSelectColumn(Tb146CompromisoAsignacionPeer::CO_PROVEEDOR);
            $c->addSelectColumn(Tb146CompromisoAsignacionPeer::TX_DESCRIPCION);
            $c->addSelectColumn(Tb052ComprasPeer::NUMERO_COMPRA);
            $c->addSelectColumn(Tb146CompromisoAsignacionPeer::FE_COMPROMISO);
            $c->addSelectColumn(Tb146CompromisoAsignacionPeer::NU_MONTO);
            $c->addSelectColumn(Tb052ComprasPeer::CO_EJECUTOR);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
            $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
            $c->addSelectColumn(Tb026SolicitudPeer::CO_TIPO_SOLICITUD);

            $c->addJoin(Tb146CompromisoAsignacionPeer::CO_SOLICITUD, Tb026SolicitudPeer::CO_SOLICITUD);
            $c->addJoin(Tb146CompromisoAsignacionPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD);
            $c->addJoin(Tb146CompromisoAsignacionPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
            $c->add(Tb052ComprasPeer::CO_COMPRAS, $codigo);

            $stmt = Tb146CompromisoAsignacionPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->data = json_encode(array(
                "co_compromiso_asignacion"     => $campos["co_compromiso_asignacion"],
                "co_proveedor"                 => $campos["co_proveedor"],
                "tx_descripcion"               => $campos["tx_descripcion"],
                "nu_cancelacion"               => $campos["numero_compra"],
                "fe_compromiso"                => $campos["fe_compromiso"],
                "nu_monto"                     => $campos["nu_monto"],
                "co_solicitud"                 => $codigo,
                "co_ejecutor"                  => $campos["co_ejecutor"],
                "co_compras"                   => $campos["co_compras"],
                "tx_razon_social"              => $campos["tx_razon_social"],
                "tx_rif"                       => $campos["tx_rif"],
                "tx_direccion"                 => $campos["tx_direccion"],
                "co_documento"                 => $campos["co_documento"],
                "co_tipo_solicitud"            => $campos["co_tipo_solicitud"]
            ));
        } else {
            $this->data = json_encode(array(
                "co_compromiso_asignacion"     => "",
                "co_proveedor"                 => "",
                "tx_descripcion"               => "",
                "nu_cancelacion"               => "Por Asignar",
                "fe_compromiso"                => "",
                "nu_monto"                     => "",
                "co_solicitud"                 => $this->getRequestParameter("co_solicitud")
            ));
        }
    }

    public function executeEditar(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");
        if ($codigo != '' || $codigo != null) {
            $c = new Criteria();
            $c->clearSelectColumns();
            //    $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
            $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
            $c->addSelectColumn(Tb026SolicitudPeer::TX_OBSERVACION);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
            $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
            $c->addSelectColumn(Tb026SolicitudPeer::CO_TIPO_SOLICITUD);

            $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
            $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $codigo);

            $stmt = Tb146CompromisoAsignacionPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->data = json_encode(array(
                "co_compromiso_asignacion"     => $campos["co_compromiso_asignacion"],
                "co_proveedor"                 => $campos["co_proveedor"],
                "tx_descripcion"               => $campos["tx_observacion"],
                "nu_cancelacion"               => $campos["numero_compra"],
                "fe_compromiso"                => $campos["fe_compromiso"],
                "nu_monto"                     => $campos["nu_monto"],
                "co_solicitud"                 => $codigo,
                "co_ejecutor"                  => $campos["co_ejecutor"],
                "co_compras"                   => $campos["co_compras"],
                "tx_razon_social"              => $campos["tx_razon_social"],
                "tx_rif"                       => $campos["tx_rif"],
                "tx_direccion"                 => $campos["tx_direccion"],
                "co_documento"                 => $campos["co_documento"],
                "co_tipo_solicitud"            => $campos["co_tipo_solicitud"]
            ));
        } else {
            $this->data = json_encode(array(
                "co_compromiso_asignacion"     => "",
                "co_proveedor"                 => "",
                "tx_descripcion"               => "",
                "nu_cancelacion"               => "Por Asignar",
                "fe_compromiso"                => "",
                "nu_monto"                     => "",
                "co_solicitud"                 => ""
            ));
        }
    }

    public function executeGenerarODP(sfWebRequest $request)
    {
        $tb146_compromiso_asignacionForm = $this->getRequestParameter('tb146_compromiso_asignacion');
        $con = Propel::getConnection();

        $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
        $tb087_presupuesto_movimiento->setCoPartida($tb146_compromiso_asignacionForm["co_presupuesto"])
            ->setCoTipoMovimiento(1)
            ->setNuMonto($tb146_compromiso_asignacionForm["nu_monto"])
            //->setNuAnio(date('Y'))
            ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
            ->setCoUsuario($this->getUser()->getAttribute('codigo'))
            ->setCoDetalleCompra($tb146_compromiso_asignacionForm["co_detalle_compra"])
            ->setInActivo(true)
            ->save($con);

        $con->commit();
        $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
        $tb087_presupuesto_movimiento->setCoPartida($tb146_compromiso_asignacionForm["co_presupuesto"])
            ->setCoTipoMovimiento(2)
            ->setNuMonto($tb146_compromiso_asignacionForm["nu_monto"])
            //->setNuAnio(date('Y'))
            ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
            ->setCoUsuario($this->getUser()->getAttribute('codigo'))
            ->setCoDetalleCompra($tb146_compromiso_asignacionForm["co_detalle_compra"])
            ->setInActivo(true)
            ->save($con);
        $con->commit();

        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb146_compromiso_asignacionForm["co_solicitud"]));
        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

        $co_odp = Tb060OrdenPagoPeer::generarODP($tb146_compromiso_asignacionForm["co_solicitud"], $con, $this->getUser()->getAttribute('ejercicio'));

        $con->commit();

        $tb045_factura = new Tb045Factura();
        $tb045_factura->setNuTotal($tb146_compromiso_asignacionForm["nu_monto"])
            ->setNuBaseImponible($tb146_compromiso_asignacionForm["nu_monto"])
            ->setCoIvaFactura(0)
            ->setNuIvaFactura(0)
            ->setCoIvaRetencion(0)
            ->setNuIvaRetencion(0)
            ->setCoCompra($tb146_compromiso_asignacionForm["co_compras"])
            ->setNuTotalRetencion(0)
            ->setTotalPagar($tb146_compromiso_asignacionForm["nu_monto"])
            ->setTxConcepto("AYUDA")
            ->setCoOdp($co_odp)
            ->setCoSolicitud($tb146_compromiso_asignacionForm["co_solicitud"])->save($con);
        $con->commit();

        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());


        $this->data = json_encode(array(
            "success" => true,
            "msg" => 'Modificación realizada exitosamente'
        ));
        $con->commit();
    }

    public function executeOdp(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");
        if ($codigo != '' || $codigo != null) {
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
            $c->addSelectColumn(Tb146CompromisoAsignacionPeer::CO_SOLICITUD);
            $c->addSelectColumn(Tb146CompromisoAsignacionPeer::CO_COMPROMISO_ASIGNACION);
            $c->addSelectColumn(Tb146CompromisoAsignacionPeer::CO_PROVEEDOR);
            $c->addSelectColumn(Tb146CompromisoAsignacionPeer::TX_DESCRIPCION);
            $c->addSelectColumn(Tb146CompromisoAsignacionPeer::NU_CANCELACION);
            $c->addSelectColumn(Tb146CompromisoAsignacionPeer::FE_COMPROMISO);
            $c->addSelectColumn(Tb146CompromisoAsignacionPeer::NU_MONTO);
            $c->addSelectColumn(Tb052ComprasPeer::CO_EJECUTOR);
            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PROYECTO_AC);
            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_ACCION_ESPECIFICA);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
            $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
            $c->addSelectColumn(Tb060OrdenPagoPeer::CO_ORDEN_PAGO);


            $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD, Tb060OrdenPagoPeer::CO_SOLICITUD,  Criteria::LEFT_JOIN);
            $c->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
            $c->addJoin(Tb146CompromisoAsignacionPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD);
            $c->addJoin(Tb146CompromisoAsignacionPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
            $c->add(Tb146CompromisoAsignacionPeer::CO_SOLICITUD, $codigo);

            $stmt = Tb146CompromisoAsignacionPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->data = json_encode(array(
                "co_compromiso_asignacion"     => $campos["co_compromiso_asignacion"],
                "co_proveedor"                 => $campos["co_proveedor"],
                "tx_descripcion"               => $campos["tx_descripcion"],
                "nu_cancelacion"               => $campos["nu_cancelacion"],
                "fe_compromiso"                => $campos["fe_compromiso"],
                "nu_monto"                     => $campos["nu_monto"],
                "co_solicitud"                 => $codigo,
                "co_ejecutor"                  => $campos["co_ejecutor"],
                "co_detalle_compras"           => $campos["co_detalle_compras"],
                "co_compras"                   => $campos["co_compras"],
                "co_presupuesto"               => $campos["co_presupuesto"],
                "co_proyecto_ac"               => $campos["co_proyecto_ac"],
                "co_accion_especifica"         => $campos["co_accion_especifica"],
                "tx_razon_social"              => $campos["tx_razon_social"],
                "tx_rif"                       => $campos["tx_rif"],
                "tx_direccion"                 => $campos["tx_direccion"],
                "co_documento"                 => $campos["co_documento"],
                "co_orden_pago"                => $campos["co_orden_pago"]
            ));
        } else {
            $this->data = json_encode(array(
                "co_compromiso_asignacion"     => "",
                "co_proveedor"                 => "",
                "tx_descripcion"               => "",
                "nu_cancelacion"               => "",
                "fe_compromiso"                => "",
                "nu_monto"                     => "",
                "co_solicitud"                 => $codigo,
            ));
        }
    }


    public function executeGuardarCompromiso(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("co_compromiso_asignacion");
        $tb146_compromiso_asignacionForm = $this->getRequestParameter('tb146_compromiso_asignacion');
        $json_asignacion  = $this->getRequestParameter("json_asignacion");
        $con = Propel::getConnection();
        $con->beginTransaction();

        try {
            if ($codigo != '' || $codigo != null) {
                $tb146_compromiso_asignacion    = Tb146CompromisoAsignacionPeer::retrieveByPk($codigo);
                $tb052_compras                  = Tb052ComprasPeer::retrieveByPk($tb146_compromiso_asignacionForm["co_compras"]);
            } else {

                $datos_solicitud = Tb026SolicitudPeer::retrieveByPK($tb146_compromiso_asignacionForm["co_solicitud"]);
                $tb146_compromiso_asignacionForm["co_tipo_solicitud"] = $datos_solicitud->getCoTipoSolicitud();

                $cs = new Criteria();
                $cs->addJoin(Tb136TipoDocumentoPeer::CO_TIPO_DOCUMENTO, Tb027TipoSolicitudPeer::ID_136_TIPO_DOCUMENTO);
                $cs->add(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD, $tb146_compromiso_asignacionForm["co_tipo_solicitud"]);
                $stmts = Tb136TipoDocumentoPeer::doSelectStmt($cs);
                $resp = $stmts->fetch(PDO::FETCH_ASSOC);

                $sigla = $resp["tx_sigla"];

                list($dia, $mes, $anio) = explode("/", $tb146_compromiso_asignacionForm["fe_compromiso"]);
                $fecha = $anio . "-" . $mes . "-" . $dia;

                if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                    $serial = $sigla . '-' . date("Ym", strtotime($this->getUser()->getAttribute('fe_cierre'))) . '-' . Tb137ControlSerialPeer::getSerial($resp["co_tipo_documento"], $con, $this->getUser()->getAttribute('ejercicio'));
                } else {
                    $serial =  $sigla . '-' . $anio.$mes  . '-' .  Tb137ControlSerialPeer::getSerial($resp["co_tipo_documento"], $con, $this->getUser()->getAttribute('ejercicio'));
                }

                $datos_solicitud = Tb026SolicitudPeer::retrieveByPK($tb146_compromiso_asignacionForm["co_solicitud"]);

                $tb052_compras = new Tb052Compras();
                $tb052_compras->setTxObservacion($tb146_compromiso_asignacionForm["tx_descripcion"]);
                $tb052_compras->setCoSolicitud($tb146_compromiso_asignacionForm["co_solicitud"]);
               // $tb052_compras->setCoEjecutor($tb146_compromiso_asignacionForm["co_ejecutor"]);
                $tb052_compras->setCoProveedor($datos_solicitud->getCoProveedor());
                $tb052_compras->setCoTipoSolicitud($datos_solicitud->getCoTipoSolicitud());
                $tb052_compras->setCoTipoSolicitud($tb146_compromiso_asignacionForm["co_tipo_solicitud"]);
                $tb052_compras->setTxConcepto($tb146_compromiso_asignacionForm["tx_descripcion"]);
                $tb052_compras->setAnio($this->getUser()->getAttribute('ejercicio'));
                $tb052_compras->setNuIva(0);
                $tb052_compras->setMontoIva(0);
                $tb052_compras->setMontoSubTotal(0);
                $tb052_compras->setMontoTotal(0);
                $tb052_compras->setCoTipoMovimiento(0);
                $tb052_compras->setNumeroCompra($serial);
                $tb052_compras->setCoUsuario($this->getUser()->getAttribute('codigo'));
                $tb052_compras->save($con);


                $tb146_compromiso_asignacion = new Tb146CompromisoAsignacion();
                $tb146_compromiso_asignacion->setCoProveedor($datos_solicitud->getCoProveedor());
                $tb146_compromiso_asignacion->setCoCompras($tb052_compras->getCoCompras());
                $tb146_compromiso_asignacion->setTxDescripcion($tb146_compromiso_asignacionForm["tx_descripcion"]);
                $tb146_compromiso_asignacion->setCoUsuario($this->getUser()->getAttribute('codigo'));

                


                $tb146_compromiso_asignacion->setFeCompromiso($fecha);
                $tb146_compromiso_asignacion->setCoSolicitud($tb146_compromiso_asignacionForm["co_solicitud"]);
                $tb146_compromiso_asignacion->save($con);

                //$tb052_compras->setFechaCompra(date("Y-m-d")); 
                if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                    $tb052_compras->setFechaCompra($this->getUser()->getAttribute('fe_cierre'));
                } else {
                    $tb052_compras->setFechaCompra($fecha);
                }
                
            }

            $listaAsignacion  = json_decode($json_asignacion, true);



            foreach ($listaAsignacion  as $asignacionForm) {

                if (empty($asignacionForm["co_detalle_compras"])) {

                    $tb053_detalle_compras = new Tb053DetalleCompras();
                    $tb053_detalle_compras->setCoCompras($tb052_compras->getCoCompras());
                    $tb053_detalle_compras->setNuCantidad(1);
                    $tb053_detalle_compras->setCoProducto(18554);
                    $tb053_detalle_compras->setDetalle($asignacionForm["tx_descripcion"]);
                    $tb053_detalle_compras->setPrecioUnitario($asignacionForm["monto"]);
                    $tb053_detalle_compras->setMonto($asignacionForm["monto"]);
                    $tb053_detalle_compras->setCoPresupuesto($asignacionForm["co_partida"]);
                    $tb053_detalle_compras->setCoProyectoAc($asignacionForm["co_proyecto"]);
                    $tb053_detalle_compras->setCoAccionEspecifica($asignacionForm["co_accion"]);
                    $tb053_detalle_compras->save($con);
                }
            }

            $c = new Criteria();
            $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
            $c->add(Tb052ComprasPeer::CO_COMPRAS, $tb052_compras->getCoCompras());
            $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);

            $monto = 0;
            while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $monto += $reg["monto"];
            }

            $tb146_compromiso_asignacion->setNuMonto($monto)->save($con);
            $tb052_compras->setMontoTotal($monto)->save($con);

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb146_compromiso_asignacionForm["co_solicitud"]));
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
                "msg" =>  $e->getMessage()
            ));
        }

        $this->setTemplate('guardar');
    }

    public function executeGuardar(sfWebRequest $request)
    {

        
        $tb026_solicitudForm = $this->getRequestParameter('tb026_solicitud');
        $con = Propel::getConnection();
        $con->beginTransaction();

        try {
            if ($tb026_solicitudForm["co_solicitud"] != '') {            
                $Tb026Solicitud = Tb026SolicitudPeer::retrieveByPk($tb026_solicitudForm["co_solicitud"]);
                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb026_solicitudForm["co_solicitud"]));
            } else {


                //$tb053_detalle_compras = new Tb053DetalleCompras();

                $cs = new Criteria();
                $cs->add(Tb136TipoDocumentoPeer::CO_TIPO_DOCUMENTO, $tb026_solicitudForm["co_tipo_solicitud"]);
                $stmts = Tb136TipoDocumentoPeer::doSelectStmt($cs);
                $resp = $stmts->fetch(PDO::FETCH_ASSOC);

                $sigla = $resp["tx_sigla"];

                $datos_solicitud = array(
                    "co_tipo_solicitud"   => $tb026_solicitudForm["co_tipo_solicitud"],
                    "ejercicio"           => $this->getUser()->getAttribute('ejercicio'),
                    "fe_solicitud"        => date("d/m/Y"),
                    "observacion"         => $tb026_solicitudForm["tx_descripcion"],
                    "codigo"              => $this->getUser()->getAttribute('codigo')
                );

                $resp = Tb026SolicitudPeer::setSolicitud($datos_solicitud, $con);

                if ($resp["success"] == true) {

                                        
                    $Tb026Solicitud = Tb026SolicitudPeer::retrieveByPK($resp["co_solicitud"]);
                    $Tb026Solicitud->setCoProveedor($tb026_solicitudForm["co_proveedor"])->save($con);

                    $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($resp["co_solicitud"]));
                    $ruta->setInCargarDato(true)->save($con);
                } else {
                    $this->data = json_encode(array(
                        "success"       => false,
                        "co_solicitud"  => $resp["co_solicitud"],
                        "msg"           =>  $resp["msg"]
                    ));

                    return;
                }              

            }
            $con->commit();
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

            $this->data = json_encode(array(
                "success" => true,
                "co_solicitud" => $resp["co_solicitud"],
                "msg" => 'Registro guardado exitosamente'
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


    public function executeEliminar(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_compromiso_asignacion");
        $con = Propel::getConnection();
        try {
            $con->beginTransaction();
            /*CAMPOS*/
            $tb146_compromiso_asignacion = Tb146CompromisoAsignacionPeer::retrieveByPk($codigo);
            $tb146_compromiso_asignacion->delete($con);
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
            "co_tipo_solicitud" => 1,
            "tx_url"            => $this->getRequestParameter("tx_url"),

        ));

        $this->getRequest()->setAttribute('in_activo', $this->getUser()->getAttribute('in_activo'));
    }

    public function executeStorefkcotipoproceso(sfWebRequest $request)
    {

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
        $c->add(Tb027TipoSolicitudPeer::CO_PROCESO, 68);
        $stmt = Tb027TipoSolicitudPeer::doSelectStmt($c);
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
        $c->addSelectColumn(Tb026SolicitudPeer::TX_OBSERVACION);
        // $c->addSelectColumn(Tb052ComprasPeer::MONTO_TOTAL);
        //  $c->addSelectColumn(Tb052ComprasPeer::NUMERO_COMPRA);
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
        //  $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD,  Criteria::JOIN);

        $c->addAnd(Tb027TipoSolicitudPeer::CO_PROCESO, 68);
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
                "tx_observacion"       => strtoupper(trim($res["tx_observacion"])),
                "co_proceso"        => trim($res["co_proceso"]),
                "numero_compra"        => trim($res["numero_compra"]),
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


    //modelo fk tb008_proveedor.CO_PROVEEDOR
    public function executeStorefkcoproveedor(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb008ProveedorPeer::doSelectStmt($c);
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

    public function executeStorefkcompromiso(sfWebRequest $request)
    {

        $co_compras = $this->getRequestParameter("co_compras");

        $c = new Criteria();
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
        $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
        $c->addSelectColumn(Tb082EjecutorPeer::NU_EJECUTOR);
        $c->addSelectColumn(Tb082EjecutorPeer::DE_EJECUTOR);
        $c->addSelectColumn(Tb083ProyectoAcPeer::NU_PROYECTO_AC);
        $c->addSelectColumn(Tb083ProyectoAcPeer::DE_PROYECTO_AC);
        $c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
        $c->add(Tb052ComprasPeer::CO_COMPRAS, $co_compras);
        $c->addJoin(Tb053DetalleComprasPeer::CO_PRESUPUESTO, Tb085PresupuestoPeer::ID);
        $c->addJoin(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA, Tb084AccionEspecificaPeer::ID);
        $c->addJoin(Tb084AccionEspecificaPeer::ID_TB083_PROYECTO_AC, Tb083ProyectoAcPeer::ID);
        $c->addJoin(Tb085PresupuestoPeer::CO_ENTE, Tb082EjecutorPeer::ID);
        $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = array(
                "co_detalle_compras"     => trim($reg["co_detalle_compras"]),
                "tx_ejecutor"     => trim($reg["nu_ejecutor"]) . ' - ' . trim($reg["de_ejecutor"]),
                "tx_proyecto"     => trim($reg["nu_proyecto_ac"]) . ' - ' . trim($reg["de_proyecto_ac"]),
                "tx_partida"     => trim($reg["nu_partida"]) . ' - ' . trim($reg["de_partida"]),
                "monto"     => trim($reg["monto"]),
            );
        }
        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
        ));

        $this->setTemplate('store');
    }

    public function executeStorefkasignacion(sfWebRequest $request)
    {

        $co_solicitud = $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addSelectColumn(Tb052ComprasPeer::TX_OBSERVACION);
        $c->addSelectColumn(Tb052ComprasPeer::FECHA_COMPRA);
        $c->addSelectColumn(Tb052ComprasPeer::NUMERO_COMPRA);
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_TOTAL);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $co_solicitud);
        $stmt = Tb052ComprasPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = array(
                "co_compras"     => trim($reg["co_compras"]),
                "tx_observacion" => trim($reg["tx_observacion"]),
                "fecha_compra"   => trim($reg["fecha_compra"]),
                "numero_compra"  => trim($reg["numero_compra"]),
                "monto_total"    => trim($reg["monto_total"]),
            );
        }
        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
        ));

        $this->setTemplate('store');
    }

   /* public function executeEliminarCompromiso(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("co_detalle_compras");

        $con = Propel::getConnection();
        try {
            $con->beginTransaction();
            /*CAMPOS*/
          //  $Tb053DetalleCompra = Tb053DetalleComprasPeer::retrieveByPk($codigo);
            /*      Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $Tb053DetalleCompra->getCoPresupuesto(), 4, $Tb053DetalleCompra->getMonto(), '', $Tb053DetalleCompra->getCoDetalleCompras());
            Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $Tb053DetalleCompra->getCoPresupuesto(), 13, $Tb053DetalleCompra->getMonto(), '', $Tb053DetalleCompra->getCoDetalleCompras());
        
            $co_compras = $Tb053DetalleCompra->getCoCompras();
            $Tb053DetalleCompra->delete($con);


            $Tb052Compras = Tb052ComprasPeer::retrieveByPk($co_compras);
            $co_solicitud = $Tb052Compras->getCoSolicitud();
            $Tb052Compras->delete($con);

            $c = new Criteria();
            $c->add(Tb052ComprasPeer::CO_SOLICITUD,  $co_solicitud);
            $cant = Tb052ComprasPeer::doCount($c);

            // $Tb052Compra = Tb052ComprasPeer::retrieveByPk($co_compras);

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
    }*/

    public function executeEliminarAsignacion(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("co_compras");

        $con = Propel::getConnection();
        try {
            $con->beginTransaction();

            $datos_compra = Tb052ComprasPeer::retrieveByPK($codigo);
            $co_solicitud = $datos_compra->getCoSolicitud();
           
            $wheredc = new Criteria();
            $wheredc->add(Tb053DetalleComprasPeer::CO_COMPRAS,$codigo, Criteria::EQUAL);
            BasePeer::doDelete($wheredc, $con);

            $wherecc = new Criteria();
            $wherecc->add(Tb146CompromisoAsignacionPeer::CO_COMPRAS,$codigo, Criteria::EQUAL);
            BasePeer::doDelete($wherecc, $con);

            $wherec = new Criteria();
            $wherec->add(Tb052ComprasPeer::CO_COMPRAS,$codigo, Criteria::EQUAL);
            BasePeer::doDelete($wherec, $con);

            $c = new Criteria();
            $c->add(Tb052ComprasPeer::CO_SOLICITUD,  $co_solicitud);
            $cant = Tb052ComprasPeer::doCount($c);

            // $Tb052Compra = Tb052ComprasPeer::retrieveByPk($co_compras);

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
}
