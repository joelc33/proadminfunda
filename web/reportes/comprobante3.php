<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $array_factura;
    public $array_factura_banco;
    function Header() {


        encabezado($this);
       

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

         $this->Ln(2);

         $this->datos = $this->getSolicitudes();

         $this->SetY($this->getY()*1.5);
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(60,140));
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("L"));
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('Datos del Solicitante')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(20,30,30,120));
         $this->Row(array(utf8_decode('Cédula:'),$this->datos['cedula'],utf8_decode('Nombre y Apellido:'),utf8_decode($this->datos['solicitante'])),1,1);
         $this->SetWidths(array(20,30,30,120));
         $this->Row(array(utf8_decode('Telf. Movil:'),$this->datos['nu_telf_movil'],utf8_decode('Telefono. Local:'),$this->datos['nu_telf_hab']),1,1);

    //         $this->Row(array(utf8_decode('Cédula:'),$this->datos['cedula']),1,1);
         $this->SetWidths(array(20,180));
         $this->Row(array(utf8_decode('Dirección:'),utf8_decode($this->datos['tx_direccion'])),1,1);
         $this->Row(array(utf8_decode('Parroquia:'),utf8_decode($this->datos['nb_parroquia'])),1,1);
         $this->SetWidths(array(200));
         $this->SetAligns(array("L"));
         $this->SetFillColor(201, 199, 199);
         $this->Ln();
         $this->Row(array(utf8_decode('Datos de la Solicitud')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(40,160));
         $this->Row(array(utf8_decode('Codigo Solicitud:'),utf8_decode($this->datos['co_solicitud'])),1,1);
         $this->Row(array(utf8_decode('Tramite Solicitado:'),utf8_decode($this->datos['nb_solicitud'])),1,1);
         $this->SetWidths(array(40,40,40,80));
         $this->Row(array(utf8_decode('Fecha de Recepción:'),$this->datos['fe_recepcion'],utf8_decode('Fecha de Entrega Tentativa:'),$this->datos['fe_estimada']),1,1);
//         $this->Row(array(),1,1);
         $this->Ln();
         $this->SetWidths(array(200));
         $this->SetAligns(array("L"));
         $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('Observación')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->Row(array(utf8_decode($this->datos['tx_observacion'])),1,1);

         $this->lista_requisitos = $this->getRequisitos();

         $this->SetWidths(array(200));
	 $this->SetFillColor(201, 199, 199);
         $this->Ln();
         $this->Row(array(utf8_decode('Requisitos Consignados')),1,1);

         foreach($this->lista_requisitos as $key => $campo){
           $this->SetFillColor(255,255,255);
           
           $this->SetAligns(array("L"));
           $this->Row(array(utf8_decode($campo['tx_requisito'])));
        }


	 $this->lista_requisitos_faltantes =$this->getRequisitosFaltantes();

         
		 $this->SetWidths(array(200));
		 $this->SetFillColor(201, 199, 199);
		 $this->Ln();
		 $this->Row(array(utf8_decode('Requisitos Faltantes')),1,1);

		 foreach($this->lista_requisitos_faltantes as $key => $campo){
		   $this->SetFillColor(255,255,255);
		   
		   $this->SetAligns(array("L"));
		   $this->Row(array(utf8_decode($campo['tx_requisito'])));
		}
	

         $this->ln();
         $this->SetWidths(array(100,100));
         $this->SetAligns(array("C","C"));
	 $this->SetFillColor(201, 199, 199);
         $this->Row(array(utf8_decode('Recibido Por:'),'Fima Solicitante'),1,1);
	 $this->SetFillColor(255,255,255);
         $this->Row(array('',''),1,1);

         $this->ln();
         $this->Cell(0,0,utf8_decode('En los 200 años del Bicentenario La Honestidad y la Eficiencia Nos Caracterizan'),0,0,'C');
//         $this->SetY($this->getY()+3);
//         $this->Cell(0,0,utf8_decode('Instituto Municipal de Geomática'),0,0,'C');


         

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

    function getSolicitudes(){

          $conex = new ConexionComun();

          $sql = "select
                          co_solicitud,
                          case when nu_cedula is null then
                              tx_tp_doc||'-'||tx_rif
                          else
                             tx_tp_doc||'-'||nu_cedula
                          end  as cedula,
                          case when tx_rif is null then
                               upper(nb_persona)||' '||upper(ap_persona)
                          else
                              upper(tx_razon_social)
                          end as solicitante,
                          upper(nb_solicitud) as nb_solicitud,
                          to_char(fe_recepcion,'dd/mm/yyyy') as fe_recepcion,
                          to_char(fe_entrega_est,'dd/mm/yyyy') as  fe_estimada,
                          to_char(fe_entrega_real,'dd/mm/yyyy') as fe_real,
                          upper(tx_observacion) as tx_observacion,
		          upper(pa.nb_parroquia) as nb_parroquia,
		          upper(ds.tx_direccion) as tx_direccion,
                          nu_telf_movil,
                          nu_telf_hab

                    from datos_solicitud ds,
                         tipo_solicitante as tp,
                         tipo_solicitud as tpsol,
                         parroquia as pa
                    where
                         pa.co_parroquia = ds.co_parroquia and
                         ds.co_tipo = tp.co_tipo and
                         tpsol.co_tipo_solicitud = ds.co_tipo_solicitud
                         and co_solicitud = ".$_GET['codigo'];

          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol[0];

    }

    function getRequisitos(){

	  $conex = new ConexionComun();

          $sql = "select distinct tx_requisito
		  from req_solicitud as r,requisito as re 
		  where re.co_requisito = r.co_requisito and co_solicitud = ".$_GET['codigo'];

          return $conex->ObtenerFilasBySqlSelect($sql);

    }

    function getRequisitosFaltantes()
    {
        $conex = new ConexionComun();
        $sql ="select distinct re.tx_requisito
		from  req_solicitud as r,
		      datos_solicitud as d,
		      requisito_sol as rs,
		      requisito as re
		where       
		      rs.co_tipo_solicitud = d.co_tipo_solicitud and
		      re.co_requisito = rs.co_requisito and 
		      rs.co_requisito not in (select distinct r.co_requisito from  req_solicitud as r where r.co_solicitud = ".$_GET['codigo'].") and
		      d.co_solicitud=r.co_solicitud and
		      r.co_solicitud =".$_GET['codigo'];

        return $conex->ObtenerFilasBySqlSelect($sql);
		  
    }


}


$pdf=new PDF('P','mm','letter');

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
