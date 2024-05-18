<?php

/**
 * ConfigPetro actions.
 *
 * @package    gobel
 * @subpackage ConfigPetro
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConfigPetroActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConfigPetro', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConfigPetro', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh097PetroPeer::ID,$codigo);
        
        $stmt = Tbrh097PetroPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "mo_petro"     => $campos["mo_petro"],
                            "fe_ini"     => $campos["fe_ini"],
                            "fe_fin"     => $campos["fe_fin"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "mo_petro"     => "",
                            "fe_ini"     => "",
                            "fe_fin"     => "",
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
         $tbrh097_petro = Tbrh097PetroPeer::retrieveByPk($codigo);
     }else{
         $tbrh097_petro = new Tbrh097Petro();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh097_petroForm = $this->getRequestParameter('tbrh097_petro');
/*CAMPOS*/
                                        
        /*Campo tipo NUMERIC */
        $tbrh097_petro->setMoPetro($tbrh097_petroForm["mo_petro"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tbrh097_petroForm["fe_ini"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh097_petro->setFeIni($fecha);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tbrh097_petroForm["fe_fin"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh097_petro->setFeFin($fecha);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tbrh097_petroForm)){
            $tbrh097_petro->setInActivo(false);
        }else{
            $tbrh097_petro->setInActivo(true);
        }
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tbrh097_petroForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh097_petro->setCreatedAt($fecha);
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tbrh097_petroForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh097_petro->setUpdatedAt($fecha);
                                
        /*CAMPOS*/
        $tbrh097_petro->save($con);
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
	$tbrh097_petro = Tbrh097PetroPeer::retrieveByPk($codigo);			
	$tbrh097_petro->delete($con);
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
                $mo_petro      =   $this->getRequestParameter("mo_petro");
            $fe_ini      =   $this->getRequestParameter("fe_ini");
            $fe_fin      =   $this->getRequestParameter("fe_fin");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($mo_petro!=""){$c->add(Tbrh097PetroPeer::mo_petro,$mo_petro);}
    
                                    
        if($fe_ini!=""){
    list($dia, $mes,$anio) = explode("/",$fe_ini);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh097PetroPeer::fe_ini,$fecha);
    }
                                    
        if($fe_fin!=""){
    list($dia, $mes,$anio) = explode("/",$fe_fin);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh097PetroPeer::fe_fin,$fecha);
    }
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh097PetroPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh097PetroPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh097PetroPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh097PetroPeer::ID);
        
    $stmt = Tbrh097PetroPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "mo_petro"     => trim($res["mo_petro"]),
            "fe_ini"     => trim($res["fe_ini"]),
            "fe_fin"     => trim($res["fe_fin"]),
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

                                                                                


}