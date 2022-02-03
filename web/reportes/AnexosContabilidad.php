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
        

//        if(!empty($this->empresa['tx_imagen_der'])){
//            $this->Image("imagenes/".$this->empresa['tx_imagen_der'],  $this->empresa['derecha_x'], $this->empresa['derecha_y'], $this->empresa['derecha_w']);
//        }

        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0,0,0);
        $this->SetY(10);
        $this->SetX(10);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        $this->Ln(4);
        $this->SetX(10);
        $this->Cell(0,0,utf8_decode('RIF. G-200005297'),0,0,'C');
        $this->Ln(4);
        $this->SetX(10);
        $this->Cell(0,0,utf8_decode('DIVISION DE CONTABILIDAD'),0,0,'C');
        $this->Ln(4);
//        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');
        $this->SetFont('Arial','B',10);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));  
        $this->Ln(6);
        if($_GET['in_periodo']){
        $this->periodo = $this->getPeriodo();
        if($this->periodo){
        $this->Cell(0,0,utf8_decode('AL PERIODO '.strtoupper(mes($this->periodo['mes'])).' '.$this->periodo['anio']. ' (ABIERTO)'),0,0,'C'); 
        $this->Ln(6);    
        }else{
        $this->Cell(0,0,utf8_decode('AL PERIODO DICIEMBRE 2021 (ABIERTO)'),0,0,'C'); 
        $this->Ln(6);             
        }
        }else{
        $co_mes = $_GET['co_mes'];
        $nu_anio = $_GET['co_anio_fiscal'];            
        $this->Cell(0,0,utf8_decode('AL PERIODO '.strtoupper(mes($co_mes)).' '.$nu_anio.' (CERRADO)'),0,0,'C'); 
         $this->Ln(6);             
        }        


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
        
         $this->lista_anexos = $this->getAnexos();
         $subtotal = 0;
         $anexo = '';

         if(count($this->lista_anexos)>0){          


         foreach($this->lista_anexos as $key => $campo){
             
         if($anexo==''){
             
        $this->SetFont('Arial','B',8);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));  
        $this->Ln(6);
        $this->SetX(10);
        $this->Cell(0,0,utf8_decode('ANEXOS DE: '.$campo['codigo'].' - '.$campo['tx_codigo']),0,0,'C');      
        $this->Ln(6);
        $this->SetX(10);
        //$this->Cell(0,0,utf8_decode('AGOSTO DE 2018'),0,0,'C');
         
         $this->SetWidths(array(150,40)); 
         $this->SetAligns(array("L","R"));              
         $this->SetFont('Arial','B',7);    
         $this->SetFillColor(201, 199, 199);
         $this->Ln(6);
         $this->SetX(10);
         $this->Row(array(utf8_decode('DESCRIPCIÓN'),'SALDO BS.'),1,1);     
         }
         
         
         if($anexo<>$campo['codigo'] && $anexo<>''){
         $this->SetWidths(array(150,40)); 
         $this->SetAligns(array("R","R"));              
         $this->SetFont('Arial','B',7);    
         $this->SetFillColor(255, 255, 255);         
         $this->SetX(10);             
         $this->Row(array('TOTAL .........',number_format($subtotal, 2, ',','.')),1,1);             
        $this->AddPage();   
        $this->SetFont('Arial','B',8);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));  
        $this->Ln(6);
        $this->SetX(10);
        $this->Cell(0,0,utf8_decode('ANEXOS DE: '.$campo['codigo'].' - '.$campo['tx_codigo']),0,0,'C');      
        $this->Ln(6);
        $this->SetX(10);
        //$this->Cell(0,0,utf8_decode('AGOSTO DE 2018'),0,0,'C');
         
         $this->SetWidths(array(150,40));
         $this->SetAligns(array("L","R"));              
         $this->SetFont('Arial','B',7);    
         $this->SetFillColor(201, 199, 199);
         $this->Ln(6);
         $this->SetX(10);
         $this->Row(array(utf8_decode('DESCRIPCIÓN'),'SALDO BS.'),1,1);                  
             
             $subtotal =  0;  
             
         }         
         $this->SetWidths(array(150,40)); 
         $this->SetAligns(array("L","R"));              
         $this->SetFont('Arial','B',7);    
         $this->SetFillColor(255, 255, 255);         
         $this->SetX(10);
         $this->Row(array($campo['nu_cuenta'].' - '.$campo['tx_descripcion'],number_format($campo['saldo_actual'], 2, ',','.')),0,0);       
         
         if($this->getY()>250){
             $this->AddPage();
         //************ Anexos *****************//
        $this->SetFont('Arial','B',8);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));  
        $this->Ln(6);
        $this->SetX(10);
        $this->Cell(0,0,utf8_decode('ANEXOS DE: '.$campo['codigo'].' - '.$campo['tx_codigo']),0,0,'C');      
        $this->Ln(6);
        $this->SetX(10);
        //$this->Cell(0,0,utf8_decode('AGOSTO DE 2018'),0,0,'C');
         
        $this->SetWidths(array(150,40)); 
         $this->SetAligns(array("L","R"));              
         $this->SetFont('Arial','B',7);    
         $this->SetFillColor(201, 199, 199);
         $this->Ln(6);
         $this->SetX(10);
         $this->Row(array(utf8_decode('DESCRIPCIÓN'),'SALDO BS.'),1,1);     

            }         
         
         $subtotal = $campo['saldo_actual'] + $subtotal;      
         $anexo =  $campo['codigo'];
             
         }
         }         
         $this->SetWidths(array(150,40)); 
         $this->SetAligns(array("R","R"));              
         $this->SetFont('Arial','B',7);    
         $this->SetFillColor(255, 255, 255);         
         $this->SetX(10);             
         $this->Row(array('TOTAL .........',number_format($subtotal, 2, ',','.')),1,1);           

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

    
    function getAnexos(){

          $conex = new ConexionComun();  
          
          if($_GET['in_periodo']){          
      $sql = " select sum(saldo_actual) as saldo_actual,codigo,tx_codigo,co_anexo_contable,nu_cuenta,(select tx_descripcion from tb024_cuenta_contable where nu_cuenta_contable = nu_cuenta) from 
(SELECT  (sum(coalesce(acu_deb,0)) + sum(coalesce(mes_deb,0)) + sum(coalesce(pre_deb,0))) - (sum(coalesce(acu_cre,0)) + sum(coalesce(mes_cre,0)) + sum(coalesce(pre_cre,0))) as saldo_actual , codigo,descripcion as tx_codigo,co_anexo_contable,
case when substring(tb024.nu_cuenta_contable,1,3)::integer = 122 then substring(tb024.nu_cuenta_contable,1,3)
when substring(tb024.nu_cuenta_contable,1,3)::integer = 302 then substring(tb024.nu_cuenta_contable,1,3)
when substring(tb024.nu_cuenta_contable,1,1)::integer = 3 then substring(tb024.nu_cuenta_contable,1,3)	
when substring(tb024.nu_cuenta_contable,1,1)::integer = 4 then substring(tb024.nu_cuenta_contable,1,3)										 
else substring(tb024.nu_cuenta_contable,1,9) end as nu_cuenta
from tb024_cuenta_contable tb024
left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = 
case when substring(tb024.nu_cuenta_contable,1,3)::integer = 122 then substring(tb024.nu_cuenta_contable,1,3)
when substring(tb024.nu_cuenta_contable,1,3)::integer = 302 then substring(tb024.nu_cuenta_contable,1,3)
when substring(tb024.nu_cuenta_contable,1,1)::integer = 3 then substring(tb024.nu_cuenta_contable,1,3)	
when substring(tb024.nu_cuenta_contable,1,1)::integer = 4 then substring(tb024.nu_cuenta_contable,1,3)										 
else substring(tb024.nu_cuenta_contable,1,9) end) 
GROUP BY codigo,co_anexo_contable,tx_descripcion,tb024.nu_cuenta_contable) as q1 where saldo_actual <> 0 and substring(nu_cuenta,1,1)::integer <> 7 
group by nu_cuenta,co_anexo_contable,codigo,tx_codigo
order by nu_cuenta ";
          }else{ 
              
    $co_mes = $_GET['co_mes'];
    $nu_anio = $_GET['co_anio_fiscal'];              
              
      $sql = " select sum(saldo_actual) as saldo_actual,codigo,tx_codigo,co_anexo_contable,nu_cuenta,(select tx_descripcion from tb024_cuenta_contable where nu_cuenta_contable = nu_cuenta) from 
(SELECT  (sum(coalesce(acu_debito,0)) + sum(coalesce(mes_debito,0))) - (sum(coalesce(acu_credito,0)) + sum(coalesce(mes_credito,0))) as saldo_actual , codigo,descripcion as tx_codigo,co_anexo_contable,
case when substring(tb024.nu_cuenta_contable,1,1)::integer = 4 then substring(tb024.nu_cuenta_contable,1,3) 
when substring(tb024.nu_cuenta_contable,1,3)::integer = 305 then  substring(tb024.nu_cuenta_contable,1,9)
when substring(tb024.nu_cuenta_contable,1,3)::integer = 302 then  substring(tb024.nu_cuenta_contable,1,5) 
when substring(tb024.nu_cuenta_contable,1,3)::integer = 301 then  substring(tb024.nu_cuenta_contable,1,9) 
when substring(tb024.nu_cuenta_contable,1,5)::integer = 10101 then  substring(tb024.nu_cuenta_contable,1,20)
when substring(tb024.nu_cuenta_contable,1,7)::integer = 1010207 then  substring(tb024.nu_cuenta_contable,1,15)
when substring(tb024.nu_cuenta_contable,1,3)::integer = 102 then  substring(tb024.nu_cuenta_contable,1,7) 
when substring(tb024.nu_cuenta_contable,1,5)::integer = 20105 then  substring(tb024.nu_cuenta_contable,1,15) 
else substring(tb024.nu_cuenta_contable,1,9) end as nu_cuenta
from tb179_resumen_mensual_contable tb079
left join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb079.co_cuenta_contable)
left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = case when substring(tb024.nu_cuenta_contable,1,1)::integer = 4 then substring(tb024.nu_cuenta_contable,1,1) 
when substring(tb024.nu_cuenta_contable,1,3)::integer = 305 then  substring(tb024.nu_cuenta_contable,1,3) 
when substring(tb024.nu_cuenta_contable,1,3)::integer = 302 then  substring(tb024.nu_cuenta_contable,1,3)
when substring(tb024.nu_cuenta_contable,1,3)::integer = 301 then  substring(tb024.nu_cuenta_contable,1,3) 
when substring(tb024.nu_cuenta_contable,1,3)::integer = 101 then  substring(tb024.nu_cuenta_contable,1,9) 
else substring(tb024.nu_cuenta_contable,1,7) end)
where co_mes = $co_mes and nu_anio = $nu_anio and in_cierre is not true
GROUP BY codigo,co_anexo_contable,tx_descripcion,tb024.nu_cuenta_contable) as q1 where saldo_actual <> 0 and substring(nu_cuenta,1,1)::integer <> 7 
group by nu_cuenta,co_anexo_contable,codigo,tx_codigo
order by co_anexo_contable,nu_cuenta ";
          }     
          //echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }

    function getPeriodo(){

        $sql = "SELECT EXTRACT(YEAR FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE) AS anio,lpad(EXTRACT(MONTH FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE)::text,2,'0') AS mes from 
tb180_maestro_contable order by co_maestro_contable desc limit 1";

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];
  
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
