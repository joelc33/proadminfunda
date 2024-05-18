<?php

/**
 * autoPresupuestoIngreso actions.
 * NombreClaseModel(Tb064PresupuestoIngreso)
 * NombreTabla(tb064_presupuesto_ingreso)
 * @package    ##PROJECT_NAME##
 * @subpackage autoPresupuestoIngreso
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoPresupuestoIngresoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('PresupuestoIngreso', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('PresupuestoIngreso', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO,$codigo);
        
        $stmt = Tb064PresupuestoIngresoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_presupuesto_ingreso"     => $campos["co_presupuesto_ingreso"],
                            "nu_partida"     => $campos["nu_partida"],
                            "tx_partida"     => $campos["tx_partida"],
                            "tx_descripcion"     => $campos["tx_descripcion"],
                            "mo_inicial"     => $campos["mo_inicial"],
                            "mo_actualizado"     => $campos["mo_actualizado"],
                            "nu_anio"     => $campos["nu_anio"],
                            "mo_comprometido"     => $campos["mo_comprometido"],
                            "mo_causado"     => $campos["mo_causado"],
                            "mo_pagado"     => $campos["mo_pagado"],
                            "mo_disponible"     => $campos["mo_disponible"],
                            "nu_nivel"     => $campos["nu_nivel"],
                            "do_cat"     => $campos["do_cat"],
                            "tip_apl"     => $campos["tip_apl"],
                            "tip_gas"     => $campos["tip_gas"],
                            "mo_comprometido_dia"     => $campos["mo_comprometido_dia"],
                            "nu_pa"     => $campos["nu_pa"],
                            "nu_ge"     => $campos["nu_ge"],
                            "nu_es"     => $campos["nu_es"],
                            "nu_se"     => $campos["nu_se"],
                            "nu_sse"     => $campos["nu_sse"],
                            "co_cuenta_contable"     => $campos["co_cuenta_contable"],
                            "in_movimiento"     => $campos["in_movimiento"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_presupuesto_ingreso"     => "",
                            "nu_partida"     => "",
                            "tx_partida"     => "",
                            "tx_descripcion"     => "",
                            "mo_inicial"     => "",
                            "mo_actualizado"     => "",
                            "nu_anio"     => "",
                            "mo_comprometido"     => "",
                            "mo_causado"     => "",
                            "mo_pagado"     => "",
                            "mo_disponible"     => "",
                            "nu_nivel"     => "",
                            "do_cat"     => "",
                            "tip_apl"     => "",
                            "tip_gas"     => "",
                            "mo_comprometido_dia"     => "",
                            "nu_pa"     => "",
                            "nu_ge"     => "",
                            "nu_es"     => "",
                            "nu_se"     => "",
                            "nu_sse"     => "",
                            "co_cuenta_contable"     => "",
                            "in_movimiento"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_presupuesto_ingreso");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb064_presupuesto_ingreso = Tb064PresupuestoIngresoPeer::retrieveByPk($codigo);
     }else{
         $tb064_presupuesto_ingreso = new Tb064PresupuestoIngreso();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb064_presupuesto_ingresoForm = $this->getRequestParameter('tb064_presupuesto_ingreso');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb064_presupuesto_ingreso->setNuPartida($tb064_presupuesto_ingresoForm["nu_partida"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb064_presupuesto_ingreso->setTxPartida($tb064_presupuesto_ingresoForm["tx_partida"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb064_presupuesto_ingreso->setTxDescripcion($tb064_presupuesto_ingresoForm["tx_descripcion"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb064_presupuesto_ingreso->setMoInicial($tb064_presupuesto_ingresoForm["mo_inicial"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb064_presupuesto_ingreso->setMoActualizado($tb064_presupuesto_ingresoForm["mo_actualizado"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb064_presupuesto_ingreso->setNuAnio($tb064_presupuesto_ingresoForm["nu_anio"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb064_presupuesto_ingreso->setMoComprometido($tb064_presupuesto_ingresoForm["mo_comprometido"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb064_presupuesto_ingreso->setMoCausado($tb064_presupuesto_ingresoForm["mo_causado"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb064_presupuesto_ingreso->setMoPagado($tb064_presupuesto_ingresoForm["mo_pagado"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb064_presupuesto_ingreso->setMoDisponible($tb064_presupuesto_ingresoForm["mo_disponible"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb064_presupuesto_ingreso->setNuNivel($tb064_presupuesto_ingresoForm["nu_nivel"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb064_presupuesto_ingreso->setDoCat($tb064_presupuesto_ingresoForm["do_cat"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb064_presupuesto_ingreso->setTipApl($tb064_presupuesto_ingresoForm["tip_apl"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb064_presupuesto_ingreso->setTipGas($tb064_presupuesto_ingresoForm["tip_gas"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb064_presupuesto_ingreso->setMoComprometidoDia($tb064_presupuesto_ingresoForm["mo_comprometido_dia"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb064_presupuesto_ingreso->setNuPa($tb064_presupuesto_ingresoForm["nu_pa"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb064_presupuesto_ingreso->setNuGe($tb064_presupuesto_ingresoForm["nu_ge"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb064_presupuesto_ingreso->setNuEs($tb064_presupuesto_ingresoForm["nu_es"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb064_presupuesto_ingreso->setNuSe($tb064_presupuesto_ingresoForm["nu_se"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb064_presupuesto_ingreso->setNuSse($tb064_presupuesto_ingresoForm["nu_sse"]);
                                                        
        /*Campo tipo BIGINT */
        $tb064_presupuesto_ingreso->setCoCuentaContable($tb064_presupuesto_ingresoForm["co_cuenta_contable"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_movimiento", $tb064_presupuesto_ingresoForm)){
            $tb064_presupuesto_ingreso->setInMovimiento(false);
        }else{
            $tb064_presupuesto_ingreso->setInMovimiento(true);
        }
                                
        /*CAMPOS*/
        $tb064_presupuesto_ingreso->save($con);
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
	$codigo = $this->getRequestParameter("co_presupuesto_ingreso");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb064_presupuesto_ingreso = Tb064PresupuestoIngresoPeer::retrieveByPk($codigo);			
	$tb064_presupuesto_ingreso->delete($con);
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
                $nu_partida      =   $this->getRequestParameter("nu_partida");
            $tx_partida      =   $this->getRequestParameter("tx_partida");
            $tx_descripcion      =   $this->getRequestParameter("tx_descripcion");
            $mo_inicial      =   $this->getRequestParameter("mo_inicial");
            $mo_actualizado      =   $this->getRequestParameter("mo_actualizado");
            $nu_anio      =   $this->getRequestParameter("nu_anio");
            $mo_comprometido      =   $this->getRequestParameter("mo_comprometido");
            $mo_causado      =   $this->getRequestParameter("mo_causado");
            $mo_pagado      =   $this->getRequestParameter("mo_pagado");
            $mo_disponible      =   $this->getRequestParameter("mo_disponible");
            $nu_nivel      =   $this->getRequestParameter("nu_nivel");
            $do_cat      =   $this->getRequestParameter("do_cat");
            $tip_apl      =   $this->getRequestParameter("tip_apl");
            $tip_gas      =   $this->getRequestParameter("tip_gas");
            $mo_comprometido_dia      =   $this->getRequestParameter("mo_comprometido_dia");
            $nu_pa      =   $this->getRequestParameter("nu_pa");
            $nu_ge      =   $this->getRequestParameter("nu_ge");
            $nu_es      =   $this->getRequestParameter("nu_es");
            $nu_se      =   $this->getRequestParameter("nu_se");
            $nu_sse      =   $this->getRequestParameter("nu_sse");
            $co_cuenta_contable      =   $this->getRequestParameter("co_cuenta_contable");
            $in_movimiento      =   $this->getRequestParameter("in_movimiento");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($nu_partida!=""){$c->add(Tb064PresupuestoIngresoPeer::nu_partida,'%'.$nu_partida.'%',Criteria::LIKE);}
        
                                        if($tx_partida!=""){$c->add(Tb064PresupuestoIngresoPeer::tx_partida,'%'.$tx_partida.'%',Criteria::LIKE);}
        
                                        if($tx_descripcion!=""){$c->add(Tb064PresupuestoIngresoPeer::tx_descripcion,'%'.$tx_descripcion.'%',Criteria::LIKE);}
        
                                            if($mo_inicial!=""){$c->add(Tb064PresupuestoIngresoPeer::mo_inicial,$mo_inicial);}
    
                                            if($mo_actualizado!=""){$c->add(Tb064PresupuestoIngresoPeer::mo_actualizado,$mo_actualizado);}
    
                                            if($nu_anio!=""){$c->add(Tb064PresupuestoIngresoPeer::nu_anio,$nu_anio);}
    
                                            if($mo_comprometido!=""){$c->add(Tb064PresupuestoIngresoPeer::mo_comprometido,$mo_comprometido);}
    
                                            if($mo_causado!=""){$c->add(Tb064PresupuestoIngresoPeer::mo_causado,$mo_causado);}
    
                                            if($mo_pagado!=""){$c->add(Tb064PresupuestoIngresoPeer::mo_pagado,$mo_pagado);}
    
                                            if($mo_disponible!=""){$c->add(Tb064PresupuestoIngresoPeer::mo_disponible,$mo_disponible);}
    
                                            if($nu_nivel!=""){$c->add(Tb064PresupuestoIngresoPeer::nu_nivel,$nu_nivel);}
    
                                        if($do_cat!=""){$c->add(Tb064PresupuestoIngresoPeer::do_cat,'%'.$do_cat.'%',Criteria::LIKE);}
        
                                        if($tip_apl!=""){$c->add(Tb064PresupuestoIngresoPeer::tip_apl,'%'.$tip_apl.'%',Criteria::LIKE);}
        
                                        if($tip_gas!=""){$c->add(Tb064PresupuestoIngresoPeer::tip_gas,'%'.$tip_gas.'%',Criteria::LIKE);}
        
                                            if($mo_comprometido_dia!=""){$c->add(Tb064PresupuestoIngresoPeer::mo_comprometido_dia,$mo_comprometido_dia);}
    
                                        if($nu_pa!=""){$c->add(Tb064PresupuestoIngresoPeer::nu_pa,'%'.$nu_pa.'%',Criteria::LIKE);}
        
                                        if($nu_ge!=""){$c->add(Tb064PresupuestoIngresoPeer::nu_ge,'%'.$nu_ge.'%',Criteria::LIKE);}
        
                                        if($nu_es!=""){$c->add(Tb064PresupuestoIngresoPeer::nu_es,'%'.$nu_es.'%',Criteria::LIKE);}
        
                                        if($nu_se!=""){$c->add(Tb064PresupuestoIngresoPeer::nu_se,'%'.$nu_se.'%',Criteria::LIKE);}
        
                                        if($nu_sse!=""){$c->add(Tb064PresupuestoIngresoPeer::nu_sse,'%'.$nu_sse.'%',Criteria::LIKE);}
        
                                            if($co_cuenta_contable!=""){$c->add(Tb064PresupuestoIngresoPeer::co_cuenta_contable,$co_cuenta_contable);}
    
                                    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb064PresupuestoIngresoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO);
        
    $stmt = Tb064PresupuestoIngresoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_presupuesto_ingreso"     => trim($res["co_presupuesto_ingreso"]),
            "nu_partida"     => trim($res["nu_partida"]),
            "tx_partida"     => trim($res["tx_partida"]),
            "tx_descripcion"     => trim($res["tx_descripcion"]),
            "mo_inicial"     => trim($res["mo_inicial"]),
            "mo_actualizado"     => trim($res["mo_actualizado"]),
            "nu_anio"     => trim($res["nu_anio"]),
            "mo_comprometido"     => trim($res["mo_comprometido"]),
            "mo_causado"     => trim($res["mo_causado"]),
            "mo_pagado"     => trim($res["mo_pagado"]),
            "mo_disponible"     => trim($res["mo_disponible"]),
            "nu_nivel"     => trim($res["nu_nivel"]),
            "do_cat"     => trim($res["do_cat"]),
            "tip_apl"     => trim($res["tip_apl"]),
            "tip_gas"     => trim($res["tip_gas"]),
            "mo_comprometido_dia"     => trim($res["mo_comprometido_dia"]),
            "nu_pa"     => trim($res["nu_pa"]),
            "nu_ge"     => trim($res["nu_ge"]),
            "nu_es"     => trim($res["nu_es"]),
            "nu_se"     => trim($res["nu_se"]),
            "nu_sse"     => trim($res["nu_sse"]),
            "co_cuenta_contable"     => trim($res["co_cuenta_contable"]),
            "in_movimiento"     => trim($res["in_movimiento"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                                                                                                                                                                                                                                


}