<script type="text/javascript">
Ext.ns("ProductoLista");
ProductoLista.main = {
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
        ProductoLista.main.mascara.show();
        this.msg = Ext.get('formularioProducto');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Producto/editar',
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
	this.codigo  = ProductoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_producto');
	ProductoLista.main.mascara.show();
        this.msg = Ext.get('formularioProducto');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Producto/editar/codigo/'+this.codigo,
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
	this.codigo  = ProductoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_producto');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Producto/eliminar',
            params:{
                co_producto:ProductoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_producto')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ProductoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ProductoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroProducto');
        ProductoLista.main.mascara.show();
        ProductoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Producto/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Producto',
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
    {header: 'co_producto',hidden:true, menuDisabled:true,dataIndex: 'co_producto'},
    {header: 'Código', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'cod_producto'},
    {header: 'Producto', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'tx_producto'},
    {header: 'Clase', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'de_clase_producto'},
//    {header: 'Co unidad producto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_unidad_producto'},
//    {header: 'In ver', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_ver'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ProductoLista.main.editar.enable();ProductoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorProductoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Producto/storelista',
    root:'data',
    fields:[
            {name: 'co_producto'},
            {name: 'tx_producto'},
            {name: 'cod_producto'},
            {name: 'de_clase_producto'}
           ]
    });
    return this.store;
}
};
Ext.onReady(ProductoLista.main.init, ProductoLista.main);
</script>
<div id="contenedorProductoLista"></div>
<div id="formularioProducto"></div>
<div id="filtroProducto"></div>
