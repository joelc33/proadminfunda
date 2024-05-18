<script type="text/javascript">
Ext.ns("agregarImagen");
agregarImagen.main= {
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
	title: 'Archivo de Imagen',
	items:[{
                            xtype: 'fileuploadfield',
                            style:"padding-right:330px",
                            id: 'form-file',
                            emptyText: 'Seleccione una Imagen',
                            fieldLabel: 'Imagen (jpg)',
                            name: 'form-file',
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
    handler:function(){
        agregarImagen.main.winformPanel_.close();
    }
});

this.guardar = new Ext.Button({
    text:'Subir Imagen',
    iconCls: 'icon-guardar',
    handler:function(){
       agregarImagen.main.onEnviar();
    }
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Imagen',
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

        if(!agregarImagen.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }

        agregarImagen.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/guardarImagen',
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
               
                Detalle.main.store_lista.baseParams.co_solicitud = agregarImagen.main.OBJ.co_solicitud;
                Detalle.main.store_lista.load();
                agregarImagen.main.winformPanel_.close();
             }
        });

}

};
Ext.onReady(agregarImagen.main.init, agregarImagen.main);
</script>
