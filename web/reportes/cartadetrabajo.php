<?php
include('ConexionComun.php');
include("fpdf.php");

class PDF extends FPDF
{
// Cabecera de página
        function Header()
        {
            // Logo
            $this->Image('imagenes/headerRRHH.png',05,05,200,30);
            $this->Ln(5);
            $this->setXY(80,40);  
            $this->SetFont('Arial','',12);
            $this->cell(60,05,'La Oficina de Recursos Humanos del Poder Ejecutivo del Estado Zulia',0,0,'C');
            $this->setXY(80,60);
            $this->SetFont('Arial','B',12);
            $this->cell(60,05,"HACE CONSTAR",0,0,"C");
        }
        function Footer()
        {
            // Go to 1.5 cm from bottom
            $this->SetY(-15);
            // Select Arial italic 8
            $this->SetFont('Arial','I',8);
            $this->SetY(-10);
            $this->Image('imagenes/pieRRHH.png',05,250,200,30);
        }
}


$pdf = new PDF('Portrait', 'mm', 'Letter');
$pdf->AliasNbPages();

$cedula=$_GET['ci'];

$conex = new ConexionComun();



$datos=pg_query("SELECT 
tbrh001.nu_cedula, 
tbrh001.nb_primer_nombre, 
tbrh001.nb_segundo_nombre,
tbrh001.nb_primer_apellido,
tbrh001.nb_segundo_apellido,
tb007.inicial,
tbrh002.fe_ingreso,
tbrh015.mo_salario_base,
tbrh005.tx_nom_estructura_administrativa,
tbrh032.tx_cargo,
tbrh003.tx_dependecia,
tbrh017.tx_tp_nomina,
tbrh067.cod_grupo_nomina

FROM tbrh001_trabajador as tbrh001 
left join tbrh002_ficha as tbrh002 on tbrh002.co_trabajador = tbrh001.co_trabajador
left join tbrh015_nom_trabajador as tbrh015 on tbrh015.co_ficha = tbrh002.co_ficha
left join tbrh009_cargo_estructura as tbrh009 on tbrh009.co_cargo_estructura =  tbrh015.co_cargo_estructura
left join tbrh005_estructura_administrativa as tbrh005 on tbrh005.co_estructura_administrativa = tbrh009.co_estructura_administrativa
left join tbrh032_cargo as tbrh032 on tbrh032.co_cargo = tbrh009.co_cargo
left join tb007_documento as tb007 on tb007.co_documento = tbrh001.co_documento
left join tbrh003_dependencia as tbrh003 on tbrh003.co_dependencia = tbrh005.co_ente
left join tbrh017_tp_nomina as tbrh017 on tbrh015.co_tp_nomina = tbrh017.co_tp_nomina
left join tbrh067_grupo_nomina as tbrh067 on tbrh015.co_grupo_nomina = tbrh067.co_grupo_nomina
where tbrh001.nu_cedula =$cedula and tbrh017.tx_tp_nomina not in ('Alto Nivel') 
 
 ");


while ($dato=pg_fetch_array($datos)) {
    $pdf->AddPage();
    
    $pdf->SetXY(20,80);
    $pdf->SetFont( 'Arial', '', 12 );
    $pdf->Write(10,utf8_decode('Que el (la) Ciudadano(a)'));
    $pdf->SetFont( 'Arial', 'B', 12 );
    $pdf->write(10,utf8_decode(" ". $dato['nb_primer_apellido']." ".$dato['nb_segundo_apellido']." ".$dato['nb_primer_nombre']." ".$dato['nb_segundo_nombre'].","." "));
    $pdf->SetFont( 'Arial', '', 12 );
    $pdf->Write(10,utf8_decode('portadora de la Cédula de identidad'." "));
    $pdf->SetFont( 'Arial', 'B', 12 );
    $pdf->Write(10,utf8_decode('N°'." ".$dato['inicial']." - ".number_format($dato['nu_cedula'],0,'.','.')));
    $pdf->SetFont( 'Arial', '', 12 );
    $pdf->Write(10,utf8_decode(', presta sus servicios en la'." "));
    $pdf->SetFont( 'Arial', 'B', 12 );
    $pdf->Write(10,utf8_decode($dato['tx_dependecia']." ".'del EJECUTIVO DEL ESTADO ZULIA'));
    $pdf->SetFont( 'Arial', '', 12 );
    $pdf->Write(10,utf8_decode(', adcristo(a) al (a la)'." "));
    $pdf->SetFont( 'Arial', 'B', 12 );
    $pdf->Write(10,utf8_decode($dato['tx_nom_estructura_administrativa']." "));
    $pdf->SetFont( 'Arial', '', 12 );


    if ($dato['tx_tp_nomina']=='Contratados')
     {
        $pdf->Write(10,utf8_decode('como'));
        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Write(10,utf8_decode(strtoupper(" ".'personal'." ".$dato['tx_tp_nomina']." ")));
        $pdf->SetFont( 'Arial', '', 12 );
     }


     
    $pdf->Write(10,utf8_decode(', desde el'." "));
    $pdf->SetFont( 'Arial', 'B', 12 );
    $pdf->Write(10,utf8_decode($dato['fe_ingreso']." "));
    $pdf->SetFont( 'Arial', '', 12 );
    $pdf->Write(10,utf8_decode('hasta la presente fecha, desempeñando actualmente el cargo de'." "));
    $pdf->SetFont( 'Arial', 'B', 12 );
    $pdf->Write(10,utf8_decode($dato['tx_cargo']." "));
    $pdf->SetFont( 'Arial', '', 12 );
    $pdf->Write(10,utf8_decode(', devengando un salario mensal de Bs.'." "));
    $pdf->SetFont( 'Arial', 'B', 12 );
    $pdf->Write(10,utf8_decode(number_format($dato['mo_salario_base'],2,',','.')."."." "));
    $pdf->ln(10);

    $dia=date('d');
    $m=date('m');
    $anio=date('Y');
    $mes='';
    if ($m==1) 
    {
        $mes='ENERO';
    }
    elseif ($m==2) 
    {
        $mes='FEBRERO';
    }
    elseif ($m==3)
    {
        $mes='MARZO';
    }
    elseif ($m==4)
    {
        $mes='ABRIL';
    }
    elseif ($m==5)
    {
        $mes='MAYO';
    }
    elseif ($m==6) 
    {
        $mes='JUNIO';
    }
    elseif ($m==7) 
    {
        $mes='JULIO';
    }
    elseif ($m==8) 
    {
        $mes='AGOSTO';
    }
    elseif ($m==9) 
    {
        $mes='SEPTIEMBRE';
    }
    elseif ($m==10) 
    {
        $mes='OCTUBRE';
    }
    elseif ($m==11) 
    {
        $mes='NOVIEMBRE';
    }
    elseif ($m==12) 
    {
        $mes='DICIEMBRE';
    }


    // $fecha=getdate(date("U"));




    $pdf->SetFont( 'Arial', '', 12 );
    $pdf->Write(10,utf8_decode('Constancia que se expide a petición escrita de parte interesada en la ciudad de Maracaibo, Estado Zulia a los'." "));
   
    $pdf->SetFont( 'Arial', 'B', 12 );
    $pdf->Write(10,utf8_decode($dia." "));
    $pdf->SetFont( 'Arial', '', 12 );
    $pdf->Write(10,utf8_decode('del mes de '." "));
    $pdf->SetFont( 'Arial', 'B', 12 );
    $pdf->Write(10,utf8_decode($mes." "));
    $pdf->SetFont( 'Arial', '', 12 );
    $pdf->Write(10,utf8_decode('del año '." "));
    $pdf->SetFont( 'Arial', 'B', 12 );
    $pdf->Write(10,utf8_decode($anio.". "));
    $pdf->ln(30);

    $pdf->setX(80);
    $pdf->Cell(60,05,utf8_decode('Dios y Federación.'),0,0,'C');      
    $pdf->ln(30);

    $pdf->setX(80);
    $pdf->Cell(60,05,utf8_decode('Dra. NELLY C. SÁNCHEZ RONDÓN'),0,0,'C');  
    $pdf->ln();
    $pdf->setX(80);
    $pdf->Cell(60,05,utf8_decode('JEFE(A) DE LA OFICINA DE RECURSOS HUMANOS DE LA'),0,0,'C');   
    $pdf->ln();
    $pdf->setX(80);
    $pdf->Cell(60,05,utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'),0,0,'C');  
    $pdf->ln(20);

}


$pdf->Output();
?>
