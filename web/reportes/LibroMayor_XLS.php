<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Isilio Vilchez");
    $objPHPExcel->getProperties()->setTitle("Listado de Libro Mayor");
    $objPHPExcel->getProperties()->setSubject("Reporte");
    $objPHPExcel->getProperties()->setDescription("Reporte para documento de Office 2007 XLSX.");
    // Set the active Excel worksheet to sheet 0
    $objPHPExcel->setActiveSheetIndex(0);
    // Rename sheet
    
    $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->setTitle('LIBRO MAYOR');

    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn

    $conex = new ConexionComun();
      
    //echo var_dump($saldo); exit();
    
    
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', '')
    ->setCellValue('B1', '')
    ->setCellValue('C1', 'RELACIÓN DE MOVIMIENTOS LIBRO MAYOR DESDE  '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))
    ->setCellValue('D1', '')
    ->setCellValue('E1', '')
    ->setCellValue('F1', '')  
    ->setCellValue('G1', '') 
    ->setCellValue('H1', '') 
    ->setCellValue('I1', '');   

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
    
    
            $fe_inicio    = $_GET['fe_inicio'];    
            $fe_fin       = $_GET['fe_fin'];
            $co_anexo_contable       = $_GET['co_anexo_contable'];
            $conex = new ConexionComun();
            
            if($co_anexo_contable){
                $co_anexo_contable = 'and tb190.co_anexo_contable = '.$co_anexo_contable;
            }else{
            $co_anexo_contable = '';   
            }
            
            $sql = "SELECT to_char(tb061.created_at::date,'dd/mm/yyyy') as fecha,
                case when substring(tb024.nu_cuenta_contable,1,1)::integer= 4 then 300 when substring(tb024.nu_cuenta_contable,1,3)::integer= 301 then 301 when substring(tb024.nu_cuenta_contable,1,3)::integer= 302 then 28 else tb190.codigo end as anexo,tb027.tx_tipo_solicitud||' - '||tb026.tx_observacion as tx_descripcion,
                tb133.tx_tipo_asiento,tb061.mo_debe,tb061.mo_haber,tb061.co_solicitud,tb024.tx_cuenta,tb061.nu_comprobante,
                case when substring(tb024.nu_cuenta_contable,1,1)::integer= 4 then 26 when substring(tb024.nu_cuenta_contable,1,3)::integer= 301 then 27 when substring(tb024.nu_cuenta_contable,1,3)::integer= 302 then 28 else tb190.co_anexo_contable end as co_anexo_contable
                from tb061_asiento_contable tb061 
left join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb061.co_cuenta_contable) 
left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = case when substring(tb024.nu_cuenta_contable,1,3)::integer = 101 then  substring(tb024.nu_cuenta_contable,1,9) else substring(tb024.nu_cuenta_contable,1,7) end) 
left join tb026_solicitud tb026 on (tb026.co_solicitud = tb061.co_solicitud) 
left join tb027_tipo_solicitud tb027 on (tb027.co_tipo_solicitud = tb026.co_tipo_solicitud)
left join tb133_tipo_asiento tb133 on (tb133.co_tipo_asiento = tb061.co_tipo_asiento) 
where tb061.created_at::date >= '".$fe_inicio."' and tb061.created_at::date <= '".$fe_fin."' $co_anexo_contable order by co_anexo_contable asc,tb061.created_at::date asc, tb061.co_solicitud asc,tb061.co_tipo_asiento";
     //echo $sql; exit();
    $Movimientos = $conex->ObtenerFilasBySqlSelect($sql);

    //var_dump($sql); exit();
     $rowCount = 2;
     $total_dia_debe = 0;
     $total_dia_haber = 0;
     $anexo = '';
     $saldo = 0;    

    foreach ($Movimientos as $key => $value) {
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
        
         if($anexo==''){
             
          $sqlCuenta = "SELECT codigo||' - '||descripcion as tx_descripcion
        FROM tb190_anexo_contable
        WHERE co_anexo_contable = ".$value['co_anexo_contable'];
                        
        
          $datosCuenta = $conex->ObtenerFilasBySqlSelect($sqlCuenta);                 
        $rowCount++; 
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, 'CUENTA DEL MAYOR: ', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $datosCuenta[0]["tx_descripcion"], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount.':E'.$rowCount)->getFont()->setBold(true);
        $rowCount++; 
        
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, 'Nº Solicitud', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount,'FECHA', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, 'DESCRIPCION', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount,'COMPROBANTE', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, 'CODIGO CONTABLE', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, 'TIPO DE ASIENTO', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, 'DEBE', PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, 'HABER', PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('i'.$rowCount, 'SALDO', PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->getFont()->setBold(true);
        $rowCount++; 
         }        
        
        
        if($anexo<>$value['anexo'] && $anexo<>''){


        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, '=========', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, '=========', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, '=========', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount.':I'.$rowCount)->getFont()->setBold(true);            
        $rowCount++;    
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, 'TOTAL:', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $total_dia_debe, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $total_dia_haber, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $saldo, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount.':I'.$rowCount)->getFont()->setBold(true);
        
          $sqlCuenta = "SELECT codigo||' - '||descripcion as tx_descripcion
        FROM tb190_anexo_contable
        WHERE co_anexo_contable = ".$value['co_anexo_contable'];
                        
        
          $datosCuenta = $conex->ObtenerFilasBySqlSelect($sqlCuenta);                 
        $rowCount++; 
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, 'CUENTA DEL MAYOR: ', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $datosCuenta[0]["tx_descripcion"], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount.':E'.$rowCount)->getFont()->setBold(true);
        $rowCount++; 
        
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, 'Nº Solicitud', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount,'FECHA', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, 'DESCRIPCION', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount,'COMPROBANTE', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, 'CODIGO CONTABLE', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, 'TIPO DE ASIENTO', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, 'DEBE', PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, 'HABER', PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('i'.$rowCount, 'SALDO', PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->getFont()->setBold(true);
        $rowCount++;         
        
         $total_dia_debe =  0;  
         $total_dia_haber =  0;
         $saldo = 0;
         $rowCount++;
        }           
        
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['co_solicitud'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['fecha'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['tx_descripcion'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['nu_comprobante'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value['tx_cuenta'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $value['tx_tipo_asiento'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $value['mo_debe'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $value['mo_haber'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        // Increment the Excel row counter
        $rowCount++;

        
        $total_dia_debe =  $total_dia_debe + $value['mo_debe'];  
        $total_dia_haber =  $total_dia_haber + $value['mo_haber'];
        $saldo = $total_dia_debe - $total_dia_haber;
        $anexo =  $value['anexo'];
                
        
        
    }
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, 'TOTAL:', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $total_dia_debe, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $total_dia_haber, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $saldo, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount.':I'.$rowCount)->getFont()->setBold(true);
    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="libro_mayor_'.date("d-m-Y").'.xlsx"');
    $objWriter->save('php://output');

?>