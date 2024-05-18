<?php

class Nomina{

    static public function concepto($concepto, $ficha, $nomina){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID);
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::NU_VALOR);
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::NU_MONTO);
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH014_CONCEPTO, Tbrh014ConceptoPeer::CO_CONCEPTO);
        $c->add(Tbrh014ConceptoPeer::NU_CONCEPTO, $concepto);
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, $ficha);
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $nomina); 

        $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos["nu_monto"];
    
    }

}

?>