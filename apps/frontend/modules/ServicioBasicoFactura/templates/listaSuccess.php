<script type="text/javascript">
Ext.ns("ServicioBasicoFacturaLista");
ServicioBasicoFacturaLista.main = {
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
        ServicioBasicoFacturaLista.main.mascara.show();
        this.msg = Ext.get('formularioServicioBasicoFactura');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ServicioBasicoFactura/editar',
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
	this.codigo  = ServicioBasicoFacturaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_factura');
	ServicioBasicoFacturaLista.main.mascara.show();
        this.msg = Ext.get('formularioServicioBasicoFactura');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ServicioBasicoFactura/editar/codigo/'+this.codigo,
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
	this.codigo  = ServicioBasicoFacturaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_factura');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ServicioBasicoFactura/eliminar',
            params:{
                co_factura:ServicioBasicoFacturaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_factura')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ServicioBasicoFacturaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ServicioBasicoFacturaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroServicioBasicoFactura');
        ServicioBasicoFacturaLista.main.mascara.show();
        ServicioBasicoFacturaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ServicioBasicoFactura/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de ServicioBasicoFactura',
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
    {header: 'co_factura',hidden:true, menuDisabled:true,dataIndex: 'co_factura'},
    {header: 'Nu factura', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_factura'},
    {header: 'Fe emision', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_emision'},
    {header: 'Nu base imponible', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_base_imponible'},
    {header: 'Co iva factura', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_iva_factura'},
    {header: 'Nu iva factura', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_iva_factura'},
    {header: 'Nu total', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_total'},
    {header: 'Co iva retencion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_iva_retencion'},
    {header: 'Nu iva retencion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_iva_retencion'},
    {header: 'Nu total retencion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_total_retencion'},
    {header: 'Total pagar', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'total_pagar'},
    {header: 'Tx concepto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_concepto'},
    {header: 'Co compra', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_compra'},
    {header: 'Co solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
    {header: 'Co proveedor', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_proveedor'},
    {header: 'Co ramo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_ramo'},
    {header: 'Co iva', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_iva'},
    {header: 'Co odp', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_odp'},
    {header: 'Nu control', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_control'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ServicioBasicoFacturaLista.main.editar.enable();ServicioBasicoFacturaLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorServicioBasicoFacturaLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ServicioBasicoFactura/storelista',
    root:'data',
    fields:[
    {name: 'co_factura'},
    {name: 'nu_factura'},
    {name: 'fe_emision'},
    {name: 'nu_base_imponible'},
    {name: 'co_iva_factura'},
    {name: 'nu_iva_factura'},
    {name: 'nu_total'},
    {name: 'co_iva_retencion'},
    {name: 'nu_iva_retencion'},
    {name: 'nu_total_retencion'},
    {name: 'total_pagar'},
    {name: 'tx_concepto'},
    {name: 'co_compra'},
    {name: 'co_solicitud'},
    {name: 'co_proveedor'},
    {name: 'co_ramo'},
    {name: 'co_iva'},
    {name: 'co_odp'},
    {name: 'nu_control'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ServicioBasicoFacturaLista.main.init, ServicioBasicoFacturaLista.main);
</script>
<div id="contenedorServicioBasicoFacturaLista"></div>
<div id="formularioServicioBasicoFactura"></div>
<div id="filtroServicioBasicoFactura"></div>
