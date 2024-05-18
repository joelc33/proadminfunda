<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $array_factura;
    public $array_factura_banco;
    
   
    function Header() {


        $this->Image("imagenes/escudosanfco.png", 100, 7,20);

        $this->SetFont('Arial','B',8);

        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('<NOMBRE DE LA INSTITUCION>'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACION Y FINANZAS'),0,0,'C');
        $this->Ln(12);
        $this->SetFont('Arial','B',14);       
        $this->Cell(0,0,utf8_decode('PUNTO DE CUENTA'),0,0,'C');
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

         $this->datos = $this->getOrdenes();         
         $this->SetFont('Arial','B',10);
         $this->Cell(0,0,utf8_decode('ORDEN DE COMPRA - '.$this->datos['tx_tipo_solicitud']),0,0,'C');
        
         $this->Ln(1);
         $this->line(1, 60, 220, 60);
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);         
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetY(65);
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DATOS DE LA ORDEN -NRO. DOCUMENTO: '.$this->datos['numero_compra'])),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(40,40,40,40,40)); 
         $this->SetAligns(array("L","L","L","L","L"));
         $this->SetFont('Arial','B',7);
         $this->Row(array('No. Orden: '.$this->datos['numero_compra'],'Estatus: '.$this->datos['de_tipo_movimiento'], utf8_decode('Fecha Emisión: ').$this->datos['fecha_compra'],utf8_decode('No. Requisión: ').$this->datos['nu_requisicion'],'Fecha Req.: '.$this->datos['created_at']),1,1);         
         $this->SetWidths(array(200));
         $this->Row(array('Unidad Solicitante: '.utf8_decode($this->datos['tx_ente'])),1,1);
         $this->SetWidths(array(90,50,60));         
         $this->Row(array('Proveedor o Suplidor: '.utf8_decode($this->datos['tx_razon_social']), 'Nro. R.I.F: '.$this->datos['tx_rif'], utf8_decode('Correo electrónico: '.$this->datos['tx_email'])),1,1);         
         $this->SetWidths(array(200));
         $this->Row(array(utf8_decode('Dirección: ').$this->datos['tx_direccion']),1,1);
         $this->Row(array('Concepto: '.$this->datos['tx_observacion']),1,1);
         $this->SetFont('Arial','B',7);
         
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->Ln();
         $this->Row(array(utf8_decode('DETALLES DE MATERIALES')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(40,160));
         $this->SetAligns(array("C","C","C","C","C","C","C"));
         $this->SetWidths(array(65,15,20,25,25,25,25));
         $this->Row(array(utf8_decode('Descripción del Item'),utf8_decode('Cantidad'),utf8_decode('Unidad'), utf8_decode('Precio Unitario'), utf8_decode('SubTotal'), utf8_decode('IVA'), utf8_decode('Total')),1,1);
         $this->SetAligns(array("C","C","C","C","C","C","C"));         
         $this->SetWidths(array(65,15,20,25,25,25,25));
         
         $SubTotal=0;
         $TotalIVA=0;
         $TotalExcento=0;
         $TotalGenerado=0;
         $monto_prod=0;
         $iva=0;
         
         $this->lista_materiales = $this->getMateriales();
       
         foreach($this->lista_materiales as $key => $campo){           
         $this->SetFont('Arial','',5);
         $this->SetAligns(array("L","C","C","C","C","C","C"));
         $monto_prod =  ($campo['nu_cantidad']*$campo['precio_unitario']);
         $iva = ($monto_prod*$campo['nu_iva'])/100;
                 
         $this->Row(array(utf8_decode($campo['tx_producto']),utf8_decode($campo['nu_cantidad']),utf8_decode($campo['de_unidad_medida']),number_format($campo['precio_unitario'], 2, ',','.'),number_format($monto_prod, 2, ',','.'),number_format($iva, 2, ',','.'),number_format($monto_prod + $iva, 2, ',','.')),1,1);
         $SubTotal =     $SubTotal + $monto_prod;
         $TotalIVA =     $TotalIVA + $iva;
         $TotalExcento=  0;
         
          
        }
         $TotalGenerado= $SubTotal + $TotalIVA;
         
         $this->SetFont('Arial','B',7);        
         $this->Ln();
         $this->SetAligns(array("R","R"));
         $this->SetWidths(array(170,30));         
               
         
         $this->Row(array(utf8_decode('Sub-Total:'),number_format($SubTotal, 2, ',','.')),1,1);
         $this->SetWidths(array(170,30));
         $this->Row(array(utf8_decode('Total I.V.A'),number_format($TotalIVA, 2, ',','.')),1,1);
         $this->SetWidths(array(170,30));
         $this->Row(array(utf8_decode('Total Excento'),number_format($TotalExcento, 2, ',','.')),1,1);
         $this->Row(array(utf8_decode('Total Generado'),number_format($TotalGenerado, 2, ',','.')),1,1);
         

         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->Ln();
         $this->Row(array(utf8_decode('PARTIDAS PRESUPUESTARIAS')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetAligns(array("C","C","C"));
         $this->SetWidths(array(50,100,50));
         
                 
         $this->Row(array(utf8_decode('PARTIDA'),utf8_decode('DESCRIPCIÓN'),utf8_decode('MONTO')),1,1);
         $this->SetAligns(array("L","L","L"));
         $this->SetWidths(array(50,100,50));
         
          $this->lista_partidas = $this->getPartidas();
          foreach($this->lista_partidas as $key => $campo){           
          
          $this->SetAligns(array("L","C","R"));
          $this->Row(array(utf8_decode($campo['co_categoria']),utf8_decode($campo['de_partida']),number_format($campo['monto'], 2, ',','.')),1,1);          
        }
          
         

         $this->ln();
         $this->SetAligns(array("C","C", "C"));
	 $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(100,100));
         $this->Row(array(utf8_decode('DIRECCION DE COMPRAS Y SUMINISTROS'),utf8_decode('SECRETARIA DE ADMINISTRACION Y FINANZAS')),1,1);
         $this->SetWidths(array(50,50,50,50));
         $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L","L", "L","L"));
         $this->Row(array(utf8_decode('Elaborado por:'),utf8_decode('Conformado por:'), utf8_decode('Conformado por:'),utf8_decode('Secretaria de Adm.:')),1,1);
         $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->Row(array(utf8_decode('REPRESENTANTE LEGAL DEL BENEFICIARIO')),1,1);
	 $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L","L", "L","L"));
         $this->SetWidths(array(50,50,50,50));
         $this->Row(array(utf8_decode('Nombre:'),utf8_decode('CI:'), utf8_decode('Firma:'),utf8_decode('Sello:')),1,1);

         $this->ln();
         
         $this->Cell(0,0,utf8_decode('Elaborado por:'),0,0,'L');
         $this->ln();
	 $this->SetY($this->GetY()+5);
         $this->Cell(0,0,utf8_decode(''),0,0,'L');      

    }
    
    
        function Contenido() {

         $this->Ln(1);
         $this->SetFont('Arial','B',10);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetY(65);
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DATOS DEL PUNTO DE CUENTA')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(100,100)); 
         $this->SetAligns(array("L","L"));
         
         $this->punto = $this->getExpendiente();       
         $this->Row(array('PUNTO DE CUENTA:  ','FECHA: '.date("d/m/Y", strtotime($this->punto['fecha_inicio']))),1,1);   
         $this->MultiCell(200,10,utf8_decode('ASUNTO: RESULTADO FINAL DE '.$this->punto['tx_tp_contrato'].' '.$this->punto['nu_expediente']),1,1,'L',1);
         $this->MultiCell(200,10,utf8_decode('RECOMENDACIÓN: OTORGAR LA ADJUDICACIÓN A LA PARTICIPANTE '.$this->punto['tx_razon_social']),1,1,'L',1);
         //$this->Row(array(utf8_decode('ASUNTO: RESULTADO FINAL DE '.$this->punto['tx_tp_contrato'].' '.$this->punto['nu_expediente'])),1,1);         
         //$this->Row(array(utf8_decode('RECOMENDACIÓN: OTORGAR LA ADJUDICACIÓN A LA PARTICIPANTE '.$this->punto['tx_razon_social'])),1,1);         
         
         $Y = $this->GetY();
         $this->MultiCell(200,70,'',1,1,'L',1);
         $this->SetY($Y);
         
         $inf = "Cumplidas las formalidades de Ley para el desarrollo del procedimiento administrativo de selección"
                 ." de contratista, signado con las siglas N° ".$this->punto['nu_expediente'].", "
                 ." y visto el resultado de la evaluación efectuada por la Comisión Interna de Contrataciones Públicas, de conformidad con "
                 ." la cual resultó valida la oferta de la empresa ".utf8_decode($this->punto['tx_razon_social'])
                 ." alcanzando un puntaje final de Cien (100) puntos, según se evidenció del análisis legal, técnico, económico y financiero contenido en el informe "
                 ." de Recomendación, asignado con el Nro. ".$this->punto['nu_expediente'].' de fecha '.date("d/m/Y", strtotime($this->punto['fecha_inicio'])).', conjuntamente con el '
                 ." Presupuesto Base emanado del contrantante por la cantidad de ".numtoletras($this->punto['monto_total'],1)." (".number_format($this->punto['monto_total'], 2, ',','.')    
                 .", el cual incluye el IVA del ".$this->punto['nu_iva']."%) y fecha estimada de entreda ".$this->punto['fecha_entrega']
                 .", por haber cumplido con todos los requerimientos exigidos en el pliego de condiciones para la contratación.";
                 
         $this->SetFont('Arial','',10); 
         $this->Ln(5);
         $this->MultiCell(200,5,utf8_decode($inf),0,'J');
         $this->Ln(5);
         
         $inf = "Esta comisión interna de contrataciones recomienda otorgar l adjudicación a la empresa y por el monto total"
                 . " y con un tiempo de entrega no mayor de cinco (05) días hábiles por haber cumplido con todos los Aspectos generales de la contratación.";
                
                 
         $this->SetFont('Arial','',10); 
         $this->MultiCell(200,5,utf8_decode($inf),0,'J');
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Arial','B',10); 
         $this->Ln(5);
         $this->Row(array(utf8_decode('POR LA COMISIÓN INTERNA DE CONTRATACIÓN')),1,1); 
         $this->SetFillColor(255,255,255);
         $Y = $this->GetY();
         $this->MultiCell(50,15,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(60);
         $this->MultiCell(50,15,'',1,1,'L',1);  
         $this->SetY($Y);
         $this->SetX(110);
         $this->MultiCell(50,15,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(160);
         $this->MultiCell(50,15,'',1,1,'L',1);
         $this->SetWidths(array(50,50,50,50));
         $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L","L", "L","L"));         
         $this->SetY($Y+15);
         $this->SetWidths(array(50,50,50,50));
         $this->SetAligns(array("L","L", "L","L"));
         $this->SetFont('Arial','',6); 
         $this->Row(array(utf8_decode('Area Júridica'),utf8_decode('Area Financiera'),utf8_decode('Area Técnica'),utf8_decode('Secretaria')),1,1);
          
         $this->SetFont('Arial','B',8); 
         $this->SetAligns(array("C","C", "C"));
	 $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(150,50));         
         $this->Row(array(utf8_decode('DESICIÓN:'),utf8_decode('FECHA/FIRMA:')),1,1);
         $this->SetFont('Arial','',6); 
         $this->SetWidths(array(25,25,25,25,25,25,25,25));
         $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L","L", "L","L","L","L", "L","L"));
         $this->Row(array(utf8_decode('Aprobado:'),utf8_decode('Informado:'),utf8_decode('Negado:'),utf8_decode('Diferido:'),utf8_decode('Visto:'),utf8_decode('Otro:_______'), utf8_decode(''),utf8_decode('')),1,1);
         
         $this->ln();
         
         $this->Cell(0,0,utf8_decode('Elaborado por:'),0,0,'L');
         $this->ln();
	 $this->SetY($this->GetY()+5);
         $this->Cell(0,0,utf8_decode(''),0,0,'L');

         

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
    
    function PuntoCuenta() {
        $this->AddPage();
        $this->Contenido();
    }
    function PrintChapter() {
        $this->AddPage();        
        $this->ChapterBody();
    }

    function getOrdenes(){

          $conex = new ConexionComun(); 
          
          $sql = "select tb039.nu_requisicion,                         
                         tb039.created_at, 
                         upper(tb027.tx_tipo_solicitud) as tx_tipo_solicitud,
                         tb052.numero_compra,
                         tb052.fecha_compra,
                         tb039.co_solicitud,
                         tb052.tx_observacion,
                         UPPER(tb008.tx_razon_social) AS tx_razon_social,
                         tb008.tx_rif,
                         tb008.tx_direccion,                         
                         tb008.nb_representante_legal,
                         tb008.nu_cedula_representante,
                         tb008.tx_email,
                         tb047.tx_ente,
                         de_tipo_movimiento
                  from   tb026_solicitud as tb026
                  left join tb039_requisiciones as tb039 on tb039.co_solicitud = tb026.co_solicitud
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud        
                  left join tb027_tipo_solicitud as tb027 on tb027.co_tipo_solicitud=tb052.co_tipo_solicitud
                  left join tb088_tipo_movimiento as tb088 on tb088.id = tb052.co_tipo_movimiento
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb052.co_proveedor
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb039.co_usuario
                  left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb039.co_solicitud
                  where tb030.co_ruta = ".$_GET['codigo']; //$conex->decrypt($_GET['codigo']);
                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];                    
         
    }

    function getMateriales(){

	  $conex = new ConexionComun();
          $sql = "SELECT distinct tb048.tx_producto,
                         tb051.nu_cantidad,
                         tb052.nu_iva,
                         tb048.cod_producto,
                         tb053.precio_unitario,
                         tb089.de_unidad_medida
                  FROM tb051_detalle_requision_producto as tb051
                  left join tb048_producto as tb048 on tb051.co_producto = tb048.co_producto                  
                  left join tb089_unidad_medida as tb089 on tb089.id = tb048.co_unidad_producto
                  left join tb052_compras as tb052 on tb052.co_requisicion=tb051.co_requisicion       
                  left join tb053_detalle_compras as tb053 on tb053.co_compras = tb052.co_compras and tb051.co_producto = tb053.co_producto
                  left join tb039_requisiciones as tb039 on tb039.co_requisicion = tb051.co_requisicion
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb039.co_solicitud
                  where tb030.co_ruta = ".$_GET['codigo']; //$conex->decrypt($_GET['codigo']);   
          
         
   
          return $conex->ObtenerFilasBySqlSelect($sql);

    }

    function getPartidas()
    {
        $conex = new ConexionComun();
        $sql ="   select t.co_categoria,
                         t.de_partida,
                         tb053.monto
                  from   tb052_compras as tb052 
                  left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras 
                  left join tb085_presupuesto as t on t.id = tb053.co_partida
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud and tb030.in_cargar_dato is true                               
                  where tb030.co_ruta = ".$_GET['codigo']; //$conex->decrypt($_GET['codigo']);

        return $conex->ObtenerFilasBySqlSelect($sql);
		  
    }
    
    function getExpendiente(){

          $conex = new ConexionComun(); 
          
          $sql = "select UPPER(tx_tp_contrato) AS tx_tp_contrato,
                         nu_expediente,
                         monto_total,
                         nu_iva,
                         fecha_inicio,
                         fecha_entrega,
                         tx_fuente_financiamiento,
                         UPPER(tx_razon_social) AS tx_razon_social
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


$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();
$pdf->PuntoCuenta();
//$pdf->PrintChapter();

$comm = new ConexionComun();
$ruta = $comm->getRuta();

//rmdir($ruta);
//mkdir($ruta, 0777, true);    

$dir="$ruta".$_GET["codigo"].".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";


$update = "update tb030_ruta set tx_ruta_reporte = '".$dir."' where co_ruta = ".$_GET['codigo']; //$comm->decrypt($_GET["codigo"]);

//echo $update; exit();
$comm->Execute($update);    

$pdf->Output($dir, 'F');
/*
$pdf=new PDF('P','mm','letter');
$pdf->PuntoCuenta();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();
*/
?>
