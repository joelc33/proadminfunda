<?php



class Tb167PacAePartidaTmpPeer extends BaseTb167PacAePartidaTmpPeer {

    static public function getCategoria($codigo){
      
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::ID);
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::ID_TB166_PAC_AE_TMP);
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::NU_PA);
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::NU_GE);
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::NU_ES);
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::NU_SE);
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::NU_SSE);
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::DE_PARTIDA);
        $c->addSelectColumn(Tb167PacAePartidaTmpPeer::MO_PARTIDA);
        $c->addSelectColumn(Tb139AplicacionPeer::TX_TIP_APLICACION);
        $c->addSelectColumn(Tb139AplicacionPeer::TX_APLICACION);
        $c->addSelectColumn(Tb166PacAeTmpPeer::NU_ACCION_ESPECIFICA);
        $c->addSelectColumn(Tb165PacTmpPeer::NU_PROYECTO_AC);
        $c->addSelectColumn(Tb082EjecutorPeer::NU_EJECUTOR);
        $c->addSelectColumn(Tb080SectorPeer::NU_SECTOR);
        $c->addJoin(Tb167PacAePartidaTmpPeer::ID_TB139_APLICACION, Tb139AplicacionPeer::CO_APLICACION);
        $c->addJoin(Tb166PacAeTmpPeer::ID, Tb167PacAePartidaTmpPeer::ID_TB166_PAC_AE_TMP);
        $c->addJoin(Tb165PacTmpPeer::ID, Tb166PacAeTmpPeer::ID_TB165_PAC_TMP);
        $c->addJoin(Tb082EjecutorPeer::ID, Tb165PacTmpPeer::ID_TB082_EJECUTOR);
        $c->addJoin(Tb080SectorPeer::ID, Tb165PacTmpPeer::ID_TB080_SECTOR);
        $c->add(Tb167PacAePartidaTmpPeer::ID,$codigo);  

        $stmt = Tb167PacAePartidaTmpPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
              
        return $campos["nu_ejecutor"].'.'.$campos["nu_sector"].'.'.$campos["nu_proyecto_ac"].'.00.'.$campos["nu_accion_especifica"].'.'.$campos["nu_pa"].'.'.$campos["nu_ge"].'.'.$campos["nu_es"].'.'.$campos["nu_se"].'.'.$campos["nu_sse"].'.L000';
    }

}
