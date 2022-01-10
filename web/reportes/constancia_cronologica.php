<?php
include("ConexionComun.php");
require('flowing_block.php');


class PDF_Flo extends PDF_FlowingBlock
{
   

    function ChapterBody() {
       // $this->Image("imagenes/escudosanfco.png", 100, 7,20);

        $this->SetFont('Arial','B',10);

        $this->SetTextColor(0,0,0);
       // $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('OFICINA DE RECURSOS HUMANOS'),0,0,'C');   
        $this->Ln(20);
        $this->SetFont('Arial','',9);
        $this->Cell(0,0,utf8_decode('La Oficina de Recursos Humanos del Poder Ejecutivo del Estado Zulia, mediante la presente:'),0,0,'C');         
        $this->Ln(20);
        $this->SetFont('Arial','B',14);        

         $this->datos = $this->getTrabajador(); 
     
         $this->Ln(1);         
         $this->SetFont('Arial','B',14);
         $this->SetFillColor(255, 255, 255);         
         $this->SetAligns(array("L","L"));
         $this->SetWidths(array(200));
         $this->SetAligns(array("C"));
         $this->SetY(55);
         
         $this->Row(array(utf8_decode('HACE CONSTAR:')),0,0);
         $this->SetFillColor(255, 255, 255);
         $this->SetFont('Arial','',10);
         $this->Ln(15);
         $this->SetX(20);
         $this->SetLeftMargin(20);
         $this->SetRightMargin(10);
   
         $this->newFlowingBlock( 170, 8, '', 'J' );
         
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $this->WriteFlowingBlock( utf8_decode('Que el ciudadano ') );
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );
         $this->WriteFlowingBlock( 'CEPEDA NECTARIO' );
         
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $data = ", portador de la cédula de identidad ";
         $this->SetX(20);
         $this->WriteFlowingBlock(utf8_decode($data));
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );
         //$montoletras = numtoletras($this->datos['monto_total'],1);
         $cedula='N° 4.50.122';
         $this->SetX(20);
         $this->WriteFlowingBlock(utf8_decode($cedula));
         
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );        
         $data = " presto sus servicios al ";
         $this->SetX(20);
         $this->WriteFlowingBlock($data);
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );
         $data = " EJECUTIVO DEL ESTADO ZULIA,";
         //$data = ", por concepto de ".$this->datos['tx_tipo_ayuda']." que concede el Gobierno Regional a ";        
         $this->WriteFlowingBlock(utf8_decode($data));
         
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $data = " en los siguientes lapsos: ";        
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->SetX(20);
         $this->finishFlowingBlock();        
     
         
         //**************************************
         $this->Ln(5);
         $this->newFlowingBlock( 170, 8, '', 'J' );  
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $data = " 1. Desde el ";        
         $this->WriteFlowingBlock(utf8_decode($data));       
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );
         $data = " 01/01/2018 ";        
         $this->WriteFlowingBlock(utf8_decode($data));   
         
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $data = " hasta el ";        
         $this->WriteFlowingBlock(utf8_decode($data));       
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );
         $data = " 01/03/2018, ";        
         $this->WriteFlowingBlock(utf8_decode($data));  
         
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $data = "en la ";        
         $this->WriteFlowingBlock(utf8_decode($data)); 
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );
         $data = " SECRETARIA DE CULTURA, ";        
         $this->WriteFlowingBlock(utf8_decode($data)); 
         
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $data = "desempeñando, por último, el cargo de ";        
         $this->WriteFlowingBlock(utf8_decode($data));  
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );
         $data = " DISEÑADOR.";        
         $this->WriteFlowingBlock(utf8_decode($data));    
         $this->SetX(20);
         $this->finishFlowingBlock();
         
         //********************************************

         //**************************************
        
         $this->Ln(5);
         $this->newFlowingBlock( 170, 8, '', 'J' );
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $data = " 2. Desde el ";        
         $this->WriteFlowingBlock(utf8_decode($data));       
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );
         $data = " 02/03/2018 ";        
         $this->WriteFlowingBlock(utf8_decode($data));   
         
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $data = " hasta el ";        
         $this->WriteFlowingBlock(utf8_decode($data));       
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );
         $data = " 01/05/2018, ";        
         $this->WriteFlowingBlock(utf8_decode($data));  
         
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $data = "en la ";        
         $this->WriteFlowingBlock(utf8_decode($data)); 
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );
         $data = " SECRETARIA DE CULTURA, ";        
         $this->WriteFlowingBlock(utf8_decode($data)); 
         
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $data = "desempeñando, por último, el cargo de ";        
         $this->WriteFlowingBlock(utf8_decode($data));  
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );
         $data = " JEFE DE TALLER.";        
         $this->WriteFlowingBlock(utf8_decode($data));          
         
         //********************************************         
         
         
         $this->SetX(20);
         $this->SetFont( 'Arial', '', 9 );
         $data = " El ciudadano percibio por concepto de prestaciones sociales, la cantidad de Bs. "; 
         $this->WriteFlowingBlock(utf8_decode($data));
         
         $this->SetX(20);
         $this->SetFont( 'Arial', 'B', 9 );               
         $monto = number_format('2300', 2, ',','.');         
         $this->WriteFlowingBlock(utf8_decode($monto));                
         
         $this->SetX(20);
         $this->finishFlowingBlock();
         
         $this->Ln(10);
         $this->newFlowingBlock( 170, 8, '', 'J' );
         $this->SetFont( 'Arial', '', 9 );
         $this->SetX(20);
         $data='Constancia que se expide a petición escrita de parte interesada en la ciudad de Maracaibo, Estado Zulia a los dos días del mes de mayo del dos mil diesciocho ';
         $this->WriteFlowingBlock(utf8_decode($data));         
         
         $this->SetX(20);
         $this->finishFlowingBlock();
         $this->Ln(20);
         $this->SetFont( 'Arial', 'B', 10 );
         $this->SetX(20);
         $this->Cell(0,0,utf8_decode('Dios y Federación.'),0,0,'C');
         $this->Ln(30);
         $this->SetX(20);
         $this->Cell(0,0,utf8_decode('DRA. LUISA GAMBOA'),0,0,'C');
         $this->Ln(5);
         $this->SetX(20);
         $this->Cell(0,0,utf8_decode('JEFE(A) DE LA OFICINA DE RECURSOS HUMANOS DE LA GOBERNACIÓN DEL ESTADO ZULIA'),0,0,'C');

    }

    function getTrabajador(){

          $conex = new ConexionComun(); 
          
          $sql = "  select (tb007.inicial || '-' || tbrh001.nu_cedula) as nu_cedula, 
                        (tbrh001.nb_primer_nombre || ' ' || tbrh001.nb_segundo_nombre) as nombre, 
                        (tbrh001.nb_primer_apellido || ' ' || tbrh001.nb_segundo_apellido) as apellido,  
                        tbrh047.tx_edo_civil, 
                        to_char(tbrh001.fe_nacimiento,'dd/mm/yyyy') as fe_nac,   
                        tbrh001.tx_direccion_domicilio,  
                        tbrh001.tx_ciudad_domicilio, 
                        tb007.tx_documento as nac,
                        tb165nac.tx_parroquia as parroquia_nac,
                        tb165dom.tx_parroquia as parroquia_domicilio,
                        tbrh001.tx_ciudad_nacimiento,  
                        tbrh001.nu_seguro_social, 
                        tbrh001.nu_rif,
                        to_char(tbrh001.created_at,'dd/mm/yyyy') as fe_registro, 
                        tbrh037.tx_nom_grado_instruccion,  
                        tbrh043.tx_profesion, 
                        tbrh046.tx_sexo,  
                        tbrh049.tx_destreza, 
                        tbrh050.tx_tipo_vivienda, 
                        to_char(tbrh002.fe_ingreso,'dd/mm/yyyy') as fe_ingreso, 
                        to_char(tbrh002.fe_finiquito,'dd/mm/yyyy') as fe_finiquito, 
                        tbrh002.tx_direccion_oficina, 
                        tbrh002.nu_telefono_oficina, 
                        to_char(tbrh002.fe_contrato,'dd/mm/yyyy') as fe_contrato, 
                        tbrh002.nu_ficha 
                         from tb026_solicitud as tb026 
                         left join tbrh001_trabajador as tbrh001 on tbrh001.co_solicitud = tb026.co_solicitud
                         left join tbrh002_ficha as tbrh002 on tbrh002.co_trabajador = tbrh001.co_trabajador 
                         left join tb007_documento as tb007 on tb007.co_documento = tbrh001.co_documento
                         left join tbrh037_nom_grado_instruccion as tbrh037 on tbrh037.co_nom_grado_instruccion = tbrh001.co_nivel_educativo
                         left join tbrh046_sexo as tbrh046 on tbrh046.co_sexo = tbrh001.co_sexo
                         left join tbrh047_edo_civil as tbrh047 on tbrh047.co_edo_civil = tbrh001.co_edo_civil
                         left join tbrh048_grupo_sanguineo as tbrh048 on tbrh048.co_grupo = tbrh001.co_grupo_sanguineo
                         left join tbrh049_destreza as tbrh049 on  tbrh049.co_destreza = tbrh001.co_destreza  
                         left join tbrh043_profesion as tbrh043 on tbrh043.co_profesion = tbrh001.co_profesion  
                         left join tbrh050_tipo_vivienda as tbrh050 on tbrh050.co_tipo_vivienda = tbrh001.co_tipo_vivienda
                         left join tb165_parroquia as tb165nac on tb165nac.co_parroquia = tbrh001.co_parroquia_nacimiento
                         left join tb165_parroquia as tb165dom on tb165dom.co_parroquia = tbrh001.co_parroquia_domicilio
                         left join tb030_ruta as tb030 on tb030.co_solicitud = tb026.co_solicitud 
                         where tb030.co_ruta = ".$_GET['codigo']; //$conex->decrypt($_GET['codigo']);
          
          
//          $sql = "  select UPPER(tb108.tx_observacion_hospedaje) as tx_observacion_hospedaje, 
//                        upper(tb108.tx_evento) as tx_evento, 
//                        tb108.fe_desde, 
//                        tb108.fe_hasta, 
//                        upper(tb008.tx_razon_social) as tx_razon_social,
//                        tb108.created_at as fecha, 
//                        upper(tb047.tx_ente) as tx_ente, 
//                        upper(tb110.tx_origen_viatico) as destino, 
//                        upper(tb107.tx_tipo_viatico ) as tx_tipo_viatico,
//                        tb008.tx_rif,
//                        tb108.co_viatico,
//                        tb108.co_categoria,
//                        tb110c.tx_cargo
//                    from tb026_solicitud as tb026 
//                    left join tbrh001_trabajador as tbrh001 on tbrh001.co_solicitud = tb026.co_solicitud 
//                    left join tb107_tipo_viatico as tb107 on tb107.co_tipo_viatico = tb108.co_tipo_viatico 
//                    left join tb110_origen_viatico as tb110 on tb108.co_destino = tb110.co_origen_viatico 
//                    left join tb008_proveedor as tb008 on tb008.co_proveedor=tb108.co_proveedor 
//                    left join tb001_usuario as tb001 on tb001.co_usuario = tb108.co_usuario
//                    left join tb109_persona as tb109  on tb109.co_proveedor = tb108.co_proveedor 
//                    left join tb110_cargo as tb110c on tb110c.co_cargo = tb109.co_cargo
//                    left join tb047_ente as tb047 on tb047.co_ente = tb001.co_ente 
//                    left join tb030_ruta as tb030 on tb030.co_solicitud = tb108.co_solicitud 
//                    where tb030.co_ruta = ".$_GET['codigo']; //$conex->decrypt($_GET['codigo']);          
                  
          
                   
 //         echo var_dump($sql); exit();
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          //echo var_dump($datosSol); exit();
          return  $datosSol[0];                    
          
          
    }
}


$pdf = new PDF_Flo('P','mm','letter');
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->ChapterBody();

//$comm = new ConexionComun();
//$ruta = $comm->getRuta();
//
////rmdir($ruta);
////mkdir($ruta, 0777, true);    
//
//$dir="$ruta".$_GET["codigo"].".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";
//
//
//$update = "update tb030_ruta set tx_ruta_reporte = '".$dir."' where co_ruta = ".$_GET['codigo']; //$comm->decrypt($_GET["codigo"]);
//
////echo $update; exit();
//$comm->Execute($update);    
//
//$pdf->Output($dir, 'F');

$pdf = new PDF_Flo('P','mm','letter');
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->ChapterBody();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
