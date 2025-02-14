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
class ContratoActions extends sfActions
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

  public function executeEditar(sfWebRequest $request)
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
    $c->addSelectColumn(Tb056ContratoComprasPeer::TX_ENTREGA);
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
        "tx_entrega"                => $campos["tx_entrega"],
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

      /*if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
        $nu_compra =  date("Ym", strtotime($this->getUser()->getAttribute('fe_cierre'))) . '-' . $correlativo;
      } else {
        $nu_compra = date("Ym") . '-' . $correlativo;
      }*/

      $nu_compra = '';

      $this->data = json_encode(array(
        "co_compras"         => "",
        "co_proveedor"       => $campos_proveedor["co_proveedor"],
        "co_requisicion"     => $requisicion["co_requisicion"],
        "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
        "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
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


  public function executeStorefkcotipoproceso(sfWebRequest $request)
  {

    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
    $c->add(Tb027TipoSolicitudPeer::CO_PROCESO, 67);
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

    $c->addAnd(Tb027TipoSolicitudPeer::CO_PROCESO, 67);
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
                "fe_solicitud"        => $tb052_comprasForm["fecha_compra"],
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
                $tipo = 'ADQ';
            }else{
                $tipo = 'SER';
            }
            $tb015_empresa = Tb015EmpresaPeer::retrieveByPk(1);
            $prefix = $tb015_empresa->getTxSiglaSerial();

            if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                $serial =  $prefix.'-'.$tipo.'-'.date("Y", strtotime($this->getUser()->getAttribute('fe_cierre'))).'-'.Tb137ControlSerialPeer::getSerial(11, $con, $this->getUser()->getAttribute('ejercicio'));
            } else {
                $serial =  $prefix.'-'.$tipo.'-'.date("Y").'-'.Tb137ControlSerialPeer::getSerial(11, $con, $this->getUser()->getAttribute('ejercicio'));
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
                $tb052_compras->setFechaCompra($fecha_compra);
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
    
              /*$wherec = new Criteria();
              $wherec->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_PRESU_BASE, $productoForm["co_detalle_cotizacion"]);
    
              $updc = new Criteria();
              $updc->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $tb053_detalle_compras->getCoDetalleCompras());
              BasePeer::doUpdate($wherec, $updc, $con);*/
    
    
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
    
            
           /* if ($productoForm["in_modificado"]) {
              if($tb053_detalle_compras_iva != null){
                Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $campoIva["co_presupuesto"], 4, $monto_iva_ant, '', $tb053_detalle_compras_iva->getCoDetalleCompras());
    
                Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $campoIva["co_presupuesto"], 1, $monto_iva, '', $tb053_detalle_compras_iva->getCoDetalleCompras());
              }
            }*/

            /**********************Actualiza la Cotizacion Disponible********************/
    
    
            $cotizacion = Tb207DetalleCotizacionPeer::retrieveByPK($productoForm["co_detalle_cotizacion"]);
            $cotizacion->setCoDetalleCompra($co_enlace);
            $cotizacion->save($con);
    
            /************************************************************************** */
    
          
    
            /**********************IVA*******************************/
            if ($monto_iva > 0) {            

              $dc = new Criteria();
              $dc->add(Tb207DetalleCotizacionPeer::CO_DETALLE_COMPRA, $co_enlace);
              $stmtdc = Tb207DetalleCotizacionPeer::doSelectStmt($dc);
              $campodc = $stmtdc->fetch(PDO::FETCH_ASSOC);

              $dci = new Criteria();
              $dci->add(Tb207DetalleCotizacionPeer::CO_DETALLE_COTIZACION_ENLACE, $campodc["co_detalle_cotizacion"]);
              $stmtdci = Tb207DetalleCotizacionPeer::doSelectStmt($dci);
              $campodci = $stmtdci->fetch(PDO::FETCH_ASSOC);

             
              $tb053_detalle_compras_iva->setCoCompras($tb052_compras->getCoCompras());
              $tb053_detalle_compras_iva->setCoProducto(19336); //IMPUESTO AL VALOR AGREGADO (IVA)
              $tb053_detalle_compras_iva->setNuCantidad(1);
              $tb053_detalle_compras_iva->setCoPresupuesto($campodci["co_presupuesto"]);
              $tb053_detalle_compras_iva->setPrecioUnitario(round($monto_iva, 2));
              $tb053_detalle_compras_iva->setMonto(round($monto_iva, 2));
              $tb053_detalle_compras_iva->setDetalle('IMPUESTO AL VALOR AGREGADO (IVA)');
              $tb053_detalle_compras_iva->setCoPartida($campoIva["co_presupuesto"]);
              $tb053_detalle_compras_iva->setCoUnidadProducto(638);
              $tb053_detalle_compras_iva->setCoDetalleCompraEnlace($co_enlace);
              $tb053_detalle_compras_iva->save($con);

              

              $cotizacioniva = Tb207DetalleCotizacionPeer::retrieveByPK($campodci["co_detalle_cotizacion"]);
              $cotizacioniva->setCoDetalleCompra($tb053_detalle_compras_iva->getCoDetalleCompras());
              $cotizacioniva->save($con);
    
             /* if (!empty($tb052_comprasForm["tx_serial_cotizacion"])) {
    
                $wherec = new Criteria();
                $wherec->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_PRESU_BASE, $this->getCoDetalleCotizacionIva($tb052_comprasForm["tx_serial_cotizacion"]));
    
                $updc = new Criteria();
                $updc->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $tb053_detalle_compras->getCoDetalleCompras());
                BasePeer::doUpdate($wherec, $updc, $con);
              }*/
            }
    
    
            /********************************************************/
    
            
          }

            if ($tb052_comprasForm["co_contrato_compras"] != '' || $tb052_comprasForm["co_contrato_compras"] != null) {
                $tb056_contrato_compras = Tb056ContratoComprasPeer::retrieveByPk($tb052_comprasForm["co_contrato_compras"]);
            } else {
                $tb056_contrato_compras = new Tb056ContratoCompras();
            }
            $tb056_contrato_compras->setCoCompras($tb052_compras->getCoCompras());
            list($dia, $mes, $anio) = explode("/", $tb052_comprasForm["fecha_inicio"]);
            $fecha = $anio . "-" . $mes . "-" . $dia;
//            $tb056_contrato_compras->setFechaInicio($fecha);
            list($dia, $mes, $anio) = explode("/", $tb052_comprasForm["fecha_fin"]);
            $fecha = $anio . "-" . $mes . "-" . $dia;
//            $tb056_contrato_compras->setFechaFin($fecha);
            $tb056_contrato_compras->setCoRamo($tb052_comprasForm["co_ramo"]);
            $tb056_contrato_compras->setMonto($tb052_comprasForm["monto"]);

            /*  list($dia, $mes, $anio) = explode("/", $tb052_comprasForm["fecha_entrega"]);
        $fecha = $anio . "-" . $mes . "-" . $dia;
  
        $tb056_contrato_compras->setFechaEntrega($fecha);*/
            $tb056_contrato_compras->setTiempoGarantia($tb052_comprasForm["tiempo_garantia"]);
            $tb056_contrato_compras->setCoTpContrato($tb052_comprasForm["co_tp_contrato"]);
            $tb056_contrato_compras->setTxEntrega($tb052_comprasForm["tx_entrega"]);
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

 /* public function executeGuardar(sfWebRequest $request)
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
        "codigo"              => $this->getUser()->getAttribute('codigo')
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


      if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
        $serial = date("Ym", strtotime($this->getUser()->getAttribute('fe_cierre'))) . '-' . Tb137ControlSerialPeer::getSerial(11, $con, $this->getUser()->getAttribute('ejercicio'));
      } else {
        $serial =  date("Ym") . '-' . Tb137ControlSerialPeer::getSerial(11, $con, $this->getUser()->getAttribute('ejercicio'));
      }

      $tb052_compras->setNumeroCompra($serial);
    }
    try {

      if (!empty($co_solicitud_cotizacion)) {
        $tb052_comprasForm["co_requisicion"] = $this->getDatosRequisicion($co_solicitud_cotizacion);
      }

      $tb052_compras->setCoRequisicion($tb052_comprasForm["co_requisicion"]);

     
      $tb052_compras->setCoEnte($tb052_comprasForm["co_ente"]);

      $tb052_compras->setCoSolicitudCotizacion($co_solicitud_cotizacion);

     
      $tb052_compras->setCoUsuario($this->getUser()->getAttribute('codigo'));

    
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

    
      $tb052_compras->setTxObservacion($tb052_comprasForm["tx_observacion"]);

      $tb052_compras->setTxConcepto($tb052_comprasForm["tx_concepto"]);

     
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

      
      $tb052_compras->save($con);





      //echo  $tb052_comprasForm["co_tipo_solicitud"]; exit();

      $listaProducto  = json_decode($json_producto, true);
      $array_producto = array();
      $i = 0;

      /* $dc = new Criteria();
      $dc->add(Tb053DetalleComprasPeer::CO_COMPRAS, $tb052_compras->getCoCompras());
      $stmt = Tb053DetalleComprasPeer::doSelectStmt($dc);

      while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $wc = new Criteria();
        $wc->add(Tb207DetalleCotizacionPeer::CO_DETALLE_COMPRA, $res["co_detalle_compras"]);

        $updc = new Criteria();
        $updc->add(Tb207DetalleCotizacionPeer::CO_DETALLE_COMPRA, NULL);
        BasePeer::doUpdate($wc, $updc, $con);
      }

      $wherec = new Criteria();
      $wherec->add(Tb053DetalleComprasPeer::CO_COMPRAS, $tb052_compras->getCoCompras());
      BasePeer::doDelete($wherec, $con);*/



/*
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
  /*      $tb053_detalle_compras->setCoCompras($tb052_compras->getCoCompras());
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

          /*$wherec = new Criteria();
          $wherec->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_PRESU_BASE, $productoForm["co_detalle_cotizacion"]);

          $updc = new Criteria();
          $updc->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $tb053_detalle_compras->getCoDetalleCompras());
          BasePeer::doUpdate($wherec, $updc, $con);*/


       /*   $c = new Criteria();
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


      /*  if ($productoForm["in_modificado"]) {
          Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $campoIva["co_presupuesto"], 4, $monto_iva_ant, '', $tb053_detalle_compras_iva->getCoDetalleCompras());

          Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $campoIva["co_presupuesto"], 1, $monto_iva, '', $tb053_detalle_compras_iva->getCoDetalleCompras());
        }*/



        /**********************IVA*******************************
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


        /********************************************************

        /**********************Actualiza la Cotizacion Disponible********************


        $cotizacion = Tb207DetalleCotizacionPeer::retrieveByPK($productoForm["co_detalle_cotizacion"]);
        $cotizacion->setCoDetalleCompra($co_enlace);
        $cotizacion->save($con);

        /************************************************************************** *
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

      $tb056_contrato_compras->setFechaEntrega($fecha);*
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
  }*/
}
