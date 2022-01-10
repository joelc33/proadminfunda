<?php

    include("ConexionComun.php");
    include("PDFMerger.php");

    $pdf = new \PDFMerger\PDFMerger();

    $conex = new ConexionComun();     
    $sql = "select tx_ruta_reporte
              from   tb030_ruta as tb030 
              where tb030.co_solicitud = ".$_GET['co_solicitud'];

    $datosSol = $conex->ObtenerFilasBySqlSelect($sql);

    foreach($datosSol as $key => $campo){                    
          $pdf->addPDF($campo["tx_ruta_reporte"], 'all');
    }

    $pdf->merge('browser');
	
	//REPLACE 'file' WITH 'browser', 'download', 'string', or 'file' for output options
	//You do not need to give a file path for browser, string, or download - just the name.
?>

