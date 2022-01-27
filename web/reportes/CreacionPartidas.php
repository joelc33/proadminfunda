<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->Image("imagenes/escudosanfco.jpg", 100, 7,20);

        $this->SetFont('Arial','B',10);
        $this->datos = $this->getConsulta2();
      //  
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        $this->Ln(5);
        $this->Cell(0,0,utf8_decode('RIF. G-200005297'),0,0,'C');        
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('COORDINACIÓN GENERAL DE ADMINISTRACIÓN'),0,0,'C');
        $this->Ln(8);
        $this->SetFont('Arial','B',12);        
        $this->Cell(0,0,utf8_decode('CREACION DE PARTIDA PRESUPUESTARIA'),0,0,'C'); 
        $this->SetFont('Arial','',8);
        $this->Ln(6);
        //$this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->Cell(0,0,utf8_decode('San Francisco, '.$this->datos['dia'].' de '.mes($this->datos['mes']).' del '.$this->datos['anio']),0,0,'R');
        
        $this->Ln(10);
        $this->SetFont('Arial','B',12);        
        //$this->Cell(0,0,utf8_decode('CREACION DE PARTIDA PRESUPUESTARIA'),0,0,'C');
             

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
         $this->SetFont('Arial','B',10);         
         $this->datos = $this->getConsulta();
         $nu_monto = number_format($this->datos['nu_monto'], 2, ',','.');

         $campo = $this->datos = $this->getConsulta();

         $this->SetFont('Arial','B',8);       
         $this->SetWidths(array(170));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->SetY(70);           
         $this->SetX(25);         
         $this->Row(array(utf8_decode('DATOS DE LA NUEVA PARTIDA')),1,1);

         foreach($this->datos as $key => $campo){
             
             if($this->getY()>200){
             $this->addPage();     
         $this->SetFont('Arial','B',8);       
         $this->SetWidths(array(170));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->SetY(70);           
         $this->SetX(25);         
         $this->Row(array(utf8_decode('DATOS DE LA NUEVA PARTIDA')),1,1);
	 }             
             
         $this->SetFillColor(255, 255, 255);         
         $this->SetFont('Arial','',7);   
         $this->SetWidths(array(65, 40, 20, 45));                 
         $this->SetAligns(array("C","C","C","C"));             
         $this->SetX(25);          
         $this->Row(array('Partida: ','Programa/Actividad','Fecha',utf8_decode('Monto de Asignación: ')),1,1);   
         $this->SetX(25);
          
         $this->SetX(25); 
         $this->Row(array($campo['tx_partida'],$campo['nu_proyecto_ac'].'/'.$campo['nu_accion_especifica'],$campo['fecha_creacion'],number_format($campo['nu_monto'])),1,1); 
         //}
         $this->SetAligns(array("C","C","C","C")); 
         $this->SetWidths(array(30, 140));    
         //foreach($this->datos as $key => $campo){ 
         $this->SetX(25);
         $this->Row(array(utf8_decode('Descripción Partida Desagregada: '),$campo['tx_descripcion']),1,1);       
         }
         
         $this->ln();
         $this->SetAligns(array("C","C", "C"));
	 $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(85,85));
         $this->SetFont('Arial','B',8);    
         $this->SetX(25);         
         $this->Row(array(utf8_decode('COORDINACIÓN DE PRESUPUESTO'),utf8_decode('SECRETARIA GENERAL DE ADMINISTRACION')),1,1);
         $this->SetFillColor(255,255,255);
         $Y = $this->GetY();
         $this->SetX(25);          
         $this->MultiCell(85,35,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(110);
         $this->MultiCell(85,35,'',1,1,'L',1);  
	 $this->SetY($this->GetY()+5);
         $this->ln();
         $this->SetFont('Arial','',8);          
         $this->SetX(25);          
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

// fechas, co_instituto, co_estatus, co_tipo_solicitud
   
    function getConsulta(){

        $conex = new ConexionComun();     
        $sql = "SELECT 	tb067.tx_partida,tb083.nu_proyecto_ac,tb084.nu_accion_especifica,
                          (tb067.tx_descripcion) as tx_descripcion, 
                          tb067.nu_monto, 
                          tb001.nb_usuario,                           
                          (select t.nb_usuario from tb001_usuario as t where t.co_usuario = tb067.co_usuario_cambio) as aprobador,                          
                          to_char(tb067.created_at,'dd/mm/yyyy') as fecha_creacion,
                          to_char(tb067.created_at,'dd') as dia,
                            to_char(tb067.created_at,'mm') as mes,
                            to_char(tb067.created_at,'yyyy') as anio
                  FROM tb067_creacion_partida as tb067  
                  left join tb083_proyecto_ac as tb083 on tb083.id = tb067.co_proyecto
                  left join tb084_accion_especifica as tb084 on tb084.id = tb067.co_accion_especifica
                  left join tb026_solicitud as tb026 on tb026.co_solicitud = tb067.co_solicitud
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb026.co_usuario
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb067.co_solicitud 
                  where tb030.co_ruta = ".$_GET['codigo']; 
                  
          //return $conex->ObtenerFilasBySqlSelect($sql);
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;
            
	
    }
    
    function getConsulta2(){

        $conex = new ConexionComun();     
        $sql = " SELECT   tb073.tx_fuente_financiamiento,
                          (tb067.nu_partida_desagregada||'-'||tb067.tx_descripcion) as tx_descripcion, 
                          tb091.nu_partida||'-'||tb091.de_partida as tx_partida, 
                          tb067.nu_monto, 
                          tb001.nb_usuario,                           
                          (select t.nb_usuario from tb001_usuario as t where t.co_usuario = tb067.co_usuario_cambio) as aprobador,                          
                          to_char(tb067.created_at,'dd/mm/yyyy') as fecha_creacion,
                          to_char(tb067.created_at,'dd') as dia,
                            to_char(tb067.created_at,'mm') as mes,
                            to_char(tb067.created_at,'yyyy') as anio
                  FROM tb067_creacion_partida as tb067  
                  left join tb073_fuente_financiamiento as tb073 on tb073.co_fuente_financiamiento = tb067.co_fuente_financiamiento
                  left join tb091_partida as tb091 on tb091.id = tb067.co_partida
                  left join tb026_solicitud as tb026 on tb026.co_solicitud = tb067.co_solicitud
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb026.co_usuario
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb067.co_solicitud 
                  where tb030.co_ruta = ".$_GET['codigo']; 
                  
          //return $conex->ObtenerFilasBySqlSelect($sql);
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
