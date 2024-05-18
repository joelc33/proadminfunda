<script type="text/javascript">
Ext.ns("CierrePresupuestoIngreso");
CierrePresupuestoIngreso.main = {
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
        CierrePresupuestoIngreso.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoEgreso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierrePresupuestoIngreso/editar',
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Movimientos',
    iconCls: 'icon-reporteest',
    handler:function(){
	this.codigo  = CierrePresupuestoIngreso.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_ingreso');
	CierrePresupuestoIngreso.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoEgreso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/listaIngreso/codigo/'+this.codigo,
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
	this.codigo  = CierrePresupuestoIngreso.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_ingreso');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoIngreso/eliminar',
            params:{
                co_presupuesto_ingreso:CierrePresupuestoIngreso.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_ingreso')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    CierrePresupuestoIngreso.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                CierrePresupuestoIngreso.main.mascara.hide();
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
        CierrePresupuestoIngreso.main.mascara.show();
        CierrePresupuestoIngreso.main.filtro.setDisabled(true);
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
    title:'Lista de Presupuesto Ingreso',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo //,'-',this.editar,'-',this.eliminar,'-',this.filtro      
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_cierre_ingreso',hidden:true, menuDisabled:true,dataIndex: 'co_cierre_ingreso'},
    //{header: 'Fecha Desde', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'fe_desde'},
    //{header: 'Fecha Hasta', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'fe_hasta'},
    {header: 'Mes', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'mes'},
    {header: 'Año', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'nu_anio'},
    {header: 'Monto Devengado', width:180,  menuDisabled:true, sortable: true,  dataIndex: 'mo_comprometido',renderer:renderMonto},
    {header: 'Monto Liquidado', width:180,  menuDisabled:true, sortable: true,  dataIndex: 'mo_causado',renderer:renderMonto},
    {header: 'Monto Recaudado', width:180,  menuDisabled:true, sortable: true,  dataIndex: 'mo_pagado',renderer:renderMonto}
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){CierrePresupuestoIngreso.main.editar.enable();CierrePresupuestoIngreso.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorCierrePresupuestoIngreso");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierrePresupuestoIngreso/storelistaCierre',
    root:'data',
    fields:[
            {name: 'co_cierre_ingreso'},
            {name: 'fe_desde'},
            {name: 'fe_hasta'},
            {name: 'mo_comprometido'},
            {name: 'mo_causado'},
            {name: 'mo_pagado'},
            {name: 'mes'},
            {name: 'nu_anio'}
           ]
    });
    return this.store;
}
};
Ext.onReady(CierrePresupuestoIngreso.main.init, CierrePresupuestoIngreso.main);
</script>
<div id="contenedorCierrePresupuestoIngreso"></div>
<div id="formularioPresupuestoEgreso"></div>
<div id="filtroPresupuestoIngreso"></div>
