<script type="text/javascript">
Ext.ns("ConfigTipoFrecuenciaLista");
function change(val){
	if(val==true){
	    return '<span style="color:green;">Activo</span>';
	}else if(val==false){
	    return '<span style="color:red;">Inactivo</span>';
	}
return val;
};
ConfigTipoFrecuenciaLista.main = {
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
        ConfigTipoFrecuenciaLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigTipoFrecuencia');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigTipoFrecuencia/editar',
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
	this.codigo  = ConfigTipoFrecuenciaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nom_frecuencia_pago');
	ConfigTipoFrecuenciaLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigTipoFrecuencia');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigTipoFrecuencia/editar/codigo/'+this.codigo,
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
	this.codigo  = ConfigTipoFrecuenciaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nom_frecuencia_pago');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigTipoFrecuencia/eliminar',
            params:{
                co_nom_frecuencia_pago:ConfigTipoFrecuenciaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nom_frecuencia_pago')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConfigTipoFrecuenciaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConfigTipoFrecuenciaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConfigTipoFrecuencia');
        ConfigTipoFrecuenciaLista.main.mascara.show();
        ConfigTipoFrecuenciaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigTipoFrecuencia/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Config Tipo Frecuencia',
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
    {header: 'co_nom_frecuencia_pago',hidden:true, menuDisabled:true,dataIndex: 'co_nom_frecuencia_pago'},
    {header: 'Frecuencia Pago', width:500,  menuDisabled:true, sortable: true,  dataIndex: 'tx_nom_frecuencia_pago'},
    {header: 'Estatus', width:100,  menuDisabled:true, sortable: true, renderer: change, dataIndex: 'in_activo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ConfigTipoFrecuenciaLista.main.editar.enable();ConfigTipoFrecuenciaLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConfigTipoFrecuenciaLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigTipoFrecuencia/storelista',
    root:'data',
    fields:[
    {name: 'co_nom_frecuencia_pago'},
    {name: 'tx_nom_frecuencia_pago'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ConfigTipoFrecuenciaLista.main.init, ConfigTipoFrecuenciaLista.main);
</script>
<div id="contenedorConfigTipoFrecuenciaLista"></div>
<div id="formularioConfigTipoFrecuencia"></div>
<div id="filtroConfigTipoFrecuencia"></div>
