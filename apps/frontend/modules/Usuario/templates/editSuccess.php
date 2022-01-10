<?php

   if($respuesta==1){

                $info = array(
			'success' => true,
			'message' => 'La Contraseña se Cambio Satisfactoriamente'
		);
	}else{
		//header('HTTP/1.1 501 Error saving the record');
		$info = array(
			'failure' => false,
			'message' => $respuesta
		);
	}
        echo json_encode($info);

?>
