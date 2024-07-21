<?php

class Tb087PresupuestoMovimientoPeer extends BaseTb087PresupuestoMovimientoPeer
{

    static public function verificar($detalle_compra, $tipo)
    {

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb087PresupuestoMovimientoPeer::CO_PARTIDA);
        $c->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $detalle_compra);
        $c->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO, $tipo);

        $stmt = Tb087PresupuestoMovimientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos["co_partida"];
    }

    static public function movimientoPartida($con,$co_ejercicio,$co_usuario, $co_presupuesto, $co_tipo_movimiento, $monto, $co_detalle_cotizacion, $co_detalle_compras)
    {

        if($co_tipo_movimiento == 4 || $co_tipo_movimiento == 13 || $co_tipo_movimiento == 16)
        {
            $monto = $monto*(-1);
        }

        $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
        $tb087_presupuesto_movimiento->setCoPartida($co_presupuesto);
        $tb087_presupuesto_movimiento->setCoTipoMovimiento($co_tipo_movimiento);
        $tb087_presupuesto_movimiento->setNuMonto($monto);
        $tb087_presupuesto_movimiento->setNuAnio($co_ejercicio);
        $tb087_presupuesto_movimiento->setCoUsuario($co_usuario);
        if (!empty($co_detalle_cotizacion))
            $tb087_presupuesto_movimiento->setCoDetallePresuBase($co_detalle_cotizacion);
        if (!empty($co_detalle_compras))
            $tb087_presupuesto_movimiento->setCoDetalleCompra($co_detalle_compras);
        $tb087_presupuesto_movimiento->setInActivo(true);
        $tb087_presupuesto_movimiento->save($con);
    }
}
