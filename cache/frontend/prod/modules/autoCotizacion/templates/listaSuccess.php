<script type="text/javascript">
Ext.ns("CotizacionLista");
CotizacionLista.main = {
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
        CotizacionLista.main.mascara.show();
        this.msg = Ext.get('formularioCotizacion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/editar',
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
	this.codigo  = CotizacionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_compras');
	CotizacionLista.main.mascara.show();
        this.msg = Ext.get('formularioCotizacion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/editar/codigo/'+this.codigo,
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
	this.codigo  = CotizacionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_compras');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/eliminar',
            params:{
                co_compras:CotizacionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_compras')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    CotizacionLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                CotizacionLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroCotizacion');
        CotizacionLista.main.mascara.show();
        CotizacionLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Cotizacion',
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
    {header: 'Co proveedor', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_proveedor'},
    {header: 'Anio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'anio'},
    {header: 'Co servicio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_servicio'},
    {header: 'Co tipo solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_solicitud'},
    {header: 'Nu iva', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_iva'},
    {header: 'Monto iva', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'monto_iva'},
    {header: 'Monto sub total', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'monto_sub_total'},
    {header: 'Monto total', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'monto_total'},
    {header: 'Co ejecutor', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_ejecutor'},
    {header: 'Co proyecto ac', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_proyecto_ac'},
    {header: 'Co accion especifica', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_accion_especifica'},
    {header: 'Co partida iva', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_partida_iva'},
    {header: 'Co partida presupuesto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_partida_presupuesto'},
    {header: 'Co tipo movimiento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_movimiento'},
    {header: 'Numero compra', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'numero_compra'},
    {header: 'Mo pagado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_pagado'},
    {header: 'Mo restante', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_restante'},
    {header: 'Nu orden compra', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_orden_compra'},
    {header: 'In responsabilidad social', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_responsabilidad_social'},
    {header: 'In anulado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_anulado'},
    {header: 'Co solicitud anular', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud_anular'},
    {header: 'In anular', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_anular'},
    {header: 'Co ramo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_ramo'},
    {header: 'Forma pago', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'forma_pago'},
    {header: 'Forma entrega', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'forma_entrega'},
    {header: 'Co solicitud cotizacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud_cotizacion'},
    {header: 'Tx concepto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_concepto'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){CotizacionLista.main.editar.enable();CotizacionLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorCotizacionLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/storelista',
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
    {name: 'co_proveedor'},
    {name: 'anio'},
    {name: 'co_servicio'},
    {name: 'co_tipo_solicitud'},
    {name: 'nu_iva'},
    {name: 'monto_iva'},
    {name: 'monto_sub_total'},
    {name: 'monto_total'},
    {name: 'co_ejecutor'},
    {name: 'co_proyecto_ac'},
    {name: 'co_accion_especifica'},
    {name: 'co_partida_iva'},
    {name: 'co_partida_presupuesto'},
    {name: 'co_tipo_movimiento'},
    {name: 'numero_compra'},
    {name: 'mo_pagado'},
    {name: 'mo_restante'},
    {name: 'nu_orden_compra'},
    {name: 'in_responsabilidad_social'},
    {name: 'in_anulado'},
    {name: 'co_solicitud_anular'},
    {name: 'in_anular'},
    {name: 'co_ramo'},
    {name: 'forma_pago'},
    {name: 'forma_entrega'},
    {name: 'co_solicitud_cotizacion'},
    {name: 'tx_concepto'},
           ]
    });
    return this.store;
}
};
Ext.onReady(CotizacionLista.main.init, CotizacionLista.main);
</script>
<div id="contenedorCotizacionLista"></div>
<div id="formularioCotizacion"></div>
<div id="filtroCotizacion"></div>
