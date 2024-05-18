<script type="text/javascript">
Ext.ns("agregarDocumento");
agregarDocumento.main= {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.co_ruta = new Ext.form.Hidden({
    name:'co_ruta',
    value:this.OBJ.co_ruta}
);
    
this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud}
);

this.datos = '<p class="registro_detalle"><b>Codigo Solicitud: </b>'+this.OBJ.co_solicitud+'</p>';
this.datos +='<p class="registro_detalle"><b>Tipo de Tramite: </b>'+this.OBJ.co_tipo_solicitud+'</p>';
this.datos +='<p class="registro_detalle"><b>Estado del Tramite: </b>'+this.OBJ.estado+'</p>';

this.fieldDatos = new Ext.form.FieldSet({
	title: 'Datos de la Solicitud',
	html: this.datos
});

this.fieldImagen = new Ext.form.FieldSet({
	title: 'Documento',
	items:[{
                            xtype: 'fileuploadfield',
                            style:"padding-right:330px",
                            id: 'form-pdf',
                            emptyText: 'Seleccione un Documento',
                            fieldLabel: 'Documento (pdf)',
                            name: 'form-pdf',
                            buttonText: 'Buscar'            
                    }]
});



this.formPanel_ = new Ext.form.FormPanel({
    fileUpload: true,
    width:700,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;', 
    items:[this.co_ruta,
           this.co_solicitud,
           this.fieldDatos,
           this.fieldImagen]
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        agregarDocumento.main.winformPanel_.close();
    }
});

this.guardar = new Ext.Button({
    text:'Subir Documento',
    iconCls: 'icon-guardar',
    handler:function(){
        agregarDocumento.main.onEnviar();
    }
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Documento',
    modal:true,
    constrain:true,
    width:710,
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
},
onEnviar: function(){
        if(!agregarDocumento.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        agregarDocumento.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/guardarDocumento',
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
                 
                Detalle.main.store_lista.baseParams.co_solicitud = agregarDocumento.main.OBJ.co_solicitud;
                Detalle.main.store_lista.load();                
                agregarDocumento.main.winformPanel_.close();
             }
        });
}

};
Ext.onReady(agregarDocumento.main.init, agregarDocumento.main);
</script>
