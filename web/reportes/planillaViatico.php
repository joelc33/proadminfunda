<?php
include("ConexionComun.php");
require('flowing_block.php');


class PDF_Flo extends PDF_FlowingBlock
{
   

    function ChapterBody() {
        $this->Image("imagenes/escudosanfco.png", 100, 7,20);

        $this->SetFont('Arial','B',8);

        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'),0,0,'C');
        $this->Ln(4);
        $this->SetX(25);       
        $this->Cell(0,0,utf8_decode('[FSV-SAF-16]'),0,0,'L');  
         $this->Ln(6);
        $this->SetFont('Arial','B',14);        

         $this->datos = $this->getSolicitudViatico(); 
        // echo var_dump($this->datos['co_viatico']);         exit();
         $this->SetFont('Arial','B',14);
         $this->Cell(0,0,utf8_decode('PLANILLA DE VIATICOS'),0,0,'C');
        
    
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);         
         $this->SetWidths(array(30,140));
         $this->SetAligns(array("L", "L"));
         $this->SetY(55);
         $this->SetFillColor(201, 199, 199);
         $this->SetX(25);            
         $this->Row(array('PV-'.date('Y').'-'.$this->datos['co_viatico'], utf8_decode('DATOS DE LA SOLICITUD')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(85,85));         
         $this->SetFont('Arial','',9);
         $this->SetX(25);          
         $Y = $this->GetY();
         $this->MultiCell(170,24,'',1,1,'L',1); 
   
         /*******************************************/
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "FECHA SOLICITUD: ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', '', 9 );
         $data = date("d/m/Y", strtotime($this->datos['fecha']));
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();           
         
         /*******************************************/
         $this->newFlowingBlock(85, 8, '', 'J' );         
         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "SOLICITANTE: ";
         $this->WriteFlowingBlock(utf8_decode($data));         
         $this->SetY($Y);
         $this->SetX(95);           
         $this->SetFont( 'Arial', '', 9 );
         $data = utf8_decode($this->datos['tx_razon_social']);
         $this->WriteFlowingBlock(utf8_decode($data)); 
         $this->finishFlowingBlock();
         $Y = $this->GetY();
         
         /*******************************************/
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "C.I./R.I.F.: ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', '', 9 );
         $data = utf8_decode($this->datos['tx_rif']);
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();         
         
         /*******************************************/
         $this->newFlowingBlock(85, 8, '', 'J' );         
         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "ORGANISMO / UNIDAD:  ";
         $this->WriteFlowingBlock(utf8_decode($data));         
         $this->SetY($Y);
         $this->SetX(95);           
         $this->SetFont( 'Arial', '', 9 );
         $data = utf8_decode($this->datos['tx_ente']);
         $this->WriteFlowingBlock(utf8_decode($data)); 
         $this->finishFlowingBlock();
         $Y = $this->GetY();
         
         /*******************************************/  
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "CARGO: ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', '', 9 );
         $data = utf8_decode($this->datos['tx_cargo']);
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();         
         
         /*******************************************/
         $this->newFlowingBlock(85, 8, '', 'J' );         
         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "CATEGORIA: I ";  
         $this->WriteFlowingBlock(utf8_decode($data));         
         $this->SetY($Y+2);
         $this->SetX(119);           
         $this->SetWidths(array(5));
         $this->MultiCell(3,3,'',1,1,'L',1);          
         $this->SetY($Y);
         if ($this->datos['co_categoria']  == 1)  $data = 'X'; else $data = '  ';           
         $this->SetFont( 'Arial', 'B', 10 );
         $this->SetX(95);
         $this->WriteFlowingBlock(utf8_decode($data)); 
         
         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "   - II ";  
         $this->WriteFlowingBlock(utf8_decode($data));         
         $this->SetY($Y+2);
         $this->SetX(128);           
         $this->SetWidths(array(5));
         $this->MultiCell(3,3,'',1,1,'L',1);          
         $this->SetY($Y);
         if ($this->datos['co_categoria'] == 2)  $data = 'X'; else $data = '  ';
         $this->SetFont( 'Arial', 'B', 10 );
         $this->SetX(95);
         $this->WriteFlowingBlock(utf8_decode($data)); 
         
         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "   - III ";                   
         $this->WriteFlowingBlock(utf8_decode($data));         
         if ($this->datos['co_categoria'] == 3)  $data = 'X'; else $data = '  '; 
         $this->SetY($Y+2);
         $this->SetX(138);           
         $this->SetWidths(array(5));
         $this->MultiCell(3,3,'',1,1,'L',1);          
         $this->SetY($Y);
         $this->SetFont( 'Arial', 'B', 10 );
         $this->SetX(95);
         $this->WriteFlowingBlock(utf8_decode($data));          
         
         
         $this->finishFlowingBlock();
         $Y = $this->GetY();

         $this->SetX(25);
         $this->MultiCell(170,30,'',1,1,'L',1); 
         
         /*******************************************/    
         
         $this->newFlowingBlock(85, 8, '', 'J' );     
         
         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "DESTINO TIPO 1:  ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', '', 9 );
         $data = 'NACIONAL ';
         $this->WriteFlowingBlock(utf8_decode($data)); 
         
         $this->SetWidths(array(5));
         $this->SetY($Y+4);
         $this->SetX(71); 
         $this->MultiCell(3,3,'',1,1,'L',1);  
         
         $this->SetY($Y+2);
         if ($this->datos['co_categoria']  == 1)  $data = 'X'; else $data = '  ';           
         $this->SetFont( 'Arial', 'B', 10 );
         $this->WriteFlowingBlock(utf8_decode($data)); 
         $Y = $this->GetY();
         $this->SetX(25); 
         $this->finishFlowingBlock();     
                
         /*******************************************/  
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "ESTADO/MUNICIPIO(NACIONAL): ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', '', 9 );
         $data = '';
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();     
                           
         /*******************************************/  
         $this->ln(5);
         $this->newFlowingBlock(85, 8, '', 'J' );     
         $Y = $Y +8;
         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "DESTINO TIPO 2:  ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', '', 9 );
         $data = 'ESTADAL ';
         $this->WriteFlowingBlock(utf8_decode($data)); 
         
         $this->SetWidths(array(5));
         $this->SetY($Y+4);
         $this->SetX(71); 
         $this->MultiCell(3,3,'',1,1,'L',1);  
         
         $this->SetY($Y+2);
         if ($this->datos['co_categoria']  == 1)  $data = 'X'; else $data = '  ';           
         $this->SetFont( 'Arial', 'B', 10 );
         $this->WriteFlowingBlock(utf8_decode($data)); 
         $Y = $this->GetY();
         $this->SetX(25); 
         $this->finishFlowingBlock();     
                
         /*******************************************/  
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "TIPO DE VIATICO ESTADAL/MUNICIPIO:  ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', '', 9 );
         $data = 'ZONA A ';
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();                   
         
         $Y = $this->GetY();
       
         /*******************************************/ 
         $this->newFlowingBlock(85, 8, '', 'J' );     
         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "DESTINO TIPO 3:  ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', '', 9 );
         $data = 'INTERNACIONAL ';
         $this->WriteFlowingBlock(utf8_decode($data)); 
         
         $this->SetWidths(array(5));
         $this->SetY($Y+4);
         $this->SetX(71); 
         $this->MultiCell(3,3,'',1,1,'L',1);  
         
         $this->SetY($Y+2);
         if ($this->datos['co_categoria']  == 1)  $data = 'X'; else $data = '  ';           
         $this->SetFont( 'Arial', 'B', 10 );
         $this->WriteFlowingBlock(utf8_decode($data)); 
         $Y = $this->GetY();
         $this->SetX(25); 
         $this->finishFlowingBlock();     
                
         /*******************************************/  
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "PAIS / CIUDAD (INTERNACIONAL):  ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', '', 9 );
         $data = 'ZONA A ';
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();                   
         
         $Y = $this->GetY();

         $this->SetX(25);
         $this->MultiCell(170,30,'',1,1,'L',1);          
         /*******************************************/          
      
//         
//         
//         $this->SetAligns(array("C","C", "C"));
//	 $this->SetFillColor(201, 199, 199);
//         $this->SetWidths(array(85,85)); 
//         $this->SetX(25);          
//         $this->Row(array(utf8_decode('DATOS DEL SOLICITANTE'),utf8_decode('DATOS DEL APROBADOR')),1,1);
//         $this->SetFillColor(255, 255, 255); 
//         $this->SetAligns(array("L","L")); 
//         $Y = $this->GetY();
//         $this->SetX(25);    
//         $this->SetWidths(array(85));         
//         $this->Row(array('Nombre:','Nombre:'),0,0);
//         $this->SetX(25);         
//         $this->Row(array('C.I.:','C.I.:'),0,0);
//         $this->SetX(25);         
//         $this->Row(array('Cargo:','Cargo:'),0,0);
//         $this->SetX(25);                
//         $this->Row(array('Firma y Sello:','Firma y Sello:'),0,0);
//         $this->SetY($Y);
//         $this->SetX(25);          
//         $this->MultiCell(85,50,'',1,1,'L',1);
//         $this->SetY($Y);
//         $this->SetX(110);          
//         $this->MultiCell(85,50,'',1,1,'L',1);*/
  

    }

    function getSolicitudViatico(){

          $conex = new ConexionComun(); 
          
          $sql = "  select UPPER(tb108.tx_observacion_hospedaje) as tx_observacion_hospedaje, 
                        upper(tb108.tx_evento) as tx_evento, 
                        tb108.fe_desde, 
                        tb108.fe_hasta, 
                        upper(tb008.tx_razon_social) as tx_razon_social,
                        tb108.created_at as fecha, 
                        upper(tb047.tx_ente) as tx_ente, 
                        upper(tb110.tx_origen_viatico) as destino, 
                        upper(tb107.tx_tipo_viatico ) as tx_tipo_viatico,
                        tb008.tx_rif,
                        tb108.co_viatico,
                        tb108.co_categoria,
                        tb110c.tx_cargo
                    from tb026_solicitud as tb026 
                    left join tb108_viatico as tb108 on tb108.co_solicitud = tb026.co_solicitud 
                    left join tb107_tipo_viatico as tb107 on tb107.co_tipo_viatico = tb108.co_tipo_viatico 
                    left join tb110_origen_viatico as tb110 on tb108.co_destino = tb110.co_origen_viatico 
                    left join tb008_proveedor as tb008 on tb008.co_proveedor=tb108.co_proveedor 
                    left join tb001_usuario as tb001 on tb001.co_usuario = tb108.co_usuario
                    left join tb109_persona as tb109  on tb109.co_proveedor = tb108.co_proveedor 
                    left join tb110_cargo as tb110c on tb110c.co_cargo = tb109.co_cargo
                    left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente 
                    left join tb030_ruta as tb030 on tb030.co_solicitud = tb108.co_solicitud 
                    where tb030.co_ruta = ".$_GET['codigo']; //$conex->decrypt($_GET['codigo']);
                  
          
                   
          //echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          //echo var_dump($datosSol); exit();
          return  $datosSol[0];                    
          
          
    }
}


$pdf = new PDF_Flo('P','mm','letter');
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->ChapterBody();

$comm = new ConexionComun();
$ruta = $comm->getRuta();

//rmdir($ruta);
//mkdir($ruta, 0777, true);    

$dir="$ruta".$_GET["codigo"].".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";


$update = "update tb030_ruta set tx_ruta_reporte = '".$dir."' where co_ruta = ".$_GET['codigo']; //$comm->decrypt($_GET["codigo"]);

//echo $update; exit();
$comm->Execute($update);    

$pdf->Output($dir, 'F');

//$pdf = new PDF_Flo('P','mm','letter');
//$pdf->AddPage();
//$pdf->AliasNbPages();
//$pdf->ChapterBody();
//$pdf->SetDisplayMode('default');
//$pdf->Output();

?>
