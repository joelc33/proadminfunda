<?php

class Tb006TipoSolicitudUsuarioPeer extends BaseTb006TipoSolicitudUsuarioPeer
{
    static public function getListaTramiteAsignado($co_usuario){
        
        $cp = new Criteria();
        $cp->clearSelectColumns();
        $cp->addSelectColumn(Tb006TipoSolicitudUsuarioPeer::CO_TIPO_SOLICITUD);
        $cp->add(Tb006TipoSolicitudUsuarioPeer::CO_USUARIO,$co_usuario);
        $stmtp = Tb006TipoSolicitudUsuarioPeer::doSelectStmt($cp);
        $i=0;

        while($resp = $stmtp->fetch(PDO::FETCH_ASSOC)){
            $registro[$i] = $resp["co_tipo_solicitud"];
            $i++;
        }
        
        return $registro;
        
    }
}
