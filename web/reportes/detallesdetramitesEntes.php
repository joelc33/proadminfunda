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
         $this->Cell(0,0,utf8_decode('Cod. Reporte: SCL0002'),0,0,'R');
	 $this->Ln(6);
         $this->Cell(0,0,utf8_decode('ESTATUS DE TRAMITES POR ENTIDADES'),0,0,'C');
         $this->Ln(6);
         $this->SetY($this->getY()*1);
         $this->SetFont('Arial','B',5);
	 $this->SetFillColor(220, 220, 220);
         $this->SetWidths(array(10,20,25,70,15,70,25,15,15,15,15,15,17,15));
         $this->SetAligns(array("C","C","C","L","C","L","C","C","L","L","L","L","L","L"));
         $this->Row(array(utf8_decode('ITEMS'),utf8_decode('NRO. SOLICITUD'),utf8_decode('CODIGO'),utf8_decode('TIPO DE SOLICITUD'),utf8_decode('RIF/CEDULA'),utf8_decode('NOMBRE O RAZON SOCIAL'),utf8_decode('PARROQUIA'),utf8_decode('INSTITUTO'),utf8_decode('ESTATUS')),1,1);

	 $this->v_tramite = $this->tramite();
	 //echo $this->v_tramite['tx_tipo_solicitud']; exit;
	 foreach($this->v_tramite as $key => $campo){
         $canti++;
        $this->SetFillColor(255,255,255);
         $this->SetFont('Arial','',5);
         $this->SetWidths(array(10,20,25,70,15,70,25,15,15,15,15,15,17,15));
         $this->SetAligns(array("C","C","C","L","C","L","C","C","L","L","L","L","L","L"));
         $this->Row(array($canti,utf8_decode($campo['co_solicitud']),utf8_decode($campo['tx_serial_sicsum']),utf8_decode($campo['tx_tipo_solicitud']),utf8_decode($campo['cedula_rif']),utf8_decode($campo['contribuyente']),utf8_decode($campo['tx_parroquia']),utf8_decode($campo['tx_instituto']),utf8_decode($campo['nb_descripcion'])));
	    if($this->getY()>190){
		       $this->addPage();
         $this->Ln(2);
         $this->SetY($this->getY()*1.5);
         $this->SetFont('Arial','B',5);
	 $this->SetFillColor(220, 220, 220);
         $this->SetWidths(array(10,20,25,70,15,70,25,15,15,15,15,15,17,15));
         $this->SetAligns(array("C","C","C","L","C","L","C","C","L","L","L","L","L","L"));
         $this->Row(array(utf8_decode('ITEMS'),utf8_decode('NRO. SOLICITUD'),utf8_decode('CODIGO'),utf8_decode('TIPO DE SOLICITUD'),utf8_decode('RIF/CEDULA'),utf8_decode('NOMBRE O RAZON SOCIAL'),utf8_decode('PARROQUIA'),utf8_decode('INSTITUTO'),utf8_decode('ESTATUS')),1,1);
                       
	    }
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

// fechas, co_instituto, co_estatus, co_tipo_solicitud
   
    function tramite(){

          $conex = new ConexionComun();

          $condicion = '';
	if($_GET['co_estatus']==1)
	{
	  if ($condicion=='') $condicion = " in_actual=true and ";
	  else $condicion.= " in_actual=true and ";
	}

	if($_GET['co_estatus']==3)
	{
	  if ($condicion=='') $condicion = " in_actual=true and ";
	  else $condicion.= "  in_actual=true and ";
	}

          $consulta = '';
            if($_GET['co_parroquia']!='')
                $consulta.= 'co_parroquia ='.$_GET['co_parroquia']." and ";
            
           if($_GET['co_instituto']!='')
                $consulta.= 'co_instituto='.$_GET['co_instituto']." and ";
            
            if($_GET['co_tipo_solicitud']!='')
                $consulta.= 'co_tipo_solicitud='.$_GET['co_tipo_solicitud']." and ";
            
            if($_GET['fe_desde']!='')
                $consulta.= "fecha_actualizacion >= '".$_GET['fe_desde']."' and ";
            
             if($_GET['fe_hasta']!='')
                $consulta.= "fecha_actualizacion <= '".$_GET['fe_hasta']."' and ";
            
            if($_GET['co_solicitud']!='')
                $consulta.= "co_solicitud =".$_GET['co_solicitud']." and ";

            if($_GET['co_estatus']!='')
                $consulta.= "co_estatus_ruta in (".$_GET['co_estatus'].") and ";
            
            $consulta.=" ".$condicion." tx_tipo_tramite = 'E' and ";

  $sql = "select * from vista_solicitud where ".$consulta." co_solicitud=co_solicitud ";
    //echo $sql; exit;
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
