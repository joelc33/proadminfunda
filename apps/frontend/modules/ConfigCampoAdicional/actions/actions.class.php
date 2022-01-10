<?php

/**
 * ConfigCampoAdicional actions.
 *
 * @package    gobel
 * @subpackage ConfigCampoAdicional
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConfigCampoAdicionalActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConfigCampoAdicional', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConfigCampoAdicional', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh019ConcepAdicionalPeer::CO_CONCEP_ADICIONAL,$codigo);
        
        $stmt = Tbrh019ConcepAdicionalPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_concep_adicional"     => $campos["co_concep_adicional"],
                            "tx_concep_adicional"     => $campos["tx_concep_adicional"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_concep_adicional"     => "",
                            "tx_concep_adicional"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_concep_adicional");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh019_concep_adicional = Tbrh019ConcepAdicionalPeer::retrieveByPk($codigo);
     }else{
         $tbrh019_concep_adicional = new Tbrh019ConcepAdicional();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh019_concep_adicionalForm = $this->getRequestParameter('tbrh019_concep_adicional');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tbrh019_concep_adicional->setTxConcepAdicional($tbrh019_concep_adicionalForm["tx_concep_adicional"]);
                                
        /*CAMPOS*/
        $tbrh019_concep_adicional->save($con);
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
	$codigo = $this->getRequestParameter("co_concep_adicional");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh019_concep_adicional = Tbrh019ConcepAdicionalPeer::retrieveByPk($codigo);			
	$tbrh019_concep_adicional->delete($con);
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
                $tx_concep_adicional      =   $this->getRequestParameter("tx_concep_adicional");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_concep_adicional!=""){$c->add(Tbrh019ConcepAdicionalPeer::tx_concep_adicional,'%'.$tx_concep_adicional.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh019ConcepAdicionalPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh019ConcepAdicionalPeer::CO_CONCEP_ADICIONAL);
        
    $stmt = Tbrh019ConcepAdicionalPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_concep_adicional"     => trim($res["co_concep_adicional"]),
            "tx_concep_adicional"     => trim($res["tx_concep_adicional"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    


}