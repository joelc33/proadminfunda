<?php




class Tb173MovimientoBienesPeer extends BaseTb173MovimientoBienesPeer {

     static public function getCoMovimientoBien($codigo,$solicitud){

        

        $c = new Criteria();

        $c->add(Tb173MovimientoBienesPeer::CO_BIENES,$codigo);

        $c->add(Tb173MovimientoBienesPeer::CO_SOLICITUD,$solicitud);

        $c->add(Tb173MovimientoBienesPeer::IN_ACTIVO,true);

        $res = Tb173MovimientoBienesPeer::doSelect($c);

        foreach($res as $result)

            return $result->getCoMovimientoBienes();

        

    }


         static public function getCoMovimientoBien2($codigo){

        

        $c = new Criteria();

        $c->add(Tb173MovimientoBienesPeer::CO_MOVIMIENTO_BIENES,$codigo);

        $res = Tb173MovimientoBienesPeer::doSelect($c);

        foreach($res as $result)

            return $result->getCoMovimientoBienes();

        

    }

         static public function getCoMovimientoBienNuevo($codigo,$solicitud){

        

        $c = new Criteria();

        $c->add(Tb173MovimientoBienesPeer::CO_BIENES,$codigo);

        $c->add(Tb173MovimientoBienesPeer::CO_SOLICITUD,$solicitud);

        $c->add(Tb173MovimientoBienesPeer::IN_ACTIVO,false);

        $res = Tb173MovimientoBienesPeer::doSelect($c);

        foreach($res as $result)

            return $result->getCoMovimientoBienes();

        

    }


     static public function getCantidad($codigo){

        

        $c = new Criteria();

        $c->add(Tb173MovimientoBienesPeer::CO_BIENES,$codigo);

        $c->add(Tb173MovimientoBienesPeer::IN_ACTIVO,true);

         $stmt = Tb173MovimientoBienesPeer::doSelectStmt($c);

        $registros = array();

        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){

            $registros[] = $reg;

        }

            return count($registros);

        

       }

       static public function getCantidadDoc($codigo){

        

        $c = new Criteria();

        $c->add(Tb173MovimientoBienesPeer::CO_DOCUMENTO,$codigo);
         $stmt = Tb173MovimientoBienesPeer::doSelectStmt($c);

        $registros = array();

        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){

            $registros[] = $reg;

        }

            return count($registros);

        

       }


      static public function getActivo(){

        

        $c = new Criteria();

        $c->add(Tb173MovimientoBienesPeer::IN_ACTIVO,true);

        $res = Tb173MovimientoBienesPeer::doSelect($c);

        foreach($res as $result)

            return $result->getCoMovimientoBienes();

        

    }


    static public function getEjecutor($codigo){

        

        $c = new Criteria();

        $c->addSelectColumn(Tb082EjecutorPeer::DE_EJECUTOR);

        $c->addJoin(Tb082EjecutorPeer::ID, Tb173MovimientoBienesPeer::CO_EJECUTOR);

        $c->add(Tb173MovimientoBienesPeer::CO_EJECUTOR,$codigo);

       // $res = Tb173MovimientoBienesPeer::doSelect($c);

         $stmt = self::doSelectStmt($c);

        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        //foreach($res as $result)

            return  $campos["de_ejecutor"];

        

    }


      static public function getFisico($codigo){

        

        $c = new Criteria();

        $c->addSelectColumn(Tb047EntePeer::TX_ENTE);

        $c->addJoin(Tb047EntePeer::CO_ENTE, Tb173MovimientoBienesPeer::CO_FISICO);

        $c->add(Tb173MovimientoBienesPeer::CO_FISICO,$codigo);

       // $res = Tb173MovimientoBienesPeer::doSelect($c);

         $stmt = self::doSelectStmt($c);

        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        //foreach($res as $result)

            return  $campos["tx_ente"];

        

    }

    static public function getUltimoUbicacion($codigo){

        

        $c = new Criteria();

        $c->addDescendingOrderByColumn(Tb173MovimientoBienesPeer::CO_MOVIMIENTO_BIENES);

        $c->add(Tb173MovimientoBienesPeer::CO_BIENES,$codigo);

        $c->add(Tb173MovimientoBienesPeer::IN_ACTIVO,true);

         $c->setLimit(1);

         $stmt = self::doSelectStmt($c);

         $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        //foreach($res as $result)

         return  $campos["co_documento"];

        

    }

    static public function getUltimoEjecutor($codigo){

        

        $c = new Criteria();

        $c->addDescendingOrderByColumn(Tb173MovimientoBienesPeer::CO_MOVIMIENTO_BIENES);

        $c->add(Tb173MovimientoBienesPeer::CO_BIENES,$codigo);

         $c->add(Tb173MovimientoBienesPeer::IN_ACTIVO,true);

         $c->setLimit(1);

         $stmt = self::doSelectStmt($c);

         $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        //foreach($res as $result)

         return  $campos["co_ejecutor"];

        

    }


    static public function getUltimoFisico($codigo){

        

        $c = new Criteria();

        $c->addDescendingOrderByColumn(Tb173MovimientoBienesPeer::CO_MOVIMIENTO_BIENES);

        $c->add(Tb173MovimientoBienesPeer::CO_BIENES,$codigo);

         $c->add(Tb173MovimientoBienesPeer::IN_ACTIVO,true);

         $c->setLimit(1);

         $stmt = self::doSelectStmt($c);

         $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        //foreach($res as $result)

         return  $campos["co_fisico"];

        

    }


      static public function getUltimoMovimiento($codigo){

        

        $c = new Criteria();

        $c->addDescendingOrderByColumn(Tb173MovimientoBienesPeer::CO_MOVIMIENTO_BIENES);

        $c->add(Tb173MovimientoBienesPeer::CO_BIENES,$codigo);

         $c->add(Tb173MovimientoBienesPeer::IN_ACTIVO,true);

         $c->setLimit(1);

         $stmt = self::doSelectStmt($c);

         $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        //foreach($res as $result)

         return  $campos["co_movimiento_bienes"];

        

    }

     static public function getVeriMovimiento($codigo){

        

        $c = new Criteria();

        $c->addDescendingOrderByColumn(Tb173MovimientoBienesPeer::CO_MOVIMIENTO_BIENES);

        $c->add(Tb173MovimientoBienesPeer::CO_BIENES,$codigo);

         $c->setLimit(1);

         $stmt = self::doSelectStmt($c);

         $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        //foreach($res as $result)

         return  $campos["in_activo"];

        

    }

    

}

