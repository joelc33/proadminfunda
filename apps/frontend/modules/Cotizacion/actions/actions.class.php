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
class CotizacionActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Compras', 'lista');
  }

  public function getRequisicion($codigo){
      
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb039RequisicionesPeer::CO_REQUISICION);
        $c->add(Tb039RequisicionesPeer::CO_SOLICITUD,$codigo);        
        $stmt = Tb039RequisicionesPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos;
      
  }


  public function executeProyecto(sfWebRequest $request)
  {

            $c = new Criteria();
            $c->add(Tb206CotizacionPeer::CO_SOLICITUD,$this->getRequestParameter("co_solicitud"));        
            $stmt = Tb206CotizacionPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);     

            $requisicion = $this->getRequisicion($this->getRequestParameter("co_solicitud"));
            $this->co_requisicion = $requisicion["co_requisicion"];       

            if(!empty($campos["co_cotizacion"])){

                    $this->data = json_encode(array(
                                    "co_cotizacion"        => $campos["co_cotizacion"],
                                    "numero_cotizacion"    => $campos["numero_cotizacion"],
                                    "tx_serial_cotizacion" => $campos["tx_serial_cotizacion"],
                                    "tx_observacion"       => $campos["tx_observacion"],
                                    "co_requisicion"       => $campos["co_requisicion"],
                                    "monto_compra"         => $campos["monto_sub_total"],
                                    "monto_iva"            => $campos["monto_iva"],
                                    "monto_total"          => $campos["monto_total"],
                                    "co_ente"              => $campos["co_ente"],
                                    "co_solicitud"         => $this->getRequestParameter("co_solicitud"),
                                    "co_tipo_solicitud"    => $this->getRequestParameter("co_tipo_solicitud"),
                                    "co_iva_factura"       => round($campos["nu_iva"],0),
                    ));


            }else{

                    $c = new Criteria();
                    $c->add(Tb039RequisicionesPeer::CO_SOLICITUD,$this->getRequestParameter("co_solicitud"));
                    $stmt = Tb039RequisicionesPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);

                    $this->data = json_encode(array(
                                    "co_cotizacion"        => "",
                                    "co_requisicion"       => $campos["co_requisicion"],
                                    "monto_compra"         => 0,
                                    "monto_iva"            => 0,
                                    "monto_total"          => 0,
                                    "co_solicitud"         => $this->getRequestParameter("co_solicitud"),
                                    "co_tipo_solicitud"    => $this->getRequestParameter("co_tipo_solicitud"),
                                    "co_iva_factura"       => "",
                                    "co_ente"              => "",
                                    "co_iva_factura"       => "",
                                    "numero_cotizacion"    => "",
                                    "tx_observacion"       => "",
                                    "tx_serial_cotizacion" => ""
                    ));
            }
  }

  public function executeAgregarProducto(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tb039RequisicionesPeer::CO_REQUISICION,$codigo);
        
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
    }else{
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

  public function executeStorelistamateriales(sfWebRequest $request) {
       
        $codigo   =   $this->getRequestParameter("co_cotizacion");
        $limit      =   $this->getRequestParameter("limit",8);
        $start      =   $this->getRequestParameter("start",0);
                       
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb207DetalleCotizacionPeer::CO_DETALLE_COTIZACION);
        $c->addSelectColumn(Tb207DetalleCotizacionPeer::CO_DETALLE_REQUISICION);
        $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        $c->addSelectColumn(Tb207DetalleCotizacionPeer::NU_CANTIDAD);
        $c->addSelectColumn(Tb207DetalleCotizacionPeer::PRECIO_UNITARIO);
        $c->addSelectColumn(Tb207DetalleCotizacionPeer::DETALLE);
        $c->addSelectColumn(Tb207DetalleCotizacionPeer::MONTO);
        $c->addSelectColumn(Tb207DetalleCotizacionPeer::IN_EXENTO);
        $c->addJoin(Tb207DetalleCotizacionPeer::CO_PRODUCTO, Tb048ProductoPeer::CO_PRODUCTO);
        $c->add(Tb207DetalleCotizacionPeer::CO_COTIZACION,$codigo);
        $c->add(Tb207DetalleCotizacionPeer::CO_PRODUCTO,19336,  Criteria::NOT_EQUAL); //Excluye el IVA
               
        $cantidadTotal = Tb207DetalleCotizacionPeer::doCount($c);
        //$c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb048ProductoPeer::TX_PRODUCTO);
        
        $stmt = Tb207DetalleCotizacionPeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));
        
        $this->setTemplate('store');
    }

  

  public function executeGuardar(sfWebRequest $request)
  {

    $codigo = $this->getRequestParameter("co_cotizacion");
    $json_producto  = $this->getRequestParameter("json_producto");
    $tb206_cotizacionForm = $this->getRequestParameter('tb206_cotizacion');

    $c = new Criteria();
    $c->add(Tb206CotizacionPeer::ANIO, $this->getUser()->getAttribute('ejercicio'));
    $c->add(Tb206CotizacionPeer::CO_TIPO_SOLICITUD,$tb206_cotizacionForm["co_tipo_solicitud"]);
    $total = Tb206CotizacionPeer::doCount($c);
    $correlativo = $total + 1;
    
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
          $tb206_cotizacion    = Tb206CotizacionPeer::retrieveByPk($codigo);
     }else{
        $tb206_cotizacion = new Tb206Cotizacion();         
        $serial = 'PB-'.date("Ym").'-'.Tb137ControlSerialPeer::getSerial(3,$con,$this->getUser()->getAttribute('ejercicio'));  
     } 
     $tb206_cotizacion->setNumeroCotizacion($serial);
         
     
     try
      { 
        $con->beginTransaction();
              
                                        
        /*Campo tipo BIGINT */
        $tb206_cotizacion->setCoRequisicion($tb206_cotizacionForm["co_requisicion"]);
        $tb206_cotizacion->setCoEnte($tb206_cotizacionForm["co_ente"]);
        $tb206_cotizacion->setCoUsuario($this->getUser()->getAttribute('codigo'));
        $tb206_cotizacion->setTxObservacion($tb206_cotizacionForm["tx_observacion"]);
        $tb206_cotizacion->setCoSolicitud($tb206_cotizacionForm["co_solicitud"]);        
        $tb206_cotizacion->setCoTipoSolicitud($tb206_cotizacionForm["co_tipo_solicitud"]);        
        $tb206_cotizacion->setAnio($this->getUser()->getAttribute('ejercicio'));       
        $tb206_cotizacion->setNuIva($tb206_cotizacionForm["co_iva_factura"]);
        $tb206_cotizacion->setMontoIva($tb206_cotizacionForm["monto_iva"]);
        $tb206_cotizacion->setMontoSubTotal($tb206_cotizacionForm["monto_compra"]);
        $tb206_cotizacion->setMontoTotal($tb206_cotizacionForm["monto_total"]);
        $tb206_cotizacion->setTxSerialCotizacion($tb206_cotizacionForm["tx_serial_cotizacion"]);
        $tb206_cotizacion->save($con);
        
        $listaProducto  = json_decode($json_producto,true);
        $array_producto = array();
        $i=0;
        
        foreach($listaProducto  as $productoForm){
          
                if(empty($productoForm["co_detalle_cotizacion"])){                    
                    $tb207_detalle_cotizacion = new Tb207DetalleCotizacion();
                    $tb207_detalle_cotizacion->setCoCotizacion($tb206_cotizacion->getCoCotizacion());                                        
                    $tb207_detalle_cotizacion->setCoProducto($productoForm["co_producto"]);
                    if(!empty($productoForm["co_detalle_requisicion"])){
                        $tb207_detalle_cotizacion->setCoDetalleRequisicion($productoForm["co_detalle_requisicion"]);
                    }
                    $tb207_detalle_cotizacion->setNuCantidad($productoForm["nu_cantidad"]);
                    $tb207_detalle_cotizacion->setPrecioUnitario($productoForm["precio_unitario"]);
                    $tb207_detalle_cotizacion->setMonto($productoForm["monto"]);
                    $tb207_detalle_cotizacion->setDetalle($productoForm["detalle"]);
                    $tb207_detalle_cotizacion->setCoUnidadProducto($productoForm["co_unidad_producto"]);
                    $tb207_detalle_cotizacion->setInCalcularIva(true);
                    $tb207_detalle_cotizacion->setInExento($productoForm["in_exento"]);
                    $tb207_detalle_cotizacion->save($con);
                }
        }
        
        
        
        
        $monto_iva = $tb206_cotizacionForm["monto_iva"];
        
        $wherec = new Criteria();
        $wherec->add(Tb207DetalleCotizacionPeer::CO_COTIZACION, $tb206_cotizacion->getCoCotizacion());
        $wherec->add(Tb207DetalleCotizacionPeer::CO_PRODUCTO, 19336);
        BasePeer::doDelete($wherec, $con);
        
        if($monto_iva > 0){        
            $tb207_detalle_cotizacion = new Tb207DetalleCotizacion();
            $tb207_detalle_cotizacion->setCoCotizacion($tb206_cotizacion->getCoCotizacion());                                        
            $tb207_detalle_cotizacion->setCoProducto(19336); //IMPUESTO AL VALOR AGREGADO (IVA)
            $tb207_detalle_cotizacion->setNuCantidad(1);
            $tb207_detalle_cotizacion->setPrecioUnitario($productoForm["precio_unitario"]);
            $tb207_detalle_cotizacion->setMonto(round($monto_iva,2));
            $tb207_detalle_cotizacion->setDetalle('IMPUESTO AL VALOR AGREGADO (IVA)');
            $tb207_detalle_cotizacion->setCoPartida($tb206_cotizacionForm["co_partida_iva"]);
            $tb207_detalle_cotizacion->setCoUnidadProducto(638);
            $tb207_detalle_cotizacion->save($con);        
        }
        
        
                
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb206_cotizacionForm["co_solicitud"]));
        $ruta->setCoUsuario($this->getUser()->getAttribute('codigo'));
        $ruta->setInCargarDato(true)->save($con);
        
       // $tb026_solicitud = Tb026SolicitudPeer::retrieveByPK($tb206_cotizacionForm["co_solicitud"]);
       // $tb026_solicitud->setCoProveedor($tb008_proveedorForm["co_proveedor"])->save($con);
        
        $con->commit();
        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());  
        
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Proceso realizado exitosamente'
                ));
        
      }catch (PropelException $e)
      {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage()
        ));
      }
    }

  

  public function executeEditar(sfWebRequest $request)
  {
    /*$codigo =  $this->getRequestParameter("co_solicitud");
    $con = Propel::getConnection();
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb206CotizacionPeer::CO_COMPRAS);
    $c->addSelectColumn(Tb206CotizacionPeer::CO_REQUISICION);
    $c->addSelectColumn(Tb206CotizacionPeer::IN_RESPONSABILIDAD_SOCIAL);
    $c->addSelectColumn(Tb206CotizacionPeer::CO_ENTE);
    $c->addSelectColumn(Tb206CotizacionPeer::CO_USUARIO);
    $c->addSelectColumn(Tb206CotizacionPeer::FECHA_COMPRA);
    $c->addSelectColumn(Tb206CotizacionPeer::TX_OBSERVACION);
    $c->addSelectColumn(Tb206CotizacionPeer::CO_SOLICITUD);
    $c->addSelectColumn(Tb206CotizacionPeer::CO_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb206CotizacionPeer::ANIO);
    $c->addSelectColumn(Tb206CotizacionPeer::NUMERO_COMPRA);
    $c->addSelectColumn(Tb206CotizacionPeer::MONTO_SUB_TOTAL);
    $c->addSelectColumn(Tb206CotizacionPeer::NU_IVA);
    $c->addSelectColumn(Tb206CotizacionPeer::MONTO_IVA);
    $c->addSelectColumn(Tb206CotizacionPeer::NU_ORDEN_COMPRA);
    $c->addSelectColumn(Tb206CotizacionPeer::MONTO_TOTAL);
    $c->addSelectColumn(Tb206CotizacionPeer::CO_EJECUTOR);
    $c->addSelectColumn(Tb206CotizacionPeer::CO_PROYECTO_AC);
    $c->addSelectColumn(Tb206CotizacionPeer::CO_ACCION_ESPECIFICA);
    $c->addSelectColumn(Tb206CotizacionPeer::CO_PARTIDA_IVA);
    $c->addSelectColumn(Tb206CotizacionPeer::CREATED_AT);
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
    $c->add(Tb206CotizacionPeer::CO_SOLICITUD,$codigo);
    $c->addJoin(Tb206CotizacionPeer::CO_SOLICITUD, Tb045FacturaPeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
    $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb206CotizacionPeer::CO_PROVEEDOR);
    $c->addJoin(Tb056ContratoComprasPeer::CO_COMPRAS, Tb206CotizacionPeer::CO_COMPRAS);
    $stmt = Tb206CotizacionPeer::doSelectStmt($c);
    $campos = $stmt->fetch(PDO::FETCH_ASSOC);

    if($campos["co_compras"]!=''){
        
        $requisicion = $this->getRequisicion($this->getRequestParameter("co_solicitud"));
        $this->co_requisicion = $requisicion["co_requisicion"];
        list($anio,$mes,$dia) = explode("-", $campos["created_at"]);

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
                            "fe_registro"        => $dia.'-'.$mes.'-'.$anio,
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
                            "co_factura"         => ($campos["co_factura"]==null)?'':$campos["co_factura"]
                            
                    ));
    }else{*/
        
        
        $requisicion = $this->getRequisicion($this->getRequestParameter("co_solicitud"));
        $this->co_requisicion = $requisicion["co_requisicion"];
        $c = new Criteria();
        //$c->add(Tb206CotizacionPeer::ANIO, date('Y'));
        $c->add(Tb206CotizacionPeer::ANIO, $this->getUser()->getAttribute('ejercicio'));
        $c->add(Tb206CotizacionPeer::CO_TIPO_SOLICITUD,$this->getRequestParameter("co_tipo_solicitud"));
        $total = Tb206CotizacionPeer::doCount($c);
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
        $cp->add(Tb045FacturaPeer::CO_SOLICITUD,$codigo);
        $cp->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb045FacturaPeer::CO_PROVEEDOR);
        $stmt = Tb008ProveedorPeer::doSelectStmt($cp);
        $campos_proveedor = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $cm = new Criteria();
        $cm->clearSelectColumns();
        $cm->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL. ') as total');
        $cm->add(Tb045FacturaPeer::CO_SOLICITUD,$codigo);
        $stmt = Tb045FacturaPeer::doSelectStmt($cm);
        $monto = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
        $nu_compra =  date("Ym", strtotime($this->getUser()->getAttribute('fe_cierre'))).'-'.$correlativo;
        }else{
        $nu_compra = date("Ym").'-'.$correlativo;
        }        
        
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
                            "monto"              => ($monto["total"]!='')?$monto["total"]:0,
                            "co_iva_factura"     => ($campos_proveedor["co_iva_factura"]==null)?"":$campos_proveedor["co_iva_factura"],
                            "tx_rif"             => ($campos_proveedor["tx_rif"]==null)?"":$campos_proveedor["tx_rif"],
                            "tx_razon_social"    => ($campos_proveedor["tx_razon_social"]==null)?"":$campos_proveedor["tx_razon_social"],
                            "tx_direccion"       => ($campos_proveedor["tx_direccion"]==null)?"":$campos_proveedor["tx_direccion"],
                            "co_ramo"            => ($campos_proveedor["co_ramo"]==null)?"":$campos_proveedor["co_ramo"],
                            "co_factura"         => ($campos_proveedor["co_factura"]==null)?"":$campos_proveedor["co_factura"]
                    ));
    //}

  }


  public function executeBuscarPresupuestoBase(sfWebRequest $request)
  {


  }

  public function executeBuscarCompra(sfWebRequest $request)
  {


  }

  public function getTxRutaReporte($co_proceso,$co_solicitud){


        $encrip = new myConfig();

        $cp = new Criteria();
        $cp->add(Tb030RutaPeer::CO_SOLICITUD,$co_solicitud);
        $cp->add(Tb030RutaPeer::CO_PROCESO,$co_proceso);
        $stmt = Tb030RutaPeer::doSelectStmt($cp);
        $campos= $stmt->fetch(PDO::FETCH_ASSOC);

        return $encrip->encrypt($campos["co_ruta"]);



  }

  public function executeStorelistaPresupuestoBase(sfWebRequest $request)
  {

            $c = new Criteria();    
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb206CotizacionPeer::CO_SOLICITUD);
            $c->addSelectColumn(Tb206CotizacionPeer::CO_COTIZACION);
            $c->addSelectColumn(Tb206CotizacionPeer::NU_IVA);
            $c->addSelectColumn(Tb206CotizacionPeer::TX_SERIAL_COTIZACION);
            $c->addSelectColumn(Tb039RequisicionesPeer::NU_REQUISICION);
            $c->addSelectColumn(Tb206CotizacionPeer::TX_OBSERVACION);
            $c->addJoin(Tb039RequisicionesPeer::CO_REQUISICION,Tb206CotizacionPeer::CO_REQUISICION);   

            $c->setIgnoreCase(true);
            $cantidadTotal = Tb206CotizacionPeer::doCount($c);            
            $c->setLimit($limit)->setOffset($start);
            $c->addDescendingOrderByColumn(Tb206CotizacionPeer::CO_SOLICITUD);
                
            $stmt = Tb206CotizacionPeer::doSelectStmt($c);
            $registros = "";
            while($res = $stmt->fetch(PDO::FETCH_ASSOC)){

            $registros[] = array(
                    "co_solicitud"          => trim($res["co_solicitud"]),
                    "co_cotizacion"         => trim($res["co_cotizacion"]),
                    "nu_requisicion"        => trim($res["nu_requisicion"]),
                    "tx_serial_cotizacion"  => trim($res["tx_serial_cotizacion"]),
                    "tx_observacion"        => trim($res["tx_observacion"]),
                    "nu_iva"                => round($res["nu_iva"],0),
                    "co_ruta_requisicion"   => $this->getTxRutaReporte(65,$res["co_solicitud"]),
                    "co_ruta_presupuesto"   => $this->getTxRutaReporte(64,$res["co_solicitud"])
                );
            }

            $this->data = json_encode(array(
                "success"   =>  true,
                "total"     =>  $cantidadTotal,
                "data"      =>  $registros
            ));

            $this->setTemplate('store');
    } 

    public function executeStorelistaCompra(sfWebRequest $request)
    {

            $c = new Criteria();    
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb052ComprasPeer::CO_SOLICITUD);
            $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
            $c->addSelectColumn(Tb052ComprasPeer::CO_SOLICITUD_COTIZACION);
            $c->addSelectColumn(Tb206CotizacionPeer::CO_COTIZACION);
            $c->addSelectColumn(Tb206CotizacionPeer::NU_IVA);
            $c->addSelectColumn(Tb206CotizacionPeer::TX_SERIAL_COTIZACION);
            $c->addSelectColumn(Tb039RequisicionesPeer::NU_REQUISICION);
            $c->addSelectColumn(Tb206CotizacionPeer::TX_OBSERVACION);
            $c->addSelectColumn(Tb052ComprasPeer::TX_CONCEPTO);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
            $c->addSelectColumn(Tb007DocumentoPeer::INICIAL); 
            $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR); 
            $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO); 
            $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
            $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);    
            $c->addSelectColumn(Tb038RamoPeer::TX_RAMO);
            $c->addSelectColumn(Tb038RamoPeer::CO_RAMO);
            $c->addSelectColumn(Tb056ContratoComprasPeer::MONTO);
            $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
            $c->addSelectColumn(Tb007DocumentoPeer::TIPO);
            $c->addAsColumn('nu_iva_retencion', Tb044IvaRetencionPeer::NU_VALOR);

            $c->addJoin(Tb039RequisicionesPeer::CO_REQUISICION,Tb206CotizacionPeer::CO_REQUISICION);
            $c->addJoin(Tb206CotizacionPeer::CO_SOLICITUD,Tb052ComprasPeer::CO_SOLICITUD_COTIZACION); 
            $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR,Tb052ComprasPeer::CO_PROVEEDOR);  
            $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO,Tb007DocumentoPeer::CO_DOCUMENTO);   
            $c->addJoin(Tb044IvaRetencionPeer::CO_IVA_RETENCION, Tb008ProveedorPeer::CO_IVA_RETENCION);
            $c->addJoin(Tb056ContratoComprasPeer::CO_RAMO, Tb038RamoPeer::CO_RAMO,Criteria::LEFT_JOIN);
            $c->addJoin(Tb056ContratoComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
            $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);

            $c->setIgnoreCase(true);
            $cantidadTotal = Tb206CotizacionPeer::doCount($c);            
            $c->setLimit($limit)->setOffset($start);
            $c->addDescendingOrderByColumn(Tb206CotizacionPeer::CO_SOLICITUD);
                
            $stmt = Tb206CotizacionPeer::doSelectStmt($c);
            $registros = "";
            while($res = $stmt->fetch(PDO::FETCH_ASSOC)){

            $registros[] = array(
                    "co_solicitud"          => trim($res["co_solicitud"]),
                    "co_proveedor"          => trim($res["co_proveedor"]),
                    "co_cotizacion"         => trim($res["co_cotizacion"]),
                    "nu_requisicion"        => trim($res["nu_requisicion"]),
                    "tx_serial_cotizacion"  => trim($res["tx_serial_cotizacion"]),
                    "tx_observacion"        => trim($res["tx_concepto"]),
                    "numero_compra"         => trim($res["numero_compra"]),
                    "co_compras"            => trim($res["co_compras"]),
                    "nu_iva"                => round($res["nu_iva"],0),
                    "tx_rif"                => $res["inicial"].'-'.$res["tx_rif"],
                    "tx_razon_social"       => $res["tx_razon_social"],
                    "co_ruta_requisicion"   => $this->getTxRutaReporte(65,$res["co_solicitud_cotizacion"]),
                    "co_ruta_presupuesto"   => $this->getTxRutaReporte(64,$res["co_solicitud_cotizacion"]),
                    "co_ruta_compra"        => $this->getTxRutaReporte(11,$res["co_solicitud"]),
                    "tipo"                  => trim($res["tipo"]),
                    "co_ramo"               => trim($res["co_ramo"]),
                    "tx_ramo"               => trim($res["tx_ramo"]),
                    "nu_iva"                => trim($res["nu_iva"]),
                    "nu_valor"              => trim($res["nu_iva_retencion"]),
                    "co_documento"          => trim($res["co_documento"])
                );
            }

            $this->data = json_encode(array(
                "success"   =>  true,
                "total"     =>  $cantidadTotal,
                "data"      =>  $registros
            ));

            $this->setTemplate('store');
    } 
    
}