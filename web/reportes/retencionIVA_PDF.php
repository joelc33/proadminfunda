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
        $this->Cell(0,0,utf8_decode('COORDINACIÓN GENERAL DE ADMINISTRACIÓN'),0,0,'C');
        $this->Ln(8);
        $this->SetFont('Arial','B',10);
        $this->Cell(0,0,utf8_decode('RETENCIONES IVA'),0,0,'C');
        $this->Ln(4);
        $this->SetFont('Arial','',8);

        $this->Cell(0,0,utf8_decode('San Francisco, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
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

        $this->datos_grupo = $this->getGrupo();
        $this->datos_cuenta = $this->getCuenta( 92);

        $nu_total_general=0;
        $nu_base_imponible_general=0;
        $nu_iva_factura_general=0;
        $nu_iva_retencion_general=0;

        foreach($this->datos_grupo as $key => $campo1){

            $this->Ln(10);
            $this->setX(10);
            $this->SetFont('Arial','',7);     
            $this->SetWidths(array(140 ));  
            $this->SetAligns(array("L",));   
            $this->Row(array( 'PORCENTAJE DE RETENCION: '.$campo1["co_iva_retencion"]  ),0,0); 
//            $this->Ln(2);
//            $this->Row(array( utf8_decode('CUENTA N°: '.$this->datos_cuenta["tx_cuenta_bancaria"].' - '.$this->datos_cuenta["tx_descripcion"] )  ),0,0); 
            $this->Ln(2);

            $this->datos = $this->getRetenciones( $campo1["co_iva_retencion"]);
        
            $this->SetFont('Arial','',7);     
            $this->SetWidths(array(140 ));  
            $this->SetAligns(array("L",));   
            $this->Row(array( 'RANGO DE FECHA DEL: '.$_GET["fe_inicio"].' AL: '.$_GET["fe_fin"]  ),0,0); 
            $this->Ln(2);
            $this->SetFont('Arial','B',7);     
            $this->SetWidths(array(10,25,50,15,25,25,25,25 ));  
            $this->SetAligns(array("C","C","C","C","C","C","C","C"));   
            $this->Row(array(utf8_decode('Nº'),'Orden de Pago','Beneficiario','Fecha', 'Monto Factura.', 'Base Imp.', 'Obj. de Ret.', 'Monto de Deduc.'),1,0); 
            $this->SetAligns(array("C","C","L","C","L","L","L"));                  
            //$this->Ln(2);
            $nu_total=0;
            $nu_base_imponible=0;
            $nu_iva_factura=0;
            $nu_iva_retencion=0;
            $i = 1;
            foreach($this->datos as $key => $campo){
                
                $this->setX(10);
                $this->SetFont('Arial','',6);
                $this->SetWidths(array(10,25,50,15,25,25,25,25 ));  
                $this->Row(array($i,$campo['tx_serial'], utf8_decode($campo['rif_prov'].' - '.$campo['den_pro']), $campo['fe_pago'], 
                number_format($campo['nu_total'], 2, ',','.'), 
                number_format($campo['nu_base_imponible'], 2, ',','.'), 
                number_format($campo['nu_iva_factura'], 2, ',','.'), 
                number_format($campo['nu_iva_retencion'], 2, ',','.') ),1,0);

                $nu_total = $campo['nu_total'] + $nu_total;
                $nu_base_imponible = $campo['nu_base_imponible'] + $nu_base_imponible;
                $nu_iva_factura = $campo['nu_iva_factura'] + $nu_iva_factura;
                $nu_iva_retencion = $campo['nu_iva_retencion'] + $nu_iva_retencion;

                $nu_total_general = $campo['nu_total'] + $nu_total_general;
                $nu_base_imponible_general = $campo['nu_base_imponible'] + $nu_base_imponible_general;
                $nu_iva_factura_general = $campo['nu_iva_factura'] + $nu_iva_factura_general;
                $nu_iva_retencion_general = $campo['nu_iva_retencion'] + $nu_iva_retencion_general;

                if($this->getY()>240){

                    $this->AddPage();
                    $this->setX(10);
                    $this->Ln(10);
                    $this->SetFont('Arial','',7);     
                    $this->SetWidths(array(140 ));  
                    $this->SetAligns(array("L",));   
                    $this->Row(array( 'PORCENTAJE DE RETENCION: '.$campo1["co_iva_retencion"]  ),0,0); 
                    $this->Ln(2);
                    $this->Row(array( utf8_decode('CUENTA N°: '.$this->datos_cuenta["tx_cuenta_bancaria"].' - '.$this->datos_cuenta["tx_descripcion"] )  ),0,0); 
                    $this->Ln(2);

                    $this->SetFont('Arial','',7);     
                    $this->SetWidths(array(140 ));  
                    $this->SetAligns(array("L",));   
                    $this->Row(array( 'RANGO DE FECHA DEL: '.$_GET["fe_inicio"].' AL: '.$_GET["fe_fin"]  ),0,0); 
                    $this->Ln(2);
                    $this->SetFont('Arial','B',7);     
                    $this->SetWidths(array(10,25,50,15,25,25,25,25 ));   
                    $this->SetAligns(array("C","C","C","C","C","C","C","C"));   
                    $this->Row(array(utf8_decode('Nº'),'Orden de Pago','Beneficiario','Fecha', 'Monto Factura.', 'Base Imp.', 'Obj. de Ret.', 'Monto de Deduc.'),1,0); 
                    $this->SetAligns(array("C","C","L","C","L","L","L"));

                }
                $i++;
            }

            $this->anulado = $this->getAnulado( $campo1["co_iva_retencion"]);

            if(count($this->anulado)>0){

                $nu_total_anulado = 0;
                $nu_base_imponible_anulado = 0;
                $nu_iva_factura_anulado = 0;
                $nu_iva_retencion_anulado = 0;

                $nu_total_general_anulado = 0;
                $nu_base_imponible_general_anulado = 0;
                $nu_iva_factura_general_anulado = 0;
                $nu_iva_retencion_general_anulado = 0;

                $this->Ln(10);
                $this->setX(10);
                $this->SetFont('Arial','',7);     
                $this->SetWidths(array(140 ));  
                $this->SetAligns(array("L",));   
                $this->Row(array('RETENCIONES ANULADAS'),0,0); 
                $this->Ln(2);
                $this->Row(array( utf8_decode('CUENTA N°: '.$this->datos_cuenta["tx_cuenta_bancaria"].' - '.$this->datos_cuenta["tx_descripcion"] )  ),0,0); 
                $this->Ln(2);

                $i = 1;
                foreach($this->anulado as $key => $campo_anulado){

                    $nu_total_anulado = $campo_anulado['nu_total'] + $nu_total_anulado;
                    $nu_base_imponible_anulado = $campo_anulado['nu_base_imponible'] + $nu_base_imponible_anulado;
                    $nu_iva_factura_anulado = $campo_anulado['nu_iva_factura'] + $nu_iva_factura_anulado;
                    $nu_iva_retencion_anulado = $campo_anulado['nu_iva_retencion'] + $nu_iva_retencion_anulado;
    
                    $nu_total_general_anulado = $campo_anulado['nu_total'] + $nu_total_general_anulado;
                    $nu_base_imponible_general_anulado = $campo_anulado['nu_base_imponible'] + $nu_base_imponible_general_anulado;
                    $nu_iva_factura_general_anulado = $campo_anulado['nu_iva_factura'] + $nu_iva_factura_general_anulado;
                    $nu_iva_retencion_general_anulado = $campo_anulado['nu_iva_retencion'] + $nu_iva_retencion_general_anulado;
                    
                    $this->setX(10);
                    $this->SetFont('Arial','',6);
                    $this->SetWidths(array(10,25,50,15,25,25,25,25 ));  
                    $this->Row(array($i,$campo_anulado['tx_serial'], utf8_decode($campo_anulado['rif_prov'].' - '.$campo_anulado['den_pro']), $campo_anulado['fe_pago'], 
                    number_format($campo_anulado['nu_total'], 2, ',','.'), 
                    number_format($campo_anulado['nu_base_imponible'], 2, ',','.'), 
                    number_format($campo_anulado['nu_iva_factura'], 2, ',','.'), 
                    number_format($campo_anulado['nu_iva_retencion'], 2, ',','.') ),1,0);
    
                    $i++;
                }
                $this->Ln(10);

                /*$nu_total = $nu_total_anulado + $nu_total;
                $nu_base_imponible = $nu_base_imponible_anulado + $nu_base_imponible;
                $nu_iva_factura = $nu_iva_factura_anulado + $nu_iva_factura;
                $nu_iva_retencion = $nu_iva_retencion_anulado + $nu_iva_retencion;

                $nu_total_general = $nu_total_general_anulado + $nu_total_general;
                $nu_base_imponible_general = $nu_base_imponible_general_anulado + $nu_base_imponible_general;
                $nu_iva_factura_general = $nu_iva_factura_general_anulado + $nu_iva_factura_general;
                $nu_iva_retencion_general = $nu_iva_retencion_general_anulado + $nu_iva_retencion_general;*/

            }

            $this->setX(10);
            $this->SetFont( 'Arial', 'B', 7);
            $this->SetWidths(array(100,25,25,25,25 )); 
            $this->SetAligns(array("C","L","L","L","L"));
            $this->Row(array(utf8_decode('TOTAL PROCENTAJE: '.$campo1["co_iva_retencion"]), 
            number_format($nu_total, 2, ',','.'), 
            number_format($nu_base_imponible, 2, ',','.'), 
            number_format($nu_iva_factura, 2, ',','.'), 
            number_format($nu_iva_retencion, 2, ',','.') ),1,0);

            if($this->getY()>240){

                $this->AddPage();
                $this->setX(10);
                $this->Ln(10);
                $this->SetFont('Arial','',7);     
                $this->SetWidths(array(140 ));  
                $this->SetAligns(array("L",));   
                $this->Row(array( 'PORCENTAJE DE RETENCION: '.$campo1["co_iva_retencion"]  ),0,0); 
                $this->Ln(2);
                $this->Row(array( utf8_decode('CUENTA N°: '.$this->datos_cuenta["tx_cuenta_bancaria"].' - '.$this->datos_cuenta["tx_descripcion"] )  ),0,0); 
                $this->Ln(2);

                $this->SetFont('Arial','',7);     
                $this->SetWidths(array(140 ));  
                $this->SetAligns(array("L",));   
                $this->Row(array( 'RANGO DE FECHA DEL: '.$_GET["fe_inicio"].' AL: '.$_GET["fe_fin"]  ),0,0); 
                $this->Ln(2);
                $this->SetFont('Arial','B',7);     
                $this->SetWidths(array(10,25,50,15,25,25,25,25 ));   
                $this->SetAligns(array("C","C","C","C","C","C","C","C"));   
                $this->Row(array(utf8_decode('Nº'),'Orden de Pago','Beneficiario','Fecha', 'Monto Factura.', 'Base Imp.', 'Obj. de Ret.', 'Monto de Deduc.'),1,0); 
                $this->SetAligns(array("C","C","L","C","L","L","L"));

            }
            
        }

        $this->Ln(5);
        $this->setX(10);
        $this->SetFont( 'Arial', 'B', 8);
        $this->SetWidths(array(100,25,25,25,25 )); 
        $this->SetAligns(array("C","L","L","L","L"));
        $this->Row(array(utf8_decode('TOTAL GENERAL: '), 
        number_format($nu_total_general, 2, ',','.'), 
        number_format($nu_base_imponible_general, 2, ',','.'), 
        number_format($nu_iva_factura_general, 2, ',','.'), 
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
        $condicion .= " tb063.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb063.fe_pago <= '".$_GET["fe_fin"]."' ";
    

        $conex = new ConexionComun();
        
        $sql = "SELECT tb045.co_iva_retencion
        FROM tb045_factura as tb045
        inner join tb008_proveedor as tb008 on tb008.co_proveedor = tb045.co_proveedor
        inner join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
        inner join tb060_orden_pago as tb060 ON tb060.co_orden_pago = tb045.co_odp
        inner join tb062_liquidacion_pago as tb062 ON tb062.co_odp = tb060.co_orden_pago
        inner join tb063_pago as tb063 ON tb063.co_liquidacion_pago = tb062.co_liquidacion_pago
        WHERE ".$condicion."
        group by tb045.co_iva_retencion order by 1 ASC;";
        
        //echo var_dump($sql); exit();
        
        return $conex->ObtenerFilasBySqlSelect($sql);

    }

    function getRetenciones( $co_iva_retencion){
    

        $conex = new ConexionComun();
        
        if(strtotime($_GET["fe_inicio"])<'01-10-2018'){
            
        $condicion ="";    
        $condicion .= " tb060.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb060.fe_pago <= '".$_GET["fe_fin"]."' ";            

        $sql = "SELECT 'G200036524'::text as rif_gob, to_char(tb060.fe_pago, 'YYYYMM') as per_imp, tb045.fe_emision as fec_doc, 'C'::text as compra, '01'::text as factura, 
        inicial||tx_rif as rif_prov, 
        tx_razon_social as den_pro, nu_factura as nro_dcto, 
        nu_control as nro_cont, nu_total, nu_iva_factura, nu_iva_retencion, 
        to_char(tb060.fe_pago, 'YYYYMM')||lpad((tb045.co_solicitud)::text, 8, '0')::text as nro_com, 0 as dcto_af, 
        0 as mont_ex, co_iva_factura as alicuota, 0 as nro_exp,
        tb060.tx_serial, to_char(tb045.fe_emision, 'DD/MM/YYYY') as fe_emision, to_char(tb060.fe_pago, 'DD/MM/YYYY') as fe_pago, nu_base_imponible
          FROM tb045_factura as tb045
          inner join tb008_proveedor as tb008 on tb008.co_proveedor = tb045.co_proveedor
          inner join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
          inner join tb060_orden_pago as tb060 ON tb060.co_orden_pago = tb045.co_odp
          WHERE tb045.in_anular is not true and tb045.co_iva_retencion = ".$co_iva_retencion." and tb060.in_anular is not true AND tb060.in_anulado is not true and ".$condicion."
          order by tb060.fe_pago ASC;";  
        }else{
            
        $condicion ="";    
        $condicion .= " tb063.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb063.fe_pago <= '".$_GET["fe_fin"]."' ";            
            
       //consulta nueva la que se esta usuando hasta 14-06-2019, se regreso a la consulta vieja para que pueda cuadrar con el modulo de fondos de terceros, se va regresar a la nueva cuando se llegue a la semana donde se habia cambiado a la nueva en su momento 
       $sql = "SELECT 'G200036524'::text as rif_gob, to_char(tb060.fe_pago, 'YYYYMM') as per_imp, tb045.fe_emision as fec_doc, 'C'::text as compra, '01'::text as factura, 
        inicial||tx_rif as rif_prov, 
        tx_razon_social as den_pro, nu_factura as nro_dcto, 
        nu_control as nro_cont, nu_total, nu_iva_factura, nu_iva_retencion, 
        to_char(tb060.fe_pago, 'YYYYMM')||lpad((tb045.co_solicitud)::text, 8, '0')::text as nro_com, 0 as dcto_af, 
        0 as mont_ex, co_iva_factura as alicuota, 0 as nro_exp,
        tb060.tx_serial, to_char(tb045.fe_emision, 'DD/MM/YYYY') as fe_emision, to_char(tb063.fe_pago, 'DD/MM/YYYY') as fe_pago, nu_base_imponible
          FROM tb045_factura as tb045
          inner join tb008_proveedor as tb008 on tb008.co_proveedor = tb045.co_proveedor
          inner join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
          inner join tb060_orden_pago as tb060 ON tb060.co_orden_pago = tb045.co_odp
          inner join tb062_liquidacion_pago as tb062 ON tb062.co_odp = tb060.co_orden_pago
          inner join tb063_pago as tb063 ON tb063.co_liquidacion_pago = tb062.co_liquidacion_pago
          WHERE tb045.in_anular is not true and tb045.co_iva_retencion = ".$co_iva_retencion." and tb060.in_anular is not true AND tb060.in_anulado is not true and ".$condicion."
          order by tb063.fe_pago ASC;";    
        }
          //echo var_dump($sql); exit();
         
          return $conex->ObtenerFilasBySqlSelect($sql);
  
    }

    function getAnulado( $co_iva_retencion){

        $condicion ="";    
        $condicion .= " tb063.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb063.fe_pago <= '".$_GET["fe_fin"]."' ";
    

        $conex = new ConexionComun();

        $sql = "SELECT 'G200036524'::text as rif_gob, to_char(tb060.fe_pago, 'YYYYMM') as per_imp, tb045.fe_emision as fec_doc, 'C'::text as compra, '01'::text as factura, 
        inicial||tx_rif as rif_prov, 
        tx_razon_social as den_pro, nu_factura as nro_dcto, 
        nu_control as nro_cont, nu_total, nu_iva_factura, nu_iva_retencion, 
        to_char(tb060.fe_pago, 'YYYYMM')||lpad((tb045.co_solicitud)::text, 8, '0')::text as nro_com, 0 as dcto_af, 
        0 as mont_ex, co_iva_factura as alicuota, 0 as nro_exp,
        tb060.tx_serial, to_char(tb045.fe_emision, 'DD/MM/YYYY') as fe_emision, to_char(tb063.fe_pago, 'DD/MM/YYYY') as fe_pago, nu_base_imponible
          FROM tb045_factura as tb045
          inner join tb008_proveedor as tb008 on tb008.co_proveedor = tb045.co_proveedor
          inner join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
          inner join tb060_orden_pago as tb060 ON tb060.co_orden_pago = tb045.co_odp
          inner join tb062_liquidacion_pago as tb062 ON tb062.co_odp = tb060.co_orden_pago
          inner join tb063_pago as tb063 ON tb063.co_liquidacion_pago = tb062.co_liquidacion_pago
          WHERE tb045.in_anular is true 
          and tb045.co_iva_retencion = ".$co_iva_retencion." 
          and tb060.in_anular is true 
          --AND tb060.in_anulado is true 
          and ".$condicion."
          order by tb063.fe_pago ASC;";   
        
          //echo var_dump($sql); exit();
         
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
