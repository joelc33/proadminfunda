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
//	$this->Cell(0,0,utf8_decode('www.ciudaddeprogreso.org.ve / www.sedebat.com'),0,0,'C');
        
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
         $this->Cell(0,0,utf8_decode('Cod. Reporte: SRV0004'),0,0,'R');
	 $this->Ln(2);
	 $this->Ln(4);
         $this->Cell(0,0,utf8_decode('REPORTE DE ESTADO DE TRAMITES'),0,0,'C');
         $this->datos = $this->getSolicitudes();

         
        $this->setY(53);
         
        $this->SetWidths(array(200));
        $this->SetFillColor(201, 199, 199);
       

         $this->SetWidths(array(70,50,20,20,20,20));
        $this->Row(array(utf8_decode('Tipo de Solicitud'),utf8_decode('Instituto'),utf8_decode('Cantidad'),utf8_decode('Pendientes'),utf8_decode('Aprobados'),utf8_decode('Entregados')),1,1);

            $cant=0;
            $cant_pendiente=0;
            $cant_aprobado=0;
            $cant_entregado=0;
       foreach($this->datos as $key => $campo){
            $this->SetFillColor(255,255,255);

            $this->SetAligns(array("L","L","R","R","R","R"));
            $this->Row(array(utf8_decode($campo['tx_tipo_solicitud']),utf8_decode($campo['tx_instituto']),utf8_decode($campo['cant']),utf8_decode($campo['cant_pendiente']),utf8_decode($campo['cant_aprobado']),utf8_decode($campo['cant_entregado'])));

            $cant+=$campo['cant'];
            $cant_pendiente+= $campo['cant_pendiente'];
            $cant_aprobado+= $campo['cant_aprobado'];
            $cant_entregado+= $campo['cant_entregado'];
        }

        $this->SetAligns(array("L","R","R","R","R"));
        $this->setX(80);
         $this->SetWidths(array(50,20,20,20,20));
       // $this->Row(array(utf8_decode("Total"),$cant,$cant_pendiente,$cant_aprobado,$cant_entregado));


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

          $sql = "select * from (select t15.co_tipo_solicitud,tx_tipo_solicitud,tx_instituto,
                        (select count(*) from t15_solicitud 
                        where fecha_recepcion >= '".$_GET['fe_desde']."' and fecha_recepcion <= '".$_GET['fe_hasta']."' and co_tipo_solicitud = t15.co_tipo_solicitud) as cant,
                    (select count(*) from t15_solicitud 
                        where fecha_recepcion >= '".$_GET['fe_desde']."' and fecha_recepcion <= '".$_GET['fe_hasta']."' and co_tipo_solicitud = t15.co_tipo_solicitud and co_estatus=1) as cant_pendiente,
                        (select count(*) from t15_solicitud 
                        where fecha_recepcion >= '".$_GET['fe_desde']."' and fecha_recepcion <= '".$_GET['fe_hasta']."' and co_tipo_solicitud = t15.co_tipo_solicitud and co_estatus=5) as cant_aprobado,
                        (select count(*) from t15_solicitud 
                        where fecha_recepcion >= '".$_GET['fe_desde']."' and fecha_recepcion <= '".$_GET['fe_hasta']."' and co_tipo_solicitud = t15.co_tipo_solicitud and co_estatus=4) as cant_entregado
                from t15_solicitud t15 join t09_tipo_solicitud t09 on (t15.co_tipo_solicitud = t09.co_tipo_solicitud)
                    join t05_instituto t05 on (t05.co_instituto = t09.co_instituto)
                where fecha_recepcion >= '".$_GET['fe_desde']."' and fecha_recepcion <= '".$_GET['fe_hasta']."'
                group by tx_tipo_solicitud,tx_instituto,t15.co_tipo_solicitud) as tabla order by cant desc";

       //   echo $sql; exit();
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
