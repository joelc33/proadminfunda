<?php

/**
 * Directorio actions.
 *
 * @package    gobel
 * @subpackage Directorio
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class DirectorioActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
   
  }
  
  public function executeAnulado(sfWebRequest $request)
  {
   
  }

  public function executeStorelista(sfWebRequest $request)
  {
   
    $limit         =   $this->getRequestParameter("limit",15);
    $start         =   $this->getRequestParameter("start",0);
    $in_ventanilla =   $this->getRequestParameter("in_ventanilla");
    $co_proceso    =   $this->getRequestParameter("co_proceso");
    $co_solicitud  =   $this->getRequestParameter("co_solicitud");
    
    $co_documento     =   $this->getRequestParameter("co_documento");
    $nu_cedula_rif    =   $this->getRequestParameter("nu_cedula_rif");
    $tx_razon_social  =   $this->getRequestParameter("tx_razon_social");
    $co_tipo_solicitud  =   $this->getRequestParameter("co_tipo_solicitud");
    
    $c = new Criteria();  
    $c->clearSelectColumns();
    
    if($co_documento!=''){
        $c->add(Tb007DocumentoPeer::CO_DOCUMENTO,$co_documento);
    }

    if($nu_cedula_rif!=''){
        $c->add(Tb008ProveedorPeer::TX_RIF,$nu_cedula_rif);
    }

    if($tx_razon_social!=''){
        $c->add(Tb008ProveedorPeer::TX_RAZON_SOCIAL,'%'.$tx_razon_social.'%',Criteria::LIKE);
    }

    if($co_proceso!=''){
        $c->add(Tb030RutaPeer::CO_PROCESO,$co_proceso);
    }
        
    if($co_solicitud!=''){
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD,$co_solicitud);
    }

    if($co_tipo_solicitud!=''){
        $c->add(Tb026SolicitudPeer::CO_TIPO_SOLICITUD,$co_tipo_solicitud);
    }

                              
    $c->setIgnoreCase(true);
    $c->addSelectColumn(Tb030RutaPeer::CO_PROCESO);
    $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);    
    $c->addSelectColumn(Tb001UsuarioPeer::TX_LOGIN);   
    $c->addSelectColumn(Tb026SolicitudPeer::CREATED_AT);  
    $c->addSelectColumn(Tb026SolicitudPeer::CO_PERSONA);  
    $c->addSelectColumn(Tb060OrdenPagoPeer::TX_SERIAL);
    $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
    //$c->addSelectColumn(Tbbn016ReportePeer::CO_REPORTE);
    $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb109PersonaPeer::CO_PROVEEDOR,   Criteria::LEFT_JOIN);
    $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR,Tb008ProveedorPeer::CO_PROVEEDOR,   Criteria::LEFT_JOIN);
    $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO,  Tb007DocumentoPeer::CO_DOCUMENTO,   Criteria::LEFT_JOIN);
    $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb060OrdenPagoPeer::CO_SOLICITUD,   Criteria::LEFT_JOIN);
    $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD,  Criteria::JOIN);
    $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD,  Criteria::JOIN);
    //$c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tbbn016ReportePeer::CO_SOLICITUD,  Criteria::LEFT_JOIN);
    $c->addJoin(Tb030RutaPeer::CO_PROCESO, Tb028ProcesoPeer::CO_PROCESO,   Criteria::JOIN);
    $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO,  Criteria::JOIN);
       
    
    $c->addAnd(Tb030RutaPeer::IN_ANULAR,NULL, Criteria::ISNULL);
    $c->addAnd(Tb030RutaPeer::IN_ACTUAL,true);
    $c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
    
    
    
//    echo $c->toString(); exit();
    
 //   $c->addAnd(Tb026SolicitudPeer::CO_USUARIO,$this->getUser()->getAttribute('codigo'));
    $cantidadTotal = Tb026SolicitudPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addDescendingOrderByColumn(Tb026SolicitudPeer::CO_SOLICITUD);
    
   
    
        
    $stmt = Tb026SolicitudPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){        
        
        $cantidad = Tb026SolicitudPeer::getCantRevision($res["co_solicitud"]);

        $tx_rif = $res["inicial"]."-".$res["tx_rif"];
        $tx_razon_social = strtoupper($res["tx_razon_social"]);
        
        if($res["tx_rif"]==''){
            if($res["co_persona"]!=''){
                $datos_persona = $this->getDatosPersona($res["co_persona"]);
                $tx_rif = $datos_persona["inicial"]."-".$datos_persona["nu_cedula"];
                $tx_razon_social = strtoupper($datos_persona["nb_persona"].' '.$datos_persona["ap_persona"]);
            }            
        }
        
        list($anio,$mes,$dia) = explode('-',$res["created_at"]);
        $registros[] = array(
                "tx_proceso"        => trim($res["tx_proceso"]),
                "co_proceso"        => trim($res["co_proceso"]),
                "tx_tipo_solicitud" => trim($res["tx_tipo_solicitud"]),
                "co_tipo_solicitud" => trim($res["co_tipo_solicitud"]),
                "co_solicitud"      => trim($res["co_solicitud"]),
                "tx_login"          => trim($res["tx_login"]),
                "tx_serial"          => trim($res["tx_serial"]),
                "tx_rif"            => $tx_rif,
                "tx_razon_social"   => $tx_razon_social,
                "fe_creacion"       => $dia.'-'.$mes.'-'.$anio,
                "cant_revision"     => $cantidad,
                "co_ruta_odp"   => $this->getTxRutaReporte(10, $res["co_solicitud"])
                //"co_reporte" => trim($res["co_reporte"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

    public function executeStorelistaanulado(sfWebRequest $request)
    {
   
    $limit         =   $this->getRequestParameter("limit",15);
    $start         =   $this->getRequestParameter("start",0);
    $in_ventanilla =   $this->getRequestParameter("in_ventanilla");
    $co_proceso    =   $this->getRequestParameter("co_proceso");
    $co_solicitud  =   $this->getRequestParameter("co_solicitud");
    
    $co_documento     =   $this->getRequestParameter("co_documento");
    $nu_cedula_rif    =   $this->getRequestParameter("nu_cedula_rif");
    $tx_razon_social  =   $this->getRequestParameter("tx_razon_social");
    
    $c = new Criteria();  
    $c->clearSelectColumns();

    if($co_documento!=''){
        $c->add(Tb007DocumentoPeer::CO_DOCUMENTO,$co_documento);
    }

    if($nu_cedula_rif!=''){
        $c->add(Tb008ProveedorPeer::TX_RIF,$nu_cedula_rif);
    }

    if($tx_razon_social!=''){
        $c->add(Tb008ProveedorPeer::TX_RAZON_SOCIAL,'%'.$tx_razon_social.'%',Criteria::LIKE);
    }

    if($co_proceso!=''){
        $c->add(Tb030RutaPeer::CO_PROCESO,$co_proceso);
    }    
    
    if($co_solicitud!=''){
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD,$co_solicitud);
    }
                              
    $c->setIgnoreCase(true);
    $c->setDistinct();
//    $c->addSelectColumn(Tb030RutaPeer::CO_PROCESO);
//    $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);    
    $c->addSelectColumn(Tb001UsuarioPeer::TX_LOGIN);   
    $c->addSelectColumn(Tb026SolicitudPeer::CREATED_AT);  
    $c->addSelectColumn(Tb026SolicitudPeer::CO_PERSONA);  
    $c->addSelectColumn(Tb060OrdenPagoPeer::TX_SERIAL);
    $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
    $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
    
    $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb109PersonaPeer::CO_PROVEEDOR,   Criteria::LEFT_JOIN);
    $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR,Tb008ProveedorPeer::CO_PROVEEDOR,   Criteria::LEFT_JOIN);
    $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO,  Tb007DocumentoPeer::CO_DOCUMENTO,   Criteria::LEFT_JOIN);
    $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb060OrdenPagoPeer::CO_SOLICITUD,   Criteria::LEFT_JOIN);
    $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD,  Criteria::JOIN);
    $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD,  Criteria::JOIN);
//    $c->addJoin(Tb030RutaPeer::CO_PROCESO, Tb028ProcesoPeer::CO_PROCESO,   Criteria::JOIN);
    $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO,  Criteria::JOIN);
   
    //$c->addAnd(Tb060OrdenPagoPeer::IN_ANULAR,TRUE);
    $c->addAnd(Tb030RutaPeer::IN_ACTUAL,true);
    $c->addAnd(Tb026SolicitudPeer::CO_ESTATUS,4);
    $c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));
    
    $cantidadTotal = Tb026SolicitudPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addDescendingOrderByColumn(Tb026SolicitudPeer::CO_SOLICITUD);
    
        
    $stmt = Tb026SolicitudPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){        
        
        $cantidad = Tb026SolicitudPeer::getCantRevision($res["co_solicitud"]);

        $tx_rif = $res["inicial"]."-".$res["tx_rif"];
        $tx_razon_social = strtoupper($res["tx_razon_social"]);
        
        if($res["tx_rif"]==''){
            if($res["co_persona"]!=''){
                $datos_persona = $this->getDatosPersona($res["co_persona"]);
                $tx_rif = $datos_persona["inicial"]."-".$datos_persona["nu_cedula"];
                $tx_razon_social = strtoupper($datos_persona["nb_persona"].' '.$datos_persona["ap_persona"]);
            }            
        }
        
        list($anio,$mes,$dia) = explode('-',$res["created_at"]);
        $registros[] = array(
                "tx_proceso"        => trim($res["tx_proceso"]),
                "co_proceso"        => trim($res["co_proceso"]),
                "tx_tipo_solicitud" => trim($res["tx_tipo_solicitud"]),
                "co_tipo_solicitud" => trim($res["co_tipo_solicitud"]),
                "co_solicitud"      => trim($res["co_solicitud"]),
                "tx_login"          => trim($res["tx_login"]),
                "tx_serial"          => trim($res["tx_serial"]),
                "tx_rif"            => $tx_rif,
                "tx_razon_social"   => $tx_razon_social,
                "fe_creacion"       => $dia.'-'.$mes.'-'.$anio,
                "cant_revision"     => $cantidad
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }
    
  public function getTxRutaReporte($co_proceso, $co_solicitud)
  {


    $encrip = new myConfig();

    $cp = new Criteria();
    $cp->add(Tb030RutaPeer::CO_SOLICITUD, $co_solicitud);
    $cp->add(Tb030RutaPeer::CO_PROCESO, $co_proceso);
    $stmt = Tb030RutaPeer::doSelectStmt($cp);
    $campos = $stmt->fetch(PDO::FETCH_ASSOC);

    return $encrip->encrypt($campos["co_ruta"]);
  }    
  
}
