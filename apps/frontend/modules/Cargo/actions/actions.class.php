<?php

/**
 * autoCargo actions.
 * NombreClaseModel(Tbrh032Cargo)
 * NombreTabla(tbrh032_cargo)
 * @package    ##PROJECT_NAME##
 * @subpackage autoCargo
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class CargoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Cargo', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Cargo', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh032CargoPeer::CO_CARGO,$codigo);
        
        $stmt = Tbrh032CargoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_cargo"     => $campos["co_cargo"],
                            "tx_cargo"     => $campos["tx_cargo"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_cargo"     => "",
                            "tx_cargo"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_cargo");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh032_cargo = Tbrh032CargoPeer::retrieveByPk($codigo);
     }else{
         $tbrh032_cargo = new Tbrh032Cargo();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh032_cargoForm = $this->getRequestParameter('tbrh032_cargo');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tbrh032_cargo->setTxCargo($tbrh032_cargoForm["tx_cargo"]);
                                                        
//        /*Campo tipo BOOLEAN */
//        if (array_key_exists("in_activo", $tbrh032_cargoForm)){
//            $tbrh032_cargo->setInActivo(false);
//        }else{
//            $tbrh032_cargo->setInActivo(true);
//        }
//                                                        
//        /*Campo tipo TIMESTAMP */
//        list($dia, $mes, $anio) = explode("/",$tbrh032_cargoForm["created_at"]);
//        $fecha = $anio."-".$mes."-".$dia;
//        $tbrh032_cargo->setCreatedAt($fecha);
//                                                        
//        /*Campo tipo TIMESTAMP */
//        list($dia, $mes, $anio) = explode("/",$tbrh032_cargoForm["updated_at"]);
//        $fecha = $anio."-".$mes."-".$dia;
//        $tbrh032_cargo->setUpdatedAt($fecha);
                                
        /*CAMPOS*/
        $tbrh032_cargo->save($con);
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
	$codigo = $this->getRequestParameter("co_cargo");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh032_cargo = Tbrh032CargoPeer::retrieveByPk($codigo);			
	$tbrh032_cargo->delete($con);
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
                $tx_cargo      =   $this->getRequestParameter("tx_cargo");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_cargo!=""){$c->add(Tbrh032CargoPeer::tx_cargo,'%'.$tx_cargo.'%',Criteria::LIKE);}
        
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh032CargoPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh032CargoPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh032CargoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh032CargoPeer::CO_CARGO);
        
    $stmt = Tbrh032CargoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_cargo"     => trim($res["co_cargo"]),
            "tx_cargo"     => trim($res["tx_cargo"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                        


}