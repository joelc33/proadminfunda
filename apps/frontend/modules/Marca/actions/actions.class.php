<?php

/**
 * Marca actions.
 *
 * @package    gobel
 * @subpackage Marca
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class MarcaActions extends sfActions
{
public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Marca', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Marca', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb174MarcaPeer::CO_MARCA,$codigo);

        $stmt = Tb174MarcaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_marca"     => $campos["co_marca"],
                            "tx_marca"     => $campos["tx_marca"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_marca"     => "",
                            "tx_marca"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_marca");

     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb174_marca = Tb174MarcaPeer::retrieveByPk($codigo);
     }else{
         $tb174_marca = new Tb174Marca();
     }
     try
      {
        $con->beginTransaction();

        $tb174_Marca_Form = $this->getRequestParameter('tb174_marca');
/*CAMPOS*/
 
        /*Campo tipo VARCHAR */
        $tb174_marca->setTxMarca(strtoupper($tb174_Marca_Form["tx_marca"]));

        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb174_Marca_Form)){
            $tb174_marca->setInActivo(false);
        }else{
            $tb174_marca->setInActivo(true);
        }

      
        /*Campo tipo BIGINT */
    //    $tb092_clase_producto->setIdTb093FamiliaProducto($tb092_clase_productoForm["id_tb093_familia_producto"]);

        /*CAMPOS*/
        $tb174_marca->save($con);
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
	$codigo = $this->getRequestParameter("co_marca");
	$con = Propel::getConnection();
	try
	{
	$con->beginTransaction();
	/*CAMPOS*/
	$tb174_marca = Tb174MarcaPeer::retrieveByPk($codigo);
	$tb174_marca->delete($con);
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
            $tx_marca      =   $this->getRequestParameter("tx_marca");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_marca!=""){$c->add(Tb174MarcaPeer::TX_MARCA,'%'.$tx_marca.'%',Criteria::LIKE);}



        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb174MarcaPeer::created_at,$fecha);
    }

        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb174MarcaPeer::updated_at,$fecha);
    }
                               

                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb174MarcaPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb174MarcaPeer::TX_MARCA);
        $c->addSelectColumn(Tb174MarcaPeer::CO_MARCA);
        $c->addSelectColumn(Tb174MarcaPeer::TX_MARCA);
        $c->addSelectColumn(Tb174MarcaPeer::IN_ACTIVO);
        $c->addSelectColumn(Tb174MarcaPeer::CREATED_AT);
        $c->addSelectColumn(Tb174MarcaPeer::UPDATED_AT);
//        $c->addSelectColumn(Tb093FamiliaProductoPeer::DE_FAMILIA_PRODUCTO);
//        $c->addJoin(Tb093FamiliaProductoPeer::ID, Tb092ClaseProductoPeer::ID_TB093_FAMILIA_PRODUCTO);

    $stmt = Tb174MarcaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_marca"     => trim($res["co_marca"]),
            "tx_marca"     => trim($res["tx_marca"]),
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

                                                                    //modelo fk tb093_familia_producto.ID
    public function executeStorefkcomarca(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb174MarcaPeer::doSelectStmt($c);
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
