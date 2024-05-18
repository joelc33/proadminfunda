<?php

/**
 * Claseproducto actions.
 *
 * @package    gobel
 * @subpackage Claseproducto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ClaseproductoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Claseproducto', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Claseproducto', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb092ClaseProductoPeer::ID,$codigo);

        $stmt = Tb092ClaseProductoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "de_clase_producto"     => $campos["de_clase_producto"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "id_tb093_familia_producto"     => $campos["id_tb093_familia_producto"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "de_clase_producto"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "id_tb093_familia_producto"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");

     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb092_clase_producto = Tb092ClaseProductoPeer::retrieveByPk($codigo);
     }else{
         $tb092_clase_producto = new Tb092ClaseProducto();
     }
     try
      {
        $con->beginTransaction();

        $tb092_clase_productoForm = $this->getRequestParameter('tb092_clase_producto');
/*CAMPOS*/
 
        /*Campo tipo VARCHAR */
        $tb092_clase_producto->setDeClaseProducto(strtoupper($tb092_clase_productoForm["de_clase_producto"]));

        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb092_clase_productoForm)){
            $tb092_clase_producto->setInActivo(false);
        }else{
            $tb092_clase_producto->setInActivo(true);
        }

      
        /*Campo tipo BIGINT */
    //    $tb092_clase_producto->setIdTb093FamiliaProducto($tb092_clase_productoForm["id_tb093_familia_producto"]);

        /*CAMPOS*/
        $tb092_clase_producto->save($con);
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
	$tb092_clase_producto = Tb092ClaseProductoPeer::retrieveByPk($codigo);
	$tb092_clase_producto->delete($con);
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
                $de_clase_producto      =   $this->getRequestParameter("de_clase_producto");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $id_tb093_familia_producto      =   $this->getRequestParameter("id_tb093_familia_producto");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($de_clase_producto!=""){$c->add(Tb092ClaseProductoPeer::DE_CLASE_PRODUCTO,'%'.$de_clase_producto.'%',Criteria::LIKE);}



        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb092ClaseProductoPeer::created_at,$fecha);
    }

        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb092ClaseProductoPeer::updated_at,$fecha);
    }
                                            if($id_tb093_familia_producto!=""){$c->add(Tb092ClaseProductoPeer::ID_TB093_FAMILIA_PRODUCTO,$id_tb093_familia_producto);}

                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb092ClaseProductoPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb092ClaseProductoPeer::DE_CLASE_PRODUCTO);
        $c->addSelectColumn(Tb092ClaseProductoPeer::ID);
        $c->addSelectColumn(Tb092ClaseProductoPeer::DE_CLASE_PRODUCTO);
//        $c->addSelectColumn(Tb093FamiliaProductoPeer::DE_FAMILIA_PRODUCTO);
//        $c->addJoin(Tb093FamiliaProductoPeer::ID, Tb092ClaseProductoPeer::ID_TB093_FAMILIA_PRODUCTO);

    $stmt = Tb092ClaseProductoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "de_clase_producto"     => trim($res["de_clase_producto"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "id_tb093_familia_producto"     => trim($res["de_familia_producto"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                    //modelo fk tb093_familia_producto.ID
    public function executeStorefkidtb093familiaproducto(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb093FamiliaProductoPeer::doSelectStmt($c);
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
