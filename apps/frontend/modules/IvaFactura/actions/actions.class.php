<?php

/**
 * autoIvaFactura actions.
 * NombreClaseModel(Tb043IvaFactura)
 * NombreTabla(tb043_iva_factura)
 * @package    ##PROJECT_NAME##
 * @subpackage autoIvaFactura
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class IvaFacturaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('IvaFactura', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('IvaFactura', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb043IvaFacturaPeer::CO_IVA_FACTURA,$codigo);
        
        $stmt = Tb043IvaFacturaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_iva_factura"     => $campos["co_iva_factura"],
                            "nu_valor"     => $campos["nu_valor"],
                            "fe_desde"     => $campos["fe_desde"],
                            "fe_hasta"     => $campos["fe_hasta"],
                            "in_activo"     => $campos["in_activo"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_iva_factura"     => "",
                            "nu_valor"     => "",
                            "fe_desde"     => "",
                            "fe_hasta"     => "",
                            "in_activo"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("co_iva_factura");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb043_iva_factura = Tb043IvaFacturaPeer::retrieveByPk($codigo);
     }else{
         $tb043_iva_factura = new Tb043IvaFactura();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb043_iva_facturaForm = $this->getRequestParameter('tb043_iva_factura');
/*CAMPOS*/
                                        
        /*Campo tipo NUMERIC */
        $tb043_iva_factura->setNuValor($tb043_iva_facturaForm["nu_valor"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb043_iva_facturaForm["fe_desde"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb043_iva_factura->setFeDesde($fecha);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb043_iva_facturaForm["fe_hasta"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb043_iva_factura->setFeHasta($fecha);
                                                        
        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb043_iva_facturaForm)){
            $tb043_iva_factura->setInActivo(false);
        }else{
            $tb043_iva_factura->setInActivo(true);
        }
                                
        /*CAMPOS*/
        $tb043_iva_factura->save($con);
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
	$codigo = $this->getRequestParameter("co_iva_factura");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb043_iva_factura = Tb043IvaFacturaPeer::retrieveByPk($codigo);			
	$tb043_iva_factura->delete($con);
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
                $nu_valor      =   $this->getRequestParameter("nu_valor");
            $fe_desde      =   $this->getRequestParameter("fe_desde");
            $fe_hasta      =   $this->getRequestParameter("fe_hasta");
            $in_activo      =   $this->getRequestParameter("in_activo");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($nu_valor!=""){$c->add(Tb043IvaFacturaPeer::nu_valor,$nu_valor);}
    
                                    
        if($fe_desde!=""){
    list($dia, $mes,$anio) = explode("/",$fe_desde);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb043IvaFacturaPeer::fe_desde,$fecha);
    }
                                    
        if($fe_hasta!=""){
    list($dia, $mes,$anio) = explode("/",$fe_hasta);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb043IvaFacturaPeer::fe_hasta,$fecha);
    }
                                    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb043IvaFacturaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb043IvaFacturaPeer::CO_IVA_FACTURA);
        
    $stmt = Tb043IvaFacturaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_iva_factura"     => trim($res["co_iva_factura"]),
            "nu_valor"     => trim($res["nu_valor"]),
            "fe_desde"     => trim($res["fe_desde"]),
            "fe_hasta"     => trim($res["fe_hasta"]),
            "in_activo"     => trim($res["in_activo"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                        


}