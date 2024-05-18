<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {


//        encabezado($this);
       
        $this->SetY(35);
         $this->SetX(5);
    }

    function Footer() {       
        $this->SetX(1);
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
       $this->DatosPersona();

       $this->SetFont('Arial','B',12);
       $this->setY(5);
       $this->setX(5);
       $this->MultiCell(320,5,'SICSUM',0,'L',0);
       $this->ln(3);
       $this->SetFont('Arial','B',8);
      // $this->setY(5);
       $this->setX(5);
       $this->SetFillColor(300,300,300);
          $this->SetWidths(array(50));
          $this->SetAligns(array("L"));
       $this->MultiCell(320,5,'Datos del Solicitante: ',0,'L',0);
       //$this->ln();
       $this->SetFont('Arial','',7);
       $this->setX(5);
		    $this->Row(array(utf8_decode('Cédula: ').' '.utf8_decode($this->datos_persona[0]['cedula_rif'])),0,1);
      // $this->MultiCell(320,5,utf8_decode('Cédula: ').' '.utf8_decode($this->datos_persona[0]['cedula_rif']),0,'L',0);
       $this->setX(5);
		    $this->Row(array(utf8_decode('Nombres: ').' '.utf8_decode($this->datos_persona[0]['contribuyente'])),0,1);
       $this->setX(5);
       $this->Row(array(utf8_decode('Tlf. Fijo: ').' '.utf8_decode($this->datos_persona[0]['telef_habitacion'])),0,1);
       $this->setX(5);
       $this->Row(array(utf8_decode('Tlf. Movil: ').' '.utf8_decode($this->datos_persona[0]['telef_movil'])),0,1);
       $this->setX(5);
       $this->Row(array(utf8_decode('Parroquia: ').' '.utf8_decode($this->datos_persona[0]['tx_parroquia'])),0,1);
       $this->setX(5);
        $this->Row(array(utf8_decode('Dirección: ').' '.utf8_decode($this->datos_persona[0]['tx_direccion'])),0,1);

       $this->SetFont('Arial','B',8);
       $this->ln();
      // $this->setY(5);
       $this->setX(5);
       $this->SetFillColor(300,300,300);
       $this->MultiCell(320,5,'Datos de la Solicitud: ',0,'L',0);
       //$this->ln();
       $this->setX(5);
       $this->SetFont('Arial','',7);
        $this->Row(array('Fecha de Recepcion: '.utf8_decode($this->datos_persona[0]['fecha_recepcion'])),0,1);
       $this->setX(5);
        $this->Row(array(utf8_decode('Cod. Solicitud: ').' '.utf8_decode($this->datos_persona[0]['co_solicitud'])),0,1);
       $this->setX(5);
        $this->Row(array(utf8_decode('Cod. de Tramite: ').' '.utf8_decode($this->datos_persona[0]['tx_serial_sicsum'])),0,1);
       $this->setX(5);
        $this->Row(array(utf8_decode('Tramite:').' '.utf8_decode($this->datos_persona[0]['tx_tipo_solicitud'])),0,1);
       $this->setX(5);
//        $this->Row(array('Fecha de Entrega: '.utf8_decode($this->datos_persona[0]['fecha_entrega_est'])),0,1);
//       $this->setX(5);
        $this->Row(array(utf8_decode('Observacion: ').' '.utf8_decode($this->datos_persona[0]['observacion'])),0,1);
       $this->ln();
       $this->setX(5);
       $this->MultiCell(320,5,utf8_decode('Mas informacion: www.sicsum.com.ve '),0,'L',0);
       $this->setX(5);
       $this->ln(9);
       $this->setX(5);

               
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


    function DatosPersona(){
     
        $comunes = new ConexionComun();

          $sql = "select * from vista_solicitud where co_instituto=8 and co_solicitud = ".$_GET['codigo'];

        $this->datos_persona =   $comunes->ObtenerFilasBySqlSelect($sql);

//        return $datos_persona[0];

    }



}
$pdf=new PDF('P','mm','Legal');
$pdf->SetMargins(50, 50, 50);
$pdf->SetAutoPageBreak(true,25);  
$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();
?>
