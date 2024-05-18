<?php

/**
 * autoCotizacion actions.
 * NombreClaseModel(Tb052Compras)
 * NombreTabla(tb052_compras)
 * @package    ##PROJECT_NAME##
 * @subpackage autoCotizacion
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoCotizacionActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Cotizacion', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Cotizacion', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb052ComprasPeer::CO_COMPRAS,$codigo);
        
        $stmt = Tb052ComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_compras"     => $campos["co_compras"],
                            "co_requisicion"     => $campos["co_requisicion"],
                            "co_ente"     => $campos["co_ente"],
                            "co_usuario"     => $campos["co_usuario"],
                            "fecha_compra"     => $campos["fecha_compra"],
                            "tx_observacion"     => $campos["tx_observacion"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "created_at"     => $campos["created_at"],
                            "co_proveedor"     => $campos["co_proveedor"],
                            "anio"     => $campos["anio"],
                            "co_servicio"     => $campos["co_servicio"],
                            "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                            "nu_iva"     => $campos["nu_iva"],
                            "monto_iva"     => $campos["monto_iva"],
                            "monto_sub_total"     => $campos["monto_sub_total"],
                            "monto_total"     => $campos["monto_total"],
                            "co_ejecutor"     => $campos["co_ejecutor"],
                            "co_proyecto_ac"     => $campos["co_proyecto_ac"],
                            "co_accion_especifica"     => $campos["co_accion_especifica"],
                            "co_partida_iva"     => $campos["co_partida_iva"],
                            "co_partida_presupuesto"     => $campos["co_partida_presupuesto"],
                            "co_tipo_movimiento"     => $campos["co_tipo_movimiento"],
                            "numero_compra"     => $campos["numero_compra"],
                            "mo_pagado"     => $campos["mo_pagado"],
                            "mo_restante"     => $campos["mo_restante"],
                            "nu_orden_compra"     => $campos["nu_orden_compra"],
                            "in_responsabilidad_social"     => $campos["in_responsabilidad_social"],
                            "in_anulado"     => $campos["in_anulado"],
                            "co_solicitud_anular"     => $campos["co_solicitud_anular"],
                            "in_anular"     => $campos["in_anular"],
                            "co_ramo"     => $campos["co_ramo"],
                            "forma_pago"     => $campos["forma_pago"],
                            "forma_entrega"     => $campos["forma_entrega"],
                            "co_solicitud_cotizacion"     => $campos["co_solicitud_cotizacion"],
                            "tx_concepto"     => $campos["tx_concepto"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_compras"     => "",
                            "co_requisicion"     => "",
                            "co_ente"     => "",
                            "co_usuario"     => "",
                            "fecha_compra"     => "",
                            "tx_observacion"     => "",
                            "co_solicitud"     => "",
                            "created_at"     => "",
                            "co_proveedor"     => "",
                            "anio"     => "",
                            "co_servicio"     => "",
                            "co_tipo_solicitud"     => "",
                            "nu_iva"     => "",
                            "monto_iva"     => "",
                            "monto_sub_total"     => "",
                            "monto_total"     => "",
                            "co_ejecutor"     => "",
                            "co_proyecto_ac"     => "",
                            "co_accion_especifica"     => "",
                            "co_partida_iva"     => "",
                            "co_partida_presupuesto"     => "",
                            "co_tipo_movimiento"     => "",
                            "numero_compra"     => "",
                            "mo_pagado"     => "",
                            "mo_restante"     => "",
                            "nu_orden_compra"     => "",
                            "in_responsabilidad_social"     => "",
                            "in_anulado"     => "",
                            "co_solicitud_anular"     => "",
                            "in_anular"     => "",
                            "co_ramo"     => "",
                            "forma_pago"     => "",
                            "forma_entrega"     => "",
                            "co_solicitud_cotizacion"     => "",
                            "tx_concepto"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_compras");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb052_compras = Tb052ComprasPeer::retrieveByPk($codigo);
     }else{
         $tb052_compras = new Tb052Compras();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb052_comprasForm = $this->getRequestParameter('tb052_compras');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb052_compras->setCoRequisicion($tb052_comprasForm["co_requisicion"]);
                                                        
        /*Campo tipo BIGINT */
        $tb052_compras->setCoEnte($tb052_comprasForm["co_ente"]);
                                                        
        /*Campo tipo BIGINT */
        $tb052_compras->setCoUsuario($tb052_comprasForm["co_usuario"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb052_comprasForm["fecha_compra"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb052_compras->setFechaCompra($fecha);
                                                        
        /*Campo tipo VARCHAR */
        $tb052_compras->setTxObservacion($tb052_comprasForm["tx_observacion"]);
                                                        
        /*Campo tipo BIGINT */
        $tb052_compras->setCoSolicitud($tb052_comprasForm["co_solicitud"]);
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb052_comprasForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb052_compras->setCreatedAt($fecha);
                                                        
        /*Campo tipo BIGINT */
        $tb052_compras->setCoProveedor($tb052_comprasForm["co_proveedor"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb052_compras->setAnio($tb052_comprasForm["anio"]);
                                                        
        /*Campo tipo BIGINT */
        $tb052_compras->setCoServicio($tb052_comprasForm["co_servicio"]);
                                                        
        /*Campo tipo BIGINT */
        $tb052_compras->setCoTipoSolicitud($tb052_comprasForm["co_tipo_solicitud"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb052_compras->setNuIva($tb052_comprasForm["nu_iva"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb052_compras->setMontoIva($tb052_comprasForm["monto_iva"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb052_compras->setMontoSubTotal($tb052_comprasForm["monto_sub_total"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb052_compras->setMontoTotal($tb052_comprasForm["monto_total"]);
                                                        
        /*Campo tipo BIGINT */
        $tb052_compras->setCoEjecutor($tb052_comprasForm["co_ejecutor"]);
                                                        
        /*Campo tipo BIGINT */
        $tb052_compras->setCoProyectoAc($tb052_comprasForm["co_proyecto_ac"]);
                                                        
        /*Campo tipo BIGINT */
        $tb052_compras->setCoAccionEspecifica($tb052_comprasForm["co_accion_especifica"]);
                                                        
        /*Campo tipo BIGINT */
        $tb052_compras->setCoPartidaIva($tb052_comprasForm["co_partida_iva"]);
                                                        
        /*Campo tipo BIGINT */
        $tb052_compras->setCoPartidaPresupuesto($tb052_comprasForm["co_partida_presupuesto"]);
                                                        
        /*Campo tipo BIGINT */
        $tb052_compras->setCoTipoMovimiento($tb052_comprasForm["co_tipo_movimiento"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb052_compras->setNumeroCompra($tb052_comprasForm["numero_compra"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb052_compras->setMoPagado($tb052_comprasForm["mo_pagado"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb052_compras->setMoRestante($tb052_comprasForm["mo_restante"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb052_compras->setNuOrdenCompra($tb052_comprasForm["nu_orden_compra"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_responsabilidad_social", $tb052_comprasForm)){
            $tb052_compras->setInResponsabilidadSocial(false);
        }else{
            $tb052_compras->setInResponsabilidadSocial(true);
        }
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_anulado", $tb052_comprasForm)){
            $tb052_compras->setInAnulado(false);
        }else{
            $tb052_compras->setInAnulado(true);
        }
                                                        
        /*Campo tipo BIGINT */
        $tb052_compras->setCoSolicitudAnular($tb052_comprasForm["co_solicitud_anular"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_anular", $tb052_comprasForm)){
            $tb052_compras->setInAnular(false);
        }else{
            $tb052_compras->setInAnular(true);
        }
                                                        
        /*Campo tipo BIGINT */
        $tb052_compras->setCoRamo($tb052_comprasForm["co_ramo"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb052_compras->setFormaPago($tb052_comprasForm["forma_pago"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb052_compras->setFormaEntrega($tb052_comprasForm["forma_entrega"]);
                                                        
        /*Campo tipo BIGINT */
        $tb052_compras->setCoSolicitudCotizacion($tb052_comprasForm["co_solicitud_cotizacion"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb052_compras->setTxConcepto($tb052_comprasForm["tx_concepto"]);
                                
        /*CAMPOS*/
        $tb052_compras->save($con);
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
	$codigo = $this->getRequestParameter("co_compras");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb052_compras = Tb052ComprasPeer::retrieveByPk($codigo);			
	$tb052_compras->delete($con);
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
                $co_requisicion      =   $this->getRequestParameter("co_requisicion");
            $co_ente      =   $this->getRequestParameter("co_ente");
            $co_usuario      =   $this->getRequestParameter("co_usuario");
            $fecha_compra      =   $this->getRequestParameter("fecha_compra");
            $tx_observacion      =   $this->getRequestParameter("tx_observacion");
            $co_solicitud      =   $this->getRequestParameter("co_solicitud");
            $created_at      =   $this->getRequestParameter("created_at");
            $co_proveedor      =   $this->getRequestParameter("co_proveedor");
            $anio      =   $this->getRequestParameter("anio");
            $co_servicio      =   $this->getRequestParameter("co_servicio");
            $co_tipo_solicitud      =   $this->getRequestParameter("co_tipo_solicitud");
            $nu_iva      =   $this->getRequestParameter("nu_iva");
            $monto_iva      =   $this->getRequestParameter("monto_iva");
            $monto_sub_total      =   $this->getRequestParameter("monto_sub_total");
            $monto_total      =   $this->getRequestParameter("monto_total");
            $co_ejecutor      =   $this->getRequestParameter("co_ejecutor");
            $co_proyecto_ac      =   $this->getRequestParameter("co_proyecto_ac");
            $co_accion_especifica      =   $this->getRequestParameter("co_accion_especifica");
            $co_partida_iva      =   $this->getRequestParameter("co_partida_iva");
            $co_partida_presupuesto      =   $this->getRequestParameter("co_partida_presupuesto");
            $co_tipo_movimiento      =   $this->getRequestParameter("co_tipo_movimiento");
            $numero_compra      =   $this->getRequestParameter("numero_compra");
            $mo_pagado      =   $this->getRequestParameter("mo_pagado");
            $mo_restante      =   $this->getRequestParameter("mo_restante");
            $nu_orden_compra      =   $this->getRequestParameter("nu_orden_compra");
            $in_responsabilidad_social      =   $this->getRequestParameter("in_responsabilidad_social");
            $in_anulado      =   $this->getRequestParameter("in_anulado");
            $co_solicitud_anular      =   $this->getRequestParameter("co_solicitud_anular");
            $in_anular      =   $this->getRequestParameter("in_anular");
            $co_ramo      =   $this->getRequestParameter("co_ramo");
            $forma_pago      =   $this->getRequestParameter("forma_pago");
            $forma_entrega      =   $this->getRequestParameter("forma_entrega");
            $co_solicitud_cotizacion      =   $this->getRequestParameter("co_solicitud_cotizacion");
            $tx_concepto      =   $this->getRequestParameter("tx_concepto");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_requisicion!=""){$c->add(Tb052ComprasPeer::co_requisicion,$co_requisicion);}
    
                                            if($co_ente!=""){$c->add(Tb052ComprasPeer::co_ente,$co_ente);}
    
                                            if($co_usuario!=""){$c->add(Tb052ComprasPeer::co_usuario,$co_usuario);}
    
                                    
        if($fecha_compra!=""){
    list($dia, $mes,$anio) = explode("/",$fecha_compra);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb052ComprasPeer::fecha_compra,$fecha);
    }
                                        if($tx_observacion!=""){$c->add(Tb052ComprasPeer::tx_observacion,'%'.$tx_observacion.'%',Criteria::LIKE);}
        
                                            if($co_solicitud!=""){$c->add(Tb052ComprasPeer::co_solicitud,$co_solicitud);}
    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb052ComprasPeer::created_at,$fecha);
    }
                                            if($co_proveedor!=""){$c->add(Tb052ComprasPeer::co_proveedor,$co_proveedor);}
    
                                            if($anio!=""){$c->add(Tb052ComprasPeer::anio,$anio);}
    
                                            if($co_servicio!=""){$c->add(Tb052ComprasPeer::co_servicio,$co_servicio);}
    
                                            if($co_tipo_solicitud!=""){$c->add(Tb052ComprasPeer::co_tipo_solicitud,$co_tipo_solicitud);}
    
                                            if($nu_iva!=""){$c->add(Tb052ComprasPeer::nu_iva,$nu_iva);}
    
                                            if($monto_iva!=""){$c->add(Tb052ComprasPeer::monto_iva,$monto_iva);}
    
                                            if($monto_sub_total!=""){$c->add(Tb052ComprasPeer::monto_sub_total,$monto_sub_total);}
    
                                            if($monto_total!=""){$c->add(Tb052ComprasPeer::monto_total,$monto_total);}
    
                                            if($co_ejecutor!=""){$c->add(Tb052ComprasPeer::co_ejecutor,$co_ejecutor);}
    
                                            if($co_proyecto_ac!=""){$c->add(Tb052ComprasPeer::co_proyecto_ac,$co_proyecto_ac);}
    
                                            if($co_accion_especifica!=""){$c->add(Tb052ComprasPeer::co_accion_especifica,$co_accion_especifica);}
    
                                            if($co_partida_iva!=""){$c->add(Tb052ComprasPeer::co_partida_iva,$co_partida_iva);}
    
                                            if($co_partida_presupuesto!=""){$c->add(Tb052ComprasPeer::co_partida_presupuesto,$co_partida_presupuesto);}
    
                                            if($co_tipo_movimiento!=""){$c->add(Tb052ComprasPeer::co_tipo_movimiento,$co_tipo_movimiento);}
    
                                        if($numero_compra!=""){$c->add(Tb052ComprasPeer::numero_compra,'%'.$numero_compra.'%',Criteria::LIKE);}
        
                                            if($mo_pagado!=""){$c->add(Tb052ComprasPeer::mo_pagado,$mo_pagado);}
    
                                            if($mo_restante!=""){$c->add(Tb052ComprasPeer::mo_restante,$mo_restante);}
    
                                        if($nu_orden_compra!=""){$c->add(Tb052ComprasPeer::nu_orden_compra,'%'.$nu_orden_compra.'%',Criteria::LIKE);}
        
                                    
                                    
                                            if($co_solicitud_anular!=""){$c->add(Tb052ComprasPeer::co_solicitud_anular,$co_solicitud_anular);}
    
                                    
                                            if($co_ramo!=""){$c->add(Tb052ComprasPeer::co_ramo,$co_ramo);}
    
                                        if($forma_pago!=""){$c->add(Tb052ComprasPeer::forma_pago,'%'.$forma_pago.'%',Criteria::LIKE);}
        
                                        if($forma_entrega!=""){$c->add(Tb052ComprasPeer::forma_entrega,'%'.$forma_entrega.'%',Criteria::LIKE);}
        
                                            if($co_solicitud_cotizacion!=""){$c->add(Tb052ComprasPeer::co_solicitud_cotizacion,$co_solicitud_cotizacion);}
    
                                        if($tx_concepto!=""){$c->add(Tb052ComprasPeer::tx_concepto,'%'.$tx_concepto.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb052ComprasPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb052ComprasPeer::CO_COMPRAS);
        
    $stmt = Tb052ComprasPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_compras"     => trim($res["co_compras"]),
            "co_requisicion"     => trim($res["co_requisicion"]),
            "co_ente"     => trim($res["co_ente"]),
            "co_usuario"     => trim($res["co_usuario"]),
            "fecha_compra"     => trim($res["fecha_compra"]),
            "tx_observacion"     => trim($res["tx_observacion"]),
            "co_solicitud"     => trim($res["co_solicitud"]),
            "created_at"     => trim($res["created_at"]),
            "co_proveedor"     => trim($res["co_proveedor"]),
            "anio"     => trim($res["anio"]),
            "co_servicio"     => trim($res["co_servicio"]),
            "co_tipo_solicitud"     => trim($res["co_tipo_solicitud"]),
            "nu_iva"     => trim($res["nu_iva"]),
            "monto_iva"     => trim($res["monto_iva"]),
            "monto_sub_total"     => trim($res["monto_sub_total"]),
            "monto_total"     => trim($res["monto_total"]),
            "co_ejecutor"     => trim($res["co_ejecutor"]),
            "co_proyecto_ac"     => trim($res["co_proyecto_ac"]),
            "co_accion_especifica"     => trim($res["co_accion_especifica"]),
            "co_partida_iva"     => trim($res["co_partida_iva"]),
            "co_partida_presupuesto"     => trim($res["co_partida_presupuesto"]),
            "co_tipo_movimiento"     => trim($res["co_tipo_movimiento"]),
            "numero_compra"     => trim($res["numero_compra"]),
            "mo_pagado"     => trim($res["mo_pagado"]),
            "mo_restante"     => trim($res["mo_restante"]),
            "nu_orden_compra"     => trim($res["nu_orden_compra"]),
            "in_responsabilidad_social"     => trim($res["in_responsabilidad_social"]),
            "in_anulado"     => trim($res["in_anulado"]),
            "co_solicitud_anular"     => trim($res["co_solicitud_anular"]),
            "in_anular"     => trim($res["in_anular"]),
            "co_ramo"     => trim($res["co_ramo"]),
            "forma_pago"     => trim($res["forma_pago"]),
            "forma_entrega"     => trim($res["forma_entrega"]),
            "co_solicitud_cotizacion"     => trim($res["co_solicitud_cotizacion"]),
            "tx_concepto"     => trim($res["tx_concepto"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                                                                                //modelo fk tb050_servicio.CO_SERVICIO
    public function executeStorefkcoservicio(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb050ServicioPeer::doSelectStmt($c);
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
                                                                                                                                //modelo fk tb085_presupuesto.ID
    public function executeStorefkcopartidapresupuesto(sfWebRequest $request){
        $c = new Criteria();
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
                    //modelo fk tb088_tipo_movimiento.ID
    public function executeStorefkcotipomovimiento(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb088TipoMovimientoPeer::doSelectStmt($c);
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