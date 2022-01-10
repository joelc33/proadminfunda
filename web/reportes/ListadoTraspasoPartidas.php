<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {



        $this->Image("imagenes/escudosanfco.png", 130, 7,20);

        $this->SetFont('Arial','B',11);
        
      //  
        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        $this->Ln(15);
        $this->Cell(0,0,utf8_decode('MODIFICACIONES PRESUPUESTARIA POR TRASPASOS'),0,0,'C');
        
        $this->SetFont('Arial','',8);
        $this->Ln(10);

        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
             

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
         $this->SetY($this->getY()*1);
         $this->SetFont('Arial','B',5);
	 $this->SetFillColor(220, 220, 220);
         $this->SetWidths(array(30,30,30,30,30,30,40));
         $this->SetAligns(array("L","L","L","L","L","L","L"));
         $this->Row(array(utf8_decode('PARTIDA ORIGEN'),utf8_decode('MONTO ACTUAL'),utf8_decode('PARTIDA DESTINO'),utf8_decode('MONTO INICIAL'),utf8_decode('MONTO TRASPASO'),utf8_decode('DISPONIBILIDAD FINAL ORIGEN'),utf8_decode('DISPONIBILIDAD FINAL DESTINO')),1,1);

	 $this->lista_partidas = $this->partidas();
	 foreach($this->lista_partidas as $key => $campo){

         $this->SetFillColor(255,255,255);
         $this->SetFont('Arial','',5);
         $this->SetWidths(array(30,30,30,30,30,30,40));
         $this->Row(array(),1,1);
	    if($this->getY($this->Row(array('','','','','','','')))>160){
		       $this->addPage();
		$this->Ln(2);
         	$this->SetY($this->getY()*1.5);
         	$this->SetFont('Arial','B',5);
	 	$this->SetFillColor(220, 220, 220);
          $this->SetWidths(array(30,30,30,30,30,30,40));
         $this->SetAligns(array("L","L","L","L","L","L","L"));
         $this->Row(array(utf8_decode('PARTIDA ORIGEN'),utf8_decode('MONTO ACTUAL'),utf8_decode('PARTIDA DESTINO'),utf8_decode('MONTO INICIAL'),utf8_decode('MONTO TRASPASO'),utf8_decode('DISPONIBILIDAD FINAL ORIGEN'),utf8_decode('DISPONIBILIDAD FINAL DESTINO')),1,1);
                       
	    }
      }

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
   
    function partidas(){

        $conex = new ConexionComun();     
          $sql = "   select distinct   nu_factura, 
                          fe_emision, 
                          nu_base_imponible, 
                          co_iva_factura, 
                          nu_iva_factura, 
                          nu_total, 
                          tb045.co_iva_retencion, 
                          nu_iva_retencion, 
                          tb045.tx_concepto, 
                          tb045.co_compra as nu_compra, 
                          numero_compra,
                          nu_total_retencion, 
                          total_pagar,
                          tb052.tx_observacion,
                         tb008.tx_razon_social,
                         tb008.tx_rif,
                         tb008.tx_direccion,                         
                         tb008.nb_representante_legal,
                         tb008.nu_cedula_representante,
                         tb008.tx_email,
                         tb047.tx_ente
                  from   tb045_factura as tb045                                                    
                  left join tb052_compras as tb052 on tb052.co_compras = tb045.co_compra
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb052.co_proveedor
                  left join tb039_requisiciones as tb039 on tb045.co_solicitud = tb039.co_solicitud
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb039.co_usuario
                  left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb045.co_solicitud 
                  where tb030.co_ruta =".$_GET['codigo'];
                  //.$_GET['co_ruta'];
                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];  
	
    }




}
$pdf=new PDF('L','mm','letter');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
