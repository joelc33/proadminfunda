<?php
include("ConexionComun.php");

class miPDF{

public function cuerpo(){
ob_start();
require_once('main.php');
$text = ob_get_contents();
ob_end_clean();
//echo $text; exit;
return $text;
}

}

$mihtml = new miPDF();

require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
$html2pdf = new HTML2PDF('P','Letter','es');
$html2pdf->WriteHTML($mihtml->cuerpo());
$html2pdf->Output('formato.pdf');
?>

