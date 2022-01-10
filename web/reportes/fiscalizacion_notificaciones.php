<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $array_factura;
    public $array_factura_banco;
    function Header() {



       

    }

    function Footer() {
	$this->SetFont('Arial','',9);     
	$this->SetY(-20);
//	$this->Cell(0,0,utf8_decode('www.ciudaddeprogreso.org.ve / www.sedebat.com'),0,0,'C'];
        
    }

    function dwawCell($title,$data) {



        $width = 8;
        $this->SetFont('Arial','B',8);
        $y =  $this->getY() * 20;
        $x =  $this->getX();
        $this->SetFillColor(206,230,100);
        $this->MultiCell(175,8,$title,0,1,'L',0);
        $this->SetY($y);
        $this->SetFont('Arial','',6);
        $this->SetFillColor(206,230,172);
        $w=$this->GetStringWidth($title)+3;
        $this->SetX($x+$w);
        $this->SetFillColor(206,230,172);
        $this->MultiCell(175,8,$data,0,1,'J',0);

    }

    function ChapterBody() {


         encabezado_estado($this);
         
	 $this->Ln(26);
         $this->Cell(0,0,utf8_decode('Fecha de Impresión: '.date("d-m-Y")),0,0,'R');
	 $this->Ln(6);
         $this->Cell(0,0,utf8_decode('Cod. Reporte: SRV0005'),0,0,'R');
	 $this->Ln(4);
         $this->Cell(0,0,utf8_decode('REPORTE DE NOTIFICACIONES'),0,0,'C');
	$this->Ln(2);

         $this->datos = $this->getSolicitudes();

         
        $this->setY(50);
         
        $this->SetWidths(array(203));
        $this->SetFillColor(201, 199, 199);
        
        
         $this->SetWidths(array(25,42,43,30,20,22,21));
        $this->Row(array(utf8_decode("Código\nNotificación"),utf8_decode("Nombre\nNotificador"),utf8_decode("Nombre\nContribuyente"),utf8_decode("Cédula\nContribuyente"),utf8_decode("Fecha\nCreación"),utf8_decode("Actividad\nEconómica"),utf8_decode("Medida\nTomada")),1,1);

        
       foreach($this->datos as $key => $campo){
            $this->SetFillColor(255,255,255);

            $this->SetAligns(array("C","L","L","L","L","L","L"));
            $this->Row(array(utf8_decode($campo['co_notificacion']),utf8_decode($campo['tx_usuario']),utf8_decode($campo['tx_razon_social']),utf8_decode($campo['cedula_rif']),utf8_decode(substr($campo['fecha_creacion'],0,10) ),utf8_decode($campo['tx_actividad']),utf8_decode($campo['tx_medida'])));

        }

      


    }

    function ChapterTitle($num,$label) {
        $this->SetFont('Arial','',6);
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

	function enc(){


	}



    function getSolicitudes(){

          $conex = new ConexionComun();

          $consulta = "";
          
          
     
        if($_GET['co_documento']!='')
                $consulta.= ' t14.co_documento ='.$_GET['co_documento']." and ";
        
        if($_GET['cedula_rif']!='')
                $consulta.= " t14.nu_documento ='".$_GET['cedula_rif']."' and ";
        
        if($_GET['co_actividad']!='')
                $consulta.= ' t38.co_actividad ='.$_GET['co_actividad']." and ";
        
        if($_GET['co_medida']!='')
                $consulta.= ' t38.co_medida ='.$_GET['co_medida']." and ";
        
        
        if($_GET['tx_razon_social']!='')
                $consulta.= " upper(contribuyente) like '%".strtoupper($_GET['tx_razon_social'])."%' and ";

        
        if($_GET['tx_usuario']!='')
                $consulta.= " upper(tx_usuario) like '%".strtoupper($_GET['tx_usuario'])."%' and ";

      /* if($_GET['nu_cedula_rif']!='')
                $consulta.= " cedula_rif like '%".strtoupper($_GET['nu_cedula_rif'])."%' and ";
       */
         $fecha_desde =  $_GET['fe_desde'];
         $fecha_hasta = $_GET['fe_hasta'];
         if( ($_GET['fe_desde']!='') && ($_GET['fe_hasta']!='')) 
                $consulta.= " (fecha_creacion between '$fecha_desde' and '$fecha_hasta')  and ";
  
          
          
          $sql = " SELECT 
        
           co_notificacion, 
           t38.co_actividad, 
           t38.co_contribuyente,
           co_fotografia,
           t38.fecha_creacion,
           t38.fecha_actualizacion,
           t38.co_medida,
           t40.tx_descripcion as tx_medida,
           t38.tx_descripcion,
           t39.tx_descripcion as tx_actividad,
           t14.contribuyente as tx_razon_social,
           t14.cedula_rif,
           t14.nu_documento,
           t14.co_documento,
           t01.nb_usuario||' '||t01.ap_usuario as tx_usuario
           from t38_notificacion t38 
           left join t39_actividad t39 
           on(t39.co_actividad=t38.co_actividad)
           left join vista_contribuyente t14 
           on(t14.co_contribuyente = t38.co_contribuyente)
           left join t01_usuario t01 on(t01.co_usuario = t38.co_usuario)
	   left join t40_medida t40 on (t40.co_medida = t38.co_medida)
          
           where $consulta co_notificacion = co_notificacion";
        // echo $sql; exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;

    }

    


}

$pdf=new PDF('P','mm','legal');
$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();
?>
