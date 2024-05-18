<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Isilio Vilchez");
    $objPHPExcel->getProperties()->setTitle("RELACIÓN DE PROVEEDORES Y SINDICATOS");
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
    $objPHPExcel->getActiveSheet()->setTitle('RELACIÓN DE PROVEEDORES');
    // Initialise the Excel row number
    $rowCount = 2;
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', '')
    ->setCellValue('B1', 'RELACIÓN DE PROVEEDORES Y SINDICATOS DESDE  '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))
    ->setCellValue('C1', '')
    ->setCellValue('D1', '')
    ->setCellValue('E1', '')
    ->setCellValue('F1', '');   

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
    
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A2', 'Nº')
    ->setCellValue('B2', 'CONCEPTOS')
    ->setCellValue('C2', 'CANTIDAD')
    ->setCellValue('D2', 'DEDUCCION')
    ->setCellValue('E2', 'APORTE')
    ->setCellValue('F2', 'TOTAL');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getFont()->setBold(true);

        $condicion ="";    
        $condicion .= " tb013.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb013.fe_pago <= '".$_GET["fe_fin"]."' ";
        $codigo_proveedor = $_GET["codigo_proveedor"];
        if($codigo_proveedor){
        $condicion .= " and tb106.codigo_proveedor = '".$codigo_proveedor."' ";    
        }        
        $conex = new ConexionComun(); 
        
        $sql = "select COUNT(DISTINCT id_tbrh002_ficha) as nu_cantidad, sum(nu_monto) as nu_monto , tb014.nu_concepto,tb014.tx_concepto,
                      ( select codigo_proveedor from tbrh106_concepto_proveedor where nu_concepto =  tb014.nu_concepto) as codigo_proveedor, 
                      ( select desc_concepto from tbrh106_concepto_proveedor where nu_concepto =  tb014.nu_concepto) as desc_concepto
                      from tbrh013_nomina tb013
inner join tbrh061_nomina_movimiento tb061 on (tb061.id_tbrh013_nomina = tb013.co_nomina)
inner join tbrh014_concepto tb014 on (tb014.co_concepto = tb061.id_tbrh014_concepto)
inner join tb026_solicitud tb026 on (tb026.co_solicitud = tb013.co_solicitud)
inner join tbrh106_concepto_proveedor tb106 on (tb106.nu_concepto = tb014.nu_concepto)
where $condicion and tb013.id_tbrh060_nomina_estatus = 3 and tb014.co_tipo_concepto in (2,3) and tb026.in_patria is true
 group by tb014.nu_concepto, tb014.tx_concepto order by codigo_proveedor";
     
    $retencion = $conex->ObtenerFilasBySqlSelect($sql);

    //var_dump($sql); exit();
    $rowCount = 3;
    $codigo_proveedor =='';

    foreach ($retencion as $key => $value) {
        
         if($codigo_proveedor ==''){
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['codigo_proveedor'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['desc_concepto'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':B'.$rowCount)->getFont()->setBold(true);
        $rowCount++;
         }
         if($codigo_proveedor <> $value['codigo_proveedor'] && $codigo_proveedor<>''){
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, 'SUB TOTALES.....', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $subtotal, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, 0, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $subtotal, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':F'.$rowCount)->getFont()->setBold(true);
        $rowCount++;
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['codigo_proveedor'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['desc_concepto'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':B'.$rowCount)->getFont()->setBold(true);
        $rowCount++;

         $subtotal = 0;
         }
         $subtotal = $subtotal + $value['nu_monto'];
         $total = $total + $value['nu_monto'];        
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['nu_concepto'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['tx_concepto'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['nu_cantidad'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['nu_monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, 0, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $value['nu_monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        // Increment the Excel row counter
        $rowCount++;
        $codigo_proveedor = $value['codigo_proveedor'];
    }
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, 'SUB TOTALES.....', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $subtotal, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, 0, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $subtotal, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':F'.$rowCount)->getFont()->setBold(true);
        $rowCount++;    
        
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, 'TOTALES .....', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $total, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, 0, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $total, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':F'.$rowCount)->getFont()->setBold(true);
        $rowCount++;        

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="retencion_proveedor'.date("H:i:s").'.xlsx"');
    $objWriter->save('php://output');

?>