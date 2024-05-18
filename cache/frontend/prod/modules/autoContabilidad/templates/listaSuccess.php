<script type="text/javascript">
Ext.ns("ContabilidadLista");
ContabilidadLista.main = {
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
        ContabilidadLista.main.mascara.show();
        this.msg = Ext.get('formularioContabilidad');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/editar',
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
	this.codigo  = ContabilidadLista.main.gridPanel_.getSelectionModel().getSelected().get('co_contrato_compras');
	ContabilidadLista.main.mascara.show();
        this.msg = Ext.get('formularioContabilidad');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/editar/codigo/'+this.codigo,
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
	this.codigo  = ContabilidadLista.main.gridPanel_.getSelectionModel().getSelected().get('co_contrato_compras');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/eliminar',
            params:{
                co_contrato_compras:ContabilidadLista.main.gridPanel_.getSelectionModel().getSelected().get('co_contrato_compras')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ContabilidadLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ContabilidadLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroContabilidad');
        ContabilidadLista.main.mascara.show();
        ContabilidadLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Contabilidad',
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
    {header: 'co_contrato_compras',hidden:true, menuDisabled:true,dataIndex: 'co_contrato_compras'},
    {header: 'Co compras', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_compras'},
    {header: 'Fecha inicio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fecha_inicio'},
    {header: 'Fecha fin', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fecha_fin'},
    {header: 'Co ramo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_ramo'},
    {header: 'Monto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'monto'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Fecha entrega', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fecha_entrega'},
    {header: 'Tiempo garantia', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tiempo_garantia'},
    {header: 'Co tp contrato', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tp_contrato'},
    {header: 'Co fuente financiamiento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_fuente_financiamiento'},
    {header: 'Nu expediente', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_expediente'},
    {header: 'Co solicitud anular', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud_anular'},
    {header: 'In anular', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_anular'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ContabilidadLista.main.editar.enable();ContabilidadLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorContabilidadLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/storelista',
    root:'data',
    fields:[
    {name: 'co_contrato_compras'},
    {name: 'co_compras'},
    {name: 'fecha_inicio'},
    {name: 'fecha_fin'},
    {name: 'co_ramo'},
    {name: 'monto'},
    {name: 'created_at'},
    {name: 'fecha_entrega'},
    {name: 'tiempo_garantia'},
    {name: 'co_tp_contrato'},
    {name: 'co_fuente_financiamiento'},
    {name: 'nu_expediente'},
    {name: 'co_solicitud_anular'},
    {name: 'in_anular'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ContabilidadLista.main.init, ContabilidadLista.main);
</script>
<div id="contenedorContabilidadLista"></div>
<div id="formularioContabilidad"></div>
<div id="filtroContabilidad"></div>
