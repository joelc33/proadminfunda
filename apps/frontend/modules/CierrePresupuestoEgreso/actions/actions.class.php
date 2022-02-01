<?php

/**
 * CierrePresupuestoEgreso actions.
 *
 * @package    gobel
 * @subpackage CierrePresupuestoEgreso
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class CierrePresupuestoEgresoActions extends sfActions
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
                            "co_cierre_egreso" => "",
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

  public function executeGuardar(sfWebRequest $request)
  {
     $json_movimiento     =   $this->getRequestParameter("json_movimiento");
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
            $Tb173CierreEgreso = new Tb173CierreEgreso();
            $Tb173CierreEgreso->setCoUsuario($this->getUser()->getAttribute('codigo'))
                              ->setFeDesde($desde)
                              ->setFeHasta($hasta)
                              ->setMoComprometido(($listaMovimiento[0]["mo_comprometido"]=='')?0:$listaMovimiento[0]["mo_comprometido"])
                              ->setMoCausado(($listaMovimiento[0]["mo_causado"]=='')?0:$listaMovimiento[0]["mo_causado"])
                              ->setMoPagado(($listaMovimiento[0]["mo_pagado"]=='')?0:$listaMovimiento[0]["mo_pagado"])
                              ->setNuAnio($this->getUser()->getAttribute('ejercicio'))
                              ->setCoMes($mes)
                              ->save($con);

            $update = "update tb087_presupuesto_movimiento tb087 set in_cerrado = true
                      from tb085_presupuesto tb085                   
                     where tb085.id = tb087.co_partida and tb085.nu_anio = $ejercicio and in_cerrado is null and 
                      co_tipo_movimiento in (1,2,3) and cast(tb087.created_at as date) between '$fe_desde' and '$fe_hasta'";

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
                    "msg" => 'Para procesar el cierre el monto comprometido debe ser mayor a cero (0)'
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
  
  public function executeStorelistaMes(sfWebRequest $request){
      
        $registros[] = array("co_mes"  => '01',"tx_mes"  => 'Enero');
        $registros[] = array("co_mes"  => '02',"tx_mes"  => 'Febrero');
        $registros[] = array("co_mes"  => '03',"tx_mes"  => 'Marzo');
        $registros[] = array("co_mes"  => '04',"tx_mes"  => 'Abril');
        $registros[] = array("co_mes"  => '05',"tx_mes"  => 'Mayo');
        $registros[] = array("co_mes"  => '06',"tx_mes"  => 'Junio');
        $registros[] = array("co_mes"  => '07',"tx_mes"  => 'Julio');
        $registros[] = array("co_mes"  => '08',"tx_mes"  => 'Agosto');
        $registros[] = array("co_mes"  => '09',"tx_mes"  => 'Septiembre');
        $registros[] = array("co_mes"  => '10',"tx_mes"  => 'Octubre');
        $registros[] = array("co_mes"  => '11',"tx_mes"  => 'Noviembre');
        $registros[] = array("co_mes"  => '12',"tx_mes"  => 'Diciembre');

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  12,
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
        
        //echo "entro"; exit();

        $sql = "SELECT distinct 
                (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$ejercicio,2,'$fe_desde','$fe_hasta')),0)) -coalesce(sum(afectacion_partida(tb085.id,$ejercicio,1,'$fe_desde','$fe_hasta')),0) mo_modificado_mov,
                sum(mo_inicial)+ (coalesce(sum(mo_modificado_admon),0)+coalesce(sum(afectacion_partida(tb085.id,$ejercicio,2,'$fe_desde','$fe_hasta')),0)) -coalesce(sum(afectacion_partida(tb085.id,$ejercicio,1,'$fe_desde','$fe_hasta')),0) as mo_aprobado,
                coalesce(sum(comprometido_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$ejercicio,1,'$fe_desde','$fe_hasta')),0) mo_comprometido,
                coalesce(sum(causado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$ejercicio,2,'$fe_desde','$fe_hasta')),0) mo_causado,
                coalesce(sum(pagado_dia),0)+coalesce(sum(movimiento_partida(tb085.id,$ejercicio,3,'$fe_desde','$fe_hasta')),0) mo_pagado
                FROM tb085_presupuesto as tb085 
                where in_movimiento is true and tb085.nu_anio = $ejercicio";
                
        // echo $sql; exit();
         
        $result = $con->prepare($sql);
        $result->execute();
        $resultado = $result->fetch(PDO::FETCH_ASSOC);
        
        $registros[] = array(
                "mo_comprometido"  => trim($resultado["mo_comprometido"]),
                "mo_causado"       => trim($resultado["mo_causado"]),
                "mo_pagado"        => trim($resultado["mo_pagado"])
        );


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  0,
            "data"      =>  $registros
            ));
    }
    
    public function executeStorelistaCierre(sfWebRequest $request)
    {
       
        $limit      =   $this->getRequestParameter("limit",20);
        $start      =   $this->getRequestParameter("start",0);
                       
        $c = new Criteria();               
        $cantidadTotal = Tb173CierreEgresoPeer::doCount($c);        

        $c->setLimit($limit)->setOffset($start);        
        $c->addDescendingOrderByColumn(Tb173CierreEgresoPeer::CO_CIERRE_EGRESO);
        
        $stmt = Tb173CierreEgresoPeer::doSelectStmt($c);
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
