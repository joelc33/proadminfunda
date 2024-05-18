<?php

class Tb053DetalleComprasPeer extends BaseTb053DetalleComprasPeer
{
    static public function getDetallesCompra($co_compra){
        $cd = new Criteria();
        $cd->add(Tb053DetalleComprasPeer::CO_COMPRAS,$co_compra);
        $stmt = Tb053DetalleComprasPeer::doSelectStmt($cd);
        $datos_detalle = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $datos_detalle;
    }
}
