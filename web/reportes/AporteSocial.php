<?php
include("ConexionComun.php");
require('flowing_block.php');


class PDF_Flo extends PDF_FlowingBlock
{
    
    function ChapterBody() {
        
        $this->datos = $this->getAporteSocial();
        
        $this->Image("imagenes/escudosanfco.png", 100, 7,20);

        $this->Ln(8);
        $this->SetX(15);        
        $this->SetFont('Arial','B',7);       
        $this->Cell(0,0,utf8_decode('RESOLUCIÓN Nro.: ').$this->datos['nu_resolucion'],0,0,'L');
        
        $this->SetFont('Arial','B',8);

        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACIÓN Y FINANZAS'),0,0,'C');
        $this->Ln(4);    
        $this->line(20, 45, 190, 45);
        $this->Ln(15); 
         
         $this->SetFont('Arial','BI',10);
         
         $this->Cell(0,0,utf8_decode('MARACAIBO ').date("d/m/Y", strtotime($this->datos['fe_resolucion'])),0,0,'C');
         $this->Ln(5);
         $this->Cell(0,0,utf8_decode('208° y 159° y 19°'),0,0,'C');
         
         $this->Ln(1);         
         $this->SetFont('Arial','BI',14);
         $this->SetFillColor(255, 255, 255);         
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetY(75);
         
         $this->Row(array(utf8_decode('RESUELTO')),0,0);
         $this->SetFillColor(255, 255, 255);
         $this->SetFont('Arial','',10);
         $this->Ln(8);
         $this->SetX(20);
         $this->SetLeftMargin(20);
         $this->SetRightMargin(10);
   
         $this->newFlowingBlock( 170, 8, '', 'J' );
         
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $this->WriteFlowingBlock( utf8_decode('Por disposición del ') );
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );
         $this->WriteFlowingBlock( 'CIUDADANO GOBERNADOR DEL ESTADO ZULIA' );
         
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $data = ", eróguese por la Tesorería del Estado, con cargo a las retenciones realizadas de los Aportes de Responsabilidad Social la cantidad de ";
         $this->SetX(20);
         $this->WriteFlowingBlock(utf8_decode($data));
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );
         $montoletras = numtoletras($this->datos['monto_total'],1);
         $this->SetX(20);
         $this->WriteFlowingBlock(utf8_decode($montoletras));
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 10 );
         $monto = " (Bs.D. ".number_format($this->datos['monto_total'], 2, ',','.').")";
         $this->SetX(20);
         $this->WriteFlowingBlock($monto);
         
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $data = ", por concepto de ".$this->datos['tx_tipo_ayuda']." que concede el Gobierno Regional a ";        
         $this->WriteFlowingBlock(utf8_decode($data));
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );
         $beneficiado = $this->datos['nomb_sol'];           
         $this->WriteFlowingBlock(utf8_decode($beneficiado));
         
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $data = ", titular de la titular de la C.I./RIF Nro. ".$this->datos['tip_doc_sol']."-".$this->datos['rif_sol'].", como apoyo de ";        
         $this->WriteFlowingBlock(utf8_decode($data));
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );
         $motivo = $this->datos['detalle'];
         $this->WriteFlowingBlock(utf8_decode($motivo));

         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $data = ". Tal suma será pagada "; 
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );
         $receptor = "a: ".$this->datos['nomb_recep'].", C.I./RIF ".$this->datos['tip_doc_prov']."-".$this->datos['rif_recep']; 
         $this->WriteFlowingBlock(utf8_decode($receptor));
         
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $data = ", para los fines antes indicados.";
         $this->WriteFlowingBlock(utf8_decode($data));
         
         $this->SetX(20);
         $this->finishFlowingBlock();
         
         $this->Ln(20);
         $this->SetFont( 'Arial', 'B', 10 );
         $this->SetX(20);
         $this->Cell(0,0,utf8_decode('Regístrese y Comuníquese'),0,0,'L');
         $this->Ln(20);
         $this->SetX(20);
         $this->Cell(0,0,utf8_decode('LA SECRETARIA DE ADMINISTRACIÓN Y FINANZAS'),0,0,'L');
         $this->Ln(5);
         $this->SetX(20);
         $this->Cell(0,0,utf8_decode('L.S.(FDO.) LCDA. RAISA BRICEÑO'),0,0,'L');
         
         $this->Ln(50); 
         $this->SetX(20);
         $this->Cell(0,0,utf8_decode('Usuario del sistema: '.$this->datos['nb_usuario']),0,0,'L');
        
    }

    function getAporteSocial(){

          $conex = new ConexionComun(); 
          
          $sql = "SELECT tb127.tx_tipo_ayuda, upper(tb126.tx_observacion) as tx_observacion, 
                         nu_resolucion, fe_resolucion,
                         upper(tb008Rec.tx_razon_social) as nomb_sol,
                         tb008Rec.tx_rif as rif_sol,
                         upper(tb008.tx_razon_social) as nomb_recep,                         
                         tb008.tx_rif as rif_recep,
                         tb007.inicial as tip_doc_prov,
                         tb007b.inicial as tip_doc_sol,
                         tb052.monto_total,
                         tb001.nb_usuario,
                         tb053.detalle
                  from   tb026_solicitud as tb026
                  left join tb126_solicitud_ayuda as tb126 on tb126.co_solicitud = tb026.co_solicitud
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud
                  left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras                   
                  left join tb127_tipo_ayuda as tb127 on tb127.co_tipo_ayuda = tb126.co_tipo_ayuda
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb126.co_proveedor
                  left join tb008_proveedor as tb008Rec on tb008Rec.co_proveedor=tb126.co_proveedor_solicitante
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb126.co_solicitud
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb030.co_usuario
                  left join tb007_documento as tb007 on tb007.co_documento=tb008.co_documento
                  left join tb007_documento as tb007b on tb007b.co_documento=tb008Rec.co_documento
                  where tb030.co_ruta = ".$_GET['codigo']; //$conex->decrypt($_GET['codigo']);
                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0]; 
    }


}

$pdf = new PDF_Flo('P','mm','letter');
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->ChapterBody();

$comm = new ConexionComun();
$ruta = $comm->getRuta();
//rmdir($ruta);
//mkdir($ruta, 0777, true);    

$dir="$ruta".$_GET["codigo"].".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";

$update = "update tb030_ruta set tx_ruta_reporte = '".$dir."' where co_ruta = ".$_GET['codigo']; //$comm->decrypt($_GET["codigo"]);


$comm->Execute($update);    
$pdf->SetMargins(0, 0);
$pdf->Output($dir, 'F');
 

//$pdf = new PDF_Flo('P','mm','letter');
//$pdf->AddPage();
//$pdf->ChapterBody();
//$pdf->Output();

?>
