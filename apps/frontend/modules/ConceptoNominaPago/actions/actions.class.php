<?php

/**
 * ConceptoNominaPago actions.
 *
 * @package    gobel
 * @subpackage ConceptoNominaPago
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConceptoNominaPagoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConceptoNominaPago', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConceptoNominaPago', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh014ConceptoPeer::CO_CONCEPTO,$codigo);
        
        $stmt = Tbrh014ConceptoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_concepto"     => $campos["co_concepto"],
                            "nu_concepto"     => $campos["nu_concepto"],
                            "tx_concepto"     => $campos["tx_concepto"],
                            "co_tipo_concepto"     => $campos["co_tipo_concepto"],
                            "co_tipo_unidad"     => $campos["co_tipo_unidad"],
                            "nu_cuenta_contable"     => $campos["nu_cuenta_contable"],
                            "nu_cuenta_presupuesto"     => $campos["nu_cuenta_presupuesto"],
                            "nu_valor"     => $campos["nu_valor"],
                            "in_imprime_detalle"     => $campos["in_imprime_detalle"],
                            "in_descripcion_alternativa"     => $campos["in_descripcion_alternativa"],
                            "in_valor_referencia"     => $campos["in_valor_referencia"],
                            "in_hoja_tiempo"     => $campos["in_hoja_tiempo"],
                            "in_prorratea"     => $campos["in_prorratea"],
                            "in_modifica_descripcion"     => $campos["in_modifica_descripcion"],
                            "in_monto_calculo"     => $campos["in_monto_calculo"],
                            "in_contractual"     => $campos["in_contractual"],
                            "in_bonificable"     => $campos["in_bonificable"],
                            "in_monto_cero"     => $campos["in_monto_cero"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            //"de_formula"     => trim(preg_replace("/[\n|\r|\n\r|\"]/i",'',$campos["de_formula"])),
                            "co_moneda"     => $campos["co_moneda"],
                            "nu_prioridad"     => $campos["nu_prioridad"],
                            "de_observacion"     => $campos["de_observacion"],
                            "co_modo_concepto"     => $campos["co_modo_concepto"],
                    ));

        $this->de_formula = trim(preg_replace("/[\n|\r|\n\r|\"]/i",'',$campos["de_formula"]));

    }else{
        $this->data = json_encode(array(
                            "co_concepto"     => "",
                            "nu_concepto"     => "",
                            "tx_concepto"     => "",
                            "co_tipo_concepto"     => "",
                            "co_tipo_unidad"     => "",
                            "nu_cuenta_contable"     => "",
                            "nu_cuenta_presupuesto"     => "",
                            "nu_valor"     => "",
                            "in_imprime_detalle"     => "",
                            "in_descripcion_alternativa"     => "",
                            "in_valor_referencia"     => "",
                            "in_hoja_tiempo"     => "",
                            "in_prorratea"     => "",
                            "in_modifica_descripcion"     => "",
                            "in_monto_calculo"     => "",
                            "in_contractual"     => "",
                            "in_bonificable"     => "",
                            "in_monto_cero"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "de_formula"     => "",
                            "co_moneda"     => "",
                            "de_observacion"     => "",
                            "nu_prioridad"     => "",
                            "co_modo_concepto"     => "",
                    ));
    }

  }

  public function executeDuplicar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh014ConceptoPeer::CO_CONCEPTO,$codigo);
        
        $stmt = Tbrh014ConceptoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_concepto"     => $campos["co_concepto"],
                            "nu_concepto"     => $campos["nu_concepto"],
                            "tx_concepto"     => $campos["tx_concepto"],
                    ));

    }else{
        $this->data = json_encode(array(
                            "co_concepto"     => "",
                            "nu_concepto"     => "",
                            "tx_concepto"     => "",
                            "co_tipo_concepto"     => "",
                            "co_tipo_unidad"     => "",
                            "nu_cuenta_contable"     => "",
                            "nu_cuenta_presupuesto"     => "",
                            "nu_valor"     => "",
                            "in_imprime_detalle"     => "",
                            "in_descripcion_alternativa"     => "",
                            "in_valor_referencia"     => "",
                            "in_hoja_tiempo"     => "",
                            "in_prorratea"     => "",
                            "in_modifica_descripcion"     => "",
                            "in_monto_calculo"     => "",
                            "in_contractual"     => "",
                            "in_bonificable"     => "",
                            "in_monto_cero"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "de_formula"     => "",
                            "co_moneda"     => "",
                            "nu_prioridad"     => "",
                            "co_modo_concepto"     => "",
                    ));
    }

  }

  public function executeOtros(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh014ConceptoPeer::CO_CONCEPTO,$codigo);
        
        $stmt = Tbrh014ConceptoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_concepto"     => $campos["co_concepto"],
                            "nu_concepto"     => $campos["nu_concepto"],
                            "tx_concepto"     => $campos["tx_concepto"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_concepto"     => "",
                            "nu_concepto"     => "",
                            "tx_concepto"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_concepto");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh014_concepto = Tbrh014ConceptoPeer::retrieveByPk($codigo);
     }else{
         $tbrh014_concepto = new Tbrh014Concepto();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh014_conceptoForm = $this->getRequestParameter('tbrh014_concepto');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tbrh014_concepto->setNuConcepto($tbrh014_conceptoForm["nu_concepto"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh014_concepto->setTxConcepto($tbrh014_conceptoForm["tx_concepto"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh014_concepto->setCoTipoConcepto($tbrh014_conceptoForm["co_tipo_concepto"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh014_concepto->setCoTipoUnidad($tbrh014_conceptoForm["co_tipo_unidad"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh014_concepto->setNuCuentaContable($tbrh014_conceptoForm["nu_cuenta_contable"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh014_concepto->setNuCuentaPresupuesto($tbrh014_conceptoForm["nu_cuenta_presupuesto"]);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh014_concepto->setNuValor($tbrh014_conceptoForm["nu_valor"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_imprime_detalle", $tbrh014_conceptoForm)){
            $tbrh014_concepto->setInImprimeDetalle(true);
        }else{
            $tbrh014_concepto->setInImprimeDetalle(false);
        }
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_descripcion_alternativa", $tbrh014_conceptoForm)){
            $tbrh014_concepto->setInDescripcionAlternativa(true);
        }else{
            $tbrh014_concepto->setInDescripcionAlternativa(false);
        }
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_valor_referencia", $tbrh014_conceptoForm)){
            $tbrh014_concepto->setInValorReferencia(true);
        }else{
            $tbrh014_concepto->setInValorReferencia(false);
        }
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_hoja_tiempo", $tbrh014_conceptoForm)){
            $tbrh014_concepto->setInHojaTiempo(true);
        }else{
            $tbrh014_concepto->setInHojaTiempo(false);
        }
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_prorratea", $tbrh014_conceptoForm)){
            $tbrh014_concepto->setInProrratea(true);
        }else{
            $tbrh014_concepto->setInProrratea(false);
        }
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_modifica_descripcion", $tbrh014_conceptoForm)){
            $tbrh014_concepto->setInModificaDescripcion(true);
        }else{
            $tbrh014_concepto->setInModificaDescripcion(false);
        }
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_monto_calculo", $tbrh014_conceptoForm)){
            $tbrh014_concepto->setInMontoCalculo(true);
        }else{
            $tbrh014_concepto->setInMontoCalculo(false);
        }
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_contractual", $tbrh014_conceptoForm)){
            $tbrh014_concepto->setInContractual(true);
        }else{
            $tbrh014_concepto->setInContractual(false);
        }
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_bonificable", $tbrh014_conceptoForm)){
            $tbrh014_concepto->setInBonificable(true);
        }else{
            $tbrh014_concepto->setInBonificable(false);
        }
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_monto_cero", $tbrh014_conceptoForm)){
            $tbrh014_concepto->setInMontoCero(true);
        }else{
            $tbrh014_concepto->setInMontoCero(false);
        }
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tbrh014_conceptoForm)){
            $tbrh014_concepto->setInActivo(false);
        }else{
            $tbrh014_concepto->setInActivo(true);
        }*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh014_conceptoForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh014_concepto->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh014_conceptoForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh014_concepto->setUpdatedAt($fecha);*/
                                                        
        /*Campo tipo VARCHAR */
        $tbrh014_concepto->setDeFormula($tbrh014_conceptoForm["de_formula"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh014_concepto->setCoMoneda($tbrh014_conceptoForm["co_moneda"]);

        /*Campo tipo BIGINT */
        $tbrh014_concepto->setDeObservacion($tbrh014_conceptoForm["de_observacion"]);

        /*Campo tipo BIGINT */
        $tbrh014_concepto->setNuPrioridad($tbrh014_conceptoForm["nu_prioridad"]);

        /*Campo tipo BIGINT */
        $tbrh014_concepto->setCoModoConcepto($tbrh014_conceptoForm["co_modo_concepto"]);
                                
        /*CAMPOS*/
        $tbrh014_concepto->save($con);
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
  
    public function executeGuardarDuplicar(sfWebRequest $request)
    {
  
        $codigo = $this->getRequestParameter("co_concepto");

        $c = new Criteria();
        $c->add(Tbrh014ConceptoPeer::CO_CONCEPTO,$codigo);
        $stmt = Tbrh014ConceptoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
          
        $con = Propel::getConnection();
        $tbrh014_concepto = new Tbrh014Concepto();

       try
        { 
          $con->beginTransaction();
         
          $tbrh014_conceptoForm = $this->getRequestParameter('tbrh014_concepto');
            /*CAMPOS*/
                                          
        /*Campo tipo VARCHAR */
        $tbrh014_concepto->setNuConcepto($tbrh014_conceptoForm["nu_concepto"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh014_concepto->setTxConcepto($tbrh014_conceptoForm["tx_concepto"]);
                                                          
          /*Campo tipo BIGINT */
          $tbrh014_concepto->setCoTipoConcepto($campos["co_tipo_concepto"]);
                                                          
          /*Campo tipo BIGINT */
          $tbrh014_concepto->setCoTipoUnidad($campos["co_tipo_unidad"]);
                                                          
          /*Campo tipo VARCHAR */
          $tbrh014_concepto->setNuCuentaContable($campos["nu_cuenta_contable"]);
                                                          
          /*Campo tipo VARCHAR */
          $tbrh014_concepto->setNuCuentaPresupuesto($campos["nu_cuenta_presupuesto"]);
                                                          
          /*Campo tipo NUMERIC */
          $tbrh014_concepto->setNuValor($campos["nu_valor"]);
                                                          
          /*Campo tipo BOOLEAN */
          $tbrh014_concepto->setInImprimeDetalle($campos["in_imprime_detalle"]);
                                                          
          /*Campo tipo BOOLEAN */
          $tbrh014_concepto->setInDescripcionAlternativa($campos["in_descripcion_alternativa"]);
                                                          
          /*Campo tipo BOOLEAN */
          $tbrh014_concepto->setInValorReferencia($campos["in_valor_referencia"]);
                                                          
          /*Campo tipo BOOLEAN */
          $tbrh014_concepto->setInHojaTiempo($campos["in_hoja_tiempo"]);
                                                          
          /*Campo tipo BOOLEAN */
          $tbrh014_concepto->setInProrratea($campos["in_prorratea"]);
                                                          
          /*Campo tipo BOOLEAN */
          $tbrh014_concepto->setInModificaDescripcion($campos["in_modifica_descripcion"]);
                                                          
          /*Campo tipo BOOLEAN */
          $tbrh014_concepto->setInMontoCalculo($campos["in_monto_calculo"]);
                                                          
          /*Campo tipo BOOLEAN */
          $tbrh014_concepto->setInContractual($campos["in_contractual"]);
                                                          
          /*Campo tipo BOOLEAN */
          $tbrh014_concepto->setInBonificable($campos["in_bonificable"]);
                                                          
          /*Campo tipo BOOLEAN */
          $tbrh014_concepto->setInMontoCero($campos["in_monto_cero"]);
                                                          
          /*Campo tipo VARCHAR */
          $tbrh014_concepto->setDeFormula($campos["de_formula"]);
                                                          
          /*Campo tipo BIGINT */
          $tbrh014_concepto->setCoMoneda($campos["co_moneda"]);

          /*Campo tipo BIGINT */
          $tbrh014_concepto->setDeObservacion($campos["de_observacion"]);

          /*Campo tipo BIGINT */
          $tbrh014_concepto->setNuPrioridad($campos["nu_prioridad"]);

          /*Campo tipo BIGINT */
          $tbrh014_concepto->setCoModoConcepto($campos["co_modo_concepto"]);
                                  
          /*CAMPOS*/
          $tbrh014_concepto->save($con);
          $this->data = json_encode(array(
                      "success" => true,
                      "msg" => 'Concepto duplicado Exitosamente!'
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
	$codigo = $this->getRequestParameter("co_concepto");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh014_concepto = Tbrh014ConceptoPeer::retrieveByPk($codigo);			
	$tbrh014_concepto->delete($con);
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
                $nu_concepto      =   $this->getRequestParameter("nu_concepto");
            $tx_concepto      =   $this->getRequestParameter("tx_concepto");
            $co_tipo_concepto      =   $this->getRequestParameter("co_tipo_concepto");
            $co_tipo_unidad      =   $this->getRequestParameter("co_tipo_unidad");
            $nu_cuenta_contable      =   $this->getRequestParameter("nu_cuenta_contable");
            $nu_cuenta_presupuesto      =   $this->getRequestParameter("nu_cuenta_presupuesto");
            $nu_valor      =   $this->getRequestParameter("nu_valor");
            $in_imprime_detalle      =   $this->getRequestParameter("in_imprime_detalle");
            $in_descripcion_alternativa      =   $this->getRequestParameter("in_descripcion_alternativa");
            $in_valor_referencia      =   $this->getRequestParameter("in_valor_referencia");
            $in_hoja_tiempo      =   $this->getRequestParameter("in_hoja_tiempo");
            $in_prorratea      =   $this->getRequestParameter("in_prorratea");
            $in_modifica_descripcion      =   $this->getRequestParameter("in_modifica_descripcion");
            $in_monto_calculo      =   $this->getRequestParameter("in_monto_calculo");
            $in_contractual      =   $this->getRequestParameter("in_contractual");
            $in_bonificable      =   $this->getRequestParameter("in_bonificable");
            $in_monto_cero      =   $this->getRequestParameter("in_monto_cero");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $de_formula      =   $this->getRequestParameter("de_formula");
            $co_moneda      =   $this->getRequestParameter("co_moneda");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($nu_concepto!=""){$c->add(Tbrh014ConceptoPeer::NU_CONCEPTO,'%'.$nu_concepto.'%',Criteria::LIKE);}
        
                                        if($tx_concepto!=""){$c->add(Tbrh014ConceptoPeer::TX_CONCEPTO,'%'.$tx_concepto.'%',Criteria::LIKE);}
        
                                            if($co_tipo_concepto!=""){$c->add(Tbrh014ConceptoPeer::CO_TIPO_CONCEPTO,$co_tipo_concepto);}
    
                                            if($co_tipo_unidad!=""){$c->add(Tbrh014ConceptoPeer::CO_TIPO_UNIDAD,$co_tipo_unidad);}
    
                                        if($nu_cuenta_contable!=""){$c->add(Tbrh014ConceptoPeer::nu_cuenta_contable,'%'.$nu_cuenta_contable.'%',Criteria::LIKE);}
        
                                        if($nu_cuenta_presupuesto!=""){$c->add(Tbrh014ConceptoPeer::nu_cuenta_presupuesto,'%'.$nu_cuenta_presupuesto.'%',Criteria::LIKE);}
        
                                            if($nu_valor!=""){$c->add(Tbrh014ConceptoPeer::nu_valor,$nu_valor);}
    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh014ConceptoPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh014ConceptoPeer::updated_at,$fecha);
    }
                                        if($de_formula!=""){$c->add(Tbrh014ConceptoPeer::de_formula,'%'.$de_formula.'%',Criteria::LIKE);}
        
                                            if($co_moneda!=""){$c->add(Tbrh014ConceptoPeer::co_moneda,$co_moneda);}
    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh014ConceptoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);

        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
        $c->addSelectColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
        $c->addSelectColumn(Tbrh014ConceptoPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tbrh014ConceptoPeer::IN_ACTIVO);
        $c->addSelectColumn(Tbrh014ConceptoPeer::NU_CUENTA_PRESUPUESTO);
        $c->addSelectColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
        $c->addSelectColumn(Tbrh014ConceptoPeer::DE_OBSERVACION);

        $c->addJoin(Tbrh014ConceptoPeer::CO_TIPO_CONCEPTO, Tbrh020TpConceptoPeer::CO_TP_CONCEPTO, Criteria::LEFT_JOIN);
        
    $stmt = Tbrh014ConceptoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_concepto"     => trim($res["co_concepto"]),
            "nu_concepto"     => trim($res["nu_concepto"]),
            "tx_concepto"     => trim($res["tx_concepto"]),
            "co_tipo_concepto"     => trim($res["co_tipo_concepto"]),
            "co_tipo_unidad"     => trim($res["co_tipo_unidad"]),
            "nu_cuenta_contable"     => trim($res["nu_cuenta_contable"]),
            "nu_cuenta_presupuesto"     => trim($res["nu_cuenta_presupuesto"]),
            "nu_valor"     => trim($res["nu_valor"]),
            "in_imprime_detalle"     => trim($res["in_imprime_detalle"]),
            "in_descripcion_alternativa"     => trim($res["in_descripcion_alternativa"]),
            "in_valor_referencia"     => trim($res["in_valor_referencia"]),
            "in_hoja_tiempo"     => trim($res["in_hoja_tiempo"]),
            "in_prorratea"     => trim($res["in_prorratea"]),
            "in_modifica_descripcion"     => trim($res["in_modifica_descripcion"]),
            "in_monto_calculo"     => trim($res["in_monto_calculo"]),
            "in_contractual"     => trim($res["in_contractual"]),
            "in_bonificable"     => trim($res["in_bonificable"]),
            "in_monto_cero"     => trim($res["in_monto_cero"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "de_formula"     => trim($res["de_formula"]),
            "co_moneda"     => trim($res["co_moneda"]),
            "tx_tp_concepto"     => trim($res["tx_tp_concepto"]),
            "de_observacion"     => trim($res["de_observacion"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                            //modelo fk tbrh020_tp_concepto.CO_TP_CONCEPTO
    public function executeStorefkcotipoconcepto(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh020TpConceptoPeer::doSelectStmt($c);
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
                    //modelo fk tbrh050_tp_unidad.CO_TP_UNIDAD
    public function executeStorefkcotipounidad(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh050TpUnidadPeer::doSelectStmt($c);
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
                                                                                                                                                                                                                                //modelo fk tbrh030_moneda.CO_MONEDA
    public function executeStorefkcomoneda(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh030MonedaPeer::doSelectStmt($c);
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
        
    public function executeTodo(sfWebRequest $request)
    {
  
    }

    //modelo fk tbrh092_modo_concepto.CO_MODO_CONCEPTO
    public function executeStorefkcomodoconcepto(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh092ModoConceptoPeer::doSelectStmt($c);
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

    //modelo fk tbrh092_modo_concepto.CO_MODO_CONCEPTO
    public function executeStorenuprioridad(sfWebRequest $request){

        $con = Propel::getConnection();

        $registros = '';
        $sql = "SELECT * FROM generate_series(1,99) as nu_prioridad;";
        $stmt = $con->prepare($sql);
        $stmt->execute();
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