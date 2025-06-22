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
        $this->Cell(0,0,utf8_decode('[FPRERA82]'),0,0,'L');
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
        //$this->Cell(0,0,utf8_decode('EJECUCIÓN PRESUPUESTARIA POR SECTORES - AÑO FISCAL '.$_GET['co_anio_fiscal']),0,0,'C'); 
        $this->Cell(0,0,utf8_decode('EJECUCIÓN PRESUPUESTARIA POR SECTORES - '.$_GET["fe_inicio"].' AL '.$_GET["fe_fin"]),0,0,'C'); 
        $this->Ln(2);          
        $this->SetY($Y);  
        $this->SetFont('courier','',8); 
        $this->SetWidths(array(100));
        $this->SetAligns(array("L")); 

        $this->SetX(10);                    
        $this->Row(array('PERIODO....:  '.$_GET["fe_inicio"]." hasta ".$_GET["fe_fin"]),0,0);   
        $this->SetX(10);          
        $this->Row(array('SECTOR.......:  '.$_GET['nu_sector']),0,0);    
        
        $tipo = $_GET['co_tipo'];

        if ($tipo==1)  // Consuta por Sector 
        {
            $this->Ln(7);       
            $this->SetFont('courier','B',9);
            $this->SetWidths(array(60,40,40,40,40,40,40,40));
            $this->SetAligns(array("C","R","R","R","R","R","R","R"));         
            $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
            $this->Row(array('Sector','Presupuestado','Modificado','Aprobado','Comprometido','Causado','Pagado','Disponible'),0,0);
            $this->Line(10, 50, 350, 50);                  
            $this->SetAligns(array("L","R","R","R","R","R","R","R"));                 

            $campo='';
            
            $total_ley    = 0;
            $total_mod    = 0;
            $total_aprob  = 0;
            $total_comp   = 0;
            $total_cau    = 0;
            $total_pag    = 0;
            $total_disp   = 0;
                    
            $this->Ln(2);
         
	    $this->lista_partidas = $this->partidas();          
         
	    foreach($this->lista_partidas as $key => $campo){
            if($this->getY()>170){
                $this->AddPage(); 
                 $Y = $this->GetY();  
                 $this->SetY($Y+12);          
                 $this->SetFont('courier','B',12);  
                 $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
                 //$this->Cell(0,0,utf8_decode('EJECUCIÓN PRESUPUESTARIA POR SECTORES  Y CÓDIGOS PRESUPUESTARIOS - AÑO FISCAL '.$_GET['co_anio_fiscal']),0,0,'C'); 
                 $this->Cell(0,0,utf8_decode('EJECUCIÓN PRESUPUESTARIA POR SECTORES - '.$_GET["fe_inicio"].' AL '.$_GET["fe_fin"]),0,0,'C'); 

                 $this->SetY($Y);  
                 $this->SetFont('courier','',8);   
                 $this->SetWidths(array(100));
                 $this->SetAligns(array("L"));                  
                $this->SetX(10);  
                if ($_GET['co_periodo']==1){
                    $nb_periodo = 'PRIMER TRIMESTRE';
                } 
                if ($_GET['co_periodo']==2){
                    $nb_periodo = 'SEGUNDO TRIMESTRE';
                } 
                if ($_GET['co_periodo']==3){
                    $nb_periodo = 'TERCER TRIMESTRE';
                } 
                if ($_GET['co_periodo']==4){
                    $nb_periodo = 'CUARTO TRIMESTRE';
                } 
                
                $this->Row(array('PERIODO....:  '.$nb_periodo),0,0);   
                $this->SetX(10);          
                $this->Row(array('SECTOR.......:  '.$_GET['nu_sector']),0,0);     
                $this->Ln(8);       
                $this->SetFont('courier','B',9);
                $this->SetWidths(array(100,40,40,40,40,40,40));
                $this->SetAligns(array("C","L","L","L","L","L","L","L","L"));       
                $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
                $this->Row(array('Sectores','Presupuestado','Modificado','Aprobado','Comprometido','Causado','Pagado'),0,0);
                $this->Line(10, 50, 350, 50);                  
                $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));    
                $this->Ln(2);
	        }        

         $this->SetFont('courier','',10);
         $this->SetWidths(array(60,40,40,40,40,40,40,40));
         $this->SetAligns(array("L","R","R","R","R","R","R","R"));      
         $monto_comp=0;

         /********************************************************************************************************/        
         /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
         /********************************************************************************************************/
//            $sectores              = $this->desc_sectores($campo['id']);  
//            $monto_incremento      = $this->partidas_mov(7, $campo['id'],1);       
//            $monto_disminucion     = $this->partidas_mov(8, $campo['id'],1);  
//            $monto_comprometido    = $this->partidas_mov(1, $campo['id'],1) ;             
//            $monto_comp            = $monto_comprometido['monto'] ;          
//            $monto_modificado      = ($monto_incremento['monto']) - $monto_disminucion['monto'];                
//            $monto_causado         = $this->partidas_mov(2, $campo['id'],1);   
//            $monto_pagado          = $this->partidas_mov(3, $campo['id'],1);                       
//            $aprobado              = $monto_modificado + $campo['inicial'];
       //   $monto_disponibilidad  = $monto_modificado - $monto_comprometido['monto'];       
         /********************************************************************************************************/
         
        $sectores              = $campo['sector'];  
        $monto_incremento      = $campo['mo_aumento'];       
        $monto_disminucion     = $campo['mo_disminucion'];             
        $monto_comp            = $campo['mo_comprometido'];          
        $monto_modificado      = ($campo['mo_modificado_mov']);               
        $monto_causado         = $campo['causado_admon']+$campo['mo_causado'];   
        $monto_pagado          = $campo['pagado_admon']+$campo['mo_pagado'];                     
        $aprobado              = $campo['inicial']+$monto_modificado;
        $disponible            = $aprobado - $monto_comp;
         
         
         $this->SetWidths(array(60,40,40,40,40,40,40,40));
         $this->Row(array(utf8_decode($sectores), number_format($campo['inicial'], 2, ',','.'),number_format($monto_modificado, 2, ',','.'),number_format($aprobado, 2, ',','.'),number_format($monto_comp, 2, ',','.'),number_format($monto_causado, 2, ',','.'),number_format($monto_pagado, 2, ',','.'),number_format($disponible, 2, ',','.')),0,0);

         $total_ley    += $campo['inicial'];
         $total_mod    += $monto_modificado;
         $total_aprob  += $aprobado;
         $total_comp   += $monto_comp;
         $total_cau    += $monto_causado;
         $total_pag    += $monto_pagado;
         $total_disp   += $disponible;
         
         }
         $this->Ln(5);
         $this->SetFont('courier','B',10);
         $this->SetWidths(array(60,40,40,40,40,40,40,40));
         $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));
         $this->Row(array('TOTAL RELACION........',number_format($total_ley, 2, ',','.'),number_format($total_mod, 2, ',','.'),number_format($total_aprob, 2, ',','.'),number_format($total_comp, 2, ',','.'),number_format($total_cau, 2, ',','.'),number_format($total_pag, 2, ',','.'),number_format($total_disp, 2, ',','.')));   
        }
        else // Consulta por Partida
        {
                $this->Ln(7);       
                $this->SetFont('courier','B',9);
                $this->SetWidths(array(60,40,40,40,40,40,40,40));
                $this->SetAligns(array("C","R","R","R","R","R","R","R","R","R","R","R"));         
                $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
                $this->Row(array('Sector','Presupuestado','Modificado','Aprobado','Comprometido','Causado','Pagado','Disponible'),0,0);
                $this->Line(10, 50, 350, 50);                  
                $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R","R"));                      

                 $campo='';

                 $total_ley    = 0;
                 $total_mod    = 0;
                 $total_aprob  = 0;
                 $total_comp   = 0;
                 $total_cau    = 0;
                 $total_pag    = 0;
                 $total_disp   = 0;

                 $this->Ln(2);

                 $this->lista_sectores = $this->partidas(); 

                 foreach($this->lista_sectores as $key => $inf){

                 $SUBtotal_ley    = 0;
                 $SUBtotal_mod    = 0;
                 $SUBtotal_aprob  = 0;
                 $SUBtotal_comp   = 0;
                 $SUBtotal_cau    = 0;
                 $SUBtotal_pag    = 0;
                 $SUBtotal_disp   = 0;

                 $this->lista_partidas = $this->codigos($inf['id']);    

                 foreach($this->lista_partidas as $key => $campo){

                    if($this->getY()>170){
                        $this->AddPage(); 
                         $Y = $this->GetY();  
                         $this->SetY($Y+12);          
                         $this->SetFont('courier','B',12);  
                         $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
                         $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA POR SECTORES Y CÓDIGOS PRESUPUESTARIOS - AÑO FISCAL '.$_GET['co_anio_fiscal']),0,0,'C'); 

                         $this->SetY($Y);  
                         $this->SetFont('courier','',8);   
                         $this->SetWidths(array(100));
                         $this->SetAligns(array("L"));                  
                        $this->SetX(10);  
                        if ($_GET['co_periodo']==1) $nb_periodo = 'PRIMER TRIMESTRE';
                        if ($_GET['co_periodo']==2) $nb_periodo = 'SEGUNDO TRIMESTRE';
                        if ($_GET['co_periodo']==3) $nb_periodo = 'TERCER TRIMESTRE';
                        if ($_GET['co_periodo']==4) $nb_periodo = 'CUARTO TRIMESTRE';

                        $this->Row(array('PERIODO....:  '.$nb_periodo),0,0);   
                        $this->SetX(10);          
                        $this->Row(array('SECTOR.......:  '.$_GET['nu_sector']),0,0);     
                        $this->Ln(8);       
                        $this->SetFont('courier','B',9);
                        $this->SetWidths(array(60,40,40,40,40,40,40,40));
                        $this->SetAligns(array("C","L","L","L","L","L","L","L"));       
                        $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
                        $this->Row(array('Cod. Presupuestario','Presupuestado','Modificado','Aprobado','Comprometido','Causado','Pagado','Disponible'),0,0);
                        $this->Line(10, 50, 350, 50);                  
                        $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R","R"));    
                        $this->Ln(2);
                        }        

                    $this->SetFont('courier','',10);
                    $this->SetWidths(array(60,40,40,40,40,40,40,40));
                    $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R","R"));      
                    $monto_comp=0;

                    /********************************************************************************************************/        
                    /**** CALCULOS DE LOS ESTADOS FINANCIEROS ***************************************************************/
                    /********************************************************************************************************/
//                       $part                  = $this->desc_partida($campo['nu_pa']);  
//                       $monto_incremento      = $this->partidas_mov(7, $campo['nu_pa'],2,$inf['id']);       
//                       $monto_disminucion     = $this->partidas_mov(8, $campo['nu_pa'],2,$inf['id']);  
//                       $monto_comprometido    = $this->partidas_mov(1, $campo['nu_pa'],2,$inf['id']) ;             
//                       $monto_comp            = $monto_comprometido['monto'] ;          
//                       $monto_modificado      = ($monto_incremento['monto']) - $monto_disminucion['monto'];                
//                       $monto_causado         = $this->partidas_mov(2, $campo['nu_pa'],2, $inf['id']);   
//                       $monto_pagado          = $this->partidas_mov(3, $campo['nu_pa'],2,$inf['id']);                       
//                       $aprobado              = $monto_modificado + $campo['inicial'];      
                        $part                  = $this->desc_partida($campo['nu_pa']); 
                        $sectores              = $campo['sector'];  
                        $monto_incremento      = $campo['mo_aumento'];       
                        $monto_disminucion     = $campo['mo_disminucion'];             
                        $monto_comp            = $campo['mo_comprometido'];          
                        $monto_modificado      = ($campo['mo_modificado_mov']);                
                        $monto_causado         = $campo['mo_causado'];   
                        $monto_pagado          = $campo['mo_pagado'];                     
                        $aprobado              = $campo['mo_aprobado']; //+$monto_modificado; 
                        $disponible            = $aprobado - $monto_comp;
                    /********************************************************************************************************/

                    $this->SetWidths(array(60,40,40,40,40,40,40,40));
                    $this->Row(array(utf8_decode($part['codigo']), number_format($campo['inicial'], 2, ',','.'),number_format($monto_modificado, 2, ',','.'),number_format($aprobado, 2, ',','.'),number_format($monto_comp, 2, ',','.'),number_format($monto_causado, 2, ',','.'),number_format($monto_pagado, 2, ',','.'),number_format($disponible, 2, ',','.')),0,0);

                    $SUBtotal_ley    += $campo['inicial'];
                    $SUBtotal_mod    += $monto_modificado;
                    $SUBtotal_aprob  += $aprobado;
                    $SUBtotal_comp   += $monto_comp;
                    $SUBtotal_cau    += $monto_causado;
                    $SUBtotal_pag    += $monto_pagado;
                    $SUBtotal_disp   += $disponible;

                }

                 $total_ley    += $SUBtotal_ley;
                 $total_mod    += $SUBtotal_mod;
                 $total_aprob  += $SUBtotal_aprob;
                 $total_comp   += $SUBtotal_comp;
                 $total_cau    += $SUBtotal_cau;
                 $total_pag    += $SUBtotal_pag;
                 $total_disp   += $SUBtotal_disp;


                 $this->SetFont('courier','B',10);
                 $this->SetWidths(array(60,40,40,40,40,40,40,40));
                 $this->SetAligns(array("L","R","R","R","R","R","R","R"));
                 $this->Row(array('TOTAL SECTOR. '.$inf['id'],number_format($SUBtotal_ley, 2, ',','.'),number_format($SUBtotal_mod, 2, ',','.'),number_format($SUBtotal_aprob, 2, ',','.'),number_format($SUBtotal_comp, 2, ',','.'),number_format($SUBtotal_cau, 2, ',','.'),number_format($SUBtotal_pag, 2, ',','.'),number_format($SUBtotal_disp, 2, ',','.')));   
                 $this->Ln(5);

               } 
                 $this->Ln(5);
                 $this->SetFont('courier','B',10);
                 $this->SetWidths(array(60,40,40,40,40,40,40,40));
                 $this->SetAligns(array("L","R","R","R","R","R","R","R"));
                 $this->Row(array('TOTAL RELACION........',number_format($total_ley, 2, ',','.'),number_format($total_mod, 2, ',','.'),number_format($total_aprob, 2, ',','.'),number_format($total_comp, 2, ',','.'),number_format($total_cau, 2, ',','.'),number_format($total_pag, 2, ',','.'),number_format($total_disp, 2, ',','.')));   
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
    
    function desc_sectores($cod){
        
    $conex = new ConexionComun();     
    $sql = "   SELECT (nu_sector||'-'||de_sector) as sector
                FROM tb080_sector as tb080
                where id = ".$cod;          

       //  echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0]; 
	
    }    
   
    function desc_partida($cod){
        
    $conex = new ConexionComun();     
    $sql = "SELECT (tb085.nu_pa||'-'||tb085.de_partida) as codigo, tb085.nu_pa
            FROM tb085_presupuesto as tb085
            where tb085.nu_pa = '".$cod."' and length(nu_partida) = 3 order by 1 asc;";          

       //   echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0]; 
	
    }     
    
    function partidas(){
        
        $condicion ="";
        $sector     = $_GET['nu_sector'];
        $periodo    = $_GET['co_periodo']; 
        $anio       = $_GET['co_anio_fiscal'];   

        if ($_GET["nu_sector"]){
            $condicion .= " and tb080.id =".$sector;
        } 
        if ($_GET["co_anio_fiscal"]){
            $condicion .= " and tb085.nu_anio =".$anio;
        }    

        list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
        $fe_inicio = $anio.'-'.$mes.'-'.$dia;

        list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
        $fe_fin = $anio.'-'.$mes.'-'.$dia;

        $conex = new ConexionComun();     
       
        $sql = "SELECT distinct 
                tb080.id,(tb080.nu_sector||'-'||tb080.de_sector) as sector, 		
                sum(mo_inicial) as inicial, 
                (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_modificado_mov,
                sum(mo_inicial)+ (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) as mo_aprobado,
                coalesce(sum(comprometido_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_comprometido,
                coalesce(sum(causado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0) mo_causado,
                coalesce(sum(pagado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,3,'$fe_inicio','$fe_fin')),0) mo_pagado
                FROM tb085_presupuesto as tb085 inner join tb080_sector as tb080 on (substring(tb085.co_categoria,6,2) = tb080.nu_sector )
                where in_movimiento is true and  length(nu_partida)=17 $condicion 
                group by 1
                order by 1 asc;";
    
          //echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
	
    }
  
    
    function codigos($sect){
        
        $condicion ="";
        $sector     = $_GET['nu_sector'];
        $periodo    = $_GET['co_periodo']; 
        $anio       = $_GET['co_anio_fiscal'];   

        if ($sector){
            $condicion .= " and tb080.id =".$sector; 
        }     
        if ($sect){
            $condicion .= " and tb080.id =".$sect;
        }        
        if ($_GET["co_anio_fiscal"]){
            $condicion .= " and tb085.nu_anio =".$anio; 
        }   

        list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
        $fe_inicio = $anio.'-'.$mes.'-'.$dia;

        list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
        $fe_fin = $anio.'-'.$mes.'-'.$dia;

        $conex = new ConexionComun();     
         
        $sql = "SELECT tb080.id, 
                        nu_pa, 
                        sum(mo_inicial) as inicial, 
                        (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_modificado_mov,
                        sum(mo_inicial)+ (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0)) -coalesce(sum(afectacion_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) as mo_aprobado,
                        coalesce(sum(comprometido_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,1,'$fe_inicio','$fe_fin')),0) mo_comprometido,
                        coalesce(sum(causado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,2,'$fe_inicio','$fe_fin')),0) mo_causado,
                        coalesce(sum(pagado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$anio,3,'$fe_inicio','$fe_fin')),0) mo_pagado
                 FROM tb085_presupuesto as tb085 inner join
                      tb080_sector as tb080 on (substring(tb085.co_categoria,6,2) = tb080.nu_sector ) 
                 where in_movimiento is true and  length(nu_partida)=17  $condicion 
                 group by 1,2 order by 1,2 asc;";
   //echo $sql;   exit();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol; 
	
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
$pdf=new PDF('L','mm','legal');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
