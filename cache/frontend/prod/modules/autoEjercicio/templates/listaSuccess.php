<script type="text/javascript">
Ext.ns("ejercicioLista");
ejercicioLista.main = {
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
        ejercicioLista.main.mascara.show();
        this.msg = Ext.get('formularioejercicio');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ejercicio/editar',
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
	this.codigo  = ejercicioLista.main.gridPanel_.getSelectionModel().getSelected().get('co_anio_fiscal');
	ejercicioLista.main.mascara.show();
        this.msg = Ext.get('formularioejercicio');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ejercicio/editar/codigo/'+this.codigo,
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
	this.codigo  = ejercicioLista.main.gridPanel_.getSelectionModel().getSelected().get('co_anio_fiscal');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ejercicio/eliminar',
            params:{
                co_anio_fiscal:ejercicioLista.main.gridPanel_.getSelectionModel().getSelected().get('co_anio_fiscal')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ejercicioLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ejercicioLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroejercicio');
        ejercicioLista.main.mascara.show();
        ejercicioLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ejercicio/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de ejercicio',
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
    {header: 'co_anio_fiscal',hidden:true, menuDisabled:true,dataIndex: 'co_anio_fiscal'},
    {header: 'Tx anio fiscal', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_anio_fiscal'},
    {header: 'Fe apertura', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_apertura'},
    {header: 'Co usuario', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_usuario'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Fe cierre', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_cierre'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ejercicioLista.main.editar.enable();ejercicioLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorejercicioLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ejercicio/storelista',
    root:'data',
    fields:[
    {name: 'co_anio_fiscal'},
    {name: 'tx_anio_fiscal'},
    {name: 'fe_apertura'},
    {name: 'co_usuario'},
    {name: 'in_activo'},
    {name: 'fe_cierre'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ejercicioLista.main.init, ejercicioLista.main);
</script>
<div id="contenedorejercicioLista"></div>
<div id="formularioejercicio"></div>
<div id="filtroejercicio"></div>
