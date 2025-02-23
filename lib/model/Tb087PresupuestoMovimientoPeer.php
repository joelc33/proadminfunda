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

    static public function movimientoPartida($con, $co_ejercicio, $co_usuario, $co_presupuesto, $co_tipo_movimiento, $monto, $co_detalle_cotizacion = '', $co_detalle_compras = '', $co_presupuesto_detalle_compra = '')
    {

        if ($co_tipo_movimiento == 4 || $co_tipo_movimiento == 13 || $co_tipo_movimiento == 16) {
            $monto = $monto * (-1);
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
        if (!empty($co_presupuesto_detalle_compra))
            $tb087_presupuesto_movimiento->setCoPresupuestoDetalleCompra($co_presupuesto_detalle_compra);
        $tb087_presupuesto_movimiento->setInActivo(true);
        $tb087_presupuesto_movimiento->save($con);
    }

    static public function afectarPartidas($con,$ejercicio,$co_usuario,$co_ruta)
    {

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb209PresupuestoDetalleCompraPeer::CO_PRESUPUESTO);
        $c->addSelectColumn(Tb209PresupuestoDetalleCompraPeer::ID);
        $c->addSelectColumn(Tb209PresupuestoDetalleCompraPeer::MONTO);
        $c->addSelectColumn(Tb209PresupuestoDetalleCompraPeer::CO_DETALLE_COMPRA);
        $c->addJoin(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS,Tb209PresupuestoDetalleCompraPeer::CO_DETALLE_COMPRA);
        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS,Tb053DetalleComprasPeer::CO_COMPRAS);
        $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD,Tb030RutaPeer::CO_SOLICITUD);
        $c->add(Tb030RutaPeer::CO_RUTA,$co_ruta);


        $c->addAscendingOrderByColumn(Tb209PresupuestoDetalleCompraPeer::ID);

        $stmt = Tb209PresupuestoDetalleCompraPeer::doSelectStmt($c);

        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

            Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $ejercicio, $co_usuario, $reg["co_presupuesto"], 1, $reg["monto"], '', $reg["co_detalle_compra"], $reg["id"]);
            Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $ejercicio, $co_usuario, $reg["co_presupuesto"], 2, $reg["monto"], '', $reg["co_detalle_compra"], $reg["id"]);
     
        }

    }
}
