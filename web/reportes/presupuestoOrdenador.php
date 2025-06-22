<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->empresa = $this->getDatosEmpresa(1);

        $this->SetFont('courier','B',12);
        $this->Cell(0, 0, utf8_decode($this->empresa['nb_empresa']), 0, 0, 'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        if (!empty($this->empresa['nb_institucion'])) {
            $this->Ln(2);
            $this->SetX(52);
            $this->MultiCell(110,4,utf8_decode($this->empresa['nb_institucion']),0,'L',0); 
            $this->Ln(2);
        }else{
            $this->Ln(4);    
        }
        $this->Cell(0, 0, utf8_decode('RIF. ' . $this->empresa['tx_rif']), 0, 0, 'L');        
      
        $this->Ln(4);
      //  $this->Cell(0,0,utf8_decode('[FPRERC54]'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Fecha de Emisión, '.date("d").'/'.date("m").'/'.date("Y")),0,0,'R'); 
        
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

    function getDatosEmpresa( $codigo){

        $sql = "SELECT co_empresa, nb_empresa, co_estado, co_municipio, tx_rif, tx_nit, nb_institucion, nb_presidente,
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

    function ChapterBody() {
       
        $this->Ln(2);        
         
        $Y = $this->GetY();  
        $this->SetY($Y+12);          
        $this->SetFont('courier','B',12);  
        $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
        $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA DE GASTO POR ORDENADOR'),0,0,'C'); 
        $this->Ln(2);          
        $this->SetY($Y);  
        $this->SetFont('courier','',8); 
        $this->SetWidths(array(100));
        $this->SetAligns(array("L")); 
        if ($_GET['co_periodo']==1) $nb_periodo = 'PRIMER TRIMESTRE';
        if ($_GET['co_periodo']==2) $nb_periodo = 'SEGUNDO TRIMESTRE';
        if ($_GET['co_periodo']==3) $nb_periodo = 'TERCER TRIMESTRE';
        if ($_GET['co_periodo']==4) $nb_periodo = 'CUARTO TRIMESTRE';        
        $this->SetX(10);         
        $this->Row(array(utf8_decode('PERIODO....:  ').utf8_decode($nb_periodo)),0,0);   
        $this->SetX(10);          
        //$this->Row(array(utf8_decode('TIPO.......:  ').utf8_decode($_GET['ejecutor'])),0,0);    

        $this->Ln(12);       
        $this->SetFont('courier','B',9);
        $this->SetWidths(array(85,35,35,35,35,15,35,15,35,15));
        $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));       
        $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
        $this->Row(array('Organo Ordenador','Presupuestado','Modificado','Aprobado','Comprometido','%COMP.','Causado','%CAU.','Pagado','%PAG.'),0,0);
        $this->Line(10, 50, 350, 50);                  
        $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));                 

         $campo='';
         $total_ley    = 0;
         $total_mod    = 0;
         $total_aprob  = 0;
         $total_comp   = 0;
         $total_cau    = 0;
         $total_pag    = 0;
         
         $total_monto_x100comp  = 0 ;          
         $total_monto_x100cau   = 0 ;          
         $total_monto_x100pag   = 0 ;
         
         $this->Ln(2);
         $this->SetFont('courier','B',9);
         $this->SetWidths(array(100));
         $this->SetAligns(array("L"));
         
	 $this->lista_organos = $this->organos();          
         
	 foreach($this->lista_organos as $key => $dato){
             
            $campo = $this->partidas($dato['id']); 
            // echo var_dump($campo['mo_admon']); exit(); 
            
            if($this->getY()>170){
                $this->AddPage(); 
                 $Y = $this->GetY();  
                 $this->SetY($Y+12);          
                 $this->SetFont('courier','B',12);  
                 $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
                 $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA POR ORDENADOR'),0,0,'C'); 

                 $this->SetY($Y);  
                 $this->SetFont('courier','',8);   
                 $this->SetWidths(array(100));
                 $this->SetAligns(array("L"));
                if ($_GET['co_periodo']==1) $nb_periodo = 'PRIMER TRIMESTRE';
                if ($_GET['co_periodo']==2) $nb_periodo = 'SEGUNDO TRIMESTRE';
                if ($_GET['co_periodo']==3) $nb_periodo = 'TERCER TRIMESTRE';
                if ($_GET['co_periodo']==4) $nb_periodo = 'CUARTO TRIMESTRE';
                                 
                $this->SetX(10);         
                $this->Row(array(utf8_decode('PERIODO....:  ').utf8_decode($nb_periodo)),0,0);   
                $this->SetX(10);          
                //$this->Row(array(utf8_decode('TIPO.......:  ').utf8_decode($_GET['ejecutor'])),0,0);     
                $this->Ln(8);       
                $this->SetFont('courier','B',9);
                $this->SetWidths(array(85,35,35,35,35,15,35,15,35,15));
                $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));       
                $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
                $this->Row(array('Organo Ordenador','Presupuestado','Modificado','Aprobado','Comprometido','%COMP.','Causado','%CAU.','Pagado','%PAG.'),0,0);
                $this->Line(10, 50, 350, 50);                  
                $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));    
                $this->Ln(2);
	 }        

            $monto_x100comp        = 0;          
            $monto_x100cau         = 0 ;          
            $monto_x100pag         = 0 ; 

         /********************************************************************************************************/        
         /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
         /********************************************************************************************************/
            $monto_comp            = $campo["mo_comprometido"];          
            $monto_modificado      = $campo["mo_modificado_mov"];                
            $mo_causado         = $campo["mo_causado"];    
            $mo_pagado          = $campo["mo_pagado"]; ;                       
            $aprobado              = $campo["mo_aprobado"]; ;
            
            $monto_x100comp        = (($monto_comp)*100)/$aprobado ;          
            $monto_x100cau         = (($mo_causado)*100)/$aprobado ;          
            $monto_x100pag         = (($mo_pagado)*100)/$aprobado ;        
         /********************************************************************************************************/         
         
         $this->SetFont('courier','',9);
         $this->SetWidths(array(85,35,35,35,35,15,35,15,35,15));
         $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));
         $this->SetWidths(array(85,35,35,35,35,15,35,15,35,15));
         $this->Row(array($dato['de_ejecutor'],number_format($campo['inicial'], 2, ',','.'),number_format($monto_modificado, 2, ',','.'),number_format($aprobado, 2, ',','.'),number_format($monto_comp, 2, ',','.'),number_format($monto_x100comp, 2, ',','.'),number_format($mo_causado, 2, ',','.'),number_format($monto_x100cau, 2, ',','.'),number_format($mo_pagado, 2, ',','.'),number_format($monto_x100pag, 2, ',','.')),0,0);
        
         
         $total_ley    += $campo['inicial'];
         $total_mod    += $monto_modificado;
         $total_aprob  += $aprobado;
         $total_comp   += $monto_comp;
         $total_cau    += $mo_causado;
         $total_pag    += $mo_pagado;      
         
         $total_monto_x100comp  += $monto_x100comp ;          
         $total_monto_x100cau   += $monto_x100cau ;          
         $total_monto_x100pag   += $monto_x100pag ; 
         
          
      }
      
      //*************************************************************
      //******** El resto de las partidas forman parte del organo EJECUTIVO DEL ESTADO
      
            $campo = $this->partidas(6); 

            $monto_x100comp        = 0;          
            $monto_x100cau         = 0 ;          
            $monto_x100pag         = 0 ; 

         /********************************************************************************************************/        
         /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
         /********************************************************************************************************/
            $monto_comp            = $campo["mo_comprometido"];          
            $monto_modificado      = $campo["mo_modificado_mov"];                
            $mo_causado            = $campo["mo_causado"];    
            $mo_pagado             = $campo["mo_pagado"]; ;                       
            $aprobado              = $campo["mo_aprobado"]; ;
            
            $monto_x100comp        = (($monto_comp)*100)/$aprobado ;          
            $monto_x100cau         = (($mo_causado)*100)/$aprobado ;          
            $monto_x100pag         = (($mo_pagado)*100)/$aprobado ;        
         /********************************************************************************************************/         
         
            $this->SetFont('courier','',9);
            $this->SetWidths(array(85,35,35,35,35,15,35,15,35,15));
            $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));
            $this->SetWidths(array(85,35,35,35,35,15,35,15,35,15));
            $this->Row(array('0004.-EJECUTIVO DEL ESTADO',number_format($campo['inicial'], 2, ',','.'),number_format($monto_modificado, 2, ',','.'),number_format($aprobado, 2, ',','.'),number_format($monto_comp, 2, ',','.'),number_format($monto_x100comp, 2, ',','.'),number_format($mo_causado, 2, ',','.'),number_format($monto_x100cau, 2, ',','.'),number_format($mo_pagado, 2, ',','.'),number_format($monto_x100pag, 2, ',','.')),0,0);
        
         
            $total_ley    += $campo['inicial'];
            $total_mod    += $monto_modificado;
            $total_aprob  += $aprobado;
            $total_comp   += $monto_comp;
            $total_cau    += $mo_causado;
            $total_pag    += $mo_pagado;      

            $total_monto_x100comp  += $monto_x100comp ;          
            $total_monto_x100cau   += $monto_x100cau ;          
            $total_monto_x100pag   += $monto_x100pag ; 
      
         
            $this->Ln(2); 
            $this->SetFont('courier','B',9);
            $this->SetWidths(array(85,35,35,35,35,15,35,15,35,15));
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
    
    
    function organos(){
        
        $conex = new ConexionComun();     
        $sql = "   SELECT distinct tb082.id, (nu_ejecutor||'.-'|| de_ejecutor) as de_ejecutor
                        FROM tb082_ejecutor tb082
                        left join tb083_proyecto_ac as tb083 on tb082.id= tb083.id_tb082_ejecutor
                         left join tb084_accion_especifica as tb084 on tb084.id_tb083_proyecto_ac=tb083.id
                         left join tb085_presupuesto as tb085 on tb085.id_tb084_accion_especifica = tb084.id
                        where tb083.id_tb013_anio_fiscal is not null and
                             length(nu_partida) = 3 and
                             co_partida<>'' order by id limit 3";          

        // echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
	
    }   
    
    function partidas($id){
    
            $condicion =""; 
            $anio       = $_GET['co_anio_fiscal'];     

            $condicion .= " and tb085.nu_anio =".$anio; 

            if($id == 3){
                $condicion .= " and tip_apl in ('01','01A','01B','01C')";
            }else if($id == 4){
                $condicion .= " and tip_apl in ('02','02A','02B','02C','02D','02E')";
            }else if ($id == 5){
                $condicion .= " and tip_apl in ('03','03A','03B','03C','03D','03E','03H')";
            }else{
                $condicion .= " and tip_apl not in ('01','01A','01B','01C','02','02A','02B','02C','02D','02E','03','03A','03B','03C','03D','03E','03H')";
            }


            list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
            $fe_inicio = $anio.'-'.$mes.'-'.$dia;

            list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
            $fe_fin = $anio.'-'.$mes.'-'.$dia;

            $conex = new ConexionComun();     
            $sql = "   SELECT distinct  sum(mo_inicial) as inicial, (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_modificado_mov,
                         sum(mo_inicial)+ (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) as mo_aprobado,
                         coalesce(sum(comprometido_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_comprometido,
                         coalesce(sum(causado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0) mo_causado,
                         coalesce(sum(pagado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,3,'$fe_inicio','$fe_fin')),0) mo_pagado
                        FROM  tb085_presupuesto tb085
                        where length(nu_partida) = 17 $condicion ";

                  //echo $sql; exit();
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
