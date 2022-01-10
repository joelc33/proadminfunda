<script type="text/javascript">
Ext.ns("CierrePresupuestoEgreso");
CierrePresupuestoEgreso.main = {
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
        CierrePresupuestoEgreso.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoEgreso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierreContable/editar',
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Detalle',
    iconCls: 'icon-reporteest',
    handler:function(){
	//CierrePresupuestoEgreso.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoEgreso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierreContable/detalle',
         params:{
                co_comprobante_contable:CierrePresupuestoEgreso.main.gridPanel_.getSelectionModel().getSelected().get('co_comprobante_contable')
            },
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
	this.codigo  = CierrePresupuestoEgreso.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_ingreso');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoIngreso/eliminar',
            params:{
                co_presupuesto_ingreso:CierrePresupuestoEgreso.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_ingreso')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    CierrePresupuestoEgreso.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                CierrePresupuestoEgreso.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPresupuestoIngreso');
        CierrePresupuestoEgreso.main.mascara.show();
        CierrePresupuestoEgreso.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoIngreso/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Cierres Administrativos Contables',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo ,'-',this.editar//,'-',this.eliminar,'-',this.filtro      
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_comprobante_contable',hidden:true, menuDisabled:true,dataIndex: 'co_comprobante_contable'},
    {header: 'Fecha', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'fe_comprobante'},
    {header: 'Tipo Documento', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo_asiento'},
    {header: 'Nro Comprobante', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_comprobante'},
    {header: 'Monto Debito', width:180,  menuDisabled:true, sortable: true,  dataIndex: 'mo_debito',renderer:renderMonto},
    {header: 'Monto Credito', width:180,  menuDisabled:true, sortable: true,  dataIndex: 'mo_credito',renderer:renderMonto}
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){CierrePresupuestoEgreso.main.editar.enable();CierrePresupuestoEgreso.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorCierrePresupuestoEgreso");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierreContable/storelistaMovimiento',
    root:'data',
    fields:[
            {name: 'co_comprobante_contable'},
            {name: 'nu_comprobante'},
            {name: 'mo_debito'},
            {name: 'mo_credito'},
            {name: 'tx_tipo_asiento'},
            {name: 'fe_comprobante'}
           ]
    });
    return this.store;
}
};
Ext.onReady(CierrePresupuestoEgreso.main.init, CierrePresupuestoEgreso.main);
</script>
<div id="contenedorCierrePresupuestoEgreso"></div>
<div id="formularioPresupuestoEgreso"></div>
<div id="filtroPresupuestoIngreso"></div>
