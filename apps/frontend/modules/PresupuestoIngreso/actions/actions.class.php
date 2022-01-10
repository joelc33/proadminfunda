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
class PresupuestoIngresoActions extends sfActions
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
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                if($nu_partida!=""){$c->add(Tb064PresupuestoIngresoPeer::nu_partida,'%'.$nu_partida.'%',Criteria::LIKE);}

                if($tx_partida!=""){$c->add(Tb064PresupuestoIngresoPeer::TX_PARTIDA,'%'.$tx_partida.'%',Criteria::LIKE);}

                if($tx_descripcion!=""){$c->add(Tb064PresupuestoIngresoPeer::TX_DESCRIPCION,'%'.$tx_descripcion.'%',Criteria::LIKE);}

                if($mo_inicial!=""){$c->add(Tb064PresupuestoIngresoPeer::mo_inicial,$mo_inicial);}

                if($mo_actualizado!=""){$c->add(Tb064PresupuestoIngresoPeer::mo_actualizado,$mo_actualizado);}

                if($nu_anio!=""){$c->add(Tb064PresupuestoIngresoPeer::NU_ANIO,$nu_anio);}

                if($mo_comprometido!=""){$c->add(Tb064PresupuestoIngresoPeer::mo_comprometido,$mo_comprometido);}

                if($mo_causado!=""){$c->add(Tb064PresupuestoIngresoPeer::mo_causado,$mo_causado);}

                if($mo_pagado!=""){$c->add(Tb064PresupuestoIngresoPeer::mo_pagado,$mo_pagado);}

                if($mo_disponible!=""){$c->add(Tb064PresupuestoIngresoPeer::mo_disponible,$mo_disponible);}

                

    }
    
    $c->setIgnoreCase(true);
    $c->add(Tb064PresupuestoIngresoPeer::NU_NIVEL,6);
    $c->add(Tb064PresupuestoIngresoPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));
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
            "mo_comprometido_dia"   => trim($res["mo_comprometido_dia"])
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                                                                                            


}