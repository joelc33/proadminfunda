<?php

/**
 * autoTramite actions.
 * NombreClaseModel(Tb027TipoSolicitud)
 * NombreTabla(tb027_tipo_solicitud)
 * @package    ##PROJECT_NAME##
 * @subpackage autoTramite
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class TramiteActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Tramite', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Tramite', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD,$codigo);
        
        $stmt = Tb027TipoSolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                            "tx_tipo_solicitud"     => $campos["tx_tipo_solicitud"],
                            "in_ver"     => $campos["in_ver"],
                            "co_proceso"     => $campos["co_proceso"],
                            "co_tipo_documento"     => $campos["id_136_tipo_documento"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_tipo_solicitud"     => "",
                            "tx_tipo_solicitud"     => "",
                            "in_ver"     => "",
                            "co_proceso"     => "",
                            "co_tipo_documento"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_tipo_solicitud");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb027_tipo_solicitud = Tb027TipoSolicitudPeer::retrieveByPk($codigo);
     }else{
         $tb027_tipo_solicitud = new Tb027TipoSolicitud();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb027_tipo_solicitudForm = $this->getRequestParameter('tb027_tipo_solicitud');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb027_tipo_solicitud->setTxTipoSolicitud($tb027_tipo_solicitudForm["tx_tipo_solicitud"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_ver", $tb027_tipo_solicitudForm)){
            $tb027_tipo_solicitud->setInVer(true);
        }else{
            $tb027_tipo_solicitud->setInVer(false);
        }
                                                        
        /*Campo tipo BIGINT */
        $tb027_tipo_solicitud->setCoProceso($tb027_tipo_solicitudForm["co_proceso"]);
        
        if($tb027_tipo_solicitudForm["co_tipo_documento"])
        $tb027_tipo_solicitud->setId136TipoDocumento($tb027_tipo_solicitudForm["co_tipo_documento"]);
                                
        /*CAMPOS*/
        $tb027_tipo_solicitud->save($con);
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
	$codigo = $this->getRequestParameter("co_tipo_solicitud");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb027_tipo_solicitud = Tb027TipoSolicitudPeer::retrieveByPk($codigo);			
	$tb027_tipo_solicitud->delete($con);
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
    
    $tx_tipo_solicitud   =   $this->getRequestParameter("tx_tipo_solicitud");
    $in_ver              =   $this->getRequestParameter("in_ver");
    $co_proceso          =   $this->getRequestParameter("co_proceso");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
         if($tx_tipo_solicitud!=""){$c->add(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD,'%'.$tx_tipo_solicitud.'%',Criteria::LIKE);}
         if($co_proceso!=""){$c->add(Tb027TipoSolicitudPeer::CO_PROCESO,$co_proceso);}
    }
    
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb027TipoSolicitudPeer::doCount($c);
    
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::IN_VER);
    $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
    $c->addJoin(Tb027TipoSolicitudPeer::CO_PROCESO, Tb028ProcesoPeer::CO_PROCESO);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        
    $stmt = Tb027TipoSolicitudPeer::doSelectStmt($c);
    $registros = "";
    
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        if($res["in_ver"]==1){
            $estado = 'SI';
        }else{
            $estado = 'NO';
        }
        
        $registros[] = array(
            "co_tipo_solicitud"     => trim($res["co_tipo_solicitud"]),
            "tx_tipo_solicitud"     => trim($res["tx_tipo_solicitud"]),
            "in_ver"                => trim($estado),
            "tx_proceso"            => trim($res["tx_proceso"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                            //modelo fk tb028_proceso.CO_PROCESO
    public function executeStorefkcoproceso(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb028ProcesoPeer::doSelectStmt($c);
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
        
    public function executeStorefkcotipodocumento(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb136TipoDocumentoPeer::doSelectStmt($c);
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