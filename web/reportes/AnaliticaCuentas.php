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

        $this->SetFont('courier','B',12);
        $this->Cell(0,0,utf8_decode($this->empresa['nb_empresa']),0,0,'C');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode($this->empresa['nb_institucion']),0,0,'C');
        $this->Ln(4);
        $this->SetX(10);
        $this->Cell(0,0,utf8_decode('DIVISION DE CONTABILIDAD'),0,0,'C');
        $this->Ln(4);
//        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');
        $this->SetFont('Arial','B',10);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));  
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('RELACIÓN ANALITICA DE CUENTAS'),0,0,'C');                        
             

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

         $this->Ln(1);  
         
         $this->SetFont('Arial','B',8);     
         $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(195,105,35)); 
         $this->SetAligns(array("L","C","R"));
            if($_GET['in_periodo']){
            $this->periodo = $this->getPeriodo();
            if($this->periodo){
            $this->Row(array('','-----------DURANTE EL PERIODO '.strtoupper(mes($this->periodo['mes'])).' '.$this->periodo['anio']. ' (ABIERTO) ---------------',''),0,0);   
            }else{
            $this->Row(array('','--------------DURANTE EL PERIODO AGOSTO 2018 (ABIERTO) -------------------',''),0,0);          
            }
            }else{
            $co_mes = $_GET['co_mes'];
            $nu_anio = $_GET['co_anio_fiscal'];   
            $this->Row(array('','-----------DURANTE EL PERIODO '.strtoupper(mes($co_mes)).' '.$nu_anio. ' (CERRADO) ----------------',''),0,0);            
            } 
         $this->SetFont('Arial','B',8);     
         $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(60,100,35,35,35,35,35)); 
         $this->SetAligns(array("L","L","R","R","R","R","R"));
         $this->Row(array('CUENTA',utf8_decode('DENOMINACIÓN'),'SALDO ANTERIOR','DEBITOS', 'CREDITOS','SALDO','SALDO ACTUAL'),1,1); 
         $this->SetFillColor(255, 255, 255);
         
         $nivel_inicial = $_GET['nivel_inicial']; // Nivel especifico de inicio
         $nivel_final = $_GET['cant_nivel']; // Máximo cantidad de niveles
         
         $this->lista_cuenta = $this->getCuentas($nivel_inicial, $nivel_final);
        if(count($this->lista_cuenta)>0){
         foreach($this->lista_cuenta as $key => $campo){ 
             
                if($this->getY()>170)
                {	
                 $this->addPage();
                 $this->Ln(6);
                 $this->SetFont('Arial','B',8);     
                 $this->SetFillColor(201, 199, 199);
                 $this->SetWidths(array(195,105,35)); 
                 $this->SetAligns(array("L","C","R"));
                if($_GET['in_periodo']){
                $this->periodo = $this->getPeriodo();
                if($this->periodo){
                $this->Row(array('','-----------DURANTE EL PERIODO '.strtoupper(mes($this->periodo['mes'])).' '.$this->periodo['anio']. ' (ABIERTO) ---------------',''),0,0);   
                }else{
                $this->Row(array('','--------------DURANTE EL PERIODO AGOSTO 2018 (ABIERTO) -------------------',''),0,0);          
                }
                }else{
                $co_mes = $_GET['co_mes'];
                $nu_anio = $_GET['co_anio_fiscal'];   
                $this->Row(array('','-----------DURANTE EL PERIODO '.strtoupper(mes($co_mes)).' '.$nu_anio. ' (CERRADO) ----------------',''),0,0);            
                } 
                 $this->SetFont('Arial','B',8);     
                 $this->SetFillColor(201, 199, 199);
                 $this->SetWidths(array(60,100,35,35,35,35,35)); 
                 $this->SetAligns(array("L","L","R","R","R","R","R"));
                 $this->Row(array('CUENTA',utf8_decode('DENOMINACIÓN'),'SALDO ANTERIOR','DEBITOS', 'CREDITOS','SALDO','SALDO ACTUAL'),1,1); 
                 $this->SetFillColor(255, 255, 255);
                } 
                
                 $this->montos = $this->getMontos($campo['nu_cuenta_contable']);
                 $this->SetFont('Arial','B',8);     
                 $this->SetFillColor(201, 199, 199);
                 $this->SetWidths(array(60,100,35,35,35,35,35)); 
                 $this->SetAligns(array("L","L","R","R","R","R","R"));
                 $this->Row(array($campo['tx_cuenta'],$campo['desc_cuenta'],number_format($this->montos['saldo_anterior'], 2, ',','.'),number_format($this->montos['pre_deb'], 2, ',','.'),number_format($this->montos['pre_cre'], 2, ',','.'),number_format($this->montos['saldo'], 2, ',','.'),number_format($this->montos['saldo_actual'], 2, ',','.')),0,0);         

               $this->movimientos = $this->getMovimientos($campo['co_cuenta_contable']); 
               if($this->movimientos){
                   $mo_debe =0;
                   $mo_haber=0;
               foreach($this->movimientos as $key => $campo1){
                   
                if($this->getY()>170)
                {	
                 $this->addPage();
                 $this->Ln(6);
                 $this->SetFont('Arial','B',8);     
                 $this->SetFillColor(201, 199, 199);
                 $this->SetWidths(array(195,105,35)); 
                 $this->SetAligns(array("L","C","R"));
                 $this->Row(array('','--------------DURANTE EL PERIODO AGOSTO 2018-------------------',''),0,0); 
                 $this->SetFont('Arial','B',8);     
                 $this->SetFillColor(201, 199, 199);
                 $this->SetWidths(array(60,100,35,35,35,35,35)); 
                 $this->SetAligns(array("L","L","R","R","R","R","R"));
                 $this->Row(array('CUENTA',utf8_decode('DENOMINACIÓN'),'SALDO ANTERIOR','DEBITOS', 'CREDITOS','SALDO','SALDO ACTUAL'),1,1); 
                 $this->SetFillColor(255, 255, 255);
                }                    
                   
                 $this->SetFont('Arial','B',8);     
                 $this->SetFillColor(201, 199, 199);
                 $this->SetWidths(array(195,35,35,35,35)); 
                 $this->SetAligns(array("L","R","R","R","R"));
                 $this->Row(array(utf8_decode($campo1['descripcion']),number_format($campo1['mo_debe'], 2, ',','.'),number_format($campo1['mo_haber'], 2, ',','.'),'',''),0,0);
                 
                 $mo_debe =  $mo_debe + $campo1['mo_debe'];
                 $mo_haber =  $mo_haber + $campo1['mo_haber'];
                   
               }
                 $this->SetFont('Arial','B',8);     
                 $this->SetFillColor(201, 199, 199);
                 $this->SetWidths(array(195,35,35,35,35)); 
                 $this->SetAligns(array("L","R","R","R","R"));
               $this->Row(array('','____________________','____________________','____________________','____________________'),0,0);
               $this->Row(array('',number_format($mo_debe, 2, ',','.'),number_format($mo_haber, 2, ',','.'),number_format($mo_debe-$mo_haber, 2, ',','.'),number_format($this->montos['saldo_actual'], 2, ',','.')),0,0);                              
               $this->Row(array('','____________________','____________________','____________________','____________________'),0,0);
               }
               }          
               
                }else{
         $this->Ln(50);
         $this->Cell(0,0,utf8_decode('NO EXISTEN REGISTROS CON LOS PARAMETROS ESPECIFICADOS'),0,0,'C');    
         }

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
   
    function getCuentas($nivel_inicial,$nivel_final){ // Nivel 1

         if($_GET['cuenta']){
          
             $cuenta = "and tb024.nu_cuenta_contable like '".$_GET['cuenta']."%'";
             
         }else{
              $cuenta =  "";
         }
        
        
        
        $conex = new ConexionComun(); 
                  $sql = "SELECT tb024.tx_cuenta,tb024.tx_descripcion as desc_cuenta,tb024.nu_cuenta_contable,co_cuenta_contable
from tb024_cuenta_contable tb024
where tb024.nu_nivel between $nivel_inicial and $nivel_final $cuenta group by tb024.tx_cuenta,tb024.tx_descripcion,tb024.nu_cuenta_contable,co_cuenta_contable order by 1 asc";
           //echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    } 
    
    function getMontos($nu_cuenta){ // Nivel 1

        if($_GET['in_periodo']){
        
        $conex = new ConexionComun(); 
                  $sql = "SELECT sum(pre_deb) as pre_deb, sum(pre_cre) as pre_cre,sum(pre_deb)  - sum(pre_cre) as saldo, (sum(acu_deb) + sum(mes_deb)) - (sum(acu_cre) + sum(mes_cre)) as saldo_anterior,
                  (sum(acu_deb) + sum(mes_deb)) - (sum(acu_cre) + sum(mes_cre)) + (sum(pre_deb)  - sum(pre_cre)) as saldo_actual  
from tb024_cuenta_contable tb024
where tb024.nu_cuenta_contable like '$nu_cuenta%'";
           //echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0]; 
        }else{          
    $co_mes = $_GET['co_mes'];
    $nu_anio = $_GET['co_anio_fiscal'];  
    $conex = new ConexionComun(); 
                  $sql = "SELECT sum(mes_debito) as pre_deb, sum(mes_credito) as pre_cre,sum(mes_debito)  - sum(mes_credito) as saldo, (sum(acu_debito)) - (sum(acu_credito)) as saldo_anterior,
                  (sum(acu_debito) - sum(acu_credito)) + (sum(mes_debito)  - sum(mes_credito)) as saldo_actual  
from tb179_resumen_mensual_contable tb179
inner join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb179.co_cuenta_contable)
where tb024.nu_cuenta_contable like '$nu_cuenta%' and co_mes = $co_mes and nu_anio = $nu_anio";
           //echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];             
        }
	 
    }     
    
    function getMovimientos($co_cuenta_contable){
        
        if($_GET['in_periodo']){
        $this->periodo = $this->getPeriodo();           
        $conex = new ConexionComun(); 
                  $sql = "select coalesce(tb061.nu_comprobante::character varying,'')||' - '|| tb133.tx_tipo_asiento ||' - '|| to_char(tb061.created_at::date,'dd/mm/yyyy') ||' - '|| tb027.tx_tipo_solicitud||'('||tb029.tx_estatus||') - '||coalesce(tx_serial,'')||' - '||tb061.co_solicitud as descripcion,
mo_debe,mo_haber,tb061.co_asiento_contable,tb027.tx_tipo_solicitud,to_char(tb061.created_at::date,'dd/mm/yyyy'),tb133.tx_tipo_asiento
 from tb024_cuenta_contable tb024
inner join tb061_asiento_contable tb061 on (tb061.co_cuenta_contable = tb024.co_cuenta_contable) 
inner join tb133_tipo_asiento tb133 on (tb133.co_tipo_asiento = tb061.co_tipo_asiento) 
inner join tb026_solicitud tb026 on (tb026.co_solicitud = tb061.co_solicitud)
inner join tb027_tipo_solicitud tb027 on (tb027.co_tipo_solicitud = tb026.co_tipo_solicitud)
inner join tb029_estatus tb029 on (tb029.co_estatus = tb026.co_estatus)
left join tb060_orden_pago tb060 on (tb060.co_solicitud = tb061.co_solicitud)
where tb061.created_at::date >= '".$this->periodo['fecha_inicio']."' and tb061.created_at::date <= '".$this->periodo['fecha_fin']."' and tb024.co_cuenta_contable =$co_cuenta_contable. order by tb061.co_tipo_asiento,to_char(tb061.created_at::date,'dd/mm/yyyy'),tb061.co_solicitud";
           //echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
        }else{
            
    $this->dias = $this->getDias();            
    
        $conex = new ConexionComun(); 
                  $sql = "select distinct tb061.co_tipo_asiento,tb061.co_solicitud,coalesce(tb061.nu_comprobante::character varying,'')||' - '|| tb133.tx_tipo_asiento ||' - '|| to_char(tb061.created_at::date,'dd/mm/yyyy') ||' - '|| tb027.tx_tipo_solicitud||'('||tb029.tx_estatus||') - '||coalesce(tx_serial,'')||' - '||tb061.co_solicitud as descripcion,
mo_debe,mo_haber,tb061.co_asiento_contable,tb027.tx_tipo_solicitud,to_char(tb061.created_at::date,'dd/mm/yyyy'),tb133.tx_tipo_asiento
 from tb179_resumen_mensual_contable tb179
inner join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb179.co_cuenta_contable)
inner join tb061_asiento_contable tb061 on (tb061.co_cuenta_contable = tb024.co_cuenta_contable) 
inner join tb133_tipo_asiento tb133 on (tb133.co_tipo_asiento = tb061.co_tipo_asiento) 
inner join tb026_solicitud tb026 on (tb026.co_solicitud = tb061.co_solicitud)
inner join tb027_tipo_solicitud tb027 on (tb027.co_tipo_solicitud = tb026.co_tipo_solicitud)
inner join tb029_estatus tb029 on (tb029.co_estatus = tb026.co_estatus)
left join tb060_orden_pago tb060 on (tb060.co_solicitud = tb061.co_solicitud)
where tb061.created_at::date >= '".$this->dias['fecha_inicio']."' and tb061.created_at::date <= '".$this->dias['fecha_fin']."' and tb179.co_cuenta_contable =$co_cuenta_contable  order by tb061.co_tipo_asiento,to_char(tb061.created_at::date,'dd/mm/yyyy'),tb061.co_solicitud";
          // echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;             
        }
	
    }    
    
    function getPeriodo(){

        $sql = "SELECT (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE as fecha_inicio,(date_trunc('MONTH',fecha_cierre::date) + INTERVAL '2 MONTH - 1 day')::DATE as fecha_fin,EXTRACT(YEAR FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE) AS anio,lpad(EXTRACT(MONTH FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE)::text,2,'0') AS mes from 
tb180_maestro_contable order by co_maestro_contable desc limit 1";

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];
  
    }    
    
    function getDias(){
        
    $co_mes = $_GET['co_mes'];
    $nu_anio = $_GET['co_anio_fiscal'];          

        $sql = "SELECT (date_trunc('MONTH','".$nu_anio."-".$co_mes."-01'::date) + INTERVAL '0 MONTH + 0 day')::DATE as fecha_inicio,(date_trunc('MONTH','".$nu_anio."-".$co_mes."-01'::date) + INTERVAL '1 MONTH - 1 day')::DATE as fecha_fin";

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];
  
    }     
    
     function getDatosEmpresa($codigo)
    {

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
        WHERE co_empresa = " . $codigo . ";";

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

$pdf=new PDF('L','mm','LEGAL');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
