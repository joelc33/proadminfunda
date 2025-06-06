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
            $this->SetX(52);
            $this->MultiCell(110,4,utf8_decode($this->empresa['nb_institucion']),0,'C',0); 
            $this->Ln(2);
        }else{
        $this->Ln(4);    
        }
        $this->Cell(0, 0, utf8_decode('RIF. ' . $this->empresa['tx_rif']), 0, 0, 'C');
        $this->Ln(4);
//        $this->Cell(0,0,utf8_decode('San Francisco, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
//        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');



    }

    function Footer() {
	$this->SetFont('Arial','',9);     
	$this->SetY(-20);        
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
     

        $this->SetFont('Arial','B',10);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));  
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('ESTADO DE SITUACIÓN FINANCIERA'),0,0,'C');                
        $this->Ln(4);
        if($_GET['in_periodo']){
        $this->periodo = $this->getPeriodo();
        if($this->periodo){
        $this->Cell(0,0,utf8_decode('AL '.$this->periodo['last_day']. ' DE '.strtoupper(mes($this->periodo['mes'])).' '.$this->periodo['anio']. ' (ABIERTO)'),0,0,'C');   
        }
        }else{
        
        $co_mes = $_GET['co_mes'];
        $nu_anio = $_GET['co_anio_fiscal'];  
        $this->periodo = $this->getPeriodo($co_mes);
        $this->Cell(0,0,utf8_decode('AL '.$this->periodo['dia']. ' DE '.strtoupper(mes($co_mes)).' '.$nu_anio),0,0,'C');            
        }
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('(Cifras expresadas en miles de Bolivares Digitales)'),0,0,'C'); 
        $this->Ln(6);       
        

         $this->SetFont('Arial','B',8);     
         $this->SetFillColor(201, 199, 199);
         $this->Row(array('ACTIVOS'),0,1); 
         $this->Ln(3);
         $this->lista_cuentas = $this->getCuentas(1,2);
         $total = 0;
         foreach($this->lista_cuentas as $key => $cuenta){
             
         $this->SetWidths(array(120)); 
         $this->SetAligns(array("L"));                   
         $this->SetFont('Arial','B',8);     
         $this->SetFillColor(201, 199, 199);    
             
         $this->Row(array($cuenta['tx_descripcion']),0,1); 
         
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(85,30,20,40,40)); 
         $this->SetAligns(array("L","L","R","C","L","R"));              
         $this->SetFont('Arial','B',8);         
      
         $this->lista_activos = $this->getActivos($cuenta['nu_cuenta_contable'],3);


         $y = $this->GetY();
          $this->SetAligns(array("L","R","R")); 
         foreach($this->lista_activos as $key => $campo){ 
           
        if($campo['nu_cuenta_contable']=='10101'){
        $tx_observacion = 'EFECTIVO Y EQUIVALENTE DE EFECTIVO';   
        }else{
        $tx_observacion = $campo['tx_descripcion'];
        }            
             
         $this->montos = $this->getMontos($campo['nu_cuenta_contable']);

         $this->SetX(15);   
         $this->Row(array(utf8_decode($tx_observacion),number_format($this->montos['saldo_actual']<0?$this->montos['saldo_actual']*-1:$this->montos['saldo_actual'], 2, ',','.')),0,1);        
         $total = $this->montos['saldo_actual'] + $total;
         
         
         if($campo['nu_cuenta_contable']=='10101'){

         $this->montos = $this->getMontosFondoTerceros($campo['nu_cuenta_contable']);
         if($this->montos['saldo_actual']!=0){
         $this->SetX(15);   
         $this->Row(array(utf8_decode('FONDOS DE TERCEROS'),number_format($this->montos['saldo_actual']<0?$this->montos['saldo_actual']*-1:$this->montos['saldo_actual'], 2, ',','.')),0,1);        
         $total = $this->montos['saldo_actual'] + $total;
         }             
         }
         
         }
         $this->Ln(3);
    }
    
         $this->SetAligns(array("R","R","R"));
         $this->SetX(15);
         $this->Row(array(utf8_decode('TOTAL ACTIVOS'),number_format($total<0?$total*-1:$total, 2, ',','.')),0,1);    
         $this->Ln(3);
         $this->SetWidths(array(200)); 
         $this->SetAligns(array("C")); 
         $this->SetFont('Arial','B',8);     
         $this->SetFillColor(201, 199, 199);
         $this->Row(array('PASIVO Y PATRIMONIO'),0,1); 
         $this->Ln(3);
         
         $sub_pas  = 0;         
         
         $this->lista_cuentas = $this->getCuentas(2,2);
         foreach($this->lista_cuentas as $key => $cuenta){
             
         $this->SetWidths(array(120)); 
         $this->SetAligns(array("L"));                   
         $this->SetFont('Arial','B',8);     
         $this->SetFillColor(201, 199, 199);    
             
         $this->Row(array($cuenta['tx_descripcion']),0,1); 
         
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(85,30,20,40,40)); 
         $this->SetAligns(array("L","R","R","C","L","R"));              
         $this->SetFont('Arial','B',8);         
      
         $this->lista_activos = $this->getActivos($cuenta['nu_cuenta_contable'],4);


         $y = $this->GetY();
          $this->SetAligns(array("L","R","R")); 
         foreach($this->lista_activos as $key => $campo){ 
             
         $this->montos = $this->getMontos($campo['nu_cuenta_contable']);    
         $this->SetX(15);             
         $this->Row(array(utf8_decode($campo['tx_descripcion']),number_format($this->montos['saldo_actual']<0?$this->montos['saldo_actual']*-1:$this->montos['saldo_actual'], 2, ',','.')),0,1);         
         $sub_pas = $this->montos['saldo_actual'] + $sub_pas;

         }
         
    }
    
         $this->Ln(3);    
         $this->SetAligns(array("R","R","R"));
         $this->SetX(15);
         $this->Row(array(utf8_decode('TOTAL PASIVO'),number_format($sub_pas<0?$sub_pas*-1:$sub_pas, 2, ',','.')),0,1);    
         $this->Ln(3);
         
         $sub_pat  = 0;
         $total_ing  = 0;
         $total_Egr = 0;

         $this->lista_cuentas = $this->getCuentas(5,2);
         foreach($this->lista_cuentas as $key => $cuenta){
             
         $this->SetWidths(array(120)); 
         $this->SetAligns(array("L"));                   
         $this->SetFont('Arial','B',8);     
         $this->SetFillColor(201, 199, 199);    
             
         $this->Row(array($cuenta['tx_descripcion']),0,1); 
         
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(85,30,20,40,40)); 
         $this->SetAligns(array("L","L","R","C","L","R"));              
         $this->SetFont('Arial','B',8);         
      
         $this->lista_activos = $this->getActivos($cuenta['nu_cuenta_contable'],4);


         $y = $this->GetY();
          $this->SetAligns(array("L","R","R")); 
         foreach($this->lista_activos as $key => $campo){
             
         if($campo['nu_cuenta_contable']=='5060000'){

         $this->lista_cuentas = $this->getCuentas(3,2);
         foreach($this->lista_cuentas as $key => $cuenta){

         $this->lista_activos = $this->getActivos($cuenta['nu_cuenta_contable'],4);

         foreach($this->lista_activos as $key => $campoI){ 
            $this->montos = $this->getMontos($campoI['nu_cuenta_contable']);
             $total_ing = $this->montos['saldo_actual'] + $total_ing;

         }             
             
         }
         
         $this->lista_activos = $this->getActivos(4,2);

         foreach($this->lista_activos as $key => $campoE){ 
            $this->montos = $this->getMontos($campoE['nu_cuenta_contable']);
             $total_Egr = $this->montos['saldo_actual'] + $total_Egr;

         }

         
         $this->SetX(15);             
         $this->Row(array(utf8_decode($campo['tx_descripcion']),number_format(($total_ing + $total_Egr)<0?($total_ing + $total_Egr)*-1:($total_ing + $total_Egr), 2, ',','.')),0,1);          
         $sub_pat = ($total_ing + $total_Egr) + $sub_pat;
         
         }else{             
             
         $this->montos = $this->getMontos($campo['nu_cuenta_contable']);    
         $this->SetX(15);             
         $this->Row(array(utf8_decode($campo['tx_descripcion']),number_format($this->montos['saldo_actual']<0?$this->montos['saldo_actual']*-1:$this->montos['saldo_actual'], 2, ',','.')),0,1);
         $sub_pat = $this->montos['saldo_actual'] + $sub_pat;

         }
         }
         
    }

         $this->Ln(3);    
         $this->SetAligns(array("R","R","R"));
         $this->SetX(15);
         $this->Row(array(utf8_decode('TOTAL PATRIMONIO'),number_format($sub_pat<0?$sub_pat*-1:$sub_pat, 2, ',','.')),0,1);    
         $this->Ln(3);
         
         $sub_pasPat = $sub_pas +  $sub_pat;       
         
 
         $this->SetAligns(array("R","R","R"));
         $this->SetX(15);
         $this->Row(array(utf8_decode('TOTAL PASIVO + PATRIMONIO'),number_format($sub_pasPat<0?$sub_pasPat*-1:$sub_pasPat, 2, ',','.')),0,1);     
    
         $this->Ln(10);
         $this->SetWidths(array(200)); 
         $this->SetAligns(array("L")); 
         $this->Row(array('* ANEXOS'),0,1);         
         $this->Row(array('NOTA: VER INFORME DE PREPARACION DEL CONTADOR PUBLICO'),0,1);  
         
         $this->addPage();
         
        $this->SetFont('Arial','B',10);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));  
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('ESTADO DE RENDIMIENTO FINANCIERO'),0,0,'C');                
        $this->Ln(4);
        if($_GET['in_periodo']){
        $this->periodo = $this->getPeriodo();
        if($this->periodo){
        $this->Cell(0,0,utf8_decode('AL '.$this->periodo['last_day']. ' DE '.strtoupper(mes($this->periodo['mes'])).' '.$this->periodo['anio']. ' (ABIERTO)'),0,0,'C'); 
        }
        }else{
        
        $co_mes = $_GET['co_mes'];
        $nu_anio = $_GET['co_anio_fiscal'];  
        $this->periodo = $this->getPeriodo($co_mes);
        $this->Cell(0,0,utf8_decode('AL '.$this->periodo['dia']. ' DE '.strtoupper(mes($co_mes)).' '.$nu_anio),0,0,'C');          
        }         

        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('(Cifras expresadas en miles de Bolivares Digitales)'),0,0,'C'); 
        $this->Ln(6);        
        
         $this->SetWidths(array(200)); 
         $this->SetAligns(array("C")); 
         $this->SetFont('Arial','B',8);     
         $this->SetFillColor(201, 199, 199);
         $this->Row(array('INGRESOS'),0,1); 
         $this->Ln(3); 
         $total = 0;
         $this->lista_cuentas = $this->getCuentas(3,2);
         foreach($this->lista_cuentas as $key => $cuenta){
             
         $this->SetWidths(array(120)); 
         $this->SetAligns(array("L"));                   
         $this->SetFont('Arial','B',8);     
         $this->SetFillColor(201, 199, 199);    
             
         $this->Row(array($cuenta['tx_descripcion']),0,1); 
         
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(100,30)); 
         $this->SetAligns(array("L","R"));              
         $this->SetFont('Arial','B',8);         
      
         $this->lista_activos = $this->getActivos($cuenta['nu_cuenta_contable'],4);
         
         
         $y = $this->GetY();
         $this->SetWidths(array(85,30));
          $this->SetAligns(array("L","R")); 
         foreach($this->lista_activos as $key => $campo){ 
             
         $this->montos = $this->getMontos($campo['nu_cuenta_contable']);    
         $this->SetX(15);   
         $this->Row(array(utf8_decode($campo['tx_descripcion']),number_format($this->montos['saldo_actual']<0?$this->montos['saldo_actual']*-1:$this->montos['saldo_actual'], 2, ',','.')),0,1);         
         $total = $this->montos['saldo_actual'] + $total;

         }        
         
    }
    
         $this->SetAligns(array("R","R","R"));
         $this->SetX(15);
         $total_ingreso = $total;
         $this->Row(array(utf8_decode('TOTAL INGRESOS'),number_format($total<0?$total*-1:$total, 2, ',','.')),0,1);     
    
         $this->SetWidths(array(200)); 
         $this->SetAligns(array("C")); 
         $this->SetFont('Arial','B',8);     
         $this->SetFillColor(201, 199, 199);
         $this->Row(array('EGRESOS'),0,1); 
         $this->Ln(3); 

         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(85,30,20,40,40)); 
         $this->SetAligns(array("L","L","R","C","L","R"));              
         $this->SetFont('Arial','B',8);         
      
         $this->lista_activos = $this->getActivos(4,2);
         $total = 0;
         
         $y = $this->GetY();
          $this->SetAligns(array("L","R","R")); 
         foreach($this->lista_activos as $key => $campo){ 
             
         $this->montos = $this->getMontos($campo['nu_cuenta_contable']);    
         $this->SetX(15);   
         $this->Row(array(utf8_decode($campo['tx_descripcion']),number_format($this->montos['saldo_actual']<0?$this->montos['saldo_actual']*-1:$this->montos['saldo_actual'], 2, ',','.')),0,1);         
         $total = $this->montos['saldo_actual'] + $total;

         }
         $this->SetAligns(array("R","R","R"));
         $this->SetX(15);
         $this->Row(array(utf8_decode('TOTAL EGRESOS'),number_format($total<0?$total*-1:$total, 2, ',','.')),0,1);
         $total_egreso = $total;
         
         $estado_resultado = $total_ingreso + $total_egreso;
         $this->Ln(5);
         $this->SetX(15);
         $this->Row(array(utf8_decode('ESTADO DE RESULTADO'),number_format($estado_resultado<0?$estado_resultado*-1:$estado_resultado, 2, ',','.')),0,1);
    
         $this->Ln(25);
         $this->SetWidths(array(200)); 
         $this->SetAligns(array("L")); 
         $this->Row(array('* ANEXOS'),0,1);         
         $this->Row(array('NOTA: VER INFORME DE PREPARACION DEL CONTADOR PUBLICO'),0,1);     

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

     function getCuentas($nu_cuenta,$nu_nivel){
        $conex = new ConexionComun();  
 
          $sql = "SELECT nu_cuenta_contable,tx_descripcion
                    from tb024_cuenta_contable tb024
                    where (tb024.nu_cuenta_contable like '$nu_cuenta%') and nu_nivel = $nu_nivel 
                    GROUP BY nu_cuenta_contable,tx_descripcion";            


                        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }
    
    function getMontos($nu_cuenta){ // Nivel 1


        
        $conex = new ConexionComun(); 
        
        if($_GET['in_periodo']){        
        
        
                  $sql = "SELECT sum(pre_deb) as pre_deb, sum(pre_cre) as pre_cre,sum(pre_deb)  - sum(pre_cre) as saldo, (sum(acu_deb) + sum(mes_deb)) - (sum(acu_cre) + sum(mes_cre)) as saldo_anterior,
                  (sum(acu_deb) + sum(mes_deb)) - (sum(acu_cre) + sum(mes_cre)) + (sum(pre_deb)  - sum(pre_cre)) as saldo_actual  
                    from tb024_cuenta_contable tb024
                    where (tb024.nu_cuenta_contable like '$nu_cuenta%') and tb024.co_cuenta_contable not in (select co_cuenta_contable from tb011_cuenta_bancaria where co_descripcion_cuenta = 3)";
                  
        }else{

            $co_mes = $_GET['co_mes'];
            $nu_anio = $_GET['co_anio_fiscal'];            

        $sql = "SELECT  (sum(acu_debito) + sum(mes_debito)) - (sum(acu_credito) + sum(mes_credito)) as saldo_actual
        from tb179_resumen_mensual_contable tb179
        inner join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb179.co_cuenta_contable)
        where (tb024.nu_cuenta_contable like '$nu_cuenta%') and tb024.co_cuenta_contable not in (select co_cuenta_contable from tb011_cuenta_bancaria where co_descripcion_cuenta = 3) and co_mes = $co_mes and nu_anio = $nu_anio and in_cierre is not true";                   
            
        }
                  
           //echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];  
	
    }  
    
    function getMontosFondoTerceros($nu_cuenta){ // Nivel 1


        
        $conex = new ConexionComun(); 
        
       if($_GET['in_periodo']){ 
        
        
                  $sql = "SELECT sum(pre_deb) as pre_deb, sum(pre_cre) as pre_cre,sum(pre_deb)  - sum(pre_cre) as saldo, (sum(acu_deb) + sum(mes_deb)) - (sum(acu_cre) + sum(mes_cre)) as saldo_anterior,
                  (sum(acu_deb) + sum(mes_deb)) - (sum(acu_cre) + sum(mes_cre)) + (sum(pre_deb)  - sum(pre_cre)) as saldo_actual  
from tb024_cuenta_contable tb024
where (tb024.nu_cuenta_contable like '$nu_cuenta%') and tb024.co_cuenta_contable in (select co_cuenta_contable from tb011_cuenta_bancaria where co_descripcion_cuenta = 3)";
                  
       }else{
           
            $co_mes = $_GET['co_mes'];
            $nu_anio = $_GET['co_anio_fiscal'];            

        $sql = "SELECT  (sum(acu_debito) + sum(mes_debito)) - (sum(acu_credito) + sum(mes_credito)) as saldo_actual
        from tb179_resumen_mensual_contable tb179
        inner join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb179.co_cuenta_contable)
        where (tb024.nu_cuenta_contable like '$nu_cuenta%') and tb024.co_cuenta_contable in (select co_cuenta_contable from tb011_cuenta_bancaria where co_descripcion_cuenta = 3) and co_mes = $co_mes and nu_anio = $nu_anio and in_cierre is not true";            
           
       }         
           //echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];  
	
    }    
    
    function getActivos($nu_cuenta_contable,$nu_nivel){
        $conex = new ConexionComun();  

             
          $sql = "SELECT tb024.tx_descripcion,nu_cuenta_contable,nu_nivel
               from tb024_cuenta_contable tb024
               left join tb011_cuenta_bancaria tb011 on (tb011.co_cuenta_contable = tb024.co_cuenta_contable)
               where tb024.nu_cuenta_contable like '$nu_cuenta_contable%' and nu_nivel = $nu_nivel
               order by nu_cuenta_contable";            


//          echo var_dump($sql);  exit();
        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }
    
        function getPasivos(){

          $conex = new ConexionComun();  

          $sql = "select *  from (SELECT  (sum(acu_deb) + sum(mes_deb) + sum(pre_deb)) - (sum(acu_cre) + sum(mes_cre) + sum(pre_cre)) as saldo_actual , codigo,descripcion as tx_descripcion
from tb024_cuenta_contable tb024
left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = case when substring(tb024.nu_cuenta_contable,1,3)::integer = 101 then  substring(tb024.nu_cuenta_contable,1,9) else substring(tb024.nu_cuenta_contable,1,9) end) 
where (tb024.nu_cuenta_contable like '2%' or tb024.nu_cuenta_contable like '501010000%' or tb024.nu_cuenta_contable like '5010201%' or tb024.nu_cuenta_contable like '6010301%') GROUP BY codigo,descripcion) as q1 order by codigo";
             
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
	
    }
    
    function getPresuepuestoActivos(){

          $conex = new ConexionComun();
          if($_GET['in_periodo']){
          $sql = "select *  from (SELECT  (sum(acu_deb) + sum(mes_deb) + sum(pre_deb)) - (sum(acu_cre) + sum(mes_cre) + sum(pre_cre)) as saldo_actual , codigo,descripcion as tx_descripcion
from tb024_cuenta_contable tb024
left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = substring(tb024.nu_cuenta_contable,1,1)) 
where (tb024.nu_cuenta_contable like '4%') GROUP BY codigo,descripcion) as q1 order by codigo";
          }else{
    $co_mes = $_GET['co_mes'];
    $nu_anio = $_GET['co_anio_fiscal'];
    
          $sql = "select *  from (SELECT  (sum(acu_debito) + sum(mes_debito)) - (sum(acu_credito) + sum(mes_credito)) as saldo_actual , codigo,descripcion as tx_descripcion
        from tb179_resumen_mensual_contable tb179
        inner join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb179.co_cuenta_contable)
left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = substring(tb024.nu_cuenta_contable,1,1)) 
where (tb024.nu_cuenta_contable like '4%') and co_mes = $co_mes and nu_anio = $nu_anio and in_cierre is not true GROUP BY codigo,descripcion) as q1 order by codigo";              
          }
                        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }
    
        function getPresuepuestoPasivos(){

          $conex = new ConexionComun(); 
          if($_GET['in_periodo']){          
          $sql = "select *  from (SELECT  (sum(acu_deb) + sum(mes_deb) + sum(pre_deb)) - (sum(acu_cre) + sum(mes_cre) + sum(pre_cre)) as saldo_actual , codigo,descripcion as tx_descripcion
from tb024_cuenta_contable tb024
left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = case when substring(tb024.nu_cuenta_contable,1,3)::integer = 302 then substring(tb024.nu_cuenta_contable,1,3)
else substring(tb024.nu_cuenta_contable,1,1) end ) 
where (tb024.nu_cuenta_contable like '3%') GROUP BY codigo,descripcion) as q1 order by codigo";
          }else{
    $co_mes = $_GET['co_mes'];
    $nu_anio = $_GET['co_anio_fiscal'];
    
          $sql = "select *  from (SELECT  sum((acu_debito + mes_debito) - (acu_credito + mes_credito)) as saldo_actual , codigo,descripcion as tx_descripcion
        from tb179_resumen_mensual_contable tb179
inner join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb179.co_cuenta_contable)
left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = case when substring(tb024.nu_cuenta_contable,1,3)::integer = 302 then substring(tb024.nu_cuenta_contable,1,3)
else substring(tb024.nu_cuenta_contable,1,1) end ) 
where (tb024.nu_cuenta_contable like '3%') and co_mes = $co_mes and nu_anio = $nu_anio and in_cierre is not true GROUP BY codigo,descripcion) as q1 order by codigo";              
          }
                        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }
    
    function getCuentasOrdenDeudoras(){

          $conex = new ConexionComun(); 
        if($_GET['in_periodo']){          
          $sql = "select *  from (SELECT  (sum(acu_deb) + sum(mes_deb) + sum(pre_deb)) as saldo_actual , codigo, 'CUENTAS DE ORDEN DEUDORAS' as tx_descripcion
from tb024_cuenta_contable tb024
left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = substring(tb024.nu_cuenta_contable,1,1)) 
where (tb024.nu_cuenta_contable like '7%') GROUP BY codigo,descripcion) as q1 order by codigo";
        }else{
    $co_mes = $_GET['co_mes'];
    $nu_anio = $_GET['co_anio_fiscal'];
    
          $sql = "select *  from (SELECT  (sum(acu_debito) + sum(mes_debito)) - (sum(acu_credito) + sum(mes_credito)) as saldo_actual , codigo,descripcion as tx_descripcion
        from tb179_resumen_mensual_contable tb179
inner join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb179.co_cuenta_contable)
left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = substring(tb024.nu_cuenta_contable,1,1)) 
where (tb024.nu_cuenta_contable like '7%') and co_mes = $co_mes and nu_anio = $nu_anio and in_cierre is not true GROUP BY codigo,descripcion) as q1 order by codigo";            
        }
                        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
    }
    
    function getCuentasOrdenAcreedoras(){

          $conex = new ConexionComun();   
          if($_GET['in_periodo']){
          $sql = "select *  from (SELECT  (sum(acu_cre) + sum(mes_cre) + sum(pre_cre)) as saldo_actual , codigo, 'CUENTAS DE ORDEN ACREEDORAS' as tx_descripcion
from tb024_cuenta_contable tb024
left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = substring(tb024.nu_cuenta_contable,1,1)) 
where (tb024.nu_cuenta_contable like '7%') GROUP BY codigo,descripcion) as q1 order by codigo";
          }else{
    $co_mes = $_GET['co_mes'];
    $nu_anio = $_GET['co_anio_fiscal'];
    
          $sql = "select *  from (SELECT  (sum(acu_debito) + sum(mes_debito)) - (sum(acu_credito) + sum(mes_credito)) as saldo_actual , codigo,descripcion as tx_descripcion
        from tb179_resumen_mensual_contable tb179
inner join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb179.co_cuenta_contable)
left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = substring(tb024.nu_cuenta_contable,1,1)) 
where (tb024.nu_cuenta_contable like '7%') and co_mes = $co_mes and nu_anio = $nu_anio and in_cierre is not true GROUP BY codigo,descripcion) as q1 order by codigo";              
          }
                        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
    }   
    
    function getPeriodo($co_mes){
      
        $where = '';
        if($co_mes){
         
         $where = 'where co_mes ='.$co_mes;   
            
        }

        $sql = "SELECT EXTRACT(YEAR FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE) AS anio,lpad(EXTRACT(MONTH FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE)::text,2,'0') AS mes,
            EXTRACT(DAY FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '2 MONTH - 1 day')::DATE)::text as last_day,
            EXTRACT(DAY FROM fecha_cierre::date)::text  as dia from 
tb180_maestro_contable $where order by co_maestro_contable desc limit 1";

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];
  
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
/*
$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();
$pdf->PrintChapter();

$comm = new ConexionComun();
$ruta = $comm->getRuta();

//rmdir($ruta);
//mkdir($ruta, 0777, true);    

$dir="$ruta".$_GET["codigo"].".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";


$update = "update tb030_ruta set tx_ruta_reporte = '".$dir."' where co_ruta = ".$_GET['codigo']; //$comm->decrypt($_GET["codigo"]);

//echo $update; exit();
$comm->Execute($update);    

$pdf->Output($dir, 'F');
*/

$pdf=new PDF('P','mm','letter');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
