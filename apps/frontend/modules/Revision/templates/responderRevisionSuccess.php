<script type="text/javascript">
Ext.ns("responderRevisionEditar");
responderRevisionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.storeCO_ESTATUS = this.getStoreCO_ESTATUS();
//<Stores de fk>

//<ClavePrimaria>
this.co_revision = new Ext.form.Hidden({
    name:'co_revision',
    value:this.OBJ.co_revision
});

this.co_ruta = new Ext.form.Hidden({
    name:'co_ruta',
    value:this.OBJ.co_ruta
});

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




this.fielset1 = new Ext.form.FieldSet({
              title:'Datos de la Solicitud',
              width:670,
              items:[this.co_ruta,                           
                    this.nu_cedula,
                    this.nb_persona,
		    this.co_tipo_solicitud,
		    this.observacion,
                    this.co_revision
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



this.guardar = new Ext.Button({
    text:'Responder',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!responderRevisionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        responderRevisionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Revision/guardarRespuesta',
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
                 
                 listaRevision.main.store_lista.load();
                 responderRevisionEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        responderRevisionEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    fileUpload: true,
    width:700,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.fielset1,this.fieldImagen]
});

this.winformPanel_ = new Ext.Window({
    title:'Respuesta Revisión',
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
//pendienteEntidadesLista.main.mascara.hide();
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
Ext.onReady(responderRevisionEditar.main.init, responderRevisionEditar.main);
</script>
<div id="requisito" ></div>
