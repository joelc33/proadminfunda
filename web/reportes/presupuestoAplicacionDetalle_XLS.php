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
                ->setCellValue('A1', 'ALCALDIA DE SAN FRANCISCO');

    $objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(false);
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', '')
                ->setCellValue('A3', '')
                ->setCellValue('A3', '[FPRER054]')
                ->setCellValue('I4', 'Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y"));

    $objPHPExcel->getActiveSheet()->mergeCells("A6:J6");
    $objPHPExcel->getActiveSheet()->mergeCells("I4:J4");
    $objPHPExcel->getActiveSheet()->getStyle("A6:J6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A6:J6')->getFont()->setBold(true);
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
    $objPHPExcel->getActiveSheet()
        ->getStyle('A7:J7')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('9c9c9c');

    $lista_apl = aplicaciones();          
         
    foreach($lista_apl as $key => $campo){
        
         /********************************************************************************************************/        
         /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
         /********************************************************************************************************/
            $monto_incremento      = $campo['mo_aumento'];       
            $monto_disminucion     = $campo['mo_disminucion'];                   
            $monto_comp            = $campo['mo_comprometido'];          
            $monto_modificado      = $campo['mo_aumento']-$campo['mo_disminucion'];  //correcta              
            $monto_causado         = $campo['mo_causado'];  
            $monto_pagado          = $campo['mo_pagado'];  
            $aprobado              = $monto_modificado + $campo['mo_ley'];      //correcto    
            $monto_disponible      = $campo['mo_ley']+$monto_modificado-$campo['mo_comprometido'];  //correcto
         /********************************************************************************************************/ 
        
        
         $fuentes='';
         $band   =1;
         $fuentes = fuente($campo['tx_tip_aplicacion']);  
         foreach($fuentes as $key => $dato){
           if(count($fuentes)>1)  
           {  
                if($band==1){
                    $fuentes = $dato['nu_fi'];
                }
                else{
                   $fuentes = $fuentes.'/'.$dato['nu_fi'];
                }
               $band=0;
               
           }else{
                $fuentes = $dato['nu_fi'];
           } 
         }
        
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J'.$rowCount)->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()
        ->getStyle('A'.$rowCount.':J'.$rowCount)
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('cdcdcd');
        
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, $campo['aplicacion'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $campo['mo_ley'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, $monto_incremento, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount, $monto_disminucion, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount, $monto_modificado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount, $aprobado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount, $monto_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$rowCount, $monto_causado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount, $monto_pagado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$rowCount, $monto_disponible, PHPExcel_Cell_DataType::TYPE_NUMERIC);

         $rowCount++; 
         $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J'.$rowCount)->getFont()->setBold(false);

         
         $lista_partida = appPartida( $campo['tx_tip_aplicacion'], $_GET['fe_inicio']); 

         foreach($lista_partida as $key => $campo2){

            $ley           =  $campo2['mo_inicial'];
            $comprometido  =  $campo2['mo_comprometido'];
            $causado       =  $campo2['mo_causado'];
            $pagado        =  $campo2['mo_pagado'];
            $aumento       =  $campo2['mo_aumento'];
            $disminucion   =  $campo2['mo_disminucion'];
            $pa_modificado =  $campo2['mo_modificado'];;
            $pa_aprobado   =  $pa_modificado + $campo2['mo_inicial'];          
            $pa_disponible =  $pa_aprobado-$comprometido; 
                      
           
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, $campo2['nu_partida'].' - '.$campo2['de_partida'], PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $ley, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, $aumento, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount, $disminucion, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount, $pa_modificado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount, $pa_aprobado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount, $comprometido, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$rowCount, $causado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount, $pagado, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$rowCount, $pa_disponible, PHPExcel_Cell_DataType::TYPE_NUMERIC);

            $rowCount++; 
         }
         
         $total_ley    += $campo['mo_ley'];
         $total_mod    += $monto_modificado;
         $total_aum    += $monto_incremento;
         $total_dis    += $monto_disminucion;
         $total_aprob  += $aprobado;
         $total_comp   += $monto_comp;
         $total_cau    += $monto_causado;
         $total_pag    += $monto_pagado;      
         $total_disp   += $monto_disponible;  
         
          
      }
      
      $rowCount++;
       
    
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, 'TOTAL RELACION........', PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $total_ley, PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, $total_aum, PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount, $total_dis, PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount, $total_mod, PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount, $total_aprob, PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount, $total_comp, PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$rowCount, $total_cau, PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount, $total_pag, PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->getActiveSheet()->setCellValue('J'.$rowCount, $total_disp, PHPExcel_Cell_DataType::TYPE_NUMERIC);

          
    
    
    function aplicaciones(){
        
    $conex = new ConexionComun();

    /*Campo tipo DATE */
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
//        echo $sql; exit();        
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol; 	
    }  

    function fuente($cod){
        
    $conex = new ConexionComun();     
    $sql = "   SELECT distinct tb085.nu_fi
                FROM tb085_presupuesto as tb085
                where tb085.tip_apl='".$cod."'  and tb085.nu_fi<>''               
                order by 1 asc;";          

          //echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 	
    }

    function appPartida($app, $fecha_fin){

        list($dia_fin, $mes_fin, $anio_fin) = explode("-", $fecha_fin);

        $fecha = $anio_fin."-".$mes_fin."-".$dia_fin;
        
        $conex = new ConexionComun();     
//        $sql = "SELECT tb085.id, nu_partida, de_partida
//        FROM tb087_presupuesto_movimiento as tb087
//        INNER JOIN tb085_presupuesto as tb085 on tb087.co_partida = tb085.id
//        WHERE tb085.id_tb139_aplicacion = ".$app." AND
//        tb087.created_at::date BETWEEN '".$anio_fin."-01-01'::date AND '".$fecha."'
//        group by 1,2,3 order by 2 asc;";
        
        
        $sql = "SELECT tb085.id, co_categoria as nu_partida, coalesce(de_partida,'') as de_partida,mo_inicial,
                coalesce(sum(mo_actualizado_ant),0) as actualiz,	
                coalesce(afectacion_partida(tb085.id,$anio_fin,2,'$fecha'),0) as mo_aumento,
                coalesce(afectacion_partida(tb085.id,$anio_fin,1,'$fecha'),0) as mo_disminucion,
                coalesce(afectacion_partida(tb085.id,$anio_fin,2,'$fecha'),0) -
                coalesce(afectacion_partida(tb085.id,$anio_fin,1,'$fecha'),0) as mo_modificado,
                coalesce(sum(comprometido_dia),0)+coalesce(movimiento_partida(tb085.id,$anio_fin,1,'$fecha'),0) as mo_comprometido,
                coalesce(sum(causado_dia),0)+coalesce(movimiento_partida(tb085.id,$anio_fin,2,'$fecha'),0) as mo_causado,	
                coalesce(sum(pagado_dia),0)+coalesce(movimiento_partida(tb085.id,$anio_fin,3,'$fecha'),0) as mo_pagado
                FROM tb087_presupuesto_movimiento as tb087
                INNER JOIN tb085_presupuesto as tb085 on tb087.co_partida = tb085.id
                WHERE tb085.nu_anio = $anio_fin and tb085.tip_apl = '$app' AND length(tb085.nu_partida)=17 AND
                cast(tb085.created_at as date) BETWEEN '".$anio_fin."-01-01'::date AND '".$fecha."'
                group by 1,2,3 order by 2 asc";
    
        
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol; 	
    }

    function appPartidaTipo($partida, $tipo, $fecha_fin){

        list($dia_fin, $mes_fin, $anio_fin) = explode("-", $fecha_fin);

        $fecha = $anio_fin."-".$mes_fin."-".$dia_fin;
        
        $conex = new ConexionComun();     
        $sql = "SELECT coalesce(sum(nu_monto),0) as mo_movimiento
        FROM tb087_presupuesto_movimiento as tb087
        INNER JOIN tb085_presupuesto as tb085 on tb087.co_partida = tb085.id
        WHERE tb087.co_partida = ".$partida." AND
        tb087.co_tipo_movimiento = ".$tipo." AND
        tb085.created_at::date BETWEEN '".$anio_fin."-01-01'::date AND '".$fecha."';";
    
        //echo var_dump($sql); exit();        
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];
        //return  $datosSol; 	
    }

    function getDatosEmpresa( $codigo){

        $sql = "SELECT co_empresa, nb_empresa, co_estado, co_municipio, tx_rif, tx_nit, 
        tx_direccion, tx_imagen_der, tx_imagen_izq, tx_imagen_cen, nu_telefono, 
        tx_sigla,
        op_imagen->'izquierda'->0 as izquierda_x,
        op_imagen->'izquierda'->1 as izquierda_y,
        op_imagen->'izquierda'->2 as izquierda_w,
        op_imagen->'centro'->0 as centro_x,
        op_imagen->'centro'->1 as centro_y,
        op_imagen->'centro'->2 as centro_w,
        op_imagen->'derecha'->0 as derecha_x,
        op_imagen->'derecha'->1 as derecha_y,
        op_imagen->'derecha'->2 as derecha_w
        FROM public.tb015_empresa
        WHERE co_empresa = ".$codigo.";";

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];
  
    }

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="presupuesto_aplicacion_'.$_GET["ejercicio"].'_'.date("d-m-Y").'.xlsx"');
    $objWriter->save('php://output');

?>