<script type="text/javascript">
Ext.ns("PartidapresupuestoLista");
PartidapresupuestoLista.main = {
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
        PartidapresupuestoLista.main.mascara.show();
        this.msg = Ext.get('formularioPartidapresupuesto');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/editar',
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
	this.codigo  = PartidapresupuestoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	PartidapresupuestoLista.main.mascara.show();
        this.msg = Ext.get('formularioPartidapresupuesto');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/editar/codigo/'+this.codigo,
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
	this.codigo  = PartidapresupuestoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/eliminar',
            params:{
                id:PartidapresupuestoLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    PartidapresupuestoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                PartidapresupuestoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPartidapresupuesto');
        PartidapresupuestoLista.main.mascara.show();
        PartidapresupuestoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Partidapresupuesto',
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
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Id tb084 accion especifica', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb084_accion_especifica'},
    {header: 'Nu partida', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_partida'},
    {header: 'De partida', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_partida'},
    {header: 'Mo inicial', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_inicial'},
    {header: 'Mo actualizado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_actualizado'},
    {header: 'Mo precomprometido', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_precomprometido'},
    {header: 'Mo comprometido', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_comprometido'},
    {header: 'Mo causado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_causado'},
    {header: 'Mo pagado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_pagado'},
    {header: 'Mo disponible', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_disponible'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    {header: 'In movimiento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_movimiento'},
    {header: 'Nu pa', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_pa'},
    {header: 'Nu ge', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_ge'},
    {header: 'Nu es', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_es'},
    {header: 'Nu se', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_se'},
    {header: 'Nu sse', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_sse'},
    {header: 'Co partida', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_partida'},
    {header: 'Nu nivel', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_nivel'},
    {header: 'Nu fi', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_fi'},
    {header: 'Co categoria', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_categoria'},
    {header: 'Nu aplicacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_aplicacion'},
    {header: 'Tp ingreso', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tp_ingreso'},
    {header: 'Co cuenta contable', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_cuenta_contable'},
    {header: 'Tip apl', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tip_apl'},
    {header: 'In gen cheque', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_gen_cheque'},
    {header: 'Tip gasto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tip_gasto'},
    {header: 'Tip ing', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tip_ing'},
    {header: 'Cod amb', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'cod_amb'},
    {header: 'Co ente', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_ente'},
    {header: 'Nu anio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_anio'},
    {header: 'Mo disponible act', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_disponible_act'},
    {header: 'Mo aumento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_aumento'},
    {header: 'Mo disminucion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_disminucion'},
    {header: 'Mo admon', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_admon'},
    {header: 'Mo actualizado ant', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_actualizado_ant'},
    {header: 'Comprometido dia', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'comprometido_dia'},
    {header: 'Causado dia', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'causado_dia'},
    {header: 'Pagado dia', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'pagado_dia'},
    {header: 'Disponible', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'disponible'},
    {header: 'Cod ente', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'cod_ente'},
    {header: 'Nu sector', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_sector'},
    {header: 'Id tb139 aplicacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb139_aplicacion'},
    {header: 'Mo admon ant', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_admon_ant'},
    {header: 'Mo modificado admon', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_modificado_admon'},
    {header: 'Co clasificacion economica', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_clasificacion_economica'},
    {header: 'Co area estrategica', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_area_estrategica'},
    {header: 'Mo inicial soberano', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_inicial_soberano'},
    {header: 'Mo actualizado soberano', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_actualizado_soberano'},
    {header: 'Mo comprometido soberano', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_comprometido_soberano'},
    {header: 'Mo causado soberano', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_causado_soberano'},
    {header: 'Mo pagado soberano', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_pagado_soberano'},
    {header: 'Mo disponible soberano', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_disponible_soberano'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){PartidapresupuestoLista.main.editar.enable();PartidapresupuestoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorPartidapresupuestoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'id_tb084_accion_especifica'},
    {name: 'nu_partida'},
    {name: 'de_partida'},
    {name: 'mo_inicial'},
    {name: 'mo_actualizado'},
    {name: 'mo_precomprometido'},
    {name: 'mo_comprometido'},
    {name: 'mo_causado'},
    {name: 'mo_pagado'},
    {name: 'mo_disponible'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'in_movimiento'},
    {name: 'nu_pa'},
    {name: 'nu_ge'},
    {name: 'nu_es'},
    {name: 'nu_se'},
    {name: 'nu_sse'},
    {name: 'co_partida'},
    {name: 'nu_nivel'},
    {name: 'nu_fi'},
    {name: 'co_categoria'},
    {name: 'nu_aplicacion'},
    {name: 'tp_ingreso'},
    {name: 'co_cuenta_contable'},
    {name: 'tip_apl'},
    {name: 'in_gen_cheque'},
    {name: 'tip_gasto'},
    {name: 'tip_ing'},
    {name: 'cod_amb'},
    {name: 'co_ente'},
    {name: 'nu_anio'},
    {name: 'mo_disponible_act'},
    {name: 'mo_aumento'},
    {name: 'mo_disminucion'},
    {name: 'mo_admon'},
    {name: 'mo_actualizado_ant'},
    {name: 'comprometido_dia'},
    {name: 'causado_dia'},
    {name: 'pagado_dia'},
    {name: 'disponible'},
    {name: 'cod_ente'},
    {name: 'nu_sector'},
    {name: 'id_tb139_aplicacion'},
    {name: 'mo_admon_ant'},
    {name: 'mo_modificado_admon'},
    {name: 'co_clasificacion_economica'},
    {name: 'co_area_estrategica'},
    {name: 'mo_inicial_soberano'},
    {name: 'mo_actualizado_soberano'},
    {name: 'mo_comprometido_soberano'},
    {name: 'mo_causado_soberano'},
    {name: 'mo_pagado_soberano'},
    {name: 'mo_disponible_soberano'},
           ]
    });
    return this.store;
}
};
Ext.onReady(PartidapresupuestoLista.main.init, PartidapresupuestoLista.main);
</script>
<div id="contenedorPartidapresupuestoLista"></div>
<div id="formularioPartidapresupuesto"></div>
<div id="filtroPartidapresupuesto"></div>
