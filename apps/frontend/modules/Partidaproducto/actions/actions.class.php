<?php

/**
 * Partidaproducto actions.
 *
 * @package    gobel
 * @subpackage Partidaproducto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class PartidaproductoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Partidaproducto', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Partidaproducto', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb094PartidaProductoPeer::ID,$codigo);

        $stmt = Tb094PartidaProductoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "nu_partida"     => $campos["nu_partida"],
                            "id_tb092_clase_producto"     => $campos["id_tb092_clase_producto"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "nu_partida"     => "",
                            "id_tb092_clase_producto"     => "",
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
         $tb094_partida_producto = Tb094PartidaProductoPeer::retrieveByPk($codigo);
     }else{
         $tb094_partida_producto = new Tb094PartidaProducto();
     }
     try
      {
        $con->beginTransaction();

        $tb094_partida_productoForm = $this->getRequestParameter('tb094_partida_producto');
/*CAMPOS*/

        /*Campo tipo VARCHAR */
        $tb094_partida_producto->setNuPartida($tb094_partida_productoForm["nu_partida"]);

        /*Campo tipo BIGINT */
        $tb094_partida_producto->setIdTb092ClaseProducto($tb094_partida_productoForm["id_tb092_clase_producto"]);

        /*Campo tipo BOOLEAN */
        $tb094_partida_producto->setInActivo(true);

        /*Campo tipo TIMESTAMP */
        $fecha = date("Y-m-d H:i:s");
        $tb094_partida_producto->setCreatedAt($fecha);

        /*Campo tipo TIMESTAMP */
        $tb094_partida_producto->setUpdatedAt($fecha);

        /*CAMPOS*/
        $tb094_partida_producto->save($con);
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
	$tb094_partida_producto = Tb094PartidaProductoPeer::retrieveByPk($codigo);
	$tb094_partida_producto->delete($con);
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
    
    $nu_partida      =   $this->getRequestParameter("nu_partida");
    $co_producto      =   $this->getRequestParameter("co_producto");
    $in_activo      =   $this->getRequestParameter("in_activo");
    $created_at      =   $this->getRequestParameter("created_at");
    $updated_at      =   $this->getRequestParameter("updated_at");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
        if($nu_partida!=""){$c->add(Tb094PartidaProductoPeer::NU_PARTIDA,'%'.$nu_partida.'%',Criteria::LIKE);}
    }
    
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb094PartidaProductoPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb094PartidaProductoPeer::ID);

        $c->clearSelectColumns();
        $c->addSelectColumn(Tb094PartidaProductoPeer::ID);
        $c->addSelectColumn(Tb094PartidaProductoPeer::NU_PARTIDA);
        $c->addSelectColumn(Tb094PartidaProductoPeer::NU_PARTIDA);
        $c->addSelectColumn(Tb091PartidaPeer::DE_PARTIDA);
        $c->addSelectColumn(Tb092ClaseProductoPeer::DE_CLASE_PRODUCTO);
        $c->addJoin(Tb092ClaseProductoPeer::ID, Tb094PartidaProductoPeer::ID_TB092_CLASE_PRODUCTO);
        $c->addJoin(Tb091PartidaPeer::NU_PARTIDA, Tb094PartidaProductoPeer::NU_PARTIDA);

    $stmt = Tb094PartidaProductoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "nu_partida"     => trim($res["nu_partida"]),
            "co_partida"     => trim($res["co_partida"]),
            "de_partida"     => trim($res["de_partida"]),
            "de_clase_producto"     => trim($res["de_clase_producto"]),
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
    

    public function executeStorefkidtb091partida(sfWebRequest $request){
        
        $cp = new Criteria();
        $cp->addAscendingOrderByColumn(Tb085PresupuestoPeer::NU_PARTIDA);
        $stmtp = Tb085PresupuestoPeer::doSelectStmt($cp);
        
        $c = new Criteria();
        
        while($regp = $stmtp->fetch(PDO::FETCH_ASSOC)){
             $array[] =  trim(substr($regp["nu_partida"], 0, 9));        
        }
        
        //$c->add(Tb091PartidaPeer::NU_PARTIDA,  $array, Criteria::IN);  
        
        $c->add(Tb091PartidaPeer::IN_MOVIMIENTO, TRUE);
        $c->addAscendingOrderByColumn(Tb091PartidaPeer::NU_PARTIDA);
        $stmt = Tb091PartidaPeer::doSelectStmt($c);
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
                                                                                    //modelo fk tb092_clase_producto.ID
        public function executeStorefkidtb092claseproducto(sfWebRequest $request){
            $c = new Criteria();
            $c->addAscendingOrderByColumn(Tb092ClaseProductoPeer::DE_CLASE_PRODUCTO);
            $stmt = Tb092ClaseProductoPeer::doSelectStmt($c);
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

        public function executeStorefkcoproducto(sfWebRequest $request) {

            $de_variable      =   $this->getRequestParameter("variable");

            $co_clase   =   $this->getRequestParameter("co_clase");

            $c = new Criteria();

            if($this->getRequestParameter("BuscarBy")=="true"){
                if($de_variable!=""){
                  $c->add(Tb048ProductoPeer::TX_PRODUCTO,'%'.$de_variable.'%',Criteria::ILIKE);
                }
            }

            $c->clearSelectColumns();
            $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
            $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
            $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
            $c->add(Tb048ProductoPeer::CO_CLASE,$co_clase);

            $cantidadTotal = Tb048ProductoPeer::doCount($c);

            $c->addAscendingOrderByColumn(Tb048ProductoPeer::TX_PRODUCTO);

            $stmt = Tb048ProductoPeer::doSelectStmt($c);
            $registros = array();
            while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
                $registros[] = $reg;
            }

            $this->data = json_encode(array(
                "success"   =>  true,
                "total"     =>  $cantidadTotal,
                "data"      =>  $registros
                ));

            $this->setTemplate('store');
        }

}
