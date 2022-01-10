<?php
include("ConexionComun.php");
include("fpdf.php");


class PDF extends FPDF {
    public $title;
    public $conexion;
    function Header() {
 

        $this->Image('imagenes/header.png',05,05,200,30);
    
        $this->Ln(10);
        $this->setXY(70,40);
        $this->SetFont('Arial','U',12);
        $this->cell(60,05,"RECIBO DE PAGO",0,0,"C");

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
      
     
     $this->lista_pensionados = $this->pensionados();
 error_reporting(0);
        // var_dump($this->lista_pensionados); exit();
        $montct3=0;$montct2=0;$montct1=0;
	  foreach($this->lista_pensionados as $data){
    //     if($this->getY()>200){
           
         
    //         $this->addPage('P','mm','A4'); 
    //         $this->SetFillColor(255, 255, 255); 
    //         $this->SetX(3);
    //         $this->SetFont('Arial','B',10);  
    //         $this->SetWidths(array(12,20,33,25,25,30,60,25,25,25));
    //         $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C")); 
    //         $this->Cell(0,5,$this->PageNo()."/".($paginasTotal),1,1,'R');  
    //     }
        

    $anios = $data['nu_mes_reconocido'] / 12;

    $this->AddPage('P','mm','A4');

    // $this->setXY(135,30);
    // $this->SetFont('courier','',8);
    // $this->cell(05,05,"GENERADO POR:",0,0,"C");
    // $this->cell(65,05,utf8_decode(strtoupper($data['nb_usuario'])),0,0,"C");

    $this->SetFont('arial','B', 8);
    $this->SetXY(10,50);                                        
    $this->Write(5,utf8_decode('COMPAÑIA:'));
    $this->SetFont('arial','',8);
    //$this->Write(5,utf8_decode(" ".'ALCALDIA DE SAN FRANCISCO'));
    $this->Cell(60,05,"ALCALDIA DE SAN FRANCISCO",0,0,'L');

    $this->SetFont('arial', 'B', 8); 
    $this->SetXY(80,50);
    $this->write(5,'RIF:');
    $this->SetFont('arial', '', 8);
    $this->write(5," ".'G-20003852-4');

    $this->SetFont('arial', 'B', 8);
    $this->SetXY(125,50);
    $this->write(5,'SUCURSAL:');  
    $this->SetFont('arial', '', 8); 
    //$this->write(5," ".$codep." ".$txdepen);
    //$this->Cell(70,05," ".$codep." ".$txdepen,0,0,'L');
    $this->MultiCell(60,05,utf8_decode(" ".$data['nu_codigo']." ".$data['tx_dependecia']),0,'L' );


    $this->SetFont('arial', 'B', 8);
    $this->SetXY(10,55);
    $this->write(5,'UNIDAD ORG:');
    $this->SetFont('arial', '', 8);
    //$this->write(5,utf8_decode(" ".$codunidad." ".$nomestruct));
    $this->Cell(60,05,utf8_decode(" ".$data['tbrh005nu_codigo']." ".$data['tx_nom_estructura_administrativa']),0,0,'L');


    $this->SetFont('arial', 'B', 8);
    $this->SetXY(125,60);
    $this->write(5,'CARGO:');
    $this->SetFont('arial', '', 8);
    //$this->write(5,utf8_decode(" ".$txcargo));
  // $this->Cell(60,05,utf8_decode(" ".$data['tx_cargo']),0,0,'L');
  $this->Multicell(60,05,utf8_decode(" ".$data['tx_cargo']),0,'L');

    $this->SetFont('arial', 'B', 8);
    $this->SetXY(10,60);
    $this->write(5,'TRABAJADOR:');
    $this->SetFont('arial', '', 8);
    //$this->write(5,utf8_decode(" ".$numficha." ".$nom1." ".$nom2." ".$ape1." ".$ape2));
    $this->Cell(60,05,utf8_decode(" ".$data['nb_primer_nombre']." ".$data['nb_segundo_nombre']." ".$data['nb_primer_apellido']." ".$data['nb_segundo_apellido']),0,0,'L');
    $this->SetFont('arial', 'B', 8);
    $this->SetXY(125,70);
    $this->write(5,'NRO. C.I:');
    $this->SetFont('arial', '', 8);
    //$this->write(5,utf8_decode(" ".$cedula));
    $this->Cell(60,05," ".$data['nu_cedula'],0,0,'L');


    $this->SetFont('arial', 'B', 8);
    $this->SetXY(10,70);
    $this->write(5,'FECHA DE NACIMIENTO:');
    $this->SetFont('arial', '', 8);
    //$this->write(5," ".$f_nac);
    $this->Cell(60,05," ".$data['fe_nacimiento'],0,0,'L');



    $this->SetFont('arial', 'B', 8);
    $this->SetXY(80,70);
    $this->write(5,'NACIONALIDAD:');
    $this->SetFont('arial', '', 8);
    //$this->write(5," ".$t_doc);
    $this->Cell(60,05," ".$data['inicial'],0,0,'L');


    $this->SetFont('arial', 'B', 8);
    $this->SetXY(125,75);
    $this->write(5,'ESTADO CIVIL:');
    $this->SetFont('arial', '', 8);
    //$this->write(5,strtoupper(" ".$edocivil2));
    $this->Cell(60,05," ".strtoupper($data['tx_edo_civil']),0,0,'L');

    $this->SetFont('arial', 'B', 8);
    $this->SetXY(10,75);
    $this->write(5,'F. INGRESO:');
    $this->SetFont('arial', '', 8);
    //$this->write(5, utf8_decode(" ".$ingreso));
    $this->Cell(60,05," ".$data['fe_ingreso'],0,0,'L');


    $this->SetFont('arial', 'B', 8);
    $this->SetXY(80,75);
    $this->write(5,utf8_decode('AÑOS RECONOCIDOS:'));
    $this->SetFont('arial', '', 8);
    //$this->write(5,utf8_decode(" ".$fcorporativa));
    $this->Cell(60,05," ".number_format($anios,2),0,0,'L');

    $this->SetFont('arial', 'B', 8);
    $this->SetXY(80,80);
    $this->write(5,'PERIODO:');
    $this->SetFont('arial', '', 8);
    //$this->write(5," ".$inicio);
    $this->Cell(60,05," ".$data['fe_inicio'],0,0,'L');

    $this->SetFont('arial', 'B', 8);
    $this->SetXY(112,80);
    $this->write(5,'AL:');
    $this->SetFont('arial', '', 8);
    //$this->write(5," ".$fin);
    $this->Cell(60,05," ".$data['fe_fin'],0,0,'L');


    $this->SetFont('arial', 'B', 8);
    $this->SetXY(10,80);
    $this->write(5,'CONTRATO:');
    $this->SetFont('arial', '', 8);
    //$this->write(5,utf8_decode(" ".strtoupper($codgpnom." ".$txgpnom)));
    $this->Cell(60,05," ".strtoupper($data['cod_grupo_nomina']." ".$data['tx_tp_nomina']),0,0,'L');


    $this->SetFont('arial', 'B', 8);
    $this->SetXY(80,85);
    $this->write(5,'BANCO:');
    $this->SetFont('arial', '', 8);
    //$this->write(5,utf8_decode(strtoupper($txbanco)));
    $this->Cell(60,05," ".strtoupper($data['tx_banco']),0,0,'L');

    $this->SetFont('arial', 'B', 8);
    $this->SetXY(10,85);
    $this->write(5,'CUENTA NRO:');
    $this->SetFont('arial', '', 8);
    //$this->write(5," ".$cuenta);
    $this->Cell(60,05," ".$data['nu_cuenta_bancaria'],0,0,'L');



    $this->SetFont('arial', 'B', 8);
    $this->SetXY(157,85);
    $this->write(5,'NUMERO DE  HORAS:');
    $this->SetFont('arial', '', 8);
    $this->Cell(60,05," ".number_format($data['nu_horas'],0, ',','.'),0,0,'L');




    $this->rect(10,100, 190, 5, '');
    $this->SetFont('arial', 'B', 8);
    $this->setXY(10,100);
    $this->write(5,utf8_decode('CODIGO'));
    $this->setXY(25,100);
    $this->write(5,utf8_decode('CONCEPTO'));
    $this->setXY(80,100);
    $this->write(5,utf8_decode('CANTIDAD'));
    $this->SetXY(100,100);
    $this->write(5,utf8_decode('ASIGNACION'));
    $this->SetXY(130,100);
    $this->write(5,utf8_decode('DEDUCCION'));
    $this->SetXY(160,100);
    $this->write(5,utf8_decode('APORTES'));
    $this->SetXY(180,100);
    $this->write(5,utf8_decode('SALDO'));
           
     //------------------------------------------FIN DE DATOS PERSONALES----------------------------\\       
        
     $idtbrh013=$data['co_nomina'];
     $idtbrh002=$data['co_ficha'];
    
    // var_dump($idtbrh013); exit();


     $sql2 = pg_query ("SELECT tbrh102.id, 
     tbrh102.id_tbrh013_nomina as nomina,
     tbrh102.id_tbrh002_ficha as ficha,
     tbrh102.id_tbrh015_nom_trabajador,
     tbrh102.nu_cedula 
     FROM tbrh102_cierre_nomina_trabajador as tbrh102 WHERE   tbrh102.id_tbrh013_nomina = '$idtbrh013' and   tbrh102.id_tbrh002_ficha = '$idtbrh002' ");


  
    while ($verif=pg_fetch_array($sql2)) {
      //var_dump($verif);exit();
    
    

   if ($verif['nomina']==$idtbrh013 and $verif['ficha']==$idtbrh002 ) {
   
                $sql3=  pg_query ("SELECT  tbrh061.id_tbrh015_nom_trabajador,        
                tbrh061.id_tbrh014_concepto, 
                tbrh061.id_tbrh020_tp_concepto, 
                tbrh061.nu_valor, 
                tbrh061.nu_monto, 
                tbrh014.nu_concepto,
                tbrh014.tx_concepto,
                tbrh014.co_tipo_concepto 
            FROM tbrh061_nomina_movimiento as tbrh061
            inner join tbrh014_concepto as tbrh014 on tbrh014.co_concepto = tbrh061.id_tbrh014_concepto
            where tbrh061.id_tbrh013_nomina='$idtbrh013' and tbrh014.co_tipo_concepto not in (4) and id_tbrh002_ficha = '$idtbrh002' 
            GROUP BY tbrh061.id_tbrh015_nom_trabajador, 
            tbrh061.id_tbrh014_concepto, 
            tbrh061.id_tbrh020_tp_concepto, 
            tbrh061.nu_valor,
            tbrh061.nu_monto, 
            tbrh014.nu_concepto,
            tbrh014.tx_concepto,
            tbrh014.co_tipo_concepto  
            ORDER BY tbrh014.co_tipo_concepto,tbrh014.nu_concepto");

      //  $detalles=pg_fetch_array($sql3);
     // var_dump($detalles); exit();
        $y = 103;

     
          
           while ($movimientos=pg_fetch_array($sql3)) {
           //var_dump($movimientos);exit();
          

           $this->setFont('arial', '', 8);
            $y = $y + 5;
           $this->setXY(10,$y);
           $this->cell(60,05,$movimientos['nu_concepto'],0,0);
           $this->setXY(25,$y);
           $this->cell(60,05,utf8_decode($movimientos['tx_concepto']),0,0);
         // var_dump($movimientos['tx_concepto']);exit();
           $this->setXY(80,$y);
           $this->cell(60,05,$movimientos['nu_valor']);
    
            $co_tipo_concepto=$movimientos['co_tipo_concepto'];
    
             for ($i=$movimientos['nu_valor']; $i <=$movimientos['nu_valor'];   $i++) { 
                  
                //es una asignacion
                if ($co_tipo_concepto==1) {
                   $this->setXY(100,$y);
                    $montct1+=$movimientos['nu_monto'];
                   $this->cell(60,05,number_format($movimientos['nu_monto'], 2, ',','.'),0,0,'L');
                }
    
    
                  //es una deduccion
                  if ($co_tipo_concepto==2) {
                   $this->setXY(130,$y);
                    $montct2+=$movimientos['nu_monto'];
                   $this->cell(60,05,number_format($movimientos['nu_monto'], 2, ',','.'),0,0,'L');
                }
    
                 //es un aporte
                 if ($co_tipo_concepto==3) {
                   $this->setXY(160,$y);
                    $montct3+=$movimientos['nu_monto'];
                   $this->cell(60,05,number_format($movimientos['nu_monto'], 2, ',','.'),0,0,'L');
                 }
    
    
                $neto=$montct1-$montct2;
                
    
             }
    
        }

         }


    }
        $this->setXY(180,225);
        $this->SetFont('arial', 'B', 8);
        $this->write(5,utf8_decode("NETO"));
        $this->setXY(75,235);
        $this->Cell(30,05,'TOTAL',0,0,'C');
    
        $this->setXY(100,235);
        $this->Cell(25,05,number_format($montct1, 2, ',','.'),1,1,'C');
        $this->setXY(125,235);
        $this->Cell(25,05,number_format($montct2, 2, ',','.'),1,1,'C');
        $this->setXY(150,235);
        $this->Cell(25,05,number_format($montct3, 2, ',','.'),1,1,'C');
        $this->setXY(175,235);
        $this->Cell(25,05,number_format($neto, 2, ',','.'),1,1,'C');
        $this->setXY(10,245);
        $this->write(5,utf8_decode("CERTIFICO HABER RECIBIDO LA CANTIDAD DE Bs."." ".number_format($neto, 2, ',','.')." "."DE ACUERDO CON EL DETALLE ANTERIOR Y FIRMO EN SEÑAL DE CONFORMIDAD."));
    
        $this->setXY(90,260);
        $this->Cell(30,05,"________________________________________",0,0,'C');
        $this->setXY(90,265);
        $this->Cell(30,05,"FIRMA DEL TRABAJADOR",0,0,'C');
    
        $this->setXY(135,270);
        $this->SetFont('courier','',8);
        $this->cell(05,05,"GENERADO POR:",0,0,"C");
        $this->cell(65,05,utf8_decode(strtoupper($data['nb_usuario'])),0,0,"C");
    
    
        $montct2=0;
        $montct1=0;
        $montct3=0;
        $neto=0;
      }




             }
        

    
    function ChapterTitle($num,$label) {
        $this->SetFont('Arial','',9);
        $this->SetFillColor(200,220,255);
        $this->Cell(0,6,"$label",0,1,'L',1);
        $this->Ln(8);
    }

    function SetTitle($title) {
        $this->title   = $title;
    }

    function PrintChapter() {
       

        $this->ChapterBody();
   }

   
    function pensionados(){
        $inicio=$_GET['fe_inicio'];
        $fin=$_GET['fe_fin'];
        $usuario=$_GET['user'];
        $gpNomia=$_GET['co_grupo_nomina'];
    $conex = new ConexionComun();     
 
             $sql=" SELECT 
              tbrh001.co_trabajador,
              tb007.inicial, 
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
              tbrh102.id_tbrh015_nom_trabajador,
              tbrh005.co_ente,
              tbrh005.co_estructura_administrativa,
              tbrh015.nu_horas,
              tb001.nb_usuario

             FROM tbrh013_nomina as tbrh013 
              inner join tbrh102_cierre_nomina_trabajador as tbrh102 on tbrh102.id_tbrh013_nomina = tbrh013.co_nomina
              inner join tbrh002_ficha as tbrh002 on tbrh002.co_ficha = tbrh102.id_tbrh002_ficha
              inner join tbrh015_nom_trabajador as tbrh015 on tbrh015.co_nom_trabajador = tbrh102.id_tbrh015_nom_trabajador
              inner join tbrh009_cargo_estructura as tbrh009 on tbrh009.co_cargo_estructura =tbrh015.co_cargo_estructura
              inner join tbrh005_estructura_administrativa as tbrh005 on tbrh005.co_estructura_administrativa = tbrh009.co_estructura_administrativa
              inner join tbrh003_dependencia as tbrh003 on  tbrh005.co_ente = tbrh003.co_dependencia
              inner join tbrh032_cargo as tbrh032 on tbrh032.co_cargo = tbrh009.co_cargo

              inner join tbrh001_trabajador as tbrh001 on tbrh001.nu_cedula = tbrh102.nu_cedula
              inner join tb007_documento as tb007 on tbrh001.co_documento = tb007.co_documento
              inner join tb010_banco as tb010 on tbrh001.co_banco = tb010.co_banco
              left join tbrh047_edo_civil as tbrh047 on tbrh001.co_edo_civil = tbrh047.co_edo_civil

              inner join tbrh067_grupo_nomina as tbrh067 on tbrh015.co_grupo_nomina = tbrh067.co_grupo_nomina
              inner join tbrh017_tp_nomina as tbrh017 on tbrh015.co_tp_nomina = tbrh017.co_tp_nomina
              join tb001_usuario as tb001 on tb001.co_usuario = '$usuario'

              where tbrh013.fe_inicio >= '$inicio' and tbrh013.fe_fin <= '$fin' and tbrh013.co_tp_nomina = 5
              and tbrh017.tx_tp_nomina not in ('Alto Nivel') and tbrh013.co_grupo_nomina = '$gpNomia'
              order by tbrh013.fe_inicio, tbrh013.fe_fin 

              
             /*tbrh001.co_trabajador, 
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
             tbrh013.co_tp_nomina,
             tbrh015.nu_horas,
             tb001.nb_usuario
             
             
             
             
             FROM tbrh001_trabajador as tbrh001
             inner join tb007_documento as tb007 on tbrh001.co_documento = tb007.co_documento
             inner join tb010_banco as tb010 on tbrh001.co_banco = tb010.co_banco
             inner join tbrh047_edo_civil as tbrh047 on tbrh001.co_edo_civil = tbrh047.co_edo_civil
             
             inner join tbrh002_ficha as tbrh002 on  tbrh001.co_trabajador = tbrh002.co_trabajador 
             inner join tbrh015_nom_trabajador as tbrh015 on  tbrh015.co_ficha = tbrh002.co_ficha
             inner join tbrh009_cargo_estructura as tbrh009 on tbrh009.co_cargo_estructura =tbrh015.co_cargo_estructura
             inner join tbrh005_estructura_administrativa as tbrh005 on tbrh005.co_estructura_administrativa = tbrh009.co_estructura_administrativa 
             inner join tbrh003_dependencia as tbrh003 on  tbrh005.co_ente = tbrh003.co_dependencia
             inner join tbrh032_cargo as tbrh032 on tbrh032.co_cargo = tbrh009.co_cargo
             inner join tbrh067_grupo_nomina as tbrh067 on tbrh015.co_grupo_nomina = tbrh067.co_grupo_nomina
             inner join tbrh017_tp_nomina as tbrh017 on tbrh015.co_tp_nomina = tbrh017.co_tp_nomina
             inner join tbrh013_nomina as tbrh013 on tbrh015.co_tp_nomina = tbrh013.co_tp_nomina 

             join tb001_usuario as tb001 on tb001.co_usuario = '$usuario'

             where tbrh015.co_grupo_nomina = tbrh013.co_grupo_nomina and
              tbrh013.fe_inicio ='$inicio' and tbrh013.fe_fin = '$fin' and tbrh013.co_tp_nomina = 5 and tbrh015.in_activo = true 
             order by tbrh013.fe_inicio, tbrh013.fe_fin*/
       ";

       
    // echo var_dump($sql); exit();        
       $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
         return  $datosSol; 
	 
    }





}
$pdf=new PDF('P','mm','A4' );

$pdf->AliasNbPages();
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
