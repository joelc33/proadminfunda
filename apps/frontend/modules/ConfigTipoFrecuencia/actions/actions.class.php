<?php

/**
 * ConfigTipoFrecuencia actions.
 *
 * @package    gobel
 * @subpackage ConfigTipoFrecuencia
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConfigTipoFrecuenciaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConfigTipoFrecuencia', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConfigTipoFrecuencia', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh023NomFrecuenciaPagoPeer::CO_NOM_FRECUENCIA_PAGO,$codigo);
        
        $stmt = Tbrh023NomFrecuenciaPagoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_nom_frecuencia_pago"     => $campos["co_nom_frecuencia_pago"],
                            "tx_nom_frecuencia_pago"     => $campos["tx_nom_frecuencia_pago"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_nom_frecuencia_pago"     => "",
                            "tx_nom_frecuencia_pago"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_nom_frecuencia_pago");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh023_nom_frecuencia_pago = Tbrh023NomFrecuenciaPagoPeer::retrieveByPk($codigo);
     }else{
         $tbrh023_nom_frecuencia_pago = new Tbrh023NomFrecuenciaPago();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh023_nom_frecuencia_pagoForm = $this->getRequestParameter('tbrh023_nom_frecuencia_pago');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tbrh023_nom_frecuencia_pago->setTxNomFrecuenciaPago($tbrh023_nom_frecuencia_pagoForm["tx_nom_frecuencia_pago"]);
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tbrh023_nom_frecuencia_pagoForm)){
            $tbrh023_nom_frecuencia_pago->setInActivo(false);
        }else{
            $tbrh023_nom_frecuencia_pago->setInActivo(true);
        }*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh023_nom_frecuencia_pagoForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh023_nom_frecuencia_pago->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh023_nom_frecuencia_pagoForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh023_nom_frecuencia_pago->setUpdatedAt($fecha);*/
                                
        /*CAMPOS*/
        $tbrh023_nom_frecuencia_pago->save($con);
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
	$codigo = $this->getRequestParameter("co_nom_frecuencia_pago");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh023_nom_frecuencia_pago = Tbrh023NomFrecuenciaPagoPeer::retrieveByPk($codigo);			
	$tbrh023_nom_frecuencia_pago->delete($con);
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
                $tx_nom_frecuencia_pago      =   $this->getRequestParameter("tx_nom_frecuencia_pago");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_nom_frecuencia_pago!=""){$c->add(Tbrh023NomFrecuenciaPagoPeer::tx_nom_frecuencia_pago,'%'.$tx_nom_frecuencia_pago.'%',Criteria::LIKE);}
        
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh023NomFrecuenciaPagoPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh023NomFrecuenciaPagoPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh023NomFrecuenciaPagoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh023NomFrecuenciaPagoPeer::CO_NOM_FRECUENCIA_PAGO);
        
    $stmt = Tbrh023NomFrecuenciaPagoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_nom_frecuencia_pago"     => trim($res["co_nom_frecuencia_pago"]),
            "tx_nom_frecuencia_pago"     => trim($res["tx_nom_frecuencia_pago"]),
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