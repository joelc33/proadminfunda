<script type="text/javascript">
Ext.ns("IvaRetencionEditar");
IvaRetencionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_CUENTA_CONTABLE = this.getStoreCO_CUENTA_CONTABLE();
//<Stores de fk>

//<ClavePrimaria>
this.co_iva_retencion = new Ext.form.Hidden({
    name:'co_iva_retencion',
    value:this.OBJ.co_iva_retencion});

this.nu_valor = new Ext.form.NumberField({
	fieldLabel:'Valor',
	name:'tb044_iva_retencion[nu_valor]',
	value:this.OBJ.nu_valor,
	allowBlank:false
});

this.fe_desde = new Ext.form.DateField({
	fieldLabel:'Fecha Desde',
	name:'tb044_iva_retencion[fe_desde]',
	value:this.OBJ.fe_desde,
	allowBlank:false,
	width:100
});

this.fe_hasta = new Ext.form.DateField({
	fieldLabel:'Fecha Hasta',
	name:'tb044_iva_retencion[fe_hasta]',
	value:this.OBJ.fe_hasta,
	allowBlank:false,
	width:100
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'Activo',
	name:'tb044_iva_retencion[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!IvaRetencionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        IvaRetencionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IvaRetencion/guardar',
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
                 IvaRetencionLista.main.store_lista.load();
                 IvaRetencionEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        IvaRetencionEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_iva_retencion,
                    this.nu_valor,
                    this.fe_desde,
                    this.fe_hasta,
                    this.in_activo
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: IvaRetencion',
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
IvaRetencionLista.main.mascara.hide();
}
,getStoreCO_CUENTA_CONTABLE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IvaRetencion/storefkcocuentacontable',
        root:'data',
        fields:[
            {name: 'co_cuenta_contable'}
            ]
    });
    return this.store;
}
};
Ext.onReady(IvaRetencionEditar.main.init, IvaRetencionEditar.main);
</script>
