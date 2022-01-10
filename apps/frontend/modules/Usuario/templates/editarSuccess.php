<script type="text/javascript">
Ext.ns("UsuarioEditar");
UsuarioEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_ROL = this.getStoreCO_ROL();
this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();
this.storeCO_ENTE = this.getStoreCO_ENTE();
//<Stores de fk>
//<Stores de fk>
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
//<Stores de fk>

//<ClavePrimaria>
this.co_usuario = new Ext.form.Hidden({
    name:'co_usuario',
    value:this.OBJ.co_usuario});
//</ClavePrimaria>


this.tx_login = new Ext.form.TextField({
	fieldLabel:'Login',
	name:'tb001_usuario[tx_login]',
	value:this.OBJ.tx_login,
        readOnly:(this.OBJ.tx_login!='')?true:false,
	style:(this.OBJ.tx_login!='')?'background:#c9c9c9;':'',
	allowBlank:false,
	width:200
});

this.nb_usuario = new Ext.form.TextField({
	fieldLabel:'Nombre',
	name:'tb001_usuario[nb_usuario]',
	value:this.OBJ.nb_usuario,
	allowBlank:false,
	width:200
});

this.ap_usuario = new Ext.form.TextField({
	fieldLabel:'Apellido',
	name:'tb001_usuario[ap_usuario]',
	value:this.OBJ.ap_usuario,
	allowBlank:false,
	width:200
});

this.tx_correo = new Ext.form.TextField({
	fieldLabel:'Correo',
	name:'tb001_usuario[tx_correo]',
	value:this.OBJ.tx_correo,
	allowBlank:false,
	width:300
});

this.tx_password = new Ext.form.TextField({
	fieldLabel:'Tx password',
	name:'tb001_usuario[tx_password]',
	value:this.OBJ.tx_password,
	allowBlank:false,
	width:200
});

this.co_rol = new Ext.form.ComboBox({
	fieldLabel:'Rol',
	store: this.storeCO_ROL,
	typeAhead: true,
	valueField: 'co_rol',
	displayField:'tx_rol',
	hiddenName:'tb001_usuario[co_rol]',
	//readOnly:(this.OBJ.co_rol!='')?true:false,
	//style:(this.main.OBJ.co_rol!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:140,
	resizable:true,
	allowBlank:false
});
this.storeCO_ROL.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_rol,
	value:  this.OBJ.co_rol,
	objStore: this.storeCO_ROL
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'Activo',
	name:'tb001_usuario[in_activo]',
	checked:(this.OBJ.in_activo=='1') ? true:false,
	allowBlank:false
});

this.nu_cedula = new Ext.form.NumberField({
	fieldLabel:'Cédula',
	name:'tb001_usuario[nu_cedula]',
	value:this.OBJ.nu_cedula,
	allowBlank:false
});

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'tb001_usuario[co_documento]',
	//readOnly:(this.OBJ.co_documento!='')?true:false,
	//style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:50,
	resizable:true,
	allowBlank:false
});
this.storeCO_DOCUMENTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_documento,
	value:  this.OBJ.co_documento,
	objStore: this.storeCO_DOCUMENTO
});

this.co_ente = new Ext.form.ComboBox({
	fieldLabel:'Ente',
	store: this.storeCO_ENTE,
	typeAhead: true,
	valueField: 'co_ente',
	displayField:'tx_ente',
	hiddenName:'tb001_usuario[co_ente]',
	//readOnly:(this.OBJ.co_documento!='')?true:false,
	//style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeCO_ENTE.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_ente,
	value:  this.OBJ.co_ente,
	objStore: this.storeCO_ENTE
});


this.co_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Ente Ejecutor',
	store: this.storeCO_EJECUTOR,
	typeAhead: true,
	valueField: 'id',
        id:'co_ejecutor',
	displayField:'de_ejecutor',
	hiddenName:'tb001_usuario[co_ejecutor]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:700,
        listeners: {
            getSelectedIndex: function() {
                var v = this.getValue();
                var r = this.findRecord(this.valueField || this.displayField, v);
                return(this.storeCO_EJECUTOR.indexOf(r));
             }
        }
});
this.storeCO_EJECUTOR.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_ejecutor,
	value:  this.OBJ.co_ejecutor,
	objStore: this.storeCO_EJECUTOR
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!UsuarioEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        UsuarioEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/guardar',
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
                 UsuarioLista.main.store_lista.load({
                     callback: function(){
                          UsuarioLista.main.editar.disable();
                          UsuarioLista.main.cambiar_estado.disable();
                     }
                 });
                 UsuarioEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        UsuarioEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:900,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_usuario,                            
                    this.co_documento,
                    this.nu_cedula,
                    this.tx_login,
                    this.nb_usuario,
                    this.ap_usuario,
                    this.tx_correo,
                    this.co_ejecutor,
                    this.co_ente,
                    this.co_rol,
                    this.in_activo
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Usuario',
    modal:true,
    constrain:true,
    width:900,
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
UsuarioLista.main.mascara.hide();
},
getStoreCO_EJECUTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/storefkcoejecutor',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_ejecutor',
            convert:function(v,r){
            return r.de_ejecutor;
            }
            }
            ]
    });
    return this.store;
}
,
getStoreCO_ENTE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/storefkcoente',
        root:'data',
        fields:[
            {name: 'co_ente'},
            {name: 'tx_ente',
            convert:function(v,r){
            return r.tx_ente;
            }
            }
            ]
    });
    return this.store;
}
,getStoreCO_ROL:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/storefkcorol',
        root:'data',
        fields:[
            {name: 'co_rol'},
            {name: 'tx_rol'}
            ]
    });
    return this.store;
}
,getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'},
            {name: 'inicial'}
            ]
    });
    return this.store;
}
};
Ext.onReady(UsuarioEditar.main.init, UsuarioEditar.main);
</script>
