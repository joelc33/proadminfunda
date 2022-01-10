<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {
        $this->SetFont('courier','B',12);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('DIRECCIPON DE CONTABILIDAD'),0,0,'L');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('[FCPPRA26]'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');                          
    }

    function Footer() {
	$this->SetFont('courier','B',9);     
	$this->SetY(200);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');  
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
         $this->SetWidths(array(200));         
         $this->SetAligns(array("C")); 
         $this->SetFont('courier','B',12); 
         $this->SetX(80);
         $this->Row(array(utf8_decode('RELACIÓN DETALLADAS DE DEUDAS POR TIPO/PROVEEDOR DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
         $this->Ln(2);
         $this->SetWidths(array(200));
         $this->SetAligns(array("L"));           
         $this->SetFont('COURIER','B',8); 
         $this->SetFillColor(255, 255, 255); 
         
         $this->lista_proveedores = $this->getProveedor();         
         
         $this->SetFont('COURIER','',11);     
         $this->SetWidths(array(35,20,80,25,30,30,30,30,30,30)); 
         $this->SetAligns(array("C","C","C","C","R","R","R","R","R","R"));   
         $this->Row(array('Documento','Soporte',utf8_decode('Descripción'),'Fecha','Monto','Cancelado','Retenciones','Saldo Bs.', 'Relacionado','Ordenado'),0,0); 
         $this->SetAligns(array("L","L","L","C","C","R","R","R")); 
         $this->Line(10, 40, 350, 40);        
         $this->Ln(2);
         $total_monto  = 0;
         $total_saldo  = 0;

        
        foreach($this->lista_proveedores as $key => $campo){
        
                    if($this->getY()>170)
                        {	
                        $this->addPage();
                        $this->Ln(6);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("C")); 
                        $this->SetFont('courier','B',9);     
                        $this->SetX(80);
                        $this->Row(array(utf8_decode('RELACIÓN DETALLADAS DE DEUDAS POR TIPO/PROVEEDOR DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
                        $this->Ln(2);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("L"));           
                        $this->SetFont('COURIER','B',8); 
                        $this->SetFillColor(255, 255, 255); 

                        $this->SetFont('COURIER','',12);     
                        $this->SetWidths(array(35,20,80,25,30,30,30,30,30,30));  
                        $this->SetAligns(array("C","C","C","C","R","R","R","R","R","R"));     
                        $this->SetX(10);
                        $this->Row(array('Documento','Soporte',utf8_decode('Descripción'),'Fecha','Monto','Cancelado','Retenciones','Saldo Bs.', 'Relacionado','Ordenado'),0,0); 
                        $this->SetAligns(array("L","L","L","C","C","R","R","R")); 
                        $this->Line(10, 40, 350, 40);        
                        $this->Ln(2);
                    } 

                   $this->SetFont('courier','B',8);
                   $this->SetWidths(array(150)); 
                   $this->SetAligns(array("L")); 
                   $this->Row(array('Tipo: PA-APORTE PATRONAL'),0,0); 
                   $this->Row(array('Proveedor: '.$campo['nu_codigo'].'-'.$campo['tx_razon_social']),0,0);
                
                $this->lista_deudas = $this->getDeuda($campo['co_proveedor']);             
         
                foreach($this->lista_deudas as $key => $campo2){              

                    if($this->getY()>170)
                        {	
                        $this->addPage();
                        $this->Ln(6);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("C")); 
                        $this->SetFont('courier','B',9);     
                        $this->SetX(80);
                        $this->Row(array(utf8_decode('RELACIÓN DETALLADAS DE DEUDAS POR TIPO/PROVEEDOR DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
                        $this->Ln(2);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("L"));           
                        $this->SetFont('COURIER','B',8); 
                        $this->SetFillColor(255, 255, 255); 

                        $this->SetFont('COURIER','',12);     
                        $this->SetWidths(array(35,20,80,25,30,30,30,30,30,30)); 
                        $this->SetAligns(array("C","C","C","C","R","R","R","R","R","R"));      
                        $this->SetX(10);
                        $this->Row(array('Documento','Soporte',utf8_decode('Descripción'),'Fecha','Monto','Cancelado','Retenciones','Saldo Bs.', 'Relacionado','Ordenado'),0,0); 
                        $this->SetAligns(array("C","C","C","C","R","R","R","R","R","R"));   
                        $this->Line(10, 40, 350, 40);        
                        $this->Ln(2);
                    }  
                        $this->SetFont('COURIER','',9);  
                        $this->SetWidths(array(35,20,80,25,30,30,30,30,30,30));  
                        $this->SetAligns(array("C","C","L","C","R","R","R","R","R","R"));   
                        
                        
                        $this->SetX(10); 
                        $this->Row(array($campo2['documento'],'--',utf8_decode($campo2['descripcion']),$campo2['fecha'],number_format($campo2['monto'], 2, ',','.'),number_format('0', 2, ',','.'),number_format('0', 2, ',','.'),number_format($campo2['saldo'], 2, ',','.'),number_format(0, 2, ',','.'),number_format(0, 2, ',','.')),0,0);         

                        $total_monto  += $campo2['monto'];
                        $total_saldo  += $campo2['monto'];
                        

                 }
                } 
        
         $this->Ln(10);      
         $this->SetFont('COURIER','B',10);  
         $this->SetAligns(array("R","R","R","R","R","R","R","R","R"));
         $this->SetWidths(array(160,30,30,30,30,30,30)); 
         $this->Row(array(utf8_decode('TOTAL RELACIÓN...: '),number_format($total_monto, 2, ',','.'),number_format('0', 2, ',','.'),number_format('0', 2, ',','.'),number_format($total_saldo, 2, ',','.'),number_format('0', 2, ',','.'),number_format('0', 2, ',','.')),0,0);         
         
         
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
   
    function getProveedor(){
        
    $condicion ="";
    $condicion .= " and tb159.fe_aporte >= '". $_GET["fe_inicio"]."' and ";
    $condicion .= " tb159.fe_aporte <= '".$_GET["fe_fin"]."' ";   

          $conex = new ConexionComun();     
          $sql = "SELECT distinct nu_codigo, tb008.co_proveedor, tb008.tx_razon_social
                    FROM tb159_aporte_patronal_nomina as tb159 
                    left join tb157_aporte_patronal as tb157 on tb159.tx_tipo_aporte = tb157.tx_movimiento 
                    left join tb158_proveedor_aporte as tb158 on tb158.co_aporte = tb157.co_aporte_patronal
                    left join tb008_proveedor as tb008 on tb008.co_proveedor = tb158.co_proveedor                    
                    where tb008.co_proveedor is not null $condicion ";
                   
        //  echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }   
    
    function getDeuda($prov){
        
    $condicion ="";
    $fe_inicio    = $_GET['fe_inicio'];    
    $fe_fin       = $_GET['fe_fin'];   

    
    $condicion .= " and tb159.fe_aporte >= '". $_GET["fe_inicio"]."' and ";
    $condicion .= " tb159.fe_aporte <= '".$_GET["fe_fin"]."' "; 
    
 
    
          $conex = new ConexionComun();     
          $sql = "SELECT 
                        ('PA-'||tb159.tx_serial_nomina) as documento,
                        coalesce(tb053.detalle,tb053.detalle,tb159.tx_tipo_aporte||' - '||tx_descripcion||' '||tb159.tx_serial_nomina||' - '||tx_tipo_nomina) as descripcion, 
                        to_char(tb159.fe_aporte,'dd/mm/yy') as fecha,                          
                        tb159.mo_aporte as monto,
                        tb159.mo_aporte as saldo
                    FROM tb159_aporte_patronal_nomina as tb159 
                    left join tb157_aporte_patronal as tb157 on tb159.tx_tipo_aporte = tb157.tx_movimiento 
                    left join tb158_proveedor_aporte as tb158 on tb158.co_aporte = tb157.co_aporte_patronal
                    left join tb008_proveedor as tb008 on tb008.co_proveedor = tb158.co_proveedor
                    left join tb053_detalle_compras as tb053 on tb159.co_detalle_compra = tb053.co_detalle_compras 
                    where tb008.co_proveedor = $prov $condicion "
                         ;
                    
                  
        //  echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }    
}

$pdf=new PDF('L','mm','legal');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
