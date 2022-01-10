<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {


        $this->Image("imagenes/escudosanfco.png", 100, 7,20);

        $this->SetFont('Arial','B',10);
        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        //$this->Ln(6);
        //$this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACION Y FINANZAS'),0,0,'C');
        $this->Ln(15);
        $this->Cell(0,0,utf8_decode('SOPORTE DE PAGO'),0,0,'C');      

        $this->Ln(5);
        $this->SetFont('Arial','',8);

        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->SetFont('Arial','B',9);     
	$this->Ln(2);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');  
        $this->Ln(5);
        $this->SetTextColor(0,0,0);
        $this->SetX(1);
     

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
         $this->datos = $this->getPagos();
                          
         $this->AddPage();    
         $this->line(1, 60, 220, 60);
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(60,140));
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetY(65);
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DATOS DEL PAGO')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetAligns(array("L","L","L","L","L","L"));         
         $this->SetFont('Arial','',6);   
         $this->SetWidths(array(30, 30, 30, 50, 30, 30));
         $this->Row(array(utf8_decode('Nro. Serial:'),$this->datos['tx_serial'],utf8_decode('Monto'),utf8_decode($this->datos['mo_pagado']), 'Fecha:',$this->datos['fe_pago']),1,1);                           
         $this->SetWidths(array(30,170));
         $this->Row(array('La Cantidad de: ',$this->datos['monto_letras'].' con 00/100Bolivares'),1,1);                  
         $this->Row(array(utf8_decode('Beneficiario:'),$this->datos['tx_razon_social']),1,1);                  
         $this->Row(array('Concepto: ',$this->datos['tx_observacion']),1,1);
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);         
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));        
         
         
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DETALLES DEL PAGO')),1,1);
         $this->SetFont('Arial','',6); 
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(30,40,20,40,30,30)); 
         $this->SetAligns(array("L","L","L","L","L","L"));
         $this->detalle_pago = $this->getDetallePago();
         $item = 0;
         foreach($this->detalle_pago as $key => $campo){
         $item++;
         $this->Row(array($item,utf8_decode('BANCO:'),$campo['tx_banco'],utf8_decode('CUENTA'),$campo['cuenta'], utf8_decode('Tipo Transacción'),utf8_decode($this->datos['tp_transaccion']), utf8_decode('FECHA'),$campo['fe_pago'],'MONTO',$campo['nu_monto']),1,1);         
         }
                  
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DEDUCCIONES')),1,1);
         $this->SetFillColor(255, 255, 255);          
         $this->SetFont('Arial','',6); 
         $this->SetWidths(array(70,130));
         $this->Row(array('CONCEPTO','MONTO'),1,1);
         $this->Row(array(utf8_decode('RETENCIÓN I.V.A'),$campo['nu_iva_retencion']),1,1);
         $campo1='';
         $this->lista_retenciones = $this->getRetenciones('');
         foreach($this->lista_retenciones as $key => $campo1){                    
          $this->Row(array(utf8_decode($campo1['tx_tipo_retencion']),number_format($campo1['mo_retencion'], 2, ',','.')),1,1);
         }   
                  
         $this->ln();
         $this->SetAligns(array("C","C", "C"));
	 $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(40,120,40));
         $this->Row(array(utf8_decode('SECRET. ADMIN. Y FINAN.'),utf8_decode('UNIDAD DE TESORERIA'),utf8_decode('MÁXIMA AUTORIDAD')),1,1);
         $this->SetFillColor(255,255,255);
         $this->SetWidths(array(40,40,40,40,40));
         $this->SetAligns(array("L", "L","L","L"));
         $this->Row(array('Autorizado por:','Elaborado por:','Conformado por:','Autorizado por:','Autorizado por:'),1,1);
         $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->Row(array(utf8_decode('DATOS DE RECEPCIÓN -  REPRESENTANTE LEGAL DEL BENEFICIARIO')),1,1);
	 $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L","L","L"));
         $this->SetWidths(array(50,50,100));
         $this->Row(array(utf8_decode('Nombre y Apellido: '. $this->datos['nb_representante_legal']),utf8_decode('CI/RIF: '.$this->datos['tx_rif']), utf8_decode('Recibe Conforme: ')),1,1);

         $this->ln();
         
         $this->Cell(0,0,utf8_decode('Usuario del sistema:'),0,0,'L');
         $this->ln();
	 $this->SetY($this->GetY()+5);
         $this->Cell(0,0,utf8_decode(''),0,0,'L');

       

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

    function getPagos(){

          $conex = new ConexionComun();     
          $sql = " select tb008.tx_razon_social,
                         tb008.tx_rif,               
                         tb008.nb_representante_legal,
                         tb008.nu_cedula_representante,
                         tb063.fe_pago,
                         tb062.fe_emision, 
                         tb062.tx_serial, 
                         tb063.nu_monto
                   FROM tb026_solicitud as tb026
                   left join tb062_liquidacion_pago as tb062 on tb026.co_solicitud = tb062.co_solicitud
                   left join tb063_pago as tb063 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago
                   left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor                  
                   left join tb030_ruta as tb030 on tb030.co_solicitud = tb026.co_solicitud 
                   where tb030.co_ruta = ".$_GET['codigo'];
               
                 
          return $conex->ObtenerFilasBySqlSelect($sql);               
         
    }
    
    function getRetenciones(){

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
                  where tb045.co_factura = ".$_GET['codigo']; 
                       
           
          return $conex->ObtenerFilasBySqlSelect($sql);
  
    }

    function getDetallePago(){

	  $conex = new ConexionComun();
          $sql = "select tb063.fe_pago,
                         tb062.fe_emision, 
                         tb062.tx_serial, 
                         tb063.fe_pago,
                         tb063.nu_monto,
                         tb074.tx_forma_pago,
                         tb010.tx_banco,
                         case when (co_cuenta_bancaria is not null) then                         
                           (select t.tx_cuenta_bancaria from tb011_cuenta_bancaria as t where t.co_cuenta_bancaria = tb063.co_cuenta_bancaria)
                         else
                           (select t.tx_descripcion from tb079_chequera as t where t.co_chequera = tb063.co_chequera) end as cuenta 
                  FROM tb063_pago as tb063
                  left join tb062_liquidacion_pago as tb062 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago
                  left join tb074_forma_pago as tb074 on tb074.co_forma_pago = tb063.co_forma_pago                  
                  left join tb010_banco as tb010 on tb010.co_banco = tb063.co_banco
                  left join tb026_solicitud as tb026 on tb026.co_solicitud = tb062.co_solicitud
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor                  
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb063.co_usuario                  
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb062.co_solicitud 
                  where tb030.co_ruta =  ".$_GET['codigo']; 
                       
           
          return $conex->ObtenerFilasBySqlSelect($sql);
  
    }



}


/*
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
*/

$pdf=new PDF('P','mm','letter');
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>