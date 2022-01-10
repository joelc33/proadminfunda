<script type="text/javascript">
Ext.ns("TesoreriaIngresoEditar");
TesoreriaIngresoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.co_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co solicitud',
	name:'tb142_cuenta_cobrar[co_solicitud]',
	value:this.OBJ.co_solicitud,
	allowBlank:false
});

this.co_usuario = new Ext.form.NumberField({
	fieldLabel:'Co usuario',
	name:'tb142_cuenta_cobrar[co_usuario]',
	value:this.OBJ.co_usuario,
	allowBlank:false
});

this.co_proveedor = new Ext.form.NumberField({
	fieldLabel:'Co proveedor',
	name:'tb142_cuenta_cobrar[co_proveedor]',
	value:this.OBJ.co_proveedor,
	allowBlank:false
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tb142_cuenta_cobrar[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tb142_cuenta_cobrar[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tb142_cuenta_cobrar[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.de_soporte = new Ext.form.TextField({
	fieldLabel:'De soporte',
	name:'tb142_cuenta_cobrar[de_soporte]',
	value:this.OBJ.de_soporte,
	allowBlank:false,
	width:200
});

this.id_tb143_cuenta_concepto = new Ext.form.ComboBox({
	fieldLabel:'Id tb143 cuenta concepto',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb142_cuenta_cobrar[id_tb143_cuenta_concepto]',
	//readOnly:(this.OBJ.id_tb143_cuenta_concepto!='')?true:false,
	//style:(this.main.OBJ.id_tb143_cuenta_concepto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb143_cuenta_concepto',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb143_cuenta_concepto,
	value:  this.OBJ.id_tb143_cuenta_concepto,
	objStore: this.storeID
});

this.id_tb144_clase_ingreso = new Ext.form.ComboBox({
	fieldLabel:'Id tb144 clase ingreso',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb142_cuenta_cobrar[id_tb144_clase_ingreso]',
	//readOnly:(this.OBJ.id_tb144_clase_ingreso!='')?true:false,
	//style:(this.main.OBJ.id_tb144_clase_ingreso!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb144_clase_ingreso',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb144_clase_ingreso,
	value:  this.OBJ.id_tb144_clase_ingreso,
	objStore: this.storeID
});

this.de_descripcion = new Ext.form.TextField({
	fieldLabel:'De descripcion',
	name:'tb142_cuenta_cobrar[de_descripcion]',
	value:this.OBJ.de_descripcion,
	allowBlank:false,
	width:200
});

this.mo_cuenta = new Ext.form.NumberField({
	fieldLabel:'Mo cuenta',
	name:'tb142_cuenta_cobrar[mo_cuenta]',
	value:this.OBJ.mo_cuenta,
	allowBlank:false
});

this.fe_documento = new Ext.form.DateField({
	fieldLabel:'Fe documento',
	name:'tb142_cuenta_cobrar[fe_documento]',
	value:this.OBJ.fe_documento,
	allowBlank:false,
	width:100
});

this.id_tb141_tipo_cuota = new Ext.form.ComboBox({
	fieldLabel:'Id tb141 tipo cuota',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb142_cuenta_cobrar[id_tb141_tipo_cuota]',
	//readOnly:(this.OBJ.id_tb141_tipo_cuota!='')?true:false,
	//style:(this.main.OBJ.id_tb141_tipo_cuota!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb141_tipo_cuota',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb141_tipo_cuota,
	value:  this.OBJ.id_tb141_tipo_cuota,
	objStore: this.storeID
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!TesoreriaIngresoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        TesoreriaIngresoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/guardar',
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
                 TesoreriaIngresoLista.main.store_lista.load();
                 TesoreriaIngresoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        TesoreriaIngresoEditar.main.winformPanel_.close();
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
                    this.co_solicitud,
                    this.co_usuario,
                    this.co_proveedor,
                    this.in_activo,
                    this.created_at,
                    this.updated_at,
                    this.de_soporte,
                    this.id_tb143_cuenta_concepto,
                    this.id_tb144_clase_ingreso,
                    this.de_descripcion,
                    this.mo_cuenta,
                    this.fe_documento,
                    this.id_tb141_tipo_cuota,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: TesoreriaIngreso',
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
TesoreriaIngresoLista.main.mascara.hide();
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/storefkidtb143cuentaconcepto',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/storefkidtb144claseingreso',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/storefkidtb141tipocuota',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
};
Ext.onReady(TesoreriaIngresoEditar.main.init, TesoreriaIngresoEditar.main);
</script>
