<script type="text/javascript">
Ext.ns("EstadoLista");
EstadoLista.main = {
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
        EstadoLista.main.mascara.show();
        this.msg = Ext.get('formularioEstado');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Estado/editar',
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
	this.codigo  = EstadoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_estado');
	EstadoLista.main.mascara.show();
        this.msg = Ext.get('formularioEstado');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Estado/editar/codigo/'+this.codigo,
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
	this.codigo  = EstadoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_estado');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Estado/eliminar',
            params:{
                co_estado:EstadoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_estado')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    EstadoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                EstadoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroEstado');
        EstadoLista.main.mascara.show();
        EstadoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Estado/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Estados',
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
    {header: 'co_estado',hidden:true, menuDisabled:true,dataIndex: 'co_estado'},
    {header: 'Estado', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'nb_estado'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){EstadoLista.main.editar.enable();EstadoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorEstadoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Estado/storelista',
    root:'data',
    fields:[
    {name: 'co_estado'},
    {name: 'nb_estado'},
           ]
    });
    return this.store;
}
};
Ext.onReady(EstadoLista.main.init, EstadoLista.main);
</script>
<div id="contenedorEstadoLista"></div>
<div id="formularioEstado"></div>
<div id="filtroEstado"></div>
