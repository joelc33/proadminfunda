<?php

/**
 * autoPrograma actions.
 * NombreClaseModel(Tb019Programa)
 * NombreTabla(tb019_programa)
 * @package    ##PROJECT_NAME##
 * @subpackage autoPrograma
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class ProgramaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Programa', 'lista');
  }
  
  public function executePresupuesto(sfWebRequest $request)
  {
        $this->data = json_encode(array(
            "co_sector" => $this->getRequestParameter("co_sector")
        ));
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Programa', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tb019ProgramaPeer::CO_PROGRAMA,$codigo);
        
        $stmt = Tb019ProgramaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_programa"     => $campos["co_programa"],
                            "co_sector"     => $campos["co_sector"],
                            "nu_programa"     => $campos["nu_programa"],
                            "tx_denominacion"     => $campos["tx_denominacion"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_programa"     => "",
                            "co_sector"       => $this->getRequestParameter("co_sector"),
                            "nu_programa"     => "",
                            "tx_denominacion" => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_programa");
     $tb019_programaForm = $this->getRequestParameter('tb019_programa');
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb019_programa = Tb019ProgramaPeer::retrieveByPk($codigo);
     }else{
        $tb019_programa = new Tb019Programa();
         
        $c = new Criteria();
        $c->add(Tb019ProgramaPeer::NU_PROGRAMA,$tb019_programaForm["nu_programa"]);
        $c->add(Tb019ProgramaPeer::CO_SECTOR,$tb019_programaForm["co_sector"]);
        $cantidad = Tb019ProgramaPeer::doCount($c);
        
             
        if($cantidad>0){
            $stmt = Tb019ProgramaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $msg = "El programa N° <b>".$tb019_programaForm["nu_programa"]."</b> ya se encuentra registrado a la denominación <b>".$campos["tx_denominacion"]."</b>";
            
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $msg
            ));
            
            return 0;
            
        }
         
         
     }
     try
      { 
        $con->beginTransaction();
       
        
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb019_programa->setCoSector($tb019_programaForm["co_sector"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb019_programa->setNuPrograma($tb019_programaForm["nu_programa"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb019_programa->setTxDenominacion($tb019_programaForm["tx_denominacion"]);
                                
        /*CAMPOS*/
        $tb019_programa->save($con);
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
	$codigo = $this->getRequestParameter("co_programa");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb019_programa = Tb019ProgramaPeer::retrieveByPk($codigo);			
	$tb019_programa->delete($con);
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
                $this->data = json_encode(array(
                    "co_sector" => $this->getRequestParameter("co_sector")
                ));
  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",12);
    $start      =   $this->getRequestParameter("start",0);
    
    $co_sector      =   $this->getRequestParameter("co_sector");
    $nu_programa      =   $this->getRequestParameter("nu_programa");
    $tx_denominacion      =   $this->getRequestParameter("tx_denominacion");
    
    
    $c = new Criteria();   

  
    if($co_sector!=""){$c->add(Tb019ProgramaPeer::CO_SECTOR,$co_sector);}

    if($nu_programa!=""){$c->add(Tb019ProgramaPeer::NU_PROGRAMA,'%'.$nu_programa.'%',Criteria::LIKE);}

    if($tx_denominacion!=""){$c->add(Tb019ProgramaPeer::TX_DENOMINACION,'%'.$tx_denominacion.'%',Criteria::LIKE);}

                    
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb019ProgramaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb019ProgramaPeer::CO_PROGRAMA);
        
    $stmt = Tb019ProgramaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_programa"     => trim($res["co_programa"]),
            "co_sector"     => trim($res["co_sector"]),
            "nu_programa"     => trim($res["nu_programa"]),
            "tx_denominacion"     => trim($res["tx_denominacion"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb018_sector.CO_SECTOR
    public function executeStorefkcosector(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb018SectorPeer::doSelectStmt($c);
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