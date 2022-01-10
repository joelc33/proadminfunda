<?php

/**
 * AportePatronal actions.
 *
 * @package    gobel
 * @subpackage AportePatronal
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class AportePatronalActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
        $codigo =  $this->getRequestParameter("co_solicitud");
        $con = Propel::getConnection();
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb052ComprasPeer::CO_COMPRAS);

        $c->add(Tb026SolicitudPeer::CO_SOLICITUD,$codigo);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR, Criteria::LEFT_JOIN);
        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
      
        $this->data = json_encode(array(
                            "co_proveedor"       => $campos["co_proveedor"],
                            "co_documento"       => $campos["co_documento"],
                            "tx_rif"             => $campos["tx_rif"],
                            "tx_razon_social"    => $campos["tx_razon_social"],
                            "tx_direccion"       => $campos["tx_direccion"],
                            "co_solicitud"       => $codigo,
                            "co_compra"          => $campos["co_compras"]
        ));
  }
  
  protected function getCoProducto($tx_codigo){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->add(Tb048ProductoPeer::COD_PRODUCTO,$tx_codigo);
        $stmt = Tb048ProductoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos["co_producto"];
  }


  
  protected function getMoTotalCompra($co_compra){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn('SUM('.Tb053DetalleComprasPeer::MONTO.') as total');
        $c->add(Tb053DetalleComprasPeer::CO_COMPRAS,$co_compra);
        $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return ($campos["total"]=='')?0:$campos["total"];
  }
  
  public function executeEliminarAporte(sfWebRequest $request){
      
        $co_detalle_compras        = $this->getRequestParameter("co_detalle_compras");
        $co_aporte_patronal_nomina = $this->getRequestParameter("co_aporte_patronal_nomina");
        
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
            /*CAMPOS*/
            $tb053_detalle_compras = Tb053DetalleComprasPeer::retrieveByPk($co_detalle_compras);			
            $co_compra = $tb053_detalle_compras->getCoCompras();
            $tb053_detalle_compras->delete($con);
            
            $tb159_aporte_patronal_nomina = Tb159AportePatronalNominaPeer::retrieveByPK($co_aporte_patronal_nomina);
            $tb159_aporte_patronal_nomina->setCoDetalleCompra(NULL)
                                         ->setCoSolicitud(NULL)
                                         ->save($con);
            
            $Tb052Compras = Tb052ComprasPeer::retrieveByPK($co_compra);
            $monto_compra = $this->getMoTotalCompra($co_compra);
            $Tb052Compras->setMontoTotal($monto_compra)->save($con);
            
            
            if($monto_compra==0){
                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($Tb052Compras->getCoSolicitud()));
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
                "msg" => 'Este registro no se puede borrar porque <br>se encuentra asociado a otros registros'
            ));
	}
        
         $this->setTemplate('eliminar');
      
  }  

  public function executeGuardarAhorroPatronal(sfWebRequest $request)
  {
      
        $mo_aporte         =  $this->getRequestParameter("mo_aporte");
        $tx_tipo_nomina    =  $this->getRequestParameter("tx_tipo_nomina");
        $co_solicitud      =  $this->getRequestParameter("co_solicitud");

        $tb137_control_serial = Tb137ControlSerialPeer::retrieveByPK(9);
        $serial = $tb137_control_serial->getNuSerial();  
        $tb137_control_serial->setNuSerial($serial+1);
        $tb137_control_serial->save();
            
        $Tb159AportePatronalNomina = new Tb159AportePatronalNomina();
        $Tb159AportePatronalNomina->setTxTipoNomina($tx_tipo_nomina);
        $Tb159AportePatronalNomina->setTxSerialNomina(date('Y-m').'-'.$serial);
        $Tb159AportePatronalNomina->setMoAporte(trim($mo_aporte));
        $Tb159AportePatronalNomina->setCoSolicitud(trim($co_solicitud));
        $Tb159AportePatronalNomina->setTxTipoAporte(85);

        $Tb159AportePatronalNomina->setFeAporte(date('Y-m-d'));
        $Tb159AportePatronalNomina->save();

        $this->data = json_encode(array(
                        "success" => true,
                        "msg" => 'EL ahorro patronal se guardo exitosamente!'
        ));

        $this->setTemplate('guardar');

  }


  
  public function executeGuardar(sfWebRequest $request)
  {
      
        $json_aporte                     =  $this->getRequestParameter("json_aporte");
        $tb160_solicitud_aporte_patronal =  $this->getRequestParameter("tb160_solicitud_aporte_patronal");
        $codigo                          =  $tb160_solicitud_aporte_patronal["co_compra"];
        
        $con = Propel::getConnection();
        if($codigo!=''||$codigo!=null){
            $tb052_compras = Tb052ComprasPeer::retrieveByPk($codigo);
        }else{
            $tb052_compras = new Tb052Compras();
        }
        try
        { 
            $con->beginTransaction();
            
            $tb052_compras->setCoUsuario($this->getUser()->getAttribute('codigo'));                                                                
            //$tb052_compras->setFechaCompra(date("Y-m-d"));
            if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
                $tb052_compras->setFechaCompra($this->getUser()->getAttribute('fe_cierre')); 
            }else{
                $tb052_compras->setFechaCompra(date("Y-m-d")); 
            }  
            $tb052_compras->setTxObservacion('PAGO DE APORTE PATRONAL');
            $tb052_compras->setCoSolicitud($tb160_solicitud_aporte_patronal["co_solicitud"]);        
            $tb052_compras->setCoTipoSolicitud(36);                                                        
            //$tb052_compras->setAnio(date('Y'));    
            $tb052_compras->setAnio($this->getUser()->getAttribute('ejercicio'));   
            $tb052_compras->setNuIva(0);        
            $tb052_compras->setMontoIva(0);
            $tb052_compras->setMontoSubTotal(0);        
            $tb052_compras->setMontoTotal($tb160_solicitud_aporte_patronal["mo_total"]);        
            $tb052_compras->setCoTipoMovimiento(0); 
            $tb052_compras->save($con);
            
            $listaAporte  = json_decode($json_aporte,true);
            
            foreach($listaAporte  as $aporteForm){                          
                if($aporteForm["co_detalle_compras"]==''){     
                    
                    list($co_aporte,$tx_descripcion) = explode("-", $aporteForm["tx_aporte_patronal"]);
                    
                    $tb053_detalle_compras = new Tb053DetalleCompras();
                    $tb053_detalle_compras->setCoCompras($tb052_compras->getCoCompras());                                        
                    $tb053_detalle_compras->setCoProducto($this->getCoProducto(trim($co_aporte)));
                    $tb053_detalle_compras->setNuCantidad(1);
                    $tb053_detalle_compras->setPrecioUnitario($aporteForm["monto"]);
                    $tb053_detalle_compras->setMonto($aporteForm["monto"]);
                    $tb053_detalle_compras->setDetalle($aporteForm["tx_aporte_patronal"].' '.$aporteForm["tx_aporte_patronal_nomina"]);
                    $tb053_detalle_compras->setInCalcularIva(false);
                    $tb053_detalle_compras->save($con);
                    
                    $tb159_aporte_patronal_nomina = Tb159AportePatronalNominaPeer::retrieveByPK($aporteForm["co_aporte_patronal_nomina"]);
                    $tb159_aporte_patronal_nomina->setCoSolicitud($tb160_solicitud_aporte_patronal["co_solicitud"]);
                    $tb159_aporte_patronal_nomina->setCoDetalleCompra($tb053_detalle_compras->getCoDetalleCompras());
                    $tb159_aporte_patronal_nomina->save($con);                    
                }
            }
            
            
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb160_solicitud_aporte_patronal["co_solicitud"]));
            $ruta->setInCargarDato(true)->save($con);

            $tb026_solicitud = Tb026SolicitudPeer::retrieveByPK($tb160_solicitud_aporte_patronal["co_solicitud"]);
            $tb026_solicitud->setCoProveedor($tb160_solicitud_aporte_patronal["co_proveedor"])->save($con);

            $con->commit();
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());  

            $this->data = json_encode(array(
                    "success" => true,
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
  
  public function executeAgregarAporte(sfWebRequest $request)
  {
       
  }

   public function executeAgregarAhorroPatronal(sfWebRequest $request)
  {
        $this->data = json_encode(array(
            "co_solicitud"        => $this->getRequestParameter('codigo')
        ));      

  }

 protected function getInPagado(){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->addAnd(Tb030RutaPeer::CO_PROCESO,4,Criteria::IN);
        $c->addAnd(Tb030RutaPeer::CO_ESTATUS_RUTA,2);    
        $c->add(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL,array($this->getUser()->getAttribute('ejercicio'),2020), Criteria::IN);
        $stmt = Tb026SolicitudPeer::doSelectStmt($c);

        $registros = array();
        $i=0;
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[$i]=$reg["co_solicitud"];
            $i++;
        }
        
        return $registros;
        
  }
  
  public function executeStorefknomina(sfWebRequest $request)
  {
        $json_aporte  = $this->getRequestParameter("json_aporte");
        $listaAporte  = json_decode($json_aporte,true);
        foreach($listaAporte  as $listaAporteForm){
           $array_aporte_patronal[$i] = $listaAporteForm["co_aporte_patronal_nomina"]; 
           $i++;
        }
        
        $c = new Criteria();
        $c->add(Tb159AportePatronalNominaPeer::TX_TIPO_APORTE,$this->getRequestParameter("tx_movimiento"));
        $c->add(Tb159AportePatronalNominaPeer::CO_APORTE_PATRONAL_NOMINA,$array_aporte_patronal,  Criteria::NOT_IN);
        $c->add(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL,array($this->getUser()->getAttribute('ejercicio'),2020), Criteria::IN);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD,Tb159AportePatronalNominaPeer::CO_SOLICITUD);
        $c->addAscendingOrderByColumn(Tb159AportePatronalNominaPeer::TX_SERIAL_NOMINA);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
          $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $this->getInPagado(), Criteria::IN);

       //echo $c->toString(); exit();
        $stmt = Tb159AportePatronalNominaPeer::doSelectStmt($c);
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
  
  public function executeStorelistaAporte(sfWebRequest $request)
  {
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb157AportePatronalPeer::TX_DESCRIPCION);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->addSelectColumn(Tb159AportePatronalNominaPeer::CO_APORTE_PATRONAL_NOMINA);
        $c->addSelectColumn(Tb159AportePatronalNominaPeer::TX_SERIAL_NOMINA);
        $c->addSelectColumn(Tb159AportePatronalNominaPeer::TX_TIPO_NOMINA);
        $c->addSelectColumn(Tb159AportePatronalNominaPeer::MO_APORTE);
        $c->addSelectColumn(Tb159AportePatronalNominaPeer::TX_TIPO_APORTE);
        $c->addJoin(Tb157AportePatronalPeer::TX_MOVIMIENTO, Tb159AportePatronalNominaPeer::TX_TIPO_APORTE);
        $c->addJoin(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS, Tb159AportePatronalNominaPeer::CO_DETALLE_COMPRA);
        $c->add(Tb053DetalleComprasPeer::CO_COMPRAS,$this->getRequestParameter("co_compra"));
        $c->addAscendingOrderByColumn(Tb159AportePatronalNominaPeer::CO_DETALLE_COMPRA);
        $stmt = Tb159AportePatronalNominaPeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            $reg["tx_aporte_patronal_nomina"]=$reg["tx_serial_nomina"].'-'.$reg["tx_tipo_nomina"];
            $reg["tx_aporte_patronal"]=$reg["tx_tipo_aporte"].'-'.$reg["tx_descripcion"];
            $reg["monto"]=$reg["mo_aporte"];
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
