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
        // $this->Cell(0,0,utf8_decode('Cod. Reporte: SCD0006'),0,0,'R');
	 $this->Ln(6);
         $this->Cell(0,0,utf8_decode('REPORTE DETALLE RECTIFICACIONES'),0,0,'C');
         $this->Ln(6);
         $this->SetY($this->getY()*1);
         $this->SetFont('Arial','B',9);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(50,70,50,70,10,25));
         $this->SetAligns(array("L","L","L","L","L","L"));


	 $this->v_tramite = $this->tramite();


         $this->Row(array(utf8_decode('Numero de Solicitud:'),$this->v_tramite[0]['co_solicitud'],utf8_decode('Codigo tramite:'),$this->v_tramite[0]['tx_serial_sicsum']),1,1);
         $this->Row(array(utf8_decode('Tramite Solicitado:'),$this->v_tramite[0]['tx_tipo_solicitud'],utf8_decode('Instituto:'),$this->v_tramite[0]['tx_instituto']),1,1);
 	 $this->Row(array(utf8_decode('Estatus:'),$this->v_tramite[0]['tx_estatus'],utf8_decode('Fecha de Recepcion:'),$this->v_tramite[0]['fecha_recepcion']),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(50,190,30,45,10,25));
         $this->SetAligns(array("L","L","L","L","L","L"));	
	 $this->Row(array(utf8_decode('Observacion:'),utf8_decode($this->v_tramite[0]['observacion1'])));
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(50,70,50,70,10,25));
         $this->SetAligns(array("L","L","L","L","L","L"));
 	 $this->Row(array(utf8_decode('Cedula/Rif:'),$this->v_tramite[0]['rif_cedula'],utf8_decode('Nombre/Razon Social:'),$this->v_tramite[0]['contribuyente']));
	$this->Row(array(utf8_decode('Telefono Movil:'),$this->v_tramite[0]['nu_telf_movil'],utf8_decode('Telefono Local:'),$this->v_tramite[0]['nu_telf_hab']),1,1);

$this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(50,70,50,70,10,25));
         $this->SetAligns(array("L","L","L","L","L","L"));	
	$this->Row(array(utf8_decode('Parroquia:'),$this->v_tramite[0]['tx_parroquia'],utf8_decode('Direccion:'),utf8_decode($this->v_tramite[0]['tx_direccion'])));

         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(50,70,50,70,10,25));
         $this->SetAligns(array("L","L","L","L","L","L"));
	$this->Row(array(utf8_decode('Fecha de Reparo:'),$this->v_tramite[0]['fe_observacion'],utf8_decode('Usuario Reparo:'),$this->v_tramite[0]['nb_usuario'].' '.$this->v_tramite[0]['ap_usuario']),1,1);
$this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(50,190,30,45,10,25));
         $this->SetAligns(array("L","L","L","L","L","L"));	
	 $this->Row(array(utf8_decode('Observacion del Reparo:'),utf8_decode($this->v_tramite[0]['observacion_rectificacion'])));
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
          $sql = "select CASE
            WHEN tb004.tx_rif IS NOT NULL THEN tb004.tx_rif::text
            ELSE btrim(to_char(tb004.nu_cedula, '999999999'::text))
        END AS rif_cedula,
        CASE
            WHEN tb004.tx_razon_social IS NOT NULL THEN replace(tb004.tx_razon_social::text, ''::text, ''::text)
            ELSE (((((COALESCE(tb004.ap_contribuyente, ''::character varying)::text || ' '::text) || COALESCE(tb004.ap_contribuyente2, ''::character varying)::text) || ' '::text) || COALESCE(tb004.nb_contribuyente, ''::character varying)::text) || ' '::text) || COALESCE(tb004.nb_contribuyente2, ''::character varying)::text
        END AS contribuyente,t15.co_solicitud, t09.tx_tipo_solicitud,t15.tx_serial_sicsum,t05.tx_instituto, t06.tx_parroquia,t15.tx_direccion,t44.fe_observacion,t01.nb_usuario,t01.ap_usuario,t12.tx_estatus,t15.fecha_recepcion,tb004.nu_telf_movil,tb004.nu_telf_hab,t15.observacion as observacion1,t44.tx_observacion as observacion_rectificacion from t15_solicitud t15
  LEFT JOIN t09_tipo_solicitud t09 ON t09.co_tipo_solicitud = t15.co_tipo_solicitud
  LEFT JOIN tb004_contribuyente tb004 ON tb004.co_contribuyente = t15.co_contribuyente
  LEFT JOIN t11_documento t11 ON t11.co_documento = tb004.co_tipo
  LEFT JOIN t06_parroquia t06 ON t06.co_parroquia = t15.co_parroquia
  LEFT JOIN t05_instituto t05 ON t05.co_instituto = t15.co_instituto
  LEFT JOIN t12_estatus t12 ON t12.co_estatus = t15.co_estatus
  LEFT JOIN t31_ruta t31 ON t31.co_solicitud = t15.co_solicitud
  LEFT JOIN t44_obs_reparo t44 ON t44.co_ruta = t31.co_ruta
  LEFT JOIN t01_usuario t01 ON t01.co_usuario = t44.co_usuario
  LEFT JOIN t30_directorio_sicsum t30 ON t30.co_solicitud = t15.co_solicitud
  where t15.co_solicitud = ".$_GET['co_solicitud']." and t44.in_activo = true";
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
