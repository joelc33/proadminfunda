<?php

/**
 * autoTraslados actions.
 * NombreClaseModel(Tbrh015NomTrabajador)
 * NombreTabla(tbrh015_nom_trabajador)
 * @package    ##PROJECT_NAME##
 * @subpackage autoTraslados
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class TrasladosActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Traslados', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Traslados', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    $co_solicitud = $this->getRequestParameter("co_solicitud");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh107TraladosPeer::CO_TRASLADOS,$codigo);
        
        $stmt = Tbrh107TraladosPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_solicitud"     => $co_solicitud,
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_solicitud"     => $co_solicitud,
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_traslados");
     $co_solicitud = $this->getRequestParameter("co_solicitud");
     $co_ficha = $this->getRequestParameter("co_ficha");
     $co_nom_trabajador_anterior = $this->getRequestParameter("co_nom_trabajador");
     $fe_traslado = $this->getRequestParameter("fe_traslado");
     $co_tp_nomina = $this->getRequestParameter("co_tp_nomina");
     $co_grupo_nomina = $this->getRequestParameter("co_grupo_nomina");
     $co_cargo_estructura = $this->getRequestParameter("co_cargo_estructura");
     $nu_horas = $this->getRequestParameter("nu_horas");
     $mo_salario_base = $this->getRequestParameter("mo_salario_base");
     $co_tp_cargo = $this->getRequestParameter("co_tp_cargo");
     $tx_tp_nomina = $this->getRequestParameter("tx_tp_nomina");
     $tx_grupo_nomina = $this->getRequestParameter("tx_grupo_nomina");
     $tx_cargo_estructura = $this->getRequestParameter("estructura").' -'.$this->getRequestParameter("tx_cargo_estructura");
     $tx_tipo_cargo = $this->getRequestParameter("tx_tipo_cargo");
     $co_tipo_pago = $this->getRequestParameter("co_tipo_pago");
     $co_tabulador = $this->getRequestParameter("co_tabulador");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh107_traslados = Tbrh107TraladosPeer::retrieveByPk($codigo);
     }else{
         $tbrh107_traslados = new Tbrh107Tralados();
     }
     try
      { 
        $con->beginTransaction();

/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tbrh107_traslados->setCoSolicitud($co_solicitud);
                                                        
        /*Campo tipo BIGINT */
        $tbrh107_traslados->setCoFicha($co_ficha);
                                                        
        /*Campo tipo BIGINT */
        $tbrh107_traslados->setCoNomTrabajadorAnterior($co_nom_trabajador_anterior);
        
        list($dia, $mes, $anio) = explode("/",$fe_traslado);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh107_traslados->setFeTraslado($fecha);        
                                                        
        /*Campo tipo BIGINT */
        $tbrh107_traslados->setCoTpNomina($co_tp_nomina);
        
        $tbrh107_traslados->setCoGrupoNomina($co_grupo_nomina);
        
        $tbrh107_traslados->setCoCargoEstructura($co_cargo_estructura);
                                                                                                 
        /*Campo tipo NUMERIC */
        $tbrh107_traslados->setNuHoras($nu_horas);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh107_traslados->setMoSalarioBase($mo_salario_base);
                                                        
        /*Campo tipo BIGINT */
        $tbrh107_traslados->setCoTpCargo($co_tp_cargo);
        
        //$tbrh107_traslados->setInAprobacion(FALSE);
        
        $tbrh107_traslados->setTxTpNomina($tx_tp_nomina);
        
        $tbrh107_traslados->setTxGrupoNomina($tx_grupo_nomina);
        
        $tbrh107_traslados->setTxCargoEstructura($tx_cargo_estructura);
        
        $tbrh107_traslados->setTxTipoCargo($tx_tipo_cargo);
        
        $tbrh107_traslados->setCoTipoPago($co_tipo_pago);
        
        $tbrh107_traslados->setCoTabulador(($co_tabulador!='')?$co_tabulador:NULL);

        /*CAMPOS*/
        $tbrh107_traslados->save($con);
        
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
        $c1 = new Criteria();
        $c1->add(Tbrh107TraladosPeer::CO_SOLICITUD,$co_solicitud);
        $cant = Tbrh107TraladosPeer::doCount($c1);

        if($cant > 0){                
            $ruta->setInCargarDato(true)->save($con);
        }        
        
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
	$codigo = $this->getRequestParameter("co_traslados");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh107_traslados = Tbrh107TraladosPeer::retrieveByPk($codigo);			
	$tbrh107_traslados->delete($con);
        
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tbrh107_traslados->getCoSolicitud()));
        $c1 = new Criteria();
        $c1->add(Tbrh107TraladosPeer::CO_SOLICITUD,$tbrh107_traslados->getCoSolicitud());
        $cant = Tbrh107TraladosPeer::doCount($c1);

        if($cant == 0){                
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
//		    "msg" =>  $e->getMessage()
		    "msg" => 'Este registro no se puede borrar porque <br>se encuentra asociado a otros registros'
		));
	}
  }
  
  public function executeAprobar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_traslados");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh107_traslados = Tbrh107TraladosPeer::retrieveByPk($codigo);			
	$tbrh107_traslados->setInAprobacion(true);
        $tbrh107_traslados->save($con);
        
        $tbrh015_nom_trabajador = new Tbrh015NomTrabajador();
        $tbrh015_nom_trabajador->setCoFicha($tbrh107_traslados->getCoFicha());
        $tbrh015_nom_trabajador->setCoTpNomina($tbrh107_traslados->getCoTpNomina());
        $tbrh015_nom_trabajador->setCoGrupoNomina($tbrh107_traslados->getCoGrupoNomina());
        $tbrh015_nom_trabajador->setCoCargoEstructura($tbrh107_traslados->getCoCargoEstructura());
        if($tbrh107_traslados->getCoTipoPago()==1){
        $tbrh015_nom_trabajador->setInSueldoTab(TRUE);
        }else{
        $tbrh015_nom_trabajador->setInSueldoTab(FALSE);    
        }
        $tbrh015_nom_trabajador->setNuHoras($tbrh107_traslados->getNuHoras());
        $tbrh015_nom_trabajador->setMoSalarioBase($tbrh107_traslados->getMoSalarioBase());
        $tbrh015_nom_trabajador->setCoTpCargo($tbrh107_traslados->getCoTpCargo());
        $tbrh015_nom_trabajador->setFeIngreso($tbrh107_traslados->getFeTraslado());
        //$tbrh015_nom_trabajador->setFeFiniquito(NULL);
        $tbrh015_nom_trabajador->setInActivo(TRUE);
        $tbrh015_nom_trabajador->setCoSolicitud($tbrh107_traslados->getCoSolicitud());
        $tbrh015_nom_trabajador->setInCestaticket(true);
        $tbrh015_nom_trabajador->setCoTabulador($tbrh107_traslados->getCoTabulador());
        $tbrh015_nom_trabajador->save($con);
        
        $tbrh015_nom_trabajador_anterior = Tbrh015NomTrabajadorPeer::retrieveByPk($tbrh107_traslados->getCoNomTrabajadorAnterior()); 
        $tbrh015_nom_trabajador_anterior->setInActivo(FALSE);
        $tbrh015_nom_trabajador_anterior->setCoUsuario($this->getUser()->getAttribute('codigo'));
        $tbrh015_nom_trabajador_anterior->setFeFiniquito($tbrh107_traslados->getFeTraslado());
        $tbrh015_nom_trabajador_anterior->save($con);
                
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tbrh107_traslados->getCoSolicitud()));
        $c1 = new Criteria();
        $c1->add(Tbrh107TraladosPeer::CO_SOLICITUD,$tbrh107_traslados->getCoSolicitud());
        $c1->add(Tbrh107TraladosPeer::IN_APROBACION,NULL, Criteria::ISNULL);
        $cant = Tbrh107TraladosPeer::doCount($c1);

        if($cant == 0){                
            $ruta->setInCargarDato(true)->save($con);
        }        
		$this->data = json_encode(array(
			    "success" => true,
			    "msg" => 'Traslado Aprobado con exito!'
		));
	$con->commit();
	}catch (PropelException $e)
	{
	$con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
		    "msg" =>  $e->getMessage()
//		    "msg" => 'Este registro no se puede borrar porque <br>se encuentra asociado a otros registros'
		));
	}
  } 
  
  public function executeRechazar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_traslados");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh107_traslados = Tbrh107TraladosPeer::retrieveByPk($codigo);			
	$tbrh107_traslados->setInAprobacion(false);
        $tbrh107_traslados->save($con);
                
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tbrh107_traslados->getCoSolicitud()));
        $c1 = new Criteria();
        $c1->add(Tbrh107TraladosPeer::CO_SOLICITUD,$tbrh107_traslados->getCoSolicitud());
        $c1->add(Tbrh107TraladosPeer::IN_APROBACION,NULL, Criteria::ISNULL);
        $cant = Tbrh107TraladosPeer::doCount($c1);

        if($cant == 0){                
            $ruta->setInCargarDato(true)->save($con);
        }        
		$this->data = json_encode(array(
			    "success" => true,
			    "msg" => 'Traslado Aprobado con exito!'
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
      
       $this->co_solicitud = $this->getRequestParameter("co_solicitud");
        $this->co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
         $this->co_proceso = $this->getRequestParameter("co_proceso");

  }

  public function executeAprobacion(sfWebRequest $request)
  {
      
       $this->co_solicitud = $this->getRequestParameter("co_solicitud");
        $this->co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
         $this->co_proceso = $this->getRequestParameter("co_proceso");

  }  
  
  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
            $co_solicitud      =   $this->getRequestParameter("co_solicitud");    
    
    $c = new Criteria();   
    $c->clearSelectColumns();
    $c->addSelectColumn(Tbrh107TraladosPeer::CO_TRASLADOS);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CEDULA);        
    $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
    $c->addSelectColumn(Tbrh005EstructuraAdministrativaPeer::TX_NOM_ESTRUCTURA_ADMINISTRATIVA);
    $c->addSelectColumn(Tbrh032CargoPeer::TX_CARGO);
    $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
    $c->addSelectColumn(Tbrh067GrupoNominaPeer::TX_GRUPO_NOMINA);
    $c->addSelectColumn('(' . Tbrh015NomTrabajadorPeer::MO_SALARIO_BASE . ') as mo_salario_anterior'); 
    $c->addSelectColumn('(' . Tbrh107TraladosPeer::TX_TP_NOMINA . ') as tx_nomina'); 
    $c->addSelectColumn('(' . Tbrh107TraladosPeer::TX_GRUPO_NOMINA . ') as grupo_nomina'); 
    $c->addSelectColumn('(' . Tbrh107TraladosPeer::TX_CARGO_ESTRUCTURA . ') as tx_cargo_estructura'); 
    $c->addSelectColumn('(' . Tbrh107TraladosPeer::TX_TIPO_CARGO . ') as tx_tipo_cargo'); 
    $c->addSelectColumn(Tbrh107TraladosPeer::MO_SALARIO_BASE);
    $c->addSelectColumn(Tbrh107TraladosPeer::NU_HORAS);
    $c->addSelectColumn(Tbrh107TraladosPeer::FE_TRASLADO);
    $c->addSelectColumn("cast(".Tbrh107TraladosPeer::IN_APROBACION." as text) as in_aprobacion");

    $c->addJoin(Tbrh002FichaPeer::CO_FICHA, Tbrh107TraladosPeer::CO_FICHA);
    $c->addJoin(Tbrh001TrabajadorPeer::CO_TRABAJADOR, Tbrh002FichaPeer::CO_TRABAJADOR);
    $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tbrh001TrabajadorPeer::CO_DOCUMENTO);
    $c->addJoin(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR, Tbrh107TraladosPeer::CO_NOM_TRABAJADOR_ANTERIOR);
    $c->addJoin(Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA, Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA);
    $c->addJoin(Tbrh032CargoPeer::CO_CARGO, Tbrh009CargoEstructuraPeer::CO_CARGO);
    $c->addJoin(Tbrh005EstructuraAdministrativaPeer::CO_ESTRUCTURA_ADMINISTRATIVA, Tbrh009CargoEstructuraPeer::CO_ESTRUCTURA_ADMINISTRATIVA);
    $c->addJoin(Tbrh017TpNominaPeer::CO_TP_NOMINA, Tbrh015NomTrabajadorPeer::CO_TP_NOMINA);
    $c->addJoin(Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA, Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA);
    $c->add(Tbrh107TraladosPeer::CO_SOLICITUD,$co_solicitud);
    $cantidadTotal = Tbrh107TraladosPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tbrh107TraladosPeer::CO_TRASLADOS);
        
    $stmt = Tbrh107TraladosPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_traslados"     => trim($res["co_traslados"]),
            "nu_cedula"     => trim($res["inicial"].' - '.$res["nu_cedula"]),
            "nombre"     => trim($res["nb_primer_nombre"]. ' '.$res["nb_primer_apellido"]),
            "tx_estructura_anterior"     => trim($res["tx_nom_estructura_administrativa"].' - '.$res["tx_cargo"]),
            "tx_nomina_anterior"     => trim($res["tx_tp_nomina"].' - '.$res["tx_grupo_nomina"]),
            "mo_salario_anterior"     => trim($res["mo_salario_anterior"]),
            "tx_nomina"     => trim($res["tx_nomina"].' - '.$res["grupo_nomina"]),
            "tx_cargo_estructura"     => trim($res["tx_cargo_estructura"]),
            "tx_tipo_cargo"     => trim($res["tx_tipo_cargo"]),
            "mo_salario_base"     => trim($res["mo_salario_base"]),
            "nu_horas"     => trim($res["nu_horas"]),
            "fe_traslado"     => trim($res["fe_traslado"]),
            "in_aprobacion"     => trim($res["in_aprobacion"]==NULL?'Pendiente':$res["in_aprobacion"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

    public function executeVerificarTrabajador(sfWebRequest $request)
    {

          $nu_cedula     = $this->getRequestParameter('nu_cedula');

          $c = new Criteria(); 
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
          $c->addSelectColumn(Tbrh002FichaPeer::CO_FICHA);
          $c->addJoin(Tbrh001TrabajadorPeer::CO_TRABAJADOR,Tbrh002FichaPeer::CO_TRABAJADOR);
          $c->add(Tbrh001TrabajadorPeer::NU_CEDULA,$nu_cedula);
          $c->add(Tbrh002FichaPeer::CO_ESTATUS,array(1,9,10), Criteria::IN);
          
          $stmt = Tbrh001TrabajadorPeer::doSelectStmt($c);

          $registros = $stmt->fetch(PDO::FETCH_ASSOC);
          
          $this->data = json_encode(array(
              "success"   => true,
              "data"      => $registros
          ));
          $this->setTemplate('store');
    }   
    
     public function executeStorefkcocargoestructura(sfWebRequest $request){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR);
        $c->addSelectColumn(Tbrh005EstructuraAdministrativaPeer::TX_NOM_ESTRUCTURA_ADMINISTRATIVA);
        $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
        $c->addSelectColumn(Tbrh067GrupoNominaPeer::TX_GRUPO_NOMINA);
        $c->addSelectColumn(Tbrh084TipoCargoPeer::TX_TIPO_CARGO);
        $c->addSelectColumn(Tbrh032CargoPeer::TX_CARGO);
        $c->addJoin(Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA, Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA);
        $c->addJoin(Tbrh032CargoPeer::CO_CARGO, Tbrh009CargoEstructuraPeer::CO_CARGO);
        $c->addJoin(Tbrh005EstructuraAdministrativaPeer::CO_ESTRUCTURA_ADMINISTRATIVA, Tbrh009CargoEstructuraPeer::CO_ESTRUCTURA_ADMINISTRATIVA);
        $c->addJoin(Tbrh017TpNominaPeer::CO_TP_NOMINA, Tbrh015NomTrabajadorPeer::CO_TP_NOMINA);
        $c->addJoin(Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA, Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA);
        $c->addJoin(Tbrh084TipoCargoPeer::CO_TP_CARGO, Tbrh015NomTrabajadorPeer::CO_TP_CARGO);
        $c->add(Tbrh015NomTrabajadorPeer::CO_FICHA,$this->getRequestParameter("co_ficha"));
        $c->add(Tbrh015NomTrabajadorPeer::IN_ACTIVO,true);
        $c->addAscendingOrderByColumn(Tbrh032CargoPeer::TX_CARGO);
        $stmt = Tbrh015NomTrabajadorPeer::doSelectStmt($c);
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