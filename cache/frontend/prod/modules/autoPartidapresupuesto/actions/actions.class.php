<?php

/**
 * autoPartidapresupuesto actions.
 * NombreClaseModel(Tb085Presupuesto)
 * NombreTabla(tb085_presupuesto)
 * @package    ##PROJECT_NAME##
 * @subpackage autoPartidapresupuesto
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoPartidapresupuestoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Partidapresupuesto', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Partidapresupuesto', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb085PresupuestoPeer::ID,$codigo);
        
        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb084_accion_especifica"     => $campos["id_tb084_accion_especifica"],
                            "nu_partida"     => $campos["nu_partida"],
                            "de_partida"     => $campos["de_partida"],
                            "mo_inicial"     => $campos["mo_inicial"],
                            "mo_actualizado"     => $campos["mo_actualizado"],
                            "mo_precomprometido"     => $campos["mo_precomprometido"],
                            "mo_comprometido"     => $campos["mo_comprometido"],
                            "mo_causado"     => $campos["mo_causado"],
                            "mo_pagado"     => $campos["mo_pagado"],
                            "mo_disponible"     => $campos["mo_disponible"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "in_movimiento"     => $campos["in_movimiento"],
                            "nu_pa"     => $campos["nu_pa"],
                            "nu_ge"     => $campos["nu_ge"],
                            "nu_es"     => $campos["nu_es"],
                            "nu_se"     => $campos["nu_se"],
                            "nu_sse"     => $campos["nu_sse"],
                            "co_partida"     => $campos["co_partida"],
                            "nu_nivel"     => $campos["nu_nivel"],
                            "nu_fi"     => $campos["nu_fi"],
                            "co_categoria"     => $campos["co_categoria"],
                            "nu_aplicacion"     => $campos["nu_aplicacion"],
                            "tp_ingreso"     => $campos["tp_ingreso"],
                            "co_cuenta_contable"     => $campos["co_cuenta_contable"],
                            "tip_apl"     => $campos["tip_apl"],
                            "in_gen_cheque"     => $campos["in_gen_cheque"],
                            "tip_gasto"     => $campos["tip_gasto"],
                            "tip_ing"     => $campos["tip_ing"],
                            "cod_amb"     => $campos["cod_amb"],
                            "co_ente"     => $campos["co_ente"],
                            "nu_anio"     => $campos["nu_anio"],
                            "mo_disponible_act"     => $campos["mo_disponible_act"],
                            "mo_aumento"     => $campos["mo_aumento"],
                            "mo_disminucion"     => $campos["mo_disminucion"],
                            "mo_admon"     => $campos["mo_admon"],
                            "mo_actualizado_ant"     => $campos["mo_actualizado_ant"],
                            "comprometido_dia"     => $campos["comprometido_dia"],
                            "causado_dia"     => $campos["causado_dia"],
                            "pagado_dia"     => $campos["pagado_dia"],
                            "disponible"     => $campos["disponible"],
                            "cod_ente"     => $campos["cod_ente"],
                            "nu_sector"     => $campos["nu_sector"],
                            "id_tb139_aplicacion"     => $campos["id_tb139_aplicacion"],
                            "mo_admon_ant"     => $campos["mo_admon_ant"],
                            "mo_modificado_admon"     => $campos["mo_modificado_admon"],
                            "co_clasificacion_economica"     => $campos["co_clasificacion_economica"],
                            "co_area_estrategica"     => $campos["co_area_estrategica"],
                            "mo_inicial_soberano"     => $campos["mo_inicial_soberano"],
                            "mo_actualizado_soberano"     => $campos["mo_actualizado_soberano"],
                            "mo_comprometido_soberano"     => $campos["mo_comprometido_soberano"],
                            "mo_causado_soberano"     => $campos["mo_causado_soberano"],
                            "mo_pagado_soberano"     => $campos["mo_pagado_soberano"],
                            "mo_disponible_soberano"     => $campos["mo_disponible_soberano"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb084_accion_especifica"     => "",
                            "nu_partida"     => "",
                            "de_partida"     => "",
                            "mo_inicial"     => "",
                            "mo_actualizado"     => "",
                            "mo_precomprometido"     => "",
                            "mo_comprometido"     => "",
                            "mo_causado"     => "",
                            "mo_pagado"     => "",
                            "mo_disponible"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "in_movimiento"     => "",
                            "nu_pa"     => "",
                            "nu_ge"     => "",
                            "nu_es"     => "",
                            "nu_se"     => "",
                            "nu_sse"     => "",
                            "co_partida"     => "",
                            "nu_nivel"     => "",
                            "nu_fi"     => "",
                            "co_categoria"     => "",
                            "nu_aplicacion"     => "",
                            "tp_ingreso"     => "",
                            "co_cuenta_contable"     => "",
                            "tip_apl"     => "",
                            "in_gen_cheque"     => "",
                            "tip_gasto"     => "",
                            "tip_ing"     => "",
                            "cod_amb"     => "",
                            "co_ente"     => "",
                            "nu_anio"     => "",
                            "mo_disponible_act"     => "",
                            "mo_aumento"     => "",
                            "mo_disminucion"     => "",
                            "mo_admon"     => "",
                            "mo_actualizado_ant"     => "",
                            "comprometido_dia"     => "",
                            "causado_dia"     => "",
                            "pagado_dia"     => "",
                            "disponible"     => "",
                            "cod_ente"     => "",
                            "nu_sector"     => "",
                            "id_tb139_aplicacion"     => "",
                            "mo_admon_ant"     => "",
                            "mo_modificado_admon"     => "",
                            "co_clasificacion_economica"     => "",
                            "co_area_estrategica"     => "",
                            "mo_inicial_soberano"     => "",
                            "mo_actualizado_soberano"     => "",
                            "mo_comprometido_soberano"     => "",
                            "mo_causado_soberano"     => "",
                            "mo_pagado_soberano"     => "",
                            "mo_disponible_soberano"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb085_presupuesto = Tb085PresupuestoPeer::retrieveByPk($codigo);
     }else{
         $tb085_presupuesto = new Tb085Presupuesto();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb085_presupuestoForm = $this->getRequestParameter('tb085_presupuesto');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb085_presupuesto->setIdTb084AccionEspecifica($tb085_presupuestoForm["id_tb084_accion_especifica"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setNuPartida($tb085_presupuestoForm["nu_partida"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setDePartida($tb085_presupuestoForm["de_partida"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoInicial($tb085_presupuestoForm["mo_inicial"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoActualizado($tb085_presupuestoForm["mo_actualizado"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoPrecomprometido($tb085_presupuestoForm["mo_precomprometido"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoComprometido($tb085_presupuestoForm["mo_comprometido"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoCausado($tb085_presupuestoForm["mo_causado"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoPagado($tb085_presupuestoForm["mo_pagado"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoDisponible($tb085_presupuestoForm["mo_disponible"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb085_presupuestoForm)){
            $tb085_presupuesto->setInActivo(false);
        }else{
            $tb085_presupuesto->setInActivo(true);
        }
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb085_presupuestoForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb085_presupuesto->setCreatedAt($fecha);
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb085_presupuestoForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb085_presupuesto->setUpdatedAt($fecha);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_movimiento", $tb085_presupuestoForm)){
            $tb085_presupuesto->setInMovimiento(false);
        }else{
            $tb085_presupuesto->setInMovimiento(true);
        }
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setNuPa($tb085_presupuestoForm["nu_pa"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setNuGe($tb085_presupuestoForm["nu_ge"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setNuEs($tb085_presupuestoForm["nu_es"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setNuSe($tb085_presupuestoForm["nu_se"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setNuSse($tb085_presupuestoForm["nu_sse"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setCoPartida($tb085_presupuestoForm["co_partida"]);
                                                        
        /*Campo tipo BIGINT */
        $tb085_presupuesto->setNuNivel($tb085_presupuestoForm["nu_nivel"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setNuFi($tb085_presupuestoForm["nu_fi"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setCoCategoria($tb085_presupuestoForm["co_categoria"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setNuAplicacion($tb085_presupuestoForm["nu_aplicacion"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setTpIngreso($tb085_presupuestoForm["tp_ingreso"]);
                                                        
        /*Campo tipo BIGINT */
        $tb085_presupuesto->setCoCuentaContable($tb085_presupuestoForm["co_cuenta_contable"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setTipApl($tb085_presupuestoForm["tip_apl"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_gen_cheque", $tb085_presupuestoForm)){
            $tb085_presupuesto->setInGenCheque(false);
        }else{
            $tb085_presupuesto->setInGenCheque(true);
        }
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setTipGasto($tb085_presupuestoForm["tip_gasto"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setTipIng($tb085_presupuestoForm["tip_ing"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setCodAmb($tb085_presupuestoForm["cod_amb"]);
                                                        
        /*Campo tipo BIGINT */
        $tb085_presupuesto->setCoEnte($tb085_presupuestoForm["co_ente"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setNuAnio($tb085_presupuestoForm["nu_anio"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoDisponibleAct($tb085_presupuestoForm["mo_disponible_act"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoAumento($tb085_presupuestoForm["mo_aumento"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoDisminucion($tb085_presupuestoForm["mo_disminucion"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoAdmon($tb085_presupuestoForm["mo_admon"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoActualizadoAnt($tb085_presupuestoForm["mo_actualizado_ant"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setComprometidoDia($tb085_presupuestoForm["comprometido_dia"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setCausadoDia($tb085_presupuestoForm["causado_dia"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setPagadoDia($tb085_presupuestoForm["pagado_dia"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setDisponible($tb085_presupuestoForm["disponible"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setCodEnte($tb085_presupuestoForm["cod_ente"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setNuSector($tb085_presupuestoForm["nu_sector"]);
                                                        
        /*Campo tipo BIGINT */
        $tb085_presupuesto->setIdTb139Aplicacion($tb085_presupuestoForm["id_tb139_aplicacion"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoAdmonAnt($tb085_presupuestoForm["mo_admon_ant"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoModificadoAdmon($tb085_presupuestoForm["mo_modificado_admon"]);
                                                        
        /*Campo tipo BIGINT */
        $tb085_presupuesto->setCoClasificacionEconomica($tb085_presupuestoForm["co_clasificacion_economica"]);
                                                        
        /*Campo tipo BIGINT */
        $tb085_presupuesto->setCoAreaEstrategica($tb085_presupuestoForm["co_area_estrategica"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoInicialSoberano($tb085_presupuestoForm["mo_inicial_soberano"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoActualizadoSoberano($tb085_presupuestoForm["mo_actualizado_soberano"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoComprometidoSoberano($tb085_presupuestoForm["mo_comprometido_soberano"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoCausadoSoberano($tb085_presupuestoForm["mo_causado_soberano"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoPagadoSoberano($tb085_presupuestoForm["mo_pagado_soberano"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoDisponibleSoberano($tb085_presupuestoForm["mo_disponible_soberano"]);
                                
        /*CAMPOS*/
        $tb085_presupuesto->save($con);
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
	$codigo = $this->getRequestParameter("id");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb085_presupuesto = Tb085PresupuestoPeer::retrieveByPk($codigo);			
	$tb085_presupuesto->delete($con);
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
                $id_tb084_accion_especifica      =   $this->getRequestParameter("id_tb084_accion_especifica");
            $nu_partida      =   $this->getRequestParameter("nu_partida");
            $de_partida      =   $this->getRequestParameter("de_partida");
            $mo_inicial      =   $this->getRequestParameter("mo_inicial");
            $mo_actualizado      =   $this->getRequestParameter("mo_actualizado");
            $mo_precomprometido      =   $this->getRequestParameter("mo_precomprometido");
            $mo_comprometido      =   $this->getRequestParameter("mo_comprometido");
            $mo_causado      =   $this->getRequestParameter("mo_causado");
            $mo_pagado      =   $this->getRequestParameter("mo_pagado");
            $mo_disponible      =   $this->getRequestParameter("mo_disponible");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $in_movimiento      =   $this->getRequestParameter("in_movimiento");
            $nu_pa      =   $this->getRequestParameter("nu_pa");
            $nu_ge      =   $this->getRequestParameter("nu_ge");
            $nu_es      =   $this->getRequestParameter("nu_es");
            $nu_se      =   $this->getRequestParameter("nu_se");
            $nu_sse      =   $this->getRequestParameter("nu_sse");
            $co_partida      =   $this->getRequestParameter("co_partida");
            $nu_nivel      =   $this->getRequestParameter("nu_nivel");
            $nu_fi      =   $this->getRequestParameter("nu_fi");
            $co_categoria      =   $this->getRequestParameter("co_categoria");
            $nu_aplicacion      =   $this->getRequestParameter("nu_aplicacion");
            $tp_ingreso      =   $this->getRequestParameter("tp_ingreso");
            $co_cuenta_contable      =   $this->getRequestParameter("co_cuenta_contable");
            $tip_apl      =   $this->getRequestParameter("tip_apl");
            $in_gen_cheque      =   $this->getRequestParameter("in_gen_cheque");
            $tip_gasto      =   $this->getRequestParameter("tip_gasto");
            $tip_ing      =   $this->getRequestParameter("tip_ing");
            $cod_amb      =   $this->getRequestParameter("cod_amb");
            $co_ente      =   $this->getRequestParameter("co_ente");
            $nu_anio      =   $this->getRequestParameter("nu_anio");
            $mo_disponible_act      =   $this->getRequestParameter("mo_disponible_act");
            $mo_aumento      =   $this->getRequestParameter("mo_aumento");
            $mo_disminucion      =   $this->getRequestParameter("mo_disminucion");
            $mo_admon      =   $this->getRequestParameter("mo_admon");
            $mo_actualizado_ant      =   $this->getRequestParameter("mo_actualizado_ant");
            $comprometido_dia      =   $this->getRequestParameter("comprometido_dia");
            $causado_dia      =   $this->getRequestParameter("causado_dia");
            $pagado_dia      =   $this->getRequestParameter("pagado_dia");
            $disponible      =   $this->getRequestParameter("disponible");
            $cod_ente      =   $this->getRequestParameter("cod_ente");
            $nu_sector      =   $this->getRequestParameter("nu_sector");
            $id_tb139_aplicacion      =   $this->getRequestParameter("id_tb139_aplicacion");
            $mo_admon_ant      =   $this->getRequestParameter("mo_admon_ant");
            $mo_modificado_admon      =   $this->getRequestParameter("mo_modificado_admon");
            $co_clasificacion_economica      =   $this->getRequestParameter("co_clasificacion_economica");
            $co_area_estrategica      =   $this->getRequestParameter("co_area_estrategica");
            $mo_inicial_soberano      =   $this->getRequestParameter("mo_inicial_soberano");
            $mo_actualizado_soberano      =   $this->getRequestParameter("mo_actualizado_soberano");
            $mo_comprometido_soberano      =   $this->getRequestParameter("mo_comprometido_soberano");
            $mo_causado_soberano      =   $this->getRequestParameter("mo_causado_soberano");
            $mo_pagado_soberano      =   $this->getRequestParameter("mo_pagado_soberano");
            $mo_disponible_soberano      =   $this->getRequestParameter("mo_disponible_soberano");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($id_tb084_accion_especifica!=""){$c->add(Tb085PresupuestoPeer::id_tb084_accion_especifica,$id_tb084_accion_especifica);}
    
                                        if($nu_partida!=""){$c->add(Tb085PresupuestoPeer::nu_partida,'%'.$nu_partida.'%',Criteria::LIKE);}
        
                                        if($de_partida!=""){$c->add(Tb085PresupuestoPeer::de_partida,'%'.$de_partida.'%',Criteria::LIKE);}
        
                                            if($mo_inicial!=""){$c->add(Tb085PresupuestoPeer::mo_inicial,$mo_inicial);}
    
                                            if($mo_actualizado!=""){$c->add(Tb085PresupuestoPeer::mo_actualizado,$mo_actualizado);}
    
                                            if($mo_precomprometido!=""){$c->add(Tb085PresupuestoPeer::mo_precomprometido,$mo_precomprometido);}
    
                                            if($mo_comprometido!=""){$c->add(Tb085PresupuestoPeer::mo_comprometido,$mo_comprometido);}
    
                                            if($mo_causado!=""){$c->add(Tb085PresupuestoPeer::mo_causado,$mo_causado);}
    
                                            if($mo_pagado!=""){$c->add(Tb085PresupuestoPeer::mo_pagado,$mo_pagado);}
    
                                            if($mo_disponible!=""){$c->add(Tb085PresupuestoPeer::mo_disponible,$mo_disponible);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb085PresupuestoPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb085PresupuestoPeer::updated_at,$fecha);
    }
                                    
                                        if($nu_pa!=""){$c->add(Tb085PresupuestoPeer::nu_pa,'%'.$nu_pa.'%',Criteria::LIKE);}
        
                                        if($nu_ge!=""){$c->add(Tb085PresupuestoPeer::nu_ge,'%'.$nu_ge.'%',Criteria::LIKE);}
        
                                        if($nu_es!=""){$c->add(Tb085PresupuestoPeer::nu_es,'%'.$nu_es.'%',Criteria::LIKE);}
        
                                        if($nu_se!=""){$c->add(Tb085PresupuestoPeer::nu_se,'%'.$nu_se.'%',Criteria::LIKE);}
        
                                        if($nu_sse!=""){$c->add(Tb085PresupuestoPeer::nu_sse,'%'.$nu_sse.'%',Criteria::LIKE);}
        
                                        if($co_partida!=""){$c->add(Tb085PresupuestoPeer::co_partida,'%'.$co_partida.'%',Criteria::LIKE);}
        
                                            if($nu_nivel!=""){$c->add(Tb085PresupuestoPeer::nu_nivel,$nu_nivel);}
    
                                        if($nu_fi!=""){$c->add(Tb085PresupuestoPeer::nu_fi,'%'.$nu_fi.'%',Criteria::LIKE);}
        
                                        if($co_categoria!=""){$c->add(Tb085PresupuestoPeer::co_categoria,'%'.$co_categoria.'%',Criteria::LIKE);}
        
                                        if($nu_aplicacion!=""){$c->add(Tb085PresupuestoPeer::nu_aplicacion,'%'.$nu_aplicacion.'%',Criteria::LIKE);}
        
                                        if($tp_ingreso!=""){$c->add(Tb085PresupuestoPeer::tp_ingreso,'%'.$tp_ingreso.'%',Criteria::LIKE);}
        
                                            if($co_cuenta_contable!=""){$c->add(Tb085PresupuestoPeer::co_cuenta_contable,$co_cuenta_contable);}
    
                                        if($tip_apl!=""){$c->add(Tb085PresupuestoPeer::tip_apl,'%'.$tip_apl.'%',Criteria::LIKE);}
        
                                    
                                        if($tip_gasto!=""){$c->add(Tb085PresupuestoPeer::tip_gasto,'%'.$tip_gasto.'%',Criteria::LIKE);}
        
                                        if($tip_ing!=""){$c->add(Tb085PresupuestoPeer::tip_ing,'%'.$tip_ing.'%',Criteria::LIKE);}
        
                                        if($cod_amb!=""){$c->add(Tb085PresupuestoPeer::cod_amb,'%'.$cod_amb.'%',Criteria::LIKE);}
        
                                            if($co_ente!=""){$c->add(Tb085PresupuestoPeer::co_ente,$co_ente);}
    
                                            if($nu_anio!=""){$c->add(Tb085PresupuestoPeer::nu_anio,$nu_anio);}
    
                                            if($mo_disponible_act!=""){$c->add(Tb085PresupuestoPeer::mo_disponible_act,$mo_disponible_act);}
    
                                            if($mo_aumento!=""){$c->add(Tb085PresupuestoPeer::mo_aumento,$mo_aumento);}
    
                                            if($mo_disminucion!=""){$c->add(Tb085PresupuestoPeer::mo_disminucion,$mo_disminucion);}
    
                                            if($mo_admon!=""){$c->add(Tb085PresupuestoPeer::mo_admon,$mo_admon);}
    
                                            if($mo_actualizado_ant!=""){$c->add(Tb085PresupuestoPeer::mo_actualizado_ant,$mo_actualizado_ant);}
    
                                            if($comprometido_dia!=""){$c->add(Tb085PresupuestoPeer::comprometido_dia,$comprometido_dia);}
    
                                            if($causado_dia!=""){$c->add(Tb085PresupuestoPeer::causado_dia,$causado_dia);}
    
                                            if($pagado_dia!=""){$c->add(Tb085PresupuestoPeer::pagado_dia,$pagado_dia);}
    
                                            if($disponible!=""){$c->add(Tb085PresupuestoPeer::disponible,$disponible);}
    
                                        if($cod_ente!=""){$c->add(Tb085PresupuestoPeer::cod_ente,'%'.$cod_ente.'%',Criteria::LIKE);}
        
                                        if($nu_sector!=""){$c->add(Tb085PresupuestoPeer::nu_sector,'%'.$nu_sector.'%',Criteria::LIKE);}
        
                                            if($id_tb139_aplicacion!=""){$c->add(Tb085PresupuestoPeer::id_tb139_aplicacion,$id_tb139_aplicacion);}
    
                                            if($mo_admon_ant!=""){$c->add(Tb085PresupuestoPeer::mo_admon_ant,$mo_admon_ant);}
    
                                            if($mo_modificado_admon!=""){$c->add(Tb085PresupuestoPeer::mo_modificado_admon,$mo_modificado_admon);}
    
                                            if($co_clasificacion_economica!=""){$c->add(Tb085PresupuestoPeer::co_clasificacion_economica,$co_clasificacion_economica);}
    
                                            if($co_area_estrategica!=""){$c->add(Tb085PresupuestoPeer::co_area_estrategica,$co_area_estrategica);}
    
                                            if($mo_inicial_soberano!=""){$c->add(Tb085PresupuestoPeer::mo_inicial_soberano,$mo_inicial_soberano);}
    
                                            if($mo_actualizado_soberano!=""){$c->add(Tb085PresupuestoPeer::mo_actualizado_soberano,$mo_actualizado_soberano);}
    
                                            if($mo_comprometido_soberano!=""){$c->add(Tb085PresupuestoPeer::mo_comprometido_soberano,$mo_comprometido_soberano);}
    
                                            if($mo_causado_soberano!=""){$c->add(Tb085PresupuestoPeer::mo_causado_soberano,$mo_causado_soberano);}
    
                                            if($mo_pagado_soberano!=""){$c->add(Tb085PresupuestoPeer::mo_pagado_soberano,$mo_pagado_soberano);}
    
                                            if($mo_disponible_soberano!=""){$c->add(Tb085PresupuestoPeer::mo_disponible_soberano,$mo_disponible_soberano);}
    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb085PresupuestoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb085PresupuestoPeer::ID);
        
    $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "id_tb084_accion_especifica"     => trim($res["id_tb084_accion_especifica"]),
            "nu_partida"     => trim($res["nu_partida"]),
            "de_partida"     => trim($res["de_partida"]),
            "mo_inicial"     => trim($res["mo_inicial"]),
            "mo_actualizado"     => trim($res["mo_actualizado"]),
            "mo_precomprometido"     => trim($res["mo_precomprometido"]),
            "mo_comprometido"     => trim($res["mo_comprometido"]),
            "mo_causado"     => trim($res["mo_causado"]),
            "mo_pagado"     => trim($res["mo_pagado"]),
            "mo_disponible"     => trim($res["mo_disponible"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "in_movimiento"     => trim($res["in_movimiento"]),
            "nu_pa"     => trim($res["nu_pa"]),
            "nu_ge"     => trim($res["nu_ge"]),
            "nu_es"     => trim($res["nu_es"]),
            "nu_se"     => trim($res["nu_se"]),
            "nu_sse"     => trim($res["nu_sse"]),
            "co_partida"     => trim($res["co_partida"]),
            "nu_nivel"     => trim($res["nu_nivel"]),
            "nu_fi"     => trim($res["nu_fi"]),
            "co_categoria"     => trim($res["co_categoria"]),
            "nu_aplicacion"     => trim($res["nu_aplicacion"]),
            "tp_ingreso"     => trim($res["tp_ingreso"]),
            "co_cuenta_contable"     => trim($res["co_cuenta_contable"]),
            "tip_apl"     => trim($res["tip_apl"]),
            "in_gen_cheque"     => trim($res["in_gen_cheque"]),
            "tip_gasto"     => trim($res["tip_gasto"]),
            "tip_ing"     => trim($res["tip_ing"]),
            "cod_amb"     => trim($res["cod_amb"]),
            "co_ente"     => trim($res["co_ente"]),
            "nu_anio"     => trim($res["nu_anio"]),
            "mo_disponible_act"     => trim($res["mo_disponible_act"]),
            "mo_aumento"     => trim($res["mo_aumento"]),
            "mo_disminucion"     => trim($res["mo_disminucion"]),
            "mo_admon"     => trim($res["mo_admon"]),
            "mo_actualizado_ant"     => trim($res["mo_actualizado_ant"]),
            "comprometido_dia"     => trim($res["comprometido_dia"]),
            "causado_dia"     => trim($res["causado_dia"]),
            "pagado_dia"     => trim($res["pagado_dia"]),
            "disponible"     => trim($res["disponible"]),
            "cod_ente"     => trim($res["cod_ente"]),
            "nu_sector"     => trim($res["nu_sector"]),
            "id_tb139_aplicacion"     => trim($res["id_tb139_aplicacion"]),
            "mo_admon_ant"     => trim($res["mo_admon_ant"]),
            "mo_modificado_admon"     => trim($res["mo_modificado_admon"]),
            "co_clasificacion_economica"     => trim($res["co_clasificacion_economica"]),
            "co_area_estrategica"     => trim($res["co_area_estrategica"]),
            "mo_inicial_soberano"     => trim($res["mo_inicial_soberano"]),
            "mo_actualizado_soberano"     => trim($res["mo_actualizado_soberano"]),
            "mo_comprometido_soberano"     => trim($res["mo_comprometido_soberano"]),
            "mo_causado_soberano"     => trim($res["mo_causado_soberano"]),
            "mo_pagado_soberano"     => trim($res["mo_pagado_soberano"]),
            "mo_disponible_soberano"     => trim($res["mo_disponible_soberano"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb084_accion_especifica.ID
    public function executeStorefkidtb084accionespecifica(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb084AccionEspecificaPeer::doSelectStmt($c);
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            //modelo fk tb184_clasificacion_economica.CO_CLASIFICACION_ECONOMICA
    public function executeStorefkcoclasificacioneconomica(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb184ClasificacionEconomicaPeer::doSelectStmt($c);
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