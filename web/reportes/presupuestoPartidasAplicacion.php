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
        $this->Cell(0,0,utf8_decode('Secretaria de Administración'),0,0,'L');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('SubSecretaria de Presupuesto'),0,0,'L');        
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('[FPRERA55]'),0,0,'L');
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
        $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA POR APLICACIÓN-PARTIDA - AÑO FISCAL '.$_GET['co_anio_fiscal']),0,0,'C'); 
        $this->Ln(2);          
        $this->SetY($Y);  
        $this->SetFont('courier','',8); 
        $this->SetWidths(array(100));
        $this->SetAligns(array("L")); 
      
        $this->SetX(10);         
        $this->Row(array(utf8_decode('ENTIDAD....:  ').$_GET['co_ejecutor']),0,0);   
        $this->SetX(10);          
        $this->Row(array(utf8_decode('APLICACIÓN.......: ')),0,0);    

        $this->Ln(5);       
        $this->SetFont('courier','B',9);
        $this->SetWidths(array(40,40,35,35,35,35,35,35,30,30));
        $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));       
        $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
        $this->Row(array('Categoria',utf8_decode('Denominación'),'Presupuestado','Modificado','Aprobado','Comprometido','Causado','Pagado','Disp. Presupuestaria','Disp. Financiera'),0,0);
        $this->Line(10, 52, 350, 52);                  
        $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));                 

         $campo='';
         $this->lista_entes = $this->entes();   
         $total        = 0;
         $total_mod    = 0;
         $total_aprob  = 0;
         $total_comp   = 0;
         $total_cau    = 0;
         $total_pag    = 0;
         
         $total_monto_x100comp  = 0 ;          
         $total_monto_x100cau   = 0 ;          
         $total_monto_x100pag   = 0 ;
                 
	 foreach($this->lista_entes as $key => $dato){
         
         $subtotal_ley    = 0;  
         $subtotal_mod    = 0;
         $subtotal_aprob  = 0;
         $subtotal_comp   = 0;
         $subtotal_cau    = 0;
         $subtotal_pag    = 0; 
         
         $subtotal_monto_x100comp  = 0 ;          
         $subtotal_monto_x100cau   = 0 ;          
         $subtotal_monto_x100pag   = 0 ;
         
         $this->Ln(2);
         $this->SetFont('courier','B',11);
         $this->SetWidths(array(100));
         $this->SetAligns(array("L"));
         $this->SetX(5);
         $this->Row(array($dato['de_ejecutor']));
         
	 $this->lista_partidas = $this->partidas($dato['co_tp_area']);   
         
	 foreach($this->lista_partidas as $key => $campo){
            if($this->getY()>170){
                $this->AddPage(); 
                 $Y = $this->GetY();  
                 $this->SetY($Y+12);          
                 $this->SetFont('courier','B',12);  
                 $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
                 $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA POR APLICACIÓN-PARTIDA - AÑO FISCAL '.$_GET['co_anio_fiscal']),0,0,'C'); 

                 $this->SetY($Y);  
                 $this->SetFont('courier','',8);   
                 $this->SetWidths(array(100));
                 $this->SetAligns(array("L"));               
                $this->SetX(10);         
                $this->Row(array(utf8_decode('ENTIDAD....:  ').$_GET['co_ejecutor']),0,0);   
                $this->SetX(10);          
                $this->Row(array(utf8_decode('APLICACIÓN.......: ')),0,0);     
                $this->Ln(10);       
                $this->SetFont('courier','B',9);
                $this->SetWidths(array(40,40,35,35,35,35,35,35,30,30));
                $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));       
                $this->SetX(5);     
                $this->Row(array('Categoria',utf8_decode('Denominación'),'Presupuestado','Modificado','Aprobado','Comprometido','Causado','Pagado','Disp. Presupuestaria','Disp. Financiera'),0,0);
                $this->Line(10, 50, 350, 50);                  
                $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));    
	 }        


         /********************************************************************************************************/        
         /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
         /********************************************************************************************************/
            
            /*$monto_incremento      = $this->partidas_mov(7, $dato['co_tp_area'],$campo['cod_amb']);     
            $monto_disminucion     = $this->partidas_mov(8, $dato['co_tp_area'],$campo['cod_amb']);  
            $monto_comprometido    = $this->partidas_mov(1, $dato['co_tp_area'],$campo['cod_amb']) ; 
            $monto_comp            = $monto_comprometido['monto'] ;          
            $monto_modificado      = ($monto_incremento['monto']) - $monto_disminucion['monto'];                
            $monto_causado         = $this->partidas_mov(2, $dato['co_tp_area'],$campo['cod_amb']);   
            $monto_pagado          = $this->partidas_mov(3, $dato['co_tp_area'],$campo['cod_amb']);                       
            $aprobado              = $monto_modificado + $campo['mo_ley'];
            $monto_x100comp        = (($monto_comp)*100)/$aprobado ;          
            $monto_x100cau         = (($monto_causado['monto'])*100)/$aprobado ;          
            $monto_x100pag         = (($monto_pagado['monto'])*100)/$aprobado ;   */   
            
            $monto_incremento      = $campo['mo_aumento'];       
            $monto_disminucion     = $campo['mo_disminucion'];                   
            $monto_comp            = $campo['mo_comprometido'];          
            $monto_modificado      = $campo['mo_aumento']-$campo['mo_disminucion'];  //correcta              
            $monto_causado         = $campo['mo_causado'];  
            $monto_pagado          = $campo['mo_pagado'];  
            $aprobado              = $monto_modificado + $campo['mo_ley'];      //correcto    
            $monto_disponible      = $campo['mo_ley']+$monto_modificado-$campo['mo_comprometido'];  //correcto
         /********************************************************************************************************/
         
         $this->SetFont('courier','',8);
         $this->SetWidths(array(75,35,35,35,35,35,35,35,35,35));
         $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));         
         $subtotal_ley    += $campo['mo_ley'];
         $subtotal_mod    += $monto_modificado;
         $subtotal_aprob  += $aprobado;
         $subtotal_comp   += $monto_comp;
         $subtotal_cau    += $monto_causado;
         $subtotal_pag    += $monto_pagado;          
         $subtotal_disponible    += $monto_disponible;
      
         
         $this->SetX(5);
         //$this->Row(array(utf8_decode($campo['tx_ambito']),number_format($campo['inicial'], 2, ',','.'),number_format($monto_modificado, 2, ',','.'),number_format($aprobado, 2, ',','.'),number_format($monto_comp, 2, ',','.'),number_format($monto_x100comp, 2, ',','.'),number_format($monto_causado['monto'], 2, ',','.'),number_format($monto_x100cau, 2, ',','.'),number_format($monto_pagado['monto'], 2, ',','.'),number_format($monto_x100pag, 2, ',','.')));
         $this->Row(array(utf8_decode($campo['aplicacion']),number_format($campo['mo_ley'], 2, ',','.'),number_format($monto_modificado, 2, ',','.'),number_format($aprobado, 2, ',','.'),number_format($monto_comp, 2, ',','.'),number_format($monto_causado, 2, ',','.'),number_format($monto_pagado, 2, ',','.'),number_format($monto_disponible, 2, ',','.')));
         }
         
         $subtotal_monto_x100comp  = (($subtotal_comp)*100)/$subtotal_aprob ;          
         $subtotal_monto_x100cau   = (($subtotal_cau)*100)/$subtotal_aprob ;          
         $subtotal_monto_x100pag   = (($subtotal_pag)*100)/$subtotal_aprob ;  
         
         $total       += $subtotal_ley;
         $total_mod   += $subtotal_mod;
         $total_aprob += $subtotal_aprob;
         $total_comp  += $subtotal_comp;
         $total_cau   += $subtotal_cau;
         $total_pag   += $subtotal_pag;
         $total_disponible   += $subtotal_disponible;
         
         $total_monto_x100comp  = (($total_comp)*100)/$total_aprob ;          
         $total_monto_x100cau   = (($total_cau)*100)/$total_aprob ;           
         $total_monto_x100pag   = (($total_pag)*100)/$total_aprob ;  
         
         $this->SetFont('courier','B',7);
         $this->SetWidths(array(75,35,35,35,35,35,35,35,35,35));
         $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));
         $this->SetX(5);
         $this->Row(array('Total Area........',number_format($subtotal_ley, 2, ',','.'),number_format($subtotal_mod, 2, ',','.'),number_format($subtotal_aprob, 2, ',','.'),number_format($subtotal_comp, 2, ',','.'),number_format($subtotal_cau, 2, ',','.'),number_format($subtotal_pag, 2, ',','.'),number_format($subtotal_disponible, 2, ',','.')));         
        
         
      }
      
         $this->SetFont('courier','B',7);
         $this->SetWidths(array(75,35,35,35,35,35,35,35,35,35));
         $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));
         $this->SetX(5);
         $this->Row(array('TOTAL RELACION........',number_format($total, 2, ',','.'),number_format($total_mod, 2, ',','.'),number_format($total_aprob, 2, ',','.'),number_format($total_comp, 2, ',','.'),number_format($total_cau, 2, ',','.'),number_format($total_pag, 2, ',','.'),number_format($total_disponible, 2, ',','.'))); 

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
    
    function entes(){      
        
   $ente= $_GET["co_ejecutor"];     

    $conex = new ConexionComun();     
    $sql = "   SELECT nu_ejecutor, de_ejecutor
               FROM tb082_ejecutor
               where id=".$ente;          

        // echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 	
    }    

    function aplicacion($ejecutor){      
        
    $ente= $_GET["co_ejecutor"];  
    if ($_GET["co_anio_fiscal"])     $condicion .= " and tb139.nu_anio_fiscal =".$anio;
    
    $conex = new ConexionComun();     
    $sql = "   SELECT tb139.tx_tip_aplicacion,
                      tb139.tx_aplicacion,
                      tb139.co_aplicacion
                FROM tb085_presupuesto as tb085
                left join tb139_aplicacion as tb139
                where tb085.cod_ente='".$ejecutor."' and tb139.co_aplicacion = tb085.id_tb139_aplicacion $condicion";
                    

        // echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 	
    }
   
   
    function partidas($tipo){
        
    $condicion ="";
    $anio       = $_GET['co_anio_fiscal'];       
    //if ($_GET["co_anio_fiscal"])     $condicion .= " and tb085.nu_anio =".$anio;   
    $co_anio_fiscal       = $_GET['co_anio_fiscal'];      

    $conex = new ConexionComun();     
    
    /*$sql = " SELECT distinct  lpad((tb138.co_ambito::text),2,'0')cod_amb, (tb085.cod_amb ||'- '|| tb138.tx_ambito) as tx_ambito,
                              sum(mo_inicial) as inicial                        
                 FROM tb082_ejecutor tb082
                 left join tb083_proyecto_ac as tb083 on tb082.id= tb083.id_tb082_ejecutor
                 left join tb084_accion_especifica as tb084 on tb084.id_tb083_proyecto_ac=tb083.id
                 left join tb085_presupuesto as tb085 on tb085.id_tb084_accion_especifica = tb084.id     
                 left join tb080_sector as tb080 on tb080.id  = tb083.id_tb080_sector 
                 left join tb138_ambito as tb138 on (tb138.co_ambito::text) = tb085.cod_amb
                 --left join tb138_ambito as tb138 on lpad((tb138.co_ambito::text),2,'0') = tb085.cod_amb
                 --left join tb160_tp_area as tb160 on (tb160.co_tp_area = tb138.nu_nivel)
                 where length(tb085.nu_partida) = 17 AND tb160.co_tp_area = ".$tipo." $condicion
                 GROUP BY 1, 2 
                 order by 1 asc ";*/

    /*$sql = "SELECT distinct  lpad((tb138.co_ambito::text),2,'0')cod_amb, (tb085.cod_amb ||'- '|| tb138.tx_ambito) as tx_ambito,
                 sum(mo_inicial) as inicial                        
                FROM tb082_ejecutor tb082
                left join tb083_proyecto_ac as tb083 on tb082.id= tb083.id_tb082_ejecutor
                left join tb084_accion_especifica as tb084 on tb084.id_tb083_proyecto_ac=tb083.id
                left join tb085_presupuesto as tb085 on tb085.id_tb084_accion_especifica = tb084.id     
                left join tb080_sector as tb080 on tb080.id  = tb083.id_tb080_sector 
                left join tb138_ambito as tb138 on (tb138.co_ambito::text) = tb085.cod_amb
                where in_movimiento is true $condicion
                GROUP BY 1, 2 
                order by 1 asc ";*/

                $sql = "SELECT co_aplicacion, nu_anio_fiscal, tx_tip_aplicacion,tx_aplicacion,(tx_tip_aplicacion ||'-'|| tx_aplicacion) as aplicacion,

                (SELECT sum(mo_inicial) as mo_ley
                    FROM tb085_presupuesto 
                    WHERE nu_anio = nu_anio_fiscal
                    AND tip_apl = tx_tip_aplicacion),
        
                 (SELECT sum(mo_distribucion) as mo_aumento
                    FROM tb097_modificacion_detalle as tb097
                    INNER JOIN tb085_presupuesto as tb085 on tb097.id_tb085_presupuesto = tb085.id
                        INNER JOIN tb096_presupuesto_modificacion tb096 on tb096.id = tb097.id_tb096_presupuesto_modificacion
                WHERE tb085.nu_anio = nu_anio_fiscal
                    AND tb097.id_tb098_tipo_distribucion = 1
                    AND tb085.tip_apl = tx_tip_aplicacion
                    AND  tb097.IN_ANULAR IS NULL
                    AND cast(tb096.fe_modificacion as date)  between '".$co_anio_fiscal."-01-01'::date AND '".$co_anio_fiscal."-12-31'),
        
        
                 (SELECT sum(mo_distribucion) as mo_disminucion
                    FROM tb097_modificacion_detalle as tb097
                    INNER JOIN tb085_presupuesto as tb085 on tb097.id_tb085_presupuesto = tb085.id
                        INNER JOIN tb096_presupuesto_modificacion tb096 on tb096.id = tb097.id_tb096_presupuesto_modificacion
                WHERE tb085.nu_anio = nu_anio_fiscal
                    AND tb097.id_tb098_tipo_distribucion = 2
                    AND tb085.tip_apl = tx_tip_aplicacion
                    AND  tb097.IN_ANULAR IS NULL
                    AND cast(tb096.fe_modificacion as date)  between '".$co_anio_fiscal."-01-01'::date AND '".$co_anio_fiscal."-12-31'),
        
                    (SELECT sum(nu_monto) as mo_comprometido
                            FROM tb087_presupuesto_movimiento as tb087
                            INNER JOIN tb085_presupuesto as tb085 on tb087.co_partida = tb085.id
                            WHERE tb085.nu_anio = nu_anio_fiscal
                            AND tb087.co_tipo_movimiento = 1
                            AND tb085.tip_apl = tx_tip_aplicacion
                            AND  IN_ANULAR IS NULL
                            AND tb087.created_at::date between '".$co_anio_fiscal."-01-01'::date AND '".$co_anio_fiscal."-12-31'),
        
                    (SELECT sum(nu_monto) as mo_causado
                            FROM tb087_presupuesto_movimiento as tb087
                            INNER JOIN tb085_presupuesto as tb085 on tb087.co_partida = tb085.id
                            WHERE tb085.nu_anio = nu_anio_fiscal
                            AND tb087.co_tipo_movimiento = 2
                            AND tb085.tip_apl = tx_tip_aplicacion
                            AND  IN_ANULAR IS NULL
                            AND tb087.created_at::date between '".$co_anio_fiscal."-01-01'::date AND '".$co_anio_fiscal."-12-31'),
        
                    (SELECT sum(nu_monto) as mo_pagado
                            FROM tb087_presupuesto_movimiento as tb087
                            INNER JOIN tb085_presupuesto as tb085 on tb087.co_partida = tb085.id
                            WHERE tb085.nu_anio = nu_anio_fiscal
                            AND tb087.co_tipo_movimiento = 3
                            AND tb085.tip_apl = tx_tip_aplicacion
                            AND  IN_ANULAR IS NULL
                            AND tb087.created_at::date between '".$co_anio_fiscal."-01-01'::date AND '".$co_anio_fiscal."-12-31')
        
        
        
                from tb139_aplicacion as tba where nu_anio_fiscal = ".$co_anio_fiscal."  and co_aplicacion in (
                    SELECT tb085.id_tb139_aplicacion
                     FROM tb085_presupuesto as tb085
                     WHERE tb085.nu_anio = $co_anio_fiscal
                     group by 1 order by 1 asc
                    ) order by tx_tip_aplicacion ASC;
        ";
    
          //echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
	
    }
    
    function partidas_mov($tipo, $id, $cod){
        
    /*
    1 -- Comprometido 
    2 -- Causado
    3 -- Pagado
    7 -- Incremento
    8 -- Deduccion
    */    
    $condicion ="";   
    $periodo    = $_GET['co_periodo']; 
    $anio       = $_GET['co_anio_fiscal'];       
    
    if ($_GET["co_anio_fiscal"])     $condicion .= " and tb085.nu_anio =".$anio; 
    if ($periodo==1) $condicion .= " and tb087.created_at >= '01-01-".$anio."' and tb087.created_at <= '31-03-".$anio."'";
    if ($periodo==2) $condicion .= " and tb087.created_at >= '01-04-".$anio."' and tb087.created_at <= '30-06-".$anio."'";  
    if ($periodo==3) $condicion .= " and tb087.created_at >= '01-07-".$anio."' and tb087.created_at <= '30-09-".$anio."'";
    if ($periodo==4) $condicion .= " and tb087.created_at >= '01-10-".$anio."' and tb087.created_at <= '31-12-".$anio."'";   

    $conex = new ConexionComun();     
    $sql = "    SELECT distinct 
                        sum(tb087.nu_monto) as monto
                 FROM tb080_sector as tb080
                 left join tb083_proyecto_ac as tb083 on tb080.id  = tb083.id_tb080_sector   
                 left join tb084_accion_especifica as tb084 on tb084.id_tb083_proyecto_ac=tb083.id
                 left join tb085_presupuesto as tb085 on tb085.id_tb084_accion_especifica = tb084.id
                 left join tb087_presupuesto_movimiento as tb087 on tb087.co_partida = tb085.id
                 left join tb138_ambito as tb138 on (tb138.co_ambito::text) = tb085.cod_amb                                                  
                 left join tb160_tp_area as tb160 on (tb160.co_tp_area = tb138.nu_nivel)
                where tb160.co_tp_area = ".$id." and tb085.cod_amb ='".$cod."'
                   and tb087.co_tipo_movimiento= $tipo 
                   and tb087.in_anular is not true
                   and length(tb085.nu_partida) = 17 
                   and tb087.created_at is not null $condicion 
                 group by tb085.cod_amb, tb160.co_tp_area order by 1 asc ";        

          //   echo var_dump($sql); exit();        
   
    
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
