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
        $this->Cell(0,0,utf8_decode('DIRECCIÓN DE CONTABILIDAD'),0,0,'L');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('[FCPPR022]'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');                          
    }

    function Footer() {
	$this->SetFont('courier','B',9);     
	$this->SetY(260);
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
         $this->SetX(70);
         $this->Row(array(utf8_decode('RELACIÓN DIARIA DE CONSIGNACIONES ')),0,0);
         $this->Ln(2);
         $this->SetWidths(array(200));
         $this->SetAligns(array("L"));           
         $this->SetFont('COURIER','B',8); 
         $this->SetFillColor(255, 255, 255); 
         
         $this->lista_proveedores = $this->getProveedor();         
         
         $this->SetFont('COURIER','',8);     
         $this->SetWidths(array(25,15,25,110,85,20,40));  
         $this->SetAligns(array("L","L","L","L","L","L","R"));   
         $this->Row(array('Documento','Sol.','OP','Proveedor','Concepto','Fecha','Monto Dcto.'),0,0);           
         $this->Line(10, 40, 350, 40);        
         $this->Ln(2);
         $total_monto  = 0;
         $cant         = 0;

        
        foreach($this->lista_proveedores as $key => $campo){

                   $this->SetFont('courier','B',8);
                   $this->SetWidths(array(200)); 
                   $this->SetAligns(array("L")); 
                   $this->Row(array('Proveedor: '.$campo['nu_codigo'].'-'.$campo['tx_razon_social']),0,0); 
                   if ($_GET["co_tipo"]){
                       $documento= $this->getDoc(); 
                       $this->Row(array('Documento: '.$documento[0]['tx_tipo_solicitud']),0,0);
                   }else{
                       $documento="TODOS DOCUMENTOS";
                       $this->Row(array('Documento: '.$documento),0,0);
                   }
                   
                   $this->Ln(2);
                $this->lista_documentos = $this->getDocumento($campo['co_proveedor']);             
         
                $subtotal_monto = 0;
                $subtotal_saldo = 0;
                                
                foreach($this->lista_documentos as $key => $campo2){              

                    if($this->getY()>175)
                        {	
                        $this->addPage();
                        $this->Ln(6);
                        $this->SetWidths(array(200));         
                        $this->SetAligns(array("C")); 
                        $this->SetFont('courier','B',12); 
                        $this->SetX(20);
                        $this->Row(array(utf8_decode('RELACIÓN DIARIA DE CONSIGNACIONES ')),0,0);
                        $this->Ln(2);
                        $this->SetFillColor(255, 255, 255); 
                        $this->SetFont('COURIER','',8);     
                        $this->SetWidths(array(25,15,25,110,85,20,40));   
                        $this->SetAligns(array("L","L","L","L","L","L","R"));  
                        $this->Row(array('Documento','Sol.','OP','Proveedor','Concepto','Fecha','Monto Dcto.'),0,0);           
                        $this->Line(10, 40, 350, 40);        
                        $this->Ln(2);
                    }  
                        $this->SetFont('COURIER','',8);  
                        $this->SetWidths(array(25,15,25,110,85,20,40));   
                        $this->SetAligns(array("L","L","L","L","L","L","R")); 
                        $this->Ln(2);
                        $this->SetX(10); 
                        $this->Row(array($campo2['documento'],$campo2['co_solicitud'],$campo2['tx_serial'],utf8_decode($campo2['tx_razon_social']),utf8_decode($campo2['tx_observacion']),$campo2['fecha'],number_format($campo2['monto'], 2, ',','.')),0,0);         
                         
                        $total_monto  += $campo2['monto'] ;
                        $cant++;
                 }  
                 $this->Ln(2);
                } 
                $this->Ln(5);      
                $this->SetFont('COURIER','B',9);  
                $this->SetAligns(array("R","R"));
                $this->SetWidths(array(175,40)); 
                $this->Row(array(utf8_decode('TOTAL DE DOCUMENTOS PROCESADOS: '.$cant),number_format($total_monto, 2, ',','.')),0,0);         
         
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
    $condicion .= " and tb063.fe_pago >= '". $_GET["fe_inicio"]."' and ";
    $condicion .= " tb063.fe_pago <= '".$_GET["fe_fin"]."' ";  
    if ($_GET["cod_prov"]) $condicion .= " and tb008.nu_codigo = '".$_GET["cod_prov"]."' "; 
  
    if ($_GET["co_tipo"]) $condicion .= " and tb026.co_tipo_solicitud = ".$_GET["co_tipo"]; 

          $conex = new ConexionComun();     
          
//          $sql = "SELECT distinct 
//                    tb008.co_proveedor, tb008.tx_razon_social, tb008.nu_codigo
//                  FROM tb060_orden_pago as tb060
//                  left join tb026_solicitud as tb026 on tb026.co_solicitud = tb060.co_solicitud
//                  left join tb008_proveedor as tb008 on tb026.co_proveedor = tb008.co_proveedor
//                  left join tb027_tipo_solicitud as tb027 on tb027.co_tipo_solicitud = tb026.co_tipo_solicitud
//                  where tb060.in_anulado<>true and tb008.co_proveedor is not null and tb060.fe_pago is not null
//                 $condicion  ";          
          
          $sql = "SELECT distinct tb008.co_proveedor, tb008.tx_razon_social, tb008.nu_codigo
                FROM tb026_solicitud as tb026
                left join tb008_proveedor as tb008 on tb026.co_proveedor = tb008.co_proveedor 
                left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud 
                left join tb063_pago as tb063 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago 
                where tb062.in_anular is not true and tb008.co_proveedor is not null
                 $condicion  ";
                   
           //echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }   
    function getDoc(){
   
          $conex = new ConexionComun();     
          $sql = " SELECT upper(tb027.tx_tipo_solicitud) as tx_tipo_solicitud FROM tb027_tipo_solicitud as tb027 where tb027.co_tipo_solicitud =".$_GET["co_tipo"];
                   
        //   echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    } 
    function getDocumento($prov){
        
    $condicion ="";
    $condicion .= " and tb063.fe_pago >= '". $_GET["fe_inicio"]."' and ";
    $condicion .= " tb063.fe_pago <= '".$_GET["fe_fin"]."' ";  
    if ($_GET["cod_prov"]) $condicion .= " and tb008.nu_codigo = '".$_GET["cod_prov"]."' "; 
  
    if ($_GET["co_tipo"]) $condicion .= " and tb026.co_tipo_solicitud = ".$_GET["co_tipo"]; 

          $conex = new ConexionComun();     
//          $sql = "SELECT distinct 
//                    coalesce(tb060.tx_documento_odp,tb060.tx_documento_odp,tb060.tx_serial) as documento,
//                    tb008.co_proveedor, tb008.tx_razon_social, tb026.co_solicitud,
//                    tb008.nu_codigo, to_char(tb060.fe_pago,'dd/mm/yy') as fecha, 
//                    substring(tb026.tx_observacion,1,30) as tx_observacion, tb060.tx_serial,
//                    tb060.mo_total as monto
//                  FROM tb060_orden_pago as tb060
//                  left join tb026_solicitud as tb026 on tb026.co_solicitud = tb060.co_solicitud
//                  left join tb008_proveedor as tb008 on tb026.co_proveedor = tb008.co_proveedor
//                  left join tb027_tipo_solicitud as tb027 on tb027.co_tipo_solicitud = tb026.co_tipo_solicitud
//                  where tb060.in_anulado<>true and tb008.co_proveedor is not null and tb060.fe_pago is not null
//                  and tb008.co_proveedor = $prov $condicion order by 5";
          
          
          $sql = "SELECT distinct coalesce(tb060.tx_documento_odp,tb060.tx_documento_odp,tb060.tx_serial) as documento, tb008.co_proveedor, tb008.tx_razon_social, tb026.co_solicitud, tb008.nu_codigo, 
                    to_char(tb063.fe_pago,'dd/mm/yy') as fecha, substring(tb026.tx_observacion,1,30) as tx_observacion, tb060.tx_serial, case when tb060.mo_total is null then tb063.nu_monto else tb060.mo_total end  as monto
                    FROM tb026_solicitud as tb026
                    left join tb008_proveedor as tb008 on tb026.co_proveedor = tb008.co_proveedor 
                    left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud 
                    left join tb063_pago as tb063 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago 
                    left join tb060_orden_pago as tb060 on tb060.co_solicitud = tb026.co_solicitud 
                    where tb062.in_anular is not true and tb008.co_proveedor is not null
                    and tb063.fe_pago is not null and tb008.co_proveedor = $prov $condicion order by 5";          
                  
          //echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }    
}

$pdf=new PDF('L','mm','Legal');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
