<script type="text/javascript">
Ext.ns("TipoRetencionEditar");
TipoRetencionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.storeCO_CLASE_RETENCION = this.getStoreCO_CLASE_RETENCION();
//<ClavePrimaria>
this.co_tipo_retencion = new Ext.form.Hidden({
    name:'co_tipo_retencion',
    value:this.OBJ.co_tipo_retencion});
//</ClavePrimaria>

this.co_clase_retencion = new Ext.form.ComboBox({
	fieldLabel:'Clase de Retencion',
	store: this.storeCO_CLASE_RETENCION,
	typeAhead: true,
	valueField: 'co_clase_retencion',
	displayField:'tx_clase_retencion',
	hiddenName:'tb041_tipo_retencion[co_clase_retencion]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'...',
	selectOnFocus: true,
	mode: 'local',
	width:220,
	allowBlank:false
});
this.storeCO_CLASE_RETENCION.load();
paqueteComunJS.funcion.seleccionarComboByCo({
objCMB: this.co_clase_retencion,
value: this.OBJ.co_clase_retencion,
objStore: this.storeCO_CLASE_RETENCION
});
this.tx_tipo_retencion = new Ext.form.TextField({
	fieldLabel:'Tipo de Retención',
	name:'tb041_tipo_retencion[tx_tipo_retencion]',
	value:this.OBJ.tx_tipo_retencion,
	allowBlank:false,
	width:400
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!TipoRetencionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        TipoRetencionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/guardar',
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
                 TipoRetencionLista.main.store_lista.load();
                 TipoRetencionEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        TipoRetencionEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_tipo_retencion,
                    this.co_clase_retencion,
                    this.tx_tipo_retencion,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Tipo de Retención',
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
TipoRetencionLista.main.mascara.hide();
}
,getStoreCO_CLASE_RETENCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/storefkcoclaseretencion',
        root:'data',
        fields:[
            {name: 'co_clase_retencion'},
            {name: 'tx_clase_retencion'}
            ]
    });
    return this.store;
}
};
Ext.onReady(TipoRetencionEditar.main.init, TipoRetencionEditar.main);
</script>
