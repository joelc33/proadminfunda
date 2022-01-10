<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

 $this->datos0 = $this->getSolicitud();
        foreach($this->datos0 as $key => $soli){ }
        $this->Image("imagenes/escudosanfco.png", 167, 7,20);

        $this->SetFont('Arial','B',8);
        

        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
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
        //$this->Row(array('','Fecha de Impresion.: ',date('d/m/Y')),0,0); 
        $this->Row(array('','Codigo de Solicitud.: ',$soli['co_solicitud']),0,0); 
//        $this->Row(array('','Codigo del Acta.: ',$va['co_reporte']),0,0); 

        $this->Ln(4);
        $this->SetFont('Arial','B',14);
        $this->Cell(0,0,utf8_decode('ACTA DE TRASPASO DE BIENES'),0,0,'C');
         
    //    $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        
        $this->Ln(5);
        $this->SetTextColor(0,0,0);
        $this->SetX(1);

        $this->Ln(2);
       

    }

    function Footer() {
 // $this->SetY(200);
  //$this->PiePagina();
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
    function Cabezera(){
    $this->Ln();
   
           $this->SetFont('Arial','B',10);
         $this->SetWidths(array(334));
         $this->SetAligns(array("L"));
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DESCRIPCIONES Y ESPECIFICACIONES DE LOS BIENES')),1,1);
         $this->SetFillColor(230, 230, 230);
        $this->SetWidths(array(15,70,45,45,40,40,40,39)); 
         $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
         $this->SetFont('Arial','',6);
         $this->Row(array(utf8_decode('Codigo'),utf8_decode('Especificación'),utf8_decode('Ubicación Receptora'),utf8_decode('Ubicación Anterior'),utf8_decode('Tipo Traslado') ,utf8_decode('documento') ,utf8_decode('Fecha') ,utf8_decode('Monto')),1,1); 

    }
    
    function Row2($data,$borde=0,$pintar=0)
    {
        //Calculate the height of the row
        $nb=0;
        $height = array();
        for($i=0;$i<count($data);$i++){
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        }
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            if($this->NbLines($this->widths[$i],$data[$i])<$nb){
                $height[$i]=5*$nb;
            }else{
                $height[$i]=5;
            }
            
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            if($borde==1)
                $this->Rect($x,$y,$w,$h);
            //Print the text
            //$this->MultiCell($w,$height[$i],$data[$i],$borde,$a,$pintar);
            $this->MultiCell($w,5,$data[$i],0,$a); //standar
    
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }


    function ChapterBody() {

         // $this->SetY(60);
         $i=true;
          if($i){
          $this->cabezera();
          $i=false;
          }else{
             $this->addPage();
             if($this->getY()>150){

          $this->addPage();
          $this->cabezera();
         }else{
          $this->cabezera();
         }
          }
         $suma=0;
         $this->datos2 = $this->getBienes();
         //$i=0;
         foreach($this->datos2 as $key => $valores){

          $this->SetFillColor(255, 255, 255);
          $this->SetWidths(array(15,70,45,45,40,40,40,39));  
          $this->SetAligns(array("C","L","C","C","L","L","C","R","C","C"));
          $d=date_create($valores['fecha']);
          $this->Row2(array(utf8_decode($valores['nu_bienes']),utf8_decode($valores['tx_detalle']),utf8_decode($valores['tx_organigrama']),utf8_decode($valores['ubi']),utf8_decode($valores['tx_subtipo_movimiento']),utf8_decode($valores['desc_documento']),date_format($d,'d/m/Y'),utf8_decode($valores['nu_monto']) ),1,1); 
          //$arr=array(utf8_decode($valores['nu_bienes']),utf8_decode($valores['tx_detalle']),utf8_decode($valores['tx_marca']),utf8_decode($valores['tx_modelo']),utf8_decode($valores['tx_organigrama']),utf8_decode($valores['ubi']),utf8_decode($valores['tx_subtipo_movimiento'].'sdddddddddddddddddddddddddddddddd'),utf8_decode($valores['desc_documento']),date_format($d,'d/m/Y'),date_format($d,'g:i:s a') );
          //$this->MultiCell($i+5,5,$arr[$i],1,'L');
          //$i++;
          //$this->ln(10);
          $suma=$suma+$valores['nu_monto'];
          if($this->getY()>170){

          $this->addPage();
          $this->cabezera($campo['de_ejecutor']);
         }
         
        }
         $this->SetFont('Arial','B',9);
         $this->SetAligns(array("L","R","L")); 
        $this->SetWidths(array(250,70,70));
        $this->Row(array('','MONTO TOTAL.: ',number_format($suma, 2, ',','.')." Bs.S"),0,0);        
        //$this->PiePagina();


        



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
          $this->Row(array(utf8_decode($val['nb_usuario']),utf8_decode('Lic. Lu Betania')),1,1);

          $this->SetFillColor(230, 230, 230);
          $this->SetWidths(array(83,84,83,84));
         $this->SetAligns(array("C","C","C","C"));
          $this->Row(array(utf8_decode('Firma - Sello'),utf8_decode('Fecha'),utf8_decode('Firma - Sello'),utf8_decode('Fecha')),1,1);
          $this->SetFont('Arial','',10);
          $this->SetFillColor(255, 255, 255);
          $this->Row(array('','','',''),1,1);
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
function getSolicitud(){

          $conex = new ConexionComun();     
          $sql = "SELECT co_solicitud FROM tb030_ruta WHERE co_ruta=$_GET[codigo] ";
                  
          //echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;                          
         
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
          $sql = "SELECT
                 (SELECT co_ejecutor FROM tb173_movimiento_bienes WHERE co_bienes=tb173.co_bienes AND co_movimiento_bienes<tb173.co_movimiento_bienes AND in_activo=true ORDER BY co_movimiento_bienes DESC LIMIT 1) as co_ejecutor
                 FROM tb173_movimiento_bienes as tb173 
                 JOIN tb030_ruta AS tb030 ON tb030.co_solicitud=tb173.co_solicitud
                 WHERE tb030.co_ruta=$_GET[codigo] 
                 GROUP BY 1
                 ORDER BY 1";
                  
          //echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;                          
         
    }

      function getEjecutor2($id){

          $conex = new ConexionComun();
          $sql = "SELECT  de_ejecutor FROM tb082_ejecutor  WHERE id=$id";
                  
          //echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;                          
         
    }

        function getBienes(){

          $conex = new ConexionComun();     
          $sql = "SELECT tb171.nu_bienes,tb174.tx_marca,
          tb175.tx_modelo,tb171.tx_detalle,tb001.nb_usuario,tbbn008.created_at as fecha
          ,tbbn006.tx_organigrama,tbbn004.tx_subtipo_movimiento,tbbn005.desc_documento,tbbn006ant.tx_organigrama AS ubi,tb171.nu_monto

        FROM tb173_movimiento_bienes AS tb173
        JOIN tb171_bienes AS tb171 ON tb171.co_bienes=tb173.co_bienes
        JOIN tb001_usuario AS tb001 ON tb001.co_usuario=tb173.co_usuario
        LEFT JOIN tb175_modelo AS tb175 ON tb175.co_modelo=tb171.co_modelo
        LEFT JOIN tb174_marca AS tb174 ON tb174.co_marca=tb175.co_marca    
        JOIN tbbn008_documento_bienes AS tbbn008 ON tbbn008.co_documento_bienes=tb173.co_documento
        JOIN tbbn006_organigrama AS tbbn006 ON tbbn006.co_organigrama=tbbn008.co_ubicacion
        JOIN tbbn004_subtipo_movimiento_bienes AS tbbn004 ON tbbn004.co_subtipo_movimiento_bienes=tbbn008.co_subtipo_movimiento
        JOIN tbbn005_tipo_documento AS tbbn005 ON tbbn005.co_documento=tbbn008.co_tipo_documento
        JOIN tb030_ruta AS tb030 ON tb030.co_solicitud=tbbn008.co_solicitud
        JOIN tbbn008_documento_bienes AS tbbn008ant ON tbbn008ant.co_documento_bienes=tb173.co_documento_ant
        JOIN tbbn006_organigrama AS tbbn006ant ON tbbn006ant.co_organigrama=tbbn008ant.co_ubicacion
        WHERE tb030.in_actual=true and tbbn008.co_tipo_documento = 2
      AND tb030.co_ruta=$_GET[codigo]  
      ORDER BY tbbn006.tx_organigrama,tb171.tx_detalle";
                  
          //echo var_dump($sql); exit();
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
