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
        $this->Cell(0,0,utf8_decode('COMPROBANTE DE CAJA FONDO DE TERCEROS'),0,0,'C');      

        $this->Ln(2);
        $this->SetFont('Arial','',8);

        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->SetX(1);
     

    }

    function Footer() {
	$this->SetFont('Arial','',9);     
	$this->SetY(-20);

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
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DATOS DEL COMPROBANTE DE CAJA '.$this->solicitud['nu_declaracion'])),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(30,120,20,30));
         $this->SetAligns(array("L","L","L","L")); 
         $this->SetFont('Arial','B',6); 
         $this->Row(array('CONCEPTO',$this->solicitud['tx_observacion'],'MONTO',number_format($this->solicitud['mo_pagar'], 2, ',','.')),1,1);    
         $this->SetWidths(array(30,170));
         $this->SetAligns(array("L","L")); 
         $this->Row(array('BENEFICIARO', $this->solicitud['tx_razon_social']),1,1);  
             
         $this->lista = $this->getDetalle();         
         $item = 0;
         
         foreach($this->lista as $key => $campo) {  
            if($item==0)
            {  
             $item++;   
             $this->SetAligns(array("C","C","C","C"));     
             $this->SetWidths(array(30, 40, 40, 90));  
             $this->SetFillColor(201, 199, 199);
             $this->Row(array('FECHA DE RETENCION','RETENCION','MONTO','OBSERVACION'),1,1); 
             $this->SetFillColor(255,255,255);
             $this->SetFont('Arial','',6);
            }  
             $this->SetAligns(array("L","L","R","J")); 
             $monto = number_format($campo['monto'], 2, ',','.');  
             $this->Row(array($campo['created_at'], $campo['tx_tipo_retencion'], $monto, $campo['tx_observacion']),1,1);                       
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
                          case when (tb069.nu_declaracion is not null) then ' - NRO. DECLARACION: '||tb069.nu_declaracion else '' end as nu_declaracion,
                          tb069.mo_pagar,
                          tb069.tx_observacion
                   FROM tb026_solicitud as tb026                   
                   left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor  
                   left join tb069_fondo_tercero as tb069 on tb026.co_solicitud = tb069.co_solicitud                     
                   left join tb030_ruta as tb030 on tb030.co_solicitud = tb069.co_solicitud                  
                   where tb030.co_ruta = ".$_GET['codigo'];
                            
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];                        
    }
    
    function getDetalle(){
        
          $conex = new ConexionComun();     
          $sql = " select tb070.created_at,
                          tb070.monto,
                          tb041.tx_tipo_retencion,
                          tb070.tx_observacion
                   FROM tb026_solicitud as tb026              
                   left join tb069_fondo_tercero as tb069 on tb026.co_solicitud = tb069.co_solicitud  
                   left join tb070_detalle_fondo as tb070 on tb070.co_fondo_tercero = tb069.co_fondo_tercero
                   left join tb041_tipo_retencion as tb041 on tb041.co_tipo_retencion  =  tb070.co_tipo_retencion
                   left join tb030_ruta as tb030 on tb030.co_solicitud = tb069.co_solicitud                  
                   where tb030.co_ruta = ".$_GET['codigo'];
                            
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