<?php

/**
 * autoTipoRetencion actions.
 * NombreClaseModel(Tb041TipoRetencion)
 * NombreTabla(tb041_tipo_retencion)
 * @package    ##PROJECT_NAME##
 * @subpackage autoTipoRetencion
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoTipoRetencionActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('TipoRetencion', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('TipoRetencion', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb041TipoRetencionPeer::CO_TIPO_RETENCION,$codigo);
        
        $stmt = Tb041TipoRetencionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_tipo_retencion"     => $campos["co_tipo_retencion"],
                            "tx_tipo_retencion"     => $campos["tx_tipo_retencion"],
                            "co_cuenta_contable"     => $campos["co_cuenta_contable"],
                            "co_clase_retencion"     => $campos["co_clase_retencion"],
                            "in_activo"     => $campos["in_activo"],
                            "nu_cuenta_pagar"     => $campos["nu_cuenta_pagar"],
                            "nu_cuenta_tercero"     => $campos["nu_cuenta_tercero"],
                            "co_cuenta_tercero"     => $campos["co_cuenta_tercero"],
                            "tx_movimiento"     => $campos["tx_movimiento"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_tipo_retencion"     => "",
                            "tx_tipo_retencion"     => "",
                            "co_cuenta_contable"     => "",
                            "co_clase_retencion"     => "",
                            "in_activo"     => "",
                            "nu_cuenta_pagar"     => "",
                            "nu_cuenta_tercero"     => "",
                            "co_cuenta_tercero"     => "",
                            "tx_movimiento"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_tipo_retencion");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb041_tipo_retencion = Tb041TipoRetencionPeer::retrieveByPk($codigo);
     }else{
         $tb041_tipo_retencion = new Tb041TipoRetencion();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb041_tipo_retencionForm = $this->getRequestParameter('tb041_tipo_retencion');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb041_tipo_retencion->setTxTipoRetencion($tb041_tipo_retencionForm["tx_tipo_retencion"]);
                                                        
        /*Campo tipo BIGINT */
        $tb041_tipo_retencion->setCoCuentaContable($tb041_tipo_retencionForm["co_cuenta_contable"]);
                                                        
        /*Campo tipo BIGINT */
        $tb041_tipo_retencion->setCoClaseRetencion($tb041_tipo_retencionForm["co_clase_retencion"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb041_tipo_retencionForm)){
            $tb041_tipo_retencion->setInActivo(false);
        }else{
            $tb041_tipo_retencion->setInActivo(true);
        }
                                                        
        /*Campo tipo VARCHAR */
        $tb041_tipo_retencion->setNuCuentaPagar($tb041_tipo_retencionForm["nu_cuenta_pagar"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb041_tipo_retencion->setNuCuentaTercero($tb041_tipo_retencionForm["nu_cuenta_tercero"]);
                                                        
        /*Campo tipo BIGINT */
        $tb041_tipo_retencion->setCoCuentaTercero($tb041_tipo_retencionForm["co_cuenta_tercero"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb041_tipo_retencion->setTxMovimiento($tb041_tipo_retencionForm["tx_movimiento"]);
                                
        /*CAMPOS*/
        $tb041_tipo_retencion->save($con);
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
	$codigo = $this->getRequestParameter("co_tipo_retencion");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb041_tipo_retencion = Tb041TipoRetencionPeer::retrieveByPk($codigo);			
	$tb041_tipo_retencion->delete($con);
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
                $tx_tipo_retencion      =   $this->getRequestParameter("tx_tipo_retencion");
            $co_cuenta_contable      =   $this->getRequestParameter("co_cuenta_contable");
            $co_clase_retencion      =   $this->getRequestParameter("co_clase_retencion");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $nu_cuenta_pagar      =   $this->getRequestParameter("nu_cuenta_pagar");
            $nu_cuenta_tercero      =   $this->getRequestParameter("nu_cuenta_tercero");
            $co_cuenta_tercero      =   $this->getRequestParameter("co_cuenta_tercero");
            $tx_movimiento      =   $this->getRequestParameter("tx_movimiento");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_tipo_retencion!=""){$c->add(Tb041TipoRetencionPeer::tx_tipo_retencion,'%'.$tx_tipo_retencion.'%',Criteria::LIKE);}
        
                                            if($co_cuenta_contable!=""){$c->add(Tb041TipoRetencionPeer::co_cuenta_contable,$co_cuenta_contable);}
    
                                            if($co_clase_retencion!=""){$c->add(Tb041TipoRetencionPeer::co_clase_retencion,$co_clase_retencion);}
    
                                    
                                        if($nu_cuenta_pagar!=""){$c->add(Tb041TipoRetencionPeer::nu_cuenta_pagar,'%'.$nu_cuenta_pagar.'%',Criteria::LIKE);}
        
                                        if($nu_cuenta_tercero!=""){$c->add(Tb041TipoRetencionPeer::nu_cuenta_tercero,'%'.$nu_cuenta_tercero.'%',Criteria::LIKE);}
        
                                            if($co_cuenta_tercero!=""){$c->add(Tb041TipoRetencionPeer::co_cuenta_tercero,$co_cuenta_tercero);}
    
                                        if($tx_movimiento!=""){$c->add(Tb041TipoRetencionPeer::tx_movimiento,'%'.$tx_movimiento.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb041TipoRetencionPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb041TipoRetencionPeer::CO_TIPO_RETENCION);
        
    $stmt = Tb041TipoRetencionPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_tipo_retencion"     => trim($res["co_tipo_retencion"]),
            "tx_tipo_retencion"     => trim($res["tx_tipo_retencion"]),
            "co_cuenta_contable"     => trim($res["co_cuenta_contable"]),
            "co_clase_retencion"     => trim($res["co_clase_retencion"]),
            "in_activo"     => trim($res["in_activo"]),
            "nu_cuenta_pagar"     => trim($res["nu_cuenta_pagar"]),
            "nu_cuenta_tercero"     => trim($res["nu_cuenta_tercero"]),
            "co_cuenta_tercero"     => trim($res["co_cuenta_tercero"]),
            "tx_movimiento"     => trim($res["tx_movimiento"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                //modelo fk tb024_cuenta_contable.CO_CUENTA_CONTABLE
    public function executeStorefkcocuentacontable(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb024CuentaContablePeer::doSelectStmt($c);
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