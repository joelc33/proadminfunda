<script type="text/javascript">
Ext.ns("PresupuestoEditar");
PresupuestoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_PARTIDA_PRESUPUESTARIA = this.getStoreCO_PARTIDA_PRESUPUESTARIA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ACTIVIDAD = this.getStoreCO_ACTIVIDAD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ANIO_FISCAL = this.getStoreCO_ANIO_FISCAL();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CUENTA_CONTABLE = this.getStoreCO_CUENTA_CONTABLE();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_PRESUPUESTO = this.getStoreCO_TIPO_PRESUPUESTO();
//<Stores de fk>

//<ClavePrimaria>
this.co_presupuesto_partida = new Ext.form.Hidden({
    name:'co_presupuesto_partida',
    value:this.OBJ.co_presupuesto_partida});
//</ClavePrimaria>


this.co_partida_presupuestaria = new Ext.form.ComboBox({
	fieldLabel:'Co partida presupuestaria',
	store: this.storeCO_PARTIDA_PRESUPUESTARIA,
	typeAhead: true,
	valueField: 'co_partida_presupuestaria',
	displayField:'co_partida_presupuestaria',
	hiddenName:'tb022_presupuesto_partida[co_partida_presupuestaria]',
	//readOnly:(this.OBJ.co_partida_presupuestaria!='')?true:false,
	//style:(this.main.OBJ.co_partida_presupuestaria!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_partida_presupuestaria',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_PARTIDA_PRESUPUESTARIA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_partida_presupuestaria,
	value:  this.OBJ.co_partida_presupuestaria,
	objStore: this.storeCO_PARTIDA_PRESUPUESTARIA
});

this.co_actividad = new Ext.form.ComboBox({
	fieldLabel:'Co actividad',
	store: this.storeCO_ACTIVIDAD,
	typeAhead: true,
	valueField: 'co_actividad',
	displayField:'co_actividad',
	hiddenName:'tb022_presupuesto_partida[co_actividad]',
	//readOnly:(this.OBJ.co_actividad!='')?true:false,
	//style:(this.main.OBJ.co_actividad!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_actividad',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ACTIVIDAD.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_actividad,
	value:  this.OBJ.co_actividad,
	objStore: this.storeCO_ACTIVIDAD
});

this.mo_inicial = new Ext.form.NumberField({
	fieldLabel:'Mo inicial',
	name:'tb022_presupuesto_partida[mo_inicial]',
	value:this.OBJ.mo_inicial,
	allowBlank:false
});

this.mo_autorizado = new Ext.form.NumberField({
	fieldLabel:'Mo autorizado',
	name:'tb022_presupuesto_partida[mo_autorizado]',
	value:this.OBJ.mo_autorizado,
	allowBlank:false
});

this.mo_comprometido = new Ext.form.NumberField({
	fieldLabel:'Mo comprometido',
	name:'tb022_presupuesto_partida[mo_comprometido]',
	value:this.OBJ.mo_comprometido,
	allowBlank:false
});

this.mo_causado = new Ext.form.NumberField({
	fieldLabel:'Mo causado',
	name:'tb022_presupuesto_partida[mo_causado]',
	value:this.OBJ.mo_causado,
	allowBlank:false
});

this.mo_pagado = new Ext.form.NumberField({
	fieldLabel:'Mo pagado',
	name:'tb022_presupuesto_partida[mo_pagado]',
	value:this.OBJ.mo_pagado,
	allowBlank:false
});

this.co_anio_fiscal = new Ext.form.ComboBox({
	fieldLabel:'Co anio fiscal',
	store: this.storeCO_ANIO_FISCAL,
	typeAhead: true,
	valueField: 'co_anio_fiscal',
	displayField:'co_anio_fiscal',
	hiddenName:'tb022_presupuesto_partida[co_anio_fiscal]',
	//readOnly:(this.OBJ.co_anio_fiscal!='')?true:false,
	//style:(this.main.OBJ.co_anio_fiscal!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_anio_fiscal',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ANIO_FISCAL.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_anio_fiscal,
	value:  this.OBJ.co_anio_fiscal,
	objStore: this.storeCO_ANIO_FISCAL
});

this.mo_disponible = new Ext.form.NumberField({
	fieldLabel:'Mo disponible',
	name:'tb022_presupuesto_partida[mo_disponible]',
	value:this.OBJ.mo_disponible,
	allowBlank:false
});

this.mo_deuda = new Ext.form.NumberField({
	fieldLabel:'Mo deuda',
	name:'tb022_presupuesto_partida[mo_deuda]',
	value:this.OBJ.mo_deuda,
	allowBlank:false
});

this.co_cuenta_contable = new Ext.form.ComboBox({
	fieldLabel:'Co cuenta contable',
	store: this.storeCO_CUENTA_CONTABLE,
	typeAhead: true,
	valueField: 'co_cuenta_contable',
	displayField:'co_cuenta_contable',
	hiddenName:'tb022_presupuesto_partida[co_cuenta_contable]',
	//readOnly:(this.OBJ.co_cuenta_contable!='')?true:false,
	//style:(this.main.OBJ.co_cuenta_contable!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_cuenta_contable',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_CUENTA_CONTABLE.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_cuenta_contable,
	value:  this.OBJ.co_cuenta_contable,
	objStore: this.storeCO_CUENTA_CONTABLE
});

this.mo_debito = new Ext.form.NumberField({
	fieldLabel:'Mo debito',
	name:'tb022_presupuesto_partida[mo_debito]',
	value:this.OBJ.mo_debito,
	allowBlank:false
});

this.mo_credito = new Ext.form.NumberField({
	fieldLabel:'Mo credito',
	name:'tb022_presupuesto_partida[mo_credito]',
	value:this.OBJ.mo_credito,
	allowBlank:false
});

this.in_ordinal = new Ext.form.Checkbox({
	fieldLabel:'In ordinal',
	name:'tb022_presupuesto_partida[in_ordinal]',
	checked:(this.OBJ.in_ordinal=='0') ? true:false,
	allowBlank:false
});

this.co_tipo_presupuesto = new Ext.form.ComboBox({
	fieldLabel:'Co tipo presupuesto',
	store: this.storeCO_TIPO_PRESUPUESTO,
	typeAhead: true,
	valueField: 'co_tipo_presupuesto',
	displayField:'co_tipo_presupuesto',
	hiddenName:'tb022_presupuesto_partida[co_tipo_presupuesto]',
	//readOnly:(this.OBJ.co_tipo_presupuesto!='')?true:false,
	//style:(this.main.OBJ.co_tipo_presupuesto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_presupuesto',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_PRESUPUESTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tipo_presupuesto,
	value:  this.OBJ.co_tipo_presupuesto,
	objStore: this.storeCO_TIPO_PRESUPUESTO
});

this.mo_aumento = new Ext.form.NumberField({
	fieldLabel:'Mo aumento',
	name:'tb022_presupuesto_partida[mo_aumento]',
	value:this.OBJ.mo_aumento,
	allowBlank:false
});

this.mo_disminucion = new Ext.form.NumberField({
	fieldLabel:'Mo disminucion',
	name:'tb022_presupuesto_partida[mo_disminucion]',
	value:this.OBJ.mo_disminucion,
	allowBlank:false
});

this.mo_precomprometido = new Ext.form.NumberField({
	fieldLabel:'Mo precomprometido',
	name:'tb022_presupuesto_partida[mo_precomprometido]',
	value:this.OBJ.mo_precomprometido,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PresupuestoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PresupuestoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/guardar',
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
                 PresupuestoLista.main.store_lista.load();
                 PresupuestoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PresupuestoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_presupuesto_partida,
                    this.co_partida_presupuestaria,
                    this.co_actividad,
                    this.mo_inicial,
                    this.mo_autorizado,
                    this.mo_comprometido,
                    this.mo_causado,
                    this.mo_pagado,
                    this.co_anio_fiscal,
                    this.mo_disponible,
                    this.mo_deuda,
                    this.co_cuenta_contable,
                    this.mo_debito,
                    this.mo_credito,
                    this.in_ordinal,
                    this.co_tipo_presupuesto,
                    this.mo_aumento,
                    this.mo_disminucion,
                    this.mo_precomprometido,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Presupuesto',
    modal:true,
    constrain:true,
width:400,
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
PresupuestoLista.main.mascara.hide();
}
,getStoreCO_PARTIDA_PRESUPUESTARIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcopartidapresupuestaria',
        root:'data',
        fields:[
            {name: 'co_partida_presupuestaria'}
            ]
    });
    return this.store;
}
,getStoreCO_ACTIVIDAD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcoactividad',
        root:'data',
        fields:[
            {name: 'co_actividad'}
            ]
    });
    return this.store;
}
,getStoreCO_ANIO_FISCAL:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcoaniofiscal',
        root:'data',
        fields:[
            {name: 'co_anio_fiscal'}
            ]
    });
    return this.store;
}
,getStoreCO_CUENTA_CONTABLE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcocuentacontable',
        root:'data',
        fields:[
            {name: 'co_cuenta_contable'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_PRESUPUESTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcotipopresupuesto',
        root:'data',
        fields:[
            {name: 'co_tipo_presupuesto'}
            ]
    });
    return this.store;
}
};
Ext.onReady(PresupuestoEditar.main.init, PresupuestoEditar.main);
</script>
