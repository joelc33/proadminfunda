<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $array_factura;
    public $array_factura_banco;
    function Header() {


        encabezado_estado_2($this,$h='v');

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

         $this->Ln(6);
         $this->Cell(0,0,utf8_decode('Fecha de Impresión: '.date("d-m-Y")),0,0,'R');
         $this->Ln(4);
         $this->Cell(0,0,utf8_decode('Cod. Reporte: SCD0006'),0,0,'R');
	 $this->Ln(6);
         $this->Cell(0,0,utf8_decode('REPORTE DE TRAMITES POR ENTREGAR'),0,0,'C');
         $this->Ln(6);
         $this->SetY($this->getY()*1);
         $this->SetFont('Arial','B',6);
	 $this->SetFillColor(220, 220, 220);
         $this->SetWidths(array(10,15,15,25,20,35,100,40));
         $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));
         $this->Row(array(utf8_decode('ITEMS'),utf8_decode('SOLICITUD'),utf8_decode('CEDULA'),utf8_decode('NOMBRE'),utf8_decode('APROBADO'),utf8_decode('TELF. MOVIL'),utf8_decode('DIRECCION'),utf8_decode('COD SICSUM')),1,1);

	 $this->v_tramite = $this->tramite();
	 //echo $this->v_tramite['tx_tipo_solicitud']; exit;
	 foreach($this->v_tramite as $key => $campo){
         $canti++;
         $this->SetFillColor(255,255,255);
         $this->SetFont('Arial','',6);
         $this->SetWidths(array(10,15,15,25,20,35,100,40));
         $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));
         $this->Row(array($canti,utf8_decode($campo['co_solicitud']),utf8_decode($campo['cedula_rif']),utf8_decode($campo['contribuyente']),utf8_decode($campo['fecha_aprobaciones']),utf8_decode($campo['telef_movil']." - ".$campo['telef_habitacion']),utf8_decode($campo['tx_direccion']),utf8_decode($campo['tx_serial_sicsum'])));
	    if($this->getY()>160){
		       $this->addPage();
		$this->Ln(2);
         	$this->SetY($this->getY()*1.5);
         	$this->SetFont('Arial','B',6);
	 	$this->SetFillColor(220, 220, 220);
         $this->SetWidths(array(10,15,15,25,20,35,100,40));
         $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));
         $this->Row(array(utf8_decode('ITEMS'),utf8_decode('SOLICITUD'),utf8_decode('CEDULA'),utf8_decode('NOMBRE'),utf8_decode('APROBADO'),utf8_decode('TELF. MOVIL'),utf8_decode('DIRECCION'),utf8_decode('COD SICSUM')),1,1);


	    }
		}

	          	$this->SetFont('Arial','B',5);
	 	$this->SetFillColor(220, 220, 220);
         //$this->SetWidths(array(10,70,15,15,15,15,15,15,15,15,15,15,17,15));
         //$this->SetAligns(array("C","R","L","L","L","L","L","L","L","L","L","L","L","L"));
         	//$this->Row(array('',utf8_decode('TOTAL'),$cant_ventanilla,$cant_inspeccion,$cant_bomberos,$cant_sindicatura,$cant_geomatica,$cant_impgas,$cant_imasur,$cant_invitra,$cant_sedebat,$cant_dsicsum,$cant_recaudacion,$cant_total),1,1);

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

// fechas, co_instituto, co_estatus, co_tipo_solicitud

    function tramite(){

        $conex = new ConexionComun();
          $sql = "select t15.co_solicitud,vc.cedula_rif, vc.contribuyente, vc.tx_direccion, vc.telef_movil,
    vc.telef_habitacion,to_char(t15.fecha_aprobacion, 'dd-mm-yyyy') as fecha_aprobaciones,t15.tx_serial_sicsum
 from  t15_solicitud as t15
  inner join vista_contribuyente as vc on (t15.co_contribuyente=vc.co_contribuyente)
  inner join t09_tipo_solicitud as t09 on (t15.co_tipo_solicitud=t09.co_tipo_solicitud)
  where t15.co_estatus = 5 and t15.fecha_aprobacion BETWEEN '".$_GET['fe_desde']."' AND '".$_GET['fe_hasta']."'
  order by t15.fecha_recepcion desc";
	$datosSol = $conex->ObtenerFilasBySqlSelect($sql);
	return  $datosSol;
    }




}
$pdf=new PDF('L','mm','letter');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
