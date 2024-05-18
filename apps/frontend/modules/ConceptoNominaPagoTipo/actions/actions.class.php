<?php

/**
 * ConceptoNominaPagoTipo actions.
 *
 * @package    gobel
 * @subpackage ConceptoNominaPagoTipo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConceptoNominaPagoTipoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConceptoNominaPagoTipo', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConceptoNominaPagoTipo', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO_TIPO_NOMINA,$codigo);
        
        $stmt = Tbrh026ConcepTipoNominaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_concepto_tipo_nomina"     => $campos["co_concepto_tipo_nomina"],
                            "co_concepto"     => $campos["co_concepto"],
                            "co_tp_nomina"     => $campos["co_tp_nomina"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "co_grupo_nomina"     => $campos["co_grupo_nomina"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_concepto_tipo_nomina"     => "",
                            "co_concepto"     => $this->getRequestParameter("co_concepto"),
                            "co_tp_nomina"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "co_grupo_nomina"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_concepto_tipo_nomina");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh026_concep_tipo_nomina = Tbrh026ConcepTipoNominaPeer::retrieveByPk($codigo);
     }else{
         $tbrh026_concep_tipo_nomina = new Tbrh026ConcepTipoNomina();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh026_concep_tipo_nominaForm = $this->getRequestParameter('tbrh026_concep_tipo_nomina');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tbrh026_concep_tipo_nomina->setCoConcepto($tbrh026_concep_tipo_nominaForm["co_concepto"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh026_concep_tipo_nomina->setCoTpNomina($tbrh026_concep_tipo_nominaForm["co_tp_nomina"]);

        /*Campo tipo BIGINT */
        $tbrh026_concep_tipo_nomina->setCoGrupoNomina($tbrh026_concep_tipo_nominaForm["co_grupo_nomina"]);
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tbrh026_concep_tipo_nominaForm)){
            $tbrh026_concep_tipo_nomina->setInActivo(false);
        }else{
            $tbrh026_concep_tipo_nomina->setInActivo(true);
        }*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh026_concep_tipo_nominaForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh026_concep_tipo_nomina->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh026_concep_tipo_nominaForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh026_concep_tipo_nomina->setUpdatedAt($fecha);*/
                                
        /*CAMPOS*/
        $tbrh026_concep_tipo_nomina->save($con);
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
	$codigo = $this->getRequestParameter("co_concepto_tipo_nomina");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh026_concep_tipo_nomina = Tbrh026ConcepTipoNominaPeer::retrieveByPk($codigo);			
	$tbrh026_concep_tipo_nomina->delete($con);
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
        "co_concepto_tipo_nomina"     => "",
        "co_concepto"     => $this->getRequestParameter("codigo"),
        "co_tp_nomina"     => "",
        "in_activo"     => "",
        "created_at"     => "",
        "updated_at"     => "",
    ));
  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $co_concepto      =   $this->getRequestParameter("co_concepto");
            $co_tp_nomina      =   $this->getRequestParameter("co_tp_nomina");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    //if($co_concepto!=""){$c->add(Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO,$co_concepto);}
    
                                            if($co_tp_nomina!=""){$c->add(Tbrh026ConcepTipoNominaPeer::co_tp_nomina,$co_tp_nomina);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh026ConcepTipoNominaPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh026ConcepTipoNominaPeer::updated_at,$fecha);
    }
                    }
                    
    $c->setIgnoreCase(true);
    //$cantidadTotal = Tbrh026ConcepTipoNominaPeer::doCount($c);
    
    //$c->setLimit($limit)->setOffset($start);
        //$c->addAscendingOrderByColumn(Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO_TIPO_NOMINA);

        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO_TIPO_NOMINA);
        $c->addSelectColumn(Tbrh017TpNominaPeer::CO_TP_NOMINA);
        $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
        $c->addSelectColumn(Tbrh017TpNominaPeer::NU_NOMINA);
        $c->addSelectColumn(Tbrh067GrupoNominaPeer::COD_GRUPO_NOMINA);

        $c->addJoin(Tbrh026ConcepTipoNominaPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
        $c->addJoin(Tbrh026ConcepTipoNominaPeer::CO_GRUPO_NOMINA, Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);

        $c->add(Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO,$co_concepto);

        $cantidadTotal = Tbrh026ConcepTipoNominaPeer::doCount($c);

        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO_TIPO_NOMINA);
        
    $stmt = Tbrh026ConcepTipoNominaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_concepto_tipo_nomina"     => trim($res["co_concepto_tipo_nomina"]),
            "co_concepto"     => trim($res["co_concepto"]),
            "nu_nomina"     => trim($res["nu_nomina"]),
            "co_tp_nomina"     => trim($res["co_tp_nomina"]),
            "tx_tp_nomina"     => trim($res["tx_tp_nomina"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "cod_grupo_nomina"     => trim($res["cod_grupo_nomina"]),
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
                    //modelo fk tbrh017_tp_nomina.CO_TP_NOMINA
    public function executeStorefkcotpnomina(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh017TpNominaPeer::doSelectStmt($c);
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
                                            
    //modelo fk tbrh017_tp_nomina.CO_TP_NOMINA
    public function executeStorefkcogruponomina(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tbrh067GrupoNominaPeer::CO_TP_NOMINA, $this->getRequestParameter("tipo"));
        $stmt = Tbrh067GrupoNominaPeer::doSelectStmt($c);
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