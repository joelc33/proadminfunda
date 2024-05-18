<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $array_factura;
    public $array_factura_banco;
    function Header() {


        encabezado_estado_2($this,$h='v');
       

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

         $this->Ln(6);
         $this->Cell(0,0,utf8_decode('Fecha de Impresión: '.date("d-m-Y")),0,0,'R');
         $this->Ln(4);
         $this->Cell(0,0,utf8_decode('Cod. Reporte: SCN0001'),0,0,'R');
         $this->Ln(6);
         $this->Cell(0,0,utf8_decode('ESTATUS DE TRAMITES POR FECHA SOLICITUD'),0,0,'C');
         $this->Ln(6);
         $this->SetY($this->getY()*1);
         $this->SetFont('Arial','B',5);
	 $this->SetFillColor(220, 220, 220);
         $this->SetWidths(array(10,70,15,15,15,15,15,15,15,15,15,15,17,15));
         $this->SetAligns(array("C","L","L","L","L","L","L","L","L","L","L","L","L","L"));
         $this->Row(array(utf8_decode('ITEMS'),utf8_decode('TRAMITE'),utf8_decode('VENTANILLA'),utf8_decode('INSPECCION'),utf8_decode('BOMBEROS'),utf8_decode('SINDICATURA'),utf8_decode('GEOMATICA'),utf8_decode('IMPGAS'),utf8_decode('IMASUR'),utf8_decode('INVITRA'),utf8_decode('SEDEBAT'),utf8_decode('DIR. SICSUM'),utf8_decode('RECAUDACION'),utf8_decode('TOTAL')),1,1);

	 $this->v_tramite = $this->tramite();
	 //echo $this->v_tramite['tx_tipo_solicitud']; exit;
	 foreach($this->v_tramite as $key => $campo){
         $canti++;
         $cant_ventanilla = $cant_ventanilla + $campo['ventanilla'];
         $cant_inspeccion = $cant_inspeccion + $campo['inspeccion'];
         $cant_bomberos = $cant_bomberos + $campo['bomberos'];
         $cant_sindicatura = $cant_sindicatura + $campo['sindicatura'];
         $cant_geomatica = $cant_geomatica + $campo['geomatica'];
         $cant_impgas = $cant_impgas + $campo['impgas'];
         $cant_imasur = $cant_imasur + $campo['imasur'];
         $cant_invitra = $cant_invitra + $campo['invitra'];
         $cant_sedebat = $cant_sedebat + $campo['sedebat'];
         $cant_dsicsum = $cant_dsicsum + $campo['dsicsum'];
         $cant_recaudacion = $cant_recaudacion + $campo['recaudacion'];
         $cant_total = $cant_total + $campo['total'];
         $this->SetFillColor(255,255,255);
         $this->SetFont('Arial','',5);
         $this->SetWidths(array(10,70,15,15,15,15,15,15,15,15,15,15,17,15));
         $this->SetAligns(array("C","L","L","L","L","L","L","L","L","L","L","L","L","L"));
         $this->Row(array($canti,utf8_decode($campo['tx_tipo_solicitud']),utf8_decode($campo['ventanilla']),utf8_decode($campo['inspeccion']),utf8_decode($campo['bomberos']),utf8_decode($campo['sindicatura']),utf8_decode($campo['geomatica']),utf8_decode($campo['impgas']),utf8_decode($campo['imasur']),utf8_decode($campo['invitra']),utf8_decode($campo['sedebat']),utf8_decode($campo['dsicsum']),utf8_decode($campo['recaudacion']),utf8_decode($campo['total'])));
	    if($this->getY()>160){
		       $this->addPage();
		$this->Ln(2);
         	$this->SetY($this->getY()*1.5);
         	$this->SetFont('Arial','B',5);
	 	$this->SetFillColor(220, 220, 220);
         $this->SetWidths(array(10,70,15,15,15,15,15,15,15,15,15,15,17,15));
         $this->SetAligns(array("C","L","L","L","L","L","L","L","L","L","L","L","L","L"));
         	$this->Row(array(utf8_decode('ITEMS'),utf8_decode('TRAMITE'),utf8_decode('VENTANILLA'),utf8_decode('INSPECCION'),utf8_decode('BOMBEROS'),utf8_decode('SINDICATURA'),utf8_decode('GEOMATICA'),utf8_decode('IMPGAS'),utf8_decode('IMASUR'),utf8_decode('INVITRA'),utf8_decode('SEDEBAT'),utf8_decode('DIR. SICSUM'),utf8_decode('RECAUDACION'),utf8_decode('TOTAL')),1,1);
                       
	    }
		}

	          	$this->SetFont('Arial','B',5);
	 	$this->SetFillColor(220, 220, 220);
         $this->SetWidths(array(10,70,15,15,15,15,15,15,15,15,15,15,17,15));
         $this->SetAligns(array("C","R","L","L","L","L","L","L","L","L","L","L","L","L"));
         	$this->Row(array('',utf8_decode('TOTAL'),$cant_ventanilla,$cant_inspeccion,$cant_bomberos,$cant_sindicatura,$cant_geomatica,$cant_impgas,$cant_imasur,$cant_invitra,$cant_sedebat,$cant_dsicsum,$cant_recaudacion,$cant_total),1,1);
   
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

// fechas, co_instituto, co_estatus, co_tipo_solicitud
   
    function tramite(){

        $conex = new ConexionComun();
	$condicion="";
	if($_GET['co_estatus']!='') $condicion = " and co_estatus in (".$_GET['co_estatus'].")";
	


	if($_GET['co_estatus']==1)
	{
	  if ($condicion=='') $condicion = " and in_actual=true";
	  else $condicion.= " and in_actual=true";
	}

	if($_GET['co_estatus']==3)
	{
	  if ($condicion=='') $condicion = " and in_actual=true";
	  else $condicion.= " and in_actual=true";
	}

	if($_GET['co_tipo_solicitud']!='')
	{
	  if ($condicion=='') $condicion = " and co_tipo_solicitud = ".$_GET['co_tipo_solicitud']." ) ";
	  else $condicion.= " and co_tipo_solicitud = ".$_GET['co_tipo_solicitud']."";
	}


	$condicion2="";
	if($_GET['co_instituto']!='') $condicion2 = " and t09.co_instituto = ".$_GET['co_instituto']."";
	

	if($_GET['co_tipo_solicitud']!='')
	{
	  if ($condicion2=='') $condicion2 = " and t09.co_tipo_solicitud = ".$_GET['co_tipo_solicitud']." ) ";
	  else $condicion2.= " and t09.co_tipo_solicitud = ".$_GET['co_tipo_solicitud']."";
	}

          $sql = " select * from (select t09.co_tipo_solicitud, t09.tx_tipo_solicitud,
(
SELECT count(co_ruta)
from vista_tramite
where fecha_recepcion >= '".$_GET['fe_desde']."'::DATE AND fecha_recepcion <= '".$_GET['fe_hasta']."'::DATE
and co_tramite = t09.co_tipo_solicitud and co_instituto=8 and tx_tipo_tramite = 'E'".$condicion."
) as ventanilla,
(
SELECT count(co_ruta)
from vista_tramite
where fecha_recepcion >= '".$_GET['fe_desde']."'::DATE AND fecha_recepcion <= '".$_GET['fe_hasta']."'::DATE
and co_tramite = t09.co_tipo_solicitud and co_instituto=9 and tx_tipo_tramite = 'E'".$condicion."
) as inspeccion,
(
SELECT count(co_ruta)
from vista_tramite
where fecha_recepcion >= '".$_GET['fe_desde']."'::DATE AND fecha_recepcion <= '".$_GET['fe_hasta']."'::DATE
and co_tramite = t09.co_tipo_solicitud and co_instituto=7 and tx_tipo_tramite = 'E'".$condicion."
) as bomberos,
(
SELECT count(co_ruta)
from vista_tramite
where fecha_recepcion >= '".$_GET['fe_desde']."'::DATE AND fecha_recepcion <= '".$_GET['fe_hasta']."'::DATE
and co_tramite = t09.co_tipo_solicitud and co_instituto=2 and tx_tipo_tramite = 'E'".$condicion."
) as sindicatura,
(
SELECT count(co_ruta)
from vista_tramite 
where fecha_recepcion >= '".$_GET['fe_desde']."'::DATE AND fecha_recepcion <= '".$_GET['fe_hasta']."'::DATE
and co_tramite = t09.co_tipo_solicitud and co_instituto=1 and tx_tipo_tramite = 'E'".$condicion."
) as geomatica,
(
SELECT count(co_ruta)
from vista_tramite
where fecha_recepcion >= '".$_GET['fe_desde']."'::DATE AND fecha_recepcion <= '".$_GET['fe_hasta']."'::DATE
and co_tramite = t09.co_tipo_solicitud and co_instituto=3 and tx_tipo_tramite = 'E'".$condicion."
) as impgas,
(
SELECT count(co_ruta)
from vista_tramite
where fecha_recepcion >= '".$_GET['fe_desde']."'::DATE AND fecha_recepcion <= '".$_GET['fe_hasta']."'::DATE
and co_tramite = t09.co_tipo_solicitud and co_instituto=4 and tx_tipo_tramite = 'E'".$condicion."
) as imasur,
(
SELECT count(co_ruta)
from vista_tramite
where fecha_recepcion >= '".$_GET['fe_desde']."'::DATE AND fecha_recepcion <= '".$_GET['fe_hasta']."'::DATE
and co_tramite = t09.co_tipo_solicitud and co_instituto=6 and tx_tipo_tramite = 'E'".$condicion."
) as invitra,
(
SELECT count(co_ruta)
from vista_tramite
where fecha_recepcion >= '".$_GET['fe_desde']."'::DATE AND fecha_recepcion <= '".$_GET['fe_hasta']."'::DATE
and co_tramite = t09.co_tipo_solicitud and co_instituto=5 and tx_tipo_tramite = 'E'".$condicion."
) as sedebat,
(
SELECT count(co_ruta)
from vista_tramite
where fecha_recepcion >= '".$_GET['fe_desde']."'::DATE AND fecha_recepcion <= '".$_GET['fe_hasta']."'::DATE
and co_tramite = t09.co_tipo_solicitud and co_instituto=13 and tx_tipo_tramite = 'E'".$condicion."
) as dsicsum,
(
SELECT count(co_ruta)
from vista_tramite
where fecha_recepcion >= '".$_GET['fe_desde']."'::DATE AND fecha_recepcion <= '".$_GET['fe_hasta']."'::DATE
and co_tramite = t09.co_tipo_solicitud and co_instituto=10 and tx_tipo_tramite = 'E'".$condicion."
) as recaudacion,
(
SELECT count(co_ruta)
from vista_tramite
where fecha_recepcion >= '".$_GET['fe_desde']."'::DATE AND fecha_recepcion <= '".$_GET['fe_hasta']."'::DATE
and co_tramite = t09.co_tipo_solicitud and tx_tipo_tramite = 'E'".$condicion."
) as total
from t09_tipo_solicitud  as t09 
where in_ver is true ".$condicion2." group by 1) as tabla order by total desc";
      //  echo $sql; exit;
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
