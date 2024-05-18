<?php

/**
 * Responsable actions.
 *
 * @package    gobel
 * @subpackage Responsable
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class ResponsableActions extends sfActions
{
public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Responsable', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Responsable', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbbn010ResponsablesPeer::CO_RESPONSABLES,$codigo);

        $stmt = Tbbn010ResponsablesPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_responsables"     => $campos["co_responsables"],
                            "tx_nombres"     => $campos["tx_nombres"],
                            "tx_apellidos"     => $campos["tx_apellidos"],
                            "nu_cedula"     => $campos["nu_cedula"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "co_responsables"     => "",
                            "tx_nombres"     => "",
                            "tx_apellidos"     => "",
                            "nu_cedula"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {
            $tbbn010_responsables_Form = $this->getRequestParameter('tbbn010_responsables');
            $codigo = $tbbn010_responsables_Form["co_responsables"];

     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbbn010_responsables = Tbbn010ResponsablesPeer::retrieveByPk($codigo);
     }else{
         $tbbn010_responsables = new Tbbn010Responsables();
     }
     try
      {
        $con->beginTransaction();

      
/*CAMPOS*/
      $t=$tbbn010_responsables_Form["in_activo"];
        /*Campo tipo VARCHAR */
        $tbbn010_responsables->setTxNombres(strtoupper($tbbn010_responsables_Form["tx_nombres"]));
        $tbbn010_responsables->setTxApellidos(strtoupper($tbbn010_responsables_Form["tx_apellidos"]));
        $tbbn010_responsables->setNuCedula(strtoupper($tbbn010_responsables_Form["nu_cedula"]));
        ($t==1)? $tbbn010_responsables->setInActivo(true): $tbbn010_responsables->setInActivo(false);

        /*Campo tipo BOOLEAN */
       

      
        /*Campo tipo BIGINT */
    //    $tb092_clase_producto->setIdTb093FamiliaProducto($tb092_clase_productoForm["id_tb093_familia_producto"]);

        /*CAMPOS*/
       
        $tbbn010_responsables->save($con);
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => "Proceso realizado exitosamente"
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
	$codigo = $this->getRequestParameter("co_responsables");
	$con = Propel::getConnection();
	try
	{
	$con->beginTransaction();
	/*CAMPOS*/
	$tbbn010_responsables = Tbbn010ResponsablesPeer::retrieveByPk($codigo);
	$tbbn010_responsables->delete($con);
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
            $nu_cedula      =   $this->getRequestParameter("nu_cedula");
            $tx_nombres      =   $this->getRequestParameter("tx_nombres");
            $tx_apellidos    =   $this->getRequestParameter("tx_apellidos");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($nu_cedula!=""){$c->add(Tbbn010ResponsablesPeer::NU_CEDULA,$nu_cedula);}
                                if($tx_nombres!=""){$c->add(Tbbn010ResponsablesPeer::TX_NOMBRES,'%'.$tx_nombres.'%',Criteria::LIKE);}
                                if($tx_apellidos!=""){$c->add(Tbbn010ResponsablesPeer::TX_APELLIDOS,'%'.$tx_apellidos.'%',Criteria::LIKE);}
                                }

                               

                    
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbbn010ResponsablesPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbbn010ResponsablesPeer::TX_APELLIDOS);
        $c->addSelectColumn(Tbbn010ResponsablesPeer::CO_RESPONSABLES);
        $c->addSelectColumn(Tbbn010ResponsablesPeer::TX_NOMBRES);
        $c->addSelectColumn(Tbbn010ResponsablesPeer::TX_APELLIDOS);
        $c->addSelectColumn(Tbbn010ResponsablesPeer::NU_CEDULA);
        $c->addSelectColumn(Tbbn010ResponsablesPeer::IN_ACTIVO);
        $c->addSelectColumn(Tbbn010ResponsablesPeer::CREATED_AT);
        $c->addSelectColumn(Tbbn010ResponsablesPeer::UPDATED_AT);
//        $c->addSelectColumn(Tb093FamiliaProductoPeer::DE_FAMILIA_PRODUCTO);
//        $c->addJoin(Tb093FamiliaProductoPeer::ID, Tb092ClaseProductoPeer::ID_TB093_FAMILIA_PRODUCTO);

    $stmt = Tbbn010ResponsablesPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_responsables"     => trim($res["co_responsables"]),
            "nu_cedula"     => trim($res["nu_cedula"]),
            "tx_nombres"     => trim($res["tx_nombres"]),
            "tx_apellidos"     => trim($res["tx_apellidos"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                    //modelo fk tb093_familia_producto.ID
    public function executeStorefkcoresponsable(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbbn010ResponsablesPeer::doSelectStmt($c);
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
