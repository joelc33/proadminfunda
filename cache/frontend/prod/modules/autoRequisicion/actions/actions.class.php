<?php

/**
 * autoRequisicion actions.
 * NombreClaseModel(Tb039Requisiciones)
 * NombreTabla(tb039_requisiciones)
 * @package    ##PROJECT_NAME##
 * @subpackage autoRequisicion
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoRequisicionActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Requisicion', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Requisicion', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb039RequisicionesPeer::CO_REQUISICION,$codigo);
        
        $stmt = Tb039RequisicionesPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_requisicion"     => $campos["co_requisicion"],
                            "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                            "co_usuario"     => $campos["co_usuario"],
                            "co_ente"     => $campos["co_ente"],
                            "created_at"     => $campos["created_at"],
                            "tx_concepto"     => $campos["tx_concepto"],
                            "tx_observacion"     => $campos["tx_observacion"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_servicio"     => $campos["co_servicio"],
                            "nu_requisicion"     => $campos["nu_requisicion"],
                            "nu_anio"     => $campos["nu_anio"],
                            "updated_at"     => $campos["updated_at"],
                            "fe_registro"     => $campos["fe_registro"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_requisicion"     => "",
                            "co_tipo_solicitud"     => "",
                            "co_usuario"     => "",
                            "co_ente"     => "",
                            "created_at"     => "",
                            "tx_concepto"     => "",
                            "tx_observacion"     => "",
                            "co_solicitud"     => "",
                            "co_servicio"     => "",
                            "nu_requisicion"     => "",
                            "nu_anio"     => "",
                            "updated_at"     => "",
                            "fe_registro"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_requisicion");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb039_requisiciones = Tb039RequisicionesPeer::retrieveByPk($codigo);
     }else{
         $tb039_requisiciones = new Tb039Requisiciones();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb039_requisicionesForm = $this->getRequestParameter('tb039_requisiciones');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb039_requisiciones->setCoTipoSolicitud($tb039_requisicionesForm["co_tipo_solicitud"]);
                                                        
        /*Campo tipo BIGINT */
        $tb039_requisiciones->setCoUsuario($tb039_requisicionesForm["co_usuario"]);
                                                        
        /*Campo tipo BIGINT */
        $tb039_requisiciones->setCoEnte($tb039_requisicionesForm["co_ente"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb039_requisicionesForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb039_requisiciones->setCreatedAt($fecha);
                                                        
        /*Campo tipo VARCHAR */
        $tb039_requisiciones->setTxConcepto($tb039_requisicionesForm["tx_concepto"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb039_requisiciones->setTxObservacion($tb039_requisicionesForm["tx_observacion"]);
                                                        
        /*Campo tipo BIGINT */
        $tb039_requisiciones->setCoSolicitud($tb039_requisicionesForm["co_solicitud"]);
                                                        
        /*Campo tipo BIGINT */
        $tb039_requisiciones->setCoServicio($tb039_requisicionesForm["co_servicio"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb039_requisiciones->setNuRequisicion($tb039_requisicionesForm["nu_requisicion"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb039_requisiciones->setNuAnio($tb039_requisicionesForm["nu_anio"]);
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb039_requisicionesForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb039_requisiciones->setUpdatedAt($fecha);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb039_requisicionesForm["fe_registro"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb039_requisiciones->setFeRegistro($fecha);
                                
        /*CAMPOS*/
        $tb039_requisiciones->save($con);
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
	$codigo = $this->getRequestParameter("co_requisicion");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb039_requisiciones = Tb039RequisicionesPeer::retrieveByPk($codigo);			
	$tb039_requisiciones->delete($con);
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
                $co_tipo_solicitud      =   $this->getRequestParameter("co_tipo_solicitud");
            $co_usuario      =   $this->getRequestParameter("co_usuario");
            $co_ente      =   $this->getRequestParameter("co_ente");
            $created_at      =   $this->getRequestParameter("created_at");
            $tx_concepto      =   $this->getRequestParameter("tx_concepto");
            $tx_observacion      =   $this->getRequestParameter("tx_observacion");
            $co_solicitud      =   $this->getRequestParameter("co_solicitud");
            $co_servicio      =   $this->getRequestParameter("co_servicio");
            $nu_requisicion      =   $this->getRequestParameter("nu_requisicion");
            $nu_anio      =   $this->getRequestParameter("nu_anio");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $fe_registro      =   $this->getRequestParameter("fe_registro");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_tipo_solicitud!=""){$c->add(Tb039RequisicionesPeer::co_tipo_solicitud,$co_tipo_solicitud);}
    
                                            if($co_usuario!=""){$c->add(Tb039RequisicionesPeer::co_usuario,$co_usuario);}
    
                                            if($co_ente!=""){$c->add(Tb039RequisicionesPeer::co_ente,$co_ente);}
    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb039RequisicionesPeer::created_at,$fecha);
    }
                                        if($tx_concepto!=""){$c->add(Tb039RequisicionesPeer::tx_concepto,'%'.$tx_concepto.'%',Criteria::LIKE);}
        
                                        if($tx_observacion!=""){$c->add(Tb039RequisicionesPeer::tx_observacion,'%'.$tx_observacion.'%',Criteria::LIKE);}
        
                                            if($co_solicitud!=""){$c->add(Tb039RequisicionesPeer::co_solicitud,$co_solicitud);}
    
                                            if($co_servicio!=""){$c->add(Tb039RequisicionesPeer::co_servicio,$co_servicio);}
    
                                            if($nu_requisicion!=""){$c->add(Tb039RequisicionesPeer::nu_requisicion,$nu_requisicion);}
    
                                            if($nu_anio!=""){$c->add(Tb039RequisicionesPeer::nu_anio,$nu_anio);}
    
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb039RequisicionesPeer::updated_at,$fecha);
    }
                                    
        if($fe_registro!=""){
    list($dia, $mes,$anio) = explode("/",$fe_registro);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb039RequisicionesPeer::fe_registro,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb039RequisicionesPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb039RequisicionesPeer::CO_REQUISICION);
        
    $stmt = Tb039RequisicionesPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_requisicion"     => trim($res["co_requisicion"]),
            "co_tipo_solicitud"     => trim($res["co_tipo_solicitud"]),
            "co_usuario"     => trim($res["co_usuario"]),
            "co_ente"     => trim($res["co_ente"]),
            "created_at"     => trim($res["created_at"]),
            "tx_concepto"     => trim($res["tx_concepto"]),
            "tx_observacion"     => trim($res["tx_observacion"]),
            "co_solicitud"     => trim($res["co_solicitud"]),
            "co_servicio"     => trim($res["co_servicio"]),
            "nu_requisicion"     => trim($res["nu_requisicion"]),
            "nu_anio"     => trim($res["nu_anio"]),
            "updated_at"     => trim($res["updated_at"]),
            "fe_registro"     => trim($res["fe_registro"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
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
                    //modelo fk tb001_usuario.CO_USUARIO
    public function executeStorefkcousuario(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb001UsuarioPeer::doSelectStmt($c);
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
                    //modelo fk tb050_servicio.CO_SERVICIO
    public function executeStorefkcoservicio(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb050ServicioPeer::doSelectStmt($c);
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