<?php

/**
 * Egreso actions.
 *
 * @package    gobel
 * @subpackage Egreso
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class EgresoActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
        $this->data = $this->data = json_encode(array(
            "co_solicitud"             => $this->getRequestParameter("co_solicitud")
        ));
  }
  
  public function executeAprobacion(sfWebRequest $request)
  {
        $this->data = $this->data = json_encode(array(
            "co_solicitud"             => $this->getRequestParameter("co_solicitud")
        ));
  }
  
  public function executeEditar(sfWebRequest $request)
  {
     $codigo = $this->getRequestParameter("codigo");
     $this->DatosEmpleado($codigo);
  }
  
  protected function DatosFicha($co_trabajador){
       
        $c = new Criteria();
        $c->add(Tbrh002FichaPeer::CO_TRABAJADOR,$co_trabajador);
        $c->add(Tbrh002FichaPeer::CO_ESTATUS,1);
        
        $stmt = Tbrh002FichaPeer::doSelectStmt($c);
        
        $registros = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $registros;
  }

  
  public function executeGuardarAprobacion(sfWebRequest $request)
  {
        $json_co_nom_trabajador = $this->getRequestParameter('json_co_nom_trabajador');
        $co_solicitud           = $this->getRequestParameter('co_solicitud');
        
        $con = Propel::getConnection();        
        
        $array = array();
        $array = explode(",",$json_co_nom_trabajador);
        
        foreach ($array as $key => $value) {    
  

            $c = new Criteria();
            $c->addJoin(Tbrh099EgresoPeer::CO_EGRESO,Tbrh104NomTrabajadorEgresoPeer::CO_EGRESO);
            $c->add(Tbrh104NomTrabajadorEgresoPeer::CO_NOM_TRABAJADOR,$value);
            $stmt = Tbrh099EgresoPeer::doSelectStmt($c);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            
            
           
            
           
            $Tbrh015NomTrabajador = Tbrh015NomTrabajadorPeer::retrieveByPK($value);
            $Tbrh015NomTrabajador->setFeFiniquito($res["fe_egreso"])
                                 ->setInActivo(false)
                                 ->setCoNomSituacion($res["co_nom_situacion"])
                                 ->save($con); 
            
            $wherec = new Criteria();
            $wherec->add(Tbrh104nomtrabajadoregresoPeer::CO_NOM_TRABAJADOR, $value);

            $updc = new Criteria();
            $updc->add(Tbrh104nomtrabajadoregresoPeer::IN_PROCESADO, true);
            BasePeer::doUpdate($wherec, $updc, $con);  
            
            
            $c = new Criteria();
            $c->add(Tbrh015NomTrabajadorPeer::CO_FICHA,$Tbrh015NomTrabajador->getCoFicha());
            $c->add(Tbrh015NomTrabajadorPeer::IN_ACTIVO,TRUE);

            $cantidad = Tbrh015NomTrabajadorPeer::doCount($c);

            if($cantidad == 0){
                $tbrh002_ficha = Tbrh002FichaPeer::retrieveByPK($Tbrh015NomTrabajador->getCoFicha());
                $tbrh002_ficha->setFeFiniquito($res["fe_finiquito"])
                              ->setCoEstatus(2)
                              ->setInActivo(false)
                              ->save($con);
            }           
            
        }
        
        $con->commit();
        
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));      
        
        $ruta->setInCargarDato(true)->save($con);
        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta()); 
         $con->commit();
        
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'El egreso se proceso exitosamente'
        ));
        
         
      
  }
  
  
  public function executeGuardar(sfWebRequest $request)
  {
      
    $tbrh099_egresoForm = $this->getRequestParameter('egreso');
    $json_co_nom_trabajador = $this->getRequestParameter("json_co_nom_trabajador");
      
    $con = Propel::getConnection();
    if($tbrh099_egresoForm["co_egreso"]!=''){
         $tbrh099_egreso = Tbrh099EgresoPeer::retrieveByPk($tbrh099_egresoForm["co_egreso"]);
    }else{
         $tbrh099_egreso = new Tbrh099Egreso();
    }
    try
      {
        $con->beginTransaction();
               
        list($dia,$mes,$anio) = explode("/",$tbrh099_egresoForm["fe_egreso"]);
        $fe_egreso = $anio.'-'.$mes.'-'.$dia;
        
        list($dia,$mes,$anio) = explode("/",$tbrh099_egresoForm["fe_movimiento"]);
        $fe_movimiento = $anio.'-'.$mes.'-'.$dia;        
        
        $nom_trabajador = $this->DatosFicha($tbrh099_egresoForm["co_trabajador"]);
             
        $in_soporte     = (isset($tbrh099_egresoForm["in_soporte"]))?TRUE:FALSE;
        $in_cedula      = (isset($tbrh099_egresoForm["in_cedula"]))?TRUE:FALSE;
        $in_declaracion = (isset($tbrh099_egresoForm["in_declaracion"]))?TRUE:FALSE;   
                
        $tbrh099_egreso->setCoTrabajador($tbrh099_egresoForm["co_trabajador"])
                       ->setCoSolicitud($tbrh099_egresoForm["co_solicitud"])
                       ->setFeEgreso($fe_egreso)
                       ->setCoFicha($nom_trabajador["co_ficha"])
                       ->setCoNomTrabajador($nom_trabajador["co_nom_trabajador"])
                       ->setFeMovimiento($fe_movimiento)
                       ->setTxMotivo($tbrh099_egresoForm["tx_motivo"])
                       ->setInSoporte($in_soporte)
                       ->setInCedula($in_cedula)
                       ->setCoNomSituacion($tbrh099_egresoForm["co_nom_situacion"])
                       ->setInDeclaracion($in_declaracion)
                       ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                       ->save($con);
        
        $array = array();
        $array = explode(",",$json_co_nom_trabajador);
        
        foreach ($array as $key => $value) {                 
               
                $Tbrh104NomTrabajadorEgreso = new Tbrh104NomTrabajadorEgreso();
                $Tbrh104NomTrabajadorEgreso->setFeFiniquito($fe_egreso)
                                           ->setCoEgreso($tbrh099_egreso->getCoEgreso())
                                           ->setCoNomTrabajador($value)
                                           ->save($con);
            
        } 
        $con->commit();
        
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tbrh099_egresoForm["co_solicitud"]));      
        
        $ruta->setInCargarDato(true)->save($con);
        
    
        $con->commit();
        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'El egreso se guardo exitosamente',
                    "co_solicitud"  => $tbrh099_egresoForm["co_solicitud"]
                ));
       
        
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
	$codigo    = $this->getRequestParameter("co_egreso");
        $co_ficha  = $this->getRequestParameter("co_ficha");
        
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$egreso = Tbrh099EgresoPeer::retrieveByPk($codigo);			
	$egreso->delete($con);
        
        
        $wherec = new Criteria();
        $wherec->add(Tbrh104NomTrabajadorEgresoPeer::CO_EGRESO, $codigo);
        BasePeer::doDelete($wherec, $con);
        
        
//        $ficha = Tbrh002FichaPeer::retrieveByPk($co_ficha);			
//        $ficha->setInActivo(TRUE);
//        $ficha->setCoEstatus(1);
//	  $ficha->save($con);
        
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
  
  public function executeVerificarTrabajador(sfWebRequest $request)
  {
  
        $co_documento  = $this->getRequestParameter('co_documento');
        $nu_cedula     = $this->getRequestParameter('nu_cedula');

        $c = new Criteria();        
        $c->addJoin(Tbrh001TrabajadorPeer::CO_TRABAJADOR,Tbrh002FichaPeer::CO_TRABAJADOR);
        $c->add(Tbrh001TrabajadorPeer::CO_DOCUMENTO,$co_documento);
        $c->add(Tbrh001TrabajadorPeer::NU_CEDULA,$nu_cedula);
        //$c->add(Tbrh002FichaPeer::CO_ESTATUS,1);
        $stmt = Tbrh001TrabajadorPeer::doSelectStmt($c);

        $registros = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagen = new myConfig();
        
        
        if ($registros["co_trabajador"]!=''){            
            if (file_exists($registros["tx_ruta_imagen"])) {            
                $imagen->setConvertToURL($registros["tx_ruta_imagen"]);
                $registros["foto"] = $imagen->getConvertToURL();
            } else {
                $foto = $imagen->getDirectorio().'foto/bust-in-silhouette.png';
                $imagen->setConvertToURL($foto);
                $registros["foto"] = $imagen->getConvertToURL();
            }   
        }
        
        
        
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        $this->setTemplate('store');
    
  }
  
  protected function DatosEmpleado($codigo){
      
        
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_TRABAJADOR);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tbrh099EgresoPeer::CO_TP_NOMINA);
        $c->addSelectColumn(Tbrh099EgresoPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tbrh099EgresoPeer::CO_CARGO);
        $c->addSelectColumn(Tbrh099EgresoPeer::TX_MOTIVO);
        $c->addSelectColumn(Tbrh099EgresoPeer::IN_SOPORTE);
        $c->addSelectColumn(Tbrh099EgresoPeer::IN_CEDULA);
        $c->addSelectColumn(Tbrh099EgresoPeer::IN_DECLARACION);
        $c->addSelectColumn(Tbrh099EgresoPeer::FE_EGRESO);
        $c->addSelectColumn(Tbrh099EgresoPeer::FE_MOVIMIENTO);
        
        $c->addJoin(Tbrh001TrabajadorPeer::CO_TRABAJADOR, Tbrh099EgresoPeer::CO_TRABAJADOR);
        $c->add(Tbrh001TrabajadorPeer::CO_TRABAJADOR,$codigo);
        
        $stmt = Tbrh001TrabajadorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);       
      
        $imagen = new myConfig();
        
        if (file_exists($campos["tx_ruta_imagen"])) {            
            $imagen->setConvertToURL($campos["tx_ruta_imagen"]);
        } else {
            $foto = $imagen->getDirectorio().'foto/bust-in-silhouette.png';
            $imagen->setConvertToURL($foto);
        }        
        
        $foto = $imagen->getConvertToURL();
            
        $this->data = json_encode(array(
                        "co_trabajador"             => $campos["co_trabajador"],
                        "nu_cedula"                 => $campos["nu_cedula"],
                        "nb_primer_nombre"          => $campos["nb_primer_nombre"],
                        "nb_segundo_nombre"         => $campos["nb_segundo_nombre"],
                        "nb_primer_apellido"        => $campos["nb_primer_apellido"],
                        "nb_segundo_apellido"       => $campos["nb_segundo_apellido"],
                        "co_documento"              => $campos["co_documento"],
                        "co_solicitud"              => $campos["co_solicitud"],
                        "co_tp_nomina"              => $campos["co_tp_nomina"],
                        "co_cargo"                  => $campos["co_cargo"],
                        "tx_motivo"                 => $campos["tx_motivo"],
                        "in_soporte"                => $campos["in_soporte"],
                        "in_cedula"                 => $campos["in_cedula"],
                        "in_declaracion"            => $campos["in_declaracion"],
                        "fe_egreso"                 => $campos["fe_egreso"],
                        "fe_movimiento"             => $campos["fe_movimiento"]
                ));
    }else{
        
                    $imagen = new myConfig();
                    $foto = $imagen->getDirectorio().'foto/bust-in-silhouette.png';
                    $imagen->setConvertToURL($foto);
                    $foto = $imagen->getConvertToURL();
        
                $this->data = json_encode(array(
                        "co_trabajador"               => "",
                        "nu_cedula"                   => "",
                        "nb_primer_nombre"            => "",
                        "nb_segundo_nombre"           => "",
                        "nb_primer_apellido"          => "",
                        "nb_segundo_apellido"         => "",
                        "co_documento"                => "",
                        "co_solicitud"                => $this->getRequestParameter("co_solicitud"),
                        "co_tp_nomina"                => "",
                        "co_cargo"                    => "",
                        "tx_motivo"                   => "",
                        "in_soporte"                  => "",
                        "in_cedula"                   => "",
                        "in_declaracion"              => "",
                        "fe_egreso"                   => "",
                        "fe_movimiento"               => "",
                        "foto"                        => $foto
                ));
    }
      
  }
  
  public function executeStorefkconomina(sfWebRequest $request){
      
        $co_trabajador  = $this->getRequestParameter('co_trabajador');
       
        $c = new Criteria();
        $c->addJoin(Tbrh017TpNominaPeer::CO_TP_NOMINA, Tbrh015NomTrabajadorPeer::CO_TP_NOMINA);
        $c->addJoin(Tbrh015NomTrabajadorPeer::CO_FICHA, Tbrh002FichaPeer::CO_FICHA);
        $c->add(Tbrh002FichaPeer::CO_TRABAJADOR,$co_trabajador);
        $c->add(Tbrh002FichaPeer::CO_ESTATUS,1);
        $stmt = Tbrh017TpNominaPeer::doSelectStmt($c);
        
        $registros = array();
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = array(
                "co_tp_nomina" => trim($res["co_tp_nomina"]),
                "tx_tp_nomina" => trim($res["tx_tp_nomina"])
            );
        }
        
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        $this->setTemplate('store');
      
  }
  
  public function executeStorefkcocargo(sfWebRequest $request){
      
        $co_trabajador  = $this->getRequestParameter('co_trabajador');
        $co_tp_nomina  = $this->getRequestParameter('co_tp_nomina');
       
        $c = new Criteria();
        $c->addJoin(Tbrh032CargoPeer::CO_CARGO, Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA);
        $c->addJoin(Tbrh015NomTrabajadorPeer::CO_FICHA, Tbrh002FichaPeer::CO_FICHA);
        $c->add(Tbrh002FichaPeer::CO_TRABAJADOR,$co_trabajador);
        $c->add(Tbrh015NomTrabajadorPeer::CO_TP_NOMINA,$co_tp_nomina);
        $c->add(Tbrh002FichaPeer::CO_ESTATUS,1);
        $stmt = Tbrh032CargoPeer::doSelectStmt($c);
        
        $registros = array();
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = array(
                "co_cargo" => trim($res["co_cargo"]),
                "tx_cargo" => trim($res["tx_cargo"])
            );
        }
        
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        $this->setTemplate('store');
      
  }
  
  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
          
    $co_solicitud      =   $this->getRequestParameter("co_solicitud");    
    
    $c = new Criteria();  
    $c->clearSelectColumns();
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_TRABAJADOR);
    $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
    $c->addSelectColumn(Tbrh099EgresoPeer::FE_EGRESO);
    $c->addSelectColumn(Tbrh099EgresoPeer::FE_MOVIMIENTO);
    $c->addSelectColumn(Tbrh099EgresoPeer::TX_MOTIVO);
    $c->addSelectColumn(Tbrh099EgresoPeer::CO_EGRESO);
    $c->addSelectColumn(Tbrh099EgresoPeer::CO_FICHA);
    $c->addSelectColumn(Tbrh024NomSituacionPeer::TX_NOM_SITUACION);
    $c->addSelectColumn(Tbrh104NomTrabajadorEgresoPeer::CO_NOM_TRABAJADOR);
    $c->addSelectColumn(Tbrh032CargoPeer::TX_CARGO);
    $c->addSelectColumn(Tbrh104NomTrabajadorEgresoPeer::IN_PROCESADO);
    $c->addSelectColumn(Tbrh067GrupoNominaPeer::TX_GRUPO_NOMINA);
    $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
    
    $c->addJoin(Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA, Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);
    $c->addJoin(Tbrh015NomTrabajadorPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
    $c->addJoin(Tbrh032CargoPeer::CO_CARGO, Tbrh009CargoEstructuraPeer::CO_CARGO);
    $c->addJoin(Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA, Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA);
    $c->addJoin(Tbrh104nomtrabajadoregresoPeer::CO_NOM_TRABAJADOR, Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR);
    $c->addJoin(Tbrh104nomtrabajadoregresoPeer::CO_EGRESO, Tbrh099EgresoPeer::CO_EGRESO);
    $c->addJoin(Tbrh002FichaPeer::CO_FICHA, Tbrh015NomTrabajadorPeer::CO_FICHA);
    $c->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
    $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tbrh001TrabajadorPeer::CO_DOCUMENTO);
    $c->addJoin(Tbrh099EgresoPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
    $c->addJoin(Tbrh099EgresoPeer::CO_NOM_SITUACION, Tbrh024NomSituacionPeer::CO_NOM_SITUACION);
    
    $c->add(Tbrh099EgresoPeer::CO_SOLICITUD,$co_solicitud);    
    
    //echo $c->toString(); exit();
    
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh001TrabajadorPeer::doCount($c);
    
    $c->addAscendingOrderByColumn(Tbrh001TrabajadorPeer::CO_TRABAJADOR);
        
    $stmt = Tbrh001TrabajadorPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        list($anio,$mes,$dia) = explode("-",$res["fe_egreso"]);
        $fe_egreso = $dia.'-'.$mes.'-'.$anio;
        
        list($anio,$mes,$dia) = explode("-",$res["fe_movimiento"]);
        $fe_movimiento = $dia.'-'.$mes.'-'.$anio;
        
        $registros[] = array(
            "co_trabajador"      => trim($res["co_trabajador"]),
            "co_nom_trabajador"      => trim($res["co_nom_trabajador"]),
            "co_egreso"          => $res["co_egreso"],
            "co_ficha"           => $res["co_ficha"],
            "in_procesado"       => ($res["in_procesado"]==true)?'<b>Procesado<b>':'Pendiente',
            "nu_cedula"          => trim($res["inicial"]).'-'.trim($res["nu_cedula"]),
            "nb_primer_nombre"   => trim($res["nb_primer_nombre"]).' '.trim($res["nb_segundo_nombre"]).' '.trim($res["nb_primer_apellido"]).' '.trim($res["nb_segundo_apellido"]),
            "co_documento"       => trim($res["co_documento"]),
            "fe_egreso"          => trim($res["fe_egreso"]),
            "fe_movimiento"      => trim($res["fe_movimiento"]),
            "tx_nom_situacion"   => trim($res["tx_nom_situacion"]),
            "tx_cargo"           => trim($res["tx_cargo"]),
            "tx_grupo_nomina"        => $res["tx_grupo_nomina"],
            "tx_tp_nomina"           => $res["tx_tp_nomina"],
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }
      
    public function executeStorefkconomsituacion(sfWebRequest $request){
       
        $c = new Criteria();
        $stmt = Tbrh024NomSituacionPeer::doSelectStmt($c);
        
        $registros = array();
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = array(
                "co_nom_situacion" => trim($res["co_nom_situacion"]),
                "tx_nom_situacion" => trim($res["tx_nom_situacion"])
            );
        }
        
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        $this->setTemplate('store');
      
    }
}
