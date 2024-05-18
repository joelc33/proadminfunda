<script type="text/javascript">
Ext.ns("ConfigSalarioMinimoLista");
function change(val){
	if(val==true){
	    return '<span style="color:green;">Activo</span>';
	}else if(val==false){
	    return '<span style="color:red;">Inactivo</span>';
	}
return val;
};
ConfigSalarioMinimoLista.main = {
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
        ConfigSalarioMinimoLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigSalarioMinimo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigSalarioMinimo/editar',
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
	this.codigo  = ConfigSalarioMinimoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	ConfigSalarioMinimoLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigSalarioMinimo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigSalarioMinimo/editar/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Eliminar un registro
this.eliminar= new Ext.Button({
    text:'Deshabilitar',
    iconCls: 'icon-eliminar',
    handler:function(){
	this.codigo  = ConfigSalarioMinimoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigSalarioMinimo/eliminar',
            params:{
                id:ConfigSalarioMinimoLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConfigSalarioMinimoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConfigSalarioMinimoLista.main.mascara.hide();
            }});
	}});
    }
});

//Eliminar un registro
this.habilitar= new Ext.Button({
    text:'Habilitar',
    iconCls: 'icon-fin',
    handler:function(){
	this.codigo  = ConfigSalarioMinimoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea habilitar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigSalarioMinimo/habilitar',
            params:{
                id:ConfigSalarioMinimoLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConfigSalarioMinimoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConfigSalarioMinimoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConfigSalarioMinimo');
        ConfigSalarioMinimoLista.main.mascara.show();
        ConfigSalarioMinimoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigSalarioMinimo/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();
this.habilitar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Config Salario Minimo',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar,'-',this.habilitar,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Salario Minimo', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'mo_salario_minimo'},
    {header: 'Fecha inicio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_ini'},
    {header: 'Fecha cierre', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_fin'},
    {header: 'Estado', width:100,  menuDisabled:true, sortable: true, renderer: change, dataIndex: 'in_activo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{
        cellclick:function(Grid, rowIndex, columnIndex,e ){
            ConfigSalarioMinimoLista.main.editar.enable();
            ConfigSalarioMinimoLista.main.eliminar.enable();
            ConfigSalarioMinimoLista.main.habilitar.enable();
        }
    },
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConfigSalarioMinimoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigSalarioMinimo/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'mo_salario_minimo'},
    {name: 'fe_ini'},
    {name: 'fe_fin'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ConfigSalarioMinimoLista.main.init, ConfigSalarioMinimoLista.main);
</script>
<div id="contenedorConfigSalarioMinimoLista"></div>
<div id="formularioConfigSalarioMinimo"></div>
<div id="filtroConfigSalarioMinimo"></div>
