<?php

/**
 * CajaActions.
 *
 * @package    gobel
 * @subpackage Caja
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class CajaActions extends autoCajaActions
{

    public function executeIndex(sfWebRequest $request)
    {
        $codigo =  $this->getRequestParameter("co_solicitud");
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb008ProveedorPeer::CO_PROVEEDOR);
        $c->addSelectColumn(Tb008ProveedorPeer::CO_DOCUMENTO);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RIF);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_RAZON_SOCIAL);
        $c->addSelectColumn(Tb008ProveedorPeer::TX_DIRECCION);
        $c->addSelectColumn(Tb026SolicitudPeer::CO_SOLICITUD);
        $c->add(Tb026SolicitudPeer::CO_SOLICITUD, $codigo);
        $c->addJoin(Tb008ProveedorPeer::CO_PROVEEDOR, Tb026SolicitudPeer::CO_PROVEEDOR);
        $stmt = Tb026SolicitudPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($campos["co_proveedor"] != '') {

            $this->data = json_encode(array(
                "co_proveedor"       => $campos["co_proveedor"],
                "co_solicitud"       => $campos["co_solicitud"],
                "co_documento"       => $campos["co_documento"],
                "tx_rif"             => $campos["tx_rif"],
                "tx_razon_social"    => $campos["tx_razon_social"],
                "tx_direccion"       => $campos["tx_direccion"],


            ));
        } else {


            $this->data = json_encode(array(
                "co_proveedor"         => "",
                "co_solicitud"         => $codigo,
                "co_documento"       => "",
                "tx_rif"     => "",
                "tx_razon_social"       => "",
                "tx_direccion"  => "",
            ));
        }
    }


    public function executeEditarPago(sfWebRequest $request)
    {

        $json_pagos  = $this->getRequestParameter("variables");
        $co_estatus_pago  = $this->getRequestParameter("co_estatus_pago");
        $co_forma_pago  = $this->getRequestParameter("co_forma_pago");
        $co_concepto_pago  = $this->getRequestParameter("co_concepto_pago");
        $co_solicitud  = $this->getRequestParameter("co_solicitud");
        $fe_recibido_exp = $this->getRequestParameter("fe_recibido_exp");
        $data = json_decode($json_pagos);
        //    exit();

        $con = Propel::getConnection();
        $tb063_pago = Tb063PagoPeer::retrieveByPk($data->co_pago);

        try {
            $con->beginTransaction();

            /*CAMPOS*/


            /*Campo tipo BIGINT */
            $tb063_pago->setTxObservacion($data->tx_observacion);

            $tb063_pago->setNuPago($data->nu_pago);

            /*Campo tipo BIGINT */
            if ($co_estatus_pago != null) {
                $tb063_pago->setCoEstatusPago($co_estatus_pago);
            }
            if ($co_concepto_pago != null) {
                $tb063_pago->setCoConceptoPago($co_concepto_pago);
            }
            if ($co_forma_pago != null) {
                $tb063_pago->setCoFormaPago($co_forma_pago);
            }
            //------nuevo campo de la base de datos-----\\
            $tb063_pago->setFeRecibidoExp($data->fe_recibido_exp);



            /*CAMPOS*/
            $tb063_pago->save($con);
            $con->commit();
            $c = new Criteria();
            $c->add(Tb062LiquidacionPagoPeer::CO_SOLICITUD, $co_solicitud);
            $c->add(Tb063PagoPeer::CO_ESTATUS_PAGO, 2);
            $c->addJoin(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO, Tb063PagoPeer::CO_LIQUIDACION_PAGO);
            $cantidad = Tb062LiquidacionPagoPeer::doCount($c);
            if ($cantidad == 0) {
                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
                $ruta->setInCargarDato(TRUE)->save($con);
                Tb030RutaPeer::getGenerarReporte($ruta->getCoRuta());
            } else {
                $ruta = Tb030RutaPeer::retrieveByPK(Tb030RutaPeer::getCoRuta($co_solicitud));
                $ruta->setInCargarDato(FALSE)->save($con);
            }

            $con->commit();


            $this->data = json_encode(array(
                "success" => true,
                "msg" => 'Proceso realizado exitosamente'
            ));
        } catch (PropelException $e) {
            $con->rollback();
            $this->data = json_encode(array(
                "success" => false,
                "msg" =>  $e->getMessage()
            ));
        }
    }

    public function executeStorelista(sfWebRequest $request)
    {

        $co_solicitud  =   $this->getRequestParameter("co_solicitud");
        $limit      =   $this->getRequestParameter("limit", 8);
        $start      =   $this->getRequestParameter("start", 0);

        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb063PagoPeer::CO_PAGO);
        $c->addSelectColumn(Tb115EstatusPagoPeer::CO_ESTATUS_PAGO);
        $c->addSelectColumn(Tb115EstatusPagoPeer::TX_ESTATUS_PAGO);
        $c->addSelectColumn(Tb116ConceptoPagoPeer::CO_CONCEPTO_PAGO);
        $c->addSelectColumn(Tb116ConceptoPagoPeer::TX_CONCEPTO_PAGO);
        $c->addSelectColumn(Tb063PagoPeer::CO_FORMA_PAGO);
        $c->addSelectColumn(Tb074FormaPagoPeer::TX_FORMA_PAGO);
        $c->addSelectColumn(Tb010BancoPeer::TX_BANCO);
        $c->addSelectColumn(Tb011CuentaBancariaPeer::TX_CUENTA_BANCARIA);
        $c->addSelectColumn(Tb063PagoPeer::NU_PAGO);
        $c->addSelectColumn(Tb063PagoPeer::NU_MONTO);
        $c->addSelectColumn(Tb063PagoPeer::TX_OBSERVACION);
        $c->addSelectColumn(Tb063PagoPeer::FE_RECIBIDO_EXP);
        $c->addJoin(Tb062LiquidacionPagoPeer::CO_LIQUIDACION_PAGO, Tb063PagoPeer::CO_LIQUIDACION_PAGO);
        $c->addJoin(Tb010BancoPeer::CO_BANCO, Tb063PagoPeer::CO_BANCO);
        $c->addJoin(Tb063PagoPeer::CO_FORMA_PAGO, Tb074FormaPagoPeer::CO_FORMA_PAGO,  Criteria::LEFT_JOIN);
        $c->addJoin(Tb011CuentaBancariaPeer::CO_CUENTA_BANCARIA, Tb063PagoPeer::CO_CUENTA_BANCARIA);
        $c->addJoin(Tb063PagoPeer::CO_ESTATUS_PAGO, Tb115EstatusPagoPeer::CO_ESTATUS_PAGO, Criteria::LEFT_JOIN);
        $c->addJoin(Tb063PagoPeer::CO_CONCEPTO_PAGO, Tb116ConceptoPagoPeer::CO_CONCEPTO_PAGO, Criteria::LEFT_JOIN);
        $c->add(Tb062LiquidacionPagoPeer::CO_SOLICITUD, $co_solicitud);

        // echo $c->toString();
        // exit();

        $cantidadTotal = Tb063PagoPeer::doCount($c);
        //$c->setLimit($limit)->setOffset($start);
        $c->addAscendingOrderByColumn(Tb063PagoPeer::CO_PAGO);

        $stmt = Tb063PagoPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  $cantidadTotal,
            "data"      =>  $registros
        ));

        $this->setTemplate('store');
    }

    public function executeStorefkcodocumento(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb007DocumentoPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
        ));
        $this->setTemplate('store');
    }

    public function executeStorefkcoestatuspago(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb115EstatusPagoPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
        ));
        $this->setTemplate('store');
    }

    public function executeStorefkcoconceptopago(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb116ConceptoPagoPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $reg;
        }

        $this->data = json_encode(array(
            "success"   =>  true,
            "total"     =>  count($registros),
            "data"      =>  $registros
        ));
        $this->setTemplate('store');
    }


    public function executeStorefkcoformapago(sfWebRequest $request)
    {
        $c = new Criteria();
        $stmt = Tb074FormaPagoPeer::doSelectStmt($c);
        $registros = array();
        while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
