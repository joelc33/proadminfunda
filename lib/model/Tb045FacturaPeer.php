<?php

class Tb045FacturaPeer extends BaseTb045FacturaPeer
{

    static public function setRetenciones($con, $co_solicitud, $co_usuario, $co_ruta, $co_ejercicio)
    {

      

        $c = new Criteria();
        $c->add(Tb045FacturaPeer::CO_SOLICITUD, $co_solicitud);
        $c->add(Tb045FacturaPeer::CO_ODP, NULL, Criteria::ISNULL);
        $stmt = Tb045FacturaPeer::doSelectStmt($c);

        $x=0;
        while ($campos = $stmt->fetch(PDO::FETCH_ASSOC)) {

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


              
            $c1 = new Criteria();
            $c1->add(Tb129DetalleFacturaPeer::CO_FACTURA, $campos["co_factura"]);
            $stmt1 = Tb129DetalleFacturaPeer::doSelectStmt($c1);
            $total_iva = 0;
            while ($res = $stmt1->fetch(PDO::FETCH_ASSOC)) {

                $tb061_asiento_contable = new Tb061AsientoContable();

                $cuenta_contable = Tb024CuentaContablePeer::getCuentaContable($res["co_producto"], $co_solicitud);

                

                $monto = $res["mo_total"]; //+$mo_retencion;

                $tb061_asiento_contable->setMoDebe($monto)
                    ->setCoCuentaContable($cuenta_contable["co_cuenta_contable"])
                    ->setCoSolicitud($co_solicitud)
                    ->setCoProducto($res["co_producto"])
                    ->setCoFactura($campos["co_factura"])
                    ->setCoUsuario($co_usuario)
                    ->setCoTipoAsiento(1)
                    ->setCoRuta($co_ruta)
                    ->save($con);


                $detalle_compra = Tb053DetalleComprasPeer::retrieveByPK($res["co_detalle_compra"]);
                $monto_detalle = $detalle_compra->getMonto();



                /*$cm = new Criteria();
                $cm->clearSelectColumns();
                $cm->addSelectColumn('coalesce(SUM(' . Tb087PresupuestoMovimientoPeer::NU_MONTO . '),0) as total');
                $cm->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO, 2);
                $cm->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $res["co_detalle_compra"]);
                $stmtm = Tb087PresupuestoMovimientoPeer::doSelectStmt($cm);
                $camposm = $stmtm->fetch(PDO::FETCH_ASSOC);

                $monto_movimiento = $camposm["total"];

                if($x==2){
                    echo ($monto_detalle. "-" . $monto_movimiento)."---"; 
                    echo ($monto * 100) / ($monto_detalle - $monto_movimiento);
                    exit();
                }
                $x++;*/

                $porcentaje = ($monto * 100) / ($monto_detalle);
                if ($porcentaje == 100)
                    $porc = 1;
                else
                    $porc = ($porcentaje / 100);


                $cd = new Criteria();
                $cd->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $res["co_detalle_compra"]);
                $cd->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO, 2);

                $cant_causado = Tb087PresupuestoMovimientoPeer::doCount($cd);

                // if ($cant_causado == 0) {

                $dc = new Criteria();
                $dc->add(Tb209PresupuestoDetalleCompraPeer::CO_DETALLE_COMPRA, $res["co_detalle_compra"]);
                $stmtdc = Tb209PresupuestoDetalleCompraPeer::doSelectStmt($dc);
                $total_iva = 0;
                while ($resdc = $stmtdc->fetch(PDO::FETCH_ASSOC)) {


                  //  echo $resdc["monto"] ."*". $porc; exit();

                    $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                    $tb087_presupuesto_movimiento->setCoPartida($resdc["co_presupuesto"])
                        ->setCoTipoMovimiento(2)
                        ->setNuMonto(($resdc["monto"] * $porc))
                        ->setNuAnio($co_ejercicio)
                        ->setCoFactura($campos["co_factura"])
                        ->setCoUsuario($co_usuario)
                        ->setCoDetalleCompra($res["co_detalle_compra"])
                        ->setCoPresupuestoDetalleCompra($resdc["id"])
                        ->setInActivo(true)
                        ->save($con);
                    //    }
                }

//                if ($mo_iva > 0) {
                    $ci = new Criteria();
                    $ci->add(Tb053DetalleComprasPeer::CO_DETALLE_COMPRA_ENLACE, $res["co_detalle_compra"]);
                    $stmti = Tb053DetalleComprasPeer::doSelectStmt($ci);
                    $campos_iva = $stmti->fetch(PDO::FETCH_ASSOC);

                    if($campos_iva["co_producto"]!=null || $campos_iva["co_producto"]!=''){
                        
                    $mo_iva = self::getIVA($res["mo_total"], $detalle_compra->getCoIvaProducto());

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

                    $dci = new Criteria();
                    $dci->add(Tb209PresupuestoDetalleCompraPeer::CO_DETALLE_COMPRA, $campos_iva["co_detalle_compras"]);
                    $stmtdci = Tb209PresupuestoDetalleCompraPeer::doSelectStmt($dci);
                    $total_iva = 0;
                    while ($resdci = $stmtdci->fetch(PDO::FETCH_ASSOC)) {

                        $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                        $tb087_presupuesto_movimiento->setCoPartida($resdci["co_presupuesto"])
                            ->setCoTipoMovimiento(2)
                            ->setNuMonto(($resdci["monto"] * $porc))
                            ->setNuAnio($co_ejercicio)
                            ->setCoUsuario($co_usuario)
                            ->setCoDetalleCompra($resdci["co_detalle_compra"])
                            ->setInActivo(true)
                            ->setCoFactura($campos["co_factura"])
                            ->save($con);
                    }
                }
//                }
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

        
    }

    static public function getIVA($monto, $iva)
    {

        $nu_iva = ($monto * $iva) / 100; //se calcula el iva por cada producto

        return $nu_iva; //$monto * $valor_iva;        
    }
}
