<?php
include("ConexionComun.php");
include('fpdf.php');
include('tcpdf/tcpdf.php');


class PDF extends FPDF
{
    public $title;
    public $conexion;
    function Header()
    {

        $this->empresa = $this->getDatosEmpresa(1);

        if (!empty($this->empresa['tx_imagen_cen'])) {
            $this->Image("imagenes/" . $this->empresa['tx_imagen_cen'],  $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
        }

        $this->SetFont('Arial', 'B', 8);

        $this->SetTextColor(0, 0, 0);
        $this->SetY(12);
        $this->Cell(0, 0, utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'), 0, 0, 'C');
        $this->Ln(4);       
        $this->Cell(0, 0, utf8_decode($this->empresa['nb_empresa']), 0, 0, 'C');
        $this->Ln(4);
        if (!empty($this->empresa['nb_institucion'])) 
        {
            $this->Cell(0, 0, utf8_decode($this->empresa['nb_institucion']), 0, 0, 'C');
            $this->Ln(4);
        }
        $this->Cell(0, 0, utf8_decode('DIRECCIÓN DE ADMINISTRACIÓN Y FINANZAS'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('RIF. ' . $this->empresa['tx_rif']), 0, 0, 'C');
        $this->Ln(12);
        $this->SetFont('Arial', 'B', 14);

        $this->Cell(0, 0, utf8_decode('CERTIFICACIÓN DE DISPONIBILIDAD PRESUPUESTARIA'), 0, 0, 'C');

        //    $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');

        $this->Ln(5);
        $this->SetTextColor(0, 0, 0);
        $this->SetX(1);

        $this->Ln(2);
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
        $y =  $this->getY() * 20;
        $x =  $this->getX();
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

        $this->op_reporte = $this->getOpcionReporte($_GET['codigo']);

        $this->Ln(1);
        $this->datos = $this->getOrden();

        $this->Ln(15);
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 0, utf8_decode('Ciudadano(a): ' . $this->datos['nb_usuario']), 0, 0, 'L');
        $this->Ln(5);
        $this->SetX(20);
        //$this->Cell(0,0,utf8_decode($this->datos['tx_proceso']),0,0,'L');
        //$this->Cell(0,0,utf8_decode('DIRECTOR DE COMPRAS Y SUMINISTRO'),0,0,'L');
        $this->Cell(0, 0, utf8_decode($this->op_reporte['ciudadano']), 0, 0, 'L');
        $this->Ln(5);
        $this->SetX(20);
        $this->Cell(0, 0, utf8_decode('Su despacho.-'), 0, 0, 'L');

        $this->Ln(10);
        $this->SetTextColor(0, 0, 0);
        $this->SetX(1);


        $this->SetY(100);
        $this->SetX(20);
        $this->SetFont('Arial', '', 10);
        $montoletra = numtoletras($this->datos['monto'], 1);
        $montonum = number_format($this->datos['monto'], 2, ',', '.');

        $html = 'Por medio de la presente se CERTIFICA LA DISPONIBILIDAD PRESUPUESTARIA contemplada en el presente ejercicio fiscal, la cantidad de ' . $montoletra . ' (' . $montonum . ') correspondiente a recursos de ' . $this->datos['tx_fuente_financiamiento'] . ', para: ';


        $this->MultiCell(170, 5, utf8_decode($html), 0, 1, 'J', 1);

        $this->SetFont('Arial', 'B', 10);
        $this->Ln(5);
        $this->SetX(20);
        $this->MultiCell(170, 5, utf8_decode('Descripción:') . $this->datos['concepto'], 0, 1, 'C', 1);
        $this->SetFont('Arial', '', 10);
        $this->Ln(5);
        $this->SetX(20);
        $this->MultiCell(170, 5, utf8_decode('A continuación se describen las partidas presupuestarias: '), 0, 1, 'L', 1);


        $this->SetWidths(array(180));
        $this->SetAligns(array("C"));
        $this->SetFillColor(201, 199, 199);
        $this->Ln();
        $this->SetFont('Arial', 'B', 9);
        $this->SetX(20);
        $this->Row(array(utf8_decode('PARTIDAS ASOCIADAS')), 1, 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 8);
        $this->SetAligns(array("C", "C", "C"));
        $this->SetWidths(array(70, 80, 30));
        $this->SetX(20);
        $this->Row(array('PARTIDA', 'DENOMINACION', 'MONTO (Bs.)'), 1, 1);
        $this->SetAligns(array("C", "L", "R"));
        $this->SetFont('Arial', '', 8);
        $this->lista_partidas = $this->getPartidas();
        foreach ($this->lista_partidas as $key => $campo) {
            $this->SetX(20);
            $this->Row(array($campo['co_categoria'], utf8_decode($campo['de_partida']), number_format($campo['monto'], 2, ',', '.')), 1, 1);
        }



        $this->ln();
        $this->SetX(20);
        $this->SetWidths(array(170));
        $this->SetAligns(array("L"));
        $this->SetFont('Arial', '', 10);
        $this->Cell(170, 5, utf8_decode('Sin más a que hacer referencia, me despido de usted.'), 0, 0, 'L');
        $this->ln(25);
        $this->SetX(20);
        $this->Cell(170, 5, utf8_decode('Atentamente'), 0, 0, 'C');


        $this->ln(35);
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 10);
        //$this->Cell(170,5,utf8_decode('SUBSECRETARIA DE PRESUPUESTO'),0,0,'C'); 
        $this->Cell(170, 5, utf8_decode($this->op_reporte['cargo_firma']), 0, 0, 'C');
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
        $this->title   = $title;
    }

    function PrintChapter()
    {
        $this->AddPage();
        $this->ChapterBody();
    }



    function getOrden()
    {

        $conex = new ConexionComun();

        $sql = "select sum(tb053.monto) as monto, tb052.tx_observacion, upper(tb039.tx_concepto) as concepto,
                  upper(tx_fuente_financiamiento) as tx_fuente_financiamiento
                  from   tb052_compras as tb052 
                  left join tb039_requisiciones as tb039 on tb039.co_solicitud = tb052.co_solicitud
                  left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras                   
                  left join tb056_contrato_compras as tb056 on tb056.co_compras = tb052.co_compras
                  left join tb073_fuente_financiamiento as tb073 on tb073.co_fuente_financiamiento = tb056.co_fuente_financiamiento                  
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud and tb030.in_cargar_dato is true
                  where tb030.co_ruta = " . $_GET['codigo'] . " group by tb052.co_compras, tx_fuente_financiamiento, concepto
                   ";


        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];
    }

    function getPartidas()
    {

        $conex = new ConexionComun();

        $sql = "select distinct tb083.id_tb013_anio_fiscal||'-'||tb082.nu_ejecutor||'-'||tb085.co_categoria as co_categoria,
                         tb085.de_partida,
                         case when (tb053.in_calcular_iva) then tb053.monto else tb052.monto_iva end as monto,
                         tb053.co_detalle_compras
                  from   tb052_compras as tb052 
                  left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras
                  left join tb085_presupuesto as tb085 on (tb085.id = tb053.co_presupuesto)
                  left join tb084_accion_especifica as tb084 on tb085.id_tb084_accion_especifica = tb084.id
                  left join tb083_proyecto_ac as tb083 on tb084.id_tb083_proyecto_ac = tb083.id
                  left join tb082_ejecutor tb082 on tb082.id = tb083.id_tb082_ejecutor
                  left join tb001_usuario as tb001 on tb001.co_ejecutor = tb082.id
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud and tb030.in_cargar_dato is true                              
                  where tb030.co_ruta = " . $_GET['codigo'] . " order by tb053.co_detalle_compras asc"; //$conex->decrypt($_GET['codigo']);

        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol;
    }

    function getDatosEmpresa($codigo)
    {

        $sql = "SELECT co_empresa, nb_empresa, co_estado, co_municipio, tx_rif, tx_nit, nb_institucion,
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
        return  $datosSol[0];
    }

    function getOpcionReporte($ruta)
    {

        $sql = "SELECT tb030.co_ruta, op_reporte,
        op_reporte->>'cargo_firma' as cargo_firma,
        op_reporte->>'ciudadano' as ciudadano
        FROM tb030_ruta as tb030
        INNER JOIN tb032_configuracion_ruta AS tb032 ON tb030.co_tipo_solicitud = tb032.co_tipo_solicitud AND tb030.co_proceso = tb032.co_proceso
        WHERE tb030.co_ruta = " . $ruta;

        //echo $sql; exit();

        $conex = new ConexionComun();

        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];
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
$pdf->Output();*/
