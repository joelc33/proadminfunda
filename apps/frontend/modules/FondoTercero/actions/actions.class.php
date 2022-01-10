<?php

/**
 * FondoTercero actions.
 *
 * @package    gobel
 * @subpackage FondoTercero
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class FondoTerceroActions extends autoFondoTerceroActions
{
    
  public function executeIndex(sfWebRequest $request)
  {
    $codigo =  $this->getRequestParameter("co_solicitud");
    $co_tipo_solicitud =  $this->getRequestParameter("co_tipo_solicitud");
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
    $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
    $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
    $c->addSelectColumn(Tb069FondoTerceroPeer::CO_FONDO_TERCERO);
    $c->addSelectColumn(Tb069FondoTerceroPeer::NU_DECLARACION);
    $c->addSelectColumn(Tb069FondoTerceroPeer::FE_EMISION);
    $c->addSelectColumn(Tb069FondoTerceroPeer::TX_OBSERVACION);
    $c->addSelectColumn(Tb069FondoTerceroPeer::MO_PAGAR);
    $c->add(Tb026SolicitudPeer::CO_SOLICITUD,$codigo);
    $c->addJoin(Tb069FondoTerceroPeer::CO_SOLICITUD, Tb026SolicitudPeer::CO_SOLICITUD);
    $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb026SolicitudPeer::CO_PROVEEDOR);
    $stmt = Tb069FondoTerceroPeer::doSelectStmt($c);
    $campos = $stmt->fetch(PDO::FETCH_ASSOC);

    if($campos["co_proveedor"]!=''){

        $this->data = json_encode(array(
                            "co_fondo_tercero"   => $campos["co_fondo_tercero"],
                            "co_proveedor"       => $campos["co_proveedor"],
                            "co_solicitud"       => $campos["co_solicitud"],
                            "co_documento"       => $campos["co_documento"],
                            "tx_rif"             => $campos["tx_rif"],
                            "tx_razon_social"    => $campos["tx_razon_social"],
                            "tx_direccion"       => $campos["tx_direccion"],
                            "nu_declaracion"     => $campos["nu_declaracion"],
                            "fe_emision"         => $campos["fe_emision"],
                            "tx_observacion"     => $campos["tx_observacion"],
                            "mo_pagar"           => $campos["mo_pagar"],
                            "co_tipo_solicitud"  => $co_tipo_solicitud,
                            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
                            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre')
                            
                            
                    ));
    }else{
        
        
        $this->data = json_encode(array(
                            "co_fondo_tercero"   => "",
                            "co_proveedor"         => "",
                            "co_solicitud"         => $codigo,
                            "co_documento"       => "",
                            "tx_rif"     => "",
                            "tx_razon_social"       => "",
                            "tx_direccion"  => "",
                            "nu_declaracion"     => "",            
                            "fe_emision"         => "",
                            "tx_observacion"     => "",   
                            "mo_pagar"           => "",
                            "co_tipo_solicitud"  => $co_tipo_solicitud,
                            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
                            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre')         
                    ));
    }

  }

  public function executeLote(sfWebRequest $request)
  {
    $codigo =  $this->getRequestParameter("co_solicitud");
    $co_tipo_solicitud =  $this->getRequestParameter("co_tipo_solicitud");

    $this->data = json_encode(array(
        "co_fondo_tercero"   => "",
        "co_proveedor"         => "",
        "co_solicitud"         => $codigo,
        "co_documento"       => "",
        "tx_rif"     => "",
        "tx_razon_social"       => "",
        "tx_direccion"  => "",
        "nu_declaracion"     => "",            
        "fe_emision"         => "",
        "tx_observacion"     => "",   
        "mo_pagar"           => "",
        "co_tipo_solicitud"  => $co_tipo_solicitud,            
    ));

  }
  
  public function executeAgregarPago(sfWebRequest $request)
  {
          $co_proveedor =  $this->getRequestParameter("co_proveedor");
          $this->data = json_encode(
              array(
                  "co_proveedor" => $co_proveedor,
                  "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
                  "fe_fin"   => $this->getUser()->getAttribute('fe_cierre')
                )
            );
  
  }
        
  public function executeGuardar(sfWebRequest $request)
  {

    $codigo = $this->getRequestParameter("co_fondo_tercero");
    $json_pagos  = $this->getRequestParameter("json_pagos");
    $tb069_fondo_terceroForm = $this->getRequestParameter('fondo');

    
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb069_fondo_tercero = Tb069FondoTerceroPeer::retrieveByPk($codigo);
     }else{
         $tb069_fondo_tercero = new Tb069FondoTercero();
     }
     try
      { 
        $con->beginTransaction();
       
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb069_fondo_tercero->setCoSolicitud($tb069_fondo_terceroForm["co_solicitud"]);
                                                        
        /*Campo tipo BIGINT */
        $tb069_fondo_tercero->setCoProveedor($tb069_fondo_terceroForm["co_proveedor"]);

        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb069_fondo_terceroForm["fecha"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb069_fondo_tercero->setFeEmision($fecha);
       
        /*Campo tipo VARCHAR */
        $tb069_fondo_tercero->setNuDeclaracion($tb069_fondo_terceroForm["nu_declaracion"]);

        /*Campo tipo VARCHAR */
        $tb069_fondo_tercero->setTxObservacion($tb069_fondo_terceroForm["tx_observacion"]);
        
        $tb069_fondo_tercero->setMoPagar($tb069_fondo_terceroForm["mo_pagar"]);
        
        /*Campo tipo BIGINT */
        $tb069_fondo_tercero->setCoUsuario($this->getUser()->getAttribute('codigo'));
                                                                
        /*CAMPOS*/
        $tb069_fondo_tercero->save($con);
        
        $delete = new Criteria();
        $delete->add(Tb062LiquidacionPagoPeer::CO_SOLICITUD, $tb069_fondo_terceroForm["co_solicitud"]);
        BasePeer::doDelete($delete, $con);
        
        $listaPagos  = json_decode($json_pagos,true);
        $monto = 0;
        foreach($listaPagos  as $pagosForm){
          
                if($pagosForm["co_detalle_fondo"]==''){
                    
                    $Tb041TipoRetencion = Tb041TipoRetencionPeer::retrieveByPK($pagosForm["co_tipo_retencion"]);
        
                    list($dia,$mes,$anio) = explode("/", $pagosForm["fe_desde"]);
                    $fe_inicio = $anio.'-'.$mes.'-'.$dia;

                    list($dia,$mes,$anio) = explode("/", $pagosForm["fe_hasta"]);
                    $fe_fin = $anio.'-'.$mes.'-'.$dia;
                    
                    
                    $registros = $this->getMontoDisponible($Tb041TipoRetencion->getCoCuentaContable(),$fe_inicio,$fe_fin,$pagosForm["co_tipo_retencion"]);
                    
                    if($registros['total']>0){                    
                        $tb070_detalle_fondo = new Tb070DetalleFondo();
                        $tb070_detalle_fondo->setCoFondoTercero($tb069_fondo_tercero->getCoFondoTercero());                                        
                        $tb070_detalle_fondo->setCoTipoRetencion($pagosForm["co_tipo_retencion"]);
                        $tb070_detalle_fondo->setMonto($pagosForm["monto"]);
                        $tb070_detalle_fondo->setTxObservacion($pagosForm["tx_observacion"]);
                        $tb070_detalle_fondo->setCoUsuario($this->getUser()->getAttribute('codigo'));
                        $tb070_detalle_fondo->setFeDesde($fe_inicio);
                        $tb070_detalle_fondo->setFeHasta($fe_fin);
                        $tb070_detalle_fondo->save($con);
                        

                        if($pagosForm["co_tipo_retencion"]==88) {

                        $c = new Criteria();
                        $c->clearSelectColumns();
                        $c->setDistinct();
                        $c->addSelectColumn(Tb046FacturaRetencionPeer::CO_FACTURA_RETENCION);
                        $c->addJoin(Tb060OrdenPagoPeer::CO_SOLICITUD, Tb046FacturaRetencionPeer::CO_SOLICITUD);
                        //$c->add(Tb046FacturaRetencionPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                        //$c->add(Tb060OrdenPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                        $c->add(Tb046FacturaRetencionPeer::CO_TIPO_RETENCION,$pagosForm["co_tipo_retencion"]);

                        $c->add(Tb060OrdenPagoPeer::FE_PAGO,$fe_inicio, Criteria::GREATER_EQUAL);
                        $c->addAnd(Tb060OrdenPagoPeer::FE_PAGO,$fe_fin, Criteria::LESS_EQUAL);
                //        
                        //echo $c->toString(); exit();
                        $stmt = Tb046FacturaRetencionPeer::doSelectStmt($c);            

                        }else{   

                        if($pagosForm["co_tipo_retencion"]==92) {            

                        $c = new Criteria();
                        $c->clearSelectColumns();
                        $c->setDistinct();
                        $c->addSelectColumn(Tb046FacturaRetencionPeer::CO_FACTURA_RETENCION);
                        $c->addJoin(Tb060OrdenPagoPeer::CO_SOLICITUD, Tb046FacturaRetencionPeer::CO_SOLICITUD);
                        $c->addJoin(Tb062LiquidacionPagoPeer::CO_ODP, Tb060OrdenPagoPeer::CO_ORDEN_PAGO);
                        $c->addJoin(Tb063PagoPeer::CO_LIQUIDACION_PAGO, Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
                        $c->addJoin(Tb045FacturaPeer::CO_FACTURA, Tb046FacturaRetencionPeer::CO_FACTURA);
                        $c->add(Tb060OrdenPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                        $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                        $c->add(Tb046FacturaRetencionPeer::CO_TIPO_RETENCION,$pagosForm["co_tipo_retencion"]);

                        $c->add(Tb063PagoPeer::FE_PAGO,$fe_inicio, Criteria::GREATER_EQUAL);
                        $c->addAnd(Tb063PagoPeer::FE_PAGO,$fe_fin, Criteria::LESS_EQUAL);
                        //echo $c->toString(); exit();

                        $stmt = Tb046FacturaRetencionPeer::doSelectStmt($c);

                        }else{

                        $c = new Criteria();
                        $c->clearSelectColumns();
                        $c->setDistinct();
                        $c->addSelectColumn(Tb046FacturaRetencionPeer::CO_FACTURA_RETENCION);
                        $c->addJoin(Tb060OrdenPagoPeer::CO_SOLICITUD, Tb046FacturaRetencionPeer::CO_SOLICITUD);
                        $c->addJoin(Tb062LiquidacionPagoPeer::CO_ODP, Tb060OrdenPagoPeer::CO_ORDEN_PAGO);
                        $c->addJoin(Tb063PagoPeer::CO_LIQUIDACION_PAGO, Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
                        $c->add(Tb060OrdenPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                        $c->add(Tb046FacturaRetencionPeer::CO_TIPO_RETENCION,$pagosForm["co_tipo_retencion"]);

                        $c->add(Tb063PagoPeer::FE_PAGO,$fe_inicio, Criteria::GREATER_EQUAL);
                        $c->addAnd(Tb063PagoPeer::FE_PAGO,$fe_fin, Criteria::LESS_EQUAL);
                        //echo $c->toString(); exit();

                        $stmt = Tb046FacturaRetencionPeer::doSelectStmt($c);           
                        }
                        }                        
    
                        while($registros = $stmt->fetch(PDO::FETCH_ASSOC)){
//                        var_dump($registros);   
//                        exit();
                        $tb204_retencion_fondo_tercero = new Tb204RetencionFondoTercero();
                        $tb204_retencion_fondo_tercero->setCoFacturaRetencion($registros["co_factura_retencion"]);                                        
                        $tb204_retencion_fondo_tercero->setCoDetalleFondo($tb070_detalle_fondo->getCoDetalleFondo());
                        $tb204_retencion_fondo_tercero->setcoSolicitud($tb069_fondo_terceroForm["co_solicitud"]);
                        $tb204_retencion_fondo_tercero->save($con);                        

                        }        


                        $wherec = new Criteria();
                        $wherec->add(Tb061AsientoContablePeer::CO_CUENTA_CONTABLE,$Tb041TipoRetencion->getCoCuentaContable());
                        $wherec->add(Tb061AsientoContablePeer::CREATED_AT,$fe_inicio, Criteria::GREATER_EQUAL);
                        $wherec->addAnd(Tb061AsientoContablePeer::CREATED_AT,$fe_fin, Criteria::LESS_EQUAL);


                        $updc = new Criteria();
                        $updc->add(Tb061AsientoContablePeer::CO_SOLICITUD_FONDO_TERCERO, $tb069_fondo_terceroForm["co_solicitud"]);

                        BasePeer::doUpdate($wherec, $updc, $con);
                        
                        $wherec = new Criteria();
                        $wherec->add(Tb134MovimientoContablePeer::CO_CUENTA_CONTABLE,$Tb041TipoRetencion->getCoCuentaContable());
                        $wherec->add(Tb134MovimientoContablePeer::FE_MOVIMIENTO,$fe_inicio, Criteria::GREATER_EQUAL);
                        $wherec->addAnd(Tb134MovimientoContablePeer::FE_MOVIMIENTO,$fe_fin, Criteria::LESS_EQUAL);

                        $updc = new Criteria();
                        $updc->add(Tb134MovimientoContablePeer::CO_SOLICITUD, $tb069_fondo_terceroForm["co_solicitud"]);
                        $updc->add(Tb134MovimientoContablePeer::CO_USUARIO, $this->getUser()->getAttribute('codigo'));
                        $updc->add(Tb134MovimientoContablePeer::IN_PAGADO, true);
                        
                        BasePeer::doUpdate($wherec, $updc, $con);
                    }
                    
                    
            }      
            
            $monto+=$pagosForm["monto"];
             
        }
        
        $Tb062LiquidacionPago = new Tb062LiquidacionPago();
        $Tb062LiquidacionPago->setCoSolicitud($tb069_fondo_terceroForm["co_solicitud"])
                       ->setFeEmision(date('Y-m-d'))
                       //->setNuAnio(date('Y'))
                       ->setNuAnio( $this->getUser()->getAttribute('ejercicio'))
                       ->setMoPagar($monto)
                       ->setMoPendiente($monto)
                       ->setMoPagado(0)
                       ->setCoTipoSolicitud($tb069_fondo_terceroForm["co_tipo_solicitud"])
                       ->save($con);      
        

                
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb069_fondo_terceroForm["co_solicitud"]));
        $ruta->setInCargarDato(true)->save($con);
        
        $tb026_solicitud = Tb026SolicitudPeer::retrieveByPK($tb069_fondo_terceroForm["co_solicitud"]);
        $tb026_solicitud->setCoProveedor($tb069_fondo_terceroForm["co_proveedor"])->save($con);
        
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
        
    public function executeEliminar(sfWebRequest $request)
    {
	$codigo = $this->getRequestParameter("co_detalle_fondo");
        $co_solicitud = $this->getRequestParameter("co_solicitud");
        
        $co_fondo_tercero = $this->getRequestParameter("co_fondo_tercero");
	$con = Propel::getConnection();
	try
	{ 
            $con->beginTransaction();
            /*CAMPOS*/
            $tb070_detalle_fondo = Tb070DetalleFondoPeer::retrieveByPk($codigo);	
            
            $Tb041TipoRetencion = Tb041TipoRetencionPeer::retrieveByPK($tb070_detalle_fondo->getCoTipoRetencion());
            
            $tb070_detalle_fondo->delete($con);
            
            $wherec = new Criteria();
            $wherec->add(Tb061AsientoContablePeer::CO_CUENTA_CONTABLE,$Tb041TipoRetencion->getCoCuentaContable());
            $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD_FONDO_TERCERO,$co_solicitud);

            $updc = new Criteria();
            $updc->add(Tb061AsientoContablePeer::CO_SOLICITUD_FONDO_TERCERO, NULL);

            BasePeer::doUpdate($wherec, $updc, $con);
            
            $wheredetalle = new Criteria();
            $wheredetalle->add(Tb204RetencionFondoTerceroPeer::CO_DETALLE_FONDO, $codigo);
            BasePeer::doDelete($wheredetalle, $con);            
            
        
            $c = new Criteria();
            $c->add(Tb070DetalleFondoPeer::CO_FONDO_TERCERO,$co_fondo_tercero);
            $cantidadPagos = Tb070DetalleFondoPeer::doCount($c);
            if($cantidadPagos==0){
                $c1 = new Criteria();
                $c1->addSelectColumn(Tb069FondoTerceroPeer::CO_SOLICITUD);
                $c1->add(Tb069FondoTerceroPeer::CO_FONDO_TERCERO,$co_fondo_tercero);
                $stmt = Tb069FondoTerceroPeer::doSelectStmt($c1);
                $campos = $stmt->fetch(PDO::FETCH_ASSOC);

                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($campos["co_solicitud"]));
                $ruta->setInCargarDato(FALSE)->save($con);
            }
            $con->commit();
		$this->data = json_encode(array(
			    "success" => true,
			    "msg" => 'Registro Borrado con exito!'
		));
	
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
  
  public function executeStorelistadetallefondo(sfWebRequest $request) {
       
        $co_fondo_tercero   =   $this->getRequestParameter("co_fondo_tercero");
        $limit      =   $this->getRequestParameter("limit",8);
        $start      =   $this->getRequestParameter("start",0);
                       
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb070DetalleFondoPeer::CO_DETALLE_FONDO);
        $c->addSelectColumn(Tb070DetalleFondoPeer::CO_FONDO_TERCERO);
        $c->addSelectColumn(Tb070DetalleFondoPeer::CO_TIPO_RETENCION);
        $c->addSelectColumn(Tb070DetalleFondoPeer::FE_DESDE);
        $c->addSelectColumn(Tb070DetalleFondoPeer::FE_HASTA);
        $c->addSelectColumn(Tb041TipoRetencionPeer::TX_TIPO_RETENCION);
        $c->addSelectColumn(Tb070DetalleFondoPeer::MONTO);
        $c->addSelectColumn(Tb070DetalleFondoPeer::TX_OBSERVACION);
        $c->addJoin(Tb070DetalleFondoPeer::CO_TIPO_RETENCION, Tb041TipoRetencionPeer::CO_TIPO_RETENCION);
        $c->add(Tb070DetalleFondoPeer::CO_FONDO_TERCERO,$co_fondo_tercero);
               
        $cantidadTotal = Tb070DetalleFondoPeer::doCount($c);
        //$c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb070DetalleFondoPeer::CO_DETALLE_FONDO);
        
        $stmt = Tb070DetalleFondoPeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            list($anio,$mes,$dia) = explode("-", $reg["fe_desde"]);
            $reg["fe_desde"] = $dia.'/'.$mes.'/'.$anio;

            list($anio,$mes,$dia) = explode("-", $reg["fe_hasta"]);
            $reg["fe_hasta"] = $dia.'/'.$mes.'/'.$anio;
            
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));
        
        $this->setTemplate('store');
    }  
        
    public function executeStorefkcoclaseretencion(sfWebRequest $request){
       
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb072ClaseRetencionPeer::CO_CLASE_RETENCION);
        $stmt = Tb072ClaseRetencionPeer::doSelectStmt($c);
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
    
    public function executeStorefkcotiporetencion(sfWebRequest $request){
        $json_tipo_retencion  = $this->getRequestParameter("json_tipo_retencion");
        $co_clase_retencion  = $this->getRequestParameter("co_clase_retencion");
        $co_proveedor  = $this->getRequestParameter("co_proveedor");
        $listaTipoRetencion  = json_decode($json_tipo_retencion,true);
        $array_tipo_retencion = array();
        $i=0;
        foreach($listaTipoRetencion  as $tipo_retencionForm){
           $array_tipo_retencion[$i] = $tipo_retencionForm["co_tipo_retencion"]; 
           $i++;
        }
        
        $c = new Criteria();
        $c->add(Tb041TipoRetencionPeer::CO_TIPO_RETENCION,$array_tipo_retencion,  Criteria::NOT_IN);
        $c->add(Tb041TipoRetencionPeer::CO_CLASE_RETENCION,$co_clase_retencion);
        $c->add(Tb041TipoRetencionPeer::IN_ACTIVO,TRUE);
        $c->add(Tb071RetencionProveedorPeer::CO_PROVEEDOR,$co_proveedor);
        $c->addAscendingOrderByColumn(Tb041TipoRetencionPeer::CO_TIPO_RETENCION);
        $c->addJoin(Tb041TipoRetencionPeer::CO_TIPO_RETENCION, Tb071RetencionProveedorPeer::CO_TIPO_RETENCION);
        $stmt = Tb041TipoRetencionPeer::doSelectStmt($c);
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
    
    public function executeStorefkcodocumento(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb007DocumentoPeer::doSelectStmt($c);
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
    
    public function executeVerificarProveedor(sfWebRequest $request)
    {

      $co_documento        = $this->getRequestParameter('co_documento');
      $tx_rif        = $this->getRequestParameter('tx_rif');

      $c = new Criteria();
      $c->add(Tb008ProveedorPeer::CO_DOCUMENTO,$co_documento);
      $c->add(Tb008ProveedorPeer::TX_RIF,$tx_rif);
      $stmt = Tb008ProveedorPeer::doSelectStmt($c);

      $registros = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->data = json_encode(array(
          "success"   => true,
          "data"      => $registros
      ));
      $this->setTemplate('store');

    }
  
    public function executeCalcularDisponibilidad()
    {
  
        $fe_desde           = $this->getRequestParameter('fe_desde');
        $fe_hasta           = $this->getRequestParameter('fe_hasta');
        $co_tipo_retencion  = $this->getRequestParameter('co_tipo_retencion');
        
        $Tb041TipoRetencion = Tb041TipoRetencionPeer::retrieveByPK($co_tipo_retencion);
        
        
        
        list($dia,$mes,$anio) = explode("/", $fe_desde);
        $fe_inicio = $anio.'-'.$mes.'-'.$dia;
        
        list($dia,$mes,$anio) = explode("/", $fe_hasta);
        $fe_fin = $anio.'-'.$mes.'-'.$dia;
                      
        $registros = $this->getMontoDisponible($Tb041TipoRetencion->getCoCuentaContable(),$fe_inicio,$fe_fin,$co_tipo_retencion);
              
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        $this->setTemplate('store');    
    }
    
    protected function getMontoDisponible($co_cuenta_contable,$fe_inicio,$fe_fin,$co_tipo_retencion){
//        $c = new Criteria();
//        $c->clearSelectColumns();
//        $c->addSelectColumn('coalesce(SUM('. Tb061AsientoContablePeer::MO_HABER.'),0) as total');
//        $c->add(Tb061AsientoContablePeer::CO_SOLICITUD_FONDO_TERCERO,NULL, Criteria::ISNULL);
//        $c->add(Tb061AsientoContablePeer::CO_CUENTA_CONTABLE,$co_cuenta_contable);
//        $c->add(Tb061AsientoContablePeer::CREATED_AT,$fe_inicio, Criteria::GREATER_EQUAL);
//        $c->addAnd(Tb061AsientoContablePeer::CREATED_AT,$fe_fin, Criteria::LESS_EQUAL);
//        
  
        if($fe_inicio>='2018-11-30'){
            
        if($co_tipo_retencion==88) {
            
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn('coalesce(SUM('.Tb046FacturaRetencionPeer::MO_RETENCION.'),0) as total');
        $c->addJoin(Tb060OrdenPagoPeer::CO_SOLICITUD, Tb046FacturaRetencionPeer::CO_SOLICITUD);
        //$c->add(Tb046FacturaRetencionPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        //$c->add(Tb060OrdenPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        $c->add(Tb046FacturaRetencionPeer::CO_TIPO_RETENCION,$co_tipo_retencion);
        
        $c->add(Tb060OrdenPagoPeer::FE_PAGO,$fe_inicio, Criteria::GREATER_EQUAL);
        $c->addAnd(Tb060OrdenPagoPeer::FE_PAGO,$fe_fin, Criteria::LESS_EQUAL);
//        
        //echo $c->toString(); exit();
        $stmt = Tb046FacturaRetencionPeer::doSelectStmt($c);

        $registros = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        return $registros;              
            
        }else{   

        if($co_tipo_retencion==92) {            
            
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn('coalesce(SUM('. Tb045FacturaPeer::NU_IVA_RETENCION.'),0) as total');
        $c->addJoin(Tb060OrdenPagoPeer::CO_SOLICITUD, Tb046FacturaRetencionPeer::CO_SOLICITUD);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_ODP, Tb060OrdenPagoPeer::CO_ORDEN_PAGO);
        $c->addJoin(Tb063PagoPeer::CO_LIQUIDACION_PAGO, Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
        $c->addJoin(Tb045FacturaPeer::CO_FACTURA, Tb046FacturaRetencionPeer::CO_FACTURA);
        $c->add(Tb060OrdenPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        $c->add(Tb046FacturaRetencionPeer::CO_TIPO_RETENCION,$co_tipo_retencion);
        
        $c->add(Tb063PagoPeer::FE_PAGO,$fe_inicio, Criteria::GREATER_EQUAL);
        $c->addAnd(Tb063PagoPeer::FE_PAGO,$fe_fin, Criteria::LESS_EQUAL);
        //echo $c->toString(); exit();
        
        $stmt = Tb046FacturaRetencionPeer::doSelectStmt($c);

        $registros = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $registros;
        }else{
          
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn('coalesce(SUM('. Tb046FacturaRetencionPeer::MO_RETENCION.'),0) as total');
        $c->addJoin(Tb060OrdenPagoPeer::CO_SOLICITUD, Tb046FacturaRetencionPeer::CO_SOLICITUD);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_ODP, Tb060OrdenPagoPeer::CO_ORDEN_PAGO);
        $c->addJoin(Tb063PagoPeer::CO_LIQUIDACION_PAGO, Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
        $c->add(Tb060OrdenPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        $c->add(Tb046FacturaRetencionPeer::CO_TIPO_RETENCION,$co_tipo_retencion);
        
        $c->add(Tb063PagoPeer::FE_PAGO,$fe_inicio, Criteria::GREATER_EQUAL);
        $c->addAnd(Tb063PagoPeer::FE_PAGO,$fe_fin, Criteria::LESS_EQUAL);
        //echo $c->toString(); exit();
        
        $stmt = Tb046FacturaRetencionPeer::doSelectStmt($c);

        $registros = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $registros;            
        }
        }
        }else{
            
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn('coalesce(SUM('.Tb046FacturaRetencionPeer::MO_RETENCION.'),0) as total');
        $c->addJoin(Tb060OrdenPagoPeer::CO_SOLICITUD, Tb046FacturaRetencionPeer::CO_SOLICITUD);
        //$c->add(Tb046FacturaRetencionPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        //$c->add(Tb060OrdenPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        $c->add(Tb046FacturaRetencionPeer::CO_TIPO_RETENCION,$co_tipo_retencion);
        
        $c->add(Tb060OrdenPagoPeer::FE_PAGO,$fe_inicio, Criteria::GREATER_EQUAL);
        $c->addAnd(Tb060OrdenPagoPeer::FE_PAGO,$fe_fin, Criteria::LESS_EQUAL);
//        
        //echo $c->toString(); exit();
        $stmt = Tb046FacturaRetencionPeer::doSelectStmt($c);

        $registros = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        return $registros;            
            
        }
        
    }
  
  
    
}
