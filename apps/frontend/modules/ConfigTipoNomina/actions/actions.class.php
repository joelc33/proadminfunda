<?php

/**
 * ConfigTipoNomina actions.
 *
 * @package    gobel
 * @subpackage ConfigTipoNomina
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConfigTipoNominaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConfigTipoNomina', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConfigTipoNomina', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh017TpNominaPeer::CO_TP_NOMINA,$codigo);
        
        $stmt = Tbrh017TpNominaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_tp_nomina"     => $campos["co_tp_nomina"],
                            "tx_tp_nomina"     => $campos["tx_tp_nomina"],
                            "nu_hora"     => $campos["nu_hora"],
                            "co_nom_tipo_ingreso"     => $campos["co_nom_tipo_ingreso"],
                            "nu_dia_derecho_vacaciones"     => $campos["nu_dia_derecho_vacaciones"],
                            "nu_anio_antiguedad_vacaciones"     => $campos["nu_anio_antiguedad_vacaciones"],
                            "nu_dia_vacaciones"     => $campos["nu_dia_vacaciones"],
                            "co_nom_tipo_disfrute"     => $campos["co_nom_tipo_disfrute"],
                            "nu_dia_adicional_anio"     => $campos["nu_dia_adicional_anio"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "nu_nomina"     => $campos["nu_nomina"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_tp_nomina"     => "",
                            "tx_tp_nomina"     => "",
                            "nu_hora"     => "",
                            "co_nom_tipo_ingreso"     => "",
                            "nu_dia_derecho_vacaciones"     => "",
                            "nu_anio_antiguedad_vacaciones"     => "",
                            "nu_dia_vacaciones"     => "",
                            "co_nom_tipo_disfrute"     => "",
                            "nu_dia_adicional_anio"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "nu_nomina"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_tp_nomina");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh017_tp_nomina = Tbrh017TpNominaPeer::retrieveByPk($codigo);
     }else{
         $tbrh017_tp_nomina = new Tbrh017TpNomina();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh017_tp_nominaForm = $this->getRequestParameter('tbrh017_tp_nomina');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tbrh017_tp_nomina->setTxTpNomina($tbrh017_tp_nominaForm["tx_tp_nomina"]);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh017_tp_nomina->setNuHora($tbrh017_tp_nominaForm["nu_hora"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh017_tp_nomina->setCoNomTipoIngreso($tbrh017_tp_nominaForm["co_nom_tipo_ingreso"]);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh017_tp_nomina->setNuDiaDerechoVacaciones($tbrh017_tp_nominaForm["nu_dia_derecho_vacaciones"]);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh017_tp_nomina->setNuAnioAntiguedadVacaciones($tbrh017_tp_nominaForm["nu_anio_antiguedad_vacaciones"]);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh017_tp_nomina->setNuDiaVacaciones($tbrh017_tp_nominaForm["nu_dia_vacaciones"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh017_tp_nomina->setCoNomTipoDisfrute($tbrh017_tp_nominaForm["co_nom_tipo_disfrute"]);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh017_tp_nomina->setNuDiaAdicionalAnio($tbrh017_tp_nominaForm["nu_dia_adicional_anio"]);
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tbrh017_tp_nominaForm)){
            $tbrh017_tp_nomina->setInActivo(false);
        }else{
            $tbrh017_tp_nomina->setInActivo(true);
        }*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh017_tp_nominaForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh017_tp_nomina->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh017_tp_nominaForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh017_tp_nomina->setUpdatedAt($fecha);*/

        /*Campo tipo VARCHAR */
        $tbrh017_tp_nomina->setNuNomina($tbrh017_tp_nominaForm["nu_nomina"]);
                                
        /*CAMPOS*/
        $tbrh017_tp_nomina->save($con);
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
	$codigo = $this->getRequestParameter("co_tp_nomina");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh017_tp_nomina = Tbrh017TpNominaPeer::retrieveByPk($codigo);			
	$tbrh017_tp_nomina->delete($con);
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
                $tx_tp_nomina      =   $this->getRequestParameter("tx_tp_nomina");
            $nu_hora      =   $this->getRequestParameter("nu_hora");
            $co_nom_tipo_ingreso      =   $this->getRequestParameter("co_nom_tipo_ingreso");
            $nu_dia_derecho_vacaciones      =   $this->getRequestParameter("nu_dia_derecho_vacaciones");
            $nu_anio_antiguedad_vacaciones      =   $this->getRequestParameter("nu_anio_antiguedad_vacaciones");
            $nu_dia_vacaciones      =   $this->getRequestParameter("nu_dia_vacaciones");
            $co_nom_tipo_disfrute      =   $this->getRequestParameter("co_nom_tipo_disfrute");
            $nu_dia_adicional_anio      =   $this->getRequestParameter("nu_dia_adicional_anio");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_tp_nomina!=""){$c->add(Tbrh017TpNominaPeer::tx_tp_nomina,'%'.$tx_tp_nomina.'%',Criteria::LIKE);}
        
                                            if($nu_hora!=""){$c->add(Tbrh017TpNominaPeer::nu_hora,$nu_hora);}
    
                                            if($co_nom_tipo_ingreso!=""){$c->add(Tbrh017TpNominaPeer::co_nom_tipo_ingreso,$co_nom_tipo_ingreso);}
    
                                            if($nu_dia_derecho_vacaciones!=""){$c->add(Tbrh017TpNominaPeer::nu_dia_derecho_vacaciones,$nu_dia_derecho_vacaciones);}
    
                                            if($nu_anio_antiguedad_vacaciones!=""){$c->add(Tbrh017TpNominaPeer::nu_anio_antiguedad_vacaciones,$nu_anio_antiguedad_vacaciones);}
    
                                            if($nu_dia_vacaciones!=""){$c->add(Tbrh017TpNominaPeer::nu_dia_vacaciones,$nu_dia_vacaciones);}
    
                                            if($co_nom_tipo_disfrute!=""){$c->add(Tbrh017TpNominaPeer::co_nom_tipo_disfrute,$co_nom_tipo_disfrute);}
    
                                            if($nu_dia_adicional_anio!=""){$c->add(Tbrh017TpNominaPeer::nu_dia_adicional_anio,$nu_dia_adicional_anio);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh017TpNominaPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh017TpNominaPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh017TpNominaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh017TpNominaPeer::CO_TP_NOMINA);
        
    $stmt = Tbrh017TpNominaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_tp_nomina"     => trim($res["co_tp_nomina"]),
            "tx_tp_nomina"     => trim($res["tx_tp_nomina"]),
            "nu_hora"     => trim($res["nu_hora"]),
            "co_nom_tipo_ingreso"     => trim($res["co_nom_tipo_ingreso"]),
            "nu_dia_derecho_vacaciones"     => trim($res["nu_dia_derecho_vacaciones"]),
            "nu_anio_antiguedad_vacaciones"     => trim($res["nu_anio_antiguedad_vacaciones"]),
            "nu_dia_vacaciones"     => trim($res["nu_dia_vacaciones"]),
            "co_nom_tipo_disfrute"     => trim($res["co_nom_tipo_disfrute"]),
            "nu_dia_adicional_anio"     => trim($res["nu_dia_adicional_anio"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "nu_nomina"     => trim($res["nu_nomina"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                                                                                            


}