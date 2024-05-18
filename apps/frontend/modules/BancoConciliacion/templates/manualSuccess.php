<script type="text/javascript">
Ext.ns("BancoConciliacionEditar");
BancoConciliacionEditar.main = {
init:function(){
 
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CUENTA_BANCARIA = this.getStoreCO_CUENTA_BANCARIA();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.id_tb010_banco = new Ext.form.ComboBox({
	fieldLabel:'Id tb010 banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'co_banco',
	hiddenName:'tb104_banco_conciliacion[id_tb010_banco]',
	//readOnly:(this.OBJ.id_tb010_banco!='')?true:false,
	//style:(this.main.OBJ.id_tb010_banco!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb010_banco',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_BANCO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb010_banco,
	value:  this.OBJ.id_tb010_banco,
	objStore: this.storeCO_BANCO
});

this.id_tb011_cuenta_bancaria = new Ext.form.ComboBox({
	fieldLabel:'Id tb011 cuenta bancaria',
	store: this.storeCO_CUENTA_BANCARIA,
	typeAhead: true,
	valueField: 'co_cuenta_bancaria',
	displayField:'co_cuenta_bancaria',
	hiddenName:'tb104_banco_conciliacion[id_tb011_cuenta_bancaria]',
	//readOnly:(this.OBJ.id_tb011_cuenta_bancaria!='')?true:false,
	//style:(this.main.OBJ.id_tb011_cuenta_bancaria!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb011_cuenta_bancaria',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_CUENTA_BANCARIA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb011_cuenta_bancaria,
	value:  this.OBJ.id_tb011_cuenta_bancaria,
	objStore: this.storeCO_CUENTA_BANCARIA
});

this.fe_movimiento = new Ext.form.DateField({
	fieldLabel:'Fe movimiento',
	name:'tb104_banco_conciliacion[fe_movimiento]',
	value:this.OBJ.fe_movimiento,
	allowBlank:false,
	width:100
});

this.de_concepto = new Ext.form.TextField({
	fieldLabel:'De concepto',
	name:'tb104_banco_conciliacion[de_concepto]',
	value:this.OBJ.de_concepto,
	allowBlank:false,
	width:200
});

this.mo_cargo = new Ext.form.NumberField({
	fieldLabel:'Mo cargo',
	name:'tb104_banco_conciliacion[mo_cargo]',
	value:this.OBJ.mo_cargo,
	allowBlank:false
});

this.mo_abono = new Ext.form.NumberField({
	fieldLabel:'Mo abono',
	name:'tb104_banco_conciliacion[mo_abono]',
	value:this.OBJ.mo_abono,
	allowBlank:false
});

this.mo_saldo = new Ext.form.NumberField({
	fieldLabel:'Mo saldo',
	name:'tb104_banco_conciliacion[mo_saldo]',
	value:this.OBJ.mo_saldo,
	allowBlank:false
});

this.id_tb101_tipo_concilacion = new Ext.form.ComboBox({
	fieldLabel:'Id tb101 tipo concilacion',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb104_banco_conciliacion[id_tb101_tipo_concilacion]',
	//readOnly:(this.OBJ.id_tb101_tipo_concilacion!='')?true:false,
	//style:(this.main.OBJ.id_tb101_tipo_concilacion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb101_tipo_concilacion',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb101_tipo_concilacion,
	value:  this.OBJ.id_tb101_tipo_concilacion,
	objStore: this.storeID
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tb104_banco_conciliacion[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tb104_banco_conciliacion[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tb104_banco_conciliacion[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!BancoConciliacionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        BancoConciliacionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/guardar',
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
                 BancoConciliacionLista.main.store_lista.load();
                 BancoConciliacionEditar.main.winformPanel_.close();
             }
        });


    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        BancoConciliacionEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
                    this.id_tb010_banco,
                    this.id_tb011_cuenta_bancaria,
                    this.fe_movimiento,
                    this.de_concepto,
                    this.mo_cargo,
                    this.mo_abono,
                    this.mo_saldo,
                    this.id_tb101_tipo_concilacion,
                    this.in_activo,
                    this.created_at,
                    this.updated_at,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Conciliacion Manual',
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
//BancoConciliacionLista.main.mascara.hide();
}
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/storefkidtb010banco',
        root:'data',
        fields:[
            {name: 'co_banco'}
            ]
    });
    return this.store;
}
,getStoreCO_CUENTA_BANCARIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/storefkidtb011cuentabancaria',
        root:'data',
        fields:[
            {name: 'co_cuenta_bancaria'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/storefkidtb101tipoconcilacion',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
};
Ext.onReady(BancoConciliacionEditar.main.init, BancoConciliacionEditar.main);
</script>
