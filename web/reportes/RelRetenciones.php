<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {
        
        $this->empresa = $this->getDatosEmpresa(1);
        if (!empty($this->empresa['tx_imagen_izq'])) {
            $this->Image("imagenes/" . $this->empresa['tx_imagen_izq'], $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
        }

        /*if(!empty($this->empresa['tx_imagen_cen'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_cen'],  $this->empresa['centro_x'], $this->empresa['centro_y'], $this->empresa['centro_w']);
        }*/

        /*  if(!empty($this->empresa['tx_imagen_der'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_der'],  $this->empresa['derecha_x'], $this->empresa['derecha_y'], $this->empresa['derecha_w']);
        }*/

        $this->SetFont('Arial', 'B', 9);

        $this->SetTextColor(0, 0, 0);
        $this->SetY(12);
        $this->Cell(0, 0, utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode($this->empresa['nb_empresa']), 0, 0, 'C');
        if (!empty($this->empresa['nb_institucion'])) {
            $this->Ln(2);
            $this->SetX(52);
            $this->MultiCell(110,4,utf8_decode($this->empresa['nb_institucion']),0,'C',0); 
            $this->Ln(2);
        }else{
        $this->Ln(4);    
        }
        $this->Cell(0, 0, utf8_decode('RIF. ' . $this->empresa['tx_rif']), 0, 0, 'C');
        $this->Ln(4);                         
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
         $this->SetFont('Arial','B',12);         
         $this->Row(array(utf8_decode('RELACIÓN DE RETENCIONES ')),0,0);
         $this->Ln(2);
         $this->SetWidths(array(200));
         $this->SetAligns(array("L"));           
         $this->SetFont('Arial','B',8); 
         $this->SetFillColor(255, 255, 255); 
         
         $contenido = "TODAS LAS RETENCIONES";
            
         $this->Row(array(utf8_decode('RETENCION:  ').$contenido),0,0); 
         $this->Row(array(utf8_decode('FECHA:      ').' UN RANGO DE FECHA DEL: '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin']))),0,0); 
      

         
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



            $this->datos = $this->getRetenciones();
            
           if(count($this->datos)>0){
               
            $this->Ln(10);

            $this->SetFont('Arial','B',7);     
            $this->SetWidths(array(25,60,15,50,25,25,25 ));  
            $this->SetAligns(array("C","C","C","L","R","R","C"));
            $this->Row(array('Orden de Pago','Beneficiario','Fecha', 'Tipo de Retencion',utf8_decode( '% Retención'), utf8_decode('Monto Retencion')),1,0); 
            $this->SetAligns(array("C","L","C","L","R","R"));                  
            //$this->Ln(2);
            $nu_total=0;
            $nu_base_imponible=0;
            $nu_iva_factura=0;
            $nu_iva_retencion=0;
     
            foreach($this->datos as $key => $campo){
                
                $this->setX(10);
                $this->SetFont('Arial','',6);
                $this->SetWidths(array(25,60,15,50,25,25,25 ));  
                $this->Row(array($campo['tx_serial'], utf8_decode($campo['rif_prov'].' - '.$campo['den_pro']), $campo['fe_pago'], 
                utf8_decode($campo['tx_tipo_retencion']), 
                utf8_decode($campo['po_retencion']), 
                number_format($campo['mo_retencion'], 2, ',','.') ),1,0);

                $nu_total = $campo['mo_retencion'] + $nu_total;
//                $nu_base_imponible = $campo['nu_base_imponible'] + $nu_base_imponible;
//                $nu_iva_factura = $campo['nu_iva_factura'] + $nu_iva_factura;
//                $nu_iva_retencion = $campo['nu_iva_retencion'] + $nu_iva_retencion;
//
//                $nu_total_general = $campo['nu_total'] + $nu_total_general;
//                $nu_base_imponible_general = $campo['nu_base_imponible'] + $nu_base_imponible_general;
//                $nu_iva_factura_general = $campo['nu_iva_factura'] + $nu_iva_factura_general;
//                $nu_iva_retencion_general = $campo['nu_iva_retencion'] + $nu_iva_retencion_general;

                if($this->getY()>240){

                    $this->AddPage();
                     $this->Ln(6);
                     $this->SetWidths(array(150));
                     $this->SetX(30);
                     $this->SetAligns(array("C")); 
                     $this->SetFont('Arial','B',12);         
                     $this->Row(array(utf8_decode('RELACIÓN DE RETENCIONES ')),0,0);
                     $this->Ln(2);
                     $this->SetWidths(array(200));
                     $this->SetAligns(array("L"));           
                     $this->SetFont('Arial','B',8); 
                     $this->SetFillColor(255, 255, 255); 

                     $contenido = "TODAS LAS RETENCIONES";

                     $this->Row(array(utf8_decode('RETENCION:  ').$contenido),0,0); 
                     $this->Row(array(utf8_decode('FECHA:      ').' UN RANGO DE FECHA DEL: '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin']))),0,0); 

                    $this->Ln(5);
                    $this->SetFont('Arial','B',7);     
                    $this->SetWidths(array(25,60,15,50,25,25,25 ));  
                    $this->SetAligns(array("C","C","C","L","R","R","C"));   
                    $this->Row(array('Orden de Pago','Beneficiario','Fecha', 'Tipo de Retencion',utf8_decode( '% Retención'), utf8_decode('Monto Retencion')),1,0); 
                    $this->SetAligns(array("C","L","C","L","R","R"));   

                }
                
            }

        }

        $this->Ln(5);
        $this->setX(10);
        $this->SetFont( 'Arial', 'B', 8);
        $this->SetWidths(array(175,25,25,25,25 )); 
        $this->SetAligns(array("R","R","L","L","L"));
        $this->Row(array(utf8_decode('TOTAL: '), 
        number_format($nu_total, 2, ',','.') ),0,0);
        
        
                 
         
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
        $condicion .= " tb063.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb063.fe_pago <= '".$_GET["fe_fin"]."' ";
    

        $conex = new ConexionComun();
        
        $sql = "SELECT tb045.co_iva_retencion
        FROM tb045_factura as tb045
        inner join tb008_proveedor as tb008 on tb008.co_proveedor = tb045.co_proveedor
        inner join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
        inner join tb060_orden_pago as tb060 ON tb060.co_orden_pago = tb045.co_odp
        inner join tb062_liquidacion_pago as tb062 ON tb062.co_odp = tb060.co_orden_pago
        inner join tb063_pago as tb063 ON tb063.co_liquidacion_pago = tb062.co_liquidacion_pago
        WHERE ".$condicion."
        group by tb045.co_iva_retencion order by 1 ASC;";
        
//         echo var_dump($sql); exit();
        
        return $conex->ObtenerFilasBySqlSelect($sql);

    }

    function getRetenciones(){

        $condicion ="";    
        $condicion .= " tb063.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb063.fe_pago <= '".$_GET["fe_fin"]."' ";
    

        $conex = new ConexionComun();

       $sql = "SELECT  inicial||tx_rif as rif_prov, 
        tx_razon_social as den_pro, nu_factura as nro_dcto, 
        nu_control as nro_cont, nu_total, nu_iva_factura, nu_iva_retencion,tb046.po_retencion,tb046.mo_retencion, 
        tb060.tx_serial, to_char(tb063.fe_pago, 'DD/MM/YYYY') as fe_pago, nu_base_imponible,tx_tipo_retencion
          FROM tb045_factura as tb045
          inner join tb008_proveedor as tb008 on tb008.co_proveedor = tb045.co_proveedor
          inner join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
          inner join tb060_orden_pago as tb060 ON tb060.co_orden_pago = tb045.co_odp
          inner join tb062_liquidacion_pago as tb062 ON tb062.co_odp = tb060.co_orden_pago
          inner join tb063_pago as tb063 ON tb063.co_liquidacion_pago = tb062.co_liquidacion_pago
          inner join tb046_factura_retencion as tb046 ON tb046.co_factura = tb045.co_factura
          inner join tb041_tipo_retencion as tb041 ON tb041.co_tipo_retencion = tb046.co_tipo_retencion
          WHERE tb045.in_anular is not true and tb060.in_anular is not true AND tb060.in_anulado is not true and ".$condicion."
          order by tb063.fe_pago ASC,tb060.tx_serial asc,tx_tipo_retencion asc;";  
        
//        echo var_dump($sql); exit();
         
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
    
    function getDatosEmpresa( $codigo){

        $sql = "SELECT co_empresa, nb_empresa, nb_institucion, co_estado, co_municipio, tx_rif, tx_nit, 
        tx_direccion, tx_imagen_der, tx_imagen_izq, tx_imagen_cen, nu_telefono, 
        tx_sigla,
        op_imagen->'izquierda'->0 as izquierda_x,
        op_imagen->'izquierda'->1 as izquierda_y,
        op_imagen->'izquierda'->2 as izquierda_w,
        op_imagen->'centro'->0 as centro_x,
        op_imagen->'centro'->1 as centro_y,
        op_imagen->'centro'->2 as centro_w,
        op_imagen->'derecha'->0 as derecha_x,
        op_imagen->'derecha'->1 as derecha_y,
        op_imagen->'derecha'->2 as derecha_w
        FROM public.tb015_empresa
        WHERE co_empresa = ".$codigo.";";

        $conex = new ConexionComun();
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
