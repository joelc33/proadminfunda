<script type="text/javascript">
Ext.ns("ViaticoLista");
ViaticoLista.main = {
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
        ViaticoLista.main.mascara.show();
        this.msg = Ext.get('formularioViatico');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/editar',
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
	this.codigo  = ViaticoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_viatico');
	ViaticoLista.main.mascara.show();
        this.msg = Ext.get('formularioViatico');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/editar/codigo/'+this.codigo,
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
	this.codigo  = ViaticoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_viatico');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/eliminar',
            params:{
                co_viatico:ViaticoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_viatico')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ViaticoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ViaticoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroViatico');
        ViaticoLista.main.mascara.show();
        ViaticoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Viatico',
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
    {header: 'co_viatico',hidden:true, menuDisabled:true,dataIndex: 'co_viatico'},
    {header: 'Co tipo viatico', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_viatico'},
    {header: 'Tx evento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_evento'},
    {header: 'Tx direccion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_direccion'},
    {header: 'In empleado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_empleado'},
    {header: 'Co origen', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_origen'},
    {header: 'Co destino', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_destino'},
    {header: 'Fe desde', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_desde'},
    {header: 'Fe hasta', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_hasta'},
    {header: 'In hospedaje', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_hospedaje'},
    {header: 'Tx observacion hospedaje', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_observacion_hospedaje'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ViaticoLista.main.editar.enable();ViaticoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorViaticoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/storelista',
    root:'data',
    fields:[
    {name: 'co_viatico'},
    {name: 'co_tipo_viatico'},
    {name: 'tx_evento'},
    {name: 'tx_direccion'},
    {name: 'in_empleado'},
    {name: 'co_origen'},
    {name: 'co_destino'},
    {name: 'fe_desde'},
    {name: 'fe_hasta'},
    {name: 'in_hospedaje'},
    {name: 'tx_observacion_hospedaje'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ViaticoLista.main.init, ViaticoLista.main);
</script>
<div id="contenedorViaticoLista"></div>
<div id="formularioViatico"></div>
<div id="filtroViatico"></div>
