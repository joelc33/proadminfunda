<?php

/**
 * autoConfiguracionRuta actions.
 * NombreClaseModel(Tb032ConfiguracionRuta)
 * NombreTabla(tb032_configuracion_ruta)
 * @package    ##PROJECT_NAME##
 * @subpackage autoConfiguracionRuta
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoConfiguracionRutaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConfiguracionRuta', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConfiguracionRuta', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb032ConfiguracionRutaPeer::CO_CONFIGURACION,$codigo);
        
        $stmt = Tb032ConfiguracionRutaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_configuracion"     => $campos["co_configuracion"],
                            "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                            "co_proceso"     => $campos["co_proceso"],
                            "nu_orden"     => $campos["nu_orden"],
                            "in_cargar_dato"     => $campos["in_cargar_dato"],
                            "nb_reporte_orden"     => $campos["nb_reporte_orden"],
                            "tx_url"     => $campos["tx_url"],
                            "tx_modulo"     => $campos["tx_modulo"],
                            "in_incompleto"     => $campos["in_incompleto"],
                            "op_reporte"     => $campos["op_reporte"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_configuracion"     => "",
                            "co_tipo_solicitud"     => "",
                            "co_proceso"     => "",
                            "nu_orden"     => "",
                            "in_cargar_dato"     => "",
                            "nb_reporte_orden"     => "",
                            "tx_url"     => "",
                            "tx_modulo"     => "",
                            "in_incompleto"     => "",
                            "op_reporte"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_configuracion");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb032_configuracion_ruta = Tb032ConfiguracionRutaPeer::retrieveByPk($codigo);
     }else{
         $tb032_configuracion_ruta = new Tb032ConfiguracionRuta();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb032_configuracion_rutaForm = $this->getRequestParameter('tb032_configuracion_ruta');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb032_configuracion_ruta->setCoTipoSolicitud($tb032_configuracion_rutaForm["co_tipo_solicitud"]);
                                                        
        /*Campo tipo BIGINT */
        $tb032_configuracion_ruta->setCoProceso($tb032_configuracion_rutaForm["co_proceso"]);
                                                        
        /*Campo tipo INTEGER */
        $tb032_configuracion_ruta->setNuOrden($tb032_configuracion_rutaForm["nu_orden"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_cargar_dato", $tb032_configuracion_rutaForm)){
            $tb032_configuracion_ruta->setInCargarDato(false);
        }else{
            $tb032_configuracion_ruta->setInCargarDato(true);
        }
                                                        
        /*Campo tipo VARCHAR */
        $tb032_configuracion_ruta->setNbReporteOrden($tb032_configuracion_rutaForm["nb_reporte_orden"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb032_configuracion_ruta->setTxUrl($tb032_configuracion_rutaForm["tx_url"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb032_configuracion_ruta->setTxModulo($tb032_configuracion_rutaForm["tx_modulo"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_incompleto", $tb032_configuracion_rutaForm)){
            $tb032_configuracion_ruta->setInIncompleto(false);
        }else{
            $tb032_configuracion_ruta->setInIncompleto(true);
        }
                                                        
        /*Campo tipo VARCHAR */
        $tb032_configuracion_ruta->setOpReporte($tb032_configuracion_rutaForm["op_reporte"]);
                                
        /*CAMPOS*/
        $tb032_configuracion_ruta->save($con);
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
	$codigo = $this->getRequestParameter("co_configuracion");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb032_configuracion_ruta = Tb032ConfiguracionRutaPeer::retrieveByPk($codigo);			
	$tb032_configuracion_ruta->delete($con);
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
            $co_proceso      =   $this->getRequestParameter("co_proceso");
            $nu_orden      =   $this->getRequestParameter("nu_orden");
            $in_cargar_dato      =   $this->getRequestParameter("in_cargar_dato");
            $nb_reporte_orden      =   $this->getRequestParameter("nb_reporte_orden");
            $tx_url      =   $this->getRequestParameter("tx_url");
            $tx_modulo      =   $this->getRequestParameter("tx_modulo");
            $in_incompleto      =   $this->getRequestParameter("in_incompleto");
            $op_reporte      =   $this->getRequestParameter("op_reporte");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_tipo_solicitud!=""){$c->add(Tb032ConfiguracionRutaPeer::co_tipo_solicitud,$co_tipo_solicitud);}
    
                                            if($co_proceso!=""){$c->add(Tb032ConfiguracionRutaPeer::co_proceso,$co_proceso);}
    
                                            if($nu_orden!=""){$c->add(Tb032ConfiguracionRutaPeer::nu_orden,$nu_orden);}
    
                                    
                                        if($nb_reporte_orden!=""){$c->add(Tb032ConfiguracionRutaPeer::nb_reporte_orden,'%'.$nb_reporte_orden.'%',Criteria::LIKE);}
        
                                        if($tx_url!=""){$c->add(Tb032ConfiguracionRutaPeer::tx_url,'%'.$tx_url.'%',Criteria::LIKE);}
        
                                        if($tx_modulo!=""){$c->add(Tb032ConfiguracionRutaPeer::tx_modulo,'%'.$tx_modulo.'%',Criteria::LIKE);}
        
                                    
                                        if($op_reporte!=""){$c->add(Tb032ConfiguracionRutaPeer::op_reporte,'%'.$op_reporte.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb032ConfiguracionRutaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb032ConfiguracionRutaPeer::CO_CONFIGURACION);
        
    $stmt = Tb032ConfiguracionRutaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_configuracion"     => trim($res["co_configuracion"]),
            "co_tipo_solicitud"     => trim($res["co_tipo_solicitud"]),
            "co_proceso"     => trim($res["co_proceso"]),
            "nu_orden"     => trim($res["nu_orden"]),
            "in_cargar_dato"     => trim($res["in_cargar_dato"]),
            "nb_reporte_orden"     => trim($res["nb_reporte_orden"]),
            "tx_url"     => trim($res["tx_url"]),
            "tx_modulo"     => trim($res["tx_modulo"]),
            "in_incompleto"     => trim($res["in_incompleto"]),
            "op_reporte"     => trim($res["op_reporte"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                                                                    


}