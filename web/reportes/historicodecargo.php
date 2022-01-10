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

$cedula=$_GET['ci'];


$conex = new ConexionComun();

$pdf->AliasNbPages();



$datospersonales=pg_query("SELECT tbrh001.co_trabajador,
tbrh001.nu_cedula,
tbrh001.nb_primer_nombre,
tbrh001.nb_segundo_nombre,
tbrh001.nb_primer_apellido,
tbrh001.nb_segundo_apellido
FROM tbrh001_trabajador as tbrh001 where tbrh001.nu_cedula = '$cedula'");



$datos=pg_query("SELECT tbrh001.co_trabajador,
tbrh001.nu_cedula,
tbrh001.nb_primer_nombre,
tbrh001.nb_segundo_nombre,
tbrh001.nb_primer_apellido,
tbrh001.nb_segundo_apellido,
tbrh002.fe_ingreso,
tbrh009.co_cargo,
tbrh032.tx_cargo,
tbrh015.mo_salario_base,
tbrh015.fe_ingreso as tbrh015fe_ingreso,
tbrh015.fe_finiquito,
tbrh002.co_ficha,
tbrh005.tx_nom_estructura_administrativa,
tbrh015.in_activo


FROM tbrh001_trabajador as tbrh001
join tbrh002_ficha as tbrh002 on tbrh002.co_trabajador = tbrh001.co_trabajador
join tbrh015_nom_trabajador as tbrh015 on tbrh015.co_ficha = tbrh002.co_ficha
join tbrh009_cargo_estructura as tbrh009 on tbrh009.co_cargo_estructura = tbrh015.co_cargo_estructura
join tbrh005_estructura_administrativa as tbrh005 on tbrh005.co_estructura_administrativa = tbrh009.co_estructura_administrativa
join tbrh032_cargo as tbrh032 on tbrh032.co_cargo = tbrh009.co_cargo where tbrh001.nu_cedula ='$cedula' 
order by tbrh015.fe_finiquito ");







$dpersonales=pg_fetch_array($datospersonales);


$primer_apellido=$dpersonales['nb_primer_apellido'];
$segundo_apellido=$dpersonales['nb_segundo_apellido'];
$primer_nombre=$dpersonales['nb_primer_nombre'];
$segundo_nombre=$dpersonales['nb_segundo_nombre'];
$cedula=$dpersonales['nu_cedula'];

$pdf->AddPage();

$pdf->setXY(20,70);
$pdf->setFont('Arial', '', 12);
$pdf->write(10,utf8_decode('Que él (la) Ciudadano(a)'));
$pdf->setFont('Arial', 'B', 12);
$pdf->write(10,utf8_decode(" ".$primer_apellido." ".$segundo_apellido." ".$primer_nombre." ".$segundo_apellido." "));
$pdf->setFont('Arial', '', 12);
$pdf->write(10,utf8_decode(', titular de la cédula de identidad '));
$pdf->setFont('Arial', 'B', 12);
$pdf->write(10,utf8_decode("  N° ".number_format($cedula,0,'.','.')));
$pdf->setFont('Arial', '', 12);
$pdf->write(10,utf8_decode(" ".' laboró para el'));
$pdf->setFont('Arial', 'B', 12);
$pdf->write(10,utf8_decode(' EJECUTIVO DEL ESTADO ZULIA '));
$pdf->setFont('Arial', '', 12);
$pdf->write(10,utf8_decode('en los siguientes lapsos:'));
$pdf->ln(15);


$i=1;



while ($data=pg_fetch_array($datos)) {
    
    $pdf->setFont('Arial', '', 12);
    $pdf->write(10,utf8_decode($i."."));
    $pdf->write(10,utf8_decode(' En el (la) '));
    $pdf->setFont('Arial', 'B', 12);
    $pdf->write(10,utf8_decode($data['tx_nom_estructura_administrativa']." "));
    $pdf->setFont('Arial', '', 12);
    $pdf->write(10,utf8_decode(', desde el '));
    $pdf->setFont('Arial', 'B', 12);
    $pdf->write(10,utf8_decode($data['tbrh015fe_ingreso']));
        
    $pdf->setFont('Arial', '', 12);
    $pdf->write(10,utf8_decode("  ".'hasta el '));
    $pdf->setFont('Arial', 'B', 12);
    $pdf->write(10,utf8_decode($data['fe_finiquito']));
    $pdf->setFont('Arial', '', 12);
    $pdf->write(10,utf8_decode("  ".'desempeñando, por ultimo, el cargo de'));
    $pdf->setFont('Arial', 'B', 12);
    $pdf->write(10,utf8_decode("  ".$data['tx_cargo']));
    $pdf->ln(15);    


     $i=$i+1;
}
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

    $pdf->ln(10);
    $pdf->setFont('Arial', '', 12);
    $pdf->write(10,utf8_decode("  ".'Constancia que se expide, a petición escrita de parte interesada, en la ciudad de Maracaibo, del estado Zulia, a los'));
    $pdf->setFont('Arial', 'B', 12);
    $pdf->write(10,utf8_decode(" ".$dia));
    $pdf->setFont('Arial', '', 12);
    $pdf->write(10,utf8_decode(" ".'dias del mes de '));
    $pdf->setFont('Arial', 'B', 12);
    $pdf->write(10,utf8_decode(" ".$mes));
    $pdf->setFont('Arial', '', 12);
    $pdf->write(10,utf8_decode(" ".'del año'));
    $pdf->setFont('Arial', 'B', 12);
    $pdf->write(10,utf8_decode(" ".$anio));
    $pdf->ln(20);

    $pdf->setX(80);
    $pdf->Cell(60,05,utf8_decode('Dios y Federación.'),0,0,'C');      
    $pdf->ln(20);

    $pdf->setX(80);
    $pdf->Cell(60,05,utf8_decode('Dra. NELLY C. SÁNCHEZ RONDÓN'),0,0,'C');  
    $pdf->ln();
    $pdf->setX(80);
    $pdf->Cell(60,05,utf8_decode('JEFE(A) DE LA OFICINA DE RECURSOS HUMANOS DE LA'),0,0,'C');   
    $pdf->ln();
    $pdf->setX(80);
    $pdf->Cell(60,05,utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'),0,0,'C');  
    $pdf->ln(20);
    

$pdf->Output();
?>
