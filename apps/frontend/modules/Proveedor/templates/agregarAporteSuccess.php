<script type="text/javascript">
Ext.ns("agregarAporte");
agregarAporte.main = {
init:function(){

//<Stores de fk>

this.storeCO_APORTE_PATRONAL = this.getStoreCO_APORTE_PATRONAL();

this.co_aporte_social = new Ext.form.ComboBox({
	fieldLabel:'Tipo Aporte',
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

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

    if (agregarAporte.main.formPanel_.form.isValid()) {
                   
                var e = new ProveedorEditar.main.RegistroAporte({                     
                    co_proveedor:'',
                    co_aporte_patronal: agregarAporte.main.co_aporte_social.getValue(),
                    tx_descripcion: agregarAporte.main.co_aporte_social.lastSelectionText,
                });

                var cant = ProveedorEditar.main.store_lista_aporte_patronal.getCount();
                (cant == 0) ? 0 : ProveedorEditar.main.store_lista_aporte_patronal.getCount() + 1;
                ProveedorEditar.main.store_lista_aporte_patronal.insert(cant, e);
              
                ProveedorEditar.main.gridAportePatronal.getView().refresh();
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
    width:600,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.co_aporte_social]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Retención',
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
                {name: 'tx_descripcion'}
            ]
    });
    return this.store;
}
};
Ext.onReady(agregarAporte.main.init, agregarAporte.main);
</script>
