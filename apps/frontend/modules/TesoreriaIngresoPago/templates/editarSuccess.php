<script type="text/javascript">
Ext.ns("TesoreriaIngresoPagoEditar");
TesoreriaIngresoPagoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.id_tb145_cuenta_cobrar_detalle = new Ext.form.ComboBox({
	fieldLabel:'Id tb145 cuenta cobrar detalle',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb148_cuenta_cobrar_pago[id_tb145_cuenta_cobrar_detalle]',
	//readOnly:(this.OBJ.id_tb145_cuenta_cobrar_detalle!='')?true:false,
	//style:(this.main.OBJ.id_tb145_cuenta_cobrar_detalle!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb145_cuenta_cobrar_detalle',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb145_cuenta_cobrar_detalle,
	value:  this.OBJ.id_tb145_cuenta_cobrar_detalle,
	objStore: this.storeID
});

this.mo_pago = new Ext.form.NumberField({
	fieldLabel:'Mo pago',
	name:'tb148_cuenta_cobrar_pago[mo_pago]',
	value:this.OBJ.mo_pago,
	allowBlank:false
});

this.id_tb074_forma_pago = new Ext.form.NumberField({
	fieldLabel:'Id tb074 forma pago',
	name:'tb148_cuenta_cobrar_pago[id_tb074_forma_pago]',
	value:this.OBJ.id_tb074_forma_pago,
	allowBlank:false
});

this.id_tb010_banco = new Ext.form.NumberField({
	fieldLabel:'Id tb010 banco',
	name:'tb148_cuenta_cobrar_pago[id_tb010_banco]',
	value:this.OBJ.id_tb010_banco,
	allowBlank:false
});

this.id_tb011_cuenta_bancaria = new Ext.form.NumberField({
	fieldLabel:'Id tb011 cuenta bancaria',
	name:'tb148_cuenta_cobrar_pago[id_tb011_cuenta_bancaria]',
	value:this.OBJ.id_tb011_cuenta_bancaria,
	allowBlank:false
});

this.fe_ingreso = new Ext.form.DateField({
	fieldLabel:'Fe ingreso',
	name:'tb148_cuenta_cobrar_pago[fe_ingreso]',
	value:this.OBJ.fe_ingreso,
	allowBlank:false,
	width:100
});

this.fe_registro = new Ext.form.DateField({
	fieldLabel:'Fe registro',
	name:'tb148_cuenta_cobrar_pago[fe_registro]',
	value:this.OBJ.fe_registro,
	allowBlank:false,
	width:100
});

this.id_tb147_tipo_documento = new Ext.form.NumberField({
	fieldLabel:'Id tb147 tipo documento',
	name:'tb148_cuenta_cobrar_pago[id_tb147_tipo_documento]',
	value:this.OBJ.id_tb147_tipo_documento,
	allowBlank:false
});

this.de_orden_ingreso = new Ext.form.TextField({
	fieldLabel:'De orden ingreso',
	name:'tb148_cuenta_cobrar_pago[de_orden_ingreso]',
	value:this.OBJ.de_orden_ingreso,
	allowBlank:false,
	width:200
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tb148_cuenta_cobrar_pago[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tb148_cuenta_cobrar_pago[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tb148_cuenta_cobrar_pago[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!TesoreriaIngresoPagoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        TesoreriaIngresoPagoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngresoPago/guardar',
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
                 TesoreriaIngresoPagoLista.main.store_lista.load();
                 TesoreriaIngresoPagoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        TesoreriaIngresoPagoEditar.main.winformPanel_.close();
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
                    this.id_tb145_cuenta_cobrar_detalle,
                    this.mo_pago,
                    this.id_tb074_forma_pago,
                    this.id_tb010_banco,
                    this.id_tb011_cuenta_bancaria,
                    this.fe_ingreso,
                    this.fe_registro,
                    this.id_tb147_tipo_documento,
                    this.de_orden_ingreso,
                    this.in_activo,
                    this.created_at,
                    this.updated_at,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: TesoreriaIngresoPago',
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
TesoreriaIngresoPagoLista.main.mascara.hide();
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngresoPago/storefkidtb145cuentacobrardetalle',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
};
Ext.onReady(TesoreriaIngresoPagoEditar.main.init, TesoreriaIngresoPagoEditar.main);
</script>
