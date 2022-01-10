<?php

/**
 * PresupuestoEjercicio actions.
 *
 * @package    gobel
 * @subpackage PresupuestoEjercicio
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class PresupuestoEjercicioActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('PresupuestoEjercicio', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('PresupuestoEjercicio', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb165PacTmpPeer::ID,$codigo);
        
        $stmt = Tb165PacTmpPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb080_sector"     => $campos["id_tb080_sector"],
                            "id_tb081_sub_sector"     => $campos["id_tb081_sub_sector"],
                            "id_tb082_ejecutor"     => $campos["id_tb082_ejecutor"],
                            "nu_proyecto_ac"     => $campos["nu_proyecto_ac"],
                            "de_proyecto_ac"     => $campos["de_proyecto_ac"],
                            "id_tb013_anio_fiscal"     => $campos["id_tb013_anio_fiscal"],
                            "id_tb086_tipo_prac"     => $campos["id_tb086_tipo_prac"],
                            "in_activo"     => $campos["in_activo"],
                            "in_cargado"     => $campos["in_cargado"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "mo_presupuesto"     => $campos["mo_presupuesto"],
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
                            "id_tb086_tipo_prac"     => "",
                            "in_activo"     => "",
                            "in_cargado"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "mo_presupuesto"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb165_pac_tmp = Tb165PacTmpPeer::retrieveByPk($codigo);
     }else{
         $tb165_pac_tmp = new Tb165PacTmp();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb165_pac_tmpForm = $this->getRequestParameter('tb165_pac_tmp');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb165_pac_tmp->setIdTb080Sector($tb165_pac_tmpForm["id_tb080_sector"]);
                                                        
        /*Campo tipo BIGINT */
        $tb165_pac_tmp->setIdTb081SubSector($tb165_pac_tmpForm["id_tb081_sub_sector"]);
                                                        
        /*Campo tipo BIGINT */
        $tb165_pac_tmp->setIdTb082Ejecutor($tb165_pac_tmpForm["id_tb082_ejecutor"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb165_pac_tmp->setNuProyectoAc($tb165_pac_tmpForm["nu_proyecto_ac"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb165_pac_tmp->setDeProyectoAc($tb165_pac_tmpForm["de_proyecto_ac"]);
                                                        
        /*Campo tipo BIGINT */
        $tb165_pac_tmp->setIdTb013AnioFiscal($tb165_pac_tmpForm["id_tb013_anio_fiscal"]);
                                                        
        /*Campo tipo BIGINT */
        $tb165_pac_tmp->setIdTb086TipoPrac($tb165_pac_tmpForm["id_tb086_tipo_prac"]);
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tb165_pac_tmpForm)){
            $tb165_pac_tmp->setInActivo(false);
        }else{
            $tb165_pac_tmp->setInActivo(true);
        }*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tb165_pac_tmpForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb165_pac_tmp->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tb165_pac_tmpForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb165_pac_tmp->setUpdatedAt($fecha);*/
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_cargado", $tb165_pac_tmpForm)){
            $tb165_pac_tmp->setInCargado(false);
        }else{
            $tb165_pac_tmp->setInCargado(true);
        }*/

                /*Campo tipo NUMERIC */
                $tb165_pac_tmp->setMoPresupuesto($tb165_pac_tmpForm["mo_presupuesto"]);
                                
        /*CAMPOS*/
        $tb165_pac_tmp->save($con);
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
	$tb165_pac_tmp = Tb165PacTmpPeer::retrieveByPk($codigo);			
	$tb165_pac_tmp->delete($con);
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
                $id_tb080_sector      =   $this->getRequestParameter("id_tb080_sector");
            $id_tb081_sub_sector      =   $this->getRequestParameter("id_tb081_sub_sector");
            $id_tb082_ejecutor      =   $this->getRequestParameter("id_tb082_ejecutor");
            $nu_proyecto_ac      =   $this->getRequestParameter("nu_proyecto_ac");
            $de_proyecto_ac      =   $this->getRequestParameter("de_proyecto_ac");
            $id_tb013_anio_fiscal      =   $this->getRequestParameter("id_tb013_anio_fiscal");
            $id_tb086_tipo_prac      =   $this->getRequestParameter("id_tb086_tipo_prac");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $in_cargado      =   $this->getRequestParameter("in_cargado");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($id_tb080_sector!=""){$c->add(Tb165PacTmpPeer::id_tb080_sector,$id_tb080_sector);}
    
                                            if($id_tb081_sub_sector!=""){$c->add(Tb165PacTmpPeer::id_tb081_sub_sector,$id_tb081_sub_sector);}
    
                                            if($id_tb082_ejecutor!=""){$c->add(Tb165PacTmpPeer::ID_TB082_EJECUTOR,$id_tb082_ejecutor);}
    
                                        if($nu_proyecto_ac!=""){$c->add(Tb165PacTmpPeer::nu_proyecto_ac,'%'.$nu_proyecto_ac.'%',Criteria::LIKE);}
        
                                        if($de_proyecto_ac!=""){$c->add(Tb165PacTmpPeer::de_proyecto_ac,'%'.$de_proyecto_ac.'%',Criteria::LIKE);}
        
                                            if($id_tb013_anio_fiscal!=""){$c->add(Tb165PacTmpPeer::id_tb013_anio_fiscal,$id_tb013_anio_fiscal);}
    
                                            if($id_tb086_tipo_prac!=""){$c->add(Tb165PacTmpPeer::id_tb086_tipo_prac,$id_tb086_tipo_prac);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb165PacTmpPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb165PacTmpPeer::updated_at,$fecha);
    }
                                    
                    }
    $c->setIgnoreCase(true);


        $c->clearSelectColumns();
        $c->addSelectColumn(Tb165PacTmpPeer::ID);
        $c->addAsColumn('mo_cargado', 'sp_tb165_pac_tmp_mo_cargado(tb165_pac_tmp.id)');
        $c->addSelectColumn(Tb165PacTmpPeer::NU_PROYECTO_AC);
        $c->addSelectColumn(Tb165PacTmpPeer::DE_PROYECTO_AC);
        $c->addSelectColumn(Tb165PacTmpPeer::ID_TB013_ANIO_FISCAL);
        $c->addSelectColumn(Tb086TipoPracPeer::DE_TIPO_PRAC);
        $c->addSelectColumn(Tb082EjecutorPeer::NU_EJECUTOR);
        $c->addSelectColumn(Tb082EjecutorPeer::DE_EJECUTOR);
        $c->addSelectColumn(Tb165PacTmpPeer::MO_PRESUPUESTO);
        $c->addSelectColumn(Tb165PacTmpPeer::IN_CARGADO);
        $c->addJoin(Tb165PacTmpPeer::ID_TB086_TIPO_PRAC, Tb086TipoPracPeer::ID);
        $c->addJoin(Tb165PacTmpPeer::ID_TB082_EJECUTOR, Tb082EjecutorPeer::ID);
        $c->add(Tb165PacTmpPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));

        $cantidadTotal = Tb165PacTmpPeer::doCount($c);
    
        $c->setLimit($limit)->setOffset($start);
            $c->addAscendingOrderByColumn(Tb165PacTmpPeer::ID);
        
    $stmt = Tb165PacTmpPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "id_tb080_sector"     => trim($res["id_tb080_sector"]),
            "id_tb081_sub_sector"     => trim($res["id_tb081_sub_sector"]),
            "nu_ejecutor"     => trim($res["nu_ejecutor"]),
            "de_ejecutor"     => trim($res["de_ejecutor"]),
            "nu_proyecto_ac"     => trim($res["nu_proyecto_ac"]),
            "de_proyecto_ac"     => trim($res["de_proyecto_ac"]),
            "id_tb013_anio_fiscal"     => trim($res["id_tb013_anio_fiscal"]),
            "id_tb086_tipo_prac"     => trim($res["de_tipo_prac"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "in_cargado"     => trim($res["in_cargado"]),
            "mo_presupuesto"     => trim($res["mo_presupuesto"]),
            "mo_cargado"     => trim($res["mo_cargado"]),
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

        $id_tb080_sector      =   $this->getRequestParameter("sector");

        $c = new Criteria();
        $c->add(Tb081SubSectorPeer::ID_TB080_SECTOR,$id_tb080_sector);
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
        $c->addAscendingOrderByColumn(Tb082EjecutorPeer::NU_EJECUTOR);
        $c->add(Tb082EjecutorPeer::IN_ACTIVO, TRUE);
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
    public function executeEjecutar(sfWebRequest $request){

        try{

            $con_gobel = Propel::getConnection("propel");

            $codigo = $this->getRequestParameter("id");

            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb165PacTmpPeer::ID);
            $c->addAsColumn('mo_cargado', 'sp_tb165_pac_tmp_mo_cargado(tb165_pac_tmp.id)');
            $c->addSelectColumn(Tb165PacTmpPeer::ID_TB080_SECTOR);
            $c->addSelectColumn(Tb165PacTmpPeer::ID_TB081_SUB_SECTOR);
            $c->addSelectColumn(Tb165PacTmpPeer::ID_TB082_EJECUTOR);
            $c->addSelectColumn(Tb165PacTmpPeer::NU_PROYECTO_AC);
            $c->addSelectColumn(Tb165PacTmpPeer::DE_PROYECTO_AC);
            $c->addSelectColumn(Tb165PacTmpPeer::ID_TB013_ANIO_FISCAL);
            $c->addSelectColumn(Tb086TipoPracPeer::DE_TIPO_PRAC);
            $c->addSelectColumn(Tb082EjecutorPeer::NU_EJECUTOR);
            $c->addSelectColumn(Tb082EjecutorPeer::DE_EJECUTOR);
            $c->addSelectColumn(Tb165PacTmpPeer::MO_PRESUPUESTO);
            $c->addSelectColumn(Tb165PacTmpPeer::ID_TB086_TIPO_PRAC);
            $c->addSelectColumn(Tb080SectorPeer::NU_SECTOR);
            $c->addSelectColumn(Tb165PacTmpPeer::IN_CARGADO);
            $c->addJoin(Tb165PacTmpPeer::ID_TB086_TIPO_PRAC, Tb086TipoPracPeer::ID);
            $c->addJoin(Tb165PacTmpPeer::ID_TB082_EJECUTOR, Tb082EjecutorPeer::ID);
            $c->addJoin(Tb165PacTmpPeer::ID_TB080_SECTOR, Tb080SectorPeer::ID);
            $c->add(Tb165PacTmpPeer::ID, $codigo);
            $stmt = Tb165PacTmpPeer::doSelectStmt($c);

            $campos_destino = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($campos_destino["in_cargado"] == true ) {
   
                $this->data = json_encode(array(
                  'success' => false,
                  'msg' => '<span style="color:green;font-size:13px,"><b>El Proy / AC ya Fue procesado!</b></span>'
                ));
   
                return $this->setTemplate('store');
            }

            if ($campos_destino["mo_presupuesto"] != $campos_destino["mo_cargado"] ) {
  
                $resta_traslado = $campos_destino["mo_presupuesto"] - $campos_destino["mo_cargado"];
   
                $this->data = json_encode(array(
                  'success' => false,
                  'msg' => '<span style="color:red;font-size:13px,"><b>El monto total de las partidas en el Pory/AC deben ser igual a las partidas de las AE!<br></b></span>Diferencia: <b>'.$resta_traslado.'</b>'
                ));
   
                return $this->setTemplate('store');
            }

            $stmt = Tb165PacTmpPeer::doSelectStmt($c);

            while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
      
                $fecha = date("Y-m-d H:i:s");
      
                $tb083_proyecto_ac = new Tb083ProyectoAc();
                $tb083_proyecto_ac->setIdTb080Sector($reg["id_tb080_sector"]);
                $tb083_proyecto_ac->setIdTb081SubSector($reg["id_tb081_sub_sector"]);
                $tb083_proyecto_ac->setIdTb082Ejecutor($reg["id_tb082_ejecutor"]);
                $tb083_proyecto_ac->setNuProyectoAc($reg['nu_proyecto_ac']);
                $tb083_proyecto_ac->setDeProyectoAc($reg['de_proyecto_ac']);
                $tb083_proyecto_ac->setIdTb013AnioFiscal($reg['id_tb013_anio_fiscal']);
                $tb083_proyecto_ac->setIdTb086TipoPrac($reg['id_tb086_tipo_prac']);
                $tb083_proyecto_ac->setInActivo(TRUE);
                $tb083_proyecto_ac->setCreatedAt($fecha);
                $tb083_proyecto_ac->setUpdatedAt($fecha);
                $tb083_proyecto_ac->save($con_gobel);

                $c_ae = new Criteria();
                $c_ae->clearSelectColumns();
                $c_ae->addSelectColumn(Tb166PacAeTmpPeer::ID);
                $c_ae->addSelectColumn(Tb166PacAeTmpPeer::ID_TB165_PAC_TMP);
                $c_ae->addSelectColumn(Tb166PacAeTmpPeer::NU_ACCION_ESPECIFICA);
                $c_ae->addSelectColumn(Tb166PacAeTmpPeer::DE_ACCION_ESPECIFICA);
                $c_ae->addAsColumn('mo_cargado', 'sp_tb166_pac_ae_tmp_mo_cargado(tb166_pac_ae_tmp.id)');
                $c_ae->add(Tb166PacAeTmpPeer::ID_TB165_PAC_TMP, $reg["id"]);
                $stmt_ae = Tb166PacAeTmpPeer::doSelectStmt($c_ae);

                while($reg_ae = $stmt_ae->fetch(PDO::FETCH_ASSOC)){

                    $tb084_accion_especifica = new Tb084AccionEspecifica();
                    $tb084_accion_especifica->setIdTb083ProyectoAc($tb083_proyecto_ac->getId());
                    $tb084_accion_especifica->setNuAccionEspecifica($reg_ae['nu_accion_especifica']);
                    $tb084_accion_especifica->setDeAccionEspecifica($reg_ae['de_accion_especifica']);
                    $tb084_accion_especifica->setInActivo(TRUE);
                    $tb084_accion_especifica->setCreatedAt($fecha);
                    $tb084_accion_especifica->setUpdatedAt($fecha);
                    $tb084_accion_especifica->save($con_gobel);

                    $c_partida = new Criteria();
                    $c_partida->clearSelectColumns();
                    $c_partida->addSelectColumn(Tb167PacAePartidaTmpPeer::ID);
                    $c_partida->addSelectColumn(Tb167PacAePartidaTmpPeer::ID_TB166_PAC_AE_TMP);
                    $c_partida->addSelectColumn(Tb167PacAePartidaTmpPeer::NU_PA);
                    $c_partida->addSelectColumn(Tb167PacAePartidaTmpPeer::NU_GE);
                    $c_partida->addSelectColumn(Tb167PacAePartidaTmpPeer::NU_ES);
                    $c_partida->addSelectColumn(Tb167PacAePartidaTmpPeer::NU_SE);
                    $c_partida->addSelectColumn(Tb167PacAePartidaTmpPeer::NU_SSE);
                    $c_partida->addSelectColumn(Tb167PacAePartidaTmpPeer::DE_PARTIDA);
                    $c_partida->addSelectColumn(Tb167PacAePartidaTmpPeer::MO_PARTIDA);
                    $c_partida->addSelectColumn(Tb167PacAePartidaTmpPeer::ID_TB139_APLICACION);
                    $c_partida->addSelectColumn(Tb139AplicacionPeer::TX_TIP_APLICACION);
                    $c_partida->addSelectColumn(Tb139AplicacionPeer::TX_APLICACION);
                    $c_partida->addSelectColumn(Tb140TipoIngresoPeer::TX_TIP_INGRESO);
                    $c_partida->addSelectColumn(Tb167PacAePartidaTmpPeer::ID_TB138_AMBITO);
                    $c_partida->addSelectColumn(Tb167PacAePartidaTmpPeer::CO_CLASIFICACION_ECONOMICA);
                    $c_partida->addSelectColumn(Tb167PacAePartidaTmpPeer::CO_AREA_ESTRATEGICA);
                    $c_partida->addSelectColumn(Tb167PacAePartidaTmpPeer::CO_TIPO_GASTO);
                    $c_partida->addSelectColumn(Tb183TipoGastoPeer::TX_SIGLAS);
                    $c_partida->addJoin(Tb167PacAePartidaTmpPeer::ID_TB139_APLICACION, Tb139AplicacionPeer::CO_APLICACION);
                    $c_partida->addJoin(Tb167PacAePartidaTmpPeer::ID_TB140_TIPO_INGRESO, Tb140TipoIngresoPeer::CO_TIPO_INGRESO);
                    $c_partida->addJoin(Tb167PacAePartidaTmpPeer::CO_TIPO_GASTO, Tb183TipoGastoPeer::CO_TIPO_GASTO);
                    $c_partida->add(Tb167PacAePartidaTmpPeer::ID_TB166_PAC_AE_TMP, $reg_ae['id']);
                    $stmt_partida = Tb167PacAePartidaTmpPeer::doSelectStmt($c_partida);

                    while($reg_partida = $stmt_partida->fetch(PDO::FETCH_ASSOC)){

                        $partida = $reg_partida['nu_pa'].$reg_partida['nu_ge'].$reg_partida['nu_es'].$reg_partida['nu_se'].$reg_partida['nu_sse'];

                        $tb085_presupuesto = new Tb085Presupuesto();
                        $tb085_presupuesto->setIdTb084AccionEspecifica($tb084_accion_especifica->getId());
                        $tb085_presupuesto->setNuPartida(trim($partida.'L0000'));
                        $tb085_presupuesto->setDePartida($reg_partida['de_partida']);
                        $tb085_presupuesto->setMoInicial($reg_partida['mo_partida']);
                        $tb085_presupuesto->setMoActualizado($reg_partida['mo_partida']);
                        $tb085_presupuesto->setMoPrecomprometido(0);
                        $tb085_presupuesto->setMoComprometido(0);
                        $tb085_presupuesto->setMoCausado(0);
                        $tb085_presupuesto->setMoPagado(0);
                        $tb085_presupuesto->setMoDisponible($reg_partida['mo_partida']);
                        $tb085_presupuesto->setInActivo(TRUE);
                        $tb085_presupuesto->setInMovimiento(TRUE);
                        $tb085_presupuesto->setInGenCheque(TRUE);
                        $tb085_presupuesto->setCreatedAt($fecha);
                        $tb085_presupuesto->setUpdatedAt($fecha);
                        $tb085_presupuesto->setNuPa($reg_partida['nu_pa']);
                        $tb085_presupuesto->setNuGe($reg_partida['nu_ge']);
                        $tb085_presupuesto->setNuEs($reg_partida['nu_es']);
                        $tb085_presupuesto->setNuSe($reg_partida['nu_se']);
                        $tb085_presupuesto->setNuSse($reg_partida['nu_sse']);
                        $tb085_presupuesto->setCoPartida($partida);
                        $tb085_presupuesto->setNuNivel(11);
                        $tb085_presupuesto->setCoCategoria(Tb167PacAePartidaTmpPeer::getCategoria($reg_partida["id"]));
                        $tb085_presupuesto->setCoEnte($reg["id_tb082_ejecutor"]);
                        $tb085_presupuesto->setCodEnte($reg["nu_ejecutor"]);
                        $tb085_presupuesto->setNuAnio($reg['id_tb013_anio_fiscal']);
                        $tb085_presupuesto->setNuSector($reg['nu_sector']);
                        $tb085_presupuesto->setNuFi('L0000');
                        $tb085_presupuesto->setNuAplicacion($reg_partida['tx_tip_aplicacion']);
                        $tb085_presupuesto->setTpIngreso($reg_partida['tx_tip_ingreso']);
                        $tb085_presupuesto->setTipApl($reg_partida['tx_tip_aplicacion']);
                        $tb085_presupuesto->setCodAmb($reg_partida['id_tb138_ambito']);
                        $tb085_presupuesto->setIdTb139Aplicacion($reg_partida['id_tb139_aplicacion']);
                        $tb085_presupuesto->setCoClasificacionEconomica($reg_partida['co_clasificacion_economica']);
                        $tb085_presupuesto->setCoAreaEstrategica($reg_partida['co_area_estrategica']);
                        $tb085_presupuesto->setTipGasto($reg_partida['tx_siglas']);
                        $tb085_presupuesto->save($con_gobel);
          
                    }

                }

            }

            $tb165_pac_tmp = Tb165PacTmpPeer::retrieveByPk($codigo);
            $tb165_pac_tmp->setInCargado(true);
            $tb165_pac_tmp->save($con_gobel);

            $con_gobel->commit();

            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Presupuesto exportado exitosamente!'
            ));
    
            $this->setTemplate('store');
    
        }catch (PropelException $e)
        {

            $con_gobel->rollback();

            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
    
            $this->setTemplate('store');

        }

    }

}