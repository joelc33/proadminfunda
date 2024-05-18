<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

 $this->datos0 = $this->getEjecutor();
        foreach($this->datos0 as $key => $soli){ }
        $this->Image("imagenes/escudosanfco.png", 167, 7,20);

        $this->SetFont('Arial','B',8);
        

        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('<NOMBRE DE LA INSTITUCION>'),0,0,'C');
        //$this->Ln(4);
        //$this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACION Y FINANZAS'),0,0,'C');
       
       /*$this->Ln(2);
        $this->SetFont('Arial','',9);
        $this->SetAligns(array("L","L","L"));
        $this->SetWidths(array(160,20,20));
        $this->Row(array('',' Nro.:',''),0,0); */
        $this->re = $this->getReporte();
        foreach($this->re as $key => $va){}
        $this->Ln(4);
        $this->SetAligns(array("L","R"));
        $this->SetWidths(array(250,50,34));
        $this->Row(array('','Fecha de Impresion.: ',date('d/m/Y')),0,0); 
        $this->Row(array('','Codigo de Solicitud.: ',$soli['co_solicitud']),0,0); 
        $this->Row(array('','Codigo del Acta.: ',$va['co_reporte']),0,0); 

        $this->Ln(4);
        $this->SetFont('Arial','B',14);
        $this->Cell(0,0,utf8_decode('ACTA DE REGISTRO DE INMUEBLE'),0,0,'C');
         
    //    $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        
        $this->Ln(5);
        $this->SetTextColor(0,0,0);
        $this->SetX(1);

        $this->Ln(2);
       

    }

    function Footer() {
 // $this->SetY(200);
  $this->PiePagina();
  $this->SetY(-20);
	$this->SetFont('Arial','',9);  
    $this->SetFont('Arial','',10); 
  $this->Cell(-334,15,$this->PageNo(),0,0,'C');      
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
    function Cabezera($nombre,$fecha){
    $this->Ln();
         $this->SetFont('Arial','B',10);
         $this->SetWidths(array(334));
         $this->SetAligns(array("L","L","L","L"));
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('INDENTIFICACIÓN')),1,1);


         $this->SetFillColor(230, 230, 230);
         $this->SetWidths(array(234,100)); 
         $this->SetAligns(array("L","L"));
         $this->SetFont('Arial','',9);
         $this->Row(array(utf8_decode('DOCUMENTO'),utf8_decode('FECHA CREACIÓN')),1,1); 
         $fecha=date_format(date_create($fecha),'d/m/Y');
         $this->Row(array($nombre,$fecha),1,0); 
   
           $this->SetFont('Arial','B',10);
         $this->SetWidths(array(334));
         $this->SetAligns(array("L"));
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DESCRIPCIONES Y ESPECIFICACIONES DE LOS BIENES')),1,1);
         $this->SetFillColor(230, 230, 230);
         $this->SetWidths(array(15,99,80,20,80,40)); 
         $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C"));
         $this->SetFont('Arial','',6);
         $this->Row(array(utf8_decode('Codigo'),utf8_decode('Especificación'),utf8_decode('Dirección'),utf8_decode('Tipo'),utf8_decode('Clasificación'),utf8_decode('Avaluo')),1,1); 

    }
    function ChapterBody() {

         $this->datos = $this->getEjecutor();
         // $this->SetY(60);
         $i=true;
         foreach($this->datos as $key => $campo){ 
          if($i){
          $this->cabezera($campo['desc_documento'],$campo['created_at']);
          $i=false;
          }else{
            $this->addPage();
          if($this->getY()>100){

          $this->addPage();
          $this->cabezera($campo['desc_documento'],$campo['created_at']);
         }else{
          $this->cabezera($campo['desc_documento'],$campo['created_at']);
         }
          }
         
         $this->datos2 = $this->getBienes($campo['co_documento_bienes']);
         foreach($this->datos2 as $key => $valores){
          $this->SetFillColor(255, 255, 255);
          $this->SetWidths(array(15,99,80,20,80,40)); 
          $this->SetAligns(array("C","L","L","C","L","R"));
          $this->Row(array(utf8_decode($valores['nu_bienes']),utf8_decode($valores['tx_detalle']),utf8_decode($valores['tx_direccion']),utf8_decode($valores['tx_tipo_inmueble']),utf8_decode($valores['tx_clasificacion_inmueble']),number_format($valores['nu_avaluo_act'], 2, ',','.').' Bs.S' ),1,1); 
          //$this->ln(10);

          if($this->getY()>120){

          $this->addPage();
          $this->cabezera($campo['desc_documento'],$campo['created_at']);
         }
         
        }
        //$this->PiePagina();


        }



 //$this->SetWidths(array(334));

 //$this->SetAligns(array("C"));
//$this->Row(array(''),1,1);

        // echo var_dump($sql); exit();
         
         //$this->Cell(0,0,'Elaborado por: '.$this->datos['nb_usuario'],0,0,'L');
        // $this->ln();
	       // $this->SetY($this->GetY()+5);

         

    }

  function PiePagina(){
  $this->datos3 = $this->getEjecutor();
        foreach($this->datos3 as $key => $val){ }
         $this->Ln(8);
         $this->SetFont('Arial','B',10);
         $this->SetWidths(array(334));
         $this->SetAligns(array("L"));
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('CONFORMIDAD CONTROL PERCEPTIVO')),1,1);
         $this->SetFillColor(230, 230, 230);
          $this->SetWidths(array(167,167));
         $this->SetAligns(array("L","L"));
          $this->Row(array(utf8_decode('Elaborado por:'),utf8_decode('Jefe de la Unidad:')),1,1);
          $this->SetFont('Arial','',10);
          $this->SetFillColor(255, 255, 255);
          $this->Row(array(utf8_decode($val['nb_usuario']),utf8_decode('Econ. Lu Betania')),1,1);

          $this->SetFillColor(230, 230, 230);
          $this->SetWidths(array(83,84,83,84));
         $this->SetAligns(array("C","C","C","C"));
          $this->Row(array(utf8_decode('Firma - Sello'),utf8_decode('Fecha'),utf8_decode('Firma - Sello'),utf8_decode('Fecha')),1,1);
          $this->SetFont('Arial','',10);
          $this->SetFillColor(255, 255, 255);
          $this->Row(array('

            ','','',''),1,0);
            $this->ln();

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
    function getReporte(){

      $conex = new ConexionComun();     
      $sql = "SELECT  tbbn016.co_reporte
      FROM tb026_solicitud AS tb026
      JOIN tb030_ruta AS tb030 ON tb030.co_solicitud=tb026.co_solicitud
      JOIN tbbn016_reporte AS tbbn016 ON tb026.co_solicitud=tbbn016.co_solicitud
      WHERE tb030.in_actual=true AND tb030.co_ruta=$_GET[codigo]";
              
      //echo var_dump($sql); exit();
      $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
      return  $datosSol;                          
     
}
    function getEjecutor(){

          $conex = new ConexionComun();     
          $sql = "SELECT tb001.nb_usuario,tb026.co_solicitud,tbbn004.tx_subtipo_movimiento,tbbn005.desc_documento,tbbn008.co_documento_bienes,tbbn008.created_at
          FROM tbbn008_documento_bienes AS tbbn008
          JOIN tb026_solicitud AS tb026 ON tb026.co_solicitud=tbbn008.co_solicitud
          JOIN tb001_usuario AS tb001 ON tb001.co_usuario=tb026.co_usuario
          JOIN tb030_ruta AS tb030 ON tb030.co_solicitud=tb026.co_solicitud
          JOIN tbbn004_subtipo_movimiento_bienes AS tbbn004 ON tbbn004.co_subtipo_movimiento_bienes=tbbn008.co_subtipo_movimiento
          JOIN tbbn005_tipo_documento AS tbbn005 ON tbbn005.co_documento=tbbn008.co_tipo_documento
          JOIN tb172_tipo_movimiento_bienes AS tb172 ON tb172.co_tipo_movimiento_bienes=tbbn004.co_tipo_movimiento_bienes
          WHERE tb030.in_actual=true AND tb030.co_ruta=$_GET[codigo]
          GROUP BY tb001.nb_usuario,tb026.co_solicitud,tbbn004.tx_subtipo_movimiento,tbbn005.desc_documento,tbbn008.co_documento_bienes";
                  
          //echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;                          
         
    }

        function getBienes($id){

          $conex = new ConexionComun();     
          $sql = "SELECT tb171.nu_bienes,tb171.tx_detalle,tb171.tx_direccion,tbbn012.tx_clasificacion_inmueble,tbbn014.tx_tipo_inmueble,tb171.nu_avaluo_act
        FROM tb171_bienes AS tb171
        JOIN tbbn012_clasificacion_inmueble AS tbbn012 ON tbbn012.co_clasificacion_inmueble=tb171.co_clasificacion_inmueble
        JOIN tbbn014_tipo_inmueble AS tbbn014 ON tbbn014.co_tipo_inmueble=tb171.co_tipo_inmueble
        LEFT JOIN tb173_movimiento_bienes AS tb173 ON tb171.co_bienes=tb173.co_bienes
        WHERE tb173.co_documento=$id";
                  
         // echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;                          
         
    }



}

$pdf=new PDF('L','mm','legal');
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



$pdf=new PDF('L','mm','legal');
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();


?>
