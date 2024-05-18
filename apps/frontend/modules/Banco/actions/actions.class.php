<?php

/**
 * autoBanco actions.
 * NombreClaseModel(Tb010Banco)
 * NombreTabla(tb010_banco)
 * @package    ##PROJECT_NAME##
 * @subpackage autoBanco
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class BancoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Banco', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Banco', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb010BancoPeer::CO_BANCO,$codigo);
        
        $stmt = Tb010BancoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_banco"     => $campos["co_banco"],
                            "tx_banco"     => $campos["tx_banco"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_banco"     => "",
                            "tx_banco"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_banco");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb010_banco = Tb010BancoPeer::retrieveByPk($codigo);
     }else{
         $tb010_banco = new Tb010Banco();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb010_bancoForm = $this->getRequestParameter('tb010_banco');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb010_banco->setTxBanco($tb010_bancoForm["tx_banco"]);
                                
        /*CAMPOS*/
        $tb010_banco->save($con);
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
	$codigo = $this->getRequestParameter("co_banco");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb010_banco = Tb010BancoPeer::retrieveByPk($codigo);			
	$tb010_banco->delete($con);
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
		    "msg" => 'El Banco no puede ser borrado, debido a que <br>se encuentra asociado a una cuenta bancaria'
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
                $tx_banco      =   $this->getRequestParameter("tx_banco");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_banco!=""){$c->add(Tb010BancoPeer::tx_banco,'%'.$tx_banco.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb010BancoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb010BancoPeer::CO_BANCO);
        
    $stmt = Tb010BancoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_banco"     => trim($res["co_banco"]),
            "tx_banco"     => trim($res["tx_banco"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    


}