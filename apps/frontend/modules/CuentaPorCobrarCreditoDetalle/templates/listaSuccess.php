<script type="text/javascript">
Ext.ns("CuentaPorCobrarCreditoDetalleLista");
CuentaPorCobrarCreditoDetalleLista.main = {
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
        CuentaPorCobrarCreditoDetalleLista.main.mascara.show();
        this.msg = Ext.get('formularioCuentaPorCobrarCreditoDetalle');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCreditoDetalle/editar',
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
	this.codigo  = CuentaPorCobrarCreditoDetalleLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	CuentaPorCobrarCreditoDetalleLista.main.mascara.show();
        this.msg = Ext.get('formularioCuentaPorCobrarCreditoDetalle');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCreditoDetalle/editar/codigo/'+this.codigo,
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
	this.codigo  = CuentaPorCobrarCreditoDetalleLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCreditoDetalle/eliminar',
            params:{
                id:CuentaPorCobrarCreditoDetalleLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    CuentaPorCobrarCreditoDetalleLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                CuentaPorCobrarCreditoDetalleLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroCuentaPorCobrarCreditoDetalle');
        CuentaPorCobrarCreditoDetalleLista.main.mascara.show();
        CuentaPorCobrarCreditoDetalleLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCreditoDetalle/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de CuentaPorCobrarCreditoDetalle',
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
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Id tb142 cuenta cobrar', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb142_cuenta_cobrar'},
    {header: 'De cuota', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_cuota'},
    {header: 'Mo cuota', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_cuota'},
    {header: 'Fe creacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_creacion'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){CuentaPorCobrarCreditoDetalleLista.main.editar.enable();CuentaPorCobrarCreditoDetalleLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorCuentaPorCobrarCreditoDetalleLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCreditoDetalle/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'id_tb142_cuenta_cobrar'},
    {name: 'de_cuota'},
    {name: 'mo_cuota'},
    {name: 'fe_creacion'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(CuentaPorCobrarCreditoDetalleLista.main.init, CuentaPorCobrarCreditoDetalleLista.main);
</script>
<div id="contenedorCuentaPorCobrarCreditoDetalleLista"></div>
<div id="formularioCuentaPorCobrarCreditoDetalle"></div>
<div id="filtroCuentaPorCobrarCreditoDetalle"></div>
