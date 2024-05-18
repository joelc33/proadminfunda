<?php

class Tb027TipoSolicitudPeer extends BaseTb027TipoSolicitudPeer
{
    
    static public function  ArmaTramitePrivilegio($codigo,$co_usuario){

        $c= new Criteria();
        $c->addSelectColumn(Tb028ProcesoPeer::TX_PROCESO);
        $c->addSelectColumn(Tb028ProcesoPeer::CO_PROCESO);     
        $res = Tb028ProcesoPeer::doSelectStmt($c);

        $menu = '';
        foreach($res as $resul){

                $cantidad = self::cantidad_hijosPrivilegio($resul['co_proceso']);

                if($cantidad > 0)
                {

                       $menu.= "{
                                 text:'".$resul['tx_proceso']."',
				 expanded: true,      
                                 children:[".self::ArmaSubTramitePrivilegio($resul['co_proceso'],$co_usuario)."]
                                },";

                }
        }

        return $menu;

    }
  
    
    static public function cantidad_hijosPrivilegio($codigo){
        $c= new Criteria();
        $c->add(self::CO_PROCESO,$codigo);
        return self::doCount($c);
    }
    
    static public function getStatus($co_usuario){
        
        $c= new Criteria();
        $c->add(Tb006TipoSolicitudUsuarioPeer::CO_USUARIO,$co_usuario);
       
        $stmt = Tb006TipoSolicitudUsuarioPeer::doSelectStmt($c);
        $registros = "";
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            $registros[$res["co_tipo_solicitud"]]= 'true';
        }
        
        return $registros;
    }

    static public function ArmaSubTramitePrivilegio($codigo,$co_usuario){

        $c= new Criteria();

        $c->addSelectColumn(self::CO_TIPO_SOLICITUD);
        $c->addSelectColumn(self::TX_TIPO_SOLICITUD);        
        $c->add(self::CO_PROCESO,$codigo);
        $c->addAscendingOrderByColumn(self::TX_TIPO_SOLICITUD);
        
        $res = self::doSelectStmt($c);

        $submenu = '';
        $registro = self::getStatus($co_usuario);
        
        
        
        foreach($res as $result){

                $submenu.= "{
                                    text:'".$result['tx_tipo_solicitud']."',
                                    id:'".$result['co_tipo_solicitud']."',
                                    leaf:true, ";
               
               
                if(array_key_exists($result['co_tipo_solicitud'], $registro))
                 $submenu.= "       checked: true},";
                else
                 $submenu.= "       checked: false},";
                
        }

        return  $submenu;

    }
    
}
