<?php

/**
 * Sector actions.
 *
 * @package    gobel
 * @subpackage Sector
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class SectorActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Sector', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Sector', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb080SectorPeer::ID,$codigo);

        $stmt = Tb080SectorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "nu_sector"     => $campos["nu_sector"],
                            "de_sector"     => $campos["de_sector"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "nu_sector"     => "",
                            "de_sector"     => "",
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
         $tb080_sector = Tb080SectorPeer::retrieveByPk($codigo);
     }else{
         $tb080_sector = new Tb080Sector();
     }
     try
      {
        $con->beginTransaction();

        $tb080_sectorForm = $this->getRequestParameter('tb080_sector');
/*CAMPOS*/

        /*Campo tipo VARCHAR */
        $tb080_sector->setNuSector($tb080_sectorForm["nu_sector"]);

        /*Campo tipo VARCHAR */
        $tb080_sector->setDeSector($tb080_sectorForm["de_sector"]);

        /*Campo tipo BOOLEAN */
        $tb080_sector->setInActivo(true);

        /*Campo tipo TIMESTAMP */
        $fecha = date("Y-m-d H:i:s");
        $tb080_sector->setCreatedAt($fecha);

        /*Campo tipo TIMESTAMP */
        $fecha = date("Y-m-d H:i:s");
        $tb080_sector->setUpdatedAt($fecha);

        /*CAMPOS*/
        $tb080_sector->save($con);
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
	$tb080_sector = Tb080SectorPeer::retrieveByPk($codigo);
	$tb080_sector->delete($con);
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
                $nu_sector      =   $this->getRequestParameter("nu_sector");
            $de_sector      =   $this->getRequestParameter("de_sector");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($nu_sector!=""){$c->add(Tb080SectorPeer::nu_sector,'%'.$nu_sector.'%',Criteria::LIKE);}

                                        if($de_sector!=""){$c->add(Tb080SectorPeer::de_sector,'%'.$de_sector.'%',Criteria::LIKE);}



        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb080SectorPeer::created_at,$fecha);
    }

        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb080SectorPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb080SectorPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb080SectorPeer::ID);

    $stmt = Tb080SectorPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "nu_sector"     => trim($res["nu_sector"]),
            "de_sector"     => trim($res["de_sector"]),
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

}
