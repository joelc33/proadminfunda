<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->datos = $this->getConsulta();

        $this->empresa = $this->getDatosEmpresa(1);
        
        if(!empty($this->empresa['tx_imagen_cen'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_cen'],  $this->empresa['centro_x'], $this->empresa['centro_y'], $this->empresa['centro_w']);
        }

        $this->SetFont('Arial','B',11);
        
      //  
        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode($this->empresa['nb_empresa']),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode($this->empresa['tx_rif']),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('MODIFICACIÓN PRESUPUESTARIA POR CRÉDITO ADICIONAL'),0,0,'C');
        
        $this->SetFont('Arial','',8);
        $this->Ln(8);

        //$this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
//        $this->Cell(0,0,utf8_decode('Maracaibo, '.$this->datos['dia'].' de '.mes($this->datos['mes']).' del '.$this->datos['anio']),0,0,'R');

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

         $this->Ln(1);
         $this->datos = $this->getConsulta();
           
         $this->line(1, 60, 220, 60);
         $this->SetFont('Arial','B',8);       
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetY(65);
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('MODIFICACIONES PRESUPUESTARIAS - DOCUMENTO NRO. '.$this->datos['nu_modificacion'])),1,1);
         $this->SetFillColor(255, 255, 255);         
         $this->SetFont('Arial','',7);   
         $this->SetWidths(array(20, 30, 25, 30, 95, 30,20,25));                 
         $this->SetAligns(array("L","L","L","L","L","L"));         
         $this->Row(array('Nro.OFICIO:',utf8_decode($this->datos['de_articulo_ley']), utf8_decode('FECHA:'), $this->datos['fe_modificacion'],''),1,1);                                    
         $this->SetWidths(array(20, 180));                 
         $this->SetAligns(array("L","L"));         
         $this->Row(array(utf8_decode('DESCRIPCIÓN:'),utf8_decode($this->datos['de_modificacion'])),1,1);                                    
         $this->SetFillColor(255, 255, 255);                  
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));      
         
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DATOS DE RAMO DE INGRESOS ORIDEN')),1,1); 
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(45,105,50)); 
         $this->SetAligns(array("C","C","C","C","C"));              
         $this->SetFont('Arial','B',6);
         $this->Row(array(utf8_decode('RAMO DE INGRESO'),utf8_decode('DENOMINACION'),utf8_decode('CREDITO ADICIONAL')),1,1);         
         $this->lista_traspaso_origen = $this->getTraspaso_origen();
         $totalcred = 0;
         $totaldeb  = 0;
          $this->SetAligns(array("L","L","R","R","R","R")); 
         foreach($this->lista_traspaso_origen as $key => $campo){ 
         if ($campo['credito']!=0){    
           $this->Row(array($campo['tx_partida'],utf8_decode($campo['tx_descripcion']),number_format($campo['credito'], 2, ',','.')),1,1);                  
         } 
         }
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $campo = "";
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DETALLES DE LA MODIFICACIÓN - PARTIDAS DESTINOS')),1,1); 
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(45,105,50)); 
         $this->SetAligns(array("C","C","C","C","C"));              
         $this->SetFont('Arial','B',6);
         $this->Row(array(utf8_decode('PARTIDA'),utf8_decode('DENOMINACION'),utf8_decode('CREDITO ADICIONAL')),1,1);   
         $this->SetFont('Arial','',6);      
         $this->lista_traspaso = $this->getTraspaso();
         $totalcred = 0;
         $totaldeb  = 0;
        $this->SetAligns(array("L","L","R","R","R","R")); 
        foreach($this->lista_traspaso as $key => $campo){ 
            if ($campo['credito']!=0){

                $this->Row(array($campo['co_categoria'],$campo['de_partida'],number_format($campo['credito'], 2, ',','.')),1,1);

                if($this->getY()>245){

                    $this->AddPage();
                    $this->Ln(7);
                    $this->setX(10);
                    $this->SetFillColor(255, 255, 255);
                    $this->SetWidths(array(45,55,50,50)); 
                    $this->SetAligns(array("C","C","C","C","C"));              
                    $this->SetFont('Arial','B',6);
                    $this->Row(array(utf8_decode('PARTIDA'),utf8_decode('DENOMINACION'),utf8_decode('CREDITO ADICIONAL')),1,1);   
                    $this->SetAligns(array("L","L","R","R","R","R"));
                    $this->SetFont('Arial','',6);

                }

            } 
        }
         
         $this->ln(8);
         $this->SetAligns(array("C","C", "C"));
	     $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(50,60,70));
         $this->SetFont('Arial','B',8);
         $this->SetX(25);
         $this->Row(array(utf8_decode('ELABORADO POR'),utf8_decode('COORDINACIÓN DE PRESUPUESTO'),utf8_decode('COORDINACIÓN GENERAL DE ADMINISTRACIÓN')),1,1);       
         $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L", "L","L"));
         $Y = $this->GetY();
         $this->SetX(25);
         $this->MultiCell(50,20,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(75);
         $this->MultiCell(60,20,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(135);
         $this->MultiCell(70,20,'',1,1,'L',1);
         $this->SetY($Y+16);
         $this->SetX(25);
         $this->SetFont('Arial','',6);
         $this->Row(array('Elaborado por:','Conformado por:','Autorizado por:'),1,1);          
        
//         $this->ln();
//         $this->SetAligns(array("C","C", "C"));
//	 $this->SetFillColor(201, 199, 199);
//         $this->SetWidths(array(140,60));
//         $this->SetFont('Arial','B',6);
//         $this->Row(array(utf8_decode('SECRETARIA DE PRESUPUESTO'),utf8_decode('MÁXIMA AUTORIDAD')),1,1);
//         $this->SetFillColor(255,255,255);
//         $this->SetWidths(array(50,40,50,60));
//         $this->SetAligns(array("L", "L","L","L"));
//         $this->Row(array('Elaborado por:'.$this->datos['nb_usuario'],'Conformado por: ','Autorizado por:','Autorizado por:'),1,1);
         
         $this->ln();
         
         $this->Cell(0,0,utf8_decode('Usuario del sistema: '.$this->datos['nb_usuario']),0,0,'L');
         $this->ln();
	 $this->SetY($this->GetY()+5);
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
      $sql = " SELECT   nu_modificacion, 
                        fe_modificacion, 
                        de_modificacion, 
                        nu_oficio, 
                        fe_oficio, 
                        de_articulo_ley, 
                        mo_modificacion, 
                        tb096.created_at, 
                        nb_usuario,
                        to_char(fe_oficio,'dd') as dia,
                        to_char(fe_oficio,'mm') as mes,
                        to_char(fe_oficio,'yyyy') as anio
                  FROM tb096_presupuesto_modificacion as tb096 
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb096.co_usuario                   
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb096.co_solicitud 
                  where tb030.co_ruta = ".$_GET['codigo'];
                        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];  
	
    }
    function getTraspaso_origen(){

          $conex = new ConexionComun();     
      $sql = " SELECT  tb064.tx_partida,   
        tb064.tx_descripcion,                    
        tb097.mo_disponible,
case when (id_tb098_tipo_distribucion = 1) then
                       (select t.mo_distribucion from tb097_modificacion_detalle as t where t.id = tb097.id)
                       else 0 end  as credito
                  FROM tb096_presupuesto_modificacion as tb096 
                  left join tb097_modificacion_detalle as tb097 on tb097.id_tb096_presupuesto_modificacion = tb096.id                     
                  left join tb064_presupuesto_ingreso as tb064 on tb064.co_presupuesto_ingreso = tb097.id_tb064_presupuesto_ingreso  
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb096.co_solicitud 
                  where id_tb098_tipo_distribucion = 1 and tb030.co_ruta = ".$_GET['codigo'];
                        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }
    function getTraspaso(){

          $conex = new ConexionComun();     
      $sql = " SELECT  tb085.co_partida,
                       tb085.co_categoria,
                       tb085.de_partida,
                       tb097.mo_disponible,
                       tb097.id_tb098_tipo_distribucion,
                       case when (id_tb098_tipo_distribucion = 2) then
                       (select t.mo_distribucion from tb097_modificacion_detalle as t where t.id = tb097.id)
                       else 0 end  as credito,
                       tb096.nu_modificacion
                  FROM tb096_presupuesto_modificacion as tb096 
                  left join tb097_modificacion_detalle as tb097 on tb097.id_tb096_presupuesto_modificacion = tb096.id
                  left join tb085_presupuesto as tb085 on tb085.id = tb097.id_tb085_presupuesto                  
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb096.co_usuario                   
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb096.co_solicitud 
                  where tb030.co_ruta = ".$_GET['codigo']." order by co_categoria ASC";
                        
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
//
//$pdf->AliasNbPages();
//$pdf->PrintChapter();
//$pdf->SetDisplayMode('default');
//$pdf->Output(); 

?>
