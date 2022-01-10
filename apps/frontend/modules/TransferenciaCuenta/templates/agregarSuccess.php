<script type="text/javascript">
Ext.ns("TransferenciaEditar");
TransferenciaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.storeCO_TIPO_RETENCION         = this.getStoreCO_TIPO_RETENCION();


this.co_transferencia_cuenta = new Ext.form.Hidden({
    name:'co_transferencia_cuenta',
    value: this.OBJ.co_transferencia_cuenta
});

this.co_cuenta_debita = new Ext.form.Hidden({
    name:'co_cuenta_debitar',
    value: this.OBJ.co_cuenta_debitar
});

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value: this.OBJ.co_solicitud
});

this.co_cuenta_creditar = new Ext.form.Hidden({
    name:'co_cuenta_creditar',
    value: this.OBJ.co_cuenta_credito
});

this.co_banco_creditar = new Ext.form.Hidden({
    name:'co_banco_creditar',
    value: this.OBJ.co_banco_creditar
});

this.co_cuenta_bancaria_creditar = new Ext.form.Hidden({
    name:'co_cuenta_bancaria_creditar',
    value: this.OBJ.co_cuenta_bancaria_creditar
});

this.co_banco_debitar = new Ext.form.Hidden({
    name:'co_banco_debitar',
    value: this.OBJ.co_banco_debitar
});

this.co_cuenta_bancaria_debitar = new Ext.form.Hidden({
    name:'co_cuenta_bancaria_debitar',
    value: this.OBJ.co_cuenta_bancaria_debitar
});

this.saldo_disponible = new Ext.form.Hidden({
    name:'saldo_disponible',
    value:this.OBJ.saldo_disponible
});

this.in_fondo_tercero = new Ext.form.Hidden({
    name:'in_fondo_tercero',
    value:this.OBJ.in_fondo_tercero
});

this.tx_cuenta_debitar = new Ext.form.TextField({
	name:'tx_cuenta_debitar',        
	readOnly:true,
	style:'background:#c9c9c9;',
	width:200,
        value: this.OBJ.tx_cuenta_debitar
});

this.tx_cuenta_bancaria_debitar = new Ext.form.TextField({
        fieldLabel:'Cuenta Bancaria',
	name:'tx_cuenta_bancaria_debitar',        
	readOnly:true,
	style:'background:#c9c9c9;',
	width:200,
        value: this.OBJ.tx_cuenta_bancaria_debitar
});

this.mo_debitar = new Ext.form.NumberField({
        fieldLabel:'Monto',
	name:'mo_debitar',
	width:200,
        value: this.OBJ.mo_debitar
});

this.buscar_debitar = new Ext.Button({
    text:'Buscar',
    handler:function(){
        this.msg = Ext.get('formulario');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TransferenciaCuenta/buscarDebitar',
         scripts: true,
         text: "Cargando.."
        });
    }
});


this.compositefieldDebitar = new Ext.form.CompositeField({
fieldLabel: 'Cuenta Contable',
items: [
	this.tx_cuenta_debitar,
	this.buscar_debitar
	]
});


this.tx_descripcion_debitar = new Ext.form.TextField({
        fieldLabel:'Descripción',
	name:'tx_descripcion_debitar',
        readOnly:true,
	style:'background:#c9c9c9;',
	width:600,
        value: this.OBJ.tx_descripcion_debitar
});

this.tx_banco_debitar = new Ext.form.TextField({
        fieldLabel:'Banco',
	name:'tx_banco_debitar',
        readOnly:true,
	style:'background:#c9c9c9;',
	width:400,
        value: this.OBJ.tx_banco_debitar
});

this.tx_cuenta_bancaria_creditar = new Ext.form.TextField({
        fieldLabel:'Cuenta Bancaria',
	name:'tx_cuenta_bancaria_creditar',        
	readOnly:true,
	style:'background:#c9c9c9;',
	width:200,
        value:this.OBJ.tx_cuenta_bancaria_creditar
});

this.nu_saldo_debitar = new Ext.form.TextField({
        fieldLabel:'Saldo Disponible',
	name:'nu_saldo_debitar',
        readOnly:true,
	style:'background:#c9c9c9;',
	width:200,
        value: this.OBJ.nu_saldo_debitar
});

this.tx_cuenta_creditar = new Ext.form.TextField({
	name:'tx_cuenta_creditar',
        readOnly:true,
	style:'background:#c9c9c9;',
	width:200,
        value:this.OBJ.tx_cuenta_creditar
});

this.buscar_creditar = new Ext.Button({
    text:'Buscar',
    handler:function(){
        this.msg = Ext.get('formulario');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TransferenciaCuenta/buscarCreditar',
         scripts: true,
         text: "Cargando.."
        });
    }
});

this.compositefieldCreditar = new Ext.form.CompositeField({
fieldLabel: 'Cuenta Contable',
items: [
	this.tx_cuenta_creditar,
	this.buscar_creditar
	]
});

this.tx_descripcion_creditar = new Ext.form.TextField({
        fieldLabel:'Descripción',
        readOnly:true,
	style:'background:#c9c9c9;',
	name:'tx_descripcion_creditar',
	width:600,
        value:this.OBJ.tx_descripcion_creditar
});

this.tx_banco_creditar = new Ext.form.TextField({
        fieldLabel:'Banco',
	name:'tx_banco_creditar',
        readOnly:true,
	style:'background:#c9c9c9;',
	width:400,
        value:this.OBJ.tx_banco_creditar
});

this.nu_saldo_creditar = new Ext.form.TextField({
        fieldLabel:'Saldo',
	name:'nu_saldo_creditar',
        readOnly:true,
	style:'background:#c9c9c9;',
	width:200,
        value:this.OBJ.nu_saldo_creditar
});

this.co_tipo_retencion = new Ext.form.ComboBox({
        fieldLabel:'Fondo Tercero',
        store: this.storeCO_TIPO_RETENCION,
        typeAhead: true,
        valueField: 'co_tipo_retencion',
        displayField:'tx_tipo_retencion',
        hiddenName:'co_tipo_retencion',
        forceSelection:true,
        resizable:true,
        triggerAction: 'all',
        selectOnFocus: true,
        mode: 'local',
        width:500
});
if(TransferenciaEditar.main.OBJ.co_tipo_retencion==null){
this.co_tipo_retencion.hide();
}else{
this.co_tipo_retencion.show();
}
this.storeCO_TIPO_RETENCION.load({
    callback: function(){
        TransferenciaEditar.main.co_tipo_retencion.setValue(TransferenciaEditar.main.OBJ.co_tipo_retencion);
    }
});

this.fieldDatosDebitar = new Ext.form.FieldSet({
        title: 'Cuenta Contable a Debitar',
        items:[this.saldo_disponible,
               this.compositefieldDebitar,
               this.tx_descripcion_debitar,
               this.tx_banco_debitar,               
               this.tx_cuenta_bancaria_debitar,
               this.nu_saldo_debitar,
               this.mo_debitar,
               this.co_cuenta_debita]
});

this.fieldDatosAcreditar = new Ext.form.FieldSet({
        title: 'Cuenta Contable a Creditar',
        items:[this.compositefieldCreditar,
               this.tx_descripcion_creditar,
               this.tx_cuenta_bancaria_creditar,
               this.tx_banco_creditar,
               this.nu_saldo_creditar,
               this.co_cuenta_creditar,
               this.co_tipo_retencion]
});


this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){
    
        var saldo_disponible = TransferenciaEditar.main.saldo_disponible.getValue();
        var monto = TransferenciaEditar.main.mo_debitar.getValue();
        
        var co_cuenta_debitar  = TransferenciaEditar.main.co_cuenta_debita.getValue();
        var co_cuenta_creditar = TransferenciaEditar.main.co_cuenta_creditar.getValue();
        var in_fondo_tercero = TransferenciaEditar.main.in_fondo_tercero.getValue();
        var co_tipo_retencion = TransferenciaEditar.main.co_tipo_retencion.getValue();
        
            
        if(co_cuenta_debitar == undefined){
            Ext.MessageBox.alert('Error en transacción', 'Debe seleccionar una cuenta a debitar');
            return false;
        }
        
        if(co_cuenta_creditar == undefined){
            Ext.MessageBox.alert('Error en transacción', 'Debe seleccionar una cuenta a creditar');
            return false;
        }
        
        if(monto == ''){
            Ext.MessageBox.alert('Error en transacción', 'Debe ingresar el monto a transferir');
            return false;
        }
        
        
        if(in_fondo_tercero==true){
            if(co_tipo_retencion==''){
            Ext.MessageBox.alert('Error en transacción', 'Debe Seleccionar el Fondo de Tercero');
            return false;
        }
        }
        
        if(!TransferenciaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        
        TransferenciaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TransferenciaCuenta/guardar',
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
                 TransferenciaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        TransferenciaEditar.main.winformPanel_.close();
    }
});
            

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:790,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
        this.co_transferencia_cuenta,
        this.co_solicitud,
        this.co_banco_creditar,
        this.co_cuenta_bancaria_creditar,
        this.co_banco_debitar,
        this.co_cuenta_bancaria_debitar,
        this.fieldDatosDebitar,
        this.fieldDatosAcreditar
    ]   
});



this.winformPanel_ = new Ext.Window({
    title:'Transferencia entre Cuenta',
    modal:true,
    constrain:true,
    width:800,
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

},
getStoreCO_TIPO_RETENCION(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TransferenciaCuenta/storefkcotiporetencion',
        root:'data',
        fields:[
                {name: 'co_tipo_retencion'},
                {name: 'tx_tipo_retencion'}
            ]
    });
    return this.store;
}
};
Ext.onReady(TransferenciaEditar.main.init, TransferenciaEditar.main);
</script>
<div id="formulario"></div>