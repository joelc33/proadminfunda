<?php

/**
 * autoAsignacionpresupuesto actions.
 * NombreClaseModel(Tb083ProyectoAc)
 * NombreTabla(tb083_proyecto_ac)
 * @package    ##PROJECT_NAME##
 * @subpackage autoAsignacionpresupuesto
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoAsignacionpresupuestoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Asignacionpresupuesto', 'lista');
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
                            "id_tb086_tipo_prac"     => $campos["id_tb086_tipo_prac"],
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
                            "id_tb086_tipo_prac"     => "",
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
                                                        
        /*Campo tipo BIGINT */
        $tb083_proyecto_ac->setIdTb086TipoPrac($tb083_proyecto_acForm["id_tb086_tipo_prac"]);
                                
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
                                    if($id_tb080_sector!=""){$c->add(Tb083ProyectoAcPeer::id_tb080_sector,$id_tb080_sector);}
    
                                            if($id_tb081_sub_sector!=""){$c->add(Tb083ProyectoAcPeer::id_tb081_sub_sector,$id_tb081_sub_sector);}
    
                                            if($id_tb082_ejecutor!=""){$c->add(Tb083ProyectoAcPeer::id_tb082_ejecutor,$id_tb082_ejecutor);}
    
                                        if($nu_proyecto_ac!=""){$c->add(Tb083ProyectoAcPeer::nu_proyecto_ac,'%'.$nu_proyecto_ac.'%',Criteria::LIKE);}
        
                                        if($de_proyecto_ac!=""){$c->add(Tb083ProyectoAcPeer::de_proyecto_ac,'%'.$de_proyecto_ac.'%',Criteria::LIKE);}
        
                                            if($id_tb013_anio_fiscal!=""){$c->add(Tb083ProyectoAcPeer::id_tb013_anio_fiscal,$id_tb013_anio_fiscal);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb083ProyectoAcPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb083ProyectoAcPeer::updated_at,$fecha);
    }
                                            if($id_tb086_tipo_prac!=""){$c->add(Tb083ProyectoAcPeer::id_tb086_tipo_prac,$id_tb086_tipo_prac);}
    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb083ProyectoAcPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb083ProyectoAcPeer::ID);
        
    $stmt = Tb083ProyectoAcPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "id_tb080_sector"     => trim($res["id_tb080_sector"]),
            "id_tb081_sub_sector"     => trim($res["id_tb081_sub_sector"]),
            "id_tb082_ejecutor"     => trim($res["id_tb082_ejecutor"]),
            "nu_proyecto_ac"     => trim($res["nu_proyecto_ac"]),
            "de_proyecto_ac"     => trim($res["de_proyecto_ac"]),
            "id_tb013_anio_fiscal"     => trim($res["id_tb013_anio_fiscal"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "id_tb086_tipo_prac"     => trim($res["id_tb086_tipo_prac"]),
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
        


}