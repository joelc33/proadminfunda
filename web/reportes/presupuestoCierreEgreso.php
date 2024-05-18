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
       /* $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Secretaria de Administración'),0,0,'L');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('SubSecretaria de Presupuesto'),0,0,'L'); */       
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('[FPRER]'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R'); 
        
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
       
        $this->AddPage(); 
        $this->Ln(2);        
        
        $anio=$_GET["co_anio_fiscal"];
                 
        $Y = $this->GetY();  
        $this->SetY($Y+5);          
        $this->SetFont('courier','B',14);  
        $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y              
        $this->Ln(10);
        $this->Cell(0,0,utf8_decode(' CIERRE DE LA EJECUCIÓN PRESUPUESTARIA DE EGRESOS- AÑO FISCAL '.$anio),0,0,'C'); 
        $this->Ln(2);          
        $this->SetY($Y);  
        $this->SetFont('courier','',12); 
        $this->SetWidths(array(100));
        $this->SetAligns(array("L")); 
        $this->SetX(10);                    
        $this->Row(array('PERIODO....:  '.strtoupper($this->mes($_GET["co_tipo"])).' del '.$_GET["co_anio_fiscal"]),0,0);   
        $this->SetX(10);            

        
        $total_comprometido  = 0;
        $total_causado       = 0;
        $total_pagado        = 0;
        
        $this->Ln(25);       
        $campo='';
        $this->Ln(2);
         
        $this->cierre  = $this->partidas_cierre(); 
        $this->ue      = $this->empresa();
         // echo var_dump($this->ue); exit(); 
         
         $this->SetFont('courier','B',12);
         $this->SetWidths(array(50, 120));         
         $this->SetAligns(array("L","L"));   
         $this->SetX(10); 
         
        
         
         $this->Row(array('UNIDAD EJECUTORA: ', $this->ue['nb_empresa']),0,0);
         $dato   = 'CIERRE MENSUAL DE '.strtoupper($this->mes($_GET["co_tipo"])); 
         $this->SetX(10); 
         $this->Row(array('TIPO: ', $dato),0,0);
         $this->Ln(2);
         $this->SetWidths(array(30, 55, 55, 50));         
         $this->SetAligns(array("C","C","C","C"));          
         $this->SetX(10); 
         $this->Row(array('Fecha','Comprometido ','Causado', 'Pagado'),1,0);        
         $this->SetFont('courier','',12);
         $this->Ln(2);
        
   
         foreach($this->cierre as $key => $campo){

             $periodo   = $dato; 

             $total_comprometido  = $campo['mo_comprometido'];
             $total_causado       = $campo['mo_causado'];
             $total_pagado        = $campo['mo_pagado'];

             $this->SetWidths(array(30, 55, 55, 50));         
             $this->SetAligns(array("C","R","R","R"));     
             $this->SetX(10); 
             $this->Row(array($periodo,number_format($total_comprometido, 2, ',','.'),number_format($total_causado, 2, ',','.'), number_format($total_pagado, 2, ',','.')),0,0);        
  
         }
   

 }
 
    function mes($nu_mes){

        if ($nu_mes<10) $nu_mes = '0'.$nu_mes;
        $mes['01']='Enero';
        $mes['02']='Febrero';
        $mes['03']='Marzo';
        $mes['04']='Abril';
        $mes['05']='Mayo';
        $mes['06']='Junio';
        $mes['07']='Julio';
        $mes['08']='Agosto';
        $mes['09']='Septiembre';
        $mes['10']='Octubre';
        $mes['11']='Noviembre';
        $mes['12']='Diciembre';

        return $mes[$nu_mes];
    } 
  
            
   function partidas_cierre(){ 
 
    $conex = new ConexionComun();   
    
    if ($_GET["co_tipo"]<10) $mes = '0'.$_GET["co_tipo"];
    else $mes = $_GET["co_tipo"];
    $condicion ="";
    $condicion .= " to_char(tb173.fe_desde,'dd-mm-yyyy') = '01-".$mes."-".$_GET["co_anio_fiscal"]."'";
    
    
    if ($condicion)
    $condicion = " where ".$condicion;     
    
    $sql = "
            SELECT 
            sum(mo_comprometido) as mo_comprometido, 
            sum(mo_causado) as mo_causado, 
            sum(mo_pagado) as mo_pagado
            FROM public.tb173_cierre_egreso as tb173 ".
            $condicion;       
    
         // echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
  
          return  $datosSol;    
    }
    
    function empresa(){ 
        
    $conex = new ConexionComun();     
    $sql2 = "
            SELECT tb015.nb_empresa
            FROM public.tb015_empresa as tb015
           limit 1";          
    
         //echo var_dump($sql); exit();        
          $datosSol2 = $conex->ObtenerFilasBySqlSelect($sql2);
          return  $datosSol2[0]; 	
    }
}
$pdf=new PDF('P','mm','letter');

$pdf->AliasNbPages();
$pdf->ChapterBody();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
