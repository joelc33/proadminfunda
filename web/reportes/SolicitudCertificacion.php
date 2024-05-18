<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {


        $this->Image("imagenes/escudosanfco.png", 100, 7,20);

        $this->SetFont('Arial','B',11);
        
      //  
        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('<NOMBRE DE LA INSTITUCION>'),0,0,'C');
        $this->Ln(10);
        
        $this->SetFont('Arial','',8);

        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->datos = $this->getResponsablePresupuesto();
        
        $this->Ln(15);
        $this->SetX(32);
        $this->SetFont('Arial','B',10);
        $this->Cell(0,0,utf8_decode('Ciudadano(a): '.$this->datos['nb_usuario']),0,0,'L');
        $this->Ln(5);
        $this->SetX(32);
        $this->Cell(0,0,utf8_decode($this->datos['tx_proceso']),0,0,'L');
        $this->Ln(5);
        $this->SetX(32);
        $this->Cell(0,0,utf8_decode('Su despacho.-'),0,0,'L');
        
        $this->Ln(10);
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

         $this->Ln(1);

         $this->datos = $this->getOrden();
             
         $this->SetY(90);  
         $this->SetX(32);
         $this->SetFont('Arial','',10);
         $this->MultiCell(170,5,utf8_decode('Tengo el agrado de dirigirme a usted, en la oportunidad de solicitar la disponibilidad presupuestaria para la ejecución de una orden por el concepto: '),0,1,'L',1);                           
        
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->SetX(32);
         $this->MultiCell(170,5,'"'.utf8_decode($this->datos['tx_observacion']).'"',0,1,'C',1);                                    
         $this->SetFont('Arial','',10);
         $this->Ln(5);
         $this->SetX(32);
         $this->MultiCell(170,5,utf8_decode('Discriminando por partidas presupuestarias de la siguiente manera: '),0,1,'L',1);                                    
         
                 
         $this->SetWidths(array(170));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->Ln();
         $this->SetFont('Arial','B',7); 
         $this->SetX(32); 
         $this->Row(array(utf8_decode('PARTIDAS ASOCIADAS')),1,1);
         $this->SetFillColor(255, 255, 255); 
         $this->SetFont('Arial','B',6); 
         $this->SetAligns(array("C","C","C"));
         $this->SetWidths(array(50,90,30));
         $this->SetX(32); 
         $this->Row(array('PARTIDA','DENOMINACION','MONTO EN BOLIVARES'),1,1);
       
         $this->lista_partidas = $this->getPartidas();
         foreach($this->lista_partidas as $key => $campo){  
          $this->SetX(32);   
          $this->Row(array($campo['co_partida'],$campo['de_partida'],number_format($campo['monto'], 2, ',','.')),1,1);
          
         }
         
         
         $this->ln();
         $this->SetX(32); 
         $this->SetWidths(array(170));
         $this->SetAligns(array("L"));  
         $this->SetFont('Arial','',10); 
         $this->Cell(170,5,utf8_decode('Agradeciendo su atención sobre el particular, me despido de usted.'),0,0,'C');         
         $this->ln(25);
         $this->SetX(32);
         $this->Cell(170,5,utf8_decode('Atentamente'),0,0,'C');         	 

         
         $this->ln(35);
         $this->SetX(32);
         $this->Cell(170,5,utf8_decode('SOLICITANTE: '. $this->nombre),0,0,'C');      
         $this->ln(10);
         $this->SetX(32);
         $this->Cell(170,5,utf8_decode('ENTIDAD SOLICITANTE: '.$this->ente ),0,0,'C');
         

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
                         tb047.tx_ente                           
                  from   tb052_compras as tb052 
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb052.co_usuario
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud                                     
                  left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente
                  where tb030.co_ruta =  ".$_GET['codigo']; //$conex->decrypt($_GET['codigo']);
                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];
           
  
    }

    function getPartidas()
    {
        $conex = new ConexionComun(); 
                    
          $sql = "select t.co_partida,
                         t.de_partida,
                         tb053.monto
                  from   tb052_compras as tb052 
                  left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras 
                  left join tb085_presupuesto as t on t.id = tb053.co_partida
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud and tb030.in_cargar_dato is true                               
                  where tb030.co_ruta = ".$_GET['codigo']; //$conex->decrypt($_GET['codigo']);
                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;         
		  
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
/*
$pdf=new PDF('P','mm','letter');
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();
*/
?>
