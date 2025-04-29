<?php

class Tb206CotizacionPeer extends BaseTb206CotizacionPeer
{

    static function getDatosRequisicion($codigo)
    {

        $c = new Criteria();
        $c->add(Tb206CotizacionPeer::CO_REQUISICION, $codigo);
        $stmt = Tb206CotizacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
    }

    static function getDatosCotizacion($codigo)
    {

        $c = new Criteria();
        $c->add(Tb206CotizacionPeer::CO_SOLICITUD, $codigo);
        $stmt = Tb206CotizacionPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos;
    }
}
