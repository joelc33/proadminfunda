<?php
include("ConexionComun.php");
//include('fpdf.php');
require('flowing_block.php');


class PDF_Flo extends PDF_FlowingBlock
{
    public $title;
    public $conexion;
    
    function SetLineStyle($style)
    {
        extract($style);
        if (isset($width)) {
            $width_prev = $this->LineWidth;
            $this->SetLineWidth($width);
            $this->LineWidth = $width_prev;
        }
        if (isset($cap)) {
            $ca = array('butt' => 0, 'round' => 1, 'square' => 2);
            if (isset($ca[$cap]))
                $this->_out($ca[$cap] . ' J');
        }
        if (isset($join)) {
            $ja = array('miter' => 0, 'round' => 1, 'bevel' => 2);
            if (isset($ja[$join]))
                $this->_out($ja[$join] . ' j');
        }
        if (isset($dash)) {
            $dash_string = '';
            if ($dash) {
                $tab = explode(',', $dash);
                $dash_string = '';
                foreach ($tab as $i => $v) {
                    if ($i > 0)
                        $dash_string .= ' ';
                    $dash_string .= sprintf('%.2F', $v);
                }
            }
            if (!isset($phase) || !$dash)
                $phase = 0;
            $this->_out(sprintf('[%s] %.2F d', $dash_string, $phase));
        }
        if (isset($color)) {
            list($r, $g, $b) = $color;
            $this->SetDrawColor($r, $g, $b);
        }
    }
    function RoundedRect($x, $y, $w, $h, $r, $round_corner = '1111', $style = '', $border_style = null, $fill_color = null)
    {
        if ('0000' == $round_corner) // Not rounded
            $this->Rect($x, $y, $w, $h, $style, $border_style, $fill_color);
        else { // Rounded
            if (!(false === strpos($style, 'F')) && $fill_color) {
                list($red, $g, $b) = $fill_color;
                $this->SetFillColor($red, $g, $b);
            }
            switch ($style) {
                case 'F':
                    $border_style = null;
                    $op = 'f';
                    break;
                case 'FD':
                case 'DF':
                    $op = 'B';
                    break;
                default:
                    $op = 'S';
                    break;
            }
            if ($border_style)
                $this->SetLineStyle($border_style);

            $MyArc = 4 / 3 * (sqrt(2) - 1);

            $this->_Point($x + $r, $y);
            $xc = $x + $w - $r;
            $yc = $y + $r;
            $this->_Line($xc, $y);
            if ($round_corner[0])
                $this->_Curve($xc + ($r * $MyArc), $yc - $r, $xc + $r, $yc - ($r * $MyArc), $xc + $r, $yc);
            else
                $this->_Line($x + $w, $y);

            $xc = $x + $w - $r;
            $yc = $y + $h - $r;
            $this->_Line($x + $w, $yc);

            if ($round_corner[1])
                $this->_Curve($xc + $r, $yc + ($r * $MyArc), $xc + ($r * $MyArc), $yc + $r, $xc, $yc + $r);
            else
                $this->_Line($x + $w, $y + $h);

            $xc = $x + $r;
            $yc = $y + $h - $r;
            $this->_Line($xc, $y + $h);
            if ($round_corner[2])
                $this->_Curve($xc - ($r * $MyArc), $yc + $r, $xc - $r, $yc + ($r * $MyArc), $xc - $r, $yc);
            else
                $this->_Line($x, $y + $h);

            $xc = $x + $r;
            $yc = $y + $r;
            $this->_Line($x, $yc);
            if ($round_corner[3])
                $this->_Curve($xc - $r, $yc - ($r * $MyArc), $xc - ($r * $MyArc), $yc - $r, $xc, $yc - $r);
            else {
                $this->_Line($x, $y);
                $this->_Line($x + $r, $y);
            }
            $this->_out($op);
        }
    }

    function _Point($x, $y)
    {
        $this->_out(sprintf('%.2F %.2F m', $x * $this->k, ($this->h - $y) * $this->k));
    }

    function _Line($x, $y)
    {
        $this->_out(sprintf('%.2F %.2F l', $x * $this->k, ($this->h - $y) * $this->k));
    }

    function _Curve($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c', $x1 * $this->k, ($this->h - $y1) * $this->k, $x2 * $this->k, ($this->h - $y2) * $this->k, $x3 * $this->k, ($this->h - $y3) * $this->k));
    }
    function Line($x1, $y1, $x2, $y2, $style = null)
    {
        if ($style)
            $this->SetLineStyle($style);
        parent::Line($x1, $y1, $x2, $y2);
    }
    
    function Header() {

        $this->empresa = $this->getDatosEmpresa(1);
        $this->datos = $this->getPagos();

        if (!empty($this->empresa['tx_imagen_izq'])) {
            $this->Image("imagenes/" . $this->empresa['tx_imagen_izq'], $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
        }

        $this->SetFont('Arial', 'B', 9);
        $this->SetTextColor(0, 0, 0);
        $this->SetY(12);
        $this->Cell(0, 0, utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode($this->empresa['nb_empresa']), 0, 0, 'C');
        $this->Ln(4);
        if (!empty($this->empresa['nb_institucion'])) {
            $this->Cell(0, 0, utf8_decode($this->empresa['nb_institucion']), 0, 0, 'C');
            $this->Ln(4);
        }
        $this->Cell(0, 0, utf8_decode('RIF. ' . $this->empresa['tx_rif']), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('DIRECCIÓN DE ADMINISTRACIÓN Y FINANZAS'), 0, 0, 'C');
         $this->Ln(10);
         $this->Cell(0,0,utf8_decode('TRANSFERENCIA TERCEROS #'.$this->datos['nu_serial_pago']),0,0,'C');      
     

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
        $montopagado = number_format($this->datos['mo_pagado'], 2, ',','.');
         $style = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0);
                          
         $this->AddPage();
        $this->Ln(5);
        $this->SetFont('Arial','',8);
        $this->Cell(0,0,utf8_decode('Fecha Transferencia: '.$this->datos['fe_emision']),0,0,'R');
 
         $this->Ln(5);
         $this->RoundedRect(10, 50, 200, 15, 0.5, '1001', '', $style);
              $this->Ln(5);
          $this->SetFont('Arial','',8);
         $this->SetX(25);
         $this->Cell(200,5,utf8_decode('MONTO A PAGAR POR TRANSFERENCIA   ...............................................BS. '),0,0,'L');
         $this->Cell(0,5,$montopagado.' *****',0,0,'R');
        
         $this->Ln(5);
         $this->SetX(25);
         $montoLetra = numtoletras($this->datos['mo_pagado'], 1);
         $this->MultiCell(200,5,utf8_decode('LA CANTIDAD DE: '.$montoLetra),0,1,'L',1);
         $this->Ln(5);
         $this->SetX(25);
         $this->MultiCell(200,5,utf8_decode('BENEFICIARIO DE LA TRANSFERENCIA'),0,1,'L',1);
         
          $this->Ln(5);
         $this->RoundedRect(10, 75, 200, 10, 0.5, '1001', '', $style);
         
         $this->SetX(25);
         $this->MultiCell(200,5,utf8_decode($this->datos['tx_rif'].' - '.$this->datos['tx_razon_social']),0,1,'L',1);
         
         $this->Ln(5);
         $this->RoundedRect(10, 95, 95, 15, 0.5, '1001', '', $style);
         $this->RoundedRect(11, 96, 93, 13, 0.5, '1001', '', $style);
         
         $this->SetX(25);
         $this->Cell(200,5,utf8_decode('BANCO Y CUENTA DESTINO'),0,0,'L');
         $this->SetX(80);
         $this->Cell(200,5,utf8_decode('MONTO'),0,0,'L');

         $this->RoundedRect(115, 95, 95, 15, 0.5, '1001', '', $style);
         $this->RoundedRect(116, 96, 93, 13, 0.5, '1001', '', $style);

         $this->SetX(125);
         $this->Cell(200,5,utf8_decode('BANCO Y CUENTA ORIGEN'),0,0,'L');
         $this->SetX(183);
         $this->Cell(200,5,utf8_decode('MONTO'),0,0,'L');  
         
         $this->Ln(10);
         $this->SetX(25);
         $this->Cell(200,5,utf8_decode($this->datos['tx_banco_proveedor']),0,0,'L');
         $this->SetX(125);
         $this->Cell(200,5,utf8_decode($this->datos['tx_banco']),0,0,'L');         
          $this->Ln(5);
         $this->SetX(25);
         $this->Cell(200,5,$this->datos['nu_cuenta_bancaria'],0,0,'L');
         $this->SetX(80);
         $this->Cell(200,5,$montopagado,0,0,'L'); 
         

         $this->SetX(125);
         $this->Cell(200,5,$this->datos['tx_cuenta_bancaria'],0,0,'L');
         $this->SetX(183);
         $this->Cell(200,5,$montopagado,0,0,'L'); 
         
         $this->Ln(10);
         $this->RoundedRect(10, 120, 200, 10, 0.5, '1001', '', $style);
         
         $this->SetX(25);
         $this->Cell(200,5,utf8_decode('MOTIVO DE LA TRANSFERENCIA'),0,0,'L');   
         $this->Ln(10);
         $this->SetX(25);
         $this->MultiCell(200,5,utf8_decode($this->datos['de_observacion']),0,1,'L',1); 
         
          $this->RoundedRect(10, 135, 200, 10, 0.5, '1001', '', $style);
          $this->RoundedRect(11, 136, 198, 8, 0.5, '1001', '', $style);
         $this->Ln(10); 
         $this->SetX(25);
         $this->Cell(200,5,utf8_decode('ORDEN DE PAGO'),0,0,'L');
         $this->SetX(80);
         $this->Cell(200,5,utf8_decode('DEDUCCIÓN'),0,0,'L');          
         $this->SetX(153);
         $this->Cell(200,5,utf8_decode('TOTAL DEDUCCIONES'),0,0,'L');
         
          $this->RoundedRect(10, 150, 200, 50, 0.5, '1001', '', $style);
          
        $this->lista_retenciones = $this->getDeducciones($this->datos['co_orden_pago']);
        
        if ($this->lista_retenciones) {
        $j = 1;
            foreach ($this->lista_retenciones as $key => $campo1) {
                if ($j == 1) {
        $this->Ln(15);
         $this->SetX(25);
         $this->Cell(200,5,utf8_decode($this->datos['tx_serial']),0,0,'L');
         $this->SetX(80);
         $this->Cell(200,5,utf8_decode($campo1["tx_tipo_retencion"]),0,0,'L');
         $this->SetX(153);
         $this->Cell(200,5,number_format($campo1["mo_retencion"], 2, ',','.'),0,0,'L');
          $j++;
                } else {
         $this->Ln(5);
         $this->SetX(80);
         $this->Cell(200,5,utf8_decode($campo1["tx_tipo_retencion"]),0,0,'L');
         $this->SetX(153);
         $this->Cell(200,5,number_format($campo1["mo_retencion"], 2, ',','.'),0,0,'L');
                    
                }

            }
        } else {

         $this->Ln(15);
         $this->SetX(25);
         $this->Cell(200,5,utf8_decode($this->datos['tx_serial']),0,0,'L');
        }          
          
          
          
          $this->RoundedRect(10, 205, 65, 20, 0.5, '1001', '', $style);
          $this->RoundedRect(77, 205, 65, 20, 0.5, '1001', '', $style);
          $this->RoundedRect(144, 205, 66, 20, 0.5, '1001', '', $style);
          
         $this->SetY(207); 
         $this->SetX(20);
         $this->Cell(200,5,utf8_decode('AUTORIZADO POR:'),0,0,'L');
         $this->SetX(80);
         $this->Cell(200,5,utf8_decode('AUTORIZADO POR:'),0,0,'L');          
         $this->SetX(150);
         $this->Cell(200,5,utf8_decode('ELABORADO POR:'),0,0,'L');
         
         $this->SetY(220); 
         $this->SetX(20);
         $this->Cell(200,5,utf8_decode('PRESIDENTE'),0,0,'L');
         $this->SetX(80);
         $this->Cell(200,5,utf8_decode('ADMINISTRADOR'),0,0,'L');          
         $this->SetX(150);
         $this->Cell(200,5,utf8_decode('TESORERÍA'),0,0,'L');          
          
          
          $this->RoundedRect(10, 230, 65, 13, 0.5, '1001', '', $style);
          $this->RoundedRect(77, 230, 65, 13, 0.5, '1001', '', $style);
          $this->RoundedRect(144, 230, 66, 13, 0.5, '1001', '', $style);     

         $this->SetY(232); 
         $this->SetX(20);
         $this->Cell(200,5,utf8_decode('NOMBRE Y APELLIDO'),0,0,'L');
         $this->SetX(80);
         $this->Cell(200,5,utf8_decode('C.I. O RIF'),0,0,'L');          
         $this->SetX(150);
         $this->Cell(200,5,utf8_decode('RECIBE CONFORME'),0,0,'L');          
          

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
        //$this->AddPage();
        $this->ChapterBody();
    }

    function getPagos(){

          $conex = new ConexionComun();     
          $sql = " select tb008.tx_razon_social,
                          tb008.nb_representante_legal,
                         inicial||'-'||tb008.tx_rif as tx_rif,
                         tb008.nu_cuenta_bancaria,
                         to_char(tb063.fe_pago,'dd-mm-yyyy') as fe_emision,
                         tb062.mo_pagar,
                         tb062.mo_pendiente,
                         tb063.nu_monto as mo_pagado,
                         to_char(tb063.fe_pago,'dd') as dia,
                         to_char(tb063.fe_pago,'mm') as mes,
                         to_char(tb063.fe_pago,'yyyy') as anio,                          
                         tb001.nb_usuario,
                         tb063.nu_serial_pago,
                         tb010.tx_banco,
                         tb010a.tx_banco as tx_banco_proveedor,
                         tx_cuenta_bancaria,
                         de_observacion,
                         tb060.co_orden_pago,
                         tb060.tx_serial
                   FROM tb026_solicitud as tb026     
                   left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud
                   left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor
                   left join tb063_pago as tb063 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago
                   left join tb001_usuario as tb001 on tb001.co_usuario = tb063.co_usuario 
                   left join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
                   left join tb010_banco as tb010 on tb010.co_banco = tb063.co_banco
                   left join tb010_banco as tb010a on tb010a.co_banco = tb008.co_banco
                   left join tb011_cuenta_bancaria as tb011 on tb011.co_cuenta_bancaria = tb063.co_cuenta_bancaria
                   left join tb155_cuenta_bancaria_historico as tb155 on tb155.co_solicitud = tb026.co_solicitud
                   left join tb060_orden_pago as tb060 on tb060.co_orden_pago = tb062.co_odp
                   where tb063.co_pago = ".$_GET['codigo'];

                               
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];                         
    }

    function getDeducciones($co_odp){

	  $conex = new ConexionComun();
          $sql = "select distinct  nu_factura,
                          mo_retencion,
                          case when tb046.co_tipo_retencion = 92 then substr(tx_tipo_retencion,1,230)||' '||po_retencion||' %'  else substr(tx_tipo_retencion,1,230) end as tx_tipo_retencion
                  from   tb045_factura as tb045     
                  left join tb046_factura_retencion as tb046 on tb046.co_factura = tb045.co_factura
                  left join tb041_tipo_retencion as tb041 on tb041.co_tipo_retencion = tb046.co_tipo_retencion
                  where mo_retencion<>0 and tb045.in_anular is null and tb045.co_odp =  ".$co_odp;                       
           
          return $conex->ObtenerFilasBySqlSelect($sql);  
    }

    function getDatosEmpresa( $codigo){

        $sql = "SELECT co_empresa, nb_empresa, co_estado, co_municipio, tx_rif, tx_nit,nb_institucion, 
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
        WHERE co_empresa = ".$codigo.";";

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];
  
    }
    
}

$pdf = new PDF_Flo('P', 'mm', 'letter');
$pdf->AliasNbPages();
$pdf->PrintChapter();

$comm = new ConexionComun();
$ruta = $comm->getRuta();

//rmdir($ruta);
//mkdir($ruta, 0777, true);    
/*
$dir="$ruta".$_GET["codigo"].".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";


$update = "update tb030_ruta set tx_ruta_reporte = '".$dir."' where co_ruta = ".$_GET['codigo']; //$comm->decrypt($_GET["codigo"]);

//echo $update; exit();
$comm->Execute($update);    

$pdf->Output($dir, 'F');
*/

$pdf = new PDF_Flo('P', 'mm', 'letter');
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
