<script type="text/javascript">
Ext.ns("FuenteFinanciamientoLista");
FuenteFinanciamientoLista.main = {
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
        FuenteFinanciamientoLista.main.mascara.show();
        this.msg = Ext.get('formularioFuenteFinanciamiento');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FuenteFinanciamiento/editar',
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
	this.codigo  = FuenteFinanciamientoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_fuente_financiamiento');
	FuenteFinanciamientoLista.main.mascara.show();
        this.msg = Ext.get('formularioFuenteFinanciamiento');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FuenteFinanciamiento/editar/codigo/'+this.codigo,
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
	this.codigo  = FuenteFinanciamientoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_fuente_financiamiento');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FuenteFinanciamiento/eliminar',
            params:{
                co_fuente_financiamiento:FuenteFinanciamientoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_fuente_financiamiento')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    FuenteFinanciamientoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                FuenteFinanciamientoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroFuenteFinanciamiento');
        FuenteFinanciamientoLista.main.mascara.show();
        FuenteFinanciamientoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/FuenteFinanciamiento/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Fuentes de Financiamiento',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar//,'-',this.eliminar,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_fuente_financiamiento',hidden:true, menuDisabled:true,dataIndex: 'co_fuente_financiamiento'},
    {header: 'Fuente Financiamiento', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_fuente_financiamiento'},
    {header: 'Siglas', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_siglas'},
    {header: 'Activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){FuenteFinanciamientoLista.main.editar.enable();FuenteFinanciamientoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorFuenteFinanciamientoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FuenteFinanciamiento/storelista',
    root:'data',
    fields:[
    {name: 'co_fuente_financiamiento'},
    {name: 'tx_fuente_financiamiento'},
    {name: 'tx_siglas'},
    {name: 'in_activo'},
           ]
    });
    return this.store;
}
};
Ext.onReady(FuenteFinanciamientoLista.main.init, FuenteFinanciamientoLista.main);
</script>
<div id="contenedorFuenteFinanciamientoLista"></div>
<div id="formularioFuenteFinanciamiento"></div>
<div id="filtroFuenteFinanciamiento"></div>
