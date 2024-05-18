<?php



class Tbrh102CierreNominaTrabajadorPeer extends BaseTbrh102CierreNominaTrabajadorPeer {

    static public function salarioNormal( $nomina, $nom_trabajador, $concepto ){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::NU_MONTO);
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH014_CONCEPTO, Tbrh014ConceptoPeer::CO_CONCEPTO);
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $nomina); 
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR, $nom_trabajador);
        $c->add(Tbrh014ConceptoPeer::NU_CONCEPTO, $concepto);

        $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos["nu_monto"];
    
    }

}
