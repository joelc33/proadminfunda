<?php
include("ConexionComun.php");
include('fpdf.php');

class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->empresa = $this->getDatosEmpresa(1);

        // if(!empty($this->empresa['tx_imagen_izq'])){
        //     $this->Image("imagenes/".$this->empresa['tx_imagen_izq'], $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
        // }

        $this->SetFont('Arial','B',10);

        $this->SetTextColor(0,0,0);
        $this->SetY(10);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('ALCALDIA DE SAN FRANCISCO'),0,0,'C');
        /*$this->Ln(6);
        $this->Cell(0,0,utf8_decode($this->empresa['nb_empresa']),0,0,'C');*/
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('RESUMEN DE DEPOSITOS'),0,0,'C');
        $this->SetFont('Arial','',8);

        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->Ln(2);
        if ($this->PageNo()>1) $this->Cell(0,10,utf8_decode('Página ').$this->PageNo(),0,0,'R');  
       
        $this->SetTextColor(0,0,0);
        $this->SetX(1);       

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

            $i++;

            $this->datos_lista = $this->getListaNomina($condicion);
            
            if($this->datos_lista["co_tp_nomina"]==13){
            
            $this->Ln(5);
            $this->setX(10);
            $this->SetFont('Arial','',8);     
            $this->SetWidths(array(30, 50, 20, 20, 20, 20 ));  
            $this->SetAligns(array("L",));   
            $this->Row(array('PROCESO: ', $this->datos_lista["co_solicitud"]),0,0); 
            $this->Ln(1);
            $this->Row(array(utf8_decode('PERIODO:'), strtoupper(utf8_decode($this->datos_lista["nu_tp_nomina"].' - '.$this->datos_lista["tx_tp_nomina"])), utf8_decode('DESDE:'), $this->datos_lista["fe_inicio"], utf8_decode('HASTA:'), $this->datos_lista["fe_fin"]),0,0); 
            $this->Ln(1);
            $this->Row(array(utf8_decode('ORGANISMO:'), utf8_decode('GOBERNACION DEL ZULIA')),0,0); 

            $this->Ln(5);
            $this->SetFont('Arial','B',8);     
            $this->SetWidths(array(60,80,30,30));   
            $this->SetAligns(array("C","C","C","C","C","C","C","C"));   
            $this->Row(array('CUENTAS','BANCOS','CANT', 'DEPOSITO'),1,0); 
            $this->SetAligns(array("L","L","R","R","R","R","R"));

            $this->concepto_lista = $this->getListaConcepto($condicion);

            $mo_total_cantidad = 0;
            $mo_total_pago = 0;

            foreach($this->concepto_lista as $key => $campo_concepto){

                $this->setX(10);
                $this->SetFont('Arial','',8);     
                $this->SetWidths(array(60,80,30,30));  
                $this->Row(array( $campo_concepto['tx_tp_forma_pago'], 
                utf8_decode($campo_concepto['nu_cuenta'].' - '.$campo_concepto['descripcion_cuenta']), 
                $campo_concepto['nu_cantidad'], 
                number_format($campo_concepto['mo_pago'], 2, ',','.')),1,0);

                $mo_total_cantidad = $campo_concepto['nu_cantidad'] + $mo_total_cantidad;
                $mo_total_pago = $campo_concepto['mo_pago'] + $mo_total_pago;

            }

            $this->setX(10);
            $this->SetFont( 'Arial', 'B', 9);
            $this->SetWidths(array(140,30,30 ));
            $this->SetAligns(array("R","R","R","R","R"));
            $this->Row(array(utf8_decode('TOTAL NOMINA'), 
            $mo_total_cantidad, 
            number_format($mo_total_pago, 2, ',','.') ),1,0);
            
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
        
        $sql = "SELECT case when mo_pago<= 5000 and tb089.co_tp_forma_pago = 1 then 3 else tb089.co_tp_forma_pago end as co_tp_forma_pago,
            case when mo_pago<= 5000 and tb089.co_tp_forma_pago = 1 then (select tx_tp_forma_pago from tbrh090_tp_forma_pago where co_tp_forma_pago=3)  else tx_tp_forma_pago end as tx_tp_forma_pago,
            case when mo_pago<= 5000 and tb089.co_tp_forma_pago = 1 then (select descripcion_cuenta from tbrh090_tp_forma_pago where co_tp_forma_pago=3)  else descripcion_cuenta end as descripcion_cuenta,
            tb090.nu_cuenta,
            count(tbrh102.nu_cedula) as nu_cantidad, sum(mo_pago) as mo_pago
            FROM tbrh102_cierre_nomina_trabajador as tbrh102
            INNER JOIN tbrh089_embargantes AS tb089 on tbrh102.nu_cedula = tb089.nu_cedula
            INNER JOIN tbrh090_tp_forma_pago AS tb090 on tb089.co_tp_forma_pago = tb090.co_tp_forma_pago
            WHERE id_tbrh013_nomina in (".implode(",", $co_nomina).") and mo_pago > 0
            group by 1,2,3,4
            order by 1 asc;";
        
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