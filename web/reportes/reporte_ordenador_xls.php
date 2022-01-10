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
                ->setCellValue('A1', 'ALCALDIA DE SAN FRANCISCO');

    $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(false);
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'SECRETARIA DE ADMINISTRACIÓN Y FINANZAS')
                ->setCellValue('A3', 'SubSecretaria de Presupuesto')
               // ->setCellValue('A3', '[FPRERC54]')
                ->setCellValue('I4', 'Fecha de Emisión, '.date("d").'/'.date("m").'/'.date("Y"))
                ->setCellValue('A5', 'PERIODO....:  '.$_GET["fe_inicio"].' hasta '.$_GET["fe_fin"]);

    $objPHPExcel->getActiveSheet()->mergeCells("A6:G6");
    $objPHPExcel->getActiveSheet()->mergeCells("I4:J4");
    $objPHPExcel->getActiveSheet()->getStyle("A6:G6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A6', ' EJECUCIÓN PRESUPUESTARIA DE GASTO POR ORDENADOR - '.$_GET["fe_inicio"].' AL '.$_GET["fe_fin"]);
   
                
    
        $objPHPExcel->getActiveSheet()->getStyle('A7:G7')->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A7', 'Organo Ordenador')
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
   

         $campo='';
         $total_ley    = 0;
         $total_mod    = 0;
         $total_aprob  = 0;
         $total_comp   = 0;
         $total_cau    = 0;
         $total_pag    = 0;
         
         $total_monto_x100comp  = 0 ;          
         $total_monto_x100cau   = 0 ;          
         $total_monto_x100pag   = 0 ;
                  
	 $lista_organos = organos();          
         
	 foreach($lista_organos as $key => $dato){
             
            $campo = partidas($dato['id']); 
           
            $monto_x100comp        = 0;          
            $monto_x100cau         = 0 ;          
            $monto_x100pag         = 0 ; 

         /********************************************************************************************************/        
         /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
         /********************************************************************************************************/
            $monto_comp            = $campo["mo_comprometido"];          
            $monto_modificado      = $campo["mo_modificado_mov"];                
            $mo_causado         = $campo["mo_causado"];    
            $mo_pagado          = $campo["mo_pagado"]; ;                       
            $aprobado              = $campo["mo_aprobado"]; ;
            
            $monto_x100comp        = (($monto_comp)*100)/$aprobado ;          
            $monto_x100cau         = (($mo_causado)*100)/$aprobado ;          
            $monto_x100pag         = (($mo_pagado)*100)/$aprobado ;     
         /********************************************************************************************************/         
        
         
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J1'.$rowCount)->getFont()->setBold(false);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, utf8_decode($dato['de_ejecutor']), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $campo['inicial'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $monto_modificado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $aprobado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $monto_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $monto_x100comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $mo_causado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $monto_x100cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $mo_pagado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $monto_x100pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            // Increment the Excel row counter
            $rowCount++;
        
         
            $total_ley    += $campo['inicial'];
            $total_mod    += $monto_modificado;
            $total_aprob  += $aprobado;
            $total_comp   += $monto_comp;
            $total_cau    += $mo_causado;
            $total_pag    += $mo_pagado;      

            $total_monto_x100comp  += $monto_x100comp ;          
            $total_monto_x100cau   += $monto_x100cau ;          
            $total_monto_x100pag   += $monto_x100pag ; 
         
          
      }
      
      //*************************************************************
      //******** El resto de las partidas forman parte del organo EJECUTIVO DEL ESTADO
      
        $campo = partidas(6); 

        $monto_x100comp        = 0;          
        $monto_x100cau         = 0 ;          
        $monto_x100pag         = 0 ; 

     /********************************************************************************************************/        
     /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
     /********************************************************************************************************/
        $monto_comp            = $campo["mo_comprometido"];          
        $monto_modificado      = $campo["mo_modificado_mov"];                
        $mo_causado            = $campo["mo_causado"];    
        $mo_pagado             = $campo["mo_pagado"]; ;                       
        $aprobado              = $campo["mo_aprobado"]; ;

        $monto_x100comp        = (($monto_comp)*100)/$aprobado ;          
        $monto_x100cau         = (($mo_causado)*100)/$aprobado ;          
        $monto_x100pag         = (($mo_pagado)*100)/$aprobado ;     
     /********************************************************************************************************/         


        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J1'.$rowCount)->getFont()->setBold(false);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, utf8_decode('0004.-EJECUTIVO DEL ESTADO'), PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $campo['inicial'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $monto_modificado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $aprobado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $monto_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $monto_x100comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $mo_causado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $monto_x100cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $mo_pagado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $monto_x100pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        // Increment the Excel row counter
        $rowCount++;


        $total_ley    += $campo['inicial'];
        $total_mod    += $monto_modificado;
        $total_aprob  += $aprobado;
        $total_comp   += $monto_comp;
        $total_cau    += $mo_causado;
        $total_pag    += $mo_pagado;      

        $total_monto_x100comp  += $monto_x100comp ;          
        $total_monto_x100cau   += $monto_x100cau ;          
        $total_monto_x100pag   += $monto_x100pag ; 
      
         
        $total_monto_x100comp  = (($total_comp)*100)/$total_aprob ;          
        $total_monto_x100cau   = (($total_cau)*100)/$total_aprob ;           
        $total_monto_x100pag   = (($total_pag)*100)/$total_aprob ; 
         
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J1'.$rowCount)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, utf8_decode('TOTAL RELACION........'), PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $total_ley, PHPExcel_Cell_DataType::TYPE_NUMERIC);
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
         

    function organos(){
        
        $conex = new ConexionComun();     
        $sql = "   SELECT distinct tb082.id, (nu_ejecutor||'.-'|| de_ejecutor) as de_ejecutor
                        FROM tb082_ejecutor tb082
                        left join tb083_proyecto_ac as tb083 on tb082.id= tb083.id_tb082_ejecutor
                         left join tb084_accion_especifica as tb084 on tb084.id_tb083_proyecto_ac=tb083.id
                         left join tb085_presupuesto as tb085 on tb085.id_tb084_accion_especifica = tb084.id
                        where tb083.id_tb013_anio_fiscal is not null and
                             length(nu_partida) = 3 and
                             co_partida<>'' order by id limit 3";          

        // echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
	
    }   
    
    function partidas($id){
    
            $condicion =""; 
            $anio       = $_GET['co_anio_fiscal'];     

            $condicion .= " and tb085.nu_anio =".$anio; 

            if($id == 3){
                $condicion .= " and tip_apl in ('01','01A','01B','01C')";
            }else if($id == 4){
                $condicion .= " and tip_apl in ('02','02A','02B','02C','02D','02E')";
            }else if ($id == 5){
                $condicion .= " and tip_apl in ('03','03A','03B','03C','03D','03E','03H')";
            }else{
                $condicion .= " and tip_apl not in ('01','01A','01B','01C','02','02A','02B','02C','02D','02E','03','03A','03B','03C','03D','03E','03H')";
            }

            list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
            $fe_inicio = $anio.'-'.$mes.'-'.$dia;

            list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
            $fe_fin = $anio.'-'.$mes.'-'.$dia;



            $conex = new ConexionComun();     
            $sql = "   SELECT distinct  sum(mo_inicial) as inicial, (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_modificado_mov,
                         sum(mo_inicial)+ (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) as mo_aprobado,
                         coalesce(sum(comprometido_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_comprometido,
                         coalesce(sum(causado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0) mo_causado,
                         coalesce(sum(pagado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,3,'$fe_inicio','$fe_fin')),0) mo_pagado
                        FROM  tb085_presupuesto tb085
                        where length(nu_partida) = 17 $condicion ";

                  //echo $sql; exit();
                  $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
                  return  $datosSol[0]; 

    }
      
   
    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="presupuesto_ordenador_'.date("H:i:s").'.xlsx"');
    $objWriter->save('php://output');

?>