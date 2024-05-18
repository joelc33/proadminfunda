<?php

/**
 * autoActividad actions.
 * NombreClaseModel(Tb020Actividad)
 * NombreTabla(tb020_actividad)
 * @package    ##PROJECT_NAME##
 * @subpackage autoActividad
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class ActividadActions extends sfActions
{
  
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Actividad', 'lista');
  }
  
  public function executePresupuesto(sfWebRequest $request)
  {
      $this->data = json_encode(array(
                "co_programa" => $this->getRequestParameter("co_programa")
      ));
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Actividad', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb020ActividadPeer::CO_ACTIVIDAD,$codigo);
        
        $stmt = Tb020ActividadPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_actividad"     => $campos["co_actividad"],
                            "co_programa"     => $campos["co_programa"],
                            "tx_actividad"     => $campos["tx_actividad"],
                            "tx_denominacion_act"     => $campos["tx_denominacion_act"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_actividad"     => "",
                            "co_programa"     => $this->getRequestParameter("co_programa"),
                            "tx_actividad"     => "",
                            "tx_denominacion_act"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_actividad");
     $tb020_actividadForm = $this->getRequestParameter('tb020_actividad');
     
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb020_actividad = Tb020ActividadPeer::retrieveByPk($codigo);
     }else{
        $tb020_actividad = new Tb020Actividad();
         
        $c = new Criteria();
        $c->add(Tb020ActividadPeer::TX_ACTIVIDAD,$tb020_actividadForm["tx_actividad"]);
        $c->add(Tb020ActividadPeer::CO_PROGRAMA,$tb020_actividadForm["co_programa"]);
        $cantidad = Tb020ActividadPeer::doCount($c);
        
             
        if($cantidad>0){
            $stmt = Tb020ActividadPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $msg = "La Actividad N° <b>".$tb020_actividadForm["tx_actividad"]."</b> ya se encuentra registrado a la denominación <b>".$campos["tx_denominacion_act"]."</b>";
            
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $msg
            ));
            
            return 0;
            
        }
         
     }
     try
      { 
        $con->beginTransaction();
       
        
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb020_actividad->setCoPrograma($tb020_actividadForm["co_programa"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb020_actividad->setTxActividad($tb020_actividadForm["tx_actividad"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb020_actividad->setTxDenominacionAct($tb020_actividadForm["tx_denominacion_act"]);
                                
        /*CAMPOS*/
        $tb020_actividad->save($con);
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
	$codigo = $this->getRequestParameter("co_actividad");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb020_actividad = Tb020ActividadPeer::retrieveByPk($codigo);			
	$tb020_actividad->delete($con);
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
                "co_programa" => $this->getRequestParameter("co_programa")
      ));
  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",12);
    $start      =   $this->getRequestParameter("start",0);
    $co_programa      =   $this->getRequestParameter("co_programa");
    $tx_actividad      =   $this->getRequestParameter("tx_actividad");
    $tx_denominacion_act      =   $this->getRequestParameter("tx_denominacion_act");
        
    $c = new Criteria();
    
    if($co_programa!=""){$c->add(Tb020ActividadPeer::CO_PROGRAMA,$co_programa);}
    if($tx_actividad!=""){$c->add(Tb020ActividadPeer::TX_ACTIVIDAD,'%'.$tx_actividad.'%',Criteria::LIKE);}
    if($tx_denominacion_act!=""){$c->add(Tb020ActividadPeer::TX_DENOMINACION_ACT,'%'.$tx_denominacion_act.'%',Criteria::LIKE);}
                            
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb020ActividadPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb020ActividadPeer::CO_ACTIVIDAD);
        
    $stmt = Tb020ActividadPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_actividad"     => trim($res["co_actividad"]),
            "co_programa"     => trim($res["co_programa"]),
            "tx_actividad"     => trim($res["tx_actividad"]),
            "tx_denominacion_act"     => trim($res["tx_denominacion_act"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                            


}