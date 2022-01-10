<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        //$this->datos0 = $this->getEjecutor();
        //foreach($this->datos0 as $key => $soli){ }
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
        //$_GET[incorporado] 
        $inco=$_GET['incorporado']; 
        $this->Ln(2);
         $this->SetAligns(array("L","R","C"));
         $this->SetWidths(array(250,50,34));
           $this->Row(array('','','BM-3'),0,0);
        $this->SetAligns(array("L","R","L"));
        $this->SetWidths(array(250,46,40));
//        $this->Row(array('','Fecha de Impresion.: ',date('d/m/Y')),0,0); 
        $fecha_ini=date_format(date_create($_GET['fe_inicio']),'d/m/Y');
        $fecha_fin=date_format(date_create($_GET['fe_fin']),'d/m/Y');
        $this->Row(array('','Rango de Fechas.: ',"Del ".$fecha_ini." al ". $fecha_fin),0,0); 
       // $this->Row(array('','Documento.: ',''),0,0); 
        // $this->Row(array('','Inventario.: ',''),0,0); 

        $this->Ln(4);
        $this->SetFont('Arial','B',14);
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('RELACION DE BIENES MUEBLES FALTANTES'),0,0,'C');
         
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
         /*$this->SetFont('Arial','B',10);
         $this->SetWidths(array(334));
         $this->SetAligns(array("L"));
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('INDENTIFICACION DE LA UNIDAD ADMINISTRATIVA')),1,1);


         $this->SetFillColor(230, 230, 230);
         $this->SetWidths(array(334)); 
         $this->SetAligns(array("L"));
         $this->SetFont('Arial','',9);
         $this->Row(array(utf8_decode('Nombre ')),1,1); 
         $this->Row(array($nombre ),1,0);*/ 
         $this->datos4 = $this->getEjecutor();
         foreach($this->datos4 as $key => $val){ }
         $this->SetFont('Arial','',8);
         $this->SetWidths(array(167,167));
         $this->SetAligns(array("L","L","L"));
             $this->SetFillColor(255, 255, 255);
         $this->Row(array(utf8_decode("UBICACION: $val[tx_organigrama]" ),utf8_decode("CODIGO: $val[cod_adm]")),1,1);
         $this->SetWidths(array(334));
         $this->SetAligns(array("L"));
         $this->Row(array(utf8_decode("DIRECCIÓN: $val[tx_direccion]")),1,1);
         $this->Row(array(utf8_decode('OBSERVACIÓN: ')),1,1);

           $this->SetFont('Arial','B',10);
         $this->SetWidths(array(334));
         $this->SetAligns(array("L"));
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DESCRIPCIONES Y ESPECIFICACIONES DE LOS BIENES')),1,1);

       

         $this->SetFillColor(230, 230, 230);
         $this->SetWidths(array(80,15,15,84,60,30,20,30)); 
         $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C"));
         $this->SetFont('Arial','',6);
         $this->Row(array(utf8_decode('Grupo.Subgrupo.Producto'),utf8_decode('Cantidad'),utf8_decode('Nro Bien'),utf8_decode('Especificación'),utf8_decode('Observación'),utf8_decode('Documento'),utf8_decode('Fecha Mov'),utf8_decode('Valor Bs.S')),1,1); 

    }
    function ChapterBody() {

         //$this->datos = $this->getEjecutor();
         // $this->SetY(60);
         $i=true;
         //foreach($this->datos as $key => $campo){ 
          if($i){
          $this->cabezera();
          $i=false;
          }else{
            $this->addPage();
          if($this->getY()>300){

          $this->addPage();
          $this->cabezera();
         }else{
          $this->cabezera();
         }
          }
         
         $this->datos2 = $this->getBienes();
         $j=0;
         $k=0;
         $suma=0;
         $resta=0;
         $total=0;
          foreach($this->datos2 as $c=> $v){
          $j++;
          }
          $k=$j;
          
         foreach($this->datos2 as $key => $valores){
          if($_GET["incorporado"]=='true'){
            $tipoi=$valores['tx_tipo_incorporacion'];
          }else{
            $tipoi=strtoupper($valores['tx_tipo_desincorporacion']);
          }
          $fecha=date_format(date_create($valores['fecha']),'d/m/Y');
          $monto=number_format($valores['nu_monto'], 2, ',','.');
          
          $this->SetFillColor(255, 255, 255);
          $this->SetWidths(array(80,15,15,84,60,30,20,30)); 
          $this->SetAligns(array("L","C","C","L","L","C","C","R"));
          if($valores['co_familia']){
            
            $this->Row2(array(utf8_decode($valores['co_familia']).chr(10).utf8_decode($valores['co_clase']).chr(10).utf8_decode($valores['cod_producto']),1,utf8_decode($valores['nu_bienes']),utf8_decode($valores['tx_detalle']),utf8_decode($valores['tx_observacion']),utf8_decode($valores['desc_documento']),utf8_decode($fecha),"$monto Bs.S"),1,1);
        
          }else{
            if($valores['tx_observacion']){
              $this->Row2(array($valores['cod_grupo'],1,utf8_decode($valores['nu_bienes']),utf8_decode($valores['tx_detalle']),utf8_decode($valores['tx_observacion']),utf8_decode($valores['desc_documento']),utf8_decode($fecha),"$monto Bs.S"),1,1);
            }else{
              $this->Row2(array($valores['cod_grupo'],1,utf8_decode($valores['nu_bienes']),utf8_decode($valores['tx_detalle']),utf8_decode($valores['tx_motivo']),utf8_decode($valores['desc_documento']),utf8_decode($fecha),"$monto Bs.S"),1,1);
            }
             
          }
          $suma=$suma+$valores['nu_monto'];  
          //$this->ln(10);
          $j--;
          
          if($this->getY()>170){

          $this->addPage();
          if($j>0){
         $this->cabezera();
          }
         }
         
        }
         if($this->getY()>100){

          $this->addPage();
         
          }
           $this->PiePagina($k,$suma,$resta);
         
       

//        }



 //$this->SetWidths(array(334));

 //$this->SetAligns(array("C"));
//$this->Row(array(''),1,1);

        // echo var_dump($sql); exit();
         
         //$this->Cell(0,0,'Elaborado por: '.$this->datos['nb_usuario'],0,0,'L');
        // $this->ln();
	       // $this->SetY($this->GetY()+5);

         

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
  function PiePagina($k,$suma,$resta){
  $this->datos3 = $this->getEjecutor();
        foreach($this->datos3 as $key => $val){ }
         $this->Ln(8);
                 $this->SetFont('Arial','B',9);
                 $this->SetAligns(array("L","R","L"));
                 $this->SetWidths(array(214,70,70));
                 $this->Row(array('','MONTO TOTAL.: ',number_format($suma, 2, ',','.')." Bs.S"),0,0); 
                 $this->Row(array('','BIENES TOTAL.: ',$k),0,0); 
         /*$this->Ln(6);
        $this->SetFont('Arial','',8);
         $this->SetWidths(array(167,167));
         $this->SetAligns(array("L","L","L"));
             $this->SetFillColor(255, 255, 255);
         $this->Row(array(utf8_decode("UBICACION: $val[tx_organigrama]" ),utf8_decode("CODIGO: $val[cod_adm]")),1,1);
         $this->SetWidths(array(334));
         $this->SetAligns(array("L"));
         $this->Row(array(utf8_decode("DIRECCIÓN: $val[tx_direccion]")),1,1);
         $this->Row(array(utf8_decode('OBSERVACIÓN: ')),1,1);

         $this->Ln(6);
         $this->SetFont('Arial','B',10);
         $this->SetWidths(array(334));
         $this->SetAligns(array("L"));
         $this->SetFillColor(201, 199, 199);

         $this->Row(array(utf8_decode('CONFORMIDAD CONTROL PERCEPTIVO')),1,1);
         $this->SetFillColor(230, 230, 230);
          $this->SetWidths(array(167,167));
         $this->SetAligns(array("L","L"));
          $this->Row(array(utf8_decode('Bienes de la dependencia:'),utf8_decode('Jefe de la Unidad:')),1,1);
          $this->SetFont('Arial','',10);
          $this->SetFillColor(255, 255, 255);
          $this->Row(array('',utf8_decode('Lic. Lu Betania')),1,1);

          $this->SetFillColor(230, 230, 230);
          $this->SetWidths(array(83,84,83,84));
         $this->SetAligns(array("C","C","C","C"));
          $this->Row(array(utf8_decode('Firma - Sello'),utf8_decode('Fecha'),utf8_decode('Firma - Sello'),utf8_decode('Fecha')),1,1);
          $this->SetFont('Arial','',10);
          $this->SetFillColor(255, 255, 255);
          $this->Row(array('

            ','','',''),1,0);
            $this->ln();*/

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

    function getEjecutor(){
         if($_GET["incorporado"]=='true'){
            $incor=1;
          }else{
            $incor=3;
          }
          $conex = new ConexionComun();     
          $sql = "SELECT tbbn006.co_organigrama,tbbn006.cod_adm, tbbn006.tx_organigrama,tbbn006.tx_direccion
          FROM tbbn006_organigrama AS tbbn006 
          WHERE 
          tbbn006.co_organigrama=$_GET[organigrama]
          ORDER BY tbbn006.tx_organigrama";
                  
          //echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;                          
         
    }

        function getBienes(){

          $conex = new ConexionComun();   
          $sql = "SELECT tb171.nu_bienes,tb048.tx_producto,tb174.tx_marca,tbbn004.tx_subtipo_movimiento,tbbn004.cod_mo||'-'||tbbn004.tx_subtipo_movimiento AS tx_subtipo_movimiento,
          tb175.tx_modelo,tb171.tx_detalle,tb173.tx_motivo,
           (tb048.cod_producto||'-'||tb048.tx_producto) as cod_producto,
           (tb092.id||'-'||tb092.de_clase_producto)  as  co_clase,
           (tb093.id||'-'||tb093.de_familia_producto)  as  co_familia,tbbn008.tx_observacion,
           tb171.cod_grupo,tbbn005.desc_documento,tbbn009.tx_uso,tb171.cod_grupo,tb172.co_tipo_movimiento_bienes,
           tbbn008.created_at as fecha,tb171.nu_monto
          FROM tb171_bienes AS tb171
          LEFT JOIN tb048_producto AS tb048 ON tb048.co_producto=tb171.co_producto
          LEFT JOIN tb092_clase_producto AS tb092 ON tb092.id=tb048.co_clase
          LEFT JOIN tb093_familia_producto AS tb093 ON tb093.id=tb092.id_tb093_familia_producto
          JOIN tb173_movimiento_bienes AS tb173 ON tb171.co_bienes=tb173.co_bienes
          LEFT JOIN tb175_modelo AS tb175 ON tb175.co_modelo=tb171.co_modelo
          LEFT JOIN tb174_marca AS tb174 ON tb174.co_marca=tb175.co_marca
          JOIN tbbn008_documento_bienes AS tbbn008 ON tbbn008.co_documento_bienes=tb173.co_documento
          JOIN tbbn006_organigrama AS tbbn006 ON tbbn006.co_organigrama=tbbn008.co_ubicacion
          JOIN tbbn004_subtipo_movimiento_bienes AS tbbn004 ON tbbn004.co_subtipo_movimiento_bienes=tbbn008.co_subtipo_movimiento
          JOIN tbbn005_tipo_documento AS tbbn005 ON tbbn005.co_documento=tbbn008.co_tipo_documento
          JOIN tb172_tipo_movimiento_bienes AS tb172 ON tb172.co_tipo_movimiento_bienes=tbbn004.co_tipo_movimiento_bienes
          LEFT JOIN tbbn009_uso AS tbbn009 ON  tbbn009.co_uso=tb171.co_uso
          WHERE tbbn008.created_at BETWEEN '$_GET[fe_inicio] 00:00:00' AND '$_GET[fe_fin] 24:00:00' AND tb171.co_tipo_bienes=1 
          AND tbbn006.co_organigrama=$_GET[organigrama]
          ORDER BY tbbn008.created_at,tbbn004.tx_subtipo_movimiento";
                  
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
