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
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('[FCPPNO27]'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');                          
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
         $this->SetWidths(array(120));
         $this->SetX(55);
         $this->SetAligns(array("C")); 
         $this->SetFont('courier','B',12);         
         $this->Row(array(utf8_decode('RELACIÓN DE CONCEPTOS DE NOMINA CORRESPONDIENTE AL MES DE '.$_GET['mes']).' DEL '.date("Y")),0,0);
         $this->Ln(6);
         $this->SetWidths(array(200));
         $this->SetAligns(array("L"));           
         $this->SetFont('COURIER','B',8); 
         $this->SetFillColor(255, 255, 255); 
         
         $this->lista_nomina = $this->getConcpNomina();
      
         $this->SetFont('COURIER','',10);     
         $this->SetWidths(array(40,100,60));  
         $this->SetAligns(array("C","C","R"));   
         $this->Row(array('Concepto',utf8_decode('Descripción'),'Monto'),0,0); 
         $this->SetAligns(array("C","L","R")); 
         $this->Line(10, 45, 210, 45);        
         $this->Ln(2);
         $mo_concep = 0;
        
         foreach($this->lista_nomina as $key => $campo){              
             
                if($this->getY()>230)
                {	
                $this->addPage();
                $this->Ln(6);
                $this->SetWidths(array(150));
                $this->SetX(30);
                $this->SetAligns(array("C")); 
                $this->SetFont('courier','B',12);         
                $this->Row(array(utf8_decode('RELACIÓN DE NOMINAS CORRESPONDIENTE AL MES DE '.$_GET['mes']).' DEL '.date("Y")),0,0);
                $this->Ln(2);
                $this->SetWidths(array(200));
                $this->SetAligns(array("L"));           
                $this->SetFont('COURIER','B',10); 
                $this->SetFillColor(255, 255, 255);                 
                $this->SetFont('COURIER','',10);     
                $this->SetWidths(array(40,100,60));  
                $this->SetAligns(array("C","C","R"));   
                $this->Row(array('Concepto',utf8_decode('Descripción'),'Monto'),0,0); 
                $this->SetAligns(array("C","L","R")); 
                $this->Line(10, 65, 210, 65);        
                $this->Ln(2);
                $mo_total_op = 0;
                $mo_total_ded = 0;
                } 
                $this->SetFont('COURIER','',10);  
                $this->SetAligns(array("C","L","R")); 
                $this->Row(array($campo['co_pago_nomina'],$campo['tx_concepto'],number_format($campo['mo_total'], 2, ',','.')),0,0);         
             
                $mo_concep = $campo['mo_total'] + $mo_concep;
                
         }
         
         $this->Ln(10);
         $y = $this->getY();
         $this->Line(160, $y, 210, $y);         
         $this->SetFont('COURIER','B',11);  
         $this->SetAligns(array("R","R","R","R"));
         $this->SetWidths(array(140,60));
         $this->Row(array(utf8_decode('TOTAL RELACIÓN...: '),number_format($mo_concep, 2, ',','.')),0,0);         
         
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
    function getConcpNomina(){ 
        
        $mes = $_GET["mes"];
        $mes = '08';
        $condicion ="";
        $nu_ejecutor = $_GET['nu_ejecutor'];
  
        $condicion .= " to_char(tb122.fe_pago,'mm') = '". $mes."' ";
        if ($_GET["nu_ejecutor"]) $condicion .= " and tb122.co_ejecutor = '".$nu_ejecutor."'";
       
            
        $conex = new ConexionComun(); 
                  $sql = " SELECT tb122.co_pago_nomina , tb122.tx_concepto, 
                                tb122.fe_pago, tb122.mo_total
                           FROM tb122_pago_nomina as tb122
                           left join tb120_tipo_trabajador as tb120  on tb122.co_tipo_trabajador = tb120.co_tipo_trabajador
                           left join tb121_tipo_nomina as tb121  on tb121.co_tipo_nomina = tb122.co_tipo_nomina                            
                            where ".$condicion." ";      
           
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
