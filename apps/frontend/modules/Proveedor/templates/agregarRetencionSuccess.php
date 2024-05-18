<script type="text/javascript">
Ext.ns("agregarRetencion");
agregarRetencion.main = {
init:function(){

//<Stores de fk>

this.storeCO_CLASE_RETENCION = this.getStoreCO_CLASE_RETENCION();
this.storeCO_TIPO_RETENCION = this.getStoreCO_TIPO_RETENCION();

this.co_clase_retencion = new Ext.form.ComboBox({
	fieldLabel:'Clase Retencion',
	store: this.storeCO_CLASE_RETENCION,
	typeAhead: true,
	valueField: 'co_clase_retencion',
	displayField:'tx_clase_retencion',
	hiddenName:'co_clase_retencion',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
        allowBlank:false,
	mode: 'local',
	width:250
});

this.storeCO_CLASE_RETENCION.load();
this.co_clase_retencion.on('select',function(cmb,record,index){
var list_tipo_retencion = paqueteComunJS.funcion.getJsonByObjStore({
        store:ProveedorEditar.main.gridRetenciones.getStore()
});    
        agregarRetencion.main.co_tipo_retencion.clearValue();
        agregarRetencion.main.storeCO_TIPO_RETENCION.load({
            params:{
                co_clase_retencion:record.get('co_clase_retencion'),
                json_tipo_retencion:list_tipo_retencion
            }
        });
},this);

this.co_tipo_retencion = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Retención',
	store: this.storeCO_TIPO_RETENCION,
	typeAhead: true,
	valueField: 'co_tipo_retencion',
	displayField:'tx_tipo_retencion',
	hiddenName:'co_tipo_retencion',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
        allowBlank:false,
	width:250
});


this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

    if (agregarRetencion.main.formPanel_.form.isValid()) {
                   
                var e = new ProveedorEditar.main.RegistroCuentaBancaria({ 
                    co_retencion_proveedor: '',
                    co_tipo_retencion: agregarRetencion.main.co_tipo_retencion.getValue(),
                    tx_tipo_retencion: agregarRetencion.main.co_tipo_retencion.lastSelectionText,
                });

                var cant = ProveedorEditar.main.store_lista_retenciones.getCount();
                (cant == 0) ? 0 : ProveedorEditar.main.store_lista_retenciones.getCount() + 1;
                ProveedorEditar.main.store_lista_retenciones.insert(cant, e);
              
                ProveedorEditar.main.gridRetenciones.getView().refresh();
                agregarRetencion.main.winformPanel_.close();

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
        agregarRetencion.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:500,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
                this.co_clase_retencion,
                this.co_tipo_retencion,
            
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Retención',
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
,getStoreCO_CLASE_RETENCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcoclaseretencion',
        root:'data',
        fields:[
            {name: 'co_clase_retencion'},
            {name: 'tx_clase_retencion'}
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
Ext.onReady(agregarRetencion.main.init, agregarRetencion.main);
</script>
