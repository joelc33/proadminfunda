<?php

/**
 * autoProducto actions.
 * NombreClaseModel(Tb048Producto)
 * NombreTabla(tb048_producto)
 * @package    ##PROJECT_NAME##
 * @subpackage autoProducto
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class ProductoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Producto', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Producto', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb048ProductoPeer::CO_PRODUCTO,$codigo);
        
        $stmt = Tb048ProductoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_producto"     => $campos["co_producto"],
                            "tx_producto"     => $campos["tx_producto"],
                            "cod_producto"     => $campos["cod_producto"],
                            "co_clase"     => $campos["co_clase"],
                            "co_unidad_producto"     => $campos["co_unidad_producto"],
                            "in_ver"     => $campos["in_ver"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_producto"     => "",
                            "tx_producto"     => "",
                            "cod_producto"     => "",
                            "co_clase"     => "",
                            "co_unidad_producto"     => "",
                            "in_ver"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_producto");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb048_producto = Tb048ProductoPeer::retrieveByPk($codigo);
         
     try
      { 
        $con->beginTransaction();
        
       
        $tb048_productoForm = $this->getRequestParameter('tb048_producto');
/*CAMPOS*/
        $c = new Criteria();       
        $c->setIgnoreCase(true);
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb092ClaseProductoPeer::ID);
        $c->addJoin(Tb048ProductoPeer::CO_CLASE,  Tb092ClaseProductoPeer::ID);
        $c->add(Tb048ProductoPeer::CO_CLASE,$tb048_productoForm["co_clase"]);
        $cantidadTotal = Tb048ProductoPeer::doCount($c); 
        $stmt = Tb048ProductoPeer::doSelectStmt($c);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $co_producto = $res["id"].str_pad($cantidadTotal+1,2,"0",STR_PAD_LEFT);
        /*Campo tipo VARCHAR */
        $tb048_producto->setTxProducto(strtoupper($tb048_productoForm["tx_producto"]));
        if($tb048_productoForm["co_clase"]!=$tb048_producto->getCoClase()){                                                
        /*Campo tipo VARCHAR */
        $tb048_producto->setCodProducto($co_producto);
        }                                                
        /*Campo tipo BIGINT */
        $tb048_producto->setCoClase($tb048_productoForm["co_clase"]);
                                                        
                                                       
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_ver", $tb048_productoForm)){
            $tb048_producto->setInVer(false);
        }else{
            $tb048_producto->setInVer(true);
        }
                                
        /*CAMPOS*/
        $tb048_producto->save($con);
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
         
         
         
     }else{
         
         
    $tb048_producto = new Tb048Producto();
         
     try
      { 
        $con->beginTransaction();
        
       
        $tb048_productoForm = $this->getRequestParameter('tb048_producto');
/*CAMPOS*/
        $c = new Criteria();       
        $c->setIgnoreCase(true);
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
        $c->addSelectColumn(Tb092ClaseProductoPeer::ID);
        $c->addJoin(Tb048ProductoPeer::CO_CLASE,  Tb092ClaseProductoPeer::ID);
        $c->add(Tb048ProductoPeer::CO_CLASE,$tb048_productoForm["co_clase"]);
        $cantidadTotal = Tb048ProductoPeer::doCount($c); 
        $c->setLimit(1)->setOffset(0);
        $c->addDescendingOrderByColumn(Tb048ProductoPeer::CO_PRODUCTO);        
        $stmt = Tb048ProductoPeer::doSelectStmt($c);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $co_producto = $tb048_productoForm["co_clase"].str_pad(substr($res["cod_producto"], -2)+1,3,"0",STR_PAD_LEFT);
        /*Campo tipo VARCHAR */
        $tb048_producto->setTxProducto(strtoupper($tb048_productoForm["tx_producto"]));
                                                        
        /*Campo tipo VARCHAR */
        $tb048_producto->setCodProducto($co_producto);
                                                        
        /*Campo tipo BIGINT */
        $tb048_producto->setCoClase($tb048_productoForm["co_clase"]);
                                                        
                                                       
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_ver", $tb048_productoForm)){
            $tb048_producto->setInVer(false);
        }else{
            $tb048_producto->setInVer(true);
        }
                                
        /*CAMPOS*/
        $tb048_producto->save($con);
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

    }
  

  public function executeEliminar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_producto");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb048_producto = Tb048ProductoPeer::retrieveByPk($codigo);			
	$tb048_producto->delete($con);
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
                $tx_producto      =   $this->getRequestParameter("tx_producto");
            $cod_producto      =   $this->getRequestParameter("cod_producto");
            $co_clase      =   $this->getRequestParameter("co_clase");
            $co_unidad_producto      =   $this->getRequestParameter("co_unidad_producto");
            $in_ver      =   $this->getRequestParameter("in_ver");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
        if($tx_producto!=""){$c->add(Tb048ProductoPeer::TX_PRODUCTO,'%'.$tx_producto.'%',Criteria::LIKE);}

        if($cod_producto!=""){$c->add(Tb048ProductoPeer::COD_PRODUCTO,'%'.$cod_producto.'%',Criteria::LIKE);}

        if($co_clase!=""){$c->add(Tb048ProductoPeer::CO_CLASE,$co_clase);}
        
    }
    
    $c->setIgnoreCase(true);
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb048ProductoPeer::COD_PRODUCTO);
    $c->addSelectColumn(Tb048ProductoPeer::CO_PRODUCTO);
    $c->addSelectColumn(Tb048ProductoPeer::TX_PRODUCTO);
    $c->addSelectColumn(Tb092ClaseProductoPeer::DE_CLASE_PRODUCTO);
    $c->addJoin(Tb048ProductoPeer::CO_CLASE,  Tb092ClaseProductoPeer::ID); 
    
        
    $cantidadTotal = Tb048ProductoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb048ProductoPeer::CO_PRODUCTO);
        
    $stmt = Tb048ProductoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
         $registros[] = $res;
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                            //modelo fk tb092_clase_producto.ID
    public function executeStorefkcoclase(sfWebRequest $request){
        $c = new Criteria();
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
                    //modelo fk tb057_unidad_producto.CO_UNIDAD_PRODUCTO
    public function executeStorefkcounidadproducto(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb057UnidadProductoPeer::doSelectStmt($c);
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