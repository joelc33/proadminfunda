<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {


        $this->empresa = $this->getDatosEmpresa(1);

        $this->Image("imagenes/escudosanfco.png", 100, 7,20);

        $this->SetFont('Arial','B',10);
        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode($this->empresa['nb_empresa']),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode($this->empresa['nb_institucion']),0,0,'C');
        $this->Ln(8);
        $this->Cell(0,0,utf8_decode('TRANSFERENCIA ENTRE CUENTAS'),0,0,'C');      

        $this->Ln(5);
        $this->SetFont('Arial','',8);

        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
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
         $this->line(1, 60, 220, 60);
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(60,140));
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetY(65);         
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DETALLES DE TRANSFERENCIA')),1,1);
         $this->SetFont('Arial','B',6); 
         $this->SetFillColor(255, 255, 255);
         $item = 0; 
         $this->campo = $this->getDetalleTransf(); 
         $this->SetWidths(array(20,20,30,30,25,30,20,25)); 
         $this->SetAligns(array("L","L","L","L","L","L"));
         $this->Row(array('FECHA:',$this->campo['created_at'],'MONTO TRANSFERENCIA:',$this->campo['mo_debito'],'APROBADOR:',$this->campo['aprobador'],'ESTADO:',$this->campo['estado']),1,1); 
         
         
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DATOS DEL DEBITO')),1,1);
         $this->SetFont('Arial','B',6); 
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(50,50,50,50)); 
         $this->SetAligns(array("C","C","C","C"));       
         $this->Row(array('BANCO','CUENTA','CODIGO CONTABLE','DEBITO'),1,1);         
         $this->SetFont('Arial','',6); 
         $this->SetAligns(array("L","C","C","R"));
         $this->Row(array($this->campo['tx_banco_deb'],$this->campo['tx_cuenta_bancaria_deb'],$this->campo['cuenta_debito'],number_format($this->campo['mo_debito'], 2, ',','.')),1,1);                  
         
         
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DATOS DEL CREDITO')),1,1);
         $this->SetFont('Arial','B',6); 
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(50,50,50,50)); 
         $this->SetAligns(array("C","C","C","C"));       
         $this->Row(array('BANCO','CUENTA','CODIGO CONTABLE','CREDITO'),1,1);         
         $this->SetFont('Arial','',6); 
         $this->SetAligns(array("L","C","C","R"));
         $this->Row(array($this->campo['tx_banco_cred'],$this->campo['tx_cuenta_bancaria_cred'],$this->campo['cuenta_credito'],number_format($this->campo['mo_debito'], 2, ',','.')),1,1);                  
            
         $this->ln();
         $this->SetAligns(array("C","C", "C"));
	 $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(40,120,40));
         $this->Row(array(utf8_decode('SECRET. ADMIN. Y FINAN.'),utf8_decode('UNIDAD DE TESORERIA'),utf8_decode('MÁXIMA AUTORIDAD')),1,1);
         $this->SetFillColor(255,255,255);
         $this->SetWidths(array(40,40,40,40,40));
         $this->SetAligns(array("L", "L","L","L"));
         $this->Row(array('Autorizado por:','Elaborado por:','Conformado por:','Autorizado por:','Autorizado por:'),1,1);
         
         $this->ln();
         
         $this->Cell(0,0,utf8_decode('Usuario del sistema:'),0,0,'L');
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

     function getDatosEmpresa($codigo)
    {

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
        WHERE co_empresa = " . $codigo . ";";

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return $datosSol[0];

    }

    function PrintChapter() {
        //$this->AddPage();
        $this->ChapterBody();
    }

    function getDetalleTransf(){

          $conex = new ConexionComun();               
          $sql = "select tb066.created_at,
                         tb066.mo_debito, 
                         tb010_cred.tx_banco as tx_banco_deb,
                         tb010_deb.tx_banco as tx_banco_cred,
                         tb011_deb.tx_cuenta_bancaria as tx_cuenta_bancaria_deb,
                         tb011_cred.tx_cuenta_bancaria as tx_cuenta_bancaria_cred,
                         tb031.tx_descripcion,
                         tb024_deb.nu_cuenta_contable as cuenta_debito,
                         tb024_cred.nu_cuenta_contable as cuenta_credito,
                         tb010_cred.tx_banco as bco_cred,
                         tb010_deb.tx_banco as bco_deb,
                         tb001_aprob.nb_usuario as aprobador,
                         tb031.tx_descripcion as estado
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

/*
$pdf=new PDF('P','mm','letter');
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();
*/
?>