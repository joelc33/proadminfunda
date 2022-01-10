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
class TipoRetencionActions extends sfActions
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
                "co_tipo_retencion" => $this->getRequestParameter("co_tipo_retencion")
         ));
  }
  
  public function executeAsignarCuenta(sfWebRequest $request)
  {
        $co_tipo_retencion   = $this->getRequestParameter("co_tipo_retencion");
        $co_cuenta_contable = $this->getRequestParameter("co_cuenta_contable");
        $con = Propel::getConnection();
        
        $tb041_tipo_retencion = Tb041TipoRetencionPeer::retrieveByPK($co_tipo_retencion);
        $tb041_tipo_retencion->setCoCuentaContable($co_cuenta_contable)
                             ->save();
        
               
        $this->data = json_encode(array(
            "success" => true,
            "msg" => 'Modificación realizada exitosamente'
        ));
        
        $this->setTemplate('guardar');
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
                            "co_clase_retencion"    => $campos["co_clase_retencion"],            
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_tipo_retencion"     => "",
                            "tx_tipo_retencion"     => "",
                            "co_clase_retencion"     => "",
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
        
        $tb041_tipo_retencion->setCoClaseRetencion($tb041_tipo_retencionForm["co_clase_retencion"]);
                                
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
  
     public function executeCambiarEstado(sfWebRequest $request)
    {
          $codigo = $this->getRequestParameter("co_tipo_retencion");
          $in_activo = $this->getRequestParameter("in_activo");
          $con = Propel::getConnection();
          try
          { 
                $con->beginTransaction();
                $tb041_tipo_retencion = Tb041TipoRetencionPeer::retrieveByPk($codigo);
                $tb041_tipo_retencion->setInActivo(($in_activo=='true')?false:true);
                $tb041_tipo_retencion->save($con);
                $this->data = json_encode(array(
                            "success" => true,
                            "msg" => 'Registro se actualizó exitosamente!'
                ));

                $con->commit();
          }catch (PropelException $e)
          {
                $con->rollback();
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'Ocurrio un error al actualizar el registro'
                ));
          }
          
          $this->setTemplate('store');
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
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($tx_tipo_retencion!=""){$c->add(Tb041TipoRetencionPeer::tx_tipo_retencion,'%'.$tx_tipo_retencion.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb041TipoRetencionPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addSelectColumn(Tb041TipoRetencionPeer::CO_TIPO_RETENCION);
    $c->addSelectColumn(Tb041TipoRetencionPeer::TX_TIPO_RETENCION);
    $c->addSelectColumn(Tb041TipoRetencionPeer::IN_ACTIVO);
    $c->addSelectColumn(Tb072ClaseRetencionPeer::TX_CLASE_RETENCION);
    $c->addSelectColumn(Tb024CuentaContablePeer::TX_CUENTA);
    $c->addAscendingOrderByColumn(Tb041TipoRetencionPeer::CO_TIPO_RETENCION);
    $c->addJoin(Tb041TipoRetencionPeer::CO_CUENTA_CONTABLE, Tb024CuentaContablePeer::CO_CUENTA_CONTABLE,  Criteria::LEFT_JOIN);
    $c->addJoin(Tb041TipoRetencionPeer::CO_CLASE_RETENCION, Tb072ClaseRetencionPeer::CO_CLASE_RETENCION);
    $stmt = Tb041TipoRetencionPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        $activo = ($res["in_activo"]==true)?'Activo':'Inactivo';
        
        $registros[] = array(
            "co_tipo_retencion"     => trim($res["co_tipo_retencion"]),
            "tx_tipo_retencion"     => trim($res["tx_tipo_retencion"]),
            "tx_clase_retencion"    => trim($res["tx_clase_retencion"]),
            "tx_cuenta"             => trim($res["tx_cuenta"]),
            "estado"                => $activo,
            "in_activo"             => $res["in_activo"]
            
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

            public function executeStorefkcoclaseretencion(sfWebRequest $request){
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb072ClaseRetencionPeer::CO_CLASE_RETENCION);
        $stmt = Tb072ClaseRetencionPeer::doSelectStmt($c);
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