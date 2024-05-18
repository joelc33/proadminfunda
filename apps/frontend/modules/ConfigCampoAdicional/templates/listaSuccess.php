<script type="text/javascript">
Ext.ns("ConfigCampoAdicionalLista");
ConfigCampoAdicionalLista.main = {
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
        ConfigCampoAdicionalLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigCampoAdicional');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigCampoAdicional/editar',
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
	this.codigo  = ConfigCampoAdicionalLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concep_adicional');
	ConfigCampoAdicionalLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigCampoAdicional');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigCampoAdicional/editar/codigo/'+this.codigo,
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
	this.codigo  = ConfigCampoAdicionalLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concep_adicional');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigCampoAdicional/eliminar',
            params:{
                co_concep_adicional:ConfigCampoAdicionalLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concep_adicional')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConfigCampoAdicionalLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConfigCampoAdicionalLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConfigCampoAdicional');
        ConfigCampoAdicionalLista.main.mascara.show();
        ConfigCampoAdicionalLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigCampoAdicional/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de ConfigCampoAdicional',
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
    {header: 'co_concep_adicional',hidden:true, menuDisabled:true,dataIndex: 'co_concep_adicional'},
    {header: 'Campo Adicional', width:500,  menuDisabled:true, sortable: true,  dataIndex: 'tx_concep_adicional'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ConfigCampoAdicionalLista.main.editar.enable();ConfigCampoAdicionalLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConfigCampoAdicionalLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigCampoAdicional/storelista',
    root:'data',
    fields:[
    {name: 'co_concep_adicional'},
    {name: 'tx_concep_adicional'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ConfigCampoAdicionalLista.main.init, ConfigCampoAdicionalLista.main);
</script>
<div id="contenedorConfigCampoAdicionalLista"></div>
<div id="formularioConfigCampoAdicional"></div>
<div id="filtroConfigCampoAdicional"></div>
