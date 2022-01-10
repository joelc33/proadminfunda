<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Isilio Vilchez");
    $objPHPExcel->getProperties()->setTitle("Listado de Movimientos de Bancos");
    $objPHPExcel->getProperties()->setSubject("Reporte");
    $objPHPExcel->getProperties()->setDescription("Reporte para documento de Office 2007 XLSX.");
    // Set the active Excel worksheet to sheet 0
    $objPHPExcel->setActiveSheetIndex(0);
    // Rename sheet
    
    $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->setTitle('MOVIMIENTOS BANCARIOS');

    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn

    $conex = new ConexionComun();
      
    $condicion ="";
    $condicion_cuenta ="";

    $fe_inicio    = $_GET['fe_inicio'];    
    $fe_fin       = $_GET['fe_fin'];   
    $co_banco     = $_GET['co_banco'];
    $co_cta       = $_GET['co_cuenta'];
    
    
    $condicion_saldo_anterior .= " and fe_transaccion >= '". $_GET["fe_inicio"]."' and ";
    $condicion_saldo_anterior .= " fe_transaccion <= '".$_GET["fe_fin"]."' ";

          $conex = new ConexionComun();     
          $sql = "  SELECT fe_transaccion, mo_saldo_anterior
                    FROM tb155_cuenta_bancaria_historico 
                    where id_tb011_cuenta_bancaria = $co_cta $condicion_saldo_anterior
                    order by 1,id asc limit 1 "; 
                        
        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);   
    
    $saldo = $datosSol[0]["mo_saldo_anterior"];
    //echo var_dump($saldo); exit();
    
    
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', '')
    ->setCellValue('B1', '')
    ->setCellValue('C1', '')
    ->setCellValue('D1', 'RELACIÓN DE MOVIMIENTOS BANCARIOS DEL  '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))
    ->setCellValue('E1', '')
    ->setCellValue('F1', '')    
    ->setCellValue('G1', '')
    ->setCellValue('H1', '')
    ->setCellValue('I1', '')
    ->setCellValue('J1', '');
    
        $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A4', 'Documento ')
    ->setCellValue('B4', 'Solicitud')
    ->setCellValue('C4', 'Beneficiario')
    ->setCellValue('D4', 'Descripcion')
    ->setCellValue('E4', 'Orden de Pago')
    ->setCellValue('F4', 'Fecha')            
    ->setCellValue('G4', 'Referencia')
    ->setCellValue('H4', 'Ingreso')
    ->setCellValue('I4', 'Egreso')
    ->setCellValue('J4', 'Saldo');
        
    if ($co_banco) $condicion_cuenta .= " and tb011.co_banco = ".$co_banco;  
    if ($co_cta)   $condicion_cuenta .= " and tb011.co_cuenta_bancaria = ".$co_cta;     
    
          $sqlCuenta = "  SELECT tb024.tx_descripcion as cuenta, tb010.tx_banco as bco,
                    tb011.co_cuenta_bancaria, tb011.mo_disponible
                    FROM tb010_banco as tb010
                    left join tb011_cuenta_bancaria as tb011 on (tb011.co_banco = tb010.co_banco)
                    left join tb024_cuenta_contable as tb024 on (tb011.co_cuenta_contable = tb024.co_cuenta_contable)
                    where tb011.co_banco = tb010.co_banco $condicion_cuenta 
                    order by bco, cuenta";
                        
        
          $datosCuenta = $conex->ObtenerFilasBySqlSelect($sqlCuenta);           
        
        $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A2', 'Banco: ')
    ->setCellValue('B2', ' '.$datosCuenta[0]["bco"]);  
        
        $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A3', 'Cuenta: ')
    ->setCellValue('B3', ' '.$datosCuenta[0]["cuenta"])
    ->setCellValue('J3', 'SALDO AL INICIO DEL PERIODO '.$saldo)                ;            

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(true);  
    $objPHPExcel->getActiveSheet()->getStyle('A3:J3')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A4:J4')->getFont()->setBold(true);
    
    
    
    $condicion .= " tb155.fe_transaccion >= '". $_GET["fe_inicio"]."' and ";
    $condicion .= " tb155.fe_transaccion <= '".$_GET["fe_fin"]."' ";
    if ($co_banco) $condicion .= " and tb011.co_banco = ".$co_banco;  
    if ($co_cta)   $condicion .= " and tb011.co_cuenta_bancaria = ".$co_cta; 
  
          $sql = "( SELECT tb155.co_solicitud, case when (tb063.co_forma_pago=1) then 'ND-'|| tb063.nu_pago 
                                else tb153.nu_tipo_documento_cuenta ||'-'|| substring(tb155.nu_documento,4,20) end as documento, 
                                case when (tb026.co_tipo_solicitud=18) then 'ALCALDIA DE SAN FRANCISCO' else UPPER(tb008.tx_razon_social) end as beneficiario, 
                                case when (tb026.co_tipo_solicitud=23) then tb122.tx_concepto when (tb026.co_tipo_solicitud=18) then case when (tb026.co_estatus=4) then 'TeC: '|| tb155.de_observacion else 'TeC: '|| tb026.tx_observacion end else tb155.de_observacion end as tx_descripcion,  
                                tb154.nu_operacion as op, to_char(tb155.fe_transaccion,'dd/mm/yyyy') as fecha, 
                                case when (tb026.co_tipo_solicitud=18) then 'OT-'||co_transferencia_cuenta else tb155.nu_transaccion end as referencia, 
                                case when ((tb153.id =1) or (tb153.id =2)) then tb155.mo_transaccion end as monto_ingr , 
                                case when ((tb153.id =3)) then tb155.mo_transaccion end as monto_egr ,tb155.fe_transaccion,tb155.id 
                                from tb026_solicitud as tb026 
                                left join tb155_cuenta_bancaria_historico as tb155 on tb155.co_solicitud = tb026.co_solicitud 
                                left join tb154_tipo_cuenta_movimiento as tb154 on tb154.id = tb155.id_tb154_tipo_cuenta_movimiento 
                                left join tb153_tipo_documento_cuenta as tb153 on tb153.id = tb155.id_tb153_tipo_documento_cuenta 
                                left join tb008_proveedor as tb008 on tb026.co_proveedor=tb008.co_proveedor 
                                left join tb011_cuenta_bancaria as tb011 on tb011.co_cuenta_bancaria = tb155.id_tb011_cuenta_bancaria 
                                left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb155.co_solicitud 
                                left join tb063_pago as tb063 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago 
                                left join tb122_pago_nomina as tb122 on tb122.co_solicitud = tb026.co_solicitud
                                left join tb066_transferencia_cuenta as tb066 on (tb066.co_solicitud = tb155.co_solicitud)
                                left join tb030_ruta as tb030 on (tb030.co_solicitud = tb155.co_solicitud and tb030.in_actual is true)
                                where tb030.co_estatus_ruta<>3 and $condicion
                                group by 1, 2, 3, 4, 5, 6,7,8,9, 10,11 order by 10,1,11)";
     //echo $sql; exit();
    $Movimientos = $conex->ObtenerFilasBySqlSelect($sql);

    //var_dump($sql); exit();
    $rowCount = 5;

    foreach ($Movimientos as $key => $value) {
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
         $saldo   = $saldo + $value['monto_ingr'] - $value['monto_egr'];
        
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['documento'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['co_solicitud'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['beneficiario'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['tx_descripcion'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value['op'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $value['fecha'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $value['referencia'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $value['monto_ingr'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $value['monto_egr'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $saldo, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        // Increment the Excel row counter
        $rowCount++;
        $mo_ingr = $value['monto_ingr'] + $mo_ingr;
        $mo_egr  = $value['monto_egr'] + $mo_egr;        
    }
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, 'Total Saldo:', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $mo_ingr, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $mo_egr, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $saldo, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount.':J'.$rowCount)->getFont()->setBold(true);
    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="movimiento_'.date("d-m-Y").'.xlsx"');
    $objWriter->save('php://output');

?>