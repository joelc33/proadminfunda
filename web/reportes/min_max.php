<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->SetFont('ARIAL','',6);        
        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R'); 
        $this->Ln(4);
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
         
         if ($_GET["co_anio_fiscal"]) $anio=$_GET["co_anio_fiscal"];
         else if ($_GET["fe_inicio"]) $anio= date("Y", strtotime($_GET["fe_inicio"]));
         
         $mes       = 8;
         $mes_old   = $mes - 1;
         if ($mes < 10) $mes = '0'.$mes;
         if ($mes_old < 10) $mes_old = '0'.$mes_old;         
                          
         $this->AddPage();
         $this->SetFont('Arial','',10);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(160, 161));
         $this->SetAligns(array("L","L"));
         
         $nomnew = $this->getDescNom($_GET['co_solicitud_new']);
         $nomold = $this->getDescNom($_GET['co_solicitud_old']);
         //echo var_dump($nomnew); exit();  
        // echo var_dump($nomold); exit();  
         
         $this->SetX(4);
         $this->Row(array('Nomina OLD: '.$nomold,'Nomina NEW: '.$nomnew),1,1);                           
        
         $this->SetWidths(array(11,11,40,15,15,15,15,17,17,17,17,17,17,17,17,21,21,21));
         $this->SetAligns(array("C","C","L","R","R","R","R","R","R","R","R","R","R","R"));         
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Arial','',7);
         $this->SetX(4);
         $this->Row(array('FUN', 'COD', 'CONCEPTO', 'MIN OLD','MIN NEW', 'MIN DIF', 'MAX OLD', 'MAX NEW','MAX DIF', 'MED OLD', 'MED NEW','MED DIF','CAN OLD','CAN NEW','CAN DIF','TOT OLD','TOT NEW','TOT DIF'),1,1);
         $this->SetFillColor(255, 255, 255);
         $total=0;

         
         $co_solicitud_new = $_GET['co_solicitud_new'];
         $co_solicitud_old = $_GET['co_solicitud_old'];
         $this->detalles = $this->getCalculosNEW($co_solicitud_new);  
         
         //echo var_dump($this->detalles); exit();  
         
         foreach($this->detalles as $key => $campo){
         
         $this->SetX(4);    
         
         $datos = $this->getCalculosOLD($co_solicitud_old, $campo['nu_concepto']);
         
         $min_old = $datos['min'];
         $max_old = $datos['max'];         
         
         $min_new = $campo['min'];
         $max_new = $campo['max'];
         
         $dif_min = $min_new - $min_old;
         $dif_max = $max_new - $max_old;    
         
         $med_old = ($min_old + $max_old / 2);
         $med_new = ($min_new + $max_new / 2);
         $med_dif = ($dif_min + $dif_max / 2);       
         
         $inform   = $this->getCanNEW($co_solicitud_new, $campo['nu_concepto']);
         $dif_cant = $inform['cant_new'] - $datos['cant_old']; 
         $dif_tot  = $inform['tot_new'] - $datos['tot_old'];
         
         if($this->getY()>175){
                $this->AddPage(); 
                $this->SetFont('Arial','',8);
                $this->SetFillColor(255, 255, 255);
                $this->SetWidths(array(160, 161));
                $this->SetAligns(array("L","L","L","L"));

                $this->SetX(4);
                $this->Row(array('Nomina OLD: '.$nomold,'Nomina NEW: '.$nomnew),1,1);                           
                $this->SetWidths(array(11,11,40,15,15,15,15,17,17,17,17,17,17,17,17,21,21,21));
                $this->SetAligns(array("C","C","L","R","R","R","R","R","R","R","R","R","R","R"));         
                $this->SetFillColor(201, 199, 199);
                $this->SetFont('Arial','',7);
                $this->SetX(4);
                $this->Row(array('FUN', 'COD', 'CONCEPTO', 'MIN OLD','MIN NEW', 'MIN DIF', 'MAX OLD', 'MAX NEW','MAX DIF', 'MED OLD', 'MED NEW','MED DIF','CAN OLD','CAN NEW','CAN DIF','TOT OLD','TOT NEW','TOT DIF'),1,1);
                $this->SetFillColor(255, 255, 255);
                $this->SetX(4);
         }       
         $this->Row(array($campo['id_tbrh020_tp_concepto'],$campo['nu_concepto'],$campo['de_concepto'], number_format($min_old, 2, ',','.'),number_format($min_new, 2, ',','.'),number_format($dif_min, 2, ',','.'),number_format($max_old, 2, ',','.'),number_format($max_new, 2, ',','.'),number_format($dif_max, 2, ',','.'),number_format($med_old, 2, ',','.'),number_format($med_new, 2, ',','.'),number_format($med_dif, 2, ',','.'),$datos['cant_old'],$inform['cant_new'],$dif_cant,number_format($datos['tot_old'], 2, ',','.'),number_format($inform['tot_new'], 2, ',','.'),number_format($dif_tot, 2, ',','.')),1,1);         
         }  
         
         $this->Ln(4);
         $this->SetFont('Arial','B',8);
         $this->SetY(210);
         $this->SetWidths(array(30,30,10,30,25,10,30,30));
         $this->SetAligns(array("L","R","L","L","R","L","L","R")); 
         
         $tot_asig_old = $this->getTotal($co_solicitud_old, 1);
         $tot_asig_new = $this->getTotal($co_solicitud_new, 1);
         $tot_asig_dif = $tot_asig_new['total'] - $tot_asig_old['total'];
                 
         $tot_ded_old   = $this->getTotal($co_solicitud_old, 2);
         $tot_ded_new   = $this->getTotal($co_solicitud_new, 2);
         $tot_deduc_dif = $tot_ded_new['total'] - $tot_ded_old['total'];
                 
         $tot_neto_old = $tot_asig_old['total'] - $tot_ded_old['total'];
         $tot_neto_new = $tot_asig_new['total'] - $tot_ded_new['total'];
         $tot_neto_dif = $tot_asig_dif - $tot_deduc_dif;
                 
         $tot_apor_old = $this->getTotal($co_solicitud_old, 3);
         $tot_apor_new = $this->getTotal($co_solicitud_new, 3);
         $tot_apor_dif = $tot_apor_new['total'] - $tot_apor_old['total'];        
                 
                 
         $this->SetX(10);
         $this->Row(array('TOT ASIG OLD:  ',number_format($tot_asig_old['total'], 2, ',','.'),'', 'TOT ASIG NEW:  ',number_format($tot_asig_new['total'], 2, ',','.'),'', 'TOT ASIG DIF:  ',number_format($tot_asig_dif, 2, ',','.')),0,1);         
         $this->SetX(10);
         $this->Row(array('TOT DEDUC OLD:  ',number_format($tot_ded_old['total'], 2, ',','.'),'', 'TOT DEDUC NEW:  ',number_format($tot_ded_new['total'], 2, ',','.'),'', 'TOT DEDUC DIF:  ',number_format($tot_deduc_dif, 2, ',','.')),0,1);         
         $this->SetX(10);
         $this->Row(array('TOT NETO OLD: ',number_format($tot_neto_old, 2, ',','.'),'', 'TOT NETO NEW:  ',number_format($tot_neto_new, 2, ',','.'),'', 'TOT NETO DIF:  ',number_format($tot_neto_dif, 2, ',','.')),0,1);         
         $this->SetX(10);
         $this->Row(array('TOT APOR OLD:  ',number_format($tot_apor_old['total'], 2, ',','.'),'', 'TOT APOR NEW:  ',number_format($tot_apor_new['total'], 2, ',','.'),'', 'TOT APOR DIF:  ',number_format($tot_apor_dif, 2, ',','.')),0,1); 
         $this->Ln(8);
         $this->SetWidths(array(200));
         $this->SetX(10);
         $this->Row(array('FIRMA AUTORIZADA: _____________________________'),0,1);         
 
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
        //$this->AddPage();
        $this->ChapterBody();
    }
    
    function getDescNom($nom){

          $conex = new ConexionComun();     
          $sql = "  SELECT distinct de_nomina
                    FROM tbrh013_nomina 
                    where co_solicitud =".$nom  ;

          //echo var_dump($sql); exit();                     
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];                         
    }    
    
    function getTotal($tipo_nom,$fun){

          $conex = new ConexionComun();     
          $sql = "  SELECT sum(tbrh061.nu_monto) as total
                    FROM tbrh061_nomina_movimiento as tbrh061 
                    left join tbrh013_nomina as tbrh013 on (tbrh013.co_nomina = tbrh061.id_tbrh013_nomina)
                    where tbrh013.co_solicitud = $tipo_nom  
                    and tbrh061.id_tbrh020_tp_concepto= ".$fun;

          //echo var_dump($sql); exit();                     
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];                         
    } 
    
    function getCanNEW($tipo_nom,$concep){

          $conex = new ConexionComun();     
          $sql = "  SELECT count(tbrh014.nu_concepto) as cant_new,
                           sum(tbrh061.nu_monto) as tot_new
                    FROM tbrh061_nomina_movimiento as tbrh061
                    left join tbrh013_nomina as tbrh013 on (tbrh013.co_nomina = tbrh061.id_tbrh013_nomina)
                    left join tbrh014_concepto as tbrh014 on (tbrh014.co_concepto = tbrh061.id_tbrh014_concepto)                   
                    where tbrh013.co_solicitud = $tipo_nom
                    and tbrh014.nu_concepto = '".$concep."'  ";

          //echo var_dump($sql); exit();                     
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];                         
    }    
    function getCalculosOLD($tipo_nom,$concep){

          $conex = new ConexionComun();     
          $sql = "  SELECT tbrh061.id_tbrh020_tp_concepto,
                            tbrh014.nu_concepto, 
                            tbrh061.de_concepto, 
                            min(tbrh061.nu_monto) as min,
                            max(tbrh061.nu_monto) as max,
                            count(tbrh014.nu_concepto) as cant_old,
                            sum(tbrh061.nu_monto) as tot_old
                    FROM tbrh061_nomina_movimiento as tbrh061
                    left join tbrh013_nomina as tbrh013 on (tbrh013.co_nomina = tbrh061.id_tbrh013_nomina)
                    left join tbrh014_concepto as tbrh014 on (tbrh014.co_concepto = tbrh061.id_tbrh014_concepto)                   
                    where tbrh013.co_solicitud = $tipo_nom
                    and tbrh014.nu_concepto = '".$concep."'    
                    group by 1, 2, 3
                    order by 1, 2";

          //echo var_dump($sql); exit();                     
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];                         
    }
    function getCalculosNEW($tipo_nom){

          $conex = new ConexionComun();     
          $sql = "  SELECT tbrh061.id_tbrh020_tp_concepto,
                            tbrh014.nu_concepto, 
                            tbrh061.de_concepto, 
                            min(tbrh061.nu_monto) as min,
                            max(tbrh061.nu_monto) as max
                    FROM tbrh061_nomina_movimiento as tbrh061
                    left join tbrh013_nomina as tbrh013 on (tbrh013.co_nomina = tbrh061.id_tbrh013_nomina)
                    left join tbrh014_concepto as tbrh014 on (tbrh014.co_concepto = tbrh061.id_tbrh014_concepto)                   
                    where tbrh013.co_solicitud = $tipo_nom                   
                    group by 1, 2, 3
                    order by 1, 2";

          //echo var_dump($sql); exit();                     
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;                         
    }    

}

$pdf=new PDF('P','mm','legal');
$pdf->AliasNbPages();
$pdf->PrintChapter();

$comm = new ConexionComun();
$ruta = $comm->getRuta();

//rmdir($ruta);
//mkdir($ruta, 0777, true);    
/*
$dir="$ruta".$_GET["codigo"].".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";


$update = "update tb030_ruta set tx_ruta_reporte = '".$dir."' where co_ruta = ".$_GET['codigo']; //$comm->decrypt($_GET["codigo"]);

//echo $update; exit();
$comm->Execute($update);    

$pdf->Output($dir, 'F');
*/

$pdf=new PDF('L','mm','LEGAL');
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
