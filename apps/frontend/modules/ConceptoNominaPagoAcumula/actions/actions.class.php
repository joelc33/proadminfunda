<?php

/**
 * ConceptoNominaPagoAcumula actions.
 *
 * @package    gobel
 * @subpackage ConceptoNominaPagoAcumula
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConceptoNominaPagoAcumulaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConceptoNominaPagoAcumula', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConceptoNominaPagoAcumula', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh034ConcepAcumuladoPeer::CO_CONCEP_ACUMULADO,$codigo);
        
        $stmt = Tbrh034ConcepAcumuladoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_concep_acumulado"     => $campos["co_concep_acumulado"],
                            "co_concepto"     => $campos["co_concepto"],
                            "co_nom_acumulado"     => $campos["co_nom_acumulado"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_concep_acumulado"     => "",
                            "co_concepto"     => $this->getRequestParameter("co_concepto"),
                            "co_nom_acumulado"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_concep_acumulado");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh034_concep_acumulado = Tbrh034ConcepAcumuladoPeer::retrieveByPk($codigo);
     }else{
         $tbrh034_concep_acumulado = new Tbrh034ConcepAcumulado();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh034_concep_acumuladoForm = $this->getRequestParameter('tbrh034_concep_acumulado');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tbrh034_concep_acumulado->setCoConcepto($tbrh034_concep_acumuladoForm["co_concepto"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh034_concep_acumulado->setCoNomAcumulado($tbrh034_concep_acumuladoForm["co_nom_acumulado"]);
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tbrh034_concep_acumuladoForm)){
            $tbrh034_concep_acumulado->setInActivo(false);
        }else{
            $tbrh034_concep_acumulado->setInActivo(true);
        }*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh034_concep_acumuladoForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh034_concep_acumulado->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh034_concep_acumuladoForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh034_concep_acumulado->setUpdatedAt($fecha);*/
                                
        /*CAMPOS*/
        $tbrh034_concep_acumulado->save($con);
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
	$codigo = $this->getRequestParameter("co_concep_acumulado");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh034_concep_acumulado = Tbrh034ConcepAcumuladoPeer::retrieveByPk($codigo);			
	$tbrh034_concep_acumulado->delete($con);
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
            $co_nom_acumulado      =   $this->getRequestParameter("co_nom_acumulado");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_concepto!=""){$c->add(Tbrh034ConcepAcumuladoPeer::co_concepto,$co_concepto);}
    
                                            if($co_nom_acumulado!=""){$c->add(Tbrh034ConcepAcumuladoPeer::co_nom_acumulado,$co_nom_acumulado);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh034ConcepAcumuladoPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh034ConcepAcumuladoPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh034ConcepAcumuladoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh034ConcepAcumuladoPeer::CO_CONCEP_ACUMULADO);
        
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh034ConcepAcumuladoPeer::CO_CONCEP_ACUMULADO);
        $c->addSelectColumn(Tbrh021NomAcumuladoPeer::TX_NOM_ACUMULADO);

        $c->addJoin(Tbrh034ConcepAcumuladoPeer::CO_NOM_ACUMULADO, Tbrh021NomAcumuladoPeer::CO_NOM_ACUMULADO);

        $c->add(Tbrh034ConcepAcumuladoPeer::CO_CONCEPTO,$co_concepto);

    $stmt = Tbrh034ConcepAcumuladoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_concep_acumulado"     => trim($res["co_concep_acumulado"]),
            "co_concepto"     => trim($res["co_concepto"]),
            "co_nom_acumulado"     => trim($res["tx_nom_acumulado"]),
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

                    //modelo fk tbrh014_concepto.CO_CONCEPTO
    public function executeStorefkcoconcepto(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh014ConceptoPeer::doSelectStmt($c);
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
                    //modelo fk tbrh021_nom_acumulado.CO_NOM_ACUMULADO
    public function executeStorefkconomacumulado(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh021NomAcumuladoPeer::doSelectStmt($c);
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