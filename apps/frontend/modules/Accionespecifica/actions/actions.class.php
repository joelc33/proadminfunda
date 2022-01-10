<?php

/**
 * Accionespecifica actions.
 *
 * @package    gobel
 * @subpackage Accionespecifica
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class AccionespecificaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Accionespecifica', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Accionespecifica', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb084AccionEspecificaPeer::ID,$codigo);

        $stmt = Tb084AccionEspecificaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb083_proyecto_ac"     => $campos["id_tb083_proyecto_ac"],
                            "nu_accion_especifica"     => $campos["nu_accion_especifica"],
                            "de_accion_especifica"     => $campos["de_accion_especifica"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb083_proyecto_ac"     => $this->getRequestParameter("id_tb083_proyecto_ac"),
                            "nu_accion_especifica"     => "",
                            "de_accion_especifica"     => "",
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
         $tb084_accion_especifica = Tb084AccionEspecificaPeer::retrieveByPk($codigo);
     }else{
         $tb084_accion_especifica = new Tb084AccionEspecifica();
     }
     try
      {
        $con->beginTransaction();

        $tb084_accion_especificaForm = $this->getRequestParameter('tb084_accion_especifica');
/*CAMPOS*/

        /*Campo tipo BIGINT */
        $tb084_accion_especifica->setIdTb083ProyectoAc($tb084_accion_especificaForm["id_tb083_proyecto_ac"]);

        /*Campo tipo VARCHAR */
        $tb084_accion_especifica->setNuAccionEspecifica($tb084_accion_especificaForm["nu_accion_especifica"]);

        /*Campo tipo VARCHAR */
        $tb084_accion_especifica->setDeAccionEspecifica($tb084_accion_especificaForm["de_accion_especifica"]);

        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tb084_accion_especificaForm)){
            $tb084_accion_especifica->setInActivo(false);
        }else{
            $tb084_accion_especifica->setInActivo(true);
        }*/

        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tb084_accion_especificaForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb084_accion_especifica->setCreatedAt($fecha);*/

        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tb084_accion_especificaForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb084_accion_especifica->setUpdatedAt($fecha);*/

        /*CAMPOS*/
        $tb084_accion_especifica->save($con);
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
	$tb084_accion_especifica = Tb084AccionEspecificaPeer::retrieveByPk($codigo);
	$tb084_accion_especifica->delete($con);
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
                $id_tb083_proyecto_ac      =   $this->getRequestParameter("id_tb083_proyecto_ac");
            $nu_accion_especifica      =   $this->getRequestParameter("nu_accion_especifica");
            $de_accion_especifica      =   $this->getRequestParameter("variable");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $codigo = $this->getRequestParameter("codigo");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($id_tb083_proyecto_ac!=""){$c->add(Tb084AccionEspecificaPeer::ID_TB083_PROYECTO_AC,$id_tb083_proyecto_ac);}

                                        if($nu_accion_especifica!=""){$c->add(Tb084AccionEspecificaPeer::NU_ACCION_ESPECIFICA,'%'.$nu_accion_especifica.'%',Criteria::LIKE);}

                                        if($de_accion_especifica!=""){$c->add(Tb084AccionEspecificaPeer::DE_ACCION_ESPECIFICA,'%'.$de_accion_especifica.'%',Criteria::LIKE);}



        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb084AccionEspecificaPeer::created_at,$fecha);
    }

        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb084AccionEspecificaPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $c->add(Tb084AccionEspecificaPeer::ID_TB083_PROYECTO_AC,$codigo);
    $cantidadTotal = Tb084AccionEspecificaPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb084AccionEspecificaPeer::ID);

    $stmt = Tb084AccionEspecificaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "id_tb083_proyecto_ac"     => trim($res["id_tb083_proyecto_ac"]),
            "nu_accion_especifica"     => trim($res["nu_accion_especifica"]),
            "de_accion_especifica"     => trim($res["de_accion_especifica"]),
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

                    //modelo fk tb083_proyecto_ac.ID
    public function executeStorefkidtb083proyectoac(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb083ProyectoAcPeer::doSelectStmt($c);
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
