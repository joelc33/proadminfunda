<?php

/**
 * autoDescripcionCuenta actions.
 * NombreClaseModel(Tb014DescripcionCuenta)
 * NombreTabla(tb014_descripcion_cuenta)
 * @package    ##PROJECT_NAME##
 * @subpackage autoDescripcionCuenta
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class DescripcionCuentaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('DescripcionCuenta', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('DescripcionCuenta', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb014DescripcionCuentaPeer::CO_DESCRIPCION_CUENTA,$codigo);
        
        $stmt = Tb014DescripcionCuentaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_descripcion_cuenta"     => $campos["co_descripcion_cuenta"],
                            "tx_descripcion_cuenta"     => $campos["tx_descripcion_cuenta"],
                            "in_activo"     => $campos["in_activo"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_descripcion_cuenta"     => "",
                            "tx_descripcion_cuenta"     => "",
                            "in_activo"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_descripcion_cuenta");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb014_descripcion_cuenta = Tb014DescripcionCuentaPeer::retrieveByPk($codigo);
     }else{
         $tb014_descripcion_cuenta = new Tb014DescripcionCuenta();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb014_descripcion_cuentaForm = $this->getRequestParameter('tb014_descripcion_cuenta');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb014_descripcion_cuenta->setTxDescripcionCuenta($tb014_descripcion_cuentaForm["tx_descripcion_cuenta"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb014_descripcion_cuentaForm)){
            $tb014_descripcion_cuenta->setInActivo(false);
        }else{
            $tb014_descripcion_cuenta->setInActivo(true);
        }
                                
        /*CAMPOS*/
        $tb014_descripcion_cuenta->save($con);
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
	$codigo = $this->getRequestParameter("co_descripcion_cuenta");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb014_descripcion_cuenta = Tb014DescripcionCuentaPeer::retrieveByPk($codigo);			
	$tb014_descripcion_cuenta->delete($con);
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
                $tx_descripcion_cuenta      =   $this->getRequestParameter("tx_descripcion_cuenta");
            $in_activo      =   $this->getRequestParameter("in_activo");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_descripcion_cuenta!=""){$c->add(Tb014DescripcionCuentaPeer::tx_descripcion_cuenta,'%'.$tx_descripcion_cuenta.'%',Criteria::LIKE);}
        
                                    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb014DescripcionCuentaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb014DescripcionCuentaPeer::CO_DESCRIPCION_CUENTA);
        
    $stmt = Tb014DescripcionCuentaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_descripcion_cuenta"     => trim($res["co_descripcion_cuenta"]),
            "tx_descripcion_cuenta"     => trim($res["tx_descripcion_cuenta"]),
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