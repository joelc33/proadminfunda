<?php

/**
 * CatalogoPartida actions.
 *
 * @package    gobel
 * @subpackage CatalogoPartida
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class CatalogoPartidaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('CatalogoPartida', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('CatalogoPartida', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb091PartidaPeer::ID,$codigo);

        $stmt = Tb091PartidaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "co_partida"     => $campos["co_partida"],
                            "nu_partida"     => $campos["nu_partida"],
                            "de_partida"     => $campos["de_partida"],
                            "id_tb013_anio_fiscal"     => $campos["id_tb013_anio_fiscal"],
                            "in_movimiento"     => $campos["in_movimiento"],
                            "nu_nivel"     => $campos["nu_nivel"],
                            "nu_pa"     => $campos["nu_pa"],
                            "nu_ge"     => $campos["nu_ge"],
                            "nu_es"     => $campos["nu_es"],
                            "nu_se"     => $campos["nu_se"],
                            "nu_sse"     => $campos["nu_sse"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "co_partida"     => "",
                            "nu_partida"     => "",
                            "de_partida"     => "",
                            "id_tb013_anio_fiscal"     => "",
                            "in_movimiento"     => "",
                            "nu_nivel"     => "",
                            "nu_pa"     => "",
                            "nu_ge"     => "",
                            "nu_es"     => "",
                            "nu_se"     => "",
                            "nu_sse"     => "",
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
         $tb091_partida = Tb091PartidaPeer::retrieveByPk($codigo);
     }else{
         $tb091_partida = new Tb091Partida();
     }
     try
      {
        $con->beginTransaction();

        $tb091_partidaForm = $this->getRequestParameter('tb091_partida');
/*CAMPOS*/

        /*Campo tipo VARCHAR */
        $tb091_partida->setCoPartida($tb091_partidaForm["co_partida"]);

        /*Campo tipo VARCHAR */
        $tb091_partida->setNuPartida($tb091_partidaForm["nu_partida"]);

        /*Campo tipo VARCHAR */
        $tb091_partida->setDePartida($tb091_partidaForm["de_partida"]);

        /*Campo tipo BIGINT */
        $tb091_partida->setIdTb013AnioFiscal($tb091_partidaForm["id_tb013_anio_fiscal"]);

        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_movimiento", $tb091_partidaForm)){
            $tb091_partida->setInMovimiento(false);
        }else{
            $tb091_partida->setInMovimiento(true);
        }

        /*Campo tipo INTEGER */
        $tb091_partida->setNuNivel($tb091_partidaForm["nu_nivel"]);

        /*Campo tipo VARCHAR */
        $tb091_partida->setNuPa($tb091_partidaForm["nu_pa"]);

        /*Campo tipo VARCHAR */
        $tb091_partida->setNuGe($tb091_partidaForm["nu_ge"]);

        /*Campo tipo VARCHAR */
        $tb091_partida->setNuEs($tb091_partidaForm["nu_es"]);

        /*Campo tipo VARCHAR */
        $tb091_partida->setNuSe($tb091_partidaForm["nu_se"]);

        /*Campo tipo VARCHAR */
        $tb091_partida->setNuSse($tb091_partidaForm["nu_sse"]);

        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb091_partidaForm)){
            $tb091_partida->setInActivo(false);
        }else{
            $tb091_partida->setInActivo(true);
        }

        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb091_partidaForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb091_partida->setCreatedAt($fecha);

        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb091_partidaForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb091_partida->setUpdatedAt($fecha);

        /*CAMPOS*/
        $tb091_partida->save($con);
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
	$tb091_partida = Tb091PartidaPeer::retrieveByPk($codigo);
	$tb091_partida->delete($con);
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
                $co_partida      =   $this->getRequestParameter("co_partida");
            $nu_partida      =   $this->getRequestParameter("nu_partida");
            $de_partida      =   $this->getRequestParameter("de_partida");
            $id_tb013_anio_fiscal      =   $this->getRequestParameter("id_tb013_anio_fiscal");
            $in_movimiento      =   $this->getRequestParameter("in_movimiento");
            $nu_nivel      =   $this->getRequestParameter("nu_nivel");
            $nu_pa      =   $this->getRequestParameter("nu_pa");
            $nu_ge      =   $this->getRequestParameter("nu_ge");
            $nu_es      =   $this->getRequestParameter("nu_es");
            $nu_se      =   $this->getRequestParameter("nu_se");
            $nu_sse      =   $this->getRequestParameter("nu_sse");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($co_partida!=""){$c->add(Tb091PartidaPeer::co_partida,'%'.$co_partida.'%',Criteria::LIKE);}

                                        if($nu_partida!=""){$c->add(Tb091PartidaPeer::nu_partida,'%'.$nu_partida.'%',Criteria::LIKE);}

                                        if($de_partida!=""){$c->add(Tb091PartidaPeer::de_partida,'%'.$de_partida.'%',Criteria::LIKE);}

                                            if($id_tb013_anio_fiscal!=""){$c->add(Tb091PartidaPeer::id_tb013_anio_fiscal,$id_tb013_anio_fiscal);}


                                            if($nu_nivel!=""){$c->add(Tb091PartidaPeer::nu_nivel,$nu_nivel);}

                                        if($nu_pa!=""){$c->add(Tb091PartidaPeer::nu_pa,'%'.$nu_pa.'%',Criteria::LIKE);}

                                        if($nu_ge!=""){$c->add(Tb091PartidaPeer::nu_ge,'%'.$nu_ge.'%',Criteria::LIKE);}

                                        if($nu_es!=""){$c->add(Tb091PartidaPeer::nu_es,'%'.$nu_es.'%',Criteria::LIKE);}

                                        if($nu_se!=""){$c->add(Tb091PartidaPeer::nu_se,'%'.$nu_se.'%',Criteria::LIKE);}

                                        if($nu_sse!=""){$c->add(Tb091PartidaPeer::nu_sse,'%'.$nu_sse.'%',Criteria::LIKE);}



        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb091PartidaPeer::created_at,$fecha);
    }

        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb091PartidaPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb091PartidaPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb091PartidaPeer::ID);

    $stmt = Tb091PartidaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "co_partida"     => trim($res["co_partida"]),
            "nu_partida"     => trim($res["nu_partida"]),
            "de_partida"     => trim($res["de_partida"]),
            "id_tb013_anio_fiscal"     => trim($res["id_tb013_anio_fiscal"]),
            "in_movimiento"     => trim($res["in_movimiento"]),
            "nu_nivel"     => trim($res["nu_nivel"]),
            "nu_pa"     => trim($res["nu_pa"]),
            "nu_ge"     => trim($res["nu_ge"]),
            "nu_es"     => trim($res["nu_es"]),
            "nu_se"     => trim($res["nu_se"]),
            "nu_sse"     => trim($res["nu_sse"]),
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

    //modelo fk tb013_anio_fiscal.CO_ANIO_FISCAL
    public function executeStorefkidtb013aniofiscal(sfWebRequest $request){
      $c = new Criteria();
      $stmt = Tb013AnioFiscalPeer::doSelectStmt($c);
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

    //modelo fk tb013_anio_fiscal.CO_ANIO_FISCAL
    public function executeStorefknupa(sfWebRequest $request){
      $c = new Criteria();
      $c->add(Tb091PartidaPeer::NU_NIVEL, 2);
      $c->addAscendingOrderByColumn(Tb091PartidaPeer::NU_PA);
      $stmt = Tb091PartidaPeer::doSelectStmt($c);
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

    //modelo fk tb013_anio_fiscal.CO_ANIO_FISCAL
    public function executeStorefknuge(sfWebRequest $request){
      $c = new Criteria();
      $c->add(Tb091PartidaPeer::NU_NIVEL, 2);
      $c->addAscendingOrderByColumn(Tb091PartidaPeer::NU_GE);
      $stmt = Tb091PartidaPeer::doSelectStmt($c);
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
