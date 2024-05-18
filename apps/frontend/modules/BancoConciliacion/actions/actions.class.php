<?php

/**
 * BancoConciliacion actions.
 *
 * @package    gobel
 * @subpackage BancoConciliacion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class BancoConciliacionActions extends sfActions
{
 
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('BancoConciliacion', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('BancoConciliacion', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {
    $this->data = json_encode(array(
                        "id_tb010_banco"     => $this->getRequestParameter("id_tb010_banco"),
                        "id_tb011_cuenta_bancaria"     => $this->getRequestParameter("id_tb011_cuenta_bancaria"),
                        "id_tb105_conciliacion"       => $this->getRequestParameter("id_tb105_conciliacion"),
                        "fe_desde"       => $this->getRequestParameter("fe_desde"),
                        "fe_hasta"       => $this->getRequestParameter("fe_hasta"),
                ));
  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb104BancoConciliacionPeer::ID,$codigo);

        $stmt = Tb104BancoConciliacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb010_banco"     => $campos["id_tb010_banco"],
                            "id_tb011_cuenta_bancaria"     => $campos["id_tb011_cuenta_bancaria"],
                            "fe_movimiento"     => $campos["fe_movimiento"],
                            "de_concepto"     => $campos["de_concepto"],
                            "mo_cargo"     => $campos["mo_cargo"],
                            "mo_abono"     => $campos["mo_abono"],
                            "mo_saldo"     => $campos["mo_saldo"],
                            "id_tb101_tipo_concilacion"     => $campos["id_tb101_tipo_concilacion"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "id_tb105_conciliacion"     => $campos["id_tb105_conciliacion"],
                            "fe_desde"       => $this->getRequestParameter("fe_desde"),
                            "fe_hasta"       => $this->getRequestParameter("fe_hasta"),
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb010_banco"     => $this->getRequestParameter("id_tb010_banco"),
                            "id_tb011_cuenta_bancaria"     => $this->getRequestParameter("id_tb011_cuenta_bancaria"),
                            "fe_movimiento"     => "",
                            "de_concepto"     => "",
                            "mo_cargo"     => "",
                            "mo_abono"     => "",
                            "mo_saldo"     => "",
                            "id_tb101_tipo_concilacion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "id_tb105_conciliacion"       => $this->getRequestParameter("id_tb105_conciliacion"),
                            "fe_desde"       => $this->getRequestParameter("fe_desde"),
                            "fe_hasta"       => $this->getRequestParameter("fe_hasta"),
                    ));
    }

  }

  public function executeManual(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb104BancoConciliacionPeer::ID,$codigo);

        $stmt = Tb104BancoConciliacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb010_banco"     => $campos["id_tb010_banco"],
                            "id_tb011_cuenta_bancaria"     => $campos["id_tb011_cuenta_bancaria"],
                            "fe_movimiento"     => $campos["fe_movimiento"],
                            "de_concepto"     => $campos["de_concepto"],
                            "mo_cargo"     => $campos["mo_cargo"],
                            "mo_abono"     => $campos["mo_abono"],
                            "mo_saldo"     => $campos["mo_saldo"],
                            "id_tb101_tipo_concilacion"     => $campos["id_tb101_tipo_concilacion"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb010_banco"     => "",
                            "id_tb011_cuenta_bancaria"     => "",
                            "fe_movimiento"     => "",
                            "de_concepto"     => "",
                            "mo_cargo"     => "",
                            "mo_abono"     => "",
                            "mo_saldo"     => "",
                            "id_tb101_tipo_concilacion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                            "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");

     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb104_banco_conciliacion = Tb104BancoConciliacionPeer::retrieveByPk($codigo);
     }else{
         $tb104_banco_conciliacion = new Tb104BancoConciliacion();
     }
     try
      {
        $con->beginTransaction();

        $tb104_banco_conciliacionForm = $this->getRequestParameter('tb104_banco_conciliacion');
/*CAMPOS*/

        /*Campo tipo BIGINT */
        $tb104_banco_conciliacion->setIdTb010Banco($tb104_banco_conciliacionForm["id_tb010_banco"]);

        /*Campo tipo BIGINT */
        $tb104_banco_conciliacion->setIdTb011CuentaBancaria($tb104_banco_conciliacionForm["id_tb011_cuenta_bancaria"]);

        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb104_banco_conciliacionForm["fe_movimiento"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb104_banco_conciliacion->setFeMovimiento($fecha);

        /*Campo tipo VARCHAR */
        $tb104_banco_conciliacion->setDeConcepto($tb104_banco_conciliacionForm["de_concepto"]);

        /*Campo tipo NUMERIC */
        $tb104_banco_conciliacion->setMoCargo($tb104_banco_conciliacionForm["mo_cargo"]);

        /*Campo tipo NUMERIC */
        $tb104_banco_conciliacion->setMoAbono($tb104_banco_conciliacionForm["mo_abono"]);

        /*Campo tipo NUMERIC */
        $tb104_banco_conciliacion->setMoSaldo($tb104_banco_conciliacionForm["mo_saldo"]);

        /*Campo tipo BIGINT */
        $tb104_banco_conciliacion->setIdTb101TipoConcilacion(1);

        /*Campo tipo BOOLEAN */
        $tb104_banco_conciliacion->setInActivo(true);

        /*Campo tipo TIMESTAMP */
        $fecha = date("Y-m-d H:i:s");
        $tb104_banco_conciliacion->setCreatedAt($fecha);

        /*Campo tipo TIMESTAMP */
        $tb104_banco_conciliacion->setUpdatedAt($fecha);

        /*Campo tipo BIGINT */
        $tb104_banco_conciliacion->setIdTb105Conciliacion($tb104_banco_conciliacionForm["id_tb105_conciliacion"]);

        /*CAMPOS*/
        $tb104_banco_conciliacion->save($con);
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
	$tb104_banco_conciliacion = Tb104BancoConciliacionPeer::retrieveByPk($codigo);
	$tb104_banco_conciliacion->delete($con);
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

  public function executeListaManual(sfWebRequest $request)
  {
    //$codigo = $this->getRequestParameter("codigo");
    $codigo = $this->getRequestParameter("co_solicitud");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                //$c->add(Tb105ConciliacionPeer::ID,$codigo);
                $c->add(Tb105ConciliacionPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb105ConciliacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        if($campos["id"]!=''){

                  $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb010_banco"     => $campos["id_tb010_banco"],
                            "id_tb011_cuenta_bancaria"     => $campos["id_tb011_cuenta_bancaria"],
                            "fe_desde"     => $campos["fe_desde"],
                            "fe_hasta"     => $campos["fe_hasta"],
                            "co_usuario"     => $campos["co_usuario"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "co_proceso"     => $campos["co_proceso"],
                            "nu_conciliacion"     => $campos["nu_conciliacion"],
                    ));

          }else{

                        $this->data = json_encode(array(
                                "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                                "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                                "co_proceso"  => $this->getRequestParameter("co_proceso"),
                                "id"     => "",
                                "id_tb010_banco"     => "",
                                "id_tb011_cuenta_bancaria"     => "",
                                "fe_desde"     => "",
                                "fe_hasta"     => "",
                                "co_usuario"     => "",
                                "in_activo"     => "",
                                "created_at"     => "",
                                "updated_at"     => "",
                        ));

          }

    }else{

        $this->data = json_encode(array(
                            "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                            "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                            "co_proceso"  => $this->getRequestParameter("co_proceso"),
                            "id"     => "",
                            "id_tb010_banco"     => "",
                            "id_tb011_cuenta_bancaria"     => "",
                            "fe_desde"     => "",
                            "fe_hasta"     => "",
                            "co_usuario"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));

    }
  }

  public function executeListaLote(sfWebRequest $request)
  {
    //$codigo = $this->getRequestParameter("codigo");
    $codigo = $this->getRequestParameter("co_solicitud");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                //$c->add(Tb105ConciliacionPeer::ID,$codigo);
                $c->add(Tb105ConciliacionPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb105ConciliacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        if($campos["id"]!=''){

                  $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb010_banco"     => $campos["id_tb010_banco"],
                            "id_tb011_cuenta_bancaria"     => $campos["id_tb011_cuenta_bancaria"],
                            "fe_desde"     => $campos["fe_desde"],
                            "fe_hasta"     => $campos["fe_hasta"],
                            "co_usuario"     => $campos["co_usuario"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "co_proceso"     => $campos["co_proceso"],
                            "nu_conciliacion"     => $campos["nu_conciliacion"],
                    ));

          }else{

                        $this->data = json_encode(array(
                                "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                                "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                                "co_proceso"  => $this->getRequestParameter("co_proceso"),
                                "id"     => "",
                                "id_tb010_banco"     => "",
                                "id_tb011_cuenta_bancaria"     => "",
                                "fe_desde"     => "",
                                "fe_hasta"     => "",
                                "co_usuario"     => "",
                                "in_activo"     => "",
                                "created_at"     => "",
                                "updated_at"     => "",
                        ));

          }

    }else{

        $this->data = json_encode(array(
                            "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                            "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                            "co_proceso"  => $this->getRequestParameter("co_proceso"),
                            "id"     => "",
                            "id_tb010_banco"     => "",
                            "id_tb011_cuenta_bancaria"     => "",
                            "fe_desde"     => "",
                            "fe_hasta"     => "",
                            "co_usuario"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));

    }
  }
  
  protected function getCriteria(){
    $c = new Criteria();   
    $c->setIgnoreCase(true);
    $c->addSelectColumn(Tb063PagoPeer::CO_PAGO);
    $c->addSelectColumn(Tb010BancoPeer::TX_BANCO);
    $c->addSelectColumn(Tb011CuentaBancariaPeer::TX_CUENTA_BANCARIA);
    $c->addSelectColumn(Tb063PagoPeer::FE_PAGO);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb063PagoPeer::NU_MONTO);
    $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
    $c->addSelectColumn(Tb063PagoPeer::IN_CONSOLIDADO);
    $c->addSelectColumn(Tb063PagoPeer::NU_PAGO);
    $c->addSelectColumn(Tb074FormaPagoPeer::TX_FORMA_PAGO);
    $c->addSelectColumn(Tb128DetalleConciliacionPeer::CO_CONCILIACION);    
    $c->addJoin(Tb063PagoPeer::CO_PAGO, Tb128DetalleConciliacionPeer::CO_PAGO, Criteria::LEFT_JOIN);
    $c->addJoin(Tb063PagoPeer::CO_FORMA_PAGO, Tb074FormaPagoPeer::CO_FORMA_PAGO);
    $c->addJoin(Tb063PagoPeer::CO_BANCO, Tb010BancoPeer::CO_BANCO);
    $c->addJoin(Tb063PagoPeer::CO_CUENTA_BANCARIA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
    $c->addJoin(Tb063PagoPeer::CO_LIQUIDACION_PAGO, Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
    $c->addJoin(Tb062LiquidacionPagoPeer::CO_SOLICITUD, Tb026SolicitudPeer::CO_SOLICITUD);
    $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);

    return $c;
  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",10);
    $start      =   $this->getRequestParameter("start",0);
                
    $co_banco    =   $this->getRequestParameter("co_banco");
    $co_cuenta   =   $this->getRequestParameter("co_cuenta");
    $desde       =   $this->getRequestParameter("fe_desde");
    $hasta       =   $this->getRequestParameter("fe_hasta");
    $co_conciliacion = $this->getRequestParameter("co_conciliacion");
    
    $registros = "";
    if($co_conciliacion!=''){
        
        $c = $this->getCriteria();
   
        $c->add(Tb128DetalleConciliacionPeer::CO_CONCILIACION,$co_conciliacion);

        $stmt = Tb063PagoPeer::doSelectStmt($c);

        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){

            list($anio,$mes,$dia) = explode("-", $res["fe_pago"]);
            $fecha = $dia.'/'.$mes.'/'.$anio;

            $registros[] = array(
                "co_solicitud"       => trim($res["co_solicitud"]),
                "co_pago"            => trim($res["co_pago"]),
                "co_pago"            => trim($res["co_pago"]),
                "tx_banco"           => trim($res["tx_banco"]),
                "in_consolidado"     => trim($res["in_consolidado"]),
                "tx_cuenta_bancaria" => trim($res["tx_cuenta_bancaria"]),
                "fe_pago"            => trim($fecha),
                "tx_tipo_solicitud"  => trim($res["tx_tipo_solicitud"]),
                "nu_monto"           => trim($res["nu_monto"]),
                "tx_forma_pago"      => trim($res["tx_forma_pago"]),
                "nu_pago"            => trim($res["nu_pago"]),
                "co_conciliacion"    => trim($res["co_conciliacion"])
            );
        }        
    }
    
    
    
    list($dia,$mes,$anio) = explode("-",$desde);
    $fe_desde = $anio.'-'.$mes.'-'.$dia;
    
    list($dia,$mes,$anio) = explode("-",$hasta);
    $fe_hasta = $anio.'-'.$mes.'-'.$dia;
   
    $c = $this->getCriteria();
   
    $c->add(Tb063PagoPeer::CO_BANCO,$co_banco);
    $c->add(Tb063PagoPeer::IN_CONSOLIDADO,true, Criteria::NOT_EQUAL);
    $c->addOr(Tb063PagoPeer::IN_CONSOLIDADO,NULL, Criteria::ISNULL);
    $c->add(Tb063PagoPeer::CO_CUENTA_BANCARIA,$co_cuenta);
    $c->add(Tb063PagoPeer::FE_PAGO,$fe_desde, Criteria::GREATER_EQUAL);
    $c->addAnd(Tb063PagoPeer::FE_PAGO,$fe_hasta, Criteria::LESS_EQUAL);
    
    
    $cantidadTotal = Tb063PagoPeer::doCount($c);

    $stmt = Tb063PagoPeer::doSelectStmt($c);
   
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        list($anio,$mes,$dia) = explode("-", $res["fe_pago"]);
        $fecha = $dia.'/'.$mes.'/'.$anio;
        
        $registros[] = array(
            "co_solicitud"       => trim($res["co_solicitud"]),
            "co_pago"            => trim($res["co_pago"]),
            "co_pago"            => trim($res["co_pago"]),
            "tx_banco"           => trim($res["tx_banco"]),
            "in_consolidado"     => trim($res["in_consolidado"]),
            "tx_cuenta_bancaria" => trim($res["tx_cuenta_bancaria"]),
            "fe_pago"            => trim($fecha),
            "tx_tipo_solicitud"  => trim($res["tx_tipo_solicitud"]),
            "nu_monto"           => trim($res["nu_monto"]),
            "tx_forma_pago"      => trim($res["tx_forma_pago"]),
            "nu_pago"            => trim($res["nu_pago"]),
            "co_conciliacion"    => trim($res["co_conciliacion"])
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb010_banco.CO_BANCO
    public function executeStorefkidtb010banco(sfWebRequest $request){
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
    public function executeStorefkidtb011cuentabancaria(sfWebRequest $request){

        $codigo      =   $this->getRequestParameter("banco");

        $c = new Criteria();
        $c->add(Tb011CuentaBancariaPeer::CO_BANCO, $codigo);
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
                                                                                //modelo fk tb101_tipo_concilacion.ID
    public function executeStorefkidtb101tipoconcilacion(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb101TipoConcilacionPeer::doSelectStmt($c);
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
