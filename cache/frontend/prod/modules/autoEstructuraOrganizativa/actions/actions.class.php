<?php

/**
 * autoEstructuraOrganizativa actions.
 * NombreClaseModel(Tbrh005EstructuraAdministrativa)
 * NombreTabla(tbrh005_estructura_administrativa)
 * @package    ##PROJECT_NAME##
 * @subpackage autoEstructuraOrganizativa
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoEstructuraOrganizativaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('EstructuraOrganizativa', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('EstructuraOrganizativa', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh005EstructuraAdministrativaPeer::CO_ESTRUCTURA_ADMINISTRATIVA,$codigo);
        
        $stmt = Tbrh005EstructuraAdministrativaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_estructura_administrativa"     => $campos["co_estructura_administrativa"],
                            "co_padre"     => $campos["co_padre"],
                            "tx_nom_estructura_administrativa"     => $campos["tx_nom_estructura_administrativa"],
                            "nu_centro_costo"     => $campos["nu_centro_costo"],
                            "co_ente"     => $campos["co_ente"],
                            "co_nivel_jerarquico"     => $campos["co_nivel_jerarquico"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "co_dependencia"     => $campos["co_dependencia"],
                            "co_enteorgano"     => $campos["co_enteorgano"],
                            "nu_codigo"     => $campos["nu_codigo"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_estructura_administrativa"     => "",
                            "co_padre"     => "",
                            "tx_nom_estructura_administrativa"     => "",
                            "nu_centro_costo"     => "",
                            "co_ente"     => "",
                            "co_nivel_jerarquico"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "co_dependencia"     => "",
                            "co_enteorgano"     => "",
                            "nu_codigo"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_estructura_administrativa");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh005_estructura_administrativa = Tbrh005EstructuraAdministrativaPeer::retrieveByPk($codigo);
     }else{
         $tbrh005_estructura_administrativa = new Tbrh005EstructuraAdministrativa();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh005_estructura_administrativaForm = $this->getRequestParameter('tbrh005_estructura_administrativa');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tbrh005_estructura_administrativa->setCoPadre($tbrh005_estructura_administrativaForm["co_padre"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh005_estructura_administrativa->setTxNomEstructuraAdministrativa($tbrh005_estructura_administrativaForm["tx_nom_estructura_administrativa"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh005_estructura_administrativa->setNuCentroCosto($tbrh005_estructura_administrativaForm["nu_centro_costo"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh005_estructura_administrativa->setCoEnte($tbrh005_estructura_administrativaForm["co_ente"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh005_estructura_administrativa->setCoNivelJerarquico($tbrh005_estructura_administrativaForm["co_nivel_jerarquico"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tbrh005_estructura_administrativaForm)){
            $tbrh005_estructura_administrativa->setInActivo(false);
        }else{
            $tbrh005_estructura_administrativa->setInActivo(true);
        }
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tbrh005_estructura_administrativaForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh005_estructura_administrativa->setCreatedAt($fecha);
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tbrh005_estructura_administrativaForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh005_estructura_administrativa->setUpdatedAt($fecha);
                                                        
        /*Campo tipo BIGINT */
        $tbrh005_estructura_administrativa->setCoDependencia($tbrh005_estructura_administrativaForm["co_dependencia"]);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh005_estructura_administrativa->setCoEnteorgano($tbrh005_estructura_administrativaForm["co_enteorgano"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh005_estructura_administrativa->setNuCodigo($tbrh005_estructura_administrativaForm["nu_codigo"]);
                                
        /*CAMPOS*/
        $tbrh005_estructura_administrativa->save($con);
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
	$codigo = $this->getRequestParameter("co_estructura_administrativa");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh005_estructura_administrativa = Tbrh005EstructuraAdministrativaPeer::retrieveByPk($codigo);			
	$tbrh005_estructura_administrativa->delete($con);
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
                $co_padre      =   $this->getRequestParameter("co_padre");
            $tx_nom_estructura_administrativa      =   $this->getRequestParameter("tx_nom_estructura_administrativa");
            $nu_centro_costo      =   $this->getRequestParameter("nu_centro_costo");
            $co_ente      =   $this->getRequestParameter("co_ente");
            $co_nivel_jerarquico      =   $this->getRequestParameter("co_nivel_jerarquico");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $co_dependencia      =   $this->getRequestParameter("co_dependencia");
            $co_enteorgano      =   $this->getRequestParameter("co_enteorgano");
            $nu_codigo      =   $this->getRequestParameter("nu_codigo");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_padre!=""){$c->add(Tbrh005EstructuraAdministrativaPeer::co_padre,$co_padre);}
    
                                        if($tx_nom_estructura_administrativa!=""){$c->add(Tbrh005EstructuraAdministrativaPeer::tx_nom_estructura_administrativa,'%'.$tx_nom_estructura_administrativa.'%',Criteria::LIKE);}
        
                                        if($nu_centro_costo!=""){$c->add(Tbrh005EstructuraAdministrativaPeer::nu_centro_costo,'%'.$nu_centro_costo.'%',Criteria::LIKE);}
        
                                            if($co_ente!=""){$c->add(Tbrh005EstructuraAdministrativaPeer::co_ente,$co_ente);}
    
                                            if($co_nivel_jerarquico!=""){$c->add(Tbrh005EstructuraAdministrativaPeer::co_nivel_jerarquico,$co_nivel_jerarquico);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh005EstructuraAdministrativaPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh005EstructuraAdministrativaPeer::updated_at,$fecha);
    }
                                            if($co_dependencia!=""){$c->add(Tbrh005EstructuraAdministrativaPeer::co_dependencia,$co_dependencia);}
    
                                            if($co_enteorgano!=""){$c->add(Tbrh005EstructuraAdministrativaPeer::co_enteorgano,$co_enteorgano);}
    
                                        if($nu_codigo!=""){$c->add(Tbrh005EstructuraAdministrativaPeer::nu_codigo,'%'.$nu_codigo.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh005EstructuraAdministrativaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh005EstructuraAdministrativaPeer::CO_ESTRUCTURA_ADMINISTRATIVA);
        
    $stmt = Tbrh005EstructuraAdministrativaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_estructura_administrativa"     => trim($res["co_estructura_administrativa"]),
            "co_padre"     => trim($res["co_padre"]),
            "tx_nom_estructura_administrativa"     => trim($res["tx_nom_estructura_administrativa"]),
            "nu_centro_costo"     => trim($res["nu_centro_costo"]),
            "co_ente"     => trim($res["co_ente"]),
            "co_nivel_jerarquico"     => trim($res["co_nivel_jerarquico"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "co_dependencia"     => trim($res["co_dependencia"]),
            "co_enteorgano"     => trim($res["co_enteorgano"]),
            "nu_codigo"     => trim($res["nu_codigo"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                                                                                            


}