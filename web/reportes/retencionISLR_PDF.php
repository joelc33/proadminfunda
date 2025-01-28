<?php
include("ConexionComun.php");
include('fpdf.php');

class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->empresa = $this->getDatosEmpresa(1);
        if (!empty($this->empresa['tx_imagen_izq'])) {
            $this->Image("imagenes/" . $this->empresa['tx_imagen_izq'], $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
        }

        /*if(!empty($this->empresa['tx_imagen_cen'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_cen'],  $this->empresa['centro_x'], $this->empresa['centro_y'], $this->empresa['centro_w']);
        }*/

        /*  if(!empty($this->empresa['tx_imagen_der'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_der'],  $this->empresa['derecha_x'], $this->empresa['derecha_y'], $this->empresa['derecha_w']);
        }*/

        $this->SetFont('Arial', 'B', 9);

        $this->SetTextColor(0, 0, 0);
        $this->SetY(12);
        $this->Cell(0, 0, utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode($this->empresa['nb_empresa']), 0, 0, 'C');
        if (!empty($this->empresa['nb_institucion'])) {
            $this->Ln(2);
            $this->SetX(52);
            $this->MultiCell(110,4,utf8_decode($this->empresa['nb_institucion']),0,'C',0); 
            $this->Ln(2);
        }else{
        $this->Ln(4);    
        }
        $this->Cell(0, 0, utf8_decode('RIF. ' . $this->empresa['tx_rif']), 0, 0, 'C');
        $this->Ln(4);      

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

         $this->Ln(6);
         $this->SetWidths(array(150));
         $this->SetX(30);
         $this->SetAligns(array("C")); 
         $this->SetFont('Arial','B',12);         
         $this->Row(array(utf8_decode('RETENCIONES ISLR')),0,0);
         $this->Ln(2);
         $this->SetWidths(array(200));
         $this->SetAligns(array("L"));           
         $this->SetFont('Arial','B',8); 
         $this->SetFillColor(255, 255, 255); 
         
        $this->Row(array('RANGO DE FECHA DEL: '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin']))),0,0);          
        $this->Ln(2);

        $nu_total_general=0;
        $nu_base_imponible_general=0;
        $nu_iva_retencion_general=0;
        $this->datos = $this->getRetenciones();
        $this->datos_cuenta = $this->getCuenta( 92);
       
            
            $this->SetFont('Arial','B',7);     
            $this->SetWidths(array(7,25,58,15,25,20,25,12,14 ));  
            $this->SetAligns(array("C","C","C","C","R","R","R","C","C"));   
            $this->Row(array(utf8_decode('Nº'),'Orden de Pago','Beneficiario','Fecha', 'Monto Factura.', 'Base Imp.', 'Monto de Deduc.', 'Porc. %', 'Concepto'),1,0); 
            $this->SetAligns(array("C","L","L","C","R","R","R","C","C"));                  
            //$this->Ln(2);
            $nu_total=0;
            $nu_base_imponible=0;
            $nu_iva_factura=0;
            $nu_iva_retencion=0;
            $i=1;
            foreach($this->datos as $key => $campo){
                
                $this->setX(10);
                $this->SetFont('Arial','',6);
                $this->SetWidths(array(7,25,58,15,25,20,25,12,14 ));  
                $this->Row(array($i,$campo['tx_serial'], utf8_decode($campo['rif'].' - '.$campo['tx_razon_social']), $campo['fechaopera'], 
                number_format($campo['nu_total'], 2, ',','.'), 
                number_format($campo['nu_base_imponible'], 2, ',','.'), 
                number_format($campo['montoopera'], 2, ',','.'),
                $campo['po_retencion'], 
                $campo['concepto'] ),1,0);

                $nu_total = $campo['nu_total'] + $nu_total;
                $nu_base_imponible = $campo['nu_base_imponible'] + $nu_base_imponible;
                $nu_iva_retencion = $campo['montoopera'] + $nu_iva_retencion;

                $nu_total_general = $campo['nu_total'] + $nu_total_general;
                $nu_base_imponible_general = $campo['nu_base_imponible'] + $nu_base_imponible_general;
                $nu_iva_retencion_general = $campo['montoopera'] + $nu_iva_retencion_general;

                if($this->getY()>240){

                    $this->AddPage();
                    $this->setX(10);
                     $this->SetWidths(array(200));
                     $this->SetAligns(array("L"));           
                     $this->SetFont('Arial','B',8); 
                     $this->SetFillColor(255, 255, 255); 

                    $this->Row(array('RANGO DE FECHA DEL: '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin']))),0,0);          

                    $this->Ln(5);
                    $this->SetFont('Arial','B',7);     
                    $this->SetWidths(array(7,25,58,15,25,20,25,12,14 ));   
                    $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));    
                    $this->Row(array(utf8_decode('Nº'),'Orden de Pago','Beneficiario','Fecha', 'Monto Factura.', 'Base Imp.', 'Monto de Deduc.', 'Porc. %', 'Concepto'),1,0); 
                    $this->SetAligns(array("C","L","L","C","R","R","R","C","C"));   

                }
               $i++; 
            }


            if($this->getY()>240){

                    $this->AddPage();
                    $this->setX(10);
                     $this->SetWidths(array(200));
                     $this->SetAligns(array("L"));           
                     $this->SetFont('Arial','B',8); 
                     $this->SetFillColor(255, 255, 255); 

                    $this->Row(array('RANGO DE FECHA DEL: '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin']))),0,0);          

                    $this->Ln(5);
                    $this->SetFont('Arial','B',7);     
                    $this->SetWidths(array(7,25,58,15,25,20,25,12,14 ));   
                    $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));    
                    $this->Row(array(utf8_decode('Nº'),'Orden de Pago','Beneficiario','Fecha', 'Monto Factura.', 'Base Imp.', 'Monto de Deduc.', 'Porc. %', 'Concepto'),1,0); 
                    $this->SetAligns(array("C","L","L","C","R","R","R","C","C"));    

            }

        $this->Ln(5);
        $this->setX(10);
        $this->SetFont( 'Arial', 'B', 8);
        $this->SetWidths(array(105,25,20,25 )); 
        $this->SetAligns(array("R","R","R","R","R"));
        $this->Row(array(utf8_decode('TOTAL: '), 
        number_format($nu_total_general, 2, ',','.'), 
        number_format($nu_base_imponible_general, 2, ',','.'), 
        number_format($nu_iva_retencion_general, 2, ',','.') ),0,0);
         
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

    function getGrupo(){

        $condicion ="";    
        $condicion .= " tb063.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb063.fe_pago <= '".$_GET["fe_fin"]."' ";
    

        $conex = new ConexionComun();
        
        $sql = "SELECT tb045.co_iva_retencion
        FROM tb045_factura as tb045
        inner join tb008_proveedor as tb008 on tb008.co_proveedor = tb045.co_proveedor
        inner join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
        inner join tb060_orden_pago as tb060 ON tb060.co_orden_pago = tb045.co_odp
        inner join tb062_liquidacion_pago as tb062 ON tb062.co_odp = tb060.co_orden_pago
        inner join tb063_pago as tb063 ON tb063.co_liquidacion_pago = tb062.co_liquidacion_pago        
        WHERE ".$condicion."
        group by tb045.co_iva_retencion order by 1 ASC;";
        
        return $conex->ObtenerFilasBySqlSelect($sql);

    }

    function getRetenciones( ){
    

        $conex = new ConexionComun();


           
        $condicion ="";    
        $condicion .= " tb063.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb063.fe_pago <= '".$_GET["fe_fin"]."' ";            
            
       //consulta nueva la que se esta usuando hasta 14-06-2019, se regreso a la consulta vieja para que pueda cuadrar con el modulo de fondos de terceros, se va regresar a la nueva cuando se llegue a la semana donde se habia cambiado a la nueva en su momento 
        $sql = "SELECT inicial||tx_rif as rif, tx_razon_social, tb060.tx_serial, nu_total, nu_base_imponible, '055' as concepto,
        nu_factura as numerofact, 
        nu_control as numerocont, to_char(tb063.fe_pago, 'DD/MM/YYYY') as fechaopera, '055'::text as codigoconc,
        tb046.mo_retencion as montoopera, po_retencion
        FROM tb046_factura_retencion as tb046
        inner join tb041_tipo_retencion as tb041 on tb046.co_tipo_retencion = tb041.co_tipo_retencion
        inner join tb045_factura as tb045 on tb046.co_factura = tb045.co_factura
        inner join tb008_proveedor as tb008 on tb008.co_proveedor = tb045.co_proveedor
        inner join tb007_documento as tb007 on tb007.co_documento = tb008.co_documento
        inner join tb060_orden_pago as tb060 ON tb060.co_orden_pago = tb045.co_odp
        inner join tb062_liquidacion_pago as tb062 ON tb062.co_odp = tb060.co_orden_pago
        inner join tb063_pago as tb063 ON tb063.co_liquidacion_pago = tb062.co_liquidacion_pago        
        where tb046.co_tipo_retencion = 4  and tb060.in_anular is not true AND ".$condicion."
        order by tb063.fe_pago ASC;";         
         
        //echo var_dump($sql); exit();
                    
         

          return $conex->ObtenerFilasBySqlSelect($sql);
  
    }

    function getCuenta( $cuenta){

        $conex = new ConexionComun();

            $sql = "SELECT co_cuenta_bancaria, tx_cuenta_bancaria, co_banco, co_tipo_cuenta, 
            co_empresa, in_activo, co_descripcion_cuenta, co_cuenta_contable, 
            mo_disponible, tx_descripcion, tip_cuenta, tx_cuenta_contable, 
            mo_ingreso, mo_egreso, tip_mov, nu_contrato
            FROM public.tb011_cuenta_bancaria
            WHERE co_cuenta_bancaria = ".$cuenta.";";
                   
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];

    }
    
    function getDatosEmpresa( $codigo){

        $sql = "SELECT co_empresa, nb_empresa, nb_institucion, co_estado, co_municipio, tx_rif, tx_nit, 
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
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
