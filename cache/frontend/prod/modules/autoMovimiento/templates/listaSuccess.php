<script type="text/javascript">
Ext.ns("MovimientoLista");
MovimientoLista.main = {
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
        MovimientoLista.main.mascara.show();
        this.msg = Ext.get('formularioMovimiento');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/editar',
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
	this.codigo  = MovimientoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_movimiento');
	MovimientoLista.main.mascara.show();
        this.msg = Ext.get('formularioMovimiento');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/editar/codigo/'+this.codigo,
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
	this.codigo  = MovimientoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_movimiento');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/eliminar',
            params:{
                co_presupuesto_movimiento:MovimientoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_movimiento')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    MovimientoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                MovimientoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroMovimiento');
        MovimientoLista.main.mascara.show();
        MovimientoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Movimiento',
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
    {header: 'co_presupuesto_movimiento',hidden:true, menuDisabled:true,dataIndex: 'co_presupuesto_movimiento'},
    {header: 'Co partida', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_partida'},
    {header: 'Nu monto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_monto'},
    {header: 'Nu anio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_anio'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    {header: 'Co usuario', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_usuario'},
    {header: 'Co tipo movimiento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_movimiento'},
    {header: 'Co detalle compra', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_detalle_compra'},
    {header: 'Tx observacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_observacion'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Co compra servicio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_compra_servicio'},
    {header: 'Co factura', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_factura'},
    {header: 'Mo saldo anterior', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_saldo_anterior'},
    {header: 'Mo saldo nuevo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_saldo_nuevo'},
    {header: 'Co solicitud anular', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud_anular'},
    {header: 'In anular', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_anular'},
    {header: 'In cerrado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_cerrado'},
    {header: 'Nu monto soberano', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_monto_soberano'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){MovimientoLista.main.editar.enable();MovimientoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorMovimientoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/storelista',
    root:'data',
    fields:[
    {name: 'co_presupuesto_movimiento'},
    {name: 'co_partida'},
    {name: 'nu_monto'},
    {name: 'nu_anio'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'co_usuario'},
    {name: 'co_tipo_movimiento'},
    {name: 'co_detalle_compra'},
    {name: 'tx_observacion'},
    {name: 'in_activo'},
    {name: 'co_compra_servicio'},
    {name: 'co_factura'},
    {name: 'mo_saldo_anterior'},
    {name: 'mo_saldo_nuevo'},
    {name: 'co_solicitud_anular'},
    {name: 'in_anular'},
    {name: 'in_cerrado'},
    {name: 'nu_monto_soberano'},
           ]
    });
    return this.store;
}
};
Ext.onReady(MovimientoLista.main.init, MovimientoLista.main);
</script>
<div id="contenedorMovimientoLista"></div>
<div id="formularioMovimiento"></div>
<div id="filtroMovimiento"></div>
