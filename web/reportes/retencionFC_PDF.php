<?php
include("ConexionComun.php");
include('fpdf.php');

class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {


        $this->Image("imagenes/escudosanfco.jpg", 100, 7,20);

        $this->SetFont('Arial','B',10);
        
      //  $this->datos = $this->getTipoOrdenes();

        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACION Y FINANZAS'),0,0,'C');
        $this->Ln(8);
        $this->SetFont('Arial','B',10);
        $this->Cell(0,0,utf8_decode('RETENCIONES FIEL CUMPLIMIENTO'),0,0,'C');
        $this->Ln(4);
        $this->SetFont('Arial','',8);

        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->Ln(2);
        if ($this->PageNo()>1) $this->Cell(0,10,utf8_decode('Página ').$this->PageNo(),0,0,'L');  
       
        $this->SetTextColor(0,0,0);
        $this->SetX(1);       

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

        $this->SetY(65);
        $x =  $this->getX();
        $campo='';
        $this->getX($x);

        $nu_total_general=0;
        $nu_base_imponible_general=0;
        $nu_iva_factura_general=0;
        $nu_iva_retencion_general=0;
        $this->datos = $this->getRetenciones();
        $this->datos_cuenta = $this->getCuenta( 92);
       
            $this->SetFont('Arial','',7);     
            $this->SetWidths(array(140 ));  
            $this->SetAligns(array("L",));   
            $this->Row(array( 'CONCEPTO DE RETENCION: '.$campo1["co_iva_retencion"]  ),0,0); 
            $this->Ln(2);
            $this->Row(array( utf8_decode('CUENTA N°: '.$this->datos_cuenta["tx_cuenta_bancaria"].' - '.$this->datos_cuenta["tx_descripcion"] )  ),0,0); 
            $this->Ln(2);
            $this->Row(array( 'RANGO DE FECHA DEL: '.$_GET["fe_inicio"].' AL: '.$_GET["fe_fin"]  ),0,0); 
            $this->Ln(2);
            
            $this->SetFont('Arial','B',7);     
            $this->SetWidths(array(25,70,15,25,25,25,15 )); 
            $this->SetAligns(array("C","C","C","C","C","C","C"));   
            $this->Row(array('Orden de Pago','Beneficiario','Fecha', 'Monto Factura.', 'Base Imp.', 'Monto de Deduc.', 'Porc. %'),1,0);
            $this->SetAligns(array("C","L","C","L","L","L","C","C"));                  
            //$this->Ln(2);
            $nu_total=0;
            $nu_base_imponible=0;
            $nu_iva_factura=0;
            $nu_iva_retencion=0;
     
            foreach($this->datos as $key => $campo){
                
                $this->setX(10);
                $this->SetFont('Arial','',6);
                $this->SetWidths(array(25,70,15,25,25,25,15 ));
                $this->Row(array($campo['tx_serial'], utf8_decode($campo['rif'].' - '.$campo['tx_razon_social']), $campo['fechaopera'], 
                number_format($campo['nu_total'], 2, ',','.'), 
                number_format($campo['nu_base_imponible'], 2, ',','.'), 
                number_format($campo['montoopera'], 2, ',','.'),
                $campo['po_retencion'] ),1,0);

                $nu_total = $campo['nu_total'] + $nu_total;
                $nu_base_imponible = $campo['nu_base_imponible'] + $nu_base_imponible;
                $nu_iva_retencion = $campo['montoopera'] + $nu_iva_retencion;

                $nu_total_general = $campo['nu_total'] + $nu_total_general;
                $nu_base_imponible_general = $campo['nu_base_imponible'] + $nu_base_imponible_general;
                $nu_iva_retencion_general = $campo['montoopera'] + $nu_iva_retencion_general;

                if($this->getY()>240){

                    $this->AddPage();
                    $this->setX(10);
                    $this->Ln(10);
                    $this->SetFont('Arial','',7);     
                    $this->SetWidths(array(140 ));  
                    $this->SetAligns(array("L",));   
                    $this->Row(array( 'CONCEPTO DE RETENCION: '.$campo1["co_iva_retencion"]  ),0,0); 
                    $this->Ln(2);
                    $this->Row(array( utf8_decode('CUENTA N°: '.$this->datos_cuenta["tx_cuenta_bancaria"].' - '.$this->datos_cuenta["tx_descripcion"] )  ),0,0); 
                    $this->Ln(2);

                    $this->SetFont('Arial','',7);     
                    $this->SetWidths(array(140 ));  
                    $this->SetAligns(array("L",));   
                    $this->Row(array( 'RANGO DE FECHA DEL: '.$_GET["fe_inicio"].' AL: '.$_GET["fe_fin"]  ),0,0); 
                    $this->Ln(2);
                    $this->SetFont('Arial','B',7);     
                    $this->SetWidths(array(25,70,15,25,25,25,15 )); 
                    $this->SetAligns(array("C","C","C","C","C","C","C"));   
                    $this->Row(array('Orden de Pago','Beneficiario','Fecha', 'Monto Factura.', 'Base Imp.', 'Monto de Deduc.', 'Porc. %'),1,0);
                    $this->SetAligns(array("C","L","C","L","L","L","C","C"));   

                }
                
            }

            $this->setX(10);
            $this->SetFont( 'Arial', 'B', 7);
            $this->SetWidths(array(110,25,25,25,15 ));  
            $this->SetAligns(array("C","L","L","L","L"));
            $this->Row(array(utf8_decode('SUB-TOTAL'), 
            number_format($nu_total, 2, ',','.'), 
            number_format($nu_base_imponible, 2, ',','.'), 
            number_format($nu_iva_retencion, 2, ',','.'), '' ),1,0);

            if($this->getY()>240){

                $this->AddPage();
                $this->setX(10);
                $this->Ln(10);
                $this->SetFont('Arial','',7);     
                $this->SetWidths(array(140 ));  
                $this->SetAligns(array("L",));   
                $this->Row(array( 'CONCEPTO DE RETENCION: '.$campo1["co_iva_retencion"]  ),0,0); 
                $this->Ln(2);
                $this->Row(array( utf8_decode('CUENTA N°: '.$this->datos_cuenta["tx_cuenta_bancaria"].' - '.$this->datos_cuenta["tx_descripcion"] )  ),0,0); 
                $this->Ln(2);

                $this->SetFont('Arial','',7);     
                $this->SetWidths(array(140 ));  
                $this->SetAligns(array("L",));   
                $this->Row(array( 'RANGO DE FECHA DEL: '.$_GET["fe_inicio"].' AL: '.$_GET["fe_fin"]  ),0,0); 
                $this->Ln(2);
                $this->SetFont('Arial','B',7);     
                $this->SetWidths(array(25,70,15,25,25,25,15 )); 
                $this->SetAligns(array("C","C","C","C","C","C","C"));   
                $this->Row(array('Orden de Pago','Beneficiario','Fecha', 'Monto Factura.', 'Base Imp.', 'Monto de Deduc.', 'Porc. %'),1,0);
                $this->SetAligns(array("C","L","C","L","L","L","C","C"));   

            }

        $this->Ln(5);
        $this->setX(10);
        $this->SetFont( 'Arial', 'B', 8);
        $this->SetWidths(array(110,25,25,25 )); 
        $this->SetAligns(array("C","L","L","L","L"));
        $this->Row(array(utf8_decode('TOTAL GENERAL: '), 
        number_format($nu_total_general, 2, ',','.'), 
        number_format($nu_base_imponible_general, 2, ',','.'), 
        number_format($nu_iva_retencion_general, 2, ',','.') ),0,0);
         
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

    function getGrupo(){

        $condicion ="";    
        $condicion .= " tb060.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb060.fe_pago <= '".$_GET["fe_fin"]."' ";
    

        $conex = new ConexionComun();
        
        $sql = "SELECT tb045.co_iva_retencion
        FROM tb045_factura as tb045
        inner join tb008_proveedor as tb008 on tb008.co_proveedor = tb045.co_proveedor
        inner join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
        inner join tb060_orden_pago as tb060 ON tb060.co_orden_pago = tb045.co_odp
        WHERE ".$condicion."
        group by tb045.co_iva_retencion order by 1 ASC;";
        
        return $conex->ObtenerFilasBySqlSelect($sql);

    }

    function getRetenciones( ){

        $condicion ="";    
        $condicion .= " tb060.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb060.fe_pago <= '".$_GET["fe_fin"]."' ";
    

        $conex = new ConexionComun();

        $sql = "SELECT inicial||tx_rif as rif, tx_razon_social, tx_serial, nu_total, nu_base_imponible, '055' as concepto,
        nu_factura as numerofact, 
        nu_control as numerocont, to_char(tb060.fe_pago, 'DD/MM/YYYY') as fechaopera, '055'::text as codigoconc,
        tb046.mo_retencion as montoopera, po_retencion
        FROM tb046_factura_retencion as tb046
        inner join tb041_tipo_retencion as tb041 on tb046.co_tipo_retencion = tb041.co_tipo_retencion
        inner join tb045_factura as tb045 on tb046.co_factura = tb045.co_factura
        inner join tb008_proveedor as tb008 on tb008.co_proveedor = tb045.co_proveedor
        inner join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
        left join tb060_orden_pago as tb060 on tb045.co_odp = tb060.co_orden_pago
        where tb046.co_tipo_retencion = 95 and tb046.in_anular is null AND ".$condicion."
        order by tb060.fe_pago ASC,rif ASC;";                 
         
          return $conex->ObtenerFilasBySqlSelect($sql);
  
    }

    function getCuenta( $cuenta){

        $conex = new ConexionComun();

            $sql = "SELECT co_cuenta_bancaria, tx_cuenta_bancaria, co_banco, co_tipo_cuenta, 
            co_empresa, in_activo, co_descripcion_cuenta, co_cuenta_contable, 
            mo_disponible, tx_descripcion, tip_cuenta, tx_cuenta_contable, 
            mo_ingreso, mo_egreso, tip_mov, nu_contrato
            FROM public.tb011_cuenta_bancaria
            WHERE co_cuenta_bancaria = ".$cuenta.";";
                   
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];

    }
    
 }

$pdf=new PDF('P','mm','letter');
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
