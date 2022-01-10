<script type="text/javascript">
Ext.ns("ConfigTipoSituacionEditar");
ConfigTipoSituacionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_nom_situacion = new Ext.form.Hidden({
    name:'co_nom_situacion',
    value:this.OBJ.co_nom_situacion});
//</ClavePrimaria>


this.tx_nom_situacion = new Ext.form.TextField({
	fieldLabel:'Situacion',
	name:'tbrh024_nom_situacion[tx_nom_situacion]',
	value:this.OBJ.tx_nom_situacion,
	allowBlank:false,
	width:450
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConfigTipoSituacionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfigTipoSituacionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigTipoSituacion/guardar',
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
                 ConfigTipoSituacionLista.main.store_lista.load();
                 ConfigTipoSituacionEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigTipoSituacionEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_nom_situacion,
                    this.tx_nom_situacion
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Config Tipo Situacion',
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
ConfigTipoSituacionLista.main.mascara.hide();
}
};
Ext.onReady(ConfigTipoSituacionEditar.main.init, ConfigTipoSituacionEditar.main);
</script>
