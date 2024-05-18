<script type="text/javascript">
Ext.ns("ProveedorEditar");
ProveedorEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
this.storeCO_CLASIFICACION = this.getStoreCO_CLASIFICACION();
this.storeCO_CUENTA_CONTABLE = this.getStoreCO_CUENTA_CONTABLE();
this.storeCO_BANCO = this.getStoreCO_BANCO();
this.storeCO_TIPO_RESIDENCIA = this.getStoreCO_TIPO_RESIDENCIA();
this.storeCO_TIPO_PROVEEDOR = this.getStoreCO_TIPO_PROVEEDOR();
this.storeCO_TIPO_RETENCION = this.getStoreCO_TIPO_RETENCION();
this.storeCO_ESTADO = this.getStoreCO_ESTADO();
this.storeCO_MUNICIPIO = this.getStoreCO_MUNICIPIO();
this.storeCO_IVA_RETENCION = this.getStoreCO_IVA_RETENCION();

this.store_lista                    = this.getLista();
this.store_lista_cuenta             = this.getListaCuenta();
this.store_lista_retenciones        = this.getListaRetencion();
this.store_lista_aporte_patronal    = this.getListaAporte();

this.RegistroRamo = Ext.data.Record.create([
                         {name: 'co_proveedor_ramo', type:'number'},
                         {name: 'co_ramo', type: 'number'},
                         {name: 'tx_tamo', type: 'string'}
                    ]);


this.RegistroCuentaBancaria = Ext.data.Record.create([                         
        {name: 'co_cuenta_proveedor', type:'number'},
        {name: 'co_banco', type:'number'},
        {name: 'tx_banco', type: 'string'},
        {name: 'tx_cuenta', type: 'string'},
        {name: 'co_cuenta_contable', type:'number'},
        {name: 'nu_cuenta_contable', type: 'string'}
]);

this.RegistroRetenciones = Ext.data.Record.create([                         
        {name: 'co_retencion_proveedor', type:'number'},
        {name: 'co_tipo_retencion', type:'number'},
        {name: 'tx_tipo_retencion', type: 'string'},
]);

this.RegistroAporte = Ext.data.Record.create([  
        {name: 'co_proveedor', type:'number'},
        {name: 'co_aporte_patronal', type:'number'},
        {name: 'tx_descripcion', type: 'string'},
]);

this.hiddenJsonRamo  = new Ext.form.Hidden({
        name:'json_ramo',
        value:''
});

this.hiddenJsonCuentaBancaria  = new Ext.form.Hidden({
        name:'json_cuenta',
        value:''
});

this.hiddenJsonRetenciones  = new Ext.form.Hidden({
        name:'json_retenciones',
        value:''
});

this.hiddenJsonAportePatronal  = new Ext.form.Hidden({
        name:'json_aporte_patronal',
        value:''
});

this.agregar = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/agregarRamo',
            scripts: true,
            text: "Cargando.."
        });
    }
});

this.botonEliminar = new Ext.Button({
                text:'Eliminar',
                iconCls: 'icon-eliminar',
                id:'eliminar',
                handler: function(boton){
                    ProveedorEditar.main.eliminar();
                }
});

this.botonEliminar.disable();


this.agregar_cuenta = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/agregarCuenta',
            scripts: true,
            text: "Cargando.."
        });
    }
});

this.agregar_retencion = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/agregarRetencion',
            scripts: true,
            text: "Cargando.."
        });
    }
});

this.botonEliminarRetencion = new Ext.Button({
                text:'Eliminar',
                iconCls: 'icon-eliminar',
                id:'eliminar',
                handler: function(boton){
                    ProveedorEditar.main.eliminarRetencion();
                }
});

this.botonEliminarContable = new Ext.Button({
                text:'Eliminar',
                iconCls: 'icon-eliminar',
                id:'eliminar',
                handler: function(boton){
                    ProveedorEditar.main.eliminarCuenta();
                }
});

this.botonEliminarContable.disable();

this.gridPanel = new Ext.grid.GridPanel({
        title:'Lista de Ramos del Proveedor',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:150,  
        width:710,
        tbar:[this.agregar,'-',this.botonEliminar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_ramo', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_ramo'},
            {header: 'Ramo',width:600, menuDisabled:true,dataIndex: 'tx_ramo'}
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
            ProveedorEditar.main.botonEliminar.enable();
        }}   
});

this.gridPanelCuenta = new Ext.grid.GridPanel({
        title:'Lista de Cuentas Bancarias',
        iconCls: 'icon-libro',
        store: this.store_lista_cuenta,
        loadMask:true,
        height:500,  
        width:770,
        tbar:[this.agregar_cuenta,'-',this.botonEliminarContable],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_ramo', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_cuenta_proveedor'},
            {header: 'Banco',width:250, menuDisabled:true,dataIndex: 'tx_banco'},
            {header: 'Cuenta Bancaria',width:250, menuDisabled:true,dataIndex: 'tx_cuenta'},
            {header: 'Cuenta Contable',width:230, menuDisabled:true,dataIndex: 'nu_cuenta_contable'}
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
            ProveedorEditar.main.botonEliminarContable.enable();
        }}   
});

this.botonEliminarRetencion.disable();
this.gridRetenciones = new Ext.grid.GridPanel({
        title:'Lista de Retenciones',
        iconCls: 'icon-libro',
        store: this.store_lista_retenciones,
        loadMask:true,
        height:500,  
        width:770,
        tbar:[this.agregar_retencion,'-',this.botonEliminarRetencion
        ],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_retencion_proveedor', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_retencion_proveedor'},
            {header: 'co_tipo_retencion', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_tipo_retencion'},
            {header: 'Tipo de Retencion',width:230, menuDisabled:true,dataIndex: 'tx_tipo_retencion'}
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
            ProveedorEditar.main.botonEliminarRetencion.enable();
        }}   
});

this.agregar_aporte = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/agregarAporte',
            scripts: true,
            text: "Cargando.."
        });
    }
});

this.botonEliminarAporte = new Ext.Button({
                text:'Eliminar',
                iconCls: 'icon-eliminar',
                handler: function(boton){
                    ProveedorEditar.main.eliminarAportePatronal();
                }
});

this.botonEliminarAporte.disable();

this.gridAportePatronal = new Ext.grid.GridPanel({
        title:'Lista de Aporte Patronal',
        iconCls: 'icon-libro',
        store: this.store_lista_aporte_patronal,
        loadMask:true,
        height:500,  
        width:770,
        tbar:[this.agregar_aporte,'-',this.botonEliminarAporte],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_aporte_social', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_aporte_patronal'},
            {header: 'Tipo de Aporte',width:330, menuDisabled:true,dataIndex: 'tx_descripcion'}
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
            ProveedorEditar.main.botonEliminarAporte.enable();
        }}   
});


if(this.OBJ.co_proveedor!=''){
    ProveedorEditar.main.store_lista.baseParams.co_proveedor= this.OBJ.co_proveedor;
    this.store_lista.load();
    
    ProveedorEditar.main.store_lista_cuenta.baseParams.co_proveedor= this.OBJ.co_proveedor;
    this.store_lista_cuenta.load();
    
    ProveedorEditar.main.store_lista_retenciones.baseParams.co_proveedor= this.OBJ.co_proveedor;
    this.store_lista_retenciones.load();
    
    ProveedorEditar.main.store_lista_aporte_patronal.baseParams.co_proveedor= this.OBJ.co_proveedor;
    this.store_lista_aporte_patronal.load();
}


//<ClavePrimaria>
this.co_proveedor = new Ext.form.Hidden({
    name:'co_proveedor',
    value:this.OBJ.co_proveedor});
//</ClavePrimaria>


this.tx_razon_social = new Ext.form.TextField({
	fieldLabel:'Razon Social',
	name:'tb008_proveedor[tx_razon_social]',
	value:this.OBJ.tx_razon_social,
	allowBlank:false,
	width:600
});

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'tb008_proveedor[co_documento]',
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
	value:  (this.OBJ.co_documento=='')?4:this.OBJ.co_documento,
	objStore: this.storeCO_DOCUMENTO
});

this.tx_rif = new Ext.form.TextField({
	name:'tb008_proveedor[tx_rif]',
	value:this.OBJ.tx_rif,
	allowBlank:false,
	width:130
});

this.tx_siglas = new Ext.form.TextField({
	fieldLabel:'Siglas',
	name:'tb008_proveedor[tx_siglas]',
	value:this.OBJ.tx_siglas,
	width:200
});



this.compositefieldCIRIF = new Ext.form.CompositeField({
fieldLabel: 'RIF',
width:300,
items: [
	this.co_documento,
	this.tx_rif,
	]
});

this.tx_nit = new Ext.form.TextField({
	fieldLabel:'NIT',
	name:'tb008_proveedor[tx_nit]',
	value:this.OBJ.tx_nit,
	width:200
});

this.tx_direccion = new Ext.form.TextField({
	fieldLabel:'Dirección',
	name:'tb008_proveedor[tx_direccion]',
	value:this.OBJ.tx_direccion,
	allowBlank:false,
	width:600
});

/*this.co_estado = new Ext.form.NumberField({
	fieldLabel:'Estado',
	name:'tb008_proveedor[co_estado]',
	value:this.OBJ.co_estado,
	allowBlank:false
});*/
    
this.co_estado = new Ext.form.ComboBox({
	fieldLabel:'Estado',
	store: this.storeCO_ESTADO,
	typeAhead: true,
	valueField: 'co_estado',
	displayField:'nb_estado',
	hiddenName:'tb008_proveedor[co_estado]',
	//readOnly:(this.OBJ.co_clasificacion!='')?true:false,
	//style:(this.main.OBJ.co_clasificacion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false,
	listeners:{
            select: function(){
                ProveedorEditar.main.storeCO_MUNICIPIO.load({
                    params: {co_estado:this.getValue()},
                    callback: function(){
                        ProveedorEditar.main.co_municipio.setValue('');
                    }
                });
            }
        }
        
});
this.storeCO_ESTADO.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_estado,
	value:  this.OBJ.co_estado,
	objStore: this.storeCO_ESTADO
});


if(this.OBJ.co_estado!=''){
    ProveedorEditar.main.storeCO_MUNICIPIO.load({
        params: {co_estado:ProveedorEditar.main.OBJ.co_estado},
        callback: function(){
            ProveedorEditar.main.co_municipio.setValue(ProveedorEditar.main.OBJ.co_municipio);
        }
    });
}
    
this.co_municipio = new Ext.form.ComboBox({
	fieldLabel:'Municipio',
	store: this.storeCO_MUNICIPIO,
	typeAhead: true,
	valueField: 'co_municipio',
	displayField:'nb_municipio',
	hiddenName:'tb008_proveedor[co_municipio]',
	//readOnly:(this.OBJ.co_clasificacion!='')?true:false,
	//style:(this.main.OBJ.co_clasificacion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false
        
});
/*this.storeCO_MUNICIPIO.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_municipio,
	value:  this.OBJ.co_municipio,
	objStore: this.storeCO_MUNICIPIO
});*/

this.compositefieldEdoMun = new Ext.form.CompositeField({
fieldLabel: 'Estado',
width:600,
items: [
	this.co_estado,
        {
           xtype: 'displayfield',
           value: 'Municipio:',
           width: 60
        },
	this.co_municipio,
	]
});

this.co_clasificacion = new Ext.form.ComboBox({
	fieldLabel:'Clasificacion',
	store: this.storeCO_CLASIFICACION,
	typeAhead: true,
	valueField: 'co_clasificacion',
	displayField:'tx_clasificacion',
	hiddenName:'tb008_proveedor[co_clasificacion]',
	//readOnly:(this.OBJ.co_clasificacion!='')?true:false,
	//style:(this.main.OBJ.co_clasificacion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:600,
	resizable:true,
	allowBlank:false
});
this.storeCO_CLASIFICACION.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_clasificacion,
	value:  this.OBJ.co_clasificacion,
	objStore: this.storeCO_CLASIFICACION
});

this.tx_email = new Ext.form.TextField({
	fieldLabel:'Email',
	name:'tb008_proveedor[tx_email]',
	value:this.OBJ.tx_email,
	width:400
});

this.tx_sitio_web = new Ext.form.TextField({
	fieldLabel:'WEB',
	name:'tb008_proveedor[tx_sitio_web]',
	value:this.OBJ.tx_sitio_web,
	width:300
});

this.nb_representante_legal = new Ext.form.TextField({
	fieldLabel:'Nombre y Apellido',
	name:'tb008_proveedor[nb_representante_legal]',
	value:this.OBJ.nb_representante_legal,
	//allowBlank:false,
	width:300
});

this.nu_cedula_representante = new Ext.form.NumberField({
	fieldLabel:'Cédula',
	name:'tb008_proveedor[nu_cedula_representante]',
	value:this.OBJ.nu_cedula_representante,
	//allowBlank:false,
	width:100
});

this.compositefieldRepresentante = new Ext.form.CompositeField({
fieldLabel: 'Cédula',
width:600,
items: [
	this.nu_cedula_representante,
        {
           xtype: 'displayfield',
           value: 'Nombre y Apellido:',
           width: 110
        },
	this.nb_representante_legal
	]
});

this.tx_num_celular = new Ext.form.TextField({
	fieldLabel:'Telf. Movil',
	name:'tb008_proveedor[tx_num_celular]',
	value:this.OBJ.tx_num_celular,
	width:100
});

this.fe_registro = new Ext.form.DateField({
	fieldLabel:'Fecha Registro',
	name:'tb008_proveedor[fe_registro]',
	value:this.OBJ.fe_registro,
	width:100
});
/*
this.co_cuenta_contable = new Ext.form.ComboBox({
	fieldLabel:'Cuenta Contable',
	store: this.storeCO_CUENTA_CONTABLE,
	typeAhead: true,
	valueField: 'co_cuenta_contable',
	displayField:'tx_cuenta',
	hiddenName:'tb008_proveedor[co_cuenta_contable]',
	//readOnly:(this.OBJ.co_cuenta_contable!='')?true:false,
	//style:(this.main.OBJ.co_cuenta_contable!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:150,
	resizable:true
});
this.storeCO_CUENTA_CONTABLE.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_cuenta_contable,
	value:  this.OBJ.co_cuenta_contable,
	objStore: this.storeCO_CUENTA_CONTABLE
});*/

this.fe_vencimiento = new Ext.form.DateField({
	fieldLabel:'Fecha Vencimiento',
	name:'tb008_proveedor[fe_vencimiento]',
	width:100
});


this.compositefieldfecha = new Ext.form.CompositeField({
fieldLabel: 'Fecha Registro',
width:600,
items: [
	this.fe_registro,
        {
           xtype: 'displayfield',
           value: 'Fecha Vencimiento:',
           width: 110
        },
	this.fe_vencimiento
	]
});


this.nu_cuenta_bancaria = new Ext.form.TextField({
	fieldLabel:'Cuenta Bancaria',
	name:'tb008_proveedor[nu_cuenta_bancaria]',
	width:200,
        value: this.OBJ.nu_cuenta_bancaria,
        maskRe: /[0-9]/
});

this.co_banco = new Ext.form.ComboBox({
	fieldLabel:'Banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'tx_banco',
	hiddenName:'tb008_proveedor[co_banco]',
	//readOnly:(this.OBJ.co_banco!='')?true:false,
	//style:(this.main.OBJ.co_banco!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true
});
this.storeCO_BANCO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_banco,
	value:  this.OBJ.co_banco,
	objStore: this.storeCO_BANCO
});


this.compositefieldBanco = new Ext.form.CompositeField({
fieldLabel: 'Banco',
width:600,
items: [
	this.co_banco,
        {
           xtype: 'displayfield',
           value: 'Cuenta Bancaria:',
           width: 100
        },
	this.nu_cuenta_bancaria,
	]
});

this.co_tipo_residencia = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Residencia',
	store: this.storeCO_TIPO_RESIDENCIA,
	typeAhead: true,
	valueField: 'co_tipo_residencia',
	displayField:'tx_tipo_residencia',
	hiddenName:'tb008_proveedor[co_tipo_residencia]',
	//readOnly:(this.OBJ.co_tipo_residencia!='')?true:false,
	//style:(this.main.OBJ.co_tipo_residencia!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true
});
this.storeCO_TIPO_RESIDENCIA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tipo_residencia,
	value:  this.OBJ.co_tipo_residencia,
	objStore: this.storeCO_TIPO_RESIDENCIA
});

this.co_tipo_proveedor = new Ext.form.ComboBox({
	fieldLabel:'Tipo Empresa',
	store: this.storeCO_TIPO_PROVEEDOR,
	typeAhead: true,
	valueField: 'co_tipo_proveedor',
	displayField:'tx_tipo_proveedor',
	hiddenName:'tb008_proveedor[co_tipo_proveedor]',
	//readOnly:(this.OBJ.co_tipo_proveedor!='')?true:false,
	//style:(this.main.OBJ.co_tipo_proveedor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_PROVEEDOR.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tipo_proveedor,
	value:  this.OBJ.co_tipo_proveedor,
	objStore: this.storeCO_TIPO_PROVEEDOR
});

this.co_iva_retencion = new Ext.form.ComboBox({
	fieldLabel:'Retención de IVA',
	store: this.storeCO_IVA_RETENCION,
	typeAhead: true,
	valueField: 'co_iva_retencion',
	displayField:'nu_valor',
	hiddenName:'tb008_proveedor[co_iva_retencion]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:50,
	resizable:true,
	allowBlank:false
});
this.storeCO_IVA_RETENCION.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_iva_retencion,
	value:  this.OBJ.co_iva_retencion,
	objStore: this.storeCO_IVA_RETENCION
});

this.tx_registro = new Ext.form.TextField({
	fieldLabel:'Registro',
	name:'tb008_proveedor[tx_registro]',
	value:this.OBJ.tx_registro,
	width:200
});

this.fe_registro_seniat = new Ext.form.DateField({
	fieldLabel:'Fecha',
	name:'tb008_proveedor[fe_registro_seniat]',
	value:this.OBJ.fe_registro_seniat,
	width:100
});

this.nu_registro = new Ext.form.NumberField({
	fieldLabel:'Nro Registro',
	name:'tb008_proveedor[nu_registro]',
	value:this.OBJ.nu_registro
});

this.nu_tomo = new Ext.form.NumberField({
	fieldLabel:'Tomo',
	name:'tb008_proveedor[nu_tomo]',
	value:this.OBJ.nu_tomo
});

this.nu_capital_suscrito = new Ext.form.NumberField({
	fieldLabel:'Capital Suscrito',
	name:'tb008_proveedor[nu_capital_suscrito]',
	value:this.OBJ.nu_capital_suscrito
});

this.nu_capital_pagado = new Ext.form.NumberField({
	fieldLabel:'Capital Pagado',
	name:'tb008_proveedor[nu_capital_pagado]',
	value:this.OBJ.nu_capital_pagado
});

this.tx_observacion = new Ext.form.TextArea({
	fieldLabel:'Observaciones',
	name:'tb008_proveedor[tx_observacion]',
	value:this.OBJ.tx_observacion,
	width:600
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ProveedorEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        
        var itemAct = ProveedorEditar.main.tabuladores.getActiveTab();
        ProveedorEditar.main.tabuladores.items.each(function(item)
        {
            ProveedorEditar.main.tabuladores.getItem(item).show();
        });
        ProveedorEditar.main.tabuladores.setActiveTab(itemAct);
        
        var list_ramo = paqueteComunJS.funcion.getJsonByObjStore({
                store:ProveedorEditar.main.gridPanel.getStore()
        });
        
        ProveedorEditar.main.hiddenJsonRamo.setValue(list_ramo);
        
        var list_cuenta = paqueteComunJS.funcion.getJsonByObjStore({
                store:ProveedorEditar.main.gridPanelCuenta.getStore()
        });
        
        ProveedorEditar.main.hiddenJsonCuentaBancaria.setValue(list_cuenta);
        
        var list_retenciones = paqueteComunJS.funcion.getJsonByObjStore({
                store:ProveedorEditar.main.gridRetenciones.getStore()
        });
        
        ProveedorEditar.main.hiddenJsonRetenciones.setValue(list_retenciones);        
        
        var list_aporte = paqueteComunJS.funcion.getJsonByObjStore({
                store:ProveedorEditar.main.gridAportePatronal.getStore()
        });
        
        ProveedorEditar.main.hiddenJsonAportePatronal.setValue(list_aporte);       
        
        
        
        
        ProveedorEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/guardar',
            waitMsg: 'Enviando datos, por favor espere..',
            waitTitle:'Enviando',
            failure: function(form, action) {
                Ext.MessageBox.alert('Error en transacción', action.result.msg);
            },
            success: function(form, action) {
                 if(action.result.success){
                     Ext.MessageBox.show({
                         title: 'Mensaje',
                         msg: action.result.msg,
                         closable: false,
                         icon: Ext.MessageBox.INFO,
                         resizable: false,
			 animEl: document.body,
                         buttons: Ext.MessageBox.OK
                     });
                 }
                 ProveedorLista.main.store_lista.load();
                 ProveedorEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ProveedorEditar.main.winformPanel_.close();
    }
});

this.fieldDatos1 = new Ext.form.FieldSet({
	title: 'Datos del Proveedor',
	items:[ this.compositefieldCIRIF,   
                this.tx_nit,     
                this.tx_razon_social,
                this.tx_siglas,
                this.co_clasificacion,
                this.tx_email,
                this.tx_sitio_web,
                this.compositefieldfecha,   
                this.hiddenJsonRamo,
                this.hiddenJsonCuentaBancaria,
                this.hiddenJsonRetenciones,
                this.hiddenJsonAportePatronal
            ]
});

this.fieldDatos2 = new Ext.form.FieldSet({
	title: 'Dirección',
	items:[this.compositefieldEdoMun,
               this.tx_direccion,]
});

this.fieldDatos3 = new Ext.form.FieldSet({
	title: 'Representante Legal',
        items:[ this.compositefieldRepresentante,
                this.tx_num_celular]
});


this.fieldDatosCuenta = new Ext.form.FieldSet({
	title: 'Cuenta Bancaria',
        items:[this.compositefieldBanco]
});



this.fieldDatos4 = new Ext.form.FieldSet({
        items:[ this.co_tipo_residencia,
                this.co_tipo_proveedor,
                this.co_iva_retencion,
                this.tx_registro,
                this.fe_registro_seniat,
                this.nu_registro,
                this.nu_tomo,
                this.nu_capital_suscrito,
                this.nu_capital_pagado,
                this.tx_observacion,
                this.gridPanel]
});

this.tabuladores = new Ext.TabPanel({
        resizeTabs:true, // turn on tab resizing
        minTabWidth: 115,
        tabWidth:150,border:false,
        enableTabScroll:true,
        autoWidth:true,
        autoHeight:250,
        activeTab: 0,
        defaults: {autoScroll:true},
        items:[
                {
                        title: 'Proveedor',
                        items:[this.fieldDatos1,
                               this.fieldDatos2,
                               this.fieldDatos3,
                               this.fieldDatosCuenta]
                },
                {
                        title: 'Datos de la Empresa',
                        items:[this.fieldDatos4]
                },               
                {
                        title: 'Retenciones Percibidas',
                        items:[this.gridRetenciones]
                },               
                {
                        title: 'Aporte Social',
                        items:[this.gridAportePatronal]
                }
        ]
});

this.formPanel_ = new Ext.form.FormPanel({   
    width:800,
    height:550, 
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_proveedor,
                    this.tabuladores
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Proveedor',
    modal:true,
    constrain:true,
    width:800,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formPanel_
    ],
    buttons:[
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
ProveedorLista.main.mascara.hide();
},getListaCuenta: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storelistaCuentaBancaria',
    root:'data',
    fields:[
                {name: 'co_cuenta_proveedor'},
                {name: 'co_banco'},
                {name: 'tx_banco'},
                {name: 'co_cuenta_bancaria'},
                {name: 'tx_cuenta'},
                {name: 'co_cuenta_contable'},
                {name: 'nu_cuenta_contable'}
           ]
    });
    return this.store;   

},getListaRetencion: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storelistaRetencion',
    root:'data',
    fields:[
                {name: 'co_retencion_proveedor'},
                {name: 'co_tipo_retencion'},
                {name: 'tx_tipo_retencion'}
                
           ]
    });
    return this.store;   

},getListaAporte: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storelistaAportePatronal',
    root:'data',
    fields:[
                {name: 'co_aporte_patronal'},
                {name: 'co_proveedor'},
                {name: 'tx_descripcion'}
                
           ]
    });
    return this.store;   

},getLista: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storelistaRamo',
    root:'data',
    fields:[
                {name: 'co_proveedor_ramo'},
                {name: 'co_ramo'},
                {name: 'tx_ramo'}
           ]
    });
    return this.store;      
},getStoreCO_ESTADO: function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcoestado',
        root:'data',
        fields:[
            {name: 'co_estado'},
            {name: 'nb_estado'}
            ]
    });
    return this.store;
},
getStoreCO_MUNICIPIO: function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcomunicipio',
        root:'data',
        fields:[
            {name: 'co_municipio'},
            {name: 'nb_municipio'}
            ]
    });
    return this.store;
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
}
,getStoreCO_CLASIFICACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcoclasificacion',
        root:'data',
        fields:[
            {name: 'co_clasificacion'},
            {name: 'tx_clasificacion'}
            ]
    });
    return this.store;
}
,getStoreCO_CUENTA_CONTABLE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcocuentacontable',
        root:'data',
        fields:[
            {name: 'co_cuenta_contable'},
            {name: 'tx_cuenta'}
            ]
    });
    return this.store;
}
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcobanco',
        root:'data',
        fields:[
            {name: 'co_banco'},
            {name: 'tx_banco'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_RESIDENCIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcotiporesidencia',
        root:'data',
        fields:[
            {name: 'co_tipo_residencia'},
            {name: 'tx_tipo_residencia'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_PROVEEDOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcotipoproveedor',
        root:'data',
        fields:[
            {name: 'co_tipo_proveedor'},
            {name: 'tx_tipo_proveedor'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_RETENCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcotiporetencion',
        root:'data',
        fields:[
            {name: 'co_tipo_retencion'},
            {name: 'tx_tipo_retencion'}
            ]
    });
    return this.store;
},getStoreCO_IVA_RETENCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcoivaretencion',
        root:'data',
        fields:[
            {name: 'co_iva_retencion'},
            {name: 'nu_valor'}
            ]
    });
    return this.store;
},
eliminar:function(){
        var s = ProveedorEditar.main.gridPanel.getSelectionModel().getSelections();
        
        var co_proveedor_ramo = ProveedorEditar.main.gridPanel.getSelectionModel().getSelected().get('co_proveedor_ramo');
       
        if(co_proveedor_ramo!=''){
            
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/eliminarRamo',
            params:{
                co_proveedor_ramo: co_proveedor_ramo
            },
            success:function(result, request ) {
               ProveedorEditar.main.store_lista.load();
            }});
            
        }
       
        for(var i = 0, r; r = s[i]; i++){
              ProveedorEditar.main.store_lista.remove(r);
        }
},
eliminarCuenta:function(){
        var s = ProveedorEditar.main.gridPanelCuenta.getSelectionModel().getSelections();
        
        var co_cuenta_proveedor = ProveedorEditar.main.gridPanelCuenta.getSelectionModel().getSelected().get('co_cuenta_proveedor');
       
        if(co_cuenta_proveedor!=''){
            
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/eliminarCuentaProveedor',
            params:{
                co_cuenta_proveedor: co_cuenta_proveedor
            },
            success:function(result, request ) {
               ProveedorEditar.main.botonEliminarContable.disable();
            }});
            
        }
       
        for(var i = 0, r; r = s[i]; i++){
              ProveedorEditar.main.store_lista_cuenta.remove(r);
        }
},
eliminarRetencion:function(){
        var s = ProveedorEditar.main.gridRetenciones.getSelectionModel().getSelections();
        
        var co_retencion_proveedor = ProveedorEditar.main.gridRetenciones.getSelectionModel().getSelected().get('co_retencion_proveedor');
       
        if(co_retencion_proveedor!=''){
            
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/eliminarRetencion',
            params:{
                co_retencion_proveedor: co_retencion_proveedor
            },
            success:function(result, request ) {
               ProveedorEditar.main.botonEliminarRetencion.disable();
            }});
            
        }
       
        for(var i = 0, r; r = s[i]; i++){
              ProveedorEditar.main.store_lista_retenciones.remove(r);
        }
},
eliminarAportePatronal:function(){
        var s = ProveedorEditar.main.gridAportePatronal.getSelectionModel().getSelections();
        
        var co_aporte_patronal = ProveedorEditar.main.gridAportePatronal.getSelectionModel().getSelected().get('co_aporte_patronal');
        var co_proveedor       = ProveedorEditar.main.gridAportePatronal.getSelectionModel().getSelected().get('co_proveedor');
       
        if(co_proveedor!=''){
            
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/eliminarAportePatronal',
            params:{
                co_aporte_patronal: co_aporte_patronal,
                co_proveedor: co_proveedor
            },
            success:function(result, request ) {
               ProveedorEditar.main.botonEliminarAporte.disable();
            }});
            
        }
       
        for(var i = 0, r; r = s[i]; i++){
              ProveedorEditar.main.store_lista_aporte_patronal.remove(r);
        }
}
};
Ext.onReady(ProveedorEditar.main.init, ProveedorEditar.main);
</script>
<div id="formularioAgregar"></div>
