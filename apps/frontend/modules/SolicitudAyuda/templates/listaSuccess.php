<script type="text/javascript">
Ext.ns("SolicitudAyudaLista");
SolicitudAyudaLista.main = {
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
        SolicitudAyudaLista.main.mascara.show();
        this.msg = Ext.get('formularioSolicitudAyuda');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/editar',
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
	this.codigo  = SolicitudAyudaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_solicitud_ayuda');
	SolicitudAyudaLista.main.mascara.show();
        this.msg = Ext.get('formularioSolicitudAyuda');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/editar/codigo/'+this.codigo,
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
	this.codigo  = SolicitudAyudaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_solicitud_ayuda');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/eliminar',
            params:{
                co_solicitud_ayuda:SolicitudAyudaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_solicitud_ayuda')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    SolicitudAyudaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                SolicitudAyudaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroSolicitudAyuda');
        SolicitudAyudaLista.main.mascara.show();
        SolicitudAyudaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de SolicitudAyuda',
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
    {header: 'co_solicitud_ayuda',hidden:true, menuDisabled:true,dataIndex: 'co_solicitud_ayuda'},
    {header: 'Co persona', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_persona'},
    {header: 'Co tipo ayuda', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_ayuda'},
    {header: 'Tx observacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_observacion'},
    {header: 'Co solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
    {header: 'Co usuario', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_usuario'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){SolicitudAyudaLista.main.editar.enable();SolicitudAyudaLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorSolicitudAyudaLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/storelista',
    root:'data',
    fields:[
    {name: 'co_solicitud_ayuda'},
    {name: 'co_persona'},
    {name: 'co_tipo_ayuda'},
    {name: 'tx_observacion'},
    {name: 'co_solicitud'},
    {name: 'co_usuario'},
    {name: 'created_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(SolicitudAyudaLista.main.init, SolicitudAyudaLista.main);
</script>
<div id="contenedorSolicitudAyudaLista"></div>
<div id="formularioSolicitudAyuda"></div>
<div id="filtroSolicitudAyuda"></div>
