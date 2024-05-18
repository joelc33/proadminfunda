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
                ->setCellValue('A1', 'UNIDAD EJECUTORA CEDENTE')
                ->setCellValue('B1', 'Nro')
                ->setCellValue('C1', 'FECHA')
                ->setCellValue('D1', 'MONTO')
                ->setCellValue('E1', 'UNIDAD RECEPTORA DESTINO');

         $rowCount = 2;
   
        $lista_traspasos = getListaTraspasos();         
        foreach($lista_traspasos as $key => $valor){

            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J1'.$rowCount)->getFont()->setBold(false);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, utf8_decode($valor['ue_cedente']), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, utf8_decode($valor['num']), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $valor['fecha'], PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $valor['monto'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, utf8_decode($valor['ue_receptor']),PHPExcel_Cell_DataType::TYPE_STRING);
            // Increment the Excel row counter
            $rowCount++;

        }
         

    
   
    function getListaTraspasos(){

        $condicion ="";  
        if ($_GET["fe_inicio"])
        $condicion .= " and tb097.created_at >= '". $_GET["fe_inicio"]."' ";
        if ($_GET["fe_fin"])
        $condicion .= " and tb097.created_at <= '".$_GET["fe_fin"]."' ";
        

          $conex = new ConexionComun();     
          $sql = "SELECT tb082_cedente.de_ejecutor as ue_cedente, 
                        tb082_receptora.de_ejecutor as ue_receptor,
                        tb096.nu_modificacion as num, 
                        to_char(tb097.created_at,'dd/mm/yyyy') as fecha,
                        sum(mo_distribucion) as monto
                  FROM tb097_modificacion_detalle as tb097          
                  left join tb082_ejecutor as tb082_cedente on tb082_cedente.id  = tb097.id_tb082_ejecutor_origen
                  left join tb082_ejecutor as tb082_receptora on tb082_receptora.id  = tb097.id_tb082_ejecutor_destino
                  left join tb096_presupuesto_modificacion as tb096 on tb096.id  = tb097.id_tb096_presupuesto_modificacion
                  where tb096.id_tb095_tipo_modificacion=1 $condicion
                  group by 1, 2, 3, 4 order by 3, 4, 1 asc";

            //var_dump($sql); exit();
                        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }    
    
   
   
    // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    // We'll be outputting an excel file
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // It will be called file.xls
    header('Content-Disposition: attachment; filename="presupuesto_traspaso_'.date("H:i:s").'.xlsx"');
    $objWriter->save('php://output');

?>