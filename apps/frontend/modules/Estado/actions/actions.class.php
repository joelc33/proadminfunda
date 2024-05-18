<?php

/**
 * autoEstado actions.
 * NombreClaseModel(Tb016Estado)
 * NombreTabla(tb016_estado)
 * @package    ##PROJECT_NAME##
 * @subpackage autoEstado
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class EstadoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Estado', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Estado', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb016EstadoPeer::CO_ESTADO,$codigo);
        
        $stmt = Tb016EstadoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_estado"     => $campos["co_estado"],
                            "nb_estado"     => $campos["nb_estado"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_estado"     => "",
                            "nb_estado"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_estado");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb016_estado = Tb016EstadoPeer::retrieveByPk($codigo);
     }else{
         $tb016_estado = new Tb016Estado();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb016_estadoForm = $this->getRequestParameter('tb016_estado');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb016_estado->setNbEstado($tb016_estadoForm["nb_estado"]);
                                
        /*CAMPOS*/
        $tb016_estado->save($con);
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
	$codigo = $this->getRequestParameter("co_estado");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb016_estado = Tb016EstadoPeer::retrieveByPk($codigo);			
	$tb016_estado->delete($con);
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
                $nb_estado      =   $this->getRequestParameter("nb_estado");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($nb_estado!=""){$c->add(Tb016EstadoPeer::nb_estado,'%'.$nb_estado.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb016EstadoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb016EstadoPeer::CO_ESTADO);
        
    $stmt = Tb016EstadoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_estado"     => trim($res["co_estado"]),
            "nb_estado"     => trim($res["nb_estado"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    


}