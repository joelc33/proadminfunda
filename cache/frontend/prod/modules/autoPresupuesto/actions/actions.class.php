<?php

/**
 * autoPresupuesto actions.
 * NombreClaseModel(Tb022PresupuestoPartida)
 * NombreTabla(tb022_presupuesto_partida)
 * @package    ##PROJECT_NAME##
 * @subpackage autoPresupuesto
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoPresupuestoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Presupuesto', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Presupuesto', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb022PresupuestoPartidaPeer::CO_PRESUPUESTO_PARTIDA,$codigo);
        
        $stmt = Tb022PresupuestoPartidaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_presupuesto_partida"     => $campos["co_presupuesto_partida"],
                            "co_partida_presupuestaria"     => $campos["co_partida_presupuestaria"],
                            "co_actividad"     => $campos["co_actividad"],
                            "mo_inicial"     => $campos["mo_inicial"],
                            "mo_autorizado"     => $campos["mo_autorizado"],
                            "mo_comprometido"     => $campos["mo_comprometido"],
                            "mo_causado"     => $campos["mo_causado"],
                            "mo_pagado"     => $campos["mo_pagado"],
                            "co_anio_fiscal"     => $campos["co_anio_fiscal"],
                            "mo_disponible"     => $campos["mo_disponible"],
                            "mo_deuda"     => $campos["mo_deuda"],
                            "co_cuenta_contable"     => $campos["co_cuenta_contable"],
                            "mo_debito"     => $campos["mo_debito"],
                            "mo_credito"     => $campos["mo_credito"],
                            "in_ordinal"     => $campos["in_ordinal"],
                            "co_tipo_presupuesto"     => $campos["co_tipo_presupuesto"],
                            "mo_aumento"     => $campos["mo_aumento"],
                            "mo_disminucion"     => $campos["mo_disminucion"],
                            "mo_precomprometido"     => $campos["mo_precomprometido"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_presupuesto_partida"     => "",
                            "co_partida_presupuestaria"     => "",
                            "co_actividad"     => "",
                            "mo_inicial"     => "",
                            "mo_autorizado"     => "",
                            "mo_comprometido"     => "",
                            "mo_causado"     => "",
                            "mo_pagado"     => "",
                            "co_anio_fiscal"     => "",
                            "mo_disponible"     => "",
                            "mo_deuda"     => "",
                            "co_cuenta_contable"     => "",
                            "mo_debito"     => "",
                            "mo_credito"     => "",
                            "in_ordinal"     => "",
                            "co_tipo_presupuesto"     => "",
                            "mo_aumento"     => "",
                            "mo_disminucion"     => "",
                            "mo_precomprometido"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_presupuesto_partida");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb022_presupuesto_partida = Tb022PresupuestoPartidaPeer::retrieveByPk($codigo);
     }else{
         $tb022_presupuesto_partida = new Tb022PresupuestoPartida();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb022_presupuesto_partidaForm = $this->getRequestParameter('tb022_presupuesto_partida');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb022_presupuesto_partida->setCoPartidaPresupuestaria($tb022_presupuesto_partidaForm["co_partida_presupuestaria"]);
                                                        
        /*Campo tipo BIGINT */
        $tb022_presupuesto_partida->setCoActividad($tb022_presupuesto_partidaForm["co_actividad"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb022_presupuesto_partida->setMoInicial($tb022_presupuesto_partidaForm["mo_inicial"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb022_presupuesto_partida->setMoAutorizado($tb022_presupuesto_partidaForm["mo_autorizado"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb022_presupuesto_partida->setMoComprometido($tb022_presupuesto_partidaForm["mo_comprometido"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb022_presupuesto_partida->setMoCausado($tb022_presupuesto_partidaForm["mo_causado"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb022_presupuesto_partida->setMoPagado($tb022_presupuesto_partidaForm["mo_pagado"]);
                                                        
        /*Campo tipo BIGINT */
        $tb022_presupuesto_partida->setCoAnioFiscal($tb022_presupuesto_partidaForm["co_anio_fiscal"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb022_presupuesto_partida->setMoDisponible($tb022_presupuesto_partidaForm["mo_disponible"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb022_presupuesto_partida->setMoDeuda($tb022_presupuesto_partidaForm["mo_deuda"]);
                                                        
        /*Campo tipo BIGINT */
        $tb022_presupuesto_partida->setCoCuentaContable($tb022_presupuesto_partidaForm["co_cuenta_contable"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb022_presupuesto_partida->setMoDebito($tb022_presupuesto_partidaForm["mo_debito"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb022_presupuesto_partida->setMoCredito($tb022_presupuesto_partidaForm["mo_credito"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_ordinal", $tb022_presupuesto_partidaForm)){
            $tb022_presupuesto_partida->setInOrdinal(false);
        }else{
            $tb022_presupuesto_partida->setInOrdinal(true);
        }
                                                        
        /*Campo tipo BIGINT */
        $tb022_presupuesto_partida->setCoTipoPresupuesto($tb022_presupuesto_partidaForm["co_tipo_presupuesto"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb022_presupuesto_partida->setMoAumento($tb022_presupuesto_partidaForm["mo_aumento"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb022_presupuesto_partida->setMoDisminucion($tb022_presupuesto_partidaForm["mo_disminucion"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb022_presupuesto_partida->setMoPrecomprometido($tb022_presupuesto_partidaForm["mo_precomprometido"]);
                                
        /*CAMPOS*/
        $tb022_presupuesto_partida->save($con);
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
	$codigo = $this->getRequestParameter("co_presupuesto_partida");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb022_presupuesto_partida = Tb022PresupuestoPartidaPeer::retrieveByPk($codigo);			
	$tb022_presupuesto_partida->delete($con);
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
                $co_partida_presupuestaria      =   $this->getRequestParameter("co_partida_presupuestaria");
            $co_actividad      =   $this->getRequestParameter("co_actividad");
            $mo_inicial      =   $this->getRequestParameter("mo_inicial");
            $mo_autorizado      =   $this->getRequestParameter("mo_autorizado");
            $mo_comprometido      =   $this->getRequestParameter("mo_comprometido");
            $mo_causado      =   $this->getRequestParameter("mo_causado");
            $mo_pagado      =   $this->getRequestParameter("mo_pagado");
            $co_anio_fiscal      =   $this->getRequestParameter("co_anio_fiscal");
            $mo_disponible      =   $this->getRequestParameter("mo_disponible");
            $mo_deuda      =   $this->getRequestParameter("mo_deuda");
            $co_cuenta_contable      =   $this->getRequestParameter("co_cuenta_contable");
            $mo_debito      =   $this->getRequestParameter("mo_debito");
            $mo_credito      =   $this->getRequestParameter("mo_credito");
            $in_ordinal      =   $this->getRequestParameter("in_ordinal");
            $co_tipo_presupuesto      =   $this->getRequestParameter("co_tipo_presupuesto");
            $mo_aumento      =   $this->getRequestParameter("mo_aumento");
            $mo_disminucion      =   $this->getRequestParameter("mo_disminucion");
            $mo_precomprometido      =   $this->getRequestParameter("mo_precomprometido");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_partida_presupuestaria!=""){$c->add(Tb022PresupuestoPartidaPeer::co_partida_presupuestaria,$co_partida_presupuestaria);}
    
                                            if($co_actividad!=""){$c->add(Tb022PresupuestoPartidaPeer::co_actividad,$co_actividad);}
    
                                            if($mo_inicial!=""){$c->add(Tb022PresupuestoPartidaPeer::mo_inicial,$mo_inicial);}
    
                                            if($mo_autorizado!=""){$c->add(Tb022PresupuestoPartidaPeer::mo_autorizado,$mo_autorizado);}
    
                                            if($mo_comprometido!=""){$c->add(Tb022PresupuestoPartidaPeer::mo_comprometido,$mo_comprometido);}
    
                                            if($mo_causado!=""){$c->add(Tb022PresupuestoPartidaPeer::mo_causado,$mo_causado);}
    
                                            if($mo_pagado!=""){$c->add(Tb022PresupuestoPartidaPeer::mo_pagado,$mo_pagado);}
    
                                            if($co_anio_fiscal!=""){$c->add(Tb022PresupuestoPartidaPeer::co_anio_fiscal,$co_anio_fiscal);}
    
                                            if($mo_disponible!=""){$c->add(Tb022PresupuestoPartidaPeer::mo_disponible,$mo_disponible);}
    
                                            if($mo_deuda!=""){$c->add(Tb022PresupuestoPartidaPeer::mo_deuda,$mo_deuda);}
    
                                            if($co_cuenta_contable!=""){$c->add(Tb022PresupuestoPartidaPeer::co_cuenta_contable,$co_cuenta_contable);}
    
                                            if($mo_debito!=""){$c->add(Tb022PresupuestoPartidaPeer::mo_debito,$mo_debito);}
    
                                            if($mo_credito!=""){$c->add(Tb022PresupuestoPartidaPeer::mo_credito,$mo_credito);}
    
                                    
                                            if($co_tipo_presupuesto!=""){$c->add(Tb022PresupuestoPartidaPeer::co_tipo_presupuesto,$co_tipo_presupuesto);}
    
                                            if($mo_aumento!=""){$c->add(Tb022PresupuestoPartidaPeer::mo_aumento,$mo_aumento);}
    
                                            if($mo_disminucion!=""){$c->add(Tb022PresupuestoPartidaPeer::mo_disminucion,$mo_disminucion);}
    
                                            if($mo_precomprometido!=""){$c->add(Tb022PresupuestoPartidaPeer::mo_precomprometido,$mo_precomprometido);}
    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb022PresupuestoPartidaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb022PresupuestoPartidaPeer::CO_PRESUPUESTO_PARTIDA);
        
    $stmt = Tb022PresupuestoPartidaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_presupuesto_partida"     => trim($res["co_presupuesto_partida"]),
            "co_partida_presupuestaria"     => trim($res["co_partida_presupuestaria"]),
            "co_actividad"     => trim($res["co_actividad"]),
            "mo_inicial"     => trim($res["mo_inicial"]),
            "mo_autorizado"     => trim($res["mo_autorizado"]),
            "mo_comprometido"     => trim($res["mo_comprometido"]),
            "mo_causado"     => trim($res["mo_causado"]),
            "mo_pagado"     => trim($res["mo_pagado"]),
            "co_anio_fiscal"     => trim($res["co_anio_fiscal"]),
            "mo_disponible"     => trim($res["mo_disponible"]),
            "mo_deuda"     => trim($res["mo_deuda"]),
            "co_cuenta_contable"     => trim($res["co_cuenta_contable"]),
            "mo_debito"     => trim($res["mo_debito"]),
            "mo_credito"     => trim($res["mo_credito"]),
            "in_ordinal"     => trim($res["in_ordinal"]),
            "co_tipo_presupuesto"     => trim($res["co_tipo_presupuesto"]),
            "mo_aumento"     => trim($res["mo_aumento"]),
            "mo_disminucion"     => trim($res["mo_disminucion"]),
            "mo_precomprometido"     => trim($res["mo_precomprometido"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb009_partida_presupuestaria.CO_PARTIDA_PRESUPUESTARIA
    public function executeStorefkcopartidapresupuestaria(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb009PartidaPresupuestariaPeer::doSelectStmt($c);
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
                    //modelo fk tb020_actividad.CO_ACTIVIDAD
    public function executeStorefkcoactividad(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb020ActividadPeer::doSelectStmt($c);
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
                                                                                //modelo fk tb013_anio_fiscal.CO_ANIO_FISCAL
    public function executeStorefkcoaniofiscal(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb013AnioFiscalPeer::doSelectStmt($c);
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
                                            //modelo fk tb024_cuenta_contable.CO_CUENTA_CONTABLE
    public function executeStorefkcocuentacontable(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb024CuentaContablePeer::doSelectStmt($c);
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
                                                        //modelo fk tb023_tipo_presupuesto.CO_TIPO_PRESUPUESTO
    public function executeStorefkcotipopresupuesto(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb023TipoPresupuestoPeer::doSelectStmt($c);
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