<?php

class Tb008ProveedorPeer extends BaseTb008ProveedorPeer
{
    static public function getProveedorDefecto(){

        $c = new Criteria();
        $c->add(Tb008ProveedorPeer::IN_RRHH,true);
        $stmt = Tb008ProveedorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos["co_proveedor"];

    }
}
