<?php

class Tb060OrdenPagoPeer extends BaseTb060OrdenPagoPeer
{
    static public function getCoRuta($codigo){
      
        $c = new Criteria();
        $c->add(Tb030RutaPeer::CO_SOLICITUD,$codigo);  
        $c->add(Tb030RutaPeer::IN_ACTUAL,TRUE);
        $stmt = Tb030RutaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos["co_ruta"];
    }
    
    static public function getODP($co_solicitud){
        $c = new Criteria();
        $c->add(Tb060OrdenPagoPeer::CO_SOLICITUD,$co_solicitud);
        $c->add(Tb060OrdenPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
       
        $stmt = Tb060OrdenPagoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos["tx_serial"];
    }
    
    static public function getNuOrdenPago($co_solicitud,$con,$ejercicio){
     
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb060OrdenPagoPeer::NU_ORDEN_PAGO);
        //$c->addSelectColumn(Tb027TipoSolicitudPeer::ID_136_TIPO_DOCUMENTO);
        $c->addJoin(Tb060OrdenPagoPeer::CO_RUTA, Tb030RutaPeer::CO_RUTA);
        //$c->addJoin(Tb030RutaPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->add(Tb030RutaPeer::CO_SOLICITUD,$co_solicitud);
        $c->add(Tb030RutaPeer::IN_ACTUAL,true);
        
        $stmt = Tb060OrdenPagoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);       
         
        if($campos["nu_orden_pago"]==''){
            
            $c1 = new Criteria();
            $c1->add(Tb137ControlSerialPeer::CO_TIPO_DOCUMENTO,1);
            //$c1->add(Tb137ControlSerialPeer::CO_TIPO_DOCUMENTO, $campos["id_136_tipo_documento"]);
            //$c1->add(Tb137ControlSerialPeer::NU_ANIO,date('Y'));
            $c1->add(Tb137ControlSerialPeer::NU_ANIO, $ejercicio);

            $cant = Tb137ControlSerialPeer::doCount($c1);
            
            
            if($cant == 0){
                 $cant = 1;
                 $Tb137ControlSerial = new Tb137ControlSerial();
                 $Tb137ControlSerial->setCoTipoDocumento(1)
                                    //->setNuAnio(date("Y"))
                                    ->setNuAnio($ejercicio)
                                    ->setNuSerial($cant)
                                    ->save($con);
                 
            }else{
            
                $stmts = Tb137ControlSerialPeer::doSelectStmt($c1);
                $serial = $stmts->fetch(PDO::FETCH_ASSOC);
                
                $cant = $serial["nu_serial"]+1;

                $wherec = new Criteria();
                $wherec->add(Tb137ControlSerialPeer::CO_TIPO_DOCUMENTO,1);
                //$wherec->add(Tb137ControlSerialPeer::CO_TIPO_DOCUMENTO, $campos["id_136_tipo_documento"]);
                //$wherec->add(Tb137ControlSerialPeer::NU_ANIO,date('Y'));
                $wherec->add(Tb137ControlSerialPeer::NU_ANIO, $ejercicio);

                $updc = new Criteria();
                $updc->add(Tb137ControlSerialPeer::NU_SERIAL,$cant);

                BasePeer::doUpdate($wherec, $updc, $con);
            
            }
            
            $campos["nu_orden_pago"] = $cant;           
          
            
        }
        
        
        return $campos["nu_orden_pago"];      
    }
    
    static public function getNuDocumentoPago($co_solicitud,$con,$ejercicio){
     
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb060OrdenPagoPeer::NU_ORDEN_PAGO);
        $c->addSelectColumn(Tb027TipoSolicitudPeer::ID_136_TIPO_DOCUMENTO);           
        $c->addJoin(Tb030RutaPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addJoin(Tb030RutaPeer::CO_RUTA, Tb060OrdenPagoPeer::CO_RUTA, Criteria::LEFT_JOIN);
        $c->add(Tb030RutaPeer::CO_SOLICITUD,$co_solicitud);
        $c->add(Tb030RutaPeer::IN_ACTUAL,true);
        
        $stmt = Tb030RutaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);       

        if($campos["nu_orden_pago"]==''){
            
            if($campos["id_136_tipo_documento"]=='' || $campos["id_136_tipo_documento"]==1){
             
            $c = new Criteria();
            $c->add(Tb137ControlSerialPeer::CO_TIPO_DOCUMENTO,1);
            //$c->add(Tb137ControlSerialPeer::NU_ANIO,date('Y'));
            $c->add(Tb137ControlSerialPeer::NU_ANIO, $ejercicio);
                $stmts = Tb137ControlSerialPeer::doSelectStmt($c);
                $serial = $stmts->fetch(PDO::FETCH_ASSOC);
                
                $cant = $serial["nu_serial"];      
            
            
            }else{
            
            $c = new Criteria();
            $c->add(Tb137ControlSerialPeer::CO_TIPO_DOCUMENTO,$campos["id_136_tipo_documento"]);
            //$c->add(Tb137ControlSerialPeer::NU_ANIO,date('Y'));
            $c->add(Tb137ControlSerialPeer::NU_ANIO, $ejercicio);

            $cant = Tb137ControlSerialPeer::doCount($c);
            
            $co_tipo_documento = $campos["id_136_tipo_documento"];
            
            
            if($cant == 0){
                 $cant = 1;
                 $Tb137ControlSerial = new Tb137ControlSerial();
                 $Tb137ControlSerial->setCoTipoDocumento($co_tipo_documento)
                                    //->setNuAnio(date("Y"))
                                    ->setNuAnio($ejercicio)
                                    ->setNuSerial($cant)
                                    ->save($con);
                 
            }else{
            
                $stmts = Tb137ControlSerialPeer::doSelectStmt($c);
                $serial = $stmts->fetch(PDO::FETCH_ASSOC);
                
                $cant = $serial["nu_serial"]+1;

                $wherec = new Criteria();
                $wherec->add(Tb137ControlSerialPeer::CO_TIPO_DOCUMENTO,$co_tipo_documento);
                //$wherec->add(Tb137ControlSerialPeer::NU_ANIO,date('Y'));
                $wherec->add(Tb137ControlSerialPeer::NU_ANIO, $ejercicio);

                $updc = new Criteria();
                $updc->add(Tb137ControlSerialPeer::NU_SERIAL,$cant);

                BasePeer::doUpdate($wherec, $updc, $con);
            
            }
        }
            
            $campos["nu_orden_pago"] = $cant;           
          
            
        }
        
        
        return $campos["nu_orden_pago"];      
    }    
    
    static public function getTxSiglas($co_tipo_solicitud){
     
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb136TipoDocumentoPeer::TX_SIGLA);   
        $c->addJoin(Tb027TipoSolicitudPeer::ID_136_TIPO_DOCUMENTO, Tb136TipoDocumentoPeer::CO_TIPO_DOCUMENTO);
        $c->addJoin(Tb030RutaPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->add(Tb030RutaPeer::CO_TIPO_SOLICITUD,$co_tipo_solicitud);
        $c->add(Tb030RutaPeer::IN_ACTUAL,true);
        
        $stmt = Tb030RutaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);       

        return $campos["tx_sigla"];      
    }    
  
    static public function generarODP_OLD( $co_solicitud, $con, $ejercicio, $nu_orden_pago=NULL, $fe_pago){

        $retencion=0;
        $total_retencion=0;
        $monto_total = 0;

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb026SolicitudPeer::CO_TIPO_SOLICITUD);
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD,$co_solicitud);

        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($campos["co_tipo_solicitud"]==37){
            $campos["co_tipo_solicitud"] = 1;
        }
            
        $co_tipo_solicitud =  $campos["co_tipo_solicitud"];
        
        
        
        
        $co_ruta = self::getCoRuta($co_solicitud);

        //Ayuda a través de los aportes de responsabilidad social
        if($co_tipo_solicitud==28){
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb052ComprasPeer::MONTO_TOTAL);
            $c->add(Tb052ComprasPeer::CO_SOLICITUD,$co_solicitud);

            $stmt = Tb087PresupuestoMovimientoPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $nu_monto    =  $campos["monto_total"];
            $monto_total = $nu_monto;
        }else if($co_tipo_solicitud==26){           

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL. ') as total');
            $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
            $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
            $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
            $stmt = Tb045FacturaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $nu_monto =  $campos["total"]-$campos["total_iva_retencion"];
           
                      
            $monto_total = $campos["total"];

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_TOTAL_RETENCION. ') as total_retencion');
            $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
            $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);

            $stmt = Tb045FacturaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $retencion =  $campos["total_retencion"];

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
            $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
            $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);

            $stmt = Tb045FacturaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $total_iva_retencion =  $campos["total_iva_retencion"];

            $total_retencion = $retencion - $total_iva_retencion;         
        }else if($co_tipo_solicitud == 38){
            
            //Fondo de Tercero MASIVO           

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn('coalesce(SUM(' . Tb162ArchivoFondoTerceroPeer::NU_MONTO. '),0) as total');
            $c->addJoin(Tb161PagoFondoTerceroPeer::CO_PAGO_FONDO_TERCERO, Tb162ArchivoFondoTerceroPeer::CO_FONDO_TERCERO);
            $c->add(Tb161PagoFondoTerceroPeer::CO_SOLICITUD,$co_solicitud);
            $c->add(Tb162ArchivoFondoTerceroPeer::IN_ANULAR,NULL, Criteria::ISNULL);

            $stmt = Tb161PagoFondoTerceroPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $nu_monto =  $campos["total"];
            $monto_total = $nu_monto;
        }
        else if($co_tipo_solicitud == 39 || $co_tipo_solicitud == 40){ 
             
             //39-Servicios Varios (Honorarios, Publicidad)

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL. ') as total');
            $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
            $c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
            $c->add(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
            $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
            $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
            $stmt = Tb045FacturaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $nu_monto =  $campos["total"];
            $monto_total = $campos["total"];
            
            

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_TOTAL_RETENCION. ') as total_retencion');
            $c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
            $c->add(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
            $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);

            $stmt = Tb045FacturaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $retencion =  $campos["total_retencion"];

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
            $c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
            $c->add(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
            $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
            $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);

            $stmt = Tb045FacturaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $total_iva_retencion =  $campos["total_iva_retencion"];

            $total_retencion = $retencion; //- $total_iva_retencion;

        }
        else if($co_tipo_solicitud > 2){

            $wherec = new Criteria();
            $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $co_solicitud, Criteria::EQUAL);
            BasePeer::doDelete($wherec, $con);

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn('coalesce(SUM(' .  Tb087PresupuestoMovimientoPeer::NU_MONTO. '),0) as total');
            $c->addJoin(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
            $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
            $c->add(Tb052ComprasPeer::CO_SOLICITUD,$co_solicitud);
            $c->add(Tb087PresupuestoMovimientoPeer::IN_ACTIVO,true);
            $c->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO,2);
            $c->add(Tb087PresupuestoMovimientoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
            $c->add(Tb053DetalleComprasPeer::IN_PRESUPUESTO, TRUE);

            $stmt = Tb087PresupuestoMovimientoPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $nu_monto =  $campos["total"];
            $monto_total = $nu_monto;
        }        
        else{

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL. ') as total');
            $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
            $c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
            $c->add(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
            $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
            $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
            
            //echo $c->toString(); exit();
            
            $stmt = Tb045FacturaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $nu_monto =  $campos["total"]-$campos["total_iva_retencion"];
            $monto_total = $campos["total"];
            
            

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_TOTAL_RETENCION. ') as total_retencion');
            $c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
            $c->add(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
            $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
            $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);

            $stmt = Tb045FacturaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $retencion =  $campos["total_retencion"];

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
            $c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
            $c->add(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
            $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
            $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);

            $stmt = Tb045FacturaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $total_iva_retencion =  $campos["total_iva_retencion"];

            $total_retencion = $retencion - $total_iva_retencion;

        }


        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb060OrdenPagoPeer::CO_ORDEN_PAGO);
        $c->add(Tb060OrdenPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        $c->add(Tb060OrdenPagoPeer::CO_SOLICITUD,$co_solicitud);
        $c->add(Tb060OrdenPagoPeer::CO_RUTA,$co_ruta);
        $cant_orden_pago = Tb060OrdenPagoPeer::doCount($c);

       // echo $c->toString(); exit();
        
        $stmt = Tb060OrdenPagoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $co_orden_pago =  $campos["co_orden_pago"];

        $nu_monto_total = $nu_monto-$total_retencion;

        if($cant_orden_pago == 0){

            $c = new Criteria();
            //$c->add(Tb060OrdenPagoPeer::NU_ANIO,date('Y'));
            $c->add(Tb060OrdenPagoPeer::NU_ANIO, $ejercicio);
            $cant = Tb060OrdenPagoPeer::doCount($c);

            $cant+=1;
            
            if ($co_tipo_solicitud != 28 && $co_tipo_solicitud != 38){ 
                if(date("Y")>$ejercicio){
                    $tx_serial = $ejercicio.'12-'.str_pad(self::getNuOrdenPago($co_solicitud,$con,$ejercicio), 5, "0", STR_PAD_LEFT);
                }
                else{
                    $tx_serial = date('Ym').'-'.str_pad(self::getNuOrdenPago($co_solicitud,$con,$ejercicio), 5, "0", STR_PAD_LEFT);
                }
            }else{
                $tx_serial = '';
            }
            
            if(date("Y")>$ejercicio){
                $tx_docuemnto_odp = self::getTxSiglas($co_tipo_solicitud,$con).$ejercicio.'12-'.str_pad(self::getNuDocumentoPago($co_solicitud,$con,$ejercicio), 4, "0", STR_PAD_LEFT);
            }else{
                $tx_docuemnto_odp = self::getTxSiglas($co_tipo_solicitud,$con).date('Ym').'-'.str_pad(self::getNuDocumentoPago($co_solicitud,$con,$ejercicio), 4, "0", STR_PAD_LEFT);
            }
                
            if(date("Y")>$ejercicio){
                //$FeEmision = $ejercicio.'-12-31';
                $FeEmision = $fe_pago; 
            }else{
                $FeEmision = date("Y-m-d"); 
            } 

            $Tb060OrdenPago = new Tb060OrdenPago();
            $Tb060OrdenPago->setCoSolicitud($co_solicitud)
                           //->setFeEmision(date('Y-m-d'))
                           ->setFeEmision( $FeEmision)
                           //->setNuAnio(date('Y'))
                           ->setNuAnio( $ejercicio)
                           ->setMoPagar($nu_monto_total)
                           ->setMoRetencion($total_retencion)
                           ->setTxSerial($tx_serial)
                           ->setMoPendiente($nu_monto_total)
                           ->setMoPagado(0)
                           ->setTxDocumentoOdp($tx_docuemnto_odp)
                           ->setMoTotal($monto_total)
                           ->setCoRuta($co_ruta)
                           ->setInPagado(FALSE)
                           ->save($con);

                if($co_tipo_solicitud == 23){
                    //LIQUIDACION DE NOMINA
                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('SUM(' .Tb123ArchivoPagoPeer::NU_MONTO. ') as total');
                    $c->addSelectColumn(Tb010BancoPeer::NU_CODIGO);
                    $c->addSelectColumn(Tb010BancoPeer::CO_BANCO);
                    $c->addJoin(Tb123ArchivoPagoPeer::CO_PAGO_NOMINA, Tb122PagoNominaPeer::CO_PAGO_NOMINA);
                    $c->addJoin(Tb123ArchivoPagoPeer::COD_BANCO, Tb010BancoPeer::NU_CODIGO);
                    $c->add(Tb122PagoNominaPeer::CO_SOLICITUD,$co_solicitud);
                    $c->addGroupByColumn(Tb010BancoPeer::NU_CODIGO);
                    $c->addGroupByColumn(Tb010BancoPeer::CO_BANCO);

                    
                    $stmt = Tb123ArchivoPagoPeer::doSelectStmt($c);
                    $registros = "";
                    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){

                        if(date("Y")>$ejercicio){
                            $FeEmision = $ejercicio.'-12-31'; 
                        }else{
                            $FeEmision = date("Y-m-d"); 
                        } 
                         
                         $Tb062LiquidacionPago = new Tb062LiquidacionPago();
                         $Tb062LiquidacionPago->setCoSolicitud($co_solicitud)
                               //->setFeEmision(date('Y-m-d'))
                               ->setFeEmision( $FeEmision)
                               //->setNuAnio(date('Y'))
                               ->setNuAnio( $ejercicio)
                               ->setMoPagar($res["total"])
                               ->setMoPendiente($res["total"])
                               ->setMoPagado(0)
                               ->setCoOdp($Tb060OrdenPago->getCoOrdenPago())
                               ->setCoTipoSolicitud($co_tipo_solicitud)                               
                               ->save($con);

                    }
                
                
            }else{            

                if(date("Y")>$ejercicio){
                    $FeEmision = $ejercicio.'-12-31'; 
                }else{
                    $FeEmision = date("Y-m-d"); 
                } 
            
            $Tb062LiquidacionPago = new Tb062LiquidacionPago();
            $Tb062LiquidacionPago->setCoSolicitud($co_solicitud)
                           //->setFeEmision(date('Y-m-d'))
                           ->setFeEmision( $FeEmision)
                           //->setNuAnio(date('Y'))
                           ->setNuAnio( $ejercicio)
                           ->setMoPagar($nu_monto_total)
                           ->setMoPendiente($nu_monto_total)
                           ->setMoPagado(0)
                           ->setCoOdp($Tb060OrdenPago->getCoOrdenPago())
                           ->setCoTipoSolicitud($co_tipo_solicitud)
                           ->save($con);
            }
        }else{

            $Tb060OrdenPago = Tb060OrdenPagoPeer::retrieveByPK($co_orden_pago);
            $Tb060OrdenPago->setMoPagar($nu_monto_total)
                           ->setMoRetencion($total_retencion)
                           ->setMoPendiente($nu_monto_total)
                           ->setMoPagado(0)
                           ->setNuOrdenPago($nu_orden_pago)
                           ->setMoTotal($monto_total)
                           ->save($con);
            
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
            $c->add(Tb062LiquidacionPagoPeer::CO_ODP,$Tb060OrdenPago->getCoOrdenPago());
            $cant_liquidacion = Tb062LiquidacionPagoPeer::doCount($c);

            $stmt = Tb062LiquidacionPagoPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
            $co_liquidacion_pago =  $campos["co_liquidacion_pago"];
            

            $Tb062LiquidacionPago = Tb062LiquidacionPagoPeer::retrieveByPK($co_liquidacion_pago);
            $Tb062LiquidacionPago->setCoSolicitud($co_solicitud)
                           ->setMoPagar($nu_monto_total)
                           ->setMoPendiente($nu_monto_total)
                           ->setMoPagado(0)
                           ->setCoOdp($Tb060OrdenPago->getCoOrdenPago())
                           ->setCoTipoSolicitud($co_tipo_solicitud)
                           ->save($con);


        }

        if($co_tipo_solicitud > 2 && $co_tipo_solicitud!=28){
            
                    $co_cuenta_por_pagar = Tb130CuentaDocumentoPeer::getCoCuentaContable($co_solicitud);
            
                    if($co_tipo_solicitud==26){
                        
                           // echo $co_tipo_solicitud; exit());
                        
                            $c = new Criteria();                           
                            $c->add(Tb045FacturaPeer::CO_SOLICITUD, $co_solicitud,Criteria::EQUAL);
                            $stmt = Tb045FacturaPeer::doSelectStmt($c);

                            while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
                                
                                $tb061_asiento_contable = new Tb061AsientoContable();
                                $tb061_asiento_contable->setMoHaber($reg["nu_total"])
                                                       ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"])
                                                       ->setCoSolicitud($co_solicitud)
                                                       ->setCoFactura($reg["co_factura"])
//                                                       ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                                       ->setCoRuta($co_ruta)
                                                       ->setCoTipoAsiento(1)
                                                       ->save($con);
                                
                                $cd = new Criteria();                           
                                $cd->add(Tb053DetalleComprasPeer::CO_FACTURA, $reg["co_factura"]);
                                $cd->add(Tb053DetalleComprasPeer::IN_PRESUPUESTO, TRUE);
                                $stmtd = Tb053DetalleComprasPeer::doSelectStmt($cd);

                                while($reg_compra = $stmtd->fetch(PDO::FETCH_ASSOC)){

                                    
                                          $cuenta_contable = Tb024CuentaContablePeer::getCuentaContable($reg_compra["co_producto"], $co_solicitud);
                                    
                                          
                                          if($reg_compra["co_producto"]==19336){
                                          
                                            $tb061_asiento_contable = new Tb061AsientoContable();
                                            $tb061_asiento_contable->setMoDebe($reg_compra["monto"])
                                                                  ->setCoCuentaContable($cuenta_contable["co_cuenta_contable"])
                                                                  ->setCoSolicitud($co_solicitud)
                                                                  ->setCoProducto(19336)
                                                                  ->setCoFactura($reg["co_factura"])
//                                                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                                                  ->setCoTipoAsiento(1)
                                                                  ->setCoPresupuesto($reg_compra["co_presupuesto"])
                                                                  ->setCoRuta($co_ruta)
                                                                  ->save($con);
                                          
                                          }else{
                                            $tb061_asiento_contable = new Tb061AsientoContable();
                                            $tb061_asiento_contable->setMoDebe($reg_compra["monto"])
                                                                  ->setCoCuentaContable($cuenta_contable["co_cuenta_contable"])
                                                                  ->setCoSolicitud($co_solicitud)
                                                                  ->setCoProducto($reg_compra["co_producto"])
                                                                  ->setCoFactura($reg["co_factura"])
//                                                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                                                  ->setCoTipoAsiento(1)
                                                                  ->setCoPresupuesto($reg_compra["co_presupuesto"])
                                                                  ->setCoRuta($co_ruta)
                                                                  ->save($con);                                          
                                          }
                                        

                                }
                                
                               
                                
                                $tb061_asiento_contable = new Tb061AsientoContable();
                                $tb061_asiento_contable->setMoHaber($reg["nu_total"])
                                                  ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_orden_pago"])
                                                  ->setCoSolicitud($co_solicitud)
                                                  ->setCoFactura($reg["co_factura"])
//                                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))                            
                                                  ->setCoTipoAsiento(2)
                                                  ->setCoRuta($co_ruta)
                                                  ->save($con);

                                $tb061_asiento_contable = new Tb061AsientoContable();
                                $tb061_asiento_contable->setMoDebe($reg["nu_total"])
                                                  ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"])
                                                  ->setCoSolicitud($co_solicitud)
                                                  ->setCoFactura($reg["co_factura"])
//                                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                                  ->setCoTipoAsiento(2)
                                                  ->setCoRuta($co_ruta)
                                                  ->save($con);                                  
                            }
                            
                    }else if($co_tipo_solicitud == 39 || $co_tipo_solicitud == 40){ 
                        
                            $wherec = new Criteria();
                            $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $co_solicitud, Criteria::EQUAL);
                            BasePeer::doDelete($wherec, $con);
            
                            $tb061_asiento_contable = new Tb061AsientoContable();
                            $tb061_asiento_contable->setMoHaber($nu_monto)
                                          ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"])
                                          ->setCoSolicitud($co_solicitud)
                                          ->setCoTipoAsiento(1)
        //                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                          ->save($con);

                            $c = new Criteria();
                            $c->clearSelectColumns();
                            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRODUCTO);
                            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
                            $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
                            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
                            $c->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
                            $c->add(Tb052ComprasPeer::CO_SOLICITUD, $co_solicitud,Criteria::EQUAL);
                            $c->add(Tb053DetalleComprasPeer::IN_PRESUPUESTO, TRUE);

                            $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);

                            while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
                                
                                $cuenta_contable = Tb024CuentaContablePeer::getCuentaContable($reg["co_producto"], $co_solicitud,$reg["co_presupuesto"]);

                                $tb061_asiento_contable = new Tb061AsientoContable();
                                $tb061_asiento_contable->setMoDebe($reg["monto"])
                                                  ->setCoCuentaContable($cuenta_contable["co_cuenta_contable"])
                                                  ->setCoSolicitud($co_solicitud)
                                                  ->setCoProducto($reg["co_producto"])
                                                  ->setCoTipoAsiento(1)
                                                  ->setCoPresupuesto($reg["co_presupuesto"])
        //                                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                                  ->save($con);
                            }

                            $tb061_asiento_contable = new Tb061AsientoContable();
                            $tb061_asiento_contable->setMoDebe($nu_monto)
                                          ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"])
                                          ->setCoSolicitud($co_solicitud)
                                          ->setCoTipoAsiento(2)
        //                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                          ->save($con);

                            $tb061_asiento_contable = new Tb061AsientoContable();
                            $tb061_asiento_contable->setMoHaber($nu_monto)
                                          ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_orden_pago"])
                                          ->setCoSolicitud($co_solicitud)
                                          ->setCoTipoAsiento(2)
        //                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                          ->save($con);
                        
                    }else{

                            if(date("Y")>$ejercicio){
                                $fe_pago = $fe_pago.date(' h:i:s'); 
                            }else{
                                $fe_pago = date("Y-m-d"); 
                            }
                          
                            
                            $tb061_asiento_contable = new Tb061AsientoContable();
                            $tb061_asiento_contable->setMoHaber($nu_monto_total)
                                          ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"])
                                          ->setCoSolicitud($co_solicitud)
                                          ->setCoTipoAsiento(1)
                                          ->setCreatedAt($fe_pago)
        //                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                          ->save($con);

                            $c = new Criteria();
                            $c->clearSelectColumns();
                            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRODUCTO);
                            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
                            $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
                            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
                            $c->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
                            $c->add(Tb052ComprasPeer::CO_SOLICITUD, $co_solicitud,Criteria::EQUAL);
                            $c->add(Tb053DetalleComprasPeer::IN_PRESUPUESTO, TRUE);

                            $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);

                            while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
                                
                                $cuenta_contable = Tb024CuentaContablePeer::getCuentaContable($reg["co_producto"], $co_solicitud,$reg["co_presupuesto"]);

                                $tb061_asiento_contable = new Tb061AsientoContable();
                                $tb061_asiento_contable->setMoDebe($reg["monto"])
                                                  ->setCoCuentaContable($cuenta_contable["co_cuenta_contable"])
                                                  ->setCoSolicitud($co_solicitud)
                                                  ->setCoProducto($reg["co_producto"])
                                                  ->setCoTipoAsiento(1)
                                                  ->setCreatedAt($fe_pago)
                                                  ->setCoPresupuesto($reg["co_presupuesto"])
        //                                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                                  ->save($con);
                            }

                            $tb061_asiento_contable = new Tb061AsientoContable();
                            $tb061_asiento_contable->setMoDebe($nu_monto_total)
                                          ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"])
                                          ->setCoSolicitud($co_solicitud)
                                          ->setCoTipoAsiento(2)
                                          ->setCreatedAt($fe_pago)
        //                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                          ->save($con);

                                          //var_dump(strtotime($fe_pago));

                            $tb061_asiento_contable = new Tb061AsientoContable();
                            $tb061_asiento_contable->setMoHaber($nu_monto_total)
                                          ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_orden_pago"])
                                          ->setCoSolicitud($co_solicitud)
                                          ->setCoTipoAsiento(2)
                                          //->setCreatedAt('2018-01-01')
                                          ->setCreatedAt($fe_pago)
        //                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                          ->save($con);
                    
                    }
        }

        return $Tb060OrdenPago->getCoOrdenPago();
    }

    static public function generarODP( $co_solicitud, $con, $ejercicio, $nu_orden_pago=NULL, $fe_pago){

        $retencion=0;
        $total_retencion=0;
        $monto_total = 0;

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb026SolicitudPeer::CO_TIPO_SOLICITUD);
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD,$co_solicitud);

        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($campos["co_tipo_solicitud"]==37){
            $campos["co_tipo_solicitud"] = 1;
        }
            
        $co_tipo_solicitud =  $campos["co_tipo_solicitud"];
        
        $co_ruta = self::getCoRuta($co_solicitud);

        switch ($co_tipo_solicitud) {
            case 28:
                    //Ayuda a través de los aportes de responsabilidad social

                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn(Tb052ComprasPeer::MONTO_TOTAL);
                    $c->add(Tb052ComprasPeer::CO_SOLICITUD,$co_solicitud);

                    $stmt = Tb052ComprasPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);

                    $nu_monto    =  $campos["monto_total"];
                    $monto_total = $nu_monto;
                break;
            case 26:
                    //Servicios Basicos

                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL. ') as total');
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
                    $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
                    $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                    $stmt = Tb045FacturaPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);

                    $nu_monto =  $campos["total"]-$campos["total_iva_retencion"];
                
                    $monto_total = $campos["total"];

                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_TOTAL_RETENCION. ') as total_retencion');
                    $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
                    $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);

                    $stmt = Tb045FacturaPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);

                    $retencion =  $campos["total_retencion"];

                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
                    $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
                    $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);

                    $stmt = Tb045FacturaPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);

                    $total_iva_retencion =  $campos["total_iva_retencion"];

                    //$total_retencion = $retencion - $total_iva_retencion;   
                    $total_retencion = $retencion;
                break;
            case 38:
                    //Fondo de Tercero MASIVO           

                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('coalesce(SUM(' . Tb162ArchivoFondoTerceroPeer::NU_MONTO. '),0) as total');
                    $c->addJoin(Tb161PagoFondoTerceroPeer::CO_PAGO_FONDO_TERCERO, Tb162ArchivoFondoTerceroPeer::CO_FONDO_TERCERO);
                    $c->add(Tb161PagoFondoTerceroPeer::CO_SOLICITUD,$co_solicitud);
                    $c->add(Tb162ArchivoFondoTerceroPeer::IN_ANULAR,NULL, Criteria::ISNULL);

                    $stmt = Tb161PagoFondoTerceroPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);

                    $nu_monto =  $campos["total"];
                    $monto_total = $nu_monto;
                break;
            case 39:
                    //39-Servicios Varios (Honorarios, Publicidad)

                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL. ') as total');
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
                    $c->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_TOTAL_RETENCION. ') as total_retencion');
                    //$c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
                    //$c->add(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
                    $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
                    $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                    $stmt = Tb045FacturaPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    $nu_monto =  $campos["total"];
                    $monto_total = $campos["total"];        
                    $retencion =  $campos["total_retencion"];        
                    $total_iva_retencion =  $campos["total_iva_retencion"];
                    $total_retencion = $retencion;

                break;
            case 40:
                    //40-Servicios Varios (Arrendamiento)

                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL. ') as total');
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
                    $c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
                    $c->add(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
                    $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
                    $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                    $stmt = Tb045FacturaPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    $nu_monto =  $campos["total"];
                    $monto_total = $campos["total"];
        
                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_TOTAL_RETENCION. ') as total_retencion');
                    $c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
                    $c->add(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
                    $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
        
                    $stmt = Tb045FacturaPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    $retencion =  $campos["total_retencion"];
        
                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
                    $c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
                    $c->add(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
                    $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
                    $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        
                    $stmt = Tb045FacturaPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    $total_iva_retencion =  $campos["total_iva_retencion"];
        
                    $total_retencion = $retencion; //- $total_iva_retencion;
            
                break;

            case 1:
                    //Compras

                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL. ') as total');
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL_RETENCION. ') as total_retencion');
                    //$c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
                    //$c->add(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
                    $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                    $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
                    //echo $c->toString(); exit();
                    $stmt = Tb045FacturaPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    //$nu_monto =  $campos["total"]-$campos["total_iva_retencion"];
                    $nu_monto =  $campos["total"];
                    $monto_total = $campos["total"];
                    $retencion =  $campos["total_retencion"];
                    $total_iva_retencion =  $campos["total_iva_retencion"];
                    $total_retencion = $retencion;

                    $wherec = new Criteria();
                    $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $co_solicitud);
                    BasePeer::doDelete($wherec, $con);

            
                break;

            case 2:
                    //Servicios

                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL. ') as total');
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL_RETENCION. ') as total_retencion');
                    //$c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
                    //$c->add(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
                    $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                    $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
                    //echo $c->toString(); exit();
                    $stmt = Tb045FacturaPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    //$nu_monto =  $campos["total"]-$campos["total_iva_retencion"];
                    $nu_monto =  $campos["total"];
                    $monto_total = $campos["total"];
                    $retencion =  $campos["total_retencion"];
                    $total_iva_retencion =  $campos["total_iva_retencion"];
                    $total_retencion = $retencion;

                    $wherec = new Criteria();
                    $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $co_solicitud);
                    BasePeer::doDelete($wherec, $con);
        
                break;

            case 63:
                    //Compras Nuevo

                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL. ') as total');
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL_RETENCION. ') as total_retencion');
                    //$c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
                    //$c->add(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
                    $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                    $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
                    //echo $c->toString(); exit();
                    $stmt = Tb045FacturaPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    //$nu_monto =  $campos["total"]-$campos["total_iva_retencion"];
                    $nu_monto =  $campos["total"];
                    $monto_total = $campos["total"];
                    $retencion =  $campos["total_retencion"];
                    $total_iva_retencion =  $campos["total_iva_retencion"];
                    $total_retencion = $retencion;

                    $wherec = new Criteria();
                    $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $co_solicitud);
                    BasePeer::doDelete($wherec, $con);
        
                break;

            case 64:
                    //Servicios Nuevo

                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL. ') as total');
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL_RETENCION. ') as total_retencion');
                    //$c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
                    //$c->add(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
                    $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                    $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
                    //echo $c->toString(); exit();
                    $stmt = Tb045FacturaPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    //$nu_monto =  $campos["total"]-$campos["total_iva_retencion"];
                    $nu_monto =  $campos["total"];
                    $monto_total = $campos["total"];
                    $retencion =  $campos["total_retencion"];
                    $total_iva_retencion =  $campos["total_iva_retencion"];
                    $total_retencion = $retencion;

                    $wherec = new Criteria();
                    $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $co_solicitud);
                    BasePeer::doDelete($wherec, $con);
        
                break;

            case 65:
                    //Obras

                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL. ') as total');
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL_RETENCION. ') as total_retencion');
                    //$c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
                    //$c->add(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
                    $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                    $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
                    //echo $c->toString(); exit();
                    $stmt = Tb045FacturaPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    //$nu_monto =  $campos["total"]-$campos["total_iva_retencion"];
                    $nu_monto =  $campos["total"];
                    $monto_total = $campos["total"];
                    $retencion =  $campos["total_retencion"];
                    $total_iva_retencion =  $campos["total_iva_retencion"];
                    $total_retencion = $retencion;

                    $wherec = new Criteria();
                    $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $co_solicitud);
                    BasePeer::doDelete($wherec, $con);
        
                break; 
            
            case 68:
                    //Registro de factura

                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL. ') as total');
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
                    $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL_RETENCION. ') as total_retencion');
                    //$c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb045FacturaPeer::CO_ODP);
                    //$c->add(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
                    $c->add(Tb045FacturaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                    $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
                    //echo $c->toString(); exit();
                    $stmt = Tb045FacturaPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    //$nu_monto =  $campos["total"]-$campos["total_iva_retencion"];
                    $nu_monto =  $campos["total"];
                    $monto_total = $campos["total"];
                    $retencion =  $campos["total_retencion"];
                    $total_iva_retencion =  $campos["total_iva_retencion"];
                    $total_retencion = $retencion;

                    $wherec = new Criteria();
                    $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $co_solicitud);
                    BasePeer::doDelete($wherec, $con);
        
                break;            
            
            case 43:
                    //Prestaciones Sociales

                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('coalesce(SUM(' .  Tb087PresupuestoMovimientoPeer::NU_MONTO. '),0) as total');
                    $c->addJoin(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
                    $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
                    $c->add(Tb052ComprasPeer::CO_SOLICITUD,$co_solicitud);
                    $c->add(Tb087PresupuestoMovimientoPeer::IN_ACTIVO,true);
                    $c->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO,2);
                    $c->add(Tb087PresupuestoMovimientoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                    $c->add(Tb053DetalleComprasPeer::IN_PRESUPUESTO, TRUE);

                    $stmt = Tb087PresupuestoMovimientoPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    $c1 = new Criteria();
                    $c1->clearSelectColumns();
                    $c1->addSelectColumn('SUM(' .Tb046FacturaRetencionPeer::MO_RETENCION. ') as total_retencion');
                    $c1->add(Tb046FacturaRetencionPeer::CO_SOLICITUD,$co_solicitud);
                    $stmt1 = Tb046FacturaRetencionPeer::doSelectStmt($c1);
                    $campos1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        
                    //$nu_monto =  $campos["total"]-$campos["total_iva_retencion"];
                    $nu_monto =  $campos["total"];
                    $monto_total = $campos["total"];
                    $retencion =  $campos1["total_retencion"];
                    $total_retencion = $retencion;

                    $wherec = new Criteria();
                    $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $co_solicitud);
                    BasePeer::doDelete($wherec, $con);
        
                break;           
            
            case 41:
                    //Consignacion de documentos varios

                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('coalesce(SUM(' .  Tb087PresupuestoMovimientoPeer::NU_MONTO. '),0) as total');
                    $c->addJoin(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
                    $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
                    $c->add(Tb052ComprasPeer::CO_SOLICITUD,$co_solicitud);
                    $c->add(Tb087PresupuestoMovimientoPeer::IN_ACTIVO,true);
                    $c->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO,2);
                    $c->add(Tb087PresupuestoMovimientoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                    $c->add(Tb053DetalleComprasPeer::IN_PRESUPUESTO, TRUE);

                    $stmt = Tb087PresupuestoMovimientoPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    $c1 = new Criteria();
                    $c1->clearSelectColumns();
                    $c1->addSelectColumn('SUM(' .Tb046FacturaRetencionPeer::MO_RETENCION. ') as total_retencion');
                    $c1->add(Tb046FacturaRetencionPeer::CO_SOLICITUD,$co_solicitud);
                    $stmt1 = Tb046FacturaRetencionPeer::doSelectStmt($c1);
                    $campos1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        
                    //$nu_monto =  $campos["total"]-$campos["total_iva_retencion"];
                    $nu_monto =  $campos["total"];
                    $monto_total = $campos["total"];
                    $retencion =  $campos1["total_retencion"];
                    $total_retencion = $retencion;

                    $wherec = new Criteria();
                    $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $co_solicitud, Criteria::EQUAL);
                    BasePeer::doDelete($wherec, $con);
        
                break;             

            default:
                    //Otros

                    echo "llego"; exit();
                    $wherec = new Criteria();
                    $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $co_solicitud, Criteria::EQUAL);
                    BasePeer::doDelete($wherec, $con);

                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn('coalesce(SUM(' .  Tb087PresupuestoMovimientoPeer::NU_MONTO. '),0) as total');
                    $c->addJoin(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
                    $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
                    $c->add(Tb052ComprasPeer::CO_SOLICITUD,$co_solicitud);
                    $c->add(Tb087PresupuestoMovimientoPeer::IN_ACTIVO,true);
                    $c->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO,2);
                    $c->add(Tb087PresupuestoMovimientoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
                    $c->add(Tb053DetalleComprasPeer::IN_PRESUPUESTO, TRUE);

                    $stmt = Tb087PresupuestoMovimientoPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);

                    $nu_monto =  $campos["total"];
                    $monto_total = $nu_monto;

                break;
        }

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb060OrdenPagoPeer::CO_ORDEN_PAGO);
        $c->add(Tb060OrdenPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        $c->add(Tb060OrdenPagoPeer::CO_SOLICITUD,$co_solicitud);
        $c->add(Tb060OrdenPagoPeer::CO_RUTA,$co_ruta);
        $cant_orden_pago = Tb060OrdenPagoPeer::doCount($c);

        //echo $c->toString(); exit();
        
        $stmt = Tb060OrdenPagoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $co_orden_pago =  $campos["co_orden_pago"];

        

        $nu_monto_total = $nu_monto-$total_retencion;
        $nu_monto_no_retencion = $nu_monto;
        //$nu_monto_total = $nu_monto;

        //echo $total_retencion; exit();

    //    echo $cant_orden_pago; exit();

        switch ($cant_orden_pago) {
            case 0:

                        $c = new Criteria();
                        //$c->add(Tb060OrdenPagoPeer::NU_ANIO,date('Y'));
                        $c->add(Tb060OrdenPagoPeer::NU_ANIO, $ejercicio);
                        $cant = Tb060OrdenPagoPeer::doCount($c);

                        $cant+=1;
                        
                        if ($co_tipo_solicitud != 28 && $co_tipo_solicitud != 38){
                            if(date("Y")>$ejercicio){
                                $tx_serial = $ejercicio.'12-'.str_pad(self::getNuOrdenPago($co_solicitud,$con,$ejercicio), 5, "0", STR_PAD_LEFT);
                            }
                            else{
                                $tx_serial = date('Ym').'-'.str_pad(self::getNuOrdenPago($co_solicitud,$con,$ejercicio), 5, "0", STR_PAD_LEFT);
                            }
                        }else{
                            $tx_serial = '';
                        }
                        
                        if(date("Y")>$ejercicio){
                            $tx_docuemnto_odp = self::getTxSiglas($co_tipo_solicitud,$con).$ejercicio.'12-'.str_pad(self::getNuDocumentoPago($co_solicitud,$con,$ejercicio), 4, "0", STR_PAD_LEFT);
                        }else{
                            $tx_docuemnto_odp = self::getTxSiglas($co_tipo_solicitud,$con).date('Ym').'-'.str_pad(self::getNuDocumentoPago($co_solicitud,$con,$ejercicio), 4, "0", STR_PAD_LEFT);
                        }
                            
                        if(date("Y")>$ejercicio){
                            //$FeEmision = $ejercicio.'-12-31';
                            $FeEmision = $fe_pago; 
                        }else{
                            $FeEmision = date("Y-m-d"); 
                        } 

                        $Tb060OrdenPago = new Tb060OrdenPago();
                        $Tb060OrdenPago->setCoSolicitud($co_solicitud)
                            //->setFeEmision(date('Y-m-d'))
                            ->setFeEmision( $FeEmision)
                            //->setNuAnio(date('Y'))
                            ->setNuAnio( $ejercicio)
                            ->setMoPagar($nu_monto_total)
                            ->setMoRetencion($total_retencion)
                            ->setTxSerial($tx_serial)
                            ->setMoPendiente($nu_monto_total)
                            ->setMoPagado(0)
                            ->setTxDocumentoOdp($tx_docuemnto_odp)
                            ->setMoTotal($monto_total)
                            ->setCoRuta($co_ruta)
                            ->setInPagado(FALSE)
                            ->save($con);

                       // echo "llego ll"; exit();

                    if($co_tipo_solicitud == 23){
                        //LIQUIDACION DE NOMINA
//                        $c = new Criteria();
//                        $c->clearSelectColumns();
//                        $c->addSelectColumn('SUM(' .Tb123ArchivoPagoPeer::NU_MONTO. ') as total');
//                        $c->addSelectColumn(Tb010BancoPeer::NU_CODIGO);
//                        $c->addSelectColumn(Tb010BancoPeer::CO_BANCO);
//                        $c->addJoin(Tb123ArchivoPagoPeer::CO_PAGO_NOMINA, Tb122PagoNominaPeer::CO_PAGO_NOMINA);
//                        $c->addJoin(Tb123ArchivoPagoPeer::COD_BANCO, Tb010BancoPeer::NU_CODIGO);
//                        $c->add(Tb122PagoNominaPeer::CO_SOLICITUD,$co_solicitud);
//                        $c->addGroupByColumn(Tb010BancoPeer::NU_CODIGO);
//                        $c->addGroupByColumn(Tb010BancoPeer::CO_BANCO);
//
//                        echo $co_tipo_solicitud; exit();
//                        $stmt = Tb123ArchivoPagoPeer::doSelectStmt($c);
//                        $registros = "";
//                        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){

                            if(date("Y")>$ejercicio){
                                $FeEmision = $ejercicio.'-12-31'; 
                            }else{
                                $FeEmision = date("Y-m-d"); 
                            } 
                            
                            $Tb062LiquidacionPago = new Tb062LiquidacionPago();
                            $Tb062LiquidacionPago->setCoSolicitud($co_solicitud)
                                //->setFeEmision(date('Y-m-d'))
                                ->setFeEmision( $FeEmision)
                                //->setNuAnio(date('Y'))
                                ->setNuAnio( $ejercicio)
                                ->setMoPagar($nu_monto_total)
                                ->setMoPendiente($nu_monto_total)
                                ->setMoPagado(0)
                                ->setCoOdp($Tb060OrdenPago->getCoOrdenPago())
                                ->setCoTipoSolicitud($co_tipo_solicitud)                               
                                ->save($con);

//                        }
                
                
                    }else{            

                        if(date("Y")>$ejercicio){
                            $FeEmision = $ejercicio.'-12-31'; 
                        }else{
                            $FeEmision = date("Y-m-d"); 
                        } 

                        $Tb062LiquidacionPago = new Tb062LiquidacionPago();
                        $Tb062LiquidacionPago->setCoSolicitud($co_solicitud)
                                //->setFeEmision(date('Y-m-d'))
                                ->setFeEmision( $FeEmision)
                                //->setNuAnio(date('Y'))
                                ->setNuAnio( $ejercicio)
                                ->setMoPagar($nu_monto_total)
                                ->setMoPendiente($nu_monto_total)
                                ->setMoPagado(0)
                                ->setCoOdp($Tb060OrdenPago->getCoOrdenPago())
                                ->setCoTipoSolicitud($co_tipo_solicitud)
                                ->save($con);
                    }
            
                break;
            default:

                    $Tb060OrdenPago = Tb060OrdenPagoPeer::retrieveByPK($co_orden_pago);
                    $Tb060OrdenPago->setMoPagar($nu_monto_total)
                        ->setMoRetencion($total_retencion)
                        ->setMoPendiente($nu_monto_total)
                        ->setMoPagado(0)
                        ->setNuOrdenPago($nu_orden_pago)
                        ->setMoTotal($monto_total)
                        ->save($con);
            
                    $c = new Criteria();
                    $c->clearSelectColumns();
                    $c->addSelectColumn(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
                    $c->add(Tb062LiquidacionPagoPeer::CO_ODP,$Tb060OrdenPago->getCoOrdenPago());
                    $cant_liquidacion = Tb062LiquidacionPagoPeer::doCount($c);

                    $stmt = Tb062LiquidacionPagoPeer::doSelectStmt($c);
                    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
                    $co_liquidacion_pago =  $campos["co_liquidacion_pago"];

                    //echo $nu_monto_total; exit();            

                    $Tb062LiquidacionPago = Tb062LiquidacionPagoPeer::retrieveByPK($co_liquidacion_pago);
                    $Tb062LiquidacionPago->setCoSolicitud($co_solicitud)
                        ->setMoPagar($nu_monto_total)
                        ->setMoPendiente($nu_monto_total)
                        ->setMoPagado(0)
                        ->setCoOdp($Tb060OrdenPago->getCoOrdenPago())
                        ->setCoTipoSolicitud($co_tipo_solicitud)
                        ->save($con);

                break;
        }

        //echo $co_tipo_solicitud; exit();

        if($co_tipo_solicitud > 0 && $co_tipo_solicitud!=28){
            
                    $co_cuenta_por_pagar = Tb130CuentaDocumentoPeer::getCoCuentaContable($co_solicitud);
            
                    if($co_tipo_solicitud==26){
                        
                            //echo $co_tipo_solicitud; exit();
                        
                            $c = new Criteria();                           
                            $c->add(Tb045FacturaPeer::CO_SOLICITUD, $co_solicitud,Criteria::EQUAL);
                            $stmt = Tb045FacturaPeer::doSelectStmt($c);

                            while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
                                
                                $tb061_asiento_contable = new Tb061AsientoContable();
                                $tb061_asiento_contable->setMoHaber($reg["nu_total"])
                                                       ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"])
                                                       ->setCoSolicitud($co_solicitud)
                                                       ->setCoFactura($reg["co_factura"])
//                                                       ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                                       ->setCoRuta($co_ruta)
                                                       ->setCoTipoAsiento(1)
                                                       ->save($con);
                                
                                $cd = new Criteria();                           
                                $cd->add(Tb053DetalleComprasPeer::CO_FACTURA, $reg["co_factura"]);
                                $cd->add(Tb053DetalleComprasPeer::IN_PRESUPUESTO, TRUE);
                                $stmtd = Tb053DetalleComprasPeer::doSelectStmt($cd);

                                while($reg_compra = $stmtd->fetch(PDO::FETCH_ASSOC)){

                                    
                                          $cuenta_contable = Tb024CuentaContablePeer::getCuentaContable($reg_compra["co_producto"], $co_solicitud);
                                    
                                          
                                          if($reg_compra["co_producto"]==19336){
                                          
                                            $tb061_asiento_contable = new Tb061AsientoContable();
                                            $tb061_asiento_contable->setMoDebe($reg_compra["monto"])
                                                                  ->setCoCuentaContable($cuenta_contable["co_cuenta_contable"])
                                                                  ->setCoSolicitud($co_solicitud)
                                                                  ->setCoProducto(19336)
                                                                  ->setCoFactura($reg["co_factura"])
//                                                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                                                  ->setCoTipoAsiento(1)
                                                                  ->setCoPresupuesto($reg_compra["co_presupuesto"])
                                                                  ->setCoRuta($co_ruta)
                                                                  ->save($con);
                                          
                                          }else{
                                            $tb061_asiento_contable = new Tb061AsientoContable();
                                            $tb061_asiento_contable->setMoDebe($reg_compra["monto"])
                                                                  ->setCoCuentaContable($cuenta_contable["co_cuenta_contable"])
                                                                  ->setCoSolicitud($co_solicitud)
                                                                  ->setCoProducto($reg_compra["co_producto"])
                                                                  ->setCoFactura($reg["co_factura"])
//                                                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                                                  ->setCoTipoAsiento(1)
                                                                  ->setCoPresupuesto($reg_compra["co_presupuesto"])
                                                                  ->setCoRuta($co_ruta)
                                                                  ->save($con);                                          
                                          }
                                        

                                }
                                
                               
                                
                                $tb061_asiento_contable = new Tb061AsientoContable();
                                $tb061_asiento_contable->setMoHaber($reg["nu_total"])
                                                  ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_orden_pago"])
                                                  ->setCoSolicitud($co_solicitud)
                                                  ->setCoFactura($reg["co_factura"])
//                                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))                            
                                                  ->setCoTipoAsiento(2)
                                                  ->setCoRuta($co_ruta)
                                                  ->save($con);

                                $tb061_asiento_contable = new Tb061AsientoContable();
                                $tb061_asiento_contable->setMoDebe($reg["nu_total"])
                                                  ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"])
                                                  ->setCoSolicitud($co_solicitud)
                                                  ->setCoFactura($reg["co_factura"])
//                                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                                  ->setCoTipoAsiento(2)
                                                  ->setCoRuta($co_ruta)
                                                  ->save($con);                                  
                            }
                            
                    }else if($co_tipo_solicitud == 39 || $co_tipo_solicitud == 40){ 

                            //echo $co_tipo_solicitud; exit();
                        
                            $wherec = new Criteria();
                            $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $co_solicitud, Criteria::EQUAL);
                            BasePeer::doDelete($wherec, $con);
            
                            $tb061_asiento_contable = new Tb061AsientoContable();
                            $tb061_asiento_contable->setMoHaber($nu_monto)
                                          ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"])
                                          ->setCoSolicitud($co_solicitud)
                                          ->setCoTipoAsiento(1)
        //                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                            ->setCoRuta($co_ruta)
                                          ->save($con);

                            $c = new Criteria();
                            $c->clearSelectColumns();
                            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRODUCTO);
                            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
                            $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
                            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
                            $c->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
                            $c->add(Tb052ComprasPeer::CO_SOLICITUD, $co_solicitud,Criteria::EQUAL);
                            $c->add(Tb053DetalleComprasPeer::IN_PRESUPUESTO, TRUE);

                            $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);

                            while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
                                
                                $cuenta_contable = Tb024CuentaContablePeer::getCuentaContable($reg["co_producto"], $co_solicitud,$reg["co_presupuesto"]);

                                $tb061_asiento_contable = new Tb061AsientoContable();
                                $tb061_asiento_contable->setMoDebe($reg["monto"])
                                                  ->setCoCuentaContable($cuenta_contable["co_cuenta_contable"])
                                                  ->setCoSolicitud($co_solicitud)
                                                  ->setCoProducto($reg["co_producto"])
                                                  ->setCoTipoAsiento(1)
                                                  ->setCoPresupuesto($reg["co_presupuesto"])
        //                                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                                    ->setCoRuta($co_ruta)
                                                  ->save($con);
                            }

                            $tb061_asiento_contable = new Tb061AsientoContable();
                            $tb061_asiento_contable->setMoDebe($nu_monto)
                                          ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"])
                                          ->setCoSolicitud($co_solicitud)
                                          ->setCoTipoAsiento(2)
        //                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                            ->setCoRuta($co_ruta)
                                          ->save($con);

                            $tb061_asiento_contable = new Tb061AsientoContable();
                            $tb061_asiento_contable->setMoHaber($nu_monto)
                                          ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_orden_pago"])
                                          ->setCoSolicitud($co_solicitud)
                                          ->setCoTipoAsiento(2)
        //                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                            ->setCoRuta($co_ruta)
                                          ->save($con);
                        
                    }else{

                        //echo $co_tipo_solicitud; exit();

                            if(date("Y")>$ejercicio){
                                $fe_pago = $fe_pago.date(' h:i:s'); 
                            }else{
                                $fe_pago = date("Y-m-d"); 
                            }

                            if($co_tipo_solicitud==1){
                                $nu_monto_total = $nu_monto_no_retencion;
                            }

                            if($co_tipo_solicitud==2){
                                $nu_monto_total = $nu_monto_no_retencion;
                            }
                            
                            if($co_tipo_solicitud==41){
                                $nu_monto_total = $nu_monto_no_retencion;
                            }                            
                          
                            if($co_tipo_solicitud==43){
                                $nu_monto_total = $nu_monto_no_retencion;
                            }  
                            
                            if($co_tipo_solicitud==63){
                                $nu_monto_total = $nu_monto_no_retencion;
                            }

                            if($co_tipo_solicitud==64){
                                $nu_monto_total = $nu_monto_no_retencion;
                            }

                            if($co_tipo_solicitud==65){
                                $nu_monto_total = $nu_monto_no_retencion;
                            }      
                            
                            if($co_tipo_solicitud==68){
                                $nu_monto_total = $nu_monto_no_retencion;
                            }                             
                            
                            $tb061_asiento_contable = new Tb061AsientoContable();
                            $tb061_asiento_contable->setMoHaber($nu_monto_total)
                                          ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"])
                                          ->setCoSolicitud($co_solicitud)
                                          ->setCoTipoAsiento(1)
                                          ->setCreatedAt($fe_pago)
                                          ->setCoRuta($co_ruta)
        //                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                          ->save($con);

                            $c = new Criteria();
                            $c->clearSelectColumns();
                            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRODUCTO);
                            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
                            $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
                            //$c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
                            $c->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
                            $c->add(Tb052ComprasPeer::CO_SOLICITUD, $co_solicitud,Criteria::EQUAL);
                            $c->add(Tb053DetalleComprasPeer::IN_PRESUPUESTO, TRUE);

                            $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);

                            while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
                                
                                $cuenta_contable = Tb024CuentaContablePeer::getCuentaContable($reg["co_producto"], $co_solicitud,$reg["co_presupuesto"]);

                                $tb061_asiento_contable = new Tb061AsientoContable();
                                $tb061_asiento_contable->setMoDebe($reg["monto"])
                                                  ->setCoCuentaContable($cuenta_contable["co_cuenta_contable"])
                                                  ->setCoSolicitud($co_solicitud)
                                                  ->setCoProducto($reg["co_producto"])
                                                  ->setCoTipoAsiento(1)
                                                  ->setCreatedAt($fe_pago)
                                                  ->setCoPresupuesto($reg["co_presupuesto"])
                                                  ->setCoRuta($co_ruta)
        //                                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                                  ->save($con);
                            }

                            //var_dump($stmt);
                            //echo $c->toString(); exit();

                        switch ($co_tipo_solicitud) {
                            case 43:

                                    $tb061_asiento_contable = new Tb061AsientoContable();
                                    $tb061_asiento_contable->setMoHaber($nu_monto_no_retencion);
                                    $tb061_asiento_contable->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_orden_pago"]);
                                    $tb061_asiento_contable->setCoSolicitud($co_solicitud);
                                    $tb061_asiento_contable->setCoTipoAsiento(2);
                                    $tb061_asiento_contable->setCreatedAt($fe_pago);
                                    $tb061_asiento_contable->save($con);

                                    $c4 = new Criteria();   
                                    $c4->setIgnoreCase(true);
                                    $c4->clearSelectColumns();
                                    $c4->addSelectColumn(Tb052ComprasPeer::CO_PROVEEDOR);
                                    $c4->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
                                    //$c4->addSelectColumn(Tb085PresupuestoPeer::CO_CUENTA_CONTABLE);
                                    $c4->addAsColumn('co_cuenta_contable', Tb048ProductoPeer::ID_TB024_CUENTA_CONTABLE);
                                    $c4->addSelectColumn(Tb024CuentaContablePeer::TX_CUENTA);
                                    $c4->addSelectColumn('SUM('.Tb053DetalleComprasPeer::MONTO.') as monto');
                                    $c4->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
                                    //$c4->addJoin(Tb053DetalleComprasPeer::CO_PRESUPUESTO, Tb085PresupuestoPeer::ID);
                                    $c4->addJoin(Tb053DetalleComprasPeer::CO_PRODUCTO, Tb048ProductoPeer::CO_PRODUCTO);
                                    $c4->addJoin(Tb048ProductoPeer::ID_TB024_CUENTA_CONTABLE, Tb024CuentaContablePeer::CO_CUENTA_CONTABLE);
                                    $c4->add(Tb052ComprasPeer::CO_SOLICITUD, $co_solicitud,Criteria::EQUAL);
                                    $c4->add(Tb053DetalleComprasPeer::IN_PRESUPUESTO, TRUE);

                                    $c4->addGroupByColumn(Tb052ComprasPeer::CO_PROVEEDOR);
                                    $c4->addGroupByColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
                                    //$c4->addGroupByColumn(Tb085PresupuestoPeer::CO_CUENTA_CONTABLE);
                                    $c4->addGroupByColumn(Tb048ProductoPeer::ID_TB024_CUENTA_CONTABLE);
                                    $c4->addGroupByColumn(Tb024CuentaContablePeer::TX_CUENTA);
                                    $stmt4 = Tb052ComprasPeer::doSelectStmt($c4);

                                    $i=0;
                                    while($reg_compras = $stmt4->fetch(PDO::FETCH_ASSOC)){

                                        $cc_proveedor = Tb024CuentaContablePeer::getNuCodigoProveedor( $reg_compras["co_proveedor"]);
                                        $cc_madre = Tb024CuentaContablePeer::getNuCodigoCuentaContable( $reg_compras["co_cuenta_contable"]);

                                        if($reg_compras["co_cuenta_contable"]==97795){
                                            $cc_movimiento = Tb130CuentaDocumentoPeer::getCuentaContable($cc_madre['nu_cuenta_contable'], $cc_madre["tx_descripcion"].' '.$cc_proveedor['tx_razon_social']);                                                                        
                                        }else{
                                            $cc_movimiento = Tb130CuentaDocumentoPeer::getCuentaContable($cc_madre['nu_cuenta_contable'].$cc_proveedor['nu_codigo'], $cc_madre["tx_descripcion"].' '.$cc_proveedor['tx_razon_social']);
                                        } 

                                        $tb061_asiento_contable = new Tb061AsientoContable();
                                        $tb061_asiento_contable->setMoDebe($reg_compras["monto"]);
                                        //$tb061_asiento_contable->setCoCuentaContable($reg_compras["co_cuenta_contable"]);
                                        $tb061_asiento_contable->setCoCuentaContable($cc_movimiento);
                                        $tb061_asiento_contable->setCoSolicitud($co_solicitud);
                                        //$tb061_asiento_contable->setCoProducto($reg_compras["co_producto"]);
                                        $tb061_asiento_contable->setCoTipoAsiento(2);
                                        $tb061_asiento_contable->setCreatedAt($fe_pago);
                                        $tb061_asiento_contable->setCoPresupuesto($reg_compras["co_presupuesto"]);
                                        $tb061_asiento_contable->save($con);

                                        $i++;
                                    }

                                    //exit();

                                break;

                            case 1:
                                $tb061_asiento_contable = new Tb061AsientoContable();
                                $tb061_asiento_contable->setMoDebe($nu_monto_no_retencion);
                                $tb061_asiento_contable->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"]);
                                $tb061_asiento_contable->setCoSolicitud($co_solicitud);
                                $tb061_asiento_contable->setCoTipoAsiento(2);
                                $tb061_asiento_contable->setCreatedAt($fe_pago);
                                $tb061_asiento_contable->setCoRuta($co_ruta);
                                $tb061_asiento_contable->save($con);

                                $tb061_asiento_contable = new Tb061AsientoContable();
                                $tb061_asiento_contable->setMoHaber($nu_monto_no_retencion);
                                $tb061_asiento_contable->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_orden_pago"]);
                                $tb061_asiento_contable->setCoSolicitud($co_solicitud);
                                $tb061_asiento_contable->setCoTipoAsiento(2);
                                $tb061_asiento_contable->setCreatedAt($fe_pago);
                                $tb061_asiento_contable->setCoRuta($co_ruta);
                                $tb061_asiento_contable->save($con);

                                break;

                            case 2:
                                $tb061_asiento_contable = new Tb061AsientoContable();
                                $tb061_asiento_contable->setMoDebe($nu_monto_no_retencion);
                                $tb061_asiento_contable->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"]);
                                $tb061_asiento_contable->setCoSolicitud($co_solicitud);
                                $tb061_asiento_contable->setCoTipoAsiento(2);
                                $tb061_asiento_contable->setCreatedAt($fe_pago);
                                $tb061_asiento_contable->setCoRuta($co_ruta);
                                $tb061_asiento_contable->save($con);

                                $tb061_asiento_contable = new Tb061AsientoContable();
                                $tb061_asiento_contable->setMoHaber($nu_monto_no_retencion);
                                $tb061_asiento_contable->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_orden_pago"]);
                                $tb061_asiento_contable->setCoSolicitud($co_solicitud);
                                $tb061_asiento_contable->setCoTipoAsiento(2);
                                $tb061_asiento_contable->setCreatedAt($fe_pago);
                                $tb061_asiento_contable->setCoRuta($co_ruta);
                                $tb061_asiento_contable->save($con);

                                break;

                            default:
                                    $tb061_asiento_contable = new Tb061AsientoContable();
                                    $tb061_asiento_contable->setMoDebe($nu_monto_no_retencion);
                                    $tb061_asiento_contable->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"]);
                                    $tb061_asiento_contable->setCoSolicitud($co_solicitud);
                                    $tb061_asiento_contable->setCoTipoAsiento(2);
                                    $tb061_asiento_contable->setCreatedAt($fe_pago);
                                    $tb061_asiento_contable->setCoRuta($co_ruta);
                                    $tb061_asiento_contable->save($con);

                                    $tb061_asiento_contable = new Tb061AsientoContable();
                                    $tb061_asiento_contable->setMoHaber($nu_monto_no_retencion);
                                    $tb061_asiento_contable->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_orden_pago"]);
                                    $tb061_asiento_contable->setCoSolicitud($co_solicitud);
                                    $tb061_asiento_contable->setCoTipoAsiento(2);
                                    $tb061_asiento_contable->setCreatedAt($fe_pago);
                                    $tb061_asiento_contable->setCoRuta($co_ruta);
                                    $tb061_asiento_contable->save($con);

                                break;
                        }
                    
                    }
        }

        return $Tb060OrdenPago->getCoOrdenPago();
    }

     static public function generarODPExpress($co_solicitud,$con){


        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn('SUM(' .Tb045FacturaPeer::NU_TOTAL. ') as total');
        $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
        $stmt = Tb045FacturaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $nu_monto =  $campos["total"];

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_TOTAL_RETENCION. ') as total_retencion');
        $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);

        $stmt = Tb045FacturaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $retencion =  $campos["total_retencion"];

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn('SUM(' . Tb045FacturaPeer::NU_IVA_RETENCION. ') as total_iva_retencion');
        $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);

        $stmt = Tb045FacturaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $total_iva_retencion =  $campos["total_iva_retencion"];

        $total_retencion = $retencion - $total_iva_retencion;

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb060OrdenPagoPeer::CO_ORDEN_PAGO);
        $c->add(Tb060OrdenPagoPeer::CO_SOLICITUD,$co_solicitud);
        $cant_orden_pago = Tb060OrdenPagoPeer::doCount($c);

        $stmt = Tb060OrdenPagoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $co_orden_pago =  $campos["co_orden_pago"];


        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
        $c->add(Tb062LiquidacionPagoPeer::CO_SOLICITUD,$co_solicitud);
        $cant_liquidacion = Tb062LiquidacionPagoPeer::doCount($c);

        $stmt = Tb062LiquidacionPagoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $co_liquidacion_pago =  $campos["co_liquidacion_pago"];

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb026SolicitudPeer::CO_TIPO_SOLICITUD);
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD,$co_solicitud);

        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $co_tipo_solicitud =  $campos["co_tipo_solicitud"];


        $nu_monto_total = $nu_monto-$total_retencion;

        if($cant_orden_pago == 0){

            $c = new Criteria();
            //$c->add(Tb060OrdenPagoPeer::NU_ANIO,date('Y'));
            $c->add(Tb060OrdenPagoPeer::NU_ANIO, $ejercicio);
            $cant = Tb060OrdenPagoPeer::doCount($c);

            $cant+=1;
           

            if(date("Y")>$ejercicio){
                //$FeEmision = $ejercicio.'-12-31';
                $FeEmision = $fe_pago;
                $tx_serial = $ejercicio.'12'.'-'.str_pad($cant, 5, "0", STR_PAD_LEFT);
            }else{
                $FeEmision = date("Y-m-d"); 
                $tx_serial = date('Ym').'-'.str_pad($cant, 5, "0", STR_PAD_LEFT);
            }  

            $Tb060OrdenPago = new Tb060OrdenPago();
            $Tb060OrdenPago->setCoSolicitud($co_solicitud)
                           //->setFeEmision(date('Y-m-d'))
                           ->setFeEmision( $FeEmision)
                           //->setNuAnio(date('Y'))
                           ->setNuAnio($ejercicio)
                           ->setMoPagar($nu_monto_total)
                           ->setMoRetencion($total_retencion)
                           ->setTxSerial($tx_serial)
                           ->setMoPendiente($nu_monto_total)
                           ->setMoPagado(0)
                           ->save($con);

            $Tb062LiquidacionPago = new Tb062LiquidacionPago();
            $Tb062LiquidacionPago->setCoSolicitud($co_solicitud)
                           //->setFeEmision(date('Y-m-d'))
                           ->setFeEmision( $FeEmision)
                           //->setNuAnio(date('Y'))
                           ->setNuAnio($ejercicio)
                           ->setMoPagar($nu_monto_total)
                           ->setMoPendiente($nu_monto_total)
                           ->setMoPagado(0)
                           ->setCoTipoSolicitud($co_tipo_solicitud)
                           ->save($con);
        }else{

            $Tb060OrdenPago = Tb060OrdenPagoPeer::retrieveByPK($co_orden_pago);
            $Tb060OrdenPago->setMoPagar($nu_monto_total)
                           ->setMoRetencion($total_retencion)
                           ->setMoPendiente($nu_monto_total)
                           ->setMoPagado(0)
                           ->save($con);

            $Tb062LiquidacionPago = Tb062LiquidacionPagoPeer::retrieveByPK($co_liquidacion_pago);
            $Tb062LiquidacionPago->setCoSolicitud($co_solicitud)
                           ->setMoPagar($nu_monto_total)
                           ->setMoPendiente($nu_monto_total)
                           ->setMoPagado(0)
                           ->setCoTipoSolicitud($co_tipo_solicitud)
                           ->save($con);


        }
    }

    static public function generarODPViatico($co_solicitud,$con){


        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn('coalesce(SUM(' .  Tb087PresupuestoMovimientoPeer::NU_MONTO. '),0) as total');
        $c->addJoin(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD,$co_solicitud);
        $c->add(Tb087PresupuestoMovimientoPeer::IN_ACTIVO,true);
        $c->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO,2);
        $c->add(Tb053DetalleComprasPeer::IN_PRESUPUESTO, TRUE);


        $stmt = Tb087PresupuestoMovimientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $nu_monto_total =  $campos["total"];

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb060OrdenPagoPeer::CO_ORDEN_PAGO);
        $c->add(Tb060OrdenPagoPeer::CO_SOLICITUD,$co_solicitud);
        $cant_orden_pago = Tb060OrdenPagoPeer::doCount($c);

        $stmt = Tb060OrdenPagoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $co_orden_pago =  $campos["co_orden_pago"];


        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
        $c->add(Tb062LiquidacionPagoPeer::CO_SOLICITUD,$co_solicitud);
        $cant_liquidacion = Tb062LiquidacionPagoPeer::doCount($c);

        $stmt = Tb062LiquidacionPagoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $co_liquidacion_pago =  $campos["co_liquidacion_pago"];

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb026SolicitudPeer::CO_TIPO_SOLICITUD);
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD,$co_solicitud);

        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $co_tipo_solicitud =  $campos["co_tipo_solicitud"];


        if($cant_orden_pago == 0){

            $c = new Criteria();
            //$c->add(Tb060OrdenPagoPeer::NU_ANIO,date('Y'));
            $c->add(Tb060OrdenPagoPeer::NU_ANIO, $ejercicio);
            $cant = Tb060OrdenPagoPeer::doCount($c);

            $cant+=1;
            

            if(date("Y")>$ejercicio){
                //$FeEmision = $ejercicio.'-12-31';
                $FeEmision = $fe_pago;
                $tx_serial = $ejercicio.'12-'.str_pad($cant, 5, "0", STR_PAD_LEFT);
            }else{
                $FeEmision = date("Y-m-d"); 
                $tx_serial = date('Ym').'-'.str_pad($cant, 5, "0", STR_PAD_LEFT);
            }  

            $Tb060OrdenPago = new Tb060OrdenPago();
            $Tb060OrdenPago->setCoSolicitud($co_solicitud)
                           //->setFeEmision(date('Y-m-d'))
                           ->setFeEmision( $FeEmision)
                           //->setNuAnio(date('Y'))
                           ->setNuAnio( $ejercicio)
                           ->setMoPagar($nu_monto_total)
                           ->setMoRetencion(0)
                           ->setTxSerial($tx_serial)
                           ->setMoPendiente($nu_monto_total)
                           ->setMoPagado(0)
                           ->save($con);

            $Tb062LiquidacionPago = new Tb062LiquidacionPago();
            $Tb062LiquidacionPago->setCoSolicitud($co_solicitud)
                           //->setFeEmision(date('Y-m-d'))
                           ->setFeEmision( $FeEmision)
                           //->setNuAnio(date('Y'))
                           ->setNuAnio( $ejercicio)
                           ->setMoPagar($nu_monto_total)
                           ->setMoPendiente($nu_monto_total)
                           ->setMoPagado(0)
                           ->setCoTipoSolicitud($co_tipo_solicitud)
                           ->save($con);
        }else{

            $Tb060OrdenPago = Tb060OrdenPagoPeer::retrieveByPK($co_orden_pago);
            $Tb060OrdenPago->setMoPagar($nu_monto_total)
                           ->setMoRetencion(0)
                           ->setMoPendiente($nu_monto_total)
                           ->setMoPagado(0)
                           ->save($con);

            $Tb062LiquidacionPago = Tb062LiquidacionPagoPeer::retrieveByPK($co_liquidacion_pago);
            $Tb062LiquidacionPago->setCoSolicitud($co_solicitud)
                           ->setMoPagar($nu_monto_total)
                           ->setMoPendiente($nu_monto_total)
                           ->setMoPagado(0)
                           ->setCoTipoSolicitud($co_tipo_solicitud)
                           ->save($con);


        }
    }
}
