<?php

/**
 * PresupuestoEjercicioAePartida actions.
 *
 * @package    gobel
 * @subpackage PresupuestoEjercicioAePartida
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class PresupuestoEjercicioAePartidaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('PresupuestoEjercicioAePartida', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('PresupuestoEjercicioAePartida', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb167PacAePartidaTmpPeer::ID,$codigo);
        
        $stmt = Tb167PacAePartidaTmpPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb166_pac_ae_tmp"     => $campos["id_tb166_pac_ae_tmp"],
                            "nu_pa"     => $campos["nu_pa"],
                            "nu_ge"     => $campos["nu_ge"],
                            "nu_es"     => $campos["nu_es"],
                            "nu_se"     => $campos["nu_se"],
                            "nu_sse"     => $campos["nu_sse"],
                            "de_partida"     => $campos["de_partida"],
                            "in_movimiento"     => $campos["in_movimiento"],
                            "in_activo"     => $campos["in_activo"],
                            "mo_partida"     => $campos["mo_partida"],
                            "id_tb139_aplicacion"     => $campos["id_tb139_aplicacion"],
                            "id_tb091_partida"     => $campos["id_tb091_partida"],
                            "id_tb140_tipo_ingreso"     => $campos["id_tb140_tipo_ingreso"],
                            "id_tb138_ambito"     => $campos["id_tb138_ambito"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb166_pac_ae_tmp"     => $this->getRequestParameter("id_tb166_pac_ae_tmp"),
                            "nu_pa"     => "",
                            "nu_ge"     => "",
                            "nu_es"     => "",
                            "nu_se"     => "",
                            "nu_sse"     => "",
                            "de_partida"     => "",
                            "in_movimiento"     => "",
                            "in_activo"     => "",
                            "mo_partida"     => "",
                            "id_tb139_aplicacion"     => "",
                            "id_tb091_partida"     => "",
                            "id_tb140_tipo_ingreso"     => "",
                            "id_tb138_ambito"     => "",
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
         $tb167_pac_ae_partida_tmp = Tb167PacAePartidaTmpPeer::retrieveByPk($codigo);
     }else{
         $tb167_pac_ae_partida_tmp = new Tb167PacAePartidaTmp();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb167_pac_ae_partida_tmpForm = $this->getRequestParameter('tb167_pac_ae_partida_tmp');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb167_pac_ae_partida_tmp->setIdTb166PacAeTmp($tb167_pac_ae_partida_tmpForm["id_tb166_pac_ae_tmp"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb167_pac_ae_partida_tmp->setNuPa($tb167_pac_ae_partida_tmpForm["nu_pa"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb167_pac_ae_partida_tmp->setNuGe($tb167_pac_ae_partida_tmpForm["nu_ge"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb167_pac_ae_partida_tmp->setNuEs($tb167_pac_ae_partida_tmpForm["nu_es"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb167_pac_ae_partida_tmp->setNuSe($tb167_pac_ae_partida_tmpForm["nu_se"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb167_pac_ae_partida_tmp->setNuSse($tb167_pac_ae_partida_tmpForm["nu_sse"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb167_pac_ae_partida_tmp->setDePartida($tb167_pac_ae_partida_tmpForm["de_partida"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_movimiento", $tb167_pac_ae_partida_tmpForm)){
            $tb167_pac_ae_partida_tmp->setInMovimiento(false);
        }else{
            $tb167_pac_ae_partida_tmp->setInMovimiento(true);
        }
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tb167_pac_ae_partida_tmpForm)){
            $tb167_pac_ae_partida_tmp->setInActivo(false);
        }else{
            $tb167_pac_ae_partida_tmp->setInActivo(true);
        }*/
                                                        
        /*Campo tipo NUMERIC */
        $tb167_pac_ae_partida_tmp->setMoPartida($tb167_pac_ae_partida_tmpForm["mo_partida"]);
                                                        
        /*Campo tipo BIGINT */
        $tb167_pac_ae_partida_tmp->setIdTb139Aplicacion($tb167_pac_ae_partida_tmpForm["id_tb139_aplicacion"]);
                                                        
        /*Campo tipo BIGINT */
        $tb167_pac_ae_partida_tmp->setIdTb091Partida($tb167_pac_ae_partida_tmpForm["id_tb091_partida"]);
                                                        
        /*Campo tipo BIGINT */
        $tb167_pac_ae_partida_tmp->setIdTb140TipoIngreso($tb167_pac_ae_partida_tmpForm["id_tb140_tipo_ingreso"]);
                                                        
        /*Campo tipo BIGINT */
        $tb167_pac_ae_partida_tmp->setIdTb138Ambito($tb167_pac_ae_partida_tmpForm["id_tb138_ambito"]);
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tb167_pac_ae_partida_tmpForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb167_pac_ae_partida_tmp->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tb167_pac_ae_partida_tmpForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb167_pac_ae_partida_tmp->setUpdatedAt($fecha);*/
                                
        /*CAMPOS*/
        $tb167_pac_ae_partida_tmp->save($con);
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
	$tb167_pac_ae_partida_tmp = Tb167PacAePartidaTmpPeer::retrieveByPk($codigo);			
	$tb167_pac_ae_partida_tmp->delete($con);
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
        "id"     => "",
        "id_tb166_pac_ae_tmp" => $this->getRequestParameter("codigo"),
        "nu_pa"     => "",
        "nu_ge"     => "",
        "nu_es"     => "",
        "nu_se"     => "",
        "nu_sse"     => "",
        "de_partida"     => "",
        "in_movimiento"     => "",
        "in_activo"     => "",
        "mo_partida"     => "",
        "id_tb139_aplicacion"     => "",
        "id_tb091_partida"     => "",
        "id_tb140_tipo_ingreso"     => "",
        "id_tb138_ambito"     => "",
        "created_at"     => "",
        "updated_at"     => "",
    ));
  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $id_tb166_pac_ae_tmp      =   $this->getRequestParameter("id_tb166_pac_ae_tmp");
            $nu_pa      =   $this->getRequestParameter("nu_pa");
            $nu_ge      =   $this->getRequestParameter("nu_ge");
            $nu_es      =   $this->getRequestParameter("nu_es");
            $nu_se      =   $this->getRequestParameter("nu_se");
            $nu_sse      =   $this->getRequestParameter("nu_sse");
            $de_partida      =   $this->getRequestParameter("de_partida");
            $in_movimiento      =   $this->getRequestParameter("in_movimiento");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $mo_partida      =   $this->getRequestParameter("mo_partida");
            $id_tb139_aplicacion      =   $this->getRequestParameter("id_tb139_aplicacion");
            $id_tb091_partida      =   $this->getRequestParameter("id_tb091_partida");
            $id_tb140_tipo_ingreso      =   $this->getRequestParameter("id_tb140_tipo_ingreso");
            $id_tb138_ambito      =   $this->getRequestParameter("id_tb138_ambito");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($id_tb166_pac_ae_tmp!=""){$c->add(Tb167PacAePartidaTmpPeer::id_tb166_pac_ae_tmp,$id_tb166_pac_ae_tmp);}
    
                                        if($nu_pa!=""){$c->add(Tb167PacAePartidaTmpPeer::nu_pa,'%'.$nu_pa.'%',Criteria::LIKE);}
        
                                        if($nu_ge!=""){$c->add(Tb167PacAePartidaTmpPeer::nu_ge,'%'.$nu_ge.'%',Criteria::LIKE);}
        
                                        if($nu_es!=""){$c->add(Tb167PacAePartidaTmpPeer::nu_es,'%'.$nu_es.'%',Criteria::LIKE);}
        
                                        if($nu_se!=""){$c->add(Tb167PacAePartidaTmpPeer::nu_se,'%'.$nu_se.'%',Criteria::LIKE);}
        
                                        if($nu_sse!=""){$c->add(Tb167PacAePartidaTmpPeer::nu_sse,'%'.$nu_sse.'%',Criteria::LIKE);}
        
                                        if($de_partida!=""){$c->add(Tb167PacAePartidaTmpPeer::de_partida,'%'.$de_partida.'%',Criteria::LIKE);}
        
                                    
                                    
                                            if($mo_partida!=""){$c->add(Tb167PacAePartidaTmpPeer::mo_partida,$mo_partida);}
    
                                            if($id_tb139_aplicacion!=""){$c->add(Tb167PacAePartidaTmpPeer::id_tb139_aplicacion,$id_tb139_aplicacion);}
    
                                            if($id_tb091_partida!=""){$c->add(Tb167PacAePartidaTmpPeer::id_tb091_partida,$id_tb091_partida);}
    
                                            if($id_tb140_tipo_ingreso!=""){$c->add(Tb167PacAePartidaTmpPeer::id_tb140_tipo_ingreso,$id_tb140_tipo_ingreso);}
    
                                            if($id_tb138_ambito!=""){$c->add(Tb167PacAePartidaTmpPeer::id_tb138_ambito,$id_tb138_ambito);}
    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb167PacAePartidaTmpPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb167PacAePartidaTmpPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $c->add(Tb167PacAePartidaTmpPeer::ID_TB166_PAC_AE_TMP,$id_tb166_pac_ae_tmp);
    $c->addJoin(Tb167PacAePartidaTmpPeer::ID_TB139_APLICACION, Tb139AplicacionPeer::CO_APLICACION);

    $cantidadTotal = Tb167PacAePartidaTmpPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb167PacAePartidaTmpPeer::ID);

        $c->clearSelectColumns();
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::ID);
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::ID_TB166_PAC_AE_TMP);
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::NU_PA);
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::NU_GE);
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::NU_ES);
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::NU_SE);
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::NU_SSE);
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::DE_PARTIDA);
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::MO_PARTIDA);
        $c->addSelectColumn(Tb139AplicacionPeer::TX_TIP_APLICACION);
        $c->addSelectColumn(Tb139AplicacionPeer::TX_APLICACION);
        $c->addJoin(Tb167PacAePartidaTmpPeer::ID_TB139_APLICACION, Tb139AplicacionPeer::CO_APLICACION);

        $c->add(Tb167PacAePartidaTmpPeer::ID_TB166_PAC_AE_TMP,$id_tb166_pac_ae_tmp);
        
    $stmt = Tb167PacAePartidaTmpPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "id_tb166_pac_ae_tmp"     => trim($res["id_tb166_pac_ae_tmp"]),
            "nu_pa"     => trim($res["nu_pa"]),
            "nu_ge"     => trim($res["nu_ge"]),
            "nu_es"     => trim($res["nu_es"]),
            "nu_se"     => trim($res["nu_se"]),
            "nu_sse"     => trim($res["nu_sse"]),
            "nu_partida"     => trim($res["nu_pa"].'.'.$res["nu_ge"].'.'.$res["nu_es"].'.'.$res["nu_se"].'.'.$res["nu_sse"]),
            "de_partida"     => trim($res["de_partida"]),
            "in_movimiento"     => trim($res["in_movimiento"]),
            "in_activo"     => trim($res["in_activo"]),
            "mo_partida"     => trim($res["mo_partida"]),
            "id_tb139_aplicacion"     => trim($res["tx_tip_aplicacion"].'-'.$res["tx_aplicacion"]),
            "id_tb091_partida"     => trim($res["id_tb091_partida"]),
            "id_tb140_tipo_ingreso"     => trim($res["id_tb140_tipo_ingreso"]),
            "id_tb138_ambito"     => trim($res["id_tb138_ambito"]),
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

                    //modelo fk tb166_pac_ae_tmp.ID
    public function executeStorefkidtb166pacaetmp(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb166PacAeTmpPeer::doSelectStmt($c);
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
                    //modelo fk tb091_partida.ID
    public function executeStorefkidtb091partida(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb091PartidaPeer::IN_MOVIMIENTO, TRUE);
        $c->add(Tb091PartidaPeer::ID_TIPO_PARTIDA, 2);
        $c->addAscendingOrderByColumn(Tb091PartidaPeer::NU_PARTIDA);
        $stmt = Tb091PartidaPeer::doSelectStmt($c);
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
                    //modelo fk tb140_tipo_ingreso.CO_TIPO_INGRESO
    public function executeStorefkidtb140tipoingreso(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb140TipoIngresoPeer::doSelectStmt($c);
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
                    //modelo fk tb138_ambito.CO_AMBITO
    public function executeStorefkidtb138ambito(sfWebRequest $request){
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb138AmbitoPeer::CO_AMBITO);
        $stmt = Tb138AmbitoPeer::doSelectStmt($c);
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