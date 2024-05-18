<script type="text/javascript">
Ext.ns("ConfigTipoFrecuenciaEditar");
ConfigTipoFrecuenciaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_nom_frecuencia_pago = new Ext.form.Hidden({
    name:'co_nom_frecuencia_pago',
    value:this.OBJ.co_nom_frecuencia_pago});
//</ClavePrimaria>


this.tx_nom_frecuencia_pago = new Ext.form.TextField({
	fieldLabel:'Frecuencia Pago',
	name:'tbrh023_nom_frecuencia_pago[tx_nom_frecuencia_pago]',
	value:this.OBJ.tx_nom_frecuencia_pago,
	allowBlank:false,
	width:450
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConfigTipoFrecuenciaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfigTipoFrecuenciaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigTipoFrecuencia/guardar',
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
                 ConfigTipoFrecuenciaLista.main.store_lista.load();
                 ConfigTipoFrecuenciaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigTipoFrecuenciaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_nom_frecuencia_pago,
                    this.tx_nom_frecuencia_pago
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Config Tipo Frecuencia',
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
ConfigTipoFrecuenciaLista.main.mascara.hide();
}
};
Ext.onReady(ConfigTipoFrecuenciaEditar.main.init, ConfigTipoFrecuenciaEditar.main);
</script>
