<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {
    $co_tipo=$_GET['co_tipo'];

    if($co_tipo==1){
        $y=$_GET['tx_anio_fiscal'];
        $t="1er Trimestre"." "." del"." ".$y; 
    }
    if($co_tipo==2){
        $y=$_GET['tx_anio_fiscal'];
        $t="2do Trimestre"." "." del"." ".$y;  
    }

    if($co_tipo==3){
        $y=$_GET['tx_anio_fiscal'];
        $t="3er Trimestre"." "." del"." ".$y;  
    }

    if($co_tipo==4){
        $y=$_GET['tx_anio_fiscal'];
        $t="4to Trimestre"." "." del"." ".$y;
    }

    $trmestre=$t;

        $this->Image("imagenes/escudosanfco.png", 140, 7,20);

        $this->SetFont('Arial','B',12);
        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACIÓN Y FINANZAS'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('COORDINACIÓN DE CAJA'),0,0,'C');  
        $this->SetFont('Arial','',12);
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');   
        $this->SetFont('Arial','B',12);        
        $this->Ln(10);
        $this->Cell(0,0,utf8_decode('ARQUEO DE LOS PAGOS REALIZADOS DURANTE EL '.strtoupper(utf8_decode($trmestre))),0,0,'C');

        $this->Ln(10); 
        $this->SetX(3);           
        $this->SetY($this->getY()*1);
        $this->SetFont('Arial','B',9);
        $this->SetFillColor(220, 220, 220);   
        $this->SetWidths(array(12,20,33,25,25,30,60,25,25,25));
        $this->SetFillColor(201, 199, 199);
        $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C"));
        $this->Row(array(utf8_decode('N°'),'SOLICITUD','Nro. CHEQUE/TRANSF.','FECHA DE PAGO','O. DE PAGO','MONTO','BENEFICIARIO','CONCEPTO','FECHA RECIBIDO','FECHA DE ENTREGA'),1,1);
        

    }

    function Footer() {
	$this->SetFont('Arial','B',10);     
	$this->SetY(195);
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
      
     
     $this->lista_pagos = $this->pagos();
     $suma=0;   

         $i=1;
        
	 foreach($this->lista_pagos as $key => $campo){
        if($this->getY()>200){
           
         
            $this->addPage('L','mm','A4'); 
            $this->SetFillColor(255, 255, 255); 
            $this->SetX(3);
            $this->SetFont('Arial','B',10);  
            $this->SetWidths(array(12,20,33,25,25,30,60,25,25,25));
            $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C")); 
            $this->Cell(0,5,$this->PageNo()."/".($paginasTotal),1,1,'R');  
        }
         /*$this->SetFillColor(255,255,255);
         $this->SetFont('Arial','',9);
       //  $this->SetWidths(array(10,35,35,35,70,35,35));
         $this->SetWidths(array(12,20,33,25,30,35,60,25,25,25));
        $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C"));
         //$this->SetAligns(array("C","C","C","R","C","C","C"));  
         $this->SetX(3);
         $fecha= date_create($campo['fe_recibido_exp']);
         $this->Row(array($i,$campo['co_solicitud'],$campo['nu_pago'], $campo['fe_pago'], $campo['co_pago'], number_format($campo['nu_monto'], 2, ',','.'),utf8_decode($campo['tx_razon_social']), $campo['tx_concepto_pago'],/*date_format($)$campo['fe_recibido_exp'],$campo['fe_emision']),1,1);

        // echo var_dump($campo['fe_pago']);
      //  $i=$i+1;
	 //if($this->getY()>=200){
           //  $this->addPage(); 
            // $this->SetWidths(array(10,35,35,35,70,35,35));
            //$this->SetWidths(array(12,20,33,25,30,35,60,25,25,25));
           // $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C",)); 
           // $this->Cell(0,5,$this->PageNo()."/".($paginasTotal),1,1,'R');  
     
            //}*/

       
            $this->SetFillColor(255,255,255);
            $this->SetFont('arial', '', 10);
            $this->SetWidths(array(12,20,33,25,25,30,60,25,25,25));
            $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C"));
          
            $fecha= date_create($campo['fe_recibido_exp']);
            $this->Row(array($i,$campo['co_solicitud'],$campo['nu_pago'], $campo['fe_pago'], $campo['co_pago'], number_format($campo['nu_monto'], 2, ',','.'),utf8_decode($campo['tx_razon_social']), $campo['tx_concepto_pago'],/*date_format($)*/$campo['fe_recibido_exp'],$campo['fe_emision']),1,1);
            number_format( $suma+=$campo['nu_monto'], 2, ',','.');
           
            $i=$i+1;
           
                                
	 
      }
           
            $this->ln(2);
            $this->setFont('arial', 'B', 10);
            $this->SetWidths(array(65,50));
            $this->SetAligns(array("C","C"));
            $this->Row(array(utf8_decode('TOTAL'),number_format($suma,2, ',','.')),1,1);
            $this->Ln(20);


            $this->setFont('arial', 'UB', 10);
            $this->SetWidths(array(95,135));
            $this->SetAligns(array("C","C"));
            $this->Row(array('ELABORADO POR:', 'AUTORIZADO POR:'),0,0);
            $this->ln(2);

            $this->setFont('arial', 'B', 10);
            $this->SetAligns(array("C","C"));
            $this->Row(array('SANDRA MEDINA.', 'DRA. ARIANNA PETIT.'),0,0);
            $this->ln(2);
            $this->Row(array('COORDINADORA DE CAJA.', 'SUB-TESORERA DEL EDO.'),0,0);
            $this->ln(2);




    }

    
    function ChapterTitle($num,$label) {
        $this->SetFont('Arial','',9);
        $this->SetFillColor(200,220,255);
        $this->Cell(0,6,"$label",0,1,'L',1);
        $this->Ln(8);
    }

    function SetTitle($title) {
        $this->title   = $title;
    }

    function PrintChapter() {
       
        $this->AddPage('L','mm','A4');
        $this->ChapterBody();
   }

   
    function pagos(){
        $co_tipo=$_GET['co_tipo'];
      
      



    if($co_tipo==1){
        $y=$_GET['tx_anio_fiscal'];
        $ini ="01";
        $fin ="03";
        $t="1er Trimestre"." "." del".$y;

        $trimestre = $y."-".$ini."-01";
        $trimestre2 = $y."-".$fin."-31";

        
    }
    if($co_tipo==2){
        $y=$_GET['tx_anio_fiscal'];
        $ini ="04";
        $fin ="06";
        $t="2do Trimestre"." "." del".$y;

        $trimestre = $y."-".$ini."-01";
        $trimestre2 = $y."-".$fin."-30";
    }
    if($co_tipo==3){
        $y=$_GET['tx_anio_fiscal'];
        $ini ="07";
        $fin ="09";
        $t="3er Trimestre"." "." del".$y;

        $trimestre = $y."-".$ini."-01";
        $trimestre2 = $y."-".$fin."-30";
    }
    if($co_tipo==4){
        $y=$_GET['tx_anio_fiscal'];
        $ini ="10";
        $fin ="12";
        $t="4to Trimestre"." "." del".$y;

        $trimestre = $y."-".$ini."-01";
        $trimestre2 = $y."-".$fin."-31";
    }
    $conex = new ConexionComun();     
 
             $sql="SELECT   tb063.nu_pago,
             to_char(tb062.fe_emision,'dd/mm/yyyy') as fe_emision, 
             tb063.fe_pago,
             tb063.nu_monto,
             tb008.tx_razon_social,
             tb062.co_solicitud,
             tb063.co_pago,
             tb063.fe_recibido_exp,
             tb116.tx_concepto_pago
     FROM tb063_pago as tb063
       
          left join tb062_liquidacion_pago as tb062 on tb062.co_liquidacion_pago= tb063.co_liquidacion_pago 
          left join tb026_solicitud as tb026 on tb062.co_solicitud =tb026.co_solicitud
          left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor
          left join tb116_concepto_pago as tb116 on tb116.co_concepto_pago = tb063.co_concepto_pago where tb063.fe_pago >='$trimestre' AND tb063.fe_pago <= '$trimestre2' 
      group by  tb063.nu_pago,
      tb062.fe_emision,
      tb063.fe_pago,
      tb063.nu_monto,
          tb008.tx_razon_social,
          tb062.co_solicitud,
          tb063.co_pago,
          tb063.fe_recibido_exp,
          tb116.tx_concepto_pago

      order by 
      tb062.fe_emision,
      tb063.fe_pago,
          tb062.co_solicitud,
          tb063.co_pago
      
       ";
        // echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
	
    }




}
$pdf=new PDF('L','mm','A4' );

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
