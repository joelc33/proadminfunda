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

        $this->Image("imagenes/escudosanfco.png", 10, 3,20);

        $this->SetFont('Arial','B',9);

        $this->SetTextColor(0,0,0);
        $this->SetY(3.5);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('ESTADO ZULIA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('CORPORACIÓN SOCIALISTA ALCALDIA BOLIVARIANA DE SAN FRANCISCO'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('COORDINACIÓN DE CATASTRO'),0,0,'C');

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

        $this->Cell(0,0,utf8_decode('Planilla Nro: '.$this->datos[0]['nu_planilla']),0,0,'R');

        $this->Ln($sep);

        $this->Cell(0,0,utf8_decode('Sírvase Extender la Correspondiente Planilla de Liquidación al Ciudadano: '.$this->datos[0]['contribuyente']),0,0,'L');

        $this->Ln($sep);

        $this->Cell(0,0,utf8_decode('Portador de la Cédula de Identidad Nro.: '.$this->datos[0]['cedula_rif']),0,0,'L');

        $this->Ln($sep);

        $this->Cell(0,0,utf8_decode('Por la Cantidad de: '. strtoupper($this->datos[0]['tx_liquidado'])." (BS. ".number_format($this->datos[0]['mo_liquidado'], 2, ',','.')).")",0,0,'L');

        $this->Ln($sep);

        $this->Cell(0,0,utf8_decode('Por Concepto de: '.strtoupper($this->datos[0]['tx_concepto'])),0,0,'L');

        $this->Ln($sep);

        $this->Cell(0,0,utf8_decode('Dirección: '.strtoupper(($this->datos[0]['tx_direccion'].' CASA Nro. '.$this->datos[0]['tx_casa_nro']))),0,0,'L');

         $this->Ln($sep);

        $this->Cell(0,0,utf8_decode('Parroquia: '.$this->datos[0]['tx_parroquia']),0,0,'L');

        $this->line(140, 85, 185, 85);
        $this->Ln($sep+2);

        $this->Cell(160,0,utf8_decode('Inspector'),0,0,'R');


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

    function ArrayPlanilla($array) {
        $this->array_planillas = $array;
    }

    function ArrayFacturaBanco($array) {
        $this->array_factura_banco = $array;
    }

    function datos_planilla (){

        $conex = new ConexionComun();       
        
        $sql = "select * from vista_sindicatura where co_catastro_declaracion = ".$_GET['codigo'];
      
        $this->datos = $conex->ObtenerFilasBySqlSelect($sql);

    }

}

$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();
?>
