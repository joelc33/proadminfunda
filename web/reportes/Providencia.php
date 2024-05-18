<?php
include("ConexionComun.php");
include('fpdf.php');


class PDF extends FPDF {
    public $title;
    public $conexion;
    public $array_factura;
    public $array_factura_banco;
    function Header() {

          encabezado_providencia($this,$h='v');
        $this->Ln(4);

    }
    function dwawCell($title,$data) {
        $width = 8;
        $this->SetFont('Arial','B',12);
        $y =  $this->getY() * 10;
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
        $this->DatosProvidencia();
        
     if ($this->datos[0]['co_tipo']==1){
	$this->SetFont('Arial','B',12);	 
	$this->Cell(0,0,utf8_decode('PROVIDENCIA ADMINISTRATIVA N° UF-SF-ZL-PA-DF-2016-'.$this->datos[0]['nu_providencia']),0,0,'C',0);
        $this->Ln(7);	 
    $this->DeberesFormales();
        }else{
			$this->SetFont('Arial','B',12);
        $this->Cell(0,0,utf8_decode('PROVIDENCIA ADMINISTRATIVA N° UF-SF-ZL-PA-2016-'.$this->datos[0]['nu_providencia']),0,0,'C',0);
         $this->Ln(7);
    $this->Fiscalizacion();
			}
               
    }
    
        function DeberesFormales() {
			
  $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
  $dia = date("j");
  $dia2=date("w");
  $mes = date(n)-1;
  $ano = date("Y"); 
$fecha = $dia. " de ".$meses[$mes]." del ".$ano;
$fecha2 = $dia. " días del mes de ".$meses[$mes]." del Dos Mil Catorce (".$ano.")";		
			
			
	$this->SetFont('Arial','',10);
	$this->MultiCell(190,5,utf8_decode('Quien suscribe, T.S.U LEONARDO LEVI LOPEZ, venezolano, mayor de edad, portador de la cédula de identidad Nº V- 11.297.405, de este domicilio, actuando en mi carácter de INTENDENTE TRIBUTARIO MUNICIPAL, del Servicio Desconcentrado Bolivariano de Administración Tributaria (SEDEBAT), según Resolución N° ABR-1027-2014 de fecha veintiuno (21) de Febrero de 2014; en uso de las atribuciones legales que me confieren lo establecido en el artículo 17 del Decreto Nº 31 Emitido por el Ciudadano Alcalde del Municipio San Francisco Econ. Omar José Prieto Fernandez, Publicado en Gaceta Municipal N° 254 de fecha Doce (12) de Noviembre de 2009; el artículo 50 de la Ordenanza sobre Administración Tributaria Municipal del Municipio San Francisco del Estado Zulia, Publicado en Gaceta Municipal N° 259 de fecha Once (11) de Diciembre de 2009. '),0,'J');
	$this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('Por medio de la presente Providencia AUTORIZO amplia y suficientemente al auditor fiscal '.$this->datos[0]['nombre'].' venezolano, mayor de edad, domiciliado en este Municipio San Francisco del Estado Zulia, titular de la cédula de identidad V- '.$this->datos[0]['cedula'].', adscrit(a) al SERVICIO DESCONCENTRADO BOLIVARIANO DE ADMINISTRACIÓN TRIBUTARIA (SEDEBAT) del Municipio San Francisco del Estado Zulia, según Resolución Nº ABR-'.$this->datos[0]['resolucion'].'-2014 de fecha primero (01) de Febrero de 2014, para iniciar el Procedimiento de Verificación de Deberes Formales de Impuestos Municipales a la Contribuyente '.$this->datos[0]['nb_contribuyente'].', con establecimiento permanente en el Municipio San Francisco, aplicable razone temporis la Ordenanza sobre Administración Tributaria Municipal del Municipio San Francisco del Estado Zulia (Gaceta Municipal Nº 259 de fecha 11-12-2009).'),0,'J');
		$this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('Todo ello de conformidad con lo establecido en el Artículo 56º de la Ordenanza sobre Administración Tributaria Municipal del Municipio San Francisco del Estado Zulia (Gaceta Municipal Nº 259 de fecha 11-12-2009).'),0,'J');
		$this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('El presente Procedimiento de Verificación de Deberes Formales se iniciara el día '.$this->datos[0]['fe_fiscalizacion'].' en cuya oportunidad deberá presentar de forma inmediata la información requerida.'),0,'J');
			$this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('Acompaña a la presente PROVIDENCIA la correspondiente Acta de Requerimiento, la cual firmara y sellara en calidad de recibido.'),0,'J');
				$this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('Dado, firmado y sellado en el Despacho del Intendente Tributario Municipal, en San Francisco del Estado Zulia, a los '.$fecha2.', año 204º de la Independencia y 155º de la Federación.'),0,'J');
		$this->Ln(5);
	$this->SetFont('Arial','B',12);
	$this->Cell(0,0,utf8_decode('T.S.U. LEONARDO LEVI LOPEZ'),0,0,'C');
	
	$this->Ln(5);
	$this->SetFont('Arial','B',10);
	$this->Cell(0,0,utf8_decode('INTENDENTE TRIBUTARIO MUNICIPAL'),0,0,'C');
	$this->Ln(5);
	$this->Cell(0,0,utf8_decode('Según Resolución N° ABR-1027-2014 DEL 21/02/2014'),0,0,'C');
    $this->Ln(10);
	$this->MultiCell(190,5,utf8_decode('DATOS DEL CONTRIBUYENTE NOTIFICADO. (Constancia de Recibo)'),0,'J');
    $this->SetFont('Arial','',10);
    $this->Ln(5);
	$this->MultiCell(190,5,utf8_decode('Nombre y Apellido:________________________    Telefono:_________________   e-mail:____________________'),0,'J');
	    $this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('Cargo en la Empresa:______________________   Fecha:____________________  Hora:______________________'),0,'J');
	
    	    $this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('Cedula de Identidad:______________________     Firma:____________________   Sello:_____________________'),0,'J');
		    $this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('Direccion Exacta:________________________________________________________________________________'),0,'J');
	  
	$this->AddPage();
	$this->SetFont('Arial','B',12);
	$this->Cell(0,0,utf8_decode('ACTA DE REQUERIMIENTO N° SEDEBAT-SF-ZL-PA-DF-AR-2014-'.$this->datos[0]['nu_providencia']),0,0,'C',0);  
	$this->Ln(4);
	$this->SetFont('Arial','',10);
	$this->MultiCell(190,5,utf8_decode('CONTRIBUYENTE: '.$this->datos[0]['nb_contribuyente']),0,'J');
	$this->Ln(2); 
	if($this->datos[0]['nu_referencia']==''){
    $this->MultiCell(190,5,utf8_decode('REGISTRO DE INFORMACION FISCAL: '.$this->datos[0]['tx_tp_doc'].'-'.$this->datos[0]['rif_cedula']),0,'J');	
		}else{
	$this->MultiCell(190,5,utf8_decode('REFERENCIA: '.$this->datos[0]['nu_referencia'].' REGISTRO DE INFORMACION FISCAL: '.$this->datos[0]['tx_tp_doc'].'-'.$this->datos[0]['rif_cedula']),0,'J');
     }
	$this->Ln(2);  
	$this->MultiCell(190,5,utf8_decode('DIRECCION FISCAL: '.$this->datos[0]['tx_direccion']),0,'J');
	 
	$this->Ln(3);
	$this->MultiCell(190,5,utf8_decode('En San Francisco a los '.$fecha2.', conforme a lo dispuesto en el artículo 56 de la Ordenanza sobre Administración Tributaria Municipal del Municipio San Francisco del Estado Zulia (Gaceta Municipal Extraordinaria  No.259 del 11-12-2009), al funcionario '.$this->datos[0]['nombre'].', titular de la cédula de identidad V- '.$this->datos[0]['cedula'].', adscrit(a) al Servicio Desconcentrado Bolivariano de Administración Tributaria (SEDEBAT), de la Alcaldía del Municipio San Francisco del Estado Zulia, debidamente autorizada según Providencia  No SEDEBAT-SF-ZL-PA-DF-2014-'.$this->datos[0]['nu_providencia'].' de fecha '.$this->datos[0]['fe_fiscalizacion'].' se procede a dejar constancia de la solicitud de información documental referida a la verificación de deberes formales de impuestos municipales, señalada a continuación:'),0,'J'); 
	$this->SetFont('Arial','B',10); 
	$this->MultiCell(190,5,utf8_decode('Copia del:'),0,'J');
	
	     $this->SetWidths(array(85,10,85,10));
         $this->SetAligns(array("L","L","L","L"));
         $this->SetFillColor(255, 255, 255);
         $this->Ln(4);
         $this->SetTextColor(0,0,0);
         $this->SetFont('Arial','',10);
         $this->Row(array(utf8_decode("1. Registro de Información Fiscal de la Empresa (vigente)."),"          ",utf8_decode("8. Documento de Propiedad del Inmueble o Contrato de Arrendamiento."),"          "),1);
         $this->Row(array(utf8_decode("2. Acta Constitutiva y sus Asambleas.                              "),"          ",utf8_decode("9. Licencia de Licores y pagos de Renovación en caso de que aplique."),"          "),1);
         $this->Row(array(utf8_decode("3. Registro de Información Fiscal de los Socios y Cedula de Identidad."),"          ",utf8_decode("10. Solvencia del Cuerpo de Bomberos.                              "),"          "),1);
         $this->Row(array(utf8_decode("4. Inscripción en el Servicio Desconcentrado Bolivariano de Administración Tributaria."),"          ",utf8_decode("11. Ultima Revisión Fiscal realizada por esta Intendencia."),"          "),1);
         $this->Row(array(utf8_decode("5. Declaraciones definitivas, anticipadas de Ingresos Brutos, Municipio de San Francisco."),"          ","                                                                                             ","          "),1);
         $this->Row(array(utf8_decode("6. Declaración de Propaganda y Publicidad."),"","",""),1);
         $this->Row(array(utf8_decode("7. Solvencia de Inmuebles."),"","",""),1);
	      $this->Ln(2);  
	      $this->MultiCell(190,5,utf8_decode('Se concede un plazo de DOS (02) días hábiles contados a partir de la fecha de notificación de la presente acta para consignar la documentación requerida, TODA LA DOCUMENTACION DEBE SER SELLADA Y FIRMADA POR EL CONTRIBUYENTE.'),0,'J');
   	      $this->Ln(2);  
	      $this->MultiCell(190,5,utf8_decode('Se hace del conocimiento de la contribuyente que de conformidad con lo dispuesto en los artículo 20 y 68 de la Ordenanza sobre Administración Tributaria Municipal del Municipio San Francisco del Estado Zulia (Gaceta Municipal Extraordinaria  No.259 del 11-12-2009). '),0,'J');
     	      $this->Ln(2);  
	      $this->MultiCell(190,5,utf8_decode('A los fines legales consiguientes, se emite la presente Acta en tres (3) ejemplares de un mismo tenor y a un solo efecto, uno (1) de los cuales queda en poder del contribuyente o responsable, quien firma en señal de notificación.'),0,'J');
       	      $this->Ln(2);  
   $this->SetFont('Arial','B',10);
   	$this->MultiCell(190,5,utf8_decode('AUDITOR FISCAL                                                            CONTRIBUYENTE'),0,'J');
	    $this->Ln(2);
	    $this->SetFont('Arial','',10);
	$this->MultiCell(190,5,utf8_decode('NOMBRE Y APELLIDO:________________________   NOMBRE Y APELLIDO:________________________'),0,'J');
	
    	    $this->Ln(2);
	$this->MultiCell(190,5,utf8_decode('CEDULA DE IDENTIDAD:______________________    CEDULA DE IDENTIDAD:______________________ '),0,'J');
		    $this->Ln(2);
	$this->MultiCell(190,5,utf8_decode('FECHA:_____________________________________   FECHA:_____________________________________'),0,'J');
	
   		    $this->Ln(2);
	$this->MultiCell(190,5,utf8_decode('HORA:______________________________________   HORA:______________________________________'),0,'J');
	
     $this->AddPage();
   	$this->SetFont('Arial','B',12);
	$this->Cell(0,0,utf8_decode('ACTA DE RECEPCION N° SEDEBAT-SF-ZL-PA-DF-ARE-2014-'.$this->datos[0]['nu_providencia']),0,0,'C',0);  
	$this->Ln(15);
	$this->SetFont('Arial','',10);
	$this->MultiCell(190,5,utf8_decode('El Servicio Desconcentrado Bolivariano de Administración Tributaria (SEDEBAT), del Municipio San Francisco del Estado Zulia, en uso de las atribuciones y facultades conferidas por la Ley, por medio de la presente Acta procede a recibir la documentación requerida de conformidad con lo dispuesto en el artículo 94 de la Ordenanza sobre Administración Tributaria Municipal del Municipio San Francisco del Estado Zulia (Gaceta Municipal Extraordinaria  No.259 del 11-12-2009), que se especifica a continuación:'),0,'J'); 
	$this->Ln(4);
	$this->SetFont('Arial','B',10); 
	$this->MultiCell(190,5,utf8_decode('Copia del:'),0,'J');
	
	     $this->SetWidths(array(85,10,85,10));
         $this->SetAligns(array("L","L","L","L"));
         $this->SetFillColor(255, 255, 255);
         $this->Ln(4);
         $this->SetTextColor(0,0,0);
         $this->SetFont('Arial','',10);
         $this->Row(array(utf8_decode("1. Registro de Información Fiscal de la Empresa (vigente)."),"          ",utf8_decode("8. Documento de Propiedad del Inmueble o Contrato de Arrendamiento."),"          "),1);
         $this->Row(array(utf8_decode("2. Acta Constitutiva y sus Asambleas.                              "),"          ",utf8_decode("9. Licencia de Licores y pagos de Renovación en caso de que aplique."),"          "),1);
         $this->Row(array(utf8_decode("3. Registro de Información Fiscal de los Socios y Cedula de Identidad."),"          ",utf8_decode("10. Solvencia del Cuerpo de Bomberos.                              "),"          "),1);
         $this->Row(array(utf8_decode("4. Inscripción en el Servicio Desconcentrado Bolivariano de Administración Tributaria."),"          ",utf8_decode("11. Ultima Revisión Fiscal realizada por esta Intendencia."),"          "),1);
         $this->Row(array(utf8_decode("5. Declaraciones definitivas, anticipadas de Ingresos Brutos, Municipio de San Francisco."),"          ","                                                                                        ","          "),1);
         $this->Row(array(utf8_decode("6. Declaración de Propaganda y Publicidad."),"","",""),1);
         $this->Row(array(utf8_decode("7. Solvencia de Inmuebles."),"","",""),1);
	      $this->Ln(10);  

   $this->SetFont('Arial','B',10);
   	$this->MultiCell(190,5,utf8_decode('AUDITOR FISCAL                                                            CONTRIBUYENTE'),0,'J');
	    $this->Ln(4);
	    $this->SetFont('Arial','',10);
	$this->MultiCell(190,5,utf8_decode('NOMBRE Y APELLIDO:________________________   NOMBRE Y APELLIDO:________________________'),0,'J');
	
    	    $this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('CEDULA DE IDENTIDAD:______________________    CEDULA DE IDENTIDAD:______________________ '),0,'J');
		    $this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('FECHA:_____________________________________   FECHA:_____________________________________'),0,'J');
	
   		    $this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('HORA:______________________________________   HORA:______________________________________'),0,'J');
	
	   		    $this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('TELEFONO:__________________________________   TELEFONO:__________________________________'),0,'J');
	
   
    }
   

        function Fiscalizacion() {
			
			
  $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
  $dia = date("j");
  $dia2=date("w");
  $mes = date(n)-1;
  $ano = date("Y"); 
$fecha = $dia. " de ".$meses[$mes]." del ".$ano;
$fecha2 = " ____ días del mes de __________ del(______)";		
				
	$this->SetFont('Arial','',9);
	$this->MultiCell(0,5,utf8_decode('Quien suscribe, ABG. KATHERINE TORO, venezolana, mayor de edad, portador de la cédula de identidad Nº V- 19.811.907, de este domicilio, actuando en mi carácter de DIRECTORA DE FISCALIZACION, de la Alcaldía del Municipio San Francisco, según Resolución N° ABR-1247-2014 de fecha Ocho (08) de Diciembre de 2014; en uso de las atribuciones legales que me confieren lo establecido en el artículo 54, numerales 1,2 y 4 de Ordenanza sobre Administración Tributaria del Municipio San Francisco del Estado Zulia, Emitido por el Ciudadano Alcalde del Municipio San Francisco Econ. Omar José Prieto Fernandez; en concordancia con el artículo 131 del Código Orgánico Tributario vigente. '),0,'J');
	$this->Ln(2);
        if($this->datos[0]['anio_inicio']>=2014){
        $this->MultiCell(0,5,utf8_decode('Por medio de la presente Providencia AUTORIZO amplia y suficientemente al auditor fiscal '.$this->datos[0]['nombre'].' venezolano, mayor de edad, domiciliado en este Municipio San Francisco del Estado Zulia, titular de la cédula de identidad V- '.$this->datos[0]['cedula'].', adscrito(a) a la  Unidad de Fiscalización del Municipio San Francisco del Estado Zulia, según Resolución de Nombramiento de fecha '.$this->datos[0]['fe_nombramiento'].', para iniciar el Procedimiento de Fiscalización y Determinación Tributaria del Impuesto Sobre Actividades Económicas a la Contribuyente '.$this->datos[0]['nb_contribuyente'].', autorizado según la Reforma Parcial de la Ordenanza que Crea y Regula el Impuesto sobre Actividades Economicas del Municipio San Francisco N° 361 de fecha 30/12/2014, con establecimiento permanente en el Municipio San Francisco, para los períodos fiscales comprendidos del '.$this->datos[0]['fe_fiscalizacion_inicio'].' al '.$this->datos[0]['fe_fiscalizacion_fin'].', aplicable razone temporis la Reforma Parcial de la Ordenanza de Reforma Total de la Ordenanza que crea y regula el Impuesto sobre Actividades Económicas del Municipio San Francisco del Estado Zulia Gaceta Municipal Extraordinaria N° 329 de fecha 30 de Diciembre de 2013. Para el Impuesto sobre Inmuebles Urbanos del Municipio San Francisco Estado Zulia, aplicable razone temporis la Ordenanza de Inmuebles Urbanos publicada en gaceta N° 160, de fecha 26/12/2015, y la Ordenanza de Inmuebles Urbanos publicada en gaceta N° 338, de fecha 16/05/2014, asi mismo, la Ordenanza que crea y regula el Impuesto sobre Publicidad y Propaganda comercial del Municipio San Francisco del Estado Zulia, publicada en gaceta N° 328 de fecha 30/12/2013.'),0,'J');
	$this->Ln(2);    
        }else{
        if($this->datos[0]['anio_inicio']>=2012){
        $this->MultiCell(0,5,utf8_decode('Por medio de la presente Providencia AUTORIZO amplia y suficientemente al auditor fiscal '.$this->datos[0]['nombre'].' venezolano, mayor de edad, domiciliado en este Municipio San Francisco del Estado Zulia, titular de la cédula de identidad V- '.$this->datos[0]['cedula'].', adscrito(a) a la  Unidad de Fiscalización del Municipio San Francisco del Estado Zulia, según Resolución de Nombramiento de fecha '.$this->datos[0]['fe_nombramiento'].', para iniciar el Procedimiento de Fiscalización y Determinación Tributaria del Impuesto Sobre Actividades Económicas a la Contribuyente '.$this->datos[0]['nb_contribuyente'].',  autorizado según la Reforma Parcial de la Ordenanza que Crea y Regula el Impuesto sobre Actividades Economicas del Municipio San Francisco N° 361 de fecha 30/12/2014, con establecimiento permanente en el Municipio San Francisco, para los períodos fiscales comprendidos del '.$this->datos[0]['fe_fiscalizacion_inicio'].' hasta 31/12/2013, aplicable razone temporis la Reforma Parcial de la Ordenanza de Reforma Total de la Ordenanza que crea y regula el Impuesto sobre Actividades Económicas del Municipio San Francisco del Estado Zulia Gaceta Municipal Extraordinaria N° 297 de fecha 23 de Diciembre de 2011 y para el periodo fiscal comprendido entre el 01/01/2014 hasta el 31/12/2014 la Reforma Parcial de la Ordenanza de Reforma Total de la Ordenanza que Crea y Regula el Impuesto sobre Actividades Económicas del Municipio San Francisco del Estado Zulia N° 329 de fecha 30 de Diciembre de 2013. Para el Impuesto sobre Inmuebles Urbanos del Municipio San Francisco Estado Zulia, aplicable razone temporis la Ordenanza de Inmuebles Urbanos publicada en gaceta N° 160, de fecha 26/12/2015, y la Ordenanza de Inmuebles Urbanos publicada en gaceta N° 338, de fecha 16/05/2014, asi mismo, la Ordenanza que crea y regula el Impuesto sobre Publicidad y Propaganda comercial del Municipio San Francisco del Estado Zulia, publicada en gaceta N° 328 de fecha 30/12/2013.'),0,'J');
	$this->Ln(2);    
        }else{
        if($this->datos[0]['anio_inicio']>=2010){
        $this->MultiCell(0,5,utf8_decode('Por medio de la presente Providencia AUTORIZO amplia y suficientemente al auditor fiscal '.$this->datos[0]['nombre'].' venezolano, mayor de edad, domiciliado en este Municipio San Francisco del Estado Zulia, titular de la cédula de identidad V- '.$this->datos[0]['cedula'].', adscrito(a) a la  Unidad de Fiscalización del Municipio San Francisco del Estado Zulia, según Resolución de Nombramiento de fecha '.$this->datos[0]['fe_nombramiento'].', para iniciar el Procedimiento de Fiscalización y Determinación Tributaria del Impuesto Sobre Actividades Económicas a la Contribuyente '.$this->datos[0]['nb_contribuyente'].',  autorizado según la Reforma Parcial de la Ordenanza que Crea y Regula el Impuesto sobre Actividades Economicas del Municipio San Francisco N° 361 de fecha 30/12/2014, con establecimiento permanente en el Municipio San Francisco, para los períodos fiscales comprendidos del '.$this->datos[0]['fe_fiscalizacion_inicio'].' hasta 31/12/2011, aplicable razone temporis la Ordenanza de Reforma Total de la Ordenanza que crea y regula el impuesto sobre Actividades Económicas del Municipio San Francisco del Estado Zulia Gaceta Municipal Extraordinaria Nº 258 de fecha 11 de Diciembre de 2009;  para el periodo fiscal comprendido entre el 01/01/2012 hasta el 31/12/2013, la Reforma Parcial de la Ordenanza de Reforma Total de la Ordenanza que crea y regula el Impuesto sobre Actividades Económicas del Municipio San Francisco del Estado Zulia Gaceta Municipal Extraordinaria N° 297 de fecha 23 de Diciembre de 2011 y para el periodo fiscal comprendido entre el 01/01/2014 hasta el 31/12/2014 la Reforma Parcial de la Ordenanza de Reforma Total de la Ordenanza que Crea y Regula el Impuesto sobre Actividades Económicas del Municipio San Francisco del Estado Zulia N° 329 de fecha 30 de Diciembre de 2013. Para el Impuesto sobre Inmuebles Urbanos del Municipio San Francisco Estado Zulia, aplicable razone temporis la Ordenanza de Inmuebles Urbanos publicada en gaceta N° 160, de fecha 26/12/2015, y la Ordenanza de Inmuebles Urbanos publicada en gaceta N° 338, de fecha 16/05/2014, asi mismo, la Ordenanza que crea y regula el Impuesto sobre Publicidad y Propaganda comercial del Municipio San Francisco del Estado Zulia, publicada en gaceta N° 328 de fecha 30/12/2013.'),0,'J');
	$this->Ln(2);    
        }else{
        if($this->datos[0]['anio_inicio']>=2008){
        $this->MultiCell(0,5,utf8_decode('Por medio de la presente Providencia AUTORIZO amplia y suficientemente al auditor fiscal '.$this->datos[0]['nombre'].' venezolano, mayor de edad, domiciliado en este Municipio San Francisco del Estado Zulia, titular de la cédula de identidad V- '.$this->datos[0]['cedula'].', adscrito(a) a la  Unidad de Fiscalización del Municipio San Francisco del Estado Zulia, según Resolución de Nombramiento de fecha '.$this->datos[0]['fe_nombramiento'].', para iniciar el Procedimiento de Fiscalización y Determinación Tributaria del Impuesto Sobre Actividades Económicas a la Contribuyente '.$this->datos[0]['nb_contribuyente'].',  autorizado según la Reforma Parcial de la Ordenanza que Crea y Regula el Impuesto sobre Actividades Economicas del Municipio San Francisco N° 361 de fecha 30/12/2014, con establecimiento permanente en el Municipio San Francisco, para los períodos fiscales comprendidos del '.$this->datos[0]['fe_fiscalizacion_inicio'].' hasta 31/12/2009, aplicable razone temporis la Ordenanza de Reforma Parcial de la Ordenanza que Crea y Regula el Impuesto sobre Actividades Económicas del Municipio San Francisco Estado Zulia Gaceta Municipal Extraordinaria Nª 202 de fecha 19/12/2007,  del 01/01/2010 al 31/12/2011 aplicable razone temporis la Ordenanza de Reforma Total de la Ordenanza que crea y regula el impuesto sobre Actividades Económicas del Municipio San Francisco del Estado Zulia Gaceta Municipal Extraordinaria Nº 258 de fecha 11 de Diciembre de 2009;  para el periodo fiscal comprendido entre el 01/01/2012 hasta el 31/12/2013, la Reforma Parcial de la Ordenanza de Reforma Total de la Ordenanza que crea y regula el Impuesto sobre Actividades Económicas del Municipio San Francisco del Estado Zulia Gaceta Municipal Extraordinaria N° 297 de fecha 23 de Diciembre de 2011 y para el periodo fiscal comprendido entre el 01/01/2014 hasta el 31/12/2014 la Reforma Parcial de la Ordenanza de Reforma Total de la Ordenanza que Crea y Regula el Impuesto sobre Actividades Económicas del Municipio San Francisco del Estado Zulia N° 329 de fecha 30 de Diciembre de 2013. Para el Impuesto sobre Inmuebles Urbanos del Municipio San Francisco Estado Zulia, aplicable razone temporis la Ordenanza de Inmuebles Urbanos publicada en gaceta N° 160, de fecha 26/12/2015, y la Ordenanza de Inmuebles Urbanos publicada en gaceta N° 338, de fecha 16/05/2014, asi mismo, la Ordenanza que crea y regula el Impuesto sobre Publicidad y Propaganda comercial del Municipio San Francisco del Estado Zulia, publicada en gaceta N° 328 de fecha 30/12/2013.'),0,'J');
	$this->Ln(2);    
        }               
        }              
        }     
        }
	$this->MultiCell(0,5,utf8_decode('Todo ello de conformidad con lo establecido en el Artículo 54 de la  Ordenanza sobre Administración Tributaria del Municipio San Francisco del Estado Zulia, en concordancia con el Articulo 131° numeral 2 de Código Orgánico Tributario (Gaceta Oficial No. 6.152 del 18/11/2014), que ordena practicar fiscalizaciones las cuales se autoriza a través de Providencia Administrativa. Dichas fiscalizaciones podrán efectuarse de manera general sobre uno o varios periodos fiscales de manera selectiva sobre uno o varios elementos de la base imponible.'),0,'J');
		$this->Ln(2);
                
	//$this->MultiCell(190,5,utf8_decode('El presente Procedimiento de Fiscalización y Determinación Tributaria se iniciara el día __/__/__ en cuya oportunidad deberá poner a disposición la información requerida.'),0,'J');
			$this->Ln(2);
	//$this->MultiCell(190,5,utf8_decode('Acompaña a la presente PROVIDENCIA la correspondiente Acta de Requerimiento, la cual firmara y sellara en calidad de recibido.'),0,'J');
				$this->Ln(2);
	$this->MultiCell(0,5,utf8_decode('Dado, firmado y sellado en el Despacho de la Unidad de Fiscalización Tributaria, en San Francisco del Estado Zulia, el '.$this->datos[0]['fe_fiscalizacion'].', año 204º de la Independencia y 155º de la Federación.'),0,'J');
		$this->Ln(13);
	$this->SetFont('Arial','B',12);
	$this->Cell(0,0,utf8_decode('ABOG. KATHERINE TORO'),0,0,'C');
	
	$this->Ln(5);
	$this->SetFont('Arial','B',10);
	$this->Cell(0,0,utf8_decode('DIRECTORA DE FISCALIZACION'),0,0,'C');
	$this->Ln(5);
	$this->Cell(0,0,utf8_decode('Según Resolución Nº ABR-1247-2014 DEL 08/12/14'),0,0,'C');
    $this->Ln(6);
//	$this->MultiCell(190,5,utf8_decode('DATOS DEL CONTRIBUYENTE NOTIFICADO. (Constancia de Recibo)'),0,'J');
//    $this->SetFont('Arial','',10);
//    $this->Ln(3);
//	$this->MultiCell(190,5,utf8_decode('Nombre y Apellido:________________________    Telefono:_________________   e-mail:____________________'),0,'J');
//	    $this->Ln(2);
//	$this->MultiCell(190,5,utf8_decode('Cargo en la Empresa:______________________   Fecha:____________________  Hora:______________________'),0,'J');
//	
//    	    $this->Ln(2);
//	$this->MultiCell(190,5,utf8_decode('Cedula de Identidad:______________________     Firma:____________________   Sello:_____________________'),0,'J');
//		    $this->Ln(2);
//	$this->MultiCell(190,5,utf8_decode('Direccion Exacta:________________________________________________________________________________'),0,'J');
//	
    	$this->AddPage();
	$this->SetFont('Arial','B',10);
        $this->Cell(0,0,utf8_decode('NOTIFICACIÓN DE LA PROVIDENCIA ADMINISTRATIVA QUE'),0,0,'C',0);
	$this->Ln(4);
        $this->Cell(0,0,utf8_decode('APERTURA EL PROCEDIMIENTO DE FISCALIZACIÓN Y'),0,0,'C',0);
	$this->Ln(4);
        $this->Cell(0,0,utf8_decode('DETERMINACION TRIBUTARIA'),0,0,'C',0);
	$this->Ln(4);
        $this->Cell(0,0,utf8_decode('Nº UAT-SF-ZL-PA-2016-'.$this->datos[0]['nu_providencia']),0,0,'C',0);
	$this->Ln(8);
	$this->SetFont('Arial','',9);
        $this->Cell(0,0,utf8_decode('Señores Representantes Legales de'),0,0,'L',0);
	$this->Ln(4);
        $this->Cell(0,0,utf8_decode($this->datos[0]['nb_contribuyente']),0,0,'L',0);
	$this->Ln(4);
        $this->Cell(0,0,utf8_decode('Ciudad.-'),0,0,'L',0);
	$this->Ln(8);
        $this->MultiCell(0,5,utf8_decode('Se le notifica que esta Unidad de Fiscalización; ha dictado la PROVIDENCIA ADMINISTRATIVA Nº UAT-SF-ZL-PA-2016-'.$this->datos[0]['nu_providencia'].' de fecha '.$this->datos[0]['fe_fiscalizacion'].', la cual se anexa  a la presente Notificación, de cuyo contenido se desprende que se ha nombrado al ciudadano, '.$this->datos[0]['nombre'].', venezolano, mayor de edad, portador de la cedula de identidad V- '.$this->datos[0]['cedula'].', suficientemente identificado en la mencionada Providencia en su carácter de Auditor Fiscal adscrito a la Unidad de Fiscalización Tributaria de la alcaldia del municipio San Francisco, para que en ejercicio de las más amplias facultades de fiscalización e investigación proceda a constatar el oportuno cumplimiento de los deberes formales y materiales por parte de su representada '.$this->datos[0]['nb_contribuyente'].', detectar y sancionar las infracciones tributarias cometidas, por lo que se recuerda a la contribuyente el deber de proporcionar los documentos que se les indicaran en la respectiva Acta de Requerimiento anexa a la presente notificación.'),0,'J');
	$this->Ln(8);
        $this->MultiCell(0,5,utf8_decode('Se hace del conocimiento a la contribuyente que el presente procedimiento fiscal se llevara a cabo en el lapso comprendido del '.$this->datos[0]['fe_fiscalizacion_inicio'].' al '.$this->datos[0]['fe_fiscalizacion_fin'].'.'),0,'J');
	$this->Ln(8);
        $this->MultiCell(0,5,utf8_decode('El presente procedimiento de Fiscalización y Determinación fiscal se iniciara el día _______, mes _______________, año _________,  en cuya oportunidad deberá poner a disposición la información requerida al momento de practicarse el procedimiento de fiscalización y determinación tributaria.'),0,'J');
	$this->Ln(8);
        $this->MultiCell(0,5,utf8_decode('Acompaña a la presente notificación la correspondiente Acta de Requerimiento, la cual firmara y sellara en calidad de recibido.'),0,'J');
	$this->Ln(20);
        $this->SetFont('Arial','B',12);
	$this->Cell(0,0,utf8_decode('ABOG. KATHERINE TORO'),0,0,'C');
	
	$this->Ln(5);
	$this->SetFont('Arial','B',10);
	$this->Cell(0,0,utf8_decode('DIRECTORA DE FISCALIZACION'),0,0,'C');
	$this->Ln(5);
	$this->Cell(0,0,utf8_decode('Según Resolución Nº ABR-1247-2014 DEL 08/12/14'),0,0,'C');

    
	$this->AddPage();
	$this->SetFont('Arial','B',12);
	$this->Cell(0,0,utf8_decode('ACTA DE REQUERIMIENTO N° UF-SF-ZL-PA-AR-2016-'.$this->datos[0]['nu_providencia']),0,0,'C',0);  
	$this->Ln(4);
	$this->SetFont('Arial','',9);
	$this->MultiCell(190,5,utf8_decode('CONTRIBUYENTE: '.$this->datos[0]['nb_contribuyente']),0,'J');
	$this->Ln(2); 
	if($this->datos[0]['nu_referencia']==''){
		if($this->datos[0]['tx_tp_doc']=='V'){

    $this->MultiCell(0,5,utf8_decode('CEDULA DE IDENTIDAD: '.$this->datos[0]['tx_tp_doc'].'-'.$this->datos[0]['rif_cedula']),0,'J');	
	}else{
     $this->MultiCell(0,5,utf8_decode('REGISTRO DE INFORMACION FISCAL: '.$this->datos[0]['tx_tp_doc'].'-'.$this->datos[0]['rif_cedula']),0,'J');	
	
		}
		
		}else{
		if($this->datos[0]['tx_tp_doc']=='V'){

	$this->MultiCell(0,5,utf8_decode('REFERENCIA: '.$this->datos[0]['nu_referencia'].' CEDULA DE IDENTIDAD: '.$this->datos[0]['tx_tp_doc'].'-'.$this->datos[0]['rif_cedula']),0,'J');
    	}else{
	$this->MultiCell(0,5,utf8_decode('REFERENCIA: '.$this->datos[0]['nu_referencia'].' REGISTRO DE INFORMACION FISCAL: '.$this->datos[0]['tx_tp_doc'].'-'.$this->datos[0]['rif_cedula']),0,'J');
    
		}
  }
    $this->Ln(2);  
	$this->MultiCell(0,5,utf8_decode('DIRECCION FISCAL: '.$this->datos[0]['tx_direccion']),0,'J');
	 
	$this->Ln(2);
	$this->MultiCell(0,5,utf8_decode('En San Francisco a los '.$fecha2.', conforme a lo dispuesto en el artículo 54 numerales 2 y 4 de la Ordenanza sobre Administración Tributaria del Municipio San Francisco del Estado Zulia, en concordancia con el artículo 137, numerales 3 y 8  del Código Orgánico Tributario, de fecha 18/11/2014 (Gaceta Oficial No. 6.152 del 18/11/2014), al funcionario '.$this->datos[0]['nombre'].', titular de la cédula de identidad V- '.$this->datos[0]['cedula'].', adscrito a la Unidad de Fiscalización de la Administración Tributaria Municipal, debidamente autorizado según Resolución de Nombramiento, se procede a dejar constancia de la solicitud de información documental referida a los periodos fiscales comprendidos entre '.$this->datos[0]['fe_fiscalizacion_inicio'].' al '.$this->datos[0]['fe_fiscalizacion_fin'].', señalada a continuación:'),0,'J'); 
	$this->SetFont('Arial','B',9); 
	$this->MultiCell(0,5,utf8_decode('Copia del:'),0,'J');
	
	     $this->SetWidths(array(85,10,85,10));
         $this->SetAligns(array("L","L","L","L"));
         $this->SetFillColor(255, 255, 255);
         $this->Ln(4);
         $this->SetTextColor(0,0,0);
         $this->SetFont('Arial','',8);
         $this->Row(array(utf8_decode("1. Registro de Comercio y última  Acta de Asamblea.          "),"       ",utf8_decode("11. Declaraciones de impuesto sobre la renta (ISLR)."),"       "),1);
         $this->Row(array(utf8_decode("2. Registro de Información Fiscal (RIF)."),"    ",utf8_decode("12. Facturación y Soportes de Venta."),"     "),1);
         $this->Row(array(utf8_decode("3. Cedula de Identidad y Registro de Información Fiscal (RIF) del Representante Legal de la Empresa."),"                 ",utf8_decode("13. Mayor analítico de ingresos. Balance General y Estado de Resultados.                        "),"           "),1);
         $this->Row(array(utf8_decode("4. Declaraciones definitivas, anticipadas de Ingresos Brutos, Municipio de San Francisco."),"                 ",utf8_decode("14. Libros legales, mayor, diario.                                                       "),"             "),1);
         $this->Row(array(utf8_decode("5. Reporte de retenciones emitidas por agentes de retención o percepción del tributo objeto de fiscalización."),"                  ","15. Documento de Propiedad del Inmueble o Contrato de Arrendamiento.                                                                              ","                    "),1);
         $this->Row(array(utf8_decode("6. Declaración de Aviso y Propaganda (Planilla de Liquidación)."),"        ",utf8_decode("16. Solvencia de inmueble.                               "),"         "),1);
         $this->Row(array(utf8_decode("7. Declaraciones definitivas de Ingresos Brutos,  otros Municipios."),"    ","17. Solvencia del Cuerpo de Bomberos.              ","       "),1);
         $this->Row(array(utf8_decode("8. Conciliación de ingresos brutos, otros Municipios.       "),"         ","18. Contrato de Obras y Servicios.                                ","         "),1);
         $this->Row(array(utf8_decode("9. Declaraciones del Impuesto al Valor Agregado (IVA).                    "),"                 ",utf8_decode("19. Ultima Revisión Fiscal realizada por la Administración Tributaria."),"                     "),1);
         $this->Row(array(utf8_decode("10. Libros auxiliares de ventas y compras  (IVA)."),"      ",utf8_decode("20. Correo electrónico Oficial del Contribuyente."),"  "),1);
	     $this->SetFont('Arial','',9);
	      $this->Ln(2);  
	      $this->MultiCell(0,5,utf8_decode('Se concede un plazo de TRES (03) días hábiles contados a partir de la fecha de notificación de la presente acta para consignar la documentación requerida, TODA LA DOCUMENTACION DEBE SER SELLADA Y FIRMADA POR EL CONTRIBUYENTE.'),0,'J');
   	      $this->Ln(2);  
	      $this->MultiCell(0,5,utf8_decode('Se hace del conocimiento de la contribuyente que de conformidad con lo dispuesto en el artículo 23 y en los ordinales 3, 4 y 8 del artículo 155 del Código Orgánico Tributario tiene la obligación de dar cumplimiento al requerimiento formulado en esta Providencia, pues su inobservancia constituye ilícitos formales tipificados y sancionados en los artículos 104  y 105, ejusdem. '),0,'J');
     	      $this->Ln(2);  
	      $this->MultiCell(0,5,utf8_decode('A los fines legales consiguientes, se emite la presente Acta en dos (2) ejemplares de un mismo tenor y a un solo efecto, uno (1) de los cuales queda en poder del contribuyente o responsable, quien firma en señal de notificación.'),0,'J');
       	      $this->Ln(2);  
   $this->SetFont('Arial','B',8);
   	$this->MultiCell(0,5,utf8_decode('AUDITOR FISCAL                                                            CONTRIBUYENTE'),0,'J');
	    $this->Ln(2);
	    $this->SetFont('Arial','',8);
	$this->MultiCell(0,5,utf8_decode('NOMBRE Y APELLIDO:________________________   NOMBRE Y APELLIDO:________________________'),0,'J');
	
    	    $this->Ln(2);
	$this->MultiCell(0,5,utf8_decode('CEDULA DE IDENTIDAD:______________________    CEDULA DE IDENTIDAD:______________________ '),0,'J');
		    $this->Ln(2);
	$this->MultiCell(0,5,utf8_decode('FECHA:_____________________________________   FECHA:_____________________________________'),0,'J');
	
   		    $this->Ln(2);
	//$this->MultiCell(0,5,utf8_decode('HORA:______________________________________   HORA:______________________________________'),0,'J');
	
        $this->AddPage();
   	$this->SetFont('Arial','B',12);
	$this->Cell(0,0,utf8_decode('ACTA DE RECEPCION N° UF-SF-ZL-PA-ARE-2016-'.$this->datos[0]['nu_providencia']),0,0,'C',0);  
	$this->Ln(15);
	$this->SetFont('Arial','',10);
	$this->MultiCell(0,5,utf8_decode('La Unidad de Fiscalizacion Tributaria del Municipio San Francisco, estado Zulia, en uso de las atribuciones y facultades conferidas por la Ley, por medio de la presente Acta procede a recibir la documentación requerida de conformidad con lo dispuesto en el artículo 137.3 del Código Orgánico Tributario, que se especifica a continuación:'),0,'J'); 
	$this->Ln(4);
	$this->SetFont('Arial','B',10); 
	$this->MultiCell(0,5,utf8_decode('Copia del:'),0,'J');
	
	     $this->SetWidths(array(85,10,85,10));
         $this->SetAligns(array("L","L","L","L"));
         $this->SetFillColor(255, 255, 255);
         $this->Ln(4);
         $this->SetTextColor(0,0,0);
         $this->SetFont('Arial','',10);
         $this->Row(array(utf8_decode("1. Registro de Comercio y última  Acta de Asamblea.          "),"              ",utf8_decode("11. Declaraciones de impuesto sobre la renta (ISLR)."),"            "),1);
         $this->Row(array(utf8_decode("2. Registro de Información Fiscal (RIF)."),"    ",utf8_decode("12. Facturación y Soportes de Venta."),"     "),1);
         $this->Row(array(utf8_decode("3. Cedula de Identidad y Registro de Información Fiscal (RIF) del Representante Legal de la Empresa."),"                 ",utf8_decode("13. Mayor analítico de ingresos. Balance General y Estado de Resultados.                        "),"           "),1);
         $this->Row(array(utf8_decode("4. Declaraciones definitivas, anticipadas de Ingresos Brutos, Municipio de San Francisco."),"          ",utf8_decode("14. Libros legales, mayor, diario.                                                   "),"          "),1);
         $this->Row(array(utf8_decode("5. Reporte de retenciones emitidas por agentes de retención o percepción del tributo objeto de fiscalización."),"                  ","15. Documento de Propiedad del Inmueble o Contrato de Arrendamiento.                                                                              ","                    "),1);
         $this->Row(array(utf8_decode("6. Declaración de Aviso y Propaganda (Planilla de Liquidación)."),"            ",utf8_decode("16. Solvencia de inmueble.                                                 "),"             "),1);
         $this->Row(array(utf8_decode("7. Declaraciones definitivas de Ingresos Brutos,  otros Municipios."),"         ","17. Solvencia del Cuerpo de Bomberos.                       ","            "),1);
         $this->Row(array(utf8_decode("8. Conciliación de ingresos brutos, otros Municipios.       "),"         ","18. Contrato de Obras y Servicios.                                ","         "),1);
         $this->Row(array(utf8_decode("9. Declaraciones del Impuesto al Valor Agregado (IVA)."),"         ",utf8_decode("19. Ultima Revisión Fiscal realizada por la Administración Tributaria."),"         "),1);
         $this->Row(array(utf8_decode("10. Libros auxiliares de ventas y compras  (IVA)."),"      ",utf8_decode("20. Correo electrónico Oficial del Contribuyente."),"  "),1);
	     $this->Ln(10);  

   $this->SetFont('Arial','B',10);
   	$this->MultiCell(190,5,utf8_decode('AUDITOR FISCAL                                                            CONTRIBUYENTE'),0,'J');
	    $this->Ln(4);
	    $this->SetFont('Arial','',10);
	$this->MultiCell(190,5,utf8_decode('NOMBRE Y APELLIDO:________________________   NOMBRE Y APELLIDO:________________________'),0,'J');
	
    	    $this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('CEDULA DE IDENTIDAD:______________________    CEDULA DE IDENTIDAD:______________________ '),0,'J');
		    $this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('FECHA:_____________________________________   FECHA:_____________________________________'),0,'J');
	
   		    $this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('HORA:______________________________________   HORA:______________________________________'),0,'J');
	
	   		    $this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('TELEFONO:_________________________________   TELEFONO:__________________________________'),0,'J');
	
	   		    $this->Ln(4);
	$this->MultiCell(190,5,utf8_decode('SELLO:_____________________________________   SELLO:_____________________________________'),0,'J');
	
        $this->AddPage();
        $this->Ln(8);
	$this->SetFont('Arial','B',10);
        $this->MultiCell(0,5,utf8_decode('A FIN DE DAR CUMPLIMIENTO CON LO ESTABLECIDO EN EL ART. 173 DEL CODIGO ORGANICO TRIBUTARIO, ESTA NOTIFICACIÓN DEBERA SER FIRMADA Y FECHADA POR LA PERSONA AUTORIZADA PARA ENTREGAR ESTE DOCUMENTO:'),0,'J');
	$this->Ln(8);
        $this->MultiCell(0,5,utf8_decode('Exposición del Acto de Notificación:'),0,'C');
	$this->Ln(8);
        $this->MultiCell(0,5,utf8_decode('El suscrito '.$this->datos[0]['nombre'].', portador (a) de la cedula de identidad Nº V-'.$this->datos[0]['cedula'].', adscrito a la Unidad de Fiscalización,  hace constar que: _____________________________, portador (a) de la cedula de identidad Nº ________________, quien desempeña el cargo de: ______________________, de la empresa '.$this->datos[0]['nb_contribuyente'].' , fue notificado el día, ___________, a las ___________. De lo cual dejo constancia.'),0,'J');
	$this->Ln(8);
        $this->MultiCell(0,5,utf8_decode('______________________________'),0,'C');
        $this->Ln(2);
        $this->MultiCell(0,5,utf8_decode($this->datos[0]['nombre']),0,'C');
        $this->Ln(2);
        $this->MultiCell(0,5,utf8_decode($this->datos[0]['cedula']),0,'C');
        $this->Ln(8);
        $this->MultiCell(0,5,utf8_decode('DATOS DE CONTRIBUYENTE NOTIFICADO.  (Constancia de Recibo).'),0,'J');
        $this->Ln(4);
        $this->MultiCell(0,5,utf8_decode('Nombre y Apellido: ________________________________________________'),0,'J');
        $this->Ln(4);
        $this->MultiCell(0,5,utf8_decode('Cargo en la empresa: ______________________________________________'),0,'J');
        $this->Ln(4);
        $this->MultiCell(0,5,utf8_decode('Cedula de Identidad: _______________________________________________'),0,'J');
	$this->Ln(4);
        $this->MultiCell(0,5,utf8_decode('Dirección Exacta: _________________________________________________'),0,'J');
	$this->Ln(4);
        $this->MultiCell(0,5,utf8_decode('Teléfono __________________________  e-mail: ________________________'),0,'J');
	$this->Ln(4);
        $this->MultiCell(0,5,utf8_decode('Fecha: ____________________________ Hora: _________________________'),0,'J');
	$this->Ln(4);
        $this->MultiCell(0,5,utf8_decode('Firma: ____________________________ Sello:__________________________'),0,'J');
	$this->Ln(4);
        $this->MultiCell(0,5,utf8_decode('Observaciones en la  Notificación:'),0,'J');
	$this->MultiCell(150,5,'                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          ',1,'J');
   
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



    function DatosProvidencia() {
		
		        $co_fiscalizacion    = $_GET["co_fiscalizacion"];

		
        $comunes = new ConexionComun();
        $sql ="select  tb004.nu_referencia, case when tb004.tx_razon_social is null then tb004.nb_contribuyente||' '||tb004.ap_contribuyente else tb004.tx_razon_social end as nb_contribuyente,
       CASE
            WHEN tb004.tx_rif IS NOT NULL THEN tb004.tx_rif::text
            ELSE btrim(to_char(tb004.nu_cedula, '999999999'::text))
        END AS rif_cedula,tb002.tx_tp_doc,
        tb106.nombre, tb106.cedula, tb004.tx_direccion, tb106.resolucion, tb107.co_tipo, to_char(tb100.fe_fiscalizacion,'dd/mm/yyyy') as fe_fiscalizacion, to_char(tb100.fe_fiscalizacion_inicio,'dd/mm/yyyy') as fe_fiscalizacion_inicio, to_char(tb100.fe_fiscalizacion_fin,'dd/mm/yyyy') as fe_fiscalizacion_fin, to_char(tb100.fe_fiscalizacion_inicio,'yyyy') as anio_inicio, to_char(tb100.fe_fiscalizacion_fin,'yyyy') as anio_fin, lpad(tb100.nu_providencia::text, 3, '0'::text) as nu_providencia,tb106.fe_nombramiento from tb100_ae_fiscalizacion as tb100 left join
                                     tb107_tipo_fiscalizacion as tb107 
                                     on (tb107.co_tipo = tb100.co_tipo) left join
                                     tb004_contribuyente as tb004
                                     on (tb004.co_contribuyente = tb100.co_contribuyente)left join
                                     tb106_auditores as tb106
                                     on (tb106.co_auditor = tb100.co_auditor) left join 
                                     tb002_tipo_contribuyente as tb002 
                                     on (tb002.co_tipo = tb004.co_tipo) where tb100.co_fiscalizacion=".$co_fiscalizacion;
          //echo $sql; exit();
          $this->datos =   $comunes->ObtenerFilasBySqlSelect($sql);
    }

    

}
$pdf=new PDF('P','mm','letter');
$pdf->SetMargins(15, 25 , 15);
$pdf->PrintChapter();
$pdf->SetDisplayMode('default');
$pdf->Output();

?>
