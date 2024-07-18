<?php

/**
 * autoCompras actions.
 * NombreClaseModel(Tb052Compras)
 * NombreTabla(tb052_compras)
 * @package    ##PROJECT_NAME##
 * @subpackage autoCompras
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class ComprasActions extends sfActions
{

    public function executeIndex(sfWebRequest $request)
    {
        //$this->forward('Compras', 'lista');
        $codigo =  $this->getRequestParameter("co_solicitud");
        $con = Propel::getConnection();
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addSelectColumn(Tb052ComprasPeer::CO_REQUISICION);
        $c->addSelectColumn(Tb052ComprasPeer::IN_RESPONSABILIDAD_SOCIAL);
        $c->addSelectColumn(Tb052ComprasPeer::CO_ENTE);
        $c->addSelectColumn(Tb052ComprasPeer::CO_USUARIO);
        $c->addSelectColumn(Tb052ComprasPeer::FECHA_COMPRA);
        $c->addSelectColumn(Tb052ComprasPeer::TX_OBSERVACION);
        $c->addSelectColumn(Tb052ComprasPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb052ComprasPeer::CO_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb052ComprasPeer::ANIO);
        $c->addSelectColumn(Tb052ComprasPeer::NUMERO_COMPRA);
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_SUB_TOTAL);
        $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_IVA);
        $c->addSelectColumn(Tb052ComprasPeer::NU_ORDEN_COMPRA);
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_TOTAL);
        $c->addSelectColumn(Tb052ComprasPeer::CO_EJECUTOR);
        $c->addSelectColumn(Tb052ComprasPeer::CO_PROYECTO_AC);
        $c->addSelectColumn(Tb052ComprasPeer::CO_ACCION_ESPECIFICA);
        $c->addSelectColumn(Tb052ComprasPeer::CO_PARTIDA_IVA);
        $c->addSelectColumn(Tb052ComprasPeer::CREATED_AT);
        $c->addSelectColumn(Tb052ComprasPeer::FORMA_ENTREGA);
        $c->addSelectColumn(Tb052ComprasPeer::FORMA_PAGO);
        $c->addSelectColumn(Tb052ComprasPeer::CO_SOLICITUD_COTIZACION);
        $c->addSelectColumn(Tb052ComprasPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tb206CotizacionPeer::TX_SERIAL_COTIZACION);
        $c->addSelectColumn(Tb056ContratoComprasPeer::CO_CONTRATO_COMPRAS);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_INICIO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_FIN);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_ENTREGA);
        $c->addSelectColumn(Tb056ContratoComprasPeer::TIEMPO_GARANTIA);
        $c->addSelectColumn(Tb056ContratoComprasPeer::CO_RAMO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::MONTO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::CO_TP_CONTRATO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::CO_FUENTE_FINANCIAMIENTO);
        $c->addSelectColumn(Tb045FacturaPeer::CO_FACTURA);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);
        $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD, Tb045FacturaPeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
        $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD_COTIZACION, Tb206CotizacionPeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb052ComprasPeer::CO_PROVEEDOR);
        $c->addJoin(Tb056ContratoComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
        $stmt = Tb052ComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($campos["co_compras"] != '') {

            $requisicion = $this->getRequisicion($this->getRequestParameter("co_solicitud"));
            $this->co_requisicion = $requisicion["co_requisicion"];
            list($anio, $mes, $dia) = explode("-", $campos["created_at"]);

            $this->data = json_encode(array(
                "co_proveedor"       => $campos["co_proveedor"],
                "co_documento"       => $campos["co_documento"],
                "tx_rif"             => $campos["tx_rif"],
                "tx_razon_social"    => $campos["tx_razon_social"],
                "tx_direccion"       => $campos["tx_direccion"],
                "co_compras"         => $campos["co_compras"],
                "co_requisicion"     => $campos["co_requisicion"],
                "co_solicitud"       => $campos["co_solicitud"],
                "co_tipo_solicitud"  => $campos["co_tipo_solicitud"],
                "nu_compra"          => $campos["numero_compra"],
                "co_usuario"         => $campos["co_usuario"],
                "co_ejecutor"        => $campos["co_ejecutor"],
                "co_proyecto"        => $campos["co_proyecto_ac"],
                "co_accion"          => $campos["co_accion_especifica"],
                "co_partida_iva"     => $campos["co_partida_iva"],
                "co_ente"            => $campos["co_ente"],
                "tx_observacion"     => $campos["tx_observacion"],
                "fecha_compra"       => $campos["fecha_compra"],
                "fe_registro"        => $dia . '-' . $mes . '-' . $anio,
                "co_contrato_compras" => $campos["co_contrato_compras"],
                "fecha_inicio"       => $campos["fecha_inicio"],
                "fecha_fin"          => $campos["fecha_fin"],
                "fecha_entrega"      => $campos["fecha_entrega"],
                "tiempo_garantia"    => $campos["tiempo_garantia"],
                "co_ramo"            => $campos["co_ramo"],
                "tx_concepto"            => $campos["tx_concepto"],
                "monto"              => $campos["monto"],
                "co_tp_contrato"     => $campos["co_tp_contrato"],
                "co_fuente_financiamiento" => $campos["co_fuente_financiamiento"],
                "monto_compra"       => $campos["monto_sub_total"],
                "co_iva_factura"     => $campos["nu_iva"],
                "monto_iva"          => $campos["monto_iva"],
                "monto_total"        => $campos["monto_total"],
                "nu_orden_compra"    => $campos["nu_orden_compra"],
                "in_responsabilidad_social" => $campos["in_responsabilidad_social"],
                "co_factura"                => ($campos["co_factura"] == null) ? '' : $campos["co_factura"],
                "co_solicitud_cotizacion"   => $campos["co_solicitud_cotizacion"],
                "tx_serial_cotizacion"      => $campos["tx_serial_cotizacion"],
                "forma_pago"                => $campos["forma_pago"],
                "forma_entrega"             => $campos["forma_entrega"],

            ));
        } else {


            $requisicion = $this->getRequisicion($this->getRequestParameter("co_solicitud"));
            $this->co_requisicion = $requisicion["co_requisicion"];
            $c = new Criteria();
            //$c->add(Tb052ComprasPeer::ANIO, date('Y'));
            $c->add(Tb052ComprasPeer::ANIO, $this->getUser()->getAttribute('ejercicio'));
            $c->add(Tb052ComprasPeer::CO_TIPO_SOLICITUD, $this->getRequestParameter("co_tipo_solicitud"));
            $total = Tb052ComprasPeer::doCount($c);
            $correlativo = $total + 1;


            $cp = new Criteria();
            $cp->clearSelectColumns();
            $cp->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
            $cp->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
            $cp->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
            $cp->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
            $cp->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
            $cp->addSelectColumn(Tb045FacturaPeer::CO_IVA_FACTURA);
            $cp->addSelectColumn(Tb045FacturaPeer::CO_RAMO);
            $cp->addSelectColumn(Tb045FacturaPeer::CO_FACTURA);
            $cp->add(Tb045FacturaPeer::CO_SOLICITUD, $codigo);
            $cp->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb045FacturaPeer::CO_PROVEEDOR);
            $stmt = Tb008ProveedorPeer::doSelectStmt($cp);
            $campos_proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

            $cm = new Criteria();
            $cm->clearSelectColumns();
            $cm->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_TOTAL . ') as total');
            $cm->add(Tb045FacturaPeer::CO_SOLICITUD, $codigo);
            $stmt = Tb045FacturaPeer::doSelectStmt($cm);
            $monto = $stmt->fetch(PDO::FETCH_ASSOC);

            if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                $nu_compra =  date("Ym", strtotime($this->getUser()->getAttribute('fe_cierre'))) . '-' . $correlativo;
            } else {
                $nu_compra = date("Ym") . '-' . $correlativo;
            }

            $this->data = json_encode(array(
                "co_compras"         => "",
                "co_proveedor"       => $campos_proveedor["co_proveedor"],
                "co_requisicion"     => $requisicion["co_requisicion"],
                "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                "fe_registro"        => "",
                "co_documento"       => $campos_proveedor["co_documento"],
                "nu_compra"          => 'Por Asignar',
                "co_usuario"         => "",
                "co_proyecto"        => "",
                "co_accion"          => "",
                "co_partida_iva"     => "",
                "co_ejecutor"        => "",
                "tx_concepto"        => "",
                "tx_observacion"     => "",
                "co_ente"            => "",
                "fecha_entrega"      => "",
                "co_factura"         => "",
                "tiempo_garantia"    => "",
                "co_tp_contrato"     => "",
                "co_fuente_financiamiento" => "",
                "monto_compra"       => 0,
                "monto_iva"          => 0,
                "monto_total"        => 0,
                "nu_orden_compra"    => "",
                "monto"              => ($monto["total"] != '') ? $monto["total"] : 0,
                "co_iva_factura"     => ($campos_proveedor["co_iva_factura"] == null) ? "" : $campos_proveedor["co_iva_factura"],
                "tx_rif"             => ($campos_proveedor["tx_rif"] == null) ? "" : $campos_proveedor["tx_rif"],
                "tx_razon_social"    => ($campos_proveedor["tx_razon_social"] == null) ? "" : $campos_proveedor["tx_razon_social"],
                "tx_direccion"       => ($campos_proveedor["tx_direccion"] == null) ? "" : $campos_proveedor["tx_direccion"],
                "co_ramo"            => ($campos_proveedor["co_ramo"] == null) ? "" : $campos_proveedor["co_ramo"],
                "co_factura"         => ($campos_proveedor["co_factura"] == null) ? "" : $campos_proveedor["co_factura"]
            ));
        }
    }

    protected function getOrigenDestino($codigo)
    {
        $c = new Criteria();
        $c->add(Tb110OrigenViaticoPeer::CO_ORIGEN_VIATICO, $codigo);

        $stmt = Tb110OrigenViaticoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos["tx_origen_viatico"];
    }

    public function executeEditarViatico(sfWebRequest $request)
    {
    }

    protected function getCoCompras($codigo)
    {
        $c = new Criteria();
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);
        $stmt = Tb052ComprasPeer::doSelectStmt($c);
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $datos["co_compras"];
    }

    public function executeAyudaAporteSocial(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_SOLICITUD_AYUDA);
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_TIPO_AYUDA);
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::FE_RESOLUCION);
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::NU_RESOLUCION);
        $c->addSelectColumn(Tb052ComprasPeer::TX_OBSERVACION);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_COMPRAS);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PARTIDA);
        $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
        $c->addSelectColumn(Tb053DetalleComprasPeer::DETALLE);

        $c->addJoin(Tb126SolicitudAyudaPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS, Criteria::LEFT_JOIN);

        $c->add(Tb126SolicitudAyudaPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb126SolicitudAyudaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
            "co_solicitud_ayuda"     => $campos["co_solicitud_ayuda"],
            "co_compras"             => $campos["co_compras"],
            "co_detalle_compras"     => $campos["co_detalle_compras"],
            "co_partida"             => $campos["co_partida"],
            "monto"                  => $campos["monto"],
            "detalle"                => $campos["detalle"],
            "co_persona"             => $campos["co_proveedor"],
            "co_tipo_ayuda"          => $campos["co_tipo_ayuda"],
            "tx_observacion"         => $campos["tx_observacion"],
            "fe_resolucion"          => $campos["fe_resolucion"],
            "nu_resolucion"          => $campos["nu_resolucion"],
            "co_solicitud"           => $this->getRequestParameter("co_solicitud"),
            "co_usuario"             => $this->getUser()->getAttribute('codigo')
        ));
    }


    public function executeAyuda(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_solicitud");
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_SOLICITUD_AYUDA);
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_TIPO_AYUDA);
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::FE_RESOLUCION);
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::NU_RESOLUCION);
        $c->addSelectColumn(Tb126SolicitudAyudaPeer::IN_MOSTRAR_PARTIDA);
        $c->addSelectColumn(Tb052ComprasPeer::TX_OBSERVACION);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_COMPRAS);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PARTIDA);
        $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
        $c->addSelectColumn(Tb053DetalleComprasPeer::DETALLE);

        $c->addJoin(Tb126SolicitudAyudaPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS, Criteria::LEFT_JOIN);

        $c->add(Tb126SolicitudAyudaPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb126SolicitudAyudaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
            "co_solicitud_ayuda"     => $campos["co_solicitud_ayuda"],
            "co_compras"             => $campos["co_compras"],
            "co_detalle_compras"     => $campos["co_detalle_compras"],
            "co_partida"             => $campos["co_partida"],
            "monto"                  => $campos["monto"],
            "detalle"                => $campos["detalle"],
            "co_persona"             => $campos["co_proveedor"],
            "co_tipo_ayuda"          => $campos["co_tipo_ayuda"],
            "tx_observacion"         => $campos["tx_observacion"],
            "fe_resolucion"          => $campos["fe_resolucion"],
            "in_mostar_partida"      => $campos["in_mostar_partida"],
            "nu_resolucion"          => $campos["nu_resolucion"],
            "co_solicitud"           => $this->getRequestParameter("co_solicitud"),
            "co_usuario"             => $this->getUser()->getAttribute('codigo')
        ));
    }

    public function getCoProveedor($co_solicitud)
    {

        $c = new Criteria();
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $co_solicitud);
        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos["co_proveedor"];
    }

    public function getMoFactura($co_solicitud)
    {

        $monto = 0;
        $c = new Criteria();
        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS, Criteria::LEFT_JOIN);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $co_solicitud);
        $c->add(Tb053DetalleComprasPeer::IN_CALCULAR_IVA, true);

        // echo $c->toString(); exit();
        $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $monto += $reg["precio_unitario"];
        }

        return $monto;
    }

    public function executeGuardarAyudaAporteSocial(sfWebRequest $request)
    {
        $codigo                     = $this->getRequestParameter("co_compras");
        $co_solicitud_ayuda         = $this->getRequestParameter("co_solicitud_ayuda");
        $co_detalle_compras         = $this->getRequestParameter("co_detalle_compras");
        $tb126_solicitud_ayudaForm  = $this->getRequestParameter("tb126_solicitud_ayuda");

        $mo_total = $tb126_solicitud_ayudaForm["mo_ayuda"];


        $con = Propel::getConnection();
        if ($codigo != '' || $codigo != null) {
            $tb052_compras = Tb052ComprasPeer::retrieveByPk($codigo);
        } else {
            $tb052_compras = new Tb052Compras();
        }
        try {
            $con->beginTransaction();
            $tb052_compras->setCoUsuario($this->getUser()->getAttribute('codigo'));
            //$tb052_compras->setFechaCompra(date("Y-m-d"));
            if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                $tb052_compras->setFechaCompra($this->getUser()->getAttribute('fe_cierre'));
            } else {
                $tb052_compras->setFechaCompra(date("Y-m-d"));
            }
            $tb052_compras->setTxObservacion($tb126_solicitud_ayudaForm["tx_observacion"]);
            $tb052_compras->setCoSolicitud($tb126_solicitud_ayudaForm["co_solicitud"]);
            $tb052_compras->setCoTipoSolicitud(28);
            //$tb052_compras->setAnio(date('Y'));
            $tb052_compras->setAnio($this->getUser()->getAttribute('ejercicio'));
            $tb052_compras->setNuIva(0);
            $tb052_compras->setMontoIva(0);
            $tb052_compras->setMontoSubTotal(0);
            $tb052_compras->setMontoTotal($mo_total);
            $tb052_compras->setCoTipoMovimiento(0);
            $tb052_compras->save($con);


            $tb126_solicitud_ayuda = Tb126SolicitudAyudaPeer::retrieveByPK($co_solicitud_ayuda);
            //$tb126_solicitud_ayuda->setNuResolucion($tb126_solicitud_ayudaForm["nu_resolucion"]);
            list($dia, $mes, $anio) = explode("/", $tb126_solicitud_ayudaForm["fe_resolucion"]);
            $tb126_solicitud_ayuda->setFeResolucion($anio . '-' . $mes . '-' . $dia);
            $tb126_solicitud_ayuda->save($con);

            if ($co_detalle_compras == '') {
                $tb053_detalle_compras = new Tb053DetalleCompras();
            } else {
                $tb053_detalle_compras = Tb053DetalleComprasPeer::retrieveByPK($co_detalle_compras);
            }

            $tb053_detalle_compras->setCoCompras($tb052_compras->getCoCompras());
            $tb053_detalle_compras->setNuCantidad(1);
            $tb053_detalle_compras->setCoProducto(18554);
            $tb053_detalle_compras->setDetalle($tb126_solicitud_ayudaForm["tx_descripcion"]);
            $tb053_detalle_compras->setPrecioUnitario($mo_total);
            $tb053_detalle_compras->setMonto($mo_total);
            $tb053_detalle_compras->save($con);

            $co_proveedor = $this->getCoProveedor($tb126_solicitud_ayudaForm["co_solicitud"]);
            //$co_cuenta_contable = Tb024CuentaContablePeer::getCuentaContableProveedorRetencion($co_proveedor, 3);
            //$co_cuenta_por_pagar = Tb130CuentaDocumentoPeer::getCoCuentaContable($tb126_solicitud_ayudaForm["co_solicitud"]); //Factura

            $wherec = new Criteria();
            $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $tb126_solicitud_ayudaForm["co_solicitud"]);
            BasePeer::doDelete($wherec, $con);

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb126_solicitud_ayudaForm["co_solicitud"]));
            //      
            //        
            //        $tb061_asiento_contable = new Tb061AsientoContable();
            //        $tb061_asiento_contable->setMoDebe($mo_total)
            //                      ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"])
            //                      ->setCoSolicitud($tb126_solicitud_ayudaForm["co_solicitud"])
            //                      ->setCoUsuario($this->getUser()->getAttribute('codigo')) 
            //                      ->setCoRuta($ruta->getCoRuta())
            //                      ->setCoTipoAsiento(1)
            //                      ->save($con);
            //        
            //        $tb061_asiento_contable = new Tb061AsientoContable();
            //        $tb061_asiento_contable->setMoHaber($mo_total)
            //                      ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_orden_pago"])
            //                      ->setCoSolicitud($tb126_solicitud_ayudaForm["co_solicitud"])
            //                      ->setCoUsuario($this->getUser()->getAttribute('codigo'))
            //                      ->setCoTipoAsiento(2)
            //                      ->setCoRuta($ruta->getCoRuta())
            //                      ->save($con);     

            $ruta->setInCargarDato(true)->save($con);

            $con->commit();
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

            $co_odp = Tb060OrdenPagoPeer::generarODP($tb126_solicitud_ayudaForm["co_solicitud"], $con, $this->getUser()->getAttribute('ejercicio'));

            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Proceso realizado exitosamente'
            ));
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }

        $this->setTemplate('guardarAyuda');
    }

    public function executeGuardarAyuda(sfWebRequest $request)
    {
        $codigo                     = $this->getRequestParameter("co_compras");
        $co_solicitud_ayuda         = $this->getRequestParameter("co_solicitud_ayuda");
        $co_detalle_compras         = $this->getRequestParameter("co_detalle_compras");
        $tb126_solicitud_ayudaForm  = $this->getRequestParameter("tb126_solicitud_ayuda");

        $mo_total = $tb126_solicitud_ayudaForm["mo_ayuda"];

        $solicitud = Tb026SolicitudPeer::retrieveByPk($tb126_solicitud_ayudaForm["co_solicitud"]);

        $con = Propel::getConnection();
        if ($codigo != '' || $codigo != null) {
            $tb052_compras = Tb052ComprasPeer::retrieveByPk($codigo);
        } else {
            $tb052_compras = new Tb052Compras();
        }

        if ($co_solicitud_ayuda != '' || $co_solicitud_ayuda != null) {
            $tb126_solicitud_ayuda = Tb126SolicitudAyudaPeer::retrieveByPK($co_solicitud_ayuda);
        } else {
            $tb126_solicitud_ayuda = new Tb126SolicitudAyuda();
        }

        try {
            $con->beginTransaction();
            $tb052_compras->setCoUsuario($this->getUser()->getAttribute('codigo'));
            //$tb052_compras->setFechaCompra(date("Y-m-d"));
            if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                $tb052_compras->setFechaCompra($this->getUser()->getAttribute('fe_cierre'));
            } else {
                $tb052_compras->setFechaCompra(date("Y-m-d"));
            }
            $tb052_compras->setTxObservacion($tb126_solicitud_ayudaForm["tx_observacion"]);
            $tb052_compras->setCoSolicitud($tb126_solicitud_ayudaForm["co_solicitud"]);
            $tb052_compras->setCoTipoSolicitud($solicitud->getCoTipoSolicitud());
            $tb052_compras->setCoProveedor($tb126_solicitud_ayudaForm["co_persona"]);
            //$tb052_compras->setAnio(date('Y'));
            $tb052_compras->setAnio($this->getUser()->getAttribute('ejercicio'));
            $tb052_compras->setNuIva(0);
            $tb052_compras->setMontoIva(0);
            $tb052_compras->setMontoSubTotal(0);
            $tb052_compras->setMontoTotal($mo_total);
            $tb052_compras->setCoTipoMovimiento(0);
            $tb052_compras->setCoEjecutor(1);
            $tb052_compras->save($con);


            //        $tb126_solicitud_ayuda = Tb126SolicitudAyudaPeer::retrieveByPK($co_solicitud_ayuda);
            //        if (array_key_exists("in_mostrar_partida", $tb126_solicitud_ayudaForm)){
            //            $tb126_solicitud_ayuda->setInPartida(true);
            //        }else{
            //            $tb126_solicitud_ayuda->setInPartida(false);
            //        }
            //        $tb126_solicitud_ayuda->setNuResolucion($tb126_solicitud_ayudaForm["nu_resolucion"]);
            //        list($dia,$mes,$anio) = explode("/",$tb126_solicitud_ayudaForm["fe_resolucion"]);
            //        $tb126_solicitud_ayuda->setFeResolucion($anio.'-'.$mes.'-'.$dia);

            $tb126_solicitud_ayuda->setCoProveedor($tb126_solicitud_ayudaForm["co_persona"]);
            $tb126_solicitud_ayuda->setCoTipoAyuda($tb126_solicitud_ayudaForm["co_tipo_ayuda"]);
            $tb126_solicitud_ayuda->setTxObservacion($tb126_solicitud_ayudaForm["tx_observacion"]);
            $tb126_solicitud_ayuda->setCoSolicitud($tb126_solicitud_ayudaForm["co_solicitud"]);
            $tb126_solicitud_ayuda->setCoUsuario($tb126_solicitud_ayudaForm["co_usuario"]);
            $tb126_solicitud_ayuda->setIdTb013AnioFiscal($this->getUser()->getAttribute('ejercicio'));

            $tb126_solicitud_ayuda->setMoTotalAyuda($mo_total);
            $tb126_solicitud_ayuda->save($con);


            $solicitud->setCoProveedor($tb126_solicitud_ayudaForm["co_persona"])->save($con);

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb126_solicitud_ayudaForm["co_solicitud"]));
            $ruta->setCoUsuario($this->getUser()->getAttribute('codigo'));
            $ruta->setInCargarDato(true);
            $ruta->save($con);


            //Modificacion  Joel Camarillo 17/06/2021

            $c = new Criteria();
            $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS, Criteria::LEFT_JOIN);
            $c->add(Tb052ComprasPeer::CO_SOLICITUD, $tb126_solicitud_ayudaForm["co_solicitud"]);
            $c->add(Tb053DetalleComprasPeer::IN_CALCULAR_IVA, true);

            // echo $c->toString(); exit();
            $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);
            $registros = array();
            $cont = 0;
            while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $tb053_detalle_compras = Tb053DetalleComprasPeer::retrieveByPK($reg["co_detalle_compras"]);
                $tb053_detalle_compras->setNuCantidad(1);
                //            $tb053_detalle_compras->setCoProducto(18554);
                //            $tb053_detalle_compras->setCoProyectoAc(10);
                //            $tb053_detalle_compras->setCoAccionEspecifica(12);        
                $tb053_detalle_compras->setDetalle($tb126_solicitud_ayudaForm["tx_observacion"]);
                $tb053_detalle_compras->setPrecioUnitario($mo_total);
                $tb053_detalle_compras->setMonto($mo_total);
                //            $tb053_detalle_compras->setCoPartida($tb126_solicitud_ayudaForm["co_partida"]);
                $tb053_detalle_compras->save($con);

                $cont++;
            }

            if ($cont == 0) {
                if ($co_detalle_compras == '') {
                    $tb053_detalle_compras = new Tb053DetalleCompras();
                } else {
                    $tb053_detalle_compras = Tb053DetalleComprasPeer::retrieveByPK($co_detalle_compras);
                }

                $tb053_detalle_compras->setCoCompras($tb052_compras->getCoCompras());
                $tb053_detalle_compras->setNuCantidad(1);
                //            $tb053_detalle_compras->setCoProducto(18554);
                //            $tb053_detalle_compras->setCoProyectoAc(10);
                //            $tb053_detalle_compras->setCoAccionEspecifica(12);        
                $tb053_detalle_compras->setDetalle($tb126_solicitud_ayudaForm["tx_observacion"]);
                $tb053_detalle_compras->setPrecioUnitario($mo_total);
                $tb053_detalle_compras->setMonto($mo_total);
                //            $tb053_detalle_compras->setCoPartida($tb126_solicitud_ayudaForm["co_partida"]);
                $tb053_detalle_compras->save($con);
            }


            $con->commit();
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Proceso realizado exitosamente'
            ));
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }
    }


    public function executeViatico(sfWebRequest $request)
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

        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        // $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addSelectColumn(Tb109PersonaPeer::NU_CELULAR);


        $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
        $c->addJoin(Tb107TipoViaticoPeer::CO_TIPO_VIATICO,  Tb108ViaticoPeer::CO_TIPO_VIATICO);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR,  Tb108ViaticoPeer::CO_PROVEEDOR);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb109PersonaPeer::CO_PROVEEDOR);
        //  $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD,Tb108ViaticoPeer::CO_SOLICITUD);
        $c->add(Tb108ViaticoPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb108ViaticoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $campos["tx_origen"]  = $this->getOrigenDestino($campos["co_origen"]);
        $campos["tx_destino"] = $this->getOrigenDestino($campos["co_destino"]);
        $campos["fe_desde"]   = date('d-m-Y', strtotime($campos["fe_desde"]));
        $campos["fe_hasta"]   = date('d-m-Y', strtotime($campos["fe_hasta"]));
        $campos["nu_cedula"]  = $campos["inicial"] . '-' . $campos["tx_rif"];
        $campos["nb_persona"] = $campos["tx_razon_social"];
        $campos["co_compra"]  = $this->getCoCompras($codigo);

        $datos_detalle = $this->getDetallesCompra($campos["co_compras"]);
        $campos["co_partida"] = $datos_detalle["co_partida"];

        $this->data = json_encode($campos);
    }



    public function executeNuevo(sfWebRequest $request)
    {
        $this->forward('Compras', 'editar');
    }

    public function executeFiltro(sfWebRequest $request)
    {
    }

    public function executeEditar(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");
        $con = Propel::getConnection();
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addSelectColumn(Tb052ComprasPeer::CO_REQUISICION);
        $c->addSelectColumn(Tb052ComprasPeer::IN_RESPONSABILIDAD_SOCIAL);
        $c->addSelectColumn(Tb052ComprasPeer::CO_ENTE);
        $c->addSelectColumn(Tb052ComprasPeer::CO_USUARIO);
        $c->addSelectColumn(Tb052ComprasPeer::FECHA_COMPRA);
        $c->addSelectColumn(Tb052ComprasPeer::TX_OBSERVACION);
        $c->addSelectColumn(Tb052ComprasPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb052ComprasPeer::CO_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb052ComprasPeer::ANIO);
        $c->addSelectColumn(Tb052ComprasPeer::NUMERO_COMPRA);
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_SUB_TOTAL);
        $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_IVA);
        $c->addSelectColumn(Tb052ComprasPeer::NU_ORDEN_COMPRA);
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_TOTAL);
        $c->addSelectColumn(Tb052ComprasPeer::CO_EJECUTOR);
        $c->addSelectColumn(Tb052ComprasPeer::CO_PROYECTO_AC);
        $c->addSelectColumn(Tb052ComprasPeer::CO_ACCION_ESPECIFICA);
        $c->addSelectColumn(Tb052ComprasPeer::CO_PARTIDA_IVA);
        $c->addSelectColumn(Tb052ComprasPeer::CREATED_AT);
        $c->addSelectColumn(Tb056ContratoComprasPeer::CO_CONTRATO_COMPRAS);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_INICIO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_FIN);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_ENTREGA);
        $c->addSelectColumn(Tb056ContratoComprasPeer::TIEMPO_GARANTIA);
        $c->addSelectColumn(Tb056ContratoComprasPeer::CO_RAMO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::MONTO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::CO_TP_CONTRATO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::CO_FUENTE_FINANCIAMIENTO);
        $c->addSelectColumn(Tb045FacturaPeer::CO_FACTURA);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);
        $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD, Tb045FacturaPeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb052ComprasPeer::CO_PROVEEDOR);
        $c->addJoin(Tb056ContratoComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
        $stmt = Tb052ComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($campos["co_compras"] != '') {

            $requisicion = $this->getRequisicion($this->getRequestParameter("co_solicitud"));
            $this->co_requisicion = $requisicion["co_requisicion"];
            list($anio, $mes, $dia) = explode("-", $campos["created_at"]);

            $this->data = json_encode(array(
                "co_proveedor"       => $campos["co_proveedor"],
                "co_documento"       => $campos["co_documento"],
                "tx_rif"             => $campos["tx_rif"],
                "tx_razon_social"    => $campos["tx_razon_social"],
                "tx_direccion"       => $campos["tx_direccion"],
                "co_compras"         => $campos["co_compras"],
                "co_requisicion"     => $campos["co_requisicion"],
                "co_solicitud"       => $campos["co_solicitud"],
                "co_tipo_solicitud"  => $campos["co_tipo_solicitud"],
                "nu_compra"          => $campos["numero_compra"],
                "co_usuario"         => $campos["co_usuario"],
                "co_ejecutor"        => $campos["co_ejecutor"],
                "co_proyecto"        => $campos["co_proyecto_ac"],
                "co_accion"          => $campos["co_accion_especifica"],
                "co_partida_iva"     => $campos["co_partida_iva"],
                "co_ente"            => $campos["co_ente"],
                "tx_observacion"     => $campos["tx_observacion"],
                "fecha_compra"       => $campos["fecha_compra"],
                "fe_registro"        => $dia . '-' . $mes . '-' . $anio,
                "co_contrato_compras" => $campos["co_contrato_compras"],
                "fecha_inicio"       => $campos["fecha_inicio"],
                "fecha_fin"          => $campos["fecha_fin"],
                "fecha_entrega"      => $campos["fecha_entrega"],
                "tiempo_garantia"    => $campos["tiempo_garantia"],
                "co_ramo"            => $campos["co_ramo"],
                "monto"              => $campos["monto"],
                "co_tp_contrato"     => $campos["co_tp_contrato"],
                "co_fuente_financiamiento" => $campos["co_fuente_financiamiento"],
                "monto_compra"       => $campos["monto_sub_total"],
                "co_iva_factura"     => $campos["nu_iva"],
                "monto_iva"          => $campos["monto_iva"],
                "monto_total"        => $campos["monto_total"],
                "nu_orden_compra"    => $campos["nu_orden_compra"],
                "in_responsabilidad_social" => $campos["in_responsabilidad_social"],
                "co_factura"         => ($campos["co_factura"] == null) ? '' : $campos["co_factura"]

            ));
        } else {


            $requisicion = $this->getRequisicion($this->getRequestParameter("co_solicitud"));
            $this->co_requisicion = $requisicion["co_requisicion"];
            $c = new Criteria();
            //$c->add(Tb052ComprasPeer::ANIO, date('Y'));
            $c->add(Tb052ComprasPeer::ANIO, $this->getUser()->getAttribute('ejercicio'));
            $c->add(Tb052ComprasPeer::CO_TIPO_SOLICITUD, $this->getRequestParameter("co_tipo_solicitud"));
            $total = Tb052ComprasPeer::doCount($c);
            $correlativo = $total + 1;


            $cp = new Criteria();
            $cp->clearSelectColumns();
            $cp->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
            $cp->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
            $cp->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
            $cp->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
            $cp->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
            $cp->addSelectColumn(Tb045FacturaPeer::CO_IVA_FACTURA);
            $cp->addSelectColumn(Tb045FacturaPeer::CO_RAMO);
            $cp->addSelectColumn(Tb045FacturaPeer::CO_FACTURA);
            $cp->add(Tb045FacturaPeer::CO_SOLICITUD, $codigo);
            $cp->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb045FacturaPeer::CO_PROVEEDOR);
            $stmt = Tb008ProveedorPeer::doSelectStmt($cp);
            $campos_proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

            $cm = new Criteria();
            $cm->clearSelectColumns();
            $cm->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_TOTAL . ') as total');
            $cm->add(Tb045FacturaPeer::CO_SOLICITUD, $codigo);
            $stmt = Tb045FacturaPeer::doSelectStmt($cm);
            $monto = $stmt->fetch(PDO::FETCH_ASSOC);

            if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                $nu_compra =  date("Ym", strtotime($this->getUser()->getAttribute('fe_cierre'))) . '-' . $correlativo;
            } else {
                $nu_compra = date("Ym") . '-' . $correlativo;
            }

            $this->data = json_encode(array(
                "co_compras"         => "",
                "co_proveedor"       => $campos_proveedor["co_proveedor"],
                "co_requisicion"     => $requisicion["co_requisicion"],
                "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                "co_tipo_solicitud"  => 1,
                "fe_registro"        => "",
                "co_documento"       => $campos_proveedor["co_documento"],
                "nu_compra"          => $nu_compra,
                "co_usuario"         => "",
                "co_proyecto"        => "",
                "co_accion"          => "",
                "co_partida_iva"     => "",
                "co_ejecutor"        => "",
                "tx_concepto"        => "",
                "tx_observacion"     => "",
                "co_ente"            => "",
                "fecha_entrega"      => "",
                "co_factura"         => "",
                "tiempo_garantia"    => "",
                "co_tp_contrato"     => "",
                "co_fuente_financiamiento" => "",
                "monto_compra"       => 0,
                "monto_iva"          => 0,
                "monto_total"        => 0,
                "nu_orden_compra"    => "",
                "monto"              => ($monto["total"] != '') ? $monto["total"] : 0,
                "co_iva_factura"     => ($campos_proveedor["co_iva_factura"] == null) ? "" : $campos_proveedor["co_iva_factura"],
                "tx_rif"             => ($campos_proveedor["tx_rif"] == null) ? "" : $campos_proveedor["tx_rif"],
                "tx_razon_social"    => ($campos_proveedor["tx_razon_social"] == null) ? "" : $campos_proveedor["tx_razon_social"],
                "tx_direccion"       => ($campos_proveedor["tx_direccion"] == null) ? "" : $campos_proveedor["tx_direccion"],
                "co_ramo"            => ($campos_proveedor["co_ramo"] == null) ? "" : $campos_proveedor["co_ramo"],
                "co_factura"         => ($campos_proveedor["co_factura"] == null) ? "" : $campos_proveedor["co_factura"]
            ));
        }
    }

    public function executeOrdenCompra(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");
        $con = Propel::getConnection();
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addSelectColumn(Tb052ComprasPeer::CO_REQUISICION);
        $c->addSelectColumn(Tb052ComprasPeer::CO_ENTE);
        $c->addSelectColumn(Tb052ComprasPeer::CO_USUARIO);
        $c->addSelectColumn(Tb052ComprasPeer::FECHA_COMPRA);
        $c->addSelectColumn(Tb052ComprasPeer::TX_OBSERVACION);
        $c->addSelectColumn(Tb052ComprasPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb052ComprasPeer::CO_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb052ComprasPeer::ANIO);
        $c->addSelectColumn(Tb052ComprasPeer::NUMERO_COMPRA);
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_SUB_TOTAL);
        $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_IVA);
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_TOTAL);
        $c->addSelectColumn(Tb052ComprasPeer::CO_EJECUTOR);
        $c->addSelectColumn(Tb052ComprasPeer::CO_PROYECTO_AC);
        $c->addSelectColumn(Tb052ComprasPeer::CO_ACCION_ESPECIFICA);
        $c->addSelectColumn(Tb052ComprasPeer::CO_PARTIDA_IVA);
        $c->addSelectColumn(Tb052ComprasPeer::CREATED_AT);
        $c->addSelectColumn(Tb056ContratoComprasPeer::CO_CONTRATO_COMPRAS);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_INICIO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_FIN);
        $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_ENTREGA);
        $c->addSelectColumn(Tb056ContratoComprasPeer::TIEMPO_GARANTIA);
        $c->addSelectColumn(Tb056ContratoComprasPeer::CO_RAMO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::MONTO);
        $c->addSelectColumn(Tb056ContratoComprasPeer::CO_TP_CONTRATO);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb052ComprasPeer::CO_PROVEEDOR);
        $c->addJoin(Tb056ContratoComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
        $stmt = Tb052ComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($campos["co_compras"] != '') {

            $requisicion = $this->getRequisicion($this->getRequestParameter("co_solicitud"));
            $this->co_requisicion = $requisicion["co_requisicion"];
            list($anio, $mes, $dia) = explode("-", $campos["created_at"]);

            $this->data = json_encode(array(
                "co_proveedor"       => $campos["co_proveedor"],
                "co_documento"       => $campos["co_documento"],
                "tx_rif"             => $campos["tx_rif"],
                "tx_razon_social"    => $campos["tx_razon_social"],
                "tx_direccion"       => $campos["tx_direccion"],
                "co_compras"         => $campos["co_compras"],
                "co_requisicion"     => $campos["co_requisicion"],
                "co_solicitud"       => $campos["co_solicitud"],
                "co_tipo_solicitud"  => $campos["co_tipo_solicitud"],
                "nu_compra"          => $campos["numero_compra"],
                "co_usuario"         => $campos["co_usuario"],
                "co_ejecutor"        => $campos["co_ejecutor"],
                "co_proyecto"        => $campos["co_proyecto_ac"],
                "co_accion"          => $campos["co_accion_especifica"],
                "co_partida_iva"     => $campos["co_partida_iva"],
                "co_ente"            => $campos["co_ente"],
                "tx_observacion"     => $campos["tx_observacion"],
                "fecha_compra"       => $campos["fecha_compra"],
                "fe_registro"        => $dia . '-' . $mes . '-' . $anio,
                "co_contrato_compras" => $campos["co_contrato_compras"],
                "fecha_inicio"       => $campos["fecha_inicio"],
                "fecha_fin"          => $campos["fecha_fin"],
                "fecha_entrega"      => $campos["fecha_entrega"],
                "tiempo_garantia"    => $campos["tiempo_garantia"],
                "co_ramo"            => $campos["co_ramo"],
                "monto"              => $campos["monto"],
                "co_tp_contrato"     => $campos["co_tp_contrato"],
                "monto_compra"       => $campos["monto_sub_total"],
                "co_iva_factura"     => $campos["nu_iva"],
                "monto_iva"          => $campos["monto_iva"],
                "monto_total"        => $campos["monto_total"],


            ));
        } else {


            $requisicion = $this->getRequisicion($this->getRequestParameter("co_solicitud"));
            $this->co_requisicion = $requisicion["co_requisicion"];
            $c = new Criteria();
            //$c->add(Tb052ComprasPeer::ANIO, date('Y'));
            $c->add(Tb052ComprasPeer::ANIO, $this->getUser()->getAttribute('ejercicio'));
            $c->add(Tb052ComprasPeer::CO_TIPO_SOLICITUD, $this->getRequestParameter("co_tipo_solicitud"));
            $total = Tb052ComprasPeer::doCount($c);
            $correlativo = $total + 1;

            $this->data = json_encode(array(
                "co_compras"         => "",
                "co_proveedor"       => "",
                "co_requisicion"     => $requisicion["co_requisicion"],
                "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                "fe_registro"        => "",
                "co_documento"       => "",
                //"nu_compra"          => date('Y').'-'.$correlativo,
                "nu_compra"          => $this->getUser()->getAttribute('ejercicio') . '-' . $correlativo,
                "co_usuario"         => "",
                "co_proyecto"        => "",
                "co_accion"          => "",
                "co_partida_iva"     => "",
                "co_ejecutor"        => "",
                "tx_concepto"        => "",
                "tx_observacion"     => "",
                "co_ente"            => "",
                "fecha_entrega"      => "",
                "tiempo_garantia"    => "",
                "co_tp_contrato"     => "",
                "monto_compra"       => 0,
                "monto_iva"          => 0,
                "monto_total"        => 0,
                "co_iva_factura"     => "",
            ));
        }
    }

    public function getRequisicion($codigo)
    {

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb039RequisicionesPeer::CO_REQUISICION);
        $c->add(Tb039RequisicionesPeer::CO_SOLICITUD, $codigo);
        $stmt = Tb039RequisicionesPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
    }

    public function getIVA($mo_iva, $codigo)
    {
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb044IvaRetencionPeer::NU_VALOR);
        $c->addJoin(Tb008ProveedorPeer::CO_IVA_RETENCION, Tb044IvaRetencionPeer::CO_IVA_RETENCION);
        $c->add(Tb008ProveedorPeer::CO_PROVEEDOR, $codigo);
        $stmt = Tb039RequisicionesPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $valor_iva = (100 - $campos['nu_valor']) / 100;

        return $mo_iva; //* $valor_iva;        
    }


    public function executeVerificarProveedor(sfWebRequest $request)
    {

        $co_documento  = $this->getRequestParameter('co_documento');
        $tx_rif        = $this->getRequestParameter('tx_rif');

        $c = new Criteria();
        if ($co_documento != '') {
            $c->add(Tb008ProveedorPeer::CO_DOCUMENTO, $co_documento);
        }
        if ($tx_rif != '') {
            $c->add(Tb008ProveedorPeer::TX_RIF, $tx_rif);
        }

        $stmt = Tb008ProveedorPeer::doSelectStmt($c);

        $registros = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        $this->setTemplate('store');
    }

    protected function getDetallesCompra($co_compra)
    {
        $cd = new Criteria();
        $cd->add(Tb053DetalleComprasPeer::CO_COMPRAS, $co_compra);
        $stmt = Tb053DetalleComprasPeer::doSelectStmt($cd);
        $datos_detalle = $stmt->fetch(PDO::FETCH_ASSOC);

        return $datos_detalle;
    }

    protected function getAccionEspecifica($codigo)
    {
        $cd = new Criteria();
        $cd->add(Tb085PresupuestoPeer::ID, $codigo);
        $stmt = Tb085PresupuestoPeer::doSelectStmt($cd);
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $datos["id_tb084_accion_especifica"];
    }

    public function executeGuardarViatico(sfWebRequest $request)
    {

        $codigo             = $this->getRequestParameter("co_compra");
        $json_detalle       = $this->getRequestParameter("json_detalle");
        // $co_partida         = $this->getRequestParameter("co_partida");
        $co_solicitud       = $this->getRequestParameter("co_solicitud");
        $mo_total           = $this->getRequestParameter("mo_total");
        $json_asignacion  = $this->getRequestParameter("json_asignacion");


        $c = new Criteria();
        //$c->add(Tb052ComprasPeer::ANIO, date('Y'));
        $c->add(Tb052ComprasPeer::ANIO, $this->getUser()->getAttribute('ejercicio'));
        $c->add(Tb052ComprasPeer::CO_TIPO_SOLICITUD, 22);
        $total = Tb052ComprasPeer::doCount($c);
        $correlativo = $total + 1;

        $con = Propel::getConnection();
        if ($codigo != '' || $codigo != null) {
            $tb052_compras = Tb052ComprasPeer::retrieveByPk($codigo);
        } else {
            $tb052_compras = new Tb052Compras();
        }
        try {
            $con->beginTransaction();

            $cv = new Criteria();
            $cv->add(Tb108ViaticoPeer::CO_SOLICITUD, $co_solicitud);
            $stmt = Tb108ViaticoPeer::doSelectStmt($cv);
            $datosv = $stmt->fetch(PDO::FETCH_ASSOC);





            $tb052_compras->setCoUsuario($this->getUser()->getAttribute('codigo'));
            //$tb052_compras->setFechaCompra(date("Y-m-d")); 
            if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                $tb052_compras->setFechaCompra($this->getUser()->getAttribute('fe_cierre'));
            } else {
                $tb052_compras->setFechaCompra(date("Y-m-d"));
            }
            $tb052_compras->setCoSolicitud($co_solicitud);
            $tb052_compras->setCoTipoSolicitud(22);
            $tb052_compras->setTxObservacion($datosv["tx_evento"]);                                                  
            $tb052_compras->setAnio($this->getUser()->getAttribute('ejercicio'));
            $tb052_compras->setNuIva(0);
            $tb052_compras->setMontoIva(0);
            $tb052_compras->setMontoSubTotal(0);
            $tb052_compras->setMontoTotal($mo_total);
            $tb052_compras->setCoTipoMovimiento(0);
            $tb052_compras->save($con);


            $cp = new Criteria();
            $cp->add(Tb048ProductoPeer::TX_PRODUCTO, 'VIATICO');
            $stmt = Tb048ProductoPeer::doSelectStmt($cp);
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);

            $datos_detalle = $this->getDetallesCompra($tb052_compras->getCoCompras());

            if ($datos_detalle["co_detalle_compras"] == '') {
                $tb053_detalle_compras = new Tb053DetalleCompras();
            } else {
                $tb053_detalle_compras = Tb053DetalleComprasPeer::retrieveByPK($datos_detalle["co_detalle_compras"]);
            }

            $tb053_detalle_compras->setCoCompras($tb052_compras->getCoCompras());
            $tb053_detalle_compras->setCoProducto($datos["co_producto"]);
            $tb053_detalle_compras->setNuCantidad(1);
            $tb053_detalle_compras->setPrecioUnitario($mo_total);
            $tb053_detalle_compras->setMonto($mo_total);
            $tb053_detalle_compras->save($con);


            $codigo = $tb052_compras->getCoCompras();

            $listaAsignacion  = json_decode($json_asignacion, true);
            foreach ($listaAsignacion  as $asignacionForm) {

                if (empty($tb053_detalle_compras->getCoPresupuesto())) {

                 
                    Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $asignacionForm["co_partida"], 1, $asignacionForm["monto"], '', $tb053_detalle_compras->getCoDetalleCompras());

                    Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $asignacionForm["co_partida"], 2, $asignacionForm["monto"], '', $tb053_detalle_compras->getCoDetalleCompras());



                    $c = new Criteria();
                    $c->add(Tb053DetalleComprasPeer::CO_COMPRAS, $codigo);
                    $c->add(Tb053DetalleComprasPeer::CO_PRESUPUESTO, null, Criteria::ISNOTNULL);
                    $cant = Tb053DetalleComprasPeer::doCount($c);


                    $Tb052Compra = Tb052ComprasPeer::retrieveByPk($codigo);

                    $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($Tb052Compra->getCoSolicitud()));

                    if ($cant > 0) {
                        $ruta->setInCargarDato(true)->save($con);
                    } else {
                        $ruta->setInCargarDato(false)->save($con);
                    }

                    $ruta->save($con);

                    $tb053_detalle_compras->setCoPresupuesto($asignacionForm["co_partida"]);
                    $tb053_detalle_compras->save($con);
                }
            }




            $listaDetalle  = json_decode($json_detalle, true);
            $array_detalle = array();
            $i = 0;
            $valor_ut = Tb118UnidadTributariaPeer::getUT();
            foreach ($listaDetalle  as $detalleForm) {

                $tb117_detalle_viatico = Tb117DetalleViaticoPeer::retrieveByPK($detalleForm["co_detalle_viatico"]);
                $tb117_detalle_viatico->setMoTotal($detalleForm["mo_total"])
                    ->setMoUt($valor_ut)
                    ->save($con);
            }

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
            $ruta->setCoUsuario($this->getUser()->getAttribute('codigo'));
            $ruta->setInCargarDato(true)->save($con);

            $con->commit();
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Proceso realizado exitosamente'
            ));
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }
    }

    public function getDatosSolicitud($codigo)
    {

        $c = new Criteria();
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $codigo);
        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
    }

    public function getDatosRequisicion($codigo)
    {

        $c = new Criteria();
        $c->add(Tb039RequisicionesPeer::CO_SOLICITUD, $codigo);
        $stmt = Tb039RequisicionesPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos['co_requisicion'];
    }

    public function getCoPresupuestoIVA($codigo)
    {

        $c = new Criteria();
        $c->add(Tb206CotizacionPeer::CO_SOLICITUD, $codigo);
        $c->add(Tb207DetalleCotizacionPeer::CO_PRODUCTO, 19336);
        $c->addJoin(Tb206CotizacionPeer::CO_COTIZACION, Tb207DetalleCotizacionPeer::CO_COTIZACION);
        $stmt = Tb207DetalleCotizacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos['co_presupuesto'];
    }

    public function executeGuardar(sfWebRequest $request)
    {

        $codigo                     = $this->getRequestParameter("co_compras");
        $co_solicitud_cotizacion    = $this->getRequestParameter("co_solicitud_cotizacion");
        $json_producto              = $this->getRequestParameter("json_producto");
        $tb008_proveedorForm        = $this->getRequestParameter('tb008_proveedor');
        $tb052_comprasForm          = $this->getRequestParameter('tb052_compras');



        $c = new Criteria();
        //$c->add(Tb052ComprasPeer::ANIO, date('Y'));

        $c->add(Tb052ComprasPeer::ANIO, $this->getUser()->getAttribute('ejercicio'));
        $c->add(Tb052ComprasPeer::CO_TIPO_SOLICITUD, $tb052_comprasForm["co_tipo_solicitud"]);
        $total = Tb052ComprasPeer::doCount($c);
        $correlativo = $total + 1;

        $con = Propel::getConnection();
        $con->beginTransaction();
        if ($codigo != '' || $codigo != null) {
            $tb052_compras = Tb052ComprasPeer::retrieveByPk($codigo);
        } else {
            $tb052_compras = new Tb052Compras();

            $tb026_solicitudForm = array(
                "co_tipo_solicitud"   => $tb052_comprasForm["co_tipo_solicitud"],
                "ejercicio"           => $this->getUser()->getAttribute('ejercicio'),
                "fe_solicitud"        => date("d/m/Y"),
                "observacion"         => $tb052_comprasForm["tx_observacion"],
                "codigo"              =>  $this->getUser()->getAttribute('codigo')
            );

            $resp = Tb026SolicitudPeer::setSolicitud($tb026_solicitudForm, $con);

            if ($resp["success"] == true) {
                $tb052_comprasForm["co_solicitud"] = $resp["co_solicitud"];
            } else {
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" =>  $resp["msg"]
                ));

                return;
            }

            if($tb052_comprasForm["co_tipo_solicitud"]==1){
                $co_serial = 2;
                $prefix = 'OC';
            }else{
                $co_serial = 3;
                $prefix = 'OS';
            }


            if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                $serial = $prefix.'-'.date("Ym", strtotime($this->getUser()->getAttribute('fe_cierre'))) . '-' . Tb137ControlSerialPeer::getSerial($co_serial, $con, $this->getUser()->getAttribute('ejercicio'));
            } else {
                $serial =  $prefix.'-'.date("Ym") . '-' . Tb137ControlSerialPeer::getSerial($co_serial, $con, $this->getUser()->getAttribute('ejercicio'));
            }

            $tb052_compras->setNumeroCompra($serial);
        }
        try {

            if (!empty($co_solicitud_cotizacion)) {
                $tb052_comprasForm["co_requisicion"] = $this->getDatosRequisicion($co_solicitud_cotizacion);
            }

            $tb052_compras->setCoRequisicion($tb052_comprasForm["co_requisicion"]);

            /*Campo tipo BIGINT */
            $tb052_compras->setCoEnte($tb052_comprasForm["co_ente"]);

            $tb052_compras->setCoSolicitudCotizacion($co_solicitud_cotizacion);

            /*Campo tipo BIGINT */
            $tb052_compras->setCoUsuario($this->getUser()->getAttribute('codigo'));

            /*Campo tipo DATE */
            //list($dia, $mes, $anio) = explode("/",$tb052_comprasForm["fecha_compra"]);
            //$fecha = $anio."-".$mes."-".$dia;
            //$tb052_compras->setFechaCompra($fecha);
            if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                //$tb052_compras->setFechaCompra($this->getUser()->getAttribute('fe_cierre')); 
                list($dia, $mes, $anio) = explode("/", $tb052_comprasForm["fecha_compra"]);
                $fecha_compra = $anio . "-" . $mes . "-" . $dia;
                $tb052_compras->setFechaCompra($fecha_compra);
            } else {
                $tb052_compras->setFechaCompra(date("Y-m-d"));
            }

            /*Campo tipo VARCHAR */
            $tb052_compras->setTxObservacion($tb052_comprasForm["tx_observacion"]);

            $tb052_compras->setTxConcepto($tb052_comprasForm["tx_concepto"]);

            /*Campo tipo BIGINT */
            $tb052_compras->setCoSolicitud($tb052_comprasForm["co_solicitud"]);

            $tb052_compras->setCoTipoSolicitud($tb052_comprasForm["co_tipo_solicitud"]);

            $tb052_compras->setCoProveedor($tb008_proveedorForm["co_proveedor"]);

            //$tb052_compras->setAnio(date('Y'));

            $tb052_compras->setAnio($this->getUser()->getAttribute('ejercicio'));

            $tb052_compras->setNuIva($tb052_comprasForm["co_iva_factura"]);

            $tb052_compras->setMontoIva($tb052_comprasForm["monto_iva"]);

            $tb052_compras->setMontoSubTotal($tb052_comprasForm["monto_compra"]);

            $tb052_compras->setMontoTotal($tb052_comprasForm["monto_total"]);

            $tb052_compras->setCoEjecutor($tb052_comprasForm["co_ejecutor"]);

            $tb052_compras->setNuOrdenCompra($tb052_comprasForm["nu_orden_compra"]);

            if (isset($tb052_comprasForm["in_responsabilidad_social"]))
                $tb052_compras->setInResponsabilidadSocial(true);
            else
                $tb052_compras->setInResponsabilidadSocial(false);

            $tb052_compras->setCoPartidaIva($tb052_comprasForm["co_partida_iva"] ? $tb052_comprasForm["co_partida_iva"] : null);

            $tb052_compras->setCoTipoMovimiento(0); //COMPRA PRE-COMPROMETIDO

            $tb052_compras->setFormaPago($tb052_comprasForm["forma_pago"]);

            $tb052_compras->setFormaEntrega($tb052_comprasForm["forma_entrega"]);

            /*CAMPOS*/
            $tb052_compras->save($con);





            //echo  $tb052_comprasForm["co_tipo_solicitud"]; exit();

            $listaProducto  = json_decode($json_producto, true);
            $array_producto = array();
            $i = 0;


        foreach ($listaProducto  as $productoForm) {

            if (empty($productoForm["co_detalle_compras"])) {
              $tb053_detalle_compras = new Tb053DetalleCompras();
            } else {
              $tb053_detalle_compras = Tb053DetalleComprasPeer::retrieveByPK($productoForm["co_detalle_compras"]);
            }
    
    
           /* if ($productoForm["in_modificado"]) {
              Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $productoForm["co_presupuesto"], 4, $tb053_detalle_compras->getMonto(), $productoForm["co_detalle_cotizacion"], $tb053_detalle_compras->getCoDetalleCompras());
    
              Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $productoForm["co_presupuesto"], 1, $productoForm["monto"], $productoForm["co_detalle_cotizacion"], $tb053_detalle_compras->getCoDetalleCompras());
            }*/
    
            //  $tb053_detalle_compras = new Tb053DetalleCompras();
            $tb053_detalle_compras->setCoCompras($tb052_compras->getCoCompras());
            $tb053_detalle_compras->setCoProducto($productoForm["co_producto"]);
            if ($productoForm["co_detalle_requisicion"] != '') {
              $tb053_detalle_compras->setCoDetalleRequisicion($productoForm["co_detalle_requisicion"]);
            }
    
            
            $tb053_detalle_compras->setNuCantidad($productoForm["nu_cantidad"]);
            $tb053_detalle_compras->setPrecioUnitario($productoForm["precio_unitario"]);
            $tb053_detalle_compras->setMonto($productoForm["monto"]);
            $tb053_detalle_compras->setDetalle($productoForm["detalle"]);
            $tb053_detalle_compras->setCoPresupuesto($productoForm["co_presupuesto"]);
            $tb053_detalle_compras->setCoUnidadProducto($productoForm["co_unidad_producto"]);
            $tb053_detalle_compras->setInCalcularIva(true);
            $tb053_detalle_compras->setInExento($productoForm["in_exento"]);
            $tb053_detalle_compras->setCoIvaProducto($productoForm["co_iva_producto"]);
            $tb053_detalle_compras->setMoIvaProducto($productoForm["mo_iva_producto"]);
            $tb053_detalle_compras->save($con);
    
            $co_enlace = $tb053_detalle_compras->getCoDetalleCompras();
    
          //  echo 'llego'; exit();
    
    
            if (empty($productoForm["co_detalle_compras"])) {
    
              $wherec = new Criteria();
              $wherec->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_PRESU_BASE, $productoForm["co_detalle_cotizacion"]);
    
              $updc = new Criteria();
              $updc->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $tb053_detalle_compras->getCoDetalleCompras());
              BasePeer::doUpdate($wherec, $updc, $con);
    
    
              $c = new Criteria();
              $c->add(Tb207DetalleCotizacionPeer::CO_PRODUCTO, 19336);
              $c->add(Tb207DetalleCotizacionPeer::CO_DETALLE_COTIZACION_ENLACE, $productoForm["co_detalle_cotizacion"]);
              $stmt = Tb207DetalleCotizacionPeer::doSelectStmt($c);
              $campoIva = $stmt->fetch(PDO::FETCH_ASSOC);
    
             
              $monto_iva_ant = $campoIva["monto"];
              $monto_iva = $this->getIVA($productoForm["mo_iva_producto"], $tb008_proveedorForm["co_proveedor"]);
    
              $tb053_detalle_compras_iva = new Tb053DetalleCompras();
            } else {
    
              $c = new Criteria();
              $c->add(Tb053DetalleComprasPeer::CO_DETALLE_COMPRA_ENLACE, $co_enlace);
              $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);
              $campoIva = $stmt->fetch(PDO::FETCH_ASSOC);
    
              $monto_iva_ant = $campoIva["monto"];
    
              $monto_iva = $this->getIVA($productoForm["mo_iva_producto"], $tb008_proveedorForm["co_proveedor"]);
              
    
              $tb053_detalle_compras_iva = Tb053DetalleComprasPeer::retrieveByPK($campoIva["co_detalle_compras"]);
            }
    
            
            if ($productoForm["in_modificado"]) {
              if($tb053_detalle_compras_iva != null){
                Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $campoIva["co_presupuesto"], 4, $monto_iva_ant, '', $tb053_detalle_compras_iva->getCoDetalleCompras());
    
                Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $campoIva["co_presupuesto"], 1, $monto_iva, '', $tb053_detalle_compras_iva->getCoDetalleCompras());
              }
            }
    
          
    
            /**********************IVA*******************************/
            if ($monto_iva > 0) {
    
              $tb053_detalle_compras_iva->setCoCompras($tb052_compras->getCoCompras());
              $tb053_detalle_compras_iva->setCoProducto(19336); //IMPUESTO AL VALOR AGREGADO (IVA)
              $tb053_detalle_compras_iva->setNuCantidad(1);
              $tb053_detalle_compras_iva->setCoPresupuesto($this->getCoPresupuestoIVA($co_solicitud_cotizacion));
              $tb053_detalle_compras_iva->setPrecioUnitario(round($monto_iva, 2));
              $tb053_detalle_compras_iva->setMonto(round($monto_iva, 2));
              $tb053_detalle_compras_iva->setDetalle('IMPUESTO AL VALOR AGREGADO (IVA)');
              $tb053_detalle_compras_iva->setCoPartida($campoIva["co_presupuesto"]);
              $tb053_detalle_compras_iva->setCoUnidadProducto(638);
              $tb053_detalle_compras_iva->setCoDetalleCompraEnlace($co_enlace);
              $tb053_detalle_compras_iva->save($con);
    
              if (!empty($tb052_comprasForm["tx_serial_cotizacion"])) {
    
                $wherec = new Criteria();
                $wherec->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_PRESU_BASE, $this->getCoDetalleCotizacionIva($tb052_comprasForm["tx_serial_cotizacion"]));
    
                $updc = new Criteria();
                $updc->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $tb053_detalle_compras->getCoDetalleCompras());
                BasePeer::doUpdate($wherec, $updc, $con);
              }
            }
    
    
            /********************************************************/
    
            /**********************Actualiza la Cotizacion Disponible********************/
    
    
            $cotizacion = Tb207DetalleCotizacionPeer::retrieveByPK($productoForm["co_detalle_cotizacion"]);
            $cotizacion->setCoDetalleCompra($co_enlace);
            $cotizacion->save($con);
    
            /************************************************************************** */
          }

            if ($tb052_comprasForm["co_contrato_compras"] != '' || $tb052_comprasForm["co_contrato_compras"] != null) {
                $tb056_contrato_compras = Tb056ContratoComprasPeer::retrieveByPk($tb052_comprasForm["co_contrato_compras"]);
            } else {
                $tb056_contrato_compras = new Tb056ContratoCompras();
            }
            $tb056_contrato_compras->setCoCompras($tb052_compras->getCoCompras());
            list($dia, $mes, $anio) = explode("/", $tb052_comprasForm["fecha_inicio"]);
            $fecha = $anio . "-" . $mes . "-" . $dia;
            $tb056_contrato_compras->setFechaInicio($fecha);
            list($dia, $mes, $anio) = explode("/", $tb052_comprasForm["fecha_fin"]);
            $fecha = $anio . "-" . $mes . "-" . $dia;
            $tb056_contrato_compras->setFechaFin($fecha);
            $tb056_contrato_compras->setCoRamo($tb052_comprasForm["co_ramo"]);
            $tb056_contrato_compras->setMonto($tb052_comprasForm["monto"]);

            /*  list($dia, $mes, $anio) = explode("/", $tb052_comprasForm["fecha_entrega"]);
        $fecha = $anio . "-" . $mes . "-" . $dia;
  
        $tb056_contrato_compras->setFechaEntrega($fecha);*/
            $tb056_contrato_compras->setTiempoGarantia($tb052_comprasForm["tiempo_garantia"]);
            $tb056_contrato_compras->setCoTpContrato($tb052_comprasForm["co_tp_contrato"]);
            $tb056_contrato_compras->setCoFuenteFinanciamiento($tb052_comprasForm["co_fuente_financiamiento"]);
            $tb056_contrato_compras->save($con);

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb052_comprasForm["co_solicitud"]));
            $ruta->setCoUsuario($this->getUser()->getAttribute('codigo'));
            $ruta->setInCargarDato(true)->save($con);

            $tb026_solicitud = Tb026SolicitudPeer::retrieveByPK($tb052_comprasForm["co_solicitud"]);
            $tb026_solicitud->setCoProveedor($tb008_proveedorForm["co_proveedor"])->save($con);

            $con->commit();
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Proceso realizado exitosamente'
            ));
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }
    }



    protected function getCoDetalleCotizacionIva($tx_serial_cotizacion)
    {

        $c = new Criteria();
        $c->addJoin(Tb206CotizacionPeer::CO_COTIZACION, Tb207DetalleCotizacionPeer::CO_COTIZACION);
        $c->add(Tb207DetalleCotizacionPeer::CO_PRODUCTO, 19336);
        $c->add(Tb206CotizacionPeer::TX_SERIAL_COTIZACION, $tx_serial_cotizacion);

        $stmt = Tb207DetalleCotizacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos["co_detalle_cotizacion"];
    }

    public function executeGuardarOrdenCompra(sfWebRequest $request)
    {

        $tb052_comprasForm = $this->getRequestParameter('tb052_compras');
        $co_compra = $this->getRequestParameter('co_compras');

        $con = Propel::getConnection();
        try {
            $con->beginTransaction();

            $compra = Tb052ComprasPeer::retrieveByPk($co_compra);
            $compra->setMontoSubTotal($tb052_comprasForm['monto_compra']);
            $compra->setMontoIva($tb052_comprasForm['monto_iva']);
            $compra->setMontoTotal($tb052_comprasForm['monto_total']);
            $compra->save($con);


            $wherec = new Criteria();
            $wherec->add(Tb053DetalleComprasPeer::CO_COMPRAS, $co_compra);
            $wherec->add(Tb053DetalleComprasPeer::CO_PRODUCTO, 19336);

            $updc = new Criteria();
            $updc->add(Tb053DetalleComprasPeer::PRECIO_UNITARIO, round($tb052_comprasForm['monto_compra'], 2));
            $updc->add(Tb053DetalleComprasPeer::MONTO, round($tb052_comprasForm['monto_iva'], 2));
            BasePeer::doUpdate($wherec, $updc, $con);



            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb052_comprasForm["co_solicitud"]));
            $ruta->setCoUsuario($this->getUser()->getAttribute('codigo'));
            $ruta->setInCargarDato(true)->save($con);
            $con->commit();

            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Proceso realizado exitosamente'
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
        $codigo = $this->getRequestParameter("co_compras");
        $con = Propel::getConnection();
        try {
            $con->beginTransaction();
            /*CAMPOS*/
            $tb052_compras = Tb052ComprasPeer::retrieveByPk($codigo);
            $tb052_compras->delete($con);
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
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD,  Criteria::JOIN);

        $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, array(1,2),Criteria::IN);
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

    public function executeEliminarMaterial(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("co_detalle_compras");
        $co_compras = $this->getRequestParameter("co_compras");
        $con = Propel::getConnection();
        try {
            $con->beginTransaction();
            /*CAMPOS*/
            $Tb053DetalleCompras = Tb053DetalleComprasPeer::retrieveByPk($codigo);
            Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $Tb053DetalleCompras->getCoPresupuesto(), 4, $Tb053DetalleCompras->getMonto(), '', $Tb053DetalleCompras->getCoDetalleCompras());
            

            $cc = new Criteria();
            $cc->add(Tb207DetalleCotizacionPeer::CO_DETALLE_COMPRA, $codigo);
            $stmtc = Tb207DetalleCotizacionPeer::doSelectStmt($cc);
            $resp = $stmtc->fetch(PDO::FETCH_ASSOC);

            Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $resp["co_presupuesto"], 1, $resp["monto"], $resp["co_detalle_cotizacion"], '');

            
            $Tb053DetalleCompras->delete($con);


            $c = new Criteria();
            $c->add(Tb053DetalleComprasPeer::CO_DETALLE_COMPRA_ENLACE, $codigo);
            $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);


            $Tb053DetalleComprasIva = Tb053DetalleComprasPeer::retrieveByPk($campos["co_detalle_compras"]);
            if($Tb053DetalleComprasIva != null){
                
                Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $Tb053DetalleComprasIva->getCoPresupuesto(), 4, $Tb053DetalleComprasIva->getMonto(), '', $Tb053DetalleComprasIva->getCoDetalleCompras());
                $Tb053DetalleComprasIva->delete($con);


                $civa = new Criteria();
                $civa->add(Tb207DetalleCotizacionPeer::CO_DETALLE_COTIZACION_ENLACE, $resp["co_detalle_cotizacion"]);
                $stmtiva = Tb207DetalleCotizacionPeer::doSelectStmt($civa);
                $respiva = $stmtiva->fetch(PDO::FETCH_ASSOC);

                Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $respiva["co_presupuesto"], 1, $respiva["monto"], $respiva["co_detalle_cotizacion"], '');

            }


            $wc = new Criteria();
            $wc->add(Tb207DetalleCotizacionPeer::CO_DETALLE_COMPRA, $codigo);
    
            $updc = new Criteria();
            $updc->add(Tb207DetalleCotizacionPeer::CO_DETALLE_COMPRA, NULL);
            BasePeer::doUpdate($wc, $updc, $con);

/*
            Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $productoForm["co_presupuesto"], 4, $tb053_detalle_compras->getMonto(), $productoForm["co_detalle_cotizacion"], $tb053_detalle_compras->getCoDetalleCompras());
            Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $productoForm["co_presupuesto"], 4, $tb053_detalle_compras->getMonto(), $productoForm["co_detalle_cotizacion"], $tb053_detalle_compras->getCoDetalleCompras());

*/

            $con->commit();
            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Registro Borrado con exito!'
            ));
           
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

    public function executeGuardarProducto(sfWebRequest $request)
    {


        $co_detalle_compras      = $this->getRequestParameter("co_detalle_compras");
        $co_detalle_requisicion  = $this->getRequestParameter("co_detalle_requisicion");
        $co_producto             = $this->getRequestParameter("co_producto");
        $cod_producto            = $this->getRequestParameter("cod_producto");
        $tx_producto             = $this->getRequestParameter("tx_producto");
        $nu_cantidad             = $this->getRequestParameter("nu_cantidad");
        $precio_unitario         = $this->getRequestParameter("precio_unitario");
        $detalle                 = $this->getRequestParameter("detalle");
        $monto                   = $this->getRequestParameter("monto");

        $con = Propel::getConnection();


        try {
            $con->beginTransaction();

            $Tb053DetalleCompras = Tb053DetalleComprasPeer::retrieveByPk($co_detalle_compras);
            $Tb053DetalleCompras->setMonto($monto);
            $Tb053DetalleCompras->setNuCantidad($nu_cantidad);
            $Tb053DetalleCompras->setPrecioUnitario($precio_unitario);
            $Tb053DetalleCompras->save($con);

            $con->commit();

            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Proceso realizado exitosamente'
            ));

            $this->setTemplate('guardar');
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }
    }

    public function executeEditarProducto(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("codigo");
        if ($codigo != '' || $codigo != null) {

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_REQUISICION);
            $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
            $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
            $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
            $c->addSelectColumn(Tb053DetalleComprasPeer::NU_CANTIDAD);
            $c->addSelectColumn(Tb053DetalleComprasPeer::PRECIO_UNITARIO);
            $c->addSelectColumn(Tb053DetalleComprasPeer::DETALLE);
            $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
            $c->addSelectColumn(Tb053DetalleComprasPeer::IN_EXENTO);
            $c->addJoin(Tb053DetalleComprasPeer::CO_PRODUCTO, Tb048ProductoPeer::CO_PRODUCTO);
            $c->add(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS, $codigo);

            $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);


            $this->data = json_encode(array(
                "co_detalle_compras"      => $campos["co_detalle_compras"],
                "co_detalle_requisicion"  => $campos["co_detalle_requisicion"],
                "co_producto"             => $campos["co_producto"],
                "cod_producto"            => $campos["cod_producto"],
                "tx_producto"             => $campos["tx_producto"],
                "nu_cantidad"             => $campos["nu_cantidad"],
                "precio_unitario"         => $campos["precio_unitario"],
                "detalle"                 => $campos["detalle"],
                "monto"                   => $campos["monto"],
                "in_exento"               => $campos["in_exento"]
            ));
        }
    }

    public function executeStorefkcoproducto(sfWebRequest $request)
    {

        $limit      =   $this->getRequestParameter("limit", 8);
        $start      =   $this->getRequestParameter("start", 0);
        $codigo     =   $this->getRequestParameter("codigo");
        $producto   =   $this->getRequestParameter("producto");
        $co_requisicion  = $this->getRequestParameter("co_requisicion");
        $json_producto  = $this->getRequestParameter("lista_producto");

        if ($co_requisicion != '') {
            $listaProducto  = json_decode($json_producto, true);
            $array_producto = array();
            $i = 0;
            

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb051DetalleRequisionProductoPeer::CO_DETALLE_REQUISICION);
            $c->addSelectColumn(Tb051DetalleRequisionProductoPeer::CO_PRODUCTO);
            $c->addSelectColumn(Tb051DetalleRequisionProductoPeer::TX_OBSERVACION);
            $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
            $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
            $c->addSelectColumn(Tb048ProductoPeer::CO_CLASE);
            $c->addSelectColumn(Tb051DetalleRequisionProductoPeer::NU_CANTIDAD);
            $c->addSelectColumn(Tb051DetalleRequisionProductoPeer::CO_UNIDAD_PRODUCTO);
            $c->addSelectColumn(Tb057UnidadProductoPeer::TX_UNIDAD_PRODUCTO);
            $c->addJoin(Tb051DetalleRequisionProductoPeer::CO_PRODUCTO, Tb048ProductoPeer::CO_PRODUCTO);
            $c->addJoin(Tb051DetalleRequisionProductoPeer::CO_UNIDAD_PRODUCTO, Tb057UnidadProductoPeer::CO_UNIDAD_PRODUCTO);
           // $c->add(Tb051DetalleRequisionProductoPeer::CO_DETALLE_REQUISICION, $array_producto,  Criteria::NOT_IN);
            $c->add(Tb048ProductoPeer::IN_VER, true);
            $c->add(Tb051DetalleRequisionProductoPeer::CO_REQUISICION, $co_requisicion);


            $cantidadTotal = Tb051DetalleRequisionProductoPeer::doCount($c);
            $c->setLimit($limit)->setOffset($start);
            $c->addAscendingOrderByColumn(Tb048ProductoPeer::TX_PRODUCTO);



            $stmt = Tb051DetalleRequisionProductoPeer::doSelectStmt($c);
            $registros = array();
            while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

               // $reg["tx_producto"] = $reg["tx_producto"];

                $cant = $reg["nu_cantidad"];                
                foreach ($listaProducto  as $productoForm) {
                    if($reg["co_detalle_requisicion"] == $productoForm["co_detalle_requisicion"]){
                        $cant-= $productoForm["nu_cantidad"];
                    }
                }

                if($cant>0){
                    $reg["nu_cantidad"] = $cant;
                    $registros[] = $reg;
                }
            }

            $this->data = json_encode(array(
                "success"   =>  true,
                "total"     =>  $cantidadTotal,
                "data"      =>  $registros
            ));
        } else {

            $listaProducto  = json_decode($json_producto, true);
            $array_producto = array();
            $i = 0;
            foreach ($listaProducto  as $productoForm) {
                $array_producto[$i] = $productoForm["co_producto"];
                $i++;
            }

            $c = new Criteria();
            //        $c->add(Tb048ProductoPeer::CO_PRODUCTO,$array_producto,  Criteria::NOT_IN);

            if ($codigo != '') {
                $c->add(Tb048ProductoPeer::COD_PRODUCTO, '%' . $codigo . '%', Criteria::ILIKE);
            }

            if ($producto) {
                $multiple_producto = preg_split('/\s+/', $producto, -1, PREG_SPLIT_NO_EMPTY);


                foreach ($multiple_producto as $value) {
                    $c->addOr(Tb048ProductoPeer::TX_PRODUCTO, '%' . $value . '%', Criteria::ILIKE);
                }
            }
            $c->add(Tb048ProductoPeer::IN_VER, true);
            $cantidadTotal = Tb048ProductoPeer::doCount($c);
            $c->setLimit($limit)->setOffset($start);
            $c->addAscendingOrderByColumn(Tb048ProductoPeer::TX_PRODUCTO);



            $stmt = Tb048ProductoPeer::doSelectStmt($c);
            $registros = array();
            while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $reg["tx_producto"] = $reg["tx_producto"];

                $registros[] = $reg;
            }

            $this->data = json_encode(array(
                "success"   =>  true,
                "total"     =>  $cantidadTotal,
                "data"      =>  $registros
            ));
        }

        $this->setTemplate('store');
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

    public function executeStorelistamateriales(sfWebRequest $request)
    {

        $co_compras   =   $this->getRequestParameter("co_compras");
        $co_cotizacion   =   $this->getRequestParameter("co_cotizacion");
        $limit      =   $this->getRequestParameter("limit", 8);
        $start      =   $this->getRequestParameter("start", 0);

        if (!empty($co_cotizacion)) {
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb207DetalleCotizacionPeer::CO_DETALLE_COTIZACION);
            $c->addSelectColumn(Tb207DetalleCotizacionPeer::CO_DETALLE_REQUISICION);
            $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
            $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
            $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
            $c->addSelectColumn(Tb207DetalleCotizacionPeer::CO_PRESUPUESTO);
            $c->addSelectColumn(Tb207DetalleCotizacionPeer::NU_CANTIDAD);
            $c->addSelectColumn(Tb207DetalleCotizacionPeer::PRECIO_UNITARIO);
            $c->addSelectColumn(Tb207DetalleCotizacionPeer::DETALLE);
            $c->addSelectColumn(Tb207DetalleCotizacionPeer::MONTO);
            $c->addSelectColumn(Tb207DetalleCotizacionPeer::IN_EXENTO);
            $c->addSelectColumn(Tb207DetalleCotizacionPeer::CO_IVA_PRODUCTO);
            $c->addSelectColumn(Tb207DetalleCotizacionPeer::MO_IVA_PRODUCTO);

            $c->addJoin(Tb207DetalleCotizacionPeer::CO_PRODUCTO, Tb048ProductoPeer::CO_PRODUCTO);
            $c->add(Tb207DetalleCotizacionPeer::CO_COTIZACION, $co_cotizacion);
            $c->add(Tb207DetalleCotizacionPeer::CO_DETALLE_COMPRA, null,Criteria::ISNULL);
            $c->add(Tb207DetalleCotizacionPeer::CO_PRODUCTO, 19336,  Criteria::NOT_EQUAL); //Excluye el IVA

            $cantidadTotal = Tb207DetalleCotizacionPeer::doCount($c);
            //$c->setLimit($limit)->setOffset($start);
            $c->addAscendingOrderByColumn(Tb048ProductoPeer::TX_PRODUCTO);

            $stmt = Tb207DetalleCotizacionPeer::doSelectStmt($c);
        } else {

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_REQUISICION);
            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
            $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
            $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
            $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
            $c->addSelectColumn(Tb053DetalleComprasPeer::NU_CANTIDAD);
            $c->addSelectColumn(Tb053DetalleComprasPeer::PRECIO_UNITARIO);
            $c->addSelectColumn(Tb053DetalleComprasPeer::DETALLE);
            $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
            $c->addSelectColumn(Tb053DetalleComprasPeer::IN_EXENTO);
            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_IVA_PRODUCTO);
            $c->addSelectColumn(Tb053DetalleComprasPeer::MO_IVA_PRODUCTO);
            $c->addSelectColumn(Tb207DetalleCotizacionPeer::CO_DETALLE_COTIZACION);
            $c->addJoin(Tb053DetalleComprasPeer::CO_PRODUCTO, Tb048ProductoPeer::CO_PRODUCTO);
            $c->addJoin(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS, Tb207DetalleCotizacionPeer::CO_DETALLE_COMPRA, Criteria::LEFT_JOIN);
            $c->add(Tb053DetalleComprasPeer::CO_COMPRAS, $co_compras);
            $c->add(Tb053DetalleComprasPeer::CO_PRODUCTO, 19336,  Criteria::NOT_EQUAL); //Excluye el IVA

            $cantidadTotal = Tb053DetalleComprasPeer::doCount($c);
            //$c->setLimit($limit)->setOffset($start);
            $c->addAscendingOrderByColumn(Tb048ProductoPeer::TX_PRODUCTO);

            $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);
        }

        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

            /* if (isset($reg['co_detalle_cotizacion'])) {
                $reg['co_detalle_compras'] = '';
            }*/

            $reg["monto_total"]         = $reg["monto"] + $reg["mo_iva_producto"];
            $reg["nu_iva_producto"]     = $reg["co_iva_producto"];
            $reg["in_modificado"]       = false;


            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));

        $this->setTemplate('store');
    }

    public function executeStorefkcodocumento(sfWebRequest $request)
    {
        $c = new Criteria();
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

    public function executeStorefkcoramo(sfWebRequest $request)
    {

        $co_proveedor = $this->getRequestParameter('co_proveedor');
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb038RamoPeer::CO_RAMO);
        $c->addSelectColumn(Tb038RamoPeer::TX_RAMO);
        $c->addJoin(Tb038RamoPeer::CO_RAMO, Tb040ProveedorRamoPeer::CO_RAMO);
        $c->add(Tb040ProveedorRamoPeer::CO_PROVEEDOR, $co_proveedor);
        $stmt = Tb040ProveedorRamoPeer::doSelectStmt($c);
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

    public function executeStorefkcoivafactura(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb043IvaFacturaPeer::NU_VALOR);
        $stmt = Tb043IvaFacturaPeer::doSelectStmt($c);
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

    public function executeStorefkcoente(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb047EntePeer::doSelectStmt($c);
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

        $co_ejecutor = $this->getUser()->getAttribute('co_ejecutor');

        $c = new Criteria();
        $c->add(Tb082EjecutorPeer::IN_ACTIVO, TRUE);

        if ($co_ejecutor != '') {
            $c->add(Tb082EjecutorPeer::ID, $co_ejecutor);
        }


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

    public function executeStorefkcopartidaViatico(sfWebRequest $request)
    {

        $c = new Criteria();
        $c->addSelectColumn(Tb091PartidaPeer::ID);
        $c->addSelectColumn(Tb091PartidaPeer::NU_PARTIDA);
        $c->addSelectColumn(Tb091PartidaPeer::DE_PARTIDA);
        $c->addJoin(Tb094PartidaProductoPeer::NU_PARTIDA,  Tb091PartidaPeer::NU_PARTIDA);
        $c->addJoin(Tb094PartidaProductoPeer::ID_TB092_CLASE_PRODUCTO,  Tb092ClaseProductoPeer::ID);
        $c->add(Tb092ClaseProductoPeer::DE_CLASE_PRODUCTO, '%VIATICO%',  Criteria::LIKE);
        $stmt = Tb091PartidaPeer::doSelectStmt($c);

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

    public function executeStorefkcopartidaAyuda(sfWebRequest $request)
    {

        $c = new Criteria();
        $c->addSelectColumn(Tb091PartidaPeer::ID);
        $c->addSelectColumn(Tb091PartidaPeer::NU_PARTIDA);
        $c->addSelectColumn(Tb091PartidaPeer::DE_PARTIDA);
        $c->addJoin(Tb094PartidaProductoPeer::NU_PARTIDA,  Tb091PartidaPeer::NU_PARTIDA);
        $c->addJoin(Tb094PartidaProductoPeer::ID_TB092_CLASE_PRODUCTO,  Tb092ClaseProductoPeer::ID);
        $c->add(Tb092ClaseProductoPeer::ID, 841016);   //FINANCIAMIENTO DE AYUDAS   
        $stmt = Tb091PartidaPeer::doSelectStmt($c);

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

    public function executeStorefkcopartida(sfWebRequest $request)
    {

        $co_clase = $this->getRequestParameter('co_clase');

        $c = new Criteria();
        $c->addSelectColumn(Tb091PartidaPeer::ID);
        $c->addSelectColumn(Tb091PartidaPeer::NU_PARTIDA);
        $c->addSelectColumn(Tb091PartidaPeer::DE_PARTIDA);
        $c->addJoin(Tb094PartidaProductoPeer::NU_PARTIDA,  Tb091PartidaPeer::NU_PARTIDA);
        $c->add(Tb094PartidaProductoPeer::ID_TB092_CLASE_PRODUCTO, $co_clase);

        $cantidad = 0;

        $stmt = Tb091PartidaPeer::doSelectStmt($c);
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

    public function executeStorefkcoproyecto(sfWebRequest $request)
    {

        $co_ejecutor = $this->getRequestParameter('co_ejecutor');
        $c = new Criteria();
        $c->add(Tb083ProyectoAcPeer::IN_ACTIVO, TRUE);
        $c->add(Tb083ProyectoAcPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
        $c->add(Tb083ProyectoAcPeer::ID_TB082_EJECUTOR, $co_ejecutor);
        $stmt = Tb083ProyectoAcPeer::doSelectStmt($c);
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

    public function executeStorefkcoaccion(sfWebRequest $request)
    {

        $co_proyecto = $this->getRequestParameter('co_proyecto');
        $c = new Criteria();
        $c->add(Tb084AccionEspecificaPeer::IN_ACTIVO, TRUE);
        $c->add(Tb084AccionEspecificaPeer::ID_TB083_PROYECTO_AC, $co_proyecto);
        $stmt = Tb084AccionEspecificaPeer::doSelectStmt($c);
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

    public function executeStorefkcotpcontrato(sfWebRequest $request)
    {

        $c = new Criteria();
        $stmt = Tb058TpContratoPeer::doSelectStmt($c);
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

    public function executeStorefkcofuentefinanciamiento(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb073FuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO);
        $stmt = Tb073FuenteFinanciamientoPeer::doSelectStmt($c);
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
