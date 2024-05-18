<?php

/**
 * CargoEstructura actions.
 *
 * @package    gobel
 * @subpackage CargoEstructura
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class CargoEstructuraActions extends sfActions
{
    public function executeBuscar(sfWebRequest $request)
   {
       
        $paquete_modulo = $this->getRequestParameter("paquete");
     
        $this->estructura = Tbrh005EstructuraAdministrativaPeer::datosEstructura();
        $this->paquete = $paquete_modulo;
   }
  
   public function executeSeleccinarEstructura(sfWebRequest $request){
       
       
       $json  = json_decode($this->getRequestParameter('json_array'),true);
       $opciones = $json['opcion'];
       
       foreach ($opciones as $lista){
           $lista;            
       }
       
       $this->paquete_modulo = $this->getRequestParameter("paquete");
       $this->estructura = Tbrh005EstructuraAdministrativaPeer::getUbicacionEstructura($lista);
       $this->co_estructura_administrativa = $lista;
       
   }
}
