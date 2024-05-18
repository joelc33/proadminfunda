<script type="text/javascript">
Ext.ns("IvaFacturaLista");
IvaFacturaLista.main = {
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
        IvaFacturaLista.main.mascara.show();
        this.msg = Ext.get('formularioIvaFactura');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IvaFactura/editar',
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
	this.codigo  = IvaFacturaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_iva_factura');
	IvaFacturaLista.main.mascara.show();
        this.msg = Ext.get('formularioIvaFactura');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IvaFactura/editar/codigo/'+this.codigo,
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
	this.codigo  = IvaFacturaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_iva_factura');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IvaFactura/eliminar',
            params:{
                co_iva_factura:IvaFacturaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_iva_factura')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    IvaFacturaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                IvaFacturaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroIvaFactura');
        IvaFacturaLista.main.mascara.show();
        IvaFacturaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/IvaFactura/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de IvaFactura',
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
    {header: 'co_iva_factura',hidden:true, menuDisabled:true,dataIndex: 'co_iva_factura'},
    {header: 'Nu valor', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_valor'},
    {header: 'Fe desde', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_desde'},
    {header: 'Fe hasta', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_hasta'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){IvaFacturaLista.main.editar.enable();IvaFacturaLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorIvaFacturaLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IvaFactura/storelista',
    root:'data',
    fields:[
    {name: 'co_iva_factura'},
    {name: 'nu_valor'},
    {name: 'fe_desde'},
    {name: 'fe_hasta'},
    {name: 'in_activo'},
           ]
    });
    return this.store;
}
};
Ext.onReady(IvaFacturaLista.main.init, IvaFacturaLista.main);
</script>
<div id="contenedorIvaFacturaLista"></div>
<div id="formularioIvaFactura"></div>
<div id="filtroIvaFactura"></div>
