<?php

/**
 * ConfigPrimaAntiguedad actions.
 *
 * @package    gobel
 * @subpackage ConfigPrimaAntiguedad
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConfigPrimaAntiguedadActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConfigPrimaAntiguedad', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConfigPrimaAntiguedad', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh070PrimaAntiguedadPeer::CO_PRIMA_ANTIGUEDAD,$codigo);
        
        $stmt = Tbrh070PrimaAntiguedadPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_prima_antiguedad"     => $campos["co_prima_antiguedad"],
                            "co_tp_nomina"     => $campos["co_tp_nomina"],
                            "co_grupo_nomina"     => $campos["co_grupo_nomina"],
                            "nu_anio"     => $campos["nu_anio"],
                            "nu_porcentaje"     => $campos["nu_porcentaje"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "de_condicional"     => $campos["de_condicional"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_prima_antiguedad"     => "",
                            "co_tp_nomina"     => "",
                            "co_grupo_nomina"     => "",
                            "nu_anio"     => "",
                            "nu_porcentaje"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "de_condicional"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_prima_antiguedad");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh070_prima_antiguedad = Tbrh070PrimaAntiguedadPeer::retrieveByPk($codigo);
     }else{
         $tbrh070_prima_antiguedad = new Tbrh070PrimaAntiguedad();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh070_prima_antiguedadForm = $this->getRequestParameter('tbrh070_prima_antiguedad');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tbrh070_prima_antiguedad->setCoTpNomina($tbrh070_prima_antiguedadForm["co_tp_nomina"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh070_prima_antiguedad->setCoGrupoNomina($tbrh070_prima_antiguedadForm["co_grupo_nomina"]);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh070_prima_antiguedad->setNuAnio($tbrh070_prima_antiguedadForm["nu_anio"]);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh070_prima_antiguedad->setNuPorcentaje($tbrh070_prima_antiguedadForm["nu_porcentaje"]);

        /*Campo tipo NUMERIC */
        $tbrh070_prima_antiguedad->setDeCondicional($tbrh070_prima_antiguedadForm["de_condicional"]);
                                
        /*CAMPOS*/
        $tbrh070_prima_antiguedad->save($con);
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
	$codigo = $this->getRequestParameter("co_prima_antiguedad");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh070_prima_antiguedad = Tbrh070PrimaAntiguedadPeer::retrieveByPk($codigo);			
	$tbrh070_prima_antiguedad->delete($con);
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
                $co_tp_nomina      =   $this->getRequestParameter("co_tp_nomina");
            $co_grupo_nomina      =   $this->getRequestParameter("co_grupo_nomina");
            $nu_anio      =   $this->getRequestParameter("nu_anio");
            $nu_porcentaje      =   $this->getRequestParameter("nu_porcentaje");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_tp_nomina!=""){$c->add(Tbrh070PrimaAntiguedadPeer::CO_TP_NOMINA,$co_tp_nomina);}
    
                                            if($co_grupo_nomina!=""){$c->add(Tbrh070PrimaAntiguedadPeer::CO_GRUPO_NOMINA,$co_grupo_nomina);}
    
                                            if($nu_anio!=""){$c->add(Tbrh070PrimaAntiguedadPeer::NU_ANIO,$nu_anio);}
    
                                            if($nu_porcentaje!=""){$c->add(Tbrh070PrimaAntiguedadPeer::NU_PORCENTAJE,$nu_porcentaje);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh070PrimaAntiguedadPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh070PrimaAntiguedadPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);

    $c->clearSelectColumns();
    $c->addSelectColumn(Tbrh070PrimaAntiguedadPeer::CO_PRIMA_ANTIGUEDAD);
    $c->addSelectColumn(Tbrh070PrimaAntiguedadPeer::NU_ANIO);
    $c->addSelectColumn(Tbrh070PrimaAntiguedadPeer::NU_PORCENTAJE);
    $c->addSelectColumn(Tbrh070PrimaAntiguedadPeer::IN_ACTIVO);
    $c->addSelectColumn(Tbrh070PrimaAntiguedadPeer::DE_CONDICIONAL);
    $c->addSelectColumn(Tbrh017TpNominaPeer::NU_NOMINA);
    $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
    $c->addSelectColumn(Tbrh067GrupoNominaPeer::COD_GRUPO_NOMINA);
    $c->addSelectColumn(Tbrh067GrupoNominaPeer::TX_GRUPO_NOMINA);

    $c->addJoin(Tbrh070PrimaAntiguedadPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
    $c->addJoin(Tbrh070PrimaAntiguedadPeer::CO_GRUPO_NOMINA, Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);

    $cantidadTotal = Tbrh070PrimaAntiguedadPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        //$c->addAscendingOrderByColumn(Tbrh070PrimaAntiguedadPeer::CO_PRIMA_ANTIGUEDAD);
        $c->addDescendingOrderByColumn(Tbrh070PrimaAntiguedadPeer::CO_PRIMA_ANTIGUEDAD);
        
    $stmt = Tbrh070PrimaAntiguedadPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_prima_antiguedad"     => trim($res["co_prima_antiguedad"]),
            "co_tp_nomina"     => trim($res["co_tp_nomina"]),
            "co_grupo_nomina"     => trim($res["co_grupo_nomina"]),
            "nu_anio"     => trim($res["nu_anio"]),
            "nu_porcentaje"     => trim($res["nu_porcentaje"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "nu_nomina"     => trim($res["nu_nomina"]),
            "tx_tp_nomina"     => trim($res["tx_tp_nomina"]),
            "cod_grupo_nomina"     => trim($res["cod_grupo_nomina"]),
            "tx_grupo_nomina"     => trim($res["tx_grupo_nomina"]),
            "de_condicional"     => trim($res["de_condicional"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tbrh017_tp_nomina.CO_TP_NOMINA
    public function executeStorefkcotpnomina(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh017TpNominaPeer::doSelectStmt($c);
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
                    //modelo fk tbrh067_grupo_nomina.CO_GRUPO_NOMINA
    public function executeStorefkcogruponomina(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tbrh067GrupoNominaPeer::CO_TP_NOMINA, $this->getRequestParameter("tipo"));
        $stmt = Tbrh067GrupoNominaPeer::doSelectStmt($c);
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