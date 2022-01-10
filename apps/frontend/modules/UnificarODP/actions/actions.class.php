<?php

/**
 * UnificarODP actions.
 *
 * @package    gobel
 * @subpackage UnificarODP
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class UnificarODPActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
        //$codigo = $this->getRequestParameter("codigo");
    $codigo = $this->getRequestParameter("co_solicitud");
    
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
    $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
    $c->addSelectColumn(Tb163UnificacionOdpPeer::CO_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb163UnificacionOdpPeer::CO_UNIFICACION_ODP);
    $c->addJoin(Tb163UnificacionOdpPeer::CO_SOLICITUD, Tb026SolicitudPeer::CO_SOLICITUD);
    $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
    $c->add(Tb163UnificacionOdpPeer::CO_SOLICITUD,$codigo);
    $stmt = Tb008ProveedorPeer::doSelectStmt($c);
    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $this->data = json_encode(array(
                            "co_solicitud"      => $this->getRequestParameter('co_solicitud'),
                            "co_proveedor"      => $campos["co_proveedor"],
                            "co_documento"      => $campos["co_documento"],
                            "tx_razon_social"   => $campos["tx_razon_social"],
                            "tx_rif"            => $campos["tx_rif"],
                            "tx_direccion"      => $campos["tx_direccion"],
                            "co_tipo_solicitud" => $campos["co_tipo_solicitud"],
                            "co_unificacion_odp"=> ($campos["co_unificacion_odp"]==NULL)?'':$campos["co_unificacion_odp"]
                    ));
    
  }
  
  protected function getTotalCompra($params,$tipo){
      
            $c = new Criteria();
            $c->clearSelectColumns();
            
            if($tipo == 'monto_iva')            
            $c->addSelectColumn('SUM('.Tb052ComprasPeer::MONTO_IVA.') as total');            
            
            if($tipo == 'monto_sub_total')            
            $c->addSelectColumn('SUM('.Tb052ComprasPeer::MONTO_SUB_TOTAL.') as total');   
             
            if($tipo == 'monto_total')            
            $c->addSelectColumn('SUM('.Tb052ComprasPeer::MONTO_TOTAL.') as total');           
            
            
            $c->add(Tb052ComprasPeer::CO_SOLICITUD,$params, Criteria::IN);
            $stmt = Tb052ComprasPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
      
            return $campos["total"];
  }
  
  
  protected function getCoSolicitud($codigo){
      
            $c = new Criteria();
            $c->add(Tb052ComprasPeer::CO_COMPRAS,$codigo);
            $stmt = Tb052ComprasPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
      
            return $campos["co_solicitud"];
  }


  public function executeGuardar(sfWebRequest $request){
      
        $json_solicitud    = $this->getRequestParameter("json_solicitud");
        $co_solicitud      = $this->getRequestParameter("co_solicitud");
        $co_tipo_solicitud = $this->getRequestParameter("cod_tipo_solicitud");
        $co_proveedor      = $this->getRequestParameter("cod_proveedor");
                
        $array = array();
        $array = explode(",",$json_solicitud);
        
	$con = Propel::getConnection();
	try
	{ 
                $con->beginTransaction();
                $monto_iva       = $this->getTotalCompra($array,'monto_iva');
                $monto_sub_total = $this->getTotalCompra($array,'monto_sub_total');
                $monto_total     = $this->getTotalCompra($array,'monto_total');
                
                $tb163_unificacion_odp = new Tb163UnificacionOdp();
                $tb163_unificacion_odp->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                      ->setCoSolicitud($co_solicitud)
                                      ->setCoTipoSolicitud($co_tipo_solicitud)
                                      ->save($con);
                
                foreach ($array as $key => $value) {                      

                    $tb164_lista_unificacion = new Tb164ListaUnificacion();
                    $tb164_lista_unificacion->setCoSolicitudOdp($value)
                                            ->setCoUnificacionOdp($tb163_unificacion_odp->getCoUnificacionOdp())
                                            ->save($con);
                } 
                                
                $tb052_compras = new Tb052Compras();
                $tb052_compras->setCoUsuario($this->getUser()->getAttribute('codigo'));                                                                
                //$tb052_compras->setFechaCompra(date("Y-m-d"));
                if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
                    $tb052_compras->setFechaCompra($this->getUser()->getAttribute('fe_cierre')); 
                }else{
                    $tb052_compras->setFechaCompra(date("Y-m-d")); 
                }  
                $tb052_compras->setTxObservacion('UNIFICACIÓN DE ORDEN DE PAGO');
                $tb052_compras->setCoSolicitud($co_solicitud);        
                $tb052_compras->setCoTipoSolicitud($co_tipo_solicitud);                                                        
                //$tb052_compras->setAnio(date('Y'));
                $tb052_compras->setAnio( $this->getUser()->getAttribute('ejercicio'));      
                $tb052_compras->setNuIva(0);        
                $tb052_compras->setMontoIva($monto_iva);
                $tb052_compras->setMontoSubTotal($monto_sub_total);        
                $tb052_compras->setMontoTotal($monto_total);  
                $tb052_compras->setCoProveedor($co_proveedor); 
                $tb052_compras->save($con);
                
                
                $c = new Criteria();
                $c->setDistinct();
                $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
                $c->add(Tb052ComprasPeer::CO_SOLICITUD,$array, Criteria::IN);;
                $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);
                $registros = "";

                while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $tb053_detalle_compras = new Tb053DetalleCompras();
                    $tb053_detalle_compras->setCoCompras($tb052_compras->getCoCompras());                                        
                    $tb053_detalle_compras->setCoProducto($res["co_producto"]);
                    $tb053_detalle_compras->setCoDetalleRequisicion($res["co_detalle_requisicion"]);
                    $tb053_detalle_compras->setNuCantidad($res["nu_cantidad"]);
                    $tb053_detalle_compras->setPrecioUnitario($res["precio_unitario"]);
                    $tb053_detalle_compras->setMonto($res["monto"]);
                    $tb053_detalle_compras->setDetalle($res["detalle"]);
                    $tb053_detalle_compras->setCoPartida($res["co_partida"]);
                    $tb053_detalle_compras->setCoUnidadProducto($res["co_unidad_producto"]);
                    $tb053_detalle_compras->setInCalcularIva($res["in_calcular_iva"]);
                    $tb053_detalle_compras->setCoProyectoAc($res["co_proyecto_ac"]);
                    $tb053_detalle_compras->setCoAccionEspecifica($res["co_accion_especifica"]);
                    $tb053_detalle_compras->setCoPresupuesto($res["co_presupuesto"]);
                    $tb053_detalle_compras->setInExento($res["in_exento"]);
                    $tb053_detalle_compras->setCoDetalleRequisicion($res["co_detalle_requisicion"]);
                    $tb053_detalle_compras->save($con);     
                    
                    $res["co_solicitud"] = $this->getCoSolicitud($res["co_compras"]);
                    
                    $wherec = new Criteria();
                    $wherec->add(Tb046FacturaRetencionPeer::CO_SOLICITUD,$res["co_solicitud"]);

                    $updc = new Criteria();    
                    $updc->add(Tb046FacturaRetencionPeer::CO_SOLICITUD_ORIGINAL, $res["co_solicitud"]);
                    
                    BasePeer::doUpdate($wherec, $updc, $con);
                    
                    $wherec = new Criteria();
                    $wherec->add(Tb045FacturaPeer::CO_SOLICITUD,$res["co_solicitud"]);

                    $updc = new Criteria();
                    $updc->add(Tb045FacturaPeer::CO_SOLICITUD_ORIGINAL, $res["co_solicitud"]);

                    BasePeer::doUpdate($wherec, $updc, $con);
                    
                    $wherec = new Criteria();
                    $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD,$res["co_solicitud"]);

                    $updc = new Criteria();
                    $updc->add(Tb061AsientoContablePeer::CO_SOLICITUD_ORIGINAL, $res["co_solicitud"]);

                    BasePeer::doUpdate($wherec, $updc, $con);
                    
                    
                }
                
                //Cambio ODP
                
                $co_odp = Tb060OrdenPagoPeer::generarODP($co_solicitud,$con,$this->getUser()->getAttribute('ejercicio'));
                
                //Se Cambia las retenciones de las solicitudes anteriores a la unificada
                $wherec = new Criteria();
                $wherec->add(Tb046FacturaRetencionPeer::CO_SOLICITUD,$array, Criteria::IN);

                $updc = new Criteria();                
                $updc->add(Tb046FacturaRetencionPeer::CO_ODP, $co_odp);
                $updc->add(Tb046FacturaRetencionPeer::CO_SOLICITUD, $co_solicitud);
                              
                BasePeer::doUpdate($wherec, $updc, $con);
                
                //Se Cambia las facturas anteriores a la unificada
                $wherec = new Criteria();
                $wherec->add(Tb045FacturaPeer::CO_SOLICITUD,$array, Criteria::IN);

                $updc = new Criteria();
                $updc->add(Tb045FacturaPeer::CO_ODP, $co_odp);
                $updc->add(Tb045FacturaPeer::CO_COMPRA, $tb052_compras->getCoCompras());
                $updc->add(Tb045FacturaPeer::CO_SOLICITUD, $co_solicitud);
                
                BasePeer::doUpdate($wherec, $updc, $con);
                                              
                Tb060OrdenPagoPeer::generarODP($co_solicitud,$con,$this->getUser()->getAttribute('ejercicio'));                
                
//                //Se genera el documento de ODP
                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
                $ruta->setInCargarDato(true)->save();                
                
                 //Se actualiza las solicitudes anteriores con la ODP unificada.
                
                $wherec = new Criteria();
                $wherec->add(Tb030RutaPeer::CO_SOLICITUD,$array, Criteria::IN);
                $wherec->add(Tb030RutaPeer::CO_PROCESO,10);
                $wherec->add(Tb030RutaPeer::IN_ACTUAL,true);

                $updc = new Criteria();
                $updc->add(Tb030RutaPeer::TX_RUTA_REPORTE,$ruta->getTxRutaReporte());
                $updc->add(Tb030RutaPeer::IN_ACTUAL, TRUE);
                $updc->add(Tb030RutaPeer::CO_ESTATUS_RUTA, 5);
                
                BasePeer::doUpdate($wherec, $updc, $con);
                
                //Se actualizan las solicitudes a culminado
                $wherec = new Criteria();
                $wherec->add(Tb026SolicitudPeer::CO_SOLICITUD,$array, Criteria::IN);

                $updc = new Criteria();
                $updc->add(Tb026SolicitudPeer::CO_ESTATUS, 3);
                
                BasePeer::doUpdate($wherec, $updc, $con);
                              
                $wherec = new Criteria();
                $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD,$array, Criteria::IN);

                $updc = new Criteria();
                $updc->add(Tb061AsientoContablePeer::CO_SOLICITUD, $co_solicitud);
                
                BasePeer::doUpdate($wherec, $updc, $con);                
                
                $tb026_solicitud = Tb026SolicitudPeer::retrieveByPK($co_solicitud);
                $tb026_solicitud->setCoProveedor($co_proveedor)->save($con);        
                
                $con->commit();
                
                $co_odp = Tb060OrdenPagoPeer::generarODP($co_solicitud,$con,$this->getUser()->getAttribute('ejercicio'));
                
                $con->commit(); 
                
                Tb030RutaPeer::getGenerarReporteUnificado($ruta->getCoRuta(),$co_tipo_solicitud);  
                
                
                
                	
		$this->data = json_encode(array(
			    "success" => true,
			    "msg" => 'La Orden de Pago se unificó con exito!'
		));
               
                
	}catch (PropelException $e)
	{
                $con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
		    "msg" =>  $e->getMessage()
		    //"msg" => 'Ocurrio un error al unificar la ODP'
		));
	}
      
  }
  
  public function executeStorefkcotramite(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD,array(1,2), Criteria::IN);
        $stmt = Tb027TipoSolicitudPeer::doSelectStmt($c);
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
  
  public function executeStorelista(sfWebRequest $request)
  {
        $paginar            =   $this->getRequestParameter("paginar");
        $limit              =   $this->getRequestParameter("limit",20);
        $start              =   $this->getRequestParameter("start",0);
        $co_proveedor       =   $this->getRequestParameter("co_proveedor");
        $co_tipo_solicitud  =   $this->getRequestParameter("co_tipo_solicitud");
        $co_unificacion_odp =   $this->getRequestParameter("co_unificacion_odp");

        $c = new Criteria();   

        $c->setIgnoreCase(true);

        $c->setDistinct();
        $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD, Tb026SolicitudPeer::CO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
      
        
        if($co_unificacion_odp != ''){            
            $c->addJoin(Tb164ListaUnificacionPeer::CO_SOLICITUD_ODP, Tb026SolicitudPeer::CO_SOLICITUD);
            $c->add(Tb164ListaUnificacionPeer::CO_UNIFICACION_ODP,$co_unificacion_odp);  
            
            
        }else{        
            $c->add(Tb026SolicitudPeer::CO_TIPO_SOLICITUD,$co_tipo_solicitud);
            $c->add(Tb026SolicitudPeer::CO_PROVEEDOR,$co_proveedor);
            $c->add(Tb030RutaPeer::IN_ACTUAL,TRUE);
            $c->add(Tb030RutaPeer::NU_ORDEN,7);
            $c->add(Tb030RutaPeer::CO_ESTATUS_RUTA,5,Criteria::NOT_EQUAL);
            $c->add(Tb030RutaPeer::TX_RUTA_REPORTE,NULL);
        }

        $cantidadTotal = Tb052ComprasPeer::doCount($c);
        $c->addAscendingOrderByColumn(Tb052ComprasPeer::CO_SOLICITUD);
        $stmt = Tb052ComprasPeer::doSelectStmt($c);
        $registros = "";
        
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = $res;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));

        $this->setTemplate('store');
    }
    
    
}
