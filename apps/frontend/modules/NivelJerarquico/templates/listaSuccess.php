<script type="text/javascript">
Ext.ns("NivelJerarquicoLista");
NivelJerarquicoLista.main = {
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
        NivelJerarquicoLista.main.mascara.show();
        this.msg = Ext.get('formularioNivelJerarquico');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NivelJerarquico/editar',
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
	this.codigo  = NivelJerarquicoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nivel_jerarquico');
	NivelJerarquicoLista.main.mascara.show();
        this.msg = Ext.get('formularioNivelJerarquico');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NivelJerarquico/editar/codigo/'+this.codigo,
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
	this.codigo  = NivelJerarquicoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nivel_jerarquico');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NivelJerarquico/eliminar',
            params:{
                co_nivel_jerarquico:NivelJerarquicoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nivel_jerarquico')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    NivelJerarquicoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                NivelJerarquicoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroNivelJerarquico');
        NivelJerarquicoLista.main.mascara.show();
        NivelJerarquicoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/NivelJerarquico/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Nivel Jerarquico',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_nivel_jerarquico',hidden:true, menuDisabled:true,dataIndex: 'co_nivel_jerarquico'},
    {header: 'Nivel Jerarquico', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_nivel_jerarquico'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){NivelJerarquicoLista.main.editar.enable();NivelJerarquicoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorNivelJerarquicoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NivelJerarquico/storelista',
    root:'data',
    fields:[
    {name: 'co_nivel_jerarquico'},
    {name: 'tx_nivel_jerarquico'},
           ]
    });
    return this.store;
}
};
Ext.onReady(NivelJerarquicoLista.main.init, NivelJerarquicoLista.main);
</script>
<div id="contenedorNivelJerarquicoLista"></div>
<div id="formularioNivelJerarquico"></div>
<div id="filtroNivelJerarquico"></div>
