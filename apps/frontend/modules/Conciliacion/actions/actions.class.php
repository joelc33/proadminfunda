<?php

/**
 * Conciliacion actions.
 *
 * @package    gobel
 * @subpackage Conciliacion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class ConciliacionActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('Conciliacion', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('Conciliacion', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb105ConciliacionPeer::ID,$codigo);

        $stmt = Tb105ConciliacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "id"     => $campos["id"],
                            "id_tb010_banco"     => $campos["id_tb010_banco"],
                            "id_tb011_cuenta_bancaria"     => $campos["id_tb011_cuenta_bancaria"],
                            "fe_desde"     => $campos["fe_desde"],
                            "fe_hasta"     => $campos["fe_hasta"],
                            "co_usuario"     => $campos["co_usuario"],
                            "co_solicitud"     => $campos["co_solicitud"],
                            "co_tipo_solicitud"     => $campos["co_tipo_solicitud"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "id"     => "",
                            "id_tb010_banco"     => "",
                            "id_tb011_cuenta_bancaria"     => "",
                            "fe_desde"     => "",
                            "fe_hasta"     => "",
                            "co_usuario"     => "",
                            "co_solicitud"     => "",
                            "co_tipo_solicitud"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }


  public function executeCrear(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");

     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb105_conciliacion = Tb105ConciliacionPeer::retrieveByPk($codigo);
     }else{
         $tb105_conciliacion = new Tb105Conciliacion();
     }
     try
      {
        $con->beginTransaction();

        $tb105_conciliacionForm = $this->getRequestParameter('tb105_conciliacion');
/*CAMPOS*/

        /*Campo tipo BIGINT */
        $tb105_conciliacion->setIdTb010Banco($tb105_conciliacionForm["id_tb010_banco"]);

        /*Campo tipo BIGINT */
        $tb105_conciliacion->setIdTb011CuentaBancaria($tb105_conciliacionForm["id_tb011_cuenta_bancaria"]);

        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb105_conciliacionForm["fe_desde"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb105_conciliacion->setFeDesde($fecha);

        /*Campo tipo DATE */
        list($dia, $mes, $anio) = explode("/",$tb105_conciliacionForm["fe_hasta"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb105_conciliacion->setFeHasta($fecha);

        /*Campo tipo BIGINT */
        $tb105_conciliacion->setCoUsuario($this->getUser()->getAttribute('codigo'));

        /*Campo tipo BIGINT */
        $tb105_conciliacion->setCoSolicitud($tb105_conciliacionForm["co_solicitud"]);

        /*Campo tipo BIGINT */
        $tb105_conciliacion->setCoTipoSolicitud($tb105_conciliacionForm["co_tipo_solicitud"]);

        /*Campo tipo BOOLEAN */
        $tb105_conciliacion->setInActivo(true);

        /*Campo tipo TIMESTAMP */
        $fecha = date("Y-m-d H:i:s");
        $tb105_conciliacion->setCreatedAt($fecha);

        /*Campo tipo TIMESTAMP */
        $tb105_conciliacion->setUpdatedAt($fecha);

        /*CAMPOS*/
        $tb105_conciliacion->save($con);

        $con->commit();

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb105ConciliacionPeer::NU_CONCILIACION);
        $c->add(Tb105ConciliacionPeer::ID, $tb105_conciliacion->getId());
        $stmt = Tb105ConciliacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->data = json_encode(array(
          'success' => true,
          'numero' => $campos["nu_conciliacion"],
          'codigo' => $tb105_conciliacion->getId(),
          'msg' => '<span style="color:green;font-size:13px,">Datos Guardados con exito!.<br>
            Numero de Conciliacion <br><textarea readonly>'.$campos["nu_conciliacion"].'</textarea></span>'
        ));

        /*$ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb105_conciliacionForm["co_solicitud"]));
        $ruta->setInCargarDato(true)->save($con);

        Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());*/

        $con->commit();

      }catch (PropelException $e)
      {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage()
        ));
      }

      $this->setTemplate('store');

    }


  public function executeGuardar(sfWebRequest $request)
  {

     $codigo    = $this->getRequestParameter("id");
     $array_pago = $this->getRequestParameter("json_pago");
     
     $lista_pagos = explode(",",$array_pago);
     
          
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb105_conciliacion = Tb105ConciliacionPeer::retrieveByPk($codigo);
     }else{
         $tb105_conciliacion = new Tb105Conciliacion();
     }
     try
      {
        $con->beginTransaction();

        $tb105_conciliacionForm = $this->getRequestParameter('tb105_conciliacion');

        $tb105_conciliacion->setIdTb010Banco($tb105_conciliacionForm["codigo_banco"]);
        $tb105_conciliacion->setIdTb011CuentaBancaria($tb105_conciliacionForm["codigo_cuenta"]);

        list($dia, $mes, $anio) = explode("-",$tb105_conciliacionForm["fecha_desde"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb105_conciliacion->setFeDesde($fecha);

        list($dia, $mes, $anio) = explode("-",$tb105_conciliacionForm["fecha_hasta"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb105_conciliacion->setFeHasta($fecha);

       
        $tb105_conciliacion->setCoUsuario($this->getUser()->getAttribute('codigo'));
        $tb105_conciliacion->setCoSolicitud($tb105_conciliacionForm["co_solicitud"]);
        $tb105_conciliacion->setCoTipoSolicitud($tb105_conciliacionForm["co_tipo_solicitud"]);
     
        $tb105_conciliacion->save($con);
        
        $update = $con->prepare("UPDATE tb063_pago tb063 SET in_consolidado = false FROM tb128_detalle_conciliacion tb128  where tb063.co_pago = tb128.co_pago and  tb128.co_conciliacion =".$tb105_conciliacion->getId());
        $update->execute();
              
        
        $wherec = new Criteria();
        $wherec->add(Tb128DetalleConciliacionPeer::CO_CONCILIACION, $tb105_conciliacion->getId());
        BasePeer::doDelete($wherec, $con);
        
        $i=0;
        foreach($lista_pagos  as $vp){          
                   
            if($vp[0]!=''){
                $Tb128DetalleConciliacion = new Tb128DetalleConciliacion();
                $Tb128DetalleConciliacion->setCoConciliacion($tb105_conciliacion->getId());
                $Tb128DetalleConciliacion->setCoPago($vp);
                $Tb128DetalleConciliacion->save($con);

                $t063_pago = Tb063PagoPeer::retrieveByPK($vp);
                $t063_pago->setInConsolidado(true)->save($con);
                
                $i++;
            }
            
        }
        
       
                
        $con->commit();

        if($i>0){
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb105_conciliacionForm["co_solicitud"]));
            $ruta->setInCargarDato(true)->save($con);
            Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());
        }else{
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb105_conciliacionForm["co_solicitud"]));
            $ruta->setInCargarDato(false)->save($con);
        }

        $con->commit();
        
        $this->data = json_encode(array(
            'success' => true,
            'msg' => 'Datos Guardados con exito!'
          ));

      }catch (PropelException $e)
      {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage()
        ));
      }
    }


    public function executeGuardarLote(sfWebRequest $request)
    {

       $codigo = $this->getRequestParameter("id");

       $con = Propel::getConnection();
       if($codigo!=''||$codigo!=null){
           $tb105_conciliacion = Tb105ConciliacionPeer::retrieveByPk($codigo);
       }else{
           $tb105_conciliacion = new Tb105Conciliacion();
       }
       try
        {
          $con->beginTransaction();

          $tb105_conciliacionForm = $this->getRequestParameter('tb105_conciliacion');
          /*CAMPOS*/

          /*Campo tipo BIGINT */
          $tb105_conciliacion->setIdTb010Banco($tb105_conciliacionForm["id_tb010_banco"]);
          $id_tb010_banco = $tb105_conciliacionForm["id_tb010_banco"];

          /*Campo tipo BIGINT */
          $tb105_conciliacion->setIdTb011CuentaBancaria($tb105_conciliacionForm["id_tb011_cuenta_bancaria"]);
          $id_tb011_cuenta_bancaria = $tb105_conciliacionForm["id_tb011_cuenta_bancaria"];

          /*Campo tipo DATE */
          list($dia, $mes, $anio) = explode("/",$tb105_conciliacionForm["fe_desde"]);
          $fecha = $anio."-".$mes."-".$dia;
          $tb105_conciliacion->setFeDesde($fecha);

          /*Campo tipo DATE */
          list($dia, $mes, $anio) = explode("/",$tb105_conciliacionForm["fe_hasta"]);
          $fecha = $anio."-".$mes."-".$dia;
          $tb105_conciliacion->setFeHasta($fecha);

          /*Campo tipo BIGINT */
          $tb105_conciliacion->setCoUsuario($this->getUser()->getAttribute('codigo'));

          /*Campo tipo BIGINT */
          $tb105_conciliacion->setCoSolicitud($tb105_conciliacionForm["co_solicitud"]);

          /*Campo tipo BIGINT */
          $tb105_conciliacion->setCoTipoSolicitud($tb105_conciliacionForm["co_tipo_solicitud"]);

          /*Campo tipo BOOLEAN */
          $tb105_conciliacion->setInActivo(true);

          /*Campo tipo TIMESTAMP */
          $fecha = date("Y-m-d H:i:s");
          $tb105_conciliacion->setCreatedAt($fecha);

          /*Campo tipo TIMESTAMP */
          $tb105_conciliacion->setUpdatedAt($fecha);

          /*CAMPOS*/
          $tb105_conciliacion->save($con);

          $con->commit();

          /*MASIVO*/

          if(array_key_exists("archivo", $_FILES)){

            if($_FILES["archivo"]["tmp_name"]!='')
            {
              /** Incluir la clase PHPExcel_IOFactory agregada en el directorio /lib/vendor/PHPExcel */
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

        			$name	  = $_FILES['archivo']['name'];
        			$tname 	  = $_FILES['archivo']['tmp_name'];
        			$type 	  = $_FILES['archivo']['type'];

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

              $delete = $con->prepare("DELETE FROM tb104_banco_conciliacion where id_tb105_conciliacion=".$tb105_conciliacion->getId());
              $delete->execute();

              //empieza  lectura vertical
              $start_v=2;
              $end_v=360;
              for($v=$start_v; $v<=$end_v; $v++){

                //empieza lectura horizontal
                for($h=$start_h; ord($h)<=ord($end_h); pp($h)){
                  //$id_tb010_banco = $id_tb010_banco;
                  //$id_tb011_cuenta_bancaria = $id_tb011_cuenta_bancaria;

                  /*list($dia_detalle, $mes_detalle, $anio_detalle) = explode("/", get_cell("A".$v, $objPHPExcel));
                  $fe_movimiento = $anio_detalle.'-'.$mes_detalle.'-'.$dia_detalle;*/
                  $fe_movimiento = get_cell("A".$v, $objPHPExcel);

                  $de_concepto = get_cell("B".$v, $objPHPExcel);
                  $mo_cargo = get_cell("C".$v, $objPHPExcel);
                  $mo_abono = get_cell("D".$v, $objPHPExcel);
                  $mo_saldo = get_cell("E".$v, $objPHPExcel);
                  $id_tb101_tipo_conciliacion = 2;
                  $id_tb105_conciliacion = $tb105_conciliacion->getId();

                }

                if($fe_movimiento!=''||$fe_movimiento!=null){

                  $tb104_banco_conciliacion = new Tb104BancoConciliacion();
                  $tb104_banco_conciliacion->setIdTb105Conciliacion($id_tb105_conciliacion);
                  $tb104_banco_conciliacion->setIdTb010Banco($id_tb010_banco);
                  $tb104_banco_conciliacion->setIdTb011CuentaBancaria($id_tb011_cuenta_bancaria);
                  $tb104_banco_conciliacion->setFeMovimiento(PHPExcel_Style_NumberFormat::toFormattedString( $fe_movimiento, 'YYYY-MM-DD'));
                  $tb104_banco_conciliacion->setDeConcepto($de_concepto);
                  $tb104_banco_conciliacion->setMoCargo($mo_cargo);
                  $tb104_banco_conciliacion->setMoAbono($mo_abono);
                  $tb104_banco_conciliacion->setMoSaldo($mo_saldo);
                  $tb104_banco_conciliacion->setIdTb101TipoConcilacion($id_tb101_tipo_conciliacion);
                  $tb104_banco_conciliacion->setInActivo(TRUE);
                  $tb104_banco_conciliacion->save($con);

                }

              }

            }
          }

          $c = new Criteria();
          $c->clearSelectColumns();
          $c->addSelectColumn(Tb105ConciliacionPeer::NU_CONCILIACION);
          $c->add(Tb105ConciliacionPeer::ID, $tb105_conciliacion->getId());
          $stmt = Tb105ConciliacionPeer::doSelectStmt($c);
          $campos = $stmt->fetch(PDO::FETCH_ASSOC);

          $this->data = json_encode(array(
            'success' => true,
            'numero' => $campos["nu_conciliacion"],
            'codigo' => $tb105_conciliacion->getId(),
            'msg' => 'Datos Guardados con exito!'
          ));

          $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb105_conciliacionForm["co_solicitud"]));
          $ruta->setInCargarDato(true)->save($con);

          Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());

          $con->commit();

        }catch (PropelException $e)
        {
          $con->rollback();
          $this->data = json_encode(array(
              "success" => false,
              "msg" =>  $e->getMessage()
          ));
        }

        echo $this->data;
        return sfView::NONE;

      }


  public function executeEliminar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("id");
	$con = Propel::getConnection();
	try
	{
	$con->beginTransaction();
	/*CAMPOS*/
	$tb105_conciliacion = Tb105ConciliacionPeer::retrieveByPk($codigo);
	$tb105_conciliacion->delete($con);
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
                $id_tb010_banco      =   $this->getRequestParameter("id_tb010_banco");
            $id_tb011_cuenta_bancaria      =   $this->getRequestParameter("id_tb011_cuenta_bancaria");
            $fe_desde      =   $this->getRequestParameter("fe_desde");
            $fe_hasta      =   $this->getRequestParameter("fe_hasta");
            $co_usuario      =   $this->getRequestParameter("co_usuario");
            $co_solicitud      =   $this->getRequestParameter("co_solicitud");
            $co_tipo_solicitud      =   $this->getRequestParameter("co_tipo_solicitud");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");


    $c = new Criteria();

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($id_tb010_banco!=""){$c->add(Tb105ConciliacionPeer::id_tb010_banco,$id_tb010_banco);}

                                            if($id_tb011_cuenta_bancaria!=""){$c->add(Tb105ConciliacionPeer::id_tb011_cuenta_bancaria,$id_tb011_cuenta_bancaria);}


        if($fe_desde!=""){
    list($dia, $mes,$anio) = explode("/",$fe_desde);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb105ConciliacionPeer::fe_desde,$fecha);
    }

        if($fe_hasta!=""){
    list($dia, $mes,$anio) = explode("/",$fe_hasta);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb105ConciliacionPeer::fe_hasta,$fecha);
    }
                                            if($co_usuario!=""){$c->add(Tb105ConciliacionPeer::co_usuario,$co_usuario);}

                                            if($co_solicitud!=""){$c->add(Tb105ConciliacionPeer::co_solicitud,$co_solicitud);}

                                            if($co_tipo_solicitud!=""){$c->add(Tb105ConciliacionPeer::co_tipo_solicitud,$co_tipo_solicitud);}



        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb105ConciliacionPeer::created_at,$fecha);
    }

        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tb105ConciliacionPeer::updated_at,$fecha);
    }
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb105ConciliacionPeer::doCount($c);

    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb105ConciliacionPeer::ID);

    $stmt = Tb105ConciliacionPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "id"     => trim($res["id"]),
            "id_tb010_banco"     => trim($res["id_tb010_banco"]),
            "id_tb011_cuenta_bancaria"     => trim($res["id_tb011_cuenta_bancaria"]),
            "fe_desde"     => trim($res["fe_desde"]),
            "fe_hasta"     => trim($res["fe_hasta"]),
            "co_usuario"     => trim($res["co_usuario"]),
            "co_solicitud"     => trim($res["co_solicitud"]),
            "co_tipo_solicitud"     => trim($res["co_tipo_solicitud"]),
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
