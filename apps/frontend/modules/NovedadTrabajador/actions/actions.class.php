<?php

/**
 * NovedadTrabajador actions.
 *
 * @package    gobel
 * @subpackage NovedadTrabajador
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class NovedadTrabajadorActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('NovedadTrabajador', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('NovedadTrabajador', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeBuscar(sfWebRequest $request)
  {

    $nu_cedula     = $this->getRequestParameter('nu_cedula');

    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_TRABAJADOR);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NU_CEDULA);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_NOMBRE);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_NOMBRE);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_PRIMER_APELLIDO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::NB_SEGUNDO_APELLIDO);
    $c->addSelectColumn(Tbrh001TrabajadorPeer::CO_DOCUMENTO);
    $c->addSelectColumn(Tbrh002FichaPeer::CO_FICHA);
    $c->addJoin(Tbrh001TrabajadorPeer::CO_TRABAJADOR,Tbrh002FichaPeer::CO_TRABAJADOR);
    $c->add(Tbrh001TrabajadorPeer::NU_CEDULA,$nu_cedula);
    $c->add(Tbrh002FichaPeer::CO_ESTATUS,1);
    
    $stmt = Tbrh001TrabajadorPeer::doSelectStmt($c);
    
    $campos = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->data = json_encode(
      array('data' => 
        array(
          "co_trabajador"             => $campos["co_trabajador"],
          "nu_cedula"                 => $campos["nu_cedula"],
          "nb_primer_nombre"          => $campos["nb_primer_nombre"],
          "nb_segundo_nombre"         => $campos["nb_segundo_nombre"],
          "nb_primer_apellido"        => $campos["nb_primer_apellido"],
          "nb_segundo_apellido"       => $campos["nb_segundo_apellido"],
          "nb_trabajador"       => $campos["nb_primer_nombre"].' '.$campos["nb_segundo_nombre"].' '.$campos["nb_primer_apellido"].' '.$campos["nb_segundo_apellido"],
          "co_ficha"              => $campos["co_ficha"],
    )));
          

    $this->setTemplate('store');

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tbrh095TrabajadorNovedadPeer::ID,$codigo);
        
        $stmt = Tbrh095TrabajadorNovedadPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "nu_cedula"     => $campos["nu_cedula"],
                            "nb_trabajador"     => $campos["nb_trabajador"],
                            "nu_concepto"     => $campos["nu_concepto"],
                            "nu_valor"     => $campos["nu_valor"],
                            "fe_novedad"     => $campos["fe_novedad"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "fe_ejecucion"     => $campos["fe_ejecucion"],
                            "nu_nomina"     => $campos["nu_nomina"],
                            "tx_grupo_nomina"     => $campos["tx_grupo_nomina"],
                            "co_ficha"     => $campos["co_ficha"],
                            "co_tp_nomina"     => $campos["co_tp_nomina"],
                            "co_grupo_nomina"     => $campos["co_grupo_nomina"],
                            "co_concepto"     => $campos["co_concepto"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "co_solicitud"     => $this->getRequestParameter("co_solicitud"),
                            "nu_cedula"     => "",
                            "nb_trabajador"     => "",
                            "nu_concepto"     => "",
                            "nu_valor"     => "",
                            "fe_novedad"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                            "fe_ejecucion"     => "",
                            "nu_nomina"     => "",
                            "tx_grupo_nomina"     => "",
                            "co_ficha"     => "",
                            "co_tp_nomina"     => "",
                            "co_grupo_nomina"     => "",
                            "co_concepto"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh095_trabajador_novedad = Tbrh095TrabajadorNovedadPeer::retrieveByPk($codigo);
     }else{
         $tbrh095_trabajador_novedad = new Tbrh095TrabajadorNovedad();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh095_trabajador_novedadForm = $this->getRequestParameter('tbrh095_trabajador_novedad');
/*CAMPOS*/
                                        
        /*Campo tipo BIGINT */
        $tbrh095_trabajador_novedad->setCoSolicitud($tbrh095_trabajador_novedadForm["co_solicitud"]);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh095_trabajador_novedad->setNuCedula($tbrh095_trabajador_novedadForm["nu_cedula"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh095_trabajador_novedad->setNbTrabajador($tbrh095_trabajador_novedadForm["nb_trabajador"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh095_trabajador_novedad->setNuConcepto($tbrh095_trabajador_novedadForm["nu_concepto"]);
                                                        
        /*Campo tipo NUMERIC */
        $tbrh095_trabajador_novedad->setNuValor($tbrh095_trabajador_novedadForm["nu_valor"]);
                                                                
        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tbrh095_trabajador_novedadForm["fe_novedad"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh095_trabajador_novedad->setFeNovedad($fecha);
                                                        
        /*Campo tipo BOOLEAN */
        /*if (array_key_exists("in_activo", $tbrh095_trabajador_novedadForm)){
            $tbrh095_trabajador_novedad->setInActivo(false);
        }else{
            $tbrh095_trabajador_novedad->setInActivo(true);
        }*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh095_trabajador_novedadForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh095_trabajador_novedad->setCreatedAt($fecha);*/
                                                        
        /*Campo tipo TIMESTAMP */
        /*list($dia, $mes, $anio) = explode("/",$tbrh095_trabajador_novedadForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tbrh095_trabajador_novedad->setUpdatedAt($fecha);*/
                                                                
        /*Campo tipo DATE */
        if (!empty($tbrh095_trabajador_novedadForm["fe_ejecucion"])) {
          list($dia, $mes, $anio) = explode("/",$tbrh095_trabajador_novedadForm["fe_ejecucion"]);
          $fecha = $anio."-".$mes."-".$dia;
          $tbrh095_trabajador_novedad->setFeEjecucion($fecha);
        }else{
          $tbrh095_trabajador_novedad->setFeEjecucion(null);
        }
                                                        
        /*Campo tipo VARCHAR */
        $tbrh095_trabajador_novedad->setNuNomina($tbrh095_trabajador_novedadForm["nu_nomina"]);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh095_trabajador_novedad->setTxGrupoNomina($tbrh095_trabajador_novedadForm["tx_grupo_nomina"]);

        $cedula = $tbrh095_trabajador_novedadForm["nu_cedula"];
        $tipo_nomina = $tbrh095_trabajador_novedadForm["co_tp_nomina"];
        $grupo_nomina = $tbrh095_trabajador_novedadForm["co_grupo_nomina"];

        $ficha = Tbrh095TrabajadorNovedadPeer::ficha( $cedula, $tipo_nomina, $grupo_nomina );
                                                        
        /*Campo tipo BIGINT */
        //$tbrh095_trabajador_novedad->setCoFicha($tbrh095_trabajador_novedadForm["co_ficha"]);
        $tbrh095_trabajador_novedad->setCoFicha($ficha);
                                                        
        /*Campo tipo BIGINT */
        $tbrh095_trabajador_novedad->setCoTpNomina($tbrh095_trabajador_novedadForm["co_tp_nomina"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh095_trabajador_novedad->setCoGrupoNomina($tbrh095_trabajador_novedadForm["co_grupo_nomina"]);

        /*Campo tipo BIGINT */
        $tbrh095_trabajador_novedad->setCoConcepto($tbrh095_trabajador_novedadForm["co_concepto"]);
                                
        /*CAMPOS*/
        $tbrh095_trabajador_novedad->save($con);

        $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tbrh095_trabajador_novedadForm["co_solicitud"]));
        $ruta->setInCargarDato(true)->save($con);
        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());
        
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
	$tbrh095_trabajador_novedad = Tbrh095TrabajadorNovedadPeer::retrieveByPk($codigo);			
	$tbrh095_trabajador_novedad->delete($con);
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

  public function executeCarga(sfWebRequest $request)
  {
    $this->data = json_encode(array(
      "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
      "co_tipo_solicitud"       => $this->getRequestParameter("co_tipo_solicitud"),
      "co_proceso"       => $this->getRequestParameter("co_proceso"),
    ));
  }

  public function executeLista(sfWebRequest $request)
  {
    $this->data = json_encode(array(
      "co_solicitud"       => $this->getRequestParameter("co_solicitud"),
      "co_tipo_solicitud"       => $this->getRequestParameter("co_tipo_solicitud"),
      "co_proceso"       => $this->getRequestParameter("co_proceso"),
    ));
  }

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",500);
    $start      =   $this->getRequestParameter("start",0);
                $co_solicitud      =   $this->getRequestParameter("co_solicitud");
            $nu_cedula      =   $this->getRequestParameter("nu_cedula");
            $nb_trabajador      =   $this->getRequestParameter("nb_trabajador");
            $nu_concepto      =   $this->getRequestParameter("nu_concepto");
            $nu_valor      =   $this->getRequestParameter("nu_valor");
            $fe_novedad      =   $this->getRequestParameter("fe_novedad");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $fe_ejecucion      =   $this->getRequestParameter("fe_ejecucion");
            $nu_nomina      =   $this->getRequestParameter("nu_nomina");
            $tx_grupo_nomina      =   $this->getRequestParameter("tx_grupo_nomina");
            $co_ficha      =   $this->getRequestParameter("co_ficha");
            $co_tp_nomina      =   $this->getRequestParameter("co_tp_nomina");
            $co_grupo_nomina      =   $this->getRequestParameter("co_grupo_nomina");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_solicitud!=""){$c->add(Tbrh095TrabajadorNovedadPeer::CO_SOLICITUD,$co_solicitud);}
    
                                            if($nu_cedula!=""){$c->add(Tbrh095TrabajadorNovedadPeer::nu_cedula,$nu_cedula);}
    
                                        if($nb_trabajador!=""){$c->add(Tbrh095TrabajadorNovedadPeer::nb_trabajador,'%'.$nb_trabajador.'%',Criteria::LIKE);}
        
                                        if($nu_concepto!=""){$c->add(Tbrh095TrabajadorNovedadPeer::nu_concepto,'%'.$nu_concepto.'%',Criteria::LIKE);}
        
                                            if($nu_valor!=""){$c->add(Tbrh095TrabajadorNovedadPeer::nu_valor,$nu_valor);}
    
                                    
        if($fe_novedad!=""){
    list($dia, $mes,$anio) = explode("/",$fe_novedad);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh095TrabajadorNovedadPeer::fe_novedad,$fecha);
    }
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh095TrabajadorNovedadPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh095TrabajadorNovedadPeer::updated_at,$fecha);
    }
                                    
        if($fe_ejecucion!=""){
    list($dia, $mes,$anio) = explode("/",$fe_ejecucion);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh095TrabajadorNovedadPeer::fe_ejecucion,$fecha);
    }
                                        if($nu_nomina!=""){$c->add(Tbrh095TrabajadorNovedadPeer::nu_nomina,'%'.$nu_nomina.'%',Criteria::LIKE);}
        
                                        if($tx_grupo_nomina!=""){$c->add(Tbrh095TrabajadorNovedadPeer::tx_grupo_nomina,'%'.$tx_grupo_nomina.'%',Criteria::LIKE);}
        
                                            if($co_ficha!=""){$c->add(Tbrh095TrabajadorNovedadPeer::co_ficha,$co_ficha);}
    
                                            if($co_tp_nomina!=""){$c->add(Tbrh095TrabajadorNovedadPeer::co_tp_nomina,$co_tp_nomina);}
    
                                            if($co_grupo_nomina!=""){$c->add(Tbrh095TrabajadorNovedadPeer::co_grupo_nomina,$co_grupo_nomina);}
    
                    }
    $c->setIgnoreCase(true);
    $c->add(Tbrh095TrabajadorNovedadPeer::CO_SOLICITUD,$co_solicitud);
    $cantidadTotal = Tbrh095TrabajadorNovedadPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh095TrabajadorNovedadPeer::ID);
        
    $stmt = Tbrh095TrabajadorNovedadPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "co_solicitud"     => trim($res["co_solicitud"]),
            "nu_cedula"     => trim($res["nu_cedula"]),
            "nb_trabajador"     => trim($res["nb_trabajador"]),
            "nu_concepto"     => trim($res["nu_concepto"]),
            "nu_valor"     => trim($res["nu_valor"]),
            "fe_novedad"     => trim($res["fe_novedad"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "fe_ejecucion"     => trim($res["fe_ejecucion"]),
            "nu_nomina"     => trim($res["nu_nomina"]),
            "tx_grupo_nomina"     => trim($res["tx_grupo_nomina"]),
            "co_ficha"     => trim($res["co_ficha"]),
            "co_tp_nomina"     => trim($res["co_tp_nomina"]),
            "co_grupo_nomina"     => trim($res["co_grupo_nomina"]),
            "fe_ejecucion"     => trim($res["fe_ejecucion"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                                                                                                                                            
    //modelo fk tbrh017_tp_nomina.CO_TP_NOMINA
    public function executeStorefkcotpnomina(sfWebRequest $request){
      /*$c = new Criteria();
      $stmt = Tbrh017TpNominaPeer::doSelectStmt($c);*/

      $co_ficha     = $this->getRequestParameter('co_ficha');

      $c = new Criteria();
      $c->clearSelectColumns();
      $c->addSelectColumn(Tbrh017TpNominaPeer::CO_TP_NOMINA);
      $c->addSelectColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
      $c->addSelectColumn(Tbrh017TpNominaPeer::NU_NOMINA);
      $c->addJoin(Tbrh002FichaPeer::CO_FICHA, Tbrh015NomTrabajadorPeer::CO_FICHA);
      $c->addJoin(Tbrh015NomTrabajadorPeer::CO_TP_NOMINA, Tbrh017TpNominaPeer::CO_TP_NOMINA);
      $c->add(Tbrh002FichaPeer::CO_FICHA,$co_ficha);
      $c->add(Tbrh002FichaPeer::CO_ESTATUS,1);
      $c->addGroupByColumn(Tbrh017TpNominaPeer::CO_TP_NOMINA);
      $c->addGroupByColumn(Tbrh017TpNominaPeer::TX_TP_NOMINA);
      $c->addGroupByColumn(Tbrh017TpNominaPeer::NU_NOMINA);
      $stmt = Tbrh002FichaPeer::doSelectStmt($c);

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
                  //modelo fk tbrh067_grupo_nomina.CO_GRUPO_NOMINA
    public function executeStorefkcogruponomina(sfWebRequest $request){
      /*$c = new Criteria();
      $c->add(Tbrh067GrupoNominaPeer::CO_TP_NOMINA, $this->getRequestParameter("tipo"));
      $stmt = Tbrh067GrupoNominaPeer::doSelectStmt($c);*/

      $tipo     = $this->getRequestParameter('tipo');
      $ficha     = $this->getRequestParameter('ficha');

      $c = new Criteria();
      $c->clearSelectColumns();
      $c->addSelectColumn(Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);
      $c->addSelectColumn(Tbrh067GrupoNominaPeer::TX_GRUPO_NOMINA);
      $c->addSelectColumn(Tbrh067GrupoNominaPeer::COD_GRUPO_NOMINA);
      //$c->addJoin(Tbrh015NomTrabajadorPeer::CO_FICHA, Tbrh002FichaPeer::CO_FICHA);
      $c->addJoin(Tbrh015NomTrabajadorPeer::CO_GRUPO_NOMINA, Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);
      $c->add(Tbrh015NomTrabajadorPeer::CO_TP_NOMINA,$tipo);
      $c->add(Tbrh015NomTrabajadorPeer::CO_FICHA,$ficha);
      //$c->add(Tbrh002FichaPeer::CO_ESTATUS,1);
      $c->addGroupByColumn(Tbrh067GrupoNominaPeer::CO_GRUPO_NOMINA);
      $c->addGroupByColumn(Tbrh067GrupoNominaPeer::TX_GRUPO_NOMINA);
      $c->addGroupByColumn(Tbrh067GrupoNominaPeer::COD_GRUPO_NOMINA);

      //echo $c->toString(); exit();

      $stmt = Tbrh015NomTrabajadorPeer::doSelectStmt($c);
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

    //modelo fk tbrh014_concepto.CO_CONCEPTO
    public function executeStorefkcoconcepto(sfWebRequest $request){
      $c = new Criteria();
      $c->add(Tbrh014ConceptoPeer::IN_HOJA_TIEMPO, true);
      $stmt = Tbrh014ConceptoPeer::doSelectStmt($c);
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


  public function executeGuardarCarga(sfWebRequest $request)
  {

    if($_FILES['documento']['tmp_name']==''){
      $this->data = json_encode(array(
          "success" => false,
          "msg" =>  "Debe Seleccionar un archivo xlsx"
      ));
      
      echo $this->data;
      return sfView::NONE;
    }

    $con = Propel::getConnection();

    $lines = file($_FILES['documento']['tmp_name']);
    $i=0;
    $contador=0;

    $data = new Spreadsheet_Excel_Reader();
    $data->setOutputEncoding('CP1251');
    $data->read($_FILES['documento']['tmp_name']);

    try
    { 
      $con->beginTransaction();

      $tbrh095_trabajador_novedadForm = $this->getRequestParameter('tbrh095_trabajador_novedad');

      $borrar = new Criteria();
      $borrar->add(Tbrh095TrabajadorNovedadPeer::CO_SOLICITUD, $tbrh095_trabajador_novedadForm["co_solicitud"], Criteria::EQUAL);
      BasePeer::doDelete($borrar, $con);

      $con->commit();

    }catch (PropelException $e)
    {
      $con->rollback();
      
      $this->data = json_encode(array(
          "success" => false,
          "msg" =>  $e->getMessage()
      ));

      echo $this->data;
      return sfView::NONE;

    }
    
    for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++){

      $contador=$contador+1;

      $cedula = (int)trim($data->sheets[0]['cells'][$i][1]);
      $nombre = trim($data->sheets[0]['cells'][$i][2]);
      $nomina = trim($data->sheets[0]['cells'][$i][3]);
      $nomina_grupo = trim($data->sheets[0]['cells'][$i][4]);
      $cargo = trim($data->sheets[0]['cells'][$i][5]);
      $concepto = trim($data->sheets[0]['cells'][$i][6]);
      $valor = trim($data->sheets[0]['cells'][$i][7]);
      //$fecha_novedad = date("Y-m-d", strtotime(trim($data->sheets[0]['cells'][$i][8])));
      $fecha_novedad = date('Y-m-d',strtotime(str_replace('/','-', trim($data->sheets[0]['cells'][$i][8]))));
      $fecha_ejecucion = date("Y-m-d", strtotime(trim($data->sheets[0]['cells'][$i][9])));

      //var_dump($fecha_novedad);exit();

      $cn_trabajador = Tbrh001TrabajadorPeer::contar($cedula);

      if($cn_trabajador==0){
        
        $this->data = json_encode(array(
          "success" => false,
          "msg" =>  "Cedula de trabajador no Existe!, Linea: ".$i
        ));
        
        echo $this->data;
        return sfView::NONE;

      }

      $cn_nomina = Tbrh067GrupoNominaPeer::contar( $nomina, $nomina_grupo);

      if($cn_nomina==0){

        $this->data = json_encode(array(
          "success" => false,
          "msg" =>  "Nonima de trabajador no Existe!, Linea: ".$i
        ));

        echo $this->data;
        return sfView::NONE;

      }else{

        $nomina_lista = Tbrh067GrupoNominaPeer::consultar( $nomina, $nomina_grupo);

        $co_tp_nomina = $nomina_lista['co_tp_nomina'];
        $co_grupo_nomina = $nomina_lista['co_grupo_nomina'];
        $ficha = Tbrh095TrabajadorNovedadPeer::ficha( $cedula, $co_tp_nomina, $co_grupo_nomina );

      }

      /*if (!checkdate($mes_novedad, $dia_novedad, $anio_novedad)) {

        $this->data = json_encode(array(
          "success" => false,
          "msg" =>  "Formato de Fecha de Novedad no es valido! Formato(DD-MM-YYYY), Linea: ".$i
        ));

        echo $this->data;
        return sfView::NONE;

      }*/

      try
       { 
         $con->beginTransaction();
         $tbrh095_trabajador_novedadForm = $this->getRequestParameter('tbrh095_trabajador_novedad');

         $tbrh095_trabajador_novedad = new Tbrh095TrabajadorNovedad();
         $tbrh095_trabajador_novedad->setCoSolicitud($tbrh095_trabajador_novedadForm["co_solicitud"]);
         $tbrh095_trabajador_novedad->setNuCedula($cedula);
         $tbrh095_trabajador_novedad->setNbTrabajador($nombre);
         $tbrh095_trabajador_novedad->setNuNomina($nomina);
         $tbrh095_trabajador_novedad->setTxGrupoNomina($nomina_grupo);
         $tbrh095_trabajador_novedad->setCoFicha($ficha);
         $tbrh095_trabajador_novedad->setDeCargo($cargo);
         $tbrh095_trabajador_novedad->setCoTpNomina($co_tp_nomina);
         $tbrh095_trabajador_novedad->setCoGrupoNomina($co_grupo_nomina);
         $tbrh095_trabajador_novedad->setNuConcepto($concepto);
         $tbrh095_trabajador_novedad->setNuValor($valor);
         $tbrh095_trabajador_novedad->setFeNovedad($fecha_novedad);                                           
         if(!empty(trim($data->sheets[0]['cells'][$i][9]))){
           $tbrh095_trabajador_novedad->setFeEjecucion($fecha_ejecucion);
         }else{
           $tbrh095_trabajador_novedad->setFeEjecucion(null);
         }
         $tbrh095_trabajador_novedad->save($con);

         $con->commit();

        }catch (PropelException $e)
        {
          $con->rollback();
          
          $this->data = json_encode(array(
              "success" => false,
              "msg" =>  $e->getMessage()
          ));

          echo $this->data;
          return sfView::NONE;

        }

    }

    /*if(array_key_exists("documento", $_FILES)){

      if($_FILES["documento"]["tmp_name"]!='')
      {
        require_once dirname(__FILE__).'/../../../../../plugins/reader/Classes/PHPExcel/IOFactory.php';

        //Funciones extras

        function get_cell($cell, $objPHPExcel){
          //seleccionar una celda
          $objCell = ($objPHPExcel->getActiveSheet()->getCell($cell));
          //tomar valor de la celda
          return $objCell->getvalue();
        }

        function pp(&$var){
          $var = chr(ord($var)+1);
          return true;
        }

        $name	  = $_FILES['documento']['name'];
        $tname 	  = $_FILES['documento']['tmp_name'];
        $type 	  = $_FILES['documento']['type'];

        if($type == 'application/vnd.ms-excel')
        {
          // Extension excel 97
          $ext = 'xls';
        }
        else if($type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
        {
          // Extension excel 2007 y 2010
          $ext = 'xlsx';
        }else{
          // Extension no valida
          echo -1;
          exit();
        }

        $xlsx = 'Excel2007';
        $xls  = 'Excel5';

        //creando el lector
        $objReader = PHPExcel_IOFactory::createReader($$ext);

        //cargamos el archivo
        $objPHPExcel = $objReader->load($tname);

        $dim = $objPHPExcel->getActiveSheet()->calculateWorksheetDimension();

        // list coloca en array $start y $end
        list($start, $end) = explode(':', $dim);

        if(!preg_match('#([A-Z]+)([0-9]+)#', $start, $rslt)){
          return false;
        }
        list($start, $start_h, $start_v) = $rslt;
        if(!preg_match('#([A-Z]+)([0-9]+)#', $end, $rslt)){
          return false;
        }
        list($end, $end_h, $end_v) = $rslt;

        //empieza  lectura vertical
        $start_v=2;
        $end_v=360;
        for($v=$start_v; $v<=$end_v; $v++){

          //empieza lectura horizontal
          for($h=$start_h; ord($h)<=ord($end_h); pp($h)){

            $cedula = get_cell("A".$v, $objPHPExcel);
            $nombre = get_cell("B".$v, $objPHPExcel);
            $nomina = get_cell("C".$v, $objPHPExcel);
            $nomina_grupo = get_cell("D".$v, $objPHPExcel);
            $cargo = get_cell("E".$v, $objPHPExcel);
            $concepto = get_cell("F".$v, $objPHPExcel);
            $valor = get_cell("G".$v, $objPHPExcel);
            $fecha_novedad = get_cell("H".$v, $objPHPExcel);
            $fecha_ejecucion = get_cell("I".$v, $objPHPExcel);

            $nomina_lista = Tbrh067GrupoNominaPeer::consultar( $nomina, $nomina_grupo);

            $co_tp_nomina = $nomina_lista['co_tp_nomina'];
            $co_grupo_nomina = $nomina_lista['co_grupo_nomina'];
            $ficha = Tbrh095TrabajadorNovedadPeer::ficha( $cedula, $co_tp_nomina, $co_grupo_nomina );

          }

          //var_dump($fecha_novedad);exit();

          if($fecha_novedad!=''||$fecha_novedad!=null){

            try
            { 
              $con->beginTransaction();
              $tbrh095_trabajador_novedadForm = $this->getRequestParameter('tbrh095_trabajador_novedad');
     
              $tbrh095_trabajador_novedad = new Tbrh095TrabajadorNovedad();
              $tbrh095_trabajador_novedad->setCoSolicitud($tbrh095_trabajador_novedadForm["co_solicitud"]);
              $tbrh095_trabajador_novedad->setNuCedula($cedula);
              $tbrh095_trabajador_novedad->setNbTrabajador($nombre);
              $tbrh095_trabajador_novedad->setNuNomina($nomina);
              $tbrh095_trabajador_novedad->setTxGrupoNomina($nomina_grupo);
              $tbrh095_trabajador_novedad->setCoFicha($ficha);
              $tbrh095_trabajador_novedad->setDeCargo($cargo);
              $tbrh095_trabajador_novedad->setCoTpNomina($co_tp_nomina);
              $tbrh095_trabajador_novedad->setCoGrupoNomina($co_grupo_nomina);
              $tbrh095_trabajador_novedad->setNuConcepto($concepto);
              $tbrh095_trabajador_novedad->setNuValor($valor);
              $tbrh095_trabajador_novedad->setFeNovedad($fecha_novedad);                                           
              if(!empty(trim($fecha_ejecucion))){
                $tbrh095_trabajador_novedad->setFeEjecucion($fecha_ejecucion);
              }else{
                $tbrh095_trabajador_novedad->setFeEjecucion(null);
              }
              $tbrh095_trabajador_novedad->save($con);
     
              $con->commit();
     
             }catch (PropelException $e)
             {
               $con->rollback();
               
               $this->data = json_encode(array(
                   "success" => false,
                   "msg" =>  $e->getMessage()
               ));
     
               echo $this->data;
               return sfView::NONE;
     
             }

          }

        }

      }
    }*/

    /*if($contador>0){
      $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tbrh095_trabajador_novedadForm["co_solicitud"]));
      $ruta->setInCargarDato(true)->save($con);
      Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());
    }else{
      $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tbrh095_trabajador_novedadForm["co_solicitud"]));
      $ruta->setInCargarDato(false)->save($con);
    }*/

    $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tbrh095_trabajador_novedadForm["co_solicitud"]));
    $ruta->setInCargarDato(true)->save($con);
    Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

    $this->data = json_encode(array(
      "success" => true,
      "cantidad" => $i,
      "msg" => 'Archivo cargado Exitosamente!<br>Cantidad de Registros: '.$contador
    ));

    echo $this->data;
    return sfView::NONE;

  }

}