<script type="text/javascript">
Ext.ns("RetencionesEditar");
RetencionesEditar.main = {
init:function(){ 

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_RETENCION = this.getStoreCO_TIPO_RETENCION();
//<Stores de fk>
//<Stores de fk>
this.storeCO_RAMO = this.getStoreCO_RAMO();
//<Stores de fk>

//<ClavePrimaria>
this.co_retencion = new Ext.form.Hidden({
    name:'co_retencion',
    value:this.OBJ.co_retencion});
//</ClavePrimaria>

//this.co_ramo = new Ext.form.Hidden({
//    name:'tb042_retencion[co_ramo]',
//    value:this.OBJ.co_ramo
//});

this.co_tipo_retencion = new Ext.form.Hidden({
    name:'tb042_retencion[co_tipo_retencion]',
    value:this.OBJ.co_tipo_retencion
});


this.co_ramo = new Ext.form.ComboBox({
	fieldLabel:'Ramo Proveedor',
	store: this.storeCO_RAMO,
	typeAhead: true,
	valueField: 'co_ramo',
	displayField:'tx_ramo',
	hiddenName:'tb042_retencion[co_ramo]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione ramo proveedor',
	selectOnFocus: true,
	mode: 'local',
	width:230
});
this.storeCO_RAMO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_ramo,
	value:  this.OBJ.co_ramo,
	objStore: this.storeCO_RAMO
});

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Tipo Proveedor',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'tx_documento',
	hiddenName:'tb042_retencion[co_documento]',
	//readOnly:(this.OBJ.co_documento!='')?true:false,
	//style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_documento',
	selectOnFocus: true,
	mode: 'local',
	width:130,
	resizable:true,
	allowBlank:false
});
this.storeCO_DOCUMENTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_documento,
	value:  this.OBJ.co_documento,
	objStore: this.storeCO_DOCUMENTO
});


this.nu_valor = new Ext.form.NumberField({
	fieldLabel:'% Retención',
	name:'tb042_retencion[nu_valor]',
	value:this.OBJ.nu_valor,
        width:50,
	allowBlank:false
});

this.mo_minimo = new Ext.form.NumberField({
	fieldLabel:'Monto Mínimo',
	name:'tb042_retencion[mo_minimo]',
        width:80,
	value:this.OBJ.mo_minimo
});

this.de_concepto = new Ext.form.TextArea({
	fieldLabel:'Concepto',
	name:'tb042_retencion[de_concepto]',
	value:this.OBJ.de_concepto,
	allowBlank:false,
	width:350
});

this.nu_concepto = new Ext.form.TextField({
	fieldLabel:'N° Concepto',
	name:'tb042_retencion[nu_concepto]',
	value:this.OBJ.nu_concepto,
	allowBlank:false,
	width:100
});

this.nu_sustraendo = new Ext.form.NumberField({
	fieldLabel:'Sustraendo',
	name:'tb042_retencion[nu_sustraendo]',
	value:this.OBJ.nu_sustraendo,
	allowBlank:false,
	width:100
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!RetencionesEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        RetencionesEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Retenciones/guardar',
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
                 RetencionesLista.main.store_lista.load();
                 RetencionesEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        RetencionesEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:500,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_retencion,
                    this.co_ramo,
                    this.co_documento,
                    this.co_tipo_retencion,
                    this.nu_valor,
                    this.mo_minimo,
                    this.de_concepto,
                    this.nu_concepto,
                    this.nu_sustraendo
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Retenciones',
    modal:true,
    constrain:true,
    width:514,
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
RetencionesLista.main.mascara.hide();
}
,getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Retenciones/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'},
            {name: 'tx_documento'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_RETENCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Retenciones/storefkcotiporetencion',
        root:'data',
        fields:[
            {name: 'co_tipo_retencion'}
            ]
    });
    return this.store;
}
,getStoreCO_RAMO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Retenciones/storefkcoramo',
        root:'data',
        fields:[
            {name: 'co_ramo'},
            {name: 'tx_ramo'}
            ]
    });
    return this.store;
}
};
Ext.onReady(RetencionesEditar.main.init, RetencionesEditar.main);
</script>
