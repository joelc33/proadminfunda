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
        $this->Cell(0,0,utf8_decode(''),0,0,'L');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode(''),0,0,'L');        
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('[FPRERB89]'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Fecha Emisión, '.date("d").'/'.date("m").'/'.date("Y")),0,0,'R'); 
        
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
         $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA POR AREA ESTRATEGICA - AÑO FISCAL '.$_GET['co_anio_fiscal']),0,0,'C'); 
         $this->Ln(2);          
         $this->SetY($Y);  
         $this->SetFont('courier','',8); 
        $this->SetWidths(array(100));
        $this->SetAligns(array("L")); 
        $this->SetX(10);         
        $this->Row(array(utf8_decode('PERIODO....:  ').$_GET["fe_inicio"]. ' hasta '.$_GET["fe_fin"]),0,0);   
        $this->SetX(10);          
        $this->Row(array(utf8_decode('TIPO.......:  ')),0,0);    

        $this->Ln(7);       
        $this->SetFont('courier','B',9);
        $this->SetWidths(array(10,70,30,30,30,30,20,30,20,30,20));
        $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C"));       
        $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
        $this->Row(array('Tipo',utf8_decode('Areas Estrategicas'),'Presupuestado','Modificado','Aprobado','Comprometido','%Comp','Causado','%Cau','Pagado','%Pag.'),0,0);
        $this->Line(10, 50, 350, 50);                  
        $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));                 

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
                 $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA POR AREA ESTRATEGICA - AÑO FISCAL '.$_GET['co_anio_fiscal']),0,0,'C'); 

                 $this->SetY($Y);  
                 $this->SetFont('courier','',8);   
                 $this->SetWidths(array(100));
                 $this->SetAligns(array("L"));                  
                $this->SetX(10);         
                $this->Row(array(utf8_decode('PERIODO....:  ').$_GET["fe_inicio"]. ' hasta '.$_GET["fe_fin"]),0,0);   
                $this->Ln(8);       
                $this->SetFont('courier','B',9);
                $this->SetWidths(array(10,50,30,30,30,30,20,30,20,30,20));
                $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));       
                $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
                $this->Row(array('Tipo',utf8_decode('Areas Estrategicas'),'Presupuestado','Modificado','Aprobado','Comprometido','%Comp','Causado','%Cau','Pagado','%Pag.'),0,0);
                $this->Line(10, 50, 350, 50);                  
                $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));    
                $this->Ln(2);
	 }   
         

         /********************************************************************************************************/        
         /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
         /********************************************************************************************************/

                    $monto_comp         = $campo["mo_comprometido"];          
                    $monto_modificado   = $campo["mo_modificado_mov"];                
                    $mo_causado         = $campo["mo_causado"];     
                    $mo_pagado          = $campo["mo_pagado"];              
                    $aprobado              = $campo['mo_aprobado'];
                    $monto_x100comp        = (($monto_comp)*100)/$aprobado ;          
                    $monto_x100cau         = (($mo_causado)*100)/$aprobado ;          
                    $monto_x100pag         = (($mo_pagado)*100)/$aprobado ;    



                 /********************************************************************************************************/         


                 $this->SetFont('courier','',8);
                 $this->SetAligns(array("L","L","R","R","R","R","R","R","R","R","R"));
                 $total_ley = $total_ley + $campo['inicial'];        
                 $this->SetWidths(array(10,60,30,30,30,30,20,30,20,30,20));
                 $this->Row(array($campo['tx_siglas'],$campo['tx_descripcion'], number_format($campo['inicial'], 2, ',','.'),number_format($monto_modificado, 2, ',','.'),number_format($aprobado, 2, ',','.'),number_format($monto_comp, 2, ',','.'),number_format($monto_x100comp, 2, ',','.'),number_format($mo_causado, 2, ',','.'),number_format($monto_x100cau, 2, ',','.'),number_format($mo_pagado, 2, ',','.'),number_format($monto_x100pag, 2, ',','.')));

                 $total       += $campo['inicial'];
                 $total_mod   += $monto_modificado;
                 $total_aprob += $aprobado;
                 $total_comp  += $monto_comp;
                 $total_cau   += $mo_causado;
                 $total_pag   += $mo_pagado;       

                 $total_monto_x100comp  = (($total_comp)*100)/$total_aprob ;          
                 $total_monto_x100cau   = (($total_cau)*100)/$total_aprob ;           
                 $total_monto_x100pag   = (($total_pag)*100)/$total_aprob ;

                 }
                 $this->SetFont('courier','B',8);
                 $this->SetWidths(array(70,30,30,30,30,20,30,20,30,20));
                 $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));
                 $this->Row(array('TOTAL RELACION........',number_format($total_ley, 2, ',','.'),number_format($total_mod, 2, ',','.'),number_format($total_aprob, 2, ',','.'),number_format($total_comp, 2, ',','.'),number_format($total_monto_x100comp, 2, ',','.'),number_format($total_cau, 2, ',','.'),number_format($total_monto_x100cau, 2, ',','.'),number_format($total_pag, 2, ',','.'),number_format($total_monto_x100pag, 2, ',','.')));   


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

    function niveles(){        

    $conex = new ConexionComun();     
    $sql = "   SELECT co_tp_area, tx_tp_area
                FROM tb160_tp_area order by 1";          

        // echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 	
    }
   
    function partidas($tipo){
        
        $condicion ="";
        $nu_anio       = $_GET['co_anio_fiscal'];    
           
        
        list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
        $fe_inicio = $anio.'-'.$mes.'-'.$dia;

        list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
        $fe_fin = $anio.'-'.$mes.'-'.$dia;

        $conex = new ConexionComun();       
    
         $sql = " SELECT distinct 
                tx_siglas,tx_descripcion, 		
                sum(mo_inicial) as inicial, 
                (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$nu_anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$nu_anio,1,'$fe_inicio','$fe_fin')),0) mo_modificado_mov,
                sum(mo_inicial)+ (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$nu_anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$nu_anio,1,'$fe_inicio','$fe_fin')),0) as mo_aprobado,
                coalesce(sum(comprometido_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$nu_anio,1,'$fe_inicio','$fe_fin')),0) mo_comprometido,
                coalesce(sum(causado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$nu_anio,2,'$fe_inicio','$fe_fin')),0) mo_causado,
                coalesce(sum(pagado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$nu_anio,3,'$fe_inicio','$fe_fin')),0) mo_pagado
                FROM tb085_presupuesto as tb085 inner join tb185_area_estrategica as tb185 on (tb085.co_area_estrategica = tb185.co_area_estrategica)
                where in_movimiento is true and  length(nu_partida)=17 and tb085.nu_anio = $nu_anio
                group by 1,2
                order by 1 asc;";
    
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
