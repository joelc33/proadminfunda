<?php

/**
 * autoNivelJerarquico actions.
 * NombreClaseModel(Tbrh004NivelJerarquico)
 * NombreTabla(tbrh004_nivel_jerarquico)
 * @package    ##PROJECT_NAME##
 * @subpackage autoNivelJerarquico
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class NivelJerarquicoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('NivelJerarquico', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('NivelJerarquico', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh004NivelJerarquicoPeer::CO_NIVEL_JERARQUICO,$codigo);
        
        $stmt = Tbrh004NivelJerarquicoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_nivel_jerarquico"     => $campos["co_nivel_jerarquico"],
                            "tx_nivel_jerarquico"     => $campos["tx_nivel_jerarquico"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_nivel_jerarquico"     => "",
                            "tx_nivel_jerarquico"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_nivel_jerarquico");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh004_nivel_jerarquico = Tbrh004NivelJerarquicoPeer::retrieveByPk($codigo);
     }else{
         $tbrh004_nivel_jerarquico = new Tbrh004NivelJerarquico();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh004_nivel_jerarquicoForm = $this->getRequestParameter('tbrh004_nivel_jerarquico');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tbrh004_nivel_jerarquico->setTxNivelJerarquico($tbrh004_nivel_jerarquicoForm["tx_nivel_jerarquico"]);
                                
        /*CAMPOS*/
        $tbrh004_nivel_jerarquico->save($con);
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
	$codigo = $this->getRequestParameter("co_nivel_jerarquico");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh004_nivel_jerarquico = Tbrh004NivelJerarquicoPeer::retrieveByPk($codigo);			
	$tbrh004_nivel_jerarquico->delete($con);
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
                $tx_nivel_jerarquico      =   $this->getRequestParameter("tx_nivel_jerarquico");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_nivel_jerarquico!=""){$c->add(Tbrh004NivelJerarquicoPeer::tx_nivel_jerarquico,'%'.$tx_nivel_jerarquico.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh004NivelJerarquicoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh004NivelJerarquicoPeer::CO_NIVEL_JERARQUICO);
        
    $stmt = Tbrh004NivelJerarquicoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_nivel_jerarquico"     => trim($res["co_nivel_jerarquico"]),
            "tx_nivel_jerarquico"     => trim($res["tx_nivel_jerarquico"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    


}