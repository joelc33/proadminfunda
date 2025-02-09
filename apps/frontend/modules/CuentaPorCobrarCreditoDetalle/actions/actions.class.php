<?php

/**
 * CuentaPorCobrarCreditoDetalle actions.
 *
 * @package    gobel
 * @subpackage CuentaPorCobrarCreditoDetalle
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class CuentaPorCobrarCreditoDetalleActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('CuentaPorCobrarCreditoDetalle', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('CuentaPorCobrarCreditoDetalle', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");

    $c2 = new Criteria();
    $c2->add(Tb142CuentaCobrarPeer::ID, $this->getRequestParameter("id_tb142_cuenta_cobrar"));
    $stmt2 = Tb142CuentaCobrarPeer::doSelectStmt($c2);
    $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);

    $c3 = new Criteria();
    $c3->clearSelectColumns();
    $c3->add(Tb145CuentaCobrarDetallePeer::ID_TB142_CUENTA_COBRAR,$this->getRequestParameter("id_tb142_cuenta_cobrar"));
    $c3->add(Tb145CuentaCobrarDetallePeer::IN_ACTIVO, true);
    $c3->addSelectColumn('SUM(' . Tb145CuentaCobrarDetallePeer::MO_CUOTA . ') as total_cuota');
    $stmt3 = Tb145CuentaCobrarDetallePeer::doSelectStmt($c3);
    $campos3 = $stmt3->fetch(PDO::FETCH_ASSOC);

    $mo_disponible_nuevo = $campos2["mo_cuenta"] - $campos3["total_cuota"];
    //$mo_disponible_editar = $campos["mo_cuota"] + $mo_disponible_nuevo;

    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb145CuentaCobrarDetallePeer::ID,$codigo);
        
        $stmt = Tb145CuentaCobrarDetallePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $mo_disponible_editar = $campos["mo_cuota"] + $mo_disponible_nuevo;

        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb142_cuenta_cobrar"     => $campos["id_tb142_cuenta_cobrar"],
                            "de_cuota"     => $campos["de_cuota"],
                            "mo_cuota"     => $campos["mo_cuota"],
                            "fe_pago"     => $campos["fe_pago"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "mo_disponible"     => $mo_disponible_editar,
                            "disponibilidad"     => $mo_disponible_nuevo,
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb142_cuenta_cobrar"     => $this->getRequestParameter("id_tb142_cuenta_cobrar"),
                            "de_cuota"     => $campos2["de_descripcion"],
                            "mo_cuota"     => "",
                            "fe_pago"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "mo_disponible"     => $mo_disponible_nuevo,
                            "disponibilidad"     => $mo_disponible_nuevo,
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb145_cuenta_cobrar_detalle = Tb145CuentaCobrarDetallePeer::retrieveByPk($codigo);
     }else{
         $tb145_cuenta_cobrar_detalle = new Tb145CuentaCobrarDetalle();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb145_cuenta_cobrar_detalleForm = $this->getRequestParameter('tb145_cuenta_cobrar_detalle');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb145_cuenta_cobrar_detalle->setIdTb142CuentaCobrar($tb145_cuenta_cobrar_detalleForm["id_tb142_cuenta_cobrar"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb145_cuenta_cobrar_detalle->setDeCuota($tb145_cuenta_cobrar_detalleForm["de_cuota"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb145_cuenta_cobrar_detalle->setMoCuota($tb145_cuenta_cobrar_detalleForm["mo_cuota"]);

        /*Campo tipo NUMERIC */
        $tb145_cuenta_cobrar_detalle->setMoPendiente($tb145_cuenta_cobrar_detalleForm["mo_cuota"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb145_cuenta_cobrar_detalleForm["fe_pago"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb145_cuenta_cobrar_detalle->setFePago($fecha);
                                
        /*CAMPOS*/
        $tb145_cuenta_cobrar_detalle->save($con);
        
        $tb142_cuenta_cobrar = Tb142CuentaCobrarPeer::retrieveByPk($tb145_cuenta_cobrar_detalleForm["id_tb142_cuenta_cobrar"]);

        $c2 = new Criteria();
        $c2->add(Tb096PresupuestoModificacionPeer::CO_SOLICITUD, $tb142_cuenta_cobrar->getCoSolicitud());
        $stmt2 = Tb096PresupuestoModificacionPeer::doSelectStmt($c2);
        $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        $c3 = new Criteria();
        $c3->setIgnoreCase(true);
        $c3->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$campos2["id"]);
        //$c3->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION,1);
        //$c3->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') as mo_distribucion');
        $stmt3 = Tb097ModificacionDetallePeer::doSelectStmt($c3);
        while($res = $stmt3->fetch(PDO::FETCH_ASSOC)){

            if($res["id_tb098_tipo_distribucion"]==1){

                /*****Presupeusto de Ingreso*****/
                $c4 = new Criteria();
                $c4->add(Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO, $res["id_tb064_presupuesto_ingreso"]);
                $stmt4 = Tb064PresupuestoIngresoPeer::doSelectStmt($c4);
                $campos4 = $stmt4->fetch(PDO::FETCH_ASSOC);

                $mo_liquidado = $campos4["mo_causado"] + $tb145_cuenta_cobrar_detalleForm["mo_cuota"];

                $tb064_presupuesto_ingreso = Tb064PresupuestoIngresoPeer::retrieveByPk($res["id_tb064_presupuesto_ingreso"]);
                $tb064_presupuesto_ingreso->setMoCausado($mo_liquidado);
                $tb064_presupuesto_ingreso->save($con);

                $tb150_presupuesto_ingreso_movimiento = new Tb150PresupuestoIngresoMovimiento();
                $tb150_presupuesto_ingreso_movimiento->setIdTb064PresupuestoIngreso($res["id_tb064_presupuesto_ingreso"]);
                $tb150_presupuesto_ingreso_movimiento->setMoMovimiento($tb145_cuenta_cobrar_detalleForm["mo_cuota"]);
                //$tb150_presupuesto_ingreso_movimiento->setNuAnio(date("Y"));
                $tb150_presupuesto_ingreso_movimiento->setNuAnio( $this->getUser()->getAttribute('ejercicio'));

                $tb150_presupuesto_ingreso_movimiento->setCreatedAt($fecha);               
                $tb150_presupuesto_ingreso_movimiento->setCoUsuario($this->getUser()->getAttribute('codigo'));
                $tb150_presupuesto_ingreso_movimiento->setCoTipoMovimiento(10);
                $tb150_presupuesto_ingreso_movimiento->setCoSolicitud($tb142_cuenta_cobrar->getCoSolicitud());
                $tb150_presupuesto_ingreso_movimiento->setIdTb142CuentaCobrar($tb145_cuenta_cobrar_detalle->getId());                
                $tb150_presupuesto_ingreso_movimiento->setMoSaldoAnterior($campos4["mo_causado"]);
                $tb150_presupuesto_ingreso_movimiento->setMoSaldoNuevo($mo_liquidado);                
                $tb150_presupuesto_ingreso_movimiento->setTxObservacion('Cuenta Por cobrar');
                $tb150_presupuesto_ingreso_movimiento->save($con);

            }

        }        
        
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb142_cuenta_cobrar->getCoSolicitud()));
        $ruta->setInCargarDato(true)->save($con);

        $con->commit();

        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());         
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente'
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
  

  public function executeEliminar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("id");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
        
        
        $c2 = new Criteria();
        $c2->add(Tb150PresupuestoIngresoMovimientoPeer::ID_TB142_CUENTA_COBRAR, $codigo);
        $stmt2 = Tb150PresupuestoIngresoMovimientoPeer::doSelectStmt($c2);
        $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);   
        
	/*CAMPOS*/
	$tb150_presupuesto_ingreso_movimiento = Tb150PresupuestoIngresoMovimientoPeer::retrieveByPk($campos2["id"]);
        
                $c4 = new Criteria();
                $c4->add(Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO, $tb150_presupuesto_ingreso_movimiento->getIdTb064PresupuestoIngreso());
                $stmt4 = Tb064PresupuestoIngresoPeer::doSelectStmt($c4);
                $campos4 = $stmt4->fetch(PDO::FETCH_ASSOC);

                $mo_liquidado = $campos4["mo_causado"] - $tb150_presupuesto_ingreso_movimiento->getMoMovimiento();

                $tb064_presupuesto_ingreso = Tb064PresupuestoIngresoPeer::retrieveByPk($tb150_presupuesto_ingreso_movimiento->getIdTb064PresupuestoIngreso());
                $tb064_presupuesto_ingreso->setMoCausado($mo_liquidado);
                $tb064_presupuesto_ingreso->save($con);        
        
        
	$tb150_presupuesto_ingreso_movimiento->delete($con);
        
        
        $tb145_cuenta_cobrar_detalle = Tb145CuentaCobrarDetallePeer::retrieveByPk($codigo);			
	$tb145_cuenta_cobrar_detalle->delete($con);
        
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
    $limit      =   $this->getRequestParameter("limit",100);
    $start      =   $this->getRequestParameter("start",0);
                $id_tb142_cuenta_cobrar      =   $this->getRequestParameter("id_tb142_cuenta_cobrar");
            $de_cuota      =   $this->getRequestParameter("de_cuota");
            $mo_cuota      =   $this->getRequestParameter("mo_cuota");
            $fe_pago      =   $this->getRequestParameter("fe_pago");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    $c->add(Tb145CuentaCobrarDetallePeer::ID_TB142_CUENTA_COBRAR,$id_tb142_cuenta_cobrar);

    $c->setIgnoreCase(true);
    $cantidadTotal = Tb145CuentaCobrarDetallePeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb145CuentaCobrarDetallePeer::ID);
        
    $stmt = Tb145CuentaCobrarDetallePeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "id_tb142_cuenta_cobrar"     => trim($res["id_tb142_cuenta_cobrar"]),
            "de_cuota"     => trim($res["de_cuota"]),
            "mo_cuota"     => trim($res["mo_cuota"]),
            "fe_pago"     => trim(date("d-m-Y", strtotime($res["fe_pago"]))),
            "in_activo"     => trim($res["in_activo"]),
            "in_pago"     => trim($res["in_pago"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb142_cuenta_cobrar.ID
    public function executeStorefkidtb142cuentacobrar(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb142CuentaCobrarPeer::doSelectStmt($c);
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