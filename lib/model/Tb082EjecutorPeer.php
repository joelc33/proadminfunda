<?php

class Tb082EjecutorPeer extends BaseTb082EjecutorPeer
{
    static public function getCoEjecutor($nu_ejecutor){
        $c = new Criteria();
        $c->add(self::NU_EJECUTOR, $nu_ejecutor);       
        
        $stmt = self::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos["id"];
    }
}
