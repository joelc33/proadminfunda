<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Cristian Garcia");
    $objPHPExcel->getProperties()->setTitle("EGRESOS RRHH");
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
    $objPHPExcel->getActiveSheet()->setTitle('EGRESOS RRHH');

    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn
   
    
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', '')
    ->setCellValue('B1', '')
    ->setCellValue('C1', '')
    ->setCellValue('D1', '')
    ->setCellValue('E1', '')
    ->setCellValue('F1', 'EGRESOS DEL  '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))    
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
    ->setCellValue('G2', 'Tipo Nomina')
    ->setCellValue('H2', 'Cargo')
    ->setCellValue('I2', 'Fecha de Movimiento')
    ->setCellValue('J2', 'Fecha de Egreso')
    ->setCellValue('K2', 'Situacion');            
     

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A2:L2')->getFont()->setBold(true);  
    
    $conex = new ConexionComun();
    $condicion ="";
 $condicion .= " tbrh099_egreso.fe_movimiento >= '". $_GET["fe_inicio"]."' and ";
$condicion .= " tbrh099_egreso.fe_movimiento <= '".$_GET["fe_fin"]."' ";
    
 $sql = "
;with cts as( 
select nb_primer_nombre, nb_segundo_nombre,nb_primer_apellido,nb_segundo_apellido, nu_cedula,tx_cargo,tx_tp_nomina, fe_movimiento, fe_egreso, tx_motivo, tx_grupo_nomina,tbrh099_egreso.co_solicitud,tbrh003_dependencia.tx_dependecia,
ROW_NUMBER() over (partition by tbrh002_ficha.co_trabajador order by tbrh002_ficha.co_ficha desc) as repetidos
from tbrh001_trabajador
INNER JOIN tbrh002_ficha ON tbrh001_trabajador.co_trabajador = tbrh002_ficha.co_trabajador
INNER JOIN tbrh015_nom_trabajador ON tbrh002_ficha.co_ficha = tbrh015_nom_trabajador.co_ficha
INNER JOIN tbrh009_cargo_estructura ON tbrh015_nom_trabajador.co_cargo_estructura = tbrh009_cargo_estructura.co_cargo_estructura
INNER JOIN tbrh032_cargo ON tbrh009_cargo_estructura.co_cargo = tbrh032_cargo.co_cargo 
INNER JOIN tbrh099_egreso ON tbrh001_trabajador.co_trabajador = tbrh099_egreso.co_trabajador
INNER JOIN tbrh017_tp_nomina ON tbrh015_nom_trabajador.co_tp_nomina = tbrh017_tp_nomina.co_tp_nomina
INNER JOIN tbrh067_grupo_nomina ON tbrh015_nom_trabajador.co_grupo_nomina = tbrh067_grupo_nomina.co_grupo_nomina
INNER JOIN tbrh005_estructura_administrativa ON tbrh009_cargo_estructura.co_estructura_administrativa = tbrh005_estructura_administrativa.co_estructura_administrativa
INNER JOIN tbrh003_dependencia ON tbrh005_estructura_administrativa.co_ente = tbrh003_dependencia.co_dependencia
WHERE 
tbrh099_egreso.co_nom_situacion = tbrh015_nom_trabajador.co_nom_situacion and ".$condicion." and 
tbrh002_ficha.in_activo = 'false'
)
select *
from cts
where repetidos = 1 order by cts.fe_egreso";        
           
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
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $value['fe_movimiento'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $value['fe_egreso'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $value['tx_motivo'], PHPExcel_Cell_DataType::TYPE_STRING);
     
        // Increment the Excel row counter
        $rowCount++;
        $numero=$numero+1;
    }

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="Egresos_'.date("d-m-Y").'.xlsx"');
    $objWriter->save('php://output');

?>