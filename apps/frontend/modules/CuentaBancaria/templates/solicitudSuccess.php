<script type="text/javascript">
Ext.ns("SolicitudEditar");
SolicitudEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
this.storeCO_CUENTA = this.getStoreCO_CUENTA();

//<ClavePrimaria>
this.co_cuenta_bancaria = new Ext.form.Hidden({
    name:'co_solicitud_cuenta',
    value:this.OBJ.co_solicitud_cuenta});
//</ClavePrimaria>


this.co_solicitud = new Ext.form.Hidden({
    name:'tb033_solicitud_cuenta_contable[co_solicitud]',
    value:this.OBJ.co_solicitud});

/*this.tx_cuenta_bancaria = new Ext.form.NumberField({
	fieldLabel:'N° de Cuenta',
	name:'tb011_cuenta_bancaria[tx_cuenta_bancaria]',
	value:this.OBJ.tx_cuenta_bancaria,
	allowBlank:false,
	width:300
});*/

this.co_banco = new Ext.form.ComboBox({
	fieldLabel:'Banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'tx_banco',
	hiddenName:'tb033_solicitud_cuenta_contable[co_banco]',
	//readOnly:(this.OBJ.co_banco!='')?true:false,
	//style:(this.main.OBJ.co_banco!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false,
	listeners:{
            select: function(){
                SolicitudEditar.main.storeCO_CUENTA.load({
                    params: {co_banco:this.getValue()},
                    callback: function(){
                        SolicitudEditar.main.co_cuenta_bancaria.setValue('');
                    }
                });
            }
        }
        
});
this.storeCO_BANCO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_banco,
	value:  this.OBJ.co_banco,
	objStore: this.storeCO_BANCO
});

this.co_cuenta_bancaria = new Ext.form.ComboBox({
	fieldLabel:'Cuenta',
	store: this.storeCO_CUENTA,
	typeAhead: true,
	valueField: 'co_cuenta_bancaria',
	displayField:'tx_cuenta_bancaria',
	hiddenName:'tb033_solicitud_cuenta_contable[co_cuenta_bancaria]',
	//readOnly:(this.OBJ.co_tipo_cuenta!='')?true:false,
	//style:(this.main.OBJ.co_tipo_cuenta!='')?'background:#c9c9c9;':'',
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

if(this.OBJ.co_cuenta!=''){
       SolicitudEditar.main.storeCO_CUENTA.load({
            params: {co_banco:SolicitudEditar.main.OBJ.co_banco},
            callback: function(){
                SolicitudEditar.main.co_cuenta_bancaria.setValue(SolicitudEditar.main.OBJ.co_cuenta);
            }
        });
}

/*
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
	emptyText:'Seleccione ...',
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

*/

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!SolicitudEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        SolicitudEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/guardarSolicitud',
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
                 
                 Detalle.main.store_lista.baseParams.co_solicitud = action.result.co_solicitud;
                 Detalle.main.store_lista.load();
                 
               
                 SolicitudEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        SolicitudEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:500,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.co_cuenta_bancaria,
           this.co_solicitud,
           this.co_banco,
           this.co_cuenta_bancaria]
});

this.winformPanel_ = new Ext.Window({
    title:'Asignación de Cuenta Bancaria',
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
//CuentaBancariaLista.main.mascara.hide();
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
,getStoreCO_CUENTA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaContable/storefkcocuenta',
        root:'data',
        fields:[
            {name: 'co_cuenta_bancaria'},
            {name: 'tx_cuenta_bancaria'}
            ]
    });
    return this.store;
}
};
Ext.onReady(SolicitudEditar.main.init, SolicitudEditar.main);
</script>
