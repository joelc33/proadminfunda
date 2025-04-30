<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Katherine Ruiz");
    $objPHPExcel->getProperties()->setTitle("Relación de Ordenes de Compra/Servicios/Contratos");
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
    $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->setTitle('RELACION ORDENES DE PAGO');

    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn
   
    
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', '')
    ->setCellValue('B1', '')
    ->setCellValue('C1', '')
    ->setCellValue('D1', '')
    ->setCellValue('E1', '')
    ->setCellValue('F1', 'RELACION ORDENES DE COMPRA/SERVICIOS/CONTRATOS DEL  '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))    
    ->setCellValue('G1', '')
    ->setCellValue('H1', '')
    ->setCellValue('I1', '')
    ->setCellValue('J1', '')
    ->setCellValue('K1', '');
    
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A2', 'Solicitud ')
    ->setCellValue('B2', 'Orden de Compra/Servicio/Contrato')
    ->setCellValue('C2', 'Rif')
    ->setCellValue('D2', 'Razon Social')
    ->setCellValue('E2', 'Fecha')
    ->setCellValue('F2', 'Estatus')            
    ->setCellValue('G2', 'Monto');        

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A2:L2')->getFont()->setBold(true);  
    
    $conex = new ConexionComun();
    $condicion ="";

    $nu_codigo = $_GET['nu_codigo'];
    if ($_GET["co_tipo"]) $tipo  = $_GET['co_tipo'];  
    else $tipo  = '';

    list($dia,$mes,$anio) = explode("-",$_GET["fe_inicio"]);
    $fe_inicio = $anio.'-'.$mes."-".$dia;

    list($dia,$mes,$anio) = explode("-",$_GET["fe_fin"]);
    $fe_fin = $anio.'-'.$mes."-".$dia;
     
    $condicion .= " tb060.fe_emision >= '".$fe_inicio."' and ";
    $condicion .= " tb060.fe_emision <= '".$fe_fin."' ";
    if ($_GET["nu_codigo"]) $condicion .= " and tb008.nu_codigo like '".$nu_codigo."'";
    if ($tipo=='APROBADAS') $condicion .= " and tb060.in_anulado = FALSE ";        
    if ($tipo=='ANULADAS')  $condicion .= " and tb060.in_anulado = TRUE ";     
    
    $sql = " select distinct tb060.co_solicitud, tb008.nu_codigo
            ,tb060.tx_serial
            ,tb008.tx_rif
            ,tb008.tx_razon_social
            ,tb060.created_at as fecha
            ,case when tb060.in_anulado = true then 'Anulada' else case when tb060.in_pagado = true then 'Aprobada' else 'Pendiente' end end as estatus
            ,tb060.mo_total as monto
            ,(select COALESCE(sum(mo_retencion),0.00) from tb046_factura_retencion where co_odp = tb060.co_orden_pago) as deducido
            ,0.00 as desafectado
            ,(select COALESCE(sum(mo_pagado),0.00) from tb062_liquidacion_pago where co_odp = tb060.co_orden_pago) as cancelado
            ,tb063.fe_pago            
            from tb060_orden_pago tb060
            left join tb026_solicitud tb026 on tb060.co_solicitud = tb026.co_solicitud
            left join tb008_proveedor tb008 on tb026.co_proveedor = tb008.co_proveedor
            left join tb062_liquidacion_pago tb062 on tb060.co_orden_pago = tb062.co_odp
            left join tb063_pago tb063 on tb062.co_liquidacion_pago = tb063.co_liquidacion_pago
             where tb060.tx_serial<>'' and tb026.co_tipo_solicitud in (1,2,70) and ".$condicion." order by 
             tb060.tx_serial 
             asc";         
           
   //  echo var_dump($sql); exit();  
    $Movimientos = $conex->ObtenerFilasBySqlSelect($sql);

    $rowCount = 3;

    foreach ($Movimientos as $key => $value) {
        
        $saldo = $value['monto'] - $value['deducido'] -  $value['cancelado'];
                
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['co_solicitud'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['tx_serial'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['tx_rif'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['tx_razon_social'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value['fecha'], PHPExcel_Cell_DataType::TYPE_STRING);        
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $value['estatus'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $value['monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
       /* $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $value['deducido'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $value['desafectado'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $value['cancelado'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $saldo, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $value['fecha'], PHPExcel_Cell_DataType::TYPE_STRING);*/
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