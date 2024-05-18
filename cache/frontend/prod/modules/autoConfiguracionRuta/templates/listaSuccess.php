<script type="text/javascript">
Ext.ns("ConfiguracionRutaLista");
ConfiguracionRutaLista.main = {
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
        ConfiguracionRutaLista.main.mascara.show();
        this.msg = Ext.get('formularioConfiguracionRuta');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfiguracionRuta/editar',
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
	this.codigo  = ConfiguracionRutaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_configuracion');
	ConfiguracionRutaLista.main.mascara.show();
        this.msg = Ext.get('formularioConfiguracionRuta');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfiguracionRuta/editar/codigo/'+this.codigo,
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
	this.codigo  = ConfiguracionRutaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_configuracion');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfiguracionRuta/eliminar',
            params:{
                co_configuracion:ConfiguracionRutaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_configuracion')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConfiguracionRutaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConfiguracionRutaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConfiguracionRuta');
        ConfiguracionRutaLista.main.mascara.show();
        ConfiguracionRutaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfiguracionRuta/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de ConfiguracionRuta',
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
    {header: 'co_configuracion',hidden:true, menuDisabled:true,dataIndex: 'co_configuracion'},
    {header: 'Co tipo solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_solicitud'},
    {header: 'Co proceso', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_proceso'},
    {header: 'Nu orden', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_orden'},
    {header: 'In cargar dato', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_cargar_dato'},
    {header: 'Nb reporte orden', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nb_reporte_orden'},
    {header: 'Tx url', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_url'},
    {header: 'Tx modulo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_modulo'},
    {header: 'In incompleto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_incompleto'},
    {header: 'Op reporte', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'op_reporte'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ConfiguracionRutaLista.main.editar.enable();ConfiguracionRutaLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConfiguracionRutaLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfiguracionRuta/storelista',
    root:'data',
    fields:[
    {name: 'co_configuracion'},
    {name: 'co_tipo_solicitud'},
    {name: 'co_proceso'},
    {name: 'nu_orden'},
    {name: 'in_cargar_dato'},
    {name: 'nb_reporte_orden'},
    {name: 'tx_url'},
    {name: 'tx_modulo'},
    {name: 'in_incompleto'},
    {name: 'op_reporte'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ConfiguracionRutaLista.main.init, ConfiguracionRutaLista.main);
</script>
<div id="contenedorConfiguracionRutaLista"></div>
<div id="formularioConfiguracionRuta"></div>
<div id="filtroConfiguracionRuta"></div>
