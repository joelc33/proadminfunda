<script type="text/javascript">
Ext.ns("PersonaEditar");
PersonaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CARGO = this.getStoreCO_CARGO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_NIVEL_ORGANIZACIONAL = this.getStoreCO_NIVEL_ORGANIZACIONAL();
//<Stores de fk>
//<Stores de fk>
this.storeCO_NIVEL_TRABAJADOR = this.getStoreCO_NIVEL_TRABAJADOR();
//<Stores de fk>

//<ClavePrimaria>
this.co_persona = new Ext.form.Hidden({
    name:'co_persona',
    value:this.OBJ.co_persona});
//</ClavePrimaria>


this.nb_persona = new Ext.form.TextField({
	fieldLabel:'Nb persona',
	name:'tb109_persona[nb_persona]',
	value:this.OBJ.nb_persona,
	allowBlank:false,
	width:200
});

this.ap_persona = new Ext.form.TextField({
	fieldLabel:'Ap persona',
	name:'tb109_persona[ap_persona]',
	value:this.OBJ.ap_persona,
	allowBlank:false,
	width:200
});

this.nu_cedula = new Ext.form.NumberField({
	fieldLabel:'Nu cedula',
	name:'tb109_persona[nu_cedula]',
	value:this.OBJ.nu_cedula,
	allowBlank:false
});

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'co_documento',
	hiddenName:'tb109_persona[co_documento]',
	//readOnly:(this.OBJ.co_documento!='')?true:false,
	//style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_documento',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_DOCUMENTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_documento,
	value:  this.OBJ.co_documento,
	objStore: this.storeCO_DOCUMENTO
});

this.co_cargo = new Ext.form.ComboBox({
	fieldLabel:'Co cargo',
	store: this.storeCO_CARGO,
	typeAhead: true,
	valueField: 'co_cargo',
	displayField:'co_cargo',
	hiddenName:'tb109_persona[co_cargo]',
	//readOnly:(this.OBJ.co_cargo!='')?true:false,
	//style:(this.main.OBJ.co_cargo!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_cargo',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_CARGO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_cargo,
	value:  this.OBJ.co_cargo,
	objStore: this.storeCO_CARGO
});

this.co_nivel_organizacional = new Ext.form.ComboBox({
	fieldLabel:'Co nivel organizacional',
	store: this.storeCO_NIVEL_ORGANIZACIONAL,
	typeAhead: true,
	valueField: 'co_nivel_organizacional',
	displayField:'co_nivel_organizacional',
	hiddenName:'tb109_persona[co_nivel_organizacional]',
	//readOnly:(this.OBJ.co_nivel_organizacional!='')?true:false,
	//style:(this.main.OBJ.co_nivel_organizacional!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_nivel_organizacional',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_NIVEL_ORGANIZACIONAL.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_nivel_organizacional,
	value:  this.OBJ.co_nivel_organizacional,
	objStore: this.storeCO_NIVEL_ORGANIZACIONAL
});

this.co_nivel_trabajador = new Ext.form.ComboBox({
	fieldLabel:'Co nivel trabajador',
	store: this.storeCO_NIVEL_TRABAJADOR,
	typeAhead: true,
	valueField: 'co_nivel_trabajador',
	displayField:'co_nivel_trabajador',
	hiddenName:'tb109_persona[co_nivel_trabajador]',
	//readOnly:(this.OBJ.co_nivel_trabajador!='')?true:false,
	//style:(this.main.OBJ.co_nivel_trabajador!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_nivel_trabajador',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_NIVEL_TRABAJADOR.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_nivel_trabajador,
	value:  this.OBJ.co_nivel_trabajador,
	objStore: this.storeCO_NIVEL_TRABAJADOR
});

this.nu_celular = new Ext.form.TextField({
	fieldLabel:'Nu celular',
	name:'tb109_persona[nu_celular]',
	value:this.OBJ.nu_celular,
	allowBlank:false,
	width:200
});

this.nu_extension = new Ext.form.TextField({
	fieldLabel:'Nu extension',
	name:'tb109_persona[nu_extension]',
	value:this.OBJ.nu_extension,
	allowBlank:false,
	width:200
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PersonaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PersonaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/guardar',
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
                 PersonaLista.main.store_lista.load();
                 PersonaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PersonaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_persona,
                    this.nb_persona,
                    this.ap_persona,
                    this.nu_cedula,
                    this.co_documento,
                    this.co_cargo,
                    this.co_nivel_organizacional,
                    this.co_nivel_trabajador,
                    this.nu_celular,
                    this.nu_extension,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Persona',
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
PersonaLista.main.mascara.hide();
}
,getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'}
            ]
    });
    return this.store;
}
,getStoreCO_CARGO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/storefkcocargo',
        root:'data',
        fields:[
            {name: 'co_cargo'}
            ]
    });
    return this.store;
}
,getStoreCO_NIVEL_ORGANIZACIONAL:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/storefkconivelorganizacional',
        root:'data',
        fields:[
            {name: 'co_nivel_organizacional'}
            ]
    });
    return this.store;
}
,getStoreCO_NIVEL_TRABAJADOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/storefkconiveltrabajador',
        root:'data',
        fields:[
            {name: 'co_nivel_trabajador'}
            ]
    });
    return this.store;
}
};
Ext.onReady(PersonaEditar.main.init, PersonaEditar.main);
</script>
