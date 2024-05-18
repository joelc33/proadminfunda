<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $array_factura;
    public $array_factura_banco;
    function Header() {


        encabezado_inmueble($this);

    }

    function Footer() {

//$this->Image('http://chart.googleapis.com/chart?chs=50x50&cht=qr&chl=http://sicsum-app.ddns.net/ventanilla/web/reportes/estado_cuenta_inmueble.php?codigo='.$_GET['codigo'].'&.png',170,140,40,40);

	$this->SetY(200);

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

         $this->dato = $this->DatosBauche();

	 $this->datosContrib = $this->DatosContribuyente();

            foreach($this->datosContrib as $key => $campo){
		$rif = $campo['rif'];
		$nb_contribuyente = $campo['nb_contribuyente'];
		$denom_comercial = $campo['tx_denom_comercial'];
		$fe_liquidacion = $campo['fe_liquidacion'];
	    }
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetFillColor(255, 255, 255);
         $this->Ln(4);
         $this->SetTextColor(0,0,0);
         $this->SetFont('Arial','B',14);
         $this->Row(array("ESTADO DE CUENTA"),0,1);
         $this->SetX(150);
       
   

//         $this->co_porcion = $this->dato['co_decl_porcion'];

         $this->Ln(2);

         $this->SetFont('Arial','B',7);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(25,95,10,35,10,25));
         $this->SetAligns(array("L","L","L","L","L","L"));
         $this->Row(array(utf8_decode('RAMO:'),'INMUEBLES URBANOS',utf8_decode('RIF.:'),$rif,utf8_decode('REF.:'),$this->datosContrib[0]['nu_referencia']),0,1);
         $this->SetWidths(array(25,175));
         $this->SetAligns(array("L","L"));
         $this->Row(array(utf8_decode('RAZÓN SOCIAL:'),utf8_decode($nb_contribuyente)),0,1);
	 $this->SetAligns(array("L","L"));
	 $this->SetWidths(array(30,170));
         $this->Row(array(utf8_decode('DENOM. COMERCIAL:'),utf8_decode($denom_comercial)),0,1);
         $this->SetWidths(array(25,175));
         $this->SetAligns(array("L","L"));
	 $this->Row(array(utf8_decode('DIRECCIÓN:'),utf8_decode($this->datosContrib[0]['tx_direccion'])),0,1);
         $this->SetWidths(array(30,90,30));
         $this->SetAligns(array("L","L","L"));
         //$this->Row(array(utf8_decode('FECHA LIQUIDACIÓN:'),$fe_liquidacion),0,1);


         //Descripcion de las actividades

         $this->SetWidths(array(15,100,25,15,15,30));
         $this->SetAligns(array("C","C","C","C","C","C","C"));
         $this->SetFillColor(201, 199, 199);
         $this->Ln(4);
         $this->SetTextColor(0,0,0);
         $this->SetFont('Arial','',6);

         $this->GetSancion();

         $this->SetFillColor(230,230,230);
         $this->SetFont('Arial','B',7);
         $this->ln(2);

         $monto_total = $this->sum_activ;

         

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

    function GetSancion(){


            $this->SetFont('Arial','B',6);
            $this->SetWidths(array(20,25,20,50,50,30));
            $this->Row(array(utf8_decode("Planilla"),
                             utf8_decode("Fecha Liquidación"),
                             utf8_decode("Estado"),
                             utf8_decode("Motivo"),
			     utf8_decode("Contribuyente"),
                             utf8_decode("Monto")),1,1);
            $this->SetFillColor(255,255,255);
            $this->SetAligns(array("L","C","C","C","L","R"));

            $total = 0;
            foreach($this->dato as $key => $campo){
                $this->Row(array(utf8_decode($campo['nu_planilla']),
                                 $campo['fe_liquidacion'],
                                 utf8_decode($campo['nb_status']),
                                 utf8_decode($campo['mensaje']),
				 $campo['nb_contribuyente'],
                                 number_format($campo['mo_liquidacion'], 2, ',','.')));

                $total += $campo['mo_liquidacion'];
	    }
            $this->SetFont('Arial','B',6);
            $this->SetX(155);
            $this->SetWidths(array(20,30));
            $this->SetAligns(array("C","R"));
            $this->SetFillColor(201, 199, 199);
            $this->Row(array(utf8_decode("Total:"), number_format($total, 2, ',','.')),1,1);


    }

   
    function DatosBauche() {

        $comunes = new ConexionComun();

        $sql = "select
                        tb074.nu_planilla,
                        tb074.tx_motivo,
                        tb074.tx_porcion as porcion,
                        tb046.nb_ramo||' - '||tb046.tx_ramo as ramo,
                        tb071.nu_referencia_inm as nu_referencia,
                        case when tb004.tx_razon_social is null then
                            tb004.nb_contribuyente||' '||tb004.ap_contribuyente
                        else
                            tb004.tx_razon_social
                        end||
                        case when nu_cant_dueno > 1 then ' Y OTROS ' else '' end as nb_contribuyente,
                        case when tx_rif is not null then
                            tb002.tx_tp_doc||'-'||tb004.tx_rif
                        else
                            tb002.tx_tp_doc||'-'||to_char(tb004.nu_cedula,'999999999999')
                        end as rif,
                        tb074.mo_total_liq,
                        to_char(tb074.fe_liquidacion,'dd/mm/yyyy') as fe_liquidacion,
                        to_char(tb077.fe_recaudacion,'dd/mm/yyyy') as fe_recaudacion,
                        tb070.tx_direccion,
                        tb076.mo_liquidacion,
                        tb076.nu_anio,
                        tb029.nb_status,
			tb069.tx_inicio_act ||' '||
			case when tb076.nu_anio_desde is null then ' A '::text else tb076.nu_anio_desde::text||' A '  end ||' '|| 				tb069_fin.tx_inicio_act ||' DEL '||tb076.nu_anio as mensaje
                        from
                        tb074_liq_inmueble as tb074
                        left join tb046_ae_ramo as tb046
                        on(tb046.co_ramo = tb074.co_ramo ) left join tb076_liq_detalle tb076
                        on (tb076.co_liq_inmueble = tb074.co_liq_inmueble) left join tb070_inmueble tb070
                        on (tb070.co_inmueble = tb076.co_inmueble) left join tb069_im_inicio_act as tb069
                        on (tb069.co_inicio_act = tb076.co_ini_periodo) left join tb069_im_inicio_act as tb069_fin
                        on (tb069_fin.co_inicio_act = tb076.co_fin_periodo) left join tb077_recaudacion_inm as tb077
                        on (tb077.co_liq_inmueble = tb076.co_liq_inmueble) left join tb029_status tb029
                        on (tb074.co_status = tb029.co_status) left join tb071_contrib_inmueble tb071
                        on (tb071.co_inmueble = tb070.co_inmueble) left join tb004_contribuyente as tb004
                        on(tb004.co_contribuyente = tb074.co_contribuyente) left join tb002_tipo_contribuyente as tb002
                        on(tb002.co_tipo = tb004.co_tipo)
                   where
                        tb071.in_activo = 1 and tb070.co_inmueble = ".$_GET['codigo']."
                   order by nu_anio" ;




        $datos =   $comunes->ObtenerFilasBySqlSelect($sql);

        return $datos;

    }

    function DatosContribuyente() {

        $comunes = new ConexionComun();

        $sql = "select
                       tb071.nu_referencia_inm as nu_referencia,
                        case when tb004.tx_razon_social is null then
                            tb004.nb_contribuyente||' '||tb004.ap_contribuyente
                        else
                            tb004.tx_razon_social
                        end||
                        case when nu_cant_dueno > 1 then ' Y OTROS ' else '' end as nb_contribuyente,
                        case when tx_rif is not null then
                            tb002.tx_tp_doc||'-'||tb004.tx_rif
                        else
                            tb002.tx_tp_doc||'-'||to_char(tb004.nu_cedula,'999999999999')
                        end as rif,
                        tb070.tx_direccion,tb004.tx_denom_comercial
                        from
                         tb071_contrib_inmueble tb071
			left join tb004_contribuyente as tb004
                        on(tb004.co_contribuyente = tb071.co_contribuyente) left join tb002_tipo_contribuyente as tb002
                        on(tb002.co_tipo = tb004.co_tipo)left join tb070_inmueble tb070
                        on (tb070.co_inmueble = tb071.co_inmueble)
                   where
                        tb071.in_activo = 1 and tb071.co_inmueble = ".$_GET['codigo'];




        $datos =   $comunes->ObtenerFilasBySqlSelect($sql);

        return $datos;

    }

}


$pdf=new PDF('P','mm','letter');

$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
