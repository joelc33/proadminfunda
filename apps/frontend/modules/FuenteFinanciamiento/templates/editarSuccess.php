<script type="text/javascript">
Ext.ns("FuenteFinanciamientoEditar");
FuenteFinanciamientoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_fuente_financiamiento = new Ext.form.Hidden({
    name:'co_fuente_financiamiento',
    value:this.OBJ.co_fuente_financiamiento});
//</ClavePrimaria>


this.tx_fuente_financiamiento = new Ext.form.TextField({
	fieldLabel:'Fuente Financiamiento',
	name:'tb073_fuente_financiamiento[tx_fuente_financiamiento]',
	value:this.OBJ.tx_fuente_financiamiento,
	allowBlank:false,
	width:200
});

this.tx_siglas = new Ext.form.TextField({
	fieldLabel:'Siglas',
	name:'tb073_fuente_financiamiento[tx_siglas]',
	value:this.OBJ.tx_siglas,
	allowBlank:false,
	width:200
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'Activo',
	name:'tb073_fuente_financiamiento[in_activo]',
	checked:(this.OBJ.in_activo=='1') ? true:false,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!FuenteFinanciamientoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        FuenteFinanciamientoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FuenteFinanciamiento/guardar',
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
                 FuenteFinanciamientoLista.main.store_lista.load();
                 FuenteFinanciamientoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        FuenteFinanciamientoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_fuente_financiamiento,
                    this.tx_fuente_financiamiento,
                    this.tx_siglas,
                    this.in_activo,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Fuentes de Financiamiento',
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
FuenteFinanciamientoLista.main.mascara.hide();
}
};
Ext.onReady(FuenteFinanciamientoEditar.main.init, FuenteFinanciamientoEditar.main);
</script>
