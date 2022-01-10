<?php

/**
 * autoProveedor actions.
 * NombreClaseModel(Tb008Proveedor)
 * NombreTabla(tb008_proveedor)
 * @package    ##PROJECT_NAME##
 * @subpackage autoProveedor
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class ProveedorActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Proveedor', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Proveedor', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }
  
  public function executeAgregarRamo(sfWebRequest $request)
  {

  }
  
  public function executeAgregarCuenta(sfWebRequest $request)
  {

  }
  public function executeAgregarRetencion(sfWebRequest $request)
  {

  }
  public function executeAgregarAporte(sfWebRequest $request)
  {

  }
  public function executeGuardarCambio(sfWebRequest $request)
  {
        $co_partida = $this->getRequestParameter("co_partida");
        $co_partida = $this->getRequestParameter("co_partida");
  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tb008ProveedorPeer::CO_PROVEEDOR,$codigo);

        $stmt = Tb008ProveedorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_proveedor"     => $campos["co_proveedor"],
                            "tx_razon_social"     => $campos["tx_razon_social"],
                            "tx_documento"     => $campos["tx_documento"],
                            "co_documento"  => $campos["co_documento"],
                            "tx_siglas"     => $campos["tx_siglas"],
                            "tx_rif"     => $campos["tx_rif"],
                            "tx_nit"     => $campos["tx_nit"],
                            "tx_direccion"     => $campos["tx_direccion"],
                            "co_estado"     => $campos["co_estado"],
                            "co_municipio"     => $campos["co_municipio"],
                            "co_clasificacion"     => $campos["co_clasificacion"],
                            "tx_email"     => $campos["tx_email"],
                            "tx_sitio_web"     => $campos["tx_sitio_web"],
                            "nb_representante_legal"     => $campos["nb_representante_legal"],
                            "nu_cedula_representante"     => $campos["nu_cedula_representante"],
                            "tx_num_celular"     => $campos["tx_num_celular"],
                            "nu_dia_credito"     => $campos["nu_dia_credito"],
                            "fe_registro"     => $campos["fe_registro"],
                            "co_cuenta_contable"     => $campos["co_cuenta_contable"],
                            "fe_vencimiento"     => $campos["fe_vencimiento"],
                            "nu_cuenta_bancaria"     => $campos["nu_cuenta_bancaria"],
                            "co_banco"     => $campos["co_banco"],
                            "co_tipo_residencia"     => $campos["co_tipo_residencia"],
                            "co_tipo_proveedor"     => $campos["co_tipo_proveedor"],
                            "co_tipo_retencion"     => $campos["co_tipo_retencion"],
                            "tx_registro"     => $campos["tx_registro"],
                            "fe_registro_seniat"     => $campos["fe_registro_seniat"],
                            "nu_registro"     => $campos["nu_registro"],
                            "nu_tomo"     => $campos["nu_tomo"],
                            "nu_capital_suscrito"     => $campos["nu_capital_suscrito"],
                            "nu_capital_pagado"     => $campos["nu_capital_pagado"],
                            "tx_observacion"     => $campos["tx_observacion"],
                            "co_iva_retencion"  => $campos["co_iva_retencion"]
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_proveedor"     => "",
                            "tx_razon_social"     => "",
                            "co_documento"     => "",
                            "tx_siglas"     => "",
                            "tx_rif"     => "",
                            "tx_nit"     => "",
                            "tx_direccion"     => "",
                            "co_estado"     => "",
                            "co_municipio"     => "",
                            "co_clasificacion"     => "",
                            "tx_email"     => "",
                            "tx_sitio_web"     => "",
                            "nb_representante_legal"     => "",
                            "nu_cedula_representante"     => "",
                            "tx_num_celular"     => "",
                            "nu_dia_credito"     => "",
                            "fe_registro"     => "",
                            "co_cuenta_contable"     => "",
                            "fe_vencimiento"     => "",
                            "nu_cuenta_bancaria"     => "",
                            "co_banco"     => "",
                            "co_tipo_residencia"     => "",
                            "co_tipo_proveedor"     => "",
                            "co_tipo_retencion"     => "",
                            "tx_registro"     => "",
                            "fe_registro_seniat"     => "",
                            "nu_registro"     => "",
                            "nu_tomo"     => "",
                            "nu_capital_suscrito"     => "",
                            "nu_capital_pagado"     => "",
                            "tx_observacion"     => "",
                            "co_iva_retencion"  => ""
                    ));
    }

  }
  
        public function executeDetalle(sfWebRequest $request)
    {

            $this->tab = "{
//                            title: 'Detalle del Tramite',
//                            tabWidth:120,
//                            autoLoad:{
//                            url:'".$_SERVER["SCRIPT_NAME"]."/Solicitud/detalleSolicitud',
//                            scripts: true,
//                            params:{codigo:this.OBJ.co_solicitud,
//                                    co_tipo_solicitud: this.OBJ.co_tipo_solicitud,
//                                    co_proceso: this.OBJ.co_proceso }
//                            }
                        }";

            $this->DatosDetalle();
    }
    
    
    public function executeDetalleExpediente(sfWebRequest $request)
    {
        $this->DatosDetalle();
    }
    
    public function DatosDetalle()
    {
        $codigo = $this->getRequestParameter("co_proveedor");
        if($codigo!=''||$codigo!=null){
            $c = new Criteria();
            $c->add(Tb008ProveedorPeer::CO_PROVEEDOR,$codigo);
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);   
            $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);   
            $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_SIGLAS);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_NIT);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_EMAIL);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_SITIO_WEB);
            $c->addSelectColumn(Tb008ProveedorPeer::FE_VENCIMIENTO);
            $c->addSelectColumn(Tb008ProveedorPeer::FE_REGISTRO);        
            $c->addSelectColumn(Tb035ClasificacionProveedorPeer::TX_CLASIFICACION);
            $c->addSelectColumn(Tb016EstadoPeer::NB_ESTADO);
            $c->addSelectColumn(Tb017MunicipioPeer::NB_MUNICIPIO);
            $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION); 
            $c->addSelectColumn(Tb008ProveedorPeer::NB_REPRESENTANTE_LEGAL); 
            $c->addSelectColumn(Tb008ProveedorPeer::NU_CEDULA_REPRESENTANTE); 
            $c->addSelectColumn(Tb008ProveedorPeer::TX_NUM_CELULAR); 
            $c->addSelectColumn(Tb008ProveedorPeer::NU_CUENTA_BANCARIA); 

            $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
            $c->addJoin(Tb008ProveedorPeer::CO_ESTADO, Tb016EstadoPeer::CO_ESTADO);
            $c->addJoin(Tb008ProveedorPeer::CO_MUNICIPIO, Tb017MunicipioPeer::CO_MUNICIPIO);
            $c->addJoin(Tb008ProveedorPeer::CO_CLASIFICACION, Tb035ClasificacionProveedorPeer::CO_CLASIFICACION);                 
            $stmt = Tb008ProveedorPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->data = json_encode(array(
                                "co_proveedor"     => $campos["co_proveedor"],
                                "tx_razon_social"     => $campos["tx_razon_social"],
                                "tx_documento"     => $campos["inicial"],
                                "tx_siglas"     => $campos["tx_siglas"],
                                "tx_rif"     => $campos["tx_rif"],
                                "tx_nit"     => $campos["tx_nit"],
                                "tx_direccion"     => $campos["tx_direccion"],
                                "nb_estado"     => $campos["nb_estado"],
                                "nb_municipio"     => $campos["nb_municipio"],
                                "tx_clasificacion"     => $campos["tx_clasificacion"],
                                "tx_email"     => $campos["tx_email"],
                                "tx_sitio_web"     => $campos["tx_sitio_web"],
                                "nb_representante_legal"     => $campos["nb_representante_legal"],
                                "nu_cedula_representante"     => $campos["nu_cedula_representante"],
                                "tx_num_celular"     => $campos["tx_num_celular"],
                                "fe_registro"     => $campos["fe_registro"],
                                "fe_vencimiento"     => $campos["fe_vencimiento"],
                                "nu_cuenta_bancaria"     => $campos["nu_cuenta_bancaria"],
                                "co_banco"     => $campos["co_banco"],
                                "co_tipo_residencia"     => $campos["co_tipo_residencia"],
                                "co_tipo_proveedor"     => $campos["co_tipo_proveedor"],
                                "co_tipo_retencion"     => $campos["co_tipo_retencion"],
                                "tx_registro"     => $campos["tx_registro"],
                                "fe_registro_seniat"     => $campos["fe_registro_seniat"],
                                "nu_registro"     => $campos["nu_registro"],
                                "nu_tomo"     => $campos["nu_tomo"],
                                "nu_capital_suscrito"     => $campos["nu_capital_suscrito"],
                                "nu_capital_pagado"     => $campos["nu_capital_pagado"],
                                "tx_observacion"     => $campos["tx_observacion"],
                                "co_iva_retencion"  => $campos["co_iva_retencion"],
                                "nu_cuenta_bancaria"    =>  $campos["nu_cuenta_bancaria"]
                        ));
        }

  }
  
  protected function getValidarCampo($valor){
      
      if($valor!=''){
          return $valor;
      }else{
         return null; 
      }
      
      
      
  }

  public function executeGuardar(sfWebRequest $request)
  {
     $json_ramo             = $this->getRequestParameter("json_ramo");
     $json_cuenta           = $this->getRequestParameter("json_cuenta");
     $json_retenciones      = $this->getRequestParameter("json_retenciones");
     $json_aporte_patronal  = $this->getRequestParameter("json_aporte_patronal");
     
     $codigo = $this->getRequestParameter("co_proveedor");
     
     $tb008_proveedorForm = $this->getRequestParameter('tb008_proveedor');
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb008_proveedor = Tb008ProveedorPeer::retrieveByPk($codigo);
     }else{
                 
        $c = new Criteria();
        $c->add(Tb008ProveedorPeer::TX_RIF,$tb008_proveedorForm["tx_rif"]);
        $cant = Tb008ProveedorPeer::doCount($c);
        
        if($cant>0){
            
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  'El RIF ingresado ya se encuentra registrado'
            ));
            
            return;
            
        }
        
        $tb008_proveedor = new Tb008Proveedor();
         
     }
     try
      { 
        $con->beginTransaction();
        
        $tb008_proveedor->setTxRazonSocial($tb008_proveedorForm["tx_razon_social"]);
        $tb008_proveedor->setCoDocumento($tb008_proveedorForm["co_documento"]);
        $tb008_proveedor->setTxSiglas($tb008_proveedorForm["tx_siglas"]);
        $tb008_proveedor->setTxRif($tb008_proveedorForm["tx_rif"]);
        $tb008_proveedor->setTxNit($tb008_proveedorForm["tx_nit"]);
        $tb008_proveedor->setTxDireccion($tb008_proveedorForm["tx_direccion"]);
        $tb008_proveedor->setCoEstado($tb008_proveedorForm["co_estado"]);
        $tb008_proveedor->setCoMunicipio($tb008_proveedorForm["co_municipio"]);
        $tb008_proveedor->setCoClasificacion($tb008_proveedorForm["co_clasificacion"]);
        $tb008_proveedor->setTxEmail($tb008_proveedorForm["tx_email"]);
        $tb008_proveedor->setTxSitioWeb($tb008_proveedorForm["tx_sitio_web"]);
        $tb008_proveedor->setCoIvaRetencion($tb008_proveedorForm["co_iva_retencion"]);

        $tb008_proveedor->setNbRepresentanteLegal($tb008_proveedorForm["nb_representante_legal"]);
               
        $tb008_proveedor->setNuCedulaRepresentante($this->getValidarCampo($tb008_proveedorForm["nu_cedula_representante"]));
        
        $tb008_proveedor->setTxNumCelular($tb008_proveedorForm["tx_num_celular"]);
        
        if($tb008_proveedorForm["nu_dia_credito"]!='')
        $tb008_proveedor->setNuDiaCredito($tb008_proveedorForm["nu_dia_credito"]);
                                                                
        /*Campo tipo DATE */
        if($tb008_proveedorForm["fe_registro"]!=''){
            list($dia, $mes, $anio) = explode("/",$tb008_proveedorForm["fe_registro"]);
            $fecha = $anio."-".$mes."-".$dia;
            $tb008_proveedor->setFeRegistro($fecha);
        }else{
            $tb008_proveedor->setFeRegistro(NULL);
        }
                                                        
        /*Campo tipo BIGINT */
       
        $tb008_proveedor->setCoCuentaContable($this->getValidarCampo($tb008_proveedorForm["co_cuenta_contable"]));
                                                                
        /*Campo tipo DATE */
        if($tb008_proveedorForm["fe_vencimiento"]!=''){
            list($dia, $mes, $anio) = explode("/",$tb008_proveedorForm["fe_vencimiento"]);
            $fecha = $anio."-".$mes."-".$dia;
            $tb008_proveedor->setFeVencimiento($fecha);
        }else{
            $tb008_proveedor->setFeVencimiento(null);
        }                                     
        
        /*Campo tipo VARCHAR */
       
        $tb008_proveedor->setNuCuentaBancaria($this->getValidarCampo($tb008_proveedorForm["nu_cuenta_bancaria"]));
                                                        
        /*Campo tipo BIGINT */
        $tb008_proveedor->setCoBanco($this->getValidarCampo($tb008_proveedorForm["co_banco"]));
                                                        
        /*Campo tipo BIGINT */
        $tb008_proveedor->setCoTipoResidencia($this->getValidarCampo($tb008_proveedorForm["co_tipo_residencia"]));
                                                        
        /*Campo tipo BIGINT */
        $tb008_proveedor->setCoTipoProveedor($this->getValidarCampo($tb008_proveedorForm["co_tipo_proveedor"]));
                                                         
                                                            
        /*Campo tipo VARCHAR */
        $tb008_proveedor->setTxRegistro($tb008_proveedorForm["tx_registro"]);
                                                                
        /*Campo tipo DATE */
        if($tb008_proveedorForm["fe_registro_seniat"]!=''){
            list($dia, $mes, $anio) = explode("/",$tb008_proveedorForm["fe_registro_seniat"]);
            $fecha = $anio."-".$mes."-".$dia;
            $tb008_proveedor->setFeRegistroSeniat($fecha);
        }else{
            $tb008_proveedor->setFeRegistroSeniat(null);
        }
                                                        
        /*Campo tipo NUMERIC */
        $tb008_proveedor->setNuRegistro($this->getValidarCampo($tb008_proveedorForm["nu_registro"]));
                                                        
        /*Campo tipo NUMERIC */
        $tb008_proveedor->setNuTomo($this->getValidarCampo($tb008_proveedorForm["nu_tomo"]));
                                                        
        /*Campo tipo NUMERIC */
        $tb008_proveedor->setNuCapitalSuscrito($this->getValidarCampo($tb008_proveedorForm["nu_capital_suscrito"]));
                                                        
        /*Campo tipo NUMERIC */
        $tb008_proveedor->setNuCapitalPagado($this->getValidarCampo($tb008_proveedorForm["nu_capital_pagado"]));
                                                        
        /*Campo tipo VARCHAR */
        $tb008_proveedor->setTxObservacion($tb008_proveedorForm["tx_observacion"]);
        
        $listaRamo  = json_decode($json_ramo,true);
        $array_ramo = array();
        $i=0;
        foreach($listaRamo  as $ramoForm){
          
                if($ramoForm["co_proveedor_ramo"]==''){
                    
                    $tb040_proveedor_ramo = new Tb040ProveedorRamo();
                    $tb040_proveedor_ramo->setCoProveedor($tb008_proveedor->getCoProveedor())
                                        ->setCoRamo($ramoForm["co_ramo"])
                                        ->save($con);
                    
                }
            
        }
        
        $listaCuenta  = json_decode($json_cuenta,true);
        $array_cuenta = array();
        $i=0;
        foreach($listaCuenta  as $cuentaForm){
          
            if($cuentaForm["co_cuenta_proveedor"]==''){

                $tb065_cuenta_proveedor = new Tb065CuentaProveedor();
                $tb065_cuenta_proveedor->setCoProveedor($tb008_proveedor->getCoProveedor())
                                    ->setCoBanco($cuentaForm["co_banco"])
                                    ->setTxCuenta($cuentaForm["tx_cuenta"])
                                 //   ->setCoCuentaContable($cuentaForm["co_cuenta_contable"])
                                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                    ->save($con);

            }
            
        }
        
        $listaRetenciones  = json_decode($json_retenciones,true);
        foreach($listaRetenciones  as $retencionesForm){
          
            if($retencionesForm["co_retencion_proveedor"]==''){

                $tb071_retencion_proveedor = new Tb071RetencionProveedor();
                $tb071_retencion_proveedor->setCoTipoRetencion($retencionesForm["co_tipo_retencion"])
                                    ->setCoProveedor($tb008_proveedor->getCoProveedor())
                                    ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                    ->save($con);

            }
            
        }        
        
        $listaAportePatronal  = json_decode($json_aporte_patronal,true);
        foreach($listaAportePatronal  as $aportePatronalForm){
          
                if($aportePatronalForm["co_proveedor"]==''){
                    
                    $tb158_proveedor_aporte = new Tb158ProveedorAporte();
                    $tb158_proveedor_aporte->setCoProveedor($tb008_proveedor->getCoProveedor())
                                           ->setCoAporte($aportePatronalForm["co_aporte_patronal"])
                                           ->save($con);
                    
                }
            
        }
        
        
        
                                
        /*CAMPOS*/
        $tb008_proveedor->save($con);
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
  
    
    public function executeEliminarRetencion(sfWebRequest $request){
      
        $codigo = $this->getRequestParameter("co_retencion_proveedor");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
            /*CAMPOS*/
            $Tb071RetencionProveedor = Tb071RetencionProveedorPeer::retrieveByPk($codigo);			
            $Tb071RetencionProveedor->delete($con);
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
        
         $this->setTemplate('eliminar');
      
  }  
    
  public function executeEliminarRamo(sfWebRequest $request){
      
        $codigo = $this->getRequestParameter("co_proveedor_ramo");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
            /*CAMPOS*/
            $tb040ProveedorRamo = Tb040ProveedorRamoPeer::retrieveByPk($codigo);			
            $tb040ProveedorRamo->delete($con);
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
        
         $this->setTemplate('eliminar');
      
  }  
  
  public function executeEliminarCuentaProveedor(sfWebRequest $request){
      
        $codigo = $this->getRequestParameter("co_cuenta_proveedor");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
            /*CAMPOS*/
            $Tb065CuentaProveedorPeer = Tb065CuentaProveedorPeer::retrieveByPk($codigo);			
            $Tb065CuentaProveedorPeer->delete($con);
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
        
         $this->setTemplate('eliminar');
      
  }  
  
  public function executeEliminarAportePatronal(sfWebRequest $request){

        $co_proveedor = $this->getRequestParameter("co_proveedor");
        $co_aporte_patronal = $this->getRequestParameter("co_aporte_patronal");
      
	$con = Propel::getConnection();
	try
	{ 
            $con->beginTransaction();
            /*CAMPOS*/
            $wherec = new Criteria();
            $wherec->add(Tb158ProveedorAportePeer::CO_APORTE, $co_aporte_patronal);
            $wherec->add(Tb158ProveedorAportePeer::CO_PROVEEDOR, $co_proveedor);
            BasePeer::doDelete($wherec, $con);
            
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
        
         $this->setTemplate('eliminar');
      
  }  

  

  public function executeEliminar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_proveedor");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb008_proveedor = Tb008ProveedorPeer::retrieveByPk($codigo);			
	$tb008_proveedor->delete($con);
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
  
  public function executeConsulta(sfWebRequest $request)
  {

  }
  
  public function executeConsultaExpediente(sfWebRequest $request)
  {

  }
  
  
  public function executeStorelistaCuentaBancaria(sfWebRequest $request)
  {
    $c = new Criteria();   
    $c->setIgnoreCase(true);
   
    $c->add(Tb065CuentaProveedorPeer::CO_PROVEEDOR,$this->getRequestParameter("co_proveedor"));
    $cantidadTotal = Tb065CuentaProveedorPeer::doCount($c);
    
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb065CuentaProveedorPeer::CO_CUENTA_PROVEEDOR);
    $c->addSelectColumn(Tb065CuentaProveedorPeer::CO_BANCO);
    $c->addSelectColumn(Tb065CuentaProveedorPeer::CO_CUENTA_CONTABLE);
    $c->addSelectColumn(Tb065CuentaProveedorPeer::TX_CUENTA);    
    $c->addSelectColumn(Tb010BancoPeer::TX_BANCO);
    $c->addSelectColumn(Tb024CuentaContablePeer::NU_CUENTA_CONTABLE);    
    
    $c->addJoin(Tb010BancoPeer::CO_BANCO, Tb065CuentaProveedorPeer::CO_BANCO);
    $c->addJoin(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Tb065CuentaProveedorPeer::CO_CUENTA_CONTABLE);
       
    $c->addAscendingOrderByColumn(Tb010BancoPeer::TX_BANCO);
        
    $stmt = Tb065CuentaProveedorPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = $res;
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    
     $this->setTemplate('storelista');
  }
  
  public function executeStorelistaRetencion(sfWebRequest $request)
  {
    $c = new Criteria();   
    $c->setIgnoreCase(true);
   
    $c->add(Tb071RetencionProveedorPeer::CO_PROVEEDOR,$this->getRequestParameter("co_proveedor"));
    $cantidadTotal = Tb071RetencionProveedorPeer::doCount($c);
    
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb071RetencionProveedorPeer::CO_RETENCION_PROVEEDOR);
    $c->addSelectColumn(Tb041TipoRetencionPeer::CO_TIPO_RETENCION);  
    $c->addSelectColumn(Tb041TipoRetencionPeer::TX_TIPO_RETENCION);  
    
    $c->addJoin(Tb071RetencionProveedorPeer::CO_TIPO_RETENCION, Tb041TipoRetencionPeer::CO_TIPO_RETENCION);

    $c->addAscendingOrderByColumn(Tb071RetencionProveedorPeer::CO_RETENCION_PROVEEDOR);
        
    $stmt = Tb071RetencionProveedorPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = $res;
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    
     $this->setTemplate('storelista');
  }
  
  public function executeStorelistaRamo(sfWebRequest $request)
  {   
    
    $c = new Criteria();   
    $c->setIgnoreCase(true);
   
    $c->add(Tb040ProveedorRamoPeer::CO_PROVEEDOR,$this->getRequestParameter("co_proveedor"));
    $cantidadTotal = Tb008ProveedorPeer::doCount($c);
    
    $c->addSelectColumn(Tb040ProveedorRamoPeer::CO_PROVEEDOR_RAMO);
    $c->addSelectColumn(Tb040ProveedorRamoPeer::CO_RAMO);
    $c->addSelectColumn(Tb038RamoPeer::TX_RAMO);    
    
    $c->addJoin(Tb040ProveedorRamoPeer::CO_RAMO, Tb038RamoPeer::CO_RAMO);
    
   
    $c->addAscendingOrderByColumn(Tb038RamoPeer::TX_RAMO);
        
    $stmt = Tb008ProveedorPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_proveedor_ramo"=> trim($res["co_proveedor_ramo"]),
            "co_ramo"     => trim($res["co_ramo"]),
            "tx_ramo"          => trim($res["tx_ramo"])
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    
     $this->setTemplate('storelista');
  }
  
  public function executeStorelistaExpediente(sfWebRequest $request)
  {   
    $co_proveedor      = $this->getRequestParameter("co_proveedor");
    $co_solicitud      = $this->getRequestParameter("co_solicitud");
    $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
    $fecha_inicio      = $this->getRequestParameter("fecha_inicio");
    $fecha_fin         = $this->getRequestParameter("fecha_fin");
    
    $limit      =   $this->getRequestParameter("limit",15);
    $start      =   $this->getRequestParameter("start",0);  
       
    $c = new Criteria();   
    $c->setIgnoreCase(true);
   
    if($co_solicitud!=''){
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD,$co_solicitud);
    }   
   
    if($co_tipo_solicitud!=''){
        $c->add(Tb026SolicitudPeer::CO_TIPO_SOLICITUD,$co_tipo_solicitud);
    }
    
    if($fecha_inicio!=''){
        list($dia,$mes,$anio) = explode("/",$fecha_inicio);
        $fe_inicio = $anio.'-'.$mes.'-'.$dia;
        $c->addAnd(Tb026SolicitudPeer::CREATED_AT,$fe_inicio,Criteria::GREATER_EQUAL);
    }
    
    if($fecha_fin!=''){
        list($dia,$mes,$anio) = explode("/",$fecha_fin);
        $fe_fin = $anio.'-'.$mes.'-'.$dia;
        $c->addAnd(Tb026SolicitudPeer::CREATED_AT,$fe_fin,Criteria::LESS_EQUAL);
    }
    
    
    $c->add(Tb026SolicitudPeer::CO_PROVEEDOR,$co_proveedor);
    
    $cantidadTotal = Tb026SolicitudPeer::doCount($c);
    
    $c->addSelectColumn(Tb026SolicitudPeer::CO_PROVEEDOR);
    $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
    $c->addSelectColumn(Tb026SolicitudPeer::CREATED_AT);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);    
    $c->setLimit($limit)->setOffset($start);
    $c->addJoin(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD,  Tb026SolicitudPeer::CO_TIPO_SOLICITUD);
       
    $c->addDescendingOrderByColumn(Tb026SolicitudPeer::CO_SOLICITUD);
        
    $stmt = Tb026SolicitudPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        list($anio,$mes,$dia) = explode("-", $res["created_at"]);
        $fecha = $dia.'-'.$mes.'-'.$anio;
        
        $registros[] = array(
            "co_proveedor"      => trim($res["co_proveedor"]),
            "co_solicitud"      => trim($res["co_solicitud"]),
            "fe_solicitud"      => trim($fecha),
            "tx_tipo_solicitud" => trim($res["tx_tipo_solicitud"])
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    
     $this->setTemplate('storelista');
  }
    
   

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",15);
    $start      =   $this->getRequestParameter("start",0);  
    
    $co_documento    =   $this->getRequestParameter("co_documento");
    $tx_rif    =   $this->getRequestParameter("tx_rif");
    $tx_razon_social    =   $this->getRequestParameter("tx_razon_social");
    
    $c = new Criteria();   
    
    if($co_documento!=''){
        $c->add(Tb008ProveedorPeer::CO_DOCUMENTO,$co_documento);
    }
    
    if($tx_rif!=''){
        $c->add(Tb008ProveedorPeer::TX_RIF,$tx_rif);
    }
    
    if($tx_razon_social!=''){
        $c->add(Tb008ProveedorPeer::TX_RAZON_SOCIAL,'%'.$tx_razon_social.'%', Criteria::LIKE);
    }
    
    
    
    
    
    $c->setIgnoreCase(true);
   
    $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
    $c->addSelectColumn(Tb007DocumentoPeer::CO_DOCUMENTO);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_SIGLAS);
    $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);    
    
    $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
   
    $c->addAscendingOrderByColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        
    $cantidadTotal = Tb008ProveedorPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $stmt = Tb008ProveedorPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_proveedor"     => trim($res["co_proveedor"]),
            "tx_razon_social"     => trim($res["tx_razon_social"]),
            "co_documento"     => trim($res["co_documento"]),
            "tx_siglas"     => trim($res["tx_siglas"]),
            "tx_rif"     => trim($res["inicial"].'-'.$res["tx_rif"])
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                //modelo fk tb007_documento.CO_DOCUMENTO
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
    
    public function executeStorefkcoestado(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb016EstadoPeer::doSelectStmt($c);
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
    
    public function executeStorefkcomunicipio(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb017MunicipioPeer::CO_ESTADO,$this->getRequestParameter("co_estado"));
        $stmt = Tb017MunicipioPeer::doSelectStmt($c);
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
    
     public function executeStorefkcoramo(sfWebRequest $request){
         
        $json_ramo  = $this->getRequestParameter("lista_ramo");
        
        $listaRamo  = json_decode($json_ramo,true);
        $array_ramo = array();
        $i=0;
        foreach($listaRamo  as $ramoForm){
           $array_ramo[$i] = $ramoForm["co_ramo"]; 
           $i++;
        }
         
        $c = new Criteria();
        $c->add(Tb038RamoPeer::CO_RAMO,$array_ramo,  Criteria::NOT_IN);
        $stmt = Tb038RamoPeer::doSelectStmt($c);
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
                                                                                            //modelo fk tb035_clasificacion_proveedor.CO_CLASIFICACION
    public function executeStorefkcoclasificacion(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb035ClasificacionProveedorPeer::doSelectStmt($c);
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
        $c->add(Tb024CuentaContablePeer::NU_NIVEL,6);
        $c->add(Tb024CuentaContablePeer::TX_TIPO,'S');
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
                                            //modelo fk tb010_banco.CO_BANCO
    public function executeStorefkcobanco(sfWebRequest $request){
        $c = new Criteria();
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
                    //modelo fk tb036_tipo_residencia.CO_TIPO_RESIDENCIA
    public function executeStorefkcotiporesidencia(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb036TipoResidenciaPeer::doSelectStmt($c);
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
                    //modelo fk tb037_tipo_proveedor.CO_TIPO_PROVEEDOR
    public function executeStorefkcotipoproveedor(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb037TipoProveedorPeer::doSelectStmt($c);
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
                    //modelo fk tb038_tipo_retencion.CO_TIPO_RETENCION
    public function executeStorefkcotiporetencion(sfWebRequest $request){
        $json_tipo_retencion  = $this->getRequestParameter("json_tipo_retencion");
        $co_clase_retencion  = $this->getRequestParameter("co_clase_retencion");
        $listaTipoRetencion  = json_decode($json_tipo_retencion,true);
        $array_tipo_retencion = array();
        $i=0;
        foreach($listaTipoRetencion  as $tipo_retencionForm){
           $array_tipo_retencion[$i] = $tipo_retencionForm["co_tipo_retencion"]; 
           $i++;
        }
        $c = new Criteria();
        $c->add(Tb041TipoRetencionPeer::CO_TIPO_RETENCION,$array_tipo_retencion,  Criteria::NOT_IN);
        $c->add(Tb041TipoRetencionPeer::CO_CLASE_RETENCION,$co_clase_retencion);
        $c->addAscendingOrderByColumn(Tb041TipoRetencionPeer::CO_TIPO_RETENCION);
        $stmt = Tb041TipoRetencionPeer::doSelectStmt($c);
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
    
    public function executeStorelistaAportePatronal(sfWebRequest $request){
        $json_aporte  = $this->getRequestParameter("json_aporte");
        $co_proveedor  = $this->getRequestParameter("co_proveedor");
        $listaAporte  = json_decode($json_aporte,true);
        $array_aporte_patronal = array();
        $i=0;
        foreach($listaAporte  as $listaAporteForm){
           $array_aporte_patronal[$i] = $listaAporteForm["co_aporte_patronal"]; 
           $i++;
        }
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb157AportePatronalPeer::TX_DESCRIPCION);
        $c->addSelectColumn(Tb157AportePatronalPeer::CO_APORTE_PATRONAL);
        $c->addSelectColumn(Tb158ProveedorAportePeer::CO_PROVEEDOR);
        $c->addJoin(Tb157AportePatronalPeer::CO_APORTE_PATRONAL, Tb158ProveedorAportePeer::CO_APORTE);
        $c->add(Tb158ProveedorAportePeer::CO_APORTE,$array_aporte_patronal,  Criteria::NOT_IN);
        $c->add(Tb158ProveedorAportePeer::CO_PROVEEDOR,$co_proveedor);
        $c->addAscendingOrderByColumn(Tb158ProveedorAportePeer::CO_APORTE);
        $stmt = Tb158ProveedorAportePeer::doSelectStmt($c);
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
    
    public function executeStorefkcoivaretencion(sfWebRequest $request){
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb044IvaRetencionPeer::NU_VALOR);
        $stmt = Tb044IvaRetencionPeer::doSelectStmt($c);
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
                                                                                            
    public function executeStorefkcoclaseretencion(sfWebRequest $request){
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb072ClaseRetencionPeer::CO_CLASE_RETENCION);
        $stmt = Tb072ClaseRetencionPeer::doSelectStmt($c);
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

    
     public function executeStorefkcoaportesocial(sfWebRequest $request){
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb157AportePatronalPeer::TX_MOVIMIENTO);
        $stmt = Tb157AportePatronalPeer::doSelectStmt($c);
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