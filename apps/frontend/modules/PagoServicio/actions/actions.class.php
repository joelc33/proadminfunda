<?php

/**
 * autoPagoServicio actions.
 * NombreClaseModel(Tb135PagoServicio)
 * NombreTabla(tb135_pago_servicio)
 * @package    ##PROJECT_NAME##
 * @subpackage autoPagoServicio
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class PagoServicioActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('PagoServicio', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('PagoServicio', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("co_solicitud");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb135PagoServicioPeer::CO_PAGO_SERVICIO);
        $c->addSelectColumn(Tb135PagoServicioPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb135PagoServicioPeer::CO_TIPO_SERVICIO);
        $c->addSelectColumn(Tb135PagoServicioPeer::NU_FACTURA);
        $c->addSelectColumn(Tb135PagoServicioPeer::NU_CONTROL);
        $c->addSelectColumn(Tb135PagoServicioPeer::MO_FACTURA);
        $c->addSelectColumn(Tb135PagoServicioPeer::FE_DESDE);
        $c->addSelectColumn(Tb135PagoServicioPeer::FE_HASTA);
        $c->addSelectColumn(Tb135PagoServicioPeer::TX_OBSERVACION);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        $c->addJoin(Tb135PagoServicioPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR, Criteria::LEFT_JOIN);
        $c->add(Tb135PagoServicioPeer::CO_SOLICITUD,$codigo);
        
        $stmt = Tb135PagoServicioPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_pago_servicio"     => $campos["co_pago_servicio"],
                            "co_solicitud"         => $codigo,
                            "co_tipo_servicio"     => $campos["co_tipo_servicio"],
                            "nu_factura"           => $campos["nu_factura"],
                            "nu_control"           => $campos["nu_control"],
                            "mo_factura"           => $campos["mo_factura"],
                            "fe_desde"             => $campos["fe_desde"],
                            "fe_hasta"             => $campos["fe_hasta"],
                            "tx_observacion"       => $campos["tx_observacion"],
                            "co_proveedor"         => $campos["co_proveedor"],
                            "co_documento"         => $campos["co_documento"],
                            "tx_razon_social"      => $campos["tx_razon_social"],
                            "tx_rif"               => $campos["tx_rif"],
                            "tx_direccion"         => $campos["tx_direccion"]
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_pago_servicio"     => "",
                            "co_solicitud"         => "",
                            "co_tipo_servicio"     => "",
                            "nu_factura"           => "",
                            "nu_control"           => "",
                            "mo_factura"           => "",
                            "fe_desde"             => "",
                            "fe_hasta"             => "",
                            "tx_observacion"       => "",
                            "co_proveedor"         => "",
                            "co_documento"         => "",
                            "tx_razon_social"      => "",
                            "tx_rif"               => "",
                            "tx_direccion"         => ""
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_pago_servicio");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb135_pago_servicio = Tb135PagoServicioPeer::retrieveByPk($codigo);
     }else{
         $tb135_pago_servicio = new Tb135PagoServicio();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb135_pago_servicioForm = $this->getRequestParameter('tb135_pago_servicio');
        $tb135_pago_servicio->setCoSolicitud($tb135_pago_servicioForm["co_solicitud"]);
        $tb135_pago_servicio->setCoTipoServicio($tb135_pago_servicioForm["co_tipo_servicio"]);
        $tb135_pago_servicio->setNuFactura($tb135_pago_servicioForm["nu_factura"]);
        $tb135_pago_servicio->setNuControl($tb135_pago_servicioForm["nu_control"]);
        $tb135_pago_servicio->setMoFactura($tb135_pago_servicioForm["mo_factura"]);
        $tb135_pago_servicio->setCoProveedor($tb135_pago_servicioForm["co_proveedor"]);
        
        list($dia, $mes, $anio) = explode("/",$tb135_pago_servicioForm["fe_desde"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb135_pago_servicio->setFeDesde($fecha);
                                                                
        
        list($dia, $mes, $anio) = explode("/",$tb135_pago_servicioForm["fe_hasta"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb135_pago_servicio->setFeHasta($fecha);
                                                        
       
        $tb135_pago_servicio->setTxObservacion($tb135_pago_servicioForm["tx_observacion"]);
                                
        /*CAMPOS*/
        $tb135_pago_servicio->save($con);
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
	$codigo = $this->getRequestParameter("co_pago_servicio");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb135_pago_servicio = Tb135PagoServicioPeer::retrieveByPk($codigo);			
	$tb135_pago_servicio->delete($con);
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
                $co_solicitud      =   $this->getRequestParameter("co_solicitud");
            $co_tipo_servicio      =   $this->getRequestParameter("co_tipo_servicio");
            $nu_factura      =   $this->getRequestParameter("nu_factura");
            $nu_control      =   $this->getRequestParameter("nu_control");
            $mo_factura      =   $this->getRequestParameter("mo_factura");
            $fe_desde      =   $this->getRequestParameter("fe_desde");
            $fe_hasta      =   $this->getRequestParameter("fe_hasta");
            $tx_observacion      =   $this->getRequestParameter("tx_observacion");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_solicitud!=""){$c->add(Tb135PagoServicioPeer::co_solicitud,$co_solicitud);}
    
                                            if($co_tipo_servicio!=""){$c->add(Tb135PagoServicioPeer::co_tipo_servicio,$co_tipo_servicio);}
    
                                        if($nu_factura!=""){$c->add(Tb135PagoServicioPeer::nu_factura,'%'.$nu_factura.'%',Criteria::LIKE);}
        
                                        if($nu_control!=""){$c->add(Tb135PagoServicioPeer::nu_control,'%'.$nu_control.'%',Criteria::LIKE);}
        
                                            if($mo_factura!=""){$c->add(Tb135PagoServicioPeer::mo_factura,$mo_factura);}
    
                                    
        if($fe_desde!=""){
    list($dia, $mes,$anio) = explode("/",$fe_desde);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb135PagoServicioPeer::fe_desde,$fecha);
    }
                                    
        if($fe_hasta!=""){
    list($dia, $mes,$anio) = explode("/",$fe_hasta);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb135PagoServicioPeer::fe_hasta,$fecha);
    }
                                        if($tx_observacion!=""){$c->add(Tb135PagoServicioPeer::tx_observacion,'%'.$tx_observacion.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb135PagoServicioPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb135PagoServicioPeer::CO_PAGO_SERVICIO);
        
    $stmt = Tb135PagoServicioPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_pago_servicio"     => trim($res["co_pago_servicio"]),
            "co_solicitud"     => trim($res["co_solicitud"]),
            "co_tipo_servicio"     => trim($res["co_tipo_servicio"]),
            "nu_factura"     => trim($res["nu_factura"]),
            "nu_control"     => trim($res["nu_control"]),
            "mo_factura"     => trim($res["mo_factura"]),
            "fe_desde"     => trim($res["fe_desde"]),
            "fe_hasta"     => trim($res["fe_hasta"]),
            "tx_observacion"     => trim($res["tx_observacion"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
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
                    //modelo fk tb134_tipo_servicio.CO_TIPO_SERVICIO
    public function executeStorefkcotiposervicio(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb134TipoServicioPeer::doSelectStmt($c);
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