<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $array_factura;
    public $array_factura_banco;
    function Header() {
    

    }

    function Footer() {

$this->Image('http://chart.googleapis.com/chart?chs=50x50&cht=qr&chl=http://sicsum-app.ddns.net/ventanilla/web/reportes/certificado.php?codigo='.$_GET['codigo'].'&.png',160,135,40,40);

	$this->SetY(200);
	$this->SetFont('Arial','B',9);     
	$this->SetY(-20);
//	$this->Cell(0,0,utf8_decode('www.ciudaddeprogreso.org.ve / www.sedebat.com'),0,0,'C');
        
    }

    function dwawCell($title,$data) {



        $width = 8;
        $this->SetFont('Arial','B',8);
        $y =  $this->getY() * 20;
        $x =  $this->getX();
        $this->SetFillColor(206,230,100);
        $this->MultiCell(175,8,$title,0,1,'L',0);
        $this->SetY($y);
        $this->SetFont('Arial','',6);
        $this->SetFillColor(206,230,172);
        $w=$this->GetStringWidth($title)+3;
        $this->SetX($x+$w);
        $this->SetFillColor(206,230,172);
        $this->MultiCell(175,8,$data,0,1,'J',0);

    }

    function ChapterBody() {


           encabezado_certificado($this);
         $this->Ln(2);
         $this->SetY(68);
        $this->datos = $this->getSolicitudes();
         $espacio = 2;
         if(strlen($this->datos['contribuyente'])>49){
            $this->SetY($this->getY()-5);
            $espacio=4;
         }else{
              $this->SetY($this->getY());
         }
             
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);
         $this->SetAligns(array("L"));
         $this->SetX(55);
         $this->MultiCell(85,$espacio,utf8_decode($this->datos['contribuyente']));
        // $this->Row(array(utf8_decode($this->datos['contribuyente'])),0,0);
        
         $this->SetY(67);
         $this->SetX(144);
         $this->MultiCell(30,5,utf8_decode($this->datos['cedula_rif']));
         
         $this->SetY(78);
         $this->SetX(55);
         $this->MultiCell(100,5,utf8_decode($this->datos['tramite']));
         
         $this->SetY(87);
         $this->SetX(55);
         $this->MultiCell(100,5,utf8_decode($this->datos['tx_tipo_solicitud']));
         
         $this->SetY(97);
         $this->SetX(55);
         $this->MultiCell(50,5,utf8_decode($this->datos['tx_serial_sicsum']));
      
         $this->SetY(109);
         $this->SetX(100);
         $this->MultiCell(50,4,utf8_decode($this->datos['dia_letra']));
         
         $this->SetY(109);
         $this->SetX(118);
         $this->MultiCell(50,4,utf8_decode($this->datos['dia']));
         
         $this->SetY(109);
         $this->SetX(143);
         $this->MultiCell(50,4,utf8_decode(mes($this->datos['mes'])));
         
         $this->SetY(109);
         $this->SetX(182);
         $this->MultiCell(50,4,utf8_decode($this->datos['anio']));

    }

    function ChapterTitle($num,$label) {
        $this->SetFont('Arial','',6);
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

	function enc(){


	}



    function getSolicitudes(){

          $conex = new ConexionComun();

          $sql = "select *,upper(tx_tipo_tramite) as tramite,num_letras(cast(to_char(fecha_aprobacion,'dd') as numeric)) as dia_letra,to_char(fecha_aprobacion,'dd') as dia,to_char(fecha_aprobacion,'mm') as mes,to_char(fecha_aprobacion,'yy') as anio from vista_solicitud_aprobada
                    where co_solicitud = ".$_GET['codigo'];

          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];

    }

    

    


}

$pdf=new PDF('P','mm','legal');
$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();
?>
