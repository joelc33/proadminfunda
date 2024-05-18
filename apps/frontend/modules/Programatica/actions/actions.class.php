<?php

/**
 * autoProgramatica actions.
 * NombreClaseModel(Tb018Sector)
 * NombreTabla(tb018_sector)
 * @package    ##PROJECT_NAME##
 * @subpackage autoProgramatica
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class ProgramaticaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Programatica', 'lista');
  }
  
  public function executePresupuesto(sfWebRequest $request)
  {
    
  }
  

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Programatica', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tb018SectorPeer::CO_SECTOR,$codigo);
        
        $stmt = Tb018SectorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_sector"     => $campos["co_sector"],
                            "nu_sector"     => $campos["nu_sector"],
                            "tx_denominacion"     => $campos["tx_denominacion"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_sector"     => "",
                            "nu_sector"     => "",
                            "tx_denominacion"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_sector");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb018_sector = Tb018SectorPeer::retrieveByPk($codigo);
     }else{
         $tb018_sector = new Tb018Sector();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb018_sectorForm = $this->getRequestParameter('tb018_sector');
        $tb018_sector->setNuSector($tb018_sectorForm["nu_sector"]);
        $tb018_sector->setTxDenominacion($tb018_sectorForm["tx_denominacion"]);
                                
        /*CAMPOS*/
        $tb018_sector->save($con);
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
	$codigo = $this->getRequestParameter("co_sector");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb018_sector = Tb018SectorPeer::retrieveByPk($codigo);			
	$tb018_sector->delete($con);
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
    
    $nu_sector      =   $this->getRequestParameter("nu_sector");
    $tx_denominacion      =   $this->getRequestParameter("tx_denominacion");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($nu_sector!=""){$c->add(Tb018SectorPeer::nu_sector,'%'.$nu_sector.'%',Criteria::LIKE);}
        
                                        if($tx_denominacion!=""){$c->add(Tb018SectorPeer::tx_denominacion,'%'.$tx_denominacion.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb018SectorPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb018SectorPeer::CO_SECTOR);
        
    $stmt = Tb018SectorPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_sector"     => trim($res["co_sector"]),
            "nu_sector"     => trim($res["nu_sector"]),
            "tx_denominacion"     => trim($res["tx_denominacion"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                


}