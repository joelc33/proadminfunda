edec vgt4<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $array_factura;
    public $array_factura_banco;
    
   
    function Header() {


     

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

         $this->datos = $this->getOrdenes();         

         $this->SetY(15);
         $this->SetWidths(array(160,40)); 
         $this->SetAligns(array("C","L"));
         $this->SetFont('arial','',8);
         $this->Row(array('',date("d/m/Y", strtotime($this->datos['fecha_compra']))),0,0); 
         $this->Ln(13);
         $Y = $this->GetY();
         $X = $this->GetX();
         $this->MultiCell(80,5,utf8_decode($this->datos['tx_razon_social']).' '.utf8_decode($this->datos['tx_direccion']),0,1,'L',0);
         $this->SetY($Y);
         $this->SetX($X+120);
         $this->MultiCell(80,5,utf8_decode($this->datos['tx_observacion']. ' '.$this->datos['tx_ente']),0,1,'L',0);
       
         $this->SetY(57);
         $this->SetWidths(array(60,30,40,80)); 
         $this->SetAligns(array("C","R","R","C"));
         $this->SetFont('arial','',8);
         $this->Row(array('',$this->datos['nu_codigo'],'',''),0,0);  

         $this->Ln(4);
         $this->SetFont('arial','B',8);
         $this->SetWidths(array(50,150));
         $this->SetAligns(array("L","L"));
         $this->Row(array('',$this->datos['de_ejecutor']),0,0);
         $this->SetFont('arial','B',8);
         
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->Row(array(utf8_decode('')),0,0);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(25,100,40,30));
         $this->SetAligns(array("C","C","C","C"));
         $this->Row(array(utf8_decode(''),utf8_decode(''), utf8_decode(''), utf8_decode('')),0,0);
         $this->SetFont('arial','',8);
         $this->SetAligns(array("C","L","R","R"));
         
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
                 
         $this->Row(array(utf8_decode($campo['nu_cantidad']),utf8_decode($campo['tx_producto']),number_format($campo['precio_unitario'], 2, ',','.'),number_format($monto_prod, 2, ',','.')),0,0);
         $SubTotal =     $SubTotal + $monto_prod;
         $TotalIVA =     $TotalIVA + $iva;
         $TotalExcento=  0;
          
        }
         
         $this->SetWidths(array(25,60,45,40,30));
         $this->SetAligns(array("C","L","R","L","L"));
         $this->Ln();  
         $this->Row(array('',utf8_decode('CATEGORIAS PRESUPUESTARIAS'),''),0,0);
         $this->lista_partidas = $this->getPartidas();
          foreach($this->lista_partidas as $key => $campo){     
          $this->Row(array('',utf8_decode($campo['co_categoria']),number_format($campo['monto'], 2, ',','.'),'',''),0,0);          
        }
        
         $TotalGenerado= $SubTotal + $TotalIVA;
         
         $this->SetFont('arial','B',9); 
         $this->SetAligns(array("R","R"));
         $this->SetWidths(array(160,40));         
               
         $Y = $this->GetY();
         $this->MultiCell(200,15,'',0,0,'L',0);
         $this->SetY(195);
         $this->Row(array('',number_format($SubTotal, 2, ',','.')),0,0);
         $this->Row(array('',number_format($TotalIVA, 2, ',','.')),0,0);
         $this->Row(array('',number_format($TotalGenerado, 2, ',','.')),0,0);
         $this->SetY($Y+10);
         
        
         
         $this->MultiCell(200,30,'',0,0,'L',0);
         $this->SetWidths(array(200));
         $this->SetAligns(array("L"));
         $this->SetY(215);
         $this->SetX(45);
         $this->SetFont('arial','',7); 
         $this->Row(array(utf8_decode('INMEDIATA')),0,0);
         $this->SetX(50);
         $this->Row(array(utf8_decode('')),0,0);
         $this->SetX(50);
         $this->Row(array(utf8_decode($campo['tiempo_garantia'])),0,0);         
         $this->Ln(2); 
         $this->SetX(30);
         $this->Row(array(utf8_decode($campo['tx_observacion'])),0,0);
         $this->SetY($Y+20);
         
 

    }
    
    
        function Contenido() {

        $this->Image("imagenes/escudosanfco.png", 100, 7,20);

        $this->SetFont('Arial','B',8);

        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACIÓN Y FINANZAS'),0,0,'C');
        $this->Ln(12);
        $this->SetFont('Arial','B',14);
        
         $this->Ln(1);

         $this->line(1, 60, 220, 60);
         $this->SetFont('Arial','B',9);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(60,140));
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetY(65);
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('PUNTO DE CUENTA')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(40,100,30,30));         
         $this->SetFont('courier','B',9);
         $this->SetAligns(array("L","L","L","L"));
         
         $this->punto = $this->getExpendiente();       
         
         $this->Row(array(utf8_decode('ASUNTO:'),'RESULTADO FINAL DE '.$this->punto['tx_tp_contrato'].' '.$this->punto['nu_expediente'],utf8_decode('Pto. Cuenta'),utf8_decode('')),1,1);         
         $this->SetWidths(array(40,100,30,30)); 
         $this->SetAligns(array("L","L","L","L"));
         $this->Row(array(utf8_decode('RECOMENDACIÓN:'),utf8_decode('OTORGAR LA ADJUDICACIÓN A LA PARTICIPANTE '.$this->punto['tx_razon_social']),'FECHA: ',$this->punto['fecha_inicio']),1,1);         
         
         $inf = "Cumplidas las formalidades de Ley para el desarrollo del procedimiento administrativo de selección"
                 ." de contratista, signado con las siglas N° ".$this->punto['nu_expediente'].", "
                 ." y visto el resultado de la evaluación efectuada por la Comisión Interna de Contrataciones Públicas, de conformidad con "
                 ." la cual resultó valida la oferta de la empresa ".utf8_decode($this->punto['tx_razon_social'])
                 ." alcanzando un puntaje final de Cien (100) puntos, según se evidenció del análisis legal, técnico, económico y financiero contenido en el informe "
                 ." de Recomendación, asignado con el Nro. ".$this->punto['nu_expediente'].' de fecha '.$this->punto['fecha_inicio'].", conjuntamente con el "
                 ." Presupuesto Base emanado del contrantante por la cantidad de ".numtoletras($this->punto['monto_total'],1)." (".number_format($this->punto['monto_total'], 2, ',','.')    
                 .", el cual incluye el IVA del ".$this->punto['nu_iva']."%) y fecha estimada de entreda ".$this->punto['fecha_entrega']
                 .", por haber cumplido con todos los requerimientos exigidos en el pliego de condiciones para la contratación.";
                 
         $this->SetFont('Arial','',10); 
         $this->MultiCell(200,8,utf8_decode($inf),1,'J');
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Arial','B',8); 
         $this->Row(array(utf8_decode('Por la Comisión Interna de Contratación')),1,1); 
         $this->SetFillColor(255,255,255);
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
                         tb008.nu_codigo,
                         de_tipo_movimiento,
                         tb082.de_ejecutor
                  from   tb026_solicitud as tb026
                  left join tb039_requisiciones as tb039 on tb039.co_solicitud = tb026.co_solicitud
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud      
                  left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras 
                  left join tb085_presupuesto as tb085 on tb085.id = tb053.co_presupuesto
                  left join tb084_accion_especifica as tb084 on tb085.id_tb084_accion_especifica = tb084.id
                  left join tb083_proyecto_ac as tb083 on tb084.id_tb083_proyecto_ac = tb083.id
                  left join tb082_ejecutor as tb082 on tb082.id = tb083.id_tb082_ejecutor
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
        $sql ="   select distinct tb083.id_tb013_anio_fiscal||'-'||tb082.nu_ejecutor||'-'||tb085.co_categoria as co_categoria,
                         tb085.de_partida,
                         case when (tb053.in_calcular_iva) then tb053.monto else tb052.monto_iva end as monto,
                         tb053.co_detalle_compras,
                        upper(tb052.tx_observacion) as tx_observacion
                  from  tb052_compras as tb052 
                  left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras 
                  left join tb085_presupuesto as tb085 on tb085.id = tb053.co_presupuesto
                  left join tb084_accion_especifica as tb084 on tb085.id_tb084_accion_especifica = tb084.id
                  left join tb083_proyecto_ac as tb083 on tb084.id_tb083_proyecto_ac = tb083.id
                  left join tb082_ejecutor as tb082 on tb082.id = tb083.id_tb082_ejecutor
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud and tb030.in_cargar_dato is true                               
                  where tb030.co_ruta = ".$_GET['codigo'].' order by tb053.co_detalle_compras asc'; //$conex->decrypt($_GET['codigo']);
        

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
                         tiempo_garantia,
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
//$pdf->PuntoCuenta();
//$pdf->PrintChapter();
//$pdf->SetDisplayMode('default');
//$pdf->Output();

?>
