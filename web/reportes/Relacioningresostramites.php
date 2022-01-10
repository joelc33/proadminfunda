<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $array_factura;
    public $array_factura_banco;
    function Header() {


        encabezado_general_legal($this,$h='v');
       
         $this->Cell(0,0,utf8_decode('Fecha de Impresión: '.date("d-m-Y")),0,0,'R');
         $this->Ln(6);
         $this->Cell(0,0,utf8_decode('Cod. Reporte: SRR0004'),0,0,'R');
	 $this->Ln(6);      

    }

    function Footer() {
	$this->SetFont('Arial','',9);     
	$this->SetY(-20);
	$this->Cell(0,0,utf8_decode(''),0,0,'C');        
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
	 $monto_ingresos_act = 0;

        $this->datos_planilla();


        $this->SetFillColor(77);
        $this->SetTextColor(255);
        $this->SetX(5);
        $this->SetFont('Arial','',9);
        $this->Cell(260,6,utf8_decode('RELACION DE INGRESOS DESDE '.$_GET['fe_inicio'].' AL '.$_GET['fe_fin']),1,1,'C',1);
	$this->SetFillColor(230, 230, 230);
        $this->SetTextColor(0);
        $this->SetX(5);	
                $this->SetFont('Arial','B',9);
                $this->SetAligns(array("C","C","C","C","C"));
                $this->SetWidths(array(15,150,45,50));

  $this->Row(array('Nro.','DESCRIPCION DEL TRAMITE','CANT. CONTRIBUYENTES','CANTIDAD INGRESOS',''));
                $this->SetFont('Arial','B',9);
                $this->SetAligns(array("C","L","C","C","C"));
                $this->SetWidths(array(15,150,45,50));


	 foreach($this->datos_act_econ as $key => $campo){
         $cant_contribuyentes_act++;
         $monto_ingresos_act = $monto_ingresos_act + $campo['monto'];
		}
	$this->SetX(5);	
	$this->Row(array('1','Actividades Economicas',$cant_contribuyentes_act,number_format($monto_ingresos_act, 2, ',','.'),''));


	$cant_contribuyentes_veh = $this->datos_veh_viejo[0]['total'] + $this->datos_veh_nuevo[0]['total'];
	$monto_ingresos_veh = $this->datos_veh_viejo[0]['monto'] + $this->datos_veh_nuevo[0]['monto'];
        $this->SetX(5);	
	$this->Row(array('2','Solvencia Vehicular',$cant_contribuyentes_veh,number_format($monto_ingresos_veh, 2, ',','.'),''));

	$this->SetX(5);	
	$this->Row(array('3','Inmuebles Urbanos',$this->datos_inm[0]['total'],number_format($this->datos_inm[0]['monto'], 2, ',','.'),''));

	$num = 3;
	 foreach($this->datos_ingvar as $key => $campo){
	$monto_ingresos_ingvar = $monto_ingresos_ingvar + $campo['monto'];
	$num++;
        $this->SetX(5);	
	$this->Row(array($num,utf8_decode($campo['tx_tipo_solicitud']),$campo['total'],number_format($campo['monto'], 2, ',','.'),''));

	    if($this->getY()>190){
		       $this->addPage();
         $this->Ln(2);
         $this->SetY($this->getY()*1.5);
         $this->SetFont('Arial','B',5);
	$this->SetFillColor(230, 230, 230);
        $this->SetTextColor(0);
        $this->SetX(5);	
                $this->SetFont('Arial','B',9);
                $this->SetAligns(array("C","C","C","C","C"));
                $this->SetWidths(array(15,150,45,50));

        $this->Row(array('Nro.','DESCRIPCION DEL TRAMITE','CANT. CONTRIBUYENTES','CANTIDAD INGRESOS',''));
                $this->SetFont('Arial','B',9);
                $this->SetAligns(array("C","L","C","C","C"));
                $this->SetWidths(array(15,150,45,50));
                       
	    }

		}

                $this->SetAligns(array("R","C","C","C","C"));
                $this->SetWidths(array(210,50));
    $monto_ingresos_total = $monto_ingresos_act + $monto_ingresos_veh + $this->datos_inm[0]['monto'] + $monto_ingresos_ingvar;
	$this->Ln(5);
	$this->SetX(5);	
	$this->Row(array('Total Ingresos',number_format($monto_ingresos_total, 2, ',','.')));

	 
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
    
        function ArrayPlanilla($array) {
        $this->array_planillas = $array;
    }

    function ArrayFacturaBanco($array) {
        $this->array_factura_banco = $array;
    }


function datos_planilla (){

        $conex = new ConexionComun();

        $condicion='';

        $fe_inicio      = $_GET['fe_inicio'];
        $fe_fin         = $_GET['fe_fin'];

        
        if ($fe_inicio!='')
        {
            $condicion .= " tb057.fe_recaudacion >= '".$fe_inicio."' ";
        }
        if ($fe_fin!='')
        {
            ($condicion!='')?$condicion.= ' and ':'';
            $condicion .= " tb057.fe_recaudacion <= '".$fe_fin."' ";
        }
       
        ($condicion!='')?$condicion = ' where '.$condicion :'';



   
         $sql_act_econ = "select count(*) as total, round(sum(tb057.nu_monto_recaudar),2) as monto,
 tb042.co_contribuyente
 from
tb052_ae_decl_porciones as tb052 
left join tb057_ae_decl_pago as tb057 on (tb057.co_decl_porcion = tb052.co_decl_porcion )
left join tb042_ae_declaracion as tb042 on (tb042.co_declaracion = tb052.co_declaracion) $condicion and tb052.co_status = 6  group by 3";

  
            
         
         $sql_veh_viejo = "select count (*) as total, round(sum(tb026.nu_monto_req),2) as monto from tb026_pago_det_veh as tb026 WHERE tb026.fe_liquidacion >='".$_GET['fe_inicio']."' and tb026.fe_liquidacion <='".$_GET['fe_fin']."'";

          $sql_veh_nuevo = "select count (*) as total, round(sum(t65.nu_monto_req),2) as monto from t65_pago_tramite as t65 WHERE t65.fe_req >='".$_GET['fe_inicio']."' and t65.fe_req <='".$_GET['fe_fin']."' ";

           $sql_inm = "select count (*) as total, round(sum(tb077.mo_pagado),2) as monto  from tb077_recaudacion_inm as tb077,tb074_liq_inmueble as tb074 WHERE tb074.fe_liquidacion >='".$_GET['fe_inicio']."' and tb074.fe_liquidacion <='".$_GET['fe_fin']."' and tb074.co_liq_inmueble = tb077.co_liq_inmueble";

           $sql_ingvar = "select count(*) as total, round(sum(tb079.mo_recaudado),2) as monto, t09.co_tipo_solicitud, t09.tx_tipo_solicitud from tb079_ingvar_declaracion as tb079,tb081_ingvar_recaudacion tb081, t09_tipo_solicitud t09 WHERE tb081.fe_recaudacion >='".$_GET['fe_inicio']."' and tb081.fe_recaudacion <='".$_GET['fe_fin']."' and tb079.co_ingvar_declaracion = tb081.co_ingvar_declaracion and t09.co_tipo_solicitud = tb079.co_ingvar_actividad group by 3,4 order by 2 desc";

        $this->datos_act_econ = $conex->ObtenerFilasBySqlSelect($sql_act_econ);
	$this->datos_veh_viejo = $conex->ObtenerFilasBySqlSelect($sql_veh_viejo);     
	$this->datos_veh_nuevo = $conex->ObtenerFilasBySqlSelect($sql_veh_nuevo); 
	$this->datos_inm = $conex->ObtenerFilasBySqlSelect($sql_inm);
	$this->datos_ingvar = $conex->ObtenerFilasBySqlSelect($sql_ingvar);              

    }





}

$pdf=new PDF('L','mm','letter');
$pdf->SetLeftMargin(2);
$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
