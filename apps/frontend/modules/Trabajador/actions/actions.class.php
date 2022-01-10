<?php

/**
 * autoTrabajador actions.
 * NombreClaseModel(Tbrh001Trabajador)
 * NombreTabla(tbrh001_trabajador)
 * @package    ##PROJECT_NAME##
 * @subpackage autoTrabajador
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class TrabajadorActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Trabajador', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Trabajador', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }
  
  public function executeAgregarSueldo(sfWebRequest $request){     
      
       $co_nom_trabajador             =  $this->getRequestParameter("co_nom_trabajador");
       $co_tp_nomina                  =  $this->getRequestParameter("co_tp_nomina");
       $co_tp_cargo                   =  $this->getRequestParameter("co_tp_cargo");
       $co_grupo_nomina               =  $this->getRequestParameter("co_grupo_nomina");
       $fe_ingreso                    =  $this->getRequestParameter("fe_ingreso");
       $co_cargo_estructura           =  $this->getRequestParameter("co_cargo_estructura");
       $mo_salario_base               =  $this->getRequestParameter("mo_salario_base");
       $co_tipo_pago                  =  $this->getRequestParameter("co_tipo_pago");
       $nu_horas                      =  $this->getRequestParameter("nu_horas");
       $co_tabulador                  =  $this->getRequestParameter("co_tabulador");
       $co_clasif_personal            =  $this->getRequestParameter("co_clasif_personal");
       $co_estructura_administrativa  = $this->getRequestParameter("co_estructura_administrativa");
       $tx_estructura                 = $this->getRequestParameter("tx_estructura");
       $co_ficha                 = $this->getRequestParameter("co_ficha");
       $rowIndex                      = $this->getRequestParameter("rowIndex");
      
      
      $this->data = json_encode(array("co_nom_trabajador"            => $co_nom_trabajador,
                                      "co_tp_nomina"                 => $co_tp_nomina,
                                      "co_grupo_nomina"              => $co_grupo_nomina,
                                      "fe_ingreso"                   => $fe_ingreso,
                                      "co_tp_cargo"                  => $co_tp_cargo,
                                      "co_cargo_estructura"          => $co_cargo_estructura,
                                      "mo_salario_base"              => $mo_salario_base,
                                      "co_tipo_pago"                 => $co_tipo_pago,
                                      "nu_horas"                     => $nu_horas,
                                      "co_tabulador"                 => $co_tabulador,
                                      "co_clasif_personal"           => $co_clasif_personal,
                                      "co_estructura_administrativa" => $co_estructura_administrativa,
                                      "tx_estructura"                => $tx_estructura,
                                      "co_ficha"                    => $co_ficha,
                                      "rowIndex"                     => $rowIndex));
  }

  public function executeAgregarSueldo2(sfWebRequest $request){     
      
       $co_nom_trabajador             =  $this->getRequestParameter("co_nom_trabajador");
       $co_tp_nomina                  =  $this->getRequestParameter("co_tp_nomina");
       $co_tp_cargo                   =  $this->getRequestParameter("co_tp_cargo");
       $co_grupo_nomina               =  $this->getRequestParameter("co_grupo_nomina");
       $fe_ingreso                    =  $this->getRequestParameter("fe_ingreso");
       $co_cargo_estructura           =  $this->getRequestParameter("co_cargo_estructura");
       $mo_salario_base               =  $this->getRequestParameter("mo_salario_base");
       $co_tipo_pago                  =  $this->getRequestParameter("co_tipo_pago");
       $nu_horas                      =  $this->getRequestParameter("nu_horas");
       $co_tabulador                  =  $this->getRequestParameter("co_tabulador");
       $co_clasif_personal            =  $this->getRequestParameter("co_clasif_personal");
       $co_estructura_administrativa  = $this->getRequestParameter("co_estructura_administrativa");
       $tx_estructura                 = $this->getRequestParameter("tx_estructura");
       $co_ficha                 = $this->getRequestParameter("co_ficha");
       $co_estatus                 = $this->getRequestParameter("co_estatus");
       $in_cestaticket                 = $this->getRequestParameter("in_cestaticket");
       
       $rowIndex                      = $this->getRequestParameter("rowIndex");
      
      
      $this->data = json_encode(array("co_nom_trabajador"            => $co_nom_trabajador,
                                      "co_tp_nomina"                 => $co_tp_nomina,
                                      "co_grupo_nomina"              => $co_grupo_nomina,
                                      "fe_ingreso"                   => $fe_ingreso,
                                      "co_tp_cargo"                  => $co_tp_cargo,
                                      "co_cargo_estructura"          => $co_cargo_estructura,
                                      "mo_salario_base"              => $mo_salario_base,
                                      "co_tipo_pago"                 => $co_tipo_pago,
                                      "nu_horas"                     => $nu_horas,
                                      "co_tabulador"                 => $co_tabulador,
                                      "co_clasif_personal"           => $co_clasif_personal,
                                      "co_estructura_administrativa" => $co_estructura_administrativa,
                                      "tx_estructura"                => $tx_estructura,
                                      "co_ficha"                    => $co_ficha,
                                      "co_estatus"                    => $co_estatus,
                                      "in_cestaticket"                 => $in_cestaticket,
                                      "rowIndex"                     => $rowIndex));
  }
  
  public function executeAgregarFamiliar(sfWebRequest $request){        
     
      $co_trabajador          = $this->getRequestParameter("co_trabajador");
      $co_sexo                = $this->getRequestParameter("co_sexo");
      $co_parentesco          = $this->getRequestParameter("co_parentesco");
      $nb_familiar            = $this->getRequestParameter("nb_familiar");
      $tx_identificacion      = $this->getRequestParameter("tx_identificacion");
      $co_familiar_trabajador = $this->getRequestParameter("co_familiar_trabajador");
      $fe_nacimiento           = $this->getRequestParameter("fe_nacimiento");
      $rowIndex               = $this->getRequestParameter("rowIndex");
      
      $this->data = json_encode(array("co_trabajador"          => $co_trabajador,
                                      "co_sexo"                => $co_sexo,
                                      "co_parentesco"          => $co_parentesco,
                                      "nb_familiar"            => $nb_familiar,
                                      "tx_identificacion"      => $tx_identificacion,
                                      "co_familiar_trabajador" => $co_familiar_trabajador,
                                      "fe_nacimiento"          => $fe_nacimiento,
                                      "rowIndex"               => $rowIndex));
  }
  
  public function executeAgregarProfesion(sfWebRequest $request){        
     
      $co_trabajador             = $this->getRequestParameter("co_trabajador");
      $co_profesion              = $this->getRequestParameter("co_profesion");
      $co_universidad            = $this->getRequestParameter("co_universidad");
      $tx_titulo_obtenido        = $this->getRequestParameter("tx_titulo_obtenido");
      $co_profesion_trabajador   = $this->getRequestParameter("co_profesion_trabajador");
      $fe_egreso                 = $this->getRequestParameter("fe_egreso");
      $rowIndex                  = $this->getRequestParameter("rowIndex");
      
      $this->data = json_encode(array("co_trabajador"           => $co_trabajador,
                                      "co_profesion"           => $co_profesion,
                                      "co_universidad"          => $co_universidad,
                                      "tx_titulo_obtenido"      => $tx_titulo_obtenido,
                                      "co_profesion_trabajador" => $co_profesion_trabajador,
                                      "fe_egreso"               => $fe_egreso,
                                      "rowIndex"                => $rowIndex));
  }
  
  protected function DatosEmpleado2($codigo){
      
        
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_TRABAJADOR);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_ENTREVISTADOR);
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
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CEDULA_ENTREVISTADOR);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::IN_LENTE);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::IN_VEHICULO);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_GRADO_LICENCIA); //562120
        $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_DESTREZA);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_TIPO_VIVIENDA);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::TX_RUTA_IMAGEN);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_MES_RECONOCIDO);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::IN_CESTATICKET);
        $c->addSelectColumn(Tbrh002FichaPeer::FE_INGRESO);
        $c->addSelectColumn(Tbrh002FichaPeer::CO_FICHA);
        $c->addSelectColumn(Tbrh002FichaPeer::CO_ESTATUS);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR);
        
        //$c->addSelectColumn(Tbrh105IngresoTrabajadorPeer::CO_INGRESO_TRABAJADOR);
        
        //$c->addJoin(Tbrh001TrabajadorPeer::CO_ESTADO,Tb016EstadoPeer::CO_ESTADO, Criteria::LEFT_JOIN);
        //$c->addJoin(Tbrh001TrabajadorPeer::CO_MUNICIPIO, Tb017MunicipioPeer::CO_MUNICIPIO, Criteria::LEFT_JOIN);
        //$c->addJoin(Tb170ParroquiaPeer::CO_PARROQUIA, Tbrh001TrabajadorPeer::CO_PARROQUIA_DOMICILIO, Criteria::LEFT_JOIN);
        //$c->addJoin(Tbrh001TrabajadorPeer::CO_TRABAJADOR, Tbrh002FichaPeer::CO_TRABAJADOR, Criteria::LEFT_JOIN);
        $c->addJoin(Tbrh001TrabajadorPeer::CO_TRABAJADOR, Tbrh002FichaPeer::CO_TRABAJADOR,  Criteria::LEFT_JOIN);
        $c->addJoin(Tbrh002FichaPeer::CO_FICHA, Tbrh015NomTrabajadorPeer::CO_FICHA,  Criteria::LEFT_JOIN);
        //$c->add(Tbrh105IngresoTrabajadorPeer::CO_INGRESO_TRABAJADOR,$codigo);
        $c->add(Tbrh001TrabajadorPeer::NU_CEDULA,$codigo);
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
                        "nu_cedula_entrevistador"   => $campos["nu_cedula_entrevistador"],
                        "in_vehiculo"               => $campos["in_vehiculo"],
                        "nu_grado_licencia"         => $campos["nu_grado_licencia"],
                        "co_destreza"               => $campos["co_destreza"],
                        "co_tipo_vivienda"          => $campos["co_tipo_vivienda"],
                        "co_ficha"          => $campos["co_ficha"],
                        "nu_mes_reconocido"          => $campos["nu_mes_reconocido"],
                        "co_estatus"          => $campos["co_estatus"],
                        "in_cestaticket"          => $campos["in_cestaticket"],
                        "co_nom_trabajador"          => $campos["co_nom_trabajador"],
                        "nb_entrevistador"          => $campos["nb_entrevistador"],
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
        $c->addSelectColumn(Tbrh105IngresoTrabajadorPeer::CO_INGRESO_TRABAJADOR);
        
        //$c->addJoin(Tbrh001TrabajadorPeer::CO_ESTADO,Tb016EstadoPeer::CO_ESTADO, Criteria::LEFT_JOIN);
        //$c->addJoin(Tbrh001TrabajadorPeer::CO_MUNICIPIO, Tb017MunicipioPeer::CO_MUNICIPIO, Criteria::LEFT_JOIN);
        //$c->addJoin(Tb170ParroquiaPeer::CO_PARROQUIA, Tbrh001TrabajadorPeer::CO_PARROQUIA_DOMICILIO, Criteria::LEFT_JOIN);
        //$c->addJoin(Tbrh001TrabajadorPeer::CO_TRABAJADOR, Tbrh002FichaPeer::CO_TRABAJADOR, Criteria::LEFT_JOIN);
        $c->addJoin(Tbrh001TrabajadorPeer::CO_TRABAJADOR, Tbrh002FichaPeer::CO_TRABAJADOR,  Criteria::LEFT_JOIN);
        $c->addJoin(Tbrh002FichaPeer::CO_FICHA, Tbrh105IngresoTrabajadorPeer::CO_FICHA,  Criteria::LEFT_JOIN);
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
  
  public function executeEditarSso(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    $this->DatosEmpleado($codigo);
  }

  public function executeEditar(sfWebRequest $request)
  {
     $codigo = $this->getRequestParameter("codigo");
     $this->DatosEmpleado($codigo);
  }

  public function executeEditar3(sfWebRequest $request)
  {
     $codigo = $this->getRequestParameter("codigo");
    $soli = $this->getRequestParameter('co_solicitudd');
     $this->data2 = json_encode(array(
                        "soli"             => $soli
                ));

     $this->DatosEmpleado2($codigo);
  }

  
  public function executeConsulta(sfWebRequest $request)
  {
     $codigo = $this->getRequestParameter("codigo");
     $this->DatosEmpleado($codigo);
  }  
  
  protected function getCoCargo($co_cargo){
      
      $c = new Criteria();
      $c->add(Tbrh009CargoEstructuraPeer::CO_CARGO,$co_cargo);
      $stmt = Tbrh009CargoEstructuraPeer::doSelectStmt($c);
      $campos = $stmt->fetch(PDO::FETCH_ASSOC);   
      
      return $campos["co_cargo_estructura"];
      
  }

public function executeGuardar2(sfWebRequest $request)
  {
    $ficha= $this->getRequestParameter("co_fichas");    
    $codigo                 = $this->getRequestParameter("co_trabajador");
    $co_nom_trabajador = $this->getRequestParameter("co_nom_trabajador");
    $co_ingreso_trabajador  = $this->getRequestParameter("co_ingreso_trabajador");
    $json_sueldo            = $this->getRequestParameter("json_sueldo");
    $json_familiar          = $this->getRequestParameter("json_familiar");
    $json_profesion         = $this->getRequestParameter("json_profesion");
    $hijos = $this->getRequestParameter("tbrh001_trabajador[nu_hijos]");
    $meses_reconocidos = $this->getRequestParameter("tbrh001_trabajador[nu_mes_reconocido]");
    $estatus = $this->getRequestParameter("tbrh001_trabajador[co_estatus]");
    $cestaticket = $this->getRequestParameter("tbrh001_trabajador[in_cestaticket]");
    $co_ingreso_trabajador = $this->getRequestParameter("co_ingreso_de_trabajador"); 
    $user = $this->getUser()->getAttribute('codigo');
    $codigoSoli = $this->getRequestParameter("soli");

   
    

    $tbrh001_trabajadorForm = $this->getRequestParameter('tbrh001_trabajador');


    
    $tbrh001_trabajador = Tbrh001TrabajadorPeer::retrieveByPk($codigo);
    $tbrh001_trabajador->setNuHijo(($hijos!='')?$hijos:NULL);
    $tbrh001_trabajador->setNuMesReconocido(($meses_reconocidos!='')?$meses_reconocidos:NULL);

    $tbrh001_trabajador->setNuCedula($tbrh001_trabajadorForm["nu_cedula"]);
    $tbrh001_trabajador->setNbPrimerNombre(strtoupper($tbrh001_trabajadorForm["nb_primer_nombre"]));
    $tbrh001_trabajador->setNbSegundoNombre(strtoupper($tbrh001_trabajadorForm["nb_segundo_nombre"]));
    $tbrh001_trabajador->setNbPrimerApellido(strtoupper($tbrh001_trabajadorForm["nb_primer_apellido"]));
    $tbrh001_trabajador->setNbSegundoApellido(strtoupper($tbrh001_trabajadorForm["nb_segundo_apellido"]));

    $tbrh001_trabajador->setCoDocumento($tbrh001_trabajadorForm["co_documento"]);
        $tbrh001_trabajador->setCoEnte(($tbrh001_trabajadorForm["co_ente"]!='')?$tbrh001_trabajadorForm["co_ente"]:NULL);
        $tbrh001_trabajador->setCoEdoCivil(($tbrh001_trabajadorForm["co_edo_civil"]!='')?$tbrh001_trabajadorForm["co_edo_civil"]:NULL);
        $tbrh001_trabajador->setCoDocumentoEntrevistador(($tbrh001_trabajadorForm["co_documento_entrevistador"]!='')?$tbrh001_trabajadorForm["co_documento_entrevistador"]:NULL);
        $tbrh001_trabajador->setNuCedulaEntrevistador(($tbrh001_trabajadorForm["nu_cedula_entrevistador"]!='')?$tbrh001_trabajadorForm["nu_cedula_entrevistador"]:NULL);
        $tbrh001_trabajador->setNbEntrevistador(($tbrh001_trabajadorForm["nb_entrevistador"]!='')?$tbrh001_trabajadorForm["nb_entrevistador"]:NULL);
                                                                
        /*Campo tipo DATE */
        if($tbrh001_trabajadorForm["fe_nacimiento"]!=''){
            list($dia, $mes, $anio) = explode("/",$tbrh001_trabajadorForm["fe_nacimiento"]);
            $fecha = $anio."-".$mes."-".$dia;
            $tbrh001_trabajador->setFeNacimiento($fecha);
        }

        if($tbrh001_trabajadorForm["co_banco"]==''){
           
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  "Para guardar al Trabajador debe Seleccionar el Banco"
            ));
            
            echo $this->data;
            return sfView::NONE;
        }
        
        if($tbrh001_trabajadorForm["nu_cuenta_bancaria"]==''){
           
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  "Para guardar al Trabajador indicar una cuenta bancaria"
            ));
            
            echo $this->data;
            return sfView::NONE;
        }

        $tbrh001_trabajador->setCoTpMotricida(($tbrh001_trabajadorForm["co_tp_motricida"]!='')?$tbrh001_trabajadorForm["co_tp_motricida"]:NULL);
        $tbrh001_trabajador->setTxDireccionDomicilio(($tbrh001_trabajadorForm["tx_direccion_domicilio"]!='')?$tbrh001_trabajadorForm["tx_direccion_domicilio"]:NULL);
        $tbrh001_trabajador->setCoParroquiaDomicilio(($tbrh001_trabajadorForm["co_parroquia_domicilio"]!='')?$tbrh001_trabajadorForm["co_parroquia_domicilio"]:NULL);
        $tbrh001_trabajador->setTxCiudadDomicilio(($tbrh001_trabajadorForm["tx_ciudad_domicilio"]!='')?$tbrh001_trabajadorForm["tx_ciudad_domicilio"]:NULL);
        $tbrh001_trabajador->setTxCiudadNacimiento(($tbrh001_trabajadorForm["tx_ciudad_nacimiento"]!='')?$tbrh001_trabajadorForm["tx_ciudad_nacimiento"]:NULL);
        $tbrh001_trabajador->setCoParroquiaNacimiento(($tbrh001_trabajadorForm["co_parroquia_nacimiento"]!='')?$tbrh001_trabajadorForm["co_parroquia_nacimiento"]:NULL);
        $tbrh001_trabajador->setCoNacionalidad(($tbrh001_trabajadorForm["co_nacionalidad"]!='')?$tbrh001_trabajadorForm["co_nacionalidad"]:NULL);
        $tbrh001_trabajador->setNuSeguroSocial(($tbrh001_trabajadorForm["nu_seguro_social"]!='')?$tbrh001_trabajadorForm["nu_seguro_social"]:NULL);
        $tbrh001_trabajador->setNuRif(($tbrh001_trabajadorForm["nu_rif"]!='')?$tbrh001_trabajadorForm["nu_rif"]:NULL);
        $tbrh001_trabajador->setCoNivelEducativo(($tbrh001_trabajadorForm["co_nivel_educativo"]!='')?$tbrh001_trabajadorForm["co_nivel_educativo"]:NULL);
        $tbrh001_trabajador->setNuAnioAprobadoEducativo(($tbrh001_trabajadorForm["nu_anio_aprobado_educativo"]!='')?$tbrh001_trabajadorForm["nu_anio_aprobado_educativo"]:NULL);
        $tbrh001_trabajador->setCoProfesion(($tbrh001_trabajadorForm["co_profesion"]!='')?$tbrh001_trabajadorForm["co_profesion"]:NULL);
        $tbrh001_trabajador->setTxObservacion(($tbrh001_trabajadorForm["tx_observacion"]!='')?$tbrh001_trabajadorForm["tx_observacion"]:NULL);
        $tbrh001_trabajador->setNuTelefonoContacto(($tbrh001_trabajadorForm["nu_telefono_contacto"]!='')?$tbrh001_trabajadorForm["nu_telefono_contacto"]:NULL);
        $tbrh001_trabajador->setNuTelefonoSecundario(($tbrh001_trabajadorForm["nu_telefono_secundario"]!='')?$tbrh001_trabajadorForm["nu_telefono_secundario"]:NULL);
        $tbrh001_trabajador->setTxCorreoElectronico(($tbrh001_trabajadorForm["tx_correo_electronico"]!='')?$tbrh001_trabajadorForm["tx_correo_electronico"]:NULL);                                                                
        $tbrh001_trabajador->setCoBanco(($tbrh001_trabajadorForm["co_banco"]!='')?$tbrh001_trabajadorForm["co_banco"]:NULL);
        $tbrh001_trabajador->setNuCuentaBancaria(($tbrh001_trabajadorForm["nu_cuenta_bancaria"]!='')?$tbrh001_trabajadorForm["nu_cuenta_bancaria"]:NULL);
        $tbrh001_trabajador->setCoGrupoSanguineo(($tbrh001_trabajadorForm["co_grupo_sanguineo"]!='')?$tbrh001_trabajadorForm["co_grupo_sanguineo"]:NULL);
        $tbrh001_trabajador->setNuEstatura(($tbrh001_trabajadorForm["nu_estatura"]!='')?$tbrh001_trabajadorForm["nu_estatura"]:NULL);
        $tbrh001_trabajador->setNuPeso(($tbrh001_trabajadorForm["nu_peso"]!='')?$tbrh001_trabajadorForm["nu_peso"]:NULL);
        $tbrh001_trabajador->setInLente(($tbrh001_trabajadorForm["in_lente"]!='')?$tbrh001_trabajadorForm["in_lente"]:NULL);
        $tbrh001_trabajador->setInVehiculo(($tbrh001_trabajadorForm["in_vehiculo"]!='')?$tbrh001_trabajadorForm["in_vehiculo"]:NULL);
        $tbrh001_trabajador->setNuGradoLicencia(($tbrh001_trabajadorForm["nu_grado_licencia"]!='')?$tbrh001_trabajadorForm["nu_grado_licencia"]:NULL);
        $tbrh001_trabajador->setCoDestreza(($tbrh001_trabajadorForm["co_destreza"]!='')?$tbrh001_trabajadorForm["co_destreza"]:NULL);
        $tbrh001_trabajador->setCoTipoVivienda(($tbrh001_trabajadorForm["co_tipo_vivienda"]!='')?$tbrh001_trabajadorForm["co_tipo_vivienda"]:NULL);

        if($tbrh001_trabajadorForm["fe_graduacion"]!=''){
            list($dia, $mes, $anio) = explode("/",$tbrh001_trabajadorForm["fe_graduacion"]);
            $fecha = $anio."-".$mes."-".$dia;
            $tbrh001_trabajador->setFeGraduacion($fecha);
        }
                                                        
        $tbrh001_trabajador->setTxCorreoElectronico(($tbrh001_trabajadorForm["tx_correo_electronico"]!='')?$tbrh001_trabajadorForm["tx_correo_electronico"]:NULL);
        
        if($tbrh001_trabajadorForm["co_solicitud"]!='')
            $tbrh001_trabajador->setCoSolicitud($tbrh001_trabajadorForm["co_solicitud"]);            

                

    $tbrh001_trabajador->save();

    if($tbrh001_trabajadorForm["fe_ingreso"]!=''){
            list($dia, $mes, $anio) = explode("/",$tbrh001_trabajadorForm["fe_ingreso"]);
            $fecha_ingreso = $anio."-".$mes."-".$dia;
        }

    


    $c = new Criteria();
    $c->add(Tbrh105IngresoTrabajadorPeer::CO_SOLICITUD,$codigoSoli);
    $c->add(Tbrh105IngresoTrabajadorPeer::CO_FICHA,$ficha);
    $cantidad = Tbrh105IngresoTrabajadorPeer::doCount($c);

    $stmt = Tbrh105IngresoTrabajadorPeer::doSelectStmt($c);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $co_ingreso = $result['co_ingreso_trabajador'];
    if($cantidad == 0){
            $tbrh105_ingreso_trabajador = new Tbrh105IngresoTrabajador();
            }else{
            $tbrh105_ingreso_trabajador = Tbrh105IngresoTrabajadorPeer::retrieveByPK($co_ingreso);
        }


            $tbrh105_ingreso_trabajador->setCoSolicitud($codigoSoli);
            $tbrh105_ingreso_trabajador->setCoFicha($ficha);
            $tbrh105_ingreso_trabajador->setCoUsuario($user);
            $tbrh105_ingreso_trabajador->save();
                                   

//        /*********SUELDO**********/
        
$listaSueldo  = json_decode($json_sueldo,true);

foreach($listaSueldo  as $v){

if($v['co_nom_trabajador'] != null){
$tbrh002_ficha = Tbrh002FichaPeer::retrieveByPk($v['co_ficha']);
$tbrh002_ficha->setCoEstatus(($v['co_estatus']!='')?$v['co_estatus']:NULL);
$tbrh002_ficha->setFeIngreso($fecha_ingreso);
$tbrh002_ficha->save();
$tbrh015_nom_trabajador = Tbrh015NomTrabajadorPeer::retrieveByPK($v["co_nom_trabajador"]);
$ficha = $v['co_ficha'];
$tbrh015_nom_trabajador->setInActivo(FALSE);

if($v['in_cestaticket'] == true){
    $tbrh015_nom_trabajador->setInCestaticket(TRUE);
}elseif($v['in_cestaticket'] == false){
    $tbrh015_nom_trabajador->setInCestaticket(FALSE);
}

}else{
$tbrh002_ficha = new Tbrh002Ficha();
$tbrh002_ficha->setCoTrabajador($codigo)
              ->setFeIngreso($fecha_ingreso)
              ->setCoEstatus(0)
              ->setNuFicha($tbrh001_trabajadorForm["nu_cedula"])
              ->setInActivo(FALSE)
             ->save();

$ficha = $tbrh002_ficha->getCoFicha();


$tbrh015_nom_trabajador = new Tbrh015NomTrabajador();
$tbrh015_nom_trabajador->setInCestaticket(TRUE);
}

if($v['fe_ingreso']!=''){
            list($dia, $mes, $anio) = explode("/",$v['fe_ingreso']);
            $fecha_asignacion = $anio."-".$mes."-".$dia;
        }

//Ingreso Tbrh015
$tbrh015_nom_trabajador->setCoCargoEstructura($v["co_cargo_estructura"]);
$tbrh015_nom_trabajador->setCoTpNomina($v["co_tp_nomina"]);
//$tbrh015_nom_trabajador->setFeIngreso($feing2);
$tbrh015_nom_trabajador->setCoGrupoNomina($v["co_grupo_nomina"]);

$tbrh015_nom_trabajador->setNuHoras($v["nu_horas"]);
$tbrh015_nom_trabajador->setCoTpCargo($v["co_tp_cargo"]);
$tbrh015_nom_trabajador->setCoFicha($ficha);
if($v["co_tipo_pago"]==1){
$tbrh015_nom_trabajador->setInSueldoTab(TRUE);
$tbrh015_nom_trabajador->setMoSalarioBase($v["mo_salario_base"]);
$tbrh015_nom_trabajador->setCoTabulador($v["co_tabulador"]);
//Fin Calcular sueldo
}else{

$tbrh015_nom_trabajador->setInSueldoTab(FALSE);
$tbrh015_nom_trabajador->setMoSalarioBase($v["mo_salario_base"]);

}


$tbrh015_nom_trabajador->setFeIngreso($fecha_asignacion);
$tbrh015_nom_trabajador->setCoSolicitud($codigoSoli);
$tbrh015_nom_trabajador->setCoUsuario($this->getUser()->getAttribute('codigo'));
$tbrh015_nom_trabajador->save();      
//Fin ingreso tbrh015       


}





//Familiar
$jsonfamilia = json_decode($json_familiar,true);
foreach($jsonfamilia  as $familia){

list($dia, $mes, $anio) = explode("-",$familia['fe_nacimiento']);
$fenac = $anio."-".$mes."-".$dia;



if($familia['co_familiar_trabajador'] == NULL){
    $tbrh083_familiar_trabajador = new Tbrh083FamiliarTrabajador();   
}else{
   $tbrh083_familiar_trabajador = Tbrh083FamiliarTrabajadorPeer::retrieveByPK($familia['co_familiar_trabajador']);
}

$tbrh083_familiar_trabajador->setCoSexo($familia['co_sexo']);
$tbrh083_familiar_trabajador->setCoParentesco($familia['co_parentesco']);
$tbrh083_familiar_trabajador->setNbFamiliar($familia['nb_familiar']);
$tbrh083_familiar_trabajador->setTxIdentificacion($familia['tx_identificacion']);
$tbrh083_familiar_trabajador->setCoTrabajador($codigo);
$tbrh083_familiar_trabajador->setFeNacimiento($fenac);
$tbrh083_familiar_trabajador->setCoUsuario($user);
$tbrh083_familiar_trabajador->save();
}

//Fin familiar

/*********PROFESION**********/             
        
        $listaProfesion  = json_decode($json_profesion,true);
        
      
            foreach($listaProfesion  as $vl){
                
        if($vl["co_profesion_trabajador"]==NULL){
                $tbrh084_profesion_trabajador = new Tbrh084ProfesionTrabajador();
            }else{
                $tbrh084_profesion_trabajador = Tbrh084ProfesionTrabajadorPeer::retrieveByPK($vl["co_profesion_trabajador"]);
                }                
                
                list($dia,$mes,$anio) = explode("-", $vl["fe_egreso"]);
                $fecha = $anio.'-'.$mes.'-'.$dia;   
                
                $tbrh084_profesion_trabajador->setFeEgreso($fecha)
                                             ->setCoProfesion($vl["co_profesion"])
                                             ->setCoUniversidad($vl["co_universidad"])
                                             ->setTxTituloObtenido($vl["tx_titulo_obtenido"])
                                             ->setCoTrabajador($codigo)
                                             ->setCoUsuario($user)
                                             ->save(); 
                
            }
        
        
        
        /*********PROFESION***********/



 


    $this->data = json_encode(array(
                "success" => false,
                "msg" =>  "Se han realizado los cambios correctamente!"
            ));
            
            echo $this->data;
            return sfView::NONE;



     
    }

  public function executeGuardar(sfWebRequest $request)
  {
    
     $codigo                 = $this->getRequestParameter("co_trabajador");
     $co_ingreso_trabajador  = $this->getRequestParameter("co_ingreso_trabajador");
     $json_sueldo            = $this->getRequestParameter("json_sueldo");
     
     $json_familiar          = $this->getRequestParameter("json_familiar");
     $json_profesion         = $this->getRequestParameter("json_profesion");
        
     $con = Propel::getConnection();
     
     $tbrh001_trabajadorForm = $this->getRequestParameter('tbrh001_trabajador');
     
     if($codigo!=''||$codigo!=null){
         $tbrh001_trabajador = Tbrh001TrabajadorPeer::retrieveByPk($codigo);
         $ficha = $this->getDatosFicha($tbrh001_trabajador->getCoTrabajador(),$tbrh001_trabajadorForm["co_solicitud"]);
     }else{
         
        $c = new Criteria();
        $c->add(Tbrh001TrabajadorPeer::NU_CEDULA,$tbrh001_trabajadorForm["nu_cedula"]);        
        $cantidad = Tbrh001TrabajadorPeer::doCount($c);
        
        
        if($cantidad==0){
            $tbrh001_trabajador = new Tbrh001Trabajador();
        }else{
            
            $stmt = Tbrh001TrabajadorPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC); 
            
            $tbrh001_trabajador = Tbrh001TrabajadorPeer::retrieveByPk($campos["co_trabajador"]);
            
        $c1 = new Criteria();
        $c1->add(Tbrh002FichaPeer::CO_TRABAJADOR,$campos["co_trabajador"]); 
        $c1->add(Tbrh002FichaPeer::NU_SOLICITUD_INGRESO,$tbrh001_trabajadorForm["co_solicitud"]); 
        $cantidad_ficha = Tbrh002FichaPeer::doCount($c1);       
        if($cantidad_ficha>0){
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  "El Trabajador ya tiene un registro con esta solicitud!"
            ));
            
            echo $this->data;
            return sfView::NONE;
        }         
            
        }         
        
     }
     try
      { 
        $con->beginTransaction();
        
       
        $tbrh001_trabajador->setNuCedula($tbrh001_trabajadorForm["nu_cedula"]);
        $tbrh001_trabajador->setNbPrimerNombre(strtoupper($tbrh001_trabajadorForm["nb_primer_nombre"]));
        $tbrh001_trabajador->setNbSegundoNombre(strtoupper($tbrh001_trabajadorForm["nb_segundo_nombre"]));
        $tbrh001_trabajador->setNbPrimerApellido(strtoupper($tbrh001_trabajadorForm["nb_primer_apellido"]));
        $tbrh001_trabajador->setNbSegundoApellido(strtoupper($tbrh001_trabajadorForm["nb_segundo_apellido"]));
        $tbrh001_trabajador->setCoDocumento($tbrh001_trabajadorForm["co_documento"]);
        $tbrh001_trabajador->setCoEnte(($tbrh001_trabajadorForm["co_ente"]!='')?$tbrh001_trabajadorForm["co_ente"]:NULL);
        $tbrh001_trabajador->setCoEdoCivil(($tbrh001_trabajadorForm["co_edo_civil"]!='')?$tbrh001_trabajadorForm["co_edo_civil"]:NULL);
        $tbrh001_trabajador->setCoDocumentoEntrevistador(($tbrh001_trabajadorForm["co_documento_entrevistador"]!='')?$tbrh001_trabajadorForm["co_documento_entrevistador"]:NULL);
        $tbrh001_trabajador->setNuCedulaEntrevistador(($tbrh001_trabajadorForm["nu_cedula_entrevistador"]!='')?$tbrh001_trabajadorForm["nu_cedula_entrevistador"]:NULL);
        $tbrh001_trabajador->setNbEntrevistador(($tbrh001_trabajadorForm["nb_entrevistador"]!='')?$tbrh001_trabajadorForm["nb_entrevistador"]:NULL);
                                                                
        /*Campo tipo DATE */
        if($tbrh001_trabajadorForm["fe_nacimiento"]!=''){
            list($dia, $mes, $anio) = explode("/",$tbrh001_trabajadorForm["fe_nacimiento"]);
            $fecha = $anio."-".$mes."-".$dia;
            $tbrh001_trabajador->setFeNacimiento($fecha);
        }
        
        if($tbrh001_trabajadorForm["co_banco"]==''){
           
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  "Para guardar al Trabajador debe Seleccionar el Banco"
            ));
            
            echo $this->data;
            return sfView::NONE;
        }
        
        if($tbrh001_trabajadorForm["nu_cuenta_bancaria"]==''){
           
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  "Para guardar al Trabajador indicar una cuenta bancaria"
            ));
            
            echo $this->data;
            return sfView::NONE;
        }
                                                        
        $tbrh001_trabajador->setCoTpMotricida(($tbrh001_trabajadorForm["co_tp_motricida"]!='')?$tbrh001_trabajadorForm["co_tp_motricida"]:NULL);
        $tbrh001_trabajador->setNuHijo(($tbrh001_trabajadorForm["nu_hijo"]!='')?$tbrh001_trabajadorForm["nu_hijo"]:NULL);
        $tbrh001_trabajador->setTxDireccionDomicilio(($tbrh001_trabajadorForm["tx_direccion_domicilio"]!='')?$tbrh001_trabajadorForm["tx_direccion_domicilio"]:NULL);
        $tbrh001_trabajador->setCoParroquiaDomicilio(($tbrh001_trabajadorForm["co_parroquia_domicilio"]!='')?$tbrh001_trabajadorForm["co_parroquia_domicilio"]:NULL);
        $tbrh001_trabajador->setTxCiudadDomicilio(($tbrh001_trabajadorForm["tx_ciudad_domicilio"]!='')?$tbrh001_trabajadorForm["tx_ciudad_domicilio"]:NULL);
        $tbrh001_trabajador->setTxCiudadNacimiento(($tbrh001_trabajadorForm["tx_ciudad_nacimiento"]!='')?$tbrh001_trabajadorForm["tx_ciudad_nacimiento"]:NULL);
        $tbrh001_trabajador->setCoParroquiaNacimiento(($tbrh001_trabajadorForm["co_parroquia_nacimiento"]!='')?$tbrh001_trabajadorForm["co_parroquia_nacimiento"]:NULL);
        $tbrh001_trabajador->setCoNacionalidad(($tbrh001_trabajadorForm["co_nacionalidad"]!='')?$tbrh001_trabajadorForm["co_nacionalidad"]:NULL);
        $tbrh001_trabajador->setNuSeguroSocial(($tbrh001_trabajadorForm["nu_seguro_social"]!='')?$tbrh001_trabajadorForm["nu_seguro_social"]:NULL);
        $tbrh001_trabajador->setNuRif(($tbrh001_trabajadorForm["nu_rif"]!='')?$tbrh001_trabajadorForm["nu_rif"]:NULL);
        $tbrh001_trabajador->setCoNivelEducativo(($tbrh001_trabajadorForm["co_nivel_educativo"]!='')?$tbrh001_trabajadorForm["co_nivel_educativo"]:NULL);
        $tbrh001_trabajador->setNuAnioAprobadoEducativo(($tbrh001_trabajadorForm["nu_anio_aprobado_educativo"]!='')?$tbrh001_trabajadorForm["nu_anio_aprobado_educativo"]:NULL);
        $tbrh001_trabajador->setCoProfesion(($tbrh001_trabajadorForm["co_profesion"]!='')?$tbrh001_trabajadorForm["co_profesion"]:NULL);
        $tbrh001_trabajador->setTxObservacion(($tbrh001_trabajadorForm["tx_observacion"]!='')?$tbrh001_trabajadorForm["tx_observacion"]:NULL);
        $tbrh001_trabajador->setNuTelefonoContacto(($tbrh001_trabajadorForm["nu_telefono_contacto"]!='')?$tbrh001_trabajadorForm["nu_telefono_contacto"]:NULL);
        $tbrh001_trabajador->setNuTelefonoSecundario(($tbrh001_trabajadorForm["nu_telefono_secundario"]!='')?$tbrh001_trabajadorForm["nu_telefono_secundario"]:NULL);
        $tbrh001_trabajador->setTxCorreoElectronico(($tbrh001_trabajadorForm["tx_correo_electronico"]!='')?$tbrh001_trabajadorForm["tx_correo_electronico"]:NULL);                                                                
        $tbrh001_trabajador->setCoBanco(($tbrh001_trabajadorForm["co_banco"]!='')?$tbrh001_trabajadorForm["co_banco"]:NULL);
        $tbrh001_trabajador->setNuCuentaBancaria(($tbrh001_trabajadorForm["nu_cuenta_bancaria"]!='')?$tbrh001_trabajadorForm["nu_cuenta_bancaria"]:NULL);
        $tbrh001_trabajador->setCoGrupoSanguineo(($tbrh001_trabajadorForm["co_grupo_sanguineo"]!='')?$tbrh001_trabajadorForm["co_grupo_sanguineo"]:NULL);
        $tbrh001_trabajador->setNuEstatura(($tbrh001_trabajadorForm["nu_estatura"]!='')?$tbrh001_trabajadorForm["nu_estatura"]:NULL);
        $tbrh001_trabajador->setNuPeso(($tbrh001_trabajadorForm["nu_peso"]!='')?$tbrh001_trabajadorForm["nu_peso"]:NULL);
        $tbrh001_trabajador->setInLente(($tbrh001_trabajadorForm["in_lente"]!='')?$tbrh001_trabajadorForm["in_lente"]:NULL);
        $tbrh001_trabajador->setInVehiculo(($tbrh001_trabajadorForm["in_vehiculo"]!='')?$tbrh001_trabajadorForm["in_vehiculo"]:NULL);
        $tbrh001_trabajador->setNuGradoLicencia(($tbrh001_trabajadorForm["nu_grado_licencia"]!='')?$tbrh001_trabajadorForm["nu_grado_licencia"]:NULL);
        $tbrh001_trabajador->setCoDestreza(($tbrh001_trabajadorForm["co_destreza"]!='')?$tbrh001_trabajadorForm["co_destreza"]:NULL);
        $tbrh001_trabajador->setCoTipoVivienda(($tbrh001_trabajadorForm["co_tipo_vivienda"]!='')?$tbrh001_trabajadorForm["co_tipo_vivienda"]:NULL);
               
     
        if($tbrh001_trabajadorForm["fe_graduacion"]!=''){
            list($dia, $mes, $anio) = explode("/",$tbrh001_trabajadorForm["fe_graduacion"]);
            $fecha = $anio."-".$mes."-".$dia;
            $tbrh001_trabajador->setFeGraduacion($fecha);
        }
                                                        
        $tbrh001_trabajador->setTxCorreoElectronico(($tbrh001_trabajadorForm["tx_correo_electronico"]!='')?$tbrh001_trabajadorForm["tx_correo_electronico"]:NULL);
        
        if($tbrh001_trabajadorForm["co_solicitud"]!='')
            $tbrh001_trabajador->setCoSolicitud($tbrh001_trabajadorForm["co_solicitud"]);            

                
        
        
        if($ficha["co_ficha"]==''){
            $tbrh002_ficha = new Tbrh002Ficha();
        }else{
            $tbrh002_ficha = Tbrh002FichaPeer::retrieveByPK($ficha["co_ficha"]);
        }
        
        $tbrh001_trabajador->save($con);
        
        if($tbrh001_trabajadorForm["fe_ingreso"]!=''){
            list($dia, $mes, $anio) = explode("/",$tbrh001_trabajadorForm["fe_ingreso"]);
            $fecha_ingreso = $anio."-".$mes."-".$dia;
        }
        
        $tbrh002_ficha->setCoTrabajador($tbrh001_trabajador->getCoTrabajador())
                      ->setFeIngreso($fecha_ingreso)
                      ->setCoEstatus(0)
                      ->setNuFicha($tbrh001_trabajadorForm["nu_cedula"])
                      ->setNuSolicitudIngreso(($tbrh001_trabajadorForm["co_solicitud"]!='')?$tbrh001_trabajadorForm["co_solicitud"]:NULL)
                      ->setInActivo(FALSE)
                      ->save($con);
        
        if($co_ingreso_trabajador=='')
            $tbrh105_ingreso_trabajador = new Tbrh105IngresoTrabajador();
        else
            $tbrh105_ingreso_trabajador = Tbrh105IngresoTrabajadorPeer::retrieveByPK($co_ingreso_trabajador);
        
        $tbrh105_ingreso_trabajador->setCoSolicitud($tbrh001_trabajadorForm["co_solicitud"])
                                   ->setCoFicha($tbrh002_ficha->getCoFicha())
                                   ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                   ->save($con);
        
        $ruta = new myConfig();
        
        if($_FILES['form-file']['name']!=''){
        
            list($name,$type) = explode('.',$_FILES['form-file']['name']);

            $fichero_subido = $ruta->getDirectorio().'foto/'.$tbrh001_trabajadorForm["nu_cedula"].'.'.$type;

            move_uploaded_file($_FILES['form-file']['tmp_name'], $fichero_subido);        

            $tbrh001_trabajador->setTxRutaImagen($fichero_subido);
        }
        
//        /*********SUELDO**********/
        
        $listaSueldo  = json_decode($json_sueldo,true);
        
        $datosFicha = $this->getDatosFicha($tbrh001_trabajador->getCoTrabajador(),$tbrh001_trabajadorForm["co_solicitud"]);

        if(count($listaSueldo)>0){
            foreach($listaSueldo  as $v){
                
                if($v["co_nom_trabajador"]==''){
                    
        $c2 = new Criteria();
        $c2->add(Tbrh002FichaPeer::CO_TRABAJADOR,$tbrh001_trabajador->getCoTrabajador());     
        $stmt2 = Tbrh002FichaPeer::doSelectStmt($c2);
        while($reg = $stmt2->fetch(PDO::FETCH_ASSOC)){
        $c = new Criteria();
        $c->add(Tbrh015NomTrabajadorPeer::CO_FICHA,$reg["co_ficha"]);
        $c->add(Tbrh015NomTrabajadorPeer::IN_ACTIVO,true);
        $c->add(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA,$v["co_cargo_estructura"]); 
        $cantidad_cargo = Tbrh015NomTrabajadorPeer::doCount($c); 
        

        if($cantidad_cargo>0){
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  "El Trabajador ya tiene un registro en uno de los cargos agregados verifique!"
            ));
            
            echo $this->data;
            return sfView::NONE;
        }         
        }        
       
                    
                    $sueldo_trabajador = new Tbrh015NomTrabajador();
                    $ficha = $datosFicha["co_ficha"];
                }else{
                    $sueldo_trabajador = Tbrh015NomTrabajadorPeer::retrieveByPK($v["co_nom_trabajador"]);
                    $ficha = $sueldo_trabajador->getCoFicha();
                }                
//        var_dump($InSueldoTab);
//        exit();
                list($dia,$mes,$anio) = explode("/", $v["fe_ingreso"]);
                $fe_ingreso = $anio.'-'.$mes.'-'.$dia;
                
                
                $sueldo_trabajador->setCoCargoEstructura($v["co_cargo_estructura"]);
                $sueldo_trabajador->setCoTpNomina($v["co_tp_nomina"]);
                $sueldo_trabajador->setFeIngreso($fe_ingreso);
                $sueldo_trabajador->setCoGrupoNomina($v["co_grupo_nomina"]);
                $sueldo_trabajador->setMoSalarioBase($v["mo_salario_base"]);
                $sueldo_trabajador->setNuHoras($v["nu_horas"]);
                $sueldo_trabajador->setCoTpCargo($v["co_tp_cargo"]);
                $sueldo_trabajador->setCoFicha($ficha);
                if($v["co_tipo_pago"]==1){
                $sueldo_trabajador->setInSueldoTab(TRUE);
                }else{
                $sueldo_trabajador->setInSueldoTab(FALSE);
                }
                $sueldo_trabajador->setInActivo(FALSE);
                $sueldo_trabajador->setCoTabulador(($v["co_tabulador"]!='')?$v["co_tabulador"]:NULL);
                $sueldo_trabajador->setCoSolicitud(($tbrh001_trabajadorForm["co_solicitud"]!='')?$tbrh001_trabajadorForm["co_solicitud"]:NULL);
                $sueldo_trabajador->setCoUsuario($this->getUser()->getAttribute('codigo'));
                $sueldo_trabajador->save($con);                
            }
        }else{
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  "Para guardar al Trabajador debe Asignar al menos un Cargo"
            ));
            
            echo $this->data;
            return sfView::NONE;
        }
        
        
        /*********SUELDO**********/
        
        /*********FAMILIAR**********/
       
        $listaFamiliar  = json_decode($json_familiar,true);
        $cant_hijos = 0;
        if(count($listaFamiliar)>0){
            foreach($listaFamiliar  as $vl){
                
                if($vl["co_familiar_trabajador"]==''){
                    $tbrh083_familiar_trabajador = new Tbrh083FamiliarTrabajador();
                    
                    $cf = new Criteria();
                    $cf->add(Tbrh083FamiliarTrabajadorPeer::TX_IDENTIFICACION,$vl["tx_identificacion"]);
                    $cant = Tbrh083FamiliarTrabajadorPeer::doCount($cf);
                    
                    if($cant > 0){
                        $con->rollback();
                        $this->data = json_encode(array(
                            "success" => false,
                            "msg" =>  "El numero de identificacion ".$vl["tx_identificacion"]."  ya se encuentra registrado"
                        ));
                        
                        echo $this->data;
                        return sfView::NONE;
                    }
                    
                    $tbrh083_familiar_trabajador->setCoSolicitud($tbrh001_trabajadorForm["co_solicitud"]);
                    
                }else{
                    $tbrh083_familiar_trabajador = Tbrh083FamiliarTrabajadorPeer::retrieveByPK($vl["co_familiar_trabajador"]);
                }                
                
                list($dia,$mes,$anio) = explode("-", $vl["fe_nacimiento"]);
                $fecha = $anio.'-'.$mes.'-'.$dia;               
                
                
                $tbrh083_familiar_trabajador->setNbFamiliar($vl["nb_familiar"])
                                            ->setTxIdentificacion($vl["tx_identificacion"])
                                            ->setCoSexo($vl["co_sexo"])
                                            ->setCoParentesco($vl["co_parentesco"])
                                            ->setFeNacimiento($fecha)
                                            ->setCoTrabajador($tbrh001_trabajador->getCoTrabajador())
                                            ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                            ->save($con); 
                
                if($vl["co_parentesco"]==4||$vl["co_parentesco"]==5){
                    $cant_hijos++;
                }
            }
        }
        
        $tbrh001_trabajador->setNuHijo($cant_hijos);
        
        
        /*********FAMILIAR**********/
        
        
        /*********PROFESION**********/             
        
        $listaProfesion  = json_decode($json_profesion,true);
        
        if(count($listaProfesion)>0){
            foreach($listaProfesion  as $vl){
                
                if($vl["co_profesion_trabajador"]==''){
                    $tbrh084_profesion_trabajador = new Tbrh084ProfesionTrabajador();
                    $tbrh084_profesion_trabajador->setCoSolicitud($tbrh001_trabajadorForm["co_solicitud"]);
                }else{
                    $tbrh084_profesion_trabajador = Tbrh084ProfesionTrabajadorPeer::retrieveByPK($vl["co_profesion_trabajador"]);
                }                
                
                list($dia,$mes,$anio) = explode("-", $vl["fe_egreso"]);
                $fecha = $anio.'-'.$mes.'-'.$dia;   
                
                $tbrh084_profesion_trabajador->setFeEgreso($fecha)
                                             ->setCoProfesion($vl["co_profesion"])
                                             ->setCoUniversidad($vl["co_universidad"])
                                             ->setTxTituloObtenido($vl["tx_titulo_obtenido"])
                                             ->setCoTrabajador($tbrh001_trabajador->getCoTrabajador())
                                             ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                             ->save($con); 
                
            }
        }
        
        
        /*********PROFESION***********/
        
        
        
        $tbrh001_trabajador->save($con);
        $con->commit();
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente'
                ));
        
        
        echo $this->data;
        return sfView::NONE;
        
      }catch (PropelException $e)
      {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" => "kldsfksdfgsdj"
        ));
      }
    }
    
    public function executeProcesarNomina(sfWebRequest $request)
    {
            $codigo = $this->getRequestParameter("co_trabajador");
            $con = Propel::getConnection();
            try
            { 
                    $con->beginTransaction();
                    /*CAMPOS*/
                    $tbrh001_trabajador = Tbrh001TrabajadorPeer::retrieveByPk($codigo);			
                    $tbrh001_trabajador->setInNomina(TRUE)->save($con);
                    $this->data = json_encode(array(
                                "success" => true,
                                "msg" => 'Registro Procesado con Exito!'
                    ));
                    $con->commit();
                    
                
                echo $this->data;
                return sfView::NONE;
                    
            }catch (PropelException $e)
            {
                    $con->rollback();
                    $this->data = json_encode(array(
                        "success" => false,
                        "msg" => 'Este registro no se puede borrar porque <br>se encuentra asociado a otros registros'
                    ));
                
                echo $this->data;
                return sfView::NONE;
                    
            }
    }
  
    public function executeProcesar(sfWebRequest $request)
    {
            $codigo = $this->getRequestParameter("co_trabajador");
            $con = Propel::getConnection();
            try
            { 
                    $con->beginTransaction();
                    /*CAMPOS*/
                    $tbrh001_trabajador = Tbrh001TrabajadorPeer::retrieveByPk($codigo);			
                    $tbrh001_trabajador->setInSeguroSocial(TRUE)->save($con);
                    $this->data = json_encode(array(
                                "success" => true,
                                "msg" => 'Registro Procesado con Exito!'
                    ));
                    $con->commit();
                    
                
                echo $this->data;
                return sfView::NONE;
                    
            }catch (PropelException $e)
            {
                    $con->rollback();
                    $this->data = json_encode(array(
                        "success" => false,
                        "msg" => 'Este registro no se puede borrar porque <br>se encuentra asociado a otros registros'
                    ));
                
                echo $this->data;
                return sfView::NONE;
                    
            }
    }
    
    protected function getCoFicha($co_trabajador){
      
      $c = new Criteria();
      $c->add(Tbrh002FichaPeer::CO_TRABAJADOR,$co_trabajador);
      $stmt = Tbrh002FichaPeer::doSelectStmt($c);
      $campos = $stmt->fetch(PDO::FETCH_ASSOC);   
      
      return $campos["co_ficha"];
      
  }
    

  public function executeEliminar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_ingreso_trabajador");
	$con = Propel::getConnection();
	try
	{ 
            $con->beginTransaction();
            
            $Tbrh105IngresoTrabajadorPeer = Tbrh105IngresoTrabajadorPeer::retrieveByPk($codigo);
            $Tbrh105IngresoTrabajadorPeer->setInDelete(true);
            $Tbrh105IngresoTrabajadorPeer->save($con);
                
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
		    "msg" =>  $e->getMessage()
//		    "msg" => ''
		));
	}
  }
  
  public function executeEliminarProfesion(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_profesion_trabajador");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$Tbrh084ProfesionTrabajador = Tbrh084ProfesionTrabajadorPeer::retrieveByPk($codigo);			
	$Tbrh084ProfesionTrabajador->delete($con);
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
		    "msg" => ''
		));
	}
  }
  
   public function executeEliminarFamiliar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_familiar_trabajador");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh083_familiar_trabajador = Tbrh083FamiliarTrabajadorPeer::retrieveByPk($codigo);			
        $tbrh083_familiar_trabajador->setInRemovido(true);
	$tbrh083_familiar_trabajador->save($con);
        
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Registro fue eliminado con exito!'
        ));
        
	$con->commit();
	}catch (PropelException $e)
	{
                $con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
//		    "msg" =>  $e->getMessage()
		    "msg" => ''
		));
	}
  }
  
  protected function getCoBanco($cuenta){
      
      $c = new Criteria();
      $c->add(Tb010BancoPeer::NU_CODIGO,substr($cuenta, 0, 4));
      $stmt = Tb010BancoPeer::doSelectStmt($c);
      $campos = $stmt->fetch(PDO::FETCH_ASSOC);   
      
      return $campos["co_banco"];
      
  }
  
  protected function getCoDocumento($sigla){
      
      $c = new Criteria();
      $c->add(Tb007DocumentoPeer::INICIAL, strtoupper($sigla));
      $stmt = Tb007DocumentoPeer::doSelectStmt($c);
      $campos = $stmt->fetch(PDO::FETCH_ASSOC);   
      
      return $campos["co_documento"];
      
  }
  
  protected function getDatosFicha($co_trabajador,$co_solicitud){      
      $c = new Criteria();
      $c->add(Tbrh002FichaPeer::CO_TRABAJADOR, $co_trabajador);
      $c->add(Tbrh002FichaPeer::NU_SOLICITUD_INGRESO, $co_solicitud);
      $c->add(Tbrh002FichaPeer::CO_ESTATUS, 0);
      $stmt = Tbrh002FichaPeer::doSelectStmt($c);
      $campos = $stmt->fetch(PDO::FETCH_ASSOC);   
      
      return $campos;
  }
  
  public function executeProcesarNominaMasivo(sfWebRequest $request)
  {

$num ="";

$codigoSoli = $this->getRequestParameter("co_solicitud");


$con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         
     }else{
         
     }try{
      
$con->beginTransaction();

if($_FILES['form-file']['tmp_name']==''){
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  "Debe Seleccionar un archivo .xls"
            ));
            
            echo $this->data;
            return sfView::NONE;
        }
        

        
        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('CP1251');
        $data->read($_FILES['form-file']['tmp_name']);    
        
        for ($i =2; $i <= $data->sheets[0]['numRows']; $i++) {
            
    
if(!is_numeric(trim($data->sheets[0]['cells'][$i][1]))){
    $this->data = json_encode(array(
        "success" => false,
        "msg" => 'El Numero de Cedula  '.$data->sheets[0]['cells'][$i][1].' debe ser númerico linea '.$i
    ));
    echo $this->data;
    return sfView::NONE;
}              

$c = new Criteria();
$c->add(Tbrh001TrabajadorPeer::NU_CEDULA,$data->sheets[0]['cells'][$i][1]);
$cantidad = Tbrh001TrabajadorPeer::doCount($c);

//Comprobar
//Inicio Co_Cargo_Estructura
$c = new Criteria();
$c->clearSelectColumns();
$c->addSelectColumn(Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA);
$c->add(Tbrh009CargoEstructuraPeer::NU_CODIGO_CARGO, $data->sheets[0]['cells'][$i][21]);
$c->add(Tbrh009CargoEstructuraPeer::NU_CODIGO_ESTRUCTURA, $data->sheets[0]['cells'][$i][22]);
$stmt = Tbrh009CargoEstructuraPeer::doSelectStmt($c);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$co_cargo_estructura = $result['co_cargo_estructura'];

if($co_cargo_estructura=='' && $co_cargo_estructura==null){
    $this->data = json_encode(array(
        "success" => false,
        "msg" => 'La asociacion cargo estrucutura no se encuentra registrada  ('.$data->sheets[0]['cells'][$i][21].' - '.$data->sheets[0]['cells'][$i][22].') Verifique! linea '.$i
    ));
    echo $this->data;
    return sfView::NONE;
} 

//FECHAS

//FECHA NACIMIENTO
$unixTimestamp = ($data->sheets[0]['cells'][$i][10] - 25568) * 86400;
$fenac = date('Y-m-d', $unixTimestamp);   
//FIN FECHA NACIMIENTO
//FECHA INGRESO 02
$unixTimestamp = ($data->sheets[0]['cells'][$i][15] - 25568) * 86400;
$feing = date('Y-m-d', $unixTimestamp);  
//FIN FECHA INGRESO
//FECHA INGRESO15
$unixTimestamp = ($data->sheets[0]['cells'][$i][16] - 25568) * 86400;
$feing2 = date('Y-m-d', $unixTimestamp);  
//FIN FECHA INGRESO
//FIN FECHAS       
//Inicio TBRH001

//Calcular Tx nivel educativo
$c = new Criteria();
$c->clearSelectColumns();
$c->addSelectColumn(Tbrh093NivelEducativoPeer::DE_NIVEL_EDUCATIVO);
$c->add(Tbrh093NivelEducativoPeer::CO_NIVEL_EDUCATIVO, $data->sheets[0]['cells'][$i][17]);
$stmt = Tbrh067GrupoNominaPeer::doSelectStmt($c);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$tx_edu = $result['de_nivel_educativo'];
//Fin tx nivel educativo

if($tx_edu=='' && $tx_edu==null){
    $this->data = json_encode(array(
        "success" => false,
        "msg" => 'El nivel Educativo no se encuentra registrado  ('.$data->sheets[0]['cells'][$i][17].') Verifique! linea '.$i
    ));
    echo $this->data;
    return sfView::NONE;
} 

if($data->sheets[0]['cells'][$i][19]==20){
  $cobanco=1;
}else{

if($data->sheets[0]['cells'][$i][19]==10){
  $cobanco=3;
}else{

if($data->sheets[0]['cells'][$i][19]==6){
  $cobanco=4;
}else{
    $this->data = json_encode(array(
        "success" => false,
        "msg" => 'El codigo del banco es incorrecto  '.$data->sheets[0]['cells'][$i][19].' linea '.$i
    ));
    echo $this->data;
    return sfView::NONE;    
}
}
}       
if($cantidad==0){
 
if(!is_numeric(trim($data->sheets[0]['cells'][$i][20]))){
    $this->data = json_encode(array(
        "success" => false,
        "msg" => 'El Numero de Cuenta  '.$data->sheets[0]['cells'][$i][20].' debe ser númerico linea '.$i
    ));
    echo $this->data;
    return sfView::NONE;
}   

if(strlen(trim($data->sheets[0]['cells'][$i][20]))!=20){
    $this->data = json_encode(array(
        "success" => false,
        "msg" => 'El Numero de Cuenta  '.$data->sheets[0]['cells'][$i][20].' debe tener 20 digitos linea '.$i
    ));
    echo $this->data;
    return sfView::NONE;
}     
//INICIO NOMINA
//CO GRUPO NOMINA Y TP NOMINA
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);
        $c->addSelectColumn(Tbrh067GrupoNominaPeer::CO_TP_NOMINA);
        $c->add(Tbrh067GrupoNominaPeer::TX_GRUPO_NOMINA, $data->sheets[0]['cells'][$i][12]);
        $stmt = Tbrh067GrupoNominaPeer::doSelectStmt($c);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $co_tp_nomina = $result['co_tp_nomina'];
        $co_grupo_nomina = $result['co_grupo_nomina'];
//FIN CO GRUPO NOMINA Y TP NOMINA    

        
if($co_tp_nomina=='' && $co_tp_nomina==null){
    $this->data = json_encode(array(
        "success" => false,
        "msg" => 'La nomina no se encuentra registrada  ('.$data->sheets[0]['cells'][$i][12].') Verifique! linea '.$i
    ));
    echo $this->data;
    return sfView::NONE;
}        
        
$Tbrh001Trabajador = new Tbrh001Trabajador();
$Tbrh001Trabajador->setNuCedula($data->sheets[0]['cells'][$i][1])
                  ->setNbPrimerApellido($data->sheets[0]['cells'][$i][2])
                  ->setNbSegundoApellido($data->sheets[0]['cells'][$i][3])
                  ->setNbPrimerNombre($data->sheets[0]['cells'][$i][4])
                  ->setNbSegundoNombre($data->sheets[0]['cells'][$i][5])
                  ->setTxNactra($data->sheets[0]['cells'][$i][6])
                  ->setCoDocumento($data->sheets[0]['cells'][$i][7])
                  ->setCoSexo($data->sheets[0]['cells'][$i][8])
                  ->setCoEdoCivil($data->sheets[0]['cells'][$i][9])
                  ->setNuRif($data->sheets[0]['cells'][$i][11])
                  ->setFeNacimiento($fenac)
                  ->setCoNivelEducativo($data->sheets[0]['cells'][$i][17])
                  ->setTxNivelEducativo($tx_edu)
                  ->setNuHijo($data->sheets[0]['cells'][$i][18])
                  ->setCoBanco($cobanco)
                  ->setNuCuentaBancaria($data->sheets[0]['cells'][$i][20])
                  ->setCoSolicitud($codigoSoli)
                  ->save($con);
$co_trabajador = $Tbrh001Trabajador->getCoTrabajador();
$cantidadCargo=0;


//FIN TBRH001
//INICIO FICHA     
$tbrh002_ficha = new Tbrh002Ficha();
$tbrh002_ficha->setCoTrabajador($co_trabajador)
              ->setFeIngreso($feing)
              ->setCoEstatus(0)
              ->setNuFicha($data->sheets[0]['cells'][$i][1])
              ->setInActivo(FALSE)
             ->save($con);
$ficha = $tbrh002_ficha->getCoFicha();
//FIN FICHA  



//Ingreso Tbrh015
$tbrh015_nom_trabajador = new Tbrh015NomTrabajador();
$tbrh015_nom_trabajador->setCoCargoEstructura($co_cargo_estructura);
$tbrh015_nom_trabajador->setCoTpNomina($co_tp_nomina);
$tbrh015_nom_trabajador->setFeIngreso($feing2);
$tbrh015_nom_trabajador->setCoGrupoNomina($co_grupo_nomina);

$tbrh015_nom_trabajador->setNuHoras($data->sheets[0]['cells'][$i][14]);
$tbrh015_nom_trabajador->setCoTpCargo($data->sheets[0]['cells'][$i][23]);
$tbrh015_nom_trabajador->setCoFicha($ficha);
if($data->sheets[0]['cells'][$i][13]==""){
$tbrh015_nom_trabajador->setInSueldoTab(TRUE);
//Calcular Sueldo
$c = new Criteria();     
$c->clearSelectColumns();
$c->addSelectColumn(Tbrh008TabuladorPeer::MO_SUELDO);
$c->addSelectColumn(Tbrh008TabuladorPeer::CO_TABULADOR);
$c->addJoin(Tbrh032CargoPeer::CO_CARGO, Tbrh009CargoEstructuraPeer::CO_CARGO);
$c->addJoin(Tbrh008TabuladorPeer::CO_TABULADOR, Tbrh032CargoPeer::CO_TABULADOR);
$c->add(Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA,$co_cargo_estructura);
$stmt = Tbrh009CargoEstructuraPeer::doSelectStmt($c);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$sueldo = $result['mo_sueldo'];
$co_tab = $result['co_tabulador'];
$tbrh015_nom_trabajador->setMoSalarioBase($sueldo);
$tbrh015_nom_trabajador->setCoTabulador($co_tab);
//Fin Calcular sueldo
}else{
$tbrh015_nom_trabajador->setInSueldoTab(FALSE);
$tbrh015_nom_trabajador->setMoSalarioBase($data->sheets[0]['cells'][$i][13]);
}
$tbrh015_nom_trabajador->setInActivo(FALSE);
$tbrh015_nom_trabajador->setInCestaticket(TRUE);
$tbrh015_nom_trabajador->setCoSolicitud($codigoSoli);
$tbrh015_nom_trabajador->save($con);      
//Fin ingreso tbrh015

//Ingreso tbrh105
$tbrh105_ingreso_trabajador = new Tbrh105IngresoTrabajador();
$tbrh105_ingreso_trabajador->setCoSolicitud($codigoSoli)
                          ->setCoFicha($ficha)
                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                          ->save($con);
//Fin ingreso 105


}else{
//La persona ya existe

       
 $num = $num.$data->sheets[0]['cells'][$i][1]." - ";
}




//        if($cantidadCargo > 0){
//          $num = $num.$data->sheets[0]['cells'][$i][1]." - ";
//        }
//        if($cantidadCargo == 0){
//          
//        
//        
////Fin Comprobar
//
//
//
//
//
//
////FIN TBRH001
////INICIO FICHA     
//$tbrh002_ficha = new Tbrh002Ficha();
//$tbrh002_ficha->setCoTrabajador($co_trabajador)
//              ->setFeIngreso($feing)
//              ->setCoEstatus(0)
//              ->setNuFicha($data->sheets[0]['cells'][$i][1])
//              ->setInActivo(FALSE)
//             ->save($con);
//$ficha = $tbrh002_ficha->getCoFicha();
////FIN FICHA  
//
////INICIO NOMINA
////CO GRUPO NOMINA Y TP NOMINA
//        $c = new Criteria();
//        $c->clearSelectColumns();
//        $c->addSelectColumn(Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);
//        $c->addSelectColumn(Tbrh067GrupoNominaPeer::CO_TP_NOMINA);
//        $c->add(Tbrh067GrupoNominaPeer::TX_GRUPO_NOMINA, $data->sheets[0]['cells'][$i][12]);
//        $stmt = Tbrh067GrupoNominaPeer::doSelectStmt($c);
//        $result = $stmt->fetch(PDO::FETCH_ASSOC);
//        $co_tp_nomina = $result['co_tp_nomina'];
//        $co_grupo_nomina = $result['co_grupo_nomina'];
////FIN CO GRUPO NOMINA Y TP NOMINA
//
//
//
////Ingreso Tbrh015
//$tbrh015_nom_trabajador = new Tbrh015NomTrabajador();
//$tbrh015_nom_trabajador->setCoCargoEstructura($co_cargo_estructura);
//$tbrh015_nom_trabajador->setCoTpNomina($co_tp_nomina);
//$tbrh015_nom_trabajador->setFeIngreso($feing2);
//$tbrh015_nom_trabajador->setCoGrupoNomina($co_grupo_nomina);
//
//$tbrh015_nom_trabajador->setNuHoras($data->sheets[0]['cells'][$i][14]);
//$tbrh015_nom_trabajador->setCoTpCargo($data->sheets[0]['cells'][$i][23]);
//$tbrh015_nom_trabajador->setCoFicha($ficha);
//if($data->sheets[0]['cells'][$i][13]==""){
//$tbrh015_nom_trabajador->setInSueldoTab(TRUE);
////Calcular Sueldo
//$c = new Criteria();     
//$c->clearSelectColumns();
//$c->addSelectColumn(Tbrh008TabuladorPeer::MO_SUELDO);
//$c->addSelectColumn(Tbrh008TabuladorPeer::CO_TABULADOR);
//$c->addJoin(Tbrh032CargoPeer::CO_CARGO, Tbrh009CargoEstructuraPeer::CO_CARGO);
//$c->addJoin(Tbrh008TabuladorPeer::CO_TABULADOR, Tbrh032CargoPeer::CO_TABULADOR);
//$c->add(Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA,$co_cargo_estructura);
//$stmt = Tbrh009CargoEstructuraPeer::doSelectStmt($c);
//$result = $stmt->fetch(PDO::FETCH_ASSOC);
//$sueldo = $result['mo_sueldo'];
//$co_tab = $result['co_tabulador'];
//$tbrh015_nom_trabajador->setMoSalarioBase($sueldo);
//$tbrh015_nom_trabajador->setCoTabulador($co_tab);
////Fin Calcular sueldo
//}else{
//$tbrh015_nom_trabajador->setInSueldoTab(FALSE);
//$tbrh015_nom_trabajador->setMoSalarioBase($data->sheets[0]['cells'][$i][13]);
//}
//$tbrh015_nom_trabajador->setInActivo(FALSE);
//$tbrh015_nom_trabajador->setInCestaticket(TRUE);
//$tbrh015_nom_trabajador->setCoSolicitud($codigoSoli);
//$tbrh015_nom_trabajador->save($con);      
////Fin ingreso tbrh015
//
////Ingreso tbrh105
//$tbrh105_ingreso_trabajador = new Tbrh105IngresoTrabajador();
//$tbrh105_ingreso_trabajador->setCoSolicitud($codigoSoli)
//                          ->setCoFicha($ficha)
//                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
//                          ->save($con);
////Fin ingreso 105
//
//
////FIN NOMINA
//}

}
if($num != ""){
$this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'La carga masiva se realizó exitosamente!, Estas personas ya existen y han sido ignorados: CI: '.$num
        ));
        $con->commit();


        echo $this->data;
        return sfView::NONE;
}
$this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'La carga masiva se realizó exitosamente!'
        ));
        $con->commit();


        echo $this->data;
        return sfView::NONE;
        
        
      }catch (PropelException $e){
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage().'-'.$i
        ));
      }

       echo $this->data;
       return sfView::NONE;




//ESTRUCTURA ADMINISTRATIVA
//  $nu_codigo_cargo = "12113";
//  $nu_codigo_estruc = "0800510007";
//   $c = new Criteria();
//        $c->clearSelectColumns();
//        $c->addSelectColumn(Tbrh009CargoEstructuraPeer::CO_ESTRUCTURA_ADMINISTRATIVA);
//        $c->add(Tbrh009CargoEstructuraPeer::NU_CODIGO_CARGO, $nu_codigo_cargo);
//        $c->add(Tbrh009CargoEstructuraPeer::NU_CODIGO_ESTRUCTURA, $nu_codigo_estruc);
 //       $stmt = Tbrh001TrabajadorPeer::doSelectStmt($c);
//        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
//echo $campos['co_estructura_administrativa'];
     

  }
  
  
  public function executeNomina(sfWebRequest $request)
  {
	$this->data = $this->data = json_encode(array(
                "co_solicitud"             => $this->getRequestParameter("co_solicitud")
        ));
  }
  
  public function executeNominaMasivo(sfWebRequest $request)
  {
	$this->data = $this->data = json_encode(array(
                "co_solicitud"             => $this->getRequestParameter("co_solicitud")
        ));
  }

  public function executeLista(sfWebRequest $request)
  {
        $this->data = $this->data = json_encode(array(
                        "co_solicitud"             => $this->getRequestParameter("co_solicitud")
                      ));
  }

   public function executeLista2(sfWebRequest $request)
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
  
  public function executeSso(sfWebRequest $request)
  {
        $this->data = $this->data = json_encode(array(
                        "co_solicitud"             => $this->getRequestParameter("co_solicitud")
                      ));
  }
  
//mio
    public function executeStorefksituacion(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh024NomSituacionPeer::doSelectStmt($c);
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
//fin mio

   public function executeStorelistaSueldo(sfWebRequest $request)
  {
        $co_trabajador     =   $this->getRequestParameter("co_trabajador");
        
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_FICHA);
         $c->addSelectColumn(Tbrh015NomTrabajadorPeer::IN_CESTATICKET);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::MO_SALARIO_BASE);        
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::NU_HORAS);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA);
        $c->addSelectColumn(Tbrh067GrupoNominaPeer::TX_GRUPO_NOMINA);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::IN_SUELDO_TAB);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_TP_NOMINA);
        $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::FE_INGRESO);        
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::FE_FINIQUITO);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::IN_ACTIVO);
        $c->addSelectColumn(Tbrh032CargoPeer::TX_CARGO);
        $c->addSelectColumn(Tbrh032CargoPeer::CO_CARGO);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_TABULADOR);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_TP_CARGO);
        $c->addSelectColumn(Tbrh009CargoEstructuraPeer::CO_ESTRUCTURA_ADMINISTRATIVA);
        $c->addSelectColumn(Tbrh017TpNominaPeer::CO_CLASIF_PERSONAL);
        $c->addSelectColumn(Tbrh002FichaPeer::CO_ESTATUS);

        $c->addJoin(Tbrh015NomTrabajadorPeer::CO_FICHA, Tbrh002FichaPeer::CO_FICHA);
        $c->addJoin(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA, Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA);
        $c->addJoin(Tbrh009CargoEstructuraPeer::CO_CARGO, Tbrh032CargoPeer::CO_CARGO);
        $c->addJoin(Tbrh015NomTrabajadorPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
        $c->addJoin(Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA, Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);
        $c->add(Tbrh002FichaPeer::CO_TRABAJADOR,$co_trabajador);
       
//        echo $c->toString(); exit();
        
        $cantidadTotal = Tbrh002FichaPeer::doCount($c);
        
        $stmt = Tbrh002FichaPeer::doSelectStmt($c);
        
        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            if($res["in_sueldo_tab"]== true){
                $res["co_tipo_pago"] = '1';
                $res["tx_tipo_pago"] = 'Tabulador';
            }else{
                $res["co_tipo_pago"] = '2';
                $res["tx_tipo_pago"] = 'Sueldo';
            }
            
            list($anio,$mes,$dia) = explode("-", $res["fe_ingreso"]);
            $fe_ingreso = $dia.'/'.$mes.'/'.$anio;
            
            $registros[] = array(
                "co_nom_trabajador"      => $res["co_nom_trabajador"],
                "co_tp_nomina"           => $res["co_tp_nomina"],
                "co_tp_cargo"            => $res["co_tp_cargo"],
                "mo_salario_base"        => $res["mo_salario_base"],
                "co_tipo_pago"           => $res["co_tipo_pago"],
                "tx_tipo_pago"           => $res["tx_tipo_pago"],
                "nu_horas"               => $res["nu_horas"],
                "fe_ingreso"             => $fe_ingreso,
                "fe_finiquito"           => $res["fe_finiquito"],
                "co_cargo_estructura"    => $res["co_cargo_estructura"],
                "co_cargo"               => $res["co_cargo"],
                "tx_tp_nomina"           => $res["tx_tp_nomina"],
                "in_activo"              => $res["in_activo"],
                "tx_cargo"               => $res["tx_cargo"],
                "co_grupo_nomina"        => $res["co_grupo_nomina"],
                "co_tabulador"        => $res["co_tabulador"],
                "tx_grupo_nomina"        => $res["tx_grupo_nomina"],
                "co_ficha"        => $res["co_ficha"],
                "co_clasif_personal"        => $res["co_clasif_personal"],
                "co_estatus"        => $res["co_estatus"],
                "in_cestaticket"        => $res["in_cestaticket"],
                "co_estructura_administrativa"  => $res["co_estructura_administrativa"],
                "tx_estructura"                 => Tbrh005EstructuraAdministrativaPeer::getUbicacionEstructura($res["co_estructura_administrativa"])
            );
        }
        
        $grupo = Tbrh015NomTrabajadorPeer::grupo($co_trabajador);
        $subgrupo = Tbrh015NomTrabajadorPeer::subgrupo($co_trabajador);

        $this->data = json_encode(array(
            "success"  =>  true,
            "total"    =>  $cantidadTotal,
            "data"     =>  $registros,
            "grupo"    =>  $grupo,
            "subgrupo" =>  $subgrupo,
            ));
        
        
        $this->setTemplate("store");
       
  }

  public function executeStorelistaSueldo2(sfWebRequest $request)
  {
        $co_trabajador     =   $this->getRequestParameter("co_trabajador");
        
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::MO_SALARIO_BASE);        
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::NU_HORAS);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::IN_SUELDO_TAB);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_TP_NOMINA);
        $c->addSelectColumn(Tbrh067GrupoNominaPeer::TX_GRUPO_NOMINA);
        $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::FE_INGRESO);        
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::FE_FINIQUITO);
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::IN_ACTIVO);
        $c->addSelectColumn(Tbrh032CargoPeer::TX_CARGO);
        $c->addSelectColumn(Tbrh032CargoPeer::CO_CARGO);
        
        $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_TP_CARGO);

        $c->addSelectColumn(Tbrh009CargoEstructuraPeer::CO_TABULADOR);

        $c->addSelectColumn(Tbrh009CargoEstructuraPeer::CO_ESTRUCTURA_ADMINISTRATIVA);
        

        $c->addJoin(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA, Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA);
        $c->addJoin(Tbrh015NomTrabajadorPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
        $c->addJoin(Tbrh015NomTrabajadorPeer::CO_FICHA, Tbrh002FichaPeer::CO_FICHA);
        $c->addJoin(Tbrh009CargoEstructuraPeer::CO_CARGO, Tbrh032CargoPeer::CO_CARGO);
        $c->addJoin(Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA, Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);
        

        $c->add(Tbrh002FichaPeer::CO_TRABAJADOR,$co_trabajador);
       
//        echo $c->toString(); exit();
        
        $cantidadTotal = Tbrh002FichaPeer::doCount($c);
        
        $stmt = Tbrh002FichaPeer::doSelectStmt($c);
        
        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            if($res["in_sueldo_tab"]== true){
                $res["co_tipo_pago"] = '1';
                $res["tx_tipo_pago"] = 'Tabulador';
            }else{
                $res["co_tipo_pago"] = '2';
                $res["tx_tipo_pago"] = 'Sueldo';
            }
            
            list($anio,$mes,$dia) = explode("-", $res["fe_ingreso"]);
            $fe_ingreso = $dia.'/'.$mes.'/'.$anio;
            
            $registros[] = array(
                "co_nom_trabajador"      => $res["co_nom_trabajador"],
                "co_tp_nomina"           => $res["co_tp_nomina"],
                "co_tp_cargo"            => $res["co_tp_cargo"],
                "mo_salario_base"        => $res["mo_salario_base"],
                "co_tipo_pago"           => $res["co_tipo_pago"],
                "tx_tipo_pago"           => $res["tx_tipo_pago"],
                "nu_horas"               => $res["nu_horas"],
                "fe_ingreso"             => $fe_ingreso,
                "fe_finiquito"           => $res["fe_finiquito"],
                "co_cargo_estructura"    => $res["co_cargo_estructura"],
                "co_cargo"               => $res["co_cargo"],
                "tx_tp_nomina"           => $res["tx_tp_nomina"],
                "in_activo"              => $res["in_activo"],
                "tx_cargo"               => $res["tx_cargo"],
                "co_grupo_nomina"        => $res["co_grupo_nomina"],
                "co_tabulador"        => $res["co_tabulador"],
                "tx_grupo_nomina"        => $res["tx_grupo_nomina"],
                "co_clasif_personal"        => '2',
                "co_estructura_administrativa"  => $res["co_estructura_administrativa"],
                "tx_estructura"                 => Tbrh005EstructuraAdministrativaPeer::getUbicacionEstructura($res["co_estructura_administrativa"])
            );
        }
        
       

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));
        
        
        $this->setTemplate("store");
       
  }
  
  public function executeStorelistafamiliar(sfWebRequest $request)
  {
        $co_trabajador     =   $this->getRequestParameter("co_trabajador");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh083FamiliarTrabajadorPeer::CO_FAMILIAR_TRABAJADOR);
        $c->addSelectColumn(Tbrh083FamiliarTrabajadorPeer::CO_SEXO);
        $c->addSelectColumn(Tbrh083FamiliarTrabajadorPeer::CO_PARENTESCO);
        $c->addSelectColumn(Tbrh083FamiliarTrabajadorPeer::TX_IDENTIFICACION);
        $c->addSelectColumn(Tbrh083FamiliarTrabajadorPeer::NB_FAMILIAR);
        $c->addSelectColumn(Tbrh083FamiliarTrabajadorPeer::FE_NACIMIENTO);
        $c->addSelectColumn(Tbrh083FamiliarTrabajadorPeer::CO_TRABAJADOR);
        $c->addSelectColumn(Tbrh046SexoPeer::TX_SEXO);
        $c->addSelectColumn(Tbrh082ParentescoPeer::TX_PARENTESCO);

        $c->addJoin(Tbrh083FamiliarTrabajadorPeer::CO_SEXO, Tbrh046SexoPeer::CO_SEXO);
        $c->addJoin(Tbrh083FamiliarTrabajadorPeer::CO_PARENTESCO, Tbrh082ParentescoPeer::CO_PARENTESCO);

        $c->add(Tbrh083FamiliarTrabajadorPeer::CO_TRABAJADOR,$co_trabajador);
        $c->add(Tbrh083FamiliarTrabajadorPeer::IN_REMOVIDO,NULL, Criteria::ISNULL);
       
        $cantidadTotal = Tbrh083FamiliarTrabajadorPeer::doCount($c);
        
        $stmt = Tbrh083FamiliarTrabajadorPeer::doSelectStmt($c);
        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            list($anio,$mes,$dia) = explode("-", $res["fe_nacimiento"]);
            $fecha = $dia.'-'.$mes.'-'.$anio;          
            
            $registros[] = array(
                "co_familiar_trabajador"=> $res["co_familiar_trabajador"],
                "co_sexo"               => $res["co_sexo"],
                "co_parentesco"         => $res["co_parentesco"],
                "tx_identificacion"     => $res["tx_identificacion"],
                "nb_familiar"           => $res["nb_familiar"],
                "fe_nacimiento"         => $fecha,
                "tx_sexo"               => $res["tx_sexo"],
                "tx_parentesco"         => $res["tx_parentesco"],
                "co_trabajador"         => $res["co_trabajador"]
            );
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));
        
        
        $this->setTemplate("store");
       
  }
  
  public function executeStorelistaprofesion(sfWebRequest $request)
  {
        $co_trabajador     =   $this->getRequestParameter("co_trabajador");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh084ProfesionTrabajadorPeer::CO_PROFESION_TRABAJADOR);
        $c->addSelectColumn(Tbrh084ProfesionTrabajadorPeer::CO_TRABAJADOR);
        $c->addSelectColumn(Tbrh084ProfesionTrabajadorPeer::CO_PROFESION);
        $c->addSelectColumn(Tbrh084ProfesionTrabajadorPeer::CO_UNIVERSIDAD);
        $c->addSelectColumn(Tbrh084ProfesionTrabajadorPeer::FE_EGRESO);
        $c->addSelectColumn(Tbrh084ProfesionTrabajadorPeer::TX_TITULO_OBTENIDO);
        $c->addSelectColumn(Tbrh085UniversidadPeer::TX_UNIVERSIDAD);
        $c->addSelectColumn(Tbrh043ProfesionPeer::TX_PROFESION);
        $c->addSelectColumn(Tbrh084ProfesionTrabajadorPeer::FE_EGRESO);

        $c->addJoin(Tbrh084ProfesionTrabajadorPeer::CO_PROFESION, Tbrh043ProfesionPeer::CO_PROFESION);
        $c->addJoin(Tbrh084ProfesionTrabajadorPeer::CO_UNIVERSIDAD, Tbrh085UniversidadPeer::CO_UNIVERSIDAD);

        $c->add(Tbrh084ProfesionTrabajadorPeer::CO_TRABAJADOR,$co_trabajador);
       
        $cantidadTotal = Tbrh083FamiliarTrabajadorPeer::doCount($c);
        
        $stmt = Tbrh083FamiliarTrabajadorPeer::doSelectStmt($c);
        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            list($anio,$mes,$dia) = explode("-", $res["fe_egreso"]);
            $fecha = $dia.'-'.$mes.'-'.$anio;          
            
            $registros[] = array(
                "co_profesion_trabajador"    => $res["co_profesion_trabajador"],
                "co_profesion"               => $res["co_profesion"],
                "co_universidad"             => $res["co_universidad"],
                "tx_profesion"               => $res["tx_profesion"],
                "tx_universidad"             => $res["tx_universidad"],
                "tx_titulo_obtenido"         => $res["tx_titulo_obtenido"],
                "fe_egreso"                  => $fecha,
                "co_trabajador"              => $res["co_trabajador"]
            );
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));
        
        
        $this->setTemplate("store");
       
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

    $c->addSelectColumn(Tbrh001TrabajadorPeer::TX_NACTRA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_DOCUMENTO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_SEXO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_EDO_CIVIL);

    $c->addSelectColumn(Tbrh001TrabajadorPeer::IN_SEGURO_SOCIAL);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::IN_NOMINA);
    $c->addSelectColumn(Tbrh043ProfesionPeer::TX_PROFESION);
    $c->addSelectColumn(Tb010BancoPeer::TX_BANCO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CUENTA_BANCARIA);
    $c->addSelectColumn(Tbrh105IngresoTrabajadorPeer::CO_INGRESO_TRABAJADOR);
    $c->addSelectColumn(Tbrh015NomTrabajadorPeer::MO_SALARIO_BASE);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::FE_NACIMIENTO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_RIF);
    $c->addSelectColumn(Tbrh009CargoEstructuraPeer::NU_CODIGO_ESTRUCTURA);
    $c->addSelectColumn(Tbrh067GrupoNominaPeer::TX_GRUPO_NOMINA);
    $c->addSelectColumn(Tbrh002FichaPeer::FE_INGRESO);

    $c->addJoin(Tbrh002FichaPeer::CO_FICHA, Tbrh105IngresoTrabajadorPeer::CO_FICHA,   Criteria::LEFT_JOIN);
    $c->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
    $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tbrh001TrabajadorPeer::CO_DOCUMENTO);
    $c->addJoin(Tbrh001TrabajadorPeer::CO_BANCO, Tb010BancoPeer::CO_BANCO,   Criteria::LEFT_JOIN);
    $c->addJoin(Tbrh001TrabajadorPeer::CO_PROFESION, Tbrh043ProfesionPeer::CO_PROFESION,  Criteria::LEFT_JOIN);
    $c->addJoin(Tbrh002FichaPeer::CO_FICHA, Tbrh015NomTrabajadorPeer::CO_FICHA,  Criteria::LEFT_JOIN);
    $c->addJoin(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA, Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA,  Criteria::LEFT_JOIN);
    $c->addJoin(Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA, Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA,  Criteria::LEFT_JOIN);

    $c->add(Tbrh105IngresoTrabajadorPeer::CO_SOLICITUD,$co_solicitud);
    $c->add(Tbrh105IngresoTrabajadorPeer::IN_DELETE,null,Criteria::ISNULL);
    
                    
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh001TrabajadorPeer::doCount($c);
    
//    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tbrh001TrabajadorPeer::CO_TRABAJADOR);
        //cambio
    $stmt = Tbrh001TrabajadorPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "in_seguro_social"      => ($res["in_seguro_social"]==null)?'Pendiente':'Procesado',
            "in_nomina"             => ($res["in_nomina"]==null)?'Pendiente':'Procesado',
            "co_trabajador"         => trim($res["co_trabajador"]),
            "nu_cedula"             => trim($res["inicial"]).'-'.trim($res["nu_cedula"]),
            "nb_primer_nombre"      => trim($res["nb_primer_nombre"]).' '.trim($res["nb_segundo_nombre"]).' '.trim($res["nb_primer_apellido"]).' '.trim($res["nb_segundo_apellido"]),
            "co_documento"          => trim($res["co_documento"]),
            "co_profesion"          => trim($res["tx_profesion"]),
            "tx_banco"              => trim($res["tx_banco"]),
            "nu_cuenta_bancaria"    => trim($res["nu_cuenta_bancaria"]),
            "co_ingreso_trabajador" => trim($res["co_ingreso_trabajador"]),
            "co_sexo" => trim($res["co_sexo"]),
            "co_edo_civil" => trim($res["co_edo_civil"]),
            "fe_nacimiento" => trim($res["fe_nacimiento"]),
            "nu_rif" => trim($res["nu_rif"]),
            "mo_salario_base" => trim($res["mo_salario_base"]),
            "tx_nactra" => trim($res["tx_nactra"]),
            "tx_grupo_nomina" => trim($res["tx_grupo_nomina"]),
            "nu_codigo_estructura" => trim($res["nu_codigo_estructura"]),
            "fe_ingreso" => trim($res["fe_ingreso"]),     
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }
    
    public function executeListaTrabajador(sfWebRequest $request)
    {
        
    }
    
    public function executeStorelistaTrabajador(sfWebRequest $request)
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
      $c->addSelectColumn(Tbrh001TrabajadorPeer::IN_SEGURO_SOCIAL);
      $c->addSelectColumn(Tbrh001TrabajadorPeer::IN_NOMINA);
      $c->addSelectColumn(Tbrh043ProfesionPeer::TX_PROFESION);
      $c->addSelectColumn(Tb010BancoPeer::TX_BANCO);
      $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CUENTA_BANCARIA);

      $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tbrh001TrabajadorPeer::CO_DOCUMENTO);
      $c->addJoin(Tbrh001TrabajadorPeer::CO_BANCO, Tb010BancoPeer::CO_BANCO,   Criteria::LEFT_JOIN);
      $c->addJoin(Tbrh001TrabajadorPeer::CO_PROFESION, Tbrh043ProfesionPeer::CO_PROFESION,  Criteria::LEFT_JOIN);

      $c->add(Tbrh001TrabajadorPeer::CO_SOLICITUD,$co_solicitud);


      $c->setIgnoreCase(true);
      $cantidadTotal = Tbrh001TrabajadorPeer::doCount($c);

      $c->setLimit($limit)->setOffset($start);
      $c->addAscendingOrderByColumn(Tbrh001TrabajadorPeer::CO_TRABAJADOR);

      $stmt = Tbrh001TrabajadorPeer::doSelectStmt($c);
      $registros = "";
      while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
      $registros[] = array(
              "in_seguro_social"   => ($res["in_seguro_social"]==null)?'Pendiente':'Procesado',
              "in_nomina"          => ($res["in_nomina"]==null)?'Pendiente':'Procesado',
              "co_trabajador"      => trim($res["co_trabajador"]),
              "nu_cedula"          => trim($res["inicial"]).'-'.trim($res["nu_cedula"]),
              "nb_primer_nombre"   => trim($res["nb_primer_nombre"]).' '.trim($res["nb_segundo_nombre"]).' '.trim($res["nb_primer_apellido"]).' '.trim($res["nb_segundo_apellido"]),
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
    }


         
    public function executeStorefkcodocumento(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb007DocumentoPeer::TIPO,'N');
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
    
     public function executeStorefkcosexo(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh046SexoPeer::doSelectStmt($c);
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
    
    public function executeStorefkcoedocivil(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh047EdoCivilPeer::doSelectStmt($c);
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
    
    public function executeStorefkcomunicipio(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb017MunicipioPeer::CO_ESTADO,$this->getRequestParameter("co_estado"));
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
    
    public function executeStorefkcoparroquia(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb170ParroquiaPeer::CO_MUNICIPIO,$this->getRequestParameter("co_municipio"));
        $stmt = Tb170ParroquiaPeer::doSelectStmt($c);
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
    
    public function executeStorefkcobanco(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb010BancoPeer::doSelectStmt($c);
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
    
    public function executeStorefkcogruposanguineo(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh048GrupoSanguineoPeer::doSelectStmt($c);
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
    
    public function executeStorefkcodestreza(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh049DestrezaPeer::doSelectStmt($c);
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
    
    public function executeStorefkcotipovivienda(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh050TipoViviendaPeer::doSelectStmt($c);
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
    
    public function executeStorefkcogradoinstrucccion(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tbrh037NomGradoInstruccionPeer::IN_ACTIVO,true);
        $stmt = Tbrh037NomGradoInstruccionPeer::doSelectStmt($c);
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
    
    public function executeStorefkcoprofesion(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tbrh043ProfesionPeer::IN_ACTIVO,true);
        $stmt = Tbrh043ProfesionPeer::doSelectStmt($c);
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
    
     public function executeStorefkcoparentesco(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh082ParentescoPeer::doSelectStmt($c);
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
    
    
    
     public function executeStorefkcouniversidad(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh085UniversidadPeer::doSelectStmt($c);
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
    
     public function executeStorefkcocargo(sfWebRequest $request){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA);
        $c->addSelectColumn(Tbrh032CargoPeer::TX_CARGO);
        $c->addJoin(Tbrh032CargoPeer::CO_CARGO, Tbrh009CargoEstructuraPeer::CO_CARGO);
        $c->add(Tbrh009CargoEstructuraPeer::CO_ESTRUCTURA_ADMINISTRATIVA,$this->getRequestParameter("co_estructura_administrativa"));
        $c->add(Tbrh032CargoPeer::CO_CLASIF_PERSONAL,$this->getRequestParameter("co_clasif_personal"));
        $c->add(Tbrh032CargoPeer::IN_ACTIVO,TRUE);
        $c->addAscendingOrderByColumn(Tbrh032CargoPeer::TX_CARGO);
        $stmt = Tbrh032CargoPeer::doSelectStmt($c);
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
    
     public function executeStorefkcotipocargo(sfWebRequest $request){
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tbrh084TipoCargoPeer::TX_TIPO_CARGO);
        $stmt = Tbrh084TipoCargoPeer::doSelectStmt($c);
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
    
    public function executeStorefkcotipopago(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh80TipoDePagoPeer::doSelectStmt($c);
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
    
    public function executeStorefkconomina(sfWebRequest $request){
       
        $c = new Criteria();
        $stmt = Tbrh017TpNominaPeer::doSelectStmt($c);
        
        $registros = array();
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = array(
                "co_tp_nomina" => trim($res["co_tp_nomina"]),
                "tx_tp_nomina" => trim($res["tx_tp_nomina"]),
                "co_clasif_personal" => trim($res["co_clasif_personal"])
            );
        }
        
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        $this->setTemplate('store');
      
    }
    
    public function executeStorefkcogruponomina(sfWebRequest $request){
       
        $c = new Criteria();
        $c->add(Tbrh067GrupoNominaPeer::CO_TP_NOMINA,$this->getRequestParameter("co_tp_nomina"));
        $stmt = Tbrh067GrupoNominaPeer::doSelectStmt($c);
        
        $registros = array();
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = array(
                "co_grupo_nomina" => trim($res["co_grupo_nomina"]),
                "tx_grupo_nomina" => trim($res["tx_grupo_nomina"])
            );
        }
        
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        $this->setTemplate('store');
      
    }
    
    public function executeStorefkcotabulador(sfWebRequest $request){
       
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh008TabuladorPeer::CO_TABULADOR);
        $c->addSelectColumn(Tbrh008TabuladorPeer::NU_CODIGO_TAB);
        $c->addSelectColumn(Tbrh008TabuladorPeer::MO_SUELDO);
        $c->addSelectColumn(Tbrh099ClasifPersonalPeer::TX_CLASIF_PERSONAL);
        $c->addJoin(Tbrh008TabuladorPeer::CO_CLASIF_PERSONAL, Tbrh099ClasifPersonalPeer::CO_CLASIF_PERSONAL);
        $c->add(Tbrh008TabuladorPeer::CO_CLASIF_PERSONAL,$this->getRequestParameter("co_clasif_personal"));
        $stmt = Tbrh008TabuladorPeer::doSelectStmt($c);
        
        $registros = array();
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = array(
                "co_tabulador" => trim($res["co_tabulador"]),
                "nu_codigo_tab" => trim($res["nu_codigo_tab"].' - '.$res["tx_clasif_personal"]),
                "mo_sueldo" => trim($res["mo_sueldo"])
            );
        }
        
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        $this->setTemplate('store');
      
    }    
    
    public function executeVerificarTrabajador(sfWebRequest $request)
    {

          $co_documento  = $this->getRequestParameter('co_documento');
          $nu_cedula     = $this->getRequestParameter('nu_cedula');

          $c = new Criteria(); 
          $c->addJoin(Tbrh001TrabajadorPeer::CO_TRABAJADOR,Tbrh002FichaPeer::CO_TRABAJADOR);
          $c->add(Tbrh001TrabajadorPeer::CO_DOCUMENTO,$co_documento);
          $c->add(Tbrh001TrabajadorPeer::NU_CEDULA,$nu_cedula);
          $c->add(Tbrh002FichaPeer::CO_ESTATUS,1);
          
          $stmt = Tbrh001TrabajadorPeer::doSelectStmt($c);

          $registros = $stmt->fetch(PDO::FETCH_ASSOC);
          
          $this->data = json_encode(array(
              "success"   => true,
              "data"      => $registros
          ));
          $this->setTemplate('store');
    }
    
    public function executeVerificarSueldo(sfWebRequest $request)
    {

          $co_cargo_estructura  = $this->getRequestParameter('co_cargo_estructura');

          $c = new Criteria();     
          $c->clearSelectColumns();
          $c->addSelectColumn(Tbrh008TabuladorPeer::MO_SUELDO);
          $c->addJoin(Tbrh032CargoPeer::CO_CARGO, Tbrh009CargoEstructuraPeer::CO_CARGO);
          $c->addJoin(Tbrh008TabuladorPeer::CO_TABULADOR, Tbrh032CargoPeer::CO_TABULADOR);
          $c->add(Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA,$co_cargo_estructura);
          $stmt = Tbrh009CargoEstructuraPeer::doSelectStmt($c);

          $registros = $stmt->fetch(PDO::FETCH_ASSOC);
          
          $this->data = json_encode(array(
              "success"   => true,
              "data"      => $registros
          ));
          $this->setTemplate('store');
    }
    
    
    public function executeStorelistaaprobacion(sfWebRequest $request)
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
      $c->addSelectColumn(Tbrh002FichaPeer::FE_INGRESO);
      $c->addSelectColumn(Tbrh002FichaPeer::CO_FICHA);
//      $c->addSelectColumn(Tbrh032CargoPeer::TX_CARGO);
      $c->addSelectColumn(Tbrh105IngresoTrabajadorPeer::IN_PROCESADA);
//      $c->addSelectColumn(Tbrh067GrupoNominaPeer::TX_GRUPO_NOMINA);
//      $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);

//      $c->addJoin(Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA, Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);
//      $c->addJoin(Tbrh015NomTrabajadorPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
//      $c->addJoin(Tbrh032CargoPeer::CO_CARGO, Tbrh009CargoEstructuraPeer::CO_CARGO);
//      $c->addJoin(Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA, Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA);
//      $c->addJoin(Tbrh002FichaPeer::CO_FICHA, Tbrh015NomTrabajadorPeer::CO_FICHA);
      $c->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
      $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tbrh001TrabajadorPeer::CO_DOCUMENTO);
      $c->addJoin(Tbrh002FichaPeer::CO_FICHA, Tbrh105IngresoTrabajadorPeer::CO_FICHA);

      $c->add(Tbrh105IngresoTrabajadorPeer::CO_SOLICITUD,$co_solicitud);    

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
              "co_nom_trabajador"  => trim($res["co_nom_trabajador"]),
              "co_egreso"          => $res["co_egreso"],
              "co_ficha"           => $res["co_ficha"],
              "in_procesado"       => ($res["in_procesada"]==true)?'<b>Procesado<b>':'Pendiente',
              "nu_cedula"          => trim($res["inicial"]).'-'.trim($res["nu_cedula"]),
              "nb_primer_nombre"   => trim($res["nb_primer_nombre"]).' '.trim($res["nb_segundo_nombre"]).' '.trim($res["nb_primer_apellido"]).' '.trim($res["nb_segundo_apellido"]),
              "co_documento"       => trim($res["co_documento"]),
              "fe_ingreso"         => trim($res["fe_ingreso"])
          );
      }

      $this->data = json_encode(array(
          "success"   =>  true,
          "total"     =>  $cantidadTotal,
          "data"      =>  $registros
          ));
    }
    
    public function executeGuardarAprobacion(sfWebRequest $request)
    {
          $json_co_ficha_trabajador = $this->getRequestParameter('json_co_ficha_trabajador');
          $co_solicitud           = $this->getRequestParameter('co_solicitud');

          $con = Propel::getConnection();        

          $array = array();
          $array = explode(",",$json_co_ficha_trabajador);

          foreach ($array as $key => $value) {  
              
              
            $tbrh002_ficha = Tbrh002FichaPeer::retrieveByPK($value);
            $tbrh002_ficha->setCoEstatus(1)
                          ->setInActivo(true)
                          ->save($con);
              
            $wherec = new Criteria();
            $wherec->add(Tbrh015NomTrabajadorPeer::CO_FICHA, $value);

            $updc = new Criteria();
            $updc->add(Tbrh015NomTrabajadorPeer::IN_ACTIVO,TRUE);
            BasePeer::doUpdate($wherec, $updc, $con);  

            
            $wherec = new Criteria();
            $wherec->add(Tbrh105IngresoTrabajadorPeer::CO_FICHA, $value);

            $updc = new Criteria();
            $updc->add(Tbrh105IngresoTrabajadorPeer::IN_PROCESADA,TRUE);
            BasePeer::doUpdate($wherec, $updc, $con);

             

          }

          $con->commit();

          $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));      

          $ruta->setInCargarDato(true)->save($con);
          Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta()); 
           $con->commit();

          $this->data = json_encode(array(
                      "success" => true,
                      "msg" => 'El ingreso se proceso exitosamente'
          ));



    }
    
    public function executeDatoNomina(sfWebRequest $request){

        $co_trabajador = $this->getRequestParameter('co_trabajador');

        $grupo = Tbrh015NomTrabajadorPeer::grupo($co_trabajador);
        $subgrupo = Tbrh015NomTrabajadorPeer::subgrupo($co_trabajador);

        $this->data = json_encode(
            array(
                "data" => array(
                    "grupo"     => $grupo,
                    "subgrupo"     => $subgrupo
                )
            )
        );
        
        $this->setTemplate("store");

    }

}