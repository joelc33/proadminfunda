<?php

/**
 * autoTesoreriaIngreso actions.
 * NombreClaseModel(Tb142CuentaCobrar)
 * NombreTabla(tb142_cuenta_cobrar)
 * @package    ##PROJECT_NAME##
 * @subpackage autoTesoreriaIngreso
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class autoTesoreriaIngresoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('TesoreriaIngreso', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('TesoreriaIngreso', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb142CuentaCobrarPeer::ID,$codigo);
        
        $stmt = Tb142CuentaCobrarPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_usuario"     => $campos["co_usuario"],
                            "co_proveedor"     => $campos["co_proveedor"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "de_soporte"     => $campos["de_soporte"],
                            "id_tb143_cuenta_concepto"     => $campos["id_tb143_cuenta_concepto"],
                            "id_tb144_clase_ingreso"     => $campos["id_tb144_clase_ingreso"],
                            "de_descripcion"     => $campos["de_descripcion"],
                            "mo_cuenta"     => $campos["mo_cuenta"],
                            "fe_documento"     => $campos["fe_documento"],
                            "id_tb141_tipo_cuota"     => $campos["id_tb141_tipo_cuota"],
                            "co_solicitud_anular"     => $campos["co_solicitud_anular"],
                            "in_anular"     => $campos["in_anular"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "co_solicitud"     => "",
                            "co_usuario"     => "",
                            "co_proveedor"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "de_soporte"     => "",
                            "id_tb143_cuenta_concepto"     => "",
                            "id_tb144_clase_ingreso"     => "",
                            "de_descripcion"     => "",
                            "mo_cuenta"     => "",
                            "fe_documento"     => "",
                            "id_tb141_tipo_cuota"     => "",
                            "co_solicitud_anular"     => "",
                            "in_anular"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb142_cuenta_cobrar = Tb142CuentaCobrarPeer::retrieveByPk($codigo);
     }else{
         $tb142_cuenta_cobrar = new Tb142CuentaCobrar();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb142_cuenta_cobrarForm = $this->getRequestParameter('tb142_cuenta_cobrar');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb142_cuenta_cobrar->setCoSolicitud($tb142_cuenta_cobrarForm["co_solicitud"]);
                                                        
        /*Campo tipo BIGINT */
        $tb142_cuenta_cobrar->setCoUsuario($tb142_cuenta_cobrarForm["co_usuario"]);
                                                        
        /*Campo tipo BIGINT */
        $tb142_cuenta_cobrar->setCoProveedor($tb142_cuenta_cobrarForm["co_proveedor"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb142_cuenta_cobrarForm)){
            $tb142_cuenta_cobrar->setInActivo(false);
        }else{
            $tb142_cuenta_cobrar->setInActivo(true);
        }
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb142_cuenta_cobrarForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb142_cuenta_cobrar->setCreatedAt($fecha);
                                                        
        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb142_cuenta_cobrarForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb142_cuenta_cobrar->setUpdatedAt($fecha);
                                                        
        /*Campo tipo VARCHAR */
        $tb142_cuenta_cobrar->setDeSoporte($tb142_cuenta_cobrarForm["de_soporte"]);
                                                        
        /*Campo tipo BIGINT */
        $tb142_cuenta_cobrar->setIdTb143CuentaConcepto($tb142_cuenta_cobrarForm["id_tb143_cuenta_concepto"]);
                                                        
        /*Campo tipo BIGINT */
        $tb142_cuenta_cobrar->setIdTb144ClaseIngreso($tb142_cuenta_cobrarForm["id_tb144_clase_ingreso"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb142_cuenta_cobrar->setDeDescripcion($tb142_cuenta_cobrarForm["de_descripcion"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb142_cuenta_cobrar->setMoCuenta($tb142_cuenta_cobrarForm["mo_cuenta"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb142_cuenta_cobrarForm["fe_documento"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb142_cuenta_cobrar->setFeDocumento($fecha);
                                                        
        /*Campo tipo BIGINT */
        $tb142_cuenta_cobrar->setIdTb141TipoCuota($tb142_cuenta_cobrarForm["id_tb141_tipo_cuota"]);
                                                        
        /*Campo tipo BIGINT */
        $tb142_cuenta_cobrar->setCoSolicitudAnular($tb142_cuenta_cobrarForm["co_solicitud_anular"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_anular", $tb142_cuenta_cobrarForm)){
            $tb142_cuenta_cobrar->setInAnular(false);
        }else{
            $tb142_cuenta_cobrar->setInAnular(true);
        }
                                
        /*CAMPOS*/
        $tb142_cuenta_cobrar->save($con);
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
	$codigo = $this->getRequestParameter("id");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb142_cuenta_cobrar = Tb142CuentaCobrarPeer::retrieveByPk($codigo);			
	$tb142_cuenta_cobrar->delete($con);
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
                $co_solicitud      =   $this->getRequestParameter("co_solicitud");
            $co_usuario      =   $this->getRequestParameter("co_usuario");
            $co_proveedor      =   $this->getRequestParameter("co_proveedor");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $de_soporte      =   $this->getRequestParameter("de_soporte");
            $id_tb143_cuenta_concepto      =   $this->getRequestParameter("id_tb143_cuenta_concepto");
            $id_tb144_clase_ingreso      =   $this->getRequestParameter("id_tb144_clase_ingreso");
            $de_descripcion      =   $this->getRequestParameter("de_descripcion");
            $mo_cuenta      =   $this->getRequestParameter("mo_cuenta");
            $fe_documento      =   $this->getRequestParameter("fe_documento");
            $id_tb141_tipo_cuota      =   $this->getRequestParameter("id_tb141_tipo_cuota");
            $co_solicitud_anular      =   $this->getRequestParameter("co_solicitud_anular");
            $in_anular      =   $this->getRequestParameter("in_anular");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_solicitud!=""){$c->add(Tb142CuentaCobrarPeer::co_solicitud,$co_solicitud);}
    
                                            if($co_usuario!=""){$c->add(Tb142CuentaCobrarPeer::co_usuario,$co_usuario);}
    
                                            if($co_proveedor!=""){$c->add(Tb142CuentaCobrarPeer::co_proveedor,$co_proveedor);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb142CuentaCobrarPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb142CuentaCobrarPeer::updated_at,$fecha);
    }
                                        if($de_soporte!=""){$c->add(Tb142CuentaCobrarPeer::de_soporte,'%'.$de_soporte.'%',Criteria::LIKE);}
        
                                            if($id_tb143_cuenta_concepto!=""){$c->add(Tb142CuentaCobrarPeer::id_tb143_cuenta_concepto,$id_tb143_cuenta_concepto);}
    
                                            if($id_tb144_clase_ingreso!=""){$c->add(Tb142CuentaCobrarPeer::id_tb144_clase_ingreso,$id_tb144_clase_ingreso);}
    
                                        if($de_descripcion!=""){$c->add(Tb142CuentaCobrarPeer::de_descripcion,'%'.$de_descripcion.'%',Criteria::LIKE);}
        
                                            if($mo_cuenta!=""){$c->add(Tb142CuentaCobrarPeer::mo_cuenta,$mo_cuenta);}
    
                                    
        if($fe_documento!=""){
    list($dia, $mes,$anio) = explode("/",$fe_documento);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb142CuentaCobrarPeer::fe_documento,$fecha);
    }
                                            if($id_tb141_tipo_cuota!=""){$c->add(Tb142CuentaCobrarPeer::id_tb141_tipo_cuota,$id_tb141_tipo_cuota);}
    
                                            if($co_solicitud_anular!=""){$c->add(Tb142CuentaCobrarPeer::co_solicitud_anular,$co_solicitud_anular);}
    
                                    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb142CuentaCobrarPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb142CuentaCobrarPeer::ID);
        
    $stmt = Tb142CuentaCobrarPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "co_solicitud"     => trim($res["co_solicitud"]),
            "co_usuario"     => trim($res["co_usuario"]),
            "co_proveedor"     => trim($res["co_proveedor"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "de_soporte"     => trim($res["de_soporte"]),
            "id_tb143_cuenta_concepto"     => trim($res["id_tb143_cuenta_concepto"]),
            "id_tb144_clase_ingreso"     => trim($res["id_tb144_clase_ingreso"]),
            "de_descripcion"     => trim($res["de_descripcion"]),
            "mo_cuenta"     => trim($res["mo_cuenta"]),
            "fe_documento"     => trim($res["fe_documento"]),
            "id_tb141_tipo_cuota"     => trim($res["id_tb141_tipo_cuota"]),
            "co_solicitud_anular"     => trim($res["co_solicitud_anular"]),
            "in_anular"     => trim($res["in_anular"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                                                        //modelo fk tb143_cuenta_concepto.ID
    public function executeStorefkidtb143cuentaconcepto(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb143CuentaConceptoPeer::doSelectStmt($c);
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
                    //modelo fk tb144_clase_ingreso.ID
    public function executeStorefkidtb144claseingreso(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb144ClaseIngresoPeer::doSelectStmt($c);
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
                                                        //modelo fk tb141_tipo_cuota.ID
    public function executeStorefkidtb141tipocuota(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb141TipoCuotaPeer::doSelectStmt($c);
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