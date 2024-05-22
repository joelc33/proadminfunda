<?php

/**
 * autoCaja actions.
 * NombreClaseModel(Tb030Ruta)
 * NombreTabla(tb030_ruta)
 * @package    ##PROJECT_NAME##
 * @subpackage autoCaja
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoCajaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Caja', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Caja', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb030RutaPeer::CO_RUTA,$codigo);
        
        $stmt = Tb030RutaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_ruta"     => $campos["co_ruta"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                            "co_proceso"     => $campos["co_proceso"],
                            "observacion"     => $campos["observacion"],
                            "co_estatus_ruta"     => $campos["co_estatus_ruta"],
                            "co_usuario"     => $campos["co_usuario"],
                            "nu_orden"     => $campos["nu_orden"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "in_actual"     => $campos["in_actual"],
                            "in_cargar_dato"     => $campos["in_cargar_dato"],
                            "tx_ruta_reporte"     => $campos["tx_ruta_reporte"],
                            "tx_imagen"     => $campos["tx_imagen"],
                            "tx_documento"     => $campos["tx_documento"],
                            "co_usuario_actualizo"     => $campos["co_usuario_actualizo"],
                            "co_solicitud_anular"     => $campos["co_solicitud_anular"],
                            "in_anular"     => $campos["in_anular"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_ruta"     => "",
                            "co_solicitud"     => "",
                            "co_tipo_solicitud"     => "",
                            "co_proceso"     => "",
                            "observacion"     => "",
                            "co_estatus_ruta"     => "",
                            "co_usuario"     => "",
                            "nu_orden"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "in_actual"     => "",
                            "in_cargar_dato"     => "",
                            "tx_ruta_reporte"     => "",
                            "tx_imagen"     => "",
                            "tx_documento"     => "",
                            "co_usuario_actualizo"     => "",
                            "co_solicitud_anular"     => "",
                            "in_anular"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_ruta");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb030_ruta = Tb030RutaPeer::retrieveByPk($codigo);
     }else{
         $tb030_ruta = new Tb030Ruta();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb030_rutaForm = $this->getRequestParameter('tb030_ruta');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb030_ruta->setCoSolicitud($tb030_rutaForm["co_solicitud"]);
                                                        
        /*Campo tipo BIGINT */
        $tb030_ruta->setCoTipoSolicitud($tb030_rutaForm["co_tipo_solicitud"]);
                                                        
        /*Campo tipo BIGINT */
        $tb030_ruta->setCoProceso($tb030_rutaForm["co_proceso"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb030_ruta->setObservacion($tb030_rutaForm["observacion"]);
                                                        
        /*Campo tipo INTEGER */
        $tb030_ruta->setCoEstatusRuta($tb030_rutaForm["co_estatus_ruta"]);
                                                        
        /*Campo tipo INTEGER */
        $tb030_ruta->setCoUsuario($tb030_rutaForm["co_usuario"]);
                                                        
        /*Campo tipo INTEGER */
        $tb030_ruta->setNuOrden($tb030_rutaForm["nu_orden"]);
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb030_rutaForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb030_ruta->setCreatedAt($fecha);
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb030_rutaForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb030_ruta->setUpdatedAt($fecha);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_actual", $tb030_rutaForm)){
            $tb030_ruta->setInActual(false);
        }else{
            $tb030_ruta->setInActual(true);
        }
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_cargar_dato", $tb030_rutaForm)){
            $tb030_ruta->setInCargarDato(false);
        }else{
            $tb030_ruta->setInCargarDato(true);
        }
                                                        
        /*Campo tipo VARCHAR */
        $tb030_ruta->setTxRutaReporte($tb030_rutaForm["tx_ruta_reporte"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb030_ruta->setTxImagen($tb030_rutaForm["tx_imagen"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb030_ruta->setTxDocumento($tb030_rutaForm["tx_documento"]);
                                                        
        /*Campo tipo BIGINT */
        $tb030_ruta->setCoUsuarioActualizo($tb030_rutaForm["co_usuario_actualizo"]);
                                                        
        /*Campo tipo BIGINT */
        $tb030_ruta->setCoSolicitudAnular($tb030_rutaForm["co_solicitud_anular"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_anular", $tb030_rutaForm)){
            $tb030_ruta->setInAnular(false);
        }else{
            $tb030_ruta->setInAnular(true);
        }
                                
        /*CAMPOS*/
        $tb030_ruta->save($con);
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente'
                ));
        $con->commit();
      }catch (PropelException $e)
      {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage()
        ));
      }
    }
  

  public function executeEliminar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_ruta");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb030_ruta = Tb030RutaPeer::retrieveByPk($codigo);			
	$tb030_ruta->delete($con);
		$this->data = json_encode(array(
			    "success" => true,
			    "msg" => 'Registro Borrado con exito!'
		));
	$con->commit();
	}catch (PropelException $e)
	{
	$con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
//		    "msg" =>  $e->getMessage()
		    "msg" => 'Este registro no se puede borrar porque <br>se encuentra asociado a otros registros'
		));
	}
  }

  public function executeLista(sfWebRequest $request)
  {

  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $co_solicitud      =   $this->getRequestParameter("co_solicitud");
            $co_tipo_solicitud      =   $this->getRequestParameter("co_tipo_solicitud");
            $co_proceso      =   $this->getRequestParameter("co_proceso");
            $observacion      =   $this->getRequestParameter("observacion");
            $co_estatus_ruta      =   $this->getRequestParameter("co_estatus_ruta");
            $co_usuario      =   $this->getRequestParameter("co_usuario");
            $nu_orden      =   $this->getRequestParameter("nu_orden");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $in_actual      =   $this->getRequestParameter("in_actual");
            $in_cargar_dato      =   $this->getRequestParameter("in_cargar_dato");
            $tx_ruta_reporte      =   $this->getRequestParameter("tx_ruta_reporte");
            $tx_imagen      =   $this->getRequestParameter("tx_imagen");
            $tx_documento      =   $this->getRequestParameter("tx_documento");
            $co_usuario_actualizo      =   $this->getRequestParameter("co_usuario_actualizo");
            $co_solicitud_anular      =   $this->getRequestParameter("co_solicitud_anular");
            $in_anular      =   $this->getRequestParameter("in_anular");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_solicitud!=""){$c->add(Tb030RutaPeer::co_solicitud,$co_solicitud);}
    
                                            if($co_tipo_solicitud!=""){$c->add(Tb030RutaPeer::co_tipo_solicitud,$co_tipo_solicitud);}
    
                                            if($co_proceso!=""){$c->add(Tb030RutaPeer::co_proceso,$co_proceso);}
    
                                        if($observacion!=""){$c->add(Tb030RutaPeer::observacion,'%'.$observacion.'%',Criteria::LIKE);}
        
                                            if($co_estatus_ruta!=""){$c->add(Tb030RutaPeer::co_estatus_ruta,$co_estatus_ruta);}
    
                                            if($co_usuario!=""){$c->add(Tb030RutaPeer::co_usuario,$co_usuario);}
    
                                            if($nu_orden!=""){$c->add(Tb030RutaPeer::nu_orden,$nu_orden);}
    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb030RutaPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb030RutaPeer::updated_at,$fecha);
    }
                                    
                                    
                                        if($tx_ruta_reporte!=""){$c->add(Tb030RutaPeer::tx_ruta_reporte,'%'.$tx_ruta_reporte.'%',Criteria::LIKE);}
        
                                        if($tx_imagen!=""){$c->add(Tb030RutaPeer::tx_imagen,'%'.$tx_imagen.'%',Criteria::LIKE);}
        
                                        if($tx_documento!=""){$c->add(Tb030RutaPeer::tx_documento,'%'.$tx_documento.'%',Criteria::LIKE);}
        
                                            if($co_usuario_actualizo!=""){$c->add(Tb030RutaPeer::co_usuario_actualizo,$co_usuario_actualizo);}
    
                                            if($co_solicitud_anular!=""){$c->add(Tb030RutaPeer::co_solicitud_anular,$co_solicitud_anular);}
    
                                    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb030RutaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb030RutaPeer::CO_RUTA);
        
    $stmt = Tb030RutaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_ruta"     => trim($res["co_ruta"]),
            "co_solicitud"     => trim($res["co_solicitud"]),
            "co_tipo_solicitud"     => trim($res["co_tipo_solicitud"]),
            "co_proceso"     => trim($res["co_proceso"]),
            "observacion"     => trim($res["observacion"]),
            "co_estatus_ruta"     => trim($res["co_estatus_ruta"]),
            "co_usuario"     => trim($res["co_usuario"]),
            "nu_orden"     => trim($res["nu_orden"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "in_actual"     => trim($res["in_actual"]),
            "in_cargar_dato"     => trim($res["in_cargar_dato"]),
            "tx_ruta_reporte"     => trim($res["tx_ruta_reporte"]),
            "tx_imagen"     => trim($res["tx_imagen"]),
            "tx_documento"     => trim($res["tx_documento"]),
            "co_usuario_actualizo"     => trim($res["co_usuario_actualizo"]),
            "co_solicitud_anular"     => trim($res["co_solicitud_anular"]),
            "in_anular"     => trim($res["in_anular"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb026_solicitud.CO_SOLICITUD
    public function executeStorefkcosolicitud(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
            ));
        $this->setTemplate('store');
    }
                    //modelo fk tb027_tipo_solicitud.CO_TIPO_SOLICITUD
    public function executeStorefkcotiposolicitud(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb027TipoSolicitudPeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
            ));
        $this->setTemplate('store');
    }
                    //modelo fk tb028_proceso.CO_PROCESO
    public function executeStorefkcoproceso(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb028ProcesoPeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
            ));
        $this->setTemplate('store');
    }
                                //modelo fk tb031_estatus_ruta.CO_ESTATUS_RUTA
    public function executeStorefkcoestatusruta(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb031EstatusRutaPeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
            ));
        $this->setTemplate('store');
    }
                                                                                                                                                        


}