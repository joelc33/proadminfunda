<?php

class Tb209PresupuestoDetalleCompraPeer extends BaseTb209PresupuestoDetalleCompraPeer
{

    static public function setInsertPresupuestoDetalleCompra($codigo, $monto, $usuario, $con, $in_cotizacion = false)
    {

        $Tb209PresupuestoDetalleCompra = new Tb209PresupuestoDetalleCompra();
        $Tb209PresupuestoDetalleCompra->setMonto($monto);
        $Tb209PresupuestoDetalleCompra->setCoUsuario($usuario);

        if ($in_cotizacion)
            $Tb209PresupuestoDetalleCompra->setCoDetalleCotizacion($codigo);
        else
            $Tb209PresupuestoDetalleCompra->setCoDetalleCompra($codigo);

        $Tb209PresupuestoDetalleCompra->save($con);

        return $Tb209PresupuestoDetalleCompra->getId();

    }


    static public function setUpdatePresupuestoDetalleCompra($codigo, $monto, $usuario, $co_proyecto, $co_accion, $co_presupuesto, $co_partida, $con, $in_cotizacion = false)
    {

        $c = new Criteria();
        if ($in_cotizacion)
            $c->add(self::CO_DETALLE_COTIZACION, $codigo);
        else
            $c->add(self::CO_DETALLE_COMPRA, $codigo);

        $c->add(self::CO_PRESUPUESTO, null, Criteria::ISNULL);
        $stmt = self::doSelectStmt($c);
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        $Tb209PresupuestoDetalleCompra = Tb209PresupuestoDetalleCompraPeer::retrieveByPK($datos["id"]);

        $Tb209PresupuestoDetalleCompra->setMonto($monto);
        $Tb209PresupuestoDetalleCompra->setCoUsuario($usuario);
        $Tb209PresupuestoDetalleCompra->setCoProyectoAc($co_proyecto);
        $Tb209PresupuestoDetalleCompra->setCoAccionEspecifica($co_accion);
        $Tb209PresupuestoDetalleCompra->setCoPresupuesto($co_presupuesto);
        $Tb209PresupuestoDetalleCompra->setCoPartida($co_partida);
        $Tb209PresupuestoDetalleCompra->save($con);

    }


    static public function getDatosPresupuestoDetalleCompra($codigo, $in_cotizacion = false)
    {
        $c = new Criteria();
        if ($in_cotizacion)
            $c->add(self::CO_DETALLE_COTIZACION, $codigo);
        else
            $c->add(self::CO_DETALLE_COMPRA, $codigo);

        $c->add(self::CO_PRESUPUESTO, null, Criteria::ISNULL);
        $stmt = self::doSelectStmt($c);
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $datos;
    }

    static public function setDeletePresupuestoDetalleCompra($co_presupuesto_detalle_compra, $codigo, $con, $in_cotizacion = false)
    {



        $Tb209PresupuestoDetalleCompra = Tb209PresupuestoDetalleCompraPeer::retrieveByPK($co_presupuesto_detalle_compra);

        $Tb209PresupuestoDetalleCompra->setCoProyectoAc(null);
        $Tb209PresupuestoDetalleCompra->setCoAccionEspecifica(null);
        $Tb209PresupuestoDetalleCompra->setCoPresupuesto(null);
        $Tb209PresupuestoDetalleCompra->setCoPartida(null);
        $Tb209PresupuestoDetalleCompra->save($con);

        $c = new Criteria();
        if ($in_cotizacion)
            $c->add(self::CO_DETALLE_COTIZACION, $codigo);
        else
            $c->add(self::CO_DETALLE_COMPRA, $codigo);

        $c->add(self::CO_PRESUPUESTO, null, Criteria::ISNULL);
        $cant = self::doCount($c);

        if ($cant > 1) {


            /**
             * suma el monto del producto que no tienen partidad asignadas
             */
            $c = new Criteria();
            $c->addSelectColumn("sum(" . self::MONTO . ") as total");
            if ($in_cotizacion)
                $c->add(self::CO_DETALLE_COTIZACION, $codigo);
            else
                $c->add(self::CO_DETALLE_COMPRA, $codigo);
            $c->add(self::CO_PRESUPUESTO, null, Criteria::ISNULL);
            $stmt = self::doSelectStmt($c);
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);



            /**
             * Busca el maximo de los productos que no tiene  partidas asignadas para eliminarlo
             */
            $cd = new Criteria();
            if ($in_cotizacion)
                $cd->add(self::CO_DETALLE_COTIZACION, $codigo);
            else
                $cd->add(self::CO_DETALLE_COMPRA, $codigo);
            $cd->add(self::CO_PRESUPUESTO, null, Criteria::ISNULL);
            $cd->getLimit(1);
            $cd->addDescendingOrderByColumn(self::ID);
            $stmtd = self::doSelectStmt($cd);
            $datos_delete = $stmtd->fetch(PDO::FETCH_ASSOC);

            /**
             * se elimina el producto 
             */
            $delete = Tb209PresupuestoDetalleCompraPeer::retrieveByPK($datos_delete["id"]);
            $delete->delete($con);

            /**
             * se suman los montos de los productos pendientes por partida y se le asigna a la menor
             */
            $updatePartida = self::retrieveByPK($co_presupuesto_detalle_compra);
            $updatePartida->setMonto($datos["total"]);
            $updatePartida->save($con);

        }


    }

}
