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
//        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');
        $this->SetFont('Arial','B',10);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));  
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('LIBRO MAYOR'),0,0,'C');                
        $this->Ln(6);
        
        list($anio,$mes,$dia) = explode("-", $_GET["fe_inicio"]);
        $fe_inicio = $dia.'/'.$mes.'/'.$anio;
        
        list($anio,$mes,$dia) = explode("-", $_GET["fe_fin"]);
        $fe_fin = $dia.'/'.$mes.'/'.$anio;        
        $this->Cell(0,0,utf8_decode('CORRESPONDIENTE DESDE '.$fe_inicio.' HASTA '.$fe_fin),0,0,'C'); 

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


         $this->lista_anexos = $this->getMovimientos();
         $total_dia_debe = 0;
         $total_dia_haber = 0;
         $co_cuenta_contable = '';
         $saldo = 0;
         
         
         if(count($this->lista_anexos)>0){                       

         foreach($this->lista_anexos as $key => $campo){
             
             
         if($co_cuenta_contable==''){
         
        $this->SetFont('Arial','B',10);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));  
        $this->Ln(6); 
        $this->cuenta = $this->getDatosCuenta($campo['co_cuenta_contable']);
        $this->Cell(0,0,utf8_decode('CUENTA CONTABLE:').' '.utf8_decode($this->cuenta['tx_descripcion']),0,0,'C');   
         
         $this->SetWidths(array(20,20,80,30,40,40,30,30,30)); 
         $this->SetAligns(array("C","C","L","C","L","L","R","R","R"));             
         $this->SetFont('Arial','B',8);    
         $this->SetFillColor(201, 199, 199);
         $this->Ln(6);
         $this->SetX(20);
         $this->Row(array(utf8_decode('Nº SOLICITUD'),utf8_decode('FECHA'),utf8_decode('DESCRIPCIÓN'),utf8_decode('COMPROBANTE'),utf8_decode('CODIGO CONTABLE'),utf8_decode('TIPO'),utf8_decode('DEBE'),utf8_decode('HABER'),utf8_decode('SALDO')),1,1); 
             
         }             
             
         if($co_cuenta_contable<>$campo['co_cuenta_contable'] && $co_cuenta_contable<>''){
         $this->SetWidths(array(230,30,30,30)); 
         $this->SetAligns(array("R","R","R","R"));                 
         $this->SetFont('Arial','B',8);    
         $this->SetFillColor(201, 199, 199);
         $this->SetX(20);
         $this->Row(array(utf8_decode('TOTAL ').utf8_decode($this->cuenta['tx_descripcion']),number_format($total_dia_debe, 2, ',','.'),number_format($total_dia_haber, 2, ',','.'),number_format($saldo, 2, ',','.')),1,1);
         $this->Ln(6);
        $this->SetFont('Arial','B',10);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));  
         
        $this->cuenta = $this->getDatosCuenta($campo['co_cuenta_contable']);
        $this->Cell(0,0,utf8_decode('CUENTA CONTABLE:').' '.utf8_decode($this->cuenta['tx_descripcion']),0,0,'C');    
         
         $this->SetWidths(array(20,20,80,30,40,40,30,30,30)); 
         $this->SetAligns(array("C","C","L","C","L","L","R","R","R"));                
         $this->SetFont('Arial','B',8);    
         $this->SetFillColor(201, 199, 199);
         $this->Ln(6);
         $this->SetX(20);
         $this->Row(array(utf8_decode('Nº SOLICITUD'),utf8_decode('FECHA'),utf8_decode('DESCRIPCIÓN'),utf8_decode('COMPROBANTE'),utf8_decode('CODIGO CONTABLE'),utf8_decode('TIPO'),utf8_decode('DEBE'),utf8_decode('HABER'),utf8_decode('SALDO')),1,1); 
         
             $total_dia_debe =  0;  
             $total_dia_haber =  0;
             $saldo = 0;
             
         }
         
         $this->SetX(20);   
         $this->SetWidths(array(20,20,80,30,40,40,30,30,30)); 
         $this->SetAligns(array("C","C","L","C","L","L","R","R","R"));          
         $this->SetFont('Arial','B',8);    
         $this->SetFillColor(255, 255, 255);                         
         $this->Row(array($campo['co_solicitud'],$campo['fecha'],utf8_decode($campo['tx_descripcion']),utf8_decode($campo['nu_comprobante']),utf8_decode($campo['tx_cuenta']),utf8_decode($campo['tx_tipo_asiento']),number_format($campo['mo_debe'], 2, ',','.'),number_format($campo['mo_haber'], 2, ',','.'),''),0,0);         
         
         if($this->getY()>170){
             $this->AddPage();
         //************ Anexos *****************//
         $this->SetWidths(array(20,20,80,30,40,40,30,30,30)); 
         $this->SetAligns(array("C","C","L","C","L","L","R","R","R"));             
         $this->SetFont('Arial','B',8);       
         $this->SetFillColor(201, 199, 199);
         $this->Ln(6);
         $this->SetX(20);
         $this->Row(array(utf8_decode('Nº SOLICITUD'),utf8_decode('FECHA'),utf8_decode('DESCRIPCIÓN'),utf8_decode('COMPROBANTE'),utf8_decode('CODIGO CONTABLE'),utf8_decode('TIPO'),utf8_decode('DEBE'),utf8_decode('HABER'),utf8_decode('SALDO')),1,1); 


            }
         $total_dia_debe =  $total_dia_debe + $campo['mo_debe'];  
         $total_dia_haber =  $total_dia_haber + $campo['mo_haber'];
         $saldo = $total_dia_debe - $total_dia_haber;
         $co_cuenta_contable =  $campo['co_cuenta_contable'];
         }
         
         $this->SetWidths(array(230,30,30,30)); 
         $this->SetAligns(array("R","R","R","R"));              
         $this->SetFont('Arial','B',8);    
         $this->SetFillColor(201, 199, 199);
         $this->Ln(6);
         $this->SetX(20);
         $this->Row(array(utf8_decode('TOTAL ').utf8_decode($this->cuenta['tx_descripcion']),number_format($total_dia_debe, 2, ',','.'),number_format($total_dia_haber, 2, ',','.'),number_format($saldo, 2, ',','.')),1,1);  
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
   
   
    function getMovimientos(){

            $fe_inicio    = $_GET['fe_inicio'];    
            $fe_fin       = $_GET['fe_fin'];
            $co_anexo_contable       = $_GET['co_anexo_contable'];
            $conex = new ConexionComun();
            
            if($co_anexo_contable){
                $co_anexo_contable = 'and tb190.co_anexo_contable = '.$co_anexo_contable;
            }else{
            $co_anexo_contable = '';   
            }
            
            $sql = "SELECT to_char(tb061.created_at::date,'dd/mm/yyyy') as fecha,
                case when substring(tb024.nu_cuenta_contable,1,1)::integer= 4 then 300 when substring(tb024.nu_cuenta_contable,1,3)::integer= 301 then 301 when substring(tb024.nu_cuenta_contable,1,3)::integer= 302 then 28 else tb190.codigo end as anexo,tb027.tx_tipo_solicitud||' - '||tb026.tx_observacion as tx_descripcion,
                tb133.tx_tipo_asiento,tb061.mo_debe,tb061.mo_haber,tb061.co_solicitud,tb024.tx_cuenta,tb176.nu_comprobante,
                case when substring(tb024.nu_cuenta_contable,1,1)::integer= 4 then 26 when substring(tb024.nu_cuenta_contable,1,3)::integer= 301 then 27 when substring(tb024.nu_cuenta_contable,1,3)::integer= 302 then 28 else tb190.co_anexo_contable end as co_anexo_contable,tb024.co_cuenta_contable
                from tb061_asiento_contable tb061 
                left join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb061.co_cuenta_contable) 
                left join tb190_anexo_contable tb190 on (tb190.nu_cuenta = case when substring(tb024.nu_cuenta_contable,1,3)::integer = 101 then  substring(tb024.nu_cuenta_contable,1,9) else substring(tb024.nu_cuenta_contable,1,7) end) 
                left join tb026_solicitud tb026 on (tb026.co_solicitud = tb061.co_solicitud) 
                left join tb027_tipo_solicitud tb027 on (tb027.co_tipo_solicitud = tb026.co_tipo_solicitud)
                left join tb133_tipo_asiento tb133 on (tb133.co_tipo_asiento = tb061.co_tipo_asiento)
                left join tb176_comprobante_contable tb176 on (tb176.co_comprobante_contable = tb061.nu_comprobante::bigint)
                where tb061.created_at::date >= '".$fe_inicio."' and tb061.created_at::date <= '".$fe_fin."' $co_anexo_contable order by nu_cuenta_contable asc,tb061.created_at::date asc, tb061.co_solicitud asc,tb061.co_tipo_asiento";
                        
//            var_dump($sql);
//            exit();
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
    
    function getDatosCuenta($co_cuenta_contable){

        $sql = "SELECT tx_descripcion
        FROM tb024_cuenta_contable
        WHERE co_cuenta_contable = ".$co_cuenta_contable.";";
        
//                    var_dump($sql);
//                    exit();

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];
  
    }      
}
$pdf=new PDF('L','mm','LEGAL');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
