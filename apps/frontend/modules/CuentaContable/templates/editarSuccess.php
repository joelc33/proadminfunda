<script type="text/javascript">
Ext.ns("AgregarCuenta");
AgregarCuenta.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_cuenta_contable = new Ext.form.Hidden({
    name:'co_cuenta_contable',
    value:this.OBJ.co_cuenta_contable});
//</ClavePrimaria>

this.tx_prefijo = new Ext.form.TextField({
	fieldLabel:'Cuenta Prefijo:',
	name:'tb024_cuenta_contable[tx_prefijo]',
        readOnly:true,
	style:'background:#c9c9c9;',
	value:this.OBJ.tx_prefijo,
	//allowBlank:false,
	width:400
});

this.tx_codigo_cuenta = new Ext.form.TextField({
	fieldLabel:'Cuenta',
	name:'tb024_cuenta_contable[tx_codigo_cuenta]',
	value:this.OBJ.tx_codigo_cuenta,
        readOnly:(this.OBJ.co_cuenta_contable!='')?true:false,
	style:(this.OBJ.co_cuenta_contable!='')?'background:#c9c9c9;':'',
	allowBlank:false,
	width:200,
        maskRe: /[0-9]/,
});

this.nu_cuenta_contable = new Ext.form.TextField({
	fieldLabel:'Nº Cuenta',
	name:'tb024_cuenta_contable[nu_cuenta_contable]',
	value:this.OBJ.nu_cuenta_contable,
        readOnly:(this.OBJ.co_cuenta_contable!='')?true:false,
	style:(this.OBJ.co_cuenta_contable!='')?'background:#c9c9c9;':'',
	width:200,
        maskRe: /[0-9]/,
});

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Denominación',
	name:'tb024_cuenta_contable[tx_descripcion]',
	value:this.OBJ.tx_descripcion,
	allowBlank:false,
	width:550
});
   
this.tx_tipo  = new Ext.form.ComboBox({
    typeAhead: true,
    triggerAction: 'all',
    lazyRender:true,
    mode: 'local',
    fieldLabel:'Tipo',
    hiddenName:'tb024_cuenta_contable[tx_tipo]',
    width:150,
    allowBlank:false,
    value: this.OBJ.tx_tipo,
    store: new Ext.data.ArrayStore({
        id: 0,
        fields: [
            'tx_tipo',
            'tx_tipo_pago'
        ],
        data: [['S', 'Movimiento'],['N', 'Sin Movimiento']]
    }),
    valueField: 'tx_tipo',
    displayField: 'tx_tipo_pago'
});

this.nivel = new Ext.form.NumberField({
	fieldLabel:'Nivel',
	name:'tb024_cuenta_contable[nu_nivel]',
	value:this.OBJ.nivel,
        width:30,
        readOnly:true,
	style:'background:#c9c9c9;',
	allowBlank:false
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
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaContable/guardar',
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
                 <?php echo $paquete ?>.main.store_lista.load();
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
    items:[         this.co_cuenta_contable,
//                    this.tx_prefijo,
                    this.tx_codigo_cuenta,
                    this.tx_descripcion,
//                    this.nu_cuenta_contable,
//                    this.nivel,
                    this.tx_tipo
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Crear Cuenta Contable',
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

}
};
Ext.onReady(AgregarCuenta.main.init, AgregarCuenta.main);
</script>
