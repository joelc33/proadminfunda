<?php



class Tbrh094PrimaNivelEduPeer extends BaseTbrh094PrimaNivelEduPeer {

    static public function nuPrimaNivelEducativo( $nivel, $co_tp_nomina, $co_grupo_nomina){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh094PrimaNivelEduPeer::CO_PRIMA_NIVEL_EDU);
        $c->addSelectColumn(Tbrh094PrimaNivelEduPeer::CO_NIVEL_EDUCATIVO);
        $c->addSelectColumn(Tbrh094PrimaNivelEduPeer::NU_PORCENTAJE);
        $c->addSelectColumn(Tbrh094PrimaNivelEduPeer::CO_TP_NOMINA);
        $c->addSelectColumn(Tbrh094PrimaNivelEduPeer::CO_GRUPO_NOMINA);
        $c->add(Tbrh094PrimaNivelEduPeer::CO_TP_NOMINA, $co_tp_nomina);
        $c->add(Tbrh094PrimaNivelEduPeer::CO_GRUPO_NOMINA, $co_grupo_nomina); 
        $c->add(Tbrh094PrimaNivelEduPeer::CO_NIVEL_EDUCATIVO, $nivel); 

        $stmt = Tbrh094PrimaNivelEduPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos["nu_porcentaje"];
    
    }

}
