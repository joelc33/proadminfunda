<?php

class Tb085PresupuestoPeer extends BaseTb085PresupuestoPeer
{
    static public function mascaraNomina($nu_partida){
        
        $partida = substr($nu_partida,0,1);
        $partida.= (substr($nu_partida,1,2)!='')?'.':'';
        $partida.= substr($nu_partida,1,2);
        $partida.= (substr($nu_partida,3,2)!='')?'.':'';
        $partida.= substr($nu_partida,3,2);
        $partida.= (substr($nu_partida,5,2)!='')?'.':'';
        $partida.= substr($nu_partida,5,2);
        $partida.= (substr($nu_partida,7,2)!='')?'.':'';
        $partida.= substr($nu_partida,7,2);
        $partida.= (substr($nu_partida,9,3)!='')?'.':'';
        $partida.= substr($nu_partida,9,3);
        $partida.= (substr($nu_partida,12,5)!='')?'.':'';
        $partida.= substr($nu_partida,12,5);
        
        return $partida;
        
    }
}
