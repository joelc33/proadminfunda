<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {
        $this->empresa = $this->getDatosEmpresa(1);
        $this->SetFont('courier','B',12);
        $this->Cell(0,0,utf8_decode($this->empresa['nb_empresa']),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode($this->empresa['nb_institucion']),0,0,'L');
        $this->Ln(4);
        //$this->Cell(0,0,utf8_decode('[FBANR018]'),0,0,'L');
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
         $this->SetWidths(array(200));         
         $this->SetAligns(array("C")); 
         $this->SetFont('courier','B',9);         
         $this->Row(array(utf8_decode('RELACIÓN DE PAGOS DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
         $this->Ln(2);
         
         $this->SetFont('Arial','',7);     
         $this->SetWidths(array(20,18,15,105,20,20)); 
         $this->SetAligns(array("C","C","C","L","R","R"));   
         $this->Row(array(utf8_decode('Nº Egreso'),'Orden de Pago','Fecha','Beneficiario', 'Monto OP','Monto Pagado'),0,0);            
         $this->Line(10, 45, 210, 45);        
         $this->Ln(2);
         $mo_total=0;
         $tx_serial='';
         $mo_total_op=0;
                $this->lista_pagos = $this->getPagos();             
         
                foreach($this->lista_pagos as $key => $campo){              

                        if($this->getY()>230)
                        {	
                        $this->addPage();
                        $this->Ln(6);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("C")); 
                        $this->SetFont('courier','B',9);         
                        $this->Row(array(utf8_decode('RELACIÓN DE TODOS LOS CHEQUES PARA ENTIDADES BANCARIAS DEL  '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
                        $this->Ln(2);

                         $this->SetFont('Arial','',7);     
                         $this->SetWidths(array(20,18,15,105,20,20)); 
                         $this->SetAligns(array("C","C","C","L","R","R"));   
                         $this->Row(array(utf8_decode('Nº Egreso'),'Orden de Pago','Fecha','Beneficiario', 'Monto OP','Monto Pagado'),0,0);            
                         $this->Line(10, 45, 210, 45);      
                        $this->Ln(2);
                        $mo_total=0;
                        } 
                        $this->SetFont('Arial','',6);  
                        $this->SetWidths(array(20,18,15,105,20,20));   
                        $this->SetAligns(array("C","C","C","L","R","R")); 
                        $this->Row(array($campo['tx_serial_pago'],$campo['tx_serial'],$campo['fe_pago'],utf8_decode($campo['beneficiario']),number_format($campo['mo_total'], 2, ',','.'),number_format($campo['nu_monto'], 2, ',','.')),0,0);         

                        $mo_total = $campo['nu_monto'] + $mo_total;
                        
                        if($tx_serial==$campo['tx_serial']){
                        
                                               
                        }else{
                        $mo_total_op = $campo['mo_total'] + $mo_total_op;    
                        }
                        $tx_serial = $campo['tx_serial'];
                 }
                 
        
         $this->Ln(10);
         $y = $this->getY();
         $this->Line(180, $y, 210, $y);         
         $this->SetFont('Arial','B',6);  
         $this->SetAligns(array("R","R","R","R"));
         $this->SetWidths(array(160,20,20));
         $this->Row(array(utf8_decode('TOTAL ..: '),number_format($mo_total_op, 2, ',','.'),number_format($mo_total, 2, ',','.')),0,0);         
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
   

    function getPagos(){

        $condicion ="";    
        $condicion .= " tb063.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb063.fe_pago <= '".$_GET["fe_fin"]."' ";
          $conex = new ConexionComun();     
        $sql = "SELECT tb060.co_solicitud,tb060.tx_serial, to_char(tb063.fe_pago, 'DD/MM/YYYY') as fe_pago,inicial||tx_rif||'-'||tx_razon_social as beneficiario,
        tb060.mo_total,tb063.nu_monto,tb062.tx_serial as tx_serial_pago    
        FROM tb063_pago as tb063
        inner join tb062_liquidacion_pago as tb062 ON tb063.co_liquidacion_pago = tb062.co_liquidacion_pago
        inner join tb060_orden_pago as tb060 ON tb062.co_odp = tb060.co_orden_pago
        inner join tb026_solicitud as tb026 on tb060.co_solicitud = tb026.co_solicitud
        inner join tb008_proveedor as tb008 on tb026.co_proveedor = tb008.co_proveedor
        inner join tb007_documento as tb007 on tb008.co_documento = tb007.co_documento
        WHERE ".$condicion." and tb060.in_anular is not true
        order by tb060.tx_serial ASC;";
                  
          //echo var_dump($sql); exit();
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
