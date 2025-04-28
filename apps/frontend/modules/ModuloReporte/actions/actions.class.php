<?php

/**
 * ModuloReporte actions.
 *
 * @package    gobel
 * @subpackage ModuloReporte
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class ModuloReporteActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }

  
  
  public function executeAnioreportecaja(){

    $c = new Criteria();
    $c->setDistinct();
    $c->addSelectColumn(Tb013AnioFiscalPeer::TX_ANIO_FISCAL);
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
 
    public function executeBuscar(sfWebRequest $request)
   {
       
        $paquete_modulo = $this->getRequestParameter("paquete");
     
        $this->estructura = Tbrh005EstructuraAdministrativaPeer::datosEstructura();
        $this->paquete = $paquete_modulo;
   }
  
   public function executeSeleccinarEstructura(sfWebRequest $request){
       
       
       $json  = json_decode($this->getRequestParameter('json_array'),true);
       $opciones = $json['opcion'];
       
       foreach ($opciones as $lista){
           $lista;            
       }
       
       $this->paquete_modulo = $this->getRequestParameter("paquete");
       $this->estructura = Tbrh005EstructuraAdministrativaPeer::getUbicacionEstructura($lista);
       $this->co_estructura_administrativa = $lista;
       
   }

   public function executeReporteBalance(sfWebRequest $request)
  {
   
  }
  public function executeReporteBienes(sfWebRequest $request)
  {
   
  }

  public function executeReporteBienesBM(sfWebRequest $request)
  {
   
  }
  public function executeReporteResumenBienes(sfWebRequest $request)
  {
   
  }
   public function executeReporteRelODP(sfWebRequest $request)
  {
   
  } 
  
  public function executeReporteAnaliticaCuentaDT(sfWebRequest $request)
  {
   
  } 
  
   public function executeReporteAnaliticaCuentaFT(sfWebRequest $request)
  {
   
  }   
  
  public function executeReportePresupuesto(sfWebRequest $request)
  {
   
  }
  
  public function executeReportePagos(sfWebRequest $request)
  {
   
  }
  
    public function executeReporteRelTraslados(sfWebRequest $request)
  {
   
  }
  
   public function executeReporteMaxMin(sfWebRequest $request)
  {
   
  }     
  
   public function executeReporteRetencionProveedor(sfWebRequest $request)
  {
   
  }    
     public function executeReporteRetencionProveedorDetalle(sfWebRequest $request)
  {
   
  } 
     public function executeReporteRetencionIslr(sfWebRequest $request)
  {
   
  }   
  public function executeReporteConsultaTrabajador(sfWebRequest $request)
  {
      
        $this->data = json_encode(array(
		"co_rol"         => $this->getUser()->getAttribute('rol'),
		"co_usuario"     => $this->getUser()->getAttribute('codigo'),
	));      
   
  }  

  public function executeCartaDeTrabajo(sfWebRequest $request)
  {
    
   
  }

  public function executeHistoricoDeCargo(sfWebRequest $request)
  {
    
    
  }



  public function executeReportedepago(sfWebRequest $request)
  {
    $this->data = $this->getUser()->getAttribute('codigo');
    
    
  }
  
  
  public function executeReportedepension(sfWebRequest $request)
  {
    
    $this->data = $this->getUser()->getAttribute('codigo');
    
  }


  
  public function executeReporteDePagoMasivo(sfWebRequest $request)
  {
    
    $this->data = $this->getUser()->getAttribute('codigo');
    
  }

  public function executeGruponomina(sfWebRequest $request)
  {
    $c = new Criteria();
    $c->setDistinct();
    $c->addSelectColumn(Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);
    $c->add(Tbrh067GrupoNominaPeer::CO_TP_NOMINA, 5 );
    $c->addSelectColumn(Tbrh067GrupoNominaPeer::TX_GRUPO_NOMINA );
    $stmt = Tbrh067GrupoNominaPeer::doSelectStmt($c);
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

  public function executeRrhhDependencia(sfWebRequest $request)
  {
    
        $c = new Criteria();
        $c->setDistinct();
        $c->addSelectColumn(Tbrh003DependenciaPeer::CO_DEPENDENCIA);
        $c->addSelectColumn(Tbrh003DependenciaPeer::NU_CODIGO);
        $c->addSelectColumn(Tbrh003DependenciaPeer::TX_DEPENDECIA);
        $c->addAscendingOrderByColumn(Tbrh003DependenciaPeer::NU_CODIGO);
        $stmt = Tbrh003DependenciaPeer::doSelectStmt($c);
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



  
  public function executeReporteRelAportePatronales(sfWebRequest $request)
  {
   
  }

  public function executeReporteRelDiariaConsignacion(sfWebRequest $request)
  {
   
  }    

  public function executeReporteOpdPartida (sfWebRequest $request)
  {
   
  }     
  
  public function executeReporteMovBco(sfWebRequest $request)
  {
   
  }
  
  public function executeReporteAnexos(sfWebRequest $request)
  {
   
  }
  
  public function executeReporteBalanceGeneral(sfWebRequest $request)
  {
   
  }  
  
  public function executeReporteBalanceCierre(sfWebRequest $request)
  {
   
  }   
    public function executeReporteRelCheque(sfWebRequest $request)
  {
   
  }

  public function executeReporteOdpProveedor(sfWebRequest $request)
  {
   
  }
  
  public function executeReportePresResumenOP(sfWebRequest $request)
  {
   
  }
  
  public function executeReporteOdp(sfWebRequest $request)
  {
   
  }  

  public function executeOrdenCompra(sfWebRequest $request)
  {
   
  }  
  
  public function executeReporteRelNomina(sfWebRequest $request)
  {
   
  }
  public function executeReporteRelConcNomina(sfWebRequest $request)
  {
   
  }  

  public function executeReporteAtencionCiudadano(sfWebRequest $request)
  {
   
  }

    public function executeEgresosRrhh(sfWebRequest $request)
  {
   
  }

    public function executeIngresosRrhh(sfWebRequest $request)
  {
   
  }

  public function executeReportePreNominaRrhh(sfWebRequest $request)
  {
   
  }

  public function executeReporteAnaliticaCuenta(sfWebRequest $request)
  {
   
  }  
  
  public function executeReporteComprobanteRetencion(sfWebRequest $request)
  {
   
  }   
  public function executeStoretb083proyectoac(sfWebRequest $request){
        $c = new Criteria();
        $codigo = $this->getRequestParameter("co_ejecutor");
        $c->add(Tb083ProyectoAcPeer::ID_TB082_EJECUTOR,$codigo,Criteria::EQUAL);
        $stmt = Tb083ProyectoAcPeer::doSelectStmt($c);

        $registros = array();
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = array(
                "id"                 => trim($res["id"]),
                "nu_proyecto_ac"     => trim($res["nu_proyecto_ac"]),
                "de_proyecto_ac"     => trim($res["de_proyecto_ac"])       
            );
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
            ));
        $this->setTemplate('store');
    }
    
      public function executeStoretb084accionesp(sfWebRequest $request){
        $c = new Criteria();
        $codigo = $this->getRequestParameter("co_ae");
        $c->add(Tb084AccionEspecificaPeer::ID_TB083_PROYECTO_AC,$codigo,Criteria::EQUAL);
        $stmt = Tb084AccionEspecificaPeer::doSelectStmt($c);

        $registros = array();
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = array(
                "id"                 => trim($res["id"]),
                "nu_accion_especifica"     => trim($res["nu_accion_especifica"]),
                "de_accion_especifica"     => trim($res["de_accion_especifica"])       
            );
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
            ));
        $this->setTemplate('store');
    }
    
    public function executeStorePartidas(sfWebRequest $request){
        
        $co_accion = $this->getRequestParameter('co_ae');
        
        $c = new Criteria();
        $c->addSelectColumn(Tb085PresupuestoPeer::ID);
        $c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);      
        
        
        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
        $registros = array();
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = array(
                "id"                 => trim($res["id"]),
                "nu_partida"     => trim($res["nu_partida"]),
                "de_partida"     => trim($res["de_partida"])       
            );
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
            ));
        $this->setTemplate('store');
    }
  public function executeReporteLibroMayor(sfWebRequest $request)
  {
   
  } 
  
    public function executeReporteLibroDiario(sfWebRequest $request)
  {
   
  } 
  
  public function executeReporteListaODP(sfWebRequest $request)
  {
   
  }   
  public function executeReporteRelRetenciones(sfWebRequest $request)
  {
   
  }  
  public function executeReporteRelCaja(sfWebRequest $request)
  {
   
  }  
  public function executeReportePresFuente(sfWebRequest $request)
  {
   
  }  
  public function executeReportePresDecreto(sfWebRequest $request)
  {
        $this->data = json_encode(array(
            "co_usuario"  => $this->getUser()->getAttribute('codigo'),
            "usuario"     => $this->getUser()->getAttribute('nombre'),
            "ejercicio"   => $this->getUser()->getAttribute('ejercicio'),
            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre'),
            "co_anio_fiscal"    => $this->getUser()->getAttribute('ejercicio')
        ));
  }    
  public function executeReporteCierrePresIngreso(sfWebRequest $request)
  {
   
  }
  public function executeReporteAportePatronal(sfWebRequest $request)
  {
   
  }
  public function executeReporteCierrePresEgreso(sfWebRequest $request)
  {
   
  }  
  public function executeReportePreCierrePresIngreso(sfWebRequest $request)
  {
   
  }
  public function executeReportePreCierrePresEgreso(sfWebRequest $request)
  {
   
  }   
  public function executeReportePresGasto(sfWebRequest $request)
  {
        $this->data = json_encode(array(
            "co_usuario"  => $this->getUser()->getAttribute('codigo'),
            "usuario"     => $this->getUser()->getAttribute('nombre'),
            "ejercicio"   => $this->getUser()->getAttribute('ejercicio'),
            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre'),
            "co_anio_fiscal"    => $this->getUser()->getAttribute('ejercicio')
        ));
  }   
  public function executeReportePresGastoTipo(sfWebRequest $request)
  {
       $this->data = json_encode(array(
            "co_usuario"  => $this->getUser()->getAttribute('codigo'),
            "usuario"     => $this->getUser()->getAttribute('nombre'),
            "ejercicio"   => $this->getUser()->getAttribute('ejercicio'),
            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre'),
            "co_anio_fiscal"    => $this->getUser()->getAttribute('ejercicio')
        ));
   
  } 
  public function executeReportePresApliPart55A(sfWebRequest $request)
  {
   
  } 
  public function executeReportePresApliPartFuent55C(sfWebRequest $request)
  {
   
  } 
  public function executeReportePresDetallada87(sfWebRequest $request)
  {
   
  }   
  public function executeReportePresArea(sfWebRequest $request)
  {
        $this->data = json_encode(array(
            "co_usuario"  => $this->getUser()->getAttribute('codigo'),
            "usuario"     => $this->getUser()->getAttribute('nombre'),
            "ejercicio"   => $this->getUser()->getAttribute('ejercicio'),
            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre'),
            "co_anio_fiscal"    => $this->getUser()->getAttribute('ejercicio')
        ));
  }   
  public function executeReportePresAplicacion(sfWebRequest $request)
  {
   
  }  
  public function executeReportePresIngreso(sfWebRequest $request)
  {
   
  }  
  public function executeReportePresSectores(sfWebRequest $request)
  {
      
        $this->data = json_encode(array(
            "co_usuario"  => $this->getUser()->getAttribute('codigo'),
            "usuario"     => $this->getUser()->getAttribute('nombre'),
            "ejercicio"   => $this->getUser()->getAttribute('ejercicio'),
            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre'),
            "co_anio_fiscal"    => $this->getUser()->getAttribute('ejercicio')
        ));
   
  }  
  
  public function executeReporteAmbito(sfWebRequest $request)
  {
      
        $this->data = json_encode(array(
            "co_usuario"  => $this->getUser()->getAttribute('codigo'),
            "usuario"     => $this->getUser()->getAttribute('nombre'),
            "ejercicio"   => $this->getUser()->getAttribute('ejercicio'),
            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre'),
            "co_anio_fiscal"    => $this->getUser()->getAttribute('ejercicio')
        ));
   
  }  
  
  public function executeReportePresOrdenador(sfWebRequest $request)
  {
        $this->data = json_encode(array(
            "co_usuario"  => $this->getUser()->getAttribute('codigo'),
            "usuario"     => $this->getUser()->getAttribute('nombre'),
            "ejercicio"   => $this->getUser()->getAttribute('ejercicio'),
            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre'),
            "co_anio_fiscal"    => $this->getUser()->getAttribute('ejercicio')
        ));
  } 
  public function executeReportePresPartidas(sfWebRequest $request)
  {
       $this->data = json_encode(array(
            "co_usuario"  => $this->getUser()->getAttribute('codigo'),
            "usuario"     => $this->getUser()->getAttribute('nombre'),
            "ejercicio"   => $this->getUser()->getAttribute('ejercicio'),
            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre'),
            "co_anio_fiscal"    => $this->getUser()->getAttribute('ejercicio')
        ));
   
  }  
  
  public function executeReportePresPartidasDetallado(sfWebRequest $request)
  {
       $this->data = json_encode(array(
            "co_usuario"  => $this->getUser()->getAttribute('codigo'),
            "usuario"     => $this->getUser()->getAttribute('nombre'),
            "ejercicio"   => $this->getUser()->getAttribute('ejercicio'),
            "fe_ini"   => $this->getUser()->getAttribute('fe_apertura'),
            "fe_fin"   => $this->getUser()->getAttribute('fe_cierre'),
            "co_anio_fiscal"    => $this->getUser()->getAttribute('ejercicio')
        ));
   
  }  
  
  public function executeRetencion(sfWebRequest $request)
  {

    $c = new Criteria();
    $c->add(Tb041TipoRetencionPeer::CO_CLASE_RETENCION, 1);
    $stmt = Tb041TipoRetencionPeer::doSelectStmt($c);
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

    //modelo fk_co_estatus_ruta
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
    
    public function executeStorefkidtb139aplicacion(sfWebRequest $request){
        
        $co_ente = $this->getRequestParameter('co_ejecutor');
        
        $c = new Criteria();
//        $c->add(Tb082EjecutorPeer::ID,$co_ente,Criteria::EQUAL);
//        $c->addJoin( Tb085PresupuestoPeer::COD_ENTE, Tb082EjecutorPeer::NU_EJECUTOR, Criteria::EQUAL);
//        $c->addJoin( Tb085PresupuestoPeer::CO_APLICACION, Tb139AplicacionPeer::CO_APLICACION, Criteria::EQUAL);        
//        
//        echo 'respuesta '.$c->toString(); exit();
//        
//        $c->setIgnoreCase(true);
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

    public function executeRegenerar(sfWebRequest $request)
    {
     
    }

    //modelo fk_co_tipo_solicitud
    public function executeStorefkcotiposolicitud(sfWebRequest $request){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb027TipoSolicitudPeer::IN_VER);
        $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
        $c->addJoin(Tb027TipoSolicitudPeer::CO_PROCESO, Tb028ProcesoPeer::CO_PROCESO);
        
        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
            
        $stmt = Tb027TipoSolicitudPeer::doSelectStmt($c);

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

    //modelo fk_co_tipo_solicitud
    public function executeStorefkcoruta(sfWebRequest $request){

        $co_tipo_solicitud = $this->getRequestParameter("tipo_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb028ProcesoPeer::CO_PROCESO);
        $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
        $c->addSelectColumn(Tb032ConfiguracionRutaPeer::NU_ORDEN);
        $c->addSelectColumn(Tb032ConfiguracionRutaPeer::IN_CARGAR_DATO);
        $c->addSelectColumn(Tb032ConfiguracionRutaPeer::CO_CONFIGURACION);  
        $c->addSelectColumn(Tb032ConfiguracionRutaPeer::CO_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb032ConfiguracionRutaPeer::NB_REPORTE_ORDEN);
        $c->add(Tb032ConfiguracionRutaPeer::CO_TIPO_SOLICITUD,$co_tipo_solicitud);
        $c->add(Tb032ConfiguracionRutaPeer::NB_REPORTE_ORDEN, NULL,Criteria::ISNOTNULL);
        $c->addJoin(Tb028ProcesoPeer::CO_PROCESO, Tb032ConfiguracionRutaPeer::CO_PROCESO);
        $cantidadTotal = Tb032ConfiguracionRutaPeer::doCount($c);
        
        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb032ConfiguracionRutaPeer::NU_ORDEN);
        
        $stmt = Tb032ConfiguracionRutaPeer::doSelectStmt($c);

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
    
  public function executeStorelistaTrabajador(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
          
    $co_documento      =   $this->getRequestParameter("co_documento");
    $nu_cedula      =   $this->getRequestParameter("nu_cedula");
    $nombre      =   $this->getRequestParameter("nombre");
    
    
    $c = new Criteria();  
    $c->clearSelectColumns();
    
    
            if($co_documento!=''){
                $c->add(Tbrh001TrabajadorPeer::CO_DOCUMENTO,$co_documento);
            }

            if($nu_cedula!=''){
                $c->add(Tbrh001TrabajadorPeer::NU_CEDULA,$nu_cedula);
            }
  
            if($nombre!=''){
                $c->add(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE,'%'.strtoupper($nombre).'%', Criteria::LIKE);
            }                  
    
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_TRABAJADOR);
    $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
    $c->addSelectColumn(Tbrh043ProfesionPeer::TX_PROFESION);
    $c->addSelectColumn(Tb010BancoPeer::TX_BANCO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CUENTA_BANCARIA);
    
    $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tbrh001TrabajadorPeer::CO_DOCUMENTO);
    $c->addJoin(Tbrh001TrabajadorPeer::CO_BANCO, Tb010BancoPeer::CO_BANCO,   Criteria::LEFT_JOIN);
    $c->addJoin(Tbrh001TrabajadorPeer::CO_PROFESION, Tbrh043ProfesionPeer::CO_PROFESION,  Criteria::LEFT_JOIN);
                    
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh001TrabajadorPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tbrh001TrabajadorPeer::CO_TRABAJADOR);
        
    $stmt = Tbrh001TrabajadorPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_trabajador"      => trim($res["co_trabajador"]),
            "nu_cedula"          => trim($res["inicial"]).'-'.trim($res["nu_cedula"]),
            "nombre"   => trim($res["nb_primer_nombre"]).' '.trim($res["nb_segundo_nombre"]).' '.trim($res["nb_primer_apellido"]).' '.trim($res["nb_segundo_apellido"]),
            "co_documento"       => trim($res["co_documento"]),
            "co_profesion"       => trim($res["tx_profesion"]),
            "tx_banco"           => trim($res["tx_banco"]),
            "nu_cuenta_bancaria" => trim($res["nu_cuenta_bancaria"])
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    $this->setTemplate('store');
    
    }    
    
  public function executeStoreNOMOLD(){

        $c = new Criteria();
        $c->setDistinct();
        $c->addSelectColumn(Tbrh013NominaPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tbrh013NominaPeer::DE_NOMINA);
        $stmt = Tbrh013NominaPeer::doSelectStmt($c);
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
    
  public function executeStorefkcoanexocontable(){

        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb190AnexoContablePeer::CO_ANEXO_CONTABLE);
        $stmt = Tb190AnexoContablePeer::doSelectStmt($c);
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

  public function executeStoreconceptoproveedor(){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh106ConceptoProveedorPeer::CODIGO_PROVEEDOR);
        $c->addSelectColumn(Tbrh106ConceptoProveedorPeer::DESC_CONCEPTO);
        $c->addAscendingOrderByColumn(Tbrh106ConceptoProveedorPeer::CODIGO_PROVEEDOR);
        $c->addGroupByColumn(Tbrh106ConceptoProveedorPeer::CODIGO_PROVEEDOR);
        $c->addGroupByColumn(Tbrh106ConceptoProveedorPeer::DESC_CONCEPTO);
        $stmt = Tbrh106ConceptoProveedorPeer::doSelectStmt($c);
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

    public function executeStoreAportePatronal(){

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb157AportePatronalPeer::TX_MOVIMIENTO);
        $c->addSelectColumn(Tb157AportePatronalPeer::TX_DESCRIPCION);
        $c->add(Tb157AportePatronalPeer::TX_MOVIMIENTO,array('904', '980', '983', '985'),Criteria::IN);
        $c->addAscendingOrderByColumn(Tb157AportePatronalPeer::TX_DESCRIPCION);
        $stmt = Tb157AportePatronalPeer::doSelectStmt($c);
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
    
  public function executeStorefkMes(){
        $nu_anio      =   $this->getRequestParameter("nu_anio");
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->add(Tb180MaestroContablePeer::NU_ANIO,$nu_anio);
        $c->addSelectColumn(Tb180MaestroContablePeer::CO_MES);
        $c->addAscendingOrderByColumn(Tb180MaestroContablePeer::CO_MES);
        $c->addGroupByColumn(Tb180MaestroContablePeer::CO_MES);
        $stmt = Tb180MaestroContablePeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = array(
            "co_mes"      => str_pad(trim($reg["co_mes"]), 2, "0", STR_PAD_LEFT),
            "tx_mes"      => $this->getMes(trim($reg["co_mes"])),
        );
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
            ));
        $this->setTemplate('store');       
   
    }
    
    protected function getMes($co_mes){
        
        switch ($co_mes) {
            case 1:
                return "ENERO";
                break;
            case 2:
                return "FEBRERO";
                break; 
            case 3:
                return "MARZO";
                break;
            case 4:
                return "ABRIL";
                break;
            case 5:
                return "MAYO";
                break;
            case 6:
                return "JUNIO";
                break;
            case 7:
                return "JULIO";
                break;
            case 8:
                return "AGOSTO";
                break;
            case 9:
                return "SEPTIEMBRE";
                break;
            case 10:
                return "OCTUBRE";
                break;
            case 11:
                return "NOVIEMBRE";
                break;            
            case 12:
                return "DICIEMBRE";
                break;
        }
        
        
        
    }    
  
}
