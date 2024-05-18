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
class autoProveedorActions extends sfActions
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
                            "co_documento"     => $campos["co_documento"],
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
                            "co_iva_retencion"     => $campos["co_iva_retencion"],
                            "tx_cuenta_contable"     => $campos["tx_cuenta_contable"],
                            "nu_codigo"     => $campos["nu_codigo"],
                            "in_rrhh"     => $campos["in_rrhh"],
                            "co_cuenta_orden_pasivo"     => $campos["co_cuenta_orden_pasivo"],
                            "co_cuenta_orden_activo"     => $campos["co_cuenta_orden_activo"],
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
                            "co_iva_retencion"     => "",
                            "tx_cuenta_contable"     => "",
                            "nu_codigo"     => "",
                            "in_rrhh"     => "",
                            "co_cuenta_orden_pasivo"     => "",
                            "co_cuenta_orden_activo"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_proveedor");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb008_proveedor = Tb008ProveedorPeer::retrieveByPk($codigo);
     }else{
         $tb008_proveedor = new Tb008Proveedor();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb008_proveedorForm = $this->getRequestParameter('tb008_proveedor');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb008_proveedor->setTxRazonSocial($tb008_proveedorForm["tx_razon_social"]);
                                                        
        /*Campo tipo BIGINT */
        $tb008_proveedor->setCoDocumento($tb008_proveedorForm["co_documento"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb008_proveedor->setTxSiglas($tb008_proveedorForm["tx_siglas"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb008_proveedor->setTxRif($tb008_proveedorForm["tx_rif"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb008_proveedor->setTxNit($tb008_proveedorForm["tx_nit"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb008_proveedor->setTxDireccion($tb008_proveedorForm["tx_direccion"]);
                                                        
        /*Campo tipo BIGINT */
        $tb008_proveedor->setCoEstado($tb008_proveedorForm["co_estado"]);
                                                        
        /*Campo tipo BIGINT */
        $tb008_proveedor->setCoMunicipio($tb008_proveedorForm["co_municipio"]);
                                                        
        /*Campo tipo BIGINT */
        $tb008_proveedor->setCoClasificacion($tb008_proveedorForm["co_clasificacion"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb008_proveedor->setTxEmail($tb008_proveedorForm["tx_email"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb008_proveedor->setTxSitioWeb($tb008_proveedorForm["tx_sitio_web"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb008_proveedor->setNbRepresentanteLegal($tb008_proveedorForm["nb_representante_legal"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb008_proveedor->setNuCedulaRepresentante($tb008_proveedorForm["nu_cedula_representante"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb008_proveedor->setTxNumCelular($tb008_proveedorForm["tx_num_celular"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb008_proveedor->setNuDiaCredito($tb008_proveedorForm["nu_dia_credito"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb008_proveedorForm["fe_registro"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb008_proveedor->setFeRegistro($fecha);
                                                        
        /*Campo tipo BIGINT */
        $tb008_proveedor->setCoCuentaContable($tb008_proveedorForm["co_cuenta_contable"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb008_proveedorForm["fe_vencimiento"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb008_proveedor->setFeVencimiento($fecha);
                                                        
        /*Campo tipo VARCHAR */
        $tb008_proveedor->setNuCuentaBancaria($tb008_proveedorForm["nu_cuenta_bancaria"]);
                                                        
        /*Campo tipo BIGINT */
        $tb008_proveedor->setCoBanco($tb008_proveedorForm["co_banco"]);
                                                        
        /*Campo tipo BIGINT */
        $tb008_proveedor->setCoTipoResidencia($tb008_proveedorForm["co_tipo_residencia"]);
                                                        
        /*Campo tipo BIGINT */
        $tb008_proveedor->setCoTipoProveedor($tb008_proveedorForm["co_tipo_proveedor"]);
                                                        
        /*Campo tipo BIGINT */
        $tb008_proveedor->setCoTipoRetencion($tb008_proveedorForm["co_tipo_retencion"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb008_proveedor->setTxRegistro($tb008_proveedorForm["tx_registro"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb008_proveedorForm["fe_registro_seniat"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb008_proveedor->setFeRegistroSeniat($fecha);
                                                        
        /*Campo tipo NUMERIC */
        $tb008_proveedor->setNuRegistro($tb008_proveedorForm["nu_registro"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb008_proveedor->setNuTomo($tb008_proveedorForm["nu_tomo"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb008_proveedor->setNuCapitalSuscrito($tb008_proveedorForm["nu_capital_suscrito"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb008_proveedor->setNuCapitalPagado($tb008_proveedorForm["nu_capital_pagado"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb008_proveedor->setTxObservacion($tb008_proveedorForm["tx_observacion"]);
                                                        
        /*Campo tipo BIGINT */
        $tb008_proveedor->setCoIvaRetencion($tb008_proveedorForm["co_iva_retencion"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb008_proveedor->setTxCuentaContable($tb008_proveedorForm["tx_cuenta_contable"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb008_proveedor->setNuCodigo($tb008_proveedorForm["nu_codigo"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_rrhh", $tb008_proveedorForm)){
            $tb008_proveedor->setInRrhh(false);
        }else{
            $tb008_proveedor->setInRrhh(true);
        }
                                                        
        /*Campo tipo BIGINT */
        $tb008_proveedor->setCoCuentaOrdenPasivo($tb008_proveedorForm["co_cuenta_orden_pasivo"]);
                                                        
        /*Campo tipo BIGINT */
        $tb008_proveedor->setCoCuentaOrdenActivo($tb008_proveedorForm["co_cuenta_orden_activo"]);
                                
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

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $tx_razon_social      =   $this->getRequestParameter("tx_razon_social");
            $co_documento      =   $this->getRequestParameter("co_documento");
            $tx_siglas      =   $this->getRequestParameter("tx_siglas");
            $tx_rif      =   $this->getRequestParameter("tx_rif");
            $tx_nit      =   $this->getRequestParameter("tx_nit");
            $tx_direccion      =   $this->getRequestParameter("tx_direccion");
            $co_estado      =   $this->getRequestParameter("co_estado");
            $co_municipio      =   $this->getRequestParameter("co_municipio");
            $co_clasificacion      =   $this->getRequestParameter("co_clasificacion");
            $tx_email      =   $this->getRequestParameter("tx_email");
            $tx_sitio_web      =   $this->getRequestParameter("tx_sitio_web");
            $nb_representante_legal      =   $this->getRequestParameter("nb_representante_legal");
            $nu_cedula_representante      =   $this->getRequestParameter("nu_cedula_representante");
            $tx_num_celular      =   $this->getRequestParameter("tx_num_celular");
            $nu_dia_credito      =   $this->getRequestParameter("nu_dia_credito");
            $fe_registro      =   $this->getRequestParameter("fe_registro");
            $co_cuenta_contable      =   $this->getRequestParameter("co_cuenta_contable");
            $fe_vencimiento      =   $this->getRequestParameter("fe_vencimiento");
            $nu_cuenta_bancaria      =   $this->getRequestParameter("nu_cuenta_bancaria");
            $co_banco      =   $this->getRequestParameter("co_banco");
            $co_tipo_residencia      =   $this->getRequestParameter("co_tipo_residencia");
            $co_tipo_proveedor      =   $this->getRequestParameter("co_tipo_proveedor");
            $co_tipo_retencion      =   $this->getRequestParameter("co_tipo_retencion");
            $tx_registro      =   $this->getRequestParameter("tx_registro");
            $fe_registro_seniat      =   $this->getRequestParameter("fe_registro_seniat");
            $nu_registro      =   $this->getRequestParameter("nu_registro");
            $nu_tomo      =   $this->getRequestParameter("nu_tomo");
            $nu_capital_suscrito      =   $this->getRequestParameter("nu_capital_suscrito");
            $nu_capital_pagado      =   $this->getRequestParameter("nu_capital_pagado");
            $tx_observacion      =   $this->getRequestParameter("tx_observacion");
            $co_iva_retencion      =   $this->getRequestParameter("co_iva_retencion");
            $tx_cuenta_contable      =   $this->getRequestParameter("tx_cuenta_contable");
            $nu_codigo      =   $this->getRequestParameter("nu_codigo");
            $in_rrhh      =   $this->getRequestParameter("in_rrhh");
            $co_cuenta_orden_pasivo      =   $this->getRequestParameter("co_cuenta_orden_pasivo");
            $co_cuenta_orden_activo      =   $this->getRequestParameter("co_cuenta_orden_activo");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_razon_social!=""){$c->add(Tb008ProveedorPeer::tx_razon_social,'%'.$tx_razon_social.'%',Criteria::LIKE);}
        
                                            if($co_documento!=""){$c->add(Tb008ProveedorPeer::co_documento,$co_documento);}
    
                                        if($tx_siglas!=""){$c->add(Tb008ProveedorPeer::tx_siglas,'%'.$tx_siglas.'%',Criteria::LIKE);}
        
                                        if($tx_rif!=""){$c->add(Tb008ProveedorPeer::tx_rif,'%'.$tx_rif.'%',Criteria::LIKE);}
        
                                        if($tx_nit!=""){$c->add(Tb008ProveedorPeer::tx_nit,'%'.$tx_nit.'%',Criteria::LIKE);}
        
                                        if($tx_direccion!=""){$c->add(Tb008ProveedorPeer::tx_direccion,'%'.$tx_direccion.'%',Criteria::LIKE);}
        
                                            if($co_estado!=""){$c->add(Tb008ProveedorPeer::co_estado,$co_estado);}
    
                                            if($co_municipio!=""){$c->add(Tb008ProveedorPeer::co_municipio,$co_municipio);}
    
                                            if($co_clasificacion!=""){$c->add(Tb008ProveedorPeer::co_clasificacion,$co_clasificacion);}
    
                                        if($tx_email!=""){$c->add(Tb008ProveedorPeer::tx_email,'%'.$tx_email.'%',Criteria::LIKE);}
        
                                        if($tx_sitio_web!=""){$c->add(Tb008ProveedorPeer::tx_sitio_web,'%'.$tx_sitio_web.'%',Criteria::LIKE);}
        
                                        if($nb_representante_legal!=""){$c->add(Tb008ProveedorPeer::nb_representante_legal,'%'.$nb_representante_legal.'%',Criteria::LIKE);}
        
                                            if($nu_cedula_representante!=""){$c->add(Tb008ProveedorPeer::nu_cedula_representante,$nu_cedula_representante);}
    
                                        if($tx_num_celular!=""){$c->add(Tb008ProveedorPeer::tx_num_celular,'%'.$tx_num_celular.'%',Criteria::LIKE);}
        
                                            if($nu_dia_credito!=""){$c->add(Tb008ProveedorPeer::nu_dia_credito,$nu_dia_credito);}
    
                                    
        if($fe_registro!=""){
    list($dia, $mes,$anio) = explode("/",$fe_registro);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb008ProveedorPeer::fe_registro,$fecha);
    }
                                            if($co_cuenta_contable!=""){$c->add(Tb008ProveedorPeer::co_cuenta_contable,$co_cuenta_contable);}
    
                                    
        if($fe_vencimiento!=""){
    list($dia, $mes,$anio) = explode("/",$fe_vencimiento);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb008ProveedorPeer::fe_vencimiento,$fecha);
    }
                                        if($nu_cuenta_bancaria!=""){$c->add(Tb008ProveedorPeer::nu_cuenta_bancaria,'%'.$nu_cuenta_bancaria.'%',Criteria::LIKE);}
        
                                            if($co_banco!=""){$c->add(Tb008ProveedorPeer::co_banco,$co_banco);}
    
                                            if($co_tipo_residencia!=""){$c->add(Tb008ProveedorPeer::co_tipo_residencia,$co_tipo_residencia);}
    
                                            if($co_tipo_proveedor!=""){$c->add(Tb008ProveedorPeer::co_tipo_proveedor,$co_tipo_proveedor);}
    
                                            if($co_tipo_retencion!=""){$c->add(Tb008ProveedorPeer::co_tipo_retencion,$co_tipo_retencion);}
    
                                        if($tx_registro!=""){$c->add(Tb008ProveedorPeer::tx_registro,'%'.$tx_registro.'%',Criteria::LIKE);}
        
                                    
        if($fe_registro_seniat!=""){
    list($dia, $mes,$anio) = explode("/",$fe_registro_seniat);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb008ProveedorPeer::fe_registro_seniat,$fecha);
    }
                                            if($nu_registro!=""){$c->add(Tb008ProveedorPeer::nu_registro,$nu_registro);}
    
                                            if($nu_tomo!=""){$c->add(Tb008ProveedorPeer::nu_tomo,$nu_tomo);}
    
                                            if($nu_capital_suscrito!=""){$c->add(Tb008ProveedorPeer::nu_capital_suscrito,$nu_capital_suscrito);}
    
                                            if($nu_capital_pagado!=""){$c->add(Tb008ProveedorPeer::nu_capital_pagado,$nu_capital_pagado);}
    
                                        if($tx_observacion!=""){$c->add(Tb008ProveedorPeer::tx_observacion,'%'.$tx_observacion.'%',Criteria::LIKE);}
        
                                            if($co_iva_retencion!=""){$c->add(Tb008ProveedorPeer::co_iva_retencion,$co_iva_retencion);}
    
                                        if($tx_cuenta_contable!=""){$c->add(Tb008ProveedorPeer::tx_cuenta_contable,'%'.$tx_cuenta_contable.'%',Criteria::LIKE);}
        
                                        if($nu_codigo!=""){$c->add(Tb008ProveedorPeer::nu_codigo,'%'.$nu_codigo.'%',Criteria::LIKE);}
        
                                    
                                            if($co_cuenta_orden_pasivo!=""){$c->add(Tb008ProveedorPeer::co_cuenta_orden_pasivo,$co_cuenta_orden_pasivo);}
    
                                            if($co_cuenta_orden_activo!=""){$c->add(Tb008ProveedorPeer::co_cuenta_orden_activo,$co_cuenta_orden_activo);}
    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb008ProveedorPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        
    $stmt = Tb008ProveedorPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_proveedor"     => trim($res["co_proveedor"]),
            "tx_razon_social"     => trim($res["tx_razon_social"]),
            "co_documento"     => trim($res["co_documento"]),
            "tx_siglas"     => trim($res["tx_siglas"]),
            "tx_rif"     => trim($res["tx_rif"]),
            "tx_nit"     => trim($res["tx_nit"]),
            "tx_direccion"     => trim($res["tx_direccion"]),
            "co_estado"     => trim($res["co_estado"]),
            "co_municipio"     => trim($res["co_municipio"]),
            "co_clasificacion"     => trim($res["co_clasificacion"]),
            "tx_email"     => trim($res["tx_email"]),
            "tx_sitio_web"     => trim($res["tx_sitio_web"]),
            "nb_representante_legal"     => trim($res["nb_representante_legal"]),
            "nu_cedula_representante"     => trim($res["nu_cedula_representante"]),
            "tx_num_celular"     => trim($res["tx_num_celular"]),
            "nu_dia_credito"     => trim($res["nu_dia_credito"]),
            "fe_registro"     => trim($res["fe_registro"]),
            "co_cuenta_contable"     => trim($res["co_cuenta_contable"]),
            "fe_vencimiento"     => trim($res["fe_vencimiento"]),
            "nu_cuenta_bancaria"     => trim($res["nu_cuenta_bancaria"]),
            "co_banco"     => trim($res["co_banco"]),
            "co_tipo_residencia"     => trim($res["co_tipo_residencia"]),
            "co_tipo_proveedor"     => trim($res["co_tipo_proveedor"]),
            "co_tipo_retencion"     => trim($res["co_tipo_retencion"]),
            "tx_registro"     => trim($res["tx_registro"]),
            "fe_registro_seniat"     => trim($res["fe_registro_seniat"]),
            "nu_registro"     => trim($res["nu_registro"]),
            "nu_tomo"     => trim($res["nu_tomo"]),
            "nu_capital_suscrito"     => trim($res["nu_capital_suscrito"]),
            "nu_capital_pagado"     => trim($res["nu_capital_pagado"]),
            "tx_observacion"     => trim($res["tx_observacion"]),
            "co_iva_retencion"     => trim($res["co_iva_retencion"]),
            "tx_cuenta_contable"     => trim($res["tx_cuenta_contable"]),
            "nu_codigo"     => trim($res["nu_codigo"]),
            "in_rrhh"     => trim($res["in_rrhh"]),
            "co_cuenta_orden_pasivo"     => trim($res["co_cuenta_orden_pasivo"]),
            "co_cuenta_orden_activo"     => trim($res["co_cuenta_orden_activo"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
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
                                                                                                                    //modelo fk tb044_iva_retencion.CO_IVA_RETENCION
    public function executeStorefkcoivaretencion(sfWebRequest $request){
        $c = new Criteria();
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
                                                                    


}