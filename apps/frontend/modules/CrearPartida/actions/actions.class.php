<?php

/**
 * autoCrearPartida actions.
 * NombreClaseModel(Tb067CreacionPartida)
 * NombreTabla(tb067_creacion_partida)
 * @package    ##PROJECT_NAME##
 * @subpackage autoCrearPartida
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class CrearPartidaActions extends sfActions
{

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
                $c->add(Tb067CreacionPartidaPeer::CO_CREACION_PARTIDA,$codigo);
        
        $stmt = Tb067CreacionPartidaPeer::doSelectStmt($c);
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
                            "co_area_estrategica"       => $campos["co_area_estrategica"],
                            "co_clasificacion_economica" => $campos["co_clasificacion_economica"],
                            "co_tipo_gasto"             => $campos["co_tipo_gasto"],
                            "co_tipo_ingreso"           => $campos["co_tipo_ingreso"]
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
                            "co_area_estrategica"          => "",
                            "co_clasificacion_economica"   => "",
                            "co_tipo_gasto"                => "",            
                            "co_tipo_ingreso"              => ""
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
	
	$tb067_creacion_partida = Tb067CreacionPartidaPeer::retrieveByPk($codigo);			
	$tb067_creacion_partida->delete($con);
        
        $c = new Criteria();
        $c->add(Tb067CreacionPartidaPeer::CO_SOLICITUD,$tb067_creacion_partida->getCoSolicitud());
        $cant = Tb067CreacionPartidaPeer::doCount($c);
        
        if($cant==0){
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb067_creacion_partida->getCoSolicitud()));
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
     $tb067_creacion_partidaForm = $this->getRequestParameter('tb067_creacion_partida');
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb067_creacion_partida = Tb067CreacionPartidaPeer::retrieveByPk($codigo);
         $cantidad=0;
     }else{
        $tb067_creacion_partida = new Tb067CreacionPartida();
        //$tb067_creacion_partida->setNuAnio(date('Y'));
        $tb067_creacion_partida->setNuAnio( $this->getUser()->getAttribute('ejercicio'));
         
        $c = new Criteria();     
        $c->add(Tb067CreacionPartidaPeer::CO_FUENTE_FINANCIAMIENTO,$tb067_creacion_partidaForm["co_fuente_financiamiento"]);
        $c->add(Tb067CreacionPartidaPeer::CO_NUMERO_FUENTE,$tb067_creacion_partidaForm["co_numero_fuente"]);
        $c->add(Tb067CreacionPartidaPeer::CO_PARTIDA,$tb067_creacion_partidaForm["co_partida"]);
        $c->add(Tb067CreacionPartidaPeer::CO_ACCION_ESPECIFICA,$tb067_creacion_partidaForm["co_accion_especifica"]);
        $c->add(Tb067CreacionPartidaPeer::TX_PARTIDA,$tb067_creacion_partidaForm["tx_partida"]);
        //$c->add(Tb067CreacionPartidaPeer::NU_ANIO,date('Y'));
        $c->add(Tb067CreacionPartidaPeer::IN_ANULAR, FALSE);
        $c->add(Tb067CreacionPartidaPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));
        
        $cantidad = Tb067CreacionPartidaPeer::doCount($c);  
         
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
        
            $tb067_creacion_partida->setCreatedAt($fecha);
            $tb067_creacion_partida->setCoFuenteFinanciamiento($tb067_creacion_partidaForm["co_fuente_financiamiento"]);
            $tb067_creacion_partida->setCoNumeroFuente($tb067_creacion_partidaForm["co_numero_fuente"]);
            $tb067_creacion_partida->setCoEnteEjecutor($tb067_creacion_partidaForm["co_ente_ejecutor"]);
            $tb067_creacion_partida->setCoProyecto($tb067_creacion_partidaForm["co_proyecto"]);
            $tb067_creacion_partida->setCoAccionEspecifica($tb067_creacion_partidaForm["co_accion_especifica"]);
            $tb067_creacion_partida->setCoPartida($tb067_creacion_partidaForm["co_partida"]);        
            $tb067_creacion_partida->setTxDescripcion($tb067_creacion_partidaForm["tx_descripcion"]);
            $tb067_creacion_partida->setTxPartida($tb067_creacion_partidaForm["tx_partida"]);
            $tb067_creacion_partida->setNuMonto(0);
            $tb067_creacion_partida->setCoSolicitud($tb067_creacion_partidaForm["co_solicitud"]);
            $tb067_creacion_partida->setCoUsuario($this->getUser()->getAttribute('codigo'));
            $tb067_creacion_partida->setCoAmbito($tb067_creacion_partidaForm["co_ambito"]);
            $tb067_creacion_partida->setCoTipoIngreso($tb067_creacion_partidaForm["co_tipo_ingreso"]);
            $tb067_creacion_partida->setCoAplicacion($tb067_creacion_partidaForm["co_aplicacion"]);
            $tb067_creacion_partida->setCoTipoGasto($tb067_creacion_partidaForm["co_tipo_gasto"]);
            $tb067_creacion_partida->setCoClasificacionEconomica($tb067_creacion_partidaForm["co_clasificacion_economica"]);
            $tb067_creacion_partida->setCoAreaEstrategica($tb067_creacion_partidaForm["co_area_estrategica"]);
            $tb067_creacion_partida->setCoEstatus(1);

            $con->commit();
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb067_creacion_partidaForm["co_solicitud"]));
            $ruta->setInCargarDato(true)->save($con);

            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());                 

            $con->commit();
       
            $tb067_creacion_partida->save($con);
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
        $co_fuente_financiamiento = $this->getRequestParameter('co_fuente_financiamiento');
        $co_numero_fuente         = $this->getRequestParameter('co_numero_fuente');
        $co_accion_especifica     = $this->getRequestParameter('co_accion_especifica');
        
        $c = new Criteria();
        $c->add(Tb091PartidaPeer::ID,$co_partida);
        $stmt = Tb091PartidaPeer::doSelectStmt($c);
        $registros = $stmt->fetch(PDO::FETCH_ASSOC); 
        
        $c = new Criteria();
        $c->add(Tb068NumeroFuenteFinanciamientoPeer::CO_NUMERO_FUENTE,$co_numero_fuente);
        $stmt = Tb068NumeroFuenteFinanciamientoPeer::doSelectStmt($c);
        $registros_numero_fuente = $stmt->fetch(PDO::FETCH_ASSOC);  
              
        $c = new Criteria();
        $c->add(Tb073FuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO,$co_fuente_financiamiento);
        $stmt = Tb073FuenteFinanciamientoPeer::doSelectStmt($c);
        $registros_fuente_financiamiento = $stmt->fetch(PDO::FETCH_ASSOC);          
        
        $nu_fi = $registros_fuente_financiamiento["tx_siglas"].str_pad($registros_numero_fuente["tx_numero_fuente"], 4, "0", STR_PAD_LEFT);
        
        
        $c = new Criteria();
        $c->add(Tb085PresupuestoPeer::CO_PARTIDA,$registros["nu_partida"]);
        $c->add(Tb085PresupuestoPeer::NU_FI,$nu_fi);
        $c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA,$co_accion_especifica);
        $c->add(Tb085PresupuestoPeer::IN_ACTIVO,true);
        $c->addJoin(Tb085PresupuestoPeer::NU_ANIO, Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
        //$c->add(Tb013AnioFiscalPeer::IN_ACTIVO,TRUE);
        $c->add(Tb013AnioFiscalPeer::CO_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
        
        $cantidad_partida = Tb085PresupuestoPeer::doCount($c);
        
        $c = new Criteria();     
        $c->add(Tb067CreacionPartidaPeer::CO_FUENTE_FINANCIAMIENTO,$co_fuente_financiamiento);
        $c->add(Tb067CreacionPartidaPeer::CO_NUMERO_FUENTE,$co_numero_fuente);
        $c->add(Tb067CreacionPartidaPeer::CO_PARTIDA,$co_partida);
        //$c->add(Tb067CreacionPartidaPeer::NU_ANIO,date('Y'));
        $c->add(Tb067CreacionPartidaPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));
        $c->add(Tb067CreacionPartidaPeer::CO_ESTATUS,1);
        
        $cantidad_partida_temp = Tb067CreacionPartidaPeer::doCount($c);        
        
        
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
  
  protected function getDatosFuenteFinanciamiento($co_numero_fuente){
      
        $c = new Criteria();
        $c->addSelectColumn(Tb073FuenteFinanciamientoPeer::TX_SIGLAS);
        $c->addSelectColumn(Tb068NumeroFuenteFinanciamientoPeer::TX_NUMERO_FUENTE);
        $c->addJoin(Tb073FuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO, Tb068NumeroFuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO);
        $c->add(Tb068NumeroFuenteFinanciamientoPeer::CO_NUMERO_FUENTE,$co_numero_fuente);
        $stmt = Tb068NumeroFuenteFinanciamientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos["tx_siglas"].str_pad($campos["tx_numero_fuente"], 4, "0", STR_PAD_LEFT);
      
  }
  
  protected function getEjecutor($codigo){
      
        $c = new Criteria();
        $c->add(Tb082EjecutorPeer::ID,$codigo);        
        $stmt = Tb082EjecutorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos["nu_ejecutor"];
      
  }  
  
  protected function getSector($codigo){
      
        $c = new Criteria();
        $c->addJoin(Tb080SectorPeer::ID, Tb083ProyectoAcPeer::ID_TB080_SECTOR);
        $c->add(Tb083ProyectoAcPeer::ID,$codigo);        
        $stmt = Tb080SectorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos["nu_sector"];
      
  }
  
  protected function getProyecto($codigo){      
        $c = new Criteria();
        $c->add(Tb083ProyectoAcPeer::ID,$codigo);
        $stmt = Tb083ProyectoAcPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos["nu_proyecto_ac"];      
  }
  
  protected function getAccionEspecifica($codigo){      
        $c = new Criteria();
        $c->add(Tb084AccionEspecificaPeer::ID,$codigo);
        $stmt = Tb084AccionEspecificaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos["nu_accion_especifica"];      
  }
  
  protected function getAmbito($codigo){      
        $c = new Criteria();
        $c->add(Tb138AmbitoPeer::CO_AMBITO,$codigo);
        $stmt = Tb138AmbitoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos;      
  }
  
  protected function getAplicacion($codigo){      
        $c = new Criteria();
        $c->add(Tb139AplicacionPeer::CO_APLICACION,$codigo);
        $stmt = Tb139AplicacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos;      
  }
  
  protected function getTipoIngreso($codigo){      
        $c = new Criteria();
        $c->add(Tb140TipoIngresoPeer::CO_TIPO_INGRESO,$codigo);
        $stmt = Tb140TipoIngresoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos;      
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
            $c->add(Tb067CreacionPartidaPeer::CO_CREACION_PARTIDA,$co_creacion_partida);
            $stmt = Tb067CreacionPartidaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
           
            if($co_estatus==2){              
                $mensaje = 'La creación de la partida presupuestaria se aprobó con exito!';

                $cp = new Criteria();
                $cp->add(Tb091PartidaPeer::ID,$campos["co_partida"]);
                $stmtp = Tb091PartidaPeer::doSelectStmt($cp);
                $presupuesto = $stmtp->fetch(PDO::FETCH_ASSOC);
                
                $nu_fi = $this->getDatosFuenteFinanciamiento($campos["co_numero_fuente"]);
                
              //  $ambito       = $this->getAmbito($campos["co_ambito"]);
                $aplicacion   = $this->getAplicacion($campos["co_aplicacion"]);
                $tipo_ingreso = $this->getTipoIngreso($campos["co_tipo_ingreso"]);
                
                $nu_partida = $presupuesto["nu_pa"].$presupuesto["nu_ge"].$presupuesto["nu_es"].$presupuesto["nu_se"].$campos["tx_partida"].$nu_fi;
                $co_partida = $presupuesto["nu_pa"].$presupuesto["nu_ge"].$presupuesto["nu_es"].$presupuesto["nu_se"].$campos["tx_partida"];
                
                $nu_sector   = $this->getSector($campos["co_proyecto"]);
                $nu_proyecto = $this->getProyecto($campos["co_proyecto"]);
                $nu_ejecutor   = $this->getEjecutor($campos["co_ente_ejecutor"]);
                $nu_accion_especifica   = $this->getAccionEspecifica($campos["co_accion_especifica"]);
                              
                $co_categoria = $nu_ejecutor.'.'.$nu_sector.'.'.$nu_proyecto.'.00.'.$nu_accion_especifica.'.'.$presupuesto["nu_pa"].'.'.$presupuesto["nu_ge"].'.'.$presupuesto["nu_es"].'.'.$presupuesto["nu_se"].'.'.$campos["tx_partida"].'.'.$nu_fi;
                
                
                $c = new Criteria();     
                $c->add(Tb085PresupuestoPeer::NU_PARTIDA,$nu_partida);
                $c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA,$campos["co_accion_especifica"]);
                //$c->add(Tb085PresupuestoPeer::NU_ANIO,date('Y'));
                $c->add(Tb085PresupuestoPeer::NU_ANIO, $this->getUser()->getAttribute('ejercicio'));
                $cantidad = Tb085PresupuestoPeer::doCount($c);  
                
                
                if($cantidad>0){
                    
                    $mensaje = 'La partida ya se encuentra registrada en el presupuesto';
                    $co_estatus = 1;
                    
                }else{
                
                    $tb085_presupuesto = New Tb085Presupuesto();
                    $tb085_presupuesto->setIdTb084AccionEspecifica($campos["co_accion_especifica"])
                                      ->setNuPartida($nu_partida)
                                      ->setDePartida($campos["tx_descripcion"])
                                      ->setMoInicial(0)
                                      ->setMoActualizado($campos["nu_monto"])
                                      ->setMoPrecomprometido(0)
                                      ->setMoComprometido(0)
                                      ->setMoCausado(0)
                                      ->setMoPagado(0)
                                      ->setMoDisponible($campos["nu_monto"])
                                      ->setInActivo(true)
                                      ->setInMovimiento($presupuesto["in_movimiento"])
                                      ->setNuPa($presupuesto["nu_pa"])
                                      ->setNuGe($presupuesto["nu_ge"])
                                      ->setNuEs($presupuesto["nu_es"])
                                      ->setNuSe($presupuesto["nu_se"])
                                      ->setNuSse($campos["tx_partida"])
                                      ->setCoPartida($co_partida)
                                      ->setNuNivel(5)
                                      ->setNuFi($nu_fi)
                                      ->setCoCategoria($co_categoria)
                                      ->setNuAplicacion($aplicacion["tx_tip_aplicacion"])
                                      ->setTpIngreso($presupuesto["tp_ingreso"])
                                      ->setNuSector($nu_sector)
                                      ->setCodEnte($nu_ejecutor)
                                      ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                                      ->setCoEnte($campos["co_ente_ejecutor"])
                                      ->setTpIngreso($tipo_ingreso["tx_tip_ingreso"])
                                      ->setTipApl($aplicacion["tx_tip_aplicacion"])
                                      ->setTipGasto($campos["co_tipo_gasto"])
                                      ->setCodAmb($campos["co_ambito"])
                                      ->setInGenCheque(($aplicacion["tx_genera_cheque"]=='S')?TRUE:FALSE)
                                      ->setIdTb139Aplicacion($campos["co_aplicacion"])
                                      ->setCoClasificacionEconomica($campos["co_clasificacion_economica"])
                                      ->setCoAreaEstrategica($campos["co_area_estrategica"])
                                      ->save($con); 

                }  
            }else if($co_estatus==3){
                $mensaje = 'La creación de la partida presupuestaria se rechazó con exito!';
            }
            
            $creacion_partida = Tb067CreacionPartidaPeer::retrieveByPK($co_creacion_partida);
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
    $c->addSelectColumn(Tb067CreacionPartidaPeer::CO_CREACION_PARTIDA);
//    $c->addSelectColumn(Tb091PartidaPeer::CO_PARTIDA);
//    $c->addSelectColumn(Tb091PartidaPeer::DE_PARTIDA);
//    $c->addSelectColumn(Tb091PartidaPeer::NU_PA);
//    $c->addSelectColumn(Tb091PartidaPeer::NU_GE);
//    $c->addSelectColumn(Tb091PartidaPeer::NU_ES);
//    $c->addSelectColumn(Tb091PartidaPeer::NU_SE);
    $c->addSelectColumn(Tb067CreacionPartidaPeer::TX_PARTIDA);
    $c->addSelectColumn(Tb067CreacionPartidaPeer::NU_PARTIDA_DESAGREGADA);
    $c->addSelectColumn(Tb067CreacionPartidaPeer::TX_DESCRIPCION);
    $c->addSelectColumn(Tb067CreacionPartidaPeer::NU_MONTO);
    $c->addAsColumn('tx_estatus', Tb031EstatusRutaPeer::TX_DESCRIPCION);
    $c->addSelectColumn(Tb031EstatusRutaPeer::CO_ESTATUS_RUTA);
    
    
//    $c->addJoin(Tb091PartidaPeer::ID, Tb067CreacionPartidaPeer::CO_PARTIDA);
    $c->addJoin(Tb031EstatusRutaPeer::CO_ESTATUS_RUTA, Tb067CreacionPartidaPeer::CO_ESTATUS);
    
    $c->add(Tb067CreacionPartidaPeer::CO_SOLICITUD,$co_solicitud);
    
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb067CreacionPartidaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb067CreacionPartidaPeer::CO_CREACION_PARTIDA);
        
    $stmt = Tb067CreacionPartidaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        
        //$res["tx_partida"] = Tb085PresupuestoPeer::mascaraNomina($res["nu_partida_desagregada"]); //$res["nu_pa"].'.'.$res["nu_ge"].'.'.$res["nu_es"].'.'.$res["nu_se"].'.'.$res["tx_partida"];
        
        $registros[] = $res;
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb099_tipo_fuente_financiamiento.ID
    public function executeStorefkcofuentefinanciamiento(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb073FuenteFinanciamientoPeer::IN_ACTIVO,true);
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
                    //modelo fk tb067_numero_fuente_financiamiento.CO_NUMERO_FUENTE
    public function executeStorefkconumerofuente(sfWebRequest $request){
        $co_fuente_financiamiento = $this->getRequestParameter("co_fuente_financiamiento");
        $c = new Criteria();
        $c->add(Tb068NumeroFuenteFinanciamientoPeer::CO_FUENTE_FINANCIAMIENTO,$co_fuente_financiamiento);
        $stmt = Tb068NumeroFuenteFinanciamientoPeer::doSelectStmt($c);
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
                    //modelo fk tb082_ejecutor.ID
    public function executeStorefkcoenteejecutor(sfWebRequest $request){
        $c = new Criteria();
        
        $co_ejecutor = $this->getUser()->getAttribute('co_ejecutor');
        if($co_ejecutor!=''){
            $c->add(Tb082EjecutorPeer::ID,$co_ejecutor);
        }
        
        $stmt = Tb082EjecutorPeer::doSelectStmt($c);
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
                    //modelo fk tb083_proyecto_ac.ID
    public function executeStorefkcoproyecto(sfWebRequest $request){
        $co_ejecutor = $this->getRequestParameter("co_ejecutor");
        $c = new Criteria();
        $c->add(Tb083ProyectoAcPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
        $c->add(Tb083ProyectoAcPeer::IN_ACTIVO,TRUE);
        $c->add(Tb083ProyectoAcPeer::ID_TB082_EJECUTOR,$co_ejecutor);
        $stmt = Tb083ProyectoAcPeer::doSelectStmt($c);
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
                    //modelo fk tb084_accion_especifica.ID
    public function executeStorefkcoaccionespecifica(sfWebRequest $request){
        $co_proyecto = $this->getRequestParameter('co_proyecto');
        $c = new Criteria();
        $c->add(Tb084AccionEspecificaPeer::IN_ACTIVO,TRUE);
        $c->add(Tb084AccionEspecificaPeer::ID_TB083_PROYECTO_AC,$co_proyecto);
     
        $stmt = Tb084AccionEspecificaPeer::doSelectStmt($c);
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
                    //modelo fk tb031_estatus_ruta.CO_ESTATUS_RUTA
    public function executeStorefkcoestatus(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb031EstatusRutaPeer::doSelectStmt($c);
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
    public function executeStorefkcousuariocambio(sfWebRequest $request){
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
    
    public function executeStorefkcoaplicacion(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb139AplicacionPeer::NU_ANIO_FISCAL,$this->getUser()->getAttribute('ejercicio'));
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
    
    public function executeStorefkcotipoingreso(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb140TipoIngresoPeer::doSelectStmt($c);
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
    
    public function executeStorefkcoambito(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb138AmbitoPeer::NU_ANIO,$this->getUser()->getAttribute('ejercicio'));
        $stmt = Tb138AmbitoPeer::doSelectStmt($c);
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
        
        $co_accion = $this->getRequestParameter('co_accion');
        $c = new Criteria();
//        $c->addSelectColumn(Tb085PresupuestoPeer::ID);
//        $c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
//        $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
       // $c->add(Tb085PresupuestoPeer::ID_TB084_ACCION_ESPECIFICA,$co_accion);
//        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
        $c->add(Tb091PartidaPeer::IN_MOVIMIENTO,true);
        $c->add(Tb091PartidaPeer::NU_NIVEL,4);
        $c->add(Tb091PartidaPeer::NU_PA,'4%', Criteria::LIKE);
        $stmt = Tb091PartidaPeer::doSelectStmt($c);
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
    
     public function executeStorefkTipoGasto(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb183TipoGastoPeer::doSelectStmt($c);
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
    
     public function executeStorefkClasificacionEconomica(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb184ClasificacionEconomicaPeer::doSelectStmt($c);
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

     public function executeStorefkAreaEstrategica(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb185AreaEstrategicaPeer::doSelectStmt($c);
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