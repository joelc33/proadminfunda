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
        $this->Ln(10);
        $this->Cell(0,0,utf8_decode('COMPROBANTE DE CAJA'),0,0,'C');      

        $this->Ln(2);
        $this->SetFont('Arial','',8);

        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
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

         $this->Ln(2);
                                   
         $this->AddPage();    
         $this->line(1, 60, 220, 60);
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetY(65);
         $this->solicitud = $this->getBeneficiario();         
         //echo var_dump($this->solicitud['tx_serial']); exit;
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DATOS DEL COMPROBANTE DE CAJA - Nro. DOCUMENTO: '.$this->solicitud['tx_serial'])),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(20,20,20,140));
         $this->SetAligns(array("L","L","L","L")); 
         $this->SetFont('Arial','B',6); 
         $this->Row(array('ORDEN PAGO',$this->solicitud['tx_serial'],'CONCEPTO',$this->solicitud['tx_concepto']),1,1);    
         $this->SetWidths(array(20,180));
         $this->SetAligns(array("L","L")); 
         $this->Row(array('BENEFICIARO', $this->solicitud['tx_razon_social']),1,1);  
             
         $this->lista = $this->getliquidacion();         
         
         foreach($this->lista as $key => $inf) {
             $this->SetAligns(array("L"));     
             $this->SetWidths(array(200));  
             $this->SetFillColor(201, 199, 199);
             $this->Row(array('LIQUIDACION NRO.'.$inf['tx_serial']),1,1); 
             $this->SetFillColor(255, 255, 255);
             $this->lista_pagos = $this->getPagos($inf['co_liquidacion_pago']);
             $this->SetAligns(array("C","C","C","C","C","C"));     
             $this->SetWidths(array(30, 40, 40, 50, 40));  
             $this->SetFillColor(201, 199, 199);
             $this->Row(array('TRANSACCION','CUENTA','NRO.','MONTO','FECHA DE CHEQ./TRANS.'),1,1); 
             $this->SetFillColor(255, 255, 255);
             foreach($this->lista_pagos as $key => $campo) {                
                 $this->SetFont('Arial','',6);
                 $monto = number_format($campo['nu_monto'], 2, ',','.');  
                 $this->Row(array($campo['tx_forma_pago'], $campo['cuenta'], $campo['nu_pago'], $monto, $campo['fe_emision']),1,1);                       
             }    
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
         $this->datos = $this->getUsuario();
         
         $this->Row(array(utf8_decode('DATOS DE RECEPCIÓN -  REPRESENTANTE LEGAL DEL BENEFICIARIO')),1,1);
	 $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L","L","L"));
         $this->SetWidths(array(50,50,100));
         $this->Row(array(utf8_decode('Nombre y Apellido: '.$this->datos['nb_representante_legal']),utf8_decode('CI/RIF: '.$this->datos['tx_rif']), utf8_decode('Recibe Conforme: ')),1,1);

         $this->ln();
         
         $this->Cell(0,0,utf8_decode('Usuario del sistema: '.$this->datos['nb_usuario']),0,0,'L');
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
    
    function getBeneficiario(){

          $conex = new ConexionComun();     
          $sql = " select distinct tb008.tx_razon_social,                          
                          tb060.tx_serial,
                          tb039.tx_concepto
                   FROM tb026_solicitud as tb026                   
                   left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor  left join tb039_requisiciones as tb039 on tb039.co_solicitud = tb026.co_solicitud
                   left join tb060_orden_pago as tb060 on tb026.co_solicitud = tb060.co_solicitud                     
                   left join tb030_ruta as tb030 on tb030.co_solicitud = tb060.co_solicitud                  
                   where tb030.co_ruta = ".$_GET['codigo'];
                            
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];                        
    }
    
        function getliquidacion(){

          $conex = new ConexionComun();     
          $sql = " select tb062.fe_emision,
                          tb062.tx_serial,
                          tb062.co_liquidacion_pago
                   FROM tb026_solicitud as tb026   
                   left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud
                   left join tb030_ruta as tb030 on tb030.co_solicitud = tb062.co_solicitud                  
                   where tb030.co_ruta = ".$_GET['codigo']. " order by 3";
                            
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;                         
    }

    function getPagos($valor){
        
          $conex = new ConexionComun();     
          $sql = " select tb062.fe_emision,
                          tb063.nu_monto,
                          case when (co_cuenta_bancaria is not null) then                         
                           (select t.tx_cuenta_bancaria from tb011_cuenta_bancaria as t where t.co_cuenta_bancaria = tb063.co_cuenta_bancaria)
                         else
                           (select t.tx_descripcion from tb079_chequera as t where t.co_chequera = tb063.co_chequera) end as cuenta,
                           tb063.nu_pago,
                           tb074.tx_forma_pago 
                   FROM tb026_solicitud as tb026                   
                   left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor                  
                   left join tb001_usuario as tb001 on tb001.co_usuario = tb026.co_usuario   
                   left join tb039_requisiciones as tb039 on tb039.co_solicitud = tb026.co_solicitud
                   left join tb060_orden_pago as tb060 on tb026.co_solicitud = tb060.co_solicitud  
                   left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud
                   left join tb063_pago as tb063 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago
                   left join tb074_forma_pago as tb074 on tb074.co_forma_pago = tb063.co_forma_pago
                   left join tb030_ruta as tb030 on tb030.co_solicitud = tb062.co_solicitud                  
                   where tb063.co_liquidacion_pago = ".$valor." and tb030.co_ruta = ".$_GET['codigo'];
                            
          return $conex->ObtenerFilasBySqlSelect($sql);                        
    }

         
    function getUsuario(){

          $conex = new ConexionComun();     
          $sql = " select tb008.nb_representante_legal,
                          tb008.tx_rif,
                          tb001.nb_usuario
                   FROM tb026_solicitud as tb026                   
                   left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor                  
                   left join tb001_usuario as tb001 on tb001.co_usuario = tb026.co_usuario                      
                   left join tb030_ruta as tb030 on tb030.co_solicitud = tb026.co_solicitud                  
                   where tb030.co_ruta = ".$_GET['codigo'];
                            
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];                          
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