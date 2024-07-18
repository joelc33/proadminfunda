<?php

/**
 * autoContabilidad actions.
 * NombreClaseModel(Tb056Contabilidad)
 * NombreTabla(tb056_contabilidad)
 * @package    ##PROJECT_NAME##
 * @subpackage autoContabilidad
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class ContabilidadActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("co_solicitud");


    $cc = new Criteria();
    $cc->addSelectColumn(Tb052ComprasPeer::CO_SOLICITUD);
    $cc->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb045FacturaPeer::CO_COMPRA);
    $cc->add(Tb045FacturaPeer::CO_SOLICITUD,$codigo);  
    $stmtc = Tb052ComprasPeer::doSelectStmt($cc);
    $res = $stmtc->fetch(PDO::FETCH_ASSOC);

    
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
    $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
    $c->addSelectColumn(Tb007DocumentoPeer::TIPO);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
    $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_INICIO);
    $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_FIN);
    $c->addSelectColumn(Tb052ComprasPeer::NU_IVA); 
    $c->addSelectColumn(Tb052ComprasPeer::TX_CONCEPTO);    
    $c->addSelectColumn(Tb038RamoPeer::TX_RAMO);
    $c->addSelectColumn(Tb038RamoPeer::CO_RAMO);
    $c->addSelectColumn(Tb056ContratoComprasPeer::MONTO);
    $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
    $c->addAsColumn('nu_iva_retencion', Tb044IvaRetencionPeer::NU_VALOR);
   
    $c->addJoin(Tb044IvaRetencionPeer::CO_IVA_RETENCION, Tb008ProveedorPeer::CO_IVA_RETENCION);
    $c->addJoin(Tb056ContratoComprasPeer::CO_RAMO, Tb038RamoPeer::CO_RAMO,Criteria::LEFT_JOIN);
    $c->addJoin(Tb056ContratoComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
    $c->addJoin(Tb052ComprasPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
    $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
    $c->add(Tb052ComprasPeer::CO_SOLICITUD,$res["co_solicitud"]);        
    
    $stmt = Tb056ContratoComprasPeer::doSelectStmt($c);
    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
    $this->data = json_encode(array(
        "co_proveedor"            => $campos["co_proveedor"],
        "nu_iva_retencion"        => $campos["nu_iva_retencion"],
        "co_compras"              => ($campos["co_compras"]==null)?'':$campos["co_compras"],
        "co_solicitud"            => $this->getRequestParameter("co_solicitud"),
        "co_solicitud_cotizacion" => $res["co_solicitud"],
        "co_documento"            => $campos["co_documento"],
        "co_ramo"                 => $campos["co_ramo"],
        "tx_razon_social"         => $campos["tx_razon_social"],
        "tx_rif"                  => $campos["tipo"].'-'.$campos["tx_rif"],
        "tipo"                    => $campos["tipo"],
        "tx_direccion"            => $campos["tx_direccion"],
        "tx_concepto"             => $campos["tx_concepto"],
        "fe_inicio"               => $campos["fecha_inicio"],
        "fe_fin"                  => $campos["fecha_fin"],
        "tx_ramo"                 => $campos["tx_ramo"],
        "monto"                   => $campos["monto"],
        "nu_iva"                  => $campos["nu_iva"],
        "co_solicitud_compra"     => $res["co_solicitud"],
        "nu_orden_pago"           => $this->getNuOrdenPago($this->getRequestParameter("co_solicitud"))
    ));
  }
  
  public function executeVerificarProveedor(sfWebRequest $request)
  {
  
    $co_documento  = $this->getRequestParameter('co_documento');
    $tx_rif        = $this->getRequestParameter('tx_rif');

    $c = new Criteria();
    
    
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
    $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
    $c->addSelectColumn(Tb044IvaRetencionPeer::NU_VALOR);    
    
    $c->add(Tb008ProveedorPeer::CO_DOCUMENTO,$co_documento);
    $c->add(Tb008ProveedorPeer::TX_RIF,$tx_rif);
    $c->addJoin(Tb008ProveedorPeer::CO_IVA_RETENCION,  Tb044IvaRetencionPeer::CO_IVA_RETENCION);
    $stmt = Tb008ProveedorPeer::doSelectStmt($c);

    $registros = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->data = json_encode(array(
        "success"   => true,
        "data"      => $registros
    ));
    $this->setTemplate('store');
    
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Contabilidad', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }
  
  public function executeVerDetalle(sfWebRequest $request)
  {

  }
  
  public function executeAgregarFactura(sfWebRequest $request)
  {
   
        $this->data = json_encode(array(
                "co_documento"     => $this->getRequestParameter("co_documento"),
                "co_ramo"          => $this->getRequestParameter("co_ramo"),
                "nu_iva"           => $this->getRequestParameter("nu_iva"),
                "nu_iva_retencion" => $this->getRequestParameter("nu_iva_retencion"),
                "co_solicitud"     => $this->getRequestParameter("co_solicitud"),
                "co_proveedor"     => $this->getRequestParameter("co_proveedor")
        ));

  }
  
  public function executeAgregarProducto(sfWebRequest $request)
  {
   
        $this->data = json_encode(array(
             "co_solicitud"     => $this->getRequestParameter("co_solicitud"),
             "iva"     => $this->getRequestParameter("iva")
        ));

  }
  
  public function executeAgregarDatosFactura(sfWebRequest $request)
  {   
        $this->data = json_encode(array(            
                "co_factura"        => $this->getRequestParameter("co_factura"),
                "nu_factura"        => $this->getRequestParameter("nu_factura"),
                "fe_emision"        => $this->getRequestParameter("fe_emision"),
                "nu_base_imponible" => $this->getRequestParameter("nu_base_imponible"),
                "nu_total_retencion"=> $this->getRequestParameter("nu_total_retencion"),
                "total_pagar"       => $this->getRequestParameter("total_pagar")
        ));
  }
    
  public function executeAgregarFacturaRetencion(sfWebRequest $request)
  {
   
        $this->data = json_encode(array(
                "co_documento"     => $this->getRequestParameter("co_documento"),
                "co_ramo"          => $this->getRequestParameter("co_ramo"),
                "nu_iva"           => $this->getRequestParameter("nu_iva"),
                "nu_iva_retencion" => $this->getRequestParameter("nu_iva_retencion")
        ));

  }
  
   
  
   public function executeAgregarFacturaRetencionExpress(sfWebRequest $request)
  {
   
        $this->data = json_encode(array(
                "co_documento"     => $this->getRequestParameter("co_documento"),
                "co_ramo"          => $this->getRequestParameter("co_ramo"),
                "nu_iva"           => $this->getRequestParameter("nu_iva"),
                "nu_iva_retencion" => $this->getRequestParameter("nu_iva_retencion")
        ));

  }
  

  
  public function executeCalculo(sfWebRequest $request)
  {
  
   
    $co_documento        = $this->getRequestParameter('co_documento');
    $co_ramo             = $this->getRequestParameter('co_ramo');
    $co_iva_factura      = $this->getRequestParameter('co_iva_factura');
    $nu_base_imponible   = $this->getRequestParameter('nu_base_imponible');
    $co_iva_retencion    = $this->getRequestParameter('co_iva_retencion');
    $co_proveedor        = $this->getRequestParameter('co_proveedor');
    
    
   
    $iva = $nu_base_imponible*($co_iva_factura/100);
    $monto_total = $nu_base_imponible+$iva;
   
    $stmt = Tb042RetencionPeer::getTipoRetencion($co_documento,$co_proveedor);
    $registros = array();
 
    while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){

        echo "ramo=".$reg["co_ramo"]; exit();
        if($reg["co_ramo"]==''){
           
             if($reg["co_tipo_retencion"]!=95 || $reg["co_tipo_retencion"]!=100){                                  
               if($co_documento==1 && $monto_total>$reg["mo_minimo"]){
                    $valor = ($nu_base_imponible*($reg["nu_valor"]/100)) - $reg["nu_sustraendo"];    
               }else{  
                     $valor = $nu_base_imponible*($reg["nu_valor"]/100);
               }
             }else{

               $valor = $monto_total*($reg["nu_valor"]/100);  
             }
             
             $registros[] = array("nu_valor" => $valor,
                                  "po_deduccion" => $reg["nu_valor"],
                                  "co_tipo_retencion" => $reg["co_tipo_retencion"],
                                  "tx_tipo_retencion" => $reg["tx_tipo_retencion"]);
           
             
        }else if($co_ramo == $reg["co_ramo"]){           
            
             if($reg["co_tipo_retencion"]!=95 || $reg["co_tipo_retencion"]!=100){
               if($co_documento==1 && $monto_total>$reg["mo_minimo"]){              
                    $valor = ($nu_base_imponible*($reg["nu_valor"]/100)) - $reg["nu_sustraendo"];    
               }else{  
                     $valor = $nu_base_imponible*($reg["nu_valor"]/100);
               }
             }else{

                     $valor = $monto_total*($reg["nu_valor"]/100);  
             }            
           
             $registros[] = array("nu_valor" => $valor,
                  "po_deduccion" => $reg["nu_valor"],
                  "co_tipo_retencion" => $reg["co_tipo_retencion"],
                  "tx_tipo_retencion" => $reg["tx_tipo_retencion"]);
            
        }
    }
    
    
    $this->data = json_encode(array(
        "success"   => true,
        "data"      => $registros
    ));
    $this->setTemplate('store');
    
  }
  
  public function executePresupuesto(sfWebRequest $request)
  {
      
  }
  
  
  public function executeEditarRetencion(sfWebRequest $request)
  {
    $codigo =  $this->getRequestParameter("co_solicitud");
    
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb039RequisicionesPeer::CO_REQUISICION);
    $c->addSelectColumn(Tb045FacturaPeer::CO_PROVEEDOR);
    $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
    $c->addSelectColumn(Tb045FacturaPeer::CO_RAMO);
    $c->addSelectColumn(Tb045FacturaPeer::CO_IVA);
    $c->addSelectColumn(Tb044IvaRetencionPeer::NU_VALOR);
    $c->addJoin(Tb039RequisicionesPeer::CO_SOLICITUD, Tb045FacturaPeer::CO_SOLICITUD);
    $c->addJoin(Tb045FacturaPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
    $c->addJoin(Tb044IvaRetencionPeer::CO_IVA_RETENCION, Tb008ProveedorPeer::CO_IVA_RETENCION);
    $c->setLimit(1);
    
    $c->addAnd(Tb039RequisicionesPeer::CO_SOLICITUD,$codigo);
    
      
    $stmt = Tb039RequisicionesPeer::doSelectStmt($c);
    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $campos["co_solicitud"] = $codigo;
    
    if($campos["co_proveedor"]!=''){
         $this->data = json_encode(array(
                "co_requisicion"     => $campos["co_requisicion"],
                "co_proveedor"       => $campos["co_proveedor"],
                "co_documento"       => $campos["co_documento"],
                "tx_rif"             => $campos["tx_rif"],
                "tx_razon_social"    => $campos["tx_razon_social"],
                "co_ramo"            => $campos["co_ramo"],
                "co_iva"             => $campos["co_iva"],
                "co_solicitud"       => $campos["co_solicitud"],
                "nu_iva_retencion"   => $campos["nu_valor"]
        ));
    }else{
        $this->data = json_encode(array(
                "co_requisicion"     => "",
                "co_proveedor"       => "",
                "co_documento"       => "",
                "tx_rif"             => "",
                "tx_razon_social"    => "",
                "co_ramo"            => "",
                "co_iva"             => "",
                "co_solicitud"       => $campos["co_solicitud"],
                "nu_iva_retencion"   => ""
        ));
    }
  }
  
  protected function getNuOrdenPago($co_solicitud){
      
        $c = new Criteria();
        $c->addJoin(Tb060OrdenPagoPeer::CO_RUTA, Tb030RutaPeer::CO_RUTA);
        $c->add(Tb030RutaPeer::CO_SOLICITUD,$co_solicitud);
        $c->add(Tb030RutaPeer::IN_ACTUAL,true);
        
        $stmt = Tb060OrdenPagoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        return $campos["nu_orden_pago"];
      
  }
  

  public function executeEditar(sfWebRequest $request)
  {
    $codigo =  $this->getRequestParameter("co_solicitud");
    
    $c = new Criteria();
    $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
    $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
    $c->addSelectColumn(Tb007DocumentoPeer::TIPO);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
    $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_INICIO);
    $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_FIN);
    $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);    
    $c->addSelectColumn(Tb038RamoPeer::TX_RAMO);
    $c->addSelectColumn(Tb038RamoPeer::CO_RAMO);
    $c->addSelectColumn(Tb056ContratoComprasPeer::MONTO);
    $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
    $c->addAsColumn('nu_iva_retencion', Tb044IvaRetencionPeer::NU_VALOR);
   
    $c->addJoin(Tb044IvaRetencionPeer::CO_IVA_RETENCION, Tb008ProveedorPeer::CO_IVA_RETENCION);
    $c->addJoin(Tb056ContratoComprasPeer::CO_RAMO, Tb038RamoPeer::CO_RAMO,Criteria::LEFT_JOIN);
    $c->addJoin(Tb056ContratoComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
    $c->addJoin(Tb052ComprasPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
    $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
    $c->add(Tb052ComprasPeer::CO_SOLICITUD,$codigo);        
    
    $stmt = Tb056ContratoComprasPeer::doSelectStmt($c);
    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
    $this->data = json_encode(array(
        "co_proveedor"          => $campos["co_proveedor"],
        "nu_iva_retencion"      => $campos["nu_iva_retencion"],
        "co_compras"            => $campos["co_compras"],
        "co_solicitud"          => $this->getRequestParameter("co_solicitud"),
        "co_documento"          => $campos["co_documento"],
        "co_ramo"               => $campos["co_ramo"],
        "tx_razon_social"       => $campos["tx_razon_social"],
        "tx_rif"                => $campos["tx_rif"],
        "tipo"                  => $campos["tipo"],
        "tx_direccion"          => $campos["tx_direccion"],
        "fe_inicio"             => $campos["fecha_inicio"],
        "fe_fin"                => $campos["fecha_fin"],
        "tx_ramo"               => $campos["tx_ramo"],
        "monto"                 => $campos["monto"],
        "nu_iva"                => $campos["nu_iva"],
        "nu_orden_pago"         => $this->getNuOrdenPago($this->getRequestParameter("co_solicitud"))
    ));
  }
  
  public function executeEditarNroFactura(sfWebRequest $request)
  {
    $codigo =  $this->getRequestParameter("co_solicitud");
    
    $c = new Criteria();
    $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
    $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
    $c->addSelectColumn(Tb007DocumentoPeer::TIPO);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
    $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_INICIO);
    $c->addSelectColumn(Tb056ContratoComprasPeer::FECHA_FIN);
    $c->addSelectColumn(Tb052ComprasPeer::NU_IVA);    
    $c->addSelectColumn(Tb038RamoPeer::TX_RAMO);
    $c->addSelectColumn(Tb038RamoPeer::CO_RAMO);
    $c->addSelectColumn(Tb056ContratoComprasPeer::MONTO);
    $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
    $c->addAsColumn('nu_iva_retencion', Tb044IvaRetencionPeer::NU_VALOR);
   
    $c->addJoin(Tb044IvaRetencionPeer::CO_IVA_RETENCION, Tb008ProveedorPeer::CO_IVA_RETENCION);
    $c->addJoin(Tb056ContratoComprasPeer::CO_RAMO, Tb038RamoPeer::CO_RAMO,Criteria::LEFT_JOIN);
    $c->addJoin(Tb056ContratoComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
    $c->addJoin(Tb052ComprasPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
    $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
    $c->add(Tb052ComprasPeer::CO_SOLICITUD,$codigo);        
    
    $stmt = Tb056ContabilidadPeer::doSelectStmt($c);
    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
    $this->data = json_encode(array(
        "co_proveedor"          => $campos["co_proveedor"],
        "nu_iva_retencion"      => $campos["nu_iva_retencion"],
        "co_compras"            => $campos["co_compras"],
        "co_solicitud"          => $this->getRequestParameter("co_solicitud"),
        "co_documento"          => $campos["co_documento"],
        "co_ramo"               => $campos["co_ramo"],
        "tx_razon_social"       => $campos["tx_razon_social"],
        "tx_rif"                => $campos["tx_rif"],
        "tipo"                  => $campos["tipo"],
        "tx_direccion"          => $campos["tx_direccion"],
        "fe_inicio"             => $campos["fecha_inicio"],
        "fe_fin"                => $campos["fecha_fin"],
        "tx_ramo"               => $campos["tx_ramo"],
        "monto"                 => $campos["monto"],
        "nu_iva"                 => $campos["nu_iva"]
    ));
  }
  
  public function executeGuardarDatosFactura(sfWebRequest $request)
  {
      
        $co_factura    = $this->getRequestParameter("co_factura");
        $nu_factura    = $this->getRequestParameter("nu_factura");
        $fecha_emision = $this->getRequestParameter("fe_emision");
        
        list($dia,$mes,$anio) = explode("-", $fecha_emision);
        $fecha = $anio.'-'.$mes.'-'.$dia;
        
        $tb045_factura = Tb045FacturaPeer::retrieveByPK($co_factura);
        $tb045_factura->setNuFactura($nu_factura)
                      ->setFeEmision($fecha)
                      ->save();
        
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb045_factura->getCoSolicitud()));
        $ruta->setInCargarDato(true)->save();

        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());  
      
        
        $this->data = json_encode(array(
                "success" => true,
                "msg" => 'La factura se actualizó exitosamente'
        ));
        
        $this->setTemplate('guardar');
  }
  
  
  
  public function getIVARetencion($mo_iva,$codigo){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb044IvaRetencionPeer::NU_VALOR);
        $c->addJoin(Tb008ProveedorPeer::CO_IVA_RETENCION, Tb044IvaRetencionPeer::CO_IVA_RETENCION);
        $c->add(Tb008ProveedorPeer::CO_PROVEEDOR,$codigo);        
        $stmt = Tb039RequisicionesPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $valor_iva = $campos['nu_valor']/100;
        
      return ($mo_iva * $valor_iva);
        
        //return $mo_iva-($mo_iva * $valor_iva);
        
  }
  
  protected function getIVA($baseimponible,$monto,$iva){
      
        $nu_iva = ($monto*$iva)/$baseimponible; //se calcula el iva por cada producto
               
        return $nu_iva; //$monto * $valor_iva;        
  }
  
  
  protected function getCodigoContableIva($co_solicitud){
      
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
        $c->addJoin(Tb008ProveedorPeer::CO_IVA_RETENCION, Tb044IvaRetencionPeer::CO_IVA_RETENCION);
        $c->add(Tb008ProveedorPeer::CO_PROVEEDOR,$codigo);        
        $stmt = Tb039RequisicionesPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos["co_codigo_contable"];
  }
  
  
  
  
 
  public function executeGuardar(sfWebRequest $request)
  {

     $co_compra        = $this->getRequestParameter("co_compra");
     $co_documento     = $this->getRequestParameter("co_documento");
     $co_ramo          = $this->getRequestParameter("co_ramo");
     $co_solicitud     = $this->getRequestParameter("co_solicitud");
     $co_proveedor     = $this->getRequestParameter("co_proveedor");
     $co_iva_factura   = $this->getRequestParameter("co_iva_factura");
     $co_iva           = $this->getRequestParameter("co_iva");
     $json_factura     = $this->getRequestParameter("json_factura");
     $nu_orden_pago    = $this->getRequestParameter("nu_orden_pago");
           
     $con = Propel::getConnection();
     
     try
      { 
        $con->beginTransaction();
        
        $listaFactura  = json_decode($json_factura,true);
        $array_factura = array();
        $i=0;
        
       
        //$co_odp = Tb060OrdenPagoPeer::generarODP($co_solicitud,$con);
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
        
        
                        
       /* $wherec = new Criteria();
        $wherec->add(Tb056ContratoComprasPeer::CO_COMPRAS,$co_compra);

        $updc = new Criteria();
        $updc->add(Tb056ContratoComprasPeer::CO_RAMO, $tb052_compras['co_ramo']);
        
        BasePeer::doUpdate($wherec, $updc, $con);*/
         
        foreach($listaFactura  as $v){
          
                if($v["co_factura"]==''){   
                    
                    if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
                        $fe_cierre = $this->getUser()->getAttribute('fe_cierre'); 
                    }else{
                        $fe_cierre =date("Y-m-d"); 
                    }  
                   
                    $tb045_factura = new Tb045Factura(); 
                    $tb045_factura->setNuFactura($v["nu_factura"])
                                   ->setNuControl($v["nu_control"])
                                   ->setFeEmision($v["fe_emision"])
                                   ->setNuTotal($v["nu_total"])
                                   ->setNuBaseImponible($v["nu_base_imponible"])
                                   ->setCoIvaFactura($v["co_iva_factura"])
                                   ->setNuIvaFactura($v["nu_iva_factura"])
                                   ->setCoIvaRetencion($v["co_iva_retencion"])
                                   ->setNuIvaRetencion($v["nu_iva_retencion"])
                                   ->setNuTotalRetencion($v["nu_total_retencion"])
                                   ->setTotalPagar($v["total_pagar"])
                                   ->setTxConcepto($v["tx_concepto"])  
                                   ->setFeRegistro($fe_cierre) 
                                  // ->setCoOdp($co_odp)
                                   ->setCoSolicitud($co_solicitud);
                    
                                        
                    
                    if($co_compra!=''){
                        $tb045_factura->setCoCompra($co_compra);
                    }
                    
                    if($co_ramo!=''){
                        $tb045_factura->setCoRamo($co_ramo);
                    }
                    
                    if($co_iva!=''){
                        $tb045_factura->setCoIva($co_iva);
                    }
                    
                    if($co_proveedor!=''){
                        $tb045_factura->setCoProveedor($co_proveedor);
                        
                        $tb026_solicitud = Tb026SolicitudPeer::retrieveByPK($co_solicitud);
                        $tb026_solicitud->setCoProveedor($co_proveedor)->save($con);                         
                    }
                    
                    $tb045_factura->save($con);
                                        
                    $co_cuenta_por_pagar = Tb130CuentaDocumentoPeer::getCoCuentaContable($co_solicitud); //Factura
                                 
                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoHaber($v["nu_total"])
                                  ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"])
                                  ->setCoSolicitud($co_solicitud)
                                  ->setCoFactura($tb045_factura->getCoFactura())
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCoRuta($ruta->getCoRuta())
                                  ->setCoTipoAsiento(1)
                                  ->save($con);
                                      
                    
                    $listaDetalleFactura  = json_decode($v["json_detalle_retencion"],true);
                    $listaProducto        = json_decode($v["json_producto"],true);
                    
                    
                    
                    $total_iva = 0;
                    foreach($listaProducto  as $lp){
                        if($lp["cant_producto"]!=''){
                           
                            $tb129_detalle_factura  = new Tb129DetalleFactura();
                            $tb129_detalle_factura->setCoProducto($lp["co_producto"])
                                                  ->setCantProducto($lp["cant_producto"])
                                                  ->setMoUnitario($lp["precio_unitario"])
                                                  ->setMoTotal($lp["mo_total"])
                                                  ->setCoPresupuesto($lp["co_presupuesto"])
                                                  ->setCoRequisicion($lp["co_detalle_requisicion"])
                                                  ->setCoDetalleCompra($lp["co_detalle_compras"])
                                                  ->setCoFactura($tb045_factura->getCoFactura())
                                                  ->save($con);

                            $mo_iva = $this->getIVA($v["nu_base_imponible"],$lp["mo_total"], $v["nu_iva_factura"]);

                            $mo_retencion = $this->getIVARetencion($mo_iva, $co_proveedor);

                            $monto = $lp["mo_total"]; //+$mo_retencion;

                            $tb061_asiento_contable = new Tb061AsientoContable();

                            $cuenta_contable = Tb024CuentaContablePeer::getCuentaContable($lp["co_producto"], $co_solicitud);

                            $tb061_asiento_contable->setMoDebe($monto)
                                          ->setCoCuentaContable($cuenta_contable["co_cuenta_contable"])
                                          ->setCoSolicitud($co_solicitud)
                                          ->setCoProducto($lp["co_producto"])
                                          ->setCoFactura($tb045_factura->getCoFactura())
                                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                          ->setCoTipoAsiento(1)
                                          ->setCoPresupuesto($lp["co_presupuesto"])
                                          ->setCoRuta($ruta->getCoRuta())
                                          ->save($con); 

                            $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                            $tb087_presupuesto_movimiento->setCoPartida($lp["co_presupuesto"])
                                             ->setCoTipoMovimiento(2)
                                             ->setNuMonto($monto)
                                             //->setNuAnio(date('Y'))
                                             ->setNuAnio( $this->getUser()->getAttribute('ejercicio'))
                                             ->setCoFactura($tb045_factura->getCoFactura())
                                             ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                             ->setCoDetalleCompra($cuenta_contable["co_detalle_compras"])
                                             ->setInActivo(true)
                                             ->save($con);


                            $total_iva+=$mo_iva;
                        } 
                                      
                    }
                    
                    $cuenta_contable = Tb024CuentaContablePeer::getCuentaContable(19336, $co_solicitud);

                    if($total_iva>0){
                            $tb061_asiento_contable = new Tb061AsientoContable();
                            $tb061_asiento_contable->setMoDebe($total_iva)
                                          ->setCoCuentaContable($cuenta_contable["co_cuenta_contable"])
                                          ->setCoSolicitud($co_solicitud)
                                          ->setCoProducto(19336)
                                          ->setCoFactura($tb045_factura->getCoFactura())
                                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                          ->setCoTipoAsiento(1)
                                          ->setCoRuta($ruta->getCoRuta())
                                          ->save($con);


                            $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                            $tb087_presupuesto_movimiento->setCoPartida($cuenta_contable["co_presupuesto"])
                                                 ->setCoTipoMovimiento(2)
                                                 ->setNuMonto($total_iva)
                                                 //->setNuAnio(date('Y'))
                                                 ->setNuAnio( $this->getUser()->getAttribute('ejercicio'))
                                                 ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                                 ->setCoDetalleCompra($cuenta_contable["co_detalle_compras"])
                                                 ->setInActivo(true)
                                                 ->setCoFactura($tb045_factura->getCoFactura())
                                                 ->save($con);
                    }         
                    
                    
                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoDebe($v["nu_total"])
                                      ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"])
                                      ->setCoSolicitud($co_solicitud)
                                      ->setCoFactura($tb045_factura->getCoFactura())
                                      ->setCoUsuario($this->getUser()->getAttribute('codigo'))                            
                                      ->setCoTipoAsiento(2)
                                      ->setCoRuta($ruta->getCoRuta())
                                      ->save($con);

                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoHaber($v["nu_total"])
                                      ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_orden_pago"])
                                      ->setCoSolicitud($co_solicitud)
                                      ->setCoFactura($tb045_factura->getCoFactura())
                                      ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                      ->setCoTipoAsiento(2)
                                      ->setCoRuta($ruta->getCoRuta())
                                      ->save($con);  
                    
                    foreach($listaDetalleFactura  as $vp){
                            $tb046_factura_retencion = new Tb046FacturaRetencion();
                            $tb046_factura_retencion->setCoFactura($tb045_factura->getCoFactura());
                            $tb046_factura_retencion->setCoTipoRetencion($vp["co_tipo_retencion"]);
                            $tb046_factura_retencion->setMoRetencion($vp["nu_valor"]);
                            $tb046_factura_retencion->setPoRetencion($vp["po_deduccion"]);
                            $tb046_factura_retencion->setCoSolicitud($co_solicitud);
                           // $tb046_factura_retencion->setCoOdp($co_odp);
                            $tb046_factura_retencion->save($con);                        
                    }


                    if($v["nu_iva_retencion"]>0){
                              $tb046_factura_retencion = new Tb046FacturaRetencion();
                              $tb046_factura_retencion->setCoFactura($tb045_factura->getCoFactura());
                              $tb046_factura_retencion->setCoTipoRetencion(92);
                              $tb046_factura_retencion->setMoRetencion($v["nu_iva_retencion"]);
                              $tb046_factura_retencion->setPoRetencion($v["co_iva_retencion"]);
                              $tb046_factura_retencion->setCoSolicitud($co_solicitud);
                           //   $tb046_factura_retencion->setCoOdp($co_odp);
                              $tb046_factura_retencion->save($con);
                    }
                    
                }
        }
        
        $con->commit();
        
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
        
        $c = new Criteria();
        $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
        $cant = Tb045FacturaPeer::doCount($c);      
        
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud)); 
            
        if($cant>0){            
                $ruta->setInCargarDato(true)->save($con);
               // $co_odp = Tb060OrdenPagoPeer::generarODP($co_solicitud,$con,$nu_orden_pago);
                
                Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());  

        }else{
            $ruta->setInCargarDato(false)->save($con);
        }
        
        $con->commit();
      
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Las Facturas se registraron exitosamente'
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
  

  public function executeEliminar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_contabilidad");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb056_contabilidad = Tb056ContabilidadPeer::retrieveByPk($codigo);			
	$tb056_contabilidad->delete($con);
		$this->data = json_encode(array(
			    "success" => true,
			    "msg" => 'Registro Borrado con exito!'
		));
	$con->commit();
	}catch (PropelException $e)
	{
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
  
  protected function ActualizaDetalleCompra($c,$con){
      
        $stmt = Tb061AsientoContablePeer::doSelectStmt($c);

        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){                    
                $wherec = new Criteria();
                $wherec->add(Tb053DetalleComprasPeer::CO_ASIENTO_CONTABLE,$reg["co_asiento_contable"]);

                $updc = new Criteria();
                $updc->add(Tb053DetalleComprasPeer::CO_ASIENTO_CONTABLE, NULL);

                BasePeer::doUpdate($wherec, $updc, $con);
        }   
  }
  
  protected function getEliminaAsientoContable($co_solicitud,$co_factura,$con){
      
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb085PresupuestoPeer::ID);
        $c->addSelectColumn(Tb061AsientoContablePeer::MO_DEBE);
        $c->addSelectColumn(Tb061AsientoContablePeer::CO_PRODUCTO);
        $c->addJoin(Tb061AsientoContablePeer::CO_CUENTA_CONTABLE, Tb085PresupuestoPeer::CO_CUENTA_CONTABLE);
        $c->add(Tb061AsientoContablePeer::CO_FACTURA, $co_factura,Criteria::EQUAL);
        $c->add(Tb061AsientoContablePeer::MO_DEBE, null,Criteria::ISNOTNULL);        
               
//        echo $c->toString(); exit();
        
        $stmt = Tb061AsientoContablePeer::doSelectStmt($c);
        
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){  
            
//                $cuenta_contable = Tb024CuentaContablePeer::getCuentaContable($reg["co_producto"], $co_solicitud);
//            
//                $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
//                $tb087_presupuesto_movimiento->setCoPartida($reg["id"])
//                         ->setCoTipoMovimiento(6)
//                         ->setNuMonto($reg["mo_debe"])
//                         ->setNuAnio(date('Y'))
//                         ->setCoUsuario($this->getUser()->getAttribute('codigo'))
//                         ->setCoDetalleCompra($cuenta_contable["co_detalle_compras"])
//                         ->setInActivo(true)
//                         ->save($con);
        }         
      
  }


  public function executeEliminarFactura(sfWebRequest $request){
      
        $codigo        = $this->getRequestParameter("co_factura");
        $co_solicitud  = $this->getRequestParameter("co_solicitud");
	
        $con = Propel::getConnection();
	try
	{ 
            $con->beginTransaction();
            /*CAMPOS*/
            
//            $this->getEliminaAsientoContable($co_solicitud, $codigo, $con);
            
            $wherec = new Criteria();
            $wherec->add(Tb046FacturaRetencionPeer::CO_FACTURA, $codigo, Criteria::EQUAL);
            BasePeer::doDelete($wherec, $con);
            
            $whereAsiento = new Criteria();
            $whereAsiento->add(Tb061AsientoContablePeer::CO_FACTURA, $codigo);
            BasePeer::doDelete($whereAsiento, $con);     
            
            /***************Eliminar Producto Factura*************/
            $wherec = new Criteria();
            $wherec->add(Tb129DetalleFacturaPeer::CO_FACTURA, $codigo, Criteria::EQUAL);
            BasePeer::doDelete($wherec, $con);            
            
            $Tb045Factura = Tb045FacturaPeer::retrieveByPk($codigo);            
            $co_compra = $Tb045Factura->getCoCompra();            
            $Tb045Factura->delete($con);
            
            $c = new Criteria();
            $c->add(Tb045FacturaPeer::CO_COMPRA,$co_compra);            
            $cant = Tb045FacturaPeer::doCount($c);            
                        
            $wherePM = new Criteria();
            $wherePM->add(Tb087PresupuestoMovimientoPeer::CO_FACTURA, $codigo, Criteria::EQUAL);
            BasePeer::doDelete($wherePM, $con);   
           
            
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
            
            if($cant>0){            
                $ruta->setInCargarDato(true)->save($con);
            }else{
                
                $wherec = new Criteria();
                $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $co_solicitud,Criteria::EQUAL);
                
                $this->ActualizaDetalleCompra($wherec,$con);
                
                BasePeer::doDelete($wherec, $con);               
                
                $ruta->setInCargarDato(false)->save($con);
            }
            
            
            $this->data = json_encode(array(
                        "success" => true,
                        "msg" => 'Registro Borrado con exito!'
            ));
            
            
            $con->commit();
	}catch (PropelException $e)
	{
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
		"msg" =>  $e->getMessage()
              //  "msg" => 'Este registro no se puede borrar'
            ));
	}
        
         $this->setTemplate('eliminar');
      
  }  
  
  public function executeStorelistaProducto(sfWebRequest $request)
  {
        $co_solicitud = $this->getRequestParameter("co_solicitud");
        $iva = $this->getRequestParameter("iva");
                           
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        $c->addSelectColumn(Tb053DetalleComprasPeer::PRECIO_UNITARIO);
        $c->addSelectColumn(Tb053DetalleComprasPeer::NU_CANTIDAD);
        $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);  
        $c->addSelectColumn(Tb053DetalleComprasPeer::IN_EXENTO);  
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_REQUISICION);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->addJoin(Tb048ProductoPeer::CO_PRODUCTO, Tb053DetalleComprasPeer::CO_PRODUCTO);
        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD,$co_solicitud);
        $c->add(Tb053DetalleComprasPeer::CO_IVA_PRODUCTO,$iva);
        $c->add(Tb053DetalleComprasPeer::IN_CALCULAR_IVA,true);
               
        $cantidadTotal = Tb053DetalleComprasPeer::doCount($c);
        
        $c->addAscendingOrderByColumn(Tb048ProductoPeer::TX_PRODUCTO);
      
        
        $stmt = Tb048ProductoPeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            $reg["mo_total"]=0;
            $reg["cantidad"]=$reg["nu_cantidad"]-$this->getCantProductoRestante($co_solicitud,$reg["co_detalle_compras"]);
            if($reg["cantidad"]>0)
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));
      
      
      $this->setTemplate('storelista');
  }

  
  protected function getCantProductoRestante($co_solicitud,$co_detalle_compras){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn('coalesce(SUM('.Tb129DetalleFacturaPeer::CANT_PRODUCTO.'),0) as cant_total');
        $c->addJoin(Tb129DetalleFacturaPeer::CO_FACTURA, Tb045FacturaPeer::CO_FACTURA);
       // $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud); 
        //$c->add(Tb045FacturaPeer::CO_SOLICITUD,NULL, Criteria::ISNULL); 
        $c->add(Tb129DetalleFacturaPeer::CO_DETALLE_COMPRA,$co_detalle_compras); 

       // echo $c->toString(); exit();

        $stmt = Tb129DetalleFacturaPeer::doSelectStmt($c);
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $datos["cant_total"];
  }

  protected function getCantProductoRestanteValuacion($co_solicitud,$co_detalle_requisicion){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn('coalesce(SUM('.Tb129DetalleFacturaPeer::CANT_PRODUCTO.'),0) as cant_total');
        $c->addJoin(Tb129DetalleFacturaPeer::CO_FACTURA, Tb045FacturaPeer::CO_FACTURA);
       // $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud); 
        $c->add(Tb045FacturaPeer::CO_SOLICITUD,NULL, Criteria::ISNULL); 
        $c->add(Tb129DetalleFacturaPeer::CO_REQUISICION,$co_detalle_requisicion); 
        $stmt = Tb129DetalleFacturaPeer::doSelectStmt($c);
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $datos["cant_total"];
  }  
  
  protected function getStatusODP($co_odp){
        $c = new Criteria();
        $c->add(Tb060OrdenPagoPeer::CO_ORDEN_PAGO,$co_odp);        
        $stmt = Tb060OrdenPagoPeer::doSelectStmt($c);
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $datos["in_pagado"];
    }
    
    public function executeStorelistaotra(sfWebRequest $request)
    {
        $paginar      =   $this->getRequestParameter("paginar");            
        $co_compra    =   $this->getRequestParameter("co_compra");
        $co_solicitud = $this->getRequestParameter("co_solicitud");
        
        
        $c = new Criteria();   
        
        if($co_compra!=''){
            $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
            $c->add(Tb045FacturaPeer::CO_COMPRA,$co_compra);   
        }

        if($co_solicitud!=''){
            $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
            $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud,Criteria::NOT_EQUAL); 
        }
        
        $cantidadTotal = Tb045FacturaPeer::doCount($c);
        
        $c->addAscendingOrderByColumn(Tb045FacturaPeer::CO_COMPRA);
            
        $stmt = Tb045FacturaPeer::doSelectStmt($c);
        
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){

            if($reg["fe_emision"]!=''){
                list($anio,$mes,$dia) = explode("-",$reg["fe_emision"]);
                $reg["fe_emision"] = $dia.'-'.$mes.'-'.$anio;
            }
            
            $reg["estatus"] = $this->getStatusODP($reg["co_odp"]);
            
            $registros[] = $reg;
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
    $paginar      =   $this->getRequestParameter("paginar");            
    $co_compra    =   $this->getRequestParameter("co_compra");
    $co_solicitud = $this->getRequestParameter("co_solicitud");
    
    
    $c = new Criteria();   
    
    if($co_compra!=''){
        $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        $c->add(Tb045FacturaPeer::CO_COMPRA,$co_compra);   
    }

    if($co_solicitud!=''){
        $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud); 
    }
    
    $cantidadTotal = Tb045FacturaPeer::doCount($c);
    
    $c->addAscendingOrderByColumn(Tb045FacturaPeer::CO_COMPRA);
        
    $stmt = Tb045FacturaPeer::doSelectStmt($c);
    
    while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){

        if($reg["fe_emision"]!=''){
            list($anio,$mes,$dia) = explode("-",$reg["fe_emision"]);
            $reg["fe_emision"] = $dia.'-'.$mes.'-'.$anio;
        }
        
        $reg["estatus"] = $this->getStatusODP($reg["co_odp"]);
        
        $registros[] = $reg;
    }


    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

       
    public function executeStorefkcoivafactura(sfWebRequest $request){
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb043IvaFacturaPeer::NU_VALOR);
        $stmt = Tb043IvaFacturaPeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
            ));
        $this->setTemplate('store');
    }
    
    
    public function executeStorelistamateriales(sfWebRequest $request) {
       
        $co_solicitud   =   $this->getRequestParameter("co_solicitud");
                       
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb051DetalleRequisionProductoPeer::CO_DETALLE_REQUISICION);
        $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        $c->addSelectColumn(Tb051DetalleRequisionProductoPeer::NU_CANTIDAD);
        $c->addSelectColumn(Tb057UnidadProductoPeer::TX_UNIDAD_PRODUCTO);
        
        $c->addJoin(Tb051DetalleRequisionProductoPeer::CO_UNIDAD_PRODUCTO, Tb057UnidadProductoPeer::CO_UNIDAD_PRODUCTO);
        $c->addJoin(Tb051DetalleRequisionProductoPeer::CO_PRODUCTO, Tb048ProductoPeer::CO_PRODUCTO);
        $c->addJoin(Tb051DetalleRequisionProductoPeer::CO_REQUISICION,  Tb039RequisicionesPeer::CO_REQUISICION);
        $c->add(Tb039RequisicionesPeer::CO_SOLICITUD,$co_solicitud);
               
        $cantidadTotal = Tb051DetalleRequisionProductoPeer::doCount($c);
        
        $c->addAscendingOrderByColumn(Tb048ProductoPeer::TX_PRODUCTO);
      
        
        $stmt = Tb048ProductoPeer::doSelectStmt($c);
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
    
        
    public function executeVerificiacionPrestacionesSociales(sfWebRequest $request)
    {   
      $codigo = $this->getRequestParameter("co_solicitud");
      if($codigo!=''||$codigo!=null){
          $c = new Criteria();
          $c->add(Tb191PrestacionSocialPeer::CO_SOLICITUD,$codigo);
          $stmt = Tb191PrestacionSocialPeer::doSelectStmt($c);
          $campos = $stmt->fetch(PDO::FETCH_ASSOC);
  
          $c_compra = new Criteria();
          $c_compra->add(Tb052ComprasPeer::CO_SOLICITUD,$codigo);
          $stmt_compra = Tb052ComprasPeer::doSelectStmt($c_compra);
          $campos_compra = $stmt_compra->fetch(PDO::FETCH_ASSOC);
  
          $this->data = json_encode(array(
                              "id"     => $campos["id"],
                              "in_activo"     => $campos["in_activo"],
                              "created_at"     => $campos["created_at"],
                              "updated_at"     => $campos["updated_at"],
                              //"co_solicitud"     => $campos["co_solicitud"],
                              "co_solicitud"     => $this->getRequestParameter("co_solicitud"),
                              "co_usuario"     => $campos["co_usuario"],
                              "co_documento"     => $campos["co_documento"],
                              "nu_documento"     => $campos["nu_documento"],
                              "nb_persona"     => $campos["nb_persona"],
                              "ap_persona"     => $campos["ap_persona"],
                              "co_tipo_trabajador"     => $campos["co_tipo_trabajador"],
                              "co_ejecutor"     => $campos["co_ejecutor"],
                              "co_situacion_trabajador"     => $campos["co_situacion_trabajador"],
                              "fe_ingreso"     => $campos["fe_ingreso"],
                              "fe_egreso"     => $campos["fe_egreso"],
                              "fe_movimiento"     => $campos["fe_movimiento"],
                              "de_observacion"     => $campos["de_observacion"],
                              "mo_pago"     => $campos["mo_pago"],
                              "co_proveedor"     => $campos["co_proveedor"],
                              "co_compras"     => $campos_compra["co_compras"],
                      ));
      }else{
          $this->data = json_encode(array(
                              "id"     => "",
                              "in_activo"     => "",
                              "created_at"     => "",
                              "updated_at"     => "",
                              "co_solicitud"     => $this->getRequestParameter("co_solicitud"),
                              "co_usuario"     => "",
                              "co_documento"     => "",
                              "nu_documento"     => "",
                              "nb_persona"     => "",
                              "ap_persona"     => "",
                              "co_tipo_trabajador"     => "",
                              "co_ejecutor"     => "",
                              "co_situacion_trabajador"     => "",
                              "fe_ingreso"     => "",
                              "fe_egreso"     => "",
                              "fe_movimiento"     => "",
                              "de_observacion"     => "",
                              "mo_pago"     => "",
                      ));
      }
    }


    public function executeStorelistaCuentaContable(sfWebRequest $request) {
       
      $co_solicitud   =   $this->getRequestParameter("co_solicitud");
                     
      $con = Propel::getConnection();

      $paginar    =   $this->getRequestParameter("paginar");
      $limit      =   $this->getRequestParameter("limit",20);
      $start      =   $this->getRequestParameter("start",0);
  
      $sql = 'select distinct tb024.tx_cuenta as nu_cuenta, 
              coalesce(tb061.mo_haber, 0) as mo_credito,
              coalesce(tb061.mo_debe, 0) as mo_debito,
              co_tipo_asiento
      from   tb026_solicitud as tb026  
      left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud 
      left join tb008_proveedor as tb008 on tb008.co_proveedor = tb052.co_proveedor  
      left join tb061_asiento_contable as tb061 on tb026.co_solicitud = tb061.co_solicitud 
      left join tb060_orden_pago as tb060 on tb060.co_solicitud = tb061.co_solicitud 
      left join tb024_cuenta_contable as tb024 on tb024.co_cuenta_contable = tb061.co_cuenta_contable  
      where ((tb061.co_tipo_asiento=2 and mo_haber is not null) or (tb061.co_tipo_asiento=2 and mo_debe is not null)) 
      and tb061.co_solicitud = :co_solicitud';
  
      $stmt2 = $con->prepare($sql);
      $stmt2->execute(
        array(
          ':co_solicitud' => $co_solicitud
          )
      );
  
      while($reg2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
          $registros2[] = $reg2;
      }
  
      $sql.= " order by co_tipo_asiento desc LIMIT ".$limit." OFFSET ".$start;
  
      $data = '';
      $stmt = $con->prepare($sql);
      $stmt->execute(
        array(
          ':co_solicitud' => $co_solicitud
          )
      );
  
      while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
          $registros[] = $reg;
      }
  
      $this->data = json_encode(array(
          "success"   =>  true,
          "total"     =>  count($registros2),
          "data"      =>  $registros
      ));
  
      $this->setTemplate('store');

  }

  public function executeStorelistaCategoriaPresupuestaria(sfWebRequest $request) {
       
    $co_solicitud   =   $this->getRequestParameter("co_solicitud");

    $co_ruta = Tb030RutaPeer::getCoRuta($co_solicitud);
                   
    $con = Propel::getConnection();

    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);

    $sql = "select tb085.co_categoria,
            anio as nu_anio,
            nu_ejecutor as nu_ue,
            tb080.nu_sector||'.'||nu_proyecto_ac as nu_pac,
            nu_accion_especifica as nu_ae,
            nu_pa as nu_pa,                         
            nu_ge as nu_ge,
            nu_es as nu_es,
            nu_se as nu_se,
            nu_sse as nu_sse,
            nu_fi as nu_fi,
            sum(monto) as mo_partida
        from  tb052_compras as tb052 
        left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras 
        left join tb085_presupuesto as tb085 on tb085.id = tb053.co_presupuesto
        left join tb084_accion_especifica as tb084 on tb085.id_tb084_accion_especifica = tb084.id
        left join tb083_proyecto_ac as tb083 on tb084.id_tb083_proyecto_ac = tb083.id
        left join tb082_ejecutor as tb082 on tb082.id = tb083.id_tb082_ejecutor
        left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud                               
        left join tb080_sector as tb080 on tb080.id = tb083.id_tb080_sector                 
        where tb030.co_ruta = :co_ruta and tb053.in_presupuesto is true
        group by 1,2,3,4,5,6,7,8,9,10,11";

    $stmt2 = $con->prepare($sql);
    $stmt2->execute(
      array(
        ':co_ruta' => $co_ruta
        )
    );

    while($reg2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
        $registros2[] = $reg2;
    }

    $sql.= " order by 1 ASC LIMIT ".$limit." OFFSET ".$start;

    $data = '';
    $stmt = $con->prepare($sql);
    $stmt->execute(
      array(
        ':co_ruta' => $co_ruta
        )
    );

    while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = $reg;
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  count($registros2),
        "data"      =>  $registros
    ));

    $this->setTemplate('store');

  }

  public function executeProcesarPrestacionSocial(sfWebRequest $request)
  {

    $tb191_prestacion_socialForm = $this->getRequestParameter('tb191_prestacion_social');
   
    $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb191_prestacion_socialForm["co_solicitud"]));
    $ruta->setInCargarDato(true)->save($con);
    Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

    $this->data = json_encode(array(
      "success" => true,
      "msg" => 'Prestacion verificada exitosamente!'
    ));

  }

}
