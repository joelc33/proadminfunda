<?php



class Tbbn006OrganigramaPeer extends BaseTbbn006OrganigramaPeer {

    static public function getCoOrganigrama($codigo,$cia){

        

        $c = new Criteria();

        $c->add(Tbbn006OrganigramaPeer::COD_ADM,$codigo);
        $c->add(Tbbn006OrganigramaPeer::COD_CIA,$cia);

        $res = Tbbn006OrganigramaPeer::doSelect($c);

        foreach($res as $result)

            return $result->getCoOrganigrama();

        

    }

    static public function getUltAdm(){

        

        $c = new Criteria();

        $c->add(Tbbn006OrganigramaPeer::CO_PADRE,NULL);
        $c->addAscendingOrderByColumn(Tbbn006OrganigramaPeer::NU_ORDEN);
        $res = Tbbn006OrganigramaPeer::doSelect($c);

        foreach($res as $result){

        }

            return $result->getCodAdm();

        

    }

    static public function getUltAdmEspe($codigo){
        $c = new Criteria();

        $c->add(Tbbn006OrganigramaPeer::CO_PADRE,$codigo);
        $c->addAscendingOrderByColumn(Tbbn006OrganigramaPeer::NU_ORDEN);
        $res = Tbbn006OrganigramaPeer::doSelect($c);

        foreach($res as $result){
            
        }
        $r=(isset($result) && !empty($result))? $result->getCodAdm():"01";
            return $r;
 
    }

    static public function getUltOrden(){

        

        $c = new Criteria();

        $c->add(Tbbn006OrganigramaPeer::CO_PADRE,NULL);
        $c->addAscendingOrderByColumn(Tbbn006OrganigramaPeer::NU_ORDEN);
        $res = Tbbn006OrganigramaPeer::doSelect($c);

        foreach($res as $result){

        }
$r=(isset($result) && !empty($result))? $result->getCodAdm():"01";
            return $result->getNuOrden();

        

    }

    static public function getUltAdmEspeOrden($codigo){
        $c = new Criteria();

        $c->add(Tbbn006OrganigramaPeer::CO_PADRE,$codigo);
        $c->addAscendingOrderByColumn(Tbbn006OrganigramaPeer::NU_ORDEN);
        $res = Tbbn006OrganigramaPeer::doSelect($c);

        foreach($res as $result){
            
        }
        $r=(isset($result) && !empty($result))? $result->getNuOrden():0;
            return $r;
 
    }

    static public function getNuOrganigrama($codigo){

        

        $c = new Criteria();

        $c->add(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA,$codigo);
        $res = Tbbn006OrganigramaPeer::doSelect($c);

        foreach($res as $result)

            return $result->getCodAdm();

        

    }

    static public function getOrganigrama($codigo){

        

        $c = new Criteria();

        $c->add(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA,$codigo);
        $res = Tbbn006OrganigramaPeer::doSelect($c);

        foreach($res as $result)

            return $result->getTxOrganigrama();

        

    }


}
