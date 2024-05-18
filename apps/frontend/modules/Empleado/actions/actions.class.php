<?php

/**
 * autoEmpleado actions.
 * NombreClaseModel(Empleado)
 * NombreTabla(empleado)
 * @package    ##PROJECT_NAME##
 * @subpackage autoEmpleado
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class EmpleadoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Empleado', 'lista');
  }
  
  public function executeDetalleBeneficiario(sfWebRequest $request)
  {
       $this->cedula = $this->getRequestParameter("cedula");
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Empleado', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $cedula_titular = $this->getRequestParameter("cedula_titular");
    if($cedula_titular!=''||$cedula_titular!=null){
        $c = new Criteria();
        $c->add(EmpleadoPeer::CEDULA_TITULAR,$cedula_titular);
        $c->add(EmpleadoPeer::PARENTESCO,'TITULAR');
        
        $stmt = EmpleadoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "cedula_titular"     => $campos["cedula_titular"],
                            "nombre_apellido"     => $campos["nombre_apellido"],
                            "nacionalidad"     => $campos["nacionalidad"],
                            "parentesco"     => $campos["parentesco"],
                            "cedula"     => $campos["cedula"],
                            "fe_nacimiento"     => $campos["fe_nacimiento"],
                            "sexo"     => ($campos["sexo"]=='null')?$campos["sexo"]:'',
                            "tipo_empleado"     => $campos["tipo_empleado"],
                            "organismo"     => $campos["organismo"],
                            "co_empleado"     => $campos["co_empleado"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "cedula_titular"     => "",
                            "nombre_apellido"     => "",
                            "nacionalidad"     => "",
                            "parentesco"     => "",
                            "cedula"     => "",
                            "fe_nacimiento"     => "",
                            "sexo"     => "",
                            "tipo_empleado"     => "",
                            "organismo"     => "",
                            "co_empleado"     => "",
                    ));
    }

  }
  
  public function executeEditarBeneficiario(sfWebRequest $request)
  {
    $cedula = $this->getRequestParameter("cedula");
    if($cedula!=''||$cedula!=null){
        $c = new Criteria();
        $c->add(EmpleadoPeer::CEDULA_TITULAR,$cedula_titular);
        $c->add(EmpleadoPeer::PARENTESCO,'TITULAR');
        
        $stmt = EmpleadoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "cedula_titular"     => $campos["cedula_titular"],
                            "nombre_apellido"     => $campos["nombre_apellido"],
                            "nacionalidad"     => $campos["nacionalidad"],
                            "parentesco"     => $campos["parentesco"],
                            "cedula"     => $campos["cedula"],
                            "fe_nacimiento"     => $campos["fe_nacimiento"],
                            "sexo"     => ($campos["sexo"]=='null')?$campos["sexo"]:'',
                            "tipo_empleado"     => $campos["tipo_empleado"],
                            "organismo"     => $campos["organismo"],
                            "co_empleado"     => $campos["co_empleado"],
                    ));
    }else{
        $this->data = json_encode(array(
                "cedula_titular"     => $this->getRequestParameter("cedula_titular"),
                "nombre_apellido"     => "",
                "nacionalidad"     => "",
                "parentesco"     => "",
                "cedula"     => "",
                "fe_nacimiento"     => "",
                "sexo"     => "",
                "tipo_empleado"     => "",
                "organismo"     => "",
                "co_empleado"     => "",
        ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_empleado");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $empleado = EmpleadoPeer::retrieveByPk($codigo);
     }else{
         $empleado = new Empleado();
     }
     try
      { 
        $con->beginTransaction();
       
        $empleadoForm = $this->getRequestParameter('empleado');
/*CAMPOS*/
                                
        /*Campo tipo VARCHAR */
        $empleado->setCedulaTitular($empleadoForm["cedula_titular"]);
                                                        
        /*Campo tipo VARCHAR */
        $empleado->setNombreApellido($empleadoForm["nombre_apellido"]);
                                                        
        /*Campo tipo VARCHAR */
        $empleado->setNacionalidad($empleadoForm["nacionalidad"]);
                                                        
        /*Campo tipo VARCHAR */
        $empleado->setParentesco($empleadoForm["parentesco"]);
                                                        
        /*Campo tipo VARCHAR */
        $empleado->setCedula($empleadoForm["cedula"]);
                                                        
        /*Campo tipo VARCHAR */
        list($dia, $mes, $anio) = explode("/",$empleadoForm["fe_nacimiento"]);
        $fecha = $anio."-".$mes."-".$dia;        
        $empleado->setFeNacimiento($fecha);
                                                        
        /*Campo tipo VARCHAR */
        $empleado->setSexo($empleadoForm["sexo"]);
                                                        
        /*Campo tipo VARCHAR */
        $empleado->setTipoEmpleado($empleadoForm["tipo_empleado"]);
                                                        
        /*Campo tipo VARCHAR */
        $empleado->setOrganismo($empleadoForm["organismo"]);
                                        
        /*CAMPOS*/
        $empleado->save($con);
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
	$codigo = $this->getRequestParameter("co_empleado");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$empleado = EmpleadoPeer::retrieveByPk($codigo);			
	$empleado->delete($con);
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
    $limit      =   $this->getRequestParameter("limit",14);
    $start      =   $this->getRequestParameter("start",0);
            $cedula_titular      =   $this->getRequestParameter("cedula_titular");
            $nombre_apellido      =   $this->getRequestParameter("nombre_apellido");
            $nacionalidad      =   $this->getRequestParameter("nacionalidad");
            $parentesco      =   $this->getRequestParameter("parentesco");
            $cedula      =   $this->getRequestParameter("cedula");
            $fe_nacimiento      =   $this->getRequestParameter("fe_nacimiento");
            $sexo      =   $this->getRequestParameter("sexo");
            $tipo_empleado      =   $this->getRequestParameter("tipo_empleado");
            $organismo      =   $this->getRequestParameter("organismo");
        
    
    $c = new Criteria();   

    
    if($cedula_titular!=""){$c->add(EmpleadoPeer::CEDULA_TITULAR,'%'.$cedula_titular.'%',Criteria::LIKE);}

    if($nombre_apellido!=""){$c->add(EmpleadoPeer::NOMBRE_APELLIDO,'%'.$nombre_apellido.'%',Criteria::LIKE);}

    if($nacionalidad!=""){$c->add(EmpleadoPeer::NACIONALIDAD,'%'.$nacionalidad.'%',Criteria::LIKE);}

    $c->add(EmpleadoPeer::PARENTESCO,'TITULAR',Criteria::LIKE);

    if($cedula!=""){$c->add(EmpleadoPeer::CEDULA,'%'.$cedula.'%',Criteria::LIKE);}

    if($fe_nacimiento!=""){$c->add(EmpleadoPeer::FE_NACIMIENTO,'%'.$fe_nacimiento.'%',Criteria::LIKE);}

    if($sexo!=""){$c->add(EmpleadoPeer::SEXO,'%'.$sexo.'%',Criteria::LIKE);}

    if($tipo_empleado!=""){$c->add(EmpleadoPeer::TIPO_EMPLEADO,'%'.$tipo_empleado.'%',Criteria::LIKE);}

    if($organismo!=""){$c->add(EmpleadoPeer::ORGANISMO,'%'.$organismo.'%',Criteria::LIKE);}

    
    
    $c->setIgnoreCase(true);
    $cantidadTotal = EmpleadoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(EmpleadoPeer::CO_EMPLEADO);
        
    $stmt = EmpleadoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        list($anio, $mes, $dia) = explode("-",$res["fe_nacimiento"]);
        $fecha = $dia."/".$mes."/".$anio;   
        
        $registros[] = array(
                "cedula_titular"     => trim($res["cedula_titular"]),
                "nombre_apellido"     => trim($res["nombre_apellido"]),
                "nacionalidad"     => trim($res["nacionalidad"]),
                "parentesco"     => trim($res["parentesco"]),
                "cedula"     => trim($res["cedula"]),
                "nac_cedula"     => trim($res["cedula"]),
                "fe_nacimiento"     => trim($fecha),
                "sexo"     => trim(($res["sexo"]==NULL)?$res["sexo"]:''),
                "tipo_empleado"     => trim($res["tipo_empleado"]),
                "organismo"     => trim($res["organismo"]),
                "co_empleado"     => trim($res["co_empleado"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }
    
    public function executeStorelistaBeneficiario(sfWebRequest $request)
    {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
            $cedula_titular      =   $this->getRequestParameter("cedula_titular");
            $nombre_apellido      =   $this->getRequestParameter("nombre_apellido");
            $nacionalidad      =   $this->getRequestParameter("nacionalidad");
            $parentesco      =   $this->getRequestParameter("parentesco");
            $cedula      =   $this->getRequestParameter("cedula");
            $fe_nacimiento      =   $this->getRequestParameter("fe_nacimiento");
            $sexo      =   $this->getRequestParameter("sexo");
            $tipo_empleado      =   $this->getRequestParameter("tipo_empleado");
            $organismo      =   $this->getRequestParameter("organismo");
        
    
    $c = new Criteria();   

    
    if($cedula_titular!=""){$c->add(EmpleadoPeer::CEDULA_TITULAR,'%'.$cedula_titular.'%',Criteria::LIKE);}

    if($nombre_apellido!=""){$c->add(EmpleadoPeer::NOMBRE_APELLIDO,'%'.$nombre_apellido.'%',Criteria::LIKE);}

    if($nacionalidad!=""){$c->add(EmpleadoPeer::NACIONALIDAD,'%'.$nacionalidad.'%',Criteria::LIKE);}

    $c->add(EmpleadoPeer::PARENTESCO,'TITULAR',Criteria::NOT_EQUAL);

    if($cedula!=""){$c->add(EmpleadoPeer::CEDULA,'%'.$cedula.'%',Criteria::LIKE);}

    if($fe_nacimiento!=""){$c->add(EmpleadoPeer::FE_NACIMIENTO,'%'.$fe_nacimiento.'%',Criteria::LIKE);}

    if($sexo!=""){$c->add(EmpleadoPeer::SEXO,'%'.$sexo.'%',Criteria::LIKE);}

    if($tipo_empleado!=""){$c->add(EmpleadoPeer::TIPO_EMPLEADO,'%'.$tipo_empleado.'%',Criteria::LIKE);}

    if($organismo!=""){$c->add(EmpleadoPeer::ORGANISMO,'%'.$organismo.'%',Criteria::LIKE);}

    
    
    $c->setIgnoreCase(true);
    $cantidadTotal = EmpleadoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(EmpleadoPeer::CO_EMPLEADO);
        
    $stmt = EmpleadoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "cedula_titular"     => trim($res["cedula_titular"]),
            "nombre_apellido"     => trim($res["nombre_apellido"]),
            "nacionalidad"     => trim($res["nacionalidad"]),
            "parentesco"     => trim($res["parentesco"]),
            "cedula"     => trim($res["nacionalidad"].'-'.$res["cedula"]),
            "fe_nacimiento"     => trim($res["fe_nacimiento"]),
            "sexo"     => trim($res["sexo"]),
            "tipo_empleado"     => trim($res["tipo_empleado"]),
            "organismo"     => trim($res["organismo"]),
            "co_empleado"     => trim($res["co_empleado"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }
    
    public function executeStorelistaTipoEmpleado(sfWebRequest $request){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->setDistinct();
        $c->addSelectColumn(EmpleadoPeer::TIPO_EMPLEADO);
        $stmt = EmpleadoPeer::doSelectStmt($c);
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

    public function executeStorelistaOrganimo(sfWebRequest $request){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->setDistinct();
        $c->addSelectColumn(EmpleadoPeer::ORGANISMO);
        $stmt = EmpleadoPeer::doSelectStmt($c);
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
    
     public function executeStorelistaSexo(sfWebRequest $request){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->setDistinct();
        $c->addSelectColumn(EmpleadoPeer::SEXO);
        $c->add(EmpleadoPeer::SEXO,'NULL', Criteria::NOT_EQUAL);
        $stmt = EmpleadoPeer::doSelectStmt($c);
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
    
     public function executeStorelistaParentesco(sfWebRequest $request){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->setDistinct();
        $c->addSelectColumn(EmpleadoPeer::PARENTESCO);
        $stmt = EmpleadoPeer::doSelectStmt($c);
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