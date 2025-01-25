<?php

/**
 * ComprobanteAjuste actions.
 *
 * @package    gobel
 * @subpackage ComprobanteAjuste
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class ComprobanteAjusteActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
    public function executeIndex(sfWebRequest $request)
    {     
            $codigo = $this->getRequestParameter("co_solicitud");
           
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::CO_COMPROBANTE_AJUSTE);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::CO_PARTIDA_AJUSTE);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::CO_PARTIDA_NUEVA);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::CO_SOLICITUD);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::TX_DESCRIPCION);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::CREATED_AT);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::CO_USUARIO);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::MO_AJUSTE);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::NU_ODP);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::CO_SOLICITUD_AJUSTE);
            $c->add(Tb168ComprobanteAjustePeer::CO_SOLICITUD,$codigo); 

            $stmt = Tb168ComprobanteAjustePeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->data = json_encode(array(
                                "co_comprobante_ajuste"     => ($campos["co_comprobante_ajuste"]==null)?'':$campos["co_comprobante_ajuste"],
                                "co_partida_ajuste"         => ($campos["co_partida_ajuste"]==null)?'':$campos["co_partida_ajuste"],
                                "co_partida_nueva"          => ($campos["co_partida_nueva"]==null)?'':$campos["co_partida_nueva"],
                                "created_at"                => ($campos["created_at"]==null)?'':$campos["created_at"],
                                "tx_descripcion"            => ($campos["tx_descripcion"]==null)?'':$campos["tx_descripcion"],
                                "co_solicitud"              => $this->getRequestParameter("co_solicitud"),
                                "co_usuario"                => ($campos["co_usuario"]==null)?'':$campos["co_usuario"],
                                "mo_ajuste"                 => ($campos["mo_ajuste"]==null)?'':$campos["mo_ajuste"],
                                "co_solicitud_ajuste"       => ($campos["co_solicitud_ajuste"]==null)?'':$campos["co_solicitud_ajuste"],
                                "nu_odp"                    => ($campos["nu_odp"]==null)?'':$campos["nu_odp"]
            ));
        
    }
    
    public function executeIndexContabilidad(sfWebRequest $request)
    {     

            $this->data = json_encode(array(
                                "co_solicitud"              => $this->getRequestParameter("co_solicitud")
            ));
        
    }
    
  public function executeIndexSolicitud(sfWebRequest $request)
  {
    $this->data = json_encode(array(
      "co_rol"            => $this->getUser()->getAttribute('rol'),
      "co_usuario"        => $this->getUser()->getAttribute('codigo'),
      "in_activo"         => $this->getUser()->getAttribute('in_activo'),
      "tx_tipo_solicitud" => $this->getRequestParameter("tx_tipo_solicitud"),
      "co_tipo_solicitud" => 47,
      "tx_url"            => $this->getRequestParameter("tx_url"),

    ));

    $this->getRequest()->setAttribute('in_activo', $this->getUser()->getAttribute('in_activo'));
  }    
    
    public function executeDistribucion(sfWebRequest $request)
    {     

            $this->data = json_encode(array(
                                "co_solicitud"              => $this->getRequestParameter("co_solicitud")
            ));
        
    }    

    public function executeCierreFiscal(sfWebRequest $request)
    {     

           $con = Propel::getConnection();
           $sql ="SELECT (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH - 1 day')::DATE as last_day, (date_trunc('MONTH',fecha_cierre::date) + INTERVAL ' MONTH + 0 day')::DATE as first_day,EXTRACT(YEAR FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL ' MONTH + 0 day')::DATE) AS year,EXTRACT(MONTH FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL ' MONTH + 0 day')::DATE) AS month from 
tb180_maestro_contable order by co_maestro_contable desc limit 1";
           $stmt = $con->prepare($sql);
           $stmt->execute(); 

           $next_month = $stmt->fetch(PDO::FETCH_ASSOC); 
           
        $c = new Criteria();
        $c->clearSelectColumns();        
        $c->addSelectColumn(Tb176ComprobanteContablePeer::CO_COMPROBANTE_CONTABLE);  
        $c->add(Tb176ComprobanteContablePeer::NU_ANIO,$next_month["year"]);
        $c->add(Tb176ComprobanteContablePeer::CO_TIPO_ASIENTO,16);
        $stmt1 = Tb176ComprobanteContablePeer::doSelectStmt($c);
        $res = $stmt1->fetch(PDO::FETCH_ASSOC);
        
        $c1 = new Criteria();
        $c1->clearSelectColumns();        
        $c1->addSelectColumn(Tb200CierreContablePeer::CO_CIERRE_CONTABLE);  
        $c1->add(Tb200CierreContablePeer::CO_SOLICITUD,$this->getRequestParameter("co_solicitud"));
        $stmt2 = Tb200CierreContablePeer::doSelectStmt($c1);
        $res2 = $stmt2->fetch(PDO::FETCH_ASSOC);        
        
           $this->data = json_encode(array(
            "co_solicitud"   => $this->getRequestParameter("co_solicitud"),
            "ejercicio"   => $next_month["year"],
            "fecha"   => $next_month["last_day"],
            "mes"   => $next_month["month"],
            "co_comprobante_contable"   => $res["co_comprobante_contable"],
            "co_cierre_contable"   => $res2["co_cierre_contable"]
        ));        
        
        
    }    
    
    public function executeAprobarAjusteContable(sfWebRequest $request)
    {     
        
            $c = new Criteria();
            $c->add(Tb194AjusteContablePeer::CO_SOLICITUD,$this->getRequestParameter("co_solicitud"));
            $c->add(Tb194AjusteContablePeer::IN_RECHAZADO,FALSE);
            $c->add(Tb194AjusteContablePeer::IN_APROBADO,NULL, Criteria::ISNULL);
            

            $cantidadTotal = Tb194AjusteContablePeer::doCount($c);
//            var_dump($cantidadTotal);
//            exit();
            if($cantidadTotal==0){
            $this->data = json_encode(array(
                "co_solicitud"              => $this->getRequestParameter("co_solicitud"),
                "procesado"              => 1
            ));
                
            }else{
            $this->data = json_encode(array(
                                "co_solicitud"              => $this->getRequestParameter("co_solicitud"),
                                "procesado"              => 0
            ));                
            }

        
    }
    
    public function executeAprobarDistribucion(sfWebRequest $request)
    {     
        
            $c = new Criteria();
            $c->add(Tb194AjusteContablePeer::CO_SOLICITUD,$this->getRequestParameter("co_solicitud"));
            $c->add(Tb194AjusteContablePeer::IN_RECHAZADO,FALSE);
            $c->add(Tb194AjusteContablePeer::IN_APROBADO,NULL, Criteria::ISNULL);
            

            $cantidadTotal = Tb194AjusteContablePeer::doCount($c);
//            var_dump($cantidadTotal);
//            exit();
            if($cantidadTotal==0){
            $this->data = json_encode(array(
                "co_solicitud"              => $this->getRequestParameter("co_solicitud"),
                "procesado"              => 1
            ));
                
            }else{
            $this->data = json_encode(array(
                                "co_solicitud"              => $this->getRequestParameter("co_solicitud"),
                                "procesado"              => 0
            ));                
            }

        
    }    
    
    public function executeAprobarCierreFiscal(sfWebRequest $request)
    {     
        
            $c = new Criteria();
            $c->add(Tb200CierreContablePeer::CO_SOLICITUD,$this->getRequestParameter("co_solicitud"));
            $c->add(Tb200CierreContablePeer::IN_RECHAZADO,FALSE);
            $c->add(Tb200CierreContablePeer::IN_APROBADO,NULL, Criteria::ISNULL);
            

            $cantidadTotal = Tb200CierreContablePeer::doCount($c);
//            var_dump($cantidadTotal);
//            exit();
            if($cantidadTotal==0){
            $this->data = json_encode(array(
                "co_solicitud"              => $this->getRequestParameter("co_solicitud"),
                "procesado"              => 1
            ));
                
            }else{
            $this->data = json_encode(array(
                                "co_solicitud"              => $this->getRequestParameter("co_solicitud"),
                                "procesado"              => 0
            ));                
            }

        
    }    
    
    public function executeAprobacion(sfWebRequest $request)
    {     
            $codigo = $this->getRequestParameter("co_solicitud");
           
            $c = new Criteria();
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::CO_COMPROBANTE_AJUSTE);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::CO_PARTIDA_AJUSTE);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::CO_PARTIDA_NUEVA);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::CO_SOLICITUD);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::TX_DESCRIPCION);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::CREATED_AT);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::CO_USUARIO);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::MO_AJUSTE);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::CO_SOLICITUD_AJUSTE);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::IN_PROCESADO);
            $c->addSelectColumn(Tb168ComprobanteAjustePeer::NU_ODP);
            $c->add(Tb168ComprobanteAjustePeer::CO_SOLICITUD,$codigo); 

            $stmt = Tb168ComprobanteAjustePeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->data = json_encode(array(
                                "co_comprobante_ajuste"     => ($campos["co_comprobante_ajuste"]==null)?'':$campos["co_comprobante_ajuste"],
                                "co_partida_ajuste"         => ($campos["co_partida_ajuste"]==null)?'':$campos["co_partida_ajuste"],
                                "co_partida_nueva"          => ($campos["co_partida_nueva"]==null)?'':$campos["co_partida_nueva"],
                                "created_at"                => ($campos["created_at"]==null)?'':$campos["created_at"],
                                "tx_descripcion"            => ($campos["tx_descripcion"]==null)?'':$campos["tx_descripcion"],
                                "co_solicitud"              => $this->getRequestParameter("co_solicitud"),
                                "co_usuario"                => ($campos["co_usuario"]==null)?'':$campos["co_usuario"],
                                "mo_ajuste"                 => ($campos["mo_ajuste"]==null)?'':$campos["mo_ajuste"],
                                "co_solicitud_ajuste"       => ($campos["co_solicitud_ajuste"]==null)?'':$campos["co_solicitud_ajuste"],
                                "in_procesado"              => ($campos["in_procesado"]==null)?'':$campos["in_procesado"],
                                "nu_odp"                    => ($campos["nu_odp"]==null)?'':$campos["nu_odp"]
            ));
        
    }
    
    public function executeBuscarCuenta(sfWebRequest $request)
    {     

        
    }    
    
    public function executeCambiarEstado(sfWebRequest $request)
    {
        $co_comprobante_ajuste = $this->getRequestParameter('co_comprobante_ajuste');
        $co_solicitud = $this->getRequestParameter('co_solicitud');
        
        $con = Propel::getConnection();
        
        try
        { 
            $con->beginTransaction(); 
        
            $c = new Criteria();
            $c->clearSelectColumns();    
            $c->setDistinct();
            $c->addSelectColumn(Tb172PartidaComprobanteAjustePeer::CO_PARTIDA_AFECTADA);
            $c->addSelectColumn(Tb172PartidaComprobanteAjustePeer::CO_PARTIDA_DESAFECTADA);
            $c->addSelectColumn(Tb172PartidaComprobanteAjustePeer::NU_MONTO);
            $c->addSelectColumn(Tb172PartidaComprobanteAjustePeer::CO_DETALLE_COMPRA);
           // $c->addSelectColumn(Tb087PresupuestoMovimientoPeer::CO_PRESUPUESTO_MOVIMIENTO);
            $c->addSelectColumn(Tb087PresupuestoMovimientoPeer::CO_TIPO_MOVIMIENTO);
            
            $c->add(Tb172PartidaComprobanteAjustePeer::CO_COMPROBANTE_AJUSTE,$co_comprobante_ajuste);
            $c->addJoin(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, Tb172PartidaComprobanteAjustePeer::CO_DETALLE_COMPRA);
            $c->add(Tb087PresupuestoMovimientoPeer::IN_ANULAR,NULL);
            
           

            $stmt = Tb172PartidaComprobanteAjustePeer::doSelectStmt($c);

            $registros = array();

            while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
           
                $wherec = new Criteria();
                $wherec->add(Tb087PresupuestoMovimientoPeer::CO_DETALLE_COMPRA, $res["co_detalle_compra"]);
                $wherec->add(Tb087PresupuestoMovimientoPeer::CO_PARTIDA, $res["co_partida_desafectada"]);

                $updc = new Criteria();
                $updc->add(Tb087PresupuestoMovimientoPeer::CO_SOLICITUD_ANULAR, $co_solicitud);
                $updc->add(Tb087PresupuestoMovimientoPeer::IN_ANULAR, TRUE);
                BasePeer::doUpdate($wherec, $updc, $con);  
                
                $tb085Desafectada = Tb085PresupuestoPeer::retrieveByPK($res["co_partida_desafectada"]);
                $tb085Afectada    = Tb085PresupuestoPeer::retrieveByPK($res["co_partida_afectada"]);
                
                if($res["co_tipo_movimiento"]==1){
                    
                    
                    $montoComprometido = $tb085Desafectada->getMoComprometido()-$res["nu_monto"];
                    $tb085Desafectada->setMoComprometido($montoComprometido)->save($con);
                   
                    
//                    $montoComprometido = $tb085Afectada->getMoComprometido()+$res["nu_monto"];
//                    $tb085Afectada->setMoComprometido($montoComprometido)->save($con);
                    
                    $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                    $tb087_presupuesto_movimiento->setCoPartida($res["co_partida_afectada"])
                                             ->setCoTipoMovimiento(1)
                                             ->setNuMonto($res["nu_monto"])
                                             ->setNuAnio( $this->getUser()->getAttribute('ejercicio'))
                                             ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                             ->setCoDetalleCompra($res["co_detalle_compra"])
                                             ->setInActivo(false)
                                             ->save($con);
                    
                }
                
                if($res["co_tipo_movimiento"]==2){
                    
                    $montoCausado = $tb085Desafectada->getMoCausado()-$res["nu_monto"];
                    $tb085Desafectada->setMoCausado($montoCausado)->save($con);
                   
//                    $montoCausado = $tb085Afectada->getMoCausado()+$res["nu_monto"];
//                    $tb085Afectada->setMoCausado($montoCausado)->save($con);
                    
                    $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                    $tb087_presupuesto_movimiento->setCoPartida($res["co_partida_afectada"])
                                             ->setCoTipoMovimiento(2)
                                             ->setNuMonto($res["nu_monto"])
                                             ->setNuAnio( $this->getUser()->getAttribute('ejercicio'))
                                             ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                             ->setCoDetalleCompra($res["co_detalle_compra"])
                                             ->setInActivo(false)
                                             ->save($con);                    
                }
                
                if($res["co_tipo_movimiento"]==3){
                    
                    $montoPagado = $tb085Desafectada->getMoPagado()-$res["nu_monto"];
                    $tb085Desafectada->setMoPagado($montoPagado)->save($con);
                    
                    $montoPagado = $tb085Afectada->getMoPagado()+$res["nu_monto"];
                   // echo $montoPagado.'-'.$res["co_partida_afectada"]; exit(); 
                   
                    $tb085Afectada->setMoPagado($montoPagado)->save($con);
                    
                    $tb087_presupuesto_movimiento = new Tb087PresupuestoMovimiento();
                    $tb087_presupuesto_movimiento->setCoPartida($res["co_partida_afectada"])
                                             ->setCoTipoMovimiento(3)
                                             ->setNuMonto($res["nu_monto"])
                                             ->setNuAnio( $this->getUser()->getAttribute('ejercicio'))
                                             ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                             ->setCoDetalleCompra($res["co_detalle_compra"])
                                             ->setInActivo(false)
                                             ->save($con);    
                    
                }
                
            }        
            
            $Tb168ComprobanteAjuste = Tb168ComprobanteAjustePeer::retrieveByPK($co_comprobante_ajuste);
            $Tb168ComprobanteAjuste->setInProcesado(TRUE)->save($con);
            
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud)); 
            $ruta->setInCargarDato(true)->save($con);
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta()); 

            $this->data = json_encode(array(
                        "success" => true,
                        "msg" => 'El comprobante de ajuste se procesó exitosamente'
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
        $tb168_comprobante_ajusteForm = $this->getRequestParameter('tb168_comprobante_ajuste');
        $json_partida                 = $this->getRequestParameter('json_partida');
        
        $con = Propel::getConnection();
        
        try
        { 
          $con->beginTransaction();  
                   
          if($tb168_comprobante_ajusteForm["co_comprobante_ajuste"]=='')
            $tb168_comprobante_ajuste = new Tb168ComprobanteAjuste();
          else
            $tb168_comprobante_ajuste = Tb168ComprobanteAjustePeer::retrieveByPK($tb168_comprobante_ajusteForm["co_comprobante_ajuste"]);
          
          $tb168_comprobante_ajuste->setCoSolicitudAjuste($tb168_comprobante_ajusteForm["co_solicitud_ajuste"])
                                   ->setNuOdp($tb168_comprobante_ajusteForm["nu_odp"])
                                   ->setTxDescripcion($tb168_comprobante_ajusteForm["tx_tipo_solicitud"])
                                   ->setCoSolicitud($tb168_comprobante_ajusteForm["co_solicitud"])
                                   ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                   ->save($con);
          
          
          
            $listaPartida  = json_decode($json_partida,true);
            $array_partida = array();
            $i=0;
            
            foreach($listaPartida  as $v){      
                
                if ($v["co_partida_comprobante_ajuste"]==''){                    
                    $tb172_partida_comprobante_ajuste = new Tb172PartidaComprobanteAjuste();
                    $tb172_partida_comprobante_ajuste->setCoComprobanteAjuste($tb168_comprobante_ajuste->getCoComprobanteAjuste())
                                                     ->setCoPartidaAfectada($v["co_partida_afectada"])
                                                     ->setCoPartidaDesafectada($v["co_partida_desafectada"])
                                                     ->setNuMonto($v["monto"])
                                                     ->setCoDetalleCompra($v["co_detalle_compras"])
                                                     ->save($con);                   
                }
            }
            
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb168_comprobante_ajusteForm["co_solicitud"])); 
            $ruta->setInCargarDato(true)->save($con);
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta()); 
          
          

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
    
    public function executeGuardarAjusteContable(sfWebRequest $request)
    {
        $co_solicitud = $this->getRequestParameter('co_solicitud');
        $json_cuenta                 = $this->getRequestParameter('json_cuenta');
        
        $con = Propel::getConnection();
        
        try
        { 
          $con->beginTransaction();  
                           
                if($co_solicitud=='' || $co_solicitud==null){
                $tb026_solicitudForm = array(
                    "co_tipo_solicitud"   => 47,
                    "ejercicio"           => $this->getUser()->getAttribute('ejercicio'),
                    "fe_solicitud"        => date("d/m/Y"),
                    "observacion"         => "Comprobante Contable",
                    "codigo"              =>  $this->getUser()->getAttribute('codigo')
                );
    
                $resp = Tb026SolicitudPeer::setSolicitud($tb026_solicitudForm, $con);
    
                if ($resp["success"] == true) {
                    $co_solicitud = $resp["co_solicitud"];
                } else {
                    $this->data = json_encode(array(
                        "success" => false,
                        "msg" =>  $resp["msg"]
                    ));
    
                    return;
                }
                }
          
            $listaCuenta  = json_decode($json_cuenta,true);
            $mo_debe = 0;
            $mo_haber = 0;

            foreach($listaCuenta  as $v){
                 
            $fecha = $v["fecha"];
            $mo_debe = $mo_debe + $v["mo_debito"];
            $mo_haber = $mo_haber + $v["mo_credito"];
            }  
            

            
             list($anio,$mes,$dia ) = explode("-", $fecha);           
            
           $sql_correlativo ="SELECT  extract(year from '".$fecha."'::date)||''||lpad(cast(extract(month from '".$fecha."'::date) as varchar(2)), 2, '0')||''||lpad((count(distinct co_solicitud)+1::numeric)::text, 4, '0') as nu_comprobante 
	   FROM  tb194_ajuste_contable as t1
	   WHERE extract(year from fecha) = extract(year from '".$fecha."'::date) AND extract(month from fecha) = extract(month from '".$fecha."'::date) and in_aprobado = true";


           
           $stmt1 = $con->prepare($sql_correlativo);
           $stmt1->execute();            
           $correlativo = $stmt1->fetch(PDO::FETCH_ASSOC); 
           
            $c = new Criteria();
            $c->clearSelectColumns();    
            $c->addSelectColumn(Tb176ComprobanteContablePeer::CO_COMPROBANTE_CONTABLE);
            $c->addSelectColumn(Tb176ComprobanteContablePeer::IN_CONTABILIZADO);
            $c->add(Tb176ComprobanteContablePeer::CO_SOLICITUD,$co_solicitud);
            $stmt = Tb176ComprobanteContablePeer::doSelectStmt($c);

            $res = $stmt->fetch(PDO::FETCH_ASSOC);      
           
            if($res["co_comprobante_contable"]!='' || $res["co_comprobante_contable"]!=null){
                
        if($res["in_contabilizado"]==true){
            
		$this->data = json_encode(array(
		    "success" => false,
		    "msg" => 'No se pueden agregar mas registros ya que el comprobante fue contabilizado. Verifique!'
		));  
                echo $this->data;
                return sfView::NONE;            
            
        }else{                
                
            $Tb176ComprobanteContable = Tb176ComprobanteContablePeer::retrieveByPK($res["co_comprobante_contable"]);   
            $Tb176ComprobanteContable->setCoUsuario($this->getUser()->getAttribute('codigo'))
                              ->setMoDebito($mo_debe)
                              ->setMoCredito($mo_haber)
                              ->setInContabilizado(FALSE)
                              ->setInCerrado(FALSE)
                              ->setFeContabilizado(date("Y-m-d"))
                              ->setCoSolicitud($co_solicitud)
                              ->save($con);            
            }
            }else{
            $Tb176ComprobanteContable = new Tb176ComprobanteContable();
            $Tb176ComprobanteContable->setCoUsuario($this->getUser()->getAttribute('codigo'))
                              ->setMoDebito($mo_debe)
                              ->setMoCredito($mo_haber)
                              ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                              ->setCoTipoAsiento(15)
                              ->setFeComprobante($fecha)
                              ->setCreatedAt(date("Y-m-d"))
                              ->setInContabilizado(FALSE)
                              ->setInCerrado(FALSE)
                                ->setFeContabilizado(date("Y-m-d"))
                              ->setCoSolicitud($co_solicitud)
                              ->save($con);
            
//            $nu_comprobante = $anio.str_pad($mes, 2, "0", STR_PAD_LEFT).str_pad($Tb176ComprobanteContable->getCoComprobanteContable(), 5, "0", STR_PAD_LEFT);
//            $Tb176ComprobanteContable->setNuComprobante($nu_comprobante)->save($con);
            }
            
           

//                var_dump($sql_correlativo);
//           exit();      
            foreach($listaCuenta  as $v){    
                
                if ($v["co_ajuste_contable"]==''){                    
                    $tb194_asiento_contable = new Tb194AjusteContable();
                    $tb194_asiento_contable->setCoSolicitud($co_solicitud)
                     ->setCoCuentaContable($v["co_cuenta_contable"])
                     ->setMoDebe($v["mo_debito"])
                     ->setMoHaber($v["mo_credito"])
                     ->setFecha($v["fecha"])
                     ->setDescripcion($v["descripcion"])
                     ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                     ->setCoTipoAsiento($v["co_tipo_asiento"])
                     ->setNuComprobante($correlativo["nu_comprobante"])
                     ->setInAprobado(true)
                     ->setInRechazado(false)
                     ->save($con);
                    
                    $tb061_aiento_contable = new Tb061AsientoContable();
                    $tb061_aiento_contable->setCoSolicitud($co_solicitud);
                    $tb061_aiento_contable->setCoCuentaContable($v["co_cuenta_contable"]);
                    $tb061_aiento_contable->setMoDebe($v["mo_debito"]);
                    $tb061_aiento_contable->setMoHaber($v["mo_credito"]);
                    $tb061_aiento_contable->setCreatedAt($v["fecha"]);
                    $tb061_aiento_contable->setCoUsuario($this->getUser()->getAttribute('codigo'));
                    $tb061_aiento_contable->setCoTipoAsiento(15);
                    $tb061_aiento_contable->setNuComprobante($Tb176ComprobanteContable->getCoComprobanteContable());
                    $tb061_aiento_contable->setInActivo(TRUE);
                    $tb061_aiento_contable->save($con); 

                    $Tb177DetComprobante = new Tb177DetComprobante();
                    $Tb177DetComprobante->setCoComprobanteContable($Tb176ComprobanteContable->getCoComprobanteContable())
                                        ->setMoCredito($v["mo_credito"])
                                        ->setMoDebito($v["mo_debito"])                       
                                        ->setCoCuentaContable($v["co_cuenta_contable"])
                                        ->setCoSolicitud($co_solicitud)
                                        ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                        ->setFeMovimiento($v["fecha"])
                                        ->save($con);     
                    
//                    $tb024_cuenta_contable = Tb024CuentaContablePeer::retrieveByPK($v["co_cuenta_contable"]);
//
//                    $tb024_cuenta_contable->setPreCre($tb024_cuenta_contable->getPreCre() + $v["mo_credito"]);
//
//                    $tb024_cuenta_contable->setPreDeb($tb024_cuenta_contable->getPreDeb() + $v["mo_debito"]);
//
//                    $tb024_cuenta_contable->save($con);                     

                    
                }
            }
            
              
            
         if($mo_debe==$mo_haber){
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud)); 
            $ruta->setInCargarDato(true)->save($con);                   
        }else{
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud)); 
            $ruta->setInCargarDato(false)->save($con);             
        }           


            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta()); 
          
          

          $this->data = json_encode(array(
                      "success" => true,
                      "msg" => 'Proceso realizado exitosamente'
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
    
    
    public function executeGuardarAprobarAjuste(sfWebRequest $request)
    {
        $co_solicitud = $this->getRequestParameter('co_solicitud');
        $json_cuenta                 = $this->getRequestParameter('json_cuenta');
        
        $con = Propel::getConnection();
        
        try
        { 
          $con->beginTransaction();  
                           
           
           $sql ="SELECT (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '2 MONTH - 1 day')::DATE as last_day, (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE as first_day,EXTRACT(YEAR FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE) AS year,EXTRACT(MONTH FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE) AS month from 
tb180_maestro_contable order by co_maestro_contable desc limit 1";
           $stmt = $con->prepare($sql);
           $stmt->execute(); 

           $next_month = $stmt->fetch(PDO::FETCH_ASSOC);       
           
           $sql_correlativo =" SELECT  extract(year from '".$next_month["last_day"]."'::date)||''||lpad(cast(extract(month from '".$next_month["last_day"]."'::date) as varchar(2)), 2, '0')||''||lpad((count(distinct co_solicitud)+1::numeric)::text, 4, '0') as nu_comprobante 
	   FROM  tb194_ajuste_contable as t1
	   WHERE extract(year from fecha) = extract(year from '".$next_month["last_day"]."'::date) AND extract(month from fecha) = extract(month from '".$next_month["last_day"]."'::date) and in_aprobado = true";

           $stmt1 = $con->prepare($sql_correlativo);
           $stmt1->execute();            
           $correlativo = $stmt1->fetch(PDO::FETCH_ASSOC);          
          
            $listaCuenta  = json_decode($json_cuenta,true);
            $mo_debe = 0;
            $mo_haber = 0;
            foreach($listaCuenta  as $v){
            $tb194_asiento_contable = Tb194AjusteContablePeer::retrieveByPK($v["co_ajuste_contable"]);
            $mo_debe = $mo_debe + $tb194_asiento_contable->getMoDebe();
            $mo_haber = $mo_haber + $tb194_asiento_contable->getMoHaber();
            }
            
            $Tb176ComprobanteContable = new Tb176ComprobanteContable();
            $Tb176ComprobanteContable->setCoUsuario($this->getUser()->getAttribute('codigo'))
                              ->setMoDebito($mo_debe)
                              ->setMoCredito($mo_haber)
                              ->setNuAnio($next_month["year"])
                              ->setCoTipoAsiento(15)
                              ->setFeComprobante($v["fecha"])
                              ->setCreatedAt(date("Y-m-d"))
                              ->setInContabilizado(TRUE)
                              ->setInCerrado(FALSE)
                              ->save($con); 
            
            $nu_comprobante = $next_month["year"].str_pad($next_month["month"], 2, "0", STR_PAD_LEFT).str_pad($Tb176ComprobanteContable->getCoComprobanteContable(), 5, "0", STR_PAD_LEFT);
            $Tb176ComprobanteContable->setNuComprobante($nu_comprobante)->save($con);            
            
            
            foreach($listaCuenta  as $v){    
 
                          
                 
                    $tb194_asiento_contable = Tb194AjusteContablePeer::retrieveByPK($v["co_ajuste_contable"]); 
                    $tb194_asiento_contable->setInAprobado(true)
                                           ->setNuComprobante($correlativo["nu_comprobante"])
                                           ->save($con); 
                    
                    $tb061_aiento_contable = new Tb061AsientoContable();
                    $tb061_aiento_contable->setCoSolicitud($tb194_asiento_contable->getCoSolicitud());
                    $tb061_aiento_contable->setCoCuentaContable($tb194_asiento_contable->getCoCuentaContable());
                    $tb061_aiento_contable->setMoDebe($tb194_asiento_contable->getMoDebe());
                    $tb061_aiento_contable->setMoHaber($tb194_asiento_contable->getMoHaber());
                    $tb061_aiento_contable->setCreatedAt($tb194_asiento_contable->getFecha());
                    $tb061_aiento_contable->setCoUsuario($this->getUser()->getAttribute('codigo'));
                    $tb061_aiento_contable->setCoTipoAsiento(15);
                    $tb061_aiento_contable->setNuComprobante($nu_comprobante);
                    $tb061_aiento_contable->setInActivo(TRUE);
                    $tb061_aiento_contable->save($con); 
                    
                    $Tb177DetComprobante = new Tb177DetComprobante();
                    $Tb177DetComprobante->setCoComprobanteContable($Tb176ComprobanteContable->getCoComprobanteContable())
                                        ->setMoCredito($tb194_asiento_contable->getMoHaber())
                                        ->setMoDebito($tb194_asiento_contable->getMoDebe())                       
                                        ->setCoCuentaContable($tb194_asiento_contable->getCoCuentaContable())
                                        ->setCoSolicitud($tb194_asiento_contable->getCoSolicitud())
                                        ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                        ->setFeMovimiento($v["fecha"])
                                        ->save($con);     
                    
                    $tb024_cuenta_contable = Tb024CuentaContablePeer::retrieveByPK($tb194_asiento_contable->getCoCuentaContable());

                    $tb024_cuenta_contable->setPreCre($tb024_cuenta_contable->getPreCre() + $tb194_asiento_contable->getMoHaber());

                    $tb024_cuenta_contable->setPreDeb($tb024_cuenta_contable->getPreDeb() + $tb194_asiento_contable->getMoDebe());

                    $tb024_cuenta_contable->save($con);                    
                    
                    
            }
            $con->commit();
            
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud)); 
            $ruta->setInCargarDato(true)->save($con);
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta()); 
          
          

          $this->data = json_encode(array(
                      "success" => true,
                      "msg" => 'Proceso realizado exitosamente'
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
    
    public function executeGuardarAprobarDistribucion(sfWebRequest $request)
    {
        $co_solicitud = $this->getRequestParameter('co_solicitud');
        $json_cuenta                 = $this->getRequestParameter('json_cuenta');
        
        $con = Propel::getConnection();
        
        try
        { 
          $con->beginTransaction();  
                           
           
           $sql ="SELECT (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH - 1 day')::DATE as last_day, (date_trunc('MONTH',fecha_cierre::date) + INTERVAL ' MONTH + 0 day')::DATE as first_day,EXTRACT(YEAR FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL ' MONTH + 0 day')::DATE) AS year from 
tb180_maestro_contable order by co_maestro_contable desc limit 1";
           $stmt = $con->prepare($sql);
           $stmt->execute(); 

           $next_month = $stmt->fetch(PDO::FETCH_ASSOC);       
           
           $sql_correlativo =" SELECT  extract(year from '".$next_month["last_day"]."'::date)||''||lpad(cast(extract(month from '".$next_month["last_day"]."'::date) as varchar(2)), 2, '0')||''||lpad((count(distinct co_solicitud)+1::numeric)::text, 4, '0') as nu_comprobante 
	   FROM  tb194_ajuste_contable as t1
	   WHERE extract(year from fecha) = extract(year from '".$next_month["last_day"]."'::date) AND extract(month from fecha) = extract(month from '".$next_month["last_day"]."'::date) and in_aprobado = true";

           $stmt1 = $con->prepare($sql_correlativo);
           $stmt1->execute();            
           $correlativo = $stmt1->fetch(PDO::FETCH_ASSOC);          
          
            $listaCuenta  = json_decode($json_cuenta,true);
            $mo_debe = 0;
            $mo_haber = 0;
            foreach($listaCuenta  as $v){
            $tb194_asiento_contable = Tb194AjusteContablePeer::retrieveByPK($v["co_ajuste_contable"]);
            $mo_debe = $mo_debe + $tb194_asiento_contable->getMoDebe();
            $mo_haber = $mo_haber + $tb194_asiento_contable->getMoHaber();
            }
            
            $Tb176ComprobanteContable = new Tb176ComprobanteContable();
            $Tb176ComprobanteContable->setCoUsuario($this->getUser()->getAttribute('codigo'))
                              ->setMoDebito($mo_debe)
                              ->setMoCredito($mo_haber)
                              ->setNuAnio($next_month["year"])
                              ->setCoTipoAsiento(17)
                              ->setFeComprobante($v["fecha"])
                              ->setCreatedAt(date("Y-m-d"))
                              ->setInContabilizado(TRUE)
                              ->setInCerrado(true)
                              ->setFeContabilizado($next_month["last_day"])
                              ->setFeCerrado($next_month["last_day"])                    
                              ->save($con); 
            
            $nu_comprobante = $next_month["year"].str_pad($next_month["month"], 2, "0", STR_PAD_LEFT).str_pad($Tb176ComprobanteContable->getCoComprobanteContable(), 5, "0", STR_PAD_LEFT);
            $Tb176ComprobanteContable->setNuComprobante($nu_comprobante)->save($con);            
            
            
            foreach($listaCuenta  as $v){    
 
                          
                 
                    $tb194_asiento_contable = Tb194AjusteContablePeer::retrieveByPK($v["co_ajuste_contable"]); 
                    $tb194_asiento_contable->setInAprobado(true)
                                           ->setNuComprobante($correlativo["nu_comprobante"])
                                           ->save($con); 
                    
                    $tb061_aiento_contable = new Tb061AsientoContable();
                    $tb061_aiento_contable->setCoSolicitud($tb194_asiento_contable->getCoSolicitud());
                    $tb061_aiento_contable->setCoCuentaContable($tb194_asiento_contable->getCoCuentaContable());
                    $tb061_aiento_contable->setMoDebe($tb194_asiento_contable->getMoDebe());
                    $tb061_aiento_contable->setMoHaber($tb194_asiento_contable->getMoHaber());
                    $tb061_aiento_contable->setCreatedAt($tb194_asiento_contable->getFecha());
                    $tb061_aiento_contable->setCoUsuario($this->getUser()->getAttribute('codigo'));
                    $tb061_aiento_contable->setCoTipoAsiento(17);
                    $tb061_aiento_contable->setNuComprobante($nu_comprobante);
                    $tb061_aiento_contable->setInActivo(TRUE);
                    $tb061_aiento_contable->save($con); 
                    
                    $Tb177DetComprobante = new Tb177DetComprobante();
                    $Tb177DetComprobante->setCoComprobanteContable($Tb176ComprobanteContable->getCoComprobanteContable())
                                        ->setMoCredito($tb194_asiento_contable->getMoHaber())
                                        ->setMoDebito($tb194_asiento_contable->getMoDebe())                       
                                        ->setCoCuentaContable($tb194_asiento_contable->getCoCuentaContable())
                                        ->setCoSolicitud($tb194_asiento_contable->getCoSolicitud())
                                        ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                        ->setFeMovimiento($v["fecha"])
                                        ->save($con);     
                    
                    $tb024_cuenta_contable = Tb024CuentaContablePeer::retrieveByPK($tb194_asiento_contable->getCoCuentaContable());

                    $tb024_cuenta_contable->setMesCre($tb024_cuenta_contable->getMesCre() + $tb194_asiento_contable->getMoHaber());

                    $tb024_cuenta_contable->setMesDeb($tb024_cuenta_contable->getMesDeb() + $tb194_asiento_contable->getMoDebe());

                    $tb024_cuenta_contable->save($con);                    
                    
                    
            }
            $con->commit();
            
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud)); 
            $ruta->setInCargarDato(true)->save($con);
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta()); 
          
          

          $this->data = json_encode(array(
                      "success" => true,
                      "msg" => 'Proceso realizado exitosamente'
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
    
    public function executeGuardarCierreFiscal(sfWebRequest $request)
    {
        $co_solicitud = $this->getRequestParameter('co_solicitud');
        $json_cuenta                 = $this->getRequestParameter('json_cuenta');
        
        $con = Propel::getConnection();
        
        try
        { 
          $con->beginTransaction();  
                           
          
            $listaCuenta  = json_decode($json_cuenta,true);
            
        $wherec = new Criteria();
        $wherec->add(Tb200CierreContablePeer::CO_SOLICITUD, $co_solicitud, Criteria::EQUAL);
        BasePeer::doDelete($wherec, $con);            
            
            foreach($listaCuenta  as $v){    
                
              if($v["co_cierre_contable"]){
              $fecha = $v["fecha"]; 
              }else{  
              list($dia, $mes, $anio) = explode("/",$v["fecha"]);
              $fecha = $anio."-".$mes."-".$dia;
              }     
                    $tb200_cierre_contable = new Tb200CierreContable();
                    $tb200_cierre_contable->setCoSolicitud($co_solicitud)
                                                     ->setCoCuentaContable($v["co_cuenta_contable"])
                                                     ->setMoDebe($v["mo_debito"])
                                                     ->setMoHaber($v["mo_credito"])
                                                     ->setFecha($fecha)
                                                     ->setDescripcion($v["descripcion"])
                                                     ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                                     ->setCoTipoAsiento(16)
                                                     ->setInRechazado(false)
                                                     ->save($con);                   
                }
            

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud)); 
            $ruta->setInCargarDato(true)->save($con);
            //Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta()); 
          
          

          $this->data = json_encode(array(
                      "success" => true,
                      "msg" => 'Proceso realizado exitosamente'
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
    
    public function executeGuardarAprobarCierre(sfWebRequest $request)
    {
        $co_solicitud = $this->getRequestParameter('co_solicitud');
        $json_cuenta                 = $this->getRequestParameter('json_cuenta');
        
        $con = Propel::getConnection();
        
        try
        { 
          $con->beginTransaction();  
                           
           
           $sql ="SELECT (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH - 1 day')::DATE as last_day, (date_trunc('MONTH',fecha_cierre::date) + INTERVAL ' MONTH + 0 day')::DATE as first_day,EXTRACT(YEAR FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL ' MONTH + 0 day')::DATE) AS year from 
tb180_maestro_contable order by co_maestro_contable desc limit 1";
           $stmt = $con->prepare($sql);
           $stmt->execute(); 

           $next_month = $stmt->fetch(PDO::FETCH_ASSOC);       
           
           $sql_correlativo =" SELECT  extract(year from '".$next_month["last_day"]."'::date)||''||lpad(cast(extract(month from '".$next_month["last_day"]."'::date) as varchar(2)), 2, '0')||''||lpad((count(distinct co_solicitud)+1::numeric)::text, 4, '0') as nu_comprobante 
	   FROM  tb200_cierre_contable as t1
	   WHERE extract(year from fecha) = extract(year from '".$next_month["last_day"]."'::date) AND extract(month from fecha) = extract(month from '".$next_month["last_day"]."'::date) and in_aprobado = true";

           $stmt1 = $con->prepare($sql_correlativo);
           $stmt1->execute();            
           $correlativo = $stmt1->fetch(PDO::FETCH_ASSOC);          
          
            $listaCuenta  = json_decode($json_cuenta,true);            
            
            $mo_debe = 0;
            $mo_haber = 0;
            foreach($listaCuenta  as $v){
            $tb200_cierre_contable = Tb200CierreContablePeer::retrieveByPK($v["co_cierre_contable"]);
            $mo_debe = $mo_debe + $tb200_cierre_contable->getMoDebe();
            $mo_haber = $mo_haber + $tb200_cierre_contable->getMoHaber();
            }
            
            $Tb176ComprobanteContable = new Tb176ComprobanteContable();
            $Tb176ComprobanteContable->setCoUsuario($this->getUser()->getAttribute('codigo'))
                              ->setMoDebito($mo_debe)
                              ->setMoCredito($mo_haber)
                              ->setNuAnio($next_month["year"])
                              ->setCoTipoAsiento(16)
                              ->setFeComprobante($v["fecha"])
                              ->setCreatedAt(date("Y-m-d"))
                              ->setInContabilizado(TRUE)
                              ->setInCerrado(true)
                              ->setFeContabilizado($next_month["last_day"])
                              ->setFeCerrado($next_month["last_day"])
                              ->save($con); 
            
            $nu_comprobante = $next_month["year"].str_pad($next_month["month"], 2, "0", STR_PAD_LEFT).str_pad($Tb176ComprobanteContable->getCoComprobanteContable(), 5, "0", STR_PAD_LEFT);
            $Tb176ComprobanteContable->setNuComprobante($nu_comprobante)->save($con);             
            
            foreach($listaCuenta  as $v){    
 
                          
                 
                    $tb200_cierre_contable = Tb200CierreContablePeer::retrieveByPK($v["co_cierre_contable"]); 
                    $tb200_cierre_contable->setInAprobado(true)
                                           ->setNuComprobante($correlativo["nu_comprobante"])
                                           ->save($con); 
                    
                    $tb061_aiento_contable = new Tb061AsientoContable();
                    $tb061_aiento_contable->setCoSolicitud($tb200_cierre_contable->getCoSolicitud());
                    $tb061_aiento_contable->setCoCuentaContable($tb200_cierre_contable->getCoCuentaContable());
                    $tb061_aiento_contable->setMoDebe($tb200_cierre_contable->getMoDebe());
                    $tb061_aiento_contable->setMoHaber($tb200_cierre_contable->getMoHaber());
                    $tb061_aiento_contable->setCreatedAt($tb200_cierre_contable->getFecha());
                    $tb061_aiento_contable->setCoUsuario($this->getUser()->getAttribute('codigo'));
                    $tb061_aiento_contable->setCoTipoAsiento(16);
                    $tb061_aiento_contable->setNuComprobante($nu_comprobante);
                    $tb061_aiento_contable->setInActivo(TRUE);
                    $tb061_aiento_contable->save($con);
                    
                    $Tb177DetComprobante = new Tb177DetComprobante();
                    $Tb177DetComprobante->setCoComprobanteContable($Tb176ComprobanteContable->getCoComprobanteContable())
                                        ->setMoCredito($tb200_cierre_contable->getMoHaber())
                                        ->setMoDebito($tb200_cierre_contable->getMoDebe())                       
                                        ->setCoCuentaContable($tb200_cierre_contable->getCoCuentaContable())
                                        ->setCoSolicitud($tb200_cierre_contable->getCoSolicitud())
                                        ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                        ->setFeMovimiento($v["fecha"])
                                        ->save($con);                    
                         
                    if($tb200_cierre_contable->getCoCuentaContable()!=2643){
                    $tb024_cuenta_contable = Tb024CuentaContablePeer::retrieveByPK($tb200_cierre_contable->getCoCuentaContable());

                    $tb024_cuenta_contable->setPreCre(0);

                    $tb024_cuenta_contable->setPreDeb(0);
                    
                    $tb024_cuenta_contable->setMesCre(0);

                    $tb024_cuenta_contable->setMesDeb(0); 
                    
                    $tb024_cuenta_contable->setAcuCre(0);

                    $tb024_cuenta_contable->setAcuDeb(0);                    

                    $tb024_cuenta_contable->save($con);  
                    }else{
                    
                    $tb024_cuenta_contable = Tb024CuentaContablePeer::retrieveByPK($tb200_cierre_contable->getCoCuentaContable());                        
                        
                    $tb024_cuenta_contable->setMesCre($tb024_cuenta_contable->getMesCre() + $tb200_cierre_contable->getMoHaber());
                    
                    $tb024_cuenta_contable->setMesDeb($tb024_cuenta_contable->getMesDeb() + $tb200_cierre_contable->getMoDebe());
                        
                    }
                    
                    
            }
            $con->commit();
            
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud)); 
            $ruta->setInCargarDato(true)->save($con);
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta()); 
          
          

          $this->data = json_encode(array(
                      "success" => true,
                      "msg" => 'Proceso realizado exitosamente'
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

        public function executeGuardarRechazarAjuste(sfWebRequest $request)
    {
        $co_solicitud = $this->getRequestParameter('co_solicitud');
        $json_cuenta                 = $this->getRequestParameter('json_cuenta');
        
        $con = Propel::getConnection();
        
        try
        { 
          $con->beginTransaction();  
                           
          
            $listaCuenta  = json_decode($json_cuenta,true);
            
            foreach($listaCuenta  as $v){    
                
                 
                    $tb194_asiento_contable = Tb194AjusteContablePeer::retrieveByPK($v["co_ajuste_contable"]); 
                    $tb194_asiento_contable->setInAprobado(FALSE)
                                           ->save($con); 
                    
            }

            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud)); 
            $ruta->setInCargarDato(true)->save($con);
            //Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta()); 
          
          

          $this->data = json_encode(array(
                      "success" => true,
                      "msg" => 'Proceso realizado exitosamente'
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
    
    protected function getDatosPartida($co_partida){
        
        $c = new Criteria();
        $c->add(Tb085PresupuestoPeer::ID,$co_partida);        
        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $campos;
        
    }


    public function executeStorelistaComprobanteAjuste(sfWebRequest $request)
    {
        $co_solicitud = $this->getRequestParameter('co_solicitud');
        
        $c = new Criteria();
        $c->clearSelectColumns();        
        $c->addSelectColumn(Tb172PartidaComprobanteAjustePeer::CO_PARTIDA_AFECTADA);
        $c->addSelectColumn(Tb172PartidaComprobanteAjustePeer::CO_PARTIDA_DESAFECTADA);
        $c->addSelectColumn(Tb172PartidaComprobanteAjustePeer::CO_COMPROBANTE_AJUSTE);
        $c->addSelectColumn(Tb172PartidaComprobanteAjustePeer::CO_PARTIDA_COMPROBANTE_AJUSTE);
        $c->addSelectColumn(Tb172PartidaComprobanteAjustePeer::NU_MONTO);
        $c->addSelectColumn(Tb172PartidaComprobanteAjustePeer::CO_DETALLE_COMPRA);
        $c->add(Tb168ComprobanteAjustePeer::CO_SOLICITUD,$co_solicitud);
        $c->addJoin(Tb168ComprobanteAjustePeer::CO_COMPROBANTE_AJUSTE, Tb172PartidaComprobanteAjustePeer::CO_COMPROBANTE_AJUSTE);
        
        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);

        $registros = array();
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            $datos_afectada    = $this->getDatosPartida($res["co_partida_afectada"]);
            $datos_desafectada = $this->getDatosPartida($res["co_partida_desafectada"]);
            
            $registros[] = array(
                "co_partida_comprobante_ajuste"  => trim($res["co_partida_comprobante_ajuste"]),
                "co_detalle_compras"             => trim($res["co_detalle_compra"]),
                "co_partida_afectada"            => trim($datos_afectada["id"]),
                "co_categoria_afectada"          => trim($datos_afectada["co_categoria"]." - ".$datos_afectada["de_partida"]),
                "co_partida_desafectada"         => trim($datos_desafectada["id"]),
                "co_categoria_desafectada"       => trim($datos_desafectada["co_categoria"]." - ".$datos_desafectada["de_partida"]),
                "monto"                          => trim($res["nu_monto"])
             );
        }
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        $this->setTemplate('store');
    }
    
    public function executeStorelistaComprobanteAjusteContable(sfWebRequest $request)
    {
        $co_solicitud = $this->getRequestParameter('co_solicitud');
        
        $c = new Criteria();
        $c->clearSelectColumns();        
        $c->addSelectColumn(Tb194AjusteContablePeer::CO_AJUSTE_CONTABLE);
        $c->addSelectColumn(Tb194AjusteContablePeer::CO_CUENTA_CONTABLE);
        $c->addSelectColumn(Tb024CuentaContablePeer::TX_CUENTA);
        $c->addSelectColumn(Tb024CuentaContablePeer::TX_DESCRIPCION);
        $c->addSelectColumn(Tb194AjusteContablePeer::MO_DEBE);
        $c->addSelectColumn(Tb194AjusteContablePeer::MO_HABER);
        $c->addSelectColumn(Tb194AjusteContablePeer::DESCRIPCION);
        $c->addSelectColumn("cast(".Tb194AjusteContablePeer::FECHA." as date) as created_at");
        $c->add(Tb194AjusteContablePeer::CO_SOLICITUD,$co_solicitud);
        $c->add(Tb194AjusteContablePeer::IN_RECHAZADO,FALSE);
        $c->addJoin(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Tb194AjusteContablePeer::CO_CUENTA_CONTABLE);
        
        $stmt = Tb194AjusteContablePeer::doSelectStmt($c);

        $registros = array();
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            $registros[] = array(
                "co_ajuste_contable"  => trim($res["co_ajuste_contable"]),
                "co_cuenta_contable"             => trim($res["co_cuenta_contable"]),
                "tx_cuenta"            => trim($res["tx_cuenta"]),
                "denominacion"          => trim($res["tx_descripcion"]),
                "descripcion"          => trim($res["descripcion"]),
                "tx_tipo_asiento"         => trim($res["mo_debe"]==0?'NOTA DE CREDITO':'NOTA DE DEBITO'),
                "fecha"       => trim($res["created_at"]),
                "mo_debito"      => trim($res["mo_debe"]),
                "mo_credito"      => trim($res["mo_haber"])
             );
        }
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        $this->setTemplate('store');
    }  
    
    public function executeStorelistaCierreContable(sfWebRequest $request)
    {
        $co_solicitud = $this->getRequestParameter('co_solicitud');
        
        $c = new Criteria();
        $c->clearSelectColumns();        
        $c->addSelectColumn(Tb200CierreContablePeer::CO_CIERRE_CONTABLE);
        $c->addSelectColumn(Tb200CierreContablePeer::CO_CUENTA_CONTABLE);
        $c->addSelectColumn(Tb024CuentaContablePeer::TX_CUENTA);
        $c->addSelectColumn(Tb024CuentaContablePeer::TX_DESCRIPCION);
        $c->addSelectColumn(Tb200CierreContablePeer::MO_DEBE);
        $c->addSelectColumn(Tb200CierreContablePeer::MO_HABER);
        $c->addSelectColumn(Tb200CierreContablePeer::DESCRIPCION);
        $c->addSelectColumn(Tb133TipoAsientoPeer::TX_TIPO_ASIENTO);
        $c->addSelectColumn("cast(".Tb200CierreContablePeer::FECHA." as date) as created_at");
        $c->add(Tb200CierreContablePeer::CO_SOLICITUD,$co_solicitud);
        $c->add(Tb200CierreContablePeer::IN_RECHAZADO,FALSE);
        $c->addJoin(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Tb200CierreContablePeer::CO_CUENTA_CONTABLE);
        $c->addJoin(Tb133TipoAsientoPeer::CO_TIPO_ASIENTO, Tb200CierreContablePeer::CO_TIPO_ASIENTO);
        $c->addAscendingOrderByColumn(Tb200CierreContablePeer::CO_CIERRE_CONTABLE);
        
        $stmt = Tb200CierreContablePeer::doSelectStmt($c);

        $registros = array();
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            $registros[] = array(
                "co_cierre_contable"  => trim($res["co_cierre_contable"]),
                "co_cuenta_contable"             => trim($res["co_cuenta_contable"]),
                "tx_cuenta"            => trim($res["tx_cuenta"]),
                "denominacion"          => trim($res["tx_descripcion"]),
                "descripcion"          => trim($res["descripcion"]),
                "tx_tipo_asiento"         => trim($res["tx_tipo_asiento"]),
                "fecha"       => trim($res["created_at"]),
                "mo_debito"      => trim($res["mo_debe"]),
                "mo_credito"      => trim($res["mo_haber"])
             );
        }
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        $this->setTemplate('store');
    }    
    
  public function executeEliminarCuenta(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_ajuste_contable");
	$con = Propel::getConnection();
	try
	{
	$con->beginTransaction();
	/*CAMPOS*/
	$tb194_asiento_contable = Tb194AjusteContablePeer::retrieveByPk($codigo);
        
            $c1 = new Criteria();
            $c1->clearSelectColumns();    
            $c1->addSelectColumn(Tb176ComprobanteContablePeer::CO_COMPROBANTE_CONTABLE);
            $c1->add(Tb176ComprobanteContablePeer::CO_SOLICITUD,$tb194_asiento_contable->getCoSolicitud());
            $stmt1 = Tb176ComprobanteContablePeer::doSelectStmt($c1);

            $res1 = $stmt1->fetch(PDO::FETCH_ASSOC);      
           
            if($res1["co_comprobante_contable"]){
                
            $Tb176ComprobanteContable = Tb176ComprobanteContablePeer::retrieveByPK($res1["co_comprobante_contable"]);   

            
            }       
        
//            var_dump($Tb176ComprobanteContable->getInCerrado());
//            exit();
            if($Tb176ComprobanteContable->getInContabilizado()==false){
        
	$tb194_asiento_contable->setInRechazado(true);
        $tb194_asiento_contable->save($con);
        
        $wherec = new Criteria();
        $wherec->add(Tb061AsientoContablePeer::CO_SOLICITUD, $tb194_asiento_contable->getCoSolicitud(), Criteria::EQUAL);
        $wherec->add(Tb061AsientoContablePeer::CO_CUENTA_CONTABLE, $tb194_asiento_contable->getCoCuentaContable(), Criteria::EQUAL);
        BasePeer::doDelete($wherec, $con);   
        
        $wherec1 = new Criteria();
        $wherec1->add(Tb177DetComprobantePeer::CO_SOLICITUD, $tb194_asiento_contable->getCoSolicitud(), Criteria::EQUAL);
        $wherec1->add(Tb177DetComprobantePeer::CO_CUENTA_CONTABLE, $tb194_asiento_contable->getCoCuentaContable(), Criteria::EQUAL);
        BasePeer::doDelete($wherec1, $con);         
        
        $c = new Criteria();
        $c->clearSelectColumns();        
        $c->addSelectColumn('SUM(' .Tb194AjusteContablePeer::MO_DEBE. ') as mo_debe');
        $c->addSelectColumn('SUM(' .Tb194AjusteContablePeer::MO_HABER. ') as mo_haber');
        $c->add(Tb194AjusteContablePeer::CO_SOLICITUD,$tb194_asiento_contable->getCoSolicitud());
        $c->add(Tb194AjusteContablePeer::IN_RECHAZADO,FALSE);        
        $stmt = Tb194AjusteContablePeer::doSelectStmt($c);        
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(count($res)==0){
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb194_asiento_contable->getCoSolicitud())); 
            $ruta->setInCargarDato(false)->save($con);            
        }
        
        if($res["mo_debe"]!=$res["mo_haber"]){
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb194_asiento_contable->getCoSolicitud())); 
            $ruta->setInCargarDato(false)->save($con);                    
        }
                    $Tb176ComprobanteContable->setCoUsuario($this->getUser()->getAttribute('codigo'))
                              ->setMoDebito($res["mo_debe"])
                              ->setMoCredito($res["mo_haber"])
                              ->save($con);

            
//            $tb024_cuenta_contable = Tb024CuentaContablePeer::retrieveByPK($tb194_asiento_contable->getCoCuentaContable());
//
//            $tb024_cuenta_contable->setPreCre($tb024_cuenta_contable->getPreCre() - $tb194_asiento_contable->getMoHaber());
//
//            $tb024_cuenta_contable->setPreDeb($tb024_cuenta_contable->getPreDeb() - $tb194_asiento_contable->getMoHaber());
//
//            $tb024_cuenta_contable->save($con);  
            
            
            
		$this->data = json_encode(array(
			    "success" => true,
			    "msg" => 'Registro Borrado con exito!'
		));
	$con->commit();
        
        
            }else{
            		$this->data = json_encode(array(
			    "success" => false,
			    "msg" => 'El registro no se puede eliminar ya que el comprobante esta contabilizado!'
		));    
            }
	}catch (PropelException $e)
	{
	$con->rollback();
		$this->data = json_encode(array(
		    "success" => false,
//		    "msg" =>  $e->getMessage()
		    "msg" => 'Este registro no se puede borrar porque <br>se encuentra asociado a otros registros'
		));
	}
  }    
    
    public function executeVerificarODP(sfWebRequest $request)
    {

        $nu_odp  = $this->getRequestParameter('nu_odp');

        $c = new Criteria();
        $c->clearSelectColumns();        
        $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb060OrdenPagoPeer::CO_ORDEN_PAGO);
        $c->add(Tb060OrdenPagoPeer::TX_SERIAL,$nu_odp);
        $c->addJoin(Tb060OrdenPagoPeer::CO_SOLICITUD, Tb026SolicitudPeer::CO_SOLICITUD);
        $c->addJoin(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD, Tb026SolicitudPeer::CO_TIPO_SOLICITUD);
        $stmt = Tb060OrdenPagoPeer::doSelectStmt($c);

        $registros = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        $this->setTemplate('store');

    }
    
    
    public function executeAgregarAjuste(sfWebRequest $request)
    {             
        $lista_partida = $this->getRequestParameter("lista_partida");
        
        $listaPartida  = json_decode($lista_partida,true);
        $array_factura = array();
        
       
        foreach($listaPartida  as $v){
            $array_detalle_compra.=$v["co_detalle_compras"].',';
        }
        
        
        $array_detalle_compra = substr($array_detalle_compra, 0,-1);
        
        $this->data = json_encode(array(
            "co_solicitud_ajuste"   => $this->getRequestParameter("co_solicitud_ajuste"),
            "co_orden_pago"         => $this->getRequestParameter("co_orden_pago"),
            "lista_detalle_compra"         => $array_detalle_compra
        ));
    }
    
    public function executeAgregarAjusteContable(sfWebRequest $request)
    {              
        
           $con = Propel::getConnection();
           $sql ="SELECT (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '2 MONTH - 1 day')::DATE as last_day, (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE as first_day,EXTRACT(YEAR FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE) AS year from 
tb180_maestro_contable order by co_maestro_contable desc limit 1";
           $stmt = $con->prepare($sql);
           $stmt->execute(); 

           $next_month = $stmt->fetch(PDO::FETCH_ASSOC);         
           $this->data = json_encode(array(
            "co_solicitud"   => $this->getRequestParameter("co_solicitud"),
            "fecha"   => $next_month["last_day"],
            "fecha_inicial"   => $next_month["first_day"]
        ));
    }   
    
    public function executeAgregarCierreFiscal(sfWebRequest $request)
    {              
        
           $con = Propel::getConnection();
           $sql ="SELECT (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH - 1 day')::DATE as last_day, (date_trunc('MONTH',fecha_cierre::date) + INTERVAL ' MONTH + 0 day')::DATE as first_day,EXTRACT(YEAR FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL ' MONTH + 0 day')::DATE) AS year,EXTRACT(MONTH FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL ' MONTH + 0 day')::DATE) AS month from 
tb180_maestro_contable order by co_maestro_contable desc limit 1";
           $stmt = $con->prepare($sql);
           $stmt->execute(); 

           $next_month = $stmt->fetch(PDO::FETCH_ASSOC); 
           
        $c = new Criteria();
        $c->clearSelectColumns();        
        $c->addSelectColumn(Tb176ComprobanteContablePeer::CO_COMPROBANTE_CONTABLE);  
        $c->add(Tb176ComprobanteContablePeer::NU_ANIO,$next_month["year"]);
        $c->add(Tb176ComprobanteContablePeer::CO_TIPO_ASIENTO,16);
        $stmt1 = Tb176ComprobanteContablePeer::doSelectStmt($c);
        $res = $stmt1->fetch(PDO::FETCH_ASSOC);   
        
           $this->data = json_encode(array(
            "co_solicitud"   => $this->getRequestParameter("co_solicitud"),
            "ejercicio"   => $next_month["year"],
            "fecha"   => $next_month["last_day"],
            "mes"   => $next_month["month"],
            "co_comprobante_contable"   => $res["co_comprobante_contable"]  
        ));
    }    
    
    public function executeStorelistaPartida(sfWebRequest $request)
    {

        $co_odp                 = $this->getRequestParameter('co_odp');
        $lista_detalle_compra   = $this->getRequestParameter('lista_detalle_compra');

        //var_dump($lista_detalle_compra); exit();
        
        $c = new Criteria();
        $c->clearSelectColumns();        
        $c->addSelectColumn(Tb085PresupuestoPeer::ID);
        $c->addSelectColumn(Tb085PresupuestoPeer::CO_CATEGORIA);
        $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
        $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);
        $c->addSelectColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);
        $c->add(Tb060OrdenPagoPeer::CO_ORDEN_PAGO,$co_odp);
        
        if($lista_detalle_compra!='false'){
            
            $lista = array();
            $lista = explode(",", $lista_detalle_compra);
            
                        
            $c->add(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS,$lista, Criteria::NOT_IN);
        }
        
        
        $c->addJoin(Tb060OrdenPagoPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD);
        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
        $c->addJoin(Tb085PresupuestoPeer::ID, Tb053DetalleComprasPeer::CO_PRESUPUESTO);
        
      
        
        $stmt = Tb085PresupuestoPeer::doSelectStmt($c);

        $registros = array();
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = array(
                "co_partida"             => trim($res["id"]),
                "co_categoria"           => trim($res["co_categoria"]),
                "de_partida"             => trim($res["de_partida"]),
                "monto"                  => trim($res["monto"]),
                "co_detalle_compras"     => trim($res["co_detalle_compras"]),
             );
        }
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        $this->setTemplate('store');

    }
    
    
    public function executeStorelistaPartidaDesafectar(sfWebRequest $request)
    {

        $co_odp  = $this->getRequestParameter('co_odp');

        $c = new Criteria();
        $c->clearSelectColumns();        
        $c->addSelectColumn(Tb085PresupuestoPeer::ID);
        $c->addSelectColumn(Tb085PresupuestoPeer::CO_CATEGORIA);
        $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
        $c->addSelectColumn(Tb053DetalleComprasPeer::MONTO);        
        $c->addJoin(Tb060OrdenPagoPeer::CO_SOLICITUD, Tb052ComprasPeer::CO_SOLICITUD);
        $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS); 
        $c->addJoin(Tb085PresupuestoPeer::ID, Tb053DetalleComprasPeer::CO_PRESUPUESTO);
        $c->add(Tb060OrdenPagoPeer::CO_ORDEN_PAGO,$co_odp);
        
        $stmt = Tb060OrdenPagoPeer::doSelectStmt($c);

        $registros = array();
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
         $registros[] = $res;
        }
        
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));
        $this->setTemplate('store');

    }
    
    public function executeStorelistaResumen(sfWebRequest $request)
    {
        $paginar    =   $this->getRequestParameter("paginar");            
        $co_comprobante_ajuste = $this->getRequestParameter("co_comprobante_ajuste");


        $c = new Criteria(); 
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb085PresupuestoPeer::ID);
        $c->addSelectColumn(Tb085PresupuestoPeer::NU_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::DE_PARTIDA);
        $c->addSelectColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);
        $c->addSelectColumn('SUM('. Tb172PartidaComprobanteAjustePeer::NU_MONTO.') as monto');
        
        $c->addJoin(Tb085PresupuestoPeer::ID, Tb172PartidaComprobanteAjustePeer::CO_PARTIDA_AFECTADA);

        $c->add(Tb172PartidaComprobanteAjustePeer::CO_COMPROBANTE_AJUSTE,$co_comprobante_ajuste);

        $c->addGroupByColumn(Tb085PresupuestoPeer::ID);
        $c->addGroupByColumn(Tb085PresupuestoPeer::NU_PARTIDA);
        $c->addGroupByColumn(Tb085PresupuestoPeer::DE_PARTIDA);
        $c->addGroupByColumn(Tb085PresupuestoPeer::MO_DISPONIBLE);


        $cantidadTotal = Tb172PartidaComprobanteAjustePeer::doCount($c);

        $i=0;

        $stmt = Tb172PartidaComprobanteAjustePeer::doSelectStmt($c);

        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){   
            
            $reg["nu_partida"] = Tb085PresupuestoPeer::mascaraNomina($reg["nu_partida"]);
            
            $registros[] = $reg;       
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));
        
        $this->setTemplate('store');
    }
    
    public function executeStorefktipoasiento(sfWebRequest $request){
        $c = new Criteria();
        $c->add(Tb133TipoAsientoPeer::CO_TIPO_ASIENTO,10);
        $c->addOr(Tb133TipoAsientoPeer::CO_TIPO_ASIENTO,9);
        $stmt = Tb133TipoAsientoPeer::doSelectStmt($c);
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
    
  public function executeStorelistaCuenta(sfWebRequest $request)
  {
        $paginar    =   $this->getRequestParameter("paginar");
        $limit      =   $this->getRequestParameter("limit",15);
        $start      =   $this->getRequestParameter("start",0);

        $nu_cuenta_contable      =   $this->getRequestParameter("nu_cuenta_contable");
        $tx_descripcion        =   $this->getRequestParameter("tx_descripcion");
        $nu_nivel        =   $this->getRequestParameter("nu_nivel");


        $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
        if($nu_cuenta_contable!=""){$c->add(Tb024CuentaContablePeer::NU_CUENTA_CONTABLE,$nu_cuenta_contable.'%',Criteria::ILIKE);}
        if($tx_descripcion!=""){$c->add(Tb024CuentaContablePeer::TX_DESCRIPCION,'%'.$tx_descripcion.'%',Criteria::ILIKE);}
        if($nu_nivel!=""){$c->add(Tb024CuentaContablePeer::NU_NIVEL,$nu_nivel);}
    }        
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE);
        $c->addSelectColumn(Tb024CuentaContablePeer::TX_CUENTA);
        $c->addSelectColumn(Tb024CuentaContablePeer::TX_DESCRIPCION);
        $c->addSelectColumn(Tb024CuentaContablePeer::NU_NIVEL);
        $c->addSelectColumn(Tb024CuentaContablePeer::PRE_DEB);
        $c->addSelectColumn(Tb024CuentaContablePeer::PRE_CRE);
        $c->setIgnoreCase(true);

        $c->add(Tb024CuentaContablePeer::TX_TIPO, 'S');
        $c->add(Tb024CuentaContablePeer::NU_NIVEL, 8, Criteria::NOT_IN);
//        $c->addAscendingOrderByColumn(Tb024CuentaContablePeer::NU_NIVEL);
        $c->addAscendingOrderByColumn(Tb024CuentaContablePeer::NU_CUENTA_CONTABLE);
        $cantidadTotal = Tb024CuentaContablePeer::doCount($c);
        $c->setLimit($limit)->setOffset($start);

        $stmt = Tb024CuentaContablePeer::doSelectStmt($c);
        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){                         
            $registros[] = array(
                "co_cuenta_contable"             => trim($res["co_cuenta_contable"]),
                "tx_cuenta"           => trim($res["tx_cuenta"]),
                "tx_descripcion"             => trim($res["tx_descripcion"]),
                "nu_nivel"                  => trim($res["nu_nivel"]),
                "saldo"     => trim($res["pre_deb"]-$res["pre_cre"]),
             );
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));
    }    
    
  public function executeStorelistacierre(sfWebRequest $request)
  {

        $con = Propel::getConnection();   
        
        
        if($this->getRequestParameter('co_cierre_contable')){
            
        $co_solicitud = $this->getRequestParameter('co_solicitud');
        
        $c = new Criteria();
        $c->clearSelectColumns();        
        $c->addSelectColumn(Tb200CierreContablePeer::CO_CIERRE_CONTABLE);
        $c->addSelectColumn(Tb200CierreContablePeer::CO_CUENTA_CONTABLE);
        $c->addSelectColumn(Tb024CuentaContablePeer::TX_CUENTA);
        $c->addSelectColumn(Tb024CuentaContablePeer::TX_DESCRIPCION);
        $c->addSelectColumn(Tb200CierreContablePeer::MO_DEBE);
        $c->addSelectColumn(Tb200CierreContablePeer::MO_HABER);
        $c->addSelectColumn(Tb200CierreContablePeer::DESCRIPCION);
        $c->addSelectColumn(Tb133TipoAsientoPeer::TX_TIPO_ASIENTO);
        $c->addSelectColumn("cast(".Tb200CierreContablePeer::FECHA." as date) as created_at");
        $c->add(Tb200CierreContablePeer::CO_SOLICITUD,$co_solicitud);
        $c->add(Tb200CierreContablePeer::IN_RECHAZADO,FALSE);
        $c->addJoin(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Tb200CierreContablePeer::CO_CUENTA_CONTABLE);
        $c->addJoin(Tb133TipoAsientoPeer::CO_TIPO_ASIENTO, Tb200CierreContablePeer::CO_TIPO_ASIENTO);
        $c->addAscendingOrderByColumn(Tb200CierreContablePeer::CO_CIERRE_CONTABLE);
        
        $stmt = Tb200CierreContablePeer::doSelectStmt($c);

        $registros = array();
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            $registros[] = array(
                "co_cierre_contable"  => trim($res["co_cierre_contable"]),
                "co_cuenta_contable"             => trim($res["co_cuenta_contable"]),
                "tx_cuenta"            => trim($res["tx_cuenta"]),
                "denominacion"          => trim($res["tx_descripcion"]),
                "descripcion"          => trim($res["descripcion"]),
                "tx_tipo_asiento"         => trim($res["tx_tipo_asiento"]),
                "fecha"       => trim($res["created_at"]),
                "mo_debito"      => trim($res["mo_debe"]),
                "mo_credito"      => trim($res["mo_haber"])
             );
        }
        $this->data = json_encode(array(
            "success"   => true,
            "data"      => $registros
        ));            
            
            
            
        }else{
        
        $fecha = $this->getRequestParameter("fecha");
        $descripcion = $this->getRequestParameter("descripcion");
        
        $sql = "select co_cuenta_contable,tx_cuenta,tx_descripcion as denominacion, (acu_cre + mes_cre + pre_cre) - (acu_deb + mes_deb + pre_deb) as mo_debito, 0 as mo_credito,'".$fecha."' as fecha,
        '".$descripcion."' as descripcion    from tb024_cuenta_contable 
where nu_cuenta_contable like '3%' and nu_nivel = 5 and (acu_cre + mes_cre + pre_cre) - (acu_deb + mes_deb + pre_deb) > 0  group by co_cuenta_contable,nu_cuenta_contable,tx_descripcion";
        //var_dump($sql);        exit();
        $stmt = $con->prepare($sql);
        $stmt->execute();        
        
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = $reg;
        }
        
        
        
        $sql = "select co_cuenta_contable,tx_cuenta,tx_descripcion as denominacion, coalesce((select sum((acu_cre + mes_cre + pre_cre) - (acu_deb + mes_deb + pre_deb)) from  tb024_cuenta_contable 
where nu_cuenta_contable like '3%' and nu_nivel = 5 and (acu_cre + mes_cre + pre_cre) - (acu_deb + mes_deb + pre_deb) > 0),0) mo_credito, 0 as mo_debito,'".$fecha."' as fecha,
        '".$descripcion."' as descripcion from tb024_cuenta_contable 
where co_cuenta_contable = 2643";
        //var_dump($sql);        exit();
        $stmt = $con->prepare($sql);
        $stmt->execute();          

        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){           
            $registros[] = $reg;
        }     
        
        $sql = "select co_cuenta_contable,tx_cuenta,tx_descripcion as denominacion, ((acu_cre + mes_cre + pre_cre) - (acu_deb + mes_deb + pre_deb)) * -1 as mo_credito, 0 as mo_debito,'".$fecha."' as fecha,
        '".$descripcion."' as descripcion from tb024_cuenta_contable 
where nu_cuenta_contable like '4%' and nu_nivel = 5 
and (acu_cre + mes_cre + pre_cre) - (acu_deb + mes_deb + pre_deb) < 0 
 group by co_cuenta_contable,nu_cuenta_contable,tx_descripcion
";
        //var_dump($sql);        exit();
        $stmt = $con->prepare($sql);
        $stmt->execute();        

        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){      
            $registros[] = $reg;
        }         
        
        $sql = "select co_cuenta_contable,tx_cuenta,tx_descripcion as denominacion, coalesce((select sum((acu_cre + mes_cre + pre_cre) - (acu_deb + mes_deb + pre_deb)) * -1 from  tb024_cuenta_contable 
where nu_cuenta_contable like '4%' and nu_nivel in (4,5) and (acu_cre + mes_cre + pre_cre) - (acu_deb + mes_deb + pre_deb) < 0),0) mo_debito, 0 as mo_credito,'".$fecha."' as fecha,
        '".$descripcion."' as descripcion from tb024_cuenta_contable 
where co_cuenta_contable = 2643";
        //var_dump($sql);        exit();
        $stmt = $con->prepare($sql);
        $stmt->execute();          

        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){           
            $registros[] = $reg;
        }        
        
        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  0,
            "data"      =>  $registros
            ));
        
        }
    }

  public function executeStorelista(sfWebRequest $request)
  {

    $limit         =   $this->getRequestParameter("limit", 15);
    $start         =   $this->getRequestParameter("start", 0);
    $in_ventanilla =   $this->getRequestParameter("in_ventanilla");
    $co_proceso    =   $this->getRequestParameter("co_proceso");
    $co_solicitud  =   $this->getRequestParameter("co_solicitud");

    $co_documento     =   $this->getRequestParameter("co_documento");
    $nu_cedula_rif    =   $this->getRequestParameter("nu_cedula_rif");
    $tx_razon_social  =   $this->getRequestParameter("tx_razon_social");

    $c = new Criteria();
    $c->clearSelectColumns();

    if ($co_documento != '') {
      $c->add(Tb007DocumentoPeer::CO_DOCUMENTO, $co_documento);
    }

    if ($nu_cedula_rif != '') {
      $c->add(Tb008ProveedorPeer::TX_RIF, $nu_cedula_rif);
    }

    if ($tx_razon_social != '') {
      $c->add(Tb008ProveedorPeer::TX_RAZON_SOCIAL, '%' . $tx_razon_social . '%', Criteria::LIKE);
    }




    if ($co_solicitud != '') {
      $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $co_solicitud);
    }

    if ($in_ventanilla == 'true') {
      $c->add(Tb030RutaPeer::NU_ORDEN, 1);
    } else {
      $c->add(Tb030RutaPeer::NU_ORDEN, 1,  Criteria::GREATER_THAN);

      if ($co_proceso != '') {
        $c->add(Tb028ProcesoPeer::CO_PROCESO, $co_proceso);
      } else {

        $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));


        $c->addAnd(Tb030RutaPeer::CO_PROCESO, $registro_proceso, Criteria::IN);
      }
    }


    $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));
    $registro_tramite = Tb006TipoSolicitudUsuarioPeer::getListaTramiteAsignado($this->getUser()->getAttribute('codigo'));

    $c->setIgnoreCase(true);
    $c->addSelectColumn(Tb030RutaPeer::CO_PROCESO);
    $c->addSelectColumn(Tb030RutaPeer::CO_RUTA);
    $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
    $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
    $c->addSelectColumn(Tb001UsuarioPeer::TX_LOGIN);
    $c->addSelectColumn(Tb026SolicitudPeer::FE_REGISTRO);
    $c->addSelectColumn(Tb026SolicitudPeer::CO_PERSONA);
    $c->addSelectColumn(Tb030RutaPeer::TX_RUTA_REPORTE);
    $c->addSelectColumn(Tb176ComprobanteContablePeer::NU_COMPROBANTE);
    $c->addSelectColumn(Tb176ComprobanteContablePeer::MO_CREDITO);
    $c->addSelectColumn(Tb176ComprobanteContablePeer::MO_DEBITO);
    $c->addSelectColumn(Tb176ComprobanteContablePeer::FE_COMPROBANTE);


    $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD,  Criteria::JOIN);
    $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb176ComprobanteContablePeer::CO_SOLICITUD,  Criteria::JOIN);
    $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD,  Criteria::JOIN);
    $c->addJoin(Tb030RutaPeer::CO_PROCESO, Tb028ProcesoPeer::CO_PROCESO,   Criteria::JOIN);
    $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO,  Criteria::JOIN);

    $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, 47);
    $c->addAnd(Tb030RutaPeer::CO_PROCESO, $registro_proceso, Criteria::IN);

    $c->addAnd(Tb030RutaPeer::IN_ANULAR, NULL, Criteria::ISNULL);
    $c->addAnd(Tb026SolicitudPeer::CO_ESTATUS, array(1, 2), Criteria::IN);
    $c->addAnd(Tb030RutaPeer::CO_ESTATUS_RUTA, 1);
    $c->addAnd(Tb030RutaPeer::IN_ACTUAL, true);
    $c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));

    $cantidadTotal = Tb026SolicitudPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
    $c->addDescendingOrderByColumn(Tb026SolicitudPeer::CO_SOLICITUD);

    $stmt = Tb026SolicitudPeer::doSelectStmt($c);
    $registros = array();
    $encrip = new myConfig();
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

      $cantidad = Tb026SolicitudPeer::getCantRevision($res["co_solicitud"]);

      $tx_rif = $res["inicial"] . "-" . $res["tx_rif"];
      $tx_razon_social = strtoupper($res["tx_razon_social"]);

      list($anio, $mes, $dia) = explode("-", $res["fe_oficio"]);
      $fecha = $dia . '/' . $mes . '/' . $anio;

      list($anio, $mes, $dia) = explode('-', $res["fe_comprobante"]);
      $registros[] = array(
        "tx_proceso"        => trim($res["tx_proceso"]),
        "tx_concepto"       => strtoupper(trim($res["tx_concepto"])),
        "co_proceso"        => trim($res["co_proceso"]),
        "tx_tipo_solicitud" => trim($res["tx_tipo_solicitud"]),
        "co_tipo_solicitud" => trim($res["co_tipo_solicitud"]),
        "co_solicitud"      => trim($res["co_solicitud"]),
        "tx_login"          => trim($res["tx_login"]),
        "tx_serial"         => Tb060OrdenPagoPeer::getODP($res["co_solicitud"]),
        "in_reporte"        => ($res["tx_ruta_reporte"] == null) ? '' : $res["co_ruta"],
        "co_ruta"           => $encrip->encrypt($res["co_ruta"]),
        "fe_creacion"       => $dia . '-' . $mes . '-' . $anio,
        "cant_revision"     => $cantidad,
        "de_modificacion"   => trim($res["de_modificacion"]),
        "nu_modificacion"   => trim($res["nu_modificacion"]),
        "nu_oficio"         => trim($res["nu_oficio"]),
          "nu_comprobante"         => trim($res["nu_comprobante"]),
          "mo_debito"         => trim($res["mo_debito"]),
          "mo_credito"         => trim($res["mo_credito"]),
        "fe_oficio"         => $fecha
      );
    }

    $this->data = json_encode(array(
      "success"   =>  true,
      "total"     =>  $cantidadTotal,
      "data"      =>  $registros
    ));
  }    
    
}
