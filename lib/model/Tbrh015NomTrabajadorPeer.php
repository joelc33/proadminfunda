<?php



class Tbrh015NomTrabajadorPeer extends BaseTbrh015NomTrabajadorPeer {

    static public function moSalarioBase( $co_ficha, $co_tp_nomina, $co_grupo_nomina){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::MO_SALARIO_BASE);
        //$c->addSelectColumn(Tbrh008TabuladorPeer::MO_SALARIO_BASE);
        //$c->addJoin(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA, Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA);
        //$c->addJoin(Tbrh009CargoEstructuraPeer::CO_TABULADOR, Tbrh008TabuladorPeer::CO_TABULADOR);
        $c->add(Tbrh015NomTrabajadorPeer::CO_FICHA, $co_ficha);
        $c->add(Tbrh015NomTrabajadorPeer::CO_TP_NOMINA, $co_tp_nomina);
        $c->add(Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA, $co_grupo_nomina); 

        $stmt = Tbrh015NomTrabajadorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos["mo_salario_base"];
    
    }

    static public function moSalarioBasico( $nom_trabajador){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::MO_SALARIO_BASE);
        $c->add(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR, $nom_trabajador);

        $stmt = Tbrh015NomTrabajadorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos["mo_salario_base"];
    
    }

    static public function verificarCompensacion( $cargo_estructura){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh032CargoPeer::IN_COMPENSACION);
        $c->addJoin(Tbrh009CargoEstructuraPeer::CO_CARGO, Tbrh032CargoPeer::CO_CARGO);
        $c->add(Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA, $cargo_estructura);

        $stmt = Tbrh009CargoEstructuraPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos["in_compensacion"];
    
    }

    static public function grupo( $co_trabajador){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_TP_NOMINA);
        $c->addJoin(Tbrh015NomTrabajadorPeer::CO_FICHA, Tbrh002FichaPeer::CO_FICHA);
        $c->add(Tbrh002FichaPeer::CO_TRABAJADOR,$co_trabajador);
        $c->add(Tbrh015NomTrabajadorPeer::IN_ACTIVO, true);

        $stmt = Tbrh015NomTrabajadorPeer::doSelectStmt($c);

        $registros = array();

        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = trim($res["co_tp_nomina"]);
        }
              
        return $registros;
    
    }

    static public function subgrupo( $co_trabajador){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA);
        $c->addJoin(Tbrh015NomTrabajadorPeer::CO_FICHA, Tbrh002FichaPeer::CO_FICHA);
        $c->add(Tbrh002FichaPeer::CO_TRABAJADOR,$co_trabajador);
        $c->add(Tbrh015NomTrabajadorPeer::IN_ACTIVO, true);

        $stmt = Tbrh015NomTrabajadorPeer::doSelectStmt($c);

        $registros = array();

        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = trim($res["co_grupo_nomina"]);
        }
              
        return $registros;
    
    }

}
