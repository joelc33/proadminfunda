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

        $this->Image("imagenes/escudosanfco.png", 100, 3,20);

        $this->SetFont('Arial','B',14);

        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('ESTADO ZULIA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('ALCALDIA DEL MUNICIPIO SAN FRANCISCO'),0,0,'C');
        $this->Ln(10);
        $this->Cell(0,0,utf8_decode('CONSTANCIA DE NÚMERO CIVICO'),0,0,'C');

        $this->Ln(15);
        $this->SetFont('Arial','',9);

        $this->Cell(0,0,utf8_decode('San Francisco, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'C');
        
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

        $sep = 12;

        $this->SetFont('Arial','B',10);

        $this->datos_planilla();
 //       $this->datos_gerente();

        $this->line(1, 60, 220, 60);

        $this->Cell(0,0,utf8_decode('Número de Solicitud: '.$this->datos[0]['nu_planilla']),0,0,'L');

        $this->Ln($sep);

        $this->Cell(0,0,utf8_decode('Solicitante: '.$this->datos[0]['contribuyente'].' C.I.: '.$this->datos[0]['cedula_rif']),0,0,'L');
       
   
        $this->Ln($sep);

        $this->Cell(0,0,utf8_decode('Dirección: '.strtoupper(($this->datos[0]['tx_direccion'].' NRO. '.$this->datos[0]['tx_casa_nro']))),0,0,'L');

         $this->Ln($sep);

        $this->Cell(0,0,utf8_decode('Parroquia: '.$this->datos[0]['tx_parroquia']),0,0,'L');

        
        $this->Ln($sep+2);

        $this->setX(160);
        $this->SetFont('Arial','B',11);
        $this->Cell(30,8,utf8_decode(strtoupper((' N°- '.$this->datos[0]['tx_casa_nro']))),1,1,'C');

        $this->ln(20);
        $this->SetAligns(array("L"));
        $this->SetWidths(array(200));
        $this->SetX(5);
        $this->SetFont('Arial','B',8);

        $this->Row(array(utf8_decode("Nota: Para el otorgamiento de esta constancia está fijada una tasa de ".strtoupper($this->datos[0]['tx_liquidado'])." (BS. ".number_format($this->datos[0]['mo_liquidado'], 2, ',','.')."). Que deberá ser cancelada en la GERENCIA DE ADMINISTRACIÓN TRIBUTARIA DE ESTA ALCALDIA
Esta constancia contiene la dirección del inmueble, la cual sirve para su localización en el municipio, sin acreditar propiedad o posesión al solicitante.")));

         $this->SetFont('Arial','B',11);
         $this->ln(30);
 //        $this->Cell(0,0,utf8_decode($this->datos_gerente[0]['nb_gerente']),0,0,'C');
         $this->ln(4);
 //        $this->Cell(0,0,utf8_decode($this->datos_gerente[0]['tx_cargo']),0,0,'C');


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

    function datos_gerente(){

 //       $conex = new ConexionComun();

 //       $sql = "select * from tb094_gerente_catastro where co_gerente = 3";

//        $this->datos_gerente = $conex->ObtenerFilasBySqlSelect($sql);

    }

}

$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();
?>
