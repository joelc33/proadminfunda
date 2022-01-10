<script type="text/javascript">
Ext.ns("ServicioBasicoFacturaFiltro");
ServicioBasicoFacturaFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_COMPRAS = this.getStoreCO_COMPRAS();
//<Stores de fk>
//<Stores de fk>
this.storeCO_SOLICITUD = this.getStoreCO_SOLICITUD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_PROVEEDOR = this.getStoreCO_PROVEEDOR();
//<Stores de fk>
//<Stores de fk>
this.storeCO_RAMO = this.getStoreCO_RAMO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_IVA_FACTURA = this.getStoreCO_IVA_FACTURA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ORDEN_PAGO = this.getStoreCO_ORDEN_PAGO();
//<Stores de fk>



this.nu_factura = new Ext.form.TextField({
	fieldLabel:'Nu factura',
	name:'nu_factura',
	value:''
});

this.fe_emision = new Ext.form.DateField({
	fieldLabel:'Fe emision',
	name:'fe_emision'
});

this.nu_base_imponible = new Ext.form.NumberField({
	fieldLabel:'Nu base imponible',
name:'nu_base_imponible',
	value:''
});

this.co_iva_factura = new Ext.form.NumberField({
	fieldLabel:'Co iva factura',
name:'co_iva_factura',
	value:''
});

this.nu_iva_factura = new Ext.form.NumberField({
	fieldLabel:'Nu iva factura',
name:'nu_iva_factura',
	value:''
});

this.nu_total = new Ext.form.NumberField({
	fieldLabel:'Nu total',
name:'nu_total',
	value:''
});

this.co_iva_retencion = new Ext.form.NumberField({
	fieldLabel:'Co iva retencion',
name:'co_iva_retencion',
	value:''
});

this.nu_iva_retencion = new Ext.form.NumberField({
	fieldLabel:'Nu iva retencion',
name:'nu_iva_retencion',
	value:''
});

this.nu_total_retencion = new Ext.form.NumberField({
	fieldLabel:'Nu total retencion',
name:'nu_total_retencion',
	value:''
});

this.total_pagar = new Ext.form.NumberField({
	fieldLabel:'Total pagar',
name:'total_pagar',
	value:''
});

this.tx_concepto = new Ext.form.TextField({
	fieldLabel:'Tx concepto',
	name:'tx_concepto',
	value:''
});

this.co_compra = new Ext.form.ComboBox({
	fieldLabel:'Co compra',
	store: this.storeCO_COMPRAS,
	typeAhead: true,
	valueField: 'co_compras',
	displayField:'co_compras',
	hiddenName:'co_compra',
	//readOnly:(this.OBJ.co_compra!='')?true:false,
	//style:(this.main.OBJ.co_compra!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_compra',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_COMPRAS.load();

this.co_solicitud = new Ext.form.ComboBox({
	fieldLabel:'Co solicitud',
	store: this.storeCO_SOLICITUD,
	typeAhead: true,
	valueField: 'co_solicitud',
	displayField:'co_solicitud',
	hiddenName:'co_solicitud',
	//readOnly:(this.OBJ.co_solicitud!='')?true:false,
	//style:(this.main.OBJ.co_solicitud!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_solicitud',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_SOLICITUD.load();

this.co_proveedor = new Ext.form.ComboBox({
	fieldLabel:'Co proveedor',
	store: this.storeCO_PROVEEDOR,
	typeAhead: true,
	valueField: 'co_proveedor',
	displayField:'co_proveedor',
	hiddenName:'co_proveedor',
	//readOnly:(this.OBJ.co_proveedor!='')?true:false,
	//style:(this.main.OBJ.co_proveedor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_proveedor',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_PROVEEDOR.load();

this.co_ramo = new Ext.form.ComboBox({
	fieldLabel:'Co ramo',
	store: this.storeCO_RAMO,
	typeAhead: true,
	valueField: 'co_ramo',
	displayField:'co_ramo',
	hiddenName:'co_ramo',
	//readOnly:(this.OBJ.co_ramo!='')?true:false,
	//style:(this.main.OBJ.co_ramo!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_ramo',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_RAMO.load();

this.co_iva = new Ext.form.ComboBox({
	fieldLabel:'Co iva',
	store: this.storeCO_IVA_FACTURA,
	typeAhead: true,
	valueField: 'co_iva_factura',
	displayField:'co_iva_factura',
	hiddenName:'co_iva',
	//readOnly:(this.OBJ.co_iva!='')?true:false,
	//style:(this.main.OBJ.co_iva!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_iva',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_IVA_FACTURA.load();

this.co_odp = new Ext.form.ComboBox({
	fieldLabel:'Co odp',
	store: this.storeCO_ORDEN_PAGO,
	typeAhead: true,
	valueField: 'co_orden_pago',
	displayField:'co_orden_pago',
	hiddenName:'co_odp',
	//readOnly:(this.OBJ.co_odp!='')?true:false,
	//style:(this.main.OBJ.co_odp!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_odp',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ORDEN_PAGO.load();

this.nu_control = new Ext.form.TextField({
	fieldLabel:'Nu control',
	name:'nu_control',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.nu_factura,
                                                                                this.fe_emision,
                                                                                this.nu_base_imponible,
                                                                                this.co_iva_factura,
                                                                                this.nu_iva_factura,
                                                                                this.nu_total,
                                                                                this.co_iva_retencion,
                                                                                this.nu_iva_retencion,
                                                                                this.nu_total_retencion,
                                                                                this.total_pagar,
                                                                                this.tx_concepto,
                                                                                this.co_compra,
                                                                                this.co_solicitud,
                                                                                this.co_proveedor,
                                                                                this.co_ramo,
                                                                                this.co_iva,
                                                                                this.co_odp,
                                                                                this.nu_control,
                                           ]
               }
            ]
    });

    this.panelfiltro = new Ext.form.FormPanel({
        frame:true,
        autoWidth:true,
        border:false,
        items:[
            this.tabpanelfiltro
        ]
    });

    this.win = new Ext.Window({
        title:'Parametros de busqueda',
        iconCls: 'icon-buscar',
        width:600,
        autoHeight:true,
        constrain:true,
        closable:false,
        buttonAlign:'center',
        items:[
            this.panelfiltro
        ],
        buttons:[
            {
                text:'Filtrar',
                handler:function(){
                     ServicioBasicoFacturaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ServicioBasicoFacturaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ServicioBasicoFacturaFiltro.main.win.close();
                    ServicioBasicoFacturaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ServicioBasicoFacturaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ServicioBasicoFacturaFiltro.main.panelfiltro.getForm().reset();
    ServicioBasicoFacturaLista.main.store_lista.baseParams={}
    ServicioBasicoFacturaLista.main.store_lista.baseParams.paginar = 'si';
    ServicioBasicoFacturaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ServicioBasicoFacturaFiltro.main.panelfiltro.getForm().getValues();
    ServicioBasicoFacturaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ServicioBasicoFacturaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ServicioBasicoFacturaLista.main.store_lista.baseParams.paginar = 'si';
        ServicioBasicoFacturaLista.main.store_lista.baseParams.BuscarBy = true;
        ServicioBasicoFacturaLista.main.store_lista.load();


}
,getStoreCO_COMPRAS:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ServicioBasicoFactura/storefkcocompra',
        root:'data',
        fields:[
            {name: 'co_compras'}
            ]
    });
    return this.store;
}
,getStoreCO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ServicioBasicoFactura/storefkcosolicitud',
        root:'data',
        fields:[
            {name: 'co_solicitud'}
            ]
    });
    return this.store;
}
,getStoreCO_PROVEEDOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ServicioBasicoFactura/storefkcoproveedor',
        root:'data',
        fields:[
            {name: 'co_proveedor'}
            ]
    });
    return this.store;
}
,getStoreCO_RAMO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ServicioBasicoFactura/storefkcoramo',
        root:'data',
        fields:[
            {name: 'co_ramo'}
            ]
    });
    return this.store;
}
,getStoreCO_IVA_FACTURA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ServicioBasicoFactura/storefkcoiva',
        root:'data',
        fields:[
            {name: 'co_iva_factura'}
            ]
    });
    return this.store;
}
,getStoreCO_ORDEN_PAGO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ServicioBasicoFactura/storefkcoodp',
        root:'data',
        fields:[
            {name: 'co_orden_pago'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ServicioBasicoFacturaFiltro.main.init,ServicioBasicoFacturaFiltro.main);
</script>