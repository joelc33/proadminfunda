<?php

/**
 * autoEmpresa actions.
 * NombreClaseModel(Tb015Empresa)
 * NombreTabla(tb015_empresa)
 * @package    ##PROJECT_NAME##
 * @subpackage autoEmpresa
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoEmpresaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Empresa', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Empresa', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb015EmpresaPeer::CO_EMPRESA,$codigo);
        
        $stmt = Tb015EmpresaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_empresa"     => $campos["co_empresa"],
                            "nb_empresa"     => $campos["nb_empresa"],
                            "co_estado"     => $campos["co_estado"],
                            "co_municipio"     => $campos["co_municipio"],
                            "tx_rif"     => $campos["tx_rif"],
                            "tx_nit"     => $campos["tx_nit"],
                            "tx_direccion"     => $campos["tx_direccion"],
                            "tx_imagen_der"     => $campos["tx_imagen_der"],
                            "tx_imagen_izq"     => $campos["tx_imagen_izq"],
                            "tx_imagen_cen"     => $campos["tx_imagen_cen"],
                            "nu_telefono"     => $campos["nu_telefono"],
                            "tx_sigla"     => $campos["tx_sigla"],
                            "op_imagen"     => $campos["op_imagen"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_empresa"     => "",
                            "nb_empresa"     => "",
                            "co_estado"     => "",
                            "co_municipio"     => "",
                            "tx_rif"     => "",
                            "tx_nit"     => "",
                            "tx_direccion"     => "",
                            "tx_imagen_der"     => "",
                            "tx_imagen_izq"     => "",
                            "tx_imagen_cen"     => "",
                            "nu_telefono"     => "",
                            "tx_sigla"     => "",
                            "op_imagen"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_empresa");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb015_empresa = Tb015EmpresaPeer::retrieveByPk($codigo);
     }else{
         $tb015_empresa = new Tb015Empresa();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb015_empresaForm = $this->getRequestParameter('tb015_empresa');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb015_empresa->setNbEmpresa($tb015_empresaForm["nb_empresa"]);
                                                        
        /*Campo tipo BIGINT */
        $tb015_empresa->setCoEstado($tb015_empresaForm["co_estado"]);
                                                        
        /*Campo tipo BIGINT */
        $tb015_empresa->setCoMunicipio($tb015_empresaForm["co_municipio"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb015_empresa->setTxRif($tb015_empresaForm["tx_rif"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb015_empresa->setTxNit($tb015_empresaForm["tx_nit"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb015_empresa->setTxDireccion($tb015_empresaForm["tx_direccion"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb015_empresa->setTxImagenDer($tb015_empresaForm["tx_imagen_der"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb015_empresa->setTxImagenIzq($tb015_empresaForm["tx_imagen_izq"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb015_empresa->setTxImagenCen($tb015_empresaForm["tx_imagen_cen"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb015_empresa->setNuTelefono($tb015_empresaForm["nu_telefono"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb015_empresa->setTxSigla($tb015_empresaForm["tx_sigla"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb015_empresa->setOpImagen($tb015_empresaForm["op_imagen"]);
                                
        /*CAMPOS*/
        $tb015_empresa->save($con);
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
	$codigo = $this->getRequestParameter("co_empresa");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb015_empresa = Tb015EmpresaPeer::retrieveByPk($codigo);			
	$tb015_empresa->delete($con);
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
                $nb_empresa      =   $this->getRequestParameter("nb_empresa");
            $co_estado      =   $this->getRequestParameter("co_estado");
            $co_municipio      =   $this->getRequestParameter("co_municipio");
            $tx_rif      =   $this->getRequestParameter("tx_rif");
            $tx_nit      =   $this->getRequestParameter("tx_nit");
            $tx_direccion      =   $this->getRequestParameter("tx_direccion");
            $tx_imagen_der      =   $this->getRequestParameter("tx_imagen_der");
            $tx_imagen_izq      =   $this->getRequestParameter("tx_imagen_izq");
            $tx_imagen_cen      =   $this->getRequestParameter("tx_imagen_cen");
            $nu_telefono      =   $this->getRequestParameter("nu_telefono");
            $tx_sigla      =   $this->getRequestParameter("tx_sigla");
            $op_imagen      =   $this->getRequestParameter("op_imagen");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($nb_empresa!=""){$c->add(Tb015EmpresaPeer::nb_empresa,'%'.$nb_empresa.'%',Criteria::LIKE);}
        
                                            if($co_estado!=""){$c->add(Tb015EmpresaPeer::co_estado,$co_estado);}
    
                                            if($co_municipio!=""){$c->add(Tb015EmpresaPeer::co_municipio,$co_municipio);}
    
                                        if($tx_rif!=""){$c->add(Tb015EmpresaPeer::tx_rif,'%'.$tx_rif.'%',Criteria::LIKE);}
        
                                        if($tx_nit!=""){$c->add(Tb015EmpresaPeer::tx_nit,'%'.$tx_nit.'%',Criteria::LIKE);}
        
                                        if($tx_direccion!=""){$c->add(Tb015EmpresaPeer::tx_direccion,'%'.$tx_direccion.'%',Criteria::LIKE);}
        
                                        if($tx_imagen_der!=""){$c->add(Tb015EmpresaPeer::tx_imagen_der,'%'.$tx_imagen_der.'%',Criteria::LIKE);}
        
                                        if($tx_imagen_izq!=""){$c->add(Tb015EmpresaPeer::tx_imagen_izq,'%'.$tx_imagen_izq.'%',Criteria::LIKE);}
        
                                        if($tx_imagen_cen!=""){$c->add(Tb015EmpresaPeer::tx_imagen_cen,'%'.$tx_imagen_cen.'%',Criteria::LIKE);}
        
                                        if($nu_telefono!=""){$c->add(Tb015EmpresaPeer::nu_telefono,'%'.$nu_telefono.'%',Criteria::LIKE);}
        
                                        if($tx_sigla!=""){$c->add(Tb015EmpresaPeer::tx_sigla,'%'.$tx_sigla.'%',Criteria::LIKE);}
        
                                        if($op_imagen!=""){$c->add(Tb015EmpresaPeer::op_imagen,'%'.$op_imagen.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb015EmpresaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb015EmpresaPeer::CO_EMPRESA);
        
    $stmt = Tb015EmpresaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_empresa"     => trim($res["co_empresa"]),
            "nb_empresa"     => trim($res["nb_empresa"]),
            "co_estado"     => trim($res["co_estado"]),
            "co_municipio"     => trim($res["co_municipio"]),
            "tx_rif"     => trim($res["tx_rif"]),
            "tx_nit"     => trim($res["tx_nit"]),
            "tx_direccion"     => trim($res["tx_direccion"]),
            "tx_imagen_der"     => trim($res["tx_imagen_der"]),
            "tx_imagen_izq"     => trim($res["tx_imagen_izq"]),
            "tx_imagen_cen"     => trim($res["tx_imagen_cen"]),
            "nu_telefono"     => trim($res["nu_telefono"]),
            "tx_sigla"     => trim($res["tx_sigla"]),
            "op_imagen"     => trim($res["op_imagen"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                //modelo fk tb016_estado.CO_ESTADO
    public function executeStorefkcoestado(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb016EstadoPeer::doSelectStmt($c);
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
                    //modelo fk tb017_municipio.CO_MUNICIPIO
    public function executeStorefkcomunicipio(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb017MunicipioPeer::doSelectStmt($c);
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