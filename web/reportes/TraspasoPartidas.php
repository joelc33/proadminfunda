<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->datos = $this->getConsulta();

        $this->Image("imagenes/escudosanfco.jpg", 100, 7,20);

        $this->SetFont('Arial','B',10);
        
      //  
        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('RIF. G-200005297'),0,0,'C');          
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('COORDINACIÓN GENERAL DE ADMINISTRACIÓN'),0,0,'C');    
        
        $this->SetFont('Arial','',8);
        $this->Ln(6);

        //$this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->Cell(0,0,utf8_decode('San Francisco, '.$this->datos['dia'].' de '.mes($this->datos['mes']).' del '.$this->datos['anio']),0,0,'R');
        
        $this->Ln(10);
        $this->SetFont('Arial','B',11);        
        $this->Cell(0,0,utf8_decode('TRASPASOS DE CREDITO PRESUPUESTARIO'),0,0,'C');
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
         $this->Row(array(utf8_decode('NRO. '.$this->datos['nu_modificacion'])),0,0); 
         $this->Ln(10);   
         $this->SetFont('Arial','',10);  
         $this->SetX(25);         
         $inf = "De conformidad con el artículo No. 8, de las Disposiciones Generales de la Ordenanza de Presupuesto para el ejercicio fiscal ".date("Y", strtotime($this->datos['fe_modificacion'])).", se efectúa traspaso de crédito presupuestario detallado a continuación:"; 
         $this->MultiCell(180,7,utf8_decode($inf),0,1,'J',0);  
         
         $this->Ln();

         $this->SetWidths(array(60, 60, 30, 30)); 
         $this->SetAligns(array("C","C","C","C"));              
         $this->SetFont('Arial','B',8);
	     $this->SetFillColor(201, 199, 199);  
         $this->SetX(25);         
         $this->Row(array(utf8_decode('CATEGORIA PRESUPUESTARIA'),utf8_decode('DENOMINACION'),utf8_decode('CEDENTE'),utf8_decode('RECEPTORA')),1,1);         
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

                /*$this->SetY(230);
                $this->SetX(25);    
                //$this->Row(array(utf8_decode('SUBSECRETARIA DE PRESUPUESTO'),utf8_decode('SECRETARIA DE ADMINISTRACION')),1,1);         
                $this->SetFillColor(255,255,255);
                $Y = $this->GetY();
                $this->SetX(25);          
                //$this->MultiCell(90,20,'',1,1,'L',1);
                $this->SetY($Y+10);
                $this->SetFont('Arial','B',7); 
                $this->SetX(25);   
                $this->Row(array(utf8_decode('LCDA. YANIRA MENDEZ ZERPA'),utf8_decode('LCDA. RAISA BRICEÑO MAVARES')),0,0);
                $this->SetX(25); 
                $this->Row(array(utf8_decode('SUB-SECRETARIA DE PRESUPUESTO'),utf8_decode('SECRETARIA DE ADMINISTRACÍON Y FINANZAS')),0,0);
                $this->SetY($Y);
                $this->SetX(115);
                //$this->MultiCell(90,20,'',1,1,'L',1);  
                $this->SetY($Y);*/
                        
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
                $this->SetWidths(array(55, 55, 40, 40)); 
                $this->SetAligns(array("C","C","C","C"));              
                $this->SetFont('Arial','B',8);
                $this->SetFillColor(201, 199, 199);  
                $this->SetX(25);         
                $this->Row(array(utf8_decode('CATEGORIA'),utf8_decode('DENOMINACION'),utf8_decode('CEDENTE'),utf8_decode('RECEPTORA')),1,1); 
                $this->SetFillColor(255, 255, 255);   
                $this->SetAligns(array("C","C","C","C"));
                $this->SetFont('Arial','',7); 

            }
            $this->SetX(25);             
            $this->Row(array($campo['co_categoria'],$campo['de_partida'],number_format($campo['debito'], 2, ',','.'),number_format($campo['credito'], 2, ',','.')),1,1);         
            $totalcred = $campo['debito'] + $totalcred;
            $totaldeb  = $campo['credito'] + $totaldeb;
         }

         $this->SetFont('Arial','B',8);         
         $this->SetWidths(array(120,30,30)); 
         $this->SetAligns(array("R","R","R")); 
         $this->SetX(25);         
         $this->Row(array('TOTAL',number_format($totalcred, 2, ',','.'),number_format($totaldeb, 2, ',','.')),1,1);         
         
         $this->ln(8);
         $this->SetAligns(array("C","C", "C"));
	     $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(65,90,65));
         $this->SetFont('Arial','B',8);
         $this->SetX(35);
         $this->Row(array(utf8_decode('COORDINACIÓN DE PRESUPUESTO'),utf8_decode('COORDINACIÓN GENERAL DE ADMINISTRACIÓN')),1,1);       
         $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L", "L","L"));
         $Y = $this->GetY();
         $this->MultiCell(65,14,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(75);
         $this->MultiCell(70,14,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(145);
         $this->MultiCell(65,14,'',1,1,'L',1);
         $this->SetY($Y+5);
         $this->SetFont('Arial','',6);
         $this->ln(8);
         $this->Row(array('Solicitado por:','Registrado por:', 'Aprobado por:'),1,1);         

//         $this->SetAligns(array("C","C", "C"));
//	     $this->SetFillColor(201, 199, 199);
//         $this->SetWidths(array(90,90));
//         $this->SetFont('Arial','B',8); 
//
//         $this->SetY(230);
//         $this->SetX(25);    
//         //$this->Row(array(utf8_decode('SUBSECRETARIA DE PRESUPUESTO'),utf8_decode('SECRETARIA DE ADMINISTRACION')),1,1);         
//         $this->SetFillColor(255,255,255);
//         $Y = $this->GetY();
//         $this->SetX(25);          
//         //$this->MultiCell(90,20,'',1,1,'L',1);
//         $this->SetY($Y+10);
//         $this->SetFont('Arial','B',7);
//         $this->ln(18);
//         $this->SetX(25);   
//         $this->Row(array(utf8_decode('LCDA. ISBELIA YUGURI'),utf8_decode('LCD0. AROLDO DIAZ')),0,0);
//         $this->SetX(25); 
//         $this->Row(array(utf8_decode('COORDINACIÓN DE PRESUPUESTO'),utf8_decode('COORDINACIÓN GENERAL DE ADMINISTRACIÓN')),0,0);
//         $this->SetY($Y);
//         $this->SetX(115);
//         //$this->MultiCell(90,20,'',1,1,'L',1);  
//         $this->SetY($Y);
                 
         //$this->ln(25);
         $this->SetY(270);
         $this->SetFont('Arial','',8); 
         $this->SetX(25);          
         $this->Cell(0,0,utf8_decode('Usuario del sistema: '.$this->datos['nb_usuario']),0,0,'L');
         $this->ln(3);
         $this->SetX(25);          
         $this->Cell(0,0,utf8_decode('Nro. Solicitud: '.$this->datos['co_solicitud']),0,0,'L');
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
      $sql = " SELECT  nu_modificacion, 
                       fe_modificacion, 
                       de_modificacion, 
                       nu_oficio, 
                       fe_oficio, 
                       de_articulo_ley, 
                       mo_modificacion, 
                       tb096.created_at, 
                       nb_usuario,
                       tb030.co_solicitud,
                       to_char(fe_modificacion,'dd') as dia,
                       to_char(fe_modificacion,'mm') as mes,
                       to_char(fe_modificacion,'yyyy') as anio
                  FROM tb096_presupuesto_modificacion as tb096 
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb096.co_usuario                   
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb096.co_solicitud 
                  where tb030.co_ruta = ".$_GET['codigo'];
                        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];  
	
    }
    function getTraspaso(){

        $conex = new ConexionComun();     
        $sql = " SELECT  tb085.co_partida,
                       tb085.co_categoria as co_categoria,
                       tb085.de_partida,
                       tb085.mo_disponible,
                       tb097.id_tb098_tipo_distribucion,
                       case when (tb097.id_tb098_tipo_distribucion = 1) then
                       (select t.mo_distribucion from tb097_modificacion_detalle as t where t.id = tb097.id)
                       else 0 end as debito,
                       case when (id_tb098_tipo_distribucion = 2) then
                       (select t.mo_distribucion from tb097_modificacion_detalle as t where t.id = tb097.id)
                       else 0 end  as credito
                  FROM tb096_presupuesto_modificacion as tb096 
                  left join tb097_modificacion_detalle as tb097 on tb097.id_tb096_presupuesto_modificacion = tb096.id
                  left join tb085_presupuesto as tb085 on tb085.id = tb097.id_tb085_presupuesto     
                  left join tb084_accion_especifica as tb084 on tb084.id  = tb085.id_tb084_accion_especifica
                  left join tb083_proyecto_ac as tb083 on tb083.id = tb084.id_tb083_proyecto_ac
                  left join tb082_ejecutor as tb082 on tb082.id  = tb083.id_tb082_ejecutor                  
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb096.co_usuario                   
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb096.co_solicitud
                  left join tb080_sector as tb080 on tb080.id = tb083.id_tb080_sector 
                  where tb030.co_ruta = ".$_GET['codigo'];
                        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }



}

$pdf=new PDF('P','mm','letter');
#Establecemos los márgenes izquierda, arriba y derecha:
//$pdf->SetMargins(30, 25 , 30);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true, 5);
#Margen inferior
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
//
//$pdf->AliasNbPages();
//$pdf->PrintChapter();
//$pdf->SetDisplayMode('default');
//$pdf->Output(); 

?>
