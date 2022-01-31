<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {
     $this->SetFont('Arial','B',8);
     
    }

    function Footer() {
	$this->SetFont('Arial','',9);     
	$this->SetY(-20);
	$this->Cell(0,0,utf8_decode(''),0,0,'C');                  
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

   
        
     function CuerpoFactura() {

        $this->empresa = $this->getDatosEmpresa(1);

         $this->Ln(1);

         $this->lista_facturas = $this->getFacturas();

         $campo='';         
         foreach($this->lista_facturas as $key => $campo){ 
         $this->AddPage(); 
         $this->SetFont('Arial','B',8);
         //$this->Image("imagenes/escudosanfco.png", 20, 7,20);  
         
         
        if(!empty($this->empresa['tx_imagen_izq'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_izq'], $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
        }
        
        /*if(!empty($this->empresa['tx_imagen_cen'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_cen'],  $this->empresa['centro_x'], $this->empresa['centro_y'], $this->empresa['centro_w']);
        }*/

        /*if(!empty($this->empresa['tx_imagen_der'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_der'],  $this->empresa['derecha_x'], $this->empresa['derecha_y'], $this->empresa['derecha_w']);
        }*/

         $this->SetTextColor(0,0,0);
         $this->SetY(12);
         $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
         $this->Ln(4);
         $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
         $this->Ln(5);
         $this->Cell(0,0,utf8_decode('RIF. G-200005297'),0,0,'C'); 
         $this->Ln(12);
         $this->SetFont('Arial','B',14);       
         $this->Cell(0,0,utf8_decode(' CONSIGNACIÓN '),0,0,'C');   
         
         $this->SetY(50);
         
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);         
         $this->SetFont('Arial','B',9);
         $this->Row(array(utf8_decode('DATOS DE LA FACTURA')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetFont('Arial','',9);
         $this->SetAligns(array("L","L","L","L"));
         $this->SetWidths(array(50,50,50,50));         
         $this->Row(array(utf8_decode('No.FACTURA:').$campo['nu_factura'],utf8_decode('No.COMPRA:').$campo['numero_compra'], 'No.CONTROL:'.$campo['nu_control'], utf8_decode('MONTO:  ').number_format($campo['nu_total'], 2, ',','.')),1,1);
         $this->SetWidths(array(200)); 
         $this->Row(array(utf8_decode('FECHA EMISION:'.$campo['fe_emision'])),1,1);
         $this->Row(array(utf8_decode('SEÑOR(ES):'.$campo['tx_razon_social']).'- R.I.F:'.utf8_decode($campo['tx_rif'])),1,1);                  
         $this->Row(array(utf8_decode('DIRECCIÓN:').$campo['tx_direccion']),1,1); 
         $this->Row(array(utf8_decode('CONCEPTO:').utf8_decode($campo['tx_concepto'])),1,1);                  
         $this->Ln();                          
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(201, 199, 199);
         $this->SetFont('Arial','B',9); 
         $this->Row(array(utf8_decode('RETENCIONES ASOCIADAS')),1,1);
         $this->SetFillColor(255, 255, 255); 
         $this->SetFont('Arial','',9); 
         $this->SetAligns(array("C","C","C","C"));
         $this->SetWidths(array(50,50,50,50));
         $datos_excento = $this->TotalExcento();
         $this->Row(array('BASE IMPONIBLE:  '.number_format($campo['nu_base_imponible']-$datos_excento['mo_exento'], 2, ',','.'),'IVA:  '.number_format($campo['nu_iva_factura'], 2, ',','.'),utf8_decode('MONTO EXENTO: ').number_format($datos_excento['mo_exento'], 2, ',','.'),'TOTAL A PAGAR:  '.number_format($campo['total_pagar'], 2, ',','.')),1,1);
         
         $this->SetFont('Arial','',9); 
         $this->SetAligns(array("L","R","R"));    
         $this->SetWidths(array(85,30,85));
         $campo1='';
         $this->lista_retenciones = $this->getRetenciones($campo['co_factura']);
         foreach($this->lista_retenciones as $key => $campo1){                    
          $this->Row(array(utf8_decode($campo1['tx_tipo_retencion']),$campo1['po_retencion'].' %',number_format($campo1['mo_retencion'], 2, ',','.')),1,1);
         }        
         
        
        $this->Ln();  
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));
        $this->SetFont('Arial','B',9); 
        $this->SetFillColor(201, 199, 199);
        $this->Row(array(utf8_decode('CATEGORIAS PRESUPUESTARIAS')),1,1);
        $this->SetFillColor(255, 255, 255);    
        $this->lista_partidas = $this->getPart();
        $this->SetWidths(array(70,80,50));        
        $this->SetAligns(array("L","L","R"));  
        $this->Row(array(utf8_decode('CÓDIGO'),utf8_decode('DESCRIPCIÓN DE PARTIDA'),utf8_decode('MONTO')),1,1); 
        $this->SetFont('Arial','',9);          
         foreach($this->lista_partidas as $key => $campo2){     
         $this->Row(array(utf8_decode($campo2['co_categoria']),utf8_decode($campo2['de_partida']),number_format($campo2['monto'], 2, ',','.')),1,1); 
         }

        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));
        $this->SetFont('Arial','B',9); 
        $this->SetFillColor(201, 199, 199);
        $this->Row(array(utf8_decode('CODIGOS CONTABLES')),1,1);
        $this->SetFillColor(255, 255, 255);    
        $this->lista_asientos = $this->getAsientos($campo['co_solicitud']);
        $this->SetWidths(array(70,80,50));        
        $this->SetAligns(array("C","R","R"));  
        $this->Row(array(utf8_decode('CUENTA'),utf8_decode('DEBITOS'),utf8_decode('CREDITOS')),1,1); 
        $this->SetFont('Arial','',9);          
         foreach($this->lista_asientos as $key => $campo2){   
         $this->SetAligns(array("R","R","R"));
         $this->Row(array(utf8_decode($campo2['tx_cuenta']),number_format($campo2['mo_debe'], 2, ',','.'),number_format($campo2['mo_haber'], 2, ',','.')),1,1); 
         }         
         
         $this->ln();
         
         $this->Cell(0,0,utf8_decode('Usuario del sistema: '.$campo['nb_usuario']),0,0,'L');
         $this->ln();
	 $this->SetY($this->GetY()+5);
         $this->Cell(0,0,utf8_decode(''),0,0,'L');

        } 
        $this->CuerpoRetenciones();

    }
    
    function CuerpoRetenciones() {  
        
        $this->empresa = $this->getDatosEmpresa(1);

         $campo='';
         
         $this->datos = $this->getFacturas(); 
         foreach($this->datos as $key => $campo){ 
             
         $this->lista_retenciones = $this->getRetenciones($campo['co_factura']);
         
         foreach($this->lista_retenciones as $key => $campo1){                             
            $this->addPage();
            $this->SetFont('Arial','B',8);
            //$this->Image("imagenes/escudosanfco.png", 20, 7,20); 
            
            if(!empty($this->empresa['tx_imagen_izq'])){
                $this->Image("imagenes/".$this->empresa['tx_imagen_izq'], $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
            }
            
            /*if(!empty($this->empresa['tx_imagen_cen'])){
                $this->Image("imagenes/".$this->empresa['tx_imagen_cen'],  $this->empresa['centro_x'], $this->empresa['centro_y'], $this->empresa['centro_w']);
            }*/
    
            /*if(!empty($this->empresa['tx_imagen_der'])){
                $this->Image("imagenes/".$this->empresa['tx_imagen_der'],  $this->empresa['derecha_x'], $this->empresa['derecha_y'], $this->empresa['derecha_w']);
            }*/

            $this->SetTextColor(0,0,0);
             $this->SetY(12);
             $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
             $this->Ln(4);
             $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
             $this->Ln(5);
             $this->Cell(0,0,utf8_decode('RIF. G-200005297'),0,0,'C');        
            $this->Ln(8);

            $this->SetWidths(array(140,30, 30));
            $this->SetAligns(array("L","R","L"));
            $this->SetFont('Arial','',8);
//            $this->Row(array('','Fecha Comprob.: ',$campo1['fe_emision']),0,0);   
//            $this->Row(array('','Periodo Fiscal: ', utf8_decode('AÑO: '.$campo1['anio'].' / MES: '.$campo1['mes'])),0,0);   
//            $this->Row(array('','Comprob. Nro.: ',$campo1['anio'].'-'.$campo1['co_factura_retencion']),0,0); 
//            $this->Row(array('','Nro. Factura: ',$campo['nu_factura']),0,0); 
//            $this->Row(array('','Nro. Control: ',$campo['nu_control']),0,0); 
            $this->SetWidths(array(200));
            $this->SetAligns(array("C")); 
            $this->Ln(8);            
            
            $this->SetFont('Arial','B',12);
            $this->Cell(0,0,utf8_decode('COMPROBANTE DE RETENCIÓN DE '.strtoupper($campo1['tx_tipo_retencion'])),0,0,'C');   
            $this->Ln(8);  
            $this->SetFont('Arial','',10);
            $texto = "";
            // Retención IVA
            if(($campo1['co_tipo_retencion'])==92)  $texto = 'Decreto con Rango, Valor y Fuerza de Ley de Reforma de la ley del Impuesto al Valor Agregado N° 1,436 del 17 de Noviembre de 2014. Articulo 11: La Administración Tributaria podra designar como responsables del pago de impuesto, en calidad de agentes de retención, a quienes por funciones publicas o por razón de sus actividades privadas intervengan en operaciones con el impuesto establecido en este Decreto con Rango, Valor y Fuerza de ley. (...)';
            // Retencion ISLR
           // if(($campo1['co_tipo_retencion'])==4)  $texto = 'Gaceta Oficial Nro. 36.206 del 12/05/1997 Decreto Nro.1808 del 23/04/1997'; 
            
            if($campo1['co_tipo_retencion']==92){
            
            $this->MultiCell(200,4,utf8_decode($texto),0,1,'J',0);
            
            $this->SetY(65);
            $this->setX(180);
            $this->SetFillColor(201, 199, 199);
            $this->SetWidths(array(30,30, 30));
            $this->SetAligns(array("C","R","L"));
            $this->SetFont('Arial','',8);
            $this->Row(array(utf8_decode('Fecha de Emisión ')),1,1);
            $this->SetFillColor(255, 255, 255);
            $this->setX(180);
            $this->Row(array(utf8_decode($campo1['fe_emision'])),1,1);
            
            $this->SetY(80);
            $this->setX(180);
            $this->SetFillColor(201, 199, 199);
            $this->SetWidths(array(30,30, 30));
            $this->SetAligns(array("C","R","L"));
            $this->SetFont('Arial','',8);
            $this->Row(array(utf8_decode('No. Comprobante ')),1,1);
            $this->setX(180);
            $this->SetFillColor(255, 255, 255);
            $this->Row(array(utf8_decode($campo1['anio'].$campo1['mes'].$campo1['nu_comprobante'])),1,1);
            
            $this->SetY(95);
            $this->setX(180);
            $this->SetFillColor(201, 199, 199);
            $this->SetWidths(array(30,30, 30));
            $this->SetAligns(array("C","R","L"));
            $this->SetFont('Arial','',8);
            $this->Row(array(utf8_decode('Periodo Fiscal ')),1,1);
            $this->setX(180);
            $this->SetFillColor(255, 255, 255);
            $this->Row(array(utf8_decode('Año: '.$campo1['anio'].' Mes: '.$campo1['mes'])),1,1);            
            
            //$this->MultiCell(200,4,utf8_decode($texto),0,1,'J',0);
            $this->Ln(5); 
            $this->SetY(65);
            $this->SetWidths(array(160));
            $this->SetAligns(array("C"));
            $this->SetFillColor(201, 199, 199); 
            $this->SetFont('Arial','B',10);            
            $this->Row(array(utf8_decode('DATOS DEL AGENTE DE RETENCIÓN')),1,1);
            $this->SetFillColor(255, 255, 255);
            $this->SetAligns(array("L","L","L","L"));
            $this->SetWidths(array(110,50));                 
            $this->SetFont('Arial','',9);          
            //$this->Row(array(utf8_decode('Empresa.: GOBERNACIÓN DEL EDO. ZULIA'),utf8_decode('R.I.F.:  G-200036524')),1,1);    
            $this->Row(array(utf8_decode('Nombre o Razón Social.: '.$this->empresa['nb_empresa']),utf8_decode('R.I.F.: '.$this->empresa['tx_rif'])),1,1);              
            $this->SetWidths(array(160));
            //$this->Row(array(utf8_decode('Dirección: AV. BELLA VISTA EDIFICIO FEDERAL MARACAIBO EDO. ZULIA')),1,1);  
            $this->Row(array(utf8_decode('Dirección: '.$this->empresa['tx_direccion'])),1,1);            
            
            $this->Ln(5); 
            $this->SetFillColor(201, 199, 199);
            $this->SetFont('Arial','B',10);
            $this->SetWidths(array(160));
            $this->SetAligns(array("C"));
            $this->Row(array(utf8_decode('DATOS DEL (PROVEEDOR / BENEFICIARIO)')),1,1);
            $this->SetFillColor(255, 255, 255);
            $this->SetWidths(array(110,50,50));
            $this->SetAligns(array("L","L","L","L"));
            $this->SetFont('Arial','',9);
            $this->Row(array(utf8_decode('Nombre o Razón Social.: ').$campo['tx_razon_social'],utf8_decode('R.I.F.:  ').$campo['tx_rif']),1,1);         
            $this->SetWidths(array(160));
            $this->Row(array(utf8_decode('Dirección: ').$campo['tx_direccion']),1,1);             
 
            $this->Ln(7);

            $this->SetWidths(array(200));
            $this->SetAligns(array("C"));
            $this->SetFillColor(201, 199, 199);
            $this->SetFont('Arial','B',10); 
            $this->Row(array(utf8_decode('RETENCIÓN (COMPRAS INTERNAS O IMPORTACIONES)')),1,1);
            $this->SetFillColor(255, 255, 255); 
            $this->SetAligns(array("C","C","C","C","C","C","C","C"));
            $this->SetWidths(array(25,20,20,25,25,25,25,35));         
            $this->SetFont('Arial','',9);            
            //$this->Row(array('Fecha: '.$campo['fe_emision'],'Monto Factura: '.number_format($campo['nu_total'], 2, ',','.'),'Monto Exento: '.number_format($campo['monto_excento'], 2, ',','.')),1,1);
            $this->Row(array('Fecha Factura','No. Factura','No. Control','N/D','N/C','Factura Afectada','Monto Factura','Compras sin Credito fiscal'),1,1);
            $this->SetWidths(array(25,20,20,25,25,25,25,35));
            $this->SetAligns(array("C","C","C","C","C","C","C","C"));           
            $this->Row(array($campo['fe_emision'],$campo['nu_factura'],$campo['nu_control'],'','','',number_format($campo['nu_total'], 2, ',','.'),''),1,1);
            $this->Ln(2);
            $this->SetAligns(array("C","C","C","C","C","C","C","C"));
            $this->SetWidths(array(25,25,30,35,25,25,25,30));         
            $this->SetFont('Arial','',9);            
            
            $this->Row(array('Base Imponible','Porcentaje','Monto Iva','Monto Retenido'),1,1);           
            $this->Row(array(number_format($campo['nu_base_imponible'], 2, ',','.'),$campo['co_iva_factura']. ' %',number_format($campo['nu_iva_factura'], 2, ',','.'),number_format($campo1['mo_retencion'], 2, ',','.')),1,1);
            
            
            }else{
                
            $this->SetY(50);
            $this->SetFillColor(201, 199, 199);
            $this->SetWidths(array(30,30, 30));
            $this->SetAligns(array("C","R","L"));
            $this->SetFont('Arial','',8);
            $this->Row(array(utf8_decode('Fecha de Emisión ')),1,1);
            $this->SetFillColor(255, 255, 255);
            $this->Row(array(utf8_decode($campo1['fe_emision'])),1,1);
            
            $this->SetY(50);
            $this->setX(95);
            $this->SetFillColor(201, 199, 199);
            $this->SetWidths(array(30,30, 30));
            $this->SetAligns(array("C","R","L"));
            $this->SetFont('Arial','',8);
            $this->Row(array(utf8_decode('No. Comprobante ')),1,1);
            $this->setX(95);
            $this->SetFillColor(255, 255, 255);
            $this->Row(array(utf8_decode($campo1['anio'].$campo1['mes'].$campo1['nu_comprobante'])),1,1);
            
            $this->SetY(50);
            $this->setX(180);
            $this->SetFillColor(201, 199, 199);
            $this->SetWidths(array(30,30, 30));
            $this->SetAligns(array("C","R","L"));
            $this->SetFont('Arial','',8);
            $this->Row(array(utf8_decode('Periodo Fiscal ')),1,1);
            $this->setX(180);
            $this->SetFillColor(255, 255, 255);
            $this->Row(array(utf8_decode('Año: '.$campo1['anio'].' Mes: '.$campo1['mes'])),1,1);            
            
            //$this->MultiCell(200,4,utf8_decode($texto),0,1,'J',0);
            $this->Ln(5); 
            
            $this->SetWidths(array(200));
            $this->SetAligns(array("C"));
            $this->SetFillColor(201, 199, 199); 
            $this->SetFont('Arial','B',10);            
            $this->Row(array(utf8_decode('DATOS DEL AGENTE DE RETENCIÓN')),1,1);
            $this->SetFillColor(255, 255, 255);
            $this->SetAligns(array("L","L","L","L"));
            $this->SetWidths(array(150,50));                 
            $this->SetFont('Arial','',9);          
            //$this->Row(array(utf8_decode('Empresa.: GOBERNACIÓN DEL EDO. ZULIA'),utf8_decode('R.I.F.:  G-200036524')),1,1);    
            $this->Row(array(utf8_decode('Nombre o Razón Social.: '.$this->empresa['nb_empresa']),utf8_decode('R.I.F.: '.$this->empresa['tx_rif'])),1,1);              
            $this->SetWidths(array(200));
            //$this->Row(array(utf8_decode('Dirección: AV. BELLA VISTA EDIFICIO FEDERAL MARACAIBO EDO. ZULIA')),1,1);  
            $this->Row(array(utf8_decode('Dirección: '.$this->empresa['tx_direccion'])),1,1);            
            
            $this->SetFillColor(201, 199, 199);
            $this->SetFont('Arial','B',10);
            $this->SetWidths(array(200));
            $this->SetAligns(array("C"));
            $this->Row(array(utf8_decode('DATOS DEL (PROVEEDOR / BENEFICIARIO)')),1,1);
            $this->SetFillColor(255, 255, 255);
            $this->SetWidths(array(150,50));
            $this->SetAligns(array("L","L","L","L"));
            $this->SetFont('Arial','',9);
            $this->Row(array(utf8_decode('Nombre o Razón Social.: ').$campo['tx_razon_social'],utf8_decode('R.I.F.:  ').$campo['tx_rif']),1,1);         
            $this->SetWidths(array(200));
            $this->Row(array(utf8_decode('Dirección: ').$campo['tx_direccion']),1,1);             
 
            $this->Ln(5);

            $this->SetWidths(array(200));
            $this->SetAligns(array("C"));
            $this->SetFillColor(201, 199, 199);
            $this->SetFont('Arial','B',10); 
            $this->Row(array(utf8_decode('RETENCIÓN (COMPRAS INTERNAS O IMPORTACIONES)')),1,1);
            $this->SetFillColor(255, 255, 255); 
            $this->SetAligns(array("C","C","C","C","C","C","C"));
            $this->SetWidths(array(25,25,25,30,30,30,35));         
            $this->SetFont('Arial','',9);            
            //$this->Row(array('Fecha: '.$campo['fe_emision'],'Monto Factura: '.number_format($campo['nu_total'], 2, ',','.'),'Monto Exento: '.number_format($campo['monto_excento'], 2, ',','.')),1,1);
            $this->Row(array('Fecha Factura','No. Factura: ','No. Control','Monto Factura','Base Imponible','Porcentaje','Monto Retenido'),1,1);
            $this->SetWidths(array(25,25,25,30,30,30,35));
            $this->SetAligns(array("C","C","C","C","C","C","C"));           
            $this->Row(array($campo['fe_emision'],$campo['nu_factura'],$campo['nu_control'],number_format($campo['nu_total'], 2, ',','.'),number_format($campo['nu_base_imponible'], 2, ',','.'),$campo1['po_retencion']. ' %',number_format($campo1['mo_retencion'], 2, ',','.')),1,1);
                
                
                
                
            }
//            $this->Row(array('IVA: '.$campo['nu_iva_factura'],utf8_decode($campo1['tx_tipo_retencion']. ' RETENIDO'),number_format($campo1['mo_retencion'], 2, ',','.')),1,1);     
            
            $this->SetFont('Arial','B',10);              
            $this->Ln(40);   
            $y= $this->GetY();
            $this->line(40, $y, 80, $y);
            $this->SetY($y+4);
            $this->SetAligns(array("L"));
            $this->SetWidths(array(25,110,40));                    
            $this->Row(array('',utf8_decode('Firma del Agente de Retención'), 'Firma del Beneficiario'),0,0);

            //$this->Image("imagenes/sello_sayf.jpg", 45, 200, 30);

            $this->line(145, $y, 185, $y);               
	             
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

        $this->CuerpoFactura();        
    }

    
    function TotalMonto(){

    $conex = new ConexionComun();     
    $sql = "select sum(tb045.nu_total) as nu_monto, sum(tb045.total_pagar) as total_pagar
                  from   tb026_solicitud as tb026
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud                                                   
                  left join tb045_factura as tb045 on tb045.co_compra = tb052.co_compras 
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud 
                  where tb045.in_anular = null and tb030.co_ruta =".$_GET['codigo']." group by tb045.co_compra";
               
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];  
    }
    
    function getFacturas(){

          $conex = new ConexionComun();     
          $sql = "select distinct   nu_factura, 
                          fecha_compra as fe_pago, 
                          co_factura,
                          tb045.nu_control,
                          to_char(tb045.fe_emision,'dd/mm/yyyy') as fe_emision,  
                          nu_base_imponible, 
                          co_iva_factura, 
                          nu_iva_factura, 
                          nu_total, 
                          tb045.co_iva_retencion, 
                          nu_iva_retencion, 
                          tb045.tx_concepto, 
                          tb045.co_compra as nu_compra, 
                          numero_compra,
                          nu_total_retencion, 
                          total_pagar,
                          tb052.tx_observacion,
                         tb008.tx_razon_social,
                         tb008.tx_rif,     
                         tb008.tx_direccion,                          
                         upper(tb008.nb_representante_legal) as nb_representante_legal,
                         tb008.nu_cedula_representante,
                         tb047.tx_ente,  
                         tb001.nb_usuario,
                         tb062.mo_pagar as nu_monto,
                         tb052.anio,
                         tb052.co_solicitud,
                         tb039.nu_requisicion,  
                         tb039.tx_concepto as concepto_req,
                         tb039.created_at, 
                         tb045.co_odp,
                         to_char(tb045.fe_emision,'dd/mm/yyyy') as fe_emision,
                         tb052.nu_orden_compra,
                         tb060.tx_serial,
                         case when(tb045.co_iva_factura = 0) then nu_total else '0' end as monto_excento,
                         to_char(tb045.fe_registro,'dd') as dia,
                         to_char(tb045.fe_registro,'mm') as mes,
                         to_char(tb045.fe_registro,'yyyy') as anio
                  from   tb026_solicitud as tb026
                  left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud                                                   
                  left join tb045_factura as tb045 on tb045.co_compra = tb052.co_compras
                  left join tb060_orden_pago as tb060 on tb060.co_orden_pago = tb045.co_odp
                  left join tb008_proveedor as tb008 on tb008.co_proveedor=tb026.co_proveedor 
                  left join tb039_requisiciones as tb039 on tb045.co_solicitud = tb039.co_solicitud
                  left join tb001_usuario as tb001 on tb001.co_usuario = tb026.co_usuario
                  left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente
                  left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb026.co_solicitud
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud 
                  where tb045.in_anular is null and tb030.co_ruta =".$_GET['codigo']." order by co_factura asc ";
               
//          echo var_dump($sql);  exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;   
    }
    function getRetenciones($fact){

	  $conex = new ConexionComun();
          $sql = "select  nu_factura,
                          nu_control,
                          to_char(fe_emision,'dd/mm/yyyy') as fe_emision, 
                          nu_base_imponible,                           
                          nu_iva_factura, 
                          nu_total,                           
                          nu_iva_retencion, 
                          tx_concepto,                           
                          nu_total_retencion, 
                          total_pagar,
                          po_retencion,
                          mo_retencion,
                          tx_tipo_retencion,
                          tb041.co_tipo_retencion,
                          lpad(co_factura_retencion::text, 8, '0'::text) as co_factura_retencion,
                          lpad(nu_comprobante::text, 8, '0'::text) as nu_comprobante,
                          to_char(tb045.fe_registro,'dd') as dia,
                          to_char(tb045.fe_registro,'mm') as mes,
                          to_char(tb045.fe_registro,'yyyy') as anio
                  from   tb045_factura as tb045     
                  left join tb046_factura_retencion as tb046 on tb046.co_factura = tb045.co_factura
                  left join tb041_tipo_retencion as tb041 on tb041.co_tipo_retencion = tb046.co_tipo_retencion
                  where tb045.in_anular is null and tb045.co_factura = ".$fact; 
                  
//          echo $sql; exit(); 
          
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol; 
  
    }
    
    function getPart()
    {
        $conex = new ConexionComun();
        $sql ="   select distinct tb083.id_tb013_anio_fiscal||'-'||tb082.nu_ejecutor||'-'||tb085.co_categoria as co_categoria,
                         upper(tb052.tx_observacion) as tx_observacion,
                         de_partida,
                         sum(case when (tb053.in_calcular_iva) then tb053.monto else tb052.monto_iva end) as monto                        
                  from  tb052_compras as tb052 
                  left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras 
                  left join tb085_presupuesto as tb085 on tb085.id = tb053.co_presupuesto
                  left join tb084_accion_especifica as tb084 on tb085.id_tb084_accion_especifica = tb084.id
                  left join tb083_proyecto_ac as tb083 on tb084.id_tb083_proyecto_ac = tb083.id
                  left join tb082_ejecutor as tb082 on tb082.id = tb083.id_tb082_ejecutor
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud and tb030.in_cargar_dato is true                               
                  where tb030.co_ruta = ".$_GET['codigo'].' group by 1, 2, 3 '; //$conex->decrypt($_GET['codigo']);
       // echo var_dump($sql); exit();

        return $conex->ObtenerFilasBySqlSelect($sql);
		  
    }
    
    function TotalExcento(){

        $conex = new ConexionComun();     
        $sql = "select sum(tb053.monto) as mo_exento
                      from   tb026_solicitud as tb026
                      left join tb052_compras as tb052 on tb052.co_solicitud = tb026.co_solicitud 
                      left join tb053_detalle_compras as tb053 on tb053.co_compras = tb052.co_compras                                                   
                      left join tb045_factura as tb045 on tb045.co_compra = tb052.co_compras 
                      left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud 
                      where tb053.in_exento = true and tb030.co_ruta =".$_GET['codigo']."
                      group by tb045.co_compra";

                //echo var_dump($sql); exit();
                   
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

    function getOpcionReporte( $ruta){
        
        $sql = "SELECT tb030.co_ruta, op_reporte,
        op_reporte->>'area_uno' as area_uno,
        op_reporte->>'area_dos' as area_dos,
        op_reporte->>'area_tres' as area_tres,
        op_reporte->>'area_cuatro' as area_cuatro
        FROM tb030_ruta as tb030
        INNER JOIN tb032_configuracion_ruta AS tb032 ON tb030.co_tipo_solicitud = tb032.co_tipo_solicitud AND tb030.co_proceso = tb032.co_proceso
        WHERE tb030.co_ruta = ".$ruta;
     
        //echo $sql; exit();

        $conex = new ConexionComun(); 

        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];                          
       
    }
    
    function getAsientos($fact){
        
        $sql = "select tb061.co_cuenta_contable,tb024.tx_cuenta,tb024.tx_descripcion,sum(coalesce(tb061.mo_debe,0)) as mo_debe,sum(coalesce(tb061.mo_haber,0)) as mo_haber
                  from tb061_asiento_contable as tb061                                               
                  left join tb024_cuenta_contable as tb024 on tb024.co_cuenta_contable = tb061.co_cuenta_contable 
                  where tb061.co_solicitud =".$fact." and co_tipo_asiento = 1 group by tb061.co_cuenta_contable,tb024.tx_cuenta,tb024.tx_descripcion";
     
        //echo $sql; exit();

        $conex = new ConexionComun(); 

        return  $conex->ObtenerFilasBySqlSelect($sql);                      
       
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
$pdf->SetMargins(0, 0);
$pdf->Output($dir, 'F');


//$pdf=new PDF('P','mm','letter');
//$pdf->PrintChapter();
//$pdf->SetMargins(0, 0);
//$pdf->SetDisplayMode('default');
//$pdf->Output();

?>