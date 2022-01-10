<?php



class Tbrh001TrabajadorPeer extends BaseTbrh001TrabajadorPeer {

    static public function contar( $cedula){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
        $c->add(Tbrh001TrabajadorPeer::NU_CEDULA, $cedula);

        $cantidad = Tbrh001TrabajadorPeer::doCount($c);

        $stmt = Tbrh001TrabajadorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $cantidad;
    
    }

}
