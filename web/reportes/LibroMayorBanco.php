<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {



        $this->Image("imagenes/escudosanfco.png", 100, 7,20);

        $this->SetFont('Arial','B',9);
        
      //  
        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        //$this->Ln(4);
        //$this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACIÓN Y FINANZAS'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('DEPARTAMENTO DE CONTABILIDAD'),0,0,'C');
        $this->SetFont('Arial','',8);
        $this->Ln(6);

        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
             

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
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));  
         $this->SetY(55);
         $this->SetFillColor(255, 255, 255);
         $this->SetFont('Arial','B',8); 
         $this->Row(array(utf8_decode('MAYOR ANÁLITICO')),1,1);        
         
         $this->SetFont('Arial','B',7);     
         $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(20,30,25,25,25,25,25,25)); 
         $this->SetAligns(array("L","C","L","L","R","R","R","R"));   
         $this->Row(array('FECHA',' #COMP.','REF.', 'MOVIMIENTO','SALDO ANT.','DEBITO','CREDITO','SALDO ACT.'),1,1); 
         $this->SetFillColor(255, 255, 255);
         
        
         /*********** Cuentas por Bco *************/
         $this->lista_cuenta = $this->getCuenta();         
         foreach($this->lista_cuenta as $key => $valor){ 
         
         if($this->getY()>170)
	 {	
         $this->addPage();
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));  
         $this->SetY(55);
         $this->SetY(55);
         $this->SetFillColor(255, 255, 255);
         $this->SetFont('Arial','B',8); 
         $this->Row(array(utf8_decode('MAYOR ANÁLITICO')),1,1);   
         $this->SetFont('Arial','B',7);     
         $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(20,30,25,25,25,25,25,25)); 
         $this->SetAligns(array("L","C","L","L","R","R","R","R"));   
         $this->Row(array('FECHA',' #COMP.','REF.', 'MOVIMIENTO','SALDO ANT.','DEBITO','CREDITO','SALDO ACT.'),1,1); 
         $this->SetFillColor(255, 255, 255);
         } 
         
         if($valor['mo_disponible']<>0){    
            $this->SetFont('Arial','B',10);
            $this->SetWidths(array(50,35,15,100)); 
            $this->SetAligns(array("L","L","L","L")); 
            $this->Row(array($valor['cuenta'],$valor['bco'],$valor['tipo'],number_format($valor['mo_disponible'], 2, ',','.')),0,0);         
            $sub_debitos = 0;
            $sub_creditos  = 0;
            $saldoAnt = 0;
            $this->SetAligns(array("L","L","R","R","R","R","R"));      
            $this->SetFont('Arial','B',7);

            /*********** Movimiento por Libro del Bco y cta asociada *************/
            $this->lista_mov = $this->getMovimientos($valor['co_cuenta_bancaria']);    
                   foreach($this->lista_mov as $key => $campo){   

                       $saldoAnt =   $campo['mo_saldo'];
                       $saldoMes =   $campo['mo_cargo'] - $campo['mo_abono']  ;
                       $saldoActual = $saldoMes + $saldoAnt;
                       $this->Row(array($campo['fe_movimiento'],$campo['de_concepto'],number_format($saldoAnt, 2, ',','.'),number_format($campo['mo_debe'], 2, ',','.'),number_format($campo['mo_cargo'], 2, ',','.'),number_format($saldoMes, 2, ',','.'),number_format($saldoActual, 2, ',','.'),''),1,1);         
                       $sub_debitos = $campo['mo_abono'] + $sub_debitos;
                       $sub_creditos  = $campo['mo_cargo'] + $sub_creditos;
                       $sub_saldosAnt = $sub_saldosAnt + $campo['saldo_ant'] ;
                       $sub_saldosMes = $sub_saldosMes + $campo['saldo_mes'] ;
                       $sub_saldosAct = $sub_saldosAct + $campo['saldo_act'] ;   

                   }
         }      
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
   
    function getCuenta(){

          $conex = new ConexionComun();     
          $sql = "  SELECT tb011.tx_cuenta_contable as cuenta, tb010.tx_banco as bco, coalesce(tb012.tx_tipo_cuenta,'S/I') as tipo,
                    tb011.co_cuenta_bancaria, tb011.mo_disponible
                    FROM tb010_banco as tb010
                    left join tb011_cuenta_bancaria as tb011 on (tb011.co_banco = tb010.co_banco)
                    left join tb012_tipo_cuenta_bancaria as tb012 on (tb012.co_tipo_cuenta = tb011.co_tipo_cuenta)
                    order by bco, cuenta, tipo";
                        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }    
    function getMovimientos($cuenta){

          $conex = new ConexionComun();     
          $sql = "  SELECT tb103.fe_movimiento, tb103.de_concepto, tb103.mo_cargo, tb103.mo_abono, tb103.mo_saldo
                     FROM tb100_banco_libro as tb100 
                     left join tb103_libro_detalle as tb103 on (tb103.id_tb100_banco_libro = tb100.id)
                     where tb100.id_tb011_cuenta_bancaria = ".$cuenta;
                        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
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

$pdf=new PDF('P','mm','letter');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
