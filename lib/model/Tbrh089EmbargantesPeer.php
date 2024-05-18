<?php

class Tbrh089EmbargantesPeer extends BaseTbrh089EmbargantesPeer
{
    
    static public function embargos($grupo, $ficha, $nomina, $fecha_inicio, $fecha_cierre){

        //$grupo = array(3, 4);
        $c1 = new Criteria();
        $c1->clearSelectColumns();
        $c1->addSelectColumn(Tbrh089EmbargantesPeer::CO_EMBARGANTE);
        $c1->addSelectColumn(Tbrh089EmbargantesPeer::CO_TRABAJADOR);
        $c1->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
        $c1->addJoin(Tbrh001TrabajadorPeer::NU_CEDULA, Tbrh089EmbargantesPeer::NU_CEDULA);
        $c1->add(Tbrh002FichaPeer::CO_FICHA, $ficha);

        $stmt1 = Tbrh002FichaPeer::doSelectStmt($c1);
        $campos1 = $stmt1->fetch(PDO::FETCH_ASSOC);        
        
        $c2 = new Criteria();
        $c2->clearSelectColumns();
        $c2->addSelectColumn(Tbrh002FichaPeer::CO_FICHA);
        $c2->add(Tbrh002FichaPeer::CO_TRABAJADOR, $campos1["co_trabajador"]);

        $stmt2 = Tbrh002FichaPeer::doSelectStmt($c2);
        $monto =0;
        while($campos2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
//        $c3 = new Criteria();
//        $c3->clearSelectColumns();
//        $c3->addSelectColumn(Tbrh088EmbargoPeer::CO_EMBARGO);
//        $c3->add(Tbrh088EmbargoPeer::CO_EMBARGANTE, $campos1["co_embargante"]);
//        $c3->add(Tbrh088EmbargoPeer::CO_TRABAJADOR, $campos1["co_trabajador"]);
//
//        $stmt3 = Tbrh088EmbargoPeer::doSelectStmt($c3);
//        $campos3 = $stmt3->fetch(PDO::FETCH_ASSOC); 
        
        
        $c = new Criteria();
        $c->clearSelectColumns();
        //$c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID);
        //$c->addSelectColumn(Tbrh061NominaMovimientoPeer::NU_VALOR);
        //$c->addSelectColumn(Tbrh061NominaMovimientoPeer::NU_MONTO);
        $c->addSelectColumn("sum(".Tbrh061NominaMovimientoPeer::NU_MONTO.") as nu_monto");
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH014_CONCEPTO, Tbrh014ConceptoPeer::CO_CONCEPTO);
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, Tbrh013NominaPeer::CO_NOMINA);
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH086_CONCEPTOS_FIJOS, Tbrh086ConceptosFijosPeer::CO_CONCEPTOS_FIJOS);
        $c->addJoin(Tbrh013NominaPeer::CO_SOLICITUD, Tb026SolicitudPeer::CO_SOLICITUD);
        $c->add(Tbrh086ConceptosFijosPeer::CO_EMBARGO, $campos1["co_embargante"]);
        $c->add(Tbrh014ConceptoPeer::NU_CONCEPTO, $grupo, Criteria::IN);
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, $campos2["co_ficha"]);
        $c->add(Tb026SolicitudPeer::IN_PATRIA, null, Criteria::ISNULL);
        $c->add(Tbrh013NominaPeer::FE_PAGO, $fecha_cierre, Criteria::LESS_EQUAL);
        $c->addAnd(Tbrh013NominaPeer::FE_PAGO, $fecha_inicio, Criteria::GREATER_EQUAL);
        $c->addAnd(Tbrh013NominaPeer::FE_PAGO, null, Criteria::ISNOTNULL);
        $c->addAnd(Tbrh013NominaPeer::ID_TBRH060_NOMINA_ESTATUS,3);

        $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        $monto = $monto + $campos["nu_monto"];
    
    }

    return $monto;
    }
    
}
