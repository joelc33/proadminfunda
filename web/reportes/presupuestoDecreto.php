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
       /* $this->Cell(0,0,utf8_decode('Secretaria de Administración'),0,0,'L');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('SubSecretaria de Presupuesto'),0,0,'L');        
        $this->Ln(4);*/
        $this->Cell(0,0,utf8_decode('[FPRERC44]'),0,0,'L');
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
        
        if ($_GET["co_anio_fiscal"]) $anio=$_GET["co_anio_fiscal"];
        else if ($_GET["fe_inicio"]) $anio= date("Y", strtotime($_GET["fe_inicio"]));        
         
        $Y = $this->GetY();  
        $this->SetY($Y+12);          
        $this->SetFont('courier','B',12);  
        $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
        $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA POR DECRETOS  - AÑO FISCAL '.$anio),0,0,'C');         
        $this->Ln(2);          
        $this->SetY($Y);  
        $this->SetFont('courier','',9); 
        $this->SetWidths(array(100));
        $this->SetAligns(array("L")); 
        $this->SetX(10);         
        $this->Row(array(utf8_decode('PERIODO....:  '.$_GET["fe_inicio"]." hasta ".$_GET["fe_fin"])),0,0);   
        $this->SetX(10);          
        $this->Row(array(utf8_decode('TIPO.......:  ')),0,0);    

        $this->Ln(9);       
        $this->SetFont('courier','B',11);
        $this->SetWidths(array(20,24,30,68,22,35,35,35,35,35));
        $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C"));       
        $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
        $this->Row(array('Decreto','Fecha','Monto','Fuente','Partida','Modificado','Aprobado','Comprometido','Pagado','Disponibilidad'),0,0);
   //     $this->Line(10, 52, 380, 52);                  
        $this->SetAligns(array("C","C","R","L","L","R","R","R","R","R"));                

        $campo='';
	$this->lista_partidas = $this->decretos();   
             
        $monto_dec  = 0;
        $decreto    ='';
        $aprobado   = 0;
        $j=0;
        
        $total_modificado   = 0;
        $total_aprobado     = 0;
        $total_comprometido = 0;
        $total_pagado       = 0;
        $total_disponble    = 0;
        
	foreach($this->lista_partidas as $key => $campo){
            
            if($this->getY()>175){
                $this->AddPage(); 
                 $Y = $this->GetY();  
                 $this->SetY($Y+14);          
                 $this->SetFont('courier','B',12);  
                 $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
                 $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA POR DECRETOS - AÑO FISCAL '.$anio),0,0,'C');        
                $this->SetY($Y+2);  
                $this->SetFont('courier','',9); 
                $this->SetWidths(array(100));
                $this->SetAligns(array("L"));                  
                $this->SetX(10);         
                $this->Row(array(utf8_decode('PERIODO....:  ')),0,0);   
                $this->SetX(10);          
                $this->Row(array(utf8_decode('TIPO.......:  ')),0,0);     
                $this->Ln(9);       
                $this->SetFont('courier','B',11);
                $this->SetWidths(array(20,24,30,47,50,35,35,35,35,40));
                $this->SetAligns(array("C","C","R","L","L","R","R","R","R","R"));            
                $this->SetX(5);      
                $this->Row(array('Decreto','Fecha','Monto','Fuente','Partida','Modificado','Aprobado','Comprometido','Pagado','Disponibilidad'),0,0);
                $this->Line(10, 52, 380, 52);                  
                $this->SetAligns(array("C","C","R","L","L","R","R","R","R","R"));       
	 }        

         $this->SetFont('courier','',10);
         $this->SetWidths(array(20,24,30,68,22,35,35,35,35,35));
         $this->SetAligns(array("C","C","R","L","C","R","R","R","R","R")); 
         $this->SetX(5);
         
            //$decreto              = $campo['decreto'];  
            $monto_incremento      = $campo['mo_aumento'];       
            $monto_disminucion     = $campo['mo_disminucion'];             
            $monto_comp            = $campo['mo_comprometido'];          
            $monto_modificado      = ($campo['mo_modificado_mov']);                
            $monto_causado         = $campo['mo_causado'];   
            $monto_pagado          = $campo['mo_pagado'];                     
            $aprobado              = $campo['mo_aprobado']; //+$monto_modificado; 
            $disponible            = $aprobado - $monto_comp;     
                
            
            if($decreto<>$campo['decreto'])
            {   
               
                if($decreto!=''){
                    
                    $this->SetX(5); 
                    $this->SetFont('courier','B',10);
                    $this->Row(array('TOTAL...','','','','',
                                     number_format($total_modificado, 2, ',','.'),
                                     number_format($total_aprobado, 2, ',','.'),
                                     number_format($total_comprometido, 2, ',','.'),
                                     number_format($total_pagado, 2, ',','.'),
                                     number_format($total_disponble, 2, ',','.')));
                    
                    $this->SetFont('courier','',10);
                    $total_modificado   = 0;
                    $total_aprobado     = 0;
                    $total_comprometido = 0;
                    $total_pagado       = 0;
                    $total_disponble    = 0;
                }
               
                
                $this->SetX(5);
                $this->Row(array($campo['decreto'],$campo['fe_oficio'],number_format($campo['mo_distribucion'], 2, ',','.'),utf8_decode($campo['tx_descripcion']),($campo['de_partida']),number_format($campo['mo_modificado_mov'], 2, ',','.'),number_format($aprobado, 2, ',','.'),number_format($monto_comp, 2, ',','.'),number_format($monto_pagado, 2, ',','.'),number_format($disponible, 2, ',','.')));
                $decreto= $campo['decreto'];   
               
                $total_modificado   += $campo['mo_modificado_mov'];
                $total_aprobado     += $aprobado;
                $total_comprometido += $monto_comp;
                $total_pagado       += $monto_pagado;
                $total_disponble    += $disponible;
             
            }   
            else{ 
                $this->SetX(5); 
                $this->Row(array('','','','',($campo['de_partida']),number_format($campo['mo_modificado_mov'], 2, ',','.'),number_format($aprobado, 2, ',','.'),number_format($monto_comp, 2, ',','.'),number_format($monto_pagado, 2, ',','.'),number_format($disponible, 2, ',','.')));
            
                $total_modificado   += $campo['mo_modificado_mov'];
                $total_aprobado     += $aprobado;
                $total_comprometido += $monto_comp;
                $total_pagado       += $monto_pagado;
                $total_disponble    += $disponible;
               
            }
           
            $j=0;
            $monto_dec = $monto_dec + $campo['mo_distribucion'];
        } 

        $this->SetX(5); 
        $this->SetFont('courier','B',11);
        $this->Row(array('TOTAL...','','','','',
        number_format($total_modificado, 2, ',','.'),
        number_format($total_aprobado, 2, ',','.'),
        number_format($total_comprometido, 2, ',','.'),
        number_format($total_pagado, 2, ',','.'),
        number_format($total_disponble, 2, ',','.')));
//            } 
 
         
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
  
    function decretos(){
        
        $condicion ="";

        $anio = $_GET["co_anio_fiscal"];

        list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
        $fe_inicio = $anio.'-'.$mes.'-'.$dia;

        list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
        $fe_fin = $anio.'-'.$mes.'-'.$dia;

        $conex = new ConexionComun();     

        $sql = "SELECT  (tb073.tx_siglas)||ltrim(to_char(cast(tb068.tx_numero_fuente as numeric),'0000')) as decreto,   
                    de_tipo_fuente_financiamiento as tx_descripcion,
                    to_char(tb096.fe_oficio , 'dd-mm-yyyy') as fe_oficio,
                    mo_distribucion as mo_distribucion,
                    tb085.nu_pa as de_partida, 
                    sum(mo_inicial) as inicial, 
                    (coalesce(sum(mo_actualizado),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_modificado_mov,
                    sum(mo_inicial)+ (coalesce(sum(mo_actualizado),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) as mo_aprobado,
                    coalesce(sum(comprometido_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_comprometido,
                    coalesce(sum(causado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0) mo_causado,
                    coalesce(sum(pagado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,3,'$fe_inicio','$fe_fin')),0) mo_pagado                
            FROM tb085_presupuesto as tb085 inner join tb068_numero_fuente_financiamiento as tb068
                   on (substring(nu_fi,2,5) = ltrim(to_char(cast(tb068.tx_numero_fuente as numeric),'0000'))) 
                   left join tb073_fuente_financiamiento as tb073 on tb073.co_fuente_financiamiento = tb068.co_fuente_financiamiento
                   right join tb099_tipo_fuente_financiamiento as tb099 on tb099.id = tb068.id_tipo_fuente_financiamiento
                   join tb096_presupuesto_modificacion tb096 on (tb096.id_tb068_numero_fuente_financiamiento = tb068.co_numero_fuente)
                   join tb097_modificacion_detalle tb097 on (tb096.id = tb097.id_tb096_presupuesto_modificacion)
            where in_movimiento is true and length(tb085.nu_partida)=17  and  id_tb098_tipo_distribucion = 1 and
                  tb085.nu_anio = $anio 
            group by 1,2,3,4,5
            order by 1,2 asc ;";    

//              echo var_dump($sql); exit();
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
