<?php
include("ConexionComun.php");
include("fpdf.php");


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
            $this->SetX(122);
            $this->MultiCell(110,4,utf8_decode($this->empresa['nb_institucion']),0,'C',0); 
            $this->Ln(2);
        }else{
        $this->Ln(4);    
        }
        $this->Cell(0, 0, utf8_decode('RIF. ' . $this->empresa['tx_rif']), 0, 0, 'C');
        $this->Ln(4);                           
    }

    function Footer() {
	$this->SetFont('Arial','B',9);     
	$this->SetY(200);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');  
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
         $this->SetWidths(array(200));         
         $this->SetAligns(array("C")); 
         $this->SetFont('Arial','B',12); 
         $this->SetX(80);
         $this->Row(array(utf8_decode('RELACIÓN DE MOVIMIENTOS BANCARIOS DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
         $this->Ln(2);
         $this->SetWidths(array(200));
         $this->SetAligns(array("L"));           
         $this->SetFont('Arial','B',8); 
         $this->SetFillColor(255, 255, 255); 
         $y =  $this->getY();
         $this->lista_cuentas = $this->getCuenta();         
         
         $this->SetFont('Arial','',11);     
         $this->SetWidths(array(20,12,83,65,22,35,30,30,45));  
         $this->SetAligns(array("C","C","C","C","C","C","R","R","R"));   
         $this->Row(array('Fecha','Sol.','Beneficiario',utf8_decode('Descripción'),'Tipo','Referencia', 'Debe','Haber','Saldo'),0,0); 
         $this->SetAligns(array("L","L","L","L","C","C","R","R","R"));
         $this->Line(10, $y+6, 350, $y+6);        
         $this->Ln(2);
         $mo_ingr = 0;
         $mo_egr  = 0;
         $saldo   = 0;
         
        foreach($this->lista_cuentas as $key => $valor){
        
                    if($this->getY()>160)
                        {	
                        $this->addPage();
                        $this->Ln(6);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("C")); 
                        $this->SetFont('Arial','B',9);     
                        $this->SetX(80);
                        $this->Row(array(utf8_decode('RELACIÓN DE MOVIMIENTOS BANCARIOS DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
                        $this->Ln(2);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("L"));           
                        $this->SetFont('Arial','B',8); 
                        $this->SetFillColor(255, 255, 255); 
                        $y =  $this->getY();
                        $this->SetFont('Arial','',12);     
                        $this->SetWidths(array(20,12,83,65,22,35,30,30,45));  
                        $this->SetAligns(array("C","C","C","C","C","C","R","R","R"));
                        $this->SetX(10);
                        $this->Row(array('Fecha','Sol.','Beneficiario',utf8_decode('Descripción'),'Tipo','Referencia', 'Debe','Haber','Saldo'),0,0); 
                        $this->SetAligns(array("L","L","L","L","C","C","R","R","R"));
                        $this->Line(10, $y+6, 350, $y+6);         
                        $this->Ln(2);
                    } 
                $saldo_ant = $this->getSaldo();
                

                
                if($saldo_ant['mo_saldo_anterior']<>0){   
                    
                   $saldo   = $saldo_ant['mo_saldo_anterior']; 
                   
                //    echo var_dump($valor['bco']); exit();
                   $this->SetFont('Arial','B',8);
                   $this->SetWidths(array(150)); 
                   $this->SetAligns(array("L")); 
                   $this->Row(array('Banco: '.$valor['bco']),0,0); 
                   $this->SetWidths(array(170,160)); 
                   $this->SetAligns(array("L","R")); 
                   $this->Row(array('Cuenta: '.utf8_decode($valor['cuenta']), 'SALDO AL INICIO DEL PERIODO: '.number_format($saldo, 2, ',','.')),0,0);
                /*********** Movimiento por Libro del Bco y cta asociada *************/
                $this->lista_mov = $this->getMovimientos($valor['co_cuenta_bancaria']);             
         
                foreach($this->lista_mov as $key => $campo){              

                        if($this->getY()>165)
                        {	
                        $this->addPage();
                        $this->Ln(6);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("C")); 
                        $this->SetFont('Arial','B',12);    
                        $this->SetX(80);
                        $this->Row(array(utf8_decode('RELACIÓN DE MOVIMIENTOS BANCARIOS DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
                        $this->Ln(2);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("L"));           
                        $this->SetFont('Arial','B',8); 
                        $this->SetFillColor(255, 255, 255); 
                        $y =  $this->getY();
                        $this->SetFont('Arial','',11);     
                        $this->SetWidths(array(20,12,83,65,22,35,30,30,45));  
                        $this->SetAligns(array("C","C","C","C","C","C","R","R","R"));
                        $this->SetX(10);
                        $this->Row(array('Fecha','Sol.','Beneficiario',utf8_decode('Descripción'),'Tipo','Referencia', 'Debe','Haber','Saldo'),0,0); 
                        $this->SetAligns(array("L","L","L","L","C","C","R","R","R"));
                        $this->Line(10, $y+6, 350, $y+6);         
                        $this->Ln(2);
                        } 
                        $this->SetFont('Arial','',8);  
                        $this->SetWidths(array(20,12,83,65,22,35,30,30,45)); 
                        $this->SetAligns(array("L","L","L","L","C","C","R","R","R")); 
                        
                        $saldo   = $saldo + $campo['monto_ingr'] - $campo['monto_egr'];
                        $this->SetX(10); 
                        $this->Row(array($campo['fecha'],$campo['co_solicitud'],utf8_decode($campo['beneficiario']),utf8_decode($campo['tx_descripcion']),utf8_decode($campo['op']),$campo['referencia'],number_format($campo['monto_ingr'], 2, ',','.'),number_format($campo['monto_egr'], 2, ',','.'),number_format($saldo, 2, ',','.')),0,0);         

                        $mo_ingr = $campo['monto_ingr'] + $mo_ingr;
                        $mo_egr  = $campo['monto_egr'] + $mo_egr;
                        $mo_sald  = $campo['monto_egr'] + $saldo;
                        

                 }
                } else{
            
        $saldo_ant2 = $this->getSaldo2();    
        
                   $saldo   = $saldo_ant2['mo_saldo_anterior']; 
                   
                //    echo var_dump($valor['bco']); exit();
                   $this->SetFont('Arial','B',8);
                   $this->SetWidths(array(150)); 
                   $this->SetAligns(array("L")); 
                   $this->Row(array('Banco: '.$valor['bco']),0,0); 
                   $this->SetWidths(array(170,160)); 
                   $this->SetAligns(array("L","R")); 
                   $this->Row(array('Cuenta: '.utf8_decode($valor['cuenta']), 'SALDO AL INICIO DEL PERIODO: '.number_format($saldo, 2, ',','.')),0,0);
                /*********** Movimiento por Libro del Bco y cta asociada *************/
                $this->lista_mov = $this->getMovimientos($valor['co_cuenta_bancaria']);             
         
                foreach($this->lista_mov as $key => $campo){              

                        if($this->getY()>165)
                        {	
                        $this->addPage();
                        $this->Ln(6);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("C")); 
                        $this->SetFont('Arial','B',12);    
                        $this->SetX(80);
                        $this->Row(array(utf8_decode('RELACIÓN DE MOVIMIENTOS BANCARIOS DEL '.date("d/m/Y", strtotime($_GET['fe_inicio'])).' AL '.date("d/m/Y", strtotime($_GET['fe_fin'])))),0,0);
                        $this->Ln(2);
                        $this->SetWidths(array(200));
                        $this->SetAligns(array("L"));           
                        $this->SetFont('Arial','B',8); 
                        $this->SetFillColor(255, 255, 255); 
                        $y =  $this->getY();
                        $this->SetFont('Arial','',11);     
                        $this->SetWidths(array(20,12,83,65,22,35,30,30,45));  
                        $this->SetAligns(array("C","C","C","C","C","C","R","R","R"));
                        $this->SetX(10);
                        $this->Row(array('Fecha','Sol.','Beneficiario',utf8_decode('Descripción'),'Tipo','Referencia', 'Debe','Haber','Saldo'),0,0); 
                        $this->SetAligns(array("L","L","L","L","C","C","R","R","R"));
                        $this->Line(10, $y+6, 350, $y+6);         
                        $this->Ln(2);
                        } 
                        $this->SetFont('Arial','',8);  
                        $this->SetWidths(array(20,12,83,65,22,35,30,30,45)); 
                        $this->SetAligns(array("L","L","L","L","C","C","R","R","R")); 
                        
                        $saldo   = $saldo + $campo['monto_ingr'] - $campo['monto_egr'];
                        $this->SetX(10); 
                        $this->Row(array($campo['fecha'],$campo['co_solicitud'],utf8_decode($campo['beneficiario']),utf8_decode($campo['tx_descripcion']),utf8_decode($campo['op']),$campo['referencia'],number_format($campo['monto_ingr'], 2, ',','.'),number_format($campo['monto_egr'], 2, ',','.'),number_format($saldo, 2, ',','.')),0,0);         

                        $mo_ingr = $campo['monto_ingr'] + $mo_ingr;
                        $mo_egr  = $campo['monto_egr'] + $mo_egr;
                        $mo_sald  = $campo['monto_egr'] + $saldo;
                        

                 }                   
            
        }
        }
         $this->Ln(10);
//         $y = $this->getY();
//         $this->Line(146, $y, 175, $y);
//         $y = $this->getY();
//         $this->Line(180, $y, 210, $y);         
         $this->SetFont('Arial','B',9);  
         $this->SetAligns(array("R","R","R","R"));
         $this->SetWidths(array(237,30,30,45));
         $this->Row(array(utf8_decode('TOTAL: '),number_format($mo_ingr, 2, ',','.'),number_format($mo_egr, 2, ',','.'),number_format($saldo, 2, ',','.')),0,0);         
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
   
    function getCuenta(){
        
    $condicion ="";
    $co_banco     = $_GET['co_banco'];
    $co_cta       = $_GET['co_cuenta'];
   
    if ($co_banco) $condicion .= " and tb011.co_banco = ".$co_banco;  
    if ($co_cta)   $condicion .= " and tb011.co_cuenta_bancaria = ".$co_cta;  

          $conex = new ConexionComun();     
          $sql = "  SELECT tb024.tx_descripcion as cuenta, tb010.tx_banco as bco,
                    tb011.co_cuenta_bancaria, tb011.mo_disponible
                    FROM tb010_banco as tb010
                    left join tb011_cuenta_bancaria as tb011 on (tb011.co_banco = tb010.co_banco)
                    left join tb024_cuenta_contable as tb024 on (tb011.co_cuenta_contable = tb024.co_cuenta_contable)
                    where tb011.co_banco = tb010.co_banco $condicion 
                    order by bco, cuenta";
                        
          //echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }   
    
    function getSaldo(){
        
    $condicion ="";
    $co_cta       = $_GET['co_cuenta'];
    //$condicion .= " and fe_transaccion >= '". $_GET["fe_inicio"]."' and ";
    $condicion .= " and  fe_transaccion < '".$_GET["fe_inicio"]."' ";

          $conex = new ConexionComun();     
          $sql = "  select sum(coalesce(monto_ingr,0)) - sum(coalesce(monto_egr,0)) as mo_saldo_anterior FROM  (
                    SELECT case when ((id_tb153_tipo_documento_cuenta =1) or (id_tb153_tipo_documento_cuenta =2)) then sum(mo_transaccion) end as monto_ingr ,
                    case when ((id_tb153_tipo_documento_cuenta =3)) then sum(mo_transaccion) end as monto_egr,id_tb153_tipo_documento_cuenta 
                    FROM tb155_cuenta_bancaria_historico tb155
                    --left join tb030_ruta as tb030 on (tb030.co_solicitud = tb155.co_solicitud and tb030.in_actual is true and tb030.co_estatus_ruta<>3)
                    where id_tb011_cuenta_bancaria = $co_cta $condicion and id_tb153_tipo_documento_cuenta is not null
                    group by id_tb153_tipo_documento_cuenta
                    ) as q1 "; 
                        
         //echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];  
	
    }
    
    function getSaldo2(){
        
    $condicion ="";
    $co_cta       = $_GET['co_cuenta'];
    $condicion .= " and fe_transaccion >= '2018-08-19' and ";
    $condicion .= " fe_transaccion <= '2018-08-19' ";

          $conex = new ConexionComun();     
          $sql = "  SELECT fe_transaccion, mo_saldo_anterior
                    FROM tb155_cuenta_bancaria_historico 
                    where id_tb011_cuenta_bancaria = $co_cta $condicion
                    order by 1 asc limit 1 "; 
                        
         //echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];  
	
    }
    
    function getMovimientos($cuenta){
        
    $condicion ="";
    $condicion2 ="";
    $fe_inicio    = $_GET['fe_inicio'];    
    $fe_fin       = $_GET['fe_fin'];   
    $co_banco     = $_GET['co_banco'];
    $co_cta       = $_GET['co_cuenta'];
    
    $condicion .= " tb155.fe_transaccion >= '". $_GET["fe_inicio"]."' and ";
    $condicion .= " tb155.fe_transaccion <= '".$_GET["fe_fin"]."' ";
    if ($co_banco) $condicion .= " and tb011.co_banco = ".$co_banco;  
    if ($co_cta)   $condicion .= " and tb011.co_cuenta_bancaria = ".$co_cta; 
    
    $condicion2 .= " tb063.fe_pago >= '". $_GET["fe_inicio"]."' and ";
    $condicion2 .= " tb063.fe_pago <= '".$_GET["fe_fin"]."' ";
    if ($co_banco) $condicion2 .= " and tb011.co_banco = ".$co_banco;  
    if ($co_cta)   $condicion2 .= " and tb011.co_cuenta_bancaria = ".$co_cta;     
    
          $conex = new ConexionComun();     
          /*$sql = "  ( SELECT tb155.co_solicitud, case when (tb063.co_forma_pago=1) then 'ND-'|| tb063.nu_pago 
                                else tb153.nu_tipo_documento_cuenta ||'-'|| substring(tb155.nu_documento,4,20) end as documento, 
                                case when (tb026.co_tipo_solicitud=18) then 'GOBERNACION DEL ZULIA' else UPPER(tb008.tx_razon_social) end as beneficiario, 
                                case when (tb026.co_tipo_solicitud=23) then tb122.tx_concepto else tb155.de_observacion end as tx_descripcion,  
                                tb154.nu_operacion as op, to_char(tb155.fe_transaccion,'dd/mm/yyyy') as fecha, 
                                case when (tb026.co_tipo_solicitud=18) then 'OT-'||co_transferencia_cuenta else tb155.nu_transaccion end as referencia, 
                                case when ((tb153.id =1) or (tb153.id =2)) then tb155.mo_transaccion end as monto_ingr , 
                                case when ((tb153.id =3)) then tb155.mo_transaccion end as monto_egr ,tb155.fe_transaccion 
                                from tb026_solicitud as tb026 
                                left join tb155_cuenta_bancaria_historico as tb155 on tb155.co_solicitud = tb026.co_solicitud 
                                left join tb154_tipo_cuenta_movimiento as tb154 on tb154.id = tb155.id_tb154_tipo_cuenta_movimiento 
                                left join tb153_tipo_documento_cuenta as tb153 on tb153.id = tb155.id_tb153_tipo_documento_cuenta 
                                left join tb008_proveedor as tb008 on tb026.co_proveedor=tb008.co_proveedor 
                                left join tb011_cuenta_bancaria as tb011 on tb011.co_cuenta_bancaria = tb155.id_tb011_cuenta_bancaria 
                                left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb155.co_solicitud 
                                left join tb063_pago as tb063 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago 
                                left join tb122_pago_nomina as tb122 on tb122.co_solicitud = tb026.co_solicitud
                                left join tb066_transferencia_cuenta as tb066 on (tb066.co_solicitud = tb155.co_solicitud)
                                left join tb030_ruta as tb030 on (tb030.co_solicitud = tb155.co_solicitud and tb030.in_actual is true)
                                where (tb030.co_estatus_ruta not in ( 3, 4)) and $condicion
                                group by 1, 2, 3, 4, 5, 6,7,8,9, 10 order by 10)";*/


            $sql = "  ( SELECT tb155.co_solicitud, case when (tb063.co_forma_pago=1) then 'ND-'|| tb063.nu_pago 
                                else tb153.nu_tipo_documento_cuenta ||'-'|| substring(tb155.nu_documento,4,20) end as documento, 
                                case when (coalesce(tb026.co_proveedor,0)=0) then UPPER(tb015.nb_institucion) else UPPER(tb008.tx_razon_social) end as beneficiario, 
                                case when (tb026.co_tipo_solicitud=23) then tb122.tx_concepto when (tb026.co_tipo_solicitud=18) then case when (tb026.co_estatus=4) then 'TeC: '|| tb155.de_observacion else 'TeC: '|| tb026.tx_observacion end else tb155.de_observacion end as tx_descripcion,  
                                tb154.nu_operacion as op, to_char(tb155.fe_transaccion,'dd/mm/yyyy') as fecha, 
                                case when (tb026.co_tipo_solicitud=18) then nu_serial_transferencia else tb155.nu_transaccion end as referencia, 
                                case when ((tb153.id =1) or (tb153.id =2)) then tb155.mo_transaccion end as monto_ingr , 
                                case when ((tb153.id =3)) then tb155.mo_transaccion end as monto_egr ,tb155.fe_transaccion,tb155.id 
                                from tb026_solicitud as tb026 
                                left join tb155_cuenta_bancaria_historico as tb155 on tb155.co_solicitud = tb026.co_solicitud 
                                left join tb154_tipo_cuenta_movimiento as tb154 on tb154.id = tb155.id_tb154_tipo_cuenta_movimiento 
                                left join tb153_tipo_documento_cuenta as tb153 on tb153.id = tb155.id_tb153_tipo_documento_cuenta 
                                left join tb008_proveedor as tb008 on tb026.co_proveedor=tb008.co_proveedor 
                                left join tb011_cuenta_bancaria as tb011 on tb011.co_cuenta_bancaria = tb155.id_tb011_cuenta_bancaria 
                                left join tb062_liquidacion_pago as tb062 on tb062.co_solicitud = tb155.co_solicitud 
                                left join tb063_pago as tb063 on tb063.co_liquidacion_pago = tb062.co_liquidacion_pago 
                                left join tb122_pago_nomina as tb122 on tb122.co_solicitud = tb026.co_solicitud
                                left join tb066_transferencia_cuenta as tb066 on (tb066.co_solicitud = tb155.co_solicitud)
                                left join tb015_empresa as tb015 on (tb015.co_empresa = tb155.co_empresa)
                                left join tb030_ruta as tb030 on (tb030.co_solicitud = tb155.co_solicitud and tb030.in_actual is true)
                                where tb030.co_estatus_ruta<>3 and $condicion
                                group by 1, 2, 3, 4, 5, 6,7,8,9, 10,11 order by 10,1,11)";
                  
          //echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
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

$pdf=new PDF('L','mm','legal');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
