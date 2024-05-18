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
    $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("N")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->setTitle('RETENCIONES_ISLR');
    // Initialise the Excel row number
    $rowCount = 2;
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'RIFRETENID')
    ->setCellValue('B1', 'NUMEROFACT')
    ->setCellValue('C1', 'NUMEROCONT')
    ->setCellValue('D1', 'FECHAOPERA')
    ->setCellValue('E1', 'CODIGOCONC')
    ->setCellValue('F1', 'MONTOOPERA')
    ->setCellValue('G1', 'PORCENTAJE');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

    /*$condicion ="";    
    $condicion .= " fe_emision >= '". $_GET["fe_inicio"]."' and ";
    $condicion .= " fe_emision <= '".$_GET["fe_fin"]."' ";*/

    $condicion ="";    
    $condicion .= " tb063.fe_pago >= '". $_GET["fe_inicio"]."' and ";
    $condicion .= " tb063.fe_pago <= '".$_GET["fe_fin"]."' ";

    $conex = new ConexionComun();

    /*$sql = "SELECT inicial||tx_rif as rifretenid, 
        nu_factura as numerofact, 
        nu_control as numerocont, to_char(fe_emision, 'DD/MM/YYYY') as fechaopera, '055'::text as codigoconc,
        nu_base_imponible as montoopera, po_retencion as porcentaje
        FROM tb046_factura_retencion as tb046
        inner join tb041_tipo_retencion as tb041 on tb046.co_tipo_retencion = tb041.co_tipo_retencion
        inner join tb045_factura as tb045 on tb046.co_factura = tb045.co_factura
        inner join tb008_proveedor as tb008 on tb008.co_proveedor = tb045.co_proveedor
        inner join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
        where tb046.co_tipo_retencion = 4 and ".$condicion."
        order by rifretenid ASC, fe_emision ASC limit 52;";*/
        
        $sql = "SELECT inicial||tx_rif as rifretenid, tx_razon_social, tb060.tx_serial, nu_total, nu_base_imponible, '055' as concepto,
        nu_factura as numerofact, 
        nu_control as numerocont, to_char(tb063.fe_pago, 'DD/MM/YYYY') as fechaopera, '055'::text as codigoconc,
        nu_base_imponible as montoopera, po_retencion as porcentaje
        FROM tb046_factura_retencion as tb046
        inner join tb041_tipo_retencion as tb041 on tb046.co_tipo_retencion = tb041.co_tipo_retencion
        inner join tb045_factura as tb045 on tb046.co_factura = tb045.co_factura
        inner join tb008_proveedor as tb008 on tb008.co_proveedor = tb045.co_proveedor
        inner join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
        left join tb060_orden_pago as tb060 on tb046.co_solicitud = tb060.co_solicitud
        inner join tb062_liquidacion_pago as tb062 ON tb062.co_odp = tb060.co_orden_pago
        inner join tb063_pago as tb063 ON tb063.co_liquidacion_pago = tb062.co_liquidacion_pago 
        where tb046.co_tipo_retencion = 4 AND tb060.in_anular is null AND ".$condicion."
        order by tb063.fe_pago ASC;";
     
    $retencion = $conex->ObtenerFilasBySqlSelect($sql);

    //var_dump($sql); exit();
    $rowCount = 2;

    foreach ($retencion as $key => $value) {
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['rifretenid'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['numerofact'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['numerocont'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['fechaopera'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value['codigoconc'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value['montoopera']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value['porcentaje']);
        // Increment the Excel row counter
        $rowCount++;
    }

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="retencion_islr_'.date("H:i:s").'.xlsx"');
    $objWriter->save('php://output');

?>