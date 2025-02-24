<?php
include("ConexionComun.php");
require('flowing_block.php');


class PDF_Flo extends PDF_FlowingBlock
{

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

    function Footer()
    {
        $this->SetFont('Times', '', 9);
        $this->SetY(-20);
        $this->Cell(0, 0, utf8_decode(''), 0, 0, 'C');
    }

    function Header()
    {

       
    }

    function ChapterBody()
    {
       

        $datos_empresa = $this->getDatosEmpresa();


         //***** Primer emblema izq ******//
         $this->SetFillColor(255, 255, 255);

         //$this->RoundedRect(posX, posY, ancho, alto, redondeo, 1=EsqRecta-0=EsqRedondeada(1digitosporEsquina), estiloEsquinas, estiloLinea, colorRelleno);
//         $this->Image("imagenes/escudosanfco.jpg", 16, 16, 17);
         $this->SetFont('Times', 'B', 8);
         $this->SetTextColor(0, 0, 0);
         $this->SetY(15);
         $this->SetX(15);
         $this->SetWidths(array(180));
         $this->SetAligns(array("L"));
         $this->Row(array(utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA')), 0, 0);
         $this->SetX(15);
         $this->Row(array(utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA')), 0, 0);
         $this->SetX(15);
         $this->Row(array(utf8_decode($datos_empresa["nb_institucion"])), 0, 0);
         $this->SetX(15);
         $this->Row(array(utf8_decode('RIF: '.$datos_empresa["tx_rif"])), 0, 0);
 
      
         //***** Segundo emblema izq ******//
         $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));
         $this->RoundedRect(15, 37, 90, 30, 3.5, '1111', 'DF', $style);
 
         $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));
         $this->RoundedRect(110, 37, 90, 30, 3.5, '1111', 'DF', $style);
 
         $this->Ln(2);

        $this->datos = $this->getOrdenes();
        $this->SetFont('Times', 'B', 12);

        $this->SetY(15);
        $this->SetX(107);
      
        $this->SetFont('Times', '', 10);
        $this->SetWidths(array(55, 35));
        $this->SetAligns(array("L", "L"));

        //-------------
        $this->newFlowingBlock(90, 5, '', 'R');
        $this->SetFont('Times', 'B', 8);
        if($this->datos['in_contrato']=='t'){
        $this->WriteFlowingBlock(utf8_decode('CONTRATO N° ').': '.$this->datos['numero_compra']);
        }else{
        if($this->datos['co_tipo_solicitud']==1){
        $this->WriteFlowingBlock(utf8_decode('ORDEN DE COMPRA ').': '.$this->datos['numero_compra']);    
        }else{    
        $this->WriteFlowingBlock(utf8_decode('CONTRATO N ').': '.$this->datos['numero_compra']);  
        }
        }
        $this->finishFlowingBlock();


        $this->newFlowingBlock(30, 5, '', 'L');
        $this->SetFont('Times', 'B', 8);
        $this->WriteFlowingBlock(utf8_decode('Maracaibo, '));
        $this->SetFont('Times', '', 8);
        $this->WriteFlowingBlock(date("d/m/Y", strtotime($this->datos['fecha_comp'])));
        $this->SetY(30);
        $this->SetX(160);
        $this->finishFlowingBlock();

       
       
        $this->SetY(40);
        $this->SetX(115);
        $this->SetFont('Times', 'B', 8);
        $this->MultiCell(90, 5, utf8_decode('N° DE PROCESO: '), 0, 'L');
        $this->SetY(40);
        $this->SetX(140);
        $this->SetFont('Times', '', 9);
        $this->MultiCell(70, 5, utf8_decode($this->datos['numero_cotizacion']), 0, 'L');
        $Y = $this->GetY();
        $this->SetY($Y);
        $this->SetX(115);
        $this->SetFont('Times', 'B', 8);
        $this->MultiCell(90, 5, utf8_decode('DESCRIPCIÓN DEL PROCESO: '), 0, 'L');
        $Y = $this->GetY();
        $this->SetY($Y);
        $this->SetX(115);
        $this->SetFont('Times', '', 7);
        $this->MultiCell(80, 5, utf8_decode($this->datos['tx_concepto']), 0, 'J');        

        $Y = 40;
        $this->SetY($Y);
        $this->SetX(16);
        $this->SetFont('Times', 'B', 8);
        $this->MultiCell(90, 5, utf8_decode('SEÑOR(ES): '), 0, 'L');
        $this->SetY($Y);        
        $this->SetX(36);
        $this->SetFont('Times', '', 8);
        $this->MultiCell(70, 5, utf8_decode($this->datos['nu_codigo'] . '-' . utf8_decode($this->datos['tx_razon_social'])), 0, 'L');

       
        $Y = $this->GetY();
        $this->SetY($Y);
        $this->SetX(16);
        $this->SetFont('Times', 'B', 8);
        $this->MultiCell(90, 5, utf8_decode('RIF: '), 0, 'L');
        $this->SetY($Y);
        $this->SetX(36);
        $this->SetFont('Times', '', 8);
        $this->MultiCell(70, 5, utf8_decode($this->datos['tx_rif']), 0, 'L');
        
        $Y = $this->GetY();        
        $this->SetY($Y);
        $this->SetX(16);
        $this->SetFont('Times', 'B', 8);
        $this->MultiCell(90, 5, utf8_decode('DIRECCIÓN: '), 0, 'L');
        $this->SetY($Y);
        $this->SetX(36);
        $this->SetFont('Times', '', 8);
        $this->MultiCell(70, 5, utf8_decode($this->datos['tx_direccion']), 0, 'L');
        //-------------
        //        $this->newFlowingBlock( 55, 5, '', 'J' );
        //            $this->SetFont('Times', 'B', 9 );
        //            $this->WriteFlowingBlock(utf8_decode('PROVEEDOR: '));
        //            $this->SetFont( 'Times', '', 9 );
        //            $this->SetX(16);
        //            $this->WriteFlowingBlock($this->datos['nu_codigo'].'-'.utf8_decode($this->datos['tx_razon_social']));
        //            $this->SetX(16);
        //        $this->finishFlowingBlock();



        //-------------
        //        $this->newFlowingBlock( 80, 5, '', 'J' );
        //            $this->SetFont('Times', 'B', 9 );
        //            $this->WriteFlowingBlock(utf8_decode('DIRECCIÓN: '));
        //            $this->SetFont( 'Times', '', 8 );
        //            $this->SetY($Y+5);
        //            $this->SetX(16);
        //            $this->WriteFlowingBlock(utf8_decode($this->datos['tx_direccion']));
        //            $this->SetX(16);
        //        $this->finishFlowingBlock();
        //-------------
        //***** tercer bloque completo ******//
        $Y = $this->GetY();
        $this->SetFillColor(255, 255, 255);
      /*  $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));
        $this->RoundedRect(15, 80, 186, 180, 3.5, '0110', 'DF', $style);*/

  


        $this->SetY(70);
        $this->SetX(15);
        $this->SetWidths(array(111, 22, 25, 29, 20, 30));
        $this->SetAligns(array("C", "C", "C", "C", "C", "C"));
        $this->SetFillColor(201, 199, 199);
        $this->SetFont('Times', 'B', 8);
        $this->SetTextColor(0, 0, 0);
        $this->Row(array(utf8_decode('DESCRIPCIÓN'), 'CANTIDAD', 'PREC./UNIT.', 'TOTAL'), 1, 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetWidths(array(111, 10, 23, 26, 18, 26));
        $this->SetAligns(array("C", "C", "R", "R", "R", "R"));
        $this->SetX(15);
       

        $style2 = array('width' => 0.5, 'cap' => 'round', 'join' => 'miter', 'dash' => '2,10', 'color' => array(0, 0, 0));
        //        $this->Line(15, 85, 200, 85, $style2);
        //$this->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(100, 150, 255)));

        $j = 0;
        $SubTotal = 0;
        $TotalIVA = 0;
        $TotalExcento = 0;
        $TotalGenerado = 0;
        $monto_prod = 0;
        $iva = 0;


        $this->SetAligns(array("L", "C", "R", "R", "R", "R"));
        $this->SetFont('Times', '', 8);
        $this->lista_materiales = $this->getMateriales();

        foreach ($this->lista_materiales as $key => $campo) {
            
            if($campo['in_calcular_iva']==true){
            $this->SetWidths(array(111, 20, 24, 28, 22, 29));
            $monto_prod =  ($campo['nu_cantidad'] * $campo['precio_unitario']);
            $iva = $campo['mo_iva_producto'];
            $nu_iva = $campo['nu_iva'];
            if ($j == 0) {
                $this->SetX(16);
                $this->Row(array(utf8_decode($campo['tx_producto']), utf8_decode($campo['nu_cantidad']), number_format($campo['precio_unitario'], 2, ',', '.'), number_format($monto_prod, 2, ',', '.')), 0, 0);
                $j = 1;
            } else {
                $this->SetFillColor(240, 240, 240);
                $this->SetX(16);
                $this->Row(array(utf8_decode($campo['tx_producto']), utf8_decode($campo['nu_cantidad']), number_format($campo['precio_unitario'], 2, ',', '.'), number_format($monto_prod, 2, ',', '.')), 0, 1);
                $j = 0;
            }

            if ($this->getY() > 250) {
                $this->addPage();
                $this->SetX(108);
                $this->Row(array('ANEXOS' . $this->datos['numero_compra']), 0, 0);
                $this->SetWidths(array(111, 20, 24, 28, 22, 29));
                $this->SetAligns(array("C", "C", "R", "R", "R", "R"));
                $this->SetX(15);
                $this->Row(array(utf8_decode('DESCRIPCIÓN'), 'CANTIDAD', 'PREC./UNIT.', 'TOTAL'), 1, 1);
                $this->SetAligns(array("L", "C", "R", "R", "R", "R"));
            }
            $SubTotal =     $SubTotal + $monto_prod;
            $TotalExcento =  0;
            }else{
            $TotalIVA =     $TotalIVA + $campo['monto'];    
            }
        }
        //         $TotalGenerado= $monto_total;
        $TotalGenerado = $SubTotal + $TotalIVA;
       
        $Y = $this->GetY();
        $this->SetY($Y + 5);
        $this->newFlowingBlock(110, 5, '', 'J');
        $montoLetra = numtoletras($TotalGenerado, 1);
        $this->SetX(15);
        $this->SetFont('Times', '', 8);
//        $this->WriteFlowingBlock(utf8_decode(' ' . $montoLetra));
        $this->SetX(15);
        $this->finishFlowingBlock();
        $this->SetY($Y);
        $this->SetFont('Times', 'B', 8);
        $this->SetAligns(array("R", "R"));
        $this->SetWidths(array(161, 29));
        $this->SetFont('Times', 'B', 8);
        $this->Row(array(utf8_decode('Sub-Total:'), number_format($SubTotal, 2, ',', '.')), 0, 0);
        $this->Row(array(utf8_decode('Total I.V.A. : '), number_format($TotalIVA, 2, ',', '.')), 0, 0);
//        $this->Row(array(utf8_decode('Total Excento: '), number_format($TotalExcento, 2, ',', '.')), 0, 0);
        $this->SetFont('Times', 'B', 10);
        $this->Row(array('Total General', number_format($TotalGenerado, 2, ',', '.')), 0, 0);

        $this->SetX(15);
        $this->SetWidths(array(186));
        $this->SetAligns(array("C"));
        $this->SetFillColor(201, 199, 199);
        $this->SetFont('Times', 'B', 8);
        $this->Row(array(utf8_decode('PARTIDAS PRESUPUESTARIAS')), 1, 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetWidths(array(70, 80, 34));
        $this->SetAligns(array("C", "L", "R", "R", "C"));
        $this->SetX(15);
        $this->SetTextColor(0, 0, 0);
        $this->Row(array(utf8_decode('CATEGORÍA'), utf8_decode('DESCRIPCIÓN'), utf8_decode('MONTO')), 0, 0);
        $this->SetFont('Times', '', 8);
        $this->SetTextColor(0, 0, 0);

      /*  $style2 = array('width' => 0.5, 'cap' => 'round', 'join' => 'miter', 'dash' => '2,10', 'color' => array(100, 150, 255));
        $this->Line(15, 90, 200, 90, $style2);
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(100, 150, 255));
        $this->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(100, 150, 255)));
*/

        $j = 0;
        $this->lista_partidas = $this->getPartidas();
        foreach ($this->lista_partidas as $key => $campo) {
            if ($j == 0) {
                $this->SetX(16);
                $this->Row(array(utf8_decode($campo['co_categoria']), utf8_decode($campo['de_partida']), number_format($campo['monto'], 2, ',', '.')), 0, 0);
                $j = 1;
            } else {
                $this->SetFillColor(240, 240, 240);
                $this->SetX(16);
                $this->Row(array(utf8_decode($campo['co_categoria']), utf8_decode($campo['de_partida']), number_format($campo['monto'], 2, ',', '.')), 0, 1);
                $j = 0;
            }

            if ($this->getY() > 250) {
                $this->addPage();
                $this->SetX(108);
                $this->Row(array('ANEXOS ' . $this->datos['numero_compra']), 0, 0);
                $this->SetX(15);
                $this->SetWidths(array(70, 80, 34));
                $this->SetAligns(array("C", "L", "R", "R", "C"));
                $this->SetTextColor(0, 0, 0);
                $this->SetFont('Times', 'B', 8);
                $this->Row(array(utf8_decode('CATEGORÍA'), utf8_decode('DESCRIPCIÓN'), utf8_decode('MONTO')), 0, 0);
                $this->SetFont('Times', '', 8);
                    }
        }

        if ($this->getY() > 250) {
            $this->SetX(108);
            $this->Row(array('ANEXOS ' . $this->datos['numero_compra']), 0, 0);
            $this->addPage();
        }
        $this->punto = $this->getExpendiente();
        //-------------
      //  $this->ln();
        $Y = $this->GetY();
//        $this->newFlowingBlock(50, 5, '', 'J');
//        $this->SetFont('Times', 'B', 8);
//        $this->WriteFlowingBlock(utf8_decode('ENTREGA: '));
//        $this->SetFont('Times', '', 9);
//        $this->SetX(15);
//        if ($this->punto['fecha_entrega'] = $this->punto['fecha_reg']) $inf = ' 5 dias';
//        else $inf = ' 8 dias ';
        //            if ($this->punto['fecha_entrega']=$this->punto['fecha_reg']) $inf = ' INMEDIATA'; else $inf = '  '.$this->punto['fecha_entrega'];
//        $this->WriteFlowingBlock($inf);
//        $this->SetX(15);
//        $this->finishFlowingBlock();
//        $this->SetY($Y);
//        $this->newFlowingBlock(30, 5, '', 'J');
//        $this->SetFont('Times', 'B', 8);
//        $this->SetX(15);
//        $this->WriteFlowingBlock(utf8_decode('GARANTIAS: '));
//        $this->finishFlowingBlock();
//        $this->SetY($Y);
        $this->SetY($Y+5);
        $this->SetFont('Times', 'B', 8);
        $this->SetX(15);
        $this->Cell(20, 0, utf8_decode('GARANTIAS: '), 0, 1, 'L', 1);
        $this->SetFont('Times', '', 8);
        $this->SetX(35);
        $this->Cell(100, 0, utf8_decode($this->punto['tiempo_garantia']), 0, 1, 'L', 1);         

//        $this->newFlowingBlock(80, 5, '', 'J');
//        $this->SetFont('Times', '', 8);
//        $this->SetX(32);
//        $this->WriteFlowingBlock('  ' . utf8_decode($this->punto['tiempo_garantia']));
//        $this->SetX(33);
//        $this->finishFlowingBlock();
       
        
//        $this->newFlowingBlock(50, 5, '', 'J');
//        $this->SetFont('Times', '', 9);
//        $this->WriteFlowingBlock('  ' . utf8_decode($this->punto['tiempo_garantia']));
////        $this->SetY($Y);
//        $this->SetX(35);
//        $this->finishFlowingBlock();
        $this->SetY($Y);
        $this->SetX(15);
        $this->newFlowingBlock(90, 5, '', 'J');
        $this->SetFont('Times', 'B', 8);
        if ($this->punto['in_responsabilidad_social'] == t) {
            $inf1 = ' SI APLICA (EN  ESPECIES)';
        } else {
            $inf1 = ' NO APLICA';
        }
        $Y = $this->GetY();
//        $this->WriteFlowingBlock(utf8_decode('COMPROMISO RESP. SOCIAL: '.$inf1));
        $this->SetY($Y+10);
//        $this->finishFlowingBlock();
        $this->SetFont('Times', 'B', 8);
        $this->SetX(15);
        $this->Cell(50, 0, utf8_decode('COMPROMISO RESP. SOCIAL 3%: '), 0, 1, 'L', 1);
        $this->SetFont('Times', '', 8);
        $this->SetX(65);
        $this->Cell(100, 0, utf8_decode($inf1), 0, 1, 'L', 1);   
        
        $Y = $this->GetY();
        $this->SetY($Y+5);
        $this->SetFont('Times', 'B', 8);
        $this->SetX(15);
        $this->Cell(15, 0, utf8_decode('PENALIDAD: '), 0, 1, 'L', 1);
        $this->SetFont('Times', '', 8);
        $this->SetX(35);
        $this->Cell(100, 0, utf8_decode('CLÁUSULA PENAL 0,02% DIARIO'), 0, 1, 'L', 1);          

        //$style2 = array('width' => 0.5, 'cap' => 'round', 'join' => 'miter', 'dash' => '2,10', 'color' => array(0,0,0));
        $this->Line(15, $Y+8, 200, $Y+8);

        $this->SetY($Y + 10);
        $this->SetX(15);
        $this->SetFont('Times', 'B', 8);
        $this->MultiCell(50, 5, utf8_decode('FORMA DE PAGO: '), 0, 'L');
        $this->SetY($Y + 10);
        $this->SetX(65);
        $this->SetFont('Times', '', 9);
        $this->MultiCell(100, 5, utf8_decode('CREDITO'), 0, 'L');
        $this->SetX(15);
        $this->SetFont('Times', 'B', 8);
        $this->MultiCell(70, 5, utf8_decode('PLAZO DE ENTREGA:'), 0, 'L');
        $this->SetY($Y + 15);
        $this->SetX(65);
        $this->SetFont('Times', '', 9);
        $this->MultiCell(100, 5, utf8_decode($this->punto['tx_entrega']), 0, 'L');
//        $this->SetX(15);
//        $this->SetFont('Times', 'B', 8);
//        $this->MultiCell(70, 5, utf8_decode('FORMA DE ENTREGA: '), 0, 'L');
//        $this->SetY($Y + 20);
//        $this->SetX(65);
//        $this->SetFont('Times', '', 9);
//        $this->MultiCell(100, 5, utf8_decode($this->punto['forma_entrega']), 0, 'L');
        $this->SetX(15);
        $this->SetFont('Times', 'B', 8);
        $this->MultiCell(70, 5, utf8_decode('ANEXOS: '), 0, 'L');
        $this->SetY($Y + 20);
        $this->SetX(65);
        $this->SetFont('Times', '', 9);
        $this->MultiCell(135, 5, utf8_decode($this->punto['nu_expediente']), 0, 'J');


       





        //        $this->newFlowingBlock( 180, 5, '', 'J' );
        //            $this->SetFont('Times', 'B', 9 );
        //            $this->WriteFlowingBlock(utf8_decode('OTRAS ESPECIFICACIONES: '));
        //            $this->SetFont( 'Times', '', 9 );
        //            $this->WriteFlowingBlock('    '.utf8_decode($campo['tx_observacion']));
        //            $this->SetX(15);
        //        $this->finishFlowingBlock();

      

       /* if ($this->getY() > 220) {

            $this->addPage();
            $Y = 10;

            $this->SetFillColor(255, 255, 255);
            $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));
            $this->RoundedRect(15, $Y+5, 180, 35, 3.5, '1111', 'DF', $style);

            $this->SetY($Y + 10);
            $this->SetX(15);
            $this->SetFont('Times', 'B', 8);
            $this->MultiCell(50, 5, utf8_decode('FORMA DE PAGO: '), 0, 'L');
            $this->SetY($Y + 10);
            $this->SetX(65);
            $this->SetFont('Times', '', 9);
            $this->MultiCell(100, 5, utf8_decode($this->punto['forma_pago']), 0, 'L');
            $this->SetX(15);
            $this->SetFont('Times', 'B', 8);
            $this->MultiCell(70, 5, utf8_decode('TIEMPO:'), 0, 'L');
            $this->SetY($Y + 15);
            $this->SetX(65);
            $this->SetFont('Times', '', 9);
            $this->MultiCell(100, 5, utf8_decode($this->punto['fecha_inicio'] . ' - ' . $this->punto['fecha_fin']), 0, 'L');
            $this->SetX(15);
            $this->SetFont('Times', 'B', 8);
            $this->MultiCell(70, 5, utf8_decode('FORMA DE ENTREGA: '), 0, 'L');
            $this->SetY($Y + 20);
            $this->SetX(65);
            $this->SetFont('Times', '', 9);
            $this->MultiCell(100, 5, utf8_decode($this->punto['forma_entrega']), 0, 'L');
            $this->SetX(15);
            $this->SetFont('Times', 'B', 8);
            $this->MultiCell(70, 5, utf8_decode('OTRAS ESPECIFICACIONES: '), 0, 'L');
            $this->SetY($Y + 25);
            $this->SetX(65);
            $this->SetFont('Times', '', 9);
            $this->MultiCell(100, 5, utf8_decode($campo['tx_observacion']), 0, 'L');
        } else {

            $this->SetFillColor(255, 255, 255);
            $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(0, 0, 0));
            $this->RoundedRect(15, $Y, 180, 35, 3.5, '1111', 'DF', $style);

            $this->SetY($Y + 10);
            $this->SetX(15);
            $this->SetFont('Times', 'B', 8);
            $this->MultiCell(50, 5, utf8_decode('FORMA DE PAGO: '), 0, 'L');
            $this->SetY($Y + 10);
            $this->SetX(65);
            $this->SetFont('Times', '', 9);
            $this->MultiCell(100, 5, utf8_decode($this->punto['forma_pago']), 0, 'L');
            $this->SetX(15);
            $this->SetFont('Times', 'B', 8);
            $this->MultiCell(70, 5, utf8_decode('TIEMPO:'), 0, 'L');
            $this->SetY($Y + 15);
            $this->SetX(65);
            $this->SetFont('Times', '', 9);
            $this->MultiCell(100, 5, utf8_decode($this->punto['fecha_inicio'] . ' - ' . $this->punto['fecha_fin']), 0, 'L');
            $this->SetX(15);
            $this->SetFont('Times', 'B', 8);
            $this->MultiCell(70, 5, utf8_decode('FORMA DE ENTREGA: '), 0, 'L');
            $this->SetY($Y + 20);
            $this->SetX(65);
            $this->SetFont('Times', '', 9);
            $this->MultiCell(100, 5, utf8_decode($this->punto['forma_entrega']), 0, 'L');
            $this->SetX(15);
            $this->SetFont('Times', 'B', 8);
            $this->MultiCell(70, 5, utf8_decode('OTRAS ESPECIFICACIONES: '), 0, 'L');
            $this->SetY($Y + 25);
            $this->SetX(65);
            $this->SetFont('Times', '', 9);
            $this->MultiCell(100, 5, utf8_decode($campo['tx_observacion']), 0, 'L');
        }*/
        //-------------

        /*if ($this->getY() > 220) {

            $this->addPage();
        }*/

        $this->ln();
        $Y = $this->GetY();
        if($Y>250){
        $this->addPage();
        $this->SetX(15);
        $this->SetY(230);
        $this->SetAligns(array("C", "C", "C", "C"));
        $this->SetFillColor(201, 199, 199);
        $this->SetWidths(array(46, 46, 48, 46));
        $this->SetFont('Arial', 'B', 6);
        $this->SetX(15);
        $this->Row(array(utf8_decode('COORDINACIÓN DE COMPRAS'), utf8_decode('COORDINACIÓN DE PRESUPUESTO'), utf8_decode('COORD GRAL DE ADMINISTRACIÓN'), utf8_decode('PROVEEDOR')), 1, 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetAligns(array("L", "L"));
        $Y = $this->GetY();
        $this->SetX(15);
        $this->MultiCell(46, 10, '', 1, 1, 'L', 1);
        $this->SetY($Y);
        $this->SetX(61);
        $this->MultiCell(46, 10, '', 1, 1, 'L', 1);
        $this->SetY($Y);
        $this->SetX(107);
        $this->MultiCell(48, 10, '', 1, 1, 'L', 1);
        $this->SetY($Y);
        $this->SetX(155);
        $this->MultiCell(46, 10, '', 1, 1, 'L', 1);
        $this->SetY($Y + 5);
        $this->SetFont('Arial', '', 6);
        $this->ln(8);
        $this->SetX(15);
        $this->Row(array('Realizado por:', 'Revisado por:', 'Aprobado por:', utf8_decode('Recibí conforme:')), 0, 0);         

        }else{
        $this->SetX(15);
        $this->SetY(240);
        $this->SetAligns(array("C", "C", "C", "C"));
        $this->SetFillColor(201, 199, 199);
        $this->SetWidths(array(46, 46, 48, 46));
        $this->SetFont('Arial', 'B', 6);
        $this->SetX(15);
        $this->Row(array(utf8_decode('COORDINACIÓN DE COMPRAS'), utf8_decode('COORDINACIÓN DE PRESUPUESTO'), utf8_decode('COORD GRAL DE ADMINISTRACIÓN'), utf8_decode('PROVEEDOR')), 1, 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetAligns(array("L", "L"));
        $Y = $this->GetY();
        $this->SetX(15);
        $this->MultiCell(46, 10, '', 1, 1, 'L', 1);
        $this->SetY($Y);
        $this->SetX(61);
        $this->MultiCell(46, 10, '', 1, 1, 'L', 1);
        $this->SetY($Y);
        $this->SetX(107);
        $this->MultiCell(48, 10, '', 1, 1, 'L', 1);
        $this->SetY($Y);
        $this->SetX(155);
        $this->MultiCell(46, 10, '', 1, 1, 'L', 1);
        $this->SetY($Y + 3);
        $this->SetFont('Arial', '', 6);
        $this->ln(6);
        $this->SetX(15);
        $this->Row(array('Realizado por:', 'Revisado por:', 'Aprobado por:', utf8_decode('Recibí conforme:')), 0, 0);            
        }

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

    function getDatosEmpresa(){

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
        WHERE co_empresa = 1;";

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];
  
    }

    function getOrdenes()
    {

        $conex = new ConexionComun();
        $sql = "select upper(tb027.tx_tipo_solicitud) as tx_tipo_solicitud,
                         tb052.numero_compra,
                         tb052.fecha_compra,
                         tb052.co_solicitud,
                         upper(tb052.tx_concepto) as tx_concepto,
                         tb052.tx_observacion,
                         UPPER(tb008.tx_razon_social) AS tx_razon_social,
                         (tb007.inicial||'-'||tb008.tx_rif) as tx_rif,
                         tb008.tx_direccion,
                         tb008.nb_representante_legal,
                         tb008.nu_cedula_representante,
                         tb008.tx_email,
                         tb047.tx_ente,
                         tb052.nu_orden_compra,
                         tb052.fecha_compra as fecha_comp,
                         tb008.nu_codigo,
                         de_tipo_movimiento,
                         tb001.nb_usuario,
                         tb027.co_tipo_solicitud,
                         tb082.de_ejecutor,
                         tb206.numero_cotizacion,
                         in_contrato
                  from   tb026_solicitud as tb026
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud
                  left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras
                  left join tb085_presupuesto as tb085 on tb085.id = tb053.co_presupuesto
                  left join tb084_accion_especifica as tb084 on tb085.id_tb084_accion_especifica = tb084.id
                  left join tb083_proyecto_ac as tb083 on tb084.id_tb083_proyecto_ac = tb083.id
                  left join tb082_ejecutor as tb082 on tb082.id = tb083.id_tb082_ejecutor
                  left join tb027_tipo_solicitud as tb027 on tb027.co_tipo_solicitud=tb052.co_tipo_solicitud
                  left join tb088_tipo_movimiento as tb088 on tb088.id = tb052.co_tipo_movimiento
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb052.co_proveedor
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb052.co_usuario
                  left join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
                  left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud
                  left join tb206_cotizacion as tb206 on tb206.co_solicitud = tb052.co_solicitud_cotizacion
                  where tb030.co_ruta = " . $_GET['codigo']; //$conex->decrypt($_GET['codigo']);

        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];
    }

    function getMateriales()
    {

        $conex = new ConexionComun();
        $sql = "SELECT UPPER((substr(tx_producto,1,50)||'-'||substr(tb053.detalle,1,50))) as tx_producto,
                         tb053.nu_cantidad,
                         tb052.nu_iva,
                         tb048.cod_producto,
                         tb053.precio_unitario,
                         tb057.tx_unidad_producto,
                         tb052.monto_total,
                         tb053.monto,
                         tb053.mo_iva_producto,
                         tb053.in_calcular_iva
                  FROM tb052_compras as tb052
                  left join tb053_detalle_compras as tb053 on tb053.co_compras = tb052.co_compras
                  left join tb048_producto as tb048 on tb053.co_producto = tb048.co_producto
                  left join tb057_unidad_producto as tb057 on tb057.co_unidad_producto = tb053.co_unidad_producto
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud
                  where tb030.co_ruta = " . $_GET['codigo']; //$conex->decrypt($_GET['codigo']);



        return $conex->ObtenerFilasBySqlSelect($sql);
    }

    function getPartidas()
    {
        $conex = new ConexionComun();
        $sql = "   select distinct
                         substr(tb085.co_categoria,1,100) as co_categoria,
                         tb085.de_partida,
                         tb085.nu_partida,
                         upper(tb052.tx_observacion) as tx_observacion,
                         sum(case when tb053.co_presupuesto is null then tb209.monto else tb053.monto end) as monto
                  from  tb052_compras as tb052
                  left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras            
                  left join tb209_presupuesto_detalle_compra as tb209 on tb209.co_detalle_compra = tb053.co_detalle_compras
                  left join tb085_presupuesto as tb085 on tb085.id = (case when tb053.co_presupuesto is null then tb209.co_presupuesto else tb053.co_presupuesto end)
                  left join tb084_accion_especifica as tb084 on tb085.id_tb084_accion_especifica = tb084.id
                  left join tb083_proyecto_ac as tb083 on tb084.id_tb083_proyecto_ac = tb083.id
                  left join tb082_ejecutor as tb082 on tb082.id = tb083.id_tb082_ejecutor
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud and tb030.in_cargar_dato is true
                  where tb030.co_ruta = " . $_GET['codigo'] . ' group by 1, 2, 3, 4 '; //$conex->decrypt($_GET['codigo']);
        // echo var_dump($sql); exit();

        return $conex->ObtenerFilasBySqlSelect($sql);
    }

    function getExpendiente()
    {

        $conex = new ConexionComun();

        $sql = "select UPPER(tx_tp_contrato) AS tx_tp_contrato,
                         nu_expediente,
                         monto_total,
                         nu_iva,
                         fecha_inicio,
                         to_char(tb052.created_at,'dd/mm/yyyy') as fecha_reg,
                         to_char(fecha_entrega, 'dd/mm/yyyy') as fecha_entrega,
                         to_char(fecha_inicio, 'dd/mm/yyyy') as fecha_inicio,
                         to_char(fecha_fin, 'dd/mm/yyyy') as fecha_fin,
                         tx_fuente_financiamiento,
                         UPPER(tx_entrega) as tx_entrega,
                         UPPER(tiempo_garantia) as tiempo_garantia,
                         forma_pago,
                         forma_entrega,
                         UPPER(tx_razon_social) AS tx_razon_social,
                         in_responsabilidad_social
                  from   tb052_compras as tb052
                  left join tb056_contrato_compras as tb056 on tb056.co_compras = tb052.co_compras
                  left join tb058_tp_contrato as tb058 on tb058.co_tp_contrato=tb056.co_tp_contrato
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb052.co_proveedor
                  left join tb073_fuente_financiamiento as tb073 on tb073.co_fuente_financiamiento = tb056.co_fuente_financiamiento
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud
                  where tb030.co_ruta = " . $_GET['codigo']; //$conex->decrypt($_GET['codigo']);

        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];
    }
}


$pdf = new PDF_Flo('P', 'mm', 'letter');
$pdf->AliasNbPages();
//$pdf->PuntoCuenta();
$pdf->PrintChapter();

$comm = new ConexionComun();
$ruta = $comm->getRuta();

//rmdir($ruta);
//mkdir($ruta, 0777, true);

$dir = "$ruta" . $_GET["codigo"] . ".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";


$update = "update tb030_ruta set tx_ruta_reporte = '" . $dir . "' where co_ruta = " . $_GET['codigo']; //$comm->decrypt($_GET["codigo"]);

//echo $update; exit();
$comm->Execute($update);
$pdf->SetMargins(0, 0, 0);
$pdf->Output($dir, 'F');

//$pdf=new PDF_Flo('P','mm','letter');
//$pdf->PrintChapter();
//$pdf->SetDisplayMode('default');
//$pdf->Output();
