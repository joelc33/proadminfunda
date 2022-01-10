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
    $rowCount = 2;
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn
    
    /*
     *  $this->Row(array('Organo Ordenador','Presupuestado',
     * 'Modificado','Aprobado','Comprometido','%Comp','Causado','%Cau','Pagado',
     * '%Pag.'),0,0);

     */
    

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Organo Ordenador')
    ->setCellValue('B1', 'Presupuestado')
    ->setCellValue('C1', 'Modificado')
    ->setCellValue('D1', 'Aprobado')
    ->setCellValue('E1', 'Comprometido')
    ->setCellValue('F1', '%Comp')
    ->setCellValue('G1', 'Causado')
    ->setCellValue('H1', '%Cau')
    ->setCellValue('I1', 'Pagado')
    ->setCellValue('J1', 'Pagado');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);

    /*$condicion ="";    
    $condicion .= " fe_emision >= '". $_GET["fe_inicio"]."' and ";
    $condicion .= " fe_emision <= '".$_GET["fe_fin"]."' ";*/

//    $condicion ="";    
//    $condicion .= " tb063.fe_pago >= '". $_GET["fe_inicio"]."' and ";
//    $condicion .= " tb063.fe_pago <= '".$_GET["fe_fin"]."' ";

    $conex = new ConexionComun();
    
    $sql = "   SELECT distinct  
                   case when(COALESCE(tip_gasto,tip_gasto,'P') in ('T','F','P')) then 'F - FUNCIONAMIENTO'
                   else 'I - INVERSION' end as tip_gasto,
                        sum(mo_inicial) as inicial                        
                FROM tb082_ejecutor tb082
                     left join tb083_proyecto_ac as tb083 on tb082.id= tb083.id_tb082_ejecutor
                     left join tb084_accion_especifica as tb084 on tb084.id_tb083_proyecto_ac=tb083.id
                     left join tb085_presupuesto as tb085 on tb085.id_tb084_accion_especifica = tb084.id
                     left join tb080_sector as tb080 on tb080.id  = tb083.id_tb080_sector                     
                     where 
                     length(nu_partida) = 17 and
                     co_partida<>'' and tb085.nu_anio = ".$_GET["co_anio_fiscal"]." group by 1 order by 1 asc";          

    
      //echo $sql; exit();        
    $datos = $conex->ObtenerFilasBySqlSelect($sql);
    
    foreach($datos as $key => $campo){

                    $monto_incremento      = partidas_mov(7, $campo['tip_gasto']);     
                    $monto_disminucion     = partidas_mov(8, $campo['tip_gasto']);     
                    $monto_comprometido    = partidas_mov(1, $campo['tip_gasto']);     
                    $monto_comp            = $monto_comprometido['monto'] ;          
                    $monto_modificado      = ($monto_incremento['monto']) - $monto_disminucion['monto'];                
                    $monto_causado         = partidas_mov(2, $campo['tip_gasto']);     
                    $monto_pagado          = partidas_mov(3, $campo['tip_gasto']);     
                    $aprobado              = $monto_modificado + $campo['inicial'];
                    $monto_x100comp        = (($monto_comp)*100)/$aprobado ;          
                    $monto_x100cau         = (($monto_causado['monto'])*100)/$aprobado ;          
                    $monto_x100pag         = (($monto_pagado['monto'])*100)/$aprobado ; 
                    
                                     
                  
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $campo['tip_gasto'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, number_format($campo['inicial'], 2, ',','.'));
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, number_format($monto_modificado, 2, ',','.'));
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, number_format($aprobado, 2, ',','.'));
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, number_format($monto_comp, 2, ',','.'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($monto_x100comp, 2, ',','.'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format($monto_causado['monto'], 2, ',','.'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format($monto_x100cau, 2, ',','.'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format($monto_pagado['monto'], 2, ',','.'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format($monto_x100pag, 2, ',','.'));
                    // Increment the Excel row counter
                    $rowCount++;
    }
    
    
    
    function partidas_mov($tipo, $tip_gasto){
                        
                list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
                $fe_inicio = $anio.'-'.$mes.'-'.$dia;

                list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
                $fe_fin = $anio.'-'.$mes.'-'.$dia;


                if ($tip_gasto=='F - FUNCIONAMIENTO')  $tip_gasto="'T','F','P'";    
                if ($tip_gasto=='I - INVERSION')       $tip_gasto="'I','S'";

                $conex = new ConexionComun();     
                
                if ($tipo == 7 || $tipo == 8){
                    
                  $condicion = " and tb097.created_at >= '$fe_inicio' and tb097.created_at <= '$fe_fin'";
                  
                  $tipoMovimiento = ($tipo == 7)?2:1;
                  
                  $sql =  " SELECT distinct sum(tb097.mo_distribucion) as monto 
                            FROM tb082_ejecutor tb082 left join tb083_proyecto_ac as tb083 
                                 on tb082.id= tb083.id_tb082_ejecutor 
                                 left join tb084_accion_especifica as tb084 
                                 on tb084.id_tb083_proyecto_ac=tb083.id left join tb085_presupuesto as tb085 
                                 on tb085.id_tb084_accion_especifica = tb084.id left join tb097_modificacion_detalle as tb097 
                                 on tb097.id_tb085_presupuesto = tb085.id and tb097.id_tb098_tipo_distribucion= $tipoMovimiento left join tb080_sector as tb080 
                                 on tb080.id = tb083.id_tb080_sector 
                                 where COALESCE(tip_gasto,tip_gasto,'P') in (".$tip_gasto.") 
                                       and length(tb085.nu_partida) = 17 
                                       and tb097.created_at is not null 
                                       $condicion";    
                    
                }else{
                    
                    $condicion = " and tb087.created_at >= '$fe_inicio' and tb087.created_at <= '$fe_fin'";    
                    $sql =  "SELECT distinct 
                                    sum(tb087.nu_monto) as monto
                             FROM tb082_ejecutor tb082
                             left join tb083_proyecto_ac as tb083 on tb082.id= tb083.id_tb082_ejecutor
                             left join tb084_accion_especifica as tb084 on tb084.id_tb083_proyecto_ac=tb083.id
                             left join tb085_presupuesto as tb085 on tb085.id_tb084_accion_especifica = tb084.id
                             left join tb087_presupuesto_movimiento as tb087 on tb087.co_partida = tb085.id and tb087.co_tipo_movimiento= $tipo
                             left join tb080_sector as tb080 on tb080.id  = tb083.id_tb080_sector                 
                             where COALESCE(tip_gasto,tip_gasto,'P') in (".$tip_gasto.")   
                                   and length(tb085.nu_partida) = 17 and 
                                   tb087.created_at is not null $condicion";

                }

               //echo $sql; exit();
                $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
                
                return  $datosSol[0]; 
    }
   
    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="retencion_islr_'.date("H:i:s").'.xlsx"');
    $objWriter->save('php://output');

?>