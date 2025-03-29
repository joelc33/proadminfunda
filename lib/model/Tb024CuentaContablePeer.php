<?php

class Tb024CuentaContablePeer extends BaseTb024CuentaContablePeer
{
    static public function getCuentaContable($co_detalle_compras,$co_solicitud,$co_presupuesto=''){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb085PresupuestoPeer::CO_CUENTA_CONTABLE);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->addSelectColumn(Tb209PresupuestoDetalleCompraPeer::CO_PRESUPUESTO);
        $c->addJoin(Tb209PresupuestoDetalleCompraPeer::CO_DETALLE_COMPRA, Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->addJoin(Tb085PresupuestoPeer::ID, Tb209PresupuestoDetalleCompraPeer::CO_PRESUPUESTO);
        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
//        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb045FacturaPeer::CO_COMPRA);
        
        if($co_detalle_compras!='')
          $c->add(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS,$co_detalle_compras);
        else {
          $c->add(Tb209PresupuestoDetalleCompraPeer::CO_PRESUPUESTO,$co_presupuesto);
        }


//        $c->add(Tb045FacturaPeer::CO_SOLICITUD,$co_solicitud);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD,$co_solicitud);
        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
    }
    
    static public function getCuentaContableProveedorRetencion($co_proveedor,$co_retencion){
                
        $proveedor          = self::getNuCodigoProveedor($co_proveedor);
        $tx_cuenta_contable = self::getNuCodigoCuenta($co_retencion);
        
        $co_cuenta = self::getBuscarCuenta($proveedor, $tx_cuenta_contable);  
        
        return $co_cuenta;
        
    }
    
    static public function getBuscarCuenta($proveedor,$tx_cuenta_contable){    

        echo "cuenta"; exit();    
     
       
        $cuenta = $tx_cuenta_contable["tx_cuenta"].$proveedor["nu_codigo"];       
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE);
        $c->add(Tb024CuentaContablePeer::TX_CUENTA,$cuenta);
        
        $cant = Tb024CuentaContablePeer::doCount($c);
        
        if($cant>0){
            $stmt = Tb024CuentaContablePeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);         
            return $campos["co_cuenta_contable"];
        }else{            
            $Tb024CuentaContable = new Tb024CuentaContable();
            $Tb024CuentaContable->setTxCuenta($cuenta)
                                ->setTxDescripcion($tx_cuenta_contable["tx_descripcion"].' '.$proveedor["tx_razon_social"])
                                ->setNuNivel(6) 
                                ->save(); 
            
            return $Tb024CuentaContable->getCoCuentaContable();
        }        
    }
    
    static public function getNuCodigoProveedor($codigo){
      
        $c = new Criteria();
        $c->add(Tb008ProveedorPeer::CO_PROVEEDOR,$codigo);
        $stmt = Tb008ProveedorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos; 
    }
    
    static public function getNuCodigoCuenta($codigo){
      
        $c = new Criteria();
        $c->addJoin(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Tb041TipoRetencionPeer::CO_CUENTA_CONTABLE);
        $c->add(Tb041TipoRetencionPeer::CO_TIPO_RETENCION,$codigo);
        $stmt = Tb024CuentaContablePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos; 
    }

    static public function getNuCodigoCuentaContable($codigo){
      
        $c = new Criteria();
        $c->add(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE,$codigo);
        $stmt = Tb024CuentaContablePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos; 
    }
    
}
