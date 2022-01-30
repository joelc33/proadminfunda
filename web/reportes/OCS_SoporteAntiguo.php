<?php
include("ConexionComun.php");
require('flowing_block.php');


class PDF_Flo extends PDF_FlowingBlock
{

    function SetLineStyle($style) {
		extract($style);
		if (isset($width)) {
			$width_prev = $this->LineWidth;
			$this->SetLineWidth($width);
			$this->LineWidth = $width_prev;
		}
		if (isset($cap)) {
			$ca = array('butt' => 0, 'round'=> 1, 'square' => 2);
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
    function RoundedRect($x, $y, $w, $h, $r, $round_corner = '1111', $style = '', $border_style = null, $fill_color = null) {
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
				case 'FD': case 'DF':
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

			$xc = $x + $w - $r ;
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

	function _Point($x, $y) {
		$this->_out(sprintf('%.2F %.2F m', $x * $this->k, ($this->h - $y) * $this->k));
	}

	function _Line($x, $y) {
		$this->_out(sprintf('%.2F %.2F l', $x * $this->k, ($this->h - $y) * $this->k));
	}

	function _Curve($x1, $y1, $x2, $y2, $x3, $y3) {
		$this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c', $x1 * $this->k, ($this->h - $y1) * $this->k, $x2 * $this->k, ($this->h - $y2) * $this->k, $x3 * $this->k, ($this->h - $y3) * $this->k));
	}
	function Line($x1, $y1, $x2, $y2, $style = null) {
		if ($style)
			$this->SetLineStyle($style);
		parent::Line($x1, $y1, $x2, $y2);
	}

    function Footer() {
	$this->SetFont('Times','',9);
	$this->SetY(-20);
	$this->Cell(0,0,utf8_decode(''),0,0,'C');
    }

    function Header() {

        //***** Primer emblema izq ******//
        $this->SetFillColor(255, 255, 255);
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(100, 150, 255));
        $this->RoundedRect(15, 12, 90, 28, 3.5, '1111', 'DF', $style);
        //$this->RoundedRect(posX, posY, ancho, alto, redondeo, 1=EsqRecta-0=EsqRedondeada(1digitosporEsquina), estiloEsquinas, estiloLinea, colorRelleno);
        $this->Image("imagenes/escudosanfco.jpg", 16, 16,17);
        $this->SetFont('Times','B',9);
        $this->SetTextColor(0,0,0);
        $this->SetY(20);
        $this->SetX(25);
        $this->SetWidths(array(80));
        $this->SetAligns(array("C"));
        $this->Row(array(utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA')),0,0);
        $this->SetX(20);
        $this->Row(array(utf8_decode('ESTADO ZULIA')),0,0);
        $this->SetX(20);
        $this->Row(array(utf8_decode('ALCALDIA DEL MUNICIPIO SAN FRANCISCO')),0,0);
        $this->SetX(20);
        $this->Row(array(utf8_decode('RIF. G-200005297')),0,0);

        //***** Primer emblema der ******//
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(100, 150, 255));
        $this->RoundedRect(107, 12, 94, 65, 3.5, '1111', 'DF', $style);
      //  $this->Image("imagenes/escudo.png", 140, 13 ,30);
        $this->SetFont('Times','B',9);
        $this->SetTextColor(0,0,0);
        $this->SetY(20);
        $this->SetX(113);
        $this->SetWidths(array(80));
        $this->SetAligns(array("C"));
        $this->Row(array(utf8_decode('ALCALDIA DE SAN FRANCISCO')),0,0);



        //***** Segundo emblema izq ******//
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(100, 150, 255));
        $this->RoundedRect(15, 42, 90, 35, 3.5, '1111', 'DF', $style);

        $this->Ln(2);

    }

    function ChapterBody() {

         $this->datos = $this->getOrdenes();
         $this->SetFont('Times','B',12);
         $this->SetX(115);
         if($this->datos['co_tipo_solicitud']==65){
         $this->Row(array(utf8_decode('ORDEN DE CONTRATO')),0,0);
         }else{
         $this->Row(array(utf8_decode('ORDEN DE '.$this->datos['tx_tipo_solicitud'])),0,0);    
         }
        $this->SetFont('Times','',10);
        $Y = $this->GetY();
        $this->SetWidths(array(55,35));
        $this->SetAligns(array("L","L"));

        //-------------
        $this->newFlowingBlock( 55, 5, '', 'J' );
            $this->SetFont('Times', 'B', 9 );
            $this->WriteFlowingBlock(utf8_decode('ORDEN No.: '));
            $this->SetFont( 'Times', '', 9 );
            $this->WriteFlowingBlock($this->datos['numero_compra']);
            $this->SetX(108);
        $this->finishFlowingBlock();

        $this->newFlowingBlock( 35, 5, '', 'J' );
            $this->SetFont('Times', 'B', 9 );
            $this->WriteFlowingBlock(utf8_decode('FECHA: '));
            $this->SetFont( 'Times', '', 9 );
            $this->WriteFlowingBlock(date("d/m/Y", strtotime($this->datos['fecha_comp'])));
            $this->SetY($Y);
            $this->SetX(163);
        $this->finishFlowingBlock();
        $Y = $this->GetY();
            $this->SetY($Y);
            $this->SetX(108);
            $this->SetFont('Times', 'B', 9 );
            $this->MultiCell(90,5,utf8_decode('CONCEPTO: '),0,'L');
            $this->SetY($Y);
            $this->SetX(131);
            $this->SetFont( 'Times', '', 9 );
            $this->MultiCell(70,5,utf8_decode($this->datos['tx_concepto']),0,'L');
        //-------------
//        $this->newFlowingBlock( 100, 5, '1', 'J' );
//            $this->SetFont('Times', 'B', 9 );
//            $this->WriteFlowingBlock(utf8_decode('CONCEPTO: '));
//            $this->SetFont( 'Times', '', 9 );
//            $this->WriteFlowingBlock(utf8_decode($this->datos['tx_concepto']));
//            $this->SetY($Y);
//            $this->SetX(108);
//        $this->finishFlowingBlock();
       //-------------
        $this->newFlowingBlock( 55, 5, '', 'J' );
            $this->SetFont('Times', 'B', 9 );
//            $this->WriteFlowingBlock(utf8_decode('ESTADO: '));
            $this->SetFont( 'Times', '', 9 );
            //$this->WriteFlowingBlock('COMPROMETIDA');
            $this->SetX(108);
        $this->finishFlowingBlock();

        $this->newFlowingBlock( 100, 5, '', 'J' );
            $this->SetFont('Times', 'B', 9 );
            //$this->SetX(108);
            //$this->WriteFlowingBlock(utf8_decode('No. PROCESO: '));
            $this->SetFont( 'Times', '', 9 );
            //$this->MultiCell(65,20,'',1,1,'L',1);
           $this->finishFlowingBlock();
            $Y = $this->GetY();
            $this->SetY($Y);
            $this->SetX(108);
            $this->SetFont('Times', 'B', 9 );
            $this->MultiCell(90,5,utf8_decode('No. PROCESO: '),0,'L');
            $this->SetY($Y);
            $this->SetX(131);
            $this->SetFont( 'Times', '', 9 );
            $this->MultiCell(70,5,utf8_decode($this->datos['nu_orden_compra']),0,'L');

        //-------------
//        $this->newFlowingBlock( 100, 5, '', 'J' );
//            $this->SetFont('Times', 'B', 9 );
//            $this->WriteFlowingBlock(utf8_decode('UNIDAD USUARIA: '));
//            $this->SetFont( 'Times', '', 9 );
//            $this->WriteFlowingBlock(utf8_decode(utf8_decode($this->datos['tx_ente'])));
//            $this->SetY(45);
//            $this->SetX(16);
//        $this->finishFlowingBlock();
        $this->newFlowingBlock( 25, 5, '', 'J' );
            $this->SetFont('Times', 'B', 9 );
            $this->WriteFlowingBlock(utf8_decode('RIF: '));
            $this->SetFont( 'Times', '', 9 );
            $this->WriteFlowingBlock($this->datos['tx_rif']);
            $this->SetY(45);
            $this->SetX(16);
        $this->finishFlowingBlock();           
            
        $Y = $this->GetY();
            $this->SetY($Y);
            $this->SetX(16);
            $this->SetFont('Times', 'B', 9 );
            $this->MultiCell(90,5,utf8_decode('PROVEEDOR: '),0,'L');
            $this->SetY($Y);
            $this->SetX(39);
            $this->SetFont( 'Times', '', 8 );
            $this->MultiCell(70,5,utf8_decode($this->datos['nu_codigo'].'-'.utf8_decode($this->datos['tx_razon_social'])),0,'L');
        $Y = $this->GetY();
            $this->SetY($Y);
            $this->SetX(16);
            $this->SetFont('Times', 'B', 9 );
            $this->MultiCell(90,5,utf8_decode('DIRECCIÓN: '),0,'L');
            $this->SetY($Y);
            $this->SetX(36);
            $this->SetFont( 'Times', '', 8 );
            $this->MultiCell(70,5,utf8_decode($this->datos['tx_direccion']),0,'L');            
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
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(100, 150, 255));
        $this->RoundedRect(15, 80, 186, 180, 3.5, '0110', 'DF', $style);


         $this->SetY(80);
         $this->SetX(15);
         $this->SetWidths(array(186));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Times','B',10);
         $this->Row(array(utf8_decode('DETALLES DE MATERIALES')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(60,22,25,29,20,28));
         $this->SetAligns(array("C","C","R","R","R","R"));
         $this->SetX(15);
         $this->SetTextColor(100, 150, 100);
         $this->Row(array(utf8_decode('DESCRIPCIÓN'),'CANTIDAD','PREC./UNIT.','SUB TOTAL','I.V.A','TOTAL'),0,0);
         $this->SetFont('Times','',8);
         $this->SetTextColor(0, 0, 0);
         $this->SetAligns(array("L","C","R","R","R","R"));

        $style2 = array('width' => 0.5, 'cap' => 'round', 'join' => 'miter', 'dash' => '2,10', 'color' => array(100, 150, 255));
//        $this->Line(15, 85, 200, 85, $style2);
        //$this->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(100, 150, 255)));

         $j = 0;
         $SubTotal=0;
         $TotalIVA=0;
         $TotalExcento=0;
         $TotalGenerado=0;
         $monto_prod=0;
         $iva=0;

         $this->lista_materiales = $this->getMateriales();

         foreach($this->lista_materiales as $key => $campo){
         $monto_prod =  ($campo['nu_cantidad']*$campo['precio_unitario']);
         $iva = ($monto_prod*$campo['nu_iva'])/100;
         $nu_iva = $campo['nu_iva'];
         if ($j==0) {
             $this->SetX(16);
             $this->Row(array(utf8_decode($campo['tx_producto']),utf8_decode($campo['nu_cantidad']),number_format($campo['precio_unitario'], 2, ',','.'),number_format($monto_prod, 2, ',','.'),number_format($iva, 2, ',','.'),number_format(($monto_prod+$iva), 2, ',','.')),0,0);
             $j=1;
         }
          else {
              $this->SetFillColor(240, 240, 240);
              $this->SetX(16);
              $this->Row(array(utf8_decode($campo['tx_producto']),utf8_decode($campo['nu_cantidad']),number_format($campo['precio_unitario'], 2, ',','.'),number_format($monto_prod, 2, ',','.'),number_format($iva, 2, ',','.'),number_format(($monto_prod+$iva), 2, ',','.')),0,1);
              $j=0;}

         if($this->getY()>180){
             $this->addPage();
            $this->SetX(108);
             $this->Row(array('ANEXOS'.$this->datos['numero_compra']),0,0);
             $this->SetWidths(array(60,22,25,29,20,28));
             $this->SetAligns(array("C","C","R","R","R","R"));
             $this->Row(array(utf8_decode('DESCRIPCIÓN'),'CANTIDAD','PREC./UNIT.','SUB TOTAL','I.V.A','TOTAL'),0,0);
             $this->SetAligns(array("L","C","R","R","R","R"));
	 }
         $SubTotal =     $SubTotal + $monto_prod;
         $TotalIVA =     $TotalIVA + $iva;
         $TotalExcento=  0;
        }

         $TotalGenerado= $SubTotal + $TotalIVA;



//        //-------------
//        $this->newFlowingBlock( 55, 5, '', 'R' );
//            $this->SetFont('Times', 'BI', 9 );
//            $this->WriteFlowingBlock(utf8_decode('Sub-Total:'));
//            $this->SetX(137);
//            $this->SetFont( 'Times', '', 9 );
//            $this->WriteFlowingBlock(number_format($SubTotal, 2, ',','.'));
//            $this->SetX(137);
//        $this->finishFlowingBlock();
//
//        $this->newFlowingBlock( 55, 5, '', 'R' );
//            $this->SetFont('Times', 'BI', 9 );
//            $this->WriteFlowingBlock(utf8_decode('Total I.V.A.: '));
//            $this->SetX(136);
//            $this->SetFont( 'Times', '', 9 );
//            $this->WriteFlowingBlock(number_format($TotalIVA, 2, ',','.'));
//            $this->SetX(136);
//        $this->finishFlowingBlock();
//
//        $this->newFlowingBlock( 55, 5, '', 'R' );
//            $this->SetFont('Times', 'BI', 9 );
//            $this->WriteFlowingBlock(utf8_decode('Total Excento: '));
//            $this->SetX(136);
//            $this->SetFont( 'Times', '', 9 );
//            $this->WriteFlowingBlock(number_format($TotalExcento, 2, ',','.'));
//            $this->SetX(136);
//        $this->finishFlowingBlock();
       //-------------
         //$this->SetX(15);
         $Y = $this->GetY();
         $this->SetY($Y+10);         
         $this->newFlowingBlock( 110, 5, '', 'J' ); 
         $montoLetra = numtoletras($TotalGenerado,1);
         $this->SetX(15);
         $this->SetFont('Times','',8);
         $this->WriteFlowingBlock(utf8_decode(' '.$montoLetra)); 
         $this->SetX(15);         
         $this->finishFlowingBlock();
         $this->SetY($Y); 
         $this->SetFont('Times','B',10);
         $this->SetAligns(array("R","R"));
         $this->SetWidths(array(150,40));
         $this->SetFont('Times', 'B', 9 );
         $this->Row(array(utf8_decode('Sub-Total:'),number_format($SubTotal, 2, ',','.')),0,0);
         $this->Row(array(utf8_decode('Total I.V.A. '.$nu_iva.' %: '),number_format($TotalIVA, 2, ',','.')),0,0);
         $this->Row(array(utf8_decode('Total Excento: '),number_format($TotalExcento, 2, ',','.')),0,0);
         $this->SetFont('Times','B',10);
         $this->Row(array('Total General',number_format($TotalGenerado, 2, ',','.')),0,0);

         $this->SetX(15);
         $this->SetWidths(array(186));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Times','B',10);
         $this->Row(array(utf8_decode('PARTIDAS PRESUPUESTARIAS')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(40,40,64,40));
         $this->SetAligns(array("C","C","L","R","C"));
         $this->SetX(15);
         $this->SetTextColor(100, 150, 100);
         $this->Row(array(utf8_decode('PROGRAMÁTICA'),utf8_decode('CUENTA'), utf8_decode('DESCRIPCIÓN'), utf8_decode('MONTO')),0,0);
         $this->SetFont('Times','',8);
         $this->SetTextColor(0, 0, 0);

        $style2 = array('width' => 0.5, 'cap' => 'round', 'join' => 'miter', 'dash' => '2,10', 'color' => array(100, 150, 255));
        $this->Line(15, 90, 200, 90, $style2);
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(100, 150, 255));
        $this->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 10, 'color' => array(100, 150, 255)));


        $j = 0;
         $this->lista_partidas = $this->getPartidas();
          foreach($this->lista_partidas as $key => $campo){
         if ($j==0) {
             $this->SetX(16);
             $this->Row(array(utf8_decode($campo['co_categoria']),utf8_decode($campo['nu_partida']),utf8_decode($campo['de_partida']),number_format($campo['monto'], 2, ',','.')),0,0);
             $j=1;
         }
          else {
              $this->SetFillColor(240, 240, 240);
              $this->SetX(16);
              $this->Row(array(utf8_decode($campo['co_categoria']),utf8_decode($campo['nu_partida']),utf8_decode($campo['de_partida']),number_format($campo['monto'], 2, ',','.')),0,1);
              $j=0;}

        if($this->getY()>250){
             $this->addPage();
             $this->SetX(108);
             $this->Row(array('ANEXOS'.$this->datos['numero_compra']),0,0);
             $this->Row(array(utf8_decode('PROGRAMÁTICA'),utf8_decode('CUENTA'), utf8_decode('DESCRIPCIÓN'), utf8_decode('MONTO'), utf8_decode('ANALISTA'), utf8_decode('FECHA')),0,0);
	 }
        }

         if($this->getY()>250){
          $this->SetX(108);
          $this->Row(array('ANEXOS'.$this->datos['numero_compra']),0,0);
          $this->addPage();
         }
         $this->punto = $this->getExpendiente();
        //-------------
        $this->ln();
        $Y = $this->GetY();
        $this->newFlowingBlock( 50, 5, '', 'J' );
            $this->SetFont('Times', 'B', 9 );
            $this->WriteFlowingBlock(utf8_decode('ENTREGA: '));
            $this->SetFont( 'Times', '', 9 );
            $this->SetX(15);
            if ($this->punto['fe_entrega']=$this->punto['fecha_reg']) $inf = ' INMEDIATA'; else $inf = '  '.$this->punto['fe_entrega'];
            $this->WriteFlowingBlock($inf);
            $this->SetX(15);
        $this->finishFlowingBlock();

        $this->newFlowingBlock( 70, 5, '', 'J' );
            $this->SetFont('Times', 'B', 9 );
            $this->WriteFlowingBlock(utf8_decode('GARANTIAS: '));
            $this->SetFont( 'Times', '', 9 );
            $this->WriteFlowingBlock('  '.$this->punto['tiempo_garantia']);
            $this->SetY($Y);
            $this->SetX(78);
        $this->finishFlowingBlock();

        $this->newFlowingBlock( 70, 5, '', 'J' );
            $this->SetFont('Times', 'B', 9 );
            $this->WriteFlowingBlock(utf8_decode('COMPROMISO RESP. SOCIAL: '));
            $this->SetFont( 'Times', '', 9 );
            if ($this->punto['in_responsabilidad_social']==t){
            $inf1 = ' SI APLICA';
            } else {
            $inf1 = ' NO APLICA';    
            }
            $this->WriteFlowingBlock($inf1);
            $this->SetY($Y);
            $this->SetX(130);
        $this->finishFlowingBlock();

//        $this->newFlowingBlock( 180, 5, '', 'J' );
//            $this->SetFont('Times', 'B', 9 );
//            $this->WriteFlowingBlock(utf8_decode('OTRAS ESPECIFICACIONES: '));
//            $this->SetFont( 'Times', '', 9 );
//            $this->WriteFlowingBlock('    '.utf8_decode($campo['tx_observacion']));
//            $this->SetX(15);
//        $this->finishFlowingBlock();

        $Y = $this->GetY();
            if($this->getY()>220){
                
             $this->addPage();
            $Y = 100; 
             
            $this->SetY($Y+10);
            $this->SetX(15);
            $this->SetFont( 'Times', 'B', 9 );
            $this->MultiCell(50,5,utf8_decode('FORMA DE PAGO: '),0,'L');
            $this->SetY($Y+10);
            $this->SetX(65);
            $this->SetFont( 'Times', '', 9 );
            $this->MultiCell(100,5,utf8_decode($this->punto['forma_pago']),0,'L');
            $this->SetX(15);
            $this->SetFont( 'Times', 'B', 9 );
            $this->MultiCell(70,5,utf8_decode('TIEMPO:'),0,'L');
            $this->SetY($Y+15);
            $this->SetX(65);
            $this->SetFont( 'Times', '', 9 );
            $this->MultiCell(100,5,utf8_decode($this->punto['fecha_inicio'].' - '.$this->punto['fecha_fin']),0,'L');            
            $this->SetX(15);
            $this->SetFont( 'Times', 'B', 9 );
            $this->MultiCell(70,5,utf8_decode('FORMA DE ENTREGA: '),0,'L');
            $this->SetY($Y+20);
            $this->SetX(65);
            $this->SetFont( 'Times', '', 9 );
            $this->MultiCell(100,5,utf8_decode($this->punto['forma_entrega']),0,'L');            
            $this->SetX(15);
            $this->SetFont( 'Times', 'B', 9 );
            $this->MultiCell(70,5,utf8_decode('OTRAS ESPECIFICACIONES: '),0,'L');
            $this->SetY($Y+25);
            $this->SetX(65);
            $this->SetFont( 'Times', '', 9 );
            $this->MultiCell(100,5,utf8_decode($campo['tx_observacion']),0,'L');
            }else{
            $this->SetY($Y+10);
            $this->SetX(15);
            $this->SetFont( 'Times', 'B', 9 );
            $this->MultiCell(50,5,utf8_decode('FORMA DE PAGO: '),0,'L');
            $this->SetY($Y+10);
            $this->SetX(65);
            $this->SetFont( 'Times', '', 9 );
            $this->MultiCell(100,5,utf8_decode($this->punto['forma_pago']),0,'L');
            $this->SetX(15);
            $this->SetFont( 'Times', 'B', 9 );
            $this->MultiCell(70,5,utf8_decode('TIEMPO:'),0,'L');
            $this->SetY($Y+15);
            $this->SetX(65);
            $this->SetFont( 'Times', '', 9 );
            $this->MultiCell(100,5,utf8_decode($this->punto['fecha_inicio'].' - '.$this->punto['fecha_fin']),0,'L');            
            $this->SetX(15);
            $this->SetFont( 'Times', 'B', 9 );
            $this->MultiCell(70,5,utf8_decode('FORMA DE ENTREGA: '),0,'L');
            $this->SetY($Y+20);
            $this->SetX(65);
            $this->SetFont( 'Times', '', 9 );
            $this->MultiCell(100,5,utf8_decode($this->punto['forma_entrega']),0,'L');            
            $this->SetX(15);
            $this->SetFont( 'Times', 'B', 9 );
            $this->MultiCell(70,5,utf8_decode('OTRAS ESPECIFICACIONES: '),0,'L');
            $this->SetY($Y+25);
            $this->SetX(65);
            $this->SetFont( 'Times', '', 9 );
            $this->MultiCell(100,5,utf8_decode($campo['tx_observacion']),0,'L');            
            }
       //-------------

         $this->ln();
         $this->SetY(230);
         $this->SetAligns(array("C","C", "C", "C"));
	 $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(46,46,48,46));
         $this->SetFont('Arial','B',6);
         $this->SetX(15);
         $this->Row(array(utf8_decode('COORDINACIÓN DE COMPRAS'),utf8_decode('COORDINACIÓN DE PRESUPUESTO'),utf8_decode('COORDINACIÓN GENERAL DE ADMINISTRACIÓN'),utf8_decode('PROVEEDOR')),1,1);
         $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L", "L"));
         $Y = $this->GetY();
         $this->SetX(15);
         $this->MultiCell(46,14,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(61);
         $this->MultiCell(46,14,'',1,1,'L',1); 
         $this->SetY($Y);
         $this->SetX(107);
         $this->MultiCell(48,14,'',1,1,'L',1);           
         $this->SetY($Y);
         $this->SetX(155);
         $this->MultiCell(46,14,'',1,1,'L',1);
         $this->SetY($Y+5);
         $this->SetFont('Arial','',6);
         $this->ln(8);
         $this->SetX(15);
         $this->Row(array('Realizado por:','Revisado por:','Aprobado por:',utf8_decode('Recibí conforme:')),0,0);

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

    function getOrdenes(){

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
                         tb052.created_at as fecha_comp,
                         tb008.nu_codigo,
                         de_tipo_movimiento,
                         tb001.nb_usuario,
                         tb027.co_tipo_solicitud,
                         tb082.de_ejecutor
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
                  where tb030.co_ruta = ".$_GET['codigo']; //$conex->decrypt($_GET['codigo']);

          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];
    }

    function getMateriales(){

	  $conex = new ConexionComun();
          $sql = "SELECT (substr(tx_producto,1,50)||'-'||substr(tb053.detalle,1,50)) as tx_producto,
                         tb053.nu_cantidad,
                         tb052.nu_iva,
                         tb048.cod_producto,
                         tb053.precio_unitario,
                         tb057.tx_unidad_producto,
                         tb053.monto
                  FROM tb052_compras as tb052
                  left join tb053_detalle_compras as tb053 on tb053.co_compras = tb052.co_compras and tb053.in_calcular_iva is true
                  left join tb048_producto as tb048 on tb053.co_producto = tb048.co_producto
                  left join tb057_unidad_producto as tb057 on tb057.co_unidad_producto = tb053.co_unidad_producto
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud
                  where tb030.co_ruta = ".$_GET['codigo']; //$conex->decrypt($_GET['codigo']);



          return $conex->ObtenerFilasBySqlSelect($sql);

    }

    function getPartidas()
    {
        $conex = new ConexionComun();
        $sql ="   select distinct
                         substr(tb085.co_categoria,1,6) as co_categoria,
                         tb085.de_partida,
                         tb085.nu_partida,
                         upper(tb052.tx_observacion) as tx_observacion,
                         sum(case when (tb053.in_calcular_iva) then tb053.monto else tb052.monto_iva end) as monto
                  from  tb052_compras as tb052
                  left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras
                  left join tb085_presupuesto as tb085 on tb085.id = tb053.co_presupuesto
                  left join tb084_accion_especifica as tb084 on tb085.id_tb084_accion_especifica = tb084.id
                  left join tb083_proyecto_ac as tb083 on tb084.id_tb083_proyecto_ac = tb083.id
                  left join tb082_ejecutor as tb082 on tb082.id = tb083.id_tb082_ejecutor
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud and tb030.in_cargar_dato is true
                  where tb030.co_ruta = ".$_GET['codigo'].' group by 1, 2, 3, 4 '; //$conex->decrypt($_GET['codigo']);
       // echo var_dump($sql); exit();

        return $conex->ObtenerFilasBySqlSelect($sql);

    }

    function getExpendiente(){

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
                         tiempo_garantia,
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
                  where tb030.co_ruta = ".$_GET['codigo']; //$conex->decrypt($_GET['codigo']);

          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];

    }


}


$pdf=new PDF_Flo('P','mm','letter');
$pdf->AliasNbPages();
//$pdf->PuntoCuenta();
$pdf->PrintChapter();

$comm = new ConexionComun();
$ruta = $comm->getRuta();

//rmdir($ruta);
//mkdir($ruta, 0777, true);

$dir="$ruta".$_GET["codigo"].".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";


$update = "update tb030_ruta set tx_ruta_reporte = '".$dir."' where co_ruta = ".$_GET['codigo']; //$comm->decrypt($_GET["codigo"]);

//echo $update; exit();
$comm->Execute($update);
$pdf->SetMargins(0, 0, 0);
$pdf->Output($dir, 'F');

//$pdf=new PDF_Flo('P','mm','letter');
//$pdf->PrintChapter();
//$pdf->SetDisplayMode('default');
//$pdf->Output();

?>
