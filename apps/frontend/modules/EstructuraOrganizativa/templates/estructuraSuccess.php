<script type="text/javascript">
Ext.ns("EstructuraOrganizativaListaEstructura");
EstructuraOrganizativaListaEstructura.main = {
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
        EstructuraOrganizativaListaEstructura.main.mascara.show();
        this.msg = Ext.get('formularioEstructuraOrganizativaListaEstructura');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/editar',
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
	this.codigo  = EstructuraOrganizativaListaEstructura.main.gridPanel_.getSelectionModel().getSelected().get('co_estructura_administrativa');
	EstructuraOrganizativaListaEstructura.main.mascara.show();
        this.msg = Ext.get('formularioEstructuraOrganizativaListaEstructura');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/editar/codigo/'+this.codigo,
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
	this.codigo  = EstructuraOrganizativaListaEstructura.main.gridPanel_.getSelectionModel().getSelected().get('co_estructura_administrativa');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/eliminar',
            params:{
                co_nivel_jerarquico:EstructuraOrganizativaListaEstructura.main.gridPanel_.getSelectionModel().getSelected().get('co_estructura_administrativa')
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
        EstructuraOrganizativaListaEstructura.main.mascara.show();
        EstructuraOrganizativaListaEstructura.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista Estructura',
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
    {header: 'co_estructura_administrativa',hidden:true, menuDisabled:true,dataIndex: 'co_estructura_administrativa'},
    {header: 'co_padre',hidden:true, menuDisabled:true,dataIndex: 'co_padre'},
    {header: 'Descripción', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_nom_estructura_administrativa'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){EstructuraOrganizativaListaEstructura.main.editar.enable();EstructuraOrganizativaListaEstructura.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorEstructuraOrganizativaListaEstructura");


this.store_lista.load();

}
,
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/storelista',
    root:'data',
    fields:[
    {name: 'co_estructura_administrativa'},
    {name: 'co_padre'},
    {name: 'tx_nom_estructura_administrativa'},
           ]
    });
    return this.store;
}
};
Ext.onReady(EstructuraOrganizativaListaEstructura.main.init, EstructuraOrganizativaListaEstructura.main);
</script>
<div id="contenedorEstructuraOrganizativaListaEstructura"></div>
<div id="formularioEstructuraOrganizativaListaEstructura"></div>
<div id="filtroEstructuraOrganizativaListaEstructura"></div>
