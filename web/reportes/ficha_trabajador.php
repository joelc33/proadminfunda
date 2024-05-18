<?php
include("ConexionComun.php");
require('flowing_block.php');


class PDF_Flo extends PDF_FlowingBlock
{
   

    function ChapterBody() {
       // $this->Image("imagenes/escudosanfco.png", 100, 7,20);

        $this->SetFont('Arial','B',8);

        $this->SetTextColor(0,0,0);
       // $this->SetY(32);
        $this->Cell(0,0,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,0,utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'),0,0,'C');
        $this->Ln(4);
        $this->SetX(25);       
        $this->Cell(0,0,utf8_decode('FECHA: ').date("d/m/Y", strtotime($this->datos['created_at'])),0,0,'R');  
        $this->Ln(6);
        $this->SetFont('Arial','B',14);        

         $this->datos = $this->getTrabajador(); 
         
         $this->SetFont('Arial','B',14);
         $this->Cell(0,0,utf8_decode('FICHA TÉCNICA DEL TRABAJADOR'),0,0,'C');
     
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);         
         $this->SetWidths(array(30,140));
         $this->SetAligns(array("L", "L"));
         $this->SetY(35);
         $this->SetFillColor(201, 199, 199);
         $this->SetX(25);            
         $this->Row(array('FICHA: '.$this->datos['nu_ficha'], utf8_decode('DATOS BÁSICOS')),1,1);
         $this->SetFillColor(255, 255, 255);
         $this->SetWidths(array(85,85));         
         $this->SetFont('Arial','',9);
         $this->SetX(25);          
         $Y = $this->GetY();
         $this->MultiCell(170,24,'',1,1,'L',1); 
   
         /*******************************************/
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "NOMBRES: ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', '', 9 );
         $data = utf8_decode($this->datos['nombre']);
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();           
         
         /*******************************************/
         $this->newFlowingBlock(85, 8, '', 'J' );         
         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "APELLIDOS: ";
         $this->WriteFlowingBlock(utf8_decode($data));         
         $this->SetY($Y+2);
         $this->SetX(165);    
         $this->MultiCell(20,20,'',1,1,'L',1); 
         $this->Image("../../foto/16149666.JPG", 166, 3+$Y, 18);
         $this->SetY($Y);
         $this->SetX(95);  
         $this->SetFont( 'Arial', '', 9 );
         $data = utf8_decode($this->datos['apellido']);
         $this->WriteFlowingBlock(utf8_decode($data)); 
         $this->finishFlowingBlock();
         $Y = $this->GetY();
         
         /*******************************************/
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "C.I./R.I.F.: ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', '', 9 );
         $data = utf8_decode($this->datos['nu_cedula']);
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();         
         
         /*******************************************/
         $this->newFlowingBlock(85, 8, '', 'J' );         
         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "NACIONALIDAD/FIGURA:  ";
         $this->WriteFlowingBlock(utf8_decode($data));         
         $this->SetY($Y);
         $this->SetX(95);           
         $this->SetFont( 'Arial', '', 9 );
         $data = $this->datos['nac'];
         $this->WriteFlowingBlock(utf8_decode($data)); 
         $this->finishFlowingBlock();
         $Y = $this->GetY();
         
         /*******************************************/  
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "ESTADO CIVIL: ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', '', 9 );
         $data = utf8_decode($this->datos['tx_edo_civil']);
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();         
         
         /*******************************************/
         $this->newFlowingBlock(85, 8, '', 'J' );         
         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "FECHA DE NAC.: ";  
         $this->WriteFlowingBlock(utf8_decode($data));         
         $this->SetY($Y+2);
         $this->SetX(119);           
         $this->SetWidths(array(5));
         //$this->MultiCell(3,3,'',1,1,'L',1);          
         $this->SetY($Y);
         $data = $this->datos['fe_nac'];           
         $this->SetFont( 'Arial', '', 9 );
         $this->SetX(95);
         $this->WriteFlowingBlock(utf8_decode($data)); 
         
         $this->finishFlowingBlock();
         $Y = $this->GetY();

         $this->SetX(25);
         $this->MultiCell(170,30,'',1,1,'L',1); 
         
         /*******************************************/    
         
         $this->newFlowingBlock(85, 8, '', 'J' );     
         
         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "CIUDAD NAC.:  ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(25); 
         $data=utf8_decode($this->datos['tx_ciudad_nacimiento']);  
         $this->SetFont( 'Arial', '', 9 );         
         $this->WriteFlowingBlock(utf8_decode($data)); 
         
         $this->SetWidths(array(5));
         $this->SetY($Y+4);
         $this->SetX(71); 
                  
         $this->SetY($Y+2);
         $data=utf8_decode($this->datos['tx_ciudad_nacimiento']);         
         $this->SetFont( 'Arial', 'B', 10 );
         $this->WriteFlowingBlock(utf8_decode($data)); 
         $Y = $this->GetY();
         $this->SetX(25); 
         $this->finishFlowingBlock();     
                
         /*******************************************/  
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "CIUDAD DOMICILIO: ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', '', 9 );
         $data = '';
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();     
         
         /*******************************************/  
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(150);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "DESTREZA: ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(150);           
         $this->SetFont( 'Arial', '', 9 );
         $data = utf8_decode($this->datos['tx_destreza']);
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();     
                           
         /*******************************************/  
         $this->ln(5);
         $this->newFlowingBlock(85, 8, '', 'J' );     
         $Y = $Y +8;
         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "MUNICIPIO NAC.:  ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', '', 9 );
         $data = '';
         $this->WriteFlowingBlock(utf8_decode($data)); 
         
         $this->SetWidths(array(5));
         $this->SetY($Y+4);
         $this->SetX(71); 
        // $this->MultiCell(3,3,'',1,1,'L',1);  
         
         $this->SetY($Y+2);
         $data = '  ';           
         $this->SetFont( 'Arial', 'B', 10 );
         $this->WriteFlowingBlock(utf8_decode($data)); 
         $Y = $this->GetY();
         $this->SetX(25); 
         $this->finishFlowingBlock();     

         /*******************************************/  
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "MUNICIPIO DOMICILIO:  ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', '', 9 );
         $data = '';
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();                   
                      
         
         /*******************************************/  
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(150);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "SEXO:  ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(150);           
         $this->SetFont( 'Arial', '', 9 );
         $data = utf8_decode($this->datos['tx_sexo']);
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();                   
         
         $Y = $this->GetY();
       
         /*******************************************/ 
         $this->newFlowingBlock(85, 8, '', 'J' );     
         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "PAÍS NAC.:  ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', '', 9 );
         $data = '';
         $this->WriteFlowingBlock(utf8_decode($data)); 
         
         $this->SetWidths(array(5));
         $this->SetY($Y+4);
         $this->SetX(71); 
         //$this->MultiCell(3,3,'',1,1,'L',1);  
         
         $this->SetY($Y+2);
         $data = '  ';           
         $this->SetFont( 'Arial', 'B', 10 );
         $this->WriteFlowingBlock(utf8_decode($data)); 
         $Y = $this->GetY();
         $this->SetX(25); 
         $this->finishFlowingBlock();     
         
         /*******************************************/  
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "PAIS DOMICILIO:  ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', '', 9 );
         $data = '';
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();                   
         
         $this->SetX(25);
         $this->MultiCell(170,30,'',1,1,'L',1);           
                
         /*******************************************/  
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(150);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "TIPO VIVIENDA:  ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(150);           
         $this->SetFont( 'Arial', '', 9 );
         $data = '';
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();                   
         
         $Y = $this->GetY();

         $this->SetX(25);
        // $this->MultiCell(170,30,'',1,1,'L',1);          
         /*******************************************/          
      
         $this->newFlowingBlock(85, 8, '', 'J' );     
         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "INGRESO:  ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', '', 9 );
         $data = '';
         $this->WriteFlowingBlock(utf8_decode($data)); 
         
         $this->SetWidths(array(5));
         $this->SetY($Y+4);
         $this->SetX(71); 
         //$this->MultiCell(3,3,'',1,1,'L',1);  
         
         $this->SetY($Y+2);
         $data = '  ';           
         $this->SetFont( 'Arial', 'B', 10 );
         $this->WriteFlowingBlock(utf8_decode($data)); 
         $Y = $this->GetY();
         $this->SetX(25); 
         $this->finishFlowingBlock();     
         
         /*******************************************/  
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "FIN DE CONTRATO:  ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(85);           
         $this->SetFont( 'Arial', '', 9 );
         $data = '';
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();                   
         
         $this->SetX(25);
        // $this->MultiCell(170,30,'',1,1,'L',1);           
                
         /*******************************************/  
         $this->newFlowingBlock(85, 8, '', 'J' );
         $this->SetY($Y);
         $this->SetX(150);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "FINIQUITO:  ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(150);           
         $this->SetFont( 'Arial', '', 9 );
         $data = '';
         $this->WriteFlowingBlock(utf8_decode($data));
         $this->finishFlowingBlock();                   
         
         $Y = $this->GetY();

         $this->SetX(25);
        // $this->MultiCell(170,30,'',1,1,'L',1);          
         /*******************************************/  
         
         $this->newFlowingBlock(85, 8, '', 'J' );     
         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', 'BI', 9 );
         $data = "MOTIVO:  ";
         $this->WriteFlowingBlock(utf8_decode($data));

         $this->SetY($Y);
         $this->SetX(25);           
         $this->SetFont( 'Arial', '', 9 );
         $data = '';
         $this->WriteFlowingBlock(utf8_decode($data)); 
         
         $this->SetWidths(array(5));
         $this->SetY($Y+4);
         $this->SetX(71); 
         //$this->MultiCell(3,3,'',1,1,'L',1);  
         
         $this->SetY($Y+2);
         $data = '  ';           
         $this->SetFont( 'Arial', 'B', 10 );
         $this->WriteFlowingBlock(utf8_decode($data)); 
         $Y = $this->GetY();
         $this->SetX(25); 
         $this->finishFlowingBlock();     
         
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);         
         $this->SetWidths(array(170));
         $this->SetAligns(array("L"));
         
         $this->SetY($Y+15);
         $this->SetFillColor(201, 199, 199);
         $this->SetX(25);            
         $this->Row(array(utf8_decode('INFORMACIÓN DE CLASIFICACIÓN')),1,1);
         $this->SetFillColor(255, 255, 255);
         //$this->SetWidths(array(85,85));         
         $this->SetFont('Arial','',9);
         $this->SetX(25);          
         $Y = $this->GetY();
         $this->MultiCell(170,40,'',1,1,'L',1); 

         
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);         
         $this->SetWidths(array(170));
         $this->SetAligns(array("L"));         
         $this->SetY($Y+35);
         $this->SetFillColor(201, 199, 199);
         $this->SetX(25);            
         $this->Row(array(utf8_decode('INFORMACIÓN DE ORGANIZACIÓN')),1,1);
         $this->SetFillColor(255, 255, 255);
         //$this->SetWidths(array(85,85));         
         $this->SetFont('Arial','',9);
         $this->SetX(25);          
         $Y = $this->GetY();
         $this->MultiCell(170,40,'',1,1,'L',1);  

         
         $this->SetFont('Arial','B',8);
         $this->SetFillColor(255, 255, 255);         
         $this->SetWidths(array(170));
         $this->SetAligns(array("L"));         
         $this->SetY($Y+35);
         $this->SetFillColor(201, 199, 199);
         $this->SetX(25);            
         $this->Row(array(utf8_decode('HISTORIAL DE CARGOS/SUELDOS')),1,1);
         $this->SetFillColor(255, 255, 255);
         //$this->SetWidths(array(85,85));         
         $this->SetFont('Arial','',9);
         $this->SetX(25);          
         $Y = $this->GetY();
         $this->MultiCell(170,50,'',1,1,'L',1);           

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
