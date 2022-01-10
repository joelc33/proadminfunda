<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $array_factura;
    public $array_factura_banco;
    function Header() {

      encabezado_general_legal($this);

        $this->SetX(10);
        $this->Ln(10);
        $this->SetFillColor(255, 255, 255);
        $this->SetX(13);
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','B',6);

        $this->DatosContribuyente();
        $this->SetWidths(array(30,160));

        $this->SetX(13);
        $this->SetFillColor(201, 199, 199);
        $this->Cell(190,6,utf8_decode('DATOS DEL CONTRIBUYENTE'),1,1,'C',1);
        $this->SetX(13);
        $this->SetFillColor(255, 255, 255);
        $this->SetAligns(array("L","L"));
        $this->Row(array(utf8_decode("Nombre o Razón Social"),utf8_decode ($this->datos[0]['nb_contribuyente'])));
        $this->SetX(13);
        $this->Row(array(utf8_decode("RIF"),$this->datos[0]['ci_rif']));
        $this->SetX(13);
        $this->Row(array(utf8_decode("Referencia"),$this->datos[0]['nu_referencia']));
        $this->SetX(13);
        $this->Row(array(utf8_decode("Dirección"),utf8_decode ($this->datos[0]['tx_direccion'])));
        $this->SetX(13);
        $this->Row(array(utf8_decode("Teléfóno"),$this->datos[0]['telefono']));
        $this->Ln(4);
        
        $this->SetFillColor(201, 199, 199);
        $this->SetX(13);
        $this->Cell(190,6,utf8_decode('ESTADO DE CUENTA DEL CONTRIBUYENTE'),1,1,'C',1);

        $this->SetWidths(array(25,25,20,25,20,25,20,30));
        $this->SetAligns(array("C","C","C","C","C","C","C","C"));
        $this->SetFillColor(201, 199, 199);
        $this->SetX(13);
        $this->SetTextColor(0,0,0);
        $this->Row(array("PLANILLA","SOLICITUD",utf8_decode("PORCIÓN"),utf8_decode("FECHA LIQ."),"FECHA DE VENC.","MOTIVO","Estado",utf8_decode("MONTO PORCIÓN")),1,1);
        $this->SetX(13);
    }

    function Footer() {       
        $this->SetX(1);
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

        
        $this->suma = 0;
        
        $this->SetFont('Arial','',6);

        foreach($this->datos as $key => $campo){
            $this->SetX(13);
            $this->SetWidths(array(25,25,20,25,20,25,20,30));
            $this->SetAligns(array("C","C","C","C","C","C","C","R"));
            $this->SetFillColor(255, 255, 255);
            $this->Row(array($campo["nu_planilla"],$campo["co_solicitud"],$campo["porcion"],$campo["fe_liquidacion"],$campo["fe_vencimiento"],$campo["tx_motivo"],$campo['nb_status'],number_format($campo["nu_monto_porcion"], 2, '.',',')));
            $this->suma = $this->suma + $campo["nu_monto_porcion"];
        }
        
        $this->SetFillColor(201, 199, 199);
        $this->SetWidths(array(25,30));
        $this->SetAligns(array("C","R"));
        $this->SetTextColor(0,0,0);
        $this->SetX(148);
        $this->SetFont('Arial','B',7);
        $this->Row(array("MONTO TOTAL",number_format($this->suma, 2, '.',',')),1,1);


	$this->Ln(5);
	$this->SetX(13);
	$this->Cell(190,6,utf8_decode('ACTIVIDADES DEL CONTRIBUYENTE'),1,1,'C',1);
        $this->SetFillColor(201, 199, 199);
        $this->SetWidths(array(30,160));
        $this->SetAligns(array("C","C"));
        $this->SetTextColor(0,0,0);
       
        $this->SetFont('Arial','B',7);
	$this->SetX(13);
        $this->Row(array("Numero Actividad","Descripcion Actividad"),1,1);
            foreach($this->act as $key => $campo){
            $this->SetX(13);
            $this->SetWidths(array(30,160));
            $this->SetAligns(array("C","C"));
            $this->SetFillColor(255, 255, 255);
            $this->Row(array($campo["nu_ref_actividad"],utf8_decode($campo["tx_actividad"])));
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

    function DatosContribuyente(){

        $comunes = new ConexionComun();

        $condicion = '';
        $condicion_sancion = '';

        
        if($_GET['fe_inicio']!=''){
             $condicion.= "fe_liquidacion >='".$_GET['fe_inicio']."'";
             $condicion_sancion = "fe_liquidacion >= '".$_GET['fe_inicio']."'";
        }
        if($_GET['fe_fin']!=''){
            if($condicion!='')
                $condicion.=' and ';
            $condicion.= "fe_liquidacion <='".$_GET['fe_fin']."'";

            if($condicion_sancion!='')
                $condicion_sancion.=' and ';
            $condicion_sancion = "fe_liquidacion <= '".$_GET['fe_fin']."'";
        }
        if($_GET['co_contribuyente']!=''){
            if($condicion!='')
                $condicion.=' and ';
            $condicion.="tb004.co_contribuyente=".$_GET['co_contribuyente'];

            if($condicion_sancion!='')
                $condicion_sancion.=' and ';
            $condicion_sancion.="tb004.co_contribuyente=".$_GET['co_contribuyente'];
        }

        if($condicion!='')
                $condicion =' where '.$condicion;

        if($condicion_sancion!='')
                $condicion_sancion =' where '.$condicion_sancion;

        $sql ="select
                     case when tx_razon_social is null then nb_contribuyente||' '||ap_contribuyente ELSE tx_razon_social end as nb_contribuyente,
                     case when tx_rif  is null then tx_tp_doc||' - '||nu_cedula ELSE tx_tp_doc||' - '||tx_rif end as ci_rif,
                     tx_direccion,
                     case when nu_telf_movil is null then nu_telf_hab else nu_telf_movil end as telefono,
                     nu_planilla,
                     nu_documento,
                     tb004.nu_referencia,
                     nu_porcion||'/'||(select count(*) from tb052_ae_decl_porciones as t where t.co_declaracion = tb042.co_declaracion) as porcion,
                     to_char(fe_liquidacion,'dd/mm/yyyy') as fe_liquidacion,
                     fe_liquidacion as fecha,
                     to_char(fe_vencimiento,'dd/mm/yyyy') as fe_vencimiento,
                     tx_motivo,
                     tb029.nb_status,
		     tb042.co_solicitud,
                     case when tb052.co_status = 9 then
                        tb052.nu_monto_porcion - tb052.nu_monto_rec
                     else
                        tb052.nu_monto_porcion end as  nu_monto_porcion

                from tb004_contribuyente as tb004 left join tb002_tipo_contribuyente as tb002
                     on (tb002.co_tipo = tb004.co_tipo) left join tb042_ae_declaracion as tb042
                     on (tb042.co_contribuyente = tb004.co_contribuyente) left join tb052_ae_decl_porciones as tb052
                     on (tb052.co_declaracion = tb042.co_declaracion) left join tb029_status as tb029
                     on (tb029.co_status = tb052.co_status)
                $condicion";


           $sql_sancion = "select
                              case when tb004.tx_razon_social is null then
                                    tb004.nb_contribuyente||' '||tb004.ap_contribuyente
                              else
                              tb004.tx_razon_social end as nb_contribuyente,
                              case when tx_rif  is null then tx_tp_doc||' - '||nu_cedula ELSE tx_tp_doc||' - '||tx_rif end as ci_rif,
                              tx_direccion,
                              case when nu_telf_movil is null then nu_telf_hab else nu_telf_movil end as telefono,
                              tb059.nu_planilla,
                              'SF'||''||to_char(fe_sancion,'yyyy')||''||tb059.co_sancion as nu_documento,
                              tb055.nu_referencia,
                              nu_porcion||'/'||(select count(*) from tb059_ae_porcion_sancion as t where t.co_sancion = tb055.co_sancion) as porcion,
			      to_char(fe_liquidacion,'dd/mm/yyyy') as fe_liquidacion,
			      fe_liquidacion as fecha,
			      to_char(fe_vencimiento,'dd/mm/yyyy') as fe_vencimiento,                             
                              tx_motivo,
                              tb029.nb_status,
                              case when tb059.co_status = 9 then
                              tb059.nu_monto_porcion - (select sum(nu_monto_recaudar)
                                                               from tb060_ae_sancion_pago
                                                               where co_porcion_sancion = tb059.co_porcion_sancion)
                             else
                                nu_monto_liq
                             end as nu_monto_porcion
                            from
                                     tb059_ae_porcion_sancion as tb059 left join tb029_status as tb029
                                     on (tb029.co_status = tb059.co_status) left join tb055_ae_sancion as tb055
                                     on (tb055.co_sancion = tb059.co_sancion) left join tb060_ae_sancion_pago as tb060
                                     on (tb059.co_porcion_sancion = tb060.co_porcion_sancion) left join tb004_contribuyente as tb004
                                     on (tb004.co_contribuyente = tb055.co_contribuyente) left join tb046_ae_ramo as tb046
                                     on (tb046.co_ramo = tb055.co_ramo) left join tb002_tipo_contribuyente as tb002
                                     on (tb002.co_tipo = tb004.co_tipo)
                            $condicion_sancion";

		$sql_act = "select tb041. nu_ref_actividad, tx_actividad from tb041_contrib_act tb041 left join tb039_ae_actividad as tb039
                                     on (tb039.nu_ref_actividad = tb041.nu_ref_actividad) where co_ordenanza = 9 and co_contribuyente =".$_GET['co_contribuyente']." order by 1";
         
		// echo $sql.' union '.$sql_sancion; exit();
          $this->datos =   $comunes->ObtenerFilasBySqlSelect($sql/*.' union '.$sql_sancion*/);
	  $this->act =   $comunes->ObtenerFilasBySqlSelect($sql_act);

          if(count($this->datos)==0){
              echo '<script type="text/javascript">
                      alert("El Contribuyente no posee estado de cuenta");
                      window.close();
               </script>';
          }
    }


}



$pdf=new PDF('P','mm','letter');



$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
