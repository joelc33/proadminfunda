<?php

/**
 * autoViatico actions.
 * NombreClaseModel(Tb108Viatico)
 * NombreTabla(tb108_viatico)
 * @package    ##PROJECT_NAME##
 * @subpackage autoViatico
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class ViaticoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Viaticoss', 'lista');
  }

  public function executeAgregar(sfWebRequest $request)
  {

  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Viaticoss', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("co_solicitud");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tb108ViaticoPeer::CO_SOLICITUD,$codigo);

        $stmt = Tb108ViaticoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_viatico"                => $campos["co_viatico"],
                            "co_tipo_viatico"           => $campos["co_tipo_viatico"],
                            "tx_evento"                 => $campos["tx_evento"],
                            "tx_direccion"              => $campos["tx_direccion"],
                            "in_empleado"               => $campos["in_empleado"],
                            "co_origen"                 => $campos["co_origen"],
                            "co_destino"                => $campos["co_destino"],
                            "fe_desde"                  => $campos["fe_desde"],
                            "fe_hasta"                  => $campos["fe_hasta"],
                            "in_hospedaje"              => $campos["in_hospedaje"],
                            "tx_observacion_hospedaje"  => $campos["tx_observacion_hospedaje"],
                            "co_tipo_traslado"          => $campos["co_tipo_traslado"],
                            "co_solicitud"              => $this->getRequestParameter("co_solicitud"),
                            "co_proveedor"              => $campos["co_proveedor"],
                            "co_categoria"              => $campos["co_categoria"]
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_viatico"                => "",
                            "co_tipo_viatico"           => "",
                            "tx_evento"                 => "",
                            "tx_direccion"              => "",
                            "in_empleado"               => "",
                            "co_origen"                 => "",
                            "co_destino"                => "",
                            "fe_desde"                  => "",
                            "fe_hasta"                  => "",
                            "in_hospedaje"              => "",
                            "tx_observacion_hospedaje"  => "",
                            "co_tipo_traslado"          => "",
                            "co_proveedor"              => "",
                            "co_solicitud"              => $this->getRequestParameter("co_solicitud"),
                            "co_categoria"              => ""
                    ));
    }

  }

  protected function dateDiff($start, $end) {

    $start_ts = strtotime($start);

    $end_ts = strtotime($end);

    $diff = $end_ts - $start_ts;

    return round($diff / 86400);

  }

  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_viatico");
     $co_proveedor = $this->getRequestParameter("co_proveedor");
     $json_detalle = $this->getRequestParameter("json_detalle");

     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb108_viatico = Tb108ViaticoPeer::retrieveByPk($codigo);
     }else{
         $tb108_viatico = new Tb108Viatico();
     }
     try
      {
        $con->beginTransaction();


        $tb109_personaForm = $this->getRequestParameter('tb109_persona');

        if($co_proveedor!=''||$co_proveedor!=null){
            $tb008_proveedor = Tb008ProveedorPeer::retrieveByPk($co_proveedor);
            
            $cp = new Criteria();
            $cp->add(Tb109PersonaPeer::CO_PROVEEDOR,$co_proveedor);
            $cant = Tb109PersonaPeer::doCount($cp);
            
            if($cant==0){
                $tb109_persona   = new Tb109Persona();
            }else{
                $tb109_persona   = Tb109PersonaPeer::retrieveByPk($co_proveedor);
            }
            
            
        }else{

            /*$c = new Criteria();
            $c->setLimit(1);
            $c->addAscendingOrderByColumn(Tb008Proveedor::NU_CODIGO);
            $stmt = Tb008Proveedor::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $correlativo = $campos["nu_codigo"]+1;
            $nu_codigo = str_pad($correlativo, 6, "0", STR_PAD_LEFT);*/

            $tb008_proveedor = new Tb008Proveedor();
            $tb109_persona   = new Tb109Persona();

            //$tb008_proveedor->setNuCodigo($nu_codigo);

        }

        $tb008_proveedor->setCoDocumento($tb109_personaForm["co_documento"]);
        $tb008_proveedor->setTxRazonSocial($tb109_personaForm["nb_persona"]);
        $tb008_proveedor->setTxRif($tb109_personaForm["nu_cedula"]);
        $tb008_proveedor->save($con);

        $tb109_persona->setCoProveedor($tb008_proveedor->getCoProveedor());
        $tb109_persona->setCoCargo($tb109_personaForm["co_cargo"]);
        $tb109_persona->setNuCelular($tb109_personaForm["nu_celular"]);
        $tb109_persona->setNuExtension($tb109_personaForm["nu_extension"]);
        $tb109_persona->save($con);

        $tb108_viaticoForm = $this->getRequestParameter('tb108_viatico');
        $tb108_viatico->setCoTipoViatico($tb108_viaticoForm["co_tipo_viatico"]);
        $tb108_viatico->setTxEvento($tb108_viaticoForm["tx_evento"]);
        $tb108_viatico->setTxDireccion($tb108_viaticoForm["tx_direccion"]);

        if (array_key_exists("in_empleado", $tb108_viaticoForm)){
            $tb108_viatico->setInEmpleado(true);
        }else{
            $tb108_viatico->setInEmpleado(false);
        }

        $tb108_viatico->setCoOrigen($tb108_viaticoForm["co_origen"]);
        $tb108_viatico->setCoDestino($tb108_viaticoForm["co_destino"]);

        list($dia, $mes, $anio) = explode("/",$tb108_viaticoForm["fe_desde"]);
        $fecha_desde = $anio."-".$mes."-".$dia;
        $tb108_viatico->setFeDesde($fecha_desde);

        list($dia, $mes, $anio) = explode("/",$tb108_viaticoForm["fe_hasta"]);
        $fecha_hasta = $anio."-".$mes."-".$dia;
        $tb108_viatico->setFeHasta($fecha_hasta);
        $tb108_viatico->setCoSolicitud($tb108_viaticoForm["co_solicitud"]);
        $tb108_viatico->setCoCategoria($tb108_viaticoForm["co_categoria"]);
        $tb108_viatico->setCoUsuario($this->getUser()->getAttribute('codigo'));
        $tb108_viatico->setCoProveedor($tb008_proveedor->getCoProveedor());

        $tb026_solicitud = Tb026SolicitudPeer::retrieveByPK($tb108_viaticoForm["co_solicitud"]);
        $tb026_solicitud->setCoProveedor($tb008_proveedor->getCoProveedor())->save($con);

        $wherec = new Criteria();
        $wherec->add(Tb117DetalleViaticoPeer::CO_SOLICITUD, $tb108_viaticoForm["co_solicitud"], Criteria::EQUAL);
        BasePeer::doDelete($wherec, $con);


        $listaItem  = json_decode($json_detalle,true);
        $array = array();
        $i=0;
        foreach($listaItem  as $v){


            $Tb117DetalleViatico = new Tb117DetalleViatico();
            $cant_dia = $this->dateDiff($fecha_desde,$fecha_hasta);


            $Tb117DetalleViatico->setCoSolicitud($tb108_viaticoForm["co_solicitud"])
                                ->setCoItemViatico($v["co_item_viatico"])
                                ->setTxObservacion($v["tx_observacion"])
                                ->setCantDia($cant_dia)
                                ->setCantUt($v["cant_ut"])
                                ->save($con);

            $i++;

        }

        if($i>0){
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb108_viaticoForm["co_solicitud"]));
            $co_ruta = $ruta->getCoRuta();
            $ruta->setInCargarDato(true)->save($con);
            
             
        }else{
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb108_viaticoForm["co_solicitud"]));
            $ruta->setInCargarDato(false)->save($con);
        }

        
        $tb108_viatico->save($con);
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente'
                ));

        $con->commit();
        Tb030RutaPeer::getGenerarReporte($co_ruta); 

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
	$codigo = $this->getRequestParameter("co_detalle_viatico");
	$con = Propel::getConnection();
	try
	{
	$con->beginTransaction();
	/*CAMPOS*/
	$Tb117DetalleViatico = Tb117DetalleViaticoPeer::retrieveByPk($codigo);
	$Tb117DetalleViatico->delete($con);
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



  public function executeStorelistaDetalle(sfWebRequest $request)
  {

        $co_solicitud      = $this->getRequestParameter("co_solicitud");
        $co_tipo_viatico = $this->getRequestParameter("co_tipo_viatico");
        $co_categoria      = $this->getRequestParameter("co_categoria");

        if($co_solicitud == ''){
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb114ItemViaticoPeer::CO_ITEM_VIATICO);
            $c->addSelectColumn(Tb114ItemViaticoPeer::TX_ITEM_VIATICO);
            $c->addSelectColumn(Tb119CategoriaItemViaticoPeer::CANT_UT);
            $c->addJoin(Tb119CategoriaItemViaticoPeer::CO_ITEM_VIATICO, Tb114ItemViaticoPeer::CO_ITEM_VIATICO);
            $c->add(Tb119CategoriaItemViaticoPeer::CO_CATEGORIA,$co_categoria);
            $c->add(Tb119CategoriaItemViaticoPeer::CO_TIPO_VIATICO,$co_tipo_viatico);

            $c->addAscendingOrderByColumn(Tb114ItemViaticoPeer::CO_ITEM_VIATICO);

            $stmt = Tb114ItemViaticoPeer::doSelectStmt($c);
            $registros = "";
            while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
                $registros[] = $res;
            }

        }else{
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb117DetalleViaticoPeer::CO_DETALLE_VIATICO);
            $c->addSelectColumn(Tb114ItemViaticoPeer::CO_ITEM_VIATICO);
            $c->addSelectColumn(Tb114ItemViaticoPeer::TX_ITEM_VIATICO);
            $c->addSelectColumn(Tb117DetalleViaticoPeer::TX_OBSERVACION);
            $c->addSelectColumn(Tb117DetalleViaticoPeer::CANT_UT);
            $c->addSelectColumn(Tb117DetalleViaticoPeer::CANT_DIA);
            $c->addJoin(Tb117DetalleViaticoPeer::CO_ITEM_VIATICO, Tb114ItemViaticoPeer::CO_ITEM_VIATICO);
            $c->add(Tb117DetalleViaticoPeer::CO_SOLICITUD,$co_solicitud);
            $cantidadTotal = Tb117DetalleViaticoPeer::doCount($c);

            $c->addAscendingOrderByColumn(Tb114ItemViaticoPeer::CO_ITEM_VIATICO);

            $stmt = Tb114ItemViaticoPeer::doSelectStmt($c);
            $registros = "";
            $valor_ut = Tb118UnidadTributariaPeer::getUT();
            while($res = $stmt->fetch(PDO::FETCH_ASSOC)){

                $res["mo_total"] = $res["cant_ut"]*$res["cant_dia"]*$valor_ut;

                $registros[] = $res;
            }
        }



        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));

        $this->setTemplate("storelista");

    }



  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $co_tipo_viatico      =   $this->getRequestParameter("co_tipo_viatico");
            $tx_evento      =   $this->getRequestParameter("tx_evento");
            $tx_direccion      =   $this->getRequestParameter("tx_direccion");
            $in_empleado      =   $this->getRequestParameter("in_empleado");
            $co_origen      =   $this->getRequestParameter("co_origen");
            $co_destino      =   $this->getRequestParameter("co_destino");
            $fe_desde      =   $this->getRequestParameter("fe_desde");
            $fe_hasta      =   $this->getRequestParameter("fe_hasta");
            $in_hospedaje      =   $this->getRequestParameter("in_hospedaje");
            $tx_observacion_hospedaje      =   $this->getRequestParameter("tx_observacion_hospedaje");
            $co_tipo_traslado      =   $this->getRequestParameter("co_tipo_traslado");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_tipo_viatico!=""){$c->add(Tb108ViaticoPeer::co_tipo_viatico,$co_tipo_viatico);}

                                        if($tx_evento!=""){$c->add(Tb108ViaticoPeer::tx_evento,'%'.$tx_evento.'%',Criteria::LIKE);}

                                        if($tx_direccion!=""){$c->add(Tb108ViaticoPeer::tx_direccion,'%'.$tx_direccion.'%',Criteria::LIKE);}


                                            if($co_origen!=""){$c->add(Tb108ViaticoPeer::co_origen,$co_origen);}

                                            if($co_destino!=""){$c->add(Tb108ViaticoPeer::co_destino,$co_destino);}


        if($fe_desde!=""){
    list($dia, $mes,$anio) = explode("/",$fe_desde);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb108ViaticoPeer::fe_desde,$fecha);
    }

        if($fe_hasta!=""){
    list($dia, $mes,$anio) = explode("/",$fe_hasta);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb108ViaticoPeer::fe_hasta,$fecha);
    }

                                        if($tx_observacion_hospedaje!=""){$c->add(Tb108ViaticoPeer::tx_observacion_hospedaje,'%'.$tx_observacion_hospedaje.'%',Criteria::LIKE);}

                                            if($co_tipo_traslado!=""){$c->add(Tb108ViaticoPeer::co_tipo_traslado,$co_tipo_traslado);}

                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb108ViaticoPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb108ViaticoPeer::CO_VIATICO);

    $stmt = Tb108ViaticoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_viatico"     => trim($res["co_viatico"]),
            "co_tipo_viatico"     => trim($res["co_tipo_viatico"]),
            "tx_evento"     => trim($res["tx_evento"]),
            "tx_direccion"     => trim($res["tx_direccion"]),
            "in_empleado"     => trim($res["in_empleado"]),
            "co_origen"     => trim($res["co_origen"]),
            "co_destino"     => trim($res["co_destino"]),
            "fe_desde"     => trim($res["fe_desde"]),
            "fe_hasta"     => trim($res["fe_hasta"]),
            "in_hospedaje"     => trim($res["in_hospedaje"]),
            "tx_observacion_hospedaje"     => trim($res["tx_observacion_hospedaje"]),
            "co_tipo_traslado"     => trim($res["co_tipo_traslado"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb107_tipo_viatico.CO_TIPO_VIATICO
    public function executeStorefkcotipoviatico(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb107TipoViaticoPeer::doSelectStmt($c);
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
                                                        //modelo fk tb110_origen_viatico.CO_ORIGEN_VIATICO
    public function executeStorefkcoorigen(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb110OrigenViaticoPeer::CO_TIPO_VIATICO,$this->getRequestParameter("co_tipo_viatico"));
        $c->addAscendingOrderByColumn(Tb110OrigenViaticoPeer::TX_ORIGEN_VIATICO);
        $stmt = Tb110OrigenViaticoPeer::doSelectStmt($c);
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
                    //modelo fk tb110_origen_viatico.CO_ORIGEN_VIATICO
    public function executeStorefkcodestino(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb110OrigenViaticoPeer::doSelectStmt($c);
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
                                                                    //modelo fk tb113_tipo_traslado.CO_TIPO_TRASLADO
    public function executeStorefkcocategoria(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb113CategoriaPeer::doSelectStmt($c);
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

    public function executeStorefkcoitemviatico(sfWebRequest $request){

        $json_item = $this->getRequestParameter("lista");

        $listaItem  = json_decode($json_item,true);
        $array = array();
        $i=0;
        foreach($listaItem  as $v){
            $array[$i] = $v["co_item_viatico"];
            $i++;
        }



        $c = new Criteria();

        if($i>0){
            $ci = new Criteria();
            $ci->add(Tb114ItemViaticoPeer::CO_ITEM_VIATICO,$array,Criteria::IN);
            $stmt = Tb114ItemViaticoPeer::doSelectStmt($ci);
            $items = array();
            while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
                $items[] = $reg["tx_tipo_item"];
            }

            $c->add(Tb114ItemViaticoPeer::TX_TIPO_ITEM,$items,Criteria::NOT_IN);
        }



        $stmt = Tb114ItemViaticoPeer::doSelectStmt($c);
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

    public function executeVerificarSolicitante(sfWebRequest $request)
    {

        $co_documento  = $this->getRequestParameter('co_documento');
        $tx_rif        = $this->getRequestParameter('tx_rif');
        $co_proveedor        = $this->getRequestParameter('co_proveedor');

        $c = new Criteria();
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb109PersonaPeer::CO_CARGO);
        $c->addSelectColumn(Tb109PersonaPeer::NU_CELULAR);
        $c->addSelectColumn(Tb109PersonaPeer::NU_EXTENSION);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR,Tb109PersonaPeer::CO_PROVEEDOR,Criteria::LEFT_JOIN);

        
        if($co_documento!='' && $tx_rif!=''){
            $c->add(Tb008ProveedorPeer::CO_DOCUMENTO,$co_documento);
            $c->add(Tb008ProveedorPeer::TX_RIF,$tx_rif);            
            $stmt = Tb008ProveedorPeer::doSelectStmt($c);
            $registros = $stmt->fetch(PDO::FETCH_ASSOC);            
        }else if($co_proveedor!=''){
            $c->add(Tb008ProveedorPeer::CO_PROVEEDOR,$co_proveedor);
            $stmt = Tb008ProveedorPeer::doSelectStmt($c);
            $registros = $stmt->fetch(PDO::FETCH_ASSOC);
        }


       
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));

        $this->setTemplate('store');

    }



}
