<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Yoser Perez");
    $objPHPExcel->getProperties()->setTitle("Listado de Retenciones");
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
    ->setCellValue('A1', 'Tipo de Nomina')
    ->setCellValue('B1', 'Serial de la Nomina')
    ->setCellValue('C1', 'Monto Aporte')
    ->setCellValue('D1', 'Tipo de Aporte')
    ->setCellValue('E1', 'Solicitud')
    ->setCellValue('F1', 'Fecha de Aporte');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

  
    $condicion ="";  

    $conex = new ConexionComun();

        if($_GET["tx_concepto"]!=''){
            $movimiento = "'".$_GET["tx_concepto"]."'";
        }
        else{
            $movimiento = "'904', '980', '983', '985'";
        }
           
        $sql = "SELECT tx_tipo_nomina, tx_serial_nomina, mo_aporte, tx_tipo_aporte,    
tb159_aporte_patronal_nomina.co_solicitud, fe_aporte
  FROM tb159_aporte_patronal_nomina
  inner join tb026_solicitud as tb026 on
tb159_aporte_patronal_nomina.co_solicitud = tb026.co_solicitud
   where tx_tipo_aporte in (".$movimiento.") and fe_aporte BETWEEN  '".$_GET["fe_inicio"]."' AND '".$_GET["fe_fin"]."' and co_estatus in (1,2,3) and  co_tipo_solicitud <> 36
                 order by fe_aporte;";
    // echo $sql; exit();
    $retencion = $conex->ObtenerFilasBySqlSelect($sql);

    //var_dump($sql); exit();
    $rowCount = 2;

    foreach ($retencion as $key => $value) {
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['tx_tipo_nomina'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['tx_serial_nomina'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['mo_aporte'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['tx_tipo_aporte'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value['co_solicitud'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value['fe_aporte'], PHPExcel_Cell_DataType::TYPE_STRING);
        // Increment the Excel row counter
        $rowCount++;
    }

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="aporte_patronal'.$_GET["ejercicio"].'_'.date("d-m-Y").'.xlsx"');
    $objWriter->save('php://output');

?>