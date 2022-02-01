<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {
        
        $this->empresa = $this->getDatosEmpresa(1);

        //$this->Image("imagenes/gez.png", 20, 7,20);

        if(!empty($this->empresa['tx_imagen_izq'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_izq'], $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
        }
        

        /*if(!empty($this->empresa['tx_imagen_der'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_der'],  $this->empresa['derecha_x'], $this->empresa['derecha_y'], $this->empresa['derecha_w']);
        }*/

        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0,0,0);
        $this->SetY(10);
        $this->SetX(10);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        //$this->Ln(4);
        //$this->SetX(10);
        //$this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACIÓN Y FINANZAS'),0,0,'C');
        $this->Ln(4);
        $this->SetX(10);
        $this->Cell(0,0,utf8_decode('COORDINACIÓN DE CONTABILIDAD'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('San Francisco, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');
        $this->SetFont('Arial','B',10);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));  
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('LIBRO DIARIO'),0,0,'C');                
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('CORRESPONDIENTE DESDE '.$_GET['fe_inicio'].' HASTA '.$_GET['fe_fin']),0,0,'C'); 

    }

    function Footer() {
	$this->SetFont('Arial','',9);     
	$this->SetY(-10);       
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


         $this->lista_anexos = $this->getMovimientos();
         $total_dia_debe = 0;
         $total_dia_haber = 0;
         $fecha = '';
         
         if(count($this->lista_anexos)>0){
         //************ Anexos *****************//
         $this->SetWidths(array(20,20,15,40,115,30,40,30,30)); 
         $this->SetAligns(array("C","C","C","L","L","L","C","L","R","R"));     
         $this->SetFont('Arial','B',8);    
         $this->SetFillColor(201, 199, 199);
         $this->Ln(6);
         $this->SetX(10);
         $this->Row(array(utf8_decode('Nº SOLICITUD'),utf8_decode('FECHA'),utf8_decode('PUB 21'),utf8_decode('CODIGO CONTABLE'),utf8_decode('DESCRIPCIÓN'),utf8_decode('COMPROBANTE'),utf8_decode('TIPO'),utf8_decode('DEBE'),utf8_decode('HABER')),1,1); 
       

         foreach($this->lista_anexos as $key => $campo){
             
             
         if($fecha<>$campo['fecha'] && $fecha<>''){
//         $this->SetWidths(array(275,30,30)); 
//         $this->SetAligns(array("R","R","R","L","L","L","R","R"));              
//         $this->SetFont('Arial','B',8);    
//         $this->SetFillColor(201, 199, 199);
//         $this->Ln(6);
//         $this->SetX(10);
//         $this->Row(array(utf8_decode('TOTAL ').''.$fecha,number_format($total_dia_debe, 2, ',','.'),number_format($total_dia_haber, 2, ',','.')),1,1);
//         
//         $this->SetWidths(array(20,20,15,40,40,75,30,40,30,30));  
//         $this->SetAligns(array("C","C","C","L","L","L","C","L","R","R"));       
//         $this->SetFont('Arial','B',8);    
//         $this->SetFillColor(201, 199, 199);
//         $this->SetX(10);
//         $this->Row(array(utf8_decode('Nº SOLICITUD'),utf8_decode('FECHA'),utf8_decode('PUB 20'),utf8_decode('CODIGO CONTABLE'),utf8_decode('CUENTA CONTABLE'),utf8_decode('DESCRIPCIÓN'),utf8_decode('COMPROBANTE'),utf8_decode('TIPO'),utf8_decode('DEBE'),utf8_decode('HABER')),1,1);         
//             $total_dia_debe =  0;  
//             $total_dia_haber =  0;
             
         }
         
         $this->SetX(10);   
         $this->SetWidths(array(20,20,15,40,115,30,40,30,30));  
         $this->SetAligns(array("C","C","C","L","L","L","C","L","R","R"));     
         $this->SetFillColor(255, 255, 255);                      
         $this->SetFont('Arial','B',8);   
         $this->Row(array($campo['co_solicitud'],$campo['fecha'],$campo['anexo'],utf8_decode($campo['tx_cuenta']),utf8_decode($campo['tx_descripcion']),utf8_decode($campo['nu_comprobante']),utf8_decode($campo['tx_tipo_asiento']),number_format($campo['mo_debe'], 2, ',','.'),number_format($campo['mo_haber'], 2, ',','.')),0,0);         
         
         if($this->getY()>180){
             $this->AddPage();
         //************ Anexos *****************//
         $this->SetWidths(array(20,20,15,40,115,30,40,30,30));   
         $this->SetAligns(array("C","C","C","L","L","L","C","L","R","R"));              
         $this->SetFont('Arial','B',8);    
         $this->SetFillColor(201, 199, 199);
         $this->Ln(6);
         $this->SetX(10);
         $this->Row(array(utf8_decode('Nº SOLICITUD'),utf8_decode('FECHA'),utf8_decode('PUB 21'),utf8_decode('CODIGO CONTABLE'),utf8_decode('DESCRIPCIÓN'),utf8_decode('COMPROBANTE'),utf8_decode('TIPO'),utf8_decode('DEBE'),utf8_decode('HABER')),1,1);


            }
         $total_dia_debe =  $total_dia_debe + $campo['mo_debe'];  
         $total_dia_haber =  $total_dia_haber + $campo['mo_haber'];
         $fecha =  $campo['fecha'];
         }
         
         $this->SetWidths(array(280,30,30)); 
         $this->SetAligns(array("R","R","R","L","L","R","R"));              
         $this->SetFont('Arial','B',8);    
         $this->SetFillColor(201, 199, 199);
         $this->Ln(6);
         $this->SetX(10);
         $this->Row(array(utf8_decode('TOTAL DESDE ').$_GET['fe_inicio'].' HASTA '.$_GET['fe_fin'],number_format($total_dia_debe, 2, ',','.'),number_format($total_dia_haber, 2, ',','.')),1,1);         
         }else{
         $this->Ln(50);
         $this->Cell(0,0,utf8_decode('NO EXISTEN REGISTROS CON LOS PARAMETROS ESPECIFICADOS'),0,0,'C');    
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

    
    function getMovimientos(){

            $fe_inicio    = $_GET['fe_inicio'];    
            $fe_fin       = $_GET['fe_fin'];  
            $conex = new ConexionComun();
            
            $sql = "SELECT to_char(tb061.created_at::date,'dd/mm/yyyy') as fecha,
                case when substring(tb024.nu_cuenta_contable,1,1)::integer= 4 then 300 when substring(tb024.nu_cuenta_contable,1,3)::integer= 301 then 301 when substring(tb024.nu_cuenta_contable,1,3)::integer= 302 then 303 else tb190.codigo end as anexo,tb027.tx_tipo_solicitud||' - '||tb026.tx_observacion as tx_descripcion,
                tb133.tx_tipo_asiento,tb061.mo_debe,tb061.mo_haber,tb061.co_solicitud,tb024.tx_cuenta,tb024.tx_descripcion as desc_cuenta, tb061.nu_comprobante
                from tb061_asiento_contable tb061 
left join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb061.co_cuenta_contable) 
left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = 
case when substring(tb024.nu_cuenta_contable,1,3)::integer = 112 then substring(tb024.nu_cuenta_contable,1,5)
when substring(tb024.nu_cuenta_contable,1,1)::integer = 4 then substring(tb024.nu_cuenta_contable,1,1)
when substring(tb024.nu_cuenta_contable,1,1)::integer = 6 then substring(tb024.nu_cuenta_contable,1,1)	
when substring(tb024.nu_cuenta_contable,1,1)::integer = 7 then substring(tb024.nu_cuenta_contable,1,1)										 
else substring(tb024.nu_cuenta_contable,1,3) end) 
left join tb026_solicitud tb026 on (tb026.co_solicitud = tb061.co_solicitud) 
left join tb027_tipo_solicitud tb027 on (tb027.co_tipo_solicitud = tb026.co_tipo_solicitud)
left join tb133_tipo_asiento tb133 on (tb133.co_tipo_asiento = tb061.co_tipo_asiento) 
where tb061.created_at::date >= '".$fe_inicio."' and tb061.created_at::date <= '".$fe_fin."' order by tb061.created_at::date asc, tb190.co_anexo_contable asc";
                        
//            var_dump($sql);
//            exit();
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

$pdf=new PDF('L','mm','LEGAL');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
