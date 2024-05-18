<?php

/**
 * Revision actions.
 *
 * @package    siames
 * @subpackage Revision
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class RevisionActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
    
  //  2135438 - adistraiento de sql - 0412-1688938
  // 
    public function executeIndex(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        
      
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD,$codigo);

        $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb001UsuarioPeer::CO_USUARIO);
        $c->addSelectColumn(Tb001UsuarioPeer::NB_USUARIO);
        $c->addSelectColumn(Tb001UsuarioPeer::NU_CEDULA);
        $c->addSelectColumn(Tb007DocumentoPeer::TIPO);
        $c->addSelectColumn(Tb030RutaPeer::CO_RUTA);
        $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);        
        $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO);
	$c->addJoin(Tb001UsuarioPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
	$c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->add(Tb030RutaPeer::CO_ESTATUS_RUTA,1);
        
        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->data = json_encode(array(
            "co_solicitud"      => $campos["co_solicitud"],
            "co_usuario"        => $campos["co_usuario"],
            "nb_usuario"        => $campos["nb_usuario"],
            "nu_cedula"         => $campos["nu_cedula"],
            "tipo"              => $campos["tipo"],
            "co_ruta"           => $campos["co_ruta"],
            "tx_tipo_solicitud" => $campos["tx_tipo_solicitud"]
        ));
        
        
      
    }else{
        $this->data = json_encode(array(
            "co_solicitud"      => "",
            "co_usuario"        => "",
            "nb_usuario"        => "",
            "nu_cedula"         => "",
            "tipo"              => "",
            "co_ruta"           => "",
            "tx_tipo_solicitud" => ""
        ));
    }
  }
  
  public function executeResponderRevision(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("co_revision");
    if($codigo!=''||$codigo!=null){
        
      
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->add(Tb034RevisionPeer::CO_REVISION,$codigo);

        $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb001UsuarioPeer::CO_USUARIO);
        $c->addSelectColumn(Tb001UsuarioPeer::NB_USUARIO);
        $c->addSelectColumn(Tb001UsuarioPeer::NU_CEDULA);
        $c->addSelectColumn(Tb007DocumentoPeer::TIPO);
        $c->addSelectColumn(Tb030RutaPeer::CO_RUTA);
        $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);        
        $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO);
	$c->addJoin(Tb001UsuarioPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
	$c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb034RevisionPeer::CO_SOLICITUD);
       
        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->data = json_encode(array(
            "co_solicitud"      => $campos["co_solicitud"],
            "co_usuario"        => $campos["co_usuario"],
            "nb_usuario"        => $campos["nb_usuario"],
            "nu_cedula"         => $campos["nu_cedula"],
            "tipo"              => $campos["tipo"],
            "co_ruta"           => $campos["co_ruta"],
            "tx_tipo_solicitud" => $campos["tx_tipo_solicitud"],
            "co_revision"       => $codigo
        ));
        
        
      
    }else{
        $this->data = json_encode(array(
            "co_solicitud"      => "",
            "co_usuario"        => "",
            "nb_usuario"        => "",
            "nu_cedula"         => "",
            "tipo"              => "",
            "co_ruta"           => "",
            "tx_tipo_solicitud" => ""
        ));
    }
  }
    
  public function executeLista(sfWebRequest $request)
  {
        $this->data = json_encode(array(
		"co_rol"         => $this->getUser()->getAttribute('rol'),
		"co_usuario"     => $this->getUser()->getAttribute('codigo'),
	));
  }
  
  protected function  getCoSolicitud($codigo){
        $c = new Criteria();
        $c->add(Tb034RevisionPeer::CO_REVISION,$codigo);
        $stmt = Tb034RevisionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos["co_solicitud"];
  } 
  
  public function executeDetalle(sfWebRequest $request){
      $co_revision = $this->getRequestParameter("codigo");
      
       $this->data = json_encode(array(
            "co_revision"   =>  $co_revision,
            "co_solicitud"  =>  $this->getCoSolicitud($co_revision)
       ));
        
      
  }
  
   public function executeDetalleEntidades(sfWebRequest $request)
    {
            $co_revision = $this->getRequestParameter("codigo");
            $this->tab = "{
                            title: 'Detalle del Tramite',
                            tabWidth:120,
                            autoLoad:{
                            url:'".$_SERVER["SCRIPT_NAME"]."/Revision/detalle',
                            scripts: true,
                            params:{codigo:'".$co_revision."'}
                            }
                        }";

            $this->DatosDetalle();
    }
  
    protected function DatosDetalle(){
        $codigo = $this->getRequestParameter("codigo");
        if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tb034RevisionPeer::CO_REVISION,$codigo);
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);   
        $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);   
        $c->addSelectColumn(Tb029EstatusPeer::TX_ESTATUS);
        $c->addSelectColumn(Tb026SolicitudPeer::CREATED_AT);
        $c->addSelectColumn(Tb026SolicitudPeer::TX_OBSERVACION);
        $c->addSelectColumn(Tb001UsuarioPeer::TX_LOGIN);
        $c->addSelectColumn(Tb001UsuarioPeer::NB_USUARIO);
        
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_ESTATUS, Tb029EstatusPeer::CO_ESTATUS);
        $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb034RevisionPeer::CO_SOLICITUD);
        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        $this->data = json_encode(array(
                            "co_solicitud"       => $campos["co_solicitud"], 
                            "tx_tipo_solicitud"  => $campos["tx_tipo_solicitud"],
                            "tx_estatus"         => $campos["tx_estatus"],
                            "fe_creacion"        => trim(date_format(date_create($campos["created_at"]),'d/m/Y')),
                            "tx_observacion"     => $campos["tx_observacion"],
                            "tx_login"           => $campos["tx_login"],
                            "nb_usuario"         => $campos["nb_usuario"]
                    ));
        }else{
            $this->data = json_encode(array(
                            "co_solicitud"          => "", 
                            "tx_tipo_solicitud"     => "",
                            "tx_estatus"            => "",
                            "fe_creacion"           => "",
                            "tx_observacion"        => "",
                            "tx_login"              => "",
                            "nb_usuario"            => "",
                          
                        ));
        }
   }
  
    //A001 = Estado Motogenerador
    //0 => Apagado Normal
    //1 => Falla Corpoelec => Moto Encendido
    
    //A002 = Tablero de Transferencia
    //0=> Falla
    //1=> Activo
    
    //A003 = Suministro CORPOELEC
    //1= Normal
    //0= Falla
  public function executeStorelista(sfWebRequest $request)
  {
    $paginar      =   $this->getRequestParameter("paginar");
    $limit        =   $this->getRequestParameter("limit",12);
    $start        =   $this->getRequestParameter("start",0);
    $co_proceso   =   $this->getRequestParameter("co_proceso");
    $co_solicitud =   $this->getRequestParameter("co_solicitud");
    
    $c = new Criteria();  
    
    if($co_proceso!=''){
        $c->add(Tb028ProcesoPeer::CO_PROCESO,$co_proceso);
    }
    
    if($co_solicitud!=''){
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD,$co_solicitud);
    }
    
    
    $registro = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));
          
       
    $c->setIgnoreCase(true);
    $c->clearSelectColumns();
    $c->addSelectColumn(Tb034RevisionPeer::CO_REVISION);
    $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);    
    $c->addSelectColumn(Tb001UsuarioPeer::TX_LOGIN);   
    $c->addSelectColumn(Tb026SolicitudPeer::CREATED_AT); 
    $c->addSelectColumn(Tb034RevisionPeer::MIME_DOCUMENTO_RECIBIDO); 
    $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addJoin(Tb028ProcesoPeer::CO_PROCESO, Tb034RevisionPeer::CO_PROCESO);
    $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb034RevisionPeer::CO_SOLICITUD);
    $c->addJoin(Tb034RevisionPeer::CO_USUARIO_ENVIA, Tb001UsuarioPeer::CO_USUARIO);
    $c->add(Tb034RevisionPeer::CO_PROCESO,$registro,Criteria::IN);
    
    $c->add(Tb034RevisionPeer::IN_ACTIVO,true);  
    $c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
    $cantidadTotal = Tb026SolicitudPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb026SolicitudPeer::CO_SOLICITUD);
        
    $stmt = Tb026SolicitudPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    
    list($anio,$mes,$dia) = explode('-',$res["created_at"]);
    $registros[] = array(
            "tx_proceso"        => trim($res["tx_proceso"]),
            "tx_tipo_solicitud" => trim($res["tx_tipo_solicitud"]),
            "co_solicitud"      => trim($res["co_solicitud"]),
            "tx_login"          => trim($res["tx_login"]),
            "fe_creacion"       => $dia.'-'.$mes.'-'.$anio,
            "mime_documento"    => $res["mime_documento_recibido"],
            "co_revision"       => $res["co_revision"]
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }
    
   public function executeGuardarRespuesta(sfWebRequest $request)
  {
        $co_ruta_actual = $this->getRequestParameter("co_ruta");
        $co_proceso = $this->getRequestParameter("co_proceso");
        $co_revision = $this->getRequestParameter("co_revision");
        $tx_observacion = $this->getRequestParameter("tx_observacion");
        
        $serv = "/var/www/html/gobel/respuesta/";

        $ruta = $serv . date("Ym");
        mkdir ($ruta);
        
        $tx_documento_ruta = $ruta.'/respuesta'.$_FILES['form-pdf']["name"];
       
        
	$con = Propel::getConnection();
       
	try
	{ 
            $con->beginTransaction();
	
            
                $tb034_revision = Tb034RevisionPeer::retrieveByPK($co_revision);
                $tb034_revision->setTxRespuesta($tx_observacion)
                            ->setCoUsuarioResp($this->getUser()->getAttribute('codigo'))
                            ->setFeRespuesta(date('Y-m-d'))
                            ->setInActivo(false)
                            ->save($con);


                /*******************DOCUMENTO**************************************/
        
                  
                   if($_FILES["form-pdf"]["size"]<=15000000){
                        if ($_FILES['form-pdf']['type'] == "application/pdf") { 
                      
                        move_uploaded_file($_FILES['form-pdf']['tmp_name'], $tx_documento_ruta); 

                         # Variables del archivo
                        $type = $_FILES["form-pdf"]["type"];
                        $tmp_name = $_FILES["form-pdf"]["tmp_name"];
                        $size = $_FILES["form-pdf"]["size"];
                        $nombre = $_FILES["form-pdf"]["name"];
                        $nombre = basename($_FILES["form-pdf"]["name"]);
                        # Contenido del archivo
                        $fp = fopen($tx_documento_ruta, "rb");


                        $buffer = fread($fp, filesize($tx_documento_ruta));

                         $tb034_revision->setImDocumentoRespuesta($buffer)
                                 ->setMimeDocumentoRespuesta($type)
                                 ->save($con);

                        fclose($fp);
                       
                       }else{
                               $this->data = json_encode(array(
                                   "success" => false,
                                   "co_solicitud_enlace" =>  $co_solicitud_enlace,
                                   "tipo_imagen" => $_FILES['form-file']['type'],
                                   "tipo_pdf" => $_FILES['form-pdf']['type'],
                                   "msg" => 'El documento debe ser un archivo *.pdf'
                               ));

                             echo $this->data;
                             return sfView::NONE;
                             exit();
                       }
                       
                       
                       $cantidad = Tb026SolicitudPeer::getCantRevision($tb034_revision->getCoSolicitud());
                       
                       if($cantidad==0){
                           $solicitud = Tb026SolicitudPeer::retrieveByPK($tb034_revision->getCoSolicitud());
                           $solicitud->setCoEstatus(1)->save($con);
                       }


                       $con->commit($con);
                   }else{

                           $this->data = json_encode(array(
                               "success" => false,
                               "msg" => 'El documento supera el tamaño requerido, tamaño máximo los 2 MB'
                           ));

                           echo $this->data;
                           return sfView::NONE;
                           exit();
                   }
        
        
                /*****************DOCUMENTO***************************************/
        
        
		$this->data = json_encode(array(
			    "success" => true,
                            "msg" => 'Proceso realizado exitosamente!'
		));
                
	$con->commit();
	}catch (PropelException $e)
	{
	$con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
		    "msg" => 'Error al generar la revision'
		));
	}
        echo $this->data;
        
        return sfView::NONE;
        
  }
    
  public function executeGuardar(sfWebRequest $request)
  {
        $co_ruta_actual = $this->getRequestParameter("co_ruta");
        $co_proceso = $this->getRequestParameter("co_proceso");
        $co_solicitud = $this->getRequestParameter("co_solicitud");
        $tx_observacion = $this->getRequestParameter("tx_observacion");
        
        $serv = "/var/www/html/gobel/revision/";

        $ruta = $serv . date("Ym");
        mkdir ($ruta);
        
        $tx_documento_ruta = $ruta.'/recibir'.$_FILES['form-pdf']["name"];
       
        
	$con = Propel::getConnection();
       
	try
	{ 
            $con->beginTransaction();
	
            
                $tb034_revision = new Tb034Revision();
                $tb034_revision->setCoRuta($co_ruta_actual)
                            ->setTxComentario($tx_observacion)
                            ->setCoUsuarioEnvia($this->getUser()->getAttribute('codigo'))
                            ->setFeEnvio(date('Y-m-d'))
                            ->setInActivo('true')
                            ->setCoSolicitud($co_solicitud)
                            ->setCoProceso($co_proceso)
                            ->save($con);


                /*******************DOCUMENTO**************************************/
        
                  
                   if($_FILES["form-pdf"]["size"]<=15000000){
                        if ($_FILES['form-pdf']['type'] == "application/pdf") { 
                      
                        move_uploaded_file($_FILES['form-pdf']['tmp_name'], $tx_documento_ruta); 

                         # Variables del archivo
                        $type = $_FILES["form-pdf"]["type"];
                        $tmp_name = $_FILES["form-pdf"]["tmp_name"];
                        $size = $_FILES["form-pdf"]["size"];
                        $nombre = $_FILES["form-pdf"]["name"];
                        $nombre = basename($_FILES["form-pdf"]["name"]);
                        # Contenido del archivo
                        $fp = fopen($tx_documento_ruta, "rb");


                        $buffer = fread($fp, filesize($tx_documento_ruta));

                         $tb034_revision->setImDocumentoRecibido($buffer)
                                 ->setMimeDocumentoRecibido($type)
                                 ->save($con);

                        fclose($fp);
                       
                       }else{
                               $this->data = json_encode(array(
                                   "success" => false,
                                   "co_solicitud_enlace" =>  $co_solicitud_enlace,
                                   "tipo_imagen" => $_FILES['form-file']['type'],
                                   "tipo_pdf" => $_FILES['form-pdf']['type'],
                                   "msg" => 'El documento debe ser un archivo'
                               ));

                             echo $this->data;
                             return sfView::NONE;
                             exit();
                       }

                       $solicitud = Tb026SolicitudPeer::retrieveByPK($co_solicitud);
                       $solicitud->setCoEstatus(2)->save($con);

                       $con->commit($con);
                   }else{

                           $this->data = json_encode(array(
                               "success" => false,
                               "msg" => 'El documento supera el tamaño requerido, tamaño máximo los 2 MB'
                           ));

                           echo $this->data;
                           return sfView::NONE;
                           exit();
                   }
        
        
                /*****************DOCUMENTO***************************************/
        
        
		$this->data = json_encode(array(
			    "success" => true,
                            "msg" => 'Proceso realizado exitosamente!'
		));
                
	$con->commit();
	}catch (PropelException $e)
	{
	$con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
		    "msg" => 'Error al generar la revision'
		));
	}
        echo $this->data;
        
        return sfView::NONE;
        
  }
    
    

  
   public function executeStorefkcoproceso(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb028ProcesoPeer::doSelectStmt($c);
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
