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
    ->setCellValue('A1', 'PARTIDA')
    ->setCellValue('B1', 'DESCRIPCIÓN')
    ->setCellValue('C1', 'INICIAL')
    ->setCellValue('D1', 'ACTUALIZADO')
    ->setCellValue('E1', 'COMPROMETIDO')
    ->setCellValue('F1', 'CAUSADO')
    ->setCellValue('G1', 'PAGADO')
    ->setCellValue('H1', 'DISPONIBLE');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

  
    $condicion ="";    
    
        
    
    if($_GET["co_ejecutor"]!=''){
        $condicion .= " and tb082.id = ". $_GET["co_ejecutor"];
    }
    
    if($_GET["co_proyecto"]!=''){
        $condicion .= " and tb084.id_tb083_proyecto_ac = ". $_GET["co_proyecto"];
    }
    
    if($_GET["co_accion"]!=''){
        $condicion .= " and tb085.id_tb084_accion_especifica = '". $_GET["co_accion"]."'";
    }
    
    if($_GET["ejercicio"]!=''){
        $condicion .= " and tb085.nu_anio = '". $_GET["ejercicio"]."'";
    }
    

    $conex = new ConexionComun();

           
        $sql = "SELECT  distinct tb085.id,nu_partida,substring(nu_partida,1,1)||case when substring(nu_partida,2,2) <> '' then '.' else '' end||
                        substring(nu_partida,2,2)||case when substring(nu_partida,4,2) <> '' then '.' else '' end||
                        substring(nu_partida,4,2)||case when substring(nu_partida,6,2) <> '' then '.' else '' end||
                        substring(nu_partida,6,2)||case when substring(nu_partida,8,2) <> '' then '.' else '' end||
                        substring(nu_partida,8,2)||case when substring(nu_partida,10,3) <> '' then '.' else '' end||
                        substring(nu_partida,10,3)||case when substring(nu_partida,13,5) <> '' then '.' else '' end||
                        substring(nu_partida,13,5) as nu_partida, de_partida, mo_inicial, mo_actualizado, mo_comprometido, mo_causado, mo_pagado, mo_disponible,co_categoria
                FROM public.tb085_presupuesto tb085 join tb084_accion_especifica tb084
                     on (tb085.id_tb084_accion_especifica = tb084.id)
                     join tb083_proyecto_ac tb083 on (tb084.id_tb083_proyecto_ac = tb083.id)
                     join tb082_ejecutor tb082 on (tb083.id_tb082_ejecutor = tb082.id)
                    -- join tb139_aplicacion tb139 on (tx_tip_aplicacion = tip_apl)
                WHERE nu_fi <> '' $condicion order by tb085.id;";
     //echo $sql; exit();
    $retencion = $conex->ObtenerFilasBySqlSelect($sql);

    //var_dump($sql); exit();
    $rowCount = 2;

    foreach ($retencion as $key => $value) {
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['co_categoria'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['de_partida'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['mo_inicial'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['mo_actualizado'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value['mo_comprometido'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value['mo_causado'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value['mo_pagado'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value['mo_disponible'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        // Increment the Excel row counter
        $rowCount++;
    }

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="presupuesto_'.$_GET["ejercicio"].'_'.date("d-m-Y").'.xlsx"');
    $objWriter->save('php://output');

?>