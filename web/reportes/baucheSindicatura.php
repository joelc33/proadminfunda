<?php
include("ConexionComun.php");
ob_end_clean();
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $array_factura;
    public $array_factura_banco;
    function Header() {

        $this->Image("imagenes/logo.jpg", 10, 4,30);

        $this->SetFont('Arial','B',9);

        $this->SetTextColor(0,0,0);       
        $this->SetY(9.5);
        $this->SetX(43);
        $this->Cell(120,5,utf8_decode('Ciudadano(a)'),0,0,'L');
        $this->Ln(4);
        $this->SetX(43);
        $this->Cell(120,5,utf8_decode('GERENTE DE ADMINISTRACIÓN TRIBUTARIA'),0,0,'L');
        $this->Ln(4);
        $this->SetX(43);
        $this->Cell(120,5,utf8_decode('Presente.-'),0,0,'L');
       
        $this->Ln(8);
        $this->SetFont('Arial','',9);

        $this->Cell(0,0,utf8_decode('San Francisco, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');

        $this->Ln(10);
        $this->SetTextColor(0,0,0);
        $this->SetX(1);

        $this->Ln(4);
        

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

        $sep = 8;

        $this->SetFont('Arial','B',9);

        $this->datos_planilla();
 //       $this->datos_gerente();
        
         $this->Cell(0,0,utf8_decode('Planilla Nro: '.$this->datos[0]['nu_planilla']),0,0,'R');

         $this->Ln($sep);

         $this->SetAligns(array("L"));
         $this->SetWidths(array(200));
         $this->SetFont('Arial','',9);
         $this->SetFillColor(255, 255, 255);
//	 $this->Row(array(utf8_decode('Sírvase Extender la Correspondiente Planilla de Liquidación al Ciudadano: '.$this->datos[0]['contribuyente'].' Portador de la Cédula de Identidad Nro.: '.$this->datos[0]['cedula'].', por la Cantidad de: '. strtoupper(num2letras($this->datos[0]['mo_liquidado'],false)).' (BS. '.number_format($this->datos[0]['mo_liquidado'], 2, ",",".").') por Concepto de: '.strtoupper($this->datos[0]['tx_concepto']).', en la Jurisdicción de la parroquia Parroquia: '.$this->datos[0]['tx_parroquia'].' del Municipio San Francisco del Estado Zulia')),0,1);

          $this->MultiCell(0,5,utf8_decode('Sírvase Extender la Correspondiente Planilla de Liquidación al Ciudadano: '.$this->datos[0]['contribuyente'].' Portador de la Cédula de Identidad Nro.: '.$this->datos[0]['cedula_rif'].', por la Cantidad de: '. strtoupper($this->datos[0]['tx_liquidado']).' (BS. '.number_format($this->datos[0]['mo_liquidado'], 2, ",",".").') por Concepto de: '.strtoupper($this->datos[0]['tx_concepto']).', en la Jurisdicción de la Parroquia: '.$this->datos[0]['tx_parroquia'].' del Municipio San Francisco del Estado Zulia'));

//         $this->line(140, 85, 185, 85);
         $this->Ln($sep+2);

         $this->SetFont('Arial','B',9);
         $this->ln(20);
         $this->setX(110);
 //        $this->Cell(100,3,utf8_decode($this->datos_gerente[0]['nb_gerente']),0,0,'C');
         $this->ln(4);
         $this->setX(110);
 //        $this->Cell(100,3,utf8_decode($this->datos_gerente[0]['tx_cargo']),0,0,'C');

         $this->SetWidths(array(25,60,35,20,18.9,27,25,25,25));

         $this->SetFillColor(201, 199, 199);
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

/*

    function ArrayPlanilla($array) {
        $this->array_planillas = $array;
    }

    function ArrayFacturaBanco($array) {
        $this->array_factura_banco = $array;
    }
*/
    function datos_planilla (){

        $conex = new ConexionComun();       
        
        $sql = "select * from vista_sindicatura where co_catastro_declaracion = ".$_GET['codigo'];

//        echo $sql;        
//        exit();
      
        $this->datos = $conex->ObtenerFilasBySqlSelect($sql);



    }

/*     function datos_gerente(){

        $conex = new ConexionComun();

        $sql = "select * from tb094_gerente_catastro where co_gerente = 3";

        $this->datos_gerente = $conex->ObtenerFilasBySqlSelect($sql);

    } */

}


$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();
?>
