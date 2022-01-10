<?php

class Tb087PresupuestoMovimientoPeer extends BaseTb087PresupuestoMovimientoPeer
{

    static public function verificar( $detalle_compra, $tipo){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb087PresupuestoMovimientoPeer::CO_PARTIDA);
        $c->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $detalle_compra);
        $c->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO, $tipo);

        $stmt = Tb087PresupuestoMovimientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos["co_partida"];
    
    }

}
