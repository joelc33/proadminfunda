<?php

/**
 * reporte actions.
 *
 * @package    sgsti
 * @subpackage reporte
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class reporteActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("i");

        $encrypt = new myConfig();

        $c = new Criteria();
        $c->clearSelectColumns();

        $c->addSelectColumn(Tb030RutaPeer::TX_RUTA_REPORTE);
        $c->add(Tb030RutaPeer::CO_RUTA, $encrypt->decrypt($codigo));


        $stmt = Tb030RutaPeer::doSelectStmt($c);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($codigo != '') {
            $gestor = fopen($res["tx_ruta_reporte"], "r");

            $file = fread($gestor, filesize($res["tx_ruta_reporte"]));
            $response = $this->getResponse();
            $response->setContentType("application/pdf");
            $response->setContent($file);
        }

        return sfView::NONE;
    }

    public function executeArchivoPago(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("i");

        $c = new Criteria();
        $c->addSelectColumn(Tb063PagoPeer::CO_FORMA_PAGO);
        $c->add(Tb063PagoPeer::CO_PAGO, $codigo);

        $stmt = Tb063PagoPeer::doSelectStmt($c);

        $campos = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($campos["co_forma_pago"] == 1) {
            //cheque
        } else {
            //transferencia

            $this->PagoProveedor($codigo);
        }


        return sfView::NONE;
    }
    
    public function executeArchivoPagoUnificado(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("i");

     
        $array = array();
        $array = explode(",",$codigo);
        
               
        $c = new Criteria();
        $c->clearSelectColumns();

        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::NU_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb063PagoPeer::NU_MONTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb063PagoPeer::FE_PAGO);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::NU_CONTRATO);
        $c->addSelectColumn(Tb063PagoPeer::NU_PAGO);

        $c->addJoin(Tb063PagoPeer::CO_CUENTA_BANCARIA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        //$c->addJoin(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO, Tb063PagoPeer::CO_LIQUIDACION_PAGO);
        $c->addJoin(Tb063PagoPeer::CO_LIQUIDACION_PAGO, Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO);
        //$c->addJoin(Tb062LiquidacionPagoPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_SOLICITUD, Tb026SolicitudPeer::CO_SOLICITUD);
        //$c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tb008ProveedorPeer::CO_DOCUMENTO);
        // $c->add(Tb008ProveedorPeer::NU_CUENTA_BANCARIA,'0116%', Criteria::LIKE);
        $c->add(Tb030RutaPeer::IN_ACTUAL,TRUE);
        $c->addAnd(Tb030RutaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
        $c->add(Tb063PagoPeer::CO_PAGO, $array, Criteria::IN);
        //$c->add(Tb123ArchivoPagoPeer::NU_MONTO,0, Criteria::GREATER_THAN);

        //echo $c->toString(); exit();
      

        $cant = Tb063PagoPeer::doCount($c);


        $stmt = Tb063PagoPeer::doSelectStmt($c);
        $ref = 1;
        $i = 0;
        $monto_total = $this->getMoTotalUnificado($array);

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="nomina.txt"');

        
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if($res["nu_cuenta_bancaria"]==''){
                echo "Para generar el archivo debe asociar una cuenta bancaria al proveedor";
                exit();
            }

            $res["tx_razon_social"] = str_replace(",", "", trim($res["tx_razon_social"]));
            $res["tx_razon_social"] = str_replace(".", "", trim($res["tx_razon_social"]));

            $cedula = str_pad(trim($res["tx_rif"]), 9, "0", STR_PAD_LEFT);
            $inicial = substr(trim($res["inicial"]), 0, 1);
            $nombre = str_pad(substr(trim($res["tx_razon_social"]),0,55), 60, " ", STR_PAD_RIGHT);
            $referencia = str_pad($ref, 9, "0", STR_PAD_LEFT);
            $tx_concepto = str_pad("PAGO A PROVEEDORES", 30, " ", STR_PAD_RIGHT);

            $cuenta = trim($res["nu_cuenta_bancaria"]);
            $cod_banco = substr(trim($res["nu_cuenta_bancaria"]), 0, 4);

            if ($cod_banco == '0116')
                $tipo = 'CTA';
            else
                $tipo = 'BAN';



            list($anio, $mes, $dia) = explode("-", $res["fe_pago"]);
            list($monto, $decimales) = explode(".", $res["nu_monto"]);
            //list($monto_total, $dec) = explode(".", $monto_total);

            $fecha = $anio . $mes . $dia;

            // $mo_total = str_pad($monto_total.str_pad($dec,2,"0",STR_PAD_RIGHT), 17, "0", STR_PAD_LEFT);
            $mo_total = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 17, "0", STR_PAD_LEFT);
            $nu_monto = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 15, "0", STR_PAD_LEFT);
            $impuesto = str_pad(0, 15, "0", STR_PAD_LEFT);
            $email = str_pad('', 40, " ", STR_PAD_RIGHT);
            $celular = str_pad(0, 11, "0", STR_PAD_LEFT);

            $moneda = 'VEB';

            $tipo_registro = '01';
            $descripcion = str_pad('Proveedores', 20, " ", STR_PAD_RIGHT);
            $rif = "G200036524";
            $contrato = trim($res["nu_contrato"]);
            $lote = str_pad(trim($res["nu_pago"]), 9, "0", STR_PAD_LEFT); //"000193907";
            $cant_operaciones = str_pad($cant, 6, "0", STR_PAD_LEFT);
            $filler = str_pad("", 158, " ", STR_PAD_RIGHT);
            if($nu_monto>0){
            $cuerpo .= "\r\n02" . $inicial . $cedula . $nombre . $referencia . $tx_concepto . $tipo . $cuenta . $cod_banco . $fecha . $nu_monto . $moneda . $impuesto . $email . $celular;
            }
            $i++;
        }

              
        list($monto, $decimales) = explode(".", $monto_total);
        $mo_total = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 17, "0", STR_PAD_LEFT);
        print(trim($tipo_registro . $descripcion . $rif . $contrato . $lote . $fecha . $cant_operaciones . $mo_total . $moneda . $filler));
        print($cuerpo);
        
        return sfView::NONE;
        
        
        
        
        
    }
    
    public function executePagoOtrosBancos(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("i");

        $c = new Criteria();
        $c->clearSelectColumns();

        $c->addSelectColumn(Tb123ArchivoPagoPeer::TX_CEDULA);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::NU_MONTO);
        $c->addSelectColumn(Tb122PagoNominaPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::NB_PERSONA);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::COD_BANCO);
        $c->addSelectColumn(Tb063PagoPeer::FE_PAGO);
        $c->addSelectColumn(Tb122PagoNominaPeer::MO_TOTAL);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::NU_CONTRATO);
        $c->addSelectColumn(Tb063PagoPeer::NU_PAGO);

        $c->addJoin(Tb063PagoPeer::CO_CUENTA_BANCARIA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO, Tb063PagoPeer::CO_LIQUIDACION_PAGO);
        $c->addJoin(Tb123ArchivoPagoPeer::CO_PAGO_NOMINA, Tb122PagoNominaPeer::CO_PAGO_NOMINA);
        $c->addJoin(Tb122PagoNominaPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);

        $c->add(Tb123ArchivoPagoPeer::COD_BANCO, array('0108','0102','0116'), Criteria::NOT_IN);
       
       // $c->add(Tb123ArchivoPagoPeer::COD_BANCO, '0116');
        $c->add(Tb030RutaPeer::CO_RUTA, $codigo);
        $c->add(Tb063PagoPeer::CO_BANCO,1);
        $c->add(Tb123ArchivoPagoPeer::NU_MONTO,0, Criteria::GREATER_THAN);

        //echo $c->toString(); exit();

        $cant = Tb123ArchivoPagoPeer::doCount($c);

        $stmt = Tb123ArchivoPagoPeer::doSelectStmt($c);
        $ref = 1;
        $i = 0;
        $monto_cabecera = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="proveedor.txt"');

        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $ref++;    
            $cedula = str_pad(substr(trim($res["tx_cedula"]), 1), 9, "0", STR_PAD_LEFT);
            $inicial = substr(trim($res["tx_cedula"]), 0, 1);
            $nombre = str_pad(trim($res["nb_persona"]), 60, " ", STR_PAD_RIGHT);
            $referencia = str_pad($ref, 9, "0", STR_PAD_LEFT);
            $tx_concepto = str_pad(trim(substr($res["tx_concepto"],1,20)), 30, " ", STR_PAD_RIGHT);

            $cuenta = str_pad(trim($res["tx_cuenta_bancaria"]), 15, "0", STR_PAD_LEFT);
            $cod_banco = substr(trim($res["tx_cuenta_bancaria"]), 0, 4);

            if(strlen(trim($res["tx_cuenta_bancaria"]))<20){
                $cod_banco='0116';
            }
            
            if ($cod_banco == '0116')
                $tipo = 'CTA';
            else
                $tipo = 'BAN';


            list($anio, $mes, $dia) = explode("-", trim($res["fe_pago"]));
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

            $contrato = trim($res["nu_contrato"]);
            $lote = str_pad(trim($res["nu_pago"]), 9, "0", STR_PAD_LEFT); //"000193907";  

            $cant_operaciones = str_pad($cant, 6, "0", STR_PAD_LEFT);

            $filler = str_pad("", 158, " ", STR_PAD_RIGHT);

            if($nu_monto>0){
            $cuerpo .= "\r\n02" . $inicial . $cedula . $nombre . $referencia . $tx_concepto . $tipo . $cuenta . $cod_banco . $fecha . $nu_monto . $moneda . $impuesto . $email . $celular;
            }
            $i++;
        }

        list($monto, $decimales) = explode(".", $monto_cabecera);
        $mo_total = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 17, "0", STR_PAD_LEFT);
        print(trim($tipo_registro . $descripcion . $rif . $contrato . $lote . $fecha . $cant_operaciones . $mo_total . $moneda . $filler));
        print($cuerpo);

        return sfView::NONE;
    }
    
    public function executePagoBodEmbargo(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("i");
        
        $c1 = new Criteria();
        $c1->clearSelectColumns();
        $c1->addSelectColumn(Tb161PagoFondoTerceroPeer::CO_PAGO_FONDO_TERCERO);
        $c1->addJoin(Tb161PagoFondoTerceroPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c1->add(Tb030RutaPeer::CO_RUTA, $codigo);
        $stmt1 = Tb161PagoFondoTerceroPeer::doSelectStmt($c1);
        $res1 = $stmt1->fetch(PDO::FETCH_ASSOC);

        $con = Propel::getConnection();
        
         $sql_cant = "SELECT count(*) as cant
        FROM tb162_archivo_fondo_tercero tb162
        INNER JOIN  tb161_pago_fondo_tercero tb161 on (tb161.co_pago_fondo_tercero = tb162.co_fondo_tercero)
        INNER JOIN  tb062_liquidacion_pago tb062 on (tb062.co_solicitud = tb161.co_solicitud)
        INNER JOIN  tb063_pago tb063 on (tb063.co_liquidacion_pago = tb062.co_liquidacion_pago)
        INNER JOIN  tb011_cuenta_bancaria tb011 on (tb011.co_cuenta_bancaria = tb063.co_cuenta_bancaria)
        WHERE CO_FONDO_TERCERO= ".$res1["co_pago_fondo_tercero"];

         $stmt_cant = $con->prepare($sql_cant);

         $stmt_cant->execute();     
         
          $row = $stmt_cant->fetch(PDO::FETCH_ASSOC);      

         $sql = "SELECT tb162.TX_CEDULA, tb162.TX_CUENTA_BANCARIA, tb162.NU_MONTO, tb162.NB_PERSONA,tb162.COD_BANCO, 
        tb063.FE_PAGO, tb011.NU_CONTRATO, tb063.NU_PAGO, tb063.CO_PAGO 
        FROM tb162_archivo_fondo_tercero tb162
        INNER JOIN  tb161_pago_fondo_tercero tb161 on (tb161.co_pago_fondo_tercero = tb162.co_fondo_tercero)
        INNER JOIN  tb062_liquidacion_pago tb062 on (tb062.co_solicitud = tb161.co_solicitud)
        INNER JOIN  tb063_pago tb063 on (tb063.co_liquidacion_pago = tb062.co_liquidacion_pago)
        INNER JOIN  tb011_cuenta_bancaria tb011 on (tb011.co_cuenta_bancaria = tb063.co_cuenta_bancaria)
        WHERE CO_FONDO_TERCERO= ".$res1["co_pago_fondo_tercero"];

         $stmt = $con->prepare($sql);

         $stmt->execute();        

     
        $cant = $row["cant"];
//        var_dump($cant);
//        exit();
        $ref = 1;
        $i = 0;
        $monto_cabecera = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="nomina.txt"');

        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

         
            
            $ref++;    
            $cedula = str_pad(substr(trim($res["tx_cedula"]), 1), 9, "0", STR_PAD_LEFT);
            $inicial = substr(trim($res["tx_cedula"]), 0, 1);
            $nombre = str_pad(trim($res["nb_persona"]), 60, " ", STR_PAD_RIGHT);
            $referencia = str_pad($ref, 9, "0", STR_PAD_LEFT);
            $tx_concepto = str_pad(trim(substr('PAGO NOMINA',1,20)), 30, " ", STR_PAD_RIGHT);

            $cuenta = str_pad(trim($res["tx_cuenta_bancaria"]), 20, "0", STR_PAD_LEFT);
            
            if (substr(trim($res["tx_cuenta_bancaria"]), 0, 4)== '0116'||substr(trim($res["tx_cuenta_bancaria"]), 0, 4)== '0000'){
                $tipo = 'CTA';
                $cod_banco='0116';
            }else{
                $cod_banco=substr(trim($res["tx_cuenta_bancaria"]), 0, 4);
                $tipo = 'BAN';
            }

            list($anio, $mes, $dia) = explode("-", trim($res["fe_pago"]));
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

            $contrato = trim($res["nu_contrato"]);
            $lote = str_pad(trim($res["nu_pago"]), 9, "0", STR_PAD_LEFT); //"000193907";  

            $cant_operaciones = str_pad($cant, 6, "0", STR_PAD_LEFT);

            $filler = str_pad("", 158, " ", STR_PAD_RIGHT);

            if($nu_monto>0){
            $cuerpo .= "\r\n02" . $inicial . $cedula . $nombre . $referencia . $tx_concepto . $tipo . $cuenta . $cod_banco . $fecha . $nu_monto . $moneda . $impuesto . $email . $celular;
            }
            $i++;
            
            $mo_total = $this->getMoTotal($res["co_pago"]);
        }
        $mo_total_decimales = round($monto_cabecera,2);
        list($monto, $decimales) = explode(".", $mo_total_decimales);
        
        $mo_total = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 17, "0", STR_PAD_LEFT);
        print(trim($tipo_registro . $descripcion . $rif . $contrato . $lote . $fecha . $cant_operaciones . $mo_total . $moneda . $filler));
        print($cuerpo);

        return sfView::NONE;
    }

    public function executePagoBod(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("i");

        $c = new Criteria();
        $c->clearSelectColumns();

        $c->addSelectColumn(Tb123ArchivoPagoPeer::TX_CEDULA);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::NU_MONTO);
        $c->addSelectColumn(Tb122PagoNominaPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::NB_PERSONA);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::COD_BANCO);
        $c->addSelectColumn(Tb063PagoPeer::FE_PAGO);
        $c->addSelectColumn(Tb122PagoNominaPeer::MO_TOTAL);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::NU_CONTRATO);
        $c->addSelectColumn(Tb063PagoPeer::NU_PAGO);

        $c->addJoin(Tb063PagoPeer::CO_CUENTA_BANCARIA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO, Tb063PagoPeer::CO_LIQUIDACION_PAGO);
        $c->addJoin(Tb123ArchivoPagoPeer::CO_PAGO_NOMINA, Tb122PagoNominaPeer::CO_PAGO_NOMINA);
        $c->addJoin(Tb122PagoNominaPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);

       // $c->add(Tb123ArchivoPagoPeer::COD_BANCO, array('0108','0102'), Criteria::NOT_IN);
       
        $c->add(Tb123ArchivoPagoPeer::COD_BANCO, '0116');
        $c->add(Tb030RutaPeer::CO_RUTA, $codigo);
        $c->add(Tb063PagoPeer::CO_BANCO,1);
        $c->add(Tb123ArchivoPagoPeer::NU_MONTO,0, Criteria::GREATER_THAN);

        //echo $c->toString(); exit();

        $cant = Tb123ArchivoPagoPeer::doCount($c);

        $stmt = Tb123ArchivoPagoPeer::doSelectStmt($c);
        $ref = 1;
        $i = 0;
        $monto_cabecera = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="nomina.txt"');

        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $ref++;    
            $cedula = str_pad(substr(trim($res["tx_cedula"]), 1), 9, "0", STR_PAD_LEFT);
            $inicial = substr(trim($res["tx_cedula"]), 0, 1);
            $nombre = str_pad(trim(utf8_decode($res["nb_persona"])), 60, " ", STR_PAD_RIGHT);
            $referencia = str_pad($ref, 9, "0", STR_PAD_LEFT);
            $tx_concepto = str_pad(trim(substr($res["tx_concepto"],1,20)), 30, " ", STR_PAD_RIGHT);

            $cuenta = str_pad(trim($res["tx_cuenta_bancaria"]), 20, "0", STR_PAD_LEFT);
            $cod_banco = substr(trim($res["tx_cuenta_bancaria"]), 0, 4);

            if(strlen(trim($res["tx_cuenta_bancaria"]))<20){
                $cod_banco='0116';
            }
            
            if ($cod_banco == '0116')
                $tipo = 'CTA';
            else
                $tipo = 'BAN';


            list($anio, $mes, $dia) = explode("-", trim($res["fe_pago"]));
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

            $contrato = trim($res["nu_contrato"]);
            $lote = str_pad(trim($res["nu_pago"]), 9, "0", STR_PAD_LEFT); //"000193907";  

            $cant_operaciones = str_pad($cant, 6, "0", STR_PAD_LEFT);

            $filler = str_pad("", 158, " ", STR_PAD_RIGHT);

            if($nu_monto>0){
            $cuerpo .= "\r\n02" . $inicial . $cedula . $nombre . $referencia . $tx_concepto . $tipo . $cuenta . $cod_banco . $fecha . $nu_monto . $moneda . $impuesto . $email . $celular;
            }
            $i++;
        }
        $mo_total_decimales = round($monto_cabecera,2);
        list($monto, $decimales) = explode(".", $mo_total_decimales);
        
        $mo_total = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 17, "0", STR_PAD_LEFT);
        print(trim($tipo_registro . $descripcion . $rif . $contrato . $lote . $fecha . $cant_operaciones . $mo_total . $moneda . $filler));
        print($cuerpo);

        return sfView::NONE;
    }

    public function executePagoBodCta(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("i");

        $c = new Criteria();
        $c->clearSelectColumns();

        $c->addSelectColumn(Tb123ArchivoPagoPeer::TX_CEDULA);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::NU_MONTO);
        $c->addSelectColumn(Tb122PagoNominaPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::NB_PERSONA);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::COD_BANCO);
        $c->addSelectColumn(Tb063PagoPeer::FE_PAGO);
        $c->addSelectColumn(Tb122PagoNominaPeer::MO_TOTAL);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::NU_CONTRATO);
        $c->addSelectColumn(Tb063PagoPeer::NU_PAGO);

        $c->addJoin(Tb063PagoPeer::CO_CUENTA_BANCARIA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO, Tb063PagoPeer::CO_LIQUIDACION_PAGO);
        $c->addJoin(Tb123ArchivoPagoPeer::CO_PAGO_NOMINA, Tb122PagoNominaPeer::CO_PAGO_NOMINA);
        $c->addJoin(Tb122PagoNominaPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);

       // $c->add(Tb123ArchivoPagoPeer::COD_BANCO, array('0108','0102'), Criteria::NOT_IN);
       
        $c->add(Tb123ArchivoPagoPeer::COD_BANCO, '0116');
        $c->add(Tb123ArchivoPagoPeer::ID_TB163_MODO_PAGO, 1);
        $c->add(Tb030RutaPeer::CO_RUTA, $codigo);
        $c->add(Tb063PagoPeer::CO_BANCO,1);
        $c->add(Tb123ArchivoPagoPeer::NU_MONTO,0, Criteria::GREATER_THAN);

        //echo $c->toString(); exit();

        $cant = Tb123ArchivoPagoPeer::doCount($c);

        $stmt = Tb123ArchivoPagoPeer::doSelectStmt($c);
        $ref = 1;
        $i = 0;
        $monto_cabecera = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="nomina.txt"');

        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $ref++;    
            $cedula = str_pad(substr(trim($res["tx_cedula"]), 1), 9, "0", STR_PAD_LEFT);
            $inicial = substr(trim($res["tx_cedula"]), 0, 1);
            $nombre = str_pad(trim($res["nb_persona"]), 60, " ", STR_PAD_RIGHT);
            $referencia = str_pad($ref, 9, "0", STR_PAD_LEFT);
            $tx_concepto = str_pad(trim(substr($res["tx_concepto"],1,20)), 30, " ", STR_PAD_RIGHT);

            $cuenta = str_pad(trim($res["tx_cuenta_bancaria"]), 20, "0", STR_PAD_LEFT);
            $cod_banco = substr(trim($res["tx_cuenta_bancaria"]), 0, 4);

            if(strlen(trim($res["tx_cuenta_bancaria"]))<20){
                $cod_banco='0116';
            }
            
            if ($cod_banco == '0116')
                $tipo = 'CTA';
            else
                $tipo = 'BAN';


            list($anio, $mes, $dia) = explode("-", trim($res["fe_pago"]));
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

            $contrato = trim($res["nu_contrato"]);
            $lote = str_pad(trim($res["nu_pago"]), 9, "0", STR_PAD_LEFT); //"000193907";  

            $cant_operaciones = str_pad($cant, 6, "0", STR_PAD_LEFT);

            $filler = str_pad("", 158, " ", STR_PAD_RIGHT);

            if($nu_monto>0){
            $cuerpo .= "\r\n02" . $inicial . $cedula . $nombre . $referencia . $tx_concepto . $tipo . $cuenta . $cod_banco . $fecha . $nu_monto . $moneda . $impuesto . $email . $celular;
            }
            $i++;
        }
        $mo_total_decimales = round($monto_cabecera,2);
        list($monto, $decimales) = explode(".", $mo_total_decimales);
        
        $mo_total = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 17, "0", STR_PAD_LEFT);
        print(trim($tipo_registro . $descripcion . $rif . $contrato . $lote . $fecha . $cant_operaciones . $mo_total . $moneda . $filler));
        print($cuerpo);

        return sfView::NONE;
    }

    public function executePagoBodBan(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("i");

        $c = new Criteria();
        $c->clearSelectColumns();

        $c->addSelectColumn(Tb123ArchivoPagoPeer::TX_CEDULA);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::NU_MONTO);
        $c->addSelectColumn(Tb122PagoNominaPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::NB_PERSONA);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::COD_BANCO);
        $c->addSelectColumn(Tb063PagoPeer::FE_PAGO);
        $c->addSelectColumn(Tb122PagoNominaPeer::MO_TOTAL);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::NU_CONTRATO);
        $c->addSelectColumn(Tb063PagoPeer::NU_PAGO);

        $c->addJoin(Tb063PagoPeer::CO_CUENTA_BANCARIA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO, Tb063PagoPeer::CO_LIQUIDACION_PAGO);
        $c->addJoin(Tb123ArchivoPagoPeer::CO_PAGO_NOMINA, Tb122PagoNominaPeer::CO_PAGO_NOMINA);
        $c->addJoin(Tb122PagoNominaPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);

       // $c->add(Tb123ArchivoPagoPeer::COD_BANCO, array('0108','0102'), Criteria::NOT_IN);
       
        $c->add(Tb123ArchivoPagoPeer::COD_BANCO, '0116');
        $c->add(Tb123ArchivoPagoPeer::ID_TB163_MODO_PAGO, 2);
        $c->add(Tb030RutaPeer::CO_RUTA, $codigo);
        $c->add(Tb063PagoPeer::CO_BANCO,1);
        $c->add(Tb123ArchivoPagoPeer::NU_MONTO,0, Criteria::GREATER_THAN);

        //echo $c->toString(); exit();

        $cant = Tb123ArchivoPagoPeer::doCount($c);

        $stmt = Tb123ArchivoPagoPeer::doSelectStmt($c);
        $ref = 1;
        $i = 0;
        $monto_cabecera = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="nomina.txt"');

        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $ref++;    
            $cedula = str_pad(substr(trim($res["tx_cedula"]), 1), 9, "0", STR_PAD_LEFT);
            $inicial = substr(trim($res["tx_cedula"]), 0, 1);
            $nombre = str_pad(trim($res["nb_persona"]), 60, " ", STR_PAD_RIGHT);
            $referencia = str_pad($ref, 9, "0", STR_PAD_LEFT);
            $tx_concepto = str_pad(trim(substr($res["tx_concepto"],1,20)), 30, " ", STR_PAD_RIGHT);

            $cuenta = str_pad(trim($res["tx_cuenta_bancaria"]), 20, "0", STR_PAD_LEFT);
            $cod_banco = substr(trim($res["tx_cuenta_bancaria"]), 0, 4);

            if(strlen(trim($res["tx_cuenta_bancaria"]))<20){
                $cod_banco='0116';
            }
            
            if ($cod_banco == '0116')
                $tipo = 'CTA';
            else
                $tipo = 'BAN';


            list($anio, $mes, $dia) = explode("-", trim($res["fe_pago"]));
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

            $contrato = trim($res["nu_contrato"]);
            $lote = str_pad(trim($res["nu_pago"]), 9, "0", STR_PAD_LEFT); //"000193907";  

            $cant_operaciones = str_pad($cant, 6, "0", STR_PAD_LEFT);

            $filler = str_pad("", 158, " ", STR_PAD_RIGHT);

            if($nu_monto>0){
            $cuerpo .= "\r\n02" . $inicial . $cedula . $nombre . $referencia . $tx_concepto . $tipo . $cuenta . $cod_banco . $fecha . $nu_monto . $moneda . $impuesto . $email . $celular;
            }
            $i++;
        }
        $mo_total_decimales = round($monto_cabecera,2);
        list($monto, $decimales) = explode(".", $mo_total_decimales);
        
        $mo_total = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 17, "0", STR_PAD_LEFT);
        print(trim($tipo_registro . $descripcion . $rif . $contrato . $lote . $fecha . $cant_operaciones . $mo_total . $moneda . $filler));
        print($cuerpo);

        return sfView::NONE;
    }

    protected function getMoTotal($codigo) {

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn('SUM(' . Tb063PagoPeer::NU_MONTO . ') AS mo_total');
        //$c->addJoin(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO, Tb063PagoPeer::CO_LIQUIDACION_PAGO);
        //$c->addJoin(Tb062LiquidacionPagoPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        //$c->add(Tb008ProveedorPeer::NU_CUENTA_BANCARIA, '0116%', Criteria::LIKE);
        $c->add(Tb063PagoPeer::CO_PAGO, $codigo);

//        echo $c->toString(); exit();

        $stmt = Tb063PagoPeer::doSelectStmt($c);

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        return $res["mo_total"];
    }
    
    
    protected function getMoTotalUnificado($array) {

        $c = new Criteria();
        $c->clearSelectColumns();

       
        $c->addSelectColumn("sum(".Tb063PagoPeer::NU_MONTO.") as mo_total");

        $c->addJoin(Tb063PagoPeer::CO_CUENTA_BANCARIA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO, Tb063PagoPeer::CO_LIQUIDACION_PAGO);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tb008ProveedorPeer::CO_DOCUMENTO);
        // $c->add(Tb008ProveedorPeer::NU_CUENTA_BANCARIA,'0116%', Criteria::LIKE);
        $c->add(Tb030RutaPeer::IN_ACTUAL,TRUE);
        $c->add(Tb063PagoPeer::CO_PAGO, $array, Criteria::IN);
        
       

        $stmt = Tb063PagoPeer::doSelectStmt($c);

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        return $res["mo_total"];
    }
    
    
    

    protected function PagoProveedor($codigo) {

        // $codigo = $this->getRequestParameter("i");

        $c = new Criteria();
        $c->clearSelectColumns();

        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::NU_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb063PagoPeer::NU_MONTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb063PagoPeer::FE_PAGO);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::NU_CONTRATO);
        $c->addSelectColumn(Tb063PagoPeer::NU_PAGO);

        $c->addJoin(Tb063PagoPeer::CO_CUENTA_BANCARIA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO, Tb063PagoPeer::CO_LIQUIDACION_PAGO);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_SOLICITUD, Tb026SolicitudPeer::CO_SOLICITUD);
        //$c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addJoin(Tb007DocumentoPeer::CO_DOCUMENTO, Tb008ProveedorPeer::CO_DOCUMENTO);
        // $c->add(Tb008ProveedorPeer::NU_CUENTA_BANCARIA,'0116%', Criteria::LIKE);
        $c->add(Tb063PagoPeer::CO_PAGO, $codigo);
        $c->setLimit(1);
        $c->addDescendingOrderByColumn(Tb063PagoPeer::CO_PAGO);

      

        $cant = Tb063PagoPeer::doCount($c);

        $stmt = Tb063PagoPeer::doSelectStmt($c);
        $ref = 1;
        $i = 0;

        $monto_total = $this->getMoTotal($codigo);

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="proveedor.txt"');

        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if($res["nu_cuenta_bancaria"]==''){
                echo "Para generar el archivo debe asociar una cuenta bancaria al proveedor";
                exit();
            }

            $res["tx_razon_social"] = str_replace(",", "", trim($res["tx_razon_social"]));
            $res["tx_razon_social"] = str_replace(".", "", trim($res["tx_razon_social"]));

            $cedula = str_pad(trim($res["tx_rif"]), 9, "0", STR_PAD_LEFT);
            $inicial = substr(trim($res["inicial"]), 0, 1);
            $nombre = str_pad(trim(substr($res["tx_razon_social"], 1, 50)), 60, " ", STR_PAD_RIGHT);
            $referencia = str_pad($ref, 9, "0", STR_PAD_LEFT);
            $tx_concepto = str_pad("PAGO A PROVEEDORES", 30, " ", STR_PAD_RIGHT);

            $cuenta = trim($res["nu_cuenta_bancaria"]);
            $cod_banco = substr(trim($res["nu_cuenta_bancaria"]), 0, 4);

            if ($cod_banco == '0116')
                $tipo = 'CTA';
            else
                $tipo = 'BAN';



            list($anio, $mes, $dia) = explode("-", $res["fe_pago"]);
            list($monto, $decimales) = explode(".", $res["nu_monto"]);
            list($monto_total, $dec) = explode(".", $monto_total);

            $fecha = $anio . $mes . $dia;

            // $mo_total = str_pad($monto_total.str_pad($dec,2,"0",STR_PAD_RIGHT), 17, "0", STR_PAD_LEFT);
            $mo_total = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 17, "0", STR_PAD_LEFT);
            $nu_monto = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 15, "0", STR_PAD_LEFT);
            $impuesto = str_pad(0, 15, "0", STR_PAD_LEFT);
            $email = str_pad('', 40, " ", STR_PAD_RIGHT);
            $celular = str_pad(0, 11, "0", STR_PAD_LEFT);

            $moneda = 'VEB';

            $tipo_registro = '01';
            $descripcion = str_pad('Proveedores', 20, " ", STR_PAD_RIGHT);
            $rif = "G200036524";
            $contrato = trim($res["nu_contrato"]);
            $lote = str_pad(trim($res["nu_pago"]), 9, "0", STR_PAD_LEFT); //"000193907";
            $cant_operaciones = str_pad($cant, 6, "0", STR_PAD_LEFT);
            $filler = str_pad("", 158, " ", STR_PAD_RIGHT);


            if ($i == 0) {
                print(trim($tipo_registro . $descripcion . $rif . $contrato . $lote . $fecha . $cant_operaciones . $mo_total . $moneda . $filler));
            }

            if($nu_monto>0){
            print("\r\n02" . $inicial . $cedula . $nombre . $referencia . $tx_concepto . $tipo . $cuenta . $cod_banco . $fecha . $nu_monto . $moneda . $impuesto . $email . $celular);
            }
            $i++;
        }

        return sfView::NONE;
    }

    public function executePagoProvincial(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("i");

        $c = new Criteria();
        $c->clearSelectColumns();

        $c->addSelectColumn(Tb123ArchivoPagoPeer::TX_CEDULA);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::NU_MONTO);
        $c->addSelectColumn(Tb122PagoNominaPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::NB_PERSONA);
        $c->addSelectColumn(Tb063PagoPeer::FE_PAGO);
        $c->addSelectColumn(Tb122PagoNominaPeer::MO_TOTAL);

        $c->addJoin(Tb063PagoPeer::CO_CUENTA_BANCARIA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO, Tb063PagoPeer::CO_LIQUIDACION_PAGO);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);        
        $c->addJoin(Tb123ArchivoPagoPeer::CO_PAGO_NOMINA, Tb122PagoNominaPeer::CO_PAGO_NOMINA);
        $c->addJoin(Tb122PagoNominaPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->add(Tb123ArchivoPagoPeer::COD_BANCO, '0108%', Criteria::LIKE);
        $c->add(Tb030RutaPeer::CO_RUTA, $codigo);
        $c->add(Tb063PagoPeer::CO_BANCO,4);
        $c->add(Tb123ArchivoPagoPeer::NU_MONTO,0, Criteria::GREATER_THAN);
        
        //echo $c->toString(); exit();

        $cant = Tb123ArchivoPagoPeer::doCount($c);

        $stmt = Tb123ArchivoPagoPeer::doSelectStmt($c);
        $ref = 1;
        $i = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="NOMINA.TXT"');


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
            if($nu_monto>0){
            print(trim($inicial . $cedula . $nombre . $cuenta . $nu_monto));
            }
            $i++;
        }

        return sfView::NONE;
    }

    public function executePagoProvincialFondoTercero(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("i");

        $c = new Criteria();
        $c->clearSelectColumns();

        $c->addSelectColumn(Tb162ArchivoFondoTerceroPeer::TX_CEDULA);
        $c->addSelectColumn(Tb162ArchivoFondoTerceroPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb162ArchivoFondoTerceroPeer::NU_MONTO);
        $c->addSelectColumn(Tb162ArchivoFondoTerceroPeer::NB_PERSONA);
        $c->addSelectColumn(Tb162ArchivoFondoTerceroPeer::COD_BANCO);
        $c->addSelectColumn(Tb063PagoPeer::FE_PAGO);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::NU_CONTRATO);
        $c->addSelectColumn(Tb063PagoPeer::NU_PAGO);
        $c->addSelectColumn(Tb063PagoPeer::CO_PAGO);
        

        $c->addJoin(Tb063PagoPeer::CO_CUENTA_BANCARIA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO, Tb063PagoPeer::CO_LIQUIDACION_PAGO);
        $c->addJoin(Tb162ArchivoFondoTerceroPeer::CO_FONDO_TERCERO, Tb161PagoFondoTerceroPeer::CO_PAGO_FONDO_TERCERO);
        $c->addJoin(Tb161PagoFondoTerceroPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);

       // $c->add(Tb162ArchivoFondoTerceroPeer::COD_BANCO, array('0108','0102'), Criteria::NOT_IN);
       
        $c->add(Tb162ArchivoFondoTerceroPeer::COD_BANCO, '0108');
        $c->add(Tb030RutaPeer::CO_RUTA, $codigo);
        //$c->add(Tb063PagoPeer::CO_BANCO, 4);

        $cant = Tb162ArchivoFondoTerceroPeer::doCount($c);

        $stmt = Tb162ArchivoFondoTerceroPeer::doSelectStmt($c);
        $ref = 1;
        $i = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="NOMINA.TXT"');


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
            if($nu_monto>0){
            print(trim($inicial . $cedula . $nombre . $cuenta . $nu_monto));
            }
            $i++;
        }

        return sfView::NONE;
    }

    public function executePagoBancodeVenezuela(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("i");

        $c = new Criteria();
        $c->clearSelectColumns();
        //$c->setDistinct();
        $c->addSelectColumn(Tb123ArchivoPagoPeer::TX_CEDULA);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::NU_MONTO);
        $c->addSelectColumn(Tb122PagoNominaPeer::TX_CONCEPTO);
        $c->addSelectColumn(Tb123ArchivoPagoPeer::NB_PERSONA);
        $c->addSelectColumn(Tb063PagoPeer::FE_PAGO);
        $c->addSelectColumn(Tb122PagoNominaPeer::MO_TOTAL);
        $c->addAsColumn('cuenta_banco', Tb011CuentaBancariaPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb063PagoPeer::NU_PAGO);

        $c->addJoin(Tb063PagoPeer::CO_CUENTA_BANCARIA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO, Tb063PagoPeer::CO_LIQUIDACION_PAGO);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->addJoin(Tb123ArchivoPagoPeer::CO_PAGO_NOMINA, Tb122PagoNominaPeer::CO_PAGO_NOMINA);
        $c->addJoin(Tb122PagoNominaPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->add(Tb123ArchivoPagoPeer::COD_BANCO, '0102', Criteria::LIKE);
        $c->add(Tb030RutaPeer::CO_RUTA, $codigo);
        $c->add(Tb063PagoPeer::CO_BANCO,3);
        $c->add(Tb123ArchivoPagoPeer::NU_MONTO,0, Criteria::GREATER_THAN);
        
      //  echo $c->toString(); exit();

        $cant = Tb123ArchivoPagoPeer::doCount($c);

        $stmt = Tb123ArchivoPagoPeer::doSelectStmt($c);
        $ref = 1;
        $i = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="BANVENEZ.txt"');

        $monto_total = 0;
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $cuenta_banco = $res["cuenta_banco"];

            
            $cedula = str_pad(substr(trim($res["tx_cedula"]), 1), 10, "0", STR_PAD_LEFT);
            $inicial = substr(trim($res["tx_cedula"]), 0, 1);
            $nombre = str_pad(trim($res["nb_persona"]), 40, " ", STR_PAD_RIGHT);

            $lote = "003291"; //str_pad($res["nu_pago"], 6, "0", STR_PAD_LEFT);
            $lotec = "03291"; //str_pad($res["nu_pago"], 6, "0", STR_PAD_LEFT);

            list($monto, $decimales) = explode(".", $res["nu_monto"]);
            $tipo_cuenta = substr($res["tx_cuenta_bancaria"],11,1);
            $cuenta = $res["tx_cuenta_bancaria"];

            $monto_total += $res["nu_monto"];

            $nu_monto = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 11, "0", STR_PAD_LEFT);

            if($cadena!=''){
                $cadena=$cadena."  ";
            }
            if($nu_monto>0){
            $cadena .= "\r\n".$tipo_cuenta. $cuenta . $nu_monto .$tipo_cuenta.'770' . $nombre . $cedula . $lote;
            }
            $i++;
            
            list($anio,$mes,$dia) = explode("-", $res["fe_pago"]);
            
        }
        $mo_total_decimales = round($monto_total,2);
        list($monto, $decimales) = explode(".", $mo_total_decimales);

        $total = str_pad($monto . str_pad($decimales, 2, "0", STR_PAD_RIGHT), 13, "0", STR_PAD_LEFT);

        print("HGOBERNACION DEL ESTADO ZULIA            ".$cuenta_banco."01".$dia."/".$mes."/".substr($anio, 2, 4). $total . $lotec.' ');
        print($cadena);
        return sfView::NONE;
    }

    public function executePagoBancodeVenezuelaFondoTercero(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("i");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->setDistinct();
        $c->addSelectColumn(Tb162ArchivoFondoTerceroPeer::TX_CEDULA);
        $c->addSelectColumn(Tb162ArchivoFondoTerceroPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb162ArchivoFondoTerceroPeer::NU_MONTO);
        $c->addSelectColumn(Tb162ArchivoFondoTerceroPeer::NB_PERSONA);
        $c->addSelectColumn(Tb162ArchivoFondoTerceroPeer::COD_BANCO);
        $c->addSelectColumn(Tb063PagoPeer::FE_PAGO);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::NU_CONTRATO);
        $c->addSelectColumn(Tb063PagoPeer::NU_PAGO);
        $c->addSelectColumn(Tb063PagoPeer::CO_PAGO);
        

        $c->addJoin(Tb063PagoPeer::CO_CUENTA_BANCARIA, Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO, Tb063PagoPeer::CO_LIQUIDACION_PAGO);
        $c->addJoin(Tb162ArchivoFondoTerceroPeer::CO_FONDO_TERCERO, Tb161PagoFondoTerceroPeer::CO_PAGO_FONDO_TERCERO);
        $c->addJoin(Tb161PagoFondoTerceroPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);

       // $c->add(Tb123ArchivoPagoPeer::COD_BANCO, array('0108','0102'), Criteria::NOT_IN);
       
        $c->add(Tb162ArchivoFondoTerceroPeer::COD_BANCO, '0102');
        $c->add(Tb030RutaPeer::CO_RUTA, $codigo);
        //$c->add(Tb063PagoPeer::CO_BANCO, 3);
        
      //  echo $c->toString(); exit();

        $cant = Tb162ArchivoFondoTerceroPeer::doCount($c);

        $stmt = Tb162ArchivoFondoTerceroPeer::doSelectStmt($c);
        $ref = 1;
        $i = 0;

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="BANVENEZ.txt"');

        $monto_total = 0;
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $cuenta_banco = $res["cuenta_banco"];

            
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
            if($nu_monto>0){
            $cadena .= "\r\n".$tipo_cuenta. $cuenta . $nu_monto .$tipo_cuenta.'770' . $nombre . $cedula . $lote;
            }
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

    public function executeDocumento(sfWebRequest $request) {

        $codigo = $this->getRequestParameter("i");

        $encrypt = new myConfig();

        $c = new Criteria();
        $c->clearSelectColumns();

        $c->addSelectColumn(Tb030RutaPeer::TX_DOCUMENTO);
        $c->add(Tb030RutaPeer::CO_RUTA, $encrypt->decrypt($codigo));


        $stmt = Tb030RutaPeer::doSelectStmt($c);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);



        if ($codigo != '') {
            $gestor = fopen($res["tx_documento"], "r");

            $file = fread($gestor, filesize($res["tx_documento"]));
            $response = $this->getResponse();
            $response->setContentType("application/pdf");
            $response->setContent($file);
        }

        return sfView::NONE;
    }

}
