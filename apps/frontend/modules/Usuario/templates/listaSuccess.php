<script type="text/javascript">
Ext.ns("UsuarioLista");
UsuarioLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        UsuarioLista.main.mascara.show();
        this.msg = Ext.get('formularioUsuario');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/editar',
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = UsuarioLista.main.gridPanel_.getSelectionModel().getSelected().get('co_usuario');
	UsuarioLista.main.mascara.show();
        this.msg = Ext.get('formularioUsuario');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/editar/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Eliminar un registro
this.cambiar_estado= new Ext.Button({
    text:'Cambiar Estatus',
    iconCls: 'icon-eliminar',
    handler:function(){
	this.codigo  = UsuarioLista.main.gridPanel_.getSelectionModel().getSelected().get('co_usuario');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea cambiar el estatus del usuario?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/cambiarEstado',
            params:{
                co_usuario:UsuarioLista.main.gridPanel_.getSelectionModel().getSelected().get('co_usuario')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    UsuarioLista.main.store_lista.load({
                        callback: function(){
                          UsuarioLista.main.editar.disable();
                          UsuarioLista.main.cambiar_estado.disable();
                        }
                    });
                    
                    if(panel_detalle.collapsed == false)
                    {
                       panel_detalle.toggleCollapse();
                    } 
                    
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                UsuarioLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Privilegio del Tramite',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroUsuario');
        UsuarioLista.main.mascara.show();
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/listaTramite',
             scripts: true,
             params:{
                 co_usuario: UsuarioLista.main.gridPanel_.getSelectionModel().getSelected().get('co_usuario')
             }
        });
    }
});

this.editar.disable();
this.cambiar_estado.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Usuario',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.cambiar_estado,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_usuario',hidden:true, menuDisabled:true,dataIndex: 'co_usuario'},
    {header: 'Login', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_login'},
    {header: 'Cédula', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cedula'},
    {header: 'Nombre y Apellido', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nb_usuario'},
    {header: 'Rol', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'co_rol'},
    {header: 'Estatus', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        
        UsuarioLista.main.editar.enable();
        UsuarioLista.main.cambiar_estado.enable();
        
         var msg = Ext.get('detalle');
         msg.load({
                url: '<?php echo $_SERVER['SCRIPT_NAME']?>/Usuario/listaProceso',
                scripts: true,
                params:
                {
                    codigo: UsuarioLista.main.store_lista.getAt(rowIndex).get('co_usuario')

                },
                text: 'Cargando...'
         });
        
    
         if(panel_detalle.collapsed == true)
         {
            panel_detalle.toggleCollapse();
         } 
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorUsuarioLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/storelista',
    root:'data',
    fields:[
    {name: 'co_usuario'},
    {name: 'tx_login'},
    {name: 'nb_usuario'},
    {name: 'tx_password'},
    {name: 'co_rol'},
    {name: 'in_activo'},
    {name: 'nu_cedula'},
    {name: 'co_documento'},
           ]
    });
    return this.store;
}
};
Ext.onReady(UsuarioLista.main.init, UsuarioLista.main);
</script>
<div id="contenedorUsuarioLista"></div>
<div id="formularioUsuario"></div>
<div id="filtroUsuario"></div>
