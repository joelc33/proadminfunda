<?php

/**
 * autoProceso actions.
 * NombreClaseModel(Tb028Proceso)
 * NombreTabla(tb028_proceso)
 * @package    ##PROJECT_NAME##
 * @subpackage autoProceso
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class ProcesoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Proceso', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Proceso', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  } 

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb028ProcesoPeer::CO_PROCESO,$codigo);
        
        $stmt = Tb028ProcesoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_proceso"     => $campos["co_proceso"],
                            "tx_proceso"     => $campos["tx_proceso"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_proceso"     => "",
                            "tx_proceso"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_proceso");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb028_proceso = Tb028ProcesoPeer::retrieveByPk($codigo);
     }else{
         $tb028_proceso = new Tb028Proceso();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb028_procesoForm = $this->getRequestParameter('tb028_proceso');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb028_proceso->setTxProceso($tb028_procesoForm["tx_proceso"]);
                                
        /*CAMPOS*/
        $tb028_proceso->save($con);
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
	$codigo = $this->getRequestParameter("co_proceso");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb028_proceso = Tb028ProcesoPeer::retrieveByPk($codigo);			
	$tb028_proceso->delete($con);
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
    $tx_proceso      =   $this->getRequestParameter("tx_proceso");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
        if($tx_proceso!=""){$c->add(Tb028ProcesoPeer::TX_PROCESO,'%'.$tx_proceso.'%',Criteria::LIKE);}
    }
    
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb028ProcesoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb028ProcesoPeer::CO_PROCESO);
        
    $stmt = Tb028ProcesoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_proceso"     => trim($res["co_proceso"]),
            "tx_proceso"     => trim($res["tx_proceso"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    


}