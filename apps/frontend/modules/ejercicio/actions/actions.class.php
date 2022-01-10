<?php

/**
 * ejercicio actions.
 *
 * @package    gobel
 * @subpackage ejercicio
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ejercicioActions extends sfActions
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
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_anio_fiscal"     => "",
                            "tx_anio_fiscal"     => "",
                            "fe_apertura"     => "",
                            "co_usuario"     => "",
                            "in_activo"     => "",
                    ));
    }

  }

    public function executeGuardar(sfWebRequest $request)
    {

        $ejercicio = $this->getRequestParameter('ejercicio');

        $c = new Criteria();
        $c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $ejercicio);
        $stmt = Tb013AnioFiscalPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->getUser()->setAttribute('ejercicio', $ejercicio );
        $this->getUser()->setAttribute('fe_apertura', $campos["fe_apertura"] );
        $this->getUser()->setAttribute('fe_cierre', $campos["fe_cierre"] );
        $this->getUser()->setAttribute('in_activo', $campos["in_activo"] );
        
        $data = array("msg" => "Usuario Validado","success"=>true,"url"=>'inicio');
        $resultado = json_encode($data);

        echo $resultado;
        return sfView::NONE;

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
    $this->data = json_encode(array(
        "co_anio_fiscal"     => "",
        "tx_anio_fiscal"     => "",
        "fe_apertura"     => "",
        "co_usuario"     => "",
        "in_activo"     => "",
    ));
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
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_anio_fiscal!=""){$c->add(Tb013AnioFiscalPeer::tx_anio_fiscal,'%'.$tx_anio_fiscal.'%',Criteria::LIKE);}
        
                                    
        if($fe_apertura!=""){
    list($dia, $mes,$anio) = explode("/",$fe_apertura);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb013AnioFiscalPeer::fe_apertura,$fecha);
    }
                                            if($co_usuario!=""){$c->add(Tb013AnioFiscalPeer::co_usuario,$co_usuario);}
    
                                    
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