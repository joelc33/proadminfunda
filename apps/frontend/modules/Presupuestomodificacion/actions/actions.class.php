<?php

/**
 * Presupuestomodificacion actions.
 *
 * @package    gobel
 * @subpackage Presupuestomodificacion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class PresupuestomodificacionActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Presupuestomodificacion', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Presupuestomodificacion', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb096PresupuestoModificacionPeer::ID,$codigo);

        $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb095_tipo_modificacion"     => $campos["id_tb095_tipo_modificacion"],
                            "nu_modificacion"     => $campos["nu_modificacion"],
                            "fe_modificacion"     => $campos["fe_modificacion"],
                            "de_modificacion"     => $campos["de_modificacion"],
                            "de_justificacion"     => $campos["de_justificacion"],
                            "nu_oficio"     => $campos["nu_oficio"],
                            "fe_oficio"     => $campos["fe_oficio"],
                            "de_articulo_ley"     => $campos["de_articulo_ley"],
                            "mo_modificacion"     => $campos["mo_modificacion"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb095_tipo_modificacion"     => "",
                            "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                            "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                            "nu_modificacion"     => "",
                            "fe_modificacion"     => "",
                            "de_modificacion"     => "",
                            "de_justificacion"     => "",
                            "nu_oficio"     => "",
                            "fe_oficio"     => "",
                            "de_articulo_ley"     => "",
                            "mo_modificacion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeTraspaso(sfWebRequest $request)
  {
    //$codigo = $this->getRequestParameter("codigo");
    $codigo = $this->getRequestParameter("co_solicitud");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tb096PresupuestoModificacionPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        if($campos["id"]!=''){

                      $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb095_tipo_modificacion"     => $campos["id_tb095_tipo_modificacion"],
                            "nu_modificacion"     => $campos["nu_modificacion"],
                            "fe_modificacion"     => $campos["fe_modificacion"],
                            "de_modificacion"     => $campos["de_modificacion"],
                            "de_justificacion"     => $campos["de_justificacion"],
                            "nu_oficio"     => $campos["nu_oficio"],
                            "fe_oficio"     => $campos["fe_oficio"],
                            "de_articulo_ley"     => $campos["de_articulo_ley"],
                            "mo_modificacion"     => $campos["mo_modificacion"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "id_tb082_ejecutor"     => $campos["id_tb082_ejecutor"],
                            "id_tb083_proyecto_ac"     => $campos["id_tb083_proyecto_ac"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
                            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre')
                    ));
        }else{
                    $this->data = json_encode(array(
                            "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                            "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                            "id"     => "",
                            "id_tb095_tipo_modificacion"     => "",
                            "nu_modificacion"     => "",
                            "fe_modificacion"     => "",
                            "de_modificacion"     => "",
                            "de_justificacion"     => "",
                            "nu_oficio"     => "",
                            "fe_oficio"     => "",
                            "de_articulo_ley"     => "",
                            "mo_modificacion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "id_tb082_ejecutor"     => "",
                            "id_tb083_proyecto_ac"     => "",
                            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
                            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre')
                    ));
        }
    }else{
                    $this->data = json_encode(array(
                            "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                            "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                            "id"     => "",
                            "id_tb095_tipo_modificacion"     => "",
                            "nu_modificacion"     => "",
                            "fe_modificacion"     => "",
                            "de_modificacion"     => "",
                            "de_justificacion"     => "",
                            "nu_oficio"     => "",
                            "fe_oficio"     => "",
                            "de_articulo_ley"     => "",
                            "mo_modificacion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "id_tb082_ejecutor"     => "",
                            "id_tb083_proyecto_ac"     => "",
                    ));
    }

  }
  
  public function executeReformulacion(sfWebRequest $request)
  {
    //$codigo = $this->getRequestParameter("codigo");
    $codigo = $this->getRequestParameter("co_solicitud");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tb096PresupuestoModificacionPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        if($campos["id"]!=''){

                      $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb095_tipo_modificacion"     => $campos["id_tb095_tipo_modificacion"],
                            "nu_modificacion"     => $campos["nu_modificacion"],
                            "fe_modificacion"     => $campos["fe_modificacion"],
                            "de_modificacion"     => $campos["de_modificacion"],
                            "de_justificacion"     => $campos["de_justificacion"],
                            "nu_oficio"     => $campos["nu_oficio"],
                            "fe_oficio"     => $campos["fe_oficio"],
                            "de_articulo_ley"     => $campos["de_articulo_ley"],
                            "mo_modificacion"     => $campos["mo_modificacion"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "id_tb082_ejecutor"     => $campos["id_tb082_ejecutor"],
                            "id_tb083_proyecto_ac"     => $campos["id_tb083_proyecto_ac"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
                            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre')
                    ));
        }else{
                    $this->data = json_encode(array(
                            "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                            "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                            "id"     => "",
                            "id_tb095_tipo_modificacion"     => "",
                            "nu_modificacion"     => "",
                            "fe_modificacion"     => "",
                            "de_modificacion"     => "",
                            "de_justificacion"     => "",
                            "nu_oficio"     => "",
                            "fe_oficio"     => "",
                            "de_articulo_ley"     => "",
                            "mo_modificacion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "id_tb082_ejecutor"     => "",
                            "id_tb083_proyecto_ac"     => "",
                            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
                            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre')
                    ));
        }
    }else{
                    $this->data = json_encode(array(
                            "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                            "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                            "id"     => "",
                            "id_tb095_tipo_modificacion"     => "",
                            "nu_modificacion"     => "",
                            "fe_modificacion"     => "",
                            "de_modificacion"     => "",
                            "de_justificacion"     => "",
                            "nu_oficio"     => "",
                            "fe_oficio"     => "",
                            "de_articulo_ley"     => "",
                            "mo_modificacion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "id_tb082_ejecutor"     => "",
                            "id_tb083_proyecto_ac"     => "",
                    ));
    }

  }  

  public function executeCreditoadicional(sfWebRequest $request)
  {
    //$codigo = $this->getRequestParameter("codigo");
    $codigo = $this->getRequestParameter("co_solicitud");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tb096PresupuestoModificacionPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);



        if($campos["id"]!=''){

          $c2 = new Criteria();
          $c2->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB082_EJECUTOR_ORIGEN);
          $c2->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION, $campos["id"]);
          $c2->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
          $stmt2 = Tb097ModificacionDetallePeer::doSelectStmt($c2);
          $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);
  
          $c3 = new Criteria();
          $c3->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB082_EJECUTOR_DESTINO);
          $c3->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION, $campos["id"]);
          $c3->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 2);
          $stmt3 = Tb097ModificacionDetallePeer::doSelectStmt($c3);
          $campos3 = $stmt3->fetch(PDO::FETCH_ASSOC);

                      $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb095_tipo_modificacion"     => $campos["id_tb095_tipo_modificacion"],
                            "nu_modificacion"     => $campos["nu_modificacion"],
                            "fe_modificacion"     => $campos["fe_modificacion"],
                            "de_modificacion"     => $campos["de_modificacion"],
                            "de_justificacion"     => $campos["de_justificacion"],
                            "nu_oficio"     => $campos["nu_oficio"],
                            "fe_oficio"     => $campos["fe_oficio"],
                            "de_articulo_ley"     => $campos["de_articulo_ley"],
                            "mo_modificacion"     => $campos["mo_modificacion"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "id_tb082_ejecutor_origen"     => $campos["id_tb082_ejecutor_origen"],
                            "id_tb082_ejecutor_destino"     => $campos["id_tb082_ejecutor_destino"],
                            "id_tb083_proyecto_ac"     => $campos["id_tb083_proyecto_ac"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                            "id_tb068_numero_fuente_financiamiento"     => $campos["id_tb068_numero_fuente_financiamiento"],
                            "id_tb152_tipo_credito"     => $campos["id_tb152_tipo_credito"],
                            "id_tb073_fuente_financiamiento"     => $campos["id_tb073_fuente_financiamiento"],
                    ));
        }else{
                    $this->data = json_encode(array(
                            "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                            "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                            "id"     => "",
                            "id_tb095_tipo_modificacion"     => "",
                            "nu_modificacion"     => "",
                            "fe_modificacion"     => "",
                            "de_modificacion"     => "",
                            "de_justificacion"     => "",
                            "nu_oficio"     => "",
                            "fe_oficio"     => "",
                            "de_articulo_ley"     => "",
                            "mo_modificacion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "id_tb082_ejecutor_origen"     => "",
                            "id_tb082_ejecutor_destino"     => "",
                            "id_tb083_proyecto_ac"     => "",
                            "id_tb068_numero_fuente_financiamiento"     => "",
                            "id_tb152_tipo_credito"     => "",
                            "id_tb073_fuente_financiamiento"     => "",
                    ));
        }
    }else{
                    $this->data = json_encode(array(
                            "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                            "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                            "id"     => "",
                            "id_tb095_tipo_modificacion"     => "",
                            "nu_modificacion"     => "",
                            "fe_modificacion"     => "",
                            "de_modificacion"     => "",
                            "de_justificacion"     => "",
                            "nu_oficio"     => "",
                            "fe_oficio"     => "",
                            "de_articulo_ley"     => "",
                            "mo_modificacion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "id_tb082_ejecutor"     => "",
                            "id_tb083_proyecto_ac"     => "",
                            "id_tb068_numero_fuente_financiamiento"     => "",
                            "id_tb152_tipo_credito"     => "",
                            "id_tb073_fuente_financiamiento"     => "",
                    ));
    }

  }
  
  public function executeCompromisoley(sfWebRequest $request)
  {
    //$codigo = $this->getRequestParameter("codigo");
    $codigo = $this->getRequestParameter("co_solicitud");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tb096PresupuestoModificacionPeer::CO_SOLICITUD, $codigo);

        $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);



        if($campos["id"]!=''){

          $c2 = new Criteria();
          $c2->addSelectColumn(Tb097ModificacionDetallePeer::ID);
          $c2->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB082_EJECUTOR_ORIGEN);
          $c2->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB064_PRESUPUESTO_INGRESO);
          $c2->addSelectColumn(Tb097ModificacionDetallePeer::MO_DISTRIBUCION);
          $c2->addSelectColumn(Tb064PresupuestoIngresoPeer::MO_INICIAL);
          $c2->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION, $campos["id"]);
          $c2->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
          $c2->addJoin(Tb097ModificacionDetallePeer::ID_TB064_PRESUPUESTO_INGRESO, Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO);
          $stmt2 = Tb097ModificacionDetallePeer::doSelectStmt($c2);
          $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);

            if($campos2["mo_inicial"]==null){
            $monto_disponible = 0;
            }else{
            $monto_disponible = $campos2["mo_inicial"];
            }
                      $this->data = json_encode(array(
                            "id_tb096_presupuesto_modificacion"     => $campos["id"],
                            "id_tb095_tipo_modificacion"     => $campos["id_tb095_tipo_modificacion"],
                            "nu_modificacion"     => $campos["nu_modificacion"],
                            "fe_modificacion"     => $campos["fe_modificacion"],
                            "de_modificacion"     => $campos["de_modificacion"],
                            "de_justificacion"     => $campos["de_justificacion"],
                            "nu_oficio"     => $campos["nu_oficio"],
                            "fe_oficio"     => $campos["fe_oficio"],
                            "de_articulo_ley"     => $campos["de_articulo_ley"],
                            "mo_modificacion"     => $campos["mo_modificacion"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "id_tb097_modificacion_detalle"     => $campos2["id"],
                            "id_tb082_ejecutor_origen"     => $campos2["id_tb082_ejecutor_origen"],
                            "id_tb064_presupuesto_ingreso"     => $campos2["id_tb064_presupuesto_ingreso"],
                            "mo_distribucion"     => $campos2["mo_distribucion"],
                            "mo_disponible"     => $monto_disponible,
                            "id_tb083_proyecto_ac"     => $campos["id_tb083_proyecto_ac"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                    ));
        }else{
                    $this->data = json_encode(array(
                            "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                            "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                            "id_tb096_presupuesto_modificacion"     => "",
                            "id_tb095_tipo_modificacion"     => "",
                            "nu_modificacion"     => "",
                            "fe_modificacion"     => "",
                            "de_modificacion"     => "",
                            "de_justificacion"     => "",
                            "nu_oficio"     => "",
                            "fe_oficio"     => "",
                            "de_articulo_ley"     => "",
                            "mo_modificacion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "id_tb097_modificacion_detalle"     => $campos2["id"],
                            "id_tb082_ejecutor_origen"     => "",
                            "id_tb064_presupuesto_ingreso"     => "",
                            "mo_distribucion"     => "",
                            "mo_disponible"     => "",                        
                            "id_tb083_proyecto_ac"     => "",
                    ));
        }
    }else{
                    $this->data = json_encode(array(
                            "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                            "co_tipo_solicitud"  => $this->getRequestParameter("co_tipo_solicitud"),
                            "id"     => "",
                            "id_tb095_tipo_modificacion"     => "",
                            "nu_modificacion"     => "",
                            "fe_modificacion"     => "",
                            "de_modificacion"     => "",
                            "de_justificacion"     => "",
                            "nu_oficio"     => "",
                            "fe_oficio"     => "",
                            "de_articulo_ley"     => "",
                            "mo_modificacion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "id_tb082_ejecutor"     => "",
                            "id_tb083_proyecto_ac"     => "",
                    ));
    }

  }  

  
  public function executeAgregarDatos(sfWebRequest $request)
  {
        //$codigo = $this->getRequestParameter("codigo");
        $codigo = $this->getRequestParameter("co_solicitud");
        if($codigo!=''||$codigo!=null){
            $c = new Criteria();
            $c->add(Tb096PresupuestoModificacionPeer::CO_SOLICITUD, $codigo);

            $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);       

            $this->data = json_encode(array(
                    "id"     => $campos["id"],
                    "id_tb095_tipo_modificacion"     => $campos["id_tb095_tipo_modificacion"],
                    "nu_modificacion"     => $campos["nu_modificacion"],
                    "fe_modificacion"     => $campos["fe_modificacion"],
                    "de_modificacion"     => $campos["de_modificacion"],
                    "de_justificacion"     => $campos["de_justificacion"],
                    "nu_oficio"     => $campos["nu_oficio"],
                    "fe_oficio"     => $campos["fe_oficio"],
                    "de_articulo_ley"     => $campos["de_articulo_ley"],
                    "mo_modificacion"     => $campos["mo_modificacion"],
                    "in_activo"     => $campos["in_activo"],
                    "created_at"     => $campos["created_at"],
                    "updated_at"     => $campos["updated_at"],
                    "id_tb082_ejecutor"     => $campos["id_tb082_ejecutor"],
                    "id_tb083_proyecto_ac"     => $campos["id_tb083_proyecto_ac"],
                    "co_solicitud"     => $campos["co_solicitud"],
                    "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
            ));        
        }

  }
  
  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("id");

     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){

         /*******Validar Traslados Origen************/
         $c_origen = new Criteria();
         $c_origen->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
         $c_origen->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
         $cantidad_origen = Tb097ModificacionDetallePeer::doCount($c_origen);

         $sum_origen = new Criteria();
         $sum_origen->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
         $sum_origen->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
         $sum_origen->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') AS suma_origen');
         $suma_origen = Tb097ModificacionDetallePeer::doSelectStmt($sum_origen);
         $campos_origen = $suma_origen->fetch(PDO::FETCH_ASSOC);

         
         if ($cantidad_origen <= 0) {
           $this->data = json_encode(array(
             'success' => false,
             'msg' => '<span style="color:red;font-size:13px,"><b>Se debe al menos cargar una partida de origen!</b></span>'
           ));

           return $this->setTemplate('store');
         }

         /*******Validar Traslados Destino************/
         $c_destino = new Criteria();
         $c_destino->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
         $c_destino->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 2);
         $cantidad_destino = Tb097ModificacionDetallePeer::doCount($c_destino);

         $sum_destino = new Criteria();
         $sum_destino->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
         $sum_destino->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 2);
         $sum_destino->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') AS suma_destino');
         $suma_destino = Tb097ModificacionDetallePeer::doSelectStmt($sum_destino);
         $campos_destino = $suma_destino->fetch(PDO::FETCH_ASSOC);

         if ($cantidad_destino <= 0) {
           $this->data = json_encode(array(
             'success' => false,
             'msg' => '<span style="color:red;font-size:13px,"><b>Se debe al menos cargar una partida de destino!</b></span>'
           ));

           return $this->setTemplate('store');
         }

         if ($campos_origen["suma_origen"] != $campos_destino["suma_destino"] ) {

           $resta_traslado = $campos_origen["suma_origen"] -$campos_destino["suma_destino"];

           $this->data = json_encode(array(
             'success' => false,
             'msg' => '<span style="color:red;font-size:13px,"><b>El monto total de las partidas de origen deben ser igual a las partidas de destino!<br></b></span>Diferencia: <b>'.$resta_traslado.'</b>'
           ));

           return $this->setTemplate('store');
         }

         $tb096_presupuesto_modificacion = Tb096PresupuestoModificacionPeer::retrieveByPk($codigo);

         try
          {
            $con->beginTransaction();

            $tb096_presupuesto_modificacionForm = $this->getRequestParameter('tb096_presupuesto_modificacion');
            if($tb096_presupuesto_modificacionForm["fe_modificacion"]!=''){
                list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_modificacion"]);
                $fecha = $anio."-".$mes."-".$dia;
                $tb096_presupuesto_modificacion->setFeModificacion($fecha);
            }

            $tb096_presupuesto_modificacion->setDeModificacion($tb096_presupuesto_modificacionForm["de_modificacion"]);
            $tb096_presupuesto_modificacion->setDeJustificacion($tb096_presupuesto_modificacionForm["de_justificacion"]);
            $tb096_presupuesto_modificacion->setNuOficio($tb096_presupuesto_modificacionForm["nu_oficio"]);
        
            if($tb096_presupuesto_modificacionForm["fe_oficio"]!=''){
                list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_oficio"]);
                $fecha = $anio."-".$mes."-".$dia;
                $tb096_presupuesto_modificacion->setFeOficio($fecha);
            }

            /*Campo tipo VARCHAR */
            $tb096_presupuesto_modificacion->setDeArticuloLey($tb096_presupuesto_modificacionForm["de_articulo_ley"]);
            $tb096_presupuesto_modificacion->setInActivo(true);
            $fecha = date("Y-m-d H:i:s");
            $tb096_presupuesto_modificacion->setUpdatedAt($fecha);
            $tb096_presupuesto_modificacion->setCoUsuario($this->getUser()->getAttribute('codigo'));
            $tb096_presupuesto_modificacion->save($con);

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb096PresupuestoModificacionPeer::NU_MODIFICACION);
            $c->add(Tb096PresupuestoModificacionPeer::ID, $tb096_presupuesto_modificacion->getId());
            $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $sum_destino = new Criteria();
            $sum_destino->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
            $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION);
            $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::MO_DISTRIBUCION);
            $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB085_PRESUPUESTO);
            $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID);
            $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::IN_TRASPASO);
            $suma_destino = Tb097ModificacionDetallePeer::doSelectStmt($sum_destino);
            
            while($campos_destino = $suma_destino->fetch(PDO::FETCH_ASSOC)){
               
                  if($campos_destino["in_traspaso"]!=true){
                        if($campos_destino["id_tb098_tipo_distribucion"]==1){    

                            $tb085_persupuesto = Tb085PresupuestoPeer::retrieveByPK($campos_destino["id_tb085_presupuesto"]);

                            $saldo_anterior = $tb085_persupuesto->getMoDisponible();
                            $saldo_nuevo = $tb085_persupuesto->getMoDisponible()-$campos_destino["mo_distribucion"];

//                            $tb085_persupuesto->setMoActualizado($tb085_persupuesto->getMoActualizado()-$campos_destino["mo_distribucion"]);
//                          //  $tb085_persupuesto->setMoDisponible($tb085_persupuesto->getMoDisponible()-$campos_destino["mo_distribucion"]);
//                            $tb085_persupuesto->save($con);

                            $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                            $tb087_presupuesto_movimiento->setCoPartida($campos_destino["id_tb085_presupuesto"])
                                             ->setCoTipoMovimiento(8)
                                             ->setNuMonto($campos_destino["mo_distribucion"])
                                             ->setNuAnio($campos_destino["id_tb013_anio_fiscal"])
                                             ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                             ->setTxObservacion('TRASPASO ENTRE PARTIDAS')
                                             ->setMoSaldoNuevo($saldo_nuevo)
                                             ->setMoSaldoAnterior($saldo_anterior)
                                             ->setInActivo(true)
                                             ->save($con);
                                             
                        }else{

                            $tb085_persupuesto = Tb085PresupuestoPeer::retrieveByPK($campos_destino["id_tb085_presupuesto"]);

                            $saldo_anterior = $tb085_persupuesto->getMoDisponible();
                            $saldo_nuevo = $tb085_persupuesto->getMoDisponible()+$campos_destino["mo_distribucion"];

//                            $tb085_persupuesto->setMoActualizado($tb085_persupuesto->getMoActualizado()+$campos_destino["mo_distribucion"]);
//                            $tb085_persupuesto->setMoDisponible($tb085_persupuesto->getMoDisponible()+$campos_destino["mo_distribucion"]);
//                            $tb085_persupuesto->save($con);
                            
                            $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                            $tb087_presupuesto_movimiento->setCoPartida($campos_destino["id_tb085_presupuesto"])
                                             ->setCoTipoMovimiento(7)
                                             ->setNuMonto($campos_destino["mo_distribucion"])
                                             ->setNuAnio($campos_destino["id_tb013_anio_fiscal"])
                                             ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                             ->setTxObservacion('TRASPASO ENTRE PARTIDAS')
                                             ->setMoSaldoNuevo($saldo_nuevo)
                                             ->setMoSaldoAnterior($saldo_anterior)
                                             ->setInActivo(true)
                                             ->save($con);
                        }

                        $tb097_movimiento = Tb097ModificacionDetallePeer::retrieveByPK($campos_destino["id"]);
                        $tb097_movimiento->setInTraspaso(true)->save($con);
                  }
            }
                        

            $this->data = json_encode(array(
      				'success' => true,
              'numero' => $campos["nu_modificacion"],
              'codigo' => $tb096_presupuesto_modificacion->getId(),
      				'msg' => '<span style="color:green;font-size:13px,">Datos Editado con exito!.<br>
      			    Numero de Movimiento <br><textarea readonly>'.$campos["nu_modificacion"].'</textarea></span>'
      			));

//            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb096_presupuesto_modificacionForm["co_solicitud"]));
//            $ruta->setInCargarDato(true)->save($con);
//
//            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

            $con->commit();

          }catch (PropelException $e)
          {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
          }

     }else{
         $tb096_presupuesto_modificacion = new Tb096PresupuestoModificacion();

         try
          {
            $con->beginTransaction();

            $tb096_presupuesto_modificacionForm = $this->getRequestParameter('tb096_presupuesto_modificacion');
    /*CAMPOS*/
             if($tb096_presupuesto_modificacionForm["co_tipo_solicitud"]==6){
                $tipo_modificacion = 1; 
             }else{
                 $tipo_modificacion = 6;
             }
            /*Campo tipo BIGINT */
            $tb096_presupuesto_modificacion->setIdTb095TipoModificacion($tipo_modificacion);

            /*Campo tipo VARCHAR */
            $tb096_presupuesto_modificacion->setNuModificacion($tb096_presupuesto_modificacionForm["nu_modificacion"]);

            /*Campo tipo DATE */
            list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_modificacion"]);
            $fecha = $anio."-".$mes."-".$dia;
            $tb096_presupuesto_modificacion->setFeModificacion($fecha);

            /*Campo tipo VARCHAR */
            $tb096_presupuesto_modificacion->setDeModificacion($tb096_presupuesto_modificacionForm["de_modificacion"]);

            /*Campo tipo VARCHAR */
            $tb096_presupuesto_modificacion->setDeJustificacion($tb096_presupuesto_modificacionForm["de_justificacion"]);

            /*Campo tipo DATE */
            $tb096_presupuesto_modificacion->setNuOficio($tb096_presupuesto_modificacionForm["nu_oficio"]);

            /*Campo tipo DATE */
            list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_oficio"]);
            $fecha = $anio."-".$mes."-".$dia;
            $tb096_presupuesto_modificacion->setFeOficio($fecha);

            /*Campo tipo VARCHAR */
            $tb096_presupuesto_modificacion->setDeArticuloLey($tb096_presupuesto_modificacionForm["de_articulo_ley"]);

            /*Campo tipo NUMERIC */
            //$tb096_presupuesto_modificacion->setMoModificacion($tb096_presupuesto_modificacionForm["mo_modificacion"]);

            /*Campo tipo BOOLEAN */
            $tb096_presupuesto_modificacion->setInActivo(true);

            /*Campo tipo TIMESTAMP */
            $fecha = date("Y-m-d H:i:s");
            $tb096_presupuesto_modificacion->setCreatedAt($fecha);

            /*Campo tipo TIMESTAMP */
            $tb096_presupuesto_modificacion->setUpdatedAt($fecha);

            /*Campo tipo BIGINT */
            $tb096_presupuesto_modificacion->setIdTb082Ejecutor($tb096_presupuesto_modificacionForm["id_tb082_ejecutor"]);

            /*Campo tipo BIGINT */
            $tb096_presupuesto_modificacion->setIdTb013AnioFiscal($this->getUser()->getAttribute('ejercicio'));

            /*Campo tipo BIGINT */
            $tb096_presupuesto_modificacion->setCoUsuario($this->getUser()->getAttribute('codigo'));

            /*Campo tipo BIGINT */
            $tb096_presupuesto_modificacion->setCoSolicitud($tb096_presupuesto_modificacionForm["co_solicitud"]);

            /*Campo tipo BIGINT */
            $tb096_presupuesto_modificacion->setCoTipoSolicitud($tb096_presupuesto_modificacionForm["co_tipo_solicitud"]);

            /*CAMPOS*/
            $tb096_presupuesto_modificacion->save($con);

            /*$this->data = json_encode(array(
                        "success" => true,
                        "msg" => 'Modificación realizada exitosamente'
                    ));*/
            //$con->commit();

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb096PresupuestoModificacionPeer::NU_MODIFICACION);
            $c->add(Tb096PresupuestoModificacionPeer::ID, $tb096_presupuesto_modificacion->getId());
            $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->data = json_encode(array(
      				'success' => true,
              'numero' => $campos["nu_modificacion"],
              'codigo' => $tb096_presupuesto_modificacion->getId(),
      				'msg' => '<span style="color:green;font-size:13px,">Datos Guardados con exito!.<br>
      			    Numero de Movimiento <br><textarea readonly>'.$campos["nu_modificacion"].'</textarea></span>'
      			));

//            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb096_presupuesto_modificacionForm["co_solicitud"]));
//            $ruta->setInCargarDato(true)->save($con);
//
//            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

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

    }


    public function executeCrearTraslado(sfWebRequest $request)
    {

       $codigo = $this->getRequestParameter("id");    
    

       $con = Propel::getConnection();
       if($codigo!=''||$codigo!=null){

           $tb096_presupuesto_modificacion = Tb096PresupuestoModificacionPeer::retrieveByPk($codigo);

           try
            {
              $con->beginTransaction();

              $tb096_presupuesto_modificacionForm = $this->getRequestParameter('tb096_presupuesto_modificacion');
      /*CAMPOS*/

              /*Campo tipo BIGINT */
              //$tb096_presupuesto_modificacion->setIdTb095TipoModificacion(1);

              /*Campo tipo VARCHAR */
              //$tb096_presupuesto_modificacion->setNuModificacion($tb096_presupuesto_modificacionForm["nu_modificacion"]);

              /*Campo tipo DATE */
              list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_modificacion"]);
              $fecha = $anio."-".$mes."-".$dia;
              $tb096_presupuesto_modificacion->setFeModificacion($fecha);

              /*Campo tipo VARCHAR */
              $tb096_presupuesto_modificacion->setDeModificacion($tb096_presupuesto_modificacionForm["de_modificacion"]);

              /*Campo tipo VARCHAR */
              $tb096_presupuesto_modificacion->setDeJustificacion($tb096_presupuesto_modificacionForm["de_justificacion"]);

              /*Campo tipo DATE */
              $tb096_presupuesto_modificacion->setNuOficio($tb096_presupuesto_modificacionForm["nu_oficio"]);

              /*Campo tipo DATE */
              if($tb096_presupuesto_modificacionForm["fe_oficio"]!=''){
                list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_oficio"]);
                $fecha = $anio."-".$mes."-".$dia;
                $tb096_presupuesto_modificacion->setFeOficio($fecha);
              }

              /*Campo tipo VARCHAR */
              $tb096_presupuesto_modificacion->setDeArticuloLey($tb096_presupuesto_modificacionForm["de_articulo_ley"]);

              /*Campo tipo NUMERIC */
              //$tb096_presupuesto_modificacion->setMoModificacion($tb096_presupuesto_modificacionForm["mo_modificacion"]);

              /*Campo tipo BOOLEAN */
              $tb096_presupuesto_modificacion->setInActivo(true);

              /*Campo tipo TIMESTAMP */
            if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
                $fecha = $this->getUser()->getAttribute('fe_cierre'); 
            }else{
                $fecha = date("Y-m-d H:i:s");
            }  
              
              //$tb096_presupuesto_modificacion->setCreatedAt($fecha);

              /*Campo tipo TIMESTAMP */
              $tb096_presupuesto_modificacion->setUpdatedAt($fecha);

              /*Campo tipo BIGINT */
              $tb096_presupuesto_modificacion->setIdTb082Ejecutor($tb096_presupuesto_modificacionForm["id_tb082_ejecutor"]);

              /*Campo tipo BIGINT */
              //$tb096_presupuesto_modificacion->setIdTb013AnioFiscal($this->getUser()->getAttribute('ejercicio'));

              /*Campo tipo BIGINT */
              $tb096_presupuesto_modificacion->setCoUsuario($this->getUser()->getAttribute('codigo'));

              /*Campo tipo BIGINT */
              //$tb096_presupuesto_modificacion->setCoSolicitud($tb096_presupuesto_modificacionForm["co_solicitud"]);

              /*Campo tipo BIGINT */
              //$tb096_presupuesto_modificacion->setCoTipoSolicitud($tb096_presupuesto_modificacionForm["co_tipo_solicitud"]);

              /*CAMPOS*/
              $tb096_presupuesto_modificacion->save($con);

              /*$this->data = json_encode(array(
                          "success" => true,
                          "msg" => 'Modificación realizada exitosamente'
                      ));*/
              //$con->commit();

              $c = new Criteria();
              $c->clearSelectColumns();
              $c->addSelectColumn(Tb096PresupuestoModificacionPeer::NU_MODIFICACION);
              $c->add(Tb096PresupuestoModificacionPeer::ID, $tb096_presupuesto_modificacion->getId());
              $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
              $campos = $stmt->fetch(PDO::FETCH_ASSOC);

              $this->data = json_encode(array(
        				'success' => true,
                'numero' => $campos["nu_modificacion"],
                'codigo' => $tb096_presupuesto_modificacion->getId(),
        				'msg' => '<span style="color:green;font-size:13px,">Datos Editado con exito!.<br>
        			    Numero de Movimiento <br><textarea readonly>'.$campos["nu_modificacion"].'</textarea></span>'
        			));

              /*$ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb096_presupuesto_modificacionForm["co_solicitud"]));
              $ruta->setInCargarDato(true)->save($con);

              Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());*/

              $con->commit();

            }catch (PropelException $e)
            {
              $con->rollback();
              $this->data = json_encode(array(
                  "success" => false,
                  "msg" =>  $e->getMessage()
              ));
            }

       }else{
           $tb096_presupuesto_modificacion = new Tb096PresupuestoModificacion();

           try
            {
              $con->beginTransaction();

              $tb096_presupuesto_modificacionForm = $this->getRequestParameter('tb096_presupuesto_modificacion');
      /*CAMPOS*/
             if($tb096_presupuesto_modificacionForm["co_tipo_solicitud"]==6){
                $tipo_modificacion = 1; 
             }else{
                 $tipo_modificacion = 6;
             }   
              /*Campo tipo BIGINT */
              $tb096_presupuesto_modificacion->setIdTb095TipoModificacion($tipo_modificacion);

              /*Campo tipo VARCHAR */
              $tb096_presupuesto_modificacion->setNuModificacion($tb096_presupuesto_modificacionForm["nu_modificacion"]);

              /*Campo tipo DATE */
              list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_modificacion"]);
              $fecha = $anio."-".$mes."-".$dia;
              $tb096_presupuesto_modificacion->setFeModificacion($fecha);

              /*Campo tipo VARCHAR */
              $tb096_presupuesto_modificacion->setDeModificacion($tb096_presupuesto_modificacionForm["de_modificacion"]);

              /*Campo tipo VARCHAR */
              $tb096_presupuesto_modificacion->setDeJustificacion($tb096_presupuesto_modificacionForm["de_justificacion"]);

              /*Campo tipo DATE */
              $tb096_presupuesto_modificacion->setNuOficio($tb096_presupuesto_modificacionForm["nu_oficio"]);

              /*Campo tipo DATE */
              if($tb096_presupuesto_modificacionForm["fe_oficio"]!=''){
                list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_oficio"]);
                $fecha = $anio."-".$mes."-".$dia;
                $tb096_presupuesto_modificacion->setFeOficio($fecha);
              }

              /*Campo tipo VARCHAR */
              $tb096_presupuesto_modificacion->setDeArticuloLey($tb096_presupuesto_modificacionForm["de_articulo_ley"]);

              /*Campo tipo NUMERIC */
              //$tb096_presupuesto_modificacion->setMoModificacion($tb096_presupuesto_modificacionForm["mo_modificacion"]);

              /*Campo tipo BOOLEAN */
              $tb096_presupuesto_modificacion->setInActivo(true);

              /*Campo tipo TIMESTAMP */
                if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
                    $fecha = $this->getUser()->getAttribute('fe_cierre'); 
                }else{
                    $fecha = date("Y-m-d H:i:s");
                }  
                
              $tb096_presupuesto_modificacion->setCreatedAt($fecha);

              /*Campo tipo TIMESTAMP */
              $tb096_presupuesto_modificacion->setUpdatedAt($fecha);

              /*Campo tipo BIGINT */
              $tb096_presupuesto_modificacion->setIdTb082Ejecutor($tb096_presupuesto_modificacionForm["id_tb082_ejecutor"]);

              /*Campo tipo BIGINT */
              $tb096_presupuesto_modificacion->setIdTb013AnioFiscal($this->getUser()->getAttribute('ejercicio'));

              /*Campo tipo BIGINT */
              $tb096_presupuesto_modificacion->setCoUsuario($this->getUser()->getAttribute('codigo'));

              /*Campo tipo BIGINT */
              $tb096_presupuesto_modificacion->setCoSolicitud($tb096_presupuesto_modificacionForm["co_solicitud"]);

              /*Campo tipo BIGINT */
              $tb096_presupuesto_modificacion->setCoTipoSolicitud($tb096_presupuesto_modificacionForm["co_tipo_solicitud"]);

              /*CAMPOS*/
              $tb096_presupuesto_modificacion->save($con);

              /*$this->data = json_encode(array(
                          "success" => true,
                          "msg" => 'Modificación realizada exitosamente'
                      ));*/
              //$con->commit();

              $c = new Criteria();
              $c->clearSelectColumns();
              $c->addSelectColumn(Tb096PresupuestoModificacionPeer::NU_MODIFICACION);
              $c->add(Tb096PresupuestoModificacionPeer::ID, $tb096_presupuesto_modificacion->getId());
              $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
              $campos = $stmt->fetch(PDO::FETCH_ASSOC);

              $this->data = json_encode(array(
        				'success' => true,
                'numero' => $campos["nu_modificacion"],
                'codigo' => $tb096_presupuesto_modificacion->getId(),
        				'msg' => '<span style="color:green;font-size:13px,">Datos Guardados con exito!.<br>
        			    Numero de Movimiento <br><textarea readonly>'.$campos["nu_modificacion"].'</textarea></span>'
        			));

              /*$ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb096_presupuesto_modificacionForm["co_solicitud"]));
              $ruta->setInCargarDato(true)->save($con);

              Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());*/

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

      }


      public function executeGuardarTraspasoGenerar(sfWebRequest $request)
      {
  
         $codigo = $this->getRequestParameter("id");
  
         $con = Propel::getConnection();
         if($codigo!=''||$codigo!=null){
  
             /*******Validar Traslados Origen************/
             $c_origen = new Criteria();
             $c_origen->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
             $c_origen->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
             $cantidad_origen = Tb097ModificacionDetallePeer::doCount($c_origen);
  
             $sum_origen = new Criteria();
             $sum_origen->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
             $sum_origen->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
             $sum_origen->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') AS suma_origen');
             $suma_origen = Tb097ModificacionDetallePeer::doSelectStmt($sum_origen);
             $campos_origen = $suma_origen->fetch(PDO::FETCH_ASSOC);
  
             if ($cantidad_origen <= 0) {
               $this->data = json_encode(array(
                 'success' => false,
                 'msg' => '<span style="color:red;font-size:13px,"><b>Se debe al menos cargar una partida Cedente!</b></span>'
               ));
  
               return $this->setTemplate('store');
             }
  
             /*******Validar Traslados Destino************/
             $c_destino = new Criteria();
             $c_destino->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
             $c_destino->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 2);
             $cantidad_destino = Tb097ModificacionDetallePeer::doCount($c_destino);
  
             $sum_destino = new Criteria();
             $sum_destino->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
             $sum_destino->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 2);
             $sum_destino->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') AS suma_destino');
             $suma_destino = Tb097ModificacionDetallePeer::doSelectStmt($sum_destino);
             $campos_destino = $suma_destino->fetch(PDO::FETCH_ASSOC);
  
             if ($cantidad_destino <= 0) {
               $this->data = json_encode(array(
                 'success' => false,
                 'msg' => '<span style="color:red;font-size:13px,"><b>Se debe al menos cargar una partida de Destino!</b></span>'
               ));
  
               return $this->setTemplate('store');
             }
  
             if ($campos_origen["suma_origen"] != $campos_destino["suma_destino"] ) {
  
               $resta_traslado = $campos_origen["suma_origen"] -$campos_destino["suma_destino"];
  
               $this->data = json_encode(array(
                 'success' => false,
                 'msg' => '<span style="color:red;font-size:13px,"><b>El monto total de las partidas de origen deben ser igual a las partidas de destino!<br></b></span>Diferencia: <b>'.$resta_traslado.'</b>'
               ));
  
               return $this->setTemplate('store');
             }
  
             try
              {
                  $con->beginTransaction();   

                  $tb096_presupuesto_modificacion = Tb096PresupuestoModificacionPeer::retrieveByPk($codigo);
                  $tb096_presupuesto_modificacion->setInProcesado(true);
                  $tb096_presupuesto_modificacion->save($con);
                
                  $sum_destino = new Criteria();

                  $sum_destino->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION);        
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB013_ANIO_FISCAL);      
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB083_PROYECTO_AC);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB084_ACCION_ESPECIFICA);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB085_PRESUPUESTO);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::NU_PARTIDA);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::MO_DISTRIBUCION);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB064_PRESUPUESTO_INGRESO);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB082_EJECUTOR_ORIGEN);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB082_EJECUTOR_DESTINO);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB139_APLICACION);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::NU_APLICACION);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::IN_TRASPASO);

                  $suma_destino = Tb097ModificacionDetallePeer::doSelectStmt($sum_destino);
  
                  while($campos_destino = $suma_destino->fetch(PDO::FETCH_ASSOC)){

                    if($campos_destino["in_traspaso"]!=true){
                      if($campos_destino["id_tb098_tipo_distribucion"]==1){

                        $c20 = new Criteria();
                        $c20->add(Tb085PresupuestoPeer::ID, $campos_destino["id_tb085_presupuesto"]);
                        $stmt20 = Tb085PresupuestoPeer::doSelectStmt($c20);
                        $campos20 = $stmt20->fetch(PDO::FETCH_ASSOC);

                        $saldo_actualizado = $campos20["mo_actualizado"]-$campos_destino["mo_distribucion"];
                        $saldo_anterior = $campos20["mo_disponible"];
                        $saldo_nuevo = $saldo_anterior-$campos_destino["mo_distribucion"];

                        /*CAMPOS*/
//                        $tb085_persupuesto = Tb085PresupuestoPeer::retrieveByPK($campos_destino["id_tb085_presupuesto"]);
//                        $tb085_persupuesto->setMoDisponible($saldo_nuevo);
//                        $tb085_persupuesto->setMoActualizado($saldo_actualizado);
//                        $tb085_persupuesto->save($con);

                        $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                        $tb087_presupuesto_movimiento->setCoPartida($campos_destino["id_tb085_presupuesto"])
                                         ->setCoTipoMovimiento(8)
                                         ->setNuMonto($campos_destino["mo_distribucion"])
                                         ->setNuAnio($campos_destino["id_tb013_anio_fiscal"])
                                         ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                         ->setTxObservacion('TRASPASO ENTRE PARTIDAS')
                                         ->setMoSaldoNuevo($saldo_nuevo)
                                         ->setMoSaldoAnterior($saldo_anterior)
                                         ->setInActivo(true)
                                         ->save($con);

                        $tb097_movimiento = Tb097ModificacionDetallePeer::retrieveByPK($campos_destino["id"]);
                        $tb097_movimiento->setInTraspaso(true)->save($con);

                      }
                      if($campos_destino["id_tb098_tipo_distribucion"]==2){

                        /*CAMPOS*/

                        $c20 = new Criteria();
                        $c20->add(Tb085PresupuestoPeer::ID, $campos_destino["id_tb085_presupuesto"]);
                        $stmt20 = Tb085PresupuestoPeer::doSelectStmt($c20);
                        $campos20 = $stmt20->fetch(PDO::FETCH_ASSOC);

                        $saldo_actualizado = $campos20["mo_actualizado"]+$campos_destino["mo_distribucion"];
                        $saldo_anterior = $campos20["mo_disponible"];
                        $saldo_nuevo = $saldo_anterior+$campos_destino["mo_distribucion"];

//                        /*CAMPOS*/
//                        $tb085_persupuesto = Tb085PresupuestoPeer::retrieveByPK($campos_destino["id_tb085_presupuesto"]);
//                        $tb085_persupuesto->setMoDisponible($saldo_nuevo);
//                        $tb085_persupuesto->setMoActualizado($saldo_actualizado);
//                        $tb085_persupuesto->save($con);

                        $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                        $tb087_presupuesto_movimiento->setCoPartida($campos_destino["id_tb085_presupuesto"])
                                         ->setCoTipoMovimiento(7)
                                         ->setNuMonto($campos_destino["mo_distribucion"])
                                         ->setNuAnio($campos_destino["id_tb013_anio_fiscal"])
                                         ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                         ->setTxObservacion('TRASPASO ENTRE PARTIDAS')
                                         ->setMoSaldoNuevo($saldo_nuevo)
                                         ->setMoSaldoAnterior($saldo_anterior)
                                         ->setInActivo(true)
                                         ->save($con);

                        $tb097_movimiento = Tb097ModificacionDetallePeer::retrieveByPK($campos_destino["id"]);
                        $tb097_movimiento->setInTraspaso(true)->save($con);

                      }
                    }
                  }
                  

                $con->commit();
                
                $tb096_presupuesto_modificacionForm = $this->getRequestParameter("tb096_presupuesto_modificacion");                
                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb096_presupuesto_modificacionForm["co_solicitud"]));
                $ruta->setInCargarDato(true)->save($con);
                
                Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

                $this->data = json_encode(array(
                  'success' => true,
                  'numero' => $tb096_presupuesto_modificacion->getNuModificacion(),
                  'msg' => 'Traslados realizados con Exito!.'
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
  
         $this->setTemplate('store');
  
        }


      public function executeCrearCredito(sfWebRequest $request)
      {

         $codigo = $this->getRequestParameter("id");

         $con = Propel::getConnection();
         if($codigo!=''||$codigo!=null){

             /*******Validar Traslados Origen************/
             $c_origen = new Criteria();
             $c_origen->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
             $c_origen->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
             $cantidad_origen = Tb097ModificacionDetallePeer::doCount($c_origen);

             $sum_origen = new Criteria();
             $sum_origen->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
             $sum_origen->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
             $sum_origen->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') AS suma_origen');
             $suma_origen = Tb097ModificacionDetallePeer::doSelectStmt($sum_origen);
             $campos_origen = $suma_origen->fetch(PDO::FETCH_ASSOC);

             if ($cantidad_origen <= 0) {
               $this->data = json_encode(array(
                 'success' => false,
                 'msg' => '<span style="color:red;font-size:13px,"><b>Se debe al menos cargar una partida de origen!</b></span>'
               ));

               return $this->setTemplate('store');
             }

             /*******Validar Traslados Destino************/
             $c_destino = new Criteria();
             $c_destino->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
             $c_destino->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 2);
             $cantidad_destino = Tb097ModificacionDetallePeer::doCount($c_destino);

             $sum_destino = new Criteria();
             $sum_destino->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
             $sum_destino->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 2);
             $sum_destino->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') AS suma_destino');
             $suma_destino = Tb097ModificacionDetallePeer::doSelectStmt($sum_destino);
             $campos_destino = $suma_destino->fetch(PDO::FETCH_ASSOC);

             if ($cantidad_destino <= 0) {
               $this->data = json_encode(array(
                 'success' => false,
                 'msg' => '<span style="color:red;font-size:13px,"><b>Se debe al menos cargar una partida de destino!</b></span>'
               ));

               return $this->setTemplate('store');
             }

             if ($campos_origen["suma_origen"] != $campos_destino["suma_destino"] ) {

               $resta_traslado = $campos_origen["suma_origen"] -$campos_destino["suma_destino"];

               $this->data = json_encode(array(
                 'success' => false,
                 'msg' => '<span style="color:red;font-size:13px,"><b>El monto total de las partidas de origen deben ser igual a las partidas de destino!<br></b></span>Diferencia: <b></b>'
               ));

               return $this->setTemplate('store');
             }

             $tb096_presupuesto_modificacion = Tb096PresupuestoModificacionPeer::retrieveByPk($codigo);

             try
              {
                $con->beginTransaction();

                $tb096_presupuesto_modificacionForm = $this->getRequestParameter('tb096_presupuesto_modificacion');
        
                if($tb096_presupuesto_modificacionForm["fe_modificacion"]!=''){
                    list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_modificacion"]);
                    $fecha = $anio."-".$mes."-".$dia;
                    $tb096_presupuesto_modificacion->setFeModificacion($fecha);
                }

                
                $tb096_presupuesto_modificacion->setDeModificacion($tb096_presupuesto_modificacionForm["de_modificacion"]);
                $tb096_presupuesto_modificacion->setDeJustificacion($tb096_presupuesto_modificacionForm["de_justificacion"]);
                $tb096_presupuesto_modificacion->setNuOficio($tb096_presupuesto_modificacionForm["nu_oficio"]);

              
                if($tb096_presupuesto_modificacionForm["fe_oficio"]!=''){
                    list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_oficio"]);
                    $fecha = $anio."-".$mes."-".$dia;
                    $tb096_presupuesto_modificacion->setFeOficio($fecha);
                }

                $tb096_presupuesto_modificacion->setDeArticuloLey($tb096_presupuesto_modificacionForm["de_articulo_ley"]);
                $tb096_presupuesto_modificacion->setInActivo(true);
                $fecha = date("Y-m-d H:i:s");
                $tb096_presupuesto_modificacion->setUpdatedAt($fecha);
                $tb096_presupuesto_modificacion->setIdTb082Ejecutor($tb096_presupuesto_modificacionForm["id_tb082_ejecutor"]);
                $tb096_presupuesto_modificacion->setCoUsuario($this->getUser()->getAttribute('codigo'));
                $tb096_presupuesto_modificacion->setIdTb068NumeroFuenteFinanciamiento($tb096_presupuesto_modificacionForm["id_tb068_numero_fuente_financiamiento"]);
                $tb096_presupuesto_modificacion->setIdTb082EjecutorOrigen($tb096_presupuesto_modificacionForm["id_tb082_ejecutor_origen"]);
                $tb096_presupuesto_modificacion->setIdTb082EjecutorDestino($tb096_presupuesto_modificacionForm["id_tb082_ejecutor_destino"]);
                $tb096_presupuesto_modificacion->setIdTb152TipoCredito($tb096_presupuesto_modificacionForm["id_tb152_tipo_credito"]);
                $tb096_presupuesto_modificacion->setIdTb073FuenteFinanciamiento($tb096_presupuesto_modificacionForm["id_tb073_fuente_financiamiento"]);
                $tb096_presupuesto_modificacion->save($con);

                $c = new Criteria();
                $c->clearSelectColumns();
                $c->addSelectColumn(Tb096PresupuestoModificacionPeer::NU_MODIFICACION);
                $c->add(Tb096PresupuestoModificacionPeer::ID, $tb096_presupuesto_modificacion->getId());
                $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
                $campos = $stmt->fetch(PDO::FETCH_ASSOC);               
              

                $this->data = json_encode(array(
                  'success' => true,
                  'numero' => $campos["nu_modificacion"],
                  'codigo' => $tb096_presupuesto_modificacion->getId(),
                  'msg' => '<span style="color:green;font-size:13px,">Datos Editado con exito!.<br>
                    Numero de Movimiento <br><textarea readonly>'.$campos["nu_modificacion"].'</textarea></span>'
                ));

                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb096_presupuesto_modificacionForm["co_solicitud"]));
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

         }else{
             $tb096_presupuesto_modificacion = new Tb096PresupuestoModificacion();

             try
              {
                $con->beginTransaction();

                $tb096_presupuesto_modificacionForm = $this->getRequestParameter('tb096_presupuesto_modificacion');
        /*CAMPOS*/

                /*Campo tipo BIGINT */
                $tb096_presupuesto_modificacion->setIdTb095TipoModificacion(2);

                /*Campo tipo VARCHAR */
                $tb096_presupuesto_modificacion->setNuModificacion($tb096_presupuesto_modificacionForm["nu_modificacion"]);

                /*Campo tipo DATE */
                list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_modificacion"]);
                $fecha = $anio."-".$mes."-".$dia;
                $tb096_presupuesto_modificacion->setFeModificacion($fecha);

                /*Campo tipo VARCHAR */
                $tb096_presupuesto_modificacion->setDeModificacion($tb096_presupuesto_modificacionForm["de_modificacion"]);

                /*Campo tipo VARCHAR */
                $tb096_presupuesto_modificacion->setDeJustificacion($tb096_presupuesto_modificacionForm["de_justificacion"]);

                /*Campo tipo DATE */
                $tb096_presupuesto_modificacion->setNuOficio($tb096_presupuesto_modificacionForm["nu_oficio"]);

                /*Campo tipo DATE */
                /*Campo tipo DATE */
                if($tb096_presupuesto_modificacionForm["fe_oficio"]!=''){
                  list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_oficio"]);
                  $fecha = $anio."-".$mes."-".$dia;
                  $tb096_presupuesto_modificacion->setFeOficio($fecha);
                }

                /*Campo tipo VARCHAR */
                $tb096_presupuesto_modificacion->setDeArticuloLey($tb096_presupuesto_modificacionForm["de_articulo_ley"]);

                /*Campo tipo NUMERIC */
                //$tb096_presupuesto_modificacion->setMoModificacion($tb096_presupuesto_modificacionForm["mo_modificacion"]);

                /*Campo tipo BOOLEAN */
                $tb096_presupuesto_modificacion->setInActivo(true);

                /*Campo tipo TIMESTAMP */
                $fecha = date("Y-m-d H:i:s");
                $tb096_presupuesto_modificacion->setCreatedAt($fecha);

                /*Campo tipo TIMESTAMP */
                $tb096_presupuesto_modificacion->setUpdatedAt($fecha);

                /*Campo tipo BIGINT */
                //$tb096_presupuesto_modificacion->setIdTb082Ejecutor($tb096_presupuesto_modificacionForm["id_tb082_ejecutor"]);

                /*Campo tipo BIGINT */
                $tb096_presupuesto_modificacion->setIdTb013AnioFiscal($this->getUser()->getAttribute('ejercicio'));

                /*Campo tipo BIGINT */
                $tb096_presupuesto_modificacion->setCoUsuario($this->getUser()->getAttribute('codigo'));

                /*Campo tipo BIGINT */
                $tb096_presupuesto_modificacion->setCoSolicitud($tb096_presupuesto_modificacionForm["co_solicitud"]);

                /*Campo tipo BIGINT */
                $tb096_presupuesto_modificacion->setCoTipoSolicitud($tb096_presupuesto_modificacionForm["co_tipo_solicitud"]);

                $tb096_presupuesto_modificacion->setIdTb068NumeroFuenteFinanciamiento($tb096_presupuesto_modificacionForm["id_tb068_numero_fuente_financiamiento"]);

                $tb096_presupuesto_modificacion->setIdTb082EjecutorOrigen($tb096_presupuesto_modificacionForm["id_tb082_ejecutor_origen"]);
                $tb096_presupuesto_modificacion->setIdTb082EjecutorDestino($tb096_presupuesto_modificacionForm["id_tb082_ejecutor_destino"]);

                /*Campo tipo BIGINT */
                $tb096_presupuesto_modificacion->setIdTb152TipoCredito($tb096_presupuesto_modificacionForm["id_tb152_tipo_credito"]);

                $tb096_presupuesto_modificacion->setIdTb073FuenteFinanciamiento($tb096_presupuesto_modificacionForm["id_tb073_fuente_financiamiento"]);

                /*CAMPOS*/
                $tb096_presupuesto_modificacion->save($con);

                /*$this->data = json_encode(array(
                            "success" => true,
                            "msg" => 'Modificación realizada exitosamente'
                        ));*/
                //$con->commit();

                $c = new Criteria();
                $c->clearSelectColumns();
                $c->addSelectColumn(Tb096PresupuestoModificacionPeer::NU_MODIFICACION);
                $c->add(Tb096PresupuestoModificacionPeer::ID, $tb096_presupuesto_modificacion->getId());
                $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
                $campos = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->data = json_encode(array(
                  'success' => true,
                  'numero' => $campos["nu_modificacion"],
                  'codigo' => $tb096_presupuesto_modificacion->getId(),
                  'msg' => '<span style="color:green;font-size:13px,">Datos Guardados con exito!.<br>
                    Numero de Movimiento <br><textarea readonly>'.$campos["nu_modificacion"].'</textarea></span>'
                ));

                /*$ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb096_presupuesto_modificacionForm["co_solicitud"]));
                $ruta->setInCargarDato(true)->save($con);

                Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());*/

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

         $this->setTemplate('store');

        }
        
      public function executeCrearCompromiso(sfWebRequest $request)
      {
            $con = Propel::getConnection();
             $tb096_presupuesto_modificacion = new Tb096PresupuestoModificacion();

             try
              {
                $con->beginTransaction();

                $tb096_presupuesto_modificacionForm = $this->getRequestParameter('tb096_presupuesto_modificacion');
        /*CAMPOS*/

                /*Campo tipo BIGINT */
                $tb096_presupuesto_modificacion->setIdTb095TipoModificacion(5);

                /*Campo tipo VARCHAR */
                $tb096_presupuesto_modificacion->setNuModificacion($tb096_presupuesto_modificacionForm["nu_modificacion"]);

                /*Campo tipo DATE */
                list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_modificacion"]);
                $fecha = $anio."-".$mes."-".$dia;
                $tb096_presupuesto_modificacion->setFeModificacion($fecha);

                /*Campo tipo VARCHAR */
                $tb096_presupuesto_modificacion->setDeModificacion($tb096_presupuesto_modificacionForm["de_modificacion"]);

                /*Campo tipo VARCHAR */
                $tb096_presupuesto_modificacion->setDeJustificacion($tb096_presupuesto_modificacionForm["de_justificacion"]);

                /*Campo tipo DATE */
                $tb096_presupuesto_modificacion->setNuOficio($tb096_presupuesto_modificacionForm["nu_oficio"]);

                /*Campo tipo DATE */
                /*Campo tipo DATE */
                if($tb096_presupuesto_modificacionForm["fe_oficio"]!=''){
                  list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_oficio"]);
                  $fecha = $anio."-".$mes."-".$dia;
                  $tb096_presupuesto_modificacion->setFeOficio($fecha);
                }

                /*Campo tipo VARCHAR */
                $tb096_presupuesto_modificacion->setDeArticuloLey($tb096_presupuesto_modificacionForm["de_articulo_ley"]);

                /*Campo tipo NUMERIC */
                //$tb096_presupuesto_modificacion->setMoModificacion($tb096_presupuesto_modificacionForm["mo_modificacion"]);

                /*Campo tipo BOOLEAN */
                $tb096_presupuesto_modificacion->setInActivo(true);

                /*Campo tipo TIMESTAMP */
                $fecha = date("Y-m-d H:i:s");
                $tb096_presupuesto_modificacion->setCreatedAt($fecha);

                /*Campo tipo TIMESTAMP */
                $tb096_presupuesto_modificacion->setUpdatedAt($fecha);

                /*Campo tipo BIGINT */
                //$tb096_presupuesto_modificacion->setIdTb082Ejecutor($tb096_presupuesto_modificacionForm["id_tb082_ejecutor"]);

                /*Campo tipo BIGINT */
                $tb096_presupuesto_modificacion->setIdTb013AnioFiscal($this->getUser()->getAttribute('ejercicio'));

                /*Campo tipo BIGINT */
                $tb096_presupuesto_modificacion->setCoUsuario($this->getUser()->getAttribute('codigo'));

                /*Campo tipo BIGINT */
                $tb096_presupuesto_modificacion->setCoSolicitud($tb096_presupuesto_modificacionForm["co_solicitud"]);

                /*Campo tipo BIGINT */
                $tb096_presupuesto_modificacion->setCoTipoSolicitud($tb096_presupuesto_modificacionForm["co_tipo_solicitud"]);

                /*CAMPOS*/
                $tb096_presupuesto_modificacion->save($con);

                /*$this->data = json_encode(array(
                            "success" => true,
                            "msg" => 'Modificación realizada exitosamente'
                        ));*/
                //$con->commit();

                $c = new Criteria();
                $c->clearSelectColumns();
                $c->addSelectColumn(Tb096PresupuestoModificacionPeer::NU_MODIFICACION);
                $c->add(Tb096PresupuestoModificacionPeer::ID, $tb096_presupuesto_modificacion->getId());
                $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
                $campos = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->data = json_encode(array(
                  'success' => true,
                  'numero' => $campos["nu_modificacion"],
                  'codigo' => $tb096_presupuesto_modificacion->getId(),
                  'msg' => '<span style="color:green;font-size:13px,">Datos Guardados con exito!.<br>
                    Numero de Movimiento <br><textarea readonly>'.$campos["nu_modificacion"].'</textarea></span>'
                ));

                /*$ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb096_presupuesto_modificacionForm["co_solicitud"]));
                $ruta->setInCargarDato(true)->save($con);

                Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());*/

                $con->commit();

              }catch (PropelException $e)
              {
                $con->rollback();
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" =>  $e->getMessage()
                ));
              }

         

         $this->setTemplate('store');

        }        


    public function executeGuardarCredito(sfWebRequest $request)
    {

       $codigo = $this->getRequestParameter("id");

       $con = Propel::getConnection();
       if($codigo!=''||$codigo!=null){

           /*******Validar Traslados Origen************/
           $c_origen = new Criteria();
           $c_origen->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
           $c_origen->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
           $cantidad_origen = Tb097ModificacionDetallePeer::doCount($c_origen);

           $sum_origen = new Criteria();
           $sum_origen->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
           $sum_origen->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
           $sum_origen->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') AS suma_origen');
           $suma_origen = Tb097ModificacionDetallePeer::doSelectStmt($sum_origen);
           $campos_origen = $suma_origen->fetch(PDO::FETCH_ASSOC);

           if ($cantidad_origen <= 0) {
             $this->data = json_encode(array(
               'success' => false,
               'msg' => '<span style="color:red;font-size:13px,"><b>Se debe al menos cargar una partida de Ingreso!</b></span>'
             ));

             return $this->setTemplate('store');
           }

           /*******Validar Traslados Destino************/
           $c_destino = new Criteria();
           $c_destino->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
           $c_destino->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 2);
           $cantidad_destino = Tb097ModificacionDetallePeer::doCount($c_destino);

           $sum_destino = new Criteria();
           $sum_destino->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
           $sum_destino->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 2);
           $sum_destino->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') AS suma_destino');
           $suma_destino = Tb097ModificacionDetallePeer::doSelectStmt($sum_destino);
           $campos_destino = $suma_destino->fetch(PDO::FETCH_ASSOC);

           if ($cantidad_destino <= 0) {
             $this->data = json_encode(array(
               'success' => false,
               'msg' => '<span style="color:red;font-size:13px,"><b>Se debe al menos cargar una partida de Gasto!</b></span>'
             ));

             return $this->setTemplate('store');
           }

           if ($campos_origen["suma_origen"] != $campos_destino["suma_destino"] ) {

             $resta_traslado = $campos_origen["suma_origen"] -$campos_destino["suma_destino"];

             $this->data = json_encode(array(
               'success' => false,
               'msg' => '<span style="color:red;font-size:13px,"><b>El monto total de las partidas de origen deben ser igual a las partidas de destino!<br></b></span>Diferencia: <b>'.$resta_traslado.'</b>'
             ));

             return $this->setTemplate('store');
           }

           $tb096_presupuesto_modificacion = Tb096PresupuestoModificacionPeer::retrieveByPk($codigo);

           try
            {
                $con->beginTransaction();

                $tb096_presupuesto_modificacionForm = $this->getRequestParameter('tb096_presupuesto_modificacion');

                if($tb096_presupuesto_modificacionForm["fe_modificacion"]!=''){
                    list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_modificacion"]);
                    $fecha = $anio."-".$mes."-".$dia;
                    $tb096_presupuesto_modificacion->setFeModificacion($fecha);
                }else{
                    $tb096_presupuesto_modificacion->setFeModificacion(null);
                }

             
                $tb096_presupuesto_modificacion->setDeModificacion($tb096_presupuesto_modificacionForm["de_modificacion"]);
                $tb096_presupuesto_modificacion->setDeJustificacion($tb096_presupuesto_modificacionForm["de_justificacion"]);
                $tb096_presupuesto_modificacion->setNuOficio($tb096_presupuesto_modificacionForm["nu_oficio"]);

                if($tb096_presupuesto_modificacionForm["fe_oficio"]!=''){
                    list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_oficio"]);
                    $fecha = $anio."-".$mes."-".$dia;
                    $tb096_presupuesto_modificacion->setFeOficio($fecha);
                }else{
                    $tb096_presupuesto_modificacion->setFeOficio(null);
                }

             
                $tb096_presupuesto_modificacion->setDeArticuloLey($tb096_presupuesto_modificacionForm["de_articulo_ley"]);
                $tb096_presupuesto_modificacion->setInActivo(true);
                $fecha = date("Y-m-d H:i:s");
                $tb096_presupuesto_modificacion->setUpdatedAt($fecha);
                $tb096_presupuesto_modificacion->setCoUsuario($this->getUser()->getAttribute('codigo'));
//                $tb096_presupuesto_modificacion->setIdTb068NumeroFuenteFinanciamiento($tb096_presupuesto_modificacionForm["id_tb068_numero_fuente_financiamiento"]);
                $tb096_presupuesto_modificacion->setIdTb082EjecutorOrigen($tb096_presupuesto_modificacionForm["id_tb082_ejecutor_origen"]);
                $tb096_presupuesto_modificacion->setIdTb082EjecutorDestino($tb096_presupuesto_modificacionForm["id_tb082_ejecutor_destino"]);
                /*Campo tipo BIGINT */
//                $tb096_presupuesto_modificacion->setIdTb152TipoCredito($tb096_presupuesto_modificacionForm["id_tb152_tipo_credito"]);
//                $tb096_presupuesto_modificacion->setIdTb073FuenteFinanciamiento($tb096_presupuesto_modificacionForm["id_tb073_fuente_financiamiento"]);
                $tb096_presupuesto_modificacion->save($con);

                $c = new Criteria();
                $c->clearSelectColumns();
                $c->addSelectColumn(Tb096PresupuestoModificacionPeer::NU_MODIFICACION);
                $c->add(Tb096PresupuestoModificacionPeer::ID, $tb096_presupuesto_modificacion->getId());
                $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
                $campos = $stmt->fetch(PDO::FETCH_ASSOC);      
              
                /*$sum_destino = new Criteria();
                $sum_destino->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
                $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION);
                $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::MO_DISTRIBUCION);
                $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB085_PRESUPUESTO);
                $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID);
                $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::IN_TRASPASO);
                $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB064_PRESUPUESTO_INGRESO);
                
               
                
                $suma_destino = Tb097ModificacionDetallePeer::doSelectStmt($sum_destino);*/

                /*while($campos_destino = $suma_destino->fetch(PDO::FETCH_ASSOC)){

                        if($campos_destino["in_traspaso"]!=true){
                              if($campos_destino["id_tb098_tipo_distribucion"]==1){                      
//                                    $tb085_persupuesto = Tb085PresupuestoPeer::retrieveByPK($campos_destino["id_tb085_presupuesto_ingreso"]);
//                                    $tb085_persupuesto->setMoDisponible($tb085_persupuesto->getMoDisponible()-$campos_destino["mo_distribucion"]);
//                                    $tb085_persupuesto->save($con);
//
//
//                                    $tb061_asiento_contable = new Tb061AsientoContable();
//                                    $tb061_asiento_contable->setCoCuentaContable($tb085_persupuesto->getCoCuentaContable())
//                                                           ->setMoDebe($campos_destino["mo_distribucion"])
//                                                           ->setCoUsuario($this->getUser()->getAttribute('codigo'))
//                                                           ->setCoSolicitud($tb096_presupuesto_modificacion->getCoSolicitud())
//                                                           ->save($con);
//
//                                    $tb134_movimiento_contable = new Tb134MovimientoContable();
//                                    $tb134_movimiento_contable->setMoAnterior($tb085_persupuesto->getMoDisponible())
//                                                              ->setMoDebito($campos_dest                
               // echo $sum_destino->toString(); exit();ino["mo_distribucion"])
//                                                              ->setMoDisponible($tb085_persupuesto->getMoDisponible()-$campos_destino["mo_distribucion"])
//                                                              ->setCoCuentaContable($tb085_persupuesto->getCoCuentaContable())
//                                                              ->setFeMovimiento(date("Y-m-d"))
//                                                              ->setCoUsuario($this->getUser()->getAttribute('codigo'))
//                                                              ->setCoSolicitud($tb096_presupuesto_modificacion->getCoSolicitud())
//                                                              ->save($con);                                 

                                  
                                $tb064_presupuesto_ingreso = Tb064PresupuestoIngresoPeer::retrieveByPK($campos_destino["id_tb064_presupuesto_ingreso"]);
                                $tb064_presupuesto_ingreso->setMoDisponible($tb064_presupuesto_ingreso->getMoDisponible()-$campos_destino["mo_distribucion"]);
                                $tb064_presupuesto_ingreso->save($con);
                              }else{

                                $tb085_persupuesto = Tb085PresupuestoPeer::retrieveByPK($campos_destino["id_tb085_presupuesto"]);
                                $tb085_persupuesto->setMoDisponible($tb085_persupuesto->getMoDisponible()+$campos_destino["mo_distribucion"]);
                                $tb085_persupuesto->save($con);

                                $tb061_asiento_contable = new Tb061AsientoContable();
                                $tb061_asiento_contable->setCoCuentaContable($tb085_persupuesto->getCoCuentaContable())
                                                       ->setMoHaber($campos_destino["mo_distribucion"])
                                                       ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                                       ->setCoSolicitud($tb096_presupuesto_modificacion->getCoSolicitud())
                                                       ->save($con);

                                $tb134_movimiento_contable = new Tb134MovimientoContable();
                                $tb134_movimiento_contable->setMoAnterior($tb085_persupuesto->getMoDisponible())
                                                          ->setMoCredito($campos_destino["mo_distribucion"])
                                                          ->setMoDisponible($tb085_persupuesto->getMoDisponible()+$campos_destino["mo_distribucion"])
                                                          ->setCoCuentaContable($tb085_persupuesto->getCoCuentaContable())
                                                          ->setFeMovimiento(date("Y-m-d"))
                                                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                                          ->setCoSolicitud($tb096_presupuesto_modificacion->getCoSolicitud())
                                                          ->save($con); 
                              }

                              $tb097_movimiento = Tb097ModificacionDetallePeer::retrieveByPK($campos_destino["id"]);
                              $tb097_movimiento->setInTraspaso(true)->save($con);
                        }
                }*/
                
 
              

              $this->data = json_encode(array(
        	'success' => true,
                'numero' => $campos["nu_modificacion"],
                'codigo' => $tb096_presupuesto_modificacion->getId(),
        				'msg' => '<span style="color:green;font-size:13px,">Datos Editado con exito!.<br>
        			    Numero de Movimiento <br><textarea readonly>'.$campos["nu_modificacion"].'</textarea></span>'
              ));

              $con->commit();

              $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb096_presupuesto_modificacion->getCoSolicitud()));
              Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta()); 

            }catch (PropelException $e)
            {
              $con->rollback();
              $this->data = json_encode(array(
                  "success" => false,
                  "msg" =>  $e->getMessage()
              ));
            }

       }else{
           $tb096_presupuesto_modificacion = new Tb096PresupuestoModificacion();

           try
            {
              $con->beginTransaction();

              $tb096_presupuesto_modificacionForm = $this->getRequestParameter('tb096_presupuesto_modificacion');
      /*CAMPOS*/

              /*Campo tipo BIGINT */
              $tb096_presupuesto_modificacion->setIdTb095TipoModificacion(2);

              /*Campo tipo VARCHAR */
              $tb096_presupuesto_modificacion->setNuModificacion($tb096_presupuesto_modificacionForm["nu_modificacion"]);

              /*Campo tipo DATE */
              list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_modificacion"]);
              $fecha = $anio."-".$mes."-".$dia;
              $tb096_presupuesto_modificacion->setFeModificacion($fecha);

              /*Campo tipo VARCHAR */
              $tb096_presupuesto_modificacion->setDeModificacion($tb096_presupuesto_modificacionForm["de_modificacion"]);

              /*Campo tipo VARCHAR */
              $tb096_presupuesto_modificacion->setDeJustificacion($tb096_presupuesto_modificacionForm["de_justificacion"]);

              /*Campo tipo DATE */
              $tb096_presupuesto_modificacion->setNuOficio($tb096_presupuesto_modificacionForm["nu_oficio"]);

              /*Campo tipo DATE */
              list($dia, $mes, $anio) = explode("/",$tb096_presupuesto_modificacionForm["fe_oficio"]);
              $fecha = $anio."-".$mes."-".$dia;
              $tb096_presupuesto_modificacion->setFeOficio($fecha);

              /*Campo tipo VARCHAR */
              $tb096_presupuesto_modificacion->setDeArticuloLey($tb096_presupuesto_modificacionForm["de_articulo_ley"]);

              /*Campo tipo NUMERIC */
              //$tb096_presupuesto_modificacion->setMoModificacion($tb096_presupuesto_modificacionForm["mo_modificacion"]);

              /*Campo tipo BOOLEAN */
              $tb096_presupuesto_modificacion->setInActivo(true);

              /*Campo tipo TIMESTAMP */
              $fecha = date("Y-m-d H:i:s");
              $tb096_presupuesto_modificacion->setCreatedAt($fecha);

              /*Campo tipo TIMESTAMP */
              $tb096_presupuesto_modificacion->setUpdatedAt($fecha);

              /*Campo tipo BIGINT */
              $tb096_presupuesto_modificacion->setIdTb082Ejecutor($tb096_presupuesto_modificacionForm["id_tb082_ejecutor_origen"]);

              /*Campo tipo BIGINT */
              $tb096_presupuesto_modificacion->setIdTb013AnioFiscal($this->getUser()->getAttribute('ejercicio'));

              /*Campo tipo BIGINT */
              $tb096_presupuesto_modificacion->setCoUsuario($this->getUser()->getAttribute('codigo'));

              /*Campo tipo BIGINT */
              $tb096_presupuesto_modificacion->setCoSolicitud($tb096_presupuesto_modificacionForm["co_solicitud"]);

              /*Campo tipo BIGINT */
              $tb096_presupuesto_modificacion->setCoTipoSolicitud($tb096_presupuesto_modificacionForm["co_tipo_solicitud"]);

              $tb096_presupuesto_modificacion->setIdTb068NumeroFuenteFinanciamiento($tb096_presupuesto_modificacionForm["id_tb068_numero_fuente_financiamiento"]);

              /*CAMPOS*/
              $tb096_presupuesto_modificacion->save($con);

              /*$this->data = json_encode(array(
                          "success" => true,
                          "msg" => 'Modificación realizada exitosamente'
                      ));*/
              //$con->commit();

              $c = new Criteria();
              $c->clearSelectColumns();
              $c->addSelectColumn(Tb096PresupuestoModificacionPeer::NU_MODIFICACION);
              $c->add(Tb096PresupuestoModificacionPeer::ID, $tb096_presupuesto_modificacion->getId());
              $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
              $campos = $stmt->fetch(PDO::FETCH_ASSOC);

              $this->data = json_encode(array(
        				'success' => true,
                'numero' => $campos["nu_modificacion"],
                'codigo' => $tb096_presupuesto_modificacion->getId(),
        				'msg' => '<span style="color:green;font-size:13px,">Datos Guardados con exito!.<br>
        			    Numero de Movimiento <br><textarea readonly>'.$campos["nu_modificacion"].'</textarea></span>'
        			));

              /*$ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb096_presupuesto_modificacionForm["co_solicitud"]));
              $ruta->setInCargarDato(true)->save($con);

              Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());*/

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

       $this->setTemplate('store');

      }

      public function executeGuardarCreditoGenerar(sfWebRequest $request)
      {
  
         $codigo = $this->getRequestParameter("id");
         $tb096_presupuesto_modificacionForm = $this->getRequestParameter('tb096_presupuesto_modificacion');
  
         $con = Propel::getConnection();
         if($codigo!=''||$codigo!=null){
  
             /*******Validar Traslados Origen************/
             $c_origen = new Criteria();
             $c_origen->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
             $c_origen->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
             $cantidad_origen = Tb097ModificacionDetallePeer::doCount($c_origen);
  
             $sum_origen = new Criteria();
             $sum_origen->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
             $sum_origen->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 1);
             $sum_origen->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') AS suma_origen');
             $suma_origen = Tb097ModificacionDetallePeer::doSelectStmt($sum_origen);
             $campos_origen = $suma_origen->fetch(PDO::FETCH_ASSOC);
  
             if ($cantidad_origen <= 0) {
               $this->data = json_encode(array(
                 'success' => false,
                 'msg' => '<span style="color:red;font-size:13px,"><b>Se debe al menos cargar una partida de Ingreso!</b></span>'
               ));
  
               return $this->setTemplate('store');
             }
  
             /*******Validar Traslados Destino************/
             $c_destino = new Criteria();
             $c_destino->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
             $c_destino->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 2);
             $cantidad_destino = Tb097ModificacionDetallePeer::doCount($c_destino);
  
             $sum_destino = new Criteria();
             $sum_destino->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
             $sum_destino->add(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION, 2);
             $sum_destino->addSelectColumn('SUM(' . Tb097ModificacionDetallePeer::MO_DISTRIBUCION . ') AS suma_destino');
             $suma_destino = Tb097ModificacionDetallePeer::doSelectStmt($sum_destino);
             $campos_destino_uno = $suma_destino->fetch(PDO::FETCH_ASSOC);
  
             if ($cantidad_destino <= 0) {
               $this->data = json_encode(array(
                 'success' => false,
                 'msg' => '<span style="color:red;font-size:13px,"><b>Se debe al menos cargar una partida de Gasto!</b></span>'
               ));
  
               return $this->setTemplate('store');
             }
  
             if ($campos_origen["suma_origen"] != $campos_destino_uno["suma_destino"] ) {
  
               $resta_traslado = $campos_origen["suma_origen"] -$campos_destino_uno["suma_destino"];
  
               $this->data = json_encode(array(
                 'success' => false,
                 'msg' => '<span style="color:red;font-size:13px,"><b>El monto total de las partidas de origen deben ser igual a las partidas de destino!<br></b></span>Diferencia: <b>'.$resta_traslado.'</b>'
               ));
  
               return $this->setTemplate('store');
             }
  
             try
              {
                  $con->beginTransaction();   

                  $tb096_presupuesto_modificacion = Tb096PresupuestoModificacionPeer::retrieveByPk($codigo);
                  $tb096_presupuesto_modificacion->setInProcesado(true);
                  $tb096_presupuesto_modificacion->save($con);
                
                  $sum_destino = new Criteria();

                  $sum_destino->add(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION,$codigo);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB096_PRESUPUESTO_MODIFICACION);        
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB013_ANIO_FISCAL);      
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB083_PROYECTO_AC);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB084_ACCION_ESPECIFICA);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB085_PRESUPUESTO);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::NU_PARTIDA);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB098_TIPO_DISTRIBUCION);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::MO_DISTRIBUCION);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB064_PRESUPUESTO_INGRESO);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB082_EJECUTOR_ORIGEN);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB082_EJECUTOR_DESTINO);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::ID_TB139_APLICACION);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::NU_APLICACION);
                  $sum_destino->addSelectColumn(Tb097ModificacionDetallePeer::IN_TRASPASO);

                  $suma_destino = Tb097ModificacionDetallePeer::doSelectStmt($sum_destino);
  
                  while($campos_destino = $suma_destino->fetch(PDO::FETCH_ASSOC)){

                    if($campos_destino["in_traspaso"]!=true){
                      if($campos_destino["id_tb098_tipo_distribucion"]==2){

                        $c10 = new Criteria();
                        $c10->add(Tb085PresupuestoPeer::ID, $campos_destino["id_tb085_presupuesto"]);
                        $stmt10 = Tb085PresupuestoPeer::doSelectStmt($c10);
                        $campos10 = $stmt10->fetch(PDO::FETCH_ASSOC);
                        
                        $c11 = new Criteria();
                        $c11->add(Tb082EjecutorPeer::ID, $campos_destino["id_tb082_ejecutor_destino"]);
                        $stmt11 = Tb082EjecutorPeer::doSelectStmt($c11);
                        $campos11 = $stmt11->fetch(PDO::FETCH_ASSOC);

                        $c12 = new Criteria();
                        $c12->clearSelectColumns();
                        $c12->add(Tb096PresupuestoModificacionPeer::ID, $codigo);
                        $c12->addSelectColumn(Tb068NumeroFuenteFinanciamientoPeer::TX_NUMERO_FUENTE);
                        $c12->addSelectColumn(Tb073FuenteFinanciamientoPeer::TX_SIGLAS);
                        $c12->addJoin(Tb096PresupuestoModificacionPeer::ID_TB068_NUMERO_FUENTE_FINANCIAMIENTO, Tb068NumeroFuenteFinanciamientoPeer::CO_NUMERO_FUENTE);
                        $c12->addJoin(Tb068NumeroFuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO, Tb073FuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO);
                        $stmt12 = Tb096PresupuestoModificacionPeer::doSelectStmt($c12);
                        $campos12 = $stmt12->fetch(PDO::FETCH_ASSOC);

                        /*CAMPOS*/     
//                        $tb085_presupuesto = new Tb085Presupuesto();
//                        $tb085_presupuesto->setIdTb084AccionEspecifica($campos_destino["id_tb084_accion_especifica"]);
//                        $tb085_presupuesto->setNuPartida($campos_destino["nu_partida"]);
//                        $tb085_presupuesto->setDePartida($campos10["de_partida"]);
//                        $tb085_presupuesto->setMoInicial(0);
//                        $tb085_presupuesto->setMoActualizado(0);
//                        $tb085_presupuesto->setMoPrecomprometido(0);
//                        $tb085_presupuesto->setMoComprometido(0);
//                        $tb085_presupuesto->setMoCausado(0);
//                        $tb085_presupuesto->setMoPagado(0);
//                        $tb085_presupuesto->setMoDisponible(0);
//                        $tb085_presupuesto->setInActivo(true);
//                        $tb085_presupuesto->setInMovimiento(true);
//                        $tb085_presupuesto->setNuPa($campos10["nu_pa"]);
//                        $tb085_presupuesto->setNuGe($campos10["nu_ge"]);
//                        $tb085_presupuesto->setNuEs($campos10["nu_es"]);
//                        $tb085_presupuesto->setNuSe($campos10["nu_se"]);
//                        $tb085_presupuesto->setNuSse($campos10["nu_sse"]);
//                        $tb085_presupuesto->setCoPartida($campos_destino["nu_partida"]);
//                        $tb085_presupuesto->setNuNivel(11);
//                        $tb085_presupuesto->setNuFi($campos12["tx_siglas"].$campos12["tx_numero_fuente"]);
//                        $tb085_presupuesto->setCoCategoria($campos11["nu_ejecutor"].'.'.$campos_destino["nu_partida"]);
//                        $tb085_presupuesto->setNuAplicacion($campos_destino["nu_aplicacion"]);
//                        $tb085_presupuesto->setTipApl($campos_destino["nu_aplicacion"]);
//                        $tb085_presupuesto->setInGenCheque(true);
//                        $tb085_presupuesto->setTipGasto($campos_destino["tip_gasto"]);
//                        $tb085_presupuesto->setCoEnte($campos_destino["id_tb082_ejecutor_destino"]);
//                        $tb085_presupuesto->setNuAnio($campos_destino["id_tb013_anio_fiscal"]);
//                        $tb085_presupuesto->setIdTb139Aplicacion($campos_destino['id_tb139_aplicacion']);
//                        $tb085_presupuesto->setCodEnte($campos11["nu_ejecutor"]);
//                        $tb085_presupuesto->save($con);

                        $saldo_anterior = 0;
                        $saldo_nuevo = $campos_destino["mo_distribucion"];

                        $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                        $tb087_presupuesto_movimiento->setCoPartida($campos_destino["id_tb085_presupuesto"])
                                         ->setCoTipoMovimiento(7)
                                         ->setNuMonto($campos_destino["mo_distribucion"])
                                         ->setNuAnio($campos_destino["id_tb013_anio_fiscal"])
                                         ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                         ->setTxObservacion('CREDITO ADICIONAL')
                                         ->setMoSaldoNuevo($saldo_nuevo)
                                         ->setMoSaldoAnterior($saldo_anterior)
                                         ->setInActivo(true)
                                         ->save($con);

                        $tb097_movimiento = Tb097ModificacionDetallePeer::retrieveByPK($campos_destino["id"]);
                        //$tb097_movimiento->setIdTb085Presupuesto($tb085_presupuesto->getId());
                        $tb097_movimiento->setInTraspaso(true);
                        $tb097_movimiento->save($con);

                      }else{
                          
                $c4 = new Criteria();
                $c4->add(Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO, $campos_destino["id_tb064_presupuesto_ingreso"]);
                $stmt4 = Tb064PresupuestoIngresoPeer::doSelectStmt($c4);
                $campos4 = $stmt4->fetch(PDO::FETCH_ASSOC);                          
                          
                $mo_devengado = $campos4["mo_comprometido"] + $campos_destino["mo_distribucion"];
                $mo_modificado = $campos4["mo_actualizado"] + $campos_destino["mo_distribucion"];

                $tb064_presupuesto_ingreso = Tb064PresupuestoIngresoPeer::retrieveByPk($campos_destino["id_tb064_presupuesto_ingreso"]);
                $tb064_presupuesto_ingreso->setMoComprometido($mo_devengado);
                $tb064_presupuesto_ingreso->setMoActualizado($mo_modificado);
                $tb064_presupuesto_ingreso->save($con);                         
                          
                $tb150_presupuesto_ingreso_movimiento = new Tb150PresupuestoIngresoMovimiento();
                $tb150_presupuesto_ingreso_movimiento->setIdTb064PresupuestoIngreso($campos_destino["id_tb064_presupuesto_ingreso"]);
                $tb150_presupuesto_ingreso_movimiento->setMoMovimiento($campos_destino["mo_distribucion"]);
                $tb150_presupuesto_ingreso_movimiento->setNuAnio( $this->getUser()->getAttribute('ejercicio'));
                $tb150_presupuesto_ingreso_movimiento->setCoUsuario($this->getUser()->getAttribute('codigo'));
                if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
                $tb150_presupuesto_ingreso_movimiento->setCreatedAt($this->getUser()->getAttribute('fe_cierre')); 
                }else{
                $tb150_presupuesto_ingreso_movimiento->setCreatedAt(date("Y-m-d")); 
                }
                $tb150_presupuesto_ingreso_movimiento->setCoTipoMovimiento(9);
                $tb150_presupuesto_ingreso_movimiento->setMoSaldoAnterior($campos4["mo_comprometido"]);
                $tb150_presupuesto_ingreso_movimiento->setMoSaldoNuevo($mo_devengado);                
                $tb150_presupuesto_ingreso_movimiento->setCoSolicitud($tb096_presupuesto_modificacion->getCoSolicitud());
                $tb150_presupuesto_ingreso_movimiento->setTxObservacion('CREDITO ADICIONAL');
                $tb150_presupuesto_ingreso_movimiento->save($con);
                
                $tb150_presupuesto_ingreso_movimiento = new Tb150PresupuestoIngresoMovimiento();
                $tb150_presupuesto_ingreso_movimiento->setIdTb064PresupuestoIngreso($campos_destino["id_tb064_presupuesto_ingreso"]);
                $tb150_presupuesto_ingreso_movimiento->setMoMovimiento($campos_destino["mo_distribucion"]);
                $tb150_presupuesto_ingreso_movimiento->setNuAnio( $this->getUser()->getAttribute('ejercicio'));
                $tb150_presupuesto_ingreso_movimiento->setCoUsuario($this->getUser()->getAttribute('codigo'));
                if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
                $tb150_presupuesto_ingreso_movimiento->setCreatedAt($this->getUser()->getAttribute('fe_cierre')); 
                }else{
                $tb150_presupuesto_ingreso_movimiento->setCreatedAt(date("Y-m-d")); 
                }                
                $tb150_presupuesto_ingreso_movimiento->setCoTipoMovimiento(7);
                $tb150_presupuesto_ingreso_movimiento->setMoSaldoAnterior($campos4["mo_actualizado"]);
                $tb150_presupuesto_ingreso_movimiento->setMoSaldoNuevo($mo_modificado);
                $tb150_presupuesto_ingreso_movimiento->setCoSolicitud($tb096_presupuesto_modificacion->getCoSolicitud());
                $tb150_presupuesto_ingreso_movimiento->setTxObservacion('CREDITO ADICIONAL');
                $tb150_presupuesto_ingreso_movimiento->save($con);

                $tb097_movimiento = Tb097ModificacionDetallePeer::retrieveByPK($campos_destino["id"]);
                $tb097_movimiento->setInTraspaso(true);
                $tb097_movimiento->save($con);                
                          
                      }
                    }
                  }
                  
                  $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb096_presupuesto_modificacionForm["co_solicitud"]));
                  $ruta->setInCargarDato(true)->save($con);

                  Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta()); 

                $con->commit();

                $this->data = json_encode(array(
                  'success' => true,
                  'msg' => 'Partidas Creadas con exito!.'
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
  
         $this->setTemplate('store');
  
        }
      
      public function executeGuardarCompromisoLey(sfWebRequest $request)
      {

                $codigo = $this->getRequestParameter("id_tb097_modificacion_detalle");
                
                $id_tb096_presupuesto_modificacion = $this->getRequestParameter("id_tb096_presupuesto_modificacion");

         $con = Propel::getConnection();
         if($codigo!=''||$codigo!=null){
             $tb097_modificacion_detalle = Tb097ModificacionDetallePeer::retrieveByPk($codigo);
         }else{
             $tb097_modificacion_detalle = new Tb097ModificacionDetalle();
         }
         try
          {
            $con->beginTransaction();

            $tb097_modificacion_detalleForm = $this->getRequestParameter('tb096_presupuesto_modificacion');
    /*CAMPOS*/

            /*Campo tipo BIGINT */
            $tb097_modificacion_detalle->setIdTb096PresupuestoModificacion($this->getRequestParameter("id_tb096_presupuesto_modificacion"));

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
            $tb097_modificacion_detalle->setMoDistribucion($tb097_modificacion_detalleForm["monto"]);

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
            
            
            $tb096_presupuesto_modificacion = Tb096PresupuestoModificacionPeer::retrieveByPk($id_tb096_presupuesto_modificacion);
            
            
                /*Campo tipo DATE */
                list($dia, $mes, $anio) = explode("/",$tb097_modificacion_detalleForm["fe_modificacion"]);
                $fecha = $anio."-".$mes."-".$dia;
                $tb096_presupuesto_modificacion->setFeModificacion($fecha);

                /*Campo tipo VARCHAR */
                $tb096_presupuesto_modificacion->setDeModificacion($tb097_modificacion_detalleForm["de_modificacion"]);

                /*Campo tipo VARCHAR */
                $tb096_presupuesto_modificacion->setDeJustificacion($tb097_modificacion_detalleForm["de_justificacion"]);

                /*Campo tipo DATE */
                $tb096_presupuesto_modificacion->setNuOficio($tb097_modificacion_detalleForm["nu_oficio"]);

                /*Campo tipo DATE */
                /*Campo tipo DATE */
                if($tb097_modificacion_detalleForm["fe_oficio"]!=''){
                  list($dia, $mes, $anio) = explode("/",$tb097_modificacion_detalleForm["fe_oficio"]);
                  $fecha = $anio."-".$mes."-".$dia;
                  $tb096_presupuesto_modificacion->setFeOficio($fecha);
                }

                /*Campo tipo VARCHAR */
                $tb096_presupuesto_modificacion->setDeArticuloLey($tb097_modificacion_detalleForm["de_articulo_ley"]);


                /*Campo tipo TIMESTAMP */
                $fecha = date("Y-m-d H:i:s");

                /*Campo tipo TIMESTAMP */
                $tb096_presupuesto_modificacion->setUpdatedAt($fecha);

                /*Campo tipo BIGINT */
                $tb096_presupuesto_modificacion->setCoUsuario($this->getUser()->getAttribute('codigo'));


                /*CAMPOS*/
                $tb096_presupuesto_modificacion->save($con);
                
                /*****Presupeusto de Ingreso*****/
                $c4 = new Criteria();
                $c4->add(Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO, $tb097_modificacion_detalleForm["id_tb064_presupuesto_ingreso"]);
                $stmt4 = Tb064PresupuestoIngresoPeer::doSelectStmt($c4);
                $campos4 = $stmt4->fetch(PDO::FETCH_ASSOC);

                if($tb097_modificacion_detalleForm["monto_ingreso_anterior"]!=0){
                if($tb097_modificacion_detalleForm["id_tb064_presupuesto_ingreso"]!=$tb097_modificacion_detalleForm["co_presupuesto_ingreso_anterior"]){
                    
                $c3 = new Criteria();
                $c3->add(Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO, $tb097_modificacion_detalleForm["co_presupuesto_ingreso_anterior"]);
                $stmt3 = Tb064PresupuestoIngresoPeer::doSelectStmt($c3);
                $campos3 = $stmt3->fetch(PDO::FETCH_ASSOC);                    
                
                $mo_devengado_anterior = $campos3["mo_comprometido"] - $tb097_modificacion_detalleForm["monto_ingreso_anterior"];                    
                    
                $tb064_presupuesto_ingreso = Tb064PresupuestoIngresoPeer::retrieveByPk($tb097_modificacion_detalleForm["co_presupuesto_ingreso_anterior"]);
                $tb064_presupuesto_ingreso->setMoComprometido($mo_devengado_anterior);
                $tb064_presupuesto_ingreso->save($con);                    
                    
                $mo_devengado = $campos4["mo_comprometido"] + $tb097_modificacion_detalleForm["monto"];

                $tb064_presupuesto_ingreso = Tb064PresupuestoIngresoPeer::retrieveByPk($tb097_modificacion_detalleForm["id_tb064_presupuesto_ingreso"]);
                $tb064_presupuesto_ingreso->setMoComprometido($mo_devengado);
                $tb064_presupuesto_ingreso->save($con); 
                
                $c5 = new Criteria();
                $c5->add(Tb150PresupuestoIngresoMovimientoPeer::ID_TB064_PRESUPUESTO_INGRESO, $tb097_modificacion_detalleForm["co_presupuesto_ingreso_anterior"]);
                $c5->add(Tb150PresupuestoIngresoMovimientoPeer::IN_ACTIVO, TRUE);
                $c5->add(Tb150PresupuestoIngresoMovimientoPeer::CO_TIPO_MOVIMIENTO, 9);
                $c5->add(Tb150PresupuestoIngresoMovimientoPeer::CO_SOLICITUD, $tb097_modificacion_detalleForm["co_solicitud"]);
                $stmt5 = Tb150PresupuestoIngresoMovimientoPeer::doSelectStmt($c5);
                while($res = $stmt5->fetch(PDO::FETCH_ASSOC)){
                $tb150_presupuesto_ingreso = Tb150PresupuestoIngresoMovimientoPeer::retrieveByPk($res["id"]);
                $tb150_presupuesto_ingreso->setInActivo(FALSE);
                $tb150_presupuesto_ingreso->save($con);
                }



                $c5 = new Criteria();
                $c5->add(Tb150PresupuestoIngresoMovimientoPeer::ID_TB064_PRESUPUESTO_INGRESO, $tb097_modificacion_detalleForm["id_tb064_presupuesto_ingreso"]);
                $c5->add(Tb150PresupuestoIngresoMovimientoPeer::IN_ACTIVO, TRUE);
                $c5->add(Tb150PresupuestoIngresoMovimientoPeer::CO_TIPO_MOVIMIENTO, 9);
                $stmt5 = Tb150PresupuestoIngresoMovimientoPeer::doSelectStmt($c5);
                while($res = $stmt5->fetch(PDO::FETCH_ASSOC)){
                $tb150_presupuesto_ingreso = Tb150PresupuestoIngresoMovimientoPeer::retrieveByPk($res["id"]);
                $tb150_presupuesto_ingreso->setInActivo(FALSE);
                $tb150_presupuesto_ingreso->save($con);
                }                
                
                $tb150_presupuesto_ingreso_movimiento = new Tb150PresupuestoIngresoMovimiento();
                $tb150_presupuesto_ingreso_movimiento->setIdTb064PresupuestoIngreso($tb097_modificacion_detalleForm["id_tb064_presupuesto_ingreso"]);
                $tb150_presupuesto_ingreso_movimiento->setMoMovimiento($tb097_modificacion_detalleForm["monto"]);
                $tb150_presupuesto_ingreso_movimiento->setNuAnio( $this->getUser()->getAttribute('ejercicio'));
                $tb150_presupuesto_ingreso_movimiento->setCoUsuario($this->getUser()->getAttribute('codigo'));
                if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
                $tb150_presupuesto_ingreso_movimiento->setCreatedAt($this->getUser()->getAttribute('fe_cierre')); 
                }else{
                $tb150_presupuesto_ingreso_movimiento->setCreatedAt(date("Y-m-d")); 
                }                
                $tb150_presupuesto_ingreso_movimiento->setCoTipoMovimiento(9);
                $tb150_presupuesto_ingreso_movimiento->setMoSaldoAnterior($campos4["mo_comprometido"]);
                $tb150_presupuesto_ingreso_movimiento->setMoSaldoNuevo($mo_devengado); 
                $tb150_presupuesto_ingreso_movimiento->setCoSolicitud($tb097_modificacion_detalleForm["co_solicitud"]);
                $tb150_presupuesto_ingreso_movimiento->setTxObservacion('INGRESO COMPROMISO DE LEY');
                $tb150_presupuesto_ingreso_movimiento->save($con);                 
                
                }
                
                
                
                }else{
                                
                $mo_devengado = $campos4["mo_comprometido"] + $tb097_modificacion_detalleForm["monto"];

                $tb064_presupuesto_ingreso = Tb064PresupuestoIngresoPeer::retrieveByPk($tb097_modificacion_detalleForm["id_tb064_presupuesto_ingreso"]);
                $tb064_presupuesto_ingreso->setMoComprometido($mo_devengado);
                $tb064_presupuesto_ingreso->save($con);                
                
                $tb150_presupuesto_ingreso_movimiento = new Tb150PresupuestoIngresoMovimiento();
                $tb150_presupuesto_ingreso_movimiento->setIdTb064PresupuestoIngreso($tb097_modificacion_detalleForm["id_tb064_presupuesto_ingreso"]);
                $tb150_presupuesto_ingreso_movimiento->setMoMovimiento($tb097_modificacion_detalleForm["monto"]);
                $tb150_presupuesto_ingreso_movimiento->setNuAnio( $this->getUser()->getAttribute('ejercicio'));
                $tb150_presupuesto_ingreso_movimiento->setCoUsuario($this->getUser()->getAttribute('codigo'));
                if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
                $tb150_presupuesto_ingreso_movimiento->setCreatedAt($this->getUser()->getAttribute('fe_cierre')); 
                }else{
                $tb150_presupuesto_ingreso_movimiento->setCreatedAt(date("Y-m-d")); 
                }                
                $tb150_presupuesto_ingreso_movimiento->setCoTipoMovimiento(9);
                $tb150_presupuesto_ingreso_movimiento->setMoSaldoAnterior($campos4["mo_comprometido"]);
                $tb150_presupuesto_ingreso_movimiento->setMoSaldoNuevo($mo_devengado); 
                $tb150_presupuesto_ingreso_movimiento->setCoSolicitud($tb097_modificacion_detalleForm["co_solicitud"]);
                $tb150_presupuesto_ingreso_movimiento->setTxObservacion('INGRESO COMPROMISO DE LEY');
                $tb150_presupuesto_ingreso_movimiento->save($con);        
                }               
            
                $this->data = json_encode(array(
                        "success" => true,
                        "msg" => 'Modificación realizada exitosamente'
                    ));
            
            
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb097_modificacion_detalleForm["co_solicitud"]));
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
	$tb096_presupuesto_modificacion = Tb096PresupuestoModificacionPeer::retrieveByPk($codigo);
	$tb096_presupuesto_modificacion->delete($con);
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
                $id_tb095_tipo_modificacion      =   $this->getRequestParameter("id_tb095_tipo_modificacion");
            $nu_modificacion      =   $this->getRequestParameter("nu_modificacion");
            $fe_modificacion      =   $this->getRequestParameter("fe_modificacion");
            $de_modificacion      =   $this->getRequestParameter("de_modificacion");
            $de_justificacion      =   $this->getRequestParameter("de_justificacion");
            $nu_oficio      =   $this->getRequestParameter("nu_oficio");
            $fe_oficio      =   $this->getRequestParameter("fe_oficio");
            $de_articulo_ley      =   $this->getRequestParameter("de_articulo_ley");
            $mo_modificacion      =   $this->getRequestParameter("mo_modificacion");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($id_tb095_tipo_modificacion!=""){$c->add(Tb096PresupuestoModificacionPeer::id_tb095_tipo_modificacion,$id_tb095_tipo_modificacion);}

                                        if($nu_modificacion!=""){$c->add(Tb096PresupuestoModificacionPeer::nu_modificacion,'%'.$nu_modificacion.'%',Criteria::LIKE);}


        if($fe_modificacion!=""){
    list($dia, $mes,$anio) = explode("/",$fe_modificacion);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb096PresupuestoModificacionPeer::fe_modificacion,$fecha);
    }
                                        if($de_modificacion!=""){$c->add(Tb096PresupuestoModificacionPeer::de_modificacion,'%'.$de_modificacion.'%',Criteria::LIKE);}

                                        if($de_justificacion!=""){$c->add(Tb096PresupuestoModificacionPeer::de_justificacion,'%'.$de_justificacion.'%',Criteria::LIKE);}


        if($nu_oficio!=""){
    list($dia, $mes,$anio) = explode("/",$nu_oficio);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb096PresupuestoModificacionPeer::nu_oficio,$fecha);
    }

        if($fe_oficio!=""){
    list($dia, $mes,$anio) = explode("/",$fe_oficio);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb096PresupuestoModificacionPeer::fe_oficio,$fecha);
    }
                                        if($de_articulo_ley!=""){$c->add(Tb096PresupuestoModificacionPeer::de_articulo_ley,'%'.$de_articulo_ley.'%',Criteria::LIKE);}

                                            if($mo_modificacion!=""){$c->add(Tb096PresupuestoModificacionPeer::mo_modificacion,$mo_modificacion);}



        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb096PresupuestoModificacionPeer::created_at,$fecha);
    }

        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb096PresupuestoModificacionPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb096PresupuestoModificacionPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb096PresupuestoModificacionPeer::ID);

    $stmt = Tb096PresupuestoModificacionPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "id_tb095_tipo_modificacion"     => trim($res["id_tb095_tipo_modificacion"]),
            "nu_modificacion"     => trim($res["nu_modificacion"]),
            "fe_modificacion"     => trim($res["fe_modificacion"]),
            "de_modificacion"     => trim($res["de_modificacion"]),
            "de_justificacion"     => trim($res["de_justificacion"]),
            "nu_oficio"     => trim($res["nu_oficio"]),
            "fe_oficio"     => trim($res["fe_oficio"]),
            "de_articulo_ley"     => trim($res["de_articulo_ley"]),
            "mo_modificacion"     => trim($res["mo_modificacion"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb095_tipo_modificacion.ID
    public function executeStorefkidtb095tipomodificacion(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb095TipoModificacionPeer::doSelectStmt($c);
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
        $subSelect = "tb082_ejecutor.id IN (SELECT id_tb082_ejecutor
          FROM tb085_presupuesto as t01
          INNER JOIN tb084_accion_especifica as t02 ON t01.id_tb084_accion_especifica = t02.id
          INNER JOIN tb083_proyecto_ac as t03 ON t02.id_tb083_proyecto_ac = t03.id
          WHERE id_tb013_anio_fiscal = ".$this->getUser()->getAttribute('ejercicio')."
          GROUP BY 1
        )";
        $c = new Criteria();
        $c->add(Tb082EjecutorPeer::IN_ACTIVO,TRUE);
        $c->add(Tb082EjecutorPeer::ID, $subSelect, Criteria::CUSTOM);
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

    public function executeStorefkcoproyecto(sfWebRequest $request){

        $co_ejecutor = $this->getRequestParameter('ejecutor');

        $c = new Criteria();
        $c->add(Tb083ProyectoAcPeer::IN_ACTIVO,TRUE);
        $c->add(Tb083ProyectoAcPeer::ID_TB082_EJECUTOR,$co_ejecutor);
        $c->add(Tb083ProyectoAcPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
        $stmt = Tb083ProyectoAcPeer::doSelectStmt($c);
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
    
    public function executeStorefkidtb064presupuestoingreso(sfWebRequest $request){

      $c = new Criteria();
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
    
    //modelo fk tb068_numero_fuente_financiamiento.CO_NUMERO_FUENTE
    public function executeStorefkidtb068numerofuentefinanciamiento(sfWebRequest $request){
      $con = Propel::getConnection();
      $tipo = $this->getRequestParameter("tipo");
      $numero = $this->getRequestParameter("numero",0);
     
        $stmt1 = $con->prepare("select substr(nu_fi,2,4) as nu_fi from tb085_presupuesto where nu_anio = ".$this->getUser()->getAttribute('ejercicio')." and nu_fi is not null group by nu_fi order by nu_fi");   
 
        $stmt1->execute();
        while($reg1 = $stmt1->fetch(PDO::FETCH_ASSOC)){   
            
           $array_producto[$i] = $reg1["nu_fi"]; 
           $i++;
        }        
        //var_dump($array_producto);exit();
      $c = new Criteria();
      //$c->add(Tb068NumeroFuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO, 4);
      $c->add(Tb068NumeroFuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO, $tipo);
      $c->addDescendingOrderByColumn(Tb068NumeroFuenteFinanciamientoPeer::TX_NUMERO_FUENTE);
      $c->add(Tb068NumeroFuenteFinanciamientoPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
      if($numero==0){
      $c->add(Tb068NumeroFuenteFinanciamientoPeer::TX_NUMERO_FUENTE, $array_producto, Criteria::NOT_IN);
      }else{
      $c->add(Tb068NumeroFuenteFinanciamientoPeer::CO_NUMERO_FUENTE, $numero);    
      }
      $stmt = Tb068NumeroFuenteFinanciamientoPeer::doSelectStmt($c);
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

  //modelo fk tb152_tipo_credito.ID
  public function executeStorefkidtb152tipocredito(sfWebRequest $request){
    $c = new Criteria();
    $stmt = Tb152TipoCreditoPeer::doSelectStmt($c);
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

  //modelo fk tb073_fuente_financiamiento.CO_FUENTE_FINANCIAMIENTO
  public function executeStorefkcofuentefinanciamiento(sfWebRequest $request){
    $c = new Criteria();
    $stmt = Tb073FuenteFinanciamientoPeer::doSelectStmt($c);
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
