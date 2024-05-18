<?php

class Tb044IvaRetencionPeer extends BaseTb044IvaRetencionPeer
{
     static public function getCuentaContable($nu_iva){
         
         $c = new Criteria();
         $c->add(Tb044IvaRetencionPeer::NU_VALOR,$nu_iva);
         $stmt = Tb044IvaRetencionPeer::doSelectStmt($c);
         $campos = $stmt->fetch(PDO::FETCH_ASSOC);
         
         return $campos["co_cuenta_contable"];
         
         
     }
}
