<?php

/**
 * autoEjercicio actions.
 * NombreClaseModel(Tb013AnioFiscal)
 * NombreTabla(tb013_anio_fiscal)
 * @package    ##PROJECT_NAME##
 * @subpackage autoEjercicio
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoEjercicioActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ejercicio', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ejercicio', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL,$codigo);
        
        $stmt = Tb013AnioFiscalPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_anio_fiscal"     => $campos["co_anio_fiscal"],
                            "tx_anio_fiscal"     => $campos["tx_anio_fiscal"],
                            "fe_apertura"     => $campos["fe_apertura"],
                            "co_usuario"     => $campos["co_usuario"],
                            "in_activo"     => $campos["in_activo"],
                            "fe_cierre"     => $campos["fe_cierre"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_anio_fiscal"     => "",
                            "tx_anio_fiscal"     => "",
                            "fe_apertura"     => "",
                            "co_usuario"     => "",
                            "in_activo"     => "",
                            "fe_cierre"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_anio_fiscal");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb013_anio_fiscal = Tb013AnioFiscalPeer::retrieveByPk($codigo);
     }else{
         $tb013_anio_fiscal = new Tb013AnioFiscal();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb013_anio_fiscalForm = $this->getRequestParameter('tb013_anio_fiscal');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb013_anio_fiscal->setTxAnioFiscal($tb013_anio_fiscalForm["tx_anio_fiscal"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb013_anio_fiscalForm["fe_apertura"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb013_anio_fiscal->setFeApertura($fecha);
                                                        
        /*Campo tipo BIGINT */
        $tb013_anio_fiscal->setCoUsuario($tb013_anio_fiscalForm["co_usuario"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb013_anio_fiscalForm)){
            $tb013_anio_fiscal->setInActivo(false);
        }else{
            $tb013_anio_fiscal->setInActivo(true);
        }
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb013_anio_fiscalForm["fe_cierre"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb013_anio_fiscal->setFeCierre($fecha);
                                
        /*CAMPOS*/
        $tb013_anio_fiscal->save($con);
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
	$codigo = $this->getRequestParameter("co_anio_fiscal");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb013_anio_fiscal = Tb013AnioFiscalPeer::retrieveByPk($codigo);			
	$tb013_anio_fiscal->delete($con);
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
                $tx_anio_fiscal      =   $this->getRequestParameter("tx_anio_fiscal");
            $fe_apertura      =   $this->getRequestParameter("fe_apertura");
            $co_usuario      =   $this->getRequestParameter("co_usuario");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $fe_cierre      =   $this->getRequestParameter("fe_cierre");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_anio_fiscal!=""){$c->add(Tb013AnioFiscalPeer::tx_anio_fiscal,'%'.$tx_anio_fiscal.'%',Criteria::LIKE);}
        
                                    
        if($fe_apertura!=""){
    list($dia, $mes,$anio) = explode("/",$fe_apertura);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb013AnioFiscalPeer::fe_apertura,$fecha);
    }
                                            if($co_usuario!=""){$c->add(Tb013AnioFiscalPeer::co_usuario,$co_usuario);}
    
                                    
                                    
        if($fe_cierre!=""){
    list($dia, $mes,$anio) = explode("/",$fe_cierre);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb013AnioFiscalPeer::fe_cierre,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb013AnioFiscalPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
        
    $stmt = Tb013AnioFiscalPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_anio_fiscal"     => trim($res["co_anio_fiscal"]),
            "tx_anio_fiscal"     => trim($res["tx_anio_fiscal"]),
            "fe_apertura"     => trim($res["fe_apertura"]),
            "co_usuario"     => trim($res["co_usuario"]),
            "in_activo"     => trim($res["in_activo"]),
            "fe_cierre"     => trim($res["fe_cierre"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                            //modelo fk tb001_usuario.CO_USUARIO
    public function executeStorefkcousuario(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb001UsuarioPeer::doSelectStmt($c);
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