<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->datos = $this->getConsulta();

        $this->Image("imagenes/escudosanfco.png", 100, 7,20);

        $this->SetFont('Arial','B',10);
        
      //  
        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACIÓN Y FINANZAS'),0,0,'C');    
        
        $this->SetFont('Arial','',8);
        $this->Ln(6);

        //$this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->Cell(0,0,utf8_decode('Maracaibo, '.$this->datos['dia'].' de '.mes($this->datos['mes']).' del '.$this->datos['anio']),0,0,'R');
        
        $this->Ln(10);
        $this->SetFont('Arial','B',11);        
        $this->Cell(0,0,utf8_decode('DESAFECTACION DE ORDENES DE PAGO'),0,0,'C');
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

         $this->Ln(5);
         $this->datos = $this->getConsulta();

         $this->SetFont('Arial','B',9);       
         $this->SetWidths(array(180));
         $this->SetAligns(array("L"));
         $this->SetY(65);
         $this->SetX(25);
         $this->SetFillColor(255, 255, 255);
         $this->Row(array(utf8_decode('NRO. SOLICITUD: '.$this->datos['co_solicitud'])),0,0); 
         $this->Ln(10);   
         $this->SetFont('Arial','',10);  
         $this->SetX(25);          
         
         $this->Ln();

         $this->SetWidths(array(30, 30, 90, 30)); 
         $this->SetAligns(array("C","C","C","C"));              
         $this->SetFont('Arial','B',8);
	     $this->SetFillColor(201, 199, 199);  
         $this->SetX(25);         
         $this->Row(array(utf8_decode('ORDER DE PAGO'),utf8_decode('RIF'),utf8_decode('RAZON SOCIAL'),utf8_decode('MONTO DISPONIBLE')),1,1);         
         $this->SetFillColor(255, 255, 255);         
         $this->lista_traspaso = $this->getTraspaso();
         $totalcred = 0;
         $totaldeb  = 0;
          $this->SetAligns(array("L","L","R","R")); 
         $this->SetFont('Arial','',8);          
         foreach($this->lista_traspaso as $key => $campo){          
            $Y = $this->GetY();
            if ($Y >= 230) {

                $this->SetAligns(array("C","C", "C"));
                $this->SetFillColor(201, 199, 199);
                $this->SetWidths(array(90,90));
                $this->SetFont('Arial','B',8); 
                        
                //$this->ln(25);
                $this->SetY(270);
                $this->SetFont('Arial','',8); 
                $this->SetX(25);          
                $this->Cell(0,0,utf8_decode('Usuario del sistema: '.$this->datos['nb_usuario']),0,0,'L');
                $this->ln(3);
                $this->SetX(25);          
                $this->Cell(0,0,utf8_decode('Nro. Solicitud: '.$this->datos['co_solicitud']),0,0,'L');

                $this->AddPage();
                $this->Ln(5);
                 $this->SetWidths(array(30, 30, 90, 30)); 
                $this->SetAligns(array("C","C","C","C"));              
                $this->SetFont('Arial','B',8);
                $this->SetFillColor(201, 199, 199);  
                $this->SetX(25);         
                $this->Row(array(utf8_decode('ORDER DE PAGO'),utf8_decode('RIF'),utf8_decode('RAZON SOCIAL'),utf8_decode('MONTO DISPONIBLE')),1,1); 
                $this->SetFillColor(255, 255, 255);   
                $this->SetAligns(array("C","C","C","C"));
                $this->SetFont('Arial','',7); 

            }
            $this->SetX(25);             
            $this->Row(array($campo['tx_serial'],$campo['tx_rif'],$campo['tx_razon_social'],number_format($campo['mo_pendiente'], 2, ',','.')),1,1);         
            $totalcred = $campo['mo_pendiente'] + $totalcred;
         }
         $this->SetFont('Arial','B',8);         
         $this->SetWidths(array(150,30,30)); 
         $this->SetAligns(array("R","R","R")); 
         $this->SetX(25);         
         $this->Row(array('TOTAL',number_format($totalcred, 2, ',','.')),1,1);         

         $this->SetAligns(array("C","C", "C"));
	     $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(90,90));
         $this->SetFont('Arial','B',8); 

         $this->SetY(230);
         $this->SetX(25);    
         //$this->Row(array(utf8_decode('SUBSECRETARIA DE PRESUPUESTO'),utf8_decode('SECRETARIA DE ADMINISTRACION')),1,1);         
         $this->SetFillColor(255,255,255);
         $Y = $this->GetY();
         $this->SetX(25);          
         //$this->MultiCell(90,20,'',1,1,'L',1);
         $this->SetY($Y+10);
//         $this->SetFont('Arial','B',7);
//         $this->ln(18);
//         $this->SetX(25);   
//         $this->Row(array(utf8_decode('LCDA. YANIRA MENDEZ ZERPA'),utf8_decode('LCDA. RAISA BRICEÑO MAVARES')),0,0);
//         $this->SetX(25); 
//         $this->Row(array(utf8_decode('SUB-SECRETARIA DE PRESUPUESTO'),utf8_decode('SECRETARIA DE ADMINISTRACÍON Y FINANZAS')),0,0);
         $this->SetY($Y);
         $this->SetX(115);
         //$this->MultiCell(90,20,'',1,1,'L',1);  
         $this->SetY($Y);
                 

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

   
    function getConsulta(){

          $conex = new ConexionComun();     
      $sql = " SELECT  inicial||'-'||tx_rif as tx_rif,tx_razon_social,tb205.co_orden_pago,tb060.tx_serial,tb062.mo_pendiente,tb205.co_solicitud,
                       to_char(fe_desafectacion,'dd') as dia,
                       to_char(fe_desafectacion,'mm') as mes,
                       to_char(fe_desafectacion,'yyyy') as anio
                  FROM tb205_desafectacion as tb205
                  inner join tb060_orden_pago as tb060 on tb060.co_orden_pago = tb205.co_orden_pago
                  inner join tb026_solicitud as tb026 on tb026.co_solicitud = tb060.co_solicitud
                  inner join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb060.co_solicitud
                  left join tb008_proveedor tb008 on tb008.co_proveedor = tb026.co_proveedor
                  left join tb007_documento tb007 on tb007.co_documento = tb008.co_documento
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb205.co_solicitud 
                  where tb030.co_ruta = ".$_GET['codigo']." order by co_desafectacion desc";
           //echo var_dump($sql); exit();             
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];  
	
    }
    function getTraspaso(){

        $conex = new ConexionComun();     
        $sql = "SELECT  inicial||'-'||tx_rif as tx_rif,tx_razon_social,tb205.co_orden_pago,tb060.tx_serial,tb062.mo_pendiente,tb205.co_solicitud,
                       to_char(fe_desafectacion,'dd') as dia,
                       to_char(fe_desafectacion,'mm') as mes,
                       to_char(fe_desafectacion,'yyyy') as anio
                  FROM tb205_desafectacion as tb205
                  inner join tb060_orden_pago as tb060 on tb060.co_orden_pago = tb205.co_orden_pago
                  inner join tb026_solicitud as tb026 on tb026.co_solicitud = tb060.co_solicitud
                  inner join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb060.co_solicitud
                  left join tb008_proveedor tb008 on tb008.co_proveedor = tb026.co_proveedor
                  left join tb007_documento tb007 on tb007.co_documento = tb008.co_documento
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb205.co_solicitud 
                  where tb030.co_ruta = ".$_GET['codigo']." order by co_desafectacion desc";
                        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }



}

$pdf=new PDF('P','mm','letter');
#Establecemos los márgenes izquierda, arriba y derecha:
//$pdf->SetMargins(30, 25 , 30);
#Establecemos el margen inferior:
//$pdf->SetAutoPageBreak(true, 5);
//#Margen inferior
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
//
//$pdf->Output($dir, 'F');


$pdf=new PDF('P','mm','letter');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
