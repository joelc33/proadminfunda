<script type="text/javascript">
Ext.ns("ProveedorLista");
ProveedorLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
    
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});
 
//objeto store
this.store_lista = this.getLista();

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'co_documento',
	//readOnly:(this.OBJ.co_documento!='')?true:false,
	//style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:50,
	resizable:true,
	allowBlank:false
});
this.storeCO_DOCUMENTO.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_documento,
	value:  4,
	objStore: this.storeCO_DOCUMENTO
});

this.tx_rif = new Ext.form.TextField({
	name:'tx_rif',
	allowBlank:false,
	width:130
});


this.compositefieldCIRIF = new Ext.form.CompositeField({
fieldLabel: 'RIF',
width:300,
items: [
	this.co_documento,
	this.tx_rif,
	]
});

this.tx_razon_social = new Ext.form.TextField({
	fieldLabel:'Razon Social',
	name:'tx_razon_social',
	allowBlank:false,
	width:600
});

this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Buscar Proveedor',
    iconCls: 'icon-electores',
    collapsible: true,
    titleCollapse: true,
    autoWidth:true,
    border:false,
   // labelWidth: 110,
    padding:'10px',
    items   : [
      this.compositefieldCIRIF,
      this.tx_razon_social
    ],
    keys: [{
		key:[Ext.EventObject.ENTER],
		handler: function() {
			ProveedorLista.main.aplicarFiltroByFormulario();
		}}
    ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                ProveedorLista.main.aplicarFiltroByFormulario();
            }
        },
        {
            text:'Limpiar',
            iconCls:'icon-limpiar',
            handler:function(){
                ProveedorLista.main.limpiarCamposByFormFiltro();
            }
        }
    ]
});


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
        this.nuevo,'-',this.editar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'co_proveedor',hidden:true, menuDisabled:true,dataIndex: 'co_proveedor'},
        {header: 'RIF', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_rif'},        
        {header: 'Razon Social', width:350,  menuDisabled:true, sortable: true,  dataIndex: 'tx_razon_social'},
        {header: 'Siglas', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_siglas'}
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

this.formFiltroPrincipal.render("filtroProveedor");
this.gridPanel_.render("contenedorProveedorLista");


this.store_lista.load();
},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = ProveedorLista.main.formFiltroPrincipal.getForm().getValues();

	ProveedorLista.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" ProveedorLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    ProveedorLista.main.store_lista.baseParams.BuscarBy = true;
	    ProveedorLista.main.store_lista.load();
	}else{
	    ProveedorLista.main.formFiltroPrincipal.getForm().reset();
            ProveedorLista.main.store_lista.baseParams={};
            ProveedorLista.main.store_lista.load();
	}

	},
	limpiarCamposByFormFiltro: function(){
	ProveedorLista.main.formFiltroPrincipal.getForm().reset();
	ProveedorLista.main.store_lista.baseParams={};
	ProveedorLista.main.store_lista.load();
        
}
,getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'},
            {name: 'inicial'}
            ]
    });
    return this.store;
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
           ]
    });
    return this.store;
}
};
Ext.onReady(ProveedorLista.main.init, ProveedorLista.main);
</script>
<div id="filtroProveedor"></div>
<div id="contenedorProveedorLista"></div>
<div id="formularioProveedor"></div>

