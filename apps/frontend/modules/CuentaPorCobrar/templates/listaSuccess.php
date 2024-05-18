<script type="text/javascript">
Ext.ns("CuentaPorCobrarLista");
CuentaPorCobrarLista.main = {
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
        CuentaPorCobrarLista.main.mascara.show();
        this.msg = Ext.get('formularioCuentaPorCobrar');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrar/editar',
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
	this.codigo  = CuentaPorCobrarLista.main.gridPanel_.getSelectionModel().getSelected().get('co_cuenta_por_cobrar');
	CuentaPorCobrarLista.main.mascara.show();
        this.msg = Ext.get('formularioCuentaPorCobrar');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrar/editar/codigo/'+this.codigo,
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
	this.codigo  = CuentaPorCobrarLista.main.gridPanel_.getSelectionModel().getSelected().get('co_cuenta_por_cobrar');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrar/eliminar',
            params:{
                co_cuenta_por_cobrar:CuentaPorCobrarLista.main.gridPanel_.getSelectionModel().getSelected().get('co_cuenta_por_cobrar')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    CuentaPorCobrarLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                CuentaPorCobrarLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroCuentaPorCobrar');
        CuentaPorCobrarLista.main.mascara.show();
        CuentaPorCobrarLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrar/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de CuentaPorCobrar',
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
    {header: 'co_cuenta_por_cobrar',hidden:true, menuDisabled:true,dataIndex: 'co_cuenta_por_cobrar'},
    {header: 'Co fuente ingreso', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_fuente_ingreso'},
    {header: 'Tx referencia', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_referencia'},
    {header: 'Mo ingreso', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_ingreso'},
    {header: 'Tx descripcion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_descripcion'},
    {header: 'Fe registro', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_registro'},
    {header: 'Co solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
    {header: 'Co banco', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_banco'},
    {header: 'Co cuenta bancaria', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_cuenta_bancaria'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    {header: 'Co usuario', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_usuario'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){CuentaPorCobrarLista.main.editar.enable();CuentaPorCobrarLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorCuentaPorCobrarLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrar/storelista',
    root:'data',
    fields:[
    {name: 'co_cuenta_por_cobrar'},
    {name: 'co_fuente_ingreso'},
    {name: 'tx_referencia'},
    {name: 'mo_ingreso'},
    {name: 'tx_descripcion'},
    {name: 'fe_registro'},
    {name: 'co_solicitud'},
    {name: 'co_banco'},
    {name: 'co_cuenta_bancaria'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'co_usuario'},
           ]
    });
    return this.store;
}
};
Ext.onReady(CuentaPorCobrarLista.main.init, CuentaPorCobrarLista.main);
</script>
<div id="contenedorCuentaPorCobrarLista"></div>
<div id="formularioCuentaPorCobrar"></div>
<div id="filtroCuentaPorCobrar"></div>
