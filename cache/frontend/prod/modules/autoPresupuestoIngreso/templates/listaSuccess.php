<script type="text/javascript">
Ext.ns("PresupuestoIngresoLista");
PresupuestoIngresoLista.main = {
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
        PresupuestoIngresoLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoIngreso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoIngreso/editar',
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
	this.codigo  = PresupuestoIngresoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_ingreso');
	PresupuestoIngresoLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoIngreso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoIngreso/editar/codigo/'+this.codigo,
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
	this.codigo  = PresupuestoIngresoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_ingreso');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoIngreso/eliminar',
            params:{
                co_presupuesto_ingreso:PresupuestoIngresoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_ingreso')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    PresupuestoIngresoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                PresupuestoIngresoLista.main.mascara.hide();
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
        PresupuestoIngresoLista.main.mascara.show();
        PresupuestoIngresoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoIngreso/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de PresupuestoIngreso',
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
    {header: 'co_presupuesto_ingreso',hidden:true, menuDisabled:true,dataIndex: 'co_presupuesto_ingreso'},
    {header: 'Nu partida', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_partida'},
    {header: 'Tx partida', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_partida'},
    {header: 'Tx descripcion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_descripcion'},
    {header: 'Mo inicial', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_inicial'},
    {header: 'Mo actualizado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_actualizado'},
    {header: 'Nu anio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_anio'},
    {header: 'Mo comprometido', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_comprometido'},
    {header: 'Mo causado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_causado'},
    {header: 'Mo pagado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_pagado'},
    {header: 'Mo disponible', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_disponible'},
    {header: 'Nu nivel', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_nivel'},
    {header: 'Do cat', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'do_cat'},
    {header: 'Tip apl', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tip_apl'},
    {header: 'Tip gas', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tip_gas'},
    {header: 'Mo comprometido dia', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_comprometido_dia'},
    {header: 'Nu pa', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_pa'},
    {header: 'Nu ge', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_ge'},
    {header: 'Nu es', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_es'},
    {header: 'Nu se', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_se'},
    {header: 'Nu sse', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_sse'},
    {header: 'Co cuenta contable', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_cuenta_contable'},
    {header: 'In movimiento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_movimiento'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){PresupuestoIngresoLista.main.editar.enable();PresupuestoIngresoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorPresupuestoIngresoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoIngreso/storelista',
    root:'data',
    fields:[
    {name: 'co_presupuesto_ingreso'},
    {name: 'nu_partida'},
    {name: 'tx_partida'},
    {name: 'tx_descripcion'},
    {name: 'mo_inicial'},
    {name: 'mo_actualizado'},
    {name: 'nu_anio'},
    {name: 'mo_comprometido'},
    {name: 'mo_causado'},
    {name: 'mo_pagado'},
    {name: 'mo_disponible'},
    {name: 'nu_nivel'},
    {name: 'do_cat'},
    {name: 'tip_apl'},
    {name: 'tip_gas'},
    {name: 'mo_comprometido_dia'},
    {name: 'nu_pa'},
    {name: 'nu_ge'},
    {name: 'nu_es'},
    {name: 'nu_se'},
    {name: 'nu_sse'},
    {name: 'co_cuenta_contable'},
    {name: 'in_movimiento'},
           ]
    });
    return this.store;
}
};
Ext.onReady(PresupuestoIngresoLista.main.init, PresupuestoIngresoLista.main);
</script>
<div id="contenedorPresupuestoIngresoLista"></div>
<div id="formularioPresupuestoIngreso"></div>
<div id="filtroPresupuestoIngreso"></div>
