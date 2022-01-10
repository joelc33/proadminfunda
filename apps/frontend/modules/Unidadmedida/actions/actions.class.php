<?php

/**
 * Unidadmedida actions.
 *
 * @package    gobel
 * @subpackage Unidadmedida
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class UnidadmedidaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Unidadmedida', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Unidadmedida', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb089UnidadMedidaPeer::ID,$codigo);

        $stmt = Tb089UnidadMedidaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "de_unidad_medida"     => $campos["de_unidad_medida"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "de_unidad_medida"     => "",
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
         $tb089_unidad_medida = Tb089UnidadMedidaPeer::retrieveByPk($codigo);
     }else{
         $tb089_unidad_medida = new Tb089UnidadMedida();
     }
     try
      {
        $con->beginTransaction();

        $tb089_unidad_medidaForm = $this->getRequestParameter('tb089_unidad_medida');
/*CAMPOS*/

        /*Campo tipo VARCHAR */
        $tb089_unidad_medida->setDeUnidadMedida($tb089_unidad_medidaForm["de_unidad_medida"]);

        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb089_unidad_medidaForm)){
            $tb089_unidad_medida->setInActivo(false);
        }else{
            $tb089_unidad_medida->setInActivo(true);
        }

        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb089_unidad_medidaForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb089_unidad_medida->setCreatedAt($fecha);

        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb089_unidad_medidaForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb089_unidad_medida->setUpdatedAt($fecha);

        /*CAMPOS*/
        $tb089_unidad_medida->save($con);
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
	$tb089_unidad_medida = Tb089UnidadMedidaPeer::retrieveByPk($codigo);
	$tb089_unidad_medida->delete($con);
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
                $de_unidad_medida      =   $this->getRequestParameter("de_unidad_medida");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($de_unidad_medida!=""){$c->add(Tb089UnidadMedidaPeer::de_unidad_medida,'%'.$de_unidad_medida.'%',Criteria::LIKE);}



        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb089UnidadMedidaPeer::created_at,$fecha);
    }

        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb089UnidadMedidaPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb089UnidadMedidaPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb089UnidadMedidaPeer::ID);

    $stmt = Tb089UnidadMedidaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "de_unidad_medida"     => trim($res["de_unidad_medida"]),
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
