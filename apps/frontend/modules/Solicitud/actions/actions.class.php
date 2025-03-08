<?php

/**
 * Solicitud actions.
 *
 * @package    siames
 * @subpackage Solicitud
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class SolicitudActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {

        $this->data = json_encode(array(
            "co_rol" => $this->getUser()->getAttribute('rol'),
            "co_usuario" => $this->getUser()->getAttribute('codigo'),
            "in_activo" => $this->getUser()->getAttribute('in_activo'),
            "tx_tipo_solicitud" => $this->getRequestParameter("tx_tipo_solicitud"),
            "co_tipo_solicitud" => $this->getRequestParameter("co_tipo_solicitud"),
            "tx_url" => $this->getRequestParameter("tx_url"),

        ));

        $this->getRequest()->setAttribute('in_activo', $this->getUser()->getAttribute('in_activo'));
    }

    public function executeImagen(sfWebRequest $request)
    {

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->add(Tb030RutaPeer::CO_RUTA, $this->getRequestParameter("co_ruta"));
        $stmt = Tb030RutaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $config = new myConfig();

        $config->setConvertToURL($campos["tx_imagen"]);

        $this->tx_ruta = $config->getConvertToURL();
    }

    public function executeAgregarImagen(sfWebRequest $request)
    {
        $co_solicitud = $this->getRequestParameter("co_solicitud");
        $estado = $this->getRequestParameter("estado");
        $tipo = $this->getRequestParameter("tipo");
        $co_ruta = $this->getRequestParameter("co_ruta");

        $this->data = json_encode(array(
            "co_solicitud" => $co_solicitud,
            "estado" => $estado,
            "co_tipo_solicitud" => $tipo,
            "co_ruta" => $co_ruta
        ));
    }

    public function executeGuardarImagen(sfWebRequest $request)
    {
        $co_ruta = $this->getRequestParameter("co_ruta");
        $co_solicitud = $this->getRequestParameter("co_solicitud");

        $config = new myConfig();

        $serv = $config->getDirectorio() . "imagen/";

        $ruta = $serv . date("Ym");
        mkdir($ruta);

        $tx_imagen_ruta = $ruta . '/' . $co_ruta . ".jpg";

        $con = Propel::getConnection();
        try {
            $con->beginTransaction();

            if ($_FILES["form-file"]["size"] <= 256000) {
                if ($_FILES['form-file']['type'] == "image/jpeg") {
                    copy($_FILES['form-file']['tmp_name'], $tx_imagen_ruta);
                    $tb030Ruta = Tb030RutaPeer::retrieveByPK($co_ruta);
                    $tb030Ruta->setTxImagen($tx_imagen_ruta)
                        ->save();
                } else {
                    $this->data = json_encode(array(
                        "success" => false,
                        "co_solicitud_enlace" => $co_solicitud_enlace,
                        "tipo_imagen" => $_FILES['form-file']['type'],
                        "tipo_pdf" => $_FILES['form-pdf']['type'],
                        "msg" => 'La imagen debe ser un archivo  *.jpg'
                    ));

                    echo $this->data;
                    return sfView::NONE;
                    exit();
                }

                $con->commit($con);
            } else {

                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'La imagen supera el tamaño requerido, tamaño máximo los 250 kb '
                ));

                echo $this->data;
                return sfView::NONE;
                exit();
            }
        } catch (Exception $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage()
            ));
        }


        $this->data = json_encode(array(
            "success" => true,
            "co_solicitud" => $co_solicitud,
            "msg" => 'La imagen se guardo exitosamente!'
        ));

        echo $this->data;
        return sfView::NONE;
    }

    public function executeGuardarDocumento(sfWebRequest $request)
    {
        $co_ruta = $this->getRequestParameter("co_ruta");
        $co_solicitud = $this->getRequestParameter("co_solicitud");

        $config = new myConfig();
        $serv = $config->getDirectorio() . "documento/";

        $ruta = $serv . date("Ym");
        mkdir($ruta);

        $tx_documento_ruta = $ruta . '/' . $_FILES['form-pdf']["name"];

        $con = Propel::getConnection();
        try {
            $con->beginTransaction();
            if ($_FILES["form-pdf"]["size"] <= 850000000) {
                if ($_FILES['form-pdf']['type'] == "application/pdf") {
                    copy($_FILES['form-pdf']['tmp_name'], $tx_documento_ruta);

                    $tb030Ruta = Tb030RutaPeer::retrieveByPK($co_ruta);
                    $tb030Ruta->setTxDocumento($tx_documento_ruta)
                        ->save();

                    fclose($fp);
                } else {
                    $this->data = json_encode(array(
                        "success" => false,
                        "msg" => 'El documento debe ser un archivo *.pdf ->' . $_FILES['form-pdf']['type']
                    ));

                    echo $this->data;
                    return sfView::NONE;
                    exit();
                }
                $con->commit($con);
            } else {

                $this->data = json_encode(array(
                    "success" => false,
                    "msg" => 'El documento supera el tamaño requerido, tamaño máximo los 2 MB'
                ));

                echo $this->data;
                return sfView::NONE;
                exit();
            }

            $this->data = json_encode(array(
                "success" => true,
                "co_solicitud" => $co_solicitud,
                "co_solicitud_enlace" => $co_solicitud_enlace,
                "msg" => 'El documento se guardo exitosamente!'
            ));
        } catch (Exception $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage()
            ));
        }

        echo $this->data;
        return sfView::NONE;
    }



    public function executeAgregarDocumento(sfWebRequest $request)
    {
        $co_solicitud = $this->getRequestParameter("co_solicitud");
        $estado = $this->getRequestParameter("estado");
        $tipo = $this->getRequestParameter("tipo");
        $co_ruta = $this->getRequestParameter("co_ruta");

        $this->data = json_encode(array(
            "co_solicitud" => $co_solicitud,
            "estado" => $estado,
            "co_tipo_solicitud" => $tipo,
            "co_ruta" => $co_ruta
        ));
    }


    public function executeEstado(sfWebRequest $request)
    {
        $codigo = $this->getRequestParameter("codigo");
        if ($codigo != '' || $codigo != null) {


            $c = new Criteria();
            $c->clearSelectColumns();
            $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $codigo);

            $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
            $c->addSelectColumn(Tb001UsuarioPeer::CO_USUARIO);
            $c->addSelectColumn(Tb001UsuarioPeer::NB_USUARIO);
            $c->addSelectColumn(Tb001UsuarioPeer::NU_CEDULA);
            $c->addSelectColumn(Tb007DocumentoPeer::TIPO);
            $c->addSelectColumn(Tb030RutaPeer::CO_RUTA);
            $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
            $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO);
            $c->addJoin(Tb001UsuarioPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
            $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
            $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
            $c->add(Tb030RutaPeer::CO_ESTATUS_RUTA, 1);

            $stmt = Tb026SolicitudPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->data = json_encode(array(
                "co_solicitud" => $campos["co_solicitud"],
                "co_usuario" => $campos["co_usuario"],
                "nb_usuario" => $campos["nb_usuario"],
                "nu_cedula" => $campos["nu_cedula"],
                "tipo" => $campos["tipo"],
                "co_ruta" => $campos["co_ruta"],
                "tx_tipo_solicitud" => $campos["tx_tipo_solicitud"]
            ));
        } else {
            $this->data = json_encode(array(
                "co_solicitud" => "",
                "co_usuario" => "",
                "nb_usuario" => "",
                "nu_cedula" => "",
                "tipo" => "",
                "co_ruta" => "",
                "tx_tipo_solicitud" => ""
            ));
        }
    }

    public function executeStorefkcoestatus(sfWebRequest $request)
    {
        $c = new Criteria();
        $c->add(Tb031EstatusRutaPeer::CO_ESTATUS_RUTA, array(2, 3), Criteria::IN);
        $stmt = Tb031EstatusRutaPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros
        ));
        $this->setTemplate('store');
    }

    public function executePendienteEntidades(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "co_rol" => $this->getUser()->getAttribute('rol'),
            "co_usuario" => $this->getUser()->getAttribute('codigo'),
        ));
    }

    public function executeProcesadoEntidades(sfWebRequest $request)
    {
        $this->data = json_encode(array(
            "co_rol" => $this->getUser()->getAttribute('rol'),
            "co_usuario" => $this->getUser()->getAttribute('codigo'),
            "co_proceso" => $this->getUser()->getAttribute('co_proceso'),
        ));
    }

    public function executeNuevaSolicitud(sfWebRequest $request)
    {

        $this->data = json_encode(array(
            "co_usuario" => $this->getUser()->getAttribute('codigo'),
            "usuario" => $this->getUser()->getAttribute('nombre'),
            "ejercicio" => $this->getUser()->getAttribute('ejercicio'),
            "fe_ini" => $this->getUser()->getAttribute('fe_apertura'),
            "fe_fin" => $this->getUser()->getAttribute('fe_cierre')
        ));

        $this->ejercicio = $this->getUser()->getAttribute('ejercicio');
    }

    protected function getCoRuta($codigo)
    {
        $c = new Criteria();
        $c->add(Tb030RutaPeer::CO_SOLICITUD, $codigo);
        $c->add(Tb030RutaPeer::IN_ACTUAL, true);
        $res = Tb030RutaPeer::doSelect($c);
        foreach ($res as $result)
            return $result->getCoRuta();
    }

    protected function getInCargarDatos($co_solicitud)
    {
        $c = new Criteria();
        $c->addSelectColumn(Tb032ConfiguracionRutaPeer::IN_CARGAR_DATO);
        $c->addJoin(Tb030RutaPeer::CO_PROCESO, Tb032ConfiguracionRutaPeer::CO_PROCESO);
        $c->addJoin(Tb030RutaPeer::CO_TIPO_SOLICITUD, Tb032ConfiguracionRutaPeer::CO_TIPO_SOLICITUD);
        $c->add(Tb030RutaPeer::CO_SOLICITUD, $co_solicitud);
        $c->add(Tb030RutaPeer::IN_ACTUAL, true);

        $stmt = Tb032ConfiguracionRutaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($campos['in_cargar_dato'] == '') ? 0 : 1;
    }

    public function executeEnviarAnular(sfWebRequest $request)
    {

        $co_solicitud = $this->getRequestParameter("co_solicitud");
        $co_usuario = $this->getUser()->getAttribute('codigo');

        $tb026_solicitud = Tb026SolicitudPeer::retrieveByPK($co_solicitud);
        $tb026_solicitud->setCoEstatus(4);
        $tb026_solicitud->save();
    }

    public function executeEnviarEntidadesCompra(sfWebRequest $request)
    {

        $co_solicitud = $this->getRequestParameter("co_solicitud");
        $co_usuario = $this->getUser()->getAttribute('codigo');

        $in_carga_datos = $this->getInCargarDatos($co_solicitud);
        $estatus = Tb030RutaPeer::getValidarCargarDatos($co_solicitud);

        if ($in_carga_datos != true) {
            $estatus = $in_carga_datos;
        }

        if ($estatus == $in_carga_datos) {


            $con = Propel::getConnection();


            try {

                $con->beginTransaction();


                $c = new Criteria();
                $c->addJoin(Tb053DetalleComprasPeer::CO_COMPRAS, Tb052ComprasPeer::CO_COMPRAS);
                $c->add(Tb052ComprasPeer::CO_SOLICITUD, $co_solicitud);

                $c->addAscendingOrderByColumn(Tb053DetalleComprasPeer::CO_DETALLE_COMPRAS);

                $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);

                while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $cc = new Criteria();
                    $cc->addJoin(Tb207DetalleCotizacionPeer::CO_DETALLE_COTIZACION, Tb209PresupuestoDetalleCompraPeer::CO_DETALLE_COTIZACION);
                    $cc->add(Tb207DetalleCotizacionPeer::CO_DETALLE_COMPRA, $reg["co_detalle_compras"]);
                    $stmtc = Tb209PresupuestoDetalleCompraPeer::doSelectStmt($cc);


                    while ($cotizacion = $stmtc->fetch(PDO::FETCH_ASSOC)) {

                        Tb087PresupuestoMovimientoPeer::movimientoPartida(
                            $con,
                            $this->getUser()->getAttribute('ejercicio'),
                            $this->getUser()->getAttribute('codigo'),
                            $cotizacion["co_presupuesto"],
                            16,
                            $cotizacion["monto"],
                            $cotizacion["co_detalle_cotizacion"],
                            '',
                            $cotizacion["id"]
                        );
                    }

                    $dc = new Criteria();
                    $dc->add(Tb209PresupuestoDetalleCompraPeer::CO_DETALLE_COMPRA, $reg["co_detalle_compras"]);
                    $stmtdc = Tb209PresupuestoDetalleCompraPeer::doSelectStmt($dc);


                    while ($detalle_compra = $stmtdc->fetch(PDO::FETCH_ASSOC)) {

                        Tb087PresupuestoMovimientoPeer::movimientoPartida(
                            $con,
                            $this->getUser()->getAttribute('ejercicio'),
                            $this->getUser()->getAttribute('codigo'),
                            $detalle_compra["co_presupuesto"],
                            1,
                            $detalle_compra["monto"],
                            '',
                            $detalle_compra["co_detalle_compra"],
                            $detalle_compra["id"]
                        );
                    }
                }

                $Tb030Ruta = Tb030RutaPeer::retrieveByPK($this->getCoRuta($co_solicitud));
                $Tb030Ruta->setCoEstatusRuta(2);
                $Tb030Ruta->setCoUsuarioActualizo($co_usuario);
                $Tb030Ruta->save($con);

                $con->commit();
            } catch (PropelException $e) {
                $con->rollback();
                $data = json_encode(array(
                    "success" => false,
                    "msg" => $e->getMessage()
                ));
            }
        }



        $this->data = json_encode(array(
            "in_estatus" => $estatus,
            "in_carga_datos" => $in_carga_datos
        ));

        $this->setTemplate('enviarEntidades');
    }


    public function executeEnviarEntidades(sfWebRequest $request)
    {

        $con = Propel::getConnection();


        try {
            $co_solicitud = $this->getRequestParameter("co_solicitud");
            $co_usuario = $this->getUser()->getAttribute('codigo');

            $in_carga_datos = $this->getInCargarDatos($co_solicitud);
            $estatus = Tb030RutaPeer::getValidarCargarDatos($co_solicitud);

            if ($in_carga_datos != true) {
                $estatus = $in_carga_datos;
            }

            if ($estatus == $in_carga_datos) {

                $Tb030Ruta = Tb030RutaPeer::retrieveByPK($this->getCoRuta($co_solicitud));
                $Tb030Ruta->setCoEstatusRuta(2);
                $Tb030Ruta->setCoUsuarioActualizo($co_usuario);
                $Tb030Ruta->save($con);

                $datos_solicitud = Tb026SolicitudPeer::retrieveByPK($co_solicitud);

                //compromisos de asignacion (pagos sin facturas)
                /* if ($datos_solicitud->getCoProceso() == 68) {

                    $c = new Criteria();
                    $c->addJoin(Tb052ComprasPeer::CO_COMPRAS, Tb053DetalleComprasPeer::CO_COMPRAS);
                    $c->add(Tb052ComprasPeer::CO_SOLICITUD, $co_solicitud);
                    $stmt = Tb053DetalleComprasPeer::doSelectStmt($c);

                    while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $reg["co_presupuesto"], 1, $reg["monto"], '', $reg["co_detalle_compras"]);
                        Tb087PresupuestoMovimientoPeer::movimientoPartida($con, $this->getUser()->getAttribute('ejercicio'), $this->getUser()->getAttribute('codigo'), $reg["co_presupuesto"], 2, $reg["monto"], '', $reg["co_detalle_compras"]);
                    }
                }*/
            }

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            $data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage()
            ));
        }


        $this->data = json_encode(array(
            "in_estatus" => $estatus,
            "in_carga_datos" => $in_carga_datos
        ));
    }

    public function executeEnviarEntidadesAyuda(sfWebRequest $request)
    {

        $con = Propel::getConnection();


        try {
            $co_solicitud_ayuda = $this->getRequestParameter("co_solicitud_ayuda");
            $co_usuario = $this->getUser()->getAttribute('codigo');
           
            $c = new Criteria();
            $c->add(Tb026SolicitudPeer::CO_SOLICITUD_AYUDA, $co_solicitud_ayuda);

            $stmt = Tb026SolicitudPeer::doSelectStmt($c);

            while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $Tb030Ruta = Tb030RutaPeer::retrieveByPK($this->getCoRuta($reg["co_solicitud"]));
                $Tb030Ruta->setCoEstatusRuta(2);
                $Tb030Ruta->setCoUsuarioActualizo($co_usuario);
                $Tb030Ruta->save($con);

                $Tb126_solicitud_ayuda = Tb126SolicitudAyudaPeer::retrieveByPK($co_solicitud_ayuda);
                $Tb126_solicitud_ayuda->setInProcesado(TRUE)->save($con);
            
            }

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            $data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage()
            ));
        }


        $this->data = json_encode(array(
            "in_estatus" => $estatus,
            "in_carga_datos" => $in_carga_datos
        ));

        $this->setTemplate('enviarEntidades');
    }

    public function executeStorefkcoproceso(sfWebRequest $request)
    {

        $c = new Criteria();
        $c->addJoin(Tb002ProcesoUsuarioPeer::CO_PROCESO, Tb028ProcesoPeer::CO_PROCESO);
        $c->add(Tb002ProcesoUsuarioPeer::CO_USUARIO, $this->getUser()->getAttribute('codigo'));
        $stmt = Tb028ProcesoPeer::doSelectStmt($c);

        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros
        ));
        $this->setTemplate('store');
    }



    public function executeStorefkcotipotramite(sfWebRequest $request)
    {

        $c = new Criteria();
        $c->add(Tb027TipoSolicitudPeer::IN_VER, true);
        $stmt = Tb027TipoSolicitudPeer::doSelectStmt($c);

        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros
        ));
        $this->setTemplate('store');
    }



    public function executeStorefkcotiposolicitudProcesado(sfWebRequest $request)
    {

        $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));
        $registro_tramite = Tb006TipoSolicitudUsuarioPeer::getListaTramiteAsignado($this->getUser()->getAttribute('codigo'));


        $c = new Criteria();
        $c->setDistinct();
        $c->addJoin(Tb006TipoSolicitudUsuarioPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->add(Tb006TipoSolicitudUsuarioPeer::CO_USUARIO, $this->getUser()->getAttribute('codigo'));
        $c->add(Tb027TipoSolicitudPeer::IN_VER, true);
        $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, $registro_tramite, Criteria::IN);
        $c->addAnd(Tb030RutaPeer::CO_PROCESO, $registro_proceso, Criteria::IN);
        $c->addAnd(Tb030RutaPeer::CO_ESTATUS_RUTA, array(2), Criteria::IN);
        $c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));


        $c->addAscendingOrderByColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);

        $stmt = Tb027TipoSolicitudPeer::doSelectStmt($c);

        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros
        ));
        $this->setTemplate('store');
    }

    public function executeStorefkcotiposolicitudDirectorio(sfWebRequest $request)
    {

        $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));
        $registro_tramite = Tb006TipoSolicitudUsuarioPeer::getListaTramiteAsignado($this->getUser()->getAttribute('codigo'));


        $c = new Criteria();
        $c->setDistinct();
        $c->addJoin(Tb006TipoSolicitudUsuarioPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->add(Tb006TipoSolicitudUsuarioPeer::CO_USUARIO, $this->getUser()->getAttribute('codigo'));
        $c->add(Tb027TipoSolicitudPeer::IN_VER, true);
        $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, $registro_tramite, Criteria::IN);
        $c->addAnd(Tb030RutaPeer::CO_PROCESO, $registro_proceso, Criteria::IN);
        $c->addAnd(Tb030RutaPeer::IN_ANULAR, NULL, Criteria::ISNULL);
        $c->addAnd(Tb030RutaPeer::IN_ACTUAL, true);
        $c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));


        $c->addAscendingOrderByColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);

        $stmt = Tb027TipoSolicitudPeer::doSelectStmt($c);

        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros
        ));
        $this->setTemplate('store');
    }


    public function executeStorefkcotiposolicitud(sfWebRequest $request)
    {

        $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));
        $registro_tramite = Tb006TipoSolicitudUsuarioPeer::getListaTramiteAsignado($this->getUser()->getAttribute('codigo'));


        $c = new Criteria();
        $c->setDistinct();
        $c->addJoin(Tb006TipoSolicitudUsuarioPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->add(Tb006TipoSolicitudUsuarioPeer::CO_USUARIO, $this->getUser()->getAttribute('codigo'));
        $c->add(Tb027TipoSolicitudPeer::IN_VER, true);
        $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, $registro_tramite, Criteria::IN);
        $c->addAnd(Tb030RutaPeer::CO_PROCESO, $registro_proceso, Criteria::IN);
        $c->addAnd(Tb030RutaPeer::IN_ANULAR, NULL, Criteria::ISNULL);
        $c->addAnd(Tb026SolicitudPeer::CO_ESTATUS, array(1, 2, 3), Criteria::IN);
        //        $c->addAnd(Tb030RutaPeer::CO_ESTATUS_RUTA, 1);
        $c->addAnd(Tb030RutaPeer::IN_ACTUAL, true);
        $c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));


        $c->addAscendingOrderByColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);

        $stmt = Tb027TipoSolicitudPeer::doSelectStmt($c);

        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => count($registros),
            "data" => $registros
        ));
        $this->setTemplate('store');
    }

    protected function crearRuta($con, $solicitud, $FeEmision)
    {

        /*if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
            $FeEmision = $this->getUser()->getAttribute('fe_cierre'); 
        }else{
            $FeEmision = date("Y-m-d"); 
        }*/

        $Tb030Ruta = new Tb030Ruta();
        $Tb030Ruta->setCoUsuario($this->getUser()->getAttribute('codigo'))
            ->setCoEstatusRuta(1)
            ->setNuOrden(1)
            ->setInActual(true)
            ->setCreatedAt($FeEmision)
            ->setUpdatedAt($FeEmision)
            ->setCoSolicitud($solicitud->getCoSolicitud())
            ->setCoProceso($this->getVerificaRuta($solicitud->getCoTipoSolicitud()))
            ->setCoTipoSolicitud($solicitud->getCoTipoSolicitud());

        if ($solicitud->getTxObservacion() != '') {
            $Tb030Ruta->setObservacion($solicitud->getTxObservacion());
        }

        $Tb030Ruta->save($con);
    }

    protected function getVerificaRuta($codigo)
    {
        $c = new Criteria();
        $c->add(Tb032ConfiguracionRutaPeer::CO_TIPO_SOLICITUD, $codigo);
        $c->addAnd(Tb032ConfiguracionRutaPeer::NU_ORDEN, 1);
        $stmt = Tb032ConfiguracionRutaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos["co_proceso"];
    }

    protected function getCoProceso($codigo)
    {
        $c = new Criteria();
        $c->add(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD, $codigo);
        $stmt = Tb027TipoSolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos["co_proceso"];
    }


    public function executeGuardarestado(sfWebRequest $request)
    {

        $co_ruta = $this->getRequestParameter('co_ruta');
        $tx_observacion = $this->getRequestParameter('observacion');
        $co_estatus = $this->getRequestParameter('co_estatus');
        $co_usuario = $this->getUser()->getAttribute('codigo');
        $ejercicio = $this->getUser()->getAttribute('ejercicio');

        $con = Propel::getConnection();


        try {

            $con->beginTransaction();

            $Tb030Ruta = Tb030RutaPeer::retrieveByPK($co_ruta);

            $in_carga_datos = $this->getInCargarDatos($Tb030Ruta->getCoSolicitud());
            $estatus = Tb030RutaPeer::getValidarCargarDatos($Tb030Ruta->getCoSolicitud());

            if ($in_carga_datos != true) {
                $estatus = $in_carga_datos;
            }

            if ($estatus == $in_carga_datos) {



                //Contabilidad Retenciones
                if ($Tb030Ruta->getCoProceso() == 8) {

                    Tb045FacturaPeer::setRetenciones($con, $Tb030Ruta->getCoSolicitud(), $co_usuario, $co_ruta, $this->getUser()->getAttribute('ejercicio'));
                }

                if($Tb030Ruta->getCoTipoSolicitud() == 22 && $Tb030Ruta->getCoProceso() == 28){

                 //   Tb087PresupuestoMovimientoPeer::afectarPartidas($con,$ejercicio,$co_usuario,$co_ruta);
                   
                }

                $Tb030Ruta->setCoEstatusRuta($co_estatus)
                    ->setCoUsuarioActualizo($co_usuario)
                    ->save($con);

                $data = json_encode(array(
                    "success" => true,
                    "msg" => 'Solicitud Procesada Exitosamente'
                ));
            } else {

                $data = json_encode(array(
                    "success" => false,
                    "msg" => 'No es posible enviar la solicitud, ya que se debe cargar los datos'
                ));
            }

            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            $data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage()
            ));
        }


        echo $data;
        return sfView::NONE;
    }

    public function executeGuardar(sfWebRequest $request)
    {

        $con = Propel::getConnection();
        $tb026_solicitudForm = $this->getRequestParameter('solicitud');
        $conf_ruta = $this->getVerificaRuta($tb026_solicitudForm["co_tipo_solicitud"]);

        if ($conf_ruta == '') {
            $data = json_encode(array(
                "success" => false,
                "msg" => 'No se genero la solicitud debido a que el tramite no tiene ruta asignada.'

            ));

            echo $data;
            return sfView::NONE;
        }

        try {

            $con->beginTransaction();

            $tb026_solicitud = new Tb026Solicitud();
            $tb026_solicitudForm = $this->getRequestParameter('solicitud');

            /*if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
                $FeEmision = $this->getUser()->getAttribute('fe_cierre'); 
            }else{
                $FeEmision = date("Y-m-d"); 
            }*/

            if (date("Y") > $this->getUser()->getAttribute('ejercicio')) {
                list($dia, $mes, $anio) = explode("/", $tb026_solicitudForm["fe_solicitud"]);
                $FeEmision = $anio . "-" . $mes . "-" . $dia;
            } else {
                list($dia, $mes, $anio) = explode("/", $tb026_solicitudForm["fe_solicitud"]);
                $FeEmision = $anio . "-" . $mes . "-" . $dia;

                //                $FeEmision = date("Y-m-d"); 
            }


            $tb026_solicitud->setCoProceso($this->getCoProceso($tb026_solicitudForm["co_tipo_solicitud"]));
            $tb026_solicitud->setCoTipoSolicitud($tb026_solicitudForm["co_tipo_solicitud"]);
            $tb026_solicitud->setTxObservacion($tb026_solicitudForm["observacion"]);
            $tb026_solicitud->setCoEstatus(1);
            $tb026_solicitud->setCreatedAt($FeEmision);
            $tb026_solicitud->setUpdatedAt($FeEmision);

            $tb026_solicitud->setCoUsuario($this->getUser()->getAttribute('codigo'));
            $tb026_solicitud->setIdTb013AnioFiscal($this->getUser()->getAttribute('ejercicio'));
            /*if(date("Y")>$this->getUser()->getAttribute('ejercicio')){
                $tb026_solicitud->setFeRegistro($this->getUser()->getAttribute('fe_cierre')); 
            }else{
                $tb026_solicitud->setFeRegistro(date("Y-m-d")); 
            }*/
            $tb026_solicitud->setFeRegistro($FeEmision);
            $tb026_solicitud->save($con);

            $this->crearRuta($con, $tb026_solicitud, $FeEmision);
            $cod_solicitud = $tb026_solicitud->getCoSolicitud();


            $data = json_encode(array(
                "success" => true,
                "msg" => '<span style="color:green;font-size:13px,">Proceso realizado exitosamente.<br>
                            Numero de Solicitud <br><textarea readonly>' . $cod_solicitud . '</textarea></span>'
            ));
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            $data = json_encode(array(
                "success" => false,
                "msg" => $e->getMessage()
            ));
        }


        echo $data;
        return sfView::NONE;
    }

    public function executeStorelistaRuta(sfWebRequest $request)
    {
        $paginar = $this->getRequestParameter("paginar");
        //        $limit      =   $this->getRequestParameter("limit",10);
        //        $start      =   $this->getRequestParameter("start",0);

        $c = new Criteria();

        $c->setIgnoreCase(true);
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
        $c->addSelectColumn(Tb031EstatusRutaPeer::TX_DESCRIPCION);
        $c->addSelectColumn(Tb030RutaPeer::IN_CARGAR_DATO);
        $c->addSelectColumn(Tb030RutaPeer::CO_RUTA);
        $c->addSelectColumn(Tb030RutaPeer::CREATED_AT);
        $c->addSelectColumn(Tb030RutaPeer::OBSERVACION);
        $c->addSelectColumn(Tb030RutaPeer::TX_IMAGEN);
        $c->addSelectColumn(Tb030RutaPeer::TX_DOCUMENTO);
        $c->addSelectColumn(Tb030RutaPeer::TX_RUTA_REPORTE);


        $c->addJoin(Tb028ProcesoPeer::CO_PROCESO, Tb030RutaPeer::CO_PROCESO);
        $c->addJoin(Tb031EstatusRutaPeer::CO_ESTATUS_RUTA, Tb030RutaPeer::CO_ESTATUS_RUTA);

        $c->add(Tb030RutaPeer::CO_SOLICITUD, $this->getRequestParameter("co_solicitud"));
        $c->add(Tb030RutaPeer::IN_ANULAR, NULL, Criteria::ISNULL);

        $cantidadTotal = Tb026SolicitudPeer::doCount($c);

        //        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb030RutaPeer::CO_RUTA);

        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $registros = "";
        $encrip = new myConfig();
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            list($fe_rep, $hora) = explode(" ", $res["created_at"]);
            list($anio, $mes, $dia) = explode("-", $fe_rep);
            $fecha = $dia . '-' . $mes . '-' . $anio;


            $registros[] = array(
                "tx_proceso" => trim($res["tx_proceso"]),
                "tx_estatus" => trim($res["tx_descripcion"]),
                "in_cargar_dato" => trim($res["in_cargar_dato"]),
                "in_cargar_documento" => ($res["tx_documento"] == null) ? '' : trim($res["tx_documento"]),
                "in_cargar_imagen" => ($res["tx_imagen"] == null) ? '' : trim($res["tx_imagen"]),
                "co_ruta" => $encrip->encrypt($res["co_ruta"]),
                "co_ruta_org" => $res["co_ruta"],
                "fe_recepcion" => $fecha,
                "in_reporte" => ($res["tx_ruta_reporte"] == null) ? '' : $res["co_ruta"],
                "tx_observacion" => ($res["observacion"] == null) ? '' : $res["observacion"]
            );
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros
        ));

        $this->setTemplate('storelista');
    }

    public function executeStorelistaRutaAnular(sfWebRequest $request)
    {
        $paginar = $this->getRequestParameter("paginar");
        //        $limit      =   $this->getRequestParameter("limit",10);
        //        $start      =   $this->getRequestParameter("start",0);

        $c = new Criteria();

        $c->setIgnoreCase(true);
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
        $c->addSelectColumn(Tb031EstatusRutaPeer::TX_DESCRIPCION);
        $c->addSelectColumn(Tb030RutaPeer::IN_CARGAR_DATO);
        $c->addSelectColumn(Tb030RutaPeer::CO_RUTA);
        $c->addSelectColumn(Tb030RutaPeer::CREATED_AT);
        $c->addSelectColumn(Tb030RutaPeer::OBSERVACION);
        $c->addSelectColumn(Tb030RutaPeer::TX_IMAGEN);
        $c->addSelectColumn(Tb030RutaPeer::TX_DOCUMENTO);
        $c->addSelectColumn(Tb030RutaPeer::TX_RUTA_REPORTE);


        $c->addJoin(Tb028ProcesoPeer::CO_PROCESO, Tb030RutaPeer::CO_PROCESO);
        $c->addJoin(Tb031EstatusRutaPeer::CO_ESTATUS_RUTA, Tb030RutaPeer::CO_ESTATUS_RUTA);

        $c->add(Tb030RutaPeer::CO_SOLICITUD, $this->getRequestParameter("co_solicitud"));
        $c->add(Tb030RutaPeer::IN_ANULAR, TRUE);

        $cantidadTotal = Tb026SolicitudPeer::doCount($c);

        //        $c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb030RutaPeer::CO_RUTA);

        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $registros = "";
        $encrip = new myConfig();
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            list($fe_rep, $hora) = explode(" ", $res["created_at"]);
            list($anio, $mes, $dia) = explode("-", $fe_rep);
            $fecha = $dia . '-' . $mes . '-' . $anio;

            $registros[] = array(
                "tx_proceso" => trim($res["tx_proceso"]),
                "tx_estatus" => trim($res["tx_descripcion"]),
                "in_cargar_dato" => trim($res["in_cargar_dato"]),
                "in_cargar_documento" => ($res["tx_documento"] == null) ? '' : trim($res["tx_documento"]),
                "in_cargar_imagen" => ($res["tx_imagen"] == null) ? '' : trim($res["tx_imagen"]),
                "co_ruta" => $encrip->encrypt($res["co_ruta"]),
                "co_ruta_org" => $res["co_ruta"],
                "fe_recepcion" => $fecha,
                "in_reporte" => ($res["tx_ruta_reporte"] == null) ? '' : $res["co_ruta"],
                "tx_observacion" => ($res["observacion"] == null) ? '' : $res["observacion"]
            );
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros
        ));

        $this->setTemplate('storelista');
    }

    public function executeCargarDatos(sfWebRequest $request)
    {
        $co_solicitud = $this->getRequestParameter('co_solicitud');
        $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
        $co_proceso = $this->getRequestParameter("co_proceso");

        $c = new Criteria();
        $c->add(Tb032ConfiguracionRutaPeer::CO_PROCESO, $co_proceso);
        $c->add(Tb032ConfiguracionRutaPeer::CO_TIPO_SOLICITUD, $co_tipo_solicitud);
        $c->addSelectColumn(Tb032ConfiguracionRutaPeer::TX_URL);
        $c->addSelectColumn(Tb032ConfiguracionRutaPeer::TX_MODULO);

        $stmt = Tb032ConfiguracionRutaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($campos["tx_url"] != '' || $campos["tx_url"] != null) {
            $this->forward($campos["tx_modulo"], $campos["tx_url"]);
        } else {
            $this->forward('Formulario', 'construccion');
        }
    }


    protected function getDatosProveedor($codigo)
    {
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb052ComprasPeer::CO_PROVEEDOR);
        $c->add(Tb052ComprasPeer::CO_SOLICITUD, $codigo);
        $stmt = Tb008ProveedorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
    }

    protected function getDatosPersona($codigo)
    {
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb109PersonaPeer::NU_CEDULA);
        $c->addSelectColumn(Tb109PersonaPeer::NB_PERSONA);
        $c->addSelectColumn(Tb109PersonaPeer::AP_PERSONA);
        $c->addJoin(Tb109PersonaPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO);
        $c->add(Tb109PersonaPeer::CO_PERSONA, $codigo);
        $stmt = Tb008ProveedorPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
    }








    public function executeStorelista(sfWebRequest $request)
    {

        $limit = $this->getRequestParameter("limit", 15);
        $start = $this->getRequestParameter("start", 0);
        $in_ventanilla = $this->getRequestParameter("in_ventanilla");
        $co_proceso = $this->getRequestParameter("co_proceso");
        $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
        $co_solicitud = $this->getRequestParameter("co_solicitud");

        $co_documento = $this->getRequestParameter("co_documento");
        $nu_cedula_rif = $this->getRequestParameter("nu_cedula_rif");
        $tx_razon_social = $this->getRequestParameter("tx_razon_social");

        $c = new Criteria();
        $c->clearSelectColumns();

        if ($co_documento != '') {
            $c->add(Tb007DocumentoPeer::CO_DOCUMENTO, $co_documento);
        }

        if ($nu_cedula_rif != '') {
            $c->add(Tb008ProveedorPeer::TX_RIF, $nu_cedula_rif);
        }

        if ($tx_razon_social != '') {
            $c->add(Tb008ProveedorPeer::TX_RAZON_SOCIAL, '%' . $tx_razon_social . '%', Criteria::LIKE);
        }

        if ($co_tipo_solicitud != '') {
            $c->add(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, $co_tipo_solicitud);
        }



        if ($co_solicitud != '') {
            $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $co_solicitud);
        }

        if ($in_ventanilla == 'true') {
            $c->add(Tb030RutaPeer::NU_ORDEN, 1);
        } else {
            $c->add(Tb030RutaPeer::NU_ORDEN, 1, Criteria::GREATER_THAN);

            if ($co_proceso != '') {
                $c->add(Tb028ProcesoPeer::CO_PROCESO, $co_proceso);
            } else {

                $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));


                $c->addAnd(Tb030RutaPeer::CO_PROCESO, $registro_proceso, Criteria::IN);
            }
        }


        $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));
        $registro_tramite = Tb006TipoSolicitudUsuarioPeer::getListaTramiteAsignado($this->getUser()->getAttribute('codigo'));


        $c->setIgnoreCase(true);
        $c->addSelectColumn(Tb030RutaPeer::CO_PROCESO);
        $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
        $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb001UsuarioPeer::TX_LOGIN);
        $c->addSelectColumn(Tb026SolicitudPeer::FE_REGISTRO);
        $c->addSelectColumn(Tb026SolicitudPeer::CO_PERSONA);
        //  $c->addSelectColumn(Tb060OrdenPagoPeer::TX_SERIAL);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb030RutaPeer::CO_RUTA);
        $c->addSelectColumn(Tb030RutaPeer::TX_RUTA_REPORTE);

        // $c->addJoin(Tb026SolicitudPeer::CO_PERSONA, Tb109PersonaPeer::CO_PERSONA,   Criteria::LEFT_JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR, Criteria::LEFT_JOIN);
        $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO, Criteria::LEFT_JOIN);
        // $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb060OrdenPagoPeer::CO_SOLICITUD,   Criteria::LEFT_JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD, Criteria::JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD, Criteria::JOIN);
        $c->addJoin(Tb030RutaPeer::CO_PROCESO, Tb028ProcesoPeer::CO_PROCESO, Criteria::JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO, Criteria::JOIN);

        $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, $registro_tramite, Criteria::IN);
        $c->addAnd(Tb030RutaPeer::CO_PROCESO, $registro_proceso, Criteria::IN);

        $c->addAnd(Tb030RutaPeer::IN_ANULAR, NULL, Criteria::ISNULL);
        $c->addAnd(Tb026SolicitudPeer::CO_ESTATUS, array(1, 2), Criteria::IN);
        $c->addAnd(Tb030RutaPeer::CO_ESTATUS_RUTA, 1);
        $c->addAnd(Tb030RutaPeer::IN_ACTUAL, true);
        $c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));

        $cantidadTotal = Tb026SolicitudPeer::doCount($c);

        $c->setLimit($limit)->setOffset($start);
        $c->addDescendingOrderByColumn(Tb026SolicitudPeer::CO_SOLICITUD);


        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $registros = array();
        $encrip = new myConfig();
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $cantidad = Tb026SolicitudPeer::getCantRevision($res["co_solicitud"]);

            $tx_rif = $res["inicial"] . "-" . $res["tx_rif"];
            $tx_razon_social = strtoupper($res["tx_razon_social"]);


            list($anio, $mes, $dia) = explode('-', $res["fe_registro"]);
            $registros[] = array(
                "tx_proceso" => trim($res["tx_proceso"]),
                "co_ruta" => $encrip->encrypt($res["co_ruta"]),
                "co_proceso" => trim($res["co_proceso"]),
                "tx_tipo_solicitud" => trim($res["tx_tipo_solicitud"]),
                "co_tipo_solicitud" => trim($res["co_tipo_solicitud"]),
                "co_solicitud" => trim($res["co_solicitud"]),
                "tx_login" => trim($res["tx_login"]),
                "tx_serial" => Tb060OrdenPagoPeer::getODP($res["co_solicitud"]),
                "tx_rif" => $tx_rif,
                "tx_razon_social" => $tx_razon_social,
                "fe_creacion" => $dia . '-' . $mes . '-' . $anio,
                "in_reporte" => ($res["tx_ruta_reporte"] == null) ? '' : $res["co_ruta"],
                "cant_revision" => $cantidad,
                "id_ruta" => $res["co_ruta"]
            );
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros
        ));
    }



    public function executeStorelistaprocesado(sfWebRequest $request)
    {

        $limit = $this->getRequestParameter("limit", 15);
        $start = $this->getRequestParameter("start", 0);
        $in_ventanilla = $this->getRequestParameter("in_ventanilla");
        $co_proceso = $this->getRequestParameter("co_proceso");
        $co_solicitud = $this->getRequestParameter("co_solicitud");

        $co_documento = $this->getRequestParameter("co_documento");
        $nu_cedula_rif = $this->getRequestParameter("nu_cedula_rif");
        $tx_razon_social = $this->getRequestParameter("tx_razon_social");
        $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");

        $c = new Criteria();
        $c->clearSelectColumns();




        if ($co_documento != '') {
            $c->add(Tb007DocumentoPeer::CO_DOCUMENTO, $co_documento);
        }

        if ($nu_cedula_rif != '') {
            $c->add(Tb008ProveedorPeer::TX_RIF, $nu_cedula_rif);
        }

        if ($tx_razon_social != '') {
            $c->add(Tb008ProveedorPeer::TX_RAZON_SOCIAL, '%' . $tx_razon_social . '%', Criteria::LIKE);
        }


        if ($co_tipo_solicitud != '') {
            $c->add(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, $co_tipo_solicitud);
        }




        if ($co_solicitud != '') {
            $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $co_solicitud);
        }

        if ($in_ventanilla == 'true') {
            $c->add(Tb030RutaPeer::NU_ORDEN, 1);
        } else {
            //$c->add(Tb030RutaPeer::NU_ORDEN,1,  Criteria::GREATER_THAN);

            if ($co_proceso != '') {
                $registro_proceso = $co_proceso;
                $c->add(Tb028ProcesoPeer::CO_PROCESO, $co_proceso);
            } else {

                $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));


                $c->addAnd(Tb030RutaPeer::CO_PROCESO, $registro_proceso, Criteria::IN);
            }
        }


        $registro_proceso = Tb028ProcesoPeer::getListaProcesoAsignado($this->getUser()->getAttribute('codigo'));
        $registro_tramite = Tb006TipoSolicitudUsuarioPeer::getListaTramiteAsignado($this->getUser()->getAttribute('codigo'));


        $c->setIgnoreCase(true);
        $c->addSelectColumn(Tb030RutaPeer::CO_PROCESO);
        $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
        $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
        $c->addSelectColumn(Tb001UsuarioPeer::TX_LOGIN);
        $c->addSelectColumn(Tb026SolicitudPeer::CREATED_AT);
        $c->addSelectColumn(Tb026SolicitudPeer::CO_PERSONA);
        //$c->addSelectColumn(Tb060OrdenPagoPeer::TX_SERIAL);
        $c->addSelectColumn(Tb007DocumentoPeer::INICIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);

        // $c->addJoin(Tb026SolicitudPeer::CO_PERSONA, Tb109PersonaPeer::CO_PERSONA,   Criteria::LEFT_JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_PROVEEDOR, Tb008ProveedorPeer::CO_PROVEEDOR, Criteria::LEFT_JOIN);
        $c->addJoin(Tb008ProveedorPeer::CO_DOCUMENTO, Tb007DocumentoPeer::CO_DOCUMENTO, Criteria::LEFT_JOIN);
        //$c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb060OrdenPagoPeer::CO_SOLICITUD,   Criteria::LEFT_JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD, Criteria::JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD, Criteria::JOIN);
        $c->addJoin(Tb030RutaPeer::CO_PROCESO, Tb028ProcesoPeer::CO_PROCESO, Criteria::JOIN);
        $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO, Criteria::JOIN);

        $c->addAnd(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, $registro_tramite, Criteria::IN);
        $c->addAnd(Tb030RutaPeer::CO_PROCESO, $registro_proceso, Criteria::IN);

        $c->addAnd(Tb030RutaPeer::CO_ESTATUS_RUTA, 2);
        $c->addAnd(Tb026SolicitudPeer::ID_TB013_ANIO_FISCAL, $this->getUser()->getAttribute('ejercicio'));

        //$c->addAnd(Tb030RutaPeer::IN_ACTUAL,true);


        //    echo $c->toString(); exit();

        //   $c->addAnd(Tb026SolicitudPeer::CO_USUARIO,$this->getUser()->getAttribute('codigo'));
        $cantidadTotal = Tb026SolicitudPeer::doCount($c);

        $c->setLimit($limit)->setOffset($start);
        $c->addDescendingOrderByColumn(Tb026SolicitudPeer::CO_SOLICITUD);




        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $registros = array();
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $cantidad = Tb026SolicitudPeer::getCantRevision($res["co_solicitud"]);

            $tx_rif = $res["inicial"] . "-" . $res["tx_rif"];
            $tx_razon_social = strtoupper($res["tx_razon_social"]);

            //        if($res["tx_rif"]==''){
            //            if($res["co_persona"]!=''){
            //                $datos_persona = $this->getDatosPersona($res["co_persona"]);
            //                $tx_rif = $datos_persona["inicial"]."-".$datos_persona["nu_cedula"];
            //                $tx_razon_social = strtoupper($datos_persona["nb_persona"].' '.$datos_persona["ap_persona"]);
            //            }            
            //        }

            list($anio, $mes, $dia) = explode('-', $res["created_at"]);
            $registros[] = array(
                "tx_proceso" => trim($res["tx_proceso"]),
                "co_proceso" => trim($res["co_proceso"]),
                "tx_tipo_solicitud" => trim($res["tx_tipo_solicitud"]),
                "co_tipo_solicitud" => trim($res["co_tipo_solicitud"]),
                "co_solicitud" => trim($res["co_solicitud"]),
                "tx_login" => trim($res["tx_login"]),
                "tx_serial" => Tb060OrdenPagoPeer::getODP($res["co_solicitud"]),
                "tx_rif" => $tx_rif,
                "tx_razon_social" => $tx_razon_social,
                "fe_creacion" => $dia . '-' . $mes . '-' . $anio,
                "cant_revision" => $cantidad
            );
        }

        $this->data = json_encode(array(
            "success" => true,
            "total" => $cantidadTotal,
            "data" => $registros
        ));
    }

    public function executeHistorial(sfWebRequest $request)
    {

        $co_solicitud = $this->getRequestParameter("co_solicitud");
        $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
        $co_proceso = $this->getRequestParameter("co_proceso");

        $this->data = json_encode(array(
            "co_solicitud" => $co_solicitud,
            "co_tipo_solicitud" => $co_tipo_solicitud,
            "co_proceso" => $co_proceso
        ));
    }

    public function executeDetalleSolicitud(sfWebRequest $request)
    {

        $co_solicitud = $this->getRequestParameter("codigo");
        $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
        $co_proceso = $this->getRequestParameter("co_proceso");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb029EstatusPeer::TX_ESTATUS);
        $c->addSelectColumn(Tb030RutaPeer::CO_RUTA);
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_ESTATUS, Tb029EstatusPeer::CO_ESTATUS);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $co_solicitud);
        $c->add(Tb030RutaPeer::IN_ACTUAL, true);


        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $encrip = new myConfig();

        $this->data = json_encode(array(
            "co_solicitud" => $co_solicitud,
            "co_tipo_solicitud" => $co_tipo_solicitud,
            "co_proceso" => $co_proceso,
            "tx_tipo_solicitud" => $campos["tx_tipo_solicitud"],
            "tx_estatus" => $campos["tx_estatus"],
            "co_ruta" => $campos["co_ruta"],
            "co_ruta_encrip" => $encrip->encrypt($campos["co_ruta"])
        ));
    }

    public function executeDetalleSolicitudAnular(sfWebRequest $request)
    {

        $co_solicitud = $this->getRequestParameter("codigo");
        $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
        $co_proceso = $this->getRequestParameter("co_proceso");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb029EstatusPeer::TX_ESTATUS);
        $c->addSelectColumn(Tb030RutaPeer::CO_RUTA);
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_ESTATUS, Tb029EstatusPeer::CO_ESTATUS);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $co_solicitud);
        $c->add(Tb030RutaPeer::IN_ACTUAL, true);


        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $encrip = new myConfig();

        $this->data = json_encode(array(
            "co_solicitud" => $co_solicitud,
            "co_tipo_solicitud" => $co_tipo_solicitud,
            "co_proceso" => $co_proceso,
            "tx_tipo_solicitud" => $campos["tx_tipo_solicitud"],
            "tx_estatus" => $campos["tx_estatus"],
            "co_ruta" => $campos["co_ruta"],
            "co_ruta_encrip" => $encrip->encrypt($campos["co_ruta"])
        ));
    }

    public function executeDetalleProcesadoSolicitud(sfWebRequest $request)
    {

        $co_solicitud = $this->getRequestParameter("codigo");
        $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
        $co_proceso = $this->getRequestParameter("co_proceso");

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb029EstatusPeer::TX_ESTATUS);
        $c->addSelectColumn(Tb030RutaPeer::CO_RUTA);
        $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addJoin(Tb026SolicitudPeer::CO_ESTATUS, Tb029EstatusPeer::CO_ESTATUS);
        $c->addJoin(Tb026SolicitudPeer::CO_SOLICITUD, Tb030RutaPeer::CO_SOLICITUD);
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $co_solicitud);
        $c->add(Tb030RutaPeer::IN_ACTUAL, true);


        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        $encrip = new myConfig();

        $this->data = json_encode(array(
            "co_solicitud" => $co_solicitud,
            "co_tipo_solicitud" => $co_tipo_solicitud,
            "co_proceso" => $co_proceso,
            "tx_tipo_solicitud" => $campos["tx_tipo_solicitud"],
            "tx_estatus" => $campos["tx_estatus"],
            "co_ruta" => $campos["co_ruta"],
            "co_ruta_encrip" => $encrip->encrypt($campos["co_ruta"])
        ));
    }

    public function executeDetalle(sfWebRequest $request)
    {


        $this->tab = "{
                            title: 'Detalle del Tramite',
                            tabWidth:120,
                            autoLoad:{
                            url:'" . $_SERVER["SCRIPT_NAME"] . "/Solicitud/detalleSolicitud',
                            scripts: true,
                            params:{codigo:this.OBJ.co_solicitud,
                                    co_tipo_solicitud: this.OBJ.co_tipo_solicitud,
                                    co_proceso: this.OBJ.co_proceso}
                            }
                        }";

        $this->DatosDetalle();
    }



    public function executeDetalleEntidades(sfWebRequest $request)
    {

        $this->tab = "{
                            title: 'Detalle del Tramite',
                            tabWidth:120,
                            autoLoad:{
                            url:'" . $_SERVER["SCRIPT_NAME"] . "/Solicitud/detalleSolicitud',
                            scripts: true,
                            params:{codigo:this.OBJ.co_solicitud,
                                    co_tipo_solicitud: this.OBJ.co_tipo_solicitud,
                                    co_proceso: this.OBJ.co_proceso }
                            }
                        }";

        $this->DatosDetalle();
    }

    public function executeDetalleEntidadesAnular(sfWebRequest $request)
    {

        $this->tab = "{
                            title: 'Detalle del Tramite',
                            tabWidth:120,
                            autoLoad:{
                            url:'" . $_SERVER["SCRIPT_NAME"] . "/Solicitud/detalleSolicitudAnular',
                            scripts: true,
                            params:{codigo:this.OBJ.co_solicitud,
                                    co_tipo_solicitud: this.OBJ.co_tipo_solicitud,
                                    co_proceso: this.OBJ.co_proceso }
                            }
                        }";

        $this->DatosDetalle();
    }

    public function executeDetalleProcesadoEntidades(sfWebRequest $request)
    {

        $this->tab = "{
                            title: 'Detalle del Tramite',
                            tabWidth:120,
                            autoLoad:{
                            url:'" . $_SERVER["SCRIPT_NAME"] . "/Solicitud/detalleProcesadoSolicitud',
                            scripts: true,
                            params:{codigo:this.OBJ.co_solicitud,
                                    co_tipo_solicitud: this.OBJ.co_tipo_solicitud,
                                    co_proceso: this.OBJ.co_proceso }
                            }
                        }";

        $this->DatosDetalle();
    }

    protected function DatosDetalle()
    {
        $codigo = $this->getRequestParameter("codigo");
        $co_tipo_solicitud = $this->getRequestParameter("co_tipo_solicitud");
        $co_proceso = $this->getRequestParameter("co_proceso");

        if ($codigo != '' || $codigo != null) {
            $c = new Criteria();
            $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $codigo);
            $c->clearSelectColumns();
            $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
            $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
            $c->addSelectColumn(Tb029EstatusPeer::TX_ESTATUS);
            $c->addSelectColumn(Tb026SolicitudPeer::CREATED_AT);
            $c->addSelectColumn(Tb026SolicitudPeer::TX_OBSERVACION);
            $c->addSelectColumn(Tb001UsuarioPeer::TX_LOGIN);
            $c->addSelectColumn(Tb001UsuarioPeer::NB_USUARIO);

            $c->addJoin(Tb026SolicitudPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
            $c->addJoin(Tb026SolicitudPeer::CO_ESTATUS, Tb029EstatusPeer::CO_ESTATUS);
            $c->addJoin(Tb026SolicitudPeer::CO_USUARIO, Tb001UsuarioPeer::CO_USUARIO);
            $stmt = Tb026SolicitudPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);


            $this->data = json_encode(array(
                "co_solicitud" => $campos["co_solicitud"],
                "tx_tipo_solicitud" => $campos["tx_tipo_solicitud"],
                "tx_estatus" => $campos["tx_estatus"],
                "fe_creacion" => trim(date_format(date_create($campos["created_at"]), 'd/m/Y')),
                "tx_observacion" => $campos["tx_observacion"],
                "tx_login" => $campos["tx_login"],
                "nb_usuario" => $campos["nb_usuario"],
                "co_tipo_solicitud" => $co_tipo_solicitud,
                "co_proceso" => $co_proceso
            ));
        } else {
            $this->data = json_encode(array(
                "co_solicitud" => "",
                "tx_tipo_solicitud" => "",
                "tx_estatus" => "",
                "fe_creacion" => "",
                "tx_observacion" => "",
                "tx_login" => "",
                "nb_usuario" => "",
                "co_tipo_solicitud" => $co_tipo_solicitud,
                "co_proceso" => $co_proceso

            ));
        }
    }
}
