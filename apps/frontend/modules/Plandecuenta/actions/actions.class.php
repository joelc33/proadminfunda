<?php

/**
 * autoPlandecuenta actions.
 * NombreClaseModel(Tb009PartidaPresupuestaria)
 * NombreTabla(tb009_partida_presupuestaria)
 * @package    ##PROJECT_NAME##
 * @subpackage autoPlandecuenta
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class PlandecuentaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Plandecuenta', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Plandecuenta', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    $tx_prefijo = $this->getRequestParameter("tx_prefijo");
    $nivel = $this->getRequestParameter("nivel");
    
   
    
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tb009PartidaPresupuestariaPeer::CO_PARTIDA_PRESUPUESTARIA,$codigo);
        
        $stmt = Tb009PartidaPresupuestariaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $length = ($campos["co_tipo"]*2)+($campos["co_tipo"]-1);
        
        $this->data = json_encode(array(
                            "co_partida_presupuestaria"  => $campos["co_partida_presupuestaria"],
                            "tx_codigo_cuenta"           => substr($campos["tx_codigo_cuenta"], $length,2),
                            "tx_descripcion"             => $campos["tx_descripcion"],
                            "tx_tipo"                    => $campos["tx_tipo"],
                            "co_tipo"                    => $campos["co_tipo"],
                            "tx_prefijo"                 => substr($campos["tx_codigo_cuenta"], 0, $length)
                    ));
    }else{
        
        if($tx_prefijo==''){
            $tx_prefijo='4.';
        }

        if($nivel==''){
            $nivel='1';
        }else{
            $nivel = $nivel+1;
        }
        
        $this->data = json_encode(array(
                            "co_partida_presupuestaria"     => "",
                            "tx_codigo_cuenta"     => "",
                            "tx_descripcion"     => "",
                            "tx_tipo"     => "",
                            "co_tipo"     => $nivel,
                            "tx_prefijo"  => $tx_prefijo
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

    $codigo = $this->getRequestParameter("co_partida_presupuestaria");
     
    $tb009_partida_presupuestariaForm = $this->getRequestParameter('tb009_partida_presupuestaria');

    if($tb009_partida_presupuestariaForm["tx_codigo_cuenta"]<10){
        $cuenta = '0'.$tb009_partida_presupuestariaForm["tx_codigo_cuenta"];
    }else{
        $cuenta = $tb009_partida_presupuestariaForm["tx_codigo_cuenta"];
    }

    $codigoCuenta = $tb009_partida_presupuestariaForm["tx_prefijo"].$cuenta.".";
      
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb009_partida_presupuestaria = Tb009PartidaPresupuestariaPeer::retrieveByPk($codigo);
     }else{
         $tb009_partida_presupuestaria = new Tb009PartidaPresupuestaria();
         
        $c = new Criteria();
        $c->add(Tb009PartidaPresupuestariaPeer::TX_CODIGO_CUENTA,$codigoCuenta);
        $cantidad = Tb009PartidaPresupuestariaPeer::doCount($c);
        
             
        if($cantidad>0){
            $stmt = Tb009PartidaPresupuestariaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $msg = "El codigo del plan de cuenta <b>".$codigoCuenta."</b> ya se encuentra registrado a la denominación <b>".$campos["tx_descripcion"]."</b>";
            
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $msg
            ));
            
            return 0;
            
        }
      
         
     }
     try
      { 
        $con->beginTransaction();       
            
        $tb009_partida_presupuestaria->setTxCodigoCuenta($codigoCuenta);
        $tb009_partida_presupuestaria->setTxDescripcion($tb009_partida_presupuestariaForm["tx_descripcion"]);
        $tb009_partida_presupuestaria->setTxTipo($tb009_partida_presupuestariaForm["tx_tipo"]);
        $tb009_partida_presupuestaria->setCoTipo($tb009_partida_presupuestariaForm["co_tipo"]);

        $tb009_partida_presupuestaria->save($con);
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
	$tx_codigo_cuenta = $this->getRequestParameter("tx_codigo_cuenta");
	$con = Propel::getConnection();
	try
	{ 
            $con->beginTransaction();

            $c = new Criteria();    
            $c->add(Tb009PartidaPresupuestariaPeer::TX_CODIGO_CUENTA,'%'.$tx_codigo_cuenta.'%',Criteria::LIKE);
            $stmt = Tb009PartidaPresupuestariaPeer::doSelectStmt($c);
            while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
                $tb009_partida_presupuestaria = Tb009PartidaPresupuestariaPeer::retrieveByPk($res["co_partida_presupuestaria"]);			
                $tb009_partida_presupuestaria->delete($con);
            }


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
    
    $tx_codigo_cuenta      =   $this->getRequestParameter("tx_codigo_cuenta");
    $tx_descripcion        =   $this->getRequestParameter("tx_descripcion");
    $tx_tipo               =   $this->getRequestParameter("tx_tipo");
    $co_tipo               =   $this->getRequestParameter("co_tipo");
    
    
    $c = new Criteria();
    
    if($tx_codigo_cuenta!=""){$c->add(Tb009PartidaPresupuestariaPeer::TX_CODIGO_CUENTA,'%'.$tx_codigo_cuenta.'%',Criteria::LIKE);}

    if($tx_descripcion!=""){$c->add(Tb009PartidaPresupuestariaPeer::TX_DESCRIPCION,'%'.$tx_descripcion.'%',Criteria::LIKE);}

    if($tx_tipo!=""){$c->add(Tb009PartidaPresupuestariaPeer::TX_TIPO,'%'.$tx_tipo.'%',Criteria::LIKE);}

    if($co_tipo!=""){$c->add(Tb009PartidaPresupuestariaPeer::CO_TIPO,$co_tipo);}
    
    
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb009PartidaPresupuestariaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
    $c->addAscendingOrderByColumn(Tb009PartidaPresupuestariaPeer::TX_CODIGO_CUENTA);
        
    $stmt = Tb009PartidaPresupuestariaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
          $Tipopuc = $res["tx_tipo"];
          $Tipo='';
          if($Tipopuc=='NO'){
              $Tipo = 'NORMAL';
          }elseif($Tipopuc=='OB'){
              $Tipo = 'OBRAS';
          }else if($Tipopuc=='EQ'){
              $Tipo = 'EQUIPOS';
          }else if($Tipopuc=='TR'){
              $Tipo = 'TRANSFERENCIA';
          }else if($Tipopuc=='RH'){
              $Tipo = 'RECURSOS HUMANOS';
          }
                
         $registros[] = array(
            "co_partida_presupuestaria"     => trim($res["co_partida_presupuestaria"]),
            "tx_codigo_cuenta"              => trim($res["tx_codigo_cuenta"]),
            "tx_descripcion"                => trim($res["tx_descripcion"]),
            "tx_tipo"                       => trim($Tipo),
            "co_tipo"                       => trim($res["co_tipo"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }
    
    public function executeStorefkcotipocuenta(sfWebRequest $request){
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tb021TipoPartidaPresupuestariaPeer::TX_TIPO_PARTIDA_PRESUPUESTARIA);
        $stmt = Tb021TipoPartidaPresupuestariaPeer::doSelectStmt($c);
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