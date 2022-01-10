<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->Image("imagenes/escudosanfco.png", 100, 7,20);

        $this->SetFont('Arial','B',8);

        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACIÓN Y FINANZAS'),0,0,'C');
        $this->Ln(12);
        $this->SetFont('Arial','B',14);       
        $this->Cell(0,0,utf8_decode(' FACTURA '),0,0,'C');      

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

         $this->lista_facturas = $this->getFacturas();

         $campo='';         
         foreach($this->lista_facturas as $key => $campo){ 
         $this->AddPage();            
         $this->SetY(65);
         
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);         
         $this->SetFont('Arial','B',9);
         $this->Row(array(utf8_decode('DATOS DE LA FACTURA')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetFont('Arial','',9);
         $this->SetAligns(array("L","L","L","L"));
         $this->SetWidths(array(50,50,50,50));         
         $this->Row(array(utf8_decode('No.FACTURA:').$campo['nu_factura'],utf8_decode('No.COMPRA:').$campo['numero_compra'], 'No.CONTROL:'.$campo['nu_control'], utf8_decode('MONTO:  ').number_format($campo['nu_total'], 2, ',','.')),1,1);
         $this->SetWidths(array(200)); 
         $this->Row(array(utf8_decode('SEÑOR(ES):'.$campo['tx_razon_social']).'- R.I.F:'.utf8_decode($campo['tx_rif'])),1,1);                  
         $this->Row(array(utf8_decode('DIRECCIÓN:').$campo['tx_direccion']),1,1); 
         $this->Row(array(utf8_decode('CONCEPTO:').utf8_decode($campo['tx_concepto'])),1,1);                  
                         
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Arial','B',9); 
         $this->Row(array(utf8_decode('RETENCIONES ASOCIADAS')),1,1);
         $this->SetFillColor(255, 255, 255); 
         $this->SetFont('Arial','',9); 
         $this->SetAligns(array("C","C","C","C"));
         $this->SetWidths(array(50,50,50,50));
         $this->Row(array('BASE IMPONIBLE:  '.number_format($campo['nu_base_imponible'], 2, ',','.'),'IVA:  '.number_format($campo['nu_iva_factura'], 2, ',','.'),utf8_decode('MONTO EXENTO: ').'0','TOTAL A PAGAR:  '.number_format($campo['total_pagar'], 2, ',','.')),1,1);
         
         $this->SetFont('Arial','',9); 
         $this->SetWidths(array(100,100));
         $this->Row(array(utf8_decode('RETENCIÓN I.V.A '),number_format($campo['nu_iva_retencion'], 2, ',','.')),1,1);
         $campo1='';
         $this->lista_retenciones = $this->getRetenciones($campo['co_factura']);
         foreach($this->lista_retenciones as $key => $campo1){                    
          $this->Row(array(utf8_decode($campo1['tx_tipo_retencion']),number_format($campo1['mo_retencion'], 2, ',','.')),1,1);
         }        
         
         $this->ln();
         $this->SetAligns(array("C","C", "C"));
	 $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(65,70,65));
         $this->SetFont('Arial','B',9); 
         $this->Row(array(utf8_decode('DIRECCION DE PRESUPUESTO'),utf8_decode('SECRETARIA DE ADMINISTRACION Y FINANZAS'),utf8_decode('MÁXIMA AUTORIDAD ORGANIZACIONAL')),1,1);         
         $Y = $this->GetY();
         $this->MultiCell(65,15,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(75);
         $this->MultiCell(70,15,'',1,1,'L',1);  
         $this->SetY($Y);
         $this->SetX(145);
         $this->MultiCell(65,15,'',1,1,'L',1);
         $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L","L", "L"));         
         $this->SetY($Y+15);
         
         $this->SetFillColor(255,255,255);
         $this->SetWidths(array(65,70,65));
         $this->SetAligns(array("L", "L","L"));         
         $this->SetFont('Arial','',7); 
         $this->Row(array(utf8_decode('Registrado por:'),utf8_decode('Revisado por:'), utf8_decode('Aprobado por:')),1,1);
         $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFont('Arial','B',9); 
         $this->Row(array(utf8_decode('DATOS DE RECEPCIÓN -  REPRESENTANTE LEGAL DEL BENEFICIARIO')),1,1);
	 $this->SetFillColor(255,255,255);
         $Y = $this->GetY();
         $this->MultiCell(50,15,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(60);
         $this->MultiCell(50,15,'',1,1,'L',1);  
         $this->SetY($Y);
         $this->SetX(110);
         $this->MultiCell(50,15,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(160);
         $this->MultiCell(50,15,'',1,1,'L',1);
         $this->SetWidths(array(50,50,50,50));
         $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L","L", "L","L"));         
         $this->SetY($Y+15);
         $this->SetAligns(array("L","L", "L","L"));
         $this->SetWidths(array(50,50,50,50));
         $this->SetFont('Arial','',7);
         $this->Row(array(utf8_decode('Nombre:'),utf8_decode('CI/RIF:'), utf8_decode('Fecha:'),utf8_decode('Firma:')),1,1);

         $this->ln();
         
         $this->Cell(0,0,utf8_decode('Usuario del sistema:'),0,0,'L');
         $this->ln();
	 $this->SetY($this->GetY()+5);
         $this->Cell(0,0,utf8_decode(''),0,0,'L');

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
        //$this->AddPage();
        $this->ChapterBody();
    }

    function getFacturas(){

          $conex = new ConexionComun();     
          $sql = "select distinct   nu_factura, 
                          co_factura,
                          fe_emision, 
                          nu_control,
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
                         tb047.tx_ente,
                         de_tipo_movimiento
                  from   tb052_compras as tb052                                                   
                  left join tb045_factura as tb045 on tb052.co_compras = tb045.co_compra
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb052.co_proveedor                  
                  left join tb088_tipo_movimiento as tb088 on tb088.id = tb052.co_tipo_movimiento
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb052.co_usuario
                  left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud 
                  where tb030.co_ruta =".$_GET['codigo'];
               
          return $conex->ObtenerFilasBySqlSelect($sql);               
         
    }
    
    

    function getRetenciones($fact){

	  $conex = new ConexionComun();
          $sql = "select  nu_factura, 
                          fe_emision, 
                          nu_base_imponible,                           
                          nu_iva_factura, 
                          nu_total,                           
                          nu_iva_retencion, 
                          tx_concepto,                           
                          nu_total_retencion, 
                          total_pagar,
                          po_retencion,
                          mo_retencion,
                          tx_tipo_retencion
                  from   tb045_factura as tb045     
                  left join tb046_factura_retencion as tb046 on tb046.co_factura = tb045.co_factura
                  left join tb041_tipo_retencion as tb041 on tb041.co_tipo_retencion = tb046.co_tipo_retencion
                  where tb045.co_factura = ".$fact; 
                       
           
          return $conex->ObtenerFilasBySqlSelect($sql);
  
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

/*
$pdf=new PDF('P','mm','letter');
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();
*/
?>
