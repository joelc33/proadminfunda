<?php

/**
 * autoRol actions.
 * NombreClaseModel(Tb003Rol)
 * NombreTabla(tb003_rol)
 * @package    ##PROJECT_NAME##
 * @subpackage autoRol
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class RolActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Rol', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Rol', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb003RolPeer::CO_ROL,$codigo);
        
        $stmt = Tb003RolPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_rol"     => $campos["co_rol"],
                            "tx_rol"     => $campos["tx_rol"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_rol"     => "",
                            "tx_rol"     => "",
                    ));
    }

  }

    public function executeEditarRolMenu(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb003RolPeer::CO_ROL,$codigo);
        
        $stmt = Tb003RolPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_rol"     => $campos["co_rol"],
                            "tx_rol"     => $campos["tx_rol"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_rol"     => "",
                            "tx_rol"     => "",
                    ));
    }
    
     $this->menu = Tb004MenuPeer::ArmaMenuPrivilegio($this->getRequestParameter('codigo'));
      $this->co_rol = $this->getRequestParameter('codigo');

  }
  
  public function executeGuardar(sfWebRequest $request)
  {
	$json  = json_decode($this->getRequestParameter('arreglo'),true);
	$opciones = $json['opcion'];
            $codigo = $this->getRequestParameter("co_rol");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb003_rol = Tb003RolPeer::retrieveByPk($codigo);
             try
      { 
        $con->beginTransaction();
       
        $tb003_rolForm = $this->getRequestParameter('tb003_rol');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb003_rol->setTxRol($tb003_rolForm["tx_rol"]);
                                
        /*CAMPOS*/
        $tb003_rol->save($con);
        
                  /*habilita los padres*/
          $data = '';
          $stmt = $con->prepare("update tb005_rol_menu
                                    set in_ver = true
                                  where co_rol_menu in(
                                         select co_rol_menu from vista_rolmenu where co_rol = $codigo and cant > 0)");
          $stmt->execute();

          /*desabilitan todos los hijos*/
          $data = '';
          $stmt2 = $con->prepare("update tb005_rol_menu
                                    set in_ver = false
                                  where co_rol_menu in(
                                         select co_rol_menu from vista_rolmenu where co_rol = $codigo and cant = 0)");
          $stmt2->execute();

	foreach ($opciones as $lista){
		$menu = Tb005RolMenuPeer::retrieveByPK($lista);
		$menu->setInVer(true)->save($con);
	}
        
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
         $tb003_rol = new Tb003Rol();
         
    try
      { 
        $con->beginTransaction();
       
        $tb003_rolForm = $this->getRequestParameter('tb003_rol');
/*CAMPOS*/
        $c = new Criteria();
        $c->add(Tb003RolPeer::TX_ROL,$tb003_rolForm["tx_rol"]);
        $c->setIgnoreCase(true);
        $cantidadTotal = Tb003RolPeer::doCount($c);
        
        if($cantidadTotal>0){
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  'El Rol '.$tb003_rolForm["tx_rol"].' ya se encuentra registrado.'
            ));
            
            return;
        }                                
        /*Campo tipo VARCHAR */
        $tb003_rol->setTxRol($tb003_rolForm["tx_rol"]);
                                
        /*CAMPOS*/
        $tb003_rol->save($con);
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Proceso realizado exitosamente'
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
	$codigo = $this->getRequestParameter("co_rol");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb003_rol = Tb003RolPeer::retrieveByPk($codigo);			
	$tb003_rol->delete($con);
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
                $tx_rol      =   $this->getRequestParameter("tx_rol");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_rol!=""){$c->add(Tb003RolPeer::tx_rol,'%'.$tx_rol.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb003RolPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb003RolPeer::CO_ROL);
        
    $stmt = Tb003RolPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_rol"     => trim($res["co_rol"]),
            "tx_rol"     => trim($res["tx_rol"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    


}