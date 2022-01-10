<script type="text/javascript">
Ext.ns("ImportarEditar");
ImportarEditar.main = {
init:function(){

this.fieldArchivo = new Ext.form.FieldSet({
	title: 'Archivo',
	items:[{
            xtype: 'fileuploadfield',
            style:"padding-right:200px",
            emptyText: 'Seleccione un Archivo',
            fieldLabel: 'Documento (xls)',
            name: 'archivo',
            buttonText: 'Buscar'            
    }]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ImportarEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ImportarEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoMasivo/guardarCarga',
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
                 PresupuestoMasivoLista.main.store_lista.load();
                 ImportarEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ImportarEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
	fileUpload: true,
    frame:true,
    width:600,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
		this.fieldArchivo
    ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Importar Presupuesto',
    modal:true,
    constrain:true,
width:614,
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
PresupuestoMasivoLista.main.mascara.hide();
}
};
Ext.onReady(ImportarEditar.main.init, ImportarEditar.main);
</script>
