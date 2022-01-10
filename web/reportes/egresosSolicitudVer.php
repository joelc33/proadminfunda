<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $resulta;
    function Header() {
        $this->Image("imagenes/escudosanfco.png", 135, 5,20);
        $this->Ln(20);
        $this->SetFont('Arial','B',12);
        $this->SetX(100);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'L');
        $this->SetFont('Arial','B',12);
        $this->Ln(5);
        $this->SetX(105);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'L');
        $this->Ln(5);
        $this->SetX(106);
        $this->Cell(0,0,utf8_decode('OFICINA DE RECURSOS HUMANOS'),0,0,'L');
        $this->SetFont('Arial','',12);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        
    }

    function Footer() {
    $this->SetFont('Arial','B',9);     
    $this->SetY(250);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');       
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
         $this->codigo = $this->getOP();
         foreach($this->codigo as $key => $resultado){

         }
         $this->Ln(8);
         $this->SetFont('Arial','B',10);
        $this->Cell(0,0,utf8_decode('SOLICITUD:'.$resultado['co_solicitud']),0,0,'R');
         $this->Ln(10);
         $this->SetWidths(array(150));
         $this->SetX(70);
         $this->SetAligns(array("C")); 
         $this->SetFont('Arial','B',12);         
         $this->Row(array(utf8_decode('EGRESOS DE TRABAJADOR')),0,0);
         $this->Ln(2);
         $this->SetFillColor(255, 255, 255); 
         
        //Se llama a la funcion

        
         

         $this->lista_op = $this->getOP2($resultado);


          $this->SetX(3);
         $this->SetFont('Arial','B',10);     
                $this->SetWidths(array(7,25,25,25,28,30,15,40,23,23,50));
                $this->SetFillColor(171, 170, 170);
                $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C"));  

         $this->Row(array('N','Nombre','Apellido','Cedula de identidad', utf8_decode('Ubicación'), 'Nomina', 'Tipo Nomina','Cargo','Fecha de Movimiento','Fecha de Egreso',utf8_decode('Situación')),1,1);

             
        
         $numero = 1;
         foreach($this->lista_op as $key => $campo){              
              
                 if($this->getY()>150)
                {   
                $this->addPage('L','mm','letter');
                $this->Ln(6);
                $this->SetX(3);                
                $this->SetFont('Arial','B',10);     
                $this->SetWidths(array(7,25,25,25,28,30,15,40,23,23,50));
                $this->SetFillColor(171, 170, 170);
                $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C"));  
                 
                $this->Row(array('N','Nombre','Apellido','Cedula de identidad', utf8_decode('Ubicación'), 'Nomina', 'Tipo Nomina','Cargo','Fecha de Movimiento','Fecha de Egreso',utf8_decode('Situación')),1,1);
                } 
                //Tabla Actualizacion abajo
                // echo var_dump($campo); exit();
                $this->SetFont('Arial','',8); 
                $this->SetX(3);  
             $this->SetWidths(array(7,25,25,25,28,30,15,40,23,23,50));
                $this->SetFillColor(255, 255, 255);
                $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C"));  
               
                 $this->Row(array($numero,utf8_decode($campo['nb_primer_nombre']),utf8_decode($campo['nb_primer_apellido']),utf8_decode($campo['nu_cedula']),ucwords(utf8_decode($campo['tx_dependecia'])),utf8_decode($campo['tx_tp_nomina']),utf8_decode($campo['tx_grupo_nomina']),utf8_decode(mb_convert_case($campo['tx_cargo'], MB_CASE_TITLE)),utf8_decode($campo['fe_movimiento']),utf8_decode($campo['fe_egreso']),mb_convert_case(utf8_decode($campo['tx_motivo']),MB_CASE_TITLE)),1,1,'R'); 
                $numero=$numero+1;
            
         }
       

   }

    function ChapterTitle($num,$label) {
        $this->SetFont('Arial','',10);
        $this->SetFillColor(200,220,255);
        $this->Cell(0,6,"$label",6,1,'L',1);
        $this->Ln(8);
    }

    function SetTitle($title) {
        $this->title   = $title;
    }

    function PrintChapter() {
        $this->AddPage();
        $this->ChapterBody();
    }
    
    function getOP(){ 

        $conex = new ConexionComun(); 
        $sql = "SELECT * FROM tb030_ruta WHERE co_ruta =".$_GET['codigo'];  
           
        // echo $sql; exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          

          return  $datosSol;  
    
    }

    function getOP2($fugas){

$conex = new ConexionComun(); 

$sql=";with cts as( 
select nb_primer_nombre, nb_segundo_nombre,nb_primer_apellido,nb_segundo_apellido, nu_cedula,tx_cargo,tx_tp_nomina, fe_movimiento, fe_egreso, tx_motivo, tx_grupo_nomina,tbrh099_egreso.co_solicitud,tbrh003_dependencia.tx_dependecia,
ROW_NUMBER() over (partition by tbrh002_ficha.co_trabajador order by tbrh002_ficha.co_ficha desc) as repetidos
from tbrh001_trabajador
INNER JOIN tbrh002_ficha ON tbrh001_trabajador.co_trabajador = tbrh002_ficha.co_trabajador
INNER JOIN tbrh015_nom_trabajador ON tbrh002_ficha.co_ficha = tbrh015_nom_trabajador.co_ficha
INNER JOIN tbrh009_cargo_estructura ON tbrh015_nom_trabajador.co_cargo_estructura = tbrh009_cargo_estructura.co_cargo_estructura
INNER JOIN tbrh032_cargo ON tbrh009_cargo_estructura.co_cargo = tbrh032_cargo.co_cargo 
INNER JOIN tbrh099_egreso ON tbrh001_trabajador.co_trabajador = tbrh099_egreso.co_trabajador 
INNER JOIN tbrh017_tp_nomina ON tbrh015_nom_trabajador.co_tp_nomina = tbrh017_tp_nomina.co_tp_nomina
INNER JOIN tbrh067_grupo_nomina ON tbrh015_nom_trabajador.co_grupo_nomina = tbrh067_grupo_nomina.co_grupo_nomina
INNER JOIN tbrh005_estructura_administrativa ON tbrh009_cargo_estructura.co_estructura_administrativa = tbrh005_estructura_administrativa.co_estructura_administrativa
INNER JOIN tbrh003_dependencia ON tbrh005_estructura_administrativa.co_ente = tbrh003_dependencia.co_dependencia
WHERE 
tbrh099_egreso.co_nom_situacion = tbrh015_nom_trabajador.co_nom_situacion and 
tbrh002_ficha.in_activo = 'false'
)
select *
from cts
where repetidos = 1 and cts.co_solicitud =".$fugas['co_solicitud']." order by cts.fe_egreso";
        
           
        // echo $sql; exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);

          return  $datosSol;  
    }   

}

$pdf=new PDF('L','mm','A4');
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
$pdf=new PDF('L','mm','A4');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 
*/

?>