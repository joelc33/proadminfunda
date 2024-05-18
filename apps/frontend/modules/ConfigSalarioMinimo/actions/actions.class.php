<?php

/**
 * ConfigSalarioMinimo actions.
 *
 * @package    gobel
 * @subpackage ConfigSalarioMinimo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConfigSalarioMinimoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('ConfigSalarioMinimo', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('ConfigSalarioMinimo', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh096SalarioMinimoPeer::ID,$codigo);
        
        $stmt = Tbrh096SalarioMinimoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "mo_salario_minimo"     => $campos["mo_salario_minimo"],
                            "fe_ini"     => $campos["fe_ini"],
                            "fe_fin"     => $campos["fe_fin"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "mo_salario_minimo"     => "",
                            "fe_ini"     => "",
                            "fe_fin"     => "",
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
         $tbrh096_salario_minimo = Tbrh096SalarioMinimoPeer::retrieveByPk($codigo);
     }else{
         $tbrh096_salario_minimo = new Tbrh096SalarioMinimo();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh096_salario_minimoForm = $this->getRequestParameter('tbrh096_salario_minimo');
/*CAMPOS*/
                                        
        /*Campo tipo NUMERIC */
        $tbrh096_salario_minimo->setMoSalarioMinimo($tbrh096_salario_minimoForm["mo_salario_minimo"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tbrh096_salario_minimoForm["fe_ini"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh096_salario_minimo->setFeIni($fecha);
                                                
        if($tbrh096_salario_minimoForm["fe_fin"]!=null){
          /*Campo tipo DATE */
          list($dia, $mes, $anio) = explode("/",$tbrh096_salario_minimoForm["fe_fin"]);
          $fecha = $anio."-".$mes."-".$dia;
          $tbrh096_salario_minimo->setFeFin($fecha);
        }else{
          $tbrh096_salario_minimo->setFeFin(null);
        }
                                
        /*CAMPOS*/
        $tbrh096_salario_minimo->save($con);
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
  
    public function executeHabilitar(sfWebRequest $request)
    {
      $codigo = $this->getRequestParameter("id");
      $con = Propel::getConnection();
      try
      { 
      $con->beginTransaction();
      /*CAMPOS*/
      $tbrh096_salario_minimo = Tbrh096SalarioMinimoPeer::retrieveByPk($codigo);
      $tbrh096_salario_minimo->setInActivo(true);		
      $tbrh096_salario_minimo->save($con);
      //$tbrh096_salario_minimo->delete($con);
        $this->data = json_encode(array(
              "success" => true,
              "msg" => 'Registro Activado con exito!'
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


  public function executeEliminar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("id");
    $con = Propel::getConnection();
    try
    { 
    $con->beginTransaction();
    /*CAMPOS*/
    $tbrh096_salario_minimo = Tbrh096SalarioMinimoPeer::retrieveByPk($codigo);
    $tbrh096_salario_minimo->setInActivo(false);		
    $tbrh096_salario_minimo->save($con);
    //$tbrh096_salario_minimo->delete($con);
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
                $mo_salario_minimo      =   $this->getRequestParameter("mo_salario_minimo");
            $fe_ini      =   $this->getRequestParameter("fe_ini");
            $fe_fin      =   $this->getRequestParameter("fe_fin");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($mo_salario_minimo!=""){$c->add(Tbrh096SalarioMinimoPeer::mo_salario_minimo,$mo_salario_minimo);}
    
                                    
        if($fe_ini!=""){
    list($dia, $mes,$anio) = explode("/",$fe_ini);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh096SalarioMinimoPeer::fe_ini,$fecha);
    }
                                    
        if($fe_fin!=""){
    list($dia, $mes,$anio) = explode("/",$fe_fin);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh096SalarioMinimoPeer::fe_fin,$fecha);
    }
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh096SalarioMinimoPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh096SalarioMinimoPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh096SalarioMinimoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        //$c->addAscendingOrderByColumn(Tbrh096SalarioMinimoPeer::ID);
        $c->addDescendingOrderByColumn(Tbrh096SalarioMinimoPeer::ID);
        
    $stmt = Tbrh096SalarioMinimoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "mo_salario_minimo"     => trim($res["mo_salario_minimo"]),
            "fe_ini"     => trim($res["fe_ini"]),
            "fe_fin"     => trim($res["fe_fin"]),
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

                                                                                


}