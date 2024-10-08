<?php

include("ConexionComun.php");

function callAPI($method, $url, $data){
    $curl = curl_init();
 
    switch ($method){
       case "POST":
          curl_setopt($curl, CURLOPT_POST, 1);
          if ($data)
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          break;
       case "PUT":
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
          if ($data)
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
          break;
       default:
          if ($data)
             $url = sprintf("%s?%s", $url, http_build_query($data));
    }
 
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       'APIKEY: 111111111111111111111',
       'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
 
    // EXECUTE:
    $result = curl_exec($curl);
    if(!$result){
       //die("Documento Generado!.");
    }
    curl_close($curl);
    return $result;
}

$co_tipo_solicitud = $_GET["co_tipo_solicitud"];
$co_proceso = $_GET["co_proceso"];
$co_anio_fiscal = $_GET["co_anio_fiscal"];

function getRutaId( $co_tipo_solicitud, $co_proceso, $co_anio_fiscal){

   $conex = new ConexionComun(); 
   
   $sql = 'SELECT tb030.co_ruta, tb030.co_solicitud, tb030.co_tipo_solicitud, tb030.co_proceso, 
   tx_ruta_reporte, in_anular, nb_reporte_orden
   FROM tb030_ruta as tb030
   INNER JOIN tb032_configuracion_ruta AS tb032 ON tb030.co_tipo_solicitud = tb032.co_tipo_solicitud AND tb030.co_proceso = tb032.co_proceso
   INNER JOIN tb026_solicitud AS tb026 ON tb030.co_solicitud = tb026.co_solicitud
   WHERE tb026.id_tb013_anio_fiscal = '.$co_anio_fiscal.'
   AND tb030.co_tipo_solicitud = '.$co_tipo_solicitud.' 
   AND tb030.co_proceso = '.$co_proceso;

   //echo $sql; exit();

   $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
   return  $datosSol;                          
  
}

$datos_ruta = getRutaId( $co_tipo_solicitud, $co_proceso, $co_anio_fiscal);

$i = 0;

foreach ($datos_ruta as $key => $value) {

   $i++;

   $definicion =  $_SERVER["SERVER_NAME"].'/proadmin/web/reportes/'.$value['nb_reporte_orden'].'.php?codigo='.$value['co_ruta'];

   //echo $definicion;
   //exit();

   $get_data = callAPI('GET', $definicion, false);
   $response = json_decode($get_data, true);
   $errors = $response['response']['errors'];
   $data = $response['response']['data'][0];

}

echo $i." Documentos Generados con Exito!.";

?>