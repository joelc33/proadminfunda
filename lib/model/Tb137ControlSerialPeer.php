<?php

class Tb137ControlSerialPeer extends BaseTb137ControlSerialPeer
{
    static public function getSerial($codigo, $con, $ejercicio, $co_tipo_contrato = '',$co_programa = '')
    {

        $c = new Criteria();
        $c->add(Tb137ControlSerialPeer::CO_TIPO_DOCUMENTO, $codigo);

        if ($co_tipo_contrato != '') {
            $c->add(Tb137ControlSerialPeer::CO_TP_CONTRATO, $co_tipo_contrato);
        }else{
           $c->add(Tb137ControlSerialPeer::CO_TP_CONTRATO, null, Criteria::ISNULL); 
        }
        
        if ($co_programa != '') {
            $c->add(Tb137ControlSerialPeer::CO_PROGRAMA, $co_programa);
        }else{
            $c->add(Tb137ControlSerialPeer::CO_PROGRAMA, null, Criteria::ISNULL);
        }
        //$c->add(Tb137ControlSerialPeer::NU_ANIO,date('Y'));
        $c->add(Tb137ControlSerialPeer::NU_ANIO, $ejercicio);

        $cant = Tb137ControlSerialPeer::doCount($c);

        if ($cant == 0) {
            $cant = 1;
            $Tb137ControlSerial = new Tb137ControlSerial();
            $Tb137ControlSerial->setCoTipoDocumento($codigo);
            
            if ($co_tipo_contrato != '') {
                $Tb137ControlSerial->setCoTpContrato($co_tipo_contrato);
            }
            
            if ($co_programa != '') {
                $Tb137ControlSerial->setCoPrograma($co_programa);
            }            

            $Tb137ControlSerial->setNuAnio($ejercicio);
            $Tb137ControlSerial->setNuSerial($cant);
            $Tb137ControlSerial->save($con);
        } else {

            $stmts = Tb137ControlSerialPeer::doSelectStmt($c);
            $serial = $stmts->fetch(PDO::FETCH_ASSOC);

            $cant = $serial["nu_serial"] + 1;

            $wherec = new Criteria();
            $wherec->add(Tb137ControlSerialPeer::CO_TIPO_DOCUMENTO, $codigo);

            if ($co_tipo_contrato != '') {
                $wherec->add(Tb137ControlSerialPeer::CO_TP_CONTRATO, $co_tipo_contrato);
            }else{
                $wherec->add(Tb137ControlSerialPeer::CO_TP_CONTRATO, null, Criteria::ISNULL);
            }
            
            if ($co_programa != '') {
                $wherec->add(Tb137ControlSerialPeer::CO_PROGRAMA, $co_programa);
            }else{
                $wherec->add(Tb137ControlSerialPeer::CO_PROGRAMA, null, Criteria::ISNULL);
            }            

            $wherec->add(Tb137ControlSerialPeer::NU_ANIO, $ejercicio);

            $updc = new Criteria();
            $updc->add(Tb137ControlSerialPeer::NU_SERIAL, $cant);

            BasePeer::doUpdate($wherec, $updc, $con);
        }

        return str_pad($cant, 5, "0", STR_PAD_LEFT);
    }
}
