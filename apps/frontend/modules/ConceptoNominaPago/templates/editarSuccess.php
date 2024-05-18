<script type="text/javascript">
Ext.ns("ConceptoNominaPagoEditar");
ConceptoNominaPagoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_TP_CONCEPTO = this.getStoreCO_TP_CONCEPTO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TP_UNIDAD = this.getStoreCO_TP_UNIDAD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_MONEDA = this.getStoreCO_MONEDA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_MODO_CONCEPTO = this.getStoreCO_MODO_CONCEPTO();
//<Stores de fk>
//<Stores de fk>
this.storeNU_PRIORIDAD = this.getStoreNU_PRIORIDAD();
//<Stores de fk>

//<ClavePrimaria>
this.co_concepto = new Ext.form.Hidden({
    name:'co_concepto',
    value:this.OBJ.co_concepto});
//</ClavePrimaria>


this.nu_concepto = new Ext.form.TextField({
	fieldLabel:'Codigo',
	name:'tbrh014_concepto[nu_concepto]',
	value:this.OBJ.nu_concepto,
	allowBlank:false,
	width:100
});

this.tx_concepto = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tbrh014_concepto[tx_concepto]',
	value:this.OBJ.tx_concepto,
	allowBlank:false,
	width:400
});

this.co_tipo_concepto = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Concepto',
	store: this.storeCO_TP_CONCEPTO,
	typeAhead: true,
	valueField: 'co_tp_concepto',
	displayField:'tx_tp_concepto',
	hiddenName:'tbrh014_concepto[co_tipo_concepto]',
	//readOnly:(this.OBJ.co_tipo_concepto!='')?true:false,
	//style:(this.main.OBJ.co_tipo_concepto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Tipo de Concepto',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TP_CONCEPTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tipo_concepto,
	value:  this.OBJ.co_tipo_concepto,
	objStore: this.storeCO_TP_CONCEPTO
});

this.co_tipo_unidad = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Unidad',
	store: this.storeCO_TP_UNIDAD,
	typeAhead: true,
	valueField: 'co_tp_unidad',
	displayField:'tx_tp_unidad',
	hiddenName:'tbrh014_concepto[co_tipo_unidad]',
	//readOnly:(this.OBJ.co_tipo_unidad!='')?true:false,
	//style:(this.main.OBJ.co_tipo_unidad!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Unidad',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TP_UNIDAD.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tipo_unidad,
	value:  this.OBJ.co_tipo_unidad,
	objStore: this.storeCO_TP_UNIDAD
});

this.nu_cuenta_contable = new Ext.form.TextField({
	fieldLabel:'Cuenta Contable',
	name:'tbrh014_concepto[nu_cuenta_contable]',
	value:this.OBJ.nu_cuenta_contable,
	//allowBlank:false,
	width:200
});

this.nu_cuenta_presupuesto = new Ext.form.TextField({
	fieldLabel:'Cuenta Presupuesto',
	name:'tbrh014_concepto[nu_cuenta_presupuesto]',
	value:this.OBJ.nu_cuenta_presupuesto,
	//allowBlank:false,
	width:200
});

this.nu_valor = new Ext.form.NumberField({
	fieldLabel:'Valor por Defecto',
	name:'tbrh014_concepto[nu_valor]',
	value:this.OBJ.nu_valor,
	allowBlank:false,
	allowDecimals : true,
    decimalPrecision : 4,
	width:100
});

this.in_imprime_detalle = new Ext.form.Checkbox({
	fieldLabel:'¿Imprime detalles?',
	name:'tbrh014_concepto[in_imprime_detalle]',
	checked:this.OBJ.in_imprime_detalle,
	allowBlank:false
});

this.in_descripcion_alternativa = new Ext.form.Checkbox({
	fieldLabel:'¿Usa descripcion alternativa?',
	name:'tbrh014_concepto[in_descripcion_alternativa]',
	checked:this.OBJ.in_descripcion_alternativa,
	allowBlank:false
});

this.in_valor_referencia = new Ext.form.Checkbox({
	fieldLabel:'¿Muestra valor de Referencia?',
	name:'tbrh014_concepto[in_valor_referencia]',
	checked:this.OBJ.in_valor_referencia,
	allowBlank:false
});

this.in_hoja_tiempo = new Ext.form.Checkbox({
	fieldLabel:'¿Utiliza Hoja de Tiempo?',
	name:'tbrh014_concepto[in_hoja_tiempo]',
	checked:this.OBJ.in_hoja_tiempo,
	allowBlank:false
});

this.in_prorratea = new Ext.form.Checkbox({
	fieldLabel:'¿Se prorratea?',
	name:'tbrh014_concepto[in_prorratea]',
	checked:this.OBJ.in_prorratea,
	allowBlank:false
});

this.in_modifica_descripcion = new Ext.form.Checkbox({
	fieldLabel:'¿Se modifica la descripcion?',
	name:'tbrh014_concepto[in_modifica_descripcion]',
	checked:this.OBJ.in_modifica_descripcion,
	allowBlank:false
});

this.in_monto_calculo = new Ext.form.Checkbox({
	fieldLabel:'¿Muestra monto del calculo?',
	name:'tbrh014_concepto[in_monto_calculo]',
	checked:this.OBJ.in_monto_calculo,
	allowBlank:false
});

this.in_contractual = new Ext.form.Checkbox({
	fieldLabel:'¿Es contractual?',
	name:'tbrh014_concepto[in_contractual]',
	checked:this.OBJ.in_contractual,
	allowBlank:false
});

this.in_bonificable = new Ext.form.Checkbox({
	fieldLabel:'¿Bonificable?',
	name:'tbrh014_concepto[in_bonificable]',
	checked:this.OBJ.in_bonificable,
	allowBlank:false
});

this.in_monto_cero = new Ext.form.Checkbox({
	fieldLabel:'¿No agregar si el monto es (0)?',
	name:'tbrh014_concepto[in_monto_cero]',
	checked:this.OBJ.in_monto_cero,
	allowBlank:false
});

this.de_formula = new Ext.form.TextArea({
	fieldLabel:'Formula',
	name:'tbrh014_concepto[de_formula]',
	//value:this.OBJ.de_formula,
	value: "<?php echo empty($de_formula)? '': $de_formula ?>",
	allowBlank:false,
	width:440,
	height:350
});

this.de_observacion = new Ext.form.TextField({
	fieldLabel:'Observacion',
	name:'tbrh014_concepto[de_observacion]',
	value:this.OBJ.de_observacion,
	//allowBlank:false,
	width:440
});

this.co_moneda = new Ext.form.ComboBox({
	fieldLabel:'Moneda',
	store: this.storeCO_MONEDA,
	typeAhead: true,
	valueField: 'co_moneda',
	displayField:'tx_simbolo',
	hiddenName:'tbrh014_concepto[co_moneda]',
	//readOnly:(this.OBJ.co_moneda!='')?true:false,
	//style:(this.main.OBJ.co_moneda!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Moneda',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_MONEDA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_moneda,
	value:  this.OBJ.co_moneda,
	objStore: this.storeCO_MONEDA
});

this.co_modo_concepto = new Ext.form.ComboBox({
	fieldLabel:'Modo de Calculo',
	store: this.storeCO_MODO_CONCEPTO,
	typeAhead: true,
	valueField: 'co_modo_concepto',
	displayField:'de_modo_concepto',
	hiddenName:'tbrh014_concepto[co_modo_concepto]',
	//readOnly:(this.OBJ.co_modo_concepto!='')?true:false,
	//style:(this.main.OBJ.co_modo_concepto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Modo',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_MODO_CONCEPTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_modo_concepto,
	value:  this.OBJ.co_modo_concepto,
	objStore: this.storeCO_MODO_CONCEPTO
});

this.nu_prioridad = new Ext.form.ComboBox({
	fieldLabel:'Nivel de Proridad',
	store: this.storeNU_PRIORIDAD,
	typeAhead: true,
	valueField: 'nu_prioridad',
	displayField:'nu_prioridad',
	hiddenName:'tbrh014_concepto[nu_prioridad]',
	//readOnly:(this.OBJ.nu_prioridad!='')?true:false,
	//style:(this.main.OBJ.nu_prioridad!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Proridad',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeNU_PRIORIDAD.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.nu_prioridad,
	value:  this.OBJ.nu_prioridad,
	objStore: this.storeNU_PRIORIDAD
});

this.fieldDatos1 = new Ext.form.FieldSet({
    title: 'Opciones del Concepto',
    autoWidth:true,
    labelWidth: 250,
    items:[
		this.in_imprime_detalle,
		this.in_descripcion_alternativa,
		this.in_valor_referencia,
		//this.in_prorratea,
		//this.in_modifica_descripcion,
		this.in_monto_calculo,
		this.in_contractual,
		//this.in_bonificable,
		this.in_monto_cero,
		this.in_hoja_tiempo,
    ]
});

this.fieldset1 = new Ext.form.FieldSet({
    items:[
		this.nu_concepto,
		this.tx_concepto,
		this.co_tipo_concepto,
		this.co_tipo_unidad,
		this.nu_cuenta_contable,
		this.nu_cuenta_presupuesto,
		this.nu_valor,
		this.co_moneda,
		this.co_modo_concepto,
		this.nu_prioridad,
        this.fieldDatos1
	]
});

this.fieldset2 = new Ext.form.FieldSet({
    items:[
		this.de_formula,
		this.de_observacion
	]
});

this.funciones = new Ext.Button({
    text:'Variables / Funciones',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('formularioConceptoNominaPago');
        //ConceptoNominaPagoEditar.main.funciones.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigNomFuncion/todo',
             scripts: true
        });
    }
});

this.concepto = new Ext.Button({
    text:'Conceptos',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('formularioConceptoNominaPago');
        //ConceptoNominaPagoEditar.main.funciones.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/todo',
             scripts: true
        });
    }
});

this.campoAdicional = new Ext.Button({
    text:'Campo Adicional',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('formularioConceptoNominaPago');
        //ConceptoNominaPagoEditar.main.funciones.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigCampoAdicional/todo',
             scripts: true
        });
    }
});

this.panelDatos1 = new Ext.Panel({
    title: 'Concepto',
    bodyStyle:'padding:5px;',
	height:510,
    //autoHeight:true,
	autoScroll:true,
    items:[
		this.fieldset1
	]
});

this.panelDatos2 = new Ext.Panel({
    title: 'Formula',
    bodyStyle:'padding:5px;',
	height:510,
    //autoHeight:true,
	tbar:[
        this.funciones,'-',this.concepto,'-',this.campoAdicional
    ],
    items:[
		this.fieldset2
	]
});

this.panel = new Ext.TabPanel({
    activeTab:0,
    border:false,
    enableTabScroll:true,
    deferredRender: false,
	autoWidth:true,
	autoHeight:true,
    items:[
		this.panelDatos1,
		this.panelDatos2
	]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConceptoNominaPagoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConceptoNominaPagoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/guardar',
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
                 ConceptoNominaPagoLista.main.store_lista.load();
                 ConceptoNominaPagoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConceptoNominaPagoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:false,
    width:680,
	labelWidth: 150,
	autoHeight:true,  
    bodyStyle:'padding:0px;',
    items:[

                    this.co_concepto,
					this.panel
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Concepto Nomina',
    modal:true,
    constrain:true,
width:694,
    frame:true,
    closabled:true,
    autoHeight:true,
	//height:550,
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
ConceptoNominaPagoLista.main.mascara.hide();
}
,getStoreCO_TP_CONCEPTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/storefkcotipoconcepto',
        root:'data',
        fields:[
            {name: 'co_tp_concepto'},
			{name: 'tx_tp_concepto'}
            ]
    });
    return this.store;
}
,getStoreCO_TP_UNIDAD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/storefkcotipounidad',
        root:'data',
        fields:[
            {name: 'co_tp_unidad'},
			{name: 'tx_tp_unidad'}
            ]
    });
    return this.store;
}
,getStoreCO_MONEDA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/storefkcomoneda',
        root:'data',
        fields:[
            {name: 'co_moneda'},
			{name: 'tx_simbolo'}
            ]
    });
    return this.store;
}
,getStoreCO_MODO_CONCEPTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/storefkcomodoconcepto',
        root:'data',
        fields:[
            {name: 'co_modo_concepto'},
			{name: 'de_modo_concepto'}
            ]
    });
    return this.store;
}
,getStoreNU_PRIORIDAD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/storenuprioridad',
        root:'data',
        fields:[
            {name: 'nu_prioridad'}
            ]
    });
    return this.store;
}
};
Ext.onReady(ConceptoNominaPagoEditar.main.init, ConceptoNominaPagoEditar.main);
</script>
