<?php

/**
 * consignacionCheque actions.
 *
 * @package    gobel
 * @subpackage consignacionCheque
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class consignacionChequeActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('consignacionCheque', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('consignacionCheque', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {
    $this->data = json_encode(array(
        "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
    ));
  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb203ConsignacionChequePeer::CO_CONSIGNACION_CHEQUE,$codigo);
        
        $stmt = Tb203ConsignacionChequePeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_consignacion_cheque"     => $campos["co_consignacion_cheque"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_banco"     => $campos["co_banco"],
                            "co_cuenta_bancaria"     => $campos["co_cuenta_bancaria"],
                            "co_chequera"     => $campos["co_chequera"],
                            "co_cheque"     => $campos["co_cheque"],
                            "nb_titular"     => $campos["nb_titular"],
                            "mo_cheque"     => $campos["mo_cheque"],
                            "fe_pago"     => $campos["fe_pago"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "id_tb154_tipo_cuenta_movimiento"     => $campos["id_tb154_tipo_cuenta_movimiento"],
                            "id_tb156_subtipo_documento"     => $campos["id_tb156_subtipo_documento"],
                            "co_estado_cheque"     => $campos["co_estado_cheque"],
                            "tx_observacion"     => $campos["tx_observacion"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_consignacion_cheque"     => "",
                            "co_solicitud"     => $this->getRequestParameter("co_solicitud"),
                            "co_banco"     => "",
                            "co_cuenta_bancaria"     => "",
                            "co_chequera"     => "",
                            "co_cheque"     => "",
                            "nb_titular"     => "",
                            "mo_cheque"     => "",
                            "fe_pago"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "id_tb154_tipo_cuenta_movimiento"     => "",
                            "id_tb156_subtipo_documento"     => "",
                            "co_estado_cheque"     => "",
                            "tx_observacion"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_consignacion_cheque");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb203_consignacion_cheque = Tb203ConsignacionChequePeer::retrieveByPk($codigo);

         try
         { 
           $con->beginTransaction();
          
           $tb203_consignacion_chequeForm = $this->getRequestParameter('tb203_consignacion_cheque');
   /*CAMPOS*/
                                           
           /*Campo tipo BIGINT */
           $tb203_consignacion_cheque->setCoSolicitud($tb203_consignacion_chequeForm["co_solicitud"]);
                                                           
           /*Campo tipo BIGINT */
           $tb203_consignacion_cheque->setCoBanco($tb203_consignacion_chequeForm["co_banco"]);
                                                           
           /*Campo tipo BIGINT */
           $tb203_consignacion_cheque->setCoCuentaBancaria($tb203_consignacion_chequeForm["co_cuenta_bancaria"]);
                                                           
           /*Campo tipo BIGINT */
           $tb203_consignacion_cheque->setCoChequera($tb203_consignacion_chequeForm["co_chequera"]);
                                                           
           /*Campo tipo BIGINT */
           $tb203_consignacion_cheque->setCoCheque($tb203_consignacion_chequeForm["co_cheque"]);
                                                           
           /*Campo tipo VARCHAR */
           $tb203_consignacion_cheque->setNbTitular($tb203_consignacion_chequeForm["nb_titular"]);
                                                           
           /*Campo tipo NUMERIC */
           $tb203_consignacion_cheque->setMoCheque($tb203_consignacion_chequeForm["mo_cheque"]);

           /*Campo tipo NUMERIC */
           $tb203_consignacion_cheque->setCoEstadoCheque($tb203_consignacion_chequeForm["co_estado_cheque"]);

           /*Campo tipo VARCHAR */
           $tb203_consignacion_cheque->setTxObservacion($tb203_consignacion_chequeForm["tx_observacion"]);
                                                                   
           /*Campo tipo DATE */
           list($dia, $mes, $anio) = explode("/",$tb203_consignacion_chequeForm["fe_pago"]);
           $fechaPago = $anio."-".$mes."-".$dia;
           $tb203_consignacion_cheque->setFePago($fechaPago);
                                                           
           /*Campo tipo TIMESTAMP */
           /*list($dia, $mes, $anio) = explode("/",$tb203_consignacion_chequeForm["created_at"]);
           $fecha = $anio."-".$mes."-".$dia;
           $fecha = date("Y-m-d H:i:s");
           $tb203_consignacion_cheque->setCreatedAt($fecha);*/
                                                           
           /*Campo tipo TIMESTAMP */
           /*list($dia, $mes, $anio) = explode("/",$tb203_consignacion_chequeForm["updated_at"]);
           $fecha = $anio."-".$mes."-".$dia;*/
           $fecha = date("Y-m-d H:i:s");
           $tb203_consignacion_cheque->setUpdatedAt($fecha);

            /*Campo tipo NUMERIC */
            $tb203_consignacion_cheque->setIdTb154TipoCuentaMovimiento(3);

            /*Campo tipo NUMERIC */
            $tb203_consignacion_cheque->setIdTb156SubtipoDocumento($tb203_consignacion_chequeForm["id_tb156_subtipo_documento"]);
                                   
           /*CAMPOS*/
           $tb203_consignacion_cheque->save($con);

           $Tb077Cheque = Tb077ChequePeer::retrieveByPK($tb203_consignacion_chequeForm["co_cheque"]);
           $Tb077Cheque->setCoEstadoCheque($tb203_consignacion_chequeForm["co_estado_cheque"]);
           $Tb077Cheque->setTxObservacion($tb203_consignacion_chequeForm["tx_observacion"]);    
           $Tb077Cheque->save($con);

           $wherec = new Criteria();
           $wherec->add(Tb061AsientoContablePeer::ID_TB155_CUENTA_BANCARIA_HISTORICO, $tb203_consignacion_cheque->getIdTb155CuentaBancariaHistorico(), Criteria::EQUAL);
           BasePeer::doDelete($wherec, $con);

           $wherec1 = new Criteria();
           $wherec1->add(Tb155CuentaBancariaHistoricoPeer::ID, $tb203_consignacion_cheque->getIdTb155CuentaBancariaHistorico(), Criteria::EQUAL);
           BasePeer::doDelete($wherec1, $con); 

            $tb011_cuenta_bancaria = new Criteria();
            $tb011_cuenta_bancaria->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA, $tb203_consignacion_chequeForm["co_cuenta_bancaria"]);
            $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::TX_CUENTA_BANCARIA);
            $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::MO_DISPONIBLE);
            $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::MO_INGRESO);
            $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::MO_EGRESO);
            $stmt = Tb011CuentaBancariaPeer::doSelectStmt($tb011_cuenta_bancaria);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $c12 = new Criteria();
            $c12->add(Tb077ChequePeer::CO_CHEQUE,$tb203_consignacion_chequeForm["co_cheque"]);
            $stmt12 = Tb077ChequePeer::doSelectStmt($c12);
            $reg12 = $stmt12->fetch(PDO::FETCH_ASSOC);

            $saldo_anterior = $campos["mo_disponible"];
            $saldo_nuevo = $tb155_cuenta_bancaria_historicoForm["mo_transaccion"]+$campos["mo_disponible"];
            
            if($tb203_consignacion_chequeForm["co_estado_cheque"]==6){

            $tb155_cuenta_bancaria_historico = new Tb155CuentaBancariaHistorico();
            $tb155_cuenta_bancaria_historico->setInActivo(true);
            $tb155_cuenta_bancaria_historico->setIdTb011CuentaBancaria($tb203_consignacion_chequeForm["co_cuenta_bancaria"]);
            $tb155_cuenta_bancaria_historico->setMoTransaccion($tb203_consignacion_chequeForm["mo_cheque"]);
            $tb155_cuenta_bancaria_historico->setFeTransaccion($fechaPago);
            $tb155_cuenta_bancaria_historico->setIdTb010Banco($tb203_consignacion_chequeForm["co_banco"]);
            $tb155_cuenta_bancaria_historico->setCoSolicitud($tb203_consignacion_chequeForm["co_solicitud"]);
            $tb155_cuenta_bancaria_historico->setIdTb154TipoCuentaMovimiento(4);
            $tb155_cuenta_bancaria_historico->setIdTb153TipoDocumentoCuenta(2);
            $tb155_cuenta_bancaria_historico->setIdTb156SubtipoDocumento($tb203_consignacion_chequeForm["id_tb156_subtipo_documento"]);
            $tb155_cuenta_bancaria_historico->setDeObservacion('Consignación de Cheque N°: '.$reg12["tx_descripcion"].' Titular: '.$tb203_consignacion_chequeForm["nb_titular"]);
            $tb155_cuenta_bancaria_historico->setMoSaldoNuevo($saldo_nuevo);
            $tb155_cuenta_bancaria_historico->setMoSaldoAnterior($saldo_anterior);
            $tb155_cuenta_bancaria_historico->setNuTransaccion('N/A');
            $tb155_cuenta_bancaria_historico->save($con);
            }else{
            
            $tb155_cuenta_bancaria_historico = new Tb155CuentaBancariaHistorico();
            $tb155_cuenta_bancaria_historico->setInActivo(true);
            $tb155_cuenta_bancaria_historico->setIdTb011CuentaBancaria($tb203_consignacion_chequeForm["co_cuenta_bancaria"]);
            $tb155_cuenta_bancaria_historico->setMoTransaccion($tb203_consignacion_chequeForm["mo_cheque"]);
            $tb155_cuenta_bancaria_historico->setFeTransaccion($fechaPago);
            $tb155_cuenta_bancaria_historico->setIdTb010Banco($tb203_consignacion_chequeForm["co_banco"]);
            $tb155_cuenta_bancaria_historico->setCoSolicitud($tb203_consignacion_chequeForm["co_solicitud"]);
            $tb155_cuenta_bancaria_historico->setIdTb154TipoCuentaMovimiento(3);
            $tb155_cuenta_bancaria_historico->setIdTb153TipoDocumentoCuenta(3);
            $tb155_cuenta_bancaria_historico->setIdTb156SubtipoDocumento($tb203_consignacion_chequeForm["id_tb156_subtipo_documento"]);
            $tb155_cuenta_bancaria_historico->setDeObservacion('Consignación de Cheque N°: '.$reg12["tx_descripcion"].' Titular: '.$tb203_consignacion_chequeForm["nb_titular"]);
            $tb155_cuenta_bancaria_historico->setMoSaldoNuevo($saldo_nuevo);
            $tb155_cuenta_bancaria_historico->setMoSaldoAnterior($saldo_anterior);
            $tb155_cuenta_bancaria_historico->setNuTransaccion('N/A');
            $tb155_cuenta_bancaria_historico->save($con);                
                
            }

            $tb011_cuenta_bancaria = Tb011CuentaBancariaPeer::retrieveByPK($tb203_consignacion_chequeForm["co_cuenta_bancaria"]);
            $tb011_cuenta_bancaria->setMoDisponible($saldo_nuevo);
            $tb011_cuenta_bancaria->save($con);

            $tb203_consignacion_cheque = Tb203ConsignacionChequePeer::retrieveByPk($codigo);
            $tb203_consignacion_cheque->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId());
            $tb203_consignacion_cheque->save($con);

            $c = new Criteria();
            $c->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA,$tb203_consignacion_chequeForm["co_cuenta_bancaria"]);
            $stmt = Tb011CuentaBancariaPeer::doSelectStmt($c);
            $reg = $stmt->fetch(PDO::FETCH_ASSOC);            
          
            $c1 = new Criteria();
            $c1->add(Tb156SubtipoDocumentoPeer::ID,$tb203_consignacion_chequeForm["id_tb156_subtipo_documento"]);
            $stmt1 = Tb156SubtipoDocumentoPeer::doSelectStmt($c1);
            $reg1 = $stmt1->fetch(PDO::FETCH_ASSOC); 
            
            if($tb203_consignacion_chequeForm["co_estado_cheque"]==6){
            $co_tipo_asiento = 10;
            
            $tb061_asiento_contable = new Tb061AsientoContable();
            $tb061_asiento_contable->setMoHaber($tb203_consignacion_chequeForm["mo_cheque"])
                          ->setCoCuentaContable($reg1["co_cuenta_contable"])
                          ->setCreatedAt($fechaPago)
                          ->setCoSolicitud($tb203_consignacion_chequeForm["co_solicitud"])
                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                          ->setCoTipoAsiento($co_tipo_asiento)
                          ->setInActivo(true)
                          ->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId())
                          ->save($con);
            

            $tb061_asiento_contable = new Tb061AsientoContable();
            $tb061_asiento_contable->setMoDebe($tb203_consignacion_chequeForm["mo_cheque"])
                          ->setCoCuentaContable($reg["co_cuenta_contable"])
                          ->setCreatedAt($fechaPago)
                          ->setCoSolicitud($tb203_consignacion_chequeForm["co_solicitud"])
                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                          ->setCoTipoAsiento($co_tipo_asiento)
                          ->setInActivo(true)
                          ->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId())
                          ->save($con);            
            
            
            
            }else{
            $co_tipo_asiento = 9;    
            
            $tb061_asiento_contable = new Tb061AsientoContable();
            $tb061_asiento_contable->setMoHaber($tb203_consignacion_chequeForm["mo_cheque"])
                          ->setCoCuentaContable($reg["co_cuenta_contable"])
                          ->setCreatedAt($fechaPago)
                          ->setCoSolicitud($tb203_consignacion_chequeForm["co_solicitud"])
                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                          ->setCoTipoAsiento($co_tipo_asiento)
                          ->setInActivo(true)
                          ->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId())
                          ->save($con);
            

            $tb061_asiento_contable = new Tb061AsientoContable();
            $tb061_asiento_contable->setMoDebe($tb203_consignacion_chequeForm["mo_cheque"])
                          ->setCoCuentaContable($reg1["co_cuenta_contable"])
                          ->setCreatedAt($fechaPago)
                          ->setCoSolicitud($tb203_consignacion_chequeForm["co_solicitud"])
                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                          ->setCoTipoAsiento($co_tipo_asiento)
                          ->setInActivo(true)
                          ->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId())
                          ->save($con);            
            
            }

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb203_consignacion_chequeForm["co_solicitud"]));
            $ruta->setInCargarDato(true)->save($con);
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

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
         $tb203_consignacion_cheque = new Tb203ConsignacionCheque();

         try
         { 
           $con->beginTransaction();
          
           $tb203_consignacion_chequeForm = $this->getRequestParameter('tb203_consignacion_cheque');
   /*CAMPOS*/
                                           
           /*Campo tipo BIGINT */
           $tb203_consignacion_cheque->setCoSolicitud($tb203_consignacion_chequeForm["co_solicitud"]);
                                                           
           /*Campo tipo BIGINT */
           $tb203_consignacion_cheque->setCoBanco($tb203_consignacion_chequeForm["co_banco"]);
                                                           
           /*Campo tipo BIGINT */
           $tb203_consignacion_cheque->setCoCuentaBancaria($tb203_consignacion_chequeForm["co_cuenta_bancaria"]);
                                                           
           /*Campo tipo BIGINT */
           $tb203_consignacion_cheque->setCoChequera($tb203_consignacion_chequeForm["co_chequera"]);
                                                           
           /*Campo tipo BIGINT */
           $tb203_consignacion_cheque->setCoCheque($tb203_consignacion_chequeForm["co_cheque"]);
                                                           
           /*Campo tipo VARCHAR */
           $tb203_consignacion_cheque->setNbTitular($tb203_consignacion_chequeForm["nb_titular"]);
                                                           
           /*Campo tipo NUMERIC */
           $tb203_consignacion_cheque->setMoCheque($tb203_consignacion_chequeForm["mo_cheque"]);

           /*Campo tipo NUMERIC */
           $tb203_consignacion_cheque->setCoEstadoCheque($tb203_consignacion_chequeForm["co_estado_cheque"]);

           /*Campo tipo VARCHAR */
           $tb203_consignacion_cheque->setTxObservacion($tb203_consignacion_chequeForm["tx_observacion"]);
                                                                   
           /*Campo tipo DATE */
           list($dia, $mes, $anio) = explode("/",$tb203_consignacion_chequeForm["fe_pago"]);
           $fechaPago = $anio."-".$mes."-".$dia;
           $tb203_consignacion_cheque->setFePago($fechaPago);
                                                           
           /*Campo tipo TIMESTAMP */
           /*list($dia, $mes, $anio) = explode("/",$tb203_consignacion_chequeForm["created_at"]);
           $fecha = $anio."-".$mes."-".$dia;*/
           $fecha = date("Y-m-d H:i:s");
           $tb203_consignacion_cheque->setCreatedAt($fecha);
                                                           
           /*Campo tipo TIMESTAMP */
           /*list($dia, $mes, $anio) = explode("/",$tb203_consignacion_chequeForm["updated_at"]);
           $fecha = $anio."-".$mes."-".$dia;*/
           $fecha = date("Y-m-d H:i:s");
           $tb203_consignacion_cheque->setUpdatedAt($fecha);

            /*Campo tipo NUMERIC */
            $tb203_consignacion_cheque->setIdTb154TipoCuentaMovimiento(3);

            /*Campo tipo NUMERIC */
            $tb203_consignacion_cheque->setIdTb156SubtipoDocumento($tb203_consignacion_chequeForm["id_tb156_subtipo_documento"]);

           /*CAMPOS*/
           $tb203_consignacion_cheque->save($con);

           $con->commit();

           $Tb077Cheque = Tb077ChequePeer::retrieveByPK($tb203_consignacion_chequeForm["co_cheque"]);
           $Tb077Cheque->setCoEstadoCheque($tb203_consignacion_chequeForm["co_estado_cheque"]);
           $Tb077Cheque->setTxObservacion($tb203_consignacion_chequeForm["tx_observacion"]);    
           $Tb077Cheque->save($con);

           /*$wherec = new Criteria();
           $wherec->add(Tb061AsientoContablePeer::ID_TB155_CUENTA_BANCARIA_HISTORICO, $tb203_consignacion_cheque->getIdTb155CuentaBancariaHistorico(), Criteria::EQUAL);
           BasePeer::doDelete($wherec, $con);

           $wherec1 = new Criteria();
           $wherec1->add(Tb155CuentaBancariaHistoricoPeer::ID, $tb203_consignacion_cheque->getIdTb155CuentaBancariaHistorico(), Criteria::EQUAL);
           BasePeer::doDelete($wherec1, $con);*/ 

            $tb011_cuenta_bancaria = new Criteria();
            $tb011_cuenta_bancaria->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA, $tb203_consignacion_chequeForm["co_cuenta_bancaria"]);
            $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::TX_CUENTA_BANCARIA);
            $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::MO_DISPONIBLE);
            $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::MO_INGRESO);
            $tb011_cuenta_bancaria->addSelectColumn(Tb011CuentaBancariaPeer::MO_EGRESO);
            $stmt = Tb011CuentaBancariaPeer::doSelectStmt($tb011_cuenta_bancaria);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $c12 = new Criteria();
            $c12->add(Tb077ChequePeer::CO_CHEQUE,$tb203_consignacion_chequeForm["co_cheque"]);
            $stmt12 = Tb077ChequePeer::doSelectStmt($c12);
            $reg12 = $stmt12->fetch(PDO::FETCH_ASSOC);

            $saldo_anterior = $campos["mo_disponible"];
            $saldo_nuevo = $tb155_cuenta_bancaria_historicoForm["mo_transaccion"]+$campos["mo_disponible"];

            if($tb203_consignacion_chequeForm["co_estado_cheque"]==6){

            $tb155_cuenta_bancaria_historico = new Tb155CuentaBancariaHistorico();
            $tb155_cuenta_bancaria_historico->setInActivo(true);
            $tb155_cuenta_bancaria_historico->setIdTb011CuentaBancaria($tb203_consignacion_chequeForm["co_cuenta_bancaria"]);
            $tb155_cuenta_bancaria_historico->setMoTransaccion($tb203_consignacion_chequeForm["mo_cheque"]);
            $tb155_cuenta_bancaria_historico->setFeTransaccion($fechaPago);
            $tb155_cuenta_bancaria_historico->setIdTb010Banco($tb203_consignacion_chequeForm["co_banco"]);
            $tb155_cuenta_bancaria_historico->setCoSolicitud($tb203_consignacion_chequeForm["co_solicitud"]);
            $tb155_cuenta_bancaria_historico->setIdTb154TipoCuentaMovimiento(4);
            $tb155_cuenta_bancaria_historico->setIdTb153TipoDocumentoCuenta(2);
            $tb155_cuenta_bancaria_historico->setIdTb156SubtipoDocumento($tb203_consignacion_chequeForm["id_tb156_subtipo_documento"]);
            $tb155_cuenta_bancaria_historico->setDeObservacion('Consignación de Cheque N°: '.$reg12["tx_descripcion"].' Titular: '.$tb203_consignacion_chequeForm["nb_titular"]);
            $tb155_cuenta_bancaria_historico->setMoSaldoNuevo($saldo_nuevo);
            $tb155_cuenta_bancaria_historico->setMoSaldoAnterior($saldo_anterior);
            $tb155_cuenta_bancaria_historico->setNuTransaccion('N/A');
            $tb155_cuenta_bancaria_historico->save($con);
            }else{
            
            $tb155_cuenta_bancaria_historico = new Tb155CuentaBancariaHistorico();
            $tb155_cuenta_bancaria_historico->setInActivo(true);
            $tb155_cuenta_bancaria_historico->setIdTb011CuentaBancaria($tb203_consignacion_chequeForm["co_cuenta_bancaria"]);
            $tb155_cuenta_bancaria_historico->setMoTransaccion($tb203_consignacion_chequeForm["mo_cheque"]);
            $tb155_cuenta_bancaria_historico->setFeTransaccion($fechaPago);
            $tb155_cuenta_bancaria_historico->setIdTb010Banco($tb203_consignacion_chequeForm["co_banco"]);
            $tb155_cuenta_bancaria_historico->setCoSolicitud($tb203_consignacion_chequeForm["co_solicitud"]);
            $tb155_cuenta_bancaria_historico->setIdTb154TipoCuentaMovimiento(3);
            $tb155_cuenta_bancaria_historico->setIdTb153TipoDocumentoCuenta(3);
            $tb155_cuenta_bancaria_historico->setIdTb156SubtipoDocumento($tb203_consignacion_chequeForm["id_tb156_subtipo_documento"]);
            $tb155_cuenta_bancaria_historico->setDeObservacion('Consignación de Cheque N°: '.$reg12["tx_descripcion"].' Titular: '.$tb203_consignacion_chequeForm["nb_titular"]);
            $tb155_cuenta_bancaria_historico->setMoSaldoNuevo($saldo_nuevo);
            $tb155_cuenta_bancaria_historico->setMoSaldoAnterior($saldo_anterior);
            $tb155_cuenta_bancaria_historico->setNuTransaccion('N/A');
            $tb155_cuenta_bancaria_historico->save($con);                
                
            }

            $tb011_cuenta_bancaria = Tb011CuentaBancariaPeer::retrieveByPK($tb203_consignacion_chequeForm["co_cuenta_bancaria"]);
            $tb011_cuenta_bancaria->setMoDisponible($saldo_nuevo);
            $tb011_cuenta_bancaria->save($con);

            $tb203_consignacion_cheque = Tb203ConsignacionChequePeer::retrieveByPk($tb203_consignacion_cheque->getCoConsignacionCheque());
            $tb203_consignacion_cheque->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId());
            $tb203_consignacion_cheque->save($con);

            $c = new Criteria();
            $c->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA,$tb203_consignacion_chequeForm["co_cuenta_bancaria"]);
            $stmt = Tb011CuentaBancariaPeer::doSelectStmt($c);
            $reg = $stmt->fetch(PDO::FETCH_ASSOC);            
          
            $c1 = new Criteria();
            $c1->add(Tb156SubtipoDocumentoPeer::ID,$tb203_consignacion_chequeForm["id_tb156_subtipo_documento"]);
            $stmt1 = Tb156SubtipoDocumentoPeer::doSelectStmt($c1);
            $reg1 = $stmt1->fetch(PDO::FETCH_ASSOC);  

            if($tb203_consignacion_chequeForm["co_estado_cheque"]==6){
            $co_tipo_asiento = 10;
            
            $tb061_asiento_contable = new Tb061AsientoContable();
            $tb061_asiento_contable->setMoHaber($tb203_consignacion_chequeForm["mo_cheque"])
                          ->setCoCuentaContable($reg1["co_cuenta_contable"])
                          ->setCreatedAt($fechaPago)
                          ->setCoSolicitud($tb203_consignacion_chequeForm["co_solicitud"])
                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                          ->setCoTipoAsiento($co_tipo_asiento)
                          ->setInActivo(true)
                          ->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId())
                          ->save($con);
            

            $tb061_asiento_contable = new Tb061AsientoContable();
            $tb061_asiento_contable->setMoDebe($tb203_consignacion_chequeForm["mo_cheque"])
                          ->setCoCuentaContable($reg["co_cuenta_contable"])
                          ->setCreatedAt($fechaPago)
                          ->setCoSolicitud($tb203_consignacion_chequeForm["co_solicitud"])
                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                          ->setCoTipoAsiento($co_tipo_asiento)
                          ->setInActivo(true)
                          ->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId())
                          ->save($con);            
            
            
            
            }else{
            $co_tipo_asiento = 9;    
            
            $tb061_asiento_contable = new Tb061AsientoContable();
            $tb061_asiento_contable->setMoHaber($tb203_consignacion_chequeForm["mo_cheque"])
                          ->setCoCuentaContable($reg["co_cuenta_contable"])
                          ->setCreatedAt($fechaPago)
                          ->setCoSolicitud($tb203_consignacion_chequeForm["co_solicitud"])
                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                          ->setCoTipoAsiento($co_tipo_asiento)
                          ->setInActivo(true)
                          ->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId())
                          ->save($con);
            

            $tb061_asiento_contable = new Tb061AsientoContable();
            $tb061_asiento_contable->setMoDebe($tb203_consignacion_chequeForm["mo_cheque"])
                          ->setCoCuentaContable($reg1["co_cuenta_contable"])
                          ->setCreatedAt($fechaPago)
                          ->setCoSolicitud($tb203_consignacion_chequeForm["co_solicitud"])
                          ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                          ->setCoTipoAsiento($co_tipo_asiento)
                          ->setInActivo(true)
                          ->setIdTb155CuentaBancariaHistorico($tb155_cuenta_bancaria_historico->getId())
                          ->save($con);            
            
            }

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb203_consignacion_chequeForm["co_solicitud"]));
            $ruta->setInCargarDato(true)->save($con);
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

           $this->data = json_encode(array(
                       "success" => true,
                       "msg" => 'Registro Creado Exitosamente!'
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
	$codigo = $this->getRequestParameter("co_consignacion_cheque");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb203_consignacion_cheque = Tb203ConsignacionChequePeer::retrieveByPk($codigo);			
    $tb203_consignacion_cheque->delete($con);
    
    $wherec = new Criteria();
    $wherec->add(Tb061AsientoContablePeer::ID_TB155_CUENTA_BANCARIA_HISTORICO, $tb203_consignacion_cheque->getIdTb155CuentaBancariaHistorico(), Criteria::EQUAL);
    BasePeer::doDelete($wherec, $con);

    $wherec1 = new Criteria();
    $wherec1->add(Tb155CuentaBancariaHistoricoPeer::ID, $tb203_consignacion_cheque->getIdTb155CuentaBancariaHistorico(), Criteria::EQUAL);
    BasePeer::doDelete($wherec1, $con); 

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
            "co_tipo_solicitud"       => $this->getRequestParameter("co_tipo_solicitud"),
            "co_proceso"       => $this->getRequestParameter("co_proceso"),
        ));
    }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $co_solicitud      =   $this->getRequestParameter("co_solicitud");
            $co_banco      =   $this->getRequestParameter("co_banco");
            $co_cuenta_bancaria      =   $this->getRequestParameter("co_cuenta_bancaria");
            $co_chequera      =   $this->getRequestParameter("co_chequera");
            $co_cheque      =   $this->getRequestParameter("co_cheque");
            $nb_titular      =   $this->getRequestParameter("nb_titular");
            $mo_cheque      =   $this->getRequestParameter("mo_cheque");
            $fe_pago      =   $this->getRequestParameter("fe_pago");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_solicitud!=""){$c->add(Tb203ConsignacionChequePeer::CO_SOLICITUD,$co_solicitud);}
    
                                            if($co_banco!=""){$c->add(Tb203ConsignacionChequePeer::CO_BANCO,$co_banco);}
    
                                            if($co_cuenta_bancaria!=""){$c->add(Tb203ConsignacionChequePeer::CO_CUENTA_BANCARIA,$co_cuenta_bancaria);}
    
                                            if($co_chequera!=""){$c->add(Tb203ConsignacionChequePeer::CO_CHEQUERA,$co_chequera);}
    
                                            if($co_cheque!=""){$c->add(Tb203ConsignacionChequePeer::co_cheque,$co_cheque);}
    
                                        if($nb_titular!=""){$c->add(Tb203ConsignacionChequePeer::nb_titular,'%'.$nb_titular.'%',Criteria::LIKE);}
        
                                            if($mo_cheque!=""){$c->add(Tb203ConsignacionChequePeer::mo_cheque,$mo_cheque);}
    
                                    
        if($fe_pago!=""){
    list($dia, $mes,$anio) = explode("/",$fe_pago);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb203ConsignacionChequePeer::FE_PAGO,$fecha);
    }
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb203ConsignacionChequePeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb203ConsignacionChequePeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb203ConsignacionChequePeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb203ConsignacionChequePeer::CO_CONSIGNACION_CHEQUE);

    $c->clearSelectColumns();
    $c->addSelectColumn(Tb203ConsignacionChequePeer::CO_CONSIGNACION_CHEQUE);
    $c->addSelectColumn(Tb203ConsignacionChequePeer::CO_SOLICITUD);
    $c->addSelectColumn(Tb203ConsignacionChequePeer::NB_TITULAR);
    $c->addSelectColumn(Tb203ConsignacionChequePeer::MO_CHEQUE);
    $c->addSelectColumn(Tb203ConsignacionChequePeer::FE_PAGO);
    $c->addSelectColumn(Tb203ConsignacionChequePeer::TX_OBSERVACION);
    $c->addSelectColumn(Tb076EstadoChequePeer::TX_ESTADO_CHEQUE);
    $c->addSelectColumn(Tb010BancoPeer::TX_BANCO);
    $c->addSelectColumn(Tb011CuentaBancariaPeer::TX_CUENTA_BANCARIA);
    $c->addSelectColumn(Tb079ChequeraPeer::TX_DESCRIPCION);
    $c->addAsColumn('nu_cheque',Tb077ChequePeer::TX_DESCRIPCION);
    $c->addJoin(Tb203ConsignacionChequePeer::CO_BANCO, Tb010BancoPeer::CO_BANCO);
    $c->addJoin(Tb203ConsignacionChequePeer::CO_CUENTA_BANCARIA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
    $c->addJoin(Tb203ConsignacionChequePeer::CO_CHEQUERA, Tb079ChequeraPeer::CO_CHEQUERA);
    $c->addJoin(Tb203ConsignacionChequePeer::CO_CHEQUE, Tb077ChequePeer::CO_CHEQUE);
    $c->addJoin(Tb203ConsignacionChequePeer::CO_ESTADO_CHEQUE, Tb076EstadoChequePeer::CO_ESTADO_CHEQUE);
    $c->add(Tb203ConsignacionChequePeer::CO_SOLICITUD,$co_solicitud);
    $stmt = Tb203ConsignacionChequePeer::doSelectStmt($c);

    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_consignacion_cheque"     => trim($res["co_consignacion_cheque"]),
            "co_solicitud"     => trim($res["co_solicitud"]),
            "co_banco"     => trim($res["tx_banco"]),
            "co_cuenta_bancaria"     => trim($res["tx_cuenta_bancaria"]),
            "co_chequera"     => trim($res["tx_descripcion"]),
            "co_cheque"     => trim($res["nu_cheque"]),
            "nb_titular"     => trim($res["nb_titular"]),
            "mo_cheque"     => trim($res["mo_cheque"]),
            "fe_pago"     => trim($res["fe_pago"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "tx_estado_cheque"     => trim($res["tx_estado_cheque"]),
            "tx_observacion"     => trim($res["tx_observacion"]),
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
                    //modelo fk tb011_cuenta_bancaria.CO_CUENTA_BANCARIA
    public function executeStorefkcocuentabancaria(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb011CuentaBancariaPeer::CO_BANCO, $this->getRequestParameter("co_banco"));
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
                    //modelo fk tb079_chequera.CO_CHEQUERA
    public function executeStorefkcochequera(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb079ChequeraPeer::CO_CUENTA_BANCARIA, $this->getRequestParameter("co_cuenta_bancaria"));
        $stmt = Tb079ChequeraPeer::doSelectStmt($c);
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
                    //modelo fk tb077_cheque.CO_CHEQUE
    public function executeStorefkcocheque(sfWebRequest $request){
        $c = new Criteria();
        //$c->add(Tb077ChequePeer::CO_ESTADO_CHEQUE, 2);
        $c->add(Tb077ChequePeer::CO_ESTADO_CHEQUE, array( 1, 2),  Criteria::IN);
        $c->add(Tb077ChequePeer::CO_CHEQUERA, $this->getRequestParameter("co_chequera"));
        $stmt = Tb077ChequePeer::doSelectStmt($c);
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

        $tipo      =   3;

        $c = new Criteria();
        $c->add(Tb156SubtipoDocumentoPeer::ID_TB154_TIPO_CUENTA_MOVIMIENTO, $tipo);
        $c->add(Tb156SubtipoDocumentoPeer::CO_CUENTA_CONTABLE, null, Criteria::ISNOTNULL);
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

    public function executeStorefkcoestadocheque(sfWebRequest $request){
        
        $co_estado_cheque = array( 2, 6);
        $c = new Criteria();
        $c->add(Tb076EstadoChequePeer::CO_ESTADO_CHEQUE, $co_estado_cheque, Criteria::IN);
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