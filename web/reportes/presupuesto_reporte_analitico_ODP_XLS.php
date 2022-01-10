<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Yoser Perez");
    $objPHPExcel->getProperties()->setTitle("Reporte Analitico ODP");
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
    $objPHPExcel->getActiveSheet()->setTitle('PRESUPUESTO_'.$_GET["ejercicio"]);
    // Initialise the Excel row number
    $rowCount = 2;
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'SOLICITUD')
    ->setCellValue('B1', 'ORDEN DE PAGO')
    ->setCellValue('C1', 'MONTO')
    ->setCellValue('D1', 'PROVEEDOR');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

  
    $condicion ="";    
    
        
    
    /*if($_GET["co_ejecutor"]!=''){
        $condicion .= " and tb082.id = ". $_GET["co_ejecutor"];
    }
    
    if($_GET["co_aplicacion"]!=''){
        $condicion .= " and tb139.co_aplicacion = ". $_GET["co_aplicacion"];
    }*/
    
    if($_GET["co_decreto"]!=''){
        $condicion .= " and tb085.nu_fi = '". $_GET["co_decreto"]."'";
    }
    
    if($_GET["ejercicio"]!=''){
        $condicion .= " and tb085.nu_anio = '". $_GET["ejercicio"]."'";
    }
    

    $conex = new ConexionComun();

           
        $sql = "SELECT tb053.co_detalle_compras,tb052.co_solicitud,tx_serial,tb053.monto,tx_razon_social
                  FROM public.tb085_presupuesto tb085 join tb053_detalle_compras tb053
                             on (tb053.co_presupuesto = tb085.id) join tb052_compras tb052
                             on (tb052.co_compras = tb053.co_compras) join tb060_orden_pago tb060
                             on (tb060.co_solicitud = tb052.co_solicitud) join tb026_solicitud tb026
                             on (tb026.co_solicitud = tb060.co_solicitud) join tb008_proveedor tb008
                             on (tb008.co_proveedor = tb026.co_proveedor)
                 WHERE length(nu_partida)=17 and tb060.in_anulado = false  $condicion";
     //echo $sql; exit();
    $retencion = $conex->ObtenerFilasBySqlSelect($sql);

    //var_dump($sql); exit();
    $rowCount = 2;

    foreach ($retencion as $key => $value) {
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['co_solicitud'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['tx_serial'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['tx_razon_social'], PHPExcel_Cell_DataType::TYPE_STRING);
        // Increment the Excel row counter
        $rowCount++;
    }

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="presupuesto_analitico_'.$_GET["ejercicio"].'_'.date("d-m-Y").'.xlsx"');
    $objWriter->save('php://output');

?>