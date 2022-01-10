<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Joel Camarillo");
    $objPHPExcel->getProperties()->setTitle("Listado de Decretos");
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
    $objPHPExcel->getActiveSheet()->setTitle('Listado de Decretos');
    // Initialise the Excel row number
    $rowCount = 2;
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn
    
    /*
     * DecretoFechaMontoFuentePartidaModificadoAprobadoComprometidoPagadoDisponibilidad

     */
    

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Decreto')
    ->setCellValue('B1', 'Fecha')
    ->setCellValue('C1', 'Monto')
    ->setCellValue('D1', 'Fuente')
    ->setCellValue('E1', 'Partida')
    ->setCellValue('F1', 'Modificado')
    ->setCellValue('G1', 'Aprobado')
    ->setCellValue('H1', 'Comprometido')
    ->setCellValue('I1', 'Pagado')
    ->setCellValue('J1', 'Disponibilidad');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
    
    $lista_decretos = decretos();  
    $decreto='';
    foreach($lista_decretos as $key => $campo){
        
            $mov = movimientos($campo['decreto']);
   
            foreach($mov as $key => $campo2){
                    $partida  = desc_partida($campo2['nu_pa']); 
                    $fecha    = fecha_decreto($campo['decreto']);    


                             /********************************************************************************************************/        
                 /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
                 /********************************************************************************************************/

                    $monto_incremento      = partidas_mov(7, $campo['decreto'],$campo2['nu_pa']);     
                    $monto_disminucion     = partidas_mov(8, $campo['decreto'],$campo2['nu_pa']);  
                    $monto_comprometido    = partidas_mov(1, $campo['decreto'],$campo2['nu_pa']) ; 
                    $monto_comp            = $monto_comprometido['monto'] ;          
                    $monto_modificado      = ($monto_incremento['monto']) - $monto_disminucion['monto'];                             
                    $monto_pagado          = partidas_mov(3, $campo['decreto'],$campo2['nu_pa']);                       
                    $aprobado              = $campo2['monto_destino'];   
                    $total_disp            = $aprobado - $monto_comp;
                 /********************************************************************************************************/         


                    if($decreto<>$campo2['decreto'])
                    {   

                        $decreto= $campo2['decreto'];    

                        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount,$campo['decreto'], PHPExcel_Cell_DataType::TYPE_STRING);
                        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $fecha['fecha'], PHPExcel_Cell_DataType::TYPE_STRING);
                        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, number_format($campo['monto'], 2, ',','.'));
                        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, utf8_decode($campo['tx_descripcion']), PHPExcel_Cell_DataType::TYPE_STRING);
                        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $partida['de_partida'],PHPExcel_Cell_DataType::TYPE_STRING);
                        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $campo2['monto_destino'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $aprobado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $monto_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $monto_pagado['monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $total_disp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                        // Increment the Excel row counter
                        $rowCount++;


                    }   
                    else{ 

                        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount,'', PHPExcel_Cell_DataType::TYPE_STRING);
                        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, '', PHPExcel_Cell_DataType::TYPE_STRING);
                        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, '', PHPExcel_Cell_DataType::TYPE_STRING);
                        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, '', PHPExcel_Cell_DataType::TYPE_STRING);
                        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $partida['de_partida'],PHPExcel_Cell_DataType::TYPE_STRING);
                        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $campo2['monto_destino'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $aprobado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $monto_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $monto_pagado['monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $total_disp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                        $rowCount++;
                    }

                    $j=0;
                    $monto_dec = $monto_dec + $campo['monto'];
            }
    }
    
     function partidas_mov($tipo, $decreto, $cod){
        
    /*
    1 -- Comprometido 
    2 -- Causado
    3 -- Pagado
    7 -- Incremento
    8 -- Deduccion
    */    
    $condicion ="";   
    $periodo    = $_GET['co_periodo']; 
    $sector     = $_GET['nu_sector'];
    $ejecutor   = $_GET['nu_ejecutor'];    
    $proyecto   = $_GET['nu_proyecto_ac'];
    $accion     = $_GET['nu_accion_especifica'];      
    $partida    = $_GET['de_partida'];    
    
//    if ($periodo==1) $condicion .= " and tb087.created_at >= '01-01-2018' and tb087.created_at <= '31-03-2018'";
//    if ($periodo==2) $condicion .= " and tb087.created_at >= '01-04-2018' and tb087.created_at <= '30-06-2018'";  
//    if ($periodo==3) $condicion .= " and tb087.created_at >= '01-07-2018' and tb087.created_at <= '30-09-2018'";
//    if ($periodo==4) $condicion .= " and tb087.created_at >= '01-10-2018' and tb087.created_at <= '31-12-2018'";

    list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
    $fe_inicio = $anio.'-'.$mes.'-'.$dia;

    list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
    $fe_fin = $anio.'-'.$mes.'-'.$dia;
    
    
    
    if ($_GET["sector"])     $condicion .= " and tb080.id =".$sector; 
    if ($_GET["ejecutor"])   $condicion .= " and tb082.id =".$ejecutor;  
    if ($_GET["proyecto"])   $condicion .= " and tb083.id=".$proyecto; 
    if ($_GET["accion"])     $condicion .= " and tb084.id=".$accion;  
    if ($_GET["partida"])    $condicion .= " and tb085.nu_partida=".$partida;      

    $conex = new ConexionComun(); 

    if($tipo==7 || $tipo==8){
        
            $tipoMovimiento = ($tipo==7)?2:1;
            $condicion = " and tb097.created_at >= '$fe_inicio' and tb097.created_at <= '$fe_fin'";
            
            $sql = "SELECT distinct  
                            (tb073.tx_siglas)||'0'||tb068.tx_numero_fuente as decreto, 
                            tb085.nu_pa, 
                            sum(tb097.mo_distribucion) as monto
                           FROM tb096_presupuesto_modificacion as tb096
                           left join tb097_modificacion_detalle as tb097 on (tb096.id = tb097.id_tb096_presupuesto_modificacion)
                           left join tb068_numero_fuente_financiamiento as tb068 on  tb068.co_numero_fuente = tb096.id_tb068_numero_fuente_financiamiento  
                           left join tb073_fuente_financiamiento as tb073 on tb073.co_fuente_financiamiento = tb096.id_tb073_fuente_financiamiento
                           left join tb099_tipo_fuente_financiamiento as tb099 on tb099.id = tb068.id_tipo_fuente_financiamiento
                           left join tb085_presupuesto as tb085  on (tb068.tx_numero_fuente = substring(tb085.nu_fi,3,4) and tb085.id = tb097.id_tb085_presupuesto)                     
                           where  tb097.id_tb098_tipo_distribucion = $tipoMovimiento
                           and tb096.id_tb073_fuente_financiamiento is not null and tb085.nu_pa ='".$cod."'
                           and tb085.nu_fi='".$decreto."' $condicion
                           group by 1, 2
                           order by 1";
    }else{
        
              $condicion .= " and tb087.created_at >= '$fe_inicio' and tb087.created_at <= '$fe_fin'";
              $sql = "SELECT distinct tb085.nu_fi,
                             tb085.nu_pa, 
                             sum(tb087.nu_monto) as monto
                        FROM 	
                             tb068_numero_fuente_financiamiento as tb068 
                             left join tb099_tipo_fuente_financiamiento as tb099 on tb099.id = tb068.id_tipo_fuente_financiamiento
                             left join tb085_presupuesto as tb085  on (tb068.tx_numero_fuente = substring(tb085.nu_fi,3,4))                     
                             left join tb087_presupuesto_movimiento as tb087 on tb087.co_partida = tb085.id and tb087.co_tipo_movimiento=1
                       where  
                             tb087.in_anular is null and 
                             tb085.nu_pa ='".$cod."'
                             and tb085.nu_fi='".$decreto."' $condicion
                             group by 1,2 order by 1";
        
    }

   
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0]; 
	
    }        
    
    
    function desc_partida($nu_pa){


    $conex = new ConexionComun();       
    
    $sql = " SELECT distinct tb085.nu_pa, (tb085.nu_pa||'-'||tb085.de_partida) as de_partida FROM tb085_presupuesto as tb085 "
            . "where tb085.nu_pa = '".$nu_pa."' and length(tb085.nu_partida) = 3  ";     
    
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0]; 
	
    }  
    
    function fecha_decreto($decreto){


        $conex = new ConexionComun();       

        $sql = " SELECT distinct to_char(tb097.created_at,'dd/mm/yyyy') as fecha
                   FROM tb085_presupuesto as tb085
                   inner join tb097_modificacion_detalle as tb097 on (tb085.id = tb097.id_tb085_presupuesto) 
                   where tb085.nu_fi ='".$decreto."' "
                . " and length(tb085.nu_partida) = 17 limit 1 ";         

    //echo var_dump($sql); exit();

              $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
              return  $datosSol[0]; 
	
    }   
    
    function movimientos($decreto){

        $conex = new ConexionComun();       

        $sql = "     SELECT distinct  
                        (tb073.tx_siglas)||'0'||tb068.tx_numero_fuente as decreto, 
                        tb085.nu_pa, 
                        sum(tb097.mo_distribucion) as monto_destino
                       FROM tb096_presupuesto_modificacion as tb096
                       left join tb097_modificacion_detalle as tb097 on (tb096.id = tb097.id_tb096_presupuesto_modificacion)
                       left join tb068_numero_fuente_financiamiento as tb068 on  tb068.co_numero_fuente = tb096.id_tb068_numero_fuente_financiamiento  
                       left join tb073_fuente_financiamiento as tb073 on tb073.co_fuente_financiamiento = tb096.id_tb073_fuente_financiamiento
                       left join tb099_tipo_fuente_financiamiento as tb099 on tb099.id = tb068.id_tipo_fuente_financiamiento
                       left join tb085_presupuesto as tb085  on (tb068.tx_numero_fuente = substring(tb085.nu_fi,3,4) and tb085.id = tb097.id_tb085_presupuesto)                     
                       where  tb097.id_tb098_tipo_distribucion = 2
                       and tb096.id_tb073_fuente_financiamiento is not null
                       and tb085.nu_fi='".$decreto."'
                       group by 1, 2
                       order by 1";


    // echo var_dump($sql); exit();

        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol; 
	
    }     
    
    function decretos(){
        
        $condicion ="";
        $periodo     = $_GET['periodo'];
        $tipo        = $_GET['tipo'];    

        if ($_GET["periodo"])     $condicion .= " and upper(tb080.de_sector) like upper('%".$periodo."%')"; 
        if ($_GET["tipo"])        $condicion .= " and upper(tb082.de_ejecutor) like upper('%".$tipo."%')";  

        $conex = new ConexionComun();     

        $sql = "     SELECT distinct  
                        (tb073.tx_siglas)||'0'||tb068.tx_numero_fuente as decreto, 
                        de_tipo_fuente_financiamiento as tx_descripcion, 
                        sum(tb097.mo_distribucion) as monto
                       FROM tb096_presupuesto_modificacion as tb096
                       left join tb097_modificacion_detalle as tb097 on (tb096.id = tb097.id_tb096_presupuesto_modificacion)
                       left join tb068_numero_fuente_financiamiento as tb068 on  tb068.co_numero_fuente = tb096.id_tb068_numero_fuente_financiamiento  
                       left join tb073_fuente_financiamiento as tb073 on tb073.co_fuente_financiamiento = tb096.id_tb073_fuente_financiamiento
                       left join tb099_tipo_fuente_financiamiento as tb099 on tb099.id = tb068.id_tipo_fuente_financiamiento
                       left join tb085_presupuesto as tb085  on (tb068.tx_numero_fuente = substring(tb085.nu_fi,3,4) and tb085.id = tb097.id_tb085_presupuesto)                     
                       where  tb097.id_tb098_tipo_distribucion = 1
                       and tb096.id_tb073_fuente_financiamiento is not null
                       group by 1, 2
                       order by 1";    

      //  echo var_dump($sql); exit();
              $datosSol = $conex->ObtenerFilasBySqlSelect($sql);    
              return  $datosSol; 
	
    }
    
    
    
    

   
    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="presupuesto_decreto_'.date("H:i:s").'.xlsx"');
    $objWriter->save('php://output');

?>