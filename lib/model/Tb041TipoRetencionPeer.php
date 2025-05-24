<?php

class Tb041TipoRetencionPeer extends BaseTb041TipoRetencionPeer
{
    static public function getCuentaContable($co_tipo_retencion){
         
         $c = new Criteria();
         $c->add(Tb041TipoRetencionPeer::CO_TIPO_RETENCION,$co_tipo_retencion);
         $stmt = Tb041TipoRetencionPeer::doSelectStmt($c);
         $campos = $stmt->fetch(PDO::FETCH_ASSOC);
         
         return $campos["co_cuenta_contable"];
    }
    
    static public function getCuentaContableTipoRetencion($tx_movimiento){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb041TipoRetencionPeer::CO_CUENTA_CONTABLE);
        $c->add(Tb041TipoRetencionPeer::TX_MOVIMIENTO,$tx_movimiento);
        $stmt = Tb041TipoRetencionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
    }    
    
}
