<?php

/**
 * autoEnte actions.
 * NombreClaseModel(Tb047Ente)
 * NombreTabla(tb047_ente)
 * @package    ##PROJECT_NAME##
 * @subpackage autoEnte
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class EnteActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Ente', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Ente', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb047EntePeer::CO_ENTE,$codigo);
        
        $stmt = Tb047EntePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_ente"     => $campos["co_ente"],
                            "tx_ente"     => $campos["tx_ente"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_ente"     => "",
                            "tx_ente"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_ente");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb047_ente = Tb047EntePeer::retrieveByPk($codigo);
     }else{
         $tb047_ente = new Tb047Ente();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb047_enteForm = $this->getRequestParameter('tb047_ente');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb047_ente->setTxEnte($tb047_enteForm["tx_ente"]);
                                
        /*CAMPOS*/
        $tb047_ente->save($con);
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
	$codigo = $this->getRequestParameter("co_ente");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb047_ente = Tb047EntePeer::retrieveByPk($codigo);			
	$tb047_ente->delete($con);
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
                $tx_ente      =   $this->getRequestParameter("tx_ente");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_ente!=""){$c->add(Tb047EntePeer::tx_ente,'%'.$tx_ente.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb047EntePeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb047EntePeer::CO_ENTE);
        
    $stmt = Tb047EntePeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_ente"     => trim($res["co_ente"]),
            "tx_ente"     => trim($res["tx_ente"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    


}