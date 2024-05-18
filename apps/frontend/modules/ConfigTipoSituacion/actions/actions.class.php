<?php

/**
 * ConfigTipoSituacion actions.
 *
 * @package    gobel
 * @subpackage ConfigTipoSituacion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConfigTipoSituacionActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConfigTipoSituacion', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConfigTipoSituacion', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh024NomSituacionPeer::CO_NOM_SITUACION,$codigo);
        
        $stmt = Tbrh024NomSituacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_nom_situacion"     => $campos["co_nom_situacion"],
                            "tx_nom_situacion"     => $campos["tx_nom_situacion"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_nom_situacion"     => "",
                            "tx_nom_situacion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_nom_situacion");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh024_nom_situacion = Tbrh024NomSituacionPeer::retrieveByPk($codigo);
     }else{
         $tbrh024_nom_situacion = new Tbrh024NomSituacion();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh024_nom_situacionForm = $this->getRequestParameter('tbrh024_nom_situacion');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tbrh024_nom_situacion->setTxNomSituacion($tbrh024_nom_situacionForm["tx_nom_situacion"]);
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tbrh024_nom_situacionForm)){
            $tbrh024_nom_situacion->setInActivo(false);
        }else{
            $tbrh024_nom_situacion->setInActivo(true);
        }*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh024_nom_situacionForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh024_nom_situacion->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh024_nom_situacionForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh024_nom_situacion->setUpdatedAt($fecha);*/
                                
        /*CAMPOS*/
        $tbrh024_nom_situacion->save($con);
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
	$codigo = $this->getRequestParameter("co_nom_situacion");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh024_nom_situacion = Tbrh024NomSituacionPeer::retrieveByPk($codigo);			
	$tbrh024_nom_situacion->delete($con);
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
                $tx_nom_situacion      =   $this->getRequestParameter("tx_nom_situacion");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_nom_situacion!=""){$c->add(Tbrh024NomSituacionPeer::tx_nom_situacion,'%'.$tx_nom_situacion.'%',Criteria::LIKE);}
        
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh024NomSituacionPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh024NomSituacionPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh024NomSituacionPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh024NomSituacionPeer::CO_NOM_SITUACION);
        
    $stmt = Tbrh024NomSituacionPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_nom_situacion"     => trim($res["co_nom_situacion"]),
            "tx_nom_situacion"     => trim($res["tx_nom_situacion"]),
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