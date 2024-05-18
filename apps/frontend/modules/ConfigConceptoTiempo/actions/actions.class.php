<?php

/**
 * ConfigConceptoTiempo actions.
 *
 * @package    gobel
 * @subpackage ConfigConceptoTiempo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConfigConceptoTiempoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConfigConceptoTiempo', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConfigConceptoTiempo', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh098ConceptoTiempoPeer::CO_CONCEPTO_TIEMPO,$codigo);
        
        $stmt = Tbrh098ConceptoTiempoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_concepto_tiempo"     => $campos["co_concepto_tiempo"],
                            "co_tp_nomina"     => $campos["co_tp_nomina"],
                            "co_grupo_nomina"     => $campos["co_grupo_nomina"],
                            "nu_mes_ini"     => $campos["nu_mes_ini"],
                            "nu_mes_fin"     => $campos["nu_mes_fin"],
                            "nu_concepto"     => $campos["nu_concepto"],
                            "co_concepto"     => $campos["co_concepto"],
                            "nu_valor"     => $campos["nu_valor"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_concepto_tiempo"     => "",
                            "co_tp_nomina"     => "",
                            "co_grupo_nomina"     => "",
                            "nu_mes_ini"     => "",
                            "nu_concepto"     => "",
                            "co_concepto"     => "",
                            "nu_valor"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_concepto_tiempo");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh098_concepto_tiempo = Tbrh098ConceptoTiempoPeer::retrieveByPk($codigo);
     }else{
         $tbrh098_concepto_tiempo = new Tbrh098ConceptoTiempo();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh098_concepto_tiempoForm = $this->getRequestParameter('tbrh098_concepto_tiempo');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tbrh098_concepto_tiempo->setCoTpNomina($tbrh098_concepto_tiempoForm["co_tp_nomina"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh098_concepto_tiempo->setCoGrupoNomina($tbrh098_concepto_tiempoForm["co_grupo_nomina"]);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh098_concepto_tiempo->setNuMesIni($tbrh098_concepto_tiempoForm["nu_mes_ini"]);

        /*Campo tipo NUMERIC */
        $tbrh098_concepto_tiempo->setNuMesFin($tbrh098_concepto_tiempoForm["nu_mes_fin"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh098_concepto_tiempo->setNuConcepto($tbrh098_concepto_tiempoForm["nu_concepto"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh098_concepto_tiempo->setCoConcepto($tbrh098_concepto_tiempoForm["co_concepto"]);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh098_concepto_tiempo->setNuValor($tbrh098_concepto_tiempoForm["nu_valor"]);
                                
        /*CAMPOS*/
        $tbrh098_concepto_tiempo->save($con);
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
	$codigo = $this->getRequestParameter("co_concepto_tiempo");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh098_concepto_tiempo = Tbrh098ConceptoTiempoPeer::retrieveByPk($codigo);			
	$tbrh098_concepto_tiempo->delete($con);
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
                $co_tp_nomina      =   $this->getRequestParameter("co_tp_nomina");
            $co_grupo_nomina      =   $this->getRequestParameter("co_grupo_nomina");
            $nu_mes_ini      =   $this->getRequestParameter("nu_mes_ini");
            $nu_concepto      =   $this->getRequestParameter("nu_concepto");
            $co_concepto      =   $this->getRequestParameter("co_concepto");
            $nu_valor      =   $this->getRequestParameter("nu_valor");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_tp_nomina!=""){$c->add(Tbrh098ConceptoTiempoPeer::CO_TP_NOMINA,$co_tp_nomina);}
    
                                            if($co_grupo_nomina!=""){$c->add(Tbrh098ConceptoTiempoPeer::CO_GRUPO_NOMINA,$co_grupo_nomina);}
    
                                            if($nu_mes_ini!=""){$c->add(Tbrh098ConceptoTiempoPeer::NU_MES_INI,$nu_mes_ini);}
    
                                        if($nu_concepto!=""){$c->add(Tbrh098ConceptoTiempoPeer::NU_CONCEPTO,'%'.$nu_concepto.'%',Criteria::LIKE);}
        
                                            if($co_concepto!=""){$c->add(Tbrh098ConceptoTiempoPeer::CO_CONCEPTO,$co_concepto);}
    
                                            if($nu_valor!=""){$c->add(Tbrh098ConceptoTiempoPeer::NU_VALOR,$nu_valor);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh098ConceptoTiempoPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh098ConceptoTiempoPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $c->clearSelectColumns();
    $c->addSelectColumn(Tbrh098ConceptoTiempoPeer::CO_CONCEPTO_TIEMPO);
    $c->addSelectColumn(Tbrh098ConceptoTiempoPeer::NU_MES_INI);
    $c->addSelectColumn(Tbrh098ConceptoTiempoPeer::NU_MES_FIN);
    $c->addSelectColumn(Tbrh098ConceptoTiempoPeer::NU_VALOR);
    $c->addSelectColumn(Tbrh017TpNominaPeer::NU_NOMINA);
    $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
    $c->addSelectColumn(Tbrh067GrupoNominaPeer::COD_GRUPO_NOMINA);
    $c->addSelectColumn(Tbrh067GrupoNominaPeer::TX_GRUPO_NOMINA);
    $c->addSelectColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
    $c->addSelectColumn(Tbrh014ConceptoPeer::TX_CONCEPTO);

    $c->addJoin(Tbrh098ConceptoTiempoPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
    $c->addJoin(Tbrh098ConceptoTiempoPeer::CO_GRUPO_NOMINA, Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);
    $c->addJoin(Tbrh098ConceptoTiempoPeer::CO_CONCEPTO, Tbrh014ConceptoPeer::CO_CONCEPTO);

    $cantidadTotal = Tbrh098ConceptoTiempoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh098ConceptoTiempoPeer::CO_CONCEPTO_TIEMPO);
        
    $stmt = Tbrh098ConceptoTiempoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_concepto_tiempo"     => trim($res["co_concepto_tiempo"]),
            "co_tp_nomina"     => trim($res["co_tp_nomina"]),
            "co_grupo_nomina"     => trim($res["co_grupo_nomina"]),
            "nu_mes_ini"     => trim($res["nu_mes_ini"]),
            "nu_mes_fin"     => trim($res["nu_mes_fin"]),
            //"nu_concepto"     => trim($res["nu_concepto"]),
            "co_concepto"     => trim($res["co_concepto"]),
            "nu_valor"     => trim($res["nu_valor"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "cod_grupo_nomina"     => trim($res["cod_grupo_nomina"]),
            "nu_concepto"     => trim($res["nu_concepto"]),
            "tx_concepto"     => trim($res["tx_concepto"]),
            "nu_nomina"     => trim($res["nu_nomina"]),
            "tx_tp_nomina"     => trim($res["tx_tp_nomina"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
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
                    //modelo fk tbrh067_grupo_nomina.CO_GRUPO_NOMINA
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
                                            //modelo fk tbrh014_concepto.CO_CONCEPTO
    public function executeStorefkcoconcepto(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tbrh014ConceptoPeer::IN_HOJA_TIEMPO, true);
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
                                                        


}