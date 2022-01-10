<?php
include("ConexionComun.php");
require('flowing_block.php');

class PDF_Flo extends PDF_FlowingBlock
{

    public $title;
    public $conexion;
    
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
    
    function Header() {


        $this->Image("imagenes/escudosanfco.png", 20, 7,20);

        $this->SetFont('Arial','B',9);
        
      //  $this->datos = $this->getTipoOrdenes();

        $this->SetTextColor(0,0,0);
        $this->SetY(12);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        //$this->Ln(4);
        //$this->SetFont('Arial','',8);
        //$this->Cell(0,0,utf8_decode('RIF.: G-20003652-4'),0,0,'C');
        //$this->Ln(4);
        //$this->SetFont('Arial','B',9);
        //$this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACIÓN Y FINANZAS'),0,0,'C');
        $this->Ln(5);
        $this->SetFont('Arial','',8);
    }

    function Footer() {
	$this->SetFont('Arial','',9);     
	$this->SetY(-20);
	$this->Cell(0,0,utf8_decode(''),0,0,'C');                  
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

         
         $this->datos = $this->getFacturas(); 
         $this->datosj = $this->getFacturas(); 


         
         $valores = $this->TotalMonto();

         $i= 1;
         $montoj = 0;
         $mo_retencionj=0;

         foreach($this->datos as $keyj => $valorj){
                $montoj +=  $valorj["nu_total"];

                $this->lista_retenciones = $this->getRetenciones($valorj['co_factura']);
                 if($this->lista_retenciones){
                           
                            foreach($this->lista_retenciones as $key1j => $campo1j){    
                                $mo_retencionj += $campo1j["mo_retencion"];
                            }
                }

         }
        
         $montoj = $montoj - $mo_retencionj;
         
         foreach($this->datos as $key => $valor){
             
         if ($i==1) // 1 factura
         {  
                        $style = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0); 
                        $campo='';            
                        $this->AddPage(); 
                        $this->SetX(40);
                        $this->SetY(9);
                        $this->SetFont('Times','B',12);       
                        $this->SetX(160);
                        $this->SetFillColor(255, 255, 255);
                        if($this->datos[0]['tx_serial']) $nu_pago = $this->datos[0]['tx_serial']; else $nu_pago = $this->datos[0]['co_odp'];
                        $this->MultiCell(165,5,'              ORDEN DE PAGO',0,1,'J',0);
                        $this->SetX(165);
                        $this->MultiCell(175,5,'              '.$nu_pago,0,1,'J',0);
                        $this->Ln(2);                        
                        $this->SetFont('Times','B',10);
                        $this->SetX(180);
                        //$this->Cell(0,0,utf8_decode('REL:'.$this->datos[0]['anio'].'-'.$this->datos[0]['nu_orden_compra']),0,0,'C'); 

                        $this->SetFont('Times','B',8);
                        $this->SetY(35); 
                        $this->SetX(144); //
                        $this->MultiCell(65,4,utf8_decode('FECHA DE EMISIÓN:                      ').date("d/m/Y", strtotime($this->datos[0]['fecha_odp'])),0,0,'L',0);                        
                        //$anio = date("Y");
                        $anio = $this->datos[0]['anio'];
                        $this->SetX(109); 
                        $this->MultiCell(100,4,'FECHA DE VENCIMIENTO:          '.'31/12/'.($anio+1),0,0,'L',0);                         
                        
                        $Y = $this->GetY();                        
                        $this->RoundedRect(10, 43, 50, 5, 1.5, '1001', '', $style);
                        $this->SetAligns(array("C"));
                        $this->SetWidths(array(50));                        
                        $this->Row(array('TIPO ORDEN DE PAGO'),0,0); 
                       
                        $Y = $this->GetY();
                        $this->RoundedRect(10, 48, 25, 5, 1.5, '0010', '', $style); 
                        $this->SetY($Y); 
                        $this->RoundedRect(35, 48, 25, 5, 1.5, '0100', '', $style);
                        $this->SetWidths(array(25,25));
                        $this->SetAligns(array("L","L"));
                        $this->SetFont('Times','',8);
                        $this->SetX(30); 
                        $this->MultiCell(5,5,'',1,0,'R',0); 
                        $this->SetY($Y); 
                        $this->line(56,$Y,56,$Y+5);                        
                        $this->SetY($Y); 
                        $this->SetX(55); 
                        $this->line(170,$Y,170,$Y+5);
                        $this->SetY($Y); 
                        $this->line(205,$Y,205,$Y+5);
                        $this->SetY($Y); 
                        if ($this->datos[0]['co_tipo_odp']==1) $avance='X'; else $permanente='X';
                        $this->Row(array('AVANCE:           '.$avance,'PERMANENTE: '.$permanente),0,0);  
                        
                        $this->SetFont('Times','B',8); 
                        $Y = $this->GetY();                        
                        $this->RoundedRect(150, 43, 60, 5, 1.5, '1001', '', $style);
                        $this->SetAligns(array("C"));
                        $this->SetWidths(array(60)); 
                        $this->SetY(43); 
                        $this->SetX(150);
                        $this->Row(array('FORMA DE PAGO'),0,0);
                        
                        $Y = $this->GetY();
                        $this->RoundedRect(150, 48, 25, 5, 1.5, '0010', '', $style); 
                        $this->SetY($Y); 
                        $this->RoundedRect(175, 48, 35, 5, 1.5, '0100', '', $style);
                        $this->SetWidths(array(25,35));
                        $this->SetAligns(array("L","L"));
                        $this->SetFont('Times','',8);                         
                        $this->SetX(150);
                        $this->Row(array('CHEQUE: ','TRANSFERENCIA: '),0,0);                                              
                        $this->SetAligns(array("L"));
                        $this->SetWidths(array(150));         
                        $this->SetFont('Times','B',10);
                        $Y = $this->GetY();
                        $this->SetX(10); 
                        $this->Row(array('                                                                      '),0,0);           
                        $this->SetY($Y - 4);
                        $this->SetX(135);               
                        $this->MultiCell(65,8,'',0,10,'R',0);
                        $this->SetY($Y-3);  
                        $this->SetX(138);
                        $VALOR = '**********'.number_format($valores['nu_monto'], 2, ',','.').' Bs. D';
                        $this->SetFont('Times','',9);
                        $this->Ln(3);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("L"));
                        $montoLetra = numtoletras($valores['nu_monto'],1);
                        $this->newFlowingBlock( 195, 5, '', 'J' );
                        $this->RoundedRect(10, 53, 200, 15, 1.5, '1111', '', $style);
                        $this->SetX(10);
                        $this->SetFont('Times','',9);
                        $this->WriteFlowingBlock(utf8_decode('HEMOS RECIBIDO DE LA GOBERNACIÓN DEL ESTADO ZULIA LA CANTIDAD DE:'));
                        $this->SetX(10);
                        $this->SetFont('Times','',9);
                        $this->WriteFlowingBlock(utf8_decode(' '.$montoLetra));                        
                        $this->SetX(10);
                        $this->SetFont('Times','B',11);
         
                        $this->WriteFlowingBlock(utf8_decode(' '.$VALOR));
                        //$this->Row(array(utf8_decode('HEMOS RECIBIDO DE LA GOBERNACIÓN DEL ESTADO ZULIA LA CANTIDAD DE: ').$montoLetra.' '.$VALOR),0,0);            
                        $this->finishFlowingBlock();
                        $this->SetFont('Times','',9);
                        $Y = $this->GetY();
                        $this->RoundedRect(10, 68, 200, 10, 1.5, '1111', '', $style); 
                        $this->SetY(68); 
                        $this->Row(array('A FAVOR DE: '.$this->datos[0]['tx_rif'].' - '.utf8_decode($this->datos[0]['tx_razon_social']).' '.utf8_decode($this->datos[0]['rep'])),0,0); 
                        
                        $Y = $this->GetY();
                        $this->RoundedRect(10, 78, 200, 15, 1.5, '1111', '', $style); 
                        $this->SetY(78); 
                        $this->SetX(10); 
                        $this->Row(array('POR CONCEPTO DE: '.utf8_decode($this->datos[0]['tx_observacion'])),0,0);     
                        
                        $this->SetY($Y+20); 
                        $this->SetFillColor(255, 255, 255);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("C"));
                        $this->SetFillColor(201, 199, 199); 
                        
                        $Y = $this->GetY();
                        $this->RoundedRect(10, 93, 200, 5, 1.5, '1001', '', $style); 
                        $this->SetY(93); 
                        
                        $this->SetFont('Times','B',8);
                        $this->Row(array(utf8_decode('DOCUMENTOS Y RETENCIONES')),0,0);
                        $this->SetFillColor(255, 255, 255);
                        $this->SetAligns(array("C","C","R","C","L","R","R"));
                        $this->SetWidths(array(30,15,35,15,30,30,45));                 
                        $this->SetFont('Times','',8);  
                        $Y = $this->GetY();
                        $this->RoundedRect(10, 98, 200, 50, 1.5, '0110', '', $style);                         
                        $this->SetY($Y);
                        $this->SetX(10);
                        $this->Row(array('DOCUM.','FECHA','MONTO BASE','','RETENCIONES','MONTO','CANCELADO'),0,0);
                        
                        $Y = $this->GetY();
                        $this->MultiCell(200,50,'',0,0,'L',0);
                        $this->SetY($Y);
                        $this->SetX(10);
                        $j=1; 
                        $this->lista_retenciones = $this->getRetenciones($this->datos[0]['co_factura']);

                        if($this->lista_retenciones){
                            $mo_retencion=0;
                            $sum_mo_retencion = 0;
                            foreach($this->lista_retenciones as $key => $campo1){     
                                if($j==1){
                            $this->Row(array('Fact-'.$this->datos[0]['nu_factura'], date("d/m/Y", strtotime($this->datos[0]['fe_pago'])), number_format(/*valores['nu_monto']*/$this->datos[0]['nu_monto'], 2, ',','.'), '',utf8_decode($campo1['tx_tipo_retencion']), number_format($campo1['mo_retencion'], 2, ',','.'), number_format(/*$valores['nu_monto']*/$this->datos[0]['total_pagar'], 2, ',','.')),0,0);
                                $j++;
                                }else{
                             $this->SetX(105);
                             $this->SetWidths(array(30,30)); 
                             $this->SetAligns(array("L","R"));
                                    $this->Row(array(utf8_decode($campo1['tx_tipo_retencion']),number_format($campo1['mo_retencion'], 2, ',','.')),0,0);
                                }

                                $tx_tipo_retencion = $campo1['tx_tipo_retencion'];
                                $mo_retencion = $mo_retencion + $campo1['mo_retencion'];
                                 $monto = $monto + $campo1['mo_retencion'];
                            }
                           
                            $sum_mo_retencion = $sum_mo_retencion + $campo1['mo_retencion'];
                        }else{
                                $this->Row(array('Fact-'.$this->datos[0]['nu_factura'], date("d/m/Y", strtotime($this->datos[0]['fe_pago'])), number_format(/*valores['nu_monto']*/$this->datos[0]['nu_monto'], 2, ',','.'), '',utf8_decode($campo1['tx_tipo_retencion']), number_format($campo1['mo_retencion'], 2, ',','.'), number_format(/*$valores['nu_monto']*/$this->datos[0]['total_pagar'], 2, ',','.')),0,0);
                                $j++;                        
                    }
                        $sum_mo_cancelado = $this->datos[0]['nu_monto'] - $mo_retencion;

                        //$this->Row(array('Fact-'.$this->datos[0]['nu_factura'], date("d/m/Y", strtotime($this->datos[0]['fe_pago'])), number_format(/*valores['nu_monto']*/$this->datos[0]['nu_monto'], 2, ',','.'),'','','0.00',number_format(/*$valores['nu_monto']*/$this->datos[0]['nu_monto'], 2, ',','.')),0,0);
                        
                        $j++;

                        
                        $y = $this->getY();
                        $this->line(60, $y+1, 90, $y+1);
                        $this->SetX(60);
                        $this->SetAligns(array("R"));
                        $Y = $this->GetY();
                        //$this->Row(array(number_format($valores['nu_monto'], 2, ',','.')),0,0);
                        $this->Row(array(number_format($this->datos[0]['nu_monto'], 2, ',','.')),0,0);

                        $this->line(140, $y+1, 170, $y+1);         
                        $this->SetAligns(array("R"));          
                        $this->SetY($Y);
                        $this->SetX(135);
                        //$this->Row(array('0.00'),0,0);
                        $this->Row(array(number_format($mo_retencion, 2, ',','.')),0,0);

                        $this->line(180, $y+1, 210, $y+1);        ;
                        $this->SetY($Y);
                        $this->SetAligns(array("R"));
                        $this->SetX(180);
                        //$this->Row(array(number_format($valores['nu_monto'], 2, ',','.')),0,0);    
                        $this->Row(array(number_format($sum_mo_cancelado, 2, ',','.')),0,0); 

                        $this->SetX(35);
                        $this->SetWidths(array(120)); 
                        $this->SetAligns(array("L"));
                        $this->SetFont('Times','B',8); 
                        if(count($this->datos)>1) $this->Row(array('Ver Anexos (OP con Fact. adicionales)...'),0,0);
                        
                        $this->SetY(143);
                        $this->SetWidths(array(100,100));
                        $this->SetAligns(array("C","C"));
                        $this->SetFillColor(201, 199, 199);
                        $this->SetFont('Times','B',8); 
                        $Y = $this->GetY();
                        $this->RoundedRect(10, 143, 90, 5, 1.5, '0011', '', $style); 
                        $this->SetY($Y);
                        $this->RoundedRect(100, 143, 110, 5, 1.5, '1100', '', $style); 
                        $this->SetY($Y);
                        $this->Row(array('CODIGOS CONTABLES','CATEGORIAS PRESUPUESTARIAS'),0,0);
                        $this->SetWidths(array(75,125));
                        $this->SetFillColor(255, 255, 255); 
                        $this->SetFont('Times','',8);                                                
                        $this->SetAligns(array("L","R","R","C","C","C","C","C","C","C","C","C","C","C","R"));
                        $this->SetWidths(array(32,29,29,1,9,8,9,8,7,5,5,6,8,9,33));
                        $Y = $this->GetY();
                        $this->RoundedRect(10, 148, 90, 50, 1.5, '0011', '', $style);  
                        $this->RoundedRect(100, 148, 110, 50, 1.5, '1100', '', $style);    
                        
                        
                        $this->SetY(150); 
                        
                        $this->SetX(10); 
                        $this->Row(array('CUENTA','DEBITOS','CREDITOS','',utf8_decode('AÑO'),'UE','PAC','AE','P','G','E','SE','SSE','F','MONTO'),0,0);
                        $this->SetAligns(array("L","R","R","C","C","C","C","C","C","C","C","C","C","C","R"));
                        $fila = $this->getY();                                                
                        $this->lista_asientos = $this->getAsientos($valor['co_solicitud']);
                        $this->SetFont('Times','',8);
                        foreach($this->lista_asientos as $key => $this->campo){     
                         $this->SetX(10);
                         $this->Row(array($this->campo['tx_cuenta'],number_format($this->campo['mo_debe'], 2, ',','.'),number_format($this->campo['mo_haber'], 2, ',','.'),''),0,0);

                        }
                        $Y2 = 198;
                        $this->campo="";
                        $this->SetY($fila);
                        $this->lista_partidas = $this->getPartidas();
                        foreach($this->lista_partidas as $key => $campo){  
                         $this->SetX(102); 
                         $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","R"));
                        $this->SetWidths(array(8,8,9,8,8,5,5,6,7,10,32));      
                        $this->SetFont('Times','',8);
                         $this->Row(array($campo['anio'],$campo['ue'],$campo['pac'],'00'.$campo['ae'],$campo['p'],$campo['g'],$campo['e'],$campo['se'],$campo['sse'],$campo['f'],number_format($campo['monto'], 2, ',','.')),0,0);
                        $monto_total_partidas = $monto_total_partidas + $campo['monto'];
                        }
                        $this->SetFont('Times','B',8); 
                        $this->SetWidths(array(60,80,60));
                        $this->SetAligns(array("C","C","C"));
                        $this->SetY($Y2);
                        $this->RoundedRect(10, $Y2, 60, 5, 1.5, '0011', '', $style); 
                        $this->SetY($Y);
                        $this->RoundedRect(70, $Y2, 80, 5, 1.5, '0000', '', $style); 
                        $this->SetY($Y);
                        $this->RoundedRect(150, $Y2, 60, 5, 1.5, '1100', '', $style); 
                        
                        $this->SetY($Y2);
                        $this->Row(array('BANCO','NUMERO DE CUENTA','MONTO EN Bs.D QUE CANCELA'),0,0); 
                        $Y2 = $this->GetY();
                        
                        $this->SetY($Y2);
                        $this->RoundedRect(10, $Y2, 60, 18, 1.5, '0011', '', $style); 
                        $this->SetY($Y);
                        $this->RoundedRect(70, $Y2, 80, 18, 1.5, '0000', '', $style); 
                        $this->SetY($Y);
                        $this->RoundedRect(150, $Y2, 60, 18, 1.5, '1100', '', $style);                      
                        $Y2 = $this->GetY();        
                        
                        $this->SetY(205);
                        $this->SetFont('Times','B',12); 
                        $this->SetAligns(array("L","R"));
                        $this->SetWidths(array(140,60));    

                        

                        

                        $this->Row(array('', number_format($montoj, 2, ',','.')),0,0);   
                        $this->SetWidths(array(60,80,60));
                        $this->SetFont('Times','B',8); 
                        
                        $this->SetY(221);
                        $this->SetAligns(array("C","C","C"));
                        $this->Row(array('REVISADO POR:','ORDENADO POR:','APROBADO POR:'),0,0);                      
                        $Y2 = $this->GetY();                            
                        
                        $this->SetY(221);
                        $Y2 = $this->GetY();
                        $this->RoundedRect(10, $Y2, 60, 5, 1.5, '0011', '', $style); 
                        $this->SetY($Y);
                        $this->RoundedRect(70, $Y2, 80, 5, 1.5, '0000', '', $style);                        
                        $this->SetY($Y);
                        $this->RoundedRect(150, $Y2, 60, 5, 1.5, '1100', '', $style);                      
                                  
                        
                        
                        $this->SetY(226);
                        $Y2 = $this->GetY(); 
                        $this->RoundedRect(10, $Y2, 60, 15, 1.5, '0011', '', $style); 
                        $this->SetY($Y);
                        $this->RoundedRect(70, $Y2, 80, 15, 1.5, '0000', '', $style);                       
                        $this->SetY($Y);
                        $this->RoundedRect(150, $Y2, 60, 15, 1.5, '1100', '', $style);                      
                        $Y2 = $this->GetY();                            
                                    
                        
                        $this->SetAligns(array("C","C","C","C"));
                        $this->SetWidths(array(60,80,60));
                        $this->SetFont('Times','',9); 
                        
                        $this->SetY(236);
                        $this->SetX(10);
                        $this->Row(array('Presupuesto','Secretaria Administracion y Finanzas.','Gobernador del Zulia'));
                        $this->SetY($Y2); 
                        $this->SetAligns(array("C"));
                        $this->SetWidths(array(200));
                        $this->SetFont('Times','B',8);
                        $this->SetY(241);
                        $this->RoundedRect(10, 241, 200, 5, 1.5, '1111', '', $style);
                        $this->Row(array('RECIBE CONFORME BENEFICIARIO'),0,0); 
                        
                        $this->SetY(246);
                        $Y2 = $this->GetY(); 
                        $this->RoundedRect(10, $Y2, 60, 5, 1.5, '0001', '', $style); 
                        $this->SetY($Y);
                        $this->RoundedRect(70, $Y2, 40, 5, 1.5, '0000', '', $style); 
                        $this->SetY($Y);
                        $this->RoundedRect(110, $Y2, 40, 5, 1.5, '0000', '', $style);                         
                        $this->SetY($Y);
                        $this->RoundedRect(150, $Y2, 30, 5, 1.5, '0000', '', $style);                         
                        $this->SetY($Y);                        
                        $this->RoundedRect(180, $Y2, 30, 5, 1.5, '1000', '', $style);                      
                        $Y2 = $this->GetY();                         
                       
                        $this->SetAligns(array("C","C","C","C","C"));
                        $this->SetWidths(array(60,40,40,30,30));
                        $this->SetFont('Times','B',9); 
                        $this->SetY(246); 
                        $this->SetX(10);
                        $this->Row(array('NOMBRE Y APELLIDO',utf8_decode('C.I.N°'),'FIRMA','FECHA','SELLO'),0,0);
                        
                        $this->SetY(251);
                        $Y2 = $this->GetY(); 
                        $this->RoundedRect(10, $Y2, 60, 22, 1.5, '0010', '', $style); 
                        $this->SetY($Y);
                        $this->RoundedRect(70, $Y2, 40, 22, 1.5, '0000', '', $style); 
                        $this->SetY($Y);
                        $this->RoundedRect(110, $Y2, 40, 22, 1.5, '0000', '', $style);                         
                        $this->SetY($Y);
                        $this->RoundedRect(150, $Y2, 30, 22, 1.5, '0000', '', $style);                         
                        $this->SetY($Y);                        
                        $this->RoundedRect(180, $Y2, 30, 22, 1.5, '0100', '', $style);                      
                        $Y2 = $this->GetY();  
                       
                        
                   if(count($this->datos)>1){
                    
                    $this->AddPage();  
                    $this->SetFont('courier','B',8);
                    $this->SetX(40);
                    $this->SetY(20);
                    $this->SetFont('courier','B',10);     
                    $this->SetX(145);
                    $this->SetFillColor(255, 255, 255);
                    if($this->datos[0]['tx_serial']) $nu_pago = $valor['tx_serial']; else $nu_pago = $valor['co_odp'];
                    $this->MultiCell(175,20,'ANEXOS '.$nu_pago,0,1,'J',0);
                    $this->SetX(155); //COLUMNA
                    $this->SetFont('courier','',6);
                    $this->MultiCell(175,3,utf8_decode('Fecha de Emisión:    ').date("d/m/Y", strtotime($this->datos[0]['fecha_odp'])),0,1,'R',0);
                    $this->SetX(155); //COLUMNA
                    //$anio = date("Y");
                    $anio = $this->datos[0]['anio'];
                    $this->MultiCell(175,3,utf8_decode('Fecha de Vencimiento: ').'31/12/'.($anio+1),0,1,'R',0); 
                    $this->Ln(1);                      
                    $this->SetWidths(array(200));
                    $this->SetAligns(array("C"));
                    $this->SetFillColor(201, 199, 199);         
                    $this->SetFont('courier','B',8);
                    $this->Row(array(utf8_decode('DOCUMENTOS Y RETENCIONES')),1,1);
                    
                    $this->SetFillColor(255, 255, 255);
                    $this->SetAligns(array("L","L"));
                    $this->SetWidths(array(40,160));         
                    $this->SetFont('courier','',6);
                    $this->SetAligns(array("C","C","L","R","L","R","R"));
                    $this->SetWidths(array(30,15,44,25,25,30,31));                 
                    $this->SetFont('courier','',6);          
                    $this->Row(array('Nro DOCUM.','FECHA', utf8_decode('DESCRIPCIÓN'),'MONTO','RETENCIONES','MONTO','CANCELADO'),1,1);
                    $Y = $this->GetY();
                    //$this->MultiCell(200,45,'',1,1,'L',1);
                    $this->SetY($Y);
                    $this->SetAligns(array("C","C","L","R","L","R","R"));
                                        
                    
                   }                        
                        
                        $i++;
         }
         elseif($i>1){ // Varias

                    $campo1='';
                    $this->lista_retenciones = $this->getRetenciones($valor['co_factura']);

                    //var_dump($this->lista_retenciones); exit();
                    $monto = 0;
                    $j=1;
                    if($this->lista_retenciones){
                    foreach($this->lista_retenciones as $key => $campo1){     
                        if($j==1){
                                $Y = $this->GetY();
                                //$this->MultiCell(200,50,'',0,0,'L',0);
                                $this->SetAligns(array("C","C","L","R","L","R","R"));
                                $this->SetWidths(array(30,15,44,25,25,30,31));
                                $this->SetX(10);
                                $this->Row(array('Fact-'.$valor['nu_factura'], date("d/m/Y", strtotime($valor['fe_pago'])), utf8_decode($valor['tx_concepto']), number_format($valor['nu_total'], 2, ',','.'),utf8_decode($campo1['tx_tipo_retencion']),number_format($campo1['mo_retencion'], 2, ',','.'),number_format($valor['total_pagar'], 2, ',','.')),0,0);
                                $j++;
                            } 
                        else
                            {   
                             //$this->SetX(124);
                                $this->SetAligns(array("C","C","L","R","L","R","R"));
                                $this->SetWidths(array(30,15,44,25,25,30,31));
                            $this->Row(array('Fact-'.$valor['nu_factura'], date("d/m/Y", strtotime($valor['fe_pago'])), utf8_decode($valor['tx_concepto']), number_format($valor['nu_total'], 2, ',','.'),utf8_decode($campo1['tx_tipo_retencion']),number_format($campo1['mo_retencion'], 2, ',','.'),number_format($valor['total_pagar'], 2, ',','.')),0,0);
                            }
                         $monto = $monto + $campo1['mo_retencion'];
                        } 
                    }else{
                        
                                 if($this->getY()>240){
                                    $this->AddPage();  
                                    $this->SetFont('courier','B',8);
                                    $this->SetX(40);
                                    $this->SetY(20);
                                    $this->SetFont('courier','B',10);     
                                    $this->SetX(145);
                                    $this->SetFillColor(255, 255, 255);
                                    if($this->datos[0]['tx_serial']) $nu_pago = $valor['tx_serial']; else $nu_pago = $valor['co_odp'];
                                    $this->MultiCell(175,20,'ANEXOS '.$nu_pago,0,1,'J',0);
                                    $this->SetX(155); //COLUMNA
                                    $this->SetFont('courier','',6);
                                    $this->MultiCell(175,3,utf8_decode('Fecha de Emisión:    ').date("d/m/Y", strtotime($this->datos[0]['fecha_odp'])),0,1,'R',0);
                                    $this->SetX(155); //COLUMNA
                                    //$anio = date("Y");
                                    $anio = $this->datos[0]['anio'];
                                    $this->MultiCell(175,3,utf8_decode('Fecha de Vencimiento: ').'31/12/'.($anio+1),0,1,'R',0); 
                                    $this->Ln(1);                      
                                    $this->SetWidths(array(200));
                                    $this->SetAligns(array("C"));
                                    $this->SetFillColor(201, 199, 199);         
                                    $this->SetFont('courier','B',8);
                                    $this->Row(array(utf8_decode('DOCUMENTOS Y RETENCIONES')),1,1);

                                    $this->SetFillColor(255, 255, 255);
                                    $this->SetAligns(array("L","L"));
                                    $this->SetWidths(array(40,160));         
                                    $this->SetFont('courier','',6);
                                    $this->SetAligns(array("C","C","L","R","L","R","R"));
                                    $this->SetWidths(array(30,15,44,25,25,30,31));                 
                                    $this->SetFont('courier','',6);          
                                    $this->Row(array('Nro DOCUM.','FECHA', utf8_decode('DESCRIPCIÓN'),'MONTO','RETENCIONES','MONTO','CANCELADO'),1,1);
                                    $Y = $this->GetY();
                                    //$this->MultiCell(200,45,'',1,1,'L',1);
                                    $this->SetY($Y);
                                    $this->SetAligns(array("C","C","L","R","L","R","R"));

                                 }                        
                                $Y = $this->GetY();
                                //$this->MultiCell(200,50,'',0,0,'L',0);
                                $this->SetY($Y);
                                $this->SetAligns(array("C","C","L","R","L","R","R"));
                                //$this->SetX(10);
                                $this->Row(array('Fact-'.$valor['nu_factura'], date("d/m/Y", strtotime($valor['fe_pago'])), utf8_decode($valor['tx_concepto']), number_format($valor['nu_total'], 2, ',','.'),'','',number_format($valor['total_pagar'], 2, ',','.')),0,0);
                                $j++;                        
                    }
                        
//                                      $y = $this->getY();
//                        $this->line(105, $y+1, 123, $y+1);
//                        $this->SetX(105);
//                        $this->SetAligns(array("R"));
//                        $Y = $this->GetY();
//                        $this->SetWidths(array(20));                        
//                        $this->Row(array(number_format($valor['nu_total'], 2, ',','.')),0,0);
//
//                        $this->line(160, $y+1, 180, $y+1);         
//                        $this->SetAligns(array("R"));          
//                        $this->SetY($Y);
//                        $this->SetX(156);
//                        $this->SetWidths(array(23));  
//                        $this->Row(array(number_format($monto, 2, ',','.')),0,0);
//
//                        $this->line(188, $y+1, 210, $y+1);        ;
//                        $this->SetY($Y);
//                        $this->SetAligns(array("R"));
//                        $this->SetX(184);
//                        $this->SetWidths(array(25));  
//                        $this->Row(array(number_format($valor['total_pagar'], 2, ',','.')),0,0);          
                        
                        $i++;
         }
         $total = $total + $valor['nu_total'];
         $total_retencion = $total_retencion + $monto;
         $total_cancelado = $total - $total_retencion;             

                   }
                   
         if(count($this->datos)>1){
                        $y = $this->getY();
                        $this->line(105, $y+1, 123, $y+1);
                        $this->SetX(85);
                        $this->SetAligns(array("R"));
                        $Y = $this->GetY();
                        $this->SetWidths(array(40));                        
                        $this->Row(array('Total Monto:'.number_format($total, 2, ',','.')),0,0);

                        $this->line(160, $y+1, 180, $y+1);         
                        $this->SetAligns(array("R"));          
                        $this->SetY($Y);
                        $this->SetX(135);
                        $this->SetWidths(array(45));  
                        $this->Row(array('Total Retenciones:'.number_format($total_retencion, 2, ',','.')),0,0);

                        $this->line(188, $y+1, 210, $y+1);        ;
                        $this->SetY($Y);
                        $this->SetAligns(array("R"));
                        $this->SetX(179);
                        $this->SetWidths(array(30));  
                        $this->Row(array('Total '.number_format($total_cancelado, 2, ',','.')),0,0);
                        
         }                   

                    $this->lista_otras_partidas = $this->getOtrasPartidas();
                    if(count($this->lista_otras_partidas)>0){
                        
                        
                    $this->AddPage();  
                    $this->SetFont('courier','B',8);
                    $this->SetX(40);
                    $this->SetY(20);
                    $this->SetFont('courier','B',10);     
                    $this->SetX(145);
                    $this->SetFillColor(255, 255, 255);
                    if($this->datos[0]['tx_serial']) $nu_pago = $valor['tx_serial']; else $nu_pago = $valor['co_odp'];
                    $this->MultiCell(175,20,'ANEXOS '.$nu_pago,0,1,'J',0);
                    $this->SetX(155); //COLUMNA
                    $this->SetFont('courier','',6);
                    $this->MultiCell(175,3,utf8_decode('Fecha de Emisión:    ').date("d/m/Y", strtotime($this->datos[0]['fecha_odp'])),0,1,'R',0);
                    $this->SetX(155); //COLUMNA
                    //$anio = date("Y");
                    $anio = $this->datos[0]['anio'];
                    $this->MultiCell(175,3,utf8_decode('Fecha de Vencimiento: ').'31/12/'.($anio+1),0,1,'R',0); 
                    $this->Ln(1);                      
                    $Y = $this->GetY();
                    //$this->MultiCell(200,45,'',1,1,'L',1);
                    $this->SetY($Y);
                    $this->SetAligns(array("C","C","L","R","L","R","R"));                        

                        $this->SetWidths(array(75,125));
                        $this->SetAligns(array("C","C"));
                        $this->SetFillColor(201, 199, 199);
                        $this->SetFont('Times','B',7); 
                        $this->Row(array('                 ','                         '),0,0);
                        $this->SetFillColor(255, 255, 255); 
                        $this->SetFont('Times','B',8);                                                
                        $this->SetAligns(array("L","R","R","C","C","C","C","C","C","C","C","C","C","C","R"));
                        $this->SetWidths(array(40,25,25,15,9,8,9,8,7,5,5,6,8,9,19));
                        $this->SetX(10); 
                        $this->Row(array('','DEBITOS','CREDITOS','',utf8_decode('AÑO'),'UE','PAC','AE','P','G','E','SE','SSE','F','MONTO'),0,0);
                        $this->SetAligns(array("L","R","R","C","C","C","C","C","C","C","C","C","C","C","R"));
                        $fila = $this->getY();
                        $Y = $this->GetY();
                        $this->MultiCell(200,45,'',0,0,'L',0);
                        $this->SetY($Y);                    
                        $this->lista_otros_asientos = $this->getOtrosAsientos($valor['co_solicitud']);
                        $this->SetFont('Times','B',10);
                        foreach($this->lista_otros_asientos as $key => $this->campo){     
                         $this->SetX(10);
                         $monto_debe = $monto_debe + $this->campo['mo_debe'];
                         $monto_haber = $monto_haber + $this->campo['mo_haber'];                         
                         
                        }
                        $this->Row(array('',number_format($monto_debe, 2, ',','.'),number_format($monto_haber, 2, ',','.'),''),0,0);
                        $monto_total_otras_partidas = 0;
                        $this->campo="";
                        $this->SetY($fila);
                        $this->lista_otras_partidas = $this->getOtrasPartidas();
                        foreach($this->lista_otras_partidas as $key => $campo){  
                         $this->SetX(115); 
                         $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","R"));
                        $this->SetWidths(array(8,8,9,8,8,5,5,6,7,10,19));      
                        $this->SetFont('Times','',8);
                         $this->Row(array($campo['anio'],$campo['ue'],$campo['pac'],'00'.$campo['ae'],$campo['p'],$campo['g'],$campo['e'],$campo['se'],$campo['sse'],$campo['f'],number_format($campo['monto'], 2, ',','.')),0,0);
                         $monto_total_otras_partidas =  $monto_total_otras_partidas + $campo['monto'];
                         if($this->getY()>230){
                         $this->AddPage();
                    $this->SetFont('courier','B',8);
                    $this->SetX(40);
                    $this->SetY(20);
                    $this->SetFont('courier','B',10);     
                    $this->SetX(145);
                    $this->SetFillColor(255, 255, 255);
                    if($this->datos[0]['tx_serial']) $nu_pago = $valor['tx_serial']; else $nu_pago = $valor['co_odp'];
                    $this->MultiCell(175,20,'ANEXOS '.$nu_pago,0,1,'J',0);
                    $this->SetX(155); //COLUMNA
                    $this->SetFont('courier','',6);
                    $this->MultiCell(175,3,utf8_decode('Fecha de Emisión:    ').date("d/m/Y", strtotime($this->datos[0]['fecha_odp'])),0,1,'R',0);
                    $this->SetX(155); //COLUMNA
                    //$anio = date("Y");
                    $anio = $this->datos[0]['anio'];
                    $this->MultiCell(175,3,utf8_decode('Fecha de Vencimiento: ').'31/12/'.($anio+1),0,1,'R',0); 
                    $this->Ln(1);                         
                        $this->SetWidths(array(75,125));
                        $this->SetAligns(array("C","C"));
                        $this->SetFillColor(201, 199, 199);
                        $this->SetFont('Times','B',7); 
                        $this->Row(array('                 ','                         '),0,0);
                        $this->SetFillColor(255, 255, 255); 
                        $this->SetFont('Times','',8);                                                
                        $this->SetAligns(array("L","R","R","C","C","C","C","C","C","C","C","C","C","C","R"));
                        $this->SetWidths(array(40,25,25,15,9,8,9,8,7,5,5,6,8,9,19));
                        $this->SetX(10); 
                        $this->Row(array('','DEBITOS','CREDITOS','',utf8_decode('AÑO'),'UE','PAC','AE','P','G','E','SE','SSE','F','MONTO'),0,0);
                        $this->SetAligns(array("L","R","R","C","C","C","C","C","C","C","C","C","C","C","R"));
                        $fila = $this->getY();
                        $Y = $this->GetY();
                        $this->MultiCell(200,45,'',0,0,'L',0);
                        $this->SetY($Y); 
                        foreach($this->lista_otros_asientos as $key => $this->campo){     
                         $this->SetX(10);
                         $monto_debe = $monto_debe + $this->campo['mo_debe'];
                         $monto_haber = $monto_haber + $this->campo['mo_haber'];
                         
                        }  
                         $this->Row(array('',number_format($monto_debe, 2, ',','.'),number_format($monto_haber, 2, ',','.'),''),0,0);
                         $this->SetX(115); 
                         $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","R"));
                         $this->SetWidths(array(8,8,9,8,8,5,5,6,7,10,19));      
                         $this->SetFont('Times','B',8);
                         $this->Row(array($campo['anio'],$campo['ue'],$campo['pac'],'00'.$campo['ae'],$campo['p'],$campo['g'],$campo['e'],$campo['se'],$campo['sse'],$campo['f'],number_format($campo['monto'], 2, ',','.')),0,0);
                                                      
                         }
                        }
                        $monto_total = $monto_total_partidas + $monto_total_otras_partidas;
                        $this->SetX(115); 
                        $this->SetAligns(array("R","R"));
                        $this->SetWidths(array(69,25));      
                        $this->SetFont('Times','B',8);
                        $this->Row(array('Total',number_format($monto_total, 2, ',','.'),''),0,0);
         }         
         
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
        
        $this->ChapterBody();      
    }

    function TotalMonto(){

            $conex = new ConexionComun();     
            $sql = "select sum(tb045.nu_total) as nu_monto, sum(tb045.total_pagar) as total_pagar
                  from   tb026_solicitud as tb026
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud                                                   
                  left join tb045_factura as tb045 on tb045.co_compra = tb052.co_compras 
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud 
                  where tb030.co_ruta =".$_GET['codigo']." group by tb045.co_compra";

          //echo $sql; exit();
               
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];  
    }


    
    function getFacturas(){

          $conex = new ConexionComun();     
          $sql = "select distinct   nu_factura, 
                          tb045.fe_emision as fe_pago, 
                          co_compra,
                          co_factura,
                          nu_base_imponible, 
                          to_char(tb045.fe_emision,'dd/mm/yyyy') as fe_emision,                          
                          co_iva_factura, 
                          nu_iva_factura, 
                          nu_total, 
                          tb045.co_iva_retencion, 
                          nu_iva_retencion, 
                          substr(tb045.tx_concepto,1,50) as tx_concepto, 
                          tb045.co_compra as nu_compra, 
                          numero_compra,
                          nu_total_retencion, 
                          total_pagar,
                         tb060.tx_concepto as tx_observacion,
                         tb008.tx_razon_social,
                         (tb007.inicial||'-'||tb008.tx_rif) as tx_rif,                        
                         upper(tb008.nb_representante_legal) as nb_representante_legal,
                         tb008.nu_cedula_representante,
                         tb047.tx_ente,  
                         tb001.nb_usuario,
                         --tb062.mo_pagar as nu_monto,
                         tb045.nu_total as nu_monto,
                         tb052.anio,
                         tb052.co_solicitud,
                         tb039.nu_requisicion,  
                         tb039.tx_concepto as concepto_req,
                         tb039.created_at, 
                         tb045.co_odp,
                         tb060.fe_emision as fecha_odp,
                         tb052.nu_orden_compra,
                         tb060.tx_serial,
                         case when(tb045.co_iva_factura = 0) then nu_total else '0' end as monto_excento,
                         tb060.co_tipo_odp
                  from   tb026_solicitud as tb026
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud                                                   
                  left join tb045_factura as tb045 on tb045.co_compra = tb052.co_compras
                  left join tb060_orden_pago as tb060 on tb060.co_orden_pago = tb045.co_odp
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor 
                  left join tb039_requisiciones as tb039 on tb045.co_solicitud = tb039.co_solicitud
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb026.co_usuario
                  left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente
                  left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud 
                  left join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
                  where tb030.co_ruta =".$_GET['codigo']." and tb060.in_anulado = false order by co_factura asc ";
               
        //  echo var_dump($sql);  exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;   
    }
    function getRetenciones($fact){

	  $conex = new ConexionComun();
          $sql = "select  nu_factura, 
                          fe_emision, 
                          nu_base_imponible,                           
                          nu_iva_factura, 
                          nu_total,                           
                          nu_iva_retencion, 
                          substr(tx_concepto,1,8) as tx_concepto,                           
                          nu_total_retencion, 
                          total_pagar,
                          po_retencion,
                          mo_retencion,
                          substr(tx_tipo_retencion,1,12) as tx_tipo_retencion
                  from   tb045_factura as tb045     
                  left join tb046_factura_retencion as tb046 on tb046.co_factura = tb045.co_factura
                  left join tb041_tipo_retencion as tb041 on tb041.co_tipo_retencion = tb046.co_tipo_retencion
                  where mo_retencion<>0 and tb045.co_factura = ".$fact; 
                       
           
          return $conex->ObtenerFilasBySqlSelect($sql);
  
    }
    
    function getPartidas($fact)
    {
                    
          $conex = new ConexionComun(); 
                    
          $sql = "select tb085.co_categoria,
                         anio,
                         nu_ejecutor as ue,
                         tb080.nu_sector||'.'||nu_proyecto_ac as pac,
                         nu_accion_especifica as ae,
                         nu_pa as p,                         
                         nu_ge as g,
                         nu_es as e,
                         nu_se as se,
                         nu_sse as sse,
                         nu_fi as f,
                         sum(monto) as monto
                  from  tb052_compras as tb052 
                  left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras 
                  left join tb085_presupuesto as tb085 on tb085.id = tb053.co_presupuesto
                  left join tb084_accion_especifica as tb084 on tb085.id_tb084_accion_especifica = tb084.id
                  left join tb083_proyecto_ac as tb083 on tb084.id_tb083_proyecto_ac = tb083.id
                  left join tb082_ejecutor as tb082 on tb082.id = tb083.id_tb082_ejecutor
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud                               
                 left join tb080_sector as tb080 on tb080.id = tb083.id_tb080_sector                 
                  where tb030.co_ruta =".$_GET['codigo']." 
                   group by 1,2,3,4,5,6,7,8,9,10,11 limit 8";

         // echo var_dump($sql); exit();                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }
    
    function getOtrasPartidas($fact)
    {
                    
          $conex = new ConexionComun(); 
                    
          $sql = "select tb085.co_categoria,
                         anio,
                         nu_ejecutor as ue,
                         tb080.nu_sector||'.'||nu_proyecto_ac as pac,
                         nu_accion_especifica as ae,
                         nu_pa as p,                         
                         nu_ge as g,
                         nu_es as e,
                         nu_se as se,
                         nu_sse as sse,
                         nu_fi as f,
                         sum(monto) as monto
                  from  tb052_compras as tb052 
                  left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras 
                  left join tb085_presupuesto as tb085 on tb085.id = tb053.co_presupuesto
                  left join tb084_accion_especifica as tb084 on tb085.id_tb084_accion_especifica = tb084.id
                  left join tb083_proyecto_ac as tb083 on tb084.id_tb083_proyecto_ac = tb083.id
                  left join tb082_ejecutor as tb082 on tb082.id = tb083.id_tb082_ejecutor
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud                               
                 left join tb080_sector as tb080 on tb080.id = tb083.id_tb080_sector                 
                  where tb030.co_ruta =".$_GET['codigo']." 
                   group by 1,2,3,4,5,6,7,8,9,10,11 limit 5000 offset 8";

         // echo var_dump($sql); exit();                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }    
    
    function getAsientos($fact)
    {
                    
          $conex = new ConexionComun(); 
                    
          $sql = "select distinct tb024.tx_cuenta, 
                         sum(tb061.mo_haber) as mo_haber,
                         sum(tb061.mo_debe) as mo_debe,
                         co_tipo_asiento
                  from   tb026_solicitud as tb026  
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud 
                  left join tb008_proveedor as tb008 on tb008.co_proveedor = tb052.co_proveedor  
                  left join tb061_asiento_contable as tb061 on tb026.co_solicitud = tb061.co_solicitud 
                  left join tb060_orden_pago as tb060 on tb060.co_solicitud = tb061.co_solicitud 
                  left join tb024_cuenta_contable as tb024 on tb024.co_cuenta_contable = tb061.co_cuenta_contable  
                  where ((tb061.co_tipo_asiento=2 and mo_haber is not null) or (tb061.co_tipo_asiento=2 and mo_debe is not null)) 
                  and tb061.co_solicitud = ".$fact." group by tb024.tx_cuenta,co_tipo_asiento order by  co_tipo_asiento desc";
                   
         // echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }
    
    function getOtrosAsientos($fact)
    {
                    
          $conex = new ConexionComun(); 
                    
          $sql = "select distinct 
                         tb061.mo_haber,
                         tb061.mo_haber as mo_debe,
                         co_tipo_asiento
                  from   tb026_solicitud as tb026  
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud 
                  left join tb008_proveedor as tb008 on tb008.co_proveedor = tb052.co_proveedor  
                  left join tb061_asiento_contable as tb061 on tb026.co_solicitud = tb061.co_solicitud 
                  left join tb060_orden_pago as tb060 on tb060.co_solicitud = tb061.co_solicitud 
                  left join tb024_cuenta_contable as tb024 on tb024.co_cuenta_contable = tb061.co_cuenta_contable  
                  where ((tb061.co_tipo_asiento=2 and mo_haber is not null)) 
                  and tb061.co_solicitud = ".$fact." order by  co_tipo_asiento desc ";
                   
         // echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }    


}

$pdf=new PDF_Flo('P','mm','letter');
$pdf->AliasNbPages();
$pdf->PrintChapter();

$comm = new ConexionComun();
$ruta = $comm->getRuta();

//rmdir($ruta);
//mkdir($ruta, 0777, true);    

$dir="$ruta".$_GET["codigo"].".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";
//
//
$update = "update tb030_ruta set tx_ruta_reporte = '".$dir."' where co_ruta = ".$_GET['codigo']; //$comm->decrypt($_GET["codigo"]);
//
////echo $update; exit();
$comm->Execute($update);    
$pdf->SetMargins(0, 0);
$pdf->Output($dir, 'F');


//$pdf=new PDF_Flo('P','mm','letter');
//$pdf->PrintChapter();
//$pdf->SetMargins(0, 0);
//$pdf->SetDisplayMode('default');
//$pdf->Output();

?>