<?php
include("ConexionComun.php");
require('flowing_block.php');


class PDF_Flo extends PDF_FlowingBlock
{

    function ChapterBody()
    {

        $this->datos = $this->getAyuda();
        $this->empresa = $this->getDatosEmpresa(1);
        $this->Image("imagenes/logosedezul.jpg", 88, 5, 35);


        $this->SetFont('Arial', 'B', 8);

        $this->SetTextColor(0, 0, 0);
        $this->SetY(32);
        $this->Cell(0, 0, utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('SERVICIO DESCONCENTRADO PARA LOS CENTROS ASISTENCIALES'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('DE SALUD DEL ESTADO ZULIA'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('RIF. G-200121661'), 0, 0, 'C');
        $this->Ln(4);
        $this->line(20, 50, 190, 50);
        $this->Ln(5);

        $this->SetFont('Arial', 'BI', 7);
        $this->SetX(140);
        $this->Cell(0, 0, utf8_decode('Maracaibo ') . date("d/m/Y", strtotime($this->datos['fe_resolucion'])), 0, 0, 'C');


        $this->Ln(5);
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(0, 0, utf8_decode('RESOLUCIÓN Nro.: ') . $this->datos['nu_resolucion'], 0, 0, 'L');

        $this->Ln(10);
        $this->SetFont('Arial', 'BI', 10);
       // $this->Cell(0, 0, utf8_decode('214° y 265°'), 0, 0, 'C');

        $this->Ln(1);
        $this->SetFont('Arial', 'BI', 14);
        $this->SetFillColor(255, 255, 255);
        $this->SetAligns(array("L", "L"));
        $this->SetWidths(array(200));
        $this->SetAligns(array("C"));
        $this->SetY(75);

        $this->SetX(7);
        $this->Row(array(utf8_decode('RESUELTO')), 0, 0);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial', '', 10);
        $this->Ln(8);
        $this->SetX(20);
        $this->SetLeftMargin(20);
        $this->SetRightMargin(10);

        $this->newFlowingBlock(170, 8, '', 'J');

        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $this->WriteFlowingBlock(utf8_decode('Por disposición del '));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $this->WriteFlowingBlock('CIUDADANO DR. OSWALDO OROZCO');

        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $data = ", eróguese por la Tesorería de SEDEZUL, con cargo a Unidad Ejecutora " .
            $this->datos['nu_ejecutor'] .
            ", Sector " . $this->datos['nu_sector'] .
            ", Proyecto / A.C. " . $this->datos['nu_proyecto_ac'] .
            ", Acción Específica " . $this->datos['nu_accion_especifica'] .
            ", Partida " . $this->datos['nu_pa'] .
            ", Genérica " . $this->datos['nu_ge'] .
            ", Específica " . $this->datos['nu_es'] .
            ", Subespecífica " . $this->datos['nu_se'] .
            ", de la vigente Ley de Presupuesto la cantidad de ";
        $this->SetX(20);
        $this->WriteFlowingBlock(utf8_decode($data));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $montoletras = numtoletras($this->datos['monto'], 1);
        $this->SetX(20);
        $this->WriteFlowingBlock(utf8_decode($montoletras));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 10);
        $monto = " (Bs. " . number_format($this->datos['monto'], 2, ',', '.') . ")";
        $this->SetX(20);
        $this->WriteFlowingBlock($monto);

        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $data = ", por concepto de ";
        $this->WriteFlowingBlock(utf8_decode($data));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $data = $this->datos['tx_tipo_ayuda'];
        $this->WriteFlowingBlock(utf8_decode($data));

        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $data = ", que concede el Gobierno Regional a través del ";
        $this->WriteFlowingBlock(utf8_decode($data));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $beneficiado = $this->datos['nomb_sol'];
        $this->WriteFlowingBlock(utf8_decode("DIR. GRAL de SEDEZUL"));

        /*$this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $data = utf8_decode(" a ");
        $this->WriteFlowingBlock(utf8_decode($data));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $beneficiado = $this->datos['nomb_sol'];
        $this->WriteFlowingBlock(utf8_decode($this->datos['tx_razon_social']));

        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $data = ", titular de la titular de la C.I./RIF Nro. ";
        $this->WriteFlowingBlock(utf8_decode($data));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $this->WriteFlowingBlock(utf8_decode($this->datos['inicial'].'-'.$this->datos['tx_rif']));*/

        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $data = ", como apoyo ";
        $this->WriteFlowingBlock(utf8_decode($data));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $motivo = strtoupper($this->datos['tx_observacion']);
        $this->WriteFlowingBlock(utf8_decode($motivo));

        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $data = ". Tal suma será pagada a ";
        $this->WriteFlowingBlock(utf8_decode($data));


        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $receptor = $this->datos['proveedor'];
        ;
        $this->WriteFlowingBlock(utf8_decode($receptor));


        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $receptor = " C.I./RIF ";
        $this->WriteFlowingBlock(utf8_decode($receptor));

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $receptor = $this->datos['inicia_proveedor'] . "-" . $this->datos['rif_proveedor'];
        $this->WriteFlowingBlock(utf8_decode($receptor));


        $this->SetX(20);
        $this->SetFont('Arial', '', 9);
        $data = ", para los fines antes indicados. En tal sentido  se otorgará con cargos a la partida antes mencionada";
        $this->WriteFlowingBlock(utf8_decode($data));


        $this->SetX(20);
        $this->finishFlowingBlock();

        $this->Ln(20);
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(20);
        $this->Cell(0, 0, utf8_decode('Regístrese y Comuníquese'), 0, 0, 'L');
        $this->Ln(20);
        $this->Cell(0, 0, utf8_decode($this->empresa['nb_presidente']), 0, 0, 'C');
        $this->SetFont('Arial', 'B', 8);
        $this->Ln(5);
        $this->SetX(25);
        $this->Cell(0, 0, utf8_decode('DIRECTOR GENERAL DE(L) ' . $this->empresa['nb_institucion']), 0, 0, 'C');
        $this->SetFont('Arial', '', 8);
        $this->Ln(4);
        $this->SetX(25);
        $this->Cell(0, 0, utf8_decode('Gaceta oficial extraordinaria del Estado Zulia N° 2966 de fecha 26 de Enero de 2022.'), 0, 0, 'C');
        /*$this->Ln(20);
        $this->SetX(20);
        $this->Cell(0, 0, utf8_decode('LA SECRETARIA DE ADMINISTRACIÓN Y FINANZAS'), 0, 0, 'L');
        $this->Ln(5);
        $this->SetX(20);
        $this->Cell(0, 0, utf8_decode('L.S.(FDO.) LCDA. RAISA BRICEÑO'), 0, 0, 'L');

        $this->Ln(50);
        $this->SetX(20);
        $this->Cell(0, 0, utf8_decode('Usuario del sistema: ' . $this->datos['nb_usuario']), 0, 0, 'L');*/

      

        


    }

    function HeaderCertificado() {

        $this->empresa = $this->getDatosEmpresa(1);

        $this->Image("imagenes/logosedezul.jpg", 88, 5, 35);


        $this->SetFont('Arial', 'B', 8);

        $this->SetTextColor(0, 0, 0);
        $this->SetY(32);
        $this->Cell(0, 0, utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('GOBERNACIÓN DEL ESTADO ZULIA'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('SERVICIO DESCONCENTRADO PARA LOS CENTROS ASISTENCIALES'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('DE SALUD DEL ESTADO ZULIA'), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, utf8_decode('RIF. G-200121661'), 0, 0, 'C');
        $this->Ln(4);
        $this->line(20, 50, 190, 50);
        $this->Ln(5);

     

    }

    function getOpcionReporte( $ruta){
        
        $sql = "SELECT tb030.co_ruta, op_reporte,
        op_reporte->>'cargo_firma' as cargo_firma,
        op_reporte->>'ciudadano' as ciudadano
        FROM tb030_ruta as tb030
        INNER JOIN tb032_configuracion_ruta AS tb032 ON tb030.co_tipo_solicitud = tb032.co_tipo_solicitud AND tb030.co_proceso = tb032.co_proceso
        WHERE tb030.co_ruta = ".$ruta;
     
        //echo $sql; exit();

        $conex = new ConexionComun(); 

        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return  $datosSol[0];                          
       
    }

    function getOrden(){

        $conex = new ConexionComun(); 
                      
            $sql = "select tb052.monto_total as monto, tb052.tx_observacion,                         
                           upper(tb047.nb_responsable) as nb_responsable, 
                           upper(tb047.cargo) as cargo ,to_char(tb026.fe_registro,'dd') as dia,to_char(tb026.fe_registro,'mm') as mes,to_char(tb026.fe_registro,'yyyy') as anio
                    from   tb052_compras as tb052 
                    left join tb026_solicitud as tb026 on tb026.co_solicitud = tb052.co_solicitud
                    left join tb030_ruta as tb030 on tb030.co_solicitud = tb026.co_solicitud and tb030.in_cargar_dato is true
                    left join tb001_usuario as tb001 on tb001.co_usuario = tb030.co_usuario
                    left join tb047_ente as tb047 on tb047.co_ente = 8
                    where tb030.co_ruta = ".$_GET['codigo']; 
                    
           
            $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
            return  $datosSol[0];     
                         
             
            
    
    }

    function ChapterBodyCertificado() {

        $this->op_reporte = $this->getOpcionReporte($_GET['codigo']);
        $this->empresa = $this->getDatosEmpresa(1);

         $this->Ln(15);

         $this->datos = $this->getOrden();
            $this->SetFont('Arial','B',10);
         $this->Cell(0,0,utf8_decode('Maracaibo, '.$this->datos['dia'].' de '.mes($this->datos['mes']).' del '.$this->datos['anio']),0,0,'R');
//         $this->Cell(0,0,utf8_decode('Maracaibo, '.date("d").' de '.mes(date("m")).' del '.date("Y")),0,0,'R');
         
         $this->SetFont('Arial','',10);
         $this->Ln(15);
         $this->SetX(25);
//         $this->Cell(0,0,utf8_decode('Señor(a):'),0,0,'L');
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode($this->datos['nb_responsable']),0,0,'L');
         $this->SetFont('Arial','B',8);
         $this->Ln(5);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode($this->datos['cargo']),0,0,'L');
         $this->SetFont('Arial','',8);
         $this->Ln(4);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode('Su Despacho.'),0,0,'L');
         
         $this->SetFont('Arial','',10);
         $this->Ln(10);
         $this->SetX(35);
         $this->Cell(10,0,utf8_decode('Reciba un cordial y respetuoso saludo.'),0,0,'L');
         
         $this->SetFont('Arial','',10);
         $this->Ln(10);
         $this->SetWidths(array(170));
         $this->SetAligns(array("J"));
         $this->SetX(25);
         $this->Row(array(utf8_decode('     La presente tiene la finalidad de solicitarle la disponibilidad presupuestaria para la ejecución del proceso de: '.$this->datos['tx_observacion']).'.'), 0, 0);
  
        $this->Ln(31);         
        
             $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->Cell(200,10,utf8_decode('Atentamente.'),0,0,'C');         
         $this->ln(10);
         
         $this->SetFont('Arial','B',10);
         $this->Ln(5);

         $this->Cell(200,10,utf8_decode('COORDINACIÓN DE CONTRATACIONES'),0,0,'C');    

         $this->AddPage();
         $this->HeaderCertificado();
         $this->Ln(15);
         
        $this->Cell(0,0,utf8_decode('Maracaibo, '.$this->datos['dia'].' de '.mes($this->datos['mes']).' del '.$this->datos['anio']),0,0,'R');
        $this->Ln(15);
        $this->SetFont('Arial','B',12);
         $this->Cell(0, 0, utf8_decode('CERTIFICACIÓN'), 0, 0, 'C');
//         $this->Ln(5);
//         $this->SetFont('Arial','B',10);
//         $this->Cell(0, 0, utf8_decode($this->datos['numero_cotizacion']), 0, 0, 'C');
//         $this->Ln(10);         
         
         $this->SetFont('Arial','',10);
         $this->Ln(5);
         $this->SetX(25);
//         $this->Cell(0,0,utf8_decode('Sres:'),0,0,'L');
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->SetX(25);
             $this->Cell(0,0,utf8_decode('COORDINACIÓN DE CONTRATACIONES'),0,0,'L');   

         $this->SetFont('Arial','',8);
         $this->Ln(4);
         $this->SetX(25);
         $this->Cell(0,0,utf8_decode('Su Despacho.'),0,0,'L');

         
         $this->SetY(110);  
         $this->SetX(20);
         $this->SetFont('Arial','',10);
         $montoletra = numtoletras($this->datos['monto'], 1);
         $montonum = number_format($this->datos['monto'], 2, ',','.');
         
         $html='     Por medio de la presente, se informa que en el presupuesto de egreso se encuentra contemplado el código presupuestario que se describe a continuación: ';

         $this->SetX(25);
         $this->MultiCell(170,5,utf8_decode($html),0,1,'J',1);                                                              
                          
                 
         $this->Ln();
         $this->SetFillColor(255, 255, 255); 
         $this->SetFont('Arial','B',8); 
         $this->SetAligns(array("C","C","C","C"));
         $this->SetWidths(array(55,55,30,30));
         $this->SetX(25); 
         $this->Row(array('CODIGO PRESUPUESTARIO','DENOMINACION','FUENTE FINANCIAMIENTO','MONTO (Bs.) DISPONIBLE TOTAL'),1,1);
         $this->SetAligns(array("C","C","C","C"));         
         $this->SetFont('Arial','',8);
         $this->lista_partidas = $this->getPartidas();
         foreach($this->lista_partidas as $key => $campo){  
             
                            if($this->getY()>240){
                     $this->AddPage();
                     $this->Ln(20);
                     $this->SetFillColor(255, 255, 255); 
                     $this->SetFont('Arial','',8); 
                     $this->SetAligns(array("C","C","C","C"));
                     $this->SetWidths(array(55,55,30,30));
                     $this->SetX(25); 
                     $this->Row(array('CODIGO PRESUPUESTARIO','DENOMINACION','FUENTE FINANCIAMIENTO','MONTO (Bs.) DISPONIBLE TOTAL'),1,1);
         
                            }             
             $prueba = utf8_decode($campo['de_partida']);
                            
          $this->SetX(25);   
          $this->SetWidths(array(55,55,30,30));
          $this->SetAligns(array("C","C","C","C"));
          $this->Row(array(utf8_decode($campo['co_categoria']),$prueba,utf8_decode($campo['tx_descripcion']),number_format($campo['monto'], 2, ',','.')),1,1);
          
         }
         
         
         
         $this->ln();
         $this->SetX(20); 
         $this->SetWidths(array(170));
         $this->SetAligns(array("L"));  
         $this->SetFont('Arial','',10); 
         $this->Cell(170,5,utf8_decode('Sin más a que hacer referencia, me despido de usted.'),0,0,'L');         
         $this->ln(15);
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->Cell(200,10,utf8_decode('Atentamente.'),0,0,'C');         
         $this->ln(10);
         
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->Cell(200,10,utf8_decode($this->datos['nb_responsable']),0,0,'C'); 
         $this->SetFont('Arial','B',10);
         $this->Ln(5);
         $this->Cell(200,10,utf8_decode($this->datos['cargo']),0,0,'C');  
         

    }

    function getPartidas()
    {
                    
          $conex = new ConexionComun(); 
                    
          $sql = "select substring(tb085.co_categoria,1,100) as co_categoria,
                         tb085.de_partida,
                         tb209.monto,
                         tb140.tx_descripcion
                  from   tb052_compras as tb052 
                   left join tb053_detalle_compras as tb053 on tb052.co_compras = tb053.co_compras
				   left join tb209_presupuesto_detalle_compra as tb209 on tb209.co_detalle_compra = tb053.co_detalle_compras				  
                  left join tb085_presupuesto as tb085 on tb085.id = tb209.co_presupuesto
                  left join tb030_ruta as tb030 on tb030.co_solicitud = tb052.co_solicitud and tb030.in_cargar_dato is true
                  left join tb140_tipo_ingreso as tb140 on tb140.co_tipo_ingreso = tb085.tip_ing::numeric
                  where tb030.co_ruta =  ". $_GET['codigo']."
                  order by co_categoria asc"; //$conex->decrypt($_GET['codigo']);
                  
          $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
          return  $datosSol;  
		  
    }


    function getAyuda()
    {

        $conex = new ConexionComun();

        $sql = "SELECT tb082.nu_ejecutor, 
                        tb080.nu_sector, 
                        tb083.nu_proyecto_ac,
                        tb084.nu_accion_especifica, 	   
                        tb085.nu_pa, 
                        tb085.nu_ge, 
                        tb085.nu_es, 
                        tb085.nu_se, 
                        tb085.nu_sse, 
                        tb053.monto, 
                        tb008.tx_razon_social,
                        tb008.tx_rif,
                        tb007.inicial,
                        tb126.tx_observacion,
                        tb008p.tx_razon_social as proveedor,
                        tb008p.tx_rif as rif_proveedor,
                        tb007p.inicial as inicia_proveedor,
                        tb126.nu_resolucion,
	                    tb127.tx_tipo_ayuda,
                        fe_resolucion
                    FROM public.tb030_ruta as tb030 
                        left join tb052_compras as tb052 on (tb030.co_solicitud = tb052.co_solicitud)
                        join tb053_detalle_compras as tb053 on (tb053.co_compras = tb052.co_compras)
						 join tb209_presupuesto_detalle_compra as tb209 on (tb053.co_detalle_compras = tb209.co_detalle_compra)
                        left join tb085_presupuesto as tb085 on (tb085.id = tb209.co_presupuesto)
                        left join tb084_accion_especifica as tb084 on (tb085.id_tb084_accion_especifica = tb084.id)
                        left join tb083_proyecto_ac as tb083 on (tb084.id_tb083_proyecto_ac = tb083.id)
                        left join tb082_ejecutor as tb082 on (tb082.id = tb083.id_tb082_ejecutor)
                        left join tb080_sector as tb080 on (tb080.id = tb083.id_tb080_sector)
                        left join tb026_solicitud as tb026 on (tb026.co_solicitud = tb030.co_solicitud)
                        left join tb126_solicitud_ayuda as tb126 on (tb026.co_solicitud_ayuda = tb126.co_solicitud_ayuda)
                        left join tb127_tipo_ayuda as tb127 on (tb127.co_tipo_ayuda = tb126.co_tipo_ayuda)
                        left join tb008_proveedor as tb008 on (tb008.co_proveedor = tb126.co_proveedor_solicitante)
                        left join tb007_documento as tb007 on (tb007.co_documento = tb008.co_documento)
                        left join tb008_proveedor as tb008p on (tb008p.co_proveedor = tb026.co_proveedor)
                        left join tb007_documento as tb007p on (tb007p.co_documento = tb008p.co_documento)
                    where tb030.co_ruta = " . $_GET['codigo']; //$conex->decrypt($_GET['codigo']);

        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return $datosSol[0];
    }

    function getDatosEmpresa($codigo)
    {

        $sql = "SELECT co_empresa, nb_empresa, co_estado, co_municipio, tx_rif, tx_nit, nb_institucion, nb_presidente,
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
        WHERE co_empresa = " . $codigo . ";";

        $conex = new ConexionComun();
        $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
        return $datosSol[0];

    }


}



$pdf = new PDF_Flo('P', 'mm', 'letter');
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->ChapterBody();
$pdf->AddPage();
$pdf->HeaderCertificado();
$pdf->ChapterBodyCertificado();
//$pdf->Output();


$comm = new ConexionComun();
$ruta = $comm->getRuta();
//rmdir($ruta);
//mkdir($ruta, 0777, true);    

$dir = "$ruta" . $_GET["codigo"] . ".pdf"; //$comm->decrypt($_GET["codigo"]).".pdf";

$update = "update tb030_ruta set tx_ruta_reporte = '" . $dir . "' where co_ruta = " . $_GET['codigo']; //$comm->decrypt($_GET["codigo"]);


$comm->Execute($update);
$pdf->SetMargins(0, 0);
$pdf->Output($dir, 'F');



?>