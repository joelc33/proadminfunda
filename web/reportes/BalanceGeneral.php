<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->empresa = $this->getDatosEmpresa(1);

        if(!empty($this->empresa['tx_imagen_izq'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_izq'], $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
        }
        

//        if(!empty($this->empresa['tx_imagen_der'])){
//            $this->Image("imagenes/".$this->empresa['tx_imagen_der'],  $this->empresa['derecha_x'], $this->empresa['derecha_y'], $this->empresa['derecha_w']);
//        }

        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0,0,0);
        $this->SetY(10);
        $this->SetX(10);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        $this->Ln(4);
        $this->SetX(10);
        $this->Cell(0,0,utf8_decode('RIF. G-200005297'),0,0,'C');
        $this->Ln(4);
        $this->SetX(10);
        $this->Cell(0,0,utf8_decode('COORDINACIÓN DE CONTABILIDAD'),0,0,'C');
        $this->Ln(4);
//        $this->Cell(0,0,utf8_decode('San Francisco, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');
        $this->SetFont('Arial','B',10);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));  
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('BALANCE GENERAL'),0,0,'C');                
        $this->Ln(6);
        if($_GET['in_periodo']){
        $this->periodo = $this->getPeriodo();
        if($this->periodo){
        $this->Cell(0,0,utf8_decode('AL PERIODO '.strtoupper(mes($this->periodo['mes'])).' '.$this->periodo['anio']. ' (ABIERTO)'),0,0,'C'); 
        $this->Ln(6);    
        }else{
        $this->Cell(0,0,utf8_decode('AL PERIODO AGOSTO 2018 (ABIERTO)'),0,0,'C'); 
        $this->Ln(6);             
        }
        }else{
        $co_mes = $_GET['co_mes'];
        $nu_anio = $_GET['co_anio_fiscal'];            
        $this->Cell(0,0,utf8_decode('AL PERIODO '.strtoupper(mes($co_mes)).' '.$nu_anio.' (CERRADO)'),0,0,'C'); 
         $this->Ln(6);             
        }


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
     
         
         //************ Cuentas del Tesoro *****************//
         $this->SetFont('Arial','B',8);     
         $this->SetFillColor(201, 199, 199);
         $this->Row(array('CUENTAS DEL TESORO'),1,1); 
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(20,50,30,20,40,40)); 
         $this->SetAligns(array("C","L","R","C","L","R"));              
         $this->SetFont('Arial','B',8);
         $this->Ln(3);
         $this->Row(array(utf8_decode('Nº'),' ACTIVOS','BOLIVARES',utf8_decode('Nº'), 'PASIVOS','BOLIVARES'),0,1);         
         $this->lista_activos = $this->getActivos();
         $sub_actTesoro = 0;
         $sub_pasTesoro  = 0;
         //$this->SetX(10);
         $y = $this->GetY();
          $this->SetAligns(array("C","L","R")); 
         foreach($this->lista_activos as $key => $campo){
             
         if($campo['codigo']<200 && $campo['codigo']!=''){    
             
         $this->Row(array($campo['codigo'],$campo['tx_descripcion'],number_format($campo['saldo_actual'], 2, ',','.')),0,1);         
         $sub_actTesoro = $campo['saldo_actual'] + $sub_actTesoro;
         }
         } 
         $this->lista_pasivos = $this->getPasivos();
//         var_dump($this->lista_pasivos);
//         exit();
         $this->SetY($y);
         $sub_total = 0;
         $codigo = 0;
         foreach($this->lista_pasivos as $key => $campo_pasivo){
         $this->SetX(110);     
         if($campo_pasivo['codigo']<200 && $campo_pasivo['codigo']!=''){
             
         if($campo_pasivo['codigo']==199){
         $codigo = 1;
         $this->SetWidths(array(60,40,60, 40)); 
         $this->SetAligns(array("R","R","R","R")); 
         $this->Row(array('','',' SUB TOTAL ', number_format($sub_total, 2, ',','.')),0,1);     
         }    
         $this->SetWidths(array(20,50,30,20,40,40)); 
         $this->SetAligns(array("C","L","R","C","L","R"));    
         $this->Row(array($campo_pasivo['codigo'],$campo_pasivo['tx_descripcion'],number_format($campo_pasivo['saldo_actual'], 2, ',','.')),0,1);         
         $sub_pasTesoro = $campo_pasivo['saldo_actual'] + $sub_pasTesoro;
         if($campo_pasivo['codigo']!=199){
         $sub_total += $campo_pasivo['saldo_actual'];    
         }
         }
         }
         if($codigo==0){
         $this->Ln(10);
         $this->SetWidths(array(60,40,60, 40)); 
         $this->SetAligns(array("R","R","R","R")); 
         $this->Row(array('','',' SUB TOTAL ', number_format($sub_total, 2, ',','.')),0,1);         
         }           
         $this->Ln(10);
         $this->SetWidths(array(60,40,60, 40)); 
         $this->SetAligns(array("R","R","R","R")); 
         $this->Row(array('TOTAL ',number_format($sub_actTesoro, 2, ',','.'),'TOTAL ', number_format($sub_pasTesoro, 2, ',','.')),0,1);         
                  
          
         //************ Cuentas de Hacienda *****************//
         $this->SetFont('Arial','B',8); 
         $this->SetWidths(array(200));
         $this->SetAligns(array("C")); 
         $this->SetFillColor(201, 199, 199);
         $this->Row(array('CUENTAS DE HACIENDA'),1,1); 
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(20,50,30,20,40,40)); 
         $this->SetAligns(array("C","L","R","C","L","R"));              
         $this->SetFont('Arial','B',8);
         $this->Ln(3);
         $this->Row(array(utf8_decode('Nº'),' ACTIVOS','BOLIVARES',utf8_decode('Nº'), 'PASIVOS','BOLIVARES'),0,1);    
         $sub_actHacienda = 0;
         $sub_pasHacienda  = 0;
         //$this->SetX(10);
         $y = $this->GetY();
          $this->SetAligns(array("C","L","R")); 
         foreach($this->lista_activos as $key => $campo2){
             
         if($campo2['codigo']>=200 && $campo2['codigo']!=''){    
             
         $this->Row(array($campo2['codigo'],$campo2['tx_descripcion'],number_format($campo2['saldo_actual'], 2, ',','.')),0,1);         
         $sub_actHacienda = $campo2['saldo_actual'] + $sub_actHacienda;
         }
         } 
         $this->lista_pasivos = $this->getPasivos();
//         var_dump($this->lista_pasivos);
//         exit();
         $this->SetY($y);    
         foreach($this->lista_pasivos as $key => $campo_pasivo){
         $this->SetX(110);     
         if($campo_pasivo['codigo']>200 && $campo_pasivo['codigo']!=''){    
             
         $this->Row(array($campo_pasivo['codigo'],$campo_pasivo['tx_descripcion'],number_format($campo_pasivo['saldo_actual'], 2, ',','.')),0,1);         
         $sub_pasHacienda = $campo_pasivo['saldo_actual'] + $sub_pasHacienda;
         }
         }
         $this->Ln(20);
         $this->SetWidths(array(60,40,60, 40)); 
         $this->SetAligns(array("R","R","R","R")); 
         //$this->Row(array('TOTAL ',number_format($sub_actHacienda, 2, ',','.'),'TOTAL ', number_format($sub_pasHacienda, 2, ',','.')),0,1);     
         $this->Ln(3); 
        //************ Cuentas de Presupusto *****************//
         $this->SetFont('Arial','B',8); 
         $this->SetWidths(array(200));
         $this->SetAligns(array("C")); 
         $this->SetFillColor(201, 199, 199);
         $this->Row(array('CUENTAS DE PRESUPUESTO'),1,1); 
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(20,50,30,20,40,40)); 
         $this->SetAligns(array("C","L","R","C","L","R"));              
         $this->SetFont('Arial','B',8);
         $this->Ln(3);
         $this->Row(array(utf8_decode('Nº'),' ACTIVOS','BOLIVARES',utf8_decode('Nº'), 'PASIVOS','BOLIVARES'),0,1);     
         $this->lista_presupuesto = $this->getPresuepuestoActivos();
         $sub_actPresupuesto = 0;
         $sub_pasPresupuesto  = 0;
         //$this->SetX(10);
         $y = $this->GetY();
          $this->SetAligns(array("C","L","R")); 
         foreach($this->lista_presupuesto as $key => $campo2){
             
         if($campo2['codigo']>=200 && $campo2['codigo']!=''){    
             
         $this->Row(array($campo2['codigo'],$campo2['tx_descripcion'],number_format($campo2['saldo_actual'], 2, ',','.')),0,1);         
         $sub_actPresupuesto = $campo2['saldo_actual'] + $sub_actPresupuesto;
         }
         } 
         $this->lista_presupuesto_pasivos = $this->getPresuepuestoPasivos();
//         var_dump($this->lista_pasivos);
//         exit();
         $this->SetY($y);    
         foreach($this->lista_presupuesto_pasivos as $key => $campo_pasivo){
         $this->SetX(110);     
             
         $this->Row(array($campo_pasivo['codigo'],$campo_pasivo['tx_descripcion'],number_format($campo_pasivo['saldo_actual'], 2, ',','.')),0,1);         
         $sub_pasPresupuesto = $campo_pasivo['saldo_actual'] + $sub_pasPresupuesto;
         
         }
         $this->Ln(5);
         $this->SetWidths(array(60,40,60, 40)); 
         $this->SetAligns(array("R","R","R","R")); 
         $this->Row(array('TOTAL ',number_format($sub_actHacienda + $sub_actPresupuesto, 2, ',','.'),'TOTAL ', number_format($sub_pasHacienda + $sub_pasPresupuesto, 2, ',','.')),0,1);     
         $this->Ln(5);        
       //************ Cuentas del Orden *****************//
//         $this->SetFont('Arial','B',8); 
//         $this->SetWidths(array(200));
//         $this->SetAligns(array("C")); 
//         $this->SetFillColor(201, 199, 199);
//         $this->Row(array('CUENTAS DE ORDEN'),1,1); 
//         $this->SetFillColor(255, 255, 255);
//         $this->SetWidths(array(70,30,60,40)); 
//         $this->SetAligns(array("C","L","R","C","L","R"));              
//         $this->SetFont('Arial','B',8); 
//         $this->Ln(3);
//         $this->lista_cuentasOrdenDeudoras = $this->getCuentasOrdenDeudoras();
//         $this->lista_cuentasOrdenAcreedoras = $this->getCuentasOrdenAcreedoras();
//        //$this->SetX(10);
//         $y = $this->GetY();
//         $this->SetAligns(array("L","R","L","R")); 
//         $this->SetY($y);    
//          foreach($this->lista_cuentasOrdenDeudoras as $key => $campo2){
//            
//         $saldo_deudora = number_format($campo2['saldo_actual'], 2, ',','.');
//         $tx_deudora = $campo2['tx_descripcion']; 
//         
//         } 
//         foreach($this->lista_cuentasOrdenAcreedoras as $key => $campo){        
//         $this->Row(array($tx_deudora,$saldo_deudora,$campo['tx_descripcion'],number_format($campo['saldo_actual'], 2, ',','.')),0,1);         
//         
//         }
         $this->Ln(5);
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

   
    function getActivos(){
        $conex = new ConexionComun();  
        if($_GET['in_periodo']){

             
          $sql = "select *  from (SELECT  (sum(acu_deb) + sum(mes_deb) + sum(pre_deb)) - (sum(acu_cre) + sum(mes_cre) + sum(pre_cre)) as saldo_actual , codigo,descripcion as tx_descripcion
from tb024_cuenta_contable tb024
left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = case when substring(tb024.nu_cuenta_contable,1,3)::integer = 101 then  substring(tb024.nu_cuenta_contable,1,9) else substring(tb024.nu_cuenta_contable,1,9) end) 
where (tb024.nu_cuenta_contable like '1%') GROUP BY codigo,descripcion) as q1 order by codigo";            
        }else{

    $co_mes = $_GET['co_mes'];
    $nu_anio = $_GET['co_anio_fiscal'];
    
          $sql = "select *  from (SELECT  (sum(acu_debito) + sum(mes_debito)) - (sum(acu_credito) + sum(mes_credito)) as saldo_actual , codigo,descripcion as tx_descripcion
from tb179_resumen_mensual_contable tb179
inner join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb179.co_cuenta_contable)
left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = case when substring(tb024.nu_cuenta_contable,1,3)::integer = 101 then  substring(tb024.nu_cuenta_contable,1,9) else substring(tb024.nu_cuenta_contable,1,9) end) 
where (tb024.nu_cuenta_contable like '1%') and co_mes = $co_mes and nu_anio = $nu_anio and in_cierre is not true GROUP BY codigo,descripcion) as q1 order by codigo";       
         
        }

                        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }
    
        function getPasivos(){

          $conex = new ConexionComun();  
          if($_GET['in_periodo']){
          $sql = "select *  from (SELECT  (sum(acu_deb) + sum(mes_deb) + sum(pre_deb)) - (sum(acu_cre) + sum(mes_cre) + sum(pre_cre)) as saldo_actual , codigo,descripcion as tx_descripcion
from tb024_cuenta_contable tb024
left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = case when substring(tb024.nu_cuenta_contable,1,3)::integer = 101 then  substring(tb024.nu_cuenta_contable,1,9) else substring(tb024.nu_cuenta_contable,1,9) end) 
where (tb024.nu_cuenta_contable like '2%' or tb024.nu_cuenta_contable like '501010000%' or tb024.nu_cuenta_contable like '5010201%' or tb024.nu_cuenta_contable like '6010301%') GROUP BY codigo,descripcion) as q1 order by codigo";
          }else{
    $co_mes = $_GET['co_mes'];
    $nu_anio = $_GET['co_anio_fiscal'];
    
          $sql = "select *  from (SELECT  sum((acu_debito + mes_debito) - (acu_credito + mes_credito)) as saldo_actual , codigo,descripcion as tx_descripcion
        from tb179_resumen_mensual_contable tb179
        inner join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb179.co_cuenta_contable)
        left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = case when substring(tb024.nu_cuenta_contable,1,3)::integer = 101 then  substring(tb024.nu_cuenta_contable,1,9) else substring(tb024.nu_cuenta_contable,1,9) end) 
        where (tb024.nu_cuenta_contable like '2%' or tb024.nu_cuenta_contable like '501010000%' or tb024.nu_cuenta_contable like '5010201%' or tb024.nu_cuenta_contable like '6010301%') 
        and co_mes = $co_mes and nu_anio = $nu_anio and in_cierre is not true GROUP BY codigo,descripcion) as q1 order by codigo";              
          }              
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
    
    function getPeriodo(){

        $sql = "SELECT EXTRACT(YEAR FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE) AS anio,lpad(EXTRACT(MONTH FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE)::text,2,'0') AS mes from 
tb180_maestro_contable order by co_maestro_contable desc limit 1";

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];
  
    }    
    
    function getDatosEmpresa( $codigo){

        $sql = "SELECT co_empresa, nb_empresa, co_estado, co_municipio, tx_rif, tx_nit, 
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
