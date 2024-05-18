<script type="text/javascript">
Ext.ns("solicitudEditar");
solicitudEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ESTATUS = this.getStoreCO_ESTATUS();
//<Stores de fk>

//<ClavePrimaria>
this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud});

this.co_ruta = new Ext.form.Hidden({
    name:'co_ruta',
    value:this.OBJ.co_ruta});

//</ClavePrimaria>

this.nu_cedula = new Ext.form.TextField({
	fieldLabel:'Cedula',
	name:'t14_contribuyente[nu_cedula]',
	value:this.OBJ.nu_cedula,
	width:200,
	style:'background:#c9c9c9;',
	readOnly:true
});

this.nb_persona = new Ext.form.TextField({
	fieldLabel:'Nombres y Apellido',
	name:'t14_contribuyente[nb_persona]',
	value:this.OBJ.nb_usuario,
	width:200,
	style:'background:#c9c9c9;',
	readOnly:true
});


this.co_tipo_solicitud = new Ext.form.TextField({
	fieldLabel:'Solicitud',
	name:'t15_solicitud[co_tipo_solicitud]',
	value:this.OBJ.tx_tipo_solicitud,
	width:500,
	style:'background:#c9c9c9;',
	readOnly:true
});

this.observacion = new Ext.form.TextArea({
	fieldLabel:'Observacion',
	name:'observacion',
	width:500,
	allowBlank:false
});

this.co_estatus = new Ext.form.ComboBox({
	fieldLabel:'Estatus',
	store: this.storeCO_ESTATUS,
	typeAhead: true,
	valueField: 'co_estatus_ruta',
	displayField:'tx_descripcion',
	hiddenName:'co_estatus',
	//readOnly:(this.OBJ.co_estatus!='')?true:false,
	//style:(this.main.OBJ.co_estatus!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Estatus',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ESTATUS.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_estatus,
	value:  this.OBJ.co_estatus,
	objStore: this.storeCO_ESTATUS
});

this.fielset1 = new Ext.form.FieldSet({
              title:'Datos de la Solicitud',
              width:670,
              items:[this.co_ruta,                           
                    this.nu_cedula,                    
                    this.nb_persona,
		    this.co_tipo_solicitud,
		    this.observacion
]});

this.fielset2 = new Ext.form.FieldSet({
              title:'Datos de Envio',width:670,
              items:[ 
		this.co_estatus
]});

this.guardar = new Ext.Button({
    text:'Procesar Solicitud',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!solicitudEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        solicitudEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/guardarestado',
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
                 
                   if(panel_detalle.collapsed == false)
                 {
                    panel_detalle.toggleCollapse();
                 } 
                 
                 pendienteEntidadesLista.main.store_lista.load();
                 solicitudEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        solicitudEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    //fileUpload: true,
    width:700,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_solicitud,
			this.fielset1,this.fielset2
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario de Solicitudes',
    modal:true,
    constrain:true,
    width:715,
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
pendienteEntidadesLista.main.mascara.hide();
}
,getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/contribuyente/storefkcodocumentonatural',
        root:'data',
        fields:[
            {name: 'co_documento'}, {name: 'inicial'}
            ]
    });
    return this.store;
}
,getStoreCO_ESTATUS:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/storefkcoestatus',
        root:'data',
        fields:[
            {name: 'co_estatus_ruta'},{name: 'tx_descripcion'}
            ]
    });
    return this.store;
}
};
Ext.onReady(solicitudEditar.main.init, solicitudEditar.main);
</script>
<div id="requisito" ></div>
