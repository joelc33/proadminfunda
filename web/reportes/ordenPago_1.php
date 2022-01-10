<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {


        $this->Image("imagenes/logo.png", 100, 7,20);

        $this->SetFont('Arial','B',10);

      //  $this->datos = $this->getTipoOrdenes();

        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        $this->Ln(6);
        $this->SetFont('Arial','B',9);
        $this->Cell(0,0,utf8_decode('ORDEN DE PAGO Nro. '),0,0,'C');

        $this->Ln(5);
        $this->SetFont('Arial','',8);

        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');

        $this->Ln(10);
        $this->SetTextColor(0,0,0);
        $this->SetX(1);

        $this->Ln(4);


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

         $this->Ln(1);

         $this->datos = $this->getPagos();

         $this->line(1, 60, 220, 60);
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(60,140));
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetY(65);
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('BENEFICIARIO')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetAligns(array("L","L","L","L"));
         $this->SetWidths(array(25,115, 20, 40));
         $this->SetFont('Arial','',6);
         $this->Row(array(utf8_decode('Nombre o Razón Social:'),$this->datos['tx_razon_social'],utf8_decode('R.I.F:'),utf8_decode($this->datos['tx_rif'])),1,1);
         $this->Row(array(utf8_decode('Dirección Fiscal:'),$this->datos['tx_direccion'],utf8_decode('Correo electrónico:'),utf8_decode($this->datos['tx_email'])),1,1);
         $this->Row(array(utf8_decode('Cuenta Bancaria:'),$this->datos['tx_cta_bancaria'],utf8_decode('Banco:'),$this->datos['tx_banco']),1,1);


         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->Ln();
         $this->SetFont('Arial','B',8);
         $this->Row(array(utf8_decode('DATOS DEL PAGO')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(40,160));
         $this->SetFont('Arial','',6);
         $this->Row(array(utf8_decode('Unidad Solicitante:'),$this->datos['tx_ente']),1,1);
         $this->Row(array(utf8_decode('Concepto:'),$this->datos['tx_observacion']),1,1);
         $this->SetAligns(array("L","L","L","L","L","L"));
         $this->SetWidths(array(40,30,20,40,20,50));

         $campo='';
         $this->lista_facturas = $this->getFacturas();
         foreach($this->lista_facturas as $key => $campo){
          $this->SetFont('Arial','',6);
          $this->Row(array(utf8_decode('Nro.Factura:'),$this->lista_facturas['nu_factura'],utf8_decode('Nro.Orden:'),$this->lista_facturas['numero_compra'],utf8_decode('Monto:'), number_format($this->lista_facturas['nu_total'], 2, ',','.')),1,1);

         

         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->Ln();
         $this->Row(array(utf8_decode('CALCULO DE RETENCIONES')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetAligns(array("C","C","C","C","C","C","C","C"));
         $this->SetWidths(array(20,30,20,30,20,30,20,30));
         $this->Row(array('Base Imponible',$this->lista_facturas['nu_base_imponible'],'IVA',$this->lista_facturas['nu_iva_factura'],utf8_decode('Monto Exento'),'0','Total a pagar',number_format($this->lista_facturas['nu_total_pagar'], 2, ',','.')),1,1);

         $this->SetWidths(array(70,130));
         $this->Row(array(utf8_decode('RETENCIÓN I.V.A'),$this->lista_facturas['nu_iva_retencion']),1,1);
         $campo1='';
         $this->lista_retenciones = $this->getRetenciones();
         foreach($this->lista_retenciones as $key => $campo1){
          $this->Row(array(utf8_decode($campo1['tx_tipo_retencion']),number_format($campo1['mo_retencion'], 2, ',','.')),1,1);
         }



         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->Ln();
         $this->Row(array(utf8_decode('PARTIDAS PRESUPUESTARIAS')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(40,160));
         $this->SetAligns(array("C","C","C","C","C","C","C"));
         $this->SetWidths(array(30,30,15,50,30,25,20));
         $this->Row(array(utf8_decode('Programa'),utf8_decode('Cuenta'),utf8_decode('Ordinal'), utf8_decode('Descripción'), utf8_decode('Monto'), utf8_decode('Analista'), utf8_decode('Fecha')),1,1);
         $this->SetAligns(array("C","C","C","C","C","C","C"));
         $this->SetWidths(array(30,30,15,50,30,25,20));

         }

         $this->ln();
         $this->SetAligns(array("C","C", "C"));
	 $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(65,70,65));
         $this->Row(array(utf8_decode('DIRECCION DE PRESUPUESTO'),utf8_decode('SECRETARIA DE ADMINISTRACION Y FINANZAS'),utf8_decode('MÁXIMA AUTORIDAD ORGANIZACIONAL')),1,1);
         $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L", "L","L"));
         $this->Row(array(utf8_decode('Registrado por:'),utf8_decode('Revisado por:'), utf8_decode('Aprobado por:')),1,1);
         $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->Row(array(utf8_decode('DATOS DE RECEPCIÓN -  REPRESENTANTE LEGAL DEL BENEFICIARIO')),1,1);
	 $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L","L", "L","L"));
         $this->SetWidths(array(50,50,50,50));
         $this->Row(array(utf8_decode('Nombre:'),utf8_decode('CI/RIF:'), utf8_decode('Fecha:'),utf8_decode('Firma:')),1,1);

         $this->ln();

         $this->Cell(0,0,utf8_decode('Usuario del sistema:'),0,0,'L');
         $this->ln();
	 $this->SetY($this->GetY()+5);
         $this->Cell(0,0,utf8_decode(''),0,0,'L');



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

    function getFacturas(){

          $conex = new ConexionComun();
          $sql = "select distinct co_factura,
                          nu_factura,
                          fe_emision,
                          nu_base_imponible,
                          co_iva_factura,
                          nu_iva_factura,
                          nu_total,
                          co_iva_retencion,
                          nu_iva_retencion,
                          tx_concepto,
                          co_compra,
                          nu_total_retencion,
                          nu_total_pagar,
                          numero_compra
                  from   tb045_factura as tb045
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb045.co_solicitud
                  left join tb052_compras as tb052 on tb052.co_solicitud=tb030.co_solicitud
                  where tb030.co_ruta = ".$_GET['co_ruta'];
                  //.$_GET['co_ruta'];

          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];

    }

    function getPagos(){

          $conex = new ConexionComun();
          $sql = "select tb039.nu_requisicion,
                         tb039.created_at,
                         tb027.tx_tipo_solicitud,
                         tb052.numero_compra,
                         tb052.fecha_compra,
                         tb039.co_solicitud,
                         tb052.tx_observacion,
                         tb008.tx_razon_social,
                         tb008.tx_rif,
                         tb008.tx_direccion,
                         tb008.nb_representante_legal,
                         tb008.nu_cedula_representante,
                         tb008.tx_email,
                         tb047.tx_ente,
                         tb027.tx_tipo_solicitud
                  from   tb039_requisiciones as tb039
                  left join tb052_compras as tb052 on tb052.co_requisicion=tb039.co_requisicion
                  left join tb027_tipo_solicitud as tb027 on tb027.co_tipo_solicitud=tb039.co_tipo_solicitud
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb052.co_proveedor
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb039.co_usuario
                  left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb039.co_solicitud
                  where tb030.co_ruta = ".$_GET['co_ruta'];

          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];

    }

    function getRetenciones(){

	  $conex = new ConexionComun();
          $sql = "select  nu_factura,
                          fe_emision,
                          nu_base_imponible,
                          nu_iva_factura,
                          nu_total,
                          nu_iva_retencion,
                          tx_concepto,
                          nu_total_retencion,
                          nu_total_pagar,
                          po_retencion,
                          mo_retencion,
                          tx_tipo_retencion
                  from   tb045_factura as tb045
                  left join tb046_factura_retencion as tb046 on tb046.co_factura = tb045.co_factura
                  left join tb041_tipo_retencion as tb041 on tb041.co_tipo_retencion = tb046.co_tipo_retencion
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb045.co_solicitud
                  where tb030.co_ruta = ".$_GET['co_ruta'];


          return $conex->ObtenerFilasBySqlSelect($sql);

    }

    function getPartidas()
    {
        $conex = new ConexionComun();
        $sql =" ".$_GET['co_ruta'];

        return $conex->ObtenerFilasBySqlSelect($sql);

    }


}


$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();
$pdf->PrintChapter();

$comm = new ConexionComun();
$ruta = $comm->getRuta();

//rmdir($ruta);
//mkdir($ruta, 0777, true);

$dir="$ruta".$_GET["codigo"].".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";


$update = "update tb030_ruta set tx_ruta_reporte = '".$dir."' where co_ruta = ".$_GET['codigo']; //$comm->decrypt($_GET["codigo"]);

//echo $update; exit();
$comm->Execute($update);

$pdf->Output($dir, 'F');

?>
