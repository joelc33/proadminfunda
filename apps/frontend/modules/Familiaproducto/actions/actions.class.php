<?php

/**
 * Familiaproducto actions.
 *
 * @package    gobel
 * @subpackage Familiaproducto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class FamiliaproductoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Familiaproducto', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Familiaproducto', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb093FamiliaProductoPeer::ID,$codigo);

        $stmt = Tb093FamiliaProductoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "de_familia_producto"     => $campos["de_familia_producto"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "de_familia_producto"     => "",
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
         $tb093_familia_producto = Tb093FamiliaProductoPeer::retrieveByPk($codigo);
     }else{
         $tb093_familia_producto = new Tb093FamiliaProducto();
     }
     try
      {
        $con->beginTransaction();

        $tb093_familia_productoForm = $this->getRequestParameter('tb093_familia_producto');
/*CAMPOS*/

        /*Campo tipo VARCHAR */
        $tb093_familia_producto->setDeFamiliaProducto(strtoupper($tb093_familia_productoForm["de_familia_producto"]));

        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb093_familia_productoForm)){
            $tb093_familia_producto->setInActivo(false);
        }else{
            $tb093_familia_producto->setInActivo(true);
        }
      

        /*CAMPOS*/
        $tb093_familia_producto->save($con);
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
	$tb093_familia_producto = Tb093FamiliaProductoPeer::retrieveByPk($codigo);
	$tb093_familia_producto->delete($con);
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
                $de_familia_producto      =   $this->getRequestParameter("de_familia_producto");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($de_familia_producto!=""){$c->add(Tb093FamiliaProductoPeer::DE_FAMILIA_PRODUCTO,'%'.$de_familia_producto.'%',Criteria::LIKE);}



        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb093FamiliaProductoPeer::created_at,$fecha);
    }

        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb093FamiliaProductoPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb093FamiliaProductoPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb093FamiliaProductoPeer::ID);

    $stmt = Tb093FamiliaProductoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "de_familia_producto"     => trim($res["de_familia_producto"]),
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
