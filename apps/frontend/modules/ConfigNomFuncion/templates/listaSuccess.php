<script type="text/javascript">
Ext.ns("ConfigNomFuncionLista");
ConfigNomFuncionLista.main = {
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
        ConfigNomFuncionLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigNomFuncion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigNomFuncion/editar',
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
	this.codigo  = ConfigNomFuncionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nom_funcion');
	ConfigNomFuncionLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigNomFuncion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigNomFuncion/editar/codigo/'+this.codigo,
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
	this.codigo  = ConfigNomFuncionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nom_funcion');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigNomFuncion/eliminar',
            params:{
                co_nom_funcion:ConfigNomFuncionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nom_funcion')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConfigNomFuncionLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConfigNomFuncionLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConfigNomFuncion');
        ConfigNomFuncionLista.main.mascara.show();
        ConfigNomFuncionLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigNomFuncion/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Config Nom Funcion',
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
    {header: 'co_nom_funcion',hidden:true, menuDisabled:true,dataIndex: 'co_nom_funcion'},
    {header: 'Variable/Funcion', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_nom_funcion'},
    {header: 'Descripcion', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_nom_descripcion'},
    {header: 'Parametro', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_nom_parametro'},
    {header: 'Tipo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tp_funcion'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ConfigNomFuncionLista.main.editar.enable();ConfigNomFuncionLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 100,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConfigNomFuncionLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigNomFuncion/storelista',
    root:'data',
    fields:[
    {name: 'co_nom_funcion'},
    {name: 'tx_nom_funcion'},
    {name: 'tx_nom_descripcion'},
    {name: 'tx_nom_parametro'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'co_tp_funcion'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ConfigNomFuncionLista.main.init, ConfigNomFuncionLista.main);
</script>
<div id="contenedorConfigNomFuncionLista"></div>
<div id="formularioConfigNomFuncion"></div>
<div id="filtroConfigNomFuncion"></div>
