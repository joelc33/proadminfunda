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
class BienesActions extends sfActions
{

    public function executeIndex(sfWebRequest $request)
    {

        $this->ejercicio = $this->getUser()->getAttribute('ejercicio');
        $this->getRequest()->setAttribute('ejercicio', $this->ejercicio);

        $c = new Criteria();
        $c->setIgnoreCase(true);
        $c->add(Tb083ProyectoAcPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
        $cantidad = Tb083ProyectoAcPeer::doCount($c);

        // if( $cantidad >= 1){
        $this->forward('Bienes', 'listaBienes');
        /* }else{
    $this->forward('Asignacionpresupuesto', 'vacio');
    }*/
    }
    public function executeMovimientos(sfWebRequest $request)
    {

    }

    public function executeListaBienes(sfWebRequest $request)
    {

    }
    public function executeListaInmuebles(sfWebRequest $request)
    {

    }

    public function executeFiltro(sfWebRequest $request)
    {

    }
    public function executeDetallebienes(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("codigo");
        if ($codigo != '' || $codigo != null) {
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb171BienesPeer::CO_BIENES);
            $c->addSelectColumn(Tb171BienesPeer::TX_SERIAL);
            $c->addSelectColumn(Tb171BienesPeer::NU_BIENES);
            $c->addSelectColumn(Tb171BienesPeer::TX_DETALLE);
            //$c->addSelectColumn(Tb174MarcaPeer::TX_MARCA);
            //$c->addSelectColumn(Tb175ModeloPeer::TX_MODELO);
            //$c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
            $c->addSelectColumn(Tb171BienesPeer::IN_ACTIVO);
            $c->addSelectColumn(Tb171BienesPeer::IN_INCORPORADO);
            //$c->addSelectColumn(Tb045FacturaPeer::NU_FACTURA);
            //$c->addSelectColumn(Tb170TipoIncorporacionPeer::TX_TIPO_INCORPORACION);
            //$c->addSelectColumn(Tbbn004SubtipoMovimientoBienesPeer::TX_SUBTIPO_MOVIMIENTO);
            //$c->addSelectColumn(Tbbn005TipoDocumentoPeer::DESC_DOCUMENTO);
            //$c->addSelectColumn(Tb053DetalleComprasPeer::PRECIO_UNITARIO);
            //$c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
            //$c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
            $c->addSelectColumn(Tb171BienesPeer::CREATED_AT);
            $c->addSelectColumn(Tb171BienesPeer::UPDATED_AT);
            //$c->addJoin(Tb175ModeloPeer::CO_MODELO, Tb171BienesPeer::CO_MODELO, Criteria::LEFT_JOIN);
            //$c->addJoin(Tb174MarcaPeer::CO_MARCA, Tb175ModeloPeer::CO_MARCA, Criteria::LEFT_JOIN);
            //$c->addJoin(Tb171BienesPeer::CO_PRODUCTO, Tb048ProductoPeer::CO_PRODUCTO, Criteria::LEFT_JOIN);
            //$c->addJoin(Tbbn004SubtipoMovimientoBienesPeer::CO_SUBTIPO_MOVIMIENTO_BIENES, Tb171BienesPeer::CO_TIPO_INCORPORACION, Criteria::LEFT_JOIN);
            //$c->addJoin(Tbbn005TipoDocumentoPeer::CO_DOCUMENTO, Tb171BienesPeer::CO_DOC_INCOR, Criteria::LEFT_JOIN);
            // $c->addJoin(Tb170TipoIncorporacionPeer::CO_TIPO_INCORPORACION, Tb171BienesPeer::CO_TIPO_INCORPORACION);
            //$c->addJoin(Tb171BienesPeer::CO_DETALLE_COMPRAS, Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS, Criteria::LEFT_JOIN);
            //$c->addJoin(Tb053DetalleComprasPeer::CO_FACTURA, Tb045FacturaPeer::CO_FACTURA, Criteria::LEFT_JOIN);
            //$c->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS, Criteria::LEFT_JOIN);
            //$c->addJoin(Tb052ComprasPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR, Criteria::LEFT_JOIN);
            //$c->addJoin(Tb045FacturaPeer::CO_ODP, Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Criteria::LEFT_JOIN);
            $c->add(Tb171BienesPeer::CO_BIENES, $codigo);
            $c->addGroupByColumn(Tb171BienesPeer::CO_BIENES);
            //$c->addGroupByColumn(Tb174MarcaPeer::TX_MARCA);
            //$c->addGroupByColumn(Tb175ModeloPeer::TX_MODELO);
            //$c->addGroupByColumn(Tb045FacturaPeer::NU_FACTURA);
            //$c->addGroupByColumn(Tb060OrdenPagoPeer::TX_SERIAL);
            //$c->addGroupByColumn(Tb048ProductoPeer::TX_PRODUCTO);
            //$c->addGroupByColumn(Tb170TipoIncorporacionPeer::CO_TIPO_INCORPORACION);
            //$c->addGroupByColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
            //$c->addGroupByColumn(Tb008ProveedorPeer::TX_RIF);
            //$c->addGroupByColumn(Tb053DetalleComprasPeer::PRECIO_UNITARIO);
            //$c->addGroupByColumn(Tbbn004SubtipoMovimientoBienesPeer::TX_SUBTIPO_MOVIMIENTO);
            //$c->addGroupByColumn(Tbbn005TipoDocumentoPeer::DESC_DOCUMENTO);
            // $c->addGroupByColumn(Tb173MovimientoBienesPeer::CO_EJECUTOR);
            // $c->addGroupByColumn(Tb173MovimientoBienesPeer::CO_FISICO);
            $c->setLimit($limit)->setOffset($start);
            $c->addAscendingOrderByColumn(Tb171BienesPeer::CO_BIENES);

            $stmt = Tb171BienesPeer::doSelectStmt($c);
            //var_dump($stmt);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->data = json_encode(array(
                "co_bienes" => $campos["co_bienes"],
                "nu_bienes" => $campos["nu_bienes"],
                "tx_serial" => $campos["tx_serial"],
                "tx_tipo_incorporacion" => $campos["tx_subtipo_movimiento"],
                "desc_documento" => $campos["desc_documento"],
                "tx_razon_social" => $campos["tx_razon_social"],
                "precio_unitario" => $campos["precio_unitario"],
                "tx_rif" => $campos["tx_rif"],
                "tx_producto" => $campos["tx_producto"],
                "tx_detalle" => $campos["tx_detalle"],
                "in_activo" => $campos["in_activo"],
                "created_at" => $campos["created_at"],
                "updated_at" => $campos["updated_at"],
            ));
        } else {
            $this->data = json_encode(array(
                "co_bienes" => "",
                "tx_detalle" => "",
                "tx_producto" => "",
                "tx_razon_social" => "",
                "precio_unitario" => "",
                "tx_rif" => "",
                "tx_tipo_incorporacion" => "",
                "nu_bienes" => "",
                "tx_serial" => "",
                "in_activo" => "",
                "created_at" => "",
                "updated_at" => "",
            ));
        }

    }

    public function executeDetalleinm(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("codigo");
        if ($codigo != '' || $codigo != null) {
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb171BienesPeer::CO_BIENES);
            $c->addSelectColumn(Tb171BienesPeer::NU_BIENES);
            $c->addSelectColumn(Tb171BienesPeer::TX_DETALLE);
            $c->addSelectColumn(Tb171BienesPeer::DESC_INM);
            $c->addSelectColumn(Tb171BienesPeer::TX_DIRECCION);
            $c->addSelectColumn(Tb171BienesPeer::TX_ESTADO_LEGAL);
            $c->addSelectColumn(Tbbn005TipoDocumentoPeer::DESC_DOCUMENTO);
            $c->addSelectColumn(Tb171BienesPeer::NU_AVALUO_ACT);
            $c->addSelectColumn(Tb171BienesPeer::CREATED_AT);
            $c->addSelectColumn(Tb171BienesPeer::NU_AVALUO_ACT);
            $c->addSelectColumn(Tbbn012ClasificacionInmueblePeer::TX_CLASIFICACION_INMUEBLE);
            $c->addSelectColumn(Tbbn014TipoInmueblePeer::TX_TIPO_INMUEBLE);
            $c->addSelectColumn(Tb171BienesPeer::TX_LINDERO_NORTE);
            $c->addSelectColumn(Tb171BienesPeer::TX_LINDERO_SUR);
            $c->addSelectColumn(Tb171BienesPeer::TX_LINDERO_ESTE);
            $c->addSelectColumn(Tb171BienesPeer::TX_LINDERO_OESTE);
            $c->addSelectColumn(Tb171BienesPeer::TX_LINDERO_INMUEBLE);
            $c->addSelectColumn(Tb171BienesPeer::NU_AREA_CONSTRUCCION);
            $c->addSelectColumn(Tb171BienesPeer::NU_AREA_CUBIERTA);
            $c->addSelectColumn(Tb171BienesPeer::NU_AREA_OI);
            $c->addSelectColumn(Tb171BienesPeer::NU_AREA_TERRENO);
            $c->addSelectColumn(Tb089UnidadMedidaPeer::DE_UNIDAD_MEDIDA);
            $c->addSelectColumn(Tb171BienesPeer::NU_MONTO);
            $c->addSelectColumn(Tb171BienesPeer::NU_AVALUO_ACT);
            $c->addSelectColumn(Tb171BienesPeer::NU_AVALUO_COMPRA);
            $c->addSelectColumn("to_char(" . Tb171BienesPeer::CREATED_AT . ",'DD-MM-YYYY') AS fecha");
            $c->addJoin(Tbbn004SubtipoMovimientoBienesPeer::CO_SUBTIPO_MOVIMIENTO_BIENES, Tb171BienesPeer::CO_TIPO_INCORPORACION);
            $c->addJoin(Tbbn005TipoDocumentoPeer::CO_DOCUMENTO, Tb171BienesPeer::CO_DOC_INCOR);
            $c->addJoin(Tbbn012ClasificacionInmueblePeer::CO_CLASIFICACION_INMUEBLE, Tb171BienesPeer::CO_CLASIFICACION_INMUEBLE);
            $c->addJoin(Tbbn014TipoInmueblePeer::CO_TIPO_INMUEBLE, Tb171BienesPeer::CO_TIPO_INMUEBLE);
            $c->addJoin(Tb089UnidadMedidaPeer::ID, Tb171BienesPeer::CO_MEDIDA);

            $c->add(Tb171BienesPeer::CO_BIENES, $codigo);
            // $c->addGroupByColumn(Tb173MovimientoBienesPeer::CO_EJECUTOR);
            // $c->addGroupByColumn(Tb173MovimientoBienesPeer::CO_FISICO);
            $c->setLimit($limit)->setOffset($start);
            $c->addAscendingOrderByColumn(Tb171BienesPeer::TX_DETALLE);

            $stmt = Tb171BienesPeer::doSelectStmt($c);
            //var_dump($stmt);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->data = json_encode(array(
                "co_bienes" => $campos["co_bienes"],
                "nu_bienes" => $campos["nu_bienes"],
                "desc_documento" => $campos["desc_documento"],
                "tx_detalle" => $campos["tx_detalle"],
                "desc_inm" => $campos["desc_inm"],
                "tx_direccion" => $campos["tx_direccion"],
                "tx_estado_legal" => $campos["tx_estado_legal"],
                "fecha" => $campos["fecha"],
                "tx_clasificacion" => $campos["tx_clasificacion_inmueble"],
                "tx_tipo" => $campos["tx_tipo_inmueble"],
                "norte" => $campos["tx_lindero_norte"],
                "sur" => $campos["tx_lindero_sur"],
                "este" => $campos["tx_lindero_este"],
                "oeste" => $campos["tx_lindero_oeste"],
                "lindero" => $campos["tx_lindero_inmueble"],
                "construccion" => $campos["nu_area_construccion"],
                "cubierta" => $campos["nu_area_cubierta"],
                "oi" => $campos["nu_area_oi"],
                "terreno" => $campos["nu_area_terreno"],
                "medida" => $campos["de_unidad_medida"],
                "precio" => $campos["nu_monto"],
                "avaluo" => $campos["nu_avaluo_act"],
                "compra" => $campos["nu_avaluo_compra"],
            ));
        } else {
            $this->data = json_encode(array(
                "co_bienes" => "",
                "tx_detalle" => "",
                "tx_producto" => "",
                "tx_razon_social" => "",
                "precio_unitario" => "",
                "tx_rif" => "",
                "tx_tipo_incorporacion" => "",
                "nu_bienes" => "",
                "tx_serial" => "",
                "in_activo" => "",
                "created_at" => "",
                "updated_at" => "",
                "fecha" => "",
            ));
        }

    }
    public function executeVerificarNuBien(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tb171BienesPeer::NU_BIENES, $this->getRequestParameter("nu_bienes"));
        $stmt = Tb171BienesPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }
        if ($registros) {
            $this->data = json_encode(array(
                "success" => true,
            ));
        } else {
            $this->data = json_encode(array(
                "success" => false,
            ));
        }
        /*$registros = array();
    while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = $reg;
    }*/

    }
    public function executeVerificarSerialBien(sfWebRequest $request)
    {

        if (in_array($this->getRequestParameter("tx_serial_bien"), array(' ', '.'))) {
            $this->data = json_encode(array(
                "success" => false,
            ));
        } else {
            $c = new Criteria();
            $c->add(Tb171BienesPeer::TX_SERIAL, $this->getRequestParameter("tx_serial_bien"));
            $stmt = Tb171BienesPeer::doSelectStmt($c);
            $registros = array();
            while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $registros[] = $reg;
            }
            if ($registros) {
                $this->data = json_encode(array(
                    "success" => true,
                ));
            } else {
                $this->data = json_encode(array(
                    "success" => false,
                ));
            }
        }

        /*$registros = array();
    while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = $reg;
    }*/

    }
    public function executeRegistrar(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb026SolicitudPeer::CO_USUARIO);
        $c->addSelectColumn(Tb026SolicitudPeer::CREATED_AT);
        $c->addSelectColumn(Tbbn016ReportePeer::CO_REPORTE);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tbbn016ReportePeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        //var_dump($stmt);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($campos["co_reporte"]) {

            $datos = $this->getDatosSolicitante($campos["co_usuario"]);

            list($anio, $mes, $dia) = explode("-", $campos["created_at"]);

            $this->data = json_encode(array(
                "co_bienes" => $campos["co_bienes"],
                "co_solicitud" => $this->getRequestParameter("co_solicitud"),
                "nb_solicitante" => $datos["nb_usuario"],
                "tx_entidad" => $datos["tx_ente"],
                "co_ente" => $datos["co_ente"],
                "co_usuario" => $campos["co_usuario"],
                "fe_registro" => $dia . '-' . $mes . '-' . $anio,
                "co_reporte" => $campos["co_reporte"],
            ));
        } else {

            $datos = $this->getDatosSolicitante($this->getUser()->getAttribute('codigo'));

            $this->data = json_encode(array(
                "co_bienes" => "",
                "co_solicitud" => $this->getRequestParameter("co_solicitud"),
                "nb_solicitante" => $datos["nb_usuario"],
                "tx_entidad" => $datos["tx_ente"],
                "fe_registro" => date("d-m-Y"),
                "co_usuario" => $datos["co_usuario"],
                "co_ente" => $datos["co_ente"],
                "co_reporte" => '',
            ));
        }

    }

    public function executeTraslado(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb026SolicitudPeer::CO_USUARIO);
        $c->addSelectColumn(Tb026SolicitudPeer::CREATED_AT);
        $c->addSelectColumn(Tbbn016ReportePeer::CO_REPORTE);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tbbn016ReportePeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        //var_dump($stmt);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($campos["co_reporte"]) {

            $datos = $this->getDatosSolicitante($campos["co_usuario"]);

            list($anio, $mes, $dia) = explode("-", $campos["created_at"]);

            $this->data = json_encode(array(
                "co_bienes" => $campos["co_bienes"],
                "co_solicitud" => $this->getRequestParameter("co_solicitud"),
                "nb_solicitante" => $datos["nb_usuario"],
                "tx_entidad" => $datos["tx_ente"],
                "co_ente" => $datos["co_ente"],
                "co_usuario" => $campos["co_usuario"],
                "fe_registro" => $dia . '-' . $mes . '-' . $anio,
                "co_reporte" => $campos["co_reporte"],
            ));
        } else {

            $datos = $this->getDatosSolicitante($this->getUser()->getAttribute('codigo'));

            $this->data = json_encode(array(
                "co_bienes" => "",
                "co_solicitud" => $this->getRequestParameter("co_solicitud"),
                "nb_solicitante" => $datos["nb_usuario"],
                "tx_entidad" => $datos["tx_ente"],
                "fe_registro" => date("d-m-Y"),
                "co_usuario" => $datos["co_usuario"],
                "co_ente" => $datos["co_ente"],
                "co_reporte" => '',
            ));
        }

    }

    public function executeDesincorporacion(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");
        $c = new Criteria();
        $c->addSelectColumn(Tb026SolicitudPeer::CO_USUARIO);
        $c->addSelectColumn(Tb026SolicitudPeer::CREATED_AT);
        $c->addSelectColumn(Tbbn016ReportePeer::CO_REPORTE);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tbbn016ReportePeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        //var_dump($stmt);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($campos["co_reporte"]) {

            $datos = $this->getDatosSolicitante($campos["co_usuario"]);

            list($anio, $mes, $dia) = explode("-", $campos["created_at"]);

            $this->data = json_encode(array(
                "co_bienes" => $campos["co_bienes"],
                "co_solicitud" => $this->getRequestParameter("co_solicitud"),
                "nb_solicitante" => $datos["nb_usuario"],
                "tx_entidad" => $datos["tx_ente"],
                "co_ente" => $datos["co_ente"],
                "co_usuario" => $campos["co_usuario"],
                "fe_registro" => $dia . '-' . $mes . '-' . $anio,
                "co_reporte" => $campos["co_reporte"],
            ));
        } else {

            $datos = $this->getDatosSolicitante($this->getUser()->getAttribute('codigo'));

            $this->data = json_encode(array(
                "co_bienes" => "",
                "co_solicitud" => $this->getRequestParameter("co_solicitud"),
                "nb_solicitante" => $datos["nb_usuario"],
                "tx_entidad" => $datos["tx_ente"],
                "fe_registro" => date("d-m-Y"),
                "co_usuario" => $datos["co_usuario"],
                "co_ente" => $datos["co_ente"],
                "co_reporte" => '',
            ));
        }

    }



    
        public function executeRegistrarInm(sfWebRequest $request)
        {
            $codigo = $this->getRequestParameter("co_solicitud");

            $c = new Criteria();
            $c->addSelectColumn(Tb026SolicitudPeer::CO_USUARIO);
            $c->addSelectColumn(Tb026SolicitudPeer::CREATED_AT);
            $c->addSelectColumn(Tbbn016ReportePeer::CO_REPORTE);
            $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tbbn016ReportePeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
            $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $codigo);

            $stmt = Tb026SolicitudPeer::doSelectStmt($c);
            //var_dump($stmt);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($campos["co_reporte"]) {

                $datos = $this->getDatosSolicitante($campos["co_usuario"]);

                list($anio, $mes, $dia) = explode("-", $campos["created_at"]);

                $this->data = json_encode(array(
                    "co_bienes" => $campos["co_bienes"],
                    "co_solicitud" => $this->getRequestParameter("co_solicitud"),
                    "nb_solicitante" => $datos["nb_usuario"],
                    "tx_entidad" => $datos["tx_ente"],
                    "co_ente" => $datos["co_ente"],
                    "co_usuario" => $campos["co_usuario"],
                    "fe_registro" => $dia . '-' . $mes . '-' . $anio,
                    "co_reporte" => $campos["co_reporte"],
                ));
            } else {

                $datos = $this->getDatosSolicitante($this->getUser()->getAttribute('codigo'));

                $this->data = json_encode(array(
                    "co_bienes" => "",
                    "co_solicitud" => $this->getRequestParameter("co_solicitud"),
                    "nb_solicitante" => $datos["nb_usuario"],
                    "tx_entidad" => $datos["tx_ente"],
                    "fe_registro" => date("d-m-Y"),
                    "co_usuario" => $datos["co_usuario"],
                    "co_ente" => $datos["co_ente"],
                    "co_reporte" => '',
                ));
            }

        }

    public function executeStorefkubicacion(sfWebRequest $request)
    {
        $i = 1;
        $c = new Criteria();
        $c->addSelectColumn(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA);
        $c->addSelectColumn(Tbbn006OrganigramaPeer::NU_NIVEL);
        $c->add(Tb173MovimientoBienesPeer::CO_BIENES, $this->getRequestParameter("co_bienes"));
        $c->add(Tb173MovimientoBienesPeer::IN_ACTIVO, true);
        $c->addJoin(Tbbn008DocumentoBienesPeer::CO_DOCUMENTO_BIENES, Tb173MovimientoBienesPeer::CO_DOCUMENTO);
        $c->addJoin(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA, Tbbn008DocumentoBienesPeer::CO_UBICACION);
        $c->addAscendingOrderByColumn(Tb173MovimientoBienesPeer::CO_MOVIMIENTO_BIENES);
        $c->setLimit(1);
        $stmt = Tb173MovimientoBienesPeer::doSelectStmt($c);

        $registros = array();
        $nivel = 0;

        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $nivel = $reg['nu_nivel'];
            $ubicacion = $reg['co_organigrama'];
            $registros[] = $reg;
        }
        $regiubi = array();
        for ($i = 1; $i <= $nivel; $i++) {

            $d = new Criteria();
            $d->add(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA, $ubicacion);
            $stmt2 = Tbbn006OrganigramaPeer::doSelectStmt($d);

            while ($reg2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $ubicacion = $reg2['co_padre'];
                $regiubi[] = $reg2;
            }

        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($regiubi),
            "data" => $regiubi,
        ));
        $this->setTemplate('store');
    }

    public function executeStorefkubicacion2(sfWebRequest $request)
    {
        $adm = $this->getRequestParameter("tx_ubicacion");
        $cia = $this->getRequestParameter("tx_cia");
        $i = 1;
        $c = new Criteria();
        if ($adm && $cia) {
            $c->add(Tbbn006OrganigramaPeer::COD_ADM, $adm);
            $c->add(Tbbn006OrganigramaPeer::COD_CIA, $cia);
        } else {
            $c->add(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA, $this->getRequestParameter("co_organigrama"));
        }

        $c->add(Tbbn006OrganigramaPeer::IN_ACTIVO, true);
        $c->addAscendingOrderByColumn(Tbbn006OrganigramaPeer::NU_NIVEL);
        $stmt = Tbbn006OrganigramaPeer::doSelectStmt($c);

        $registros = array();
        $nivel = 0;

        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $nivel = $reg['nu_nivel'];
            $ubicacion = $reg['co_organigrama'];
            $registros[] = $reg;
        }
        $regiubi = array();
        for ($i = 1; $i <= $nivel; $i++) {

            $d = new Criteria();
            $d->add(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA, $ubicacion);
            $stmt2 = Tbbn006OrganigramaPeer::doSelectStmt($d);

            while ($reg2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $ubicacion = $reg2['co_padre'];
                $regiubi[] = $reg2;
            }

        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($regiubi),
            "data" => $regiubi,
        ));
        $this->setTemplate('store');
    }

    public function executeStorefklistubicacion(sfWebRequest $request)
    {
        $padre = $this->getRequestParameter("co_organigrama");
        $adm = $this->getRequestParameter("tx_ubicacion");
        $cia = $this->getRequestParameter("tx_cia");
        $nivel = 1;

        $c = new Criteria();
        if ($adm && $cia) {
            $p = Tbbn006OrganigramaPeer::getCoOrganigrama($adm, $cia);
            $c->add(Tbbn006OrganigramaPeer::CO_PADRE, $p);
        } else {
            if ($padre != '') {
                $c->add(Tbbn006OrganigramaPeer::CO_PADRE, $padre);
            } else {
                $c->add(Tbbn006OrganigramaPeer::NU_NIVEL, $nivel);
            }
        }

        $c->add(Tbbn006OrganigramaPeer::IN_ACTIVO, true);
        $c->addAscendingOrderByColumn(Tbbn006OrganigramaPeer::COD_ADM);
        $stmt = Tbbn006OrganigramaPeer::doSelectStmt($c);
        $registros = array();
        /*
        {name: 'co_organigrama'},
        {name: 'tx_organigrama'},
        {name: 'co_padre'},
        {name: 'nu_nivel'},
        {name: 'tx_punto_referencia'},
        {name: 'cod_adm'},

         */
        $i = 0;
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if ($reg['tx_organigrama'] == null) {
                $registros[$i]['tx_organigrama'] = $reg['cod_adm'];
            } else {
                $registros[$i]['tx_organigrama'] = $reg['tx_organigrama'];
            }
            $registros[$i]['co_organigrama'] = $reg['co_organigrama'];
            $registros[$i]['co_padre'] = $reg['co_padre'];
            $registros[$i]['nu_nivel'] = $reg['nu_nivel'];
            $registros[$i]['tx_punto_referencia'] = $reg['tx_punto_referencia'];
            $registros[$i]['cod_adm'] = $reg['cod_adm'];
            $registros[$i]['cod_cia'] = $reg['cod_cia'];
            $i++;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }

    public function executeStorefkcotipoincorporacion(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tbbn004SubtipoMovimientoBienesPeer::CO_TIPO_MOVIMIENTO_BIENES, 1);
        $c->addAscendingOrderByColumn(Tbbn004SubtipoMovimientoBienesPeer::TX_SUBTIPO_MOVIMIENTO);
        $stmt = Tbbn004SubtipoMovimientoBienesPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }
    public function executeStorefkcodocumentoincorporacion(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tbbn005TipoDocumentoPeer::CO_TIPO_MOVIMIENTO_BIENES, 1);
        $c->addAscendingOrderByColumn(Tbbn005TipoDocumentoPeer::DESC_DOCUMENTO);
        $stmt = Tbbn005TipoDocumentoPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }
    public function executeStorefkcotipomovimiento(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tbbn004SubtipoMovimientoBienesPeer::CO_TIPO_MOVIMIENTO_BIENES, $this->getRequestParameter("co_tipo_movimiento"));
        $c->addAscendingOrderByColumn(Tbbn004SubtipoMovimientoBienesPeer::TX_SUBTIPO_MOVIMIENTO);
        $stmt = Tbbn004SubtipoMovimientoBienesPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }
    public function executeStorefkcodocumento(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tbbn005TipoDocumentoPeer::CO_TIPO_MOVIMIENTO_BIENES, $this->getRequestParameter("co_tipo_documento"));
        $c->addAscendingOrderByColumn(Tbbn005TipoDocumentoPeer::DESC_DOCUMENTO);
        $stmt = Tbbn005TipoDocumentoPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }
    public function executeStorefklistejecutor(sfWebRequest $request)
    {
        $depe = $this->getRequestParameter("co_dependencia");
        if (!isset($depe) && empty($depe)) {
            $depe = 1;
        }
        $c = new Criteria();
        $c->add(Tb082EjecutorPeer::CO_DEPENDENCIA, $depe);
        $c->addAscendingOrderByColumn(Tb082EjecutorPeer::DE_EJECUTOR);
        $stmt = Tb082EjecutorPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }

    public function executeStorefklistejecutor2(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb082EjecutorPeer::ID);
        $stmt = Tb082EjecutorPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }

    public function executeStorefklistdesincorporacion(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb176TipoDesincorporacionPeer::TX_TIPO_DESINCORPORACION);
        $stmt = Tb176TipoDesincorporacionPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }
    public function executeStorefklistincorporacion(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb170TipoIncorporacionPeer::TX_TIPO_INCORPORACION);
        $stmt = Tb170TipoIncorporacionPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }

    public function executeStorefklistmarca(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tb174MarcaPeer::IN_ACTIVO, true);
        $c->addAscendingOrderByColumn(Tb174MarcaPeer::TX_MARCA);
        $stmt = Tb174MarcaPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }
    public function executeStorefklistmodelo(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tb175ModeloPeer::CO_MARCA, $this->getRequestParameter("co_marca"));
        $c->add(Tb175ModeloPeer::IN_ACTIVO, true);
        $c->addAscendingOrderByColumn(Tb175ModeloPeer::TX_MODELO);
        $stmt = Tb175ModeloPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }
    public function executeStorefklisttipo(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tbbn014TipoInmueblePeer::IN_ACTIVO, true);
        $c->addAscendingOrderByColumn(Tbbn014TipoInmueblePeer::TX_TIPO_INMUEBLE);
        $stmt = Tbbn014TipoInmueblePeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }
    public function executeStorefklistmunicipio(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tb017MunicipioPeer::IN_ACTIVO, true);
        $c->add(Tb017MunicipioPeer::CO_ESTADO, 23);
        $c->addAscendingOrderByColumn(Tb017MunicipioPeer::NB_MUNICIPIO);
        $stmt = Tb017MunicipioPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }
    public function executeStorefklistparroquia(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tbbn003ParroquiaPeer::CO_MUNICIPIO, $this->getRequestParameter("co_municipio"));
        $c->add(Tbbn003ParroquiaPeer::IN_ACTIVO, true);
        $c->addAscendingOrderByColumn(Tbbn003ParroquiaPeer::TX_PARROQUIA);
        $stmt = Tbbn003ParroquiaPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }
    public function executeStorefklistmedidas(sfWebRequest $request)
    {
        $c = new Criteria();

        $c->addOr(Tb089UnidadMedidaPeer::ID, 635);
        $c->addOr(Tb089UnidadMedidaPeer::ID, 636);
        $c->addAscendingOrderByColumn(Tb089UnidadMedidaPeer::DE_UNIDAD_MEDIDA);
        $stmt = Tb089UnidadMedidaPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }

    public function executeStorefklistuso(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tbbn009UsoPeer::CO_UBICACION, $this->getRequestParameter("co_ubicacion"));
        $c->add(Tbbn009UsoPeer::IN_ACTIVO, true);
        $c->addAscendingOrderByColumn(Tbbn009UsoPeer::TX_USO);
        $stmt = Tbbn009UsoPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }

    public function executeStorefklistorganismos(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tbbn001OrganismosPeer::IN_ACTIVO, true);
        $c->addAscendingOrderByColumn(Tbbn001OrganismosPeer::TX_ORGANISMOS);
        $stmt = Tbbn001OrganismosPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }

    public function executeStorefklistdependencia(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tbrh003DependenciaPeer::CO_ORGANISMOS, $this->getRequestParameter("co_organismos"));
        $c->add(Tbrh003DependenciaPeer::IN_ACTIVO, true);
        $c->addAscendingOrderByColumn(Tbrh003DependenciaPeer::TX_DEPENDENCIA);
        $stmt = Tbrh003DependenciaPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }

    public function executeStorefklistente(sfWebRequest $request)
    {
        $ente = $this->getRequestParameter("co_dependencia");
        if (!isset($ente) && empty($ente)) {
            $ente = 1;
        }
        $c = new Criteria();
        $c->add(Tb047EntePeer::CO_DEPENDENCIA, $ente);
        $c->addAscendingOrderByColumn(Tb047EntePeer::TX_ENTE);
        $stmt = Tb047EntePeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }
    public function executeStorefklistproveedor(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $stmt = Tb008ProveedorPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reg['nombre']="$reg[tx_rif] $reg[tx_razon_social]";
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }

    public function executeStorefklistresponsables(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tbbn010ResponsablesPeer::NU_CEDULA);
        $stmt = Tbbn010ResponsablesPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }

    public function executeStorefklistclasificacion(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tbbn012ClasificacionInmueblePeer::TX_CLASIFICACION_INMUEBLE);
        $stmt = Tbbn012ClasificacionInmueblePeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }

    public function executeGuardarBien(sfWebRequest $request)
    {
        $con = Propel::getConnection();
        try
        {
            $con->beginTransaction();

            $listaBienes = json_decode($json_bienes, true);
            $array_bienes = array();
            $cantidad=$this->getRequestParameter("nu_cantidad");
            if($this->getRequestParameter("co_proveedor")!=null || $this->getRequestParameter("co_proveedor")!=''){
            $co_proveedor = $this->getRequestParameter("co_proveedor");    
            }else{
            $co_proveedor = NULL;     
            }
            
            $i = 1;
            //$nu_bien=''.date('Y').''.
            for($i=1;$i<=$cantidad;$i++){
                
            
            $tb171_bienes = new Tb171Bienes();
            $tb171_bienes->setCoDetalleCompras($this->getRequestParameter("co_detalle_compras"))
                ->setTxDetalle($this->getRequestParameter("tx_detalle"))
                ->setCoTipoIncorporacion($this->getRequestParameter("co_tipo_incorporacion"))
                ->setInActivo(false)
                ->setCoProducto($this->getRequestParameter("co_producto"))
                ->setCoUbicacion($this->getRequestParameter("co_ubicacion"))
                ->setCoUsuario($this->getRequestParameter("co_usuario"))
                ->setInIncorporado(true)
                ->setCoSolicitud($this->getRequestParameter("co_solicitud"))
                ->setCoProveedor($co_proveedor)
            //->setNuBienes($this->getRequestParameter("nu_bienes"))
            //->setTxSerial($this->getRequestParameter("tx_serial"))
                ->setCoDocIncor($this->getRequestParameter("co_documento"))
                ->setCoModelo($this->getRequestParameter("co_modelo"))
                ->setNuMonto($this->getRequestParameter("precio_unitario"))
               // ->setCoResponsable($this->getRequestParameter("co_responsable"))
                //->setCoUso($this->getRequestParameter("co_uso"))
                ->setCoTipoBienes(1)
                ->save($con);

            // $correlativo = str_pad($tb171_bienes->getCoBienes(),6,"0",STR_PAD_LEFT);
            //$adm=Tbbn006OrganigramaPeer::getNuOrganigrama($this->getRequestParameter("co_ubicacion"));

            $tb171_bienes->setNuBienes($tb171_bienes->getCoBienes())
                ->save($con);

//            if (Tbbn008DocumentoBienesPeer::getDocumentoBienes($this->getRequestParameter("co_documento"), $this->getRequestParameter("co_solicitud"), $this->getRequestParameter("co_tipo_incorporacion"), $this->getRequestParameter("co_ubicacion"))) {
//
//                $doc = Tbbn008DocumentoBienesPeer::getDocumentoBienes($this->getRequestParameter("co_documento"), $this->getRequestParameter("co_solicitud"), $this->getRequestParameter("co_tipo_incorporacion"), $this->getRequestParameter("co_ubicacion"));
//                $mo = Tbbn008DocumentoBienesPeer::getMontoDocumentoBienes($doc);
//                $monto = $this->getRequestParameter("precio_unitario") + $mo;
//                $tbbn008_documento_bienes = Tbbn008DocumentoBienesPeer::retrieveByPk($doc);
//
//                $tbbn008_documento_bienes->setNuMonto($monto)
//                    ->save($con);
//            } else {
                $tbbn008_documento_bienes = new Tbbn008DocumentoBienes();
                $tbbn008_documento_bienes->setCoTipoDocumento($this->getRequestParameter("co_documento"))
                    ->setInActivo(false)
                    ->setCoSolicitud($this->getRequestParameter("co_solicitud"))
                    ->setCoSubtipoMovimiento($this->getRequestParameter("co_tipo_incorporacion"))
                    ->setNuMonto($this->getRequestParameter("precio_unitario"))
                    ->setCoUbicacion($this->getRequestParameter("co_ubicacion"))
                    ->setCoBienes($tb171_bienes->getCoBienes())
                    ->save($con);

                $doc = $tbbn008_documento_bienes->getCoDocumentoBienes();
//            }

            $tb173_movimientos_bienes = new Tb173MovimientoBienes();
            $tb173_movimientos_bienes->setCoDocumento($doc)
                ->setCoBienes($tb171_bienes->getCoBienes())
                ->setCoUsuario($this->getRequestParameter("co_usuario"))
                ->setInActivo(false)
                ->setTxMotivo($this->getRequestParameter("tx_motivo"))
            //->setCoUbicacionOrigen($this->getRequestParameter("co_ubicacion_ant"))
                //->setCoUso($this->getRequestParameter("co_uso"))
                ->save($con);
            }

            $con->commit();
            $this->data = json_encode(array(
                "success" => true,
                "msg" =>   $this->getRequestParameter("nu_cantidad"),

            ));

        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage(),
            ));
        }
    }

    public function executeAgregarInmueble(sfWebRequest $request)
    {
        $con = Propel::getConnection();
        try
        {
            $con->beginTransaction();

            $array_bienes = array();
            $i = 0;
            //$nu_bien=''.date('Y').''.

            $tb171_bienes = new Tb171Bienes();
            $tb171_bienes->setTxDetalle($this->getRequestParameter("tx_observacion"))
                ->setCoTipoIncorporacion(39)
                ->setInActivo(false)
                ->setCoUsuario($this->getRequestParameter("co_usuario"))
                ->setInIncorporado(true)
                ->setCoSolicitud($this->getRequestParameter("co_solicitud"))
                ->setCoDocIncor($this->getRequestParameter("co_tipo_documento"))
                ->setNuMonto($this->getRequestParameter("nu_precio"))
                ->setCoTipoBienes(2)
                ->setCoTipoInmueble($this->getRequestParameter("co_tipo"))
                ->setCoParroquia($this->getRequestParameter("co_parroquia"))
                ->setTxAvenida($this->getRequestParameter("tx_avenida"))
                ->setTxCalle($this->getRequestParameter("tx_calle"))
                ->setTxSector($this->getRequestParameter("tx_sector"))
                ->setTxPuntoReferencia($this->getRequestParameter("tx_punto_referencia"))
                ->setTxLinderoNorte($this->getRequestParameter("tx_norte"))
                ->setTxLinderoSur($this->getRequestParameter("tx_sur"))
                ->setTxLinderoEste($this->getRequestParameter("tx_este"))
                ->setTxLinderoOeste($this->getRequestParameter("tx_oeste"))
                ->setTxEstadoLegal($this->getRequestParameter("tx_legal"))
                ->setCoMedida($this->getRequestParameter("co_medida"))
                ->setNuAreaConstruccion($this->getRequestParameter("tx_construido"))
                ->setNuAreaCubierta($this->getRequestParameter("tx_cubierto"))
                ->setNuAreaOi($this->getRequestParameter("tx_oi"))
                ->setNuAreaTotal(0)
                ->setNuAreaTerreno($this->getRequestParameter("tx_terreno"))
                ->setNuAvaluoAct($this->getRequestParameter("nu_avaluo"))
                ->setCoClasificacionInmueble($this->getRequestParameter("co_clasificacion"))
                ->setDescInm($this->getRequestParameter("tx_descripcion"))
                ->save($con);

            $tb171_bienes->setNuBienes($tb171_bienes->getCoBienes())
                ->save($con);

//            if (Tbbn008DocumentoBienesPeer::getDocumentoBienes($this->getRequestParameter("co_tipo_documento"), $this->getRequestParameter("co_solicitud"), 39, null, null)) {
//
//                $doc = Tbbn008DocumentoBienesPeer::getDocumentoBienes($this->getRequestParameter("co_tipo_documento"), $this->getRequestParameter("co_solicitud"), 39, null, null);
//                $mo = Tbbn008DocumentoBienesPeer::getMontoDocumentoBienes($doc);
//                $monto = $this->getRequestParameter("nu_precio") + $mo;
//                $tbbn008_documento_bienes = Tbbn008DocumentoBienesPeer::retrieveByPk($doc);
//
//                $tbbn008_documento_bienes->setNuMonto($monto)
//                    ->save($con);
//            } else {
                $tbbn008_documento_bienes = new Tbbn008DocumentoBienes();
                $tbbn008_documento_bienes->setCoTipoDocumento($this->getRequestParameter("co_tipo_documento"))
                    ->setInActivo(false)
                    ->setCoSolicitud($this->getRequestParameter("co_solicitud"))
                    ->setCoSubtipoMovimiento(39)
                    ->setNuMonto($this->getRequestParameter("nu_precio"))
                    ->setCoBienes($tb171_bienes->getCoBienes())                        
                    ->save($con);

                $doc = $tbbn008_documento_bienes->getCoDocumentoBienes();
//            }

            $tb173_movimientos_bienes = new Tb173MovimientoBienes();
            $tb173_movimientos_bienes->setCoDocumento($doc)
                ->setCoBienes($tb171_bienes->getCoBienes())
                ->setCoUsuario($this->getRequestParameter("co_usuario"))
                ->setInActivo(false)
                ->setTxMotivo($this->getRequestParameter("tx_motivo"))
                ->setCoUso($this->getRequestParameter("co_uso"))
                ->save($con);

            $con->commit();
            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Modificación realizada exitosamente',

            ));

        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage(),
            ));
        }
    }

    public function executeGuardar(sfWebRequest $request)
    {

        $con = Propel::getConnection();
        try
        {
            $con->beginTransaction();
            $json = $this->getRequestParameter("json_bienes");
            $listaBienes = json_decode($json, true);
            $array_bienes = array();
            $i = 0;

            foreach ($listaBienes as $bienesForm) {

                $tbbn008_documento_bienes = Tbbn008DocumentoBienesPeer::retrieveByPk($bienesForm["co_documento_bienes"]);
                $tbbn008_documento_bienes->setInActivo(true)
                    ->save($con);

                $tb173_movimientos_bienes = Tb173MovimientoBienesPeer::retrieveByPK($bienesForm["co_movimiento_bienes"]);
                $tb173_movimientos_bienes->setInActivo(true)
                    ->save($con);

                $incorporado = Tb171BienesPeer::getIncorporacion($bienesForm["co_bienes"]);
                if ($incorporado) {
                    $tb171_bienes = Tb171BienesPeer::retrieveByPK($bienesForm["co_bienes"]);
                    $tb171_bienes->setInActivo(true)
                        ->setInIncorporado(true)
                        ->save($con);
                }
            }

            /* $tb173_movimiento_bienes = new Tb173MovimientoBienes();
            $tb173_movimiento_bienes->setCoSolicitud($this->getRequestParameter("co_solicitud"))
            ->save($con);*/
            if ($this->getRequestParameter("co_reporte") == '') {
                $tbbn016_reporte = new Tbbn016Reporte();
                $tbbn016_reporte->setCoSolicitud($this->getRequestParameter("co_solicitud"))
                    ->setCoUsuario($this->getRequestParameter("co_usuario"))
                    ->setCoTipoReporte(1)
                    ->save($con);

            } else if (!Tbbn016ReportePeer::retrieveByPk($this->getRequestParameter("co_reporte"))) {
                $tbbn016_reporte = new Tbbn016Reporte();
                $tbbn016_reporte->setCoSolicitud($this->getRequestParameter("co_solicitud"))
                    ->setCoUsuario($this->getRequestParameter("co_usuario"))
                    ->setCoTipoReporte(1)
                    ->save($con);
            }

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($this->getRequestParameter("co_solicitud")));
            $ruta->setInCargarDato(true)->save($con);

            $con->commit();
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());
            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Modificación realizada exitosamente',

            ));

        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage(),
            ));
        }
        $this->setTemplate('store');
    }

    public function executeGuardarTraslado(sfWebRequest $request)
    {

        $con = Propel::getConnection();
        try
        {
            $con->beginTransaction();
            $json = $this->getRequestParameter("json_bienes");
            $listaBienes = json_decode($json, true);
            $array_bienes = array();
            $i = 0;

            foreach ($listaBienes as $bienesForm) {

                $tbbn008_documento_bienes = Tbbn008DocumentoBienesPeer::retrieveByPK($bienesForm["co_documento_bienes"]);
                $tbbn008_documento_bienes->setInActivo(true)
                    ->save($con);

                $tb173_movimientos_bienes = Tb173MovimientoBienesPeer::retrieveByPK($bienesForm["co_movimiento_bienes"]);
                $tb173_movimientos_bienes->setCoDocumento($bienesForm["co_documento_bienes"])
                    ->setInActivo(true)
                    ->save($con);

                $ulteje = Tb173MovimientoBienesPeer::getUltimoEjecutor($bienesForm["co_bienes"]);
                $ultfisico = Tb173MovimientoBienesPeer::getUltimoFisico($bienesForm["co_bienes"]);
                $tb171_bienes = Tb171BienesPeer::retrieveByPK($bienesForm["co_bienes"]);
                $tb171_bienes->setCoUbicacion($bienesForm["co_organigrama"])
                    ->save($con);
            }

            if ($this->getRequestParameter("co_reporte") == '') {
                $tbbn016_reporte = new Tbbn016Reporte();
                $tbbn016_reporte->setCoSolicitud($this->getRequestParameter("co_solicitud"))
                    ->setCoUsuario($this->getRequestParameter("co_usuario"))
                    ->setCoTipoReporte(1)
                    ->save($con);

            } else if (!Tbbn016ReportePeer::retrieveByPk($this->getRequestParameter("co_reporte"))) {
                $tbbn016_reporte = new Tbbn016Reporte();
                $tbbn016_reporte->setCoSolicitud($this->getRequestParameter("co_solicitud"))
                    ->setCoUsuario($this->getRequestParameter("co_usuario"))
                    ->setCoTipoReporte(1)
                    ->save($con);
            }

            /* $tb173_movimiento_bienes = new Tb173MovimientoBienes();
            $tb173_movimiento_bienes->setCoSolicitud($this->getRequestParameter("co_solicitud"))
            ->save($con);*/

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($this->getRequestParameter("co_solicitud")));
            $ruta->setInCargarDato(true)->save($con);

            $con->commit();
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());
            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Modificación realizada exitosamente',

            ));

        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage(),
            ));
        }
        $this->setTemplate('store');
    }

    public function executeGuardarDesincorporacion(sfWebRequest $request)
    {

        $con = Propel::getConnection();
        try
        {
            $con->beginTransaction();
            $json = $this->getRequestParameter("json_bienes");
            $listaBienes = json_decode($json, true);
            $array_bienes = array();
            $i = 0;

            foreach ($listaBienes as $bienesForm) {

                $tbbn008_documento_bienes = Tbbn008DocumentoBienesPeer::retrieveByPK($bienesForm["co_documento_bienes"]);
                $tbbn008_documento_bienes->setInActivo(true)
                    ->save($con);

                $tb173_movimientos_bienes = Tb173MovimientoBienesPeer::retrieveByPK($bienesForm["co_movimiento_bienes"]);
                $tb173_movimientos_bienes->setCoDocumento($bienesForm["co_documento_bienes"])
                    ->setInActivo(true)
                    ->save($con);

                $tb171_bienes = Tb171BienesPeer::retrieveByPK($bienesForm["co_bienes"]);
                $tb171_bienes->setCoUbicacion($bienesForm["co_organigrama"])
                    ->setInIncorporado(false)
                    ->save($con);
            }

            if ($this->getRequestParameter("co_reporte") == '') {
                $tbbn016_reporte = new Tbbn016Reporte();
                $tbbn016_reporte->setCoSolicitud($this->getRequestParameter("co_solicitud"))
                    ->setCoUsuario($this->getRequestParameter("co_usuario"))
                    ->setCoTipoReporte(1)
                    ->save($con);

            } else if (!Tbbn016ReportePeer::retrieveByPk($this->getRequestParameter("co_reporte"))) {
                $tbbn016_reporte = new Tbbn016Reporte();
                $tbbn016_reporte->setCoSolicitud($this->getRequestParameter("co_solicitud"))
                    ->setCoUsuario($this->getRequestParameter("co_usuario"))
                    ->setCoTipoReporte(1)
                    ->save($con);
            }

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($this->getRequestParameter("co_solicitud")));
            $ruta->setInCargarDato(true)->save($con);

            $con->commit();
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());
            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Los Bienes se han desincorporado exitosamente',

            ));

        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage(),
            ));
        }
        $this->setTemplate('store');
    }
    public function executeTrasladarBien(sfWebRequest $request)
    {

        $con = Propel::getConnection();
        try
        {
            $con->beginTransaction();

            $ultubicacion = Tb173MovimientoBienesPeer::getUltimoUbicacion($this->getRequestParameter("co_bienes"));

//            if (Tbbn008DocumentoBienesPeer::getDocumentoBienes($this->getRequestParameter("co_tipo_documento"), $this->getRequestParameter("co_solicitud"), $this->getRequestParameter("co_tipo_movimiento"), $this->getRequestParameter("co_traslado"), $this->getRequestParameter("co_responsable"))) {
//
//                $doc = Tbbn008DocumentoBienesPeer::getDocumentoBienes($this->getRequestParameter("co_tipo_documento"), $this->getRequestParameter("co_solicitud"), $this->getRequestParameter("co_tipo_movimiento"), $this->getRequestParameter("co_traslado"), $this->getRequestParameter("co_responsable"));
//                $mo = Tbbn008DocumentoBienesPeer::getMontoDocumentoBienes($doc);
//                $monto = $this->getRequestParameter("precio_unitario") + $mo;
//                $tbbn008_documento_bienes = Tbbn008DocumentoBienesPeer::retrieveByPk($doc);
//
//                $tbbn008_documento_bienes->setNuMonto($monto)
//                    ->save($con);
//            } else {
                $tbbn008_documento_bienes = new Tbbn008DocumentoBienes();
                $tbbn008_documento_bienes->setCoTipoDocumento($this->getRequestParameter("co_tipo_documento"))
                    ->setInActivo(false)
                    ->setCoSolicitud($this->getRequestParameter("co_solicitud"))
                    ->setCoSubtipoMovimiento($this->getRequestParameter("co_tipo_movimiento"))
                    ->setNuMonto($this->getRequestParameter("precio_unitario"))
                    ->setCoUbicacion($this->getRequestParameter("co_traslado"))
                    ->setCoBienes($this->getRequestParameter("co_bienes"))
                    ->save($con);

                $doc = $tbbn008_documento_bienes->getCoDocumentoBienes();
//            }

            $tb173_movimientos_bienes = new Tb173MovimientoBienes();
            $tb173_movimientos_bienes->setCoDocumento($doc)
                ->setCoBienes($this->getRequestParameter("co_bienes"))
                ->setCoUsuario($this->getRequestParameter("co_usuario"))
                ->setInActivo(false)
                ->setTxMotivo($this->getRequestParameter("tx_motivo"))
                ->setCoDocumentoAnt($ultubicacion)
                //->setCoUso($this->getRequestParameter("co_uso"))
                ->save($con);

            $con->commit();
            $this->data = json_encode(array(
                "success" => true,

            ));

        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage(),
            ));
        }
        $this->setTemplate('store');
    }

    public function executeCondenarBien(sfWebRequest $request)
    {

        $con = Propel::getConnection();
        try
        {
            $con->beginTransaction();

            $ultubicacion = Tb173MovimientoBienesPeer::getUltimoUbicacion($this->getRequestParameter("co_bienes"));

//            if (Tbbn008DocumentoBienesPeer::getDocumentoBienes($this->getRequestParameter("co_tipo_documento"), $this->getRequestParameter("co_solicitud"), $this->getRequestParameter("co_tipo_movimiento"), $this->getRequestParameter("co_traslado"), $this->getRequestParameter("co_responsable"))) {
//
//                $doc = Tbbn008DocumentoBienesPeer::getDocumentoBienes($this->getRequestParameter("co_tipo_documento"), $this->getRequestParameter("co_solicitud"), $this->getRequestParameter("co_tipo_movimiento"), $this->getRequestParameter("co_traslado"), $this->getRequestParameter("co_responsable"));
//                $mo = Tbbn008DocumentoBienesPeer::getMontoDocumentoBienes($doc);
//                $monto = $this->getRequestParameter("precio_unitario") + $mo;
//                $tbbn008_documento_bienes = Tbbn008DocumentoBienesPeer::retrieveByPk($doc);
//
//                $tbbn008_documento_bienes->setNuMonto($monto)
//                    ->save($con);
//            } else {
            
                    $c = new Criteria();

        $c->add(Tbbn008DocumentoBienesPeer::CO_DOCUMENTO_BIENES,$ultubicacion);
         $stmt = Tbbn008DocumentoBienesPeer::doSelectStmt($c);

         $campos = $stmt->fetch(PDO::FETCH_ASSOC);
            
            
                $tbbn008_documento_bienes = new Tbbn008DocumentoBienes();
                $tbbn008_documento_bienes->setCoTipoDocumento($this->getRequestParameter("co_tipo_documento"))
                    ->setInActivo(false)
                    ->setCoSolicitud($this->getRequestParameter("co_solicitud"))
                    ->setCoSubtipoMovimiento($this->getRequestParameter("co_tipo_movimiento"))
                    ->setNuMonto($this->getRequestParameter("precio_unitario"))
                    ->setCoUbicacion($campos["co_ubicacion"])
                   ->setCoBienes($this->getRequestParameter("co_bienes"))
                    ->save($con);

                $doc = $tbbn008_documento_bienes->getCoDocumentoBienes();
//            }

            $tb171_bienes = Tb171BienesPeer::retrieveByPK($this->getRequestParameter("co_bienes"));
            $tb171_bienes->setInActivo(false)
                ->setCoDocDes($this->getRequestParameter("co_tipo_documento"))
                ->save($con);

            $tb173_movimientos_bienes = new Tb173MovimientoBienes();
            $tb173_movimientos_bienes->setCoDocumento($doc)
                ->setCoBienes($this->getRequestParameter("co_bienes"))
                ->setCoUsuario($this->getRequestParameter("co_usuario"))
                ->setInActivo(false)
                ->setTxMotivo($this->getRequestParameter("tx_motivo"))
                ->setCoDocumentoAnt($ultubicacion)
                //->setCoUso($this->getRequestParameter("co_uso"))
                ->save($con);
            $con->commit();
            $this->data = json_encode(array(
                "success" => true,

            ));

        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage(),
            ));
        }
        $this->setTemplate('store');
    }
    public function executeAgregarNuevoProducto(sfWebRequest $request)
    {

    }

    public function executeAgregarProductoCompra(sfWebRequest $request)
    {

    }

    public function executeAgregarBienes(sfWebRequest $request)
    {

    }

    public function executeAgregarBienesDesin(sfWebRequest $request)
    {

    }
    public function executeAgregarInm(sfWebRequest $request)
    {

    }

    public function executeStorefkcoproductonuevo(sfWebRequest $request)
    {

        $limit = $this->getRequestParameter("limit", 5);
        $start = $this->getRequestParameter("start", 0);
        $codigo = $this->getRequestParameter("codigo");
        $producto = $this->getRequestParameter("producto");

        $json_producto = $this->getRequestParameter("lista_producto");

        $listaProducto = json_decode($json_producto, true);
        $array_producto = array();
        $i = 0;
        foreach ($listaProducto as $productoForm) {
            $array_producto[$i] = $productoForm["co_producto"];
            $i++;
        }

        $c = new Criteria();
        $c->setIgnoreCase(true);
        $c->add(Tb048ProductoPeer::CO_PRODUCTO, $array_producto, Criteria::NOT_IN);

        if ($codigo != '') {
            $c->add(Tb048ProductoPeer::COD_PRODUCTO, $codigo);
        }

        if ($producto) {
            $c->add(Tb048ProductoPeer::TX_PRODUCTO, '%' . $producto . '%', Criteria::LIKE);
        }

        $cantidadTotal = Tb048ProductoPeer::doCount($c);

        $c->clearSelectColumns();
        $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);

        $c->addJoin(Tb092ClaseProductoPeer::ID, Tb048ProductoPeer::CO_CLASE);
        $c->addJoin(Tb093FamiliaProductoPeer::ID, Tb092ClaseProductoPeer::ID_TB093_FAMILIA_PRODUCTO);
        //$c->add(Tb093FamiliaProductoPeer::CO_TIPO_PRODUCTO, "tb093_familia_producto.co_tipo_producto IN (1,2)", Criteria::CUSTOM);
        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb048ProductoPeer::TX_PRODUCTO);

        $stmt = Tb048ProductoPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }

    public function executeStorefkcobienes(sfWebRequest $request)
    {

        $limit = $this->getRequestParameter("limit", 20);
        $start = $this->getRequestParameter("start", 0);
        $numero = $this->getRequestParameter("numero");
        $serial = $this->getRequestParameter("serial");
        $bien = $this->getRequestParameter("bien");
        $ubicacion = $this->getRequestParameter("organigramaf");
        $solicitud = $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->setIgnoreCase(true);

        if ($numero != '') {
            $c->add(Tb171BienesPeer::NU_BIENES, $numero);
        }
        if ($serial != '') {
            $c->add(Tb171BienesPeer::TX_SERIAL, $serial);
        }

        if ($bien) {
            $c->add(Tb171BienesPeer::TX_DETALLE, '%' . $bien . '%', Criteria::LIKE);
        }

        if ($ubicacion) {
            $c->add(Tb171BienesPeer::CO_UBICACION, $ubicacion);
        }

        $cantidadTotal = Tb171BienesPeer::doCount($c);

        $c->clearSelectColumns();
        $c->addSelectColumn(Tb171BienesPeer::CO_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::TX_SERIAL);
        $c->addSelectColumn(Tb171BienesPeer::NU_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::TX_DETALLE);
        $c->addSelectColumn(Tb171BienesPeer::NU_MONTO);
        $c->addSelectColumn(Tb174MarcaPeer::TX_MARCA);
        $c->addSelectColumn(Tb175ModeloPeer::TX_MODELO);
        $c->addSelectColumn(Tbbn006OrganigramaPeer::TX_ORGANIGRAMA);
        $c->addSelectColumn(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA);
        $c->addJoin(Tb171BienesPeer::CO_MODELO,Tb175ModeloPeer::CO_MODELO,  Criteria::LEFT_JOIN);
        $c->addJoin(Tb175ModeloPeer::CO_MARCA, Tb174MarcaPeer::CO_MARCA,  Criteria::LEFT_JOIN);
        $c->addJoin(Tb173MovimientoBienesPeer::CO_BIENES, Tb171BienesPeer::CO_BIENES);
        $c->addJoin(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA, Tb171BienesPeer::CO_UBICACION);
        $c->add(Tb171BienesPeer::IN_ACTIVO, true);
        $c->add(Tb171BienesPeer::IN_INCORPORADO, true);
        $c->add(Tb173MovimientoBienesPeer::IN_ACTIVO, true);
        $condi = "tb173_movimiento_bienes.co_bienes NOT IN (SELECT co_bienes FROM  tb173_movimiento_bienes WHERE co_documento IN (SELECT co_documento_bienes FROM tbbn008_documento_bienes WHERE co_solicitud=$solicitud))";
        $c->add(Tb173MovimientoBienesPeer::CO_BIENES, $condi, Criteria::CUSTOM);
        $c->addGroupByColumn(Tb171BienesPeer::CO_BIENES);
        $c->addGroupByColumn(Tb174MarcaPeer::TX_MARCA);
        $c->addGroupByColumn(Tb175ModeloPeer::TX_MODELO);
        $c->addGroupByColumn(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA);
        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb171BienesPeer::TX_DETALLE);

        $stmt = Tb171BienesPeer::doSelectStmt($c);
        //var_dump($stmt);        exit();
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }

    public function executeStorefkcobieneslista(sfWebRequest $request)
    {
        $paginar = $this->getRequestParameter("paginar");
        $limit = $this->getRequestParameter("limit", 20);
        $start = $this->getRequestParameter("start", 0);
        $numero = $this->getRequestParameter("numero");
        $serial = $this->getRequestParameter("serial");
        $bien = $this->getRequestParameter("bien");
        $solicitud = $this->getRequestParameter("co_solicitud");
        $ejecutor = $this->getRequestParameter("id_tb082_ejecutor");
        $fisico = $this->getRequestParameter("co_ente");
        $marca = $this->getRequestParameter("co_marca");
        $modelo = $this->getRequestParameter("co_modelo");
        $organismo = $this->getRequestParameter("co_organismos");
        $dependencia = $this->getRequestParameter("co_dependencia");
        $estatus = $this->getRequestParameter("estatus");
        $incor = $this->getRequestParameter("incorporado");
        $organi = $this->getRequestParameter("organigrama");
        $cod_adm = $this->getRequestParameter("tx_ubicacion");
        $cod_cia = $this->getRequestParameter("tx_cia");

        $c = new Criteria();
        $c->setIgnoreCase(true);
        if ($estatus != '') {
            $c->add(Tb171BienesPeer::IN_ACTIVO, $estatus);
        }
        if ($marca != '') {
            $c->add(Tb174MarcaPeer::CO_MARCA, $marca);
        }
        if ($modelo != '') {
            $c->add(Tb171BienesPeer::CO_MODELO, $modelo);
        }

        if ($numero != '') {
            $c->add(Tb171BienesPeer::NU_BIENES, $numero);
        }
        if ($serial != '') {
            $c->add(Tb171BienesPeer::TX_SERIAL, $serial);
        }

        if ($incor != '') {
            $c->add(Tb171BienesPeer::IN_INCORPORADO, $incor);
        }

        if ($bien) {
            $c->add(Tb171BienesPeer::TX_DETALLE, '%' . $bien . '%', Criteria::LIKE);
        }
        if ($cod_adm && $cod_cia) {
            $co_adm = Tbbn006OrganigramaPeer::getCoOrganigrama($cod_adm, $cod_cia);
            $c->add(Tb171BienesPeer::CO_UBICACION, $co_adm);
        } else {
            if ($organi) {
                $c->add(Tb171BienesPeer::CO_UBICACION, $organi);
            }
        }

        $cantidadTotal = Tb171BienesPeer::doCount($c);

        $c->clearSelectColumns();
        $c->addSelectColumn(Tb171BienesPeer::CO_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::TX_SERIAL);
        $c->addSelectColumn(Tb171BienesPeer::NU_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::TX_DETALLE);
        //$c->addSelectColumn(Tb174MarcaPeer::TX_MARCA);
        //$c->addSelectColumn(Tb175ModeloPeer::TX_MODELO);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        $c->addSelectColumn(Tb171BienesPeer::IN_ACTIVO);
        $c->addSelectColumn(Tb171BienesPeer::IN_INCORPORADO);
        $c->addSelectColumn(Tbbn006OrganigramaPeer::TX_ORGANIGRAMA);
        $c->addSelectColumn(Tb045FacturaPeer::NU_FACTURA);
        $c->addSelectColumn('(' . Tb060OrdenPagoPeer::TX_SERIAL . ') as tx_odp');
        //$c->addJoin(Tb175ModeloPeer::CO_MODELO, Tb171BienesPeer::CO_MODELO, Criteria::LEFT_JOIN);
        //$c->addJoin(Tb174MarcaPeer::CO_MARCA, Tb175ModeloPeer::CO_MARCA, Criteria::LEFT_JOIN);
        $c->addJoin(Tb171BienesPeer::CO_UBICACION, Tbbn006OrganigramaPeer::CO_ORGANIGRAMA, Criteria::LEFT_JOIN);
        $c->addJoin(Tb171BienesPeer::CO_PRODUCTO, Tb048ProductoPeer::CO_PRODUCTO, Criteria::LEFT_JOIN);
        $c->addJoin(Tb171BienesPeer::CO_DETALLE_COMPRAS, Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS, Criteria::LEFT_JOIN);
        $c->addJoin(Tb053DetalleComprasPeer::CO_FACTURA, Tb045FacturaPeer::CO_FACTURA, Criteria::LEFT_JOIN);
        $c->addJoin(Tb045FacturaPeer::CO_ODP, Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Criteria::LEFT_JOIN);
        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb171BienesPeer::NU_BIENES);

        $stmt = Tb171BienesPeer::doSelectStmt($c);
        //var_dump($stmt);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($reg['in_activo']) {$reg['activo'] = "ACTIVO";} else { $reg['activo'] = "INACTIVO";}
            if ($reg['in_incorporado']) {$reg['incorporado'] = "INCORPORADO";} else { $reg['incorporado'] = "DESINCORPORADO";}
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }
    public function executeStorefkcoinmueblelista(sfWebRequest $request)
    {
        $paginar = $this->getRequestParameter("paginar");
        $limit = $this->getRequestParameter("limit", 20);
        $start = $this->getRequestParameter("start", 0);
        $numero = $this->getRequestParameter("numero");
        $bien = $this->getRequestParameter("bien");
        $detalle = $this->getRequestParameter("denominacion");
        $clasificacion = $this->getRequestParameter("co_clasificacion_inmueble");
        $tipo = $this->getRequestParameter("co_tipo_inmueble");

        $c = new Criteria();
        $c->setIgnoreCase(true);

        if ($numero != '') {
            $c->add(Tb171BienesPeer::NU_BIENES, $numero);
        }

        if ($bien) {
            $c->add(Tb171BienesPeer::TX_DETALLE, '%' . $bien . '%', Criteria::LIKE);
        }

        if ($detalle) {
            $c->add(Tb171BienesPeer::DESC_INM, '%' . $detalle . '%', Criteria::LIKE);
        }

        if ($clasificacion != '') {
            $c->add(Tb171BienesPeer::CO_CLASIFICACION_INMUEBLE, $clasificacion);
        }

        if ($tipo != '') {
            $c->add(Tb171BienesPeer::CO_TIPO_INMUEBLE, $tipo);
        }

        

        $c->clearSelectColumns();
        $c->addSelectColumn(Tb171BienesPeer::CO_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::NU_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::TX_DETALLE);
        $c->addSelectColumn(Tb171BienesPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb171BienesPeer::DESC_INM);
        $c->addSelectColumn(Tbbn012ClasificacionInmueblePeer::TX_CLASIFICACION_INMUEBLE);
        $c->addSelectColumn(Tbbn014TipoInmueblePeer::TX_TIPO_INMUEBLE);
        //$c->addJoin(Tb171BienesPeer::CO_PRODUCTO,Tb048ProductoPeer::CO_PRODUCTO, Criteria::LEFT_JOIN);
        $c->addJoin(Tb171BienesPeer::CO_CLASIFICACION_INMUEBLE, Tbbn012ClasificacionInmueblePeer::CO_CLASIFICACION_INMUEBLE);
        $c->addJoin(Tb171BienesPeer::CO_TIPO_INMUEBLE, Tbbn014TipoInmueblePeer::CO_TIPO_INMUEBLE);
        $c->add(Tb171BienesPeer::CO_TIPO_BIENES, 2);
        $cantidadTotal = Tb171BienesPeer::doCount($c);
        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb171BienesPeer::NU_BIENES);

        $stmt = Tb171BienesPeer::doSelectStmt($c);
        //var_dump($stmt);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }
    public function executeStorefkcobienesdesin(sfWebRequest $request)
    {

        $limit = $this->getRequestParameter("limit", 5);
        $start = $this->getRequestParameter("start", 0);
        $numero = $this->getRequestParameter("numero");
        $serial = $this->getRequestParameter("serial");
        $bien = $this->getRequestParameter("bien");
        $solicitud = $this->getRequestParameter("co_solicitud");
        $ejecutor = $this->getRequestParameter("listejecutor");
        $fisico = $this->getRequestParameter("listente");
        $factura = $this->getRequestParameter("factura");
        $odp = $this->getRequestParameter("odp");

        $c = new Criteria();
        $c->setIgnoreCase(true);

        if ($numero != '') {
            $c->add(Tb171BienesPeer::NU_BIENES, $numero);
        }
        if ($serial != '') {
            $c->add(Tb171BienesPeer::TX_SERIAL, $serial);
        }

        if (isset($ejecutor) && !empty($ejecutor)) {
            if ($ejecutor != '...') {
                $c->add(Tb082EjecutorPeer::DE_EJECUTOR, $ejecutor);
            }
        }

        if (isset($fisico) && !empty($fisico)) {
            if ($fisico != '...') {
                $c->add(Tb047EntePeer::TX_ENTE, $fisico);
            }
        }

        if ($factura != '') {
            $c->add(Tb045FacturaPeer::NU_FACTURA, $factura);
        }
        if ($odp != '') {
            $c->add(Tb060OrdenPagoPeer::TX_SERIAL, $odp);
        }

        if ($bien) {
            $c->add(Tb171BienesPeer::TX_DETALLE, '%' . $bien . '%', Criteria::LIKE);
        }

        $cantidadTotal = Tb171BienesPeer::doCount($c);

        $c->clearSelectColumns();
        $c->addSelectColumn(Tb171BienesPeer::CO_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::TX_SERIAL);
        $c->addSelectColumn(Tb171BienesPeer::NU_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::TX_DETALLE);
        $c->addSelectColumn(Tb174MarcaPeer::TX_MARCA);
        $c->addSelectColumn(Tb175ModeloPeer::TX_MODELO);
        $c->addSelectColumn(Tb082EjecutorPeer::DE_EJECUTOR);
        $c->addSelectColumn(Tb047EntePeer::TX_ENTE);
        $c->addSelectColumn(Tb045FacturaPeer::NU_FACTURA);
        $c->addSelectColumn('(' . Tb060OrdenPagoPeer::TX_SERIAL . ') as tx_odp');
        $c->addJoin(Tb175ModeloPeer::CO_MODELO, Tb171BienesPeer::CO_MODELO);
        $c->addJoin(Tb174MarcaPeer::CO_MARCA, Tb175ModeloPeer::CO_MARCA);
        $c->addJoin(Tb082EjecutorPeer::ID, Tb171BienesPeer::CO_EJECUTOR);
        $c->addJoin(Tb047EntePeer::CO_ENTE, Tb171BienesPeer::CO_FISICO);

        $c->addJoin(Tb173MovimientoBienesPeer::CO_BIENES, Tb171BienesPeer::CO_BIENES, Criteria::LEFT_JOIN);
        $c->addJoin(Tb171BienesPeer::CO_DETALLE_COMPRAS, Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS, Criteria::LEFT_JOIN);
        $c->addJoin(Tb053DetalleComprasPeer::CO_FACTURA, Tb045FacturaPeer::CO_FACTURA, Criteria::LEFT_JOIN);
        $c->addJoin(Tb045FacturaPeer::CO_ODP, Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Criteria::LEFT_JOIN);
        $c->add(Tb171BienesPeer::IN_ACTIVO, true);
        $c->add(Tb171BienesPeer::IN_INCORPORADO, true);
        $c->add(Tb173MovimientoBienesPeer::IN_ACTIVO, true);
        $c->addGroupByColumn(Tb171BienesPeer::CO_BIENES);
        $c->addGroupByColumn(Tb174MarcaPeer::TX_MARCA);
        $c->addGroupByColumn(Tb175ModeloPeer::TX_MODELO);
        $c->addGroupByColumn(Tb082EjecutorPeer::DE_EJECUTOR);
        $c->addGroupByColumn(Tb047EntePeer::TX_ENTE);
        $c->addGroupByColumn(Tb045FacturaPeer::NU_FACTURA);
        $c->addGroupByColumn(Tb060OrdenPagoPeer::TX_SERIAL);
        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb171BienesPeer::TX_DETALLE);

        $stmt = Tb171BienesPeer::doSelectStmt($c);
        //var_dump($stmt);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }

    public function executeStorefkcoproductocompra(sfWebRequest $request)
    {

        $limit = $this->getRequestParameter("limit", 5);
        $start = $this->getRequestParameter("start", 0);
        $codigo = $this->getRequestParameter("codigo");
        $producto = $this->getRequestParameter("producto");
        $orden_compras = $this->getRequestParameter("orden_compras");
        $fe_orden_compras = $this->getRequestParameter("fe_orden_compras");
        $factura = $this->getRequestParameter("factura");
        $fe_factura = $this->getRequestParameter("fec_factura");

        $json_producto = $this->getRequestParameter("lista_producto");

        $listaProducto = json_decode($json_producto, true);
        $array_producto = array();
        $i = 0;
        foreach ($listaProducto as $productoForm) {
            $array_producto[$i] = $productoForm["co_producto"];
            $i++;
        }

        $c = new Criteria();
        $c->setIgnoreCase(true);
        $c->add(Tb048ProductoPeer::CO_PRODUCTO, $array_producto, Criteria::NOT_IN);

        if ($codigo != '') {
            $c->add(Tb048ProductoPeer::COD_PRODUCTO, $codigo);
        }

        if ($producto) {
            $c->add(Tb048ProductoPeer::TX_PRODUCTO, '%' . $producto . '%', Criteria::ILIKE);
        }

        if ($orden_compras) {
            $c->add(Tb060OrdenPagoPeer::TX_SERIAL, $orden_compras);
        }

        if ($fe_orden_compras) {
            $c->add(Tb060OrdenPagoPeer::FE_EMISION, $fe_orden_compras);
        }

        if ($factura) {
            $c->add(Tb045FacturaPeer::NU_FACTURA, $factura);
        }

        if ($fe_factura) {
            $c->add(Tb045FacturaPeer::FE_EMISION, $fe_factura);
        }

        $cantidadTotal = Tb048ProductoPeer::doCount($c);

        //$nu= add(Tb053DetalleComprasPeer::NU_CANTIDAD + 2);
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
        $c->addSelectColumn(Tb052ComprasPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        $c->addSelectColumn(Tb053DetalleComprasPeer::DETALLE);
        $c->addSelectColumn(Tb053DetalleComprasPeer::PRECIO_UNITARIO);
        $c->addSelectColumn(Tb052ComprasPeer::NUMERO_COMPRA);
        $c->addSelectColumn(Tb045FacturaPeer::NU_FACTURA);
        $c->addSelectColumn(Tb060OrdenPagoPeer::TX_SERIAL);
        //$c->addSelectColumn('COUNT(' . Tb171BienesPeer::CO_BIENES . ') as num');
        // $can = Tb048ProductoPeer::doCount($c->addSelectColumn('COUNT('.Tb171BienesPeer::CO_BIENES.')::integer as num'));
        //$f=$c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->addSelectColumn('' . Tb053DetalleComprasPeer::NU_CANTIDAD . ' as nu');
        //$c->addSelectColumn("(SELECT COUNT(*) FROM tb171_bienes WHERE co_detalle_compras=".$f.") AS num",Criteria::CUSTOM);
        //$c->addAsColumn(Tb053DetalleComprasPeer::NU_CANTIDAD);
        $c->addSelectColumn(Tb045FacturaPeer::FE_EMISION);
        $c->addAsColumn('fecha', Tb060OrdenPagoPeer::FE_EMISION);

        $c->addJoin(Tb048ProductoPeer::CO_PRODUCTO, Tb053DetalleComprasPeer::CO_PRODUCTO);
        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
        $c->addJoin(Tb045FacturaPeer::CO_COMPRA, Tb053DetalleComprasPeer::CO_COMPRAS);
        $c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
        $c->addJoin(Tb092ClaseProductoPeer::ID, Tb048ProductoPeer::CO_CLASE);
        //$c->addJoin(Tb093FamiliaProductoPeer::ID, Tb092ClaseProductoPeer::ID_TB093_FAMILIA_PRODUCTO);
        //$c->addAlias('tb171',Tb171Bienes);
        //$c->addJoin(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS, Tb171BienesPeer::CO_DETALLE_COMPRAS, Criteria::LEFT_JOIN);
        //$c->addJoin(Tb171BienesPeer::CO_DETALLE_COMPRAS,Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS,Criteria::LEFT_JOIN);
        //$c->add(Tb093FamiliaProductoPeer::CO_TIPO_PRODUCTO, "tb093_familia_producto.co_tipo_producto IN (1,2)", Criteria::CUSTOM);
        //$c->add(Tb053DetalleComprasPeer::IN_BIEN, true);
        $c->add(Tb060OrdenPagoPeer::IN_PAGADO, true);
        $c->add(Tb060OrdenPagoPeer::IN_ANULADO, false);
        $c->add(Tb060OrdenPagoPeer::IN_ANULADO, "tb060_orden_pago.tx_serial IS NOT NULL", Criteria::CUSTOM);
        //$condi="SELECT COUNT(*) FROM tb171_bienes WHERE co_detalle_compras IS NOT NULL";
        $condi = "tb053_detalle_compras.nu_cantidad > (SELECT COUNT(*) FROM tb171_bienes WHERE co_detalle_compras =tb053_detalle_compras.co_detalle_compras AND co_detalle_compras IS NOT NULL)";
       // $c->add(Tb053DetalleComprasPeer::NU_CANTIDAD, $condi, Criteria::CUSTOM);

        //$c->add((integer)Tb053DetalleComprasPeer::NU_CANTIDAD,(integer)'num',Criteria::GREATER_THAN);
        $c->addGroupByColumn(1);
        $c->addGroupByColumn(2);
        $c->addGroupByColumn(3);
        $c->addGroupByColumn(7);
        $c->addGroupByColumn(8);
        $c->addGroupByColumn(9);
        $c->addGroupByColumn(10);
        $c->addGroupByColumn(Tb045FacturaPeer::FE_EMISION);
        $c->addGroupByColumn('fecha');
        //$no=$c->addSelectColumn('COUNT('.Tb171BienesPeer::CO_BIENES.') as num');
        // $having = $c->getNewCriterion('tb053_detalle_compras.nu_cantidad',(integer)'COUNT(tb171_bienes.co_bienes)',Criteria::GREATER_THAN);
        //$having = $c->getNewCriterion($can,(integer)Tb053DetalleComprasPeer::NU_CANTIDAD,Criteria::LESS_THAN);
        //$c->addHaving($having);

        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb048ProductoPeer::TX_PRODUCTO);

        $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);
        //var_dump($stmt);
        //return exit;
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //$reg["nu_cantidad"] = $reg["nu"] - $reg["num"];
            $reg["nu_cantidad"] = $reg["nu"];
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros,
        ));
        $this->setTemplate('store');
    }

    public function executeStorelistabienes(sfWebRequest $request)
    {

        $co_solicitud = $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb171BienesPeer::CO_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::NU_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::TX_SERIAL);
        $c->addSelectColumn(Tb171BienesPeer::CO_USUARIO);
        $c->addSelectColumn(Tb171BienesPeer::NU_MONTO);
        $c->addSelectColumn(Tb175ModeloPeer::TX_MODELO);
        $c->addSelectColumn(Tb174MarcaPeer::TX_MARCA);
        $c->addSelectColumn(Tb171BienesPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb171BienesPeer::CO_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        $c->addSelectColumn(Tb171BienesPeer::TX_DETALLE);
        $c->addSelectColumn(Tbbn006OrganigramaPeer::TX_ORGANIGRAMA);
        $c->addSelectColumn(Tbbn008DocumentoBienesPeer::CO_DOCUMENTO_BIENES);
        $c->addSelectColumn(Tbbn005TipoDocumentoPeer::TX_DOCUMENTO);
        $c->addSelectColumn(Tb173MovimientoBienesPeer::CO_MOVIMIENTO_BIENES);
        $c->addSelectColumn(Tbbn004SubtipoMovimientoBienesPeer::TX_SUBTIPO_MOVIMIENTO);
        $c->addJoin(Tb171BienesPeer::CO_PROVEEDOR,Tb008ProveedorPeer::CO_PROVEEDOR, Criteria::LEFT_JOIN);
        $c->addJoin(Tb048ProductoPeer::CO_PRODUCTO, Tb171BienesPeer::CO_PRODUCTO);
        $c->addJoin(Tb175ModeloPeer::CO_MODELO, Tb171BienesPeer::CO_MODELO);
        $c->addJoin(Tb174MarcaPeer::CO_MARCA, Tb175ModeloPeer::CO_MARCA);
        $c->addJoin(Tb173MovimientoBienesPeer::CO_BIENES, Tb171BienesPeer::CO_BIENES);
        $c->addJoin(Tbbn008DocumentoBienesPeer::CO_DOCUMENTO_BIENES, Tb173MovimientoBienesPeer::CO_DOCUMENTO);
        $c->addJoin(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA, Tbbn008DocumentoBienesPeer::CO_UBICACION);
        $c->addJoin(Tbbn005TipoDocumentoPeer::CO_DOCUMENTO, Tbbn008DocumentoBienesPeer::CO_TIPO_DOCUMENTO);
        $c->addJoin(Tbbn004SubtipoMovimientoBienesPeer::CO_SUBTIPO_MOVIMIENTO_BIENES, Tbbn008DocumentoBienesPeer::CO_SUBTIPO_MOVIMIENTO);
        $c->add(Tbbn008DocumentoBienesPeer::CO_SOLICITUD, $co_solicitud);

        $c->addAscendingOrderByColumn(Tb171BienesPeer::CO_BIENES);
        $cantidadTotal = Tb171BienesPeer::doCount($c);

        $stmt = Tb171BienesPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros,
        ));

        $this->setTemplate('store');
    }

    public function executeStorelistaInmuebles(sfWebRequest $request)
    {

        $co_solicitud = $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb171BienesPeer::CO_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::NU_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::CO_USUARIO);
        $c->addSelectColumn(Tb171BienesPeer::NU_MONTO);
        $c->addSelectColumn(Tb171BienesPeer::TX_DETALLE);
        $c->addSelectColumn(Tb171BienesPeer::DESC_INM);
        $c->addSelectColumn(Tb171BienesPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb171BienesPeer::TX_LINDERO_INMUEBLE);
        $c->addSelectColumn(Tbbn008DocumentoBienesPeer::CO_DOCUMENTO_BIENES);
        $c->addSelectColumn(Tbbn005TipoDocumentoPeer::TX_DOCUMENTO);
        $c->addSelectColumn(Tb173MovimientoBienesPeer::CO_MOVIMIENTO_BIENES);
        $c->addSelectColumn(Tbbn004SubtipoMovimientoBienesPeer::TX_SUBTIPO_MOVIMIENTO);
        $c->addJoin(Tb173MovimientoBienesPeer::CO_BIENES, Tb171BienesPeer::CO_BIENES);
        $c->addJoin(Tbbn008DocumentoBienesPeer::CO_DOCUMENTO_BIENES, Tb173MovimientoBienesPeer::CO_DOCUMENTO);
        $c->addJoin(Tbbn005TipoDocumentoPeer::CO_DOCUMENTO, Tbbn008DocumentoBienesPeer::CO_TIPO_DOCUMENTO);
        $c->addJoin(Tbbn004SubtipoMovimientoBienesPeer::CO_SUBTIPO_MOVIMIENTO_BIENES, Tbbn008DocumentoBienesPeer::CO_SUBTIPO_MOVIMIENTO);
        $c->add(Tbbn008DocumentoBienesPeer::CO_SOLICITUD, $co_solicitud);

        $c->addAscendingOrderByColumn(Tb171BienesPeer::CO_BIENES);
        $cantidadTotal = Tb171BienesPeer::doCount($c);

        $stmt = Tb171BienesPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros,
        ));

        $this->setTemplate('store');
    }

    public function executeStorelistabienestraslado(sfWebRequest $request)
    {

        $co_solicitud = $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb171BienesPeer::CO_USUARIO);
        $c->addSelectColumn(Tb173MovimientoBienesPeer::CO_MOVIMIENTO_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::CO_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::TX_DETALLE);
        $c->addSelectColumn(Tb171BienesPeer::NU_BIENES);
        $c->addSelectColumn(Tb175ModeloPeer::TX_MODELO);
        $c->addSelectColumn(Tb174MarcaPeer::TX_MARCA);
        $c->addSelectColumn(Tb174MarcaPeer::TX_MARCA);
        $c->addSelectColumn(Tbbn006OrganigramaPeer::TX_ORGANIGRAMA);
        $c->addSelectColumn(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA);
        $c->addSelectColumn(Tbbn008DocumentoBienesPeer::CO_DOCUMENTO_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::CO_UBICACION);
        $c->addJoin(Tb171BienesPeer::CO_BIENES, Tb173MovimientoBienesPeer::CO_BIENES);
        $c->addJoin(Tbbn008DocumentoBienesPeer::CO_DOCUMENTO_BIENES, Tb173MovimientoBienesPeer::CO_DOCUMENTO);
        $c->addJoin(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA, Tbbn008DocumentoBienesPeer::CO_UBICACION);
        $c->addJoin(Tb171BienesPeer::CO_MODELO,Tb175ModeloPeer::CO_MODELO,  Criteria::LEFT_JOIN);
        $c->addJoin(Tb175ModeloPeer::CO_MARCA, Tb174MarcaPeer::CO_MARCA,  Criteria::LEFT_JOIN);

        $c->add(Tbbn008DocumentoBienesPeer::CO_SOLICITUD, $co_solicitud);

        $c->addAscendingOrderByColumn(Tb173MovimientoBienesPeer::CO_MOVIMIENTO_BIENES);
        $cantidadTotal = Tb171BienesPeer::doCount($c);

        $stmt = Tb171BienesPeer::doSelectStmt($c);
        //var_dump(Tb173MovimientoBienesPeer::getEjecutor(17));
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reg["ubicacion_ant"] = Tbbn006OrganigramaPeer::getOrganigrama($reg["co_ubicacion"]);
            //$reg["n_fisico"] = Tb173MovimientoBienesPeer::getFisico($reg["co_fisico"]);
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros,
        ));

        $this->setTemplate('store');
    }

    public function executeStorelistabienesmovimientos(sfWebRequest $request)
    {

        $co_bienes = $this->getRequestParameter("co_bienes");

        $d = new Criteria();
        $d->clearSelectColumns();
        $d->addSelectColumn(Tb173MovimientoBienesPeer::CREATED_AT);
        $d->addSelectColumn(Tb171BienesPeer::CO_BIENES);
        $d->addSelectColumn(Tb171BienesPeer::TX_DETALLE);
        $d->addSelectColumn(Tb171BienesPeer::NU_BIENES);
        $d->addSelectColumn(Tb171BienesPeer::TX_SERIAL);
        $d->addSelectColumn(Tb001UsuarioPeer::NB_USUARIO);
        $d->addSelectColumn(Tbbn006OrganigramaPeer::TX_ORGANIGRAMA);
        $d->addJoin(Tb171BienesPeer::CO_BIENES, Tb173MovimientoBienesPeer::CO_BIENES);
        $d->addJoin(Tb175ModeloPeer::CO_MODELO, Tb171BienesPeer::CO_MODELO);
        $d->addJoin(Tb174MarcaPeer::CO_MARCA, Tb175ModeloPeer::CO_MARCA);
        $d->addJoin(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA, Tb173MovimientoBienesPeer::CO_UBICACION_ORIGEN);

        $d->addJoin(Tb001UsuarioPeer::CO_USUARIO, Tb173MovimientoBienesPeer::CO_USUARIO);

        $d->add(Tb173MovimientoBienesPeer::CO_BIENES, $co_bienes);
        $d->add(Tb173MovimientoBienesPeer::CO_UBICACION_ORIGEN, null, Criteria::ISNOTNULL);
        $d->addAscendingOrderByColumn(Tb173MovimientoBienesPeer::CO_MOVIMIENTO_BIENES);
        $stmt2 = Tb171BienesPeer::doSelectStmt($d);
        // var_dump( $stmt2);

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbbn008DocumentoBienesPeer::CREATED_AT);
        $c->addSelectColumn(Tbbn008DocumentoBienesPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb171BienesPeer::CO_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::TX_DETALLE);
        $c->addSelectColumn(Tb171BienesPeer::NU_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::TX_SERIAL);
        $c->addSelectColumn(Tb001UsuarioPeer::NB_USUARIO);
        $c->addSelectColumn(Tbbn008DocumentoBienesPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tbbn008DocumentoBienesPeer::COD_DOCUMENTO);
        $c->addSelectColumn(Tbbn004SubtipoMovimientoBienesPeer::TX_SUBTIPO_MOVIMIENTO);
        $c->addSelectColumn(Tbbn005TipoDocumentoPeer::DESC_DOCUMENTO);
        $c->addSelectColumn(Tbbn006OrganigramaPeer::TX_ORGANIGRAMA);
        $c->addJoin(Tb171BienesPeer::CO_BIENES, Tb173MovimientoBienesPeer::CO_BIENES);
//        $c->addJoin(Tb175ModeloPeer::CO_MODELO, Tb171BienesPeer::CO_MODELO, Criteria::LEFT_JOIN);
//        $c->addJoin(Tb174MarcaPeer::CO_MARCA, Tb175ModeloPeer::CO_MARCA, Criteria::LEFT_JOIN);

        $c->addJoin(Tbbn008DocumentoBienesPeer::CO_DOCUMENTO_BIENES, Tb173MovimientoBienesPeer::CO_DOCUMENTO);
        $c->addJoin(Tbbn004SubtipoMovimientoBienesPeer::CO_SUBTIPO_MOVIMIENTO_BIENES, Tbbn008DocumentoBienesPeer::CO_SUBTIPO_MOVIMIENTO);
        $c->addJoin(Tbbn005TipoDocumentoPeer::CO_DOCUMENTO, Tbbn008DocumentoBienesPeer::CO_TIPO_DOCUMENTO);
        $c->addJoin(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA, Tbbn008DocumentoBienesPeer::CO_UBICACION);

        $c->addJoin(Tb001UsuarioPeer::CO_USUARIO, Tb173MovimientoBienesPeer::CO_USUARIO);

        $c->add(Tb173MovimientoBienesPeer::CO_BIENES, $co_bienes);
        $c->addAscendingOrderByColumn(Tb173MovimientoBienesPeer::CO_MOVIMIENTO_BIENES);
        $cantidadTotal = Tb171BienesPeer::doCount($c);
        $stmt = Tb171BienesPeer::doSelectStmt($c);
        //var_dump(Tb173MovimientoBienesPeer::getEjecutor(17));
        $registros = array();
        while ($reg2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $reg2['fecha'] = date_format(date_create($reg2['created_at']), 'd/m/Y');
            $reg2['hora'] = date_format(date_create($reg2['created_at']), 'h:i:s a');
            $reg2['tx_subtipo_movimiento'] = "ORIGEN";
            $reg2['desc_documento'] = "N/A";
            $registros[] = $reg2;
        }
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reg['fecha'] = date_format(date_create($reg['created_at']), 'd/m/Y');
            $reg['hora'] = date_format(date_create($reg['created_at']), 'h:i:s a');
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros,
        ));

        $this->setTemplate('store');
    }
    public function executeStorelistabienesdesincorporacion(sfWebRequest $request)
    {

        $co_solicitud = $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb171BienesPeer::CO_USUARIO);
        $c->addSelectColumn(Tb173MovimientoBienesPeer::CO_MOVIMIENTO_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::CO_BIENES);
        $c->addSelectColumn(Tb171BienesPeer::TX_DETALLE);
        $c->addSelectColumn(Tb171BienesPeer::NU_BIENES);
        $c->addSelectColumn(Tb175ModeloPeer::TX_MODELO);
        $c->addSelectColumn(Tb174MarcaPeer::TX_MARCA);
        $c->addSelectColumn(Tb174MarcaPeer::TX_MARCA);
        $c->addSelectColumn(Tbbn006OrganigramaPeer::TX_ORGANIGRAMA);
        $c->addSelectColumn(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA);
        $c->addSelectColumn(Tbbn008DocumentoBienesPeer::CO_DOCUMENTO_BIENES);
        $c->addSelectColumn(Tbbn005TipoDocumentoPeer::TX_DOCUMENTO);
        $c->addSelectColumn(Tbbn004SubtipoMovimientoBienesPeer::TX_SUBTIPO_MOVIMIENTO);
        $c->addSelectColumn(Tb171BienesPeer::CO_UBICACION);
        $c->addJoin(Tb171BienesPeer::CO_BIENES, Tb173MovimientoBienesPeer::CO_BIENES);
        $c->addJoin(Tbbn008DocumentoBienesPeer::CO_DOCUMENTO_BIENES, Tb173MovimientoBienesPeer::CO_DOCUMENTO);
        $c->addJoin(Tbbn005TipoDocumentoPeer::CO_DOCUMENTO, Tbbn008DocumentoBienesPeer::CO_TIPO_DOCUMENTO);
        $c->addJoin(Tbbn004SubtipoMovimientoBienesPeer::CO_SUBTIPO_MOVIMIENTO_BIENES, Tbbn008DocumentoBienesPeer::CO_SUBTIPO_MOVIMIENTO);
        $c->addJoin(Tbbn008DocumentoBienesPeer::CO_UBICACION, Tbbn006OrganigramaPeer::CO_ORGANIGRAMA, Criteria::LEFT_JOIN);
        $c->addJoin(Tb171BienesPeer::CO_MODELO,Tb175ModeloPeer::CO_MODELO,  Criteria::LEFT_JOIN);
        $c->addJoin(Tb175ModeloPeer::CO_MARCA, Tb174MarcaPeer::CO_MARCA,  Criteria::LEFT_JOIN);

        $c->add(Tbbn008DocumentoBienesPeer::CO_SOLICITUD, $co_solicitud);

        $c->addAscendingOrderByColumn(Tb173MovimientoBienesPeer::CO_MOVIMIENTO_BIENES);
        $cantidadTotal = Tb171BienesPeer::doCount($c);

        $stmt = Tb171BienesPeer::doSelectStmt($c);
        //var_dump(Tb173MovimientoBienesPeer::getEjecutor(17));
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reg["ubicacion_ant"] = Tbbn006OrganigramaPeer::getOrganigrama($reg["co_ubicacion"]);
            //$reg["n_fisico"] = Tb173MovimientoBienesPeer::getFisico($reg["co_fisico"]);
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros,
        ));

        $this->setTemplate('store');
    }

    public function executeEliminar(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_bienes");
        $solicitud = $this->getRequestParameter("co_solicitud");
        $mov = $this->getRequestParameter("co_movimiento");
        $doc = $this->getRequestParameter("co_documento");
        $con = Propel::getConnection();
        try
        {
            $con->beginTransaction();
            /*CAMPOS*/
            //$dd=Tb173MovimientoBienesPeer::getCantidad($codigo);
            if (Tb173MovimientoBienesPeer::getCantidad($codigo) <= 1) {
                if (Tb173MovimientoBienesPeer::retrieveByPK(Tb173MovimientoBienesPeer::getCoMovimientoBien2($mov))) {
                    $tb173_movimientos_bienes = Tb173MovimientoBienesPeer::retrieveByPK($mov);
                    $tb173_movimientos_bienes->delete($con);
                }

                if (Tb173MovimientoBienesPeer::getCantidadDoc($doc) <= 0) {
                    $tbbn008_documento_bienes = Tbbn008DocumentoBienesPeer::retrieveByPK($doc);
                    $tbbn008_documento_bienes->delete($con);
                }

                $tb171_bienes = Tb171BienesPeer::retrieveByPk($codigo);
                $tb171_bienes->delete($con);

                $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Registro Borrado con exito!',
                ));
            } else {
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'Este Bien no se puede borrar porque <br> ya posee varios de movimientos ',
                ));
            }
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
//        "msg" =>  $e->getMessage()
                "msg" => 'Este registro no se puede borrar porque <br>se encuentra asociado a otros registros ',
            ));
        }
        $this->setTemplate('eliminar');
    }

    public function executeEliminarTraslado(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_bienes");
        $codigo2 = $this->getRequestParameter("co_movimiento_bienes");
        $con = Propel::getConnection();
        try
        {
            $ult = Tb173MovimientoBienesPeer::getUltimoMovimiento($codigo);
            $veri = Tb173MovimientoBienesPeer::getVeriMovimiento($codigo);
            if ($ult == $codigo2 || $veri == false) {
                $con->beginTransaction();
                /*CAMPOS*/
                $tb173_movimientos_bienes = Tb173MovimientoBienesPeer::retrieveByPK($codigo2);
                $tb173_movimientos_bienes->delete($con);

                if (Tb173MovimientoBienesPeer::getCantidadDoc($this->getRequestParameter("co_documento_bienes")) <= 0) {
                    $tbbn008_documento_bienes = Tbbn008DocumentoBienesPeer::retrieveByPK($this->getRequestParameter("co_documento_bienes"));
                    $tbbn008_documento_bienes->delete($con);
                }

                $tb171_bienes = Tb171BienesPeer::retrieveByPk($codigo);
                $tb171_bienes->setCoUbicacion(Tb173MovimientoBienesPeer::getUltimoUbicacion($codigo))
                    ->save($con);

                $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Registro Borrado con exito!',
                ));
                $con->commit();
            } else {
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'Este registro no se puede borrar porque <br> ya exiten movimientos mas recientes',
                ));
            }
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
//        "msg" =>  $e->getMessage()
                "msg" => 'Este registro no se puede borrar porque <br>se encuentra asociado a otros registros',
            ));
        }
        $this->setTemplate('eliminarTraslado');
    }

    public function executeEliminarDesincorporacion(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_bienes");
        $codigo2 = $this->getRequestParameter("co_movimiento_bienes");
        $con = Propel::getConnection();
        try
        {

            $incorporado = Tb171BienesPeer::getIncorporacion($codigo);
            if ($incorporado) {
                $con->beginTransaction();
                /*CAMPOS*/

                $tb173_movimientos_bienes = Tb173MovimientoBienesPeer::retrieveByPK($codigo2);
                $tb173_movimientos_bienes->delete($con);

                if (Tb173MovimientoBienesPeer::getCantidadDoc($this->getRequestParameter("co_documento_bienes")) <= 0) {
                    $tbbn008_documento_bienes = Tbbn008DocumentoBienesPeer::retrieveByPK($this->getRequestParameter("co_documento_bienes"));
                    $tbbn008_documento_bienes->delete($con);
                }

                $tb171_bienes = Tb171BienesPeer::retrieveByPk($codigo);
                $tb171_bienes->setInActivo(true)
                    ->setCoDocDes(null)
                    ->save($con);

                $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Registro Borrado con exito!',
                ));
                $con->commit();

            } else {
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'Este registro no se puede borrarr porque <br> ya se encuentra desincorporado',
                ));
            }

        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
//        "msg" =>  $e->getMessage()
                "msg" => 'Este registro no se puede borrar porque <br>se encuentra asociado a otros registros',
            ));
        }
        $this->setTemplate('eliminarDesincorporacion');
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

}
