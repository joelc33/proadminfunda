<?php

/**
 * ConfigTipoAcumulado actions.
 *
 * @package    gobel
 * @subpackage ConfigTipoAcumulado
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConfigTipoAcumuladoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConfigTipoAcumulado', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConfigTipoAcumulado', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh021NomAcumuladoPeer::CO_NOM_ACUMULADO,$codigo);
        
        $stmt = Tbrh021NomAcumuladoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_nom_acumulado"     => $campos["co_nom_acumulado"],
                            "tx_nom_acumulado"     => $campos["tx_nom_acumulado"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_nom_acumulado"     => "",
                            "tx_nom_acumulado"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_nom_acumulado");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh021_nom_acumulado = Tbrh021NomAcumuladoPeer::retrieveByPk($codigo);
     }else{
         $tbrh021_nom_acumulado = new Tbrh021NomAcumulado();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh021_nom_acumuladoForm = $this->getRequestParameter('tbrh021_nom_acumulado');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tbrh021_nom_acumulado->setTxNomAcumulado($tbrh021_nom_acumuladoForm["tx_nom_acumulado"]);
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tbrh021_nom_acumuladoForm)){
            $tbrh021_nom_acumulado->setInActivo(false);
        }else{
            $tbrh021_nom_acumulado->setInActivo(true);
        }*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh021_nom_acumuladoForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh021_nom_acumulado->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh021_nom_acumuladoForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh021_nom_acumulado->setUpdatedAt($fecha);*/
                                
        /*CAMPOS*/
        $tbrh021_nom_acumulado->save($con);
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
	$codigo = $this->getRequestParameter("co_nom_acumulado");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh021_nom_acumulado = Tbrh021NomAcumuladoPeer::retrieveByPk($codigo);			
	$tbrh021_nom_acumulado->delete($con);
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
                $tx_nom_acumulado      =   $this->getRequestParameter("tx_nom_acumulado");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_nom_acumulado!=""){$c->add(Tbrh021NomAcumuladoPeer::tx_nom_acumulado,'%'.$tx_nom_acumulado.'%',Criteria::LIKE);}
        
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh021NomAcumuladoPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh021NomAcumuladoPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh021NomAcumuladoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh021NomAcumuladoPeer::CO_NOM_ACUMULADO);
        
    $stmt = Tbrh021NomAcumuladoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_nom_acumulado"     => trim($res["co_nom_acumulado"]),
            "tx_nom_acumulado"     => trim($res["tx_nom_acumulado"]),
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