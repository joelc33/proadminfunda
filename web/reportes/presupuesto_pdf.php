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
        $this->Cell(0,0,utf8_decode('Coordinación de Presupuesto'),0,0,'L');        
        $this->Ln(4);
      //  $this->Cell(0,0,utf8_decode('[FPRERB57]'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
//        $this->Cell(0,0,utf8_decode('Fecha de Emisión '.date("d").'/'.date("m").'/'.date("Y")),0,0,'R'); 
        
   }

    function Footer() {
	$this->SetFont('courier','B',9);     
	$this->SetY(195);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');  
    }

    function dwawCell($title,$data) {
        $width = 8;
        $this->SetFont('courier','B',12);
        $y =  $this->getY() * 20;
        $x =  $this->getX();
        $this->SetFillColor(206,230,100);
        $this->MultiCell(175,8,$title,0,1,'L',0);
        $this->SetY($y);
        $this->SetFont('courier','',12);
        $this->SetFillColor(206,230,172);
        $w=$this->GetStringWidth($title)+3;
        $this->SetX($x+$w);
        $this->SetFillColor(206,230,172);
        $this->MultiCell(175,8,$data,0,1,'J',0);

    }

    function ChapterBody() {
       
        $this->Ln(2);        
         
        if ($_GET["ejercicio"]) $anio=$_GET["ejercicio"];
        else if ($_GET["fe_inicio"]) $anio= date("Y", strtotime($_GET["fe_inicio"]));     
        
         $Y = $this->GetY();  
         $this->SetY($Y+12);          
         $this->SetFont('courier','B',12);  
         $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
         $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA - '.$anio),0,0,'C'); 
         $this->Ln(2);          
         $this->SetY($Y);  
         $this->SetFont('courier','',8); 
        $this->SetWidths(array(100));
        $this->SetAligns(array("L")); 
        $this->SetX(10);         
//        $this->Row(array(utf8_decode('PERIODO....:  '.$_GET["fe_inicio"]." hasta ".$_GET["fe_fin"])),0,0);   
        $this->SetX(10);          
//        $this->Row(array(utf8_decode('TIPO.......:  ')),0,0);    

        $this->Ln(16);       
        $this->SetFont('courier','B',9);
        $this->SetWidths(array(45,45,30,25,25,30,30,30,25,25,20,25));
        $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C"));       
        $this->SetX(10); // configura la linea donde comenzara escribir en el eje de y       
        $this->Row(array('Partida',utf8_decode('Descripción'),'Presupuesto Inicial','Aumento',utf8_decode('Disminución'),'Presupuesto Modificado','Comprometido','Disponible','Causado','Pagado','Por Pagar'),0,0);
        $this->Line(10, 55, 350, 55);                  
        $this->SetAligns(array("L","L","R","R","R","R","R","R","R","R","R","R","R"));                 

         $campo='';
        
         $total_ley = 0;
         $this->Ln(2);
         $this->SetFont('courier','B',9);
         $this->SetWidths(array(100));
         $this->SetAligns(array("L"));
         
	 $this->lista_partidas = $this->partidas();          
         
	 foreach($this->lista_partidas as $key => $campo){
            if($this->getY()>170){
                $this->AddPage(); 
         $Y = $this->GetY();  
         $this->SetY($Y+12);          
         $this->SetFont('courier','B',12);  
         $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
         $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA - '.$anio),0,0,'C'); 
         $this->Ln(2);          
         $this->SetY($Y);  
         $this->SetFont('courier','',8); 
        $this->SetWidths(array(100));
        $this->SetAligns(array("L")); 
        $this->SetX(10);         
//        $this->Row(array(utf8_decode('PERIODO....:  '.$_GET["fe_inicio"]." hasta ".$_GET["fe_fin"])),0,0);   
        $this->SetX(10);          
//        $this->Row(array(utf8_decode('TIPO.......:  ')),0,0);    

        $this->Ln(16);       
        $this->SetFont('courier','B',9);
        $this->SetWidths(array(45,45,30,25,25,30,30,30,25,25,20,25));
        $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C"));       
        $this->SetX(10); // configura la linea donde comenzara escribir en el eje de y       
        $this->Row(array('Partida',utf8_decode('Descripción'),'Presupuesto Inicial','Aumento',utf8_decode('Disminución'),'Presupuesto Modificado','Comprometido','Disponible','Causado','Pagado','Por Pagar'),0,0);
        $this->Line(10, 53, 350, 53);                  
        $this->SetAligns(array("L","L","R","R","R","R","R","R","R","R","R","R","R"));    
                $this->Ln(2);
	 }   
         

         /********************************************************************************************************/        
         /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
         /********************************************************************************************************/

            $monto_comp            = $campo["mo_comprometido"];          
            $monto_modificado      = $campo["modificado"];                
            $monto_causado         = $campo["mo_causado"];            
            $monto_pagado          = $campo["mo_pagado"];     
            $aprobado              = $campo["mo_aprobado"];
            $disponible            = $campo["mo_disponible"];
            $por_pagar             = $campo["mo_causado"]-$campo["mo_pagado"];
            $monto_x100comp        = (($monto_comp)*100)/$aprobado ;          
            $monto_x100cau         = (($monto_causado)*100)/$aprobado ;          
            $monto_x100pag         = (($monto_pagado)*100)/$aprobado ;  
            
            
            
         /********************************************************************************************************/         

            
         $this->SetFont('courier','',8);
         $this->SetAligns(array("L","L","R","R","R","R","R","R","R","R","R","R","R"));
         $total_ley = $total_ley + $campo['inicial'];
         $partida   = $this->desc_partida($campo['nu_pa']);  
         $this->SetWidths(array(45,45,30,25,25,30,30,30,25,25,20,25));
         $this->Row(array(utf8_decode($campo['co_categoria']),utf8_decode($campo['de_partida']), number_format($campo['inicial'], 2, ',','.'),number_format($campo['mo_aumento'], 2, ',','.'),number_format($campo['mo_disminucion'], 2, ',','.'),number_format($campo['mo_aprobado'], 2, ',','.'),number_format($campo['mo_comprometido'], 2, ',','.'),number_format($campo['mo_disponible'], 2, ',','.'),number_format($campo['mo_causado'], 2, ',','.'),number_format($campo['mo_pagado'], 2, ',','.'),number_format($por_pagar, 2, ',','.')),0,0);

         $total_aumento       += $campo['mo_aumento'];
         $total_disminucion       += $campo['mo_disminucion'];
         $total_mod   += $monto_modificado;
         $total_aprob += $aprobado;
         $total_comp  += $monto_comp;
         $total_cau   += $monto_causado;
         $total_pag   += $monto_pagado;
         $total_disp   += $disponible;
         $total_xpagar   += $por_pagar;
         
         $total_monto_x100comp  = (($total_comp)*100)/$total_aprob ;          
         $total_monto_x100cau   = (($total_cau)*100)/$total_aprob ;           
         $total_monto_x100pag   = (($total_pag)*100)/$total_aprob ;
         
         }
         $this->SetFont('courier','B',8);
         $this->SetWidths(array(45,45,30,25,25,30,30,30,25,25,20,25));
         $this->SetAligns(array("L","L","R","R","R","R","R","R","R","R","R","R","R"));
         $this->Row(array('','TOTAL RELACION........',number_format($total_ley, 2, ',','.'),number_format($total_aumento, 2, ',','.'),number_format($total_disminucion, 2, ',','.'),number_format($total_aprob, 2, ',','.'),number_format($total_comp, 2, ',','.'),number_format($total_disp, 2, ',','.'),number_format($total_cau, 2, ',','.'),number_format($total_pag, 2, ',','.'),number_format($total_xpagar, 2, ',','.')));   
      

 }

    

    function ChapterTitle($num,$label) {
        $this->SetFont('courier','',10);
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

    
    function desc_partida($cod){
        

    $conex = new ConexionComun();     
    $sql = "   SELECT distinct de_partida
                FROM tb091_partida
                where nu_partida = '".$cod."'"
            ;          

         //echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0]; 
	
    }    
   
    function partidas(){
        
    $condicion ="";
    $periodo    = $_GET['co_periodo']; 
    $anio       = $_GET['ejercicio'];  
    
    if($_GET["co_ejecutor"]!=''){
        $condicion .= " and tb082.id = ". $_GET["co_ejecutor"];
    }
    
    if($_GET["co_proyecto"]!=''){
        $condicion .= " and tb084.id_tb083_proyecto_ac = ". $_GET["co_proyecto"];
    }
    
    if($_GET["co_accion"]!=''){
        $condicion .= " and tb085.id_tb084_accion_especifica = '". $_GET["co_accion"]."'";
    }
    
    if($_GET["ejercicio"]!=''){
        $condicion .= " and tb085.nu_anio = '". $_GET["ejercicio"]."'";
    }
         
    $conex = new ConexionComun(); 

 
    
    $sql = "select tb085.id,co_categoria,de_partida as de_partida, sum(mo_inicial) as inicial,
        coalesce(sum(mo_aumento),0) as mo_aumento, coalesce(sum(mo_disminucion),0) as mo_disminucion,       
        (coalesce(sum(mo_aumento),0)) -coalesce(sum(mo_disminucion),0) modificado, 
        sum(mo_inicial)+ (coalesce(sum(mo_aumento),0)) -coalesce(sum(mo_disminucion),0) as mo_aprobado, 
        coalesce(sum(mo_comprometido),0) as mo_comprometido, 
        coalesce(sum(mo_causado),0) as mo_causado, 
        coalesce(sum(mo_pagado),0) as mo_pagado,
        coalesce(sum(mo_disponible),0) as mo_disponible
        FROM tb085_presupuesto as tb085 join tb084_accion_especifica tb084
         on (tb085.id_tb084_accion_especifica = tb084.id)
         join tb083_proyecto_ac tb083 on (tb084.id_tb083_proyecto_ac = tb083.id)
         join tb082_ejecutor tb082 on (tb083.id_tb082_ejecutor = tb082.id)
        where co_partida<>'' $condicion
                     group by 1 order by tb085.id asc";
   

    
        //echo var_dump($sql); exit();        
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
