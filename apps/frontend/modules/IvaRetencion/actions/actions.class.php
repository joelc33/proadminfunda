<?php

/**
 * autoIvaRetencion actions.
 * NombreClaseModel(Tb044IvaRetencion)
 * NombreTabla(tb044_iva_retencion)
 * @package    ##PROJECT_NAME##
 * @subpackage autoIvaRetencion
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class IvaRetencionActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('IvaRetencion', 'lista');
  }
  
  public function executeVerCuentaAgregar(sfWebRequest $request){
      
        $nu_cuenta_contable = $this->getRequestParameter("nu_cuenta_contable");
        $nivel = $this->getRequestParameter("nivel");
        $this->nu_cuenta = "cuenta".$this->getRequestParameter("co_cuenta_contable");
        $tx_cuenta = $this->getRequestParameter("tx_cuenta");
        
        $this->data = json_encode(array(
                "nu_cuenta_contable" => $nu_cuenta_contable,
                "nivel"              => $nivel,
                "tx_cuenta"          => $tx_cuenta
        ));
  }
  
  public function executePlanDeCuenta(sfWebRequest $request)
  {
         $this->data = json_encode(array(
                "ejercicio"        => $this->getUser()->getAttribute('ejercicio'),
                "co_iva_retencion" => $this->getRequestParameter("co_iva_retencion")
         ));
  }
  
  public function executeAsignarCuenta(sfWebRequest $request)
  {
        $co_iva_retencion   = $this->getRequestParameter("co_iva_retencion");
        $co_cuenta_contable = $this->getRequestParameter("co_cuenta_contable");
        $con = Propel::getConnection();
        
//        $tb044_iva_retencion = Tb044IvaRetencionPeer::retrieveByPK($co_iva_retencion);
//        $tb044_iva_retencion->setCoCuentaContable($co_cuenta_contable)
//                            ->save();
        
        $wherec = new Criteria();
        $wherec->add(Tb044IvaRetencionPeer::CO_IVA_RETENCION, NULL,  Criteria::ISNOTNULL);
        
        $updc = new Criteria();
        $updc->add(Tb044IvaRetencionPeer::CO_CUENTA_CONTABLE, $co_cuenta_contable);

        BasePeer::doUpdate($wherec, $updc, $con);
        
        
        $this->data = json_encode(array(
            "success" => true,
            "msg" => 'Modificación realizada exitosamente'
        ));
        
        $this->setTemplate('guardar');
  }
  
  

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('IvaRetencion', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tb044IvaRetencionPeer::CO_IVA_RETENCION,$codigo);
        
        $stmt = Tb044IvaRetencionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_iva_retencion"     => $campos["co_iva_retencion"],
                            "nu_valor"     => $campos["nu_valor"],
                            "fe_desde"     => $campos["fe_desde"],
                            "fe_hasta"     => $campos["fe_hasta"],
                            "in_activo"     => $campos["in_activo"],
                            "co_cuenta_contable"     => $campos["co_cuenta_contable"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_iva_retencion"     => "",
                            "nu_valor"     => "",
                            "fe_desde"     => "",
                            "fe_hasta"     => "",
                            "in_activo"     => "",
                            "co_cuenta_contable"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_iva_retencion");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb044_iva_retencion = Tb044IvaRetencionPeer::retrieveByPk($codigo);
     }else{
        $tb044_iva_retencion = new Tb044IvaRetencion();
         
        $c = new Criteria();        
        $stmt = Tb044IvaRetencionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $tb044_iva_retencion->setCoCuentaContable($campos["co_cuenta_contable"]);
         
     }
     try
      { 
        $con->beginTransaction();
       
        $tb044_iva_retencionForm = $this->getRequestParameter('tb044_iva_retencion');
/*CAMPOS*/
                                        
        /*Campo tipo NUMERIC */
        $tb044_iva_retencion->setNuValor($tb044_iva_retencionForm["nu_valor"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb044_iva_retencionForm["fe_desde"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb044_iva_retencion->setFeDesde($fecha);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb044_iva_retencionForm["fe_hasta"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb044_iva_retencion->setFeHasta($fecha);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb044_iva_retencionForm)){
            $tb044_iva_retencion->setInActivo(false);
        }else{
            $tb044_iva_retencion->setInActivo(true);
        }
        
        
       
        
        
                                                        
                                 
        /*CAMPOS*/
        $tb044_iva_retencion->save($con);
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
	$codigo = $this->getRequestParameter("co_iva_retencion");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb044_iva_retencion = Tb044IvaRetencionPeer::retrieveByPk($codigo);			
	$tb044_iva_retencion->delete($con);
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
                
    
    $c = new Criteria();   
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb044IvaRetencionPeer::CO_IVA_RETENCION);
    $c->addSelectColumn(Tb044IvaRetencionPeer::NU_VALOR);
    $c->addSelectColumn(Tb024CuentaContablePeer::TX_CUENTA);
            
    $c->addJoin(Tb044IvaRetencionPeer::CO_CUENTA_CONTABLE, Tb024CuentaContablePeer::CO_CUENTA_CONTABLE);
    
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb044IvaRetencionPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb044IvaRetencionPeer::CO_IVA_RETENCION);
        
    $stmt = Tb044IvaRetencionPeer::doSelectStmt($c);
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