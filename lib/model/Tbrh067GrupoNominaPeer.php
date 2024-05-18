<?php



class Tbrh067GrupoNominaPeer extends BaseTbrh067GrupoNominaPeer {

    static public function contar( $tp_nomina, $grupo_nomina){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh067GrupoNominaPeer::CO_TP_NOMINA);
        $c->addSelectColumn(Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);
        $c->addJoin(Tbrh067GrupoNominaPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
        $c->add(Tbrh017TpNominaPeer::NU_NOMINA, $tp_nomina);
        $c->add(Tbrh067GrupoNominaPeer::COD_GRUPO_NOMINA, $grupo_nomina);

        $cantidad = Tbrh067GrupoNominaPeer::doCount($c);

        $stmt = Tbrh067GrupoNominaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $cantidad;
    
    }

    static public function consultar( $tp_nomina, $grupo_nomina){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh067GrupoNominaPeer::CO_TP_NOMINA);
        $c->addSelectColumn(Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);
        $c->addJoin(Tbrh067GrupoNominaPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
        $c->add(Tbrh017TpNominaPeer::NU_NOMINA, $tp_nomina);
        $c->add(Tbrh067GrupoNominaPeer::COD_GRUPO_NOMINA, $grupo_nomina);

        $stmt = Tbrh067GrupoNominaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos;
    
    }

}
