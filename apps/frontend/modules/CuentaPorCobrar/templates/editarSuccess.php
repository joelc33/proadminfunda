<script type="text/javascript">
Ext.ns("CuentaPorCobrarEditar");
CuentaPorCobrarEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_FUENTE_INGRESO = this.getStoreCO_FUENTE_INGRESO();
this.storeCO_BANCO = this.getStoreCO_BANCO();
this.storeCO_CUENTA_BANCARIA = this.getStoreCO_CUENTA_BANCARIA();

//<ClavePrimaria>
this.co_cuenta_por_cobrar = new Ext.form.Hidden({
    name:'co_cuenta_por_cobrar',
    value:this.OBJ.co_cuenta_por_cobrar});
//</ClavePrimaria>

this.co_solicitud = new Ext.form.Hidden({
    name:'tb125_cuenta_por_cobrar[co_solicitud]',
    value:this.OBJ.co_solicitud
});

this.co_fuente_ingreso = new Ext.form.ComboBox({
	fieldLabel:'Fuente Ingreso',
	store: this.storeCO_FUENTE_INGRESO,
	typeAhead: true,
	valueField: 'co_fuente_ingreso',
	displayField:'tx_fuente_ingreso',
	hiddenName:'tb125_cuenta_por_cobrar[co_fuente_ingreso]',
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	allowBlank:false
});
this.storeCO_FUENTE_INGRESO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_fuente_ingreso,
	value:  this.OBJ.co_fuente_ingreso,
	objStore: this.storeCO_FUENTE_INGRESO
});

this.tx_referencia = new Ext.form.TextField({
	fieldLabel:'Referencia',
	name:'tb125_cuenta_por_cobrar[tx_referencia]',
	value:this.OBJ.tx_referencia,
	allowBlank:false,
	width:200
});

this.mo_ingreso = new Ext.form.NumberField({
	fieldLabel:'Monto de Ingreso',
	name:'tb125_cuenta_por_cobrar[mo_ingreso]',
	value:this.OBJ.mo_ingreso,
	allowBlank:false,
	width:200
});

this.tx_descripcion = new Ext.form.TextArea({
	fieldLabel:'Descripcion',
	name:'tb125_cuenta_por_cobrar[tx_descripcion]',
	value:this.OBJ.tx_descripcion,
	allowBlank:false,
	width:400
});

this.fe_registro = new Ext.form.DateField({
	fieldLabel:'Fecha',
	name:'tb125_cuenta_por_cobrar[fe_registro]',
	value:this.OBJ.fe_registro,
	allowBlank:false,
	width:100
});

 
this.co_banco = new Ext.form.ComboBox({
	fieldLabel:'Banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'tx_banco',
	hiddenName:'tb125_cuenta_por_cobrar[co_banco]',
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeCO_BANCO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_banco,
	value:  this.OBJ.co_banco,
	objStore: this.storeCO_BANCO
});

this.co_cuenta_bancaria = new Ext.form.ComboBox({
	fieldLabel:'Cuenta Bancaria',
	store: this.storeCO_CUENTA_BANCARIA,
	typeAhead: true,
	valueField: 'co_cuenta_bancaria',
	displayField:'tx_cuenta_bancaria',
	hiddenName:'tb125_cuenta_por_cobrar[co_cuenta_bancaria]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeCO_CUENTA_BANCARIA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_cuenta_bancaria,
	value:  this.OBJ.co_cuenta_bancaria,
	objStore: this.storeCO_CUENTA_BANCARIA
});


this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!CuentaPorCobrarEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        CuentaPorCobrarEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrar/guardar',
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
//                 CuentaPorCobrarLista.main.store_lista.load();
                 CuentaPorCobrarEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        CuentaPorCobrarEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_cuenta_por_cobrar,
                    this.co_solicitud,
                    this.co_fuente_ingreso,
                    this.tx_referencia,
                    this.mo_ingreso,
                    this.tx_descripcion,
                    this.fe_registro,
                    this.co_banco,
                    this.co_cuenta_bancaria
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Cuenta por Cobrar',
    modal:true,
    constrain:true,
    width:600,
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
}
,getStoreCO_FUENTE_INGRESO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrar/storefkcofuenteingreso',
        root:'data',
        fields:[
            {name: 'co_fuente_ingreso'},
            {name: 'tx_fuente_ingreso'}
            ]
    });
    return this.store;
}
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrar/storefkcobanco',
        root:'data',
        fields:[
            {name: 'co_banco'},
            {name: 'tx_banco'}
            ]
    });
    return this.store;
}
,getStoreCO_CUENTA_BANCARIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrar/storefkcocuentabancaria',
        root:'data',
        fields:[
            {name: 'co_cuenta_bancaria'},
            {name: 'tx_cuenta_bancaria'}
            ]
    });
    return this.store;
}
};
Ext.onReady(CuentaPorCobrarEditar.main.init, CuentaPorCobrarEditar.main);
</script>
