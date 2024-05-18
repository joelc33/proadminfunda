<script type="text/javascript">
Ext.ns("NovedadTrabajadorEditar");
NovedadTrabajadorEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.co_solicitud = new Ext.form.Hidden({
    name:'tbrh095_trabajador_novedad[co_solicitud]',
    value:this.OBJ.co_solicitud
});

this.fieldImagen = new Ext.form.FieldSet({
	title: 'Archivo',
	items:[{
                            xtype: 'fileuploadfield',
                            style:"padding-right:200px",
                            emptyText: 'Seleccione un Documento',
                            fieldLabel: 'Documento (xls)',
                            name: 'documento',
                            buttonText: 'Buscar'            
                    }]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!NovedadTrabajadorEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        NovedadTrabajadorEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NovedadTrabajador/guardarCarga',
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
                 NovedadTrabajadorLista.main.store_lista.load();
                 NovedadTrabajadorEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        NovedadTrabajadorEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
	fileUpload: true,
    frame:true,
    width:600,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
		this.co_solicitud,
		this.fieldImagen
    ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Novedad Trabajador',
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
NovedadTrabajadorLista.main.mascara.hide();
}
,getStoreCO_TP_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NovedadTrabajador/storefkcotpnomina',
        root:'data',
        fields:[
            {name: 'co_tp_nomina'},
			{name: 'nu_nomina'},
            {
				name: 'nomina',
				convert: function(v, r) {
						return r.nu_nomina + ' - ' + r.tx_tp_nomina;
				}
		    }
            ]
    });
    return this.store;
}
,getStoreCO_GRUPO_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NovedadTrabajador/storefkcogruponomina',
        root:'data',
        fields:[
            {name: 'co_grupo_nomina'},
            {name: 'cod_grupo_nomina'},
            {
				name: 'grupo',
				convert: function(v, r) {
						return r.cod_grupo_nomina + ' - ' + r.tx_grupo_nomina;
				}
		    }
            ]
    });
    return this.store;
}
,getStoreCO_CONCEPTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NovedadTrabajador/storefkcoconcepto',
        root:'data',
        fields:[
            {name: 'co_concepto'},
            {name: 'nu_concepto'},
            {name: 'tx_concepto'},
            {
				name: 'concepto',
				convert: function(v, r) {
						return r.nu_concepto + ' - ' + r.tx_concepto;
				}
		    }
            ]
    });
    return this.store;
}
};
Ext.onReady(NovedadTrabajadorEditar.main.init, NovedadTrabajadorEditar.main);
</script>
