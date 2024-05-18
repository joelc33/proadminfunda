<?php

/**
 * PresupuestoMasivo actions.
 *
 * @package    gobel
 * @subpackage PresupuestoMasivo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class PresupuestoMasivoActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('PresupuestoMasivo', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('PresupuestoMasivo', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }
  
  public function executeImportar(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");
    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
                $c->add(Tb195ImportarPresupuestoPeer::ID,$codigo);
        
        $stmt = Tb195ImportarPresupuestoPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "nu_ejercicio"     => $campos["nu_ejercicio"],
                            "nu_ejecutor"     => $campos["nu_ejecutor"],
                            "de_ejecutor"     => $campos["de_ejecutor"],
                            "nu_sector"     => $campos["nu_sector"],
                            "co_ac_pr"     => $campos["co_ac_pr"],
                            "nu_proyecto_ac"     => $campos["nu_proyecto_ac"],
                            "de_proyecto_ac"     => $campos["de_proyecto_ac"],
                            "nu_accion_especifica"     => $campos["nu_accion_especifica"],
                            "de_accion_especifica"     => $campos["de_accion_especifica"],
                            "nu_partida"     => $campos["nu_partida"],
                            "nu_desagregado"     => $campos["nu_desagregado"],
                            "nu_fi"     => $campos["nu_fi"],
                            "de_partida"     => $campos["de_partida"],
                            "mo_inicial"     => $campos["mo_inicial"],
                            "co_categoria"     => $campos["co_categoria"],
                            "nu_pa"     => $campos["nu_pa"],
                            "nu_aplicacion"     => $campos["nu_aplicacion"],
                            "nu_area_estrategica"     => $campos["nu_area_estrategica"],
                            "nu_amb"     => $campos["nu_amb"],
                            "tip_gasto"     => $campos["tip_gasto"],
                            "nu_clasificacion_economica"     => $campos["nu_clasificacion_economica"],
                            "tipo_ordenador"     => $campos["tipo_ordenador"],
                            "tp_ingreso"     => $campos["tp_ingreso"],
                            "nu_ff"     => $campos["nu_ff"],
                            "id"     => $campos["id"],
                    ));
    }else{
        $this->data = json_encode(array(
                            "nu_ejercicio"     => "",
                            "nu_ejecutor"     => "",
                            "de_ejecutor"     => "",
                            "nu_sector"     => "",
                            "co_ac_pr"     => "",
                            "nu_proyecto_ac"     => "",
                            "de_proyecto_ac"     => "",
                            "nu_accion_especifica"     => "",
                            "de_accion_especifica"     => "",
                            "nu_partida"     => "",
                            "nu_desagregado"     => "",
                            "nu_fi"     => "",
                            "de_partida"     => "",
                            "mo_inicial"     => "",
                            "co_categoria"     => "",
                            "nu_pa"     => "",
                            "nu_aplicacion"     => "",
                            "nu_area_estrategica"     => "",
                            "nu_amb"     => "",
                            "tip_gasto"     => "",
                            "nu_clasificacion_economica"     => "",
                            "tipo_ordenador"     => "",
                            "tp_ingreso"     => "",
                            "nu_ff"     => "",
                            "id"     => "",
                    ));
    }

  }

  public function executeGuardar(sfWebRequest $request)
  {

            $codigo = $this->getRequestParameter("id");
        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb195_importar_presupuesto = Tb195ImportarPresupuestoPeer::retrieveByPk($codigo);
     }else{
         $tb195_importar_presupuesto = new Tb195ImportarPresupuesto();
     }
     try
      { 
        $con->beginTransaction();
       
        $tb195_importar_presupuestoForm = $this->getRequestParameter('tb195_importar_presupuesto');
/*CAMPOS*/
                                
        /*Campo tipo NUMERIC */
        $tb195_importar_presupuesto->setNuEjercicio($tb195_importar_presupuestoForm["nu_ejercicio"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setNuEjecutor($tb195_importar_presupuestoForm["nu_ejecutor"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setDeEjecutor($tb195_importar_presupuestoForm["de_ejecutor"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setNuSector($tb195_importar_presupuestoForm["nu_sector"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setCoAcPr($tb195_importar_presupuestoForm["co_ac_pr"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setNuProyectoAc($tb195_importar_presupuestoForm["nu_proyecto_ac"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setDeProyectoAc($tb195_importar_presupuestoForm["de_proyecto_ac"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setNuAccionEspecifica($tb195_importar_presupuestoForm["nu_accion_especifica"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setDeAccionEspecifica($tb195_importar_presupuestoForm["de_accion_especifica"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setNuPartida($tb195_importar_presupuestoForm["nu_partida"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setNuDesagregado($tb195_importar_presupuestoForm["nu_desagregado"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setNuFi($tb195_importar_presupuestoForm["nu_fi"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setDePartida($tb195_importar_presupuestoForm["de_partida"]);
                                                        
        /*Campo tipo NUMERIC */
        $tb195_importar_presupuesto->setMoInicial($tb195_importar_presupuestoForm["mo_inicial"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setCoCategoria($tb195_importar_presupuestoForm["co_categoria"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setNuPa($tb195_importar_presupuestoForm["nu_pa"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setNuAplicacion($tb195_importar_presupuestoForm["nu_aplicacion"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setNuAreaEstrategica($tb195_importar_presupuestoForm["nu_area_estrategica"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setNuAmb($tb195_importar_presupuestoForm["nu_amb"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setTipGasto($tb195_importar_presupuestoForm["tip_gasto"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setNuClasificacionEconomica($tb195_importar_presupuestoForm["nu_clasificacion_economica"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setTipoOrdenador($tb195_importar_presupuestoForm["tipo_ordenador"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setTpIngreso($tb195_importar_presupuestoForm["tp_ingreso"]);
                                                        
        /*Campo tipo VARCHAR */
        $tb195_importar_presupuesto->setNuFf($tb195_importar_presupuestoForm["nu_ff"]);
                                        
        /*CAMPOS*/
        $tb195_importar_presupuesto->save($con);
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
	$tb195_importar_presupuesto = Tb195ImportarPresupuestoPeer::retrieveByPk($codigo);			
	$tb195_importar_presupuesto->delete($con);
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
            $nu_ejercicio      =   $this->getRequestParameter("nu_ejercicio");
            $nu_ejecutor      =   $this->getRequestParameter("nu_ejecutor");
            $de_ejecutor      =   $this->getRequestParameter("de_ejecutor");
            $nu_sector      =   $this->getRequestParameter("nu_sector");
            $co_ac_pr      =   $this->getRequestParameter("co_ac_pr");
            $nu_proyecto_ac      =   $this->getRequestParameter("nu_proyecto_ac");
            $de_proyecto_ac      =   $this->getRequestParameter("de_proyecto_ac");
            $nu_accion_especifica      =   $this->getRequestParameter("nu_accion_especifica");
            $de_accion_especifica      =   $this->getRequestParameter("de_accion_especifica");
            $nu_partida      =   $this->getRequestParameter("nu_partida");
            $nu_desagregado      =   $this->getRequestParameter("nu_desagregado");
            $nu_fi      =   $this->getRequestParameter("nu_fi");
            $de_partida      =   $this->getRequestParameter("de_partida");
            $mo_inicial      =   $this->getRequestParameter("mo_inicial");
            $co_categoria      =   $this->getRequestParameter("co_categoria");
            $nu_pa      =   $this->getRequestParameter("nu_pa");
            $nu_aplicacion      =   $this->getRequestParameter("nu_aplicacion");
            $nu_area_estrategica      =   $this->getRequestParameter("nu_area_estrategica");
            $nu_amb      =   $this->getRequestParameter("nu_amb");
            $tip_gasto      =   $this->getRequestParameter("tip_gasto");
            $nu_clasificacion_economica      =   $this->getRequestParameter("nu_clasificacion_economica");
            $tipo_ordenador      =   $this->getRequestParameter("tipo_ordenador");
            $tp_ingreso      =   $this->getRequestParameter("tp_ingreso");
            $nu_ff      =   $this->getRequestParameter("nu_ff");
        
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                if($nu_ejercicio!=""){$c->add(Tb195ImportarPresupuestoPeer::nu_ejercicio,$nu_ejercicio);}
    
                                        if($nu_ejecutor!=""){$c->add(Tb195ImportarPresupuestoPeer::nu_ejecutor,'%'.$nu_ejecutor.'%',Criteria::LIKE);}
        
                                        if($de_ejecutor!=""){$c->add(Tb195ImportarPresupuestoPeer::de_ejecutor,'%'.$de_ejecutor.'%',Criteria::LIKE);}
        
                                        if($nu_sector!=""){$c->add(Tb195ImportarPresupuestoPeer::nu_sector,'%'.$nu_sector.'%',Criteria::LIKE);}
        
                                        if($co_ac_pr!=""){$c->add(Tb195ImportarPresupuestoPeer::co_ac_pr,'%'.$co_ac_pr.'%',Criteria::LIKE);}
        
                                        if($nu_proyecto_ac!=""){$c->add(Tb195ImportarPresupuestoPeer::nu_proyecto_ac,'%'.$nu_proyecto_ac.'%',Criteria::LIKE);}
        
                                        if($de_proyecto_ac!=""){$c->add(Tb195ImportarPresupuestoPeer::de_proyecto_ac,'%'.$de_proyecto_ac.'%',Criteria::LIKE);}
        
                                        if($nu_accion_especifica!=""){$c->add(Tb195ImportarPresupuestoPeer::nu_accion_especifica,'%'.$nu_accion_especifica.'%',Criteria::LIKE);}
        
                                        if($de_accion_especifica!=""){$c->add(Tb195ImportarPresupuestoPeer::de_accion_especifica,'%'.$de_accion_especifica.'%',Criteria::LIKE);}
        
                                        if($nu_partida!=""){$c->add(Tb195ImportarPresupuestoPeer::nu_partida,'%'.$nu_partida.'%',Criteria::LIKE);}
        
                                        if($nu_desagregado!=""){$c->add(Tb195ImportarPresupuestoPeer::nu_desagregado,'%'.$nu_desagregado.'%',Criteria::LIKE);}
        
                                        if($nu_fi!=""){$c->add(Tb195ImportarPresupuestoPeer::nu_fi,'%'.$nu_fi.'%',Criteria::LIKE);}
        
                                        if($de_partida!=""){$c->add(Tb195ImportarPresupuestoPeer::de_partida,'%'.$de_partida.'%',Criteria::LIKE);}
        
                                            if($mo_inicial!=""){$c->add(Tb195ImportarPresupuestoPeer::mo_inicial,$mo_inicial);}
    
                                        if($co_categoria!=""){$c->add(Tb195ImportarPresupuestoPeer::co_categoria,'%'.$co_categoria.'%',Criteria::LIKE);}
        
                                        if($nu_pa!=""){$c->add(Tb195ImportarPresupuestoPeer::nu_pa,'%'.$nu_pa.'%',Criteria::LIKE);}
        
                                        if($nu_aplicacion!=""){$c->add(Tb195ImportarPresupuestoPeer::nu_aplicacion,'%'.$nu_aplicacion.'%',Criteria::LIKE);}
        
                                        if($nu_area_estrategica!=""){$c->add(Tb195ImportarPresupuestoPeer::nu_area_estrategica,'%'.$nu_area_estrategica.'%',Criteria::LIKE);}
        
                                        if($nu_amb!=""){$c->add(Tb195ImportarPresupuestoPeer::nu_amb,'%'.$nu_amb.'%',Criteria::LIKE);}
        
                                        if($tip_gasto!=""){$c->add(Tb195ImportarPresupuestoPeer::tip_gasto,'%'.$tip_gasto.'%',Criteria::LIKE);}
        
                                        if($nu_clasificacion_economica!=""){$c->add(Tb195ImportarPresupuestoPeer::nu_clasificacion_economica,'%'.$nu_clasificacion_economica.'%',Criteria::LIKE);}
        
                                        if($tipo_ordenador!=""){$c->add(Tb195ImportarPresupuestoPeer::tipo_ordenador,'%'.$tipo_ordenador.'%',Criteria::LIKE);}
        
                                        if($tp_ingreso!=""){$c->add(Tb195ImportarPresupuestoPeer::tp_ingreso,'%'.$tp_ingreso.'%',Criteria::LIKE);}
        
                                        if($nu_ff!=""){$c->add(Tb195ImportarPresupuestoPeer::nu_ff,'%'.$nu_ff.'%',Criteria::LIKE);}
        
                        }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tb195ImportarPresupuestoPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb195ImportarPresupuestoPeer::ID);
        
    $stmt = Tb195ImportarPresupuestoPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "nu_ejercicio"     => trim($res["nu_ejercicio"]),
            "nu_ejecutor"     => trim($res["nu_ejecutor"]),
            "de_ejecutor"     => trim($res["de_ejecutor"]),
            "nu_sector"     => trim($res["nu_sector"]),
            "co_ac_pr"     => trim($res["co_ac_pr"]),
            "nu_proyecto_ac"     => trim($res["nu_proyecto_ac"]),
            "de_proyecto_ac"     => trim($res["de_proyecto_ac"]),
            "nu_accion_especifica"     => trim($res["nu_accion_especifica"]),
            "de_accion_especifica"     => trim($res["de_accion_especifica"]),
            "nu_partida"     => trim($res["nu_partida"]),
            "nu_desagregado"     => trim($res["nu_desagregado"]),
            "nu_fi"     => trim($res["nu_fi"]),
            "de_partida"     => trim($res["de_partida"]),
            "mo_inicial"     => trim($res["mo_inicial"]),
            "co_categoria"     => trim($res["co_categoria"]),
            "nu_pa"     => trim($res["nu_pa"]),
            "nu_aplicacion"     => trim($res["nu_aplicacion"]),
            "nu_area_estrategica"     => trim($res["nu_area_estrategica"]),
            "nu_amb"     => trim($res["nu_amb"]),
            "tip_gasto"     => trim($res["tip_gasto"]),
            "nu_clasificacion_economica"     => trim($res["nu_clasificacion_economica"]),
            "tipo_ordenador"     => trim($res["tipo_ordenador"]),
            "tp_ingreso"     => trim($res["tp_ingreso"]),
            "nu_ff"     => trim($res["nu_ff"]),
            "id"     => trim($res["id"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

                                                                                                                                                                                                                                                                                                        
    public function executeGuardarCarga(sfWebRequest $request)
    {

       $con = Propel::getConnection();

       try
        {
          $con->beginTransaction();

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

              $delete = $con->prepare("DELETE FROM tb195_importar_presupuesto WHERE nu_ejercicio = ".$this->getUser()->getAttribute('ejercicio'));
              $delete->execute();

              //empieza  lectura vertical
              $start_v=2;
              $end_v=1133;
              for($v=$start_v; $v<=$end_v; $v++){

                //empieza lectura horizontal
                for($h=$start_h; ord($h)<=ord($end_h); pp($h)){

                  $nu_ejercicio = get_cell("A".$v, $objPHPExcel);
                  
                  if($nu_ejercicio!=$this->getUser()->getAttribute('ejercicio')){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "El Ejercicio debe ser igual al del Sistema!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                  
                  
                  $nu_ejecutor = get_cell("B".$v, $objPHPExcel);
                  
                  if($nu_ejecutor=='' || $nu_ejecutor==null){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "Debe Tener el Ejecutor!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                  
                  
                  $c = new Criteria();
                  $c->clearSelectColumns();
                  $c->add(Tb082EjecutorPeer::IN_ACTIVO,true);
                  $c->add(Tb082EjecutorPeer::NU_EJECUTOR,$nu_ejecutor);
                  $cant_ejecutor = Tb082EjecutorPeer::doCount($c);
                  
                  if($cant_ejecutor!=1){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "El Ejecutor ".$nu_ejecutor." no Esta registrado en el sistema o esta repetido!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                    
                  
                  $de_ejecutor = get_cell("C".$v, $objPHPExcel);
                  $nu_sector = get_cell("D".$v, $objPHPExcel);
                  
                  if($nu_sector=='' || $nu_sector==null){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "Debe Tener el sector!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                  
                  
                  $c = new Criteria();
                  $c->clearSelectColumns();
                  $c->add(Tb080SectorPeer::IN_ACTIVO,true);
                  $c->add(Tb080SectorPeer::NU_SECTOR,$nu_sector);
                  $cant_sector = Tb080SectorPeer::doCount($c);
                  
                  if($cant_sector!=1){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "El Sector ".$nu_sector." no Esta registrado en el sistema o esta repetido!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                  
                  
                  $co_ac_pr = get_cell("E".$v, $objPHPExcel);
                  $nu_proyecto_ac = get_cell("F".$v, $objPHPExcel);
                  
                  if($nu_proyecto_ac=='' || $nu_proyecto_ac==null){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "Debe Tener La Accion Centralizada!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                  
                  
                  $c = new Criteria();
                  $c->clearSelectColumns();
                  $c->add(Tb196AcPredefinidaPeer::NU_ORIGINAL,$nu_proyecto_ac);
                  $cant_ac = Tb196AcPredefinidaPeer::doCount($c);

                  if($cant_ac!=1){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "La Accion Centralizada ".$nu_proyecto_ac." no Esta registrado en el sistema o esta repetido!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                  
                  
                  $de_proyecto_ac = get_cell("G".$v, $objPHPExcel);                                    
                                    
                  $nu_accion_especifica = get_cell("H".$v, $objPHPExcel);
                  
                  if($nu_accion_especifica=='' || $nu_accion_especifica==null){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "Debe Tener La Accion Especifica!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                  
                  
                  $de_accion_especifica = get_cell("I".$v, $objPHPExcel);
                  
                  if($de_accion_especifica=='' || $de_accion_especifica==null){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "Debe Tener Descripcion de La Accion Especifica!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                  
                  
                  $nu_partida = get_cell("J".$v, $objPHPExcel);
                  
                  if($nu_partida=='' || $nu_partida==null){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "Debe Tener La Partida!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                   
                  
                  $nu_desagregado = get_cell("K".$v, $objPHPExcel);
                  
                  if($nu_desagregado=='' || $nu_desagregado==null){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "Debe Tener El Desagregado!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                  
                  
                  $nu_fi = get_cell("L".$v, $objPHPExcel);
                  
                  if($nu_fi=='' || $nu_fi==null){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "Debe Tener La Fuente!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                  
                  
                  $de_partida = get_cell("M".$v, $objPHPExcel);
                  
                  if($de_partida=='' || $de_partida==null){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "Debe Tener La Descripcion de la Partida!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                  
                  
                  $mo_inicial = get_cell("N".$v, $objPHPExcel);
                  
                  if($mo_inicial=='' || $mo_inicial==null){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "Debe Tener El Monto!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                  
                  
                  $co_categoria = get_cell("O".$v, $objPHPExcel);
                  $nu_pa = get_cell("P".$v, $objPHPExcel);
                  $nu_aplicacion = get_cell("Q".$v, $objPHPExcel);
                  
                  if($nu_aplicacion==NULL ||$nu_aplicacion==''){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "Debe tener la Aplicacion!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  } 
                  
                  
                  $c = new Criteria();
                  $c->clearSelectColumns();
                  $c->add(Tb139AplicacionPeer::TX_TIP_APLICACION,$nu_aplicacion);
                  $c->add(Tb139AplicacionPeer::NU_ANIO_FISCAL,$nu_ejercicio);
                  $cant_nu_aplicacion = Tb139AplicacionPeer::doCount($c);
                  
                  if($cant_nu_aplicacion!=1){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "La Aplicacion ".$nu_aplicacion." no Esta registrado en el sistema o esta repetido para el ejercicio fiscal!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                  
                  
                  $nu_area_estrategica = get_cell("R".$v, $objPHPExcel);
                  
                  if($nu_area_estrategica==NULL ||$nu_area_estrategica==''){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "Debe tener El Area Estrategica!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  } 
                  
                  
                  $c = new Criteria();
                  $c->clearSelectColumns();
                  $c->add(Tb185AreaEstrategicaPeer::CO_AREA_ESTRATEGICA,$nu_area_estrategica);
                  $cant_area = Tb185AreaEstrategicaPeer::doCount($c);
                  
                  if($cant_area!=1){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "La Area Estrategica no Esta registrado en el sistema o esta repetido!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                  
                  
                  $nu_amb = get_cell("S".$v, $objPHPExcel);
                  
                  if($nu_amb==NULL ||$nu_amb==''){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "Debe tener El Ambito!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  } 
                  
                  $c = new Criteria();
                  $c->clearSelectColumns();
                  $c->add(Tb138AmbitoPeer::CO_AMBITO,$nu_amb);
                  $cant_ambito = Tb138AmbitoPeer::doCount($c);
                  
                  if($cant_ambito!=1){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "El Ambito no Esta registrado en el sistema!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                   
                  
                  $tip_gasto = get_cell("T".$v, $objPHPExcel);
                  
                  if($tip_gasto==NULL ||$tip_gasto==''){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "Debe tener Tipo de Gasto!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }   
                  
                  $c = new Criteria();
                  $c->clearSelectColumns();
                  $c->add(Tb183TipoGastoPeer::CO_TIPO_GASTO,$tip_gasto);
                  $cant_tipo_gasto = Tb183TipoGastoPeer::doCount($c);
                  
                  if($cant_tipo_gasto!=1){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "El Tipo de gasto no Esta registrado en el sistema!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                   
                  
                  
                  $nu_clasificacion_economica = get_cell("U".$v, $objPHPExcel);
                  
                  if($nu_clasificacion_economica==NULL ||$nu_clasificacion_economica==''){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "Debe tener la Clasificacion Economica!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }   
                  
                  $c = new Criteria();
                  $c->clearSelectColumns();
                  $c->add(Tb184ClasificacionEconomicaPeer::CO_CLASIFICACION_ECONOMICA,$nu_clasificacion_economica);
                  $cant_clasificacion_economica = Tb184ClasificacionEconomicaPeer::doCount($c);
                  
                  if($cant_clasificacion_economica!=1){

                    $this->data = json_encode(array(
                      "success" => false,
                      "msg" =>  "El Tipo de Clasificacion Economica no Esta registrado en el sistema!, Linea: ".$v
                    ));

                    echo $this->data;
                    return sfView::NONE;

                  }                  
                  
                  $tipo_ordenador = get_cell("V".$v, $objPHPExcel);
                  $tp_ingreso = get_cell("W".$v, $objPHPExcel);
                  $nu_ff = get_cell("X".$v, $objPHPExcel);

                }
                               
                

                if($nu_ejercicio!=''||$nu_ejercicio!=null){

                  $tb195_importar_presupuesto = new Tb195ImportarPresupuesto();
                  $tb195_importar_presupuesto->setNuEjercicio($nu_ejercicio);
                  $tb195_importar_presupuesto->setNuEjecutor($nu_ejecutor);
                  $tb195_importar_presupuesto->setDeEjecutor($de_ejecutor);
                  $tb195_importar_presupuesto->setNuSector($nu_sector);
                  $tb195_importar_presupuesto->setCoAcPr($co_ac_pr);
                  $tb195_importar_presupuesto->setNuProyectoAc($nu_proyecto_ac);
                  $tb195_importar_presupuesto->setDeProyectoAc($de_proyecto_ac);
                  $tb195_importar_presupuesto->setNuAccionEspecifica($nu_accion_especifica);
                  $tb195_importar_presupuesto->setDeAccionEspecifica($de_accion_especifica);
                  $tb195_importar_presupuesto->setNuPartida($nu_partida);
                  $tb195_importar_presupuesto->setNuDesagregado($nu_desagregado);
                  $tb195_importar_presupuesto->setNuFi($nu_fi);
                  $tb195_importar_presupuesto->setDePartida($de_partida);
                  $tb195_importar_presupuesto->setMoInicial($mo_inicial);
                  $tb195_importar_presupuesto->setCoCategoria($co_categoria);
                  $tb195_importar_presupuesto->setNuPa($nu_pa);
                  $tb195_importar_presupuesto->setNuAplicacion($nu_aplicacion);
                  $tb195_importar_presupuesto->setNuAreaEstrategica($nu_area_estrategica);
                  $tb195_importar_presupuesto->setNuAmb($nu_amb);
                  $tb195_importar_presupuesto->setTipGasto($tip_gasto);
                  $tb195_importar_presupuesto->setNuClasificacionEconomica($nu_clasificacion_economica);
                  $tb195_importar_presupuesto->setTipoOrdenador($tipo_ordenador);
                  $tb195_importar_presupuesto->setTpIngreso($tp_ingreso);
                  $tb195_importar_presupuesto->setNuFf($nu_ff);
                  $tb195_importar_presupuesto->save($con);

                  $con->commit();

                }

              }

              //importar a tablas temporales
              $sql = 'select (select id from tb080_sector where nu_sector = tb195.nu_sector)as id_tb080_sector ,
              (select id from tb082_ejecutor where nu_ejecutor = tb195.nu_ejecutor and in_activo = true ) as id_tb082_ejecutor,
              nu_proyecto_ac,
              (select de_nombre from tb196_ac_predefinida where nu_original = tb195.nu_proyecto_ac) as de_proyecto_ac,
              nu_ejercicio,1 as id_tb086_tipo_prac, sum(mo_inicial) as mo_presupuesto
              from tb195_importar_presupuesto  tb195
              where nu_ejercicio = :ejercicio
              and  nu_sector is not null
              group by nu_ejercicio,nu_proyecto_ac,nu_ejecutor,nu_sector,de_ejecutor
              order by nu_ejecutor';

              $data = '';
              $stmt = $con->prepare($sql);
              $stmt->execute(
                array(
                  ':ejercicio' => $this->getUser()->getAttribute('ejercicio')
                  )
              );
              //$stmt->execute();

              $delete = $con->prepare("DELETE FROM tb165_pac_tmp WHERE id_tb013_anio_fiscal = ".$this->getUser()->getAttribute('ejercicio'));
              $delete->execute();

              while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){

                $tb165_pac_tmp = new Tb165PacTmp();
                $tb165_pac_tmp->setIdTb080Sector($reg["id_tb080_sector"]);
                $tb165_pac_tmp->setIdTb081SubSector($reg["id_tb081_sub_sector"]);
                $tb165_pac_tmp->setIdTb082Ejecutor($reg["id_tb082_ejecutor"]);
                $tb165_pac_tmp->setNuProyectoAc($reg["nu_proyecto_ac"]);
                $tb165_pac_tmp->setDeProyectoAc($reg["de_proyecto_ac"]);
                $tb165_pac_tmp->setIdTb013AnioFiscal($reg["nu_ejercicio"]);
                $tb165_pac_tmp->setIdTb086TipoPrac($reg["id_tb086_tipo_prac"]);
                $tb165_pac_tmp->setMoPresupuesto($reg["mo_presupuesto"]);
                $tb165_pac_tmp->save($con);

              }

              $sql = 'select (select id from tb165_pac_tmp where id_tb082_ejecutor = (select id from tb082_ejecutor where nu_ejecutor = tb195.nu_ejecutor and in_activo = true) and id_tb013_anio_fiscal = nu_ejercicio and nu_proyecto_ac = tb195.nu_proyecto_ac)as id_tb165_pac_tmp ,
              nu_accion_especifica,de_accion_especifica,true as in_activo
              from tb195_importar_presupuesto  tb195
              where nu_sector is not null AND nu_ejercicio = :ejercicio
              group by nu_ejercicio,nu_accion_especifica,de_accion_especifica,nu_ejecutor,nu_proyecto_ac
              order by nu_ejecutor';

              $data = '';
              $stmt = $con->prepare($sql);
              $stmt->execute(
                array(
                  ':ejercicio' => $this->getUser()->getAttribute('ejercicio')
                  )
              );
              //$stmt->execute();

              $delete = $con->prepare("DELETE FROM tb166_pac_ae_tmp where id_tb165_pac_tmp in
              ( SELECT id from tb165_pac_tmp WHERE id_tb013_anio_fiscal = ".$this->getUser()->getAttribute('ejercicio').")");
              $delete->execute();

              while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){

                $tb166_pac_ae_tmp = new Tb166PacAeTmp();
                $tb166_pac_ae_tmp->setIdTb165PacTmp($reg["id_tb165_pac_tmp"]);
                $tb166_pac_ae_tmp->setNuAccionEspecifica($reg["nu_accion_especifica"]); 
                $tb166_pac_ae_tmp->setDeAccionEspecifica($reg["de_accion_especifica"]);
                $tb166_pac_ae_tmp->save($con);

              }

              $sql = 'select  ( select id from tb166_pac_ae_tmp where id_tb165_pac_tmp =
              (select id from tb165_pac_tmp where id_tb082_ejecutor =
              (select id from tb082_ejecutor where nu_ejecutor = tb195.nu_ejecutor and in_activo = true)
              and id_tb013_anio_fiscal = nu_ejercicio and nu_proyecto_ac = tb195.nu_proyecto_ac) and nu_accion_especifica = tb195.nu_accion_especifica
              ) as id_tb166_pac_ae_tmp ,
              nu_pa,substring(nu_partida,4,2) as nu_ge,substring(nu_partida,6,2) as nu_es,substring(nu_partida,8,2) as nu_se,nu_desagregado as nu_sse,de_partida,true as in_movimiento, true as in_activo,
              mo_inicial,(select co_aplicacion from tb139_aplicacion where tx_tip_aplicacion = tb195.nu_aplicacion and nu_anio_fiscal = tb195.nu_ejercicio ) as nu_aplicacion,3 tipo_ingreso,  nu_amb, nu_ejercicio,nu_clasificacion_economica,nu_area_estrategica,tip_gasto
              from tb195_importar_presupuesto  tb195
              where nu_sector is not null AND nu_ejercicio = :ejercicio
              order by nu_ejecutor,1';

              $data = '';
              $stmt = $con->prepare($sql);
              $stmt->execute(
                array(
                  ':ejercicio' => $this->getUser()->getAttribute('ejercicio')
                  )
              );
              //$stmt->execute();

              $delete = $con->prepare("DELETE FROM tb167_pac_ae_partida_tmp WHERE id_tb013_anio_fiscal = ".$this->getUser()->getAttribute('ejercicio'));
              $delete->execute();

              while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){

                $tb167_pac_ae_partida_tmp = new Tb167PacAePartidaTmp();
                $tb167_pac_ae_partida_tmp->setIdTb166PacAeTmp($reg["id_tb166_pac_ae_tmp"]);
                $tb167_pac_ae_partida_tmp->setNuPa($reg["nu_pa"]);
                $tb167_pac_ae_partida_tmp->setNuGe($reg["nu_ge"]);
                $tb167_pac_ae_partida_tmp->setNuEs($reg["nu_es"]);
                $tb167_pac_ae_partida_tmp->setNuSe($reg["nu_se"]);
                $tb167_pac_ae_partida_tmp->setNuSse($reg["nu_sse"]);
                $tb167_pac_ae_partida_tmp->setDePartida($reg["de_partida"]);
                $tb167_pac_ae_partida_tmp->setInMovimiento(true);
                $tb167_pac_ae_partida_tmp->setMoPartida($reg["mo_inicial"]);
                $tb167_pac_ae_partida_tmp->setIdTb139Aplicacion($reg["nu_aplicacion"]);
                $tb167_pac_ae_partida_tmp->setIdTb140TipoIngreso($reg["tipo_ingreso"]);
                $tb167_pac_ae_partida_tmp->setIdTb138Ambito($reg["nu_amb"]);
                $tb167_pac_ae_partida_tmp->setIdTb013AnioFiscal($reg["nu_ejercicio"]);
                $tb167_pac_ae_partida_tmp->setCoClasificacionEconomica($reg["nu_clasificacion_economica"]);
                $tb167_pac_ae_partida_tmp->setCoAreaEstrategica($reg["nu_area_estrategica"]);      
                $tb167_pac_ae_partida_tmp->setCoTipoGasto($reg["tip_gasto"]);                
                $tb167_pac_ae_partida_tmp->save($con);

              }

            }
          }

          //$con->commit();

          $this->data = json_encode(array(
            'success' => true,
            'msg' => 'Datos importados con exito!'
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

        echo $this->data;
        return sfView::NONE;

      }

}