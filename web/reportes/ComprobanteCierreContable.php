<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {


        $this->Image("imagenes/escudosanfco.png", 100, 7,20);

        $this->SetFont('Arial','B',10);
        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('<NOMBRE DE LA INSTITUCION>'),0,0,'C');
        //$this->Ln(6);
        //$this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACION Y FINANZAS'),0,0,'C');
        $this->Ln(8);
        $this->SetFont('Arial','B',12);        
        $this->Cell(0,0,utf8_decode('COMPROBANTE DE CIERRE CONTABLE'),0,0,'C');      

        $this->Ln(5);

        $this->SetFont('Arial','B',9);     
	
        $this->Ln(5);
        $this->SetTextColor(0,0,0);
        $this->SetX(1);
     

    }

    function Footer() {
	$this->SetFont('Arial','',9);     
	$this->SetY(-20);                
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

         $this->Ln(1);
                          
         $this->AddPage();  
         $this->SetFont('Arial','',8);
         //$this->comprobante = $this->getComprobante();
         $this->campo = $this->getComprobante(); 
//         var_dump($this->campo['dia']);
//         exit();
         $this->Cell(0,0,utf8_decode('Maracaibo, '.$this->campo['dia'].' de '.mes($this->campo['mes']).' del '.$this->campo['anio']),0,0,'R');
         $this->SetFont('Arial','B',9);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(60,140));
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetY(65);         
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('COMPROBANTE Nro.'.$this->campo['nu_comprobante'])),1,1);
         $this->SetFont('Arial','',9); 
         $this->SetFillColor(255, 255, 255);
         
         $this->SetWidths(array(200,60,55,20,25)); 
         $this->SetAligns(array("L","L","L","L","L","L"));
         $this->Row(array('Periodo: '.mes($this->campo['mes'])),1,1);
//         $this->Ln(5);
//         $this->MultiCell(200,14,utf8_decode('Descripción: '.$this->campo['descripcion']),1,1,'L',1);
//         $this->Ln(5);
         $this->Row(array(utf8_decode('Descripción: '.$this->campo['descripcion'])),1,1);
         
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Arial','B',9);          
         $this->Row(array(utf8_decode('RELACIÓN DEL COMPROBANTE')),1,1);
         $this->SetFont('Arial','',9); 
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(40,100,30,30)); 
         $this->SetAligns(array("C","C","C","C"));       
         $this->Row(array('CUENTA','DENOMINACION','DEBITOS','CREDITOS'),1,1);          
         $total_debe = 0;
         $total_haber = 0;
         $this->lista_comprobante = $this->getDetalleComprobante($this->campo['nu_comprobante']);
         foreach($this->lista_comprobante as $key => $valor){
                if($this->getY()>230)
                {	
                 $this->addPage();
         $this->Cell(0,0,utf8_decode('Maracaibo, '.$this->campo['dia'].' de '.mes($this->campo['mes']).' del '.$this->campo['anio']),0,0,'R');
         $this->SetFont('Arial','B',9);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(60,140));
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetY(65);         
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('COMPROBANTE Nro.'.$this->campo['nu_comprobante'])),1,1);
         $this->SetFont('Arial','',9); 
         $this->SetFillColor(255, 255, 255);
         
         $this->SetWidths(array(200,60,55,20,25)); 
         $this->SetAligns(array("L","L","L","L","L","L"));
         $this->Row(array('Periodo: '.mes($this->campo['mes'])),1,1);
//         $this->Ln(5);
//         $this->MultiCell(200,14,utf8_decode('Descripción: '.$this->campo['descripcion']),1,1,'L',1);
//         $this->Ln(5);
         $this->Row(array(utf8_decode('Descripción: '.$this->campo['descripcion'])),1,1);
         
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Arial','B',9);          
         $this->Row(array(utf8_decode('RELACIÓN DEL COMPROBANTE')),1,1);
         $this->SetFont('Arial','',9); 
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(40,100,30,30)); 
         $this->SetAligns(array("C","C","C","C"));       
         $this->Row(array('CUENTA','DENOMINACION','DEBITOS','CREDITOS'),1,1); 
                }             

         $this->SetFont('Arial','',8); 
         $this->SetAligns(array("L","L","R","R"));
         $this->Row(array($valor['tx_cuenta'],utf8_decode($valor['tx_descripcion']),number_format($valor['mo_debe'], 2, ',','.'),number_format($valor['mo_haber'], 2, ',','.')),1,1);  
         $total_debe = $total_debe + $valor['mo_debe'];
         $total_haber = $total_haber + $valor['mo_haber'];
         
         }
         $this->SetFont('Arial','B',9); 
         $this->SetAligns(array("L","R","R","R"));
          $this->Row(array('',utf8_decode("TOTAL"),number_format($total_debe, 2, ',','.'),number_format($total_haber, 2, ',','.')),1,1);
          $this->ln(8);
	 $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(65,70,65));
         $this->SetAligns(array("L","L","L","R"));
         $this->SetFont('Arial','B',8);
         $Y = $this->GetY();
         $this->MultiCell(65,20,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(75);
         $this->MultiCell(70,20,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(145);
         $this->MultiCell(65,20,'',1,1,'L',1);
         $this->SetY($Y+5);
         $this->SetFont('Arial','',6);
         $this->ln(15);
         $this->Row(array('Solicitado por:','Creado por:', 'Aprobado por:'),1,1);      
         //$this->Cell(0,0,utf8_decode('Usuario del sistema: '.utf8_decode($this->campo['nb_usuario'])),0,0,'L');
         $this->ln();
	 $this->SetY($this->GetY()+5);
         $this->Cell(0,0,utf8_decode(''),0,0,'L');      

       

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
        //$this->AddPage();
        $this->ChapterBody();
    }

    function getComprobante(){

          $conex = new ConexionComun();               
          $sql = "select
                 to_char(tb200.fecha,'dd/mm/yyyy') as fecha,
                 to_char(tb200.fecha,'dd') as dia,
                 to_char(tb200.fecha,'mm') as mes,
                 to_char(tb200.fecha,'yyyy') as anio,
                 nu_comprobante,descripcion
                  FROM tb200_cierre_contable as tb200                                                 
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb200.co_solicitud 
                  where tb200.in_rechazado = false and tb030.co_ruta = ".$_GET['codigo']." limit 1";
//          var_dump($sql)  ;
//          exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];   
         
         
    }
    
    function getDetalleComprobante($nu_comprobante){

          $conex = new ConexionComun();               
          $sql = "select tx_cuenta,tx_descripcion,mo_debe,mo_haber
                  FROM tb200_cierre_contable as tb200                                                 
                  left join tb024_cuenta_contable as tb024 on tb024.co_cuenta_contable = tb200.co_cuenta_contable 
                  where tb200.nu_comprobante = $nu_comprobante";
//          var_dump($sql)  ;
//          exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;   
         
         
    }    

}



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


//$pdf=new PDF('P','mm','letter');
//$pdf->PrintChapter();
//$pdf->SetDisplayMode('default');
//$pdf->Output();

?>