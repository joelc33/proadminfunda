<script type="text/javascript">
Ext.ns("ConfigConceptoFijoLista");
ConfigConceptoFijoLista.main = {
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
        ConfigConceptoFijoLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigConceptoFijo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoFijo/editar',
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
	this.codigo  = ConfigConceptoFijoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_conceptos_fijos');
	ConfigConceptoFijoLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigConceptoFijo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoFijo/editar/codigo/'+this.codigo,
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
	this.codigo  = ConfigConceptoFijoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_conceptos_fijos');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoFijo/eliminar',
            params:{
                co_conceptos_fijos:ConfigConceptoFijoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_conceptos_fijos')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConfigConceptoFijoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConfigConceptoFijoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConfigConceptoFijo');
        ConfigConceptoFijoLista.main.mascara.show();
        ConfigConceptoFijoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoFijo/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de ConfigConceptoFijo',
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
    {header: 'co_conceptos_fijos',hidden:true, menuDisabled:true,dataIndex: 'co_conceptos_fijos'},
    {header: 'Co nom trabajador', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_nom_trabajador'},
    {header: 'Nu monto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_monto'},
    {header: 'Nu valor', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_valor'},
    {header: 'Mo saldo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_saldo'},
    {header: 'Fe movimiento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_movimiento'},
    {header: 'Fe vencimiento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_vencimiento'},
    {header: 'Co embargo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_embargo'},
    {header: 'Co tp formula', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tp_formula'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    {header: 'Tx codigo concepto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_codigo_concepto'},
    {header: 'Co concepto formula', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_concepto_formula'},
    {header: 'Co ficha', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_ficha'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ConfigConceptoFijoLista.main.editar.enable();ConfigConceptoFijoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConfigConceptoFijoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoFijo/storelista',
    root:'data',
    fields:[
    {name: 'co_conceptos_fijos'},
    {name: 'co_nom_trabajador'},
    {name: 'nu_monto'},
    {name: 'nu_valor'},
    {name: 'mo_saldo'},
    {name: 'fe_movimiento'},
    {name: 'fe_vencimiento'},
    {name: 'co_embargo'},
    {name: 'co_tp_formula'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'tx_codigo_concepto'},
    {name: 'co_concepto_formula'},
    {name: 'co_ficha'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ConfigConceptoFijoLista.main.init, ConfigConceptoFijoLista.main);
</script>
<div id="contenedorConfigConceptoFijoLista"></div>
<div id="formularioConfigConceptoFijo"></div>
<div id="filtroConfigConceptoFijo"></div>
