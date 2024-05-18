<script type="text/javascript">
Ext.ns("ConfiguracionRutaEditar");
ConfiguracionRutaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_configuracion = new Ext.form.Hidden({
    name:'co_configuracion',
    value:this.OBJ.co_configuracion});
//</ClavePrimaria>


this.co_tipo_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co tipo solicitud',
	name:'tb032_configuracion_ruta[co_tipo_solicitud]',
	value:this.OBJ.co_tipo_solicitud,
	allowBlank:false
});

this.co_proceso = new Ext.form.NumberField({
	fieldLabel:'Co proceso',
	name:'tb032_configuracion_ruta[co_proceso]',
	value:this.OBJ.co_proceso,
	allowBlank:false
});

this.nu_orden = new Ext.form.NumberField({
	fieldLabel:'Nu orden',
	name:'tb032_configuracion_ruta[nu_orden]',
	value:this.OBJ.nu_orden,
	allowBlank:false
});

this.in_cargar_dato = new Ext.form.Checkbox({
	fieldLabel:'In cargar dato',
	name:'tb032_configuracion_ruta[in_cargar_dato]',
	checked:(this.OBJ.in_cargar_dato=='0') ? true:false,
	allowBlank:false
});

this.nb_reporte_orden = new Ext.form.TextField({
	fieldLabel:'Nb reporte orden',
	name:'tb032_configuracion_ruta[nb_reporte_orden]',
	value:this.OBJ.nb_reporte_orden,
	allowBlank:false,
	width:200
});

this.tx_url = new Ext.form.TextField({
	fieldLabel:'Tx url',
	name:'tb032_configuracion_ruta[tx_url]',
	value:this.OBJ.tx_url,
	allowBlank:false,
	width:200
});

this.tx_modulo = new Ext.form.TextField({
	fieldLabel:'Tx modulo',
	name:'tb032_configuracion_ruta[tx_modulo]',
	value:this.OBJ.tx_modulo,
	allowBlank:false,
	width:200
});

this.in_incompleto = new Ext.form.Checkbox({
	fieldLabel:'In incompleto',
	name:'tb032_configuracion_ruta[in_incompleto]',
	checked:(this.OBJ.in_incompleto=='0') ? true:false,
	allowBlank:false
});

this.op_reporte = new Ext.form.TextField({
	fieldLabel:'Op reporte',
	name:'tb032_configuracion_ruta[op_reporte]',
	value:this.OBJ.op_reporte,
	allowBlank:false,
	width:200
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConfiguracionRutaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfiguracionRutaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfiguracionRuta/guardar',
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
                 ConfiguracionRutaLista.main.store_lista.load();
                 ConfiguracionRutaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfiguracionRutaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_configuracion,
                    this.co_tipo_solicitud,
                    this.co_proceso,
                    this.nu_orden,
                    this.in_cargar_dato,
                    this.nb_reporte_orden,
                    this.tx_url,
                    this.tx_modulo,
                    this.in_incompleto,
                    this.op_reporte,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: ConfiguracionRuta',
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
ConfiguracionRutaLista.main.mascara.hide();
}
};
Ext.onReady(ConfiguracionRutaEditar.main.init, ConfiguracionRutaEditar.main);
</script>
