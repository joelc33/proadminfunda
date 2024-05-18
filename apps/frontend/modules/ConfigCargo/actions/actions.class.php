<?php

/**
 * ConfigCargo actions.
 *
 * @package    gobel
 * @subpackage ConfigCargo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConfigCargoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConfigCargo', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConfigCargo', 'editar');
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
                            "co_tabulador2"     => $campos["co_tabulador2"],
                            "nu_codigo"     => $campos["nu_codigo"],
                            "co_tp_tabulador"     => $campos["co_tp_tabulador"],
                            "co_tabulador"     => $campos["co_tabulador"],
                            "in_compensacion"     => $campos["in_compensacion"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_cargo"     => "",
                            "tx_cargo"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "co_tabulador2"     => "",
                            "nu_codigo"     => "",
                            "co_tp_tabulador"     => "",
                            "co_tabulador"     => "",
                            "in_compensacion"     => "",
                    ));
    }

  }

  public function executeParametro(sfWebRequest $request)
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
                            "co_tabulador2"     => $campos["co_tabulador2"],
                            "nu_codigo"     => $campos["nu_codigo"],
                            "co_tp_tabulador"     => $campos["co_tp_tabulador"],
                            "co_tabulador"     => $campos["co_tabulador"],
                            "in_compensacion"     => $campos["in_compensacion"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_cargo"     => "",
                            "tx_cargo"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "co_tabulador2"     => "",
                            "nu_codigo"     => "",
                            "co_tp_tabulador"     => "",
                            "co_tabulador"     => "",
                            "in_compensacion"     => "",
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
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tbrh032_cargoForm)){
            $tbrh032_cargo->setInActivo(false);
        }else{
            $tbrh032_cargo->setInActivo(true);
        }*/

        $tbrh032_cargo->setInActivo(true);
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh032_cargoForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh032_cargo->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh032_cargoForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh032_cargo->setUpdatedAt($fecha);*/
                                                        
        /*Campo tipo BIGINT */
        //$tbrh032_cargo->setCoTabulador2($tbrh032_cargoForm["co_tabulador2"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh032_cargo->setNuCodigo($tbrh032_cargoForm["nu_codigo"]);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh032_cargo->setCoTpTabulador($tbrh032_cargoForm["co_tp_tabulador"]);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh032_cargo->setCoTabulador($tbrh032_cargoForm["co_tabulador"]);

        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_compensacion", $tbrh032_cargoForm)){
          $tbrh032_cargo->setInCompensacion(true);
        }else{
            $tbrh032_cargo->setInCompensacion(false);
        }
                                
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
            $co_tabulador2      =   $this->getRequestParameter("co_tabulador2");
            $nu_codigo      =   $this->getRequestParameter("nu_codigo");
            $co_tp_tabulador      =   $this->getRequestParameter("co_tp_tabulador");
            $co_tabulador      =   $this->getRequestParameter("co_tabulador");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_cargo!=""){$c->add(Tbrh032CargoPeer::TX_CARGO,'%'.$tx_cargo.'%',Criteria::LIKE);}
        
                                    
                                    
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
                                            if($co_tabulador2!=""){$c->add(Tbrh032CargoPeer::co_tabulador2,$co_tabulador2);}
    
                                        if($nu_codigo!=""){$c->add(Tbrh032CargoPeer::NU_CODIGO,'%'.$nu_codigo.'%',Criteria::LIKE);}
        
                                            if($co_tp_tabulador!=""){$c->add(Tbrh032CargoPeer::co_tp_tabulador,$co_tp_tabulador);}
    
                                            if($co_tabulador!=""){$c->add(Tbrh032CargoPeer::co_tabulador,$co_tabulador);}
    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh032CargoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh032CargoPeer::CO_CARGO);

        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh032CargoPeer::CO_CARGO);
        $c->addSelectColumn(Tbrh032CargoPeer::TX_CARGO);
        $c->addSelectColumn(Tbrh032CargoPeer::NU_CODIGO);
        $c->addSelectColumn(Tbrh032CargoPeer::IN_COMPENSACION);
        $c->addSelectColumn(Tbrh100TpTabuladorPeer::TX_TP_TABULADOR);
        $c->addSelectColumn(Tbrh008TabuladorPeer::NU_CODIGO_TAB);
        $c->addSelectColumn(Tbrh008TabuladorPeer::MO_SUELDO);
        $c->addJoin(Tbrh032CargoPeer::CO_TP_TABULADOR, Tbrh100TpTabuladorPeer::CO_TP_TABULADOR);
        $c->addJoin(Tbrh032CargoPeer::CO_TABULADOR, Tbrh008TabuladorPeer::CO_TABULADOR);
        
    $stmt = Tbrh032CargoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_cargo"     => trim($res["co_cargo"]),
            "tx_cargo"     => trim($res["tx_cargo"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "co_tabulador2"     => trim($res["co_tabulador2"]),
            "nu_codigo"     => trim($res["nu_codigo"]),
            "co_tp_tabulador"     => trim($res["tx_tp_tabulador"]),
            "nu_codigo_tab"     => trim($res["nu_codigo_tab"]),
            "mo_sueldo"     => trim($res["mo_sueldo"]),
            "in_compensacion"     => trim($res["in_compensacion"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                                                        
    //modelo fk tbrh100_tp_tabulador.co_tp_tabulador
    public function executeStorefkcotptabulador(sfWebRequest $request){
      $c = new Criteria();
      $stmt = Tbrh100TpTabuladorPeer::doSelectStmt($c);
      $registros = array();
      while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
          $registros[] = $reg;
      }

      $this->data = json_encode(array(
          "success"   =>  true,
          "total"     =>  count($registros),
          "data"      =>  $registros
          ));
      $this->setTemplate('store');
  }

    //modelo fk tbrh100_tp_tabulador.co_tp_tabulador
    public function executeStorefkcotabulador(sfWebRequest $request){
      $c = new Criteria();
      $c->add(Tbrh008TabuladorPeer::CO_TP_TABULADOR, $this->getRequestParameter("tipo"));
      $stmt = Tbrh008TabuladorPeer::doSelectStmt($c);
      $registros = array();
      while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
          $registros[] = $reg;
      }

      $this->data = json_encode(array(
          "success"   =>  true,
          "total"     =>  count($registros),
          "data"      =>  $registros
          ));
      $this->setTemplate('store');
  }

}