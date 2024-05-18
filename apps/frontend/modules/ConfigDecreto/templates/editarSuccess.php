<script type="text/javascript">
Ext.ns("ConfigDecretoEditar");
ConfigDecretoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_FUENTE_FINANCIAMIENTO = this.getStoreCO_FUENTE_FINANCIAMIENTO();

this.storeCO_TIPO_FINANCIAMIENTO = this.getStoreCO_TIPO_FINANCIAMIENTO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_USUARIO = this.getStoreCO_USUARIO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ANIO_FISCAL = this.getStoreCO_ANIO_FISCAL();
//<Stores de fk>

//<ClavePrimaria>
this.co_numero_fuente = new Ext.form.Hidden({
    name:'co_numero_fuente',
    value:this.OBJ.co_numero_fuente});
//</ClavePrimaria>


this.co_fuente_financiamiento = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Financiamiento',
	store: this.storeCO_FUENTE_FINANCIAMIENTO,
	typeAhead: true,
	valueField: 'co_fuente_financiamiento',
	displayField:'tx_fuente_financiamiento',
	hiddenName:'tb068_numero_fuente_financiamiento[co_fuente_financiamiento]',
	//readOnly:(this.OBJ.co_fuente_financiamiento!='')?true:false,
	//style:(this.main.OBJ.co_fuente_financiamiento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Fuente Financiamiento',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_FUENTE_FINANCIAMIENTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_fuente_financiamiento,
	value:  this.OBJ.co_fuente_financiamiento,
	objStore: this.storeCO_FUENTE_FINANCIAMIENTO
});

this.tx_numero_fuente = new Ext.form.TextField({
	fieldLabel:'N° Decreto',
	name:'tb068_numero_fuente_financiamiento[tx_numero_fuente]',
	value:this.OBJ.tx_numero_fuente,
	allowBlank:false,
	width:200
});


this.co_tipo_fuente_financiamiento = new Ext.form.ComboBox({
	fieldLabel:'Fuente Financiamiento',
	store: this.storeCO_TIPO_FINANCIAMIENTO,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_tipo_fuente_financiamiento',
	hiddenName:'tb068_numero_fuente_financiamiento[co_tipo_fuente_financiamiento]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Fuente Financiamiento',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	allowBlank:false
});
this.storeCO_TIPO_FINANCIAMIENTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tipo_fuente_financiamiento,
	value:  this.OBJ.co_tipo_fuente_financiamiento,
	objStore: this.storeCO_TIPO_FINANCIAMIENTO
});

this.id_tb013_anio_fiscal = new Ext.form.ComboBox({
	fieldLabel:'Ejercicio Fiscal',
	store: this.storeCO_ANIO_FISCAL,
	typeAhead: true,
	valueField: 'co_anio_fiscal',
	displayField:'co_anio_fiscal',
	hiddenName:'tb068_numero_fuente_financiamiento[id_tb013_anio_fiscal]',
	//readOnly:(this.OBJ.id_tb013_anio_fiscal!='')?true:false,
	//style:(this.main.OBJ.id_tb013_anio_fiscal!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Ejercicio Fiscal',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ANIO_FISCAL.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb013_anio_fiscal,
	value:  this.OBJ.id_tb013_anio_fiscal,
	objStore: this.storeCO_ANIO_FISCAL
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConfigDecretoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfigDecretoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigDecreto/guardar',
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
                 ConfigDecretoLista.main.store_lista.load();
                 ConfigDecretoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigDecretoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:700,
    labelWidth: 140,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_numero_fuente,
                    this.co_fuente_financiamiento,
                    this.co_tipo_fuente_financiamiento,
                    this.tx_numero_fuente,
                    this.id_tb013_anio_fiscal,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Decreto',
    modal:true,
    constrain:true,
width:700,
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
ConfigDecretoLista.main.mascara.hide();
}
,getStoreCO_FUENTE_FINANCIAMIENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigDecreto/storefkcofuentefinanciamiento',
        root:'data',
        fields:[
            {name: 'co_fuente_financiamiento'},
            {name: 'tx_fuente_financiamiento'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_FINANCIAMIENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigDecreto/storefkcotipofuentefinanciamiento',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_tipo_fuente_financiamiento'}
            ]
    });
    return this.store;
}
,getStoreCO_USUARIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigDecreto/storefkcousuario',
        root:'data',
        fields:[
            {name: 'co_usuario'}
            ]
    });
    return this.store;
}
,getStoreCO_ANIO_FISCAL:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigDecreto/storefkidtb013aniofiscal',
        root:'data',
        fields:[
            {name: 'co_anio_fiscal'}
            ]
    });
    return this.store;
}
};
Ext.onReady(ConfigDecretoEditar.main.init, ConfigDecretoEditar.main);
</script>
