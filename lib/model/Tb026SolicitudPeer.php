<?php

class Tb026SolicitudPeer extends BaseTb026SolicitudPeer
{
    static public function getCantRevision($co_solicitud){
        $cs = new Criteria();
        $cs->add(Tb034RevisionPeer::CO_SOLICITUD,$co_solicitud);
        $cs->add(Tb034RevisionPeer::IN_ACTIVO,true);

        $cantidad = Tb034RevisionPeer::doCount($cs);
        
        return $cantidad;
    }
}
