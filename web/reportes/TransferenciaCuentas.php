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
                          
         $this->AddPage();  
         $this->SetFont('Arial','B',10);
         $this->campo = $this->getDetalleTransf(); 
         $this->Ln(10);
         $this->Cell(0,0,utf8_decode('TRANSFERENCIA #'.$this->campo['nu_serial_transferencia']),0,0,'C'); 
         $this->Ln(10);
        $this->SetFont('Arial','',8);
        $this->Cell(0,0,utf8_decode('Fecha Transferencia: '.$this->campo['created_at']),0,0,'R');
         $this->Ln(5);
        $this->SetFont('Arial','B',8);
        $this->Cell(0,0,utf8_decode('CUENTA ORIGEN'),0,0,'C');
        
                 $this->Ln(5);
         $this->RoundedRect(10, 60, 200, 15, 0.5, '1001', '', $style);
         $this->Ln(5);
         $this->SetY(62);
         $this->SetFont('Arial','',8);
         $this->SetX(25);
         $this->Cell(200,5,utf8_decode('BANCO'),0,0,'L');
         $this->SetX(80);
         $this->Cell(200,5,utf8_decode('CUENTA NRO.'),0,0,'L');
          $this->SetX(125);
         $this->Cell(200,5,utf8_decode('REFERENCIA'),0,0,'L');
         $this->SetX(183);
         $this->Cell(200,5,utf8_decode('MONTO'),0,0,'L');
         $this->Ln(5);
         $this->SetX(25);
         $this->Cell(200,5,utf8_decode($this->campo['bco_deb']),0,0,'L');
         $this->SetX(80);
         $this->Cell(200,5,utf8_decode($this->campo['cuenta_debito']),0,0,'L');
          $this->SetX(125);
         $this->Cell(200,5,utf8_decode('ND-'.$this->campo['nu_serial_transferencia']),0,0,'L');
         $this->SetX(183);
         $this->Cell(200,5,number_format($this->campo['mo_debito'], 2, ',','.'),0,0,'L');
         
         
         $this->Ln(15);
        $this->SetFont('Arial','B',8);
        $this->Cell(0,0,utf8_decode('CUENTA DESTINO'),0,0,'C');
        
         $this->Ln(5);
         $this->RoundedRect(10, 88, 200, 15, 0.5, '1001', '', $style);
         $this->Ln(5);
         $this->SetY(90);
         $this->SetFont('Arial','',8);
         $this->SetX(25);
         $this->Cell(200,5,utf8_decode('BANCO'),0,0,'L');
         $this->SetX(80);
         $this->Cell(200,5,utf8_decode('CUENTA NRO.'),0,0,'L');
          $this->SetX(125);
         $this->Cell(200,5,utf8_decode('REFERENCIA'),0,0,'L');
         $this->SetX(183);
         $this->Cell(200,5,utf8_decode('MONTO'),0,0,'L');
         $this->Ln(5);
         $this->SetX(25);
         $this->Cell(200,5,utf8_decode($this->campo['bco_cred']),0,0,'L');
         $this->SetX(80);
         $this->Cell(200,5,utf8_decode($this->campo['cuenta_credito']),0,0,'L');
          $this->SetX(125);
         $this->Cell(200,5,utf8_decode('NC-'.$this->campo['nu_serial_transferencia']),0,0,'L');
         $this->SetX(183);
         $this->Cell(200,5,number_format($this->campo['mo_debito'], 2, ',','.'),0,0,'L');

         $this->Ln(15);
         $this->RoundedRect(10, 120, 200, 113, 0.5, '1001', '', $style);
         
         $this->SetX(15);
         $this->Cell(200,5,utf8_decode('CONCEPTO'),0,0,'L');   
         $this->Ln(12);
         $this->SetX(11);
         $this->MultiCell(200,5,utf8_decode($this->campo['tx_observacion']),0,1,'L',1);    
         
          $this->RoundedRect(10, 238, 65, 20, 0.5, '1001', '', $style);
          $this->RoundedRect(77, 238, 65, 20, 0.5, '1001', '', $style);
          $this->RoundedRect(144, 238, 66, 20, 0.5, '1001', '', $style);
          
         $this->SetY(240); 
         $this->SetX(20);
         $this->Cell(200,5,utf8_decode('ELABORADO POR:'),0,0,'L');
         $this->SetX(80);
         $this->Cell(200,5,utf8_decode('COSNFORMADO POR:'),0,0,'L');          
         $this->SetX(150);
         $this->Cell(200,5,utf8_decode('AUTORIZADO POR:'),0,0,'L');
         
         $this->SetY(254); 
         $this->SetX(20);
         $this->Cell(200,5,utf8_decode('ANALISTA'),0,0,'L');
         $this->SetX(80);
         $this->Cell(200,5,utf8_decode('TESORERÍA'),0,0,'L');          
         $this->SetX(150);
         $this->Cell(200,5,utf8_decode('ADMINISTRADOR'),0,0,'L');          
          
          
     
        
//         $this->SetFillColor(255, 255, 255);
//         $this->SetWidths(array(60,140));
//         $this->SetAligns(array("L","L"));
//         $this->SetWidths(array(200));
//         $this->SetAligns(array("C"));
//         $this->SetY(105);         
//         $this->SetFillColor(201, 199, 199);
//         $this->Row(array(utf8_decode('DETALLES DE TRANSFERENCIA Nro.'.$this->campo['co_solicitud'])),1,1);
//         $this->SetFont('Arial','',9); 
//         $this->SetFillColor(255, 255, 255);
//         $item = 0; 
//         
//         //$this->SetWidths(array(40,60,55,20,25)); 
//         $this->SetWidths(array(50,100,50)); 
//         $this->SetAligns(array("L","L","L","L","L","L"));
//         //$this->Row(array('FECHA: '.$this->campo['created_at'],'MONTO TRANSFERENCIA: '.$this->campo['mo_debito'],'APROBADOR: '.$this->campo['aprobador'],'ESTADO: '.$this->campo['estado']),1,1);
//         $this->Row(array('FECHA: '.$this->campo['created_at'],'MONTO TRANSFERENCIA: '.$this->campo['mo_debito'],'ESTADO: '.$this->campo['estado']),1,1);  
//         
//         
//         $this->SetWidths(array(200));
//         $this->SetAligns(array("C"));
//         $this->SetFillColor(201, 199, 199);
//         $this->SetFont('Arial','B',9);          
//         $this->Row(array(utf8_decode('DATOS DEL DEBITO')),1,1);
//         $this->SetFont('Arial','',9); 
//         $this->SetFillColor(255, 255, 255);
//         $this->SetWidths(array(50,50,50,50)); 
//         $this->SetAligns(array("C","C","C","C"));       
//         $this->Row(array('BANCO','CUENTA','CODIGO CONTABLE','DEBITO'),1,1);         
//         $this->SetFont('Arial','',9); 
//         $this->SetAligns(array("L","C","C","R"));
//         $this->Row(array($this->campo['bco_deb'],$this->campo['tx_cuenta_bancaria_deb'],$this->campo['cuenta_debito'],number_format($this->campo['mo_debito'], 2, ',','.')),1,1);                  
//         
//         
//         $this->SetWidths(array(200));
//         $this->SetAligns(array("C"));
//         $this->SetFillColor(201, 199, 199);
//         $this->SetFont('Arial','B',9);          
//         $this->Row(array(utf8_decode('DATOS DEL CREDITO')),1,1);
//         $this->SetFont('Arial','',9); 
//         $this->SetFillColor(255, 255, 255);
//         $this->SetWidths(array(50,50,50,50)); 
//         $this->SetAligns(array("C","C","C","C"));       
//         $this->Row(array('BANCO','CUENTA','CODIGO CONTABLE','CREDITO'),1,1);         
//         $this->SetAligns(array("L","C","C","R"));
//         $this->Row(array($this->campo['bco_cred'],$this->campo['tx_cuenta_bancaria_cred'],$this->campo['cuenta_credito'],number_format($this->campo['mo_debito'], 2, ',','.')),1,1);                  
//            
//         
//         $this->ln();
//         $this->SetAligns(array("L","L", "C"));
//	 $this->SetFillColor(255,255,255);
//         $this->SetWidths(array(40,160));
//         $this->Row(array(utf8_decode('CONCEPTO:'),utf8_decode($this->campo['tx_observacion'])),1,1);
////         $this->SetAligns(array("C","C", "C"));
////	 $this->SetFillColor(201, 199, 199);
////         $this->SetWidths(array(40,120,40));
////         $this->Row(array(utf8_decode('SECRET. ADMIN. Y FINAN.'),utf8_decode('UNIDAD DE TESORERIA'),utf8_decode('MÁXIMA AUTORIDAD')),1,1);
////         $this->SetFillColor(255,255,255);
////         $this->SetWidths(array(40,40,40,40,40));
////         $this->SetAligns(array("L", "L","L","L"));
////         $this->Row(array('Autorizado por:','Elaborado por:','Conformado por:','Autorizado por:','Autorizado por:'),1,1);
////         
////         $this->ln();
////         
////         $this->Cell(0,0,utf8_decode('Usuario del sistema:'),0,0,'L');
////         $this->ln();
////	 $this->SetY($this->GetY()+5);
////         $this->Cell(0,0,utf8_decode(''),0,0,'L');
////         
//
//         $this->SetAligns(array("C","C", "C"));
//	 $this->SetFillColor(201, 199, 199);
//         $this->SetWidths(array(100,100));
//         $this->SetFont('Arial','B',7); 
//         $this->Row(array(utf8_decode('COORDINACIÓN DE TESORERIA'),utf8_decode('COORDINACIÓN GENERAL DE ADMINISTRACIÓN')),1,1);
//         $this->SetFillColor(255,255,255);
//         $this->SetWidths(array(40,30,30,40));
//         $this->SetAligns(array("L", "L","L","L"));
//         $Y = $this->GetY();
//         //$this->MultiCell(40,20,'',1,1,'L',1);
//         $this->SetY($Y);
//         //$this->SetX(50);
//         $this->MultiCell(100,20,'',1,1,'L',1);
//         $this->SetY($Y);
//         $this->SetX(110);
//         $this->MultiCell(100,20,'',1,1,'L',1);
//         $this->SetY($Y);
////         $this->SetX(170);
////         $this->MultiCell(40,20,'',1,1,'L',1);
//         $this->SetY($Y);
//         $this->SetFont('Arial','',6);
//         $this->ln(15);
//         $this->SetWidths(array(100,100));
//         $this->Row(array('Elaborado por: '.utf8_decode(strtoupper($this->campo['nb_usuario'])),'Conformado por: '),1,1);
//         $this->SetFillColor(201, 199, 199);
//         $this->SetWidths(array(200));
//         $this->SetAligns(array("C"));
//         $this->Row(array(utf8_decode('RECIBE CONFORME')),1,1);
//	     $this->SetFillColor(255,255,255);
//         $this->SetAligns(array("L","L","L"));
//         $this->SetWidths(array(50,50,100));
//         $Y = $this->GetY();
//         $this->MultiCell(80,20,utf8_decode('Nombre y Apellido: ').utf8_decode($this->campo['nb_representante_legal']),1,1,'L',1);
//         $this->SetY($Y);
//         $this->SetX(90);
//         $this->MultiCell(40,20,utf8_decode('CI/RIF: '.$this->campo['inicial'].'-'.$this->campo['tx_rif']),1,1,'L',1);
//         $this->SetY($Y);
//         $this->SetX(130);
//         $this->MultiCell(80,20,utf8_decode('Firma: '),1,1,'L',1);
//
//         $this->ln();
//         
//         $this->Cell(0,0,utf8_decode('Usuario del sistema: '.utf8_decode($this->campo['nb_usuario'])),0,0,'L');
//         $this->ln();
//	 $this->SetY($this->GetY()+5);
//         $this->Cell(0,0,utf8_decode(''),0,0,'L');      

       

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

    function getDetalleTransf(){

          $conex = new ConexionComun();               
          $sql = "select tb026.co_solicitud,
                         to_char(tb030.created_at,'dd/mm/yyyy') as created_at,
                         to_char(tb030.created_at,'dd') as dia,
                         to_char(tb030.created_at,'mm') as mes,
                         to_char(tb030.created_at,'yyyy') as anio,                          
                         tb066.mo_debito, 
                         tb011_deb.tx_cuenta_bancaria as tx_cuenta_bancaria_deb,
                         tb011_cred.tx_cuenta_bancaria as tx_cuenta_bancaria_cred,
                         tb031.tx_descripcion,
                         tb024_deb.nu_cuenta_contable as cuenta_debito,
                         tb024_cred.nu_cuenta_contable as cuenta_credito,
                         tb010_cred.tx_banco as bco_cred,
                         tb010_deb.tx_banco as bco_deb,
                         tb001_aprob.nb_usuario as aprobador,
                         tb001.nb_usuario as nb_usuario,
                         tb031.tx_descripcion as estado,
                         tb026.tx_observacion,
                         nu_serial_transferencia
                  FROM tb066_transferencia_cuenta as tb066               
                  left join tb011_cuenta_bancaria as tb011_deb on tb011_deb.co_cuenta_bancaria = tb066.co_cuenta_bancaria_debito
                  left join tb011_cuenta_bancaria as tb011_cred on tb011_cred.co_cuenta_bancaria = tb066.co_cuenta_bancaria_credito
                  left join tb026_solicitud as tb026 on tb026.co_solicitud = tb066.co_solicitud
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor   
                  left join tb010_banco as tb010_cred on tb010_cred.co_banco = tb066.co_banco_credito
                  left join tb010_banco as tb010_deb on tb010_deb.co_banco = tb066.co_banco_debito
                  left join tb031_estatus_ruta as tb031 on tb031.co_estatus_ruta = tb066.co_estado
                  left join tb024_cuenta_contable as tb024_deb on tb024_deb.co_cuenta_contable = tb066.co_cuenta_contable_debito
                  left join tb024_cuenta_contable as tb024_cred on tb024_cred.co_cuenta_contable = tb066.co_cuenta_contable_credito
                  left join tb001_usuario as tb001_aprob on tb001_aprob.co_usuario = tb066.co_usuario_cambio_estado 
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb066.co_usuario                                    
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb066.co_solicitud 
                  where tb030.co_ruta = ".$_GET['codigo'];
                 
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

$dir="$ruta".$_GET["codigo"].".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";


$update = "update tb030_ruta set tx_ruta_reporte = '".$dir."' where co_ruta = ".$_GET['codigo']; //$comm->decrypt($_GET["codigo"]);

//echo $update; exit();
$comm->Execute($update);    

$pdf->Output($dir, 'F');


//$pdf = new PDF_Flo('P', 'mm', 'letter');
//$pdf->PrintChapter();
//$pdf->SetDisplayMode('default');
//$pdf->Output();

?>