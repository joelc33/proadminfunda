<?php
include("ConexionComun.php");
require('flowing_block.php');

class PDF_Flo extends PDF_FlowingBlock{
    public $title;
    public $conexion;
    
    function SetLineStyle($style) {
		extract($style);
		if (isset($width)) {
			$width_prev = $this->LineWidth;
			$this->SetLineWidth($width);
			$this->LineWidth = $width_prev;
		}
		if (isset($cap)) {
			$ca = array('butt' => 0, 'round'=> 1, 'square' => 2);
			if (isset($ca[$cap]))
				$this->_out($ca[$cap] . ' J');
		}
		if (isset($join)) {
			$ja = array('miter' => 0, 'round' => 1, 'bevel' => 2);
			if (isset($ja[$join]))
				$this->_out($ja[$join] . ' j');
		}
		if (isset($dash)) {
			$dash_string = '';
			if ($dash) {
				$tab = explode(',', $dash);
				$dash_string = '';
				foreach ($tab as $i => $v) {
					if ($i > 0)
						$dash_string .= ' ';
					$dash_string .= sprintf('%.2F', $v);
				}
			}
			if (!isset($phase) || !$dash)
				$phase = 0;
			$this->_out(sprintf('[%s] %.2F d', $dash_string, $phase));
		}
		if (isset($color)) {
			list($r, $g, $b) = $color;
			$this->SetDrawColor($r, $g, $b);
		}
	}
    function RoundedRect($x, $y, $w, $h, $r, $round_corner = '1111', $style = '', $border_style = null, $fill_color = null) {
		if ('0000' == $round_corner) // Not rounded
			$this->Rect($x, $y, $w, $h, $style, $border_style, $fill_color);
		else { // Rounded
			if (!(false === strpos($style, 'F')) && $fill_color) {
				list($red, $g, $b) = $fill_color;
				$this->SetFillColor($red, $g, $b);
			}
			switch ($style) {
				case 'F':
					$border_style = null;
					$op = 'f';
					break;
				case 'FD': case 'DF':
					$op = 'B';
					break;
				default:
					$op = 'S';
					break;
			}
			if ($border_style)
				$this->SetLineStyle($border_style);

			$MyArc = 4 / 3 * (sqrt(2) - 1);

			$this->_Point($x + $r, $y);
			$xc = $x + $w - $r;
			$yc = $y + $r;
			$this->_Line($xc, $y);
			if ($round_corner[0])
				$this->_Curve($xc + ($r * $MyArc), $yc - $r, $xc + $r, $yc - ($r * $MyArc), $xc + $r, $yc);
			else
				$this->_Line($x + $w, $y);

			$xc = $x + $w - $r ;
			$yc = $y + $h - $r;
			$this->_Line($x + $w, $yc);

			if ($round_corner[1])
				$this->_Curve($xc + $r, $yc + ($r * $MyArc), $xc + ($r * $MyArc), $yc + $r, $xc, $yc + $r);
			else
				$this->_Line($x + $w, $y + $h);

			$xc = $x + $r;
			$yc = $y + $h - $r;
			$this->_Line($xc, $y + $h);
			if ($round_corner[2])
				$this->_Curve($xc - ($r * $MyArc), $yc + $r, $xc - $r, $yc + ($r * $MyArc), $xc - $r, $yc);
			else
				$this->_Line($x, $y + $h);

			$xc = $x + $r;
			$yc = $y + $r;
			$this->_Line($x, $yc);
			if ($round_corner[3])
				$this->_Curve($xc - $r, $yc - ($r * $MyArc), $xc - ($r * $MyArc), $yc - $r, $xc, $yc - $r);
			else {
				$this->_Line($x, $y);
				$this->_Line($x + $r, $y);
			}
			$this->_out($op);
		}
	}

	function _Point($x, $y) {
		$this->_out(sprintf('%.2F %.2F m', $x * $this->k, ($this->h - $y) * $this->k));
	}

	function _Line($x, $y) {
		$this->_out(sprintf('%.2F %.2F l', $x * $this->k, ($this->h - $y) * $this->k));
	}

	function _Curve($x1, $y1, $x2, $y2, $x3, $y3) {
		$this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c', $x1 * $this->k, ($this->h - $y1) * $this->k, $x2 * $this->k, ($this->h - $y2) * $this->k, $x3 * $this->k, ($this->h - $y3) * $this->k));
	} 
	function Line($x1, $y1, $x2, $y2, $style = null) {
		if ($style)
			$this->SetLineStyle($style);
		parent::Line($x1, $y1, $x2, $y2);
	}    
    function Header() {

        $this->empresa = $this->getDatosEmpresa(1);

        // if(!empty($this->empresa['tx_imagen_izq'])){
        //     $this->Image("imagenes/".$this->empresa['tx_imagen_izq'], $this->empresa['izquierda_x'], $this->empresa['izquierda_y'], $this->empresa['izquierda_w']);
        // }

        $this->SetFont('Arial','B',8);

        $this->SetTextColor(0,0,0);
        $this->SetY(10);
        $this->Cell(0,0,utf8_decode('COMPROBANTE DE RETENCION'),0,0,'C');
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('DE IMPUESTO SOBRE LA RENTA ANUAL O DE CESE DE ACTIVIDADES'),0,0,'C');
        /*$this->Ln(6);
        $this->Cell(0,0,utf8_decode($this->empresa['nb_empresa']),0,0,'C');*/
        $this->Ln(6);
        $this->Cell(0,0,utf8_decode('PARA PERSONAS RESIDENTES PERCEPTORAS DE SUELDOS, SALARIOS Y DEMAS REMUNERACIONES SIMILARES'),0,0,'C');
        $this->SetFont('Arial','',8);

        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
        $this->Ln(2);
        //if ($this->PageNo()>1) $this->Cell(0,10,utf8_decode('Página ').$this->PageNo(),0,0,'R');  
       
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
        
        
            $this->lista_fichas = $this->getFichas(); 
            
            if($this->lista_fichas){
            $cant = count($this->lista_fichas);
            $i = 0;
            foreach($this->lista_fichas as $key => $campo){ 
            $i++;    
            $this->datos = $this->getDatos($campo["co_ficha"]);
            $style = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0);
            $this->RoundedRect(10, 3, 340, 35, 25, '0000', '', $style);
            $this->Ln(5);
            $this->setX(130);
            $this->SetFont('Arial','B',8);     
            $this->SetWidths(array(50, 50, 20, 20, 20, 20 ));  
            $this->SetAligns(array("R","L"));        
            $this->Row(array(utf8_decode('DESDE'), utf8_decode('HASTA')),0,0);
            $this->SetY(33);
            $this->setX(130);
            $this->Row(array(date("d/m/Y", strtotime($_GET["fe_inicio"])), date("d/m/Y", strtotime($_GET["fe_fin"]))),0,0);
            $this->SetY(34);
            $this->RoundedRect(10, 38, 340, 75, 25, '0000', '', $style);
            $this->Ln(5);
            $this->setX(10);
            $this->SetFont('Arial','B',8);     
            $this->SetWidths(array(100, 50, 50, 20, 20, 20 ));  
            $this->SetAligns(array("L","L","L"));   
            $this->Row(array('BENEFICIARIO DE LAS REMUNERACIONES '),0,0); 
            $this->Ln(1);
            $this->Row(array(utf8_decode('APELLIDOS Y NOMBRES'),utf8_decode('NRO. RIF'),utf8_decode('CEDULA DE IDENTIDAD')),0,0); 
            $this->Ln(1);
            $this->setX(10);
            $this->SetFont('Arial','',8);     
            $this->SetWidths(array(100, 50, 50, 20, 20, 20 ));  
            $this->SetAligns(array("L","L","L"));             
            $this->Row(array(utf8_decode($this->datos[0]['trabajador']), utf8_decode($this->datos[0]['nu_rif']),utf8_decode($this->datos[0]['nu_cedula'])),0,0); 
            $this->Ln(2);
            $this->setX(10);
            $this->SetFont('Arial','B',8);     
            $this->SetWidths(array(100, 50, 50, 20, 20, 20 ));  
            $this->SetAligns(array("L","L","L"));             
            $this->Row(array('TIPO DE AGENTE DE RETENCION: ',utf8_decode('NRO. RIF')),0,0);
            $this->Ln(1);
            $this->setX(10);
            $this->SetFont('Arial','',8);     
            $this->SetWidths(array(100, 50, 50, 20, 20, 20 ));  
            $this->SetAligns(array("L","L","L")); 
            $this->Row(array(utf8_decode('<NOMBRE DE LA INSTITUCION>'),utf8_decode('G-20003652-4'),utf8_decode('')),0,0); 
            $this->Ln(2);
            $this->setX(10);
            $this->SetFont('Arial','B',8);     
            $this->SetWidths(array(100, 50, 50, 20, 20, 20 ));  
            $this->SetAligns(array("L","L","L"));            
            $this->Row(array('FUNCIONARIO AUTORIZADO HACER LA RETENCION: ',utf8_decode('CEDULA')),0,0);
            $this->Ln(1);
            $this->setX(10);
            $this->SetFont('Arial','',8);     
            $this->SetWidths(array(100, 50, 50, 20, 20, 20 ));  
            $this->SetAligns(array("L","L","L")); 
            $this->Row(array(utf8_decode('OMAR JOSE PRIETO FERNANDEZ'),utf8_decode('V9761075'),utf8_decode('')),0,0);   
            $this->Ln(2);
            $this->setX(10);
            $this->SetFont('Arial','B',8);     
            $this->SetWidths(array(150, 50, 50, 20, 20, 20 ));  
            $this->SetAligns(array("L","L","L"));            
            $this->Row(array('DIREECION DEL AGENTE DE RETENCION, DE LA SOCIEDAD, COMUNIDAD, DEPENDENCIA OFICIAL, ORGANISMO INTERNACIONAL Y OTROS: '),0,0);     
            $this->Ln(1);
            $this->setX(10);
            $this->SetFont('Arial','',8);     
            $this->SetWidths(array(100, 50, 50, 20, 20, 20 ));  
            $this->SetAligns(array("L","L","L")); 
            $this->Row(array(utf8_decode('PLAZA BOLIVAR - PALACIO DE GOBIERNO CALLE 95, CASCO CENTRAL')),0,0);             
            $this->Ln(2);
            $this->setX(10);
            $this->SetFont('Arial','B',8);     
            $this->SetWidths(array(50, 50, 50, 50, 20, 20 ));  
            $this->SetAligns(array("L","L","L","L"));            
            $this->Row(array(utf8_decode('CIUDAD O LUGAR'),utf8_decode('ZONAL POSTAL'),utf8_decode('ESTADO O ENTIDAD FEDERAL'),utf8_decode('TELEFONO')),0,0);    
            $this->Ln(1);
            $this->setX(10);
            $this->SetFont('Arial','',8);     
            $this->SetWidths(array(50, 50, 50, 50, 20, 20 ));  
            $this->SetAligns(array("L","L","C","L")); 
            $this->Row(array(utf8_decode($this->datos[0]['tx_ciudad_domicilio']),utf8_decode(''),utf8_decode('ZULIA'),utf8_decode($this->datos[0]['nu_telefono_contacto'])),0,0);             
            $this->RoundedRect(10, 113, 340, 85, 25, '0000', '', $style);
            $this->Ln(2);
            $this->setX(10);
            $this->SetFont('Arial','B',7);     
            $this->SetWidths(array(60, 25, 25, 30, 50,150 ));  
            $this->SetAligns(array("C","L","C","L","L","L")); 
            $this->Row(array(utf8_decode('REMUNERACIONES'),'','',utf8_decode('REMUNERACIONES'),utf8_decode('IMPUESTO'),utf8_decode('DATOS OBTENIDOS DE LA INFORMACION SUMINISTRADA POR EL CONTRIBUYENTE')),0,0); 
            $this->setX(10);
            $this->SetFont('Arial','B',7);     
            $this->SetWidths(array(30, 30, 25, 25, 30, 50,150 ));  
            $this->SetAligns(array("L","L","C","L","L","L"));             
            $this->Row(array(utf8_decode('MES PAGADO'),utf8_decode('ABONADO EN CUENTA'),utf8_decode('PORCENTAJE DE RETENCION'),utf8_decode('IMPUESTO RETENIDO'),utf8_decode('PAGADAS O ABONADAS'),utf8_decode('RETENIDO ACUMULADO')),0,0);             
            $this->RoundedRect(10, 113, 340, 18, 25, '0000', '', $style);
            $this->RoundedRect(190, 131, 160, 55, 25, '0000', '', $style);
            $this->RoundedRect(190, 186, 160, 12, 25, '0000', '', $style);
            $this->Ln(2);
            $this->lista = $this->getRemuneraciones($campo["co_ficha"]); 
            $remuneraciones_acumulado = 0;
            $impuesto_acumulado = 0;
            foreach($this->lista as $key => $campo1){
            $remuneraciones_acumulado = $remuneraciones_acumulado + $campo1['nu_monto'];
            $impuesto_acumulado = $impuesto_acumulado + $campo1['nu_impuesto'];
            $this->setX(10);
            $this->SetFont('Arial','B',7);     
            $this->SetWidths(array(30, 30, 25, 25, 30, 50,150 ));  
            $this->SetAligns(array("L","C","C","L","L","L"));               
            $this->Row(array(utf8_decode(mes($campo1['mes'])),number_format($campo1['nu_monto'], 2, ',','.'),number_format($campo1['nu_valor'], 5, ',','.'),number_format($campo1['nu_impuesto'], 2, ',','.'),number_format($remuneraciones_acumulado, 2, ',','.'),number_format($impuesto_acumulado, 2, ',','.')),0,0);                             
                
            }
            $this->RoundedRect(190, 131, 160, 12, 25, '0000', '', $style);
            $this->SetY(132);
            $this->setX(190);
            $this->SetFont('Arial','B',7);     
            $this->SetWidths(array(25, 30, 30, 30, 30,15 ));  
            $this->SetAligns(array("C","C","C","C","L","C")); 
            $this->Row(array(utf8_decode('INFORMACION SEGUN AR-I MES'),utf8_decode('REMUNERACION ANUAL Bs'),utf8_decode('DESGRAVAMENES Bs'),utf8_decode('CONYUGE (1 = SI)'),utf8_decode('CARGAS FAMILIARES'),utf8_decode('%')),0,0);
            $this->Ln(2);
            $this->lista2 = $this->getRemuneracionesValor($campo["co_ficha"]);
            $cant1 = count($this->lista2);
            $j = 0;            
            foreach($this->lista2 as $key => $campo2){
            $j++;
            $this->setX(190);
            $this->SetFont('Arial','B',7);     
            $this->SetWidths(array(25, 30, 30, 30, 30,15 ));   
            $this->SetAligns(array("C","C","C","C","L","C"));
            if($campo2['nu_valor']>0){
            if($cant1>4){
            if($j<=4){
            $this->Row(array(utf8_decode('1ra. REL. '.mes($campo2['mes'])),'','','','',number_format($campo2['nu_valor'], 5, ',','.')),0,0);    
            }    
            }else{
            $this->Row(array(utf8_decode('1ra. REL. '.mes($campo2['mes'])),'','','','',number_format($campo2['nu_valor'], 5, ',','.')),0,0);    
            }    
                
            }
                                         
                
            }            
            
            $this->SetY(189);
            $this->setX(190);
            $this->SetFont('Arial','B',7);     
            $this->SetWidths(array(60, 30, 30, 30, 30,30 ));  
            $this->SetAligns(array("L","C","C","C","L","L")); 
            $this->Row(array(utf8_decode('FIRMA DEL AGENTE DE RETENCION:')),0,0);   
            if($cant>$i){
            $this->AddPage();
            }
            //$this->AddPage();
            }
            
            }else{
            $this->Ln(50);
            $this->Cell(0,0,utf8_decode('No hay informacion para los parametros ingresados'),0,0,'C');         
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

    function getRemuneraciones($co_ficha){  

        $condicion ="";
        $condicion .= " tb013.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb013.fe_pago <= '".$_GET["fe_fin"]."' ";
        
        
        $conex = new ConexionComun(); 
                  $sql = "select lpad(EXTRACT(MONTH FROM tb013.fe_pago)::text,2,'0') as mes, sum(tb061.nu_monto) as nu_monto,(sum(tb061.nu_monto) * tb061.nu_valor)/100 as nu_impuesto,tb061.nu_valor
                        from tbrh013_nomina tb013 
                        inner join tbrh061_nomina_movimiento tb061 on (tb061.id_tbrh013_nomina = tb013.co_nomina)
                        inner join tbrh014_concepto tb014 on (tb014.co_concepto = tb061.id_tbrh014_concepto)
                        where $condicion and tb013.id_tbrh060_nomina_estatus = 3 and tb014.co_concepto = 590 and id_tbrh002_ficha = $co_ficha
                        group by EXTRACT(month FROM tb013.fe_pago),tb061.nu_valor";
           //echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  

    }
    
    function getRemuneracionesValor($co_ficha){  

        $condicion ="";    
        $condicion .= " tb013.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb013.fe_pago <= '".$_GET["fe_fin"]."' ";
        
        
        $conex = new ConexionComun(); 
                  $sql = "select lpad(EXTRACT(MONTH FROM tb013.fe_pago)::text,2,'0') as mes, sum(tb061.nu_monto) as nu_monto,(sum(tb061.nu_monto) * tb061.nu_valor)/100 as nu_impuesto,tb061.nu_valor
                        from tbrh013_nomina tb013 
                        inner join tbrh061_nomina_movimiento tb061 on (tb061.id_tbrh013_nomina = tb013.co_nomina)
                        inner join tbrh014_concepto tb014 on (tb014.co_concepto = tb061.id_tbrh014_concepto) 
                        where $condicion and tb013.id_tbrh060_nomina_estatus = 3 and tb014.co_concepto = 590 and id_tbrh002_ficha = $co_ficha
                        group by EXTRACT(month FROM tb013.fe_pago),tb061.nu_valor";
           //echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  

    }    
    
    function getFichas(){  

       
        if($_GET["nu_cedula"]){
        $conex = new ConexionComun(); 
                  $sql = "select co_ficha
            from tbrh001_trabajador tb001 
            inner join tbrh002_ficha tb002 on (tb002.co_trabajador = tb001.co_trabajador)
            where tb001.nu_cedula = ".$_GET["nu_cedula"];
           //echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;    
        }else{
            
        $condicion ="";   

        $this->nivel = $this->getNivel();
        
        if($this->nivel["co_nivel_jerarquico"]==2){
        $condicion .= " tb009.co_estructura_administrativa in ( select co_estructura_administrativa from tbrh005_estructura_administrativa where co_padre = ". $_GET["co_estructura_administrativa"].") and ";
        }else{
        $condicion .= " tb009.co_estructura_administrativa = ". $_GET["co_estructura_administrativa"]." and ";            
        }        
        $condicion .= " tb013.fe_pago >= '". $_GET["fe_inicio"]."' and ";
        $condicion .= " tb013.fe_pago <= '".$_GET["fe_fin"]."' ";
        
        
        $conex = new ConexionComun(); 
                  $sql = "select id_tbrh002_ficha as co_ficha
            from tbrh013_nomina tb013 
            inner join tbrh061_nomina_movimiento tb061 on (tb061.id_tbrh013_nomina = tb013.co_nomina) 
            inner join tbrh014_concepto tb014 on (tb014.co_concepto = tb061.id_tbrh014_concepto)
            inner join tbrh015_nom_trabajador tb015 on (tb015.co_nom_trabajador = tb061.id_tbrh015_nom_trabajador)
            inner join tbrh009_cargo_estructura tb009 on (tb009.co_cargo_estructura = tb015.co_cargo_estructura)            
            where $condicion and tb013.id_tbrh060_nomina_estatus = 3 and tb014.co_concepto = 590
            group by id_tbrh002_ficha";
           //echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
        }

    }    
    
    function getDatos($co_ficha){  
          
        $conex = new ConexionComun(); 
                  $sql = "select tb001.nu_cedula, tb001.nu_rif, coalesce(nb_primer_apellido,'')||' '||coalesce(nb_segundo_apellido,'')||' '||coalesce(nb_primer_nombre,'')||' '||coalesce(nb_segundo_nombre,'') as trabajador, 
                  tb001.nu_telefono_contacto,tx_ciudad_domicilio from tbrh002_ficha tb002
            inner join tbrh001_trabajador tb001 on (tb001.co_trabajador = tb002.co_trabajador)
            where co_ficha = $co_ficha";
           //echo var_dump($sql); exit();  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  

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
    
    function getNivel(){

        $sql = "SELECT *
        FROM tbrh005_estructura_administrativa
        WHERE co_estructura_administrativa = ".$_GET["co_estructura_administrativa"].";";

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];
  
    }    

}

$pdf=new PDF_Flo('L','mm','LEGAL');
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>