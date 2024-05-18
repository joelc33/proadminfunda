<?php

/**
 * Anulacion actions.
 *
 * @package    gobel
 * @subpackage Anulacion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class AnulacionActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb169AnulacionPeer::CO_ANULACION);
        $c->addSelectColumn(Tb169AnulacionPeer::CO_SOLICITUD_ANULAR);
        $c->addSelectColumn(Tb169AnulacionPeer::TX_OBSERVACION);
        $c->addSelectColumn(Tb169AnulacionPeer::CO_PROCESO);
        $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
        
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb169AnulacionPeer::CO_SOLICITUD_ANULAR);
        $c->add(Tb169AnulacionPeer::CO_SOLICITUD,$this->getRequestParameter("co_solicitud"));       
        
        $stmt = Tb169AnulacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);     
      
        $this->data = json_encode(array(
                "co_anulacion"            => $campos["co_anulacion"],
                "co_solicitud_anular"     => $campos["co_solicitud_anular"],
                "tx_tipo_solicitud"       => $campos["tx_tipo_solicitud"],
                "tx_observacion"          => $campos["tx_observacion"],
                "co_solicitud"            => $this->getRequestParameter("co_solicitud"),
                "co_proceso"              => $campos["co_proceso"]
        ));
  }
  
  public function executeVerificarSolicitud(sfWebRequest $request)
  {
  
    $co_solicitud  = $this->getRequestParameter('co_solicitud');

    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
    $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->add(Tb026SolicitudPeer::CO_SOLICITUD,$co_solicitud);
    $stmt = Tb026SolicitudPeer::doSelectStmt($c);

    $registros = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->data = json_encode(array(
        "success"   => true,
        "data"      => $registros
    ));
    
    $this->setTemplate('store');
    
  }
  
  
  public function executeStorefkcoproceso(sfWebRequest $request)
  {
  
        $co_solicitud  = $this->getRequestParameter('co_solicitud');

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb030RutaPeer::CO_RUTA);
        $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);        
        $c->addJoin(Tb028ProcesoPeer::CO_PROCESO, Tb030RutaPeer::CO_PROCESO);
        $c->add(Tb030RutaPeer::CO_SOLICITUD,$co_solicitud);
        $c->add(Tb030RutaPeer::IN_ANULAR,NULL);
        $c->addAscendingOrderByColumn(Tb030RutaPeer::NU_ORDEN);
        
        $stmt = Tb028ProcesoPeer::doSelectStmt($c);

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
  
  public function executeGuardar(sfWebRequest $request)
  {
      
      $co_anulacion        = $this->getRequestParameter("co_anulacion");
      $co_solicitud        = $this->getRequestParameter("co_solicitud");
      $co_solicitud_anular = $this->getRequestParameter("co_solicitud_anular");
      $tx_tipo_solicitud   = $this->getRequestParameter("tx_tipo_solicitud");
      $tx_observacion      = $this->getRequestParameter("tx_observacion");
      $co_proceso          = $this->getRequestParameter("co_proceso");
      
      
      //co_proceso = co_ruta
      
      $con = Propel::getConnection();
      try
      { 
        $con->beginTransaction();
        
        $solicitud = Tb026SolicitudPeer::retrieveByPK($co_solicitud_anular);
      
        if($co_anulacion == ''){

            $Tb169Anulacion = new Tb169Anulacion();
            $Tb169Anulacion->setCoProceso($co_proceso)
                           ->setCoSolicitud($co_solicitud)
                           ->setCoSolicitudAnular($co_solicitud_anular)
                           ->setTxObservacion($tx_observacion)
                           ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                           ->save($con);
                        
            $tb030_ruta = Tb030RutaPeer::retrieveByPK($co_proceso);
            $tb030_ruta->setInActual(TRUE)
                       ->setCoSolicitudAnular($co_solicitud)
                       ->setCoEstatusRuta(1)
                        ->save($con);
            
            
            $c = new Criteria();
            $c->add(Tb030RutaPeer::CO_SOLICITUD,$co_solicitud_anular);
            $c->add(Tb030RutaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
            $c->add(Tb030RutaPeer::CO_RUTA,$co_proceso, Criteria::GREATER_EQUAL);
            $c->addAscendingOrderByColumn(Tb030RutaPeer::CO_RUTA);            
                       
            $stmt = Tb030RutaPeer::doSelectStmt($c);

            $registros = array();
            while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){

                
                                 
                    if($reg["co_proceso"]==4){
                        $this->Tesoreria($co_solicitud_anular,$co_solicitud,$con);
                    }
                    
                    if($reg["co_proceso"]==10){
                        $this->Presupuesto_odp($co_solicitud_anular,$co_solicitud,$solicitud->getCoTipoSolicitud(),$con);
                    }
                    
                    if($reg["co_proceso"]==8){
                        $this->Contabilidad_retenciones($co_solicitud_anular,$co_solicitud,$con);
                    }
                    
                    if($reg["co_proceso"]==9){
                        $this->Presupuesto_certificacion($co_solicitud_anular,$co_solicitud,$con);
                    }
                    
                    if($reg["co_proceso"]==9){
                        $this->Presupuesto_traspaso($co_solicitud_anular,$co_solicitud,$con);
                    }
                
                if($reg["co_ruta"]!=$co_proceso){                
                    $tb030_ruta = Tb030RutaPeer::retrieveByPK($reg["co_ruta"]);
                    $tb030_ruta->setInAnular(TRUE)
                               ->setCoSolicitudAnular($co_solicitud)
                               ->save($con); 
                }                

            }
            
            $con->commit();
            
            $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Solicitud Anulada con exito!'
            ));
            

        } 
        
      }catch (PropelException $e)
      {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage()
        ));
      }
      
  }
  
  
 
  protected function Presupuesto_traspaso($codigo,$co_solicitud,$con){   
   
        $wherec = new Criteria();
        $wherec->add(Tb096PresupuestoModificacionPeer::CO_SOLICITUD, $codigo);

        $updc = new Criteria();
        $updc->add(Tb096PresupuestoModificacionPeer::IN_ANULAR, TRUE);
        $updc->add(Tb096PresupuestoModificacionPeer::CO_SOLICITUD_ANULAR, $co_solicitud);
        BasePeer::doUpdate($wherec, $updc, $con);  

        $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($wherec);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);  


        $wherec_partida = new Criteria();
        $wherec_partida->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION, $campos["id"]);

        $updc_partida = new Criteria();
        $updc_partida->add(Tb097ModificacionDetallePeer::IN_ANULAR, TRUE);
        $updc_partida->add(Tb097ModificacionDetallePeer::CO_SOLICITUD_ANULAR, $co_solicitud);
        BasePeer::doUpdate($wherec_partida, $updc_partida, $con); 
        
        $stmt2 = Tb097ModificacionDetallePeer::doSelectStmt($wherec_partida);
       
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){

           
        }
        
         
  }  
  
  
  protected function Presupuesto_certificacion($codigo,$co_solicitud,$con){   
   
      $this->AnularMovimiento($codigo,1,$co_solicitud,$con);
         
  }  
  
  protected function Contabilidad_retenciones($codigo,$co_solicitud,$con){
      
    /*********************FACTURAS*************************/
      
    $wherec = new Criteria();
    $wherec->add(Tb045FacturaPeer::CO_SOLICITUD, $codigo);
    
    $updc = new Criteria();
    $updc->add(Tb045FacturaPeer::IN_ANULAR, TRUE);
    $updc->add(Tb045FacturaPeer::CO_SOLICITUD_ANULAR, $co_solicitud);
    BasePeer::doUpdate($wherec, $updc, $con);    
    
    /********************DETALLE FACTURA******************/
        
    $c = new Criteria();
    $c->addJoin(Tb045FacturaPeer::CO_FACTURA, Tb046FacturaRetencionPeer::CO_FACTURA);
    $c->add(Tb045FacturaPeer::CO_SOLICITUD,$codigo);
    $stmt = Tb046FacturaRetencionPeer::doSelectStmt($c);

    $registros = array();
    while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        $Tb046FacturaRetencion = Tb046FacturaRetencionPeer::retrieveByPK($reg["co_factura_retencion"]);
        $Tb046FacturaRetencion->setInAnular(TRUE)
                              ->setCoSolicitudAnular($co_solicitud)
                              ->save($con);
        
    }
    
    /*********************ASIENTO*************************/
    
    $wherec = new Criteria();
    $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $codigo);
    
    $updc = new Criteria();
    $updc->add(Tb061AsientoContablePeer::IN_ANULAR, TRUE);
    $updc->add(Tb061AsientoContablePeer::CO_SOLICITUD_ANULAR, $co_solicitud);
    BasePeer::doUpdate($wherec, $updc, $con); 
    
    $this->AnularMovimiento($codigo,2,$co_solicitud,$con);
    
        
  }
  
  
  protected function Presupuesto_odp($codigo,$co_tipo_solicitud,$co_solicitud,$con){
      
    /*********************ORDEN DE PAGO*************************/
      
    $wherec = new Criteria();
    $wherec->add(Tb060OrdenPagoPeer::CO_SOLICITUD, $codigo);
    
    $updc = new Criteria();
    $updc->add(Tb060OrdenPagoPeer::IN_ANULAR, TRUE);
    $updc->add(Tb060OrdenPagoPeer::CO_SOLICITUD_ANULAR, $co_solicitud);
    BasePeer::doUpdate($wherec, $updc, $con);    
    
    /*********************LIQUIDACION*************************/
    
    $wherec = new Criteria();
    $wherec->add(Tb062LiquidacionPagoPeer::CO_SOLICITUD, $codigo);
    
    $updc = new Criteria();
    $updc->add(Tb062LiquidacionPagoPeer::CO_SOLICITUD_ANULAR, $co_solicitud);
    $updc->add(Tb062LiquidacionPagoPeer::IN_ANULAR, TRUE);
    BasePeer::doUpdate($wherec, $updc, $con);    
      
    /*********************ASIENTO*************************/
    
    if($co_tipo_solicitud > 2){
    
        $wherec = new Criteria();
        $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $codigo);

        $updc = new Criteria();
        $updc->add(Tb061AsientoContablePeer::IN_ANULAR, TRUE);
        $updc->add(Tb061AsientoContablePeer::CO_SOLICITUD_ANULAR, $co_solicitud);
        BasePeer::doUpdate($wherec, $updc, $con); 
        
        $this->AnularMovimiento($codigo,2,$co_solicitud,$con);
        
    }
    
  }
  
  
  protected function Tesoreria($codigo,$co_solicitud,$con){
      
    $c = new Criteria();
    $c->add(Tb062LiquidacionPagoPeer::CO_SOLICITUD,$codigo);       
    $stmt = Tb062LiquidacionPagoPeer::doSelectStmt($c);
    $campos = $stmt->fetch(PDO::FETCH_ASSOC);      
      
    $wherec = new Criteria();
    $wherec->add(Tb063PagoPeer::CO_LIQUIDACION_PAGO, $campos["co_liquidacion_pago"]);
    $updc = new Criteria();
    $updc->add(Tb063PagoPeer::IN_ANULAR, TRUE);
    $updc->add(Tb063PagoPeer::CO_SOLICITUD_ANULAR, $co_solicitud);
    BasePeer::doUpdate($wherec, $updc, $con);  

    $this->AnularMovimiento($codigo,3,$co_solicitud,$con);
    
    //*******************Falta agregar el reintegro del banco****************

    //Falta Anular los asientos de pago
    /*   
     *  $wherec = new Criteria();
        $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $codigo);

        $updc = new Criteria();
        $updc->add(Tb061AsientoContablePeer::IN_ANULAR, TRUE);
        BasePeer::doUpdate($wherec, $updc, $con); 
    */
      
  }
  
  
  protected function AnularMovimiento($codigo,$tipo,$co_solicitud,$con){
      
    $c = new Criteria();
    $c->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
    $c->add(Tb052ComprasPeer::CO_SOLICITUD,$codigo);   

    $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);

    $registros = array();
    while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        /********************Movimiento Presupuesto******************/
        
        $wherec = new Criteria();
        $wherec->add(Tb087PresupuestoMovimientoPeer::CO_PARTIDA, $reg["co_presupuesto"]);
        $wherec->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $reg["co_detalle_compras"]);
        $wherec->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO,$tipo);
        $wherec->add(Tb087PresupuestoMovimientoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                 
        $stmt2 = Tb087PresupuestoMovimientoPeer::doSelectStmt($wherec);
        $campos = $stmt2->fetch(PDO::FETCH_ASSOC);    
        
        if($campos["co_presupuesto_movimiento"]!=''){
            $tb085_presupuesto = Tb085PresupuestoPeer::retrieveByPK($reg["co_presupuesto"]);

            if($tipo==1){
                $monto = $tb085_presupuesto->getMoComprometido()-$campos["nu_monto"];            
                $tb085_presupuesto->setMoComprometido($monto);
            }
            if($tipo==2){
                $monto = $tb085_presupuesto->getMoCausado()-$campos["nu_monto"];
                $tb085_presupuesto->setMoCausado($monto);
            }

            if($tipo==3){
                $monto = $tb085_presupuesto->getMoPagado()-$campos["nu_monto"];
                $tb085_presupuesto->setMoPagado($monto);
            }  

            $tb085_presupuesto->save($con);
                      
            $tb087 = Tb087PresupuestoMovimientoPeer::retrieveByPK($campos["co_presupuesto_movimiento"]);
            $tb087->setInAnular(TRUE)
                  ->setCoSolicitudAnular($co_solicitud)
                  ->save($con);
        }
        
    }     
      
  }
  
  
  
  
}
