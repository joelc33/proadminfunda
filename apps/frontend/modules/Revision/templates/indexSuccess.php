<script type="text/javascript">
Ext.ns("revisionEditar");
revisionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.storeCO_ESTATUS = this.getStoreCO_ESTATUS();
this.storeCO_PROCESO = this.getStoreCO_PROCESO();
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
	name:'nu_cedula',
	value:this.OBJ.nu_cedula,
	width:200,
	style:'background:#c9c9c9;',
	readOnly:true
});

this.nb_persona = new Ext.form.TextField({
	fieldLabel:'Nombres y Apellido',
	name:'nb_persona',
	value:this.OBJ.nb_usuario,
	width:200,
	style:'background:#c9c9c9;',
	readOnly:true
});


this.co_tipo_solicitud = new Ext.form.TextField({
	fieldLabel:'Solicitud',
	name:'tx_tipo_solicitud',
	value:this.OBJ.tx_tipo_solicitud,
	width:500,
	style:'background:#c9c9c9;',
	readOnly:true
});

this.observacion = new Ext.form.TextArea({
	fieldLabel:'Observacion',
	name:'tx_observacion',
	width:500,
	allowBlank:false
});

this.co_proceso = new Ext.form.ComboBox({
	fieldLabel:'Unidad',
	store: this.storeCO_PROCESO,
	typeAhead: true,
	valueField: 'co_proceso',
	displayField:'tx_proceso',
	hiddenName:'co_proceso',
	//readOnly:(this.OBJ.co_proceso!='')?true:false,
	//style:(this.main.OBJ.co_proceso!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_PROCESO.load();


this.fielset1 = new Ext.form.FieldSet({
              title:'Datos de la Solicitud',
              width:670,
              items:[this.co_ruta,                           
                    this.nu_cedula,
                    this.nb_persona,
		    this.co_tipo_solicitud,
		    this.observacion
]});

this.fieldImagen = new Ext.form.FieldSet({
	title: 'Documento',
	items:[{
                            xtype: 'fileuploadfield',
                            style:"padding-right:300px",
                            id: 'form-pdf',
                            emptyText: 'Seleccione un Documento',
                            fieldLabel: 'Documento',
                            name: 'form-pdf',
                            buttonText: 'Buscar'            
                    }]
});

this.fielset2 = new Ext.form.FieldSet({
              title:'Datos de Envio',width:670,
              items:[ 
		this.co_proceso
              ]
});


this.guardar = new Ext.Button({
    text:'Procesar Solicitud',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!revisionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        revisionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Revision/guardar',
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
                 revisionEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        revisionEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    fileUpload: true,
    width:700,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_solicitud,
			this.fielset1,this.fieldImagen,this.fielset2
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
,getStoreCO_PROCESO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Revision/storefkcoproceso',
        root:'data',
        fields:[
            {name: 'co_proceso'},
            {name: 'tx_proceso'}
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
Ext.onReady(revisionEditar.main.init, revisionEditar.main);
</script>
<div id="requisito" ></div>
