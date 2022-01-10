<script type="text/javascript">
Ext.ns("NivelJerarquicoEditar");
NivelJerarquicoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_nivel_jerarquico = new Ext.form.Hidden({
    name:'co_nivel_jerarquico',
    value:this.OBJ.co_nivel_jerarquico});
//</ClavePrimaria>


this.tx_nivel_jerarquico = new Ext.form.TextField({
	fieldLabel:'Nivel Jerarquico',
	name:'tbrh004_nivel_jerarquico[tx_nivel_jerarquico]',
	value:this.OBJ.tx_nivel_jerarquico,
	allowBlank:false,
	width:200
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!NivelJerarquicoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        NivelJerarquicoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NivelJerarquico/guardar',
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
                 NivelJerarquicoLista.main.store_lista.load();
                 NivelJerarquicoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        NivelJerarquicoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_nivel_jerarquico,
                    this.tx_nivel_jerarquico,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Nivel Jerarquico',
    modal:true,
    constrain:true,
width:400,
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
NivelJerarquicoLista.main.mascara.hide();
}
};
Ext.onReady(NivelJerarquicoEditar.main.init, NivelJerarquicoEditar.main);
</script>
