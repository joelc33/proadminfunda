<script type="text/javascript">
Ext.ns("ConfigTipoNominaEditar");
ConfigTipoNominaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_tp_nomina = new Ext.form.Hidden({
    name:'co_tp_nomina',
    value:this.OBJ.co_tp_nomina});
//</ClavePrimaria>


this.tx_tp_nomina = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tbrh017_tp_nomina[tx_tp_nomina]',
	value:this.OBJ.tx_tp_nomina,
	allowBlank:false,
	width:400
});

this.nu_hora = new Ext.form.NumberField({
	fieldLabel:'N° horas trabajo Diario',
	name:'tbrh017_tp_nomina[nu_hora]',
	value:this.OBJ.nu_hora,
	allowBlank:false,
	width:100
});

this.co_nom_tipo_ingreso = new Ext.form.NumberField({
	fieldLabel:'Co nom tipo ingreso',
	name:'tbrh017_tp_nomina[co_nom_tipo_ingreso]',
	value:this.OBJ.co_nom_tipo_ingreso,
	allowBlank:false
});

this.nu_dia_derecho_vacaciones = new Ext.form.NumberField({
	fieldLabel:'Antiguedad para derecho a vacaciones (Dias)',
	name:'tbrh017_tp_nomina[nu_dia_derecho_vacaciones]',
	value:this.OBJ.nu_dia_derecho_vacaciones,
	allowBlank:false,
	width:100
});

this.nu_anio_antiguedad_vacaciones = new Ext.form.NumberField({
	fieldLabel:'Antiguedad para incremento de dias de Vacaciones (Años)',
	name:'tbrh017_tp_nomina[nu_anio_antiguedad_vacaciones]',
	value:this.OBJ.nu_anio_antiguedad_vacaciones,
	allowBlank:false,
	width:100
});

this.nu_dia_vacaciones = new Ext.form.NumberField({
	fieldLabel:'Dias de Vacaciones',
	name:'tbrh017_tp_nomina[nu_dia_vacaciones]',
	value:this.OBJ.nu_dia_vacaciones,
	allowBlank:false,
	width:100
});

this.co_nom_tipo_disfrute = new Ext.form.NumberField({
	fieldLabel:'Co nom tipo disfrute',
	name:'tbrh017_tp_nomina[co_nom_tipo_disfrute]',
	value:this.OBJ.co_nom_tipo_disfrute,
	allowBlank:false
});

this.nu_dia_adicional_anio = new Ext.form.NumberField({
	fieldLabel:'Dias adicionales por Año',
	name:'tbrh017_tp_nomina[nu_dia_adicional_anio]',
	value:this.OBJ.nu_dia_adicional_anio,
	allowBlank:false,
	width:100
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tbrh017_tp_nomina[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tbrh017_tp_nomina[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tbrh017_tp_nomina[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.nu_nomina = new Ext.form.TextField({
	fieldLabel:'Cod. Nomina',
	name:'tbrh017_tp_nomina[nu_nomina]',
	value:this.OBJ.nu_nomina,
	allowBlank:false,
	width:100
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConfigTipoNominaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfigTipoNominaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigTipoNomina/guardar',
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
                 ConfigTipoNominaLista.main.store_lista.load();
                 ConfigTipoNominaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigTipoNominaEditar.main.winformPanel_.close();
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

                    this.co_tp_nomina,
                    this.nu_nomina,
                    this.tx_tp_nomina,
                    this.nu_hora,
                    //this.co_nom_tipo_ingreso,
                    this.nu_dia_derecho_vacaciones,
                    this.nu_anio_antiguedad_vacaciones,
                    this.nu_dia_vacaciones,
                    //this.co_nom_tipo_disfrute,
                    this.nu_dia_adicional_anio,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Config Tipo Nomina',
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
ConfigTipoNominaLista.main.mascara.hide();
}
};
Ext.onReady(ConfigTipoNominaEditar.main.init, ConfigTipoNominaEditar.main);
</script>
