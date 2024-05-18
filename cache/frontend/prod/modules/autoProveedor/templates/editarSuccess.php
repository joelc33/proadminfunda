<script type="text/javascript">
Ext.ns("ProveedorEditar");
ProveedorEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_CLASIFICACION = this.getStoreCO_CLASIFICACION();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CUENTA_CONTABLE = this.getStoreCO_CUENTA_CONTABLE();
//<Stores de fk>
//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_RESIDENCIA = this.getStoreCO_TIPO_RESIDENCIA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_PROVEEDOR = this.getStoreCO_TIPO_PROVEEDOR();
//<Stores de fk>
//<Stores de fk>
this.storeCO_IVA_RETENCION = this.getStoreCO_IVA_RETENCION();
//<Stores de fk>

//<ClavePrimaria>
this.co_proveedor = new Ext.form.Hidden({
    name:'co_proveedor',
    value:this.OBJ.co_proveedor});
//</ClavePrimaria>


this.tx_razon_social = new Ext.form.TextField({
	fieldLabel:'Tx razon social',
	name:'tb008_proveedor[tx_razon_social]',
	value:this.OBJ.tx_razon_social,
	allowBlank:false,
	width:200
});

this.co_documento = new Ext.form.NumberField({
	fieldLabel:'Co documento',
	name:'tb008_proveedor[co_documento]',
	value:this.OBJ.co_documento,
	allowBlank:false
});

this.tx_siglas = new Ext.form.TextField({
	fieldLabel:'Tx siglas',
	name:'tb008_proveedor[tx_siglas]',
	value:this.OBJ.tx_siglas,
	allowBlank:false,
	width:200
});

this.tx_rif = new Ext.form.TextField({
	fieldLabel:'Tx rif',
	name:'tb008_proveedor[tx_rif]',
	value:this.OBJ.tx_rif,
	allowBlank:false,
	width:200
});

this.tx_nit = new Ext.form.TextField({
	fieldLabel:'Tx nit',
	name:'tb008_proveedor[tx_nit]',
	value:this.OBJ.tx_nit,
	allowBlank:false,
	width:200
});

this.tx_direccion = new Ext.form.TextField({
	fieldLabel:'Tx direccion',
	name:'tb008_proveedor[tx_direccion]',
	value:this.OBJ.tx_direccion,
	allowBlank:false,
	width:200
});

this.co_estado = new Ext.form.NumberField({
	fieldLabel:'Co estado',
	name:'tb008_proveedor[co_estado]',
	value:this.OBJ.co_estado,
	allowBlank:false
});

this.co_municipio = new Ext.form.NumberField({
	fieldLabel:'Co municipio',
	name:'tb008_proveedor[co_municipio]',
	value:this.OBJ.co_municipio,
	allowBlank:false
});

this.co_clasificacion = new Ext.form.ComboBox({
	fieldLabel:'Co clasificacion',
	store: this.storeCO_CLASIFICACION,
	typeAhead: true,
	valueField: 'co_clasificacion',
	displayField:'co_clasificacion',
	hiddenName:'tb008_proveedor[co_clasificacion]',
	//readOnly:(this.OBJ.co_clasificacion!='')?true:false,
	//style:(this.main.OBJ.co_clasificacion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_clasificacion',
	selectOnFocus: true,
	mode: 'local',
	width:200,
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
	fieldLabel:'Tx email',
	name:'tb008_proveedor[tx_email]',
	value:this.OBJ.tx_email,
	allowBlank:false,
	width:200
});

this.tx_sitio_web = new Ext.form.TextField({
	fieldLabel:'Tx sitio web',
	name:'tb008_proveedor[tx_sitio_web]',
	value:this.OBJ.tx_sitio_web,
	allowBlank:false,
	width:200
});

this.nb_representante_legal = new Ext.form.TextField({
	fieldLabel:'Nb representante legal',
	name:'tb008_proveedor[nb_representante_legal]',
	value:this.OBJ.nb_representante_legal,
	allowBlank:false,
	width:200
});

this.nu_cedula_representante = new Ext.form.NumberField({
	fieldLabel:'Nu cedula representante',
	name:'tb008_proveedor[nu_cedula_representante]',
	value:this.OBJ.nu_cedula_representante,
	allowBlank:false
});

this.tx_num_celular = new Ext.form.TextField({
	fieldLabel:'Tx num celular',
	name:'tb008_proveedor[tx_num_celular]',
	value:this.OBJ.tx_num_celular,
	allowBlank:false,
	width:200
});

this.nu_dia_credito = new Ext.form.NumberField({
	fieldLabel:'Nu dia credito',
	name:'tb008_proveedor[nu_dia_credito]',
	value:this.OBJ.nu_dia_credito,
	allowBlank:false
});

this.fe_registro = new Ext.form.DateField({
	fieldLabel:'Fe registro',
	name:'tb008_proveedor[fe_registro]',
	value:this.OBJ.fe_registro,
	allowBlank:false,
	width:100
});

this.co_cuenta_contable = new Ext.form.ComboBox({
	fieldLabel:'Co cuenta contable',
	store: this.storeCO_CUENTA_CONTABLE,
	typeAhead: true,
	valueField: 'co_cuenta_contable',
	displayField:'co_cuenta_contable',
	hiddenName:'tb008_proveedor[co_cuenta_contable]',
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

this.fe_vencimiento = new Ext.form.DateField({
	fieldLabel:'Fe vencimiento',
	name:'tb008_proveedor[fe_vencimiento]',
	value:this.OBJ.fe_vencimiento,
	allowBlank:false,
	width:100
});

this.nu_cuenta_bancaria = new Ext.form.TextField({
	fieldLabel:'Nu cuenta bancaria',
	name:'tb008_proveedor[nu_cuenta_bancaria]',
	value:this.OBJ.nu_cuenta_bancaria,
	allowBlank:false,
	width:200
});

this.co_banco = new Ext.form.ComboBox({
	fieldLabel:'Co banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'co_banco',
	hiddenName:'tb008_proveedor[co_banco]',
	//readOnly:(this.OBJ.co_banco!='')?true:false,
	//style:(this.main.OBJ.co_banco!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_banco',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_BANCO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_banco,
	value:  this.OBJ.co_banco,
	objStore: this.storeCO_BANCO
});

this.co_tipo_residencia = new Ext.form.ComboBox({
	fieldLabel:'Co tipo residencia',
	store: this.storeCO_TIPO_RESIDENCIA,
	typeAhead: true,
	valueField: 'co_tipo_residencia',
	displayField:'co_tipo_residencia',
	hiddenName:'tb008_proveedor[co_tipo_residencia]',
	//readOnly:(this.OBJ.co_tipo_residencia!='')?true:false,
	//style:(this.main.OBJ.co_tipo_residencia!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_residencia',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_RESIDENCIA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tipo_residencia,
	value:  this.OBJ.co_tipo_residencia,
	objStore: this.storeCO_TIPO_RESIDENCIA
});

this.co_tipo_proveedor = new Ext.form.ComboBox({
	fieldLabel:'Co tipo proveedor',
	store: this.storeCO_TIPO_PROVEEDOR,
	typeAhead: true,
	valueField: 'co_tipo_proveedor',
	displayField:'co_tipo_proveedor',
	hiddenName:'tb008_proveedor[co_tipo_proveedor]',
	//readOnly:(this.OBJ.co_tipo_proveedor!='')?true:false,
	//style:(this.main.OBJ.co_tipo_proveedor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_proveedor',
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

this.co_tipo_retencion = new Ext.form.NumberField({
	fieldLabel:'Co tipo retencion',
	name:'tb008_proveedor[co_tipo_retencion]',
	value:this.OBJ.co_tipo_retencion,
	allowBlank:false
});

this.tx_registro = new Ext.form.TextField({
	fieldLabel:'Tx registro',
	name:'tb008_proveedor[tx_registro]',
	value:this.OBJ.tx_registro,
	allowBlank:false,
	width:200
});

this.fe_registro_seniat = new Ext.form.DateField({
	fieldLabel:'Fe registro seniat',
	name:'tb008_proveedor[fe_registro_seniat]',
	value:this.OBJ.fe_registro_seniat,
	allowBlank:false,
	width:100
});

this.nu_registro = new Ext.form.NumberField({
	fieldLabel:'Nu registro',
	name:'tb008_proveedor[nu_registro]',
	value:this.OBJ.nu_registro,
	allowBlank:false
});

this.nu_tomo = new Ext.form.NumberField({
	fieldLabel:'Nu tomo',
	name:'tb008_proveedor[nu_tomo]',
	value:this.OBJ.nu_tomo,
	allowBlank:false
});

this.nu_capital_suscrito = new Ext.form.NumberField({
	fieldLabel:'Nu capital suscrito',
	name:'tb008_proveedor[nu_capital_suscrito]',
	value:this.OBJ.nu_capital_suscrito,
	allowBlank:false
});

this.nu_capital_pagado = new Ext.form.NumberField({
	fieldLabel:'Nu capital pagado',
	name:'tb008_proveedor[nu_capital_pagado]',
	value:this.OBJ.nu_capital_pagado,
	allowBlank:false
});

this.tx_observacion = new Ext.form.TextField({
	fieldLabel:'Tx observacion',
	name:'tb008_proveedor[tx_observacion]',
	value:this.OBJ.tx_observacion,
	allowBlank:false,
	width:200
});

this.co_iva_retencion = new Ext.form.ComboBox({
	fieldLabel:'Co iva retencion',
	store: this.storeCO_IVA_RETENCION,
	typeAhead: true,
	valueField: 'co_iva_retencion',
	displayField:'co_iva_retencion',
	hiddenName:'tb008_proveedor[co_iva_retencion]',
	//readOnly:(this.OBJ.co_iva_retencion!='')?true:false,
	//style:(this.main.OBJ.co_iva_retencion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_iva_retencion',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_IVA_RETENCION.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_iva_retencion,
	value:  this.OBJ.co_iva_retencion,
	objStore: this.storeCO_IVA_RETENCION
});

this.tx_cuenta_contable = new Ext.form.TextField({
	fieldLabel:'Tx cuenta contable',
	name:'tb008_proveedor[tx_cuenta_contable]',
	value:this.OBJ.tx_cuenta_contable,
	allowBlank:false,
	width:200
});

this.nu_codigo = new Ext.form.TextField({
	fieldLabel:'Nu codigo',
	name:'tb008_proveedor[nu_codigo]',
	value:this.OBJ.nu_codigo,
	allowBlank:false,
	width:200
});

this.in_rrhh = new Ext.form.Checkbox({
	fieldLabel:'In rrhh',
	name:'tb008_proveedor[in_rrhh]',
	checked:(this.OBJ.in_rrhh=='0') ? true:false,
	allowBlank:false
});

this.co_cuenta_orden_pasivo = new Ext.form.NumberField({
	fieldLabel:'Co cuenta orden pasivo',
	name:'tb008_proveedor[co_cuenta_orden_pasivo]',
	value:this.OBJ.co_cuenta_orden_pasivo,
	allowBlank:false
});

this.co_cuenta_orden_activo = new Ext.form.NumberField({
	fieldLabel:'Co cuenta orden activo',
	name:'tb008_proveedor[co_cuenta_orden_activo]',
	value:this.OBJ.co_cuenta_orden_activo,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ProveedorEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
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

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_proveedor,
                    this.tx_razon_social,
                    this.co_documento,
                    this.tx_siglas,
                    this.tx_rif,
                    this.tx_nit,
                    this.tx_direccion,
                    this.co_estado,
                    this.co_municipio,
                    this.co_clasificacion,
                    this.tx_email,
                    this.tx_sitio_web,
                    this.nb_representante_legal,
                    this.nu_cedula_representante,
                    this.tx_num_celular,
                    this.nu_dia_credito,
                    this.fe_registro,
                    this.co_cuenta_contable,
                    this.fe_vencimiento,
                    this.nu_cuenta_bancaria,
                    this.co_banco,
                    this.co_tipo_residencia,
                    this.co_tipo_proveedor,
                    this.co_tipo_retencion,
                    this.tx_registro,
                    this.fe_registro_seniat,
                    this.nu_registro,
                    this.nu_tomo,
                    this.nu_capital_suscrito,
                    this.nu_capital_pagado,
                    this.tx_observacion,
                    this.co_iva_retencion,
                    this.tx_cuenta_contable,
                    this.nu_codigo,
                    this.in_rrhh,
                    this.co_cuenta_orden_pasivo,
                    this.co_cuenta_orden_activo,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Proveedor',
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
ProveedorLista.main.mascara.hide();
}
,getStoreCO_CLASIFICACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcoclasificacion',
        root:'data',
        fields:[
            {name: 'co_clasificacion'}
            ]
    });
    return this.store;
}
,getStoreCO_CUENTA_CONTABLE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcocuentacontable',
        root:'data',
        fields:[
            {name: 'co_cuenta_contable'}
            ]
    });
    return this.store;
}
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcobanco',
        root:'data',
        fields:[
            {name: 'co_banco'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_RESIDENCIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcotiporesidencia',
        root:'data',
        fields:[
            {name: 'co_tipo_residencia'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_PROVEEDOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcotipoproveedor',
        root:'data',
        fields:[
            {name: 'co_tipo_proveedor'}
            ]
    });
    return this.store;
}
,getStoreCO_IVA_RETENCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcoivaretencion',
        root:'data',
        fields:[
            {name: 'co_iva_retencion'}
            ]
    });
    return this.store;
}
};
Ext.onReady(ProveedorEditar.main.init, ProveedorEditar.main);
</script>
