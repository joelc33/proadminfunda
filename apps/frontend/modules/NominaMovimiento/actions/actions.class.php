<?php

/**
 * NominaMovimiento actions.
 *
 * @package    gobel
 * @subpackage NominaMovimiento
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class NominaMovimientoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('NominaMovimiento', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    //$this->forward('NominaMovimiento', 'editar');
    $this->data = json_encode(
        array(
        "id_tbrh013_nomina"     => $this->getRequestParameter("id_tbrh013_nomina"),
        "id_tbrh002_ficha"     => $this->getRequestParameter("id_tbrh002_ficha"),
        "id_tbrh015_nom_trabajador"     => $this->getRequestParameter("id_tbrh015_nom_trabajador"),
        )
    );
  }

  public function executeFiltro(sfWebRequest $request)
  {
    $this->data = json_encode(
        array(
        "id_tbrh013_nomina"     => $this->getRequestParameter("id_tbrh013_nomina"),
        )
    );
  }

  public function executeFiltroSobregiro(sfWebRequest $request)
  {
    $this->data = json_encode(
        array(
        "id_tbrh013_nomina"     => $this->getRequestParameter("id_tbrh013_nomina"),
        )
    );
  }

  public function executeEmpleado(sfWebRequest $request)
  {

    $this->data = json_encode(
        array(
        "id_tbrh013_nomina"     => $this->getRequestParameter("codigo"),
        )
    );

  }

  public function executeEmpleadoMovimiento(sfWebRequest $request)
  {

    $this->data = json_encode(
        array(
        "id_tbrh013_nomina"     => $this->getRequestParameter("codigo"),
        )
    );

  }

  public function executeSobregiroLista(sfWebRequest $request)
  {

    $this->data = json_encode(
        array(
        "id_tbrh013_nomina"     => $this->getRequestParameter("id_tbrh013_nomina"),
        )
    );

  }

  public function executeSinCalculoLista(sfWebRequest $request)
  {

    $this->data = json_encode(
        array(
        "id_tbrh013_nomina"     => $this->getRequestParameter("id_tbrh013_nomina"),
        )
    );

  }

  public function executeDetalle(sfWebRequest $request)
  {

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
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_TELEFONO_CONTACTO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_TELEFONO_SECUNDARIO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_BANCO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CUENTA_BANCARIA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_GRUPO_SANGUINEO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_ESTATURA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_PESO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::IN_LENTE);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::IN_VEHICULO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_GRADO_LICENCIA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_DESTREZA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_TIPO_VIVIENDA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::TX_RUTA_IMAGEN);
    $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
    $c->addSelectColumn(Tbrh015NomTrabajadorPeer::MO_SALARIO_BASE);
    $c->addSelectColumn(Tbrh002FichaPeer::FE_INGRESO);
    $c->addSelectColumn(Tbrh032CargoPeer::TX_CARGO);
    $c->addSelectColumn(Tbrh024NomSituacionPeer::TX_NOM_SITUACION);
    
    $c->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR,Tbrh001TrabajadorPeer::CO_TRABAJADOR);
    $c->addJoin(Tbrh001TrabajadorPeer::CO_DOCUMENTO,Tb007DocumentoPeer::CO_DOCUMENTO);
    $c->addJoin(Tbrh002FichaPeer::CO_FICHA, Tbrh015NomTrabajadorPeer::CO_FICHA);
    $c->addJoin(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA, Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA, Criteria::LEFT_JOIN);
    $c->addJoin(Tbrh009CargoEstructuraPeer::CO_CARGO, Tbrh032CargoPeer::CO_CARGO, Criteria::LEFT_JOIN);
    $c->addJoin(Tbrh002FichaPeer::CO_ESTATUS, Tbrh024NomSituacionPeer::CO_NOM_SITUACION, Criteria::LEFT_JOIN);
    $c->add(Tbrh002FichaPeer::CO_FICHA, $this->getRequestParameter("id_tbrh002_ficha"));
    $c->add(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR, $this->getRequestParameter("id_tbrh015_nom_trabajador"));
    
    $stmt = Tbrh002FichaPeer::doSelectStmt($c);
    $campos = $stmt->fetch(PDO::FETCH_ASSOC);

    $imagen = new myConfig();
        
    if (!empty($campos["tx_ruta_imagen"])) {            
        $imagen->setConvertToURL($campos["tx_ruta_imagen"]);
    } else {
        $foto = $imagen->getDirectorio().'foto/bust-in-silhouette.png';
        $imagen->setConvertToURL($foto);
    }        
    
    $foto = $imagen->getConvertToURL();

    $this->data = json_encode(
        array(
            "co_trabajador"             => $campos["co_trabajador"],
            "nu_documento"              => $campos["inicial"].'-'.$campos["nu_cedula"],
            "nu_cedula"                 => $campos["nu_cedula"],
            "nb_primer_nombre"          => $campos["nb_primer_nombre"],
            "nb_segundo_nombre"         => $campos["nb_segundo_nombre"],
            "nb_primer_apellido"        => $campos["nb_primer_apellido"],
            "nb_segundo_apellido"       => $campos["nb_segundo_apellido"],
            "nb_trabajador"       => $campos["nb_primer_nombre"].' '.$campos["nb_segundo_nombre"].' '.$campos["nb_primer_apellido"].' '.$campos["nb_segundo_apellido"],
            "co_documento"              => $campos["co_documento"],
            "co_ente"                   => $campos["co_ente"],
            "co_edo_civil"              => $campos["co_edo_civil"],
            "fe_nacimiento"             => $campos["fe_nacimiento"],
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
            "tx_cargo"          => $campos["tx_cargo"],
            "tx_nom_situacion"          => $campos["tx_nom_situacion"],
            "fe_ingreso"          => date("d-m-Y", strtotime($campos["fe_ingreso"])),
            "mo_salario_base"          => number_format($campos["mo_salario_base"], 2, ',', '.'),
            "id_tbrh013_nomina"         => $this->getRequestParameter("id_tbrh013_nomina"),
            "id_tbrh002_ficha"          => $this->getRequestParameter("id_tbrh002_ficha"),
            "id_tbrh015_nom_trabajador"          => $this->getRequestParameter("id_tbrh015_nom_trabajador"),
            "foto"                      => $foto
        )
    );

  }

  public function executeDetalleSobregiro(sfWebRequest $request)
  {

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
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_TELEFONO_CONTACTO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_TELEFONO_SECUNDARIO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_BANCO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CUENTA_BANCARIA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_GRUPO_SANGUINEO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_ESTATURA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_PESO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::IN_LENTE);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::IN_VEHICULO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_GRADO_LICENCIA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_DESTREZA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_TIPO_VIVIENDA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::TX_RUTA_IMAGEN);
    $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
    $c->addSelectColumn(Tbrh015NomTrabajadorPeer::MO_SALARIO_BASE);
    $c->addSelectColumn(Tbrh002FichaPeer::FE_INGRESO);
    $c->addSelectColumn(Tbrh032CargoPeer::TX_CARGO);
    $c->addSelectColumn(Tbrh024NomSituacionPeer::TX_NOM_SITUACION);
    
    $c->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR,Tbrh001TrabajadorPeer::CO_TRABAJADOR);
    $c->addJoin(Tbrh001TrabajadorPeer::CO_DOCUMENTO,Tb007DocumentoPeer::CO_DOCUMENTO);
    $c->addJoin(Tbrh002FichaPeer::CO_FICHA, Tbrh015NomTrabajadorPeer::CO_FICHA);
    $c->addJoin(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA, Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA, Criteria::LEFT_JOIN);
    $c->addJoin(Tbrh009CargoEstructuraPeer::CO_CARGO, Tbrh032CargoPeer::CO_CARGO, Criteria::LEFT_JOIN);
    $c->addJoin(Tbrh002FichaPeer::CO_ESTATUS, Tbrh024NomSituacionPeer::CO_NOM_SITUACION, Criteria::LEFT_JOIN);
    $c->add(Tbrh002FichaPeer::CO_FICHA, $this->getRequestParameter("id_tbrh002_ficha"));
    $c->add(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR, $this->getRequestParameter("id_tbrh015_nom_trabajador"));
    
    $stmt = Tbrh002FichaPeer::doSelectStmt($c);
    $campos = $stmt->fetch(PDO::FETCH_ASSOC);

    $imagen = new myConfig();
        
    if (!empty($campos["tx_ruta_imagen"])) {            
        $imagen->setConvertToURL($campos["tx_ruta_imagen"]);
    } else {
        $foto = $imagen->getDirectorio().'foto/bust-in-silhouette.png';
        $imagen->setConvertToURL($foto);
    }        
    
    $foto = $imagen->getConvertToURL();

    $this->data = json_encode(
        array(
            "co_trabajador"             => $campos["co_trabajador"],
            "nu_documento"              => $campos["inicial"].'-'.$campos["nu_cedula"],
            "nu_cedula"                 => $campos["nu_cedula"],
            "nb_primer_nombre"          => $campos["nb_primer_nombre"],
            "nb_segundo_nombre"         => $campos["nb_segundo_nombre"],
            "nb_primer_apellido"        => $campos["nb_primer_apellido"],
            "nb_segundo_apellido"       => $campos["nb_segundo_apellido"],
            "nb_trabajador"       => $campos["nb_primer_nombre"].' '.$campos["nb_segundo_nombre"].' '.$campos["nb_primer_apellido"].' '.$campos["nb_segundo_apellido"],
            "co_documento"              => $campos["co_documento"],
            "co_ente"                   => $campos["co_ente"],
            "co_edo_civil"              => $campos["co_edo_civil"],
            "fe_nacimiento"             => $campos["fe_nacimiento"],
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
            "tx_cargo"          => $campos["tx_cargo"],
            "tx_nom_situacion"          => $campos["tx_nom_situacion"],
            "fe_ingreso"          => date("d-m-Y", strtotime($campos["fe_ingreso"])),
            "mo_salario_base"          => number_format($campos["mo_salario_base"], 2, ',', '.'),
            "id_tbrh013_nomina"         => $this->getRequestParameter("id_tbrh013_nomina"),
            "id_tbrh002_ficha"          => $this->getRequestParameter("id_tbrh002_ficha"),
            "id_tbrh015_nom_trabajador"          => $this->getRequestParameter("id_tbrh015_nom_trabajador"),
            "foto"                      => $foto
        )
    );

  }

  public function executeDetalleCerrar(sfWebRequest $request)
  {

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
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_TELEFONO_CONTACTO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_TELEFONO_SECUNDARIO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_BANCO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CUENTA_BANCARIA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_GRUPO_SANGUINEO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_ESTATURA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_PESO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::IN_LENTE);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::IN_VEHICULO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_GRADO_LICENCIA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_DESTREZA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_TIPO_VIVIENDA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::TX_RUTA_IMAGEN);
    $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
    $c->addSelectColumn(Tbrh015NomTrabajadorPeer::MO_SALARIO_BASE);
    $c->addSelectColumn(Tbrh002FichaPeer::FE_INGRESO);
    $c->addSelectColumn(Tbrh032CargoPeer::TX_CARGO);
    
    $c->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR,Tbrh001TrabajadorPeer::CO_TRABAJADOR);
    $c->addJoin(Tbrh001TrabajadorPeer::CO_DOCUMENTO,Tb007DocumentoPeer::CO_DOCUMENTO);
    $c->addJoin(Tbrh002FichaPeer::CO_FICHA, Tbrh015NomTrabajadorPeer::CO_FICHA);
    $c->addJoin(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA, Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA, Criteria::LEFT_JOIN);
    $c->addJoin(Tbrh009CargoEstructuraPeer::CO_CARGO, Tbrh032CargoPeer::CO_CARGO, Criteria::LEFT_JOIN);
    $c->add(Tbrh002FichaPeer::CO_FICHA, $this->getRequestParameter("id_tbrh002_ficha"));
    $c->add(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR, $this->getRequestParameter("id_tbrh015_nom_trabajador"));
    
    $stmt = Tbrh002FichaPeer::doSelectStmt($c);
    $campos = $stmt->fetch(PDO::FETCH_ASSOC);

    $imagen = new myConfig();
        
    if (!empty($campos["tx_ruta_imagen"])) {            
        $imagen->setConvertToURL($campos["tx_ruta_imagen"]);
    } else {
        $foto = $imagen->getDirectorio().'foto/bust-in-silhouette.png';
        $imagen->setConvertToURL($foto);
    }        
    
    $foto = $imagen->getConvertToURL();

    $this->data = json_encode(
        array(
            "co_trabajador"             => $campos["co_trabajador"],
            "nu_documento"              => $campos["inicial"].'-'.$campos["nu_cedula"],
            "nu_cedula"                 => $campos["nu_cedula"],
            "nb_primer_nombre"          => $campos["nb_primer_nombre"],
            "nb_segundo_nombre"         => $campos["nb_segundo_nombre"],
            "nb_primer_apellido"        => $campos["nb_primer_apellido"],
            "nb_segundo_apellido"       => $campos["nb_segundo_apellido"],
            "nb_trabajador"       => $campos["nb_primer_nombre"].' '.$campos["nb_segundo_nombre"].' '.$campos["nb_primer_apellido"].' '.$campos["nb_segundo_apellido"],
            "co_documento"              => $campos["co_documento"],
            "co_ente"                   => $campos["co_ente"],
            "co_edo_civil"              => $campos["co_edo_civil"],
            "fe_nacimiento"             => $campos["fe_nacimiento"],
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
            "tx_cargo"          => $campos["tx_cargo"],
            "fe_ingreso"          => date("d-m-Y", strtotime($campos["fe_ingreso"])),
            "mo_salario_base"          => number_format($campos["mo_salario_base"], 2, ',', '.'),
            "id_tbrh013_nomina"         => $this->getRequestParameter("id_tbrh013_nomina"),
            "id_tbrh002_ficha"          => $this->getRequestParameter("id_tbrh002_ficha"),
            "id_tbrh015_nom_trabajador"          => $this->getRequestParameter("id_tbrh015_nom_trabajador"),
            "foto"                      => $foto
        )
    );

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID);
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::DE_CONCEPTO);
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::NU_VALOR);
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::NU_MONTO);
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::IN_DESCRIPCION_ALTERNATIVA);
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH014_CONCEPTO);
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR);
        $c->addSelectColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
        $c->addSelectColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH014_CONCEPTO, Tbrh014ConceptoPeer::CO_CONCEPTO);
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH020_TP_CONCEPTO, Tbrh020TpConceptoPeer::CO_TP_CONCEPTO);
        $c->add(Tbrh061NominaMovimientoPeer::ID,$codigo);
        
        $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tbrh013_nomina"     => $campos["id_tbrh013_nomina"],
                            "id_tbrh014_concepto"     => $campos["id_tbrh014_concepto"],
                            "id_tbrh020_tp_concepto"     => $campos["id_tbrh020_tp_concepto"],
                            "id_tbrh002_ficha"     => $campos["id_tbrh002_ficha"],
                            "nu_concepto"     => $campos["nu_concepto"],
                            "tx_tp_concepto"     => $campos["tx_tp_concepto"],
                            "de_concepto"     => $campos["de_concepto"],
                            "nu_valor"     => $campos["nu_valor"],
                            "nu_monto"     => $campos["nu_monto"],
                            "id_tbrh050_tp_unidad"     => $campos["id_tbrh050_tp_unidad"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "in_imprime_detalle"     => $campos["in_imprime_detalle"],
                            "in_descripcion_alternativa"     => $campos["in_descripcion_alternativa"],
                            "in_valor_referencia"     => $campos["in_valor_referencia"],
                            "in_hoja_tiempo"     => $campos["in_hoja_tiempo"],
                            "in_prorratea"     => $campos["in_prorratea"],
                            "in_modifica_descripcion"     => $campos["in_modifica_descripcion"],
                            "in_monto_calculo"     => $campos["in_monto_calculo"],
                            "in_contractual"     => $campos["in_contractual"],
                            "in_bonificable"     => $campos["in_bonificable"],
                            "in_monto_cero"     => $campos["in_monto_cero"],
                            "id_tbrh030_moneda"     => $campos["id_tbrh030_moneda"],
                            "id_tbrh015_nom_trabajador"     => $campos["id_tbrh015_nom_trabajador"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tbrh013_nomina"     => "",
                            "id_tbrh014_concepto"     => "",
                            "id_tbrh020_tp_concepto"     => "",
                            "id_tbrh002_ficha"     => "",
                            "de_concepto"     => "",
                            "nu_valor"     => "",
                            "nu_monto"     => "",
                            "id_tbrh050_tp_unidad"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "in_imprime_detalle"     => "",
                            "in_descripcion_alternativa"     => "",
                            "in_valor_referencia"     => "",
                            "in_hoja_tiempo"     => "",
                            "in_prorratea"     => "",
                            "in_modifica_descripcion"     => "",
                            "in_monto_calculo"     => "",
                            "in_contractual"     => "",
                            "in_bonificable"     => "",
                            "in_monto_cero"     => "",
                            "id_tbrh030_moneda"     => "",
                            "id_tbrh015_nom_trabajador"     => "",
                    ));
    }

  }

  public function executeEditarFijo(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh086ConceptosFijosPeer::CO_CONCEPTOS_FIJOS);
        $c->addSelectColumn(Tbrh014ConceptoPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tbrh086ConceptosFijosPeer::NU_VALOR);
        $c->addSelectColumn(Tbrh086ConceptosFijosPeer::NU_MONTO);
        $c->addSelectColumn(Tbrh086ConceptosFijosPeer::MO_SALDO);
        $c->addSelectColumn(Tbrh086ConceptosFijosPeer::TX_CODIGO_CONCEPTO);
        $c->addSelectColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
        $c->addAsColumn('nu_referencia', Tbrh014ConceptoPeer::NU_VALOR);
        $c->addJoin(Tbrh086ConceptosFijosPeer::CO_CONCEPTO_FORMULA, Tbrh014ConceptoPeer::CO_CONCEPTO);
        $c->addJoin(Tbrh014ConceptoPeer::CO_TIPO_CONCEPTO, Tbrh020TpConceptoPeer::CO_TP_CONCEPTO);
        $c->add(Tbrh086ConceptosFijosPeer::CO_CONCEPTOS_FIJOS,$codigo);
        
        $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["co_conceptos_fijos"],
                            "de_concepto"     => $campos["tx_concepto"],
                            "nu_valor"     => $campos["nu_valor"],
                            "nu_monto"     => $campos["nu_monto"],
                            "mo_saldo"     => $campos["mo_saldo"],
                            "nu_concepto"     => $campos["tx_codigo_concepto"],
                            "tx_tp_concepto"     => $campos["tx_tp_concepto"],
                            "nu_referencia"     => $campos["nu_referencia"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "tx_concepto"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");

            $id_tbrh015_nom_trabajador = $this->getRequestParameter("id_tbrh015_nom_trabajador");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh061_nomina_movimiento = Tbrh061NominaMovimientoPeer::retrieveByPk($codigo);
     }else{
         $tbrh061_nomina_movimiento = new Tbrh061NominaMovimiento();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh061_nomina_movimientoForm = $this->getRequestParameter('tbrh061_nomina_movimiento');
        /*CAMPOS*/

        /*Campo tipo VARCHAR */
        $tbrh061_nomina_movimiento->setDeConcepto($tbrh061_nomina_movimientoForm["de_concepto"]);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh061_nomina_movimiento->setNuValor($tbrh061_nomina_movimientoForm["nu_valor"]);

        $c = new Criteria();
        $c->setIgnoreCase(true);
        $c->clearSelectColumns();
        $c->addSelectColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
        $c->addSelectColumn(Tbrh014ConceptoPeer::DE_FORMULA);
        $c->addSelectColumn(Tbrh014ConceptoPeer::CO_MODO_CONCEPTO);
        $c->add(Tbrh014ConceptoPeer::CO_CONCEPTO, $tbrh061_nomina_movimientoForm["id_tbrh014_concepto"]);
        $stmt = Tbrh014ConceptoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $c2 = new Criteria();
        $c2->setIgnoreCase(true);
        $c2->clearSelectColumns();
        $c2->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA);
        $c2->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA);
        $c2->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH086_CONCEPTOS_FIJOS);
        //$c2->addSelectColumn(Tbrh013NominaPeer::CO_NOMINA);
        $c2->addSelectColumn(Tbrh013NominaPeer::CO_TP_NOMINA);
        $c2->addSelectColumn(Tbrh013NominaPeer::CO_GRUPO_NOMINA);
        $c2->addSelectColumn("sp_nu_lunes(".Tbrh013NominaPeer::FE_INICIO.", ".Tbrh013NominaPeer::FE_FIN.") as nu_lunes");
        $c2->addSelectColumn("date_part('year',age(".Tbrh001TrabajadorPeer::FE_NACIMIENTO.")) as nu_edad");
        $c2->addSelectColumn("sp_antiguedad_trabajador(".Tbrh002FichaPeer::FE_INGRESO.", ".Tbrh001TrabajadorPeer::NU_MES_RECONOCIDO.") as nu_antiguedad");
        $c2->addSelectColumn(Tbrh001TrabajadorPeer::CO_SEXO);
        $c2->addSelectColumn(Tbrh001TrabajadorPeer::NU_HIJO);
        $c2->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, Tbrh013NominaPeer::CO_NOMINA);
        $c2->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, Tbrh002FichaPeer::CO_FICHA);
        $c2->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
        $c2->add(Tbrh061NominaMovimientoPeer::ID, $codigo);
        $stmt2 = Tbrh061NominaMovimientoPeer::doSelectStmt($c2);
        $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        $valor = 0;
        $referencia = $tbrh061_nomina_movimientoForm["nu_valor"];
        $ficha = $campos2["id_tbrh002_ficha"];
        $modo_concepto = $campos["co_modo_concepto"];
        $nomina = $campos2["id_tbrh013_nomina"];
        $nu_lunes = $campos2["nu_lunes"];
        $tipo_nomina = $campos2["co_tp_nomina"];
        $grupo_nomina = $campos2["co_grupo_nomina"];
        $edad = $campos2["nu_edad"];
        $sexo = $campos2["co_sexo"];
        $cantidad_hijo = $campos2["nu_hijo"];
        $antiguedad = $campos2["nu_antiguedad"];

        //echo $nomina; exit();
    
        //****INVOCAR FUNCIONES Y VARIABLES PARA FORMULAS****//
        if($modo_concepto==1){

            if($campos["de_formula"]!= ""){

                //****INVOCAR FUNCIONES Y VARIABLES PARA FORMULAS****//
                //**************************************************//
                @eval($campos["de_formula"]);
    
                $tbrh061_nomina_movimiento->setNuMonto($valor);
    
            }

        }elseif($modo_concepto==2){

            $c3 = new Criteria();
            $c3->setIgnoreCase(true);
            $c3->clearSelectColumns();
            $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::CO_CONCEPTOS_FIJOS);
            $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::CO_NOM_TRABAJADOR);
            $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::NU_VALOR);
            $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::NU_MONTO);
            $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::MO_SALDO);
            $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::FE_MOVIMIENTO);
            $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::FE_VENCIMIENTO);
            $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::CO_EMBARGO);
            $c3->addSelectColumn(Tbrh014ConceptoPeer::DE_FORMULA);
            //$c3->addSelectColumn(Tbrh091TpFormulaPeer::DE_FORMULA);
            //$c3->addJoin(Tbrh086ConceptosFijosPeer::CO_TP_FORMULA, Tbrh091TpFormulaPeer::CO_TP_FORMULA);
            $c3->addJoin(Tbrh086ConceptosFijosPeer::CO_CONCEPTO_FORMULA, Tbrh014ConceptoPeer::CO_CONCEPTO, Criteria::LEFT_JOIN);
            $c3->add(Tbrh086ConceptosFijosPeer::CO_CONCEPTOS_FIJOS, $campos2["id_tbrh086_conceptos_fijos"]);
            $stmt3 = Tbrh086ConceptosFijosPeer::doSelectStmt($c3);
            $campos3 = $stmt3->fetch(PDO::FETCH_ASSOC);

            //$referencia = $campos3["nu_valor"];
            $cantidad = $tbrh061_nomina_movimientoForm["nu_valor"];
            $monto = $campos3["nu_monto"];
            $saldo = $campos3["mo_saldo"];

            if($campos3["de_formula"]!= ""){

                //****INVOCAR FUNCIONES Y VARIABLES PARA FORMULAS****//
                //**************************************************//
                @eval($campos3["de_formula"]);
    
                $tbrh061_nomina_movimiento->setNuMonto($valor);
    
            }

        }
                                                        
        /*Campo tipo NUMERIC */
        $tbrh061_nomina_movimiento->setNuMonto($tbrh061_nomina_movimientoForm["nu_monto"]);
                                                                                     
        /*CAMPOS*/
        $tbrh061_nomina_movimiento->save($con);
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
	$codigo = $this->getRequestParameter("id");
	$con = Propel::getConnection();
	try
	{ 
        $con->beginTransaction();
        /*CAMPOS*/
        $tbrh061_nomina_movimiento = Tbrh061NominaMovimientoPeer::retrieveByPk($codigo);			
        $tbrh061_nomina_movimiento->delete($con);

        $wherec2 = new Criteria();
        $wherec2->add(Tbrh062NominaMovimientoAcumulaPeer::ID_TBRH061_NOMINA_MOVIMIENTO, $codigo);
        BasePeer::doDelete($wherec2, $con);

        $this->data = json_encode(array(
            "success" => true,
            "msg" => 'Concepto Borrado con exito!'
        ));

        $con->commit();
	}catch (PropelException $e)
	{
	$con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
		    "msg" =>  $e->getMessage()
		    //"msg" => 'Este registro no se puede borrar porque <br>se encuentra asociado a otros registros'
		));
	}
  }

  public function executeEliminarCalculo(sfWebRequest $request)
  {
    $id_tbrh013_nomina = $this->getRequestParameter("id_tbrh013_nomina");
    $id_tbrh002_ficha = $this->getRequestParameter("id_tbrh002_ficha");
    $id_tbrh015_nom_trabajador = $this->getRequestParameter("id_tbrh015_nom_trabajador");
	$con = Propel::getConnection();
	try
	{ 
        $con->beginTransaction();
        /*CAMPOS*/

        $wherec1 = new Criteria();
        $wherec1->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $id_tbrh013_nomina);
        $wherec1->add(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, $id_tbrh002_ficha);
        $wherec1->add(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR, $id_tbrh015_nom_trabajador);
        BasePeer::doDelete($wherec1, $con);

        $this->data = json_encode(array(
            "success" => true,
            "msg" => 'Calculos Borrados con exito!'
        ));

        $con->commit();
	}catch (PropelException $e)
	{
	$con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
		    "msg" =>  $e->getMessage()
		    //"msg" => 'Este registro no se puede borrar porque <br>se encuentra asociado a otros registros'
		));
	}
  }

  public function executeLista(sfWebRequest $request)
  {

  }

  public function executeStorelistaImprimible(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);

    $id_tbrh013_nomina      =   $this->getRequestParameter("id_tbrh013_nomina");
    $id_tbrh002_ficha      =   $this->getRequestParameter("id_tbrh002_ficha");
    $id_tbrh015_nom_trabajador      =   $this->getRequestParameter("id_tbrh015_nom_trabajador");
    
    $c = new Criteria();   
    $c->setIgnoreCase(true);

    $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID);
    $c->addSelectColumn(Tbrh061NominaMovimientoPeer::DE_CONCEPTO);
    $c->addSelectColumn(Tbrh061NominaMovimientoPeer::NU_VALOR);
    $c->addSelectColumn(Tbrh061NominaMovimientoPeer::NU_MONTO);
    $c->addSelectColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
    $c->addSelectColumn(Tbrh050TpUnidadPeer::TX_TP_UNIDAD);
    $c->addSelectColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
    $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH086_CONCEPTOS_FIJOS);
    
    $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH014_CONCEPTO, Tbrh014ConceptoPeer::CO_CONCEPTO);
    $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH050_TP_UNIDAD, Tbrh050TpUnidadPeer::CO_TP_UNIDAD);
    $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH020_TP_CONCEPTO, Tbrh020TpConceptoPeer::CO_TP_CONCEPTO);

    $c->add(Tbrh061NominaMovimientoPeer::IN_IMPRIME_DETALLE, true);
    $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH020_TP_CONCEPTO, array( 4),  Criteria::NOT_IN);
    $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $id_tbrh013_nomina);
    $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, $id_tbrh002_ficha);
    $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR, $id_tbrh015_nom_trabajador);

    $cantidadTotal = Tbrh061NominaMovimientoPeer::doCount($c);
    
    $c->addAscendingOrderByColumn(Tbrh061NominaMovimientoPeer::ID);
    //$c->addAscendingOrderByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH020_TP_CONCEPTO);
    //$c->addAscendingOrderByColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
    //$c->addAscendingOrderByColumn('CAST('.Tbrh014ConceptoPeer::NU_CONCEPTO.' AS BIGINT)');

    $c->setLimit($limit)->setOffset($start);
        
    $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "id_tbrh013_nomina"     => trim($res["id_tbrh013_nomina"]),
            "id_tbrh014_concepto"     => trim($res["id_tbrh014_concepto"]),
            "id_tbrh020_tp_concepto"     => trim($res["tx_tp_concepto"]),
            "id_tbrh002_ficha"     => trim($res["id_tbrh002_ficha"]),
            "de_concepto"     => trim($res["de_concepto"]),
            "nu_valor"     => trim($res["nu_valor"]),
            "nu_monto"     => trim($res["nu_monto"]),
            "id_tbrh050_tp_unidad"     => trim($res["tx_tp_unidad"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "in_imprime_detalle"     => trim($res["in_imprime_detalle"]),
            "in_descripcion_alternativa"     => trim($res["in_descripcion_alternativa"]),
            "in_valor_referencia"     => trim($res["in_valor_referencia"]),
            "in_hoja_tiempo"     => trim($res["in_hoja_tiempo"]),
            "in_prorratea"     => trim($res["in_prorratea"]),
            "in_modifica_descripcion"     => trim($res["in_modifica_descripcion"]),
            "in_monto_calculo"     => trim($res["in_monto_calculo"]),
            "in_contractual"     => trim($res["in_contractual"]),
            "in_bonificable"     => trim($res["in_bonificable"]),
            "in_monto_cero"     => trim($res["in_monto_cero"]),
            "id_tbrh030_moneda"     => trim($res["id_tbrh030_moneda"]),
            "nu_concepto"     => trim($res["nu_concepto"]),
            "id_tbrh086_conceptos_fijos"     => trim($res["id_tbrh086_conceptos_fijos"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

    public function executeStorelistaNoImprimible(sfWebRequest $request)
    {
      $paginar    =   $this->getRequestParameter("paginar");
      $limit      =   $this->getRequestParameter("limit",20);
      $start      =   $this->getRequestParameter("start",0);
  
      $id_tbrh013_nomina      =   $this->getRequestParameter("id_tbrh013_nomina");
      $id_tbrh002_ficha      =   $this->getRequestParameter("id_tbrh002_ficha");
      $id_tbrh015_nom_trabajador      =   $this->getRequestParameter("id_tbrh015_nom_trabajador");
      
      $c = new Criteria();   
      $c->setIgnoreCase(true);
  
      $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID);
      $c->addSelectColumn(Tbrh061NominaMovimientoPeer::DE_CONCEPTO);
      $c->addSelectColumn(Tbrh061NominaMovimientoPeer::NU_VALOR);
      $c->addSelectColumn(Tbrh061NominaMovimientoPeer::NU_MONTO);
      $c->addSelectColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
      $c->addSelectColumn(Tbrh050TpUnidadPeer::TX_TP_UNIDAD);
      $c->addSelectColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
      
      $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH014_CONCEPTO, Tbrh014ConceptoPeer::CO_CONCEPTO);
      $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH050_TP_UNIDAD, Tbrh050TpUnidadPeer::CO_TP_UNIDAD);
      $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH020_TP_CONCEPTO, Tbrh020TpConceptoPeer::CO_TP_CONCEPTO);
  
      //$c->add(Tbrh061NominaMovimientoPeer::IN_IMPRIME_DETALLE, false);
      $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH020_TP_CONCEPTO, 4);
      $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $id_tbrh013_nomina);
      $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, $id_tbrh002_ficha);
      $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR, $id_tbrh015_nom_trabajador);
  
      $cantidadTotal = Tbrh061NominaMovimientoPeer::doCount($c);
      
      $c->addAscendingOrderByColumn(Tbrh061NominaMovimientoPeer::ID);
      //$c->addAscendingOrderByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH020_TP_CONCEPTO);
      //$c->addAscendingOrderByColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
      //$c->addAscendingOrderByColumn('CAST('.Tbrh014ConceptoPeer::NU_CONCEPTO.' AS BIGINT)');
  
      $c->setLimit($limit)->setOffset($start);
          
      $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);
      $registros = "";
      while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
      $registros[] = array(
              "id"     => trim($res["id"]),
              "id_tbrh013_nomina"     => trim($res["id_tbrh013_nomina"]),
              "id_tbrh014_concepto"     => trim($res["id_tbrh014_concepto"]),
              "id_tbrh020_tp_concepto"     => trim($res["tx_tp_concepto"]),
              "id_tbrh002_ficha"     => trim($res["id_tbrh002_ficha"]),
              "de_concepto"     => trim($res["de_concepto"]),
              "nu_valor"     => trim($res["nu_valor"]),
              "nu_monto"     => trim($res["nu_monto"]),
              "id_tbrh050_tp_unidad"     => trim($res["tx_tp_unidad"]),
              "in_activo"     => trim($res["in_activo"]),
              "created_at"     => trim($res["created_at"]),
              "updated_at"     => trim($res["updated_at"]),
              "in_imprime_detalle"     => trim($res["in_imprime_detalle"]),
              "in_descripcion_alternativa"     => trim($res["in_descripcion_alternativa"]),
              "in_valor_referencia"     => trim($res["in_valor_referencia"]),
              "in_hoja_tiempo"     => trim($res["in_hoja_tiempo"]),
              "in_prorratea"     => trim($res["in_prorratea"]),
              "in_modifica_descripcion"     => trim($res["in_modifica_descripcion"]),
              "in_monto_calculo"     => trim($res["in_monto_calculo"]),
              "in_contractual"     => trim($res["in_contractual"]),
              "in_bonificable"     => trim($res["in_bonificable"]),
              "in_monto_cero"     => trim($res["in_monto_cero"]),
              "id_tbrh030_moneda"     => trim($res["id_tbrh030_moneda"]),
              "nu_concepto"     => trim($res["nu_concepto"]),
          );
      }
  
      $this->data = json_encode(array(
          "success"   =>  true,
          "total"     =>  $cantidadTotal,
          "data"      =>  $registros
          ));
      }

    public function executeStorelistaTipo(sfWebRequest $request)
    {
        $paginar    =   $this->getRequestParameter("paginar");
        $limit      =   $this->getRequestParameter("limit",20);
        $start      =   $this->getRequestParameter("start",0);

        $id_tbrh013_nomina      =   $this->getRequestParameter("co_nomina");
        $id_tbrh067_grupo_nomina      =   $this->getRequestParameter("co_grupo_nomina");

        $c = new Criteria();   
        $c->setIgnoreCase(true);
        $c->addSelectColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
        $c->addSelectColumn('SUM('.Tbrh061NominaMovimientoPeer::NU_MONTO.') as nu_monto');
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH020_TP_CONCEPTO, Tbrh020TpConceptoPeer::CO_TP_CONCEPTO);

        $c->addAscendingOrderByColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA,$id_tbrh013_nomina);
        //$c->add(Tbrh061NominaMovimientoPeer::ID_TBRH067_GRUPO_NOMINA,$id_tbrh067_grupo_nomina);

        $c->addGroupByColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
          
        $cantidadTotal = Tbrh061NominaMovimientoPeer::doCount($c);
        $c->setLimit($limit)->setOffset($start);

        $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);
        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = array(
                "id"     => trim($res["id"]),
                "tx_tp_concepto"     => trim($res["tx_tp_concepto"]),
                "nu_monto"     => trim($res["nu_monto"]),
            );
        }
  
      $this->data = json_encode(array(
          "success"   =>  true,
          "total"     =>  $cantidadTotal,
          "data"      =>  $registros
          ));
      }    
      
      
      public function executeStorelistaTipoConcepto(sfWebRequest $request)
      {
          $paginar    =   $this->getRequestParameter("paginar");
          $limit      =   $this->getRequestParameter("limit",100);
          $start      =   $this->getRequestParameter("start",0);
  
          $id_tbrh013_nomina      =   $this->getRequestParameter("co_nomina");
          $id_tbrh067_grupo_nomina      =   $this->getRequestParameter("co_grupo_nomina");
  
          $c = new Criteria();   
          $c->setIgnoreCase(true);
          $c->addSelectColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
          $c->addSelectColumn(Tbrh014ConceptoPeer::TX_CONCEPTO);
          $c->addSelectColumn(Tbrh014ConceptoPeer::NU_CUENTA_PRESUPUESTO);
          $c->addSelectColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
          $c->addSelectColumn('SUM('.Tbrh061NominaMovimientoPeer::NU_MONTO.') as nu_monto');
          $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH014_CONCEPTO, Tbrh014ConceptoPeer::CO_CONCEPTO);
          $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH020_TP_CONCEPTO, Tbrh020TpConceptoPeer::CO_TP_CONCEPTO);
  
          $c->addAscendingOrderByColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
          $c->addAscendingOrderByColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
          $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA,$id_tbrh013_nomina);
          //$c->add(Tbrh061NominaMovimientoPeer::ID_TBRH067_GRUPO_NOMINA,$id_tbrh067_grupo_nomina);
  
          $c->addGroupByColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
          $c->addGroupByColumn(Tbrh014ConceptoPeer::TX_CONCEPTO);
          $c->addGroupByColumn(Tbrh014ConceptoPeer::NU_CUENTA_PRESUPUESTO);
          $c->addGroupByColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
            
          $cantidadTotal = Tbrh061NominaMovimientoPeer::doCount($c);
          $c->setLimit($limit)->setOffset($start);
  
          $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);
          $registros = "";
          while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
          $registros[] = array(
                  "id"     => trim($res["id"]),
                  "nu_concepto"     => trim($res["nu_concepto"]),
                  "tx_concepto"     => trim($res["tx_concepto"]),
                  "nu_cuenta_presupuesto"     => trim($res["nu_cuenta_presupuesto"]),
                  "tx_tp_concepto"     => trim($res["tx_tp_concepto"]),
                  "nu_monto"     => trim($res["nu_monto"]),
              );
          }
    
        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));
        }   


      public function executeStorelistaEmpleado(sfWebRequest $request)
      {
        $paginar    =   $this->getRequestParameter("paginar");
        $limit      =   $this->getRequestParameter("limit",20);
        $start      =   $this->getRequestParameter("start",0);

        $id_tbrh013_nomina      =   $this->getRequestParameter("co_nomina");
        $nu_cedula      =   $this->getRequestParameter("nu_cedula");
        $nb_trabajador      =   $this->getRequestParameter("nb_trabajador");

        $c = new Criteria();   
    
        if($this->getRequestParameter("BuscarBy")=="true"){

            if($nu_cedula!=""){$c->add(Tbrh001TrabajadorPeer::NU_CEDULA,$nu_cedula);}
    
            if($nb_trabajador!=""){$c->add(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE,'%'.$nb_trabajador.'%',Criteria::LIKE);}
            
        }

        $c->setIgnoreCase(true);
        $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $id_tbrh013_nomina);
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA);
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA);
        $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR);
        $c->addSelectColumn(Tbrh002FichaPeer::NU_FICHA);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
        $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
        $c->addSelectColumn(Tbrh032CargoPeer::TX_CARGO);
        $c->addSelectColumn(Tbrh024NomSituacionPeer::TX_NOM_SITUACION);
        $c->addAsColumn('mo_asignacion', 'sp_tbrh061_nomina_movimiento_mo_movimiento( tbrh061_nomina_movimiento.id_tbrh013_nomina, tbrh061_nomina_movimiento.id_tbrh002_ficha, tbrh061_nomina_movimiento.id_tbrh015_nom_trabajador, 1 )');
        $c->addAsColumn('mo_deduccion', 'sp_tbrh061_nomina_movimiento_mo_movimiento( tbrh061_nomina_movimiento.id_tbrh013_nomina, tbrh061_nomina_movimiento.id_tbrh002_ficha, tbrh061_nomina_movimiento.id_tbrh015_nom_trabajador, 2 )');
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, Tbrh002FichaPeer::CO_FICHA);
        $c->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
        $c->addJoin(Tbrh001TrabajadorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
        $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR, Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR);
        $c->addJoin(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA, Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA, Criteria::LEFT_JOIN);
        $c->addJoin(Tbrh009CargoEstructuraPeer::CO_CARGO, Tbrh032CargoPeer::CO_CARGO, Criteria::LEFT_JOIN);
        $c->addJoin(Tbrh002FichaPeer::CO_ESTATUS, Tbrh024NomSituacionPeer::CO_NOM_SITUACION, Criteria::LEFT_JOIN);
        $c->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA);
        $c->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA);
        $c->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR);
        $c->addGroupByColumn(Tbrh002FichaPeer::NU_FICHA);
        $c->addGroupByColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
        $c->addGroupByColumn(Tb007DocumentoPeer::INICIAL);
        $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
        $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
        $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
        $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
        $c->addGroupByColumn(Tbrh032CargoPeer::TX_CARGO);
        $c->addGroupByColumn(Tbrh024NomSituacionPeer::TX_NOM_SITUACION);
        $c->addAscendingOrderByColumn(Tbrh001TrabajadorPeer::NU_CEDULA);

        //$c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $id_tbrh013_nomina);

        $cantidadTotal = Tbrh061NominaMovimientoPeer::doCount($c);

        $c->setLimit($limit)->setOffset($start);
            
        $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);

        //echo $c->toString(); exit();

        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = array(
                "id_tbrh013_nomina"     => trim($res["id_tbrh013_nomina"]),
                "id_tbrh002_ficha"     => trim($res["id_tbrh002_ficha"]),
                "id_tbrh015_nom_trabajador"     => trim($res["id_tbrh015_nom_trabajador"]),
                "nu_ficha"     => trim($res["nu_ficha"]),
                "nu_cedula"     => trim($res["nu_cedula"]),
                "inicial"     => trim($res["inicial"]),
                "nombre"     => trim($res["nb_primer_nombre"].' '.$res["nb_segundo_nombre"].' '.$res["nb_primer_apellido"].' '.$res["nb_segundo_apellido"]),
                "mo_pago"     => trim($res["mo_asignacion"]-$res["mo_deduccion"]),
                "tx_cargo"     => trim($res["tx_cargo"]),
                "tx_nom_situacion"     => trim($res["tx_nom_situacion"]),
            );
        }
    
        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));
        }


        public function executeStorelistaEmpleadoSobregiro(sfWebRequest $request)
        {
          $paginar    =   $this->getRequestParameter("paginar");
          $limit      =   $this->getRequestParameter("limit",200);
          $start      =   $this->getRequestParameter("start",0);
  
          $id_tbrh013_nomina      =   $this->getRequestParameter("co_nomina");
          $nu_cedula      =   $this->getRequestParameter("nu_cedula");
          $nb_trabajador      =   $this->getRequestParameter("nb_trabajador");
  
          $c = new Criteria();   
      
          if($this->getRequestParameter("BuscarBy")=="true"){
  
              if($nu_cedula!=""){$c->add(Tbrh001TrabajadorPeer::NU_CEDULA,$nu_cedula);}
      
              if($nb_trabajador!=""){$c->add(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE,'%'.$nb_trabajador.'%',Criteria::LIKE);}
              
          }
  
          $c->setIgnoreCase(true);
          $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $id_tbrh013_nomina);
          $c->add(Tbrh061NominaMovimientoPeer::ID, "sp_tbrh061_nomina_movimiento_sobregiro( tbrh061_nomina_movimiento.id_tbrh013_nomina, tbrh061_nomina_movimiento.id_tbrh002_ficha, tbrh061_nomina_movimiento.id_tbrh015_nom_trabajador ) = true", Criteria::CUSTOM);
          $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA);
          $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA);
          $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR);
          $c->addSelectColumn(Tbrh002FichaPeer::NU_FICHA);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
          $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
          $c->addSelectColumn(Tbrh032CargoPeer::TX_CARGO);
          $c->addAsColumn('in_sobregiro', 'sp_tbrh061_nomina_movimiento_sobregiro( tbrh061_nomina_movimiento.id_tbrh013_nomina, tbrh061_nomina_movimiento.id_tbrh002_ficha, tbrh061_nomina_movimiento.id_tbrh015_nom_trabajador )');
          $c->addAsColumn('mo_asignacion', 'sp_tbrh061_nomina_movimiento_mo_movimiento( tbrh061_nomina_movimiento.id_tbrh013_nomina, tbrh061_nomina_movimiento.id_tbrh002_ficha, tbrh061_nomina_movimiento.id_tbrh015_nom_trabajador, 1 )');
          $c->addAsColumn('mo_deduccion', 'sp_tbrh061_nomina_movimiento_mo_movimiento( tbrh061_nomina_movimiento.id_tbrh013_nomina, tbrh061_nomina_movimiento.id_tbrh002_ficha, tbrh061_nomina_movimiento.id_tbrh015_nom_trabajador, 2 )');
          $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, Tbrh002FichaPeer::CO_FICHA);
          $c->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
          $c->addJoin(Tbrh001TrabajadorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
          $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR, Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR);
          $c->addJoin(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA, Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA, Criteria::LEFT_JOIN);
          $c->addJoin(Tbrh009CargoEstructuraPeer::CO_CARGO, Tbrh032CargoPeer::CO_CARGO, Criteria::LEFT_JOIN);
          $c->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA);
          $c->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA);
          $c->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR);
          $c->addGroupByColumn(Tbrh002FichaPeer::NU_FICHA);
          $c->addGroupByColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
          $c->addGroupByColumn(Tb007DocumentoPeer::INICIAL);
          $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
          $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
          $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
          $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
          $c->addGroupByColumn(Tbrh032CargoPeer::TX_CARGO);
          $c->addAscendingOrderByColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
  
          //$c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $id_tbrh013_nomina);
  
          $cantidadTotal = Tbrh061NominaMovimientoPeer::doCount($c);
  
          $c->setLimit($limit)->setOffset($start);
              
          $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);
  
          //echo $c->toString(); exit();
  
          $registros = "";
          while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
          $registros[] = array(
                  "id_tbrh013_nomina"     => trim($res["id_tbrh013_nomina"]),
                  "id_tbrh002_ficha"     => trim($res["id_tbrh002_ficha"]),
                  "id_tbrh015_nom_trabajador"     => trim($res["id_tbrh015_nom_trabajador"]),
                  "nu_ficha"     => trim($res["nu_ficha"]),
                  "nu_cedula"     => trim($res["nu_cedula"]),
                  "inicial"     => trim($res["inicial"]),
                  "nombre"     => trim($res["nb_primer_nombre"].' '.$res["nb_segundo_nombre"].' '.$res["nb_primer_apellido"].' '.$res["nb_segundo_apellido"]),
                  "mo_pago"     => trim($res["mo_asignacion"]-$res["mo_deduccion"]),
                  "tx_cargo"     => trim($res["tx_cargo"]),
              );
          }
      
          $this->data = json_encode(array(
              "success"   =>  true,
              "total"     =>  $cantidadTotal,
              "data"      =>  $registros
              ));
          }


          public function executeStorelistaEmpleadoSinCalculo(sfWebRequest $request)
          {
            $paginar    =   $this->getRequestParameter("paginar");
            $limit      =   $this->getRequestParameter("limit",200);
            $start      =   $this->getRequestParameter("start",0);

            $codigo = $this->getRequestParameter("co_nomina");
            $c2 = new Criteria();
            $c2->add(Tbrh013NominaPeer::CO_NOMINA,$codigo);
            $stmt2 = Tbrh013NominaPeer::doSelectStmt($c2);
            $campos = $stmt2->fetch(PDO::FETCH_ASSOC);
    
            $co_tp_nomina      =   $campos["co_tp_nomina"];
            $co_grupo_nomina      =   $campos["co_grupo_nomina"];
            $nu_cedula      =   $this->getRequestParameter("nu_cedula");
            $nb_trabajador      =   $this->getRequestParameter("nb_trabajador");

            $cr = new Criteria();
            $cr->clearSelectColumns();
            $cr->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR);
            $cr->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $codigo);
            $cr->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR);
            $cr->addAscendingOrderByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR);
            $stmtr = Tbrh061NominaMovimientoPeer::doSelectStmt($cr);
            $i=0;
            while($resr = $stmtr->fetch(PDO::FETCH_ASSOC)){
                $registros[$i] = $resr["id_tbrh015_nom_trabajador"];
                $i++;
            }
    
            $c = new Criteria();   
        
            if($this->getRequestParameter("BuscarBy")=="true"){
    
                if($nu_cedula!=""){$c->add(Tbrh001TrabajadorPeer::NU_CEDULA,$nu_cedula);}
        
                if($nb_trabajador!=""){$c->add(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE,'%'.$nb_trabajador.'%',Criteria::LIKE);}
                
            }
    
            $c->setIgnoreCase(true);
            $c->add(Tbrh015NomTrabajadorPeer::CO_TP_NOMINA, $co_tp_nomina);
            $c->add(Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA, $co_grupo_nomina);
            $c->add(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR, $registros, Criteria::NOT_IN);
            $c->add(Tbrh015NomTrabajadorPeer::IN_ACTIVO, TRUE);
            $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR);
            $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_FICHA);
            $c->addSelectColumn(Tbrh002FichaPeer::NU_FICHA);
            $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
            $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
            $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
            $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
            $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
            $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
            $c->addSelectColumn(Tbrh032CargoPeer::TX_CARGO);
            $c->addSelectColumn(Tbrh024NomSituacionPeer::TX_NOM_SITUACION);
            $c->addJoin(Tbrh015NomTrabajadorPeer::CO_FICHA, Tbrh002FichaPeer::CO_FICHA);
            $c->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
            $c->addJoin(Tbrh001TrabajadorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
            $c->addJoin(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA, Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA, Criteria::LEFT_JOIN);
            $c->addJoin(Tbrh009CargoEstructuraPeer::CO_CARGO, Tbrh032CargoPeer::CO_CARGO, Criteria::LEFT_JOIN);
            $c->addJoin(Tbrh002FichaPeer::CO_ESTATUS, Tbrh024NomSituacionPeer::CO_NOM_SITUACION, Criteria::LEFT_JOIN);
            $c->addAscendingOrderByColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
    
            $cantidadTotal = Tbrh015NomTrabajadorPeer::doCount($c);
    
            $c->setLimit($limit)->setOffset($start);
                
            $stmt = Tbrh015NomTrabajadorPeer::doSelectStmt($c);
    
            //echo $c->toString(); exit();
    
            $registros = "";
            while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = array(
                    "id_tbrh013_nomina"     => trim($codigo),
                    "id_tbrh002_ficha"     => trim($res["co_ficha"]),
                    "id_tbrh015_nom_trabajador"     => trim($res["co_nom_trabajador"]),
                    "nu_ficha"     => trim($res["nu_ficha"]),
                    "nu_cedula"     => trim($res["nu_cedula"]),
                    "inicial"     => trim($res["inicial"]),
                    "nombre"     => trim($res["nb_primer_nombre"].' '.$res["nb_segundo_nombre"].' '.$res["nb_primer_apellido"].' '.$res["nb_segundo_apellido"]),
                    "tx_cargo"     => trim($res["tx_cargo"]),
                    "tx_nom_situacion"     => trim($res["tx_nom_situacion"]),
                );
            }
        
            $this->data = json_encode(array(
                "success"   =>  true,
                "total"     =>  $cantidadTotal,
                "data"      =>  $registros
                ));
            }


        public function executeStorelistaEmpleadoCerrar(sfWebRequest $request)
        {
          $paginar    =   $this->getRequestParameter("paginar");
          $limit      =   $this->getRequestParameter("limit",20);
          $start      =   $this->getRequestParameter("start",0);
  
          $id_tbrh013_nomina      =   $this->getRequestParameter("co_nomina");
          $nu_cedula      =   $this->getRequestParameter("nu_cedula");
          $nb_trabajador      =   $this->getRequestParameter("nb_trabajador");
          
          $c = new Criteria();   
      
          if($this->getRequestParameter("BuscarBy")=="true"){
  
            if($nu_cedula!=""){$c->add(Tbrh001TrabajadorPeer::NU_CEDULA,$nu_cedula);}
      
            if($nb_trabajador!=""){$c->add(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE,'%'.$nb_trabajador.'%',Criteria::LIKE);}
                                          
          }
  
          $c->setIgnoreCase(true);
          $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $id_tbrh013_nomina);
          $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA);
          $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA);
          $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR);
          $c->addSelectColumn(Tbrh002FichaPeer::NU_FICHA);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
          $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
          $c->addAsColumn('mo_asignacion', 'sp_tbrh061_nomina_movimiento_mo_movimiento( tbrh061_nomina_movimiento.id_tbrh013_nomina, tbrh061_nomina_movimiento.id_tbrh002_ficha, tbrh061_nomina_movimiento.id_tbrh015_nom_trabajador, 1 )');
          $c->addAsColumn('mo_deduccion', 'sp_tbrh061_nomina_movimiento_mo_movimiento( tbrh061_nomina_movimiento.id_tbrh013_nomina, tbrh061_nomina_movimiento.id_tbrh002_ficha, tbrh061_nomina_movimiento.id_tbrh015_nom_trabajador, 2 )');
          $c->addAsColumn('mo_patronal', 'sp_tbrh061_nomina_movimiento_mo_movimiento( tbrh061_nomina_movimiento.id_tbrh013_nomina, tbrh061_nomina_movimiento.id_tbrh002_ficha, tbrh061_nomina_movimiento.id_tbrh015_nom_trabajador, 3 )');
          $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, Tbrh002FichaPeer::CO_FICHA);
          $c->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
          $c->addJoin(Tbrh001TrabajadorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
          $c->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA);
          $c->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA);
          $c->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR);
          $c->addGroupByColumn(Tbrh002FichaPeer::NU_FICHA);
          $c->addGroupByColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
          $c->addGroupByColumn(Tb007DocumentoPeer::INICIAL);
          $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
          $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
          $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
          $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
          $c->addAscendingOrderByColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
  
          //$c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $id_tbrh013_nomina);
  
          $cantidadTotal = Tbrh061NominaMovimientoPeer::doCount($c);
  
          $c->setLimit($limit)->setOffset($start);
              
          $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);
  
          //echo $c->toString(); exit();
  
          $registros = "";
          while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
          $registros[] = array(
                  "id_tbrh013_nomina"     => trim($res["id_tbrh013_nomina"]),
                  "id_tbrh002_ficha"     => trim($res["id_tbrh002_ficha"]),
                  "id_tbrh015_nom_trabajador"     => trim($res["id_tbrh015_nom_trabajador"]),
                  "nu_ficha"     => trim($res["nu_ficha"]),
                  "nu_cedula"     => trim($res["nu_cedula"]),
                  "inicial"     => trim($res["inicial"]),
                  "nombre"     => trim($res["nb_primer_nombre"].' '.$res["nb_segundo_nombre"].' '.$res["nb_primer_apellido"].' '.$res["nb_segundo_apellido"]),
                  "mo_pago"     => trim($res["mo_asignacion"]-$res["mo_deduccion"]),
                  "mo_asignacion"     => trim($res["mo_asignacion"]),
                  "mo_deduccion"     => trim($res["mo_deduccion"]),
                  "mo_patronal"     => trim($res["mo_patronal"]),
              );
          }
      
          $this->data = json_encode(array(
              "success"   =>  true,
              "total"     =>  $cantidadTotal,
              "data"      =>  $registros
              ));
          }

        public function executeNeto(sfWebRequest $request)
        {
            
          $paginar    =   $this->getRequestParameter("paginar");
          $limit      =   $this->getRequestParameter("limit",20);
          $start      =   $this->getRequestParameter("start",0);
  
          $id_tbrh013_nomina      =   $this->getRequestParameter("id_tbrh013_nomina");
          $id_tbrh002_ficha      =   $this->getRequestParameter("id_tbrh002_ficha");
          $id_tbrh015_nom_trabajador      =   $this->getRequestParameter("id_tbrh015_nom_trabajador");
          
          $c = new Criteria();   
  
          $c->setIgnoreCase(true);
          $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA);
          $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA);
          $c->addSelectColumn(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR);
          $c->addSelectColumn(Tbrh002FichaPeer::NU_FICHA);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
          $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
          $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
          $c->addAsColumn('mo_asignacion', 'sp_tbrh061_nomina_movimiento_mo_movimiento( tbrh061_nomina_movimiento.id_tbrh013_nomina, tbrh061_nomina_movimiento.id_tbrh002_ficha, tbrh061_nomina_movimiento.id_tbrh015_nom_trabajador, 1 )');
          $c->addAsColumn('mo_deduccion', 'sp_tbrh061_nomina_movimiento_mo_movimiento( tbrh061_nomina_movimiento.id_tbrh013_nomina, tbrh061_nomina_movimiento.id_tbrh002_ficha, tbrh061_nomina_movimiento.id_tbrh015_nom_trabajador, 2 )');
          $c->addJoin(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, Tbrh002FichaPeer::CO_FICHA);
          $c->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
          $c->addJoin(Tbrh001TrabajadorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
          $c->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA);
          $c->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA);
          $c->addGroupByColumn(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR);
          $c->addGroupByColumn(Tbrh002FichaPeer::NU_FICHA);
          $c->addGroupByColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
          $c->addGroupByColumn(Tb007DocumentoPeer::INICIAL);
          $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
          $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
          $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
          $c->addGroupByColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
          $c->addAscendingOrderByColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
  
          $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $id_tbrh013_nomina);
          $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, $id_tbrh002_ficha);
          $c->add(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR, $id_tbrh015_nom_trabajador);
  
          $c->setLimit($limit)->setOffset($start);
  
          $cantidadTotal = Tbrh061NominaMovimientoPeer::doCount($c);
              
          $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c);
  
          //echo $c->toString(); exit();
  
          $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->data = json_encode(
                array(
                    "data" => array(
                        "mo_asignacion"     => floatval($campos["mo_asignacion"]),
                        "mo_deduccion"     => floatval($campos["mo_deduccion"]),
                        "mo_neto"     => floatval($campos["mo_asignacion"]-$campos["mo_deduccion"]),
                    )
                )
            );
        
        }

        public function executeProcesarCalculo(sfWebRequest $request){

            $id_tbrh013_nomina = $this->getRequestParameter("id_tbrh013_nomina");
            $id_tbrh002_ficha = $this->getRequestParameter("id_tbrh002_ficha");
            $id_tbrh015_nom_trabajador = $this->getRequestParameter("id_tbrh015_nom_trabajador");
    
    echo "llego"; exit();
    
            $c = new Criteria();
            $c->setIgnoreCase(true);
            $c->clearSelectColumns();
            $c->addSelectColumn(Tbrh013NominaPeer::CO_NOMINA);
            $c->addSelectColumn(Tbrh013NominaPeer::CO_SOLICITUD);
            $c->addSelectColumn(Tbrh013NominaPeer::NU_NOMINA);
            $c->addSelectColumn(Tbrh013NominaPeer::FE_INICIO);
            $c->addSelectColumn(Tbrh013NominaPeer::FE_FIN);
            $c->addSelectColumn(Tbrh013NominaPeer::FE_PAGO);
            $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
            $c->addSelectColumn(Tbrh023NomFrecuenciaPagoPeer::TX_NOM_FRECUENCIA_PAGO);
            $c->addSelectColumn(Tbrh060NominaEstatusPeer::DE_NOMINA_ESTATUS);
            $c->addSelectColumn(Tbrh013NominaPeer::CO_TP_NOMINA);
            $c->addSelectColumn(Tbrh013NominaPeer::CO_NOM_FRECUENCIA_PAGO);
            $c->addSelectColumn(Tbrh013NominaPeer::CO_GRUPO_NOMINA);
            $c->addSelectColumn("sp_nu_lunes(".Tbrh013NominaPeer::FE_INICIO.", ".Tbrh013NominaPeer::FE_FIN.") as nu_lunes");
            $c->addJoin(Tbrh013NominaPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
            $c->addJoin(Tbrh013NominaPeer::CO_NOM_FRECUENCIA_PAGO, Tbrh023NomFrecuenciaPagoPeer::CO_NOM_FRECUENCIA_PAGO);
            $c->addJoin(Tbrh013NominaPeer::ID_TBRH060_NOMINA_ESTATUS, Tbrh060NominaEstatusPeer::ID);
            $c->add(Tbrh013NominaPeer::CO_NOMINA,$id_tbrh013_nomina);
            $c->addAscendingOrderByColumn(Tbrh013NominaPeer::CO_NOMINA);
            $stmt = Tbrh013NominaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $c2 = new Criteria();
            $c2->setIgnoreCase(true);
            $c2->clearSelectColumns();
            $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::TX_CONCEPTO);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::DE_FORMULA);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_MONEDA);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_TIPO_CONCEPTO);
            //$c2->addSelectColumn(Tbrh002FichaPeer::CO_FICHA);
            $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_FICHA);
            $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR);
            $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_NOM_SITUACION);
            $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::IN_CESTATICKET);
            $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::MO_SALARIO_NORMAL);
            $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA);
            $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::MO_SALARIO_ANTERIOR);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_TIPO_UNIDAD);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::NU_VALOR);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_IMPRIME_DETALLE);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_DESCRIPCION_ALTERNATIVA);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_VALOR_REFERENCIA);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_HOJA_TIEMPO);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_PRORRATEA);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_MODIFICA_DESCRIPCION);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_MONTO_CALCULO);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_CONTRACTUAL);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_BONIFICABLE);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_MONTO_CERO);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::NU_PRIORIDAD);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_MODO_CONCEPTO);
            $c2->addSelectColumn(Tbrh026ConcepTipoNominaPeer::CO_GRUPO_NOMINA);
            $c2->addSelectColumn("date_part('year',age(".Tbrh001TrabajadorPeer::FE_NACIMIENTO.")) as nu_edad");
            $c2->addSelectColumn("sp_antiguedad_trabajador(".Tbrh002FichaPeer::FE_INGRESO.", ".Tbrh001TrabajadorPeer::NU_MES_RECONOCIDO.") as nu_antiguedad");
            $c2->addSelectColumn("sp_antiguedad_trabajador_meses(".Tbrh002FichaPeer::FE_INGRESO.", ".Tbrh001TrabajadorPeer::NU_MES_RECONOCIDO.") as nu_mes_antiguedad");
            $c2->addSelectColumn("sp_nu_dias_egreso('".$campos['fe_inicio']."', ".Tbrh002FichaPeer::FE_FINIQUITO.") as nu_dias_egreso");
            $c2->addSelectColumn("sp_nu_dias_ingreso(".Tbrh002FichaPeer::FE_INGRESO.", '".$campos['fe_fin']."') as nu_dias_ingreso");
            $c2->addSelectColumn(Tbrh001TrabajadorPeer::CO_SEXO);
            $c2->addSelectColumn(Tbrh001TrabajadorPeer::NU_HIJO);
            $c2->addSelectColumn(Tbrh001TrabajadorPeer::CO_NIVEL_EDUCATIVO);
            $c2->addSelectColumn(Tbrh002FichaPeer::CO_ESTATUS);
            $c2->addJoin(Tbrh014ConceptoPeer::CO_CONCEPTO, Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO);
            $c2->addJoin(Tbrh014ConceptoPeer::CO_CONCEPTO, Tbrh051ConcepFrecueciaPeer::CO_CONCEPTO);
            $c2->addJoin(Tbrh014ConceptoPeer::CO_CONCEPTO, Tbrh027ConceptoSituacionPeer::CO_CONCEPTO);
            $c2->addJoin(Tbrh014ConceptoPeer::CO_CONCEPTO, Tbrh085ConceptoTipoCargoPeer::CO_CONCEPTO);
            //*************ASOCIACION DE TABLAS CON TRABAJADOR****************//
            $c2->addJoin(Tbrh026ConcepTipoNominaPeer::CO_TP_NOMINA, Tbrh015NomTrabajadorPeer::CO_TP_NOMINA);
            $c2->addJoin(Tbrh026ConcepTipoNominaPeer::CO_GRUPO_NOMINA, Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA);
            $c2->addJoin(Tbrh085ConceptoTipoCargoPeer::CO_TP_CARGO, Tbrh015NomTrabajadorPeer::CO_TP_CARGO);
            $c2->addJoin(Tbrh015NomTrabajadorPeer::CO_FICHA, Tbrh002FichaPeer::CO_FICHA);
            $c2->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
            $c2->addJoin(Tbrh027ConceptoSituacionPeer::CO_SITUACION, Tbrh002FichaPeer::CO_ESTATUS);
            //****************************************************************//
            $c2->add(Tbrh026ConcepTipoNominaPeer::CO_TP_NOMINA, $campos["co_tp_nomina"]);
            $c2->add(Tbrh026ConcepTipoNominaPeer::CO_GRUPO_NOMINA, $campos["co_grupo_nomina"]);
            $c2->add(Tbrh051ConcepFrecueciaPeer::CO_NOM_FRECUENCIA_PAGO, $campos["co_nom_frecuencia_pago"]);
            $c2->add(Tbrh015NomTrabajadorPeer::CO_FICHA, $id_tbrh002_ficha);
            $c2->add(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR, $id_tbrh015_nom_trabajador);
            $c2->add(Tbrh014ConceptoPeer::IN_ACTIVO, TRUE);
            $c2->add(Tbrh015NomTrabajadorPeer::IN_ACTIVO, TRUE);
            //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_MODO_CONCEPTO);
            //$c2->addAscendingOrderByColumn(Tbrh015NomTrabajadorPeer::CO_FICHA);
            //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::NU_PRIORIDAD);
            //$c2->addAscendingOrderByColumn('CAST('.Tbrh014ConceptoPeer::NU_CONCEPTO.' AS BIGINT)');
            //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_TIPO_CONCEPTO);
            $c2->addAscendingOrderByColumn(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA);
            $c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::NU_PRIORIDAD);
            //$c2->addAscendingOrderByColumn('CAST('.Tbrh014ConceptoPeer::NU_CONCEPTO.' AS BIGINT)');
            //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_MODO_CONCEPTO);
            //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_TIPO_CONCEPTO);
            //$c2->addAscendingOrderByColumn('CAST('.Tbrh014ConceptoPeer::NU_CONCEPTO.' AS BIGINT)');
            //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
            //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
            $stmt2 = Tbrh014ConceptoPeer::doSelectStmt($c2);

            //var_dump($stmt2);
    
            $con = Propel::getConnection();
            try{ 
                $con->beginTransaction();
    
                $wherec = new Criteria();
                $wherec->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $id_tbrh013_nomina);
                $wherec->add(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, $id_tbrh002_ficha);
                $wherec->add(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR, $id_tbrh015_nom_trabajador);
                BasePeer::doDelete($wherec, $con);

                $wherec2 = new Criteria();
                $wherec2->add(Tbrh062NominaMovimientoAcumulaPeer::ID_TBRH013_NOMINA, $id_tbrh013_nomina);
                $wherec2->add(Tbrh062NominaMovimientoAcumulaPeer::ID_TBRH002_FICHA, $id_tbrh002_ficha);
                BasePeer::doDelete($wherec2, $con);

                $con->commit();
    
            $registros = "";
            while($res = $stmt2->fetch(PDO::FETCH_ASSOC)){
    
                $valor = 0;
                $referencia = $res["nu_valor"];
                $ficha = $res["co_ficha"];
                $modo_concepto = $res["co_modo_concepto"];
                $nomina = $campos["co_nomina"];
                $nu_lunes = $campos["nu_lunes"];
                $tipo_nomina = $campos["co_tp_nomina"];
                $grupo_nomina = $campos["co_grupo_nomina"];
                $edad = $res["nu_edad"];
                $sexo = $res["co_sexo"];
                $cantidad_hijo = $res["nu_hijo"];
                $antiguedad = $res["nu_antiguedad"];
                $nivel_educativo = $res["co_nivel_educativo"];
                $fecha_inicio = $campos["fe_inicio"];
                $fecha_cierre = $campos["fe_fin"];
                $concepto = $res["nu_concepto"];
                $nom_trabajador = $res["co_nom_trabajador"];
                $in_cestaticket = $res["in_cestaticket"];
                $mes_antiguedad = $res["nu_mes_antiguedad"];
                $situacion = $res["co_nom_situacion"];
                $dias_egreso = $res["nu_dias_egreso"];
                $dias_ingreso = $res["nu_dias_ingreso"];
                $mo_salario_normal = $res["mo_salario_normal"];
                $cargo_estructura = $res["co_cargo_estructura"];
                $mo_salario_anterior = $res["mo_salario_anterior"];
    
                //echo $mo_salario_base; exit();
                //****INVOCAR FUNCIONES Y VARIABLES PARA FORMULAS****//
                //****MODO DIRECTO********//
                if($modo_concepto==1){

                    if($res["de_formula"]!= ""){
                        //****INVOCAR FUNCIONES Y VARIABLES PARA FORMULAS****//
                        //$mo_salario_base = Tbrh015NomTrabajadorPeer::moSalarioBase( $ficha, $tipo_nomina, $grupo_nomina );
                        //$valor_concepto = Tbrh061NominaMovimiento::concepto( $concepto, $ficha, $nomina);
        
    
                        //**************************************************//
                        
                        @eval($res["de_formula"]);
    
                        if($res["in_monto_cero"]==true){
                            if($valor<=0){
                                continue;
                            }
                        }
        
                            $tbrh061_nomina_movimiento = new Tbrh061NominaMovimiento();
                            $tbrh061_nomina_movimiento->setIdTbrh013Nomina($campos["co_nomina"]);
                            $tbrh061_nomina_movimiento->setIdTbrh014Concepto($res["co_concepto"]);
                            $tbrh061_nomina_movimiento->setIdTbrh020TpConcepto($res["co_tipo_concepto"]);
                            $tbrh061_nomina_movimiento->setIdTbrh002Ficha($res["co_ficha"]);
                            $tbrh061_nomina_movimiento->setDeConcepto($res["tx_concepto"]);
                            $tbrh061_nomina_movimiento->setNuValor($referencia);
                            $tbrh061_nomina_movimiento->setNuMonto($valor);
                            $tbrh061_nomina_movimiento->setIdTbrh050TpUnidad($res["co_tipo_unidad"]);
                            $tbrh061_nomina_movimiento->setInImprimeDetalle($res["in_imprime_detalle"]);
                            $tbrh061_nomina_movimiento->setInDescripcionAlternativa($res["in_descripcion_alternativa"]);
                            $tbrh061_nomina_movimiento->setInValorReferencia($res["in_valor_referencia"]);
                            $tbrh061_nomina_movimiento->setInHojaTiempo($res["in_hoja_tiempo"]);
                            $tbrh061_nomina_movimiento->setInProrratea($res["in_prorratea"]);
                            $tbrh061_nomina_movimiento->setInModificaDescripcion($res["in_modifica_descripcion"]);
                            $tbrh061_nomina_movimiento->setInMontoCalculo($res["in_monto_calculo"]);
                            $tbrh061_nomina_movimiento->setInContractual($res["in_contractual"]);
                            $tbrh061_nomina_movimiento->setInBonificable($res["in_bonificable"]);
                            $tbrh061_nomina_movimiento->setInMontoCero($res["in_monto_cero"]);
                            $tbrh061_nomina_movimiento->setIdTbrh030Moneda($res["co_moneda"]);
                            $tbrh061_nomina_movimiento->setIdTbrh015NomTrabajador($res["co_nom_trabajador"]);
                            $tbrh061_nomina_movimiento->setNuPrioridad($res["nu_prioridad"]);
                            $tbrh061_nomina_movimiento->save($con);
    
                            $c3 = new Criteria();
                            $c3->setIgnoreCase(true);
                            $c3->clearSelectColumns();
                            $c3->addSelectColumn(Tbrh034ConcepAcumuladoPeer::CO_CONCEPTO);
                            $c3->addSelectColumn(Tbrh034ConcepAcumuladoPeer::CO_NOM_ACUMULADO);
                            $c3->add(Tbrh034ConcepAcumuladoPeer::CO_CONCEPTO, $res["co_concepto"]);
                            $c3->addAscendingOrderByColumn(Tbrh034ConcepAcumuladoPeer::CO_NOM_ACUMULADO);
                            $stmt3 = Tbrh034ConcepAcumuladoPeer::doSelectStmt($c3);
        
                            while($res2 = $stmt3->fetch(PDO::FETCH_ASSOC)){
        
                                $tbrh062_nomina_movimiento_acumula = new Tbrh062NominaMovimientoAcumula();
                                $tbrh062_nomina_movimiento_acumula->setIdTbrh061NominaMovimiento($tbrh061_nomina_movimiento->getId());
                                $tbrh062_nomina_movimiento_acumula->setIdTbrh021NomAcumulado($res2["co_nom_acumulado"]);
                                $tbrh062_nomina_movimiento_acumula->setIdTbrh013Nomina($campos["co_nomina"]);
                                $tbrh062_nomina_movimiento_acumula->setIdTbrh002Ficha($res["co_ficha"]);
                                $tbrh062_nomina_movimiento_acumula->save($con);
        
                            }
        
                            $con->commit();
                        
                    }

                }elseif($modo_concepto==2){
                //****MODO MULTIPLE****//
                
                    $c3 = new Criteria();
                    $c3->setIgnoreCase(true);
                    $c3->clearSelectColumns();
                    $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::CO_CONCEPTOS_FIJOS);
                    $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::NU_VALOR);
                    $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::NU_MONTO);
                    $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::MO_SALDO);
                    $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::FE_MOVIMIENTO);
                    $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::FE_VENCIMIENTO);
                    $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::CO_EMBARGO);
                    $c3->addSelectColumn(Tbrh014ConceptoPeer::DE_FORMULA);
                    $c3->addSelectColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
                    $c3->addSelectColumn(Tbrh014ConceptoPeer::NU_PRIORIDAD);
                    $c3->addSelectColumn(Tbrh014ConceptoPeer::NU_VALOR." as nu_referencia");
                    //$c3->addSelectColumn(Tbrh091TpFormulaPeer::DE_FORMULA);
                    //$c3->addJoin(Tbrh086ConceptosFijosPeer::CO_TP_FORMULA, Tbrh091TpFormulaPeer::CO_TP_FORMULA);
                    //$c3->addJoin(Tbrh086ConceptosFijosPeer::CO_CONCEPTO_FORMULA, Tbrh014ConceptoPeer::CO_CONCEPTO, Criteria::LEFT_JOIN);
                    $c3->addJoin(Tbrh086ConceptosFijosPeer::CO_CONCEPTO_FORMULA, Tbrh014ConceptoPeer::CO_CONCEPTO);
                    //$c3->addJoin(Tbrh086ConceptosFijosPeer::CO_FICHA, Tbrh015NomTrabajadorPeer::CO_FICHA);
                    //$c3->add(Tbrh086ConceptosFijosPeer::CO_NOM_TRABAJADOR,$res["co_nom_trabajador"]);
                    $c3->add(Tbrh086ConceptosFijosPeer::CO_FICHA, $res["co_ficha"]);
                    $c3->add(Tbrh086ConceptosFijosPeer::TX_CODIGO_CONCEPTO, $res["nu_concepto"]);
                    $c3->add(Tbrh086ConceptosFijosPeer::IN_ACTIVO, TRUE);
                    $c3->addAscendingOrderByColumn(Tbrh086ConceptosFijosPeer::CO_CONCEPTOS_FIJOS);
                    $stmt3 = Tbrh086ConceptosFijosPeer::doSelectStmt($c3);

                    $cantidad = 0;
                    $monto = 0;
                    $saldo = 0;

                    while($res2 = $stmt3->fetch(PDO::FETCH_ASSOC)){

                        $referencia = $res2["nu_referencia"];
                        $cantidad = $res2["nu_valor"];
                        $monto = $res2["nu_monto"];
                        $saldo = $res2["mo_saldo"];

                        if($res2["de_formula"]!= ""){

                            @eval($res2["de_formula"]);
    
                            if($res["in_monto_cero"]==true){
                                if($valor<=0){
                                    continue;
                                }
                            }

                            //echo $referencia; exit();

                            $tbrh061_nomina_movimiento = new Tbrh061NominaMovimiento();
                            $tbrh061_nomina_movimiento->setIdTbrh013Nomina($campos["co_nomina"]);
                            $tbrh061_nomina_movimiento->setIdTbrh014Concepto($res2["co_concepto"]);
                            $tbrh061_nomina_movimiento->setIdTbrh020TpConcepto($res["co_tipo_concepto"]);
                            $tbrh061_nomina_movimiento->setIdTbrh002Ficha($res["co_ficha"]);
                            $tbrh061_nomina_movimiento->setDeConcepto($res["tx_concepto"]);
                            $tbrh061_nomina_movimiento->setNuValor($referencia);
                            $tbrh061_nomina_movimiento->setNuMonto($valor);
                            $tbrh061_nomina_movimiento->setIdTbrh050TpUnidad($res["co_tipo_unidad"]);
                            $tbrh061_nomina_movimiento->setInImprimeDetalle($res["in_imprime_detalle"]);
                            $tbrh061_nomina_movimiento->setInDescripcionAlternativa($res["in_descripcion_alternativa"]);
                            $tbrh061_nomina_movimiento->setInValorReferencia($res["in_valor_referencia"]);
                            $tbrh061_nomina_movimiento->setInHojaTiempo($res["in_hoja_tiempo"]);
                            $tbrh061_nomina_movimiento->setInProrratea($res["in_prorratea"]);
                            $tbrh061_nomina_movimiento->setInModificaDescripcion($res["in_modifica_descripcion"]);
                            $tbrh061_nomina_movimiento->setInMontoCalculo($res["in_monto_calculo"]);
                            $tbrh061_nomina_movimiento->setInContractual($res["in_contractual"]);
                            $tbrh061_nomina_movimiento->setInBonificable($res["in_bonificable"]);
                            $tbrh061_nomina_movimiento->setInMontoCero($res["in_monto_cero"]);
                            $tbrh061_nomina_movimiento->setIdTbrh030Moneda($res["co_moneda"]);
                            $tbrh061_nomina_movimiento->setIdTbrh015NomTrabajador($res["co_nom_trabajador"]);
                            $tbrh061_nomina_movimiento->setIdTbrh086ConceptosFijos($res2["co_conceptos_fijos"]);
                            $tbrh061_nomina_movimiento->setNuPrioridad($res2["nu_prioridad"]);
                            $tbrh061_nomina_movimiento->save($con);

                            $con->commit();

                        }

                    }

                }
    
            }
    
                    $this->data = json_encode(array(
                        "success" => true,
                        "msg" => 'Nomina procesada exitosamente',
                        //"data"      =>  $registros
                    ));
    
                }catch (PropelException $e){
    
                    $con->rollback();
    
                    $this->data = json_encode(array(
                        "success" => false,
                        "msg" =>  $e->getMessage()
                    ));
    
                }
    
            $this->setTemplate('store');
    
        }


        public function executeRecalcularConcepto(sfWebRequest $request){

            $arreglo = $this->getRequestParameter("arreglo");
      
            $listaArreglo  = json_decode($arreglo,true);

            foreach($listaArreglo as $arregloForm){

            $id_tbrh013_nomina = $arregloForm['id_tbrh013_nomina'];
            $id_tbrh002_ficha = $arregloForm['id_tbrh002_ficha'];
            $id_tbrh015_nom_trabajador = $arregloForm['id_tbrh015_nom_trabajador'];
    
            $c = new Criteria();
            $c->setIgnoreCase(true);
            $c->clearSelectColumns();
            $c->addSelectColumn(Tbrh013NominaPeer::CO_NOMINA);
            $c->addSelectColumn(Tbrh013NominaPeer::CO_SOLICITUD);
            $c->addSelectColumn(Tbrh013NominaPeer::NU_NOMINA);
            $c->addSelectColumn(Tbrh013NominaPeer::FE_INICIO);
            $c->addSelectColumn(Tbrh013NominaPeer::FE_FIN);
            $c->addSelectColumn(Tbrh013NominaPeer::FE_PAGO);
            $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
            $c->addSelectColumn(Tbrh023NomFrecuenciaPagoPeer::TX_NOM_FRECUENCIA_PAGO);
            $c->addSelectColumn(Tbrh060NominaEstatusPeer::DE_NOMINA_ESTATUS);
            $c->addSelectColumn(Tbrh013NominaPeer::CO_TP_NOMINA);
            $c->addSelectColumn(Tbrh013NominaPeer::CO_NOM_FRECUENCIA_PAGO);
            $c->addSelectColumn(Tbrh013NominaPeer::CO_GRUPO_NOMINA);
            $c->addSelectColumn("sp_nu_lunes(".Tbrh013NominaPeer::FE_INICIO.", ".Tbrh013NominaPeer::FE_FIN.") as nu_lunes");
            $c->addJoin(Tbrh013NominaPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
            $c->addJoin(Tbrh013NominaPeer::CO_NOM_FRECUENCIA_PAGO, Tbrh023NomFrecuenciaPagoPeer::CO_NOM_FRECUENCIA_PAGO);
            $c->addJoin(Tbrh013NominaPeer::ID_TBRH060_NOMINA_ESTATUS, Tbrh060NominaEstatusPeer::ID);
            $c->add(Tbrh013NominaPeer::CO_NOMINA,$id_tbrh013_nomina);
            $c->addAscendingOrderByColumn(Tbrh013NominaPeer::CO_NOMINA);
            $stmt = Tbrh013NominaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $c2 = new Criteria();
            $c2->setIgnoreCase(true);
            $c2->clearSelectColumns();
            $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::TX_CONCEPTO);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::DE_FORMULA);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_MONEDA);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_TIPO_CONCEPTO);
            //$c2->addSelectColumn(Tbrh002FichaPeer::CO_FICHA);
            $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_FICHA);
            $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR);
            $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::IN_CESTATICKET);
            $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::MO_SALARIO_NORMAL);
            $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_CARGO_ESTRUCTURA);
            $c2->addSelectColumn(Tbrh015NomTrabajadorPeer::MO_SALARIO_ANTERIOR);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_TIPO_UNIDAD);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::NU_VALOR);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_IMPRIME_DETALLE);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_DESCRIPCION_ALTERNATIVA);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_VALOR_REFERENCIA);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_HOJA_TIEMPO);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_PRORRATEA);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_MODIFICA_DESCRIPCION);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_MONTO_CALCULO);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_CONTRACTUAL);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_BONIFICABLE);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_MONTO_CERO);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::NU_PRIORIDAD);
            $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_MODO_CONCEPTO);
            $c2->addSelectColumn(Tbrh026ConcepTipoNominaPeer::CO_GRUPO_NOMINA);
            $c2->addSelectColumn("date_part('year',age(".Tbrh001TrabajadorPeer::FE_NACIMIENTO.")) as nu_edad");
            $c2->addSelectColumn("sp_antiguedad_trabajador(".Tbrh002FichaPeer::FE_INGRESO.", ".Tbrh001TrabajadorPeer::NU_MES_RECONOCIDO.") as nu_antiguedad");
            $c2->addSelectColumn("sp_antiguedad_trabajador_meses(".Tbrh002FichaPeer::FE_INGRESO.", ".Tbrh001TrabajadorPeer::NU_MES_RECONOCIDO.") as nu_mes_antiguedad");
            $c2->addSelectColumn("sp_nu_dias_egreso('".$campos['fe_inicio']."', ".Tbrh002FichaPeer::FE_FINIQUITO.") as nu_dias_egreso");
            $c2->addSelectColumn("sp_nu_dias_ingreso(".Tbrh002FichaPeer::FE_INGRESO.", '".$campos['fe_fin']."') as nu_dias_ingreso");
            $c2->addSelectColumn(Tbrh001TrabajadorPeer::CO_SEXO);
            $c2->addSelectColumn(Tbrh001TrabajadorPeer::NU_HIJO);
            $c2->addSelectColumn(Tbrh001TrabajadorPeer::CO_NIVEL_EDUCATIVO);
            $c2->addSelectColumn(Tbrh002FichaPeer::CO_ESTATUS);
            $c2->addJoin(Tbrh014ConceptoPeer::CO_CONCEPTO, Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO);
            $c2->addJoin(Tbrh014ConceptoPeer::CO_CONCEPTO, Tbrh051ConcepFrecueciaPeer::CO_CONCEPTO);
            $c2->addJoin(Tbrh014ConceptoPeer::CO_CONCEPTO, Tbrh027ConceptoSituacionPeer::CO_CONCEPTO);
            $c2->addJoin(Tbrh014ConceptoPeer::CO_CONCEPTO, Tbrh085ConceptoTipoCargoPeer::CO_CONCEPTO);
            //*************ASOCIACION DE TABLAS CON TRABAJADOR****************//
            $c2->addJoin(Tbrh026ConcepTipoNominaPeer::CO_TP_NOMINA, Tbrh015NomTrabajadorPeer::CO_TP_NOMINA);
            $c2->addJoin(Tbrh026ConcepTipoNominaPeer::CO_GRUPO_NOMINA, Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA);
            $c2->addJoin(Tbrh085ConceptoTipoCargoPeer::CO_TP_CARGO, Tbrh015NomTrabajadorPeer::CO_TP_CARGO);
            $c2->addJoin(Tbrh015NomTrabajadorPeer::CO_FICHA, Tbrh002FichaPeer::CO_FICHA);
            $c2->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
            $c2->addJoin(Tbrh027ConceptoSituacionPeer::CO_SITUACION, Tbrh002FichaPeer::CO_ESTATUS);
            //****************************************************************//
            $c2->add(Tbrh026ConcepTipoNominaPeer::CO_TP_NOMINA, $campos["co_tp_nomina"]);
            $c2->add(Tbrh026ConcepTipoNominaPeer::CO_GRUPO_NOMINA, $campos["co_grupo_nomina"]);
            $c2->add(Tbrh051ConcepFrecueciaPeer::CO_NOM_FRECUENCIA_PAGO, $campos["co_nom_frecuencia_pago"]);
            $c2->add(Tbrh015NomTrabajadorPeer::CO_FICHA, $id_tbrh002_ficha);
            $c2->add(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR, $id_tbrh015_nom_trabajador);
            $c2->add(Tbrh014ConceptoPeer::IN_ACTIVO, TRUE);
            $c2->add(Tbrh015NomTrabajadorPeer::IN_ACTIVO, TRUE);
            //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_MODO_CONCEPTO);
            //$c2->addAscendingOrderByColumn(Tbrh015NomTrabajadorPeer::CO_FICHA);
            //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::NU_PRIORIDAD);
            //$c2->addAscendingOrderByColumn('CAST('.Tbrh014ConceptoPeer::NU_CONCEPTO.' AS BIGINT)');
            //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_TIPO_CONCEPTO);
            $c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::NU_PRIORIDAD);
            //$c2->addAscendingOrderByColumn('CAST('.Tbrh014ConceptoPeer::NU_CONCEPTO.' AS BIGINT)');
            //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_MODO_CONCEPTO);
            //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_TIPO_CONCEPTO);
            //$c2->addAscendingOrderByColumn('CAST('.Tbrh014ConceptoPeer::NU_CONCEPTO.' AS BIGINT)');
            //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
            //$c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
            $stmt2 = Tbrh014ConceptoPeer::doSelectStmt($c2);
    
            $con = Propel::getConnection();
            try{ 
                $con->beginTransaction();
    
                $wherec = new Criteria();
                $wherec->add(Tbrh061NominaMovimientoPeer::ID_TBRH013_NOMINA, $id_tbrh013_nomina);
                $wherec->add(Tbrh061NominaMovimientoPeer::ID_TBRH002_FICHA, $id_tbrh002_ficha);
                $wherec->add(Tbrh061NominaMovimientoPeer::ID_TBRH015_NOM_TRABAJADOR, $id_tbrh015_nom_trabajador);
                BasePeer::doDelete($wherec, $con);

                $wherec2 = new Criteria();
                $wherec2->add(Tbrh062NominaMovimientoAcumulaPeer::ID_TBRH013_NOMINA, $id_tbrh013_nomina);
                $wherec2->add(Tbrh062NominaMovimientoAcumulaPeer::ID_TBRH002_FICHA, $id_tbrh002_ficha);
                BasePeer::doDelete($wherec2, $con);

                $con->commit();
    
            $registros = "";
            while($res = $stmt2->fetch(PDO::FETCH_ASSOC)){
    
                $valor = 0;
                $referencia = $res["nu_valor"];
                $ficha = $res["co_ficha"];
                $modo_concepto = $res["co_modo_concepto"];
                $nomina = $campos["co_nomina"];
                $nu_lunes = $campos["nu_lunes"];
                $tipo_nomina = $campos["co_tp_nomina"];
                $grupo_nomina = $campos["co_grupo_nomina"];
                $edad = $res["nu_edad"];
                $sexo = $res["co_sexo"];
                $cantidad_hijo = $res["nu_hijo"];
                $antiguedad = $res["nu_antiguedad"];
                $nivel_educativo = $res["co_nivel_educativo"];
                $fecha_inicio = $campos["fe_inicio"];
                $fecha_cierre = $campos["fe_fin"];
                $concepto = $res["nu_concepto"];
                $nom_trabajador = $res["co_nom_trabajador"];
                $in_cestaticket = $res["in_cestaticket"];
                $mes_antiguedad = $res["nu_mes_antiguedad"];
                $situacion = $res["co_estatus"];
                $dias_egreso = $res["nu_dias_egreso"];
                $dias_ingreso = $res["nu_dias_ingreso"];
                $mo_salario_normal = $res["mo_salario_normal"];
                $cargo_estructura = $res["co_cargo_estructura"];
                $mo_salario_anterior = $res["mo_salario_anterior"];
    
                //echo $mo_salario_base; exit();
                //****INVOCAR FUNCIONES Y VARIABLES PARA FORMULAS****//
                //****MODO DIRECTO********//
                if($modo_concepto==1){

                    if($res["de_formula"]!= ""){
                        //****INVOCAR FUNCIONES Y VARIABLES PARA FORMULAS****//
                        //$mo_salario_base = Tbrh015NomTrabajadorPeer::moSalarioBase( $ficha, $tipo_nomina, $grupo_nomina );
                        //$valor_concepto = Tbrh061NominaMovimiento::concepto( $concepto, $ficha, $nomina);
        
    
                        //**************************************************//
                        
                        @eval($res["de_formula"]);
    
                        if($res["in_monto_cero"]==true){
                            if($valor<=0){
                                continue;
                            }
                        }
        
                            $tbrh061_nomina_movimiento = new Tbrh061NominaMovimiento();
                            $tbrh061_nomina_movimiento->setIdTbrh013Nomina($campos["co_nomina"]);
                            $tbrh061_nomina_movimiento->setIdTbrh014Concepto($res["co_concepto"]);
                            $tbrh061_nomina_movimiento->setIdTbrh020TpConcepto($res["co_tipo_concepto"]);
                            $tbrh061_nomina_movimiento->setIdTbrh002Ficha($res["co_ficha"]);
                            $tbrh061_nomina_movimiento->setDeConcepto($res["tx_concepto"]);
                            $tbrh061_nomina_movimiento->setNuValor($referencia);
                            $tbrh061_nomina_movimiento->setNuMonto($valor);
                            $tbrh061_nomina_movimiento->setIdTbrh050TpUnidad($res["co_tipo_unidad"]);
                            $tbrh061_nomina_movimiento->setInImprimeDetalle($res["in_imprime_detalle"]);
                            $tbrh061_nomina_movimiento->setInDescripcionAlternativa($res["in_descripcion_alternativa"]);
                            $tbrh061_nomina_movimiento->setInValorReferencia($res["in_valor_referencia"]);
                            $tbrh061_nomina_movimiento->setInHojaTiempo($res["in_hoja_tiempo"]);
                            $tbrh061_nomina_movimiento->setInProrratea($res["in_prorratea"]);
                            $tbrh061_nomina_movimiento->setInModificaDescripcion($res["in_modifica_descripcion"]);
                            $tbrh061_nomina_movimiento->setInMontoCalculo($res["in_monto_calculo"]);
                            $tbrh061_nomina_movimiento->setInContractual($res["in_contractual"]);
                            $tbrh061_nomina_movimiento->setInBonificable($res["in_bonificable"]);
                            $tbrh061_nomina_movimiento->setInMontoCero($res["in_monto_cero"]);
                            $tbrh061_nomina_movimiento->setIdTbrh030Moneda($res["co_moneda"]);
                            $tbrh061_nomina_movimiento->setIdTbrh015NomTrabajador($res["co_nom_trabajador"]);
                            $tbrh061_nomina_movimiento->setNuPrioridad($res["nu_prioridad"]);
                            $tbrh061_nomina_movimiento->save($con);
    
                            $c3 = new Criteria();
                            $c3->setIgnoreCase(true);
                            $c3->clearSelectColumns();
                            $c3->addSelectColumn(Tbrh034ConcepAcumuladoPeer::CO_CONCEPTO);
                            $c3->addSelectColumn(Tbrh034ConcepAcumuladoPeer::CO_NOM_ACUMULADO);
                            $c3->add(Tbrh034ConcepAcumuladoPeer::CO_CONCEPTO, $res["co_concepto"]);
                            $c3->addAscendingOrderByColumn(Tbrh034ConcepAcumuladoPeer::CO_NOM_ACUMULADO);
                            $stmt3 = Tbrh034ConcepAcumuladoPeer::doSelectStmt($c3);
        
                            while($res2 = $stmt3->fetch(PDO::FETCH_ASSOC)){
        
                                $tbrh062_nomina_movimiento_acumula = new Tbrh062NominaMovimientoAcumula();
                                $tbrh062_nomina_movimiento_acumula->setIdTbrh061NominaMovimiento($tbrh061_nomina_movimiento->getId());
                                $tbrh062_nomina_movimiento_acumula->setIdTbrh021NomAcumulado($res2["co_nom_acumulado"]);
                                $tbrh062_nomina_movimiento_acumula->setIdTbrh013Nomina($campos["co_nomina"]);
                                $tbrh062_nomina_movimiento_acumula->setIdTbrh002Ficha($res["co_ficha"]);
                                $tbrh062_nomina_movimiento_acumula->save($con);
        
                            }
        
                            $con->commit();
                        
                    }

                }elseif($modo_concepto==2){
                //****MODO MULTIPLE****//
                
                    $c3 = new Criteria();
                    $c3->setIgnoreCase(true);
                    $c3->clearSelectColumns();
                    $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::CO_CONCEPTOS_FIJOS);
                    $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::NU_VALOR);
                    $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::NU_MONTO);
                    $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::MO_SALDO);
                    $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::FE_MOVIMIENTO);
                    $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::FE_VENCIMIENTO);
                    $c3->addSelectColumn(Tbrh086ConceptosFijosPeer::CO_EMBARGO);
                    $c3->addSelectColumn(Tbrh014ConceptoPeer::DE_FORMULA);
                    $c3->addSelectColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
                    $c3->addSelectColumn(Tbrh014ConceptoPeer::NU_PRIORIDAD);
                    $c3->addSelectColumn(Tbrh014ConceptoPeer::NU_VALOR." as nu_referencia");
                    //$c3->addSelectColumn(Tbrh091TpFormulaPeer::DE_FORMULA);
                    //$c3->addJoin(Tbrh086ConceptosFijosPeer::CO_TP_FORMULA, Tbrh091TpFormulaPeer::CO_TP_FORMULA);
                    //$c3->addJoin(Tbrh086ConceptosFijosPeer::CO_CONCEPTO_FORMULA, Tbrh014ConceptoPeer::CO_CONCEPTO, Criteria::LEFT_JOIN);
                    $c3->addJoin(Tbrh086ConceptosFijosPeer::CO_CONCEPTO_FORMULA, Tbrh014ConceptoPeer::CO_CONCEPTO);
                    //$c3->addJoin(Tbrh086ConceptosFijosPeer::CO_FICHA, Tbrh015NomTrabajadorPeer::CO_FICHA);
                    //$c3->add(Tbrh086ConceptosFijosPeer::CO_NOM_TRABAJADOR,$res["co_nom_trabajador"]);
                    $c3->add(Tbrh086ConceptosFijosPeer::CO_FICHA, $res["co_ficha"]);
                    $c3->add(Tbrh086ConceptosFijosPeer::TX_CODIGO_CONCEPTO, $res["nu_concepto"]);
                    $c3->add(Tbrh086ConceptosFijosPeer::IN_ACTIVO, TRUE);
                    $c3->addAscendingOrderByColumn(Tbrh086ConceptosFijosPeer::CO_CONCEPTOS_FIJOS);
                    $stmt3 = Tbrh086ConceptosFijosPeer::doSelectStmt($c3);

                    $cantidad = 0;
                    $monto = 0;
                    $saldo = 0;

                    while($res2 = $stmt3->fetch(PDO::FETCH_ASSOC)){

                        $referencia = $res2["nu_referencia"];
                        $cantidad = $res2["nu_valor"];
                        $monto = $res2["nu_monto"];
                        $saldo = $res2["mo_saldo"];

                        if($res2["de_formula"]!= ""){

                            @eval($res2["de_formula"]);
    
                            if($res["in_monto_cero"]==true){
                                if($valor<=0){
                                    continue;
                                }
                            }

                            $tbrh061_nomina_movimiento = new Tbrh061NominaMovimiento();
                            $tbrh061_nomina_movimiento->setIdTbrh013Nomina($campos["co_nomina"]);
                            $tbrh061_nomina_movimiento->setIdTbrh014Concepto($res2["co_concepto"]);
                            $tbrh061_nomina_movimiento->setIdTbrh020TpConcepto($res["co_tipo_concepto"]);
                            $tbrh061_nomina_movimiento->setIdTbrh002Ficha($res["co_ficha"]);
                            $tbrh061_nomina_movimiento->setDeConcepto($res["tx_concepto"]);
                            $tbrh061_nomina_movimiento->setNuValor($referencia);
                            $tbrh061_nomina_movimiento->setNuMonto($valor);
                            $tbrh061_nomina_movimiento->setIdTbrh050TpUnidad($res["co_tipo_unidad"]);
                            $tbrh061_nomina_movimiento->setInImprimeDetalle($res["in_imprime_detalle"]);
                            $tbrh061_nomina_movimiento->setInDescripcionAlternativa($res["in_descripcion_alternativa"]);
                            $tbrh061_nomina_movimiento->setInValorReferencia($res["in_valor_referencia"]);
                            $tbrh061_nomina_movimiento->setInHojaTiempo($res["in_hoja_tiempo"]);
                            $tbrh061_nomina_movimiento->setInProrratea($res["in_prorratea"]);
                            $tbrh061_nomina_movimiento->setInModificaDescripcion($res["in_modifica_descripcion"]);
                            $tbrh061_nomina_movimiento->setInMontoCalculo($res["in_monto_calculo"]);
                            $tbrh061_nomina_movimiento->setInContractual($res["in_contractual"]);
                            $tbrh061_nomina_movimiento->setInBonificable($res["in_bonificable"]);
                            $tbrh061_nomina_movimiento->setInMontoCero($res["in_monto_cero"]);
                            $tbrh061_nomina_movimiento->setIdTbrh030Moneda($res["co_moneda"]);
                            $tbrh061_nomina_movimiento->setIdTbrh015NomTrabajador($res["co_nom_trabajador"]);
                            $tbrh061_nomina_movimiento->setIdTbrh086ConceptosFijos($res2["co_conceptos_fijos"]);
                            $tbrh061_nomina_movimiento->setNuPrioridad($res2["nu_prioridad"]);
                            $tbrh061_nomina_movimiento->save($con);

                            $con->commit();

                        }

                    }

                }
    
                /*$registros[] = array(
                    "nu_concepto"     => trim($res["nu_concepto"]),
                    "tx_concepto"     => trim($res["tx_concepto"]),
                    "de_formula"     => $res["de_formula"],
                    "valor"     => $valor,
                );*/
            }

                    $tbrh013_nomina = Tbrh013NominaPeer::retrieveByPk($id_tbrh013_nomina);
                    $tbrh013_nomina->setInProcesado(true);
                    $tbrh013_nomina->setIdTbrh060NominaEstatus(2);
                    $tbrh013_nomina->save($con);

                    $con->commit();
    
                    $this->data = json_encode(array(
                        "success" => true,
                        "msg" => 'Conceptos calculados Exitosamente!',
                        //"data"      =>  $registros
                    ));
    
                }catch (PropelException $e){
    
                    $con->rollback();
    
                    $this->data = json_encode(array(
                        "success" => false,
                        "msg" =>  $e->getMessage()
                    ));
    
                }

            }
    
            $this->setTemplate('store');
    
        }


        public function executeStorelistaAgregar(sfWebRequest $request)
        {
          $paginar    =   $this->getRequestParameter("paginar");
          $limit      =   $this->getRequestParameter("limit",200);
          $start      =   $this->getRequestParameter("start",0);
      
          $id_tbrh013_nomina      =   $this->getRequestParameter("id_tbrh013_nomina");
          $id_tbrh002_ficha      =   $this->getRequestParameter("id_tbrh002_ficha");
          $id_tbrh015_nom_trabajador      =   $this->getRequestParameter("id_tbrh015_nom_trabajador");

          $c = new Criteria();
          $c->setIgnoreCase(true);
          $c->clearSelectColumns();
          $c->addSelectColumn(Tbrh013NominaPeer::CO_NOMINA);
          $c->addSelectColumn(Tbrh013NominaPeer::CO_SOLICITUD);
          $c->addSelectColumn(Tbrh013NominaPeer::NU_NOMINA);
          $c->addSelectColumn(Tbrh013NominaPeer::FE_INICIO);
          $c->addSelectColumn(Tbrh013NominaPeer::FE_FIN);
          $c->addSelectColumn(Tbrh013NominaPeer::FE_PAGO);
          $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
          $c->addSelectColumn(Tbrh023NomFrecuenciaPagoPeer::TX_NOM_FRECUENCIA_PAGO);
          $c->addSelectColumn(Tbrh060NominaEstatusPeer::DE_NOMINA_ESTATUS);
          $c->addSelectColumn(Tbrh013NominaPeer::CO_TP_NOMINA);
          $c->addSelectColumn(Tbrh013NominaPeer::CO_NOM_FRECUENCIA_PAGO);
          $c->addSelectColumn(Tbrh013NominaPeer::CO_GRUPO_NOMINA);
          $c->addJoin(Tbrh013NominaPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
          $c->addJoin(Tbrh013NominaPeer::CO_NOM_FRECUENCIA_PAGO, Tbrh023NomFrecuenciaPagoPeer::CO_NOM_FRECUENCIA_PAGO);
          $c->addJoin(Tbrh013NominaPeer::ID_TBRH060_NOMINA_ESTATUS, Tbrh060NominaEstatusPeer::ID);
          $c->add(Tbrh013NominaPeer::CO_NOMINA,$id_tbrh013_nomina);
          $c->addAscendingOrderByColumn(Tbrh013NominaPeer::CO_NOMINA);
          $stmt = Tbrh013NominaPeer::doSelectStmt($c);
          $campos = $stmt->fetch(PDO::FETCH_ASSOC);

          $subSelect = "tbrh014_concepto.co_concepto NOT IN (SELECT id_tbrh014_concepto
          FROM public.tbrh061_nomina_movimiento
          WHERE id_tbrh013_nomina = ".$id_tbrh013_nomina." AND 
          id_tbrh002_ficha = ".$id_tbrh002_ficha." AND
          id_tbrh015_nom_trabajador = ".$id_tbrh015_nom_trabajador." 
          GROUP BY 1
          )";
          
          $c2 = new Criteria();   
          $c2->setIgnoreCase(true);
      
          $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
          $c2->addSelectColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
          $c2->addSelectColumn(Tbrh014ConceptoPeer::TX_CONCEPTO);
          $c2->addSelectColumn(Tbrh050TpUnidadPeer::TX_TP_UNIDAD);
          $c2->addSelectColumn(Tbrh020TpConceptoPeer::TX_TP_CONCEPTO);
          
          $c2->addJoin(Tbrh014ConceptoPeer::CO_TIPO_UNIDAD, Tbrh050TpUnidadPeer::CO_TP_UNIDAD);
          $c2->addJoin(Tbrh014ConceptoPeer::CO_TIPO_CONCEPTO, Tbrh020TpConceptoPeer::CO_TP_CONCEPTO);
          $c2->addJoin(Tbrh014ConceptoPeer::CO_CONCEPTO, Tbrh026ConcepTipoNominaPeer::CO_CONCEPTO);
          $c2->addJoin(Tbrh014ConceptoPeer::CO_CONCEPTO, Tbrh051ConcepFrecueciaPeer::CO_CONCEPTO);
          $c2->addJoin(Tbrh014ConceptoPeer::CO_CONCEPTO, Tbrh027ConceptoSituacionPeer::CO_CONCEPTO);
            //$c2->addJoin(Tbrh027ConceptoSituacionPeer::CO_SITUACION, Tbrh002FichaPeer::CO_ESTATUS);
            //$c2->addJoin(Tbrh026ConcepTipoNominaPeer::CO_TP_NOMINA, Tbrh002FichaPeer::ID_TBRH017_TP_NOMINA);
            //*************ASOCIACION DE TABLAS CON TRABAJADOR****************//
            $c2->addJoin(Tbrh026ConcepTipoNominaPeer::CO_TP_NOMINA, Tbrh015NomTrabajadorPeer::CO_TP_NOMINA);
            $c2->addJoin(Tbrh026ConcepTipoNominaPeer::CO_GRUPO_NOMINA, Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA);
            $c2->addJoin(Tbrh015NomTrabajadorPeer::CO_FICHA, Tbrh002FichaPeer::CO_FICHA);
            $c2->addJoin(Tbrh027ConceptoSituacionPeer::CO_SITUACION, Tbrh002FichaPeer::CO_ESTATUS);
            //****************************************************************//

          $c2->add(Tbrh014ConceptoPeer::CO_CONCEPTO, $subSelect, Criteria::CUSTOM);
          $c2->add(Tbrh026ConcepTipoNominaPeer::CO_TP_NOMINA, $campos["co_tp_nomina"]);
          $c2->add(Tbrh026ConcepTipoNominaPeer::CO_GRUPO_NOMINA, $campos["co_grupo_nomina"]);
          $c2->add(Tbrh051ConcepFrecueciaPeer::CO_NOM_FRECUENCIA_PAGO, $campos["co_nom_frecuencia_pago"]);
          $c2->add(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR, $id_tbrh015_nom_trabajador);
          $c2->add(Tbrh014ConceptoPeer::IN_ACTIVO, TRUE);
      
          $cantidadTotal = Tbrh061NominaMovimientoPeer::doCount($c2);
          
          //$c->addAscendingOrderByColumn(Tbrh061NominaMovimientoPeer::ID);
          $c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_TIPO_CONCEPTO);
          $c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
      
          $c2->setLimit($limit)->setOffset($start);
              
          $stmt = Tbrh061NominaMovimientoPeer::doSelectStmt($c2);
          $registros = "";
          while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
          $registros[] = array(
                  "id"     => trim($res["co_concepto"]),
                  "id_tbrh020_tp_concepto"     => trim($res["tx_tp_concepto"]),
                  "de_concepto"     => trim($res["tx_concepto"]),
                  "nu_valor"     => trim($res["nu_valor"]),
                  "nu_monto"     => trim($res["nu_monto"]),
                  "id_tbrh050_tp_unidad"     => trim($res["tx_tp_unidad"]),
                  "nu_concepto"     => trim($res["nu_concepto"]),
              );
          }
      
          $this->data = json_encode(array(
              "success"   =>  true,
              "total"     =>  $cantidadTotal,
              "data"      =>  $registros
              ));
          }


          public function executeGuardarNuevo(sfWebRequest $request)
          {
        
            $id_tbrh013_nomina = $this->getRequestParameter("id_tbrh013_nomina");
            $id_tbrh002_ficha = $this->getRequestParameter("id_tbrh002_ficha");
            $id_tbrh015_nom_trabajador = $this->getRequestParameter("id_tbrh015_nom_trabajador");
            $json_concepto = $this->getRequestParameter("json_concepto");

            $listaConcepto  = json_decode($json_concepto,true);

            //var_dump($listaConcepto);
            //exit();

            $con = Propel::getConnection();
            try{ 
                $con->beginTransaction();

                /*$c = new Criteria();
                $c->setIgnoreCase(true);
                $c->clearSelectColumns();
                $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR);
                $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_TP_NOMINA);
                $c->addSelectColumn(Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA);
                $c->add(Tbrh015NomTrabajadorPeer::CO_NOM_TRABAJADOR, $id_tbrh015_nom_trabajador);
                $stmt = Tbrh015NomTrabajadorPeer::doSelectStmt($c);
                $campos = $stmt->fetch(PDO::FETCH_ASSOC);*/

                $c = new Criteria();
                $c->setIgnoreCase(true);
                $c->clearSelectColumns();
                $c->addSelectColumn(Tbrh013NominaPeer::CO_NOMINA);
                $c->addSelectColumn(Tbrh013NominaPeer::CO_SOLICITUD);
                $c->addSelectColumn(Tbrh013NominaPeer::NU_NOMINA);
                $c->addSelectColumn(Tbrh013NominaPeer::FE_INICIO);
                $c->addSelectColumn(Tbrh013NominaPeer::FE_FIN);
                $c->addSelectColumn(Tbrh013NominaPeer::FE_PAGO);
                $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
                $c->addSelectColumn(Tbrh023NomFrecuenciaPagoPeer::TX_NOM_FRECUENCIA_PAGO);
                $c->addSelectColumn(Tbrh060NominaEstatusPeer::DE_NOMINA_ESTATUS);
                $c->addSelectColumn(Tbrh013NominaPeer::CO_TP_NOMINA);
                $c->addSelectColumn(Tbrh013NominaPeer::CO_NOM_FRECUENCIA_PAGO);
                $c->addSelectColumn(Tbrh013NominaPeer::CO_GRUPO_NOMINA);
                $c->addSelectColumn("sp_nu_lunes(".Tbrh013NominaPeer::FE_INICIO.", ".Tbrh013NominaPeer::FE_FIN.") as nu_lunes");
                $c->addJoin(Tbrh013NominaPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
                $c->addJoin(Tbrh013NominaPeer::CO_NOM_FRECUENCIA_PAGO, Tbrh023NomFrecuenciaPagoPeer::CO_NOM_FRECUENCIA_PAGO);
                $c->addJoin(Tbrh013NominaPeer::ID_TBRH060_NOMINA_ESTATUS, Tbrh060NominaEstatusPeer::ID);
                $c->add(Tbrh013NominaPeer::CO_NOMINA, $id_tbrh013_nomina);
                $c->addAscendingOrderByColumn(Tbrh013NominaPeer::CO_NOMINA);
                $stmt = Tbrh013NominaPeer::doSelectStmt($c);
                $campos = $stmt->fetch(PDO::FETCH_ASSOC);

                $c4 = new Criteria();
                $c4->setIgnoreCase(true);
                $c4->clearSelectColumns();
                $c4->addSelectColumn("date_part('year',age(".Tbrh001TrabajadorPeer::FE_NACIMIENTO.")) as nu_edad");
                $c4->addSelectColumn("sp_antiguedad_trabajador(".Tbrh002FichaPeer::FE_INGRESO.", ".Tbrh001TrabajadorPeer::NU_MES_RECONOCIDO.") as nu_antiguedad");
                $c4->addSelectColumn(Tbrh001TrabajadorPeer::CO_SEXO);
                $c4->addSelectColumn(Tbrh001TrabajadorPeer::NU_HIJO);
                $c4->addJoin(Tbrh002FichaPeer::CO_TRABAJADOR, Tbrh001TrabajadorPeer::CO_TRABAJADOR);
                $c4->add(Tbrh002FichaPeer::CO_FICHA, $id_tbrh002_ficha);
                $stmt4 = Tbrh002FichaPeer::doSelectStmt($c4);
                $campos4 = $stmt4->fetch(PDO::FETCH_ASSOC);

            foreach($listaConcepto as $conceptoForm){

                $c2 = new Criteria();
                $c2->setIgnoreCase(true);
                $c2->clearSelectColumns();
                $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::NU_CONCEPTO);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::TX_CONCEPTO);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::DE_FORMULA);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_MONEDA);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_TIPO_CONCEPTO);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_TIPO_UNIDAD);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_IMPRIME_DETALLE);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_DESCRIPCION_ALTERNATIVA);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_VALOR_REFERENCIA);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_HOJA_TIEMPO);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_PRORRATEA);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_MODIFICA_DESCRIPCION);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_MONTO_CALCULO);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_CONTRACTUAL);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_BONIFICABLE);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::IN_MONTO_CERO);
                $c2->addSelectColumn(Tbrh014ConceptoPeer::CO_MODO_CONCEPTO);
                $c2->add(Tbrh014ConceptoPeer::CO_CONCEPTO, $conceptoForm["id"]);
                $c2->addAscendingOrderByColumn(Tbrh014ConceptoPeer::CO_CONCEPTO);
                $stmt2 = Tbrh014ConceptoPeer::doSelectStmt($c2);

                while($res = $stmt2->fetch(PDO::FETCH_ASSOC)){

                    $valor = 0;
                    $referencia = $conceptoForm["nu_valor"];
                    $ficha = $id_tbrh002_ficha;
                    $modo_concepto = $res["co_modo_concepto"];
                    $nomina = $id_tbrh013_nomina;
                    $nu_lunes = $campos["nu_lunes"];
                    $tipo_nomina = $campos["co_tp_nomina"];
                    $grupo_nomina = $campos["co_grupo_nomina"];
                    $edad = $campos4["nu_edad"];
                    $sexo = $campos4["co_sexo"];
                    $cantidad_hijo = $campos4["nu_hijo"];
                    $antiguedad = $campos4["nu_antiguedad"];
        
                    //****INVOCAR FUNCIONES Y VARIABLES PARA FORMULAS****//
        
                    if($res["de_formula"]!= ""){

                        //****INVOCAR FUNCIONES Y VARIABLES PARA FORMULAS****//
                        //$mo_salario_base = Tbrh015NomTrabajadorPeer::moSalarioBase( $res["co_ficha"], $campos["co_tp_nomina"], $campos["co_grupo_nomina"] );


                        //**************************************************//
        
                        @eval($res["de_formula"]);
    
                        if($res["in_monto_cero"]==true){
                            if($valor<=0){
                                continue;
                            }
                        }

                        $tbrh061_nomina_movimiento = new Tbrh061NominaMovimiento();
                        $tbrh061_nomina_movimiento->setIdTbrh013Nomina($id_tbrh013_nomina);
                        $tbrh061_nomina_movimiento->setIdTbrh014Concepto($res["co_concepto"]);
                        $tbrh061_nomina_movimiento->setIdTbrh020TpConcepto($res["co_tipo_concepto"]);
                        $tbrh061_nomina_movimiento->setIdTbrh002Ficha($id_tbrh002_ficha);
                        $tbrh061_nomina_movimiento->setDeConcepto($res["tx_concepto"]);
                        $tbrh061_nomina_movimiento->setNuValor($referencia);
                        $tbrh061_nomina_movimiento->setNuMonto($valor);
                        $tbrh061_nomina_movimiento->setIdTbrh050TpUnidad($res["co_tipo_unidad"]);
                        $tbrh061_nomina_movimiento->setInImprimeDetalle($res["in_imprime_detalle"]);
                        $tbrh061_nomina_movimiento->setInDescripcionAlternativa($res["in_descripcion_alternativa"]);
                        $tbrh061_nomina_movimiento->setInValorReferencia($res["in_valor_referencia"]);
                        $tbrh061_nomina_movimiento->setInHojaTiempo($res["in_hoja_tiempo"]);
                        $tbrh061_nomina_movimiento->setInProrratea($res["in_prorratea"]);
                        $tbrh061_nomina_movimiento->setInModificaDescripcion($res["in_modifica_descripcion"]);
                        $tbrh061_nomina_movimiento->setInMontoCalculo($res["in_monto_calculo"]);
                        $tbrh061_nomina_movimiento->setInContractual($res["in_contractual"]);
                        $tbrh061_nomina_movimiento->setInBonificable($res["in_bonificable"]);
                        $tbrh061_nomina_movimiento->setInMontoCero($res["in_monto_cero"]);
                        $tbrh061_nomina_movimiento->setIdTbrh030Moneda($res["co_moneda"]);
                        $tbrh061_nomina_movimiento->setIdTbrh015NomTrabajador($id_tbrh015_nom_trabajador);
                        $tbrh061_nomina_movimiento->save($con);

                        $con->commit();

                        $c3 = new Criteria();
                        $c3->setIgnoreCase(true);
                        $c3->clearSelectColumns();
                        $c3->addSelectColumn(Tbrh034ConcepAcumuladoPeer::CO_CONCEPTO);
                        $c3->addSelectColumn(Tbrh034ConcepAcumuladoPeer::CO_NOM_ACUMULADO);
                        $c3->add(Tbrh034ConcepAcumuladoPeer::CO_CONCEPTO, $res["co_concepto"]);
                        $c3->addAscendingOrderByColumn(Tbrh034ConcepAcumuladoPeer::CO_NOM_ACUMULADO);
                        $stmt3 = Tbrh034ConcepAcumuladoPeer::doSelectStmt($c3);
    
                        while($res2 = $stmt3->fetch(PDO::FETCH_ASSOC)){
    
                            $tbrh062_nomina_movimiento_acumula = new Tbrh062NominaMovimientoAcumula();
                            $tbrh062_nomina_movimiento_acumula->setIdTbrh061NominaMovimiento($tbrh061_nomina_movimiento->getId());
                            $tbrh062_nomina_movimiento_acumula->setIdTbrh021NomAcumulado($res2["co_nom_acumulado"]);
                            $tbrh062_nomina_movimiento_acumula->setIdTbrh013Nomina($id_tbrh013_nomina);
                            $tbrh062_nomina_movimiento_acumula->setIdTbrh002Ficha($id_tbrh002_ficha);
                            $tbrh062_nomina_movimiento_acumula->save($con);
    
                        }
                    }
                }
            }

                $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Conceptos agregados con exito!',
                    "concepto" => $referencia
                ));

                $con->commit();

            }catch (PropelException $e){

                $con->rollback();

                $this->data = json_encode(array(
                    "success" => false,
                    "msg" =>  $e->getMessage()
                ));

            }

        }

}