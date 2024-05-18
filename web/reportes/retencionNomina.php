<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Joel Camarillo");
    $objPHPExcel->getProperties()->setTitle("Listado de Retenciones Nomina");
    $objPHPExcel->getProperties()->setSubject("Reporte");
    $objPHPExcel->getProperties()->setDescription("Reporte para documento de Office 2007 XLSX.");
    // Set the active Excel worksheet to sheet 0
    $objPHPExcel->setActiveSheetIndex(0);
    // Rename sheet
    $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->setTitle('RETENCIONES_NOMINA');
    // Initialise the Excel row number
    $rowCount = 2;
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'CONC. DENOMINACIÓN')
    ->setCellValue('B1', 'MONTO');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setBold(true);

    $condicion ="";    
    /*$condicion .= " and tb060.fe_pago::date >= '". $_GET["fe_inicio"]."' and ";
    $condicion .= " tb060.fe_pago::date <= '".$_GET["fe_fin"]."' ";*/
    $condicion .= " and tb060.fe_emision::date >= '". $_GET["fe_inicio"]."' and ";
    $condicion .= " tb060.fe_emision::date <= '".$_GET["fe_fin"]."' ";

    $conex = new ConexionComun();

    /*$sql = "SELECT lpad(tx_movimiento,4,'0')||'-'||tx_descripcion as concepto,sum(nu_monto) monto
            FROM public.tb132_pago_nomina_masivo tb132 join public.tb122_pago_nomina tb122 on (tb122.co_pago_nomina = tb132.co_pago)
            join tb060_orden_pago tb060 on (tb060.co_solicitud = tb122.co_solicitud)
            where  tx_tipo_movimiento = 'D' and tb060.in_pagado = true  $condicion
            group by tx_movimiento,tx_descripcion   
            order by tx_movimiento;";*/
    
    $sql = "SELECT lpad(tx_movimiento,4,'0')||'-'||tx_descripcion as concepto,sum(nu_monto) monto
    FROM public.tb132_pago_nomina_masivo tb132 
    inner join public.tb122_pago_nomina tb122 on (tb122.co_pago_nomina = tb132.co_pago)
    inner join tb060_orden_pago tb060 on (tb060.co_solicitud = tb122.co_solicitud)
    where  tx_tipo_movimiento = 'D' $condicion
    group by tx_movimiento,tx_descripcion   
    order by tx_movimiento;";  
     
    $retencion = $conex->ObtenerFilasBySqlSelect($sql);

    //var_dump($retencion); exit();
    $rowCount = 2;

    foreach ($retencion as $key => $value) {
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value['concepto'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $rowCount++;
    }

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    
    header('Content-Disposition: attachment; filename="retencion_nomina_'.date("H:i:s").'.xlsx"');
    $objWriter->save('php://output');

?>