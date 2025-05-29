<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Joel Camarillo");
    $objPHPExcel->getProperties()->setTitle("Listado de Creditos Adicionales");
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
    $objPHPExcel->getActiveSheet()->setTitle('MOVIMIENTOS');
    // Initialise the Excel row number
    $rowCount = 2;
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn



    $conex = new ConexionComun();
    
            
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Solicitud')
    ->setCellValue('B1', 'Tipo de Modificación')
    ->setCellValue('C1', 'Serial')
    ->setCellValue('D1', 'Fecha')
    ->setCellValue('E1', 'Descripcion')
    ->setCellValue('F1', 'Justificacion')
    ->setCellValue('G1', 'Oficio')
    ->setCellValue('H1', 'Fecha Oficio')
    ->setCellValue('I1', 'Tipo de Credito')
    ->setCellValue('J1', 'Fuente Financiamiento')    
    ->setCellValue('K1', 'Monto');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);        
        
   
    $sql = "SELECT co_solicitud,de_tipo_modificacion,nu_modificacion,fe_modificacion,de_modificacion,de_justificacion,nu_oficio,fe_oficio,de_tipo_modificacion,tx_tipo_solicitud,de_tipo_credito,
            tx_fuente_financiamiento,sum(mo_distribucion) as monto
            FROM public.tb096_presupuesto_modificacion tb096 join tb095_tipo_modificacion tb095
                on (tb096.id_tb095_tipo_modificacion = tb095.id)  
                left join tb027_tipo_solicitud as tb027 on (tb027.co_tipo_solicitud = tb096.co_tipo_solicitud)
                left join tb152_tipo_credito as tb152 on (tb152.id = tb096.id_tb152_tipo_credito)
                left join tb073_fuente_financiamiento tb073 on (tb096.id_tb073_fuente_financiamiento = tb073.co_fuente_financiamiento)
                left join tb097_modificacion_detalle tb097 on (tb097.id_tb096_presupuesto_modificacion = tb096.id)
            where co_fuente_financiamiento = 6	and tb097.id_tb098_tipo_distribucion = 2 and fe_modificacion between '".$_GET['fe_inicio']."' and '".$_GET['fe_fin']."'
            group by co_solicitud,de_tipo_modificacion,nu_modificacion,fe_modificacion,de_modificacion,de_justificacion,nu_oficio,fe_oficio,de_tipo_modificacion,tx_tipo_solicitud,de_tipo_credito,
            tx_fuente_financiamiento
            ORDER BY tb096.fe_modificacion ASC";
                
                
    // echo $sql; exit();
    $retencion = $conex->ObtenerFilasBySqlSelect($sql);

   
    $rowCount = 2;

    foreach ($retencion as $key => $value) {
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['co_solicitud'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['de_tipo_modificacion'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['nu_modificacion'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['fe_modificacion'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value['de_modificacion'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $value['de_justificacion'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $value['nu_oficio'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $value['fe_oficio'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $value['de_tipo_credito'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $value['tx_fuente_financiamiento'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $value['monto'], PHPExcel_Cell_DataType::TYPE_STRING);

        // Increment the Excel row counter
        $rowCount++;
    }                
                
        
   
    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="movimiento_'.date("d-m-Y").'.xlsx"');
    $objWriter->save('php://output');

?>