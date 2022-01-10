<script type="text/javascript">
Ext.ns("IvaFacturaEditar");
IvaFacturaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_iva_factura = new Ext.form.Hidden({
    name:'co_iva_factura',
    value:this.OBJ.co_iva_factura});
//</ClavePrimaria>


this.nu_valor = new Ext.form.NumberField({
	fieldLabel:'Nu valor',
	name:'tb043_iva_factura[nu_valor]',
	value:this.OBJ.nu_valor,
	allowBlank:false
});

this.fe_desde = new Ext.form.DateField({
	fieldLabel:'Fe desde',
	name:'tb043_iva_factura[fe_desde]',
	value:this.OBJ.fe_desde,
	allowBlank:false,
	width:100
});

this.fe_hasta = new Ext.form.DateField({
	fieldLabel:'Fe hasta',
	name:'tb043_iva_factura[fe_hasta]',
	value:this.OBJ.fe_hasta,
	allowBlank:false,
	width:100
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tb043_iva_factura[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!IvaFacturaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        IvaFacturaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IvaFactura/guardar',
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
                 IvaFacturaLista.main.store_lista.load();
                 IvaFacturaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        IvaFacturaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_iva_factura,
                    this.nu_valor,
                    this.fe_desde,
                    this.fe_hasta,
                    this.in_activo,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: IvaFactura',
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
IvaFacturaLista.main.mascara.hide();
}
};
Ext.onReady(IvaFacturaEditar.main.init, IvaFacturaEditar.main);
</script>
