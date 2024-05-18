<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {
        $this->SetFont('courier','B',12);
        $this->Cell(0,0,utf8_decode('<NOMBRE DE LA INSTITUCION>'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Secretaria de Administración'),0,0,'L');
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
         $this->SetWidths(array(210));
         $this->SetX(30);
         $this->SetAligns(array("C")); 
         $this->SetFont('courier','B',12);         
         $this->Row(array(utf8_decode('RELACIÓN DETALLADA DE ORDENES DE PAGO POR PROVEEDOR DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
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
         }else $co_tipo = "TODOS LOS ESTADOS";         
         
         $this->Row(array(utf8_decode('PROVEEDOR...........:  ').$proveedor),0,0); 
         $this->Row(array(utf8_decode('ESTADO..............:  ').$co_tipo),0,0); 

         $this->SetX(10);
      
         $this->SetFont('COURIER','',9);     
         $this->SetWidths(array(20,25,20,20,30,60,30,25,30));
         $this->SetAligns(array("C","L","C","C","L","L","R","R","R"));   
         $this->Row(array('Solicitud', utf8_decode('Número OP'),'Fecha','Estado', utf8_decode('N° Factura'), 'Concepto','Monto O.P.','Deducido','Total'),0,0); 
         $this->SetAligns(array("C","L","C","C","L","L","R","R","R"));   
         $this->Line(10, 55, 270, 55);        
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
             
                if($this->getY()>190)
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
                    $this->SetWidths(array(20,25,20,20,30,60,30,25,30));
                    $this->SetAligns(array("C","L","C","C","L","L","R","R","R"));  
                    $this->Row(array('Solicitud', utf8_decode('Número OP'),'Fecha','Estado', utf8_decode('N° Factura'), 'Concepto','Monto O.P.','Deducido','Total'),0,0); 
                    $this->SetAligns(array("C","L","C","C","R","R","R","R","R"));  
                    $this->Line(10, 40, 270, 40);          
                    $this->Ln(5);
                    $mo_total_op = 0;
                    $mo_total_ded = 0; 
                }

                $this->lista_factura = $this->getFactura($campo['co_orden_pago']);

                $factura = "";

                foreach($this->lista_factura as $key => $campoFactura){
                    $factura .= $campoFactura['nu_factura'].' ';
                }

                $mo_retencion = $this->getFacturaRetencion($campo['co_solicitud']);

                $this->SetX(10); 
                $this->SetFont('COURIER','',7);  
                $this->SetWidths(array(20,25,20,20,30,60,30,25,30));  
                $this->SetAligns(array("C","L","C","C","L","L","R","R","R"));   
                $this->Row(
                    array(
                        $campo['co_solicitud'],
                        $campo['tx_serial']/*.' - '.utf8_decode(trim($campo['de_orden']))*/,
                        date("d/m/Y", strtotime($campo['fe_emision'])),
                        $campo['tipo'],
                        $factura,
                        utf8_decode(trim($campo['de_concepto'])),
                        number_format($campo['mo_total'], 2, ',','.'),
                        //number_format($campo['mo_retencion'], 2, ',','.'),
                        number_format($mo_retencion['mo_retencion'], 2, ',','.'),
                        number_format($campo['mo_pagar'], 2, ',','.')
                    )
                ,0,0);         
             
                $mo_op = $campo['mo_total'] + $mo_op;
                $mo_deduc  = $campo['mo_retencion'] + $mo_deduc;
                $mo_subtotal = $mo_subtotal + $campo['mo_pagar'] ;  

         }

         $this->SetX(10);
         $this->SetFont('COURIER','B',7);
         $this->SetAligns(array("L","L","R","R","R"));
         $this->SetWidths(array(30,145,30,25,30));
         $this->Row(
             array(
                 '',
                 'TOTAL ORDEN DE PAGO.........................:',
                 number_format($mo_op, 2, ',','.'),
                 number_format($mo_deduc, 2, ',','.'), 
                 number_format($mo_subtotal, 2, ',','.')
                ),
            0,0);         
         $mo_total_op = $mo_total_op + $mo_op ;  
         $mo_total_ded = $mo_total_ded + $mo_deduc; 
         }
         
         $this->Ln(10);
         $y = $this->getY();
         $this->Line(170, $y, 204, $y);
         $y = $this->getY();
         $this->Line(210, $y, 250, $y);
         $this->SetFont('COURIER','B',7);  
         $this->SetAligns(array("L","L","R","R","R"));
         $this->SetWidths(array(30,135,30,30,30));
         $this->Row(array('',utf8_decode('TOTAL RELACIÓN.........................:'),number_format($mo_total_op, 2, ',','.'),number_format($mo_total_ded, 2, ',','.')),0,0);         
         
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
        $condicion .= " tb060.fe_emision >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb060.fe_emision <= '".$_GET["fe_fin"]."' ";
        if ($_GET["nu_codigo"]) $condicion .= " and tb008.nu_codigo like '".$nu_codigo."'";
        if ($tipo=='APROBADAS') $condicion .= " and tb060.in_anulado = FALSE ";        
        if ($tipo=='ANULADAS')  $condicion .= " and tb060.in_anulado = TRUE "; 
            
        $conex = new ConexionComun(); 
                  $sql = " SELECT distinct tb008.nu_codigo, (tb008.nu_codigo||'-'||tb008.tx_razon_social) as proveedor, 
                                  upper(tb008.tx_razon_social) as tx_razon_social
                           FROM tb060_orden_pago as tb060
                           left join tb026_solicitud as tb026 on tb060.co_solicitud = tb026.co_solicitud
                           left join tb008_proveedor as tb008 on tb008.co_proveedor = tb026.co_proveedor
                           where ".$condicion." and tb026.co_tipo_solicitud in ( 1, 2, 26, 39, 40, 41 ) order by tb008.nu_codigo asc";      
           
         //echo var_dump($sql); exit();  
         $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
         return  $datosSol;  
	
    }     
    function getOP($nu_codigo){
        
        $condicion ="";  
        $condicion .= " and tb060.fe_emision >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb060.fe_emision <= '".$_GET["fe_fin"]."' ";        

        $conex = new ConexionComun(); 
        $sql = " SELECT case when tb026.co_tipo_solicitud in ( 32, 34 ) then tb146.tx_descripcion else tb026.tx_observacion end as de_orden, 
                                tx_serial,
                                nu_orden_pago, fe_emision,
                                mo_pagar, mo_retencion, mo_total,
                                nu_orden_pago, tb026.co_solicitud,
                            (case when (tb060.in_anulado) then 'ANULADA' else 'APROBADA' end) as tipo,
                            upper(tb052.tx_observacion) as tx_concepto,
                            upper(tb060.tx_concepto) as de_concepto,
                            co_orden_pago
                           FROM tb060_orden_pago as tb060
                           left join tb026_solicitud as tb026 on tb060.co_solicitud = tb026.co_solicitud
                           left join tb146_compromiso_asignacion as tb146 on tb026.co_solicitud = tb146.co_solicitud
                           left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor      
                           left join tb052_compras as tb052 on tb052.co_solicitud = tb060.co_solicitud                       
                           where tb008.nu_codigo like '".$nu_codigo."' ".$condicion." and tb026.co_tipo_solicitud in ( 1, 2, 26, 39, 40, 41 ) order by tx_serial asc ";
                           
            /*$sql = " SELECT case when tb026.co_tipo_solicitud in (32,34) then (tx_serial||' '||tb146.tx_descripcion) else (tx_serial||' '||tb026.tx_observacion) end as orden, 
                           nu_orden_pago, fe_emision,
                           mo_pagar, mo_retencion, mo_total,
                           nu_orden_pago, tb026.co_solicitud,
                       (case when (tb060.in_anulado) then 'ANULADA' else 'APROBADA' end) as tipo,
                       upper(tb052.tx_observacion) as tx_concepto
                      FROM tb060_orden_pago as tb060
                      left join tb026_solicitud as tb026 on tb060.co_solicitud = tb026.co_solicitud
                      left join tb146_compromiso_asignacion as tb146 on tb026.co_solicitud = tb146.co_solicitud
                      left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor      
                      left join tb052_compras as tb052 on tb052.co_solicitud = tb060.co_solicitud                       
                      where tb008.nu_codigo like '".$nu_codigo."' ".$condicion." order by tx_serial asc ";*/
                  
                   //where tb008.nu_codigo =".$_GET['codigo']." order by tx_serial asc ";  
           
          //echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    } 

    function getFactura($codigo){

        $conex = new ConexionComun();

        $sql = "SELECT co_factura, nu_factura
        FROM tb045_factura
        WHERE co_odp = ".$codigo.";";

        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol; 

    }

    function getFacturaRetencion($codigo){

        $conex = new ConexionComun();

        $sql = "SELECT sum(mo_retencion) as mo_retencion
        FROM tb046_factura_retencion
        WHERE co_solicitud = ".$codigo.";";

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

$pdf=new PDF('L','mm','letter');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
