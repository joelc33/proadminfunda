<?php



class Tbrh070PrimaAntiguedadPeer extends BaseTbrh070PrimaAntiguedadPeer {

    static public function nuPrimaAntiguedad( $antiguedad, $co_tp_nomina, $co_grupo_nomina){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh070PrimaAntiguedadPeer::CO_PRIMA_ANTIGUEDAD);
        $c->addSelectColumn(Tbrh070PrimaAntiguedadPeer::NU_ANIO);
        $c->addSelectColumn(Tbrh070PrimaAntiguedadPeer::NU_PORCENTAJE);
        $c->addSelectColumn(Tbrh070PrimaAntiguedadPeer::CO_TP_NOMINA);
        $c->addSelectColumn(Tbrh070PrimaAntiguedadPeer::CO_GRUPO_NOMINA);
        $c->addSelectColumn(Tbrh070PrimaAntiguedadPeer::DE_CONDICIONAL);
        $c->add(Tbrh070PrimaAntiguedadPeer::CO_TP_NOMINA, $co_tp_nomina);
        $c->add(Tbrh070PrimaAntiguedadPeer::CO_GRUPO_NOMINA, $co_grupo_nomina); 

        $c->addAscendingOrderByColumn(Tbrh070PrimaAntiguedadPeer::NU_ANIO);
        $stmt = Tbrh070PrimaAntiguedadPeer::doSelectStmt($c);

        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            if($res["de_condicional"]=='='){
                if($antiguedad==$res["nu_anio"]){
                    $porcentaje = $res["nu_porcentaje"];
                    $nu_anio = $res["nu_anio"];
                }
            }elseif($res["de_condicional"]=='>='){
                if($antiguedad>=$res["nu_anio"]){
                    $porcentaje = $res["nu_porcentaje"];
                    $nu_anio = $res["nu_anio"];
                }
            }

        }
              
        return $porcentaje;
    
    }

}
