<script type="text/javascript">
Ext.ns("CierreMensualContable");
CierreMensualContable.main = {
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
        CierreMensualContable.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoEgreso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierreMensualContable/editar',
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
	this.codigo  = CierreMensualContable.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_ingreso');
	CierreMensualContable.main.mascara.show();
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
	this.codigo  = CierreMensualContable.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_ingreso');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoIngreso/eliminar',
            params:{
                co_presupuesto_ingreso:CierreMensualContable.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_ingreso')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    CierreMensualContable.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                CierreMensualContable.main.mascara.hide();
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
        CierreMensualContable.main.mascara.show();
        CierreMensualContable.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoIngreso/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

function renderMonto(val, attr, record) { 
     return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';  
} 

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Cierre Mensual',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo       
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_maestro_mensual',hidden:true, menuDisabled:true,dataIndex: 'co_maestro_mensual'},
    {header: 'Mes', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'mes'},
    {header: 'Año', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'nu_anio'},
    {header: 'Monto Debito', width:250,  menuDisabled:true, sortable: true,  dataIndex: 'mo_debe',renderer:renderMonto},
    {header: 'Monto Credito', width:250,  menuDisabled:true, sortable: true,  dataIndex: 'mo_haber',renderer:renderMonto}
 //   {header: 'Monto Disponible', width:180,  menuDisabled:true, sortable: true,  dataIndex: 'mo_disponible',renderer:renderMonto}
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){CierreMensualContable.main.editar.enable();CierreMensualContable.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorCierreMensualContable");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierreMensualContable/storelistaMaestro',
    root:'data',
    fields:[
            {name: 'co_maestro_mensual'},
            {name: 'mo_debe'},
            {name: 'mo_haber'},
            {name: 'mo_disponible'},
            {name: 'mes'},
            {name: 'nu_anio'}
           ]
    });
    return this.store;
}
};
Ext.onReady(CierreMensualContable.main.init, CierreMensualContable.main);
</script>
<div id="contenedorCierreMensualContable"></div>
<div id="formularioPresupuestoEgreso"></div>
<div id="filtroPresupuestoIngreso"></div>
