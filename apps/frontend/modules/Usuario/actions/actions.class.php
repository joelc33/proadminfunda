<?php

/**
 * autoUsuario actions.
 * NombreClaseModel(Tb001Usuario)
 * NombreTabla(tb001_usuario)
 * @package    ##PROJECT_NAME##
 * @subpackage autoUsuario
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class UsuarioActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Usuario', 'lista');
  }
  
  public function executeEliminarProceso(sfWebRequest $request){
      
        $codigo = $this->getRequestParameter("co_usuario_proceso");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
            /*CAMPOS*/
            $tb002_proceso_usuario = Tb002ProcesoUsuarioPeer::retrieveByPk($codigo);			
            $tb002_proceso_usuario->delete($con);
            $this->data = json_encode(array(
                        "success" => true,
                        "msg" => 'Registro Borrado con exito!'
            ));
            $con->commit();
	}catch (PropelException $e)
	{
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => 'El registro no se puede borrar'
            ));
	}
  }

  public function executePrincipalProceso(sfWebRequest $request){
      
        $codigo = $this->getRequestParameter("co_usuario_proceso");
        $con = Propel::getConnection();
        try
        { 
        $con->beginTransaction();
                /*CAMPOS*/
                $tb002_proceso_usuario = Tb002ProcesoUsuarioPeer::retrieveByPk($codigo);			
                $tb002_proceso_usuario->setInPrincipal(true);
                $tb002_proceso_usuario->save($con);
                $this->data = json_encode(array(
                            "success" => true,
                            "msg" => 'Registro marcado como principal!'
                ));
                $con->commit();
        }catch (PropelException $e)
        {
                $con->rollback();
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El registro no se puede borrar'
                ));
        }
    }
  
   public function executeStorefkcoejecutor(sfWebRequest $request){
    
        $c = new Criteria();
        $c->add(Tb082EjecutorPeer::IN_ACTIVO,TRUE);
        $stmt = Tb082EjecutorPeer::doSelectStmt($c);
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
  
  public function executeStorefkcoproceso(sfWebRequest $request){
        
        $co_usuario = $this->getRequestParameter("co_usuario");     
        
        $sql ="select * from tb028_proceso 
                where co_proceso not in (select co_proceso
                                             from tb002_proceso_usuario
                                             where co_usuario = $co_usuario)";
        
        $con = Propel::getConnection();
        $data = '';
        $stmt = $con->prepare($sql);
        $stmt->execute();
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
  
  public function executeAgregarProceso(sfWebRequest $request){
      
      $co_proceso = $this->getRequestParameter("co_proceso");
      $this->co_usuario = $this->getRequestParameter("co_usuario");
      $in_principal = $this->getRequestParameter("in_principal");
      
      $con = Propel::getConnection();
      try
      { 
      
            $Tb002ProcesoUsuario = new Tb002ProcesoUsuario();    
            $Tb002ProcesoUsuario->setCoProceso($co_proceso)
                                ->setCoUsuario($this->co_usuario)
                                ->setInPrincipal(false)
                                ->save($con);

            if($in_principal=='true'){

                $wherec = new Criteria();
                $wherec->add(Tb002ProcesoUsuarioPeer::CO_USUARIO, $this->co_usuario, Criteria::EQUAL);
                
                $updc = new Criteria();
                $updc->add(Tb002ProcesoUsuarioPeer::IN_PRINCIPAL, false);

                BasePeer::doUpdate($wherec, $updc, $con);
                  
                $Tb002 = Tb002ProcesoUsuarioPeer::retrieveByPK($Tb002ProcesoUsuario->getCoUsuarioProceso());
                $Tb002->setInPrincipal(true);
                $Tb002->save($con);
            }
            
            $this->respuesta = 1;
            $this->mensaje = 'El registro se agregó exitosamente!';
               
            
            
      }catch (PropelException $e)
      {
        $con->rollback();
        $this->respuesta = 2;
        $this->mensaje = $e->getMessage();
        
      }
      
              
      
  }
  
  public function executeCambioClave(){

  }
  
  public function executeEdit($request){

        $this->respuesta = 1;

        if ($request->isMethod('post'))
        {
         $con = Propel::getConnection();
          try
          {
             $this->guardarClave($con);
             $con->commit();
          }
          catch (PropelException $e)
          {
            $con->rollBack();
            $this->respuesta = $e->getMessage();
          }
        }
  }
  
  protected function guardarClave($con)
  {
        $codigo = $this->getUser()->getAttribute('codigo');
        $clave = $this->getRequestParameter('clave');
        $clave_actual = $this->getRequestParameter('clave_actual');
        $confirmacion = $this->getRequestParameter('confirmacion');

        $Usuario = Tb001UsuarioPeer::retrieveByPK($codigo);
        
        if($Usuario->getTxPassword() !=  md5($clave_actual)){
                $this->respuesta = "La contraseña actual no coinciden con la ingresada ".$Usuario->getTxPassword()."!=".md5($clave_actual);
     
        }else{
           
            if($clave === $confirmacion){
                $Usuario->setTxPassword(md5($clave))->save($con);
            }else{
                $this->respuesta = "La contraseña y la confirmacion no coinciden";                         
            }
            
        }       
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Usuario', 'editar');
  }
  
  public function executeListaProceso(sfWebRequest $request)
  {
    $this->co_usuario = $this->getRequestParameter('codigo');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }
  
  public function executeListaTramite(sfWebRequest $request)
  {    
      $co_usuario = $this->getRequestParameter('co_usuario');
      $this->tramite = Tb027TipoSolicitudPeer::ArmaTramitePrivilegio($this->getRequestParameter('codigo'),$co_usuario);
  
      
       $this->data = json_encode(array(
                            "co_usuario" => $co_usuario
       ));
  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb001UsuarioPeer::CO_USUARIO,$codigo);
        
        $stmt = Tb001UsuarioPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                "co_usuario"     => $campos["co_usuario"],
                "tx_login"       => $campos["tx_login"],
                "nb_usuario"     => $campos["nb_usuario"],
                "ap_usuario"     => $campos["ap_usuario"],
                "tx_correo"      => $campos["tx_correo"],
                "co_ejecutor"    => $campos["co_ejecutor"],
                "tx_password"    => $campos["tx_password"],
                "co_rol"         => $campos["co_rol"],
                "in_activo"      => $campos["in_activo"],
                "nu_cedula"      => $campos["nu_cedula"],
                "co_documento"   => $campos["co_documento"],
                "co_ente"   => $campos["co_ente"]
        ));
    }else{
        $this->data = json_encode(array(
                "co_usuario"     => "",
                "tx_login"       => "",
                "nb_usuario"     => "",
                "tx_password"    => "",
                "co_rol"         => "",
                "in_activo"      => "",
                "nu_cedula"      => "",
                "co_documento"   => "",
                "ap_usuario"     => "",
                "tx_correo"      => "",
                "co_ejecutor"    => "",
                "co_ente"        => ""
        ));
    }

  }
  
  protected function getValidaUsuario($login){
        $c = new Criteria();
        $c->add(Tb001UsuarioPeer::TX_LOGIN,$login);
        $c->setIgnoreCase(true);
        $stmt = Tb001UsuarioPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos["nb_usuario"];
  }
  
  protected function getValidaTramite($co_usuario){
        $c= new Criteria();
        $c->add(Tb006TipoSolicitudUsuarioPeer::CO_USUARIO,$co_usuario);
       
        $stmt = Tb006TipoSolicitudUsuarioPeer::doSelectStmt($c);
        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[$res["co_tipo_solicitud"]]= 'true';
        }
        
        return $registros;
  }
  
  public function executeGuardarTramite(sfWebRequest $request)
  {
     $json  = json_decode($this->getRequestParameter('arreglo'),true);
     $opciones = $json['opcion'];

     $codigo = $this->getRequestParameter("co_usuario");
   
     $con = Propel::getConnection();
     try
      { 
        $con->beginTransaction();
        
        $wherec = new Criteria();
        $wherec->add(Tb006TipoSolicitudUsuarioPeer::CO_USUARIO,$codigo);
        BasePeer::doDelete($wherec, $con);
        
        foreach ($opciones as $lista){              
                  $tb006TipoSolicitudUsuario = new Tb006TipoSolicitudUsuario();
                  $tb006TipoSolicitudUsuario->setCoUsuario($codigo)
                                            ->setCoTipoSolicitud($lista)
                                            ->save($con);
        }                             
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente'
                ));
        $con->commit();
      }catch (PropelException $e)
      {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage()
        ));
      }
        
  }

  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_usuario");
     
     $tb001_usuarioForm = $this->getRequestParameter('tb001_usuario');
      
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb001_usuario = Tb001UsuarioPeer::retrieveByPk($codigo);
     }else{
         $tb001_usuario = new Tb001Usuario();
         
         $nombre_usuario = $this->getValidaUsuario($tb001_usuarioForm["tx_login"]);
         
        if($nombre_usuario!=''){
                $data = json_encode(array(
                     "success" => false,
                     "msg"    => 'El login <b>'.$tb001_usuarioForm["tx_login"].'</b> ya se encuentra asignado a la persona <b>'.$nombre_usuario.'</b>'
                ));

                echo  $data;
                return sfView::NONE;
        }
         
     }
     try
      { 
        $con->beginTransaction();
       
       
/*CAMPOS*/
                                        
        /*Campo tipo VARCHAR */
        $tb001_usuario->setTxLogin($tb001_usuarioForm["tx_login"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb001_usuario->setNbUsuario($tb001_usuarioForm["nb_usuario"]);
        $tb001_usuario->setApUsuario($tb001_usuarioForm["ap_usuario"]);
        $tb001_usuario->setTxCorreo($tb001_usuarioForm["tx_correo"]);
        
        /*Campo tipo VARCHAR */
       // $password = $this->generaPass();
        $tb001_usuario->setTxPassword(md5(123456));
                                                        
        /*Campo tipo BIGINT */
        if($tb001_usuarioForm["co_ejecutor"]!=''){
            $tb001_usuario->setCoEjecutor($tb001_usuarioForm["co_ejecutor"]);
        }else{
            $tb001_usuario->setCoEjecutor(NULL);
        }
        
        if($tb001_usuarioForm["co_ente"]!=''){
            $tb001_usuario->setCoEnte($tb001_usuarioForm["co_ente"]);
        }else{
            $tb001_usuario->setCoEnte(NULL);
        }
            
        $tb001_usuario->setCoRol($tb001_usuarioForm["co_rol"]);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb001_usuarioForm)){
            $tb001_usuario->setInActivo(true);
        }else{
            $tb001_usuario->setInActivo(false);
        }
                                                        
        /*Campo tipo NUMERIC */
        $tb001_usuario->setNuCedula($tb001_usuarioForm["nu_cedula"]);
                                                        
        /*Campo tipo BIGINT */
        $tb001_usuario->setCoDocumento($tb001_usuarioForm["co_documento"]);
                                
        /*CAMPOS*/
        $tb001_usuario->save($con);
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente'
                ));
        $con->commit();
        
        
        

        $mensaje = 'Estimado(a) Funcionario(a), usted acaba de obtener su acceso al
                    Sistema Administrativo de Gobierno Electronico (GOBEL). Sus datos
                    de acceso son:\r\n\r\n


                    Usuario: '.$tb001_usuarioForm["tx_login"].' \r\n
                    Clave: '.$password.' \r\n\r\n


                    A partir de este momento, con la utilización de su usuario y
                    contraseña usted tiene la posibilidad de acceder al sistema. \r\n\r\n

                    La ruta de acceso al sistema es https://localhost

                    Puede cambiar su contraseña en la opción "Cambio de Clave" del menu
                    Autenticación \r\n

                    Gracias por utilizar nuestros servicios.';

            $mensaje = wordwrap($mensaje, 70, "\r\n");

            mail($tb001_usuarioForm["tx_correo"], 'Cuenta de Usuario GOBEL', $mensaje);

        
      }catch (PropelException $e)
      {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage()
        ));
      }
    }
  
    
    protected function generaPass(){
        //Se define una cadena de caractares. Te recomiendo que uses esta.
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        //Obtenemos la longitud de la cadena de caracteres
        $longitudCadena=strlen($cadena);

        //Se define la variable que va a contener la contraseña
        $pass = "";
        //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
        $longitudPass=10;

        //Creamos la contraseña
        for($i=1 ; $i<=$longitudPass ; $i++){
            //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
            $pos=rand(0,$longitudCadena-1);

            //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
  }

  public function executeCambiarEstado(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_usuario");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb001_usuario = Tb001UsuarioPeer::retrieveByPk($codigo);
        
        $estatus = $tb001_usuario->getInActivo();
        
        if($estatus == 1){
            $tb001_usuario->setInActivo(0);
        }else{
            $tb001_usuario->setInActivo(1);
        }
        
	$tb001_usuario->save($con);
		$this->data = json_encode(array(
			    "success" => true,
			    "msg" => 'Es cambio de estatus se realizo exitosamente!'
		));
	$con->commit();
	}catch (PropelException $e)
	{
	$con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
//		    "msg" =>  $e->getMessage()
		    "msg" => 'Ocurrio un error al cambiar el estatus'
		));
	}
  }

  public function executeLista(sfWebRequest $request)
  {

  }
  
  public function executeStorelistaProceso(){
      
    $co_usuario    =   $this->getRequestParameter("co_usuario");
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
    
   
    $c = new Criteria();
    $c->setIgnoreCase(true);
    $c->add(Tb002ProcesoUsuarioPeer::CO_USUARIO,$co_usuario);
    $cantidadTotal = Tb002ProcesoUsuarioPeer::doCount($c);
    
    if($paginar=='si') $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb028ProcesoPeer::TX_PROCESO);
    
    
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb002ProcesoUsuarioPeer::CO_USUARIO_PROCESO);
    $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
    $c->addSelectColumn(Tb002ProcesoUsuarioPeer::IN_PRINCIPAL);
    $c->addJoin(Tb002ProcesoUsuarioPeer::CO_PROCESO, Tb028ProcesoPeer::CO_PROCESO);
    $stmt = Tb002ProcesoUsuarioPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_usuario_proceso"=> trim($res["co_usuario_proceso"]),
            "tx_proceso"        => trim($res["tx_proceso"]),
            "in_principal"     => (trim($res["in_principal"]))==1?'SI':""
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    
    
     $this->setTemplate('storelista');
      
  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
    
    $tx_login      =   $this->getRequestParameter("tx_login");
    $nb_usuario      =   $this->getRequestParameter("nb_usuario");
    $tx_password      =   $this->getRequestParameter("tx_password");
    $co_rol      =   $this->getRequestParameter("co_rol");
    $in_activo      =   $this->getRequestParameter("in_activo");
    $nu_cedula      =   $this->getRequestParameter("nu_cedula");
    $co_documento      =   $this->getRequestParameter("co_documento");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
        if($tx_login!=""){$c->add(Tb001UsuarioPeer::tx_login,'%'.$tx_login.'%',Criteria::LIKE);}

        if($nb_usuario!=""){$c->add(Tb001UsuarioPeer::nb_usuario,'%'.$nb_usuario.'%',Criteria::LIKE);}

        if($tx_password!=""){$c->add(Tb001UsuarioPeer::tx_password,'%'.$tx_password.'%',Criteria::LIKE);}

        if($co_rol!=""){$c->add(Tb001UsuarioPeer::co_rol,$co_rol);}


        if($nu_cedula!=""){$c->add(Tb001UsuarioPeer::nu_cedula,$nu_cedula);}

        if($co_documento!=""){$c->add(Tb001UsuarioPeer::co_documento,$co_documento);}    
    }
    
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb001UsuarioPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb001UsuarioPeer::CO_USUARIO);
        
    $stmt = Tb001UsuarioPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        
    if($res["in_activo"]==1){
        $estado='Activo';
    }else{
        $estado='Inactivo';
    }
    $registros[] = array(
            "co_usuario"     => trim($res["co_usuario"]),
            "tx_login"     => trim($res["tx_login"]),
            "nb_usuario"     => trim($res["nb_usuario"]),
            "tx_password"     => trim($res["tx_password"]),
            "co_rol"     => trim($this->getTxRol($res["co_rol"])),
            "in_activo"     => trim($estado),
            "nu_cedula"     => trim($res["nu_cedula"]),
            "co_documento"     => trim($res["co_documento"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }
    
    protected function getTxRol($codigo){
        $c = new Criteria();
        $c->add(Tb003RolPeer::CO_ROL,$codigo);
        
        $stmt = Tb003RolPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos["tx_rol"];
    }

    //modelo fk tb003_rol.CO_ROL
    public function executeStorefkcorol(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb003RolPeer::doSelectStmt($c);
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
                                            //modelo fk tb007_documento.CO_DOCUMENTO
    public function executeStorefkcodocumento(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb007DocumentoPeer::doSelectStmt($c);
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
        
    public function executeStorefkcoente(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb047EntePeer::doSelectStmt($c);
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