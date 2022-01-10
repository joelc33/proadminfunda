<?php
include("ConexionComun.php");
include('fpdf.php');

class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

    }

    function Footer() {

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

        $listaArreglo  = json_decode($_GET['codigo'],true);
        $i=0;
        $contador = count($listaArreglo);

        foreach($listaArreglo as $arregloForm){

            $condicion[] = $arregloForm['co_nomina'];

        }

            

            $this->datos_lista = $this->getListaNomina($condicion);
            
            if($this->datos_lista["co_tp_nomina"]==13){
            
            $this->concepto_lista = $this->getListaConcepto($condicion);
            $cant = count($this->concepto_lista);
            foreach($this->concepto_lista as $key => $campo_concepto){

         //********cheque**************//
         $this->SetFont('courier','B',12);
         
         $this->SetX(1);
         $this->SetY(6);
         $this->Ln(-1);
         $this->SetFillColor(255, 255, 255);
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(135, 50)); 
         $this->Row(array('',number_format($campo_concepto['mo_pago'], 2, ',','.')),0,0); 
         $this->Ln(5);
         $this->SetX(1);
         $this->SetY(21);
         $this->SetFont('courier','',10);
         $this->SetWidths(array(20, 150)); 
         $this->Row(array('',$campo_concepto['nb_nombre']),0,0); 
         $this->Ln(1);
         $montoLetra = numtoletras($campo_concepto['mo_pago'],1);
         $this->Row(array('',$montoLetra),0,0); 
         $this->Ln(7);
         $this->SetAligns(array("L","L","L","L"));
         $this->SetWidths(array(10,60,5,15));
         $fecha_pago= explode("-", $this->datos_lista['fe_pago']);
         //var_dump($fecha_det[0]); exit();
         $this->SetX(13);
         $this->Row(array('',$fecha_pago[0]. '    DE    '. strtoupper(mes($fecha_pago[1])),' ',$fecha_pago[2]),0,0);
         $this->SetY(64);
         $this->SetFillColor(255, 255, 255);
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(130, 50)); 
         $this->Row(array('',strtoupper($campo_concepto['nu_clave'])),0,0);          
         $this->SetY(94);
         $this->SetFont('courier','',10);
         $this->SetWidths(array(80, 20,130)); 
         $this->SetX(10);
         $this->Row(array($campo_concepto['nb_nombre'],$campo_concepto['nu_cheque'],$campo_concepto['nu_cedula']),0,0);
         $this->Ln(2);
         $this->SetX(10);
         $fecha_nomina= explode("-", $this->datos_lista['fe_fin']);         
         $this->Cell(0,0,utf8_decode('BENEFICIARIO DE EMBAR EMPLEADOS                '.mes($fecha_nomina[1])),0,0,'L');
         $this->Ln(2);
         $this->SetAligns(array("L","L","L","L"));
         $this->SetWidths(array(20,80,30,30));
         $this->Row(array('Cod.','Descripcion','Asignaciones','Deducciones'),0,0);
            $this->concepto = $this->getConceptos($campo_concepto['id_tbrh013_nomina'],$campo_concepto['id_tbrh002_ficha']);
            foreach($this->concepto as $key => $concepto){ 
            if($concepto['id_tbrh020_tp_concepto']==1){    
            $this->Ln(2);
            $this->Row(array($concepto['nu_concepto'],$concepto['de_concepto'],$concepto['nu_monto'],''),0,0);  
            }else{
             $this->Row(array($concepto['nu_concepto'],$concepto['de_concepto'],'',$concepto['nu_monto']),0,0);   
            }
            }
              
         
         $this->SetX(1);
         $this->SetY(223);
         $this->Ln(-1);
         $this->SetFillColor(255, 255, 255);
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(175, 50)); 
         $this->Row(array('',number_format($campo_concepto['mo_pago'], 2, ',','.')),0,0);  
         $i++;
         if($cant<>$i){
         $this->AddPage(); 
         }
         //********fin de cheque**************/
            
            }
            
            }else{
            $this->Ln(50);
            $this->Cell(0,0,utf8_decode('LA NOMINA SELECCIONADA NO ES UNA NOMINA DE EMBARGO'),0,0,'C');                   
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

    function getListaNomina($co_nomina){  

        $conex = new ConexionComun();
        
        $sql = "SELECT co_solicitud, tx_tp_nomina, tbrh017.nu_nomina as nu_tp_nomina,
            to_char(fe_inicio, 'DD-MM-YYYY') as fe_inicio,
            to_char(fe_fin, 'DD-MM-YYYY') as fe_fin,
            to_char(fe_pago, 'DD-MM-YYYY') as fe_pago,
            tbrh013.co_tp_nomina
        FROM tbrh013_nomina as tbrh013
        INNER JOIN tbrh017_tp_nomina AS tbrh017 on tbrh013.co_tp_nomina = tbrh017.co_tp_nomina
        WHERE tbrh013.co_nomina in (".implode(",", $co_nomina).")
        group by 1,2,3,4,5,6,7;";
        
        //echo var_dump($sql); exit();
        
        //return $conex->ObtenerFilasBySqlSelect($sql);
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];

    }

    function getListaConcepto($co_nomina){  

        $conex = new ConexionComun();
        
        $sql = "select * from (SELECT case when mo_pago<= 5000 and tb089.co_tp_forma_pago = 1 then 3 else tb089.co_tp_forma_pago end as co_tp_forma_pago,
                tb089.nu_cedula,tb089.nb_nombre,tbrh102.nu_cheque,tbrh102.id_tbrh013_nomina,tbrh102.id_tbrh002_ficha,tbrh102.nu_clave,count(tbrh102.nu_cedula) as nu_cantidad,
                sum(mo_pago) as mo_pago 
                FROM tbrh102_cierre_nomina_trabajador as tbrh102  
                INNER JOIN tbrh089_embargantes AS tb089 on tbrh102.nu_cedula = tb089.nu_cedula 
                INNER JOIN tbrh090_tp_forma_pago AS tb090 on tb089.co_tp_forma_pago = tb090.co_tp_forma_pago 
                WHERE id_tbrh013_nomina in (".implode(",", $co_nomina).") and mo_pago > 0 and tb089.co_tp_forma_pago in (1,3) group by 1,2,3,4,5,6,7 order by 1 asc
                ) as q1 where q1.co_tp_forma_pago = 1;";
        
        //echo var_dump($sql); exit();
        
        return $conex->ObtenerFilasBySqlSelect($sql);

    }
    
    function getConceptos($co_nomina,$co_ficha){  

        $conex = new ConexionComun();
        
        $sql = "select * 
                FROM tbrh061_nomina_movimiento as tb061  
                INNER JOIN tbrh014_concepto AS tb014 on tb014.co_concepto = tb061.id_tbrh014_concepto 
                WHERE id_tbrh013_nomina = $co_nomina and id_tbrh002_ficha = $co_ficha";
        
        //echo var_dump($sql); exit();
        
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
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>