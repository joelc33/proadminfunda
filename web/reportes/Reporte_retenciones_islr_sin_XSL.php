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
    $objPHPExcel->getActiveSheet()->setTitle('RETENCION ISLR SIN IMPUESTO');
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
        
        $sql = "select tb001.nu_rif,id_tbrh002_ficha, round(sum(monto_operacion),2) as operacion,0  
from ( select nu_cedula,tb102.id_tbrh002_ficha,tb013.fe_pago,tb102.id_tbrh013_nomina, (select coalesce(sum(nu_monto),0) as monto 
from tbrh061_nomina_movimiento tb61 where tb61.id_tbrh014_concepto = 12 and id_tbrh002_ficha = tb102.id_tbrh002_ficha and id_tbrh013_nomina = tb102.id_tbrh013_nomina ), 
(select coalesce(sum(nu_monto),0) as monto_operacion from tbrh061_nomina_movimiento tb61 where tb61.id_tbrh014_concepto = 588 and id_tbrh002_ficha = tb102.id_tbrh002_ficha and id_tbrh013_nomina = tb102.id_tbrh013_nomina ) 
from tbrh102_cierre_nomina_trabajador tb102 
inner join tbrh002_ficha tb02 on (tb02.co_ficha = tb102.id_tbrh002_ficha) 
inner join tbrh013_nomina tb013 on (tb013.co_nomina = tb102.id_tbrh013_nomina)
inner join tb026_solicitud tb026 on (tb026.co_solicitud = tb013.co_solicitud)
where $condicion and tb02.co_estatus in (1,2,10) and tb026.in_patria is not true
group by nu_cedula ,tb102.id_tbrh002_ficha,tb013.fe_pago,tb102.id_tbrh013_nomina,monto ) as q1 
inner join tbrh001_trabajador tb001 on (tb001.nu_cedula = q1.nu_cedula) where monto = 0 and tb001.nu_rif <>'' and monto_operacion >0
group by id_tbrh002_ficha ,q1.nu_cedula,tb001.nu_rif";
     
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
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value['fe_pago'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, '001', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $value['operacion'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $value['nu_valor'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
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