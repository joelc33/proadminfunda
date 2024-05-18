<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->empresa = $this->getDatosEmpresa(1);

        $this->datos = $this->getDeclaracion();

        //$this->Image("imagenes/escudosanfco.png", 100, 7,20);

        if(!empty($this->empresa['tx_imagen_cen'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_cen'],  $this->empresa['centro_x'], $this->empresa['centro_y'], $this->empresa['centro_w']);
        }

        $this->SetFont('Arial','B',10);
        $this->SetTextColor(0,0,0);
        $this->SetY(34);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('<NOMBRE DE LA INSTITUCION>'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('RIF. G-200005297'),0,0,'C');        
        //$this->Ln(6);
        //$this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACION Y FINANZAS'),0,0,'C');
        //$this->Cell(0,0,utf8_decode($this->empresa['nb_empresa']),0,0,'C');
        $this->Ln(15);
        $this->SetFont('Arial','B',10);
        $this->Cell(0,0,utf8_decode('PAGO DE FONDOS DE TERCEROS'),0,0,'C');
        $this->Ln(5);
        $this->SetFont('Arial','',8);

        //$this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
//        $this->Cell(0,0,utf8_decode('Maracaibo, '.$this->datos['dia'].' de '.mes($this->datos['mes']).' del '.$this->datos['anio']),0,0,'R');
        
        $this->Ln(6);
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

         
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->Ln();
         $this->SetFont('Arial','B',8); 
         $this->Row(array(utf8_decode('DATOS DE LA DECLARACIÓN')),1,1);
         $this->SetFillColor(255, 255, 255);        
         $this->SetAligns(array("L","L","C", "C"));
         $this->SetWidths(array(30,35,60,75)); 
        
         $campo='';
         $campo = $this->getDeclaracion();           
         $this->SetFont('Arial','B',8);          
         $this->Row(array(utf8_decode('Nro.Declaración:'),$campo['nu_declaracion'],utf8_decode('Fecha de Emisión: ').$campo['fe_emision'],utf8_decode('Monto a Pagar:  ').number_format($campo['mo_pagar'], 2, ',','.')),1,1);
         $this->SetWidths(array(30,170)); 
         $this->SetFont('Arial','',8);
         $this->Row(array(utf8_decode('Concepto:'),utf8_decode($campo['tx_observacion'])),1,1);         
         $this->SetAligns(array("L","L","L","L"));
         $this->SetWidths(array(30,110, 60));   
         $this->Row(array(utf8_decode('Razón Social:'),$campo['tx_razon_social'],utf8_decode('R.I.F: ').utf8_decode($campo['tx_rif'])),1,1);                  
         $this->SetWidths(array(30,170)); 
         $this->Row(array(utf8_decode('Dirección Fiscal:'),$campo['tx_direccion']),1,1); 
         
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Arial','B',8); 
         $this->Row(array(utf8_decode('DETALLES DE RETENCIONES')),1,1);
         $this->SetAligns(array("C","C","C","C"));
         $this->SetWidths(array(45,30,80,45));
         $this->Row(array(utf8_decode('Tipo Retención'),utf8_decode('Clase Retención'),'Detalle','Monto a pagar'),1,1);
         $this->SetFillColor(255, 255, 255); 
         $this->SetFont('Arial','',7);                   
         $campo1='';
         $total = 0;
         $this->lista_retenciones = $this->getRetenciones();
         foreach($this->lista_retenciones as $key => $campo1){  
          $this->SetAligns(array("C","C","C","R"));
          $this->Row(array(utf8_decode($campo1['tx_tipo_retencion']),utf8_decode($campo1['tx_clase_retencion']),utf8_decode($campo1['tx_observacion']),number_format($campo1['monto'], 2, ',','.')),1,1);
          $total = $total + $campo1['monto'];
         }
         $this->SetAligns(array("R","R"));
         $this->SetWidths(array(155,45));
         $this->SetFont('Arial','B',8); 
         $this->Row(array('Total de Retenciones', number_format($total, 2, ',','.')),1,1);
         
         $this->ln();
         
         $this->Cell(0,0,utf8_decode('Usuario del sistema: '.$campo['nb_usuario']),0,0,'L');
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

    function getDeclaracion(){

          $conex = new ConexionComun();     
          $sql = "   select tb069.fe_emision, 
                          tb069.nu_declaracion,
                          tb069.tx_observacion, 
                          tb069.mo_pagar,                           
                          tb008.tx_razon_social,
                          tb008.tx_rif,
                          tb008.tx_direccion,
                          tb001.nb_usuario,
                          to_char(tb069.fe_emision,'dd') as dia,
                          to_char(tb069.fe_emision,'mm') as mes,
                          to_char(tb069.fe_emision,'yyyy') as anio
                  from   tb026_solicitud as tb026                                                    
                  left join tb069_fondo_tercero as tb069 on tb069.co_solicitud = tb026.co_solicitud
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor                  
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb026.co_usuario                  
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb026.co_solicitud 
                  where tb030.co_ruta = ".$_GET['codigo'];
                  //.$_GET['co_ruta'];
                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];     
         
    }
    
    

    function getRetenciones(){

	  $conex = new ConexionComun();
          $sql = "select  tx_tipo_retencion, 
                          tx_clase_retencion,
                          monto,
                          tb070.tx_observacion
                  from   tb026_solicitud as tb026   
                  left join tb069_fondo_tercero as tb069 on tb069.co_solicitud = tb026.co_solicitud
                  left join tb070_detalle_fondo as tb070 on tb070.co_fondo_tercero = tb069.co_fondo_tercero 
                  left join tb041_tipo_retencion as tb041 on tb041.co_tipo_retencion = tb070.co_tipo_retencion
                  left join tb072_clase_retencion as tb072 on tb072.co_clase_retencion = tb041.co_clase_retencion
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb026.co_solicitud                  
                  where tb070.in_anular is null AND tb030.co_ruta = ".$_GET['codigo']; 
                       
           
          return $conex->ObtenerFilasBySqlSelect($sql);
    }

    function getDatosEmpresa( $codigo){

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
        WHERE co_empresa = ".$codigo.";";

        $conex = new ConexionComun();
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
$pdf->Output();*/


?>
