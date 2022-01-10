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
 
  }
 

  public function executeValidar(sfWebRequest $request)
  {

     $usuario = $this->getRequestParameter('usuario');
     $password = $this->getRequestParameter('password');
     //$captcha = $this->getRequestParameter('captcha');

     $this->datos = Tb001UsuarioPeer::getDatosUsuario($usuario, md5($password));

     if(($this->datos!="")){ 
	     $this->codigo = $this->datos->getCoUsuario();
	     $this->nombre = $this->datos->getNbUsuario().' '.$this->datos->getApUsuario();
	     $this->co_rol = $this->datos->getCoRol();
             //$this->co_rol_solicitud = $this->datos->getCoRolSolicitud();
           //  $this->co_instituto = $this->datos->getCoInstituto();

	     $_SESSION['codigo'] = $this->codigo;
	     $_SESSION['nombre'] = $this->nombre;

            // echo "codigo=".$this->codigo; exit();
	     $this->getUser()->setAttribute('nombre', $this->nombre);
	     $this->getUser()->setAttribute('codigo', $this->codigo);
        //     $this->getUser()->setAttribute('co_instituto', $this->co_instituto);
	     $this->getUser()->setAttribute('rol', $this->co_rol);
        //     $this->getUser()->setAttribute('rol_solicitud', $this->co_rol_solicitud);
	     $this->getUser()->setAuthenticated(true);
            
             $this->redirect('/proadmin/web/index.php/ejercicio');
         
         
     }else{   
      
            $this->resultado = "Usuario y/o Contraseña Invalida";
            $this->setTemplate('index');

     }
  }

  public function executeLimpiar(sfWebRequest $request)
  { 
     
      $this->getUser()->setAuthenticated(false);
      $this->redirect('/proadmin/web/index.php');
      
      
  }
  
   public function executeCerrarNavegador(sfWebRequest $request)
  { 
      $con = Propel::getConnection();
      $sql = "insert into t79_historico_conexion 
             (co_accion, co_usuario, fe_conexion,ip)
              VALUES (3,".$_SESSION['codigo'].", now(),'".$_SERVER["REMOTE_ADDR"]."')";
      $stmt = $con->prepare($sql);
      $stmt->execute();
      
      
      $this->getUser()->setAuthenticated(false);
      $this->redirect('/proadmin/web/index.php');
      
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
