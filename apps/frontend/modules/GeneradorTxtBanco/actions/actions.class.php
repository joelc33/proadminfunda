<?php

/**
 * GeneradorTxtBanco actions.
 *
 * @package    gobel
 * @subpackage GeneradorTxtBanco
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class GeneradorTxtBancoActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      $this->data = json_encode(array(
          "co_liquidacion_pago"  => $this->getRequestParameter("co_liquidacion_pago")
      ));
  }
  
  public function executeIndexMenu(sfWebRequest $request)
  {
    $this->data = json_encode(array(
        "co_liquidacion_pago"  => $this->getRequestParameter("co_liquidacion_pago")
    ));
  }
  
  public function executeVerificarSolicitud(sfWebRequest $request)
  {
  
    $co_solicitud  = $this->getRequestParameter('co_solicitud');

    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
    $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
    
    $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
    $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tb008ProveedorPeer::CO_DOCUMENTO);
//    $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb062LiquidacionPagoPeer::CO_SOLICITUD);
//    $c->addJoin(Tb063PagoPeer::CO_LIQUIDACION_PAGO, Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
//    $c->addJoin(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA, Tb063PagoPeer::CO_CUENTA_BANCARIA);
//    $c->addJoin(Tb010BancoPeer::CO_BANCO, Tb063PagoPeer::CO_BANCO);
    $c->add(Tb026SolicitudPeer::CO_SOLICITUD,$co_solicitud);
    $stmt = Tb026SolicitudPeer::doSelectStmt($c);

    $registros = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->data = json_encode(array(
        "success"   => true,
        "data"      => $registros
    ));
    
    $this->setTemplate('store');
    
  }
  
  public function executeStorefkcoliquidacion(sfWebRequest $request)
  {
  
        $co_solicitud  = $this->getRequestParameter('co_solicitud');

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
        $c->addSelectColumn(Tb062LiquidacionPagoPeer::MO_PAGADO);
        $c->addSelectColumn(Tb062LiquidacionPagoPeer::TX_SERIAL);        
        $c->add(Tb062LiquidacionPagoPeer::CO_SOLICITUD,$co_solicitud);
        
        $stmt = Tb062LiquidacionPagoPeer::doSelectStmt($c);

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
  
  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_pago_nomina");
     $co_banco = $this->getRequestParameter("co_banco");
     $nu_banco = $this->getRequestParameter("nu_banco");
     $co_cuenta_bancaria = $this->getRequestParameter("co_cuenta_bancaria");

     $con = Propel::getConnection();
    
     try
      {
        $con->beginTransaction();

        $mo_total = 0;
        $i=0;
        $lines = file($_FILES['form-file']['tmp_name']);
        
        $where = new Criteria();
        $where->add(Tb175ArchivoTemporalPagoPeer::CO_BANCO, $co_banco);
        BasePeer::doDelete($where, $con);  
        
        foreach($lines as $line)
        {
            $i++;
            $cadena = str_replace("|","", $line);
            $array = explode(",", $cadena);

            if(!is_numeric(trim($array[0]))){
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El código de persona  '.$array[0].' debe ser númerico '.$array[1].' linea '.$i
                ));
                echo $this->data;
                return sfView::NONE;
            }

            if(strlen(trim($array[1]))>9){
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El número de cédula  '.trim($array[1]).' debe tener una longitud de 9 caracteres '
                ));
                echo $this->data;
                return sfView::NONE;
            }

            if(strlen(trim($array[3]))==''){
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El número de cuenta  '.trim($array[3]).' debe tener una longitud de menos 10 digitos'
                ));
                echo $this->data;
                return sfView::NONE;
            }

            $cod_banco = Tb010BancoPeer::getCodigo(trim($nu_banco));
            $co_persona = trim(utf8_decode($array[0]));
            
            $Tb175ArchivoTemporalPago = new Tb175ArchivoTemporalPago();
            $Tb175ArchivoTemporalPago->setCoPersona($co_persona)
                                     ->setTxCedula(trim(utf8_decode($array[1])))
                                     ->setNbPersona(utf8_decode($array[2]))
                                     ->setTxCuentaBancaria(trim(utf8_decode($array[3])))
                                     ->setNuMonto(trim(utf8_decode($array[4])))
                                     ->setCodBanco($cod_banco)
                                     ->setCoBanco($co_banco)
                                     ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                     ->save($con);
                                   
            $i++;
        }        
        
        if($i==0){
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  "Debe Seleccionar un archivo de nomina",
            ));
            
            echo $this->data;
            return sfView::NONE;
        }       
        
        $con->commit();
        
        
        if($nu_banco == '20'){
            $this->GenerarBOD($co_banco, $co_cuenta_bancaria);
        }
        
        if($nu_banco == '10'){
            $this->GenerarVZLA($co_banco);
        }

        if($nu_banco == '06'){
            $this->GenerarProvincial($co_banco);
        }
        

      }catch (PropelException $e)
      {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage().'---'.$i.'----'.$cadena
        ));
      }

      echo $this->data;
      return sfView::NONE;

    }
    
    public function executeGenerar(sfWebRequest $request)
    {

     $con = Propel::getConnection();
    
     try
      {
        $con->beginTransaction();

        $mo_total = 0;
        $lines = file($_FILES['form-file']['tmp_name']);
        
        $where = new Criteria();
        $where->add(Tb175ArchivoTemporalPagoPeer::CO_LIQUIDACION_PAGO,$this->getRequestParameter("co_liquidacion_pago"));
        
     
        BasePeer::doDelete($where, $con);  
        
        foreach($lines as $line)
        {
            $cadena = str_replace("|","", $line);
            $array = explode(",", $cadena);

            if(!is_numeric(trim($array[0]))){
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El código de persona  '.$array[0].' debe ser númerico '.$array[1].'linea '.$i
                ));
                echo $this->data;
                return sfView::NONE;
            }

            if(strlen(trim($array[1]))>9){
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El número de cédula  '.trim($array[1]).' debe tener una longitud de 9 caracteres '
                ));
                echo $this->data;
                return sfView::NONE;
            }

            if(strlen(trim($array[3]))==''){
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El número de cuenta  '.trim($array[3]).' debe tener una longitud de menos 10 digitos'
                ));
                echo $this->data;
                return sfView::NONE;
            }

            $cod_banco_une = $array[5];
            $co_banco = Tb010BancoPeer::getCodigo(trim($array[5]));
            $co_modo = Tb010BancoPeer::getModoPago( trim($array[3]), trim($array[5]));
            
            $Tb175ArchivoTemporalPago = new Tb175ArchivoTemporalPago();
            $Tb175ArchivoTemporalPago->setCoPersona(trim(utf8_decode($array[0])))
                                     ->setTxCedula(trim(utf8_decode($array[1])))
                                     ->setNbPersona(utf8_decode($array[2]))
                                     ->setTxCuentaBancaria(trim(utf8_decode($array[3])))
                                     ->setNuMonto(trim(utf8_decode($array[4])))
                                     ->setCodBanco($co_banco)
                                     ->setCoLiquidacionPago($this->getRequestParameter("co_liquidacion_pago"))
                                     ->save($con);
                                   
            $i++;
        }        
        
        if($i==0){
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  "Debe Seleccionar un archivo de nomina",
            ));
            
            echo $this->data;
            return sfView::NONE;
        }       
        
        $con->commit();
        
        
        if($cod_banco_une == '20'){
            $this->GenerarBOD();
        }
        
        if($cod_banco_une == '10'){
            $this->GenerarVZLA();
        }

        /*if($cod_banco_une == '06'){
            $this->GenerarProvincial();
        }*/
        

      }catch (PropelException $e)
      {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage().'---'.$i.'----'.$cadena
        ));
      }

      echo $this->data;
      return sfView::NONE;

    }
    
    protected function GenerarVZLA($co_banco) {

        $concepto           = $this->getRequestParameter("tx_concepto");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb175ArchivoTemporalPagoPeer::TX_CEDULA);
        $c->addSelectColumn(Tb175ArchivoTemporalPagoPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb175ArchivoTemporalPagoPeer::NU_MONTO);
        $c->addSelectColumn(Tb175ArchivoTemporalPagoPeer::NB_PERSONA);
        $c->add(Tb175ArchivoTemporalPagoPeer::CO_BANCO, $co_banco);
        
        //echo $c->toString(); exit();

        $cant = Tb175ArchivoTemporalPagoPeer::doCount($c);

        $stmt = Tb175ArchivoTemporalPagoPeer::doSelectStmt($c);
        $ref = 1;
        $i = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="BANVENEZ.DAT"');

        $monto_total = 0;
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $cuenta_banco = $res["cuenta_banco"];
            $res["tx_concepto"] = $concepto; 

            
            $cedula = str_pad(substr(trim($res["tx_cedula"]), 1), 11, "0", STR_PAD_LEFT);
            $inicial = substr(trim($res["tx_cedula"]), 0, 1);
            $nombre = str_pad(trim($res["nb_persona"]), 40, " ", STR_PAD_RIGHT);

            $lote = "03291"; //str_pad($res["nu_pago"], 6, "0", STR_PAD_LEFT);

            list($monto, $decimales) = explode(".", $res["nu_monto"]);
            $tipo_cuenta = substr($res["tx_cuenta_bancaria"],11,1);
            $cuenta = $res["tx_cuenta_bancaria"];

            $monto_total += $res["nu_monto"];

            $nu_monto = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 11, "0", STR_PAD_LEFT);

            if($cadena!=''){
                $cadena=$cadena."  ";
            }
            
            $cadena .= "\r\n".$tipo_cuenta. $cuenta . $nu_monto .$tipo_cuenta.'770' . $nombre . $cedula . $lote;

            $i++;
            
            list($anio,$mes,$dia) = explode("-", $res["fe_pago"]);
            
        }
        $mo_total_decimales = round($monto_total,2);
        list($monto, $decimales) = explode(".", $mo_total_decimales);

        $total = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 13, "0", STR_PAD_LEFT);

        print("HGOBERNACION DEL ESTADO ZULIA            ".$cuenta_banco."01".$dia."/".$mes."/".substr($anio, 2, 4). $total . $lote);
        print($cadena);
        return sfView::NONE;
    }
    
    
    protected function GenerarBOD($co_banco, $co_cuenta_bancaria){

        $concepto   = $this->getRequestParameter("tx_concepto");

        $c_cuenta = new Criteria();
        $c_cuenta->setIgnoreCase(true);
        $c_cuenta->clearSelectColumns();
        $c_cuenta->addSelectColumn(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c_cuenta->addSelectColumn(Tb011CuentaBancariaPeer::NU_CONTRATO);
        $c_cuenta->add(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA, $co_cuenta_bancaria);
        $stmt_cuenta = Tb011CuentaBancariaPeer::doSelectStmt($c_cuenta);
        $campos_cuenta = $stmt_cuenta->fetch(PDO::FETCH_ASSOC);

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb175ArchivoTemporalPagoPeer::TX_CEDULA);
        $c->addSelectColumn(Tb175ArchivoTemporalPagoPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb175ArchivoTemporalPagoPeer::NU_MONTO);
        $c->addSelectColumn(Tb175ArchivoTemporalPagoPeer::NB_PERSONA);
        $c->addSelectColumn(Tb175ArchivoTemporalPagoPeer::COD_BANCO);
        $c->add(Tb175ArchivoTemporalPagoPeer::CO_BANCO, $co_banco);

        //echo $c->toString(); exit();

        $cant = Tb175ArchivoTemporalPagoPeer::doCount($c);

        $stmt = Tb175ArchivoTemporalPagoPeer::doSelectStmt($c);
        $ref = 1;
        $i = 0;
        $monto_cabecera = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="nomina_pago_'.date("d-m-Y").'.txt"');

        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            
            $res["tx_concepto"]=$concepto;
            $ref++;    
            $cedula = str_pad(substr(trim($res["tx_cedula"]), 1), 9, "0", STR_PAD_LEFT);
            $inicial = substr(trim($res["tx_cedula"]), 0, 1);
            $nombre = str_pad(trim($res["nb_persona"]), 60, " ", STR_PAD_RIGHT);
            $referencia = str_pad($ref, 9, "0", STR_PAD_LEFT);
            $tx_concepto = str_pad(trim(substr($res["tx_concepto"],0,19)), 30, " ", STR_PAD_RIGHT);

            $cuenta = str_pad(trim($res["tx_cuenta_bancaria"]), 20, "0", STR_PAD_LEFT);
            $cod_banco = substr(trim($res["tx_cuenta_bancaria"]), 0, 4);

            if(strlen(trim($res["tx_cuenta_bancaria"]))<20){
                $cod_banco='0116';
            }
            
            if($cod_banco == '0116'){
                $tipo = 'CTA';
            }else{
                $tipo = 'BAN';
            }

            //list($anio, $mes, $dia) = explode("-", trim($res["fe_pago"]));
            list($anio, $mes, $dia) = explode("-", trim(date('Y-m-d')));
            list($monto, $decimales) = explode(".", trim($res["nu_monto"]));

            $monto_cabecera += $res["nu_monto"];

            $fecha = $anio . $mes . $dia;

            $nu_monto = str_pad($monto.str_pad($decimales, 2, "0", STR_PAD_RIGHT), 15, "0", STR_PAD_LEFT);
            $impuesto = str_pad(0, 15, "0", STR_PAD_LEFT);
            $email = str_pad('', 40, " ", STR_PAD_RIGHT);
            $celular = str_pad(0, 11, "0", STR_PAD_LEFT);

            $moneda = 'VEB';

            $tipo_registro = '01';
            $descripcion = str_pad('NOMINA', 20, " ", STR_PAD_RIGHT);
            $rif = "G200036524";

            $contrato = trim($campos_cuenta["nu_contrato"]);
            //$lote = str_pad(trim($res["nu_pago"]), 9, "0", STR_PAD_LEFT); //"000193907"; 
            $lote = str_pad(trim($fecha), 9, "0", STR_PAD_LEFT); //"000193907";  

            $cant_operaciones = str_pad($cant, 6, "0", STR_PAD_LEFT);

            $filler = str_pad("", 158, " ", STR_PAD_RIGHT);


            $cuerpo .= "\r\n02" . $inicial . $cedula . $nombre . $referencia . $tx_concepto . $tipo . $cuenta . $cod_banco . $fecha . $nu_monto . $moneda . $impuesto . $email . $celular;

            $i++;
        }
        $mo_total_decimales = round($monto_cabecera,2);
        list($monto, $decimales) = explode(".", $mo_total_decimales);
        
        $mo_total = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 17, "0", STR_PAD_LEFT);
        print(trim($tipo_registro . $descripcion . $rif . $contrato . $lote . $fecha . $cant_operaciones . $mo_total . $moneda . $filler));
        print($cuerpo);

        return sfView::NONE;
    }

    protected function GenerarProvincial($co_banco){

        $concepto   = $this->getRequestParameter("tx_concepto");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb175ArchivoTemporalPagoPeer::TX_CEDULA);
        $c->addSelectColumn(Tb175ArchivoTemporalPagoPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb175ArchivoTemporalPagoPeer::NU_MONTO);
        $c->addSelectColumn(Tb175ArchivoTemporalPagoPeer::NB_PERSONA);
        $c->addSelectColumn(Tb175ArchivoTemporalPagoPeer::COD_BANCO);
        $c->add(Tb175ArchivoTemporalPagoPeer::CO_BANCO, $co_banco);

        //echo $c->toString(); exit();

        $cant = Tb175ArchivoTemporalPagoPeer::doCount($c);

        $stmt = Tb175ArchivoTemporalPagoPeer::doSelectStmt($c);
        $ref = 1;
        $i = 0;
        $monto_cabecera = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="nomina_pago_'.date("d-m-Y").'.txt"');

        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $cedula = str_pad(substr(trim($res["tx_cedula"]), 1), 9, "0", STR_PAD_LEFT);
            $inicial = substr(trim($res["tx_cedula"]), 0, 1);
            $nombre = str_pad(trim($res["nb_persona"]), 35, " ", STR_PAD_RIGHT);

            list($monto, $decimales) = explode(".", $res["nu_monto"]);
            $cuenta = trim($res["tx_cuenta_bancaria"]);

            $nu_monto = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 13, "0", STR_PAD_LEFT);

            if ($i > 0) {
                print("\r\n");
            }

            print(trim($inicial . $cedula . $nombre . $cuenta . $nu_monto));
            $i++;
        }

        return sfView::NONE;

    }

    //modelo fk tb010_banco.CO_BANCO
    public function executeStorefkidtb010banco(sfWebRequest $request){
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb010BancoPeer::CO_BANCO);
        $c->add(Tb010BancoPeer::TX_CODIGO_BANCO, NULL, Criteria::ISNOTNULL);
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
    public function executeStorefkidtb011cuentabancaria(sfWebRequest $request){
    
        $co_banco = $this->getRequestParameter("co_banco");
        
        $c = new Criteria();
        $c->add(Tb011CuentaBancariaPeer::CO_BANCO,$co_banco);
        if($co_banco==1){
        $c->add(Tb011CuentaBancariaPeer::NU_CONTRATO, NULL, Criteria::ISNOTNULL);
        }
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

}
