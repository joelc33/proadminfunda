<?php

class Tb004MenuPeer extends BaseTb004MenuPeer
{
    static public function  ArmaMenu($co_rol,$co_usuario){

        /*
         * Se buscan las opciones de menu padre
         */
        $c= new Criteria();
        $c->add(Tb005RolMenuPeer::CO_ROL,$co_rol);
        $c->add(Tb004MenuPeer::CO_PADRE,0);
        $c->add(Tb005RolMenuPeer::IN_VER,'t');
        $c->addJoin(Tb004MenuPeer::CO_MENU,Tb005RolMenuPeer::CO_MENU);
        $c->addAscendingOrderByColumn(Tb004MenuPeer::NU_ORDEN);


        $res = Tb004MenuPeer::doSelect($c);


        $menu = '';

        foreach($res as $resul){

                $cantidad = Tb004MenuPeer::cantidad_hijos($resul->getCoMenu(),$co_rol);

                if($cantidad > 0)
                {
                        if($resul->getCoMenu()==112){
                            $usuario = $nb_usuario;
                        }else{
                            $usuario = '';
                        }
                        $menu.="{text: '<b>".$resul->getTxMenu().' '.$usuario."</b>',
                                 iconCls:'".$resul->getTxIcono()."',
                                 menu: [".self::ArmaSubmenu($resul->getCoMenu(),$co_rol,$resul->getTxMenu(),$resul->getTxIcono())."],},";


                }

                /*elseif($resul->getCoMenu()==21){

                   $menu.="{text: '<b>".$resul->getTxMenu().' '.$usuario."</b>',
                                 iconCls:'".$resul->getTxIcono()."',
                                 menu: [".self::ArmaSubmenu($co_rol,$co_usuario)."],},";

                }*/
        }

        return $menu;

    }

    static public function cantidad_hijos($co_padre,$co_rol){

        $c= new Criteria();
        $c->add(Tb005RolMenuPeer::CO_ROL,$co_rol);
        $c->add(self::CO_PADRE,$co_padre);
        $c->add(Tb005RolMenuPeer::IN_VER,'t');
        $c->addJoin(self::CO_MENU,Tb005RolMenuPeer::CO_MENU);
        return self::doCount($c);
    }

    static public function ArmaSubmenuSolicitud($co_rol,$co_usuario){



        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
        $c->addSelectColumn(Tb032ConfiguracionRutaPeer::TX_URL);
        $c->addSelectColumn(Tb032ConfiguracionRutaPeer::TX_MODULO);

        $c->addJoin(Tb006TipoSolicitudUsuarioPeer::CO_TIPO_SOLICITUD, Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->addJoin(Tb032ConfiguracionRutaPeer::CO_TIPO_SOLICITUD,Tb027TipoSolicitudPeer::CO_TIPO_SOLICITUD);
        $c->add(Tb032ConfiguracionRutaPeer::NU_ORDEN,1); 
        $c->add(Tb006TipoSolicitudUsuarioPeer::CO_USUARIO,$co_usuario); 
        $c->add(Tb027TipoSolicitudPeer::IN_VER,true);        
        $c->addAscendingOrderByColumn(Tb027TipoSolicitudPeer::TX_TIPO_SOLICITUD);
        

        //echo $c->toString(); exit();

        $res = Tb027TipoSolicitudPeer::doSelectStmt($c);  

        $submenu = '';

        foreach($res as $result){

         //  var_dump($result); exit();

            $submenu.= "{
                                    text:'".$result['tx_tipo_solicitud']."',
                                    iconCls:'',
                                    id:'".$result['co_tipo_solicitud']."',
                                    leaf:true,
                                    listeners :{

                                        click: function(){
                                            var msg = Ext.get('tabPrincipal');
                                                msg.load({
                                                        url: 'Solicitud/index',
                                                        scripts: true,
                                                        text: 'Cargando...',
                                                        params:{
                                                            tx_tipo_solicitud: '".$result['tx_tipo_solicitud']."',
                                                            co_tipo_solicitud: '".$result['co_tipo_solicitud']."',
                                                            tx_url: '".$result['tx_modulo']."/".$result['tx_url']."'
                                                        }
                                                });
                                            panel_detalle.collapse();
                                        }
                                    }
            },";
            


        }

     
        return  $submenu;



    }

    static public function ArmaSubmenu($co_padre,$co_rol,$nb_menu,$icono){



        $c= new Criteria();
        $c->add(Tb005RolMenuPeer::CO_ROL,$co_rol);
        $c->add(self::CO_PADRE,$co_padre);
        $c->add(Tb005RolMenuPeer::IN_VER,'t');
        $c->addJoin(self::CO_MENU,Tb005RolMenuPeer::CO_MENU);
        $c->addAscendingOrderByColumn(self::NU_ORDEN);
        $res = self::doSelect($c);

        $submenu = '';

        foreach($res as $result){

            $cantidad = self::cantidad_hijosPrivilegio($result->getCoMenu(),$co_rol);

            if($cantidad > 0)
            {
                 $cantidad_hijos = self::cantidad_hijos($result->getCoMenu(),$co_rol);

                 if($cantidad_hijos > 0){
                        $submenu.= "{
                                 text:'".$result->getTxMenu()."',
                                 iconCls:'".$result->getTxIcono()."',
                                 menu:[".self::ArmaSubmenu($result->getCoMenu(),$co_rol,$co_usuario)."]
                                },";
                 }

            }else{

                $submenu.= "{
                                    text:'".$result->getTxMenu()."',
                                    iconCls:'".$result->getTxIcono()."',
                                    id:'".$result->getCoMenu()."',
                                    leaf:true,
                                    listeners :{

                                        click: function(){
                                            var msg = Ext.get('tabPrincipal');
                                                msg.load({
                                                        url: '".$result->getTxHref()."',
                                                        scripts: true,
                                                        text: 'Cargando...'
                                                });
                                            panel_detalle.collapse();
                                        }
                                    }
                                },";
            }


        }

       /* foreach($res as $result){

                    $submenu.= "{text:'".$result->getTxMenu()."',
                                 id:'".$result->getCoMenu()."',
                                 handler:function(){
                                        var msg = Ext.get('tabPrincipal');
                                        msg.load({
                                                url: '".$result->getTxHref()."',
                                                scripts: true,
                                                text: 'Cargando...',
                                                params:{
                                                  co_menu:".$result->getCoMenu().",
                                                  nb_menu:'".$nb_menu."',
                                                  iconCls:'".$icono."'
                                                }
                                        });
                                        panel_detalle.collapse();
                                 }},";


        }*/

        return  $submenu;



    }



    static public function getListaMenu($co_rol){

          $c = new Criteria();
          $c->clearSelectColumns();
          $c->addSelectColumn(self::CO_MENU);
          $c->addSelectColumn(self::TX_MENU);
          $c->addSelectColumn(self::CO_PADRE);
          $c->addSelectColumn(Tb005RolMenuPeer::IN_VER);
          $c->addJoin(self::CO_MENU, Tb005RolMenuPeer::CO_MENU);
          $c->addAscendingOrderByColumn(self::NU_ORDEN);
          $c->add(self::CO_PADRE,0);
          $c->add(Tb005RolMenuPeer::CO_ROL,$co_rol);
          $stmt = self::doSelectStmt($c);

          $data="";
          while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                $data.= "new Ext.form.FieldSet({
                        defaultType: 'checkbox',
                        title: '".$row['tx_menu']."',
                        items:[".self::getListaSubmenu($row['co_menu'], $co_rol)."]}),";
          }
          return $data;

    }


    static public function getListaSubmenu($co_padre,$co_rol){

           $c = new Criteria();
          $c->clearSelectColumns();
          $c->addSelectColumn(self::CO_MENU);
          $c->addSelectColumn(self::TX_MENU);
          $c->addSelectColumn(self::CO_PADRE);
          $c->addSelectColumn(TTb005RolMenuPeer::IN_VER);
          $c->addSelectColumn(TTb005RolMenuPeer::CO_ROL_MENU);
          $c->addJoin(self::CO_MENU, TTb005RolMenuPeer::CO_MENU);
          $c->addAscendingOrderByColumn(self::NU_ORDEN);
          $c->add(self::CO_PADRE,$co_padre);
          $c->add(TTb005RolMenuPeer::CO_ROL,$co_rol);
          $stmt = self::doSelectStmt($c);

        $submenu = '';

        $stmt = self::doSelectStmt($c);

        $data="";
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

//                if($row['in_ver']=='t')
//                    $flag = true;
//                else
                    $flag = false;

                $submenu.= "{
                                fieldLabel: '',
                                boxLabel: '".$row['tx_menu']."',";

                $submenu.=  ($row['in_ver']=='t')?'checked:true,':'';

                 $submenu.="name: 'radio[".$row['co_rol_menu']."]'},";


        }

        return  $submenu;

    }

    static public function getVerificaMenu($co_rol){

          $c = new Criteria();

          $c = new Criteria();
          $c->clearSelectColumns();
          $c->addSelectColumn(self::CO_MENU);
          $c->addSelectColumn(self::TX_MENU);
          $c->addSelectColumn(TTb005RolMenuPeer::CO_ROL_MENU);
          $c->addJoin(self::CO_MENU, TTb005RolMenuPeer::CO_MENU);
          $c->addAscendingOrderByColumn(self::NU_ORDEN);
          $c->add(TTb005RolMenuPeer::CO_ROL,$co_rol);
          $c->add(self::CO_PADRE,0,Criteria::NOT_EQUAL);

          return self::doSelectStmt($c);



    }

     static public function cantidad_hijosPrivilegio($co_padre,$co_rol){

        $c= new Criteria();
        $c->add(Tb005RolMenuPeer::CO_ROL,$co_rol);
        $c->add(self::CO_PADRE,$co_padre);
//        $c->add(T04RolMenuPeer::IN_VER,'t');
        $c->addJoin(self::CO_MENU,Tb005RolMenuPeer::CO_MENU);
        return self::doCount($c);
    }

    static public function  ArmaMenuPrivilegio($co_rol){


        /*
         * Se buscan las opciones de menu padre
         */
        $c= new Criteria();
        $c->addSelectColumn(Tb005RolMenuPeer::CO_ROL_MENU);
        $c->addSelectColumn(self::CO_MENU);
        $c->addSelectColumn(self::TX_MENU);
        $c->addSelectColumn(self::TX_ICONO);

        $c->addSelectColumn(Tb005RolMenuPeer::IN_VER);
        $c->add(Tb005RolMenuPeer::CO_ROL,$co_rol);
        $c->add(self::CO_PADRE,0);
//        $c->add(Tb005RolMenuPeer::IN_VER,'t');
        $c->addJoin(self::CO_MENU,Tb005RolMenuPeer::CO_MENU);
        $c->addAscendingOrderByColumn(self::NU_ORDEN);
        $res = self::doSelectStmt($c);

        $menu = '';
        foreach($res as $resul){

                $cantidad = self::cantidad_hijosPrivilegio($resul['co_menu'],$co_rol);

                if($cantidad > 0)
                {

                       $menu.= "{
                                 text:'".$resul['tx_menu']."',
				expanded: true,
                                 children:[".self::ArmaSubmenuPrivilegio($resul['co_menu'],$co_rol)."]
                                },";



                }
        }

        return $menu;

    }

    static public function ArmaSubmenuPrivilegio($co_padre,$co_rol){

        $c= new Criteria();

        $c->addSelectColumn(Tb005RolMenuPeer::CO_ROL_MENU);
        $c->addSelectColumn(self::CO_MENU);
        $c->addSelectColumn(self::TX_MENU);
        $c->addSelectColumn(self::TX_ICONO);
        $c->addSelectColumn(Tb005RolMenuPeer::IN_VER);

        $c->add(Tb005RolMenuPeer::CO_ROL,$co_rol);
        $c->add(self::CO_PADRE,$co_padre);
//        $c->add(Tb005RolMenuPeer::IN_VER,'t');
        $c->addJoin(self::CO_MENU,Tb005RolMenuPeer::CO_MENU);
        $c->addAscendingOrderByColumn(self::NU_ORDEN);
        $res = self::doSelectStmt($c);


        $submenu = '';

        foreach($res as $result){

            $cantidad = self::cantidad_hijosPrivilegio($result['co_menu'],$co_rol);

            if($cantidad > 0)
            {

                       $submenu.= "{
                                 text:'".$result['tx_menu']."',
                                 id:'".$result['co_rol_menu']."',
                                 children:[".self::ArmaSubmenuPrivilegio($result['co_menu'],$co_rol)."]
                                 },";



            }else{

                $submenu.= "{
                                    text:'".$result['tx_menu']."',
                                    id:'".$result['co_rol_menu']."',
                                    iconCls:'".$result['tx_icono']."',
                                    leaf:true, ";
                if($result['in_ver']==1)
                 $submenu.= "       checked: true },";
                else
                 $submenu.= "       checked: false },";
            }

        }

        return  $submenu;

    }
}
