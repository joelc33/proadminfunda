<?php

/**
 * autoTipoAyuda actions.
 * NombreClaseModel(Tb127TipoAyuda)
 * NombreTabla(tb127_tipo_ayuda)
 * @package    ##PROJECT_NAME##
 * @subpackage autoTipoAyuda
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class TipoAyudaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('TipoAyuda', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('TipoAyuda', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb127TipoAyudaPeer::CO_TIPO_AYUDA,$codigo);
        
        $stmt = Tb127TipoAyudaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_tipo_ayuda"     => $campos["co_tipo_ayuda"],
                            "tx_tipo_ayuda"     => $campos["tx_tipo_ayuda"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_tipo_ayuda"     => "",
                            "tx_tipo_ayuda"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_tipo_ayuda");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb127_tipo_ayuda = Tb127TipoAyudaPeer::retrieveByPk($codigo);
     }else{
         $tb127_tipo_ayuda = new Tb127TipoAyuda();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb127_tipo_ayudaForm = $this->getRequestParameter('tb127_tipo_ayuda');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb127_tipo_ayuda->setTxTipoAyuda($tb127_tipo_ayudaForm["tx_tipo_ayuda"]);
                                
        /*CAMPOS*/
        $tb127_tipo_ayuda->save($con);
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
	$codigo = $this->getRequestParameter("co_tipo_ayuda");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb127_tipo_ayuda = Tb127TipoAyudaPeer::retrieveByPk($codigo);			
	$tb127_tipo_ayuda->delete($con);
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
                $tx_tipo_ayuda      =   $this->getRequestParameter("tx_tipo_ayuda");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_tipo_ayuda!=""){$c->add(Tb127TipoAyudaPeer::tx_tipo_ayuda,'%'.$tx_tipo_ayuda.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb127TipoAyudaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb127TipoAyudaPeer::CO_TIPO_AYUDA);
        
    $stmt = Tb127TipoAyudaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_tipo_ayuda"     => trim($res["co_tipo_ayuda"]),
            "tx_tipo_ayuda"     => trim($res["tx_tipo_ayuda"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    


}