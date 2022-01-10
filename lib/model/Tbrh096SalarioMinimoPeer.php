<?php



class Tbrh096SalarioMinimoPeer extends BaseTbrh096SalarioMinimoPeer {

    static public function salarioMinimo(){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh096SalarioMinimoPeer::MO_SALARIO_MINIMO);
        $c->add(Tbrh096SalarioMinimoPeer::IN_ACTIVO, TRUE); 

        $stmt = Tbrh096SalarioMinimoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos["mo_salario_minimo"];
    
    }

}
