<script type="text/javascript">
Ext.ns("PrestacionSocialEditar");
PrestacionSocialEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();

this.storeCO_SITUACION_TRABAJADOR = this.getStoreCO_SITUACION_TRABAJADOR();
//objeto store
this.store_cuenta_contable = this.getLista_cuenta_contable();
//objeto store
this.store_categoria_presupuestaria = this.getLista_categoria_presupuestaria();

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>
//<ClavePrimaria>
this.co_compras = new Ext.form.Hidden({
    name:'co_compras',
    value:this.OBJ.co_compras});
//</ClavePrimaria>

this.co_solicitud = new Ext.form.Hidden({
    name:'tb191_prestacion_social[co_solicitud]',
    value:this.OBJ.co_solicitud
});

this.co_usuario = new Ext.form.Hidden({
    name:'tb191_prestacion_social[co_usuario]',
    value:this.OBJ.co_usuario
});

this.co_proveedor = new Ext.form.Hidden({
    name:'tb191_prestacion_social[co_proveedor]',
    value:this.OBJ.co_proveedor
});

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'tb191_prestacion_social[co_documento]',
	//readOnly:(this.OBJ.co_documento!='')?true:false,
	//style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
    style:'background:#c9c9c9;',
	readOnly:true,
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
	value:  this.OBJ.co_documento,
	objStore: this.storeCO_DOCUMENTO
});

this.nu_documento = new Ext.form.TextField({
	fieldLabel:'Nu documento',
	name:'tb191_prestacion_social[nu_documento]',
	value:this.OBJ.nu_documento,
	allowBlank:false,
    style:'background:#c9c9c9;',
	readOnly:true,
	width:145
});

this.compositefieldCI = new Ext.form.CompositeField({
fieldLabel: 'N° Documento',
width:300,
items: [
	this.co_documento,
	this.nu_documento,
	]
});

this.nb_persona = new Ext.form.TextField({
	fieldLabel:'Nombre / Apellido',
	name:'tb191_prestacion_social[nb_persona]',
	value:this.OBJ.nb_persona,
	allowBlank:false,
	style:'background:#c9c9c9;',
	readOnly:true,
	width:400
});

this.co_situacion_trabajador = new Ext.form.ComboBox({
	fieldLabel:'Situacion Trabajador',
	store: this.storeCO_SITUACION_TRABAJADOR,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_situacion_empleado',
	hiddenName:'tb191_prestacion_social[co_situacion_trabajador]',
	//readOnly:(this.OBJ.co_situacion_trabajador!='')?true:false,
	//style:(this.main.OBJ.co_situacion_trabajador!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Situacion Trabajador...',
	selectOnFocus: true,
	mode: 'local',
    style:'background:#c9c9c9;',
	readOnly:true,
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeCO_SITUACION_TRABAJADOR.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_situacion_trabajador,
	value:  this.OBJ.co_situacion_trabajador,
	objStore: this.storeCO_SITUACION_TRABAJADOR
});

this.fe_ingreso = new Ext.form.DateField({
	fieldLabel:'Fecha Ingreso',
	name:'tb191_prestacion_social[fe_ingreso]',
	value:this.OBJ.fe_ingreso,
	allowBlank:false,
    style:'background:#c9c9c9;',
	readOnly:true,
	width:100
});

this.fe_egreso = new Ext.form.DateField({
	fieldLabel:'Fecha Egreso',
	name:'tb191_prestacion_social[fe_egreso]',
	value:this.OBJ.fe_egreso,
	allowBlank:false,
    style:'background:#c9c9c9;',
	readOnly:true,
	width:100
});

this.fe_movimiento = new Ext.form.DateField({
	fieldLabel:'Fecha Movimiento',
	name:'tb191_prestacion_social[fe_movimiento]',
	value:this.OBJ.fe_movimiento,
	allowBlank:false,
    style:'background:#c9c9c9;',
	readOnly:true,
	width:100
});

this.de_observacion = new Ext.form.TextField({
	fieldLabel:'Observacion',
	name:'tb191_prestacion_social[de_observacion]',
	value:this.OBJ.de_observacion,
	allowBlank:false,
    style:'background:#c9c9c9;',
	readOnly:true,
	width:400
});

this.mo_pago = new Ext.form.NumberField({
	fieldLabel:'Monto a Pagar',
	name:'tb191_prestacion_social[mo_pago]',
	value:this.OBJ.mo_pago,
	allowBlank:false,
    style:'background:#c9c9c9;',
	readOnly:true,
	width:200
});

function formatoNro(val){
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}

//Grid principal
this.gridPanel_categria_presupuestaria = new Ext.grid.GridPanel({
    store: this.store_categoria_presupuestaria,
    loadMask:true,
    border:false,
    height:200,
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Año', width:60,  menuDisabled:true, sortable: true,  dataIndex: 'nu_anio'},
    {header: 'UE', width:50,  menuDisabled:true, sortable: true,  dataIndex: 'nu_ue'},
    {header: 'PAC', width:50,  menuDisabled:true, sortable: true,  dataIndex: 'nu_pac'},
    {header: 'AE', width:50,  menuDisabled:true, sortable: true,  dataIndex: 'nu_ae'},
    {header: 'P', width:50,  menuDisabled:true, sortable: true,  dataIndex: 'nu_pa'},
    {header: 'G', width:50,  menuDisabled:true, sortable: true,  dataIndex: 'nu_ge'},
    {header: 'E', width:50,  menuDisabled:true, sortable: true,  dataIndex: 'nu_es'},
    {header: 'SE', width:50,  menuDisabled:true, sortable: true,  dataIndex: 'nu_se'},
    {header: 'SSE', width:50,  menuDisabled:true, sortable: true,  dataIndex: 'nu_sse'},
    {header: 'F', width:60,  menuDisabled:true, sortable: true,  dataIndex: 'nu_fi'},
    {header: 'Monto', width:130,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_partida'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_categoria_presupuestaria,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

//Grid principal
this.gridPanel_cuenta_contable = new Ext.grid.GridPanel({
    store: this.store_cuenta_contable,
    loadMask:true,
    border:false,
    height:200,
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Cuenta', width:330,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cuenta'},
    {header: 'Debitos', width:150,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_debito'},
    {header: 'Creditos', width:150,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_credito'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_cuenta_contable,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.panel_categoria = new Ext.TabPanel({
    activeTab:0,
    border:true,
    enableTabScroll:true,
    deferredRender: true,
	autoWidth:true,
	height:230,
    items:[
		{
			title: 'Códigos contables',
            autoScroll:true,
            border:false,
			items:[
                this.gridPanel_cuenta_contable
            ]
		},
		{
			title: 'Categoría Presupuestaria',
            autoScroll:true,
            border:false,
			items:[
                this.gridPanel_categria_presupuestaria
            ]
		}
	]
});

this.panelDatos2 = new Ext.Panel({
    autoHeight:true,
    border:false,
    bodyStyle:'padding:0px;',
    items:[
		this.panel_categoria
	]
});

this.guardar = new Ext.Button({
    text:'Procesar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PrestacionSocialEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PrestacionSocialEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/procesarPrestacionSocial',
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
                 //PrestacionSocialLista.main.store_lista.load();
                 PrestacionSocialEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PrestacionSocialEditar.main.winformPanel_.close();
    }
});

this.fieldDatos1 = new Ext.form.FieldSet({
	title: 'Datos del Trabajador',
	items:[   
			this.compositefieldCI,
			this.co_proveedor,
            this.nb_persona,
    ]
});

this.fieldDatos2 = new Ext.form.FieldSet({
	title: 'Datos del Egreso',
	items:[   
			this.co_situacion_trabajador,
			this.fe_ingreso,
			this.fe_egreso,
			this.fe_movimiento,
			this.de_observacion,
    ]
});

this.fieldDatos3 = new Ext.form.FieldSet({
	items:[   
			this.mo_pago,
    ]
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:false,
    width:700,
autoHeight:true,  
    autoScroll:true,
	labelWidth: 130,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
                    this.co_solicitud,
					this.co_compras,
                    this.co_usuario,
					this.fieldDatos1,
					this.fieldDatos2,
                    this.fieldDatos3,
                    this.panelDatos2
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Contabilidad - Verificacion Prestacion Social',
    modal:true,
    constrain:true,
width:714,
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
//PrestacionSocialLista.main.mascara.hide();
PrestacionSocialEditar.main.store_cuenta_contable.baseParams.co_solicitud=PrestacionSocialEditar.main.OBJ.co_solicitud;
this.store_cuenta_contable.load();
PrestacionSocialEditar.main.store_categoria_presupuestaria.baseParams.co_solicitud=PrestacionSocialEditar.main.OBJ.co_solicitud;
this.store_categoria_presupuestaria.load();
}
,getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'},
            {name: 'inicial'}
            ]
    });
    return this.store;
}
,getStoreCO_SITUACION_TRABAJADOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/storefkcosituaciontrabajador',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_situacion_empleado'},
            ]
    });
    return this.store;
},
getLista_cuenta_contable: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/storelistaCuentaContable',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'nu_cuenta'},
    {name: 'mo_debito'},
    {name: 'mo_credito'},
           ]
    });
    return this.store;
},
getLista_categoria_presupuestaria: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/storelistaCategoriaPresupuestaria',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'nu_anio'},
    {name: 'nu_ue'},
    {name: 'nu_pac'},
    {name: 'nu_ae'},
    {name: 'nu_pa'},
    {name: 'nu_ge'},
    {name: 'nu_es'},
    {name: 'nu_se'},
    {name: 'nu_sse'},
    {name: 'nu_fi'},
    {name: 'mo_partida'},
           ]
    });
    return this.store;
}
};
Ext.onReady(PrestacionSocialEditar.main.init, PrestacionSocialEditar.main);
</script>
