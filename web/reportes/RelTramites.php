<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {
        $this->SetFont('courier','B',12);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Secretaria de Administración y Finanzas'),0,0,'L');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('[FBANR018]'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');                          
    }

    function Footer() {
	$this->SetFont('courier','B',9);     
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

         $this->Ln(6);
         $this->SetWidths(array(200));         
         $this->SetAligns(array("C")); 
         $this->SetFont('courier','B',9);         
         $this->Row(array(utf8_decode('RELACIÓN DE TODOS LOS CHEQUES PARA ENTIDADES BANCARIAS DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
         $this->Ln(2);
         $this->SetWidths(array(200));
         $this->SetAligns(array("L"));           
         $this->SetFont('COURIER','B',8); 
         $this->SetFillColor(255, 255, 255); 
         
         $this->lista_cuentas = $this->getCuenta();         
         
         $this->SetFont('COURIER','',9);     
         $this->SetWidths(array(25,25,20,60,25,35));  
         $this->SetAligns(array("C","C","C","C","C","C","R"));   
         $this->Row(array('Nro. Cheque','Control','Fecha','Beneficiario', 'Estado','Monto'),0,0); 
         $this->SetAligns(array("C","C","C","C","C","C","R"));            
         $this->Line(10, 40, 210, 40);        
         $this->Ln(2);
         $mo_total=0;
         
         
        foreach($this->lista_cuentas as $key => $valor){
        
                    if($this->getY()>230)
                        {	
                        $this->addPage();
                        $this->Ln(6);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("C")); 
                        $this->SetFont('courier','B',9);        
                        $this->Row(array(utf8_decode('RELACIÓN DE TODOS LOS CHEQUES PARA ENTIDADES BANCARIAS DEL  '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
                        $this->Ln(2);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("L"));           
                        $this->SetFont('COURIER','B',8); 
                        $this->SetFillColor(255, 255, 255); 

                        $this->SetFont('COURIER','',9);     
                        $this->SetWidths(array(25,25,20,60,25,35));   
                        $this->SetAligns(array("C","C","C","C","C","C","R"));  
                        $this->Row(array('Nro. Cheque','Control','Fecha','Beneficiario', 'Estado','Monto'),0,0); 
                        $this->SetAligns(array("C","C","C","C","C","C","R")); 
                        $this->Line(10, 40, 210, 40);        
                        $this->Ln(2);
                        $mo_total=0;
                    } 
 
                   $this->SetFont('courier','B',8);
                   $this->SetWidths(array(100,100)); 
                   $this->SetAligns(array("L", "L")); 
                   $this->Row(array('Banco: '.$valor['bco'], 'Cuenta: '.$valor['cuenta']),0,0);         
                /*********** listado de cheques *************/
                $this->lista_cheques = $this->getMovimientos($valor['co_cuenta_bancaria']);             
         
                foreach($this->lista_cheques as $key => $campo){              

                        if($this->getY()>230)
                        {	
                        $this->addPage();
                        $this->Ln(6);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("C")); 
                        $this->SetFont('courier','B',9);         
                        $this->Row(array(utf8_decode('RELACIÓN DE TODOS LOS CHEQUES PARA ENTIDADES BANCARIAS DEL  '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
                        $this->Ln(2);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("L"));           
                        $this->SetFont('COURIER','B',8); 
                        $this->SetFillColor(255, 255, 255); 

                        $this->SetFont('COURIER','',9);     
                        $this->SetWidths(array(25,25,20,60,25,35));  
                        $this->SetAligns(array("C","C","C","C","C","C","R"));   
                        $this->Row(array('Nro. Cheque','Control','Fecha','Beneficiario', 'Estado','Monto'),0,0); 
                        $this->SetAligns(array("C","C","C","C","C","C","R"));   
                        $this->Line(10, 40, 210, 40);        
                        $this->Ln(2);
                        $mo_total=0;
                        } 
                        $this->SetFont('COURIER','',7);  
                        $this->SetWidths(array(25,25,20,60,25,35));  
                        $this->SetAligns(array("C","C","C","C","C","C","R")); 
                        $this->Row(array($campo['documento'],$campo['nu_control'],$campo['fecha'],utf8_decode($campo['beneficiario']),$campo['estado'],number_format($campo['monto'], 2, ',','.')),0,0);         

                        $mo_total = $campo['monto'] + $mo_total;

                 }
                 
        }
         $this->Ln(10);
         $y = $this->getY();
         $this->Line(180, $y, 210, $y);         
         $this->SetFont('COURIER','B',8);  
         $this->SetAligns(array("R","R","R"));
         $this->SetWidths(array(160,40));
         $this->Row(array(utf8_decode('TOTAL RELACIÓN...: '),number_format($mo_total, 2, ',','.')),0,0);         
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
          $sql = "  SELECT tb024.tx_cuenta as cuenta, tb010.tx_banco as bco,
                    tb011.co_cuenta_bancaria
                    FROM tb010_banco as tb010
                    left join tb011_cuenta_bancaria as tb011 on (tb011.co_banco = tb010.co_banco)
                    left join tb024_cuenta_contable as tb024 on (tb011.co_cuenta_contable = tb024.co_cuenta_contable)
                    where tb011.tx_cuenta_bancaria like '01160172390016073568'
                    order by bco, cuenta";
          
          
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }    
    function getMovimientos($cuenta){

          $conex = new ConexionComun();     
          $sql = "  SELECT 'CH-'||tb077.tx_descripcion as documento, "
                  . "tb077.tx_descripcion as nu_control, "
                  . "to_char(tb063.fe_pago,'dd/mm/yyyy') as fecha, "
                  . "UPPER(tb008.tx_razon_social||' '||tb008.tx_rif) AS beneficiario, "
                  . "tb076.tx_estado_cheque as estado, "
                  . "tb063.nu_monto as monto "
                  . "from tb063_pago as tb063 "
                  . "left join tb062_liquidacion_pago as tb062 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago "
                  . "left join tb060_orden_pago as tb060 on tb060.co_solicitud = tb062.co_solicitud "
                  . "left join tb026_solicitud as tb026 on tb060.co_solicitud = tb026.co_solicitud "
                  . "left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor "
                  . "left join tb079_chequera as tb079 on tb079.co_chequera = tb063.co_chequera "
                  . "left join tb077_cheque as tb077 on tb079.co_chequera = tb077.co_chequera "
                  . "left join tb076_estado_cheque as tb076 on tb076.co_estado_cheque = tb077.co_estado_cheque "
                  . "where tb063.co_forma_pago = 1 and tb063.co_cuenta_bancaria=".$cuenta;
                  

                  
         // echo var_dump($sql); exit();
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
