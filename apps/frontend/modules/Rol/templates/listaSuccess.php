<script type="text/javascript">
Ext.ns("RolLista");
RolLista.main = {
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
        RolLista.main.mascara.show();
        this.msg = Ext.get('formularioRol');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Rol/editar',
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
	this.codigo  = RolLista.main.gridPanel_.getSelectionModel().getSelected().get('co_rol');
	RolLista.main.mascara.show();
        this.msg = Ext.get('formularioRol');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Rol/editar/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Eliminar un registro
this.eliminar= new Ext.Button({
    text:'Eliminar',
    iconCls: 'icon-eliminar',
    handler:function(){
	this.codigo  = RolLista.main.gridPanel_.getSelectionModel().getSelected().get('co_rol');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Rol/eliminar',
            params:{
                co_rol:RolLista.main.gridPanel_.getSelectionModel().getSelected().get('co_rol')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    RolLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                RolLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroRol');
        RolLista.main.mascara.show();
        RolLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Rol/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Roles',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_rol',hidden:true, menuDisabled:true,dataIndex: 'co_rol'},
    {header: 'Rol', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_rol'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){RolLista.main.editar.enable();RolLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

//Evento Doble Click
this.gridPanel_.on('rowdblclick', function( grid, row, evt){
this.record = RolLista.main.store_lista.getAt(row);
this.codigo = this.record.data["co_rol"];
RolLista.main.mascara.show();
this.msg = Ext.get('formularioRol');
this.msg.load({
    url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/Rol/editarRolMenu/codigo/"+this.codigo,
    scripts: true,
    text: "Cargando.."
});

});

this.gridPanel_.render("contenedorRolLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Rol/storelista',
    root:'data',
    fields:[
    {name: 'co_rol'},
    {name: 'tx_rol'},
           ]
    });
    return this.store;
}
};
Ext.onReady(RolLista.main.init, RolLista.main);
</script>
<div id="contenedorRolLista"></div>
<div id="formularioRol"></div>
<div id="filtroRol"></div>
