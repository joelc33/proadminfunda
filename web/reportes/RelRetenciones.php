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
        $this->Cell(0,0,utf8_decode('Coordinación General de Administración'),0,0,'L');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('[FCPPR028]'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('San Francisco, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');                          
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
         $this->Row(array(utf8_decode('RELACIÓN DE RETENCIONES ')),0,0);
         $this->Ln(2);
         $this->SetWidths(array(200));
         $this->SetAligns(array("L"));           
         $this->SetFont('COURIER','B',8); 
         $this->SetFillColor(255, 255, 255); 
         
         $this->lista_ret = $this->getRetenciones();
         
         if ($_GET['nu_codigo']) {
             $contenido = $this->lista_ret[0]['tx_tipo_retencion'];
         }else $contenido = "TODAS LAS RETENCIONES";
         
//         $this->Row(array(utf8_decode('CONTENIDO:  ').$contenido),0,0);   
         $this->Row(array(utf8_decode('RETENCION:  ').$contenido),0,0); 
         $this->Row(array(utf8_decode('FECHA:      ').' UN RANGO DE FECHA DEL: '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin']))),0,0); 
      
//         $this->SetFont('COURIER','',9);     
//         $this->SetWidths(array(30,20,20,20,20,20,20,20,20)); 
//         $this->SetAligns(array("L","C","C","C","C","R","R","R","R"));   
//         $this->Row(array('','Orden de Pago','Beneficiario','Fecha', 'Monto Factura','Obj. de Ret.','Monto Deduc.','Nro. Cheque','Fecha'),0,0); 
//         $this->SetAligns(array("L","C","C","L","L","R","R","R")); 
//         $this->Line(10, 65, 210, 65); 
         
         $this->SetY(50);
         $x =  $this->getX();
         $campo='';
         $this->getX($x);

         $this->datos_grupo = $this->getGrupo();
         $this->datos_cuenta = $this->getCuenta( 92);

         $nu_total_general=0;
         $nu_base_imponible_general=0;
         $nu_iva_factura_general=0;
         $nu_iva_retencion_general=0;         

                 foreach($this->datos_grupo as $key => $campo1){

            $this->Ln(5);
            $this->setX(10);
            $this->SetFont('Arial','',7);     
            $this->SetWidths(array(140 ));  
            $this->SetAligns(array("L",));   
            $this->Row(array( 'PORCENTAJE DE RETENCION: '.$campo1["co_iva_retencion"]  ),0,0); 
//            $this->Ln(2);
//            $this->Row(array( utf8_decode('CUENTA N°: '.$this->datos_cuenta["tx_cuenta_bancaria"].' - '.$this->datos_cuenta["tx_descripcion"] )  ),0,0); 
            $this->Ln(2);

            $this->datos = $this->getRetenciones( $campo1["co_iva_retencion"]);
        
            $this->SetFont('Arial','',7);     
            $this->SetWidths(array(140 ));  
            $this->SetAligns(array("L",));   
            $this->Row(array( 'RANGO DE FECHA DEL: '.$_GET["fe_inicio"].' AL: '.$_GET["fe_fin"]  ),0,0); 
            $this->Ln(2);
            $this->SetFont('Arial','B',7);     
            $this->SetWidths(array(25,60,15,25,25,25,25 ));  
            $this->SetAligns(array("C","C","C","C","C","C","C"));   
            $this->Row(array('Orden de Pago','Beneficiario','Fecha', 'Monto Factura.', 'Base Imp.', 'Obj. de Ret.', 'Monto de Deduc.'),1,0); 
            $this->SetAligns(array("C","L","C","L","L","L"));                  
            //$this->Ln(2);
            $nu_total=0;
            $nu_base_imponible=0;
            $nu_iva_factura=0;
            $nu_iva_retencion=0;
     
            foreach($this->datos as $key => $campo){
                
                $this->setX(10);
                $this->SetFont('Arial','',6);
                $this->SetWidths(array(25,60,15,25,25,25,25 )); 
                $this->Row(array($campo['tx_serial'], utf8_decode($campo['rif_prov'].' - '.$campo['den_pro']), $campo['fe_pago'], 
                number_format($campo['nu_total'], 2, ',','.'), 
                number_format($campo['nu_base_imponible'], 2, ',','.'), 
                number_format($campo['nu_iva_factura'], 2, ',','.'), 
                number_format($campo['nu_iva_retencion'], 2, ',','.') ),1,0);

                $nu_total = $campo['nu_total'] + $nu_total;
                $nu_base_imponible = $campo['nu_base_imponible'] + $nu_base_imponible;
                $nu_iva_factura = $campo['nu_iva_factura'] + $nu_iva_factura;
                $nu_iva_retencion = $campo['nu_iva_retencion'] + $nu_iva_retencion;

                $nu_total_general = $campo['nu_total'] + $nu_total_general;
                $nu_base_imponible_general = $campo['nu_base_imponible'] + $nu_base_imponible_general;
                $nu_iva_factura_general = $campo['nu_iva_factura'] + $nu_iva_factura_general;
                $nu_iva_retencion_general = $campo['nu_iva_retencion'] + $nu_iva_retencion_general;

                if($this->getY()>240){

                    $this->AddPage();
                    $this->setX(10);
                    $this->Ln(10);
                    $this->SetFont('Arial','',7);     
                    $this->SetWidths(array(140 ));  
                    $this->SetAligns(array("L",));   
                    $this->Row(array( 'PORCENTAJE DE RETENCION: '.$campo1["co_iva_retencion"]  ),0,0); 
//                    $this->Ln(2);
//                    $this->Row(array( utf8_decode('CUENTA N°: '.$this->datos_cuenta["tx_cuenta_bancaria"].' - '.$this->datos_cuenta["tx_descripcion"] )  ),0,0); 
                    $this->Ln(2);

                    $this->SetFont('Arial','',7);     
                    $this->SetWidths(array(140 ));  
                    $this->SetAligns(array("L",));   
                    $this->Row(array( 'RANGO DE FECHA DEL: '.$_GET["fe_inicio"].' AL: '.$_GET["fe_fin"]  ),0,0); 
                    $this->Ln(2);
                    $this->SetFont('Arial','B',7);     
                    $this->SetWidths(array(25,60,15,25,25,25,25 ));  
                    $this->SetAligns(array("C","C","C","C","C","C","C"));   
                    $this->Row(array('Orden de Pago','Beneficiario','Fecha', 'Monto Factura.', 'Base Imp.', 'Obj. de Ret.', 'Monto de Deduc.'),1,0); 
                    $this->SetAligns(array("C","L","C","L","L","L"));   

                }
                
            }

            $this->setX(10);
            $this->SetFont( 'Arial', 'B', 7);
            $this->SetWidths(array(100,25,25,25,25 )); 
            $this->SetAligns(array("C","L","L","L","L"));
            $this->Row(array(utf8_decode('TOTAL PROCENTAJE: '.$campo1["co_iva_retencion"]), 
            number_format($nu_total, 2, ',','.'), 
            number_format($nu_base_imponible, 2, ',','.'), 
            number_format($nu_iva_factura, 2, ',','.'), 
            number_format($nu_iva_retencion, 2, ',','.') ),1,0);

            if($this->getY()>240){

                $this->AddPage();
                $this->setX(10);
                $this->Ln(10);
                $this->SetFont('Arial','',7);     
                $this->SetWidths(array(140 ));  
                $this->SetAligns(array("L",));   
                $this->Row(array( 'PORCENTAJE DE RETENCION: '.$campo1["co_iva_retencion"]  ),0,0); 
//                $this->Ln(2);
//                $this->Row(array( utf8_decode('CUENTA N°: '.$this->datos_cuenta["tx_cuenta_bancaria"].' - '.$this->datos_cuenta["tx_descripcion"] )  ),0,0); 
                $this->Ln(2);

                $this->SetFont('Arial','',7);     
                $this->SetWidths(array(140 ));  
                $this->SetAligns(array("L",));   
                $this->Row(array( 'RANGO DE FECHA DEL: '.$_GET["fe_inicio"].' AL: '.$_GET["fe_fin"]  ),0,0); 
                $this->Ln(2);
                $this->SetFont('Arial','B',7);     
                $this->SetWidths(array(25,60,15,25,25,25,25 ));  
                $this->SetAligns(array("C","C","C","C","C","C","C"));   
                $this->Row(array('Orden de Pago','Beneficiario','Fecha', 'Monto Factura.', 'Base Imp.', 'Obj. de Ret.', 'Monto de Deduc.'),1,0); 
                $this->SetAligns(array("C","L","C","L","L","L"));   

            }

        }

        $this->Ln(5);
        $this->setX(10);
        $this->SetFont( 'Arial', 'B', 8);
        $this->SetWidths(array(100,25,25,25,25 )); 
        $this->SetAligns(array("C","L","L","L","L"));
        $this->Row(array(utf8_decode('TOTAL GENERAL: '), 
        number_format($nu_total_general, 2, ',','.'), 
        number_format($nu_base_imponible_general, 2, ',','.'), 
        number_format($nu_iva_factura_general, 2, ',','.'), 
        number_format($nu_iva_retencion_general, 2, ',','.') ),0,0);
         
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
    
function getGrupo(){

        $condicion ="";    
        $condicion .= " tb060.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb060.fe_pago <= '".$_GET["fe_fin"]."' ";
    

        $conex = new ConexionComun();
        
        $sql = "SELECT tb045.co_iva_retencion
        FROM tb045_factura as tb045
        inner join tb008_proveedor as tb008 on tb008.co_proveedor = tb045.co_proveedor
        inner join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
        inner join tb060_orden_pago as tb060 ON tb060.co_orden_pago = tb045.co_odp
        WHERE ".$condicion."
        group by tb045.co_iva_retencion order by 1 ASC;";
        
        return $conex->ObtenerFilasBySqlSelect($sql);

    }

    function getRetenciones( $co_iva_retencion){

        $condicion ="";    
        $condicion .= " tb060.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb060.fe_pago <= '".$_GET["fe_fin"]."' ";
    

        $conex = new ConexionComun();

        $sql = "SELECT 'G200036524'::text as rif_gob, to_char(tb060.fe_pago, 'YYYYMM') as per_imp, tb045.fe_emision as fec_doc, 'C'::text as compra, '01'::text as factura, 
        inicial||tx_rif as rif_prov, 
        tx_razon_social as den_pro, nu_factura as nro_dcto, 
        nu_control as nro_cont, nu_total, nu_iva_factura, nu_iva_retencion, 
        to_char(tb060.fe_pago, 'YYYYMM')||lpad((tb045.co_solicitud)::text, 8, '0')::text as nro_com, 0 as dcto_af, 
        0 as mont_ex, co_iva_factura as alicuota, 0 as nro_exp,
        tx_serial, to_char(tb045.fe_emision, 'DD/MM/YYYY') as fe_emision, to_char(tb060.fe_pago, 'DD/MM/YYYY') as fe_pago, nu_base_imponible
          FROM tb045_factura as tb045
          inner join tb008_proveedor as tb008 on tb008.co_proveedor = tb045.co_proveedor
          inner join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
          inner join tb060_orden_pago as tb060 ON tb060.co_orden_pago = tb045.co_odp
          WHERE tb045.co_iva_retencion = ".$co_iva_retencion." AND ".$condicion."
          order by tx_rif ASC, tb060.fe_pago ASC;";                 
         
          return $conex->ObtenerFilasBySqlSelect($sql);
  
    }

    function getCuenta( $cuenta){

        $conex = new ConexionComun();

            $sql = "SELECT co_cuenta_bancaria, tx_cuenta_bancaria, co_banco, co_tipo_cuenta, 
            co_empresa, in_activo, co_descripcion_cuenta, co_cuenta_contable, 
            mo_disponible, tx_descripcion, tip_cuenta, tx_cuenta_contable, 
            mo_ingreso, mo_egreso, tip_mov, nu_contrato
            FROM public.tb011_cuenta_bancaria
            WHERE co_cuenta_bancaria = ".$cuenta.";";
                   
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

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
