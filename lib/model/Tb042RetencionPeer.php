<?php

class Tb042RetencionPeer extends BaseTb042RetencionPeer
{
    
        static public function getTipoRetencion ($co_documento,$co_proveedor){
            
            $c = new Criteria();
            $c->addSelectColumn(Tb042RetencionPeer::CO_TIPO_RETENCION);
            $c->addSelectColumn(Tb042RetencionPeer::NU_VALOR);
            $c->addSelectColumn(Tb042RetencionPeer::NU_SUSTRAENDO);
            $c->addSelectColumn(Tb042RetencionPeer::CO_RAMO);
            $c->addSelectColumn(Tb042RetencionPeer::MO_MINIMO);
            $c->addSelectColumn(Tb041TipoRetencionPeer::TX_TIPO_RETENCION);
            $c->addSelectColumn(Tb041TipoRetencionPeer::CO_TIPO_RETENCION);
            $c->addJoin(Tb041TipoRetencionPeer::CO_TIPO_RETENCION, Tb042RetencionPeer::CO_TIPO_RETENCION);
            $c->addJoin(Tb071RetencionProveedorPeer::CO_TIPO_RETENCION, Tb042RetencionPeer::CO_TIPO_RETENCION);            
            $c->add(Tb042RetencionPeer::CO_DOCUMENTO,$co_documento);
            $c->add(Tb071RetencionProveedorPeer::CO_PROVEEDOR,$co_proveedor);
            $c->add(Tb041TipoRetencionPeer::IN_ACTIVO,TRUE);
            
            echo $c->toString(); exit();

            return  Tb042RetencionPeer::doSelectStmt($c);
            
        }
}
