<?php

class Tb053DetalleComprasPeer extends BaseTb053DetalleComprasPeer
{
    static public function getDetallesCompra($co_compra){
        $cd = new Criteria();
        $cd->add(self::CO_COMPRAS,$co_compra);
        $stmt = self::doSelectStmt($cd);
        $datos_detalle = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $datos_detalle;
    }

    static public function getCantProducto($co_detalle_requisicion, $co_detalle_compras){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn('coalesce(SUM(' . self::NU_CANTIDAD . '),0) as cant_total');
        if (!empty($co_detalle_compras)) {
            $c->add(self::CO_DETALLE_COMPRAS, $co_detalle_compras, Criteria::NOT_IN);
        }
        $c->add(self::IN_ANULAR, NULL, Criteria::ISNULL);
        $c->add(self::CO_DETALLE_REQUISICION, $co_detalle_requisicion);

        $stmt = self::doSelectStmt($c);
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $datos["cant_total"];
    }
}
