<?php

/**
 * Movimiento actions.
 *
 * @package    gobel
 * @subpackage Movimiento
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class MovimientoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Movimiento', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Movimiento', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb087PresupuestoMovimientoPeer::ID,$codigo);

        $stmt = Tb087PresupuestoMovimientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb085_presupuesto"     => $campos["id_tb085_presupuesto"],
                            "mo_movimiento"     => $campos["mo_movimiento"],
                            "id_tb088_tipo_movimiento"     => $campos["id_tb088_tipo_movimiento"],
                            "nu_referencia"     => $campos["nu_referencia"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb085_presupuesto"     => "",
                            "mo_movimiento"     => "",
                            "id_tb088_tipo_movimiento"     => "",
                            "nu_referencia"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("id");

     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb087_presupuesto_movimiento = Tb087PresupuestoMovimientoPeer::retrieveByPk($codigo);
     }else{
         $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
     }
     try
      {
        $con->beginTransaction();

        $tb087_presupuesto_movimientoForm = $this->getRequestParameter('tb087_presupuesto_movimiento');
/*CAMPOS*/

        /*Campo tipo BIGINT */
        $tb087_presupuesto_movimiento->setIdTb085Presupuesto($tb087_presupuesto_movimientoForm["id_tb085_presupuesto"]);

        /*Campo tipo NUMERIC */
        $tb087_presupuesto_movimiento->setMoMovimiento($tb087_presupuesto_movimientoForm["mo_movimiento"]);

        /*Campo tipo BIGINT */
        $tb087_presupuesto_movimiento->setIdTb088TipoMovimiento($tb087_presupuesto_movimientoForm["id_tb088_tipo_movimiento"]);

        /*Campo tipo VARCHAR */
        $tb087_presupuesto_movimiento->setNuReferencia($tb087_presupuesto_movimientoForm["nu_referencia"]);

        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb087_presupuesto_movimientoForm)){
            $tb087_presupuesto_movimiento->setInActivo(false);
        }else{
            $tb087_presupuesto_movimiento->setInActivo(true);
        }

        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb087_presupuesto_movimientoForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb087_presupuesto_movimiento->setCreatedAt($fecha);

        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb087_presupuesto_movimientoForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb087_presupuesto_movimiento->setUpdatedAt($fecha);

        /*CAMPOS*/
        $tb087_presupuesto_movimiento->save($con);
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
	$codigo = $this->getRequestParameter("id");
	$con = Propel::getConnection();
	try
	{
	$con->beginTransaction();
	/*CAMPOS*/
	$tb087_presupuesto_movimiento = Tb087PresupuestoMovimientoPeer::retrieveByPk($codigo);
	$tb087_presupuesto_movimiento->delete($con);
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
    $this->data = json_encode(array(
        "codigo" => $this->getRequestParameter("codigo")
    ));
  }

  public function executeListaIngreso(sfWebRequest $request)
  {
    $this->data = json_encode(array(
        "codigo" => $this->getRequestParameter("codigo")
    ));
  }  
  
  public function executeStorelista(sfWebRequest $request)
  {
        $paginar    =   $this->getRequestParameter("paginar");
        $limit      =   $this->getRequestParameter("limit",20);
        $start      =   $this->getRequestParameter("start",0);

        $id_tb085_presupuesto       =   $this->getRequestParameter("codigo");
        $co_tipo_movimiento         =   $this->getRequestParameter("co_tipo_movimiento");
        $mo_movimiento              =   $this->getRequestParameter("mo_movimiento");
        $id_tb088_tipo_movimiento   =   $this->getRequestParameter("id_tb088_tipo_movimiento");
        $nu_referencia              =   $this->getRequestParameter("nu_referencia");
        $in_activo                  =   $this->getRequestParameter("in_activo");
        $created_at                 =   $this->getRequestParameter("created_at");
        $updated_at                 =   $this->getRequestParameter("updated_at");


        $c = new Criteria();
    
        $c->clearSelectColumns();
//        $c->setDistinct();
        $c->addSelectColumn(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA);
        $c->addSelectColumn(Tb087PresupuestoMovimientoPeer::NU_MONTO);
//        $c->addSelectColumn(Tb060OrdenPagoPeer::TX_SERIAL);
        $c->addSelectColumn(Tb052ComprasPeer::CO_SOLICITUD);
       // $c->addSelectColumn(Tb087PresupuestoMovimientoPeer::CREATED_AT);
        $c->addSelectColumn("cast(".Tb087PresupuestoMovimientoPeer::CREATED_AT." as date) as created_at");
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);

        $c->setIgnoreCase(true);
        
        $c->addJoin(Tb085PresupuestoPeer::ID,Tb087PresupuestoMovimientoPeer::CO_PARTIDA,Criteria::INNER_JOIN);
        $c->addJoin(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA,Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS,Criteria::INNER_JOIN);        
        $c->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS,Tb052ComprasPeer::CO_COMPRAS,Criteria::INNER_JOIN);
        $c->addJoin(Tb052ComprasPeer::CO_SOLICITUD,Tb026SolicitudPeer::CO_SOLICITUD,  Criteria::INNER_JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR,Tb008ProveedorPeer::CO_PROVEEDOR,Criteria::INNER_JOIN);
        $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO,Criteria::INNER_JOIN);
       
        $c->addJoin(Tb085PresupuestoPeer::ID,Tb087PresupuestoMovimientoPeer::CO_PARTIDA);
        $c->add(Tb087PresupuestoMovimientoPeer::CO_PARTIDA,$id_tb085_presupuesto);
        if($co_tipo_movimiento == 1)
            $c->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO,array(1,4),Criteria::IN);
        else
            $c->add(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO,$co_tipo_movimiento);
        //$c->add(Tb087PresupuestoMovimientoPeer::IN_ACTIVO, TRUE);
        
        $c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
        $c->add(Tb087PresupuestoMovimientoPeer::NU_MONTO,0, Criteria::GREATER_THAN);
        $c->add(Tb087PresupuestoMovimientoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        $c->add(Tb060OrdenPagoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        $c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
        
        $c->addAscendingOrderByColumn(Tb052ComprasPeer::CO_SOLICITUD);
        
        $cantidadTotal = Tb087PresupuestoMovimientoPeer::doCount($c);
        $stmt = Tb087PresupuestoMovimientoPeer::doSelectStmt($c);
        
        //echo $c->toString(); exit();
    
        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){

            list($fecha,$hora)      = explode(" ", $res["created_at"]);
            list($anio,$mes,$dia)   = explode("-", $fecha);


            $registros[] = array(
                "de_tipo_movimiento"       => trim($res["de_tipo_movimiento"]),
                "nu_monto"                 => trim($res["nu_monto"]),
                "created_at"               => trim($dia.'/'.$mes.'/'.$anio),
                "co_solicitud"             => $res["co_solicitud"],
                "tx_serial"                => $res["tx_serial"], 
                "tx_razon_social"          => $res["tx_razon_social"],
                "tx_rif"                   => $res["inicial"]."-".$res["tx_rif"]
            );
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));
    }
    
  public function executeStorelistaIngreso(sfWebRequest $request)
  {


        $id_tb064_presupuesto_ingreso       =   $this->getRequestParameter("codigo");
        $co_tipo_movimiento         =   $this->getRequestParameter("co_tipo_movimiento");


        $c = new Criteria();
    
        $c->clearSelectColumns();
        $c->setDistinct();
        $c->addSelectColumn(Tb150PresupuestoIngresoMovimientoPeer::ID);
        $c->addSelectColumn(Tb150PresupuestoIngresoMovimientoPeer::CO_SOLICITUD);
        $c->addSelectColumn("cast(". Tb150PresupuestoIngresoMovimientoPeer::CREATED_AT." as date) as created_at");
        $c->addSelectColumn(Tb150PresupuestoIngresoMovimientoPeer::MO_MOVIMIENTO);

        $c->setIgnoreCase(true);
        $c->add(Tb150PresupuestoIngresoMovimientoPeer::ID_TB064_PRESUPUESTO_INGRESO,$id_tb064_presupuesto_ingreso);
        $c->add(Tb150PresupuestoIngresoMovimientoPeer::CO_TIPO_MOVIMIENTO,$co_tipo_movimiento);
        $c->add(Tb150PresupuestoIngresoMovimientoPeer::IN_ACTIVO,TRUE);
        $c->addJoin(Tb150PresupuestoIngresoMovimientoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);

        $c->add(Tb150PresupuestoIngresoMovimientoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        $c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
        
        
        $c->addAscendingOrderByColumn(Tb150PresupuestoIngresoMovimientoPeer::ID);
        
        $cantidadTotal = Tb150PresupuestoIngresoMovimientoPeer::doCount($c);
        $stmt = Tb150PresupuestoIngresoMovimientoPeer::doSelectStmt($c);
        
        //echo $c->toString(); exit();
    
        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){

            list($fecha,$hora)      = explode(" ", $res["created_at"]);
            list($anio,$mes,$dia)   = explode("-", $fecha);


            $registros[] = array(
                "nu_monto"                 => trim($res["mo_movimiento"]),
                "created_at"               => trim($dia.'/'.$mes.'/'.$anio),
                "co_solicitud"             => $res["co_solicitud"],
            );
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));
        
        $this->setTemplate('store');
        
    }    
    
    public function executeStorelistaMovimiento(sfWebRequest $request)
    {
        $paginar    =   $this->getRequestParameter("paginar");
        $limit      =   $this->getRequestParameter("limit",20);
        $start      =   $this->getRequestParameter("start",0);

        $id_tb085_presupuesto       =   $this->getRequestParameter("codigo");
        $co_tipo_movimiento         =   $this->getRequestParameter("co_tipo_movimiento");
        $mo_movimiento              =   $this->getRequestParameter("mo_movimiento");
        $id_tb088_tipo_movimiento   =   $this->getRequestParameter("id_tb088_tipo_movimiento");
        $nu_referencia              =   $this->getRequestParameter("nu_referencia");
        $in_activo                  =   $this->getRequestParameter("in_activo");
        $created_at                 =   $this->getRequestParameter("created_at");
        $updated_at                 =   $this->getRequestParameter("updated_at");


        $c = new Criteria();

        $c->clearSelectColumns();
        $c->setDistinct();
        $c->addSelectColumn(Tb097ModificacionDetallePeer::MO_DISTRIBUCION);
        $c->addSelectColumn(Tb096PresupuestoModificacionPeer::NU_MODIFICACION);
        $c->addSelectColumn(Tb096PresupuestoModificacionPeer::CREATED_AT);
        $c->addSelectColumn(Tb096PresupuestoModificacionPeer::DE_MODIFICACION);
        $c->addSelectColumn(Tb096PresupuestoModificacionPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID);

        $c->setIgnoreCase(true);

        $c->addJoin(Tb096PresupuestoModificacionPeer::ID, Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,Criteria::INNER_JOIN);

        
        $c->add(Tb097ModificacionDetallePeer::IN_ANULAR,NULL, Criteria::ISNULL);
        $c->add(Tb097ModificacionDetallePeer::ID_TB085_PRESUPUESTO,$id_tb085_presupuesto);
        $c->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION,$co_tipo_movimiento);
        $c->add(Tb097ModificacionDetallePeer::ID_TB013_ANIO_FISCAL,$this->getUser()->getAttribute('ejercicio'));

        $c->addAscendingOrderByColumn(Tb097ModificacionDetallePeer::ID);

        //echo $c->toString(); exit();
        
        $cantidadTotal = Tb097ModificacionDetallePeer::doCount($c);
        $stmt = Tb097ModificacionDetallePeer::doSelectStmt($c);   

        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){

            list($fecha,$hora)      = explode(" ", $res["created_at"]);
            list($anio,$mes,$dia)   = explode("-", $fecha);


            $registros[] = array(
                "mo_distribucion"          => trim($res["mo_distribucion"]),
                "created_at"               => trim($dia.'/'.$mes.'/'.$anio),
                "co_solicitud"             => $res["co_solicitud"],
                "de_modificacion"          => $res["de_modificacion"], 
                "nu_modificacion"                => $res["nu_modificacion"]
            );
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));
        
        $this->setTemplate('store');
    }

    
    public function executeStorelistaMovimientoIngreso(sfWebRequest $request)
    {
        $paginar    =   $this->getRequestParameter("paginar");
        $limit      =   $this->getRequestParameter("limit",20);
        $start      =   $this->getRequestParameter("start",0);

        $id_tb064_presupuesto       =   $this->getRequestParameter("codigo");
        $co_tipo_movimiento         =   $this->getRequestParameter("co_tipo_movimiento");


        $c = new Criteria();

        $c->clearSelectColumns();
        $c->setDistinct();
        $c->addSelectColumn(Tb150PresupuestoIngresoMovimientoPeer::ID);
        $c->addSelectColumn(Tb150PresupuestoIngresoMovimientoPeer::MO_MOVIMIENTO);
        $c->addSelectColumn(Tb096PresupuestoModificacionPeer::NU_MODIFICACION);
        $c->addSelectColumn(Tb150PresupuestoIngresoMovimientoPeer::CREATED_AT);
        $c->addSelectColumn(Tb096PresupuestoModificacionPeer::DE_MODIFICACION);
        $c->addSelectColumn(Tb096PresupuestoModificacionPeer::CO_SOLICITUD);
        //$c->addSelectColumn(Tb097ModificacionDetallePeer::ID);

        $c->setIgnoreCase(true);
        
        $c->addJoin(Tb150PresupuestoIngresoMovimientoPeer::CO_SOLICITUD,Tb096PresupuestoModificacionPeer::CO_SOLICITUD, Criteria::LEFT_JOIN);
       $c->addJoin(Tb096PresupuestoModificacionPeer::ID, Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,Criteria::LEFT_JOIN);        
 
        
        $c->add(Tb150PresupuestoIngresoMovimientoPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        //$c->add(Tb097ModificacionDetallePeer::IN_ANULAR,NULL, Criteria::ISNULL);
        $c->add(Tb150PresupuestoIngresoMovimientoPeer::ID_TB064_PRESUPUESTO_INGRESO,$id_tb064_presupuesto);
        //$c->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION,$co_tipo_movimiento);
        $c->add(Tb150PresupuestoIngresoMovimientoPeer::CO_TIPO_MOVIMIENTO,$co_tipo_movimiento);
        //$c->add(Tb097ModificacionDetallePeer::ID_TB013_ANIO_FISCAL,$this->getUser()->getAttribute('ejercicio'));

        $c->addAscendingOrderByColumn(Tb150PresupuestoIngresoMovimientoPeer::ID);

        //echo $c->toString(); exit();
        
        $cantidadTotal = Tb150PresupuestoIngresoMovimientoPeer::doCount($c);
        $stmt = Tb150PresupuestoIngresoMovimientoPeer::doSelectStmt($c);   

        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){

            list($fecha,$hora)      = explode(" ", $res["created_at"]);
            list($anio,$mes,$dia)   = explode("-", $fecha);


            $registros[] = array(
                "mo_distribucion"          => trim($res["mo_movimiento"]),
                "created_at"               => trim($dia.'/'.$mes.'/'.$anio),
                "co_solicitud"             => $res["co_solicitud"],
                "de_modificacion"          => $res["de_modificacion"], 
                "nu_modificacion"                => $res["nu_modificacion"]
            );
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));
        
        $this->setTemplate('store');
    }    
                    //modelo fk tb085_presupuesto.ID
    public function executeStorefkidtb085presupuesto(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
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
                                //modelo fk tb088_tipo_movimiento.ID
    public function executeStorefkidtb088tipomovimiento(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb088TipoMovimientoPeer::doSelectStmt($c);
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
