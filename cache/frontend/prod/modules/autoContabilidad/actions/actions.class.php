<?php

/**
 * autoContabilidad actions.
 * NombreClaseModel(Tb056ContratoCompras)
 * NombreTabla(tb056_contrato_compras)
 * @package    ##PROJECT_NAME##
 * @subpackage autoContabilidad
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoContabilidadActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Contabilidad', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Contabilidad', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb056ContratoComprasPeer::CO_CONTRATO_COMPRAS,$codigo);
        
        $stmt = Tb056ContratoComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_contrato_compras"     => $campos["co_contrato_compras"],
                            "co_compras"     => $campos["co_compras"],
                            "fecha_inicio"     => $campos["fecha_inicio"],
                            "fecha_fin"     => $campos["fecha_fin"],
                            "co_ramo"     => $campos["co_ramo"],
                            "monto"     => $campos["monto"],
                            "created_at"     => $campos["created_at"],
                            "fecha_entrega"     => $campos["fecha_entrega"],
                            "tiempo_garantia"     => $campos["tiempo_garantia"],
                            "co_tp_contrato"     => $campos["co_tp_contrato"],
                            "co_fuente_financiamiento"     => $campos["co_fuente_financiamiento"],
                            "nu_expediente"     => $campos["nu_expediente"],
                            "co_solicitud_anular"     => $campos["co_solicitud_anular"],
                            "in_anular"     => $campos["in_anular"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_contrato_compras"     => "",
                            "co_compras"     => "",
                            "fecha_inicio"     => "",
                            "fecha_fin"     => "",
                            "co_ramo"     => "",
                            "monto"     => "",
                            "created_at"     => "",
                            "fecha_entrega"     => "",
                            "tiempo_garantia"     => "",
                            "co_tp_contrato"     => "",
                            "co_fuente_financiamiento"     => "",
                            "nu_expediente"     => "",
                            "co_solicitud_anular"     => "",
                            "in_anular"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_contrato_compras");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb056_contrato_compras = Tb056ContratoComprasPeer::retrieveByPk($codigo);
     }else{
         $tb056_contrato_compras = new Tb056ContratoCompras();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb056_contrato_comprasForm = $this->getRequestParameter('tb056_contrato_compras');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb056_contrato_compras->setCoCompras($tb056_contrato_comprasForm["co_compras"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb056_contrato_comprasForm["fecha_inicio"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb056_contrato_compras->setFechaInicio($fecha);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb056_contrato_comprasForm["fecha_fin"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb056_contrato_compras->setFechaFin($fecha);
                                                        
        /*Campo tipo BIGINT */
        $tb056_contrato_compras->setCoRamo($tb056_contrato_comprasForm["co_ramo"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb056_contrato_compras->setMonto($tb056_contrato_comprasForm["monto"]);
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb056_contrato_comprasForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb056_contrato_compras->setCreatedAt($fecha);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb056_contrato_comprasForm["fecha_entrega"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb056_contrato_compras->setFechaEntrega($fecha);
                                                        
        /*Campo tipo VARCHAR */
        $tb056_contrato_compras->setTiempoGarantia($tb056_contrato_comprasForm["tiempo_garantia"]);
                                                        
        /*Campo tipo BIGINT */
        $tb056_contrato_compras->setCoTpContrato($tb056_contrato_comprasForm["co_tp_contrato"]);
                                                        
        /*Campo tipo BIGINT */
        $tb056_contrato_compras->setCoFuenteFinanciamiento($tb056_contrato_comprasForm["co_fuente_financiamiento"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb056_contrato_compras->setNuExpediente($tb056_contrato_comprasForm["nu_expediente"]);
                                                        
        /*Campo tipo BIGINT */
        $tb056_contrato_compras->setCoSolicitudAnular($tb056_contrato_comprasForm["co_solicitud_anular"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_anular", $tb056_contrato_comprasForm)){
            $tb056_contrato_compras->setInAnular(false);
        }else{
            $tb056_contrato_compras->setInAnular(true);
        }
                                
        /*CAMPOS*/
        $tb056_contrato_compras->save($con);
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
	$codigo = $this->getRequestParameter("co_contrato_compras");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb056_contrato_compras = Tb056ContratoComprasPeer::retrieveByPk($codigo);			
	$tb056_contrato_compras->delete($con);
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
                $co_compras      =   $this->getRequestParameter("co_compras");
            $fecha_inicio      =   $this->getRequestParameter("fecha_inicio");
            $fecha_fin      =   $this->getRequestParameter("fecha_fin");
            $co_ramo      =   $this->getRequestParameter("co_ramo");
            $monto      =   $this->getRequestParameter("monto");
            $created_at      =   $this->getRequestParameter("created_at");
            $fecha_entrega      =   $this->getRequestParameter("fecha_entrega");
            $tiempo_garantia      =   $this->getRequestParameter("tiempo_garantia");
            $co_tp_contrato      =   $this->getRequestParameter("co_tp_contrato");
            $co_fuente_financiamiento      =   $this->getRequestParameter("co_fuente_financiamiento");
            $nu_expediente      =   $this->getRequestParameter("nu_expediente");
            $co_solicitud_anular      =   $this->getRequestParameter("co_solicitud_anular");
            $in_anular      =   $this->getRequestParameter("in_anular");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_compras!=""){$c->add(Tb056ContratoComprasPeer::co_compras,$co_compras);}
    
                                    
        if($fecha_inicio!=""){
    list($dia, $mes,$anio) = explode("/",$fecha_inicio);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb056ContratoComprasPeer::fecha_inicio,$fecha);
    }
                                    
        if($fecha_fin!=""){
    list($dia, $mes,$anio) = explode("/",$fecha_fin);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb056ContratoComprasPeer::fecha_fin,$fecha);
    }
                                            if($co_ramo!=""){$c->add(Tb056ContratoComprasPeer::co_ramo,$co_ramo);}
    
                                            if($monto!=""){$c->add(Tb056ContratoComprasPeer::monto,$monto);}
    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb056ContratoComprasPeer::created_at,$fecha);
    }
                                    
        if($fecha_entrega!=""){
    list($dia, $mes,$anio) = explode("/",$fecha_entrega);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb056ContratoComprasPeer::fecha_entrega,$fecha);
    }
                                        if($tiempo_garantia!=""){$c->add(Tb056ContratoComprasPeer::tiempo_garantia,'%'.$tiempo_garantia.'%',Criteria::LIKE);}
        
                                            if($co_tp_contrato!=""){$c->add(Tb056ContratoComprasPeer::co_tp_contrato,$co_tp_contrato);}
    
                                            if($co_fuente_financiamiento!=""){$c->add(Tb056ContratoComprasPeer::co_fuente_financiamiento,$co_fuente_financiamiento);}
    
                                        if($nu_expediente!=""){$c->add(Tb056ContratoComprasPeer::nu_expediente,'%'.$nu_expediente.'%',Criteria::LIKE);}
        
                                            if($co_solicitud_anular!=""){$c->add(Tb056ContratoComprasPeer::co_solicitud_anular,$co_solicitud_anular);}
    
                                    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb056ContratoComprasPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb056ContratoComprasPeer::CO_CONTRATO_COMPRAS);
        
    $stmt = Tb056ContratoComprasPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_contrato_compras"     => trim($res["co_contrato_compras"]),
            "co_compras"     => trim($res["co_compras"]),
            "fecha_inicio"     => trim($res["fecha_inicio"]),
            "fecha_fin"     => trim($res["fecha_fin"]),
            "co_ramo"     => trim($res["co_ramo"]),
            "monto"     => trim($res["monto"]),
            "created_at"     => trim($res["created_at"]),
            "fecha_entrega"     => trim($res["fecha_entrega"]),
            "tiempo_garantia"     => trim($res["tiempo_garantia"]),
            "co_tp_contrato"     => trim($res["co_tp_contrato"]),
            "co_fuente_financiamiento"     => trim($res["co_fuente_financiamiento"]),
            "nu_expediente"     => trim($res["nu_expediente"]),
            "co_solicitud_anular"     => trim($res["co_solicitud_anular"]),
            "in_anular"     => trim($res["in_anular"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                                                                                                                    


}