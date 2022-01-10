<script type="text/javascript">
Ext.ns("ModeloLista");
ModeloLista.main = {
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
        ModeloLista.main.mascara.show();
        this.msg = Ext.get('formularioModelo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modelo/editar',
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
	this.codigo  = ModeloLista.main.gridPanel_.getSelectionModel().getSelected().get('co_modelo');
	ModeloLista.main.mascara.show();
        this.msg = Ext.get('formularioModelo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modelo/editar/codigo/'+this.codigo,
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
	this.codigo  = ModeloLista.main.gridPanel_.getSelectionModel().getSelected().get('co_modelo');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modelo/eliminar',
            params:{
                co_modelo:ModeloLista.main.gridPanel_.getSelectionModel().getSelected().get('co_modelo')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ModeloLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ModeloLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroModelo');
        ModeloLista.main.mascara.show();
        ModeloLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modelo/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Modelos',
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
    {header: 'co_modelo',hidden:true, menuDisabled:true,dataIndex: 'co_modelo'},
    {header: 'Modelos', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'tx_modelo'},
    {header: 'Marcas', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'tx_marca'},
    //{header: 'Familia Producto', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb093_familia_producto'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ModeloLista.main.editar.enable();ModeloLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorModeloLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modelo/storelista',
    root:'data',
    fields:[
    {name: 'co_modelo'},
    {name: 'co_marca'},
    {name: 'tx_marca'},
    {name: 'tx_modelo'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'}
           ]
    });
    return this.store;
}
};
Ext.onReady(ModeloLista.main.init, ModeloLista.main);
</script>
<div id="contenedorModeloLista"></div>
<div id="formularioModelo"></div>
<div id="filtroModelo"></div>
