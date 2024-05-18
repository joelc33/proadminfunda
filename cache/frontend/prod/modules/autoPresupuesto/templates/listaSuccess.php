<script type="text/javascript">
Ext.ns("PresupuestoLista");
PresupuestoLista.main = {
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
        PresupuestoLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuesto');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/editar',
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
	this.codigo  = PresupuestoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_partida');
	PresupuestoLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuesto');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/editar/codigo/'+this.codigo,
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
	this.codigo  = PresupuestoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_partida');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/eliminar',
            params:{
                co_presupuesto_partida:PresupuestoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_presupuesto_partida')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    PresupuestoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                PresupuestoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPresupuesto');
        PresupuestoLista.main.mascara.show();
        PresupuestoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Presupuesto',
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
    {header: 'co_presupuesto_partida',hidden:true, menuDisabled:true,dataIndex: 'co_presupuesto_partida'},
    {header: 'Co partida presupuestaria', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_partida_presupuestaria'},
    {header: 'Co actividad', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_actividad'},
    {header: 'Mo inicial', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_inicial'},
    {header: 'Mo autorizado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_autorizado'},
    {header: 'Mo comprometido', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_comprometido'},
    {header: 'Mo causado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_causado'},
    {header: 'Mo pagado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_pagado'},
    {header: 'Co anio fiscal', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_anio_fiscal'},
    {header: 'Mo disponible', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_disponible'},
    {header: 'Mo deuda', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_deuda'},
    {header: 'Co cuenta contable', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_cuenta_contable'},
    {header: 'Mo debito', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_debito'},
    {header: 'Mo credito', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_credito'},
    {header: 'In ordinal', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_ordinal'},
    {header: 'Co tipo presupuesto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_presupuesto'},
    {header: 'Mo aumento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_aumento'},
    {header: 'Mo disminucion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_disminucion'},
    {header: 'Mo precomprometido', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_precomprometido'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){PresupuestoLista.main.editar.enable();PresupuestoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorPresupuestoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storelista',
    root:'data',
    fields:[
    {name: 'co_presupuesto_partida'},
    {name: 'co_partida_presupuestaria'},
    {name: 'co_actividad'},
    {name: 'mo_inicial'},
    {name: 'mo_autorizado'},
    {name: 'mo_comprometido'},
    {name: 'mo_causado'},
    {name: 'mo_pagado'},
    {name: 'co_anio_fiscal'},
    {name: 'mo_disponible'},
    {name: 'mo_deuda'},
    {name: 'co_cuenta_contable'},
    {name: 'mo_debito'},
    {name: 'mo_credito'},
    {name: 'in_ordinal'},
    {name: 'co_tipo_presupuesto'},
    {name: 'mo_aumento'},
    {name: 'mo_disminucion'},
    {name: 'mo_precomprometido'},
           ]
    });
    return this.store;
}
};
Ext.onReady(PresupuestoLista.main.init, PresupuestoLista.main);
</script>
<div id="contenedorPresupuestoLista"></div>
<div id="formularioPresupuesto"></div>
<div id="filtroPresupuesto"></div>
