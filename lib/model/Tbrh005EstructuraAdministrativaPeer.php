<?php

class Tbrh005EstructuraAdministrativaPeer extends BaseTbrh005EstructuraAdministrativaPeer
{
    static public function  datosEstructura(){
        /*
         * Se buscan las opciones de menu padre
         */
        $c= new Criteria();
        $c->addSelectColumn(Tbrh005EstructuraAdministrativaPeer::CO_ESTRUCTURA_ADMINISTRATIVA);
        $c->addSelectColumn(Tbrh005EstructuraAdministrativaPeer::TX_NOM_ESTRUCTURA_ADMINISTRATIVA);
        $c->addSelectColumn(Tbrh005EstructuraAdministrativaPeer::NU_CODIGO);
        
        $c->add(Tbrh005EstructuraAdministrativaPeer::CO_PADRE,0);
        $c->add(Tbrh005EstructuraAdministrativaPeer::IN_ACTIVO,TRUE);
        $c->addAscendingOrderByColumn(Tbrh005EstructuraAdministrativaPeer::NU_CODIGO);
        $res = Tbrh005EstructuraAdministrativaPeer::doSelectStmt($c);

        $menu = '';
        foreach($res as $resul){

                $cantidad = self::cantidad_hijos($resul['co_estructura_administrativa']);

                if($cantidad > 0)
                {

                       $negocio.= "{
                                 text:'".$resul['nu_codigo'].'-'.$resul['tx_nom_estructura_administrativa']."',
                                 children:[".self::ArmaSubEstructura($resul['co_estructura_administrativa'])."]
                                },";
                }
        }

        return $negocio;

    }

    static public  function cantidad_hijos($codigo){

        $c= new Criteria();
        $c->add(Tbrh005EstructuraAdministrativaPeer::CO_PADRE,$codigo);
        $c->add(Tbrh005EstructuraAdministrativaPeer::IN_ACTIVO,TRUE);
        
        return Tbrh005EstructuraAdministrativaPeer::doCount($c);
    }
    
    static public  function ArmaSubEstructura($codigo){

        $c= new Criteria();

        $c= new Criteria();
        $c->add(Tbrh005EstructuraAdministrativaPeer::CO_PADRE,$codigo);
        $c->add(Tbrh005EstructuraAdministrativaPeer::IN_ACTIVO,TRUE);
        $c->addAscendingOrderByColumn(Tbrh005EstructuraAdministrativaPeer::NU_CODIGO);
        $res = Tbrh005EstructuraAdministrativaPeer::doSelectStmt($c);

        $subnegocio = '';

        foreach($res as $result){

            $cantidad = self::cantidad_hijos($result['co_estructura_administrativa']);

            if($cantidad > 0)
            {

                       $subnegocio.= "{
                                 text:'".$result['nu_codigo'].'-'.$result['tx_nom_estructura_administrativa']."',
                                 id:'".$result['co_estructura_administrativa']."',
                                checked: false,    
                                listeners:{
                                      checkchange: function(column, recordIndex, checked){
                                            buscarNegocio.main.getEnviarNegocio();
                                      }

                                },                                     
                                 children:[".self::ArmaSubEstructura($result['co_estructura_administrativa'])."]
                                 },";
            }else{

                $subnegocio.= "{
                                    text:'".$result['nu_codigo'].'-'.$result['tx_nom_estructura_administrativa']."',
                                    id:'".$result['co_estructura_administrativa']."',
                                    leaf:true, 
                                    checked: false,    
                                    listeners:{
                                          checkchange: function(column, recordIndex, checked){
                                                buscarNegocio.main.getEnviarNegocio();
                                          }

                                    }
                               },";
              
            }

        }

        return  $subnegocio;

    }
    
    
    static function getUbicacionEstructura($codigo){
        $cadena='';
        if($codigo!=''){         
            $c = new Criteria();
            $c->addSelectColumn(Tbrh005EstructuraAdministrativaPeer::TX_NOM_ESTRUCTURA_ADMINISTRATIVA);
            $c->addSelectColumn(Tbrh005EstructuraAdministrativaPeer::NU_CODIGO);
            $c->addSelectColumn(Tbrh005EstructuraAdministrativaPeer::CO_PADRE);
            $c->add(Tbrh005EstructuraAdministrativaPeer::CO_ESTRUCTURA_ADMINISTRATIVA,$codigo);

            $stmt = Tbrh005EstructuraAdministrativaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $cadena = self::getParentEstructura($campos["co_padre"]).$campos["tx_nom_estructura_administrativa"];
       }
        return $cadena;
        
    }
    
    protected function getParentEstructura($co_padre){
        
        if($co_padre!=''){
             $c = new Criteria();
            $c->addSelectColumn(Tbrh005EstructuraAdministrativaPeer::TX_NOM_ESTRUCTURA_ADMINISTRATIVA);
            $c->addSelectColumn(Tbrh005EstructuraAdministrativaPeer::CO_PADRE);
            $c->add(Tbrh005EstructuraAdministrativaPeer::CO_ESTRUCTURA_ADMINISTRATIVA,$co_padre);

            $stmt = Tbrh005EstructuraAdministrativaPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $cadena = self::getParentEstructura($campos["co_padre"]).$campos["tx_nom_estructura_administrativa"].' / ';

            return $cadena;
        }
        
    } 
    
    static function getSeleccionarNegocio($codigo){
        $cadena='';
        if($codigo!=''){         
            $c = new Criteria();
            $c->addSelectColumn(J814tNegocioPeer::TX_NEGOCIO);
            $c->addSelectColumn(J814tNegocioPeer::CO_PADRE_NEGOCIO);
            $c->add(J814tNegocioPeer::CO_NEGOCIO,$codigo);

            $stmt = J814tNegocioPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            $cadena = self::getNegocio($campos["co_padre_negocio"]).$campos["tx_negocio"];
       }
        return $cadena;
        
    }
    
    protected function getNegocio($co_padre){
        
        if($co_padre!=''){
            $c = new Criteria();
            $c->addSelectColumn(J814tNegocioPeer::TX_NEGOCIO);
            $c->addSelectColumn(J814tNegocioPeer::CO_PADRE_NEGOCIO);
            $c->addSelectColumn(J814tNegocioPeer::CO_CATEGORIA_NEGOCIO);
            $c->add(J814tNegocioPeer::CO_NEGOCIO,$co_padre);

            $stmt = J814tNegocioPeer::doSelectStmt($c);
            $campos = $stmt->fetch(PDO::FETCH_ASSOC);

            if($campos["co_categoria_negocio"]!=1)
                $cadena = self::getNegocio($campos["co_padre_negocio"]).$campos["tx_negocio"].' / ';
            else
                $cadena = $campos["tx_negocio"].' / ';

            return $cadena;
        }
        
    } 
}
