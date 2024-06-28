<script type="text/javascript">
Ext.ns("AgregarCuenta");
AgregarCuenta.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.co_clase_retencion = new Ext.form.Hidden({
    name:'co_clase_retencion',
    value:this.OBJ.co_clase_retencion});

this.co_tipo_retencion = new Ext.form.Hidden({
    name:'co_tipo_retencion',
    value:this.OBJ.co_tipo_retencion});

this.tx_codigo_cuenta = new Ext.form.NumberField({
	fieldLabel:'Cuenta Contable',
	name:'tx_codigo_cuenta',
	allowBlank:false,
	width:200,
        maskRe: /[0-9]/
});



this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!AgregarCuenta.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        AgregarCuenta.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoRetencion/AsignarCuenta',
            waitMsg: 'Enviando datos, por favor espere..',
            waitTitle:'Enviando',
            failure: function(form, action) {
                Ext.MessageBox.alert('Error en transacción', action.result.msg);
            },
            success: function(form, action) {
                 if(action.result.success){
                     Ext.utiles.msg('Mensaje', action.result.msg);
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
                 AgregarCuenta.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
    handler:function(){
        AgregarCuenta.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:700,
    autoHeight:true,  
    autoScroll:true,
   // bodyStyle:'padding:10px;',
    items:[      this.co_tipo_retencion,
                this.co_clase_retencion,
                    this.tx_codigo_cuenta
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Asociar Cuenta Contable',
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
};
Ext.onReady(AgregarCuenta.main.init, AgregarCuenta.main);
</script>
