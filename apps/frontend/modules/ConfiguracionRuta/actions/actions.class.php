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
class ConfiguracionRutaActions extends sfActions
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
                            "co_configuracion"      => $campos["co_configuracion"],
                            "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                            "co_proceso"            => $campos["co_proceso"],
                            "nu_orden"              => $campos["nu_orden"],
                            "nb_reporte_orden"      => $campos["nb_reporte_orden"],
                            "tx_url"                => $campos["tx_url"],
                            "tx_modulo"             => $campos["tx_modulo"],
                            "in_cargar_dato"        => $campos["in_cargar_dato"],
                            "in_incompleto"         => $campos["in_incompleto"] 
            
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_configuracion"  => "",
                            "co_tipo_solicitud" => $this->getRequestParameter("co_tipo_solicitud"),
                            "co_proceso"        => "",
                            "nu_orden"          => "",
                            "nb_reporte_orden"  => "",
                            "tx_url"            => "",
                            "tx_modulo"         => "",
                            "in_cargar_dato"    => "",
                            "in_incompleto"     => ""
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
        
        $tb032_configuracion_ruta->setNbReporteOrden($tb032_configuracion_rutaForm["nb_reporte_orden"]);
                                                        
        /*Campo tipo INTEGER */
        $tb032_configuracion_ruta->setNuOrden($tb032_configuracion_rutaForm["nu_orden"]);
        
        $tb032_configuracion_ruta->setTxUrl($tb032_configuracion_rutaForm["tx_url"]);
        
        $tb032_configuracion_ruta->setTxModulo($tb032_configuracion_rutaForm["tx_modulo"]);
        
        $tb032_configuracion_ruta->setNuOrden($tb032_configuracion_rutaForm["nu_orden"]);
                            
        if(array_key_exists("in_cargar_dato", $tb032_configuracion_rutaForm)){
            $tb032_configuracion_ruta->setInCargarDato(true);
        }else{
            $tb032_configuracion_ruta->setInCargarDato(false);
        }
        
        if(array_key_exists("in_incompleto", $tb032_configuracion_rutaForm)){
            $tb032_configuracion_ruta->setInIncompleto(true);
        }else{
            $tb032_configuracion_ruta->setInIncompleto(false);
        }
        
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
        $this->data = json_encode(array(
                            "co_tipo_solicitud"  => $this->getRequestParameter("codigo")
                    ));
  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
            
    $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");    
    
    $c = new Criteria(); 
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
    $c->addSelectColumn(Tb032ConfiguracionRutaPeer::NU_ORDEN);
    $c->addSelectColumn(Tb032ConfiguracionRutaPeer::IN_CARGAR_DATO);
    $c->addSelectColumn(Tb032ConfiguracionRutaPeer::CO_CONFIGURACION);  
    $c->addSelectColumn(Tb032ConfiguracionRutaPeer::CO_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb032ConfiguracionRutaPeer::NB_REPORTE_ORDEN);
    $c->add(Tb032ConfiguracionRutaPeer::CO_TIPO_SOLICITUD,$co_tipo_solicitud);
    $c->addJoin(Tb028ProcesoPeer::CO_PROCESO, Tb032ConfiguracionRutaPeer::CO_PROCESO);
    $cantidadTotal = Tb032ConfiguracionRutaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb032ConfiguracionRutaPeer::NU_ORDEN);
    
    $stmt = Tb032ConfiguracionRutaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    
    if($res["in_cargar_dato"]==true){
        $res["in_cargar_dato"] = 'SI';
    }else{
        $res["in_cargar_dato"] = 'NO';
    }
        
        
    $registros[] = array(
            "co_configuracion"     => trim($res["co_configuracion"]),
            "co_tipo_solicitud"    => trim($res["co_tipo_solicitud"]),
            "in_cargar_dato"       => $res["in_cargar_dato"],
            "tx_proceso"           => trim($res["tx_proceso"]),
            "nb_reporte_orden"     => trim($res["nb_reporte_orden"]),
            "nu_orden"             => trim($res["nu_orden"]),
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
                    //modelo fk tb028_proceso.CO_PROCESO
    public function executeStorefkcoproceso(sfWebRequest $request){
        
       /* $cr = new Criteria();
        $cr->clearSelectColumns();
        $cr->addSelectColumn(Tb032ConfiguracionRutaPeer::CO_PROCESO);
        $cr->add(Tb032ConfiguracionRutaPeer::CO_TIPO_SOLICITUD,1);
        $stmtr = Tb032ConfiguracionRutaPeer::doSelectStmt($cr);
        $i=0;
        while($res = $stmtr->fetch(PDO::FETCH_ASSOC)){
            $registros[$i] = $res["co_proceso"];
            $i++;
        }*/
        
        
        
        $c = new Criteria();
      //  $c->add(Tb028ProcesoPeer::CO_PROCESO,$registros, Criteria::NOT_IN);        
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
                    


}