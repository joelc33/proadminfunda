<script type="text/javascript">
Ext.ns("consignacionChequeEditar");
consignacionChequeEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CUENTA_BANCARIA = this.getStoreCO_CUENTA_BANCARIA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CHEQUERA = this.getStoreCO_CHEQUERA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CHEQUE = this.getStoreCO_CHEQUE();
//<Stores de fk>
//<Stores de fk>
this.storeID_SUBTIPODOCUMENTO = this.getStoreID_SUBTIPODOCUMENTO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ESTADO = this.getStoreCO_ESTADO();

//<ClavePrimaria>
this.co_consignacion_cheque = new Ext.form.Hidden({
    name:'co_consignacion_cheque',
    value:this.OBJ.co_consignacion_cheque});
//</ClavePrimaria>

this.co_solicitud = new Ext.form.Hidden({
    name:'tb203_consignacion_cheque[co_solicitud]',
    value:this.OBJ.co_solicitud});

this.co_banco = new Ext.form.ComboBox({
	fieldLabel:'Banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'tx_banco',
	hiddenName:'tb203_consignacion_cheque[co_banco]',
	//readOnly:(this.OBJ.co_banco!='')?true:false,
	//style:(this.main.OBJ.co_banco!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Banco',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false,
	onSelect: function(record){
		consignacionChequeEditar.main.co_cuenta_bancaria.clearValue();
		consignacionChequeEditar.main.co_chequera.clearValue();
		consignacionChequeEditar.main.co_cheque.clearValue();
        consignacionChequeEditar.main.co_banco.setValue(record.data.co_banco);
		consignacionChequeEditar.main.storeCO_CUENTA_BANCARIA.load({
			params: {
				co_banco:record.data.co_banco
			}
		});
        this.collapse();
    }
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
	hiddenName:'tb203_consignacion_cheque[co_cuenta_bancaria]',
	//readOnly:(this.OBJ.co_cuenta_bancaria!='')?true:false,
	//style:(this.main.OBJ.co_cuenta_bancaria!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Cuenta Bancaria',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false,
	onSelect: function(record){
		consignacionChequeEditar.main.co_chequera.clearValue();
		consignacionChequeEditar.main.co_cheque.clearValue();
        consignacionChequeEditar.main.co_cuenta_bancaria.setValue(record.data.co_cuenta_bancaria);
		consignacionChequeEditar.main.storeCO_CHEQUERA.load({
			params: {
				co_cuenta_bancaria:record.data.co_cuenta_bancaria
			}
		});
        this.collapse();
    }
});
/*this.storeCO_CUENTA_BANCARIA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_cuenta_bancaria,
	value:  this.OBJ.co_cuenta_bancaria,
	objStore: this.storeCO_CUENTA_BANCARIA
});*/

if(this.OBJ.co_banco){
  	this.storeCO_CUENTA_BANCARIA.load({
		params: {
			co_banco:this.OBJ.co_banco
		},
		callback: function(){
			consignacionChequeEditar.main.co_cuenta_bancaria.setValue(consignacionChequeEditar.main.OBJ.co_cuenta_bancaria);
		}
	});

}

this.co_chequera = new Ext.form.ComboBox({
	fieldLabel:'Chequera',
	store: this.storeCO_CHEQUERA,
	typeAhead: true,
	valueField: 'co_chequera',
	displayField:'chequera',
	hiddenName:'tb203_consignacion_cheque[co_chequera]',
	//readOnly:(this.OBJ.co_chequera!='')?true:false,
	//style:(this.main.OBJ.co_chequera!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Chequera',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false,
	onSelect: function(record){
		consignacionChequeEditar.main.co_cheque.clearValue();
        consignacionChequeEditar.main.co_chequera.setValue(record.data.co_chequera);
		consignacionChequeEditar.main.storeCO_CHEQUE.load({
			params: {
				co_chequera:record.data.co_chequera
			}
		});
        this.collapse();
    }
});
/*this.storeCO_CHEQUERA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_chequera,
	value:  this.OBJ.co_chequera,
	objStore: this.storeCO_CHEQUERA
});*/

if(this.OBJ.co_cuenta_bancaria){
  	this.storeCO_CHEQUERA.load({
		params: {
			co_cuenta_bancaria:this.OBJ.co_cuenta_bancaria
		},
		callback: function(){
			consignacionChequeEditar.main.co_chequera.setValue(consignacionChequeEditar.main.OBJ.co_chequera);
		}
	});

}

this.co_cheque = new Ext.form.ComboBox({
	fieldLabel:'Cheque',
	store: this.storeCO_CHEQUE,
	typeAhead: true,
	valueField: 'co_cheque',
	displayField:'tx_descripcion',
	hiddenName:'tb203_consignacion_cheque[co_cheque]',
	//readOnly:(this.OBJ.co_cheque!='')?true:false,
	//style:(this.main.OBJ.co_cheque!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Cheque',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
/*this.storeCO_CHEQUE.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_cheque,
	value:  this.OBJ.co_cheque,
	objStore: this.storeCO_CHEQUE
});*/
if(this.OBJ.co_chequera){
  	this.storeCO_CHEQUE.load({
		params: {
			co_chequera:this.OBJ.co_chequera
		},
		callback: function(){
			consignacionChequeEditar.main.co_cheque.setValue(consignacionChequeEditar.main.OBJ.co_cheque);
		}
	});

}

this.nb_titular = new Ext.form.TextField({
	fieldLabel:'Titular',
	name:'tb203_consignacion_cheque[nb_titular]',
	value:this.OBJ.nb_titular,
	allowBlank:false,
	width:200,
	listeners:{
		change: function(){
			this.setValue(String(this.getValue()).toUpperCase());
		}
	}
});

this.mo_cheque = new Ext.form.NumberField({
	fieldLabel:'Monto',
	name:'tb203_consignacion_cheque[mo_cheque]',
	value:this.OBJ.mo_cheque,
	allowBlank:false,
	width:200
});

this.fe_pago = new Ext.form.DateField({
	fieldLabel:'Fecha',
	name:'tb203_consignacion_cheque[fe_pago]',
	value:this.OBJ.fe_pago,
	allowBlank:false,
	width:100
});

this.id_tb156_subtipo_documento = new Ext.form.ComboBox({
	fieldLabel:'Sub-Tipo',
	store: this.storeID_SUBTIPODOCUMENTO,
	typeAhead: true,
	valueField: 'id',
	displayField:'descripcion',
	hiddenName:'tb203_consignacion_cheque[id_tb156_subtipo_documento]',
	//readOnly:(this.OBJ.id_tb156_subtipo_documento!='')?true:false,
	//style:(this.main.OBJ.id_tb156_subtipo_documento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Sub-Tipo Documento...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});

this.storeID_SUBTIPODOCUMENTO.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb156_subtipo_documento,
	value:  this.OBJ.id_tb156_subtipo_documento,
	objStore: this.storeID_SUBTIPODOCUMENTO
});

this.co_estado_cheque = new Ext.form.ComboBox({
	fieldLabel:'Estado',
	store: this.storeCO_ESTADO,
	typeAhead: true,
	valueField: 'co_estado_cheque',
	displayField:'tx_estado_cheque',
	hiddenName:'tb203_consignacion_cheque[co_estado_cheque]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Estado',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	allowBlank:false
});
this.storeCO_ESTADO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_estado_cheque,
	value:  this.OBJ.co_estado_cheque,
	objStore: this.storeCO_ESTADO
});

this.tx_observacion = new Ext.form.TextArea({
	fieldLabel:'Observacion',
	name:'tb203_consignacion_cheque[tx_observacion]',
	value:this.OBJ.tx_observacion,
    width:400,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!consignacionChequeEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        consignacionChequeEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/anularCheque/guardar',
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
                 consignacionChequeLista.main.store_lista.load();
                 consignacionChequeEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        consignacionChequeEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_consignacion_cheque,
                    this.co_solicitud,
					this.id_tb156_subtipo_documento,
                    this.co_banco,
                    this.co_cuenta_bancaria,
                    this.co_chequera,
                    this.co_cheque,
                    this.nb_titular,
                    this.mo_cheque,
					this.fe_pago,
					this.co_estado_cheque,
					this.tx_observacion
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Anulación de Cheque',
    modal:true,
    constrain:true,
width:614,
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
consignacionChequeLista.main.mascara.hide();
}
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/anularCheque/storefkcobanco',
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
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/anularCheque/storefkcocuentabancaria',
        root:'data',
        fields:[
            {name: 'co_cuenta_bancaria'},
			{name: 'tx_cuenta_bancaria'}
            ]
    });
    return this.store;
}
,getStoreCO_CHEQUERA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/anularCheque/storefkcochequera',
        root:'data',
        fields:[
            {name: 'co_chequera'},
			{name: 'tx_descripcion'},
			{
				name: 'chequera',
				convert: function(v, r) {
						return r.tx_descripcion + ' ( ' + r.nro_inicial + ' - ' + r.nro_final + ' ) ';
				}
			},
            ]
    });
    return this.store;
}
,getStoreCO_CHEQUE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/anularCheque/storefkcocheque',
        root:'data',
        fields:[
            {name: 'co_cheque'},
			{name: 'tx_descripcion'}
            ]
    });
    return this.store;
}
,getStoreID_SUBTIPODOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/anularCheque/storefkidtb156subtipodocumento',
        root:'data',
        fields:[
            {name: 'id'},
			{name: 'nu_subtipo_documento'},
			{name: 'de_subtipo_documento'},
			{name: 'descripcion',
              convert:function(v,r){
                return r.nu_subtipo_documento+' - '+r.de_subtipo_documento;
              }
            }
            ]
    });
    return this.store;
}
,getStoreCO_ESTADO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/anularCheque/storefkcoestadocheque',
        root:'data',
        fields:[
            {name: 'co_estado_cheque'},{name: 'tx_estado_cheque'}
            ]
    });
    return this.store;
}
};
Ext.onReady(consignacionChequeEditar.main.init, consignacionChequeEditar.main);
</script>
