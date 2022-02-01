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
        //$this->Ln(4);
        //$this->Cell(0,0,utf8_decode('Secretaria de Administración'),0,0,'L');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('[FCPPRA43]'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');                          
    }

    function Footer() {
	$this->SetFont('courier','B',9);     
	$this->SetY(250);
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
         $this->SetWidths(array(150));
         $this->SetX(30);
         $this->SetAligns(array("C")); 
         $this->SetFont('courier','B',12);         
         $this->Row(array(utf8_decode('RELACIÓN DE ORDENES DE PAGO DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
         $this->Ln(2);
         $this->SetWidths(array(200));
         $this->SetAligns(array("L"));           
         $this->SetFont('COURIER','B',8); 
         $this->SetFillColor(255, 255, 255); 
         
         $this->lista_prov = $this->getProveedores();
         
         if ($_GET['nu_codigo']) {
             $proveedor = $this->lista_prov[0]['tx_razon_social'];
         }else $proveedor = "TODOS LOS PROVEEDORES";
         
         if ($_GET['co_tipo']) {
             $co_tipo = $_GET['co_tipo'];
             if ($co_tipo==1) $co_tipo='APROBADAS';
             else $co_tipo='ANULADAS';
         }else $co_tipo = "TODOS LOS ESTADOS";         
         
         $this->Row(array(utf8_decode('PROVEEDOR...........:  ').$proveedor),0,0); 
         $this->Row(array(utf8_decode('ESTADO..............:  ').$co_tipo),0,0); 
      
         $this->SetFont('COURIER','',9);     
         $this->SetWidths(array(15,20,20,20,20,20,20,25,25,25));
         $this->SetAligns(array("C","C","C","C","R","R","R","R","C"));   
         $this->Row(array('Sol.', utf8_decode('Número OP'),'Rif','Fecha','Estado', 'Monto','Deducido','Desafectado','Cancelado','Fecha Pago'),0,0); 
         $this->SetAligns(array("L","C","C","C","R","R","R")); 
         $this->Line(10, 55, 210, 55);        
         $this->Ln(5);
         $mo_total_op = 0;
         $mo_total_ded = 0;

         foreach($this->lista_prov as $key => $data){          
            $this->SetWidths(array(200));
            $this->SetAligns(array("L"));           
            $this->SetFont('COURIER','B',8);           
            $this->Row(array(utf8_decode($data['proveedor'])),0,0); 
            $this->lista_op = $this->getOP($data['nu_codigo']);
            $y = $this->getY();
            $this->Line(10, $y, 60, $y);
            $mo_op = 0;
            $mo_deduc  = 0;
            $mo_subtotal = 0;
         
         foreach($this->lista_op as $key => $campo){              
             
                if($this->getY()>230)
                {	
                $this->addPage();
                $this->SetWidths(array(200));
                $this->SetAligns(array("L"));           
                $this->SetFont('COURIER','B',8); 
                $this->SetFillColor(255, 255, 255);  
                $this->SetX(10);                
                $this->Row(array(utf8_decode('PROVEEDOR...........:  ').$proveedor),0,0); 
                $this->Row(array(utf8_decode('ESTADO..............:  ').$co_tipo),0,0); 

                $this->SetFont('COURIER','',9);     
                $this->SetWidths(array(15,20,20,20,20,20,20,25,25,25)); 
                $this->SetAligns(array("C","C","C","C","R","R","R","R","C"));   
                $this->Row(array('Sol.', utf8_decode('Número OP'),'Rif','Fecha','Estado', 'Monto','Deducido','Desafectado','Cancelado','Fecha Pago'),0,0); 
                $this->SetAligns(array("L","C","C","C","R","R","R")); 
                $this->Line(10, 40, 210, 40);        
                $this->Ln(5);
                $mo_total_op = 0;
                $mo_total_ded = 0; 
                } 
                $this->SetFont('COURIER','',7);  
                $this->SetWidths(array(15,20,20,20,20,20,20,25,25,25));
                $this->SetAligns(array("C","C","C","C","R","R","R","R","C")); 
                $this->Row(array($campo['co_solicitud'],$campo['tx_serial'],$campo['tx_rif'],date("d/m/Y", strtotime($campo['fecha'])),$campo['estatus'],number_format($campo['monto'], 2, ',','.'),number_format($campo['deducido'], 2, ',','.'),number_format(0, 2, ',','.'),number_format($campo['cancelado'], 2, ',','.'), date("d/m/Y", strtotime($campo['fe_pago']))),0,0);         


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
    function getProveedores(){ 
        
        $condicion ="";
        $nu_codigo = $_GET['nu_codigo'];
        if ($_GET["co_tipo"]) $tipo  = $_GET['co_tipo'];  
        else $tipo  = '';
        
       // $nu_codigo = '092604';        
        $condicion .= " tb060.tb060.created_at::date >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb060.tb060.created_at::date <= '".$_GET["fe_fin"]."' ";
        if ($_GET["nu_codigo"]) $condicion .= " and tb008.nu_codigo like '".$nu_codigo."'";
        if ($tipo=='APROBADAS') $condicion .= " and tb060.in_anulado = FALSE ";        
        if ($tipo=='ANULADAS')  $condicion .= " and tb060.in_anulado = TRUE "; 
            
        $conex = new ConexionComun(); 
                  $sql = " SELECT distinct tb008.nu_codigo, (tb008.nu_codigo||'-'||tb008.tx_razon_social) as proveedor, 
                                  upper(tb008.tx_razon_social) as tx_razon_social
                           FROM tb060_orden_pago as tb060
                           left join tb026_solicitud as tb026 on tb060.co_solicitud = tb026.co_solicitud
                           left join tb008_proveedor as tb008 on tb008.co_proveedor = tb026.co_proveedor    
                           where ".$condicion." order by tb008.nu_codigo asc";      
           
         //echo var_dump($sql); exit();  
         $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
         return  $datosSol;  
	
    }     
    function getOP($nu_codigo){ 

        $conex = new ConexionComun(); 
        
        $condicion ="";
        $nu_codigo = $_GET['nu_codigo'];
        if ($_GET["co_tipo"]) $tipo  = $_GET['co_tipo'];  
        else $tipo  = '';
        
       // $nu_codigo = '092604';        
        $condicion .= " tb060.tb060.created_at::date >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb060.tb060.created_at::date <= '".$_GET["fe_fin"]."' ";
        if ($_GET["nu_codigo"]) $condicion .= " and tb008.nu_codigo like '".$nu_codigo."'";
        if ($tipo=='APROBADAS') $condicion .= " and tb060.in_anulado = FALSE ";        
        if ($tipo=='ANULADAS')  $condicion .= " and tb060.in_anulado = TRUE ";         
        
        $sql = " select distinct tb060.co_solicitud, tb008.nu_codigo
        ,tb060.tx_serial
        ,tb008.tx_rif
        ,tb008.tx_razon_social
        ,tb060.created_at as fecha
        ,case when tb060.in_anulado = true then 'Anulada' else case when tb060.in_pagado = true then 'Pagada' else 'Pendiente' end end as estatus
        ,tb060.mo_total as monto
        ,(select COALESCE(sum(mo_retencion),0.00) from tb046_factura_retencion where co_odp = tb060.co_orden_pago) as deducido
        ,0.00 as desafectado
        ,(select COALESCE(sum(mo_pagado),0.00) from tb062_liquidacion_pago where co_odp = tb060.co_orden_pago) as cancelado
        ,tb063.fe_pago
        from tb060_orden_pago tb060
        left join tb026_solicitud tb026 on tb060.co_solicitud = tb026.co_solicitud
        left join tb008_proveedor tb008 on tb026.co_proveedor = tb008.co_proveedor
        left join tb062_liquidacion_pago tb062 on tb060.co_orden_pago = tb062.co_odp
        left join tb063_pago tb063 on tb062.co_liquidacion_pago = tb063.co_liquidacion_pago
         where tb060.tx_serial<>'' and ".$condicion." 
         order by 
         /*tb008.nu_codigo, tb060.tx_serial */
         tb060.tx_serial
         asc";  
           
         //  echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
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

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
