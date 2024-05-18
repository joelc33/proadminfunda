<script type="text/javascript">
Ext.ns("ConfigDecretoLista");
ConfigDecretoLista.main = {
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
        ConfigDecretoLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigDecreto');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigDecreto/editar',
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
	this.codigo  = ConfigDecretoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_numero_fuente');
	ConfigDecretoLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigDecreto');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigDecreto/editar/codigo/'+this.codigo,
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
	this.codigo  = ConfigDecretoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_numero_fuente');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigDecreto/eliminar',
            params:{
                co_numero_fuente:ConfigDecretoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_numero_fuente')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConfigDecretoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConfigDecretoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConfigDecreto');
        ConfigDecretoLista.main.mascara.show();
        ConfigDecretoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigDecreto/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Decreto',
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
    {header: 'co_numero_fuente',hidden:true, menuDisabled:true,dataIndex: 'co_numero_fuente'},
    {header: 'Tipo de  Financiamiento', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'co_fuente_financiamiento'},
    {header: 'Fuente Financiamiento', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'de_tipo_fuente_financiamiento'},
    {header: 'N° Decreto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_numero_fuente'},
    {header: 'Ejercicio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb013_anio_fiscal'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ConfigDecretoLista.main.editar.enable();ConfigDecretoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConfigDecretoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigDecreto/storelista',
    root:'data',
    fields:[
    {name: 'co_numero_fuente'},
    {name: 'co_fuente_financiamiento'},
    {name: 'tx_numero_fuente'},
    {name: 'co_usuario'},
    {name: 'de_tipo_fuente_financiamiento'},
    {name: 'created_at'},
    {name: 'id_tb013_anio_fiscal'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ConfigDecretoLista.main.init, ConfigDecretoLista.main);
</script>
<div id="contenedorConfigDecretoLista"></div>
<div id="formularioConfigDecreto"></div>
<div id="filtroConfigDecreto"></div>
