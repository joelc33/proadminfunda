<script type="text/javascript">
Ext.ns("TipoRetencionEditar");
TipoRetencionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_CUENTA_CONTABLE = this.getStoreCO_CUENTA_CONTABLE();
//<Stores de fk>

//<ClavePrimaria>
this.co_tipo_retencion = new Ext.form.Hidden({
    name:'co_tipo_retencion',
    value:this.OBJ.co_tipo_retencion});
//</ClavePrimaria>


this.tx_tipo_retencion = new Ext.form.TextField({
	fieldLabel:'Tx tipo retencion',
	name:'tb041_tipo_retencion[tx_tipo_retencion]',
	value:this.OBJ.tx_tipo_retencion,
	allowBlank:false,
	width:200
});

this.co_cuenta_contable = new Ext.form.ComboBox({
	fieldLabel:'Co cuenta contable',
	store: this.storeCO_CUENTA_CONTABLE,
	typeAhead: true,
	valueField: 'co_cuenta_contable',
	displayField:'co_cuenta_contable',
	hiddenName:'tb041_tipo_retencion[co_cuenta_contable]',
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

this.co_clase_retencion = new Ext.form.NumberField({
	fieldLabel:'Co clase retencion',
	name:'tb041_tipo_retencion[co_clase_retencion]',
	value:this.OBJ.co_clase_retencion,
	allowBlank:false
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tb041_tipo_retencion[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.nu_cuenta_pagar = new Ext.form.TextField({
	fieldLabel:'Nu cuenta pagar',
	name:'tb041_tipo_retencion[nu_cuenta_pagar]',
	value:this.OBJ.nu_cuenta_pagar,
	allowBlank:false,
	width:200
});

this.nu_cuenta_tercero = new Ext.form.TextField({
	fieldLabel:'Nu cuenta tercero',
	name:'tb041_tipo_retencion[nu_cuenta_tercero]',
	value:this.OBJ.nu_cuenta_tercero,
	allowBlank:false,
	width:200
});

this.co_cuenta_tercero = new Ext.form.NumberField({
	fieldLabel:'Co cuenta tercero',
	name:'tb041_tipo_retencion[co_cuenta_tercero]',
	value:this.OBJ.co_cuenta_tercero,
	allowBlank:false
});

this.tx_movimiento = new Ext.form.TextField({
	fieldLabel:'Tx movimiento',
	name:'tb041_tipo_retencion[tx_movimiento]',
	value:this.OBJ.tx_movimiento,
	allowBlank:false,
	width:200
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
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_tipo_retencion,
                    this.tx_tipo_retencion,
                    this.co_cuenta_contable,
                    this.co_clase_retencion,
                    this.in_activo,
                    this.nu_cuenta_pagar,
                    this.nu_cuenta_tercero,
                    this.co_cuenta_tercero,
                    this.tx_movimiento,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: TipoRetencion',
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
TipoRetencionLista.main.mascara.hide();
}
,getStoreCO_CUENTA_CONTABLE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/storefkcocuentacontable',
        root:'data',
        fields:[
            {name: 'co_cuenta_contable'}
            ]
    });
    return this.store;
}
};
Ext.onReady(TipoRetencionEditar.main.init, TipoRetencionEditar.main);
</script>
