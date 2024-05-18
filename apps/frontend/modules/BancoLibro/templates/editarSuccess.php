<script type="text/javascript">
Ext.ns("BancoLibroEditar");
BancoLibroEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CUENTA_BANCARIA = this.getStoreCO_CUENTA_BANCARIA();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.nu_libro = new Ext.form.TextField({
	fieldLabel:'Nu libro',
	name:'tb100_banco_libro[nu_libro]',
	value:this.OBJ.nu_libro,
	allowBlank:false,
	width:200
});

this.id_tb010_banco = new Ext.form.ComboBox({
	fieldLabel:'Id tb010 banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'co_banco',
	hiddenName:'tb100_banco_libro[id_tb010_banco]',
	//readOnly:(this.OBJ.id_tb010_banco!='')?true:false,
	//style:(this.main.OBJ.id_tb010_banco!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb010_banco',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_BANCO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb010_banco,
	value:  this.OBJ.id_tb010_banco,
	objStore: this.storeCO_BANCO
});

this.id_tb011_cuenta_bancaria = new Ext.form.ComboBox({
	fieldLabel:'Id tb011 cuenta bancaria',
	store: this.storeCO_CUENTA_BANCARIA,
	typeAhead: true,
	valueField: 'co_cuenta_bancaria',
	displayField:'co_cuenta_bancaria',
	hiddenName:'tb100_banco_libro[id_tb011_cuenta_bancaria]',
	//readOnly:(this.OBJ.id_tb011_cuenta_bancaria!='')?true:false,
	//style:(this.main.OBJ.id_tb011_cuenta_bancaria!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb011_cuenta_bancaria',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_CUENTA_BANCARIA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb011_cuenta_bancaria,
	value:  this.OBJ.id_tb011_cuenta_bancaria,
	objStore: this.storeCO_CUENTA_BANCARIA
});

this.fe_desde = new Ext.form.DateField({
	fieldLabel:'Fe desde',
	name:'tb100_banco_libro[fe_desde]',
	value:this.OBJ.fe_desde,
	allowBlank:false,
	width:100
});

this.fe_hasta = new Ext.form.DateField({
	fieldLabel:'Fe hasta',
	name:'tb100_banco_libro[fe_hasta]',
	value:this.OBJ.fe_hasta,
	allowBlank:false,
	width:100
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tb100_banco_libro[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tb100_banco_libro[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tb100_banco_libro[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!BancoLibroEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        BancoLibroEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoLibro/guardar',
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
                 BancoLibroLista.main.store_lista.load();
                 BancoLibroEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        BancoLibroEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
                    this.nu_libro,
                    this.id_tb010_banco,
                    this.id_tb011_cuenta_bancaria,
                    this.fe_desde,
                    this.fe_hasta,
                    this.in_activo,
                    this.created_at,
                    this.updated_at,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: BancoLibro',
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
BancoLibroLista.main.mascara.hide();
}
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoLibro/storefkidtb010banco',
        root:'data',
        fields:[
            {name: 'co_banco'}
            ]
    });
    return this.store;
}
,getStoreCO_CUENTA_BANCARIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoLibro/storefkidtb011cuentabancaria',
        root:'data',
        fields:[
            {name: 'co_cuenta_bancaria'}
            ]
    });
    return this.store;
}
};
Ext.onReady(BancoLibroEditar.main.init, BancoLibroEditar.main);
</script>
