<?php

/**
 * Nomina actions.
 *
 * @package    gobel
 * @subpackage Nomina
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class NominaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Nomina', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Nomina', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh013NominaPeer::CO_NOMINA,$codigo);
        
        $stmt = Tbrh013NominaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_nomina"     => $campos["co_nomina"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_tp_nomina"     => $campos["co_tp_nomina"],
                            "co_nom_frecuencia_pago"     => $campos["co_nom_frecuencia_pago"],
                            "nu_nomina"     => $campos["nu_nomina"],
                            "de_nomina"     => $campos["de_nomina"],
                            "de_observacion"     => $campos["de_observacion"],
                            "fe_inicio"     => $campos["fe_inicio"],
                            "fe_fin"     => $campos["fe_fin"],
                            "fe_pago"     => $campos["fe_pago"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "in_procesado"     => $campos["in_procesado"],
                            "id_tbrh060_nomina_estatus"     => $campos["id_tbrh060_nomina_estatus"],
                            "co_grupo_nomina"     => $campos["co_grupo_nomina"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_nomina"     => "",
                            "co_solicitud"     => "",
                            "co_tp_nomina"     => "",
                            "co_nom_frecuencia_pago"     => "",
                            "nu_nomina"     => "",
                            "de_nomina"     => "",
                            "de_observacion"     => "",
                            "fe_inicio"     => "",
                            "fe_fin"     => "",
                            "fe_pago"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "in_procesado"     => "",
                            "id_tbrh060_nomina_estatus"     => "",
                            "co_grupo_nomina"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_nomina");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh013_nomina = Tbrh013NominaPeer::retrieveByPk($codigo);
     }else{
         $tbrh013_nomina = new Tbrh013Nomina();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh013_nominaForm = $this->getRequestParameter('tbrh013_nomina');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tbrh013_nomina->setCoSolicitud($tbrh013_nominaForm["co_solicitud"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh013_nomina->setCoTpNomina($tbrh013_nominaForm["co_tp_nomina"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh013_nomina->setCoNomFrecuenciaPago($tbrh013_nominaForm["co_nom_frecuencia_pago"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh013_nomina->setNuNomina($tbrh013_nominaForm["nu_nomina"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh013_nomina->setDeNomina($tbrh013_nominaForm["de_nomina"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh013_nomina->setDeObservacion($tbrh013_nominaForm["de_observacion"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tbrh013_nominaForm["fe_inicio"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh013_nomina->setFeInicio($fecha);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tbrh013_nominaForm["fe_fin"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh013_nomina->setFeFin($fecha);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tbrh013_nominaForm["fe_pago"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh013_nomina->setFePago($fecha);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tbrh013_nominaForm)){
            $tbrh013_nomina->setInActivo(false);
        }else{
            $tbrh013_nomina->setInActivo(true);
        }
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tbrh013_nominaForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh013_nomina->setCreatedAt($fecha);
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tbrh013_nominaForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh013_nomina->setUpdatedAt($fecha);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_procesado", $tbrh013_nominaForm)){
            $tbrh013_nomina->setInProcesado(false);
        }else{
            $tbrh013_nomina->setInProcesado(true);
        }
                                                        
        /*Campo tipo BIGINT */
        $tbrh013_nomina->setIdTbrh060NominaEstatus($tbrh013_nominaForm["id_tbrh060_nomina_estatus"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh013_nomina->setCoGrupoNomina($tbrh013_nominaForm["co_grupo_nomina"]);
                                
        /*CAMPOS*/
        $tbrh013_nomina->save($con);
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
  
  public function executeGuardarCheque(sfWebRequest $request)
  {

        $json_embargos = $this->getRequestParameter("hiddenJsonembargos");
        $nu_cheque_inicial = $this->getRequestParameter("nu_cheque_inicial");
        $nu_clave = $this->getRequestParameter("nu_clave");
        
     $con = Propel::getConnection();
     try
      { 
        $con->beginTransaction();
        $i = 0;
        $listaEmbargos  = json_decode($json_embargos,true);
        foreach($listaEmbargos  as $EmbargosForm){
/*CAMPOS*/
        $nu_cheque = $nu_cheque_inicial + $i;
        $tbrh102_cierre_nomina_trabajador = Tbrh102CierreNominaTrabajadorPeer::retrieveByPk($EmbargosForm["id"]);      
        $tbrh102_cierre_nomina_trabajador->setNuCheque($nu_cheque);
        $tbrh102_cierre_nomina_trabajador->setNuClave($nu_clave);
        $tbrh102_cierre_nomina_trabajador->save($con);
        $i++;
        }                    

        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Cheques Generados exitosamente'
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
	$codigo = $this->getRequestParameter("co_nomina");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh013_nomina = Tbrh013NominaPeer::retrieveByPk($codigo);			
	$tbrh013_nomina->delete($con);
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

  public function executeCerradaLista(sfWebRequest $request)
  {
    $this->data = json_encode(array(
		"co_rol"         => $this->getUser()->getAttribute('rol'),
		"co_usuario"     => $this->getUser()->getAttribute('codigo'),
	));
  }

    public function executeChequeEmbargo(sfWebRequest $request)
  {
    $this->co_nomina = $this->getRequestParameter("codigo");   

  }  
  
  public function executeStorelistaCerrado(sfWebRequest $request)
  {
   
    $limit         =   $this->getRequestParameter("limit",12);
    $start         =   $this->getRequestParameter("start",0);
    $in_ventanilla = $this->getRequestParameter("in_ventanilla");
    $co_proceso    =   $this->getRequestParameter("co_proceso");
    $co_solicitud  =   $this->getRequestParameter("co_solicitud");
    
    $co_documento     =   $this->getRequestParameter("co_documento");
    $nu_cedula_rif    =   $this->getRequestParameter("nu_cedula_rif");
    $tx_razon_social  =   $this->getRequestParameter("tx_razon_social");
    $tx_serial        =   $this->getRequestParameter("tx_serial");
    
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
    
    if($tx_serial!=''){
        $c->add(Tb060OrdenPagoPeer::TX_SERIAL,$tx_serial);
    }
    
   
    $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));
    $registro_tramite = Tb006TipoSolicitudUsuarioPeer::getListaTramiteAsignado($this->getUser()->getAttribute('codigo'));
      
                              
    $c->setIgnoreCase(true);
    $c->addSelectColumn(Tb030RutaPeer::CO_PROCESO);
    $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);    
    $c->addSelectColumn(Tb001UsuarioPeer::TX_LOGIN);   
    $c->addSelectColumn(Tb026SolicitudPeer::CREATED_AT);  
    //$c->addSelectColumn(Tb060OrdenPagoPeer::TX_SERIAL);  
    
    //$c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
    //$c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
    //$c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);    

    //$c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR,Tb008ProveedorPeer::CO_PROVEEDOR,   Criteria::LEFT_JOIN);
    //$c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO,  Tb007DocumentoPeer::CO_DOCUMENTO,   Criteria::LEFT_JOIN);
   // $c->addJoin(Tb060OrdenPagoPeer::CO_SOLICITUD, Tb026SolicitudPeer::CO_SOLICITUD);
    
    $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addJoin(Tb028ProcesoPeer::CO_PROCESO, Tb030RutaPeer::CO_PROCESO);
    $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
    $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO);
    
   // $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD,$registro_tramite,Criteria::IN);
    $c->addAnd(Tb030RutaPeer::CO_PROCESO,60,Criteria::IN);
   // $c->addAnd(Tb030RutaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
    
    $c->addAnd(Tb030RutaPeer::CO_ESTATUS_RUTA,2);
    //$c->addAnd(Tb030RutaPeer::IN_ACTUAL,FALSE);
    $c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
    
    //$c->addAnd(Tb026SolicitudPeer::CO_USUARIO,$this->getUser()->getAttribute('codigo'));
    $cantidadTotal = Tb026SolicitudPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addDescendingOrderByColumn(Tb026SolicitudPeer::CO_SOLICITUD);
        
    $stmt = Tb026SolicitudPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        
        $cantidad = Tb026SolicitudPeer::getCantRevision($res["co_solicitud"]);

        $tx_rif = $res["inicial"]."-".$res["tx_rif"];
        $tx_razon_social = strtoupper($res["tx_razon_social"]);
        list($anio,$mes,$dia) = explode('-',$res["created_at"]);
        $registros[] = array(
                "tx_proceso"        => trim($res["tx_proceso"]),
                "co_proceso"        => trim($res["co_proceso"]),
                "tx_tipo_solicitud" => trim($res["tx_tipo_solicitud"]),
                "co_tipo_solicitud" => trim($res["co_tipo_solicitud"]),
                "co_solicitud"      => trim($res["co_solicitud"]),
                "tx_login"          => trim($res["tx_login"]),
                "tx_serial"         => Tb060OrdenPagoPeer::getODP($res["co_solicitud"]),
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

  public function executeLista(sfWebRequest $request)
  {

  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $co_solicitud      =   $this->getRequestParameter("co_solicitud");
            $co_tp_nomina      =   $this->getRequestParameter("co_tp_nomina");
            $co_nom_frecuencia_pago      =   $this->getRequestParameter("co_nom_frecuencia_pago");
            $nu_nomina      =   $this->getRequestParameter("nu_nomina");
            $de_nomina      =   $this->getRequestParameter("de_nomina");
            $de_observacion      =   $this->getRequestParameter("de_observacion");
            $fe_inicio      =   $this->getRequestParameter("fe_inicio");
            $fe_fin      =   $this->getRequestParameter("fe_fin");
            $fe_pago      =   $this->getRequestParameter("fe_pago");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $in_procesado      =   $this->getRequestParameter("in_procesado");
            $id_tbrh060_nomina_estatus      =   $this->getRequestParameter("id_tbrh060_nomina_estatus");
            $co_grupo_nomina      =   $this->getRequestParameter("co_grupo_nomina");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_solicitud!=""){$c->add(Tbrh013NominaPeer::co_solicitud,$co_solicitud);}
    
                                            if($co_tp_nomina!=""){$c->add(Tbrh013NominaPeer::co_tp_nomina,$co_tp_nomina);}
    
                                            if($co_nom_frecuencia_pago!=""){$c->add(Tbrh013NominaPeer::co_nom_frecuencia_pago,$co_nom_frecuencia_pago);}
    
                                        if($nu_nomina!=""){$c->add(Tbrh013NominaPeer::nu_nomina,'%'.$nu_nomina.'%',Criteria::LIKE);}
        
                                        if($de_nomina!=""){$c->add(Tbrh013NominaPeer::de_nomina,'%'.$de_nomina.'%',Criteria::LIKE);}
        
                                        if($de_observacion!=""){$c->add(Tbrh013NominaPeer::de_observacion,'%'.$de_observacion.'%',Criteria::LIKE);}
        
                                    
        if($fe_inicio!=""){
    list($dia, $mes,$anio) = explode("/",$fe_inicio);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh013NominaPeer::fe_inicio,$fecha);
    }
                                    
        if($fe_fin!=""){
    list($dia, $mes,$anio) = explode("/",$fe_fin);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh013NominaPeer::fe_fin,$fecha);
    }
                                    
        if($fe_pago!=""){
    list($dia, $mes,$anio) = explode("/",$fe_pago);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh013NominaPeer::fe_pago,$fecha);
    }
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh013NominaPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh013NominaPeer::updated_at,$fecha);
    }
                                    
                                            if($id_tbrh060_nomina_estatus!=""){$c->add(Tbrh013NominaPeer::id_tbrh060_nomina_estatus,$id_tbrh060_nomina_estatus);}
    
                                            if($co_grupo_nomina!=""){$c->add(Tbrh013NominaPeer::co_grupo_nomina,$co_grupo_nomina);}
    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh013NominaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh013NominaPeer::CO_NOMINA);
        
    $stmt = Tbrh013NominaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_nomina"     => trim($res["co_nomina"]),
            "co_solicitud"     => trim($res["co_solicitud"]),
            "co_tp_nomina"     => trim($res["co_tp_nomina"]),
            "co_nom_frecuencia_pago"     => trim($res["co_nom_frecuencia_pago"]),
            "nu_nomina"     => trim($res["nu_nomina"]),
            "de_nomina"     => trim($res["de_nomina"]),
            "de_observacion"     => trim($res["de_observacion"]),
            "fe_inicio"     => trim($res["fe_inicio"]),
            "fe_fin"     => trim($res["fe_fin"]),
            "fe_pago"     => trim($res["fe_pago"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "in_procesado"     => trim($res["in_procesado"]),
            "id_tbrh060_nomina_estatus"     => trim($res["id_tbrh060_nomina_estatus"]),
            "co_grupo_nomina"     => trim($res["co_grupo_nomina"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                //modelo fk tbrh017_tp_nomina.CO_TP_NOMINA
    public function executeStorefkcotpnomina(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh017TpNominaPeer::doSelectStmt($c);
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
                    //modelo fk tbrh023_nom_frecuencia_pago.CO_NOM_FRECUENCIA_PAGO
    public function executeStorefkconomfrecuenciapago(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh023NomFrecuenciaPagoPeer::doSelectStmt($c);
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
                                                                                                                                            //modelo fk tbrh060_nomina_estatus.ID
    public function executeStorefkidtbrh060nominaestatus(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh060NominaEstatusPeer::doSelectStmt($c);
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
                    
    public function executeDetalleRealizados(sfWebRequest $request)
    {

            $this->tab = "{
                            title: 'Detalle del Tramite',
                            tabWidth:120,
                            autoLoad:{
                            url:'".$_SERVER["SCRIPT_NAME"]."/Solicitud/detalleProcesadoSolicitud',
                            scripts: true,
                            params:{codigo:this.OBJ.co_solicitud,
                                    co_tipo_solicitud: this.OBJ.co_tipo_solicitud,
                                    co_proceso: this.OBJ.co_proceso }
                            }
                        },
                        {
                            title: 'Pagos',
                            tabWidth:120,
                            autoLoad:{
                            url:'".$_SERVER["SCRIPT_NAME"]."/Nomina/detallePagosRealizados',
                            scripts: true,
                            params:{
                                    codigo:this.OBJ.co_solicitud,
                                    co_tipo_solicitud: this.OBJ.co_tipo_solicitud,
                                    co_proceso: this.OBJ.co_proceso
                            }
                            }
                        }";

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

   public function executeDetallePagosRealizados(sfWebRequest $request){
        $co_solicitud = $this->getRequestParameter("codigo");
        $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
        $co_proceso = $this->getRequestParameter("co_proceso");
    
        $this->data = json_encode(array(
            "co_solicitud"        =>  $co_solicitud,
            "co_tipo_solicitud"   => $co_tipo_solicitud,
            "co_proceso"          => $co_proceso,
            "co_ruta"             => ($campos["co_ruta"]=='')?$this->getCoRuta($co_solicitud):$campos["co_ruta"],
        ));
        
        $this->accion      = sfContext::getInstance()->getActionName();
        $this->modulo      = sfContext::getInstance()->getModuleName();
        $this->url         = $_SERVER["SCRIPT_NAME"];
    }  

    protected function getCoRuta($co_solicitud){
        $c = new Criteria();
        $c->add(Tb030RutaPeer::CO_SOLICITUD,$co_solicitud);
        $c->add(Tb030RutaPeer::IN_ACTUAL,TRUE);
        $stmt = Tb030RutaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos["co_ruta"];
    }

    public function executeStorelistaFinal(sfWebRequest $request)
    {
      $paginar    =   $this->getRequestParameter("paginar");
      $limit      =   $this->getRequestParameter("limit",20);
      $start      =   $this->getRequestParameter("start",0);
                  $co_solicitud      =   $this->getRequestParameter("co_solicitud");
              $co_tp_nomina      =   $this->getRequestParameter("co_tp_nomina");
              $co_nom_frecuencia_pago      =   $this->getRequestParameter("co_nom_frecuencia_pago");
              $nu_nomina      =   $this->getRequestParameter("nu_nomina");
              $de_nomina      =   $this->getRequestParameter("de_nomina");
              $de_observacion      =   $this->getRequestParameter("de_observacion");
              $fe_inicio      =   $this->getRequestParameter("fe_inicio");
              $fe_fin      =   $this->getRequestParameter("fe_fin");
              $fe_pago      =   $this->getRequestParameter("fe_pago");
              $in_activo      =   $this->getRequestParameter("in_activo");
              $created_at      =   $this->getRequestParameter("created_at");
              $updated_at      =   $this->getRequestParameter("updated_at");
              $in_procesado      =   $this->getRequestParameter("in_procesado");
      
      
      $c = new Criteria();   
  
      if($this->getRequestParameter("BuscarBy")=="true"){
                                      if($co_solicitud!=""){$c->add(Tbrh013NominaPeer::CO_SOLICITUD,$co_solicitud);}
      
                                              if($co_tp_nomina!=""){$c->add(Tbrh013NominaPeer::CO_TP_NOMINA,$co_tp_nomina);}
      
                                              if($co_nom_frecuencia_pago!=""){$c->add(Tbrh013NominaPeer::CO_NOM_FRECUENCIA_PAGO,$co_nom_frecuencia_pago);}
      
                                          if($nu_nomina!=""){$c->add(Tbrh013NominaPeer::NU_NOMINA,'%'.$nu_nomina.'%',Criteria::LIKE);}
          
                                          if($de_nomina!=""){$c->add(Tbrh013NominaPeer::DE_NOMINA,'%'.$de_nomina.'%',Criteria::LIKE);}
          
                                          if($de_observacion!=""){$c->add(Tbrh013NominaPeer::DE_OBSERVACION,'%'.$de_observacion.'%',Criteria::LIKE);}
          
                                      
          if($fe_inicio!=""){
      list($dia, $mes,$anio) = explode("/",$fe_inicio);
      $fecha = $anio."-".$mes."-".$dia;
      $c->add(Tbrh013NominaPeer::FE_INICIO,$fecha);
      }
                                      
          if($fe_fin!=""){
      list($dia, $mes,$anio) = explode("/",$fe_fin);
      $fecha = $anio."-".$mes."-".$dia;
      $c->add(Tbrh013NominaPeer::FE_FIN,$fecha);
      }
                                      
          if($fe_pago!=""){
      list($dia, $mes,$anio) = explode("/",$fe_pago);
      $fecha = $anio."-".$mes."-".$dia;
      $c->add(Tbrh013NominaPeer::fe_pago,$fecha);
      }
                                      
                                      
          if($created_at!=""){
      list($dia, $mes,$anio) = explode("/",$created_at);
      $fecha = $anio."-".$mes."-".$dia;
      $c->add(Tbrh013NominaPeer::created_at,$fecha);
      }
                                      
          if($updated_at!=""){
      list($dia, $mes,$anio) = explode("/",$updated_at);
      $fecha = $anio."-".$mes."-".$dia;
      $c->add(Tbrh013NominaPeer::updated_at,$fecha);
      }
                                      
                      }
      $c->setIgnoreCase(true);
      $cantidadTotal = Tbrh013NominaPeer::doCount($c);
      
      $c->setLimit($limit)->setOffset($start);
          $c->addAscendingOrderByColumn(Tbrh013NominaPeer::CO_NOMINA);
  
          $c->clearSelectColumns();
          $c->addSelectColumn(Tbrh013NominaPeer::CO_NOMINA);
          $c->addSelectColumn(Tbrh013NominaPeer::CO_SOLICITUD);
          $c->addSelectColumn(Tbrh013NominaPeer::NU_NOMINA);
          $c->addSelectColumn(Tbrh013NominaPeer::FE_INICIO);
          $c->addSelectColumn(Tbrh013NominaPeer::FE_FIN);
          $c->addSelectColumn(Tbrh013NominaPeer::FE_PAGO);
          $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
          $c->addAsColumn('cod_nomina',Tbrh017TpNominaPeer::NU_NOMINA);
          $c->addSelectColumn(Tbrh023NomFrecuenciaPagoPeer::TX_NOM_FRECUENCIA_PAGO);
          $c->addSelectColumn(Tbrh060NominaEstatusPeer::DE_NOMINA_ESTATUS);
          $c->addSelectColumn(Tbrh067GrupoNominaPeer::COD_GRUPO_NOMINA);
  
          $c->addJoin(Tbrh013NominaPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
          $c->addJoin(Tbrh013NominaPeer::CO_NOM_FRECUENCIA_PAGO, Tbrh023NomFrecuenciaPagoPeer::CO_NOM_FRECUENCIA_PAGO);
          $c->addJoin(Tbrh013NominaPeer::ID_TBRH060_NOMINA_ESTATUS, Tbrh060NominaEstatusPeer::ID);
          $c->addJoin(Tbrh013NominaPeer::CO_GRUPO_NOMINA, Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);
  
          $c->add(Tbrh013NominaPeer::CO_SOLICITUD, $co_solicitud);
          $c->add(Tbrh013NominaPeer::IN_ACTIVO, TRUE);
          $c->add(Tbrh013NominaPeer::ID_TBRH060_NOMINA_ESTATUS, 3);
          
      $stmt = Tbrh013NominaPeer::doSelectStmt($c);
      $registros = "";
      while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
      $registros[] = array(
              "co_nomina"     => trim($res["co_nomina"]),
              "co_solicitud"     => trim($res["co_solicitud"]),
              "co_tp_nomina"     => trim($res["tx_tp_nomina"]),
              "co_nom_frecuencia_pago"     => trim($res["tx_nom_frecuencia_pago"]),
              "nu_nomina"     => trim($res["nu_nomina"]),
              "cod_nomina"     => trim($res["cod_nomina"]),
              "de_nomina"     => trim($res["de_nomina"]),
              "de_observacion"     => trim($res["de_observacion"]),
              "fe_inicio"     => trim(date("d-m-Y", strtotime($res["fe_inicio"]))),
              "fe_fin"     => trim(date("d-m-Y", strtotime($res["fe_fin"]))),
              "fe_pago"     => trim(date("d-m-Y", strtotime($res["fe_pago"]))),
              "in_activo"     => trim($res["in_activo"]),
              "created_at"     => trim($res["created_at"]),
              "updated_at"     => trim($res["updated_at"]),
              "in_procesado"     => trim($res["in_procesado"]),
              "id_tbrh060_nomina_estatus"     => trim($res["de_nomina_estatus"]),
              "cod_grupo_nomina"     => trim($res["cod_grupo_nomina"]),
          );
      }
  
      $this->data = json_encode(array(
          "success"   =>  true,
          "total"     =>  $cantidadTotal,
          "data"      =>  $registros
          ));
      }

      public function executePresupuesto(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("codigo");

        $listaArreglo  = json_decode($codigo,true);

        foreach($listaArreglo as $arregloForm){
            $condicion[] = $arregloForm['co_nomina'];
        }
        
        /** Incluir la clase PHPExcel_IOFactory agregada en el directorio /lib/vendor/PHPExcel */
        require_once dirname(__FILE__).'/../../../../../plugins/reader/Classes/PHPExcel/IOFactory.php';

        // Instantiate a new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set properties
        $objPHPExcel->getProperties()->setCreator("Yoser Perez");
        $objPHPExcel->getProperties()->setTitle("PRESU");
        $objPHPExcel->getProperties()->setSubject("Reporte");
        $objPHPExcel->getProperties()->setDescription("Reporte para documento de Office 2007 XLSX.");
        // Set the active Excel worksheet to sheet 0
        $objPHPExcel->setActiveSheetIndex(0);
        // Rename sheet

        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'SUC')
        ->setCellValue('B1', 'FUN')
        ->setCellValue('C1', 'CTO')
        ->setCellValue('D1', 'CONCEPTO')
        ->setCellValue('E1', 'MONTO')
        ->setCellValue('F1', 'CAT')    
        ->setCellValue('G1', 'PART')
        ->setCellValue('H1', 'LEY')
        ->setCellValue('I1', 'BAN')
        ->setCellValue('J1', 'PROC')
        ->setCellValue('K1', 'AÑO')
        ->setCellValue('L1', 'PDO')
        ->setCellValue('M1', 'MES');

        // Make bold cells
        $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->setTitle('PRESUPUESTARIA');

        /*$c = new Criteria();   
        $c->setIgnoreCase(true);
        $c->addSelectColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
        $c->addSelectColumn(Tbrh014ConceptoPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tbrh014ConceptoPeer::NU_CUENTA_PRESUPUESTO);
        $c->addSelectColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::TX_BANCO);
        $c->addSelectColumn('SUM('.Tbrh061NominaMovimientoPeer::NU_MONTO.') as nu_monto');
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH014_CONCEPTO, Tbrh014ConceptoPeer::CO_CONCEPTO);
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH020_TP_CONCEPTO, Tbrh020TpConceptoPeer::CO_TP_CONCEPTO);
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, Tbrh002FichaPeer::CO_FICHA);
        $c->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);

        $c->addAscendingOrderByColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
        $c->addAscendingOrderByColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA,$codigo);

        $c->addGroupByColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
        $c->addGroupByColumn(Tbrh014ConceptoPeer::TX_CONCEPTO);
        $c->addGroupByColumn(Tbrh014ConceptoPeer::NU_CUENTA_PRESUPUESTO);
        $c->addGroupByColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
        $c->addGroupByColumn(Tbrh001TrabajadorPeer::TX_BANCO);
          
        $cantidadTotal = Tbrh061NominaMovimientoPeer::doCount($c);

        $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);*/

        $c = new Criteria();   
        $c->setIgnoreCase(true);
        $c->addSelectColumn(Tbrh101CierreNominaPresupuestoPeer::DE_SUCURSAL);
        $c->addSelectColumn(Tbrh101CierreNominaPresupuestoPeer::DE_FUN);
        $c->addSelectColumn(Tbrh101CierreNominaPresupuestoPeer::NU_CONCEPTO);
        $c->addSelectColumn(Tbrh101CierreNominaPresupuestoPeer::DE_CONCEPTO);
        //$c->addSelectColumn(Tbrh101CierreNominaPresupuestoPeer::MO_CONCEPTO);
        $c->addSelectColumn(Tbrh101CierreNominaPresupuestoPeer::DE_CATEGORIA);
        $c->addSelectColumn(Tbrh101CierreNominaPresupuestoPeer::NU_PARTIDA);
        $c->addSelectColumn(Tbrh101CierreNominaPresupuestoPeer::NU_DECRETO);
        $c->addSelectColumn(Tbrh101CierreNominaPresupuestoPeer::NU_BANCO);
        $c->addSelectColumn(Tbrh101CierreNominaPresupuestoPeer::ID_TB026_SOLICITUD);
        $c->addSelectColumn(Tbrh101CierreNominaPresupuestoPeer::FE_PAGO);
        $c->addSelectColumn('SUM('.Tbrh101CierreNominaPresupuestoPeer::MO_CONCEPTO.') as mo_concepto');
        $c->addAscendingOrderByColumn(Tbrh101CierreNominaPresupuestoPeer::DE_FUN);
        $c->addAscendingOrderByColumn(Tbrh101CierreNominaPresupuestoPeer::NU_CONCEPTO);
        //$c->add(Tbrh101CierreNominaPresupuestoPeer::ID_TBRH013_NOMINA, $codigo);
        $c->add(Tbrh101CierreNominaPresupuestoPeer::ID_TBRH013_NOMINA, $condicion, Criteria::IN);

        $c->addGroupByColumn(Tbrh101CierreNominaPresupuestoPeer::DE_SUCURSAL);
        $c->addGroupByColumn(Tbrh101CierreNominaPresupuestoPeer::DE_FUN);
        $c->addGroupByColumn(Tbrh101CierreNominaPresupuestoPeer::NU_CONCEPTO);
        $c->addGroupByColumn(Tbrh101CierreNominaPresupuestoPeer::DE_CONCEPTO);
        $c->addGroupByColumn(Tbrh101CierreNominaPresupuestoPeer::DE_CATEGORIA);
        $c->addGroupByColumn(Tbrh101CierreNominaPresupuestoPeer::NU_PARTIDA);
        $c->addGroupByColumn(Tbrh101CierreNominaPresupuestoPeer::NU_DECRETO);
        $c->addGroupByColumn(Tbrh101CierreNominaPresupuestoPeer::NU_BANCO);
        $c->addGroupByColumn(Tbrh101CierreNominaPresupuestoPeer::ID_TB026_SOLICITUD);
        $c->addGroupByColumn(Tbrh101CierreNominaPresupuestoPeer::FE_PAGO);

        $cantidadTotal = Tbrh101CierreNominaPresupuestoPeer::doCount($c);

        $stmt = Tbrh101CierreNominaPresupuestoPeer::doSelectStmt($c);
        
        $rowCount = 2;
        
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){

            /*$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, substr(trim($res["nu_cuenta_presupuesto"]), 0, 4), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, substr(trim($res["tx_tp_concepto"]), 0, 1), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, trim($res["nu_concepto"]), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, trim($res["tx_concepto"]), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, trim($res["nu_monto"]), PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, substr(trim($res["nu_cuenta_presupuesto"]), 4, 8), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, substr(trim($res["nu_cuenta_presupuesto"]), 12, 12), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, substr(trim($res["nu_cuenta_presupuesto"]), 24, 5), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, trim($res["tx_banco"]), PHPExcel_Cell_DataType::TYPE_STRING);*/

            $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, trim($res["de_sucursal"]), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, trim($res["de_fun"]), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, trim($res["nu_concepto"]), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, trim($res["de_concepto"]), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, trim($res["mo_concepto"]), PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, trim($res["de_categoria"]), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, trim($res["nu_partida"]), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, trim($res["nu_decreto"]), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, trim($res["nu_banco"]), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, trim($res["id_tb026_solicitud"]), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, trim(date("Y", strtotime($res["fe_pago"]))), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, trim(date("d", strtotime($res["fe_pago"]))), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('M'.$rowCount, trim(date("m", strtotime($res["fe_pago"]))), PHPExcel_Cell_DataType::TYPE_STRING);
            // Increment the Excel row counter
            $rowCount++;
        }

        // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        // We'll be outputting an excel file
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // It will be called file.xls
        header('Content-Disposition: attachment; filename="nomina_presupuestaria_'.date("d-m-Y").'.xlsx"');
        $objWriter->save('php://output');

        return sfView::NONE;

      }

      public function executeUnificadoCheque(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("codigo");

        $listaArreglo  = json_decode($codigo,true);

        foreach($listaArreglo as $arregloForm){
            $condicion[] = $arregloForm['co_nomina'];
        }
        
        $c1 = new Criteria();   
        $c1->setIgnoreCase(true);
        $c1->add(Tbrh013NominaPeer::CO_NOMINA, $condicion, Criteria::IN);  
        $stmt1 = Tbrh013NominaPeer::doSelectStmt($c1);        
        while ($res1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {

        if($res1["co_tp_nomina"]==13){   
        $sql = "select * from (SELECT case when mo_pago<= 5000 and tb089.co_tp_forma_pago = 1 then 3 else tb089.co_tp_forma_pago end as co_tp_forma_pago,
                tbrh102.nu_cedula,tbrh102.nb_trabajador,id_tbrh013_nomina,de_inicial,tbrh102.nu_cuenta,nu_banco,id_tbrh015_nom_trabajador,count(tbrh102.nu_cedula) as nu_cantidad,
                sum(mo_pago) as mo_pago 
                FROM tbrh102_cierre_nomina_trabajador as tbrh102  
                INNER JOIN tbrh089_embargantes AS tb089 on tbrh102.nu_cedula = tb089.nu_cedula 
                INNER JOIN tbrh090_tp_forma_pago AS tb090 on tb089.co_tp_forma_pago = tb090.co_tp_forma_pago 
                WHERE id_tbrh013_nomina in (".implode(",", $condicion).") and mo_pago > 0 and tb089.co_tp_forma_pago in (1,3) 
                group by 1,2,3,4,5,6,7,8 order by tbrh102.nu_cedula asc
                ) as q1 where q1.co_tp_forma_pago = 1;";
//        var_dump($sql);
//        exit();
           $con = Propel::getConnection();
           $stmt = $con->prepare($sql);
           $stmt->execute();
        }

        $ref = 1;
        $i = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="pago_cheques_embargos_'.date("d-m-Y").'.txt"');

        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $ref++;
            $nu_cedula = str_pad(trim($res["nu_cedula"]), 13, " ", STR_PAD_LEFT);
            $cedula = str_pad(trim($res["de_inicial"].$res["nu_cedula"]), 13, " ", STR_PAD_LEFT);
            $nb_trabajador = str_pad(trim(utf8_decode($res["nb_trabajador"])), 30, " ", STR_PAD_RIGHT);
            $nu_cuenta = str_pad(trim($res["nu_cuenta"]), 20, "0", STR_PAD_LEFT);
            $mo_pago = str_pad(trim($res["mo_pago"]), 16, " ", STR_PAD_LEFT);
            $nu_banco = substr(trim($res["nu_banco"]), 0, 2);
            $nu_ubicacion = trim($res["id_tbrh015_nom_trabajador"]);

            //$nu_monto = str_pad($monto.str_pad($decimales, 2, "0", STR_PAD_RIGHT), 15, "0", STR_PAD_LEFT);

            $filler = str_pad("", 158, " ", STR_PAD_RIGHT);


            //$cuerpo .= "|".$nu_cedula."|,|".$cedula."|,|". $nb_trabajador ."|,|". $nu_cuenta ."|,|". $mo_pago ."|,|". $nu_banco ."|". "\r\n";
            $cuerpo .= "|".$nu_cedula."|,|".$cedula."|,|". $nb_trabajador ."|,|". $nu_cuenta ."|,|". $mo_pago ."|,|". $nu_banco ."|,|". $nu_ubicacion ."|". "\r\n";

            $i++;
        }
        }
        print($cuerpo);

        return sfView::NONE;
    }
    
      public function executeUnificado(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("codigo");

        $listaArreglo  = json_decode($codigo,true);

        foreach($listaArreglo as $arregloForm){
            $condicion[] = $arregloForm['co_nomina'];
        }

        /*$c = new Criteria();   
        $c->setIgnoreCase(true);
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $codigo);
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA);
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA);
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR);
        $c->addSelectColumn(Tbrh002FichaPeer::NU_FICHA);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
        $c->addSelectColumn(Tbrh032CargoPeer::TX_CARGO);
        $c->addAsColumn('mo_asignacion', 'sp_tbrh061_nomina_movimiento_mo_movimiento( tbrh061_nomina_movimiento.id_tbrh013_nomina, tbrh061_nomina_movimiento.id_tbrh002_ficha, 1 )');
        $c->addAsColumn('mo_deduccion', 'sp_tbrh061_nomina_movimiento_mo_movimiento( tbrh061_nomina_movimiento.id_tbrh013_nomina, tbrh061_nomina_movimiento.id_tbrh002_ficha, 2 )');
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, Tbrh002FichaPeer::CO_FICHA);
        $c->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
        $c->addJoin(Tbrh001TrabajadorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR, Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR);
        $c->addJoin(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA, Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA, Criteria::LEFT_JOIN);
        $c->addJoin(Tbrh009CargoEstructuraPeer::CO_CARGO, Tbrh032CargoPeer::CO_CARGO, Criteria::LEFT_JOIN);
        $c->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA);
        $c->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA);
        $c->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR);
        $c->addGroupByColumn(Tbrh002FichaPeer::NU_FICHA);
        $c->addGroupByColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
        $c->addGroupByColumn(Tb007DocumentoPeer::INICIAL);
        $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
        $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
        $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
        $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
        $c->addGroupByColumn(Tbrh032CargoPeer::TX_CARGO);
        $c->addAscendingOrderByColumn(Tbrh001TrabajadorPeer::NU_CEDULA);

        $cant = Tbrh061NominaMovimientoPeer::doCount($c);
            
        $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);*/
        
        $c1 = new Criteria();   
        $c1->setIgnoreCase(true);
        $c1->add(Tbrh013NominaPeer::CO_NOMINA, $condicion, Criteria::IN);  
        $stmt1 = Tbrh013NominaPeer::doSelectStmt($c1);        
        while ($res1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {

        if($res1["co_tp_nomina"]==13){   
        $c = new Criteria();   
        $c->setIgnoreCase(true);
        //$c->add(Tbrh102CierreNominaTrabajadorPeer::ID_TBRH013_NOMINA, $codigo);
        //$c->add(Tbrh102CierreNominaTrabajadorPeer::MO_PAGO, 'tbrh102_cierre_nomina_trabajador.mo_pago > 0', Criteria::CUSTOM);
        $c->add(Tbrh102CierreNominaTrabajadorPeer::MO_PAGO, 0, Criteria::GREATER_THAN);
        $c->addJoin(Tbrh089EmbargantesPeer::NU_CEDULA, Tbrh102CierreNominaTrabajadorPeer::NU_CEDULA);
        $c->add(Tbrh102CierreNominaTrabajadorPeer::ID_TBRH013_NOMINA, $res1["co_nomina"]);
        $c->add(Tbrh089EmbargantesPeer::CO_TP_FORMA_PAGO,2);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::ID_TBRH013_NOMINA);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::DE_INICIAL);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CEDULA);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NB_TRABAJADOR);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CUENTA);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NU_BANCO);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::MO_PAGO);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::ID_TBRH015_NOM_TRABAJADOR);
        $c->addAscendingOrderByColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CEDULA);

        $cant = Tbrh102CierreNominaTrabajadorPeer::doCount($c);
            
        $stmt = Tbrh102CierreNominaTrabajadorPeer::doSelectStmt($c);
        }else{
         
        $c = new Criteria();   
        $c->setIgnoreCase(true);
        //$c->add(Tbrh102CierreNominaTrabajadorPeer::ID_TBRH013_NOMINA, $codigo);
        //$c->add(Tbrh102CierreNominaTrabajadorPeer::MO_PAGO, 'tbrh102_cierre_nomina_trabajador.mo_pago > 0', Criteria::CUSTOM);
        $c->add(Tbrh102CierreNominaTrabajadorPeer::MO_PAGO, 0, Criteria::GREATER_THAN);
        $c->add(Tbrh102CierreNominaTrabajadorPeer::ID_TBRH013_NOMINA, $res1["co_nomina"]);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::ID_TBRH013_NOMINA);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::DE_INICIAL);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CEDULA);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NB_TRABAJADOR);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CUENTA);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NU_BANCO);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::MO_PAGO);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::ID_TBRH015_NOM_TRABAJADOR);
        $c->addAscendingOrderByColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CEDULA);

        $cant = Tbrh102CierreNominaTrabajadorPeer::doCount($c);
            
        $stmt = Tbrh102CierreNominaTrabajadorPeer::doSelectStmt($c);            
            
        }

        $ref = 1;
        $i = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="nomina_pago_'.date("d-m-Y").'.txt"');

        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $ref++;
            $nu_cedula = str_pad(trim($res["nu_cedula"]), 13, " ", STR_PAD_LEFT);
            $cedula = str_pad(trim($res["de_inicial"].$res["nu_cedula"]), 13, " ", STR_PAD_LEFT);
            $nb_trabajador = str_pad(trim(utf8_decode($res["nb_trabajador"])), 30, " ", STR_PAD_RIGHT);
            $nu_cuenta = str_pad(trim($res["nu_cuenta"]), 20, "0", STR_PAD_LEFT);
            $mo_pago = str_pad(trim($res["mo_pago"]), 16, " ", STR_PAD_LEFT);
            $nu_banco = substr(trim($res["nu_banco"]), 0, 2);
            $nu_ubicacion = trim($res["id_tbrh015_nom_trabajador"]);

            //$nu_monto = str_pad($monto.str_pad($decimales, 2, "0", STR_PAD_RIGHT), 15, "0", STR_PAD_LEFT);

            $filler = str_pad("", 158, " ", STR_PAD_RIGHT);


            //$cuerpo .= "|".$nu_cedula."|,|".$cedula."|,|". $nb_trabajador ."|,|". $nu_cuenta ."|,|". $mo_pago ."|,|". $nu_banco ."|". "\r\n";
            $cuerpo .= "|".$nu_cedula."|,|".$cedula."|,|". $nb_trabajador ."|,|". $nu_cuenta ."|,|". $mo_pago ."|,|". $nu_banco ."|,|". $nu_ubicacion ."|". "\r\n";

            $i++;
        }
        }
        print($cuerpo);

        return sfView::NONE;
    }  
    
    
      public function executePatriaBod(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("codigo");

        $listaArreglo  = json_decode($codigo,true);

        foreach($listaArreglo as $arregloForm){
            $condicion[] = $arregloForm['co_nomina'];
        }
        
//        $c1 = new Criteria();   
//        $c1->setIgnoreCase(true);
//        $c1->add(Tbrh013NominaPeer::CO_NOMINA, $condicion, Criteria::IN);  
//        $stmt1 = Tbrh013NominaPeer::doSelectStmt($c1);        
//        while ($res1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
         
        $c = new Criteria();   
        $c->setIgnoreCase(true);

        
        $c->addSelectColumn(Tbrh013NominaPeer::FE_PAGO);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::DE_INICIAL);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CEDULA);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NB_TRABAJADOR);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CUENTA);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NU_BANCO);
        $c->addSelectColumn('SUM('.Tbrh102CierreNominaTrabajadorPeer::MO_PAGO.') as mo_pago');
        $c->addAscendingOrderByColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CEDULA);
        $c->addJoin(Tbrh013NominaPeer::CO_NOMINA, Tbrh102CierreNominaTrabajadorPeer::ID_TBRH013_NOMINA);
        $c->add(Tbrh102CierreNominaTrabajadorPeer::MO_PAGO, 0, Criteria::GREATER_THAN);
        $c->add(Tbrh102CierreNominaTrabajadorPeer::NU_BANCO, 20);
        $c->add(Tbrh102CierreNominaTrabajadorPeer::ID_TBRH013_NOMINA,$condicion, Criteria::IN);
               
        $c->addGroupByColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CEDULA);
        $c->addGroupByColumn(Tbrh102CierreNominaTrabajadorPeer::DE_INICIAL);
        $c->addGroupByColumn(Tbrh102CierreNominaTrabajadorPeer::NB_TRABAJADOR);
        $c->addGroupByColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CUENTA);
        $c->addGroupByColumn(Tbrh102CierreNominaTrabajadorPeer::NU_BANCO);
        $c->addGroupByColumn(Tbrh013NominaPeer::FE_PAGO);        
        
        //$cant = Tbrh102CierreNominaTrabajadorPeer::doCount($c);
            
        $stmt = Tbrh102CierreNominaTrabajadorPeer::doSelectStmt($c);            
            
        

        $ref = 1;
        //$i = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="nomina_pago_patria_'.date("d-m-Y").'.txt"');

        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $ref++;
            $cedula = str_pad(substr(trim($res["nu_cedula"]), 0), 8, "0", STR_PAD_LEFT);
            $inicial = substr(trim($res["de_inicial"]), 0, 1);            
            $cuenta = str_pad(trim($res["nu_cuenta"]), 20, "0", STR_PAD_LEFT);
            $nb_trabajador = str_pad(trim(utf8_decode($res["nb_trabajador"])), 40, " ", STR_PAD_RIGHT);
            $nu_monto = round($res["mo_pago"],2);
            list($monto, $decimales) = explode(".", $nu_monto);
            $mo_pago = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 11, "0", STR_PAD_LEFT);            
            
            $monto_cabecera += $res["mo_pago"];
            list($anio, $mes, $dia) = explode("-", trim($res["fe_pago"]));
            $fecha = $anio . $mes . $dia;
            $filler = str_pad("", 158, " ", STR_PAD_RIGHT);
            $cuerpo .= "\r\n" . $inicial . $cedula . $cuenta . $mo_pago . $nb_trabajador;

            $i++;
        }
        
//        }
        
        $id = 'ONTNOM';
        $rif = "G200036524";
        $cant_operaciones = str_pad($i, 7, "0", STR_PAD_LEFT);
        $mo_total_decimales = round($monto_cabecera,2);
        list($monto, $decimales) = explode(".", $mo_total_decimales);
        $mo_total = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 15, "0", STR_PAD_LEFT);
        $moneda = 'VES';
      
        print(trim($id . $rif . $cant_operaciones . $mo_total . $moneda . $fecha.$filler));
        
        
        print($cuerpo);

        return sfView::NONE;
    }

      public function executePatriaProvincial(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("codigo");

        $listaArreglo  = json_decode($codigo,true);

        foreach($listaArreglo as $arregloForm){
            $condicion[] = $arregloForm['co_nomina'];
        }
        
//        $c1 = new Criteria();   
//        $c1->setIgnoreCase(true);
//        $c1->add(Tbrh013NominaPeer::CO_NOMINA, $condicion, Criteria::IN);  
//        $stmt1 = Tbrh013NominaPeer::doSelectStmt($c1);        
//        while ($res1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $nu_banco = '06'; 
        $c = new Criteria();   
        $c->setIgnoreCase(true);

        
        $c->addSelectColumn(Tbrh013NominaPeer::FE_PAGO);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::DE_INICIAL);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CEDULA);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NB_TRABAJADOR);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CUENTA);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NU_BANCO);
        $c->addSelectColumn('SUM('.Tbrh102CierreNominaTrabajadorPeer::MO_PAGO.') as mo_pago');
        $c->addAscendingOrderByColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CEDULA);
        $c->addJoin(Tbrh013NominaPeer::CO_NOMINA, Tbrh102CierreNominaTrabajadorPeer::ID_TBRH013_NOMINA);
        $c->add(Tbrh102CierreNominaTrabajadorPeer::MO_PAGO, 0, Criteria::GREATER_THAN);
        $c->add(Tbrh102CierreNominaTrabajadorPeer::NU_BANCO, $nu_banco);
        $c->add(Tbrh102CierreNominaTrabajadorPeer::ID_TBRH013_NOMINA,$condicion, Criteria::IN);
               
        $c->addGroupByColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CEDULA);
        $c->addGroupByColumn(Tbrh102CierreNominaTrabajadorPeer::DE_INICIAL);
        $c->addGroupByColumn(Tbrh102CierreNominaTrabajadorPeer::NB_TRABAJADOR);
        $c->addGroupByColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CUENTA);
        $c->addGroupByColumn(Tbrh102CierreNominaTrabajadorPeer::NU_BANCO);
        $c->addGroupByColumn(Tbrh013NominaPeer::FE_PAGO);        
        
        //$cant = Tbrh102CierreNominaTrabajadorPeer::doCount($c);
            
        $stmt = Tbrh102CierreNominaTrabajadorPeer::doSelectStmt($c);            
            
        

        $ref = 1;
        //$i = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="nomina_pago_patria_'.date("d-m-Y").'.txt"');

        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $ref++;
            $cedula = str_pad(substr(trim($res["nu_cedula"]), 0), 8, "0", STR_PAD_LEFT);
            $inicial = substr(trim($res["de_inicial"]), 0, 1);            
            $cuenta = str_pad(trim($res["nu_cuenta"]), 20, "0", STR_PAD_LEFT);
            $nb_trabajador = str_pad(trim(utf8_decode($res["nb_trabajador"])), 40, " ", STR_PAD_RIGHT);
            $nu_monto = round($res["mo_pago"],2);
            list($monto, $decimales) = explode(".", $nu_monto);
            $mo_pago = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 11, "0", STR_PAD_LEFT);            
            
            $monto_cabecera += $res["mo_pago"];
            list($anio, $mes, $dia) = explode("-", trim($res["fe_pago"]));
            $fecha = $anio . $mes . $dia;
            $filler = str_pad("", 158, " ", STR_PAD_RIGHT);
            $cuerpo .= "\r\n" . $inicial . $cedula . $cuenta . $mo_pago . $nb_trabajador;

            $i++;
        }
        
//        }
        
        $id = 'ONTNOM';
        $rif = "G200036524";
        $cant_operaciones = str_pad($i, 7, "0", STR_PAD_LEFT);
        $mo_total_decimales = round($monto_cabecera,2);
        list($monto, $decimales) = explode(".", $mo_total_decimales);
        $mo_total = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 15, "0", STR_PAD_LEFT);
        $moneda = 'VES';
      
        print(trim($id . $rif . $cant_operaciones . $mo_total . $moneda . $fecha.$filler));
        
        
        print($cuerpo);

        return sfView::NONE;
    }

      public function executePatriaVenezuela(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("codigo");

        $listaArreglo  = json_decode($codigo,true);

        foreach($listaArreglo as $arregloForm){
            $condicion[] = $arregloForm['co_nomina'];
        }
        
//        $c1 = new Criteria();   
//        $c1->setIgnoreCase(true);
//        $c1->add(Tbrh013NominaPeer::CO_NOMINA, $condicion, Criteria::IN);  
//        $stmt1 = Tbrh013NominaPeer::doSelectStmt($c1);        
//        while ($res1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
         
        $c = new Criteria();   
        $c->setIgnoreCase(true);

        
        $c->addSelectColumn(Tbrh013NominaPeer::FE_PAGO);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::DE_INICIAL);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CEDULA);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NB_TRABAJADOR);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CUENTA);
        $c->addSelectColumn(Tbrh102CierreNominaTrabajadorPeer::NU_BANCO);
        $c->addSelectColumn('SUM('.Tbrh102CierreNominaTrabajadorPeer::MO_PAGO.') as mo_pago');
        $c->addAscendingOrderByColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CEDULA);
        $c->addJoin(Tbrh013NominaPeer::CO_NOMINA, Tbrh102CierreNominaTrabajadorPeer::ID_TBRH013_NOMINA);
        $c->add(Tbrh102CierreNominaTrabajadorPeer::MO_PAGO, 0, Criteria::GREATER_THAN);
        $c->add(Tbrh102CierreNominaTrabajadorPeer::NU_BANCO, 10);
        $c->add(Tbrh102CierreNominaTrabajadorPeer::ID_TBRH013_NOMINA,$condicion, Criteria::IN);
               
        $c->addGroupByColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CEDULA);
        $c->addGroupByColumn(Tbrh102CierreNominaTrabajadorPeer::DE_INICIAL);
        $c->addGroupByColumn(Tbrh102CierreNominaTrabajadorPeer::NB_TRABAJADOR);
        $c->addGroupByColumn(Tbrh102CierreNominaTrabajadorPeer::NU_CUENTA);
        $c->addGroupByColumn(Tbrh102CierreNominaTrabajadorPeer::NU_BANCO);
        $c->addGroupByColumn(Tbrh013NominaPeer::FE_PAGO);        
        
        //$cant = Tbrh102CierreNominaTrabajadorPeer::doCount($c);
            
        $stmt = Tbrh102CierreNominaTrabajadorPeer::doSelectStmt($c);            
            
        

        $ref = 1;
        //$i = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="nomina_pago_patria_'.date("d-m-Y").'.txt"');

        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $ref++;
            $cedula = str_pad(substr(trim($res["nu_cedula"]), 0), 8, "0", STR_PAD_LEFT);
            $inicial = substr(trim($res["de_inicial"]), 0, 1);            
            $cuenta = str_pad(trim($res["nu_cuenta"]), 20, "0", STR_PAD_LEFT);
            $nb_trabajador = str_pad(trim(utf8_decode($res["nb_trabajador"])), 40, " ", STR_PAD_RIGHT);
            $nu_monto = round($res["mo_pago"],2);
            list($monto, $decimales) = explode(".", $nu_monto);
            $mo_pago = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 11, "0", STR_PAD_LEFT);            
            
            $monto_cabecera += $res["mo_pago"];
            list($anio, $mes, $dia) = explode("-", trim($res["fe_pago"]));
            $fecha = $anio . $mes . $dia;
            $filler = str_pad("", 158, " ", STR_PAD_RIGHT);
            $cuerpo .= "\r\n" . $inicial . $cedula . $cuenta . $mo_pago . $nb_trabajador;

            $i++;
        }
//        }
        
        $id = 'ONTNOM';
        $rif = "G200036524";
        $cant_operaciones = str_pad($i, 7, "0", STR_PAD_LEFT);
        $mo_total_decimales = round($monto_cabecera,2);
        list($monto, $decimales) = explode(".", $mo_total_decimales);
        $mo_total = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 15, "0", STR_PAD_LEFT);
        $moneda = 'VES';
      
        print(trim($id . $rif . $cant_operaciones . $mo_total . $moneda . $fecha.$filler));
        
        
        print($cuerpo);

        return sfView::NONE;
    }    

    public function executeStorelistaEmbargante(sfWebRequest $request){
        
       $co_nomina = $this->getRequestParameter('co_nomina');
        $listaArreglo  = json_decode($co_nomina,true);
        foreach($listaArreglo as $arregloForm){

            $condicion[] = $arregloForm['co_nomina'];

        }       
       
        $sql = "select * from (SELECT case when mo_pago<= 5000 and tb089.co_tp_forma_pago = 1 then 3 else tb089.co_tp_forma_pago end as co_tp_forma_pago,
                tbrh102.nu_cedula,tb089.nb_nombre as nb_trabajador,id_tbrh013_nomina,de_inicial,tbrh102.nu_cuenta,nu_banco,id_tbrh015_nom_trabajador,tbrh102.id,tbrh102.nu_cheque,count(tbrh102.nu_cedula) as nu_cantidad,
                sum(mo_pago) as mo_pago 
                FROM tbrh102_cierre_nomina_trabajador as tbrh102  
                INNER JOIN tbrh089_embargantes AS tb089 on tbrh102.nu_cedula = tb089.nu_cedula 
                INNER JOIN tbrh090_tp_forma_pago AS tb090 on tb089.co_tp_forma_pago = tb090.co_tp_forma_pago 
                WHERE id_tbrh013_nomina in (".implode(",", $condicion).") and mo_pago > 0 and tb089.co_tp_forma_pago in (1,3) 
                group by 1,2,3,4,5,6,7,8,9,10 order by tbrh102.nu_cedula asc
                ) as q1 where q1.co_tp_forma_pago = 1;";
//        var_dump($sql);
//        exit();
           $con = Propel::getConnection();
           $stmt = $con->prepare($sql);
           $stmt->execute();
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

    public function executeFecha(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("codigo");

        $listaArreglo  = json_decode($codigo,true);

        foreach($listaArreglo as $arregloForm){
            $condicion[] = $arregloForm['co_nomina'];
        }

        $this->data = json_encode($codigo);

    }
    
}