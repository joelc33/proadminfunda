<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Isilio Vilchez");
    $objPHPExcel->getProperties()->setTitle("RELACIÓN DETALLADA DE PROVEEDORES Y SINDICATOS");
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
    $objPHPExcel->getActiveSheet()->setTitle('DETALLE DE PROVEEDORES');
    // Initialise the Excel row number
    $rowCount = 2;
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', '')
    ->setCellValue('B1', 'RELACIÓN DETALLADA DE PROVEEDORES Y SINDICATOS DESDE  '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))
    ->setCellValue('C1', '')
    ->setCellValue('D1', '')
    ->setCellValue('E1', '')
    ->setCellValue('F1', '');   

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
    
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A2', 'CEDULA')
    ->setCellValue('B2', 'NOMBRES')
    ->setCellValue('C2', 'NOMINA')
    ->setCellValue('D2', 'CANTIDAD')
    ->setCellValue('E2', 'MONTO')
    ->setCellValue('F2', 'CODIGO')
    ->setCellValue('G2', 'CONCEPTO');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true);

        $condicion ="";    
        $condicion .= " tb013.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb013.fe_pago <= '".$_GET["fe_fin"]."' ";
        $codigo_proveedor = $_GET["codigo_proveedor"];
        
        $conex = new ConexionComun(); 
                  $sql = "select COUNT(DISTINCT id_tbrh002_ficha) as nu_cantidad, sum(nu_monto) as nu_monto , tb001.nu_cedula,tb001.nb_primer_nombre||' '||tb001.nb_primer_apellido as nombre,tb067.tx_grupo_nomina,
tb014.nu_concepto,tb014.tx_concepto from tbrh013_nomina tb013 
inner join tbrh061_nomina_movimiento tb061 on (tb061.id_tbrh013_nomina = tb013.co_nomina) 
inner join tbrh014_concepto tb014 on (tb014.co_concepto = tb061.id_tbrh014_concepto)
inner join tbrh002_ficha tb002 on (tb002.co_ficha = tb061.id_tbrh002_ficha) 
inner join tbrh106_concepto_proveedor tb106 on (tb106.nu_concepto = tb014.nu_concepto) 
inner join tbrh001_trabajador tb001 on (tb001.co_trabajador = tb002.co_trabajador)
inner join tbrh067_grupo_nomina tb067 on (tb067.co_grupo_nomina = tb013.co_grupo_nomina)
inner join tb026_solicitud tb026 on (tb026.co_solicitud = tb013.co_solicitud)
where $condicion and tb013.id_tbrh060_nomina_estatus = 3 and tb014.co_tipo_concepto = 2 and tb106.codigo_proveedor = '".$codigo_proveedor."' and tb026.in_patria is not true
group by tb014.nu_concepto, tb014.tx_concepto,tb001.nu_cedula,tb001.nb_primer_nombre,tb001.nb_primer_apellido,tb067.tx_grupo_nomina 
order by nu_concepto";
     
    $retencion = $conex->ObtenerFilasBySqlSelect($sql);

    //var_dump($sql); exit();
    $rowCount = 3;

    foreach ($retencion as $key => $value) {
        

         $subtotal = $subtotal + $value['nu_monto'];
         $total = $total + $value['nu_monto'];        
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['nu_cedula'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['nombre'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['tx_grupo_nomina'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['nu_cantidad'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value['nu_monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $value['nu_concepto'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $value['tx_concepto'], PHPExcel_Cell_DataType::TYPE_STRING);
        // Increment the Excel row counter
        $rowCount++;

    }
        
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, 'TOTAL .....', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $total, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount.':E'.$rowCount)->getFont()->setBold(true);
        $rowCount++;        

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="retencion_detalle_proveedor_'.date("d-m-Y").'.xlsx"');
    $objWriter->save('php://output');

?>