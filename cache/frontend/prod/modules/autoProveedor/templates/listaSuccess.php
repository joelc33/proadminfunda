<script type="text/javascript">
Ext.ns("ProveedorLista");
ProveedorLista.main = {
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
        ProveedorLista.main.mascara.show();
        this.msg = Ext.get('formularioProveedor');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/editar',
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
	this.codigo  = ProveedorLista.main.gridPanel_.getSelectionModel().getSelected().get('co_proveedor');
	ProveedorLista.main.mascara.show();
        this.msg = Ext.get('formularioProveedor');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/editar/codigo/'+this.codigo,
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
	this.codigo  = ProveedorLista.main.gridPanel_.getSelectionModel().getSelected().get('co_proveedor');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/eliminar',
            params:{
                co_proveedor:ProveedorLista.main.gridPanel_.getSelectionModel().getSelected().get('co_proveedor')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ProveedorLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ProveedorLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroProveedor');
        ProveedorLista.main.mascara.show();
        ProveedorLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Proveedor',
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
    {header: 'co_proveedor',hidden:true, menuDisabled:true,dataIndex: 'co_proveedor'},
    {header: 'Tx razon social', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_razon_social'},
    {header: 'Co documento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_documento'},
    {header: 'Tx siglas', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_siglas'},
    {header: 'Tx rif', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_rif'},
    {header: 'Tx nit', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_nit'},
    {header: 'Tx direccion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_direccion'},
    {header: 'Co estado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_estado'},
    {header: 'Co municipio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_municipio'},
    {header: 'Co clasificacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_clasificacion'},
    {header: 'Tx email', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_email'},
    {header: 'Tx sitio web', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_sitio_web'},
    {header: 'Nb representante legal', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nb_representante_legal'},
    {header: 'Nu cedula representante', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cedula_representante'},
    {header: 'Tx num celular', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_num_celular'},
    {header: 'Nu dia credito', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_dia_credito'},
    {header: 'Fe registro', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_registro'},
    {header: 'Co cuenta contable', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_cuenta_contable'},
    {header: 'Fe vencimiento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_vencimiento'},
    {header: 'Nu cuenta bancaria', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cuenta_bancaria'},
    {header: 'Co banco', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_banco'},
    {header: 'Co tipo residencia', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_residencia'},
    {header: 'Co tipo proveedor', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_proveedor'},
    {header: 'Co tipo retencion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_retencion'},
    {header: 'Tx registro', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_registro'},
    {header: 'Fe registro seniat', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_registro_seniat'},
    {header: 'Nu registro', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_registro'},
    {header: 'Nu tomo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_tomo'},
    {header: 'Nu capital suscrito', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_capital_suscrito'},
    {header: 'Nu capital pagado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_capital_pagado'},
    {header: 'Tx observacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_observacion'},
    {header: 'Co iva retencion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_iva_retencion'},
    {header: 'Tx cuenta contable', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cuenta_contable'},
    {header: 'Nu codigo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_codigo'},
    {header: 'In rrhh', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_rrhh'},
    {header: 'Co cuenta orden pasivo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_cuenta_orden_pasivo'},
    {header: 'Co cuenta orden activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_cuenta_orden_activo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ProveedorLista.main.editar.enable();ProveedorLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorProveedorLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storelista',
    root:'data',
    fields:[
    {name: 'co_proveedor'},
    {name: 'tx_razon_social'},
    {name: 'co_documento'},
    {name: 'tx_siglas'},
    {name: 'tx_rif'},
    {name: 'tx_nit'},
    {name: 'tx_direccion'},
    {name: 'co_estado'},
    {name: 'co_municipio'},
    {name: 'co_clasificacion'},
    {name: 'tx_email'},
    {name: 'tx_sitio_web'},
    {name: 'nb_representante_legal'},
    {name: 'nu_cedula_representante'},
    {name: 'tx_num_celular'},
    {name: 'nu_dia_credito'},
    {name: 'fe_registro'},
    {name: 'co_cuenta_contable'},
    {name: 'fe_vencimiento'},
    {name: 'nu_cuenta_bancaria'},
    {name: 'co_banco'},
    {name: 'co_tipo_residencia'},
    {name: 'co_tipo_proveedor'},
    {name: 'co_tipo_retencion'},
    {name: 'tx_registro'},
    {name: 'fe_registro_seniat'},
    {name: 'nu_registro'},
    {name: 'nu_tomo'},
    {name: 'nu_capital_suscrito'},
    {name: 'nu_capital_pagado'},
    {name: 'tx_observacion'},
    {name: 'co_iva_retencion'},
    {name: 'tx_cuenta_contable'},
    {name: 'nu_codigo'},
    {name: 'in_rrhh'},
    {name: 'co_cuenta_orden_pasivo'},
    {name: 'co_cuenta_orden_activo'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ProveedorLista.main.init, ProveedorLista.main);
</script>
<div id="contenedorProveedorLista"></div>
<div id="formularioProveedor"></div>
<div id="filtroProveedor"></div>
