<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $array_factura;
    public $array_factura_banco;
    function Header() {


	encabezado_general_legal($this);
	


         $this->Ln(6);
         $this->Cell(0,0,utf8_decode('Fecha de Impresión: '.date("d-m-Y")),0,0,'R');
         $this->Ln(4);
         $this->Cell(0,0,utf8_decode('Cod. Reporte: SAE0013'),0,0,'R');
	 $this->Ln(6);
         $this->Cell(0,0,utf8_decode('REPORTE DIFERENCIAL DE MOROSOS'),0,0,'C');
         $this->SetY(38);  



    }

    function Footer() {
	$this->SetFont('Arial','',9);     
	$this->SetY(-20);
//	$this->Cell(0,0,utf8_decode('www.ciudaddeprogreso.org.ve / www.sedebat.com'),0,0,'C');
        
    }

    function dwawCell($title,$data) {



        $width = 8;
        $this->SetFont('Arial','B',8);
        $y =  $this->getY() * 20;
        $x =  $this->getX();
        $this->SetFillColor(206,230,100);
        $this->MultiCell(175,8,$title,0,1,'L',0);
        $this->Cell(0,0,utf8_decode('Fecha de Impresión: '.date("d-m-Y")),0,0,'R');
        $this->SetY($y);
        $this->SetFont('Arial','',6);
        $this->SetFillColor(206,230,172);
        $w=$this->GetStringWidth($title)+3;
        $this->SetX($x+$w);
        $this->SetFillColor(206,230,172);
        $this->MultiCell(175,8,$data,0,1,'J',0);

    }

    function ChapterBody() {


         
         $this->Ln(20);
	
         $this->datos = $this->getSolicitudes();
		//echo $this->datos['co_contribuyente']; exit;
         
        $this->setY(45);
	

      	
	$this->Ln(3);
        $this->SetFillColor(201, 199, 199);
        $this->SetFont('Arial','',8);
	$this->SetAligns(array("C","L","L","R","C","R","R"));
         $this->SetWidths(array(10,20,20,50,20,20,20,20,25));
        $this->Row(array(utf8_decode('Nro.'),utf8_decode('Rif/Cedula'),utf8_decode('Referencia'),utf8_decode('Contribuyente'),utf8_decode('M Recaudado'),utf8_decode('Fecha Recaudacion'),utf8_decode('Ultimo Pago'),utf8_decode('Telefono'),utf8_decode('Parroquia')),1,1);

            $cant=0;
	     $i = 0;
            $cant_pendiente=0;
            $cant_aprobado=0;
            $cant_entregado=0;
	    $total_recaudacion=0;
       foreach($this->datos as $key => $campo){

		$total_recaudacion = $total_recaudacion + $campo['nu_monto_liq'];
	if($campo['motivo_no_pagado']==''){
	    $i = $i + 1 ;
            $this->SetFillColor(255,255,255);
            $this->SetAligns(array("C","L","C","C","R","C","R","R"));
            $this->Row(array($i,utf8_decode($campo['rif']),utf8_decode($campo['nu_referencia']),utf8_decode($campo['contribuyente']),number_format($campo['nu_monto_liq'], 2, ',','.'),utf8_decode($campo['fe_recaudacion']),utf8_decode($campo['tx_motivo']),utf8_decode($campo['telefono']),utf8_decode($campo['parroquia'])));
}

	    if($this->getY()>320){
		       $this->addPage();
	$this->setY(45);
         $this->Ln(2);
        $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(10,20,20,50,20,20,20,20,25));
        $this->Row(array(utf8_decode('Nro.'),utf8_decode('Rif/Cedula'),utf8_decode('Referencia'),utf8_decode('Contribuyente'),utf8_decode('M Recaudado'),utf8_decode('Fecha Recaudacion'),utf8_decode('Ultimo Pago'),utf8_decode('Telefono'),utf8_decode('Parroquia')),1,1);
	        }
        }

        $this->SetAligns(array("R","R","R","R","R"));
        $this->setX(50);
         $this->SetWidths(array(55,25,20,20,20));
        $this->Row(array(utf8_decode("Total Recaudado"),number_format($total_recaudacion, 2, ',','.')));


    }

    function ChapterTitle($num,$label) {
        $this->SetFont('Arial','',6);
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

	function enc(){


	}



    function getSolicitudes(){

          $conex = new ConexionComun();

        $fe_inicio      = $_GET["fe_inicio"];
        $fe_fin         = $_GET["fe_fin"];
        $co_sigla        = $_GET["co_sigla"];
        $anio = $_GET['ano_motivo'];
        $co_sigla2        = $_GET["co_sigla2"];
        $anio2 = $_GET['ano_motivo2'];


        if($co_sigla!='')
        {

           $condicion .= "t3.co_sigla in (".$co_sigla.")";
        }


        if($anio!=''){
           ($condicion!='')?$condicion.= ' and ':'';
           $condicion .= "t3.tx_motivo like '%".$anio."%'";
        }

	($condicion!='')?$condicion = ' where '.$condicion :'';


        if($co_sigla2!='')
        {

           $condicion2 .= "t2.co_sigla in (".$co_sigla2.")";
        }


        if($anio2!=''){
           ($condicion2!='')?$condicion2.= ' and ':'';
           $condicion2 .= "t2.tx_motivo like '%".$anio2."%'";
        }

	($condicion2!='')?$condicion2 = ' where '.$condicion2 :'';

          $sql = "select * ,(SELECT 
    t2.tx_motivo as motivo_no_pagado
   FROM v_lista_empresas_ae t2
     ".$condicion2." and t3.co_contribuyente= t2.co_contribuyente
      limit 1)  from v_lista_empresas_ae t3 ".$condicion;

          //echo $sql; exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          //echo $datosSol[0]['co_contribuyente']; exit();
          return  $datosSol;

/*SELECT   sum(t1.nu_monto_liq)
   FROM v_lista_empresas_ae t1
     JOIN ( SELECT v_lista_empresas_ae.co_contribuyente,
            max(v_lista_empresas_ae.fe_declaracion) AS fecha
           FROM v_lista_empresas_ae where v_lista_empresas_ae.co_sigla in(25,26)
           GROUP BY v_lista_empresas_ae.co_contribuyente) t2 ON t1.co_contribuyente = t2.co_contribuyente AND t1.fe_declaracion = t2.fecha
  WHERE  t1.co_sigla in(25,26) and fe_recaudacion >= '2015-01-01' and fe_recaudacion <= '2015-03-06' and t1.tx_motivo like '%2015%'
*/

    }

    


}

$pdf=new PDF('P','mm','legal');
$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();
?>
