<?php

class Tb028ProcesoPeer extends BaseTb028ProcesoPeer
{
    static public function getListaProcesoAsignado($co_usuario){
        
        $cp = new Criteria();
        $cp->clearSelectColumns();
        $cp->addSelectColumn(Tb002ProcesoUsuarioPeer::CO_PROCESO);
        $cp->add(Tb002ProcesoUsuarioPeer::CO_USUARIO,$co_usuario);
        $stmtp = Tb026SolicitudPeer::doSelectStmt($cp);
        $i=0;

        while($resp = $stmtp->fetch(PDO::FETCH_ASSOC)){
            $registro[$i] = $resp["co_proceso"];
            $i++;
        }
        
        return $registro;
        
    }
}
