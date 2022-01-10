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
        $this->setX(10);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));  
        //$this->SetY(55);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','B',8); 
        $this->Row(array(utf8_decode('LISTA DE AYUDAS')),1,1);        
        
        $this->SetFont('Arial','B',7);     
        $this->SetFillColor(201, 199, 199);
        $this->SetWidths(array(10,50,55,10,20,40,15)); 
        $this->SetAligns(array("L","L","L","L","L","L","L","L"));   
        $this->Row(array(utf8_decode('N°'),utf8_decode('DESCRIPCION'),utf8_decode('REF.'), utf8_decode('N° RES.'),utf8_decode('FECHA RESOLUCION'),utf8_decode('SOLICITANTE'),utf8_decode('ESTATUS')),1,1); 
        $this->SetFillColor(255, 255, 255);

        $this->lista_ayuda = $this->getListaAyuda();         
        foreach($this->lista_ayuda as $key => $valor){

            $this->SetFont('Arial','',7);
            $this->SetWidths(array(10,50,55,10,20,40,15));  
            $this->SetAligns(array("L","L","L","L","L","L","L","L")); 
            $this->Row(array(utf8_decode($valor['co_solicitud']),utf8_decode($valor['tx_tipo_solicitud']).' - '.utf8_decode($valor['tx_tipo_ayuda']),utf8_decode($valor['detalle']),utf8_decode($valor['nu_resolucion']),utf8_decode($valor['fe_resolucion']),utf8_decode($valor['nomb_sol']),utf8_decode($valor['tx_descripcion'])),1,1); 

            if($this->getY()>240){

                $this->AddPage();
                $this->Ln(1);
                $this->setX(10);
                $this->SetWidths(array(200));
                $this->SetAligns(array("C"));  
                //$this->SetY(55);
                $this->SetFillColor(255, 255, 255);
                $this->SetFont('Arial','B',8); 
                $this->Row(array(utf8_decode('LISTA DE AYUDAS')),1,1);        
                
                $this->SetFont('Arial','B',7);     
                $this->SetFillColor(201, 199, 199);
                $this->SetWidths(array(10,50,55,10,20,40,15)); 
                $this->SetAligns(array("L","L","L","L","L","L","L","L"));   
                $this->Row(array(utf8_decode('N° SOLICITUD'),utf8_decode('DESCRIPCION'),utf8_decode('REF.'), utf8_decode('N° RES.'),utf8_decode('FECHA RESOLUCION'),utf8_decode('SOLICITANTE'),utf8_decode('ESTATUS')),1,1); 
                $this->SetFillColor(255, 255, 255);

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
     
    function getListaAyuda(){

        $condicion ="";    
        $condicion .= " tb026.created_at >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb026.created_at <= '".$_GET["fe_fin"]."' ";
        if ($_GET["co_estatus"]) {
            $condicion .= " and tb030.co_estatus_ruta = '".$_GET["co_estatus"]."' ";
        }
        

          $conex = new ConexionComun();     
          $sql = "SELECT tb126.co_solicitud, tb127.tx_tipo_ayuda, upper(tb053.detalle) as detalle, 
            nu_resolucion, fe_resolucion,
            upper(tb008Rec.tx_razon_social) as nomb_sol,
            tb008Rec.tx_rif as rif_sol,
            upper(tb008.tx_razon_social) as nomb_recep,                         
            tb008.tx_rif as rif_recep,
            tb007.inicial as tip_doc_prov,
            tb007b.inicial as tip_doc_sol,
            tb052.monto_total,
            tb053.co_partida,
            tb001.nb_usuario,
            tb126.in_partida,
            tx_documento_odp, fe_pago, tx_descripcion, tx_tipo_solicitud
            from   tb026_solicitud as tb026
            left join tb126_solicitud_ayuda as tb126 on tb126.co_solicitud = tb026.co_solicitud
            left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud
            left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras 
            left join tb091_partida as t on t.id = tb053.co_partida
            left join tb084_accion_especifica as tb084 on tb084.id  = tb053.co_accion_especifica
            left join tb083_proyecto_ac as tb083 on tb083.id = tb053.co_proyecto_ac
            left join tb082_ejecutor as tb082 on tb082.id  = tb083.id_tb082_ejecutor
            left join tb080_sector as tb080 on tb080.id = tb083.id_tb080_sector 
            left join tb127_tipo_ayuda as tb127 on tb127.co_tipo_ayuda = tb126.co_tipo_ayuda
            left join tb008_proveedor as tb008 on tb008.co_proveedor=tb126.co_proveedor
            left join tb008_proveedor as tb008Rec on tb008Rec.co_proveedor=tb126.co_proveedor_solicitante
            left join tb030_ruta as tb030 on tb030.co_solicitud = tb126.co_solicitud
            left join tb001_usuario as tb001 on tb001.co_usuario = tb030.co_usuario
            left join tb007_documento as tb007 on tb007.co_documento=tb008.co_documento
            left join tb007_documento as tb007b on tb007b.co_documento=tb008Rec.co_documento
            left join tb060_orden_pago as tb060 on tb026.co_solicitud=tb060.co_solicitud
            left join tb031_estatus_ruta as tb031 on tb031.co_estatus_ruta = tb030.co_estatus_ruta
            left join tb027_tipo_solicitud as tb027 on tb027.co_tipo_solicitud = tb030.co_tipo_solicitud
            where tb127.tx_tipo_ayuda is not null AND ".$condicion." AND tb030.co_proceso = 4
            group by 1,2,3,4,5,6,7,8,9,10,11,12,13,14, 15, 16, 17, 18, 19 order by 1 asc;";

            //var_dump($sql); exit();
                        
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
