<script type="text/javascript">
Ext.ns("PresupuestoMasivoLista");
PresupuestoMasivoLista.main = {
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
        PresupuestoMasivoLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoMasivo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoMasivo/editar',
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
	this.codigo  = PresupuestoMasivoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	PresupuestoMasivoLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoMasivo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoMasivo/editar/codigo/'+this.codigo,
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
	this.codigo  = PresupuestoMasivoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoMasivo/eliminar',
            params:{
                id:PresupuestoMasivoLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    PresupuestoMasivoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                PresupuestoMasivoLista.main.mascara.hide();
            }});
	}});
    }
});

//Agregar un registro
this.importar = new Ext.Button({
    text:'Importar',
    iconCls: 'icon-descargar',
    handler:function(){
        PresupuestoMasivoLista.main.mascara.show();
        this.msg = Ext.get('formularioPresupuestoMasivo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoMasivo/importar',
         scripts: true,
         text: "Cargando.."
        });
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPresupuestoMasivo');
        PresupuestoMasivoLista.main.mascara.show();
        PresupuestoMasivoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoMasivo/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de PresupuestoMasivo',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar,'-',this.filtro,'-',this.importar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Nu ejercicio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_ejercicio'},
    {header: 'Nu ejecutor', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_ejecutor'},
    {header: 'De ejecutor', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_ejecutor'},
    {header: 'Nu sector', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_sector'},
    {header: 'Co ac pr', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_ac_pr'},
    {header: 'Nu proyecto ac', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_proyecto_ac'},
    {header: 'De proyecto ac', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_proyecto_ac'},
    {header: 'Nu accion especifica', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_accion_especifica'},
    {header: 'De accion especifica', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_accion_especifica'},
    {header: 'Nu partida', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_partida'},
    {header: 'Nu desagregado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_desagregado'},
    {header: 'Nu fi', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_fi'},
    {header: 'De partida', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_partida'},
    {header: 'Mo inicial', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_inicial'},
    {header: 'Co categoria', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_categoria'},
    {header: 'Nu pa', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_pa'},
    {header: 'Nu aplicacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_aplicacion'},
    {header: 'Nu area estrategica', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_area_estrategica'},
    {header: 'Nu amb', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_amb'},
    {header: 'Tip gasto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tip_gasto'},
    {header: 'Nu clasificacion economica', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_clasificacion_economica'},
    {header: 'Tipo ordenador', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tipo_ordenador'},
    {header: 'Tp ingreso', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tp_ingreso'},
    {header: 'Nu ff', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_ff'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){PresupuestoMasivoLista.main.editar.enable();PresupuestoMasivoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorPresupuestoMasivoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoMasivo/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'nu_ejercicio'},
    {name: 'nu_ejecutor'},
    {name: 'de_ejecutor'},
    {name: 'nu_sector'},
    {name: 'co_ac_pr'},
    {name: 'nu_proyecto_ac'},
    {name: 'de_proyecto_ac'},
    {name: 'nu_accion_especifica'},
    {name: 'de_accion_especifica'},
    {name: 'nu_partida'},
    {name: 'nu_desagregado'},
    {name: 'nu_fi'},
    {name: 'de_partida'},
    {name: 'mo_inicial'},
    {name: 'co_categoria'},
    {name: 'nu_pa'},
    {name: 'nu_aplicacion'},
    {name: 'nu_area_estrategica'},
    {name: 'nu_amb'},
    {name: 'tip_gasto'},
    {name: 'nu_clasificacion_economica'},
    {name: 'tipo_ordenador'},
    {name: 'tp_ingreso'},
    {name: 'nu_ff'},
           ]
    });
    return this.store;
}
};
Ext.onReady(PresupuestoMasivoLista.main.init, PresupuestoMasivoLista.main);
</script>
<div id="contenedorPresupuestoMasivoLista"></div>
<div id="formularioPresupuestoMasivo"></div>
<div id="filtroPresupuestoMasivo"></div>
