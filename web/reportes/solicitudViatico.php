<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $array_factura;
    public $array_factura_banco;
    
   
    function Header() {

        $this->empresa = $this->getDatosEmpresa(1);

        //$this->Image("imagenes/escudosanfco.png", 100, 7,20);

        if(!empty($this->empresa['tx_imagen_cen'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_cen'],  $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
        }

        $this->SetFont('Arial','B',8);

        $this->SetTextColor(0, 0, 0);
        $this->SetY(12);
        $this->Cell(0, 0, utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'), 0, 0, 'C');
        $this->Ln(4);       
        $this->Cell(0, 0, utf8_decode($this->empresa['nb_empresa']), 0, 0, 'C');
        if (!empty($this->empresa['nb_institucion'])) {
            $empresa = utf8_decode($this->empresa['nb_institucion']);
            $this->Ln(2);
            $this->SetX(52);
            $this->MultiCell(110,4,utf8_decode($this->empresa['nb_institucion']),0,'C',0); 
            $this->Ln(2);
        }else{
            $empresa = utf8_decode($this->empresa['nb_empresa']);
        $this->Ln(4);    
        }
        $this->Cell(0, 0, utf8_decode('RIF. ' . $this->empresa['tx_rif']), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('DIRECCIÓN DE ADMINISTRACIÓN Y FINANZAS'), 0, 0, 'C');
        $this->Ln(12);
        $this->SetFont('Arial', 'B', 14);
      

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

         $this->datos = $this->getSolicitudViatico();      
         $this->empresa = $this->getDatosEmpresa(1);
        if (!empty($this->empresa['nb_institucion'])) {
            $empresa = utf8_decode($this->empresa['nb_institucion']);
        }else{
            $empresa = utf8_decode($this->empresa['nb_empresa']);   
        }         
         $this->SetFont('Arial','B',14);
         $this->Cell(0,0,utf8_decode('SOLICITUD DE VIATICOS'),0,0,'C');
        
    
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);         
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(170));
         $this->SetAligns(array("L"));
         $this->SetY(55);
         $this->SetFillColor(201, 199, 199);
         $this->SetX(25);            
         $this->Row(array(utf8_decode('DATOS DE LA SOLICITUD')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetAligns(array("L"));
         $this->SetFont('Arial','',9);
         $this->SetX(25);          
         $Y = $this->GetY();
         $this->MultiCell(170,40,'',1,1,'L',1);  
         $this->SetY($Y);
         $this->SetX(25);          
         $this->Row(array('FECHA SOLICITUD: '.date("d/m/Y", strtotime($this->datos['fecha']))),0,0);  
         $this->SetX(25);          
         $this->MultiCell(170,30,'ORGANISMO / UNIDAD:  '.utf8_decode($this->datos['tx_ente']),0,1,'J',0);
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Arial','B',8);   
         $this->SetX(25);          
         $this->Row(array(utf8_decode('DETALLES DE UBICACIÓN')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetFont('Arial','',9);         
         $this->SetAligns(array("L"));
         $Y = $this->GetY();
         $this->SetX(25);          
         $this->MultiCell(170,20,'',1,1,'L',1);  
         $this->SetY($Y);
         $this->SetX(25);          
         $this->Row(array(utf8_decode('TIPO DE VIATICO: '.utf8_decode($this->datos['tx_tipo_viatico']))),0,0);   
         $this->SetX(25);          
         $this->MultiCell(170,10,'DESTINO:  '.utf8_decode($this->datos['destino']),0,1,'J',0);
         $this->SetWidths(array(170));         
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Arial','B',8);       
         $this->SetX(25);          
         $this->Row(array(utf8_decode('DETALLES DEL VIAJE')),1,1);
         $this->SetFont('Arial','',9);          
         $this->SetFillColor(255, 255, 255); 
         $this->SetAligns(array("L","L","L"));      
         $this->SetWidths(array(60,60,50));
         $this->SetX(25);          
         $this->Row(array('FECHA DE SALIDA: '.date("d/m/Y", strtotime($this->datos['fe_desde'])),'FECHA DE RETORNO: '.date("d/m/Y", strtotime($this->datos['fe_hasta'])),'CANTIDAD DE DIAS: '),1,1);            
         $this->SetWidths(array(170));
         $this->SetAligns(array("L"));
         $Y = $this->GetY();
         $this->SetX(25);          
         $this->MultiCell(170,30,'',1,1,'L',1);  
         $this->SetY($Y);   
         $this->SetX(25);          
         $this->MultiCell(170,30,'MOTIVO:  '.utf8_decode($this->datos['tx_evento']),0,1,'J',0);     
         $Y = $this->GetY();
         $this->SetX(25);          
         $this->MultiCell(170,40,'',1,1,'L',1);  
         $this->SetY($Y);    
         $this->SetX(25);          
         $this->MultiCell(170,40,'OBSERVACIONES:  '.utf8_decode($this->datos['tx_observacion_hospedaje']),0,1,'J',0);              
         $this->SetFont('Arial','B',8);
         
//          $Y = $this->GetY();
//         $this->MultiCell(200,30,'',1,1,'L',1);
         
         $this->SetAligns(array("C","C", "C"));
	 $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(85,85)); 
         $this->SetX(25);          
         $this->Row(array(utf8_decode('DATOS DEL SOLICITANTE'),utf8_decode('DATOS DEL APROBADOR')),1,1);
         $this->SetFillColor(255, 255, 255); 
         $this->SetAligns(array("L","L")); 
         $Y = $this->GetY();
         $this->SetX(25);    
         $this->SetWidths(array(85));         
         $this->Row(array('Nombre:','Nombre:'),0,0);
         $this->SetX(25);         
         $this->Row(array('C.I.:','C.I.:'),0,0);
         $this->SetX(25);         
         $this->Row(array('Cargo:','Cargo:'),0,0);
         $this->SetX(25);                
         $this->Row(array('Firma y Sello:','Firma y Sello:'),0,0);
         $this->SetY($Y);
         $this->SetX(25);          
         $this->MultiCell(85,50,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(110);          
         $this->MultiCell(85,50,'',1,1,'L',1);
         
          $this->AddPage(); 
          
          
         $this->Ln(10); 
         $this->SetFont('Arial','B',12);
         $this->Cell(0,0,utf8_decode('MEMORANDO INTERNO'),0,0,'C');
         $this->Ln(12);
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 0, utf8_decode('PARA: '), 0, 0, 'L');
        $this->SetX(33);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0,0,utf8_decode($this->datos['nb_responsable']),0,0,'L');
        $this->Ln(5);
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 0, utf8_decode('DE:'), 0, 0, 'L');
        $this->SetX(31);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0,0,utf8_decode($this->empresa['nb_presidente']),0,0,'L');
        $this->Ln(5);
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0,0,utf8_decode('ASUNTO: '),0,0,'L');
        $this->SetFont('Arial', '', 10);
        $this->SetX(37);
        $this->Cell(0,0,utf8_decode('Asignación de viáticos'),0,0,'L');
        $this->Ln(5);
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0,0,utf8_decode('FECHA: '),0,0,'L');
        $this->SetX(35);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0,0,date("d/m/Y", strtotime($this->datos['fecha'])),0,0,'L');        

        $this->Ln(10);        
         
         $this->SetFont('Arial','',12);
         $this->SetX(20);
         $inf = "Por medio de la presente, me dirijo a usted con finalidad de solicitarle el CALCULO de la ASIGNACIÓN DE VIÁTICOS SEGÚN DECRETO N° 349 DE FECHA 05-05-202 que seran utilizados para *** hacia la *** donde se visitará *** durante los dias **** , a **** portador(a) de la cedula de identidad N° ****, representante de ".$empresa."."; 
         $this->MultiCell(180,5,utf8_decode($inf),0,1,'J',0);
         
         $this->Ln(10); 
         $this->SetX(20);
         $this->Cell(0,0,utf8_decode('Agradeciendo la atención prestada.'),0,0,'L');
         
         $this->Ln(20); 
         $this->SetX(20);
         $this->Cell(0,0,utf8_decode('Atentamente.'),0,0,'L');
         
         $this->ln(10);
         
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->Cell(200,10,utf8_decode($this->datos['nb_responsable']),0,0,'C'); 
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->Cell(200,10,utf8_decode($this->datos['cargo']),0,0,'C');         
  

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

    function getSolicitudViatico(){

          $conex = new ConexionComun(); 
          
          $sql = "  select UPPER(tb108.tx_observacion_hospedaje) as tx_observacion_hospedaje, 
                        upper(tb108.tx_evento) as tx_evento, 
                        tb108.fe_desde, 
                        tb108.fe_hasta, 
                        tb108.created_at as fecha, 
                        upper(tb047.tx_ente) as tx_ente, 
                        upper(tb110.tx_origen_viatico) as destino, 
                        upper(tb107.tx_tipo_viatico ) as tx_tipo_viatico,
                        tb047.nb_responsable,tb047a.cargo
                    from tb026_solicitud as tb026 
                    left join tb108_viatico as tb108 on tb108.co_solicitud = tb026.co_solicitud 
                    left join tb107_tipo_viatico as tb107 on tb107.co_tipo_viatico = tb108.co_tipo_viatico 
                    left join tb110_origen_viatico as tb110 on tb108.co_destino = tb110.co_origen_viatico 
                    left join tb008_proveedor as tb008 on tb008.co_proveedor=tb108.co_proveedor 
                    left join tb001_usuario as tb001 on tb001.co_usuario = tb108.co_usuario 
                    left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente
                    left join tb047_ente as tb047a on tb047a.co_ente = 1
                    left join tb030_ruta as tb030 on tb030.co_solicitud = tb108.co_solicitud 
                    where tb030.co_ruta = ".$_GET['codigo']; //$conex->decrypt($_GET['codigo']);
                  
          //echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];                    
          
          
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

$pdf->Output($dir, 'F');

//$pdf=new PDF('P','mm','letter');
//$pdf->PrintChapter();
//$pdf->SetDisplayMode('default');
//$pdf->Output();

?>
