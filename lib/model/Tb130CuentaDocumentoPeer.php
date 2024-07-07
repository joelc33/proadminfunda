<?php

class Tb130CuentaDocumentoPeer extends BaseTb130CuentaDocumentoPeer
{
    static public  function getCoCuentaContable($codigo){
        
        /*datos */
        $cs = new Criteria();
        $cs->clearSelectColumns();
        $cs->addSelectColumn(Tb026SolicitudPeer::CO_TIPO_SOLICITUD);
        $cs->addSelectColumn(Tb026SolicitudPeer::CO_PROVEEDOR);
        $cs->add(Tb026SolicitudPeer::CO_SOLICITUD,$codigo);
        $stmts = Tb026SolicitudPeer::doSelectStmt($cs);
        $datos_solicitud = $stmts->fetch(PDO::FETCH_ASSOC);
        $co_tipo_solicitud =  $datos_solicitud["co_tipo_solicitud"];
        
        
         
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb130CuentaDocumentoPeer::CO_CUENTA_GASTO_PAGO);
        $c->addSelectColumn(Tb130CuentaDocumentoPeer::CO_CUENTA_ORDEN_PAGO);
        $c->addSelectColumn(Tb130CuentaDocumentoPeer::TX_CUENTA_GASTO);
        $c->addSelectColumn(Tb130CuentaDocumentoPeer::TX_CUENTA_ODP);
        $c->addSelectColumn(Tb130CuentaDocumentoPeer::TX_DOCUMENTO);
        $c->add(Tb130CuentaDocumentoPeer::CO_TIPO_SOLICITUD,$co_tipo_solicitud);        
        $stmt = Tb130CuentaDocumentoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        if($datos_solicitud["co_proveedor"]!=''){
            $datos_proveedor = Tb008ProveedorPeer::retrieveByPK($datos_solicitud["co_proveedor"]);
            
            $tx_descripcion = $campos["tx_documento"].' '. strtoupper($datos_proveedor->getTxRazonSocial());
             
            $tx_cuenta_gasto = $campos["tx_cuenta_gasto"].$datos_proveedor->getNuCodigo();
            
//            $tx_cuenta_gasto = $campos["tx_cuenta_gasto"];
                      
            $campos["co_cuenta_gasto_pago"]=self::getCuentaContable($tx_cuenta_gasto,$tx_descripcion);
            
            $tx_cuenta_odp = $campos["tx_cuenta_odp"].$datos_proveedor->getNuCodigo();  
//            $tx_cuenta_odp = $campos["tx_cuenta_odp"];
            $campos["co_cuenta_orden_pago"]=self::getCuentaContable($tx_cuenta_odp,$tx_descripcion);
            
        }else{
            
            $tx_descripcion = $campos["tx_documento"];
             
            $tx_cuenta_gasto = $campos["tx_cuenta_gasto"];
                      
            $campos["co_cuenta_gasto_pago"]=self::getCuentaContable($tx_cuenta_gasto,$tx_descripcion);
            
            $tx_cuenta_odp = $campos["tx_cuenta_odp"];            
            $campos["co_cuenta_orden_pago"]=self::getCuentaContable($tx_cuenta_odp,$tx_descripcion);
            
            
        }
        
        
        
        return $campos;
        
    }   
    
    static function getCuentaContable($tx_cuenta,$tx_descripcion){
        
        
        $c = new Criteria();
        $c->add(Tb024CuentaContablePeer::NU_CUENTA_CONTABLE,$tx_cuenta);     
        
        $cant = Tb024CuentaContablePeer::doCount($c);
        
        if($cant > 0){
           
            $stmt = Tb024CuentaContablePeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $campos["co_cuenta_contable"];
            
        }else{
            
            
            $Tb024CuentaContable = new Tb024CuentaContable();
            $Tb024CuentaContable->setNuCuentaContable($tx_cuenta)
                                ->setTxCodigoCuenta($tx_cuenta)
                                ->setTxDescripcion($tx_descripcion)
                                ->setTxTipo('S')
                                ->setTxCuenta('S')
                                ->setNuNivel(6)
                                ->save();
                      
            
            return $Tb024CuentaContable->getCoCuentaContable();           
            
        }
        
       
        
        
    }
    
}
