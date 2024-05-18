<?php

/**
 * autoRamo actions.
 * NombreClaseModel(Tb038Ramo)
 * NombreTabla(tb038_ramo)
 * @package    ##PROJECT_NAME##
 * @subpackage autoRamo
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class RamoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Ramo', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Ramo', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb038RamoPeer::CO_RAMO,$codigo);
        
        $stmt = Tb038RamoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_ramo"     => $campos["co_ramo"],
                            "tx_ramo"     => $campos["tx_ramo"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_ramo"     => "",
                            "tx_ramo"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_ramo");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb038_ramo = Tb038RamoPeer::retrieveByPk($codigo);
     }else{
         $tb038_ramo = new Tb038Ramo();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb038_ramoForm = $this->getRequestParameter('tb038_ramo');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb038_ramo->setTxRamo($tb038_ramoForm["tx_ramo"]);
                                
        /*CAMPOS*/
        $tb038_ramo->save($con);
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
	$codigo = $this->getRequestParameter("co_ramo");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb038_ramo = Tb038RamoPeer::retrieveByPk($codigo);			
	$tb038_ramo->delete($con);
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
                $tx_ramo      =   $this->getRequestParameter("tx_ramo");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_ramo!=""){$c->add(Tb038RamoPeer::tx_ramo,'%'.$tx_ramo.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb038RamoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb038RamoPeer::CO_RAMO);
        
    $stmt = Tb038RamoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_ramo"     => trim($res["co_ramo"]),
            "tx_ramo"     => trim($res["tx_ramo"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    


}