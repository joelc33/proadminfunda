<?php



class Tbrh098ConceptoTiempoPeer extends BaseTbrh098ConceptoTiempoPeer {

    static public function hojaTiempo( $co_tp_nomina, $co_grupo_nomina, $concepto, $mes ){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh098ConceptoTiempoPeer::CO_CONCEPTO_TIEMPO);
        $c->addSelectColumn(Tbrh098ConceptoTiempoPeer::CO_TP_NOMINA);
        $c->addSelectColumn(Tbrh098ConceptoTiempoPeer::CO_GRUPO_NOMINA);
        $c->addSelectColumn(Tbrh098ConceptoTiempoPeer::NU_MES_INI);
        $c->addSelectColumn(Tbrh098ConceptoTiempoPeer::NU_MES_FIN);
        $c->addSelectColumn(Tbrh098ConceptoTiempoPeer::NU_CONCEPTO);
        $c->addSelectColumn(Tbrh098ConceptoTiempoPeer::CO_CONCEPTO);
        $c->addSelectColumn(Tbrh098ConceptoTiempoPeer::NU_VALOR);
        $c->add(Tbrh098ConceptoTiempoPeer::CO_TP_NOMINA, $co_tp_nomina);
        $c->add(Tbrh098ConceptoTiempoPeer::CO_GRUPO_NOMINA, $co_grupo_nomina); 
        $c->add(Tbrh098ConceptoTiempoPeer::NU_CONCEPTO, $concepto);
        $c->add(Tbrh098ConceptoTiempoPeer::NU_MES_INI, $mes, Criteria::LESS_EQUAL);
        $c->addAnd(Tbrh098ConceptoTiempoPeer::NU_MES_FIN, $mes, Criteria::GREATER_EQUAL); 

        $stmt = Tbrh098ConceptoTiempoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos["nu_valor"];
    
    }

}
