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
    $objPHPExcel->getActiveSheet()->setTitle('RETENCIONES_IVA');
    // Initialise the Excel row number
    $rowCount = 2;
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'RIF_GOB')
    ->setCellValue('B1', 'PER_IMP')
    ->setCellValue('C1', 'FEC_DOC')
    ->setCellValue('D1', 'COMPRA')
    ->setCellValue('E1', 'FACTURA')
    ->setCellValue('F1', 'RIF_PROV')
    ->setCellValue('G1', 'DEN_PRO')
    ->setCellValue('H1', 'NRO_DCTO')
    ->setCellValue('I1', 'NRO_CONT')
    ->setCellValue('J1', 'MON_FACT')
    ->setCellValue('K1', 'BASE_IMP')
    ->setCellValue('L1', 'MONT_IVA')
    ->setCellValue('M1', 'DCTO_AF')
    ->setCellValue('N1', 'NRO_COM')
    ->setCellValue('O1', 'MONT_EX')
    ->setCellValue('P1', 'ALICUOTA')
    ->setCellValue('Q1', 'NRO_EXP');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setBold(true);

    $condicion ="";    
    $condicion .= " tb063.fe_pago >= '". $_GET["fe_inicio"]."' and ";
    $condicion .= " tb063.fe_pago <= '".$_GET["fe_fin"]."' ";

    $conex = new ConexionComun();

    $sql = "SELECT 'G200036524'::text as rif_gob, to_char(tb063.fe_pago, 'YYYYMM') as per_imp, tb045.fe_emision as fec_doc, 'C'::text as compra, '01'::text as factura, 
    inicial||tx_rif as rif_prov, 
    tx_razon_social as den_pro, nu_factura as nro_dcto, 
    nu_control as nro_cont, nu_total as mont_fact, nu_base_imponible as base_imp, nu_iva_retencion as mont_iva, 
    to_char(tb063.fe_pago, 'YYYYMM')||lpad((tb045.co_solicitud)::text, 8, '0')::text as nro_com, 0 as dcto_af, 0 as mont_ex, co_iva_factura as alicuota, 0 as nro_exp
      FROM tb045_factura as tb045
      inner join tb008_proveedor as tb008 on tb008.co_proveedor = tb045.co_proveedor
      inner join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
      inner join tb060_orden_pago as tb060 ON tb060.co_orden_pago = tb045.co_odp
      inner join tb062_liquidacion_pago as tb062 ON tb062.co_odp = tb060.co_orden_pago
      inner join tb063_pago as tb063 ON tb063.co_liquidacion_pago = tb062.co_liquidacion_pago      
      where tb045.in_anular is not true and tb060.in_anular is not true and tb060.in_anulado is not true and ".$condicion."
      order by tb063.fe_pago ASC;";                 
     
    $retencion = $conex->ObtenerFilasBySqlSelect($sql);

    //var_dump($retencion); exit();
    $rowCount = 2;

    foreach ($retencion as $key => $value) {
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value['rif_gob']);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['per_imp'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value['fec_doc']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value['compra']);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value['factura'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $value['rif_prov'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $value['den_pro'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $value['nro_dcto'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $value['nro_cont'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $value['mont_fact']);
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $value['base_imp']);
        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $value['mont_iva']);
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $value['dcto_af']);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('N'.$rowCount, $value['nro_com'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $value['mont_ex']);
        $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $value['alicuota']);
        $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $value['nro_exp']);
        // Increment the Excel row counter
        $rowCount++;
    }

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="retencion_iva_'.date("H:i:s").'.xlsx"');
    $objWriter->save('php://output');

?>