<?php

/**
 * Asignacionpresupuesto actions.
 *
 * @package    gobel
 * @subpackage Asignacionpresupuesto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class AsignacionpresupuestoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {

    $this->ejercicio = $this->getUser()->getAttribute('ejercicio');
    $this->getRequest()->setAttribute('ejercicio', $this->ejercicio);

    $c = new Criteria();
    $c->setIgnoreCase(true);
    $c->add(Tb083ProyectoAcPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
    $cantidad = Tb083ProyectoAcPeer::doCount($c);

   // if( $cantidad >= 1){
      $this->forward('Asignacionpresupuesto', 'lista');
   /* }else{
      $this->forward('Asignacionpresupuesto', 'vacio');
    }*/
  }
  
  public function executeListaDesagregadaTodas(sfWebRequest $request)
  {
//    $this->data = json_encode(array(
//        "nu_partida" => $this->getRequestParameter("nu_partida"),
//        "co_accion_especifica" => $this->getRequestParameter("co_accion_especifica")
//    ));
  }

  public function executeVacio(sfWebRequest $request)
  {

  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Asignacionpresupuesto', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb083ProyectoAcPeer::ID,$codigo);

        $stmt = Tb083ProyectoAcPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb080_sector"     => $campos["id_tb080_sector"],
                            "id_tb081_sub_sector"     => $campos["id_tb081_sub_sector"],
                            "id_tb082_ejecutor"     => $campos["id_tb082_ejecutor"],
                            "nu_proyecto_ac"     => $campos["nu_proyecto_ac"],
                            "de_proyecto_ac"     => $campos["de_proyecto_ac"],
                            "id_tb013_anio_fiscal"     => $campos["id_tb013_anio_fiscal"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb080_sector"     => "",
                            "id_tb081_sub_sector"     => "",
                            "id_tb082_ejecutor"     => "",
                            "nu_proyecto_ac"     => "",
                            "de_proyecto_ac"     => "",
                            "id_tb013_anio_fiscal"     => "",
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
         $tb083_proyecto_ac = Tb083ProyectoAcPeer::retrieveByPk($codigo);
     }else{
         $tb083_proyecto_ac = new Tb083ProyectoAc();
     }
     try
      {
        $con->beginTransaction();

        $tb083_proyecto_acForm = $this->getRequestParameter('tb083_proyecto_ac');
/*CAMPOS*/

        /*Campo tipo BIGINT */
        $tb083_proyecto_ac->setIdTb080Sector($tb083_proyecto_acForm["id_tb080_sector"]);

        /*Campo tipo BIGINT */
        $tb083_proyecto_ac->setIdTb081SubSector($tb083_proyecto_acForm["id_tb081_sub_sector"]);

        /*Campo tipo BIGINT */
        $tb083_proyecto_ac->setIdTb082Ejecutor($tb083_proyecto_acForm["id_tb082_ejecutor"]);

        /*Campo tipo VARCHAR */
        $tb083_proyecto_ac->setNuProyectoAc($tb083_proyecto_acForm["nu_proyecto_ac"]);

        /*Campo tipo VARCHAR */
        $tb083_proyecto_ac->setDeProyectoAc($tb083_proyecto_acForm["de_proyecto_ac"]);

        /*Campo tipo BIGINT */
        $tb083_proyecto_ac->setIdTb013AnioFiscal($tb083_proyecto_acForm["id_tb013_anio_fiscal"]);

        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb083_proyecto_acForm)){
            $tb083_proyecto_ac->setInActivo(false);
        }else{
            $tb083_proyecto_ac->setInActivo(true);
        }

        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb083_proyecto_acForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb083_proyecto_ac->setCreatedAt($fecha);

        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb083_proyecto_acForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb083_proyecto_ac->setUpdatedAt($fecha);

        /*CAMPOS*/
        $tb083_proyecto_ac->save($con);
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
	$tb083_proyecto_ac = Tb083ProyectoAcPeer::retrieveByPk($codigo);
	$tb083_proyecto_ac->delete($con);
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
    $co_ejecutor = $this->getUser()->getAttribute('co_ejecutor');
    
    $id_tb080_sector      =   $this->getRequestParameter("id_tb080_sector");
    $id_tb081_sub_sector      =   $this->getRequestParameter("id_tb081_sub_sector");
    $id_tb082_ejecutor      =   $this->getRequestParameter("id_tb082_ejecutor");
    $nu_proyecto_ac      =   $this->getRequestParameter("nu_proyecto_ac");
    $de_proyecto_ac      =   $this->getRequestParameter("de_proyecto_ac");
    $id_tb013_anio_fiscal      =   $this->getRequestParameter("id_tb013_anio_fiscal");
    $in_activo      =   $this->getRequestParameter("in_activo");
    $created_at      =   $this->getRequestParameter("created_at");
    $updated_at      =   $this->getRequestParameter("updated_at");
    $id_tb086_tipo_prac      =   $this->getRequestParameter("id_tb086_tipo_prac");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
        if($id_tb080_sector!=""){$c->add(Tb083ProyectoAcPeer::ID_TB080_SECTOR,$id_tb080_sector);}

        if($id_tb081_sub_sector!=""){$c->add(Tb083ProyectoAcPeer::ID_TB081_SUB_SECTOR,$id_tb081_sub_sector);}

        if($id_tb082_ejecutor!=""){$c->add(Tb083ProyectoAcPeer::ID_TB082_EJECUTOR,$id_tb082_ejecutor);}

        if($nu_proyecto_ac!=""){$c->add(Tb083ProyectoAcPeer::NU_PROYECTO_AC,'%'.$nu_proyecto_ac.'%',Criteria::LIKE);}

        if($de_proyecto_ac!=""){$c->add(Tb083ProyectoAcPeer::DE_PROYECTO_AC,'%'.$de_proyecto_ac.'%',Criteria::LIKE);}

        if($id_tb013_anio_fiscal!=""){$c->add(Tb083ProyectoAcPeer::ID_TB013_ANIO_FISCAL,$id_tb013_anio_fiscal);}

        if($id_tb086_tipo_prac!=""){$c->add(Tb083ProyectoAcPeer::ID_TB086_TIPO_PRAC,$id_tb086_tipo_prac);}
    }
    
    $c->setIgnoreCase(true);
    $c->add(Tb083ProyectoAcPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
    
    if($co_ejecutor!=''){
        $c->add(Tb083ProyectoAcPeer::ID_TB082_EJECUTOR,$co_ejecutor);
    }
    
    $cantidadTotal = Tb083ProyectoAcPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb083ProyectoAcPeer::ID);

    $c->clearSelectColumns();
    $c->addSelectColumn(Tb083ProyectoAcPeer::ID);
    $c->addSelectColumn(Tb083ProyectoAcPeer::NU_PROYECTO_AC);
    $c->addSelectColumn(Tb083ProyectoAcPeer::DE_PROYECTO_AC);
    $c->addSelectColumn(Tb083ProyectoAcPeer::ID_TB013_ANIO_FISCAL);
    $c->addSelectColumn(Tb080SectorPeer::NU_SECTOR);
//    $c->addSelectColumn(Tb081SubSectorPeer::NU_SUB_SECTOR);
    $c->addSelectColumn(Tb082EjecutorPeer::NU_EJECUTOR);
    $c->addJoin(Tb080SectorPeer::ID, Tb083ProyectoAcPeer::ID_TB080_SECTOR);
   // $c->addJoin(Tb081SubSectorPeer::ID, Tb083ProyectoAcPeer::ID_TB081_SUB_SECTOR);
    $c->addJoin(Tb082EjecutorPeer::ID, Tb083ProyectoAcPeer::ID_TB082_EJECUTOR);

    //echo $c->toString(); exit();
    
    $stmt = Tb083ProyectoAcPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "id_tb080_sector"     => trim($res["nu_sector"]),
            "id_tb081_sub_sector"     => trim($res["nu_sub_sector"]),
            "id_tb082_ejecutor"     => trim($res["nu_ejecutor"]),
            "nu_proyecto_ac"     => trim($res["nu_proyecto_ac"]),
            "de_proyecto_ac"     => trim($res["de_proyecto_ac"]),
            "id_tb013_anio_fiscal"     => trim($res["id_tb013_anio_fiscal"]),
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

                    //modelo fk tb080_sector.ID
    public function executeStorefkidtb080sector(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb080SectorPeer::doSelectStmt($c);
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
                    //modelo fk tb081_sub_sector.ID
    public function executeStorefkidtb081subsector(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb081SubSectorPeer::doSelectStmt($c);
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
                    //modelo fk tb082_ejecutor.ID
    public function executeStorefkidtb082ejecutor(sfWebRequest $request){
        $c = new Criteria();
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
                                            //modelo fk tb013_anio_fiscal.CO_ANIO_FISCAL
    public function executeStorefkidtb013aniofiscal(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb013AnioFiscalPeer::doSelectStmt($c);
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

    //modelo fk tb086_tipo_prac.ID
    public function executeStorefkidtb086tipoprac(sfWebRequest $request){
      $c = new Criteria();
      $stmt = Tb086TipoPracPeer::doSelectStmt($c);
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

    public function executeDetalleae(sfWebRequest $request)
    {

      $codigo = $this->getRequestParameter("codigo");
      if($codigo!=''||$codigo!=null){
          $c = new Criteria();
          $c->clearSelectColumns();
          $c->addSelectColumn(Tb083ProyectoAcPeer::ID);
          $c->addSelectColumn(Tb083ProyectoAcPeer::NU_PROYECTO_AC);
          $c->addSelectColumn(Tb083ProyectoAcPeer::DE_PROYECTO_AC);
          $c->addSelectColumn(Tb083ProyectoAcPeer::ID_TB013_ANIO_FISCAL);
          $c->addSelectColumn(Tb080SectorPeer::NU_SECTOR);
          $c->addSelectColumn(Tb080SectorPeer::DE_SECTOR);
//          $c->addSelectColumn(Tb081SubSectorPeer::NU_SUB_SECTOR);
//          $c->addSelectColumn(Tb081SubSectorPeer::DE_SUB_SECTOR);
          $c->addSelectColumn(Tb082EjecutorPeer::NU_EJECUTOR);
          $c->addSelectColumn(Tb082EjecutorPeer::DE_EJECUTOR);
          $c->addSelectColumn(Tb086TipoPracPeer::DE_TIPO_PRAC);
          $c->addJoin(Tb080SectorPeer::ID, Tb083ProyectoAcPeer::ID_TB080_SECTOR);
//          $c->addJoin(Tb081SubSectorPeer::ID, Tb083ProyectoAcPeer::ID_TB081_SUB_SECTOR);
          $c->addJoin(Tb082EjecutorPeer::ID, Tb083ProyectoAcPeer::ID_TB082_EJECUTOR);
          $c->addJoin(Tb086TipoPracPeer::ID, Tb083ProyectoAcPeer::ID_TB086_TIPO_PRAC);
          $c->add(Tb083ProyectoAcPeer::ID,$codigo);

          $stmt = Tb083ProyectoAcPeer::doSelectStmt($c);
          $campos = $stmt->fetch(PDO::FETCH_ASSOC);
          $this->data = json_encode(array(
                              "id"     => $campos["id"],
                              "id_tb080_sector"     => $campos["nu_sector"].' - '.$campos["de_sector"],
                              "id_tb081_sub_sector"     => $campos["nu_sub_sector"].' - '.$campos["de_sub_sector"],
                              "id_tb082_ejecutor"     => $campos["nu_ejecutor"].' - '.$campos["de_ejecutor"],
                              "nu_proyecto_ac"     => $campos["nu_proyecto_ac"],
                              "de_proyecto_ac"     => $campos["de_proyecto_ac"],
                              "id_tb013_anio_fiscal"     => $campos["id_tb013_anio_fiscal"],
                              "in_activo"     => $campos["in_activo"],
                              "created_at"     => $campos["created_at"],
                              "updated_at"     => $campos["updated_at"],
                              "de_tipo_prac"     => $campos["de_tipo_prac"],
                      ));
      }else{
          $this->data = json_encode(array(
                              "id"     => "",
                              "id_tb080_sector"     => "",
                              "id_tb081_sub_sector"     => "",
                              "id_tb082_ejecutor"     => "",
                              "nu_proyecto_ac"     => "",
                              "de_proyecto_ac"     => "",
                              "id_tb013_anio_fiscal"     => "",
                              "in_activo"     => "",
                              "created_at"     => "",
                              "updated_at"     => "",
                      ));
      }

    }
    
    
    
    public function executeStorefkAnioFiscal(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb013AnioFiscalPeer::doSelectStmt($c);
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
    
    public function executeStorelistaDesagregadaTodas(sfWebRequest $request)
    {
            $paginar              =   $this->getRequestParameter("paginar");
            $nu_partida               =   $this->getRequestParameter("nu_partida");
            $co_accion_especifica =   $this->getRequestParameter("co_accion_especifica");
            $limit                =   $this->getRequestParameter("limit",15);
            $start                =   $this->getRequestParameter("start",0);

            $id_tb084_accion_especifica      =   $this->getRequestParameter("codigo");
            $nu_partida                      =   $this->getRequestParameter("nu_partida");
            $de_partida                      =   $this->getRequestParameter("de_partida");
            $mo_inicial                      =   $this->getRequestParameter("mo_inicial");
            $mo_actualizado                  =   $this->getRequestParameter("mo_actualizado");
            $mo_precomprometido              =   $this->getRequestParameter("mo_precomprometido");
            $mo_comprometido                 =   $this->getRequestParameter("mo_comprometido");
            $mo_causado                      =   $this->getRequestParameter("mo_causado");
            $mo_pagado                       =   $this->getRequestParameter("mo_pagado");
            $mo_disponible                   =   $this->getRequestParameter("mo_disponible");
            $in_activo                       =   $this->getRequestParameter("in_activo");
            $created_at                      =   $this->getRequestParameter("created_at");
            $updated_at                      =   $this->getRequestParameter("updated_at");
            $in_movimiento                   =   $this->getRequestParameter("in_movimiento");

            $co_ejecutor = $this->getRequestParameter("co_ejecutor");
            $tip_apl = $this->getRequestParameter("tip_apl");
            $nu_fi = $this->getRequestParameter("nu_fi");
            $monto       = $this->getRequestParameter("monto");

            $c = new Criteria();

            if($this->getRequestParameter("BuscarBy")=="true"){
                    if($id_tb084_accion_especifica!=""){$c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA,$id_tb084_accion_especifica);}

                    if($nu_partida!=""){$c->add(Tb085PresupuestoPeer::CO_PARTIDA,'%'.$nu_partida.'%',Criteria::LIKE);}

                    if($de_partida!=""){$c->add(Tb085PresupuestoPeer::DE_PARTIDA,'%'.$de_partida.'%',Criteria::LIKE);}

                    if($mo_inicial!=""){$c->add(Tb085PresupuestoPeer::MO_INICIAL,$mo_inicial);}

                    if($mo_actualizado!=""){$c->add(Tb085PresupuestoPeer::MO_ACTUALIZADO,$mo_actualizado);}

                    if($mo_precomprometido!=""){$c->add(Tb085PresupuestoPeer::MO_PRECOMPROMETIDO,$mo_precomprometido);}

                    if($mo_comprometido!=""){$c->add(Tb085PresupuestoPeer::MO_COMPROMETIDO,$mo_comprometido);}

                    if($mo_causado!=""){$c->add(Tb085PresupuestoPeer::MO_CAUSADO,$mo_causado);}

                    if($mo_pagado!=""){$c->add(Tb085PresupuestoPeer::MO_PAGADO,$mo_pagado);}

                    if($mo_disponible!=""){$c->add(Tb085PresupuestoPeer::MO_DISPONIBLE,$mo_disponible);}
            }

//            $datos_partida = $this->getDatosPartida($codigo);
            
            $c->setIgnoreCase(true);
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb085PresupuestoPeer::ID);
            $c->addSelectColumn(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA);
            $c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
            $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_INICIAL);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_ACTUALIZADO);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_PRECOMPROMETIDO);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_COMPROMETIDO);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_CAUSADO);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_PAGADO);
            $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
            $c->addSelectColumn(Tb024CuentaContablePeer::TX_CUENTA);
            $c->addSelectColumn(Tb085PresupuestoPeer::NU_NIVEL);
            $c->addSelectColumn(Tb139AplicacionPeer::TX_TIP_APLICACION);
            $c->addSelectColumn(Tb139AplicacionPeer::TX_APLICACION);
            $c->addSelectColumn(Tb084AccionEspecificaPeer::NU_ACCION_ESPECIFICA);
            $c->addSelectColumn(Tb083ProyectoAcPeer::NU_PROYECTO_AC);
            $c->addSelectColumn(Tb080SectorPeer::NU_SECTOR);
            
            $c->addJoin(Tb080SectorPeer::ID, Tb083ProyectoAcPeer::ID_TB080_SECTOR);
            $c->addJoin(Tb083ProyectoAcPeer::ID, Tb084AccionEspecificaPeer::ID_TB083_PROYECTO_AC);
            $c->addJoin(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA, Tb084AccionEspecificaPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(Tb085PresupuestoPeer::CO_CUENTA_CONTABLE, Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Criteria::LEFT_JOIN);
            $c->addJoin(Tb085PresupuestoPeer::TIP_APL, Tb139AplicacionPeer::TX_TIP_APLICACION, Criteria::LEFT_JOIN);
            $c->addJoin(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA, Tb084AccionEspecificaPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(Tb084AccionEspecificaPeer::ID_TB083_PROYECTO_AC, Tb083ProyectoAcPeer::ID, Criteria::LEFT_JOIN);
            
            $c->add(Tb085PresupuestoPeer::NU_ANIO,$this->getRequestParameter("tx_anio_fiscal"));
            
            $c->add(Tb085PresupuestoPeer::NU_FI,'', Criteria::NOT_EQUAL);
            
            if($co_ejecutor!=''){
                $c->add(Tb083ProyectoAcPeer::ID_TB082_EJECUTOR,$co_ejecutor);
            }
            
            if($monto!=''){
                $c->add(Tb085PresupuestoPeer::MO_DISPONIBLE,$monto, Criteria::GREATER_EQUAL);
            }
            
            if($tip_apl!=''){
                $c->add(Tb139AplicacionPeer::CO_APLICACION,$tip_apl);
            }      
            
            if($nu_fi!=''){
                $c->add(Tb085PresupuestoPeer::NU_FI,$nu_fi);
            }             
            
//            $c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA,$id_tb084_accion_especifica);
//            $c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA,$co_accion_especifica);  
//            $c->add(Tb085PresupuestoPeer::CO_PARTIDA,$nu_partida);
            
            
            
            $cantidadTotal = Tb085PresupuestoPeer::doCount($c);

            $c->setLimit($limit)->setOffset($start);
                $c->addAscendingOrderByColumn(Tb085PresupuestoPeer::ID);

            $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
            $registros = "";
            while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = array(
                    "id"     => trim($res["id"]),
                    "id_tb084_accion_especifica"    => trim($res["id_tb084_accion_especifica"]),
                    "nu_partida"                    => trim($res["nu_sector"].'.'.$res["nu_proyecto_ac"].'.00.'.$res["nu_accion_especifica"].'.'.Tb085PresupuestoPeer::mascaraNomina($res["nu_partida"])),
                    "de_partida"                    => trim($res["de_partida"]),
                    "mo_inicial"                    => trim($res["mo_inicial"]),
                    "mo_actualizado"                => trim($res["mo_actualizado"]),
                    "mo_precomprometido"            => trim($res["mo_precomprometido"]),
                    "mo_comprometido"               => trim($res["mo_comprometido"]),
                    "mo_causado"                    => trim($res["mo_causado"]),
                    "mo_pagado"                     => trim($res["mo_pagado"]),
                    "mo_disponible"                 => trim($res["mo_disponible"]),
                    "tx_cuenta"                     => trim($res["tx_cuenta"]),
                    "nu_nivel"                      => trim($res["nu_nivel"]),
                    "aplicacion"                    => $res["tx_tip_aplicacion"].'-'.$res["tx_aplicacion"]
                );
            }

            $this->data = json_encode(array(
                "success"   =>  true,
                "total"     =>  $cantidadTotal,
                "data"      =>  $registros
                ));
            
           $this->setTemplate('store');
    }

}
