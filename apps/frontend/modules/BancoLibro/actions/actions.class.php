<?php

/**
 * BancoLibro actions.
 *
 * @package    gobel
 * @subpackage BancoLibro
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class BancoLibroActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('BancoLibro', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('BancoLibro', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb100BancoLibroPeer::ID,$codigo);

        $stmt = Tb100BancoLibroPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "nu_libro"     => $campos["nu_libro"],
                            "id_tb010_banco"     => $campos["id_tb010_banco"],
                            "id_tb011_cuenta_bancaria"     => $campos["id_tb011_cuenta_bancaria"],
                            "fe_desde"     => $campos["fe_desde"],
                            "fe_hasta"     => $campos["fe_hasta"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "nu_libro"     => "",
                            "id_tb010_banco"     => "",
                            "id_tb011_cuenta_bancaria"     => "",
                            "fe_desde"     => "",
                            "fe_hasta"     => "",
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
         $tb100_banco_libro = Tb100BancoLibroPeer::retrieveByPk($codigo);
     }else{
         $tb100_banco_libro = new Tb100BancoLibro();
     }
     try
      {
        $con->beginTransaction();

        $tb100_banco_libroForm = $this->getRequestParameter('tb100_banco_libro');
/*CAMPOS*/

        /*Campo tipo VARCHAR */
        $tb100_banco_libro->setNuLibro($tb100_banco_libroForm["nu_libro"]);

        /*Campo tipo BIGINT */
        $tb100_banco_libro->setIdTb010Banco($tb100_banco_libroForm["id_tb010_banco"]);

        /*Campo tipo BIGINT */
        $tb100_banco_libro->setIdTb011CuentaBancaria($tb100_banco_libroForm["id_tb011_cuenta_bancaria"]);

        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb100_banco_libroForm["fe_desde"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb100_banco_libro->setFeDesde($fecha);

        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb100_banco_libroForm["fe_hasta"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb100_banco_libro->setFeHasta($fecha);

        /*Campo tipo BOOLEAN */
        if (array_key_exists("in_activo", $tb100_banco_libroForm)){
            $tb100_banco_libro->setInActivo(false);
        }else{
            $tb100_banco_libro->setInActivo(true);
        }

        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb100_banco_libroForm["created_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb100_banco_libro->setCreatedAt($fecha);

        /*Campo tipo TIMESTAMP */
        list($dia, $mes, $anio) = explode("/",$tb100_banco_libroForm["updated_at"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb100_banco_libro->setUpdatedAt($fecha);

        /*CAMPOS*/
        $tb100_banco_libro->save($con);
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
	$tb100_banco_libro = Tb100BancoLibroPeer::retrieveByPk($codigo);
	$tb100_banco_libro->delete($con);
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
                $nu_libro      =   $this->getRequestParameter("nu_libro");
            $id_tb010_banco      =   $this->getRequestParameter("id_tb010_banco");
            $id_tb011_cuenta_bancaria      =   $this->getRequestParameter("id_tb011_cuenta_bancaria");
            $fe_desde      =   $this->getRequestParameter("fe_desde");
            $fe_hasta      =   $this->getRequestParameter("fe_hasta");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($nu_libro!=""){$c->add(Tb100BancoLibroPeer::nu_libro,'%'.$nu_libro.'%',Criteria::LIKE);}

                                            if($id_tb010_banco!=""){$c->add(Tb100BancoLibroPeer::id_tb010_banco,$id_tb010_banco);}

                                            if($id_tb011_cuenta_bancaria!=""){$c->add(Tb100BancoLibroPeer::id_tb011_cuenta_bancaria,$id_tb011_cuenta_bancaria);}


        if($fe_desde!=""){
    list($dia, $mes,$anio) = explode("/",$fe_desde);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb100BancoLibroPeer::fe_desde,$fecha);
    }

        if($fe_hasta!=""){
    list($dia, $mes,$anio) = explode("/",$fe_hasta);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb100BancoLibroPeer::fe_hasta,$fecha);
    }


        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb100BancoLibroPeer::created_at,$fecha);
    }

        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb100BancoLibroPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb100BancoLibroPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb100BancoLibroPeer::ID);

    $stmt = Tb100BancoLibroPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "nu_libro"     => trim($res["nu_libro"]),
            "id_tb010_banco"     => trim($res["id_tb010_banco"]),
            "id_tb011_cuenta_bancaria"     => trim($res["id_tb011_cuenta_bancaria"]),
            "fe_desde"     => trim($res["fe_desde"]),
            "fe_hasta"     => trim($res["fe_hasta"]),
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

                                //modelo fk tb010_banco.CO_BANCO
    public function executeStorefkidtb010banco(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb010BancoPeer::doSelectStmt($c);
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
                    //modelo fk tb011_cuenta_bancaria.CO_CUENTA_BANCARIA
    public function executeStorefkidtb011cuentabancaria(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tb011CuentaBancariaPeer::doSelectStmt($c);
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
