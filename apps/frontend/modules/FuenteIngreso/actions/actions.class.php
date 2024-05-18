<?php

/**
 * autoFuenteIngreso actions.
 * NombreClaseModel(Tb124FuenteIngreso)
 * NombreTabla(tb124_fuente_ingreso)
 * @package    ##PROJECT_NAME##
 * @subpackage autoFuenteIngreso
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class FuenteIngresoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('FuenteIngreso', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('FuenteIngreso', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb124FuenteIngresoPeer::CO_FUENTE_INGRESO,$codigo);
        
        $stmt = Tb124FuenteIngresoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_fuente_ingreso"     => $campos["co_fuente_ingreso"],
                            "tx_fuente_ingreso"     => $campos["tx_fuente_ingreso"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_fuente_ingreso"     => "",
                            "tx_fuente_ingreso"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_fuente_ingreso");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb124_fuente_ingreso = Tb124FuenteIngresoPeer::retrieveByPk($codigo);
     }else{
         $tb124_fuente_ingreso = new Tb124FuenteIngreso();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb124_fuente_ingresoForm = $this->getRequestParameter('tb124_fuente_ingreso');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb124_fuente_ingreso->setTxFuenteIngreso($tb124_fuente_ingresoForm["tx_fuente_ingreso"]);
                                
        /*CAMPOS*/
        $tb124_fuente_ingreso->save($con);
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
	$codigo = $this->getRequestParameter("co_fuente_ingreso");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb124_fuente_ingreso = Tb124FuenteIngresoPeer::retrieveByPk($codigo);			
	$tb124_fuente_ingreso->delete($con);
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
                $tx_fuente_ingreso      =   $this->getRequestParameter("tx_fuente_ingreso");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_fuente_ingreso!=""){$c->add(Tb124FuenteIngresoPeer::tx_fuente_ingreso,'%'.$tx_fuente_ingreso.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb124FuenteIngresoPeer::doCount($c);
   
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb124FuenteIngresoPeer::CO_FUENTE_INGRESO);
    $c->addSelectColumn(Tb124FuenteIngresoPeer::TX_FUENTE_INGRESO);
    $c->addSelectColumn(Tb024CuentaContablePeer::TX_CUENTA);
    $c->addJoin(Tb124FuenteIngresoPeer::CO_CUENTA_CONTABLE, Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Criteria::LEFT_JOIN);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb124FuenteIngresoPeer::CO_FUENTE_INGRESO);
        
    $stmt = Tb124FuenteIngresoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = $res;
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    


}