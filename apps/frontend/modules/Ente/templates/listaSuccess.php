<script type="text/javascript">
Ext.ns("EnteLista");
EnteLista.main = {
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
        EnteLista.main.mascara.show();
        this.msg = Ext.get('formularioEnte');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ente/editar',
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
	this.codigo  = EnteLista.main.gridPanel_.getSelectionModel().getSelected().get('co_ente');
	EnteLista.main.mascara.show();
        this.msg = Ext.get('formularioEnte');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ente/editar/codigo/'+this.codigo,
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
	this.codigo  = EnteLista.main.gridPanel_.getSelectionModel().getSelected().get('co_ente');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ente/eliminar',
            params:{
                co_ente:EnteLista.main.gridPanel_.getSelectionModel().getSelected().get('co_ente')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    EnteLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                EnteLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroEnte');
        EnteLista.main.mascara.show();
        EnteLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ente/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Ente',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_ente',hidden:true, menuDisabled:true,dataIndex: 'co_ente'},
    {header: 'Ente', width:500,  menuDisabled:true, sortable: true,  dataIndex: 'tx_ente'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){EnteLista.main.editar.enable();EnteLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorEnteLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ente/storelista',
    root:'data',
    fields:[
    {name: 'co_ente'},
    {name: 'tx_ente'},
           ]
    });
    return this.store;
}
};
Ext.onReady(EnteLista.main.init, EnteLista.main);
</script>
<div id="contenedorEnteLista"></div>
<div id="formularioEnte"></div>
<div id="filtroEnte"></div>
