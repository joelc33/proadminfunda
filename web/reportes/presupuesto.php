<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->SetFont('courier','B',11);
        
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
        
        $this->SetFont('courier','B',8);
        $this->Image("imagenes/escudosanfco.png", 20, 7,20);         

        $this->SetTextColor(0,0,0);
        $this->SetY(10);
        $this->SetX(140); // configura la linea donde comenzara escribir en el eje de y
        $this->Cell(30,0,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->SetY(14);
        $this->SetX(140); // configura la linea donde comenzara escribir en el eje de y
        $this->Cell(30,0,utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'),0,0,'C');
        $this->SetY(18);
        $this->SetX(140); // configura la linea donde comenzara escribir en el eje de y
        $this->Cell(30,0,utf8_decode('SUBSECRETARIA DE PRESUPUESTO'),0,0,'C'); 
       
        $this->SetFont('courier','',7);        
        $this->Ln(2);        
         
         $Y = $this->GetY();  
         $this->SetY($Y+10);          
         $this->SetFont('courier','B',14);  
         $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
         $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA '),0,0,'C'); 
         
         $this->SetY($Y);  
         $this->SetFont('courier','',8); 
        $this->SetWidths(array(100));
        $this->SetAligns(array("L")); 
        $this->SetX(180);         
        $this->Row(array(utf8_decode('SECTOR.........:  ').utf8_decode($_GET['sector'])),0,0);   
        $this->SetX(180);          
        $this->Row(array(utf8_decode('EJECUTOR.......:  ').utf8_decode($_GET['ejecutor'])),0,0);    
        $this->SetX(180);          
        $this->Row(array(utf8_decode('PROY. AC.......:  ').utf8_decode($_GET['proyecto'])),0,0); 
        $this->SetX(180);          
        $this->Row(array(utf8_decode('AC. ESPEC......:  ').utf8_decode($_GET['accion'])),0,0); 
        $this->SetX(180);          
        $this->Row(array(utf8_decode('PARTIDAS.......:  ').utf8_decode($_GET['partida'])),0,0);     

        $this->Ln(2);       
        $this->SetFont('courier','B',10);
        $this->SetWidths(array(35,30,30,35,35,35,30,35));
        $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));       
        $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
        $this->Row(array('PARTIDA','MONTO INICIAL','MODIFICADO','ACTUALIZADO','COMPROMETIDO','CAUSADO','PAGADO','DISPONIBILIDAD'),0,0);
        $this->Line(10, 52, 270, 52);                  
        $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));                 

         $campo='';
	 $this->lista_partidas = $this->partidas();   
         
	 foreach($this->lista_partidas as $key => $campo){
            if($this->getY()>180){
                $this->AddPage(); 
                $this->SetFont('courier','B',8);
                $this->Image("imagenes/escudosanfco.png", 20, 7,20);         

                $this->SetTextColor(0,0,0);
                $this->SetY(10);
                $this->SetX(140); // configura la linea donde comenzara escribir en el eje de y
                $this->Cell(30,0,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
                $this->SetY(14);
                $this->SetX(140); // configura la linea donde comenzara escribir en el eje de y
                $this->Cell(30,0,utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'),0,0,'C');
                $this->SetY(18);
                $this->SetX(140); // configura la linea donde comenzara escribir en el eje de y
                $this->Cell(30,0,utf8_decode('SUBSECRETARIA DE PRESUPUESTO'),0,0,'C'); 

                $this->SetFont('courier','',7);        
                $this->Ln(2);        

                 $Y = $this->GetY();  
                 $this->SetY($Y+10);          
                 $this->SetFont('courier','B',14);  
                 $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
                 $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA '),0,0,'C'); 

                 $this->SetY($Y);  
                 $this->SetFont('courier','',8);          
                 $this->SetX(180);    
                 $this->SetWidths(array(100));
                 $this->SetAligns(array("L"));                  
                 $this->Row(array(utf8_decode('SECTOR.........:  ').utf8_decode($_GET['sector'])),0,0);   
                 $this->SetX(180);          
                 $this->Row(array(utf8_decode('EJECUTOR.......:  ').utf8_decode($_GET['ejecutor'])),0,0);    
                 $this->SetX(180);          
                 $this->Row(array(utf8_decode('PROY. AC.......:  ').utf8_decode($_GET['proyecto'])),0,0); 
                 $this->SetX(180);          
                 $this->Row(array(utf8_decode('AC. ESPEC......:  ').utf8_decode($campo['de_accion_especifica'])),0,0); 
                 $this->SetX(180);          
                 $this->Row(array(utf8_decode('PARTIDAS.......:  ').utf8_decode($_GET['partida'])),0,0);    
                $this->Ln(2);       
                $this->SetFont('courier','B',10);
                $this->SetWidths(array(35,30,30,35,35,35,30,35));
                $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));       
                $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
                $this->Row(array('PARTIDA','MONTO INICIAL','MODIFICADO','ACTUALIZADO','COMPROMETIDO','CAUSADO','PAGADO','DISPONIBILIDAD'),0,0);
                $this->Line(10, 52, 270, 52);                  
                $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));    
	 }        

         $this->SetFont('courier','',9);
         $this->SetWidths(array(35,30,30,35,35,35,30,35));
         $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));
        
         $this->Row(array($campo['nu_partida'],number_format($campo['inicial'], 2, ',','.'),number_format($campo['act'], 2, ',','.'),number_format($campo['act'], 2, ',','.'),number_format($campo['comp'], 2, ',','.'),number_format($campo['causa'], 2, ',','.'),number_format($campo['pag'], 2, ',','.'),number_format($campo['disp'], 2, ',','.')));

      }

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

// fechas, co_instituto, co_estatus, co_tipo_solicitud
   
    function partidas(){
        
    $condicion ="";
    $sector     = $_GET['sector'];
    $ejecutor   = $_GET['ejecutor'];    
    $proyecto   = $_GET['proyecto'];
    $accion     = $_GET['accion'];      
    $partida    = $_GET['partida'];     

    if ($_GET["sector"])     $condicion .= " and upper(tb080.de_sector) like upper('%".$sector."%')"; 
    if ($_GET["ejecutor"])   $condicion .= " and upper(tb082.de_ejecutor) like upper('%".$ejecutor."%')";  
    if ($_GET["proyecto"])   $condicion .= " and upper(tb083.de_proyecto_ac) like upper('%".$proyecto."%')"; 
    if ($_GET["accion"])     $condicion .= " and upper(tb084.de_accion_especifica) like upper('%".$accion."%')";  
    if ($_GET["partida"])    $condicion .= " and upper(tb085.nu_partida) like upper('".$partida."')";      

    $conex = new ConexionComun();     
    $sql = "   SELECT distinct  tb085.nu_partida,
                        mo_inicial as inicial,
                        mo_actualizado as act,
                        mo_precomprometido as pre,
                        mo_comprometido as comp,
                        mo_causado as causa,
                        mo_pagado as pag,
                        mo_disponible as disp,
                        substr(de_accion_especifica,1,10) as de_accion_especifica
                FROM tb082_ejecutor tb082
                     left join tb083_proyecto_ac as tb083 on tb082.id= tb083.id_tb082_ejecutor
                     left join tb084_accion_especifica as tb084 on tb084.id_tb083_proyecto_ac=tb083.id
                     left join tb085_presupuesto as tb085 on tb085.id_tb084_accion_especifica = tb084.id
                     left join tb001_usuario as tb001 on tb001.co_ejecutor = tb082.id
                     left join tb080_sector as tb080 on tb080.id  = tb083.id_tb080_sector
                     where tb083.id_tb013_anio_fiscal is not null and 
                     co_partida<>'' $condicion order by nu_partida ";          

      //   echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
	
    }




}
$pdf=new PDF('L','mm','letter');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
