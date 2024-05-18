<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Isilio Vilchez");
    $objPHPExcel->getProperties()->setTitle("RELACIÓN DE RETENCION ISLR");
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
    $objPHPExcel->getActiveSheet()->setTitle('RETENCION ISLR CON IMPUESTO');
    // Initialise the Excel row number
    $rowCount = 2;
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'SEC')
    ->setCellValue('B1', 'RETENIDO')
    ->setCellValue('C1', 'FACTURA')
    ->setCellValue('D1', 'CONTROL')
    ->setCellValue('E1', 'FECOPE')
    ->setCellValue('F1', 'CONCEPTO')
    ->setCellValue('G1', 'OPERACION')
    ->setCellValue('H1', 'REREO');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

        $condicion ="";    
        $condicion .= " tb013.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb013.fe_pago <= '".$_GET["fe_fin"]."' ";
        
        $conex = new ConexionComun(); 
        
        $sql = "select tb001.nu_rif,id_tbrh002_ficha, operacion,nu_valor::numeric,nu_monto from 
(
select distinct nu_cedula,tb061.id_tbrh002_ficha,round((sum(tb061.nu_monto) / (nu_valor/100)),2) as operacion,tb061.nu_valor,round((sum(tb061.nu_monto)),2) as nu_monto 
from tbrh061_nomina_movimiento tb061
inner join tbrh002_ficha tb02 on (tb02.co_ficha = tb061.id_tbrh002_ficha) 
inner join tbrh013_nomina tb013 on (tb013.co_nomina = tb061.id_tbrh013_nomina)
inner join tb026_solicitud tb026 on (tb026.co_solicitud = tb013.co_solicitud)
inner join tbrh001_trabajador tb001 on (tb001.co_trabajador = tb02.co_trabajador)
 where $condicion and tb013.id_tbrh060_nomina_estatus = 3 and tb061.id_tbrh014_concepto in(12) and tb026.in_patria is not true
group by nu_cedula ,tb061.id_tbrh002_ficha,tb061.nu_valor 
) as q1 
inner join tbrh001_trabajador tb001 on (tb001.nu_cedula = q1.nu_cedula)";
     
    $retencion = $conex->ObtenerFilasBySqlSelect($sql);

    //var_dump($sql); exit();
    $rowCount = 2;

    foreach ($retencion as $key => $value) {
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, 1, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['nu_rif'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, '0000000000', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, 'NA', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, date("d/m/Y", strtotime($_GET['fe_fin'])), PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, '001', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $value['operacion'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $value['nu_valor'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $value['nu_monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        // Increment the Excel row counter
        $rowCount++;

    }       

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="retencion_proveedor_'.date("d-m-Y").'.xlsx"');
    $objWriter->save('php://output');

?>