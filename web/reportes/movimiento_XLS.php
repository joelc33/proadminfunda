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
    $objPHPExcel->getActiveSheet()->setTitle('MOVIMIENTOS');
    // Initialise the Excel row number
    $rowCount = 2;
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn



    $conex = new ConexionComun();
    
    if($_GET['tipo']==7 ||$_GET['tipo']==8){
        
        if($_GET['tipo']==7){
            $tipo = 2;
        }else{
          $tipo = 1; 
        }
        
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Solicitud')
    ->setCellValue('B1', 'Monto')
    ->setCellValue('C1', 'Fecha')
    ->setCellValue('D1', 'Nro')
    ->setCellValue('E1', 'Descripcion');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);        
        
                $sql = "SELECT DISTINCT tb097.mo_distribucion as nu_monto, 
        tb096.nu_modificacion,
        tb096.de_modificacion, cast(tb096.created_at as date) as created_at, 
        tb096.co_solicitud, tb097.id
        FROM tb097_modificacion_detalle tb097
        INNER JOIN tb096_presupuesto_modificacion tb096 ON (tb096.id=tb097.id_tb096_presupuesto_modificacion) 
        WHERE tb097.id_tb085_presupuesto=".$_GET['partida']."
        AND tb097.id_tb098_tipo_distribucion=".$tipo." and
        tb097.in_anular is null
        ORDER BY tb097.id 
        ASC;";
                
                
     //echo $sql; exit();
    $retencion = $conex->ObtenerFilasBySqlSelect($sql);

    //var_dump($sql); exit();
    $rowCount = 2;

    foreach ($retencion as $key => $value) {
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['co_solicitud'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['nu_monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['created_at'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['nu_modificacion'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value['de_modificacion'], PHPExcel_Cell_DataType::TYPE_STRING);
        // Increment the Excel row counter
        $rowCount++;
    }                
                
        
    }else{
        
        
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Solicitud')
    ->setCellValue('B1', 'Monto')
    ->setCellValue('C1', 'Fecha')
    ->setCellValue('D1', 'Orden de Pago')
    ->setCellValue('E1', 'RIF')
    ->setCellValue('F1', 'Razon Social');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);        
   
        $sql = "SELECT DISTINCT tb087_presupuesto_movimiento.CO_DETALLE_COMPRA, 
        tb087_presupuesto_movimiento.NU_MONTO, tb060_orden_pago.TX_SERIAL, 
        tb052_compras.CO_SOLICITUD, cast(tb087_presupuesto_movimiento.CREATED_AT as date) as created_at, 
        tb008_proveedor.TX_RAZON_SOCIAL, tb008_proveedor.TX_RIF, tb007_documento.INICIAL 
        FROM tb085_presupuesto 
        INNER JOIN tb087_presupuesto_movimiento ON (tb085_presupuesto.ID=tb087_presupuesto_movimiento.CO_PARTIDA) 
        LEFT JOIN tb053_detalle_compras ON (tb087_presupuesto_movimiento.CO_DETALLE_COMPRA=tb053_detalle_compras.CO_DETALLE_COMPRAS) 
        LEFT JOIN tb052_compras ON (tb053_detalle_compras.CO_COMPRAS=tb052_compras.CO_COMPRAS) 
        LEFT JOIN tb060_orden_pago ON (tb052_compras.CO_SOLICITUD=tb060_orden_pago.CO_SOLICITUD) 
        LEFT JOIN tb026_solicitud ON (tb060_orden_pago.CO_SOLICITUD=tb026_solicitud.CO_SOLICITUD) 
        LEFT JOIN tb008_proveedor ON (tb026_solicitud.CO_PROVEEDOR=tb008_proveedor.CO_PROVEEDOR) 
        LEFT JOIN tb007_documento ON (tb008_proveedor.CO_DOCUMENTO=tb007_documento.CO_DOCUMENTO) 
        WHERE tb087_presupuesto_movimiento.CO_PARTIDA=".$_GET['partida']."
        AND tb087_presupuesto_movimiento.CO_TIPO_MOVIMIENTO=".$_GET['tipo']."
        AND tb085_presupuesto.ID=tb087_presupuesto_movimiento.CO_PARTIDA and tb087_presupuesto_movimiento.in_anular is null and tb060_orden_pago.in_anular is null
        ORDER BY tb052_compras.CO_SOLICITUD 
        ASC;";
    
        
     //echo $sql; exit();
    $retencion = $conex->ObtenerFilasBySqlSelect($sql);

    //var_dump($sql); exit();
    $rowCount = 2;

    foreach ($retencion as $key => $value) {
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['co_solicitud'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['nu_monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['created_at'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['tx_serial'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value['inicial'].'-'.$value['tx_rif'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value['tx_razon_social'], PHPExcel_Cell_DataType::TYPE_STRING);
        // Increment the Excel row counter
        $rowCount++;
    }
    }
    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="movimiento_'.date("d-m-Y").'.xlsx"');
    $objWriter->save('php://output');

?>