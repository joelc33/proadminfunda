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
            $this->SetX(122);
            $this->MultiCell(110,4,utf8_decode($this->empresa['nb_institucion']),0,'C',0); 
            $this->Ln(2);
        }else{
        $this->Ln(4);    
        }
        $this->Cell(0, 0, utf8_decode('RIF. ' . $this->empresa['tx_rif']), 0, 0, 'C');
        $this->Ln(4); 
        
   }

    function Footer() {
	$this->SetFont('Arial','B',9);     
	$this->SetY(195);
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
       
        $this->Ln(2);        
         
        if ($_GET["co_anio_fiscal"]) $anio=$_GET["co_anio_fiscal"];
        else if ($_GET["fe_inicio"]) $anio= date("Y", strtotime($_GET["fe_inicio"]));     
        
         $Y = $this->GetY();  
         $this->SetY($Y+12);          
         $this->SetFont('Arial','B',12);  
         $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
         $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA POR PARTIDAS- '.$anio),0,0,'C'); 
        $this->Ln(5);          
        
        $this->SetFont('Arial','B',10); 
        $this->SetWidths(array(100));
        $this->SetAligns(array("L")); 
        $this->SetX(10);                    
        $this->Row(array('PERIODO....:  01-01-'.$_GET['co_anio_fiscal'].' A '.$_GET['fe_fin']),0,0);   
        $this->SetX(10);   

        $this->Ln(10);       
        $this->SetFont('Arial','B',9);
        $this->SetWidths(array(10,50,30,30,30,30,15,30,30,15,30,15,25));
        $this->SetAligns(array("C","C","R","R","R","R","R","R","R","R","R","R","R"));       
        $this->SetX(10); // configura la linea donde comenzara escribir en el eje de y       
        $this->Row(array('','Partida','Presupuesto Inicial','Modificado','Presupuesto Aprobado','Comprometido','%Comp','Disponible','Causado','%Cau','Pagado','%Pag.','Por pagar'),0,0);
        $this->Line(10, 55, 350, 55);                  
        $this->SetAligns(array("L","L","R","R","R","R","R","R","R","R","R","R","R"));                 

         $campo='';
        
         $total_ley = 0;
         $this->Ln(2);
         $this->SetFont('Arial','B',9);
         $this->SetWidths(array(100));
         $this->SetAligns(array("L"));
         
	 $this->lista_partidas = $this->partidas();          
         
	 foreach($this->lista_partidas as $key => $campo){
            if($this->getY()>170){
                $this->AddPage(); 
                 $Y = $this->GetY();  
                 $this->SetY($Y+12);          
                 $this->SetFont('Arial','B',12);  
                 $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
                 $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA POR PARTIDAS- '.$anio),0,0,'C'); 
                $this->Ln(5);          

                $this->SetFont('Arial','B',10); 
                $this->SetWidths(array(100));
                $this->SetAligns(array("L")); 
                $this->SetX(10);                    
                $this->Row(array('PERIODO....:  01-01-'.$_GET['co_anio_fiscal'].' A '.$_GET['fe_fin']),0,0);   
                $this->SetX(10);   

                $this->Ln(10);       
                $this->SetFont('Arial','B',9);
                $this->SetWidths(array(10,50,30,30,30,30,15,30,30,15,30,15,25));
                $this->SetAligns(array("C","C","R","R","R","R","R","R","R","R","R","R","R"));       
                $this->SetX(10); // configura la linea donde comenzara escribir en el eje de y       
                $this->Row(array('','Partida','Presupuesto Inicial','Modificado','Presupuesto Aprobado','Comprometido','%Comp','Disponible','Causado','%Cau','Pagado','%Pag.','Por pagar'),0,0);
                $this->Line(10, 55, 350, 55);                  
                $this->SetAligns(array("L","L","R","R","R","R","R","R","R","R","R","R","R"));
	 }   
         

         /********************************************************************************************************/        
         /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
         /********************************************************************************************************/

            $monto_comp            = $campo["mo_comprometido"];          
            $monto_modificado      = $campo["modificado"];                
            $monto_causado         = $campo["mo_causado"];            
            $monto_pagado          = $campo["mo_pagado"];     
            $aprobado              = $campo["mo_aprobado"];
            $disponible            = $campo["mo_aprobado"]-$campo["mo_comprometido"];
            $por_pagar             = $campo["mo_causado"]-$campo["mo_pagado"];
            $monto_x100comp        = (($monto_comp)*100)/$aprobado ;          
            $monto_x100cau         = (($monto_causado)*100)/$aprobado ;          
            $monto_x100pag         = (($monto_pagado)*100)/$aprobado ;  
            
            
            
         /********************************************************************************************************/         

            
         $this->SetFont('Arial','',8);
         $this->SetAligns(array("L","L","R","R","R","R","R","R","R","R","R","R","R"));
         $total_ley = $total_ley + $campo['inicial'];
         $partida   = $this->desc_partida($campo['nu_pa']);  
         $this->SetWidths(array(10,50,30,30,30,30,15,30,30,15,30,15,25));
         $this->Row(array($campo['nu_pa'],$partida['de_partida'], number_format($campo['inicial'], 2, ',','.'),number_format($monto_modificado, 2, ',','.'),number_format($aprobado, 2, ',','.'),number_format($monto_comp, 2, ',','.'),number_format($monto_x100comp, 2, ',','.'),number_format($disponible, 2, ',','.'),number_format($monto_causado, 2, ',','.'),number_format($monto_x100cau, 2, ',','.'),number_format($monto_pagado, 2, ',','.'),number_format($monto_x100pag, 2, ',','.'),number_format($por_pagar, 2, ',','.')),0,0);

         $total       += $campo['inicial'];
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
         $this->SetFont('Arial','B',8);
         $this->SetWidths(array(10,50,30,30,30,30,15,30,30,15,30,15,25));
         $this->SetAligns(array("R","R","R","R","R","R","R","R","R","R","R","R","R"));
         $this->Row(array('','TOTAL:',number_format($total_ley, 2, ',','.'),number_format($total_mod, 2, ',','.'),number_format($total_aprob, 2, ',','.'),number_format($total_comp, 2, ',','.'),number_format($total_monto_x100comp, 2, ',','.'),number_format($total_disp, 2, ',','.'),number_format($total_cau, 2, ',','.'),number_format($total_monto_x100cau, 2, ',','.'),number_format($total_pag, 2, ',','.'),number_format($total_monto_x100pag, 2, ',','.'),number_format($total_xpagar, 2, ',','.')));   
      

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
    $anio       = $_GET['co_anio_fiscal'];  
    
    list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
    $fe_inicio = $anio.'-'.$mes.'-'.$dia;

    list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
    $fe_fin = $anio.'-'.$mes.'-'.$dia;
         
    $conex = new ConexionComun(); 

    if($anio==2021){
    
    $sql = "select  nu_pa||nu_ge as nu_pa,
                    sum(mo_inicial) as inicial, 
                    (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) modificado,
                    sum(mo_inicial)+ (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) as mo_aprobado,
                    coalesce(sum(mo_comprometido),0) as mo_comprometido,
                    coalesce(sum(mo_causado),0) as mo_causado,
                    coalesce(sum(mo_pagado),0) as mo_pagado
                FROM tb085_presupuesto as tb085                     
                     where nu_anio ='$anio' and co_partida<>''
                     group by 1 order by nu_pa asc";
    }else{
        $sql = "select  nu_pa||nu_ge as nu_pa,
                    sum(mo_inicial) as inicial, 
                    (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) modificado,
                    sum(mo_inicial)+ (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) as mo_aprobado,
                    coalesce(sum(comprometido_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_comprometido,
                    coalesce(sum(causado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0) mo_causado,
                    coalesce(sum(pagado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,3,'$fe_inicio','$fe_fin')),0) mo_pagado
                FROM tb085_presupuesto as tb085                     
                     where nu_anio ='$anio' and co_partida<>''
                     group by 1 order by nu_pa asc";          

            }
    
        //echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
	
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
$pdf=new PDF('L','mm','legal');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
