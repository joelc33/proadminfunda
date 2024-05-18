<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Isilio Vilchez");
    $objPHPExcel->getProperties()->setTitle("Listado de Analitico de Depositos de Terceros");
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
    $objPHPExcel->getActiveSheet()->setTitle('Analitico Depositos de Terceros');

    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn

    $conex = new ConexionComun();
      
    //echo var_dump($saldo); exit();
    

    
        $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Cuenta ')
    ->setCellValue('B1', 'Denominacion')
    ->setCellValue('C1', 'Saldo Anterior')
    ->setCellValue('D1', 'Debitos')
    ->setCellValue('E1', 'Creditos')
    ->setCellValue('F1', 'Saldo')
    ->setCellValue('G1', 'Saldo Actual'); 

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true);  

         $nivel_inicial = $_GET['nivel_inicial']; // Nivel especifico de inicio
         $nivel_final = $_GET['cant_nivel']; // Máximo cantidad de niveles    
         if($_GET['cuenta']){
          
             $cuenta = "and tb024.nu_cuenta_contable like '".$_GET['cuenta']."%'";
             
         }else{
              $cuenta =  "";
         }
        
        
        
        $conex = new ConexionComun(); 
                  $sql = "SELECT tb024.tx_cuenta,tb024.tx_descripcion as desc_cuenta,tb024.nu_cuenta_contable,co_cuenta_contable
from tb024_cuenta_contable tb024
where tb024.nu_nivel between 4 and 6 and tb024.nu_cuenta_contable like '2010504%' group by tb024.tx_cuenta,tb024.tx_descripcion,tb024.nu_cuenta_contable,co_cuenta_contable order by 1 asc";
     //echo $sql; exit();
    $Cuentas = $conex->ObtenerFilasBySqlSelect($sql);

   //var_dump($sql); exit();
    $rowCount = 2;

    foreach ($Cuentas as $key => $value) {
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
                if($_GET['in_periodo']){
                  $sql = "SELECT sum(pre_deb) as pre_deb, sum(pre_cre) as pre_cre,sum(pre_deb)  - sum(pre_cre) as saldo, (sum(acu_deb) + sum(mes_deb)) - (sum(acu_cre) + sum(mes_cre)) as saldo_anterior,
                  (sum(acu_deb) + sum(mes_deb)) - (sum(acu_cre) + sum(mes_cre)) + (sum(pre_deb)  - sum(pre_cre)) as saldo_actual  
from tb024_cuenta_contable tb024
where tb024.nu_cuenta_contable like '".$value['nu_cuenta_contable']."%'";
        }else{
    $co_mes = $_GET['co_mes'];
    $nu_anio = $_GET['co_anio_fiscal'];  
    $conex = new ConexionComun(); 
                  $sql = "SELECT sum(mes_debito) as pre_deb, sum(mes_credito) as pre_cre,sum(mes_debito)  - sum(mes_credito) as saldo, (sum(acu_debito)) - (sum(acu_credito)) as saldo_anterior,
                  (sum(acu_debito) - sum(acu_credito)) + (sum(mes_debito)  - sum(mes_credito)) as saldo_actual  
from tb179_resumen_mensual_contable tb179
inner join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb179.co_cuenta_contable)
where tb024.nu_cuenta_contable like '".$value['nu_cuenta_contable']."%' and co_mes = $co_mes and nu_anio = $nu_anio";
        }                  
                  
           //echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);        
        
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $value['tx_cuenta'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['desc_cuenta'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $datosSol[0]['saldo_anterior'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $datosSol[0]['pre_deb'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $datosSol[0]['pre_cre'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $datosSol[0]['saldo'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $datosSol[0]['saldo_actual'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        // Increment the Excel row counter
        $rowCount++;
        
        
                if($_GET['in_periodo']){
        $sql = "SELECT (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE as fecha_inicio,(date_trunc('MONTH',fecha_cierre::date) + INTERVAL '2 MONTH - 1 day')::DATE as fecha_fin,EXTRACT(YEAR FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE) AS anio,lpad(EXTRACT(MONTH FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE)::text,2,'0') AS mes from 
tb180_maestro_contable order by co_maestro_contable desc limit 1";
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);    
        
                  $sql = "select coalesce(tb061.nu_comprobante::character varying,'')||' - '|| tb133.tx_tipo_asiento ||' - '|| to_char(tb061.created_at::date,'dd/mm/yyyy') ||' - '|| tb027.tx_tipo_solicitud||'('||tb029.tx_estatus||') - '||coalesce(tx_serial,'')||' - '||tb061.co_solicitud as descripcion,
mo_debe,mo_haber,tb061.co_asiento_contable,tb027.tx_tipo_solicitud,to_char(tb061.created_at::date,'dd/mm/yyyy'),tb133.tx_tipo_asiento
 from tb024_cuenta_contable tb024
inner join tb061_asiento_contable tb061 on (tb061.co_cuenta_contable = tb024.co_cuenta_contable) 
inner join tb133_tipo_asiento tb133 on (tb133.co_tipo_asiento = tb061.co_tipo_asiento) 
inner join tb026_solicitud tb026 on (tb026.co_solicitud = tb061.co_solicitud)
inner join tb027_tipo_solicitud tb027 on (tb027.co_tipo_solicitud = tb026.co_tipo_solicitud)
inner join tb029_estatus tb029 on (tb029.co_estatus = tb026.co_estatus)
left join tb060_orden_pago tb060 on (tb060.co_solicitud = tb061.co_solicitud)
where tb061.created_at::date >= '".$datosSol[0]['fecha_inicio']."' and tb061.created_at::date <= '".$datosSol[0]['fecha_fin']."' and tb024.co_cuenta_contable = ".$value['co_cuenta_contable']." order by tb061.co_tipo_asiento,to_char(tb061.created_at::date,'dd/mm/yyyy'),tb061.co_solicitud";
                  
        }else{
           $conex = new ConexionComun();          
      $co_mes = $_GET['co_mes'];
    $nu_anio = $_GET['co_anio_fiscal'];          

        $sql = "SELECT (date_trunc('MONTH','".$nu_anio."-".$co_mes."-01'::date) + INTERVAL '0 MONTH + 0 day')::DATE as fecha_inicio,(date_trunc('MONTH','".$nu_anio."-".$co_mes."-01'::date) + INTERVAL '1 MONTH - 1 day')::DATE as fecha_fin";

        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
    

                  $sql = "select distinct tb061.co_tipo_asiento,tb061.co_solicitud,coalesce(tb061.nu_comprobante::character varying,'')||' - '|| tb133.tx_tipo_asiento ||' - '|| to_char(tb061.created_at::date,'dd/mm/yyyy') ||' - '|| tb027.tx_tipo_solicitud||'('||tb029.tx_estatus||') - '||coalesce(tx_serial,'')||' - '||tb061.co_solicitud as descripcion,
mo_debe,mo_haber,tb061.co_asiento_contable,tb027.tx_tipo_solicitud,to_char(tb061.created_at::date,'dd/mm/yyyy'),tb133.tx_tipo_asiento
 from tb179_resumen_mensual_contable tb179
inner join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb179.co_cuenta_contable)
inner join tb061_asiento_contable tb061 on (tb061.co_cuenta_contable = tb024.co_cuenta_contable) 
inner join tb133_tipo_asiento tb133 on (tb133.co_tipo_asiento = tb061.co_tipo_asiento) 
inner join tb026_solicitud tb026 on (tb026.co_solicitud = tb061.co_solicitud)
inner join tb027_tipo_solicitud tb027 on (tb027.co_tipo_solicitud = tb026.co_tipo_solicitud)
inner join tb029_estatus tb029 on (tb029.co_estatus = tb026.co_estatus)
left join tb060_orden_pago tb060 on (tb060.co_solicitud = tb061.co_solicitud)
where tb061.created_at::date >= '".$datosSol[0]['fecha_inicio']."' and tb061.created_at::date <= '".$datosSol[0]['fecha_fin']."' and tb179.co_cuenta_contable = ".$value['co_cuenta_contable']."  order by tb061.co_tipo_asiento,to_char(tb061.created_at::date,'dd/mm/yyyy'),tb061.co_solicitud";
        }                  
                  
           //echo var_dump($sql); exit();  
          $Movimientos = $conex->ObtenerFilasBySqlSelect($sql); 
          $mo_debe =0;
          $mo_haber =0;
          foreach ($Movimientos as $key => $value1) {
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value1['descripcion'], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value1['mo_debe'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value1['mo_haber'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        
        $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount.':F'.$rowCount)->getFont()->setBold(true);    
        $rowCount++;
        $mo_debe =  $mo_debe + $value1['mo_debe'];
        $mo_haber =  $mo_haber + $value1['mo_haber'];
          }
          if($Movimientos){
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, 'TOTAL', PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $mo_debe, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $mo_haber, PHPExcel_Cell_DataType::TYPE_NUMERIC);
          $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $mo_debe-$mo_haber, PHPExcel_Cell_DataType::TYPE_NUMERIC);
          $objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount.':F'.$rowCount)->getFont()->setBold(true);
          $rowCount++;
          }
    }
    
    

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="Analitico_cuenta_dt'.date("d-m-Y").'.xlsx"');
    $objWriter->save('php://output');

?>