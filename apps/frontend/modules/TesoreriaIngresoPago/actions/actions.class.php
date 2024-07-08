<?php

/**
 * TesoreriaIngresoPago actions.
 *
 * @package    gobel
 * @subpackage TesoreriaIngresoPago
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class TesoreriaIngresoPagoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('TesoreriaIngresoPago', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('TesoreriaIngresoPago', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb148CuentaCobrarPagoPeer::ID,$codigo);
        
        $stmt = Tb148CuentaCobrarPagoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb145_cuenta_cobrar_detalle"     => $campos["id_tb145_cuenta_cobrar_detalle"],
                            "mo_pago"     => $campos["mo_pago"],
                            "id_tb074_forma_pago"     => $campos["id_tb074_forma_pago"],
                            "id_tb010_banco"     => $campos["id_tb010_banco"],
                            "id_tb011_cuenta_bancaria"     => $campos["id_tb011_cuenta_bancaria"],
                            "fe_ingreso"     => $campos["fe_ingreso"],
                            "fe_registro"     => $campos["fe_registro"],
                            "id_tb147_tipo_documento"     => $campos["id_tb147_tipo_documento"],
                            "de_orden_ingreso"     => $campos["de_orden_ingreso"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb145_cuenta_cobrar_detalle"     => "",
                            "mo_pago"     => "",
                            "id_tb074_forma_pago"     => "",
                            "id_tb010_banco"     => "",
                            "id_tb011_cuenta_bancaria"     => "",
                            "fe_ingreso"     => "",
                            "fe_registro"     => "",
                            "id_tb147_tipo_documento"     => "",
                            "de_orden_ingreso"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb148_cuenta_cobrar_pago = Tb148CuentaCobrarPagoPeer::retrieveByPk($codigo);
     }else{
         $tb148_cuenta_cobrar_pago = new Tb148CuentaCobrarPago();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb148_cuenta_cobrar_pagoForm = $this->getRequestParameter('tb148_cuenta_cobrar_pago');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb148_cuenta_cobrar_pago->setIdTb145CuentaCobrarDetalle($tb148_cuenta_cobrar_pagoForm["id_tb145_cuenta_cobrar_detalle"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb148_cuenta_cobrar_pago->setMoPago($tb148_cuenta_cobrar_pagoForm["mo_pago"]);
                                                        
        /*Campo tipo BIGINT */
//        $tb148_cuenta_cobrar_pago->setIdTb074FormaPago($tb148_cuenta_cobrar_pagoForm["id_tb074_forma_pago"]);
                                                        
        /*Campo tipo BIGINT */
        $tb148_cuenta_cobrar_pago->setIdTb010Banco($tb148_cuenta_cobrar_pagoForm["id_tb010_banco"]);
                                                        
        /*Campo tipo BIGINT */
        $tb148_cuenta_cobrar_pago->setIdTb011CuentaBancaria($tb148_cuenta_cobrar_pagoForm["id_tb011_cuenta_bancaria"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("-",$tb148_cuenta_cobrar_pagoForm["fe_ingreso"]);
        $fe_ingreso = $anio."-".$mes."-".$dia;
        $tb148_cuenta_cobrar_pago->setFeIngreso($fe_ingreso);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("-",$tb148_cuenta_cobrar_pagoForm["fe_registro"]);
        $fe_registro = date('Y-m-d');
        $tb148_cuenta_cobrar_pago->setFeRegistro(date('Y-m-d'));
                                                        
        /*Campo tipo BIGINT */
        $tb148_cuenta_cobrar_pago->setIdTb147TipoDocumento($tb148_cuenta_cobrar_pagoForm["id_tb153_tipo_documento_cuenta"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb148_cuenta_cobrar_pago->setDeOrdenIngreso($tb148_cuenta_cobrar_pagoForm["de_orden_ingreso"]);

        /*Campo tipo BIGINT */
        $tb148_cuenta_cobrar_pago->setIdTb155CuentaBancariaHistorico($tb148_cuenta_cobrar_pagoForm["id_tb155_cuenta_bancaria_historico"]?$tb148_cuenta_cobrar_pagoForm["id_tb155_cuenta_bancaria_historico"]:null);
                                
        /*CAMPOS*/
        $tb148_cuenta_cobrar_pago->save($con);


        $c1 = new Criteria();
        $c1->clearSelectColumns();
        $c1->add(Tb148CuentaCobrarPagoPeer::ID_TB145_CUENTA_COBRAR_DETALLE, $tb148_cuenta_cobrar_pagoForm["id_tb145_cuenta_cobrar_detalle"]);
        $c1->add(Tb148CuentaCobrarPagoPeer::IN_ACTIVO, true);
        $c1->addSelectColumn('SUM(' . Tb148CuentaCobrarPagoPeer::MO_PAGO . ') as total_pago');
        $stmt1 = Tb148CuentaCobrarPagoPeer::doSelectStmt($c1);
        $campos1 = $stmt1->fetch(PDO::FETCH_ASSOC);

        $c2 = new Criteria();
        $c2->clearSelectColumns();
        $c2->add(Tb145CuentaCobrarDetallePeer::ID, $tb148_cuenta_cobrar_pagoForm["id_tb145_cuenta_cobrar_detalle"]);
        $c2->add(Tb145CuentaCobrarDetallePeer::IN_ACTIVO, true);
        $stmt2 = Tb145CuentaCobrarDetallePeer::doSelectStmt($c2);
        $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        $pendiente = $campos2["mo_cuota"] - $campos1["total_pago"];

        $c10 = new Criteria();
        $c10->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA, $tb148_cuenta_cobrar_pagoForm["id_tb011_cuenta_bancaria"]);
        $stmt10 = Tb011CuentaBancariaPeer::doSelectStmt($c10);
        $campos10 = $stmt10->fetch(PDO::FETCH_ASSOC);
        
        $c11 = new Criteria();
        $c11->add(Tb153TipoDocumentoCuentaPeer::ID, $tb148_cuenta_cobrar_pagoForm["id_tb153_tipo_documento_cuenta"]);
        $stmt11 = Tb153TipoDocumentoCuentaPeer::doSelectStmt($c11);
        $campos11 = $stmt11->fetch(PDO::FETCH_ASSOC);        

        $mo_disponible = $campos10["mo_disponible"] + $tb148_cuenta_cobrar_pagoForm["mo_pago"];
        $mo_ingreso = $campos10["mo_ingreso"] + $tb148_cuenta_cobrar_pagoForm["mo_pago"];
        
        if($this->getRequestParameter('in_posteo')==0){
            

        $tb011_cuenta_bancaria = Tb011CuentaBancariaPeer::retrieveByPk($tb148_cuenta_cobrar_pagoForm["id_tb011_cuenta_bancaria"]);
        $tb011_cuenta_bancaria->setMoDisponible($mo_disponible);
        $tb011_cuenta_bancaria->setMoIngreso($mo_ingreso);
        $tb011_cuenta_bancaria->save($con);

        $tb155_cuenta_bancaria_historico = new Tb155CuentaBancariaHistorico();
        $tb155_cuenta_bancaria_historico->setIdTb011CuentaBancaria($tb148_cuenta_cobrar_pagoForm["id_tb011_cuenta_bancaria"]);
        $tb155_cuenta_bancaria_historico->setMoTransaccion($tb148_cuenta_cobrar_pagoForm["mo_pago"]);
        $tb155_cuenta_bancaria_historico->setNuTransaccion($tb148_cuenta_cobrar_pagoForm["nu_referencia"]);
        $tb155_cuenta_bancaria_historico->setMoSaldoAnterior($campos10["mo_disponible"]);
        $tb155_cuenta_bancaria_historico->setMoSaldoNuevo($mo_disponible);
        $tb155_cuenta_bancaria_historico->setFeTransaccion($fe_ingreso);
        $tb155_cuenta_bancaria_historico->setCoSolicitud($this->getRequestParameter("co_solicitud"));
        $tb155_cuenta_bancaria_historico->setIdTb010Banco($campos10["co_banco"]);
        $tb155_cuenta_bancaria_historico->setIdTb153TipoDocumentoCuenta($tb148_cuenta_cobrar_pagoForm["id_tb153_tipo_documento_cuenta"]);
        $tb155_cuenta_bancaria_historico->setIdTb154TipoCuentaMovimiento($campos11["id_tipo_cuenta_movimiento"]);
        $tb155_cuenta_bancaria_historico->setIdTb156SubtipoDocumento(1);
        $tb155_cuenta_bancaria_historico->setDeObservacion($campos2["de_cuota"]);
        $tb155_cuenta_bancaria_historico->setIdTb148CuentaCobrarPago($tb148_cuenta_cobrar_pago->getId());
        $tb155_cuenta_bancaria_historico->setInConciliado(true);
        $tb155_cuenta_bancaria_historico->save($con);

        }else{
         
        $tb155_cuenta_bancaria_historico = Tb155CuentaBancariaHistoricoPeer::retrieveByPk( $tb148_cuenta_cobrar_pagoForm["id_tb155_cuenta_bancaria_historico"]);
        $tb155_cuenta_bancaria_historico->setInConciliado(true);
        $tb155_cuenta_bancaria_historico->setIdTb148CuentaCobrarPago($tb148_cuenta_cobrar_pago->getId());
        $tb155_cuenta_bancaria_historico->save($con);            
            
        }

        $tb145_cuenta_cobrar_detalle = Tb145CuentaCobrarDetallePeer::retrieveByPk( $tb148_cuenta_cobrar_pagoForm["id_tb145_cuenta_cobrar_detalle"]);
        $tb145_cuenta_cobrar_detalle->setMoPagado($campos1["total_pago"]);
        $tb145_cuenta_cobrar_detalle->setMoPendiente($pendiente);
        if($pendiente == 0){
            $tb145_cuenta_cobrar_detalle->setInPago(true);
        }
        $tb145_cuenta_cobrar_detalle->save($con);


        
        $c3 = new Criteria();
        $c3->clearSelectColumns();
        $c3->add(Tb142CuentaCobrarPeer::ID, $campos2["id_tb142_cuenta_cobrar"]);
        $c3->add(Tb142CuentaCobrarPeer::IN_ACTIVO, true);
        $stmt3 = Tb142CuentaCobrarPeer::doSelectStmt($c3);
        $campos3 = $stmt3->fetch(PDO::FETCH_ASSOC);        

        $c4 = new Criteria();
        $c4->clearSelectColumns();
        $c4->add(Tb096PresupuestoModificacionPeer::CO_SOLICITUD, $campos3["co_solicitud"]);
        $stmt4 = Tb096PresupuestoModificacionPeer::doSelectStmt($c4);
        $campos4 = $stmt4->fetch(PDO::FETCH_ASSOC); 
        
        $c5 = new Criteria();
        $c5->clearSelectColumns();
        $c5->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION, $campos4["id"]);
        $c5->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
        $stmt5 = Tb097ModificacionDetallePeer::doSelectStmt($c5);
        $campos5 = $stmt5->fetch(PDO::FETCH_ASSOC);
        
        $c6 = new Criteria();
        $c6->clearSelectColumns();
        $c6->addSelectColumn(Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO);
        $c6->addSelectColumn(Tb064PresupuestoIngresoPeer::MO_PAGADO);
        $c6->addSelectColumn(Tb097ModificacionDetallePeer::MO_DISTRIBUCION);
        $c6->addSelectColumn(Tb064PresupuestoIngresoPeer::CO_CUENTA_CONTABLE);
        $c6->addJoin(Tb097ModificacionDetallePeer::ID_TB064_PRESUPUESTO_INGRESO, Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO);
        $c6->addJoin(Tb096PresupuestoModificacionPeer::ID, Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION);
        $c6->add(Tb096PresupuestoModificacionPeer::CO_SOLICITUD, $campos3["co_solicitud"]);
        $stmt6 = Tb064PresupuestoIngresoPeer::doSelectStmt($c6);
        $cantidad6 = Tb064PresupuestoIngresoPeer::doCount($c6);
        
        while($campos6 = $stmt6->fetch(PDO::FETCH_ASSOC)){
            
        if($cantidad6>1){    

        $mo_recaudado = $campos6["mo_pagado"] + $campos6["mo_distribucion"];
        $mo_movimiento = $campos6["mo_distribucion"];
        }else{
        
        $mo_recaudado = $campos6["mo_pagado"] + $tb148_cuenta_cobrar_pagoForm["mo_pago"];    
        $mo_movimiento = $tb148_cuenta_cobrar_pagoForm["mo_pago"];    
        }

        $tb064_presupuesto_ingreso = Tb064PresupuestoIngresoPeer::retrieveByPk($campos6["co_presupuesto_ingreso"]);
        $tb064_presupuesto_ingreso->setMoPagado($mo_recaudado);
        $tb064_presupuesto_ingreso->save($con);                         

        $tb150_presupuesto_ingreso_movimiento = new Tb150PresupuestoIngresoMovimiento();
        $tb150_presupuesto_ingreso_movimiento->setIdTb064PresupuestoIngreso($campos6["co_presupuesto_ingreso"]);
        $tb150_presupuesto_ingreso_movimiento->setMoMovimiento($mo_movimiento);
        $tb150_presupuesto_ingreso_movimiento->setNuAnio( $this->getUser()->getAttribute('ejercicio'));
        if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
        $tb150_presupuesto_ingreso_movimiento->setCreatedAt($fe_registro); 
        }else{
        $tb150_presupuesto_ingreso_movimiento->setCreatedAt($fe_registro); 
        }        
        $tb150_presupuesto_ingreso_movimiento->setCoUsuario($this->getUser()->getAttribute('codigo'));
        $tb150_presupuesto_ingreso_movimiento->setCoTipoMovimiento(11);
        $tb150_presupuesto_ingreso_movimiento->setMoSaldoAnterior($campos6["mo_pagado"]);
        $tb150_presupuesto_ingreso_movimiento->setMoSaldoNuevo($mo_recaudado);
        $tb150_presupuesto_ingreso_movimiento->setCoSolicitud($campos3["co_solicitud"]);
        $tb150_presupuesto_ingreso_movimiento->setTxObservacion($campos2["de_cuota"]);
        $tb150_presupuesto_ingreso_movimiento->save($con);        
        
        $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
        if($co_tipo_solicitud==31){
        $fecha_asiento =    $fe_ingreso; 
        }else{
        $fecha_asiento =    $fe_registro;    
        }
        
        
                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoDebe($mo_movimiento)
                                  ->setCoCuentaContable($campos10["co_cuenta_contable"])
                                  ->setCoSolicitud($campos3["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCreatedAt($fecha_asiento)
                                  ->setCoTipoAsiento(12)
                                  ->setInActivo(true)
                                  ->save($con);   
                    

                    
                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoHaber($mo_movimiento)
                                  ->setCoCuentaContable($campos6["co_cuenta_contable"])
                                  ->setCoSolicitud($campos3["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCreatedAt($fecha_asiento)
                                  ->setCoTipoAsiento(12)
                                  ->setInActivo(true)
                                  ->save($con);    
                    
        }
        
         if($this->getRequestParameter('in_posteo')==1){
               $c = new Criteria();
               $c->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA,$tb155_cuenta_bancaria_historico->getIdTb011CuentaBancaria());
               $stmt = Tb011CuentaBancariaPeer::doSelectStmt($c);
               $reg = $stmt->fetch(PDO::FETCH_ASSOC);            
             
               $c1 = new Criteria();
               $c1->add(Tb156SubtipoDocumentoPeer::ID,$tb155_cuenta_bancaria_historico->getIdTb156SubtipoDocumento());
               $stmt1 = Tb156SubtipoDocumentoPeer::doSelectStmt($c1);
               $reg1 = $stmt1->fetch(PDO::FETCH_ASSOC); 
                    
                    
                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoHaber($tb148_cuenta_cobrar_pagoForm["mo_pago"])
                                  ->setCoCuentaContable($reg["co_cuenta_contable"])
                                  ->setCoSolicitud($campos3["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCreatedAt($fecha_asiento)
                                  ->setCoTipoAsiento(9)
                                  ->setInActivo(true)
                                  ->save($con);
                    

                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoDebe($tb148_cuenta_cobrar_pagoForm["mo_pago"])
                                  ->setCoCuentaContable($reg1["co_cuenta_contable"])
                                  ->setCoSolicitud($campos3["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCreatedAt($fecha_asiento)
                                  ->setCoTipoAsiento(9)
                                  ->setInActivo(true)
                                  ->save($con);   
                    
         }
        
       $c = new Criteria();
       $c->add(Tb008ProveedorPeer::CO_PROVEEDOR,$campos3["co_proveedor"]);
       $stmt = Tb008ProveedorPeer::doSelectStmt($c);
       $reg = $stmt->fetch(PDO::FETCH_ASSOC); 
        
                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoHaber($tb148_cuenta_cobrar_pagoForm["mo_pago"])
                                  ->setCoCuentaContable($reg["co_cuenta_orden_activo"])
                                  ->setCoSolicitud($campos3["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCreatedAt($fecha_asiento)
                                  ->setCoTipoAsiento(13)
                                  ->setInActivo(true)
                                  ->save($con);        
                    
                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoDebe($tb148_cuenta_cobrar_pagoForm["mo_pago"])
                                  ->setCoCuentaContable($reg["co_cuenta_orden_pasivo"])
                                  ->setCoSolicitud($campos3["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCreatedAt($fecha_asiento)
                                  ->setCoTipoAsiento(13)
                                  ->setInActivo(true)
                                  ->save($con);                        
                    
        
        $con->commit();

        $this->data = json_encode(array(
            "success" => true,
            "mo_pagado" => $campos1["total_pago"],
            "mo_pendiente" => $pendiente,
            "msg" => 'Ingreso realizado Exitosamente!'
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
	/*CAMPOS*/
	$tb148_cuenta_cobrar_pago = Tb148CuentaCobrarPagoPeer::retrieveByPk($codigo);			
	$tb148_cuenta_cobrar_pago->delete($con);
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
                $id_tb145_cuenta_cobrar_detalle      =   $this->getRequestParameter("co_liquidacion_pago");
            $mo_pago      =   $this->getRequestParameter("mo_pago");
            $id_tb074_forma_pago      =   $this->getRequestParameter("id_tb074_forma_pago");
            $id_tb010_banco      =   $this->getRequestParameter("id_tb010_banco");
            $id_tb011_cuenta_bancaria      =   $this->getRequestParameter("id_tb011_cuenta_bancaria");
            $fe_ingreso      =   $this->getRequestParameter("fe_ingreso");
            $fe_registro      =   $this->getRequestParameter("fe_registro");
            $id_tb147_tipo_documento      =   $this->getRequestParameter("id_tb147_tipo_documento");
            $de_orden_ingreso      =   $this->getRequestParameter("de_orden_ingreso");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    $c->add(Tb148CuentaCobrarPagoPeer::ID_TB145_CUENTA_COBRAR_DETALLE, $id_tb145_cuenta_cobrar_detalle);

    $c->setIgnoreCase(true);
    $cantidadTotal = Tb148CuentaCobrarPagoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb148CuentaCobrarPagoPeer::ID);

        $c->addSelectColumn(Tb148CuentaCobrarPagoPeer::ID);
        $c->addSelectColumn(Tb148CuentaCobrarPagoPeer::MO_PAGO);
        $c->addSelectColumn(Tb148CuentaCobrarPagoPeer::DE_ORDEN_INGRESO);
        $c->addSelectColumn(Tb155CuentaBancariaHistoricoPeer::NU_DOCUMENTO);

        $c->addJoin(Tb148CuentaCobrarPagoPeer::ID_TB155_CUENTA_BANCARIA_HISTORICO, Tb155CuentaBancariaHistoricoPeer::ID);
        
    $stmt = Tb148CuentaCobrarPagoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "id_tb145_cuenta_cobrar_detalle"     => trim($res["id_tb145_cuenta_cobrar_detalle"]),
            "mo_pago"     => trim($res["mo_pago"]),
            "id_tb074_forma_pago"     => trim($res["id_tb074_forma_pago"]),
            "id_tb010_banco"     => trim($res["id_tb010_banco"]),
            "id_tb011_cuenta_bancaria"     => trim($res["id_tb011_cuenta_bancaria"]),
            "fe_ingreso"     => trim($res["fe_ingreso"]),
            "fe_registro"     => trim($res["fe_registro"]),
            "id_tb147_tipo_documento"     => trim($res["id_tb147_tipo_documento"]),
            "de_orden_ingreso"     => trim($res["de_orden_ingreso"]),
            "nu_documento"     => trim($res["nu_documento"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb145_cuenta_cobrar_detalle.ID
    public function executeStorefkidtb145cuentacobrardetalle(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb145CuentaCobrarDetallePeer::doSelectStmt($c);
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