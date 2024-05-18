<?php

/**
 * autoItemCategoriaViatico actions.
 * NombreClaseModel(Tb119CategoriaItemViatico)
 * NombreTabla(tb119_categoria_item_viatico)
 * @package    ##PROJECT_NAME##
 * @subpackage autoItemCategoriaViatico
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class ItemCategoriaViaticoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ItemCategoriaViatico', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ItemCategoriaViatico', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb119CategoriaItemViaticoPeer::CO_CATEGORIA_ITEM_VIATICO,$codigo);
        
        $stmt = Tb119CategoriaItemViaticoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_categoria_item_viatico"     => $campos["co_categoria_item_viatico"],
                            "co_categoria"     => $campos["co_categoria"],
                            "co_item_viatico"     => $campos["co_item_viatico"],
                            "cant_ut"     => $campos["cant_ut"],
                            "co_tipo_viatico"     => $campos["co_tipo_viatico"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_categoria_item_viatico"     => "",
                            "co_categoria"     => "",
                            "co_item_viatico"     => "",
                            "cant_ut"     => "",
                            "co_tipo_viatico"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_categoria_item_viatico");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb119_categoria_item_viatico = Tb119CategoriaItemViaticoPeer::retrieveByPk($codigo);
     }else{
         $tb119_categoria_item_viatico = new Tb119CategoriaItemViatico();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb119_categoria_item_viaticoForm = $this->getRequestParameter('tb119_categoria_item_viatico');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb119_categoria_item_viatico->setCoCategoria($tb119_categoria_item_viaticoForm["co_categoria"]);
                                                        
        /*Campo tipo BIGINT */
        $tb119_categoria_item_viatico->setCoItemViatico($tb119_categoria_item_viaticoForm["co_item_viatico"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb119_categoria_item_viatico->setCantUt($tb119_categoria_item_viaticoForm["cant_ut"]);
                                                        
        /*Campo tipo BIGINT */
        $tb119_categoria_item_viatico->setCoTipoViatico($tb119_categoria_item_viaticoForm["co_tipo_viatico"]);
                                
        /*CAMPOS*/
        $tb119_categoria_item_viatico->save($con);
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
	$codigo = $this->getRequestParameter("co_categoria_item_viatico");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb119_categoria_item_viatico = Tb119CategoriaItemViaticoPeer::retrieveByPk($codigo);			
	$tb119_categoria_item_viatico->delete($con);
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
    
    $co_categoria      =   $this->getRequestParameter("co_categoria");
    $co_item_viatico      =   $this->getRequestParameter("co_item_viatico");
    $cant_ut      =   $this->getRequestParameter("cant_ut");
    $co_tipo_viatico      =   $this->getRequestParameter("co_tipo_viatico");
    
    
    $c = new Criteria();   
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb119CategoriaItemViaticoPeer::CO_CATEGORIA_ITEM_VIATICO);
    $c->addSelectColumn(Tb119CategoriaItemViaticoPeer::CANT_UT);
    $c->addSelectColumn(Tb113CategoriaPeer::TX_CATEGORIA);
    $c->addSelectColumn(Tb107TipoViaticoPeer::TX_TIPO_VIATICO);
    $c->addSelectColumn(Tb114ItemViaticoPeer::TX_ITEM_VIATICO);
    
    $c->addJoin(Tb119CategoriaItemViaticoPeer::CO_CATEGORIA, Tb113CategoriaPeer::CO_CATEGORIA);
    $c->addJoin(Tb119CategoriaItemViaticoPeer::CO_TIPO_VIATICO, Tb107TipoViaticoPeer::CO_TIPO_VIATICO);
    $c->addJoin(Tb119CategoriaItemViaticoPeer::CO_ITEM_VIATICO,  Tb114ItemViaticoPeer::CO_ITEM_VIATICO);
    
   
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb119CategoriaItemViaticoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb119CategoriaItemViaticoPeer::CO_CATEGORIA_ITEM_VIATICO);
        
    $stmt = Tb119CategoriaItemViaticoPeer::doSelectStmt($c);
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

                    //modelo fk tb113_categoria.CO_CATEGORIA
    public function executeStorefkcocategoria(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb113CategoriaPeer::doSelectStmt($c);
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
                    //modelo fk tb114_item_viatico.CO_ITEM_VIATICO
    public function executeStorefkcoitemviatico(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb114ItemViaticoPeer::CO_TIPO_VIATICO,$this->getRequestParameter("co_tipo_viatico"));
        $stmt = Tb114ItemViaticoPeer::doSelectStmt($c);
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
                                //modelo fk tb107_tipo_viatico.CO_TIPO_VIATICO
    public function executeStorefkcotipoviatico(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb107TipoViaticoPeer::doSelectStmt($c);
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