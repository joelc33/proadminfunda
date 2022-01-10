<?php

/**
 * autoCuentaPorCobrar actions.
 * NombreClaseModel(Tb125CuentaPorCobrar)
 * NombreTabla(tb125_cuenta_por_cobrar)
 * @package    ##PROJECT_NAME##
 * @subpackage autoCuentaPorCobrar
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class CuentaPorCobrarActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('CuentaPorCobrar', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('CuentaPorCobrar', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
     
    $codigo = $this->getRequestParameter("co_solicitud");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tb125CuentaPorCobrarPeer::CO_SOLICITUD,$codigo);

        $stmt = Tb125CuentaPorCobrarPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_cuenta_por_cobrar"     => $campos["co_cuenta_por_cobrar"],
                            "co_fuente_ingreso"        => $campos["co_fuente_ingreso"],
                            "tx_referencia"            => $campos["tx_referencia"],
                            "mo_ingreso"               => $campos["mo_ingreso"],
                            "tx_descripcion"           => $campos["tx_descripcion"],
                            "fe_registro"              => $campos["fe_registro"],
                            "co_solicitud"             => $this->getRequestParameter("co_solicitud"),
                            "co_banco"                 => $campos["co_banco"],
                            "co_cuenta_bancaria"       => $campos["co_cuenta_bancaria"],
                            "created_at"               => $campos["created_at"],
                            "updated_at"               => $campos["updated_at"],
                            "co_usuario"               => $this->getUser()->getAttribute('codigo')
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_cuenta_por_cobrar");

     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb125_cuenta_por_cobrar = Tb125CuentaPorCobrarPeer::retrieveByPk($codigo);
     }else{
         $tb125_cuenta_por_cobrar = new Tb125CuentaPorCobrar();
     }
     try
      {
        $con->beginTransaction();

        $tb125_cuenta_por_cobrarForm = $this->getRequestParameter('tb125_cuenta_por_cobrar');

        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb125_cuenta_por_cobrarForm["co_solicitud"]));
   
        $tb125_cuenta_por_cobrar->setCoFuenteIngreso($tb125_cuenta_por_cobrarForm["co_fuente_ingreso"]);
        $tb125_cuenta_por_cobrar->setTxReferencia($tb125_cuenta_por_cobrarForm["tx_referencia"]);
        $tb125_cuenta_por_cobrar->setMoIngreso($tb125_cuenta_por_cobrarForm["mo_ingreso"]);
        $tb125_cuenta_por_cobrar->setTxDescripcion($tb125_cuenta_por_cobrarForm["tx_descripcion"]);


        list($dia, $mes, $anio) = explode("/",$tb125_cuenta_por_cobrarForm["fe_registro"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb125_cuenta_por_cobrar->setFeRegistro($fecha);


        $tb125_cuenta_por_cobrar->setCoSolicitud($tb125_cuenta_por_cobrarForm["co_solicitud"]);
        $tb125_cuenta_por_cobrar->setCoBanco($tb125_cuenta_por_cobrarForm["co_banco"]);
        $tb125_cuenta_por_cobrar->setCoCuentaBancaria($tb125_cuenta_por_cobrarForm["co_cuenta_bancaria"]);
        $tb125_cuenta_por_cobrar->setCoUsuario($tb125_cuenta_por_cobrarForm["co_usuario"]);


        $cfuente = new Criteria();
        $cfuente->add(Tb124FuenteIngresoPeer::CO_FUENTE_INGRESO,$tb125_cuenta_por_cobrarForm["co_fuente_ingreso"]);
        $stmtFuente = Tb124FuenteIngresoPeer::doSelectStmt($cfuente);
        $datosFuente = $stmtFuente->fetch(PDO::FETCH_ASSOC);

        if($tb125_cuenta_por_cobrar->getCoAsientoFuente()!=''){

            $tb061_asiento_contable_fuente = Tb061AsientoContablePeer::retrieveByPK($tb125_cuenta_por_cobrar->getCoAsientoFuente());

            $tb024_cuenta_contable_fuente = Tb024CuentaContablePeer::retrieveByPK($tb061_asiento_contable_fuente->getCoCuentaContable());

            $monto_disponible = $tb024_cuenta_contable_fuente->getMoDisponible();
            $monto_haber    = $tb061_asiento_contable_fuente->getMoHaber();

            $nuevo_monto = $monto_disponible-$monto_haber;
            
            if($nuevo_monto<0){
                $nuevo_monto = 0;
            }

            $tb024_cuenta_contable_fuente->setMoDisponible($nuevo_monto)->save($con);

            $tb024_cuenta_contable_fuente_update = Tb024CuentaContablePeer::retrieveByPK($datosFuente["co_cuenta_contable"]);

            $monto_disponible = $tb024_cuenta_contable_fuente_update->getMoDisponible();
            $monto_ingreso    = $tb125_cuenta_por_cobrarForm["mo_ingreso"];

            $monto_total = $monto_disponible+$monto_ingreso;
            
            $tb024_cuenta_contable_fuente_update->setMoDisponible($monto_total)->save($con);

            $tb061_asiento_contable_fuente->setCoCuentaContable($datosFuente["co_cuenta_contable"])
                                          ->setMoHaber($tb125_cuenta_por_cobrarForm["mo_ingreso"])
                                          ->setCoUsuario($tb125_cuenta_por_cobrarForm["co_usuario"])
                                          ->setCoRuta($ruta->getCoRuta())
                                          ->save($con);
        }else{
            
            $tb061_asiento_contable_fuente = new Tb061AsientoContable();
            $tb061_asiento_contable_fuente->setCoSolicitud($tb125_cuenta_por_cobrarForm["co_solicitud"])
                                        ->setMoHaber($tb125_cuenta_por_cobrarForm["mo_ingreso"])
                                        ->setCoUsuario($tb125_cuenta_por_cobrarForm["co_usuario"])
                                        ->setCoCuentaContable($datosFuente["co_cuenta_contable"])
                                        ->setCoRuta($ruta->getCoRuta())
                                        ->save($con);
            
            $tb125_cuenta_por_cobrar->setCoAsientoFuente($tb061_asiento_contable_fuente->getCoAsientoContable());
            
        }
        
        
        $cCuenta = new Criteria();
        $cCuenta->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA,$tb125_cuenta_por_cobrarForm["co_cuenta_bancaria"]);
        $stmtCuenta = Tb011CuentaBancariaPeer::doSelectStmt($cCuenta);
        $datosCuenta = $stmtCuenta->fetch(PDO::FETCH_ASSOC);


        if($tb125_cuenta_por_cobrar->getCoAsientoCuenta()!=''){
            $tb061_asiento_contable_cuenta = Tb061AsientoContablePeer::retrieveByPK($tb125_cuenta_por_cobrar->getCoAsientoCuenta());
            $tb061_asiento_contable_cuenta->setCoCuentaContable($datosCuenta["co_cuenta_contable"])
                                          ->setMoDebe($tb125_cuenta_por_cobrarForm["mo_ingreso"])
                                          ->setCoUsuario($tb125_cuenta_por_cobrarForm["co_usuario"])
                                          ->setCoRuta($ruta->getCoRuta())
                                          ->save($con);
        }else{
            
            $tb061_asiento_contable_cuenta = new Tb061AsientoContable();
            $tb061_asiento_contable_cuenta->setCoSolicitud($tb125_cuenta_por_cobrarForm["co_solicitud"])
                                          ->setMoDebe($tb125_cuenta_por_cobrarForm["mo_ingreso"])
                                          ->setCoUsuario($tb125_cuenta_por_cobrarForm["co_usuario"])
                                          ->setCoCuentaContable($datosCuenta["co_cuenta_contable"])
                                          ->setCoRuta($ruta->getCoRuta())
                                          ->save($con);
            
            $tb125_cuenta_por_cobrar->setCoAsientoCuenta($tb061_asiento_contable_cuenta->getCoAsientoContable());
            
        }      
        
        $tb125_cuenta_por_cobrar->save($con);
        
        $ruta->setInCargarDato(true)->save($con);
    
        $con->commit();
        
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
	$codigo = $this->getRequestParameter("co_cuenta_por_cobrar");
	$con = Propel::getConnection();
	try
	{
	$con->beginTransaction();
	/*CAMPOS*/
	$tb125_cuenta_por_cobrar = Tb125CuentaPorCobrarPeer::retrieveByPk($codigo);
	$tb125_cuenta_por_cobrar->delete($con);
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
                $co_fuente_ingreso      =   $this->getRequestParameter("co_fuente_ingreso");
            $tx_referencia      =   $this->getRequestParameter("tx_referencia");
            $mo_ingreso      =   $this->getRequestParameter("mo_ingreso");
            $tx_descripcion      =   $this->getRequestParameter("tx_descripcion");
            $fe_registro      =   $this->getRequestParameter("fe_registro");
            $co_solicitud      =   $this->getRequestParameter("co_solicitud");
            $co_banco      =   $this->getRequestParameter("co_banco");
            $co_cuenta_bancaria      =   $this->getRequestParameter("co_cuenta_bancaria");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $co_usuario      =   $this->getRequestParameter("co_usuario");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_fuente_ingreso!=""){$c->add(Tb125CuentaPorCobrarPeer::co_fuente_ingreso,$co_fuente_ingreso);}

                                        if($tx_referencia!=""){$c->add(Tb125CuentaPorCobrarPeer::tx_referencia,'%'.$tx_referencia.'%',Criteria::LIKE);}

                                            if($mo_ingreso!=""){$c->add(Tb125CuentaPorCobrarPeer::mo_ingreso,$mo_ingreso);}

                                        if($tx_descripcion!=""){$c->add(Tb125CuentaPorCobrarPeer::tx_descripcion,'%'.$tx_descripcion.'%',Criteria::LIKE);}


        if($fe_registro!=""){
    list($dia, $mes,$anio) = explode("/",$fe_registro);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb125CuentaPorCobrarPeer::fe_registro,$fecha);
    }
                                            if($co_solicitud!=""){$c->add(Tb125CuentaPorCobrarPeer::co_solicitud,$co_solicitud);}

                                            if($co_banco!=""){$c->add(Tb125CuentaPorCobrarPeer::co_banco,$co_banco);}

                                            if($co_cuenta_bancaria!=""){$c->add(Tb125CuentaPorCobrarPeer::co_cuenta_bancaria,$co_cuenta_bancaria);}


        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb125CuentaPorCobrarPeer::created_at,$fecha);
    }

        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb125CuentaPorCobrarPeer::updated_at,$fecha);
    }
                                            if($co_usuario!=""){$c->add(Tb125CuentaPorCobrarPeer::co_usuario,$co_usuario);}

                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb125CuentaPorCobrarPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb125CuentaPorCobrarPeer::CO_CUENTA_POR_COBRAR);

    $stmt = Tb125CuentaPorCobrarPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_cuenta_por_cobrar"     => trim($res["co_cuenta_por_cobrar"]),
            "co_fuente_ingreso"     => trim($res["co_fuente_ingreso"]),
            "tx_referencia"     => trim($res["tx_referencia"]),
            "mo_ingreso"     => trim($res["mo_ingreso"]),
            "tx_descripcion"     => trim($res["tx_descripcion"]),
            "fe_registro"     => trim($res["fe_registro"]),
            "co_solicitud"     => trim($res["co_solicitud"]),
            "co_banco"     => trim($res["co_banco"]),
            "co_cuenta_bancaria"     => trim($res["co_cuenta_bancaria"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "co_usuario"     => trim($res["co_usuario"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb124_fuente_ingreso.CO_FUENTE_INGRESO
    public function executeStorefkcofuenteingreso(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb124FuenteIngresoPeer::doSelectStmt($c);
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
                    //modelo fk tb011_cuenta_bancaria.CO_CUENTA_BANCARIA
    public function executeStorefkcocuentabancaria(sfWebRequest $request){
        $c = new Criteria();
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



}
