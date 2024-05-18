<?php

/**
 * autoInicio actions.
 * NombreClaseModel(Tb004Menu)
 * NombreTabla(tb004_menu)
 * @package    ##PROJECT_NAME##
 * @subpackage autoInicio
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoInicioActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('inicio', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('inicio', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb004MenuPeer::CO_MENU,$codigo);
        
        $stmt = Tb004MenuPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_menu"     => $campos["co_menu"],
                            "tx_menu"     => $campos["tx_menu"],
                            "co_padre"     => $campos["co_padre"],
                            "tx_href"     => $campos["tx_href"],
                            "nu_orden"     => $campos["nu_orden"],
                            "tx_icono"     => $campos["tx_icono"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_menu"     => "",
                            "tx_menu"     => "",
                            "co_padre"     => "",
                            "tx_href"     => "",
                            "nu_orden"     => "",
                            "tx_icono"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_menu");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb004_menu = Tb004MenuPeer::retrieveByPk($codigo);
     }else{
         $tb004_menu = new Tb004Menu();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb004_menuForm = $this->getRequestParameter('tb004_menu');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb004_menu->setTxMenu($tb004_menuForm["tx_menu"]);
                                                        
        /*Campo tipo BIGINT */
        $tb004_menu->setCoPadre($tb004_menuForm["co_padre"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb004_menu->setTxHref($tb004_menuForm["tx_href"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb004_menu->setNuOrden($tb004_menuForm["nu_orden"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb004_menu->setTxIcono($tb004_menuForm["tx_icono"]);
                                
        /*CAMPOS*/
        $tb004_menu->save($con);
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
	$codigo = $this->getRequestParameter("co_menu");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb004_menu = Tb004MenuPeer::retrieveByPk($codigo);			
	$tb004_menu->delete($con);
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
                $tx_menu      =   $this->getRequestParameter("tx_menu");
            $co_padre      =   $this->getRequestParameter("co_padre");
            $tx_href      =   $this->getRequestParameter("tx_href");
            $nu_orden      =   $this->getRequestParameter("nu_orden");
            $tx_icono      =   $this->getRequestParameter("tx_icono");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_menu!=""){$c->add(Tb004MenuPeer::tx_menu,'%'.$tx_menu.'%',Criteria::LIKE);}
        
                                            if($co_padre!=""){$c->add(Tb004MenuPeer::co_padre,$co_padre);}
    
                                        if($tx_href!=""){$c->add(Tb004MenuPeer::tx_href,'%'.$tx_href.'%',Criteria::LIKE);}
        
                                            if($nu_orden!=""){$c->add(Tb004MenuPeer::nu_orden,$nu_orden);}
    
                                        if($tx_icono!=""){$c->add(Tb004MenuPeer::tx_icono,'%'.$tx_icono.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb004MenuPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb004MenuPeer::CO_MENU);
        
    $stmt = Tb004MenuPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_menu"     => trim($res["co_menu"]),
            "tx_menu"     => trim($res["tx_menu"]),
            "co_padre"     => trim($res["co_padre"]),
            "tx_href"     => trim($res["tx_href"]),
            "nu_orden"     => trim($res["nu_orden"]),
            "tx_icono"     => trim($res["tx_icono"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                    


}