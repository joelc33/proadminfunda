<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $array_factura;
    public $array_factura_banco;
    function Header() {

   
        $this->SetX(10);
        $this->Ln(10);
        $this->SetFillColor(255, 255, 255);
        $this->SetX(13);
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','B',6);

        $this->Image("imagenes/escudosanfco.png", 100, 7,20);

        
        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        //$this->Ln(6);
        //$this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACION Y FINANZAS'),0,0,'C');
        $this->Ln(10);

        $this->SetFont('Arial','',8);

        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        
        $this->SetWidths(array(30,160));
        $this->Ln(10);
        
        $this->datos = $this->getDatosProveedor();
        $this->SetX(13);
        $this->SetFillColor(201, 199, 199);
        $this->Cell(190,6,utf8_decode('DATOS DEL PROVEEDOR'),1,1,'C',1);
        $this->SetX(13);
        $this->SetFillColor(255, 255, 255);
        $this->SetAligns(array("L","L"));        
        $this->SetX(13);
        $this->SetFillColor(255, 255, 255);
        $this->SetAligns(array("L","L"));
        $this->Row(array(utf8_decode("Nombre o Razón Social"),utf8_decode ($this->datos['tx_razon_social'])));
        $this->SetX(13);
        $this->Row(array(utf8_decode("RIF"),$this->datos['tx_rif']));
        $this->Ln(4);
        
        $this->SetFillColor(201, 199, 199);
        $this->SetX(13);        
        $this->Cell(190,6,utf8_decode('CARACTERISTICAS DEL PROVEEDOR'),1,1,'C',1);
        $this->SetWidths(array(25,25,20,25,20,25,20,30));
        $this->SetAligns(array("C","C","C","C","C","C","C","C"));
        $this->SetFillColor(201, 199, 199);
        $this->SetX(13);
        $this->SetTextColor(0,0,0);
        $this->SetWidths(array(50,20));
        $this->Row(array("Representante Legal","Cedula"),1,1);
        $this->SetX(13);;
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

        
                
        $this->SetFont('Arial','',6);          
      
	$this->Ln(5);
	$this->SetX(13);
        $this->SetFillColor(201, 199, 199);
	$this->Cell(190,6,utf8_decode('RAMOS DEL PROVEEDOR'),1,1,'C',1);
        $this->SetFillColor(201, 199, 199);
        $this->SetWidths(array(30,160));
        $this->SetAligns(array("C","C"));
        $this->SetTextColor(0,0,0);
       
        $this->SetFont('Arial','',7);
	$this->SetX(13);
        $this->Row(array("Numero Actividad","Descripcion Actividad"),1,1);
        $this->Row(array('',''));

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

    function DatosProveedor(){

        $comunes = new ConexionComun();

$sql ="SELECT co_proveedor, 
                       tx_razon_social, 
                       co_documento, 
                       tx_siglas, 
                       tx_rif, 
                       tx_nit, 
                       tx_direccion, 
                       co_estado, 
                       co_municipio, 
                       co_clasificacion, 
                       tx_email, 
                       tx_sitio_web, 
                       nb_representante_legal,
                       nu_cedula_representante, 
                       tx_num_celular, 
                       nu_dia_credito, 
                       fe_registro, 
                       co_cuenta_contable, 
                       fe_vencimiento, 
                       nu_cuenta_bancaria, 
                       co_banco, 
                       co_tipo_residencia, 
                       co_tipo_proveedor, 
                       co_tipo_retencion, 
                       tx_registro, 
                       fe_registro_seniat, 
                       nu_registro, 
                       nu_tomo, 
                       nu_capital_suscrito, 
                       nu_capital_pagado, 
                       tx_observacion
                  FROM tb008_proveedor
                  where co_proveedor = 3 ";
         
         return $comunes->ObtenerFilasBySqlSelect($sql);
    }


}



$pdf=new PDF('P','mm','letter');



$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
