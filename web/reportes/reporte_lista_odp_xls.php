<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Joel Camarillo");
    $objPHPExcel->getProperties()->setTitle("Listado de Area");
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
    $objPHPExcel->getActiveSheet()->setTitle('Listado de Area');
    // Initialise the Excel row number
    $rowCount = 2;
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn
    
       

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'AMBITOS')
    ->setCellValue('B1', 'MONTO LEY')
    ->setCellValue('C1', 'MODIFICADO')
    ->setCellValue('D1', 'APROBADO')
    ->setCellValue('E1', 'COMPROMETIDO')
    ->setCellValue('F1', '%COMP')
    ->setCellValue('G1', 'CAUSADO')
    ->setCellValue('H1', '%CAU')
    ->setCellValue('I1', 'PAGADO')
    ->setCellValue('J1', '%PAG');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
    
         $campo='';
         $lista_niveles = niveles(); 
         $total        = 0;
         $total_mod    = 0;
         $total_aprob  = 0;
         $total_comp   = 0;
         $total_cau    = 0;
         $total_pag    = 0;
         
         $total_monto_x100comp  = 0 ;          
         $total_monto_x100cau   = 0 ;          
         $total_monto_x100pag   = 0 ;
                 
	 foreach($lista_niveles as $key => $dato){
         
         $subtotal_ley    = 0;  
         $subtotal_mod    = 0;
         $subtotal_aprob  = 0;
         $subtotal_comp   = 0;
         $subtotal_cau    = 0;
         $subtotal_pag    = 0; 
         
         $subtotal_monto_x100comp  = 0 ;          
         $subtotal_monto_x100cau   = 0 ;          
         $subtotal_monto_x100pag   = 0 ;
         
         $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J1'.$rowCount)->getFont()->setBold(true);
         $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $dato['tx_tp_area'], PHPExcel_Cell_DataType::TYPE_STRING);// Increment the Excel row counter
         $rowCount++;
                 
	 $lista_partidas = partidas($dato['co_tp_area']);   
         
	 foreach($lista_partidas as $key => $campo){

         /********************************************************************************************************/        
         /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
         /********************************************************************************************************/
           
            $monto_incremento      = partidas_mov(7, $dato['co_tp_area'],$campo['cod_amb']);     
            $monto_disminucion     = partidas_mov(8, $dato['co_tp_area'],$campo['cod_amb']);  
            $monto_comprometido    = partidas_mov(1, $dato['co_tp_area'],$campo['cod_amb']) ; 
            $monto_comp            = $monto_comprometido['monto'] ;          
            $monto_modificado      = ($monto_incremento['monto']) - $monto_disminucion['monto'];                
            $monto_causado         = partidas_mov(2, $dato['co_tp_area'],$campo['cod_amb']);   
            $monto_pagado          = partidas_mov(3, $dato['co_tp_area'],$campo['cod_amb']);                       
            $aprobado              = $monto_modificado + $campo['inicial'];
            $monto_x100comp        = round((($monto_comp)*100)/$aprobado,2) ;          
            $monto_x100cau         = round((($monto_causado['monto'])*100)/$aprobado,2) ;           
            $monto_x100pag         = round((($monto_pagado['monto'])*100)/$aprobado,2) ;           
         /********************************************************************************************************/
          
                
            $subtotal_ley    += $campo['inicial'];
            $subtotal_mod    += $monto_modificado;
            $subtotal_aprob  += $aprobado;
            $subtotal_comp   += $monto_comp;
            $subtotal_cau    += $monto_causado['monto'];
            $subtotal_pag    += $monto_pagado['monto'];   
         
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J1'.$rowCount)->getFont()->setBold(false);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, utf8_decode($campo['tx_ambito']), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $campo['inicial'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $monto_modificado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $aprobado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $monto_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $monto_x100comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $monto_causado['monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $monto_x100cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $monto_pagado['monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $monto_x100pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            // Increment the Excel row counter
            $rowCount++;
         
         
         
         }
         
         
        
         $subtotal_monto_x100comp  = round((($subtotal_comp)*100)/$subtotal_aprob,2) ;          
         $subtotal_monto_x100cau   = round((($subtotal_cau)*100)/$subtotal_aprob,2) ;          
         $subtotal_monto_x100pag   = round((($subtotal_pag)*100)/$subtotal_aprob,2) ;  
         
         $total       += $subtotal_ley;
         $total_mod   += $subtotal_mod;
         $total_aprob += $subtotal_aprob;
         $total_comp  += $subtotal_comp;
         $total_cau   += $subtotal_cau;
         $total_pag   += $subtotal_pag;
         
         $total_monto_x100comp  = round((($total_comp)*100)/$total_aprob,2) ;         
         $total_monto_x100cau   = round((($total_cau)*100)/$total_aprob,2) ;           
         $total_monto_x100pag   = round((($total_pag)*100)/$total_aprob,2) ;  
         
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J1'.$rowCount)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, 'Total Area........', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $subtotal_ley, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $subtotal_mod,  PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $subtotal_aprob, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $subtotal_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $subtotal_monto_x100comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $subtotal_cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $subtotal_monto_x100cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $subtotal_pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $subtotal_monto_x100pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        // Increment the Excel row counter
        $rowCount++;
         
         
         
      }
      
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J1'.$rowCount)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, 'TOTAL RELACION........', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $total, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $total_mod, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $total_aprob, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $total_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $total_monto_x100comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $total_cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $total_monto_x100cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $total_pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $total_monto_x100pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        // Increment the Excel row counter
        $rowCount++;
    
    
    
    
   
    
    function niveles(){        

          $conex = new ConexionComun();     
          $sql = "   SELECT co_tp_area, tx_tp_area
                        FROM tb160_tp_area order by 1"; 
          
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 	
    }
   
    function partidas($tipo){
        
        $condicion ="";
        $anio       = $_GET['co_anio_fiscal'];       
        if ($_GET["co_anio_fiscal"])     $condicion .= " and tb085.nu_anio =".$anio;        

        $conex = new ConexionComun();     

        $sql = " SELECT distinct  lpad((tb138.co_ambito::text),2,'0')cod_amb, (tb085.cod_amb ||'- '|| tb138.tx_ambito) as tx_ambito,
                              sum(mo_inicial) as inicial                        
                 FROM tb082_ejecutor tb082
                 left join tb083_proyecto_ac as tb083 on tb082.id= tb083.id_tb082_ejecutor
                 left join tb084_accion_especifica as tb084 on tb084.id_tb083_proyecto_ac=tb083.id
                 left join tb085_presupuesto as tb085 on tb085.id_tb084_accion_especifica = tb084.id     
                 left join tb080_sector as tb080 on tb080.id  = tb083.id_tb080_sector 
                 left join tb138_ambito as tb138 on (tb138.co_ambito::text) = tb085.cod_amb
                 --left join tb138_ambito as tb138 on lpad((tb138.co_ambito::text),2,'0') = tb085.cod_amb
                 left join tb160_tp_area as tb160 on (tb160.co_tp_area = tb138.nu_nivel)
                 where length(tb085.nu_partida) = 17 AND tb160.co_tp_area = ".$tipo." $condicion
                 GROUP BY 1, 2 
                 order by 1 asc ";
    
//         echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
	
    }
    
    function partidas_mov($tipo, $id, $cod){
        
    /*
    1 -- Comprometido 
    2 -- Causado
    3 -- Pagado
    7 -- Incremento
    8 -- Deduccion
    */    
    $condicion ="";   
    $periodo    = $_GET['co_periodo']; 
    $anio       = $_GET['co_anio_fiscal'];       
    
    $conex = new ConexionComun();     
    
    list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
    $fe_inicio = $anio.'-'.$mes.'-'.$dia;

    list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
    $fe_fin = $anio.'-'.$mes.'-'.$dia;
    
    if ($tipo == 7 || $tipo == 8){
        
        $tipoMovimiento = ($tipo==7)?2:1;
        
        $condicion = " and tb097.created_at >= '$fe_inicio' and tb097.created_at <= '$fe_fin'";
        
        $sql = "SELECT distinct sum(tb097.mo_distribucion) as monto 
                FROM tb080_sector as tb080 left join tb083_proyecto_ac as tb083 on tb080.id = tb083.id_tb080_sector 
                     left join tb084_accion_especifica as tb084 on tb084.id_tb083_proyecto_ac=tb083.id 
                     left join tb085_presupuesto as tb085 on tb085.id_tb084_accion_especifica = tb084.id 
                     left join tb097_modificacion_detalle as tb097 on tb097.id_tb085_presupuesto = tb085.id 
                     left join tb138_ambito as tb138 on (tb138.co_ambito::text) = tb085.cod_amb 
                     left join tb160_tp_area as tb160 on (tb160.co_tp_area = tb138.nu_nivel) 
                 where tb160.co_tp_area = ".$id." and tb085.cod_amb ='".$cod."'
                   and tb097.id_tb098_tipo_distribucion = $tipoMovimiento 
                   and tb097.in_anular is null
                   and length(tb085.nu_partida) = 17 
                   $condicion 
                group by tb085.cod_amb, tb160.co_tp_area order by 1 asc";
        
    }else{
    
         $condicion = " and tb087.created_at >= '$fe_inicio' and tb087.created_at <= '$fe_fin'";
         
         $sql = "SELECT distinct 
                        sum(tb087.nu_monto) as monto
                 FROM tb080_sector as tb080
                 left join tb083_proyecto_ac as tb083 on tb080.id  = tb083.id_tb080_sector   
                 left join tb084_accion_especifica as tb084 on tb084.id_tb083_proyecto_ac=tb083.id
                 left join tb085_presupuesto as tb085 on tb085.id_tb084_accion_especifica = tb084.id
                 left join tb087_presupuesto_movimiento as tb087 on tb087.co_partida = tb085.id
                 left join tb138_ambito as tb138 on (tb138.co_ambito::text) = tb085.cod_amb                                                  
                 left join tb160_tp_area as tb160 on (tb160.co_tp_area = tb138.nu_nivel)
                where tb160.co_tp_area = ".$id." and tb085.cod_amb ='".$cod."'
                   and tb087.co_tipo_movimiento= $tipo 
                   and tb087.in_anular is null
                   and length(tb085.nu_partida) = 17 
                   and tb087.created_at is not null $condicion 
                 group by tb085.cod_amb, tb160.co_tp_area order by 1 asc ";        
    }
           // echo var_dump($sql); exit();        
   
    
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0]; 
	
    }     
    
   
   
    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="presupuesto_area_'.date("H:i:s").'.xlsx"');
    $objWriter->save('php://output');

?>