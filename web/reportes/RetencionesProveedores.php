<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {


        $this->Image("imagenes/escudosanfco.png", 100, 7,20);

        $this->SetFont('Arial','B',9);
        
      //  $this->datos = $this->getTipoOrdenes();

        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('TESORERIA GENERAL'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('RETENCIONES POR PROVEEDORES'),0,0,'C');
        $this->Ln(5);
        $this->SetFont('Arial','',8);

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

         $this->datos = $this->getRetenciones();

                  
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->Ln();
         $this->SetFont('Arial','B',8);
         $this->Row(array(utf8_decode('RELACIÓN DE PROVEEDORES - DEL DIA: '.' AL ')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(15,20,15,150));         
         $this->SetFont('Arial','B',6);
         $campo='';
         $this->lista_proveedores = $this->getProveedores();
       //  foreach($this->lista_proveedores as $key => $campo){        
          $this->Row(array(utf8_decode('RIF:'),'',utf8_decode('Proveedor:'),''),1,1);
          $this->SetFont('Arial','',6);
            $this->lista_retenciones = $this->getRetenciones();
            //  foreach($this->lista_retenciones as $key => $campo){ 
                $this->SetAligns(array("L","L","L","L","L","L","L","L"));
                $this->SetWidths(array(15,20,15,80,15,15,20,20)); 
                $this->Row(array('Nro.Factura:','',utf8_decode('Descripción:'),'','Orden Pago:','','Fecha:',''),1,1);
                $this->SetAligns(array("C","C","C","C"));
                $this->SetWidths(array(50,50,60,40)); 
                $this->Row(array(utf8_decode('Retención'),'Cheque/Transferencia','Banco/Cuenta Bancaria',utf8_decode('Monto Retención')),1,1);
                $this->SetAligns(array("L","L","L","R"));
                //$this->Row(array('','','',''),1,1);
               // $this->Row(array(utf8_decode('nro Retención nro - IVA'),number_format($this->lista_facturas['nu_iva_retencion'], 2, ',','.'),'',''),1,1);
                $this->SetAligns(array("R","R"));
                $this->SetWidths(array(160,40)); 
                $this->SetFont('Arial','B',6);
                $this->Row(array(utf8_decode('Total Retención'),''),1,1);
            //}               
       //  }
        
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

    function PrintChapter() {
        $this->AddPage();
        $this->ChapterBody();
    }

    function getProveedores(){

          $conex = new ConexionComun();     
          $sql = "   select distinct   nu_factura, 
                          fe_emision, 
                          nu_base_imponible,
                          nu_iva_factura, 
                          nu_total, 
                          total_pagar,
                          nu_total_retencion,
                          nu_iva_retencion, 
                          tb045.tx_concepto,  
                          numero_compra,
                         tb008.tx_razon_social,
                         tb008.tx_rif,
                         tb008.tx_direccion,                         
                         tb008.nb_representante_legal,
                         tb008.nu_cedula_representante,
                         tb008.tx_email,
                         tb047.tx_ente
                  from   tb045_factura as tb045                                                    
                  left join tb052_compras as tb052 on tb052.co_compras = tb045.co_compra
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb052.co_proveedor
                  left join tb039_requisiciones as tb039 on tb045.co_solicitud = tb039.co_solicitud
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb039.co_usuario
                  left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb045.co_solicitud 
                  where tb030.co_ruta = ".$_GET['codigo'];
                  //.$_GET['co_ruta'];
                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];                
         
    }
    
    

    function getRetenciones(){

	  $conex = new ConexionComun();
          $sql = "select  nu_total_retencion, 
                          total_pagar,
                          po_retencion,
                          mo_retencion,
                          nu_total_retencion,
                          tx_tipo_retencion
                  from   tb045_factura as tb045     
                  left join tb046_factura_retencion as tb046 on tb046.co_factura = tb045.co_factura
                  left join tb041_tipo_retencion as tb041 on tb041.co_tipo_retencion = tb046.co_tipo_retencion
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb045.co_solicitud                  
                  where tb030.co_ruta = ".$_GET['codigo']; 
                       
           
          return $conex->ObtenerFilasBySqlSelect($sql);
  
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
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
