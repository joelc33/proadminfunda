<?php
include("ConexionComun.php");
require('flowing_block.php');


class PDF_Flo extends PDF_FlowingBlock
{

    function ChapterBody()
    {

        $this->datos = $this->getAyuda();

        $this->Image("imagenes/logosedezul.jpg", 85, 5, 46);

      
        $this->SetFont('Arial', 'B', 8);

        $this->SetTextColor(0, 0, 0);
        $this->SetY(32);
        $this->Cell(0, 0, utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('SERVICIO DESCONCENTRADO PARA LOS CENTROS ASISTENCIALES'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('DE SALUD DEL ESTADO ZULIA'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('RIF. G-20007909-6'), 0, 0, 'C');
        $this->Ln(4);
        $this->line(20, 50, 190, 50);
        $this->Ln(10);

        $this->Ln();
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(0, 0, utf8_decode('RESOLUCIÓN Nro.: ') . $this->datos['nu_resolucion'], 0, 0, 'L');

        $this->Ln(5);

        $this->SetFont('Arial', 'BI', 10);

        $this->Cell(0, 0, utf8_decode('MARACAIBO ') . date("d/m/Y", strtotime($this->datos['fe_resolucion'])), 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(0, 0, utf8_decode('214° y 265°'), 0, 0, 'C');

        $this->Ln(1);
        $this->SetFont('Arial', 'BI', 14);
        $this->SetFillColor(255, 255, 255);
        $this->SetAligns(array("L", "L"));
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));
        $this->SetY(75);

        $this->Row(array(utf8_decode('RESUELTO')), 0, 0);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial', '', 10);
        $this->Ln(8);
        $this->SetX(20);
        $this->SetLeftMargin(20);
        $this->SetRightMargin(10);

        $this->newFlowingBlock(170, 8, '', 'J');

        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $this->WriteFlowingBlock(utf8_decode('Por disposición del '));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $this->WriteFlowingBlock('CIUDADANO GOBERNADOR DEL ESTADO ZULIA');

        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $data = ", eróguese por la Tesorería del Estado, con cargo a Unidad Ejecutora " . 
                $this->datos['nu_ejecutor'] . 
                ", Sector " . $this->datos['nu_sector'] . 
                ", Proyecto / A.C. " . $this->datos['nu_proyecto_ac'] . 
                ", Acción Específica " . $this->datos['nu_accion_especifica'].
                ", Partida " . $this->datos['nu_pa']. 
                ", Genérica " . $this->datos['nu_ge']. 
                ", Específica " . $this->datos['nu_es']. 
                ", Subespecífica " . $this->datos['nu_se'].
                ", de la vigente Ley de Presupuesto la cantidad de ";
        $this->SetX(20);
        $this->WriteFlowingBlock(utf8_decode($data));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $montoletras = numtoletras($this->datos['monto'], 1);
        $this->SetX(20);
        $this->WriteFlowingBlock(utf8_decode($montoletras));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 10);
        $monto = " (Bs. " . number_format($this->datos['monto'], 2, ',', '.') . ")";
        $this->SetX(20);
        $this->WriteFlowingBlock($monto);

        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $data = ", por concepto de ";
        $this->WriteFlowingBlock(utf8_decode($data));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $data = $this->datos['tx_tipo_ayuda'];
        $this->WriteFlowingBlock(utf8_decode($data));

        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $data = ", que concede el Gobierno Regional a";
        $this->WriteFlowingBlock(utf8_decode($data));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $beneficiado = $this->datos['nomb_sol'];
        $this->WriteFlowingBlock(utf8_decode($this->datos['tx_razon_social']));

        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $data = ", titular de la titular de la C.I./RIF Nro. ";
        $this->WriteFlowingBlock(utf8_decode($data));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $this->WriteFlowingBlock(utf8_decode($this->datos['inicial'].'-'.$this->datos['tx_rif']));

        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $data = ", como apoyo ";
        $this->WriteFlowingBlock(utf8_decode($data));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $motivo = strtoupper($this->datos['tx_observacion']);
        $this->WriteFlowingBlock(utf8_decode($motivo));

        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $data = ". Tal suma será pagada a ";
        $this->WriteFlowingBlock(utf8_decode($data));

        
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $receptor = $this->datos['proveedor'];;
        $this->WriteFlowingBlock(utf8_decode($receptor));


        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $receptor = " C.I./RIF ";
        $this->WriteFlowingBlock(utf8_decode($receptor));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $receptor =  $this->datos['inicia_proveedor'] . "-" . $this->datos['rif_proveedor'];
        $this->WriteFlowingBlock(utf8_decode($receptor));


        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $data = ", para los fines antes indicados. En tal sentido  se otorgará con cargos a la partida antes mencionada";
        $this->WriteFlowingBlock(utf8_decode($data));


        $this->SetX(20);
        $this->finishFlowingBlock();

        $this->Ln(20);
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(20);
        $this->Cell(0, 0, utf8_decode('Regístrese y Comuníquese'), 0, 0, 'L');
        /*$this->Ln(20);
        $this->SetX(20);
        $this->Cell(0, 0, utf8_decode('LA SECRETARIA DE ADMINISTRACIÓN Y FINANZAS'), 0, 0, 'L');
        $this->Ln(5);
        $this->SetX(20);
        $this->Cell(0, 0, utf8_decode('L.S.(FDO.) LCDA. RAISA BRICEÑO'), 0, 0, 'L');

        $this->Ln(50);
        $this->SetX(20);
        $this->Cell(0, 0, utf8_decode('Usuario del sistema: ' . $this->datos['nb_usuario']), 0, 0, 'L');*/

    }

    function getAyuda()
    {

        $conex = new ConexionComun();

        $sql = "SELECT tb082.nu_ejecutor, 
                        tb080.nu_sector, 
                        tb083.nu_proyecto_ac,
                        tb084.nu_accion_especifica, 	   
                        tb085.nu_pa, 
                        tb085.nu_ge, 
                        tb085.nu_es, 
                        tb085.nu_se, 
                        tb085.nu_sse, 
                        tb053.monto, 
                        tb008.tx_razon_social,
                        tb008.tx_rif,
                        tb007.inicial,
                        tb126.tx_observacion,
                        tb008p.tx_razon_social as proveedor,
                        tb008p.tx_rif as rif_proveedor,
                        tb007p.inicial as inicia_proveedor,
                        tb126.nu_resolucion,
	                    tb127.tx_tipo_ayuda,
                        fe_resolucion
                    FROM public.tb030_ruta as tb030 
                        join tb052_compras as tb052 on (tb030.co_solicitud = tb052.co_solicitud)
                        join tb053_detalle_compras as tb053 on (tb053.co_compras = tb052.co_compras)
                        join tb085_presupuesto as tb085 on (tb085.id = tb053.co_presupuesto)
                        join tb084_accion_especifica as tb084 on (tb085.id_tb084_accion_especifica = tb084.id)
                        join tb083_proyecto_ac as tb083 on (tb084.id_tb083_proyecto_ac = tb083.id)
                        join tb082_ejecutor as tb082 on (tb082.id = tb083.id_tb082_ejecutor)
                        join tb080_sector as tb080 on (tb080.id = tb083.id_tb080_sector)
                        join tb126_solicitud_ayuda as tb126 on (tb126.co_solicitud = tb030.co_solicitud)
                        join tb127_tipo_ayuda as tb127 on (tb127.co_tipo_ayuda = tb126.co_tipo_ayuda)
                        join tb008_proveedor as tb008 on (tb008.co_proveedor = tb126.co_proveedor_solicitante)
                        join tb007_documento as tb007 on (tb007.co_documento = tb008.co_documento)
                        join tb008_proveedor as tb008p on (tb008p.co_proveedor = tb126.co_proveedor)
                        join tb007_documento as tb007p on (tb007p.co_documento = tb008p.co_documento)
                    where co_ruta = ". $_GET['codigo']; //$conex->decrypt($_GET['codigo']);

        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return $datosSol[0];
    }


}



$pdf = new PDF_Flo('P', 'mm', 'letter');
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->ChapterBody();
//$pdf->Output();


$comm = new ConexionComun();
$ruta = $comm->getRuta();
//rmdir($ruta);
//mkdir($ruta, 0777, true);    

$dir = "$ruta" . $_GET["codigo"] . ".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";

$update = "update tb030_ruta set tx_ruta_reporte = '" . $dir . "' where co_ruta = " . $_GET['codigo']; //$comm->decrypt($_GET["codigo"]);


$comm->Execute($update);
$pdf->SetMargins(0, 0);
$pdf->Output($dir, 'F');



?>