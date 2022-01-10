<script type="text/javascript">
Ext.ns("TesoreriaIngresoPagoLista");
TesoreriaIngresoPagoLista.main = {
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
        TesoreriaIngresoPagoLista.main.mascara.show();
        this.msg = Ext.get('formularioTesoreriaIngresoPago');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngresoPago/editar',
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
	this.codigo  = TesoreriaIngresoPagoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	TesoreriaIngresoPagoLista.main.mascara.show();
        this.msg = Ext.get('formularioTesoreriaIngresoPago');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngresoPago/editar/codigo/'+this.codigo,
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
	this.codigo  = TesoreriaIngresoPagoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngresoPago/eliminar',
            params:{
                id:TesoreriaIngresoPagoLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    TesoreriaIngresoPagoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                TesoreriaIngresoPagoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroTesoreriaIngresoPago');
        TesoreriaIngresoPagoLista.main.mascara.show();
        TesoreriaIngresoPagoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngresoPago/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de TesoreriaIngresoPago',
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
    {header: 'Id tb145 cuenta cobrar detalle', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb145_cuenta_cobrar_detalle'},
    {header: 'Mo pago', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_pago'},
    {header: 'Id tb074 forma pago', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb074_forma_pago'},
    {header: 'Id tb010 banco', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb010_banco'},
    {header: 'Id tb011 cuenta bancaria', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb011_cuenta_bancaria'},
    {header: 'Fe ingreso', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_ingreso'},
    {header: 'Fe registro', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_registro'},
    {header: 'Id tb147 tipo documento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb147_tipo_documento'},
    {header: 'De orden ingreso', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_orden_ingreso'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){TesoreriaIngresoPagoLista.main.editar.enable();TesoreriaIngresoPagoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorTesoreriaIngresoPagoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngresoPago/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'id_tb145_cuenta_cobrar_detalle'},
    {name: 'mo_pago'},
    {name: 'id_tb074_forma_pago'},
    {name: 'id_tb010_banco'},
    {name: 'id_tb011_cuenta_bancaria'},
    {name: 'fe_ingreso'},
    {name: 'fe_registro'},
    {name: 'id_tb147_tipo_documento'},
    {name: 'de_orden_ingreso'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(TesoreriaIngresoPagoLista.main.init, TesoreriaIngresoPagoLista.main);
</script>
<div id="contenedorTesoreriaIngresoPagoLista"></div>
<div id="formularioTesoreriaIngresoPago"></div>
<div id="filtroTesoreriaIngresoPago"></div>
