<?php

/**
 * autoLogin actions.
 * NombreClaseModel(T01Usuario)
 * NombreTabla(t01_usuario)
 * @package    ##PROJECT_NAME##
 * @subpackage autoLogin
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class LoginActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {

     $this->getUser()->setAttribute('nombre','');
     $this->getUser()->setAttribute('codigo','');
     $this->getUser()->setAttribute('rol','');

     $this->getUser()->setAuthenticated(false);
     $this->getUser()->getAttributeHolder()->clear();
     $this->url = $_SERVER["SCRIPT_NAME"];

  }


  public function executeValidar(sfWebRequest $request)
  {

     $usuario = $this->getRequestParameter('usuario');
     $password = $this->getRequestParameter('password');

     $captcha = $this->getRequestParameter('captcha');
     $ejercicio = $this->getRequestParameter('co_anio_fiscal');

     $this->datos = $this->getDatosUsuario($usuario, md5($password));


     if(($this->datos!="") ){
	     $this->codigo = $this->datos["co_usuario"];
	     $this->nombre = $this->datos["nb_usuario"];
	     $this->co_rol = $this->datos["co_rol"];

	     $this->getUser()->setAttribute('nombre', $this->nombre);
	     $this->getUser()->setAttribute('codigo', $this->codigo);
	     $this->getUser()->setAttribute('rol', $this->co_rol);
             $this->getUser()->setAttribute('co_ejecutor', $this->datos["co_ejecutor"]);
             $this->getUser()->setAttribute('co_proceso', $this->datos["co_proceso"]);

             $this->getUser()->setAttribute('ejercicio', date("Y"));
         //    $this->getUser()->setAttribute('rol_solicitud', $this->co_rol_solicitud);

	     $this->getUser()->setAuthenticated(true);

             $data = array("msg" => "Usuario Validado","success"=>true);
             $resultado = json_encode($data);


     }else{

            $data = array("msg" => "Usuario y/o Contraseña Invalida","success"=>false);

            $resultado = json_encode($data);

     }
     echo $resultado;
     return sfView::NONE;
  }

  public function executeLimpiar(sfWebRequest $request)
  {
      $this->getUser()->setAuthenticated(false);
      $this->getUser()->getAttributeHolder()->clear();
      $this->redirect('/proadmin/web/');

  }


  protected function getDatosUsuario($usuario,$password){

          $c= new Criteria();
          $c->clearSelectColumns();
          $c->addSelectColumn(Tb001UsuarioPeer::NB_USUARIO);
          $c->addSelectColumn(Tb001UsuarioPeer::CO_USUARIO);
          $c->addSelectColumn(Tb001UsuarioPeer::CO_ROL);
          $c->addSelectColumn(Tb001UsuarioPeer::CO_EJECUTOR);
          $c->addSelectColumn(Tb001UsuarioPeer::CO_EJECUTOR);
          $c->addSelectColumn(Tb002ProcesoUsuarioPeer::CO_PROCESO);
          $c->addJoin(Tb002ProcesoUsuarioPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO);
          
          $c->add(Tb002ProcesoUsuarioPeer::IN_PRINCIPAL,true);
          $c->add(Tb001UsuarioPeer::TX_LOGIN,$usuario);
          $c->add(Tb001UsuarioPeer::TX_PASSWORD,$password);

          $res = Tb001UsuarioPeer::doSelectStmt($c);

          foreach($res as $result)
            return $result;
    }

    public function executeStorefkAnioFiscal(sfWebRequest $request){
        $c = new Criteria();
        $c->addDescendingOrderByColumn(Tb013AnioFiscalPeer::CO_ANIO_FISCAL);
        $stmt = Tb013AnioFiscalPeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
            ));
        $this->setTemplate('store');
    }




}
