<?php

/**
 * TesoreriaIngreso actions.
 *
 * @package    gobel
 * @subpackage TesoreriaIngreso
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class TesoreriaIngresoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('TesoreriaIngreso', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('TesoreriaIngreso', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeIngresar(sfWebRequest $request)
  {

        $this->co_liquidacion_pago = $this->getRequestParameter('co_liquidacion_pago');
        $this->co_solicitud = $this->getRequestParameter('co_solicitud');
        $this->co_tipo_solicitud = $this->getRequestParameter('co_tipo_solicitud');

        $c = new Criteria();
        $c->add(Tb145CuentaCobrarDetallePeer::ID, $this->co_liquidacion_pago);
        $stmt = Tb145CuentaCobrarDetallePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $disponible = $campos["mo_cuota"] - $campos["mo_pagado"];

        $this->data = json_encode(array(
            "id"     => $campos["id"],
            "id_tb142_cuenta_cobrar"     => $campos["id_tb142_cuenta_cobrar"],
            "de_cuota"     => $campos["de_cuota"],
            "mo_cuota"     => $campos["mo_cuota"],
            "mo_pagado"     => $campos["mo_pagado"],
            "mo_pendiente"     => $campos["mo_pendiente"],
            "mo_disponible"     => $disponible,
        ));
  
  }

  public function executeDetalle(sfWebRequest $request)
  {
      $co_solicitud = $this->getRequestParameter("codigo");
      $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
      $co_proceso = $this->getRequestParameter("co_proceso");

          /*
           * {
                          title: 'Detalle del Tramite',
                          tabWidth:120,
                          autoLoad:{
                          url:'".$_SERVER["SCRIPT_NAME"]."/Solicitud/detalleSolicitud',
                          scripts: true,
                          params:{codigo:this.OBJ.co_solicitud,
                                  co_tipo_solicitud: this.OBJ.co_tipo_solicitud,
                                  co_proceso: this.OBJ.co_proceso }
                          }
                      },
           */
          if($co_tipo_solicitud==23){
              $this->tab = "
                      {
                          title: 'Pagos',
                          tabWidth:120,
                          autoLoad:{
                          url:'".$_SERVER["SCRIPT_NAME"]."/Tesoreria/detallePagosNomina',
                          scripts: true,
                          params:{codigo:this.OBJ.co_solicitud,
                                  co_tipo_solicitud: this.OBJ.co_tipo_solicitud,
                                  co_proceso: this.OBJ.co_proceso }
                          }
                      }";
              
          }else{
              $this->tab = "
                      {
                          title: 'Ingresos',
                          tabWidth:120,
                          autoLoad:{
                          url:'".$_SERVER["SCRIPT_NAME"]."/TesoreriaIngreso/detallePagos',
                          scripts: true,
                          params:{codigo:this.OBJ.co_solicitud,
                                  co_tipo_solicitud: this.OBJ.co_tipo_solicitud,
                                  co_proceso: this.OBJ.co_proceso }
                          }
                      }";
          }

          $this->DatosDetalle();
  }

  protected function DatosDetalle(){
    $codigo = $this->getRequestParameter("codigo");
    $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
    $co_proceso = $this->getRequestParameter("co_proceso");
    
    if($codigo!=''||$codigo!=null){
    $c = new Criteria();
    $c->add(Tb026SolicitudPeer::CO_SOLICITUD,$codigo);
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);   
    $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);   
    $c->addSelectColumn(Tb029EstatusPeer::TX_ESTATUS);
    $c->addSelectColumn(Tb026SolicitudPeer::CREATED_AT);
    $c->addSelectColumn(Tb026SolicitudPeer::TX_OBSERVACION);
    $c->addSelectColumn(Tb001UsuarioPeer::TX_LOGIN);
    $c->addSelectColumn(Tb001UsuarioPeer::NB_USUARIO);
    
    $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addJoin(Tb026SolicitudPeer::CO_ESTATUS, Tb029EstatusPeer::CO_ESTATUS);
    $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO);
    $stmt = Tb026SolicitudPeer::doSelectStmt($c);
    $campos = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
    $this->data = json_encode(array(
                        "co_solicitud"       => $campos["co_solicitud"], 
                        "tx_tipo_solicitud"  => $campos["tx_tipo_solicitud"],
                        "tx_estatus"         => $campos["tx_estatus"],
                        "fe_creacion"        => trim(date_format(date_create($campos["created_at"]),'d/m/Y')),
                        "tx_observacion"     => $campos["tx_observacion"],
                        "tx_login"           => $campos["tx_login"],
                        "nb_usuario"         => $campos["nb_usuario"],
                        "co_tipo_solicitud"  => $co_tipo_solicitud,
                        "co_proceso"         => $co_proceso
                ));
    }else{
        $this->data = json_encode(array(
                        "co_solicitud"          => "", 
                        "tx_tipo_solicitud"     => "",
                        "tx_estatus"            => "",
                        "fe_creacion"           => "",
                        "tx_observacion"        => "",
                        "tx_login"              => "",
                        "nb_usuario"            => "",
                        "co_tipo_solicitud"  => $co_tipo_solicitud,
                        "co_proceso"         => $co_proceso
                      
                    ));
    }
}

    public function executeDetallePagos(sfWebRequest $request){
        
        $co_solicitud = $this->getRequestParameter("codigo");
        $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
        $co_proceso = $this->getRequestParameter("co_proceso");

        $c = new Criteria();
        $c->add(Tb062LiquidacionPagoPeer::CO_SOLICITUD,$co_solicitud);
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);   
        $stmt = Tb062LiquidacionPagoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $encrip = new myConfig();
        
        $co_ruta = Tb030RutaPeer::getCoRuta($co_solicitud);
        
        $this->data = json_encode(array(
            "co_solicitud"        => $co_solicitud,
            "co_tipo_solicitud"   => $co_tipo_solicitud,
            "co_proceso"          => $co_proceso,
            "co_liquidacion_pago" => $campos["co_liquidacion_pago"],
            "co_ruta"             => $co_ruta    
        ));
        
        $this->accion      = sfContext::getInstance()->getActionName();
        $this->modulo      = sfContext::getInstance()->getModuleName();
        $this->url         = $_SERVER["SCRIPT_NAME"];
    }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb142CuentaCobrarPeer::ID,$codigo);
        
        $stmt = Tb142CuentaCobrarPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_usuario"     => $campos["co_usuario"],
                            "co_proveedor"     => $campos["co_proveedor"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "de_soporte"     => $campos["de_soporte"],
                            "id_tb143_cuenta_concepto"     => $campos["id_tb143_cuenta_concepto"],
                            "id_tb144_clase_ingreso"     => $campos["id_tb144_clase_ingreso"],
                            "de_descripcion"     => $campos["de_descripcion"],
                            "mo_cuenta"     => $campos["mo_cuenta"],
                            "fe_documento"     => $campos["fe_documento"],
                            "id_tb141_tipo_cuota"     => $campos["id_tb141_tipo_cuota"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "co_solicitud"     => "",
                            "co_usuario"     => "",
                            "co_proveedor"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "de_soporte"     => "",
                            "id_tb143_cuenta_concepto"     => "",
                            "id_tb144_clase_ingreso"     => "",
                            "de_descripcion"     => "",
                            "mo_cuenta"     => "",
                            "fe_documento"     => "",
                            "id_tb141_tipo_cuota"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb142_cuenta_cobrar = Tb142CuentaCobrarPeer::retrieveByPk($codigo);
     }else{
         $tb142_cuenta_cobrar = new Tb142CuentaCobrar();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb142_cuenta_cobrarForm = $this->getRequestParameter('tb142_cuenta_cobrar');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb142_cuenta_cobrar->setCoSolicitud($tb142_cuenta_cobrarForm["co_solicitud"]);
                                                        
        /*Campo tipo BIGINT */
        $tb142_cuenta_cobrar->setCoUsuario($tb142_cuenta_cobrarForm["co_usuario"]);
                                                        
        /*Campo tipo BIGINT */
        $tb142_cuenta_cobrar->setCoProveedor($tb142_cuenta_cobrarForm["co_proveedor"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb142_cuenta_cobrarForm)){
            $tb142_cuenta_cobrar->setInActivo(false);
        }else{
            $tb142_cuenta_cobrar->setInActivo(true);
        }
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb142_cuenta_cobrarForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb142_cuenta_cobrar->setCreatedAt($fecha);
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb142_cuenta_cobrarForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb142_cuenta_cobrar->setUpdatedAt($fecha);
                                                        
        /*Campo tipo VARCHAR */
        $tb142_cuenta_cobrar->setDeSoporte($tb142_cuenta_cobrarForm["de_soporte"]);
                                                        
        /*Campo tipo BIGINT */
        $tb142_cuenta_cobrar->setIdTb143CuentaConcepto($tb142_cuenta_cobrarForm["id_tb143_cuenta_concepto"]);
                                                        
        /*Campo tipo BIGINT */
        $tb142_cuenta_cobrar->setIdTb144ClaseIngreso($tb142_cuenta_cobrarForm["id_tb144_clase_ingreso"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb142_cuenta_cobrar->setDeDescripcion($tb142_cuenta_cobrarForm["de_descripcion"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb142_cuenta_cobrar->setMoCuenta($tb142_cuenta_cobrarForm["mo_cuenta"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb142_cuenta_cobrarForm["fe_documento"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb142_cuenta_cobrar->setFeDocumento($fecha);
                                                        
        /*Campo tipo BIGINT */
        $tb142_cuenta_cobrar->setIdTb141TipoCuota($tb142_cuenta_cobrarForm["id_tb141_tipo_cuota"]);
                                
        /*CAMPOS*/
        $tb142_cuenta_cobrar->save($con);
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
   
    $limit         =   $this->getRequestParameter("limit",20);
    $start         =   $this->getRequestParameter("start",0);
    $in_ventanilla = $this->getRequestParameter("in_ventanilla");
    $co_proceso    =   $this->getRequestParameter("co_proceso");
    $co_solicitud  =   $this->getRequestParameter("co_solicitud");
    
    $co_documento     =   $this->getRequestParameter("co_documento");
    $nu_cedula_rif    =   $this->getRequestParameter("nu_cedula_rif");
    $tx_razon_social  =   $this->getRequestParameter("tx_razon_social");    
    
    $c = new Criteria();  
    $c->clearSelectColumns();
    
    if($co_proceso!=''){
        $c->add(Tb028ProcesoPeer::CO_PROCESO,$co_proceso);
    }
    
    if($co_documento!=''){
        $c->add(Tb007DocumentoPeer::CO_DOCUMENTO,$co_documento);
    }
    
    if($nu_cedula_rif!=''){
        $c->add(Tb008ProveedorPeer::TX_RIF,$nu_cedula_rif);
    }
    
    if($tx_razon_social!=''){
        $c->add(Tb008ProveedorPeer::TX_RAZON_SOCIAL,'%'.$tx_razon_social.'%',Criteria::LIKE);
    }
        
    
    if($co_solicitud!=''){
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD,$co_solicitud);
    }
    
    if($in_ventanilla=='true'){
        $c->add(Tb030RutaPeer::NU_ORDEN,1);
    }else{
        $c->add(Tb030RutaPeer::NU_ORDEN,1,  Criteria::GREATER_THAN);
    }
    
   
    $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));
    $registro_tramite = Tb006TipoSolicitudUsuarioPeer::getListaTramiteAsignado($this->getUser()->getAttribute('codigo'));
      
                              
    $c->setIgnoreCase(true);
    $c->addSelectColumn(Tb030RutaPeer::CO_SOLICITUD);
    $c->addSelectColumn(Tb030RutaPeer::CO_PROCESO);
    $c->addSelectColumn(Tb030RutaPeer::CO_RUTA);
    $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD); 
    $c->addSelectColumn(Tb001UsuarioPeer::TX_LOGIN);   
    $c->addSelectColumn(Tb026SolicitudPeer::CREATED_AT); 
    $c->addSelectColumn(Tb026SolicitudPeer::CO_PERSONA);  
    
    
    $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);

    $c->addJoin(Tb142CuentaCobrarPeer::CO_PROVEEDOR,Tb008ProveedorPeer::CO_PROVEEDOR,   Criteria::LEFT_JOIN);
    $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO,  Tb007DocumentoPeer::CO_DOCUMENTO,   Criteria::LEFT_JOIN);

    $c->addJoin(Tb142CuentaCobrarPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        
    $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addJoin(Tb028ProcesoPeer::CO_PROCESO, Tb030RutaPeer::CO_PROCESO);
    $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
    $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO);

    $c->addJoin(Tb142CuentaCobrarPeer::ID, Tb145CuentaCobrarDetallePeer::ID_TB142_CUENTA_COBRAR);
    $c->addAnd(Tb145CuentaCobrarDetallePeer::IN_PAGO, false);
    
  //  $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD,$registro_tramite,Criteria::IN);
    $c->addAnd(Tb030RutaPeer::CO_PROCESO,42,Criteria::IN);
    
    $c->addAnd(Tb030RutaPeer::CO_ESTATUS_RUTA,1);
    $c->addAnd(Tb030RutaPeer::IN_ACTUAL,true);
    $c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
    
    //echo $c->toString(); exit();
    
    //$c->addAnd(Tb026SolicitudPeer::CO_USUARIO,$this->getUser()->getAttribute('codigo'));
    $cantidadTotal = Tb026SolicitudPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb026SolicitudPeer::CO_SOLICITUD);
        
    
    $stmt = Tb026SolicitudPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        
        $cantidad = Tb026SolicitudPeer::getCantRevision($res["co_solicitud"]);

        $tx_rif = $res["inicial"]."-".$res["tx_rif"];
        $tx_razon_social = strtoupper($res["tx_razon_social"]);
        
         if($res["tx_rif"]==''){
            if($res["co_persona"]!=''){
                $datos_persona = $this->getDatosPersona($res["co_persona"]);
                $tx_rif = $datos_persona["inicial"]."-".$datos_persona["nu_cedula"];
                $tx_razon_social = strtoupper($datos_persona["nb_persona"].' '.$datos_persona["ap_persona"]);
            }            
        }
        
        

        list($anio,$mes,$dia) = explode('-',$res["created_at"]);
        $registros[] = array(
                "tx_proceso"        => trim($res["tx_proceso"]),
                "co_ruta"           => trim($res["co_ruta"]),
                "co_solicitud"      => trim($res["co_solicitud"]),
                "co_proceso"        => trim($res["co_proceso"]),
                "tx_tipo_solicitud" => trim($res["tx_tipo_solicitud"]),
                "co_tipo_solicitud" => trim($res["co_tipo_solicitud"]),
                "co_solicitud"      => trim($res["co_solicitud"]),
                "tx_login"          => trim($res["tx_login"]),
                "tx_rif"            => $tx_rif,
                "tx_razon_social"   => $tx_razon_social,
                "fe_creacion"       => $dia.'-'.$mes.'-'.$anio,
                "cant_revision"     => $cantidad
            );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

    public function executeStorelistaIngresado(sfWebRequest $request)
    {
     
      $limit         =   $this->getRequestParameter("limit",20);
      $start         =   $this->getRequestParameter("start",0);
      $in_ventanilla = $this->getRequestParameter("in_ventanilla");
      $co_proceso    =   $this->getRequestParameter("co_proceso");
      $co_solicitud  =   $this->getRequestParameter("co_solicitud");
      
      $co_documento     =   $this->getRequestParameter("co_documento");
      $nu_cedula_rif    =   $this->getRequestParameter("nu_cedula_rif");
      $tx_razon_social  =   $this->getRequestParameter("tx_razon_social");    
      
      $c = new Criteria();  
      $c->clearSelectColumns();
      
      if($co_proceso!=''){
          $c->add(Tb028ProcesoPeer::CO_PROCESO,$co_proceso);
      }
      
      if($co_documento!=''){
          $c->add(Tb007DocumentoPeer::CO_DOCUMENTO,$co_documento);
      }
      
      if($nu_cedula_rif!=''){
          $c->add(Tb008ProveedorPeer::TX_RIF,$nu_cedula_rif);
      }
      
      if($tx_razon_social!=''){
          $c->add(Tb008ProveedorPeer::TX_RAZON_SOCIAL,'%'.$tx_razon_social.'%',Criteria::LIKE);
      }
          
      
      if($co_solicitud!=''){
          $c->add(Tb026SolicitudPeer::CO_SOLICITUD,$co_solicitud);
      }
      
      if($in_ventanilla=='true'){
          $c->add(Tb030RutaPeer::NU_ORDEN,1);
      }else{
          $c->add(Tb030RutaPeer::NU_ORDEN,1,  Criteria::GREATER_THAN);
      }
      
     
      $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));
      $registro_tramite = Tb006TipoSolicitudUsuarioPeer::getListaTramiteAsignado($this->getUser()->getAttribute('codigo'));
        
                                
      $c->setIgnoreCase(true);
      $c->addSelectColumn(Tb030RutaPeer::CO_SOLICITUD);
      $c->addSelectColumn(Tb030RutaPeer::CO_PROCESO);
      $c->addSelectColumn(Tb030RutaPeer::CO_RUTA);
      $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
      $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
      $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
      $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD); 
      $c->addSelectColumn(Tb001UsuarioPeer::TX_LOGIN);   
      $c->addSelectColumn(Tb026SolicitudPeer::CREATED_AT); 
      $c->addSelectColumn(Tb026SolicitudPeer::CO_PERSONA);  
      
      
      $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
      $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
      $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
  
      $c->addJoin(Tb142CuentaCobrarPeer::CO_PROVEEDOR,Tb008ProveedorPeer::CO_PROVEEDOR,   Criteria::LEFT_JOIN);
      $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO,  Tb007DocumentoPeer::CO_DOCUMENTO,   Criteria::LEFT_JOIN);
  
      $c->addJoin(Tb142CuentaCobrarPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
          
      $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
      $c->addJoin(Tb028ProcesoPeer::CO_PROCESO, Tb030RutaPeer::CO_PROCESO);
      $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
      $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO);

      $c->addJoin(Tb142CuentaCobrarPeer::ID, Tb145CuentaCobrarDetallePeer::ID_TB142_CUENTA_COBRAR);
      $c->addAnd(Tb145CuentaCobrarDetallePeer::IN_PAGO, true);
      
    //  $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD,$registro_tramite,Criteria::IN);
      $c->addAnd(Tb030RutaPeer::CO_PROCESO,42,Criteria::IN);
      
      $c->addAnd(Tb030RutaPeer::CO_ESTATUS_RUTA,1);
      $c->addAnd(Tb030RutaPeer::IN_ACTUAL,true);
      $c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
      
      //echo $c->toString(); exit();
      
      //$c->addAnd(Tb026SolicitudPeer::CO_USUARIO,$this->getUser()->getAttribute('codigo'));
      $cantidadTotal = Tb026SolicitudPeer::doCount($c);
      
      $c->setLimit($limit)->setOffset($start);
      $c->addAscendingOrderByColumn(Tb026SolicitudPeer::CO_SOLICITUD);
          
      
      $stmt = Tb026SolicitudPeer::doSelectStmt($c);
      $registros = "";
      while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
          
          
          $cantidad = Tb026SolicitudPeer::getCantRevision($res["co_solicitud"]);
  
          $tx_rif = $res["inicial"]."-".$res["tx_rif"];
          $tx_razon_social = strtoupper($res["tx_razon_social"]);
          
           if($res["tx_rif"]==''){
              if($res["co_persona"]!=''){
                  $datos_persona = $this->getDatosPersona($res["co_persona"]);
                  $tx_rif = $datos_persona["inicial"]."-".$datos_persona["nu_cedula"];
                  $tx_razon_social = strtoupper($datos_persona["nb_persona"].' '.$datos_persona["ap_persona"]);
              }            
          }
          
          
  
          list($anio,$mes,$dia) = explode('-',$res["created_at"]);
          $registros[] = array(
                  "tx_proceso"        => trim($res["tx_proceso"]),
                  "co_ruta"           => trim($res["co_ruta"]),
                  "co_solicitud"      => trim($res["co_solicitud"]),
                  "co_proceso"        => trim($res["co_proceso"]),
                  "tx_tipo_solicitud" => trim($res["tx_tipo_solicitud"]),
                  "co_tipo_solicitud" => trim($res["co_tipo_solicitud"]),
                  "co_solicitud"      => trim($res["co_solicitud"]),
                  "tx_login"          => trim($res["tx_login"]),
                  "tx_rif"            => $tx_rif,
                  "tx_razon_social"   => $tx_razon_social,
                  "fe_creacion"       => $dia.'-'.$mes.'-'.$anio,
                  "cant_revision"     => $cantidad
              );
      }
  
      $this->data = json_encode(array(
          "success"   =>  true,
          "total"     =>  $cantidadTotal,
          "data"      =>  $registros
          ));
      }

    public function executeListaPendiente()
    {
        $codigo      =   $this->getRequestParameter("co_solicitud");
        
        $c = new Criteria();   
        $c->add(Tb142CuentaCobrarPeer::CO_SOLICITUD, $codigo);
        $c->add(Tb145CuentaCobrarDetallePeer::IN_PAGO, false);
        $c->addSelectColumn(Tb142CuentaCobrarPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb145CuentaCobrarDetallePeer::ID);
        $c->addSelectColumn(Tb145CuentaCobrarDetallePeer::DE_CUOTA);
        $c->addSelectColumn(Tb145CuentaCobrarDetallePeer::MO_CUOTA);
        $c->addSelectColumn(Tb145CuentaCobrarDetallePeer::MO_PAGADO);
        $c->addSelectColumn(Tb145CuentaCobrarDetallePeer::MO_PENDIENTE);
        $c->addSelectColumn(Tb145CuentaCobrarDetallePeer::FE_PAGO);
        $c->addSelectColumn(Tb143CuentaConceptoPeer::DE_CUENTA_CONCEPTO);
        $c->addJoin(Tb145CuentaCobrarDetallePeer::ID_TB142_CUENTA_COBRAR, Tb142CuentaCobrarPeer::ID);
        $c->addJoin(Tb142CuentaCobrarPeer::ID_TB143_CUENTA_CONCEPTO, Tb143CuentaConceptoPeer::ID);
        $stmt = Tb145CuentaCobrarDetallePeer::doSelectStmt($c);

        $cantidadTotal = Tb026SolicitudPeer::doCount($c);

        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){

            //var_dump($res);

            $registros[] = array(
                "co_liquidacion_pago"     => trim($res["id"]),
                "de_cuenta_concepto"     => trim($res["de_cuenta_concepto"]),
                "de_cuota"     => trim($res["de_cuota"]),
                "mo_cuota"     => trim($res["mo_cuota"]),
                "fe_pago"     => trim(date("d-m-Y", strtotime($res["fe_pago"]))),
                "mo_pagado"     => trim($res["mo_pagado"]),
                "mo_pendiente"     => trim($res["mo_pendiente"]),
            );
        }
  
        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));
    }   

    public function executeListaPagos()
    {
        $codigo      =   $this->getRequestParameter("co_solicitud");
        
        $c = new Criteria();   
        $c->add(Tb142CuentaCobrarPeer::CO_SOLICITUD, $codigo);
        $c->add(Tb145CuentaCobrarDetallePeer::IN_PAGO, true);
        $c->addSelectColumn(Tb142CuentaCobrarPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb145CuentaCobrarDetallePeer::ID);
        $c->addSelectColumn(Tb145CuentaCobrarDetallePeer::DE_CUOTA);
        $c->addSelectColumn(Tb145CuentaCobrarDetallePeer::MO_CUOTA);
        $c->addSelectColumn(Tb145CuentaCobrarDetallePeer::MO_PAGADO);
        $c->addSelectColumn(Tb145CuentaCobrarDetallePeer::MO_PENDIENTE);
        $c->addSelectColumn(Tb145CuentaCobrarDetallePeer::FE_PAGO);
        $c->addSelectColumn(Tb143CuentaConceptoPeer::DE_CUENTA_CONCEPTO);
        $c->addJoin(Tb145CuentaCobrarDetallePeer::ID_TB142_CUENTA_COBRAR, Tb142CuentaCobrarPeer::ID);
        $c->addJoin(Tb142CuentaCobrarPeer::ID_TB143_CUENTA_CONCEPTO, Tb143CuentaConceptoPeer::ID);
        $stmt = Tb145CuentaCobrarDetallePeer::doSelectStmt($c);

        $cantidadTotal = Tb026SolicitudPeer::doCount($c);

        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){

            //var_dump($res);

            $registros[] = array(
                "co_liquidacion_pago"     => trim($res["id"]),
                "de_cuenta_concepto"     => trim($res["de_cuenta_concepto"]),
                "de_cuota"     => trim($res["de_cuota"]),
                "mo_cuota"     => trim($res["mo_cuota"]),
                "fe_pago"     => trim(date("d-m-Y", strtotime($res["fe_pago"]))),
                "mo_pagado"     => trim($res["mo_pagado"]),
                "mo_pendiente"     => trim($res["mo_pendiente"]),
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
        

    public function executeStorefktipodocumento(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb147TipoDocumentoPeer::doSelectStmt($c);
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

    public function executeStoreTransaccionCuenta(sfWebRequest $request){

        $id_tb011_cuenta_bancaria = $this->getRequestParameter("cuenta");

        $c = new Criteria();
        $c->add(Tb155CuentaBancariaHistoricoPeer::ID_TB011_CUENTA_BANCARIA, $id_tb011_cuenta_bancaria);
        $c->add(Tb155CuentaBancariaHistoricoPeer::IN_CONCILIADO, FALSE);
        $c->add(Tb155CuentaBancariaHistoricoPeer::FE_TRANSACCION, "date_part('year', tb155_cuenta_bancaria_historico.fe_transaccion) = ".$this->getUser()->getAttribute('ejercicio'), Criteria::CUSTOM);
        $c->add(Tb155CuentaBancariaHistoricoPeer::ID_TB154_TIPO_CUENTA_MOVIMIENTO, 4);
        $stmt = Tb155CuentaBancariaHistoricoPeer::doSelectStmt($c);
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
    
    public function executeStorePartidaIngreso(sfWebRequest $request){

        $co_solicitud = $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB064_PRESUPUESTO_INGRESO);
        $c->addSelectColumn(Tb064PresupuestoIngresoPeer::TX_DESCRIPCION);
        $c->add(Tb096PresupuestoModificacionPeer::CO_SOLICITUD, $co_solicitud);
        $c->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
        $c->addJoin(Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO, Tb097ModificacionDetallePeer::ID_TB064_PRESUPUESTO_INGRESO);
        $c->addJoin(Tb096PresupuestoModificacionPeer::ID, Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION);
        $stmt = Tb097ModificacionDetallePeer::doSelectStmt($c);
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

    public function executeRealizado(sfWebRequest $request)
    {

        
    }


}