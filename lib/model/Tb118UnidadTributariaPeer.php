<?php

class Tb118UnidadTributariaPeer extends BaseTb118UnidadTributariaPeer
{
    static public function  getUT(){
        $c = new Criteria();
        $c->add(Tb118UnidadTributariaPeer::IN_ACTIVO,true);
        
        $stmt = Tb118UnidadTributariaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos["mo_unidad_tributaria"];
    }
}
