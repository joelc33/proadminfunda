<?php

/**
 * ServicioBasicoFactura actions.
 *
 * @package    gobel
 * @subpackage ServicioBasicoFactura
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ServicioBasicoFacturaActions extends sfActions
{

    public function executeIndex(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "co_rol"            => $this->getUser()->getAttribute('rol'),
            "co_usuario"        => $this->getUser()->getAttribute('codigo'),
            "in_activo"         => $this->getUser()->getAttribute('in_activo'),
            "co_tipo_solicitud" => 26

        ));

        $this->getRequest()->setAttribute('in_activo', $this->getUser()->getAttribute('in_activo'));
    }


    public function executeAgregarFactura(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "co_documento"      => $this->getRequestParameter('co_documento'),
            "co_proveedor"      => $this->getRequestParameter('co_proveedor'),
            "co_ramo"           => $this->getRequestParameter('co_ramo'),
            "co_solicitud"      => $this->getRequestParameter('co_solicitud'),
            "co_iva_factura"    => $this->getRequestParameter('co_iva_factura'),
            "co_iva_retencion"  => $this->getRequestParameter('co_iva_retencion'),
            "co_tipo_solicitud" => $this->getRequestParameter('co_tipo_solicitud'),
            "mo_exento"         => 0
        ));
    }

    public function executeAgregarFacturaDV(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "co_documento"      => $this->getRequestParameter('co_documento'),
            "co_proveedor"      => $this->getRequestParameter('co_proveedor'),
            "co_ramo"           => $this->getRequestParameter('co_ramo'),
            "co_solicitud"      => $this->getRequestParameter('co_solicitud'),
            "co_iva_factura"    => $this->getRequestParameter('co_iva_factura'),
            "co_iva_retencion"  => $this->getRequestParameter('co_iva_retencion'),
            "co_tipo_solicitud" => $this->getRequestParameter('co_tipo_solicitud'),
            "mo_exento"         => 0
        ));
    }

    public function executeEditarFacturaDV(sfWebRequest $request)
    {

        $co_factura  = $this->getRequestParameter('co_factura');

        $c = new Criteria();
        $c->add(Tb045FacturaPeer::CO_FACTURA, $co_factura);
        $stmt = Tb045FacturaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
            "co_factura"            => $campos["co_factura"],
            "nu_factura"            => $campos["nu_factura"],
            "fe_emision"            => $campos["fe_emision"],
            "nu_base_imponible"     => $campos["nu_base_imponible"],
            "co_iva_factura"        => $campos["co_iva_factura"],
            "nu_iva_factura"        => $campos["nu_iva_factura"],
            "nu_total"              => $campos["nu_total"],
            "co_iva_retencion"      => $campos["co_iva_retencion"],
            "nu_iva_retencion"      => $campos["nu_iva_retencion"],
            "nu_total_retencion"    => $campos["nu_total_retencion"],
            "total_pagar"           => $campos["total_pagar"],
            "tx_concepto"           => $campos["tx_concepto"],
            "co_compra"             => $campos["co_compra"],
            "co_proveedor"          => $campos["co_proveedor"],
            "co_ramo"               => $campos["co_ramo"],
            "co_iva"                => $campos["co_iva"],
            "co_odp"                => $campos["co_odp"],
            "nu_control"            => $campos["nu_control"],
            "co_documento"          => $campos4["co_documento"],
            "tx_rif"                => $campos4["tx_rif"],
            "tx_razon_social"       => $campos4["tx_razon_social"],
            "tx_direccion"          => $campos4["tx_direccion"],
            "co_iva_retencion"      => $campos4["co_iva_retencion"],
            "id_tb048_producto"     => $campos["id_tb048_producto"],
            "co_detalle_compras"    => $campos5["co_detalle_compras"],
            "co_pago_servicio"      => $campos135["co_pago_servicio"],
            "co_tipo_solicitud"     => $camposs["co_tipo_solicitud"],
            "tx_observacion"        => $campos6["tx_observacion"]
        ));
    }

    public function executeNuevo(sfWebRequest $request)
    {
        $this->forward('ServicioBasicoFactura', 'editar');
    }

    public function executeFiltro(sfWebRequest $request) {}

    public function executeEditar(sfWebRequest $request)
    {
        //$codigo = $this->getRequestParameter("codigo");
        $codigo = $this->getRequestParameter("co_solicitud");
        if ($codigo != '' || $codigo != null) {
            $c = new Criteria();
            //$c->add(Tb045FacturaPeer::CO_FACTURA,$codigo);
            $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);
            $stmt = Tb052ComprasPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);


            $c135 = new Criteria();
            $c135->add(Tb135PagoServicioPeer::CO_SOLICITUD, $campos["co_solicitud"]);
            $stmt135 = Tb135PagoServicioPeer::doSelectStmt($c135);
            $campos135 = $stmt135->fetch(PDO::FETCH_ASSOC);


            $c4 = new Criteria();
            $c4->add(Tb008ProveedorPeer::CO_PROVEEDOR, $campos["co_proveedor"]);
            $stmt4 = Tb008ProveedorPeer::doSelectStmt($c4);
            $campos4 = $stmt4->fetch(PDO::FETCH_ASSOC);



            $c5 = new Criteria();
            $c5->add(Tb053DetalleComprasPeer::CO_COMPRAS, $campos["co_compra"]);
            $stmt5 = Tb053DetalleComprasPeer::doSelectStmt($c5);
            $campos5 = $stmt5->fetch(PDO::FETCH_ASSOC);




            $cs = new Criteria();
            $cs->add(Tb026SolicitudPeer::CO_SOLICITUD, $codigo);
            $stmts = Tb026SolicitudPeer::doSelectStmt($cs);
            $camposs = $stmts->fetch(PDO::FETCH_ASSOC);


            $this->data = json_encode(array(
                "co_factura"            => $campos["co_factura"],
                "nu_factura"            => $campos["nu_factura"],
                "fe_emision"            => $campos["fe_emision"],
                "nu_base_imponible"     => $campos["nu_base_imponible"],
                "co_iva_factura"        => $campos["co_iva_factura"],
                "nu_iva_factura"        => $campos["nu_iva_factura"],
                "nu_total"              => $campos["nu_total"],
                "co_iva_retencion"      => $campos["co_iva_retencion"],
                "nu_iva_retencion"      => $campos["nu_iva_retencion"],
                "nu_total_retencion"    => $campos["nu_total_retencion"],
                "total_pagar"           => $campos["total_pagar"],
                "tx_concepto"           => $campos["tx_concepto"],
                "co_compra"             => $campos["co_compras"],
                "co_solicitud"          => $this->getRequestParameter("co_solicitud"),
                "co_proveedor"          => $campos["co_proveedor"],
                "co_ramo"               => $campos["co_ramo"],
                "co_iva"                => $campos["co_iva"],
                "co_odp"                => $campos["co_odp"],
                "nu_control"            => $campos["nu_control"],
                "co_documento"          => $campos4["co_documento"],
                "tx_rif"                => $campos4["tx_rif"],
                "tx_razon_social"       => $campos4["tx_razon_social"],
                "tx_direccion"          => $campos4["tx_direccion"],
                "co_iva_retencion"      => $campos4["co_iva_retencion"],
                "id_tb048_producto"     => $campos["id_tb048_producto"],
                "co_detalle_compras"    => $campos5["co_detalle_compras"],
                "co_pago_servicio"      => $campos135["co_pago_servicio"],
                "co_tipo_solicitud"     => $camposs["co_tipo_solicitud"],
                "tx_observacion"        => $campos["tx_observacion"]
            ));
        } else {
            $this->data = json_encode(array(
                "co_factura"            => "",
                "nu_factura"            => "",
                "fe_emision"            => "",
                "nu_base_imponible"     => "",
                "co_iva_factura"        => "",
                "nu_iva_factura"        => "",
                "nu_total"              => "",
                "co_iva_retencion"      => "",
                "nu_iva_retencion"      => "",
                "nu_total_retencion"    => "",
                "total_pagar"           => "",
                "tx_concepto"           => "",
                "co_compra"             => "",
                "co_solicitud"          => $this->getRequestParameter('co_solicitud'),
                "co_proveedor"          => "",
                "co_ramo"               => "",
                "co_iva"                => "",
                "co_odp"                => "",
                "nu_control"            => "",
                "id_tb048_producto"     => "",
                "co_detalle_compras"    => "",
                "co_pago_servicio"      => "",
                "co_tipo_solicitud"     => $camposs["co_tipo_solicitud"],
                "tx_observacion"        => ""
            ));
        }
    }


    public function executeDocumentosVarios(sfWebRequest $request)
    {
        //$codigo = $this->getRequestParameter("codigo");
        $codigo = $this->getRequestParameter("co_solicitud");
        if ($codigo != '' || $codigo != null) {
            $c = new Criteria();
            //$c->add(Tb045FacturaPeer::CO_FACTURA,$codigo);
            $c->add(Tb045FacturaPeer::CO_SOLICITUD, $codigo);

            $stmt = Tb045FacturaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);


            $c135 = new Criteria();
            $c135->add(Tb135PagoServicioPeer::CO_SOLICITUD, $campos["co_solicitud"]);
            $stmt135 = Tb135PagoServicioPeer::doSelectStmt($c135);
            $campos135 = $stmt135->fetch(PDO::FETCH_ASSOC);


            if ($campos["co_factura"] != '') {
                $c4 = new Criteria();
                $c4->add(Tb008ProveedorPeer::CO_PROVEEDOR, $campos["co_proveedor"]);
                $stmt4 = Tb008ProveedorPeer::doSelectStmt($c4);
                $campos4 = $stmt4->fetch(PDO::FETCH_ASSOC);
            }

            if ($campos["co_compra"] != '') {
                $c5 = new Criteria();
                $c5->add(Tb053DetalleComprasPeer::CO_COMPRAS, $campos["co_compra"]);
                $stmt5 = Tb053DetalleComprasPeer::doSelectStmt($c5);
                $campos5 = $stmt5->fetch(PDO::FETCH_ASSOC);
            }

            $cs = new Criteria();
            $cs->add(Tb026SolicitudPeer::CO_SOLICITUD, $codigo);
            $stmts = Tb026SolicitudPeer::doSelectStmt($cs);
            $camposs = $stmts->fetch(PDO::FETCH_ASSOC);

            $cc = new Criteria();
            $cc->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);
            $stmtc = Tb052ComprasPeer::doSelectStmt($cc);
            $camposc = $stmtc->fetch(PDO::FETCH_ASSOC);


            $this->data = json_encode(array(
                "co_factura"            => $campos["co_factura"],
                "nu_factura"            => $campos["nu_factura"],
                "fe_emision"            => $campos["fe_emision"],
                "nu_base_imponible"     => $campos["nu_base_imponible"],
                "co_iva_factura"        => $campos["co_iva_factura"],
                "nu_iva_factura"        => $campos["nu_iva_factura"],
                "nu_total"              => $campos["nu_total"],
                "co_iva_retencion"      => $campos["co_iva_retencion"],
                "nu_iva_retencion"      => $campos["nu_iva_retencion"],
                "nu_total_retencion"    => $campos["nu_total_retencion"],
                "total_pagar"           => $campos["total_pagar"],
                "tx_concepto"           => $camposc["tx_observacion"],
                "co_compra"             => $campos["co_compra"],
                "co_solicitud"          => $this->getRequestParameter("co_solicitud"),
                "co_proveedor"          => $campos["co_proveedor"],
                "co_ramo"               => $campos["co_ramo"],
                "co_iva"                => $campos["co_iva"],
                "co_odp"                => $campos["co_odp"],
                "nu_control"            => $campos["nu_control"],
                "co_documento"          => $campos4["co_documento"],
                "tx_rif"                => $campos4["tx_rif"],
                "tx_razon_social"       => $campos4["tx_razon_social"],
                "tx_direccion"          => $campos4["tx_direccion"],
                "co_iva_retencion"      => $campos4["co_iva_retencion"],
                "id_tb048_producto"     => $campos["id_tb048_producto"],
                "co_detalle_compras"    => $campos5["co_detalle_compras"],
                "co_pago_servicio"      => $campos135["co_pago_servicio"],
                "co_tipo_solicitud"     => $camposs["co_tipo_solicitud"]
            ));
        } else {
            $this->data = json_encode(array(
                "co_factura"            => "",
                "nu_factura"            => "",
                "fe_emision"            => "",
                "nu_base_imponible"     => "",
                "co_iva_factura"        => "",
                "nu_iva_factura"        => "",
                "nu_total"              => "",
                "co_iva_retencion"      => "",
                "nu_iva_retencion"      => "",
                "nu_total_retencion"    => "",
                "total_pagar"           => "",
                "tx_concepto"           => "",
                "co_compra"             => "",
                "co_solicitud"          => $this->getRequestParameter('co_solicitud'),
                "co_proveedor"          => "",
                "co_ramo"               => "",
                "co_iva"                => "",
                "co_odp"                => "",
                "nu_control"            => "",
                "id_tb048_producto"     => "",
                "co_detalle_compras"    => "",
                "co_pago_servicio"      => "",
                "co_tipo_solicitud"     => $camposs["co_tipo_solicitud"]
            ));
        }
    }



    public function executeGuardarFacturaServicio(sfWebRequest $request)
    {

        $con = Propel::getConnection();

        try {
            $con->beginTransaction();

            $v["nu_factura"]                = $this->getRequestParameter("nu_factura");
            $v["nu_control"]                = $this->getRequestParameter("nu_control");
            $v["fe_emision"]                = $this->getRequestParameter("fe_emision");
            $v["tx_producto"]               = $this->getRequestParameter("tx_producto");
            $v["co_producto"]               = $this->getRequestParameter("co_producto");
            $v["nu_base_imponible"]         = $this->getRequestParameter("nu_base_imponible");
            $v["tx_concepto"]               = $this->getRequestParameter("tx_concepto");
            $v["co_compra"]                 = $this->getRequestParameter("co_compra");
            $v["co_iva_factura"]            = $this->getRequestParameter("co_iva_factura");
            $v["nu_iva_factura"]            = $this->getRequestParameter("nu_iva_factura");
            $v["nu_total"]                  = $this->getRequestParameter("nu_total");
            $v["co_iva_retencion"]          = $this->getRequestParameter("co_iva_retencion");
            $v["nu_iva_retencion"]          = $this->getRequestParameter("nu_iva_retencion");
            $v["nu_total_retencion"]        = $this->getRequestParameter("nu_total_retencion");
            $v["nu_total_pagar"]            = $this->getRequestParameter("total_pagar");
            $v["nu_total_pagar"]            = $this->getRequestParameter("nu_total_pagar");
            $v["json_detalle_retencion"]    = $this->getRequestParameter("json_detalle_retencion");


            $cf = new Criteria();
            $cf->add(Tb052ComprasPeer::CO_COMPRAS, $v["co_compra"]);
            $stmtf = Tb052ComprasPeer::doSelectStmt($cf);
            $tb045_facturaForm = $stmtf->fetch(PDO::FETCH_ASSOC);

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
            $tb045_factura->setCoCompra($v["co_compra"]);


            $tb045_factura->setCoIvaFactura($v["co_iva_factura"]);
            $tb045_factura->setNuIvaFactura($v["nu_iva_factura"]);
            $tb045_factura->setCoIvaRetencion($v["co_iva_retencion"]);
            $tb045_factura->setNuIvaRetencion($v["nu_iva_retencion"]);
            $tb045_factura->setNuTotalRetencion($v["nu_total_retencion"]);
            $tb045_factura->setTxConcepto($v["tx_concepto"]);
            $tb045_factura->setFeRegistro($fe_cierre);
            //   $tb045_factura->setNuExento($v["nu_exento"]);
            //   $tb045_factura->setSubTotalCs($v["sub_total_cs"]);
            //   $tb045_factura->setNuIvaCs($v["co_iva_cs"]);


            $tb045_factura->save($con);


            $tb053_detalle_compras = new Tb053DetalleCompras();
            $tb053_detalle_compras->setCoCompras($v["co_compra"]);
            $tb053_detalle_compras->setNuCantidad(1);
            $tb053_detalle_compras->setCoProducto($v["co_producto"]);
            $tb053_detalle_compras->setDetalle($v["tx_concepto"]);
            $tb053_detalle_compras->setPrecioUnitario($v["total_pagar"]);
            //$tb053_detalle_compras->setMonto($v["total_pagar"]);
            $tb053_detalle_compras->setMonto($v["nu_base_imponible"] + $v["nu_exento"]);
            $tb053_detalle_compras->setInCalcularIva(true);
            $tb053_detalle_compras->setCoFactura($tb045_factura->getCoFactura());
            $tb053_detalle_compras->save($con);


            $tb209_presupuesto_detalle_compra = new Tb209PresupuestoDetalleCompra();
            $tb209_presupuesto_detalle_compra->setMonto($tb053_detalle_compras->getMonto());
            $tb209_presupuesto_detalle_compra->setCoDetalleCompra($tb053_detalle_compras->getCoDetalleCompras());
            $tb209_presupuesto_detalle_compra->setCoUsuario($this->getUser()->getAttribute("codigo"));
            $tb209_presupuesto_detalle_compra->save($con);


          //  $total_pagar = $total_pagar + $v["total_pagar"];

            if ($v["nu_iva_retencion"] > 0) {
                $tb046_factura_retencion = new Tb046FacturaRetencion();
                $tb046_factura_retencion->setCoFactura($tb045_factura->getCoFactura());
                $tb046_factura_retencion->setCoTipoRetencion(92);
                $tb046_factura_retencion->setMoRetencion($v["nu_iva_retencion"]);
                $tb046_factura_retencion->setPoRetencion($v["co_iva_retencion"]);
                $tb046_factura_retencion->setCoSolicitud($tb045_facturaForm["co_solicitud"]);
                $tb046_factura_retencion->save($con);
            }

            if ($v["mo_iva_cs"] > 0) {
                $tb046_factura_retencion = new Tb046FacturaRetencion();
                $tb046_factura_retencion->setCoFactura($tb045_factura->getCoFactura());
                $tb046_factura_retencion->setCoTipoRetencion(171);
                $tb046_factura_retencion->setMoRetencion($v["mo_iva_cs"]);
                $tb046_factura_retencion->setPoRetencion($v["co_iva_cs"]);
                $tb046_factura_retencion->setCoSolicitud($tb045_facturaForm["co_solicitud"]);
                $tb046_factura_retencion->save($con);
            }

            $listaDetalleFactura  = json_decode($v["json_detalle_retencion"], true);

            foreach ($listaDetalleFactura  as $vp) {
                $tb046_factura_retencion_dos = new Tb046FacturaRetencion();
                $tb046_factura_retencion_dos->setCoFactura($tb045_factura->getCoFactura());
                $tb046_factura_retencion_dos->setCoTipoRetencion($vp["co_tipo_retencion"]);
                $tb046_factura_retencion_dos->setMoRetencion($vp["nu_valor"]);
                $tb046_factura_retencion_dos->setPoRetencion($vp["po_deduccion"]);
                $tb046_factura_retencion_dos->setCoSolicitud($tb045_facturaForm["co_solicitud"]);
                $tb046_factura_retencion_dos->save($con);
            }



            $monto_iva = $v["nu_iva_factura"] + $v["mo_iva_cs"];

            /*$wherec = new Criteria();
        $wherec->add(Tb053DetalleComprasPeer::CO_COMPRAS, $tb052_compras->getCoCompras());
        $wherec->add(Tb053DetalleComprasPeer::CO_PRODUCTO, 19336);
        BasePeer::doDelete($wherec, $con);*/

            if ($monto_iva > 0) {
                $tb053_detalle_compras = new Tb053DetalleCompras();
                $tb053_detalle_compras->setCoCompras($v["co_compra"]);
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

                $tb209_presupuesto_detalle_compra = new Tb209PresupuestoDetalleCompra();
                $tb209_presupuesto_detalle_compra->setMonto($tb053_detalle_compras->getMonto());
                $tb209_presupuesto_detalle_compra->setCoDetalleCompra($tb053_detalle_compras->getCoDetalleCompras());
                $tb209_presupuesto_detalle_compra->setCoUsuario($this->getUser()->getAttribute("codigo"));
                $tb209_presupuesto_detalle_compra->save($con);
            }


            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_TOTAL . ') as total');
            $c->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_IVA_RETENCION . ') as total_iva_retencion');
            $c->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_TOTAL_RETENCION . ') as total_retencion');
            $c->add(Tb045FacturaPeer::IN_ANULAR, NULL, Criteria::ISNULL);
            $c->add(Tb045FacturaPeer::CO_SOLICITUD, $tb045_facturaForm["co_solicitud"]);
            // echo $c->toString(); exit();
            $stmt = Tb045FacturaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $nu_monto =  $campos["total"];
            $retencion =  $campos["total_retencion"];
            $total_retencion = $retencion;


            $nu_monto_total = $nu_monto - $total_retencion;

            $compra = Tb052ComprasPeer::retrieveByPK($v["co_compra"]);
            $compra->setMontoTotal($nu_monto_total)->save($con);

            $con->commit();

            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Factura cargada exitosamente!'
            ));
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }

        $this->setTemplate('guardar');
    }


    public function executeVerificarFactura(sfWebRequest $request)
    {
        $cf = new Criteria();
        $cf->add(Tb045FacturaPeer::CO_SOLICITUD, $this->getRequestParameter('co_solicitud'));
        $cantidadFactura = Tb045FacturaPeer::doCount($cf);

        if ($cantidadFactura == 0) {
            $this->data = json_encode(array(
                "success" => false,
                "msg" => 'Para enviar el pago de servicio debe tener por lo menos una factura cargada'
            ));
        } else {
           /* $cc = new Criteria();
            $cc->addJoin(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
            $cc->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
            $cc->add(Tb052ComprasPeer::CO_SOLICITUD, $this->getRequestParameter('co_solicitud'));
            $cantidadPartida = Tb087PresupuestoMovimientoPeer::doCount($cc);

            if ($cantidadPartida == 0) {
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'Para enviar el pago de servicio debe asignar las partidas'
                ));
            } else {*/
                $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Ok'
                ));
            //}
        }

        $this->setTemplate('guardar');
    }

    public function executeGuardar(sfWebRequest $request)
    {

        $codigo             = $this->getRequestParameter("co_factura");
        $co_pago_servicio   = $this->getRequestParameter("co_pago_servicio");
        $co_detalle_compras = $this->getRequestParameter("co_detalle_compras");
        $json_factura       = $this->getRequestParameter("json_factura");

        $listaFactura  = json_decode($json_factura, true);

        $con = Propel::getConnection();

        try {
            $con->beginTransaction();

            $tb045_facturaForm   = $this->getRequestParameter('tb045_factura');
            $tb008_proveedorForm = $this->getRequestParameter('tb008_proveedor');
            /*CAMPOS*/

            $co_compra = $tb045_facturaForm["co_compra"];

            if ($co_compra != '' || $co_compra != null) {
                $tb052_compras = Tb052ComprasPeer::retrieveByPk($co_compra);
                $tb135_pago_servicio = Tb135PagoServicioPeer::retrieveByPk($co_pago_servicio);
            } else {
                $tb052_compras = new Tb052Compras();
                $tb135_pago_servicio = new Tb135PagoServicio();

                $tb026_solicitudForm = array(
                    "co_tipo_solicitud"   => 26,
                    "ejercicio"           => $this->getUser()->getAttribute('ejercicio'),
                    "fe_solicitud"        => date("d/m/Y"),
                    "observacion"         => $tb008_proveedorForm["tx_observacion"],
                    "codigo"              =>  $this->getUser()->getAttribute('codigo')
                );

                $resp = Tb026SolicitudPeer::setSolicitud($tb026_solicitudForm, $con);

                if ($resp["success"] == true) {
                    $tb045_facturaForm["co_solicitud"] = $resp["co_solicitud"];
                } else {
                    $this->data = json_encode(array(
                        "success" => false,
                        "msg" =>  $resp["msg"]
                    ));

                    return;
                }
            }


            $c = new Criteria();
            $c->clearSelectColumns();
            $c->add(Tb040ProveedorRamoPeer::CO_PROVEEDOR, $tb045_facturaForm["co_proveedor"]);
            $stmt = Tb040ProveedorRamoPeer::doSelectStmt($c);
            $camposRamo = $stmt->fetch(PDO::FETCH_ASSOC);




            $tb135_pago_servicio->setCoSolicitud($tb045_facturaForm["co_solicitud"])
                ->setCoProveedor($tb045_facturaForm["co_proveedor"])
                ->save($con);


            $tb052_compras->setCoUsuario($this->getUser()->getAttribute('codigo'));
            //$tb052_compras->setFechaCompra(date("Y-m-d"));
            if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                $tb052_compras->setFechaCompra($this->getUser()->getAttribute('fe_cierre'));
            } else {
                $tb052_compras->setFechaCompra(date("Y-m-d"));
            }
            $tb052_compras->setTxObservacion($tb045_facturaForm["tx_concepto"]);
            $tb052_compras->setCoRamo($camposRamo["co_ramo"]);
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
            $tb052_compras->save($con);

            $total_pagar = 0;

            $tb052_compras->setMontoTotal($total_pagar);
            $tb052_compras->save($con);

            $solicitud = Tb026SolicitudPeer::retrieveByPk($tb045_facturaForm["co_solicitud"]);
            $solicitud->setCoProveedor($tb045_facturaForm["co_proveedor"])->save($con);

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb045_facturaForm["co_solicitud"]));
            $ruta->setInCargarDato(true)->save($con);

            $con->commit();

            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

            $this->data = json_encode(array(
                "success"       => true,
                "msg"           => 'Factura cargada exitosamente!',
                "co_solicitud"  => $tb045_facturaForm["co_solicitud"]
            ));
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }
    }


    public function executeGuardarFactura(sfWebRequest $request)
    {

        $co_factura             = $this->getRequestParameter("co_factura");
        $nu_factura             = $this->getRequestParameter("nu_factura");
        $fe_emision             = $this->getRequestParameter("fe_emision");
        $tx_concepto            = $this->getRequestParameter("tx_concepto");
        $nu_control             = $this->getRequestParameter("nu_control");


        $con = Propel::getConnection();

        try {
            $con->beginTransaction();

            $tb045_factura = Tb045FacturaPeer::retrieveByPk($co_factura);
            $tb045_factura->setNuFactura($nu_factura);

            list($dia, $mes, $anio) = explode("/", $fe_emision);

            $tb045_factura->setFeEmision($$anio . "-" . $mes . "-" . $dia);
            $tb045_factura->setTxConcepto($tx_concepto);
            $tb045_factura->setNuControl($nu_control);
            $tb045_factura->save($con);

            $con->commit();

            $this->data = json_encode(array(
                "success" => true,
                "msg" => "La Factura se modifico exitosamente"
            ));
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }

        $this->setTemplate('guardar');
    }


    public function executeEliminar(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("co_factura");
        $con = Propel::getConnection();
        try {
            $con->beginTransaction();
            /*CAMPOS*/
            $tb045_factura = Tb045FacturaPeer::retrieveByPk($codigo);
            $tb045_factura->delete($con);
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

    public function executeLista(sfWebRequest $request) {}

    public function executeEliminarFactura(sfWebRequest $request)
    {

        $codigo = $this->getRequestParameter("co_factura");
        $co_detalle_compras = $this->getRequestParameter("co_detalle_compras");

        $con = Propel::getConnection();
        try {
            $con->beginTransaction();

            $Tb045Factura = Tb045FacturaPeer::retrieveByPk($codigo);
            $co_solicitud = $Tb045Factura->getCoSolicitud();
            $co_factura = $Tb045Factura->getCoFactura();
            $Tb045Factura->delete($con);

            $wherec = new Criteria();
            $wherec->add(Tb053DetalleComprasPeer::CO_FACTURA, $co_factura);
            BasePeer::doDelete($wherec, $con);

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
                "msg" => $e->getMessage()
                //  "msg" => 'Este registro no se puede borrar'
            ));
        }

        $this->setTemplate('eliminar');
    }

    public function executeStorelistaServiciosBasicos(sfWebRequest $request)
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

        $c->addAnd(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD, 26);
        $c->addAnd(Tb030RutaPeer::CO_PROCESO, $registro_proceso, Criteria::IN);

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

        $this->setTemplate('store');
    }

    public function executeStorelista(sfWebRequest $request)
    {
        $paginar            =   $this->getRequestParameter("paginar");
        $limit              =   $this->getRequestParameter("limit", 20);
        $start              =   $this->getRequestParameter("start", 0);
        $co_solicitud       =   $this->getRequestParameter("co_solicitud");

        $c = new Criteria();

        $c->setIgnoreCase(true);

        $c->setDistinct();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb045FacturaPeer::CO_FACTURA);
        $c->addSelectColumn(Tb045FacturaPeer::NU_FACTURA);
        $c->addSelectColumn(Tb045FacturaPeer::FE_EMISION);
        $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->addSelectColumn(Tb045FacturaPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tb045FacturaPeer::NU_CONTROL);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        $c->addSelectColumn(Tb045FacturaPeer::NU_BASE_IMPONIBLE);
        $c->addSelectColumn(Tb045FacturaPeer::CO_IVA_FACTURA);
        $c->addSelectColumn(Tb045FacturaPeer::NU_IVA_FACTURA);
        $c->addSelectColumn(Tb045FacturaPeer::NU_TOTAL);
        $c->addSelectColumn(Tb045FacturaPeer::CO_IVA_RETENCION);
        $c->addSelectColumn(Tb045FacturaPeer::NU_IVA_RETENCION);
        $c->addSelectColumn(Tb045FacturaPeer::NU_TOTAL_RETENCION);
        $c->addSelectColumn(Tb045FacturaPeer::TOTAL_PAGAR);
        $c->addSelectColumn(Tb045FacturaPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tb045FacturaPeer::CO_COMPRA);
        $c->addSelectColumn(Tb045FacturaPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb045FacturaPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb045FacturaPeer::CO_RAMO);
        $c->addSelectColumn(Tb045FacturaPeer::CO_IVA);
        $c->addSelectColumn(Tb045FacturaPeer::CO_ODP);
        $c->addSelectColumn(Tb045FacturaPeer::NU_CONTROL);
        $c->addSelectColumn(Tb045FacturaPeer::ID_TB048_PRODUCTO);

        $c->addJoin(Tb048ProductoPeer::CO_PRODUCTO, Tb053DetalleComprasPeer::CO_PRODUCTO);
        $c->addJoin(Tb045FacturaPeer::CO_FACTURA, Tb053DetalleComprasPeer::CO_FACTURA);
        $c->add(Tb053DetalleComprasPeer::CO_PRODUCTO, 19336, Criteria::NOT_EQUAL);
        $c->add(Tb045FacturaPeer::CO_SOLICITUD, $co_solicitud);

        // echo $c->toString(); exit();

        $cantidadTotal = Tb045FacturaPeer::doCount($c);

        //$c->setLimit($limit)->setOffset($start);

        $c->addAscendingOrderByColumn(Tb045FacturaPeer::CO_FACTURA);

        $stmt = Tb045FacturaPeer::doSelectStmt($c);
        $registros = "";
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = array(
                "co_factura"     => trim($res["co_factura"]),
                "nu_factura"     => trim($res["nu_factura"]),
                "fe_emision"     => trim($res["fe_emision"]),
                "total_pagar"    => trim($res["monto"]),
                "tx_concepto"    => trim($res["tx_concepto"]),
                "nu_control"     => trim($res["nu_control"]),
                "co_producto"    => trim($res["co_producto"]),
                "tx_producto"    => trim($res["tx_producto"]),
                "co_detalle_compras" => trim($res["co_detalle_compras"]),
                "nu_base_imponible"     => trim($res["nu_base_imponible"]),
                "co_iva_factura"     => trim($res["co_iva_factura"]),
                "nu_iva_factura"     => trim($res["nu_iva_factura"]),
                "nu_total"     => trim($res["nu_total"]),
                "co_iva_retencion"     => trim($res["co_iva_retencion"]),
                "nu_iva_retencion"     => trim($res["nu_iva_retencion"]),
                "nu_total_retencion"     => trim($res["nu_total_retencion"]),
                "co_compra"     => trim($res["co_compra"]),
                "co_solicitud"     => trim($res["co_solicitud"]),
                "co_proveedor"     => trim($res["co_proveedor"]),
                "co_ramo"     => trim($res["co_ramo"]),
                "co_iva"     => trim($res["co_iva"]),
                "co_odp"     => trim($res["co_odp"]),
                "nu_control"     => trim($res["nu_control"]),
                "id_tb048_producto"     => trim($res["id_tb048_producto"]),
            );
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));
    }

    //modelo fk tb052_compras.CO_COMPRAS
    public function executeStorefkcocompra(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb052ComprasPeer::doSelectStmt($c);
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
    //modelo fk tb038_ramo.CO_RAMO
    public function executeStorefkcoramo(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb038RamoPeer::doSelectStmt($c);
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
    //modelo fk tb043_iva_factura.CO_IVA_FACTURA
    public function executeStorefkcoiva(sfWebRequest $request)
    {
        $c = new Criteria();
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
    //modelo fk tb060_orden_pago.CO_ORDEN_PAGO
    public function executeStorefkcoodp(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb060OrdenPagoPeer::doSelectStmt($c);
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

    //modelo fk tb060_orden_pago.CO_ORDEN_PAGO
    public function executeStorefkcoivaretencion(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb044IvaRetencionPeer::doSelectStmt($c);
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

    public function executeStorefkcoproducto(sfWebRequest $request)
    {

        $de_variable            =   $this->getRequestParameter("variable");
        $co_tipo_solicitud      =   $this->getRequestParameter("co_tipo_solicitud");
        $co_documento           =   $this->getRequestParameter("co_documento");

        //$co_clase   =   12;
        $co_clase   =   array(12, 18, 19, 20, 21, 22, 30);

        $c = new Criteria();

        if ($co_tipo_solicitud == 26) {
            //Servicios Varios (Servicios Basicos)
            $c->add(Tb048ProductoPeer::CO_PRODUCTO, array(19500, 19499, 19498,20024,20025,20028), Criteria::IN);
        }

        if ($co_tipo_solicitud == 39) {
            //Servicios Varios ( Honorarios, Publicidad)
            if ($co_documento == 4 || $co_documento == 5) {
                $c->add(Tb048ProductoPeer::CO_PRODUCTO, array(19548, 19546), Criteria::IN);
            } else {
                $c->add(Tb048ProductoPeer::CO_PRODUCTO, array(19544, 19543), Criteria::IN);
            }
        }

        if ($co_tipo_solicitud == 40) {
            //Servicios Varios (Arrendamiento)
            $c->add(Tb048ProductoPeer::CO_PRODUCTO, array(19545), Criteria::IN);
        }

        if ($co_tipo_solicitud == 41) {
            //Servicios Varios (Servicios Basicos)
            $c->add(Tb048ProductoPeer::CO_PRODUCTO, array(19574), Criteria::IN);
        }

        if ($this->getRequestParameter("BuscarBy") == "true") {
            if ($de_variable != "") {
                $c->add(Tb048ProductoPeer::TX_PRODUCTO, '%' . $de_variable . '%', Criteria::ILIKE);
            }
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
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));

        $this->setTemplate('store');
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
}
