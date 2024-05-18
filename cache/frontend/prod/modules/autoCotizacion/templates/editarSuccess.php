<script type="text/javascript">
Ext.ns("CotizacionEditar");
CotizacionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_SERVICIO = this.getStoreCO_SERVICIO();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>

//<ClavePrimaria>
this.co_compras = new Ext.form.Hidden({
    name:'co_compras',
    value:this.OBJ.co_compras});
//</ClavePrimaria>


this.co_requisicion = new Ext.form.NumberField({
	fieldLabel:'Co requisicion',
	name:'tb052_compras[co_requisicion]',
	value:this.OBJ.co_requisicion,
	allowBlank:false
});

this.co_ente = new Ext.form.NumberField({
	fieldLabel:'Co ente',
	name:'tb052_compras[co_ente]',
	value:this.OBJ.co_ente,
	allowBlank:false
});

this.co_usuario = new Ext.form.NumberField({
	fieldLabel:'Co usuario',
	name:'tb052_compras[co_usuario]',
	value:this.OBJ.co_usuario,
	allowBlank:false
});

this.fecha_compra = new Ext.form.DateField({
	fieldLabel:'Fecha compra',
	name:'tb052_compras[fecha_compra]',
	value:this.OBJ.fecha_compra,
	allowBlank:false,
	width:100
});

this.tx_observacion = new Ext.form.TextField({
	fieldLabel:'Tx observacion',
	name:'tb052_compras[tx_observacion]',
	value:this.OBJ.tx_observacion,
	allowBlank:false,
	width:200
});

this.co_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co solicitud',
	name:'tb052_compras[co_solicitud]',
	value:this.OBJ.co_solicitud,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tb052_compras[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.co_proveedor = new Ext.form.NumberField({
	fieldLabel:'Co proveedor',
	name:'tb052_compras[co_proveedor]',
	value:this.OBJ.co_proveedor,
	allowBlank:false
});

this.anio = new Ext.form.NumberField({
	fieldLabel:'Anio',
	name:'tb052_compras[anio]',
	value:this.OBJ.anio,
	allowBlank:false
});

this.co_servicio = new Ext.form.ComboBox({
	fieldLabel:'Co servicio',
	store: this.storeCO_SERVICIO,
	typeAhead: true,
	valueField: 'co_servicio',
	displayField:'co_servicio',
	hiddenName:'tb052_compras[co_servicio]',
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
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_servicio,
	value:  this.OBJ.co_servicio,
	objStore: this.storeCO_SERVICIO
});

this.co_tipo_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co tipo solicitud',
	name:'tb052_compras[co_tipo_solicitud]',
	value:this.OBJ.co_tipo_solicitud,
	allowBlank:false
});

this.nu_iva = new Ext.form.NumberField({
	fieldLabel:'Nu iva',
	name:'tb052_compras[nu_iva]',
	value:this.OBJ.nu_iva,
	allowBlank:false
});

this.monto_iva = new Ext.form.NumberField({
	fieldLabel:'Monto iva',
	name:'tb052_compras[monto_iva]',
	value:this.OBJ.monto_iva,
	allowBlank:false
});

this.monto_sub_total = new Ext.form.NumberField({
	fieldLabel:'Monto sub total',
	name:'tb052_compras[monto_sub_total]',
	value:this.OBJ.monto_sub_total,
	allowBlank:false
});

this.monto_total = new Ext.form.NumberField({
	fieldLabel:'Monto total',
	name:'tb052_compras[monto_total]',
	value:this.OBJ.monto_total,
	allowBlank:false
});

this.co_ejecutor = new Ext.form.NumberField({
	fieldLabel:'Co ejecutor',
	name:'tb052_compras[co_ejecutor]',
	value:this.OBJ.co_ejecutor,
	allowBlank:false
});

this.co_proyecto_ac = new Ext.form.NumberField({
	fieldLabel:'Co proyecto ac',
	name:'tb052_compras[co_proyecto_ac]',
	value:this.OBJ.co_proyecto_ac,
	allowBlank:false
});

this.co_accion_especifica = new Ext.form.NumberField({
	fieldLabel:'Co accion especifica',
	name:'tb052_compras[co_accion_especifica]',
	value:this.OBJ.co_accion_especifica,
	allowBlank:false
});

this.co_partida_iva = new Ext.form.NumberField({
	fieldLabel:'Co partida iva',
	name:'tb052_compras[co_partida_iva]',
	value:this.OBJ.co_partida_iva,
	allowBlank:false
});

this.co_partida_presupuesto = new Ext.form.ComboBox({
	fieldLabel:'Co partida presupuesto',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb052_compras[co_partida_presupuesto]',
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
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_partida_presupuesto,
	value:  this.OBJ.co_partida_presupuesto,
	objStore: this.storeID
});

this.co_tipo_movimiento = new Ext.form.ComboBox({
	fieldLabel:'Co tipo movimiento',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb052_compras[co_tipo_movimiento]',
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
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tipo_movimiento,
	value:  this.OBJ.co_tipo_movimiento,
	objStore: this.storeID
});

this.numero_compra = new Ext.form.TextField({
	fieldLabel:'Numero compra',
	name:'tb052_compras[numero_compra]',
	value:this.OBJ.numero_compra,
	allowBlank:false,
	width:200
});

this.mo_pagado = new Ext.form.NumberField({
	fieldLabel:'Mo pagado',
	name:'tb052_compras[mo_pagado]',
	value:this.OBJ.mo_pagado,
	allowBlank:false
});

this.mo_restante = new Ext.form.NumberField({
	fieldLabel:'Mo restante',
	name:'tb052_compras[mo_restante]',
	value:this.OBJ.mo_restante,
	allowBlank:false
});

this.nu_orden_compra = new Ext.form.TextField({
	fieldLabel:'Nu orden compra',
	name:'tb052_compras[nu_orden_compra]',
	value:this.OBJ.nu_orden_compra,
	allowBlank:false,
	width:200
});

this.in_responsabilidad_social = new Ext.form.Checkbox({
	fieldLabel:'In responsabilidad social',
	name:'tb052_compras[in_responsabilidad_social]',
	checked:(this.OBJ.in_responsabilidad_social=='0') ? true:false,
	allowBlank:false
});

this.in_anulado = new Ext.form.Checkbox({
	fieldLabel:'In anulado',
	name:'tb052_compras[in_anulado]',
	checked:(this.OBJ.in_anulado=='0') ? true:false,
	allowBlank:false
});

this.co_solicitud_anular = new Ext.form.NumberField({
	fieldLabel:'Co solicitud anular',
	name:'tb052_compras[co_solicitud_anular]',
	value:this.OBJ.co_solicitud_anular,
	allowBlank:false
});

this.in_anular = new Ext.form.Checkbox({
	fieldLabel:'In anular',
	name:'tb052_compras[in_anular]',
	checked:(this.OBJ.in_anular=='0') ? true:false,
	allowBlank:false
});

this.co_ramo = new Ext.form.NumberField({
	fieldLabel:'Co ramo',
	name:'tb052_compras[co_ramo]',
	value:this.OBJ.co_ramo,
	allowBlank:false
});

this.forma_pago = new Ext.form.TextField({
	fieldLabel:'Forma pago',
	name:'tb052_compras[forma_pago]',
	value:this.OBJ.forma_pago,
	allowBlank:false,
	width:200
});

this.forma_entrega = new Ext.form.TextField({
	fieldLabel:'Forma entrega',
	name:'tb052_compras[forma_entrega]',
	value:this.OBJ.forma_entrega,
	allowBlank:false,
	width:200
});

this.co_solicitud_cotizacion = new Ext.form.NumberField({
	fieldLabel:'Co solicitud cotizacion',
	name:'tb052_compras[co_solicitud_cotizacion]',
	value:this.OBJ.co_solicitud_cotizacion,
	allowBlank:false
});

this.tx_concepto = new Ext.form.TextField({
	fieldLabel:'Tx concepto',
	name:'tb052_compras[tx_concepto]',
	value:this.OBJ.tx_concepto,
	allowBlank:false,
	width:200
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!CotizacionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        CotizacionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/guardar',
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
                 CotizacionLista.main.store_lista.load();
                 CotizacionEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        CotizacionEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_compras,
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
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Cotizacion',
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
CotizacionLista.main.mascara.hide();
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
Ext.onReady(CotizacionEditar.main.init, CotizacionEditar.main);
</script>
