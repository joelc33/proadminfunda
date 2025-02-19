<?php

/**
 * autoTesoreria actions.
 * NombreClaseModel(Tb030Ruta)
 * NombreTabla(tb030_ruta)
 * @package    ##PROJECT_NAME##
 * @subpackage autoTesoreria
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class TesoreriaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
       $this->co_liquidacion_pago = $this->getRequestParameter('co_liquidacion_pago');
       $this->co_solicitud = $this->getRequestParameter('co_solicitud');
       $this->co_tipo_solicitud = $this->getRequestParameter('co_tipo_solicitud');
       $this->co_tipo_odp = $this->getRequestParameter('co_tipo_odp');
       $this->tx_observacion = $this->getTxObservacion($this->co_solicitud);
  
  }
  
   public function executeCorrelativoTransferencia(sfWebRequest $request)
  {
	
        $c = new Criteria();
        $cant = Tb063PagoPeer::doCount($c);
	
	$this->data = json_encode(array(
                "success" => true,
                //"correlativo" => date("Y").$cant+1
                "correlativo" => $this->getUser()->getAttribute('ejercicio').$cant+1
	));
                
  }
  
  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Tesoreria', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }
  
  public function executePagos(sfWebRequest $request)
  {
        $this->data = json_encode(array(
		"co_rol"         => $this->getUser()->getAttribute('rol'),
		"co_usuario"     => $this->getUser()->getAttribute('codigo'),
	));
  }
  
    public function executePagosRealizados(sfWebRequest $request)
  {
        $this->data = json_encode(array(
		"co_rol"         => $this->getUser()->getAttribute('rol'),
		"co_usuario"     => $this->getUser()->getAttribute('codigo'),
	));
  }
  
  public function executeUnificacionPago(sfWebRequest $request)
  {
        $this->data = json_encode(array(
		"co_rol"         => $this->getUser()->getAttribute('rol'),
		"co_usuario"     => $this->getUser()->getAttribute('codigo'),
	));
  }
  
  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tb030RutaPeer::CO_RUTA,$codigo);
        
        $stmt = Tb030RutaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_ruta"     => $campos["co_ruta"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                            "co_proceso"     => $campos["co_proceso"],
                            "observacion"     => $campos["observacion"],
                            "co_estatus_ruta"     => $campos["co_estatus_ruta"],
                            "co_usuario"     => $campos["co_usuario"],
                            "nu_orden"     => $campos["nu_orden"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "in_actual"     => $campos["in_actual"],
                            "in_cargar_dato"     => $campos["in_cargar_dato"],
                            "tx_ruta_reporte"     => $campos["tx_ruta_reporte"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_ruta"     => "",
                            "co_solicitud"     => "",
                            "co_tipo_solicitud"     => "",
                            "co_proceso"     => "",
                            "observacion"     => "",
                            "co_estatus_ruta"     => "",
                            "co_usuario"     => "",
                            "nu_orden"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "in_actual"     => "",
                            "in_cargar_dato"     => "",
                            "tx_ruta_reporte"     => "",
                    ));
    }

  }
  
  public function executeCargarNomina(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("co_solicitud");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb122PagoNominaPeer::CO_PAGO_NOMINA);
        $c->addSelectColumn(Tb122PagoNominaPeer::CO_TIPO_NOMINA);
        $c->addSelectColumn(Tb122PagoNominaPeer::CO_TIPO_TRABAJADOR);
        $c->addSelectColumn(Tb122PagoNominaPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tb122PagoNominaPeer::FE_PAGO);
        $c->addSelectColumn(Tb122PagoNominaPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb122PagoNominaPeer::CO_USUARIO);
        $c->addSelectColumn(Tb122PagoNominaPeer::CREATED_AT);
        $c->addSelectColumn(Tb122PagoNominaPeer::CO_EJECUTOR);
        $c->addSelectColumn(Tb122PagoNominaPeer::MO_TOTAL);        
        
        $c->addSelectColumn(Tb052ComprasPeer::MONTO_TOTAL);
        
        $c->add(Tb122PagoNominaPeer::CO_SOLICITUD,$codigo); 
        
        //$datos_nomina = $this->getMoNominaMasivo($codigo);

        $stmt = Tb122PagoNominaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $diferencia = 0;
        
        $this->data = json_encode(array(
                            "co_pago_nomina"     => $campos["co_pago_nomina"],
                            "co_tipo_trabajador" => $campos["co_tipo_trabajador"],
                            "co_tipo_nomina"     => $campos["co_tipo_nomina"],
                            "tx_concepto"        => $campos["tx_concepto"],
                            "fe_pago"            => $campos["fe_pago"],
                            "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                            "co_usuario"         => $campos["co_usuario"],
                            "created_at"         => $campos["created_at"],
                            "co_ejecutor"        => $campos["co_ejecutor"],
                            "mo_nomina"          => 0,
                            "mo_total"           => 0,
                            "mo_diferencia"      => $diferencia,
                            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
                            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre')
                    ));
    }else{
        
        //$datos_nomina = $this->getMoNomina($codigo);
        
        $this->data = json_encode(array(
                            "co_pago_nomina"     => "",
                            "co_tipo_trabajador" => "",
                            "co_tipo_nomina"     => "",
                            "tx_concepto"        => "",
                            "fe_pago"            => "",
                            "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                            "co_usuario"         => "",
                            "created_at"         => "",
                            "co_ejecutor"        => "",
                            "mo_nomina"          => 0,
                            "mo_total"           => 0,
                            "mo_diferencia"      => "",
                            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
                            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre')
                    ));
    }      

  }  
  
    public function executeChequeEmbargo(sfWebRequest $request)
  {
    $co_solicitud = $this->getRequestParameter("co_solicitud");
    $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
    $this->data = json_encode(array(
            "co_tipo_solicitud" => $co_tipo_solicitud,
            "co_solicitud"          => $co_solicitud
        ));
    

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
    
    public function executeDetallePagosNomina(sfWebRequest $request){
      
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
    
    protected function getCoRuta($co_solicitud){
        $c = new Criteria();
        $c->add(Tb030RutaPeer::CO_SOLICITUD,$co_solicitud);
        $c->add(Tb030RutaPeer::IN_ACTUAL,TRUE);
        $stmt = Tb030RutaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos["co_ruta"];
    }
    
    public function executeDetallePagosRealizadosUnificado(sfWebRequest $request){
      
        $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
            
        $this->data = json_encode(array(
             "co_tipo_solicitud"   => $co_tipo_solicitud
        ));
        
        $this->accion      = sfContext::getInstance()->getActionName();
        $this->modulo      = sfContext::getInstance()->getModuleName();
        $this->url         = $_SERVER["SCRIPT_NAME"];
       
    }    

    public function executeDetallePagosRealizados(sfWebRequest $request){
        $co_solicitud = $this->getRequestParameter("codigo");
        $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
        $co_proceso = $this->getRequestParameter("co_proceso");
      
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
        $c->addSelectColumn(Tb060OrdenPagoPeer::CO_RUTA);
        $c->addSelectColumn(Tb063PagoPeer::CO_FORMA_PAGO);
        $c->addJoin(Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Tb062LiquidacionPagoPeer::CO_ODP, Criteria::LEFT_JOIN);
        $c->addJoin(Tb063PagoPeer::CO_LIQUIDACION_PAGO, Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
        $c->add(Tb062LiquidacionPagoPeer::CO_SOLICITUD,$co_solicitud);
        $c->addSelectColumn(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);   
        $stmt = Tb062LiquidacionPagoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
      
        $this->data = json_encode(array(
              "co_solicitud"        =>  $co_solicitud,
              "co_tipo_solicitud"   => $co_tipo_solicitud,
              "co_proceso"          => $co_proceso,
              "co_ruta"             => ($campos["co_ruta"]=='')?$this->getCoRuta($co_solicitud):$campos["co_ruta"],
              "co_liquidacion_pago" => $campos["co_liquidacion_pago"],
              "co_forma_pago"       => $campos["co_forma_pago"],
              "tx_etiqueta"         => ($campos["co_forma_pago"]=='1')?'Visualizar Cheque':'Visualizar Achivo de Pago'
        ));
        
        $this->accion      = sfContext::getInstance()->getActionName();
        $this->modulo      = sfContext::getInstance()->getModuleName();
        $this->url         = $_SERVER["SCRIPT_NAME"];
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
                            title: 'Pagos',
                            tabWidth:120,
                            autoLoad:{
                            url:'".$_SERVER["SCRIPT_NAME"]."/Tesoreria/detallePagos',
                            scripts: true,
                            params:{codigo:this.OBJ.co_solicitud,
                                    co_tipo_solicitud: this.OBJ.co_tipo_solicitud,
                                    co_proceso: this.OBJ.co_proceso }
                            }
                        }";
            }

            $this->DatosDetalle();
    }
    
      public function executeDetalleRealizados(sfWebRequest $request)
    {

            $this->tab = "{
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
                        {
                            title: 'Pagos',
                            tabWidth:120,
                            autoLoad:{
                            url:'".$_SERVER["SCRIPT_NAME"]."/Tesoreria/detallePagosRealizados',
                            scripts: true,
                            params:{codigo:this.OBJ.co_solicitud,
                                    co_tipo_solicitud: this.OBJ.co_tipo_solicitud,
                                    co_proceso: this.OBJ.co_proceso }
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
   
   protected function HistoricoPago($co_solicitud,$co_cuenta_bancaria,$monto_disponible_anterior,$monto_disponible_actual,$monto_total,$fecha,$con,$tx_descripcion){
            //*******************HITORICO DE CUENTAS BANCARIAS***************************************************
            
            $tb15_solicitud = Tb026SolicitudPeer::retrieveByPk($co_solicitud);
            
            if($tb15_solicitud->getCoTipoSolicitud()==49){
                
            $cpago = new Criteria();
            $cpago->clearSelectColumns();
            $cpago->addSelectColumn(Tb063PagoPeer::CREATED_AT);
            $cpago->addSelectColumn(Tb063PagoPeer::CO_CUENTA_BANCARIA);
            $cpago->addSelectColumn(Tb063PagoPeer::NU_MONTO);
            $cpago->addSelectColumn(Tb063PagoPeer::FE_PAGO);
            $cpago->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
            $cpago->addSelectColumn(Tb063PagoPeer::CO_BANCO);
            $cpago->addSelectColumn(Tb060OrdenPagoPeer::TX_DOCUMENTO_ODP);
            $cpago->addSelectColumn(Tb062LiquidacionPagoPeer::TX_SERIAL);
            $cpago->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
            $cpago->addJoin(Tb063PagoPeer::CO_LIQUIDACION_PAGO, Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
            $cpago->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb062LiquidacionPagoPeer::CO_SOLICITUD);
            $cpago->addJoin(Tb026SolicitudPeer::CO_SOLICITUD,Tb060OrdenPagoPeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
            $cpago->addJoin(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD,Tb026SolicitudPeer::CO_TIPO_SOLICITUD);
            $cpago->add(Tb063PagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
            $cpago->add(Tb060OrdenPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
            $cpago->add(Tb062LiquidacionPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
            $cpago->add(Tb063PagoPeer::CO_CUENTA_BANCARIA,$co_cuenta_bancaria);
            $cpago->add(Tb026SolicitudPeer::CO_SOLICITUD,$co_solicitud);
                        
            $stmtPago = Tb026SolicitudPeer::doSelectStmt($cpago);
            $camposPago = $stmtPago->fetch(PDO::FETCH_ASSOC);
            
            $tx_documento_odp='';
            if($camposPago["tx_documento_odp"]==null){
                $tx_documento_odp = $camposPago["tx_serial"];
            }else{
                $tx_documento_odp = $camposPago["tx_documento_odp"];
            }
            
            $cuenta = new Criteria();
            $cuenta->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA, $co_cuenta_bancaria);
            $stmtcuenta = Tb011CuentaBancariaPeer::doSelectStmt($cuenta);
            $res_cuenta = $stmtcuenta->fetch(PDO::FETCH_ASSOC); 
            
            $pagos = new Criteria;
            $pagos->clearSelectColumns();
            $pagos->addJoin(Tb123ArchivoPagoPeer::CO_PAGO_NOMINA, Tb122PagoNominaPeer::CO_PAGO_NOMINA);
            $pagos->add(Tb122PagoNominaPeer::CO_SOLICITUD,$co_solicitud);
            $stmt_pagos = Tb123ArchivoPagoPeer::doSelectStmt($pagos);
            $cantidad = Tb123ArchivoPagoPeer::doCount($pagos);
            
            if($cantidad>0){
            while($reg = $stmt_pagos->fetch(PDO::FETCH_ASSOC)){          
            
            $monto_disponible_anterior = $res_cuenta["mo_ingreso"]-$res_cuenta["mo_egreso"];
            $monto_total_egreso = $res_cuenta["mo_egreso"]+$reg["nu_monto"];
            $monto_disponible_actual   = $res_cuenta["mo_ingreso"]-$monto_total_egreso;            
            
            $Tb155CuentaBancariaHistorico = new Tb155CuentaBancariaHistorico();
            $Tb155CuentaBancariaHistorico->setInActivo(TRUE)
                                         ->setIdTb011CuentaBancaria($camposPago["co_cuenta_bancaria"])
                                         ->setMoTransaccion($reg["nu_monto"])
                                         ->setFeTransaccion($camposPago["fe_pago"])
                                         ->setDeObservacion($tx_descripcion)
                                         ->setIdTb010Banco($camposPago["co_banco"])
                                         ->setIdTb154TipoCuentaMovimiento(3)
                                         ->setIdTb153TipoDocumentoCuenta(3)
                                         ->setNuTransaccion($tx_documento_odp)
                                         ->setCoSolicitud($camposPago["co_solicitud"])
                                         ->setInConciliado(FALSE)
                                         ->setMoSaldoAnterior($monto_disponible_anterior)
                                         ->setMoSaldoNuevo($monto_disponible_actual)
                                         ->save($con);     
            }
            }else{
                
            $cpago = new Criteria();
            $cpago->clearSelectColumns();
            $cpago->addSelectColumn(Tb063PagoPeer::CREATED_AT);
            $cpago->addSelectColumn(Tb063PagoPeer::CO_CUENTA_BANCARIA);
            $cpago->addSelectColumn(Tb063PagoPeer::NU_MONTO);
            $cpago->addSelectColumn(Tb063PagoPeer::FE_PAGO);
            $cpago->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
            $cpago->addSelectColumn(Tb063PagoPeer::CO_BANCO);
            $cpago->addSelectColumn(Tb060OrdenPagoPeer::TX_DOCUMENTO_ODP);
            $cpago->addSelectColumn(Tb062LiquidacionPagoPeer::TX_SERIAL);
            $cpago->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
            $cpago->addJoin(Tb063PagoPeer::CO_LIQUIDACION_PAGO, Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
            $cpago->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb062LiquidacionPagoPeer::CO_SOLICITUD);
            $cpago->addJoin(Tb026SolicitudPeer::CO_SOLICITUD,Tb060OrdenPagoPeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
            $cpago->addJoin(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD,Tb026SolicitudPeer::CO_TIPO_SOLICITUD);
            $cpago->add(Tb063PagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
            $cpago->add(Tb060OrdenPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
            $cpago->add(Tb062LiquidacionPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
            $cpago->add(Tb063PagoPeer::CO_CUENTA_BANCARIA,$co_cuenta_bancaria);
            $cpago->add(Tb026SolicitudPeer::CO_SOLICITUD,$co_solicitud);
                        
            $stmtPago = Tb026SolicitudPeer::doSelectStmt($cpago);
            $camposPago = $stmtPago->fetch(PDO::FETCH_ASSOC);
            
            $tx_documento_odp='';
            if($camposPago["tx_documento_odp"]==null){
                $tx_documento_odp = $camposPago["tx_serial"];
            }else{
                $tx_documento_odp = $camposPago["tx_documento_odp"];
            }
                
            
            
            $Tb155CuentaBancariaHistorico = new Tb155CuentaBancariaHistorico();
            $Tb155CuentaBancariaHistorico->setInActivo(TRUE)
                                         ->setIdTb011CuentaBancaria($camposPago["co_cuenta_bancaria"])
                                         ->setMoTransaccion($camposPago["nu_monto"])
                                         ->setFeTransaccion($camposPago["fe_pago"])
                                         ->setDeObservacion($tx_descripcion)
                                         ->setIdTb010Banco($camposPago["co_banco"])
                                         ->setIdTb154TipoCuentaMovimiento(3)
                                         ->setIdTb153TipoDocumentoCuenta(3)
                                         ->setNuTransaccion($tx_documento_odp)
                                         ->setCoSolicitud($camposPago["co_solicitud"])
                                         ->setInConciliado(FALSE)
                                         ->setMoSaldoAnterior($monto_disponible_anterior)
                                         ->setMoSaldoNuevo($monto_disponible_actual)
                                         ->save($con);                
                
                
            }
                
            }else{
       
            $cpago = new Criteria();
            $cpago->clearSelectColumns();
            $cpago->addSelectColumn(Tb063PagoPeer::CREATED_AT);
            $cpago->addSelectColumn(Tb063PagoPeer::CO_CUENTA_BANCARIA);
            $cpago->addSelectColumn(Tb063PagoPeer::NU_MONTO);
            $cpago->addSelectColumn(Tb063PagoPeer::FE_PAGO);
            $cpago->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
            $cpago->addSelectColumn(Tb063PagoPeer::CO_BANCO);
            $cpago->addSelectColumn(Tb060OrdenPagoPeer::TX_DOCUMENTO_ODP);
            $cpago->addSelectColumn(Tb062LiquidacionPagoPeer::TX_SERIAL);
            $cpago->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
            $cpago->addJoin(Tb063PagoPeer::CO_LIQUIDACION_PAGO, Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
            $cpago->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb062LiquidacionPagoPeer::CO_SOLICITUD);
            $cpago->addJoin(Tb026SolicitudPeer::CO_SOLICITUD,Tb060OrdenPagoPeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
            $cpago->addJoin(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD,Tb026SolicitudPeer::CO_TIPO_SOLICITUD);
            $cpago->add(Tb063PagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
            $cpago->add(Tb060OrdenPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
            $cpago->add(Tb062LiquidacionPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
            $cpago->add(Tb063PagoPeer::CO_CUENTA_BANCARIA,$co_cuenta_bancaria);
            $cpago->add(Tb026SolicitudPeer::CO_SOLICITUD,$co_solicitud);
                        
            $stmtPago = Tb026SolicitudPeer::doSelectStmt($cpago);
            $camposPago = $stmtPago->fetch(PDO::FETCH_ASSOC);
            
            $tx_documento_odp='';
            if($camposPago["tx_documento_odp"]==null){
                $tx_documento_odp = $camposPago["tx_serial"];
            }else{
                $tx_documento_odp = $camposPago["tx_documento_odp"];
            }
                
            
            
            $Tb155CuentaBancariaHistorico = new Tb155CuentaBancariaHistorico();
            $Tb155CuentaBancariaHistorico->setInActivo(TRUE)
                                         ->setIdTb011CuentaBancaria($camposPago["co_cuenta_bancaria"])
                                         ->setMoTransaccion($monto_total)
                                         ->setFeTransaccion($fecha)
                                         ->setDeObservacion($tx_descripcion)
                                         ->setIdTb010Banco($camposPago["co_banco"])
                                         ->setIdTb154TipoCuentaMovimiento(3)
                                         ->setIdTb153TipoDocumentoCuenta(3)
                                         ->setNuTransaccion($tx_documento_odp)
                                         ->setCoSolicitud($camposPago["co_solicitud"])
                                         ->setInConciliado(FALSE)
                                         ->setMoSaldoAnterior($monto_disponible_anterior)
                                         ->setMoSaldoNuevo($monto_disponible_actual)
                                         ->save($con);
           
            }
            //*******************HITORICO DE CUENTAS BANCARIAS***************************************************
   }
   
  public function executeGuardarNomina(sfWebRequest $request)
  {


     $codigo = $this->getRequestParameter("co_pago_nomina");

     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb122_pago_nomina = Tb122PagoNominaPeer::retrieveByPk($codigo);
     }else{
         $tb122_pago_nomina = new Tb122PagoNomina();
     }
     try
      {
        $con->beginTransaction();

        $tb122_pago_nominaForm = $this->getRequestParameter('tb122_pago_nomina');
        $tb122_pago_nomina->setCoTipoTrabajador($tb122_pago_nominaForm["co_tipo_trabajador"]);
        $tb122_pago_nomina->setCoTipoNomina($tb122_pago_nominaForm["co_tipo_nomina"]);
        $tb122_pago_nomina->setTxConcepto($tb122_pago_nominaForm["tx_concepto"]);
        $tb122_pago_nomina->setCoEjecutor($tb122_pago_nominaForm["co_ejecutor"]);

        list($dia, $mes, $anio) = explode("/",$tb122_pago_nominaForm["fe_pago"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb122_pago_nomina->setFePago($fecha);


        $tb122_pago_nomina->setCoSolicitud($tb122_pago_nominaForm["co_solicitud"]);
        $tb122_pago_nomina->setCoUsuario($this->getUser()->getAttribute('codigo'));
        $tb122_pago_nomina->save($con);

        $lines = file($_FILES['form-file']['tmp_name']);
        $i=0;
        $cadena = '';

        $wherec = new Criteria();
        $wherec->add(Tb123ArchivoPagoPeer::CO_PAGO_NOMINA, $tb122_pago_nomina->getCoPagoNomina(), Criteria::EQUAL);
        BasePeer::doDelete($wherec, $con);

        $mo_total = 0;

        foreach($lines as $line)
        {
            $cadena = str_replace("|","", $line);
            $array = explode(",", $cadena);

            if(!is_numeric(trim($array[0]))){
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El código de persona  '.$array[0].' debe ser númerico '.$array[1].'linea '.$i
                ));
                echo $this->data;
                return sfView::NONE;
            }

            if(strlen(trim($array[1]))>9){
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El número de cédula  '.trim($array[1]).' debe tener una longitud de 9 caracteres '
                ));
                echo $this->data;
                return sfView::NONE;
            }

            if(strlen(trim($array[3]))==''){
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El número de cuenta  '.trim($array[3]).' debe tener una longitud de menos 10 digitos'
                ));
                echo $this->data;
                return sfView::NONE;
            }

            /*if(trim($array[5]) == '06'){
               $co_banco = '0108'; 
            }
            
            if(trim($array[5]) == '10'){
                $co_banco = '0102';
            }
            
            if(trim($array[5]) == '20'){
                $co_banco = '0116';
            }*/

            /*if( trim($array[5]) == '06'){
                $co_banco = '0108';
            }elseif( trim($array[5]) == '10'){
                $co_banco = '0102';
            }elseif( trim($array[5]) == '20'){
                $co_banco = '0116';
            }*/

            $co_banco = Tb010BancoPeer::getCodigo( trim($array[5]));
            $co_modo = Tb010BancoPeer::getModoPago( trim($array[3]), trim($array[5]));
            
            $Tb123ArchivoPago = new Tb123ArchivoPago();
            $Tb123ArchivoPago->setCoPagoNomina($tb122_pago_nomina->getCoPagoNomina())
                             ->setCoPersona(trim(utf8_decode($array[0])))
                             ->setTxCedula(trim(utf8_decode($array[1])))
                             ->setNbPersona(utf8_decode($array[2]))
                             ->setTxCuentaBancaria(trim(utf8_decode($array[3])))
                             ->setNuMonto(trim(utf8_decode($array[4])))
                             ->setCodBanco($co_banco)
                             ->setIdTb163ModoPago($co_modo)
                             //->setCoUbicacion(trim(utf8_decode($array[6])))
                             ->save($con);
            
            $mo_total+=trim($array[4]);
            $cadena = $array[2];
            $i++;
        }
        
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb062LiquidacionPagoPeer::MO_PAGAR);
        $c->add(Tb062LiquidacionPagoPeer::CO_SOLICITUD,$tb122_pago_nominaForm["co_solicitud"]);  
        $stmt = Tb062LiquidacionPagoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);        
        $diferencia = (float)$mo_total-(float)$campos["mo_pagar"];
        if((float)$mo_total!=(float)$campos["mo_pagar"])
        {
            
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  "El monto de la nomina debe ser igual al monto total cargado ".$campos["mo_pagar"]."!=".$mo_total.'diferencia='.$diferencia,
                "monto" => $mo_total,
                "diferencia" => $diferencia 
            ));
            
            echo $this->data;
            return sfView::NONE;
            
        }        

        
        if($i==0){
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  "Debe Seleccionar un archivo de nomina",
            ));
            
            echo $this->data;
            return sfView::NONE;
        }
        
        
        
        $tb122_pago_nomina->setMoTotal($mo_total)->save($con);
        
        
        if($i>0){
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb122_pago_nominaForm["co_solicitud"]));
            $ruta->setInCargarDato(true)->save($con);
        }else{
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb122_pago_nominaForm["co_solicitud"]));
            $ruta->setInCargarDato(false)->save($con);
        }

        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente ',
                    "monto" => $mo_total,
                    "diferencia" => $diferencia 
                ));
        
        $con->commit();

      }catch (PropelException $e)
      {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage().'---'.$i.'----'.$cadena
        ));
      }

       echo $this->data;
       return sfView::NONE;


  }   

  public function executeGuardar(sfWebRequest $request)
  {

     $co_solicitud = $this->getRequestParameter("co_solicitud");
     $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
     $json_pagos = $this->getRequestParameter("co_liquidacion_pago");
     $tb062PagosForm = $this->getRequestParameter('Pagos');
     $co_ruta = Tb030RutaPeer::getCoRuta($co_solicitud);   
     $con = Propel::getConnection();

    try
      { 
        $con->beginTransaction();
        
        $tb026_solicitud = Tb026SolicitudPeer::retrieveByPK($co_solicitud);
        $tb008_proveedor = Tb008ProveedorPeer::retrieveByPK($tb026_solicitud->getCoProveedor());
        if($tb008_proveedor->getNuCuentaBancaria()==null || $tb008_proveedor->getNuCuentaBancaria()=='' || $tb008_proveedor->getCoBanco()==null) {

            $this->data = json_encode(array(
              'success' => false,
              'msg' => '<span style="color:red;font-size:13px,"><b>El Proveedor no tiene Banco o cuenta bancaria registrada verifique.!</b></span>'
            ));

            return $this->setTemplate('store');
        }        
        
        $listaPagos  = json_decode($json_pagos,true);
        $cant_pagos = count($listaPagos);
        foreach($listaPagos  as $PagosForm){
            $tb062_liquidacion_pago = Tb062LiquidacionPagoPeer::retrieveByPk($PagosForm["co_liquidacion_pago"]);
            /*CAMPOS*/
            if($cant_pagos==1){
                $mo_pagado = $tb062PagosForm["monto"] + $tb062PagosForm["mo_pagado"];
                $mo_pendiente = $tb062PagosForm["mo_pendiente"] - $tb062PagosForm["monto"];
                $monto = $tb062PagosForm["monto"];
                $tb062_liquidacion_pago->setMoPagado($mo_pagado);
                $tb062_liquidacion_pago->setMoPendiente($mo_pendiente);
            }else{
                $monto = $PagosForm["mo_pendiente"];    
                $mo_pagado = $tb062PagosForm["monto"];
                $mo_pendiente = $tb062PagosForm["mo_pendiente"] - $tb062PagosForm["monto"];

                $tb062_liquidacion_pago->setMoPagado($PagosForm["mo_pendiente"]+$PagosForm["mo_pagado"]);
                $tb062_liquidacion_pago->setMoPendiente(0); 
            }
            
            $porcentaje_pago = round(($tb062PagosForm["monto"]*100)/$PagosForm["mo_pagar"],15);
            
            if($mo_pendiente==0){
                $casiento = new Criteria;
                $casiento->add(Tb061AsientoContablePeer::CO_SOLICITUD,$co_solicitud);
                $casiento->add(Tb061AsientoContablePeer::MO_HABER,NULL,  Criteria::ISNOTNULL);
                
                $stmt_asiento = Tb061AsientoContablePeer::doSelectStmt($casiento);

                while($reg = $stmt_asiento->fetch(PDO::FETCH_ASSOC)){
                    
                    if($reg["co_cuenta_contable"]!=''){
                        $tb024_cuenta_contable = Tb024CuentaContablePeer::retrieveByPK($reg["co_cuenta_contable"]);

                        $mo_disponible_cuenta = ($tb024_cuenta_contable->getMoDisponible()=='')?0:$tb024_cuenta_contable->getMoDisponible();

                        $monto_haber = $mo_disponible_cuenta+$reg["mo_haber"];
                        $tb024_cuenta_contable->setMoDisponible($monto_haber)->save($con);                    
                    }
                }
            }
            
            /*CAMPOS*/
            $tb062_liquidacion_pago->save($con);

            /*if($tb062PagosForm["co_forma_pago"]==1){
                $c = new Criteria();
                $c->add(Tb077ChequePeer::CO_CHEQUERA, $tb062PagosForm["co_chequera"]);
                $c->add(Tb077ChequePeer::CO_ESTADO_CHEQUE,1);
                $c->addAscendingOrderByColumn(Tb077ChequePeer::CO_CHEQUE);
                $c->setLimit(1);
                $cantidad = Tb077ChequePeer::doCount($c);
                $stmt = Tb077ChequePeer::doSelectStmt($c);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                if($cantidad==0){
                    $con->rollback();
                    $this->data = json_encode(array(
                    "success" => false,
                    "msg" =>  $e->getMessage()
                    ));  
                    return;
                }
                $nu_pago = $res["tx_descripcion"];
                $tb077Cheque = Tb077ChequePeer::retrieveByPK($res["co_cheque"]);
                $tb077Cheque->setCoEstadoCheque(2)->save($con);            

            }else{
                $nu_pago =  $tb062PagosForm["nu_referencia"];
            }*/

            $tipo_asiento = 3;

            switch ($tb062PagosForm["co_forma_pago"]){
                case 1:
                    //Cheques
                    if($co_tipo_solicitud == 38){
                    $tipo_asiento = 3;
                    $nu_pago = $tb062PagosForm["nu_referencia"];                        
                    }else{
                    $c = new Criteria();
                    $c->add(Tb077ChequePeer::CO_CHEQUERA, $tb062PagosForm["co_chequera"]);
                    $c->add(Tb077ChequePeer::CO_ESTADO_CHEQUE,1);
                    $c->addAscendingOrderByColumn(Tb077ChequePeer::CO_CHEQUE);
                    $c->setLimit(1);
                    $cantidad = Tb077ChequePeer::doCount($c);
                    $stmt = Tb077ChequePeer::doSelectStmt($c);
                    $res = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($cantidad==0){
                        $con->rollback();
                        $this->data = json_encode(array(
                        "success" => false,
                        "msg" =>  $e->getMessage()
                        ));  
                        return;
                    }

                    $tipo_asiento = 3;
                    $nu_pago = $res["tx_descripcion"];
                    $tb077Cheque = Tb077ChequePeer::retrieveByPK($res["co_cheque"]);
                    $tb077Cheque->setCoEstadoCheque(2)->save($con); 
                    }
                    break;
                case 3:

                    //Cheques de Gerencia
                    $cg = new Criteria();
                    $cg->add(Tb079ChequeraPeer::CO_CUENTA_BANCARIA, $tb062PagosForm["co_cuenta"]);
                    $cg->add(Tb079ChequeraPeer::TX_DESCRIPCION, 'CHEQUERA CHEQUE DE GERENCIA');
                    $stmtcg = Tb079ChequeraPeer::doSelectStmt($cg);
                    $cantidad_cg = Tb079ChequeraPeer::doCount($cg);
                    $campos_cg = $stmtcg->fetch(PDO::FETCH_ASSOC);

                    $co_chequera = $campos_cg["co_chequera"];
                    $co_cheque = null;

                    if($cantidad_cg==0){

                        $tb079_chequera = new Tb079Chequera();
                        $tb079_chequera->setCoCuentaBancaria($tb062PagosForm["co_cuenta"]);
                        $tb079_chequera->setTxDescripcion('CHEQUERA CHEQUE DE GERENCIA');
                        $tb079_chequera->setNroChequera($this->getUser()->getAttribute('ejercicio'));
                        $tb079_chequera->setAnioChequera($this->getUser()->getAttribute('ejercicio'));
                        $tb079_chequera->setSerie(1);
                        $tb079_chequera->setNroInicial(9999);
                        $tb079_chequera->setNroFinal(9999);
                        $tb079_chequera->setCoEstadoChequera(1);
                        $tb079_chequera->setCoUsuario($this->getUser()->getAttribute('codigo'));
                        $tb079_chequera->setInActivo(true);
                        $tb079_chequera->setFeChequera(date("Y-m-d"));
                        $tb079_chequera->save($con);

                        $con->commit();

                        $co_chequera = $tb079_chequera->getCoChequera();

                        /*******Validar Cheque Existente************/
                        $buscar_cheque = new Criteria();
                        $buscar_cheque->add(Tb077ChequePeer::CO_CHEQUERA, $co_chequera);
                        $buscar_cheque->add(Tb077ChequePeer::TX_DESCRIPCION, $tb062PagosForm["nu_referencia"]);
                        $cantidad_buscar = Tb077ChequePeer::doCount($buscar_cheque);
                        /*******************************************/

                        if($cantidad_buscar > 0) {
                            $this->data = json_encode(array(
                              'success' => false,
                              'msg' => '<span style="color:red;font-size:13px,"><b>El numero de Cheque ya se encuenta registrado.!</b></span>'
                            ));
                 
                            return $this->setTemplate('store');
                        }

                        $tb077_cheque_nuevo = new Tb077Cheque();
                        $tb077_cheque_nuevo->setTxDescripcion($tb062PagosForm["nu_referencia"]);
                        $tb077_cheque_nuevo->setCoChequera($co_chequera);
                        $tb077_cheque_nuevo->setCoEstadoCheque(1);
                        $tb077_cheque_nuevo->setTxObservacion('PAGO DE CHEQUE');
                        $tb077_cheque_nuevo->save($con);

                        $con->commit();

                        $co_cheque = $tb077_cheque_nuevo->getCoCheque();

                    }else{

                        $c = new Criteria();
                        $c->add(Tb077ChequePeer::CO_CHEQUERA, $co_chequera);
                        $c->add(Tb077ChequePeer::CO_ESTADO_CHEQUE, 1);
                        $c->addAscendingOrderByColumn(Tb077ChequePeer::CO_CHEQUE);
                        $c->setLimit(1);
                        $cantidad = Tb077ChequePeer::doCount($c);
                        $stmt = Tb077ChequePeer::doSelectStmt($c);
                        $res = $stmt->fetch(PDO::FETCH_ASSOC);
                        //if($cantidad==0){

                        /*******Validar Cheque Existente************/
                        $buscar_cheque = new Criteria();
                        $buscar_cheque->add(Tb077ChequePeer::CO_CHEQUERA, $co_chequera);
                        $buscar_cheque->add(Tb077ChequePeer::TX_DESCRIPCION, $tb062PagosForm["nu_referencia"]);
                        $cantidad_buscar = Tb077ChequePeer::doCount($buscar_cheque);
                        /*******************************************/

                        if($cantidad_buscar > 0) {
                            
                            $this->data = json_encode(array(
                              'success' => false,
                              'msg' => '<span style="color:red;font-size:13px,"><b>El numero de Cheque ya se encuenta registrado.!</b></span>'
                            ));
                 
                            return $this->setTemplate('store');
                        }

                        $tb077_cheque_nuevo = new Tb077Cheque();
                        $tb077_cheque_nuevo->setTxDescripcion($tb062PagosForm["nu_referencia"]);
                        $tb077_cheque_nuevo->setCoChequera($co_chequera);
                        $tb077_cheque_nuevo->setCoEstadoCheque(1);
                        $tb077_cheque_nuevo->setTxObservacion('PAGO DE CHEQUE');
                        $tb077_cheque_nuevo->save($con);

                        $con->commit();

                        $co_cheque = $tb077_cheque_nuevo->getCoCheque();
                            
                        //}

                    }

                    //var_dump($co_cheque);
                    //exit();

                    $tipo_asiento = 3;
                    $nu_pago = $tb062PagosForm["nu_referencia"];
                    $tb077Cheque = Tb077ChequePeer::retrieveByPK($co_cheque);
                    $tb077Cheque->setCoEstadoCheque(2);
                    $tb077Cheque->save($con); 

                    $con->commit();

                    break;
                case 4:
                    //Nota de Debito
                    $tipo_asiento = 9;
                    $nu_pago =  $tb062PagosForm["nu_referencia"];

                    break;
                default:
                    $tipo_asiento = 3;
                    $nu_pago =  $tb062PagosForm["nu_referencia"];
                break;
            }

            $co_chequera = $tb062PagosForm["co_chequera"]?$tb062PagosForm["co_chequera"]:$co_chequera;
            $co_cheque = $tb062PagosForm["co_cheque"]?$tb062PagosForm["co_cheque"]:$co_cheque;

            $tb063_pago = new Tb063Pago();

            $tb063_pago->setCoLiquidacionPago($PagosForm["co_liquidacion_pago"]);
            $tb063_pago->setCoFormaPago($tb062PagosForm["co_forma_pago"]);
            $tb063_pago->setCoBanco($tb062PagosForm["co_banco"]?$tb062PagosForm["co_banco"]:null);
            $tb063_pago->setCoCuentaBancaria($tb062PagosForm["co_cuenta"]?$tb062PagosForm["co_cuenta"]:null);
            //$tb063_pago->setCoChequera($tb062PagosForm["co_chequera"]?$tb062PagosForm["co_chequera"]:null);
            $tb063_pago->setCoChequera($co_chequera);
            //$tb063_pago->setCoCheque($tb062PagosForm["co_cheque"]?$tb062PagosForm["co_cheque"]:null);
            $tb063_pago->setCoCheque($co_cheque);
            
            list($dia, $mes, $anio) = explode("-",$tb062PagosForm["fe_emision"]);
            $fecha = $anio."-".$mes."-".$dia;
            
            $tb063_pago->setFePago($fecha);
            $tb063_pago->setNuPago($nu_pago);
            $tb063_pago->setNuMonto($monto);
            $tb063_pago->setCoUsuario($this->getUser()->getAttribute('codigo'));
            
            
            
            
            $monto_total+=$monto;             

            /*CAMPOS*/
            $tb063_pago->save($con);
            
            
       }
       
        /*ASIENTO CONTABLE*/
        if($co_tipo_solicitud == 14|| $co_tipo_solicitud == 38){
            
        }else{
        $co_cuenta_por_pagar = Tb130CuentaDocumentoPeer::getCoCuentaContable($co_solicitud); 
        } 
        if($co_tipo_solicitud == 14 || $co_tipo_solicitud == 38){
            //14-38Pagos de fondo a tercero 
                
        if ($co_tipo_solicitud == 14){       
            $tercero = new Criteria();
            $tercero->add(Tb069FondoTerceroPeer::CO_SOLICITUD, $co_solicitud);
            $stmttercero = Tb069FondoTerceroPeer::doSelectStmt($tercero);
            $res_tercero = $stmttercero->fetch(PDO::FETCH_ASSOC);                
            
            $detalle_tercero = new Criteria();
            $detalle_tercero->addSelectColumn(Tb041TipoRetencionPeer::CO_CUENTA_TERCERO);
            $detalle_tercero->addSelectColumn(Tb070DetalleFondoPeer::MONTO);
            $detalle_tercero->add(Tb070DetalleFondoPeer::CO_FONDO_TERCERO, $res_tercero["co_fondo_tercero"]);
            $detalle_tercero->addJoin(Tb041TipoRetencionPeer::CO_TIPO_RETENCION, Tb070DetalleFondoPeer::CO_TIPO_RETENCION);
            $stmtdetalletercero = Tb070DetalleFondoPeer::doSelectStmt($detalle_tercero); 
            
            
            while($res_detalle_tercero = $stmtdetalletercero->fetch(PDO::FETCH_ASSOC)){
            
            $tb061_asiento_contable = new Tb061AsientoContable();
            $tb061_asiento_contable->setMoDebe($res_detalle_tercero["monto"])
                                    ->setCoCuentaContable($res_detalle_tercero["co_cuenta_tercero"])
                                    ->setCoSolicitud($co_solicitud)
                                    ->setCreatedAt($fecha)
                                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                    ->setCoRuta($co_ruta)
                                    ->setCoTipoAsiento(3)
                                    ->save($con);
            }            
            
        }else{
        
            $detalle_tercero = new Criteria();
            $detalle_tercero->addSelectColumn(Tb041TipoRetencionPeer::CO_CUENTA_TERCERO);
            $detalle_tercero->addSelectColumn(Tb060OrdenPagoPeer::MO_PAGAR);
            $detalle_tercero->add(Tb161PagoFondoTerceroPeer::CO_SOLICITUD, $co_solicitud);
            $detalle_tercero->addJoin(Tb041TipoRetencionPeer::CO_TIPO_RETENCION, Tb161PagoFondoTerceroPeer::CO_TIPO_RETENCION);
            $detalle_tercero->addJoin(Tb060OrdenPagoPeer::CO_SOLICITUD, Tb161PagoFondoTerceroPeer::CO_SOLICITUD);
            $stmtdetalletercero = Tb161PagoFondoTerceroPeer::doSelectStmt($detalle_tercero);   
            
            while($res_detalle_tercero = $stmtdetalletercero->fetch(PDO::FETCH_ASSOC)){
            
            $tb061_asiento_contable = new Tb061AsientoContable();
            $tb061_asiento_contable->setMoDebe($res_detalle_tercero["mo_pagar"])
                                    ->setCoCuentaContable($res_detalle_tercero["co_cuenta_tercero"])
                                    ->setCoSolicitud($co_solicitud)
                                    ->setCreatedAt($fecha)
                                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                    ->setCoRuta($co_ruta)
                                    ->setCoTipoAsiento(3)
                                    ->save($con);
            }            
            
        }
            

            
            
            
        }else{
            
        if($co_tipo_solicitud == 28){
            
            $odp = Tb060OrdenPagoPeer::retrieveByPK($tb062_liquidacion_pago->getCoOdp());

            $tb061_asiento_contable = new Tb061AsientoContable();
            $tb061_asiento_contable->setMoDebe($monto_total)
                                    ->setCoCuentaContable(97938)
                                    ->setCoSolicitud($co_solicitud)
                                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                    ->setCoRuta($co_ruta)
                                    ->setCreatedAt($fecha)
                                    ->setCoTipoAsiento($tipo_asiento)
                                    ->save($con);
            
            //$odp->setFePago(date("Y-m-d"));
            if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
                $odp->setFePago($this->getUser()->getAttribute('fe_cierre')); 
            }else{
                $odp->setFePago(date("Y-m-d")); 
            }  
            
            $c1  = new Criteria();
            $c1->addSelectColumn(Tb062LiquidacionPagoPeer::MO_PENDIENTE);
            $c1->add(Tb062LiquidacionPagoPeer::CO_SOLICITUD,$co_solicitud);
            $stmt1 = Tb062LiquidacionPagoPeer::doSelectStmt($c1);
            $pendiente = 0;
            while($reg1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                $pendiente += $reg1["mo_pendiente"];
            }
            if($pendiente==0){            
                $odp->setInPagado(true);
            }          

                $odp->save($con);            
            
        }else{            
            $odp = Tb060OrdenPagoPeer::retrieveByPK($tb062_liquidacion_pago->getCoOdp());

            $tb061_asiento_contable = new Tb061AsientoContable();
            $tb061_asiento_contable->setMoDebe($monto_total)
                                    ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_orden_pago"])
                                    ->setCoSolicitud($co_solicitud)
                                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                    ->setCoRuta($co_ruta)
                                    ->setCreatedAt($fecha)
                                    ->setCoTipoAsiento($tipo_asiento)
                                    ->save($con);
            
            //$odp->setFePago(date("Y-m-d"));
            if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
                $odp->setFePago($this->getUser()->getAttribute('fe_cierre')); 
            }else{
                $odp->setFePago(date("Y-m-d")); 
            }  
            
            $c1  = new Criteria();
            $c1->addSelectColumn(Tb062LiquidacionPagoPeer::MO_PENDIENTE);
            $c1->add(Tb062LiquidacionPagoPeer::CO_SOLICITUD,$co_solicitud);
            $stmt1 = Tb062LiquidacionPagoPeer::doSelectStmt($c1);
            $pendiente = 0;
            while($reg1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                $pendiente += $reg1["mo_pendiente"];
            }
            if($pendiente==0){            
                $odp->setInPagado(true);
            }          

                $odp->save($con);  
        }
        }
      
        
        $cuenta = new Criteria();
        $cuenta->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA, $tb062PagosForm["co_cuenta"]);
        $stmtcuenta = Tb011CuentaBancariaPeer::doSelectStmt($cuenta);
        $res_cuenta = $stmtcuenta->fetch(PDO::FETCH_ASSOC);
        
        $tb061_asiento_contable = new Tb061AsientoContable();
        $tb061_asiento_contable->setMoHaber($monto_total)
                               ->setCoSolicitud($co_solicitud)
                               ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                               ->setCoCuentaContable($res_cuenta["co_cuenta_contable"])
                               ->setCreatedAt($fecha)
                               ->setCoTipoAsiento($tipo_asiento)
                               ->setCoRuta($co_ruta)
                               ->save($con);        
        /*************HISTORICO MOVIMIENTO BANCARIO**************************************/
        
        $monto_disponible_anterior = $res_cuenta["mo_ingreso"]-$res_cuenta["mo_egreso"];
        $monto_total_egreso = $res_cuenta["mo_egreso"]+$monto_total;
        $monto_disponible_actual   = $res_cuenta["mo_ingreso"]-$monto_total_egreso;
        
        $this->HistoricoPago($co_solicitud,$tb062PagosForm["co_cuenta"],$monto_disponible_anterior,$monto_disponible_actual,$monto_total,$fecha,$con,$tb062PagosForm["tx_descripcion"]);
        
        $Tb011CuentaBancaria = Tb011CuentaBancariaPeer::retrieveByPK($res_cuenta["co_cuenta_bancaria"]);
        $Tb011CuentaBancaria->setMoEgreso($monto_total_egreso)->save($con);
        
        /*************HISTORICO MOVIMIENTO BANCARIO**************************************/
        

                $cpresupuesto = new Criteria;
                $cpresupuesto->clearSelectColumns();
                $cpresupuesto->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
                $cpresupuesto->addSelectColumn(Tb053DetalleComprasPeer::CO_PRODUCTO);
                $cpresupuesto->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
                $cpresupuesto->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
                $cpresupuesto->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS,  Tb052ComprasPeer::CO_COMPRAS);
                $cpresupuesto->add(Tb052ComprasPeer::CO_SOLICITUD,$co_solicitud);
                              
                $stmt_presupuesto = Tb053DetalleComprasPeer::doSelectStmt($cpresupuesto);


                while($reg = $stmt_presupuesto->fetch(PDO::FETCH_ASSOC)){
                    if($reg["co_presupuesto"]!=''){
                    /*$tb085_presupuesto = Tb085PresupuestoPeer::retrieveByPK($reg["co_presupuesto"]);
//                    $mo_causado = $tb085_presupuesto->getMoCausado()-$reg["mo_debe"];
                    $porcentaje = round(($reg["monto"] * $porcentaje_pago)/100,2);
                    $mo_pagado = $tb085_presupuesto->getMoPagado()+$porcentaje;

                    $tb085_presupuesto->setMoPagado($mo_pagado)
                                      ->save($con);*/

                        $contador = Tb087PresupuestoMovimientoPeer::verificar( $reg["co_detalle_compras"], 3);

                        if($contador==null){

                            $tb085_presupuesto = Tb085PresupuestoPeer::retrieveByPK($reg["co_presupuesto"]);
                            $porcentaje = round(($reg["monto"] * $porcentaje_pago)/100,15);
                            $mo_pagado = $tb085_presupuesto->getMoPagado()+$porcentaje;
                            $tb085_presupuesto->setMoPagado($mo_pagado);
                            $tb085_presupuesto->save($con);

                        }else{

                            $tb085_presupuesto = Tb085PresupuestoPeer::retrieveByPK($reg["co_presupuesto"]);
                            $porcentaje = round(($reg["monto"] * $porcentaje_pago)/100,15);
                            $mo_pagado = $tb085_presupuesto->getMoPagado()+$porcentaje;
                            $tb085_presupuesto->setMoPagado($mo_pagado);
                            $tb085_presupuesto->save($con);

                        }
                    
                        switch ($co_tipo_solicitud){
                            case 23:

                                $contador = Tb087PresupuestoMovimientoPeer::verificar( $reg["co_detalle_compras"], 3);

                                if($contador==null){
                                       
                                    $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                                    $tb087_presupuesto_movimiento->setCoPartida($tb085_presupuesto->getId())
                                                    ->setCoTipoMovimiento(3)
                                                    ->setNuMonto($porcentaje)
                                                    ->setCreatedAt($fecha)
                                                    ->setNuAnio( $this->getUser()->getAttribute('ejercicio'))
                                                    ->setCoDetalleCompra($reg["co_detalle_compras"])
                                                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))                                     
                                                    ->setInActivo(true)
                                                    ->save($con);
                                }

                                break;
                            default:
//                                var_dump($porcentaje_pago);
//                                exit();
                                $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                                $tb087_presupuesto_movimiento->setCoPartida($tb085_presupuesto->getId())
                                                ->setCoTipoMovimiento(3)
                                                ->setNuMonto($porcentaje)
                                                ->setCreatedAt($fecha)
                                                ->setNuAnio( $this->getUser()->getAttribute('ejercicio'))
                                                ->setCoDetalleCompra($reg["co_detalle_compras"])
                                                ->setCoUsuario($this->getUser()->getAttribute('codigo'))                                     
                                                ->setInActivo(true)
                                                ->save($con);

                                break;
                        }

                    }

               }         
        
        /*ASIENTO CONTABLE*/

       $c  = new Criteria();
       $c->addSelectColumn(Tb062LiquidacionPagoPeer::MO_PENDIENTE);
       $c->add(Tb062LiquidacionPagoPeer::CO_SOLICITUD,$co_solicitud);
       $stmt = Tb062LiquidacionPagoPeer::doSelectStmt($c);
        $pendiente = 0;
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            $pendiente += $reg["mo_pendiente"];
        }
        if($pendiente==0){            
            
//                $cpresupuesto = new Criteria;
//                $cpresupuesto->clearSelectColumns();
//                $cpresupuesto->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
//                $cpresupuesto->addSelectColumn(Tb053DetalleComprasPeer::CO_PRODUCTO);
//                $cpresupuesto->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
//                $cpresupuesto->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
//                $cpresupuesto->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS,  Tb052ComprasPeer::CO_COMPRAS);
//                $cpresupuesto->add(Tb052ComprasPeer::CO_SOLICITUD,$co_solicitud);
//                              
//                $stmt_presupuesto = Tb053DetalleComprasPeer::doSelectStmt($cpresupuesto);
//
//                while($reg = $stmt_presupuesto->fetch(PDO::FETCH_ASSOC)){
//                    if($reg["co_presupuesto"]!=''){
//                    $tb085_presupuesto = Tb085PresupuestoPeer::retrieveByPK($reg["co_presupuesto"]);
////                    $mo_causado = $tb085_presupuesto->getMoCausado()-$reg["mo_debe"];
//                    
//                    $mo_pagado = $tb085_presupuesto->getMoPagado()+$reg["monto"];
//
//                    $tb085_presupuesto->setMoPagado($mo_pagado)
//                                      ->save($con);
//                    
//
//                    $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
//                    $tb087_presupuesto_movimiento->setCoPartida($tb085_presupuesto->getId())
//                                     ->setCoTipoMovimiento(3)
//                                     ->setNuMonto($reg["monto"])
//                                     //->setNuAnio(date('Y'))
//                                     ->setNuAnio( $this->getUser()->getAttribute('ejercicio'))
//                                     ->setCoDetalleCompra($reg["co_detalle_compras"])
//                                     ->setCoUsuario($this->getUser()->getAttribute('codigo'))                                     
//                                     ->setInActivo(true)
//                                     ->save($con);
//                    }
//               } 
            
            
            
//            antes
//            if($co_tipo_solicitud == 23){  
//                $cp = new Criteria;
//                $cp->clearSelectColumns();
//                $cp->addSelectColumn(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE);
//                $cp->addSelectColumn(Tb046FacturaRetencionPeer::MO_RETENCION);
//                $cp->addSelectColumn(Tb046FacturaRetencionPeer::CO_FACTURA);
//                $cp->addJoin(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Tb041TipoRetencionPeer::CO_CUENTA_CONTABLE,  Criteria::LEFT_JOIN);
//                $cp->addJoin(Tb041TipoRetencionPeer::CO_TIPO_RETENCION, Tb046FacturaRetencionPeer::CO_TIPO_RETENCION, Criteria::LEFT_JOIN);
//                $cp->addJoin(Tb046FacturaRetencionPeer::CO_SOLICITUD, Tb060OrdenPagoPeer::CO_SOLICITUD , Criteria::LEFT_JOIN);
//                $cp->add(Tb060OrdenPagoPeer::CO_ORDEN_PAGO,$tb062_liquidacion_pago->getCoOdp());
//        
//                
//            }
//            else{
//                $cp = new Criteria;
//                $cp->clearSelectColumns();
//                $cp->addSelectColumn(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE);
//                $cp->addSelectColumn(Tb046FacturaRetencionPeer::MO_RETENCION);
//                $cp->addSelectColumn(Tb046FacturaRetencionPeer::CO_FACTURA);
//                $cp->addJoin(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Tb041TipoRetencionPeer::CO_CUENTA_CONTABLE,  Criteria::LEFT_JOIN);
//                $cp->addJoin(Tb041TipoRetencionPeer::CO_TIPO_RETENCION, Tb046FacturaRetencionPeer::CO_TIPO_RETENCION, Criteria::LEFT_JOIN);
//                $cp->add(Tb046FacturaRetencionPeer::CO_ODP,$tb062_liquidacion_pago->getCoOdp());
//                       
//            }
//            
//            
//            $stmt_pc = Tb024CuentaContablePeer::doSelectStmt($cp); 
            
            //ahora
                $cp = new Criteria;
                $cp->clearSelectColumns();
                $cp->addSelectColumn(Tb041TipoRetencionPeer::CO_CUENTA_CONTABLE);
                $cp->addSelectColumn(Tb046FacturaRetencionPeer::MO_RETENCION);
                $cp->addSelectColumn(Tb046FacturaRetencionPeer::CO_FACTURA_RETENCION);
                $cp->addSelectColumn(Tb046FacturaRetencionPeer::CO_TIPO_RETENCION);
                $cp->addSelectColumn(Tb046FacturaRetencionPeer::CO_FACTURA);
                $cp->addJoin(Tb041TipoRetencionPeer::CO_TIPO_RETENCION, Tb046FacturaRetencionPeer::CO_TIPO_RETENCION, Criteria::LEFT_JOIN);
                $cp->add(Tb046FacturaRetencionPeer::CO_SOLICITUD,$co_solicitud);
                $cp->add(Tb046FacturaRetencionPeer::IN_ANULAR,NULL, Criteria::ISNULL);     
                
                $stmt_pc = Tb046FacturaRetencionPeer::doSelectStmt($cp);

            while($reg = $stmt_pc->fetch(PDO::FETCH_ASSOC)){

                $tb061_asiento_contable = new Tb061AsientoContable();
                $tb061_asiento_contable->setMoHaber($reg["mo_retencion"])
                                       ->setCoSolicitud($co_solicitud)
                                       ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                       ->setCoCuentaContable($reg["co_cuenta_contable"])
                                       ->setCoFactura($reg["co_factura"])
                                       ->setCreatedAt($fecha)
                                       ->setCoTipoAsiento(3)
                                       ->setCoRuta($co_ruta)
                                       ->save($con);
                
            $tb061_asiento_contable = new Tb061AsientoContable();
            $tb061_asiento_contable->setMoDebe($reg["mo_retencion"])
                                    ->setCoCuentaContable($co_cuenta_por_pagar["co_cuenta_orden_pago"])
                                    ->setCoSolicitud($co_solicitud)
                                    ->setCreatedAt($fecha)
                                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                    ->setCoRuta($co_ruta)
                                    ->setCoTipoAsiento(3)
                                    ->save($con); 

         $sql_retencion = "SELECT  count(t1.co_factura_retencion) + 1 as correlativo
	   FROM  tb046_factura_retencion as t1
	   WHERE nu_comprobante is not null and co_tipo_retencion = ".$reg["co_tipo_retencion"];
         
         $stmt_retencion = $con->prepare($sql_retencion);

         $stmt_retencion->execute();

         $row_retencion = $stmt_retencion->fetch(PDO::FETCH_ASSOC);        
            
                $tb046_factura_retencion = Tb046FacturaRetencionPeer::retrieveByPK($reg["co_factura_retencion"]); 
                $tb046_factura_retencion->setNuComprobante($row_retencion["correlativo"]);
                $tb046_factura_retencion->save($con);
            
            }
            
            
            
            $tb030ruta = Tb030RutaPeer::retrieveByPK($co_ruta);
            $tb030ruta->setCoEstatusRuta(2);
            $tb030ruta->setCoUsuarioActualizo($this->getUser()->getAttribute('codigo'));
            $tb030ruta->save($con);
            
            
            //fondo de terceros 
            if($co_tipo_solicitud == 14){  
                $ft = new Criteria;
                $ft->clearSelectColumns();
                $ft->addSelectColumn(Tb204RetencionFondoTerceroPeer::CO_FACTURA_RETENCION);
                $ft->add(Tb204RetencionFondoTerceroPeer::CO_SOLICITUD,$co_solicitud);
                $stmt_ft = Tb204RetencionFondoTerceroPeer::doSelectStmt($ft);
                while($reg_ft = $stmt_ft->fetch(PDO::FETCH_ASSOC)){
                $tb046_factura_retencion = Tb046FacturaRetencionPeer::retrieveByPK($reg_ft["co_factura_retencion"]); 
                $tb046_factura_retencion->setInPagado(true);
                $tb046_factura_retencion->setFePago($fecha);
                $tb046_factura_retencion->save($con);
                }
        
                
            }            
            
        }
        
        
        $con->commit();
         
        $this->data = json_encode(array(
                    "success" => true,
                    "co_pago" => $tb063_pago->getCoPago(),
                    "msg" => 'Proceso realizado exitosamente'
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
	$codigo = $this->getRequestParameter("co_ruta");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb030_ruta = Tb030RutaPeer::retrieveByPk($codigo);			
	$tb030_ruta->delete($con);
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
  
  protected function  getDatosPersona($codigo){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb109PersonaPeer::NU_CEDULA);
        $c->addSelectColumn(Tb109PersonaPeer::NB_PERSONA);
        $c->addSelectColumn(Tb109PersonaPeer::AP_PERSONA);
        $c->addJoin(Tb109PersonaPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
        $c->add(Tb109PersonaPeer::CO_PERSONA,$codigo);
        $stmt = Tb008ProveedorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos;
  } 
  
  public function executeStorelistapagos(sfWebRequest $request)
  {
   
    $limit         =   $this->getRequestParameter("limit",12);
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
    $c->addSelectColumn(Tb060OrdenPagoPeer::FE_EMISION); 
    $c->addSelectColumn(Tb026SolicitudPeer::CO_PERSONA);  
    $c->addSelectColumn(Tb060OrdenPagoPeer::TX_CONCEPTO); 
    $c->addSelectColumn(Tb026SolicitudPeer::TX_OBSERVACION);
    $c->addSelectColumn(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
    $c->addSelectColumn(Tb062LiquidacionPagoPeer::MO_PENDIENTE);
    $c->addSelectColumn(Tb060OrdenPagoPeer::CO_TIPO_ODP);
    
    
    $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
 //   $c->addSelectColumn(Tb060OrdenPagoPeer::TX_SERIAL);

    $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR,Tb008ProveedorPeer::CO_PROVEEDOR,   Criteria::LEFT_JOIN);
    $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO,  Tb007DocumentoPeer::CO_DOCUMENTO,   Criteria::LEFT_JOIN);
    $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb062LiquidacionPagoPeer::CO_SOLICITUD);
        
    $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addJoin(Tb028ProcesoPeer::CO_PROCESO, Tb030RutaPeer::CO_PROCESO);
    $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
    $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO);
    $c->addJoin(Tb060OrdenPagoPeer::CO_SOLICITUD, Tb062LiquidacionPagoPeer::CO_SOLICITUD);
    
  //  $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD,$registro_tramite,Criteria::IN);
    $c->addAnd(Tb062LiquidacionPagoPeer::MO_PENDIENTE,0,Criteria::GREATER_THAN);
    $c->addAnd(Tb060OrdenPagoPeer::IN_PAGADO,false);
    $c->addAnd(Tb030RutaPeer::CO_PROCESO,4,Criteria::IN);
    
    $c->addAnd(Tb030RutaPeer::CO_ESTATUS_RUTA,1);
    $c->addAnd(Tb030RutaPeer::IN_ACTUAL,true);
    //$c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
    
    
    //echo $c->toString(); exit();
    
    //$c->addAnd(Tb026SolicitudPeer::CO_USUARIO,$this->getUser()->getAttribute('codigo'));
    $cantidadTotal = Tb062LiquidacionPagoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb060OrdenPagoPeer::CO_ORDEN_PAGO);
 
    
//         $registros = '';
//         $sql = "select tb062.co_liquidacion_pago, tb062.tx_serial, tb062.co_solicitud,                    
//                        to_char(fe_emision,'dd/mm/yyyy') as fe_emision,
//                        tb062.mo_pagar,
//                        tb062.mo_pagado,
//                        tb062.mo_pendiente,
//                        tb062.nu_anio,
//                        tb027.tx_tipo_solicitud,
//			tb027.co_tipo_solicitud
//                from tb062_liquidacion_pago as tb062,
//                     tb026_solicitud as tb026,
//                     tb027_tipo_solicitud as tb027
//                where
//                     tb062.co_solicitud = tb026.co_solicitud and
//                     tb026.co_tipo_solicitud = tb027.co_tipo_solicitud and
//                     tb062.in_anular is null and
//                     tb062.co_solicitud = ".$co_solicitud." and tb062.mo_pendiente > 0  order by co_liquidacion_pago";    
    
    $stmt = Tb062LiquidacionPagoPeer::doSelectStmt($c);
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
        
        

        list($anio,$mes,$dia) = explode('-',$res["fe_emision"]);
        $registros[] = array(
                "tx_proceso"        => trim($res["tx_proceso"]),
                "co_ruta"           => trim($res["co_ruta"]),
                "co_liquidacion_pago" => trim($res["co_liquidacion_pago"]),
                "co_solicitud"      => trim($res["co_solicitud"]),
                "co_proceso"        => trim($res["co_proceso"]),
                "tx_tipo_solicitud" => trim($res["tx_tipo_solicitud"]),
                "co_tipo_solicitud" => trim($res["co_tipo_solicitud"]),
                "co_solicitud"      => trim($res["co_solicitud"]),
                "tx_login"          => trim($res["tx_login"]),
                "tx_rif"            => $tx_rif,
                "tx_razon_social"   => $tx_razon_social,
                "tx_concepto"       => trim($res["tx_observacion"]),
                "co_tipo_odp"       => trim($res["co_tipo_odp"]),
                "mo_pendiente"       => trim($res["mo_pendiente"]),
                "fe_emision"       => $dia.'-'.$mes.'-'.$anio,
                "cant_revision"     => $cantidad,
                "tx_serial"         => Tb060OrdenPagoPeer::getODP($res["co_solicitud"]),
                "co_ruta_odp"   => $this->getTxRutaReporte(10, $res["co_solicitud"])
            );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }
    
    
  public function executeStorelistapagosrealizados(sfWebRequest $request)
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
    
    
    if($tx_serial!=''){
        $c->add(Tb060OrdenPagoPeer::TX_SERIAL,$tx_serial);
    }
    
   
    $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));
    $registro_tramite = Tb006TipoSolicitudUsuarioPeer::getListaTramiteAsignado($this->getUser()->getAttribute('codigo'));
      
                              
    $c->setIgnoreCase(true);
    $c->setDistinct();
    $c->addSelectColumn(Tb063PagoPeer::CO_PAGO);
    $c->addSelectColumn(Tb062LiquidacionPagoPeer::CO_ODP);
    $c->addSelectColumn(Tb030RutaPeer::CO_PROCESO);
    $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);    
    $c->addSelectColumn(Tb001UsuarioPeer::TX_LOGIN);   
    $c->addSelectColumn(Tb026SolicitudPeer::CREATED_AT);  
    //$c->addSelectColumn(Tb060OrdenPagoPeer::TX_SERIAL);  
    
    $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);    

    $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR,Tb008ProveedorPeer::CO_PROVEEDOR,   Criteria::LEFT_JOIN);
    $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO,  Tb007DocumentoPeer::CO_DOCUMENTO,   Criteria::LEFT_JOIN);
   // $c->addJoin(Tb060OrdenPagoPeer::CO_SOLICITUD, Tb026SolicitudPeer::CO_SOLICITUD);
    
    $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
    $c->addJoin(Tb028ProcesoPeer::CO_PROCESO, Tb030RutaPeer::CO_PROCESO);
    $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO);
    $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb062LiquidacionPagoPeer::CO_SOLICITUD);
    $c->addJoin(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO, Tb063PagoPeer::CO_LIQUIDACION_PAGO);
    
   // $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD,$registro_tramite,Criteria::IN);
    $c->addAnd(Tb030RutaPeer::CO_PROCESO,4,Criteria::IN);
   // $c->addAnd(Tb030RutaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
    
    $c->addAnd(Tb030RutaPeer::CO_ESTATUS_RUTA,2);
    //$c->addAnd(Tb030RutaPeer::IN_ACTUAL,FALSE);
    $c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
    
    //$c->addAnd(Tb026SolicitudPeer::CO_USUARIO,$this->getUser()->getAttribute('codigo'));
    $cantidadTotal = Tb026SolicitudPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addDescendingOrderByColumn(Tb063PagoPeer::CO_PAGO);

    $stmt = Tb026SolicitudPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        $encrip = new myConfig();
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
                "tx_serial"         => trim(Tb060OrdenPagoPeer::getODPPagosRealizados($res["co_odp"])),
                "tx_rif"            => $tx_rif,
                "tx_razon_social"   => $tx_razon_social,            
                "fe_creacion"       => $dia.'-'.$mes.'-'.$anio,
                "cant_revision"     => $cantidad,
                "co_pago"           => trim($res["co_pago"]),
                "co_odp"            => trim($res["co_odp"]),
                "co_ruta_odp"       => $encrip->encrypt(Tb060OrdenPagoPeer::getODPRuta($res["co_odp"]))
            );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }
    
    
   public function executeStorelistapagosunificado(sfWebRequest $request)
   {
   
    $limit         =   $this->getRequestParameter("limit",12);
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
    $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR,Tb008ProveedorPeer::CO_PROVEEDOR,   Criteria::LEFT_JOIN);
    $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO,  Tb007DocumentoPeer::CO_DOCUMENTO,   Criteria::LEFT_JOIN);
    
    $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addJoin(Tb028ProcesoPeer::CO_PROCESO, Tb030RutaPeer::CO_PROCESO);
    $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
    $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO);
    
   // $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD,$registro_tramite,Criteria::IN);
    $c->addAnd(Tb030RutaPeer::CO_PROCESO,4,Criteria::IN);
    
    $c->addAnd(Tb030RutaPeer::CO_ESTATUS_RUTA,2);
    //$c->addAnd(Tb030RutaPeer::IN_ACTUAL,FALSE);
    
    $c->addGroupByColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
    $c->addGroupByColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
    
    //$c->addAnd(Tb026SolicitudPeer::CO_USUARIO,$this->getUser()->getAttribute('codigo'));
    $cantidadTotal = Tb026SolicitudPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
        
    $stmt = Tb026SolicitudPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        
        $cantidad = Tb026SolicitudPeer::getCantRevision($res["co_solicitud"]);

        $tx_rif = $res["inicial"]."-".$res["tx_rif"];
        $tx_razon_social = strtoupper($res["tx_razon_social"]);
        list($anio,$mes,$dia) = explode('-',$res["created_at"]);
        $registros[] = array(
                "tx_tipo_solicitud" => trim($res["tx_tipo_solicitud"]),
                "co_tipo_solicitud" => trim($res["co_tipo_solicitud"])
            );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }
    
    
    public function executeListaPendiente(){


        $co_solicitud = $this->getRequestParameter("co_solicitud");
         $con = Propel::getConnection();

         $registros = '';
         $sql = "select tb062.co_liquidacion_pago, tb062.tx_serial, tb062.co_solicitud,                    
                        to_char(fe_emision,'dd/mm/yyyy') as fe_emision,
                        tb062.mo_pagar,
                        tb062.mo_pagado,
                        tb062.mo_pendiente,
                        tb062.nu_anio,
                        tb027.tx_tipo_solicitud,
			tb027.co_tipo_solicitud
                from tb062_liquidacion_pago as tb062,
                     tb026_solicitud as tb026,
                     tb027_tipo_solicitud as tb027
                where
                     tb062.co_solicitud = tb026.co_solicitud and
                     tb026.co_tipo_solicitud = tb027.co_tipo_solicitud and
                     tb062.in_anular is null and
                     tb062.co_solicitud = ".$co_solicitud." and tb062.mo_pendiente > 0  order by co_liquidacion_pago";

         $stmt = $con->prepare($sql);

         $stmt->execute();

          while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $row ;
          }        
         $this->registros = json_encode(array(
          "success"=> true,
          "total"  => count($registros),
          "data"   => $registros
          ));
              
        }    
        
      public function executeListaPagos(){


        $co_solicitud = $this->getRequestParameter("co_solicitud");
         $con = Propel::getConnection();

         $registros = '';
         $sql = "select tb063.co_pago, tb063.co_liquidacion_pago,                  
                        to_char(tb063.fe_pago,'dd/mm/yyyy') as fe_pago,
                        tb010.tx_banco,
                        tb011.tx_cuenta_bancaria,
                        tb074.tx_forma_pago,
                        tb074.co_forma_pago,
                        tb063.nu_pago,
                        tb063.nu_monto,
                        tb060.co_ruta,
                        (select co_ruta from tb030_ruta where co_solicitud = $co_solicitud and in_actual = true) as ruta_actual                       
                from tb063_pago as tb063 left join tb074_forma_pago as tb074
                     on (tb063.co_forma_pago = tb074.co_forma_pago) left join 
                     tb011_cuenta_bancaria as tb011 
                     on (tb063.co_cuenta_bancaria = tb011.co_cuenta_bancaria)
                     left join tb010_banco as tb010 on (tb063.co_banco = tb010.co_banco)
                     left join tb062_liquidacion_pago as tb062 
                     on (tb063.co_liquidacion_pago = tb062.co_liquidacion_pago)
                     left join tb060_orden_pago as tb060 on (tb062.co_odp = tb060.co_orden_pago)
                where
                     tb063.in_anular is null and tb063.co_liquidacion_pago in (select tb062.co_liquidacion_pago from tb062_liquidacion_pago as tb062 where tb062.co_solicitud = $co_solicitud  order by co_liquidacion_pago)  order by co_pago";

         $stmt = $con->prepare($sql);

         $stmt->execute();

          while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if($row["co_ruta"]==''){
                $row["co_ruta"] = $row["ruta_actual"];
            }
            $registros[] = $row ;
          }        
         $this->registros = json_encode(array(
          "success"=> true,
          "total"  => count($registros),
          "data"   => $registros
          ));
              
        }         
        
    public function executeListaPagosUnificado(){


        $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
         $con = Propel::getConnection();

         $registros = '';
         $sql = "select tb063.co_pago, tb063.co_liquidacion_pago,                  
                        to_char(tb063.fe_pago,'dd/mm/yyyy') as fe_pago,
                        tb010.tx_banco,
                        tb011.tx_cuenta_bancaria,
                        tb074.tx_forma_pago,
                        tb063.nu_pago,
                        tb063.nu_monto,
                        tb060.co_ruta,
                        tb060.co_solicitud,
                        tb060.tx_serial,
                        (select co_ruta 
                          from tb030_ruta
                          where co_solicitud = tb062.co_solicitud  and in_actual = true) as ruta_actual                       
                from tb063_pago as tb063 left join tb074_forma_pago as tb074
                     on (tb063.co_forma_pago = tb074.co_forma_pago) left join 
                     tb011_cuenta_bancaria as tb011 
                     on (tb063.co_cuenta_bancaria = tb011.co_cuenta_bancaria)
                     left join tb010_banco as tb010 on (tb063.co_banco = tb010.co_banco)
                     left join tb062_liquidacion_pago as tb062 
                     on (tb063.co_liquidacion_pago = tb062.co_liquidacion_pago)
                     left join tb060_orden_pago as tb060 on (tb062.co_odp = tb060.co_orden_pago)
                where
                     tb063.co_liquidacion_pago in (select tb062.co_liquidacion_pago from tb062_liquidacion_pago as tb062 
                     join tb026_solicitud tb026 on (tb062.co_solicitud = tb026.co_solicitud) 
                     where tb026.co_tipo_solicitud = $co_tipo_solicitud  order by co_liquidacion_pago) and in_anulado is false order by co_pago desc
                     ";

         $stmt = $con->prepare($sql);

         $stmt->execute();

          while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if($row["co_ruta"]==''){
                $row["co_ruta"] = $row["ruta_actual"];
            }
            $registros[] = $row ;
          }        
         $this->registros = json_encode(array(
          "success"=> true,
          "total"  => count($registros),
          "data"   => $registros
          ));
              
        }          

                    //modelo fk tb026_solicitud.CO_SOLICITUD
    public function executeStorefkcosolicitud(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
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
                    //modelo fk tb027_tipo_solicitud.CO_TIPO_SOLICITUD
    public function executeStorefkcotiposolicitud(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb027TipoSolicitudPeer::doSelectStmt($c);
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
                    //modelo fk tb028_proceso.CO_PROCESO
    public function executeStorefkcoproceso(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb028ProcesoPeer::doSelectStmt($c);
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
                                //modelo fk tb031_estatus_ruta.CO_ESTATUS_RUTA
    public function executeStorefkcoestatusruta(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb031EstatusRutaPeer::doSelectStmt($c);
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
                                                                                            
      public function executeFormapago(sfWebRequest $request){
        $c = new Criteria();
	$c->add(Tb074FormaPagoPeer::IN_ACTIVO, TRUE);
        $stmt = Tb074FormaPagoPeer::doSelectStmt($c);
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

       public function executeBanco(){


        $c = new Criteria();
        $c->add(Tb010BancoPeer::IN_ENTE, TRUE);
        $stmt = Tb010BancoPeer::doSelectStmt($c);
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
     
public function executeCuenta(){
        
        $co_banco = $this->getRequestParameter("co_banco");
        $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");

        $c = new Criteria();
        $c->add(Tb011CuentaBancariaPeer::CO_BANCO, $co_banco);
        if($co_tipo_solicitud==14 || $co_tipo_solicitud ==38){
        $c->add(Tb011CuentaBancariaPeer::IN_FONDO_TERCERO, TRUE);
            
        }
        $c->addAscendingOrderByColumn(Tb011CuentaBancariaPeer::TX_CUENTA_BANCARIA);
        $stmt = Tb011CuentaBancariaPeer::doSelectStmt($c);
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
     
public function executeChequera(){
        
        $co_cuenta_bancaria = $this->getRequestParameter("co_cuenta_bancaria");

        $c = new Criteria();
        $c->add(Tb079ChequeraPeer::CO_CUENTA_BANCARIA, $co_cuenta_bancaria);
        $c->add(Tb079ChequeraPeer::CO_ESTADO_CHEQUERA,1);
        $stmt = Tb079ChequeraPeer::doSelectStmt($c);
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
     
public function executeCheque(){
        
        $co_chequera = $this->getRequestParameter("co_chequera");
        $cant_pagos = $this->getRequestParameter("cant_pagos");

        $c = new Criteria();
        $c->add(Tb077ChequePeer::CO_CHEQUERA, $co_chequera);
        $c->add(Tb077ChequePeer::CO_ESTADO_CHEQUE,1);
        $c->addAscendingOrderByColumn(Tb077ChequePeer::CO_CHEQUE);
        $c->setLimit($cant_pagos);
        $stmt = Tb077ChequePeer::doSelectStmt($c);
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
     
        public function executeStorefkcodocumento(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb007DocumentoPeer::doSelectStmt($c);
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
    
    public function executeStorefkcoliquidacionpago(sfWebRequest $request){
        
       $codigo = explode(',', $this->getRequestParameter('co_liquidacion_pago'));
       $c  = new Criteria();
       $c->addJoin(Tb062LiquidacionPagoPeer::CO_ODP, Tb060OrdenPagoPeer::CO_ORDEN_PAGO, Criteria::LEFT_JOIN);
       $c->add(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO,$codigo, Criteria::IN);
       $c->add(Tb060OrdenPagoPeer::IN_PAGADO,NULL, Criteria::ISNULL);
       $c->addOr(Tb060OrdenPagoPeer::IN_PAGADO,FALSE);
       $stmt = Tb062LiquidacionPagoPeer::doSelectStmt($c);
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
    
    public function executeStorelistaEmbargante(sfWebRequest $request){
        
       $co_solicitud = $this->getRequestParameter('co_solicitud');
       $nu_cedula = $this->getRequestParameter('nu_cedula');
       $nombre = $this->getRequestParameter('nombre');
       

       $c  = new Criteria();
       $c->addJoin(Tb161PagoFondoTerceroPeer::CO_PAGO_FONDO_TERCERO, Tb162ArchivoFondoTerceroPeer::CO_FONDO_TERCERO);
       if($nu_cedula!=''){
       $c->add(Tb162ArchivoFondoTerceroPeer::TX_CEDULA,'%'.$nu_cedula.'%', Criteria::ILIKE);    
       }
       
       if($nombre!=''){
       $c->add(Tb162ArchivoFondoTerceroPeer::NB_PERSONA,'%'.$nombre.'%', Criteria::ILIKE);    
       }
       
       $c->add(Tb161PagoFondoTerceroPeer::CO_SOLICITUD,$co_solicitud);
       $stmt = Tb162ArchivoFondoTerceroPeer::doSelectStmt($c);
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
    
  public function getTxRutaReporte($co_proceso, $co_solicitud)
  {


    $encrip = new myConfig();

    $cp = new Criteria();
    $cp->add(Tb030RutaPeer::CO_SOLICITUD, $co_solicitud);
    $cp->add(Tb030RutaPeer::CO_PROCESO, $co_proceso);
    $stmt = Tb030RutaPeer::doSelectStmt($cp);
    $campos = $stmt->fetch(PDO::FETCH_ASSOC);

    return $encrip->encrypt($campos["co_ruta"]);
  }
  
  public function getTxObservacion($co_solicitud)
  {
    $c = new Criteria();
    $c->add(Tb052ComprasPeer::CO_SOLICITUD, $co_solicitud);
    $stmt = Tb052ComprasPeer::doSelectStmt($c);
    $campos = $stmt->fetch(PDO::FETCH_ASSOC);

    return $campos["tx_observacion"];
  }  
     
}
