<?php

/**
 * IngresoFinanciero actions.
 *
 * @package    gobel
 * @subpackage IngresoFinanciero
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class IngresoFinancieroActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('IngresoFinanciero', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('IngresoFinanciero', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb155CuentaBancariaHistoricoPeer::ID,$codigo);
        
        $stmt = Tb155CuentaBancariaHistoricoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "id_tb011_cuenta_bancaria"     => $campos["id_tb011_cuenta_bancaria"],
                            "mo_transaccion"     => $campos["mo_transaccion"],
                            "fe_transaccion"     => $campos["fe_transaccion"],
                            "mo_saldo_nuevo"     => $campos["mo_saldo_nuevo"],
                            "de_observacion"     => $campos["de_observacion"],
                            "id_tb010_banco"     => $campos["id_tb010_banco"],
                            "id_tb154_tipo_cuenta_movimiento"     => $campos["id_tb154_tipo_cuenta_movimiento"],
                            "id_tb153_tipo_documento_cuenta"     => $campos["id_tb153_tipo_documento_cuenta"],
                            "id_tb156_subtipo_documento"     => $campos["id_tb156_subtipo_documento"],
                            "nu_documento"     => $campos["nu_documento"],
                            "mo_saldo_anterior"     => $campos["mo_saldo_anterior"],
                            "nu_transaccion"     => $campos["nu_transaccion"],
                            "co_solicitud"     => $campos["co_solicitud"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "id_tb011_cuenta_bancaria"     => "",
                            "mo_transaccion"     => "",
                            "fe_transaccion"     => "",
                            "mo_saldo_nuevo"     => "",
                            "de_observacion"     => "",
                            "id_tb010_banco"     => "",
                            "id_tb154_tipo_cuenta_movimiento"     => "",
                            "id_tb153_tipo_documento_cuenta"     => "",
                            "id_tb156_subtipo_documento"     => "",
                            "nu_documento"     => "",
                            "mo_saldo_anterior"     => "",
                            "nu_transaccion"     => "",
                            "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

        $codigo = $this->getRequestParameter("id");
        
        $con = Propel::getConnection();
        if($codigo!=''||$codigo!=null){

            $tb155_cuenta_bancaria_historico = Tb155CuentaBancariaHistoricoPeer::retrieveByPk($codigo);

            try
            { 
              $con->beginTransaction();
             
              $tb155_cuenta_bancaria_historicoForm = $this->getRequestParameter('tb155_cuenta_bancaria_historico');
              /*CAMPOS*/
                                              
              /*Campo tipo BOOLEAN */
              $tb155_cuenta_bancaria_historico->setInActivo(true);
                                                              
              /*Campo tipo TIMESTAMP */
              //$tb155_cuenta_bancaria_historico->setCreatedAt($fecha);
                                                              
              /*Campo tipo TIMESTAMP */
              //$tb155_cuenta_bancaria_historico->setUpdatedAt($fecha);
                                                              
              /*Campo tipo BIGINT */
              $tb155_cuenta_bancaria_historico->setIdTb011CuentaBancaria($tb155_cuenta_bancaria_historicoForm["id_tb011_cuenta_bancaria"]);
                                                              
              /*Campo tipo NUMERIC */
              $tb155_cuenta_bancaria_historico->setMoTransaccion($tb155_cuenta_bancaria_historicoForm["mo_transaccion"]);
                                                                      
              /*Campo tipo DATE */
              list($dia, $mes, $anio) = explode("/",$tb155_cuenta_bancaria_historicoForm["fe_transaccion"]);
              $fecha = $anio."-".$mes."-".$dia;
              $tb155_cuenta_bancaria_historico->setFeTransaccion($fecha);
                                                              
              /*Campo tipo VARCHAR */
              $tb155_cuenta_bancaria_historico->setDeObservacion($tb155_cuenta_bancaria_historicoForm["de_observacion"]);
                                                              
              /*Campo tipo BIGINT */
              $tb155_cuenta_bancaria_historico->setIdTb010Banco($tb155_cuenta_bancaria_historicoForm["id_tb010_banco"]);
                                                              
              /*Campo tipo BIGINT */
              $tb155_cuenta_bancaria_historico->setIdTb154TipoCuentaMovimiento($tb155_cuenta_bancaria_historicoForm["id_tb154_tipo_cuenta_movimiento"]);
                                                              
              /*Campo tipo BIGINT */
              $tb155_cuenta_bancaria_historico->setIdTb153TipoDocumentoCuenta($tb155_cuenta_bancaria_historicoForm["id_tb153_tipo_documento_cuenta"]);
                                                              
              /*Campo tipo BIGINT */
              $tb155_cuenta_bancaria_historico->setIdTb156SubtipoDocumento($tb155_cuenta_bancaria_historicoForm["id_tb156_subtipo_documento"]);
                                                              
              /*Campo tipo VARCHAR */
              //$tb155_cuenta_bancaria_historico->setNuDocumento($tb155_cuenta_bancaria_historicoForm["nu_documento"]);
      
              $tb011_cuenta_bancaria = new Criteria();
              $tb011_cuenta_bancaria->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA, $tb155_cuenta_bancaria_historicoForm["id_tb011_cuenta_bancaria"]);
              $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::TX_CUENTA_BANCARIA);
              $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::MO_DISPONIBLE);
              $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::MO_INGRESO);
              $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::MO_EGRESO);
              $stmt = Tb011CuentaBancariaPeer::doSelectStmt($tb011_cuenta_bancaria);
              $campos = $stmt->fetch(PDO::FETCH_ASSOC);
      
              $saldo_anterior = $campos["mo_disponible"];
              $saldo_nuevo = $tb155_cuenta_bancaria_historicoForm["mo_transaccion"]+$campos["mo_disponible"];
      
              /*Campo tipo NUMERIC */
              //$tb155_cuenta_bancaria_historico->setMoSaldoNuevo($saldo_nuevo);
              //$tb155_cuenta_bancaria_historico->setMoSaldoAnterior($saldo_anterior);
                                    
                /*Campo tipo VARCHAR */
                $tb155_cuenta_bancaria_historico->setNuTransaccion($tb155_cuenta_bancaria_historicoForm["nu_transaccion"]);

              /*CAMPOS*/
              $tb155_cuenta_bancaria_historico->save($con);
              
               
                if($tb155_cuenta_bancaria_historicoForm["id_tb153_tipo_documento_cuenta"]==1){
                $co_tipo_asiento = 8;
                }else{
                if($tb155_cuenta_bancaria_historicoForm["id_tb153_tipo_documento_cuenta"] == 2){
                $co_tipo_asiento = 10;
                }else{
                $co_tipo_asiento = 9;
                }   
                }                
              
                $wherec = new Criteria();
                $wherec->add(Tb061AsientoContablePeer::ID_TB155_CUENTA_BANCARIA_HISTORICO, $codigo, Criteria::EQUAL);
                BasePeer::doDelete($wherec, $con);                 
                
               $c = new Criteria();
               $c->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA,$tb155_cuenta_bancaria_historicoForm["id_tb011_cuenta_bancaria"]);
               $stmt = Tb011CuentaBancariaPeer::doSelectStmt($c);
               $reg = $stmt->fetch(PDO::FETCH_ASSOC);            
             
               $c1 = new Criteria();
               $c1->add(Tb156SubtipoDocumentoPeer::ID,$tb155_cuenta_bancaria_historicoForm["id_tb156_subtipo_documento"]);
               $stmt1 = Tb156SubtipoDocumentoPeer::doSelectStmt($c1);
               $reg1 = $stmt1->fetch(PDO::FETCH_ASSOC);        
               
               if($tb155_cuenta_bancaria_historicoForm["id_tb154_tipo_cuenta_movimiento"]==3){
              
                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoHaber($tb155_cuenta_bancaria_historicoForm["mo_transaccion"])
                                  ->setCoCuentaContable($reg["co_cuenta_contable"])
                                  ->setCreatedAt($fecha)
                                  ->setCoSolicitud($tb155_cuenta_bancaria_historicoForm["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCoTipoAsiento($co_tipo_asiento)
                                  ->setInActivo(true)
                                  ->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId())
                                  ->save($con);
                    

                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoDebe($tb155_cuenta_bancaria_historicoForm["mo_transaccion"])
                                  ->setCoCuentaContable($reg1["co_cuenta_contable"])
                                  ->setCreatedAt($fecha)
                                  ->setCoSolicitud($tb155_cuenta_bancaria_historicoForm["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCoTipoAsiento($co_tipo_asiento)
                                  ->setInActivo(true)
                                  ->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId())
                                  ->save($con); 
                    
               }else{
                   
                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoDebe($tb155_cuenta_bancaria_historicoForm["mo_transaccion"])
                                  ->setCoCuentaContable($reg["co_cuenta_contable"])
                                  ->setCreatedAt($fecha)
                                  ->setCoSolicitud($tb155_cuenta_bancaria_historicoForm["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCoTipoAsiento($co_tipo_asiento)
                                  ->setInActivo(true)
                                  ->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId())
                                  ->save($con);
                    

                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoHaber($tb155_cuenta_bancaria_historicoForm["mo_transaccion"])
                                  ->setCoCuentaContable($reg1["co_cuenta_contable"])
                                  ->setCreatedAt($fecha)
                                  ->setCoSolicitud($tb155_cuenta_bancaria_historicoForm["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCoTipoAsiento($co_tipo_asiento)
                                  ->setInActivo(true)
                                  ->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId())
                                  ->save($con);                    
                   
               }      
                    
      
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

            $tb155_cuenta_bancaria_historico = new Tb155CuentaBancariaHistorico();

            try
            { 
              $con->beginTransaction();
             
              $tb155_cuenta_bancaria_historicoForm = $this->getRequestParameter('tb155_cuenta_bancaria_historico');
              /*CAMPOS*/
                                              
              /*Campo tipo BOOLEAN */
              $tb155_cuenta_bancaria_historico->setInActivo(true);
                                                              
              /*Campo tipo TIMESTAMP */
              //$tb155_cuenta_bancaria_historico->setCreatedAt($fecha);
                                                              
              /*Campo tipo TIMESTAMP */
              //$tb155_cuenta_bancaria_historico->setUpdatedAt($fecha);
                                                              
              /*Campo tipo BIGINT */
              $tb155_cuenta_bancaria_historico->setIdTb011CuentaBancaria($tb155_cuenta_bancaria_historicoForm["id_tb011_cuenta_bancaria"]);
                                                              
              /*Campo tipo NUMERIC */
              $tb155_cuenta_bancaria_historico->setMoTransaccion($tb155_cuenta_bancaria_historicoForm["mo_transaccion"]);
                                                                      
              /*Campo tipo DATE */
              list($dia, $mes, $anio) = explode("/",$tb155_cuenta_bancaria_historicoForm["fe_transaccion"]);
              $fecha = $anio."-".$mes."-".$dia;
              $tb155_cuenta_bancaria_historico->setFeTransaccion($fecha);
                                                              
              /*Campo tipo VARCHAR */
              $tb155_cuenta_bancaria_historico->setDeObservacion($tb155_cuenta_bancaria_historicoForm["de_observacion"]);
                                                              
              /*Campo tipo BIGINT */
              $tb155_cuenta_bancaria_historico->setIdTb010Banco($tb155_cuenta_bancaria_historicoForm["id_tb010_banco"]);
                                                              
              /*Campo tipo BIGINT */
              $tb155_cuenta_bancaria_historico->setIdTb154TipoCuentaMovimiento($tb155_cuenta_bancaria_historicoForm["id_tb154_tipo_cuenta_movimiento"]);
                                                              
              /*Campo tipo BIGINT */
              $tb155_cuenta_bancaria_historico->setIdTb153TipoDocumentoCuenta($tb155_cuenta_bancaria_historicoForm["id_tb153_tipo_documento_cuenta"]);
                                                              
              /*Campo tipo BIGINT */
              $tb155_cuenta_bancaria_historico->setIdTb156SubtipoDocumento($tb155_cuenta_bancaria_historicoForm["id_tb156_subtipo_documento"]);

                /*Campo tipo BIGINT */
                $tb155_cuenta_bancaria_historico->setCoSolicitud($tb155_cuenta_bancaria_historicoForm["co_solicitud"]);
                                                              
              /*Campo tipo VARCHAR */
              //$tb155_cuenta_bancaria_historico->setNuDocumento($tb155_cuenta_bancaria_historicoForm["nu_documento"]);

              if($tb155_cuenta_bancaria_historicoForm["id_tb154_tipo_cuenta_movimiento"]==3){  
      
                $tb011_cuenta_bancaria = new Criteria();
                $tb011_cuenta_bancaria->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA, $tb155_cuenta_bancaria_historicoForm["id_tb011_cuenta_bancaria"]);
                $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::TX_CUENTA_BANCARIA);
                $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::MO_DISPONIBLE);
                $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::MO_INGRESO);
                $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::MO_EGRESO);
                $stmt = Tb011CuentaBancariaPeer::doSelectStmt($tb011_cuenta_bancaria);
                $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
                $saldo_anterior = $campos["mo_disponible"];
                $saldo_nuevo = $campos["mo_disponible"] - $tb155_cuenta_bancaria_historicoForm["mo_transaccion"];
        
                /*Campo tipo NUMERIC */
                $tb155_cuenta_bancaria_historico->setMoSaldoNuevo($saldo_nuevo);
                $tb155_cuenta_bancaria_historico->setMoSaldoAnterior($saldo_anterior);

                $tb011_cuenta_bancaria = Tb011CuentaBancariaPeer::retrieveByPK($tb155_cuenta_bancaria_historicoForm["id_tb011_cuenta_bancaria"]);
                $tb011_cuenta_bancaria->setMoDisponible($saldo_nuevo);
                $tb011_cuenta_bancaria->save($con);

              }

              if($tb155_cuenta_bancaria_historicoForm["id_tb154_tipo_cuenta_movimiento"]==4){  
      
                $tb011_cuenta_bancaria = new Criteria();
                $tb011_cuenta_bancaria->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA, $tb155_cuenta_bancaria_historicoForm["id_tb011_cuenta_bancaria"]);
                $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::TX_CUENTA_BANCARIA);
                $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::MO_DISPONIBLE);
                $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::MO_INGRESO);
                $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::MO_EGRESO);
                $stmt = Tb011CuentaBancariaPeer::doSelectStmt($tb011_cuenta_bancaria);
                $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
                $saldo_anterior = $campos["mo_disponible"];
                $saldo_nuevo = $tb155_cuenta_bancaria_historicoForm["mo_transaccion"]+$campos["mo_disponible"];
        
                /*Campo tipo NUMERIC */
                $tb155_cuenta_bancaria_historico->setMoSaldoNuevo($saldo_nuevo);
                $tb155_cuenta_bancaria_historico->setMoSaldoAnterior($saldo_anterior);

                $tb011_cuenta_bancaria = Tb011CuentaBancariaPeer::retrieveByPK($tb155_cuenta_bancaria_historicoForm["id_tb011_cuenta_bancaria"]);
                $tb011_cuenta_bancaria->setMoDisponible($saldo_nuevo);
                $tb011_cuenta_bancaria->save($con);

              }

                /*Campo tipo VARCHAR */
                $tb155_cuenta_bancaria_historico->setNuTransaccion($tb155_cuenta_bancaria_historicoForm["nu_transaccion"]);
                                      
              /*CAMPOS*/
              $tb155_cuenta_bancaria_historico->save($con);
              
                if($tb155_cuenta_bancaria_historicoForm["id_tb153_tipo_documento_cuenta"]==1){
                $co_tipo_asiento = 8;
                }else{
                if($tb155_cuenta_bancaria_historicoForm["id_tb153_tipo_documento_cuenta"] == 2){
                $co_tipo_asiento = 10;
                }else{
                $co_tipo_asiento = 9;
                }   
                }                
              
               $c = new Criteria();
               $c->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA,$tb155_cuenta_bancaria_historicoForm["id_tb011_cuenta_bancaria"]);
               $stmt = Tb011CuentaBancariaPeer::doSelectStmt($c);
               $reg = $stmt->fetch(PDO::FETCH_ASSOC);            
             
               $c1 = new Criteria();
               $c1->add(Tb156SubtipoDocumentoPeer::ID,$tb155_cuenta_bancaria_historicoForm["id_tb156_subtipo_documento"]);
               $stmt1 = Tb156SubtipoDocumentoPeer::doSelectStmt($c1);
               $reg1 = $stmt1->fetch(PDO::FETCH_ASSOC);        
               
               if($tb155_cuenta_bancaria_historicoForm["id_tb154_tipo_cuenta_movimiento"]==3){
              
                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoHaber($tb155_cuenta_bancaria_historicoForm["mo_transaccion"])
                                  ->setCoCuentaContable($reg["co_cuenta_contable"])
                                  ->setCreatedAt($fecha)
                                  ->setCoSolicitud($tb155_cuenta_bancaria_historicoForm["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCoTipoAsiento($co_tipo_asiento)
                                  ->setInActivo(true)
                                  ->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId())
                                  ->save($con);
                    

                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoDebe($tb155_cuenta_bancaria_historicoForm["mo_transaccion"])
                                  ->setCoCuentaContable($reg1["co_cuenta_contable"])
                                  ->setCreatedAt($fecha)
                                  ->setCoSolicitud($tb155_cuenta_bancaria_historicoForm["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCoTipoAsiento($co_tipo_asiento)
                                  ->setInActivo(true)
                                  ->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId())
                                  ->save($con); 
                    
               }else{
                   
                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoDebe($tb155_cuenta_bancaria_historicoForm["mo_transaccion"])
                                  ->setCoCuentaContable($reg["co_cuenta_contable"])
                                  ->setCreatedAt($fecha)
                                  ->setCoSolicitud($tb155_cuenta_bancaria_historicoForm["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCoTipoAsiento($co_tipo_asiento)
                                  ->setInActivo(true)
                                  ->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId())
                                  ->save($con);
                    

                    $tb061_asiento_contable = new Tb061AsientoContable();
                    $tb061_asiento_contable->setMoHaber($tb155_cuenta_bancaria_historicoForm["mo_transaccion"])
                                  ->setCoCuentaContable($reg1["co_cuenta_contable"])
                                  ->setCreatedAt($fecha)
                                  ->setCoSolicitud($tb155_cuenta_bancaria_historicoForm["co_solicitud"])
                                  ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setCoTipoAsiento($co_tipo_asiento)
                                  ->setInActivo(true)
                                  ->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId())
                                  ->save($con);                    
                   
               }              
      
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
  

  public function executeEliminar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("id");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb155_cuenta_bancaria_historico = Tb155CuentaBancariaHistoricoPeer::retrieveByPk($codigo);			
	$tb155_cuenta_bancaria_historico->delete($con);
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
            "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
        ));
  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $id_tb011_cuenta_bancaria      =   $this->getRequestParameter("id_tb011_cuenta_bancaria");
            $mo_transaccion      =   $this->getRequestParameter("mo_transaccion");
            $fe_transaccion      =   $this->getRequestParameter("fe_transaccion");
            $mo_saldo_nuevo      =   $this->getRequestParameter("mo_saldo_nuevo");
            $de_observacion      =   $this->getRequestParameter("de_observacion");
            $id_tb010_banco      =   $this->getRequestParameter("id_tb010_banco");
            $id_tb154_tipo_cuenta_movimiento      =   $this->getRequestParameter("id_tb154_tipo_cuenta_movimiento");
            $id_tb153_tipo_documento_cuenta      =   $this->getRequestParameter("id_tb153_tipo_documento_cuenta");
            $id_tb156_subtipo_documento      =   $this->getRequestParameter("id_tb156_subtipo_documento");
            $nu_documento      =   $this->getRequestParameter("nu_documento");
            $mo_saldo_anterior      =   $this->getRequestParameter("mo_saldo_anterior");
            $co_solicitud      =   $this->getRequestParameter("co_solicitud");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                            
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb155CuentaBancariaHistoricoPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb155CuentaBancariaHistoricoPeer::updated_at,$fecha);
    }
                                            if($id_tb011_cuenta_bancaria!=""){$c->add(Tb155CuentaBancariaHistoricoPeer::id_tb011_cuenta_bancaria,$id_tb011_cuenta_bancaria);}
    
                                            if($mo_transaccion!=""){$c->add(Tb155CuentaBancariaHistoricoPeer::mo_transaccion,$mo_transaccion);}
    
                                    
        if($fe_transaccion!=""){
    list($dia, $mes,$anio) = explode("/",$fe_transaccion);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb155CuentaBancariaHistoricoPeer::fe_transaccion,$fecha);
    }
                                            if($mo_saldo_nuevo!=""){$c->add(Tb155CuentaBancariaHistoricoPeer::mo_saldo_nuevo,$mo_saldo_nuevo);}
    
                                        if($de_observacion!=""){$c->add(Tb155CuentaBancariaHistoricoPeer::de_observacion,'%'.$de_observacion.'%',Criteria::LIKE);}
        
                                            if($id_tb010_banco!=""){$c->add(Tb155CuentaBancariaHistoricoPeer::id_tb010_banco,$id_tb010_banco);}
    
                                            if($id_tb154_tipo_cuenta_movimiento!=""){$c->add(Tb155CuentaBancariaHistoricoPeer::id_tb154_tipo_cuenta_movimiento,$id_tb154_tipo_cuenta_movimiento);}
    
                                            if($id_tb153_tipo_documento_cuenta!=""){$c->add(Tb155CuentaBancariaHistoricoPeer::id_tb153_tipo_documento_cuenta,$id_tb153_tipo_documento_cuenta);}
    
                                            if($id_tb156_subtipo_documento!=""){$c->add(Tb155CuentaBancariaHistoricoPeer::id_tb156_subtipo_documento,$id_tb156_subtipo_documento);}
    
                                        if($nu_documento!=""){$c->add(Tb155CuentaBancariaHistoricoPeer::nu_documento,'%'.$nu_documento.'%',Criteria::LIKE);}
        
                                            if($mo_saldo_anterior!=""){$c->add(Tb155CuentaBancariaHistoricoPeer::mo_saldo_anterior,$mo_saldo_anterior);}
    
                    }
    $c->setIgnoreCase(true);
    $c->add(Tb155CuentaBancariaHistoricoPeer::CO_SOLICITUD, $co_solicitud);
    $cantidadTotal = Tb155CuentaBancariaHistoricoPeer::doCount($c);
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb155CuentaBancariaHistoricoPeer::ID);

        

        $c->addSelectColumn(Tb155CuentaBancariaHistoricoPeer::ID);
        $c->addSelectColumn(Tb010BancoPeer::TX_BANCO);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::TX_DESCRIPCION);
        $c->addSelectColumn(Tb155CuentaBancariaHistoricoPeer::NU_DOCUMENTO);
        $c->addSelectColumn(Tb155CuentaBancariaHistoricoPeer::MO_TRANSACCION);
        $c->addSelectColumn(Tb155CuentaBancariaHistoricoPeer::MO_SALDO_NUEVO);
        $c->addSelectColumn(Tb155CuentaBancariaHistoricoPeer::MO_SALDO_ANTERIOR);
        $c->addSelectColumn(Tb155CuentaBancariaHistoricoPeer::FE_TRANSACCION);
        $c->addSelectColumn(Tb155CuentaBancariaHistoricoPeer::NU_TRANSACCION);

        $c->addJoin(Tb010BancoPeer::CO_BANCO, Tb155CuentaBancariaHistoricoPeer::ID_TB010_BANCO);
        $c->addJoin(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA, Tb155CuentaBancariaHistoricoPeer::ID_TB011_CUENTA_BANCARIA);
        
    $stmt = Tb155CuentaBancariaHistoricoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "id_tb011_cuenta_bancaria"     => trim($res["tx_cuenta_bancaria"]),
            "mo_transaccion"     => trim($res["mo_transaccion"]),
            "fe_transaccion"     => trim($res["fe_transaccion"]),
            "mo_saldo_nuevo"     => trim($res["mo_saldo_nuevo"]),
            "de_observacion"     => trim($res["de_observacion"]),
            "id_tb010_banco"     => trim($res["tx_banco"]),
            "tx_descripcion"     => trim($res["tx_descripcion"]),
            "id_tb154_tipo_cuenta_movimiento"     => trim($res["id_tb154_tipo_cuenta_movimiento"]),
            "id_tb153_tipo_documento_cuenta"     => trim($res["id_tb153_tipo_documento_cuenta"]),
            "id_tb156_subtipo_documento"     => trim($res["id_tb156_subtipo_documento"]),
            "nu_documento"     => trim($res["nu_documento"]),
            "mo_saldo_anterior"     => trim($res["mo_saldo_anterior"]),
            "nu_transaccion"     => trim($res["nu_transaccion"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                        //modelo fk tb011_cuenta_bancaria.CO_CUENTA_BANCARIA
    public function executeStorefkidtb011cuentabancaria(sfWebRequest $request){

        $banco      =   $this->getRequestParameter("banco");

        $c = new Criteria();
        $c->add(Tb011CuentaBancariaPeer::CO_BANCO, $banco);
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
                                                                    //modelo fk tb010_banco.CO_BANCO
    public function executeStorefkidtb010banco(sfWebRequest $request){
        $c = new Criteria();
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
                    //modelo fk tb154_tipo_cuenta_movimiento.ID
    public function executeStorefkidtb154tipocuentamovimiento(sfWebRequest $request){

        $condicion = array(3, 4);

        $c = new Criteria();
        $c->add(Tb154TipoCuentaMovimientoPeer::ID, $condicion, Criteria::IN);
        $stmt = Tb154TipoCuentaMovimientoPeer::doSelectStmt($c);
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
                    //modelo fk tb153_tipo_documento_cuenta.ID
    public function executeStorefkidtb153tipodocumentocuenta(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb153TipoDocumentoCuentaPeer::doSelectStmt($c);
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
                    //modelo fk tb156_subtipo_documento.ID
    public function executeStorefkidtb156subtipodocumento(sfWebRequest $request){

        $tipo      =   $this->getRequestParameter("tipo");

        $c = new Criteria();
        $c->add(Tb156SubtipoDocumentoPeer::ID_TB154_TIPO_CUENTA_MOVIMIENTO, $tipo);
        $stmt = Tb156SubtipoDocumentoPeer::doSelectStmt($c);
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
          
    //modelo fk tb011_cuenta_bancaria.CO_CUENTA_BANCARIA
    public function executeCargarDisponible(sfWebRequest $request){

        $cuenta      =   $this->getRequestParameter("cuenta");

        $c = new Criteria();
        $c->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA, $cuenta);
        $stmt = Tb011CuentaBancariaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
            "success"   =>  true,
            "data"      =>  $campos
        ));
        
        $this->setTemplate('store');
    }


}