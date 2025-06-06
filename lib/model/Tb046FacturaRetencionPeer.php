<?php

class Tb046FacturaRetencionPeer extends BaseTb046FacturaRetencionPeer
{

    static public function getMontoRetencion($co_factura)
    {
        
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn('coalesce(SUM(' . self::MO_RETENCION . '),0) as total');
        $c->add(self::CO_FACTURA,$co_factura);
        $stmt = self::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);

        return $campos["total"];
    }

}
