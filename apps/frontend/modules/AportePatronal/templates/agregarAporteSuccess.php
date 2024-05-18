<script type="text/javascript">
Ext.ns("agregarAporte");
agregarAporte.main = {
init:function(){

//<Stores de fk>

//this.storeCO_CLASE_RETENCION = this.getStoreCO_CLASE_RETENCION();

this.storeCO_APORTE_PATRONAL = this.getStoreCO_APORTE_PATRONAL();
this.storeNomina = this.getStoreNomina();

this.nu_monto = 0;
       
this.co_aporte_patronal = new Ext.form.ComboBox({
	fieldLabel:'Aporte Patronal',
	store: this.storeCO_APORTE_PATRONAL,
	typeAhead: true,
	valueField: 'co_aporte_patronal',
	displayField:'tx_descripcion',
	hiddenName:'co_aporte_patronal',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
        allowBlank:false,
	mode: 'local',
	width:350
});

this.storeCO_APORTE_PATRONAL.load();
this.co_aporte_patronal.on('select',function(cmb,record,index){
    
        var list_aporte = paqueteComunJS.funcion.getJsonByObjStore({
                store:AportePatronalEditar.main.gridPanel.getStore()
        });
    
        agregarAporte.main.co_aporte_patronal_nomina.clearValue();
        agregarAporte.main.storeNomina.load({
            params:{
                tx_movimiento:record.get('tx_movimiento'),
                json_aporte:list_aporte
            }
        });
},this);


this.co_aporte_patronal_nomina = new Ext.form.ComboBox({
	fieldLabel:'Nomina',
	store: this.storeNomina,
	typeAhead: true,
	valueField: 'co_aporte_patronal_nomina',
	displayField:'tx_serial_nomina',
	hiddenName:'co_aporte_patronal_nomina',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
        allowBlank:false,
	mode: 'local',
	width:350
});

this.co_aporte_patronal_nomina.on('select',function(cmb,record,index){
        agregarAporte.main.monto.setValue(paqueteComunJS.funcion.getNumeroFormateado(record.get('mo_aporte')));
        agregarAporte.main.nu_monto = record.get('mo_aporte');
},this);

this.monto = new Ext.form.TextField({
	fieldLabel:'Monto',
	name:'monto',
        readOnly:true,
	style:'background:#c9c9c9;',
	allowBlank:false,
	width:350
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

    if (agregarAporte.main.formPanel_.form.isValid()) {
                   
                var e = new AportePatronalEditar.main.Registro({ 
                    co_solicitud_aporte: '',
                    co_detalle_compras: '',
                    co_aporte_patronal_nomina: agregarAporte.main.co_aporte_patronal_nomina.getValue(),
                    tx_aporte_patronal_nomina: agregarAporte.main.co_aporte_patronal_nomina.lastSelectionText,
                    co_aporte_patronal: agregarAporte.main.co_aporte_patronal.getValue(),
                    tx_aporte_patronal: agregarAporte.main.co_aporte_patronal.lastSelectionText,
                    monto: agregarAporte.main.nu_monto
                });

                var cant = AportePatronalEditar.main.store_lista.getCount();
                (cant == 0) ? 0 : AportePatronalEditar.main.store_lista.getCount() + 1;
                AportePatronalEditar.main.store_lista.insert(cant, e);
              
                AportePatronalEditar.main.gridPanel.getView().refresh();
                AportePatronalEditar.main.getCalcular();
                agregarAporte.main.winformPanel_.close();

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
        agregarAporte.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:500,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
                this.co_aporte_patronal,
                this.co_aporte_patronal_nomina,
                this.monto
            
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Aporte Patronal',
    modal:true,
    constrain:true,
    width:500,
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
Ext.onReady(agregarAporte.main.init, agregarAporte.main);
</script>
