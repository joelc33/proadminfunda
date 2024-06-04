<?php

  class myConfig{
       
        public function myConfig(){
            
        }       
         
        public function encrypt($string) {
            $result = '';
            for($i=0; $i<strlen($string); $i++) {
               $char = substr($string, $i, 1);
               $keychar = substr($this->getKeyEncrypt(), ($i % strlen($this->getKeyEncrypt()))-1, 1);
               $char = chr(ord($char)+ord($keychar));
               $result.=$char;
            }
            return base64_encode($result);
        }
        
        function decrypt($string) {
            $result = '';
            $string = base64_decode($string);
            for($i=0; $i<strlen($string); $i++) {
               $char = substr($string, $i, 1);
               $keychar = substr($this->getKeyEncrypt(), ($i % strlen($this->getKeyEncrypt()))-1, 1);
               $char = chr(ord($char)-ord($keychar));
               $result.=$char;
            }
            return $result;
         }
        
        protected function getKeyEncrypt(){
            return date("Y-m-d");
        }
        
        public function getDirectorio(){
            return '/var/www/html/proadmin/';
        }
        
        public function getDirectorioReporte(){
            return '/var/www/html/proadmin/web/reportes/imagenes/';
        }
        
        public function setConvertToURL($url){
            $this->ruta = $url;
        }
        
        public function getConvertToURL(){
            return str_replace('/var/www/html/', 'http://'.$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].'/', $this->ruta);
        }
        
        
  }

?>

