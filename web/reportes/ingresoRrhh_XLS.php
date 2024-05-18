<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Cristian Garcia");
    $objPHPExcel->getProperties()->setTitle("Ingresos RRHH");
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
    $objPHPExcel->getActiveSheet()->setTitle('Ingresos RRHH');

    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn
   
    
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', '')
    ->setCellValue('B1', '')
    ->setCellValue('C1', '')
    ->setCellValue('D1', '')
    ->setCellValue('E1', '')
    ->setCellValue('F1', 'INGRESOS DEL  '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))    
    ->setCellValue('G1', '')
    ->setCellValue('H1', '')
    ->setCellValue('I1', '')
    ->setCellValue('J1', '')
    ->setCellValue('K1', '');
    
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A2', 'N')
    ->setCellValue('B2', 'Nombre')
    ->setCellValue('C2', 'Apellido')
    ->setCellValue('D2', 'Cedula de Identidad')
    ->setCellValue('E2', 'Ubicacion')
    ->setCellValue('F2', 'Nomina')            
    ->setCellValue('G2', 'Codigo')
    ->setCellValue('H2', 'Cargo')
    ->setCellValue('I2', 'Sueldo')
    ->setCellValue('J2', 'Fecha de Tramite')
    ->setCellValue('K2', 'Fecha de Ingreso');            
     

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A2:L2')->getFont()->setBold(true);  
    
    $conex = new ConexionComun();
    $condicion ="";
 if($_GET["co_tipo"]==1){
        $condicion .= " tbrh015_nom_trabajador.fe_ingreso >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tbrh015_nom_trabajador.fe_ingreso <= '".$_GET["fe_fin"]."' ";
        $condicion2 .= "tbrh015_nom_trabajador.fe_ingreso";
        }else if($_GET["co_tipo"]==2){
        $condicion .= " tbrh105_ingreso_trabajador.created_at >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tbrh105_ingreso_trabajador.created_at <= '".$_GET["fe_fin"]."' ";
        $condicion2 .= "tbrh105_ingreso_trabajador.created_at";
        } 
    
    $sql = " 
select nb_primer_nombre, nb_primer_apellido, nu_cedula,tx_dependecia, tx_tp_nomina, tx_grupo_nomina, tx_cargo, mo_salario_base, tbrh015_nom_trabajador.fe_ingreso, tbrh002_ficha.fe_ingreso AS ficha_ingreso

from tbrh001_trabajador, tbrh002_ficha, tbrh015_nom_trabajador, tbrh009_cargo_estructura, tbrh005_estructura_administrativa, tbrh003_dependencia,tbrh017_tp_nomina, tbrh067_grupo_nomina, tbrh032_cargo, tbrh105_ingreso_trabajador


where 
tbrh001_trabajador.co_trabajador = tbrh002_ficha.co_trabajador and
tbrh002_ficha.co_ficha =  tbrh015_nom_trabajador.co_ficha and
tbrh015_nom_trabajador.co_cargo_estructura = tbrh009_cargo_estructura.co_cargo_estructura and 
tbrh009_cargo_estructura.co_estructura_administrativa = tbrh005_estructura_administrativa.co_estructura_administrativa and
tbrh005_estructura_administrativa.co_ente = tbrh003_dependencia.co_dependencia and
tbrh015_nom_trabajador.co_tp_nomina = tbrh017_tp_nomina.co_tp_nomina and
tbrh015_nom_trabajador.co_grupo_nomina = tbrh067_grupo_nomina.co_grupo_nomina and
tbrh009_cargo_estructura.co_cargo = tbrh032_cargo.co_cargo and 
tbrh105_ingreso_trabajador.co_ficha = tbrh002_ficha.co_ficha and 
tbrh105_ingreso_trabajador.in_procesada = true and
tbrh105_ingreso_trabajador.in_delete IS NOT TRUE and
tbrh015_nom_trabajador.in_activo = true and
".$condicion.'order by '.$condicion2;         
           
    // echo var_dump($sql); exit();  
    $Movimientos = $conex->ObtenerFilasBySqlSelect($sql);

    $rowCount = 3;
    $numero=1;
    foreach ($Movimientos as $key => $value) {
        
       
                
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $numero, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['nb_primer_nombre'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['nb_primer_apellido'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['nu_cedula'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value['tx_dependecia'], PHPExcel_Cell_DataType::TYPE_STRING);        
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $value['tx_tp_nomina'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $value['tx_grupo_nomina'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $value['tx_cargo'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $value['mo_salario_base'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $value['fe_ingreso'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $value['ficha_ingreso'], PHPExcel_Cell_DataType::TYPE_STRING);
     
        // Increment the Excel row counter
        $rowCount++;
        $numero=$numero+1;
    }

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="Ingresos_'.date("d-m-Y").'.xlsx"');
    $objWriter->save('php://output');

?>