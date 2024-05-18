<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Yoser Perez");
    $objPHPExcel->getProperties()->setTitle("Reporte de la ejecución presupuestaria por Aplicacion");
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
    $objPHPExcel->getActiveSheet()->setTitle('PRESUPUESTO_APLICACION'.$_GET["ejercicio"]);
    // Initialise the Excel row number
    $rowCount = 8;
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn
    
    $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '<NOMBRE DE LA INSTITUCION>');

    $objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(false);
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', '')
                ->setCellValue('A3', '')
                ->setCellValue('A3', '[FPRERB89]')
                ->setCellValue('I4', 'Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y"));

    $objPHPExcel->getActiveSheet()->mergeCells("A6:J6");
    $objPHPExcel->getActiveSheet()->mergeCells("I4:J4");
    $objPHPExcel->getActiveSheet()->getStyle("A6:J6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A6:J6')->getFont()->setBold(true);
    
    $objPHPExcel->getActiveSheet()->getStyle('A7:J7')->getFont()->setBold(true);    
    $objPHPExcel->getActiveSheet()
        ->getStyle('A7:J7')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('9c9c9c');
    
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A6', 'RESUMEN DE EJECUCIÓN PRESUPUESTARIA POR APLICACIÓN AL '.$_GET['fe_inicio']);
   

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A7', 'Aplic. Denominación')
    ->setCellValue('B7', 'Monto Ley')
    ->setCellValue('C7', 'Aumentos')
    ->setCellValue('D7', 'Disminuciones')
    ->setCellValue('E7', 'Modificado')
    ->setCellValue('F7', 'Aprobado')
    ->setCellValue('G7', 'Comprometido_dia')
    ->setCellValue('H7', 'Causado_dia')
    ->setCellValue('I7', 'Pagado_dia')
    ->setCellValue('J7', 'Disponibilidad');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A7:J7')->getFont()->setBold(true);    

    $conex = new ConexionComun();

    /*value tipo DATE */
    list($dia_ini, $mes_ini, $anio_ini) = explode("-", $_GET['fe_inicio']);
    $fecha_ini = $anio_ini."-".$mes_ini."-".$dia_ini;

    list($dia_fin, $mes_fin, $anio_fin) = explode("-", $_GET['fe_inicio']);
    $fecha_fin = $anio_fin."-".$mes_fin."-".$dia_fin;
           
$sql = "SELECT co_aplicacion, nu_anio_fiscal, tx_tip_aplicacion,tx_aplicacion,(tx_tip_aplicacion ||'-'|| tx_aplicacion) as aplicacion,

        (SELECT sum(mo_inicial) as mo_ley
            FROM tb085_presupuesto 
            WHERE nu_anio = nu_anio_fiscal
            AND tip_apl = tx_tip_aplicacion),

         (SELECT sum(mo_distribucion) as mo_aumento
			FROM tb097_modificacion_detalle as tb097
			INNER JOIN tb085_presupuesto as tb085 on tb097.id_tb085_presupuesto = tb085.id
		        INNER JOIN tb096_presupuesto_modificacion tb096 on tb096.id = tb097.id_tb096_presupuesto_modificacion
		WHERE tb085.nu_anio = nu_anio_fiscal
			AND tb097.id_tb098_tipo_distribucion = 2
			AND tb085.tip_apl = tx_tip_aplicacion
			AND  tb097.IN_ANULAR IS NULL
			AND cast(tb096.fe_modificacion as date)  between '".$anio_fin."-01-01'::date AND '".$fecha_ini."'),


         (SELECT sum(mo_distribucion) as mo_disminucion
			FROM tb097_modificacion_detalle as tb097
			INNER JOIN tb085_presupuesto as tb085 on tb097.id_tb085_presupuesto = tb085.id
		        INNER JOIN tb096_presupuesto_modificacion tb096 on tb096.id = tb097.id_tb096_presupuesto_modificacion
		WHERE tb085.nu_anio = nu_anio_fiscal
			AND tb097.id_tb098_tipo_distribucion = 1
			AND tb085.tip_apl = tx_tip_aplicacion
			AND  tb097.IN_ANULAR IS NULL
			AND cast(tb096.fe_modificacion as date)  between '".$anio_fin."-01-01'::date AND '".$fecha_ini."'),

            (SELECT sum(nu_monto) as mo_comprometido
					FROM tb087_presupuesto_movimiento as tb087
					INNER JOIN tb085_presupuesto as tb085 on tb087.co_partida = tb085.id
					WHERE tb085.nu_anio = nu_anio_fiscal
					AND tb087.co_tipo_movimiento = 1
					AND tb085.tip_apl = tx_tip_aplicacion
					AND  IN_ANULAR IS NULL
					AND tb087.created_at::date between '".$anio_fin."-01-01'::date AND '".$fecha_ini."'),

            (SELECT sum(nu_monto) as mo_causado
					FROM tb087_presupuesto_movimiento as tb087
					INNER JOIN tb085_presupuesto as tb085 on tb087.co_partida = tb085.id
					WHERE tb085.nu_anio = nu_anio_fiscal
					AND tb087.co_tipo_movimiento = 2
					AND tb085.tip_apl = tx_tip_aplicacion
					AND  IN_ANULAR IS NULL
					AND tb087.created_at::date between '".$anio_fin."-01-01'::date AND '".$fecha_ini."'),

            (SELECT sum(nu_monto) as mo_pagado
					FROM tb087_presupuesto_movimiento as tb087
					INNER JOIN tb085_presupuesto as tb085 on tb087.co_partida = tb085.id
					WHERE tb085.nu_anio = nu_anio_fiscal
					AND tb087.co_tipo_movimiento = 3
					AND tb085.tip_apl = tx_tip_aplicacion
					AND  IN_ANULAR IS NULL
					AND tb087.created_at::date between '".$anio_fin."-01-01'::date AND '".$fecha_ini."')



        from tb139_aplicacion as tba where nu_anio_fiscal = ".$anio_ini."  and co_aplicacion in (
            SELECT tb085.id_tb139_aplicacion
             FROM tb085_presupuesto as tb085
             WHERE tb085.nu_anio = $anio_ini
             group by 1 order by 1 asc
            ) order by tx_tip_aplicacion ASC;
";
     //echo $sql; exit();
    $retencion = $conex->ObtenerFilasBySqlSelect($sql);

    //var_dump($sql); exit();
    $rowCount = 8;

    foreach ($retencion as $key => $value) {

         /********************************************************************************************************/        
         /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
         /********************************************************************************************************/
            $monto_incremento      = $value['mo_aumento'];       
            $monto_disminucion     = $value['mo_disminucion'];                   
            $monto_comp            = $value['mo_comprometido'];          
            $monto_modificado      = $value['mo_aumento']-$value['mo_disminucion'];  //correcta              
            $monto_causado         = $value['mo_causado'];  
            $monto_pagado          = $value['mo_pagado'];  
            $aprobado              = $monto_modificado + $value['mo_ley'];      //correcto    
            $monto_disponible      = $value['mo_ley']+$monto_modificado-$value['mo_comprometido'];  //correcto
         /********************************************************************************************************/
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)

     
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['aplicacion'], PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['mo_ley'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $monto_incremento, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $monto_disminucion, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $monto_modificado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $aprobado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $monto_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $monto_causado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $monto_pagado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $monto_disponible, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            // Increment the Excel row counter
            $rowCount++;
        
        
    }

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="presupuesto_aplicacion_'.$_GET["ejercicio"].'_'.date("d-m-Y").'.xlsx"');
    $objWriter->save('php://output');

?>