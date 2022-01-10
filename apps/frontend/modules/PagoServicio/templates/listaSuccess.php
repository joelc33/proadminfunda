<script type="text/javascript">
Ext.ns("PagoServicioLista");
PagoServicioLista.main = {
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
        PagoServicioLista.main.mascara.show();
        this.msg = Ext.get('formularioPagoServicio');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoServicio/editar',
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
	this.codigo  = PagoServicioLista.main.gridPanel_.getSelectionModel().getSelected().get('co_pago_servicio');
	PagoServicioLista.main.mascara.show();
        this.msg = Ext.get('formularioPagoServicio');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoServicio/editar/codigo/'+this.codigo,
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
	this.codigo  = PagoServicioLista.main.gridPanel_.getSelectionModel().getSelected().get('co_pago_servicio');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoServicio/eliminar',
            params:{
                co_pago_servicio:PagoServicioLista.main.gridPanel_.getSelectionModel().getSelected().get('co_pago_servicio')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    PagoServicioLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                PagoServicioLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPagoServicio');
        PagoServicioLista.main.mascara.show();
        PagoServicioLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoServicio/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de PagoServicio',
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
    {header: 'co_pago_servicio',hidden:true, menuDisabled:true,dataIndex: 'co_pago_servicio'},
    {header: 'Co solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
    {header: 'Co tipo servicio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_servicio'},
    {header: 'Nu factura', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_factura'},
    {header: 'Nu control', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_control'},
    {header: 'Mo factura', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_factura'},
    {header: 'Fe desde', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_desde'},
    {header: 'Fe hasta', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_hasta'},
    {header: 'Tx observacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_observacion'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){PagoServicioLista.main.editar.enable();PagoServicioLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorPagoServicioLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoServicio/storelista',
    root:'data',
    fields:[
    {name: 'co_pago_servicio'},
    {name: 'co_solicitud'},
    {name: 'co_tipo_servicio'},
    {name: 'nu_factura'},
    {name: 'nu_control'},
    {name: 'mo_factura'},
    {name: 'fe_desde'},
    {name: 'fe_hasta'},
    {name: 'tx_observacion'},
           ]
    });
    return this.store;
}
};
Ext.onReady(PagoServicioLista.main.init, PagoServicioLista.main);
</script>
<div id="contenedorPagoServicioLista"></div>
<div id="formularioPagoServicio"></div>
<div id="filtroPagoServicio"></div>
