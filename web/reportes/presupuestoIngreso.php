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
        $this->SetY($Y+5);          
        $this->SetFont('Arial','B',12);  
        $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
        $this->Cell(0,0,utf8_decode('EJECUCIÓN PRESUPUESTARIA DE INGRESO - AÑO FISCAL '.$anio),0,0,'C'); 
        $this->Ln(5);          
        
        $this->SetFont('Arial','B',10); 
        $this->SetWidths(array(100));
        $this->SetAligns(array("L")); 
        $this->SetX(10);                    
        $this->Row(array('PERIODO....:  01-01-'.$_GET['co_anio_fiscal'].' A '.$_GET['fe_fin']),0,0);   
        $this->SetX(10);            

        $this->Ln(7);       
        $this->SetFont('Arial','B',9);
        $this->SetWidths(array(35,40,36,40,40,40,20,40,15,30,10));
        $this->SetAligns(array("C","C","R","R","R","R","C","R","C","R","C"));                
        $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
        $this->Row(array('CODIGO PRESUPUESTARIO','DENOMINACION','PRESUPUESTADO','MODIFICADO','TOTAL APROBADO','DEVENGADO','%','LIQUIDADO','%','RECAUDADO','%'),0,0);
        $this->Line(10, 50, 350, 50);                  
        $this->SetAligns(array("L","R","R","R","R","R","R","R","R","R","R"));                 

        $campo='';
        $this->Ln(2);
        $tipo = $_GET["co_tipo"];

        $cond_tipo = array( 1, 2);
        if (in_array( $tipo, $cond_tipo)){
         
        $this->nivel_uno = $this->partidas_uno( $_GET['co_anio_fiscal'], $_GET["fe_fin"]);
        
        $total_ini = 0;
        $total_mod = 0;
        $total_dev = 0;
        $total_liq = 0;
        $total_rec = 0;

        foreach($this->nivel_uno as $key => $campo){
            
            $this->mo_inicial = $this->mo_uno('', 12, $_GET['co_anio_fiscal'], $_GET['fe_fin']);
            $this->mo_actualizado = $this->mo_uno('', 7, $_GET['co_anio_fiscal'], $_GET['fe_fin']);
            $this->mo_devengado = $this->mo_uno('', 9, $_GET['co_anio_fiscal'], $_GET['fe_fin']);
            $this->mo_liquidado = $this->mo_uno('', 10, $_GET['co_anio_fiscal'], $_GET['fe_fin']);
            $this->mo_recaudado = $this->mo_uno('', 11, $_GET['co_anio_fiscal'], $_GET['fe_fin']);

            $total_presupuestado = $this->mo_inicial['mo_partida'];
            $total_modificado = $this->mo_actualizado['mo_partida'];
            $total_devengado = $this->mo_devengado['mo_partida'];
            $total_liquidado = $this->mo_liquidado['mo_partida'];
            $total_recaudado = $this->mo_recaudado['mo_partida'];

            $total_aprobado = $total_presupuestado + $total_modificado;
         
            $total_devengadox100  = (($total_devengado)*100)/$total_aprobado;  
            $total_causadox100    = (($total_liquidado)*100)/$total_devengado;  
            $total_pagadox100     = (($total_recaudado)*100)/$total_liquidado;

            $this->SetFont('Arial','B',8);
            $this->SetWidths(array(35,40,36,40,40,38,20,35,17,32,12));
            $this->SetAligns(array("L","L","R","R","R","R","C","R","C","R","C"));   
            $this->Row(array(
               '3',
               'RECURSOS', 
               number_format($total_presupuestado, 2, ',','.'), 
               number_format($total_modificado, 2, ',','.'),
               number_format($total_aprobado, 2, ',','.'), 
               number_format($total_devengado, 2, ',','.'), 
               number_format($total_devengadox100, 2, ',','.'), 
               number_format($total_liquidado, 2, ',','.'), 
               number_format($total_causadox100, 2, ',','.'), 
               number_format($total_recaudado, 2, ',','.'), 
               number_format($total_pagadox100, 2, ',','.')
           ),0,0);


            if($this->getY()>170){
                $this->AddPage(); 
                $Y = $this->GetY();  
                $this->SetY($Y+5);          
                $this->SetFont('Arial','B',12);  
                $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
                $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA DE INGRESO - AÑO FISCAL '.$anio),0,0,'C'); 

                $this->SetY($Y);  
                $this->SetFont('Arial','',8);   
                $this->SetWidths(array(100));
                $this->SetAligns(array("L"));                  
                $this->SetX(10);  

                $this->Row(array('PERIODO....:  01-01-'.$_GET['co_anio_fiscal'].' A '.$_GET['fe_fin']),0,0);    
                $this->SetX(10);            
                $this->Ln(8);       
                $this->SetFont('Arial','B',9);
                $this->SetWidths(array(35,40,36,40,40,36,15,36,15,33,15));
                $this->SetAligns(array("C","C","R","R","R","R","C","R","C","R","C","R","R","R","R"));        
                $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
                $this->Row(array('CODIGO PRESUPUESTARIO','DENOMINACION','PRESUPUESTADO','MODIFICADO','TOTAL APROBADO','DEVENGADO','%','LIQUIDADO','%','RECAUDADO','%'),0,0);
                $this->Line(10, 50, 350, 50);    
                $this->Ln(2);
            }

            $this->nivel_dos = $this->partidas_dos('', $_GET['co_anio_fiscal']);             
             
            foreach($this->nivel_dos as $key => $campo_dos){

                $this->mo_inicial = $this->mo_dos($campo_dos['nu_pa'], 12, $campo_dos['nu_anio'], $_GET['fe_fin']);
                $this->mo_actualizado = $this->mo_dos($campo_dos['nu_pa'], 7, $campo_dos['nu_anio'], $_GET['fe_fin']);
                $this->mo_devengado = $this->mo_dos($campo_dos['nu_pa'], 9, $campo_dos['nu_anio'], $_GET['fe_fin']);
                $this->mo_liquidado = $this->mo_dos($campo_dos['nu_pa'], 10, $campo_dos['nu_anio'], $_GET['fe_fin']);
                $this->mo_recaudado = $this->mo_dos($campo_dos['nu_pa'], 11, $campo_dos['nu_anio'], $_GET['fe_fin']);

                $total_presupuestado = $this->mo_inicial['mo_partida']; 
                $total_modificado = $this->mo_actualizado['mo_partida'];
                $total_devengado = $this->mo_devengado['mo_partida'];
                $total_liquidado = $this->mo_liquidado['mo_partida'];
                $total_recaudado = $this->mo_recaudado['mo_partida'];

                $total_aprobado = $total_presupuestado + $total_modificado;
                
                $total_devengadox100  = (($total_devengado)*100)/$total_aprobado;  
                $total_causadox100    = (($total_liquidado)*100)/$total_devengado;  
                $total_pagadox100     = (($total_recaudado)*100)/$total_liquidado; 
                $this->SetFont('Arial','',8);
                $this->SetWidths(array(35,40,36,40,40,38,20,35,17,32,12));
                $this->SetAligns(array("L","L","R","R","R","R","C","R","C","R","C"));  
                $this->Row(array(
                    $campo_dos['nu_pa'],
                    utf8_decode($campo_dos['tx_descripcion']), 
                    number_format($total_presupuestado, 2, ',','.'), 
                    number_format($total_modificado, 2, ',','.'),
                    number_format($total_aprobado, 2, ',','.'), 
                    number_format($total_devengado, 2, ',','.'), 
                    number_format($total_devengadox100, 2, ',','.'), 
                    number_format($total_liquidado, 2, ',','.'), 
                    number_format($total_causadox100, 2, ',','.'), 
                    number_format($total_recaudado, 2, ',','.'), 
                    number_format($total_pagadox100, 2, ',','.')
               ),0,0);


                if($this->getY()>170){
                    $this->AddPage(); 
                    $Y = $this->GetY();  
                    $this->SetY($Y+5);          
                    $this->SetFont('Arial','B',12);  
                    $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
                    $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA DE INGRESO - AÑO FISCAL '.$anio),0,0,'C'); 
    
                    $this->SetY($Y);  
                    $this->SetFont('Arial','',8);   
                    $this->SetWidths(array(100));
                    $this->SetAligns(array("L"));                  
                    $this->SetX(10);  
    
                    $this->Row(array('PERIODO....:  01-01-'.$_GET['co_anio_fiscal'].' A '.$_GET['fe_fin']),0,0);      
                    $this->SetX(10);            
                    $this->Ln(8);       
                    $this->SetFont('Arial','B',9);
                    $this->SetWidths(array(35,40,36,40,40,36,15,36,15,33,15));
                    $this->SetAligns(array("C","C","R","R","R","R","C","R","C","R","C","R","R","R","R"));        
                    $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
                    $this->Row(array('CODIGO PRESUPUESTARIO','DENOMINACION','PRESUPUESTADO','MODIFICADO','TOTAL APROBADO','DEVENGADO','%','LIQUIDADO','%','RECAUDADO','%'),0,0);
                    $this->Line(10, 50, 350, 50);    
                    $this->Ln(2);
                }

                $cond_tipo = array( 1);
                if (in_array( $tipo, $cond_tipo)){

                    $total_ini = $total_ini + $total_presupuestado;
                    $total_mod = $total_mod + $total_modificado;
                    $total_dev = $total_dev + $total_devengado;
                    $total_liq = $total_liq + $total_liquidado;
                    $total_rec = $total_rec + $total_recaudado;

                    continue;
                }

                $this->nivel_tres = $this->partidas_tres($campo_dos['nu_pa'], $campo_dos['nu_anio']);             
             
                foreach($this->nivel_tres as $key => $campo_tres){ 

                        $this->mo_inicial = $this->mo_tres($campo_tres['nu_pa'], $campo_tres['nu_ge'], 12, $campo_tres['nu_anio'], $_GET['fe_fin']);
                        $this->mo_actualizado = $this->mo_tres($campo_dos['nu_pa'], $campo_tres['nu_ge'], 7, $campo_tres['nu_anio'], $_GET['fe_fin']);
                        $this->mo_devengado = $this->mo_tres($campo_dos['nu_pa'], $campo_tres['nu_ge'], 9, $campo_tres['nu_anio'], $_GET['fe_fin']);
                        $this->mo_liquidado = $this->mo_tres($campo_dos['nu_pa'], $campo_tres['nu_ge'], 10, $campo_tres['nu_anio'], $_GET['fe_fin']);
                        $this->mo_recaudado = $this->mo_tres($campo_dos['nu_pa'], $campo_tres['nu_ge'], 11, $campo_tres['nu_anio'], $_GET['fe_fin']);

                        $total_presupuestado = $this->mo_inicial['mo_partida'];
                        $total_modificado = $this->mo_actualizado['mo_partida'];
                        $total_devengado = $this->mo_devengado['mo_partida'];
                        $total_liquidado = $this->mo_liquidado['mo_partida'];
                        $total_recaudado = $this->mo_recaudado['mo_partida'];

                        $total_aprobado = $total_presupuestado + $total_modificado;

                        $total_devengadox100  = (($total_devengado)*100)/$total_aprobado;  
                        $total_causadox100    = (($total_liquidado)*100)/$total_devengado;  
                        $total_pagadox100     = (($total_recaudado)*100)/$total_liquidado; 

                        $this->SetFont('Arial','',8);
                        $this->SetWidths(array(35,40,36,40,40,38,20,35,17,32,12));
                        $this->SetAligns(array("L","L","R","R","R","R","C","R","C","R","C")); 
                        $this->Row(array(
                            $campo_tres['nu_pa'].'.'.$campo_tres['nu_ge'],
                            utf8_decode($campo_tres['tx_descripcion']), 
                            number_format($total_presupuestado, 2, ',','.'), 
                            number_format($total_modificado, 2, ',','.'),
                            number_format($total_aprobado, 2, ',','.'), 
                            number_format($total_devengado, 2, ',','.'), 
                            number_format($total_devengadox100, 2, ',','.'), 
                            number_format($total_liquidado, 2, ',','.'), 
                            number_format($total_causadox100, 2, ',','.'), 
                            number_format($total_recaudado, 2, ',','.'), 
                            number_format($total_pagadox100, 2, ',','.')
                    ),0,0);

                    if($this->getY()>170){
                        $this->AddPage(); 
                        $Y = $this->GetY();  
                        $this->SetY($Y+5);          
                        $this->SetFont('Arial','B',12);  
                        $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
                        $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA DE INGRESO - AÑO FISCAL '.$anio),0,0,'C'); 
        
                        $this->SetY($Y);  
                        $this->SetFont('Arial','',8);   
                        $this->SetWidths(array(100));
                        $this->SetAligns(array("L"));                  
                        $this->SetX(10);  
        
                        $this->Row(array('PERIODO....:  01-01-'.$_GET['co_anio_fiscal'].' A '.$_GET['fe_fin']),0,0);       
                        $this->SetX(10);            
                        $this->Ln(8);       
                        $this->SetFont('Arial','B',9);
                        $this->SetWidths(array(35,40,36,40,40,36,15,36,15,33,15));
                        $this->SetAligns(array("C","C","R","R","R","R","C","R","C","R","C","R","R","R","R"));        
                        $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
                        $this->Row(array('CODIGO PRESUPUESTARIO','DENOMINACION','PRESUPUESTADO','MODIFICADO','TOTAL APROBADO','DEVENGADO','%','LIQUIDADO','%','RECAUDADO','%'),0,0);
                        $this->Line(10, 50, 350, 50);    
                        $this->Ln(2);
                    }

                    /*$cond_tipo = array( 1);
                    if (in_array( $tipo, $cond_tipo)){

                        $total_ini = $total_ini + $total_presupuestado;
                        $total_mod = $total_mod + $total_modificado;
                        $total_dev = $total_dev + $total_devengado;
                        $total_liq = $total_liq + $total_liquidado;
                        $total_rec = $total_rec + $total_recaudado;

                        continue;
                    }*/

                    $this->nivel_cuatro = $this->partidas_cuatro( $campo_tres['nu_pa'], $campo_tres['nu_ge'], $campo_tres['nu_anio']);             
             
                    foreach($this->nivel_cuatro as $key => $campo_cuatro){

                        $this->mo_inicial = $this->mo_cuatro($campo_cuatro['nu_pa'], $campo_cuatro['nu_ge'], $campo_cuatro['nu_es'], 12, $campo_cuatro['nu_anio'], $_GET['fe_fin']);
                        $this->mo_actualizado = $this->mo_cuatro($campo_cuatro['nu_pa'], $campo_cuatro['nu_ge'], $campo_cuatro['nu_es'], 7, $campo_cuatro['nu_anio'], $_GET['fe_fin']);
                        $this->mo_devengado = $this->mo_cuatro($campo_cuatro['nu_pa'], $campo_cuatro['nu_ge'], $campo_cuatro['nu_es'], 9, $campo_cuatro['nu_anio'], $_GET['fe_fin']);
                        $this->mo_liquidado = $this->mo_cuatro($campo_cuatro['nu_pa'], $campo_cuatro['nu_ge'], $campo_cuatro['nu_es'], 10, $campo_cuatro['nu_anio'], $_GET['fe_fin']);
                        $this->mo_recaudado = $this->mo_cuatro($campo_cuatro['nu_pa'], $campo_cuatro['nu_ge'], $campo_cuatro['nu_es'], 11, $campo_cuatro['nu_anio'], $_GET['fe_fin']);

                        $total_presupuestado = $this->mo_inicial['mo_partida'];
                        $total_modificado = $this->mo_actualizado['mo_partida'];
                        $total_devengado = $this->mo_devengado['mo_partida'];
                        $total_liquidado = $this->mo_liquidado['mo_partida'];
                        $total_recaudado = $this->mo_recaudado['mo_partida'];

                        $total_aprobado = $total_presupuestado + $total_modificado;

                        $total_devengadox100  = (($total_devengado)*100)/$total_aprobado;  
                        $total_causadox100    = (($total_liquidado)*100)/$total_devengado;  
                        $total_pagadox100     = (($total_recaudado)*100)/$total_liquidado;

                        $this->SetFont('Arial','',8);
                        $this->SetWidths(array(35,40,36,40,40,38,20,35,17,32,12));
                        $this->SetAligns(array("L","L","R","R","R","R","C","R","C","R","C")); 
                        $this->Row(array(
                            $campo_cuatro['nu_pa'].'.'.$campo_cuatro['nu_ge'].'.'.$campo_cuatro['nu_es'],
                            utf8_decode($campo_cuatro['tx_descripcion']), 
                            number_format($total_presupuestado, 2, ',','.'), 
                            number_format($total_modificado, 2, ',','.'),
                            number_format($total_aprobado, 2, ',','.'), 
                            number_format($total_devengado, 2, ',','.'), 
                            number_format($total_devengadox100, 2, ',','.'), 
                            number_format($total_liquidado, 2, ',','.'), 
                            number_format($total_causadox100, 2, ',','.'), 
                            number_format($total_recaudado, 2, ',','.'), 
                            number_format($total_pagadox100, 2, ',','.')
                        ),0,0);

                        if($this->getY()>170){
                            $this->AddPage(); 
                            $Y = $this->GetY();  
                            $this->SetY($Y+5);          
                            $this->SetFont('Arial','B',12);  
                            $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
                            $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA DE INGRESO - AÑO FISCAL '.$anio),0,0,'C'); 
            
                            $this->SetY($Y);  
                            $this->SetFont('Arial','',8);   
                            $this->SetWidths(array(100));
                            $this->SetAligns(array("L"));                  
                            $this->SetX(10);  
            
                            $this->Row(array('PERIODO....:  01-01-'.$_GET['co_anio_fiscal'].' A '.$_GET['fe_fin']),0,0);      
                            $this->SetX(10);            
                            $this->Ln(8);       
                            $this->SetFont('Arial','B',9);
                            $this->SetWidths(array(35,40,36,40,40,36,15,36,15,33,15));
                            $this->SetAligns(array("C","C","R","R","R","R","C","R","C","R","C","R","R","R","R"));        
                            $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
                            $this->Row(array('CODIGO PRESUPUESTARIO','DENOMINACION','PRESUPUESTADO','MODIFICADO','TOTAL APROBADO','DEVENGADO','%','LIQUIDADO','%','RECAUDADO','%'),0,0);
                            $this->Line(10, 50, 350, 50);    
                            $this->Ln(2);
                        }

                        $this->nivel_cinco = $this->partidas_cinco($campo_cuatro['nu_pa'], $campo_cuatro['nu_ge'], $campo_cuatro['nu_es'], $campo_cuatro['nu_anio']);             
             
                        foreach($this->nivel_cinco as $key => $campo_cinco){

                            $this->mo_inicial = $this->mo_cinco($campo_cinco['nu_pa'], $campo_cinco['nu_ge'], $campo_cinco['nu_es'], $campo_cinco['nu_se'], 12, $campo_cinco['nu_anio'], $_GET['fe_fin']);
                            $this->mo_actualizado = $this->mo_cinco($campo_cinco['nu_pa'], $campo_cinco['nu_ge'], $campo_cinco['nu_es'], $campo_cinco['nu_se'], 7, $campo_cinco['nu_anio'], $_GET['fe_fin']);
                            $this->mo_devengado = $this->mo_cinco($campo_cinco['nu_pa'], $campo_cinco['nu_ge'], $campo_cinco['nu_es'], $campo_cinco['nu_se'], 9, $campo_cinco['nu_anio'], $_GET['fe_fin']);
                            $this->mo_liquidado = $this->mo_cinco($campo_cinco['nu_pa'], $campo_cinco['nu_ge'], $campo_cinco['nu_es'], $campo_cinco['nu_se'], 10, $campo_cinco['nu_anio'], $_GET['fe_fin']);
                            $this->mo_liquidado = $this->mo_cinco($campo_cinco['nu_pa'], $campo_cinco['nu_ge'], $campo_cinco['nu_es'], $campo_cinco['nu_se'], 11, $campo_cinco['nu_anio'], $_GET['fe_fin']);
                            
                            $total_presupuestado = $this->mo_inicial['mo_partida'];
                            $total_modificado = $this->mo_actualizado['mo_partida'];
                            $total_devengado = $this->mo_devengado['mo_partida'];
                            $total_liquidado = $this->mo_liquidado['mo_partida'];
                            $total_recaudado = $this->mo_recaudado['mo_partida'];

                            $total_aprobado = $total_presupuestado + $total_modificado;

                            $total_devengadox100  = (($total_devengado)*100)/$total_aprobado;  
                            $total_causadox100    = (($total_liquidado)*100)/$total_devengado;  
                            $total_pagadox100     = (($total_recaudado)*100)/$total_liquidado;

                            $this->SetFont('Arial','',8);
                            $this->SetWidths(array(35,40,36,40,40,38,20,35,17,32,12));
                            $this->SetAligns(array("L","L","R","R","R","R","C","R","C","R","C")); 
                            $this->Row(array(
                                $campo_cinco['nu_pa'].'.'.$campo_cinco['nu_ge'].'.'.$campo_cinco['nu_es'].'.'.$campo_cinco['nu_se'],
                                utf8_decode($campo_cinco['tx_descripcion']), 
                                number_format($total_presupuestado, 2, ',','.'), 
                                number_format($total_modificado, 2, ',','.'),
                                number_format($total_aprobado, 2, ',','.'), 
                                number_format($total_devengado, 2, ',','.'), 
                                number_format($total_devengadox100, 2, ',','.'), 
                                number_format($total_liquidado, 2, ',','.'), 
                                number_format($total_causadox100, 2, ',','.'), 
                                number_format($total_recaudado, 2, ',','.'), 
                                number_format($total_pagadox100, 2, ',','.')
                            ),0,0);

                            if($this->getY()>170){
                                $this->AddPage(); 
                                $Y = $this->GetY();  
                                $this->SetY($Y+5);          
                                $this->SetFont('Arial','B',12);  
                                $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
                                $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA DE INGRESO - AÑO FISCAL '.$anio),0,0,'C'); 
                
                                $this->SetY($Y);  
                                $this->SetFont('Arial','',8);   
                                $this->SetWidths(array(100));
                                $this->SetAligns(array("L"));                  
                                $this->SetX(10);  
                
                                $this->Row(array('PERIODO....:  01-01-'.$_GET['co_anio_fiscal'].' A '.$_GET['fe_fin']),0,0);      
                                $this->SetX(10);            
                                $this->Ln(8);       
                                $this->SetFont('Arial','B',9);
                                $this->SetWidths(array(35,40,36,40,40,36,15,36,15,33,15));
                                $this->SetAligns(array("C","C","R","R","R","R","C","R","C","R","C","R","R","R","R"));        
                                $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
                                $this->Row(array('CODIGO PRESUPUESTARIO','DENOMINACION','PRESUPUESTADO','MODIFICADO','TOTAL APROBADO','DEVENGADO','%','LIQUIDADO','%','RECAUDADO','%'),0,0);
                                $this->Line(10, 50, 350, 50);    
                                $this->Ln(2);
                            }


                            $this->nivel_seis = $this->partidas_seis($campo_cinco['nu_pa'], $campo_cinco['nu_ge'], $campo_cinco['nu_es'], $campo_cinco['nu_se'], $campo_cinco['nu_anio']);             
             
                            foreach($this->nivel_seis as $key => $campo_seis){

                                $this->mo_inicial = $this->mo_seis($campo_seis['nu_pa'], $campo_seis['nu_ge'], $campo_seis['nu_es'], $campo_seis['nu_se'], $campo_seis['nu_sse'], 12, $campo_seis['nu_anio'], $_GET['fe_fin']);
                                $this->mo_actualizado = $this->mo_seis($campo_seis['nu_pa'], $campo_seis['nu_ge'], $campo_seis['nu_es'], $campo_seis['nu_se'], $campo_seis['nu_sse'], 7, $campo_seis['nu_anio'], $_GET['fe_fin']);
                                $this->mo_devengado = $this->mo_seis($campo_seis['nu_pa'], $campo_seis['nu_ge'], $campo_seis['nu_es'], $campo_seis['nu_se'], $campo_seis['nu_sse'], 9, $campo_seis['nu_anio'], $_GET['fe_fin']);
                                $this->mo_liquidado = $this->mo_seis($campo_seis['nu_pa'], $campo_seis['nu_ge'], $campo_seis['nu_es'], $campo_seis['nu_se'], $campo_seis['nu_sse'], 10, $campo_seis['nu_anio'], $_GET['fe_fin']);
                                $this->mo_recaudado = $this->mo_seis($campo_seis['nu_pa'], $campo_seis['nu_ge'], $campo_seis['nu_es'], $campo_seis['nu_se'], $campo_seis['nu_sse'], 11, $campo_seis['nu_anio'], $_GET['fe_fin']);

                                $total_presupuestado = $this->mo_inicial['mo_partida'];
                                $total_modificado = $this->mo_actualizado['mo_partida'];
                                $total_devengado = $this->mo_devengado['mo_partida'];
                                $total_liquidado = $this->mo_liquidado['mo_partida'];
                                $total_recaudado = $this->mo_recaudado['mo_partida'];

                                $total_aprobado = $total_presupuestado + $total_modificado;

                                $total_devengadox100  = (($total_devengado)*100)/$total_aprobado;  
                                $total_causadox100    = (($total_liquidado)*100)/$total_devengado;  
                                $total_pagadox100     = (($total_recaudado)*100)/$total_liquidado; 

                                $this->SetFont('Arial','',8);
                                $this->SetWidths(array(35,40,36,40,40,38,20,35,17,32,12));
                                $this->SetAligns(array("L","L","R","R","R","R","C","R","C","R","C"));  
                                $this->Row(array(
                                    $campo_seis['nu_pa'].'.'.$campo_seis['nu_ge'].'.'.$campo_seis['nu_es'].'.'.$campo_seis['nu_se'].'.'.$campo_seis['nu_sse'],
                                    utf8_decode($campo_seis['tx_descripcion']), 
                                    number_format($total_presupuestado, 2, ',','.'), 
                                    number_format($total_modificado, 2, ',','.'),
                                    number_format($total_aprobado, 2, ',','.'), 
                                    number_format($total_devengado, 2, ',','.'), 
                                    number_format($total_devengadox100, 2, ',','.'), 
                                    number_format($total_liquidado, 2, ',','.'), 
                                    number_format($total_causadox100, 2, ',','.'), 
                                    number_format($total_recaudado, 2, ',','.'), 
                                    number_format($total_pagadox100, 2, ',','.')
                                ),0,0);

                                if($this->getY()>170){
                                    $this->AddPage(); 
                                    $Y = $this->GetY();  
                                    $this->SetY($Y+5);          
                                    $this->SetFont('Arial','B',12);  
                                    $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
                                    $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA DE INGRESO - AÑO FISCAL '.$anio),0,0,'C'); 
                    
                                    $this->SetY($Y);  
                                    $this->SetFont('Arial','',8);   
                                    $this->SetWidths(array(100));
                                    $this->SetAligns(array("L"));                  
                                    $this->SetX(10);  
                    
                                    $this->Row(array('PERIODO....:  01-01-'.$_GET['co_anio_fiscal'].' A '.$_GET['fe_fin']),0,0);       
                                    $this->SetX(10);            
                                    $this->Ln(8);       
                                    $this->SetFont('Arial','B',9);
                                    $this->SetWidths(array(35,40,36,40,40,36,15,36,15,33,15));
                                    $this->SetAligns(array("C","C","R","R","R","R","C","R","C","R","C","R","R","R","R"));        
                                    $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
                                    $this->Row(array('CODIGO PRESUPUESTARIO','DENOMINACION','PRESUPUESTADO','MODIFICADO','TOTAL APROBADO','DEVENGADO','%','LIQUIDADO','%','RECAUDADO','%'),0,0);
                                    $this->Line(10, 50, 350, 50);    
                                    $this->Ln(2);
                                }

                                $total_ini = $total_ini + $total_presupuestado;
                                $total_mod = $total_mod + $total_modificado;
                                $total_dev = $total_dev + $total_devengado;
                                $total_liq = $total_liq + $total_liquidado;
                                $total_rec = $total_rec + $total_recaudado;

                            }

                        }


                    }

                }

            }

        }
    }else{

        $this->nivel_seis = $this->partidas_seis_mov($_GET['co_anio_fiscal']);             
             
        foreach($this->nivel_seis as $key => $campo_seis){

            $this->mo_inicial = $this->mo_seis($campo_seis['nu_pa'], $campo_seis['nu_ge'], $campo_seis['nu_es'], $campo_seis['nu_se'], $campo_seis['nu_sse'], 12, $campo_seis['nu_anio'], $_GET['fe_fin']);
            $this->mo_actualizado = $this->mo_seis($campo_seis['nu_pa'], $campo_seis['nu_ge'], $campo_seis['nu_es'], $campo_seis['nu_se'], $campo_seis['nu_sse'], 7, $campo_seis['nu_anio'], $_GET['fe_fin']);
            $this->mo_devengado = $this->mo_seis($campo_seis['nu_pa'], $campo_seis['nu_ge'], $campo_seis['nu_es'], $campo_seis['nu_se'], $campo_seis['nu_sse'], 9, $campo_seis['nu_anio'], $_GET['fe_fin']);
            $this->mo_liquidado = $this->mo_seis($campo_seis['nu_pa'], $campo_seis['nu_ge'], $campo_seis['nu_es'], $campo_seis['nu_se'], $campo_seis['nu_sse'], 10, $campo_seis['nu_anio'], $_GET['fe_fin']);
            $this->mo_recaudado = $this->mo_seis($campo_seis['nu_pa'], $campo_seis['nu_ge'], $campo_seis['nu_es'], $campo_seis['nu_se'], $campo_seis['nu_sse'], 11, $campo_seis['nu_anio'], $_GET['fe_fin']);

            $total_presupuestado = $this->mo_inicial['mo_partida'];
            $total_modificado = $this->mo_actualizado['mo_partida'];
            $total_devengado = $this->mo_devengado['mo_partida'];
            $total_liquidado = $this->mo_liquidado['mo_partida'];
            $total_recaudado = $this->mo_recaudado['mo_partida'];

            $total_aprobado = $total_presupuestado + $total_modificado;

            $total_devengadox100  = (($total_devengado)*100)/$total_aprobado;  
            $total_causadox100    = (($total_liquidado)*100)/$total_devengado;  
            $total_pagadox100     = (($total_recaudado)*100)/$total_liquidado; 

            $this->SetFont('Arial','',8);
            $this->SetWidths(array(35,40,36,40,40,38,20,35,17,32,12));
            $this->SetAligns(array("L","L","R","R","R","R","C","R","C","R","C"));  
            $this->Row(array(
                $campo_seis['nu_pa'].'.'.$campo_seis['nu_ge'].'.'.$campo_seis['nu_es'].'.'.$campo_seis['nu_se'].'.'.$campo_seis['nu_sse'],
                utf8_decode($campo_seis['tx_descripcion']), 
                number_format($total_presupuestado, 2, ',','.'), 
                number_format($total_modificado, 2, ',','.'),
                number_format($total_aprobado, 2, ',','.'), 
                number_format($total_devengado, 2, ',','.'), 
                number_format($total_devengadox100, 2, ',','.'), 
                number_format($total_liquidado, 2, ',','.'), 
                number_format($total_causadox100, 2, ',','.'), 
                number_format($total_recaudado, 2, ',','.'), 
                number_format($total_pagadox100, 2, ',','.')
            ),0,0);

            if($this->getY()>170){
                $this->AddPage(); 
                $Y = $this->GetY();  
                $this->SetY($Y+5);          
                $this->SetFont('Arial','B',12);  
                $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y                  
                $this->Cell(0,0,utf8_decode(' EJECUCIÓN PRESUPUESTARIA DE INGRESO - AÑO FISCAL '.$anio),0,0,'C'); 

                $this->SetY($Y);  
                $this->SetFont('Arial','',8);   
                $this->SetWidths(array(100));
                $this->SetAligns(array("L"));                  
                $this->SetX(10);  

                $this->Row(array('PERIODO....:  01-01-'.$_GET['co_anio_fiscal'].' A '.$_GET['fe_fin']),0,0);       
                $this->SetX(10);            
                $this->Ln(8);       
                $this->SetFont('Arial','B',9);
                $this->SetWidths(array(35,40,36,40,40,36,15,36,15,33,15));
                $this->SetAligns(array("C","C","R","R","R","R","C","R","C","R","C","R","R","R","R"));        
                $this->SetX(5); // configura la linea donde comenzara escribir en el eje de y       
                $this->Row(array('CODIGO PRESUPUESTARIO','DENOMINACION','PRESUPUESTADO','MODIFICADO','TOTAL APROBADO','DEVENGADO','%','LIQUIDADO','%','RECAUDADO','%'),0,0);
                $this->Line(10, 50, 350, 50);    
                $this->Ln(2);
            }

            $total_ini = $total_ini + $total_presupuestado;
            $total_mod = $total_mod + $total_modificado;
            $total_dev = $total_dev + $total_devengado;
            $total_liq = $total_liq + $total_liquidado;
            $total_rec = $total_rec + $total_recaudado;

        }

    } 

        $total_aprobado = $total_ini + $total_mod;
        $total_devengadox100  = (($total_dev)*100)/$total_aprobado;  
        $total_causadox100    = (($total_liq)*100)/$total_dev;  
        $total_pagadox100     = (($total_rec)*100)/$total_liq; 

        $this->Ln(2);  
        $this->SetFont('Arial','B',8);
        $this->Row(array(
            '',
            'TOTAL.....',
            number_format($total_ini, 2, ',','.'), 
            number_format($total_mod, 2, ',','.'),
            number_format($total_aprobado, 2, ',','.'), 
            number_format($total_dev, 2, ',','.'), 
            number_format($total_devengadox100, 2, ',','.'), 
            number_format($total_liq, 2, ',','.'), 
            number_format($total_causadox100, 2, ',','.'), 
            number_format($total_rec, 2, ',','.'), 
            number_format($total_pagadox100, 2, ',','.'))
        ,0,0);

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
  
   function partidas_uno($anio, $fe_fin ){ 

    $conex = new ConexionComun(); 

    $sql = "SELECT nu_anio
            FROM tb064_presupuesto_ingreso as tb064
            where tb064.nu_anio = ".$anio." 
            AND tb064.in_movimiento IS true group by 1 order by 1 asc";

    /*$sql = "SELECT tb064.nu_pa, tb091.de_partida as tx_descripcion, 
        sp_mo_ing_pa( 12, ".$anio.", '".$fe_fin."', tb064.nu_pa) as mo_inicial,
        sp_mo_ing_pa( 7, ".$anio.", '".$fe_fin."', tb064.nu_pa) as mo_actualizado,
        sp_mo_ing_pa( 8, ".$anio.", '".$fe_fin."', tb064.nu_pa) as mo_comprometido,
        sp_mo_ing_pa( 1, ".$anio.", '".$fe_fin."', tb064.nu_pa) as mo_causado,
        sp_mo_ing_pa( 2, ".$anio.", '".$fe_fin."', tb064.nu_pa) as mo_pagado
        FROM tb064_presupuesto_ingreso as tb064
        inner join tb091_partida as tb091 on tb064.nu_pa = tb091.nu_partida
        where tb064.nu_anio = ".$anio." group by 1, 2,tb064.nu_anio order by 1 asc";*/     

        //echo var_dump($sql); exit();        
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol; 
	
    }

    function mo_uno($pa, $tipo, $anio, $fe_fin){ 
        
        if($tipo==12){
            
        $sql = "SELECT mo_inicial as mo_partida
        FROM tb064_presupuesto_ingreso as tb064
        WHERE tb064.nu_anio = ".$anio."
        AND tb064.in_movimiento IS true;";            
            
        }else{        

        $sql = "SELECT sum(tb150.mo_movimiento) as mo_partida
        FROM tb150_presupuesto_ingreso_movimiento as tb150
        INNER JOIN tb064_presupuesto_ingreso as tb064 on tb064.co_presupuesto_ingreso = tb150.id_tb064_presupuesto_ingreso
        WHERE tb150.co_tipo_movimiento = ".$tipo."
        AND tb150.nu_anio = ".$anio."
        AND tb064.in_movimiento IS true
        AND tb150.in_anular IS null
        AND cast(tb150.created_at as date) BETWEEN '".$anio."-01-01'::date AND '".$fe_fin."';";
        }
        //echo var_dump($sql); exit();

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];

    }
    
   function partidas_dos($nu_pa, $nu_anio){ 

        $conex = new ConexionComun();

        $sql = "
            SELECT tb064.nu_anio, tb064.nu_pa, tb091.de_partida as tx_descripcion
                FROM tb064_presupuesto_ingreso AS tb064
                INNER JOIN tb091_partida as tb091 ON tb064.nu_pa = tb091.nu_partida
                WHERE nu_anio = ".$nu_anio."
                AND tb064.in_movimiento IS true
            group by 1, 2, 3 order by 1, 2 asc;
        ";

    
        //echo var_dump($sql); exit();        
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol; 
	
    }

    function mo_dos($pa, $tipo, $anio, $fe_fin){ 
        
        if($tipo==12){
            
        $sql = "SELECT mo_inicial as mo_partida
        FROM tb064_presupuesto_ingreso as tb064
        WHERE tb064.nu_pa = '".$pa."'
        AND tb064.nu_anio = ".$anio."
        AND tb064.in_movimiento IS true;";            
            
        }else{        

        $sql = "SELECT sum(mo_movimiento) as mo_partida
        FROM tb150_presupuesto_ingreso_movimiento as tb150
        INNER JOIN tb064_presupuesto_ingreso as tb064 on tb064.co_presupuesto_ingreso = tb150.id_tb064_presupuesto_ingreso
        WHERE tb064.nu_pa = '".$pa."'
        AND tb150.co_tipo_movimiento = ".$tipo."
        AND tb150.nu_anio = ".$anio."
        AND tb064.in_movimiento IS true
        AND tb150.in_anular IS null
        AND cast(tb150.created_at as date) BETWEEN '".$anio."-01-01'::date AND '".$fe_fin."';";
        }
        //echo var_dump($sql); exit();

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];

    }

   function partidas_tres( $nu_pa, $nu_anio){ 
     
        $conex = new ConexionComun();              

        $sql = "SELECT tb064.nu_anio, tb064.nu_pa, tb064.nu_ge, tb091.de_partida as tx_descripcion
                FROM tb064_presupuesto_ingreso AS tb064
                INNER JOIN tb091_partida as tb091 ON tb064.nu_pa::character varying = tb091.nu_partida::character varying
                WHERE tb064.nu_anio = ".$nu_anio."
                AND tb064.nu_pa = '".$nu_pa."'
                AND tb064.in_movimiento IS true
            group by 1, 2, 3, 4 order by 1, 2, 3 asc;
        ";
    
        //echo var_dump($sql); exit();

        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol; 
	
    } 

    function mo_tres($pa, $ge, $tipo, $anio, $fe_fin){
        
        if($tipo==12){
            
        $sql = "SELECT mo_inicial as mo_partida
        FROM tb064_presupuesto_ingreso as tb064
        WHERE tb064.nu_pa = '".$pa."'
        AND tb064.nu_ge = '".$ge."'
        AND tb064.nu_anio = ".$anio."
        AND tb064.in_movimiento IS true;";            
            
        }else{        

        $sql = "SELECT sum(mo_movimiento) as mo_partida
        FROM tb150_presupuesto_ingreso_movimiento as tb150
        INNER JOIN tb064_presupuesto_ingreso as tb064 on tb064.co_presupuesto_ingreso = tb150.id_tb064_presupuesto_ingreso
        WHERE tb064.nu_pa = '".$pa."'
        AND tb064.nu_ge = '".$ge."'
        AND tb150.co_tipo_movimiento = ".$tipo."
        AND tb150.nu_anio = ".$anio."
        AND tb064.in_movimiento IS true
        AND tb150.in_anular IS null
        AND cast(tb150.created_at as date) BETWEEN '".$anio."-01-01'::date AND '".$fe_fin."';";
        }
        //echo var_dump($sql); exit();

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];

    }
    
   function partidas_cuatro( $nu_pa, $nu_ge, $nu_anio){

        $conex = new ConexionComun();  

        $sql = "SELECT tb064.nu_anio, tb064.nu_pa, tb064.nu_ge, tb064.nu_es, tb091.de_partida as tx_descripcion
            FROM tb064_presupuesto_ingreso AS tb064
            INNER JOIN tb091_partida as tb091 ON tb064.nu_pa::character varying||tb064.nu_ge::character varying = tb091.nu_partida::character varying
            WHERE tb064.nu_anio = ".$nu_anio."
            AND tb064.nu_pa = '".$nu_pa."'
            AND tb064.nu_ge = '".$nu_ge."'
            AND tb064.in_movimiento IS true
            group by 1, 2, 3, 4, 5 order by 1, 2, 3, 4 asc;
        ";

        //echo var_dump($sql); exit();

        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol; 
	
    }

    function mo_cuatro($pa, $ge, $es, $tipo, $anio, $fe_fin){ 
        
        if($tipo==12){
            
        $sql = "SELECT mo_inicial as mo_partida
        FROM tb064_presupuesto_ingreso as tb064
        WHERE tb064.nu_pa = '".$pa."'
        AND tb064.nu_ge = '".$ge."'
        AND tb064.nu_es = '".$es."'
        AND tb064.nu_anio = ".$anio."
        AND tb064.in_movimiento IS true;";            
            
        }else{        

        $sql = "SELECT sum(mo_movimiento) as mo_partida
        FROM tb150_presupuesto_ingreso_movimiento as tb150
        INNER JOIN tb064_presupuesto_ingreso as tb064 on tb064.co_presupuesto_ingreso = tb150.id_tb064_presupuesto_ingreso
        WHERE tb064.nu_pa = '".$pa."'
        AND tb064.nu_ge = '".$ge."'
        AND tb064.nu_es = '".$es."'
        AND tb150.co_tipo_movimiento = ".$tipo."
        AND tb150.nu_anio = ".$anio."
        AND tb064.in_movimiento IS true
        AND tb150.in_anular IS null
        AND cast(tb150.created_at as date) BETWEEN '".$anio."-01-01'::date AND '".$fe_fin."';";
        }
        //echo var_dump($sql); exit();

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];

    }
    
   function partidas_cinco($nu_pa, $nu_ge, $nu_es, $nu_anio){   

        $conex = new ConexionComun();     

        $sql = "SELECT tb064.nu_anio, tb064.nu_pa, tb064.nu_ge, tb064.nu_es, tb064.nu_se, tb091.de_partida as tx_descripcion
            FROM tb064_presupuesto_ingreso AS tb064
            INNER JOIN tb091_partida as tb091 ON tb064.nu_pa::character varying||tb064.nu_ge::character varying||tb064.nu_es::character varying = tb091.nu_partida::character varying
            WHERE tb064.nu_anio = ".$nu_anio."
            AND tb064.nu_pa = '".$nu_pa."'
            AND tb064.nu_ge = '".$nu_ge."'
            AND tb064.nu_es = '".$nu_es."'
            AND tb064.in_movimiento IS true
            group by 1, 2, 3, 4, 5, 6 order by 1, 2, 3, 4, 5 asc;
        ";
    
        //echo var_dump($sql); exit();

        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol; 
	
    }

    function mo_cinco($pa, $ge, $es, $se, $tipo, $anio, $fe_fin){
        
        if($tipo==12){
            
        $sql = "SELECT mo_inicial as mo_partida
        FROM tb064_presupuesto_ingreso as tb064
        WHERE tb064.nu_pa = '".$pa."'
        AND tb064.nu_ge = '".$ge."'
        AND tb064.nu_es = '".$es."'
        AND tb064.nu_se = '".$se."'
        AND tb064.nu_anio = ".$anio."
        AND tb064.in_movimiento IS true;";            
            
        }else{        

        $sql = "SELECT sum(mo_movimiento) as mo_partida
        FROM tb150_presupuesto_ingreso_movimiento as tb150
        INNER JOIN tb064_presupuesto_ingreso as tb064 on tb064.co_presupuesto_ingreso = tb150.id_tb064_presupuesto_ingreso
        WHERE tb064.nu_pa = '".$pa."'
        AND tb064.nu_ge = '".$ge."'
        AND tb064.nu_es = '".$es."'
        AND tb064.nu_se = '".$se."'
        AND tb150.co_tipo_movimiento = ".$tipo."
        AND tb150.nu_anio = ".$anio."
        AND tb064.in_movimiento IS true
        AND tb150.in_anular IS null
        AND cast(tb150.created_at as date) BETWEEN '".$anio."-01-01'::date AND '".$fe_fin."';";
        }
        //echo var_dump($sql); exit();

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];

    }

    function partidas_seis($nu_pa, $nu_ge, $nu_es, $nu_se, $nu_anio){   

        $conex = new ConexionComun();     

        $sql = "SELECT tb064.nu_anio, tb064.nu_pa, tb064.nu_ge, tb064.nu_es, tb064.nu_se, tb064.nu_sse, tb064.tx_descripcion as tx_descripcion
            FROM tb064_presupuesto_ingreso AS tb064
            WHERE tb064.nu_anio = ".$nu_anio."
            AND tb064.nu_pa = '".$nu_pa."'
            AND tb064.nu_ge = '".$nu_ge."'
            AND tb064.nu_es = '".$nu_es."'
            AND tb064.nu_se = '".$nu_se."'
            AND tb064.in_movimiento IS true
            group by 1, 2, 3, 4, 5, 6, 7 order by 1, 2, 3, 4, 5, 6 asc;
        ";
    
        //echo var_dump($sql); exit();

        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol; 
	
    }

    function mo_seis($pa, $ge, $es, $se, $sse, $tipo, $anio, $fe_fin){
        
        if($tipo==12){
            
        $sql = "SELECT mo_inicial as mo_partida
        FROM tb064_presupuesto_ingreso as tb064
        WHERE tb064.nu_pa = '".$pa."'
        AND tb064.nu_ge = '".$ge."'
        AND tb064.nu_es = '".$es."'
        AND tb064.nu_se = '".$se."'
        AND tb064.nu_sse = '".$sse."'
        AND tb064.nu_anio = ".$anio."
        AND tb064.in_movimiento IS true;";            
            
        }else{

        $sql = "SELECT sum(mo_movimiento) as mo_partida
        FROM tb150_presupuesto_ingreso_movimiento as tb150
        INNER JOIN tb064_presupuesto_ingreso as tb064 on tb064.co_presupuesto_ingreso = tb150.id_tb064_presupuesto_ingreso
        WHERE tb064.nu_pa = '".$pa."'
        AND tb064.nu_ge = '".$ge."'
        AND tb064.nu_es = '".$es."'
        AND tb064.nu_se = '".$se."'
        AND tb064.nu_sse = '".$sse."'
        AND tb150.co_tipo_movimiento = ".$tipo."
        AND tb150.nu_anio = ".$anio."
        AND tb064.in_movimiento IS true
        AND tb150.in_anular IS null
        AND cast(tb150.created_at as date) BETWEEN '".$anio."-01-01'::date AND '".$fe_fin."';";
        }
//        echo var_dump($sql); exit();

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];

    }

    function partidas_seis_mov( $nu_anio){   

        $conex = new ConexionComun();     

        $sql = "SELECT tb064.nu_anio, tb064.nu_pa, tb064.nu_ge, tb064.nu_es, tb064.nu_se, tb064.nu_sse, tb064.tx_descripcion as tx_descripcion
            FROM tb064_presupuesto_ingreso AS tb064
            WHERE tb064.nu_anio = ".$nu_anio."
            AND tb064.in_movimiento IS true
            order by 1, 2, 3, 4, 5, 6 asc;
        ";
    
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
