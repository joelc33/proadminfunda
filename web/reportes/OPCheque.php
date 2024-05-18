<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {
     $this->SetFont('courier','B',12);
     
    }

    function Footer() {
	$this->SetFont('Arial','',9);     
	$this->SetY(-20);
	$this->Cell(0,0,utf8_decode(''),0,0,'C');                  
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

         
         $this->datos = $this->getFacturas(); 

         //********cheque**************//
         $this->SetFont('courier','B',12);
         $this->AddPage(); 
         $this->SetX(1);
         $this->Ln(-1);
         $this->SetFillColor(255, 255, 255);
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(135, 50)); 
         $this->Row(array('',number_format($this->datos[0]['nu_monto'], 2, ',','.')),0,0); 
         $this->Ln(5);
         $this->SetX(1);
         $this->SetY(25);
         $this->SetFont('courier','',10);
         $this->SetWidths(array(20, 150)); 
         $this->Row(array('',$this->datos[0]['tx_razon_social']),0,0); 
         $this->Ln(2);
         $montoLetra = numtoletras($this->datos[0]['nu_monto'],1);
         $this->Row(array('',$montoLetra),0,0); 
         $this->Ln(6);
         $this->SetAligns(array("L","L","L","L"));
         $this->SetWidths(array(10,60,5,15));
         $fecha_det= explode("-", $this->datos[0]['fe_pago']);
         //var_dump($fecha_det[0]); exit();
         $this->SetX(15);
         $this->Row(array('',$fecha_det[2]. '    DE    '. strtoupper(mes($fecha_det[1])),' ',$fecha_det[0]),0,0);

         //********fin de cheque**************/
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
        
        $this->ChapterBody();  

    }

    
    function TotalMonto(){

    $conex = new ConexionComun();     
    $sql = "select sum(tb045.nu_total) as nu_monto, sum(tb045.total_pagar) as total_pagar
                  from   tb026_solicitud as tb026
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud                                                   
                  left join tb045_factura as tb045 on tb045.co_compra = tb052.co_compras 
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud 
                  where tb030.co_ruta =".$_GET['codigo']." group by tb045.co_compra";
               
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];  
    }
    
    function getFacturas(){

          $conex = new ConexionComun();     
          $sql = "select distinct tb063.fe_pago, tb063.nu_monto,  upper(tb008.tx_razon_social) as tx_razon_social
                  from   tb026_solicitud as tb026
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor 
                  left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud
                  left join tb063_pago as tb063 on tb062.co_liquidacion_pago = tb063.co_liquidacion_pago
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb026.co_solicitud 
                  where tb030.co_ruta =".$_GET['codigo'];
               
         // echo var_dump($sql);  exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;   
    }
}
/*
$pdf=new PDF('P','mm','letter');
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
*/

$pdf=new PDF('P','mm','letter');
$pdf->ChapterBody();
$pdf->SetMargins(0, 0);
$pdf->SetDisplayMode('default');
$pdf->Output();

?>