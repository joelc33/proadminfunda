<?php

class Tb001UsuarioPeer extends BaseTb001UsuarioPeer
{
	 static public function getDatosUsuario($usuario,$password,$ip){

          $c= new Criteria();
          $c->add(self::TX_LOGIN,$usuario);
          $c->add(self::TX_PASSWORD,$password);
          $c->add(self::IN_ACTIVO,true);
          $res = self::doSelect($c);

          foreach($res as $result)
            return $result;
    }
    
    static public function getDatosUsuarioAnulacion($usuario,$password){

          $c= new Criteria();
          $c->add(self::TX_LOGIN,$usuario);
          $c->add(self::TX_PASSWORD,$password);
	  $c->add(self::IN_AUTORIZAR,true);
          $res = self::doSelect($c);

          foreach($res as $result)
            return $result;
    }
    
    static public function getDatosUsuarioEditar($usuario,$password){

          $c= new Criteria();
          $c->add(self::TX_LOGIN,$usuario);
          $c->add(self::TX_PASSWORD,$password);
	  $c->add(self::IN_EDITAR,true);
          $res = self::doSelect($c);

          foreach($res as $result)
            return $result;
    }

    static public function getDatosUsuarioAutorizacion($usuario,$password){

          $c= new Criteria();
          $c->add(self::TX_LOGIN,$usuario);
          $c->add(self::TX_PASSWORD,$password);
	  $c->add(self::IN_AUTORIZAR_NUEVA_SOLICITUD,true);
          $res = self::doSelect($c);

          foreach($res as $result)
            return $result;
    }

    static public function getDatosUsuarioAutorizar($codigo){

          $c= new Criteria();
          $c->add(self::CO_USUARIO,$codigo);
	  $c->add(self::IN_AUTORIZAR_INSPECCION,true);
          $res = self::doSelect($c);

          foreach($res as $result)
            return $result;
    }
    
        static public function getDatosUsuarioConvenio($usuario,$password){

          $c= new Criteria();
          $c->add(self::TX_LOGIN,$usuario);
          $c->add(self::TX_PASSWORD,$password);
	  $c->add(self::IN_AUTORIZAR_CONVENIO,true);
          $res = self::doSelect($c);

          foreach($res as $result)
            return $result;
    }

    static public function getDatosUsuarioExoneracion($usuario,$password){

      $c= new Criteria();
      $c->add(self::TX_LOGIN,$usuario);
      $c->add(self::TX_PASSWORD,$password);
      $c->add(self::IN_AUTORIZAR_EXONERACION,true);
      $res = self::doSelect($c);

      foreach($res as $result)
        return $result;
    }

    static public function getBuscaUsuario($co_usuario){

          $c = new Criteria();

          $c->addAnd(self::CO_USUARIO,$co_usuario);
          $stmt = self::doSelectStmt($c);

          $data="";
          while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
             $data[]=$row;
          }
          return $data;

    }
    
    static public function getDatosUsuarioAdjunto($co_usuario,$password){

          $c= new Criteria();
          $c->add(self::CO_USUARIO,$co_usuario);
          $c->add(self::TX_PASSWORD,$password);
          $c->add(self::IN_ACTIVO,true);
          $res = self::doSelect($c);

          foreach($res as $result)
            return $result;
    }    
}
