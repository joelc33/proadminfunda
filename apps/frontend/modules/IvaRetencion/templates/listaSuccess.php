<script type="text/javascript">
Ext.ns("IvaRetencionLista");
IvaRetencionLista.main = {
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
        IvaRetencionLista.main.mascara.show();
        this.msg = Ext.get('formularioIvaRetencion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IvaRetencion/editar',
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
	this.codigo  = IvaRetencionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_iva_retencion');
	IvaRetencionLista.main.mascara.show();
        this.msg = Ext.get('formularioIvaRetencion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IvaRetencion/editar/codigo/'+this.codigo,
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
	this.codigo  = IvaRetencionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_iva_retencion');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IvaRetencion/eliminar',
            params:{
                co_iva_retencion:IvaRetencionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_iva_retencion')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    IvaRetencionLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                IvaRetencionLista.main.mascara.hide();
            }});
	}});
    }
});

this.add_cuenta = new Ext.Button({
    text:'Agregar Cuenta Contable',
    iconCls: 'icon-nuevo',
    handler:function(){
        IvaRetencionLista.main.mascara.show();
        this.msg = Ext.get('formularioIvaRetencion');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IvaRetencion/planDeCuenta',
         scripts: true,
         text: "Cargando..",
         params:{
             co_iva_retencion:IvaRetencionLista.main.gridPanel_.getSelectionModel().getSelected().get('co_iva_retencion')
         }
        });
    }
});

this.editar.disable();
this.eliminar.disable();
//this.add_cuenta.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de IvaRetencion',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.add_cuenta
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_iva_retencion',hidden:true, menuDisabled:true,dataIndex: 'co_iva_retencion'},
    {header: 'Valor', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_valor'},
    {header: 'Cuenta Contable', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cuenta'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        IvaRetencionLista.main.editar.enable();
        IvaRetencionLista.main.eliminar.enable();
       // IvaRetencionLista.main.add_cuenta.enable();
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorIvaRetencionLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IvaRetencion/storelista',
    root:'data',
    fields:[
                {name: 'co_iva_retencion'},
                {name: 'nu_valor'},
                {name: 'tx_cuenta'},
           ]
    });
    return this.store;
}
};
Ext.onReady(IvaRetencionLista.main.init, IvaRetencionLista.main);
</script>
<div id="contenedorIvaRetencionLista"></div>
<div id="formularioIvaRetencion"></div>
<div id="filtroIvaRetencion"></div>
