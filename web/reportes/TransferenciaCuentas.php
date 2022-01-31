<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {


        $this->Image("imagenes/escudosanfco.jpg", 100, 7,20);

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
        $this->Cell(0,0,utf8_decode('TRANSFERENCIA ENTRE CUENTAS'),0,0,'C');      

        $this->Ln(5);

        $this->SetFont('Arial','B',9);     
	
        $this->Ln(5);
        $this->SetTextColor(0,0,0);
        $this->SetX(1);
     

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
                          
         $this->AddPage();  
         $this->SetFont('Arial','',8);
         $this->campo = $this->getDetalleTransf(); 
         $this->Cell(0,0,utf8_decode('San Francisco, '.$this->campo['dia'].' de '.mes($this->campo['mes']).' del '.$this->campo['anio']),0,0,'R');
         $this->SetFont('Arial','B',9);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(60,140));
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetY(65);         
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DETALLES DE TRANSFERENCIA Nro.'.$this->campo['co_solicitud'])),1,1);
         $this->SetFont('Arial','',9); 
         $this->SetFillColor(255, 255, 255);
         $item = 0; 
         
         //$this->SetWidths(array(40,60,55,20,25)); 
         $this->SetWidths(array(50,100,50)); 
         $this->SetAligns(array("L","L","L","L","L","L"));
         //$this->Row(array('FECHA: '.$this->campo['created_at'],'MONTO TRANSFERENCIA: '.$this->campo['mo_debito'],'APROBADOR: '.$this->campo['aprobador'],'ESTADO: '.$this->campo['estado']),1,1);
         $this->Row(array('FECHA: '.$this->campo['created_at'],'MONTO TRANSFERENCIA: '.$this->campo['mo_debito'],'ESTADO: '.$this->campo['estado']),1,1);  
         
         
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Arial','B',9);          
         $this->Row(array(utf8_decode('DATOS DEL DEBITO')),1,1);
         $this->SetFont('Arial','',9); 
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(50,50,50,50)); 
         $this->SetAligns(array("C","C","C","C"));       
         $this->Row(array('BANCO','CUENTA','CODIGO CONTABLE','DEBITO'),1,1);         
         $this->SetFont('Arial','',9); 
         $this->SetAligns(array("L","C","C","R"));
         $this->Row(array($this->campo['bco_deb'],$this->campo['tx_cuenta_bancaria_deb'],$this->campo['cuenta_debito'],number_format($this->campo['mo_debito'], 2, ',','.')),1,1);                  
         
         
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Arial','B',9);          
         $this->Row(array(utf8_decode('DATOS DEL CREDITO')),1,1);
         $this->SetFont('Arial','',9); 
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(50,50,50,50)); 
         $this->SetAligns(array("C","C","C","C"));       
         $this->Row(array('BANCO','CUENTA','CODIGO CONTABLE','CREDITO'),1,1);         
         $this->SetAligns(array("L","C","C","R"));
         $this->Row(array($this->campo['bco_cred'],$this->campo['tx_cuenta_bancaria_cred'],$this->campo['cuenta_credito'],number_format($this->campo['mo_debito'], 2, ',','.')),1,1);                  
            
         
         $this->ln();
         $this->SetAligns(array("L","L", "C"));
	 $this->SetFillColor(255,255,255);
         $this->SetWidths(array(40,160));
         $this->Row(array(utf8_decode('CONCEPTO:'),utf8_decode($this->campo['tx_observacion'])),1,1);
//         $this->SetAligns(array("C","C", "C"));
//	 $this->SetFillColor(201, 199, 199);
//         $this->SetWidths(array(40,120,40));
//         $this->Row(array(utf8_decode('SECRET. ADMIN. Y FINAN.'),utf8_decode('UNIDAD DE TESORERIA'),utf8_decode('MÁXIMA AUTORIDAD')),1,1);
//         $this->SetFillColor(255,255,255);
//         $this->SetWidths(array(40,40,40,40,40));
//         $this->SetAligns(array("L", "L","L","L"));
//         $this->Row(array('Autorizado por:','Elaborado por:','Conformado por:','Autorizado por:','Autorizado por:'),1,1);
//         
//         $this->ln();
//         
//         $this->Cell(0,0,utf8_decode('Usuario del sistema:'),0,0,'L');
//         $this->ln();
//	 $this->SetY($this->GetY()+5);
//         $this->Cell(0,0,utf8_decode(''),0,0,'L');
//         

         $this->SetAligns(array("C","C", "C"));
	 $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(100,100));
         $this->SetFont('Arial','B',7); 
         $this->Row(array(utf8_decode('COORDINACIÓN DE TESORERIA'),utf8_decode('COORDINACIÓN GENERAL DE ADMINISTRACIÓN')),1,1);
         $this->SetFillColor(255,255,255);
         $this->SetWidths(array(40,30,30,40));
         $this->SetAligns(array("L", "L","L","L"));
         $Y = $this->GetY();
         //$this->MultiCell(40,20,'',1,1,'L',1);
         $this->SetY($Y);
         //$this->SetX(50);
         $this->MultiCell(100,20,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(110);
         $this->MultiCell(100,20,'',1,1,'L',1);
         $this->SetY($Y);
//         $this->SetX(170);
//         $this->MultiCell(40,20,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetFont('Arial','',6);
         $this->ln(15);
         $this->SetWidths(array(100,100));
         $this->Row(array('Elaborado por: '.utf8_decode(strtoupper($this->campo['nb_usuario'])),'Conformado por: '),1,1);
         $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->Row(array(utf8_decode('RECIBE CONFORME')),1,1);
	     $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L","L","L"));
         $this->SetWidths(array(50,50,100));
         $Y = $this->GetY();
         $this->MultiCell(80,20,utf8_decode('Nombre y Apellido: ').utf8_decode($this->campo['nb_representante_legal']),1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(90);
         $this->MultiCell(40,20,utf8_decode('CI/RIF: '.$this->campo['inicial'].'-'.$this->campo['tx_rif']),1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(130);
         $this->MultiCell(80,20,utf8_decode('Firma: '),1,1,'L',1);

         $this->ln();
         
         $this->Cell(0,0,utf8_decode('Usuario del sistema: '.utf8_decode($this->campo['nb_usuario'])),0,0,'L');
         $this->ln();
	 $this->SetY($this->GetY()+5);
         $this->Cell(0,0,utf8_decode(''),0,0,'L');      

       

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

    function getDetalleTransf(){

          $conex = new ConexionComun();               
          $sql = "select tb026.co_solicitud,
                         to_char(tb030.created_at,'dd/mm/yyyy') as created_at,
                         to_char(tb030.created_at,'dd') as dia,
                         to_char(tb030.created_at,'mm') as mes,
                         to_char(tb030.created_at,'yyyy') as anio,                          
                         tb066.mo_debito, 
                         tb011_deb.tx_cuenta_bancaria as tx_cuenta_bancaria_deb,
                         tb011_cred.tx_cuenta_bancaria as tx_cuenta_bancaria_cred,
                         tb031.tx_descripcion,
                         tb024_deb.nu_cuenta_contable as cuenta_debito,
                         tb024_cred.nu_cuenta_contable as cuenta_credito,
                         tb010_cred.tx_banco as bco_cred,
                         tb010_deb.tx_banco as bco_deb,
                         tb001_aprob.nb_usuario as aprobador,
                         tb001.nb_usuario as nb_usuario,
                         tb031.tx_descripcion as estado,
                         tb026.tx_observacion
                  FROM tb066_transferencia_cuenta as tb066               
                  left join tb011_cuenta_bancaria as tb011_deb on tb011_deb.co_cuenta_bancaria = tb066.co_cuenta_bancaria_debito
                  left join tb011_cuenta_bancaria as tb011_cred on tb011_cred.co_cuenta_bancaria = tb066.co_cuenta_bancaria_credito
                  left join tb026_solicitud as tb026 on tb026.co_solicitud = tb066.co_solicitud
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor   
                  left join tb010_banco as tb010_cred on tb010_cred.co_banco = tb066.co_banco_credito
                  left join tb010_banco as tb010_deb on tb010_deb.co_banco = tb066.co_banco_debito
                  left join tb031_estatus_ruta as tb031 on tb031.co_estatus_ruta = tb066.co_estado
                  left join tb024_cuenta_contable as tb024_deb on tb024_deb.co_cuenta_contable = tb066.co_cuenta_contable_debito
                  left join tb024_cuenta_contable as tb024_cred on tb024_cred.co_cuenta_contable = tb066.co_cuenta_contable_credito
                  left join tb001_usuario as tb001_aprob on tb001_aprob.co_usuario = tb066.co_usuario_cambio_estado 
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb066.co_usuario                                    
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb066.co_solicitud 
                  where tb030.co_ruta = ".$_GET['codigo'];
                 
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
//$pdf->PrintChapter();
//$pdf->SetDisplayMode('default');
//$pdf->Output();

?>