<?php

/**
 * ConfigNomFuncion actions.
 *
 * @package    gobel
 * @subpackage ConfigNomFuncion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConfigNomFuncionActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConfigNomFuncion', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConfigNomFuncion', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh035NomFuncionPeer::CO_NOM_FUNCION,$codigo);
        
        $stmt = Tbrh035NomFuncionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_nom_funcion"     => $campos["co_nom_funcion"],
                            "tx_nom_funcion"     => $campos["tx_nom_funcion"],
                            "tx_nom_descripcion"     => $campos["tx_nom_descripcion"],
                            "tx_nom_parametro"     => $campos["tx_nom_parametro"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "co_tp_funcion"     => $campos["co_tp_funcion"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_nom_funcion"     => "",
                            "tx_nom_funcion"     => "",
                            "tx_nom_descripcion"     => "",
                            "tx_nom_parametro"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "co_tp_funcion"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_nom_funcion");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh035_nom_funcion = Tbrh035NomFuncionPeer::retrieveByPk($codigo);
     }else{
         $tbrh035_nom_funcion = new Tbrh035NomFuncion();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh035_nom_funcionForm = $this->getRequestParameter('tbrh035_nom_funcion');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tbrh035_nom_funcion->setTxNomFuncion($tbrh035_nom_funcionForm["tx_nom_funcion"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh035_nom_funcion->setTxNomDescripcion($tbrh035_nom_funcionForm["tx_nom_descripcion"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh035_nom_funcion->setTxNomParametro($tbrh035_nom_funcionForm["tx_nom_parametro"]);
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tbrh035_nom_funcionForm)){
            $tbrh035_nom_funcion->setInActivo(false);
        }else{
            $tbrh035_nom_funcion->setInActivo(true);
        }*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh035_nom_funcionForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh035_nom_funcion->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh035_nom_funcionForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh035_nom_funcion->setUpdatedAt($fecha);*/
                                                        
        /*Campo tipo BIGINT */
        $tbrh035_nom_funcion->setCoTpFuncion($tbrh035_nom_funcionForm["co_tp_funcion"]);
                                
        /*CAMPOS*/
        $tbrh035_nom_funcion->save($con);
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
	$codigo = $this->getRequestParameter("co_nom_funcion");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh035_nom_funcion = Tbrh035NomFuncionPeer::retrieveByPk($codigo);			
	$tbrh035_nom_funcion->delete($con);
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

  public function executeTodo(sfWebRequest $request)
  {

  }

  public function executeLista(sfWebRequest $request)
  {

  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",100);
    $start      =   $this->getRequestParameter("start",0);
                $tx_nom_funcion      =   $this->getRequestParameter("tx_nom_funcion");
            $tx_nom_descripcion      =   $this->getRequestParameter("tx_nom_descripcion");
            $tx_nom_parametro      =   $this->getRequestParameter("tx_nom_parametro");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $co_tp_funcion      =   $this->getRequestParameter("co_tp_funcion");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_nom_funcion!=""){$c->add(Tbrh035NomFuncionPeer::tx_nom_funcion,'%'.$tx_nom_funcion.'%',Criteria::LIKE);}
        
                                        if($tx_nom_descripcion!=""){$c->add(Tbrh035NomFuncionPeer::tx_nom_descripcion,'%'.$tx_nom_descripcion.'%',Criteria::LIKE);}
        
                                        if($tx_nom_parametro!=""){$c->add(Tbrh035NomFuncionPeer::tx_nom_parametro,'%'.$tx_nom_parametro.'%',Criteria::LIKE);}
        
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh035NomFuncionPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh035NomFuncionPeer::updated_at,$fecha);
    }
                                            if($co_tp_funcion!=""){$c->add(Tbrh035NomFuncionPeer::co_tp_funcion,$co_tp_funcion);}
    
                    }
    $c->setIgnoreCase(true);

        
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh035NomFuncionPeer::CO_NOM_FUNCION);
        $c->addSelectColumn(Tbrh035NomFuncionPeer::TX_NOM_FUNCION);
        $c->addSelectColumn(Tbrh035NomFuncionPeer::TX_NOM_DESCRIPCION);
        $c->addSelectColumn(Tbrh035NomFuncionPeer::TX_NOM_PARAMETRO);
        $c->addSelectColumn(Tbrh036TipoFuncionPeer::TX_TP_FUNCION);
        $c->addJoin(Tbrh035NomFuncionPeer::CO_TP_FUNCION, Tbrh036TipoFuncionPeer::CO_TP_FUNCION);
    
        $c->setLimit($limit)->setOffset($start);
        $cantidadTotal = Tbrh035NomFuncionPeer::doCount($c);
            $c->addAscendingOrderByColumn(Tbrh035NomFuncionPeer::CO_NOM_FUNCION);
        
    $stmt = Tbrh035NomFuncionPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_nom_funcion"     => trim($res["co_nom_funcion"]),
            "tx_nom_funcion"     => trim($res["tx_nom_funcion"]),
            "tx_nom_descripcion"     => trim($res["tx_nom_descripcion"]),
            "tx_nom_parametro"     => trim($res["tx_nom_parametro"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "co_tp_funcion"     => trim($res["tx_tp_funcion"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                                            //modelo fk tbrh036_tipo_funcion.CO_TP_FUNCION
    public function executeStorefkcotpfuncion(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh036TipoFuncionPeer::doSelectStmt($c);
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