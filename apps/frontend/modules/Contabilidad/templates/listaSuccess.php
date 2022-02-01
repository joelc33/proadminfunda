<script type="text/javascript">
Ext.ns("ContabilidadLista");
ContabilidadLista.main = {
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
        ContabilidadLista.main.mascara.show();
        this.msg = Ext.get('formularioContabilidad');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/editar',
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
	this.codigo  = ContabilidadLista.main.gridPanel_.getSelectionModel().getSelected().get('co_contabilidad');
	ContabilidadLista.main.mascara.show();
        this.msg = Ext.get('formularioContabilidad');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/editar/codigo/'+this.codigo,
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
	this.codigo  = ContabilidadLista.main.gridPanel_.getSelectionModel().getSelected().get('co_contabilidad');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/eliminar',
            params:{
                co_contabilidad:ContabilidadLista.main.gridPanel_.getSelectionModel().getSelected().get('co_contabilidad')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ContabilidadLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ContabilidadLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroContabilidad');
        ContabilidadLista.main.mascara.show();
        ContabilidadLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Contabilidad',
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
    {header: 'co_contabilidad',hidden:true, menuDisabled:true,dataIndex: 'co_contabilidad'},
    {header: 'Co compra', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_compra'},
    {header: 'Co solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
    {header: 'Co ramo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_ramo'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Co anio fiscal', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_anio_fiscal'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ContabilidadLista.main.editar.enable();ContabilidadLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorContabilidadLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/storelista',
    root:'data',
    fields:[
    {name: 'co_contabilidad'},
    {name: 'co_compra'},
    {name: 'co_solicitud'},
    {name: 'co_ramo'},
    {name: 'created_at'},
    {name: 'co_anio_fiscal'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ContabilidadLista.main.init, ContabilidadLista.main);
</script>
<div id="contenedorContabilidadLista"></div>
<div id="formularioContabilidad"></div>
<div id="filtroContabilidad"></div>
