<?php

/**
 * PrestacionSocial actions.
 *
 * @package    gobel
 * @subpackage PrestacionSocial
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class PrestacionSocialActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('PrestacionSocial', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('PrestacionSocial', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("co_solicitud");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tb191PrestacionSocialPeer::CO_SOLICITUD,$codigo);
        $stmt = Tb191PrestacionSocialPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $c_compra = new Criteria();
        $c_compra->add(Tb052ComprasPeer::CO_SOLICITUD,$codigo);
        $stmt_compra = Tb052ComprasPeer::doSelectStmt($c_compra);
        $campos_compra = $stmt_compra->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            //"co_solicitud"     => $campos["co_solicitud"],
                            "co_solicitud"     => $this->getRequestParameter("co_solicitud"),
                            "co_usuario"     => $campos["co_usuario"],
                            "co_documento"     => $campos["co_documento"],
                            "nu_documento"     => $campos["nu_documento"],
                            "nb_persona"     => $campos["nb_persona"],
                            "ap_persona"     => $campos["ap_persona"],
                            "co_tipo_trabajador"     => $campos["co_tipo_trabajador"],
                            "co_ejecutor"     => $campos["co_ejecutor"],
                            "co_situacion_trabajador"     => $campos["co_situacion_trabajador"],
                            "fe_ingreso"     => $campos["fe_ingreso"],
                            "fe_egreso"     => $campos["fe_egreso"],
                            "fe_movimiento"     => $campos["fe_movimiento"],
                            "de_observacion"     => $campos["de_observacion"],
                            //"mo_pago"     => $campos["mo_pago"],
                            "mo_pago"     => ($campos["mo_pago"]==null)?0:$campos["mo_pago"],
                            "co_proveedor"     => $campos["co_proveedor"],
                            "co_compras"     => $campos_compra["co_compras"],
                            "co_prestacion_causa_retiro"     => $campos["co_prestacion_causa_retiro"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "co_solicitud"     => $this->getRequestParameter("co_solicitud"),
                            "co_usuario"     => "",
                            "co_documento"     => "",
                            "nu_documento"     => "",
                            "nb_persona"     => "",
                            "ap_persona"     => "",
                            "co_tipo_trabajador"     => "",
                            "co_ejecutor"     => "",
                            "co_situacion_trabajador"     => "",
                            "fe_ingreso"     => "",
                            "fe_egreso"     => "",
                            "fe_movimiento"     => "",
                            "de_observacion"     => "",
                            "co_prestacion_causa_retiro"     => "",
                            "mo_pago"     => 0,
                    ));
    }

  }

  public function executeAgregar(sfWebRequest $request)
  {   
    $this->data = json_encode(array(
        "co_solicitud"      => $this->getRequestParameter('co_solicitud'),
    ));
  }

  public function executeAgregarTercero(sfWebRequest $request)
  {   
    $this->data = json_encode(array(
        "co_solicitud"      => $this->getRequestParameter('co_solicitud'),
    ));
  }

  
  public function executeGuardar(sfWebRequest $request)
  {

    $codigo = $this->getRequestParameter("id");

    $co_compra = $this->getRequestParameter("co_compras");
    $json_detalle      = $this->getRequestParameter("json_detalle");
    $listaDetalle  = json_decode($json_detalle,true);
    $json_detalle_tercero      = $this->getRequestParameter("json_detalle_tercero");
    $listaDetalle_tercero  = json_decode($json_detalle_tercero,true);    
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb191_prestacion_social = Tb191PrestacionSocialPeer::retrieveByPk($codigo);
     }else{
         $tb191_prestacion_social = new Tb191PrestacionSocial();
     }
     if($co_compra!=''||$co_compra!=null){
        $tb052_compras = Tb052ComprasPeer::retrieveByPk($co_compra);
    }else{
        $tb052_compras = new Tb052Compras();
    }
     try
      { 
        $con->beginTransaction();
       
        $tb191_prestacion_socialForm = $this->getRequestParameter('tb191_prestacion_social');
/*CAMPOS*/
                                                        
        /*Campo tipo BIGINT */
        $tb191_prestacion_social->setCoSolicitud($tb191_prestacion_socialForm["co_solicitud"]);
                                                        
        /*Campo tipo BIGINT */
        $tb191_prestacion_social->setCoUsuario($this->getUser()->getAttribute('codigo'));
                                                        
        /*Campo tipo BIGINT */
        $tb191_prestacion_social->setCoDocumento($tb191_prestacion_socialForm["co_documento"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb191_prestacion_social->setNuDocumento($tb191_prestacion_socialForm["nu_documento"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb191_prestacion_social->setNbPersona($tb191_prestacion_socialForm["nb_persona"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb191_prestacion_social->setApPersona($tb191_prestacion_socialForm["ap_persona"]);
                                                        
        /*Campo tipo BIGINT */
        $tb191_prestacion_social->setCoTipoTrabajador($tb191_prestacion_socialForm["co_tipo_trabajador"]);
                                                        
        /*Campo tipo BIGINT */
        $tb191_prestacion_social->setCoEjecutor($tb191_prestacion_socialForm["co_ejecutor"]);
                                                        
        /*Campo tipo BIGINT */
        $tb191_prestacion_social->setCoSituacionTrabajador($tb191_prestacion_socialForm["co_situacion_trabajador"]);
        
        $tb191_prestacion_social->setCoPrestacionCausaRetiro($tb191_prestacion_socialForm["co_prestacion_causa_retiro"]);        
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb191_prestacion_socialForm["fe_ingreso"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb191_prestacion_social->setFeIngreso($fecha);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb191_prestacion_socialForm["fe_egreso"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb191_prestacion_social->setFeEgreso($fecha);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb191_prestacion_socialForm["fe_movimiento"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb191_prestacion_social->setFeMovimiento($fecha);
                                                        
        /*Campo tipo VARCHAR */
        $tb191_prestacion_social->setDeObservacion($tb191_prestacion_socialForm["de_observacion"]);
                                                        
        /*Campo tipo NUMERIC */
        //$tb191_prestacion_social->setMoPago($tb191_prestacion_socialForm["mo_pago"]);

        /*Campo tipo BIGINT */
        $tb191_prestacion_social->setCoProveedor($tb191_prestacion_socialForm["co_proveedor"]);
                                
        /*CAMPOS*/
        $tb191_prestacion_social->save($con);

        $tb026_solicitud = Tb026SolicitudPeer::retrieveByPk($tb191_prestacion_socialForm["co_solicitud"]);
        $tb026_solicitud->setCoProveedor($tb191_prestacion_socialForm["co_proveedor"])->save($con);

        $tb052_compras->setCoUsuario($this->getUser()->getAttribute('codigo'));                                                                
        //$tb052_compras->setFechaCompra(date("Y-m-d"));
        if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
            $tb052_compras->setFechaCompra($this->getUser()->getAttribute('fe_cierre')); 
        }else{
            $tb052_compras->setFechaCompra(date("Y-m-d")); 
        }  
        $tb052_compras->setTxObservacion('PAGO DE PRESTACIONES SOCIALES');
        $tb052_compras->setCoSolicitud($tb191_prestacion_socialForm["co_solicitud"]);        
        $tb052_compras->setCoTipoSolicitud(43);                                                    
        $tb052_compras->setAnio( $this->getUser()->getAttribute('ejercicio'));     
        $tb052_compras->setNuIva(0);        
        $tb052_compras->setMontoIva(0);
        //$tb052_compras->setMontoSubTotal(0);
        //$tb052_compras->setMontoTotal($tb191_prestacion_socialForm["mo_pago"]);             
        $tb052_compras->setCoProveedor($tb191_prestacion_socialForm["co_proveedor"]);      
        $tb052_compras->setCoTipoMovimiento(0); 
        $tb052_compras->save($con);

        $wherec = new Criteria();
        $wherec->add(Tb053DetalleComprasPeer::CO_COMPRAS, $tb052_compras->getCoCompras(), Criteria::EQUAL);
        $stmtw = Tb053DetalleComprasPeer::doSelectStmt($wherec);
        while($resw = $stmtw->fetch(PDO::FETCH_ASSOC)){
            $wherem = new Criteria();
            $wherem->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $resw["co_detalle_compras"], Criteria::EQUAL);
            BasePeer::doDelete($wherem, $con);
        }
        BasePeer::doDelete($wherec, $con);

        $total_pagar = 0;
        $total_asignacion = 0;
        $total_deduccion = 0;
        foreach($listaDetalle  as $v){
        
            //if($v["co_detalle_compras"]==''){

                if($v["co_unidad_producto"]==639){
                    $in_presupuesto = TRUE;
                }else{
                    $in_presupuesto = FALSE;
                }

                $tb053_detalle_compras = new Tb053DetalleCompras();
                $tb053_detalle_compras->setCoCompras($tb052_compras->getCoCompras());
                $tb053_detalle_compras->setNuCantidad(1);
                $tb053_detalle_compras->setPrecioUnitario($v["mo_pago"]);
                $tb053_detalle_compras->setMonto($v["mo_pago"]);
                $tb053_detalle_compras->setDetalle($v["tx_producto"]);
                $tb053_detalle_compras->setCoProducto($v["co_producto"]);
                $tb053_detalle_compras->setCoUnidadProducto($v["co_unidad_producto"]);
                $tb053_detalle_compras->setInPresupuesto($in_presupuesto);
                //$tb053_detalle_compras->setCoPresupuesto($reg["id"]);
                $tb053_detalle_compras->save($con);

                $total_asignacion = $total_asignacion+$v["mo_asignacion"];
                $total_deduccion = $total_deduccion+$v["mo_deduccion"];
                //$total_pagar = $total_pagar+$v["mo_pago"];
                $total_pagar = $total_asignacion-$total_deduccion;

                $con->commit();

            //}
                
        }

        $where_detalle = new Criteria();
        $where_detalle->add(Tb053DetalleComprasPeer::CO_COMPRAS, $tb052_compras->getCoCompras());
        $where_detalle->add(Tb053DetalleComprasPeer::CO_PRODUCTO, 19765);
        $stmt_compra = Tb053DetalleComprasPeer::doSelectStmt($where_detalle);
        $campos_compra = $stmt_compra->fetch(PDO::FETCH_ASSOC);

        $deduccion_detalle = $campos_compra['precio_unitario'] - $total_deduccion;

        $updc = new Criteria();
        $updc->add(Tb053DetalleComprasPeer::MONTO, $deduccion_detalle);
        BasePeer::doUpdate($where_detalle, $updc, $con); 

        $tb191_prestacion_social->setMoPago($total_pagar);
        $tb191_prestacion_social->save($con);
        
        $where_re = new Criteria();
        $where_re->add(Tb198PrestacionTercerosPeer::CO_SOLICITUD, $tb191_prestacion_socialForm["co_solicitud"], Criteria::EQUAL);
        BasePeer::doDelete($where_re, $con);   
        
        $where_retencion = new Criteria();
        $where_retencion->add(Tb046FacturaRetencionPeer::CO_SOLICITUD, $tb191_prestacion_socialForm["co_solicitud"], Criteria::EQUAL);
        BasePeer::doDelete($where_retencion, $con);          
        
        foreach($listaDetalle_tercero  as $vt){

                $tb198_prestacion_tercero = new Tb198PrestacionTerceros();
                $tb198_prestacion_tercero->setNuCedula($vt["nu_cedula"]);
                $tb198_prestacion_tercero->setNombre($vt["nombre"]);
                $tb198_prestacion_tercero->setNuCuenta($vt["nu_cuenta"]!=''?$vt["nu_cuenta"]:NULL);
                $tb198_prestacion_tercero->setPorcentaje($vt["porcentaje"]);
                $tb198_prestacion_tercero->setMoPagar($vt["mo_pagar"]);
                $tb198_prestacion_tercero->setCoSolicitud($tb191_prestacion_socialForm["co_solicitud"]);
                $tb198_prestacion_tercero->save($con);
                
                $tb046_factura_retencion = new Tb046FacturaRetencion();
                $tb046_factura_retencion->setCoTipoRetencion(165);
                $tb046_factura_retencion->setPoRetencion($vt["porcentaje"]);
                $tb046_factura_retencion->setMoRetencion($vt["mo_pagar"]);
                $tb046_factura_retencion->setCoSolicitud($tb191_prestacion_socialForm["co_solicitud"]);
                $tb046_factura_retencion->save($con);                  
                $total_pagar = $total_asignacion-$total_deduccion;
                $con->commit();

            $total_retenciones = $total_retenciones + $vt["mo_pagar"];
                
        }
        
        $sub_total = $total_pagar - $total_retenciones;
        $tb052_compras->setMontoSubTotal($sub_total);
        $tb052_compras->setMontoTotal($total_pagar);
        $tb052_compras->save($con); 
        
      

        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Prestacion cargada exitosamente'
        ));

        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb191_prestacion_socialForm["co_solicitud"]));
        $ruta->setInCargarDato(true)->save($con);
        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

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

  public function executeLista(sfWebRequest $request)
  {

  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $co_solicitud      =   $this->getRequestParameter("co_solicitud");
            $co_usuario      =   $this->getRequestParameter("co_usuario");
            $co_documento      =   $this->getRequestParameter("co_documento");
            $nu_documento      =   $this->getRequestParameter("nu_documento");
            $nb_persona      =   $this->getRequestParameter("nb_persona");
            $ap_persona      =   $this->getRequestParameter("ap_persona");
            $co_tipo_trabajador      =   $this->getRequestParameter("co_tipo_trabajador");
            $co_ejecutor      =   $this->getRequestParameter("co_ejecutor");
            $co_situacion_trabajador      =   $this->getRequestParameter("co_situacion_trabajador");
            $fe_ingreso      =   $this->getRequestParameter("fe_ingreso");
            $fe_egreso      =   $this->getRequestParameter("fe_egreso");
            $fe_movimiento      =   $this->getRequestParameter("fe_movimiento");
            $de_observacion      =   $this->getRequestParameter("de_observacion");
            $mo_pago      =   $this->getRequestParameter("mo_pago");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                            
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb191PrestacionSocialPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb191PrestacionSocialPeer::updated_at,$fecha);
    }
                                            if($co_solicitud!=""){$c->add(Tb191PrestacionSocialPeer::co_solicitud,$co_solicitud);}
    
                                            if($co_usuario!=""){$c->add(Tb191PrestacionSocialPeer::co_usuario,$co_usuario);}
    
                                            if($co_documento!=""){$c->add(Tb191PrestacionSocialPeer::co_documento,$co_documento);}
    
                                        if($nu_documento!=""){$c->add(Tb191PrestacionSocialPeer::nu_documento,'%'.$nu_documento.'%',Criteria::LIKE);}
        
                                        if($nb_persona!=""){$c->add(Tb191PrestacionSocialPeer::nb_persona,'%'.$nb_persona.'%',Criteria::LIKE);}
        
                                        if($ap_persona!=""){$c->add(Tb191PrestacionSocialPeer::ap_persona,'%'.$ap_persona.'%',Criteria::LIKE);}
        
                                            if($co_tipo_trabajador!=""){$c->add(Tb191PrestacionSocialPeer::co_tipo_trabajador,$co_tipo_trabajador);}
    
                                            if($co_ejecutor!=""){$c->add(Tb191PrestacionSocialPeer::co_ejecutor,$co_ejecutor);}
    
                                            if($co_situacion_trabajador!=""){$c->add(Tb191PrestacionSocialPeer::co_situacion_trabajador,$co_situacion_trabajador);}
    
                                    
        if($fe_ingreso!=""){
    list($dia, $mes,$anio) = explode("/",$fe_ingreso);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb191PrestacionSocialPeer::fe_ingreso,$fecha);
    }
                                    
        if($fe_egreso!=""){
    list($dia, $mes,$anio) = explode("/",$fe_egreso);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb191PrestacionSocialPeer::fe_egreso,$fecha);
    }
                                    
        if($fe_movimiento!=""){
    list($dia, $mes,$anio) = explode("/",$fe_movimiento);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb191PrestacionSocialPeer::fe_movimiento,$fecha);
    }
                                        if($de_observacion!=""){$c->add(Tb191PrestacionSocialPeer::de_observacion,'%'.$de_observacion.'%',Criteria::LIKE);}
        
                                            if($mo_pago!=""){$c->add(Tb191PrestacionSocialPeer::mo_pago,$mo_pago);}
    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb191PrestacionSocialPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb191PrestacionSocialPeer::ID);
        
    $stmt = Tb191PrestacionSocialPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "co_solicitud"     => trim($res["co_solicitud"]),
            "co_usuario"     => trim($res["co_usuario"]),
            "co_documento"     => trim($res["co_documento"]),
            "nu_documento"     => trim($res["nu_documento"]),
            "nb_persona"     => trim($res["nb_persona"]),
            "ap_persona"     => trim($res["ap_persona"]),
            "co_tipo_trabajador"     => trim($res["co_tipo_trabajador"]),
            "co_ejecutor"     => trim($res["co_ejecutor"]),
            "co_situacion_trabajador"     => trim($res["co_situacion_trabajador"]),
            "fe_ingreso"     => trim($res["fe_ingreso"]),
            "fe_egreso"     => trim($res["fe_egreso"]),
            "fe_movimiento"     => trim($res["fe_movimiento"]),
            "de_observacion"     => trim($res["de_observacion"]),
            "mo_pago"     => trim($res["mo_pago"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

    public function executeStorelistadetalle(sfWebRequest $request)
    {
        $paginar    =   $this->getRequestParameter("paginar");
        $limit      =   $this->getRequestParameter("limit",20);
        $start      =   $this->getRequestParameter("start",0);

        $co_solicitud      =   $this->getRequestParameter("co_solicitud");
        $co_compras      =   $this->getRequestParameter("co_compras");

        $c = new Criteria();
        $c->setIgnoreCase(true);
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->addSelectColumn(Tb053DetalleComprasPeer::DETALLE);
        $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
        $c->addSelectColumn(Tb053DetalleComprasPeer::PRECIO_UNITARIO);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::CO_CLASE);
        $c->addSelectColumn(Tb048ProductoPeer::CO_UNIDAD_PRODUCTO);
        $c->addJoin(Tb053DetalleComprasPeer::CO_PRODUCTO, Tb048ProductoPeer::CO_PRODUCTO);
        $c->add(Tb053DetalleComprasPeer::CO_COMPRAS,$co_compras);
        $cantidadTotal = Tb053DetalleComprasPeer::doCount($c);

        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
          
      $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);
      $registros = "";
      while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
          if($res["co_unidad_producto"]==639){
                //$mo_asignacion = $res["monto"];
                $mo_asignacion = $res["precio_unitario"];
                $mo_deduccion = 0;
          }else{
                $mo_deduccion = $res["monto"];
                $mo_asignacion = 0;
          }
      $registros[] = array(
              "co_detalle_compras"     => trim($res["co_detalle_compras"]),
              "tx_producto"     => trim($res["detalle"]),
              "co_producto"     => trim($res["co_producto"]),
              "mo_pago"     => trim($res["precio_unitario"]),
              "co_clase"     => trim($res["co_clase"]),
              "co_unidad_producto"     => trim($res["co_unidad_producto"]),
              "mo_asignacion"     => trim($mo_asignacion),
              "mo_deduccion"     => trim($mo_deduccion),
          );
      }
  
      $this->data = json_encode(array(
          "success"   =>  true,
          "total"     =>  $cantidadTotal,
          "data"      =>  $registros
          ));
      }
      
    public function executeStorelistadetalletercero(sfWebRequest $request)
    {
        $paginar    =   $this->getRequestParameter("paginar");
        $limit      =   $this->getRequestParameter("limit",20);
        $start      =   $this->getRequestParameter("start",0);

        $co_solicitud      =   $this->getRequestParameter("co_solicitud");

        $c = new Criteria();
        $c->setIgnoreCase(true);
        $c->clearSelectColumns();
        $c->add(Tb198PrestacionTercerosPeer::CO_SOLICITUD,$co_solicitud);
        $cantidadTotal = Tb198PrestacionTercerosPeer::doCount($c);

        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb198PrestacionTercerosPeer::CO_PRESTACION_TERCEROS);
          
      $stmt = Tb198PrestacionTercerosPeer::doSelectStmt($c);
      $registros = "";
      while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
      $registros[] = array(
              "co_prestacion_terceros"     => trim($res["co_prestacion_terceros"]),
              "nu_cedula"     => trim($res["nu_cedula"]),
              "nombre"     => trim($res["nombre"]),
              "nu_cuenta"     => trim($res["nu_cuenta"]),
              "porcentaje"     => trim($res["porcentaje"]),
              "mo_pagar"     => trim($res["mo_pagar"]),
              "co_solicitud"     => trim($res["co_solicitud"]),
          );
      }
  
      $this->data = json_encode(array(
          "success"   =>  true,
          "total"     =>  $cantidadTotal,
          "data"      =>  $registros
          ));
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

    public function executeStorefkcotipotrabajador(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb193NominaTrabajadorPeer::doSelectStmt($c);
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

    public function executeStorefkcoejecutor(sfWebRequest $request){
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb082EjecutorPeer::NU_EJECUTOR);
        $stmt = Tb082EjecutorPeer::doSelectStmt($c);
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

    public function executeStorefkcosituaciontrabajador(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb192SituacionEmpleadoPeer::doSelectStmt($c);
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
    
    public function executeStorefkcoprestacionretiro(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb199PrestacionCausaRetiroPeer::doSelectStmt($c);
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

    public function executeProveedor(sfWebRequest $request){

        $co_documento      =   $this->getRequestParameter("co_documento");
        $nu_documento      =   $this->getRequestParameter("nu_documento");

        $c = new Criteria();
        $c->add(Tb008ProveedorPeer::CO_DOCUMENTO, $co_documento);
        $c->add(Tb008ProveedorPeer::TX_RIF, $nu_documento);
        $stmt = Tb008ProveedorPeer::doSelectStmt($c);

        $registros = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));

        $this->setTemplate('store');
    }

    public function executeStorefkcoclase(sfWebRequest $request) {

        $c = new Criteria();  
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb092ClaseProductoPeer::ID);
        $c->addSelectColumn(Tb092ClaseProductoPeer::DE_CLASE_PRODUCTO);
        $c->add(Tb092ClaseProductoPeer::ID, array( 55, 56, 57), Criteria::IN); 

        $cantidadTotal = Tb092ClaseProductoPeer::doCount($c);

        $c->addAscendingOrderByColumn(Tb092ClaseProductoPeer::ID);

        $stmt = Tb092ClaseProductoPeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));

        $this->setTemplate('store');
    }

    public function executeStorefkcoproducto(sfWebRequest $request) {

        $co_clase  = $this->getRequestParameter("co_clase");

        $c = new Criteria();  
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
        $c->addSelectColumn(Tb048ProductoPeer::CO_UNIDAD_PRODUCTO);
        //$c->add(Tb048ProductoPeer::CO_PRODUCTO, array( 19763, 19764), Criteria::IN); 
        $c->add(Tb048ProductoPeer::CO_CLASE, array( $co_clase), Criteria::IN); 

        $cantidadTotal = Tb048ProductoPeer::doCount($c);

        $c->addAscendingOrderByColumn(Tb048ProductoPeer::COD_PRODUCTO);

        $stmt = Tb048ProductoPeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));

        $this->setTemplate('store');
    }

    public function executeEliminar(sfWebRequest $request){
      
        $co_solicitud  = $this->getRequestParameter("co_solicitud");
        $co_detalle_compras  = $this->getRequestParameter("co_detalle_compras");
	
        $con = Propel::getConnection();
	    try
	    { 
            $con->beginTransaction();             
            
            $Tb053DetalleCompras = Tb053DetalleComprasPeer::retrieveByPk($co_detalle_compras);            
            $Tb053DetalleCompras->delete($con);
            
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
            $ruta->setInCargarDato(false)->save($con);
            
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
                "msg" =>  $e->getMessage()
                    //  "msg" => 'Este registro no se puede borrar'
                    ));
            }
        
         $this->setTemplate('eliminar');
      
    } 
    
    public function executeEliminarTercero(sfWebRequest $request){
      
        $co_solicitud  = $this->getRequestParameter("co_solicitud");
        $co_factura_retencion  = $this->getRequestParameter("co_factura_retencion");
	
        $con = Propel::getConnection();
	    try
	    { 
            $con->beginTransaction();             
            
            $Tb046FacturaRetencion = Tb046FacturaRetencionPeer::retrieveByPk($co_factura_retencion);            
            $Tb046FacturaRetencion->delete($con);
            
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
            $ruta->setInCargarDato(false)->save($con);
            
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
                "msg" =>  $e->getMessage()
                    //  "msg" => 'Este registro no se puede borrar'
                    ));
            }
        
         $this->setTemplate('eliminar');
      
    }     
}