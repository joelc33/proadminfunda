<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {
        $this->SetFont('courier','B',12);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'L');
        $this->SetFont('courier','',8);
        //$this->Ln(4);
        //$this->Cell(0,0,utf8_decode('Secretaria de Administración'),0,0,'L');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('[FCPPRA43]'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
//        $this->Cell(0,0,utf8_decode('San Francisco, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');                          
    }

    function Footer() {
	$this->SetFont('courier','B',9);     
	$this->SetY(250);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');       
    }

    function dwawCell($title,$data) {
        $width = 8;
        $this->SetFont('Arial','B',12);
        $y =  $this->getY() * 20;
        $x =  $this->getX();
        $this->SetFillColor(206,230,100);
        $this->MultiCell(175,8,$title,0,1,'L',0);
        $this->SetY($y);
        $this->SetFont('Arial','',12);
        $this->SetFillColor(206,230,172);
        $w=$this->GetStringWidth($title)+3;
        $this->SetX($x+$w);
        $this->SetFillColor(206,230,172);
        $this->MultiCell(175,8,$data,0,1,'J',0);

    }

    function ChapterBody() {
        
         $this->Ln(6);
         $this->SetWidths(array(150));
         $this->SetX(30);
         $this->SetAligns(array("C")); 
         $this->SetFont('courier','B',12);         
         $this->Row(array(utf8_decode('LISTA DE ORDENES DE PAGO DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
         $this->Ln(2);
         $this->SetFillColor(255, 255, 255); 
         
         $this->lista_op = $this->getOP();
      
         $this->SetFont('COURIER','',10);     
         $this->SetWidths(array(30,80,25,25,40));
         $this->SetAligns(array("C","C","C","C","R"));    
         $this->Row(array(utf8_decode('Número OP'),'Beneficiario','Estado', 'Fecha', 'Monto OP'),0,0); 
         $this->SetAligns(array("C","C","C","C","R"));   
         $this->Line(10, 40, 210, 40);        
         $this->Ln(5);
         $total = 0;
         $total_anuladas = 0;
         $total_otras = 0;
         foreach($this->lista_op as $key => $campo){              
             
                if($this->getY()>230)
                {	
                $this->addPage();
                $this->Ln(6);
                $this->SetX(10);                
                $this->SetFont('COURIER','',10);     
                $this->SetWidths(array(30,80,25,25,40));
                $this->SetAligns(array("C","C","C","C","R"));   
                $this->Row(array(utf8_decode('Número OP'),'Beneficiario','Estado', 'Fecha', 'Monto OP'),0,0);                      
                $this->Line(10, 35, 210, 35);                 
                $this->Ln(5);
                } 
                // echo var_dump($campo); exit();
                $this->SetFont('COURIER','',10);  
                $this->SetWidths(array(30,80,25,25,40));
                $this->SetAligns(array("C","L","C","C","R"));  
                $this->Row(array($campo['tx_serial'],$campo['beneficiario'], $campo['estatus'],date("d/m/Y", strtotime($campo['fecha'])),number_format($campo['monto'], 2, ',','.')),0,0);         
         
                $total = $total + $campo['monto'];
                
                if($campo['estatus']=='Anulada'){
                $total_anuladas = $total_anuladas + $campo['monto'];
                }else{
                $total_otras = $total_otras + $campo['monto'];    
                }                
                
                }
                $this->SetFont('COURIER','',10);  
                $this->SetWidths(array(30,80,25,25,40));
                $this->SetAligns(array("C","L","C","R","R"));  
                $this->Row(array('','', '','TOTAL',number_format($total, 2, ',','.')),0,0);
                $this->Ln(5);
                $this->Row(array('TOTAL ANULADAS',number_format($total_anuladas, 2, ',','.')),0,0);
                $this->Ln(5);
                $this->Row(array('TOTAL APROBADAS',number_format($total_otras, 2, ',','.')),0,0);
                  

   }

    function ChapterTitle($num,$label) {
        $this->SetFont('Arial','',10);
        $this->SetFillColor(200,220,255);
        $this->Cell(0,6,"$label",0,1,'L',1);
        $this->Ln(8);
    }

    function SetTitle($title) {
        $this->title   = $title;
    }

    function PrintChapter() {
        $this->AddPage();
        $this->ChapterBody();
    }
    
    function getOP(){ 

        $conex = new ConexionComun(); 
        
        $condicion ="";
        if ($_GET["co_tipo"]) $tipo  = $_GET['co_tipo'];  
        else $tipo  = '';
       
        $condicion .= " tb060.created_at::date >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb060.created_at::date <= '".$_GET["fe_fin"]."' ";
        
        if ($tipo==1) $condicion .= " and tb060.in_anulado = FALSE ";        
        if ($tipo==2)  $condicion .= " and tb060.in_anulado = TRUE ";         
        
        $sql = "  select distinct tb060.tx_serial, tb060.co_solicitud, 
                        case when(tb060.co_solicitud is not null) then prov1.tx_razon_social 
                        else prov2.tx_razon_social end as beneficiario , tb060.created_at as fecha , 
                        case when tb060.in_anulado = true then 'Anulada' else 
                        case when tb060.in_pagado = true then 'Pagada' else 'Pendiente' end end as estatus, 
                        tb060.mo_total as monto 
                  from tb060_orden_pago tb060 
                        left join tb026_solicitud as tb026 on (tb026.co_solicitud=tb060.co_solicitud) 
                        left join tb008_proveedor as prov1 on (tb026.co_proveedor=prov1.co_proveedor) 
                        left join tb008_proveedor as prov2 on (tb060.co_prov_opanulada=prov2.co_proveedor) 
                  where tb060.tx_serial<>'' and ".$condicion." 
                  order by tb060.tx_serial ";  
           
        // echo $sql; exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }   

}
/*
$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();
$pdf->PrintChapter();

$comm = new ConexionComun();
$ruta = $comm->getRuta();

//rmdir($ruta);
//mkdir($ruta, 0777, true);    

$dir="$ruta".$_GET["codigo"].".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";


$update = "update tb030_ruta set tx_ruta_reporte = '".$dir."' where co_ruta = ".$_GET['codigo']; //$comm->decrypt($_GET["codigo"]);

//echo $update; exit();
$comm->Execute($update);    

$pdf->Output($dir, 'F');
*/

$pdf=new PDF('P','mm','letter');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>