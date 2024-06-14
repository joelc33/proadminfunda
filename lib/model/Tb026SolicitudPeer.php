<?php

class Tb026SolicitudPeer extends BaseTb026SolicitudPeer
{
    static public function getCantRevision($co_solicitud)
    {
        $cs = new Criteria();
        $cs->add(Tb034RevisionPeer::CO_SOLICITUD, $co_solicitud);
        $cs->add(Tb034RevisionPeer::IN_ACTIVO, true);

        $cantidad = Tb034RevisionPeer::doCount($cs);

        return $cantidad;
    }

    protected static function  getVerificaRuta($codigo)
    {
        $c = new Criteria();
        $c->add(Tb032ConfiguracionRutaPeer::CO_TIPO_SOLICITUD, $codigo);
        $c->addAnd(Tb032ConfiguracionRutaPeer::NU_ORDEN, 1);
        $stmt = Tb032ConfiguracionRutaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos["co_proceso"];
    }

    protected static function crearRuta($con,$solicitud, $FeEmision,$codigo){
             
       $Tb030Ruta = new Tb030Ruta();
       $Tb030Ruta->setCoUsuario($codigo)
               ->setCoEstatusRuta(1)
               ->setNuOrden(1)
               ->setInActual(true)
               ->setCreatedAt($FeEmision)
               ->setUpdatedAt($FeEmision)
               ->setCoSolicitud($solicitud->getCoSolicitud())
               ->setCoProceso(self::getVerificaRuta($solicitud->getCoTipoSolicitud()))
               ->setCoTipoSolicitud($solicitud->getCoTipoSolicitud());
       
        if($solicitud->getTxObservacion()!=''){
            $Tb030Ruta->setObservacion($solicitud->getTxObservacion());
        }
        
        $Tb030Ruta->save($con);      
    }

    protected static function  getCoProceso($codigo){
        $c = new Criteria();
        $c->add(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD,$codigo);
        $stmt = Tb027TipoSolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos["co_proceso"];
    }  

    static public function setSolicitud($tb026_solicitudForm)
    {

        $con = Propel::getConnection();
        $conf_ruta = self::getVerificaRuta($tb026_solicitudForm["co_tipo_solicitud"]);

        if ($conf_ruta == '') {
            $data = array(
                "success" => false,
                "msg"    => 'No se genero la solicitud debido a que el tramite no tiene ruta asignada.'
            );
            return $data;
        }

        try {

            $con->beginTransaction();

            $tb026_solicitud = new Tb026Solicitud();
         
            if (date("Y") > $tb026_solicitudForm['ejercicio']) {
                list($dia, $mes, $anio) = explode("/", $tb026_solicitudForm["fe_solicitud"]);
                $FeEmision = $anio . "-" . $mes . "-" . $dia;
            } else {
                list($dia, $mes, $anio) = explode("/", $tb026_solicitudForm["fe_solicitud"]);
                $FeEmision = $anio . "-" . $mes . "-" . $dia;
            }


            $tb026_solicitud->setCoProceso(self::getCoProceso($tb026_solicitudForm["co_tipo_solicitud"]));
            $tb026_solicitud->setCoTipoSolicitud($tb026_solicitudForm["co_tipo_solicitud"]);
            $tb026_solicitud->setTxObservacion($tb026_solicitudForm["observacion"]);
            $tb026_solicitud->setCoEstatus(1);
            $tb026_solicitud->setCreatedAt($FeEmision);
            $tb026_solicitud->setUpdatedAt($FeEmision);

            $tb026_solicitud->setCoUsuario($tb026_solicitudForm['codigo']);
            $tb026_solicitud->setIdTb013AnioFiscal($tb026_solicitudForm['ejercicio']);
           
            $tb026_solicitud->setFeRegistro($FeEmision);
            $tb026_solicitud->save($con);

            self::crearRuta($con, $tb026_solicitud, $FeEmision, $tb026_solicitudForm['codigo']);
            $cod_solicitud = $tb026_solicitud->getCoSolicitud();


            $data = array(
                "success" => true,
                "msg"     => 'Proceso realizado exitosamente.',
                "co_solicitud" => $cod_solicitud
            );

//            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            $data = array(
                "success" => false,
                "msg" =>  $e->getMessage()
            );
        }

        return $data;

    }
}
