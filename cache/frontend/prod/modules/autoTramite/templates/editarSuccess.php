<script type="text/javascript">
Ext.ns("TramiteEditar");
TramiteEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_PROCESO = this.getStoreCO_PROCESO();
//<Stores de fk>

//<ClavePrimaria>
this.co_tipo_solicitud = new Ext.form.Hidden({
    name:'co_tipo_solicitud',
    value:this.OBJ.co_tipo_solicitud});
//</ClavePrimaria>


this.tx_tipo_solicitud = new Ext.form.TextField({
	fieldLabel:'Tx tipo solicitud',
	name:'tb027_tipo_solicitud[tx_tipo_solicitud]',
	value:this.OBJ.tx_tipo_solicitud,
	allowBlank:false,
	width:200
});

this.in_ver = new Ext.form.Checkbox({
	fieldLabel:'In ver',
	name:'tb027_tipo_solicitud[in_ver]',
	checked:(this.OBJ.in_ver=='0') ? true:false,
	allowBlank:false
});

this.co_proceso = new Ext.form.ComboBox({
	fieldLabel:'Co proceso',
	store: this.storeCO_PROCESO,
	typeAhead: true,
	valueField: 'co_proceso',
	displayField:'co_proceso',
	hiddenName:'tb027_tipo_solicitud[co_proceso]',
	//readOnly:(this.OBJ.co_proceso!='')?true:false,
	//style:(this.main.OBJ.co_proceso!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_proceso',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_PROCESO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_proceso,
	value:  this.OBJ.co_proceso,
	objStore: this.storeCO_PROCESO
});

this.id136_tipo_documento = new Ext.form.NumberField({
	fieldLabel:'Id136 tipo documento',
	name:'tb027_tipo_solicitud[id136_tipo_documento]',
	value:this.OBJ.id136_tipo_documento,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!TramiteEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        TramiteEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tramite/guardar',
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
                 TramiteLista.main.store_lista.load();
                 TramiteEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        TramiteEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_tipo_solicitud,
                    this.tx_tipo_solicitud,
                    this.in_ver,
                    this.co_proceso,
                    this.id136_tipo_documento,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Tramite',
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
TramiteLista.main.mascara.hide();
}
,getStoreCO_PROCESO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tramite/storefkcoproceso',
        root:'data',
        fields:[
            {name: 'co_proceso'}
            ]
    });
    return this.store;
}
};
Ext.onReady(TramiteEditar.main.init, TramiteEditar.main);
</script>
