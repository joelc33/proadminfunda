<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->empresa = $this->getDatosEmpresa(1);

        //$this->Image("imagenes/escudosanfco.png", 100, 7,20);

        /*if(!empty($this->empresa['tx_imagen_izq'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_izq'], $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
        }*/
        
        if(!empty($this->empresa['tx_imagen_cen'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_cen'],  $this->empresa['centro_x'], $this->empresa['centro_y'], $this->empresa['centro_w']);
        }

        /*if(!empty($this->empresa['tx_imagen_der'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_der'],  $this->empresa['derecha_x'], $this->empresa['derecha_y'], $this->empresa['derecha_w']);
        }*/

        $this->SetFont('Arial','B',10);
        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('<NOMBRE DE LA INSTITUCION>'),0,0,'C');
        //$this->Ln(6);
        //$this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACION Y FINANZAS'),0,0,'C');
        //$this->Cell(0,0,utf8_decode($this->empresa['nb_empresa']),0,0,'C');
        $this->Ln(10);
        $this->Cell(0,0,utf8_decode('COMPROBANTE DE CAJA'),0,0,'C');      

        $this->Ln(2);
        $this->SetFont('Arial','',8);

        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
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

         $this->Ln(2);
         $this->datos = $this->getPagos();
                          
         $this->AddPage();    
         $this->line(1, 60, 220, 60);
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetY(65);
         $this->solicitud = $this->getBeneficiario();         
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DATOS DEL COMPROBANTE DE CAJA ')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(40,160));
         $this->SetAligns(array("L","L","L","L")); 
         $this->SetFont('Arial','B',7); 
         $this->Row(array(utf8_decode('NRO. REQUISICIÓN: ').$this->solicitud['nu_requisicion'],utf8_decode('CONCEPTO:  ').$this->solicitud['tx_concepto']),1,1);    
         $this->SetWidths(array(40,160));
         $this->SetAligns(array("L","L")); 
         $this->Row(array('BENEFICIARIO: ', $this->solicitud['tx_razon_social']),1,1); 
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DETALLES DEL COMPROBANTE - LIQUIDACION NRO.'.$this->solicitud['tx_serial'])),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetAligns(array("C","C","C","C","C","C"));         
         $this->SetFont('Arial','B',6);    
         $this->SetWidths(array(30, 40, 25, 40, 25, 40));        
         $monto = number_format($this->datos['nu_monto'], 2, ',','.');         
         $this->Row(array('TRANSACCION','CUENTA','NRO.','CONCEPTO','FECHA DE PAGO','MONTO CANCELADO'),1,1);  
         $this->SetFont('Arial','',6);
         $this->Row(array($this->datos['tx_forma_pago'], $this->datos['cuenta'], $this->datos['nu_pago'],  $this->datos['tx_concepto_pago'], $this->datos['fe_emision'],$monto),1,1);  
         $this->SetWidths(array(70,65,65));
         $this->SetAligns(array("C","C","C")); 
         $this->SetFont('Arial','B',6);         
         $this->Row(array('ESTATUS','FECHA DE RECIBIDO','FECHA ULTIMA LLAMADA'),1,1);  
         $this->SetFont('Arial','',6);                 
         $this->Row(array($this->datos['tx_estatus_pago'],$this->datos['fe_emision'],''),1,1);
         $this->SetFont('Arial','',6);
         $this->SetFillColor(255, 255, 255);    
         $this->SetWidths(array(200)); 
         $this->SetAligns(array("C"));//       
         $this->SetFont('Arial','B',6);
         $this->Row(array('OBSERVACIONES'),1,1);
         $this->SetAligns(array("L"));
         $this->MultiCell(200,8,utf8_decode($this->datos['tx_observacion']),1,'J');   
                  
         $this->ln();
         $this->SetAligns(array("C","C", "C"));
	 $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(40,120,40));
         $this->Row(array(utf8_decode('SECRET. ADMIN. Y FINAN.'),utf8_decode('UNIDAD DE TESORERIA'),utf8_decode('MÁXIMA AUTORIDAD')),1,1);
         $this->SetFillColor(255,255,255);
         $this->SetWidths(array(40,40,40,40,40));
         $this->SetAligns(array("L", "L","L","L"));
         $this->Row(array('Autorizado por:','Elaborado por:','Conformado por:','Autorizado por:','Autorizado por:'),1,1);
         $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->Row(array(utf8_decode('DATOS DE RECEPCIÓN -  REPRESENTANTE LEGAL DEL BENEFICIARIO')),1,1);
	 $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L","L","L"));
         $this->SetWidths(array(50,50,100));
         $this->Row(array(utf8_decode('Nombre y Apellido: '.$this->datos['nb_representante_legal']),utf8_decode('CI/RIF: '.$this->datos['tx_rif']), utf8_decode('Recibe Conforme: ')),1,1);

         $this->ln();
         
         $this->Cell(0,0,utf8_decode('Usuario del sistema: '.$this->datos['nb_usuario']),0,0,'L');
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

      function getBeneficiario(){

          $conex = new ConexionComun();     
          $sql = " select distinct tb008.tx_razon_social,                          
                          tb062.tx_serial,
                          tb039.tx_concepto,
                          tb039.nu_requisicion
                   FROM tb026_solicitud as tb026                   
                   left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor
                   left join tb039_requisiciones as tb039 on tb039.co_solicitud = tb026.co_solicitud
                    left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud 
                   left join tb063_pago as tb063 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago 
                   where tb063.co_pago = ".$_GET['codigo'];
                            
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];                        
    }
    function getPagos(){

          $conex = new ConexionComun();     
          $sql = " select tb008.tx_razon_social,
                          tb008.nb_representante_legal,
                          tb008.tx_rif,
                          tb062.tx_serial,
                          tb062.fe_emision,
                          tb063.tx_observacion,
                          tb063.nu_monto,
                          tb001.nb_usuario,
                          case when (co_cuenta_bancaria is not null) then                         
                           (select t.tx_cuenta_bancaria from tb011_cuenta_bancaria as t where t.co_cuenta_bancaria = tb063.co_cuenta_bancaria)
                         else
                           (select t.tx_descripcion from tb079_chequera as t where t.co_chequera = tb063.co_chequera) end as cuenta,
                           tb063.nu_pago,
                           tb074.tx_forma_pago,
                           tb115.tx_estatus_pago,
                           tb116.tx_concepto_pago 
                   FROM tb026_solicitud as tb026
                   left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud
                   left join tb063_pago as tb063 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago
                   left join tb074_forma_pago as tb074 on tb074.co_forma_pago = tb063.co_forma_pago
                   left join tb115_estatus_pago as tb115 on tb115.co_estatus_pago = tb063.co_estatus_pago
                   left join tb116_concepto_pago as tb116 on tb116.co_concepto_pago = tb063.co_concepto_pago
                   left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor                  
                   left join tb001_usuario as tb001 on tb001.co_usuario = tb026.co_usuario                     
                   where tb063.co_pago = ".$_GET['codigo'];
          
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];                         
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