<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->Image("imagenes/escudosanfco.png", 20, 7,20);

        $this->SetFont('Arial','B',8);

        $this->SetTextColor(0,0,0);
        $this->SetY(10);
        $this->SetX(140); // configura la linea donde comenzara escribir en el eje de y
        $this->Cell(30,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->SetY(14);
        $this->SetX(140); // configura la linea donde comenzara escribir en el eje de y
        $this->Cell(30,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
               
    

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
/*
    function ChapterBody() {

         $this->Ln(1);

         $this->datos = $this->getFacturas();

         $campo='';         
         foreach($this->datos as $key => $campo){ 
         $this->AddPage();    
         //$this->line(1, 60, 220, 60);
         $this->Ln(12);
        $this->SetFont('Arial','B',10);
        $this->Cell(0,0,utf8_decode('Rel: '.$campo['anio'].'-'.$campo['co_solicitud']),0,0,'C'); 
        $this->SetX(140); // configura la linea donde comenzara escribir en el eje de y
        $this->SetFont('Arial','B',12);
        $y = $this->getY();
        $x =$this->getX();
        $this->Cell(0,0,utf8_decode(' ORDEN DE PAGO '),0,0,'C');      
        $this->SetX($x+200); // configura la linea donde comenzara escribir en el eje de y
        $this->SetFont('Arial','B',10);
        $this->Cell(0,0,utf8_decode($campo['numero_compra']),0,0,'C');      
        $this->SetX($x+200); // configura la linea donde comenzara escribir en el eje de y
        
        $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(60,140));
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);         
         $this->SetFont('Arial','B',8);
         $this->Row(array(utf8_decode('DOCUMENTOS Y RETENCIONES')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(40,160));         
         $this->SetFont('Arial','',6);
         $this->SetAligns(array("L","L","L","L","L","L"));
         $this->SetWidths(array(15,20,15,15,15,120));                 
         $this->SetFont('Arial','',6);          
         $this->Row(array(utf8_decode('Nro.Factura:'),$this->datos['nu_factura'],utf8_decode('Fecha:'), $this->datos['fe_emision'],'Concepto:',$this->datos['tx_concepto']),1,1);
         $this->SetAligns(array("C","C","C","C","C","C","C","C"));
         $this->SetWidths(array(20,30,20,30,20,30,20,30));
         $this->Row(array('Base Imponible',$this->datos['nu_base_imponible'],'IVA',$this->datos['nu_iva_factura'],utf8_decode('Monto Exento'),'0','Total a pagar',number_format($this->datos['total_pagar'], 2, ',','.')),1,1);
         $this->SetWidths(array(70,130));
         $this->Row(array(utf8_decode('RETENCIÓN I.V.A'),$this->datos['nu_iva_retencion']),1,1);
         $campo1='';
         $this->lista_retenciones = $this->getRetenciones($this->datos['co_factura']);
         foreach($this->lista_retenciones as $key => $campo1){                    
          $this->Row(array(utf8_decode($campo1['tx_tipo_retencion']),number_format($campo1['mo_retencion'], 2, ',','.')),1,1);
         }        
         
         $this->SetY(160);
         $this->SetWidths(array(100,100));
         $this->SetAligns(array("C","C"));
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Arial','B',7); 
         $this->Row(array('CODIGOS CONTABLES','CATEGORIAS PRESUPUESTARIAS'),1,1);
         $this->SetFillColor(255, 255, 255); 
         $this->SetFont('Arial','B',6); 
         $this->SetAligns(array("C","C","C","C","C"));
         $this->SetWidths(array(40,30,30,50,50));
         $this->Row(array('CUENTA','DEBITOS','CREDITOS','PARTIDA','MONTO'),1,1);
         $fila = $this->getY();
         $this->lista_asientos = $this->getAsientos();
         foreach($this->lista_asientos as $key => $this->campo){     
          $this->Row(array($this->campo['nu_cuenta_contable'],$this->campo['mo_haber'],number_format($this->campo['mo_debe'], 2, ',','.')),1,1);
          
         }
         $this->campo="";
         $this->SetY($fila);
         $this->lista_partidas = $this->getPartidas();
         foreach($this->lista_partidas as $key => $campo){  
          $this->SetX(110); 
          $this->SetWidths(array(50,50));
          $this->Row(array($campo['co_categoria'],number_format($campo['monto'], 2, ',','.')),1,1);
          
         }
         
         $this->SetY(220);
         $this->SetWidths(array(40,80,80));
         $this->Row(array('Banco:','Nro.Cuenta:', 'Monto en Bs. que cancela'),1,1);
         $this->SetWidths(array(40,160));
         $this->Row(array('Emitido por:','Observaciones:'),1,1);
         $this->SetAligns(array("L", "L","L"));
         $this->SetWidths(array(40,40,40,40,40));
         $this->Row(array('Revisado por:','Ordenado por:', 'Autorizado por:','Aprobado por:','Cheque entregado por:'),1,1);
         $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->Row(array(utf8_decode('RECIBIDO CONFORME BENEFICIARIO')),1,1);
	 $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L","L", "L","L"));
         $this->SetWidths(array(40,40,40,40,40));
  
         $this->ln();
         
         $this->Cell(0,0,utf8_decode('Usuario del sistema:'),0,0,'L');
         $this->ln();
	 $this->SetY($this->GetY()+5);
         $this->Cell(0,0,utf8_decode(''),0,0,'L');

        }
    } */
   
     function ChapterBody() {

         
         $this->datos = $this->getFacturas(); 
         
         $valor = $this->TotalMonto();

         //********cheque**************//
         if ($this->datos['co_forma_pago']==2) // Valida si el pago es por Cheque
         {    
         $this->AddPage(); 
         $this->SetX(30);
         $this->SetFillColor(255, 255, 255);
         
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(120, 50)); 
         $this->Row(array($this->datos['cuenta'],'Bs. '.number_format($valor['nu_monto'], 2, ',','.')),1,1); 
         $this->Ln(12);
         $this->SetX(30); //COLUMNA
         $this->SetFont('Arial','',6);
         $this->SetWidths(array(30, 140)); 
         $this->Row(array('PAGUESE A LA ORDEN DE:',$this->datos['nb_representante_legal']),1,1); 
         $this->Ln(4);
         $this->SetX(30); //COLUMNA
         $montoLetra = numtoletras($valor['nu_monto'],1);
         $this->Row(array('LA CANTIDAD DE: ',$montoLetra),1,1); 
         $this->Ln(6);
         $this->SetX(30); //COLUMNA
         $this->SetAligns(array("L","L","L","L"));
         $this->SetWidths(array(15, 70,10,40));
         $this->Row(array('FECHA ','XXX',' DE ','XXXX'),1,1);
         }
         
         //********fin de cheque**************/
         
         
         $campo='';            
         $this->AddPage(); 
         $this->SetX(40);
         $this->SetY(30);
         $this->SetFont('Arial','B',10);
         $this->Cell(0,0,utf8_decode('Rel: '.$this->datos['anio'].'-'.$this->datos['co_solicitud']),0,0,'C'); 
         $this->SetFont('Arial','B',12);       
         $this->SetX(145);
         $this->SetFillColor(255, 255, 255);
         if($this->datos['tx_serial']) $nu_pago = $this->datos['tx_serial']; else $nu_pago = '201804-00624';
         $this->MultiCell(175,20,'ORDEN DE PAGO '.$nu_pago,0,1,'J',0);
         $this->SetX(155); //COLUMNA
         $this->SetFont('Arial','',6);
         $this->MultiCell(175,3,utf8_decode('Fecha de Emisión:    ').date("d/m/Y", strtotime($this->datos['fe_pago'])),0,1,'R',0);
         $this->SetX(155); //COLUMNA
         $anio = date("Y");
         $this->MultiCell(175,3,utf8_decode('Fecha de Vencimiento: ').'31/12/'.($anio+1),0,1,'R',0); 
         $this->Ln(5);
         $this->SetX(155); //COLUMNA      
         $this->SetWidths(array(50));
         $this->SetAligns(array("C"));
         $this->Row(array(utf8_decode('FORMA DE PAGO')),1,1);
         $this->SetWidths(array(25,25));
         $this->SetAligns(array("L","L"));
         $this->SetX(155); //COLUMNA 
         $this->Row(array('TRANSFERENCIA: ','CHEQUE: X'),1,1);         
         $this->Ln(5);         
         $this->SetAligns(array("L"));
         $this->SetWidths(array(150));         
         $this->SetFont('Arial','B',8);
         $Y = $this->GetY();
         $this->SetX(10); //COLUMNA
         $this->Row(array('HE RECIBIDO DEL CUIDADANO TESORERO GENERAL DEL ESTADO LA CANTIDAD DE: '),0,0);           
         $this->SetY($Y - 2);
         $this->SetX(135);               
         $this->MultiCell(65,8,'',1,1,'R',1);
         $this->SetY($Y-2);  
         $this->SetX(140);
         $VALOR = '**********'.number_format($valor['nu_monto'].' Bs.', 2, ',','.');
         $this->MultiCell(50,8,$VALOR,0,0,'R',1);                          
         $this->Ln(2);
         $this->SetX(10); //COLUMNA
         $this->SetWidths(array(25, 175));
         $this->SetAligns(array("L","J"));
         $montoLetra = numtoletras($valor['nu_monto'],1);
         $this->Row(array('SON: ',$montoLetra),0,0);            
         $this->Ln(2);
         $this->Row(array('A  FAVOR DE: ',$this->datos['tx_rif'].' - '.$this->datos['tx_razon_social']),0,0);     
                                             
         $this->Ln(2);
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(60,140));
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);         
         $this->SetFont('Arial','B',8);
         $this->Row(array(utf8_decode('DOCUMENTOS Y RETENCIONES')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(40,160));         
         $this->SetFont('Arial','',6);
         $this->SetAligns(array("C","C","L","C","C","C","C"));
         $this->SetWidths(array(20,15,35,25,35,35,35));                 
         $this->SetFont('Arial','',6);          
         $this->Row(array('SOPORTE','FECHA', utf8_decode('DESCRIPCIÓN'),'MONTO','RETENCIONES','MONTO','CANCELADO'),1,1);
         $Y = $this->GetY();
         $this->MultiCell(200,55,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetAligns(array("C","C","L","R","L","R","R"));
         $this->Row(array($this->datos['nu_compra'], date("d/m/Y", strtotime($this->datos['fe_pago'])), $this->datos['tx_concepto'], number_format($this->datos['nu_base_imponible'], 2, ',','.'),utf8_decode('109- RETENCIÓN I.V.A'),number_format($this->datos['nu_iva_retencion'], 2, ',','.'),number_format($this->datos['total_pagar'], 2, ',','.')),0,0);
         
         $campo1='';
         $this->lista_retenciones = $this->getRetenciones($this->datos['co_factura']);
         $monto = 0;
         foreach($this->lista_retenciones as $key => $campo1){     
          $this->SetX(105);
          $this->SetWidths(array(35,35)); 
          $this->SetAligns(array("L","R"));
          $this->Row(array(utf8_decode($campo1['tx_tipo_retencion']),number_format($campo1['mo_retencion'], 2, ',','.')),0,0);
          $monto = $monto + $campo1['mo_retencion'];
         }        
         $y = $this->getY();
         $this->line(80, $y+1, 105, $y+1);
         $this->SetX(70);
         $this->SetAligns(array("R"));
         $Y = $this->GetY();
         $this->Row(array(number_format($this->datos['nu_base_imponible'], 2, ',','.')),0,0);
         
         $this->line(145, $y+1, 175, $y+1);         
         $this->SetAligns(array("R"));          
         $this->SetY($Y);
         $this->SetX(140);
         $this->Row(array($monto),0,0);
         
         $this->line(180, $y+1, 210, $y+1);        ;
         $this->SetY($Y);
         $this->SetAligns(array("R"));
         $this->SetX(175);
         $this->Row(array(number_format($this->datos['total_pagar'], 2, ',','.')),0,0);         
         
         $this->SetY(160);
         $this->SetWidths(array(75,125));
         $this->SetAligns(array("C","C"));
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Arial','B',7); 
         $this->Row(array('CODIGOS CONTABLES','CATEGORIAS PRESUPUESTARIAS'),1,1);
         $this->SetFillColor(255, 255, 255); 
         $this->SetFont('Arial','B',6); 
         $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C"));
         $this->SetWidths(array(25,25,25,10,10,10,10,10,10,10,10,10,35));
         $this->Row(array('CUENTA','DEBITOS','CREDITOS',utf8_decode('AÑO'),'UE','AE','P','G','E','SE','SSE','F','MONTO'),1,1);
         $fila = $this->getY();
         $Y = $this->GetY();
         $this->MultiCell(200,45,'',1,1,'L',1);
         $this->SetY($Y);
         $this->lista_asientos = $this->getAsientos();
         foreach($this->lista_asientos as $key => $this->campo){     
          $this->Row(array($this->campo['tx_cuenta'],number_format($this->campo['mo_haber'], 2, ',','.'),number_format($this->campo['mo_debe'], 2, ',','.')),1,1);
          
         }
         $this->campo="";
         $this->SetY($fila);
         $this->lista_partidas = $this->getPartidas();
         foreach($this->lista_partidas as $key => $campo){  
          $this->SetX(85); 
          $this->SetAligns(array("C","C","C","C","C","C","C","C","C","R"));
          $this->SetWidths(array(10,10,10,10,10,10,10,10,10,35));
          $this->Row(array($campo['anio'],$campo['ue'],$campo['ae'],$campo['p'],$campo['g'],$campo['e'],$campo['se'],$campo['sse'],$campo['f'],number_format($campo['monto'], 2, ',','.')),1,1);
          
         }
         
         $this->SetY(220);
         $this->SetAligns(array("L","L","L"));
         $this->SetWidths(array(40,80,80));
         $this->Row(array('Banco:','Nro.Cuenta:', 'Monto en Bs. que cancela: '.$valor['nu_monto']),1,1);
         $this->SetAligns(array("C","C","C","C","C","C","C","C","C","R"));
         $this->SetWidths(array(40,160));
         $this->Row(array('Emitido por:','Observaciones:'),1,1);
         $this->SetAligns(array("L", "L","L"));
         $this->SetWidths(array(40,40,40,40,40));
         $this->Row(array('Revisado por: Presupuesto','Ordenado por: Secret. de Admin y Finanzas', 'Autorizado por: Gobernador','Aprobado por:','Cheque entregado por:'),1,1);
         $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->Row(array(utf8_decode('RECIBIDO CONFORME BENEFICIARIO')),1,1);
	 $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L","L", "L","L"));
         $this->SetWidths(array(40,40,40,40,40));
         $this->Row(array('Nombre: ','CI', 'Firma:','Fecha:','Sello'),1,1);


        //} 

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

    
    function TotalMonto(){

    $conex = new ConexionComun();     
    $sql = "select sum(tb062.mo_pagar) as nu_monto
                  from   tb026_solicitud as tb026
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud                                                   
                  left join tb045_factura as tb045 on tb045.co_compra = tb052.co_compras 
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor 
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb026.co_usuario
                  left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente
                  left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud
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
                         tb008.nb_representante_legal,
                         tb008.nu_cedula_representante,
                         tb047.tx_ente,  
                         tb001.nb_usuario,
                         tb062.mo_pagar as nu_monto,
                         tb052.anio,
                         tb052.co_solicitud
                  from   tb026_solicitud as tb026
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud                                                   
                  left join tb045_factura as tb045 on tb045.co_compra = tb052.co_compras 
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor 
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb026.co_usuario
                  left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente
                  left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud 
                  where tb030.co_ruta =".$_GET['codigo'];
               
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];   
    }
    function getRetenciones($fact){

	  $conex = new ConexionComun();
          $sql = "select  nu_factura, 
                          fe_emision, 
                          nu_base_imponible,                           
                          nu_iva_factura, 
                          nu_total,                           
                          nu_iva_retencion, 
                          tx_concepto,                           
                          nu_total_retencion, 
                          total_pagar,
                          po_retencion,
                          mo_retencion,
                          tx_tipo_retencion
                  from   tb045_factura as tb045     
                  left join tb046_factura_retencion as tb046 on tb046.co_factura = tb045.co_factura
                  left join tb041_tipo_retencion as tb041 on tb041.co_tipo_retencion = tb046.co_tipo_retencion
                  where tb045.co_factura = ".$fact; 
                       
           
          return $conex->ObtenerFilasBySqlSelect($sql);
  
    }
    
    function getPartidas()
    {
                    
          $conex = new ConexionComun(); 
                    
          $sql = "select distinct t.co_categoria,
                         anio,
                         nu_ejecutor as ue,
                         nu_proyecto_ac as pac,
                         nu_accion_especifica as ae,
                         nu_pa as p,                         
                         nu_ge as g,
                         nu_es as e,
                         nu_se as se,
                         nu_sse as sse,
                         nu_fi as f,
                         case when (tb053.in_calcular_iva) then tb045.nu_base_imponible else tb045.nu_iva_factura end as monto                       
                  from   tb026_solicitud as tb026
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud  
                  left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras  
                  left join tb045_factura as tb045 on tb052.co_compras = tb045.co_compra
                  left join tb085_presupuesto as t on t.id = tb053.co_presupuesto
                  left join tb084_accion_especifica as tb084 on tb084.id  = t.id_tb084_accion_especifica
                  left join tb083_proyecto_ac as tb083 on tb083.id = tb084.id_tb083_proyecto_ac
                  left join  tb082_ejecutor as tb082 on tb082.id  = tb083.id_tb082_ejecutor
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud 
                  where tb030.co_ruta =".$_GET['codigo'];
                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }
    
    function getAsientos()
    {
                    
          $conex = new ConexionComun(); 
                    
          $sql = "select tb024.tx_cuenta||'.'||tb008.co_proveedor as tx_cuenta, 
                         tb061.mo_haber,
                         tb061.mo_debe
                  from   tb026_solicitud as tb026  
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud 
                  left join tb008_proveedor as tb008 on tb008.co_proveedor = tb052.co_proveedor  
                  left join tb061_asiento_contable as tb061 on tb026.co_solicitud = tb061.co_solicitud             
                  left join tb024_cuenta_contable as tb024 on tb024.co_cuenta_contable = tb061.co_cuenta_contable
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb026.co_solicitud and tb061.co_tipo_asiento=1 
                  where tb030.co_ruta =".$_GET['codigo'];
                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }


}
/*
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

$pdf->Output($dir, 'F');
*/

$pdf=new PDF('P','mm','letter');
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>