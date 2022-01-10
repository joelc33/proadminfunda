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
        /*$this->Cell(0,0,utf8_decode('Secretaria de Administración'),0,0,'L');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('SubSecretaria de Presupuesto'),0,0,'L');        
        $this->Ln(4);*/
        $this->Cell(0,0,utf8_decode('[FPRER095]'),0,0,'L');
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
       
        $this->Ln(2);        
         
         $Y = $this->GetY();  
         $this->SetY($Y+12);          
         $this->SetFont('courier','B',12);  
         $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
         $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA POR FUENTE DE FINANCIAMIENTO'),0,0,'C'); 
        $this->Ln(2);          
         $this->SetY($Y);  
         $this->SetFont('courier','',8); 
        $this->SetWidths(array(100));
        $this->SetAligns(array("L")); 
        $this->SetX(10);         
        $this->Row(array(utf8_decode('PERIODO....:  ').$nb_periodo),0,0);   
        $this->SetX(10);          
        $this->Row(array(utf8_decode('TIPO.......:  CONSOLIDADO')),0,0);    

        $this->Ln(7);  

        if ($_GET['co_periodo']==1) $nb_periodo = 'PRIMER TRIMESTRE';
        if ($_GET['co_periodo']==2) $nb_periodo = 'SEGUNDO TRIMESTRE';
        if ($_GET['co_periodo']==3) $nb_periodo = 'TERCER TRIMESTRE';
        if ($_GET['co_periodo']==4) $nb_periodo = 'CUARTO TRIMESTRE';          
        $this->SetFont('courier','B',9);
        $this->SetWidths(array(70,70,35,30,30,30,30,30,30));
        $this->SetAligns(array("C","C","R","R","R","R","R","R","R","R","R"));       
        $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
        $this->Row(array('Organo Ordenador','Fuente','Presupuestado','Modificado','Aprobado','Comprometido','Causado','Pagado'),0,0);
        $this->Line(10, 50, 350, 50); 
        $this->SetWidths(array(70,70,30,30,30,30,30,30));
        $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));                 

         $campo='';
         $total_ley = 0;         

         $this->lista_niveles = $this->organos();   
         $total        = 0;
         $total_mod    = 0;
         $total_aprob  = 0;
         $total_comp   = 0;
         $total_cau    = 0;
         $total_pag    = 0;         
         
	 foreach($this->lista_niveles as $key => $dato){
         
         $subtotal_ley    = 0;  
         $subtotal_mod    = 0;
         $subtotal_aprob  = 0;
         $subtotal_comp   = 0;
         $subtotal_cau    = 0;
         $subtotal_pag    = 0; 
         
         
         $this->Ln(2);
         $this->SetFont('courier','B',9);
         $this->SetWidths(array(100));
         $this->SetAligns(array("L"));
        
         $this->Row(array($dato['de_ejecutor']));
         
	 $this->lista_partidas = $this->partidas($dato['id']);          
         
	 foreach($this->lista_partidas as $key => $campo){
            if($this->getY()>165){
                $this->AddPage(); 
                 $Y = $this->GetY();  
                 $this->SetY($Y+12);          
                 $this->SetFont('courier','B',12);  
                 $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
                 $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA POR FUENTE DE FINANCIAMIENTO'),0,0,'C'); 

                 $this->SetY($Y);  
                 $this->SetFont('courier','',8);   
                 $this->SetWidths(array(100));
                 $this->SetAligns(array("L"));   
                if ($_GET['co_periodo']==1) $nb_periodo = 'PRIMER TRIMESTRE';
                if ($_GET['co_periodo']==2) $nb_periodo = 'SEGUNDO TRIMESTRE';
                if ($_GET['co_periodo']==3) $nb_periodo = 'TERCER TRIMESTRE';
                if ($_GET['co_periodo']==4) $nb_periodo = 'CUARTO TRIMESTRE';                     
                $this->SetX(10);         
                $this->Row(array(utf8_decode('PERIODO....:  ').utf8_decode($_GET['sector'])),0,0);   
                $this->SetX(10);          
                $this->Row(array(utf8_decode('TIPO.......:  ').utf8_decode($_GET['ejecutor'])),0,0);     
                $this->Ln(8);       
                $this->SetFont('courier','B',9);
                $this->SetWidths(array(70,70,35,30,30,30,30,30,30));
                $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));       
                $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
                $this->Row(array('Organo Ordenador','Fuente','Presupuestado','Modificado','Aprobado','Comprometido','Causado','Pagado'));
                $this->Line(10, 50, 350, 50);                  
                $this->SetWidths(array(70,70,30,30,30,30,30,30));
                $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));    
                $this->Ln(2);
	 }        
         
         
         

         /********************************************************************************************************/        
         /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
         /********************************************************************************************************/
            
            $monto_incremento      = $this->partidas_mov(7, $dato['id'],$campo['nu_pa'],$campo['id']);     
            $monto_disminucion     = $this->partidas_mov(8, $dato['id'],$campo['nu_pa'],$campo['id']);  
            $monto_comprometido    = $this->partidas_mov(1, $dato['id'],$campo['nu_pa'],$campo['id']) ; 
            $monto_comp            = $monto_comprometido['monto'] ;          
            $monto_modificado      = ($monto_incremento['monto']) - $monto_disminucion['monto'];                
            $monto_causado         = $this->partidas_mov(2, $dato['id'],$campo['nu_pa'],$campo['id']);   
            $monto_pagado          = $this->partidas_mov(3, $dato['id'],$campo['nu_pa'],$campo['id']);                       
            $aprobado              = $monto_modificado + $campo['inicial'];      
         /********************************************************************************************************/         
         
         
         $this->SetFont('courier','',8);         
         $this->SetAligns(array("L","L","L","R","R","R","R","R","R","R","R"));
         $subtotal_ley    += $campo['inicial'];                  
         $subtotal_mod    += $monto_modificado;
         $subtotal_aprob  += $aprobado;
         $subtotal_comp   += $monto_comp;
         $subtotal_cau    += $monto_causado['monto'];
         $subtotal_pag    += $monto_pagado['monto']; 
         $partida       = $this->desc_partida($campo['nu_pa']);  
         $this->SetWidths(array(10,60,70,30,30,30,30,30,30));
         $this->Row(array($campo['nu_pa'],$partida['de_partida'], utf8_decode($campo['de_tipo_fuente_financiamiento']), number_format($campo['inicial'], 2, ',','.'),number_format($monto_modificado, 2, ',','.'),number_format($aprobado, 2, ',','.'),number_format($monto_comp, 2, ',','.'),number_format($monto_causado['monto'], 2, ',','.'),number_format($monto_pagado['monto'], 2, ',','.')));       
         }
         $this->SetFont('courier','B',9);
         $this->SetWidths(array(140,30,30,30,30,30,30));
         $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));
         $this->Row(array('Total Organo........',number_format($subtotal_ley, 2, ',','.'),number_format($subtotal_mod, 2, ',','.'),number_format($subtotal_aprob, 2, ',','.'),number_format($subtotal_comp, 2, ',','.'),number_format($subtotal_cau, 2, ',','.'),number_format($subtotal_pag, 2, ',','.')));   
         
         $total_ley   += $subtotal_ley; 
         $total_mod   += $subtotal_mod;
         $total_aprob += $subtotal_aprob;
         $total_comp  += $subtotal_comp;
         $total_cau   += $subtotal_cau;
         $total_pag   += $subtotal_pag;
         
      }
      
         $this->Ln(5);
         $this->SetFont('courier','B',7);
         $this->SetWidths(array(140,30,30,30,30,30,30));
         $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));
         $this->Row(array('TOTAL RELACION........',number_format($total_ley, 2, ',','.'),number_format($total_mod, 2, ',','.'),number_format($total_aprob, 2, ',','.'),number_format($total_comp, 2, ',','.'),number_format($total_cau, 2, ',','.'),number_format($total_pag, 2, ',','.')));   

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

    function organos(){
        

    $conex = new ConexionComun();     
    $sql = "   SELECT id, (nu_ejecutor||'.-'|| de_ejecutor) as de_ejecutor
                FROM tb082_ejecutor
                order by 1";          

      //   echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
	
    }
    
    function desc_partida($cod){
        

    $conex = new ConexionComun();     
    $sql = "   SELECT distinct de_partida
                FROM tb085_presupuesto
                where nu_partida = '".$cod."'";          

         //echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0]; 
	
    }    
   
    function partidas($tipo){
        
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
    $sql = "   SELECT distinct  
                        nu_pa,
                        tb099.id,
                        tb099.de_tipo_fuente_financiamiento,
                        sum(mo_inicial) as inicial                        
                FROM tb082_ejecutor tb082
                     left join tb083_proyecto_ac as tb083 on tb082.id= tb083.id_tb082_ejecutor
                     left join tb084_accion_especifica as tb084 on tb084.id_tb083_proyecto_ac=tb083.id
                     left join tb085_presupuesto as tb085 on tb085.id_tb084_accion_especifica = tb084.id
                     left join tb080_sector as tb080 on tb080.id  = tb083.id_tb080_sector 
                     left join tb068_numero_fuente_financiamiento as tb068 on tb068.tx_numero_fuente = substring(tb085.nu_fi,3,4)
                     left join tb099_tipo_fuente_financiamiento as tb099 on tb099.id = tb068.id_tipo_fuente_financiamiento 
                     where tb083.id_tb013_anio_fiscal is not null and 
                     length(nu_partida) = 17 and
                     co_partida<>'' $condicion and tb082.id = ".$tipo." group by 1, 2, 3 "
            . "order by tb099.de_tipo_fuente_financiamiento, nu_pa asc";          

    
  //      echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
	
    }
    
    function partidas_mov($tipo, $id, $cod, $fuente){
        
    /*
    1 -- Comprometido 
    2 -- Causado
    3 -- Pagado
    7 -- Incremento
    8 -- Deduccion
    */    
    $condicion ="";   
    $periodo    = $_GET['co_periodo']; 
    $sector     = $_GET['nu_sector'];
    $ejecutor   = $_GET['nu_ejecutor'];    
    $proyecto   = $_GET['nu_proyecto_ac'];
    $accion     = $_GET['nu_accion_especifica'];      
    $partida    = $_GET['de_partida'];    
    
    if ($periodo==1) $condicion .= " and tb087.created_at >= '01-01-2018' and tb087.created_at <= '31-03-2018'";
    if ($periodo==2) $condicion .= " and tb087.created_at >= '01-04-2018' and tb087.created_at <= '30-06-2018'";  
    if ($periodo==3) $condicion .= " and tb087.created_at >= '01-07-2018' and tb087.created_at <= '30-09-2018'";
    if ($periodo==4) $condicion .= " and tb087.created_at >= '01-10-2018' and tb087.created_at <= '31-12-2018'";

    if ($_GET["sector"])     $condicion .= " and tb080.id =".$sector; 
    if ($_GET["ejecutor"])   $condicion .= " and tb082.id =".$ejecutor;  
    if ($_GET["proyecto"])   $condicion .= " and tb083.id=".$proyecto; 
    if ($_GET["accion"])     $condicion .= " and tb084.id=".$accion;  
    if ($_GET["partida"])    $condicion .= " and tb085.nu_partida=".$partida;      

    $conex = new ConexionComun();     
    $sql =  "      SELECT distinct tb082.id, tb085.nu_pa, tb099.de_tipo_fuente_financiamiento, 
                        sum(tb087.nu_monto) as monto
                 FROM tb082_ejecutor tb082
                 left join tb083_proyecto_ac as tb083 on tb082.id= tb083.id_tb082_ejecutor
                 left join tb084_accion_especifica as tb084 on tb084.id_tb083_proyecto_ac=tb083.id
                 left join tb085_presupuesto as tb085 on tb085.id_tb084_accion_especifica = tb084.id
                 left join tb087_presupuesto_movimiento as tb087 on tb087.co_partida = tb085.id and tb087.co_tipo_movimiento= $tipo
                 left join tb080_sector as tb080 on tb080.id  = tb083.id_tb080_sector
                 left join tb068_numero_fuente_financiamiento as tb068 on tb068.tx_numero_fuente = substring(tb085.nu_fi,3,4)
                 left join tb099_tipo_fuente_financiamiento as tb099 on tb099.id = tb068.id_tipo_fuente_financiamiento                 
                 where tb083.id_tb013_anio_fiscal is not null 
                       and tb082.id = ".$id." and tb085.nu_pa ='".$cod."'   
                       and tb099.id =".$fuente." 
                       and length(tb085.nu_partida) = 17 and tb087.created_at is not null $condicion                  
                 group by 1, 2, 3
                 order by 1 asc";

//        if ($tipo==7) {
//             echo var_dump($sql); exit();        
//             
//         }    
    
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0]; 
	
    }         
    
     



}
$pdf=new PDF('L','mm','legal');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
