<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF
{
    public $title;
    public $conexion;
    function Header()
    {


        $this->empresa = $this->getDatosEmpresa(1);

        $this->Image("imagenes/escudosanfco.png", 165, 5, 20);
        $this->Ln(20);
        $this->SetFont('Arial', 'B', 12);
        $this->SetX(130);
        $this->Cell(0, 0, utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 12);
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode($this->empresa['nb_empresa']), 0, 0, 'L');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode($this->empresa['nb_institucion']), 0, 0, 'L');
        $this->Ln(5);
        $this->SetX(136);
        $this->Cell(0, 0, utf8_decode('OFICINA DE RECURSOS HUMANOS'), 0, 0, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('Maracaibo, ' . date("d") . ' de ' . mes(date("m")) . ' del ' . date("Y")), 0, 0, 'R');

    }

    function Footer()
    {
        $this->SetFont('Arial', 'B', 9);
        $this->SetY(250);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
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

        $this->Ln(10);
        $this->SetWidths(array(150));
        $this->SetX(100);
        $this->SetAligns(array("C"));
        $this->SetFont('Arial', 'B', 12);
        $this->Row(array(utf8_decode('REPORTE PRE-NOMINA ' . date("d/m/Y", strtotime($_GET['fe_inicio'])) . ' AL ' . date("d/m/Y", strtotime($_GET['fe_fin'])))), 0, 0);
        $this->Ln(2);
        $this->SetFillColor(255, 255, 255);

        $this->lista_op = $this->getOP();
        $this->SetX(3);
        $this->SetFont('Arial', 'B', 10);
        $this->SetWidths(array(8, 15, 20, 25, 25, 20, 10, 25, 20, 40, 15, 15, 40, 20, 30, 20));
        $this->SetFillColor(171, 170, 170);
        $this->SetAligns(array("C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C"));

        $this->Row(array(
            utf8_decode('N'),
            utf8_decode('Grupo'),
            utf8_decode('Cedula'),
            utf8_decode('Nombre'),
            utf8_decode('Apellido'),
            utf8_decode('Fecha de Ingreso'),
            utf8_decode('Act'),
            utf8_decode('Fecha de Asignacion'),
            utf8_decode('Solicitud'),
            utf8_decode('Cuenta Bancaria'),
            utf8_decode('Co Banco'),
            utf8_decode('Codigo'),
            //aqui
            utf8_decode('Cargo'),
            utf8_decode('Codigo Estructura'),
            utf8_decode('Estructura admin'),
            utf8_decode('Salario'),
        ), 1, 1);

        $this->SetAligns(array("C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C"));


        $numero = 1;
        foreach ($this->lista_op as $key => $campo) {

            if ($this->getY() > 150) {
                $this->addPage('L', 'mm', 'letter');
                $this->Ln(6);
                $this->SetX(3);
                $this->SetFont('Arial', 'B', 10);
                $this->SetWidths(array(8, 15, 20, 25, 25, 20, 10, 25, 20, 40, 15, 15, 40, 20, 30, 20));
                $this->SetFillColor(171, 170, 170);
                $this->SetAligns(array("C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C"));

                $this->Row(array(
                    utf8_decode('N'),
                    utf8_decode('Grupo'),
                    utf8_decode('Cedula'),
                    utf8_decode('Nombre'),
                    utf8_decode('Apellido'),
                    utf8_decode('Fecha de Ingreso'),
                    utf8_decode('Act'),
                    utf8_decode('Fecha de Asignacion'),
                    utf8_decode('Solicitud'),
                    utf8_decode('Cuenta Bancaria'),
                    utf8_decode('Co Banco'),
                    utf8_decode('Codigo'),
                    utf8_decode('Cargo'),
                    utf8_decode('Codigo Estructura'),
                    utf8_decode('Estructura admin'),
                    utf8_decode('Salario'),
                ), 1, 1);
            }
            //Tabla Actualizacion abajo
            // echo var_dump($campo); exit();
            $this->SetFont('Arial', '', 8);
            $this->SetX(3);
            $this->SetWidths(array(8, 15, 20, 25, 25, 20, 10, 25, 20, 40, 15, 15, 40, 20, 30, 20));
            $this->SetFillColor(255, 255, 255);
            $this->SetAligns(array("C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C", "C"));


            $this->Row(array(
                $numero,
                utf8_decode($campo['tx_grupo_nomina']),
                utf8_decode($campo['nu_cedula']),
                utf8_decode($campo['nb_primer_nombre']),
                ucwords(utf8_decode($campo['nb_primer_apellido'])),
                utf8_decode($campo['fecha02']),
                utf8_decode($campo['in_activo']),
                utf8_decode(mb_convert_case($campo['fecha015'], MB_CASE_TITLE)),
                utf8_decode($campo['co_solicitud']),
                utf8_decode($campo['nu_cuenta_bancaria']),
                mb_convert_case(utf8_decode($campo['co_banco']), MB_CASE_TITLE),
                utf8_decode($campo['cargo_codigo']),
                utf8_decode($campo['tx_cargo']),
                utf8_decode($campo['estruc_codigo']),
                utf8_decode($campo['tx_nom_estructura_administrativa']),
                utf8_decode($campo['mo_salario_base'])

            ), 1, 1, 'R');


            $numero = $numero + 1;
        }

    }

    function ChapterTitle($num, $label)
    {
        $this->SetFont('Arial', '', 10);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(0, 6, "$label", 6, 1, 'L', 1);
        $this->Ln(8);
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

    function SetTitle($title)
    {
        $this->title = $title;
    }

    function PrintChapter()
    {
        $this->AddPage();
        $this->ChapterBody();
    }

    function getOP()
    {

        $conex = new ConexionComun();

        //respaldo 3
        if ($_GET["co_tipo"] == 1) {
            $condicion .= " tbrh015_nom_trabajador.fe_ingreso >= '" . $_GET["fe_inicio"] . "' and ";
            $condicion .= " tbrh015_nom_trabajador.fe_ingreso <= '" . $_GET["fe_fin"] . "' ";
            $condicion2 .= "tbrh015_nom_trabajador.fe_ingreso";
        } else if ($_GET["co_tipo"] == 2) {
            $condicion .= " tbrh105_ingreso_trabajador.created_at >= '" . $_GET["fe_inicio"] . "' and ";
            $condicion .= " tbrh105_ingreso_trabajador.created_at <= '" . $_GET["fe_fin"] . "' ";
            $condicion2 .= "tbrh105_ingreso_trabajador.created_at";
        }

        $sql = " 
        select 
tx_grupo_nomina, nu_cedula, nb_primer_nombre, nb_primer_apellido,tbrh002_ficha.fe_ingreso AS fecha02,tbrh002_ficha.in_activo, tbrh015_nom_trabajador.fe_ingreso AS fecha015,tbrh105_ingreso_trabajador.co_solicitud,
nu_cuenta_bancaria,co_banco,tbrh032_cargo.nu_codigo AS cargo_codigo,tx_cargo,tbrh005_estructura_administrativa.nu_codigo AS estruc_codigo,
tx_nom_estructura_administrativa,mo_salario_base

from tbrh001_trabajador, tbrh015_nom_trabajador, tbrh002_ficha, tbrh067_grupo_nomina,tbrh032_cargo, tbrh009_cargo_estructura, tbrh005_estructura_administrativa, tbrh105_ingreso_trabajador


where 
tbrh067_grupo_nomina.co_grupo_nomina = tbrh015_nom_trabajador.co_grupo_nomina and
tbrh015_nom_trabajador.co_ficha = tbrh002_ficha.co_ficha and
tbrh002_ficha.co_trabajador = tbrh001_trabajador.co_trabajador and
tbrh032_cargo.co_cargo = tbrh009_cargo_estructura.co_cargo and
tbrh009_cargo_estructura.co_cargo_estructura = tbrh015_nom_trabajador.co_cargo_estructura and
tbrh009_cargo_estructura.co_estructura_administrativa = tbrh005_estructura_administrativa.co_estructura_administrativa and
tbrh002_ficha.in_activo = true and
tbrh015_nom_trabajador.in_activo = true and
tbrh105_ingreso_trabajador.in_delete IS NOT TRUE and
tbrh105_ingreso_trabajador.co_ficha = tbrh002_ficha.co_ficha and" . $condicion . 'order by ' . $condicion2;

        // echo $sql; exit();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return $datosSol;

    }

}
/*
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
*/

$pdf = new PDF('L', 'mm', 'Legal');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>