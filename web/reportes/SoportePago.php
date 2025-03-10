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
        
        if (!empty($this->empresa['nb_institucion'])) {
            $this->Ln(2);
            $this->SetX(52);
            $this->MultiCell(110,4,utf8_decode($this->empresa['nb_institucion']),0,'C',0); 
            $this->Ln(2);
        }else{
        $this->Ln(4);    
        }
        $this->Cell(0, 0, utf8_decode('RIF. ' . $this->empresa['tx_rif']), 0, 0, 'C');
        $this->Ln(4);
//        $this->Cell(0, 0, utf8_decode('DIRECCIÓN DE ADMINISTRACIÓN Y FINANZAS'), 0, 0, 'C');
//         $this->Ln(10);
//         $this->Cell(0,0,utf8_decode('TRANSFERENCIA TERCEROS #'.$this->datos['nu_serial_pago']),0,0,'C');      
     

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
         $this->Ln(10);
         $this->Cell(0,0,utf8_decode('TRANSFERENCIA TERCEROS #'.$this->datos['nu_serial_pago']),0,0,'C'); 
         $this->Ln(5);
        $this->SetFont('Arial','',8);
        $this->Cell(0,0,utf8_decode('Fecha Transferencia: '.$this->datos['fe_emision']),0,0,'R');
 
         $this->Ln(5);
         $this->RoundedRect(10, 50, 200, 15, 0.5, '1001', '', $style);
              $this->Ln(5);
              $this->SetY(52);
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
         $this->RoundedRect(10, 120, 200, 14, 0.5, '1001', '', $style);
         
         $this->SetX(25);
         $this->Cell(200,5,utf8_decode('MOTIVO DE LA TRANSFERENCIA'),0,0,'L');   
         $this->Ln(10);
         $this->SetX(25);
         $this->MultiCell(185,5,utf8_decode($this->datos['de_observacion']),0,1,'L',1); 
         
          $this->RoundedRect(10, 139, 200, 10, 0.5, '1001', '', $style);
          $this->RoundedRect(11, 140, 198, 8, 0.5, '1001', '', $style);
         $this->Ln(10); 
         $this->SetX(25);
         $this->Cell(200,5,utf8_decode('ORDEN DE PAGO'),0,0,'L');
         $this->SetX(80);
         $this->Cell(200,5,utf8_decode('DEDUCCIÓN'),0,0,'L');          
         $this->SetX(153);
         $this->Cell(200,5,utf8_decode('TOTAL DEDUCCIONES'),0,0,'L');
         
          $this->RoundedRect(10, 154, 200, 46, 0.5, '1001', '', $style);
          
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
         
         
         $this->CuerpoRetenciones();
         
          

    }
    
    
    function CuerpoRetenciones() {  
        
        $this->empresa = $this->getDatosEmpresa(1);


            
             $this->lista_retenciones = $this->getRetenciones($this->datos['co_orden_pago'],2);
             
            
            if(count($this->lista_retenciones)>0){                     
                
            $this->AddPage();
            
            $this->datos1 = $this->getFacturas(); 
            $this->nro_comprobante = $this->getComprobante($this->datos['co_solicitud'],2);

            $this->Ln(5);      
            
            
            
            
            $this->SetFont('Arial','B',9);
            $this->Cell(0,0,utf8_decode('COMPROBANTE DE RETENCIÓN DEL IMPUESTO POR TIMBRE FISCAL'),0,0,'C'); 
            $this->Ln(1);
            $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _'),0,0,'C'); 
            $this->Ln(5);                 
                
            $this->SetFillColor(201, 199, 199);
            $this->SetWidths(array(170,30, 30));
            $this->SetAligns(array("R","L"));
            $this->SetFont('Arial','B',8);
            $this->Row(array(utf8_decode('Nro. Comprobante:'),utf8_decode($this->nro_comprobante['anio'].$this->nro_comprobante['mes'].$this->nro_comprobante['nu_comprobante'])),0,0);   
            $this->Row(array(utf8_decode('Fecha de Emisión:'),utf8_decode($this->nro_comprobante['fe_emision'])),0,0);
            $this->Ln(5);  
            
            $this->RoundedRect(10, $this->getY()-3, 95, 50, 0.5, '1001', '', $style);         
            $this->RoundedRect(110, $this->getY()-3, 95, 50, 0.5, '1001', '', $style);    

            $this->Cell(95,0,utf8_decode('DATOS DEL AGENTE DE RETENCIÓN'),0,0,'C');
            $this->Cell(5,0,utf8_decode(''),0,0,'C');
            $this->Cell(95,0,utf8_decode('DATOS DEL CONTRIBUYENTE'),0,0,'C'); 
            $this->Ln(8);
            
            if (!empty($this->empresa['nb_institucion'])) 
            {
            $agente_retencion = utf8_decode($this->empresa['nb_institucion']);
            }else{
            $agente_retencion = utf8_decode($this->empresa['nb_empresa']);    
            }
            $y= $this->GetY();           
            $this->SetY($y);
            $this->SetX(12);
            $this->MultiCell(90,4,$agente_retencion,0,1,'J',0);
            $z= $this->GetY();
            $this->SetY($y);            
            $this->SetX(112);
            $this->MultiCell(90,4,utf8_decode($this->datos1['tx_razon_social']),0,1,'J',0);
            $p= $this->GetY();
            $cant = $z-$y;
            $this->SetX(12);
            $this->SetFont('Arial','',8); 
            if($z==$p){
            if($cant==4){
             $q = $y +4;      
            }else{
             $q = $y +8;                  
            }
            }else{
            $q = $y +8;    
            }
            $this->SetY($q);
            $this->SetX(12);
            $this->MultiCell(90,4,utf8_decode('R.I.F. Agente de Retención:'),0,1,'J',0);
            $this->SetY($q);
            $this->SetX(112);
            $this->MultiCell(90,4,utf8_decode('R.I.F. Contribuyente:'),0,1,'J',0);
            
            $y= $this->GetY();
            $this->SetY($y);            
            $this->SetX(12);
            $this->SetFont('Arial','B',8);            
            $this->MultiCell(90,4,utf8_decode($this->empresa['tx_rif']),0,1,'J',0);
            $this->SetY($y);
            $this->SetX(112);            
            $this->MultiCell(90,4,utf8_decode($this->datos1['tx_rif']),0,1,'J',0);
            $y= $this->GetY();
            $this->SetY($y);              
            $this->SetX(12);
            $this->SetFont('Arial','',8);            
            $this->MultiCell(90,4,utf8_decode('Dirección Fiscal:'),0,1,'J',0); 
            $this->SetY($y);
            $this->SetX(112);    
            $this->MultiCell(90,4,utf8_decode('Dirección Fiscal:'),0,1,'J',0); 
            
            
            $this->SetFont('Arial','B',8);
            $y= $this->GetY();
            $this->SetY($y);
            $this->SetX(112);
            $this->MultiCell(90,4,utf8_decode(strtoupper($this->datos1['tx_direccion'])),0,1,'J',0); 
            $this->SetY($y);
            $this->SetX(12);
            $this->MultiCell(90,4,utf8_decode($this->empresa['tx_direccion']),0,1,'J',0);
            
                $this->Ln(15);
                 $this->SetWidths(array(20, 25, 25, 45,30,15,30)); 
                 $this->SetAligns(array("L","L","L","L","R","L","R"));              
                 $this->SetFont('Arial','B',8);
                     $this->SetFillColor(201, 199, 199);  
                 $this->SetX(10);         
                 $this->Row(array(utf8_decode('Fecha Fac.'),utf8_decode('Nro. Factura'),utf8_decode('Nro. Control'),utf8_decode('Concepto de Retención'),utf8_decode('Base Imponible'),utf8_decode('%'),utf8_decode('Monto Retenido')),0,0);  
                 $this->ln(1);
                 $this->SetX(10);
                 $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _'),0,0,'L');
                 $this->ln(5);
                 $this->SetX(10);
                 $this->Cell(0,0,utf8_decode('Orden de Pago: OP-'.$this->datos['tx_serial']),0,0,'L');
                 $this->ln(1);
                 $this->SetX(10);
                 $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _'),0,0,'L');
                 $this->ln(5);
                 
                 $total_base = 0;
                 $total_impuesto = 0;
                 
            foreach($this->lista_retenciones as $key => $campo1){
                
                 $this->SetAligns(array("L","L","L","L","R","L","R"));   
                 $this->SetFont('Arial','',8);
                 $this->Row(array(utf8_decode($campo1['fe_emision']),utf8_decode($campo1['nu_factura']),utf8_decode($campo1['nu_control']),utf8_decode('TASA POR TIMBRE FISCAL('.$this->datos1['inicial'].')'),number_format($campo1['nu_base_imponible'], 2, ',','.'),$campo1['po_retencion'],number_format($campo1['mo_retencion'], 2, ',','.')),0,0);  
                 
                 $total_base = $total_base + $campo1['nu_base_imponible'];
                 $total_impuesto = $total_impuesto + $campo1['mo_retencion'];
            
           }
           $this->SetFont('Arial','B',8);
                  $this->ln(1);
         $this->Cell(145,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
         $this->Cell(45,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
                  $this->ln(1);
         $this->Cell(145,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
                  $this->Cell(45,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
                  $this->ln(1);
 
         $this->SetWidths(array(115,30,15,30)); 
         $this->SetAligns(array("R","R","R","R")); 
         
         $this->ln(3);
         $this->SetX(10);         
         $this->Row(array('TOTAL IMPUESTO RETENIDO:',number_format($total_base, 2, ',','.'),'',number_format($total_impuesto, 2, ',','.')),0,0);   
        
         
         $this->ln(18);           
           
                 $this->ln(35); 
                 $this->SetWidths(array(200)); 
                 $this->SetAligns(array("C","C")); 
                 $this->SetX(10);        
                 $this->Row(array(utf8_decode('_ _ _ _ _ _  _ _ _ _  _ _ _ _ _  _ _')),0,0);
                 $this->SetX(10);
                 $this->Row(array(utf8_decode('Firma y Sello del Agente de Retención')),0,0); 
                
            }
            
             $this->lista_retenciones = $this->getRetenciones($this->datos['co_orden_pago'],4);
             
            
            if(count($this->lista_retenciones)>0){                     
                
            $this->AddPage();
            
            $this->datos1 = $this->getFacturas(); 
            $this->nro_comprobante = $this->getComprobante($this->datos['co_solicitud'],4);

            $this->Ln(5);      
            
            
            
            
            $this->SetFont('Arial','B',9);
            $this->Cell(0,0,utf8_decode('COMPROBANTE DE RETENCIÓN DE I.S.L.R.'),0,0,'C'); 
            $this->Ln(1);
            $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ '),0,0,'C'); 
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode('Articulo 24 Decreto 1.808 G.O. Nro. 36.203 del 12 de Mayo de 1997'),0,0,'C');
            $this->Ln(5);    
            $this->SetFillColor(201, 199, 199);
            $this->SetWidths(array(170,30, 30));
            $this->SetAligns(array("R","L"));
            $this->SetFont('Arial','B',8);
//            $this->Row(array(utf8_decode('Pagina:'),utf8_decode('1')),0,0);
            $this->Row(array(utf8_decode('Nro. Comprobante:'),utf8_decode($this->nro_comprobante['anio'].$this->nro_comprobante['mes'].$this->nro_comprobante['nu_comprobante'])),0,0);   
            $this->Row(array(utf8_decode('Fecha de Emisión:'),utf8_decode($this->nro_comprobante['fe_emision'])),0,0);
            $this->Ln(10);  
            
            $this->RoundedRect(10, $this->getY()-3, 95, 50, 0.5, '1001', '', $style);         
            $this->RoundedRect(110, $this->getY()-3, 95, 50, 0.5, '1001', '', $style);    

            $this->Cell(95,0,utf8_decode('DATOS DEL AGENTE DE RETENCIÓN'),0,0,'C');
            $this->Cell(5,0,utf8_decode(''),0,0,'C');
            $this->Cell(95,0,utf8_decode('DATOS DEL CONTRIBUYENTE'),0,0,'C'); 
            $this->Ln(8);
            
            if (!empty($this->empresa['nb_institucion'])) 
            {
            $agente_retencion = utf8_decode($this->empresa['nb_institucion']);
            }else{
            $agente_retencion = utf8_decode($this->empresa['nb_empresa']);    
            }
            $y= $this->GetY();           
            $this->SetY($y);
            $this->SetX(12);
            $this->MultiCell(90,4,$agente_retencion,0,1,'J',0);
            $z= $this->GetY();
            $this->SetY($y);            
            $this->SetX(112);
            $this->MultiCell(90,4,utf8_decode($this->datos1['tx_razon_social']),0,1,'J',0);
            $p= $this->GetY();
            $cant = $z-$y;
            $this->SetX(12);
            $this->SetFont('Arial','',8); 
            if($z==$p){
            if($cant==4){
             $q = $y +4;      
            }else{
             $q = $y +8;                  
            }
            }else{
            $q = $y +8;    
            }
            $this->SetY($q);
            $this->SetX(12);
            $this->MultiCell(90,4,utf8_decode('R.I.F. Agente de Retención:'),0,1,'J',0);
            $this->SetY($q);
            $this->SetX(112);
            $this->MultiCell(90,4,utf8_decode('R.I.F. Contribuyente:'),0,1,'J',0);
            
            $y= $this->GetY();
            $this->SetY($y);            
            $this->SetX(12);
            $this->SetFont('Arial','B',8);            
            $this->MultiCell(90,4,utf8_decode($this->empresa['tx_rif']),0,1,'J',0);
            $this->SetY($y);
            $this->SetX(112);            
            $this->MultiCell(90,4,utf8_decode($this->datos1['tx_rif']),0,1,'J',0);
            $y= $this->GetY();
            $this->SetY($y);              
            $this->SetX(12);
            $this->SetFont('Arial','',8);            
            $this->MultiCell(90,4,utf8_decode('Dirección Fiscal:'),0,1,'J',0); 
            $this->SetY($y);
            $this->SetX(112);    
            $this->MultiCell(90,4,utf8_decode('Dirección Fiscal:'),0,1,'J',0); 
            
            
            $this->SetFont('Arial','B',8);
            $y= $this->GetY();
            $this->SetY($y);
            $this->SetX(112);
            $this->MultiCell(90,4,utf8_decode(strtoupper($this->datos1['tx_direccion'])),0,1,'J',0); 
            $this->SetY($y);
            $this->SetX(12);
            $this->MultiCell(90,4,utf8_decode($this->empresa['tx_direccion']),0,1,'J',0);
            $this->Ln(15);
            $this->SetX(10);
            $this->MultiCell(90,4,utf8_decode('Banco: '.$this->datos['tx_siglas'].'-'.$this->datos['nu_cuenta_bancaria']),0,1,'J',0);
            $this->SetX(10);
            $this->Ln(5);
            $this->MultiCell(90,4,utf8_decode('Forma de Pago: ND-'.$this->datos['nu_serial_pago']),0,1,'J',0);
            
            $this->Ln(5);
                 $this->SetWidths(array(20, 20, 20, 40,25,20,15,30)); 
                 $this->SetAligns(array("L","L","L","L","R","R","L","R"));              
                 $this->SetFont('Arial','B',8);
                     $this->SetFillColor(201, 199, 199);  
                 $this->SetX(10);         
                 $this->Row(array(utf8_decode('Fecha Fac.'),utf8_decode('Nro. Factura'),utf8_decode('Nro. Control'),utf8_decode('Concepto de Retención'),utf8_decode('Base Imponible'),utf8_decode('Sustraendo'),utf8_decode('%'),utf8_decode('Monto Retenido')),0,0);  
                 $this->ln(1);
                 $this->SetX(10);
                 $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _'),0,0,'L');
                 $this->ln(5);
                 $this->SetX(10);
                 $this->Cell(0,0,utf8_decode('Orden de Pago: OP-'.$this->datos['tx_serial']),0,0,'L');
                 $this->ln(1);
                 $this->SetX(10);
                 $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _'),0,0,'L');
                 $this->ln(5);
                 
                
                 $total_base = 0;
                 $total_impuesto = 0;
                 $total_sustraendo = 0;
                 
            foreach($this->lista_retenciones as $key => $campo1){
                
                 $this->SetAligns(array("L","L","L","L","R","R","L","R"));   
                 $this->SetFont('Arial','',8);
                 $this->Row(array(utf8_decode($campo1['fe_emision']),utf8_decode($campo1['nu_factura']),utf8_decode($campo1['nu_control']),utf8_decode($campo1['de_concepto']),number_format($campo1['nu_base_imponible'], 2, ',','.'),number_format($campo1['nu_sustraendo'], 2, ',','.'),$campo1['po_retencion'],number_format($campo1['mo_retencion'], 2, ',','.')),0,0);  
   
                 $total_base = $total_base + $campo1['nu_base_imponible'];
                 $total_impuesto = $total_impuesto + $campo1['mo_retencion'];
                 $total_sustraendo = $total_sustraendo + $campo1['nu_sustraendo'];
            
           }
           
           $this->SetFont('Arial','B',8);
                  $this->ln(1);
         $this->Cell(125,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
         $this->Cell(20,0,utf8_decode('_ _ _ _ _ _'),0,0,'R');
         $this->Cell(45,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
                  $this->ln(1);
         $this->Cell(125,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
         $this->Cell(20,0,utf8_decode('_ _ _ _ _ _'),0,0,'R');
                  $this->Cell(45,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
                  $this->ln(1);
 
         $this->SetWidths(array(100,25,20,15,30)); 
         $this->SetAligns(array("R","R","R","R","R")); 
         
         $this->ln(3);
         $this->SetX(10);         
         $this->Row(array('TOTAL IMPUESTO RETENIDO:',number_format($total_base, 2, ',','.'),number_format($total_sustraendo, 2, ',','.'),'',number_format($total_impuesto, 2, ',','.')),0,0);   
                   
           
                 $this->ln(35); 
                 $this->SetWidths(array(200)); 
                 $this->SetAligns(array("C","C")); 
                 $this->SetX(10);        
                 $this->Row(array(utf8_decode('_ _ _ _ _ _  _ _ _ _  _ _ _ _ _  _ _')),0,0);
                 $this->SetX(10);
                 $this->Row(array(utf8_decode('Firma y Sello del Agente de Retención')),0,0); 
                
            } 
            
            
             $this->lista_retenciones = $this->getRetenciones($this->datos['co_orden_pago'],92);
             
            
            if(count($this->lista_retenciones)>0){
 
            $this->AddPage();
            
            $this->datos1 = $this->getFacturas(); 
            $this->nro_comprobante = $this->getComprobante($this->datos['co_solicitud'],92);

            $this->Ln(1);  
            
            $this->SetFillColor(201, 199, 199);
            $this->SetWidths(array(170,30, 30));
            $this->SetAligns(array("R","L"));
            $this->SetFont('Arial','B',8);
            $this->Row(array(utf8_decode('Fecha de Comprob.:'),utf8_decode($this->nro_comprobante['fe_emision'])),0,0);
            $this->Row(array(utf8_decode('Periodo Fiscal: AÑO:'),utf8_decode($this->nro_comprobante['anio']).' / MES: '.$this->nro_comprobante['mes']),0,0);            
            $this->Row(array(utf8_decode('Nro. Comprobante:'),utf8_decode($this->nro_comprobante['anio'].$this->nro_comprobante['mes'].$this->nro_comprobante['nu_comprobante'])),0,0);   
            $this->Ln(5);               
 
            $this->SetFont('Arial','B',9);
            $this->Cell(0,0,utf8_decode('COMPROBANTE DE RETENCIÓN DEL IMPUESTO AL VALOR AGREGADO (IVA)'),0,0,'C'); 
            $this->Ln(5);           
 
                 $this->SetWidths(array(20, 20, 20, 30,25,20,25,30)); 
                 $this->SetAligns(array("L","L","L","R","R","C","R","R"));              
                 $this->SetFont('Arial','B',8);
                     $this->SetFillColor(201, 199, 199);  
                 $this->SetX(10);         
                 $this->Row(array(utf8_decode('Fecha Fac.'),utf8_decode('Nro. Factura'),utf8_decode('Nro. Control'),utf8_decode('Monto Factura'),utf8_decode('Base Imponible'),utf8_decode('Alic.'),utf8_decode('Impuesto Iva'),utf8_decode('Iva Retenido')),0,0);  
                 $this->ln(1);
                 $this->SetX(10);
                 $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _'),0,0,'L');
                 $this->ln(5);
                 $this->SetX(10);
                 $this->Cell(0,0,utf8_decode($this->datos1['tx_razon_social']).' - '.utf8_decode($this->datos1['tx_rif']),0,0,'L');
                 $this->ln(5);
                 
                 $total_base = 0;
                 $total_impuesto = 0;
                 $total_factura = 0;
                 $total_iva_factura = 0;                 
                 
                foreach($this->lista_retenciones as $key => $campo1){
                
                 $this->SetAligns(array("L","L","L","R","R","C","R","R"));   
                 $this->SetFont('Arial','',8);
                 $this->Row(array(utf8_decode($campo1['fe_emision']),utf8_decode($campo1['nu_factura']),utf8_decode($campo1['nu_control']),number_format($campo1['nu_total'], 2, ',','.'),number_format($campo1['nu_base_imponible'], 2, ',','.'),number_format($campo1['co_iva_factura'], 2, ',','.'). ' %',number_format($campo1['nu_iva_factura'], 2, ',','.'),number_format($campo1['mo_retencion'], 2, ',','.')),0,0);  
   
                 $total_base = $total_base + $campo1['nu_base_imponible'];
                 $total_impuesto = $total_impuesto + $campo1['mo_retencion'];
                 $total_factura = $total_factura + $campo1['nu_total'];
                 $total_iva_factura = $total_iva_factura + $campo1['nu_iva_factura'];
            
           }
                 

           $this->SetFont('Arial','B',8);
                  $this->ln(1);
         $this->Cell(90,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
         $this->Cell(25,0,utf8_decode('_ _ _ _ _ _'),0,0,'R');
         $this->Cell(45,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
         $this->Cell(30,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
                  $this->ln(1);
         $this->Cell(90,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
         $this->Cell(25,0,utf8_decode('_ _ _ _ _ _'),0,0,'R');
          $this->Cell(45,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
          $this->Cell(30,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
                  $this->ln(1);
 
         $this->SetWidths(array(60,30,25,20,25,30)); 
         $this->SetAligns(array("R","R","R","R","R","R")); 
         
         $this->ln(3);
         $this->SetX(10);         
         $this->Row(array('TOTAL RELACION:',number_format($total_factura, 2, ',','.'),number_format($total_base, 2, ',','.'),'',number_format($total_iva_factura, 2, ',','.'),number_format($total_impuesto, 2, ',','.')),0,0);           
 
         $this->ln(18);           
           
                 $this->SetY(220);
                 $this->SetWidths(array(200)); 
                 $this->SetAligns(array("C")); 
                 $this->SetX(5);
                 $this->Row(array(utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _')),0,0);                 
                 $this->ln(10);
                 $this->SetWidths(array(100,100)); 
                 $this->SetAligns(array("C","C")); 
                 $this->SetX(10);        
                 $this->Row(array(utf8_decode('_____________________________________'),utf8_decode('_____________________________________')),0,0);
                 $this->SetX(10);
                 $this->Row(array(utf8_decode('Agente de Retención'),utf8_decode('Firma del Beneficiario')),0,0);          
         
            }   
            
             $this->lista_retenciones = $this->getRetenciones($this->datos['co_orden_pago'],100);
             
            
            if(count($this->lista_retenciones)>0){                     
                
            $this->AddPage();
            
            $this->datos1 = $this->getFacturas(); 
            $this->nro_comprobante = $this->getComprobante($this->datos['co_solicitud'],100);

            $this->Ln(5);      
            
            
            
            
            $this->SetFont('Arial','B',9);
            $this->Cell(0,0,utf8_decode('COMPROBANTE DE RETENCIÓN DE FIEL CUMPLIMIENTO'),0,0,'C');
            $this->Ln(1);
            $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _'),0,0,'C'); 
            $this->Ln(5);                 
                
            $this->SetFillColor(201, 199, 199);
            $this->SetWidths(array(170,30, 30));
            $this->SetAligns(array("R","L"));
            $this->SetFont('Arial','B',8);
            $this->Row(array(utf8_decode('Nro. Comprobante:'),utf8_decode($this->nro_comprobante['anio'].$this->nro_comprobante['mes'].$this->nro_comprobante['nu_comprobante'])),0,0);   
            $this->Row(array(utf8_decode('Fecha de Emisión:'),utf8_decode($this->nro_comprobante['fe_emision'])),0,0);
            $this->Ln(5);  
            
            $this->RoundedRect(10, $this->getY()-3, 95, 50, 0.5, '1001', '', $style);         
            $this->RoundedRect(110, $this->getY()-3, 95, 50, 0.5, '1001', '', $style);    

            $this->Cell(95,0,utf8_decode('DATOS DEL AGENTE DE RETENCIÓN'),0,0,'C');
            $this->Cell(5,0,utf8_decode(''),0,0,'C');
            $this->Cell(95,0,utf8_decode('DATOS DEL CONTRIBUYENTE'),0,0,'C'); 
            $this->Ln(8);
            
            if (!empty($this->empresa['nb_institucion'])) 
            {
            $agente_retencion = utf8_decode($this->empresa['nb_institucion']);
            }else{
            $agente_retencion = utf8_decode($this->empresa['nb_empresa']);    
            }
            $y= $this->GetY();           
            $this->SetY($y);
            $this->SetX(12);
            $this->MultiCell(90,4,$agente_retencion,0,1,'J',0);
            $z= $this->GetY();
            $this->SetY($y);            
            $this->SetX(112);
            $this->MultiCell(90,4,utf8_decode($this->datos1['tx_razon_social']),0,1,'J',0);
            $p= $this->GetY();
            $cant = $z-$y;
            $this->SetX(12);
            $this->SetFont('Arial','',8); 
            if($z==$p){
            if($cant==4){
             $q = $y +4;      
            }else{
             $q = $y +8;                  
            }
            }else{
            $q = $y +8;    
            }
            $this->SetY($q);
            $this->SetX(12);
            $this->MultiCell(90,4,utf8_decode('R.I.F. Agente de Retención:'),0,1,'J',0);
            $this->SetY($q);
            $this->SetX(112);
            $this->MultiCell(90,4,utf8_decode('R.I.F. Contribuyente:'),0,1,'J',0);
            
            $y= $this->GetY();
            $this->SetY($y);            
            $this->SetX(12);
            $this->SetFont('Arial','B',8);            
            $this->MultiCell(90,4,utf8_decode($this->empresa['tx_rif']),0,1,'J',0);
            $this->SetY($y);
            $this->SetX(112);            
            $this->MultiCell(90,4,utf8_decode($this->datos1['tx_rif']),0,1,'J',0);
            $y= $this->GetY();
            $this->SetY($y);              
            $this->SetX(12);
            $this->SetFont('Arial','',8);            
            $this->MultiCell(90,4,utf8_decode('Dirección Fiscal:'),0,1,'J',0); 
            $this->SetY($y);
            $this->SetX(112);    
            $this->MultiCell(90,4,utf8_decode('Dirección Fiscal:'),0,1,'J',0); 
            
            
            $this->SetFont('Arial','B',8);
            $y= $this->GetY();
            $this->SetY($y);
            $this->SetX(112);
            $this->MultiCell(90,4,utf8_decode(strtoupper($this->datos1['tx_direccion'])),0,1,'J',0); 
            $this->SetY($y);
            $this->SetX(12);
            $this->MultiCell(90,4,utf8_decode($this->empresa['tx_direccion']),0,1,'J',0);
            
                $this->Ln(15);
                 $this->SetWidths(array(20, 25, 25, 45,30,15,30)); 
                 $this->SetAligns(array("L","L","L","L","R","L","R"));              
                 $this->SetFont('Arial','B',8);
                     $this->SetFillColor(201, 199, 199);  
                 $this->SetX(10);         
                 $this->Row(array(utf8_decode('Fecha Fac.'),utf8_decode('Nro. Factura'),utf8_decode('Nro. Control'),utf8_decode('Concepto de Retención'),utf8_decode('Base Imponible'),utf8_decode('%'),utf8_decode('Monto Retenido')),0,0);  
                 $this->ln(1);
                 $this->SetX(10);
                 $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _'),0,0,'L');
                 $this->ln(5);
                 $this->SetX(10);
                 $this->Cell(0,0,utf8_decode('Orden de Pago: OP-'.$this->datos['tx_serial']),0,0,'L');
                 $this->ln(1);
                 $this->SetX(10);
                 $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _'),0,0,'L');
                 $this->ln(5);
                 
                 $total_base = 0;
                 $total_impuesto = 0;
                 
            foreach($this->lista_retenciones as $key => $campo1){
                
                 $this->SetAligns(array("L","L","L","L","R","L","R"));   
                 $this->SetFont('Arial','',8);
                 $this->Row(array(utf8_decode($campo1['fe_emision']),utf8_decode($campo1['nu_factura']),utf8_decode($campo1['nu_control']),utf8_decode($campo1['tx_tipo_retencion']),number_format($campo1['nu_total'], 2, ',','.'),$campo1['po_retencion'],number_format($campo1['mo_retencion'], 2, ',','.')),0,0);  
                 
                 $total_base = $total_base + $campo1['nu_total'];
                 $total_impuesto = $total_impuesto + $campo1['mo_retencion'];
            
           }
           $this->SetFont('Arial','B',8);
                  $this->ln(1);
         $this->Cell(145,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
         $this->Cell(45,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
                  $this->ln(1);
         $this->Cell(145,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
                  $this->Cell(45,0,utf8_decode('_ _ _ _ _ _ _ _ _'),0,0,'R');
                  $this->ln(1);
 
         $this->SetWidths(array(115,30,15,30)); 
         $this->SetAligns(array("R","R","R","R")); 
         
         $this->ln(3);
         $this->SetX(10);         
         $this->Row(array('TOTAL IMPUESTO RETENIDO:',number_format($total_base, 2, ',','.'),'',number_format($total_impuesto, 2, ',','.')),0,0);   
        
         
         $this->ln(18);           
           
                 $this->ln(35); 
                 $this->SetWidths(array(200)); 
                 $this->SetAligns(array("C","C")); 
                 $this->SetX(10);        
                 $this->Row(array(utf8_decode('_ _ _ _ _ _  _ _ _ _  _ _ _ _ _  _ _')),0,0);
                 $this->SetX(10);
                 $this->Row(array(utf8_decode('Firma y Sello del Agente de Retención')),0,0); 
                
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
                         tb010a.tx_siglas,
                         tb010a.tx_banco as tx_banco_proveedor,
                         tx_cuenta_bancaria,
                         de_observacion,
                         tb060.co_orden_pago,
                         tb060.tx_serial,
                         tb026.co_solicitud
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
    
    function getFacturas(){

          $conex = new ConexionComun();     
          $sql = "select distinct   nu_factura, 
                          fecha_compra as fe_pago, 
                          co_factura,
                          tb045.nu_control,
                          to_char(tb045.fe_emision,'dd/mm/yyyy') as fe_emision,  
                          nu_base_imponible, 
                          co_iva_factura, 
                          nu_iva_factura, 
                          nu_total, 
                          tb045.co_iva_retencion, 
                          nu_iva_retencion, 
                          tb045.tx_concepto, 
                          tb045.co_compra as nu_compra, 
                          numero_compra,
                          nu_total_retencion, 
                          total_pagar,
                          tb052.tx_observacion,
                         tb008.tx_razon_social,
                         tb007.inicial,
                         (tb007.inicial||'-'||tb008.tx_rif) as tx_rif,  
                         tb008.tx_direccion,                          
                         upper(tb008.nb_representante_legal) as nb_representante_legal,
                         tb008.nu_cedula_representante,
                         tb047.tx_ente,  
                         tb001.nb_usuario,
                         tb062.mo_pagar as nu_monto,
                         tb052.anio,
                         tb045.co_solicitud,
                         tb039.nu_requisicion,  
                         tb039.tx_concepto as concepto_req,
                         tb039.created_at, 
                         tb045.co_odp,
                         to_char(tb045.fe_emision,'dd/mm/yyyy') as fe_emision,
                         tb052.nu_orden_compra,
                         tb060.tx_serial,
                         case when(tb045.co_iva_factura = 0) then nu_total else '0' end as monto_excento,
                         to_char(tb045.fe_emision,'dd') as dia,
                         to_char(tb045.fe_emision,'mm') as mes,
                         to_char(tb045.fe_emision,'yyyy') as anio
                  from   tb026_solicitud as tb026
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud                                                   
                  left join tb045_factura as tb045 on tb045.co_compra = tb052.co_compras
                  left join tb060_orden_pago as tb060 on tb060.co_orden_pago = tb045.co_odp
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor 
                  left join tb039_requisiciones as tb039 on tb045.co_solicitud = tb039.co_solicitud
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb026.co_usuario
                  left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente
                  left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb045.co_solicitud
                  left join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
                  left join tb063_pago as tb063 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago
                  where tb045.in_anular is null and tb063.co_pago =".$_GET['codigo']." order by co_factura asc ";
               
//          echo var_dump($sql);  exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];   
    }
    function getRetenciones($co_odp,$co_tipo_retencion){

	  $conex = new ConexionComun();
          $sql = "select  nu_factura,
                          nu_control,
                          to_char(fe_emision,'dd/mm/yyyy') as fe_emision, 
                          nu_base_imponible,
                          co_iva_factura, 
                          nu_iva_factura, 
                          nu_total,                           
                          nu_iva_retencion, 
                          tx_concepto,                           
                          nu_total_retencion, 
                          total_pagar,
                          po_retencion,
                          mo_retencion,
                          tx_tipo_retencion,
                          tb041.co_tipo_retencion,
                          tb042.de_concepto,
                          tb042.nu_sustraendo,
                          lpad(co_factura_retencion::text, 8, '0'::text) as co_factura_retencion,
                          lpad(nu_comprobante::text, 8, '0'::text) as nu_comprobante,
                          to_char(tb045.fe_emision,'dd') as dia,
                          to_char(tb045.fe_emision,'mm') as mes,
                          to_char(tb045.fe_emision,'yyyy') as anio
                  from   tb045_factura as tb045     
                  left join tb046_factura_retencion as tb046 on tb046.co_factura = tb045.co_factura
                  left join tb041_tipo_retencion as tb041 on tb041.co_tipo_retencion = tb046.co_tipo_retencion
                  left join tb026_solicitud as tb026 on tb026.co_solicitud = tb046.co_solicitud
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor
                  left join tb042_retencion as tb042 on (tb046.co_tipo_retencion = tb042.co_tipo_retencion and tb008.co_documento = tb042.co_documento and tb045.co_ramo = tb042.co_ramo) 
                  where tb045.in_anular is null and tb046.co_tipo_retencion = $co_tipo_retencion and tb045.co_odp = ".$co_odp; 
                  
//          echo $sql; exit(); 
          
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
  
    }   
    
    function getComprobante($co_solicitud,$co_tipo_retencion){

	  $conex = new ConexionComun();
          $sql = "select  nu_factura,
                          nu_control,
                          to_char(fe_emision,'dd/mm/yyyy') as fe_emision, 
                          nu_base_imponible,                           
                          nu_iva_factura, 
                          nu_total,                           
                          nu_iva_retencion, 
                          tx_concepto,                           
                          nu_total_retencion, 
                          total_pagar,
                          po_retencion,
                          mo_retencion,
                          tx_tipo_retencion,
                          tb041.co_tipo_retencion,
                          lpad(co_factura_retencion::text, 8, '0'::text) as co_factura_retencion,
                          lpad(nu_comprobante::text, 8, '0'::text) as nu_comprobante,
                          to_char(tb045.fe_emision,'dd') as dia,
                          to_char(tb045.fe_emision,'mm') as mes,
                          to_char(tb045.fe_emision,'yyyy') as anio
                  from   tb045_factura as tb045     
                  left join tb046_factura_retencion as tb046 on tb046.co_factura = tb045.co_factura
                  left join tb041_tipo_retencion as tb041 on tb041.co_tipo_retencion = tb046.co_tipo_retencion
                  where tb045.in_anular is null and tb046.co_tipo_retencion = $co_tipo_retencion and tb045.co_solicitud = ".$co_solicitud; 
                  
//          echo $sql; exit(); 
          
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0]; 
  
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
