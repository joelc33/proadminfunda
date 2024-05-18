<?php

/**
 * ConfigConceptoFijo actions.
 *
 * @package    gobel
 * @subpackage ConfigConceptoFijo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConfigConceptoFijoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConfigConceptoFijo', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConfigConceptoFijo', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh086ConceptosFijosPeer::CO_CONCEPTOS_FIJOS,$codigo);
        
        $stmt = Tbrh086ConceptosFijosPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_conceptos_fijos"     => $campos["co_conceptos_fijos"],
                            "co_nom_trabajador"     => $campos["co_nom_trabajador"],
                            "nu_monto"     => $campos["nu_monto"],
                            "nu_valor"     => $campos["nu_valor"],
                            "mo_saldo"     => $campos["mo_saldo"],
                            "fe_movimiento"     => $campos["fe_movimiento"],
                            "fe_vencimiento"     => $campos["fe_vencimiento"],
                            "co_embargo"     => $campos["co_embargo"],
                            "co_tp_formula"     => $campos["co_tp_formula"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "tx_codigo_concepto"     => $campos["tx_codigo_concepto"],
                            "co_concepto_formula"     => $campos["co_concepto_formula"],
                            "co_ficha"     => $campos["co_ficha"],
                            "co_grupo"     => $this->getRequestParameter("grupo"),
                            "co_subgrupo"     => $this->getRequestParameter("subgrupo"),
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_conceptos_fijos"     => "",
                            "co_nom_trabajador"     => "",
                            "nu_monto"     => "",
                            "nu_valor"     => "",
                            "mo_saldo"     => "",
                            "fe_movimiento"     => "",
                            "fe_vencimiento"     => "",
                            "co_embargo"     => "",
                            "co_tp_formula"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "tx_codigo_concepto"     => "",
                            "co_concepto_formula"     => "",
                            "co_ficha"     => $codigo = $this->getRequestParameter("ficha"),
                            "co_grupo"     => $this->getRequestParameter("grupo"),
                            "co_subgrupo"     => $this->getRequestParameter("subgrupo"),
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_conceptos_fijos");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh086_conceptos_fijos = Tbrh086ConceptosFijosPeer::retrieveByPk($codigo);

         try
         { 
           $con->beginTransaction();
          
           $tbrh086_conceptos_fijosForm = $this->getRequestParameter('tbrh086_conceptos_fijos');
   /*CAMPOS*/
                                           
           /*Campo tipo BIGINT */
           //$tbrh086_conceptos_fijos->setCoNomTrabajador($tbrh086_conceptos_fijosForm["co_nom_trabajador"]);
                                                           
           /*Campo tipo NUMERIC */
           $tbrh086_conceptos_fijos->setNuMonto($tbrh086_conceptos_fijosForm["nu_monto"]);
                                                           
           /*Campo tipo NUMERIC */
           $tbrh086_conceptos_fijos->setNuValor($tbrh086_conceptos_fijosForm["nu_valor"]);
                                                           
           /*Campo tipo NUMERIC */
           $tbrh086_conceptos_fijos->setMoSaldo($tbrh086_conceptos_fijosForm["mo_saldo"]);
                                                                   
           /*Campo tipo DATE */
           list($dia, $mes, $anio) = explode("/",$tbrh086_conceptos_fijosForm["fe_movimiento"]);
           $fecha = $anio."-".$mes."-".$dia;
           $tbrh086_conceptos_fijos->setFeMovimiento($fecha);
                                                                   
           /*Campo tipo DATE */
           if (!empty($tbrh086_conceptos_fijosForm["fe_vencimiento"])) {
            list($dia, $mes, $anio) = explode("/",$tbrh086_conceptos_fijosForm["fe_vencimiento"]);
            $fecha = $anio."-".$mes."-".$dia;
            $tbrh086_conceptos_fijos->setFeVencimiento($fecha);
           }
                                                           
           /*Campo tipo BIGINT */
           $tbrh086_conceptos_fijos->setCoEmbargo($tbrh086_conceptos_fijosForm["co_embargo"]);
                                                           
           /*Campo tipo BIGINT */
           $tbrh086_conceptos_fijos->setCoTpFormula($tbrh086_conceptos_fijosForm["co_tp_formula"]);
                                                           
           /*Campo tipo BOOLEAN */
           /*if (array_key_exists("in_activo", $tbrh086_conceptos_fijosForm)){
               $tbrh086_conceptos_fijos->setInActivo(false);
           }else{
               $tbrh086_conceptos_fijos->setInActivo(true);
           }*/
                                                           
           /*Campo tipo TIMESTAMP */
           /*list($dia, $mes, $anio) = explode("/",$tbrh086_conceptos_fijosForm["created_at"]);
           $fecha = $anio."-".$mes."-".$dia;
           $tbrh086_conceptos_fijos->setCreatedAt($fecha);*/
                                                           
           /*Campo tipo TIMESTAMP */
           /*list($dia, $mes, $anio) = explode("/",$tbrh086_conceptos_fijosForm["updated_at"]);
           $fecha = $anio."-".$mes."-".$dia;
           $tbrh086_conceptos_fijos->setUpdatedAt($fecha);/*
                                                           
           /*Campo tipo VARCHAR */
           $tbrh086_conceptos_fijos->setTxCodigoConcepto($tbrh086_conceptos_fijosForm["tx_codigo_concepto"]);
                                                           
           /*Campo tipo BIGINT */
           $tbrh086_conceptos_fijos->setCoConceptoFormula($tbrh086_conceptos_fijosForm["co_concepto_formula"]);
                                                           
           /*Campo tipo BIGINT */
           //$tbrh086_conceptos_fijos->setCoFicha($tbrh086_conceptos_fijosForm["co_ficha"]);
                                   
           /*CAMPOS*/
           $tbrh086_conceptos_fijos->save($con);
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

     }else{
         $tbrh086_conceptos_fijos = new Tbrh086ConceptosFijos();


         try
         { 
           $con->beginTransaction();
          
           $tbrh086_conceptos_fijosForm = $this->getRequestParameter('tbrh086_conceptos_fijos');
   /*CAMPOS*/
                                           
           /*Campo tipo BIGINT */
           //$tbrh086_conceptos_fijos->setCoNomTrabajador($tbrh086_conceptos_fijosForm["co_nom_trabajador"]);
                                                           
           /*Campo tipo NUMERIC */
           $tbrh086_conceptos_fijos->setNuMonto($tbrh086_conceptos_fijosForm["nu_monto"]);
                                                           
           /*Campo tipo NUMERIC */
           $tbrh086_conceptos_fijos->setNuValor($tbrh086_conceptos_fijosForm["nu_valor"]);
                                                           
           /*Campo tipo NUMERIC */
           $tbrh086_conceptos_fijos->setMoSaldo($tbrh086_conceptos_fijosForm["mo_saldo"]);
                                                                   
           /*Campo tipo DATE */
           list($dia, $mes, $anio) = explode("/",$tbrh086_conceptos_fijosForm["fe_movimiento"]);
           $fecha = $anio."-".$mes."-".$dia;
           $tbrh086_conceptos_fijos->setFeMovimiento($fecha);
                                                                   
           /*Campo tipo DATE */
           if (!empty($tbrh086_conceptos_fijosForm["fe_vencimiento"])) {
            list($dia, $mes, $anio) = explode("/",$tbrh086_conceptos_fijosForm["fe_vencimiento"]);
            $fecha = $anio."-".$mes."-".$dia;
            $tbrh086_conceptos_fijos->setFeVencimiento($fecha);
           }
                                                           
           /*Campo tipo BIGINT */
           $tbrh086_conceptos_fijos->setCoEmbargo($tbrh086_conceptos_fijosForm["co_embargo"]);
                                                           
           /*Campo tipo BIGINT */
           $tbrh086_conceptos_fijos->setCoTpFormula($tbrh086_conceptos_fijosForm["co_tp_formula"]);
                                                           
           /*Campo tipo BOOLEAN */
           $tbrh086_conceptos_fijos->setInActivo(true);
                                                           
           /*Campo tipo TIMESTAMP */
           $fecha = date("Y-m-d H:i:s");
           $tbrh086_conceptos_fijos->setCreatedAt($fecha);
                                                           
           /*Campo tipo TIMESTAMP */
           $tbrh086_conceptos_fijos->setUpdatedAt($fecha);
                                                           
           /*Campo tipo VARCHAR */
           $tbrh086_conceptos_fijos->setTxCodigoConcepto($tbrh086_conceptos_fijosForm["tx_codigo_concepto"]);
                                                           
           /*Campo tipo BIGINT */
           $tbrh086_conceptos_fijos->setCoConceptoFormula($tbrh086_conceptos_fijosForm["co_concepto_formula"]);
                                                           
           /*Campo tipo BIGINT */
           $tbrh086_conceptos_fijos->setCoFicha($tbrh086_conceptos_fijosForm["co_ficha"]);
                                   
           /*CAMPOS*/
           $tbrh086_conceptos_fijos->save($con);
           $this->data = json_encode(array(
                       "success" => true,
                       "msg" => 'Concepto creado exitosamente'
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
    }
  

  public function executeEliminar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_conceptos_fijos");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh086_conceptos_fijos = Tbrh086ConceptosFijosPeer::retrieveByPk($codigo);			
	$tbrh086_conceptos_fijos->delete($con);
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
                $co_nom_trabajador      =   $this->getRequestParameter("co_nom_trabajador");
            $nu_monto      =   $this->getRequestParameter("nu_monto");
            $nu_valor      =   $this->getRequestParameter("nu_valor");
            $mo_saldo      =   $this->getRequestParameter("mo_saldo");
            $fe_movimiento      =   $this->getRequestParameter("fe_movimiento");
            $fe_vencimiento      =   $this->getRequestParameter("fe_vencimiento");
            $co_embargo      =   $this->getRequestParameter("co_embargo");
            $co_tp_formula      =   $this->getRequestParameter("co_tp_formula");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $tx_codigo_concepto      =   $this->getRequestParameter("tx_codigo_concepto");
            $co_concepto_formula      =   $this->getRequestParameter("co_concepto_formula");
            $co_ficha      =   $this->getRequestParameter("co_ficha");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_nom_trabajador!=""){$c->add(Tbrh086ConceptosFijosPeer::co_nom_trabajador,$co_nom_trabajador);}
    
                                            if($nu_monto!=""){$c->add(Tbrh086ConceptosFijosPeer::nu_monto,$nu_monto);}
    
                                            if($nu_valor!=""){$c->add(Tbrh086ConceptosFijosPeer::nu_valor,$nu_valor);}
    
                                            if($mo_saldo!=""){$c->add(Tbrh086ConceptosFijosPeer::mo_saldo,$mo_saldo);}
    
                                    
        if($fe_movimiento!=""){
    list($dia, $mes,$anio) = explode("/",$fe_movimiento);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh086ConceptosFijosPeer::fe_movimiento,$fecha);
    }
                                    
        if($fe_vencimiento!=""){
    list($dia, $mes,$anio) = explode("/",$fe_vencimiento);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh086ConceptosFijosPeer::fe_vencimiento,$fecha);
    }
                                            if($co_embargo!=""){$c->add(Tbrh086ConceptosFijosPeer::co_embargo,$co_embargo);}
    
                                            if($co_tp_formula!=""){$c->add(Tbrh086ConceptosFijosPeer::co_tp_formula,$co_tp_formula);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh086ConceptosFijosPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh086ConceptosFijosPeer::updated_at,$fecha);
    }
                                        if($tx_codigo_concepto!=""){$c->add(Tbrh086ConceptosFijosPeer::tx_codigo_concepto,'%'.$tx_codigo_concepto.'%',Criteria::LIKE);}
        
                                            if($co_concepto_formula!=""){$c->add(Tbrh086ConceptosFijosPeer::co_concepto_formula,$co_concepto_formula);}
    
                                            //if($co_ficha!=""){$c->add(Tbrh086ConceptosFijosPeer::CO_FICHA,$co_ficha);}
    
                    }
    $c->setIgnoreCase(true);
    $c->add(Tbrh086ConceptosFijosPeer::CO_FICHA,$co_ficha);

    $cantidadTotal = Tbrh086ConceptosFijosPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tbrh086ConceptosFijosPeer::CO_CONCEPTOS_FIJOS);

    $c->clearSelectColumns();

    $c->addSelectColumn(Tbrh086ConceptosFijosPeer::CO_CONCEPTOS_FIJOS);
    $c->addSelectColumn(Tbrh086ConceptosFijosPeer::CO_NOM_TRABAJADOR);
    $c->addSelectColumn(Tbrh086ConceptosFijosPeer::NU_MONTO);
    $c->addSelectColumn(Tbrh086ConceptosFijosPeer::NU_VALOR);
    $c->addSelectColumn(Tbrh086ConceptosFijosPeer::MO_SALDO);
    $c->addSelectColumn(Tbrh086ConceptosFijosPeer::FE_MOVIMIENTO);
    $c->addSelectColumn(Tbrh086ConceptosFijosPeer::FE_VENCIMIENTO);
    $c->addSelectColumn(Tbrh086ConceptosFijosPeer::TX_CODIGO_CONCEPTO);
    $c->addSelectColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
    $c->addSelectColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
    $c->addSelectColumn(Tbrh014ConceptoPeer::TX_CONCEPTO);

    $c->addJoin(Tbrh086ConceptosFijosPeer::CO_CONCEPTO_FORMULA, Tbrh014ConceptoPeer::CO_CONCEPTO, Criteria::LEFT_JOIN);
        
    $stmt = Tbrh086ConceptosFijosPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_conceptos_fijos"     => trim($res["co_conceptos_fijos"]),
            "co_nom_trabajador"     => trim($res["co_nom_trabajador"]),
            "nu_monto"     => trim($res["nu_monto"]),
            "nu_valor"     => trim($res["nu_valor"]),
            "mo_saldo"     => trim($res["mo_saldo"]),
            "fe_movimiento"     => trim($res["fe_movimiento"]),
            "fe_vencimiento"     => trim($res["fe_vencimiento"]),
            "co_embargo"     => trim($res["co_embargo"]),
            "co_tp_formula"     => trim($res["co_tp_formula"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "tx_codigo_concepto"     => trim($res["tx_codigo_concepto"]),
            "co_concepto_formula"     => trim($res["co_concepto_formula"]),
            "co_ficha"     => trim($res["co_ficha"]),
            "nu_concepto"     => trim($res["nu_concepto"]),
            "tx_concepto"     => trim($res["tx_concepto"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

             
    public function executeIndividual(sfWebRequest $request)
    {

      $this->data = json_encode(array(
        "co_rol"         => $this->getUser()->getAttribute('rol'),
        "co_usuario"     => $this->getUser()->getAttribute('codigo'),
      ));    
  
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
          $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_ENTE);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_EDO_CIVIL);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::FE_NACIMIENTO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_TP_MOTRICIDA);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_HIJO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::TX_DIRECCION_DOMICILIO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_PARROQUIA_DOMICILIO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::TX_CIUDAD_DOMICILIO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::TX_CIUDAD_NACIMIENTO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_PARROQUIA_NACIMIENTO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_NACIONALIDAD);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_SEGURO_SOCIAL);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_RIF);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_NIVEL_EDUCATIVO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_ANIO_APROBADO_EDUCATIVO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_PROFESION);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::FE_GRADUACION);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::TX_CORREO_ELECTRONICO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_SOLICITUD);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_DOCUMENTO_ENTREVISTADOR);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::TX_OBSERVACION);
          //$c->addSelectColumn(Tb017MunicipioPeer::CO_MUNICIPIO);
          //$c->addSelectColumn(Tb016EstadoPeer::CO_ESTADO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_TELEFONO_CONTACTO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_TELEFONO_SECUNDARIO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_BANCO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CUENTA_BANCARIA);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_GRUPO_SANGUINEO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_ESTATURA);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_PESO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::IN_LENTE);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::IN_VEHICULO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_GRADO_LICENCIA); //562120
          $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_DESTREZA);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_TIPO_VIVIENDA);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::TX_RUTA_IMAGEN);
          $c->addSelectColumn(Tbrh002FichaPeer::FE_INGRESO);
          $c->addSelectColumn(Tbrh002FichaPeer::CO_FICHA);
          //$c->addSelectColumn(Tbrh105IngresoTrabajadorPeer::CO_INGRESO_TRABAJADOR);
          
          //$c->addJoin(Tbrh001TrabajadorPeer::CO_ESTADO,Tb016EstadoPeer::CO_ESTADO, Criteria::LEFT_JOIN);
          //$c->addJoin(Tbrh001TrabajadorPeer::CO_MUNICIPIO, Tb017MunicipioPeer::CO_MUNICIPIO, Criteria::LEFT_JOIN);
          //$c->addJoin(Tb170ParroquiaPeer::CO_PARROQUIA, Tbrh001TrabajadorPeer::CO_PARROQUIA_DOMICILIO, Criteria::LEFT_JOIN);
          //$c->addJoin(Tbrh001TrabajadorPeer::CO_TRABAJADOR, Tbrh002FichaPeer::CO_TRABAJADOR, Criteria::LEFT_JOIN);
          $c->addJoin(Tbrh001TrabajadorPeer::CO_TRABAJADOR, Tbrh002FichaPeer::CO_TRABAJADOR,  Criteria::LEFT_JOIN);
          //$c->add(Tbrh105IngresoTrabajadorPeer::CO_INGRESO_TRABAJADOR,$codigo);
          $c->add(Tbrh001TrabajadorPeer::CO_TRABAJADOR,$codigo);
        //  $c->add(Tbrh002FichaPeer::CO_ESTATUS,1);
          
          //echo $c->toString(); exit();
          
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
                          "co_ingreso_trabajador"     => $campos["co_ingreso_trabajador"],
                          "nu_cedula"                 => $campos["nu_cedula"],
                          "nb_primer_nombre"          => $campos["nb_primer_nombre"],
                          "nb_segundo_nombre"         => $campos["nb_segundo_nombre"],
                          "nb_primer_apellido"        => $campos["nb_primer_apellido"],
                          "nb_segundo_apellido"       => $campos["nb_segundo_apellido"],
                          "co_documento"              => $campos["co_documento"],
                          "co_ente"                   => $campos["co_ente"],
                          "co_edo_civil"              => $campos["co_edo_civil"],
                          "fe_nacimiento"             => $campos["fe_nacimiento"],
                          "fe_ingreso"                => $campos["fe_ingreso"],
                          "co_tp_motricida"           => $campos["co_tp_motricida"],
                          "nu_hijo"                   => $campos["nu_hijo"],
                          "tx_direccion_domicilio"    => $campos["tx_direccion_domicilio"],
                          "co_parroquia_domicilio"    => $campos["co_parroquia_domicilio"],
                          "tx_ciudad_domicilio"       => $campos["tx_ciudad_domicilio"],
                          "tx_ciudad_nacimiento"      => $campos["tx_ciudad_nacimiento"],
                          "co_parroquia_nacimiento"   => $campos["co_parroquia_nacimiento"],
                          "co_nacionalidad"           => $campos["co_nacionalidad"],
                          "nu_seguro_social"          => $campos["nu_seguro_social"],
                          "nu_rif"                    => $campos["nu_rif"],
                          "created_at"                => $campos["created_at"],
                          "updated_at"                => $campos["updated_at"],
                          "co_nivel_educativo"        => $campos["co_nivel_educativo"],
                          "nu_anio_aprobado_educativo"=> $campos["nu_anio_aprobado_educativo"],
                          "co_profesion"              => $campos["co_profesion"],
                          "fe_graduacion"             => $campos["fe_graduacion"],
                          "tx_correo_electronico"     => $campos["tx_correo_electronico"],
                          "co_solicitud"              => $campos["co_solicitud"],
                          "co_estado"                 => $campos["co_estado"],
                          "co_municipio"              => $campos["co_municipio"],
                          "co_documento_entrevistador"=> $campos["co_documento_entrevistador"],
                          "tx_observacion"            => $campos["tx_observacion"],
                          "nu_telefono_contacto"      => $campos["nu_telefono_contacto"],
                          "nu_telefono_secundario"    => $campos["nu_telefono_secundario"],
                          "tx_correo_electronico"     => $campos["tx_correo_electronico"],
                          "co_banco"                  => $campos["co_banco"],
                          "nu_cuenta_bancaria"        => $campos["nu_cuenta_bancaria"],
                          "co_grupo_sanguineo"        => $campos["co_grupo_sanguineo"],
                          "nu_estatura"               => $campos["nu_estatura"],
                          "nu_peso"                   => $campos["nu_peso"],
                          "in_lente"                  => $campos["in_lente"],
                          "in_vehiculo"               => $campos["in_vehiculo"],
                          "nu_grado_licencia"         => $campos["nu_grado_licencia"],
                          "co_destreza"               => $campos["co_destreza"],
                          "co_tipo_vivienda"          => $campos["co_tipo_vivienda"],
                          "co_ficha"          => $campos["co_ficha"],
                          "foto"                      => $foto
                  ));
      }else{
          
                      $imagen = new myConfig();
                      $foto = $imagen->getDirectorio().'foto/bust-in-silhouette.png';
                      $imagen->setConvertToURL($foto);
                      $foto = $imagen->getConvertToURL();
          
                  $this->data = json_encode(array(
                          "co_trabajador"               => "",
                          "co_ingreso_trabajador"       => "",
                          "nu_cedula"                   => "",
                          "nb_primer_nombre"            => "",
                          "nb_segundo_nombre"           => "",
                          "nb_primer_apellido"          => "",
                          "nb_segundo_apellido"         => "",
                          "co_documento"                => "",
                          "co_ente"                     => "",
                          "co_edo_civil"                => "",
                          "fe_nacimiento"               => "",
                          "co_tp_motricida"             => "",
                          "nu_hijo"                     => "",
                          "tx_direccion_domicilio"      => "",
                          "co_parroquia_domicilio"      => "",
                          "tx_ciudad_domicilio"         => "",
                          "tx_ciudad_nacimiento"        => "",
                          "co_parroquia_nacimiento"     => "",
                          "co_nacionalidad"             => "",
                          "nu_seguro_social"            => "",
                          "nu_rif"                      => "",
                          "created_at"                  => "",
                          "updated_at"                  => "",
                          "co_nivel_educativo"          => "",
                          "nu_anio_aprobado_educativo"  => "",
                          "co_profesion"                => "",
                          "fe_graduacion"               => "",
                          "tx_correo_electronico"       => "",
                          "co_solicitud"                => $this->getRequestParameter("co_solicitud"),
                          "co_estado"                   => "",
                          "co_municipio"                => "",
                          "co_documento_entrevistador"  => "",
                          "tx_observacion"              => "",
                          "nu_telefono_contacto"        => "",
                          "nu_telefono_secundario"      => "",
                          "tx_correo_electronico"       => "",
                          "co_banco"                    => "",
                          "nu_cuenta_bancaria"          => "",
                          "co_grupo_sanguineo"          => "",
                          "nu_estatura"                 => "",
                          "nu_peso"                     => "",
                          "in_lente"                    => "",
                          "in_vehiculo"                 => "",
                          "nu_grado_licencia"           => "",
                          "co_destreza"                 => "",
                          "co_tipo_vivienda"            => "",
                          "co_ficha"               => "",
                          "foto"                        => $foto
                  ));
      }
        
    }

    public function executeConsulta(sfWebRequest $request)
    {
       $codigo = $this->getRequestParameter("codigo");
       $this->DatosEmpleado($codigo);
    } 

    //modelo fk tbrh023_nom_frecuencia_pago.CO_NOM_FRECUENCIA_PAGO
    public function executeStorefkcoconceptoformula(sfWebRequest $request){

      $grupo = $this->getRequestParameter("grupo");
      $subgrupo = $this->getRequestParameter("subgrupo");

      /*$c = new Criteria();
      $stmt = Tbrh014ConceptoPeer::doSelectStmt($c);
      $registros = array();*/

      $c = new Criteria();
      $c->clearSelectColumns();
      $c->addSelectColumn(Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO);
      $c->addSelectColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
      $c->addSelectColumn(Tbrh014ConceptoPeer::TX_CONCEPTO);
      $c->addSelectColumn(Tbrh014ConceptoPeer::DE_OBSERVACION);
      $c->addJoin(Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO, Tbrh014ConceptoPeer::CO_CONCEPTO);
      //$c->add(Tbrh026ConcepTipoNominaPeer::CO_TP_NOMINA, $grupo);
      //$c->add(Tbrh026ConcepTipoNominaPeer::CO_GRUPO_NOMINA, $subgrupo);
      $c->add(Tbrh026ConcepTipoNominaPeer::CO_TP_NOMINA, $grupo, Criteria::IN);
      $c->add(Tbrh026ConcepTipoNominaPeer::CO_GRUPO_NOMINA, $subgrupo, Criteria::IN);
      $c->addAscendingOrderByColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
      
      $stmt = Tbrh026ConcepTipoNominaPeer::doSelectStmt($c);
      $registros = array();

      /*while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
          $registros[] = $reg;
      }*/

      while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = array(
                "co_concepto_formula"     => trim($res["co_concepto"]),
                "nu_concepto"     => trim($res["nu_concepto"]),
                "tx_concepto"     => trim($res["tx_concepto"]),
                "de_observacion"     => trim($res["de_observacion"]),
            );
        }

      $this->data = json_encode(array(
          "success"   =>  true,
          "total"     =>  count($registros),
          "data"      =>  $registros
          ));
      $this->setTemplate('store');
  }

  public function executeStorelistaNomina(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",2000);
    $start      =   $this->getRequestParameter("start",0);
                $co_concepto      =   $this->getRequestParameter("co_concepto");
            $co_tp_nomina      =   $this->getRequestParameter("co_tp_nomina");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    //if($co_concepto!=""){$c->add(Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO,$co_concepto);}
    
                                            if($co_tp_nomina!=""){$c->add(Tbrh026ConcepTipoNominaPeer::co_tp_nomina,$co_tp_nomina);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh026ConcepTipoNominaPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh026ConcepTipoNominaPeer::updated_at,$fecha);
    }
                    }
                    
    $c->setIgnoreCase(true);
    //$cantidadTotal = Tbrh026ConcepTipoNominaPeer::doCount($c);
    
    //$c->setLimit($limit)->setOffset($start);
        //$c->addAscendingOrderByColumn(Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO_TIPO_NOMINA);

        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO_TIPO_NOMINA);
        $c->addSelectColumn(Tbrh017TpNominaPeer::CO_TP_NOMINA);
        $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
        $c->addSelectColumn(Tbrh017TpNominaPeer::NU_NOMINA);
        $c->addSelectColumn(Tbrh067GrupoNominaPeer::COD_GRUPO_NOMINA);

        $c->addJoin(Tbrh026ConcepTipoNominaPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
        $c->addJoin(Tbrh026ConcepTipoNominaPeer::CO_GRUPO_NOMINA, Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);

        $c->add(Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO,$co_concepto);

        $cantidadTotal = Tbrh026ConcepTipoNominaPeer::doCount($c);

        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO_TIPO_NOMINA);
        
    $stmt = Tbrh026ConcepTipoNominaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_concepto_tipo_nomina"     => trim($res["co_concepto_tipo_nomina"]),
            "co_concepto"     => trim($res["co_concepto"]),
            "nu_nomina"     => trim($res["nu_nomina"]),
            "co_tp_nomina"     => trim($res["co_tp_nomina"]),
            "tx_tp_nomina"     => trim($res["tx_tp_nomina"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "cod_grupo_nomina"     => trim($res["cod_grupo_nomina"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

}