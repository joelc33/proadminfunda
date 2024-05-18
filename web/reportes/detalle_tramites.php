<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $array_factura;
    public $array_factura_banco;
    function Header() {


	encabezado_general_legal($this);
	


         $this->Ln(6);
         $this->Cell(0,0,utf8_decode('Fecha de Impresión: '.date("d-m-Y")),0,0,'R');
         $this->Ln(4);
         $this->Cell(0,0,utf8_decode('Cod. Reporte: SRV0008'),0,0,'R');
	 $this->Ln(15);
        // $this->Cell(0,0,utf8_decode('Reporte Solicitudes Pendiente Mas DE 30 Dias en el ente '.$_GET["tx_instituto"]),0,0,'C');
         $this->SetY(38);  

       
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
        $this->Cell(0,0,utf8_decode('Fecha de Impresión: '.date("d-m-Y")),0,0,'R');
        $this->SetY($y);
        $this->SetFont('Arial','',6);
        $this->SetFillColor(206,230,172);
        $w=$this->GetStringWidth($title)+3;
        $this->SetX($x+$w);
        $this->SetFillColor(206,230,172);
        $this->MultiCell(175,8,$data,0,1,'J',0);

    }

    function ChapterBody() {


         
         $this->Ln(7);
	
         $this->datos = $this->getSolicitudes();
	 $this->datos_rec = $this->getSolicitudesRec();
		//echo $this->datos['co_contribuyente']; exit;
         $this->Cell(0,0,utf8_decode('Reporte Solicitudes Pendiente Mas DE 30 Dias en el ente '.$_GET["tx_instituto"]),0,0,'C');
        $this->setY(45);
	

      	
	$this->Ln(3);
        $this->SetFillColor(201, 199, 199);
        $this->SetFont('Arial','',8);
        $this->SetAligns(array("C","C","C","C","C","C","C"));
        $this->SetWidths(array(10,15,20,60,40,35,25));
        $this->Row(array(utf8_decode('Nro.'),utf8_decode('Codigo'),utf8_decode('Rif/Cedula'),utf8_decode('Nombre/Razon Social'),utf8_decode('Tipo Solicitud'),utf8_decode('Codigo SICSUM'),utf8_decode('Fecha Ingreso')),1,1);

            $cant=0;
	     $i = 0;
            $cant_pendiente=0;
            $cant_aprobado=0;
            $cant_entregado=0;
	    $total_recaudacion=0;
       foreach($this->datos as $key => $campo){

		$total_recaudacion = $total_recaudacion + $campo['nu_monto_liq'];
		$i = $i + 1 ;
            $this->SetFillColor(255,255,255);

  $this->SetAligns(array("C","C","C","L","L","C"));
            $this->Row(array($i,utf8_decode($campo['co_solicitud']),utf8_decode($campo['cedula_rif']),utf8_decode($campo['contribuyente']),utf8_decode($campo['tx_tipo_solicitud']),utf8_decode($campo['tx_serial_sicsum']),utf8_decode($campo['fecha_creacion'])));

	    if($this->getY()>320){
	      $this->addPage();

$this->SetFont('Arial','B',9);
	 $this->Ln(6);
         $this->Cell(0,0,utf8_decode('Reporte Solicitudes Mas DE 30 Dias asociados a rectificacion '.$_GET["tx_instituto"]),0,0,'C');
	      $this->setY(45);
        $this->Ln(2);
$this->SetFont('Arial','',8);
        $this->SetFillColor(201, 199, 199);
        $this->SetAligns(array("C","C","C","L","L","C","C"));
        $this->SetWidths(array(10,15,20,60,40,35,25));
        $this->Row(array(utf8_decode('Nro.'),utf8_decode('Codigo'),utf8_decode('Rif/Cedula'),utf8_decode('Nombre/Razon Social'),utf8_decode('Tipo Solicitud'),utf8_decode('Codigo SICSUM'),utf8_decode('Fecha Ingreso')),1,1);
	     }
        }

$this->addPage();
$this->SetFont('Arial','B',9);
	 $this->Ln(6);
         $this->Cell(0,0,utf8_decode('Reporte Solicitudes Mas De 30 Dias asociados a rectificacion '.$_GET["tx_instituto"]),0,0,'C');
         $this->SetY(45);  
$i = 0 ;


	$this->Ln(3);
        $this->SetFillColor(201, 199, 199);
        $this->SetFont('Arial','',8);
        $this->SetAligns(array("C","C","C","C","C","C","C"));
        $this->SetWidths(array(10,15,20,60,40,35,25));
        $this->Row(array(utf8_decode('Nro.'),utf8_decode('Codigo'),utf8_decode('Rif/Cedula'),utf8_decode('Nombre/Razon Social'),utf8_decode('Tipo Solicitud'),utf8_decode('Codigo SICSUM'),utf8_decode('Fecha Ingreso')),1,1);
       foreach($this->datos_rec as $key => $campo){
		
		$total_recaudacion = $total_recaudacion + $campo['nu_monto_liq'];
		$i = $i + 1 ;
            $this->SetFillColor(255,255,255);

  $this->SetAligns(array("C","C","C","L","L","C"));
            $this->Row(array($i,utf8_decode($campo['co_solicitud']),utf8_decode($campo['cedula_rif']),utf8_decode($campo['contribuyente']),utf8_decode($campo['tx_tipo_solicitud']),utf8_decode($campo['tx_serial_sicsum']),utf8_decode($campo['fecha_creacion'])));

	    if($this->getY()>320){
	      $this->addPage();
	      $this->setY(45);
        $this->Ln(2);
        $this->SetFillColor(201, 199, 199);
        $this->SetAligns(array("C","C","C","L","L","C","C"));
        $this->SetWidths(array(10,15,20,60,40,35,25));
        $this->Row(array(utf8_decode('Nro.'),utf8_decode('Codigo'),utf8_decode('Rif/Cedula'),utf8_decode('Nombre/Razon Social'),utf8_decode('Tipo Solicitud'),utf8_decode('Codigo SICSUM'),utf8_decode('Fecha Ingreso')),1,1);
	     }
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

        $co_rol_solicitud    = $_GET["co_rol_solicitud"];
        $tx_instituto      = $_GET["tx_instituto"];
	if($tx_instituto=='Unidad de Recaudación'){
	$co_instituto = 10;
	}
	if($tx_instituto=='Ventanilla'){
	$co_instituto = 8;
	}
	if($tx_instituto=='Unidad de Inspección'){
	$co_instituto = 9;
	}
	if($tx_instituto=='Geomatica'){
	$co_instituto = 1;
	}
	if($tx_instituto=='Bombero'){
	$co_instituto = 7;
	}
	if($tx_instituto=='Unidad de Fiscalizacíón'){
	$co_instituto = 12;
	}
	if($tx_instituto=='Sindicatura'){
	$co_instituto = 2;
	}
	if($tx_instituto=='IPMGAS'){
	$co_instituto = 3;
	}
    	$fecha_hoy = date("d-m-Y");



          $sql = "select distinct  t31.co_solicitud, vp.cedula_rif,contribuyente,tx_tipo_solicitud, tx_serial_sicsum, t31.fecha_creacion from t31_ruta t31 LEFT JOIN vista_solicitud_procesada vp ON t31.co_solicitud = vp.co_solicitud where t31.fecha_creacion>= '21-11-2014' and t31.fecha_creacion<= '$fecha_hoy' and t31.co_instituto = $co_instituto and t31.co_estatus = 1 and t31.in_actual = true and date_part('day', '$fecha_hoy' - t31.fecha_creacion) > 30";

          $sql_rec = "select distinct t31.co_solicitud, vp.cedula_rif,contribuyente,tx_tipo_solicitud, tx_serial_sicsum, t31.fecha_creacion from t31_ruta t31 LEFT JOIN vista_rectificadas vr ON t31.co_solicitud = vr.co_solicitud_enlace LEFT JOIN vista_solicitud_procesada vp ON vr.co_solicitud_enlace = vp.co_solicitud where t31.fecha_creacion>= '21-11-2014' and t31.fecha_creacion<= '06-07-2015' and t31.co_instituto = $co_instituto and t31.co_estatus = 1 and t31.in_actual = true and date_part('day', '$fecha_hoy' - t31.fecha_creacion) > 30 and t31.co_solicitud = vr.co_solicitud_enlace";

          //echo $sql_rec; exit();
          $datos = $conex->ObtenerFilasBySqlSelect($sql);
	  $datos_rec = $conex->ObtenerFilasBySqlSelect($sql_rec);
          //echo $datosSol[0]['co_contribuyente']; exit();
          return  $datos;

/*SELECT   sum(t1.nu_monto_liq)
   FROM v_lista_empresas_ae t1
     JOIN ( SELECT v_lista_empresas_ae.co_contribuyente,
            max(v_lista_empresas_ae.fe_declaracion) AS fecha
           FROM v_lista_empresas_ae where v_lista_empresas_ae.co_sigla in(25,26)
           GROUP BY v_lista_empresas_ae.co_contribuyente) t2 ON t1.co_contribuyente = t2.co_contribuyente AND t1.fe_declaracion = t2.fecha
  WHERE  t1.co_sigla in(25,26) and fe_recaudacion >= '2015-01-01' and fe_recaudacion <= '2015-03-06' and t1.tx_motivo like '%2015%'
*/

    }

    function getSolicitudesRec(){

          $conex = new ConexionComun();

        $co_rol_solicitud    = $_GET["co_rol_solicitud"];
        $tx_instituto      = $_GET["tx_instituto"];
	if($tx_instituto=='Unidad de Recaudación'){
	$co_instituto = 10;
	}
	if($tx_instituto=='Ventanilla'){
	$co_instituto = 8;
	}
	if($tx_instituto=='Unidad de Inspección'){
	$co_instituto = 9;
	}
	if($tx_instituto=='Geomatica'){
	$co_instituto = 1;
	}
	if($tx_instituto=='Bombero'){
	$co_instituto = 7;
	}
	if($tx_instituto=='Unidad de Fiscalizacíón'){
	$co_instituto = 12;
	}
	if($tx_instituto=='Sindicatura'){
	$co_instituto = 2;
	}
	if($tx_instituto=='IPMGAS'){
	$co_instituto = 2;
	}
    	$fecha_hoy = date("d-m-Y");


          $sql_rec = "select distinct t31.co_solicitud, vp.cedula_rif,contribuyente,tx_tipo_solicitud, tx_serial_sicsum, t31.fecha_creacion from t31_ruta t31 LEFT JOIN vista_rectificadas vr ON t31.co_solicitud = vr.co_solicitud_enlace LEFT JOIN vista_solicitud_procesada vp ON vr.co_solicitud_enlace = vp.co_solicitud where t31.fecha_creacion>= '21-11-2014' and t31.fecha_creacion<= '06-07-2015' and t31.co_instituto = $co_instituto and t31.co_estatus = 1 and t31.in_actual = true and date_part('day', '$fecha_hoy' - t31.fecha_creacion) > 30 and t31.co_solicitud = vr.co_solicitud_enlace";

          //echo $sql_rec; exit();
	  $datos_rec = $conex->ObtenerFilasBySqlSelect($sql_rec);
          //echo $datosSol[0]['co_contribuyente']; exit();
          return  $datos_rec;

/*SELECT   sum(t1.nu_monto_liq)
   FROM v_lista_empresas_ae t1
     JOIN ( SELECT v_lista_empresas_ae.co_contribuyente,
            max(v_lista_empresas_ae.fe_declaracion) AS fecha
           FROM v_lista_empresas_ae where v_lista_empresas_ae.co_sigla in(25,26)
           GROUP BY v_lista_empresas_ae.co_contribuyente) t2 ON t1.co_contribuyente = t2.co_contribuyente AND t1.fe_declaracion = t2.fecha
  WHERE  t1.co_sigla in(25,26) and fe_recaudacion >= '2015-01-01' and fe_recaudacion <= '2015-03-06' and t1.tx_motivo like '%2015%'
*/

    }

    


}

$pdf=new PDF('P','mm','legal');
$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();
?>
