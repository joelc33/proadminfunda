<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->empresa = $this->getDatosEmpresa(1);

        if(!empty($this->empresa['tx_imagen_izq'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_izq'], $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
        }
        

        if(!empty($this->empresa['tx_imagen_der'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_der'],  $this->empresa['derecha_x'], $this->empresa['derecha_y'], $this->empresa['derecha_w']);
        }

        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0,0,0);
        $this->SetY(10);
        $this->SetX(10);
        $this->Cell(0,0,utf8_decode('<NOMBRE DE LA INSTITUCION>'),0,0,'C');
        $this->Ln(4);
        $this->SetX(10);
        //$this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACIÓN Y FINANZAS'),0,0,'C');
        $this->Ln(4);
        $this->SetX(10);
        $this->Cell(0,0,utf8_decode('RECURSOS HUMANOS'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');
        $this->SetFont('Arial','B',10);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));  
        $this->Ln(8);
        $this->Cell(0,0,utf8_decode('RELACIÓN DE PROVEEDORES Y SINDICATOS DESDE  '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin']))),0,0,'C');       

             

    }

    function Footer() {
	$this->SetFont('Arial','',9);     
	$this->SetY(-20);
        $this->Cell(0,0,utf8_decode('______________________________________________'),0,0,'C');
        $this->Ln(4);
//	$this->Cell(0,0,utf8_decode('Dra. NELLY SANCHEZ'),0,0,'C'); 
//        $this->Ln(4);
	$this->Cell(0,0,utf8_decode('DIRECTOR DE RECURSOS HUMANOS'),0,0,'C'); 
        $this->Ln(4);      
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
         $this->SetFont('Arial','B',8);     
         $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(30,60,25,30,30,25,35,35));  
         $this->SetAligns(array("L","L","R","R","R","R","R","R"));
         $this->Row(array(utf8_decode('Nº'),utf8_decode('CONCEPTOS'),'CANTIDAD','DEDUCCION','APORTE', 'TOTAL'),1,1); 
         $this->SetFillColor(255, 255, 255);
         $codigo_proveedor =='';
         $subtotal = 0;
         $subtotal_aporte = 0;
         $subtotal_deduccion = 0;
         $this->lista_conceptos = $this->getConceptos();

         foreach($this->lista_conceptos as $key => $campo){ 
             
                if($this->getY()>230)
                {	
                 $this->addPage();
                 $this->Ln(6);
                 $this->SetFont('Arial','B',8);     
                 $this->SetFillColor(201, 199, 199);
                 $this->SetWidths(array(30,60,25,30,30,25,35,35));  
                 $this->SetAligns(array("L","L","R","R","R","R","R","R"));
                 $this->Row(array(utf8_decode('Nº'),utf8_decode('CONCEPTOS'),'CANTIDAD','DEDUCCION','APORTE', 'TOTAL'),1,1); 
                 $this->SetFillColor(255, 255, 255);
                } 
                
                 
                 $this->SetFont('Arial','B',8);     
                 $this->SetFillColor(201, 199, 199);
                 $this->SetWidths(array(30,60,25,30,30,25,35,35)); 
                 $this->SetAligns(array("L","L","R","R","R","R","R"));
                 if($codigo_proveedor ==''){
                 $this->Row(array($campo['codigo_proveedor'],$campo['desc_concepto'],'','','',''),1,1);
                 }
                 if($codigo_proveedor <> $campo['codigo_proveedor'] && $codigo_proveedor<>''){
                 $this->Row(array('','','TOTALES.....',number_format($subtotal_deduccion, 2, ',','.'),number_format($subtotal_aporte, 2, ',','.'),number_format($subtotal, 2, ',','.')),0,0);
                 $this->Row(array($campo['codigo_proveedor'],$campo['desc_concepto'],'','','',''),1,1);
                 

                 $subtotal_aporte = 0;
                 $subtotal_deduccion = 0;
                 $subtotal = 0;
                 }
                 $subtotal = $subtotal + $campo['nu_monto'];
                 $total = $total + $campo['nu_monto'];
                 if($campo['co_tipo_concepto']==3){
                 $subtotal_aporte = $subtotal_aporte +  $campo['nu_monto'];
                 $total_aporte = $total_aporte + $campo['nu_monto'];
                 $this->Row(array($campo['nu_concepto'],$campo['tx_concepto'],$campo['nu_cantidad'],'0.00',number_format($campo['nu_monto'], 2, ',','.'),number_format($campo['nu_monto'], 2, ',','.')),0,0);         
                 }else{
                 $subtotal_deduccion = $subtotal_deduccion + $campo['nu_monto'];
                 $total_deduccion = $total_deduccion + $campo['nu_monto'];
                 $this->Row(array($campo['nu_concepto'],$campo['tx_concepto'],$campo['nu_cantidad'],number_format($campo['nu_monto'], 2, ',','.'),'0.00',number_format($campo['nu_monto'], 2, ',','.')),0,0);    
                 }
                 $codigo_proveedor = $campo['codigo_proveedor'];
               } 
               $this->Row(array('','','TOTALES.....',number_format($subtotal_deduccion, 2, ',','.'),number_format($subtotal_aporte, 2, ',','.'),number_format($subtotal, 2, ',','.')),1,1);
               $this->Ln(6);
               $this->Row(array('','','TOTALES.....',number_format($total_deduccion, 2, ',','.'),number_format($total_aporte, 2, ',','.'),number_format($total, 2, ',','.')),1,1);

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
   
    function getConceptos(){

        $condicion ="";    
        $condicion .= " tb013.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb013.fe_pago <= '".$_GET["fe_fin"]."' ";
        $codigo_proveedor = $_GET["codigo_proveedor"];
        if($codigo_proveedor){
        $condicion .= " and tb106.codigo_proveedor = '".$codigo_proveedor."' ";    
        }        
        
        $conex = new ConexionComun(); 
                  $sql = "select COUNT(DISTINCT id_tbrh002_ficha) as nu_cantidad, sum(nu_monto) as nu_monto , tb014.nu_concepto,tb014.tx_concepto,tb014.co_tipo_concepto,
                      ( select codigo_proveedor from tbrh106_concepto_proveedor where nu_concepto =  tb014.nu_concepto) as codigo_proveedor, 
                      ( select desc_concepto from tbrh106_concepto_proveedor where nu_concepto =  tb014.nu_concepto) as desc_concepto
                      from tbrh013_nomina tb013
inner join tbrh061_nomina_movimiento tb061 on (tb061.id_tbrh013_nomina = tb013.co_nomina)
inner join tbrh014_concepto tb014 on (tb014.co_concepto = tb061.id_tbrh014_concepto)
inner join tb026_solicitud tb026 on (tb026.co_solicitud = tb013.co_solicitud)
inner join tbrh106_concepto_proveedor tb106 on (tb106.nu_concepto = tb014.nu_concepto)
where $condicion and tb013.id_tbrh060_nomina_estatus = 3 and tb014.co_tipo_concepto in (2,3) and tb026.in_patria is true
 group by tb014.nu_concepto, tb014.tx_concepto,tb014.co_tipo_concepto order by codigo_proveedor";
         //  echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }   
    
    function getDatosEmpresa( $codigo){

        $sql = "SELECT co_empresa, nb_empresa, co_estado, co_municipio, tx_rif, tx_nit, 
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
