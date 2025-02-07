<script type="text/javascript">
Ext.ns("CuentaPorCobrarCreditoDetalleEditar");
CuentaPorCobrarCreditoDetalleEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>

//<ClavePrimaria>
this.id_tb142_cuenta_cobrar = new Ext.form.Hidden({
    name:'tb145_cuenta_cobrar_detalle[id_tb142_cuenta_cobrar]',
    value:this.OBJ.id_tb142_cuenta_cobrar});
//</ClavePrimaria>
this.mo_disponible = new Ext.form.Hidden({
    name:'tb145_cuenta_cobrar_detalle[mo_disponible]',
    value:this.OBJ.mo_disponible
});

this.de_cuota = new Ext.form.TextArea({
	fieldLabel:'Descripcion',
	name:'tb145_cuenta_cobrar_detalle[de_cuota]',
	value:this.OBJ.de_cuota,
	allowBlank:false,
	width:400,
        listeners: {
        change: function(field, newValue, oldValue) {
        field.setValue(newValue.toUpperCase());
    }
}         
});

this.disponibilidad = new Ext.form.NumberField({
	fieldLabel:'Monto Disponible',
	name:'tb145_cuenta_cobrar_detalle[mo_disponible]',
	value:this.OBJ.disponibilidad,
	allowBlank:false,
	width:200,
    readOnly: true,
	style: 'background:#c9c9c9;',
});

this.mo_cuota = new Ext.form.NumberField({
	fieldLabel:'Monto',
	name:'tb145_cuenta_cobrar_detalle[mo_cuota]',
	value:this.OBJ.mo_cuota,
	allowBlank:false,
	width:200,
    msgTarget: 'under',
    validator: function(){
        return this.validFlag;
    },
    listeners:{
        change: function(textfield, newValue, oldValue){
        var me = this;
        if(CuentaPorCobrarCreditoDetalleEditar.main.mo_disponible.getValue() < newValue){
            me.validFlag = 'El monto a solicitar no debe superar al monto Disponible.';
        }else{
            me.validFlag = true;
        }
        //me.validFlag = 'El monto a solicitar no debe superar al monto Disponible.';
        me.validate();
        }
    }
});

this.fe_pago = new Ext.form.DateField({
	fieldLabel:'Fecha de Pago',
	name:'tb145_cuenta_cobrar_detalle[fe_pago]',
	value:this.OBJ.fe_pago,
        maxValue:this.OBJ.fe_pago?new Date():new Date(),
	allowBlank:false,
	width:100
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!CuentaPorCobrarCreditoDetalleEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        CuentaPorCobrarCreditoDetalleEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCreditoDetalle/guardar',
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
                 //CuentaPorCobrarCreditoEditar.main.store_lista.load();
                 CuentaPorCobrarCreditoEditar.main.store_lista.load({
                   params:{
                        id_tb142_cuenta_cobrar:CuentaPorCobrarCreditoDetalleEditar.main.id_tb142_cuenta_cobrar.getValue()
                   },
                   callback: function(){
                        CuentaPorCobrarCreditoEditar.main.getTotal();
                   }
                 });
                 CuentaPorCobrarCreditoDetalleEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        CuentaPorCobrarCreditoDetalleEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
                    this.id_tb142_cuenta_cobrar,
                    this.disponibilidad,
                    this.de_cuota,
                    this.mo_cuota,
                    this.fe_pago
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Cuenta Por Cobrar Detalle',
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
CuentaPorCobrarCreditoEditar.main.mascara.hide();
}
};
Ext.onReady(CuentaPorCobrarCreditoDetalleEditar.main.init, CuentaPorCobrarCreditoDetalleEditar.main);
</script>
