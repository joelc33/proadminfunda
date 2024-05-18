<script type="text/javascript">
Ext.ns("inicioLista");
inicioLista.main = {
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
        inicioLista.main.mascara.show();
        this.msg = Ext.get('formularioinicio');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/inicio/editar',
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
	this.codigo  = inicioLista.main.gridPanel_.getSelectionModel().getSelected().get('co_menu');
	inicioLista.main.mascara.show();
        this.msg = Ext.get('formularioinicio');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/inicio/editar/codigo/'+this.codigo,
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
	this.codigo  = inicioLista.main.gridPanel_.getSelectionModel().getSelected().get('co_menu');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/inicio/eliminar',
            params:{
                co_menu:inicioLista.main.gridPanel_.getSelectionModel().getSelected().get('co_menu')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    inicioLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                inicioLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroinicio');
        inicioLista.main.mascara.show();
        inicioLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/inicio/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de inicio',
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
    {header: 'co_menu',hidden:true, menuDisabled:true,dataIndex: 'co_menu'},
    {header: 'Tx menu', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_menu'},
    {header: 'Co padre', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_padre'},
    {header: 'Tx href', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_href'},
    {header: 'Nu orden', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_orden'},
    {header: 'Tx icono', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_icono'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){inicioLista.main.editar.enable();inicioLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorinicioLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/inicio/storelista',
    root:'data',
    fields:[
    {name: 'co_menu'},
    {name: 'tx_menu'},
    {name: 'co_padre'},
    {name: 'tx_href'},
    {name: 'nu_orden'},
    {name: 'tx_icono'},
           ]
    });
    return this.store;
}
};
Ext.onReady(inicioLista.main.init, inicioLista.main);
</script>
<div id="contenedorinicioLista"></div>
<div id="formularioinicio"></div>
<div id="filtroinicio"></div>
