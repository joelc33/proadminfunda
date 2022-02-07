<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->empresa = $this->getDatosEmpresa(1);

        if(!empty($this->empresa['tx_imagen_izq'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_izq'], $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
        }
        

//        if(!empty($this->empresa['tx_imagen_der'])){
//            $this->Image("imagenes/".$this->empresa['tx_imagen_der'],  $this->empresa['derecha_x'], $this->empresa['derecha_y'], $this->empresa['derecha_w']);
//        }

        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0,0,0);
        $this->SetY(10);
        $this->SetX(10);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        //$this->Ln(4);
        //$this->SetX(10);
        //$this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACIÓN Y FINANZAS'),0,0,'C');
        $this->Ln(4);
        $this->SetX(10);
        $this->Cell(0,0,utf8_decode('COORDINACIÓN DE CONTABILIDAD'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('San Francisco, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');
        $this->SetFont('Arial','B',10);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));  
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('BALANCE DE COMPROBACIÓN'),0,0,'C');                
        $this->Ln(6);
        //$this->Cell(0,0,utf8_decode('AL PERIODO AGOSTO 2018'),0,0,'C');         
             

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
         
         $this->SetFont('Arial','B',8);     
         $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(195,105,35)); 
         $this->SetAligns(array("L","C","R"));
         $this->Row(array('','--------------DURANTE EL PERIODO -------------------',''),0,0); 
         $this->SetFont('Arial','B',8);     
         $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(60,100,35,35,35,35,35)); 
         $this->SetAligns(array("L","L","R","R","R","R","R"));
         $this->Row(array('CUENTA',utf8_decode('DENOMINACIÓN'),'SALDO ANTERIOR','DEBITOS', 'CREDITOS','SALDO','SALDO ACTUAL'),1,1); 
         $this->SetFillColor(255, 255, 255);
         
         $nivel_inicial = $_GET['nivel_inicial']; // Nivel especifico de inicio
         $nivel_final = $_GET['cant_nivel']; // Máximo cantidad de niveles
         
         $this->lista_cuenta = $this->getCuentas($nivel_inicial, $nivel_final);

         foreach($this->lista_cuenta as $key => $campo){ 
             
                if($this->getY()>180)
                {	
                 $this->addPage();
                 $this->Ln(6);
                 $this->SetFont('Arial','B',8);     
                 $this->SetFillColor(201, 199, 199);
                 $this->SetWidths(array(195,105,35)); 
                 $this->SetAligns(array("L","C","R"));
                 $this->Row(array('','--------------DURANTE EL PERIODO AGOSTO 2018-------------------',''),0,0); 
                 $this->SetFont('Arial','B',8);     
                 $this->SetFillColor(201, 199, 199);
                 $this->SetWidths(array(60,100,35,35,35,35,35)); 
                 $this->SetAligns(array("L","L","R","R","R","R","R"));
                 $this->Row(array('CUENTA',utf8_decode('DENOMINACIÓN'),'SALDO ANTERIOR','DEBITOS', 'CREDITOS','SALDO','SALDO ACTUAL'),1,1); 
                 $this->SetFillColor(255, 255, 255);
                } 
                
                 $this->montos = $this->getMontos($campo['co_cuenta_contable']);
                
                $this->Row(array($campo['tx_cuenta'],$campo['desc_cuenta'],number_format($this->montos['saldo_anterior'], 2, ',','.'),number_format($this->montos['pre_deb'], 2, ',','.'),number_format($this->montos['pre_cre'], 2, ',','.'),number_format($this->montos['saldo'], 2, ',','.'),number_format($this->montos['saldo_actual'], 2, ',','.')),1,1);         

         } 

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
   
    function getCuentas($nivel_inicial,$nivel_final){ // Nivel 1

         if($_GET['co_cuenta']){
          
             $co_cuenta = "and tb024.nu_cuenta_contable like '".$_GET['co_cuenta']."%'";
             
         }else{
              $co_cuenta =  "";
         }
        
        
        
        $conex = new ConexionComun(); 
                  $sql = "SELECT tb024.tx_cuenta,tb024.tx_descripcion as desc_cuenta,tb024.nu_cuenta_contable,tb024.co_cuenta_contable
from tb024_cuenta_contable tb024
where tb024.nu_nivel between $nivel_inicial and $nivel_final $co_cuenta group by tb024.tx_cuenta,tb024.tx_descripcion,tb024.nu_cuenta_contable,tb024.co_cuenta_contable order by 1 asc";
         //  echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    } 
    
    function getMontos($co_cuenta){ // Nivel 1


        
        $conex = new ConexionComun(); 
                  $sql = "SELECT sum(pre_deb) as pre_deb, sum(pre_cre) as pre_cre,sum(pre_deb)  - sum(pre_cre) as saldo, (sum(acu_deb) + sum(mes_deb)) - (sum(acu_cre) + sum(mes_cre)) as saldo_anterior,
                  (sum(acu_deb) + sum(mes_deb)) - (sum(acu_cre) + sum(mes_cre)) + (sum(pre_deb)  - sum(pre_cre)) as saldo_actual  
from tb024_cuenta_contable tb024
where tb024.co_cuenta_contable = $co_cuenta";
           //echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];  
	
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
/*
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
*/

$pdf=new PDF('L','mm','LEGAL');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
