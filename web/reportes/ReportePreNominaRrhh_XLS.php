<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Cristian Garcia");
    $objPHPExcel->getProperties()->setTitle("Pre-Nomina RRHH");
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
    $objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("N")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("O")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("P")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->setTitle('Ingresos RRHH');

    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn
   
    
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', '')
    ->setCellValue('B1', '')
    ->setCellValue('C1', '')
    ->setCellValue('D1', '')
    ->setCellValue('E1', '')
    ->setCellValue('F1', 'PRE-NOMINA DEL  '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))    
    ->setCellValue('G1', '')
    ->setCellValue('H1', '')
    ->setCellValue('I1', '')
    ->setCellValue('J1', '')
    ->setCellValue('K1', '')
    ->setCellValue('L1', '');
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A2', 'N')
    ->setCellValue('B2', 'Grupo')
    ->setCellValue('C2', 'Cedula')
    ->setCellValue('D2', 'Nombre')
    ->setCellValue('E2', 'Apellido')
    ->setCellValue('F2', 'Fecha de Ingreso')            
    ->setCellValue('G2', 'Act')
    ->setCellValue('H2', 'Fecha de Asignacion')
    ->setCellValue('I2', 'Solicitud')
    ->setCellValue('J2', 'Cuenta Bancaria')
    ->setCellValue('K2', 'Co Banco')
    ->setCellValue('L2', 'Codigo')
    ->setCellValue('M2', 'Cargo')
    ->setCellValue('N2', 'Codigo Estructura')
    ->setCellValue('O2', 'Estructura admin')
    ->setCellValue('P2', 'Salario');
    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A2:P2')->getFont()->setBold(true);  
    
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
    
    $sql = " select 
tx_grupo_nomina, nu_cedula, nb_primer_nombre, nb_primer_apellido,tbrh002_ficha.fe_ingreso AS fecha02,tbrh002_ficha.in_activo, tbrh015_nom_trabajador.fe_ingreso AS fecha015,tbrh105_ingreso_trabajador.co_solicitud,
nu_cuenta_bancaria,co_banco,tbrh032_cargo.nu_codigo AS cargo_codigo,tx_cargo,tbrh005_estructura_administrativa.nu_codigo AS estruc_codigo,
tx_nom_estructura_administrativa,mo_salario_base

from tbrh001_trabajador, tbrh015_nom_trabajador, tbrh002_ficha, tbrh067_grupo_nomina,tbrh032_cargo, tbrh009_cargo_estructura, tbrh005_estructura_administrativa, tbrh105_ingreso_trabajador


where 
tbrh067_grupo_nomina.co_grupo_nomina = tbrh015_nom_trabajador.co_grupo_nomina and
tbrh015_nom_trabajador.co_ficha = tbrh002_ficha.co_ficha and
tbrh002_ficha.co_trabajador = tbrh001_trabajador.co_trabajador and
tbrh032_cargo.co_cargo = tbrh009_cargo_estructura.co_cargo and
tbrh009_cargo_estructura.co_cargo_estructura = tbrh015_nom_trabajador.co_cargo_estructura and
tbrh009_cargo_estructura.co_estructura_administrativa = tbrh005_estructura_administrativa.co_estructura_administrativa and
tbrh002_ficha.in_activo = true and
tbrh015_nom_trabajador.in_activo = true and
tbrh105_ingreso_trabajador.in_procesada = true and
tbrh105_ingreso_trabajador.in_delete IS NOT TRUE and
tbrh105_ingreso_trabajador.co_ficha = tbrh002_ficha.co_ficha and".$condicion.'order by '.$condicion2;
           
    // echo var_dump($sql); exit();  
    $Movimientos = $conex->ObtenerFilasBySqlSelect($sql);

    $rowCount = 3;
    $numero=1;
    foreach ($Movimientos as $key => $value) {
        
       
                
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $numero, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['tx_grupo_nomina'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['nu_cedula'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['nb_primer_nombre'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value['nb_primer_apellido'], PHPExcel_Cell_DataType::TYPE_STRING);        
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $value['fecha02'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $value['in_activo'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $value['fecha015'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $value['co_solicitud'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $value['nu_cuenta_bancaria'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $value['co_banco'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $value['cargo_codigo'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('M'.$rowCount, $value['tx_cargo'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('N'.$rowCount, $value['estruc_codigo'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('O'.$rowCount, $value['tx_nom_estructura_administrativa'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('P'.$rowCount, $value['mo_salario_base'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        // Increment the Excel row counter
        $rowCount++;
        $numero=$numero+1;
    }

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="Pre-Nomina_'.date("d-m-Y").'.xlsx"');
    $objWriter->save('php://output');

?>