<script type="text/javascript">
Ext.ns("ConfigCampoAdicionalEditar");
ConfigCampoAdicionalEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_concep_adicional = new Ext.form.Hidden({
    name:'co_concep_adicional',
    value:this.OBJ.co_concep_adicional});
//</ClavePrimaria>


this.tx_concep_adicional = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tbrh019_concep_adicional[tx_concep_adicional]',
	value:this.OBJ.tx_concep_adicional,
	allowBlank:false,
	width:450
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConfigCampoAdicionalEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfigCampoAdicionalEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigCampoAdicional/guardar',
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
                 ConfigCampoAdicionalLista.main.store_lista.load();
                 ConfigCampoAdicionalEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigCampoAdicionalEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_concep_adicional,
                    this.tx_concep_adicional,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Config Campo Adicional',
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
ConfigCampoAdicionalLista.main.mascara.hide();
}
};
Ext.onReady(ConfigCampoAdicionalEditar.main.init, ConfigCampoAdicionalEditar.main);
</script>
