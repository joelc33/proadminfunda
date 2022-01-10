<?php

/**
 * Modificaciondetalle actions.
 *
 * @package    gobel
 * @subpackage Modificaciondetalle
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ModificaciondetalleActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Modificaciondetalle', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Modificaciondetalle', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();

        $c->clearSelectColumns();
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::NU_PARTIDA);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB083_PROYECTO_AC);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB084_ACCION_ESPECIFICA);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB085_PRESUPUESTO);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::MO_DISTRIBUCION);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB082_EJECUTOR_ORIGEN);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB082_EJECUTOR_DESTINO);
        $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION);
        $c->addJoin(Tb096PresupuestoModificacionPeer::ID, Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION);
        $c->addJoin(Tb085PresupuestoPeer::ID, Tb097ModificacionDetallePeer::ID_TB085_PRESUPUESTO);
        $c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
        //$c->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);
        $c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
        
        $c->add(Tb097ModificacionDetallePeer::ID,$codigo);

        $stmt = Tb097ModificacionDetallePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "ejecutor"     => $campos["id_tb082_ejecutor"],
                            "id_tb096_presupuesto_modificacion"     => $campos["id_tb096_presupuesto_modificacion"],
                            "id_tb013_anio_fiscal"     => $campos["id_tb013_anio_fiscal"],
                            "id_tb083_proyecto_ac"     => $campos["id_tb083_proyecto_ac"],
                            "id_tb084_accion_especifica"     => $campos["id_tb084_accion_especifica"],
                            "id_tb085_presupuesto"     => $campos["id_tb085_presupuesto"],
                            "nu_partida"     => $campos["nu_partida"],
                            "id_tb098_tipo_distribucion"     => $campos["id_tb098_tipo_distribucion"],
                            "mo_distribucion"     => $campos["mo_distribucion"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "mo_disponible"     => $campos["mo_disponible"],
                            "id_tb082_ejecutor_origen"     => $campos["id_tb082_ejecutor_origen"],
                            "id_tb082_ejecutor_destino"     => $campos["id_tb082_ejecutor_destino"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb096_presupuesto_modificacion"     => $this->getRequestParameter("movimiento"),
                            "id_tb013_anio_fiscal"     => "",
                            "id_tb083_proyecto_ac"     => "",
                            "ejecutor"     => $this->getRequestParameter("ejecutor"),
                            "id_tb084_accion_especifica"     => "",
                            "id_tb085_presupuesto"     => "",
                            "nu_partida"     => "",
                            "id_tb098_tipo_distribucion"     => "",
                            "mo_distribucion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "id_tb082_ejecutor_origen"     => "",
                            "id_tb082_ejecutor_destino"     => "",
                    ));
    }

  }

  public function executeEditarCreditoadicional(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();

        $c->clearSelectColumns();
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::NU_PARTIDA);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB085_PRESUPUESTO);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::MO_DISTRIBUCION);
        $c->addSelectColumn(Tb064PresupuestoIngresoPeer::MO_DISPONIBLE);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB082_EJECUTOR_ORIGEN);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB064_PRESUPUESTO_INGRESO);
        $c->addJoin(Tb097ModificacionDetallePeer::ID_TB064_PRESUPUESTO_INGRESO, Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO);

        $c->add(Tb097ModificacionDetallePeer::ID,$codigo);

        $stmt = Tb097ModificacionDetallePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "ejecutor"     => $campos["id_tb082_ejecutor"],
                            "id_tb096_presupuesto_modificacion"     => $campos["id_tb096_presupuesto_modificacion"],
                            "id_tb013_anio_fiscal"     => $campos["id_tb013_anio_fiscal"],
                            "id_tb083_proyecto_ac"     => $campos["id_tb083_proyecto_ac"],
                            "id_tb084_accion_especifica"     => $campos["id_tb084_accion_especifica"],
                            "id_tb064_presupuesto_ingreso"     => $campos["id_tb064_presupuesto_ingreso"],
                            "nu_partida"     => $campos["nu_partida"],
                            "id_tb098_tipo_distribucion"     => $campos["id_tb098_tipo_distribucion"],
                            "mo_distribucion"     => $campos["mo_distribucion"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "mo_disponible"     => $campos["mo_disponible"],
                            "id_tb082_ejecutor_origen"     => $campos["id_tb082_ejecutor_origen"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb096_presupuesto_modificacion"     => $this->getRequestParameter("movimiento"),
                            "id_tb013_anio_fiscal"     => "",
                            "id_tb082_ejecutor_origen"     => $this->getRequestParameter("ejecutor"),
                            "id_tb084_accion_especifica"     => "",
                            "id_tb064_presupuesto_ingreso"     => "",
                            "nu_partida"     => "",
                            "id_tb098_tipo_distribucion"     => "",
                            "mo_distribucion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeDestino(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();

        $c->clearSelectColumns();
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::NU_PARTIDA);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB083_PROYECTO_AC);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB084_ACCION_ESPECIFICA);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB085_PRESUPUESTO);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::MO_DISTRIBUCION);
        //$c->addSelectColumn(Tb096PresupuestoModificacionPeer::ID_TB082_EJECUTOR);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB082_EJECUTOR_DESTINO);
        $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB139_APLICACION);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::NU_APLICACION);
        $c->addJoin(Tb096PresupuestoModificacionPeer::ID, Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION);
        $c->addJoin(Tb085PresupuestoPeer::ID, Tb097ModificacionDetallePeer::ID_TB085_PRESUPUESTO);

        $c->add(Tb097ModificacionDetallePeer::ID,$codigo);

        $stmt = Tb097ModificacionDetallePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $c2 = new Criteria();
        $c2->clearSelectColumns();
        $c2->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION, $campos["id_tb096_presupuesto_modificacion"]);
        $c2->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
        $c2->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') as mo_debito');
        //$c->addGroupByColumn(valuePeer::VALUE);
        $stmt2 = Tb097ModificacionDetallePeer::doSelectStmt($c2);
        $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "ejecutor"     => $campos["id_tb082_ejecutor"],
                            "id_tb096_presupuesto_modificacion"     => $campos["id_tb096_presupuesto_modificacion"],
                            "id_tb013_anio_fiscal"     => $campos["id_tb013_anio_fiscal"],
                            "id_tb083_proyecto_ac"     => $campos["id_tb083_proyecto_ac"],
                            "id_tb084_accion_especifica"     => $campos["id_tb084_accion_especifica"],
                            "id_tb085_presupuesto"     => $campos["id_tb085_presupuesto"],
                            "nu_partida"     => $campos["nu_partida"],
                            "id_tb098_tipo_distribucion"     => $campos["id_tb098_tipo_distribucion"],
                            "mo_distribucion"     => $campos["mo_distribucion"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "mo_disponible"     => $campos2["mo_debito"],
                            "id_tb082_ejecutor"     => $campos["id_tb082_ejecutor_destino"],
                            "id_tb139_aplicacion"     => $campos["id_tb139_aplicacion"],
                            "nu_aplicacion"     => $campos["nu_aplicacion"],
                    ));
    }else{

        $c2 = new Criteria();
        $c2->clearSelectColumns();
        $c2->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION, $this->getRequestParameter("movimiento"));
        $c2->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
        $c2->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') as mo_debito');
        //$c->addGroupByColumn(valuePeer::VALUE);
        $stmt2 = Tb097ModificacionDetallePeer::doSelectStmt($c2);
        $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        $c3 = new Criteria();
        $c3->clearSelectColumns();
        $c3->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION, $this->getRequestParameter("movimiento"));
        $c3->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 2);
        $c3->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') as mo_credito');
        //$c->addGroupByColumn(valuePeer::VALUE);
        $stmt3 = Tb097ModificacionDetallePeer::doSelectStmt($c3);
        $campos3 = $stmt3->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb096_presupuesto_modificacion"     => $this->getRequestParameter("movimiento"),
                            "id_tb013_anio_fiscal"     => "",
                            "ejecutor"     => $this->getRequestParameter("ejecutor"),
                            "id_tb084_accion_especifica"     => "",
                            "id_tb085_presupuesto"     => "",
                            "nu_partida"     => "",
                            "id_tb098_tipo_distribucion"     => "",
                            "mo_distribucion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "mo_disponible"     => $campos2["mo_debito"]-$campos3["mo_credito"],
                            "id_tb082_ejecutor"     => $this->getRequestParameter("ejecutor")!=""?$this->getRequestParameter("ejecutor"):"",
                            "id_tb139_aplicacion"     => "",
                            "nu_aplicacion"     => "",
                    ));
    }

  }

  public function executeDestinoTraspaso(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();

        $c->clearSelectColumns();
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::NU_PARTIDA);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB083_PROYECTO_AC);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB084_ACCION_ESPECIFICA);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB085_PRESUPUESTO);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::MO_DISTRIBUCION);
        $c->addSelectColumn(Tb096PresupuestoModificacionPeer::ID_TB095_TIPO_MODIFICACION);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB082_EJECUTOR_DESTINO);
        $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB139_APLICACION);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::NU_APLICACION);
        $c->addJoin(Tb096PresupuestoModificacionPeer::ID, Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION);
        $c->addJoin(Tb085PresupuestoPeer::ID, Tb097ModificacionDetallePeer::ID_TB085_PRESUPUESTO);

        $c->add(Tb097ModificacionDetallePeer::ID,$codigo);

        $stmt = Tb097ModificacionDetallePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $c2 = new Criteria();
        $c2->clearSelectColumns();
        $c2->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION, $campos["id_tb096_presupuesto_modificacion"]);
        $c2->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
        $c2->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') as mo_debito');
        //$c->addGroupByColumn(valuePeer::VALUE);
        $stmt2 = Tb097ModificacionDetallePeer::doSelectStmt($c2);
        $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "ejecutor"     => $campos["id_tb082_ejecutor"],
                            "id_tb096_presupuesto_modificacion"     => $campos["id_tb096_presupuesto_modificacion"],
                            "id_tb013_anio_fiscal"     => $campos["id_tb013_anio_fiscal"],
                            "id_tb083_proyecto_ac"     => $campos["id_tb083_proyecto_ac"],
                            "id_tb084_accion_especifica"     => $campos["id_tb084_accion_especifica"],
                            "id_tb085_presupuesto"     => $campos["id_tb085_presupuesto"],
                            "nu_partida"     => $campos["nu_partida"],
                            "id_tb098_tipo_distribucion"     => $campos["id_tb098_tipo_distribucion"],
                            "mo_distribucion"     => $campos["mo_distribucion"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "mo_disponible"     => $campos2["mo_debito"],
                            "id_tb082_ejecutor"     => $campos["id_tb082_ejecutor_destino"],
                            "id_tb139_aplicacion"     => $campos["id_tb139_aplicacion"],
                            "nu_aplicacion"     => $campos["nu_aplicacion"],
                            "id_tb095_tipo_modificacion"     => $campos["id_tb095_tipo_modificacion"],
                    ));
    }else{
        
        $c = new Criteria();

        $c->clearSelectColumns();
        $c->addSelectColumn(Tb096PresupuestoModificacionPeer::ID_TB095_TIPO_MODIFICACION);
        $c->add(Tb096PresupuestoModificacionPeer::ID,$this->getRequestParameter("movimiento"));
        $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);        

        $c2 = new Criteria();
        $c2->clearSelectColumns();
        $c2->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION, $this->getRequestParameter("movimiento"));
        $c2->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
        $c2->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') as mo_debito');
        //$c->addGroupByColumn(valuePeer::VALUE);
        $stmt2 = Tb097ModificacionDetallePeer::doSelectStmt($c2);
        $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        $c3 = new Criteria();
        $c3->clearSelectColumns();
        $c3->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION, $this->getRequestParameter("movimiento"));
        $c3->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 2);
        $c3->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') as mo_credito');
        //$c->addGroupByColumn(valuePeer::VALUE);
        $stmt3 = Tb097ModificacionDetallePeer::doSelectStmt($c3);
        $campos3 = $stmt3->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb096_presupuesto_modificacion"     => $this->getRequestParameter("movimiento"),
                            "id_tb013_anio_fiscal"     => "",
                            "ejecutor"     => $this->getRequestParameter("ejecutor"),
                            "id_tb084_accion_especifica"     => "",
                            "id_tb085_presupuesto"     => "",
                            "nu_partida"     => "",
                            "id_tb098_tipo_distribucion"     => "",
                            "mo_distribucion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "mo_disponible"     => $campos2["mo_debito"]-$campos3["mo_credito"],
                            "id_tb082_ejecutor"     => $this->getRequestParameter("ejecutor")!=""?$this->getRequestParameter("ejecutor"):"",
                            "id_tb139_aplicacion"     => "",
                            "nu_aplicacion"     => "",
                            "id_tb095_tipo_modificacion"     => $campos["id_tb095_tipo_modificacion"],
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");

     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb097_modificacion_detalle = Tb097ModificacionDetallePeer::retrieveByPk($codigo);
     }else{
         $tb097_modificacion_detalle = new Tb097ModificacionDetalle();
     }
     try
      {
        $con->beginTransaction();

        $tb097_modificacion_detalleForm = $this->getRequestParameter('tb097_modificacion_detalle');
/*CAMPOS*/

        /*Campo tipo BIGINT */
        $tb097_modificacion_detalle->setIdTb096PresupuestoModificacion($tb097_modificacion_detalleForm["id_tb096_presupuesto_modificacion"]);

        /*Campo tipo BIGINT */
        $tb097_modificacion_detalle->setIdTb013AnioFiscal($this->getUser()->getAttribute('ejercicio'));

        /*Campo tipo BIGINT */
        $tb097_modificacion_detalle->setIdTb083ProyectoAc($tb097_modificacion_detalleForm["id_tb083_proyecto_ac"]);

        /*Campo tipo BIGINT */
        $tb097_modificacion_detalle->setIdTb084AccionEspecifica($tb097_modificacion_detalleForm["id_tb084_accion_especifica"]);

        /*Campo tipo BIGINT */
        $tb097_modificacion_detalle->setIdTb085Presupuesto($tb097_modificacion_detalleForm["id_tb085_presupuesto"]);

        /*Campo tipo VARCHAR */
        $tb097_modificacion_detalle->setNuPartida($tb097_modificacion_detalleForm["nu_partida"]);

        /*Campo tipo BIGINT */
        $tb097_modificacion_detalle->setIdTb098TipoDistribucion(1);

        /*Campo tipo NUMERIC */
        $tb097_modificacion_detalle->setMoDistribucion($tb097_modificacion_detalleForm["mo_distribucion"]);

        /*Campo tipo BOOLEAN */
        $tb097_modificacion_detalle->setInActivo(true);

        $fecha = date("Y-m-d H:i:s");

        /*Campo tipo TIMESTAMP */
        $tb097_modificacion_detalle->setCreatedAt($fecha);

        /*Campo tipo TIMESTAMP */
        $tb097_modificacion_detalle->setUpdatedAt($fecha);

        /*Campo tipo BIGINT */
        $tb097_modificacion_detalle->setIdTb082EjecutorOrigen($tb097_modificacion_detalleForm["id_tb082_ejecutor_origen"]);

        /*Campo tipo BIGINT */
        //$tb097_modificacion_detalle->setIdTb082EjecutorDestino($tb097_modificacion_detalleForm["id_tb082_ejecutor_destino"]);

        /*CAMPOS*/
        $tb097_modificacion_detalle->save($con);
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

    public function executeGuardarCredito(sfWebRequest $request)
    {

       $codigo = $this->getRequestParameter("id");
       $tb097_modificacion_detalleForm = $this->getRequestParameter('tb097_modificacion_detalle');


       $con = Propel::getConnection();
       if($codigo!=''||$codigo!=null){
           $tb097_modificacion_detalle = Tb097ModificacionDetallePeer::retrieveByPk($codigo);
       }else{
           $tb097_modificacion_detalle = new Tb097ModificacionDetalle();
           
             /*******Validar Traslados Destino************/
            $c_destino = new Criteria();
            $c_destino->add(Tb097ModificacionDetallePeer::ID_TB085_PRESUPUESTO,$tb097_modificacion_detalleForm["id_tb085_presupuesto"]);
            $c_destino->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION, $tb097_modificacion_detalleForm["id_tb096_presupuesto_modificacion"]);
            $cantidad_destino = Tb097ModificacionDetallePeer::doCount($c_destino);

            if ($cantidad_destino >= 1) {
                $this->data = json_encode(array(
                  'success' => false,
                  'msg' => '<span style="color:red;font-size:13px,"><b>La partida ya se encuentra asociada a este tramite!</b></span>'
                ));
   
                return $this->setTemplate('store');
            }
           
       }
       try
        {
          $con->beginTransaction();           
          /*CAMPOS*/

          $c2 = new Criteria();
          $c2->addSelectColumn(Tb068NumeroFuenteFinanciamientoPeer::TX_NUMERO_FUENTE);
          $c2->addSelectColumn(Tb073FuenteFinanciamientoPeer::TX_SIGLAS);
          $c2->add(Tb096PresupuestoModificacionPeer::ID, $tb097_modificacion_detalleForm["id_tb096_presupuesto_modificacion"]);
          $c2->addJoin(Tb096PresupuestoModificacionPeer::ID_TB068_NUMERO_FUENTE_FINANCIAMIENTO, Tb068NumeroFuenteFinanciamientoPeer::CO_NUMERO_FUENTE);
          $c2->addJoin(Tb068NumeroFuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO, Tb073FuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO);
          $stmt2 = Tb096PresupuestoModificacionPeer::doSelectStmt($c2);
          $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);

          $c3 = new Criteria();
          $c3->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
          $c3->addSelectColumn(Tb085PresupuestoPeer::NU_PA);
          $c3->addSelectColumn(Tb085PresupuestoPeer::NU_GE);
          $c3->addSelectColumn(Tb085PresupuestoPeer::NU_ES);
          $c3->addSelectColumn(Tb085PresupuestoPeer::NU_SE);
          $c3->addSelectColumn(Tb085PresupuestoPeer::NU_SSE);
          $c3->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
          $c3->add(Tb085PresupuestoPeer::ID, $tb097_modificacion_detalleForm["id_tb085_presupuesto"]);
          $c3->add(Tb085PresupuestoPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));
          //$c3->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);
          $stmt3 = Tb085PresupuestoPeer::doSelectStmt($c3);
          $campos3 = $stmt3->fetch(PDO::FETCH_ASSOC);

          /*Campo tipo BIGINT */
          $tb097_modificacion_detalle->setIdTb096PresupuestoModificacion($tb097_modificacion_detalleForm["id_tb096_presupuesto_modificacion"]);

          /*Campo tipo BIGINT */
          $tb097_modificacion_detalle->setIdTb013AnioFiscal($this->getUser()->getAttribute('ejercicio'));

          /*Campo tipo BIGINT */
          $tb097_modificacion_detalle->setIdTb083ProyectoAc($tb097_modificacion_detalleForm["id_tb083_proyecto_ac"]);

          /*Campo tipo BIGINT */
          $tb097_modificacion_detalle->setIdTb084AccionEspecifica($tb097_modificacion_detalleForm["id_tb084_accion_especifica"]);

          /*Campo tipo BIGINT */
          $tb097_modificacion_detalle->setIdTb085Presupuesto($tb097_modificacion_detalleForm["id_tb085_presupuesto"]);

          if($campos2["tx_numero_fuente"]!=''||$campos2["tx_numero_fuente"]!=null){
            //$de_partida = $campos3["nu_pa"].$campos3["nu_ge"].$campos3["nu_es"].$campos3["nu_se"].$campos3["nu_sse"].$campos2["tx_siglas"].'0'.$campos2["tx_numero_fuente"];   
            $de_partida = $campos3["nu_pa"].$campos3["nu_ge"].$campos3["nu_es"].$campos3["nu_se"].$campos3["nu_sse"].$campos2["tx_siglas"].$campos2["tx_numero_fuente"]; 
          }else{
            $de_partida = $campos3["nu_partida"];
          }

          /*Campo tipo VARCHAR */
          $tb097_modificacion_detalle->setNuPartida($de_partida);

          /*Campo tipo BIGINT */
          $tb097_modificacion_detalle->setIdTb098TipoDistribucion(2);

          /*Campo tipo NUMERIC */
          $tb097_modificacion_detalle->setMoDistribucion($tb097_modificacion_detalleForm["mo_distribucion"]);

          /*Campo tipo BOOLEAN */
          $tb097_modificacion_detalle->setInActivo(true);

          $fecha = date("Y-m-d H:i:s");

          /*Campo tipo TIMESTAMP */
          $tb097_modificacion_detalle->setCreatedAt($fecha);

          /*Campo tipo TIMESTAMP */
          $tb097_modificacion_detalle->setUpdatedAt($fecha);

          /*Campo tipo BIGINT */
          $tb097_modificacion_detalle->setIdTb082EjecutorDestino($tb097_modificacion_detalleForm["id_tb082_ejecutor"]);

        /*Campo tipo BIGINT */
        $tb097_modificacion_detalle->setIdTb139Aplicacion($tb097_modificacion_detalleForm["id_tb139_aplicacion"]);
                                                    
        /*Campo tipo VARCHAR */
        $tb097_modificacion_detalle->setNuAplicacion($tb097_modificacion_detalleForm["nu_aplicacion"]);

        /*Campo tipo VARCHAR */
        $tb097_modificacion_detalle->setMoDisponible($campos3["mo_disponible"]);

          /*CAMPOS*/
          $tb097_modificacion_detalle->save($con);

          $con->commit();

          $this->data = json_encode(array(
            "success" => true,
            "msg" => 'Modificación realizada exitosamente'
          ));

        }catch (PropelException $e)
        {

          $con->rollback();
          $this->data = json_encode(array(
              "success" => false,
              "msg" =>  $e->getMessage()
          ));

        }

        $this->setTemplate('guardar');
      }

      public function executeGuardarCreditoAdicional(sfWebRequest $request)
      {

                $codigo = $this->getRequestParameter("id");

         $con = Propel::getConnection();
         if($codigo!=''||$codigo!=null){
             $tb097_modificacion_detalle = Tb097ModificacionDetallePeer::retrieveByPk($codigo);
         }else{
             $tb097_modificacion_detalle = new Tb097ModificacionDetalle();
         }
         try
          {
            $con->beginTransaction();

            $tb097_modificacion_detalleForm = $this->getRequestParameter('tb097_modificacion_detalle');
    /*CAMPOS*/

            /*Campo tipo BIGINT */
            $tb097_modificacion_detalle->setIdTb096PresupuestoModificacion($tb097_modificacion_detalleForm["id_tb096_presupuesto_modificacion"]);

            /*Campo tipo BIGINT */
            $tb097_modificacion_detalle->setIdTb013AnioFiscal($this->getUser()->getAttribute('ejercicio'));

            /*Campo tipo BIGINT */
            //$tb097_modificacion_detalle->setIdTb083ProyectoAc($tb097_modificacion_detalleForm["id_tb083_proyecto_ac"]);

            /*Campo tipo BIGINT */
            //$tb097_modificacion_detalle->setIdTb084AccionEspecifica($tb097_modificacion_detalleForm["id_tb084_accion_especifica"]);

            /*Campo tipo BIGINT */
            $tb097_modificacion_detalle->setIdTb064PresupuestoIngreso($tb097_modificacion_detalleForm["id_tb064_presupuesto_ingreso"]);

            /*Campo tipo VARCHAR */
            $tb097_modificacion_detalle->setNuPartida($tb097_modificacion_detalleForm["nu_partida"]);

            /*Campo tipo BIGINT */
            $tb097_modificacion_detalle->setIdTb098TipoDistribucion(1);

            /*Campo tipo NUMERIC */
            $tb097_modificacion_detalle->setMoDistribucion($tb097_modificacion_detalleForm["mo_distribucion"]);

            /*Campo tipo BOOLEAN */
            $tb097_modificacion_detalle->setInActivo(true);

            $fecha = date("Y-m-d H:i:s");

            /*Campo tipo TIMESTAMP */
            $tb097_modificacion_detalle->setCreatedAt($fecha);

            /*Campo tipo TIMESTAMP */
            $tb097_modificacion_detalle->setUpdatedAt($fecha);

            $tb097_modificacion_detalle->setIdTb082EjecutorOrigen($tb097_modificacion_detalleForm["id_tb082_ejecutor_origen"]);

            /*CAMPOS*/
            $tb097_modificacion_detalle->save($con);
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

          $this->setTemplate('guardar');
        }


  public function executeEliminar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("id");
	$con = Propel::getConnection();
	try
	{
	$con->beginTransaction();
	/*CAMPOS*/
	$tb097_modificacion_detalle = Tb097ModificacionDetallePeer::retrieveByPk($codigo);
	$tb097_modificacion_detalle->delete($con);
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
                $id_tb096_presupuesto_modificacion      =   $this->getRequestParameter("id_tb096_presupuesto_modificacion");
            $id_tb013_anio_fiscal      =   $this->getRequestParameter("id_tb013_anio_fiscal");
            $id_tb084_accion_especifica      =   $this->getRequestParameter("id_tb084_accion_especifica");
            $id_tb085_presupuesto      =   $this->getRequestParameter("id_tb085_presupuesto");
            $nu_partida      =   $this->getRequestParameter("nu_partida");
            $id_tb098_tipo_distribucion      =   $this->getRequestParameter("id_tb098_tipo_distribucion");
            $mo_distribucion      =   $this->getRequestParameter("mo_distribucion");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($id_tb096_presupuesto_modificacion!=""){$c->add(Tb097ModificacionDetallePeer::id_tb096_presupuesto_modificacion,$id_tb096_presupuesto_modificacion);}

                                            if($id_tb013_anio_fiscal!=""){$c->add(Tb097ModificacionDetallePeer::id_tb013_anio_fiscal,$id_tb013_anio_fiscal);}

                                            if($id_tb084_accion_especifica!=""){$c->add(Tb097ModificacionDetallePeer::id_tb084_accion_especifica,$id_tb084_accion_especifica);}

                                            if($id_tb085_presupuesto!=""){$c->add(Tb097ModificacionDetallePeer::id_tb085_presupuesto,$id_tb085_presupuesto);}

                                        if($nu_partida!=""){$c->add(Tb097ModificacionDetallePeer::nu_partida,'%'.$nu_partida.'%',Criteria::LIKE);}

                                            if($id_tb098_tipo_distribucion!=""){$c->add(Tb097ModificacionDetallePeer::id_tb098_tipo_distribucion,$id_tb098_tipo_distribucion);}

                                            if($mo_distribucion!=""){$c->add(Tb097ModificacionDetallePeer::mo_distribucion,$mo_distribucion);}



        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb097ModificacionDetallePeer::created_at,$fecha);
    }

        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb097ModificacionDetallePeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
   


        $c->clearSelectColumns();
        $c->addSelectColumn(Tb097ModificacionDetallePeer::ID);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::NU_PARTIDA);
        $c->addSelectColumn(Tb097ModificacionDetallePeer::MO_DISTRIBUCION);
        $c->addSelectColumn(Tb085PresupuestoPeer::CO_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
        $c->addSelectColumn(Tb082EjecutorPeer::NU_EJECUTOR);
        $c->addJoin(Tb085PresupuestoPeer::ID, Tb097ModificacionDetallePeer::ID_TB085_PRESUPUESTO);
        $c->addJoin(Tb097ModificacionDetallePeer::ID_TB082_EJECUTOR_ORIGEN, Tb082EjecutorPeer::ID);
        $c->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
        $c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
        //$c->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);
        $c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
        $c->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$id_tb096_presupuesto_modificacion);
         $cantidadTotal = Tb097ModificacionDetallePeer::doCount($c);

 //$c->setLimit($limit)->setOffset($start);

        $c->addAscendingOrderByColumn(Tb097ModificacionDetallePeer::ID);        

    $stmt = Tb097ModificacionDetallePeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "id_tb096_presupuesto_modificacion"     => trim($res["id_tb096_presupuesto_modificacion"]),
            "id_tb013_anio_fiscal"     => trim($res["id_tb013_anio_fiscal"]),
            "id_tb084_accion_especifica"     => trim($res["id_tb084_accion_especifica"]),
            "id_tb085_presupuesto"     => trim($res["id_tb085_presupuesto"]),
            "nu_partida"     => trim($res["nu_partida"]),
            "co_partida"     => trim($res["co_partida"]),
            "de_partida"     => trim($res["de_partida"]),
            "id_tb098_tipo_distribucion"     => trim($res["id_tb098_tipo_distribucion"]),
            "mo_distribucion"     => trim($res["mo_distribucion"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "nu_ejecutor"     => trim($res["nu_ejecutor"]),
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
      $paginar    =   $this->getRequestParameter("paginar");
      $limit      =   $this->getRequestParameter("limit",1000);
      $start      =   $this->getRequestParameter("start",0);
                  $id_tb096_presupuesto_modificacion      =   $this->getRequestParameter("id_tb096_presupuesto_modificacion");
              $id_tb013_anio_fiscal      =   $this->getRequestParameter("id_tb013_anio_fiscal");
              $id_tb084_accion_especifica      =   $this->getRequestParameter("id_tb084_accion_especifica");
              $id_tb085_presupuesto      =   $this->getRequestParameter("id_tb085_presupuesto");
              $nu_partida      =   $this->getRequestParameter("nu_partida");
              $id_tb098_tipo_distribucion      =   $this->getRequestParameter("id_tb098_tipo_distribucion");
              $mo_distribucion      =   $this->getRequestParameter("mo_distribucion");
              $in_activo      =   $this->getRequestParameter("in_activo");
              $created_at      =   $this->getRequestParameter("created_at");
              $updated_at      =   $this->getRequestParameter("updated_at");


      $c = new Criteria();

      if($this->getRequestParameter("BuscarBy")=="true"){
                                      if($id_tb096_presupuesto_modificacion!=""){$c->add(Tb097ModificacionDetallePeer::id_tb096_presupuesto_modificacion,$id_tb096_presupuesto_modificacion);}

                                              if($id_tb013_anio_fiscal!=""){$c->add(Tb097ModificacionDetallePeer::id_tb013_anio_fiscal,$id_tb013_anio_fiscal);}

                                              if($id_tb084_accion_especifica!=""){$c->add(Tb097ModificacionDetallePeer::id_tb084_accion_especifica,$id_tb084_accion_especifica);}

                                              if($id_tb085_presupuesto!=""){$c->add(Tb097ModificacionDetallePeer::id_tb085_presupuesto,$id_tb085_presupuesto);}

                                          if($nu_partida!=""){$c->add(Tb097ModificacionDetallePeer::nu_partida,'%'.$nu_partida.'%',Criteria::LIKE);}

                                              if($id_tb098_tipo_distribucion!=""){$c->add(Tb097ModificacionDetallePeer::id_tb098_tipo_distribucion,$id_tb098_tipo_distribucion);}

                                              if($mo_distribucion!=""){$c->add(Tb097ModificacionDetallePeer::mo_distribucion,$mo_distribucion);}



          if($created_at!=""){
      list($dia, $mes,$anio) = explode("/",$created_at);
      $fecha = $anio."-".$mes."-".$dia;
      $c->add(Tb097ModificacionDetallePeer::created_at,$fecha);
      }

          if($updated_at!=""){
      list($dia, $mes,$anio) = explode("/",$updated_at);
      $fecha = $anio."-".$mes."-".$dia;
      $c->add(Tb097ModificacionDetallePeer::updated_at,$fecha);
      }
                      }
      $c->setIgnoreCase(true);
      //$cantidadTotal = Tb097ModificacionDetallePeer::doCount($c);

      $c->setLimit($limit)->setOffset($start);

          $c->addAscendingOrderByColumn(Tb097ModificacionDetallePeer::ID);

          $c->clearSelectColumns();
          $c->addSelectColumn(Tb097ModificacionDetallePeer::ID);
          $c->addSelectColumn(Tb097ModificacionDetallePeer::NU_PARTIDA);
          $c->addSelectColumn(Tb097ModificacionDetallePeer::MO_DISTRIBUCION);
          $c->addSelectColumn(Tb064PresupuestoIngresoPeer::TX_PARTIDA);
          $c->addSelectColumn(Tb064PresupuestoIngresoPeer::TX_DESCRIPCION);
          $c->addJoin(Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO, Tb097ModificacionDetallePeer::ID_TB064_PRESUPUESTO_INGRESO);
          $c->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);

          $c->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$id_tb096_presupuesto_modificacion);

      $stmt = Tb097ModificacionDetallePeer::doSelectStmt($c);
      $cantidadTotal = Tb097ModificacionDetallePeer::doCount($c);
      $registros = "";
      while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
      $registros[] = array(
              "id"     => trim($res["id"]),
              "id_tb096_presupuesto_modificacion"     => trim($res["id_tb096_presupuesto_modificacion"]),
              "id_tb013_anio_fiscal"     => trim($res["id_tb013_anio_fiscal"]),
              "id_tb084_accion_especifica"     => trim($res["id_tb084_accion_especifica"]),
              "id_tb085_presupuesto"     => trim($res["id_tb085_presupuesto"]),
              "nu_partida"     => trim($res["nu_partida"]),
              "co_partida"     => trim($res["tx_partida"]),
              "de_partida"     => trim($res["tx_descripcion"]),
              "id_tb098_tipo_distribucion"     => trim($res["id_tb098_tipo_distribucion"]),
              "mo_distribucion"     => trim($res["mo_distribucion"]),
              "in_activo"     => trim($res["in_activo"]),
              "created_at"     => trim($res["created_at"]),
              "updated_at"     => trim($res["updated_at"]),
              "nu_ejecutor"     => trim($res["nu_ejecutor"]),
          );
      }

      $this->data = json_encode(array(
          "success"   =>  true,
          "total"     =>  $cantidadTotal,
          "data"      =>  $registros
          ));

        $this->setTemplate('guardar');

      }


    public function executeStorelistaDestino(sfWebRequest $request)
    {
      $paginar    =   $this->getRequestParameter("paginar");
      $limit      =   $this->getRequestParameter("limit",1000);
      $start      =   $this->getRequestParameter("start",0);
                  $id_tb096_presupuesto_modificacion      =   $this->getRequestParameter("id_tb096_presupuesto_modificacion");
              $id_tb013_anio_fiscal      =   $this->getRequestParameter("id_tb013_anio_fiscal");
              $id_tb084_accion_especifica      =   $this->getRequestParameter("id_tb084_accion_especifica");
              $id_tb085_presupuesto      =   $this->getRequestParameter("id_tb085_presupuesto");
              $nu_partida      =   $this->getRequestParameter("nu_partida");
              $id_tb098_tipo_distribucion      =   $this->getRequestParameter("id_tb098_tipo_distribucion");
              $mo_distribucion      =   $this->getRequestParameter("mo_distribucion");
              $in_activo      =   $this->getRequestParameter("in_activo");
              $created_at      =   $this->getRequestParameter("created_at");
              $updated_at      =   $this->getRequestParameter("updated_at");


      $c = new Criteria();

      if($this->getRequestParameter("BuscarBy")=="true"){
                                      if($id_tb096_presupuesto_modificacion!=""){$c->add(Tb097ModificacionDetallePeer::id_tb096_presupuesto_modificacion,$id_tb096_presupuesto_modificacion);}

                                              if($id_tb013_anio_fiscal!=""){$c->add(Tb097ModificacionDetallePeer::id_tb013_anio_fiscal,$id_tb013_anio_fiscal);}

                                              if($id_tb084_accion_especifica!=""){$c->add(Tb097ModificacionDetallePeer::id_tb084_accion_especifica,$id_tb084_accion_especifica);}

                                              if($id_tb085_presupuesto!=""){$c->add(Tb097ModificacionDetallePeer::id_tb085_presupuesto,$id_tb085_presupuesto);}

                                          if($nu_partida!=""){$c->add(Tb097ModificacionDetallePeer::nu_partida,'%'.$nu_partida.'%',Criteria::LIKE);}

                                              if($id_tb098_tipo_distribucion!=""){$c->add(Tb097ModificacionDetallePeer::id_tb098_tipo_distribucion,$id_tb098_tipo_distribucion);}

                                              if($mo_distribucion!=""){$c->add(Tb097ModificacionDetallePeer::mo_distribucion,$mo_distribucion);}



          if($created_at!=""){
      list($dia, $mes,$anio) = explode("/",$created_at);
      $fecha = $anio."-".$mes."-".$dia;
      $c->add(Tb097ModificacionDetallePeer::created_at,$fecha);
      }

          if($updated_at!=""){
      list($dia, $mes,$anio) = explode("/",$updated_at);
      $fecha = $anio."-".$mes."-".$dia;
      $c->add(Tb097ModificacionDetallePeer::updated_at,$fecha);
      }
                      }
      $c->setIgnoreCase(true);
      //$cantidadTotal = Tb097ModificacionDetallePeer::doCount($c);

      $c->setLimit($limit)->setOffset($start);

          $c->addAscendingOrderByColumn(Tb097ModificacionDetallePeer::ID);

          $c->clearSelectColumns();
          $c->addSelectColumn(Tb097ModificacionDetallePeer::ID);
          $c->addSelectColumn(Tb097ModificacionDetallePeer::NU_PARTIDA);
          $c->addSelectColumn(Tb097ModificacionDetallePeer::MO_DISTRIBUCION);
          //$c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
          $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
          $c->addSelectColumn(Tb082EjecutorPeer::NU_EJECUTOR);
          $c->addSelectColumn(Tb082EjecutorPeer::DE_EJECUTOR);
          $c->addJoin(Tb085PresupuestoPeer::ID, Tb097ModificacionDetallePeer::ID_TB085_PRESUPUESTO);
          $c->addJoin(Tb097ModificacionDetallePeer::ID_TB082_EJECUTOR_DESTINO, Tb082EjecutorPeer::ID);
          $c->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 2);
          $c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
         // $c->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);
          $c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
          $c->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$id_tb096_presupuesto_modificacion);

      $stmt = Tb097ModificacionDetallePeer::doSelectStmt($c);
      $cantidadTotal = Tb097ModificacionDetallePeer::doCount($c);
      $registros = "";
      while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
      $registros[] = array(
              "id"     => trim($res["id"]),
              "id_tb096_presupuesto_modificacion"     => trim($res["id_tb096_presupuesto_modificacion"]),
              "id_tb013_anio_fiscal"     => trim($res["id_tb013_anio_fiscal"]),
              "id_tb084_accion_especifica"     => trim($res["id_tb084_accion_especifica"]),
              "id_tb085_presupuesto"     => trim($res["id_tb085_presupuesto"]),
              "nu_partida"     => trim($res["nu_partida"]),
              "co_partida"     => trim($res["nu_partida"]),
              "de_partida"     => trim($res["de_partida"]),
              "id_tb098_tipo_distribucion"     => trim($res["id_tb098_tipo_distribucion"]),
              "mo_distribucion"     => trim($res["mo_distribucion"]),
              "in_activo"     => trim($res["in_activo"]),
              "created_at"     => trim($res["created_at"]),
              "updated_at"     => trim($res["updated_at"]),
              "nu_ejecutor"     => trim($res["nu_ejecutor"]),
              "de_ejecutor"     => trim($res["de_ejecutor"]),
          );
      }

      $this->data = json_encode(array(
          "success"   =>  true,
          "total"     =>  $cantidadTotal,
          "data"      =>  $registros
          ));

          $this->setTemplate('storelista');
      }

                    //modelo fk tb096_presupuesto_modificacion.ID
    public function executeStorefkidtb096presupuestomodificacion(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
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

    //modelo fk tb084_accion_especifica.ID
    public function executeStorefkidtb084accionespecifica(sfWebRequest $request){
      $codigo      =   $this->getRequestParameter("ac");

      $c = new Criteria();
      $c->add(Tb084AccionEspecificaPeer::ID_TB083_PROYECTO_AC, $codigo);
      $stmt = Tb084AccionEspecificaPeer::doSelectStmt($c);
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
    //modelo fk tb085_presupuesto.ID
    public function executeStorefkidtb085presupuesto(sfWebRequest $request){
      $codigo      =   $this->getRequestParameter("ae");

      $c = new Criteria();
      $c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA, $codigo);
      $c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
      //$c->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);
      $c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
      $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
      $registros = array();
      while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
        $reg["co_partida"]=$reg["nu_partida"];
        $registros[] = $reg;
      }

      $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  count($registros),
        "data"      =>  $registros
      ));
      $this->setTemplate('store');
    }

        //modelo fk tb085_presupuesto.ID
        public function executeStorefkidtb085presupuestoCredito(sfWebRequest $request){
            $codigo      =   $this->getRequestParameter("ae");
            $id_tb095_tipo_modificacion      =   $this->getRequestParameter("id_tb095_tipo_modificacion");

            $subSelect = "tb085_presupuesto.nu_fi IN (SELECT nu_fi
            FROM tb097_modificacion_detalle as tb097
            INNER JOIN tb085_presupuesto as tb085 ON tb097.id_tb085_presupuesto = tb085.id
            WHERE id_tb096_presupuesto_modificacion = ".$this->getRequestParameter("id_tb096_presupuesto_modificacion")."
            GROUP BY 1
            )";

            $c = new Criteria();
            $c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA, $codigo);
            //$c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
            //$c->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);            
            if($id_tb095_tipo_modificacion==1){
            $c->add(Tb085PresupuestoPeer::NU_FI, $subSelect, Criteria::CUSTOM);    
            }

            $c->add(Tb085PresupuestoPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));
            //$c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
            $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
            $registros = array();
            while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
              $reg["co_partida"]=$reg["nu_partida"];
              $registros[] = $reg;
            }
      
            $this->data = json_encode(array(
              "success"   =>  true,
              "total"     =>  count($registros),
              "data"      =>  $registros
            ));
            $this->setTemplate('store');
          }          
          
        public function executeStorefkidtb085presupuestoCreditoAdicional(sfWebRequest $request){
            $codigo      =   $this->getRequestParameter("ae");

            $subSelect = "tb085_presupuesto.nu_fi IN (SELECT nu_fi
            FROM tb097_modificacion_detalle as tb097
            INNER JOIN tb085_presupuesto as tb085 ON tb097.id_tb085_presupuesto = tb085.id
            WHERE id_tb096_presupuesto_modificacion = ".$this->getRequestParameter("id_tb096_presupuesto_modificacion")."
            GROUP BY 1
            )";

            $c = new Criteria();
            $c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA, $codigo);
            //$c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
            //$c->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);
            //$c->add(Tb085PresupuestoPeer::NU_FI, $subSelect, Criteria::CUSTOM);
            $c->add(Tb085PresupuestoPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));
            //$c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
            $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
            $registros = array();
            while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
              $reg["co_partida"]=$reg["nu_partida"];
              $registros[] = $reg;
            }
      
            $this->data = json_encode(array(
              "success"   =>  true,
              "total"     =>  count($registros),
              "data"      =>  $registros
            ));
            $this->setTemplate('store');
          }          

    //modelo fk tb064_presupuesto_ingreso.ID
    public function executeStorefkidtb064presupuestoingreso(sfWebRequest $request){
      $codigo      =   $this->getRequestParameter("movimiento");

      $c = new Criteria();
      //$c->add(Tb064PresupuestoIngresoPeer::ID_TB084_ACCION_ESPECIFICA, $codigo);
      $c->add(Tb064PresupuestoIngresoPeer::NU_NIVEL, 6);
      $c->add(Tb064PresupuestoIngresoPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));
      $stmt = Tb064PresupuestoIngresoPeer::doSelectStmt($c);
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

    //modelo fk tb139_aplicacion.CO_APLICACION
    public function executeStorefkidtb139aplicacion(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb139AplicacionPeer::NU_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
        $stmt = Tb139AplicacionPeer::doSelectStmt($c);
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
