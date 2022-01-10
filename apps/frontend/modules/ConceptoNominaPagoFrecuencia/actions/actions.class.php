<?php

/**
 * ConceptoNominaPagoFrecuencia actions.
 *
 * @package    gobel
 * @subpackage ConceptoNominaPagoFrecuencia
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConceptoNominaPagoFrecuenciaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConceptoNominaPagoFrecuencia', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConceptoNominaPagoFrecuencia', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh051ConcepFrecueciaPeer::CO_CONCEP_FRECUECIA,$codigo);
        
        $stmt = Tbrh051ConcepFrecueciaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_concep_frecuecia"     => $campos["co_concep_frecuecia"],
                            "co_concepto"     => $campos["co_concepto"],
                            "co_nom_frecuencia_pago"     => $campos["co_nom_frecuencia_pago"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_concep_frecuecia"     => "",
                            "co_concepto"     => $this->getRequestParameter("co_concepto"),
                            "co_nom_frecuencia_pago"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_concep_frecuecia");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh051_concep_frecuecia = Tbrh051ConcepFrecueciaPeer::retrieveByPk($codigo);
     }else{
         $tbrh051_concep_frecuecia = new Tbrh051ConcepFrecuecia();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh051_concep_frecueciaForm = $this->getRequestParameter('tbrh051_concep_frecuecia');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tbrh051_concep_frecuecia->setCoConcepto($tbrh051_concep_frecueciaForm["co_concepto"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh051_concep_frecuecia->setCoNomFrecuenciaPago($tbrh051_concep_frecueciaForm["co_nom_frecuencia_pago"]);
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tbrh051_concep_frecueciaForm)){
            $tbrh051_concep_frecuecia->setInActivo(false);
        }else{
            $tbrh051_concep_frecuecia->setInActivo(true);
        }*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh051_concep_frecueciaForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh051_concep_frecuecia->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh051_concep_frecueciaForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh051_concep_frecuecia->setUpdatedAt($fecha);*/
                                
        /*CAMPOS*/
        $tbrh051_concep_frecuecia->save($con);
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
	$codigo = $this->getRequestParameter("co_concep_frecuecia");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh051_concep_frecuecia = Tbrh051ConcepFrecueciaPeer::retrieveByPk($codigo);			
	$tbrh051_concep_frecuecia->delete($con);
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
            $co_nom_frecuencia_pago      =   $this->getRequestParameter("co_nom_frecuencia_pago");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_concepto!=""){$c->add(Tbrh051ConcepFrecueciaPeer::co_concepto,$co_concepto);}
    
                                            if($co_nom_frecuencia_pago!=""){$c->add(Tbrh051ConcepFrecueciaPeer::co_nom_frecuencia_pago,$co_nom_frecuencia_pago);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh051ConcepFrecueciaPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh051ConcepFrecueciaPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    //$cantidadTotal = Tbrh051ConcepFrecueciaPeer::doCount($c);
    
    //$c->setLimit($limit)->setOffset($start);
      //  $c->addAscendingOrderByColumn(Tbrh051ConcepFrecueciaPeer::CO_CONCEP_FRECUECIA);

        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh051ConcepFrecueciaPeer::CO_CONCEP_FRECUECIA);
        $c->addSelectColumn(Tbrh023NomFrecuenciaPagoPeer::TX_NOM_FRECUENCIA_PAGO);

        $c->addJoin(Tbrh051ConcepFrecueciaPeer::CO_NOM_FRECUENCIA_PAGO, Tbrh023NomFrecuenciaPagoPeer::CO_NOM_FRECUENCIA_PAGO);

        $c->add(Tbrh051ConcepFrecueciaPeer::CO_CONCEPTO,$co_concepto);

        $cantidadTotal = Tbrh051ConcepFrecueciaPeer::doCount($c);
        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh051ConcepFrecueciaPeer::CO_CONCEP_FRECUECIA);
        
    $stmt = Tbrh051ConcepFrecueciaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_concep_frecuecia"     => trim($res["co_concep_frecuecia"]),
            "co_concepto"     => trim($res["co_concepto"]),
            "co_nom_frecuencia_pago"     => trim($res["tx_nom_frecuencia_pago"]),
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
                    //modelo fk tbrh023_nom_frecuencia_pago.CO_NOM_FRECUENCIA_PAGO
    public function executeStorefkconomfrecuenciapago(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh023NomFrecuenciaPagoPeer::doSelectStmt($c);
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