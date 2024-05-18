<?php



class Tbrh095TrabajadorNovedadPeer extends BaseTbrh095TrabajadorNovedadPeer {

    static public function ficha( $cedula, $co_tp_nomina, $co_grupo_nomina){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh002FichaPeer::CO_FICHA);
        $c->addJoin(Tbrh001TrabajadorPeer::CO_TRABAJADOR, Tbrh002FichaPeer::CO_TRABAJADOR);
        $c->addJoin(Tbrh002FichaPeer::CO_FICHA, Tbrh015NomTrabajadorPeer::CO_FICHA);
        $c->add(Tbrh015NomTrabajadorPeer::CO_TP_NOMINA, $co_tp_nomina);
        $c->add(Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA, $co_grupo_nomina); 
        $c->add(Tbrh001TrabajadorPeer::NU_CEDULA, $cedula); 

        $stmt = Tbrh001TrabajadorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos["co_ficha"];
    
    }

    static public function novedad( $ficha, $co_tp_nomina, $co_grupo_nomina, $concepto, $fecha_inicio, $fecha_cierre){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn("sum(".Tbrh095TrabajadorNovedadPeer::NU_VALOR.") as nu_valor");
        $c->add(Tbrh095TrabajadorNovedadPeer::NU_CONCEPTO, $concepto);
        $c->add(Tbrh095TrabajadorNovedadPeer::CO_FICHA, $ficha);
        $c->add(Tbrh095TrabajadorNovedadPeer::CO_TP_NOMINA, $co_tp_nomina);
        $c->add(Tbrh095TrabajadorNovedadPeer::CO_GRUPO_NOMINA, $co_grupo_nomina);
        $c->add(Tbrh095TrabajadorNovedadPeer::IN_UTILIZADO, FALSE);
        $c->add(Tbrh095TrabajadorNovedadPeer::FE_NOVEDAD, $fecha_cierre, Criteria::LESS_EQUAL);
        $c->addAnd(Tbrh095TrabajadorNovedadPeer::FE_NOVEDAD, $fecha_inicio, Criteria::GREATER_EQUAL);
        $c->addAnd(Tbrh095TrabajadorNovedadPeer::FE_NOVEDAD, null, Criteria::ISNOTNULL);
        $c->addJoin(Tbrh095TrabajadorNovedadPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->add(Tb030RutaPeer::IN_ACTUAL, TRUE);
        $c->add(Tb030RutaPeer::CO_ESTATUS_RUTA, 1);

        $stmt = Tbrh095TrabajadorNovedadPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        /*$con = Propel::getConnection();

        try
        { 
            $con->beginTransaction();

            $wherec = new Criteria();
            $c2->add(Tbrh095TrabajadorNovedadPeer::NU_CONCEPTO, $concepto);
            $c2->add(Tbrh095TrabajadorNovedadPeer::CO_FICHA, $ficha);
            $c2->add(Tbrh095TrabajadorNovedadPeer::CO_TP_NOMINA, $co_tp_nomina);
            $c2->add(Tbrh095TrabajadorNovedadPeer::CO_GRUPO_NOMINA, $co_grupo_nomina);
            $c2->add(Tbrh095TrabajadorNovedadPeer::FE_NOVEDAD, $fecha_cierre, Criteria::LESS_EQUAL);
            $c2->addAnd(Tbrh095TrabajadorNovedadPeer::FE_NOVEDAD, $fecha_inicio, Criteria::GREATER_EQUAL);
            $c2->addAnd(Tbrh095TrabajadorNovedadPeer::FE_NOVEDAD, null, Criteria::ISNOTNULL);

            $updc = new Criteria();
            $updc->add(Tbrh095TrabajadorNovedadPeer::IN_UTILIZADO, TRUE);
            BasePeer::doUpdate($wherec, $updc, $con);

        }catch (PropelException $e){
            $con->rollback();
        }*/
              
        return $campos["nu_valor"];
    
    }

}
