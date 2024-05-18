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
class autoRetencionesActions extends sfActions
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
                            "co_tipo_retencion"     => "",
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
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb042_retencion->setCoDocumento($tb042_retencionForm["co_documento"]);
                                                        
        /*Campo tipo BIGINT */
        $tb042_retencion->setCoTipoRetencion($tb042_retencionForm["co_tipo_retencion"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb042_retencion->setNuValor($tb042_retencionForm["nu_valor"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb042_retencion->setNuSustraendo($tb042_retencionForm["nu_sustraendo"]);
                                                        
        /*Campo tipo BIGINT */
        $tb042_retencion->setCoRamo($tb042_retencionForm["co_ramo"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb042_retencion->setMoMinimo($tb042_retencionForm["mo_minimo"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb042_retencion->setDeConcepto($tb042_retencionForm["de_concepto"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb042_retencion->setNuConcepto($tb042_retencionForm["nu_concepto"]);
                                
        /*CAMPOS*/
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

  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $co_documento      =   $this->getRequestParameter("co_documento");
            $co_tipo_retencion      =   $this->getRequestParameter("co_tipo_retencion");
            $nu_valor      =   $this->getRequestParameter("nu_valor");
            $nu_sustraendo      =   $this->getRequestParameter("nu_sustraendo");
            $co_ramo      =   $this->getRequestParameter("co_ramo");
            $mo_minimo      =   $this->getRequestParameter("mo_minimo");
            $de_concepto      =   $this->getRequestParameter("de_concepto");
            $nu_concepto      =   $this->getRequestParameter("nu_concepto");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_documento!=""){$c->add(Tb042RetencionPeer::co_documento,$co_documento);}
    
                                            if($co_tipo_retencion!=""){$c->add(Tb042RetencionPeer::co_tipo_retencion,$co_tipo_retencion);}
    
                                            if($nu_valor!=""){$c->add(Tb042RetencionPeer::nu_valor,$nu_valor);}
    
                                            if($nu_sustraendo!=""){$c->add(Tb042RetencionPeer::nu_sustraendo,$nu_sustraendo);}
    
                                            if($co_ramo!=""){$c->add(Tb042RetencionPeer::co_ramo,$co_ramo);}
    
                                            if($mo_minimo!=""){$c->add(Tb042RetencionPeer::mo_minimo,$mo_minimo);}
    
                                        if($de_concepto!=""){$c->add(Tb042RetencionPeer::de_concepto,'%'.$de_concepto.'%',Criteria::LIKE);}
        
                                        if($nu_concepto!=""){$c->add(Tb042RetencionPeer::nu_concepto,'%'.$nu_concepto.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb042RetencionPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb042RetencionPeer::CO_RETENCION);
        
    $stmt = Tb042RetencionPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_retencion"     => trim($res["co_retencion"]),
            "co_documento"     => trim($res["co_documento"]),
            "co_tipo_retencion"     => trim($res["co_tipo_retencion"]),
            "nu_valor"     => trim($res["nu_valor"]),
            "nu_sustraendo"     => trim($res["nu_sustraendo"]),
            "co_ramo"     => trim($res["co_ramo"]),
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