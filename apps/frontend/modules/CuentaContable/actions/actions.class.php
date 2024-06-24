<?php

/**
 * CuentaContable actions.
 *
 * @package    gobel
 * @subpackage CuentaContable
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class CuentaContableActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
        $codigo = $this->getRequestParameter("co_solicitud");
         
        $c = new Criteria();
        $c->addSelectColumn(Tb033SolicitudCuentaContablePeer::CO_SOLICITUD_CUENTA);
        $c->addSelectColumn(Tb010BancoPeer::TX_BANCO);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb012TipoCuentaBancariaPeer::TX_TIPO_CUENTA);
                        
        $c->addJoin(Tb033SolicitudCuentaContablePeer::CO_CUENTA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addJoin(Tb033SolicitudCuentaContablePeer::CO_BANCO, Tb010BancoPeer::CO_BANCO);
        $c->addJoin(Tb011CuentaBancariaPeer::CO_TIPO_CUENTA, Tb012TipoCuentaBancariaPeer::CO_TIPO_CUENTA);
        
        $c->add(Tb033SolicitudCuentaContablePeer::CO_SOLICITUD,$codigo);
        
        $stmt = Tb033SolicitudCuentaContablePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
      
      
         $this->data = json_encode(array(
                "co_solicitud_cuenta" => $campos["co_solicitud_cuenta"],
                "co_solicitud"        => $codigo,
                "tx_cuenta_bancaria"  => $campos["tx_cuenta_bancaria"],
                "tx_banco"            => $campos["tx_banco"],
                "co_cuenta_bancaria"  => $campos["co_cuenta_bancaria"],
                "tx_tipo_cuenta"      => $campos["tx_tipo_cuenta"]
         ));
  }
  
    public function executeFiltro(sfWebRequest $request)
  {

  }

  
  public function executePresupuesto(sfWebRequest $request)
  {
        $codigo = $this->getRequestParameter("id");
         
        $c = new Criteria();
        $c->addSelectColumn(Tb085PresupuestoPeer::ID);
        $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::CO_PARTIDA);                        
        $c->add(Tb085PresupuestoPeer::ID,$codigo);
        
        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
      
        $this->data = json_encode($campos);
  }
  
  public function executeFuenteIngreso(sfWebRequest $request)
  {
        $codigo = $this->getRequestParameter("id");
        $tx_fuente_ingreso = $this->getRequestParameter("tx_fuente_ingreso");
               
      
        $this->data = json_encode(array(
            "tx_fuente_ingreso" => $tx_fuente_ingreso,
            "co_fuente_ingreso" => $codigo
            
        ));
  }
  
  public function executePlanDeCuenta(sfWebRequest $request)
  {
         $this->data = json_encode(array(
                "ejercicio" => $this->getUser()->getAttribute('ejercicio')
         ));
  }
  
  public function executeProveedor(sfWebRequest $request)
  {
        $codigo = $this->getRequestParameter("co_solicitud");
         
        $c = new Criteria();
        $c->addSelectColumn(Tb106SolicitudCuentaContableProveedorPeer::CO_SOL_CUENTA);
        $c->addSelectColumn(Tb010BancoPeer::TX_BANCO);
        $c->addSelectColumn(Tb065CuentaProveedorPeer::TX_CUENTA);
        $c->addSelectColumn(Tb065CuentaProveedorPeer::CO_CUENTA_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        
        $c->addJoin(Tb106SolicitudCuentaContableProveedorPeer::CO_CUENTA, Tb065CuentaProveedorPeer::CO_CUENTA_PROVEEDOR);
        $c->addJoin(Tb106SolicitudCuentaContableProveedorPeer::CO_BANCO, Tb010BancoPeer::CO_BANCO);
        $c->addJoin(Tb106SolicitudCuentaContableProveedorPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tb008ProveedorPeer::CO_DOCUMENTO);
        
        $c->add(Tb106SolicitudCuentaContableProveedorPeer::CO_SOLICITUD,$codigo);
        
        $stmt = Tb106SolicitudCuentaContableProveedorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
      
      
        $this->data = json_encode(array(
                "co_sol_cuenta"       => $campos["co_sol_cuenta"],
                "co_solicitud"        => $codigo,
                "tx_cuenta"           => $campos["tx_cuenta"],
                "tx_banco"            => $campos["tx_banco"],
                "tx_razon_social"     => $campos["tx_razon_social"],
                "tx_rif"              => $campos["inicial"].'-'.$campos["tx_rif"],
                "co_cuenta_bancaria"  => $campos["co_cuenta_proveedor"]
        ));
  }
  
  public function executeAsignarProveedor(sfWebRequest $request)
  {
        $co_cuenta_contable = $this->getRequestParameter("co_cuenta_contable");
        $co_cuenta_bancaria = $this->getRequestParameter("co_cuenta_bancaria");
        $co_solicitud = $this->getRequestParameter("co_solicitud");
        
	$con = Propel::getConnection();
	try
	{ 
            $con->beginTransaction();
	
            $Tb065CuentaProveedor = Tb065CuentaProveedorPeer::retrieveByPk($co_cuenta_bancaria);	
            $Tb065CuentaProveedor->setCoCuentaContable($co_cuenta_contable);
            $Tb065CuentaProveedor->save($con);
            
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
            $ruta->setInCargarDato(true)->save($con);
            $con->commit();

            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());  
            

            $this->data = json_encode(array(
                        "success" => true,
                        "msg" => 'La cuenta bancaria se asignó exitosamente!'
            ));
        
            $con->commit();
	}catch (PropelException $e)
	{
              $con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
		    "msg" => 'Ocurrio un error al asignar la cuenta bancaria'
		));
	}
        
        $this->setTemplate('asignar');
  }
  
  public function executeAsignar(sfWebRequest $request)
  {
        $co_cuenta_contable = $this->getRequestParameter("co_cuenta_contable");
        $co_cuenta_bancaria = $this->getRequestParameter("co_cuenta_bancaria");
        $co_solicitud = $this->getRequestParameter("co_solicitud");
        
	$con = Propel::getConnection();
	try
	{ 
            $con->beginTransaction();
	
            $tb011_cuenta_bancaria = Tb011CuentaBancariaPeer::retrieveByPk($co_cuenta_bancaria);	
            $tb011_cuenta_bancaria->setCoCuentaContable($co_cuenta_contable);
            $tb011_cuenta_bancaria->save($con);
            
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
            $ruta->setInCargarDato(true)->save($con);
            $con->commit();

            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());  
            

            $this->data = json_encode(array(
                        "success" => true,
                        "msg" => 'La cuenta bancaria se asignó exitosamente!'
            ));
        
            $con->commit();
	}catch (PropelException $e)
	{
              $con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
		    "msg" => 'Ocurrio un error al asignar la cuenta bancaria'
		));
	}
  }
  
  public function executeAsignarPresupuesto(sfWebRequest $request)
  {
        $co_cuenta_contable = $this->getRequestParameter("co_cuenta_contable");
        $co_presupuesto = $this->getRequestParameter("co_presupuesto");
        
	$con = Propel::getConnection();
	try
	{ 
            $con->beginTransaction();
	
            $tb085_presupuesto = Tb085PresupuestoPeer::retrieveByPk($co_presupuesto);	
            $tb085_presupuesto->setCoCuentaContable($co_cuenta_contable);
            $tb085_presupuesto->save($con);
            
           
            $this->data = json_encode(array(
                        "success" => true,
                        "msg" => 'La cuenta contable se asignó exitosamente!'
            ));
        
            $con->commit();
	}catch (PropelException $e)
	{
              $con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
		    "msg" => 'Ocurrio un error al asignar la cuenta bancaria'
		));
	}
        
        $this->setTemplate('asignar');
  }
  
  public function executeAsignarFuenteIngreso(sfWebRequest $request)
  {
        $co_cuenta_contable = $this->getRequestParameter("co_cuenta_contable");
        $co_fuente_ingreso  = $this->getRequestParameter("co_fuente_ingreso");
        
	$con = Propel::getConnection();
	try
	{ 
            $con->beginTransaction();
	
            $tb085_presupuesto = Tb124FuenteIngresoPeer::retrieveByPk($co_fuente_ingreso);	
            $tb085_presupuesto->setCoCuentaContable($co_cuenta_contable);
            $tb085_presupuesto->save($con);
            
           
            $this->data = json_encode(array(
                        "success" => true,
                        "msg" => 'La cuenta contable se asignó exitosamente!'
            ));
        
            $con->commit();
	}catch (PropelException $e)
	{
              $con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
		    "msg" => 'Ocurrio un error al asignar la cuenta bancaria'
		));
	}
        
        $this->setTemplate('asignar');
  }
  
  
  public function executeGuardar(sfWebRequest $request)
  {
     $codigo = $this->getRequestParameter("co_cuenta_contable");
     $tb024_cuenta_contableForm = $this->getRequestParameter('tb024_cuenta_contable');
      
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
    
      try
      { 
        $con->beginTransaction();
         $tb024_cuenta_contable = Tb024CuentaContablePeer::retrieveByPk($codigo);
         $tb024_cuenta_contable->setTxTipo($tb024_cuenta_contableForm["tx_tipo"]);
         $tb024_cuenta_contable->setTxDescripcion(strtoupper($tb024_cuenta_contableForm["tx_descripcion"]));
         $tb024_cuenta_contable->save($con);
        
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
         
         
     }else{
         $tb024_cuenta_contable = new Tb024CuentaContable();
     try
      { 
        $con->beginTransaction();
        
        $cant = strlen(trim($tb024_cuenta_contableForm["tx_codigo_cuenta"]));
        
        $c = new Criteria();
        $c->add(Tb024CuentaContablePeer::TX_CODIGO_CUENTA,$tb024_cuenta_contableForm["tx_codigo_cuenta"]);
        $stmt = Tb024CuentaContablePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        if($campos["co_cuenta_contable"]!=''||$campos["co_cuenta_contable"]!=null){
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El Numero de la cuenta contable ya existe'
                ));
                echo $this->data;
                return sfView::NONE;              
        }
        
        if($cant==1){
            $nu_nivel = 1;

        }else{
            if($cant==3){
             $nu_nivel = 2;  
             $tx_nivel_anterior = substr($tb024_cuenta_contableForm["tx_codigo_cuenta"],0,1);

            }else{
            if($cant==5){
             $nu_nivel = 3; 
             $tx_nivel_anterior = substr($tb024_cuenta_contableForm["tx_codigo_cuenta"],0,3);
            }else{
            if($cant==7){
             $nu_nivel = 4;
             $tx_nivel_anterior = substr($tb024_cuenta_contableForm["tx_codigo_cuenta"],0,5);
            }else{
            if($cant==9){
             $nu_nivel = 5;   
             $tx_nivel_anterior = substr($tb024_cuenta_contableForm["tx_codigo_cuenta"],0,7);
            }else{ 
            if($cant==14){
             $nu_nivel = 6;   
             $tx_nivel_anterior = substr($tb024_cuenta_contableForm["tx_codigo_cuenta"],0,9);
            }else{
            if($cant==16){
             $nu_nivel = 7;   
             $tx_nivel_anterior = substr($tb024_cuenta_contableForm["tx_codigo_cuenta"],0,14);
            }else{
            if($cant==18){
             $nu_nivel = 8;  
             $tx_nivel_anterior = substr($tb024_cuenta_contableForm["tx_codigo_cuenta"],0,16);
            }else{
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El Numero de la cuenta contable es invalida'
                ));
                echo $this->data;
                return sfView::NONE;    
            }                
            }               
            }                
            }               
            }                
            }                
            }           
        }
        
        $c1 = new Criteria();
        $c1->add(Tb024CuentaContablePeer::TX_CODIGO_CUENTA,$tx_nivel_anterior);
        $stmt1 = Tb024CuentaContablePeer::doSelectStmt($c1);
        $campos1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        if($campos1["co_cuenta_contable"]==''||$campos1["co_cuenta_contable"]==null){
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'EL nivel anterior no existe, verifique!'
                ));
                echo $this->data;
                return sfView::NONE;              
        }     
        $tb024_cuenta_contable->setTxCodigoCuenta($tb024_cuenta_contableForm["tx_codigo_cuenta"])
                              ->setNuCuentaContable($tb024_cuenta_contableForm["tx_codigo_cuenta"])
                              ->setTxTipo($tb024_cuenta_contableForm["tx_tipo"])
                              ->setTxDescripcion(strtoupper($tb024_cuenta_contableForm["tx_descripcion"]))
                              ->setMoDisponible(0)
                              ->setNuNivel($nu_nivel)
                              ->save($con);
                              
        
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

  }
  
  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    $tx_prefijo = $this->getRequestParameter("tx_prefijo");
    $nivel = $this->getRequestParameter("nivel");
    $this->paquete = $this->getRequestParameter("paquete");
    $tx_cuenta = $this->getRequestParameter("tx_cuenta");
    $co_cuenta_contable = $this->getRequestParameter("co_cuenta_contable");
    
    if($co_cuenta_contable!=''){
        $c = new Criteria();
        $c->add(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE,$co_cuenta_contable);
        $stmt = Tb024CuentaContablePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
          
        $this->data = json_encode(array(
                "co_cuenta_contable"         => $co_cuenta_contable,
                "tx_codigo_cuenta"           => $campos["tx_codigo_cuenta"],
                "nu_cuenta_contable"         => $campos["nu_cuenta_contable"],
                "tx_descripcion"             => $campos["tx_descripcion"],
                "tx_tipo"                    => $campos["tx_tipo"],
                "nivel"                      => $campos["nu_nivel"],
                "tx_prefijo"                 => $tx_prefijo
        ));
        
      
    }else{
        
        $c = new Criteria();
        $c->add(Tb024CuentaContablePeer::TX_CUENTA,$tx_cuenta.'%',  Criteria::LIKE);
        $c->add(Tb024CuentaContablePeer::NU_NIVEL,$nivel+1);  
        
        $cant = Tb024CuentaContablePeer::doCount($c);
           
        if(($nivel+1)==1){
            $cantidad = $cant+1;
        }else{
            $cantidad = str_pad($cant+1, 2, "0", STR_PAD_LEFT);
        }
        
        $this->data = json_encode(array(
                            "co_cuenta_contable"         => "",
                            "tx_codigo_cuenta"           => "",
                            "nu_cuenta_contable"         => "",
                            "tx_descripcion"             => "",
                            "tx_tipo"                    => "",
                            "nivel"                      => "",
                            "tx_prefijo"                 => ""
                    ));
    }

  }
  
  public function executeVerCuenta(sfWebRequest $request){
      
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
  
  public function executeVerCuentaPresupuesto(sfWebRequest $request){
      
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
  
  public function executeVerCuentaFuenteIngreso(sfWebRequest $request){
      
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
  
  public function executeVerCuentaProveedor(sfWebRequest $request){
      
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
  
  public function executeStorelista(sfWebRequest $request)
  {
        $paginar    =   $this->getRequestParameter("paginar");
        $limit      =   $this->getRequestParameter("limit",15);
        $start      =   $this->getRequestParameter("start",0);

        $nu_cuenta_contable      =   $this->getRequestParameter("nu_cuenta_contable");
        $tx_descripcion        =   $this->getRequestParameter("tx_descripcion");
        $nu_nivel        =   $this->getRequestParameter("nu_nivel");


        $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
        if($nu_cuenta_contable!=""){$c->add(Tb024CuentaContablePeer::NU_CUENTA_CONTABLE,$nu_cuenta_contable.'%',Criteria::ILIKE);}
        if($tx_descripcion!=""){$c->add(Tb024CuentaContablePeer::TX_DESCRIPCION,'%'.$tx_descripcion.'%',Criteria::ILIKE);}
        if($nu_nivel!=""){$c->add(Tb024CuentaContablePeer::NU_NIVEL,$nu_nivel);}
    }        

        $c->setIgnoreCase(true);
        $cantidadTotal = Tb024CuentaContablePeer::doCount($c);

        $c->setLimit($limit)->setOffset($start);
        //$c->add(Tb024CuentaContablePeer::NU_NIVEL, 1);
        $c->addAscendingOrderByColumn(Tb024CuentaContablePeer::NU_CUENTA_CONTABLE);
//        $c->addAscendingOrderByColumn(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE);

        $stmt = Tb024CuentaContablePeer::doSelectStmt($c);
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
    
    public function executeStorelistacuenta(sfWebRequest $request)
    {
        $paginar    =   $this->getRequestParameter("paginar");
        $limit      =   $this->getRequestParameter("limit",15);
        $start      =   $this->getRequestParameter("start",0);

        $tx_cuenta  =   $this->getRequestParameter("tx_cuenta");
        $nu_nivel    =   $this->getRequestParameter("nu_nivel");


        $c = new Criteria();
       
        $c->add(Tb024CuentaContablePeer::NU_NIVEL, $nu_nivel+1);
        $c->add(Tb024CuentaContablePeer::TX_CUENTA,$tx_cuenta.'%',  Criteria::ILIKE);
        $c->addAscendingOrderByColumn(Tb024CuentaContablePeer::TX_CUENTA);
        
        $c->setIgnoreCase(true);
        $cantidadTotal = Tb024CuentaContablePeer::doCount($c);
        
        $c->setLimit($limit)->setOffset($start);

        $stmt = Tb024CuentaContablePeer::doSelectStmt($c);
        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){  
            
             $res["cant"] = $this->getInAsignada($res["co_cuenta_contable"]);             
             $registros[] = $res;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));
        
         $this->setTemplate('storelista');
    }
    
    public function executeStorefkcocuenta(sfWebRequest $request){
        
        $co_banco = $this->getRequestParameter("co_banco");
        
        $c = new Criteria();
        $c->add(Tb011CuentaBancariaPeer::CO_BANCO,$co_banco);
        $c->add(Tb011CuentaBancariaPeer::CO_CUENTA_CONTABLE,NULL,Criteria::ISNULL);
        $c->addAscendingOrderByColumn(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $stmt = Tb011CuentaBancariaPeer::doSelectStmt($c);
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
    
    
    protected function getInAsignada($co_cuenta_contable){       
        
        $c = new Criteria();       
        $c->add(Tb011CuentaBancariaPeer::CO_CUENTA_CONTABLE, $co_cuenta_contable);
        $cant = Tb011CuentaBancariaPeer::doCount($c);
        
        if($cant == 0){
            $c = new Criteria();       
            $c->add(Tb065CuentaProveedorPeer::CO_CUENTA_CONTABLE, $co_cuenta_contable);
            $cant = Tb065CuentaProveedorPeer::doCount($c);
        }if($cant == 0){
            $c = new Criteria();       
            $c->add(Tb044IvaRetencionPeer::CO_CUENTA_CONTABLE, $co_cuenta_contable);
            $cant = Tb044IvaRetencionPeer::doCount($c);
        }if($cant == 0){
            $c = new Criteria();       
            $c->add(Tb041TipoRetencionPeer::CO_CUENTA_CONTABLE, $co_cuenta_contable);
            $cant = Tb041TipoRetencionPeer::doCount($c);
        }if($cant == 0){
            $c = new Criteria();       
            $c->add(Tb085PresupuestoPeer::CO_CUENTA_CONTABLE, $co_cuenta_contable);
            $cant = Tb085PresupuestoPeer::doCount($c);
        }if($cant == 0){
            $c = new Criteria();       
            $c->add(Tb124FuenteIngresoPeer::CO_CUENTA_CONTABLE, $co_cuenta_contable);
            $cant = Tb124FuenteIngresoPeer::doCount($c);
        }
        
        return $cant;        
    }
}
