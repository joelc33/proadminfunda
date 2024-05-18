<script type="text/javascript">
Ext.ns("TipoRetencionLista");
TipoRetencionLista.main = {
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
        TipoRetencionLista.main.mascara.show();
        this.msg = Ext.get('formularioTipoRetencion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/editar',
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
	this.codigo  = TipoRetencionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tipo_retencion');
	TipoRetencionLista.main.mascara.show();
        this.msg = Ext.get('formularioTipoRetencion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/editar/codigo/'+this.codigo,
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
	this.codigo  = TipoRetencionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tipo_retencion');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/eliminar',
            params:{
                co_tipo_retencion:TipoRetencionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_tipo_retencion')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    TipoRetencionLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                TipoRetencionLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroTipoRetencion');
        TipoRetencionLista.main.mascara.show();
        TipoRetencionLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de TipoRetencion',
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
    {header: 'co_tipo_retencion',hidden:true, menuDisabled:true,dataIndex: 'co_tipo_retencion'},
    {header: 'Tx tipo retencion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo_retencion'},
    {header: 'Co cuenta contable', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_cuenta_contable'},
    {header: 'Co clase retencion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_clase_retencion'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Nu cuenta pagar', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cuenta_pagar'},
    {header: 'Nu cuenta tercero', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cuenta_tercero'},
    {header: 'Co cuenta tercero', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_cuenta_tercero'},
    {header: 'Tx movimiento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_movimiento'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){TipoRetencionLista.main.editar.enable();TipoRetencionLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorTipoRetencionLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/storelista',
    root:'data',
    fields:[
    {name: 'co_tipo_retencion'},
    {name: 'tx_tipo_retencion'},
    {name: 'co_cuenta_contable'},
    {name: 'co_clase_retencion'},
    {name: 'in_activo'},
    {name: 'nu_cuenta_pagar'},
    {name: 'nu_cuenta_tercero'},
    {name: 'co_cuenta_tercero'},
    {name: 'tx_movimiento'},
           ]
    });
    return this.store;
}
};
Ext.onReady(TipoRetencionLista.main.init, TipoRetencionLista.main);
</script>
<div id="contenedorTipoRetencionLista"></div>
<div id="formularioTipoRetencion"></div>
<div id="filtroTipoRetencion"></div>
