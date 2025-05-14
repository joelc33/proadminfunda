<?php

class Tb039RequisicionesPeer extends BaseTb039RequisicionesPeer
{

    static public function generarRequisicion($co_requisicion,$ejercicio,$co_usuario,$con){

        $c = new Criteria();
        $c->add(self::CO_REQUISICION, $co_requisicion);
        $stmt = self::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        list($anio, $mes, $dia) = explode("-", $campos["fe_registro"]);
        $fecha = $dia . "/" . $mes . "/" . $anio;  
        
        
        $tb026_solicitudForm = array(
            "co_tipo_solicitud"   => 61,
            "ejercicio"           => $ejercicio,
            "fe_solicitud"        => $fecha,
            "observacion"         => $campos["tx_observacion"],
            "codigo"              => $co_usuario
        );

        $resp = Tb026SolicitudPeer::setSolicitud($tb026_solicitudForm,$con);

        if ($resp["success"] == true) {
            $tb039_requisicionesForm["co_solicitud"]        = $resp["co_solicitud"];
            $tb039_requisicionesForm["co_tipo_solicitud"]   = 61;
        }

        

        $tb039_requisiciones = new Tb039Requisiciones();
        $tb039_requisiciones->setCoUsuario($co_usuario);
        $tb039_requisiciones->setCoEnte($campos["co_ente"]);
        $tb039_requisiciones->setCoTipoSolicitud($campos["co_tipo_solicitud"]);
        $tb039_requisiciones->setCoSolicitud($tb039_requisicionesForm["co_solicitud"]);
       

        $c = new Criteria();
        $c->add(self::NU_ANIO, $ejercicio);
        $cantidad = self::doCount($c);
        $cantidad += 1;
        
        $tb039_requisiciones->setNuAnio($ejercicio);
        $tb039_requisiciones->setNuRequisicion($ejercicio . $cantidad);      
        $tb039_requisiciones->setFeRegistro($campos["fe_registro"]);      
        $tb039_requisiciones->setTxConcepto($campos["tx_concepto"]);
        $tb039_requisiciones->setTxObservacion($campos["tx_observacion"]);
        $tb039_requisiciones->setCoServicio($campos["co_servicio"]);
        $tb039_requisiciones->setCoEnte($campos["co_ente"]);
        $tb039_requisiciones->setCoPrograma($campos["co_programa"]);
        $tb039_requisiciones->save($con);

       

        $detalleRequisicion = new Criteria();
        $detalleRequisicion->add(Tb051DetalleRequisionProductoPeer::CO_REQUISICION, $co_requisicion);
        $stmtDetalle = Tb051DetalleRequisionProductoPeer::doSelectStmt($detalleRequisicion);
        while ($productoForm = $stmtDetalle->fetch(PDO::FETCH_ASSOC)) {

            $tb051_detalle_requision_producto = new Tb051DetalleRequisionProducto();
            $tb051_detalle_requision_producto->setCoProducto($productoForm["co_producto"])
                ->setCoRequisicion($tb039_requisiciones->getCoRequisicion())
                ->setNuCantidad($productoForm["nu_cantidad"])
                ->setCoUnidadProducto($productoForm["co_unidad_producto"])
                ->setTxObservacion($productoForm["tx_observacion"])
                ->save($con);
                
        }      

       


        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb039_requisicionesForm["co_solicitud"]));
        $ruta->setInCargarDato(true)->save($con);
        $ruta->setCoEstatusRuta(2);
        $ruta->save($con);
      

        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());
    }

}
