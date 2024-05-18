<?php

/**
 * FondoTerceroMasivo actions.
 *
 * @package    gobel
 * @subpackage FondoTerceroMasivo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class FondoTerceroMasivoActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $codigo = $this->getRequestParameter("co_solicitud");
    
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb161PagoFondoTerceroPeer::CO_PAGO_FONDO_TERCERO);
        $c->addSelectColumn(Tb161PagoFondoTerceroPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb161PagoFondoTerceroPeer::CO_USUARIO);
        $c->addSelectColumn(Tb161PagoFondoTerceroPeer::FE_DESDE);
        $c->addSelectColumn(Tb161PagoFondoTerceroPeer::FE_HASTA);
        $c->addSelectColumn(Tb161PagoFondoTerceroPeer::CO_CLASE_RETENCION);
        $c->addSelectColumn(Tb161PagoFondoTerceroPeer::CO_TIPO_RETENCION);
        $c->addSelectColumn(Tb161PagoFondoTerceroPeer::MO_DISPONIBLE);
                
        $c->add(Tb161PagoFondoTerceroPeer::CO_SOLICITUD,$codigo); 
        
        $stmt = Tb161PagoFondoTerceroPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
                
        $this->data = json_encode(array(
                "co_pago_fondo_tercero"     => $campos["co_pago_fondo_tercero"],
                "co_solicitud"              => $codigo,
                "co_usuario"                => $this->getUser()->getAttribute('codigo'),
                "fe_desde"                  => $campos["fe_desde"],
                "fe_hasta"                  => $campos["fe_hasta"],
                "co_clase_retencion"        => $campos["co_clase_retencion"],
                "co_tipo_retencion"         => $campos["co_tipo_retencion"],
                "mo_disponible"             => $campos["mo_disponible"]
        ));
    
  }
  
  public function executeGuardar(sfWebRequest $request)
  {

     $codigo = $this->getRequestParameter("co_pago_fondo_tercero");

     $con = Propel::getConnection();
     if($codigo!=''||$codigo!=null){
         $tb161_pago_fondo_tercero = Tb161PagoFondoTerceroPeer::retrieveByPk($codigo);
     }else{
         $tb161_pago_fondo_tercero = new Tb161PagoFondoTercero();
     }
     try
      {
        $con->beginTransaction();

        $tb161_pago_fondo_terceroForm = $this->getRequestParameter('tb161_pago_fondo_tercero');
        $tb161_pago_fondo_tercero->setCoClaseRetencion($tb161_pago_fondo_terceroForm["co_clase_retencion"]);
        $tb161_pago_fondo_tercero->setCoTipoRetencion($tb161_pago_fondo_terceroForm["co_tipo_retencion"]);

        list($dia, $mes, $anio) = explode("/",$tb161_pago_fondo_terceroForm["fe_pago_desde"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb161_pago_fondo_tercero->setFeDesde($fecha);
        
        list($dia, $mes, $anio) = explode("/",$tb161_pago_fondo_terceroForm["fe_pago_hasta"]);
        $fecha = $anio."-".$mes."-".$dia;
        $tb161_pago_fondo_tercero->setFeHasta($fecha);

        $tb161_pago_fondo_tercero->setCoSolicitud($tb161_pago_fondo_terceroForm["co_solicitud"]);
        $tb161_pago_fondo_tercero->setCoUsuario($this->getUser()->getAttribute('codigo'));
        $tb161_pago_fondo_tercero->save($con);

        $lines = file($_FILES['form-file']['tmp_name']);
        $i=0;
        $cadena = '';

        $wherec = new Criteria();
        $wherec->add(Tb162ArchivoFondoTerceroPeer::CO_FONDO_TERCERO, $tb161_pago_fondo_tercero->getCoPagoFondoTercero(), Criteria::EQUAL);
        BasePeer::doDelete($wherec, $con);

        $mo_total = 0;

        foreach($lines as $line)
        {
            $cadena = str_replace("|","", $line);
            $array = explode(",", $cadena);

            if(!is_numeric(trim($array[0]))){
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El código de persona  '.$array[0].' debe ser númerico '.$array[1].'linea '.$i
                ));
                echo $this->data;
                return sfView::NONE;
            }

            if(strlen(trim($array[1]))>10){
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El número de cédula  '.trim($array[1]).' debe tener una longitud de 9 caracteres '
                ));
                echo $this->data;
                return sfView::NONE;
            }

            if(strlen(trim($array[3]))==''){
                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El número de cuenta  '.trim($array[3]).' debe tener una longitud de menos 10 digitos'
                ));
                echo $this->data;
                return sfView::NONE;
            }

            /*if( trim($array[5]) == '06'){
                $co_banco = '0108';
            }elseif( trim($array[5]) == '10'){
                $co_banco = '0102';
            }elseif( trim($array[5]) == '22'){
                $co_banco = '0116';
            }*/

            $co_banco = Tb010BancoPeer::getCodigo(trim($array[5]));
            //$co_banco = '0116';
            $co_modo = Tb010BancoPeer::getModoPago( trim($array[3]), trim($array[5]) );
            
            $Tb162ArchivoFondoTercero = new Tb162ArchivoFondoTercero();
            $Tb162ArchivoFondoTercero->setCoFondoTercero($tb161_pago_fondo_tercero->getCoPagoFondoTercero())
                             ->setCoPersona(trim(utf8_decode($array[0])))
                             ->setTxCedula(trim(utf8_decode($array[1])))
                             ->setNbPersona(utf8_decode($array[2]))
                             ->setTxCuentaBancaria(trim(utf8_decode($array[3])))
                             ->setNuMonto(trim($array[4]))
                             ->setCodBanco($co_banco)
                             ->setIdTb163ModoPago($co_modo)
                             ->save($con);
            //trim(utf8_decode($array[5]))
            $mo_total+=trim($array[4]);
            $cadena = $array[2];
            $i++;
        }

        
        if($i==0){
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  "Debe Seleccionar un archivo de nomina",
            ));
            
            echo $this->data;
            return sfView::NONE;
        }             
        
        if($i>0){
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb161_pago_fondo_tercero->getCoSolicitud()));
            $ruta->setInCargarDato(true)->save($con);
        }else{
            $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($tb161_pago_fondo_tercero->getCoSolicitud()));
            $ruta->setInCargarDato(false)->save($con);
        }
        
        $co_odp = Tb060OrdenPagoPeer::generarODP($tb161_pago_fondo_tercero->getCoSolicitud(),$con,$this->getUser()->getAttribute('ejercicio')); 

        $this->data = json_encode(array(
                    "success" => true,
                    "msg" => 'Modificación realizada exitosamente ',
                    "co_pago_fondo_tercero"=>$tb161_pago_fondo_tercero->getCoPagoFondoTercero()
        ));
        
        $con->commit();

      }catch (PropelException $e)
      {
        $con->rollback();
        $this->data = json_encode(array(
            "success" => false,
            "msg" =>  $e->getMessage().'---'.$i.'----'.$cadena
        ));
      }

       echo $this->data;
       return sfView::NONE;

    }
    
    public function executeStorefkcotiporetencion(sfWebRequest $request){
        $co_clase_retencion  = $this->getRequestParameter("co_clase_retencion");
        
        $c = new Criteria();
               
        $c->add(Tb041TipoRetencionPeer::CO_CLASE_RETENCION,$co_clase_retencion);
        $c->add(Tb041TipoRetencionPeer::IN_ACTIVO,TRUE);
        $c->addAscendingOrderByColumn(Tb041TipoRetencionPeer::CO_TIPO_RETENCION);
        
       
        
        $stmt = Tb041TipoRetencionPeer::doSelectStmt($c);
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
    
    
    public function executeStorelista(sfWebRequest $request){
        
        $co_solicitud      =   $this->getRequestParameter("co_solicitud");
        
        $c = new Criteria(); 
        $c->clearSelectColumns(); 
        $c->addSelectColumn('COUNT('. Tb162ArchivoFondoTerceroPeer::COD_BANCO.') as cant');
        $c->addSelectColumn(Tb010BancoPeer::TX_BANCO);
        $c->addSelectColumn('SUM('.Tb162ArchivoFondoTerceroPeer::NU_MONTO.') as total');        

        $c->addJoin(Tb161PagoFondoTerceroPeer::CO_PAGO_FONDO_TERCERO, Tb162ArchivoFondoTerceroPeer::CO_FONDO_TERCERO);
        $c->addJoin(Tb162ArchivoFondoTerceroPeer::COD_BANCO, Tb010BancoPeer::NU_CODIGO);
        $c->add(Tb161PagoFondoTerceroPeer::CO_SOLICITUD,$co_solicitud);
        $c->addGroupByColumn(Tb010BancoPeer::TX_BANCO);
      
        $cantidadTotal = Tb162ArchivoFondoTerceroPeer::doCount($c);

        $c->addAscendingOrderByColumn(Tb010BancoPeer::TX_BANCO);

        $i=0;
        $mo_disponible=0;

        $stmt = Tb162ArchivoFondoTerceroPeer::doSelectStmt($c);      
        

        while($reg = $stmt->fetch(PDO::FETCH_ASSOC)){             
            $registros[] = $reg;
            $i++;
        }
        
        if($i==0){
                $registros[] = array(
                    "cant"       => "",
                    "tx_banco"           => "",
                    "total"     => "",
                );
        }


        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
            ));

        $this->setTemplate('store');
    }
}
