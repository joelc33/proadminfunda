<?php

/**
 * CrearPartidaIngreso actions.
 *
 * @package    gobel
 * @subpackage CrearPartidaIngreso
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class CrearPartidaIngresoActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('CrearPartida', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('CrearPartida', 'editar');
  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    $co_solicitud =  $this->getRequestParameter("co_solicitud");  
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb178CreacionPartidaIngresoPeer::CO_CREACION_PARTIDA,$codigo);
        
        $stmt = Tb178CreacionPartidaIngresoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_creacion_partida"       => $campos["co_creacion_partida"],
                            "co_fuente_financiamiento"  => $campos["co_fuente_financiamiento"],
                            "co_numero_fuente"          => $campos["co_numero_fuente"],
                            "co_ente_ejecutor"          => $campos["co_ente_ejecutor"],
                            "co_proyecto"               => $campos["co_proyecto"],
                            "co_accion_especifica"      => $campos["co_accion_especifica"],
                            "co_partida"                => $campos["co_partida"],
                            "nu_anio"                   => $campos["nu_anio"],
                            "tx_descripcion"            => $campos["tx_descripcion"],
                            "tx_partida"                => $campos["tx_partida"],
                            "nu_monto"                  => $campos["nu_monto"],
                            "co_solicitud"              => $campos["co_solicitud"],
                            "co_usuario"                => $campos["co_usuario"],
                            "co_estatus"                => $campos["co_estatus"],
                            "co_usuario_cambio"         => $campos["co_usuario_cambio"],
                            "fe_cambio"                 => $campos["fe_cambio"],
                            "co_aplicacion"             => $campos["co_aplicacion"],
                            "co_ambito"                 => $campos["co_ambito"],
                            "co_tipo_ingreso"           => $campos["co_tipo_ingreso"],
                            "tx_partida"                => $campos["tx_partida"]
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_creacion_partida"          => "",
                            "co_fuente_financiamiento"     => "",
                            "co_numero_fuente"             => "",
                            "co_ente_ejecutor"             => "",
                            "co_proyecto"                  => "",
                            "co_accion_especifica"         => "",
                            "co_partida"                   => "",
                            "nu_anio"                      => "",
                            "tx_descripcion"               => "",
                            "tx_partida"                   => "",
                            "nu_monto"                     => "",
                            "co_solicitud"                 => $co_solicitud,
                            "co_usuario"                   => "",
                            "co_estatus"                   => "",
                            "co_usuario_cambio"            => "",
                            "fe_cambio"                    => "",
                            "co_aplicacion"                => "",
                            "co_ambito"                    => "",
                            "co_tipo_ingreso"              => "",
                            "tx_partida"                   => ""
                    ));
    }

  }
  
  public function executeEliminar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_creacion_partida");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	
	$tb178_creacion_partida_ingreso = Tb178CreacionPartidaIngresoPeer::retrieveByPK($codigo);			
	$tb178_creacion_partida_ingreso->delete($con);
        
        $c = new Criteria();
        $c->add(Tb178CreacionPartidaIngresoPeer::CO_SOLICITUD,$tb178_creacion_partida_ingreso->getCoSolicitud());
        $cant = Tb178CreacionPartidaIngresoPeer::doCount($c);
        
        if($cant==0){
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb178_creacion_partida_ingreso->getCoSolicitud()));
            $ruta->setInCargarDato(false)->save($con);
        }
        
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
		    "msg" => 'No es posible eliminar el registro'
		));
	}
  }

  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_creacion_partida");
     $tb178_creacion_partida_ingresoForm = $this->getRequestParameter('tb178_creacion_partida_ingreso');
    
    $c = new Criteria();
    $c->add(Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO,$tb178_creacion_partida_ingresoForm["co_partida"]);
    $stmt = Tb064PresupuestoIngresoPeer::doSelectStmt($c);
    $registros = $stmt->fetch(PDO::FETCH_ASSOC); 
     
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb178_creacion_partida_ingreso = Tb178CreacionPartidaIngresoPeer::retrieveByPk($codigo);
         $cantidad=0;
     }else{
        $tb178_creacion_partida_ingreso = new Tb178CreacionPartidaIngreso();
        $tb178_creacion_partida_ingreso->setNuAnio($this->getUser()->getAttribute('ejercicio'));
         
        $c = new Criteria();     
        $c->add(Tb178CreacionPartidaIngresoPeer::CO_PARTIDA,$tb178_creacion_partida_ingresoForm["co_partida"]);
        $c->add(Tb178CreacionPartidaIngresoPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));
        $cantidad = 0; //Tb178CreacionPartidaIngresoPeer::doCount($c);  
         
     }
     try
      { 
        $con->beginTransaction();        
        
        if($cantidad > 0){
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  "La partida ya se encuentra registrada"
             ));
        }else{
            
            if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
                $fecha = $this->getUser()->getAttribute('fe_cierre'); 
            }else{
                $fecha = date("Y-m-d H:i:s");
            }  
            
          
            $tb178_creacion_partida_ingreso->setCreatedAt($fecha);
            $tb178_creacion_partida_ingreso->setCoPartida($tb178_creacion_partida_ingresoForm["co_partida"]);        
            $tb178_creacion_partida_ingreso->setTxDescripcion($tb178_creacion_partida_ingresoForm["tx_descripcion"]);
            $tb178_creacion_partida_ingreso->setNuPartida($registros["nu_partida"]);
            $tb178_creacion_partida_ingreso->setCoSolicitud($tb178_creacion_partida_ingresoForm["co_solicitud"]);
            $tb178_creacion_partida_ingreso->setCoUsuario($this->getUser()->getAttribute('codigo'));
            $tb178_creacion_partida_ingreso->setCoAplicacion($tb178_creacion_partida_ingresoForm["co_aplicacion"]);
            $tb178_creacion_partida_ingreso->setNuPartidaDesagregada($registros["nu_partida"].$tb178_creacion_partida_ingresoForm["tx_partida"]);
            $tb178_creacion_partida_ingreso->setTxPartida($tb178_creacion_partida_ingresoForm["tx_partida"]);
            $tb178_creacion_partida_ingreso->setCoEstatus(1);

            $con->commit();
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb178_creacion_partida_ingresoForm["co_solicitud"]));
            $ruta->setInCargarDato(true)->save($con);

            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());                 

            $con->commit();
       
            $tb178_creacion_partida_ingreso->save($con);
            $this->data = json_encode(array(
                        "success" => true,
                        "msg" => 'Modificación realizada exitosamente'
                    ));
            $con->commit();
        
        }
      }catch (PropelException $e)
      {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage()
        ));
      }
    }
  

  public function executeCargarDisponible(sfWebRequest $request) {
      
        $co_partida               = $this->getRequestParameter('co_partida');
               
        $c = new Criteria();
        $c->add(Tb064PresupuestoIngresoPeer::CO_PRESUPUESTO_INGRESO,$co_partida);
        $stmt = Tb064PresupuestoIngresoPeer::doSelectStmt($c);
        $registros = $stmt->fetch(PDO::FETCH_ASSOC);         
            
        $c = new Criteria();
        $c->add(Tb064PresupuestoIngresoPeer::NU_PARTIDA,'%'.$registros["nu_partida"].'%', Criteria::LIKE);
        $c->add(Tb064PresupuestoIngresoPeer::NU_NIVEL,6);
        $c->addJoin(Tb064PresupuestoIngresoPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));
               
        $cantidad_partida = Tb064PresupuestoIngresoPeer::doCount($c);
        
        $c = new Criteria();     
        $c->add(Tb178CreacionPartidaIngresoPeer::NU_PARTIDA,$registros["nu_partida"]);
        $c->add(Tb178CreacionPartidaIngresoPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));
        $c->add(Tb178CreacionPartidaIngresoPeer::CO_ESTATUS,1);
        
        $cantidad_partida_temp = Tb178CreacionPartidaIngresoPeer::doCount($c); 
        
        $cantidad_partida+=$cantidad_partida_temp;
        
        $registros["nu_cant_partida"] = str_pad($cantidad_partida, 3, "0", STR_PAD_LEFT);
                
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        
        $this->setTemplate('store');      
  }

  public function executeLista(sfWebRequest $request)
  {
        $co_solicitud =  $this->getRequestParameter("co_solicitud");          
        $this->data = json_encode(array("co_solicitud" => $co_solicitud));
           
  }
  
  public function executeListaAprobador(sfWebRequest $request)
  {
        $co_solicitud =  $this->getRequestParameter("co_solicitud");          
        $this->data = json_encode(array("co_solicitud" => $co_solicitud));
           
  }   
  
  protected function getAplicacion($codigo){      
        $c = new Criteria();
        $c->add(Tb139AplicacionPeer::CO_APLICACION,$codigo);
        $stmt = Tb139AplicacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos["tx_tip_aplicacion"];      
  }
  
  
  public function executeCambiarEstado(sfWebRequest $request)
  {
	      
       $co_creacion_partida = $this->getRequestParameter("co_creacion_partida");
       $co_estatus = $this->getRequestParameter("co_estatus");        
        
	$con = Propel::getConnection();
	try
	{ 
            $con->beginTransaction();  
            
            $c = new Criteria();
            $c->add(Tb178CreacionPartidaIngresoPeer::CO_CREACION_PARTIDA,$co_creacion_partida);
            $stmt = Tb178CreacionPartidaIngresoPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
           
            if($co_estatus==2){              
                $mensaje = 'La creación de la partida presupuestaria se aprobó con exito!';

                $aplicacion   = $this->getAplicacion($campos["co_aplicacion"]);
                
                $c = new Criteria();     
                $c->add(Tb064PresupuestoIngresoPeer::NU_PARTIDA,$campos["nu_partida_desagregada"]);
                $c->add(Tb064PresupuestoIngresoPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));
                $cantidad = Tb064PresupuestoIngresoPeer::doCount($c);  
                
                if($cantidad>0){
                    
                    $mensaje = 'La partida ya se encuentra registrada en el presupuesto';
                    $co_estatus = 1;
                    
                }else{
                    
                    /*
                     *  co_presupuesto_ingreso bigint NOT NULL DEFAULT nextval('tb064_presupuesto_ingreso_co_presupuesto_ingreso_seq'::regclass),
                        nu_partida character varying,
                        tx_partida character varying,
                        tx_descripcion character varying,
                        mo_inicial numeric,
                        mo_actualizado numeric,
                        nu_anio numeric,
                        mo_comprometido numeric,
                        mo_causado numeric,
                        mo_pagado numeric,
                        mo_disponible numeric,
                        nu_nivel numeric,
                        do_cat character varying,
                        tip_apl character varying,
                        tip_gas character varying,
                        mo_comprometido_dia numeric,
                     */
                    
                
                    $tb064_presupuesto_ingreso = New Tb064PresupuestoIngreso();
                    $tb064_presupuesto_ingreso->setNuPartida($campos["nu_partida_desagregada"])
                                              ->setTxPartida($campos["nu_partida_desagregada"])
                                              ->setTxDescripcion($campos["tx_descripcion"])
                                              ->setMoInicial(0)
                                              ->setMoActualizado(0)
                                              ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                                              ->setMoComprometido(0)
                                              ->setMoCausado(0)
                                              ->setMoPagado(0)
                                              ->setMoDisponible(0)
                                              ->setNuNivel(6)
                                              ->setDoCat('A')
                                              ->setTipApl($aplicacion)
                                              ->setTipGas(NULL)
                                              ->setMoComprometidoDia(0)
                                              ->save($con); 

                }  
            }else if($co_estatus==3){
                $mensaje = 'La creación de la partida presupuestaria se rechazó con exito!';
            }
            
            $creacion_partida = Tb178CreacionPartidaIngresoPeer::retrieveByPK($co_creacion_partida);
            $creacion_partida->setCoEstatus($co_estatus)->save($con);

            
            $con->commit();
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($campos["co_solicitud"]));
            $ruta->setInCargarDato(true)->save($con);

            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());                 

            $con->commit();
            
            $this->data = json_encode(array(
                        "success" => true,
                        "msg" => $mensaje
            ));           
            
	}catch (PropelException $e)
	{
                $con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
		    "msg" => 'Ocurrio un error durante la transacción con la partida'
		));
	}
  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar       =   $this->getRequestParameter("paginar");
    $co_solicitud  =   $this->getRequestParameter("co_solicitud");
    $limit         =   $this->getRequestParameter("limit",20);
    $start         =   $this->getRequestParameter("start",0);    
    
    $c = new Criteria();  
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb178CreacionPartidaIngresoPeer::CO_CREACION_PARTIDA);
    $c->addSelectColumn(Tb178CreacionPartidaIngresoPeer::CO_PARTIDA);
    $c->addSelectColumn(Tb178CreacionPartidaIngresoPeer::NU_PARTIDA);
    $c->addSelectColumn(Tb178CreacionPartidaIngresoPeer::NU_PARTIDA_DESAGREGADA);
    $c->addSelectColumn(Tb178CreacionPartidaIngresoPeer::TX_DESCRIPCION);
    $c->addAsColumn('tx_estatus', Tb031EstatusRutaPeer::TX_DESCRIPCION);
    $c->addSelectColumn(Tb031EstatusRutaPeer::CO_ESTATUS_RUTA);
    
    $c->addJoin(Tb031EstatusRutaPeer::CO_ESTATUS_RUTA, Tb178CreacionPartidaIngresoPeer::CO_ESTATUS);
    $c->addJoin(Tb031EstatusRutaPeer::CO_ESTATUS_RUTA, Tb178CreacionPartidaIngresoPeer::CO_ESTATUS);
    
    $c->add(Tb178CreacionPartidaIngresoPeer::CO_SOLICITUD,$co_solicitud);
    
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb178CreacionPartidaIngresoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb178CreacionPartidaIngresoPeer::CO_CREACION_PARTIDA);
        
    $stmt = Tb178CreacionPartidaIngresoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        
        $res["tx_partida"] = Tb085PresupuestoPeer::mascaraNomina($res["nu_partida_desagregada"]); //$res["nu_pa"].'.'.$res["nu_ge"].'.'.$res["nu_es"].'.'.$res["nu_se"].'.'.$res["tx_partida"];
        
        $registros[] = $res;
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }
  
    public function executeStorefkcoaplicacion(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb139AplicacionPeer::doSelectStmt($c);
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
    
    public function executeStorefkcopartida(sfWebRequest $request){
        
        $c = new Criteria();
        $c->add(Tb064PresupuestoIngresoPeer::NU_NIVEL,5);
        //$c->add(Tb064PresupuestoIngresoPeer::NU_ANIO,$this->getUser()->getAttribute('ejercicio'));
        $stmt = Tb064PresupuestoIngresoPeer::doSelectStmt($c);
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
