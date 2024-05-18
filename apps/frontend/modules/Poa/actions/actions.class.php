<?php

/**
 * Poa actions.
 *
 * @package    gobel
 * @subpackage Poa
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class PoaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Poa', 'lista');
  }

  public function executeLista(sfWebRequest $request)
  {

  }

  public function executeStorelista(sfWebRequest $request)
  {

    $con = Propel::getConnection("poa");

    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);

    /*$sql = 'SELECT co_sector, tx_descripcion, nu_original, de_nombre, nu_ae, de_ae,
            co_partida, monto, ef_uno, tipo, id_ejecutor, tx_ejecutor, de_denominacion
            FROM vista_distribucion_presupuesto
            WHERE ef_uno = :ejercicio';*/

    $sql = 'SELECT co_sector, de_sector, SUM(monto) AS mo_presupuesto
            FROM vista_exportar_poa
            WHERE ef_uno = :ejercicio
            GROUP BY co_sector, de_sector';

    $stmt2 = $con->prepare($sql);
    $stmt2->execute(
      array(
        ':ejercicio' => $this->getUser()->getAttribute('ejercicio')
        )
    );

    while($reg2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
        $registros2[] = $reg2;
    }

    $sql.= " ORDER BY co_sector ASC LIMIT ".$limit." OFFSET ".$start;

    $data = '';
    $stmt = $con->prepare($sql);
    $stmt->execute(
      array(
        ':ejercicio' => $this->getUser()->getAttribute('ejercicio')
        )
    );

    while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = $reg;
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  count($registros2),
        "data"      =>  $registros
    ));

    $this->setTemplate('store');

  }

  public function executeSubsector(sfWebRequest $request)
  {
    $this->data = json_encode(array(
        "co_sector" => $this->getRequestParameter("sector")
    ));
  }

  public function executeStorelistasubsector(sfWebRequest $request)
  {

    $con = Propel::getConnection("poa");

    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);

    $sector    =   $this->getRequestParameter("co_sector");

    /*$sql = 'SELECT co_sector, tx_descripcion, nu_original, de_nombre, nu_ae, de_ae,
            co_partida, monto, ef_uno, tipo, id_ejecutor, tx_ejecutor, de_denominacion
            FROM vista_distribucion_presupuesto
            WHERE ef_uno = :ejercicio';*/

    $sql = 'SELECT co_sub_sector, de_sub_sector, SUM(monto) AS mo_presupuesto
            FROM vista_exportar_poa
            WHERE ef_uno = :ejercicio
            AND co_sector = :sector
            GROUP BY co_sub_sector, de_sub_sector';

    $stmt2 = $con->prepare($sql);
    $stmt2->execute(
      array(
        ':ejercicio' => $this->getUser()->getAttribute('ejercicio'),
        ':sector' => $sector
        )
    );

    while($reg2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
        $registros2[] = $reg2;
    }

    $sql.= " ORDER BY co_sub_sector ASC LIMIT ".$limit." OFFSET ".$start;

    $data = '';
    $stmt = $con->prepare($sql);
    $stmt->execute(
      array(
        ':ejercicio' => $this->getUser()->getAttribute('ejercicio'),
        ':sector' => $sector
        )
    );

    while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = $reg;
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  count($registros2),
        "data"      =>  $registros
    ));

    $this->setTemplate('store');

  }

  public function executeEjecutor(sfWebRequest $request)
  {
    $this->data = json_encode(array(
        "co_sub_sector" => $this->getRequestParameter("subsector")
    ));
  }

  public function executeStorelistaejecutor(sfWebRequest $request)
  {

    $con = Propel::getConnection("poa");

    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);

    $sub_sector    =   $this->getRequestParameter("co_sub_sector");

    $sql = 'SELECT co_sub_sector, id_ejecutor, tx_ejecutor as de_ejecutor, SUM(monto) AS mo_presupuesto
            FROM vista_exportar_poa
            WHERE ef_uno = :ejercicio
            AND co_sub_sector = :sub_sector
            GROUP BY co_sub_sector, id_ejecutor, tx_ejecutor';

    $stmt2 = $con->prepare($sql);
    $stmt2->execute(
      array(
        ':ejercicio' => $this->getUser()->getAttribute('ejercicio'),
        ':sub_sector' => $sub_sector
        )
    );

    while($reg2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
        $registros2[] = $reg2;
    }

    $sql.= " ORDER BY co_sub_sector, id_ejecutor ASC LIMIT ".$limit." OFFSET ".$start;

    $data = '';
    $stmt = $con->prepare($sql);
    $stmt->execute(
      array(
        ':ejercicio' => $this->getUser()->getAttribute('ejercicio'),
        ':sub_sector' => $sub_sector
        )
    );

    while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = $reg;
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  count($registros2),
        "data"      =>  $registros
    ));

    $this->setTemplate('store');

  }

  public function executePrac(sfWebRequest $request)
  {
    $this->data = json_encode(array(
        "co_sub_sector" => $this->getRequestParameter("subsector"),
        "id_ejecutor" => $this->getRequestParameter("ejecutor")
    ));
  }

  public function executeStorelistaprac(sfWebRequest $request)
  {

    $con = Propel::getConnection("poa");

    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);

    $sub_sector    =   $this->getRequestParameter("co_sub_sector");
    $id_ejecutor    =   $this->getRequestParameter("id_ejecutor");

    $sql = 'SELECT nu_pr_ac, de_nombre, SUM(monto) AS mo_presupuesto
            FROM vista_exportar_poa
            WHERE ef_uno = :ejercicio
            AND co_sub_sector = :sub_sector
            AND id_ejecutor = :id_ejecutor
            GROUP BY nu_pr_ac, de_nombre';

    $stmt2 = $con->prepare($sql);
    $stmt2->execute(
      array(
        ':ejercicio' => $this->getUser()->getAttribute('ejercicio'),
        ':sub_sector' => $sub_sector,
        ':id_ejecutor' => $id_ejecutor
        )
    );

    while($reg2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
        $registros2[] = $reg2;
    }

    $sql.= " ORDER BY nu_pr_ac ASC LIMIT ".$limit." OFFSET ".$start;

    $data = '';
    $stmt = $con->prepare($sql);
    $stmt->execute(
      array(
        ':ejercicio' => $this->getUser()->getAttribute('ejercicio'),
        ':sub_sector' => $sub_sector,
        ':id_ejecutor' => $id_ejecutor
        )
    );

    while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = $reg;
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  count($registros2),
        "data"      =>  $registros
    ));

    $this->setTemplate('store');

  }

  public function executeAe(sfWebRequest $request)
  {
    $this->data = json_encode(array(
        "prac" => $this->getRequestParameter("prac")
    ));
  }

  public function executeStorelistaae(sfWebRequest $request)
  {

    $con = Propel::getConnection("poa");

    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);

    $nu_pr_ac    =   $this->getRequestParameter("prac");

    $sql = 'SELECT nu_pr_ac, nu_ae, de_ae, SUM(monto) AS mo_presupuesto
            FROM vista_exportar_poa
            WHERE ef_uno = :ejercicio
            AND nu_pr_ac = :nu_pr_ac
            GROUP BY nu_pr_ac, nu_ae, de_ae';

    $stmt2 = $con->prepare($sql);
    $stmt2->execute(
      array(
        ':ejercicio' => $this->getUser()->getAttribute('ejercicio'),
        ':nu_pr_ac' => $nu_pr_ac
        )
    );

    while($reg2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
        $registros2[] = $reg2;
    }

    $sql.= " ORDER BY nu_pr_ac, nu_ae ASC LIMIT ".$limit." OFFSET ".$start;

    $data = '';
    $stmt = $con->prepare($sql);
    $stmt->execute(
      array(
        ':ejercicio' => $this->getUser()->getAttribute('ejercicio'),
        ':nu_pr_ac' => $nu_pr_ac
        )
    );

    while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = $reg;
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  count($registros2),
        "data"      =>  $registros
    ));

    $this->setTemplate('store');

  }

  public function executePartida(sfWebRequest $request)
  {
    $this->data = json_encode(array(
        "prac" => $this->getRequestParameter("prac"),
        "ae" => $this->getRequestParameter("ae")
    ));
  }

  public function executeStorelistapartida(sfWebRequest $request)
  {

    $con = Propel::getConnection("poa");

    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);

    $nu_pr_ac    =   $this->getRequestParameter("prac");
    $nu_ae    =   $this->getRequestParameter("ae");

    $sql = 'SELECT nu_partida, cu_partida, de_denominacion, monto AS mo_presupuesto
            FROM vista_exportar_poa
            WHERE ef_uno = :ejercicio
            AND nu_pr_ac = :nu_pr_ac
            AND nu_ae = :nu_ae';

    $stmt2 = $con->prepare($sql);
    $stmt2->execute(
      array(
        ':ejercicio' => $this->getUser()->getAttribute('ejercicio'),
        ':nu_pr_ac' => $nu_pr_ac,
        ':nu_ae' => $nu_ae
        )
    );

    while($reg2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
        $registros2[] = $reg2;
    }

    $sql.= " ORDER BY nu_partida ASC LIMIT ".$limit." OFFSET ".$start;

    $data = '';
    $stmt = $con->prepare($sql);
    $stmt->execute(
      array(
        ':ejercicio' => $this->getUser()->getAttribute('ejercicio'),
        ':nu_pr_ac' => $nu_pr_ac,
        ':nu_ae' => $nu_ae
        )
    );

    while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = $reg;
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  count($registros2),
        "data"      =>  $registros
    ));

    $this->setTemplate('store');

  }

  public function executeActividad(sfWebRequest $request)
  {
    $this->data = json_encode(array(
        "prac" => $this->getRequestParameter("prac"),
        "ae" => $this->getRequestParameter("ae")
    ));
  }

  public function executeStorelistaactividad(sfWebRequest $request)
  {

    $con = Propel::getConnection("poa");

    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);

    $nu_pr_ac    =   $this->getRequestParameter("prac");
    $nu_ae    =   $this->getRequestParameter("ae");

    $sql = 'SELECT nu_actividad, nb_meta
            FROM vista_exportar_poa_actividad
            WHERE nu_pr_ac = :nu_pr_ac
            AND nu_ae = :nu_ae';

    $stmt2 = $con->prepare($sql);
    $stmt2->execute(
      array(
        ':nu_pr_ac' => $nu_pr_ac,
        ':nu_ae' => $nu_ae
        )
    );

    while($reg2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
        $registros2[] = $reg2;
    }

    $sql.= " ORDER BY nu_actividad ASC LIMIT ".$limit." OFFSET ".$start;

    $data = '';
    $stmt = $con->prepare($sql);
    $stmt->execute(
      array(
        ':nu_pr_ac' => $nu_pr_ac,
        ':nu_ae' => $nu_ae
        )
    );

    while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = $reg;
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  count($registros2),
        "data"      =>  $registros
    ));

    $this->setTemplate('store');

  }

  public function executeImportar(sfWebRequest $request)
  {
    $this->ejercicio = $this->getUser()->getAttribute('ejercicio');
    $this->getRequest()->setAttribute('ejercicio', $this->ejercicio);
  }

  public function executeStorelistaimportar(sfWebRequest $request)
  {

    $con = Propel::getConnection("poa");

    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);

    $sql = 'SELECT ef_uno, id_ejecutor, nu_pr_ac, nu_ae, nu_partida, cu_partida, de_denominacion, monto AS mo_presupuesto
            FROM vista_exportar_poa
            WHERE ef_uno = :ejercicio';

    if($this->getRequestParameter("BuscarBy")=="true"){
      if($this->getRequestParameter("variable")!=""){
        $sql.=" and nu_ae||nu_pr_ac||id_ejecutor||nu_partida||cu_partida||de_denominacion ILIKE '%".$this->getRequestParameter("variable")."%'";
      }
    }

    $stmt2 = $con->prepare($sql);
    $stmt2->execute(
      array(
        ':ejercicio' => $this->getUser()->getAttribute('ejercicio')
        )
    );

    while($reg2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
        $registros2[] = $reg2;
    }

    $sql.= " ORDER BY id_ejecutor, nu_pr_ac, nu_ae, nu_partida ASC LIMIT ".$limit." OFFSET ".$start;

    $data = '';
    $stmt = $con->prepare($sql);
    $stmt->execute(
      array(
        ':ejercicio' => $this->getUser()->getAttribute('ejercicio')
        )
    );

    while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
        $registros[] = $reg;
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  count($registros2),
        "data"      =>  $registros
    ));

    $this->setTemplate('store');

  }

  public function executeEjecutar(sfWebRequest $request)
  {
      $con = Propel::getConnection("poa");

      $sql = 'SELECT ef_uno, co_sector, co_sub_sector, id_ejecutor, nu_original, nu_pr_ac, tipo, de_nombre
               FROM vista_exportar_poa
              WHERE ef_uno = :ejercicio
              GROUP BY ef_uno, co_sector, co_sub_sector, id_ejecutor, nu_original, nu_pr_ac, tipo, de_nombre
              ORDER BY id_ejecutor, nu_pr_ac ASC';

      $data = '';
      $stmt = $con->prepare($sql);
      $stmt->execute(
        array(
          ':ejercicio' => $this->getUser()->getAttribute('ejercicio')
          )
      );

      try{

        $con_gobel = Propel::getConnection("propel");

        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){

          $sector = new Criteria();
          $sector->add(Tb080SectorPeer::NU_SECTOR, $reg['co_sector']);
          $stmtsector = Tb080SectorPeer::doSelectStmt($sector);
          $campossector = $stmtsector->fetch(PDO::FETCH_ASSOC);

          $subsector = new Criteria();
          $subsector->add(Tb081SubSectorPeer::NU_SUB_SECTOR, $reg['co_sub_sector']);
          $stmtsubsector = Tb081SubSectorPeer::doSelectStmt($subsector);
          $campossubsector = $stmtsubsector->fetch(PDO::FETCH_ASSOC);

          $ejecutor = new Criteria();
          $ejecutor->add(Tb082EjecutorPeer::NU_EJECUTOR, $reg['id_ejecutor']);
          $stmtejecutor = Tb082EjecutorPeer::doSelectStmt($ejecutor);
          $camposejecutor = $stmtejecutor->fetch(PDO::FETCH_ASSOC);

          $fecha = date("Y-m-d H:i:s");

          $tb083_proyecto_ac = new Tb083ProyectoAc();
          $tb083_proyecto_ac->setIdTb080Sector($campossector["id"]);
          $tb083_proyecto_ac->setIdTb081SubSector($campossubsector["id"]);
          $tb083_proyecto_ac->setIdTb082Ejecutor($camposejecutor["id"]);
          $tb083_proyecto_ac->setNuProyectoAc($reg['nu_pr_ac']);
          $tb083_proyecto_ac->setDeProyectoAc($reg['de_nombre']);
          $tb083_proyecto_ac->setIdTb013AnioFiscal($reg['ef_uno']);
          $tb083_proyecto_ac->setIdTb086TipoPrac($reg['tipo']);
          $tb083_proyecto_ac->setInActivo(TRUE);
          $tb083_proyecto_ac->setCreatedAt($fecha);
          $tb083_proyecto_ac->setUpdatedAt($fecha);
          $tb083_proyecto_ac->save($con_gobel);

          $sql_ae = 'SELECT nu_ae, de_ae
                  FROM vista_exportar_poa
                  WHERE ef_uno = :ejercicio
                  AND nu_pr_ac = :nu_pr_ac
                  GROUP BY nu_ae, de_ae';

          $stmt_ae = $con->prepare($sql_ae);
          $stmt_ae->execute(
            array(
              ':ejercicio' => $reg['ef_uno'],
              ':nu_pr_ac' => $reg['nu_pr_ac']
              )
          );

          while($reg_ae = $stmt_ae->fetch(PDO::FETCH_ASSOC)){

            $tb084_accion_especifica = new Tb084AccionEspecifica();
            $tb084_accion_especifica->setIdTb083ProyectoAc($tb083_proyecto_ac->getId());
            $tb084_accion_especifica->setNuAccionEspecifica($reg_ae['nu_ae']);
            $tb084_accion_especifica->setDeAccionEspecifica($reg_ae['de_ae']);
            $tb084_accion_especifica->setInActivo(TRUE);
            $tb084_accion_especifica->setCreatedAt($fecha);
            $tb084_accion_especifica->setUpdatedAt($fecha);
            $tb084_accion_especifica->save($con_gobel);

            $sql_partida = 'SELECT nu_partida, de_denominacion, monto, nu_pa, nu_ge,
                    nu_es, nu_se, nu_sse, cu_partida, nu_nivel
                    FROM vista_exportar_poa
                    WHERE ef_uno = :ejercicio
                    AND nu_pr_ac = :nu_pr_ac
                    AND nu_ae = :nu_ae
                    ORDER BY nu_partida';

            $stmt_partida = $con->prepare($sql_partida);
            $stmt_partida->execute(
              array(
                ':ejercicio' => $reg['ef_uno'],
                ':nu_pr_ac' => $reg['nu_pr_ac'],
                ':nu_ae' => $reg_ae['nu_ae']
                )
            );

            while($reg_partida = $stmt_partida->fetch(PDO::FETCH_ASSOC)){

              $tb085_presupuesto = new Tb085Presupuesto();
              $tb085_presupuesto->setIdTb084AccionEspecifica($tb084_accion_especifica->getId());
              $tb085_presupuesto->setNuPartida(trim($reg_partida['nu_partida']));
              $tb085_presupuesto->setDePartida($reg_partida['de_denominacion']);
              $tb085_presupuesto->setMoInicial($reg_partida['monto']);
              $tb085_presupuesto->setMoActualizado($reg_partida['monto']);
              $tb085_presupuesto->setMoPrecomprometido(0);
              $tb085_presupuesto->setMoComprometido(0);
              $tb085_presupuesto->setMoCausado(0);
              $tb085_presupuesto->setMoPagado(0);
              $tb085_presupuesto->setMoDisponible($reg_partida['monto']);
              $tb085_presupuesto->setInActivo(TRUE);
              $tb085_presupuesto->setInMovimiento(TRUE);
              $tb085_presupuesto->setCreatedAt($fecha);
              $tb085_presupuesto->setUpdatedAt($fecha);
              $tb085_presupuesto->setNuPa($reg_partida['nu_pa']);
              $tb085_presupuesto->setNuGe($reg_partida['nu_ge']);
              $tb085_presupuesto->setNuEs($reg_partida['nu_es']);
              $tb085_presupuesto->setNuSe($reg_partida['nu_se']);
              $tb085_presupuesto->setNuSse($reg_partida['nu_sse']);
              $tb085_presupuesto->setCoPartida($reg_partida['cu_partida']);
              $tb085_presupuesto->setNuNivel($reg_partida['nu_nivel']);
              $tb085_presupuesto->save($con_gobel);

            }

            $sql_actividad = 'SELECT nu_pr_ac, nu_ae, nu_actividad, nb_meta
                    FROM vista_exportar_poa_actividad
                    WHERE nu_pr_ac = :nu_pr_ac
                    AND nu_ae = :nu_ae
                    ORDER BY nu_actividad';

            $stmt_actividad = $con->prepare($sql_actividad);
            $stmt_actividad->execute(
              array(
                ':nu_pr_ac' => $reg['nu_pr_ac'],
                ':nu_ae' => $reg_ae['nu_ae']
                )
            );

            while($reg_actividad = $stmt_actividad->fetch(PDO::FETCH_ASSOC)){

              $tb090_actividad = new Tb090Actividad();
              $tb090_actividad->setIdTb084AccionEspecifica($tb084_accion_especifica->getId());
              $tb090_actividad->setNuActividad(trim($reg_actividad['nu_actividad']));
              $tb090_actividad->setDeActividad(trim($reg_actividad['nb_meta']));
              $tb090_actividad->setInActivo(TRUE);
              $tb090_actividad->setCreatedAt($fecha);
              $tb090_actividad->setUpdatedAt($fecha);
              $tb090_actividad->save($con_gobel);

            }

          }

        }

        $con_gobel->commit();

        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Presupuesto exportado exitosamente!'
                ));

        $this->setTemplate('store');

      }catch (PropelException $e)
      {
        $con_gobel->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage()
        ));

        $this->setTemplate('store');
      }
  }

}
