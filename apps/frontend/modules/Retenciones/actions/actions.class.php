<?php

/**
 * autoRetenciones actions.
 * NombreClaseModel(Tb042Retencion)
 * NombreTabla(tb042_retencion)
 * @package    ##PROJECT_NAME##
 * @subpackage autoRetenciones
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class RetencionesActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Retenciones', 'lista');
  } 

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Retenciones', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb042RetencionPeer::CO_RETENCION,$codigo);
        
        $stmt = Tb042RetencionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_retencion"     => $campos["co_retencion"],
                            "co_documento"     => $campos["co_documento"],
                            "co_tipo_retencion"     => $campos["co_tipo_retencion"],
                            "nu_valor"     => $campos["nu_valor"],
                            "nu_sustraendo"     => $campos["nu_sustraendo"],
                            "co_ramo"     => $campos["co_ramo"],
                            "mo_minimo"     => $campos["mo_minimo"],
                            "de_concepto"     => $campos["de_concepto"],
                            "nu_concepto"     => $campos["nu_concepto"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_retencion"     => "",
                            "co_documento"     => "",
                            "co_tipo_retencion"     => $this->getRequestParameter("co_tipo_retencion"),
                            "nu_valor"     => "",
                            "nu_sustraendo"     => "",
                            "co_ramo"     => "",
                            "mo_minimo"     => "",
                            "de_concepto"     => "",
                            "nu_concepto"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_retencion");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb042_retencion = Tb042RetencionPeer::retrieveByPk($codigo);
     }else{
         $tb042_retencion = new Tb042Retencion();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb042_retencionForm = $this->getRequestParameter('tb042_retencion');
     
        $tb042_retencion->setCoDocumento($tb042_retencionForm["co_documento"]);
        $tb042_retencion->setCoTipoRetencion($tb042_retencionForm["co_tipo_retencion"]);
        $tb042_retencion->setNuValor(($tb042_retencionForm["nu_valor"]!='')?$tb042_retencionForm["nu_valor"]:NULL);
        $tb042_retencion->setNuSustraendo(($tb042_retencionForm["nu_sustraendo"]!='')?$tb042_retencionForm["nu_sustraendo"]:NULL);
        $tb042_retencion->setCoRamo(($tb042_retencionForm["co_ramo"]!='')?$tb042_retencionForm["co_ramo"]:NULL);
        $tb042_retencion->setMoMinimo(($tb042_retencionForm["mo_minimo"]!='')?$tb042_retencionForm["mo_minimo"]:NULL);

        /*Campo tipo VARCHAR */
        $tb042_retencion->setDeConcepto($tb042_retencionForm["de_concepto"]);
                                                
        /*Campo tipo VARCHAR */
        $tb042_retencion->setNuConcepto($tb042_retencionForm["nu_concepto"]);
   
        $tb042_retencion->save($con);
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
	$codigo = $this->getRequestParameter("co_retencion");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb042_retencion = Tb042RetencionPeer::retrieveByPk($codigo);			
	$tb042_retencion->delete($con);
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
        $co_tipo_retencion = $this->getRequestParameter("co_tipo_retencion");
        
        $this->data = json_encode(array(
                            "co_tipo_retencion"     => $co_tipo_retencion
                       ));
        
  }

  public function executeIslr(sfWebRequest $request)
  {
        $co_tipo_retencion = $this->getRequestParameter("co_tipo_retencion");
        
        $this->data = json_encode(array(
                            "co_tipo_retencion"     => $co_tipo_retencion
                       ));
        
  }
  
  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
    
    $co_tipo_retencion  =   $this->getRequestParameter("co_tipo_retencion");
  
    
    $c = new Criteria();   
    $c->add(Tb042RetencionPeer::CO_TIPO_RETENCION,$co_tipo_retencion);
      
    $c->setIgnoreCase(true);
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb007DocumentoPeer::TX_DOCUMENTO);
    $c->addSelectColumn(Tb041TipoRetencionPeer::TX_TIPO_RETENCION);
    $c->addSelectColumn(Tb042RetencionPeer::NU_VALOR);
    $c->addSelectColumn(Tb042RetencionPeer::NU_SUSTRAENDO);
    $c->addSelectColumn(Tb038RamoPeer::TX_RAMO);
    $c->addSelectColumn(Tb042RetencionPeer::MO_MINIMO);
    $c->addSelectColumn(Tb042RetencionPeer::CO_RETENCION);

    $c->addSelectColumn(Tb042RetencionPeer::DE_CONCEPTO);
    $c->addSelectColumn(Tb042RetencionPeer::NU_CONCEPTO);
    
    $c->addJoin(Tb042RetencionPeer::CO_RAMO, Tb038RamoPeer::CO_RAMO,  Criteria::LEFT_JOIN);
    $c->addJoin(Tb041TipoRetencionPeer::CO_TIPO_RETENCION, Tb042RetencionPeer::CO_TIPO_RETENCION);
    $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tb042RetencionPeer::CO_DOCUMENTO);
  
    $cantidadTotal = Tb042RetencionPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb042RetencionPeer::CO_RAMO);
    $c->addAscendingOrderByColumn(Tb042RetencionPeer::CO_TIPO_RETENCION);
    $c->addAscendingOrderByColumn(Tb042RetencionPeer::CO_DOCUMENTO);
    
        
    $stmt = Tb042RetencionPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_retencion"     => trim($res["co_retencion"]),
            "tx_documento"     => trim($res["tx_documento"]),
            "tx_tipo_retencion"     => trim($res["tx_tipo_retencion"]),
            "nu_valor"     => trim($res["nu_valor"]),
            "nu_sustraendo"     => trim($res["nu_sustraendo"]),
            "tx_ramo"     => trim($res["tx_ramo"]),
            "mo_minimo"     => trim($res["mo_minimo"]),
            "de_concepto"     => trim($res["de_concepto"]),
            "nu_concepto"     => trim($res["nu_concepto"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb007_documento.CO_DOCUMENTO
    public function executeStorefkcodocumento(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb007DocumentoPeer::doSelectStmt($c);
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
                    //modelo fk tb041_tipo_retencion.CO_TIPO_RETENCION
    public function executeStorefkcotiporetencion(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb041TipoRetencionPeer::doSelectStmt($c);
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
                                            //modelo fk tb038_ramo.CO_RAMO
    public function executeStorefkcoramo(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb038RamoPeer::doSelectStmt($c);
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