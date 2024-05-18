<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Joel Camarillo");
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
  //  $objPHPExcel->getActiveSheet()->setTitle('PRESUPUESTO_'.$_GET["ejercicio"]);
    // Initialise the Excel row number
    $rowCount = 2;
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Solicitud')
    ->setCellValue('B1', 'Fecha de Emisión')
    ->setCellValue('C1', 'Serial')
    ->setCellValue('D1', 'RIF')
    ->setCellValue('E1', 'Razón Social')
    ->setCellValue('F1', 'Monto ODP')
    ->setCellValue('G1', 'Partida')
    ->setCellValue('H1', 'Monto');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

  
    $condicion ="";  

    $conex = new ConexionComun();

       //BETWEEN  '".$_GET["fe_inicio"]."' AND '".$_GET["fe_fin"]."'
           
        $sql = "SELECT tb026.co_solicitud, fe_emision, tx_serial, tb007.inicial||'-'||tb008.tx_rif as identificacion, tb008.tx_razon_social,tb060.mo_total, tb085.nu_pa,sum(tb053.monto) as monto
    FROM public.tb060_orden_pago tb060 join tb026_solicitud tb026 
         on (tb060.co_solicitud = tb026.co_solicitud) join tb052_compras tb052
         on (tb052.co_solicitud = tb026.co_solicitud) join tb053_detalle_compras tb053
         on (tb053.co_compras = tb052.co_compras) join tb085_presupuesto tb085
         on (tb085.id = tb053.co_presupuesto) join tb008_proveedor tb008
         on (tb008.co_proveedor = tb026.co_proveedor) join tb007_documento tb007
         on (tb007.co_documento = tb008.co_documento)
    where tb060.fe_emision BETWEEN  '".$_GET["fe_inicio"]."' AND '".$_GET["fe_fin"]."' and tb026.co_estatus <> 4  and tb052.in_anulado = false 
    group by tb026.co_solicitud, tb007.inicial,tb008.tx_rif,tb008.tx_razon_social, fe_emision, tx_serial, tb060.mo_total, tb085.nu_pa
    order by tb026.co_solicitud";
    // echo $sql; exit();
    $retencion = $conex->ObtenerFilasBySqlSelect($sql);

    //var_dump($sql); exit();
    $rowCount = 2;

    foreach ($retencion as $key => $value) {
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['co_solicitud'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['fe_emision'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['tx_serial'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['identificacion'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value['tx_razon_social'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value['mo_total'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value['nu_pa'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value['monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        // Increment the Excel row counter
        $rowCount++;
    }

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="relacion_odp_partida.xlsx"');
    $objWriter->save('php://output');

?>