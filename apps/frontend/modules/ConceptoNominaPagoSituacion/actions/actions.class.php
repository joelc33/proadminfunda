<?php

/**
 * ConceptoNominaPagoSituacion actions.
 *
 * @package    gobel
 * @subpackage ConceptoNominaPagoSituacion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConceptoNominaPagoSituacionActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConceptoNominaPagoSituacion', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConceptoNominaPagoSituacion', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh027ConceptoSituacionPeer::CO_CONCEPTO_SITUACION,$codigo);
        
        $stmt = Tbrh027ConceptoSituacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_concepto_situacion"     => $campos["co_concepto_situacion"],
                            "co_concepto"     => $campos["co_concepto"],
                            "co_situacion"     => $campos["co_situacion"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_concepto_situacion"     => "",
                            "co_concepto"     => $this->getRequestParameter("co_concepto"),
                            "co_situacion"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_concepto_situacion");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh027_concepto_situacion = Tbrh027ConceptoSituacionPeer::retrieveByPk($codigo);
     }else{
         $tbrh027_concepto_situacion = new Tbrh027ConceptoSituacion();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh027_concepto_situacionForm = $this->getRequestParameter('tbrh027_concepto_situacion');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tbrh027_concepto_situacion->setCoConcepto($tbrh027_concepto_situacionForm["co_concepto"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh027_concepto_situacion->setCoSituacion($tbrh027_concepto_situacionForm["co_situacion"]);
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tbrh027_concepto_situacionForm)){
            $tbrh027_concepto_situacion->setInActivo(false);
        }else{
            $tbrh027_concepto_situacion->setInActivo(true);
        }*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh027_concepto_situacionForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh027_concepto_situacion->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh027_concepto_situacionForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh027_concepto_situacion->setUpdatedAt($fecha);*/
                                
        /*CAMPOS*/
        $tbrh027_concepto_situacion->save($con);
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
	$codigo = $this->getRequestParameter("co_concepto_situacion");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh027_concepto_situacion = Tbrh027ConceptoSituacionPeer::retrieveByPk($codigo);			
	$tbrh027_concepto_situacion->delete($con);
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
        "co_concepto"     => $this->getRequestParameter("codigo"),
    ));
  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $co_concepto      =   $this->getRequestParameter("co_concepto");
            $co_situacion      =   $this->getRequestParameter("co_situacion");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_concepto!=""){$c->add(Tbrh027ConceptoSituacionPeer::co_concepto,$co_concepto);}
    
                                            if($co_situacion!=""){$c->add(Tbrh027ConceptoSituacionPeer::co_situacion,$co_situacion);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh027ConceptoSituacionPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh027ConceptoSituacionPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    //$cantidadTotal = Tbrh027ConceptoSituacionPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh027ConceptoSituacionPeer::CO_CONCEPTO_SITUACION);
        
        
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh027ConceptoSituacionPeer::CO_CONCEPTO_SITUACION);
        $c->addSelectColumn(Tbrh024NomSituacionPeer::TX_NOM_SITUACION);

        $c->addJoin(Tbrh027ConceptoSituacionPeer::CO_SITUACION, Tbrh024NomSituacionPeer::CO_NOM_SITUACION);

        $c->add(Tbrh027ConceptoSituacionPeer::CO_CONCEPTO,$co_concepto);

        $cantidadTotal = Tbrh027ConceptoSituacionPeer::doCount($c);

    $stmt = Tbrh027ConceptoSituacionPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_concepto_situacion"     => trim($res["co_concepto_situacion"]),
            "co_concepto"     => trim($res["co_concepto"]),
            "co_situacion"     => trim($res["tx_nom_situacion"]),
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

                                //modelo fk tbrh024_nom_situacion.CO_NOM_SITUACION
    public function executeStorefkcosituacion(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh024NomSituacionPeer::doSelectStmt($c);
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