<?php

/**
 * ConfigAplicacion actions.
 *
 * @package    gobel
 * @subpackage ConfigAplicacion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConfigAplicacionActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConfigAplicacion', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConfigAplicacion', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb139AplicacionPeer::CO_APLICACION,$codigo);
        
        $stmt = Tb139AplicacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_aplicacion"     => $campos["co_aplicacion"],
                            "nu_anio_fiscal"     => $campos["nu_anio_fiscal"],
                            "tx_tip_aplicacion"     => $campos["tx_tip_aplicacion"],
                            "tx_aplicacion"     => $campos["tx_aplicacion"],
                            "tx_genera_cheque"     => $campos["tx_genera_cheque"],
                            "tx_tip_gasto"     => $campos["tx_tip_gasto"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_aplicacion"     => "",
                            "nu_anio_fiscal"     => "",
                            "tx_tip_aplicacion"     => "",
                            "tx_aplicacion"     => "",
                            "tx_genera_cheque"     => "",
                            "tx_tip_gasto"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_aplicacion");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb139_aplicacion = Tb139AplicacionPeer::retrieveByPk($codigo);

        $tb139_aplicacionForm = $this->getRequestParameter('tb139_aplicacion');
/*CAMPOS*/
                
         if($tb139_aplicacionForm["tx_tip_aplicacion"]!=$tb139_aplicacion->getTxTipAplicacion()){
         $c = new Criteria();
         $c->add(Tb139AplicacionPeer::NU_ANIO_FISCAL,$tb139_aplicacionForm["nu_anio_fiscal"]);
         $c->add(Tb139AplicacionPeer::TX_TIP_APLICACION, $tb139_aplicacionForm["tx_tip_aplicacion"]);
         $cantidad = Tb139AplicacionPeer::doCount($c);

         if ($cantidad > 0) {
           $this->data = json_encode(array(
             'success' => false,
             'msg' => '<span style="color:red;font-size:13px,"><b> La aplicacion ya se encuentra registrada</b></span>'
           ));

           return $this->setTemplate('store');
         }  
         }

     }else{
         $tb139_aplicacion = new Tb139Aplicacion();
         
         
         
        $tb139_aplicacionForm = $this->getRequestParameter('tb139_aplicacion');
/*CAMPOS*/
                
         
         $c = new Criteria();
         $c->add(Tb139AplicacionPeer::NU_ANIO_FISCAL,$tb139_aplicacionForm["nu_anio_fiscal"]);
         $c->add(Tb139AplicacionPeer::TX_TIP_APLICACION, $tb139_aplicacionForm["tx_tip_aplicacion"]);
         $cantidad = Tb139AplicacionPeer::doCount($c);

         if ($cantidad > 0) {
           $this->data = json_encode(array(
             'success' => false,
             'msg' => '<span style="color:red;font-size:13px,"><b> La aplicacion ya se encuentra registrada</b></span>'
           ));

           return $this->setTemplate('store');
         }         
         
     }
     try
      { 
        $con->beginTransaction();
       
        $tb139_aplicacionForm = $this->getRequestParameter('tb139_aplicacion');
/*CAMPOS*/
      
        /*Campo tipo NUMERIC */
        $tb139_aplicacion->setNuAnioFiscal($tb139_aplicacionForm["nu_anio_fiscal"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb139_aplicacion->setTxTipAplicacion($tb139_aplicacionForm["tx_tip_aplicacion"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb139_aplicacion->setTxAplicacion($tb139_aplicacionForm["tx_aplicacion"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb139_aplicacion->setTxGeneraCheque($tb139_aplicacionForm["tx_genera_cheque"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb139_aplicacion->setTxTipGasto($tb139_aplicacionForm["tx_tip_gasto"]);
                                
        /*CAMPOS*/
        $tb139_aplicacion->save($con);
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
  

  public function executeEliminar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_aplicacion");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb139_aplicacion = Tb139AplicacionPeer::retrieveByPk($codigo);			
	$tb139_aplicacion->delete($con);
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
//		    "msg" =>  $e->getMessage()
		    "msg" => 'Este registro no se puede borrar porque <br>se encuentra asociado a otros registros'
		));
	}
  }

  public function executeLista(sfWebRequest $request)
  {

  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $nu_anio_fiscal      =   $this->getRequestParameter("nu_anio_fiscal");
            $tx_tip_aplicacion      =   $this->getRequestParameter("tx_tip_aplicacion");
            $tx_aplicacion      =   $this->getRequestParameter("tx_aplicacion");
            $tx_genera_cheque      =   $this->getRequestParameter("tx_genera_cheque");
            $tx_tip_gasto      =   $this->getRequestParameter("tx_tip_gasto");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($nu_anio_fiscal!=""){$c->add(Tb139AplicacionPeer::NU_ANIO_FISCAL,$nu_anio_fiscal);}
    
                                        if($tx_tip_aplicacion!=""){$c->add(Tb139AplicacionPeer::TX_TIP_APLICACION,'%'.$tx_tip_aplicacion.'%',Criteria::LIKE);}
        
                                        if($tx_aplicacion!=""){$c->add(Tb139AplicacionPeer::TX_APLICACION,'%'.$tx_aplicacion.'%',Criteria::LIKE);}
        
                                        if($tx_genera_cheque!=""){$c->add(Tb139AplicacionPeer::TX_GENERA_CHEQUE,'%'.$tx_genera_cheque.'%',Criteria::LIKE);}
        
                                        if($tx_tip_gasto!=""){$c->add(Tb139AplicacionPeer::TX_TIP_GASTO,'%'.$tx_tip_gasto.'%',Criteria::LIKE);}
        
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb139AplicacionPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb139AplicacionPeer::CO_APLICACION);
        
    $stmt = Tb139AplicacionPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_aplicacion"     => trim($res["co_aplicacion"]),
            "nu_anio_fiscal"     => trim($res["nu_anio_fiscal"]),
            "tx_tip_aplicacion"     => trim($res["tx_tip_aplicacion"]),
            "tx_aplicacion"     => trim($res["tx_aplicacion"]),
            "tx_genera_cheque"     => trim($res["tx_genera_cheque"]),
            "tx_tip_gasto"     => trim($res["tx_tip_gasto"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                    


}