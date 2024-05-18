<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {
        $this->SetFont('courier','B',12);
        $this->Cell(0,0,utf8_decode('<NOMBRE DE LA INSTITUCION>'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Secretaria de Administración y Finanzas'),0,0,'L');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('[FBANRC34]'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');                          
    }

    function Footer() {
	$this->SetFont('courier','B',9);     
	$this->SetY(250);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');       
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

         $this->Ln(6);
         $this->SetWidths(array(200));         
         $this->SetAligns(array("C")); 
         $this->SetFont('courier','B',9);         
         $this->Row(array(utf8_decode('RELACIÓN DETALLADA DE MOVIMIENTOS BANCARIOS DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
         $this->Ln(2);
         $this->SetWidths(array(200));
         $this->SetAligns(array("L"));           
         $this->SetFont('COURIER','B',8); 
         $this->SetFillColor(255, 255, 255); 
         
         $this->lista_cuentas = $this->getCuenta();         
         
         $this->SetFont('COURIER','',9);     
         $this->SetWidths(array(20,35,35,10,20,25,30,30,30));  
         $this->SetAligns(array("C","C","C","C","C","C","R","R","R"));   
         $this->Row(array('Documento','Beneficiario',utf8_decode('Descripción'),'OP','Fecha','Referencia', 'INGRESOS','EGRESOS','SALDO'),0,0); 
         $this->SetAligns(array("L","L","L","C","C","R","R","R","R")); 
         $this->Line(10, 40, 210, 40);        
         $this->Ln(2);
         $mo_ingr = 0;
         $mo_egr = 0;
         
         
        foreach($this->lista_cuentas as $key => $valor){
        
                    if($this->getY()>230)
                        {	
                        $this->addPage();
                        $this->Ln(6);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("C")); 
                        $this->SetFont('courier','B',9);        
                        $this->Row(array(utf8_decode('RELACIÓN DETALLADA DE MOVIMIENTOS BANCARIOS DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
                        $this->Ln(2);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("L"));           
                        $this->SetFont('COURIER','B',8); 
                        $this->SetFillColor(255, 255, 255); 

                        $this->SetFont('COURIER','',9);     
                        $this->SetWidths(array(20,35,35,10,20,25,30,30,30));  
                        $this->SetAligns(array("C","C","C","C","C","C","R","R","R"));   
                        $this->Row(array('Documento','Beneficiario',utf8_decode('Descripción'),'OP','Fecha','Referencia', 'INGRESOS','EGRESOS','SALDO'),0,0); 
                        $this->SetAligns(array("L","L","L","C","C","R","R","R")); 
                        $this->Line(10, 40, 210, 40);        
                        $this->Ln(2);
                        $mo_ingr = 0;
                        $mo_egr = 0;
                    } 
                if($valor['mo_disponible']<>0){    
                   $this->SetFont('courier','B',8);
                   $this->SetWidths(array(150)); 
                   $this->SetAligns(array("L")); 
                   $this->Row(array('Banco: '.$valor['bco']),0,0);         
                   $this->Row(array('Cuenta: '.$valor['cuenta']),0,0);
                /*********** Detalles de Movimientos Bancarios *************/
                $this->lista_mov = $this->getMovimientos($valor['co_cuenta_bancaria']);             
         
                foreach($this->lista_mov as $key => $campo){              

                        if($this->getY()>230)
                        {	
                        $this->addPage();
                        $this->Ln(6);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("C")); 
                        $this->SetFont('courier','B',9);         
                        $this->Row(array(utf8_decode('RELACIÓN DE MOVIMIENTOS BANCARIOS DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
                        $this->Ln(2);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("L"));           
                        $this->SetFont('COURIER','B',8); 
                        $this->SetFillColor(255, 255, 255); 

                        $this->SetFont('COURIER','',9);     
                        $this->SetWidths(array(20,25,35,10,20,35,30,30));   
                        $this->SetAligns(array("C","C","C","C","C","C","R","R"));   
                        $this->Row(array('Documento','Beneficiario',utf8_decode('Descripción'),'OP','Fecha','Referencia', 'Ingreso.','Egreso.'),0,0); 
                        $this->SetAligns(array("L","L","L","C","C","R","R","R")); 
                        $this->Line(10, 40, 210, 40);        
                        $this->Ln(2);
                        $mo_ingr = 0;
                        $mo_egr = 0;
                        } 
                        $this->SetFont('COURIER','',7);  
                        $this->SetWidths(array(20,25,35,10,20,35,30,30));   
                        $this->SetAligns(array("L","L","L","C","C","R","R","R")); 
                        $this->Row(array($campo['documento'],$campo['beneficiario'],$campo['tx_descripcion'],utf8_decode($campo['op']),$campo['fecha'],$campo['referencia'],number_format($campo['monto_ingr'], 2, ',','.'),number_format($campo['monto_egr'], 2, ',','.')),0,0);         

                        $mo_ingr = $campo['monto_ingr'] + $mo_ingr;
                        $mo_egr  = $campo['monto_egr'] + $mo_egr;

                 }
                } 
        }
         $this->Ln(10);
         $y = $this->getY();
         $this->Line(146, $y, 175, $y);
         $y = $this->getY();
         $this->Line(180, $y, 210, $y);         
         $this->SetFont('COURIER','B',8);  
         $this->SetAligns(array("R","R","R"));
         $this->SetWidths(array(120,40,40));
         $this->Row(array(utf8_decode('TOTAL RELACIÓN...: '),number_format($mo_ingr, 2, ',','.'),number_format($mo_egr, 2, ',','.')),0,0);         
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
   
    function getCuenta(){

          $conex = new ConexionComun();     
          $sql = "  SELECT tb024.tx_descripcion as cuenta, tb011.co_cuenta_bancaria, tb010.tx_banco as bco,
                    tb011.co_cuenta_bancaria, tb011.mo_disponible
                    FROM tb010_banco as tb010
                    left join tb011_cuenta_bancaria as tb011 on (tb011.co_banco = tb010.co_banco)
                    left join tb024_cuenta_contable as tb024 on (tb011.co_cuenta_contable = tb024.co_cuenta_contable)
                    where tb011.tx_cuenta_bancaria like '01160172390016073568'
                    order by bco, cuenta";
                        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }    
    function getMovimientos($cuenta){

          $conex = new ConexionComun();     
          $sql = "  SELECT 'NC-'||to_char(tb066.created_at,'yyyy')||to_char(tb066.created_at,'mm')||'-'||tb066.co_transferencia_cuenta as documento , 'GOBERNACION DEL ESTADO' as beneficiario,
                    'Para cubrir gastos' as tx_descripcion,
                    'IA' as op, to_char(tb066.created_at,'dd/mm/yyyy') as fecha, 'OT'||to_char(tb066.created_at,'yyyy')||to_char(tb066.created_at,'mm')||'-'||tb066.co_transferencia_cuenta as referencia,
                    tb066.mo_debito as monto_ingr, '0.00' as monto_egr
                    FROM tb066_transferencia_cuenta as tb066 where tb066.co_cuenta_bancaria_credito = ".$cuenta."
                    union    
                    SELECT 'ND-'||tb052.nu_orden_compra as documento,UPPER(tb008.tx_razon_social) AS beneficiario,
                    tb052.tx_observacion as tx_descripcion,
                    'EA' as op, to_char(tb062.fe_emision,'dd/mm/yyyy') as fecha, tb060.tx_serial as referencia,
                    '0.00' as monto_ingr, tb062.mo_pagado as monto_egr
                    from   tb026_solicitud as tb026
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud 
                  left join tb053_detalle_compras as tb053 on tb053.co_compras = tb052.co_compras 
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor 
                  left join tb060_orden_pago as tb060 on tb060.co_solicitud = tb026.co_solicitud 
                  left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud and tb062.mo_pagado<>0
                  where tb026.co_solicitud= 1";
                  
                  
        //  echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }    
}

$pdf=new PDF('P','mm','letter');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
