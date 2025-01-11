<?php

class Tb045FacturaPeer extends BaseTb045FacturaPeer
{

    static public function setRetenciones($con, $co_solicitud, $co_usuario, $co_ruta, $co_ejercicio)
    {

        $c = new Criteria();
        $c->add(Tb045FacturaPeer::CO_SOLICITUD, $co_solicitud);
        $stmt = Tb045FacturaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);


        $co_cuenta_por_pagar = Tb130CuentaDocumentoPeer::getCoCuentaContable($co_solicitud); //Factura

        $tb061_asiento_contable = new Tb061AsientoContable();
        $tb061_asiento_contable->setMoHaber($campos["nu_total"])
            ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"])
            ->setCoSolicitud($co_solicitud)
            ->setCoFactura($campos["co_factura"])
            ->setCoUsuario($co_usuario)
            ->setCoRuta($co_ruta)
            ->setCoTipoAsiento(1)
            ->save($con);



        $c = new Criteria();
        $c->add(Tb129DetalleFacturaPeer::CO_FACTURA, $campos["co_factura"]);
        $stmt = Tb129DetalleFacturaPeer::doSelectStmt($c);
        $total_iva = 0;
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $tb061_asiento_contable = new Tb061AsientoContable();

            $cuenta_contable = Tb024CuentaContablePeer::getCuentaContable($res["co_producto"], $co_solicitud);

            $mo_iva = self::getIVA($campos["nu_base_imponible"], $res["mo_total"], $campos["nu_iva_factura"]);

            $monto = $res["mo_total"]; //+$mo_retencion;

            $tb061_asiento_contable->setMoDebe($monto)
                ->setCoCuentaContable($cuenta_contable["co_cuenta_contable"])
                ->setCoSolicitud($co_solicitud)
                ->setCoProducto($res["co_producto"])
                ->setCoFactura($campos["co_factura"])
                ->setCoUsuario($co_usuario)
                ->setCoTipoAsiento(1)
                ->setCoPresupuesto($res["co_presupuesto"])
                ->setCoRuta($co_ruta)
                ->save($con);


            $cd = new Criteria();
            $cd->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $res["co_detalle_compra"]);
            $cd->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO, 2);
            $cant_causado = Tb087PresupuestoMovimientoPeer::doCount($cd);

            if($cant_causado == 0){ 
                $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                $tb087_presupuesto_movimiento->setCoPartida($res["co_presupuesto"])
                    ->setCoTipoMovimiento(2)
                    ->setNuMonto($monto)
                    ->setNuAnio($co_ejercicio)
                    ->setCoFactura($campos["co_factura"])
                    ->setCoUsuario($co_usuario)
                    ->setCoDetalleCompra($res["co_detalle_compra"])
                    ->setInActivo(true)
                    ->save($con);
            }

            if ($mo_iva > 0) {
                $ci = new Criteria();
                $ci->add(Tb053DetalleComprasPeer::CO_DETALLE_COMPRA_ENLACE, $res["co_detalle_compra"]);
                $stmti = Tb053DetalleComprasPeer::doSelectStmt($ci);
                $campos_iva = $stmti->fetch(PDO::FETCH_ASSOC);


                $cuenta_contable = Tb024CuentaContablePeer::getCuentaContable($campos_iva["co_producto"], $co_solicitud);


                $tb061_asiento_contable = new Tb061AsientoContable();
                $tb061_asiento_contable->setMoDebe($mo_iva)
                    ->setCoCuentaContable($cuenta_contable["co_cuenta_contable"])
                    ->setCoSolicitud($co_solicitud)
                    ->setCoProducto($campos_iva["co_producto"])
                    ->setCoFactura($campos["co_factura"])
                    ->setCoUsuario($co_usuario)
                    ->setCoTipoAsiento(1)
                    ->setCoRuta($co_ruta)
                    ->save($con);


                $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                $tb087_presupuesto_movimiento->setCoPartida($campos_iva["co_presupuesto"])
                    ->setCoTipoMovimiento(2)
                    ->setNuMonto($mo_iva)
                    ->setNuAnio($co_ejercicio)
                    ->setCoUsuario($co_usuario)
                    ->setCoDetalleCompra($cuenta_contable["co_detalle_compras"])
                    ->setInActivo(true)
                    ->setCoFactura($campos["co_factura"])
                    ->save($con);
            }

            //$total_iva += $mo_iva;
        }




        $tb061_asiento_contable = new Tb061AsientoContable();
        $tb061_asiento_contable->setMoDebe($campos["nu_total"])
            ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_gasto_pago"])
            ->setCoSolicitud($co_solicitud)
            ->setCoFactura($campos["co_factura"])
            ->setCoUsuario($co_usuario)
            ->setCoTipoAsiento(2)
            ->setCoRuta($co_ruta)
            ->save($con);

        $tb061_asiento_contable = new Tb061AsientoContable();
        $tb061_asiento_contable->setMoHaber($campos["nu_total"])
            ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_orden_pago"])
            ->setCoSolicitud($co_solicitud)
            ->setCoFactura($campos["co_factura"])
            ->setCoUsuario($co_usuario)
            ->setCoTipoAsiento(2)
            ->setCoRuta($co_ruta)
            ->save($con);
    }


    static public function getIVA($baseimponible, $monto, $iva)
    {

        $nu_iva = ($monto * $iva) / $baseimponible; //se calcula el iva por cada producto

        return $nu_iva; //$monto * $valor_iva;        
    }
}
