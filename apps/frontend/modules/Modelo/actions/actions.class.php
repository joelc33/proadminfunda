<?php

/**
 * Modelo actions.
 *
 * @package    gobel
 * @subpackage Modelo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class ModeloActions extends sfActions
{
public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Modelo', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Modelo', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb175ModeloPeer::CO_MODELO,$codigo);

        $stmt = Tb175ModeloPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_modelo"     => $campos["co_modelo"],
                            "co_marca"     => $campos["co_marca"],
                             "tx_modelo"     => $campos["tx_modelo"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_modelo"     => "",
                            "tx_modelo"     => "",
                            "tx_marca"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_modelo");
            $co_marca = $this->getRequestParameter("list_marca");


     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb175_modelo = Tb175ModeloPeer::retrieveByPk($codigo);
     }else{
         $tb175_modelo = new Tb175Modelo();
     }
     try
      {
        $con->beginTransaction();

        $tb175_modelo_form = $this->getRequestParameter('tb175_modelo');
        $tb174_marca_form=$this->getRequestParameter('tb174_marca');
/*CAMPOS*/
 
        /*Campo tipo VARCHAR */
        $tb175_modelo->setTxModelo(strtoupper($tb175_modelo_form["tx_modelo"]));
		$tb175_modelo->setCoMarca($tb174_marca_form["co_marca"]);
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb175_modelo_form)){
            $tb175_modelo->setInActivo(false);
        }else{
            $tb175_modelo->setInActivo(true);
        }

      
        /*Campo tipo BIGINT */
    //    $tb092_clase_producto->setIdTb093FamiliaProducto($tb092_clase_productoForm["id_tb093_familia_producto"]);

        /*CAMPOS*/
        $tb175_modelo->save($con);
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
	$codigo = $this->getRequestParameter("co_modelo");
	$con = Propel::getConnection();
	try
	{
	$con->beginTransaction();
	/*CAMPOS*/
	$tb175_modelo = Tb175ModeloPeer::retrieveByPk($codigo);
	$tb175_modelo->delete($con);
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
            $tx_modelo      =   $this->getRequestParameter("tx_modelo");
            $co_marca      =   $this->getRequestParameter("list_marca");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){

    if($tx_modelo!=""){$c->add(Tb175ModeloPeer::TX_MODELO,'%'.$tx_modelo.'%',Criteria::LIKE);}
    if($co_marca!=""){$c->add(Tb175ModeloPeer::CO_MARCA,$co_marca);}



        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb175ModeloPeer::created_at,$fecha);
    }

        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb175ModeloPeer::updated_at,$fecha);
    }
                               

                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb174MarcaPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb174MarcaPeer::TX_MARCA);
         $c->addAscendingOrderByColumn(Tb175ModeloPeer::CO_MARCA);
        $c->addSelectColumn(Tb175ModeloPeer::CO_MODELO);
         $c->addSelectColumn(Tb175ModeloPeer::TX_MODELO);
        $c->addSelectColumn(Tb174MarcaPeer::TX_MARCA);
        $c->addSelectColumn(Tb175ModeloPeer::IN_ACTIVO);
        $c->addSelectColumn(Tb175ModeloPeer::CREATED_AT);
        $c->addSelectColumn(Tb175ModeloPeer::UPDATED_AT);
//        $c->addSelectColumn(Tb093FamiliaProductoPeer::DE_FAMILIA_PRODUCTO);
        $c->addJoin(Tb175ModeloPeer::CO_MARCA, Tb174MarcaPeer::CO_MARCA);

    $stmt = Tb175ModeloPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_modelo"     => trim($res["co_modelo"]),
            "co_marca"     => trim($res["co_marca"]),
            "tx_modelo"     => trim($res["tx_modelo"]),
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
