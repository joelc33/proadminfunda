<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF
{
  public $title;
  public $conexion;
  function Header()
  {

    $this->datos0 = $this->getEjecutor();
    foreach ($this->datos0 as $key => $soli) {
    }
    $this->Image("imagenes/escudosanfco.png", 167, 7, 20);
    $this->empresa = $this->getDatosEmpresa(1);

    $this->SetFont('Arial', 'B', 8);


    $this->SetTextColor(0, 0, 0);
    $this->SetY(32);
    $this->Cell(0, 0, utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'), 0, 0, 'C');
    $this->Ln(4);
    $this->Cell(0, 0, utf8_decode($this->empresa['nb_empresa']), 0, 0, 'C');
    $this->Ln(4);
    $this->Cell(0, 0, utf8_decode($this->empresa['nb_institucion']), 0, 0, 'C');
    //$this->Ln(4);
    //$this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACION Y FINANZAS'),0,0,'C');

    /*$this->Ln(2);
     $this->SetFont('Arial','',9);
     $this->SetAligns(array("L","L","L"));
     $this->SetWidths(array(160,20,20));
     $this->Row(array('',' Nro.:',''),0,0); */
    $this->re = $this->getReporte();
    foreach ($this->re as $key => $va) {
    }
    $this->Ln(4);
    $this->SetAligns(array("L", "R"));
    $this->SetWidths(array(250, 50, 34));
    //        $this->Row(array('','Fecha de Impresion.: ',date('d/m/Y')),0,0); 
    $this->Row(array('', 'Codigo de Solicitud.: ', $soli['co_solicitud']), 0, 0);
    //  $this->Row(array('','Codigo del Acta.: ',$va['co_reporte']),0,0); 

    $this->Ln(4);
    $this->SetFont('Arial', 'B', 14);
    $this->Cell(0, 0, utf8_decode('ACTA DE INCORPORACIÓN'), 0, 0, 'C');

    //    $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');

    $this->Ln(5);
    $this->SetTextColor(0, 0, 0);
    $this->SetX(1);

    $this->Ln(2);


  }

  function Footer()
  {
    // $this->SetY(200);
    //$this->PiePagina();
    $this->SetY(-10);
    $this->SetFont('Arial', '', 9);
    $this->SetFont('Arial', '', 10);
    $this->Cell(-334, 15, $this->PageNo(), 0, 0, 'C');
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
  function Cabezera($nombre, $inco, $doc, $res)
  {
    $this->Ln();
    $this->SetFont('Arial', 'B', 10);
    $this->SetWidths(array(334));
    $this->SetAligns(array("L", "L", "L", "L"));
    $this->SetFillColor(201, 199, 199);
    $this->Row(array(utf8_decode('INDENTIFICACIÓN')), 1, 1);

    $this->datos = $this->getEjecutor();
    $this->SetFillColor(230, 230, 230);
    $this->SetWidths(array(100, 85, 85, 64));
    $this->SetAligns(array("L"));
    $this->SetFont('Arial', '', 9);
    $this->Row(array(utf8_decode('UBICACION'), utf8_decode('TIPO INCORPORACIÓN'), utf8_decode('DOCUMENTO'), utf8_decode('RESPONSABLE')), 1, 1);
    foreach ($this->datos as $key => $campo) {
      $this->Row(array($campo['tx_organigrama'], $campo['tx_subtipo_movimiento'], $campo['desc_documento'], $res), 1, 0);
    }


  }
  function ChapterBody()
  {


    // $this->SetY(60);
    $i = true;
    $suma = 0;
    $this->Cabezera();
    $this->SetFont('Arial', 'B', 10);
    $this->SetWidths(array(334));
    $this->SetAligns(array("L"));
    $this->SetFillColor(201, 199, 199);
    $this->Row(array(utf8_decode('DESCRIPCIONES Y ESPECIFICACIONES DE LOS BIENES')), 1, 1);
    $this->SetFillColor(230, 230, 230);
    $this->SetWidths(array(15, 99, 35, 35, 50, 20, 20, 20, 40, 20, 40, 40));
    $this->SetAligns(array("C", "C", "C", "C", "C", "C", "C", "C", "R", "C", "C", "C", "C"));
    $this->SetFont('Arial', '', 6);
    $this->Row(array(utf8_decode('Codigo'), utf8_decode('Especificación'), utf8_decode('Proveedor'), utf8_decode('Rif'), utf8_decode('Orden de Compra'), utf8_decode('Fecha Orden'), utf8_decode('Factura'), utf8_decode('Fecha Factura'), utf8_decode('monto')), 1, 1);



    $this->datos2 = $this->getBienes();
    foreach ($this->datos2 as $key => $valores) {
      $this->SetFillColor(255, 255, 255);
      $this->SetWidths(array(15, 99, 35, 35, 50, 20, 20, 20, 40, 20, 20, 20));
      $this->SetAligns(array("C", "L", "L", "L", "L", "C", "C", "R", "R", "C", "C", "C", "L"));
      $this->Row(array(utf8_decode($valores['nu_bienes']), utf8_decode($valores['tx_detalle']), utf8_decode($valores['tx_razon_social']), utf8_decode($valores['tx_rif']), utf8_decode($valores['orden_compra']), utf8_decode($valores['fe_orden']), utf8_decode($valores['nu_factura']), utf8_decode($valores['fe_factura']), utf8_decode($valores['nu_monto'])), 1, 1);
      //$this->ln(10);
      $suma = $suma + $valores['nu_monto'];
      if ($this->getY() > 170) {

        $this->addPage();
        $this->Cabezera();
        $this->SetFont('Arial', 'B', 10);
        $this->SetWidths(array(334));
        $this->SetAligns(array("L"));
        $this->SetFillColor(201, 199, 199);
        $this->Row(array(utf8_decode('DESCRIPCIONES Y ESPECIFICACIONES DE LOS BIENES')), 1, 1);
        $this->SetFillColor(230, 230, 230);
        $this->SetWidths(array(15, 99, 35, 35, 50, 20, 20, 20, 40, 20, 40, 40));
        $this->SetAligns(array("C", "C", "C", "C", "C", "C", "C", "C", "R", "C", "C", "C", "C"));
        $this->SetFont('Arial', '', 6);
        $this->Row(array(utf8_decode('Codigo'), utf8_decode('Especificación'), utf8_decode('Proveedor'), utf8_decode('Rif'), utf8_decode('Orden de Compra'), utf8_decode('Fecha Orden'), utf8_decode('Factura'), utf8_decode('Fecha Factura'), utf8_decode('monto')), 1, 1);

      }

    }



    $this->SetFont('Arial', 'B', 9);
    $this->SetAligns(array("L", "R", "L"));
    $this->SetWidths(array(230, 70, 70));
    $this->Row(array('', 'MONTO TOTAL.: ', number_format($suma, 2, ',', '.') . " Bs.S"), 0, 0);

    $this->PiePagina();



  }

  function PiePagina()
  {
    $this->datos3 = $this->getEjecutor();
    foreach ($this->datos3 as $key => $val) {
    }
    $this->Ln(8);
    $this->SetFont('Arial', 'B', 10);
    $this->SetWidths(array(334));
    $this->SetAligns(array("L"));
    $this->SetFillColor(201, 199, 199);
    $this->Row(array(utf8_decode('CONFORMIDAD CONTROL PERCEPTIVO')), 1, 1);
    $this->SetFillColor(230, 230, 230);
    $this->SetWidths(array(167, 167));
    $this->SetAligns(array("L", "L"));
    $this->Row(array(utf8_decode('Elaborado por:'), utf8_decode('Jefe de la Unidad:')), 1, 1);
    $this->SetFont('Arial', '', 10);
    $this->SetFillColor(255, 255, 255);
    $this->Row(array(utf8_decode($val['nb_usuario']), utf8_decode('Econ. Lu Betania')), 1, 1);

    $this->SetFillColor(230, 230, 230);
    $this->SetWidths(array(83, 84, 83, 84));
    $this->SetAligns(array("C", "C", "C", "C"));
    $this->Row(array(utf8_decode('Firma - Sello'), utf8_decode('Fecha'), utf8_decode('Firma - Sello'), utf8_decode('Fecha')), 1, 1);
    $this->SetFont('Arial', '', 10);
    $this->SetFillColor(255, 255, 255);
    $this->Row(array('

            ',
      '',
      '',
      ''
    ), 1, 0);
    $this->ln();

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
  function getReporte()
  {

    $conex = new ConexionComun();
    $sql = "SELECT  tbbn016.co_reporte
      FROM tb026_solicitud AS tb026
      JOIN tb030_ruta AS tb030 ON tb030.co_solicitud=tb026.co_solicitud
      JOIN tbbn016_reporte AS tbbn016 ON tb026.co_solicitud=tbbn016.co_solicitud
      WHERE tb030.in_actual=true AND tb030.co_ruta=$_GET[codigo]";

    //echo var_dump($sql); exit();
    $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
    return $datosSol;

  }
  function getEjecutor()
  {

    $conex = new ConexionComun();
    $sql = "SELECT tb001.nb_usuario,tb026.co_solicitud,tbbn006.tx_organigrama,tbbn004.tx_subtipo_movimiento,tbbn005.desc_documento,tbbn008.co_documento_bienes
                          ,tbbn010.tx_nombres||' '||tbbn010.tx_apellidos AS responsable
          FROM tbbn008_documento_bienes AS tbbn008
          JOIN tb026_solicitud AS tb026 ON tb026.co_solicitud=tbbn008.co_solicitud
          JOIN tb001_usuario AS tb001 ON tb001.co_usuario=tb026.co_usuario
          JOIN tb030_ruta AS tb030 ON tb030.co_solicitud=tb026.co_solicitud
          JOIN tbbn006_organigrama AS tbbn006 ON tbbn006.co_organigrama=tbbn008.co_ubicacion
          JOIN tbbn004_subtipo_movimiento_bienes AS tbbn004 ON tbbn004.co_subtipo_movimiento_bienes=tbbn008.co_subtipo_movimiento
          JOIN tbbn005_tipo_documento AS tbbn005 ON tbbn005.co_documento=tbbn008.co_tipo_documento
          JOIN tb172_tipo_movimiento_bienes AS tb172 ON tb172.co_tipo_movimiento_bienes=tbbn004.co_tipo_movimiento_bienes
          LEFT JOIN tbbn010_responsables AS tbbn010 ON tbbn010.co_responsables=tbbn006.co_responsable
          WHERE tb030.in_actual=true AND tb030.co_ruta=$_GET[codigo]
          GROUP BY tb001.nb_usuario,tb026.co_solicitud,tbbn006.tx_organigrama,tbbn004.tx_subtipo_movimiento,tbbn005.desc_documento,tbbn008.co_documento_bienes,tbbn010.tx_apellidos,tbbn010.tx_nombres limit 1";

    //echo var_dump($sql); exit();
    $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
    return $datosSol;

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

  function getBienes($id)
  {

    $conex = new ConexionComun();
    $sql = "SELECT tb171.nu_bienes,tb048.tx_producto,tb174.tx_marca,
       tb175.tx_modelo,tb171.tx_detalle,tb008.tx_razon_social,tb008.tx_rif,tb060.tx_serial as orden_compra,
       tb060.fe_emision as fe_orden,tb045.nu_factura,tbbn008.created_at::date as fe_factura,tb171.nu_monto
        FROM tb171_bienes AS tb171
        LEFT JOIN tb048_producto AS tb048 ON tb048.co_producto=tb171.co_producto
        LEFT JOIN tb173_movimiento_bienes AS tb173 ON tb171.co_bienes=tb173.co_bienes
        JOIN tbbn008_documento_bienes AS tbbn008 ON tbbn008.co_documento_bienes=tb173.co_documento
        LEFT JOIN tb053_detalle_compras AS tb053 ON tb053.co_detalle_compras=tb171.co_detalle_compras
        LEFT JOIN tb045_factura AS tb045 ON tb045.co_factura=tb053.co_factura
        LEFT JOIN tb060_orden_pago tb060 ON tb060.co_orden_pago=tb045.co_odp
        LEFT JOIN tb175_modelo AS tb175 ON tb175.co_modelo=tb171.co_modelo
        LEFT JOIN tb174_marca AS tb174 ON tb174.co_marca=tb175.co_marca
        LEFT JOIN tb008_proveedor AS tb008 ON tb008.co_proveedor=tb171.co_proveedor
        JOIN tb030_ruta AS tb030 ON tb030.co_solicitud=tbbn008.co_solicitud
        WHERE tb030.co_ruta=$_GET[codigo]";

    // echo var_dump($sql); exit();
    $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
    return $datosSol;

  }



}

$pdf = new PDF('L', 'mm', 'legal');
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



$pdf = new PDF('L', 'mm', 'legal');
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();


?>