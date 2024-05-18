<?php

/**
 * Ubicacion actions.
 *
 * @package    gobel
 * @subpackage Ubicacion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class UbicacionActions extends sfActions
{
public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Ubicacion', 'lista');
  }


  public function executeLista(sfWebRequest $request)
  {

  }

  
  public function executeGuardar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("co_organigrama");
    $con = Propel::getConnection();
    if($codigo!=''||$codigo!=null){
      $tbbn006_organigrama = Tbbn006OrganigramaPeer::retrieveByPk($codigo);
      try {
        $con->beginTransaction();
        $tbbn006_organigrama->setTxOrganigrama(strtoupper($this->getRequestParameter("tx_organigrama")));
        $tbbn006_organigrama->setCoParroquia(strtoupper($this->getRequestParameter("co_parroquia")));
        $tbbn006_organigrama->setTxSector(strtoupper($this->getRequestParameter("tx_sector")));
        $tbbn006_organigrama->setTxCalle(strtoupper($this->getRequestParameter("tx_calle")));
        $tbbn006_organigrama->setTxAvenida(strtoupper($this->getRequestParameter("tx_avenida")));
        $tbbn006_organigrama->setTxpuntoReferencia(strtoupper($this->getRequestParameter("tx_punto_referencia")));
        $tbbn006_organigrama->setInActivo(strtoupper($this->getRequestParameter("in_activo")));
        $tbbn006_organigrama->save($con);
        
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente'
                ));
       $con->commit();
      } catch (PropelException $e) {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage()
        ));
      }

      
    }else{
      $this->data = json_encode(array(
        "success" => false,
        "msg" =>  'Datos vacios'
    ));
    }

  }

  public function executeNuevo(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("co_organigrama");
    $con = Propel::getConnection();
    if($codigo!=''||$codigo!=null){
      $organigrama = Tbbn006OrganigramaPeer::retrieveByPk($codigo);
      $nu_nivel=$organigrama->getNuNivel()+1;
      $cod_cia=$organigrama->getCodCia();
      //$cod_adm_padre=substr($organigrama,strlen(Tbbn006OrganigramaPeer::getUltAdmEspe($codigo))+1,100);
      $cod_adm= substr(Tbbn006OrganigramaPeer::getUltAdmEspe($codigo),strlen($organigrama->getCodAdm()),100)+1;
      $o=$organigrama->getCodAdm();
      $cod_adm=$o.'0'.$cod_adm;
      $nu_orden=Tbbn006OrganigramaPeer::getUltAdmEspeOrden($codigo)+1;
    }else{
      $nu_nivel=1;
      $cod_cia=01;
      $cod_adm=Tbbn006OrganigramaPeer::getUltAdm()+1;
      $cod_adm="0$cod_adm";
      $nu_orden=Tbbn006OrganigramaPeer::getUltAdmOrden()+1;
    }
      try {
        $con->beginTransaction();
        $tbbn006_organigrama = new Tbbn006Organigrama;
        $tbbn006_organigrama->setCodAdm($cod_adm);
        $tbbn006_organigrama->setCoPadre($codigo);
        $tbbn006_organigrama->setNuNivel($nu_nivel);
        $tbbn006_organigrama->setCoUsuario($this->getUser()->getAttribute('codigo'));
        $tbbn006_organigrama->setCoResponsable($this->getRequestParameter("co_responsables"));
        $tbbn006_organigrama->setTxOrganigrama(strtoupper($this->getRequestParameter("tx_organigrama")));
        $tbbn006_organigrama->setCoParroquia(strtoupper($this->getRequestParameter("co_parroquia")));
        $tbbn006_organigrama->setTxSector(strtoupper($this->getRequestParameter("tx_sector")));
        $tbbn006_organigrama->setTxCalle(strtoupper($this->getRequestParameter("tx_calle")));
        $tbbn006_organigrama->setTxAvenida(strtoupper($this->getRequestParameter("tx_avenida")));
        $tbbn006_organigrama->setTxpuntoReferencia(strtoupper($this->getRequestParameter("tx_punto_referencia")));
        $tbbn006_organigrama->setInActivo(strtoupper($this->getRequestParameter("in_activo")));
        $tbbn006_organigrama->setCodCia($cod_cia);
        $tbbn006_organigrama->setNuOrden($nu_orden);
        $tbbn006_organigrama->save($con);
        
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" =>'Registro realizado exitosamente'
                ));
       $con->commit();
      } catch (PropelException $e) {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage()
        ));
      }

      
    

  }


  public function executeRegistrar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("co_organigrama");
    $con = Propel::getConnection();
    if($codigo!=''||$codigo!=null){
      $tbbn006_organigrama = Tbbn006OrganigramaPeer::retrieveByPk($codigo);
      try {
        $con->beginTransaction();
        $tbbn006_organigrama->setTxOrganigrama(strtoupper($this->getRequestParameter("tx_organigrama")));
        $tbbn006_organigrama->setCoParroquia(strtoupper($this->getRequestParameter("co_parroquia")));
        $tbbn006_organigrama->setTxSector(strtoupper($this->getRequestParameter("tx_sector")));
        $tbbn006_organigrama->setTxCalle(strtoupper($this->getRequestParameter("tx_calle")));
        $tbbn006_organigrama->setTxAvenida(strtoupper($this->getRequestParameter("tx_avenida")));
        $tbbn006_organigrama->setTxpuntoReferencia(strtoupper($this->getRequestParameter("tx_punto_referencia")));
        $tbbn006_organigrama->setInActivo(strtoupper($this->getRequestParameter("in_activo")));
        $tbbn006_organigrama->save($con);
        
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente'
                ));
       $con->commit();
      } catch (PropelException $e) {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage()
        ));
      }

      
    }else{
      $this->data = json_encode(array(
        "success" => false,
        "msg" =>  'Datos vacios'
    ));
    }

  }


  public function executeStorefkubicacion2(sfWebRequest $request)
  {
      $adm = $this->getRequestParameter("tx_ubicacion");
      $cia = $this->getRequestParameter("tx_cia");
      $i = 1;
      $c = new Criteria();
      if ($adm && $cia) {
          $c->add(Tbbn006OrganigramaPeer::COD_ADM, $adm);
          $c->add(Tbbn006OrganigramaPeer::COD_CIA, $cia);
      } else {
          $c->add(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA, $this->getRequestParameter("co_organigrama"));
      }

      $c->addAscendingOrderByColumn(Tbbn006OrganigramaPeer::NU_NIVEL);
      $stmt = Tbbn006OrganigramaPeer::doSelectStmt($c);

      $registros = array();
      $nivel = 0;

      while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $nivel = $reg['nu_nivel'];
          $ubicacion = $reg['co_organigrama'];
          $registros[] = $reg;
      }
      $regiubi = array();
      for ($i = 1; $i <= $nivel; $i++) {

          $d = new Criteria();
          $d->addSelectColumn(Tbbn006OrganigramaPeer::TX_ORGANIGRAMA);
          $d->addSelectColumn(Tbbn006OrganigramaPeer::COD_ADM);
          $d->addSelectColumn(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA);
          $d->addSelectColumn(Tbbn006OrganigramaPeer::CO_PADRE);
          $d->addSelectColumn(Tbbn006OrganigramaPeer::NU_NIVEL);
          $d->addSelectColumn(Tbbn006OrganigramaPeer::CO_PARROQUIA);
          $d->addSelectColumn(Tbbn006OrganigramaPeer::TX_AVENIDA);
          $d->addSelectColumn(Tbbn006OrganigramaPeer::TX_CALLE);
          $d->addSelectColumn(Tbbn006OrganigramaPeer::TX_SECTOR);
          $d->addSelectColumn(Tbbn006OrganigramaPeer::TX_PUNTO_REFERENCIA);
          $d->addSelectColumn(Tbbn006OrganigramaPeer::IN_ACTIVO);
          $d->addSelectColumn(Tbbn006OrganigramaPeer::COD_CIA);
          $d->addSelectColumn(Tbbn006OrganigramaPeer::TX_DIRECCION);
          $d->addSelectColumn(Tbbn006OrganigramaPeer::CO_RESPONSABLE);
          $d->addSelectColumn(Tbbn003ParroquiaPeer::CO_MUNICIPIO);
          $d->addSelectColumn(Tbbn010ResponsablesPeer::TX_NOMBRES);
          $d->addSelectColumn(Tbbn010ResponsablesPeer::TX_APELLIDOS);
          $d->addJoin(Tbbn006OrganigramaPeer::CO_PARROQUIA, Tbbn003ParroquiaPeer::CO_PARROQUIA, Criteria::LEFT_JOIN);
          $d->addJoin(Tbbn006OrganigramaPeer::CO_RESPONSABLE, Tbbn010ResponsablesPeer::CO_RESPONSABLES, Criteria::LEFT_JOIN);
          $d->add(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA, $ubicacion);
      
          $stmt2 = Tbbn006OrganigramaPeer::doSelectStmt($d);
         // var_dump($stmt2);
          while ($reg2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
              $ubicacion = $reg2['co_padre'];
              $regiubi[] = $reg2;
          }

      }

      $this->data = json_encode(array(
          "success" => true,
          "total" => count($regiubi),
          "data" => $regiubi,
      ));
      $this->setTemplate('store');
  }

  public function executeStorefklistubicacion(sfWebRequest $request)
  {
      $padre = $this->getRequestParameter("co_organigrama");
      $adm = $this->getRequestParameter("tx_ubicacion");
      $cia = $this->getRequestParameter("tx_cia");
      $nivel = 1;

      $c = new Criteria();
      $c->addSelectColumn(Tbbn006OrganigramaPeer::TX_ORGANIGRAMA);
      $c->addSelectColumn(Tbbn006OrganigramaPeer::COD_ADM);
      $c->addSelectColumn(Tbbn006OrganigramaPeer::CO_ORGANIGRAMA);
      $c->addSelectColumn(Tbbn006OrganigramaPeer::CO_PADRE);
      $c->addSelectColumn(Tbbn006OrganigramaPeer::NU_NIVEL);
      $c->addSelectColumn(Tbbn006OrganigramaPeer::CO_PARROQUIA);
      $c->addSelectColumn(Tbbn006OrganigramaPeer::TX_AVENIDA);
      $c->addSelectColumn(Tbbn006OrganigramaPeer::TX_CALLE);
      $c->addSelectColumn(Tbbn006OrganigramaPeer::TX_SECTOR);
      $c->addSelectColumn(Tbbn006OrganigramaPeer::TX_PUNTO_REFERENCIA);
      $c->addSelectColumn(Tbbn006OrganigramaPeer::IN_ACTIVO);
      $c->addSelectColumn(Tbbn006OrganigramaPeer::COD_CIA);
      $c->addSelectColumn(Tbbn006OrganigramaPeer::TX_DIRECCION);
      $c->addSelectColumn(Tbbn006OrganigramaPeer::CO_RESPONSABLE);
      $c->addSelectColumn(Tbbn010ResponsablesPeer::TX_NOMBRES);
      $c->addSelectColumn(Tbbn010ResponsablesPeer::TX_APELLIDOS);  
      $c->addJoin(Tbbn006OrganigramaPeer::CO_RESPONSABLE, Tbbn010ResponsablesPeer::CO_RESPONSABLES, Criteria::LEFT_JOIN);
      if ($adm && $cia) {
          $p = Tbbn006OrganigramaPeer::getCoOrganigrama($adm, $cia);
          $c->add(Tbbn006OrganigramaPeer::CO_PADRE, $p);
      } else {
          if ($padre != '') {
              $c->add(Tbbn006OrganigramaPeer::CO_PADRE, $padre);
          } else {
              $c->add(Tbbn006OrganigramaPeer::NU_NIVEL, $nivel);
          }
      }
      $c->addAscendingOrderByColumn(Tbbn006OrganigramaPeer::COD_ADM);
      $stmt = Tbbn006OrganigramaPeer::doSelectStmt($c);
      $registros = array();
      /*
      {name: 'co_organigrama'},
      {name: 'tx_organigrama'},
      {name: 'co_padre'},
      {name: 'nu_nivel'},
      {name: 'tx_punto_referencia'},
      {name: 'cod_adm'},

       */
      $i = 0;
      while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

          if ($reg['tx_organigrama'] == null) {
              $registros[$i]['tx_organigrama'] = $reg['cod_adm'];
          } else {
              $registros[$i]['tx_organigrama'] = $reg['tx_organigrama'];
          }
          $registros[$i]['co_organigrama'] = $reg['co_organigrama'];
          $registros[$i]['co_responsable'] = $reg['co_responsable'];
          $registros[$i]['co_padre'] = $reg['co_padre'];
          $registros[$i]['nu_nivel'] = $reg['nu_nivel'];
          $registros[$i]['tx_punto_referencia'] = $reg['tx_punto_referencia'];
          $registros[$i]['tx_sector'] = $reg['tx_sector'];
          $registros[$i]['tx_calle'] = $reg['tx_calle'];
          $registros[$i]['tx_avenida'] = $reg['tx_avenida'];
          $registros[$i]['co_parroquia'] = $reg['co_parroquia'];
          $registros[$i]['cod_adm'] = $reg['cod_adm'];
          $registros[$i]['cod_cia'] = $reg['cod_cia'];
          $i++;
      }

      $this->data = json_encode(array(
          "success" => true,
          "total" => count($registros),
          "data" => $registros,
      ));
      $this->setTemplate('store');
  }
  public function executeStorefklistmunicipio(sfWebRequest $request)
  {
      $c = new Criteria();
      $co_municipio= $this->getRequestParameter("co_municipio");
      if($co_municipio!=''){
        $c->add(Tb017MunicipioPeer::CO_MUNICIPIO,$co_municipio);
      }
      $c->add(Tb017MunicipioPeer::IN_ACTIVO, true);
      $c->add(Tb017MunicipioPeer::CO_ESTADO, 23);
      $c->addAscendingOrderByColumn(Tb017MunicipioPeer::NB_MUNICIPIO);
      $stmt = Tb017MunicipioPeer::doSelectStmt($c);
      $registros = array();
      while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $registros[] = $reg;
      }

      $this->data = json_encode(array(
          "success" => true,
          "total" => count($registros),
          "data" => $registros,
      ));
      $this->setTemplate('store');
  }

  public function executeStorefklistresponsables(sfWebRequest $request)
  {
      $c = new Criteria();
      //$c->add(Tbbn010ResponsablesPeer::CO_PADRE, $p);
      $c->addAscendingOrderByColumn(Tbbn010ResponsablesPeer::NU_CEDULA);
      $stmt = Tbbn010ResponsablesPeer::doSelectStmt($c);
      $registros = array();
      $i = 0;
      while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

          $reg['nombre']="$reg[nu_cedula] $reg[tx_nombres] $reg[tx_apellidos]";
       
          $registros[]=$reg;
      }

      $this->data = json_encode(array(
          "success" => true,
          "total" => count($registros),
          "data" => $registros,
      ));
      $this->setTemplate('store');
  }
}
