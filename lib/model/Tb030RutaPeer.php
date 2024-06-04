<?php

class Tb030RutaPeer extends BaseTb030RutaPeer
{
     static public function getCoRuta($codigo){
        
        $c = new Criteria();
        $c->add(Tb030RutaPeer::CO_SOLICITUD,$codigo);
        $c->add(Tb030RutaPeer::IN_ACTUAL,true);
        $res = Tb030RutaPeer::doSelect($c);
        foreach($res as $result)
            return $result->getCoRuta();
        
    }
    
    static public function getValidarCargarDatos($codigo){
        
        $c = new Criteria();
        $c->add(Tb030RutaPeer::CO_SOLICITUD,$codigo);
        $c->add(Tb030RutaPeer::IN_ACTUAL,true);
        
        $stmt = Tb030RutaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return ($campos['in_cargar_dato']=='')?0:1;
        
    }
    
    static public function getGenerarReporte($co_ruta){
        
        $c = new Criteria();
        $c->addSelectColumn(Tb032ConfiguracionRutaPeer::NB_REPORTE_ORDEN);
        $c->addJoin(Tb030RutaPeer::CO_PROCESO, Tb032ConfiguracionRutaPeer::CO_PROCESO);
        $c->addJoin(Tb030RutaPeer::CO_TIPO_SOLICITUD, Tb032ConfiguracionRutaPeer::CO_TIPO_SOLICITUD);
        $c->add(Tb030RutaPeer::CO_RUTA,$co_ruta);
        
        $stmt = Tb032ConfiguracionRutaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        $url = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/proadmin/web/reportes/".$campos["nb_reporte_orden"].".php?codigo=".$co_ruta;

        echo $url; exit();
        
        $pag = fopen($url,"r");
    }
    
     static public function getGenerarReporteUnificado($co_ruta,$co_tipo_solicitud){
        
        $c = new Criteria();
        $c->addSelectColumn(Tb032ConfiguracionRutaPeer::NB_REPORTE_ORDEN);
        $c->addJoin(Tb030RutaPeer::CO_PROCESO, Tb032ConfiguracionRutaPeer::CO_PROCESO);
        $c->add(Tb032ConfiguracionRutaPeer::CO_TIPO_SOLICITUD, $co_tipo_solicitud);
        $c->add(Tb030RutaPeer::CO_RUTA,$co_ruta);
        
        $stmt = Tb032ConfiguracionRutaPeer::doSelectStmt($c);
        $campos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        $url = "http://".$_SERVER['SERVER_NAME']."/proadmin/web/reportes/".$campos["nb_reporte_orden"].".php?codigo=".$co_ruta;
        
       // echo $url; exit();
        
        $pag = fopen($url,"r");
    }
}
