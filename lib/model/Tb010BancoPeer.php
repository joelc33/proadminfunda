<?php

class Tb010BancoPeer extends BaseTb010BancoPeer
{

    static public function getCodigo( $codigo){

        $c= new Criteria();
        $c->add(Tb010BancoPeer::TX_CODIGO_BANCO,$codigo);
        $stmt = Tb010BancoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        return $campos["nu_codigo"];

    }

    static public function getModoPago( $cuenta, $codigo){

        $c= new Criteria();
        $c->add(Tb010BancoPeer::TX_CODIGO_BANCO,$codigo);
        $stmt = Tb010BancoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $cadena = trim(substr($cuenta, 0, 4));

        if($cadena == $campos["nu_codigo"]){
            $modo = 1;
        }else{
            $modo = 2;
        }
        return $modo;

    }

}
