<?php

/**
 * Aeactividades actions.
 *
 * @package    gobel
 * @subpackage Aeactividades
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class AeactividadesActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Aeactividades', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Aeactividades', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb090ActividadPeer::ID,$codigo);

        $stmt = Tb090ActividadPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb084_accion_especifica"     => $campos["id_tb084_accion_especifica"],
                            "nu_actividad"     => $campos["nu_actividad"],
                            "de_actividad"     => $campos["de_actividad"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb084_accion_especifica"     => "",
                            "nu_actividad"     => "",
                            "de_actividad"     => "",
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
         $tb090_actividad = Tb090ActividadPeer::retrieveByPk($codigo);
     }else{
         $tb090_actividad = new Tb090Actividad();
     }
     try
      {
        $con->beginTransaction();

        $tb090_actividadForm = $this->getRequestParameter('tb090_actividad');
/*CAMPOS*/

        /*Campo tipo BIGINT */
        $tb090_actividad->setIdTb084AccionEspecifica($tb090_actividadForm["id_tb084_accion_especifica"]);

        /*Campo tipo VARCHAR */
        $tb090_actividad->setNuActividad($tb090_actividadForm["nu_actividad"]);

        /*Campo tipo VARCHAR */
        $tb090_actividad->setDeActividad($tb090_actividadForm["de_actividad"]);

        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb090_actividadForm)){
            $tb090_actividad->setInActivo(false);
        }else{
            $tb090_actividad->setInActivo(true);
        }

        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb090_actividadForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb090_actividad->setCreatedAt($fecha);

        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb090_actividadForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb090_actividad->setUpdatedAt($fecha);

        /*CAMPOS*/
        $tb090_actividad->save($con);
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
	$tb090_actividad = Tb090ActividadPeer::retrieveByPk($codigo);
	$tb090_actividad->delete($con);
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
    $this->data = json_encode(array(
        "codigo" => $this->getRequestParameter("codigo")
    ));
  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $id_tb084_accion_especifica      =   $this->getRequestParameter("codigo");
            $nu_actividad      =   $this->getRequestParameter("nu_actividad");
            $de_actividad      =   $this->getRequestParameter("de_actividad");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($id_tb084_accion_especifica!=""){$c->add(Tb090ActividadPeer::id_tb084_accion_especifica,$id_tb084_accion_especifica);}

                                        if($nu_actividad!=""){$c->add(Tb090ActividadPeer::nu_actividad,'%'.$nu_actividad.'%',Criteria::LIKE);}

                                        if($de_actividad!=""){$c->add(Tb090ActividadPeer::de_actividad,'%'.$de_actividad.'%',Criteria::LIKE);}



        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb090ActividadPeer::created_at,$fecha);
    }

        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb090ActividadPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $c->add(Tb090ActividadPeer::ID_TB084_ACCION_ESPECIFICA,$id_tb084_accion_especifica);
    $cantidadTotal = Tb090ActividadPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb090ActividadPeer::ID);

    $stmt = Tb090ActividadPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "id_tb084_accion_especifica"     => trim($res["id_tb084_accion_especifica"]),
            "nu_actividad"     => trim($res["nu_actividad"]),
            "de_actividad"     => trim($res["de_actividad"]),
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

                    //modelo fk tb084_accion_especifica.ID
    public function executeStorefkidtb084accionespecifica(sfWebRequest $request){
        $c = new Criteria();
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



}
