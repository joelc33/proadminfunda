<?php

/**
 * CierrePresupuestoIngreso actions.
 *
 * @package    gobel
 * @subpackage CierrePresupuestoIngreso
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class CierrePresupuestoIngresoActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
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
  
    public function executeStorelistaCierre(sfWebRequest $request)
    {
       
        $limit      =   $this->getRequestParameter("limit",20);
        $start      =   $this->getRequestParameter("start",0);
                       
        $c = new Criteria();               
        $cantidadTotal = Tb174CierreIngresoPeer::doCount($c);        

        $c->setLimit($limit)->setOffset($start);        
        $c->addDescendingOrderByColumn(Tb174CierreIngresoPeer::CO_CIERRE_INGRESO);
        
        $stmt = Tb174CierreIngresoPeer::doSelectStmt($c);
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            list($anio,$mes,$dia) = explode("-",$reg["fe_desde"]);
            $reg["fe_desde"] = $dia.'-'.$mes.'-'.$anio;
        
            list($anio,$mes,$dia) = explode("-",$reg["fe_hasta"]);
            $reg["fe_hasta"] = $dia.'-'.$mes.'-'.$anio;
            
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
        $fe_desde = $ejercicio.'-01-'.$dia;
        
        list($anio,$mes,$dia) = explode("-", $hasta);
        $fe_hasta = $ejercicio.'-'.$mes.'-'.$dia;
        
        $con = Propel::getConnection();

        $sql = "select sum(tb150.mo_movimiento) as monto
                  from tb150_presupuesto_ingreso_movimiento tb150 join tb064_presupuesto_ingreso tb064
                       on (tb150.id_tb064_presupuesto_ingreso = tb064.co_presupuesto_ingreso) 
                where tb064.nu_anio = $ejercicio and co_tipo_movimiento = :tipo_movimiento and 
                      cast(tb150.created_at as date) between '$fe_desde' and '$fe_hasta' and tb150.in_anular is not true";
       
        //echo $sql; exit();

        $result = $con->prepare($sql);
        $result->execute(array(
            ':tipo_movimiento' => 9
        ));
        $comprometido = $result->fetch(PDO::FETCH_ASSOC);


        $result->execute(
          array(
            ':tipo_movimiento' => 10
            )
        );

        $causado = $result->fetch(PDO::FETCH_ASSOC);;

        $result->execute(
          array(
            ':tipo_movimiento' => 11
            )
        );

        $pagado = $result->fetch(PDO::FETCH_ASSOC);;

        $registros[] = array(
                "mo_comprometido"  => trim($comprometido["monto"]),
                "mo_causado"       => trim($causado["monto"]),
                "mo_pagado"        => trim($pagado["monto"])
        );


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  0,
            "data"      =>  $registros
            ));
    }
    
    public function executeGuardar(sfWebRequest $request)
    {
     $json_movimiento     = $this->getRequestParameter("json_movimiento");
     $ejercicio           =   $this->getUser()->getAttribute('ejercicio');
     $mes                 =   $this->getRequestParameter('co_mes');
     
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
        
        if($listaMovimiento[0]["mo_comprometido"]>0){
            $Tb174CierreIngreso = new Tb174CierreIngreso();
            $Tb174CierreIngreso->setCoUsuario($this->getUser()->getAttribute('codigo'))
                              ->setFeDesde($desde)
                              ->setFeHasta($hasta)
                              ->setMoComprometido(($listaMovimiento[0]["mo_comprometido"]=='')?0:$listaMovimiento[0]["mo_comprometido"])
                              ->setMoCausado(($listaMovimiento[0]["mo_causado"]=='')?0:$listaMovimiento[0]["mo_causado"])
                              ->setMoPagado(($listaMovimiento[0]["mo_pagado"]=='')?0:$listaMovimiento[0]["mo_pagado"])
                              ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                              ->setCoMes($mes)
                              ->save($con);

            $update = "update tb150_presupuesto_ingreso_movimiento tb150 set in_cerrado = true
                      from  tb064_presupuesto_ingreso tb064                 
                     where tb150.id_tb064_presupuesto_ingreso = tb064.co_presupuesto_ingreso and tb064.nu_anio = $ejercicio and in_cerrado is null and 
                           co_tipo_movimiento in (9,10,11) and cast(tb150.created_at as date) between '$fe_desde' and '$fe_hasta'";

            $result = $con->prepare($update);
            $result->execute();

            $con->commit();
            
            $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'El cierre se proceso exitosamente'
            ));
        }else{
            $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'Para procesar el cierre el monto devengado debe ser mayor a cero (0)'
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
