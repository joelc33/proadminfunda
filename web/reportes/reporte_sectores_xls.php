<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Joel Camarillo");
    $objPHPExcel->getProperties()->setTitle("Listado de Sectores");
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
    $objPHPExcel->getActiveSheet()->setTitle('Listado de Sectores');
    // Initialise the Excel row number
    
  
    
    $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'ALCALDIA DE SAN FRANCISCO');
    
    $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(false);
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'SECRETARIA DE ADMINISTRACIÓN Y FINANZAS')
                ->setCellValue('A3', 'SubSecretaria de Presupuesto')
                ->setCellValue('A3', '[FPRERA82]')
                ->setCellValue('F4', 'Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y"))
                ->setCellValue('A5', 'PERIODO....:  '.$_GET["fe_inicio"].' hasta '.$_GET["fe_fin"]);
   
    $objPHPExcel->getActiveSheet()->mergeCells("A6:H6");
    $objPHPExcel->getActiveSheet()->mergeCells("F4:H4");
    $objPHPExcel->getActiveSheet()->getStyle("A6:H6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A6', 'EJECUCIÓN PRESUPUESTARIA POR SECTORES - '.$_GET["fe_inicio"].' AL '.$_GET["fe_fin"]);
    
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn
    
        $tipo = $_GET['co_tipo'];

        if ($tipo==1)  // Consuta por Sector 
        {
            $objPHPExcel->getActiveSheet()->getStyle('A8:H8')->getFont()->setBold(true);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A8', 'Sector')
                    ->setCellValue('B8', 'Presupuestado')
                    ->setCellValue('C8', 'Modificado')
                    ->setCellValue('D8', 'Aprobado')
                    ->setCellValue('E8', 'Comprometido')
                    ->setCellValue('F8', 'Causado')
                    ->setCellValue('G8', 'Pagado')
                    ->setCellValue('H8', 'Disponible');
            
             $rowCount = 9;

            // Make bold cells
            $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
            
            $campo='';

            $total_ley    = 0;
            $total_mod    = 0;
            $total_aprob  = 0;
            $total_comp   = 0;
            $total_cau    = 0;
            $total_pag    = 0;
            $total_disp   = 0;

            $lista_partidas = partidas();          
         
            foreach($lista_partidas as $key => $campo){

        
                $monto_comp=0;

                 /********************************************************************************************************/        
                 /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
                 /********************************************************************************************************/
                $sectores              = $campo['sector'];  
                $monto_incremento      = $campo['mo_aumento'];       
                $monto_disminucion     = $campo['mo_disminucion'];             
                $monto_comp            = $campo['mo_comprometido'];          
                $monto_modificado      = ($campo['mo_modificado_mov']);                
                $monto_causado         = $campo['causado_admon']+$campo['mo_causado'];   
                $monto_pagado          = $campo['pagado_admon']+$campo['mo_pagado'];                     
                $aprobado              = $campo['inicial']+$monto_modificado;
                $disponible            = $aprobado - $monto_comp;
                
                //   $monto_disponibilidad  = $monto_modificado - $monto_comprometido['monto'];       
                 /********************************************************************************************************/
                $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J1'.$rowCount)->getFont()->setBold(false);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $sectores, PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $campo['inicial'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $monto_modificado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $aprobado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $monto_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $monto_causado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $monto_pagado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $disponible, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                // Increment the Excel row counter
                $rowCount++;


                $total_ley    += $campo['inicial'];
                $total_mod    += $monto_modificado;
                $total_aprob  += $aprobado;
                $total_comp   += $monto_comp;
                $total_cau    += $monto_causado;
                $total_pag    += $monto_pagado;
                $total_disp   += $disponible;
         
            }        
         
                 
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J'.$rowCount)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, utf8_decode('TOTAL RELACION........'), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $total_ley, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $total_mod, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $total_aprob, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $total_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $total_cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $total_pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $total_disp, PHPExcel_Cell_DataType::TYPE_NUMERIC);

            // Increment the Excel row counter
            $rowCount++;
         
         
        }
        else // Consulta por Partida
        {
            $objPHPExcel->getActiveSheet()->getStyle('A8:H8')->getFont()->setBold(true);
            $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A8', 'Cod. Presupuestario')
                         ->setCellValue('B8', 'Presupuestado')
                         ->setCellValue('C8', 'Modificado')
                         ->setCellValue('D8', 'Aprobado')
                         ->setCellValue('E8', 'Comprometido')
                         ->setCellValue('F8', 'Causado')
                         ->setCellValue('G8', 'Pagado')
                         ->setCellValue('H8', 'Disponible');
             $rowCount = 9;
        

         $campo='';
         
         $total_ley    = 0;
         $total_mod    = 0;
         $total_aprob  = 0;
         $total_comp   = 0;
         $total_cau    = 0;
         $total_pag    = 0;
         $total_disp   = 0;
         
         $lista_sectores = partidas(); 
         
         foreach($lista_sectores as $key => $inf){
             
            $SUBtotal_ley    = 0;
            $SUBtotal_mod    = 0;
            $SUBtotal_aprob  = 0;
            $SUBtotal_comp   = 0;
            $SUBtotal_cau    = 0;
            $SUBtotal_pag    = 0;
            $SUBtotal_disp   = 0;

            $lista_partidas = codigos($inf['id']);    

            foreach($lista_partidas as $key => $campo){
    
                $monto_comp=0;

                /********************************************************************************************************/        
                /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
                /********************************************************************************************************/
                        $part                  = desc_partida($campo['nu_pa']); 
                        $sectores              = $campo['sector'];  
                        $monto_incremento      = $campo['mo_aumento'];       
                        $monto_disminucion     = $campo['mo_disminucion'];             
                        $monto_comp            = $campo['mo_comprometido'];          
                        $monto_modificado      = ($campo['mo_modificado_mov']);                
                        $monto_causado         = $campo['mo_causado'];   
                        $monto_pagado          = $campo['mo_pagado'];                     
                        $aprobado              = $campo['mo_aprobado'];                           
                        $disponible            = $aprobado - $monto_comp;
                /********************************************************************************************************/
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J1'.$rowCount)->getFont()->setBold(false);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, utf8_decode($part['codigo']), PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $campo['inicial'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $monto_modificado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $aprobado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $monto_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $monto_causado['monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $monto_pagado['monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $disponible, PHPExcel_Cell_DataType::TYPE_NUMERIC);

                // Increment the Excel row counter
                $rowCount++;

                $SUBtotal_ley    += $campo['inicial'];
                $SUBtotal_mod    += $monto_modificado;
                $SUBtotal_aprob  += $aprobado;
                $SUBtotal_comp   += $monto_comp;
                $SUBtotal_cau    += $monto_causado['monto'];
                $SUBtotal_pag    += $monto_pagado['monto'];
                $SUBtotal_disp   += $disponible;
         
            }
         
         $total_ley    += $SUBtotal_ley;
         $total_mod    += $SUBtotal_mod;
         $total_aprob  += $SUBtotal_aprob;
         $total_comp   += $SUBtotal_comp;
         $total_cau    += $SUBtotal_cau;
         $total_pag    += $SUBtotal_pag;        
         $total_disp   += $SUBtotal_disp;

                  
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J1'.$rowCount)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, 'TOTAL SECTOR. '.$inf['id'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $SUBtotal_ley, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $SUBtotal_mod, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $SUBtotal_aprob, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $SUBtotal_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $SUBtotal_cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $SUBtotal_pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $SUBtotal_disp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        // Increment the Excel row counter
        $rowCount++;

         
       } 
       
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J1'.$rowCount)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, 'TOTAL RELACION........'.$inf['id'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $total_ley, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $total_mod, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $total_aprob, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $total_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $total_cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $total_pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $total_disp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        // Increment the Excel row counter
        $rowCount++;
      }         
    
    function niveles(){        

          $conex = new ConexionComun();     
          $sql = "   SELECT co_tp_area, tx_tp_area
                        FROM tb160_tp_area order by 1"; 
          
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 	
    }
   
   

    
    function desc_sectores($cod){
        
    $conex = new ConexionComun();     
    $sql = "   SELECT (nu_sector||'-'||de_sector) as sector
                FROM tb080_sector as tb080
                where id = ".$cod;          

       //  echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0]; 
	
    }    
   
    function desc_partida($cod){
        
    $conex = new ConexionComun();     
    $sql = "   SELECT (tb085.nu_pa||'-'||tb085.de_partida) as codigo, tb085.nu_pa
                FROM tb085_presupuesto as tb085
                where tb085.nu_pa = '".$cod."' and length(nu_partida) = 3 order by 1 asc "
            ;          

       //   echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0]; 
	
    }     
    
    function partidas(){
        
        $condicion ="";
        $sector     = $_GET['nu_sector'];
        $periodo    = $_GET['co_periodo']; 
        $anio       = $_GET['co_anio_fiscal'];   

        if ($_GET["nu_sector"]){
            $condicion .= " and tb080.id =".$sector;
        } 
        if ($_GET["co_anio_fiscal"]){
            $condicion .= " and tb085.nu_anio =".$anio;
        }    

        list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
        $fe_inicio = $anio.'-'.$mes.'-'.$dia;

        list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
        $fe_fin = $anio.'-'.$mes.'-'.$dia;

        $conex = new ConexionComun();     
       
        $sql = "SELECT distinct 
                tb080.id,(tb080.nu_sector||'-'||tb080.de_sector) as sector, 		
                sum(mo_inicial) as inicial, 
                (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_modificado_mov,
                sum(mo_inicial)+ (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) as mo_aprobado,
                coalesce(sum(comprometido_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_comprometido,
                coalesce(sum(causado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0) mo_causado,
                coalesce(sum(pagado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,3,'$fe_inicio','$fe_fin')),0) mo_pagado
                FROM tb085_presupuesto as tb085 inner join tb080_sector as tb080 on (substring(tb085.co_categoria,6,2) = tb080.nu_sector )
                where in_movimiento is true and  length(nu_partida)=17 $condicion 
                group by 1
                order by 1 asc;";
    
          //echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
	
    }
  
    
    function codigos($sect){
        
    $condicion ="";
    $sector     = $_GET['nu_sector'];
    $periodo    = $_GET['co_periodo']; 
    $anio       = $_GET['co_anio_fiscal'];   
    
    if ($sector)     $condicion .= " and tb080.id =".$sector; 
    if ($sect)       $condicion .= " and tb080.id =".$sect; 
    if ($_GET["co_anio_fiscal"])     $condicion .= " and tb085.nu_anio =".$anio; 
    
    list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
    $fe_inicio = $anio.'-'.$mes.'-'.$dia;

    list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
    $fe_fin = $anio.'-'.$mes.'-'.$dia;

    $conex = new ConexionComun();     
     $sql = "SELECT tb080.id, 
                        nu_pa, 
                        sum(mo_inicial) as inicial, 
                        (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_modificado_mov,
                        sum(mo_inicial)+ (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) as mo_aprobado,
                        coalesce(sum(comprometido_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_comprometido,
                        coalesce(sum(causado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0) mo_causado,
                        coalesce(sum(pagado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,3,'$fe_inicio','$fe_fin')),0) mo_pagado
                 FROM tb085_presupuesto as tb085 inner join
                      tb080_sector as tb080 on (substring(tb085.co_categoria,6,2) = tb080.nu_sector ) 
                 where in_movimiento is true and  length(nu_partida)=17  $condicion 
                 group by 1,2 order by 1,2 asc;";

    
//         echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
	
    }    
    
    
   
    function partidas_mov($tipo, $id, $band, $sect){
        
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
    
    
    list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
    $fe_inicio = $anio.'-'.$mes.'-'.$dia;

    list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
    $fe_fin = $anio.'-'.$mes.'-'.$dia;
    
    if ($_GET["co_anio_fiscal"]) $condicion .= " and tb085.nu_anio =".$anio; 
    if ($band==2) $condicion .= " and tb085.nu_partida like '".$id."%' and tb080.id =".$sect;
    if ($band==1) $condicion .= " and tb080.id =".$id;
    
    $conex = new ConexionComun(); 
    if ($tipo == 7 || $tipo == 8){
        
        $tipoMovimiento = ($tipo==7)?2:1;
        
        $condicion.= " and tb097.created_at >= '$fe_inicio' and tb097.created_at <= '$fe_fin'";
   
         $sql = "select id, sum(mo_distribucion) as monto
                from (SELECT distinct  
                        tb080.id,
                        tb097.mo_distribucion
                 FROM tb080_sector as tb080
                 left join tb083_proyecto_ac as tb083 on tb080.id  = tb083.id_tb080_sector   
                 left join tb084_accion_especifica as tb084 on tb084.id_tb083_proyecto_ac=tb083.id
                 left join tb085_presupuesto as tb085 on tb085.id_tb084_accion_especifica = tb084.id
                 left join tb097_modificacion_detalle as tb097 on tb097.id_tb085_presupuesto = tb085.id                    
                 where tb097.id_tb098_tipo_distribucion = $tipoMovimiento 
                   and tb097.in_anular is null
                   and length(tb085.nu_partida) = 17 
                   and tb097.created_at is not null $condicion ) as tabla
                 group by 1 order by 1 asc";  
    }else{

        $condicion.= " and tb087.created_at >= '$fe_inicio' and tb087.created_at <= '$fe_fin'";
        $sql = "select id, sum(nu_monto) as monto
                from (SELECT distinct  
                        tb080.id,
                        tb087.nu_monto
                 FROM tb080_sector as tb080
                 left join tb083_proyecto_ac as tb083 on tb080.id  = tb083.id_tb080_sector   
                 left join tb084_accion_especifica as tb084 on tb084.id_tb083_proyecto_ac=tb083.id
                 left join tb085_presupuesto as tb085 on tb085.id_tb084_accion_especifica = tb084.id
                 left join tb087_presupuesto_movimiento as tb087 on tb087.co_partida = tb085.id                    
                 where tb087.co_tipo_movimiento= $tipo 
                   and tb087.in_anular is null
                   and length(tb085.nu_partida) = 17 
                   and tb087.created_at is not null $condicion ) as tabla
                 group by 1 order by 1 asc";        
    
    }

      $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
      return  $datosSol[0]; 
	
    }    
    
   
   
    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="presupuesto_sectores_'.date("H:i:s").'.xlsx"');
    $objWriter->save('php://output');

?>