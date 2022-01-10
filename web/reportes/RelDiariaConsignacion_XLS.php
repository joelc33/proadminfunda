<?php
include("ConexionComun.php");

require_once '../../plugins/reader/Classes/PHPExcel/IOFactory.php';

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Yoser Perez");
    $objPHPExcel->getProperties()->setTitle("RELACION DIARIA DE CONSIGNACION");
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
    $objPHPExcel->getActiveSheet()->setTitle('CONSIGNACION DIARIA');
    // Initialise the Excel row number
    // Iterate through each result from the SQL query in turn
    // We fetch each database result row into $row in turn

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Documento')
    ->setCellValue('B1', 'Sol.')
    ->setCellValue('C1', 'OP')
    ->setCellValue('D1', 'Proveedor')
    ->setCellValue('E1', 'Concepto')
    ->setCellValue('F1', 'Fecha')
    ->setCellValue('G1', 'Monto Dcto.');

    // Make bold cells
    $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

    //var_dump($sql); exit();
    $rowCount = 2;

    $lista_proveedores = getProveedor();

    //var_dump($lista_proveedores); exit();
    
    foreach($lista_proveedores as $key => $campo){
        //Set cell An to the "name" column from the database (assuming you have a column called name)
        //where n is the Excel row number (ie cell A1 in the first row)
//        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':A'.$rowCount)->getFont()->setBold(true);
//        $objPHPExcel->setActiveSheetIndex(0)
//        ->setCellValue('A'.$rowCount, 'Proveedor');

        //$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $campo['nu_codigo'].'-'.$campo['tx_razon_social'], PHPExcel_Cell_DataType::TYPE_STRING);

        if($_GET["co_tipo"]){
            $doc= getDoc();
            $documento=$doc[0]['tx_tipo_solicitud'];
        }else{
            $documento="TODOS DOCUMENTOS";
        }

        $rowCount++;
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':A'.$rowCount)->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$rowCount, 'Documento');
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $documento, PHPExcel_Cell_DataType::TYPE_STRING);
        //Increment the Excel row counter
        $rowCount++;

        $lista_documentos = getDocumento($campo['co_proveedor']);             
         
        $subtotal_monto = 0;
        $subtotal_saldo = 0;

        foreach($lista_documentos as $key => $campo2){

          $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $campo2['documento'], PHPExcel_Cell_DataType::TYPE_STRING);
          $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $campo2['co_solicitud'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
          $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $campo2['tx_serial'], PHPExcel_Cell_DataType::TYPE_STRING);
          $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $campo2['tx_razon_social'], PHPExcel_Cell_DataType::TYPE_STRING);
          $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $campo2['tx_observacion'], PHPExcel_Cell_DataType::TYPE_STRING);
          $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $campo2['fecha'], PHPExcel_Cell_DataType::TYPE_STRING);
          $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $campo2['monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);

          $rowCount++;

        }

    }       

    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="rel_diaria_consignacion_'.date("d-m-Y").'.xlsx"');
    $objWriter->save('php://output');

    function getProveedor(){
        
    $condicion ="";
    $condicion .= " and tb063.fe_pago >= '". $_GET["fe_inicio"]."' and ";
    $condicion .= " tb063.fe_pago <= '".$_GET["fe_fin"]."' ";  
    if ($_GET["cod_prov"]) $condicion .= " and tb008.nu_codigo = '".$_GET["cod_prov"]."' "; 
  
    if ($_GET["co_tipo"]) $condicion .= " and tb026.co_tipo_solicitud = ".$_GET["co_tipo"]; 

          $conex = new ConexionComun();     
          
//          $sql = "SELECT distinct 
//                    tb008.co_proveedor, tb008.tx_razon_social, tb008.nu_codigo
//                  FROM tb060_orden_pago as tb060
//                  left join tb026_solicitud as tb026 on tb026.co_solicitud = tb060.co_solicitud
//                  left join tb008_proveedor as tb008 on tb026.co_proveedor = tb008.co_proveedor
//                  left join tb027_tipo_solicitud as tb027 on tb027.co_tipo_solicitud = tb026.co_tipo_solicitud
//                  where tb060.in_anulado<>true and tb008.co_proveedor is not null and tb060.fe_pago is not null
//                 $condicion  ";          
          
          $sql = "SELECT distinct tb008.co_proveedor, tb008.tx_razon_social, tb008.nu_codigo
                FROM tb026_solicitud as tb026
                left join tb008_proveedor as tb008 on tb026.co_proveedor = tb008.co_proveedor 
                left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud 
                left join tb063_pago as tb063 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago 
                where tb062.in_anular is not true and tb008.co_proveedor is not null
                 $condicion  ";
                   
           //echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }        
        function getDoc(){
       
              $conex = new ConexionComun();     
              $sql = " SELECT upper(tb027.tx_tipo_solicitud) as tx_tipo_solicitud FROM tb027_tipo_solicitud as tb027 where tb027.co_tipo_solicitud =".$_GET["co_tipo"];
                       
            //   echo var_dump($sql); exit();
              $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
              return  $datosSol;  
        
        } 
    function getDocumento($prov){
        
    $condicion ="";
    $condicion .= " and tb063.fe_pago >= '". $_GET["fe_inicio"]."' and ";
    $condicion .= " tb063.fe_pago <= '".$_GET["fe_fin"]."' ";  
    if ($_GET["cod_prov"]) $condicion .= " and tb008.nu_codigo = '".$_GET["cod_prov"]."' "; 
  
    if ($_GET["co_tipo"]) $condicion .= " and tb026.co_tipo_solicitud = ".$_GET["co_tipo"]; 

          $conex = new ConexionComun();     
//          $sql = "SELECT distinct 
//                    coalesce(tb060.tx_documento_odp,tb060.tx_documento_odp,tb060.tx_serial) as documento,
//                    tb008.co_proveedor, tb008.tx_razon_social, tb026.co_solicitud,
//                    tb008.nu_codigo, to_char(tb060.fe_pago,'dd/mm/yy') as fecha, 
//                    substring(tb026.tx_observacion,1,30) as tx_observacion, tb060.tx_serial,
//                    tb060.mo_total as monto
//                  FROM tb060_orden_pago as tb060
//                  left join tb026_solicitud as tb026 on tb026.co_solicitud = tb060.co_solicitud
//                  left join tb008_proveedor as tb008 on tb026.co_proveedor = tb008.co_proveedor
//                  left join tb027_tipo_solicitud as tb027 on tb027.co_tipo_solicitud = tb026.co_tipo_solicitud
//                  where tb060.in_anulado<>true and tb008.co_proveedor is not null and tb060.fe_pago is not null
//                  and tb008.co_proveedor = $prov $condicion order by 5";
          
          
          $sql = "SELECT distinct coalesce(tb060.tx_documento_odp,tb060.tx_documento_odp,tb060.tx_serial) as documento, tb008.co_proveedor, tb008.tx_razon_social, tb026.co_solicitud, tb008.nu_codigo, 
                    to_char(tb063.fe_pago,'dd/mm/yy') as fecha, substring(tb026.tx_observacion,1,30) as tx_observacion, tb060.tx_serial, tb063.nu_monto as monto
                    FROM tb026_solicitud as tb026
                    left join tb008_proveedor as tb008 on tb026.co_proveedor = tb008.co_proveedor 
                    left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud 
                    left join tb063_pago as tb063 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago 
                    left join tb060_orden_pago as tb060 on tb060.co_solicitud = tb026.co_solicitud 
                    where tb062.in_anular is not true and tb008.co_proveedor is not null
                    and tb063.fe_pago is not null and tb008.co_proveedor = $prov $condicion order by 6";          
                  
          //echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }

?>