<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    
   
    function Header() {

        $this->empresa = $this->getDatosEmpresa(1);

        //$this->Image("imagenes/escudosanfco.png", 100, 7,20);

        /*if(!empty($this->empresa['tx_imagen_izq'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_izq'], $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
        }*/
        
        if(!empty($this->empresa['tx_imagen_cen'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_cen'],  $this->empresa['centro_x'], $this->empresa['centro_y'], $this->empresa['centro_w']);
        }

        /*if(!empty($this->empresa['tx_imagen_der'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_der'],  $this->empresa['derecha_x'], $this->empresa['derecha_y'], $this->empresa['derecha_w']);
        }*/

        $this->SetFont('Arial','B',8);

        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
//        $this->Ln(4);
//        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode($this->empresa['nb_empresa']),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('RIF. '.$this->empresa['tx_rif']),0,0,'C');
        //$this->Ln(4);
        //$this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACION Y FINANZAS'),0,0,'C');
        //$this->Cell(0,0,utf8_decode($this->empresa['nb_empresa']),0,0,'C');
        $this->Ln(12);
        $this->SetFont('Arial','B',14);
        $this->Cell(0,0,utf8_decode('PRESUPUESTO BASE '),0,0,'C');
     
    //    $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        
        $this->Ln(5);
        $this->SetTextColor(0,0,0);
        $this->SetX(1);

        $this->Ln(2);
       

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

         $this->op_reporte = $this->getOpcionReporte($_GET['codigo']);
        
         $this->Ln(1);

         $this->datos = $this->getOrdenes();

         //$this->line(1, 60, 220, 60);
         $this->SetFont('Arial','B',10);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(60,140));
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetY(60);
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DATOS DEL PRESUPUESTO BASE')),1,1);
         $this->SetFillColor(255, 255, 255);         
         $this->SetWidths(array(100,100)); 
         $Y = $this->GetY();
         $this->MultiCell(100,10,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(110);
         $this->MultiCell(100,10,'',1,1,'L',1);
         $this->SetY(68);
         $this->SetAligns(array("L","L"));
         $this->SetFont('Arial','',9);
         $this->Row(array(utf8_decode('CODIGO: ').utf8_decode($this->datos['nu_orden_compra']), utf8_decode('  FECHA:  ').date("d/m/Y", strtotime($this->datos['fe_registro']))),0,0);
         //$this->Row(array('', utf8_decode('  FECHA:  ').date("d/m/Y", strtotime($this->datos['fe_registro']))),0,0);
         $this->SetWidths(array(200));
         $this->Ln(2);
         $Y = $this->GetY()+3;
         $this->MultiCell(200,13,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetAligns(array("J"));
         $this->Row(array(utf8_decode('CONCEPTO: ').utf8_decode($this->datos['tx_concepto'])),0,0);
         $this->SetFont('Arial','B',9); 
         
         $concepto = $this->datos['tx_concepto'];
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('ESPECIFICACIONES TÉCNICAS')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(40,160));
         $this->SetAligns(array("C","C","C","C","C","C"));
         $this->SetWidths(array(10,70,20,30,30,40));
         $this->Row(array('ITEM',utf8_decode('DESCRIPCIÓN'),utf8_decode('CANT.'),utf8_decode('UNIDAD DE MEDIDA'), utf8_decode('PRECIO UNITARIO'), utf8_decode('IMPORTE TOTAL')),1,1);
         $this->SetAligns(array("C","L","C","C","R","R"));
         $this->SetWidths(array(10,70,20,30,30,40));
         
         $item=0;
         $SubTotal=0;
         $TotalIVA=0;
         $TotalExcento=0;
         $TotalGenerado=0;
         $monto_prod=0;
         $iva=0;
         $i = 0;
         
         $this->lista_materiales = $this->getMateriales();
       
         foreach($this->lista_materiales as $key => $campo){           
         $this->SetFont('Arial','',9);         
         //$iva = round(($campo['monto']*$campo['nu_iva'])/100, 2);
         $iva = $campo['monto_iva'];
         $item=$item+1;
         $i++;
         $this->Row(array($item, utf8_decode($campo['tx_producto'].' - '.$campo['detalle']),utf8_decode($campo['nu_cantidad']),utf8_decode($campo['tx_unidad_producto']),number_format($campo['precio_unitario'], 2, ',','.'),number_format($campo['monto'], 2, ',','.')),1,1);
         //$SubTotal =     $SubTotal + round($campo['monto'],2);
         $SubTotal =     $SubTotal + $campo['monto'];
         $TotalIVA =     $TotalIVA + $iva;
         $TotalExcento=  0;
        }
        while ($i<11) 
         {
          $this->Row(array('','','','','',''),1,1);  
          $i++;
         }
         //$total_iva = round(($SubTotal * $iva)/100,2);
         //$total_iva = $TotalIVA;
         $total_iva = $this->datos['monto_iva'];
         
         $TotalGenerado= $SubTotal + $total_iva;
         
         $this->SetFont('Arial','B',9); 
         $this->SetAligns(array("R", "R"));
         $this->SetWidths(array(150,50));     
         $this->Row(array(utf8_decode('Sub-Total:'),number_format($SubTotal, 2, ',','.')),1,1);
         $this->Row(array(utf8_decode('Total I.V.A '.$this->datos['nu_iva'].' %'),number_format($total_iva, 2, ',','.')),1,1);
         $this->Row(array(utf8_decode('Total Excento'),number_format($TotalExcento, 2, ',','.')),1,1);
         $this->Row(array(utf8_decode('Total Generado'),number_format($TotalGenerado, 2, ',','.')),1,1);
         
        $this->SetY(230);
        $this->SetX(72);
        $this->SetFont('Arial','',9);
        $this->MultiCell(72,0,'',1,1,'L',1);
        $this->SetY(230);
        $this->SetX(72);
        //$this->MultiCell(72,5,utf8_decode("Lcdo. Aroldo Diaz"),0,'C');
        $this->SetY(235);
        $this->SetX(72);
        $this->MultiCell(72,5,utf8_decode("COORDINACIÓN DE COMPRAS"),0,'C');

//        $this->SetY(230);
//        $this->SetX(72);
//        $this->SetFont('Arial','',9);
//        $this->MultiCell(72,0,'',1,1,'L',1);
//        $this->SetY(230);
//        $this->SetX(72);
//        $this->MultiCell(72,5,utf8_decode("Lcda. Milagros Arambulo"),0,'C');
//        $this->SetY(235);
//        $this->SetX(72);
//        $this->MultiCell(72,5,utf8_decode("COORDINACIÓN DE COMPRAS"),0,'C');        
        
        //$this->MultiCell(72,5,utf8_decode("COORDINACIÓN DE COMPRAS"),1,10,'C',0);           

//         $this->ln();
//         $this->SetAligns(array("C","C", "C"));
//	 $this->SetFillColor(201, 199, 199);
//         $this->SetWidths(array(200));
//         $this->SetFont('Arial','B',9); 
//         //$this->Row(array(utf8_decode('SECRETARIA DE ADMINISTRACIÓN Y FINANZAS')),1,1);
//         $this->Row(array(utf8_decode($this->op_reporte['dep_compra'])),1,1);
//         $this->SetWidths(array(65,70,65));
//         $this->SetFillColor(255,255,255);
//         $this->SetAligns(array("L", "L","L"));
//         $Y = $this->GetY();
//         $this->MultiCell(65,20,'',1,1,'L',1);
//         $this->SetY($Y);
//         $this->SetX(75);
//         $this->MultiCell(70,20,'',1,1,'L',1);
//         $this->SetY($Y);
//         $this->SetX(145);
//         $this->MultiCell(65,20,'',1,1,'L',1);
//         $this->SetY($Y+17);
//         
//         $this->SetFont('Arial','B',7); 
//         $this->Row(array(utf8_decode('Elaborado por:'),utf8_decode('Conformado por:'), utf8_decode('Aprobado por:')),1,1);
//
//         $this->ln();
//         
//         $this->Cell(0,0,utf8_decode('Usuario Sistema:'),0,0,'L');
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
    
    function PrintChapter() {
        $this->AddPage();        
        $this->ChapterBody();
    }

    function getOrdenes(){

          $conex = new ConexionComun(); 
          
          $sql = "select tb039.nu_requisicion,                         
                         tb039.created_at, 
                         tb039.fe_registro,
                         tb027.tx_tipo_solicitud,
                         tb052.numero_compra,
                         tb052.nu_orden_compra,
                         tb052.fecha_compra,
                         tb039.co_solicitud,
                         tb052.tx_observacion,
                         tb008.tx_razon_social,
                         tb008.tx_rif,
                         tb008.tx_direccion,                         
                         tb008.nb_representante_legal,
                         tb008.nu_cedula_representante,
                         tb008.tx_email,
                         tb047.tx_ente,
                         tb056.nu_expediente,
                         tb052.monto_iva,
                         tb052.nu_iva,
                         upper(tb039.tx_concepto) as tx_concepto
                  from   tb039_requisiciones as tb039
                  left join tb052_compras as tb052 on tb052.co_requisicion=tb039.co_requisicion  
                  left join tb056_contrato_compras as tb056 on tb056.co_compras = tb052.co_compras
                  left join tb027_tipo_solicitud as tb027 on tb027.co_tipo_solicitud=tb039.co_tipo_solicitud
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
          $sql = "SELECT tb048.tx_producto,
                         tb053.nu_cantidad,
                         tb052.nu_iva,
                         tb048.cod_producto,
                         tb053.precio_unitario,
                         tb057.tx_unidad_producto,
                         tb053.monto,
                         tb053.detalle,
                         tb052.monto_iva
                  FROM tb052_compras as tb052       
                  left join tb053_detalle_compras as tb053 on tb053.co_compras = tb052.co_compras and tb053.in_calcular_iva is true
                  left join tb048_producto as tb048 on tb053.co_producto = tb048.co_producto                  
                  left join tb057_unidad_producto as tb057 on tb057.co_unidad_producto = tb053.co_unidad_producto  
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud
                  where tb030.co_ruta =".$_GET['codigo']; //$conex->decrypt($_GET['codigo']);   
          
         
   
          return $conex->ObtenerFilasBySqlSelect($sql);

    }

    function getPartidas()
    {
        $conex = new ConexionComun();
        $sql =" ".$_GET['codigo'];

        return $conex->ObtenerFilasBySqlSelect($sql);
		  
    } 

    function ChapterBody2() {

        $this->datos = $this->getResponsablePresupuesto();
        
        $this->Ln(15);
        $this->SetX(20);
        $this->SetFont('Arial','B',10);
        $this->Cell(0,0,utf8_decode('Ciudadano(a): '.$this->datos['nb_usuario']),0,0,'L');
        $this->Ln(5);
        $this->SetX(20);
        //$this->Cell(0,0,utf8_decode($this->datos['tx_proceso']),0,0,'L');
        //$this->Cell(0,0,utf8_decode('SUBSECRETARIA DE PRESUPUESTO'),0,0,'L');
        $this->Cell(0,0,utf8_decode($this->op_reporte['ciudadano']),0,0,'L');
        $this->Ln(5);
        $this->SetX(20);
        $this->Cell(0,0,utf8_decode('Su despacho.-'),0,0,'L');
        
        $this->Ln(10);
        $this->SetTextColor(0,0,0);
        $this->SetX(1);
        
         $this->Ln(1);

         $this->datos = $this->getOrden();
         $this->nombre = $this->datos['nb_usuario'];
         $this->ente = $this->datos['tx_ente'];    
         
         $this->SetY(90);  
         $this->SetX(20);
         $this->SetFont('Arial','',10);
         $this->MultiCell(190,5,utf8_decode('Por medio del presente me dirijo a usted, en la oportunidad de solicitar la disponibilidad presupuestaria y certificación para la ejecución de una orden por el concepto de: '),0,1,'L',1);                           
        
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->SetX(20);
         $this->MultiCell(190,5,$this->datos['tx_concepto'],0,1,'C',1);                                    
         $this->SetFont('Arial','',10);
         $this->Ln(5);
         $this->SetX(20);
         $this->MultiCell(190,5,utf8_decode('Discriminado por partidas presupuestarias de la siguiente manera: '),0,1,'L',1);                                    
         
                 
         $this->SetWidths(array(190));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->Ln();
         $this->SetFont('Arial','B',9); 
         $this->SetX(20); 
         $this->Row(array(utf8_decode('PARTIDAS ASOCIADAS')),1,1);
         $this->SetFillColor(255, 255, 255); 
         $this->SetFont('Arial','B',8); 
         $this->SetAligns(array("C","C","C"));
         $this->SetWidths(array(50,110,30));
         $this->SetX(20); 
         $this->Row(array('PARTIDA','DENOMINACION','MONTO (Bs.)'),1,1);
         $this->SetAligns(array("C","L","R"));          
         $this->SetFont('Arial','',8);
         $this->lista_partidas = $this->getPartidas2();
         foreach($this->lista_partidas as $key => $campo){  
          $this->SetX(20);   
          $this->Row(array($campo['co_partida'],$campo['de_partida'],number_format($campo['monto'], 2, ',','.')),1,1);
          
         }
         $this->ln(); 
         $this->SetFont('Arial','',10); 
         $this->SetX(20);
         $this->MultiCell(190,5,utf8_decode('Sin otro particular al cual hacer mención, me despido de usted.'),0,1,'L',1);                                    
                
         $this->ln(25);
         $this->SetX(20);
         $this->Cell(190,5,utf8_decode('Atentamente'),0,0,'C');         	 

         
         $this->ln(35);
         $this->SetX(20);
         $this->SetFont('Arial','B',9); 
         //$this->Cell(170,5,utf8_decode('DIRECTOR DE COMPRAS Y SUMINISTRO'. $this->nombre),0,0,'C');   
         //$this->Cell(190,5,utf8_decode('DIRECTOR(A) DE COMPRAS Y SUMINISTRO'),0,0,'C');   
         $this->Cell(190,5,utf8_decode($this->op_reporte['cargo_firma']),0,0,'C');
    }

    function PrintChapter2() {
        $this->AddPage();
        $this->ChapterBody2();
    }

    function getResponsablePresupuesto(){

          $conex = new ConexionComun();     
          $sql = " select tb001.nb_usuario,
                          tb028.tx_proceso
                  from   tb052_compras as tb052                          
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud 
                  left join tb028_proceso as tb028 on tb028.co_proceso = tb030.co_proceso                                                      
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb028.co_responsable
                  where tb030.co_ruta = ".$_GET['codigo'];
                  //.$_GET['co_ruta'];
                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];           
                  
    }
    function getOrden(){

	  $conex = new ConexionComun(); 
                    
          $sql = "select tb052.tx_observacion,
                         tb001.nb_usuario,
                         tb047.tx_ente,
                          upper(tb039.tx_concepto) as tx_concepto                           
                  from   tb052_compras as tb052 
                  left join tb039_requisiciones as tb039 on tb052.co_requisicion=tb039.co_requisicion
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb052.co_usuario
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud                                     
                  left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente
                  where tb030.co_ruta =  ".$_GET['codigo']; //$conex->decrypt($_GET['codigo']);
                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];
           
  
    }

    function getPartidas2()
    {
        $conex = new ConexionComun(); 
                    
          $sql = "select t.co_partida,
                         t.de_partida,
                         case when (tb053.in_calcular_iva) then tb053.monto else tb052.monto_iva end as monto
                  from   tb052_compras as tb052 
                  left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras 
                  left join tb091_partida as t on t.id = tb053.co_partida
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud and tb030.in_cargar_dato is true                               
                  where tb030.co_ruta = ".$_GET['codigo'].' order by tb053.co_detalle_compras asc'; //$conex->decrypt($_GET['codigo']);
                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;         
		  
    }

    function getDatosEmpresa( $codigo){

        $sql = "SELECT co_empresa, nb_empresa, co_estado, co_municipio, tx_rif, tx_nit, 
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

    function getOpcionReporte( $ruta){
        
        $sql = "SELECT tb030.co_ruta, op_reporte,
        op_reporte->>'dep_compra' as dep_compra,
        op_reporte->>'cargo_firma' as cargo_firma,
        op_reporte->>'ciudadano' as ciudadano
        FROM tb030_ruta as tb030
        INNER JOIN tb032_configuracion_ruta AS tb032 ON tb030.co_tipo_solicitud = tb032.co_tipo_solicitud AND tb030.co_proceso = tb032.co_proceso
        WHERE tb030.co_ruta = ".$ruta;
     
        //echo $sql; exit();

        $conex = new ConexionComun(); 

        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];                          
       
    }

}
$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();
$pdf->PrintChapter();
//$pdf->PrintChapter2();
$comm = new ConexionComun();
$ruta = $comm->getRuta();

//rmdir($ruta);
//mkdir($ruta, 0777, true);    

$dir="$ruta".$_GET["codigo"].".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";


$update = "update tb030_ruta set tx_ruta_reporte = '".$dir."' where co_ruta = ".$_GET['codigo']; //$comm->decrypt($_GET["codigo"]);

//echo $update; exit();
$comm->Execute($update);    

$pdf->Output($dir, 'F');

//header('Location: http://'.$_SERVER["SERVER_NAME"].'/index.php/reporte/index/i/'.$_GET["p"]);



//$pdf=new PDF('P','mm','letter');
//$pdf->PrintChapter();
//$pdf->SetDisplayMode('default');
//$pdf->Output(); 

?>
