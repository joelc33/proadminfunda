<?php



class Tb171BienesPeer extends BaseTb171BienesPeer {

	   static public function getIncorporacion($codigo){
        
        $c = new Criteria();
        $c->addSelectColumn(Tb171BienesPeer::IN_INCORPORADO);
        $c->add(Tb171BienesPeer::CO_BIENES,$codigo);
         $stmt = self::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        //foreach($res as $result)
            return  $campos["in_incorporado"];
        
    }

}
