<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {

        $this->empresa = $this->getDatosEmpresa(1);

        //$this->Image("imagenes/escudosanfco.png", 100, 7,20);

        if(!empty($this->empresa['tx_imagen_cen'])){
            $this->Image("imagenes/".$this->empresa['tx_imagen_cen'],  $this->empresa['centro_x'], $this->empresa['centro_y'], $this->empresa['centro_w']);
        }

        $this->SetFont('Arial','B',9);
        
      //  
        $this->SetTextColor(0,0,0);
        $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPUBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('<NOMBRE DE LA INSTITUCION>'),0,0,'C');
       // $this->Ln(4);
        //$this->Cell(0,0,utf8_decode('SECRETARIA DE ADMINISTRACIÓN Y FINANZAS'),0,0,'C');
       // $this->Cell(0,0,utf8_decode($this->empresa['nb_empresa']),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('SUBSECRETARIA DE PRESUPUESTO'),0,0,'C');
        $this->SetFont('Arial','',8);
        $this->Ln(6);

        $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
             

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
        $this->setX(10);
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));  
        //$this->SetY(55);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','B',8); 
        $this->Row(array(utf8_decode('RELACIÓN DE TRASPASOS DE CRÉDITOS PRESUPUESTARIOS ARTICULO N°22 LEY DE PRESUPUESTO DEL ESTADO.')),1,1);        
        
        $this->Row(array('CORRESPONDIENTE DESDE '.$_GET['fe_inicio'].' HASTA '.$_GET['fe_fin']),1,1);        
                
        $this->SetFont('Arial','B',7);     
        $this->SetFillColor(201, 199, 199);
        $this->SetWidths(array(60,30,20,30,60)); 
        $this->SetAligns(array("L","L","L","R","L"));   
        $this->Row(array(utf8_decode('UNIDAD EJECUTORA CEDENTE'),utf8_decode('N°'),utf8_decode('FECHA'), utf8_decode('MONTO'),utf8_decode('UNIDAD RECEPTORA DESTINO')),1,1); 
        $this->SetFillColor(255, 255, 255);

        $this->lista_traspasos = $this->getListaTraspasos();         
        foreach($this->lista_traspasos as $key => $valor){

            $this->SetFont('Arial','',7);
            //$this->SetWidths(array(60,30,20,30,60)); 
            $this->SetAligns(array("L","L","L","R","L"));   
            //$this->Row(array(utf8_decode($valor['ue_cedente']),utf8_decode($valor['num']),$valor['fecha'],number_format($valor['monto'], 2, ',','.'),utf8_decode($valor['ue_receptor'])),1,1); 

            //Multicell test
            $alto = 5;

            $this->lista_detalle = $this->getListaTraspasosDetalle($valor['id']);

            $definicion = count($this->lista_detalle)*$alto;
            $datos = count($this->lista_detalle);

            $this->Cell(60, $definicion, substr(utf8_decode($valor['nu_ejecutor'].'-'.$valor['ue_cedente']), 0,40), 1,'L');
            $this->Cell(30, $definicion, utf8_decode($valor['num']), 1,'L');
            $this->Cell(20, $definicion, $valor['fecha'], 1,'L');
            $i=1;
            foreach($this->lista_detalle as $key2 => $valorDetalle){
                if($definicion>5){
                    if($datos>=$i){
                        $this->Cell(30, 5, number_format($valorDetalle['monto'], 2, ',','.'), 1,'R');
                        $this->Cell(60, 5, substr(utf8_decode($valorDetalle['nu_ejecutor'].'-'.$valorDetalle['ue_receptor']), 0,38), 1,'L');
                        $this->Ln(5);
                        $this->Cell(110, $definicion, '', 0,'L');
                    }elseif($datos==$i){
                        $this->Ln($definicion);
                    }
                    $i++;
                }else{
                    $this->Cell(30, 5, number_format($valorDetalle['monto'], 2, ',','.'), 1,'R');
                    $this->Cell(60, 5, substr(utf8_decode($valorDetalle['nu_ejecutor'].'-'.$valorDetalle['ue_receptor']), 0,38), 1,'L');
                }
            }
            //$this->Cell(30, $alto, number_format($valor['monto'], 2, ',','.'), 1,'R');
            //$this->Cell(60, $alto, count($this->lista_detalle), 1,'L');
            $this->Ln(5);

            if($this->getY()>240){

                $this->AddPage();
                $this->Ln(1);
                $this->setX(10);
                $this->SetWidths(array(200));
                $this->SetAligns(array("C"));  
                //$this->SetY(55);
                $this->SetFillColor(255, 255, 255);
                $this->SetFont('Arial','B',8); 
                $this->Row(array(utf8_decode('RELACIÓN DE TRASPASOS DE CRÉDITOS PRESUPUESTARIOS ARTICULO N°22 LEY DE PRESUPUESTO DEL ESTADO.')),1,1);        
                
                $this->SetFont('Arial','B',7);     
                $this->SetFillColor(201, 199, 199);
                $this->SetWidths(array(60,30,20,30,60)); 
                $this->SetAligns(array("L","L","L","R","L")); 
                $this->Row(array(utf8_decode('UNIDAD EJECUTORA CEDENTE'),utf8_decode('N°'),utf8_decode('FECHA'), utf8_decode('MONTO'),utf8_decode('UNIDAD RECEPTORA DESTINO')),1,1); 
                $this->SetFillColor(255, 255, 255);

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
        $this->AddPage();
        $this->ChapterBody();
    }
     
    function getListaTraspasos(){

        $condicion ="";  
        if ($_GET["fe_inicio"])
        $condicion .= " and tb097.created_at >= '". $_GET["fe_inicio"]."' ";
        if ($_GET["fe_fin"])
        $condicion .= " and tb097.created_at <= '".$_GET["fe_fin"]."' ";
        

          $conex = new ConexionComun();     
          /*$sql = "SELECT tb082_cedente.de_ejecutor as ue_cedente, 
                        tb082_receptora.de_ejecutor as ue_receptor,
                        tb096.nu_modificacion as num, 
                        to_char(tb097.created_at,'dd/mm/yyyy') as fecha,
                        sum(mo_distribucion) as monto
                  FROM tb097_modificacion_detalle as tb097          
                  left join tb082_ejecutor as tb082_cedente on tb082_cedente.id  = tb097.id_tb082_ejecutor_origen
                  left join tb082_ejecutor as tb082_receptora on tb082_receptora.id  = tb097.id_tb082_ejecutor_destino
                  left join tb096_presupuesto_modificacion as tb096 on tb096.id  = tb097.id_tb096_presupuesto_modificacion
                  where tb096.id_tb095_tipo_modificacion=1 $condicion
                  group by 1, 2, 3, 4 order by 3, 4, 1 asc";*/

            $sql = "SELECT tb096.id, tb082_cedente.de_ejecutor as ue_cedente, tb082_cedente.nu_ejecutor,
            tb096.nu_modificacion as num, 
            to_char(tb097.created_at,'dd/mm/yyyy') as fecha,
            sum(mo_distribucion) as monto
            FROM tb097_modificacion_detalle as tb097          
                inner join tb082_ejecutor as tb082_cedente on tb082_cedente.id  = tb097.id_tb082_ejecutor_origen
                inner join tb096_presupuesto_modificacion as tb096 on tb096.id  = tb097.id_tb096_presupuesto_modificacion
            where tb096.id_tb095_tipo_modificacion=1 $condicion
            group by 1, 2, 3, 4, 5 order by 1 ASC";

            //var_dump($sql); exit();
                        
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
	
    }  

    function getListaTraspasosDetalle($id){

        $condicion ="";  
        if ($_GET["fe_inicio"])
        $condicion .= " and tb097.created_at >= '". $_GET["fe_inicio"]."' ";
        if ($_GET["fe_fin"])
        $condicion .= " and tb097.created_at <= '".$_GET["fe_fin"]."' ";
        

          $conex = new ConexionComun();     

            $sql = "SELECT tb096.id, tb082_receptora.de_ejecutor as ue_receptor, tb082_receptora.nu_ejecutor,
            sum(mo_distribucion) as monto
            FROM tb097_modificacion_detalle as tb097          
                inner join tb082_ejecutor as tb082_receptora on tb082_receptora.id  = tb097.id_tb082_ejecutor_destino
                inner join tb096_presupuesto_modificacion as tb096 on tb096.id  = tb097.id_tb096_presupuesto_modificacion
            where tb096.id_tb095_tipo_modificacion=1 and id_tb096_presupuesto_modificacion = ".$id." 
            group by 1, 2, 3 order by 2 asc";

            //var_dump($sql); exit();
                        
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

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output(); 

?>
