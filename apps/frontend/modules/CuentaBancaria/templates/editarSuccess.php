<script type="text/javascript">
Ext.ns("CuentaBancariaEditar");
CuentaBancariaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_CUENTA = this.getStoreCO_TIPO_CUENTA();
this.storeCO_DESCRIPCION_CUENTA = this.getStoreCO_DESCRIPCION_CUENTA();
//<Stores de fk>

//<ClavePrimaria>
this.co_cuenta_bancaria = new Ext.form.Hidden({
    name:'co_cuenta_bancaria',
    value:this.OBJ.co_cuenta_bancaria});
//</ClavePrimaria>


this.tx_cuenta_bancaria = new Ext.form.TextField({
	fieldLabel:'N° de Cuenta',
	name:'tb011_cuenta_bancaria[tx_cuenta_bancaria]',
	value:this.OBJ.tx_cuenta_bancaria,
	allowBlank:false,
        maxLength:20,
        minLength:20,
	width:300
});

this.co_banco = new Ext.form.ComboBox({
	fieldLabel:'Banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'tx_banco',
	hiddenName:'tb011_cuenta_bancaria[co_banco]',
	//readOnly:(this.OBJ.co_banco!='')?true:false,
	//style:(this.main.OBJ.co_banco!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_banco',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false
});
this.storeCO_BANCO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_banco,
	value:  this.OBJ.co_banco,
	objStore: this.storeCO_BANCO
});

this.co_tipo_cuenta = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Cuenta',
	store: this.storeCO_TIPO_CUENTA,
	typeAhead: true,
	valueField: 'co_tipo_cuenta',
	displayField:'tx_tipo_cuenta',
	hiddenName:'tb011_cuenta_bancaria[co_tipo_cuenta]',
	//readOnly:(this.OBJ.co_tipo_cuenta!='')?true:false,
	//style:(this.main.OBJ.co_tipo_cuenta!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_cuenta',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_CUENTA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tipo_cuenta,
	value:  this.OBJ.co_tipo_cuenta,
	objStore: this.storeCO_TIPO_CUENTA
});

this.co_descripcion_cuenta = new Ext.form.ComboBox({
	fieldLabel:'Descripción',
	store: this.storeCO_DESCRIPCION_CUENTA,
	typeAhead: true,
	valueField: 'co_descripcion_cuenta',
	displayField:'tx_descripcion_cuenta',
	hiddenName:'tb011_cuenta_bancaria[co_descripcion_cuenta]',
	//readOnly:(this.OBJ.co_tipo_cuenta!='')?true:false,
	//style:(this.main.OBJ.co_tipo_cuenta!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Descripción...',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	allowBlank:false
});
this.storeCO_DESCRIPCION_CUENTA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_descripcion_cuenta,
	value:  this.OBJ.co_descripcion_cuenta,
	objStore: this.storeCO_DESCRIPCION_CUENTA
});

this.nu_contrato = new Ext.form.NumberField({
	fieldLabel:'N° Contrato',
	name:'tb011_cuenta_bancaria[nu_contrato]',
	value:this.OBJ.nu_contrato,
	allowBlank:false,
	width:200
});

this.mo_disponible = new Ext.form.NumberField({
	fieldLabel:'Monto Disponible',
	name:'tb011_cuenta_bancaria[mo_disponible]',
	value:this.OBJ.mo_disponible,
	allowBlank:false,
	width:200
});

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Definicion',
	name:'tb011_cuenta_bancaria[tx_descripcion]',
	value:this.OBJ.tx_descripcion,
	allowBlank:false,
	width:300
});

this.tx_codigo_cuenta = new Ext.form.TextField({
	fieldLabel:'Cuenta Contable',
	name:'tx_codigo_cuenta',
	allowBlank:false,
	width:200,
        maskRe: /[0-9]/
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!CuentaBancariaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        CuentaBancariaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/guardar',
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
                 CuentaBancariaLista.main.store_lista.load();
                 CuentaBancariaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        CuentaBancariaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:500,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_cuenta_bancaria,
                    this.co_banco,
                    this.tx_cuenta_bancaria,
                    this.co_tipo_cuenta,
                    this.co_descripcion_cuenta,
                    this.nu_contrato,
                    this.tx_descripcion,
                    this.tx_codigo_cuenta
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Cuenta Bancaria',
    modal:true,
    constrain:true,
    width:500,
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
CuentaBancariaLista.main.mascara.hide();
}
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/storefkcobanco',
        root:'data',
        fields:[
            {name: 'co_banco'},
            {name: 'tx_banco'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_CUENTA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/storefkcotipocuenta',
        root:'data',
        fields:[
            {name: 'co_tipo_cuenta'},
            {name: 'tx_tipo_cuenta'}
            ]
    });
    return this.store;
}
,getStoreCO_DESCRIPCION_CUENTA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/storefkcodescripcioncuenta',
        root:'data',
        fields:[
            {name: 'co_descripcion_cuenta'},
            {name: 'tx_descripcion_cuenta'}
            ]
    });
    return this.store;
}
};
Ext.onReady(CuentaBancariaEditar.main.init, CuentaBancariaEditar.main);
</script>
