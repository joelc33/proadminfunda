<?php

class Tb052ComprasPeer extends BaseTb052ComprasPeer
{
    static public function getCompra($co_solicitud){
        $cd = new Criteria();
        $cd->add(Tb052ComprasPeer::CO_SOLICITUD,$co_solicitud);
        $stmt = Tb052ComprasPeer::doSelectStmt($cd);
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $datos;
    }  
}
