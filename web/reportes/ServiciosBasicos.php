<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {
     $this->SetFont('Arial','B',8);
     
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

   
        
     function CuerpoFactura() {

         $this->Ln(1);

         $this->lista_facturas = $this->getFacturas();

         $campo='';         
         foreach($this->lista_facturas as $key => $campo){ 
         $this->AddPage(); 
         $this->SetFont('Arial','B',8);
         $this->Image("imagenes/escudosanfco.png", 20, 7,20);         

         $this->SetTextColor(0,0,0);
         $this->SetY(10);
         $this->SetX(140); // configura la linea donde comenzara escribir en el eje de y
         $this->Cell(30,0,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
         $this->SetY(14);
         $this->SetX(140); // configura la linea donde comenzara escribir en el eje de y
         $this->Cell(30,0,utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'),0,0,'C');
         $this->SetY(18);
         $this->SetX(140); // configura la linea donde comenzara escribir en el eje de y
         $this->Cell(30,0,utf8_decode('SECRETARIA DE ADMINISTRACIÓN Y FINANZAS'),0,0,'C'); 
         $this->Ln(12);
         $this->SetFont('Arial','B',14);       
         $this->Cell(0,0,utf8_decode(' CONSIGNACIÓN '),0,0,'C');   
         
         $this->SetY(50);
         
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);         
         $this->SetFont('Arial','B',9);
         $this->Row(array(utf8_decode('DATOS DE LA FACTURA')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetFont('Arial','',9);
         $this->SetAligns(array("L","L","L","L"));
         $this->SetWidths(array(50,50,50,50));         
         $this->Row(array(utf8_decode('No.FACTURA:').$campo['nu_factura'],'No.CONTROL:'.$campo['nu_control'], utf8_decode('MONTO:  ').number_format($campo['nu_total'], 2, ',','.'),utf8_decode('FECHA:').$campo['fe_emision']),1,1);
         $this->SetWidths(array(200)); 
         $this->Row(array(utf8_decode('SEÑOR(ES):'.$campo['tx_razon_social']).'- R.I.F:'.utf8_decode($campo['tx_rif'])),1,1);                  
         $this->Row(array(utf8_decode('DIRECCIÓN:').$campo['tx_direccion']),1,1); 
         $this->Row(array(utf8_decode('CONCEPTO:').utf8_decode($campo['tx_concepto'])),1,1);                  
         $this->Ln();                          
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Arial','B',9); 
         $this->Row(array(utf8_decode('RETENCIONES ASOCIADAS')),1,1);
         $this->SetFillColor(255, 255, 255); 
         $this->SetFont('Arial','',9); 
         $this->SetAligns(array("C","C","C","C"));
         $this->SetWidths(array(50,50,50,50));
         $this->Row(array('BASE IMPONIBLE:  '.number_format($campo['nu_base_imponible'], 2, ',','.'),'IVA:  '.number_format($campo['nu_iva_factura'], 2, ',','.'),utf8_decode('MONTO EXENTO: ').number_format($campo['monto_excento'], 2, ',','.'),'TOTAL A PAGAR:  '.number_format($campo['total_pagar'], 2, ',','.')),1,1);

         $this->SetFont('Arial','',9); 
         $this->SetWidths(array(100,100));
         $campo1='';
         $this->lista_retenciones = $this->getRetenciones($campo['co_factura']);
         foreach($this->lista_retenciones as $key => $campo1){                    
         if(($campo1['co_tipo_retencion'])==92){
         $this->Row(array(utf8_decode($campo1['tx_tipo_retencion']),number_format($campo1['nu_iva_retencion'], 2, ',','.')),1,1);     
         }else{
         $this->Row(array(utf8_decode($campo1['tx_tipo_retencion']),number_format($campo1['mo_retencion'], 2, ',','.')),1,1);     
         }
         }
         
         $this->SetWidths(array(100,100));
         
         $this->Row(array('SUB TOTAL GRAVADO CS:  '.number_format($campo['sub_total_cs'], 2, ',','.'),'IVA CS ('.number_format($campo['nu_iva_cs'], 2, ',','.').' %):  '.number_format($campo['iva_cs'], 2, ',','.')),1,1);
                  
         

        } 
        $this->CuerpoRetenciones();

    }
    
    function CuerpoRetenciones() {       

         $campo='';
         
         $this->datos = $this->getFacturas(); 
         foreach($this->datos as $key => $campo){ 
             
         $this->lista_retenciones = $this->getRetenciones($campo['co_factura']);
         
         foreach($this->lista_retenciones as $key => $campo1){                             
            $this->addPage();
            $this->SetFont('Arial','B',8);
            $this->Image("imagenes/escudosanfco.png", 20, 7,20);         

            $this->SetTextColor(0,0,0);
            $this->SetY(10);
            $this->SetX(140); // configura la linea donde comenzara escribir en el eje de y
            $this->Cell(30,0,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
            $this->SetY(14);
            $this->SetX(140); // configura la linea donde comenzara escribir en el eje de y
            $this->Cell(30,0,utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'),0,0,'C');
            $this->SetY(18);
            $this->SetX(140); // configura la linea donde comenzara escribir en el eje de y
            $this->Cell(30,0,utf8_decode('SECRETARIA DE ADMINISTRACIÓN Y FINANZAS'),0,0,'C');             
            $this->Ln(8);

           $this->SetWidths(array(140,30, 30));
            $this->SetAligns(array("L","R","L"));
            $this->SetFont('Arial','',8);
            $this->Row(array('','Fecha Comprob.: ',$campo1['fe_emision']),0,0);   
            $this->Row(array('','Periodo Fiscal: ', utf8_decode('AÑO: '.$campo1['anio'].' / MES: '.$campo1['mes'])),0,0);   
            $this->Row(array('','Comprob. Nro.: ',$campo1['anio'].'-'.$campo1['co_factura_retencion']),0,0);               
            $this->SetWidths(array(200));
            $this->SetAligns(array("C")); 
            $this->Ln(8);            
            
            $this->SetFont('Arial','B',12);
            $this->Cell(0,0,utf8_decode('COMPROBANTE DE RETENCIÓN DE '.strtoupper($campo1['tx_tipo_retencion'])),0,0,'C');   
            $this->Ln(8);  
            $this->SetFont('Arial','',10);
            $texto = "";
            // Retención IVA
            if(($campo1['co_tipo_retencion'])==92)  $texto = 'VA-ART.11: Serán responsable del pago del impuesto en calidad de agente de retención compradores o adquirientes de determinados bienes inmuebles y los recpetores de ciertos servicios, a quienes la Administración Tributaria designe como tal.';
            // Retencion ISLR
            if(($campo1['co_tipo_retencion'])==4)  $texto = 'Gaceta Oficial Nro. 36.206 del 12/05/1997 Decreto Nro.1808 del 23/04/1997'; 
            
            $this->MultiCell(200,4,utf8_decode($texto),0,1,'J',0);
            $this->Ln(8);              
            $this->SetFillColor(201, 199, 199);
            $this->SetFont('Arial','B',10);
            $this->SetWidths(array(200));
            $this->SetAligns(array("C"));
            $this->Row(array(utf8_decode('SUJETO RETENIDO (PROVEEDOR / BENEFICIARIO)')),1,1);
            $this->SetFillColor(255, 255, 255);
            $this->SetWidths(array(100,50,50));
            $this->SetAligns(array("L","L","L","L"));
            $this->SetFont('Arial','',9);
            $this->Row(array(utf8_decode('Proveedor.: ').$campo['tx_razon_social'],utf8_decode('R.I.F.:  ').$campo['tx_rif'], 'NIT:  '),1,1);         
            $this->SetWidths(array(200));
            $this->Row(array(utf8_decode('Dirección: ').$campo['tx_direccion']),1,1);             
            $this->Ln(5);
            $this->SetWidths(array(200));
            $this->SetAligns(array("C"));
            $this->SetFillColor(201, 199, 199); 
            $this->SetFont('Arial','B',10);            
            $this->Row(array(utf8_decode('AGENTE DE RETENCIÓN (EMPRESA)')),1,1);
            $this->SetFillColor(255, 255, 255);
            $this->SetAligns(array("L","L","L","L"));
            $this->SetWidths(array(150,50));                 
            $this->SetFont('Arial','',9);          
            $this->Row(array(utf8_decode('Empresa.: GOBERNACIÓN DEL EDO. ZULIA'),utf8_decode('R.I.F.:  G-200036524')),1,1);         
            $this->SetWidths(array(200));
            $this->Row(array(utf8_decode('Dirección: AV. BELLA VISTA EDIFICIO FEDERAL MARACAIBO EDO. ZULIA')),1,1);  
            $this->Ln(5);

            $this->SetWidths(array(200));
            $this->SetAligns(array("C"));
            $this->SetFillColor(201, 199, 199);
            $this->SetFont('Arial','B',10); 
            $this->Row(array(utf8_decode('RETENCIÓN (COMPRAS INTERNAS O IMPORTACIONES)')),1,1);
            $this->SetFillColor(255, 255, 255); 
            $this->SetAligns(array("L","L","R","L"));
            $this->SetWidths(array(30,30,40,100));         
            $this->SetFont('Arial','',9);            
            $this->Row(array('Nro.: '.$campo['nu_factura'],'Fecha: '.$campo['fe_emision'],'Monto: '.number_format($campo['nu_total'], 2, ',','.'), 'Concepto:  '.utf8_decode($campo['tx_concepto'])),1,1);
            $this->SetWidths(array(60,40,50,50)); 
            $this->SetAligns(array("C","C","C","C"));             
            $this->Row(array('Base Imponible: '.number_format($campo['nu_base_imponible'], 2, ',','.'),'IVA: '.$campo['nu_iva_factura'],'Monto Exento: '.number_format($campo['monto_excento'], 2, ',','.'),'Total a pagar: '.number_format($campo['total_pagar'], 2, ',','.')),1,1);

            $this->SetWidths(array(100,100));
            if(($campo1['co_tipo_retencion'])==92){
            $this->Row(array(utf8_decode($campo1['tx_tipo_retencion']),number_format($campo1['nu_iva_retencion'], 2, ',','.')),1,1);     
            }else{
            $this->Row(array(utf8_decode($campo1['tx_tipo_retencion']),number_format($campo1['mo_retencion'], 2, ',','.')),1,1);     
            }
            $this->SetWidths(array(100,100));
            $this->Row(array('SUB TOTAL GRAVADO CS:  '.number_format($campo['sub_total_cs'], 2, ',','.'),'IVA CS ('.number_format($campo['nu_iva_cs'], 2, ',','.').' %):  '.number_format($campo['iva_cs'], 2, ',','.')),1,1);
               
            $this->SetFont('Arial','B',10);              
            $this->Ln(40);   
            $y= $this->GetY();
            $this->line(40, $y, 80, $y);
            $this->SetY($y+4);
            $this->SetAligns(array("L"));
            $this->SetWidths(array(25,110,40));                    
            $this->Row(array('',utf8_decode('Firma del Agente de Retención'), 'Firma del Beneficiario'),0,0);

            $this->line(145, $y, 185, $y);               
	             
         } 
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

        $this->CuerpoFactura();        
    }

    
    function TotalMonto(){

    $conex = new ConexionComun();     
    $sql = "select sum(tb045.nu_total) as nu_monto, sum(tb045.total_pagar) as total_pagar
                  from   tb026_solicitud as tb026
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud                                                   
                  left join tb045_factura as tb045 on tb045.co_compra = tb052.co_compras 
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud 
                  where tb030.co_ruta =".$_GET['codigo']." group by tb045.co_compra";
               
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];  
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
                         tb008.tx_rif,     
                         tb008.tx_direccion,                          
                         upper(tb008.nb_representante_legal) as nb_representante_legal,
                         tb008.nu_cedula_representante,
                         tb047.tx_ente,  
                         tb001.nb_usuario,
                         tb062.mo_pagar as nu_monto,
                         tb052.anio,
                         tb052.co_solicitud,
                         tb039.nu_requisicion,  
                         tb039.tx_concepto as concepto_req,
                         tb039.created_at, 
                         tb045.co_odp,
                         tb052.nu_orden_compra,
                         tb060.tx_serial,
                         tb045.sub_total_cs,
                         tb045.nu_iva_cs,
                         round((tb045.sub_total_cs * tb045.nu_iva_cs)/100,2) as iva_cs,
                         case when(tb045.co_iva_factura = 0) then nu_total else nu_exento end as monto_excento,
                         to_char(tb045.fe_registro,'dd') as dia,
                         to_char(tb045.fe_registro,'mm') as mes,
                         to_char(tb045.fe_registro,'yy') as anio                         
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
                  where tb030.co_ruta =".$_GET['codigo']." order by co_factura asc ";
               
         // echo var_dump($sql);  exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;   
    }
    function getRetenciones($fact){

	  $conex = new ConexionComun();
          $sql = "select  nu_factura, 
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
                          tb045.sub_total_cs,
                          tb045.nu_iva_cs,
                          co_factura_retencion,
                          to_char(tb045.fe_registro,'dd') as dia,
                          to_char(tb045.fe_registro,'mm') as mes,
                          to_char(tb045.fe_registro,'yy') as anio
                  from   tb045_factura as tb045     
                  left join tb046_factura_retencion as tb046 on tb046.co_factura = tb045.co_factura
                  left join tb041_tipo_retencion as tb041 on tb041.co_tipo_retencion = tb046.co_tipo_retencion
                  where tb045.co_factura = ".$fact; 
                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
  
    }
    
    function getPart()
    {
        $conex = new ConexionComun();
        $sql ="   select distinct tb083.id_tb013_anio_fiscal||'-'||tb082.nu_ejecutor||'-'||tb085.co_categoria as co_categoria,
                         upper(tb052.tx_observacion) as tx_observacion,
                         de_partida,
                         sum(case when (tb053.in_calcular_iva) then tb053.monto else tb052.monto_iva end) as monto                        
                  from  tb052_compras as tb052 
                  left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras 
                  left join tb085_presupuesto as tb085 on tb085.id = tb053.co_presupuesto
                  left join tb084_accion_especifica as tb084 on tb085.id_tb084_accion_especifica = tb084.id
                  left join tb083_proyecto_ac as tb083 on tb084.id_tb083_proyecto_ac = tb083.id
                  left join tb082_ejecutor as tb082 on tb082.id = tb083.id_tb082_ejecutor
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud and tb030.in_cargar_dato is true                               
                  where tb030.co_ruta = ".$_GET['codigo'].' group by 1, 2, 3 '; //$conex->decrypt($_GET['codigo']);
       // echo var_dump($sql); exit();

        return $conex->ObtenerFilasBySqlSelect($sql);
		  
    }
    

}

$pdf=new PDF('P','mm','letter');
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
$pdf->SetMargins(0, 0);
$pdf->Output($dir, 'F');


//$pdf=new PDF('P','mm','letter');
//$pdf->PrintChapter();
//$pdf->SetMargins(0, 0);
//$pdf->SetDisplayMode('default');
//$pdf->Output();

?>