<?php

/**
 * autoPersona actions.
 * NombreClaseModel(Tb109Persona)
 * NombreTabla(tb109_persona)
 * @package    ##PROJECT_NAME##
 * @subpackage autoPersona
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class PersonaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Persona', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Persona', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb109PersonaPeer::CO_PERSONA,$codigo);
        
        $stmt = Tb109PersonaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_persona"     => $campos["co_persona"],
                            "nb_persona"     => $campos["nb_persona"],
                            "ap_persona"     => $campos["ap_persona"],
                            "nu_cedula"     => $campos["nu_cedula"],
                            "co_documento"     => $campos["co_documento"],
                            "co_cargo"     => $campos["co_cargo"],
                            "co_nivel_organizacional"     => $campos["co_nivel_organizacional"],
                            "co_nivel_trabajador"     => $campos["co_nivel_trabajador"],
                            "nu_celular"     => $campos["nu_celular"],
                            "nu_extension"     => $campos["nu_extension"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_persona"     => "",
                            "nb_persona"     => "",
                            "ap_persona"     => "",
                            "nu_cedula"     => "",
                            "co_documento"     => "",
                            "co_cargo"     => "",
                            "co_nivel_organizacional"     => "",
                            "co_nivel_trabajador"     => "",
                            "nu_celular"     => "",
                            "nu_extension"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_persona");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb109_persona = Tb109PersonaPeer::retrieveByPk($codigo);
     }else{
         $tb109_persona = new Tb109Persona();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb109_personaForm = $this->getRequestParameter('tb109_persona');
                                        
        /*Campo tipo VARCHAR */
        $tb109_persona->setNbPersona($tb109_personaForm["nb_persona"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb109_persona->setApPersona($tb109_personaForm["ap_persona"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb109_persona->setNuCedula($tb109_personaForm["nu_cedula"]);
                                                        
        /*Campo tipo BIGINT */
        $tb109_persona->setCoDocumento($tb109_personaForm["co_documento"]);
                                                        
        /*Campo tipo BIGINT */
        $tb109_persona->setCoCargo($tb109_personaForm["co_cargo"]);
                                                        
        /*Campo tipo BIGINT */
        $tb109_persona->setCoNivelOrganizacional($tb109_personaForm["co_nivel_organizacional"]);
                                                        
        /*Campo tipo BIGINT */
        $tb109_persona->setCoNivelTrabajador($tb109_personaForm["co_nivel_trabajador"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb109_persona->setNuCelular($tb109_personaForm["nu_celular"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb109_persona->setNuExtension($tb109_personaForm["nu_extension"]);
                                
        /*CAMPOS*/
        $tb109_persona->save($con);
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
	$codigo = $this->getRequestParameter("co_persona");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb109_persona = Tb109PersonaPeer::retrieveByPk($codigo);			
	$tb109_persona->delete($con);
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
                $nb_persona      =   $this->getRequestParameter("nb_persona");
            $ap_persona      =   $this->getRequestParameter("ap_persona");
            $nu_cedula      =   $this->getRequestParameter("nu_cedula");
            $co_documento      =   $this->getRequestParameter("co_documento");
            $co_cargo      =   $this->getRequestParameter("co_cargo");
            $co_nivel_organizacional      =   $this->getRequestParameter("co_nivel_organizacional");
            $co_nivel_trabajador      =   $this->getRequestParameter("co_nivel_trabajador");
            $nu_celular      =   $this->getRequestParameter("nu_celular");
            $nu_extension      =   $this->getRequestParameter("nu_extension");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($nb_persona!=""){$c->add(Tb109PersonaPeer::nb_persona,'%'.$nb_persona.'%',Criteria::LIKE);}
        
                                        if($ap_persona!=""){$c->add(Tb109PersonaPeer::ap_persona,'%'.$ap_persona.'%',Criteria::LIKE);}
        
                                            if($nu_cedula!=""){$c->add(Tb109PersonaPeer::nu_cedula,$nu_cedula);}
    
                                            if($co_documento!=""){$c->add(Tb109PersonaPeer::co_documento,$co_documento);}
    
                                            if($co_cargo!=""){$c->add(Tb109PersonaPeer::co_cargo,$co_cargo);}
    
                                            if($co_nivel_organizacional!=""){$c->add(Tb109PersonaPeer::co_nivel_organizacional,$co_nivel_organizacional);}
    
                                            if($co_nivel_trabajador!=""){$c->add(Tb109PersonaPeer::co_nivel_trabajador,$co_nivel_trabajador);}
    
                                        if($nu_celular!=""){$c->add(Tb109PersonaPeer::nu_celular,'%'.$nu_celular.'%',Criteria::LIKE);}
        
                                        if($nu_extension!=""){$c->add(Tb109PersonaPeer::nu_extension,'%'.$nu_extension.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb109PersonaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb109PersonaPeer::CO_PERSONA);
        
    $stmt = Tb109PersonaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_persona"     => trim($res["co_persona"]),
            "nb_persona"     => trim($res["nb_persona"]),
            "ap_persona"     => trim($res["ap_persona"]),
            "nu_cedula"     => trim($res["nu_cedula"]),
            "co_documento"     => trim($res["co_documento"]),
            "co_cargo"     => trim($res["co_cargo"]),
            "co_nivel_organizacional"     => trim($res["co_nivel_organizacional"]),
            "co_nivel_trabajador"     => trim($res["co_nivel_trabajador"]),
            "nu_celular"     => trim($res["nu_celular"]),
            "nu_extension"     => trim($res["nu_extension"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                        //modelo fk tb007_documento.CO_DOCUMENTO
    public function executeStorefkcodocumento(sfWebRequest $request){
        $c = new Criteria();
        //$c->add(Tb007DocumentoPeer::TIPO,'N');
        $stmt = Tb007DocumentoPeer::doSelectStmt($c);
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
                    //modelo fk tb110_cargo.CO_CARGO
    public function executeStorefkcocargo(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb110CargoPeer::doSelectStmt($c);
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
                    //modelo fk tb111_nivel_organizacional.CO_NIVEL_ORGANIZACIONAL
    public function executeStorefkconivelorganizacional(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb111NivelOrganizacionalPeer::doSelectStmt($c);
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
                    //modelo fk tb112_nivel_trabajador.CO_NIVEL_TRABAJADOR
    public function executeStorefkconiveltrabajador(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb112NivelTrabajadorPeer::doSelectStmt($c);
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