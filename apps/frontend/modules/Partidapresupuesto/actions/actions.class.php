<?php

/**
 * Partidapresupuesto actions.
 *
 * @package    gobel
 * @subpackage Partidapresupuesto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class PartidapresupuestoActions extends sfActions
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
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb084_accion_especifica"     => $this->getRequestParameter("id_tb084_accion_especifica"),
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
        $tb085_presupuesto->setNuPartida($tb085_presupuestoForm["nu_partida"].$tb085_presupuestoForm["nu_sse"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setDePartida($tb085_presupuestoForm["de_partida"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoInicial(0);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoActualizado(0);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoPrecomprometido(0);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoComprometido(0);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoCausado(0);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoPagado(0);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoDisponible(0);
                                                        
        /*Campo tipo BOOLEAN */
        $tb085_presupuesto->setInActivo(true);
                                                        
        /*Campo tipo TIMESTAMP */
                                                        
        /*Campo tipo BOOLEAN */
        $tb085_presupuesto->setInMovimiento(false);
                                                        
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
        $tb085_presupuesto->setCoPartida($tb085_presupuestoForm["co_partida"].$tb085_presupuestoForm["nu_sse"]);
                                                        
        /*Campo tipo BIGINT */
        $tb085_presupuesto->setNuNivel(4);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setNuFi($tb085_presupuestoForm["nu_fi"]);
                                                        
        /*Campo tipo VARCHAR */
        //$tb085_presupuesto->setCoCategoria($tb085_presupuestoForm["co_categoria"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setNuAplicacion($tb085_presupuestoForm["nu_aplicacion"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setTpIngreso($tb085_presupuestoForm["tp_ingreso"]);
                                                        
        /*Campo tipo BIGINT */
        $tb085_presupuesto->setCoCuentaContable($tb085_presupuestoForm["co_cuenta_contable"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setTipApl($tb085_presupuestoForm["tip_apl"]);
                                                        
        /*Campo tipo BOOLEAN */
        $tb085_presupuesto->setInGenCheque(false);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setTipGasto($tb085_presupuestoForm["tip_gasto"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setTipIng($tb085_presupuestoForm["tip_ing"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setCodAmb($tb085_presupuestoForm["cod_amb"]);
                                                        
        /*Campo tipo BIGINT */
        $tb085_presupuesto->setCoEnte($tb085_presupuestoForm["co_ente"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setNuAnio($this->getUser()->getAttribute('ejercicio'));
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoDisponibleAct(0);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoAumento(0);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoDisminucion(0);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoAdmon(0);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setMoActualizadoAnt(0);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setComprometidoDia(0);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setCausadoDia(0);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setPagadoDia(0);
                                                        
        /*Campo tipo NUMERIC */
        $tb085_presupuesto->setDisponible(0);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setCodEnte($tb085_presupuestoForm["cod_ente"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb085_presupuesto->setNuSector($tb085_presupuestoForm["nu_sector"]);
                                                        
        /*Campo tipo BIGINT */
        $tb085_presupuesto->setIdTb139Aplicacion($tb085_presupuestoForm["id_tb139_aplicacion"]);
                                
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
    $this->data = json_encode(array(
        "codigo" => $this->getRequestParameter("codigo")
    ));
  }
  
  public function executeListaDesagregada(sfWebRequest $request)
  {
    $this->data = json_encode(array(
        "nu_partida" => $this->getRequestParameter("nu_partida"),
        "co_accion_especifica" => $this->getRequestParameter("co_accion_especifica"),
        "ejercicio" => $this->getUser()->getAttribute('ejercicio')
    ));
  }

  public function executeListaDesagregadaTodas(sfWebRequest $request)
  {
    $this->data = json_encode(array(
        "nu_partida" => $this->getRequestParameter("nu_partida"),
        "co_accion_especifica" => $this->getRequestParameter("co_accion_especifica"),
        "ejercicio" => $this->getUser()->getAttribute('ejercicio')
    ));
  }
  
  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
    
    $id_tb084_accion_especifica      =   $this->getRequestParameter("codigo");
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


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
            if($id_tb084_accion_especifica!=""){$c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA,$id_tb084_accion_especifica);}

            if($nu_partida!=""){$c->add(Tb085PresupuestoPeer::CO_PARTIDA,'%'.$nu_partida.'%',Criteria::LIKE);}

            if($de_partida!=""){$c->add(Tb085PresupuestoPeer::DE_PARTIDA,'%'.$de_partida.'%',Criteria::LIKE);}

            if($mo_inicial!=""){$c->add(Tb085PresupuestoPeer::MO_INICIAL,$mo_inicial);}

            if($mo_actualizado!=""){$c->add(Tb085PresupuestoPeer::MO_ACTUALIZADO,$mo_actualizado);}

            if($mo_precomprometido!=""){$c->add(Tb085PresupuestoPeer::MO_PRECOMPROMETIDO,$mo_precomprometido);}

            if($mo_comprometido!=""){$c->add(Tb085PresupuestoPeer::MO_COMPROMETIDO,$mo_comprometido);}

            if($mo_causado!=""){$c->add(Tb085PresupuestoPeer::MO_CAUSADO,$mo_causado);}

            if($mo_pagado!=""){$c->add(Tb085PresupuestoPeer::MO_PAGADO,$mo_pagado);}

            if($mo_disponible!=""){$c->add(Tb085PresupuestoPeer::MO_DISPONIBLE,$mo_disponible);}
    }
    
    $c->setIgnoreCase(true);
    $c->clearSelectColumns();
    //$c->addSelectColumn(Tb085PresupuestoPeer::ID);
    $c->addSelectColumn(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA);
    $c->addSelectColumn(Tb085PresupuestoPeer::CO_PARTIDA);
    $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
    $c->addSelectColumn('sum('.Tb085PresupuestoPeer::MO_INICIAL.') as mo_inicial');
    $c->addSelectColumn('sum('.Tb085PresupuestoPeer::MO_ACTUALIZADO.') as mo_actualizado');
    $c->addSelectColumn('sum('.Tb085PresupuestoPeer::MO_PRECOMPROMETIDO.') as mo_precomprometido');
    $c->addSelectColumn('sum('.Tb085PresupuestoPeer::MO_COMPROMETIDO.') as mo_comprometido');
    $c->addSelectColumn('sum('.Tb085PresupuestoPeer::MO_CAUSADO.') as mo_causado');
    $c->addSelectColumn('sum('.Tb085PresupuestoPeer::MO_PAGADO.') as mo_pagado');
    $c->addSelectColumn('sum('.Tb085PresupuestoPeer::MO_DISPONIBLE.') as mo_disponible');
    $c->addSelectColumn(Tb024CuentaContablePeer::TX_CUENTA);
    $c->addSelectColumn(Tb085PresupuestoPeer::NU_NIVEL);
    
   // $c->addGroupByColumn(Tb085PresupuestoPeer::ID);
    $c->addGroupByColumn(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA);
    $c->addGroupByColumn(Tb085PresupuestoPeer::CO_PARTIDA);
    $c->addGroupByColumn(Tb085PresupuestoPeer::DE_PARTIDA);
    $c->addGroupByColumn(Tb024CuentaContablePeer::TX_CUENTA);
    $c->addGroupByColumn(Tb085PresupuestoPeer::NU_NIVEL);
    
    $c->addJoin( Tb085PresupuestoPeer::CO_CUENTA_CONTABLE, Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Criteria::LEFT_JOIN);
    $c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA,$id_tb084_accion_especifica);
    $c->add(Tb085PresupuestoPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));
    //$c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
    //$c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
   // $c->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);
//    $c->add(Tb085PresupuestoPeer::NU_SSE,NULL);
    $cantidadTotal = Tb085PresupuestoPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
       // $c->addAscendingOrderByColumn(Tb085PresupuestoPeer::ID);

    $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "id_tb084_accion_especifica"    => trim($res["id_tb084_accion_especifica"]),
            "nu_partida"                    => trim($res["co_partida"]),
            "de_partida"                    => trim($res["de_partida"]),
            "mo_inicial"                    => trim($res["mo_inicial"]),
            "mo_actualizado"                => trim($res["mo_actualizado"]),
            "mo_precomprometido"            => trim($res["mo_precomprometido"]),
            "mo_comprometido"               => trim($res["mo_comprometido"]),
            "mo_causado"                    => trim($res["mo_causado"]),
            "mo_pagado"                     => trim($res["mo_pagado"]),
            "mo_disponible"                 => trim($res["mo_disponible"]),
            "tx_cuenta"                     => trim($res["tx_cuenta"]),
            "nu_nivel"                      => trim($res["nu_nivel"])
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }
    
    
    
    protected function getDatosPartida($co_partida){
        $c = new Criteria();
        $c->add(Tb091PartidaPeer::ID,$co_partida);
        $stmt = Tb091PartidaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos;
    }
    
    public function executeStorelistaDesagregada(sfWebRequest $request)
    {
            $paginar              =   $this->getRequestParameter("paginar");
            $nu_partida               =   $this->getRequestParameter("nu_partida");
            $co_accion_especifica =   $this->getRequestParameter("co_accion_especifica");
            $limit                =   $this->getRequestParameter("limit",20);
            $start                =   $this->getRequestParameter("start",0);

            $id_tb084_accion_especifica      =   $this->getRequestParameter("codigo");
            $nu_partida                      =   $this->getRequestParameter("nu_partida");
            $de_partida                      =   $this->getRequestParameter("de_partida");
            $mo_inicial                      =   $this->getRequestParameter("mo_inicial");
            $mo_actualizado                  =   $this->getRequestParameter("mo_actualizado");
            $mo_precomprometido              =   $this->getRequestParameter("mo_precomprometido");
            $mo_comprometido                 =   $this->getRequestParameter("mo_comprometido");
            $mo_causado                      =   $this->getRequestParameter("mo_causado");
            $mo_pagado                       =   $this->getRequestParameter("mo_pagado");
            $mo_disponible                   =   $this->getRequestParameter("mo_disponible");
            $in_activo                       =   $this->getRequestParameter("in_activo");
            $created_at                      =   $this->getRequestParameter("created_at");
            $updated_at                      =   $this->getRequestParameter("updated_at");
            $in_movimiento                   =   $this->getRequestParameter("in_movimiento");


            $c = new Criteria();

            if($this->getRequestParameter("BuscarBy")=="true"){
                    if($id_tb084_accion_especifica!=""){$c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA,$id_tb084_accion_especifica);}

                    if($nu_partida!=""){$c->add(Tb085PresupuestoPeer::CO_PARTIDA,'%'.$nu_partida.'%',Criteria::LIKE);}

                    if($de_partida!=""){$c->add(Tb085PresupuestoPeer::DE_PARTIDA,'%'.$de_partida.'%',Criteria::LIKE);}

                    if($mo_inicial!=""){$c->add(Tb085PresupuestoPeer::MO_INICIAL,$mo_inicial);}

                    if($mo_actualizado!=""){$c->add(Tb085PresupuestoPeer::MO_ACTUALIZADO,$mo_actualizado);}

                    if($mo_precomprometido!=""){$c->add(Tb085PresupuestoPeer::MO_PRECOMPROMETIDO,$mo_precomprometido);}

                    if($mo_comprometido!=""){$c->add(Tb085PresupuestoPeer::MO_COMPROMETIDO,$mo_comprometido);}

                    if($mo_causado!=""){$c->add(Tb085PresupuestoPeer::MO_CAUSADO,$mo_causado);}

                    if($mo_pagado!=""){$c->add(Tb085PresupuestoPeer::MO_PAGADO,$mo_pagado);}

                    if($mo_disponible!=""){$c->add(Tb085PresupuestoPeer::MO_DISPONIBLE,$mo_disponible);}
            }

            $datos_partida = $this->getDatosPartida($codigo);
            
            $c->setIgnoreCase(true);
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb085PresupuestoPeer::ID);
            $c->addSelectColumn(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA);
            $c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
            $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_INICIAL);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_ACTUALIZADO);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_PRECOMPROMETIDO);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_COMPROMETIDO);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_CAUSADO);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_PAGADO);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
            $c->addSelectColumn(Tb024CuentaContablePeer::TX_CUENTA);
            $c->addSelectColumn(Tb085PresupuestoPeer::NU_NIVEL);
            $c->addSelectColumn(Tb139AplicacionPeer::TX_TIP_APLICACION);
            $c->addSelectColumn(Tb139AplicacionPeer::TX_APLICACION);

            
            $c->addJoin(Tb139AplicacionPeer::TX_TIP_APLICACION, Tb085PresupuestoPeer::TIP_APL);
            $c->addJoin(Tb085PresupuestoPeer::CO_CUENTA_CONTABLE, Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Criteria::LEFT_JOIN);
            $c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA,$id_tb084_accion_especifica);
            $c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA,$co_accion_especifica);  
            $c->add(Tb085PresupuestoPeer::CO_PARTIDA,$nu_partida);
            
            $c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
            //$c->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);
            $c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
            
            
            $cantidadTotal = Tb085PresupuestoPeer::doCount($c);

            $c->setLimit($limit)->setOffset($start);
                $c->addAscendingOrderByColumn(Tb085PresupuestoPeer::ID);

            $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
            $registros = "";
            while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = array(
                    "id"     => trim($res["id"]),
                    "id_tb084_accion_especifica"    => trim($res["id_tb084_accion_especifica"]),
                    "nu_partida"                    => trim($res["nu_partida"]),
                    "de_partida"                    => trim($res["de_partida"]),
                    "mo_inicial"                    => trim($res["mo_inicial"]),
                    "mo_actualizado"                => trim($res["mo_actualizado"]),
                    "mo_precomprometido"            => trim($res["mo_precomprometido"]),
                    "mo_comprometido"               => trim($res["mo_comprometido"]),
                    "mo_causado"                    => trim($res["mo_causado"]),
                    "mo_pagado"                     => trim($res["mo_pagado"]),
                    "mo_disponible"                 => trim($res["mo_disponible"]),
                    "tx_cuenta"                     => trim($res["tx_cuenta"]),
                    "nu_nivel"                      => trim($res["nu_nivel"]),
                    "aplicacion"                    => $res["tx_tip_aplicacion"].'-'.$res["tx_aplicacion"]
                );
            }

            $this->data = json_encode(array(
                "success"   =>  true,
                "total"     =>  $cantidadTotal,
                "data"      =>  $registros
                ));
            
           $this->setTemplate('store');
    }
    
      public function executeStorelistaDesagregadaTodas(sfWebRequest $request)
    {
            $paginar              =   $this->getRequestParameter("paginar");
            $nu_partida               =   $this->getRequestParameter("nu_partida");
            $co_accion_especifica =   $this->getRequestParameter("co_accion_especifica");
            $limit                =   $this->getRequestParameter("limit",20);
            $start                =   $this->getRequestParameter("start",0);

            $id_tb084_accion_especifica      =   $this->getRequestParameter("codigo");
            $nu_partida                      =   $this->getRequestParameter("nu_partida");
            $de_partida                      =   $this->getRequestParameter("de_partida");
            $mo_inicial                      =   $this->getRequestParameter("mo_inicial");
            $mo_actualizado                  =   $this->getRequestParameter("mo_actualizado");
            $mo_precomprometido              =   $this->getRequestParameter("mo_precomprometido");
            $mo_comprometido                 =   $this->getRequestParameter("mo_comprometido");
            $mo_causado                      =   $this->getRequestParameter("mo_causado");
            $mo_pagado                       =   $this->getRequestParameter("mo_pagado");
            $mo_disponible                   =   $this->getRequestParameter("mo_disponible");
            $in_activo                       =   $this->getRequestParameter("in_activo");
            $created_at                      =   $this->getRequestParameter("created_at");
            $updated_at                      =   $this->getRequestParameter("updated_at");
            $in_movimiento                   =   $this->getRequestParameter("in_movimiento");

            $co_ejecutor = $this->getRequestParameter("co_ejecutor");
            $co_accion   = $this->getRequestParameter("co_accion");
            $co_proyecto = $this->getRequestParameter("co_proyecto");

            $tip_apl = $this->getRequestParameter("tip_apl");
            $nu_fi = $this->getRequestParameter("nu_fi");
            $monto       = $this->getRequestParameter("monto");

            $c = new Criteria();

            if($this->getRequestParameter("BuscarBy")=="true"){
                    if($id_tb084_accion_especifica!=""){$c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA,$id_tb084_accion_especifica);}

                    if($nu_partida!=""){$c->add(Tb085PresupuestoPeer::CO_CATEGORIA,'%'.$nu_partida.'%',Criteria::LIKE);}

                    if($de_partida!=""){$c->add(Tb085PresupuestoPeer::DE_PARTIDA,'%'.$de_partida.'%',Criteria::LIKE);}

                    if($mo_inicial!=""){$c->add(Tb085PresupuestoPeer::MO_INICIAL,$mo_inicial);}

                    if($mo_actualizado!=""){$c->add(Tb085PresupuestoPeer::MO_ACTUALIZADO,$mo_actualizado);}

                    if($mo_precomprometido!=""){$c->add(Tb085PresupuestoPeer::MO_PRECOMPROMETIDO,$mo_precomprometido);}

                    if($mo_comprometido!=""){$c->add(Tb085PresupuestoPeer::MO_COMPROMETIDO,$mo_comprometido);}

                    if($mo_causado!=""){$c->add(Tb085PresupuestoPeer::MO_CAUSADO,$mo_causado);}

                    if($mo_pagado!=""){$c->add(Tb085PresupuestoPeer::MO_PAGADO,$mo_pagado);}

                    if($mo_disponible!=""){$c->add(Tb085PresupuestoPeer::MO_DISPONIBLE,$mo_disponible);}

                    if($co_accion!=""){$c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA,$co_accion);}

                    if($co_proyecto!=""){$c->add(Tb084AccionEspecificaPeer::ID_TB083_PROYECTO_AC,$co_proyecto);}
            }

//            $datos_partida = $this->getDatosPartida($codigo);
            
            $c->setIgnoreCase(true);
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb085PresupuestoPeer::ID);
            $c->addSelectColumn(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA);
            $c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
            $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_INICIAL);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_ACTUALIZADO);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_PRECOMPROMETIDO);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_AUMENTO);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISMINUCION);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_COMPROMETIDO);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_CAUSADO);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_PAGADO);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
            $c->addSelectColumn(Tb085PresupuestoPeer::CO_CATEGORIA);
            $c->addSelectColumn(Tb085PresupuestoPeer::TIP_APL);
            $c->addSelectColumn(Tb139AplicacionPeer::TX_APLICACION);

            $c->addJoin(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA, Tb084AccionEspecificaPeer::ID);
            $c->addJoin(Tb084AccionEspecificaPeer::ID_TB083_PROYECTO_AC, Tb083ProyectoAcPeer::ID);
            $c->addJoin(Tb083ProyectoAcPeer::ID, Tb084AccionEspecificaPeer::ID_TB083_PROYECTO_AC);
            $c->addJoin(Tb085PresupuestoPeer::ID_TB139_APLICACION, Tb139AplicacionPeer::CO_APLICACION, Criteria::LEFT_JOIN);

            $c->add(Tb085PresupuestoPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));
            
            //$c->add(Tb085PresupuestoPeer::NU_FI,'', Criteria::NOT_EQUAL);
            
            if($co_ejecutor!=''){
                $c->add(Tb083ProyectoAcPeer::ID_TB082_EJECUTOR,$co_ejecutor);
            }
            
            if($monto!=''){
                $c->add(Tb085PresupuestoPeer::MO_DISPONIBLE,$monto, Criteria::GREATER_EQUAL);
            }
            
            if($tip_apl!=''){
                //$c->add(Tb139AplicacionPeer::CO_APLICACION,$tip_apl);
                $c->add(Tb085PresupuestoPeer::ID_TB139_APLICACION,$tip_apl);
            }      
            
            if($nu_fi!=''){
                $c->add(Tb085PresupuestoPeer::NU_FI,$nu_fi);
            }             
            
//            $c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA,$id_tb084_accion_especifica);
//            $c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA,$co_accion_especifica);  
//            $c->add(Tb085PresupuestoPeer::CO_PARTIDA,$nu_partida);
            
            
            
            $cantidadTotal = Tb085PresupuestoPeer::doCount($c);

            $c->setLimit($limit)->setOffset($start);
                $c->addAscendingOrderByColumn(Tb085PresupuestoPeer::ID);

            $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
            $registros = "";
            while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = array(
                    "id"     => trim($res["id"]),
                    "id_tb084_accion_especifica"    => trim($res["id_tb084_accion_especifica"]),
                    //"nu_partida"                    => trim($res["nu_sector"].'.'.$res["nu_proyecto_ac"].'.00.'.$res["nu_accion_especifica"].'.'.Tb085PresupuestoPeer::mascaraNomina($res["nu_partida"])),
                    "nu_partida"                    => trim($res["co_categoria"]),
                    "de_partida"                    => trim($res["de_partida"]),
                    "mo_inicial"                    => trim($res["mo_inicial"]),
                    "mo_actualizado"                => trim($res["mo_actualizado"]),
                    "mo_precomprometido"            => trim($res["mo_precomprometido"]),
                    "mo_comprometido"               => trim($res["mo_comprometido"]),
                    "mo_aumento"                    => trim($res["mo_aumento"]),
                    "mo_disminucion"                => trim($res["mo_disminucion"]),
                    "mo_causado"                    => trim($res["mo_causado"]),
                    "mo_pagado"                     => trim($res["mo_pagado"]),
                    "mo_disponible"                 => trim($res["mo_disponible"]),
                    "tx_cuenta"                     => trim($res["tx_cuenta"]),
                    "nu_nivel"                      => trim($res["nu_nivel"]),
                    "aplicacion"                    => trim($res["tip_apl"].' - '.$res["tx_aplicacion"]),
                );
            }

            $this->data = json_encode(array(
                "success"   =>  true,
                "total"     =>  $cantidadTotal,
                "data"      =>  $registros
                ));
            
           $this->setTemplate('store');
    }

    
    public function executeStorefkcoaplicacion(sfWebRequest $request){

        $co_ejecutor = $this->getRequestParameter("co_ejecutor");
        $c = new Criteria();
        $c->setIgnoreCase(true);
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb139AplicacionPeer::CO_APLICACION);
        $c->addSelectColumn(Tb139AplicacionPeer::TX_TIP_APLICACION);
        $c->addSelectColumn(Tb139AplicacionPeer::NU_ANIO_FISCAL);
        $c->addSelectColumn(Tb139AplicacionPeer::TX_APLICACION);
        $c->add(Tb085PresupuestoPeer::CO_ENTE, $co_ejecutor);
        $c->addJoin(Tb139AplicacionPeer::TX_TIP_APLICACION, Tb085PresupuestoPeer::TIP_APL);
        $c->add(Tb139AplicacionPeer::NU_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));

        $c->addGroupByColumn(Tb139AplicacionPeer::CO_APLICACION);
        $c->addGroupByColumn(Tb139AplicacionPeer::TX_TIP_APLICACION);
        $c->addGroupByColumn(Tb139AplicacionPeer::NU_ANIO_FISCAL);
        $c->addGroupByColumn(Tb139AplicacionPeer::TX_APLICACION);
        $c->addAscendingOrderByColumn(Tb139AplicacionPeer::TX_TIP_APLICACION);

        //echo $c->toString(); exit();
        $stmt = Tb139AplicacionPeer::doSelectStmt($c);
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

    public function executeStorefkcoaplicacionTodo(sfWebRequest $request){

        $c = new Criteria();
        $c->setIgnoreCase(true);
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb139AplicacionPeer::CO_APLICACION);
        $c->addSelectColumn(Tb139AplicacionPeer::TX_TIP_APLICACION);
        $c->addSelectColumn(Tb139AplicacionPeer::NU_ANIO_FISCAL);
        $c->addSelectColumn(Tb139AplicacionPeer::TX_APLICACION);
        $c->add(Tb139AplicacionPeer::NU_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
        $c->addAscendingOrderByColumn(Tb139AplicacionPeer::TX_TIP_APLICACION);
        $stmt = Tb139AplicacionPeer::doSelectStmt($c);
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

    public function executeStorefkcodecreto(sfWebRequest $request){

        $co_ejecutor = $this->getRequestParameter("co_ejecutor");
        $aplicacion = $this->getRequestParameter("aplicacion");
        
        $c = new Criteria();
        
            if($co_ejecutor!=''){
                $c->add(Tb085PresupuestoPeer::CO_ENTE, $co_ejecutor);
            }   
            
            if($aplicacion!=''){
                $c->add(Tb139AplicacionPeer::CO_APLICACION, $aplicacion);
            }   
            
        $c->addSelectColumn(Tb085PresupuestoPeer::NU_FI);
        $c->add(Tb085PresupuestoPeer::NU_FI, NULL, Criteria::ISNOTNULL);
        $c->add(Tb085PresupuestoPeer::NU_FI, '', Criteria::NOT_IN);
        $c->addJoin(Tb139AplicacionPeer::TX_TIP_APLICACION, Tb085PresupuestoPeer::TIP_APL);
        $c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
        $c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
        //$c->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);
        
        $c->addGroupByColumn(Tb085PresupuestoPeer::NU_FI);
        $c->addAscendingOrderByColumn(Tb085PresupuestoPeer::NU_FI);
        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
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
    
    
    
     public function executeStorefkTipoGasto(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb183TipoGastoPeer::doSelectStmt($c);
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
    
     public function executeStorefkClasificacionEconomica(sfWebRequest $request){
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
    
     public function executeStorefkAmbito(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb138AmbitoPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));
        $stmt = Tb138AmbitoPeer::doSelectStmt($c);
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

     public function executeStorefkAreaEstrategica(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb185AreaEstrategicaPeer::doSelectStmt($c);
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
    
    public function executeEditarAplicacion(sfWebRequest $request)
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
                              "tipo_gasto"     => $campos["tip_gasto"],
                              "id_tb139_aplicacion"     => $campos["id_tb139_aplicacion"],
                              "co_clasificacion_economica"     => $campos["co_clasificacion_economica"],
                              "co_ambito"     => $campos["cod_amb"],
                              "co_area_estrategica"     => $campos["co_area_estrategica"],
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
                              "co_clasificacion_economica"     => "",
                              "co_ambito"     => "",
                              "co_area_estrategica"     => "",
                      ));
      }
  
    }

    public function executeGuardarAplicacion(sfWebRequest $request)
    {
  
       $codigo = $this->getRequestParameter("id");
          
       $con = Propel::getConnection();

           $tb085_presupuesto = Tb085PresupuestoPeer::retrieveByPk($codigo);
       try
        { 
          $con->beginTransaction();
         
          $tb085_presupuestoForm = $this->getRequestParameter('tb085_presupuesto');
        /*CAMPOS*/                                    
          /*Campo tipo VARCHAR */
          $tb085_presupuesto->setTipApl($tb085_presupuestoForm["de_aplicacion"]);
          $tb085_presupuesto->setTipGasto($tb085_presupuestoForm["tipo_gasto"]);
                                                          
          /*Campo tipo BIGINT */
          $tb085_presupuesto->setIdTb139Aplicacion($tb085_presupuestoForm["id_tb139_aplicacion"]);
          $tb085_presupuesto->setCoClasificacionEconomica($tb085_presupuestoForm["co_clasificacion_economica"]);
          $tb085_presupuesto->setCodAmb($tb085_presupuestoForm["co_ambito"]);
          $tb085_presupuesto->setCoAreaEstrategica($tb085_presupuestoForm["co_area_estrategica"]);
                                  
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

}
