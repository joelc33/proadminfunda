<?php

/**
 * NominaPeriodo actions.
 *
 * @package    gobel
 * @subpackage NominaPeriodo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class NominaPeriodoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('NominaPeriodo', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('NominaPeriodo', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh013NominaPeer::CO_NOMINA,$codigo);
        
        $stmt = Tbrh013NominaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_nomina"     => $campos["co_nomina"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_tp_nomina"     => $campos["co_tp_nomina"],
                            "co_nom_frecuencia_pago"     => $campos["co_nom_frecuencia_pago"],
                            "nu_nomina"     => $campos["nu_nomina"],
                            "de_nomina"     => $campos["de_nomina"],
                            "de_observacion"     => $campos["de_observacion"],
                            "fe_inicio"     => $campos["fe_inicio"],
                            "fe_fin"     => $campos["fe_fin"],
                            "fe_pago"     => $campos["fe_pago"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "in_procesado"     => $campos["in_procesado"],
                            "id_tbrh060_nomina_estatus"     => $campos["id_tbrh060_nomina_estatus"],
                            "co_grupo_nomina"     => $campos["co_grupo_nomina"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_nomina"     => "",
                            "co_solicitud"     => $this->getRequestParameter("co_solicitud"),
                            "co_tp_nomina"     => "",
                            "co_nom_frecuencia_pago"     => "",
                            "nu_nomina"     => "",
                            "de_nomina"     => "",
                            "de_observacion"     => "",
                            "fe_inicio"     => "",
                            "fe_fin"     => "",
                            "fe_pago"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "in_procesado"     => "",
                            "id_tbrh060_nomina_estatus"     => "",
                            "co_grupo_nomina"     => "",
                    ));
    }

  }

  public function executeCalculo(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh013NominaPeer::CO_NOMINA,$codigo);
        
        $stmt = Tbrh013NominaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_nomina"     => $campos["co_nomina"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_tp_nomina"     => $campos["co_tp_nomina"],
                            "co_nom_frecuencia_pago"     => $campos["co_nom_frecuencia_pago"],
                            "nu_nomina"     => $campos["nu_nomina"],
                            "de_nomina"     => $campos["de_nomina"],
                            "de_observacion"     => $campos["de_observacion"],
                            "fe_inicio"     => $campos["fe_inicio"],
                            "fe_fin"     => $campos["fe_fin"],
                            "fe_pago"     => $campos["fe_pago"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "in_procesado"     => $campos["in_procesado"],
                            "id_tbrh060_nomina_estatus"     => $campos["id_tbrh060_nomina_estatus"],
                            "co_grupo_nomina"     => $campos["co_grupo_nomina"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_nomina"     => "",
                            "co_solicitud"     => $this->getRequestParameter("co_solicitud"),
                            "co_tp_nomina"     => "",
                            "co_nom_frecuencia_pago"     => "",
                            "nu_nomina"     => "",
                            "de_nomina"     => "",
                            "de_observacion"     => "",
                            "fe_inicio"     => "",
                            "fe_fin"     => "",
                            "fe_pago"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "in_procesado"     => "",
                            "id_tbrh060_nomina_estatus"     => "",
                            "co_grupo_nomina"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_nomina");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh013_nomina = Tbrh013NominaPeer::retrieveByPk($codigo);
     }else{
         $tbrh013_nomina = new Tbrh013Nomina();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh013_nominaForm = $this->getRequestParameter('tbrh013_nomina');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tbrh013_nomina->setCoSolicitud($tbrh013_nominaForm["co_solicitud"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh013_nomina->setCoTpNomina($tbrh013_nominaForm["co_tp_nomina"]);

        /*Campo tipo BIGINT */
        $tbrh013_nomina->setCoGrupoNomina($tbrh013_nominaForm["co_grupo_nomina"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh013_nomina->setCoNomFrecuenciaPago($tbrh013_nominaForm["co_nom_frecuencia_pago"]);
                                                        
        /*Campo tipo VARCHAR */
        //$tbrh013_nomina->setNuNomina($tbrh013_nominaForm["nu_nomina"]);
                                                        
        /*Campo tipo VARCHAR */
        //$tbrh013_nomina->setDeNomina($tbrh013_nominaForm["de_nomina"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh013_nomina->setDeObservacion($tbrh013_nominaForm["de_observacion"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tbrh013_nominaForm["fe_inicio"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh013_nomina->setFeInicio($fecha);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tbrh013_nominaForm["fe_fin"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh013_nomina->setFeFin($fecha);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tbrh013_nominaForm["fe_pago"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh013_nomina->setFePago($fecha);
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tbrh013_nominaForm)){
            $tbrh013_nomina->setInActivo(false);
        }else{
            $tbrh013_nomina->setInActivo(true);
        }*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh013_nominaForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh013_nomina->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh013_nominaForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh013_nomina->setUpdatedAt($fecha);*/
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_procesado", $tbrh013_nominaForm)){
            $tbrh013_nomina->setInProcesado(false);
        }else{
            $tbrh013_nomina->setInProcesado(true);
        }*/

        $tbrh013_nomina->setInProcesado(false);

        /*Campo tipo BIGINT */
        $tbrh013_nomina->setIdTbrh060NominaEstatus(1);
                                
        /*CAMPOS*/
        $tbrh013_nomina->save($con);

        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tbrh013_nominaForm["co_solicitud"]));
        $ruta->setInCargarDato(true)->save($con);

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
	$codigo = $this->getRequestParameter("co_nomina");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
    $tbrh013_nomina = Tbrh013NominaPeer::retrieveByPk($codigo);
    $tbrh013_nomina->setInActivo(false);	
    $tbrh013_nomina->save($con);		
	//$tbrh013_nomina->delete($con);
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
        "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
        "co_tipo_solicitud"       => $this->getRequestParameter("co_tipo_solicitud"),
        "co_proceso"       => $this->getRequestParameter("co_proceso"),
    ));
  }

  public function executeListaCalculo(sfWebRequest $request)
  {
    $this->data = json_encode(array(
        "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
        "co_tipo_solicitud"       => $this->getRequestParameter("co_tipo_solicitud"),
        "co_proceso"       => $this->getRequestParameter("co_proceso"),
    ));
  }

  public function executeCerrarLista(sfWebRequest $request)
  {
    $this->data = json_encode(array(
        "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
        "co_tipo_solicitud"       => $this->getRequestParameter("co_tipo_solicitud"),
        "co_proceso"       => $this->getRequestParameter("co_proceso"),
    ));
  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $co_solicitud      =   $this->getRequestParameter("co_solicitud");
            $co_tp_nomina      =   $this->getRequestParameter("co_tp_nomina");
            $co_nom_frecuencia_pago      =   $this->getRequestParameter("co_nom_frecuencia_pago");
            $nu_nomina      =   $this->getRequestParameter("nu_nomina");
            $de_nomina      =   $this->getRequestParameter("de_nomina");
            $de_observacion      =   $this->getRequestParameter("de_observacion");
            $fe_inicio      =   $this->getRequestParameter("fe_inicio");
            $fe_fin      =   $this->getRequestParameter("fe_fin");
            $fe_pago      =   $this->getRequestParameter("fe_pago");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $in_procesado      =   $this->getRequestParameter("in_procesado");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_solicitud!=""){$c->add(Tbrh013NominaPeer::CO_SOLICITUD,$co_solicitud);}
    
                                            if($co_tp_nomina!=""){$c->add(Tbrh013NominaPeer::CO_TP_NOMINA,$co_tp_nomina);}
    
                                            if($co_nom_frecuencia_pago!=""){$c->add(Tbrh013NominaPeer::CO_NOM_FRECUENCIA_PAGO,$co_nom_frecuencia_pago);}
    
                                        if($nu_nomina!=""){$c->add(Tbrh013NominaPeer::NU_NOMINA,'%'.$nu_nomina.'%',Criteria::LIKE);}
        
                                        if($de_nomina!=""){$c->add(Tbrh013NominaPeer::DE_NOMINA,'%'.$de_nomina.'%',Criteria::LIKE);}
        
                                        if($de_observacion!=""){$c->add(Tbrh013NominaPeer::DE_OBSERVACION,'%'.$de_observacion.'%',Criteria::LIKE);}
        
                                    
        if($fe_inicio!=""){
    list($dia, $mes,$anio) = explode("/",$fe_inicio);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh013NominaPeer::FE_INICIO,$fecha);
    }
                                    
        if($fe_fin!=""){
    list($dia, $mes,$anio) = explode("/",$fe_fin);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh013NominaPeer::FE_FIN,$fecha);
    }
                                    
        if($fe_pago!=""){
    list($dia, $mes,$anio) = explode("/",$fe_pago);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh013NominaPeer::FE_PAGO,$fecha);
    }
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh013NominaPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh013NominaPeer::updated_at,$fecha);
    }
                                    
                    }
    $c->setIgnoreCase(true);

        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh013NominaPeer::CO_NOMINA);
        $c->addSelectColumn(Tbrh013NominaPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tbrh013NominaPeer::NU_NOMINA);
        $c->addSelectColumn(Tbrh013NominaPeer::FE_INICIO);
        $c->addSelectColumn(Tbrh013NominaPeer::FE_FIN);
        $c->addSelectColumn(Tbrh013NominaPeer::FE_PAGO);
        $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
        $c->addAsColumn('cod_nomina',Tbrh017TpNominaPeer::NU_NOMINA);
        $c->addSelectColumn(Tbrh023NomFrecuenciaPagoPeer::TX_NOM_FRECUENCIA_PAGO);
        $c->addSelectColumn(Tbrh060NominaEstatusPeer::DE_NOMINA_ESTATUS);
        $c->addSelectColumn(Tbrh067GrupoNominaPeer::COD_GRUPO_NOMINA);

        $c->addJoin(Tbrh013NominaPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
        $c->addJoin(Tbrh013NominaPeer::CO_NOM_FRECUENCIA_PAGO, Tbrh023NomFrecuenciaPagoPeer::CO_NOM_FRECUENCIA_PAGO);
        $c->addJoin(Tbrh013NominaPeer::ID_TBRH060_NOMINA_ESTATUS, Tbrh060NominaEstatusPeer::ID);
        $c->addJoin(Tbrh013NominaPeer::CO_GRUPO_NOMINA, Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);

        $c->add(Tbrh013NominaPeer::CO_SOLICITUD, $co_solicitud);
        $c->add(Tbrh013NominaPeer::IN_ACTIVO, TRUE);

        $cantidadTotal = Tbrh013NominaPeer::doCount($c);
    
        $c->setLimit($limit)->setOffset($start);
            $c->addAscendingOrderByColumn(Tbrh013NominaPeer::CO_NOMINA);
        
    $stmt = Tbrh013NominaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_nomina"     => trim($res["co_nomina"]),
            "co_solicitud"     => trim($res["co_solicitud"]),
            "co_tp_nomina"     => trim($res["tx_tp_nomina"]),
            "co_nom_frecuencia_pago"     => trim($res["tx_nom_frecuencia_pago"]),
            "nu_nomina"     => trim($res["nu_nomina"]),
            "cod_nomina"     => trim($res["cod_nomina"]),
            "de_nomina"     => trim($res["de_nomina"]),
            "de_observacion"     => trim($res["de_observacion"]),
            "fe_inicio"     => trim(date("d-m-Y", strtotime($res["fe_inicio"]))),
            "fe_fin"     => trim(date("d-m-Y", strtotime($res["fe_fin"]))),
            "fe_pago"     => trim(date("d-m-Y", strtotime($res["fe_pago"]))),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "in_procesado"     => trim($res["in_procesado"]),
            "id_tbrh060_nomina_estatus"     => trim($res["de_nomina_estatus"]),
            "cod_grupo_nomina"     => trim($res["cod_grupo_nomina"]),
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
                    //modelo fk tbrh025_nom_frecuencia_pago.CO_NOM_FRECUENCIA_PAGO
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
                                                                                                                                
    public function executeStorefkidtbrh060nominaestatus(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh060NominaEstatusPeer::doSelectStmt($c);
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

    public function executeProcesarCalculo(sfWebRequest $request){

        $codigo = $this->getRequestParameter("co_nomina");

        $c = new Criteria();
        $c->setIgnoreCase(true);
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh013NominaPeer::CO_NOMINA);
        $c->addSelectColumn(Tbrh013NominaPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tbrh013NominaPeer::NU_NOMINA);
        $c->addSelectColumn(Tbrh013NominaPeer::FE_INICIO);
        $c->addSelectColumn(Tbrh013NominaPeer::FE_FIN);
        $c->addSelectColumn(Tbrh013NominaPeer::FE_PAGO);
        $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
        $c->addSelectColumn(Tbrh023NomFrecuenciaPagoPeer::TX_NOM_FRECUENCIA_PAGO);
        $c->addSelectColumn(Tbrh060NominaEstatusPeer::DE_NOMINA_ESTATUS);
        $c->addSelectColumn(Tbrh013NominaPeer::CO_TP_NOMINA);
        $c->addSelectColumn(Tbrh013NominaPeer::CO_NOM_FRECUENCIA_PAGO);
        $c->addSelectColumn(Tbrh013NominaPeer::CO_GRUPO_NOMINA);
        $c->addSelectColumn("sp_nu_lunes(".Tbrh013NominaPeer::FE_INICIO.", ".Tbrh013NominaPeer::FE_FIN.") as nu_lunes");
        $c->addJoin(Tbrh013NominaPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
        $c->addJoin(Tbrh013NominaPeer::CO_NOM_FRECUENCIA_PAGO, Tbrh023NomFrecuenciaPagoPeer::CO_NOM_FRECUENCIA_PAGO);
        $c->addJoin(Tbrh013NominaPeer::ID_TBRH060_NOMINA_ESTATUS, Tbrh060NominaEstatusPeer::ID);
        $c->add(Tbrh013NominaPeer::CO_NOMINA,$codigo);
        $c->addAscendingOrderByColumn(Tbrh013NominaPeer::CO_NOMINA);
        $stmt = Tbrh013NominaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $c2 = new Criteria();
        $c2->setIgnoreCase(true);
        $c2->clearSelectColumns();
        $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::TX_CONCEPTO);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::DE_FORMULA);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_MONEDA);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_TIPO_CONCEPTO);
        //$c2->addSelectColumn(Tbrh002FichaPeer::CO_FICHA);
        $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_FICHA);
        $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR);
        $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::IN_CESTATICKET);
        $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::MO_SALARIO_NORMAL);
        $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA);
        $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::MO_SALARIO_ANTERIOR);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_TIPO_UNIDAD);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::NU_VALOR);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_IMPRIME_DETALLE);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_DESCRIPCION_ALTERNATIVA);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_VALOR_REFERENCIA);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_HOJA_TIEMPO);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_PRORRATEA);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_MODIFICA_DESCRIPCION);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_MONTO_CALCULO);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_CONTRACTUAL);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_BONIFICABLE);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_MONTO_CERO);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::NU_PRIORIDAD);
        $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_MODO_CONCEPTO);
        $c2->addSelectColumn(Tbrh026ConcepTipoNominaPeer::CO_GRUPO_NOMINA);
        $c2->addSelectColumn("date_part('year',age(".Tbrh001TrabajadorPeer::FE_NACIMIENTO.")) as nu_edad");
        $c2->addSelectColumn("sp_antiguedad_trabajador(".Tbrh002FichaPeer::FE_INGRESO.", ".Tbrh001TrabajadorPeer::NU_MES_RECONOCIDO.") as nu_antiguedad");
        $c2->addSelectColumn("sp_antiguedad_trabajador_meses(".Tbrh002FichaPeer::FE_INGRESO.", ".Tbrh001TrabajadorPeer::NU_MES_RECONOCIDO.") as nu_mes_antiguedad");
        $c2->addSelectColumn("sp_nu_dias_egreso('".$campos['fe_inicio']."', ".Tbrh002FichaPeer::FE_FINIQUITO.") as nu_dias_egreso");
        $c2->addSelectColumn("sp_nu_dias_ingreso(".Tbrh002FichaPeer::FE_INGRESO.", '".$campos['fe_fin']."') as nu_dias_ingreso");
        $c2->addSelectColumn(Tbrh001TrabajadorPeer::CO_SEXO);
        $c2->addSelectColumn(Tbrh001TrabajadorPeer::NU_HIJO);
        $c2->addSelectColumn(Tbrh001TrabajadorPeer::CO_NIVEL_EDUCATIVO);
        $c2->addSelectColumn(Tbrh002FichaPeer::CO_ESTATUS);
        $c2->addJoin(Tbrh014ConceptoPeer::CO_CONCEPTO, Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO);
        $c2->addJoin(Tbrh014ConceptoPeer::CO_CONCEPTO, Tbrh051ConcepFrecueciaPeer::CO_CONCEPTO);
        $c2->addJoin(Tbrh014ConceptoPeer::CO_CONCEPTO, Tbrh027ConceptoSituacionPeer::CO_CONCEPTO);
        $c2->addJoin(Tbrh014ConceptoPeer::CO_CONCEPTO, Tbrh085ConceptoTipoCargoPeer::CO_CONCEPTO);
        //$c2->addJoin(Tbrh026ConcepTipoNominaPeer::CO_TP_NOMINA, Tbrh002FichaPeer::ID_TBRH017_TP_NOMINA);
        //*************ASOCIACION DE TABLAS CON TRABAJADOR****************//
        $c2->addJoin(Tbrh026ConcepTipoNominaPeer::CO_TP_NOMINA, Tbrh015NomTrabajadorPeer::CO_TP_NOMINA);
        $c2->addJoin(Tbrh026ConcepTipoNominaPeer::CO_GRUPO_NOMINA, Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA);
        $c2->addJoin(Tbrh085ConceptoTipoCargoPeer::CO_TP_CARGO, Tbrh015NomTrabajadorPeer::CO_TP_CARGO);
        $c2->addJoin(Tbrh015NomTrabajadorPeer::CO_FICHA, Tbrh002FichaPeer::CO_FICHA);
        $c2->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
        $c2->addJoin(Tbrh027ConceptoSituacionPeer::CO_SITUACION, Tbrh002FichaPeer::CO_ESTATUS);
        //****************************************************************//
        $c2->add(Tbrh026ConcepTipoNominaPeer::CO_TP_NOMINA, $campos["co_tp_nomina"]);
        $c2->add(Tbrh026ConcepTipoNominaPeer::CO_GRUPO_NOMINA, $campos["co_grupo_nomina"]);
        $c2->add(Tbrh051ConcepFrecueciaPeer::CO_NOM_FRECUENCIA_PAGO, $campos["co_nom_frecuencia_pago"]);
        $c2->add(Tbrh014ConceptoPeer::IN_ACTIVO, TRUE);
        $c2->add(Tbrh015NomTrabajadorPeer::IN_ACTIVO, TRUE);
        //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_MODO_CONCEPTO);
        $c2->addAscendingOrderByColumn(Tbrh015NomTrabajadorPeer::CO_FICHA);
        $c2->addAscendingOrderByColumn(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR);
        //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_TIPO_CONCEPTO);
        $c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::NU_PRIORIDAD);
        //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_MODO_CONCEPTO);
        //$c2->addAscendingOrderByColumn('CAST('.Tbrh014ConceptoPeer::NU_CONCEPTO.' AS BIGINT)');
        //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_TIPO_CONCEPTO);
        //$c2->addAscendingOrderByColumn('CAST('.Tbrh014ConceptoPeer::NU_CONCEPTO.' AS BIGINT)');
        //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
        //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
        $stmt2 = Tbrh014ConceptoPeer::doSelectStmt($c2);

        //echo $c2->toString(); exit();

        $con = Propel::getConnection();
        try{ 
            $con->beginTransaction();

            $wherec = new Criteria();
            $wherec->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $campos["co_nomina"]);
            //$wherec->add(Tbrh061NominaMovimientoPeer::ID_TBRH067_GRUPO_NOMINA, $campos["co_grupo_nomina"]);
            BasePeer::doDelete($wherec, $con);

            $wherec2 = new Criteria();
            $wherec2->add(Tbrh062NominaMovimientoAcumulaPeer::ID_TBRH013_NOMINA, $campos["co_nomina"]);
            //$wherec2->add(Tbrh062NominaMovimientoAcumulaPeer::ID_TBRH067_GRUPO_NOMINA, $campos["co_grupo_nomina"]);
            BasePeer::doDelete($wherec2, $con);

            $con->commit();

        $registros = "";
        while($res = $stmt2->fetch(PDO::FETCH_ASSOC)){

            $valor = 0;
            $referencia = $res["nu_valor"];
            $ficha = $res["co_ficha"];
            $modo_concepto = $res["co_modo_concepto"];
            $nomina = $campos["co_nomina"];
            $nu_lunes = $campos["nu_lunes"];
            $tipo_nomina = $campos["co_tp_nomina"];
            $grupo_nomina = $campos["co_grupo_nomina"];
            $edad = $res["nu_edad"];
            $sexo = $res["co_sexo"];
            $cantidad_hijo = $res["nu_hijo"];
            $antiguedad = $res["nu_antiguedad"];
            $nivel_educativo = $res["co_nivel_educativo"];
            $fecha_inicio = $campos["fe_inicio"];
            $fecha_cierre = $campos["fe_fin"];
            $concepto = $res["nu_concepto"];
            $nom_trabajador = $res["co_nom_trabajador"];
            $in_cestaticket = $res["in_cestaticket"];
            $mes_antiguedad = $res["nu_mes_antiguedad"];
            $situacion = $res["co_estatus"];
            $dias_egreso = $res["nu_dias_egreso"];
            $dias_ingreso = $res["nu_dias_ingreso"];
            $mo_salario_normal = $res["mo_salario_normal"];
            $cargo_estructura = $res["co_cargo_estructura"];
            $mo_salario_anterior = $res["mo_salario_anterior"];

            //****INVOCAR FUNCIONES Y VARIABLES PARA FORMULAS****//
            //****MODO DIRECTO********//
            if($modo_concepto==1){

                if($res["de_formula"]!= ""){

                    //****INVOCAR FUNCIONES Y VARIABLES PARA FORMULAS****//
                    //$mo_salario_base = Tbrh015NomTrabajadorPeer::moSalarioBase( $res["co_ficha"], $campos["co_tp_nomina"], $campos["co_grupo_nomina"] );
    
    
                    //**************************************************//
    
                    @eval($res["de_formula"]);
    
                        if($res["in_monto_cero"]==true){
                            if($valor<=0){
                                continue;
                            }
                        }
    
                        $tbrh061_nomina_movimiento = new Tbrh061NominaMovimiento();
                        $tbrh061_nomina_movimiento->setIdTbrh013Nomina($campos["co_nomina"]);
                        $tbrh061_nomina_movimiento->setIdTbrh014Concepto($res["co_concepto"]);
                        $tbrh061_nomina_movimiento->setIdTbrh020TpConcepto($res["co_tipo_concepto"]);
                        $tbrh061_nomina_movimiento->setIdTbrh002Ficha($res["co_ficha"]);
                        $tbrh061_nomina_movimiento->setDeConcepto($res["tx_concepto"]);
                        $tbrh061_nomina_movimiento->setNuValor($referencia);
                        $tbrh061_nomina_movimiento->setNuMonto($valor);
                        $tbrh061_nomina_movimiento->setIdTbrh050TpUnidad($res["co_tipo_unidad"]);
                        $tbrh061_nomina_movimiento->setInImprimeDetalle($res["in_imprime_detalle"]);
                        $tbrh061_nomina_movimiento->setInDescripcionAlternativa($res["in_descripcion_alternativa"]);
                        $tbrh061_nomina_movimiento->setInValorReferencia($res["in_valor_referencia"]);
                        $tbrh061_nomina_movimiento->setInHojaTiempo($res["in_hoja_tiempo"]);
                        $tbrh061_nomina_movimiento->setInProrratea($res["in_prorratea"]);
                        $tbrh061_nomina_movimiento->setInModificaDescripcion($res["in_modifica_descripcion"]);
                        $tbrh061_nomina_movimiento->setInMontoCalculo($res["in_monto_calculo"]);
                        $tbrh061_nomina_movimiento->setInContractual($res["in_contractual"]);
                        $tbrh061_nomina_movimiento->setInBonificable($res["in_bonificable"]);
                        $tbrh061_nomina_movimiento->setInMontoCero($res["in_monto_cero"]);
                        $tbrh061_nomina_movimiento->setIdTbrh030Moneda($res["co_moneda"]);
                        //$tbrh061_nomina_movimiento->setIdTbrh067GrupoNomina($res["co_grupo_nomina"]);
                        $tbrh061_nomina_movimiento->setIdTbrh015NomTrabajador($res["co_nom_trabajador"]);
                        $tbrh061_nomina_movimiento->setNuPrioridad($res["nu_prioridad"]);
                        $tbrh061_nomina_movimiento->save($con);
    
                        $c3 = new Criteria();
                        $c3->setIgnoreCase(true);
                        $c3->clearSelectColumns();
                        $c3->addSelectColumn(Tbrh034ConcepAcumuladoPeer::CO_CONCEPTO);
                        $c3->addSelectColumn(Tbrh034ConcepAcumuladoPeer::CO_NOM_ACUMULADO);
                        $c3->add(Tbrh034ConcepAcumuladoPeer::CO_CONCEPTO, $res["co_concepto"]);
                        $c3->addAscendingOrderByColumn(Tbrh034ConcepAcumuladoPeer::CO_NOM_ACUMULADO);
                        $stmt3 = Tbrh034ConcepAcumuladoPeer::doSelectStmt($c3);
    
                        while($res2 = $stmt3->fetch(PDO::FETCH_ASSOC)){
    
                            $tbrh062_nomina_movimiento_acumula = new Tbrh062NominaMovimientoAcumula();
                            $tbrh062_nomina_movimiento_acumula->setIdTbrh061NominaMovimiento($tbrh061_nomina_movimiento->getId());
                            $tbrh062_nomina_movimiento_acumula->setIdTbrh021NomAcumulado($res2["co_nom_acumulado"]);
                            $tbrh062_nomina_movimiento_acumula->setIdTbrh013Nomina($campos["co_nomina"]);
                            $tbrh062_nomina_movimiento_acumula->setIdTbrh002Ficha($res["co_ficha"]);
                            $tbrh062_nomina_movimiento_acumula->setIdTbrh067GrupoNomina($res["co_grupo_nomina"]);
                            $tbrh062_nomina_movimiento_acumula->save($con);
    
                        }
    
                        $con->commit();
                    
                }
                
            }elseif($modo_concepto==2){
            //****MODO MULTIPLE****//
            
                $c3 = new Criteria();
                $c3->setIgnoreCase(true);
                $c3->clearSelectColumns();
                $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::CO_CONCEPTOS_FIJOS);
                $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::NU_VALOR);
                $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::NU_MONTO);
                $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::MO_SALDO);
                $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::FE_MOVIMIENTO);
                $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::FE_VENCIMIENTO);
                $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::CO_EMBARGO);
                $c3->addSelectColumn(Tbrh014ConceptoPeer::DE_FORMULA);
                $c3->addSelectColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
                $c3->addSelectColumn(Tbrh014ConceptoPeer::NU_PRIORIDAD);
                $c3->addSelectColumn(Tbrh014ConceptoPeer::NU_VALOR." as nu_referencia");
                //$c3->addSelectColumn(Tbrh091TpFormulaPeer::DE_FORMULA);
                //$c3->addJoin(Tbrh086ConceptosFijosPeer::CO_TP_FORMULA, Tbrh091TpFormulaPeer::CO_TP_FORMULA);
                //$c3->addJoin(Tbrh086ConceptosFijosPeer::CO_CONCEPTO_FORMULA, Tbrh014ConceptoPeer::CO_CONCEPTO, Criteria::LEFT_JOIN);
                $c3->addJoin(Tbrh086ConceptosFijosPeer::CO_CONCEPTO_FORMULA, Tbrh014ConceptoPeer::CO_CONCEPTO);
                //$c3->addJoin(Tbrh086ConceptosFijosPeer::CO_FICHA, Tbrh015NomTrabajadorPeer::CO_FICHA);
                //$c3->add(Tbrh086ConceptosFijosPeer::CO_NOM_TRABAJADOR,$res["co_nom_trabajador"]);
                $c3->add(Tbrh086ConceptosFijosPeer::CO_FICHA, $res["co_ficha"]);
                $c3->add(Tbrh086ConceptosFijosPeer::TX_CODIGO_CONCEPTO, $res["nu_concepto"]);
                $c3->add(Tbrh086ConceptosFijosPeer::IN_ACTIVO, TRUE);
                $c3->addAscendingOrderByColumn(Tbrh086ConceptosFijosPeer::CO_CONCEPTOS_FIJOS);
                $stmt3 = Tbrh086ConceptosFijosPeer::doSelectStmt($c3);

                $cantidad = 0;
                $monto = 0;
                $saldo = 0;

                while($res2 = $stmt3->fetch(PDO::FETCH_ASSOC)){

                    $referencia = $res2["nu_referencia"];
                    $cantidad = $res2["nu_valor"];
                    $monto = $res2["nu_monto"];
                    $saldo = $res2["mo_saldo"];

                    if($res2["de_formula"]!= ""){

                        @eval($res2["de_formula"]);

                        if($res["in_monto_cero"]==true){
                            if($valor<=0){
                                continue;
                            }
                        }

                        $tbrh061_nomina_movimiento = new Tbrh061NominaMovimiento();
                        $tbrh061_nomina_movimiento->setIdTbrh013Nomina($campos["co_nomina"]);
                        $tbrh061_nomina_movimiento->setIdTbrh014Concepto($res2["co_concepto"]);
                        $tbrh061_nomina_movimiento->setIdTbrh020TpConcepto($res["co_tipo_concepto"]);
                        $tbrh061_nomina_movimiento->setIdTbrh002Ficha($res["co_ficha"]);
                        $tbrh061_nomina_movimiento->setDeConcepto($res["tx_concepto"]);
                        $tbrh061_nomina_movimiento->setNuValor($referencia);
                        $tbrh061_nomina_movimiento->setNuMonto($valor);
                        $tbrh061_nomina_movimiento->setIdTbrh050TpUnidad($res["co_tipo_unidad"]);
                        $tbrh061_nomina_movimiento->setInImprimeDetalle($res["in_imprime_detalle"]);
                        $tbrh061_nomina_movimiento->setInDescripcionAlternativa($res["in_descripcion_alternativa"]);
                        $tbrh061_nomina_movimiento->setInValorReferencia($res["in_valor_referencia"]);
                        $tbrh061_nomina_movimiento->setInHojaTiempo($res["in_hoja_tiempo"]);
                        $tbrh061_nomina_movimiento->setInProrratea($res["in_prorratea"]);
                        $tbrh061_nomina_movimiento->setInModificaDescripcion($res["in_modifica_descripcion"]);
                        $tbrh061_nomina_movimiento->setInMontoCalculo($res["in_monto_calculo"]);
                        $tbrh061_nomina_movimiento->setInContractual($res["in_contractual"]);
                        $tbrh061_nomina_movimiento->setInBonificable($res["in_bonificable"]);
                        $tbrh061_nomina_movimiento->setInMontoCero($res["in_monto_cero"]);
                        $tbrh061_nomina_movimiento->setIdTbrh030Moneda($res["co_moneda"]);
                        $tbrh061_nomina_movimiento->setIdTbrh015NomTrabajador($res["co_nom_trabajador"]);
                        $tbrh061_nomina_movimiento->setIdTbrh086ConceptosFijos($res2["co_conceptos_fijos"]);
                        $tbrh061_nomina_movimiento->setNuPrioridad($res2["nu_prioridad"]);
                        $tbrh061_nomina_movimiento->save($con);

                        $con->commit();

                    }

                }

            }

        }

                $tbrh013_nomina = Tbrh013NominaPeer::retrieveByPk($campos["co_nomina"]);
                $tbrh013_nomina->setInProcesado(true);
                $tbrh013_nomina->setIdTbrh060NominaEstatus(2);
                $tbrh013_nomina->save($con);

                $c = new Criteria();
                $c->add(Tbrh013NominaPeer::CO_SOLICITUD, $campos["co_solicitud"]);
                $c->add(Tbrh013NominaPeer::ID_TBRH060_NOMINA_ESTATUS, 1);
                $cantidad_nom = Tbrh013NominaPeer::doCount($c);

                if($cantidad_nom>0){
                    $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($campos["co_solicitud"]));
                    $ruta->setInCargarDato(false)->save($con);
                }else{
                    $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($campos["co_solicitud"]));
                    $ruta->setInCargarDato(true)->save($con);
                    Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());
                }

                $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Nomina procesada exitosamente',
                    //"data"      =>  $registros
                ));

            }catch (PropelException $e){

                $con->rollback();

                $this->data = json_encode(array(
                    "success" => false,
                    "msg" =>  $e->getMessage()
                ));

            }

        $this->setTemplate('store');

        }



        public function executeResumenTipo(sfWebRequest $request)
        {
          $codigo = $this->getRequestParameter("codigo");
          if($codigo!=''||$codigo!=null){
              $c = new Criteria();
                      $c->add(Tbrh013NominaPeer::CO_NOMINA,$codigo);
              
              $stmt = Tbrh013NominaPeer::doSelectStmt($c);
              $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              $this->data = json_encode(array(
                                  "co_nomina"     => $campos["co_nomina"],
                                  "co_solicitud"     => $campos["co_solicitud"],
                                  "co_tp_nomina"     => $campos["co_tp_nomina"],
                                  "co_nom_frecuencia_pago"     => $campos["co_nom_frecuencia_pago"],
                                  "nu_nomina"     => $campos["nu_nomina"],
                                  "de_nomina"     => $campos["de_nomina"],
                                  "de_observacion"     => $campos["de_observacion"],
                                  "fe_inicio"     => $campos["fe_inicio"],
                                  "fe_fin"     => $campos["fe_fin"],
                                  "fe_pago"     => $campos["fe_pago"],
                                  "in_activo"     => $campos["in_activo"],
                                  "created_at"     => $campos["created_at"],
                                  "updated_at"     => $campos["updated_at"],
                                  "in_procesado"     => $campos["in_procesado"],
                                  "id_tbrh060_nomina_estatus"     => $campos["id_tbrh060_nomina_estatus"],
                                  "co_grupo_nomina"     => $campos["co_grupo_nomina"],
                          ));
          }else{
              $this->data = json_encode(array(
                                  "co_nomina"     => "",
                                  "co_solicitud"     => $this->getRequestParameter("co_solicitud"),
                                  "co_tp_nomina"     => "",
                                  "co_nom_frecuencia_pago"     => "",
                                  "nu_nomina"     => "",
                                  "de_nomina"     => "",
                                  "de_observacion"     => "",
                                  "fe_inicio"     => "",
                                  "fe_fin"     => "",
                                  "fe_pago"     => "",
                                  "in_activo"     => "",
                                  "created_at"     => "",
                                  "updated_at"     => "",
                                  "in_procesado"     => "",
                                  "id_tbrh060_nomina_estatus"     => "",
                                  "co_grupo_nomina"     => "",
                          ));
          }
      
        }

        public function executeResumenConcepto(sfWebRequest $request)
        {
          $codigo = $this->getRequestParameter("codigo");
          if($codigo!=''||$codigo!=null){
              $c = new Criteria();
                      $c->add(Tbrh013NominaPeer::CO_NOMINA,$codigo);
              
              $stmt = Tbrh013NominaPeer::doSelectStmt($c);
              $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              $this->data = json_encode(array(
                                  "co_nomina"     => $campos["co_nomina"],
                                  "co_solicitud"     => $campos["co_solicitud"],
                                  "co_tp_nomina"     => $campos["co_tp_nomina"],
                                  "co_nom_frecuencia_pago"     => $campos["co_nom_frecuencia_pago"],
                                  "nu_nomina"     => $campos["nu_nomina"],
                                  "de_nomina"     => $campos["de_nomina"],
                                  "de_observacion"     => $campos["de_observacion"],
                                  "fe_inicio"     => $campos["fe_inicio"],
                                  "fe_fin"     => $campos["fe_fin"],
                                  "fe_pago"     => $campos["fe_pago"],
                                  "in_activo"     => $campos["in_activo"],
                                  "created_at"     => $campos["created_at"],
                                  "updated_at"     => $campos["updated_at"],
                                  "in_procesado"     => $campos["in_procesado"],
                                  "id_tbrh060_nomina_estatus"     => $campos["id_tbrh060_nomina_estatus"],
                                  "co_grupo_nomina"     => $campos["co_grupo_nomina"],
                          ));
          }else{
              $this->data = json_encode(array(
                                  "co_nomina"     => "",
                                  "co_solicitud"     => $this->getRequestParameter("co_solicitud"),
                                  "co_tp_nomina"     => "",
                                  "co_nom_frecuencia_pago"     => "",
                                  "nu_nomina"     => "",
                                  "de_nomina"     => "",
                                  "de_observacion"     => "",
                                  "fe_inicio"     => "",
                                  "fe_fin"     => "",
                                  "fe_pago"     => "",
                                  "in_activo"     => "",
                                  "created_at"     => "",
                                  "updated_at"     => "",
                                  "in_procesado"     => "",
                                  "id_tbrh060_nomina_estatus"     => "",
                                  "co_grupo_nomina"     => "",
                          ));
          }
      
        }


        public function executeCerrar(sfWebRequest $request)
        {

            $arreglo = $this->getRequestParameter("arreglo");
      
            $listaArreglo  = json_decode($arreglo,true);
      
            $con = Propel::getConnection();
      
            try
            { 
              $con->beginTransaction();
      
              foreach($listaArreglo as $arregloForm){
      
                /*Campo tipo TIMESTAMP */
                $fecha = date("Y-m-d H:i:s");
      
                $tbrh013_nomina = Tbrh013NominaPeer::retrieveByPk($arregloForm['co_nomina']);
                $tbrh013_nomina->setIdTbrh060NominaEstatus(3);
                $tbrh013_nomina->setUpdatedAt($fecha);
                $tbrh013_nomina->save($con);

                $wherec = new Criteria();
                $wherec->add(Tbrh101CierreNominaPresupuestoPeer::ID_TBRH013_NOMINA, $arregloForm['co_nomina']);
                BasePeer::doDelete($wherec, $con);

                $wherect = new Criteria();
                $wherect->add(Tbrh102CierreNominaTrabajadorPeer::ID_TBRH013_NOMINA, $arregloForm['co_nomina']);
                BasePeer::doDelete($wherect, $con);

                $con->commit();

                $c = new Criteria();
                $c->add(Tbrh013NominaPeer::CO_NOMINA, $arregloForm["co_nomina"]);
                $stmt = Tbrh013NominaPeer::doSelectStmt($c);
                $campos = $stmt->fetch(PDO::FETCH_ASSOC);

                $c2 = new Criteria();
                $c2->add(Tbrh013NominaPeer::CO_SOLICITUD, $campos["co_solicitud"]);
                $c2->add(Tbrh013NominaPeer::ID_TBRH060_NOMINA_ESTATUS, 2);
                $cantidad_nom = Tbrh013NominaPeer::doCount($c2);

                $c3 = new Criteria();   
                $c3->setIgnoreCase(true);
                $c3->addSelectColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
                $c3->addSelectColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
                $c3->addSelectColumn(Tbrh014ConceptoPeer::TX_CONCEPTO);
                $c3->addSelectColumn(Tbrh014ConceptoPeer::NU_CUENTA_PRESUPUESTO);
                $c3->addSelectColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
                $c3->addSelectColumn(Tb010BancoPeer::TX_CODIGO_BANCO);
                $c3->addSelectColumn(Tbrh001TrabajadorPeer::CO_BANCO);
                $c3->addSelectColumn(Tbrh013NominaPeer::FE_PAGO);
                $c3->addSelectColumn('SUM('.Tbrh061NominaMovimientoPeer::NU_MONTO.') as nu_monto');
                $c3->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH014_CONCEPTO, Tbrh014ConceptoPeer::CO_CONCEPTO);
                $c3->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH020_TP_CONCEPTO, Tbrh020TpConceptoPeer::CO_TP_CONCEPTO);
                $c3->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, Tbrh002FichaPeer::CO_FICHA);
                $c3->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
                $c3->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, Tbrh013NominaPeer::CO_NOMINA);
                $c3->addJoin(Tbrh001TrabajadorPeer::CO_BANCO, Tb010BancoPeer::CO_BANCO, Criteria::LEFT_JOIN);
        
                $c3->addAscendingOrderByColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
                $c3->addAscendingOrderByColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
                $c3->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $arregloForm['co_nomina']);
                $c3->add(Tbrh061NominaMovimientoPeer::ID_TBRH020_TP_CONCEPTO, array(4),  Criteria::NOT_IN);
        
                $c3->addGroupByColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
                $c3->addGroupByColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
                $c3->addGroupByColumn(Tbrh014ConceptoPeer::TX_CONCEPTO);
                $c3->addGroupByColumn(Tbrh014ConceptoPeer::NU_CUENTA_PRESUPUESTO);
                $c3->addGroupByColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
                $c3->addGroupByColumn(Tb010BancoPeer::TX_CODIGO_BANCO);
                $c3->addGroupByColumn(Tbrh001TrabajadorPeer::CO_BANCO);
                $c3->addGroupByColumn(Tbrh013NominaPeer::FE_PAGO);
        
                $stmt3 = Tbrh061NominaMovimientoPeer::doSelectStmt($c3);

                while($res = $stmt3->fetch(PDO::FETCH_ASSOC)){

                    //var_dump($res);

                    $tbrh101_cierre_nomina_presupuesto = new Tbrh101CierreNominaPresupuesto();
                    $tbrh101_cierre_nomina_presupuesto->setIdTbrh013Nomina($arregloForm['co_nomina']);
                    $tbrh101_cierre_nomina_presupuesto->setIdTbrh014Concepto($res["co_concepto"]);
                    $tbrh101_cierre_nomina_presupuesto->setDeConcepto($res["tx_concepto"]);
                    $tbrh101_cierre_nomina_presupuesto->setNuConcepto($res["nu_concepto"]);
                    $tbrh101_cierre_nomina_presupuesto->setIdTb026Solicitud($campos["co_solicitud"]);
                    $tbrh101_cierre_nomina_presupuesto->setMoConcepto($res["nu_monto"]);
                    $tbrh101_cierre_nomina_presupuesto->setDeSucursal(substr(trim($res["nu_cuenta_presupuesto"]), 0, 4));
                    $tbrh101_cierre_nomina_presupuesto->setDeFun(substr(trim($res["tx_tp_concepto"]), 0, 1));
                    $tbrh101_cierre_nomina_presupuesto->setDeCategoria(substr(trim($res["nu_cuenta_presupuesto"]), 4, 8));
                    $tbrh101_cierre_nomina_presupuesto->setNuBanco($res["tx_codigo_banco"]);
                    $tbrh101_cierre_nomina_presupuesto->setIdTb010Banco($res["co_banco"]);
                    $tbrh101_cierre_nomina_presupuesto->setNuPartida(substr(trim($res["nu_cuenta_presupuesto"]), 12, 12));
                    $tbrh101_cierre_nomina_presupuesto->setFePago($res["fe_pago"]);
                    $tbrh101_cierre_nomina_presupuesto->setNuDecreto(substr(trim($res["nu_cuenta_presupuesto"]), 24, 5));
                    $tbrh101_cierre_nomina_presupuesto->save($con);

                }

                $c4 = new Criteria();   
                $c4->setIgnoreCase(true);
                $c4->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $arregloForm["co_nomina"]);
                $c4->add(Tbrh061NominaMovimientoPeer::ID_TBRH020_TP_CONCEPTO, array(4),  Criteria::NOT_IN);
                $c4->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA);
                $c4->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA);
                $c4->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR);
                $c4->addSelectColumn(Tbrh002FichaPeer::NU_FICHA);
                $c4->addSelectColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
                $c4->addSelectColumn(Tb007DocumentoPeer::INICIAL);
                $c4->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
                $c4->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
                $c4->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
                $c4->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
                $c4->addSelectColumn(Tbrh001TrabajadorPeer::NU_CUENTA_BANCARIA);
                $c4->addSelectColumn(Tb010BancoPeer::TX_CODIGO_BANCO);
                $c4->addAsColumn('mo_asignacion', 'sp_tbrh061_nomina_movimiento_mo_movimiento( tbrh061_nomina_movimiento.id_tbrh013_nomina, tbrh061_nomina_movimiento.id_tbrh002_ficha, tbrh061_nomina_movimiento.id_tbrh015_nom_trabajador, 1 )');
                $c4->addAsColumn('mo_deduccion', 'sp_tbrh061_nomina_movimiento_mo_movimiento( tbrh061_nomina_movimiento.id_tbrh013_nomina, tbrh061_nomina_movimiento.id_tbrh002_ficha, tbrh061_nomina_movimiento.id_tbrh015_nom_trabajador, 2 )');
                $c4->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, Tbrh002FichaPeer::CO_FICHA);
                $c4->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
                $c4->addJoin(Tbrh001TrabajadorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
                $c4->addJoin(Tbrh001TrabajadorPeer::CO_BANCO, Tb010BancoPeer::CO_BANCO, Criteria::LEFT_JOIN);
                $c4->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA);
                $c4->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA);
                $c4->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR);
                $c4->addGroupByColumn(Tbrh002FichaPeer::NU_FICHA);
                $c4->addGroupByColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
                $c4->addGroupByColumn(Tb007DocumentoPeer::INICIAL);
                $c4->addGroupByColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
                $c4->addGroupByColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
                $c4->addGroupByColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
                $c4->addGroupByColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
                $c4->addGroupByColumn(Tbrh001TrabajadorPeer::NU_CUENTA_BANCARIA);
                $c4->addGroupByColumn(Tb010BancoPeer::TX_CODIGO_BANCO);
                $c4->addAscendingOrderByColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
                    
                $stmt4 = Tbrh061NominaMovimientoPeer::doSelectStmt($c4);

                //var_dump($stmt4);

                while($res2 = $stmt4->fetch(PDO::FETCH_ASSOC)){                    

                    $mo_pago = $res2["mo_asignacion"]-$res2["mo_deduccion"];

                    $mo_salario_normal = Tbrh102CierreNominaTrabajadorPeer::salarioNormal( $arregloForm['co_nomina'], $res2['id_tbrh015_nom_trabajador'], '5611' );

                    if($mo_salario_normal === NULL){
                        $mo_salario_normal = 0;
                    }

                    $tbrh102_cierre_nomina_trabajador = new Tbrh102CierreNominaTrabajador();
                    $tbrh102_cierre_nomina_trabajador->setIdTbrh013Nomina($arregloForm['co_nomina']);
                    $tbrh102_cierre_nomina_trabajador->setIdTb026Solicitud($campos["co_solicitud"]);
                    $tbrh102_cierre_nomina_trabajador->setIdTbrh002Ficha($res2['id_tbrh002_ficha']);
                    $tbrh102_cierre_nomina_trabajador->setIdTbrh015NomTrabajador($res2['id_tbrh015_nom_trabajador']);
                    $tbrh102_cierre_nomina_trabajador->setDeInicial($res2["inicial"]);
                    $tbrh102_cierre_nomina_trabajador->setNuCedula($res2["nu_cedula"]);
                    $tbrh102_cierre_nomina_trabajador->setNbTrabajador(trim($res2["nb_primer_apellido"].' '.$res2["nb_primer_nombre"]));
                    $tbrh102_cierre_nomina_trabajador->setNuCuenta(trim($res2["nu_cuenta_bancaria"]));
                    $tbrh102_cierre_nomina_trabajador->setNuBanco(trim($res2["tx_codigo_banco"]));
                    $tbrh102_cierre_nomina_trabajador->setMoPago($mo_pago);
                    $tbrh102_cierre_nomina_trabajador->setMoSalarioNormal($mo_salario_normal);
                    $tbrh102_cierre_nomina_trabajador->save($con);

                }

                if($cantidad_nom>0){
                    $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($campos["co_solicitud"]));
                    $ruta->setInCargarDato(false)->save($con);
                }else{
                    $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($campos["co_solicitud"]));
                    $ruta->setInCargarDato(true)->save($con);
                    Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());
                }
      
                $con->commit();
      
              }

              $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Nominas Cerradas Exitosamente!',
              ));
      
            }catch (PropelException $e)
            {
              $con->rollback();
              $this->data = json_encode(array(
                  "success" => false,
                  "msg" =>  $e->getMessage()
              ));
            }
      
          }


          public function executeAbrir(sfWebRequest $request)
          {
  
              $arreglo = $this->getRequestParameter("arreglo");
        
              $listaArreglo  = json_decode($arreglo,true);
        
              $con = Propel::getConnection();
        
              try
              { 
                $con->beginTransaction();
        
                foreach($listaArreglo as $arregloForm){
        
                  /*Campo tipo TIMESTAMP */
                  $fecha = date("Y-m-d H:i:s");
        
                  $tbrh013_nomina = Tbrh013NominaPeer::retrieveByPk($arregloForm['co_nomina']);
                  $tbrh013_nomina->setIdTbrh060NominaEstatus(2);
                  $tbrh013_nomina->setUpdatedAt($fecha);
                  $tbrh013_nomina->save($con);

                  $wherec = new Criteria();
                  $wherec->add(Tbrh101CierreNominaPresupuestoPeer::ID_TBRH013_NOMINA, $arregloForm['co_nomina']);
                  BasePeer::doDelete($wherec, $con);

                  $wherect = new Criteria();
                  $wherect->add(Tbrh102CierreNominaTrabajadorPeer::ID_TBRH013_NOMINA, $arregloForm['co_nomina']);
                  BasePeer::doDelete($wherect, $con);
        
                  /*$c = new Criteria();
                  $c->clearSelectColumns();
                  $c->addSelectColumn(Tb170ExoneracionPeer::ID_TB079_LIQUIDACION);
                  $c->add(Tb170ExoneracionPeer::ID,$arregloForm['id']);
                  $stmt = Tb170ExoneracionPeer::doSelectStmt($c);
                  $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
                  $tb079_liquidacion = Tb079LiquidacionPeer::retrieveByPk($campos['id_tb079_liquidacion']);
                  $tb079_liquidacion->setCoEstatus(5);
                  $tb079_liquidacion->save($con);*/

                  $c = new Criteria();
                  $c->add(Tbrh013NominaPeer::CO_NOMINA, $arregloForm["co_nomina"]);
                  $stmt = Tbrh013NominaPeer::doSelectStmt($c);
                  $campos = $stmt->fetch(PDO::FETCH_ASSOC);
  
                  $c2 = new Criteria();
                  $c2->add(Tbrh013NominaPeer::CO_SOLICITUD, $campos["co_solicitud"]);
                  $c2->add(Tbrh013NominaPeer::ID_TBRH060_NOMINA_ESTATUS, 2);
                  $cantidad_nom = Tbrh013NominaPeer::doCount($c2);
  
                  if($cantidad_nom>0){
                      $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($campos["co_solicitud"]));
                      $ruta->setInCargarDato(false)->save($con);
                  }else{
                      $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($campos["co_solicitud"]));
                      $ruta->setInCargarDato(true)->save($con);
                      Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());
                  }
        
                  $con->commit();
        
                }
        
              }catch (PropelException $e)
              {
                $con->rollback();
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" =>  $e->getMessage()
                ));
              }
        
              $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Nominas Aperturadas Exitosamente!',
              ));
        
            }

}