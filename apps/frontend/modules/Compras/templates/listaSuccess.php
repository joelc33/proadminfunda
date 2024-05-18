<script type="text/javascript">
Ext.ns("ComprasLista");
ComprasLista.main = {
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
        ComprasLista.main.mascara.show();
        this.msg = Ext.get('formularioCompras');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/editar',
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
	this.codigo  = ComprasLista.main.gridPanel_.getSelectionModel().getSelected().get('co_compras');
	ComprasLista.main.mascara.show();
        this.msg = Ext.get('formularioCompras');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/editar/codigo/'+this.codigo,
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
	this.codigo  = ComprasLista.main.gridPanel_.getSelectionModel().getSelected().get('co_compras');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/eliminar',
            params:{
                co_compras:ComprasLista.main.gridPanel_.getSelectionModel().getSelected().get('co_compras')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ComprasLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ComprasLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroCompras');
        ComprasLista.main.mascara.show();
        ComprasLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Compras',
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
    {header: 'co_compras',hidden:true, menuDisabled:true,dataIndex: 'co_compras'},
    {header: 'Co requisicion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_requisicion'},
    {header: 'Co ente', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_ente'},
    {header: 'Co usuario', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_usuario'},
    {header: 'Fecha compra', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fecha_compra'},
    {header: 'Tx observacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_observacion'},
    {header: 'Co solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ComprasLista.main.editar.enable();ComprasLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorComprasLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storelista',
    root:'data',
    fields:[
    {name: 'co_compras'},
    {name: 'co_requisicion'},
    {name: 'co_ente'},
    {name: 'co_usuario'},
    {name: 'fecha_compra'},
    {name: 'tx_observacion'},
    {name: 'co_solicitud'},
    {name: 'created_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ComprasLista.main.init, ComprasLista.main);
</script>
<div id="contenedorComprasLista"></div>
<div id="formularioCompras"></div>
<div id="filtroCompras"></div>
