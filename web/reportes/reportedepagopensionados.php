<?php
include('ConexionComun.php');
include("fpdf.php");

class PDF extends FPDF
{
// Cabecera de página
        function Header()
        {
            // Logo
            $this->Image('imagenes/header.png',05,05,200,30);
    
            $this->Ln(10);
            $this->setXY(70,40);
            $this->SetFont('Arial','U',12);
            $this->cell(60,05,"RECIBO DE PAGO",0,0,"C");
        }
}
error_reporting(0);
$pdf = new PDF();
$pdf->AliasNbPages();




$inicio=$_GET['fe_inicio'];
$fin=$_GET['fe_fin'];


$montct3=0;$montct2=0;$montct1=0;
$conex = new ConexionComun();

$datos=pg_query("SELECT tbrh001.co_trabajador, 
tbrh001.nu_cedula,
tbrh001.nb_primer_nombre,
tbrh001.nb_segundo_nombre,
tbrh001.nb_primer_apellido,
tbrh001.nb_segundo_apellido,
tbrh001.fe_nacimiento,
tbrh001.nu_mes_reconocido,
tbrh047.tx_edo_civil,
tbrh001.nu_cuenta_bancaria,
tbrh003.nu_codigo,
tbrh003.tx_dependecia,
tb007.inicial,
tb010.tx_banco, 
tbrh002.nu_ficha,
tbrh002.co_ficha,
tbrh002.fe_ingreso,
tbrh002.fe_corporativa,
tbrh015.mo_salario_base,
tbrh005.nu_codigo as tbrh005nu_codigo,
tbrh005.tx_nom_estructura_administrativa,
tbrh032.tx_cargo, 
tbrh067.cod_grupo_nomina,
tbrh017.tx_tp_nomina,
tbrh013.co_nomina,
tbrh013.fe_inicio,
tbrh013.fe_fin,
tbrh013.de_nomina,
tbrh013.de_observacion,
tbrh015.co_nom_trabajador,
tbrh005.co_ente,
tbrh005.co_estructura_administrativa,
tbrh015.in_activo




FROM tbrh001_trabajador as tbrh001
left join tb007_documento as tb007 on tbrh001.co_documento = tb007.co_documento
left join tb010_banco as tb010 on tbrh001.co_banco = tb010.co_banco
left join tbrh047_edo_civil as tbrh047 on tbrh001.co_edo_civil = tbrh047.co_edo_civil

left join tbrh002_ficha as tbrh002 on  tbrh001.co_trabajador = tbrh002.co_trabajador 
left join tbrh015_nom_trabajador as tbrh015 on  tbrh015.co_ficha = tbrh002.co_ficha
left join tbrh009_cargo_estructura as tbrh009 on tbrh009.co_cargo_estructura =tbrh015.co_cargo_estructura
left join tbrh005_estructura_administrativa as tbrh005 on tbrh005.co_estructura_administrativa = tbrh009.co_estructura_administrativa 
left join tbrh003_dependencia as tbrh003 on  tbrh005.co_ente = tbrh003.co_dependencia
left join tbrh032_cargo as tbrh032 on tbrh032.co_cargo = tbrh009.co_cargo
left join tbrh067_grupo_nomina as tbrh067 on tbrh015.co_grupo_nomina = tbrh067.co_grupo_nomina
left join tbrh017_tp_nomina as tbrh017 on tbrh015.co_tp_nomina = tbrh017.co_tp_nomina
left join tbrh013_nomina as tbrh013 on tbrh015.co_tp_nomina = tbrh013.co_tp_nomina 
 where tbrh017.tx_tp_nomina = 'Pensionados' and tbrh017.tx_tp_nomina not in ('Alto Nivel') and tbrh015.in_activo not in ('false')
  and tbrh015.co_grupo_nomina = tbrh013.co_grupo_nomina and tbrh013.fe_inicio >='$inicio' and tbrh013.fe_fin <= '$fin'");

 while ($data=pg_fetch_array($datos)) {
   
    $anios = $data['nu_mes_reconocido'] / 12;

    $pdf->AddPage();

    $pdf->SetFont('arial','B', 8);
    $pdf->SetXY(10,50);                                        
    $pdf->Write(5,utf8_decode('COMPAÑIA:'));
    $pdf->SetFont('arial','',8);
    //$pdf->Write(5,utf8_decode(" ".'<NOMBRE DE LA INSTITUCION>'));
    $pdf->Cell(60,05,"<NOMBRE DE LA INSTITUCION>",0,0,'L');

    $pdf->SetFont('arial', 'B', 8); 
    $pdf->SetXY(80,50);
    $pdf->write(5,'RIF:');
    $pdf->SetFont('arial', '', 8);
    $pdf->write(5," ".'G-20003852-4');

    $pdf->SetFont('arial', 'B', 8);
    $pdf->SetXY(125,50);
    $pdf->write(5,'SUCURSAL:');  
    $pdf->SetFont('arial', '', 8); 
    //$pdf->write(5," ".$codep." ".$txdepen);
    //$pdf->Cell(70,05," ".$codep." ".$txdepen,0,0,'L');
    $pdf->MultiCell(60,05,utf8_decode(" ".$data['nu_codigo']." ".$data['tx_dependecia']),0,'L' );


    $pdf->SetFont('arial', 'B', 8);
    $pdf->SetXY(10,55);
    $pdf->write(5,'UNIDAD ORG:');
    $pdf->SetFont('arial', '', 8);
    //$pdf->write(5,utf8_decode(" ".$codunidad." ".$nomestruct));
    $pdf->Cell(60,05,utf8_decode(" ".$data['tbrh005nu_codigo']." ".$data['tx_nom_estructura_administrativa']),0,0,'L');


    $pdf->SetFont('arial', 'B', 8);
    $pdf->SetXY(125,60);
    $pdf->write(5,'CARGO:');
    $pdf->SetFont('arial', '', 8);
    //$pdf->write(5,utf8_decode(" ".$txcargo));
  // $pdf->Cell(60,05,utf8_decode(" ".$data['tx_cargo']),0,0,'L');
  $pdf->Multicell(60,05,utf8_decode(" ".$data['tx_cargo']),0,'L');

    $pdf->SetFont('arial', 'B', 8);
    $pdf->SetXY(10,60);
    $pdf->write(5,'TRABAJADOR:');
    $pdf->SetFont('arial', '', 8);
    //$pdf->write(5,utf8_decode(" ".$numficha." ".$nom1." ".$nom2." ".$ape1." ".$ape2));
    $pdf->Cell(60,05,utf8_decode(" ".$data['nb_primer_nombre']." ".$data['nb_segundo_nombre']." ".$data['nb_primer_apellido']." ".$data['nb_segundo_apellido']),0,0,'L');
    $pdf->SetFont('arial', 'B', 8);
    $pdf->SetXY(125,70);
    $pdf->write(5,'NRO. C.I:');
    $pdf->SetFont('arial', '', 8);
    //$pdf->write(5,utf8_decode(" ".$cedula));
    $pdf->Cell(60,05," ".$data['nu_cedula'],0,0,'L');


    $pdf->SetFont('arial', 'B', 8);
    $pdf->SetXY(10,70);
    $pdf->write(5,'FECHA DE NACIMIENTO:');
    $pdf->SetFont('arial', '', 8);
    //$pdf->write(5," ".$f_nac);
    $pdf->Cell(60,05," ".$data['fe_nacimiento'],0,0,'L');



    $pdf->SetFont('arial', 'B', 8);
    $pdf->SetXY(80,70);
    $pdf->write(5,'NACIONALIDAD:');
    $pdf->SetFont('arial', '', 8);
    //$pdf->write(5," ".$t_doc);
    $pdf->Cell(60,05," ".$data['inicial'],0,0,'L');


    $pdf->SetFont('arial', 'B', 8);
    $pdf->SetXY(125,75);
    $pdf->write(5,'ESTADO CIVIL:');
    $pdf->SetFont('arial', '', 8);
    //$pdf->write(5,strtoupper(" ".$edocivil2));
    $pdf->Cell(60,05," ".strtoupper($data['tx_edo_civil']),0,0,'L');

    $pdf->SetFont('arial', 'B', 8);
    $pdf->SetXY(10,75);
    $pdf->write(5,'F. INGRESO:');
    $pdf->SetFont('arial', '', 8);
    //$pdf->write(5, utf8_decode(" ".$ingreso));
    $pdf->Cell(60,05," ".$data['fe_ingreso'],0,0,'L');


    $pdf->SetFont('arial', 'B', 8);
    $pdf->SetXY(80,75);
    $pdf->write(5,utf8_decode('AÑOS RECONOCIDOS:'));
    $pdf->SetFont('arial', '', 8);
    //$pdf->write(5,utf8_decode(" ".$fcorporativa));
    $pdf->Cell(60,05," ".number_format($anios,2),0,0,'L');

    $pdf->SetFont('arial', 'B', 8);
    $pdf->SetXY(80,80);
    $pdf->write(5,'PERIODO:');
    $pdf->SetFont('arial', '', 8);
    //$pdf->write(5," ".$inicio);
    $pdf->Cell(60,05," ".$data['fe_inicio'],0,0,'L');

    $pdf->SetFont('arial', 'B', 8);
    $pdf->SetXY(112,80);
    $pdf->write(5,'AL:');
    $pdf->SetFont('arial', '', 8);
    //$pdf->write(5," ".$fin);
    $pdf->Cell(60,05," ".$data['fe_fin'],0,0,'L');


    $pdf->SetFont('arial', 'B', 8);
    $pdf->SetXY(10,80);
    $pdf->write(5,'CONTRATO:');
    $pdf->SetFont('arial', '', 8);
    //$pdf->write(5,utf8_decode(" ".strtoupper($codgpnom." ".$txgpnom)));
    $pdf->Cell(60,05," ".strtoupper($data['cod_grupo_nomina']." ".$data['tx_tp_nomina']),0,0,'L');


    $pdf->SetFont('arial', 'B', 8);
    $pdf->SetXY(80,85);
    $pdf->write(5,'BANCO:');
    $pdf->SetFont('arial', '', 8);
    //$pdf->write(5,utf8_decode(strtoupper($txbanco)));
    $pdf->Cell(60,05," ".strtoupper($data['tx_banco']),0,0,'L');

    $pdf->SetFont('arial', 'B', 8);
    $pdf->SetXY(10,85);
    $pdf->write(5,'CUENTA NRO:');
    $pdf->SetFont('arial', '', 8);
    //$pdf->write(5," ".$cuenta);
    $pdf->Cell(60,05," ".$data['nu_cuenta_bancaria'],0,0,'L');



    $pdf->SetFont('arial', 'B', 8);
    $pdf->SetXY(157,85);
    $pdf->write(5,'SUELDO:');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(60,05," ".number_format($data['mo_salario_base'], 2, ',','.'),0,0,'L');



    //$pdf->AddPage();
//-------------------------------------------FIN DE DATOS PERSONALES ---------------------------------------------------\\
    $pdf->rect(10,100, 190, 5, '');
    $pdf->SetFont('arial', 'B', 8);
    $pdf->setXY(10,100);
    $pdf->write(5,utf8_decode('CODIGO'));
    $pdf->setXY(25,100);
    $pdf->write(5,utf8_decode('CONCEPTO'));
    $pdf->setXY(80,100);
    $pdf->write(5,utf8_decode('CANTIDAD'));
    $pdf->SetXY(100,100);
    $pdf->write(5,utf8_decode('ASIGNACION'));
    $pdf->SetXY(130,100);
    $pdf->write(5,utf8_decode('DEDUCCION'));
    $pdf->SetXY(160,100);
    $pdf->write(5,utf8_decode('APORTES'));
    $pdf->SetXY(180,100);
    $pdf->write(5,utf8_decode('SALDO'));

          
    $idtbrh013=$data['co_nomina'];
    $idtbrh002=$data['co_ficha'];
    $idtbrh015=$data['co_nom_trabajador'];

    $verifDatos=pg_query("SELECT tbrh102.id, 
    tbrh102.id_tbrh013_nomina,
    tbrh102.id_tbrh002_ficha,
    tbrh102.id_tbrh015_nom_trabajador,
    tbrh102.nu_cedula 
    FROM tbrh102_cierre_nomina_trabajador as tbrh102 WHERE   tbrh102.id_tbrh013_nomina = '$idtbrh013' and   tbrh102.id_tbrh002_ficha = '$idtbrh002' and   tbrh102.id_tbrh015_nom_trabajador = '$idtbrh015'  ");

    while ($verifDatos2=pg_fetch_array($verifDatos)) {
    if ($verifDatos2['id_tbrh013_nomina']==$idtbrh013 and $verifDatos2['id_tbrh002_ficha']==$idtbrh002 
    and $verifDatos2['id_tbrh015_nom_trabajador']==$idtbrh015 ) {


        $datos2=pg_query("      
        SELECT  tbrh061.id_tbrh015_nom_trabajador,        
                tbrh061.id_tbrh014_concepto, 
                tbrh061.id_tbrh020_tp_concepto, 
                tbrh061.nu_valor, 
                tbrh061.nu_monto, 
                tbrh014.nu_concepto,
                tbrh014.tx_concepto,
                tbrh014.co_tipo_concepto 
            FROM tbrh061_nomina_movimiento as tbrh061
            inner join tbrh014_concepto as tbrh014 on tbrh014.co_concepto = tbrh061.id_tbrh014_concepto
            where tbrh061.id_tbrh013_nomina='$idtbrh013' and tbrh014.co_tipo_concepto not in (4) and id_tbrh002_ficha = '$idtbrh002' AND tbrh061.id_tbrh015_nom_trabajador = '$idtbrh015'
            GROUP BY tbrh061.id_tbrh015_nom_trabajador, 
            tbrh061.id_tbrh014_concepto, 
            tbrh061.id_tbrh020_tp_concepto, 
            tbrh061.nu_valor,
            tbrh061.nu_monto, 
            tbrh014.nu_concepto,
            tbrh014.tx_concepto,
            tbrh014.co_tipo_concepto  
            ORDER BY tbrh014.co_tipo_concepto,tbrh014.nu_concepto
     ");
       }
    }

        $y = 103;
    
    while ($data2=pg_fetch_array($datos2)) {
        

        $pdf->setFont('arial', '', 8);
        $y = $y + 5;
        $pdf->setXY(10,$y);
        $pdf->cell(60,05,$data2['nu_concepto'],0,0);
        $pdf->setXY(25,$y);
        $pdf->cell(60,05,utf8_decode($data2['tx_concepto']),0,0);
        $pdf->setXY(80,$y);
        $pdf->cell(60,05,$data2['nu_valor']);

        $co_tipo_concepto=$data2['co_tipo_concepto'];

         for ($i=$data2['nu_valor']; $i <=$data2['nu_valor'];   $i++) { 
              
            //es una asignacion
            if ($co_tipo_concepto==1) {
                $pdf->setXY(100,$y);
                $montct1+=$data2['nu_monto'];
                $pdf->cell(60,05,number_format($data2['nu_monto'], 2, ',','.'),0,0,'L');
            }


              //es una deduccion
              if ($co_tipo_concepto==2) {
                $pdf->setXY(130,$y);
                $montct2+=$data2['nu_monto'];
                $pdf->cell(60,05,number_format($data2['nu_monto'], 2, ',','.'),0,0,'L');
            }

             //es un aporte
             if ($co_tipo_concepto==3) {
                $pdf->setXY(160,$y);
                $montct3+=$data2['nu_monto'];
                $pdf->cell(60,05,number_format($data2['nu_monto'], 2, ',','.'),0,0,'L');
             }


            $neto=$montct1-$montct2;
            

         }


    }
    
    $pdf->setXY(180,225);
    $pdf->SetFont('arial', 'B', 8);
    $pdf->write(5,utf8_decode("NETO"));
    $pdf->setXY(75,235);
    $pdf->Cell(30,05,'TOTAL',0,0,'C');

    $pdf->setXY(100,235);
    $pdf->Cell(25,05,number_format($montct1, 2, ',','.'),1,1,'C');
    $pdf->setXY(125,235);
    $pdf->Cell(25,05,number_format($montct2, 2, ',','.'),1,1,'C');
    $pdf->setXY(150,235);
    $pdf->Cell(25,05,number_format($montct3, 2, ',','.'),1,1,'C');
    $pdf->setXY(175,235);
    $pdf->Cell(25,05,number_format($neto, 2, ',','.'),1,1,'C');
    $pdf->setXY(10,245);
    $pdf->write(5,utf8_decode("CERTIFICO HABER RECIBIDO LA CANTIDAD DE Bs."." ".number_format($neto, 2, ',','.')." "."DE ACUERDO CON EL DETALLE ANTERIOR Y FIRMO EN SEÑAL DE CONFORMIDAD."));

    $pdf->setXY(90,260);
    $pdf->Cell(30,05,"________________________________________",0,0,'C');
    $pdf->setXY(90,265);
    $pdf->Cell(30,05,"FIRMA DEL TRABAJADOR",0,0,'C');



    $montct2=0;
    $montct1=0;
    $montct3=0;
    $neto=0;
  }
 

$pdf->Output();
?>