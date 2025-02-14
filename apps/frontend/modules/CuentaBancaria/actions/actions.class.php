<?php

/**
 * autoCuentaBancaria actions.
 * NombreClaseModel(Tb011CuentaBancaria)
 * NombreTabla(tb011_cuenta_bancaria)
 * @package    ##PROJECT_NAME##
 * @subpackage autoCuentaBancaria
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class CuentaBancariaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('CuentaBancaria', 'lista');
  }
  
  public function executeSolicitud(sfWebRequest $request)
  {
        $codigo = $this->getRequestParameter("co_solicitud");
         
        $c = new Criteria();
        $c->add(Tb033SolicitudCuentaContablePeer::CO_SOLICITUD,$codigo);
        
        $stmt = Tb033SolicitudCuentaContablePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
      
      
         $this->data = json_encode(array(
                "co_solicitud_cuenta" => $campos["co_solicitud_cuenta"],
                "co_solicitud"        => $codigo,
                "co_cuenta"           => $campos["co_cuenta"],
                "co_banco"            => $campos["co_banco"]              
         ));
  }
  
  public function executeSolicitudProveedor(sfWebRequest $request)
  {
        $codigo = $this->getRequestParameter("co_solicitud");
         
        $c = new Criteria();
        $c->addSelectColumn(Tb106SolicitudCuentaContableProveedorPeer::CO_SOL_CUENTA);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb007DocumentoPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb106SolicitudCuentaContableProveedorPeer::CO_BANCO);
        $c->addSelectColumn(Tb106SolicitudCuentaContableProveedorPeer::CO_CUENTA);
        
        $c->addJoin(Tb106SolicitudCuentaContableProveedorPeer::CO_PROVEEDOR,  Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addJoin(Tb106SolicitudCuentaContableProveedorPeer::CO_BANCO, Tb010BancoPeer::CO_BANCO);
        $c->addJoin(Tb106SolicitudCuentaContableProveedorPeer::CO_CUENTA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        
        $c->add(Tb106SolicitudCuentaContableProveedorPeer::CO_SOLICITUD,$codigo);
        
        $stmt = Tb033SolicitudCuentaContablePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
      
      
         $this->data = json_encode(array(
                "co_solicitud_cuenta"   => $campos["co_sol_cuenta"],
                "co_proveedor"      => $campos["co_proveedor"],
                "co_solicitud"      => $codigo,
                "co_documento"      => $campos["co_documento"],
                "tx_razon_social"   => $campos["tx_razon_social"],
                "tx_rif"            => $campos["tx_rif"],
                "tx_direccion"      => $campos["tx_direccion"],
                "co_banco"          => $campos["co_banco"],
                "co_cuenta"         => $campos["co_cuenta"]
         ));
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('CuentaBancaria', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->addSelectColumn(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::CO_BANCO);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::CO_TIPO_CUENTA);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::CO_DESCRIPCION_CUENTA);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::NU_CONTRATO);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::MO_DISPONIBLE);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::TX_DESCRIPCION);
        $c->addSelectColumn(Tb024CuentaContablePeer::NU_CUENTA_CONTABLE);
        $c->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA,$codigo);
        $c->addJoin(Tb011CuentaBancariaPeer::CO_CUENTA_CONTABLE, Tb024CuentaContablePeer::CO_CUENTA_CONTABLE);
        $stmt = Tb011CuentaBancariaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_cuenta_bancaria"     => $campos["co_cuenta_bancaria"],
                            "tx_cuenta_bancaria"     => $campos["tx_cuenta_bancaria"],
                            "co_banco"     => $campos["co_banco"],
                            "co_tipo_cuenta"     => $campos["co_tipo_cuenta"],
                            "co_descripcion_cuenta"     => $campos["co_descripcion_cuenta"],
                            "nu_contrato"     => $campos["nu_contrato"],
                            "mo_disponible"     => $campos["mo_disponible"],
                            "tx_descripcion"     => $campos["tx_descripcion"],
                            "nu_cuenta_contable"     => $campos["nu_cuenta_contable"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_cuenta_bancaria"     => "",
                            "tx_cuenta_bancaria"     => "",
                            "co_banco"     => "",
                            "co_tipo_cuenta"     => "",
                            "co_descripcion_cuenta"     => "",
                            "nu_contrato"     => "",
                            "mo_disponible"     => "",
                            "tx_descripcion"     => "",
                            "nu_cuenta_contable"     => "",
                    ));
    }

  }

  public function executeEditarCheque(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("co_cheque");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb077ChequePeer::CO_CHEQUE,$codigo);
        
        $stmt = Tb077ChequePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_cheque"     => $campos["co_cheque"],
                            "tx_descripcion"     => $campos["tx_descripcion"],
                            "co_estado_cheque"     => $campos["co_estado_cheque"],
                            "created_at"     => $campos["created_at"],
                            "co_chequera"     => $campos["co_chequera"],
                            "tx_observacion"     => $campos["tx_observacion"],
                            "in_activo"     => $campos["in_activo"],
                            "updated_at"     => $campos["updated_at"],
                            "nb_titular"     => $campos["nb_titular"],
                            "mo_cheque"     => $campos["mo_cheque"],
                            "fe_pago"     => $campos["fe_pago"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_cheque"     => "",
                            "tx_descripcion"     => "",
                            "co_estado_cheque"     => "",
                            "created_at"     => "",
                            "co_chequera"     => $this->getRequestParameter("co_chequera"),
                            "tx_observacion"     => "",
                            "in_activo"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

    public function executeEditarchequera(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tb079ChequeraPeer::CO_CHEQUERA,$codigo);
        
        $stmt = Tb079ChequeraPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_chequera"     => $campos["co_chequera"],
                            "co_cuenta_bancaria"     => $campos["co_cuenta_bancaria"],
                            "tx_descripcion"     => $campos["tx_descripcion"],
                            "nro_chequera"     => $campos["nro_chequera"],
                            "anio_chequera"     => $campos["anio_chequera"],
                            "serie"     => $campos["serie"],
                            "nro_inicial"     => $campos["nro_inicial"],
                            "nro_final"     => $campos["nro_final"],
                            "fe_chequera"     => $campos["fe_chequera"],
                            "in_activo"     => $campos["in_activo"],
            
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_chequera"     => "",
                            "co_cuenta_bancaria"     => $this->getRequestParameter("co_cuenta_bancaria"),
                            "tx_descripcion"     => "",
                            "nro_chequera"     => "",
                            "anio_chequera"  => "",
                            "serie"  => "",
                            "nro_inicial"  => "",
                            "nro_final"  => "",
                            "fe_chequera"  => "",
                            "in_activo"  => ""
                    ));
    }

  }
  
  
    public function executeEstadocheque(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("co_cheque");
    if($codigo!=''||$codigo!=null){
        
      
        $c = new Criteria();
        $c->add(Tb077ChequePeer::CO_CHEQUE,$codigo);       
        $stmt = Tb077ChequePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->data = json_encode(array(
            "co_cheque"      => $campos["co_cheque"],
            "co_estado_cheque"        => $campos["co_estado_cheque"],
        ));
        
        
      
    }

  }
  
  
  public function executeGuardarSolicitudProveedor(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_solicitud_cuenta");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb106_solicitud_cuenta_contable_proveedor = Tb106SolicitudCuentaContableProveedorPeer::retrieveByPk($codigo);
     }else{
         $tb106_solicitud_cuenta_contable_proveedor = new Tb106SolicitudCuentaContableProveedor();
         $tb106_solicitud_cuenta_contable_proveedor->setCoUsuario($this->getUser()->getAttribute('codigo'));
     
     }
     try
      { 
        $con->beginTransaction();
       
        $tb106_solicitud_cuenta_contable_proveedorForm = $this->getRequestParameter('tb106_solicitud_cuenta_contable_proveedor');

        $tb106_solicitud_cuenta_contable_proveedor->setCoBanco($tb106_solicitud_cuenta_contable_proveedorForm["co_banco"]);
        $tb106_solicitud_cuenta_contable_proveedor->setCoCuenta($tb106_solicitud_cuenta_contable_proveedorForm["co_cuenta_bancaria"]);
        $tb106_solicitud_cuenta_contable_proveedor->setCoProveedor($tb106_solicitud_cuenta_contable_proveedorForm["co_proveedor"]);
        $tb106_solicitud_cuenta_contable_proveedor->setCoSolicitud($tb106_solicitud_cuenta_contable_proveedorForm["co_solicitud"]);
        $tb106_solicitud_cuenta_contable_proveedor->save($con);
        
        $con->commit();
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb106_solicitud_cuenta_contable_proveedorForm["co_solicitud"]));
        $ruta->setInCargarDato(true)->save($con);
     
        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());                 

        $con->commit();
      
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente',
                    "co_solicitud"  =>  $tb106_solicitud_cuenta_contable_proveedorForm["co_solicitud"]
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
      
      $this->setTemplate('guardarSolicitud');
      
    }
  
  
  
   public function executeGuardarSolicitud(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_solicitud_cuenta");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb033_solicitud_cuenta_contable = Tb033SolicitudCuentaContablePeer::retrieveByPk($codigo);
     }else{
         $tb033_solicitud_cuenta_contable = new Tb033SolicitudCuentaContable();
         $tb033_solicitud_cuenta_contable->setCoUsuario($this->getUser()->getAttribute('codigo'));
     
     }
     try
      { 
        $con->beginTransaction();
       
        $tb033_solicitud_cuenta_contableForm = $this->getRequestParameter('tb033_solicitud_cuenta_contable');

        $tb033_solicitud_cuenta_contable->setCoBanco($tb033_solicitud_cuenta_contableForm["co_banco"]);
        $tb033_solicitud_cuenta_contable->setCoCuenta($tb033_solicitud_cuenta_contableForm["co_cuenta_bancaria"]);
        $tb033_solicitud_cuenta_contable->setCoSolicitud($tb033_solicitud_cuenta_contableForm["co_solicitud"]);
        $tb033_solicitud_cuenta_contable->save($con);
        
        $con->commit();
        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb033_solicitud_cuenta_contableForm["co_solicitud"]));
        $ruta->setInCargarDato(true)->save($con);
     
        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());                 

        $con->commit();
      
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente',
                    "co_solicitud"  =>  $tb033_solicitud_cuenta_contableForm["co_solicitud"]
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
  
  public function executeGuardar(sfWebRequest $request)
  {

      $codigo = $this->getRequestParameter("co_cuenta_bancaria");
      $tx_codigo_cuenta = $this->getRequestParameter("tx_codigo_cuenta");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb011_cuenta_bancaria = Tb011CuentaBancariaPeer::retrieveByPk($codigo);
     }else{
         $tb011_cuenta_bancaria = new Tb011CuentaBancaria();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb011_cuenta_bancariaForm = $this->getRequestParameter('tb011_cuenta_bancaria');
/*CAMPOS*/
        
//        if(!is_numeric(trim($tb011_cuenta_bancariaForm["tx_cuenta_bancaria"]))){
//            $this->data = json_encode(array(
//                "success" => false,
//                "msg" => 'El Campo Cuenta Bancaria deben ser solo numeros, verifique!'
//            ));
//            echo $this->data;
//            return sfView::NONE;
//        }        
        
        $tx_nivel_anterior = substr($tx_codigo_cuenta,0,9);
        
        $cant = strlen(trim($tx_codigo_cuenta));

        if($tx_nivel_anterior!='101010102' && $tx_nivel_anterior!='101099901'){
             $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'La cuenta contable no esta asociada a banco, verifique!'
                ));
                echo $this->data;
                return sfView::NONE;           
        }        
        
        if($cant==18 || $cant==14){
            
        $c = new Criteria();
        $c->add(Tb024CuentaContablePeer::TX_CODIGO_CUENTA,$tx_codigo_cuenta);
        $stmt = Tb024CuentaContablePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        if($campos["co_cuenta_contable"]!=''||$campos["co_cuenta_contable"]!=null){
            
        if($campos["tx_tipo"]=='N'){
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'la cuenta contable no acepta movimiento, verifique!'
                ));
                echo $this->data;
                return sfView::NONE;              
        }else{
            $co_cuenta_contable = $campos["co_cuenta_contable"];
        }                       
        }else{

                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'la cuenta contable no existe, verifique!'
                ));
                echo $this->data;
                return sfView::NONE;               
        
        }           
            
        }else{
             $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'La cuenta contable es invalida'
                ));
                echo $this->data;
                return sfView::NONE;             
        }
        
     if($codigo!=''||$codigo!=null){
        $c2 = new Criteria();
        $c2->add(Tb011CuentaBancariaPeer::CO_CUENTA_CONTABLE,$co_cuenta_contable);
        $c2->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA,$codigo, Criteria::NOT_IN);
        $stmt2 = Tb011CuentaBancariaPeer::doSelectStmt($c2);
        $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        if($campos2["co_cuenta_bancaria"]!=''||$campos2["co_cuenta_bancaria"]!=null){
            $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'La cuenta contable ya fue asignada a otra cuenta bancaria, verifique!'
                ));
                echo $this->data;
                return sfView::NONE;                 
        }
     }else{
        $c2 = new Criteria();
        $c2->add(Tb011CuentaBancariaPeer::CO_CUENTA_CONTABLE,$co_cuenta_contable);
        $stmt2 = Tb011CuentaBancariaPeer::doSelectStmt($c2);
        $campos2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        if($campos2["co_cuenta_bancaria"]!=''||$campos2["co_cuenta_bancaria"]!=null){
            $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'La cuenta contable ya fue asignada a otra cuenta bancaria, verifique!'
                ));
                echo $this->data;
                return sfView::NONE;                 
        }
     }
        
        
                                        
        /*Campo tipo VARCHAR */
        $tb011_cuenta_bancaria->setTxCuentaBancaria($tb011_cuenta_bancariaForm["tx_cuenta_bancaria"]);
                                                        
        /*Campo tipo BIGINT */
        $tb011_cuenta_bancaria->setCoBanco($tb011_cuenta_bancariaForm["co_banco"]);
                                                        
        /*Campo tipo BIGINT */
        $tb011_cuenta_bancaria->setCoTipoCuenta($tb011_cuenta_bancariaForm["co_tipo_cuenta"]);
        
         $tb011_cuenta_bancaria->setCoDescripcionCuenta($tb011_cuenta_bancariaForm["co_descripcion_cuenta"]);
         
         $tb011_cuenta_bancaria->setNuContrato($tb011_cuenta_bancariaForm["nu_contrato"]);

        /*Campo tipo NUMERIC */
        $tb011_cuenta_bancaria->setMoDisponible($tb011_cuenta_bancariaForm["mo_disponible"]);
        
        $tb011_cuenta_bancaria->setCoCuentaContable($co_cuenta_contable);

        /*Campo tipo VARCHAR */
        $tb011_cuenta_bancaria->setTxDescripcion($tb011_cuenta_bancariaForm["tx_descripcion"]);
                                
        /*CAMPOS*/
        $tb011_cuenta_bancaria->save($con);
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
    
    
    public function executeGuardarChequera(sfWebRequest $request)
  {

      $codigo = $this->getRequestParameter("co_chequera");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb79_chequera = Tb079ChequeraPeer::retrieveByPk($codigo);
         
          try
      { 
        $con->beginTransaction();
       
        $tb79_chequeraForm = $this->getRequestParameter('tb079_chequera');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb79_chequera->setCoCuentaBancaria($tb79_chequeraForm["co_cuenta_bancaria"]);
                                                        
        /*Campo tipo BIGINT */
        $tb79_chequera->setTxDescripcion($tb79_chequeraForm["tx_descripcion"]);
                                                        
        /*Campo tipo BIGINT */
        $tb79_chequera->setNroChequera($tb79_chequeraForm["nro_chequera"]);
        
        $tb79_chequera->setAnioChequera($tb79_chequeraForm["anio_chequera"]);
        
        $tb79_chequera->setSerie($tb79_chequeraForm["serie"]);
        
        $tb79_chequera->setNroInicial($tb79_chequeraForm["nro_inicial"]);
        
        $tb79_chequera->setNroFinal($tb79_chequeraForm["nro_final"]);
        list($dia, $mes, $anio) = explode("/",$tb79_chequeraForm["fe_chequera"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb79_chequera->setFeChequera($fecha);
        
        $tb79_chequera->setCoUsuario($this->getUser()->getAttribute('codigo'));
        
        
        
                                
        /*CAMPOS*/
        $tb79_chequera->save($con);
        
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Proceso realizado exitosamente'
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
         $tb79_chequera = new Tb079Chequera();
         
          try
      { 
        $con->beginTransaction();
       
        $tb79_chequeraForm = $this->getRequestParameter('tb079_chequera');
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb79_chequera->setCoCuentaBancaria($tb79_chequeraForm["co_cuenta_bancaria"]);
                                                        
        /*Campo tipo BIGINT */
        $tb79_chequera->setTxDescripcion($tb79_chequeraForm["tx_descripcion"]);
                                                        
        /*Campo tipo BIGINT */
        $tb79_chequera->setNroChequera($tb79_chequeraForm["nro_chequera"]);
        
        $tb79_chequera->setAnioChequera($tb79_chequeraForm["anio_chequera"]);
        
        $tb79_chequera->setSerie($tb79_chequeraForm["serie"]);
        
        $tb79_chequera->setNroInicial($tb79_chequeraForm["nro_inicial"]);
        
        $tb79_chequera->setNroFinal($tb79_chequeraForm["nro_final"]);
        list($dia, $mes, $anio) = explode("/",$tb79_chequeraForm["fe_chequera"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb79_chequera->setFeChequera($fecha);
        
        $tb79_chequera->setCoUsuario($this->getUser()->getAttribute('codigo'));
        
        $tb79_chequera->setCoEstadoChequera(1);
        
        
        
                                
        /*CAMPOS*/
        $tb79_chequera->save($con);
        
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Proceso realizado exitosamente'
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

    public function executeGuardarCheque(sfWebRequest $request)
    {
  
      $codigo = $this->getRequestParameter("co_cheque");
          
       $con = Propel::getConnection();
       if($codigo!=''||$codigo!=null){


           $tb077_cheque = Tb077ChequePeer::retrieveByPk($codigo);

           try
           { 
             $con->beginTransaction();
            
             $tb077_chequeForm = $this->getRequestParameter('tb077_cheque');
     /*CAMPOS*/
                                                             
             /*Campo tipo BIGINT */
             $tb077_cheque->setTxDescripcion($tb077_chequeForm["tx_descripcion"]);
   
             /*Campo tipo BIGINT */
             $tb077_cheque->setNbTitular($tb077_chequeForm["nb_titular"]);
   
             /*Campo tipo BIGINT */
             $tb077_cheque->setMoCheque($tb077_chequeForm["mo_cheque"]);

            /*Campo tipo DATE */
            list($dia, $mes, $anio) = explode("/",$tb077_chequeForm["fe_pago"]);
            $fecha = $anio."-".$mes."-".$dia;
   
             /*Campo tipo BIGINT */
             $tb077_cheque->setFePago($fecha);
   
             /*Campo tipo BOOLEAN */
             $tb077_cheque->setInActivo(true);
                                     
             /*CAMPOS*/
             $tb077_cheque->save($con);
   
             $this->data = json_encode(array(
                         "success" => true,
                         "msg" => 'Cheque Editado Exitosamente!'
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


           $tb077_cheque = new Tb077Cheque();

           try
           { 
             $con->beginTransaction();
            
             $tb077_chequeForm = $this->getRequestParameter('tb077_cheque');
     /*CAMPOS*/
                                             
             /*Campo tipo BIGINT */
             $tb077_cheque->setCoChequera($tb077_chequeForm["co_chequera"]);
                                                             
             /*Campo tipo BIGINT */
             $tb077_cheque->setTxDescripcion($tb077_chequeForm["tx_descripcion"]);
   
             /*Campo tipo BIGINT */
             $tb077_cheque->setCoEstadoCheque(1);
   
             /*Campo tipo BIGINT */
             $tb077_cheque->setNbTitular($tb077_chequeForm["nb_titular"]);
   
             /*Campo tipo BIGINT */
             $tb077_cheque->setMoCheque($tb077_chequeForm["mo_cheque"]);
   
            /*Campo tipo DATE */
            list($dia, $mes, $anio) = explode("/",$tb077_chequeForm["fe_pago"]);
            $fecha = $anio."-".$mes."-".$dia;
   
             /*Campo tipo BIGINT */
             $tb077_cheque->setFePago($fecha);
   
             /*Campo tipo BOOLEAN */
             $tb077_cheque->setInActivo(true);
                                     
             /*CAMPOS*/
             $tb077_cheque->save($con);
   
             $this->data = json_encode(array(
                         "success" => true,
                         "msg" => 'Cheque Creado Exitosamente!'
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
    
      public function executeGuardarestadocheque(sfWebRequest $request){
      
        $co_estado_cheque        = $this->getRequestParameter('co_estado_cheque');
        $tx_observacion        = $this->getRequestParameter('tx_observacion');
        $co_cheque        = $this->getRequestParameter('co_cheque');
        
        $con = Propel::getConnection();
        
        
        try
        { 

              $con->beginTransaction();
              
              $Tb077Cheque = Tb077ChequePeer::retrieveByPK($co_cheque);
              
              $Tb077Cheque->setCoEstadoCheque($co_estado_cheque);
              $Tb077Cheque->setTxObservacion($tx_observacion);    
              $Tb077Cheque->save($con);
              
              $tb76CambioCheque = new Tb075CambioCheque();
              $tb76CambioCheque->setCoCheque($co_cheque);
              $tb76CambioCheque->setCoEstadoCheque($co_estado_cheque);
              $tb76CambioCheque->setTxObservacion($tx_observacion);
              $tb76CambioCheque->setCoUsuario($this->getUser()->getAttribute('codigo'));
              $tb76CambioCheque->save($con);              

                  $data = json_encode(array(
                                  "success" => true,
                                  "msg"     => 'Proceso Realizado Exitosamente'
                  ));

             
             $con->commit();

        }catch (PropelException $e)
        {
              $con->rollback();
              $data = json_encode(array(
                  "success" => false,
                  "msg" =>  $e->getMessage()
              ));
        }


        echo  $data;
        return sfView::NONE;
        
      
  }
  

  public function executeEliminar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_cuenta_bancaria");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb011_cuenta_bancaria = Tb011CuentaBancariaPeer::retrieveByPk($codigo);			
	$tb011_cuenta_bancaria->delete($con);
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
  
    public function executeDeshabilitar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_chequera");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$t01_usuario = Tb079ChequeraPeer::retrieveByPk($codigo);
	$t01_usuario->setCoEstadoChequera(2);			
	$t01_usuario->save($con);
		$this->data = json_encode(array(
			    "success" => true,
			    "msg" => 'Chequera Desabilitada!'
		));
	$con->commit();
	}catch (PropelException $e)
	{
	$con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
//		    "msg" =>  $e->getMessage()
		    "msg" => 'Este registro no se puede Modificar porque <br>se encuentra asociado a otros registros'
		));
	}
  }
  
  public function executeHabilitar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_chequera");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$t01_usuario = Tb079ChequeraPeer::retrieveByPk($codigo);
	$t01_usuario->setCoEstadoChequera(1);			
	$t01_usuario->save($con);
		$this->data = json_encode(array(
			    "success" => true,
			    "msg" => 'Chequera Habilitada!'
		));
	$con->commit();
	}catch (PropelException $e)
	{
	$con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
//		    "msg" =>  $e->getMessage()
		    "msg" => 'Este registro no se puede Modificar porque <br>se encuentra asociado a otros registros'
		));
	}
  }
  
  public function executeAnular(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_chequera");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$t01_usuario = Tb079ChequeraPeer::retrieveByPk($codigo);
	$t01_usuario->setCoEstadoChequera(4);			
	$t01_usuario->save($con);
		$this->data = json_encode(array(
			    "success" => true,
			    "msg" => 'Chequera Habilitada!'
		));
	$con->commit();
	}catch (PropelException $e)
	{
	$con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
//		    "msg" =>  $e->getMessage()
		    "msg" => 'Este registro no se puede Modificar porque <br>se encuentra asociado a otros registros'
		));
	}
  }

  public function executeLista(sfWebRequest $request)
  {

  }

    public function executeChequera(sfWebRequest $request)
  {
        $this->data = json_encode(array(
                            "co_cuenta_bancaria"  => $this->getRequestParameter("co_cuenta_bancaria")
                    ));
  }
  
      public function executeCheque(sfWebRequest $request)
  {
          
    $c = new Criteria();
    $c->add(Tb079ChequeraPeer::CO_CHEQUERA,$this->getRequestParameter("co_chequera"));    
    $stmt = Tb079ChequeraPeer::doSelectStmt($c);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_chequera"  => $res["co_chequera"],
                            "tx_descripcion"  => $res["tx_descripcion"]
                    ));
  }
  
  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
    
    $tx_cuenta_bancaria      =   $this->getRequestParameter("tx_cuenta_bancaria");
    $co_banco      =   $this->getRequestParameter("co_banco");
    $co_tipo_cuenta      =   $this->getRequestParameter("co_tipo_cuenta");
    
    
    $c = new Criteria();
    $c->addSelectColumn(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
    $c->addSelectColumn(Tb011CuentaBancariaPeer::TX_CUENTA_BANCARIA);
    $c->addSelectColumn(Tb011CuentaBancariaPeer::NU_CONTRATO);
    $c->addSelectColumn(Tb010BancoPeer::TX_BANCO);
    $c->addSelectColumn(Tb012TipoCuentaBancariaPeer::TX_TIPO_CUENTA);
    $c->addSelectColumn(Tb014DescripcionCuentaPeer::TX_DESCRIPCION_CUENTA);
    $c->addSelectColumn(Tb024CuentaContablePeer::TX_CUENTA);
    $c->addJoin(Tb011CuentaBancariaPeer::CO_CUENTA_CONTABLE, Tb024CuentaContablePeer::CO_CUENTA_CONTABLE,   Criteria::LEFT_JOIN);
    $c->addJoin(Tb011CuentaBancariaPeer::CO_TIPO_CUENTA, Tb012TipoCuentaBancariaPeer::CO_TIPO_CUENTA, Criteria::LEFT_JOIN);
    $c->addJoin(Tb011CuentaBancariaPeer::CO_DESCRIPCION_CUENTA, Tb014DescripcionCuentaPeer::CO_DESCRIPCION_CUENTA, Criteria::LEFT_JOIN);
    $c->addJoin(Tb010BancoPeer::CO_BANCO, Tb011CuentaBancariaPeer::CO_BANCO);
    $c->addAscendingOrderByColumn(Tb011CuentaBancariaPeer::CO_BANCO);

    if($this->getRequestParameter("BuscarBy")=="true"){
        if($tx_cuenta_bancaria!=""){$c->add(Tb011CuentaBancariaPeer::tx_cuenta_bancaria,'%'.$tx_cuenta_bancaria.'%',Criteria::LIKE);}

        if($co_banco!=""){$c->add(Tb011CuentaBancariaPeer::co_banco,$co_banco);}

        if($co_tipo_cuenta!=""){$c->add(Tb011CuentaBancariaPeer::co_tipo_cuenta,$co_tipo_cuenta);}    
    }
    
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb011CuentaBancariaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        
    $stmt = Tb011CuentaBancariaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_cuenta_bancaria"     => trim($res["co_cuenta_bancaria"]),
            "tx_cuenta_bancaria"     => trim($res["tx_cuenta_bancaria"]),
            "co_banco"               => trim($res["tx_banco"]),
            "co_tipo_cuenta"         => trim($res["tx_tipo_cuenta"]),
            "tx_descripcion_cuenta"  => trim($res["tx_descripcion_cuenta"]),
            "tx_cuenta"              => trim($res["tx_cuenta"]),
            "nu_contrato"              => trim($res["nu_contrato"])
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }
    
      public function executeStorelistachequera(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
            
    $co_cuenta_bancaria = $this->getRequestParameter("co_cuenta_bancaria");    
    
    $c = new Criteria();
    $c->addSelectColumn(Tb079ChequeraPeer::CO_CHEQUERA);
    $c->addSelectColumn(Tb079ChequeraPeer::CO_CUENTA_BANCARIA);
    $c->addSelectColumn(Tb079ChequeraPeer::TX_DESCRIPCION);
    $c->addSelectColumn(Tb079ChequeraPeer::NRO_CHEQUERA);
    $c->addSelectColumn(Tb079ChequeraPeer::ANIO_CHEQUERA);
    $c->addSelectColumn(Tb079ChequeraPeer::SERIE);
    $c->addSelectColumn(Tb079ChequeraPeer::NRO_INICIAL);
    $c->addSelectColumn(Tb079ChequeraPeer::NRO_FINAL);
    $c->addSelectColumn(Tb079ChequeraPeer::FE_CHEQUERA);
    $c->addSelectColumn(Tb079ChequeraPeer::CO_ESTADO_CHEQUERA);
    $c->addSelectColumn(Tb078EstadoChequeraPeer::TX_ESTADO_CHEQUERA);
    
    $c->add(Tb079ChequeraPeer::CO_CUENTA_BANCARIA,$co_cuenta_bancaria);
    $c->addJoin(Tb078EstadoChequeraPeer::CO_ESTADO_CHEQUERA, Tb079ChequeraPeer::CO_ESTADO_CHEQUERA);
    $cantidadTotal = Tb079ChequeraPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb079ChequeraPeer::ANIO_CHEQUERA);
    
    $stmt = Tb079ChequeraPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            
    $registros[] = array(
            "co_chequera"     => trim($res["co_chequera"]),
            "co_cuenta_bancaria"    => trim($res["co_cuenta_bancaria"]),
            "tx_descripcion"           => trim($res["tx_descripcion"]),
            "chequera"     => trim($res["nro_chequera"].'-'.$res["anio_chequera"]),
            "nro_chequera"     => trim($res["nro_chequera"]),
            "anio_chequera"             => trim($res["anio_chequera"]),
            "serie"             => trim($res["serie"]),
            "nro_inicial"             => trim($res["nro_inicial"]),
            "nro_final"             => trim($res["nro_final"]),
            "fe_chequera"             => trim($res["fe_chequera"]),
            "estado"             => trim($res["tx_estado_chequera"]),
            "co_estado_chequera"             => trim($res["co_estado_chequera"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }
    
    public function executeStorelistacheque(sfWebRequest $request)
    {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
            
    $co_chequera = $this->getRequestParameter("co_chequera");    
    
    $c = new Criteria();
    $c->addSelectColumn(Tb077ChequePeer::CO_CHEQUE);
    $c->addSelectColumn(Tb077ChequePeer::TX_DESCRIPCION);
    $c->addSelectColumn(Tb077ChequePeer::CO_ESTADO_CHEQUE);
    $c->addSelectColumn(Tb077ChequePeer::CO_CHEQUERA);
    $c->addSelectColumn(Tb077ChequePeer::TX_OBSERVACION);
    $c->addSelectColumn(Tb077ChequePeer::NB_TITULAR);
    $c->addSelectColumn(Tb077ChequePeer::MO_CHEQUE);
    $c->addSelectColumn(Tb077ChequePeer::FE_PAGO);
    $c->addSelectColumn(Tb076EstadoChequePeer::TX_ESTADO_CHEQUE);
    
    $c->add(Tb077ChequePeer::CO_CHEQUERA,$co_chequera);
    $c->addJoin(Tb076EstadoChequePeer::CO_ESTADO_CHEQUE, Tb077ChequePeer::CO_ESTADO_CHEQUE);
    $cantidadTotal = Tb077ChequePeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb077ChequePeer::TX_DESCRIPCION);
    
    $stmt = Tb077ChequePeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            
    $registros[] = array(
            "co_cheque"     => trim($res["co_cheque"]),
            "co_chequera"    => trim($res["co_chequera"]),
            "tx_descripcion"           => trim($res["tx_descripcion"]),
            "co_estado_cheque"     => trim($res["co_estado_cheque"]),
            "tx_estado_cheque"     => trim($res["tx_estado_cheque"]),
            "tx_observacion"     => trim($res["tx_observacion"]),
            "nb_titular"     => trim($res["nb_titular"]),
            "mo_cheque"     => trim($res["mo_cheque"]),
            "fe_pago"     => trim($res["fe_pago"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }
    

                                //modelo fk tb010_banco.CO_BANCO
    public function executeStorefkcobanco(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb010BancoPeer::IN_ENTE,true);
        $c->addAscendingOrderByColumn(Tb010BancoPeer::CO_BANCO);
        $stmt = Tb010BancoPeer::doSelectStmt($c);
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
    
     public function executeStorefkcobancoproveedor(sfWebRequest $request){
        
        $co_proveedor = $this->getRequestParameter("co_proveedor");
         
        $c = new Criteria();
        $c->add(Tb065CuentaProveedorPeer::CO_PROVEEDOR,$co_proveedor);
        $c->addJoin(Tb010BancoPeer::CO_BANCO, Tb065CuentaProveedorPeer::CO_BANCO);
        $c->add(Tb065CuentaProveedorPeer::CO_CUENTA_CONTABLE,NULL,Criteria::ISNULL);
        $c->addAscendingOrderByColumn(Tb010BancoPeer::CO_BANCO);
        
        $stmt = Tb010BancoPeer::doSelectStmt($c);
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
    
    
                    //modelo fk tb012_tipo_cuenta_bancaria.CO_TIPO_CUENTA
    public function executeStorefkcotipocuenta(sfWebRequest $request){
        $c = new Criteria();
        //$c->add(Tb077ChequePeer::CO_CHEQUERA,$co_chequera);
        $c->addAscendingOrderByColumn(Tb012TipoCuentaBancariaPeer::CO_TIPO_CUENTA);
        $stmt = Tb012TipoCuentaBancariaPeer::doSelectStmt($c);
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
    
    public function executeStorefkcocuentaproveedor(sfWebRequest $request){
        
        $co_banco = $this->getRequestParameter("co_banco");
        $co_proveedor = $this->getRequestParameter("co_proveedor");
        
        $c = new Criteria();
        $c->add(Tb065CuentaProveedorPeer::CO_BANCO,$co_banco);
        $c->add(Tb065CuentaProveedorPeer::CO_PROVEEDOR,$co_proveedor);
        $c->add(Tb065CuentaProveedorPeer::CO_CUENTA_CONTABLE,NULL,Criteria::ISNULL);        
        
        $c->addAscendingOrderByColumn(Tb065CuentaProveedorPeer::TX_CUENTA);
        $stmt = Tb065CuentaProveedorPeer::doSelectStmt($c);
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
    
    
    
    //modelo fk tb012_tipo_cuenta_bancaria.CO_TIPO_CUENTA
    public function executeStorefkcocuenta(sfWebRequest $request){
        
        $co_banco = $this->getRequestParameter("co_banco");
        
        $c = new Criteria();
        $c->add(Tb011CuentaBancariaPeer::CO_BANCO,$co_banco);
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
    
    
    public function executeStorefkcodescripcioncuenta(sfWebRequest $request){
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb014DescripcionCuentaPeer::CO_DESCRIPCION_CUENTA);
        $stmt = Tb014DescripcionCuentaPeer::doSelectStmt($c);
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
        
    public function executeStorefkcoestadocheque(sfWebRequest $request){
        
        $co_estado_cheque = $this->getRequestParameter("co_estado_cheque");
        $c = new Criteria();
        $c->add(Tb076EstadoChequePeer::CO_ESTADO_CHEQUE,$co_estado_cheque);
        $c->addOr(Tb076EstadoChequePeer::CO_ESTADO_CHEQUE,"2",Criteria::IN);
        $c->addOr(Tb076EstadoChequePeer::CO_ESTADO_CHEQUE,"5",Criteria::IN);
        $c->addOr(Tb076EstadoChequePeer::CO_ESTADO_CHEQUE,"6",Criteria::IN);
        $c->addAscendingOrderByColumn(Tb076EstadoChequePeer::CO_ESTADO_CHEQUE);
        $stmt = Tb076EstadoChequePeer::doSelectStmt($c);
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