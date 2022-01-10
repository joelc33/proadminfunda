<?php
include "ConexionComun.php";
include 'fpdf.php';

class PDF extends FPDF
{
    public $title;
    public $conexion;
    public function Header()
    {

        $this->Image("imagenes/escudosanfco.png", 167, 7, 20);

        $this->SetFont('Arial', 'B', 8);

        $fecha = strtotime("01-$_GET[fecha]");
        $mes = date("m", $fecha);
        $anio = date("Y", $fecha);
        if ($mes == 1) {
            $nmes = "ENERO";
        } elseif ($mes == 2) {
            $nmes = "FEBRERO";
        } elseif ($mes == 3) {
            $nmes = "MARZO";
        } elseif ($mes == 4) {
            $nmes = "ABRIL";
        } elseif ($mes == 5) {
            $nmes = "MAYO";
        } elseif ($mes == 6) {
            $nmes = "JUNIO";
        } elseif ($mes == 7) {
            $nmes = "JULIO";
        } elseif ($mes == 8) {
            $nmes = "AGOSTO";
        } elseif ($mes == 9) {
            $nmes = "SEPTIEMBRE";
        } elseif ($mes == 10) {
            $nmes = "OCTUBRE";
        } elseif ($mes == 11) {
            $nmes = "NOVIEMBRE";
        } elseif ($mes == 12) {
            $nmes = "DICIEMBRE";
        }
        $this->SetTextColor(0, 0, 0);
        $this->SetY(32);
        $this->Cell(0, 0, utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('ALCALDIA DE SAN FRANCISCO'), 0, 0, 'C');
        //$this->Ln(4);
        //$this->Cell(0, 0, utf8_decode('DIRECCIÓN DE ASESORÍA TECNICA Y EVALUACION DE PROYECTOS GUBERNAMENTALES'), 0, 0, 'C');

        $this->Ln(3);
        $this->SetAligns(array("L", "R", "L"));
        $this->SetWidths(array(100, 70, 30));
        $this->SetAligns(array("L", "R", "L"));
        $this->SetWidths(array(234, 70, 30));
        $this->Row(array('', 'Fecha de Impresion.: ', date('d/m/Y')), 0, 0);
        $this->SetFont('Arial', 'B', 14);
        $this->Ln(6);
        $this->Cell(0, 0, utf8_decode('RESUMEN DE LA CUENTA DE BIENES MUEBLES EN CADA UNIDAD DE TRABAJO'), 0, 0, 'C');
        $this->Ln(6);
        $this->Cell(0, 0, utf8_decode('CORRESPONDIENTE AL MES DE ' . $nmes . ' DEL AÑO ' . $anio), 0, 0, 'C');

        //    $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');

        $this->Ln(5);
        $this->SetTextColor(0, 0, 0);
        $this->SetX(1);

        $this->Ln(2);

    }

    public function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('Arial', '', 9);
    }

    public function dwawCell($title, $data)
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
    public function Cabezera()
    {
        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->SetWidths(array(100, 100, 134));
        $this->SetAligns(array("L", "L", "L"));
        $this->SetFillColor(255, 255, 255);

        $this->Row(array(utf8_decode("ESTADO: ZULIA"), utf8_decode("DISTRITO: MARACAIBO"), utf8_decode("MUNICIPIO: MARACAIBO")), 1, 1);
        if ($_GET['organigrama']) {
            $this->datos4 = $this->getEjecutor();
            foreach ($this->datos4 as $key => $val) {}
            $this->SetFont('Arial', '', 8);
            $this->SetWidths(array(100, 234));
            $this->SetAligns(array("L", "L", "L"));
            $this->SetFillColor(255, 255, 255);
            $this->Row(array(utf8_decode("UBICACION: $val[tx_organigrama]"), utf8_decode("CODIGO: $val[cod_adm]")), 1, 1);
            $this->SetWidths(array(334));
            $this->SetAligns(array("L"));
            $this->Row(array(utf8_decode("DIRECCIÓN: $val[tx_direccion]")), 1, 1);
            $this->Row(array(utf8_decode('OBSERVACIÓN: ')), 1, 1);}
        $this->Ln(5);

    }
    public function ChapterBody()
    {

        $this->Cabezera();
        $this->Titulo();
        $this->Cuerpo();

        /* $this->Row(array(utf8_decode('Existencia Anterior:'),$cba,number_format($monto_ant, 2, ',','.').' Bs.S',''),1,1);
        $this->Row(array(utf8_decode('Incorporaciones a la Cuenta:'),$cbi,number_format($monto_incor, 2, ',','.').' Bs.S',''),1,1);
        $this->Row(array(utf8_decode('Desincorporaciones en el mes de la cuenta por todos los conceptos, Con excepción del 60, "Faltantes de Bienes por Investigar" '),$cbd,'',number_format($monto_des, 2, ',','.').' Bs.S'),1,1);
        $this->Row(array(utf8_decode('Desincorporaciones en el mes de la cuenta por  el concepto 60 "Faltantes de Bienes por Investigar":'), $cbdf,'',number_format($monto_desf, 2, ',','.').' Bs.S'),1,1);
        $this->SetFillColor(255, 250, 250);
        $this->Row(array(utf8_decode('Existencia final :'),$cf,number_format($monto_ant+$monto_incor, 2, ',','.').' Bs.S',number_format($monto_desf+$monto_des, 2, ',','.').' Bs.S'),1,1);
        $this->SetWidths(array(110,90));
        $this->SetAligns(array("R","R"));

        $this->Cell(110,5,utf8_decode('Monto total :'),0,0,'R');
        $this->Cell(90,5,number_format($monto_final, 2, ',','.').' Bs.S',1,1,'C');*/
        //$this->Row(array(utf8_decode('Monto total :'),number_format($monto_final, 2, ',','.').' Bs.S'),1,1);

        // $this->SetY(200);
        // $this->PiePagina();

    }
    public function Titulo()
    {
        $this->Ln();
        $this->SetFont('Arial', 'B', 8);
        $this->SetWidths(array(45, 15, 44, 15, 44, 15, 44, 15, 44, 15, 40));
        $this->SetFillColor(201, 199, 199);
        $this->SetAligns(array("C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C"));
        $this->Row(array(utf8_decode("UNIDAD DE TRABAJO"), utf8_decode("NRO"), utf8_decode("EXISTENCIA ANT"), utf8_decode("NRO"), utf8_decode("INCORPORACIONES"), utf8_decode("NRO"), 'DESINCORPORACIONES', 'NRO', 'FALTANTES COD-60', 'NRO', 'MONTO ACTUAL'), 1, 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(255, 255, 255);
        $this->SetAligns(array("L", "C", "R", "C", "R", "C", "R", "C", "R", "C", "R"));
    }
    public function Cuerpo()
    {

        $this->padre = $this->getEjecutor();
        foreach ($this->padre as $key => $value) {

            $cba = $this->GetCantAnt($value['co_organigrama']);
            $cbi = $this->GetCantIncor($value['co_organigrama']);
            $cbd = $this->GetCantDes($value['co_organigrama']);
            $cbdf = $this->GetCantDes60($value['co_organigrama']);

            $monto_ant = $this->GetMontoAnt($value['co_organigrama']);
            $monto_incor = $this->GetMontoIncor($value['co_organigrama']);
            $monto_des = $this->GetMontoDes($value['co_organigrama']);
            $monto_desf = $this->GetMontoDes60($value['co_organigrama']);

            $cf = $cba + $cbi - $cbd - $cbdf;
            $monto_final = $monto_incor + $monto_ant - $monto_des - $monto_desf;
            $this->SetWidths(array(45, 15, 44, 15, 44, 15, 44, 15, 44, 15, 40));
            $this->SetAligns(array("L", "C", "R", "C", "R", "C", "R", "C", "R", "C", "R"));
            $this->Row2(array(utf8_decode($value['cod_adm'] . '-' . $value['tx_organigrama']), $cba, number_format($monto_ant, 2, ',', '.') . ' Bs.S', $cbi, number_format($monto_incor, 2, ',', '.') . ' Bs.S', $cbd, number_format($monto_des, 2, ',', '.') . ' Bs.S', $cbdf, number_format($monto_desf, 2, ',', '.') . ' Bs.S', $cf, number_format($monto_final, 2, ',', '.') . ' Bs.S'), 1, 1);
            $monto_final = 0;
            if ($this->getY() > 150) {

                $this->addPage();
                $this->Titulo();
            }
        }
    }
    public function Row2($data, $borde = 0, $pintar = 0)
    {
        //Calculate the height of the row
        $nb = 0;
        $height = array();
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            if ($this->NbLines($this->widths[$i], $data[$i]) < $nb) {
                $height[$i] = 5 * $nb;
            } else {
                $height[$i] = 5;
            }

            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            if ($borde == 1) {
                $this->Rect($x, $y, $w, $h);
            }

            //Print the text
            //$this->MultiCell($w,$height[$i],$data[$i],$borde,$a,$pintar);
            $this->MultiCell($w, 5, $data[$i], 0, $a); //standar

            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    public function GetMontoAnt($ubi)
    {

        $monto_ant = 0;
        $this->bienes_incor_ant = $this->getBienesAnt($ubi);
        if (isset($this->bienes_incor_ant) && !empty($this->bienes_incor_ant)) {
            foreach ($this->bienes_incor_ant as $key => $valor) {
                $monto_ant = $monto_ant + $valor['nu_monto'];
            }
        }
        return $monto_ant;
    }

    public function GetMontoIncor($ubi)
    {
        $this->bienesincorporados = $this->getBienes($ubi);
        $monto_incor = 0;
        if (isset($this->bienesincorporados) && !empty($this->bienesincorporados)) {
            foreach ($this->bienesincorporados as $key => $bi) {
                $monto_incor = $monto_incor + $bi['nu_monto'];
            }
        }

        return $monto_incor;

    }

    public function GetMontoDes($ubi)
    {
        $this->bienesdesincorporados = $this->getBienesDes($ubi);
        $monto_des = 0;
        if (isset($this->bienesdesincorporados) && !empty($this->bienesdesincorporados)) {
            foreach ($this->bienesdesincorporados as $key => $bd) {
                if ($bd['co_subtipo_movimiento_bienes'] != 63) {
                    $monto_des = $monto_des + $bd['nu_monto'];
                }
            }
        }
        return $monto_des;
    }
    public function GetMontoDes60($ubi)
    {
        $this->bienesdesincorporados = $this->getBienesDes($ubi);
        $monto_desf = 0;
        if (isset($this->bienesdesincorporados) && !empty($this->bienesdesincorporados)) {
            foreach ($this->bienesdesincorporados as $key => $bd) {
                if ($bd['co_subtipo_movimiento_bienes'] == 63) {
                    $monto_desf = $monto_desf + $bd['nu_monto'];
                }
            }
        }
        return $monto_desf;
    }

    public function GetCantAnt($ubi)
    {
        $cba = 0;
        $cbia = 0;
        $this->bienes_incor_ant = $this->getBienesAnt($ubi);
        if (isset($this->bienes_incor_ant) && !empty($this->bienes_incor_ant)) {
            foreach ($this->bienes_incor_ant as $key => $valor) {
                $cbia++;
            }
        }

        $cba = $cbia;
        return $cba;
    }

    public function GetCantIncor($ubi)
    {
        $this->bienesincorporados = $this->getBienes($ubi);
        $cbi = 0;
        if (isset($this->bienesincorporados) && !empty($this->bienesincorporados)) {
            foreach ($this->bienesincorporados as $key => $bi) {
                $cbi++;
            }}
        return $cbi;

    }

    public function GetCantDes($ubi)
    {
        $this->bienesdesincorporados = $this->getBienesDes($ubi);
        $cbd = 0;
        if (isset($this->bienesdesincorporados) && !empty($this->bienesdesincorporados)) {
            foreach ($this->bienesdesincorporados as $key => $bd) {
                if ($bd['co_subtipo_movimiento_bienes'] != 63) {
                    $cbd++;
                }
            }
        }
        return $cbd;
    }

    public function GetCantDes60($ubi)
    {
        $this->bienesdesincorporados = $this->getBienesDes($ubi);
        $cbdf = 0;
        if (isset($this->bienesdesincorporados) && !empty($this->bienesdesincorporados)) {
            foreach ($this->bienesdesincorporados as $key => $bd) {
                if ($bd['co_subtipo_movimiento_bienes'] == 63) {
                    $cbdf++;
                }
            }}
        return $cbdf;
    }

    public function PiePagina()
    {
        $this->Ln(6);
        $this->SetFont('Arial', 'B', 10);
        $this->SetWidths(array(200));
        $this->SetAligns(array("L"));
        $this->SetFillColor(201, 199, 199);
        $this->Row(array(utf8_decode('CONFORMIDAD CONTROL PERCEPTIVO')), 1, 1);
        $this->SetFillColor(230, 230, 230);
        $this->SetWidths(array(100, 100));
        $this->SetAligns(array("L", "L"));
        $this->Row(array(utf8_decode('Bienes de la dependencia:'), utf8_decode('Jefe de la Unidad:')), 1, 1);
        $this->SetFont('Arial', '', 10);
        $this->SetFillColor(255, 255, 255);
        $this->Row(array('', utf8_decode('Lic. Lu Betania')), 1, 1);

        $this->SetFillColor(230, 230, 230);
        $this->SetWidths(array(50, 50, 50, 50));
        $this->SetAligns(array("C", "C", "C", "C"));
        $this->Row(array(utf8_decode('Firma - Sello'), utf8_decode('Fecha'), utf8_decode('Firma - Sello'), utf8_decode('Fecha')), 1, 1);
        $this->SetFont('Arial', '', 10);
        $this->SetFillColor(255, 255, 255);
        $this->Row(array('

            ', '', '', ''), 1, 0);
        $this->ln();

    }
    public function ChapterTitle($num, $label)
    {
        $this->SetFont('Arial', '', 10);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(0, 6, "$label", 0, 1, 'L', 1);
        $this->Ln(8);
    }

    public function SetTitle($title)
    {
        $this->title = $title;
    }

    public function PrintChapter()
    {
        $this->AddPage();
        $this->ChapterBody();

    }
    public function getEjecutor()
    {
        $ubi = '';
        if ($_GET['organigrama'] != '') {
            $ubi = "WHERE tbbn006.co_organigrama=$_GET[organigrama]";
        }
        $conex = new ConexionComun();
        $sql = "SELECT tbbn006.co_organigrama,tbbn006.cod_adm, tbbn006.tx_organigrama,tbbn006.tx_direccion
       FROM tbbn006_organigrama AS tbbn006
       $ubi
       ORDER BY tbbn006.cod_adm";

        //echo var_dump($sql); exit();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return $datosSol;

    }

    public function getHijos($cod)
    {
        $conex = new ConexionComun();
        $sql = "SELECT tbbn006.co_organigrama,tbbn006.cod_adm, tbbn006.tx_organigrama,tbbn006.tx_direccion
   FROM tbbn006_organigrama AS tbbn006
   WHERE tbbn006.co_padre=$cod
   ORDER BY tbbn006.tx_organigrama";

        //echo var_dump($sql); exit();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return $datosSol;

    }

    public function getBienesAnt($ubi)
    {
        $fecha = strtotime("01-$_GET[fecha]");
        $mes = date("m", $fecha);
        $anio = date("y", $fecha);
        $fecha = date("d-m-Y",mktime(0, 0, 0, $mes,1, $anio)-1);
        $conex = new ConexionComun();
        $sql = "SELECT tb171.nu_monto           
        FROM tb173_movimiento_bienes AS tb173
        JOIN tb171_bienes AS tb171 ON tb173.co_bienes=tb171.co_bienes
        JOIN tbbn008_documento_bienes AS tbbn008 ON tbbn008.co_documento_bienes=tb173.co_documento
        JOIN tbbn004_subtipo_movimiento_bienes AS tbbn004 ON tbbn004.co_subtipo_movimiento_bienes=tbbn008.co_subtipo_movimiento
        JOIN tb172_tipo_movimiento_bienes AS tb172 ON tb172.co_tipo_movimiento_bienes=tbbn004.co_tipo_movimiento_bienes
        WHERE tbbn008.created_at::date <='$fecha' AND tb172.co_tipo_movimiento_bienes IN (1,2) AND tbbn008.co_ubicacion= $ubi";

         //echo var_dump($sql); exit();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return $datosSol;

    }

    public function getBienes($ubi)
    {
        $conex = new ConexionComun();
        $fecha = strtotime("01-$_GET[fecha]");
        //$fechaComoEntero = strtotime($fecha);
        $mes = date("m", $fecha);
        $anio = date("y", $fecha);
        $dia = date("d", (mktime(0, 0, 0, $mes + 1, 1, $anio) - 1));

        $sql = "SELECT tb171.nu_monto
        FROM tb171_bienes AS tb171
        JOIN tb173_movimiento_bienes AS tb173 ON tb171.co_bienes=tb173.co_bienes
        JOIN tbbn008_documento_bienes AS tbbn008 ON tbbn008.co_documento_bienes=tb173.co_documento
        JOIN tbbn004_subtipo_movimiento_bienes AS tbbn004 ON tbbn004.co_subtipo_movimiento_bienes=tbbn008.co_subtipo_movimiento
        JOIN tb172_tipo_movimiento_bienes AS tb172 ON tb172.co_tipo_movimiento_bienes=tbbn004.co_tipo_movimiento_bienes
      WHERE tbbn008.created_at BETWEEN '01-$_GET[fecha]' AND '$dia-$_GET[fecha]' AND tb172.co_tipo_movimiento_bienes IN (1,2) AND tb171.co_tipo_bienes=1 
      AND tbbn008.co_ubicacion=$ubi";

        // echo var_dump($sql); exit();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return $datosSol;

    }

    public function getBienesDes($ubi)
    {
        $conex = new ConexionComun();
        $fecha = strtotime("01-$_GET[fecha]");
        //$fechaComoEntero = strtotime($fecha);
        $mes = date("m", $fecha);
        $anio = date("y", $fecha);
        $dia = date("d", (mktime(0, 0, 0, $mes + 1, 1, $anio) - 1));

        $sql = "SELECT tb171.nu_monto,
        (SELECT t004.co_subtipo_movimiento_bienes     
	 
     FROM	 tb173_movimiento_bienes AS t173
     JOIN tbbn008_documento_bienes AS t008 ON t008.co_documento_bienes=t173.co_documento
     JOIN tbbn004_subtipo_movimiento_bienes AS t004 ON t004.co_subtipo_movimiento_bienes=t008.co_subtipo_movimiento
 WHERE t173.co_bienes=tb171.co_bienes
 ORDER BY t173.co_movimiento_bienes DESC LIMIT 1) AS co_subtipo_movimiento_bienes 
          FROM tb171_bienes AS tb171
          JOIN tb173_movimiento_bienes AS tb173 ON tb171.co_bienes=tb173.co_bienes
          JOIN tbbn008_documento_bienes AS tbbn008 ON tbbn008.co_documento_bienes=tb173.co_documento
          JOIN tbbn004_subtipo_movimiento_bienes AS tbbn004 ON tbbn004.co_subtipo_movimiento_bienes=tbbn008.co_subtipo_movimiento
          JOIN tb172_tipo_movimiento_bienes AS tb172 ON tb172.co_tipo_movimiento_bienes=tbbn004.co_tipo_movimiento_bienes
        WHERE tbbn008.created_at BETWEEN '01-$_GET[fecha]' AND '$dia-$_GET[fecha]'  AND tb171.co_tipo_bienes=1 AND tb171.in_incorporado IS FALSE  AND tbbn008.co_ubicacion=$ubi
        ORDER BY tbbn004.tx_subtipo_movimiento";

        // echo var_dump($sql); exit();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return $datosSol;

    }

}

//$pdf = new PDF('L', 'mm', 'legal');
//$pdf->AliasNbPages();
//$pdf->PrintChapter();
//
//$comm = new ConexionComun();
//$ruta = $comm->getRuta();
//
////rmdir($ruta);
////mkdir($ruta, 0777, true);
//
//$dir = "$ruta" . $_GET["codigo"] . ".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";
//
//$update = "update tb030_ruta set tx_ruta_reporte = '" . $dir . "' where co_ruta = " . $_GET['codigo']; //$comm->decrypt($_GET["codigo"]);
//
////echo $update; exit();
//$comm->Execute($update);
//
//$pdf->Output($dir, 'F');

$pdf = new PDF('L', 'mm', 'legal');
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();
