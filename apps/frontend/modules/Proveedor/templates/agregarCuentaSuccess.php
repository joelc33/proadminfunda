<script type="text/javascript">
Ext.ns("agregarCuenta");
agregarCuenta.main = {
init:function(){

//<Stores de fk>

this.storeCO_BANCO = this.getStoreCO_BANCO();
/*this.storeCO_CUENTA_CONTABLE = this.getStoreCO_CUENTA_CONTABLE();

this.co_cuenta_contable = new Ext.form.ComboBox({
	fieldLabel:'Cuenta Contable',
	store: this.storeCO_CUENTA_CONTABLE,
	typeAhead: true,
	valueField: 'co_cuenta_contable',
	displayField:'nu_cuenta_contable',
	hiddenName:'tb008_proveedor[co_cuenta_contable]',
	//readOnly:(this.OBJ.co_cuenta_contable!='')?true:false,
	//style:(this.main.OBJ.co_cuenta_contable!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:250,
        allowBlank:false,
	resizable:true
});

this.storeCO_CUENTA_CONTABLE.load();*/

this.nu_cuenta_bancaria = new Ext.form.TextField({
	fieldLabel:'Cuenta Bancaria',
	name:'tb008_proveedor[nu_cuenta_bancaria]',
	width:200,
        allowBlank:false,
        maskRe: /[0-9]/,
});

this.co_banco = new Ext.form.ComboBox({
	fieldLabel:'Banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'tx_banco',
	hiddenName:'tb008_proveedor[co_banco]',
	//readOnly:(this.OBJ.co_banco!='')?true:false,
	//style:(this.main.OBJ.co_banco!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
        allowBlank:false,
	mode: 'local',
	width:300,
	resizable:true
});
this.storeCO_BANCO.load();


this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

    if (agregarCuenta.main.formPanel_.form.isValid()) {
                   
                var e = new ProveedorEditar.main.RegistroCuentaBancaria({ 
                    co_cuenta_proveedor: '',
                    co_banco: agregarCuenta.main.co_banco.getValue(),
                    tx_banco: agregarCuenta.main.co_banco.lastSelectionText,
                    tx_cuenta: agregarCuenta.main.nu_cuenta_bancaria.getValue()
                });

                var cant = ProveedorEditar.main.store_lista_cuenta.getCount();
                (cant == 0) ? 0 : ProveedorEditar.main.store_lista_cuenta.getCount() + 1;
                ProveedorEditar.main.store_lista_cuenta.insert(cant, e);
              
                ProveedorEditar.main.gridPanelCuenta.getView().refresh();
                agregarCuenta.main.winformPanel_.close();

        }
        else {
            Ext.Msg.show({
                title: 'Mensaje',
                msg: 'Debe llenar los campos requeridos',
                buttons: Ext.Msg.OK,
                animEl: document.body,
                icon: Ext.MessageBox.INFO
            });
        }

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        agregarCuenta.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:500,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.co_banco,
           this.nu_cuenta_bancaria]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Cuenta Contable',
    modal:true,
    constrain:true,
    width:500,
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
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcobanco',
        root:'data',
        fields:[
            {name: 'co_banco'},
            {name: 'tx_banco'}
            ]
    });
    return this.store;
}
,getStoreCO_CUENTA_CONTABLE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcocuentacontable',
        root:'data',
        fields:[
            {name: 'co_cuenta_contable'},
            {name: 'nu_cuenta_contable'}
            ]
    });
    return this.store;
}
};
Ext.onReady(agregarCuenta.main.init, agregarCuenta.main);
</script>
