<?php
include("ConexionComun.php");
include('fpdf.php');
include('tcpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->empresa = $this->getDatosEmpresa(1);

        if (!empty($this->empresa['tx_imagen_izq'])) {
            $this->Image("imagenes/" . $this->empresa['tx_imagen_izq'],  $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
        }



        $this->SetFont('Arial', 'B', 8);

        $this->SetTextColor(0, 0, 0);
        $this->SetY(12);
        $this->Cell(0, 0, utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode($this->empresa['nb_empresa']), 0, 0, 'C');
        $this->Ln(4);
        if (!empty($this->empresa['nb_institucion'])) {
            $this->Cell(0, 0, utf8_decode($this->empresa['nb_institucion']), 0, 0, 'C');
            $this->Ln(4);
        }
        $this->Cell(0, 0, utf8_decode('RIF. ' . $this->empresa['tx_rif']), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('DIRECCIÓN DE ADMINISTRACIÓN Y FINANZAS'), 0, 0, 'C');
     

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
        $this->empresa = $this->getDatosEmpresa(1);

         $this->Ln(15);

         $this->datos = $this->getOrden();
            $this->SetFont('Arial','B',10);
         $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
         
         $this->SetFont('Arial','',10);
         $this->Ln(15);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode('Señor(a):'),0,0,'L');
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode($this->datos['nb_responsable']),0,0,'L');
         $this->SetFont('Arial','B',8);
         $this->Ln(5);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode($this->datos['cargo']),0,0,'L');
         $this->SetFont('Arial','',8);
         $this->Ln(4);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode('Su Despacho.'),0,0,'L');
         
         $this->SetFont('Arial','',10);
         $this->Ln(10);
         $this->SetX(35);
         $this->Cell(10,0,utf8_decode('Reciba un cordial y respetuoso saludo.'),0,0,'L');
         
         $this->SetFont('Arial','',10);
         $this->Ln(10);
         $this->SetWidths(array(170));
         $this->SetAligns(array("J"));
         $this->SetX(25);
         $this->Row(array(utf8_decode('     La presente tiene la finalidad de solicitarle la disponibilidad presupuestaria para la ejecución del proceso de: '.$this->datos['tx_concepto']).'.'), 0, 0);
  
        $this->Ln(31);         
        
             $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->Cell(200,10,utf8_decode('Atentamente.'),0,0,'C');         
         $this->ln(10);
         
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->Cell(200,10,utf8_decode($this->empresa['nb_presidente']),0,0,'C'); 
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->Cell(200,10,utf8_decode('Presidente.'),0,0,'C');   
         
         $this->AddPage();
         $this->Ln(15);
         
        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->Ln(15);
        $this->SetFont('Arial','B',12);
         $this->Cell(0, 0, utf8_decode('DISPONIBILIDAD PRESUPUESTARIA INICIAL'), 0, 0, 'C');
         $this->Ln(15);
         
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
         $this->Cell(0,0,utf8_decode('PRESIDENTE DE LA '.$this->empresa['nb_institucion']),0,0,'L');
         $this->SetFont('Arial','',8);
         $this->Ln(4);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode('Su Despacho.'),0,0,'L');

         
         $this->SetY(100);  
         $this->SetX(20);
         $this->SetFont('Arial','',10);
         $montoletra = numtoletras($this->datos['monto'], 1);
         $montonum = number_format($this->datos['monto'], 2, ',','.');
         
         $html='     Por medio de la presente, se informa que en el presupuesto de egreso se encuentra contemplado el código presupuestario que se describe a continuación: ';

         $this->SetX(25);
         $this->MultiCell(170,5,utf8_decode($html),0,1,'J',1);                                                              
                          
                 
         $this->Ln();
         $this->SetFillColor(255, 255, 255); 
         $this->SetFont('Arial','B',8); 
         $this->SetAligns(array("C","C","C","C"));
         $this->SetWidths(array(35,55,50,30));
         $this->SetX(25); 
         $this->Row(array('CODIGO PRESUPUESTARIO','DENOMINACION','FUENTE FINANCIAMIENTO','MONTO (Bs.) DISPONIBLE TOTAL'),1,1);
         $this->SetAligns(array("C","C","C","C"));         
         $this->SetFont('Arial','',8);
         $this->lista_partidas = $this->getPartidas();
         foreach($this->lista_partidas as $key => $campo){  
             
                            if($this->getY()>240){
                     $this->AddPage();
                     $this->Ln(20);
                     $this->SetFillColor(255, 255, 255); 
                     $this->SetFont('Arial','B',6); 
                     $this->SetAligns(array("C","C","C","C"));
                     $this->SetWidths(array(35,55,50,30));
                     $this->SetX(25); 
                     $this->Row(array('CODIGO PRESUPUESTARIO','DENOMINACION','FUENTE FINANCIAMIENTO','MONTO (Bs.) DISPONIBLE TOTAL'),1,1);
         
                            }             
             $prueba = $campo['de_partida'];
                            
          $this->SetX(25);   
          $this->SetWidths(array(35,55,50,30));
          $this->SetAligns(array("C","C","C","C"));
          $this->Row(array(utf8_decode($campo['co_categoria']),$prueba,utf8_decode($campo['tx_descripcion']),number_format($campo['monto'], 2, ',','.')),1,1);
          
         }
         
         
         
         $this->ln();
         $this->SetX(20); 
         $this->SetWidths(array(170));
         $this->SetAligns(array("L"));  
         $this->SetFont('Arial','',10); 
         $this->Cell(170,5,utf8_decode('Sin más a que hacer referencia, me despido de usted.'),0,0,'L');         
         $this->ln(15);
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->Cell(200,10,utf8_decode('Atentamente.'),0,0,'C');         
         $this->ln(10);
         
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->Cell(200,10,utf8_decode($this->empresa['nb_presidente']),0,0,'C'); 
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->Cell(200,10,utf8_decode('Presidente.'),0,0,'C');   
         

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

  

    function getOrden(){

	  $conex = new ConexionComun(); 
                    
          $sql = "select sum(tb207.monto) as monto, tb206.tx_observacion, upper(tb039.tx_concepto) as tx_concepto,                         
                         upper(tb047.nb_responsable) as nb_responsable, 
                         upper(tb047.cargo) as cargo 
                  from   tb206_cotizacion as tb206 
                  left join tb039_requisiciones as tb039 on tb039.co_solicitud = tb206.co_solicitud
                  left join tb207_detalle_cotizacion as tb207 on tb206.co_cotizacion = tb207.co_cotizacion
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb206.co_solicitud and tb030.in_cargar_dato is true
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb030.co_usuario
                  left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente
                  where tb030.co_ruta = ".$_GET['codigo']." group by tb206.co_cotizacion, tx_concepto, tb047.nb_responsable,tb047.cargo "; 
                  
         
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];     
                       
           
          
  
    }

    function getPartidas()
    {
                    
          $conex = new ConexionComun(); 
                    
          $sql = "select substring(tb085.co_categoria,18,50) as co_categoria,
                         tb085.de_partida,
                         sum(tb207.monto) as monto,
                         tb140.tx_descripcion
                  from   tb206_cotizacion as tb206 
                  left join tb207_detalle_cotizacion as tb207 on tb207.co_cotizacion = tb206.co_cotizacion
                  left join tb085_presupuesto as tb085 on (tb085.id = tb207.co_presupuesto)
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb206.co_solicitud and tb030.in_cargar_dato is true
                  left join tb140_tipo_ingreso as tb140 on tb140.co_tipo_ingreso = tb085.tip_ing::numeric
                  where tb030.co_ruta = ".$_GET['codigo']."  group by co_categoria,tb085.de_partida,tb140.tx_descripcion
                  order by co_categoria asc"; //$conex->decrypt($_GET['codigo']);
                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
		  
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



//$pdf=new PDF('P','mm','letter');
//$pdf->AliasNbPages();
//$pdf->PrintChapter();
//
//$comm = new ConexionComun();
//$ruta = $comm->getRuta();
//
////rmdir($ruta);
////mkdir($ruta, 0777, true);    
//
//$dir="$ruta".$_GET["codigo"].".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";
//
//
//$update = "update tb030_ruta set tx_ruta_reporte = '".$dir."' where co_ruta = ".$_GET['codigo']; //$comm->decrypt($_GET["codigo"]);
//
////echo $update; exit();
//$comm->Execute($update);    
//$pdf->Output($dir, 'F');

$pdf=new PDF('P','mm','letter');
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
