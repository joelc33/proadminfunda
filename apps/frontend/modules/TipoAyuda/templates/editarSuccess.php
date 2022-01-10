<script type="text/javascript">
Ext.ns("TipoAyudaEditar");
TipoAyudaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_tipo_ayuda = new Ext.form.Hidden({
    name:'co_tipo_ayuda',
    value:this.OBJ.co_tipo_ayuda});
//</ClavePrimaria>


this.tx_tipo_ayuda = new Ext.form.TextField({
	fieldLabel:'Tipo de Ayuda',
	name:'tb127_tipo_ayuda[tx_tipo_ayuda]',
	value:this.OBJ.tx_tipo_ayuda,
	allowBlank:false,
	width:500
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!TipoAyudaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        TipoAyudaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/TipoAyuda/guardar',
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
                 TipoAyudaLista.main.store_lista.load();
                 TipoAyudaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        TipoAyudaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:700,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_tipo_ayuda,
                    this.tx_tipo_ayuda,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Tipo de Ayuda',
    modal:true,
    constrain:true,
width:700,
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
TipoAyudaLista.main.mascara.hide();
}
};
Ext.onReady(TipoAyudaEditar.main.init, TipoAyudaEditar.main);
</script>
