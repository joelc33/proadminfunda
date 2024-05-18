<?php

/**
 * autoCompromisoAsignacion actions.
 * NombreClaseModel(Tb146CompromisoAsignacion)
 * NombreTabla(tb146_compromiso_asignacion)
 * @package    ##PROJECT_NAME##
 * @subpackage autoCompromisoAsignacion
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class CompromisoAsignacionActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('CompromisoAsignacion', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('CompromisoAsignacion', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }
  
  public function executeAgregarAsignacion(sfWebRequest $request)
  {

  }  

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("co_solicitud");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->clearSelectColumns();        
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addSelectColumn(Tb146CompromisoAsignacionPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb146CompromisoAsignacionPeer::CO_COMPROMISO_ASIGNACION);
        $c->addSelectColumn(Tb146CompromisoAsignacionPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb146CompromisoAsignacionPeer::TX_DESCRIPCION);
        $c->addSelectColumn(Tb146CompromisoAsignacionPeer::NU_CANCELACION);
        $c->addSelectColumn(Tb146CompromisoAsignacionPeer::FE_COMPROMISO);
        $c->addSelectColumn(Tb146CompromisoAsignacionPeer::NU_MONTO);
        $c->addSelectColumn(Tb052ComprasPeer::CO_EJECUTOR);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
        
        $c->addJoin(Tb146CompromisoAsignacionPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD);
        $c->addJoin(Tb146CompromisoAsignacionPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->add(Tb146CompromisoAsignacionPeer::CO_SOLICITUD,$codigo);
        
        $stmt = Tb146CompromisoAsignacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_compromiso_asignacion"     => $campos["co_compromiso_asignacion"],
                            "co_proveedor"                 => $campos["co_proveedor"],
                            "tx_descripcion"               => $campos["tx_descripcion"],
                            "nu_cancelacion"               => $campos["nu_cancelacion"],
                            "fe_compromiso"                => $campos["fe_compromiso"],
                            "nu_monto"                     => $campos["nu_monto"],
                            "co_solicitud"                 => $codigo,
                            "co_ejecutor"                  => $campos["co_ejecutor"],
                            "co_compras"                   => $campos["co_compras"],
                            "tx_razon_social"              => $campos["tx_razon_social"],
                            "tx_rif"                       => $campos["tx_rif"],
                            "tx_direccion"                 => $campos["tx_direccion"],
                            "co_documento"                 => $campos["co_documento"]
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_compromiso_asignacion"     => "",
                            "co_proveedor"                 => "",
                            "tx_descripcion"               => "",
                            "nu_cancelacion"               => "",
                            "fe_compromiso"                => "",
                            "nu_monto"                     => "",
                            "co_solicitud"                 => $codigo,
                    ));
    }

  }
  
  public function executeGenerarODP(sfWebRequest $request)
  {
        $tb146_compromiso_asignacionForm = $this->getRequestParameter('tb146_compromiso_asignacion');
        $con = Propel::getConnection();
        
        $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
        $tb087_presupuesto_movimiento->setCoPartida($tb146_compromiso_asignacionForm["co_presupuesto"])
                         ->setCoTipoMovimiento(1)
                         ->setNuMonto($tb146_compromiso_asignacionForm["nu_monto"])
                         //->setNuAnio(date('Y'))
                         ->setNuAnio( $this->getUser()->getAttribute('ejercicio'))
                         ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                         ->setCoDetalleCompra($tb146_compromiso_asignacionForm["co_detalle_compra"])
                         ->setInActivo(true)
                         ->save($con);

        $con->commit();
        $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
        $tb087_presupuesto_movimiento->setCoPartida($tb146_compromiso_asignacionForm["co_presupuesto"])
                         ->setCoTipoMovimiento(2)
                         ->setNuMonto($tb146_compromiso_asignacionForm["nu_monto"])
                         //->setNuAnio(date('Y'))
                         ->setNuAnio( $this->getUser()->getAttribute('ejercicio'))
                         ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                         ->setCoDetalleCompra($tb146_compromiso_asignacionForm["co_detalle_compra"])
                         ->setInActivo(true)
                         ->save($con);
         $con->commit();
        
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb146_compromiso_asignacionForm["co_solicitud"]));
        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());  
                    
        $co_odp = Tb060OrdenPagoPeer::generarODP($tb146_compromiso_asignacionForm["co_solicitud"],$con,$this->getUser()->getAttribute('ejercicio')); 
        
        $con->commit();
        
        $tb045_factura = new Tb045Factura(); 
        $tb045_factura->setNuTotal($tb146_compromiso_asignacionForm["nu_monto"])
                       ->setNuBaseImponible($tb146_compromiso_asignacionForm["nu_monto"])
                       ->setCoIvaFactura(0)
                       ->setNuIvaFactura(0)
                       ->setCoIvaRetencion(0)
                       ->setNuIvaRetencion(0)
                       ->setCoCompra($tb146_compromiso_asignacionForm["co_compras"])
                       ->setNuTotalRetencion(0)
                       ->setTotalPagar($tb146_compromiso_asignacionForm["nu_monto"])
                       ->setTxConcepto("AYUDA")   
                       ->setCoOdp($co_odp)
                       ->setCoSolicitud($tb146_compromiso_asignacionForm["co_solicitud"])->save($con);
         $con->commit();
        
        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());        
        
        
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente'
                ));
        $con->commit();
      
  }
  
  public function executeOdp(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("co_solicitud");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->clearSelectColumns();        
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);
        $c->addSelectColumn(Tb146CompromisoAsignacionPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb146CompromisoAsignacionPeer::CO_COMPROMISO_ASIGNACION);
        $c->addSelectColumn(Tb146CompromisoAsignacionPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb146CompromisoAsignacionPeer::TX_DESCRIPCION);
        $c->addSelectColumn(Tb146CompromisoAsignacionPeer::NU_CANCELACION);
        $c->addSelectColumn(Tb146CompromisoAsignacionPeer::FE_COMPROMISO);
        $c->addSelectColumn(Tb146CompromisoAsignacionPeer::NU_MONTO);
        $c->addSelectColumn(Tb052ComprasPeer::CO_EJECUTOR);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PRESUPUESTO);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_PROYECTO_AC);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_ACCION_ESPECIFICA);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);        
        $c->addSelectColumn(Tb060OrdenPagoPeer::CO_ORDEN_PAGO);
        
        
        $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD, Tb060OrdenPagoPeer::CO_SOLICITUD,  Criteria::LEFT_JOIN);
        $c->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
        $c->addJoin(Tb146CompromisoAsignacionPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD);
        $c->addJoin(Tb146CompromisoAsignacionPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->add(Tb146CompromisoAsignacionPeer::CO_SOLICITUD,$codigo);
        
        $stmt = Tb146CompromisoAsignacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_compromiso_asignacion"     => $campos["co_compromiso_asignacion"],
                            "co_proveedor"                 => $campos["co_proveedor"],
                            "tx_descripcion"               => $campos["tx_descripcion"],
                            "nu_cancelacion"               => $campos["nu_cancelacion"],
                            "fe_compromiso"                => $campos["fe_compromiso"],
                            "nu_monto"                     => $campos["nu_monto"],
                            "co_solicitud"                 => $codigo,
                            "co_ejecutor"                  => $campos["co_ejecutor"],
                            "co_detalle_compras"           => $campos["co_detalle_compras"],
                            "co_compras"                   => $campos["co_compras"],
                            "co_presupuesto"               => $campos["co_presupuesto"],
                            "co_proyecto_ac"               => $campos["co_proyecto_ac"],
                            "co_accion_especifica"         => $campos["co_accion_especifica"],
                            "tx_razon_social"              => $campos["tx_razon_social"],
                            "tx_rif"                       => $campos["tx_rif"],
                            "tx_direccion"                 => $campos["tx_direccion"],
                            "co_documento"                 => $campos["co_documento"],
                            "co_orden_pago"                => $campos["co_orden_pago"]
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_compromiso_asignacion"     => "",
                            "co_proveedor"                 => "",
                            "tx_descripcion"               => "",
                            "nu_cancelacion"               => "",
                            "fe_compromiso"                => "",
                            "nu_monto"                     => "",
                            "co_solicitud"                 => $codigo,
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_compromiso_asignacion");
     $tb146_compromiso_asignacionForm = $this->getRequestParameter('tb146_compromiso_asignacion');
     $json_asignacion  = $this->getRequestParameter("json_asignacion");
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb146_compromiso_asignacion = Tb146CompromisoAsignacionPeer::retrieveByPk($codigo);
         //$tb053_detalle_compras = Tb053DetalleComprasPeer::retrieveByPK($tb146_compromiso_asignacionForm["co_detalle_compra"]);
         $tb052_compras         = Tb052ComprasPeer::retrieveByPk($tb146_compromiso_asignacionForm["co_compras"]);
     }else{
         $tb146_compromiso_asignacion = new Tb146CompromisoAsignacion();
         $tb052_compras = new Tb052Compras();
         //$tb053_detalle_compras = new Tb053DetalleCompras();
     }
     try
      { 
        $con->beginTransaction();
        
        $Tb026Solicitud = Tb026SolicitudPeer::retrieveByPK($tb146_compromiso_asignacionForm["co_solicitud"]);
        $Tb026Solicitud->setCoProveedor($tb146_compromiso_asignacionForm["co_proveedor"])->save($con);
        
        $tb146_compromiso_asignacion->setCoProveedor($tb146_compromiso_asignacionForm["co_proveedor"]);
        $tb146_compromiso_asignacion->setTxDescripcion($tb146_compromiso_asignacionForm["tx_descripcion"]);
        $tb146_compromiso_asignacion->setNuCancelacion($tb146_compromiso_asignacionForm["nu_cancelacion"]);
        $tb146_compromiso_asignacion->setCoUsuario($this->getUser()->getAttribute('codigo'));
        
        list($dia, $mes, $anio) = explode("/",$tb146_compromiso_asignacionForm["fe_compromiso"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb146_compromiso_asignacion->setFeCompromiso($fecha);                                                        
        
        $tb146_compromiso_asignacion->setNuMonto($tb146_compromiso_asignacionForm["nu_monto"]);
        $tb146_compromiso_asignacion->setCoSolicitud($tb146_compromiso_asignacionForm["co_solicitud"]);
        $tb146_compromiso_asignacion->save($con);        
        
        $tb052_compras->setCoUsuario($this->getUser()->getAttribute('codigo'));                                                                
        //$tb052_compras->setFechaCompra(date("Y-m-d")); 
        if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
            $tb052_compras->setFechaCompra($this->getUser()->getAttribute('fe_cierre')); 
        }else{
            $tb052_compras->setFechaCompra(date("Y-m-d")); 
        }   
        $tb052_compras->setTxObservacion($tb146_compromiso_asignacionForm["tx_descripcion"]);
        $tb052_compras->setCoSolicitud($tb146_compromiso_asignacionForm["co_solicitud"]); 
        $tb052_compras->setCoEjecutor($tb146_compromiso_asignacionForm["co_ejecutor"]); 
        $tb052_compras->setCoTipoSolicitud(32);                                                        
        //$tb052_compras->setAnio(date('Y'));     
        $tb052_compras->setAnio( $this->getUser()->getAttribute('ejercicio'));  
        $tb052_compras->setNuIva(0);        
        $tb052_compras->setMontoIva(0);
        $tb052_compras->setMontoSubTotal(0);        
        $tb052_compras->setMontoTotal($tb146_compromiso_asignacionForm["nu_monto"]);        
        $tb052_compras->setCoTipoMovimiento(0); 
        $tb052_compras->save($con);   
        
        $listaAsignacion  = json_decode($json_asignacion,true);
        
        foreach($listaAsignacion  as $asignacionForm){
          
                if($asignacionForm["co_detalle_compras"]==''){
                    
                    $tb053_detalle_compras = new Tb053DetalleCompras();
                    $tb053_detalle_compras->setCoCompras($tb052_compras->getCoCompras());
                    $tb053_detalle_compras->setNuCantidad(1);
                    $tb053_detalle_compras->setCoProducto(18554);
                    $tb053_detalle_compras->setDetalle($tb146_compromiso_asignacionForm["tx_descripcion"]);
                    $tb053_detalle_compras->setPrecioUnitario($asignacionForm["monto"]);
                    $tb053_detalle_compras->setMonto($asignacionForm["monto"]);

                    $tb053_detalle_compras->setCoPresupuesto($asignacionForm["co_partida"]);
                    $tb053_detalle_compras->setCoProyectoAc($asignacionForm["co_proyecto"]);
                    $tb053_detalle_compras->setCoAccionEspecifica($asignacionForm["co_accion"]);        
                    $tb053_detalle_compras->save($con);
                }
        }        
        

                       
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb146_compromiso_asignacionForm["co_solicitud"]));
        $ruta->setInCargarDato(true)->save($con);
    
        $con->commit();
        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());        
        
        
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
	$codigo = $this->getRequestParameter("co_compromiso_asignacion");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb146_compromiso_asignacion = Tb146CompromisoAsignacionPeer::retrieveByPk($codigo);			
	$tb146_compromiso_asignacion->delete($con);
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
                $co_proveedor      =   $this->getRequestParameter("co_proveedor");
            $tx_descripcion      =   $this->getRequestParameter("tx_descripcion");
            $nu_cancelacion      =   $this->getRequestParameter("nu_cancelacion");
            $fe_compromiso      =   $this->getRequestParameter("fe_compromiso");
            $nu_monto      =   $this->getRequestParameter("nu_monto");
            $co_solicitud      =   $this->getRequestParameter("co_solicitud");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_proveedor!=""){$c->add(Tb146CompromisoAsignacionPeer::co_proveedor,$co_proveedor);}
    
                                        if($tx_descripcion!=""){$c->add(Tb146CompromisoAsignacionPeer::tx_descripcion,'%'.$tx_descripcion.'%',Criteria::LIKE);}
        
                                            if($nu_cancelacion!=""){$c->add(Tb146CompromisoAsignacionPeer::nu_cancelacion,$nu_cancelacion);}
    
                                    
        if($fe_compromiso!=""){
    list($dia, $mes,$anio) = explode("/",$fe_compromiso);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb146CompromisoAsignacionPeer::fe_compromiso,$fecha);
    }
                                            if($nu_monto!=""){$c->add(Tb146CompromisoAsignacionPeer::nu_monto,$nu_monto);}
    
                                            if($co_solicitud!=""){$c->add(Tb146CompromisoAsignacionPeer::co_solicitud,$co_solicitud);}
    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb146CompromisoAsignacionPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb146CompromisoAsignacionPeer::CO_COMPROMISO_ASIGNACION);
        
    $stmt = Tb146CompromisoAsignacionPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_compromiso_asignacion"     => trim($res["co_compromiso_asignacion"]),
            "co_proveedor"     => trim($res["co_proveedor"]),
            "tx_descripcion"     => trim($res["tx_descripcion"]),
            "nu_cancelacion"     => trim($res["nu_cancelacion"]),
            "fe_compromiso"     => trim($res["fe_compromiso"]),
            "nu_monto"     => trim($res["nu_monto"]),
            "co_solicitud"     => trim($res["co_solicitud"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb008_proveedor.CO_PROVEEDOR
    public function executeStorefkcoproveedor(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb008ProveedorPeer::doSelectStmt($c);
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
    
    public function executeStorefkasignacion(sfWebRequest $request){

            $co_compras = $this->getRequestParameter("co_compras");
    
            $c = new Criteria();
            $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
            $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
            $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
            $c->addSelectColumn(Tb082EjecutorPeer::NU_EJECUTOR);
            $c->addSelectColumn(Tb082EjecutorPeer::DE_EJECUTOR);
            $c->addSelectColumn(Tb083ProyectoAcPeer::NU_PROYECTO_AC);
            $c->addSelectColumn(Tb083ProyectoAcPeer::DE_PROYECTO_AC);
            $c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
            $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
            $c->add(Tb053DetalleComprasPeer::CO_COMPRAS, $co_compras);
            $c->addJoin(Tb053DetalleComprasPeer::CO_PRESUPUESTO, Tb085PresupuestoPeer::ID);
            $c->addJoin(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA, Tb084AccionEspecificaPeer::ID);
            $c->addJoin(Tb084AccionEspecificaPeer::ID_TB083_PROYECTO_AC, Tb083ProyectoAcPeer::ID);
            $c->addJoin(Tb085PresupuestoPeer::CO_ENTE, Tb082EjecutorPeer::ID);
            $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);
            $registros = array();
            while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = array(
            "co_detalle_compras"     => trim($reg["co_detalle_compras"]),
            "tx_ejecutor"     => trim($reg["nu_ejecutor"]).' - '.trim($reg["de_ejecutor"]),
            "tx_proyecto"     => trim($reg["nu_proyecto_ac"]).' - '.trim($reg["de_proyecto_ac"]),
            "tx_partida"     => trim($reg["nu_partida"]).' - '.trim($reg["de_partida"]),
            "monto"     => trim($reg["monto"]),
        );
            }
            $this->data = json_encode(array(
                "success"   =>  true,
                "total"     =>  count($registros),
                "data"      =>  $registros
            ));
    
            $this->setTemplate('store');
        }    
        
     public function executeEliminarAsignacion(sfWebRequest $request){
      
        $codigo = $this->getRequestParameter("co_detalle_compras");
        
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
            /*CAMPOS*/
            $Tb053DetalleCompra = Tb053DetalleComprasPeer::retrieveByPk($codigo);
            $co_compras = $Tb053DetalleCompra->getCoCompras();
            $Tb053DetalleCompra->delete($con);
            
            
            $c = new Criteria();
            $c->add(Tb053DetalleComprasPeer::CO_COMPRAS,$co_compras);            
            $cant = Tb053DetalleComprasPeer::doCount($c);
            
            $Tb052Compra = Tb052ComprasPeer::retrieveByPk($co_compras);
            
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($Tb052Compra->getCoSolicitud()));

            if($cant>0){            
                $ruta->setInCargarDato(true)->save($con);
            }else{
                $ruta->setInCargarDato(false)->save($con);
            }
            
            
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
                "msg" => 'Este registro no se puede borrar'
            ));
	}
        
         $this->setTemplate('eliminar');
      
  }

}