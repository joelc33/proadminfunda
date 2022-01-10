<?php

/**
 * Subsector actions.
 *
 * @package    gobel
 * @subpackage Subsector
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class SubsectorActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Subsector', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Subsector', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb081SubSectorPeer::ID,$codigo);

        $stmt = Tb081SubSectorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb080_sector"     => $campos["id_tb080_sector"],
                            "nu_sub_sector"     => $campos["nu_sub_sector"],
                            "de_sub_sector"     => $campos["de_sub_sector"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb080_sector"     => "",
                            "nu_sub_sector"     => "",
                            "de_sub_sector"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");

     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb081_sub_sector = Tb081SubSectorPeer::retrieveByPk($codigo);
     }else{
         $tb081_sub_sector = new Tb081SubSector();
     }
     try
      {
        $con->beginTransaction();

        $tb081_sub_sectorForm = $this->getRequestParameter('tb081_sub_sector');
/*CAMPOS*/

        /*Campo tipo BIGINT */
        $tb081_sub_sector->setIdTb080Sector($tb081_sub_sectorForm["id_tb080_sector"]);

        /*Campo tipo VARCHAR */
        $tb081_sub_sector->setNuSubSector($tb081_sub_sectorForm["nu_sub_sector"]);

        /*Campo tipo VARCHAR */
        $tb081_sub_sector->setDeSubSector($tb081_sub_sectorForm["de_sub_sector"]);

        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb081_sub_sectorForm)){
            $tb081_sub_sector->setInActivo(false);
        }else{
            $tb081_sub_sector->setInActivo(true);
        }

        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb081_sub_sectorForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb081_sub_sector->setCreatedAt($fecha);

        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb081_sub_sectorForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb081_sub_sector->setUpdatedAt($fecha);

        /*CAMPOS*/
        $tb081_sub_sector->save($con);
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
	$tb081_sub_sector = Tb081SubSectorPeer::retrieveByPk($codigo);
	$tb081_sub_sector->delete($con);
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
                $id_tb080_sector      =   $this->getRequestParameter("id_tb080_sector");
            $nu_sub_sector      =   $this->getRequestParameter("nu_sub_sector");
            $de_sub_sector      =   $this->getRequestParameter("de_sub_sector");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($id_tb080_sector!=""){$c->add(Tb081SubSectorPeer::id_tb080_sector,$id_tb080_sector);}

                                        if($nu_sub_sector!=""){$c->add(Tb081SubSectorPeer::nu_sub_sector,'%'.$nu_sub_sector.'%',Criteria::LIKE);}

                                        if($de_sub_sector!=""){$c->add(Tb081SubSectorPeer::de_sub_sector,'%'.$de_sub_sector.'%',Criteria::LIKE);}



        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb081SubSectorPeer::created_at,$fecha);
    }

        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb081SubSectorPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb081SubSectorPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb081SubSectorPeer::ID);

    $c->clearSelectColumns();
    $c->addSelectColumn(Tb081SubSectorPeer::ID);
    $c->addSelectColumn(Tb081SubSectorPeer::NU_SUB_SECTOR);
    $c->addSelectColumn(Tb081SubSectorPeer::DE_SUB_SECTOR);
    $c->addSelectColumn(Tb080SectorPeer::NU_SECTOR);
    $c->addJoin(Tb080SectorPeer::ID, Tb081SubSectorPeer::ID_TB080_SECTOR);

    $stmt = Tb081SubSectorPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "nu_sector"     => trim($res["nu_sector"]),
            "nu_sub_sector"     => trim($res["nu_sub_sector"]),
            "de_sub_sector"     => trim($res["de_sub_sector"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb080_sector.ID
    public function executeStorefkidtb080sector(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb080SectorPeer::doSelectStmt($c);
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
