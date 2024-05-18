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
        $this->Cell(0,0,utf8_decode('Coordinación General de Administración'),0,0,'L');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Coordinación de Presupuesto'),0,0,'L');        
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('[FCPPR055]'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
//        $this->Cell(0,0,utf8_decode('San Francisco, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R'); 
        
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
        $this->Cell(0,0,utf8_decode(' RESUMEN DE ORDENES DE PAGO'),0,0,'C'); 
        $this->Ln(2);          
        $this->SetY($Y);  
        $this->SetFont('courier','',9); 
        $this->SetWidths(array(100));
        $this->SetAligns(array("L")); 
        if ($_GET['co_periodo']==1) $nb_periodo = 'PRIMER TRIMESTRE';
        if ($_GET['co_periodo']==2) $nb_periodo = 'SEGUNDO TRIMESTRE';
        if ($_GET['co_periodo']==3) $nb_periodo = 'TERCER TRIMESTRE';
        if ($_GET['co_periodo']==4) $nb_periodo = 'CUARTO TRIMESTRE';        
        $this->SetX(30);         
        $this->Row(array(utf8_decode('PERIODO....:  ').utf8_decode($nb_periodo)),0,0);   
        $this->SetX(30);          
        $this->Row(array(utf8_decode('TIPO.......:  CONSOLIDADO')),0,0);    

        $this->Ln(12);       
        $this->SetFont('courier','B',12);
        $this->SetWidths(array(85,35,40,70));
        $this->SetAligns(array("C","C","C","C"));       
        $this->SetX(30);
        $this->Row(array('ORDEN DE PAGO','EJERCICIO','CANTIDAD','MONTO'),1,0);                       
        $this->SetAligns(array("L","C","C","R"));                 

         $campo='';
         $totat_cant   = 0;
         $total_monto  = 0;
       
	 $this->lista_ordenes = $this->ordenes();          
         
	 foreach($this->lista_ordenes as $key => $campo){
         
         $this->SetFont('courier','',12);         
         $this->SetAligns(array("L","C","R","R"));
         $this->SetWidths(array(85,35,40,70));
         $this->SetX(30); 
         $this->Row(array($campo['tipo'],$campo['nu_anio'],$campo['cantidad'],number_format($campo['monto'], 2, ',','.')),1,0);
         
         $totat_cant    += $campo['cantidad'];
         $total_monto   += $campo['monto'];  
          
         }
         $this->SetFont('courier','B',12);
         $this->SetWidths(array(120,40,70));
         $this->SetAligns(array("L","R","R"));
         $this->SetX(30); 
         $this->Row(array('TOTAL ORDENES DE PAGO........',$totat_cant,'BS. '.number_format($total_monto, 2, ',','.')),1,0);   

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
    
    function ordenes(){

        list($dia,$mes,$anio) = explode("-", $_GET["fe_inicio"]);
        $fe_inicio = $anio.'-'.$mes.'-'.$dia;
        list($dia,$mes,$anio) = explode("-", $_GET["fe_fin"]);
        $fe_fin = $anio.'-'.$mes.'-'.$dia;
        $co_anio_fiscal = $_GET['co_anio_fiscal'];
            
    $conex = new ConexionComun();     
    $sql = "   (SELECT 3, (case when (tb060.in_anulado) then 'ANULADAS' end) as tipo,
                        tb060.nu_anio,
                        count(distinct co_orden_pago) as cantidad, 
                        sum( distinct mo_total) as monto                            
                FROM tb060_orden_pago as tb060
                WHERE tb060.nu_anio='".$co_anio_fiscal."' and tb060.in_anulado=true
                GROUP BY 1, 2, 3)
                UNION
                (SELECT distinct 1, (case when (tb060.in_anulado=false) then 'APROBADAS SIN CHEQUE' end) as tipo,
                                             tb060.nu_anio,
                                             count(distinct co_orden_pago) as cantidad, 
                                             sum(distinct mo_total) as monto                            
                FROM tb060_orden_pago as tb060
                LEFT JOIN tb026_solicitud as tb026 on tb060.co_solicitud = tb026.co_solicitud
                LEFT JOIN tb062_liquidacion_pago as tb062 on tb060.co_solicitud = tb062.co_solicitud
                LEFT JOIN tb063_pago as tb063 on (tb063.co_liquidacion_pago = tb062.co_liquidacion_pago)
                WHERE tb060.nu_anio='".$co_anio_fiscal."' and tb060.in_anulado=false
                and tb063.co_forma_pago=2
                GROUP BY 1, 2, 3 )
                UNION
                (SELECT distinct 2, (case when (tb060.in_anulado=false) then 'APROBADAS C/CHEQUE' end) as tipo,
                        tb060.nu_anio,
                        count(distinct co_orden_pago) as cantidad, 
                        sum(distinct mo_total) as monto                            
                FROM tb060_orden_pago as tb060
                LEFT JOIN tb026_solicitud as tb026 on tb060.co_solicitud = tb026.co_solicitud
                LEFT JOIN tb062_liquidacion_pago as tb062 on tb060.co_solicitud = tb062.co_solicitud
                LEFT JOIN tb063_pago as tb063 on (tb063.co_liquidacion_pago = tb062.co_liquidacion_pago)
                WHERE tb060.nu_anio='".$co_anio_fiscal."' and tb060.in_anulado=false
                and tb063.co_forma_pago=1
                GROUP BY 1, 2, 3 )      
                ORDER BY 1                     
                   "  ; 
            
        // echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
	
    }  
    

}
$pdf=new PDF('L','mm','letter');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
