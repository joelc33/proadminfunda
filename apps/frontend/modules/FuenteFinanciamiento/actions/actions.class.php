<?php

/**
 * autoFuenteFinanciamiento actions.
 * NombreClaseModel(Tb073FuenteFinanciamiento)
 * NombreTabla(tb073_fuente_financiamiento)
 * @package    ##PROJECT_NAME##
 * @subpackage autoFuenteFinanciamiento
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class FuenteFinanciamientoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('FuenteFinanciamiento', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('FuenteFinanciamiento', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb073FuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO,$codigo);
        
        $stmt = Tb073FuenteFinanciamientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_fuente_financiamiento"     => $campos["co_fuente_financiamiento"],
                            "tx_fuente_financiamiento"     => $campos["tx_fuente_financiamiento"],
                            "tx_siglas"     => $campos["tx_siglas"],
                            "in_activo"     => $campos["in_activo"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_fuente_financiamiento"     => "",
                            "tx_fuente_financiamiento"     => "",
                            "tx_siglas"     => "",
                            "in_activo"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_fuente_financiamiento");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb073_fuente_financiamiento = Tb073FuenteFinanciamientoPeer::retrieveByPk($codigo);
     }else{
         $tb073_fuente_financiamiento = new Tb073FuenteFinanciamiento();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb073_fuente_financiamientoForm = $this->getRequestParameter('tb073_fuente_financiamiento');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb073_fuente_financiamiento->setTxFuenteFinanciamiento($tb073_fuente_financiamientoForm["tx_fuente_financiamiento"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb073_fuente_financiamiento->setTxSiglas($tb073_fuente_financiamientoForm["tx_siglas"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb073_fuente_financiamientoForm)){
            $tb073_fuente_financiamiento->setInActivo(true);
        }else{
            $tb073_fuente_financiamiento->setInActivo(false);
        }
                                
        /*CAMPOS*/
        $tb073_fuente_financiamiento->save($con);
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
	$codigo = $this->getRequestParameter("co_fuente_financiamiento");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb073_fuente_financiamiento = Tb073FuenteFinanciamientoPeer::retrieveByPk($codigo);			
	$tb073_fuente_financiamiento->delete($con);
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
                $tx_fuente_financiamiento      =   $this->getRequestParameter("tx_fuente_financiamiento");
            $tx_siglas      =   $this->getRequestParameter("tx_siglas");
            $in_activo      =   $this->getRequestParameter("in_activo");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_fuente_financiamiento!=""){$c->add(Tb073FuenteFinanciamientoPeer::tx_fuente_financiamiento,'%'.$tx_fuente_financiamiento.'%',Criteria::LIKE);}
        
                                        if($tx_siglas!=""){$c->add(Tb073FuenteFinanciamientoPeer::tx_siglas,'%'.$tx_siglas.'%',Criteria::LIKE);}
        
                                    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb073FuenteFinanciamientoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb073FuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO);
        
    $stmt = Tb073FuenteFinanciamientoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_fuente_financiamiento"     => trim($res["co_fuente_financiamiento"]),
            "tx_fuente_financiamiento"     => trim($res["tx_fuente_financiamiento"]),
            "tx_siglas"     => trim($res["tx_siglas"]),
            "in_activo"     => trim($res["in_activo"]?'SI':'NO'),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                            


}