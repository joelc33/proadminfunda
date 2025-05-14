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
       die("Documento Generado con Exito!.");
    }
    curl_close($curl);
    return $result;
}

$co_solicitud = $_GET["co_solicitud"];
$co_tipo_solicitud = $_GET["co_tipo_solicitud"];
$co_proceso = $_GET["co_proceso"];

/*$conex = new ConexionComun();

$sql = 'SELECT co_ruta, co_solicitud, co_tipo_solicitud, 
co_proceso, observacion, tx_ruta_reporte, in_anular
FROM tb030_ruta
WHERE co_solicitud = '.$co_solicitud.' 
AND co_tipo_solicitud = '.$co_tipo_solicitud.' 
AND co_proceso = '.$co_proceso;

$datosRuta = $conex->ObtenerFilasBySqlSelect($sql);

foreach ($datosRuta as $key => $value) {

   echo $_SERVER["SERVER_NAME"].'/gobel/web/reportes/'.$value['co_ruta'];

}*/

function getRutaId($co_solicitud, $co_tipo_solicitud, $co_proceso){

   $conex = new ConexionComun(); 
   
   $sql = 'SELECT tb030.co_ruta, tb030.co_solicitud, tb030.co_tipo_solicitud, tb030.co_proceso, 
   tx_ruta_reporte, in_anular, nb_reporte_orden
   FROM tb030_ruta as tb030
   INNER JOIN tb032_configuracion_ruta AS tb032 ON tb030.co_tipo_solicitud = tb032.co_tipo_solicitud AND tb030.co_proceso = tb032.co_proceso
   WHERE co_solicitud = '.$co_solicitud.' 
   AND tb030.co_tipo_solicitud = '.$co_tipo_solicitud.' 
   AND tb030.co_proceso = '.$co_proceso.' order by tb030.co_ruta desc';

   //echo $sql; exit();

   $datosSol = $conex->ObtenerFilasBySqlSelect($sql);
   return  $datosSol[0];                          
  
}

$datos_ruta = getRutaId( $co_solicitud, $co_tipo_solicitud, $co_proceso);

$definicion =  $_SERVER["SERVER_NAME"].'/proadmin/web/reportes/'.$datos_ruta['nb_reporte_orden'].'.php?codigo='.$datos_ruta['co_ruta'];

//echo $definicion;
//exit();

$get_data = callAPI('GET', $definicion, false);
$response = json_decode($get_data, true);
$errors = $response['response']['errors'];
$data = $response['response']['data'][0];

?>