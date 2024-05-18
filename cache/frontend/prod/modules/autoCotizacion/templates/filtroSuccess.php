<script type="text/javascript">
Ext.ns("CotizacionFiltro");
CotizacionFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_SERVICIO = this.getStoreCO_SERVICIO();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>



this.co_requisicion = new Ext.form.NumberField({
	fieldLabel:'Co requisicion',
	name:'co_requisicion',
	value:''
});

this.co_ente = new Ext.form.NumberField({
	fieldLabel:'Co ente',
	name:'co_ente',
	value:''
});

this.co_usuario = new Ext.form.NumberField({
	fieldLabel:'Co usuario',
	name:'co_usuario',
	value:''
});

this.fecha_compra = new Ext.form.DateField({
	fieldLabel:'Fecha compra',
	name:'fecha_compra'
});

this.tx_observacion = new Ext.form.TextField({
	fieldLabel:'Tx observacion',
	name:'tx_observacion',
	value:''
});

this.co_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co solicitud',
	name:'co_solicitud',
	value:''
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

this.co_proveedor = new Ext.form.NumberField({
	fieldLabel:'Co proveedor',
	name:'co_proveedor',
	value:''
});

this.anio = new Ext.form.NumberField({
	fieldLabel:'Anio',
name:'anio',
	value:''
});

this.co_servicio = new Ext.form.ComboBox({
	fieldLabel:'Co servicio',
	store: this.storeCO_SERVICIO,
	typeAhead: true,
	valueField: 'co_servicio',
	displayField:'co_servicio',
	hiddenName:'co_servicio',
	//readOnly:(this.OBJ.co_servicio!='')?true:false,
	//style:(this.main.OBJ.co_servicio!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_servicio',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_SERVICIO.load();

this.co_tipo_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co tipo solicitud',
	name:'co_tipo_solicitud',
	value:''
});

this.nu_iva = new Ext.form.NumberField({
	fieldLabel:'Nu iva',
name:'nu_iva',
	value:''
});

this.monto_iva = new Ext.form.NumberField({
	fieldLabel:'Monto iva',
name:'monto_iva',
	value:''
});

this.monto_sub_total = new Ext.form.NumberField({
	fieldLabel:'Monto sub total',
name:'monto_sub_total',
	value:''
});

this.monto_total = new Ext.form.NumberField({
	fieldLabel:'Monto total',
name:'monto_total',
	value:''
});

this.co_ejecutor = new Ext.form.NumberField({
	fieldLabel:'Co ejecutor',
	name:'co_ejecutor',
	value:''
});

this.co_proyecto_ac = new Ext.form.NumberField({
	fieldLabel:'Co proyecto ac',
	name:'co_proyecto_ac',
	value:''
});

this.co_accion_especifica = new Ext.form.NumberField({
	fieldLabel:'Co accion especifica',
	name:'co_accion_especifica',
	value:''
});

this.co_partida_iva = new Ext.form.NumberField({
	fieldLabel:'Co partida iva',
	name:'co_partida_iva',
	value:''
});

this.co_partida_presupuesto = new Ext.form.ComboBox({
	fieldLabel:'Co partida presupuesto',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'co_partida_presupuesto',
	//readOnly:(this.OBJ.co_partida_presupuesto!='')?true:false,
	//style:(this.main.OBJ.co_partida_presupuesto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_partida_presupuesto',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.co_tipo_movimiento = new Ext.form.ComboBox({
	fieldLabel:'Co tipo movimiento',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'co_tipo_movimiento',
	//readOnly:(this.OBJ.co_tipo_movimiento!='')?true:false,
	//style:(this.main.OBJ.co_tipo_movimiento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_movimiento',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.numero_compra = new Ext.form.TextField({
	fieldLabel:'Numero compra',
	name:'numero_compra',
	value:''
});

this.mo_pagado = new Ext.form.NumberField({
	fieldLabel:'Mo pagado',
name:'mo_pagado',
	value:''
});

this.mo_restante = new Ext.form.NumberField({
	fieldLabel:'Mo restante',
name:'mo_restante',
	value:''
});

this.nu_orden_compra = new Ext.form.TextField({
	fieldLabel:'Nu orden compra',
	name:'nu_orden_compra',
	value:''
});

this.in_responsabilidad_social = new Ext.form.Checkbox({
	fieldLabel:'In responsabilidad social',
	name:'in_responsabilidad_social',
	checked:true
});

this.in_anulado = new Ext.form.Checkbox({
	fieldLabel:'In anulado',
	name:'in_anulado',
	checked:true
});

this.co_solicitud_anular = new Ext.form.NumberField({
	fieldLabel:'Co solicitud anular',
	name:'co_solicitud_anular',
	value:''
});

this.in_anular = new Ext.form.Checkbox({
	fieldLabel:'In anular',
	name:'in_anular',
	checked:true
});

this.co_ramo = new Ext.form.NumberField({
	fieldLabel:'Co ramo',
	name:'co_ramo',
	value:''
});

this.forma_pago = new Ext.form.TextField({
	fieldLabel:'Forma pago',
	name:'forma_pago',
	value:''
});

this.forma_entrega = new Ext.form.TextField({
	fieldLabel:'Forma entrega',
	name:'forma_entrega',
	value:''
});

this.co_solicitud_cotizacion = new Ext.form.NumberField({
	fieldLabel:'Co solicitud cotizacion',
	name:'co_solicitud_cotizacion',
	value:''
});

this.tx_concepto = new Ext.form.TextField({
	fieldLabel:'Tx concepto',
	name:'tx_concepto',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_requisicion,
                                                                                this.co_ente,
                                                                                this.co_usuario,
                                                                                this.fecha_compra,
                                                                                this.tx_observacion,
                                                                                this.co_solicitud,
                                                                                this.created_at,
                                                                                this.co_proveedor,
                                                                                this.anio,
                                                                                this.co_servicio,
                                                                                this.co_tipo_solicitud,
                                                                                this.nu_iva,
                                                                                this.monto_iva,
                                                                                this.monto_sub_total,
                                                                                this.monto_total,
                                                                                this.co_ejecutor,
                                                                                this.co_proyecto_ac,
                                                                                this.co_accion_especifica,
                                                                                this.co_partida_iva,
                                                                                this.co_partida_presupuesto,
                                                                                this.co_tipo_movimiento,
                                                                                this.numero_compra,
                                                                                this.mo_pagado,
                                                                                this.mo_restante,
                                                                                this.nu_orden_compra,
                                                                                this.in_responsabilidad_social,
                                                                                this.in_anulado,
                                                                                this.co_solicitud_anular,
                                                                                this.in_anular,
                                                                                this.co_ramo,
                                                                                this.forma_pago,
                                                                                this.forma_entrega,
                                                                                this.co_solicitud_cotizacion,
                                                                                this.tx_concepto,
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
                     CotizacionFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    CotizacionFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    CotizacionFiltro.main.win.close();
                    CotizacionLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    CotizacionLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    CotizacionFiltro.main.panelfiltro.getForm().reset();
    CotizacionLista.main.store_lista.baseParams={}
    CotizacionLista.main.store_lista.baseParams.paginar = 'si';
    CotizacionLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = CotizacionFiltro.main.panelfiltro.getForm().getValues();
    CotizacionLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("CotizacionLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        CotizacionLista.main.store_lista.baseParams.paginar = 'si';
        CotizacionLista.main.store_lista.baseParams.BuscarBy = true;
        CotizacionLista.main.store_lista.load();


}
,getStoreCO_SERVICIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/storefkcoservicio',
        root:'data',
        fields:[
            {name: 'co_servicio'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/storefkcopartidapresupuesto',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/storefkcotipomovimiento',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(CotizacionFiltro.main.init,CotizacionFiltro.main);
</script>