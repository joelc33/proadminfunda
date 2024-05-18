<?php

/**
 * Ejecutor actions.
 *
 * @package    gobel
 * @subpackage Ejecutor
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class EjecutorActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Ejecutor', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Ejecutor', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb082EjecutorPeer::ID,$codigo);

        $stmt = Tb082EjecutorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "nu_ejecutor"     => $campos["nu_ejecutor"],
                            "de_ejecutor"     => $campos["de_ejecutor"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "tx_sigla"     => $campos["tx_sigla"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "nu_ejecutor"     => "",
                            "de_ejecutor"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "tx_sigla"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");

     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb082_ejecutor = Tb082EjecutorPeer::retrieveByPk($codigo);
     }else{
         $tb082_ejecutor = new Tb082Ejecutor();
     }
     try
      {
        $con->beginTransaction();

        $tb082_ejecutorForm = $this->getRequestParameter('tb082_ejecutor');
/*CAMPOS*/

        /*Campo tipo VARCHAR */
        $tb082_ejecutor->setNuEjecutor($tb082_ejecutorForm["nu_ejecutor"]);

        /*Campo tipo VARCHAR */
        $tb082_ejecutor->setDeEjecutor($tb082_ejecutorForm["de_ejecutor"]);

        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb082_ejecutorForm)){
            $tb082_ejecutor->setInActivo(false);
        }else{
            $tb082_ejecutor->setInActivo(true);
        }

        /*Campo tipo TIMESTAMP */
        $fecha = date("Y-m-d H:i:s");
        $tb082_ejecutor->setCreatedAt($fecha);

        $tb082_ejecutor->setUpdatedAt($fecha);

        /*Campo tipo VARCHAR */
        $tb082_ejecutor->setTxSigla($tb082_ejecutorForm["tx_sigla"]);

        /*CAMPOS*/
        $tb082_ejecutor->save($con);
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
	$tb082_ejecutor = Tb082EjecutorPeer::retrieveByPk($codigo);
	$tb082_ejecutor->delete($con);
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
                $nu_ejecutor      =   $this->getRequestParameter("nu_ejecutor");
            $de_ejecutor      =   $this->getRequestParameter("de_ejecutor");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($nu_ejecutor!=""){$c->add(Tb082EjecutorPeer::NU_EJECUTOR,'%'.$nu_ejecutor.'%',Criteria::ILIKE);}

                                        if($de_ejecutor!=""){$c->add(Tb082EjecutorPeer::DE_EJECUTOR,'%'.$de_ejecutor.'%',Criteria::ILIKE);}



        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb082EjecutorPeer::created_at,$fecha);
    }

        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb082EjecutorPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb082EjecutorPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb082EjecutorPeer::ID);

    $stmt = Tb082EjecutorPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "nu_ejecutor"     => trim($res["nu_ejecutor"]),
            "de_ejecutor"     => trim($res["de_ejecutor"]),
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
