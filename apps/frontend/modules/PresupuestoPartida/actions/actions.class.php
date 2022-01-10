<?php

/**
 * autoPresupuestoPartida actions.
 * NombreClaseModel(Tb085Presupuesto)
 * NombreTabla(tb085_presupuesto)
 * @package    ##PROJECT_NAME##
 * @subpackage autoPresupuestoPartida
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class PresupuestoPartidaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('PresupuestoPartida', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('PresupuestoPartida', 'editar');
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
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb084_accion_especifica"     => $this->getRequestParameter("co_accion_especifica"),
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
                    ));
    }

  }
  
  protected function getDatosPartida($co_partida){
        $c = new Criteria();
        $c->add(Tb091PartidaPeer::ID,$co_partida);
        $stmt = Tb091PartidaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos;
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
        
        $datos_partida = $this->getDatosPartida($tb085_presupuestoForm["co_partida"]);
        
//        echo var_dump($datos_partida); exit();
        
        $tb085_presupuesto->setIdTb084AccionEspecifica($tb085_presupuestoForm["id_tb084_accion_especifica"]);
        $tb085_presupuesto->setNuPartida($datos_partida["nu_partida"]);
        $tb085_presupuesto->setDePartida($datos_partida["de_partida"]);
        $tb085_presupuesto->setMoInicial($tb085_presupuestoForm["mo_inicial"]);                                                        
        $tb085_presupuesto->setMoPagado($tb085_presupuestoForm["mo_pagado"]);
        $tb085_presupuesto->setMoActualizado(0);
        $tb085_presupuesto->setMoPrecomprometido(0);
        $tb085_presupuesto->setMoComprometido(0);
        $tb085_presupuesto->setMoCausado(0);
        $tb085_presupuesto->setMoDisponible($tb085_presupuestoForm["mo_disponible"]);
        $tb085_presupuesto->setInActivo(true);
        $tb085_presupuesto->setInMovimiento(true);
        $tb085_presupuesto->setNuPa($datos_partida["nu_pa"]);
        $tb085_presupuesto->setNuGe($datos_partida["nu_ge"]);
        $tb085_presupuesto->setNuEs($datos_partida["nu_es"]);
        $tb085_presupuesto->setNuSe($datos_partida["nu_se"]);
        $tb085_presupuesto->setCoPartida($datos_partida["co_partida"]);
        $tb085_presupuesto->setNuNivel(4);
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
    
                    }
    $c->setIgnoreCase(true);
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
          
    public function executeStorefkcopartida(sfWebRequest $request){
             
        $c = new Criteria();
        $c->addSelectColumn(Tb091PartidaPeer::ID);
        $c->addSelectColumn(Tb091PartidaPeer::NU_PARTIDA);
        $c->addSelectColumn(Tb091PartidaPeer::DE_PARTIDA);
        $c->add(Tb091PartidaPeer::NU_NIVEL,4);
      
        $stmt = Tb091PartidaPeer::doSelectStmt($c);
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