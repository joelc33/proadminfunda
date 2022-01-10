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
    $objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->setTitle('Listado de Ordenador');
    // Initialise the Excel row number
    
        $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'ALCALDIA DE SAN FRANCISCO');

        $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(false);
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A2', 'SECRETARIA DE ADMINISTRACIÓN Y FINANZAS')
                    ->setCellValue('A3', 'SubSecretaria de Presupuesto')
                    ->setCellValue('A3', '[FPRERB57]')
                    ->setCellValue('I4', 'Fecha de Emisión '.date("d").'/'.date("m").'/'.date("Y"))
                    ->setCellValue('A5', 'PERIODO....:  '.$_GET["fe_inicio"].' hasta '.$_GET["fe_fin"]);

        $objPHPExcel->getActiveSheet()->mergeCells("A6:M6");
        $objPHPExcel->getActiveSheet()->mergeCells("I4:M4");
        $objPHPExcel->getActiveSheet()->getStyle("A6:M6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A6:M6')->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A6', 'EJECUCIÓN PRESUPUESTARIA POR PARTIDAS- AÑO FISCAL '.$_GET['co_anio_fiscal']);
   
    
        $objPHPExcel->getActiveSheet()->getStyle('A7:M7')->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A7', 'Partida')
                ->setCellValue('B7', 'Descripcion')
                ->setCellValue('C7', 'Gasto')
                ->setCellValue('D7', 'Ambito')
                ->setCellValue('E7', 'Clasificacion Economica')
                ->setCellValue('F7', 'Area Estrategica')
                ->setCellValue('G7', 'Aplicación')
                ->setCellValue('H7', 'Presupuestado')
                ->setCellValue('I7', 'Modificado')
                ->setCellValue('J7', 'Aprobado')
                ->setCellValue('K7', 'Comprometido')
               // ->setCellValue('F7', '%COMP')
                ->setCellValue('L7', 'Causado')
               // ->setCellValue('H7', '%CAU.')
                ->setCellValue('M7', 'Pagado');
               // ->setCellValue('J7', '%PAG.');

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
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':M'.$rowCount)->getFont()->setBold(false);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $campo['nu_pa'], PHPExcel_Cell_DataType::TYPE_STRING);
         $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $campo['de_partida'].' '.$campo['de_partida'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $campo['tip_gasto'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $campo['tx_ambito'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $campo['tx_siglas_clasificacion_eco'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $campo['tx_siglas_accion_especifica'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $campo['nu_aplicacion'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $campo['inicial'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $monto_modificado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $aprobado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $monto_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
//        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $monto_x100comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $monto_causado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
//        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $monto_x100cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $monto_pagado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
//        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $monto_x100pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
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
                 
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':M'.$rowCount)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, 'TOTAL RELACION........', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $total, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $total_mod, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $total_aprob, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $total_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
//        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $total_monto_x100comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $total_cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
//        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $total_monto_x100cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $total_pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
//        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $total_monto_x100pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        // Increment the Excel row counter
        $rowCount++;

    
   
  
function partidas(){
        
    $condicion    ="";
    $periodo      = $_GET['co_periodo']; 
    $anio         = $_GET['co_anio_fiscal'];  
    
    $tip_apl      = $_GET["tip_apl"];
    $co_ejecutor  = $_GET["co_ejecutor"];
    $nu_fi        = $_GET["nu_fi"];
    
    
    list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
    $fe_inicio = $anio.'-'.$mes.'-'.$dia;

    list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
    $fe_fin = $anio.'-'.$mes.'-'.$dia;
    
    if ($co_ejecutor != ''){
        $condicion.=' and tb083.id_tb082_ejecutor ='.$co_ejecutor;
    }
    
    if ($nu_fi != ''){
        $condicion.=" and tb085.nu_fi ='".$nu_fi."'";
    }
    
    if ($tip_apl != ''){
        $condicion.=" and tb085.id_tb139_aplicacion =".$tip_apl;
    }
         
    $conex = new ConexionComun();     

    $sql = "select co_categoria as nu_pa, de_partida, tip_gasto,tx_ambito,tb184.tx_descripcion as tx_siglas_clasificacion_eco,tb185.tx_descripcion as tx_siglas_accion_especifica,tip_apl as nu_aplicacion,sum (mo_inicial) as inicial, (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) modificado,sum(mo_inicial)+ (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) as mo_aprobado,
                    coalesce(sum(comprometido_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_comprometido,
                    coalesce(sum(causado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0) mo_causado,
                    coalesce(sum(pagado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,3,'$fe_inicio','$fe_fin')),0) mo_pagado
FROM tb085_presupuesto as tb085 join tb084_accion_especifica as tb084 on (tb084.id = tb085.id_tb084_accion_especifica) left join 
tb083_proyecto_ac as tb083 on (tb083.id = tb084.id_tb083_proyecto_ac) 
left join tb138_ambito tb138 on (tb138.co_ambito = cast(tb085.cod_amb as integer))
left join tb184_clasificacion_economica tb184 on (tb184.co_clasificacion_economica = tb085.co_clasificacion_economica)
left join tb185_area_estrategica tb185 on (tb185.co_area_estrategica = tb085.co_area_estrategica)
where tb085.nu_anio ='$anio' and length(nu_partida) = 17 and co_partida<>'' $condicion
 group by 1,2,3,4,5,6,7 order by nu_pa asc";          

         //echo $sql; exit(); 
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