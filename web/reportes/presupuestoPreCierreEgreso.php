<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

         $this->empresa = $this->getDatosEmpresa(1);

        $this->SetFont('courier','B',12);
        $this->Cell(0, 0, utf8_decode($this->empresa['nb_empresa']), 0, 0, 'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
         if (!empty($this->empresa['nb_institucion'])) {
            $this->Ln(2);
            $this->SetX(52);
            $this->MultiCell(110,4,utf8_decode($this->empresa['nb_institucion']),0,'L',0); 
            $this->Ln(2);
        }else{
        $this->Ln(4);    
        }
        $this->Cell(0, 0, utf8_decode('RIF. ' . $this->empresa['tx_rif']), 0, 0, 'L');             
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('[FPRER]'),0,0,'L');
        $this->SetFont('courier','',8);
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R'); 
        
   }

    function getDatosEmpresa( $codigo){

        $sql = "SELECT co_empresa, nb_empresa, co_estado, co_municipio, tx_rif, tx_nit, nb_institucion, nb_presidente,
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

    function Footer() {
	$this->SetFont('courier','B',9);     
	$this->SetY(195);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');  
    }

    function dwawCell($title,$data) {
        $width = 8;
        $this->SetFont('courier','B',12);
        $y =  $this->getY() * 20;
        $x =  $this->getX();
        $this->SetFillColor(206,230,100);
        $this->MultiCell(175,8,$title,0,1,'L',0);
        $this->SetY($y);
        $this->SetFont('courier','',12);
        $this->SetFillColor(206,230,172);
        $w=$this->GetStringWidth($title)+3;
        $this->SetX($x+$w);
        $this->SetFillColor(206,230,172);
        $this->MultiCell(175,8,$data,0,1,'J',0);

    }
    


    function ChapterBody() {
       
        $this->AddPage(); 
        $this->Ln(2);        
        
        if ($_GET["co_anio_fiscal"]) $anio=$_GET["co_anio_fiscal"];
        else if ($_GET["fe_inicio"]) $anio= date("Y", strtotime($_GET["fe_inicio"]));

         
        $Y = $this->GetY();  
        $this->SetY($Y+5);          
        $this->SetFont('courier','B',14);  
        $this->SetX(0); // configura la linea donde comenzara escribir en el eje de y              
        $this->Ln(10);
        $this->Cell(0,0,utf8_decode(' PRECIERRE DE LA EJECUCIÓN PRESUPUESTARIA DE EGRESOS- AÑO FISCAL '.$anio),0,0,'C'); 
        $this->Ln(2);          
        $this->SetY($Y);  
        $this->SetFont('courier','',12); 
        $this->SetWidths(array(100));
        $this->SetAligns(array("L")); 
        $this->SetX(10);                    
        $this->Row(array('PERIODO....:  '.$_GET["fe_inicio"].' al '.$_GET["fe_fin"]),0,0);   
        $this->SetX(10);            

        
        $total_comprometido  = 0;
        $total_causado       = 0;
        $total_pagado        = 0;
        
        $this->Ln(25);       
        $campo='';
        $this->Ln(2);
         
	
         $this->precierre = $this->partidas_precierre();   
         $this->ue = $this->empresa();
         // echo var_dump($this->precierre); exit(); 
         
         $this->SetFont('courier','B',12);
         $this->SetWidths(array(50, 120));         
         $this->SetAligns(array("L","L"));   
         $this->SetX(10); 
         
         $this->Row(array('UNIDAD EJECUTORA: ', $this->ue['nb_empresa']),0,0);
         $dato   = 'PRECIERRE '.$_GET['fe_inicio'].' / '.$_GET['fe_fin'];  

         $this->SetX(10); 
         $this->Row(array('TIPO: ', $dato),0,0);
         $this->Ln(2);
         $this->SetWidths(array(30, 55, 55, 50));         
         $this->SetAligns(array("C","C","C","C"));          
         $this->SetX(10); 
         $this->Row(array('Fecha','Comprometido ','Causado', 'Pagado'),1,0);        
         $this->SetFont('courier','',12);
         $this->Ln(2);
        
        
         foreach($this->precierre as $key => $campo){
             
             // echo var_dump('registros: '.$campo); exit(); 
              
             $this->SetWidths(array(30, 55, 55, 50));    
             $this->SetAligns(array("C","R","R","R"));  
             $periodo   = $campo['fecha'];  
             
             $total_comprometido  = $this->movimiento(1, $campo['fecha']);
             $total_causado       = $this->movimiento(2, $campo['fecha']);
             $total_pagado        = $this->movimiento(3, $campo['fecha']);

             $this->SetX(10); 
             $this->Row(array($periodo,number_format($total_comprometido['monto'], 2, ',','.'),number_format($total_causado['monto'], 2, ',','.'), number_format($total_pagado['monto'], 2, ',','.')),0,0);        

            }                       

 }
 
    function mes($nu_mes){

        $mes['01']='Enero';
        $mes['02']='Febrero';
        $mes['03']='Marzo';
        $mes['04']='Abril';
        $mes['05']='Mayo';
        $mes['06']='Junio';
        $mes['07']='Julio';
        $mes['08']='Agosto';
        $mes['09']='Septiembre';
        $mes['10']='Octubre';
        $mes['11']='Noviembre';
        $mes['12']='Diciembre';

        return $mes[$nu_mes];
    } 

    function movimiento($tipo, $fecha){ 
 
    $conex = new ConexionComun();   
    
    if ($_GET["co_anio_fiscal"]) $anio=$_GET["co_anio_fiscal"];
    else if ($_GET["fe_inicio"]) $anio= date("Y", strtotime($_GET["fe_inicio"]));    

    $sql = "
            select sum(nu_monto) as monto from
            (select distinct nu_monto, co_detalle_compra 
                             from tb087_presupuesto_movimiento as tb087 
                             join tb085_presupuesto as tb085 on (tb087.co_partida = tb085.id)
             where  tb085.nu_anio = '".$anio."' and in_cerrado is null and 
                    co_tipo_movimiento = ".$tipo." and
                    (cast (tb087.created_at as date) 
                     between '".$fecha."' and 
                            '".$fecha."'
                    )
            ) as tabla        

                   "; 

         // echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
  
          return  $datosSol[0];    
    }
    
   function partidas_precierre(){ 
 
    $conex = new ConexionComun();   
    
    if ($_GET["co_anio_fiscal"]) $anio=$_GET["co_anio_fiscal"];
    else if ($_GET["fe_inicio"]) $anio= date("Y", strtotime($_GET["fe_inicio"]));      
    
    $sql = "
            select distinct to_char(cast(tb087.created_at as date),'dd-mm-yyyy') as fecha
                  from tb087_presupuesto_movimiento as tb087 
                  join tb085_presupuesto as tb085 on (tb087.co_partida = tb085.id)
            where  tb085.nu_anio = '".$anio."' and in_cerrado is null and 
                   (cast (tb087.created_at as date) 
                    between '".$_GET["fe_inicio"]."' and 
                            '".$_GET["fe_fin"]."'
                   )
    ";       
    
      //    echo var_dump($sql); exit();        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
  
          return  $datosSol;    
    }    
     
    function empresa(){ 
        
    $conex = new ConexionComun();     
    $sql2 = "
            SELECT tb015.nb_empresa
            FROM public.tb015_empresa as tb015
           limit 1";          
    
         //echo var_dump($sql); exit();        
          $datosSol2 = $conex->ObtenerFilasBySqlSelect($sql2);
          return  $datosSol2[0]; 	
    }
}
$pdf=new PDF('P','mm','letter');

$pdf->AliasNbPages();
$pdf->ChapterBody();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
