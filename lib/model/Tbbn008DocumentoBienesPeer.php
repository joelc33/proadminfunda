<?php



class Tbbn008DocumentoBienesPeer extends BaseTbbn008DocumentoBienesPeer {

    static public function getDocumentoBienes($doc,$solicitud,$mov,$ubi){

        

        $c = new Criteria();

        $c->add(Tbbn008DocumentoBienesPeer::CO_TIPO_DOCUMENTO,$doc);

        $c->add(Tbbn008DocumentoBienesPeer::CO_SOLICITUD,$solicitud);

        $c->add(Tbbn008DocumentoBienesPeer::CO_SUBTIPO_MOVIMIENTO,$mov);
        $c->add(Tbbn008DocumentoBienesPeer::CO_UBICACION,$ubi);
        //$c->add(Tbbn008DocumentoBienesPeer::CO_RESPONSABLE,$res);

        $res = Tbbn008DocumentoBienesPeer::doSelect($c);

        foreach($res as $result)

            return $result->getCoDocumentoBienes();

        

    }
    static public function getMontoDocumentoBienes($codigo){

        

        $c = new Criteria();

        $c->add(Tbbn008DocumentoBienesPeer::CO_DOCUMENTO_BIENES,$codigo);
        $res = Tbbn008DocumentoBienesPeer::doSelect($c);

        foreach($res as $result)

            return $result->getNuMonto();

        

    }
}
