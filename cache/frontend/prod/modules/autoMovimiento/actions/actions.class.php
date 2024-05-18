<?php

/**
 * autoMovimiento actions.
 * NombreClaseModel(Tb087PresupuestoMovimiento)
 * NombreTabla(tb087_presupuesto_movimiento)
 * @package    ##PROJECT_NAME##
 * @subpackage autoMovimiento
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoMovimientoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Movimiento', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Movimiento', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb087PresupuestoMovimientoPeer::CO_PRESUPUESTO_MOVIMIENTO,$codigo);
        
        $stmt = Tb087PresupuestoMovimientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_presupuesto_movimiento"     => $campos["co_presupuesto_movimiento"],
                            "co_partida"     => $campos["co_partida"],
                            "nu_monto"     => $campos["nu_monto"],
                            "nu_anio"     => $campos["nu_anio"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "co_usuario"     => $campos["co_usuario"],
                            "co_tipo_movimiento"     => $campos["co_tipo_movimiento"],
                            "co_detalle_compra"     => $campos["co_detalle_compra"],
                            "tx_observacion"     => $campos["tx_observacion"],
                            "in_activo"     => $campos["in_activo"],
                            "co_compra_servicio"     => $campos["co_compra_servicio"],
                            "co_factura"     => $campos["co_factura"],
                            "mo_saldo_anterior"     => $campos["mo_saldo_anterior"],
                            "mo_saldo_nuevo"     => $campos["mo_saldo_nuevo"],
                            "co_solicitud_anular"     => $campos["co_solicitud_anular"],
                            "in_anular"     => $campos["in_anular"],
                            "in_cerrado"     => $campos["in_cerrado"],
                            "nu_monto_soberano"     => $campos["nu_monto_soberano"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_presupuesto_movimiento"     => "",
                            "co_partida"     => "",
                            "nu_monto"     => "",
                            "nu_anio"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "co_usuario"     => "",
                            "co_tipo_movimiento"     => "",
                            "co_detalle_compra"     => "",
                            "tx_observacion"     => "",
                            "in_activo"     => "",
                            "co_compra_servicio"     => "",
                            "co_factura"     => "",
                            "mo_saldo_anterior"     => "",
                            "mo_saldo_nuevo"     => "",
                            "co_solicitud_anular"     => "",
                            "in_anular"     => "",
                            "in_cerrado"     => "",
                            "nu_monto_soberano"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_presupuesto_movimiento");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb087_presupuesto_movimiento = Tb087PresupuestoMovimientoPeer::retrieveByPk($codigo);
     }else{
         $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb087_presupuesto_movimientoForm = $this->getRequestParameter('tb087_presupuesto_movimiento');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb087_presupuesto_movimiento->setCoPartida($tb087_presupuesto_movimientoForm["co_partida"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb087_presupuesto_movimiento->setNuMonto($tb087_presupuesto_movimientoForm["nu_monto"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb087_presupuesto_movimiento->setNuAnio($tb087_presupuesto_movimientoForm["nu_anio"]);
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb087_presupuesto_movimientoForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb087_presupuesto_movimiento->setCreatedAt($fecha);
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb087_presupuesto_movimientoForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb087_presupuesto_movimiento->setUpdatedAt($fecha);
                                                        
        /*Campo tipo BIGINT */
        $tb087_presupuesto_movimiento->setCoUsuario($tb087_presupuesto_movimientoForm["co_usuario"]);
                                                        
        /*Campo tipo BIGINT */
        $tb087_presupuesto_movimiento->setCoTipoMovimiento($tb087_presupuesto_movimientoForm["co_tipo_movimiento"]);
                                                        
        /*Campo tipo BIGINT */
        $tb087_presupuesto_movimiento->setCoDetalleCompra($tb087_presupuesto_movimientoForm["co_detalle_compra"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb087_presupuesto_movimiento->setTxObservacion($tb087_presupuesto_movimientoForm["tx_observacion"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb087_presupuesto_movimientoForm)){
            $tb087_presupuesto_movimiento->setInActivo(false);
        }else{
            $tb087_presupuesto_movimiento->setInActivo(true);
        }
                                                        
        /*Campo tipo BIGINT */
        $tb087_presupuesto_movimiento->setCoCompraServicio($tb087_presupuesto_movimientoForm["co_compra_servicio"]);
                                                        
        /*Campo tipo BIGINT */
        $tb087_presupuesto_movimiento->setCoFactura($tb087_presupuesto_movimientoForm["co_factura"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb087_presupuesto_movimiento->setMoSaldoAnterior($tb087_presupuesto_movimientoForm["mo_saldo_anterior"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb087_presupuesto_movimiento->setMoSaldoNuevo($tb087_presupuesto_movimientoForm["mo_saldo_nuevo"]);
                                                        
        /*Campo tipo BIGINT */
        $tb087_presupuesto_movimiento->setCoSolicitudAnular($tb087_presupuesto_movimientoForm["co_solicitud_anular"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_anular", $tb087_presupuesto_movimientoForm)){
            $tb087_presupuesto_movimiento->setInAnular(false);
        }else{
            $tb087_presupuesto_movimiento->setInAnular(true);
        }
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_cerrado", $tb087_presupuesto_movimientoForm)){
            $tb087_presupuesto_movimiento->setInCerrado(false);
        }else{
            $tb087_presupuesto_movimiento->setInCerrado(true);
        }
                                                        
        /*Campo tipo NUMERIC */
        $tb087_presupuesto_movimiento->setNuMontoSoberano($tb087_presupuesto_movimientoForm["nu_monto_soberano"]);
                                
        /*CAMPOS*/
        $tb087_presupuesto_movimiento->save($con);
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
	$codigo = $this->getRequestParameter("co_presupuesto_movimiento");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb087_presupuesto_movimiento = Tb087PresupuestoMovimientoPeer::retrieveByPk($codigo);			
	$tb087_presupuesto_movimiento->delete($con);
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
                $co_partida      =   $this->getRequestParameter("co_partida");
            $nu_monto      =   $this->getRequestParameter("nu_monto");
            $nu_anio      =   $this->getRequestParameter("nu_anio");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $co_usuario      =   $this->getRequestParameter("co_usuario");
            $co_tipo_movimiento      =   $this->getRequestParameter("co_tipo_movimiento");
            $co_detalle_compra      =   $this->getRequestParameter("co_detalle_compra");
            $tx_observacion      =   $this->getRequestParameter("tx_observacion");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $co_compra_servicio      =   $this->getRequestParameter("co_compra_servicio");
            $co_factura      =   $this->getRequestParameter("co_factura");
            $mo_saldo_anterior      =   $this->getRequestParameter("mo_saldo_anterior");
            $mo_saldo_nuevo      =   $this->getRequestParameter("mo_saldo_nuevo");
            $co_solicitud_anular      =   $this->getRequestParameter("co_solicitud_anular");
            $in_anular      =   $this->getRequestParameter("in_anular");
            $in_cerrado      =   $this->getRequestParameter("in_cerrado");
            $nu_monto_soberano      =   $this->getRequestParameter("nu_monto_soberano");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_partida!=""){$c->add(Tb087PresupuestoMovimientoPeer::co_partida,$co_partida);}
    
                                            if($nu_monto!=""){$c->add(Tb087PresupuestoMovimientoPeer::nu_monto,$nu_monto);}
    
                                            if($nu_anio!=""){$c->add(Tb087PresupuestoMovimientoPeer::nu_anio,$nu_anio);}
    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb087PresupuestoMovimientoPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb087PresupuestoMovimientoPeer::updated_at,$fecha);
    }
                                            if($co_usuario!=""){$c->add(Tb087PresupuestoMovimientoPeer::co_usuario,$co_usuario);}
    
                                            if($co_tipo_movimiento!=""){$c->add(Tb087PresupuestoMovimientoPeer::co_tipo_movimiento,$co_tipo_movimiento);}
    
                                            if($co_detalle_compra!=""){$c->add(Tb087PresupuestoMovimientoPeer::co_detalle_compra,$co_detalle_compra);}
    
                                        if($tx_observacion!=""){$c->add(Tb087PresupuestoMovimientoPeer::tx_observacion,'%'.$tx_observacion.'%',Criteria::LIKE);}
        
                                    
                                            if($co_compra_servicio!=""){$c->add(Tb087PresupuestoMovimientoPeer::co_compra_servicio,$co_compra_servicio);}
    
                                            if($co_factura!=""){$c->add(Tb087PresupuestoMovimientoPeer::co_factura,$co_factura);}
    
                                            if($mo_saldo_anterior!=""){$c->add(Tb087PresupuestoMovimientoPeer::mo_saldo_anterior,$mo_saldo_anterior);}
    
                                            if($mo_saldo_nuevo!=""){$c->add(Tb087PresupuestoMovimientoPeer::mo_saldo_nuevo,$mo_saldo_nuevo);}
    
                                            if($co_solicitud_anular!=""){$c->add(Tb087PresupuestoMovimientoPeer::co_solicitud_anular,$co_solicitud_anular);}
    
                                    
                                    
                                            if($nu_monto_soberano!=""){$c->add(Tb087PresupuestoMovimientoPeer::nu_monto_soberano,$nu_monto_soberano);}
    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb087PresupuestoMovimientoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb087PresupuestoMovimientoPeer::CO_PRESUPUESTO_MOVIMIENTO);
        
    $stmt = Tb087PresupuestoMovimientoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_presupuesto_movimiento"     => trim($res["co_presupuesto_movimiento"]),
            "co_partida"     => trim($res["co_partida"]),
            "nu_monto"     => trim($res["nu_monto"]),
            "nu_anio"     => trim($res["nu_anio"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "co_usuario"     => trim($res["co_usuario"]),
            "co_tipo_movimiento"     => trim($res["co_tipo_movimiento"]),
            "co_detalle_compra"     => trim($res["co_detalle_compra"]),
            "tx_observacion"     => trim($res["tx_observacion"]),
            "in_activo"     => trim($res["in_activo"]),
            "co_compra_servicio"     => trim($res["co_compra_servicio"]),
            "co_factura"     => trim($res["co_factura"]),
            "mo_saldo_anterior"     => trim($res["mo_saldo_anterior"]),
            "mo_saldo_nuevo"     => trim($res["mo_saldo_nuevo"]),
            "co_solicitud_anular"     => trim($res["co_solicitud_anular"]),
            "in_anular"     => trim($res["in_anular"]),
            "in_cerrado"     => trim($res["in_cerrado"]),
            "nu_monto_soberano"     => trim($res["nu_monto_soberano"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb085_presupuesto.ID
    public function executeStorefkcopartida(sfWebRequest $request){
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
                                                                    //modelo fk tb001_usuario.CO_USUARIO
    public function executeStorefkcousuario(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb001UsuarioPeer::doSelectStmt($c);
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
                                                        //modelo fk tb052_compras.CO_COMPRAS
    public function executeStorefkcocompraservicio(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb052ComprasPeer::doSelectStmt($c);
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