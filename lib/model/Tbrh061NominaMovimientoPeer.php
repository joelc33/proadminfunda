<?php



class Tbrh061NominaMovimientoPeer extends BaseTbrh061NominaMovimientoPeer {

    static public function moConcepto($concepto, $ficha, $nomina){

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

    static public function moGrupoConcepto($grupo, $ficha, $nomina){

        //$grupo = array(3, 4);

        $c = new Criteria();
        $c->clearSelectColumns();
        //$c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID);
        //$c->addSelectColumn(Tbrh061NominaMovimientoPeer::NU_VALOR);
        //$c->addSelectColumn(Tbrh061NominaMovimientoPeer::NU_MONTO);
        $c->addSelectColumn("sum(".Tbrh061NominaMovimientoPeer::NU_MONTO.") as nu_monto");
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH014_CONCEPTO, Tbrh014ConceptoPeer::CO_CONCEPTO);
        $c->add(Tbrh014ConceptoPeer::NU_CONCEPTO, $grupo, Criteria::IN);
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, $ficha);
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $nomina); 

        $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos["nu_monto"];
    
    }

    static public function moTipoConcepto($tipo, $ficha, $nomina){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn("sum(".Tbrh061NominaMovimientoPeer::NU_MONTO.") as nu_monto");
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH020_TP_CONCEPTO, $tipo);
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, $ficha);
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $nomina); 

        $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos["nu_monto"];
    
    }

    static public function moGrupoConceptoUbicacion($grupo, $ficha, $nomina, $nom_trabajador){

        //$grupo = array(3, 4);

        $c = new Criteria();
        $c->clearSelectColumns();
        //$c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID);
        //$c->addSelectColumn(Tbrh061NominaMovimientoPeer::NU_VALOR);
        //$c->addSelectColumn(Tbrh061NominaMovimientoPeer::NU_MONTO);
        $c->addSelectColumn("sum(".Tbrh061NominaMovimientoPeer::NU_MONTO.") as nu_monto");
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH014_CONCEPTO, Tbrh014ConceptoPeer::CO_CONCEPTO);
        $c->add(Tbrh014ConceptoPeer::NU_CONCEPTO, $grupo, Criteria::IN);
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, $ficha);
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $nomina);
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR, $nom_trabajador);

        $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos["nu_monto"];
    
    }

    static public function salarioPromedio($nom_trabajador, $concepto, $nomina){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn("date_part('year', tbrh013_nomina.fe_fin) as nu_anio");
        $c->add(Tbrh013NominaPeer::CO_NOMINA, $nomina);
        $stmt = Tbrh013NominaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $c2 = new Criteria();
        $c2->clearSelectColumns();
        $c2->addSelectColumn("avg(".Tbrh061NominaMovimientoPeer::NU_VALOR.") as nu_monto");
        $c2->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH014_CONCEPTO, Tbrh014ConceptoPeer::CO_CONCEPTO);
        $c2->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, Tbrh013NominaPeer::CO_NOMINA);
        $c2->add(Tbrh014ConceptoPeer::NU_CONCEPTO, $concepto, Criteria::IN);
        $c2->add(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR, $nom_trabajador);
        $c2->add(Tbrh013NominaPeer::FE_FIN, "date_part('year', tbrh013_nomina.fe_fin) = ".$campos["nu_anio"], Criteria::CUSTOM);

        $stmt2 = Tbrh061NominaMovimientoPeer::doSelectStmt($c2);
        $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);
              
        return $campos2["nu_monto"];
    
    }
    
    static public function sumatoriaConceptos($nom_trabajador, $concepto, $nomina){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn("date_part('month', tbrh013_nomina.fe_fin) as nu_mes");
        $c->addSelectColumn("date_part('year', tbrh013_nomina.fe_fin) as nu_anio");
        $c->add(Tbrh013NominaPeer::CO_NOMINA, $nomina);
        $stmt = Tbrh013NominaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
       
        $c2 = new Criteria();
        $c2->clearSelectColumns();
        $c2->addSelectColumn("SUM(".Tbrh061NominaMovimientoPeer::NU_MONTO.") as nu_monto");
        $c2->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH014_CONCEPTO, Tbrh014ConceptoPeer::CO_CONCEPTO);
        $c2->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, Tbrh013NominaPeer::CO_NOMINA);
        $c2->add(Tbrh014ConceptoPeer::NU_CONCEPTO, $concepto, Criteria::IN);
        $c2->add(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR, $nom_trabajador);
        $c2->add(Tbrh013NominaPeer::FE_FIN, "date_part('month', tbrh013_nomina.fe_fin) = ".$campos["nu_mes"], Criteria::CUSTOM);
        $c2->addAnd(Tbrh013NominaPeer::FE_FIN, "date_part('year', tbrh013_nomina.fe_fin) = ".$campos["nu_anio"], Criteria::CUSTOM);
        

        $stmt2 = Tbrh061NominaMovimientoPeer::doSelectStmt($c2);
        $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);
              
        return $campos2["nu_monto"];
    
    }    

}
