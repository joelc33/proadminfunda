<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Joel Camarillo");
    $objPHPExcel->getProperties()->setTitle("Listado de Gastos");
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
    $objPHPExcel->getActiveSheet()->setTitle('Listado de Gastos');
    // Initialise the Excel row number
    $rowCount = 8;
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn
    
    /*
     *  $this->Row(array('Organo Ordenador','Presupuestado',
     * 'Modificado','Aprobado','Comprometido','%Comp','Causado','%Cau','Pagado',
     * '%Pag.'),0,0);

     */
    
    $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '<NOMBRE DE LA INSTITUCION>');
    
    $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(false);
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'SECRETARIA DE ADMINISTRACIÓN Y FINANZAS')
                ->setCellValue('A3', 'SubSecretaria de Presupuesto')
                ->setCellValue('A3', '[FPRERB93]')
                ->setCellValue('I4', 'Fecha de Emisión, '.date("d").'/'.date("m").'/'.date("Y"))
                ->setCellValue('A5', 'PERIODO....:  '.$_GET["fe_inicio"].' hasta '.$_GET["fe_fin"]);
   
    $objPHPExcel->getActiveSheet()->mergeCells("A6:J6");
    $objPHPExcel->getActiveSheet()->mergeCells("I4:J4");
    $objPHPExcel->getActiveSheet()->getStyle("A6:J6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A6:J6')->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A6', 'RESUMEN DE EJECUCIÓN PRESUPUESTARIA DE EGRESOS POR AMBITO - - AÑO FISCAL'.$_GET['co_anio_fiscal']);

    $objPHPExcel->getActiveSheet()->getStyle('A7:J7')->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A7', 'Ambito')
    ->setCellValue('B7', 'Presupuestado')
    ->setCellValue('C7', 'Modificado')
    ->setCellValue('D7', 'Aprobado')
    ->setCellValue('E7', 'Comprometido')
    ->setCellValue('F7', '%Comp')
    ->setCellValue('G7', 'Causado')
    ->setCellValue('H7', '%Cau')
    ->setCellValue('I7', 'Pagado')
    ->setCellValue('J7', 'Pagado');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A8:J8')->getFont()->setBold(false);

    $lista_partidas = partidas();
    
    $total        = 0;
         $total_mod    = 0;
         $total_aprob  = 0;
         $total_comp   = 0;
         $total_cau    = 0;
         $total_pag    = 0;
         
         $total_monto_x100comp  = 0 ;          
         $total_monto_x100cau   = 0 ;          
         $total_monto_x100pag   = 0 ;
    
    foreach($lista_partidas as $key => $campo){

                    $monto_comp         = $campo["mo_comprometido"];          
                    $monto_modificado   = $campo["mo_modificado_mov"];                
                    $mo_causado         = $campo["mo_causado"];     
                    $mo_pagado          = $campo["mo_pagado"];              
                    $aprobado              = $campo['mo_aprobado'];
                    $monto_x100comp        = (($monto_comp)*100)/$aprobado ;          
                    $monto_x100cau         = (($mo_causado)*100)/$aprobado ;          
                    $monto_x100pag         = (($mo_pagado)*100)/$aprobado ;    
                    
                                     
                  
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $campo["tx_descripcion"], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $campo['inicial'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $monto_modificado,PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $aprobado,PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $monto_comp,PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $monto_x100comp,PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $mo_causado,PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $monto_x100cau,PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $mo_pagado,PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $monto_x100pag,PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    // Increment the Excel row counter
                    $rowCount++;
                    
                    $total       += $campo['inicial'];
                    $total_mod   += $monto_modificado;
                    $total_aprob += $aprobado;
                    $total_comp  += $monto_comp;
                    $total_cau   += $mo_causado;
                    $total_pag   += $mo_pagado;       

                    $total_monto_x100comp  = (($total_comp)*100)/$total_aprob ;          
                    $total_monto_x100cau   = (($total_cau)*100)/$total_aprob ;           
                    $total_monto_x100pag   = (($total_pag)*100)/$total_aprob ;
    }
    
    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J'.$rowCount)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, 'TOTAL RELACION........', PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $total,PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $total_mod,PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $total_aprob,PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $total_comp,PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $total_monto_x100comp,PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $total_cau,PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $total_monto_x100cau,PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $total_pag,PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $total_monto_x100pag,PHPExcel_Cell_DataType::TYPE_NUMERIC);

    
    
    function partidas(){
        
        $condicion ="";
        $nu_anio       = $_GET['co_anio_fiscal'];    
           
        
        list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
        $fe_inicio = $anio.'-'.$mes.'-'.$dia;

        list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
        $fe_fin = $anio.'-'.$mes.'-'.$dia;

        $conex = new ConexionComun();     

        $sql = "SELECT distinct co_ambito,
                co_ambito||'-'||tx_ambito as tx_descripcion, 		
                sum(mo_inicial) as inicial, 
                (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$nu_anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$nu_anio,1,'$fe_inicio','$fe_fin')),0) mo_modificado_mov,
                sum(mo_inicial)+ (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$nu_anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$nu_anio,1,'$fe_inicio','$fe_fin')),0) as mo_aprobado,
                coalesce(sum(comprometido_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$nu_anio,1,'$fe_inicio','$fe_fin')),0) mo_comprometido,
                coalesce(sum(causado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$nu_anio,2,'$fe_inicio','$fe_fin')),0) mo_causado,
                coalesce(sum(pagado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$nu_anio,3,'$fe_inicio','$fe_fin')),0) mo_pagado
                FROM tb085_presupuesto as tb085 inner join tb138_ambito as tb138 on (tb138.co_ambito = cast(tb085.cod_amb as integer))
                where in_movimiento is true and  length(nu_partida)=17 and tb085.nu_anio = $nu_anio
                group by 1,2
                order by 1 asc;";
      //  echo $sql; exit();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol; 
	
    }
   
    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="presupuesto_tipo_gasto_'.date("H:i:s").'.xlsx"');
    $objWriter->save('php://output');

?>