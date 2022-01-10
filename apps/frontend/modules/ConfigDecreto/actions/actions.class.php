<?php

/**
 * ConfigDecreto actions.
 *
 * @package    gobel
 * @subpackage ConfigDecreto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConfigDecretoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConfigDecreto', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConfigDecreto', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb068NumeroFuenteFinanciamientoPeer::CO_NUMERO_FUENTE,$codigo);
        
        $stmt = Tb068NumeroFuenteFinanciamientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_numero_fuente"     => $campos["co_numero_fuente"],
                            "co_fuente_financiamiento"     => $campos["co_fuente_financiamiento"],
                            "tx_numero_fuente"     => $campos["tx_numero_fuente"],
                            "co_usuario"     => $campos["co_usuario"],
                            "created_at"     => $campos["created_at"],
                            "co_tipo_fuente_financiamiento"     => $campos["id_tipo_fuente_financiamiento"],
                            "id_tb013_anio_fiscal"     => $campos["id_tb013_anio_fiscal"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_numero_fuente"     => "",
                            "co_fuente_financiamiento"     => "",
                            "tx_numero_fuente"     => "",
                            "co_usuario"     => "",
                            "created_at"     => "",
                            "id_tipo_fuente_financiamiento"     => "",
                            "id_tb013_anio_fiscal"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_numero_fuente");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb068_numero_fuente_financiamiento = Tb068NumeroFuenteFinanciamientoPeer::retrieveByPk($codigo);

         $tb068_numero_fuente_financiamientoForm = $this->getRequestParameter('tb068_numero_fuente_financiamiento');

         if($tb068_numero_fuente_financiamientoForm["tx_numero_fuente"]!=$tb068_numero_fuente_financiamiento->getTxNumeroFuente()){
                $c = new Criteria();
                $c->add(Tb068NumeroFuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO, $tb068_numero_fuente_financiamientoForm["co_fuente_financiamiento"]);
                $c->add(Tb068NumeroFuenteFinanciamientoPeer::TX_NUMERO_FUENTE, $tb068_numero_fuente_financiamientoForm["tx_numero_fuente"]);
                $c->add(Tb068NumeroFuenteFinanciamientoPeer::ID_TIPO_FUENTE_FINANCIAMIENTO, $tb068_numero_fuente_financiamientoForm["co_tipo_fuente_financiamiento"]);
                $c->add(Tb068NumeroFuenteFinanciamientoPeer::ID_TB013_ANIO_FISCAL, $tb068_numero_fuente_financiamientoForm["id_tb013_anio_fiscal"]);
                $cantidad = Tb068NumeroFuenteFinanciamientoPeer::doCount($c);
   
                if ($cantidad > 0) {
                    $this->data = json_encode(array(
                      'success' => false,
                      'msg' => '<span style="color:red;font-size:13px,"><b> El Decreto ya se encuentra registrado</b></span>'
                    ));
         
                    return $this->setTemplate('store');
                }  

            }

     }else{
         $tb068_numero_fuente_financiamiento = new Tb068NumeroFuenteFinanciamiento();

         $tb068_numero_fuente_financiamientoForm = $this->getRequestParameter('tb068_numero_fuente_financiamiento');

         $c = new Criteria();
         $c->add(Tb068NumeroFuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO, $tb068_numero_fuente_financiamientoForm["co_fuente_financiamiento"]);
         $c->add(Tb068NumeroFuenteFinanciamientoPeer::TX_NUMERO_FUENTE, $tb068_numero_fuente_financiamientoForm["tx_numero_fuente"]);
         $c->add(Tb068NumeroFuenteFinanciamientoPeer::ID_TIPO_FUENTE_FINANCIAMIENTO, $tb068_numero_fuente_financiamientoForm["co_tipo_fuente_financiamiento"]);
         $c->add(Tb068NumeroFuenteFinanciamientoPeer::ID_TB013_ANIO_FISCAL, $tb068_numero_fuente_financiamientoForm["id_tb013_anio_fiscal"]);
         $cantidad = Tb068NumeroFuenteFinanciamientoPeer::doCount($c);

         if ($cantidad > 0) {
           $this->data = json_encode(array(
             'success' => false,
             'msg' => '<span style="color:red;font-size:13px,"><b> El Decreto ya se encuentra registrado</b></span>'
           ));

           return $this->setTemplate('store');
         } 
         
     }
     try
      { 
        $con->beginTransaction();
       
        $tb068_numero_fuente_financiamientoForm = $this->getRequestParameter('tb068_numero_fuente_financiamiento');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb068_numero_fuente_financiamiento->setCoFuenteFinanciamiento($tb068_numero_fuente_financiamientoForm["co_fuente_financiamiento"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb068_numero_fuente_financiamiento->setTxNumeroFuente($tb068_numero_fuente_financiamientoForm["tx_numero_fuente"]);
                                                        
        /*Campo tipo BIGINT */
        $tb068_numero_fuente_financiamiento->setCoUsuario($this->getUser()->getAttribute('codigo'));
        
        $tb068_numero_fuente_financiamiento->setIdTipoFuenteFinanciamiento($tb068_numero_fuente_financiamientoForm["co_tipo_fuente_financiamiento"]);
                                                                
        /*Campo tipo DATE */
        /*list($dia, $mes, $anio) = explode("/",$tb068_numero_fuente_financiamientoForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb068_numero_fuente_financiamiento->setCreatedAt($fecha);*/

         /*Campo tipo INTEGER */
         $tb068_numero_fuente_financiamiento->setIdTb013AnioFiscal($tb068_numero_fuente_financiamientoForm["id_tb013_anio_fiscal"]);
                                
        /*CAMPOS*/
        $tb068_numero_fuente_financiamiento->save($con);
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
	$codigo = $this->getRequestParameter("co_numero_fuente");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb068_numero_fuente_financiamiento = Tb068NumeroFuenteFinanciamientoPeer::retrieveByPk($codigo);			
	$tb068_numero_fuente_financiamiento->delete($con);
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
                $co_fuente_financiamiento      =   $this->getRequestParameter("co_fuente_financiamiento");
            $tx_numero_fuente      =   $this->getRequestParameter("tx_numero_fuente");
            $co_usuario      =   $this->getRequestParameter("co_usuario");
            $created_at      =   $this->getRequestParameter("created_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_fuente_financiamiento!=""){$c->add(Tb068NumeroFuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO,$co_fuente_financiamiento);}
    
                                        if($tx_numero_fuente!=""){$c->add(Tb068NumeroFuenteFinanciamientoPeer::TX_NUMERO_FUENTE,'%'.$tx_numero_fuente.'%',Criteria::LIKE);}
        
                                            if($co_usuario!=""){$c->add(Tb068NumeroFuenteFinanciamientoPeer::CO_USUARIO,$co_usuario);}
    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb068NumeroFuenteFinanciamientoPeer::created_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb068NumeroFuenteFinanciamientoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb068NumeroFuenteFinanciamientoPeer::CO_NUMERO_FUENTE);

        $c->addSelectColumn(Tb068NumeroFuenteFinanciamientoPeer::CO_NUMERO_FUENTE);
        $c->addSelectColumn(Tb068NumeroFuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO);
        $c->addSelectColumn(Tb068NumeroFuenteFinanciamientoPeer::TX_NUMERO_FUENTE);
        $c->addSelectColumn(Tb073FuenteFinanciamientoPeer::TX_FUENTE_FINANCIAMIENTO);
        $c->addSelectColumn(Tb099TipoFuenteFinanciamientoPeer::DE_TIPO_FUENTE_FINANCIAMIENTO);
        $c->addSelectColumn(Tb068NumeroFuenteFinanciamientoPeer::ID_TB013_ANIO_FISCAL);

        $c->addJoin(Tb073FuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO, Tb068NumeroFuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO);
        $c->addJoin(Tb068NumeroFuenteFinanciamientoPeer::ID_TIPO_FUENTE_FINANCIAMIENTO, Tb099TipoFuenteFinanciamientoPeer::ID , Criteria::LEFT_JOIN);
        
    $stmt = Tb068NumeroFuenteFinanciamientoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_numero_fuente"     => trim($res["co_numero_fuente"]),
            "co_fuente_financiamiento"     => trim($res["tx_fuente_financiamiento"]),
            "de_tipo_fuente_financiamiento"     => trim($res["de_tipo_fuente_financiamiento"]),
            "tx_numero_fuente"     => trim($res["tx_numero_fuente"]),
            "co_usuario"     => trim($res["co_usuario"]),
            "created_at"     => trim($res["created_at"]),
            "id_tb013_anio_fiscal"     => trim($res["id_tb013_anio_fiscal"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb073_fuente_financiamiento.CO_FUENTE_FINANCIAMIENTO
    public function executeStorefkcofuentefinanciamiento(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb073FuenteFinanciamientoPeer::doSelectStmt($c);
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
    
        public function executeStorefkcotipofuentefinanciamiento(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb099TipoFuenteFinanciamientoPeer::doSelectStmt($c);
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
                    
    //modelo fk tb013_anio_fiscal.CO_ANIO_FISCAL
    public function executeStorefkidtb013aniofiscal(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb013AnioFiscalPeer::doSelectStmt($c);
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