<script type="text/javascript">
Ext.ns("ProcesoLista");
ProcesoLista.main = {
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
        ProcesoLista.main.mascara.show();
        this.msg = Ext.get('formularioProceso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proceso/editar',
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
	this.codigo  = ProcesoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_proceso');
	ProcesoLista.main.mascara.show();
        this.msg = Ext.get('formularioProceso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proceso/editar/codigo/'+this.codigo,
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
	this.codigo  = ProcesoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_proceso');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proceso/eliminar',
            params:{
                co_proceso:ProcesoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_proceso')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ProcesoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ProcesoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroProceso');
        ProcesoLista.main.mascara.show();
        ProcesoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proceso/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Proceso',
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
    {header: 'co_proceso',hidden:true, menuDisabled:true,dataIndex: 'co_proceso'},
    {header: 'Proceso', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_proceso'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ProcesoLista.main.editar.enable();ProcesoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorProcesoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proceso/storelista',
    root:'data',
    fields:[
    {name: 'co_proceso'},
    {name: 'tx_proceso'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ProcesoLista.main.init, ProcesoLista.main);
</script>
<div id="contenedorProcesoLista"></div>
<div id="formularioProceso"></div>
<div id="filtroProceso"></div>
