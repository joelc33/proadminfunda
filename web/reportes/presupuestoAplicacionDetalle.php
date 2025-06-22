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
        $this->Cell(0,0,utf8_decode('[FPRER054]'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R'); 
        
   }

    function Footer() {
	    $this->SetFont('courier','B',9);     
        $this->SetY(260);
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
        $this->Cell(0,0,utf8_decode('RESUMEN DE EJECUCIÓN PRESUPUESTARIA POR APLICACIÓN AL '.date("d/m/Y", strtotime($_GET['fe_inicio']))),0,0,'C');
        //$this->Cell(0,0,utf8_decode('RESUMEN DE EJECUCIÓN PRESUPUESTARIA POR APLICACIÓN DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin']))),0,0,'C'); 
        $this->Ln(2);          
        $this->SetY($Y);  
               

        $this->Ln(20);       
        $this->SetFont('courier','B',9);
        //$this->SetWidths(array(80,25,30,30,30,30,30,35,35,35,35));
        $this->SetWidths(array(80,30,30,30,30,30,35,35,35,35));
        $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));       
        $this->SetX(10);       
        //$this->Row(array(utf8_decode('Aplic. Denominación'),'Fuente','Monto Ley','Aumentos','Disminuciones','Modificado','Aprobado','Comprometido_dia','Causado_dia','Pagado_dia','Disponibilidad'),1,0);
        $this->Row(array(utf8_decode('Aplic. Denominación'), 'Monto Ley','Aumentos','Disminuciones','Modificado','Aprobado','Comprometido_dia','Causado_dia','Pagado_dia','Disponibilidad'),1,0);                           
        
        $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));                 

         $campo='';
         $total_ley    = 0;
         $total_mod    = 0;
         $total_aum    = 0;
         $total_dis    = 0;
         $total_aprob  = 0;
         $total_comp   = 0;
         $total_cau    = 0;
         $total_pag    = 0;
         $total_disp   = 0;
         
         $this->Ln(2);
         $this->SetFont('courier','B',9);
         $this->SetWidths(array(100));
         $this->SetAligns(array("L"));
         
	 $this->lista_apl = $this->aplicaciones();          
         
	 foreach($this->lista_apl as $key => $campo){
            
            if($this->getY()>250){
                $this->AddPage(); 
                $Y = $this->GetY();  
                $this->SetY($Y+12);          
                $this->SetFont('courier','B',12);  
                $this->SetX(0); 
                $this->Cell(0,0,utf8_decode('RESUMEN DE EJECUCIÓN PRESUPUESTARIA POR APLICACIÓN AL '.date("d/m/Y", strtotime($_GET['fe_inicio']))),0,0,'C');  
                //$this->Cell(0,0,utf8_decode('RESUMEN DE EJECUCIÓN PRESUPUESTARIA POR APLICACIÓN DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin']))),0,0,'C'); 

                $this->SetY($Y);  
                $this->Ln(8);       
                $this->SetFont('courier','B',9);
                //$this->SetWidths(array(80,25,30,30,30,30,30,35,35,35,35));
                $this->SetWidths(array(80,30,30,30,30,30,35,35,35,35));
                $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C"));       
                $this->Ln(20);  
                $this->SetX(10);
                //$this->Row(array(utf8_decode('Aplic. Denominación'),'Fuente','Monto Ley','Aumentos','Disminuciones','Modificado','Aprobado','Comprometido_dia','Causado_dia','Pagado_dia','Disponibilidad'),1,0);
                $this->Row(array(utf8_decode('Aplic. Denominación'),'Monto Ley','Aumentos','Disminuciones','Modificado','Aprobado','Comprometido_dia','Causado_dia','Pagado_dia','Disponibilidad'),1,0);
                $this->SetAligns(array("L","L","R","R","R","R","R","R","R","R","R"));    
                $this->Ln(2);
	        }        

         /********************************************************************************************************/        
         /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
         /********************************************************************************************************/
            $monto_incremento      = $campo['mo_aumento'];       
            $monto_disminucion     = $campo['mo_disminucion'];                   
            $monto_comp            = $campo['mo_comprometido'];          
            $monto_modificado      = $campo['mo_aumento']-$campo['mo_disminucion'];  //correcta              
            $monto_causado         = $campo['mo_causado'];  
            $monto_pagado          = $campo['mo_pagado'];  
            $aprobado              = $monto_modificado + $campo['mo_ley'];      //correcto    
            $monto_disponible      = $campo['mo_ley']+$monto_modificado-$campo['mo_comprometido'];  //correcto
         /********************************************************************************************************/ 
        
         $fuentes='';
         $band   =1;
         $this->fuentes = $this->fuente($campo['tx_tip_aplicacion']);  
         foreach($this->fuentes as $key => $dato){
           if(count($this->fuentes)>1)  
           {  
                if($band==1){
                    $fuentes = $dato['nu_fi'];
                }
                else{
                   $fuentes = $fuentes.'/'.$dato['nu_fi'];
                }
               $band=0;
               
           }else{
                $fuentes = $dato['nu_fi'];
           } 
         }
         $this->SetFont('courier','',8);
         //$this->SetWidths(array(80,25,30,30,30,30,30,35,35,35,35));
         $this->SetWidths(array(80,30,30,30,30,30,35,35,35,35));
         $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));
         $this->SetX(10);
         //$this->Row(array($campo['aplicacion'],$fuentes,number_format($campo['inicial'], 2, ',','.'),number_format($monto_incremento, 2, ',','.'),number_format($monto_disminucion, 2, ',','.'),number_format($monto_modificado, 2, ',','.'),number_format($aprobado, 2, ',','.'),number_format($monto_comp, 2, ',','.'),number_format($monto_causado, 2, ',','.'),number_format($monto_pagado, 2, ',','.'),number_format($monto_disponible, 2, ',','.')),1,0);
         $this->Row(array($campo['aplicacion'],number_format($campo['mo_ley'], 2, ',','.'),number_format($monto_incremento, 2, ',','.'),number_format($monto_disminucion, 2, ',','.'),number_format($monto_modificado, 2, ',','.'),number_format($aprobado, 2, ',','.'),number_format($monto_comp, 2, ',','.'),number_format($monto_causado, 2, ',','.'),number_format($monto_pagado, 2, ',','.'),number_format($monto_disponible, 2, ',','.')),1,0);

         $this->lista_partida = $this->appPartida( $campo['co_aplicacion'], $_GET['fe_inicio']); 

         foreach($this->lista_partida as $key => $campo2){

            if($this->getY()>250){
                $this->AddPage(); 
                $Y = $this->GetY();  
                $this->SetY($Y+12);          
                $this->SetFont('courier','B',12);  
                $this->SetX(0); 
                $this->Cell(0,0,utf8_decode('RESUMEN DE EJECUCIÓN PRESUPUESTARIA POR APLICACIÓN AL '.date("d/m/Y", strtotime($_GET['fe_inicio']))),0,0,'C');  
                //$this->Cell(0,0,utf8_decode('RESUMEN DE EJECUCIÓN PRESUPUESTARIA POR APLICACIÓN DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin']))),0,0,'C'); 

                $this->SetY($Y);  
                $this->Ln(8);       
                $this->SetFont('courier','B',9);
                //$this->SetWidths(array(80,25,30,30,30,30,30,35,35,35,35));
                $this->SetWidths(array(80,30,30,30,30,30,35,35,35,35));
                $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C"));       
                $this->Ln(20);  
                $this->SetX(10);
                //$this->Row(array(utf8_decode('Aplic. Denominación'),'Fuente','Monto Ley','Aumentos','Disminuciones','Modificado','Aprobado','Comprometido_dia','Causado_dia','Pagado_dia','Disponibilidad'),1,0);
                $this->Row(array(utf8_decode('Aplic. Denominación'),'Monto Ley','Aumentos','Disminuciones','Modificado','Aprobado','Comprometido_dia','Causado_dia','Pagado_dia','Disponibilidad'),1,0);
                $this->SetAligns(array("L","L","R","R","R","R","R","R","R","R","R"));    
                $this->Ln(2);
	        } 

            $this->SetFont('courier','',8);
            //$ley = $this->appPartidaTipo( $campo2['id'], 12, $_GET['fe_inicio']);
            $comprometido = $this->appPartidaTipo( $campo2['id'], 1, $_GET['fe_inicio']);
            $causado = $this->appPartidaTipo( $campo2['id'], 2, $_GET['fe_inicio']);
            $pagado = $this->appPartidaTipo( $campo2['id'], 3, $_GET['fe_inicio']);
            $aumento = $this->appPartidaTipo( $campo2['id'], 7, $_GET['fe_inicio']);
            $disminucion = $this->appPartidaTipo( $campo2['id'], 8, $_GET['fe_inicio']);
            $pa_modificado = $aumento['mo_movimiento']-$disminucion['mo_movimiento'];
            $pa_aprobado = $pa_modificado + $campo2['mo_inicial'];          
            $pa_disponible = $pa_aprobado-$comprometido['mo_movimiento']; 
            
            $this->Row(array(
            utf8_decode($campo2['nu_partida'].' - '.$campo2['de_partida']),
            number_format($campo2['mo_inicial'], 2, ',','.'),
            number_format($aumento['mo_movimiento'], 2, ',','.'),
            number_format($disminucion['mo_movimiento'], 2, ',','.'),
            number_format($pa_modificado, 2, ',','.'),
            number_format($pa_aprobado, 2, ',','.'),
            number_format($comprometido['mo_movimiento'], 2, ',','.'),
            number_format($causado['mo_movimiento'], 2, ',','.'),
            number_format($pagado['mo_movimiento'], 2, ',','.'),
            number_format($pa_disponible, 2, ',','.')),1,0);
         }
         
         $total_ley    += $campo['mo_ley'];
         $total_mod    += $monto_modificado;
         $total_aum    += $monto_incremento;
         $total_dis    += $monto_disminucion;
         $total_aprob  += $aprobado;
         $total_comp   += $monto_comp;
         $total_cau    += $monto_causado;
         $total_pag    += $monto_pagado;      
         $total_disp   += $monto_disponible;  
         
          
      }
         $this->Ln(2); 
         $this->SetFont('courier','B',7);
         //$this->SetWidths(array(105,30,30,30,30,35,35,35,35));
         //$this->SetWidths(array(80,30,30,30,30,35,35,35,35));
         $this->SetWidths(array(80,30,30,30,30,30,35,35,35,35));
         $this->SetAligns(array("L","L","R","R","R","R","R","R","R","R","R"));
         $this->Row(array('TOTAL RELACION........',number_format($total_ley, 2, ',','.'),number_format($total_aum, 2, ',','.'),number_format($total_dis, 2, ',','.'),number_format($total_mod, 2, ',','.'),number_format($total_aprob, 2, ',','.'),number_format($total_comp, 2, ',','.'),number_format($total_cau, 2, ',','.'),number_format($total_pag, 2, ',','.'),number_format($total_disp, 2, ',','.')));   

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
    
    function aplicaciones(){
        
    $conex = new ConexionComun();

    /*Campo tipo DATE */
    list($dia_ini, $mes_ini, $anio_ini) = explode("-", $_GET['fe_inicio']);
    $fecha_ini = $anio_ini."-".$mes_ini."-".$dia_ini;

    list($dia_fin, $mes_fin, $anio_fin) = explode("-", $_GET['fe_inicio']);
    $fecha_fin = $anio_fin."-".$mes_fin."-".$dia_fin;

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
			AND tb097.id_tb098_tipo_distribucion = 2
			AND tb085.tip_apl = tx_tip_aplicacion
			AND  tb097.IN_ANULAR IS NULL
			AND cast(tb096.fe_modificacion as date)  between '".$anio_fin."-01-01'::date AND '".$fecha_ini."'),


         (SELECT sum(mo_distribucion) as mo_disminucion
			FROM tb097_modificacion_detalle as tb097
			INNER JOIN tb085_presupuesto as tb085 on tb097.id_tb085_presupuesto = tb085.id
		        INNER JOIN tb096_presupuesto_modificacion tb096 on tb096.id = tb097.id_tb096_presupuesto_modificacion
		WHERE tb085.nu_anio = nu_anio_fiscal
			AND tb097.id_tb098_tipo_distribucion = 1
			AND tb085.tip_apl = tx_tip_aplicacion
			AND  tb097.IN_ANULAR IS NULL
			AND cast(tb096.fe_modificacion as date)  between '".$anio_fin."-01-01'::date AND '".$fecha_ini."'),

            (SELECT sum(nu_monto) as mo_comprometido
					FROM tb087_presupuesto_movimiento as tb087
					INNER JOIN tb085_presupuesto as tb085 on tb087.co_partida = tb085.id
					WHERE tb085.nu_anio = nu_anio_fiscal
					AND tb087.co_tipo_movimiento = 1
					AND tb085.tip_apl = tx_tip_aplicacion
					AND  IN_ANULAR IS NULL
					AND tb087.created_at::date between '".$anio_fin."-01-01'::date AND '".$fecha_ini."'),

            (SELECT sum(nu_monto) as mo_causado
					FROM tb087_presupuesto_movimiento as tb087
					INNER JOIN tb085_presupuesto as tb085 on tb087.co_partida = tb085.id
					WHERE tb085.nu_anio = nu_anio_fiscal
					AND tb087.co_tipo_movimiento = 2
					AND tb085.tip_apl = tx_tip_aplicacion
					AND  IN_ANULAR IS NULL
					AND tb087.created_at::date between '".$anio_fin."-01-01'::date AND '".$fecha_ini."'),

            (SELECT sum(nu_monto) as mo_pagado
					FROM tb087_presupuesto_movimiento as tb087
					INNER JOIN tb085_presupuesto as tb085 on tb087.co_partida = tb085.id
					WHERE tb085.nu_anio = nu_anio_fiscal
					AND tb087.co_tipo_movimiento = 3
					AND tb085.tip_apl = tx_tip_aplicacion
					AND  IN_ANULAR IS NULL
					AND tb087.created_at::date between '".$anio_fin."-01-01'::date AND '".$fecha_ini."')



        from tb139_aplicacion as tba where nu_anio_fiscal = ".$anio_ini."  and co_aplicacion in (
            SELECT tb085.id_tb139_aplicacion
             FROM tb085_presupuesto as tb085
             WHERE tb085.nu_anio = $anio_ini
             group by 1 order by 1 asc
            ) order by tx_tip_aplicacion ASC;
";

        //echo var_dump($sql); exit();        
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol; 	
    }  

    function fuente($cod){
        
    $conex = new ConexionComun();     
    $sql = "   SELECT distinct tb085.nu_fi
                FROM tb085_presupuesto as tb085
                where tb085.tip_apl='".$cod."'  and tb085.nu_fi<>''               
                order by 1 asc;";          

          //echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 	
    }

    function appPartida($app, $fecha_fin){

        list($dia_fin, $mes_fin, $anio_fin) = explode("-", $fecha_fin);

        $fecha = $anio_fin."-".$mes_fin."-".$dia_fin;
        
        $conex = new ConexionComun();     
        $sql = "SELECT tb085.id, nu_partida, de_partida,mo_inicial
        FROM tb087_presupuesto_movimiento as tb087
        INNER JOIN tb085_presupuesto as tb085 on tb087.co_partida = tb085.id
        WHERE tb085.id_tb139_aplicacion = ".$app." AND
        tb085.created_at::date BETWEEN '".$anio_fin."-01-01'::date AND '".$fecha."'
        group by 1,2,3 order by 2 asc;";
    
        //echo var_dump($sql); exit();        
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol; 	
    }

    function appPartidaTipo($partida, $tipo, $fecha_fin){

        list($dia_fin, $mes_fin, $anio_fin) = explode("-", $fecha_fin);

        $fecha = $anio_fin."-".$mes_fin."-".$dia_fin;
        
        $conex = new ConexionComun();     
        $sql = "SELECT sum(nu_monto) as mo_movimiento
        FROM tb087_presupuesto_movimiento as tb087
        INNER JOIN tb085_presupuesto as tb085 on tb087.co_partida = tb085.id
        WHERE tb087.co_partida = ".$partida." AND
        tb087.co_tipo_movimiento = ".$tipo." AND
        tb085.created_at::date BETWEEN '".$anio_fin."-01-01'::date AND '".$fecha."';";
    
        //echo var_dump($sql); exit();        
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];
        //return  $datosSol; 	
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


}
$pdf=new PDF('L','mm','A3');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
