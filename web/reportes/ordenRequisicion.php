<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->empresa = $this->getDatosEmpresa(1);

        if (!empty($this->empresa['tx_imagen_cen'])) {
            $this->Image("imagenes/" . $this->empresa['tx_imagen_cen'],  $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
        }

        $this->SetFont('Arial', 'B', 8);

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
//        $this->Cell(0, 0, utf8_decode('DIRECCIÓN DE ADMINISTRACIÓN Y FINANZAS'), 0, 0, 'C');
//        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('RIF. ' . $this->empresa['tx_rif']), 0, 0, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 8);
//        $this->Cell(0,0,utf8_decode('REQUISICIÓN '),0,0,'C');

//        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        
//        $this->Ln(5);
        $this->SetTextColor(0,0,0);
        $this->SetX(1);

        $this->Ln(2);
       

    }

    function Footer() {
//	$this->SetFont('Arial','',9);     
//	$this->SetY(-20);      
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
        $this->empresa = $this->getDatosEmpresa(1);

         $this->Ln(1);

         $this->datos = $this->getOrdenes();

         $this->Cell(0,0,utf8_decode('Maracaibo, '.$this->datos['dia'].' de '.mes($this->datos['mes']).' del '.$this->datos['anio']),0,0,'R');
         
         $this->SetFont('Arial','',10);
         $this->Ln(5);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode('Señor(a):'),0,0,'L');
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode($this->empresa['nb_presidente']),0,0,'L');
         $this->SetFont('Arial','B',8);
         $this->Ln(5);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode(strtoupper($this->empresa['tx_nit'].' '.$this->empresa['nb_institucion'])),0,0,'L');
         $this->SetFont('Arial','',8);
         $this->Ln(4);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode('Su Despacho.'),0,0,'L');
         
         $this->SetFont('Arial','',10);
         $this->Ln(5);
         $this->SetX(35);
         $this->Cell(10,0,utf8_decode('Reciba un cordial y respetuoso saludo.'),0,0,'L');
         
         $this->SetFont('Arial','',10);
         $this->Ln(10);
         $this->SetWidths(array(170));
         $this->SetAligns(array("J"));
         $this->SetX(25);
         $this->Row(array(utf8_decode('     La presente tiene como finalidad, solicitarle los siguientes ítems para el proceso, '.$this->datos['tx_concepto'])), 0, 0);
  
        // $this->line(1, 60, 220, 60);
//         $this->SetFont('Arial','B',10);
//         $this->SetFillColor(255, 255, 255);
//         $this->SetWidths(array(60,140));
//         $this->SetAligns(array("L","L"));
//         $this->SetWidths(array(200));
//         $this->SetAligns(array("C"));
//         $this->SetY(60);
//         $this->SetFillColor(201, 199, 199);
//         $this->Row(array(utf8_decode('DATOS DE LA REQUISICIÓN')),1,1);
//         $this->SetFillColor(255, 255, 255);
//         $this->SetWidths(array(100,100)); 
//         $Y = $this->GetY();
//         $this->MultiCell(100,10,'',1,1,'L',1);
//         $this->SetY($Y);
//         $this->SetX(110);
//         $this->MultiCell(100,10,'',1,1,'L',1);
//         $this->SetY(68);
//         $this->SetAligns(array("L","L"));
//         $this->SetFont('Arial','',9);
//         $this->Row(array(utf8_decode('  REQUISICIÓN N°  ').$this->datos['nu_requisicion'],utf8_decode('  FECHA:  ').date("d/m/Y", strtotime($this->datos['fe_registro']))),0,0); 
//         $this->SetWidths(array(200));
//         $this->Ln(2);
//         $Y = $this->GetY()+3;
//         $this->MultiCell(200,13,'',1,1,'L',1);
//         $this->SetY($Y);
//         $this->SetAligns(array("J"));
//         $this->Row(array('  DEPARTAMENTO SOLICITANTE: '.utf8_decode($this->datos['tx_ente'])),0,0);
//        // $this->Row(array(' UNIDAD USUARIA: '),0,0);
//         $Y = $this->GetY();
//         $this->SetY($Y);
//         $this->MultiCell(200,11,'',1,1,'L',1);
//         $this->SetY($Y+1);
//         $this->Row(array('  CONCEPTO: '.utf8_decode($this->datos['tx_concepto'])),0,0);
         
         
         
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->Ln(5);
         $this->SetFont('Arial','B',10);
//         $this->Row(array('DETALLES DE MATERIALES'),1,1);
         $this->SetFillColor(255, 255, 255);         
         $this->SetAligns(array("C","C","C","C"));
         $this->SetWidths(array(15,95,35,30)); 
         $this->SetX(25);
         $this->Row(array(utf8_decode('ITEM'),utf8_decode('DESCRIPCIÓN'),utf8_decode('PRESENTACIÓN'),'CANTIDAD'),1,1);         
         $i = 1;
         $this->lista_materiales = $this->getMateriales();
         foreach($this->lista_materiales as $key => $campo){ 

                            if($this->getY()>220){
                     $this->AddPage();
                     
                     $this->Cell(0,0,utf8_decode('Maracaibo, '.$this->datos['dia'].' de '.mes($this->datos['mes']).' del '.$this->datos['anio']),0,0,'R');
                     $this->Ln(20);
                     $this->SetFillColor(255, 255, 255);         
                     $this->SetAligns(array("C","C","C","C"));
                     $this->SetWidths(array(15,95,35,30));
                     $this->SetX(25);
                     $this->Row(array(utf8_decode('ITEM'),utf8_decode('DESCRIPCIÓN'),utf8_decode('PRESENTACIÓN'),'CANTIDAD'),1,1); 
                            }               
             
         $this->SetFont('Arial','',9);
         $this->SetAligns(array("C","L","C","C"));
         $this->SetWidths(array(15,95,35,30));
         $this->SetX(25);
         $this->Row(array(utf8_decode($i),utf8_decode($campo['tx_producto']).' - '.utf8_decode($campo['tx_observacion']),utf8_decode($campo['tx_unidad_producto']),utf8_decode($campo['nu_cantidad'])),1,1);
         $i++;
        }
//        while ($i<11) 
//         {
//             $this->SetX(25);
//          $this->Row(array('','',''),1,1);  
//          $i++;
//         }   
         foreach($this->lista_materiales as $key => $campo){
             
//         if($this->getY()>220){
//             $this->addPage();
//
//	 }             
//         $this->SetAligns(array("L"));
//         $this->SetWidths(array(200));
//         $this->SetFont('Arial','B',9);
//         if ($campo['tx_observacion'])
//             $this->Row(array(utf8_decode('ESPECIFICACIONES TÉCNICAS / CÓDIGO: '.$campo['cod_producto'].' - ').utf8_decode($campo['tx_observacion'])),1,1);
        }
                 
//         $this->ln();
//         $this->SetAligns(array("C","C", "C"));
//	     $this->SetFillColor(201, 199, 199);
//         $this->SetWidths(array(65,70,65));
//         $this->SetFont('Arial','B',8);
         //$this->Row(array('UNIDAD SOLICITANTE',utf8_decode('DIRECCIÓN DE COMPRAS Y SUMINISTRO'),utf8_decode('SECRETARIA DE ADMINISTRACIÓN Y FINANZAS')),1,1);  
//         $this->Row(array(utf8_decode($this->op_reporte['de_unidad']),utf8_decode($this->op_reporte['de_ubicacion_admin']),utf8_decode($this->op_reporte['de_empresa'])),1,1);       
//         $this->SetFillColor(255,255,255);
//         $this->SetAligns(array("L", "L","L"));
//         $Y = $this->GetY();
//         $this->MultiCell(65,14,'',1,1,'L',1);
//         $this->SetY($Y);
//         $this->SetX(75);
//         $this->MultiCell(70,14,'',1,1,'L',1);
//         $this->SetY($Y);
//         $this->SetX(145);
//         $this->MultiCell(65,14,'',1,1,'L',1);
//         $this->SetY($Y+5);
//         $this->SetFont('Arial','',6);
//         $this->ln(8);
//         $this->Row(array('Solicitado por:','Registrado por:', 'Aprobado por:'),1,1);
         
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->Cell(200,10,utf8_decode('Atentamente.'),0,0,'C');         
         $this->ln(10);
         
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->Cell(200,10,utf8_decode($this->datos['nb_responsable']),0,0,'C'); 
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->Cell(200,10,utf8_decode($this->datos['cargo']),0,0,'C');          
         
         //$this->Cell(0,0,'Elaborado por: '.$this->datos['nb_usuario'],0,0,'L');
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

    function getTipoOrdenes(){

          $conex = new ConexionComun();     
          $sql = "select upper(tb027.tx_tipo_solicitud) as tx_tipo_solicitud                   
                  from   tb039_requisiciones as tb039                  
                  left join tb027_tipo_solicitud as tb027 on tb027.co_tipo_solicitud=tb039.co_tipo_solicitud                  
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb039.co_solicitud                  
                  where tb030.co_ruta = ".$_GET['codigo'];
                  
         // echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];                          
         
    }
    
    function getOrdenes(){

          $conex = new ConexionComun();     
          $sql = "select tb039.nu_requisicion,  
                         upper(tb039.tx_concepto) as tx_concepto,
                         tb039.created_at,
                         tb039.fe_registro,                
                         tb039.co_solicitud,
                         upper(tb039.tx_observacion) as tx_observacion,
                         upper(tb047.tx_ente) as tx_ente, 
                         upper(tb047.nb_responsable) as nb_responsable, 
                         upper(tb047.cargo) as cargo, 
                         to_char(tb039.fe_registro,'dd') as dia,
                         to_char(tb039.fe_registro,'mm') as mes,
                         to_char(tb039.fe_registro,'yyyy') as anio,
                         nb_usuario
                  from   tb039_requisiciones as tb039                  
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb039.co_usuario
                  left join tb047_ente as tb047 on tb047.co_ente = tb039.co_ente
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb039.co_solicitud                  
                  where tb030.co_ruta = ".$_GET['codigo'];
                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];                          
         
    }

    function getMateriales(){

	  $conex = new ConexionComun();
          $sql = "SELECT distinct upper(tb048.tx_producto) as tx_producto,
                         tb051.nu_cantidad,
                         tb048.cod_producto,
                         tb057.tx_unidad_producto,
                         --tb053.precio_unitario,
                         upper(tb051.tx_observacion) as tx_observacion
                  FROM tb051_detalle_requision_producto as tb051
                  left join tb048_producto as tb048 on tb051.co_producto = tb048.co_producto  
                  left join tb057_unidad_producto as tb057 on tb057.co_unidad_producto = tb051.co_unidad_producto
                  left join tb089_unidad_medida as tb089 on tb089.id = tb048.co_unidad_producto
                  left join tb052_compras as tb052 on tb052.co_requisicion=tb051.co_requisicion       
                  left join tb053_detalle_compras as tb053 on tb053.co_compras = tb052.co_compras and tb051.co_producto = tb053.co_producto
                  left join tb039_requisiciones as tb039 on tb039.co_requisicion = tb051.co_requisicion
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb039.co_solicitud
                  where tb030.co_ruta = ".$_GET['codigo'];                
   
          return $conex->ObtenerFilasBySqlSelect($sql);

    }

    function getPartidas()
    {
        $conex = new ConexionComun();
        $sql =" ".$_GET['codigo'];

        return $conex->ObtenerFilasBySqlSelect($sql);
		  
    }

    function getDatosEmpresa( $codigo){

        $sql = "SELECT co_empresa, nb_empresa, co_estado, co_municipio, tx_rif, tx_nit, nb_institucion, nb_presidente,
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
        op_reporte->>'de_unidad' as de_unidad,
        op_reporte->>'de_ubicacion_admin' as de_ubicacion_admin,
        op_reporte->>'de_empresa' as de_empresa
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

$comm = new ConexionComun();
$ruta = $comm->getRuta();

//echo $ruta; exit();
//rmdir($ruta);
//mkdir($ruta, 0777, true);    

$dir="$ruta".$_GET["codigo"].".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";


$update = "update tb030_ruta set tx_ruta_reporte = '".$dir."' where co_ruta = ".$_GET['codigo']; //$comm->decrypt($_GET["codigo"]);

//echo $update; exit();
$comm->Execute($update);    

$pdf->Output($dir, 'F');



//$pdf=new PDF('P','mm','letter');
//$pdf->PrintChapter();
//$pdf->SetDisplayMode('default');
//$pdf->Output();


?>
