<?php

/**
 * PresupuestoEjercicioAe actions.
 *
 * @package    gobel
 * @subpackage PresupuestoEjercicioAe
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class PresupuestoEjercicioAeActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('PresupuestoEjercicioAe', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('PresupuestoEjercicioAe', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb166PacAeTmpPeer::ID,$codigo);
        
        $stmt = Tb166PacAeTmpPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb165_pac_tmp"     => $campos["id_tb165_pac_tmp"],
                            "nu_accion_especifica"     => $campos["nu_accion_especifica"],
                            "de_accion_especifica"     => $campos["de_accion_especifica"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb165_pac_tmp"     => $this->getRequestParameter("id_tb165_pac_tmp"),
                            "nu_accion_especifica"     => "",
                            "de_accion_especifica"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb166_pac_ae_tmp = Tb166PacAeTmpPeer::retrieveByPk($codigo);
     }else{
         $tb166_pac_ae_tmp = new Tb166PacAeTmp();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb166_pac_ae_tmpForm = $this->getRequestParameter('tb166_pac_ae_tmp');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tb166_pac_ae_tmp->setIdTb165PacTmp($tb166_pac_ae_tmpForm["id_tb165_pac_tmp"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb166_pac_ae_tmp->setNuAccionEspecifica($tb166_pac_ae_tmpForm["nu_accion_especifica"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb166_pac_ae_tmp->setDeAccionEspecifica($tb166_pac_ae_tmpForm["de_accion_especifica"]);
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tb166_pac_ae_tmpForm)){
            $tb166_pac_ae_tmp->setInActivo(false);
        }else{
            $tb166_pac_ae_tmp->setInActivo(true);
        }*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tb166_pac_ae_tmpForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb166_pac_ae_tmp->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tb166_pac_ae_tmpForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb166_pac_ae_tmp->setUpdatedAt($fecha);*/
                                
        /*CAMPOS*/
        $tb166_pac_ae_tmp->save($con);
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
	$codigo = $this->getRequestParameter("id");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tb166_pac_ae_tmp = Tb166PacAeTmpPeer::retrieveByPk($codigo);			
	$tb166_pac_ae_tmp->delete($con);
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
    $this->data = json_encode(array(
        "id"     => "",
        "id_tb165_pac_tmp"     => $this->getRequestParameter("codigo"),
        "nu_accion_especifica"     => "",
        "de_accion_especifica"     => "",
        "in_activo"     => "",
        "created_at"     => "",
        "updated_at"     => "",
    ));
  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $id_tb165_pac_tmp      =   $this->getRequestParameter("id_tb165_pac_tmp");
            $nu_accion_especifica      =   $this->getRequestParameter("nu_accion_especifica");
            $de_accion_especifica      =   $this->getRequestParameter("de_accion_especifica");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($id_tb165_pac_tmp!=""){$c->add(Tb166PacAeTmpPeer::id_tb165_pac_tmp,$id_tb165_pac_tmp);}
    
                                        if($nu_accion_especifica!=""){$c->add(Tb166PacAeTmpPeer::nu_accion_especifica,'%'.$nu_accion_especifica.'%',Criteria::LIKE);}
        
                                        if($de_accion_especifica!=""){$c->add(Tb166PacAeTmpPeer::de_accion_especifica,'%'.$de_accion_especifica.'%',Criteria::LIKE);}
        
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb166PacAeTmpPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb166PacAeTmpPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb166PacAeTmpPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb166PacAeTmpPeer::ID);

        $c->add(Tb166PacAeTmpPeer::ID_TB165_PAC_TMP,$id_tb165_pac_tmp);
        $c->addSelectColumn(Tb166PacAeTmpPeer::ID);
        $c->addSelectColumn(Tb166PacAeTmpPeer::ID_TB165_PAC_TMP);
        $c->addSelectColumn(Tb166PacAeTmpPeer::NU_ACCION_ESPECIFICA);
        $c->addSelectColumn(Tb166PacAeTmpPeer::DE_ACCION_ESPECIFICA);
        $c->addAsColumn('mo_cargado', 'sp_tb166_pac_ae_tmp_mo_cargado(tb166_pac_ae_tmp.id)');
        
    $stmt = Tb166PacAeTmpPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "id_tb165_pac_tmp"     => trim($res["id_tb165_pac_tmp"]),
            "nu_accion_especifica"     => trim($res["nu_accion_especifica"]),
            "de_accion_especifica"     => trim($res["de_accion_especifica"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "mo_cargado"     => trim($res["mo_cargado"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                    //modelo fk tb165_pac_tmp.ID
    public function executeStorefkidtb165pactmp(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb165PacTmpPeer::doSelectStmt($c);
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