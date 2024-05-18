<?php

/**
 * autoPresupuestomodificacion actions.
 * NombreClaseModel(Tb096PresupuestoModificacion)
 * NombreTabla(tb096_presupuesto_modificacion)
 * @package    ##PROJECT_NAME##
 * @subpackage autoPresupuestomodificacion
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoPresupuestomodificacionActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Presupuestomodificacion', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Presupuestomodificacion', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb096PresupuestoModificacionPeer::ID,$codigo);
        
        $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb095_tipo_modificacion"     => $campos["id_tb095_tipo_modificacion"],
                            "nu_modificacion"     => $campos["nu_modificacion"],
                            "fe_modificacion"     => $campos["fe_modificacion"],
                            "de_modificacion"     => $campos["de_modificacion"],
                            "de_justificacion"     => $campos["de_justificacion"],
                            "nu_oficio"     => $campos["nu_oficio"],
                            "fe_oficio"     => $campos["fe_oficio"],
                            "de_articulo_ley"     => $campos["de_articulo_ley"],
                            "mo_modificacion"     => $campos["mo_modificacion"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "id_tb082_ejecutor"     => $campos["id_tb082_ejecutor"],
                            "id_tb013_anio_fiscal"     => $campos["id_tb013_anio_fiscal"],
                            "co_usuario"     => $campos["co_usuario"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                            "id_tb068_numero_fuente_financiamiento"     => $campos["id_tb068_numero_fuente_financiamiento"],
                            "id_tb082_ejecutor_origen"     => $campos["id_tb082_ejecutor_origen"],
                            "id_tb082_ejecutor_destino"     => $campos["id_tb082_ejecutor_destino"],
                            "id_tb152_tipo_credito"     => $campos["id_tb152_tipo_credito"],
                            "in_procesado"     => $campos["in_procesado"],
                            "id_tb073_fuente_financiamiento"     => $campos["id_tb073_fuente_financiamiento"],
                            "co_solicitud_anular"     => $campos["co_solicitud_anular"],
                            "in_anular"     => $campos["in_anular"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb095_tipo_modificacion"     => "",
                            "nu_modificacion"     => "",
                            "fe_modificacion"     => "",
                            "de_modificacion"     => "",
                            "de_justificacion"     => "",
                            "nu_oficio"     => "",
                            "fe_oficio"     => "",
                            "de_articulo_ley"     => "",
                            "mo_modificacion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "id_tb082_ejecutor"     => "",
                            "id_tb013_anio_fiscal"     => "",
                            "co_usuario"     => "",
                            "co_solicitud"     => "",
                            "co_tipo_solicitud"     => "",
                            "id_tb068_numero_fuente_financiamiento"     => "",
                            "id_tb082_ejecutor_origen"     => "",
                            "id_tb082_ejecutor_destino"     => "",
                            "id_tb152_tipo_credito"     => "",
                            "in_procesado"     => "",
                            "id_tb073_fuente_financiamiento"     => "",
                            "co_solicitud_anular"     => "",
                            "in_anular"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb096_presupuesto_modificacion = Tb096PresupuestoModificacionPeer::retrieveByPk($codigo);
     }else{
         $tb096_presupuesto_modificacion = new Tb096PresupuestoModificacion();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb096_presupuesto_modificacionForm = $this->getRequestParameter('tb096_presupuesto_modificacion');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb096_presupuesto_modificacion->setIdTb095TipoModificacion($tb096_presupuesto_modificacionForm["id_tb095_tipo_modificacion"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb096_presupuesto_modificacion->setNuModificacion($tb096_presupuesto_modificacionForm["nu_modificacion"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_modificacion"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb096_presupuesto_modificacion->setFeModificacion($fecha);
                                                        
        /*Campo tipo VARCHAR */
        $tb096_presupuesto_modificacion->setDeModificacion($tb096_presupuesto_modificacionForm["de_modificacion"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb096_presupuesto_modificacion->setDeJustificacion($tb096_presupuesto_modificacionForm["de_justificacion"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb096_presupuesto_modificacion->setNuOficio($tb096_presupuesto_modificacionForm["nu_oficio"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_oficio"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb096_presupuesto_modificacion->setFeOficio($fecha);
                                                        
        /*Campo tipo VARCHAR */
        $tb096_presupuesto_modificacion->setDeArticuloLey($tb096_presupuesto_modificacionForm["de_articulo_ley"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb096_presupuesto_modificacion->setMoModificacion($tb096_presupuesto_modificacionForm["mo_modificacion"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb096_presupuesto_modificacionForm)){
            $tb096_presupuesto_modificacion->setInActivo(false);
        }else{
            $tb096_presupuesto_modificacion->setInActivo(true);
        }
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb096_presupuesto_modificacion->setCreatedAt($fecha);
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb096_presupuesto_modificacion->setUpdatedAt($fecha);
                                                        
        /*Campo tipo BIGINT */
        $tb096_presupuesto_modificacion->setIdTb082Ejecutor($tb096_presupuesto_modificacionForm["id_tb082_ejecutor"]);
                                                        
        /*Campo tipo BIGINT */
        $tb096_presupuesto_modificacion->setIdTb013AnioFiscal($tb096_presupuesto_modificacionForm["id_tb013_anio_fiscal"]);
                                                        
        /*Campo tipo BIGINT */
        $tb096_presupuesto_modificacion->setCoUsuario($tb096_presupuesto_modificacionForm["co_usuario"]);
                                                        
        /*Campo tipo BIGINT */
        $tb096_presupuesto_modificacion->setCoSolicitud($tb096_presupuesto_modificacionForm["co_solicitud"]);
                                                        
        /*Campo tipo BIGINT */
        $tb096_presupuesto_modificacion->setCoTipoSolicitud($tb096_presupuesto_modificacionForm["co_tipo_solicitud"]);
                                                        
        /*Campo tipo BIGINT */
        $tb096_presupuesto_modificacion->setIdTb068NumeroFuenteFinanciamiento($tb096_presupuesto_modificacionForm["id_tb068_numero_fuente_financiamiento"]);
                                                        
        /*Campo tipo BIGINT */
        $tb096_presupuesto_modificacion->setIdTb082EjecutorOrigen($tb096_presupuesto_modificacionForm["id_tb082_ejecutor_origen"]);
                                                        
        /*Campo tipo BIGINT */
        $tb096_presupuesto_modificacion->setIdTb082EjecutorDestino($tb096_presupuesto_modificacionForm["id_tb082_ejecutor_destino"]);
                                                        
        /*Campo tipo BIGINT */
        $tb096_presupuesto_modificacion->setIdTb152TipoCredito($tb096_presupuesto_modificacionForm["id_tb152_tipo_credito"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_procesado", $tb096_presupuesto_modificacionForm)){
            $tb096_presupuesto_modificacion->setInProcesado(false);
        }else{
            $tb096_presupuesto_modificacion->setInProcesado(true);
        }
                                                        
        /*Campo tipo BIGINT */
        $tb096_presupuesto_modificacion->setIdTb073FuenteFinanciamiento($tb096_presupuesto_modificacionForm["id_tb073_fuente_financiamiento"]);
                                                        
        /*Campo tipo BIGINT */
        $tb096_presupuesto_modificacion->setCoSolicitudAnular($tb096_presupuesto_modificacionForm["co_solicitud_anular"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_anular", $tb096_presupuesto_modificacionForm)){
            $tb096_presupuesto_modificacion->setInAnular(false);
        }else{
            $tb096_presupuesto_modificacion->setInAnular(true);
        }
                                
        /*CAMPOS*/
        $tb096_presupuesto_modificacion->save($con);
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
	$codigo = $this->getRequestParameter("id");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb096_presupuesto_modificacion = Tb096PresupuestoModificacionPeer::retrieveByPk($codigo);			
	$tb096_presupuesto_modificacion->delete($con);
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
                $id_tb095_tipo_modificacion      =   $this->getRequestParameter("id_tb095_tipo_modificacion");
            $nu_modificacion      =   $this->getRequestParameter("nu_modificacion");
            $fe_modificacion      =   $this->getRequestParameter("fe_modificacion");
            $de_modificacion      =   $this->getRequestParameter("de_modificacion");
            $de_justificacion      =   $this->getRequestParameter("de_justificacion");
            $nu_oficio      =   $this->getRequestParameter("nu_oficio");
            $fe_oficio      =   $this->getRequestParameter("fe_oficio");
            $de_articulo_ley      =   $this->getRequestParameter("de_articulo_ley");
            $mo_modificacion      =   $this->getRequestParameter("mo_modificacion");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $id_tb082_ejecutor      =   $this->getRequestParameter("id_tb082_ejecutor");
            $id_tb013_anio_fiscal      =   $this->getRequestParameter("id_tb013_anio_fiscal");
            $co_usuario      =   $this->getRequestParameter("co_usuario");
            $co_solicitud      =   $this->getRequestParameter("co_solicitud");
            $co_tipo_solicitud      =   $this->getRequestParameter("co_tipo_solicitud");
            $id_tb068_numero_fuente_financiamiento      =   $this->getRequestParameter("id_tb068_numero_fuente_financiamiento");
            $id_tb082_ejecutor_origen      =   $this->getRequestParameter("id_tb082_ejecutor_origen");
            $id_tb082_ejecutor_destino      =   $this->getRequestParameter("id_tb082_ejecutor_destino");
            $id_tb152_tipo_credito      =   $this->getRequestParameter("id_tb152_tipo_credito");
            $in_procesado      =   $this->getRequestParameter("in_procesado");
            $id_tb073_fuente_financiamiento      =   $this->getRequestParameter("id_tb073_fuente_financiamiento");
            $co_solicitud_anular      =   $this->getRequestParameter("co_solicitud_anular");
            $in_anular      =   $this->getRequestParameter("in_anular");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($id_tb095_tipo_modificacion!=""){$c->add(Tb096PresupuestoModificacionPeer::id_tb095_tipo_modificacion,$id_tb095_tipo_modificacion);}
    
                                        if($nu_modificacion!=""){$c->add(Tb096PresupuestoModificacionPeer::nu_modificacion,'%'.$nu_modificacion.'%',Criteria::LIKE);}
        
                                    
        if($fe_modificacion!=""){
    list($dia, $mes,$anio) = explode("/",$fe_modificacion);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb096PresupuestoModificacionPeer::fe_modificacion,$fecha);
    }
                                        if($de_modificacion!=""){$c->add(Tb096PresupuestoModificacionPeer::de_modificacion,'%'.$de_modificacion.'%',Criteria::LIKE);}
        
                                        if($de_justificacion!=""){$c->add(Tb096PresupuestoModificacionPeer::de_justificacion,'%'.$de_justificacion.'%',Criteria::LIKE);}
        
                                        if($nu_oficio!=""){$c->add(Tb096PresupuestoModificacionPeer::nu_oficio,'%'.$nu_oficio.'%',Criteria::LIKE);}
        
                                    
        if($fe_oficio!=""){
    list($dia, $mes,$anio) = explode("/",$fe_oficio);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb096PresupuestoModificacionPeer::fe_oficio,$fecha);
    }
                                        if($de_articulo_ley!=""){$c->add(Tb096PresupuestoModificacionPeer::de_articulo_ley,'%'.$de_articulo_ley.'%',Criteria::LIKE);}
        
                                            if($mo_modificacion!=""){$c->add(Tb096PresupuestoModificacionPeer::mo_modificacion,$mo_modificacion);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb096PresupuestoModificacionPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb096PresupuestoModificacionPeer::updated_at,$fecha);
    }
                                            if($id_tb082_ejecutor!=""){$c->add(Tb096PresupuestoModificacionPeer::id_tb082_ejecutor,$id_tb082_ejecutor);}
    
                                            if($id_tb013_anio_fiscal!=""){$c->add(Tb096PresupuestoModificacionPeer::id_tb013_anio_fiscal,$id_tb013_anio_fiscal);}
    
                                            if($co_usuario!=""){$c->add(Tb096PresupuestoModificacionPeer::co_usuario,$co_usuario);}
    
                                            if($co_solicitud!=""){$c->add(Tb096PresupuestoModificacionPeer::co_solicitud,$co_solicitud);}
    
                                            if($co_tipo_solicitud!=""){$c->add(Tb096PresupuestoModificacionPeer::co_tipo_solicitud,$co_tipo_solicitud);}
    
                                            if($id_tb068_numero_fuente_financiamiento!=""){$c->add(Tb096PresupuestoModificacionPeer::id_tb068_numero_fuente_financiamiento,$id_tb068_numero_fuente_financiamiento);}
    
                                            if($id_tb082_ejecutor_origen!=""){$c->add(Tb096PresupuestoModificacionPeer::id_tb082_ejecutor_origen,$id_tb082_ejecutor_origen);}
    
                                            if($id_tb082_ejecutor_destino!=""){$c->add(Tb096PresupuestoModificacionPeer::id_tb082_ejecutor_destino,$id_tb082_ejecutor_destino);}
    
                                            if($id_tb152_tipo_credito!=""){$c->add(Tb096PresupuestoModificacionPeer::id_tb152_tipo_credito,$id_tb152_tipo_credito);}
    
                                    
                                            if($id_tb073_fuente_financiamiento!=""){$c->add(Tb096PresupuestoModificacionPeer::id_tb073_fuente_financiamiento,$id_tb073_fuente_financiamiento);}
    
                                            if($co_solicitud_anular!=""){$c->add(Tb096PresupuestoModificacionPeer::co_solicitud_anular,$co_solicitud_anular);}
    
                                    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb096PresupuestoModificacionPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb096PresupuestoModificacionPeer::ID);
        
    $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "id_tb095_tipo_modificacion"     => trim($res["id_tb095_tipo_modificacion"]),
            "nu_modificacion"     => trim($res["nu_modificacion"]),
            "fe_modificacion"     => trim($res["fe_modificacion"]),
            "de_modificacion"     => trim($res["de_modificacion"]),
            "de_justificacion"     => trim($res["de_justificacion"]),
            "nu_oficio"     => trim($res["nu_oficio"]),
            "fe_oficio"     => trim($res["fe_oficio"]),
            "de_articulo_ley"     => trim($res["de_articulo_ley"]),
            "mo_modificacion"     => trim($res["mo_modificacion"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "id_tb082_ejecutor"     => trim($res["id_tb082_ejecutor"]),
            "id_tb013_anio_fiscal"     => trim($res["id_tb013_anio_fiscal"]),
            "co_usuario"     => trim($res["co_usuario"]),
            "co_solicitud"     => trim($res["co_solicitud"]),
            "co_tipo_solicitud"     => trim($res["co_tipo_solicitud"]),
            "id_tb068_numero_fuente_financiamiento"     => trim($res["id_tb068_numero_fuente_financiamiento"]),
            "id_tb082_ejecutor_origen"     => trim($res["id_tb082_ejecutor_origen"]),
            "id_tb082_ejecutor_destino"     => trim($res["id_tb082_ejecutor_destino"]),
            "id_tb152_tipo_credito"     => trim($res["id_tb152_tipo_credito"]),
            "in_procesado"     => trim($res["in_procesado"]),
            "id_tb073_fuente_financiamiento"     => trim($res["id_tb073_fuente_financiamiento"]),
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

                    //modelo fk tb095_tipo_modificacion.ID
    public function executeStorefkidtb095tipomodificacion(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb095TipoModificacionPeer::doSelectStmt($c);
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
                                                                                                                                                        //modelo fk tb082_ejecutor.ID
    public function executeStorefkidtb082ejecutor(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb082EjecutorPeer::doSelectStmt($c);
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