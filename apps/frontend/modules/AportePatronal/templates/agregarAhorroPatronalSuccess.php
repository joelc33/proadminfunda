<script type="text/javascript">
Ext.ns("agregarAhorroPatronal");
agregarAhorroPatronal.main = {
init:function(){

//<Stores de fk>

//this.storeCO_CLASE_RETENCION = this.getStoreCO_CLASE_RETENCION();

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud,
});

this.concepto = new Ext.form.TextField({
    fieldLabel:'Concepto de Nomina',
    name:'tx_tipo_nomina',    
    allowBlank:false,
    width:450
});

this.monto = new Ext.form.TextField({
	fieldLabel:'Monto Aporte',
	name:'mo_aporte',
	allowBlank:false,
	width:250
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

    if (agregarAhorroPatronal.main.formPanel_.form.isValid()) {
                   
            agregarAhorroPatronal.main.formPanel_.getForm().submit({
                method:'POST',
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/AportePatronal/guardarAhorroPatronal',
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
 
                    agregarAhorroPatronal.main.winformPanel_.close();
                 }
            });

        }
        else {
            Ext.Msg.show({
                title: 'Mensaje',
                msg: 'Debe llenar los campos requeridos',
                buttons: Ext.Msg.OK,
                animEl: document.body,
                icon: Ext.MessageBox.INFO
            });
        }

   
    }
});


this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        agregarAhorroPatronal.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
                this.co_solicitud,
                this.concepto,
                this.monto            
          ]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Aporte Patronal',
    modal:true,
    constrain:true,
    width:600,
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
}
,getStoreCO_APORTE_PATRONAL:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcoaportesocial',
        root:'data',
        fields:[
                {name: 'co_aporte_patronal'},
                {name: 'tx_movimiento'},
                {name: 'tx_descripcion',
                    convert:function(v,r){
                    return r.tx_movimiento+' - '+r.tx_descripcion;
                    }
                }
            ]
    });
    return this.store;
}
,getStoreNomina:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/AportePatronal/storefknomina',
        root:'data',
        fields:[
                {name: 'co_aporte_patronal_nomina'},
                {name: 'tx_tipo_nomina'},
                {name: 'mo_aporte'},
                {name: 'tx_serial_nomina',
                    convert:function(v,r){
                    return r.tx_serial_nomina+' - '+r.tx_tipo_nomina;
                    }
                }
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_RETENCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcotiporetencion',
        root:'data',
        fields:[
            {name: 'co_tipo_retencion'},
            {name: 'tx_tipo_retencion'}
            ]
    });
    return this.store;
}
};
Ext.onReady(agregarAhorroPatronal.main.init, agregarAhorroPatronal.main);
</script>
