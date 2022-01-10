<?php

/**
 * CuentaPorCobrarCredito actions.
 *
 * @package    gobel
 * @subpackage CuentaPorCobrarCredito
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class CuentaPorCobrarCreditoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('CuentaPorCobrarCredito', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('CuentaPorCobrarCredito', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    //$codigo = $this->getRequestParameter("codigo");
    $codigo = $this->getRequestParameter("co_solicitud");
    if($codigo!=''||$codigo!=null){

        $c = new Criteria();
        //$c->add(Tb142CuentaCobrarPeer::ID,$codigo);
        $c->add(Tb142CuentaCobrarPeer::CO_SOLICITUD,$codigo);
        $stmt = Tb142CuentaCobrarPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $c2 = new Criteria();
        $c2->add(Tb096PresupuestoModificacionPeer::CO_SOLICITUD,$codigo);
        $stmt2 = Tb096PresupuestoModificacionPeer::doSelectStmt($c2);
        $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        $c3 = new Criteria();
        $c3->clearSelectColumns();
        $c3->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$campos2["id"]);
        $c3->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION,1);
        $c3->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') as mo_distribucion');
        $stmt3 = Tb097ModificacionDetallePeer::doSelectStmt($c3);
        $campos3 = $stmt3->fetch(PDO::FETCH_ASSOC);

        if($campos["id"]!=''){
            $c4 = new Criteria();
            $c4->add(Tb008ProveedorPeer::CO_PROVEEDOR,$campos["co_proveedor"]);
            $stmt4 = Tb008ProveedorPeer::doSelectStmt($c4);
            $campos4 = $stmt4->fetch(PDO::FETCH_ASSOC);
        }

        //var_dump($campos3["mo_distribucion"]);

        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "co_solicitud"     => $this->getRequestParameter("co_solicitud"),
                            "co_usuario"     => $this->getUser()->getAttribute('codigo'),
                            "co_proveedor"     => $campos["co_proveedor"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "de_soporte"     => $campos["de_soporte"],
                            "id_tb143_cuenta_concepto"     => $campos["id_tb143_cuenta_concepto"],
                            "id_tb144_clase_ingreso"     => $campos["id_tb144_clase_ingreso"],
                            "de_descripcion"     => $campos["de_descripcion"],
                            //"mo_cuenta"     => $campos["mo_cuenta"],
                            "mo_cuenta"     => $campos3["mo_distribucion"],
                            "fe_documento"     => $campos["fe_documento"],
                            "id_tb141_tipo_cuota"     => $campos["id_tb141_tipo_cuota"],
                            "co_documento"     => $campos4["co_documento"],
                            "tx_rif"     => $campos4["tx_rif"],
                            "tx_razon_social"     => $campos4["tx_razon_social"],
                    ));
    }/*else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "co_solicitud"     => $this->getRequestParameter("co_solicitud"),
                            "co_usuario"     => $this->getUser()->getAttribute('codigo'),
                            "co_proveedor"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "de_soporte"     => "",
                            "id_tb143_cuenta_concepto"     => "",
                            "id_tb144_clase_ingreso"     => "",
                            "de_descripcion"     => "",
                            "mo_cuenta"     => $campos3["mo_distribucion"],
                            "fe_documento"     => "",
                            "id_tb141_tipo_cuota"     => "",
                    ));
    }*/

  }

  public function executeGuardar(sfWebRequest $request)
  {

    $codigo = $this->getRequestParameter("id");
        
    $con = Propel::getConnection();

    $tb142_cuenta_cobrarForm = $this->getRequestParameter('tb142_cuenta_cobrar');

     if($codigo!=''||$codigo!=null){

        try
        { 
          $con->beginTransaction();

        $tb142_cuenta_cobrar = Tb142CuentaCobrarPeer::retrieveByPk($codigo);
        /*CAMPOS*/
        $tb142_cuenta_cobrar->setCoSolicitud($tb142_cuenta_cobrarForm["co_solicitud"]);
        $tb142_cuenta_cobrar->setCoUsuario($this->getUser()->getAttribute('codigo'));
        $tb142_cuenta_cobrar->setCoProveedor($tb142_cuenta_cobrarForm["co_proveedor"]);
        $tb142_cuenta_cobrar->setInActivo(true);
        $fecha = date("Y-m-d H:i:s");
        //$tb142_cuenta_cobrar->setCreatedAt($fecha);
        $tb142_cuenta_cobrar->setUpdatedAt($fecha);
        $tb142_cuenta_cobrar->setDeSoporte($tb142_cuenta_cobrarForm["de_soporte"]);
        $tb142_cuenta_cobrar->setIdTb143CuentaConcepto($tb142_cuenta_cobrarForm["id_tb143_cuenta_concepto"]);
        $tb142_cuenta_cobrar->setIdTb144ClaseIngreso($tb142_cuenta_cobrarForm["id_tb144_clase_ingreso"]);
        $tb142_cuenta_cobrar->setDeDescripcion($tb142_cuenta_cobrarForm["de_descripcion"]);
        $tb142_cuenta_cobrar->setMoCuenta($tb142_cuenta_cobrarForm["mo_cuenta"]);                                   
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb142_cuenta_cobrarForm["fe_documento"]);
        $fe_documento = $anio."-".$mes."-".$dia;
        $tb142_cuenta_cobrar->setFeDocumento($fe_documento);
        $tb142_cuenta_cobrar->setIdTb141TipoCuota($tb142_cuenta_cobrarForm["id_tb141_tipo_cuota"]);
        $tb142_cuenta_cobrar->save($con);
        
        $wherec = new Criteria();
        $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $tb142_cuenta_cobrarForm["co_solicitud"]);
        $wherec->add(Tb061AsientoContablePeer::CO_TIPO_ASIENTO, 11);
        BasePeer::doDelete($wherec, $con);
        
        $wherec = new Criteria();
        $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $tb142_cuenta_cobrarForm["co_solicitud"]);
        $wherec->add(Tb061AsientoContablePeer::CO_TIPO_ASIENTO, 12);
        BasePeer::doDelete($wherec, $con);        
        
       $c = new Criteria();
       $c->add(Tb008ProveedorPeer::CO_PROVEEDOR,$tb142_cuenta_cobrarForm["co_proveedor"]);
       $stmt = Tb008ProveedorPeer::doSelectStmt($c);
       $reg = $stmt->fetch(PDO::FETCH_ASSOC); 
       
       
        $c4 = new Criteria();
        $c4->clearSelectColumns();
        $c4->add(Tb096PresupuestoModificacionPeer::CO_SOLICITUD, $tb142_cuenta_cobrarForm["co_solicitud"]);
        $stmt4 = Tb096PresupuestoModificacionPeer::doSelectStmt($c4);
        $campos4 = $stmt4->fetch(PDO::FETCH_ASSOC); 
        
        $c5 = new Criteria();
        $c5->clearSelectColumns();
        $c5->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION, $campos4["id"]);
        $c5->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
        $stmt5 = Tb097ModificacionDetallePeer::doSelectStmt($c5);
        $campos5 = $stmt5->fetch(PDO::FETCH_ASSOC);
        
        $c6 = new Criteria();
        $c6->add(Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO, $campos5["id_tb064_presupuesto_ingreso"]);
        $stmt6 = Tb064PresupuestoIngresoPeer::doSelectStmt($c6);
        $campos6 = $stmt6->fetch(PDO::FETCH_ASSOC);               
        
                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoHaber($tb142_cuenta_cobrarForm["mo_cuenta"])
                                  ->setCoCuentaContable($reg["co_cuenta_orden_pasivo"])
                                  ->setCoSolicitud($tb142_cuenta_cobrarForm["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCoTipoAsiento(11)
                                  ->setInActivo(true)
                                  ->save($con);        
                    
                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoDebe($tb142_cuenta_cobrarForm["mo_cuenta"])
                                  ->setCoCuentaContable($reg["co_cuenta_orden_activo"])
                                  ->setCoSolicitud($tb142_cuenta_cobrarForm["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCoTipoAsiento(11)
                                  ->setInActivo(true)
                                  ->save($con);  
                    
                    
                    $tb061_asiento_contable2 = new Tb061AsientoContable();
                    $tb061_asiento_contable2->setMoDebe($tb142_cuenta_cobrarForm["mo_cuenta"])
                                  ->setCoCuentaContable(60652)
                                  ->setCoSolicitud($tb142_cuenta_cobrarForm["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCreatedAt($fe_documento)
                                  ->setCoTipoAsiento(12)
                                  ->setInActivo(true)
                                  ->save($con);        
                    
                    $tb061_asiento_contable2 = new Tb061AsientoContable();
                    $tb061_asiento_contable2->setMoHaber($tb142_cuenta_cobrarForm["mo_cuenta"])
                                  ->setCoCuentaContable(122224)
                                  ->setCoSolicitud($tb142_cuenta_cobrarForm["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCreatedAt($fe_documento)
                                  ->setCoTipoAsiento(12)
                                  ->setInActivo(true)
                                  ->save($con);      
                    
                    $tb061_asiento_contable3 = new Tb061AsientoContable();
                    $tb061_asiento_contable3->setMoDebe($tb142_cuenta_cobrarForm["mo_cuenta"])
                                  ->setCoCuentaContable(122224)
                                  ->setCoSolicitud($tb142_cuenta_cobrarForm["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCreatedAt($fe_documento)
                                  ->setCoTipoAsiento(12)
                                  ->setInActivo(true)
                                  ->save($con);        
                    
                    $tb061_asiento_contable3 = new Tb061AsientoContable();
                    $tb061_asiento_contable3->setMoHaber($tb142_cuenta_cobrarForm["mo_cuenta"])
                                  ->setCoCuentaContable($campos6["co_cuenta_contable"])
                                  ->setCoSolicitud($tb142_cuenta_cobrarForm["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCreatedAt($fe_documento)
                                  ->setCoTipoAsiento(12)
                                  ->setInActivo(true)
                                  ->save($con);                       
                    
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb142_cuenta_cobrarForm["co_solicitud"]));
        $ruta->setInCargarDato(true)->save($con);

        $con->commit();

        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta()); 

        $this->data = json_encode(array(
            "success" => true,
            "codigo" => $tb142_cuenta_cobrar->getId(),
            "msg" => 'Modificación realizada exitosamente!'
        ));

        }catch (PropelException $e){

            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }

     }else{

        try
        { 
        $con->beginTransaction();

        $tb142_cuenta_cobrar = new Tb142CuentaCobrar();
        /*CAMPOS*/
        $tb142_cuenta_cobrar->setCoSolicitud($tb142_cuenta_cobrarForm["co_solicitud"]);
        $tb142_cuenta_cobrar->setCoUsuario($this->getUser()->getAttribute('codigo'));
        $tb142_cuenta_cobrar->setCoProveedor($tb142_cuenta_cobrarForm["co_proveedor"]);
        $tb142_cuenta_cobrar->setInActivo(true);
        //$fecha = date("Y-m-d H:i:s");
        //$tb142_cuenta_cobrar->setCreatedAt($fecha);
        //$tb142_cuenta_cobrar->setUpdatedAt($fecha);
        $tb142_cuenta_cobrar->setDeSoporte($tb142_cuenta_cobrarForm["de_soporte"]);
        $tb142_cuenta_cobrar->setIdTb143CuentaConcepto($tb142_cuenta_cobrarForm["id_tb143_cuenta_concepto"]);
        $tb142_cuenta_cobrar->setIdTb144ClaseIngreso($tb142_cuenta_cobrarForm["id_tb144_clase_ingreso"]);
        $tb142_cuenta_cobrar->setDeDescripcion($tb142_cuenta_cobrarForm["de_descripcion"]);
        $tb142_cuenta_cobrar->setMoCuenta($tb142_cuenta_cobrarForm["mo_cuenta"]);                                   
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb142_cuenta_cobrarForm["fe_documento"]);
        $fe_documento = $anio."-".$mes."-".$dia;
        $tb142_cuenta_cobrar->setFeDocumento($fe_documento);
        $tb142_cuenta_cobrar->setIdTb141TipoCuota($tb142_cuenta_cobrarForm["id_tb141_tipo_cuota"]);
        $tb142_cuenta_cobrar->save($con);

        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb142_cuenta_cobrarForm["co_solicitud"]));
        $ruta->setInCargarDato(true)->save($con);

        $c2 = new Criteria();
        $c2->add(Tb096PresupuestoModificacionPeer::CO_SOLICITUD, $tb142_cuenta_cobrarForm["co_solicitud"]);
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
//                $c4 = new Criteria();
//                $c4->add(Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO, $res["id_tb064_presupuesto_ingreso"]);
//                $stmt4 = Tb064PresupuestoIngresoPeer::doSelectStmt($c4);
//                $campos4 = $stmt4->fetch(PDO::FETCH_ASSOC);
//
//                $mo_liquidado = $campos4["mo_causado"] + $tb142_cuenta_cobrarForm["mo_cuenta"];
//
//                $tb064_presupuesto_ingreso = Tb064PresupuestoIngresoPeer::retrieveByPk($res["id_tb064_presupuesto_ingreso"]);
//                $tb064_presupuesto_ingreso->setMoCausado($mo_liquidado);
//                $tb064_presupuesto_ingreso->save($con);
//
//                $tb150_presupuesto_ingreso_movimiento = new Tb150PresupuestoIngresoMovimiento();
//                $tb150_presupuesto_ingreso_movimiento->setIdTb064PresupuestoIngreso($res["id_tb064_presupuesto_ingreso"]);
//                $tb150_presupuesto_ingreso_movimiento->setMoMovimiento($tb142_cuenta_cobrarForm["mo_cuenta"]);
//                //$tb150_presupuesto_ingreso_movimiento->setNuAnio(date("Y"));
//                $tb150_presupuesto_ingreso_movimiento->setNuAnio( $this->getUser()->getAttribute('ejercicio'));
//                if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
//                $tb150_presupuesto_ingreso_movimiento->setCreatedAt($this->getUser()->getAttribute('fe_cierre')); 
//                }else{
//                $tb150_presupuesto_ingreso_movimiento->setCreatedAt(date("Y-m-d")); 
//                }                
//                $tb150_presupuesto_ingreso_movimiento->setCoUsuario($this->getUser()->getAttribute('codigo'));
//                $tb150_presupuesto_ingreso_movimiento->setCoTipoMovimiento(10);
//                $tb150_presupuesto_ingreso_movimiento->setCoSolicitud($tb142_cuenta_cobrarForm["co_solicitud"]);
//                $tb150_presupuesto_ingreso_movimiento->setIdTb142CuentaCobrar($tb142_cuenta_cobrar->getId());                
//                $tb150_presupuesto_ingreso_movimiento->setMoSaldoAnterior($campos4["mo_causado"]);
//                $tb150_presupuesto_ingreso_movimiento->setMoSaldoNuevo($mo_liquidado);                
//                $tb150_presupuesto_ingreso_movimiento->setTxObservacion('Cuenta Por cobrar');
//                $tb150_presupuesto_ingreso_movimiento->save($con);

            }elseif($res["id_tb098_tipo_distribucion"]==2){

                /*****Presupeusto de Gasto*****/
                $c4 = new Criteria();
                $c4->add(Tb085PresupuestoPeer::ID, $res["id_tb085_presupuesto"]);
                $c4->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
                $c4->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);
                $stmt4 = Tb085PresupuestoPeer::doSelectStmt($c4);
                $campos4 = $stmt4->fetch(PDO::FETCH_ASSOC);

                $mo_actualizado = $campos4["mo_actualizado"] + $res["mo_distribucion"];
                $mo_disponible = $campos4["mo_disponible"] + $res["mo_distribucion"];

                /*$tb085_presupuesto = Tb085PresupuestoPeer::retrieveByPk($res["id_tb085_presupuesto"]);
                $tb085_presupuesto->setMoActualizado($mo_actualizado);
                $tb085_presupuesto->setMoDisponible($mo_disponible);
                $tb085_presupuesto->save($con);*/

                $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                $tb087_presupuesto_movimiento->setCoPartida($res["id_tb085_presupuesto"]);
                $tb087_presupuesto_movimiento->setNuMonto($res["mo_distribucion"]);
                $tb087_presupuesto_movimiento->setNuAnio( $this->getUser()->getAttribute('ejercicio'));
                //$tb087_presupuesto_movimiento->setCreatedAt(date("Y-m-d"));
                //$tb087_presupuesto_movimiento->setUpdatedAt(date("Y-m-d"));
                $tb087_presupuesto_movimiento->setCoUsuario($this->getUser()->getAttribute('codigo'));
                $tb087_presupuesto_movimiento->setCoTipoMovimiento(7);
                $tb087_presupuesto_movimiento->setTxObservacion('CREDITO ADICIONAL');
                $tb087_presupuesto_movimiento->setinActivo(true);
                $tb087_presupuesto_movimiento->save($con);

            }

        }
        
        $wherec = new Criteria();
        $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $tb142_cuenta_cobrarForm["co_solicitud"]);
        $wherec->add(Tb061AsientoContablePeer::CO_TIPO_ASIENTO, 11);
        BasePeer::doDelete($wherec, $con);
        
       $c = new Criteria();
       $c->add(Tb008ProveedorPeer::CO_PROVEEDOR,$tb142_cuenta_cobrarForm["co_proveedor"]);
       $stmt = Tb008ProveedorPeer::doSelectStmt($c);
       $reg = $stmt->fetch(PDO::FETCH_ASSOC); 
        
                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoHaber($tb142_cuenta_cobrarForm["mo_cuenta"])
                                  ->setCoCuentaContable($reg["co_cuenta_orden_pasivo"])
                                  ->setCoSolicitud($tb142_cuenta_cobrarForm["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCoTipoAsiento(11)
                                  ->setInActivo(true)
                                  ->save($con);        
                    
                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoDebe($tb142_cuenta_cobrarForm["mo_cuenta"])
                                  ->setCoCuentaContable($reg["co_cuenta_orden_activo"])
                                  ->setCoSolicitud($tb142_cuenta_cobrarForm["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCoTipoAsiento(11)
                                  ->setInActivo(true)
                                  ->save($con);                     
        

        $con->commit();

        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta()); 

        $this->data = json_encode(array(
            "success" => true,
            "codigo" => $tb142_cuenta_cobrar->getId(),
            "msg" => 'Datos cargados exitosamente!'
        ));

        }catch (PropelException $e){

            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }

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
	$tb142_cuenta_cobrar = Tb142CuentaCobrarPeer::retrieveByPk($codigo);			
	$tb142_cuenta_cobrar->delete($con);
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
                $co_solicitud      =   $this->getRequestParameter("co_solicitud");
            $co_usuario      =   $this->getRequestParameter("co_usuario");
            $co_proveedor      =   $this->getRequestParameter("co_proveedor");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $de_soporte      =   $this->getRequestParameter("de_soporte");
            $id_tb143_cuenta_concepto      =   $this->getRequestParameter("id_tb143_cuenta_concepto");
            $id_tb144_clase_ingreso      =   $this->getRequestParameter("id_tb144_clase_ingreso");
            $de_descripcion      =   $this->getRequestParameter("de_descripcion");
            $mo_cuenta      =   $this->getRequestParameter("mo_cuenta");
            $fe_documento      =   $this->getRequestParameter("fe_documento");
            $id_tb141_tipo_cuota      =   $this->getRequestParameter("id_tb141_tipo_cuota");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_solicitud!=""){$c->add(Tb142CuentaCobrarPeer::co_solicitud,$co_solicitud);}
    
                                            if($co_usuario!=""){$c->add(Tb142CuentaCobrarPeer::co_usuario,$co_usuario);}
    
                                            if($co_proveedor!=""){$c->add(Tb142CuentaCobrarPeer::co_proveedor,$co_proveedor);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb142CuentaCobrarPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb142CuentaCobrarPeer::updated_at,$fecha);
    }
                                        if($de_soporte!=""){$c->add(Tb142CuentaCobrarPeer::de_soporte,'%'.$de_soporte.'%',Criteria::LIKE);}
        
                                            if($id_tb143_cuenta_concepto!=""){$c->add(Tb142CuentaCobrarPeer::id_tb143_cuenta_concepto,$id_tb143_cuenta_concepto);}
    
                                            if($id_tb144_clase_ingreso!=""){$c->add(Tb142CuentaCobrarPeer::id_tb144_clase_ingreso,$id_tb144_clase_ingreso);}
    
                                        if($de_descripcion!=""){$c->add(Tb142CuentaCobrarPeer::de_descripcion,'%'.$de_descripcion.'%',Criteria::LIKE);}
        
                                            if($mo_cuenta!=""){$c->add(Tb142CuentaCobrarPeer::mo_cuenta,$mo_cuenta);}
    
                                    
        if($fe_documento!=""){
    list($dia, $mes,$anio) = explode("/",$fe_documento);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb142CuentaCobrarPeer::fe_documento,$fecha);
    }
                                            if($id_tb141_tipo_cuota!=""){$c->add(Tb142CuentaCobrarPeer::id_tb141_tipo_cuota,$id_tb141_tipo_cuota);}
    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb142CuentaCobrarPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb142CuentaCobrarPeer::ID);
        
    $stmt = Tb142CuentaCobrarPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "co_solicitud"     => trim($res["co_solicitud"]),
            "co_usuario"     => trim($res["co_usuario"]),
            "co_proveedor"     => trim($res["co_proveedor"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "de_soporte"     => trim($res["de_soporte"]),
            "id_tb143_cuenta_concepto"     => trim($res["id_tb143_cuenta_concepto"]),
            "id_tb144_clase_ingreso"     => trim($res["id_tb144_clase_ingreso"]),
            "de_descripcion"     => trim($res["de_descripcion"]),
            "mo_cuenta"     => trim($res["mo_cuenta"]),
            "fe_documento"     => trim($res["fe_documento"]),
            "id_tb141_tipo_cuota"     => trim($res["id_tb141_tipo_cuota"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                                                        //modelo fk tb143_cuenta_concepto.ID
    public function executeStorefkidtb143cuentaconcepto(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb143CuentaConceptoPeer::doSelectStmt($c);
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
                    //modelo fk tb144_clase_ingreso.ID
    public function executeStorefkidtb144claseingreso(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb144ClaseIngresoPeer::doSelectStmt($c);
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
                                                        //modelo fk tb141_tipo_cuota.ID
    public function executeStorefkidtb141tipocuota(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb141TipoCuotaPeer::doSelectStmt($c);
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