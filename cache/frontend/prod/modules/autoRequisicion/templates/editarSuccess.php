<script type="text/javascript">
Ext.ns("RequisicionEditar");
RequisicionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_TIPO_SOLICITUD = this.getStoreCO_TIPO_SOLICITUD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_USUARIO = this.getStoreCO_USUARIO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_SOLICITUD = this.getStoreCO_SOLICITUD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_SERVICIO = this.getStoreCO_SERVICIO();
//<Stores de fk>

//<ClavePrimaria>
this.co_requisicion = new Ext.form.Hidden({
    name:'co_requisicion',
    value:this.OBJ.co_requisicion});
//</ClavePrimaria>


this.co_tipo_solicitud = new Ext.form.ComboBox({
	fieldLabel:'Co tipo solicitud',
	store: this.storeCO_TIPO_SOLICITUD,
	typeAhead: true,
	valueField: 'co_tipo_solicitud',
	displayField:'co_tipo_solicitud',
	hiddenName:'tb039_requisiciones[co_tipo_solicitud]',
	//readOnly:(this.OBJ.co_tipo_solicitud!='')?true:false,
	//style:(this.main.OBJ.co_tipo_solicitud!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_solicitud',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_SOLICITUD.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tipo_solicitud,
	value:  this.OBJ.co_tipo_solicitud,
	objStore: this.storeCO_TIPO_SOLICITUD
});

this.co_usuario = new Ext.form.ComboBox({
	fieldLabel:'Co usuario',
	store: this.storeCO_USUARIO,
	typeAhead: true,
	valueField: 'co_usuario',
	displayField:'co_usuario',
	hiddenName:'tb039_requisiciones[co_usuario]',
	//readOnly:(this.OBJ.co_usuario!='')?true:false,
	//style:(this.main.OBJ.co_usuario!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_usuario',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_USUARIO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_usuario,
	value:  this.OBJ.co_usuario,
	objStore: this.storeCO_USUARIO
});

this.co_ente = new Ext.form.NumberField({
	fieldLabel:'Co ente',
	name:'tb039_requisiciones[co_ente]',
	value:this.OBJ.co_ente,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tb039_requisiciones[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false,
	width:100
});

this.tx_concepto = new Ext.form.TextField({
	fieldLabel:'Tx concepto',
	name:'tb039_requisiciones[tx_concepto]',
	value:this.OBJ.tx_concepto,
	allowBlank:false,
	width:200
});

this.tx_observacion = new Ext.form.TextField({
	fieldLabel:'Tx observacion',
	name:'tb039_requisiciones[tx_observacion]',
	value:this.OBJ.tx_observacion,
	allowBlank:false,
	width:200
});

this.co_solicitud = new Ext.form.ComboBox({
	fieldLabel:'Co solicitud',
	store: this.storeCO_SOLICITUD,
	typeAhead: true,
	valueField: 'co_solicitud',
	displayField:'co_solicitud',
	hiddenName:'tb039_requisiciones[co_solicitud]',
	//readOnly:(this.OBJ.co_solicitud!='')?true:false,
	//style:(this.main.OBJ.co_solicitud!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_solicitud',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_SOLICITUD.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_solicitud,
	value:  this.OBJ.co_solicitud,
	objStore: this.storeCO_SOLICITUD
});

this.co_servicio = new Ext.form.ComboBox({
	fieldLabel:'Co servicio',
	store: this.storeCO_SERVICIO,
	typeAhead: true,
	valueField: 'co_servicio',
	displayField:'co_servicio',
	hiddenName:'tb039_requisiciones[co_servicio]',
	//readOnly:(this.OBJ.co_servicio!='')?true:false,
	//style:(this.main.OBJ.co_servicio!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_servicio',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_SERVICIO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_servicio,
	value:  this.OBJ.co_servicio,
	objStore: this.storeCO_SERVICIO
});

this.nu_requisicion = new Ext.form.NumberField({
	fieldLabel:'Nu requisicion',
	name:'tb039_requisiciones[nu_requisicion]',
	value:this.OBJ.nu_requisicion,
	allowBlank:false
});

this.nu_anio = new Ext.form.NumberField({
	fieldLabel:'Nu anio',
	name:'tb039_requisiciones[nu_anio]',
	value:this.OBJ.nu_anio,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tb039_requisiciones[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.fe_registro = new Ext.form.DateField({
	fieldLabel:'Fe registro',
	name:'tb039_requisiciones[fe_registro]',
	value:this.OBJ.fe_registro,
	allowBlank:false,
	width:100
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!RequisicionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        RequisicionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/guardar',
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
                 RequisicionLista.main.store_lista.load();
                 RequisicionEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        RequisicionEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_requisicion,
                    this.co_tipo_solicitud,
                    this.co_usuario,
                    this.co_ente,
                    this.created_at,
                    this.tx_concepto,
                    this.tx_observacion,
                    this.co_solicitud,
                    this.co_servicio,
                    this.nu_requisicion,
                    this.nu_anio,
                    this.updated_at,
                    this.fe_registro,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Requisicion',
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
RequisicionLista.main.mascara.hide();
}
,getStoreCO_TIPO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/storefkcotiposolicitud',
        root:'data',
        fields:[
            {name: 'co_tipo_solicitud'}
            ]
    });
    return this.store;
}
,getStoreCO_USUARIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/storefkcousuario',
        root:'data',
        fields:[
            {name: 'co_usuario'}
            ]
    });
    return this.store;
}
,getStoreCO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/storefkcosolicitud',
        root:'data',
        fields:[
            {name: 'co_solicitud'}
            ]
    });
    return this.store;
}
,getStoreCO_SERVICIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/storefkcoservicio',
        root:'data',
        fields:[
            {name: 'co_servicio'}
            ]
    });
    return this.store;
}
};
Ext.onReady(RequisicionEditar.main.init, RequisicionEditar.main);
</script>
