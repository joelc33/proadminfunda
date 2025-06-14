<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF
{
    public $title;
    public $conexion;
    function Header()
    {


        $this->Image("imagenes/escudosanfco.png", 100, 7, 20);

        $this->SetFont('Arial', 'B', 10);

        //  $this->datos = $this->getTipoOrdenes();

        $this->empresa = $this->getDatosEmpresa(1);

        $this->SetTextColor(0, 0, 0);
        $this->SetY(32);
        $this->Cell(0, 0, utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode($this->empresa['nb_empresa']), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode($this->empresa['nb_institucion']), 0, 0, 'C');
        $this->Ln(8);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 0, utf8_decode('COMPRA EXPRESS'), 0, 0, 'C');
        $this->Ln(4);
        $this->SetFont('Arial', '', 8);

        $this->Cell(0, 0, utf8_decode('Maracaibo, ' . date("d") . ' de ' . mes(date("m")) . ' del ' . date("Y")), 0, 0, 'R');
        $this->Ln(2);
        if ($this->PageNo() > 1)
            $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'L');

        $this->SetTextColor(0, 0, 0);
        $this->SetX(1);

    }

    function Footer()
    {
        $this->SetFont('Arial', '', 9);
        $this->SetY(-20);
    }

    function dwawCell($title, $data)
    {
        $width = 8;
        $this->SetFont('Arial', 'B', 12);
        $y = $this->getY() * 20;
        $x = $this->getX();
        $this->SetFillColor(206, 230, 100);
        $this->MultiCell(175, 8, $title, 0, 1, 'L', 0);
        $this->SetY($y);
        $this->SetFont('Arial', '', 12);
        $this->SetFillColor(206, 230, 172);
        $w = $this->GetStringWidth($title) + 3;
        $this->SetX($x + $w);
        $this->SetFillColor(206, 230, 172);
        $this->MultiCell(175, 8, $data, 0, 1, 'J', 0);

    }

    function ChapterBody()
    {



        $this->datos = $this->getFacturas();
        $this->line(1, 60, 220, 60);
        $this->SetY(65);
        $x = $this->getX();
        $campo = '';
        $this->getX($x);
        $this->SetFillColor(201, 199, 199);
        $this->SetFont('Arial', 'B', 8);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));
        $this->Row(array(utf8_decode('DATOS DE LA REQUISICION')), 1, 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetWidths(array(30, 50, 120));
        $this->SetAligns(array("L", "L", "L", "L"));
        $this->SetFont('Arial', 'B', 7);
        $this->Row(array(utf8_decode('Nro.: ') . $this->datos[0]['nu_requisicion'], utf8_decode('Fecha Requisición:  ') . $this->datos[0]['created_at'], 'Unidad Solicitante:  ' . utf8_decode($this->datos[0]['tx_ente'])), 1, 1);
        $this->SetWidths(array(30, 170));
        $this->Row(array('Concepto: ', $this->datos[0]['concepto_req']), 1, 1);

        foreach ($this->datos as $key => $campo) {

            if ($this->getY() > 170) {
                $this->addPage();
                $this->SetY(65);
                $this->getX(20);
                $this->getX($x);
                $this->SetFillColor(201, 199, 199);
                $this->SetFont('Arial', 'B', 8);
                $this->SetWidths(array(200));
                $this->SetAligns(array("C"));
                $this->Row(array(utf8_decode('DATOS DE LA REQUISICION')), 1, 1);
                $this->SetFillColor(255, 255, 255);
                $this->SetWidths(array(30, 50, 120));
                $this->SetAligns(array("L", "L", "L", "L"));
                $this->SetFont('Arial', 'B', 7);
                $this->Row(array(utf8_decode('Nro.: ') . $campo['nu_requisicion'], utf8_decode('Fecha Requisición:  ') . $campo['created_at'], 'Unidad Solicitante:  ' . utf8_decode($campo['tx_ente'])), 1, 1);
                $this->SetWidths(array(30, 170));
                $this->Row(array('Concepto: ', $campo['concepto_req']), 1, 1);
            }

            $this->SetWidths(array(200));
            $this->SetAligns(array("L"));
            $this->SetFillColor(201, 199, 199);
            $this->SetFont('Arial', 'B', 8);
            $this->Row(array(utf8_decode('FACTURA NRO. ' . $campo['nu_factura'])), 1, 1);
            $this->SetFillColor(255, 255, 255);
            $this->SetAligns(array("L", "L", "L", "L", "L", "L"));
            $this->SetWidths(array(140, 60));
            $this->SetFont('Arial', 'B', 7);
            $this->Row(array('Concepto:  ' . utf8_decode($campo['concepto_fact']), 'Monto: ' . number_format($campo['nu_total'], 2, ',', '.')), 1, 1);


            $this->SetWidths(array(200));
            $this->SetAligns(array("C"));
            $this->SetFillColor(201, 199, 199);
            $this->SetFont('Arial', 'B', 6);
            $this->Row(array(utf8_decode('RETENCIONES ASOCIADAS')), 1, 1);
            $this->SetFillColor(255, 255, 255);
            $this->SetFont('Arial', 'B', 7);
            $this->SetAligns(array("C", "C", "C", "C"));
            $this->SetWidths(array(60, 40, 50, 50));
            $this->Row(array('Base Imponible :' . $campo['nu_base_imponible'], 'IVA: ' . $campo['nu_iva_factura'], 'Monto Exento: ' . number_format($campo['monto_excento'], 2, ',', '.'), 'Total a pagar: ' . number_format($campo['total_pagar'], 2, ',', '.')), 1, 1);

            $this->SetFont('Arial', '', 7);
            $this->SetWidths(array(100, 100));
            $this->Row(array(utf8_decode('RETENCIÓN I.V.A'), $campo['nu_iva_retencion']), 1, 1);
            $campo1 = '';
            $this->lista_retenciones = $this->getRetenciones($campo['co_factura']);
            foreach ($this->lista_retenciones as $key => $campo1) {
                $this->Row(array(utf8_decode($campo1['tx_tipo_retencion']), number_format($campo1['mo_retencion'], 2, ',', '.')), 1, 1);

            }

        }
        $this->ln();
        $this->Cell(0, 0, utf8_decode('Usuario del sistema: ' . $campo['nb_usuario']), 0, 0, 'L');
        $this->SetY($this->GetY() + 5);
    }

    function ChapterTitle($num, $label)
    {
        $this->SetFont('Arial', '', 10);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(0, 6, "$label", 0, 1, 'L', 1);
        $this->Ln(8);
    }

    function SetTitle($title)
    {
        $this->title = $title;
    }

    function PrintChapter()
    {
        $this->AddPage();
        $this->ChapterBody();
    }

    function getFacturas()
    {

        $conex = new ConexionComun();
        $sql = "   select tb045.nu_factura, 
                          tb039.nu_requisicion,
                          co_factura,
                          fe_emision, 
                          nu_base_imponible,
                          nu_iva_factura, 
                          nu_total, 
                          total_pagar,
                          nu_total_retencion,
                          nu_iva_retencion, 
                          tb045.tx_concepto as concepto_fact,
                          tb039.nu_requisicion,  
                         tb039.tx_concepto as concepto_req,
                         tb039.created_at,  
                         tb047.tx_ente, 
                         nb_usuario,
                         case when(tb045.co_iva_factura = 0) then nu_total else '0' end as monto_excento
                  from   tb026_solicitud as tb026                                                    
                  left join tb045_factura as tb045 on tb045.co_solicitud = tb026.co_solicitud
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor
                  left join tb039_requisiciones as tb039 on tb045.co_solicitud = tb039.co_solicitud
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb039.co_usuario   
                  left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb045.co_solicitud 
                  where tb030.co_ruta = " . $_GET['codigo'];
        //.$_GET['co_ruta'];

        return $conex->ObtenerFilasBySqlSelect($sql);
    }

    function getDatosEmpresa($codigo)
    {

        $sql = "SELECT co_empresa, nb_empresa, co_estado, co_municipio, tx_rif, tx_nit, 
        tx_direccion, tx_imagen_der, tx_imagen_izq, tx_imagen_cen, nu_telefono, 
        tx_sigla,
        op_imagen->'izquierda'->0 as izquierda_x,
        op_imagen->'izquierda'->1 as izquierda_y,
        op_imagen->'izquierda'->2 as izquierda_w,
        op_imagen->'centro'->0 as centro_x,
        op_imagen->'centro'->1 as centro_y,
        op_imagen->'centro'->2 as centro_w,
        op_imagen->'derecha'->0 as derecha_x,
        op_imagen->'derecha'->1 as derecha_y,
        op_imagen->'derecha'->2 as derecha_w
        FROM public.tb015_empresa
        WHERE co_empresa = " . $codigo . ";";

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return $datosSol[0];

    }

    function getRetenciones($fact)
    {

        $conex = new ConexionComun();
        $sql = "select  mo_retencion,
                          tx_tipo_retencion
                  from   tb045_factura as tb045     
                  left join tb046_factura_retencion as tb046 on tb046.co_factura = tb045.co_factura
                  left join tb041_tipo_retencion as tb041 on tb041.co_tipo_retencion = tb046.co_tipo_retencion
                  where tb045.co_factura = " . $fact;


        return $conex->ObtenerFilasBySqlSelect($sql);

    }

}


$pdf = new PDF('P', 'mm', 'letter');
$pdf->AliasNbPages();
$pdf->PrintChapter();

$comm = new ConexionComun();
$ruta = $comm->getRuta();

//rmdir($ruta);
//mkdir($ruta, 0777, true);    

$dir = "$ruta" . $_GET["codigo"] . ".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";


$update = "update tb030_ruta set tx_ruta_reporte = '" . $dir . "' where co_ruta = " . $_GET['codigo']; //$comm->decrypt($_GET["codigo"]);

//echo $update; exit();
$comm->Execute($update);

$pdf->Output($dir, 'F');

/*
$pdf=new PDF('P','mm','letter');
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); */


?>