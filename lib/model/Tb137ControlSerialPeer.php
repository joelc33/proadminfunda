<?php

class Tb137ControlSerialPeer extends BaseTb137ControlSerialPeer
{
    static public function getSerial($codigo,$con,$ejercicio){
                                 
        $c = new Criteria();
        $c->add(Tb137ControlSerialPeer::CO_TIPO_DOCUMENTO,$codigo);
        //$c->add(Tb137ControlSerialPeer::NU_ANIO,date('Y'));
        $c->add(Tb137ControlSerialPeer::NU_ANIO, $ejercicio);

        $cant = Tb137ControlSerialPeer::doCount($c);

        if($cant == 0){
             $cant = 1;
             $Tb137ControlSerial = new Tb137ControlSerial();
             $Tb137ControlSerial->setCoTipoDocumento($codigo)
                                //->setNuAnio(date("Y"))
                                ->setNuAnio($ejercicio)
                                ->setNuSerial($cant)
                                ->save($con); 

        }else{

            $stmts = Tb137ControlSerialPeer::doSelectStmt($c);
            $serial = $stmts->fetch(PDO::FETCH_ASSOC);

            $cant = $serial["nu_serial"]+1;

            $wherec = new Criteria();
            $wherec->add(Tb137ControlSerialPeer::CO_TIPO_DOCUMENTO,$codigo);
            //$wherec->add(Tb137ControlSerialPeer::NU_ANIO,date('Y'));
            $wherec->add(Tb137ControlSerialPeer::NU_ANIO, $ejercicio);

            $updc = new Criteria();
            $updc->add(Tb137ControlSerialPeer::NU_SERIAL,$cant);

            BasePeer::doUpdate($wherec, $updc, $con);

        }
        
        return str_pad($cant, 5, "0", STR_PAD_LEFT);           
           
    }
}
