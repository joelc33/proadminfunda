<script type="text/javascript">
Ext.ns("TesoreriaIngresoLista");
TesoreriaIngresoLista.main = {
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
        TesoreriaIngresoLista.main.mascara.show();
        this.msg = Ext.get('formularioTesoreriaIngreso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/editar',
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
	this.codigo  = TesoreriaIngresoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	TesoreriaIngresoLista.main.mascara.show();
        this.msg = Ext.get('formularioTesoreriaIngreso');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/editar/codigo/'+this.codigo,
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
	this.codigo  = TesoreriaIngresoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/eliminar',
            params:{
                id:TesoreriaIngresoLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    TesoreriaIngresoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                TesoreriaIngresoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroTesoreriaIngreso');
        TesoreriaIngresoLista.main.mascara.show();
        TesoreriaIngresoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de TesoreriaIngreso',
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
    {header: 'Co solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
    {header: 'Co usuario', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_usuario'},
    {header: 'Co proveedor', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_proveedor'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    {header: 'De soporte', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_soporte'},
    {header: 'Id tb143 cuenta concepto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb143_cuenta_concepto'},
    {header: 'Id tb144 clase ingreso', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb144_clase_ingreso'},
    {header: 'De descripcion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_descripcion'},
    {header: 'Mo cuenta', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_cuenta'},
    {header: 'Fe documento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_documento'},
    {header: 'Id tb141 tipo cuota', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb141_tipo_cuota'},
    {header: 'Co solicitud anular', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud_anular'},
    {header: 'In anular', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_anular'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){TesoreriaIngresoLista.main.editar.enable();TesoreriaIngresoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorTesoreriaIngresoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'co_solicitud'},
    {name: 'co_usuario'},
    {name: 'co_proveedor'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'de_soporte'},
    {name: 'id_tb143_cuenta_concepto'},
    {name: 'id_tb144_clase_ingreso'},
    {name: 'de_descripcion'},
    {name: 'mo_cuenta'},
    {name: 'fe_documento'},
    {name: 'id_tb141_tipo_cuota'},
    {name: 'co_solicitud_anular'},
    {name: 'in_anular'},
           ]
    });
    return this.store;
}
};
Ext.onReady(TesoreriaIngresoLista.main.init, TesoreriaIngresoLista.main);
</script>
<div id="contenedorTesoreriaIngresoLista"></div>
<div id="formularioTesoreriaIngreso"></div>
<div id="filtroTesoreriaIngreso"></div>
