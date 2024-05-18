<script type="text/javascript">
Ext.ns("PresupuestoPartidaLista");
PresupuestoPartidaLista.main = {
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
        PresupuestoPartidaLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoPartida');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoPartida/editar',
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
	this.codigo  = PresupuestoPartidaLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	PresupuestoPartidaLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoPartida');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoPartida/editar/codigo/'+this.codigo,
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
	this.codigo  = PresupuestoPartidaLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoPartida/eliminar',
            params:{
                id:PresupuestoPartidaLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    PresupuestoPartidaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                PresupuestoPartidaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPresupuestoPartida');
        PresupuestoPartidaLista.main.mascara.show();
        PresupuestoPartidaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoPartida/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de PresupuestoPartida',
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
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){PresupuestoPartidaLista.main.editar.enable();PresupuestoPartidaLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorPresupuestoPartidaLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoPartida/storelista',
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
           ]
    });
    return this.store;
}
};
Ext.onReady(PresupuestoPartidaLista.main.init, PresupuestoPartidaLista.main);
</script>
<div id="contenedorPresupuestoPartidaLista"></div>
<div id="formularioPresupuestoPartida"></div>
<div id="filtroPresupuestoPartida"></div>
