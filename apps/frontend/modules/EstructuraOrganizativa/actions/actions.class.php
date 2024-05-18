<?php

/**
 * autoEstructuraOrganizativa actions.
 * NombreClaseModel(Tbrh005EstructuraAdministrativa)
 * NombreTabla(tbrh005_estructura_administrativa)
 * @package    ##PROJECT_NAME##
 * @subpackage autoEstructuraOrganizativa
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 16948 2009-04-03 15:52:30Z fabien $
 */
class EstructuraOrganizativaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {        
        
    $this->forward('EstructuraOrganizativa', 'lista');
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->forward('EstructuraOrganizativa', 'editar');
  }

  public function executeFiltro(sfWebRequest $request)
  {

  }

  public function executeEditar(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("codigo");

    if($codigo!=''||$codigo!=null){
        $c = new Criteria();
        $c->add(Tbrh005EstructuraAdministrativaPeer::CO_ESTRUCTURA_ADMINISTRATIVA,$codigo);
        $stmt = Tbrh005EstructuraAdministrativaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->data = json_encode(array(
                            "co_estructura_administrativa"     => $campos["co_estructura_administrativa"],
                            "co_padre"     => $campos["co_padre"],
                            "tx_nom_estructura_administrativa"     => $campos["tx_nom_estructura_administrativa"],
                            "nu_centro_costo"     => $campos["nu_centro_costo"],
                            "co_ente"     => $campos["co_ente"],
                            "co_nivel_jerarquico"     => $campos["co_nivel_jerarquico"],
                            "in_activo"     => $campos["in_activo"],
                            "created_at"     => $campos["created_at"],
                            "updated_at"     => $campos["updated_at"],
                            "co_dependencia"     => $campos["co_dependencia"],
                    ));
    }else{
        
     
        $this->data = json_encode(array(
                            "co_estructura_administrativa"     => "",
                            "co_padre"     => "",
                            "tx_nom_estructura_administrativa"     => "",
                            "nu_centro_costo"     => "",
                            "co_ente"     => "",
                            "co_nivel_jerarquico"     => "",
                            "in_activo"     => "",
                            "created_at"     => "",
                            "updated_at"     => "",
                    ));
    }

  }
  
  public function executeAgregarCargo(sfWebRequest $request)
  {

    $nivel = $this->getRequestParameter("nivel");
    $this->paquete = $this->getRequestParameter("paquete");
    $co_estructura_administrativa = $this->getRequestParameter("co_estructura_administrativa");
    $co_cargo_estructura = $this->getRequestParameter("co_cargo_estructura");
    $tx_estructura_administrativa = $this->getRequestParameter("tx_estructura_administrativa");
        
        $this->data = json_encode(array(
                            "co_cargo_estructura"  => $co_cargo_estructura,
                            "co_estructura_administrativa"  => $co_estructura_administrativa,
                            "tx_estructura_administrativa"  => $tx_estructura_administrativa,
                            "nivel"                      => $nivel+1
                    ));
    

  }  

  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_estructura_administrativa");

        
     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tbrh005_estructura_administrativa = Tbrh005EstructuraAdministrativaPeer::retrieveByPk($codigo);
     }else{
         $tbrh005_estructura_administrativa = new Tbrh005EstructuraAdministrativa();
     }
     try
      { 
        $con->beginTransaction();
       
        $tbrh005_estructura_administrativaForm = $this->getRequestParameter('tbrh005_estructura_administrativa');
/*CAMPOS*/
     $c= new Criteria();
     $c->add(Tbrh005EstructuraAdministrativaPeer::CO_ESTRUCTURA_ADMINISTRATIVA,$tbrh005_estructura_administrativaForm["co_padre"]);
        $stmt = Tbrh005EstructuraAdministrativaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        $co_nivel = $campos["co_nivel_jerarquico"] + 1;        
       
        /*Campo tipo BIGINT */
        if($tbrh005_estructura_administrativaForm["co_padre"]){
        $tbrh005_estructura_administrativa->setCoPadre($tbrh005_estructura_administrativaForm["co_padre"]);
        }else{
        $tbrh005_estructura_administrativa->setCoPadre(0);    
        }                                                
        /*Campo tipo VARCHAR */
        $tbrh005_estructura_administrativa->setTxNomEstructuraAdministrativa($tbrh005_estructura_administrativaForm["tx_nom_estructura_administrativa"]);
                                                        
        /*Campo tipo VARCHAR */
        //$tbrh005_estructura_administrativa->setNuCentroCosto($tbrh005_estructura_administrativaForm["nu_centro_costo"]);
                                                        
        /*Campo tipo BIGINT */
        $tbrh005_estructura_administrativa->setCoEnte(1);
                                                        
        /*Campo tipo BIGINT */
        //$tbrh005_estructura_administrativa->setCoNivelJerarquico($co_nivel);
                                                        

        $tbrh005_estructura_administrativa->setInActivo(true);

        /*CAMPOS*/
        $tbrh005_estructura_administrativa->save($con);
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
  
  public function executeGuardarCargo(sfWebRequest $request)
  {

     $co_estructura_administrativa = $this->getRequestParameter("co_estructura_administrativa");
     $co_cargo = $this->getRequestParameter("co_cargo");
     $nu_nivel = $this->getRequestParameter("nu_nivel");
     $cantidad = $this->getRequestParameter("cantidad");
     $co_padre = $this->getRequestParameter("co_padre");

        for($j=1;$j<=$cantidad;$j++){      
     $con = Propel::getConnection();
     try
      { 
        $con->beginTransaction();
       
/*CAMPOS*/
        $tbrh009_cargo_estructura = new Tbrh009CargoEstructura();

  
        /*Campo tipo VARCHAR */
        $tbrh009_cargo_estructura->setCoEstructuraAdministrativa($co_estructura_administrativa);
                                                        
        /*Campo tipo VARCHAR */
        $tbrh009_cargo_estructura->setCoCargo($co_cargo);
                                                        
        /*Campo tipo BIGINT */
        $tbrh009_cargo_estructura->setNivel($nu_nivel);
        
        $tbrh009_cargo_estructura->setCoPadre($co_padre);

        /*CAMPOS*/
        $tbrh009_cargo_estructura->save($con);
         $con->commit();
        
        
        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Proceso Realizado exitosamente'
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
    }
    
  public function executeEliminar(sfWebRequest $request)
  {
	$codigo = $this->getRequestParameter("co_estructura_administrativa");
	$con = Propel::getConnection();
	try
	{ 
	$con->beginTransaction();
	/*CAMPOS*/
	$tbrh005_estructura_administrativa = Tbrh005EstructuraAdministrativaPeer::retrieveByPk($codigo);			
	$tbrh005_estructura_administrativa->delete($con);
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
      
        $nivel_cero = new Criteria();
        $nivel_cero->add(Tbrh005EstructuraAdministrativaPeer::CO_PADRE,0);
        $this->nivel_cero = Tbrh005EstructuraAdministrativaPeer::doCount($nivel_cero);
        
        $c= new Criteria();
        $c->add(Tbrh005EstructuraAdministrativaPeer::CO_PADRE,0);
        $c->add(Tbrh005EstructuraAdministrativaPeer::IN_ACTIVO,TRUE);
        $c->addAscendingOrderByColumn(Tbrh005EstructuraAdministrativaPeer::CO_ESTRUCTURA_ADMINISTRATIVA);
        
       
        $res = Tbrh005EstructuraAdministrativaPeer::doSelect($c);  
        
      
        $this->Empresa = '';
        
        

        foreach($res as $result){

                $cantidad = $this->cantidad_hijos($result->getCoEstructuraAdministrativa());

                
                if($cantidad > 0)
                {

                       $this->Empresa.= "{
                                 text:'".$result->getTxNomEstructuraAdministrativa()."',
                                 expanded:true,
                                 children:[
                                {
                                    text:'Configurar ".$result->getTxNomEstructuraAdministrativa()."',
                                    iconCls:'icon-editar',
                                    leaf:true,
                                    listeners :{

                                        click: function(){
                                            var msg = Ext.get('formularioEstructuraOrganizativa');
                                                msg.load({
                                                        url: 'EstructuraOrganizativa/CargosLista',
                                                        params:{
                                                        co_estructura_administrativa:".$result->getCoEstructuraAdministrativa().",
                                                        tx_estructura_administrativa:'".$result->getTxNomEstructuraAdministrativa()."',
                                                        co_cargo_estructura:0,    
                                                        nivel:0    
                                                        },                                                        
                                                        scripts: true,
                                                        text: 'Cargando...'
                                                });
						panel_detalle.collapse();
                                        }
                                    }
                                },
                                ".$this->ArmaSubnivel($result->getCoEstructuraAdministrativa())."                                
                                ]     
                                },";

                }else{
                 
                $this->Empresa.= "{
                                    text:'".$result->getTxNomEstructuraAdministrativa()."',
                                    leaf:true,
                                    listeners :{

                                        click: function(){
                                            var msg = Ext.get('formularioEstructuraOrganizativa');
                                                msg.load({
                                                        url: 'EstructuraOrganizativa/CargosLista',
                                                        params:{
                                                        co_estructura_administrativa:".$result->getCoEstructuraAdministrativa().",
                                                        tx_estructura_administrativa:'".$result->getTxNomEstructuraAdministrativa()."',
                                                        co_cargo_estructura:0,    
                                                        nivel:0    
                                                        },                                                        
                                                        scripts: true,
                                                        text: 'Cargando...'
                                                });
						panel_detalle.collapse();
                                        }
                                    }
                                },";                    
                    
                
            }
        }      
      

  }
  
    public function executeEstructura(sfWebRequest $request)
  {   
      

  }  
  
    static public function ArmaSubnivel($co_padre){

        
        $c= new Criteria();
        $c->add(Tbrh005EstructuraAdministrativaPeer::CO_PADRE,$co_padre);
        $c->add(Tbrh005EstructuraAdministrativaPeer::IN_ACTIVO,TRUE);
        $c->addAscendingOrderByColumn(Tbrh005EstructuraAdministrativaPeer::CO_ESTRUCTURA_ADMINISTRATIVA);
        $res = Tbrh005EstructuraAdministrativaPeer::doSelect($c);

        $subnivel = '';

        foreach($res as $result){


            $cantidad_subnivel = self::cantidad_hijos_subnivel($result->getCoEstructuraAdministrativa());
        
            
            if($cantidad_subnivel > 0)
            {
                 $cantidad_hijos = self::cantidad_hijos($result->getCoEstructuraAdministrativa());

                 if($cantidad_hijos > 0){
                       $subnivel.= "{
                                 text:'".$result->getTxNomEstructuraAdministrativa()."',
                                 children:[
                                {
                                    text:'Configurar ".$result->getTxNomEstructuraAdministrativa()."',
                                    iconCls:'icon-editar',
                                    leaf:true,
                                    listeners :{

                                        click: function(){
                                            var msg = Ext.get('formularioEstructuraOrganizativa');
                                                msg.load({
                                                        url: 'EstructuraOrganizativa/CargosLista',
                                                        params:{
                                                        co_estructura_administrativa:".$result->getCoEstructuraAdministrativa().",
                                                        tx_estructura_administrativa:'".$result->getTxNomEstructuraAdministrativa()."',
                                                        co_cargo_estructura:0,    
                                                        nivel:0
                                                        },
                                                        scripts: true,
                                                        text: 'Cargando...'
                                                });
						panel_detalle.collapse();
                                        }
                                    }
                                },
                                ". self::ArmaSubnivel($result->getCoEstructuraAdministrativa())."]
                                },";
                 }

            }else{
        
                $subnivel.= "{
                                    text:'".$result->getTxNomEstructuraAdministrativa()."',
                                    leaf:true,
                                    listeners :{

                                        click: function(){
                                            var msg = Ext.get('formularioEstructuraOrganizativa');
                                                msg.load({
                                                        url: 'EstructuraOrganizativa/CargosLista',
                                                        params:{
                                                        co_estructura_administrativa:".$result->getCoEstructuraAdministrativa().",
                                                        tx_estructura_administrativa:'".$result->getTxNomEstructuraAdministrativa()."',
                                                        co_cargo_estructura:0,    
                                                        nivel:0
                                                        },                                                        
                                                        scripts: true,
                                                        text: 'Cargando...'
                                                });
						panel_detalle.collapse();
                                        }
                                    }
                                },";                
            
            }


        }

        return  $subnivel;



    }
    
    protected function cantidad_hijos($co_padre){

        $c= new Criteria();
        $c->add(Tbrh005EstructuraAdministrativaPeer::CO_PADRE,$co_padre);
        $c->add(Tbrh005EstructuraAdministrativaPeer::IN_ACTIVO,TRUE);
        return Tbrh005EstructuraAdministrativaPeer::doCount($c);
    } 
    
    protected function cantidad_hijos_subnivel($co_padre){

        $c= new Criteria();
        $c->add(Tbrh005EstructuraAdministrativaPeer::CO_PADRE,$co_padre);
        $c->add(Tbrh005EstructuraAdministrativaPeer::IN_ACTIVO,TRUE);
        return Tbrh005EstructuraAdministrativaPeer::doCount($c);
    } 
    
  public function executeCargosLista(sfWebRequest $request){
      

        $nivel = $this->getRequestParameter("nivel");
        $co_cargo_estructura = $this->getRequestParameter("co_cargo_estructura");
        $this->nu_cuenta = "estructura".$this->getRequestParameter("co_cargo_estructura");
        $co_estructura_administrativa = $this->getRequestParameter("co_estructura_administrativa");
        $tx_estructura_administrativa = $this->getRequestParameter("tx_estructura_administrativa");
        
        $this->data = json_encode(array(
                "co_cargo_estructura" => $co_cargo_estructura,
                "co_estructura_administrativa" => $co_estructura_administrativa,
                "tx_estructura_administrativa" => $tx_estructura_administrativa,
                "nivel"              => $nivel,
        ));
  } 

  public function executeStorelista(sfWebRequest $request)
  {
    $paginar    =   $this->getRequestParameter("paginar");
    $limit      =   $this->getRequestParameter("limit",20);
    $start      =   $this->getRequestParameter("start",0);
                $co_padre      =   $this->getRequestParameter("co_padre");
            $tx_nom_estructura_administrativa      =   $this->getRequestParameter("tx_nom_estructura_administrativa");
            $nu_centro_costo      =   $this->getRequestParameter("nu_centro_costo");
            $co_ente      =   $this->getRequestParameter("co_ente");
            $co_nivel_jerarquico      =   $this->getRequestParameter("co_nivel_jerarquico");
            $in_activo      =   $this->getRequestParameter("in_activo");
            $created_at      =   $this->getRequestParameter("created_at");
            $updated_at      =   $this->getRequestParameter("updated_at");
            $co_dependencia      =   $this->getRequestParameter("co_dependencia");
    
    
    $c = new Criteria();   

    if($this->getRequestParameter("BuscarBy")=="true"){
                                    if($co_padre!=""){$c->add(Tbrh005EstructuraAdministrativaPeer::co_padre,$co_padre);}
    
                                        if($tx_nom_estructura_administrativa!=""){$c->add(Tbrh005EstructuraAdministrativaPeer::tx_nom_estructura_administrativa,'%'.$tx_nom_estructura_administrativa.'%',Criteria::LIKE);}
        
                                        if($nu_centro_costo!=""){$c->add(Tbrh005EstructuraAdministrativaPeer::nu_centro_costo,'%'.$nu_centro_costo.'%',Criteria::LIKE);}
        
                                            if($co_ente!=""){$c->add(Tbrh005EstructuraAdministrativaPeer::co_ente,$co_ente);}
    
                                            if($co_nivel_jerarquico!=""){$c->add(Tbrh005EstructuraAdministrativaPeer::co_nivel_jerarquico,$co_nivel_jerarquico);}
    
                                    
                                    
        if($created_at!=""){
    list($dia, $mes,$anio) = explode("/",$created_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh005EstructuraAdministrativaPeer::created_at,$fecha);
    }
                                    
        if($updated_at!=""){
    list($dia, $mes,$anio) = explode("/",$updated_at);
    $fecha = $anio."-".$mes."-".$dia;
    $c->add(Tbrh005EstructuraAdministrativaPeer::updated_at,$fecha);
    }
                                            if($co_dependencia!=""){$c->add(Tbrh005EstructuraAdministrativaPeer::co_dependencia,$co_dependencia);}
    
                    }
    $c->setIgnoreCase(true);
    $cantidadTotal = Tbrh005EstructuraAdministrativaPeer::doCount($c);
    
    $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tbrh005EstructuraAdministrativaPeer::CO_ESTRUCTURA_ADMINISTRATIVA);
        
    $stmt = Tbrh005EstructuraAdministrativaPeer::doSelectStmt($c);
    $registros = "";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $registros[] = array(
            "co_estructura_administrativa"     => trim($res["co_estructura_administrativa"]),
            "co_padre"     => trim($res["co_padre"]),
            "tx_nom_estructura_administrativa"     => trim($res["tx_nom_estructura_administrativa"]),
            "nu_centro_costo"     => trim($res["nu_centro_costo"]),
            "co_ente"     => trim($res["co_ente"]),
            "co_nivel_jerarquico"     => trim($res["co_nivel_jerarquico"]),
            "in_activo"     => trim($res["in_activo"]),
            "created_at"     => trim($res["created_at"]),
            "updated_at"     => trim($res["updated_at"]),
            "co_dependencia"     => trim($res["co_dependencia"]),
        );
    }

    $this->data = json_encode(array(
        "success"   =>  true,
        "total"     =>  $cantidadTotal,
        "data"      =>  $registros
        ));
    }

    public function executeStorelistaCargos(sfWebRequest $request)
    {

        $limit      =   $this->getRequestParameter("limit",15);
        $start      =   $this->getRequestParameter("start",0);

        $co_estructura_administrativa  =   $this->getRequestParameter("co_estructura_administrativa");
        $co_padre  =   $this->getRequestParameter("co_padre");
        $nu_nivel    =   $this->getRequestParameter("nu_nivel");


        $c = new Criteria();
        $c->addSelectColumn(Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA);
        $c->addSelectColumn(Tbrh009CargoEstructuraPeer::CO_ESTRUCTURA_ADMINISTRATIVA);
        $c->addSelectColumn(Tbrh009CargoEstructuraPeer::NIVEL);
        $c->addSelectColumn(Tbrh032CargoPeer::TX_CARGO);       
        $c->add(Tbrh009CargoEstructuraPeer::NIVEL, $nu_nivel+1);
        $c->add(Tbrh009CargoEstructuraPeer::CO_PADRE,$co_padre);
        $c->add(Tbrh009CargoEstructuraPeer::CO_ESTRUCTURA_ADMINISTRATIVA,$co_estructura_administrativa);
        $c->addJoin(Tbrh032CargoPeer::CO_CARGO, Tbrh009CargoEstructuraPeer::CO_CARGO);
        $c->addAscendingOrderByColumn(Tbrh009CargoEstructuraPeer::CO_CARGO_ESTRUCTURA);
        
        $c->setIgnoreCase(true);
        $cantidadTotal = Tbrh009CargoEstructuraPeer::doCount($c);
        
        $c->setLimit($limit)->setOffset($start);

        $stmt = Tbrh009CargoEstructuraPeer::doSelectStmt($c);
        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){  
            
             //$res["cant"] = $this->getInAsignada($res["co_estructura_administrativa"]);             
             $registros[] = $res;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));
        
         $this->setTemplate('storelista');
    }    
                                                                    //modelo fk tbrh004_nivel_jerarquico.CO_NIVEL_JERARQUICO
    public function executeStorefkconiveljerarquico(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh004NivelJerarquicoPeer::doSelectStmt($c);
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
                                                        //modelo fk tbrh003_dependencia.CO_DEPENDENCIA
    public function executeStorefkcodependencia(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh003DependenciaPeer::doSelectStmt($c);
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
    
    public function executeStorefkcocargo(sfWebRequest $request){
        $c = new Criteria();
        $stmt = Tbrh032CargoPeer::doSelectStmt($c);
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
    
    public function executeStorefkcopadre(sfWebRequest $request){
        $c = new Criteria();
        $c->addAscendingOrderByColumn(Tbrh005EstructuraAdministrativaPeer::CO_ESTRUCTURA_ADMINISTRATIVA);
        $stmt = Tbrh005EstructuraAdministrativaPeer::doSelectStmt($c);       
        $registros = array();
        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[] = $reg;
        }
        $registros[] = (array('co_estructura_administrativa' => 0, 'tx_nom_estructura_administrativa' => 'Sin Padre' ));
        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
            ));
        $this->setTemplate('store');
    }        
        


}