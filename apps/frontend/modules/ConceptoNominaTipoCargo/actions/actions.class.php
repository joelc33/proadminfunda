<?php

/**
 * ConceptoNominaTipoCargo actions.
 *
 * @package    gobel
 * @subpackage ConceptoNominaTipoCargo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConceptoNominaTipoCargoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConceptoNominaTipoCargo', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConceptoNominaTipoCargo', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh085ConceptoTipoCargoPeer::CO_CONCEPTO_TIPO_CARGO,$codigo);
        
        $stmt = Tbrh085ConceptoTipoCargoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_concepto_tipo_cargo"     => $campos["co_concepto_tipo_cargo"],
                            "co_concepto"     => $campos["co_concepto"],
                            "co_tp_cargo"     => $campos["co_tp_cargo"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_concepto_tipo_cargo"     => "",
                            "co_concepto"     => $this->getRequestParameter("co_concepto"),
                            "co_tp_cargo"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_concepto_tipo_cargo");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh085_concepto_tipo_cargo = Tbrh085ConceptoTipoCargoPeer::retrieveByPk($codigo);
     }else{
         $tbrh085_concepto_tipo_cargo = new Tbrh085ConceptoTipoCargo();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh085_concepto_tipo_cargoForm = $this->getRequestParameter('tbrh085_concepto_tipo_cargo');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tbrh085_concepto_tipo_cargo->setCoConcepto($tbrh085_concepto_tipo_cargoForm["co_concepto"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh085_concepto_tipo_cargo->setCoTpCargo($tbrh085_concepto_tipo_cargoForm["co_tp_cargo"]);
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tbrh085_concepto_tipo_cargoForm)){
            $tbrh085_concepto_tipo_cargo->setInActivo(false);
        }else{
            $tbrh085_concepto_tipo_cargo->setInActivo(true);
        }*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh085_concepto_tipo_cargoForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh085_concepto_tipo_cargo->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh085_concepto_tipo_cargoForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh085_concepto_tipo_cargo->setUpdatedAt($fecha);*/
                                
        /*CAMPOS*/
        $tbrh085_concepto_tipo_cargo->save($con);
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
	$codigo = $this->getRequestParameter("co_concepto_tipo_cargo");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh085_concepto_tipo_cargo = Tbrh085ConceptoTipoCargoPeer::retrieveByPk($codigo);			
	$tbrh085_concepto_tipo_cargo->delete($con);
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
    $this->data = json_encode(array(
        "co_concepto"     => $this->getRequestParameter("codigo"),
    ));
  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $co_concepto      =   $this->getRequestParameter("co_concepto");
            $co_tp_cargo      =   $this->getRequestParameter("co_tp_cargo");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_concepto!=""){$c->add(Tbrh085ConceptoTipoCargoPeer::co_concepto,$co_concepto);}
    
                                            if($co_tp_cargo!=""){$c->add(Tbrh085ConceptoTipoCargoPeer::co_tp_cargo,$co_tp_cargo);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh085ConceptoTipoCargoPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh085ConceptoTipoCargoPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $c->clearSelectColumns();
    $c->addSelectColumn(Tbrh085ConceptoTipoCargoPeer::CO_CONCEPTO_TIPO_CARGO);
    $c->addSelectColumn(Tbrh084TipoCargoPeer::TX_TIPO_CARGO);
    $c->addJoin(Tbrh085ConceptoTipoCargoPeer::CO_TP_CARGO, Tbrh084TipoCargoPeer::CO_TP_CARGO);
    $c->add(Tbrh085ConceptoTipoCargoPeer::CO_CONCEPTO,$co_concepto);

    $cantidadTotal = Tbrh085ConceptoTipoCargoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh085ConceptoTipoCargoPeer::CO_CONCEPTO_TIPO_CARGO);
        
    $stmt = Tbrh085ConceptoTipoCargoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_concepto_tipo_cargo"     => trim($res["co_concepto_tipo_cargo"]),
            "co_concepto"     => trim($res["co_concepto"]),
            "co_tp_cargo"     => trim($res["co_tp_cargo"]),
            "tx_tipo_cargo"     => trim($res["tx_tipo_cargo"]),
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

                    //modelo fk tbrh014_concepto.CO_CONCEPTO
    public function executeStorefkcoconcepto(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh014ConceptoPeer::doSelectStmt($c);
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
                    //modelo fk tbrh084_tipo_cargo.CO_TP_CARGO
    public function executeStorefkcotpcargo(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh084TipoCargoPeer::doSelectStmt($c);
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