<?php

/**
 * CierreContable actions.
 *
 * @package    gobel
 * @subpackage CierreContable
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class CierreContableActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    
  }
  
  public function executeDiario(sfWebRequest $request)
  {
    
  }  
  
  public function executeMensual(sfWebRequest $request)
  {
    
  }    
  
  public function executeGuardar(sfWebRequest $request)
  {
    
    $json_movimiento     =   $this->getRequestParameter("json_movimiento");
    $ejercicio           =   $this->getRequestParameter('ejercicio');
    $fe_hasta            =   $this->getRequestParameter('fe_hasta');
        
    list($dia,$mes,$anio) = explode("/", $fe_hasta);
    $hasta = $anio.'-'.$mes.'-'.$dia;
     
     $con = Propel::getConnection();
     
      try
      { 
        $con->beginTransaction();
        
        $listaMovimiento  = json_decode($json_movimiento,true);        
        
//        $month = "$ejercicio-$mes";
//        $aux = date('Y-m-d', strtotime("{$month}  + 1 month"));
//        $ulimo_dia = date('Y-m-d', strtotime("{$aux} - 1 day"));
//        
//        $desde = $ejercicio.'-'.$mes.'-01';
//        $hasta = $ulimo_dia;
//        
        if(count($listaMovimiento)>0){
            
            
            foreach($listaMovimiento  as $v){
                

                $Tb176ComprobanteContable = new Tb176ComprobanteContable();
                $Tb176ComprobanteContable->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                  ->setMoDebito($v["mo_debe"])
                                  ->setMoCredito($v["mo_haber"])
                                  ->setNuAnio($ejercicio)
                                  ->setCoTipoAsiento($v["co_tipo_asiento"])
                                  ->setFeComprobante($v["fecha"])
                                  ->setCreatedAt(date("Y-m-d"))
                                  ->setInContabilizado(FALSE)
                                  ->setInCerrado(FALSE)
                                  ->save($con);
                
                //$nu_comprobante = $ejercicio.$mes.str_pad($Tb176ComprobanteContable->getCoComprobanteContable(), 5, "0", STR_PAD_LEFT);
//                $Tb176ComprobanteContable->setNuComprobante($Tb176ComprobanteContable->getCoComprobanteContable())->save($con);
                
           $sql_month ="SELECT (date_trunc('MONTH','$hasta'::date) + INTERVAL '0 MONTH + 0 day')::DATE as first_day";

           $stmt_month = $con->prepare($sql_month);
           $stmt_month->execute(); 

           $month = $stmt_month->fetch(PDO::FETCH_ASSOC);                    
                
                        $sql = "select tb061.co_asiento_contable,tb061.co_cuenta_contable, tb061.co_solicitud ,tb061.co_tipo_asiento,tb133.tx_tipo_asiento, coalesce(sum(mo_debe),0) as mo_debe, coalesce(sum(mo_haber),0) as mo_haber, cast(tb061.created_at as date) as fecha_movimiento
                from tb061_asiento_contable tb061 
                join tb133_tipo_asiento tb133 on (tb133.co_tipo_asiento = tb061.co_tipo_asiento)
                left join tb026_solicitud tb026 on tb026.co_solicitud = tb061.co_solicitud
               where cast(tb061.created_at as date) between '".$v["fecha"]."' and '".$v["fecha"]."' and tb061.nu_comprobante is null and tb061.co_tipo_asiento = ".$v["co_tipo_asiento"]."
               group by tb061.co_asiento_contable, tb061.co_solicitud,tb061.co_cuenta_contable ,tb061.co_tipo_asiento,tb133.tx_tipo_asiento";
        //var_dump($sql);        exit();
        $stmt = $con->prepare($sql);
        $stmt->execute();  
                while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
                    
                    
                    $Tb177DetComprobante = new Tb177DetComprobante();
                    $Tb177DetComprobante->setCoComprobanteContable($Tb176ComprobanteContable->getCoComprobanteContable())
                                        ->setMoCredito($reg["mo_haber"])
                                        ->setMoDebito($reg["mo_debe"])                       
                                        ->setCoCuentaContable($reg["co_cuenta_contable"])
                                        ->setCoSolicitud($reg["co_solicitud"])
                                        ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                        ->setFeMovimiento($reg["fecha_movimiento"])
                                        ->save($con);      
                    
                    
                    $update = "update tb061_asiento_contable 
                                  set nu_comprobante = '".$Tb176ComprobanteContable->getCoComprobanteContable()."'
                                where co_asiento_contable = ".$reg["co_asiento_contable"];
                        
                    $result = $con->prepare($update);
                    $result->execute();
                    
                }
                
                
                
            }
            
            $con->commit();
            
            $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'El cierre administrativo se proceso exitosamente'
            ));
            
        }else{
            $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'No existen registros para procesar el cierre'
            ));
        }
                      
       
      }catch (PropelException $e)
      {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage()
        ));
      }
     
  }
  
  
  public function executeGuardarCierreDiario(sfWebRequest $request)
  {
    
    $co_comprobante_contable     =   $this->getRequestParameter("co_comprobante_contable");
     
     $con = Propel::getConnection();
     
      try
      { 
        $con->beginTransaction();
        
       $codigo = explode(',',$co_comprobante_contable);
       $c1  = new Criteria();
       $c1->add(Tb176ComprobanteContablePeer::CO_COMPROBANTE_CONTABLE,$codigo, Criteria::IN);
       $stmt1 = Tb176ComprobanteContablePeer::doSelectStmt($c1);
       $registros1 = array();
        while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
//        var_dump($row["co_comprobante_contable"]);
//        exit();            
        
            
        if($row["mo_debito"]!=$row["mo_credito"]){
            
		$this->data = json_encode(array(
		    "success" => false,
		    "msg" => 'El monto debito y el monto credito debe ser igual. Verifique!'
		));  
                echo $this->data;
                return sfView::NONE;            
            
        }else{    
            
        $tb176_comprobante_contable = Tb176ComprobanteContablePeer::retrieveByPK($row["co_comprobante_contable"]);
        
        $tb176_comprobante_contable->setInContabilizado(true);
        $tb176_comprobante_contable->setFeContabilizado(date('Y-m-d'));
        $tb176_comprobante_contable->save($con);
               
        
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb177DetComprobantePeer::CO_CUENTA_CONTABLE);
        $c->addSelectColumn('SUM('. Tb177DetComprobantePeer::MO_CREDITO.') as mo_credito');
        $c->addSelectColumn('SUM('. Tb177DetComprobantePeer::MO_DEBITO.') as mo_debito');
//        $c->addSelectColumn(Tb177DetComprobantePeer::MO_CREDITO);
//        $c->addSelectColumn(Tb177DetComprobantePeer::MO_DEBITO);
//        $c->add(Tb177DetComprobantePeer::CO_COMPROBANTE_CONTABLE,$tb176_comprobante_contable->getCoComprobanteContable());  
        $c->add(Tb177DetComprobantePeer::CO_COMPROBANTE_CONTABLE,$codigo, Criteria::IN);
//        $c->add(Tb177DetComprobantePeer::CO_CUENTA_CONTABLE,122234);
        $c->addGroupByColumn(Tb177DetComprobantePeer::CO_CUENTA_CONTABLE);
        $stmt = Tb177DetComprobantePeer::doSelectStmt($c);
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){


//        var_dump($reg["mo_debito"]);
//        exit();                   
        
        $tb024_cuenta_contable = Tb024CuentaContablePeer::retrieveByPK($reg["co_cuenta_contable"]);

        $tb024_cuenta_contable->setPreCre($tb024_cuenta_contable->getPreCre() + $reg["mo_credito"]);
        
        $tb024_cuenta_contable->setPreDeb($tb024_cuenta_contable->getPreDeb() + $reg["mo_debito"]);
        
        $tb024_cuenta_contable->save($con);
        }
        }        
        }  
            $con->commit();
            
            $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'El cierre diario se proceso exitosamente'
            ));
            
         
                      
       
      }catch (PropelException $e)
      {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage()
        ));
      }
     
  }  
  
  
  public function executeGuardarCierreMensual(sfWebRequest $request)
  {
    
    $json_movimiento     =   $this->getRequestParameter("json_movimiento");
    $ejercicio           =   $this->getRequestParameter('ejercicio');
    $fe_hasta            =   $this->getRequestParameter('fe_hasta');
        
    list($dia,$mes,$anio) = explode("/", $fe_hasta);
    $hasta = $anio.'-'.$mes.'-'.$dia;
     
     $con = Propel::getConnection();
     
      try
      { 
        $con->beginTransaction();
        
        $listaMovimiento  = json_decode($json_movimiento,true);  
                if(count($listaMovimiento)>0){
            $total_debito = 0;
            $total_credito = 0;
            
            foreach($listaMovimiento  as $v){
                
             $tb176_comprbante_contable = Tb176ComprobanteContablePeer::retrieveByPK($v["co_comprobante_contable"]);                

             $tb176_comprbante_contable->setInCerrado(TRUE);
             $tb176_comprbante_contable->setFeCerrado(date("Y-m-d"));
             $tb176_comprbante_contable->save($con); 
             
//             $total_debito = $total_debito + $tb176_comprbante_contable->getMoDebito();
//             $total_credito = $total_credito + $tb176_comprbante_contable->getMoCredito();                
            }
            
        $sql2 = "select sum(pre_deb) as total_debito, sum(pre_cre) as total_credito from tb024_cuenta_contable";
//        var_dump($sql);        exit();
        $stmt2 = $con->prepare($sql2);
        $stmt2->execute(); 
        
            $reg2 = $stmt2->fetch(PDO::FETCH_ASSOC);        

        $sql = "select co_cuenta_contable,acu_deb + mes_deb as acu_deb,acu_cre + mes_cre as acu_cre,pre_deb,pre_cre "
                . "from tb024_cuenta_contable where co_cuenta_contable not in (select co_cuenta_contable "
                . "from  tb024_cuenta_contable where  acu_cre = 0 and acu_deb = 0 and mes_cre = 0 and mes_deb = 0 and pre_deb = 0 and pre_cre = 0) order by 1";
//        var_dump($sql);        exit();
        $stmt = $con->prepare($sql);
        $stmt->execute(); 
        
                while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){                    
                      
                $tb024_cuenta_contable = Tb024CuentaContablePeer::retrieveByPK($reg["co_cuenta_contable"]);

                $tb024_cuenta_contable->setMesCre($reg["pre_cre"]);

                $tb024_cuenta_contable->setMesDeb($reg["pre_deb"]);
                
                $tb024_cuenta_contable->setAcuCre($reg["acu_cre"]);

                $tb024_cuenta_contable->setAcuDeb($reg["acu_deb"]);
                
                $tb024_cuenta_contable->setPreCre(0);

                $tb024_cuenta_contable->setPreDeb(0);                

                $tb024_cuenta_contable->save($con);
        
                $Tb179ResumenMensualContable = new Tb179ResumenMensualContable();
                
                $Tb179ResumenMensualContable->setCoMes($mes);
                $Tb179ResumenMensualContable->setNuAnio($anio);
                $Tb179ResumenMensualContable->setAcuCredito($reg["acu_cre"]);                        
                $Tb179ResumenMensualContable->setAcuDebito($reg["acu_deb"]);
                $Tb179ResumenMensualContable->setMesCredito($reg["pre_cre"]);                        
                $Tb179ResumenMensualContable->setMesDebito($reg["pre_deb"]);
                $Tb179ResumenMensualContable->setCoCuentaContable($reg["co_cuenta_contable"]);
                $Tb179ResumenMensualContable->setCoUsuario($this->getUser()->getAttribute('codigo'));
                $Tb179ResumenMensualContable->setCreatedAt(date("Y-m-d"));
                $Tb179ResumenMensualContable->save($con);
                    
                }
               
                $Tb180_maestro_contable = new Tb180MaestroContable();
                $Tb180_maestro_contable->setMoDebe($reg2["total_debito"]);
                $Tb180_maestro_contable->setMoHaber($reg2["total_credito"]);
                $Tb180_maestro_contable->setCoMes($mes);
                $Tb180_maestro_contable->setNuAnio($anio);
                $Tb180_maestro_contable->setCoUsuario($this->getUser()->getAttribute('codigo'));
                $Tb180_maestro_contable->setCreatedAt(date("Y-m-d"));
                $Tb180_maestro_contable->setFechaCierre($hasta);
                $Tb180_maestro_contable->save($con);
            
            
            $con->commit();
            
            $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'El cierre mensual se proceso exitosamente'
            ));
            
        }else{
            $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'No existen registros para procesar el cierre'
            ));
        }
                      
       
      }catch (PropelException $e)
      {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage()
        ));
      }
     
  }  
  
  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    $con = Propel::getConnection();
           $sql ="SELECT (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '2 MONTH - 1 day')::DATE as last_day, (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE as first_day,EXTRACT(YEAR FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE) AS year from 
tb180_maestro_contable order by co_maestro_contable desc limit 1";

           $stmt = $con->prepare($sql);
           $stmt->execute(); 

           $next_month = $stmt->fetch(PDO::FETCH_ASSOC);    
    
    if($codigo!=''||$codigo!=null){

    }else{
        $this->data = json_encode(array(
            "co_comprobante_contable" => "",
            "nu_comprobante"          => "",
            "mo_credito"              => "",
            "mo_debito"               => "",
            "co_mes"                  => "",
            "fe_desde"                => $next_month["first_day"],
            "fe_hasta"                => $next_month["last_day"],
            "ejercicio"               => $next_month["year"]
        ));
    }

  }
  
  public function executeEditarMensual(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    $con = Propel::getConnection();
           $sql ="SELECT (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '2 MONTH - 1 day')::DATE as last_day, (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE as first_day,EXTRACT(YEAR FROM (date_trunc('MONTH',fecha_cierre::date) + INTERVAL '1 MONTH + 0 day')::DATE) AS year from 
tb180_maestro_contable order by co_maestro_contable desc limit 1";
           $stmt = $con->prepare($sql);
           $stmt->execute(); 

           $next_month = $stmt->fetch(PDO::FETCH_ASSOC);    
    
    if($codigo!=''||$codigo!=null){

    }else{
        $this->data = json_encode(array(
            "co_comprobante_contable" => "",
            "nu_comprobante"          => "",
            "mo_credito"              => "",
            "mo_debito"               => "",
            "co_mes"                  => "",
            "fe_desde"                => $next_month["first_day"],
            "fe_hasta"                => $next_month["last_day"],
            "ejercicio"               => $next_month["year"]
        ));
    }

  }  
  
  public function executeDetalle(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("co_comprobante_contable"); 
    
    if($codigo!=''||$codigo!=null){
        
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->add(Tb176ComprobanteContablePeer::CO_COMPROBANTE_CONTABLE,$codigo);
        $c->addSelectColumn(Tb133TipoAsientoPeer::CO_TIPO_ASIENTO);
        $c->addSelectColumn(Tb133TipoAsientoPeer::TX_TIPO_ASIENTO);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::CO_COMPROBANTE_CONTABLE);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::MO_CREDITO);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::MO_DEBITO);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::NU_ANIO);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::NU_COMPROBANTE);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::MO_CREDITO);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::FE_COMPROBANTE);
        $c->addJoin(Tb133TipoAsientoPeer::CO_TIPO_ASIENTO, Tb176ComprobanteContablePeer::CO_TIPO_ASIENTO);             
        $c->addAscendingOrderByColumn(Tb176ComprobanteContablePeer::CO_COMPROBANTE_CONTABLE);
        
        $stmt = Tb176ComprobanteContablePeer::doSelectStmt($c);   
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            list($anio,$mes,$dia) = explode("-",$row["fe_comprobante"]);
            
            $fe_comprobante = $dia.'/'.$mes.'/'.$anio;        
            $this->data = json_encode(array(
            "co_comprobante_contable" => $row["co_comprobante_contable"],
            "nu_comprobante"          => $row["nu_comprobante"],
            "tx_tipo_asiento"         => $row["tx_tipo_asiento"],
            "mo_credito"              => $row["mo_credito"],
            "mo_debito"               => $row["mo_debito"],
            "fe_comprobante"          => $fe_comprobante,
            "nu_anio"               => $row["nu_anio"]
        ));
        

    }

  }
  
  public function executeDetalleMensual(sfWebRequest $request)
  {
    $this->nu_anio = $this->getRequestParameter("nu_anio"); 
    $this->co_mes = $this->getRequestParameter("co_mes"); 
    
   $this->data = json_encode(array(
            "nu_anio"         => $this->nu_anio,
            "co_mes"         => $this->co_mes
        ));
  }  

  public function executeDetalleTipoAsiento(sfWebRequest $request)
  {
    $co_tipo_asiento = $this->getRequestParameter("co_tipo_asiento");
    $fecha = $this->getRequestParameter("fecha");
    
    if($co_tipo_asiento!=''||$co_tipo_asiento!=null){
        
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->add(Tb133TipoAsientoPeer::CO_TIPO_ASIENTO,$co_tipo_asiento);
        $c->addSelectColumn(Tb133TipoAsientoPeer::CO_TIPO_ASIENTO);
        $c->addSelectColumn(Tb133TipoAsientoPeer::TX_TIPO_ASIENTO);    
        
        $stmt = Tb133TipoAsientoPeer::doSelectStmt($c);   
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        
            list($anio,$mes,$dia) = explode("-",$fecha);
            
            $fecha_movimiento = $dia.'/'.$mes.'/'.$anio;               
            $this->data = json_encode(array(
            "co_tipo_asiento"         => $row["co_tipo_asiento"],
            "tx_tipo_asiento"         => $row["tx_tipo_asiento"],
            "fecha"                   => $fecha_movimiento,
        ));
        

    }

  }  
  
  public function executeStorelista(sfWebRequest $request)
  {
       
        $mes           =   $this->getRequestParameter("co_mes");  
        $ejercicio     =   $this->getUser()->getAttribute('ejercicio');
        $fe_hasta     =   $this->getRequestParameter('fe_hasta');
        
        list($dia,$mes,$anio) = explode("/", $fe_hasta);
        
        $hasta = $anio.'-'.$mes.'-'.$dia;
       
//        $month = "$ejercicio-$mes";
//        $aux = date('Y-m-d', strtotime("{$month}  + 1 month"));
//        $ulimo_dia = date('Y-m-d', strtotime("{$aux} - 1 day"));
//        
//        $desde = $ejercicio.'-'.$mes.'-01';
//        $hasta = $ulimo_dia;
            
        $registros = $this->getMonto($hasta);


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  0,
            "data"      =>  $registros
            ));
  }
  
  protected function getMonto($hasta){
      
        $con = Propel::getConnection();        
        
        /*$c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb133TipoAsientoPeer::CO_TIPO_ASIENTO);
        $c->addSelectColumn(Tb133TipoAsientoPeer::TX_TIPO_ASIENTO);
        $c->addSelectColumn('SUM('. Tb061AsientoContablePeer::MO_DEBE.') as mo_debe');
        $c->addSelectColumn('SUM('. Tb061AsientoContablePeer::MO_HABER.') as mo_haber');
        $c->addJoin(Tb133TipoAsientoPeer::CO_TIPO_ASIENTO, Tb061AsientoContablePeer::CO_TIPO_ASIENTO);
        //$c->add(Tb061AsientoContablePeer::NU_COMPROBANTE,null, Criteria::ISNULL);
        $c->add(Tb061AsientoContablePeer::CREATED_AT,$hasta, Criteria::EQUAL);
        $c->addGroupByColumn(Tb133TipoAsientoPeer::TX_TIPO_ASIENTO);
        $c->addGroupByColumn(Tb133TipoAsientoPeer::CO_TIPO_ASIENTO);
        $stmt = Tb061AsientoContablePeer::doSelectStmt($c);
       
        $stmt = Tb061AsientoContablePeer::doSelectStmt($c);*/
        //echo $c->toString(); exit();
        
           $sql_month ="SELECT (date_trunc('MONTH','$hasta'::date) + INTERVAL '0 MONTH + 0 day')::DATE as first_day";

           $stmt_month = $con->prepare($sql_month);
           $stmt_month->execute(); 

           $month = $stmt_month->fetch(PDO::FETCH_ASSOC);         
        
        $sql = "select tb061.co_tipo_asiento,tb133.tx_tipo_asiento, coalesce(sum(mo_debe),0) as mo_debe, coalesce(sum(mo_haber),0) as mo_haber,cast(tb061.created_at as date) as fecha
                from tb061_asiento_contable tb061 
                join tb133_tipo_asiento tb133 on (tb133.co_tipo_asiento = tb061.co_tipo_asiento)
                left join tb026_solicitud tb026 on tb026.co_solicitud = tb061.co_solicitud
               where cast(tb061.created_at as date) between '".$month["first_day"]."' and '$hasta' and tb061.nu_comprobante is null
               group by cast(tb061.created_at as date),tb061.co_tipo_asiento,tb133.tx_tipo_asiento";
        //var_dump($sql);        exit();
        $stmt = $con->prepare($sql);
        $stmt->execute();        
        
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = $reg;
        }
      
        return $registros;
  } 




  public function executeStorelistaMovimiento(sfWebRequest $request)
  {
       
        $limit      =   $this->getRequestParameter("limit",20);
        $start      =   $this->getRequestParameter("start",0);
                       
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb133TipoAsientoPeer::CO_TIPO_ASIENTO);
        $c->addSelectColumn(Tb133TipoAsientoPeer::TX_TIPO_ASIENTO);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::CO_COMPROBANTE_CONTABLE);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::MO_CREDITO);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::MO_DEBITO);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::NU_ANIO);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::NU_COMPROBANTE);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::MO_CREDITO);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::FE_COMPROBANTE);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::IN_CONTABILIZADO);

        $c->add(Tb176ComprobanteContablePeer::IN_CERRADO,FALSE);
        $c->add(Tb176ComprobanteContablePeer::NU_ANIO,$this->getUser()->getAttribute('ejercicio'));
        $c->addJoin(Tb133TipoAsientoPeer::CO_TIPO_ASIENTO, Tb176ComprobanteContablePeer::CO_TIPO_ASIENTO);        
        $cantidadTotal = Tb176ComprobanteContablePeer::doCount($c);        

        //$c->setLimit($limit)->setOffset($start);        
        $c->addDescendingOrderByColumn(Tb176ComprobanteContablePeer::CO_COMPROBANTE_CONTABLE);
        
        $stmt = Tb176ComprobanteContablePeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            if($reg["mo_debito"]==null&&$reg["mo_credito"]==null){
                
            }else{
                      
            list($anio,$mes,$dia) = explode("-",$reg["fe_comprobante"]);
            
            $reg["fe_comprobante"] = $dia.'/'.$mes.'/'.$anio;
            
            $reg["in_contabilizado"] = $reg["in_contabilizado"]==FALSE?'NO':'SI';
            
            $registros[] = $reg;
            }
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));
    }
    
    
  public function executeStorelistaDetalle(sfWebRequest $request)
  {
       
        $limit      =   $this->getRequestParameter("limit",20);
        $start      =   $this->getRequestParameter("start",0);
        $co_comprobante_contable      =   $this->getRequestParameter("co_comprobante_contable");
                       
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->add(Tb177DetComprobantePeer::CO_COMPROBANTE_CONTABLE,$co_comprobante_contable);
        $c->addSelectColumn(Tb177DetComprobantePeer::CO_COMPROBANTE_CONTABLE);
        $c->addSelectColumn(Tb177DetComprobantePeer::MO_CREDITO);
        $c->addSelectColumn(Tb177DetComprobantePeer::MO_DEBITO);
        $c->addSelectColumn(Tb177DetComprobantePeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE);
        $c->addSelectColumn(Tb024CuentaContablePeer::TX_CUENTA);
        $c->addSelectColumn(Tb024CuentaContablePeer::TX_DESCRIPCION);
        $c->addJoin(Tb024CuentaContablePeer::CO_CUENTA_CONTABLE, Tb177DetComprobantePeer::CO_CUENTA_CONTABLE);        
        $cantidadTotal = Tb177DetComprobantePeer::doCount($c);        

        //$c->setLimit($limit)->setOffset($start);        
        $c->addAscendingOrderByColumn(Tb177DetComprobantePeer::CO_SOLICITUD);
        
        $stmt = Tb177DetComprobantePeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
                      
//            list($anio,$mes,$dia) = explode("-",$reg["fe_comprobante"]);
//            
//            $reg["fe_comprobante"] = $dia.'/'.$mes.'/'.$anio;
            
            $registros[] = $reg;
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));
    }
    
  public function executeStorelistaDetalleMensual(sfWebRequest $request)
  {
       
        $limit      =   $this->getRequestParameter("limit",20);
        $start      =   $this->getRequestParameter("start",0);
        $nu_anio      =   $this->getRequestParameter("nu_anio");
        $co_mes      =   $this->getRequestParameter("co_mes");
                       
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb133TipoAsientoPeer::CO_TIPO_ASIENTO);
        $c->addSelectColumn(Tb133TipoAsientoPeer::TX_TIPO_ASIENTO);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::CO_COMPROBANTE_CONTABLE);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::MO_CREDITO);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::MO_DEBITO);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::NU_ANIO);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::NU_COMPROBANTE);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::MO_CREDITO);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::FE_COMPROBANTE);
        $c->addSelectColumn(Tb176ComprobanteContablePeer::IN_CONTABILIZADO);
        $c->add(Tb176ComprobanteContablePeer::IN_CERRADO,TRUE);
        $c->add(Tb176ComprobanteContablePeer::NU_ANIO, $nu_anio);
        $c->add(Tb176ComprobanteContablePeer::FE_COMPROBANTE, "date_part('year', tb176_comprobante_contable.fe_comprobante) = ".$nu_anio, Criteria::CUSTOM);
        $c->add(Tb176ComprobanteContablePeer::FE_COMPROBANTE, "date_part('month', tb176_comprobante_contable.fe_comprobante) = ".$co_mes, Criteria::CUSTOM);
        $c->addJoin(Tb133TipoAsientoPeer::CO_TIPO_ASIENTO, Tb176ComprobanteContablePeer::CO_TIPO_ASIENTO);        
        $cantidadTotal = Tb176ComprobanteContablePeer::doCount($c);        

        //$c->setLimit($limit)->setOffset($start);        
        $c->addAscendingOrderByColumn(Tb176ComprobanteContablePeer::CO_COMPROBANTE_CONTABLE);
        
        $stmt = Tb176ComprobanteContablePeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
                      
            list($anio,$mes,$dia) = explode("-",$reg["fe_comprobante"]);
            
            $reg["fe_comprobante"] = $dia.'/'.$mes.'/'.$anio;
            
            $reg["in_contabilizado"] = $reg["in_contabilizado"]==FALSE?'NO':'SI';
            
            $registros[] = $reg;
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));
    }    
    
  public function executeStorelistaCierre(sfWebRequest $request)
  {
       
        $limit      =   $this->getRequestParameter("limit",20);
        $start      =   $this->getRequestParameter("start",0);
                       
        $c = new Criteria();
        $c->clearSelectColumns();      
        $cantidadTotal = Tb180MaestroContablePeer::doCount($c);        

        //$c->setLimit($limit)->setOffset($start);        
        $c->addAscendingOrderByColumn(Tb180MaestroContablePeer::CO_MAESTRO_CONTABLE);
        
        $stmt = Tb180MaestroContablePeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
                      
//            list($anio,$mes,$dia) = explode("-",$reg["fe_comprobante"]);
//            
//            $reg["fe_comprobante"] = $dia.'/'.$mes.'/'.$anio;
            
            $registros[] = $reg;
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));
    }    

  public function executeStorelistaDetalleTipoAsiento(sfWebRequest $request)
  {
       
        $co_tipo_asiento      =   $this->getRequestParameter("co_tipo_asiento");
        $fecha      =   $this->getRequestParameter("fecha");      
        $con = Propel::getConnection();              
        
        $sql = "select tb061.co_solicitud, coalesce(mo_debe,0) as mo_debito, coalesce(mo_haber,0) as mo_credito, cast(tb061.created_at as date) as fecha,tb024.tx_descripcion,tb024.tx_cuenta
                from tb061_asiento_contable tb061 
                left join tb024_cuenta_contable tb024 on (tb024.co_cuenta_contable = tb061.co_cuenta_contable)
                left join tb026_solicitud tb026 on tb026.co_solicitud = tb061.co_solicitud
               where cast(tb061.created_at as date) = '$fecha'  and tb061.nu_comprobante is null and tb061.co_tipo_asiento = ".$co_tipo_asiento."
               order by tb061.co_solicitud asc,tb024.tx_cuenta";
        //var_dump($sql);        exit();
        $stmt = $con->prepare($sql);
        $stmt->execute();  
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
                      
//            list($anio,$mes,$dia) = explode("-",$reg["fe_comprobante"]);
//            
//            $reg["fe_comprobante"] = $dia.'/'.$mes.'/'.$anio;
            
            $registros[] = $reg;
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "data"      =>  $registros
        ));
    }    
    
    protected function getMes($co_mes){
        
        switch ($co_mes) {
            case 1:
                return "Enero";
                break;
            case 2:
                return "Febrero";
                break; 
            case 3:
                return "Marzo";
                break;
            case 4:
                return "Abril";
                break;
            case 5:
                return "Mayo";
                break;
            case 6:
                return "Junio";
                break;
            case 7:
                return "Julio";
                break;
            case 8:
                return "Agosto";
                break;
            case 9:
                return "Septiembre";
                break;
            case 10:
                return "Octubre";
                break;
            case 11:
                return "Noviembre";
                break;            
            case 12:
                return "Diciembre";
                break;
        }
    }
}
