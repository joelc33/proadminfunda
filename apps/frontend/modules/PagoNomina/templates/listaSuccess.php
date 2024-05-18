<script type="text/javascript">
Ext.ns("PagoNominaLista");
PagoNominaLista.main = {
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
        PagoNominaLista.main.mascara.show();
        this.msg = Ext.get('formularioPagoNomina');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/editar',
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
	this.codigo  = PagoNominaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_pago_nomina');
	PagoNominaLista.main.mascara.show();
        this.msg = Ext.get('formularioPagoNomina');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/editar/codigo/'+this.codigo,
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
	this.codigo  = PagoNominaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_pago_nomina');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/eliminar',
            params:{
                co_pago_nomina:PagoNominaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_pago_nomina')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    PagoNominaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                PagoNominaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPagoNomina');
        PagoNominaLista.main.mascara.show();
        PagoNominaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de PagoNomina',
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
    {header: 'co_pago_nomina',hidden:true, menuDisabled:true,dataIndex: 'co_pago_nomina'},
    {header: 'Co tipo trabajador', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_trabajador'},
    {header: 'Co tipo nomina', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_nomina'},
    {header: 'Tx concepto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_concepto'},
    {header: 'Fe pago', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_pago'},
    {header: 'Co solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
    {header: 'Co usuario', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_usuario'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){PagoNominaLista.main.editar.enable();PagoNominaLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorPagoNominaLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storelista',
    root:'data',
    fields:[
    {name: 'co_pago_nomina'},
    {name: 'co_tipo_trabajador'},
    {name: 'co_tipo_nomina'},
    {name: 'tx_concepto'},
    {name: 'fe_pago'},
    {name: 'co_solicitud'},
    {name: 'co_usuario'},
    {name: 'created_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(PagoNominaLista.main.init, PagoNominaLista.main);
</script>
<div id="contenedorPagoNominaLista"></div>
<div id="formularioPagoNomina"></div>
<div id="filtroPagoNomina"></div>
