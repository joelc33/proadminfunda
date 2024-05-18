<script type="text/javascript">
Ext.ns("ConfigTipoAcumuladoEditar");
ConfigTipoAcumuladoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_nom_acumulado = new Ext.form.Hidden({
    name:'co_nom_acumulado',
    value:this.OBJ.co_nom_acumulado});
//</ClavePrimaria>


this.tx_nom_acumulado = new Ext.form.TextField({
	fieldLabel:'Tipo de Acumulado',
	name:'tbrh021_nom_acumulado[tx_nom_acumulado]',
	value:this.OBJ.tx_nom_acumulado,
	allowBlank:false,
	width:400
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConfigTipoAcumuladoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfigTipoAcumuladoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigTipoAcumulado/guardar',
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
                 ConfigTipoAcumuladoLista.main.store_lista.load();
                 ConfigTipoAcumuladoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigTipoAcumuladoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
autoHeight:true,  
    autoScroll:true,
    labelWidth: 150,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_nom_acumulado,
                    this.tx_nom_acumulado,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Config Tipo Acumulado',
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
ConfigTipoAcumuladoLista.main.mascara.hide();
}
};
Ext.onReady(ConfigTipoAcumuladoEditar.main.init, ConfigTipoAcumuladoEditar.main);
</script>
