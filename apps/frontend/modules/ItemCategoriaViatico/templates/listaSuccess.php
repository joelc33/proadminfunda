<script type="text/javascript">
Ext.ns("ItemCategoriaViaticoLista");
ItemCategoriaViaticoLista.main = {
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
        ItemCategoriaViaticoLista.main.mascara.show();
        this.msg = Ext.get('formularioItemCategoriaViatico');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ItemCategoriaViatico/editar',
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
	this.codigo  = ItemCategoriaViaticoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_categoria_item_viatico');
	ItemCategoriaViaticoLista.main.mascara.show();
        this.msg = Ext.get('formularioItemCategoriaViatico');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ItemCategoriaViatico/editar/codigo/'+this.codigo,
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
	this.codigo  = ItemCategoriaViaticoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_categoria_item_viatico');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ItemCategoriaViatico/eliminar',
            params:{
                co_categoria_item_viatico:ItemCategoriaViaticoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_categoria_item_viatico')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ItemCategoriaViaticoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ItemCategoriaViaticoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroItemCategoriaViatico');
        ItemCategoriaViaticoLista.main.mascara.show();
        ItemCategoriaViaticoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ItemCategoriaViatico/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de ItemCategoriaViatico',
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
    {header: 'co_categoria_item_viatico',hidden:true, menuDisabled:true,dataIndex: 'co_categoria_item_viatico'},
    {header: 'Categoria', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'tx_categoria',renderer:textoLargo},
    {header: 'Tipo de Viatico', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo_viatico',renderer:textoLargo},
    {header: 'Viatico', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'tx_item_viatico',renderer:textoLargo},
    {header: 'Cant ut', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'cant_ut'},
     ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        ItemCategoriaViaticoLista.main.editar.enable();
        ItemCategoriaViaticoLista.main.eliminar.enable();
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorItemCategoriaViaticoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ItemCategoriaViatico/storelista',
    root:'data',
    fields:[
                {name: 'co_categoria_item_viatico'},
                {name: 'tx_categoria'},
                {name: 'tx_item_viatico'},
                {name: 'cant_ut'},
                {name: 'tx_tipo_viatico'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ItemCategoriaViaticoLista.main.init, ItemCategoriaViaticoLista.main);
</script>
<div id="contenedorItemCategoriaViaticoLista"></div>
<div id="formularioItemCategoriaViatico"></div>
<div id="filtroItemCategoriaViatico"></div>
