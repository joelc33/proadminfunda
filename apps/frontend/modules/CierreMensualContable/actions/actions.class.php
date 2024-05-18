<?php

/**
 * CierreMensualContable actions.
 *
 * @package    gobel
 * @subpackage CierreMensualContable
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class CierreMensualContableActions extends sfActions
{
  
  public function executeIndex(sfWebRequest $request)
  {
   
  }
  
  public function executePrecierre(sfWebRequest $request)
  {
        $this->data = json_encode(array(
            "ejercicio"        => $this->getUser()->getAttribute('ejercicio')
        ));
  }
  
  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){

    }else{
        $this->data = json_encode(array(
                            "co_cierre_ingreso" => "",
                            "fe_desde"         => "",
                            "fe_hasta"         => "",
                            "tx_organismo"     => "",
                            "mo_comprometido"  => "",
                            "mo_causado"       => "",
                            "mo_pagado"        => "",
                            "ejercicio"        => $this->getUser()->getAttribute('ejercicio')
        ));
    }

  }
  
   public function executeStorelistaMaestro(sfWebRequest $request)
    {
       
        $limit      =   $this->getRequestParameter("limit",20);
        $start      =   $this->getRequestParameter("start",0);
                       
        $c = new Criteria();               
        $cantidadTotal = Tb180MaestroMensualContablePeer::doCount($c);        

        $c->setLimit($limit)->setOffset($start);        
        $c->addDescendingOrderByColumn(Tb180MaestroMensualContablePeer::CO_MAESTRO_MENSUAL);
        
        $stmt = Tb180MaestroMensualContablePeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
                       
            $reg["mes"] = $this->getMes($reg["co_mes"]);           
            
            $registros[] = $reg;
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  0,
            "data"      =>  $registros
        ));
    }
    
    public function executeStorelista(sfWebRequest $request)
    {
       
        $mes           =   $this->getRequestParameter("co_mes");  
        $ejercicio     =   $this->getUser()->getAttribute('ejercicio');
       
        $month = "$ejercicio-$mes";
        $aux = date('Y-m-d', strtotime("{$month}  + 1 month"));
        $ulimo_dia = date('Y-m-d', strtotime("{$aux} - 1 day"));
        
        $desde = $ejercicio.'-'.$mes.'-01';
        $hasta = $ulimo_dia;
        
        list($anio,$mes,$dia) = explode("-", $desde);
        $fe_desde = $ejercicio.'-'.$mes.'-'.$dia;
        
        list($anio,$mes,$dia) = explode("-", $hasta);
        $fe_hasta = $ejercicio.'-'.$mes.'-'.$dia;

        $con = Propel::getConnection();

        $sql = "select tb024.co_cuenta_contable,tx_cuenta, coalesce(sum(mo_debe),0) as mo_debe, coalesce(sum(mo_haber),0) as mo_haber
                from tb024_cuenta_contable tb024 join tb061_asiento_contable tb061
                     on (tb024.co_cuenta_contable = tb061.co_cuenta_contable)
               where  tx_cuenta is not null and tb061.in_anular is null and cast(tb061.created_at as date) between '$fe_desde' and '$fe_hasta'
               group by tb024.co_cuenta_contable,tx_cuenta";

        $result = $con->prepare($sql);
        $result->execute();
      //  $datos = $result->fetch(PDO::FETCH_ASSOC);

        while($reg = $result->fetch(PDO::FETCH_ASSOC)){
            
            $registros[] = array(
                "co_cuenta_contable" => trim($reg["co_cuenta_contable"]),
                "tx_cuenta"   => trim($reg["tx_cuenta"]),
                "mo_debito"   => trim($reg["mo_debe"]),
                "mo_credito"  => trim($reg["mo_haber"])
             );

        }
      
        
        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  0,
            "data"      =>  $registros
            ));
    }
    
    public function executeGuardar(sfWebRequest $request)
    {
     $json_movimiento     =   $this->getRequestParameter("json_movimiento");
     $ejercicio           =   $this->getUser()->getAttribute('ejercicio');
     $mes                 =   $this->getRequestParameter('co_mes');
     $mo_debe             =   $this->getRequestParameter('mo_debe');
     $mo_haber            =   $this->getRequestParameter('mo_haber');
     
     $con = Propel::getConnection();
     
      try
      { 
        $con->beginTransaction();
        
        $listaMovimiento  = json_decode($json_movimiento,true);
        
        $month = "$ejercicio-$mes";
        $aux = date('Y-m-d', strtotime("{$month}  + 1 month"));
        $ulimo_dia = date('Y-m-d', strtotime("{$aux} - 1 day"));
        
        $desde = $ejercicio.'-'.$mes.'-01';
        $hasta = $ulimo_dia;
        
        list($anio,$mes,$dia) = explode("-", $desde);
        $fe_desde = $ejercicio.'-'.$mes.'-'.$dia;
        
        list($anio,$mes,$dia) = explode("-", $hasta);
        $fe_hasta = $ejercicio.'-'.$mes.'-'.$dia;
        
        
        $c = new Criteria();
        $c->add(Tb180MaestroMensualContablePeer::NU_ANIO, $ejercicio);
        $c->add(Tb180MaestroMensualContablePeer::CO_MES, $mes);        
        $cant = Tb180MaestroMensualContablePeer::doCount($c);
        
        
        if($cant > 0){
            $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El mes de '.$this->getMes($mes).' del año '.$ejercicio.' se encuentra cerrado'
            ));
        }else if(count($listaMovimiento)>0){
            
                       
            $tb180_maestro_mensual_contable = new  Tb180MaestroMensualContable();
            $tb180_maestro_mensual_contable->setMoDebe($mo_debe)
                                           ->setMoHaber($mo_haber)
                                           ->setCoMes($mes)
                                           ->setNuAnio($ejercicio)
                                           ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                           ->save($con);
            
            foreach ($listaMovimiento as $value) {
                 $tb179_resumen_mensual_contable = new Tb179ResumenMensualContable();
                 $tb179_resumen_mensual_contable->setCoMes($mes)
                                           ->setNuAnio($ejercicio)
                                           ->setMoCredito($value["mo_credito"])
                                           ->setMoDebito($value["mo_debito"])
                                           ->setCoCuentaContable($value["co_cuenta_contable"])
                                           ->setCoUsuario($this->getUser()->getAttribute('codigo'))
                                           ->setCoMaestroMensual($tb180_maestro_mensual_contable->getCoMaestroMensual())
                                           ->save($con);
            }
          
            $con->commit();
            
            $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'El cierre se procesó exitosamente'
            ));
        }else{
            $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'No extisten registros para procesar el cierre'
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
