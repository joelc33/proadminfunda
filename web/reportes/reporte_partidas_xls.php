<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Joel Camarillo");
    $objPHPExcel->getProperties()->setTitle("Listado de Ordenador");
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
    $objPHPExcel->getActiveSheet()->setTitle('Listado de Ordenador');
    // Initialise the Excel row number
    
        $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', '<NOMBRE DE LA INSTITUCION>');

        $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(false);
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A2', 'SECRETARIA DE ADMINISTRACIÓN Y FINANZAS')
                    ->setCellValue('A3', 'SubSecretaria de Presupuesto')
                    ->setCellValue('A3', '[FPRERB57]')
                    ->setCellValue('I4', 'Fecha de Emisión '.date("d").'/'.date("m").'/'.date("Y"))
                    ->setCellValue('A5', 'PERIODO....:  '.$_GET["fe_inicio"].' hasta '.$_GET["fe_fin"]);

        $objPHPExcel->getActiveSheet()->mergeCells("A6:G6");
        $objPHPExcel->getActiveSheet()->mergeCells("I4:J4");
        $objPHPExcel->getActiveSheet()->getStyle("A6:G6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A6', 'EJECUCIÓN PRESUPUESTARIA POR PARTIDAS- AÑO FISCAL '.$_GET['co_anio_fiscal']);
   
    
        $objPHPExcel->getActiveSheet()->getStyle('A7:J7')->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A7', 'Partida')
                ->setCellValue('B7', 'Presupuestado')
                ->setCellValue('C7', 'Modificado')
                ->setCellValue('D7', 'Aprobado')
                ->setCellValue('E7', 'Comprometido')
                ->setCellValue('F7', '%COMP')
                ->setCellValue('G7', 'Causado')
                ->setCellValue('H7', '%CAU.')
                ->setCellValue('I7', 'Pagado')
                ->setCellValue('J7', '%PAG.');

         $rowCount = 8;
         
	 $lista_partidas = partidas();          
         
	 foreach($lista_partidas as $key => $campo){
           

         /********************************************************************************************************/        
         /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
         /********************************************************************************************************/
            
            $monto_comp            = $campo["mo_comprometido"];          
            $monto_modificado      = $campo["modificado"];                
            $monto_causado         = $campo["mo_causado"];            
            $monto_pagado          = $campo["mo_pagado"];     
            $aprobado              = $campo["mo_aprobado"];
            $monto_x100comp        = (($monto_comp)*100)/$aprobado ;          
            $monto_x100cau         = (($monto_causado)*100)/$aprobado ;          
            $monto_x100pag         = (($monto_pagado)*100)/$aprobado ; 
            
            
           
            
        /********************************************************************************************************/         
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J'.$rowCount)->getFont()->setBold(false);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $campo['nu_pa'].' '.$campo['de_partida'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $campo['inicial'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $monto_modificado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $aprobado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $monto_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $monto_x100comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $monto_causado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $monto_x100cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $monto_pagado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $monto_x100pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        // Increment the Excel row counter
        $rowCount++;
         
         
         
         $total       += $campo['inicial'];
         $total_mod   += $monto_modificado;
         $total_aprob += $aprobado;
         $total_comp  += $monto_comp;
         $total_cau   += $monto_causado;
         $total_pag   += $monto_pagado;       
         
         $total_monto_x100comp  = round((($total_comp)*100)/$total_aprob,2);          
         $total_monto_x100cau   = round((($total_cau)*100)/$total_aprob,2);           
         $total_monto_x100pag   = round((($total_pag)*100)/$total_aprob,2);
         
        }
                 
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J'.$rowCount)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, 'TOTAL RELACION........', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $total, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $total_mod, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $total_aprob, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $total_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $total_monto_x100comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $total_cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $total_monto_x100cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $total_pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $total_monto_x100pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        // Increment the Excel row counter
        $rowCount++;

    
   
  
    function partidas(){
        
        $condicion ="";
        $periodo    = $_GET['co_periodo']; 
        $anio       = $_GET['co_anio_fiscal'];  

        list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
        $fe_inicio = $anio.'-'.$mes.'-'.$dia;

        list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
        $fe_fin = $anio.'-'.$mes.'-'.$dia;

        $conex = new ConexionComun();     
        $sql = "select  nu_pa,
                        sum(mo_inicial) as inicial, 
                        (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) modificado,
                        sum(mo_inicial)+ (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) as mo_aprobado,
                        coalesce(sum(comprometido_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_comprometido,
                        coalesce(sum(causado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0) mo_causado,
                        coalesce(sum(pagado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,3,'$fe_inicio','$fe_fin')),0) mo_pagado
                    FROM tb085_presupuesto as tb085                     
                         where nu_anio ='$anio' and length(nu_partida) = 17 and co_partida<>''
                         group by 1 order by nu_pa asc";          


    //        echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
	
    }                        

    
   
   
    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="presupuesto_ordenador_'.date("H:i:s").'.xlsx"');
    $objWriter->save('php://output');

?>