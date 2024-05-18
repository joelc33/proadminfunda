<script type="text/javascript">
Ext.ns("FuenteIngresoEditar");
FuenteIngresoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_fuente_ingreso = new Ext.form.Hidden({
    name:'co_fuente_ingreso',
    value:this.OBJ.co_fuente_ingreso
});
//</ClavePrimaria>


this.tx_fuente_ingreso = new Ext.form.TextField({
	fieldLabel:'Descripción',
	name:'tb124_fuente_ingreso[tx_fuente_ingreso]',
	value:this.OBJ.tx_fuente_ingreso,
	allowBlank:false,
	width:500
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!FuenteIngresoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        FuenteIngresoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FuenteIngreso/guardar',
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
                 FuenteIngresoLista.main.store_lista.load();
                 FuenteIngresoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        FuenteIngresoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:700,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_fuente_ingreso,
                    this.tx_fuente_ingreso,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Fuente de Ingreso',
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
FuenteIngresoLista.main.mascara.hide();
}
};
Ext.onReady(FuenteIngresoEditar.main.init, FuenteIngresoEditar.main);
</script>
