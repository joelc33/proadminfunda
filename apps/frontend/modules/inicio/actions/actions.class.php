<?php

/**
 * inicio actions.
 *
 * @package    taquilla
 * @subpackage inicio
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class inicioActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
      $this->nombre = $this->getUser()->getAttribute('nombre');
      $this->ejercicio = $this->getUser()->getAttribute('ejercicio');
      $this->getRequest()->setAttribute('titulo', $this->nombre);
      $this->getRequest()->setAttribute('ejercicio', $this->ejercicio);

      
     $menu = Tb004MenuPeer::ArmaMenu($this->getUser()->getAttribute('rol'),$this->getUser()->getAttribute('codigo')); 
     
     $this->getRequest()->setAttribute('menu', $menu);
     $this->usuario = $this->getUser()->setAttribute('member_id', $this->nombre); 

      if($this->nombre==''){
        $this->redirect('/proadmin/web/index.php');
      }else{
         $this->getUser()->setAuthenticated(true);      
      }
  }
}
