<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->datos = $this->getConsulta();

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
        $this->Ln(12);
        $this->SetFont('Arial', 'B', 13);
                
        $this->Cell(0,0,utf8_decode('TRASPASO DE CREDITO PRESUPUESTARIO'),0,0,'C');
    }

    function Footer() {
	$this->SetFont('Arial','',9);     
	$this->SetY(-20);
	$this->Cell(0,10,$this->PageNo().'/{nb}',0,0,'R');         
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
         $this->SetY(45);
         $this->SetX(25);
         $this->SetFillColor(255, 255, 255);
         $this->Row(array(utf8_decode('Nro. Traspaso: '.$this->datos['nu_modificacion'])),0,0); 
         $this->Ln(2);
         $this->SetX(25);
         $this->SetFillColor(255, 255, 255);
         $this->Row(array(utf8_decode('Fecha..............: '.$this->datos['fe_traspaso'])),0,0); 
         $this->Ln(2);   
         $this->SetFont('Arial','',9);  
         $this->SetX(25);         
         $inf = "De conformidad a lo establecido en el Art. 104 Numeral 1 sobre Traspasos de Creditos Presupuestarios del Reglamento Nro. 1 de la Ley de Organica de la Administración Financiera del Sector Publico sobre el Sistema Presupuestario, se efectúa el siguiente traspaso:"; 
         $this->MultiCell(180,7,utf8_decode($inf),0,1,'J',0);  
         
         $this->Ln();

         $this->SetWidths(array(60, 90, 30, 30)); 
         $this->SetAligns(array("L","L","R","C"));              
         $this->SetFont('Arial','B',8);
	     $this->SetFillColor(201, 199, 199);  
         $this->SetX(25);         
         $this->Row(array(utf8_decode('CODIGO PRESUPUESTARIO'),utf8_decode('DENOMINACION'),utf8_decode('MONTO Bs')),0,0);  
         $this->ln(1);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _'),0,0,'L');
         $this->ln(5);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode('CATEGORIA CEDENTE:'),0,0,'L');
         $this->ln(1);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _'),0,0,'L');
         $this->ln(5);
         $this->SetFillColor(255, 255, 255);         
         $this->lista_traspaso = $this->getTraspaso();
         $totalcred = 0;
         $totaldeb  = 0;
          $this->SetAligns(array("L","L","R","R")); 
         $this->SetFont('Arial','',8);          
         foreach($this->lista_traspaso as $key => $campo){          
            $Y = $this->GetY();
            if ($Y >= 230) {

                $this->AddPage();
                $this->Ln(5);
                 $this->SetWidths(array(60, 90, 30, 30)); 
                 $this->SetAligns(array("L","L","R","C"));              
                 $this->SetFont('Arial','B',8);
                     $this->SetFillColor(201, 199, 199);  
                 $this->SetX(25);         
                 $this->Row(array(utf8_decode('CODIGO PRESUPUESTARIO'),utf8_decode('DENOMINACION'),utf8_decode('MONTO Bs')),0,0);  
                 $this->ln(1);
                 $this->SetX(25);
                 $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _'),0,0,'L');
                 $this->ln(5);
                 $this->SetX(25);
                 $this->Cell(0,0,utf8_decode('CATEGORIA CEDENTE:'),0,0,'L');
                 $this->ln(1);
                 $this->SetX(25);
                 $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _'),0,0,'L');
                 $this->ln(5); 

            }
            $this->SetX(25);   
            if ($campo['debito']>0){
            $this->Row(array($campo['co_categoria'],$campo['de_partida'],number_format($campo['debito'], 2, ',','.')),0,0);         
            }
            $totalcred = $campo['credito'] + $totalcred;
            $totaldeb  = $campo['debito'] + $totaldeb;
         }
          $this->SetFont('Arial','B',8);
         $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _'),0,0,'R');
         $this->ln(3);
         
         $this->SetWidths(array(150,30,30)); 
         $this->SetAligns(array("R","R","R")); 
         $this->SetX(25);         
         $this->Row(array('TOTAL CEDENTE:',number_format($totaldeb, 2, ',','.')),0,0);   
                  $this->ln(1);
         $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _'),0,0,'R');
                  $this->ln(1);
         $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _'),0,0,'R');
         
         
         
         $this->ln(5);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode('CATEGORIA RECEPTORA:'),0,0,'L');
         $this->ln(1);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _'),0,0,'L');
         $this->ln(5);
         $this->SetFillColor(255, 255, 255);         
         $this->lista_traspaso = $this->getTraspaso();
         $totalcred = 0;
         $totaldeb  = 0;
          $this->SetAligns(array("L","L","R","R")); 
         $this->SetFont('Arial','',8);          
         foreach($this->lista_traspaso as $key => $campo){          
            $Y = $this->GetY();
            if ($Y >= 230) {

                $this->AddPage();
                $this->Ln(5);
                 $this->SetWidths(array(60, 90, 30, 30)); 
                 $this->SetAligns(array("L","L","R","C"));              
                 $this->SetFont('Arial','B',8);
                     $this->SetFillColor(201, 199, 199);  
                 $this->SetX(25);         
                 $this->Row(array(utf8_decode('CODIGO PRESUPUESTARIO'),utf8_decode('DENOMINACION'),utf8_decode('MONTO Bs')),0,0);  
                 $this->ln(1);
                 $this->SetX(25);
                 $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _'),0,0,'L');
                 $this->ln(5);
                 $this->SetX(25);
                 $this->Cell(0,0,utf8_decode('CATEGORIA RECEPTORA:'),0,0,'L');
                 $this->ln(1);
                 $this->SetX(25);
                 $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _'),0,0,'L');
                 $this->ln(5); 

            }
            $this->SetX(25);   
            if ($campo['credito']>0){
            $this->SetWidths(array(60, 90, 30, 30)); 
            $this->SetAligns(array("L","L","R","C"));              
            $this->SetFont('Arial','',8);
	    $this->SetFillColor(201, 199, 199);  
            $this->Row(array($campo['co_categoria'],$campo['de_partida'],number_format($campo['credito'], 2, ',','.')),0,0);         
            }
            $totalcred = $campo['credito'] + $totalcred;
            $totaldeb  = $campo['debito'] + $totaldeb;
         }
          $this->SetFont('Arial','B',8);
         $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _'),0,0,'R');
         $this->ln(3);
         
         $this->SetWidths(array(150,30,30)); 
         $this->SetAligns(array("R","R","R")); 
         $this->SetX(25);         
         $this->Row(array('TOTAL RECEPTORA:',number_format($totalcred, 2, ',','.')),0,0);   
                  $this->ln(1);
         $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _'),0,0,'R');
                  $this->ln(1);
         $this->Cell(0,0,utf8_decode('_ _ _ _ _ _ _ _ _ _ _ _'),0,0,'R');         
         
         $this->ln(18);
         
         $this->SetWidths(array(80,80)); 
         $this->SetAligns(array("C","C")); 
         $this->SetX(25);        
         $this->Row(array(utf8_decode('_______________________________'),'_______________________________'),0,0);
         $this->SetX(25);
         $this->Row(array(utf8_decode('ADMINISTRACIÓN'),'PRESUPUESTO'),0,0);           
         


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
                       to_char(fe_modificacion::date,'dd/mm/yyyy') as fe_traspaso,
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

    function getDatosEmpresa( $codigo){

        $sql = "SELECT co_empresa, nb_empresa, co_estado, co_municipio, tx_rif, tx_nit, nb_institucion,
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
