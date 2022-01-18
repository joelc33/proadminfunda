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
//        $this->Ln(6);
//        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        $this->Ln(6);
        //$this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACION Y FINANZAS'),0,0,'C');
        $this->Cell(0,0,utf8_decode($this->empresa['nb_empresa']),0,0,'C');
        $this->Ln(10);
        $this->Cell(0,0,utf8_decode('SOPORTE DE PAGO'),0,0,'C');      
     

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
         $this->datos = $this->getPagos();
                          
         $this->AddPage();
        $this->Ln(5);
        $this->SetFont('Arial','',8);
        $this->Cell(0,0,utf8_decode('San Francisco, '.$this->datos['dia'].' de '.mes($this->datos['mes']).' del '.$this->datos['anio']),0,0,'R');
 
         $this->Ln(5);
              
         
         $this->line(1, 60, 220, 60);
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(60,140));
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetY(65);
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DATOS GENERALES DEL PAGO')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetAligns(array("L","L","L","L","L","L","L","L"));         
         $this->SetFont('Arial','',7);   
         $this->SetWidths(array(40, 50, 45, 40, 25));        
         $montopag = number_format($this->datos['mo_pagar'], 2, ',','.');
         $montopagado = number_format($this->datos['mo_pagado'], 2, ',','.');
         $montopend = number_format($this->datos['mo_pendiente'], 2, ',','.');
         $this->Row(array('Nro. Serial: '.$this->datos['tx_serial'],'Monto a Pagar: '.$montopag,'Monto Pagado: '.$montopagado,'Monto Pendiente: '.$montopend, 'Fecha: '.$this->datos['fe_emision']),1,1);                           
         $this->SetWidths(array(40,160));
         $montoletra = numtoletras($this->datos['mo_pagar'], 1);        
         $this->Row(array('La Cantidad de: ',$montoletra),1,1);                  
         $this->Row(array(utf8_decode('Beneficiario:'),utf8_decode($this->datos['tx_razon_social'])),1,1); 
         $this->Row(array('Cuenta Proveedor: ',$this->datos['nu_cuenta_bancaria']),1,1);
         //$this->Row(array('Concepto: ',utf8_decode($this->datos['tx_concepto'])),1,1);
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);         
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));         
         
         
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('DETALLES DEL PAGO')),1,1); 
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(20,40,40,30,30,40)); 
         $this->SetAligns(array("C","C","C","C","C","C")); 
         $this->detalle_pago = $this->getDetallePago();
         $item = 0;
         $this->SetFont('Arial','B',6);
         $this->Row(array('NRO.PAGO','BANCO','CUENTA/NRO.CHEQUE','TIPO TRANSACCION','FECHA','MONTO'),1,1);         
         $this->SetFont('Arial','',6);
         $total=0;
         foreach($this->detalle_pago as $key => $campo){
         $item++;
         $this->SetAligns(array("C","C","C","C","C","R")); 
         $this->Row(array($item,$campo['tx_banco'],$campo['cuenta'], $campo['tx_forma_pago'], $campo['fe_pago'],number_format($campo['nu_monto'], 2, ',','.')),1,1);         
         $total=$total+$campo['nu_monto'];         
         }  
         $this->SetAligns(array("R","R"));     
         $this->SetWidths(array(160, 40)); 
         $this->SetFont('Arial','B',7);
         $monto = number_format($total, 2, ',','.');  
         $this->Row(array('Total',$monto),1,1);   
         
         $this->ln();
         $this->SetAligns(array("C","C", "C"));
	     $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(80,80,40));
         $this->Row(array(utf8_decode('SECRET. ADMIN. Y FINAN.'),utf8_decode('UNIDAD DE TESORERIA'),utf8_decode('MÁXIMA AUTORIDAD')),1,1);
         $this->SetFillColor(255,255,255);
         $this->SetWidths(array(80,40,40,40));
         $this->SetAligns(array("L", "L","L","L"));
         $Y = $this->GetY();
         $this->MultiCell(80,25,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(90);
         $this->MultiCell(40,25,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(130);
         $this->MultiCell(40,25,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(170);
         $this->MultiCell(40,25,'',1,1,'L',1);
         $this->SetY($Y);
         $this->SetFont('Arial','',6);
         $this->ln(20);
         $this->Row(array(utf8_decode('Autorizado por: '),'Elaborado por: '.utf8_decode(strtoupper($this->datos['nb_usuario'])),'Conformado por: ','Autorizado por: '),1,1);
         $this->SetFillColor(201, 199, 199);
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->Row(array(utf8_decode('DATOS DE RECEPCIÓN -  REPRESENTANTE LEGAL DEL BENEFICIARIO')),1,1);
	     $this->SetFillColor(255,255,255);
         $this->SetAligns(array("L","L","L"));
         $this->SetWidths(array(50,50,100));
         $Y = $this->GetY();
         $this->MultiCell(80,20,utf8_decode('Nombre y Apellido: ').utf8_decode($this->datos['nb_representante_legal']),1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(90);
         $this->MultiCell(40,20,utf8_decode('CI/RIF: '.$this->datos['inicial'].'-'.$this->datos['tx_rif']),1,1,'L',1);
         $this->SetY($Y);
         $this->SetX(130);
         $this->MultiCell(80,20,utf8_decode('Recibe Conforme: '),1,1,'L',1);

         $this->ln();
         
         $this->Cell(0,0,utf8_decode('Usuario del sistema: '.utf8_decode($this->datos['nb_usuario'])),0,0,'L');
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

    function getPagos(){

          $conex = new ConexionComun();     
          $sql = " select tb008.tx_razon_social,
                          tb008.nb_representante_legal,
                         tb008.tx_rif,
                         tb008.nu_cuenta_bancaria,
                         to_char(tb062.fe_emision,'dd-mm-yyyy') as fe_emision,
                         tb062.tx_serial,
                         tb062.mo_pagar,
                         tb062.mo_pendiente,
                         tb062.mo_pagado,
                         tb039.tx_concepto,
                         to_char(tb063.fe_pago,'dd') as dia,
                         to_char(tb063.fe_pago,'mm') as mes,
                         to_char(tb063.fe_pago,'yyyy') as anio,                          
                         tb001.nb_usuario,
                         inicial                         
                   FROM tb026_solicitud as tb026     
                   left join tb039_requisiciones as tb039 on tb039.co_solicitud = tb026.co_solicitud
                   left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud
                   left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor
                   left join tb063_pago as tb063 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago
                   left join tb001_usuario as tb001 on tb001.co_usuario = tb063.co_usuario 
                   left join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
                   where tb063.co_pago = ".$_GET['codigo'];

                               
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];                         
    }

    function getDetallePago(){

	  $conex = new ConexionComun();
          $sql = "select tb063.fe_pago,
                         tb062.fe_emision, 
                         tb062.tx_serial, 
                         to_char(tb063.fe_pago,'dd-mm-yyyy') as fe_pago, 
                         tb063.nu_monto,
                         tb074.tx_forma_pago,
                         tb010.tx_banco,
                         case when (co_cuenta_bancaria is not null) then                         
                           (select t.tx_cuenta_bancaria from tb011_cuenta_bancaria as t where t.co_cuenta_bancaria = tb063.co_cuenta_bancaria)
                         else
                           (select t.tx_descripcion from tb079_chequera as t where t.co_chequera = tb063.co_chequera) end as cuenta 
                  FROM tb063_pago as tb063
                  left join tb062_liquidacion_pago as tb062 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago
                  left join tb074_forma_pago as tb074 on tb074.co_forma_pago = tb063.co_forma_pago                  
                  left join tb010_banco as tb010 on tb010.co_banco = tb063.co_banco
                  where tb063.co_pago =  ".$_GET['codigo'];                       
           
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
/*
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
