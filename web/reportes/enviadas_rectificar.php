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
	
 	$fe_desde    = $_GET['fe_desde'];
        $fe_hasta      = $_GET['fe_hasta'];

         $this->Ln(6);
         $this->Cell(0,0,utf8_decode('Fecha de Impresión: '.date("d-m-Y")),0,0,'R');
         $this->Ln(4);
         $this->Cell(0,0,utf8_decode('Cod. Reporte: SRV008'),0,0,'R');
	 $this->Ln(6);
         $this->Cell(0,0,utf8_decode('REPORTE SOLICITUDES ENVIADAS A RECTIFICAR'),0,0,'C');
 	 $this->Ln(6);
         $this->Cell(0,0,utf8_decode('DESDE '.$fe_desde.' AL '.$fe_hasta),0,0,'C');
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


         
         $this->Ln(20);
	
         $this->datos = $this->getSolicitudes();
		//echo $this->datos['co_contribuyente']; exit;
         
        $this->setY(55);
	

      	
	$this->Ln(3);
        $this->SetFillColor(201, 199, 199);
        $this->SetFont('Arial','',8);
	$this->SetAligns(array("C","C","C","L","L","C"));
        $this->SetWidths(array(10,20,20,45,35,35,20,20));
        $this->Row(array(utf8_decode('Nro.'),utf8_decode('Cod. Solicitud'),utf8_decode('Rif/Cedula'),utf8_decode('Nombre/Razon Social'),utf8_decode('Tipo Solicitud'),utf8_decode('Codigo SICSUM'),utf8_decode('Fecha Rec.'),utf8_decode('Ente Rec.')),1,1);

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
            $this->Row(array($i,utf8_decode($campo['co_solicitud']),utf8_decode($campo['cedula_rif']),utf8_decode($campo['contribuyente']),utf8_decode($campo['tx_tipo_solicitud']),utf8_decode($campo['tx_serial_sicsum']),utf8_decode($campo['fe_observacion']),utf8_decode($campo['tx_instituto'])));

	    if($this->getY()>320){
		       $this->addPage();
	$this->setY(45);
         $this->Ln(2);
        $this->SetFillColor(201, 199, 199);
	$this->SetAligns(array("C","C","C","L","L","C"));
         $this->SetWidths(array(10,20,20,45,35,35,20,20));
       $this->Row(array(utf8_decode('Nro.'),utf8_decode('Cod. Solicitud'),utf8_decode('Rif/Cedula'),utf8_decode('Nombre/Razon Social'),utf8_decode('Tipo Solicitud'),utf8_decode('Cod. SICSUM'),utf8_decode('Fecha Rec.'),utf8_decode('Ente Rec.')),1,1);
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

        $fe_desde    = $_GET['fe_desde'];
        $fe_hasta      = $_GET['fe_hasta'];
    
          $condicion = '';
          if($_GET['fe_desde']){
              $condicion = " t44.fe_observacion>= '".$_GET['fe_desde']."' and ";
          }
          
          if($_GET['fe_hasta']){
	      $condicion.= " t44.fe_observacion<= '".$_GET['fe_hasta']."' and ";
          }

          if($_GET['co_instituto']){
	      $condicion.= " vp.co_instituto = ".$_GET['co_instituto']." and ";
          }


          $sql = "select vp.co_solicitud, vp.cedula_rif, vp.contribuyente, vp.tx_tipo_solicitud, vp.tx_serial_sicsum, t05.tx_instituto, t44.fe_observacion  from vista_solicitud_procesada vp join t44_obs_reparo t44 on (vp.co_ruta = t44.co_ruta_actual)  join t31_ruta t31 on (t31.co_ruta = t44.co_ruta)   join t05_instituto t05 on (t05.co_instituto = t31.co_instituto) where $condicion in_activo = true and vp.co_estatus <> 6";

          //echo $sql; exit();
          $datos = $conex->ObtenerFilasBySqlSelect($sql);
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

    


}

$pdf=new PDF('P','mm','legal');
$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();
?>
