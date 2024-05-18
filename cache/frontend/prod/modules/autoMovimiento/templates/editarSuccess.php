<script type="text/javascript">
Ext.ns("MovimientoEditar");
MovimientoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeCO_USUARIO = this.getStoreCO_USUARIO();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeCO_COMPRAS = this.getStoreCO_COMPRAS();
//<Stores de fk>

//<ClavePrimaria>
this.co_presupuesto_movimiento = new Ext.form.Hidden({
    name:'co_presupuesto_movimiento',
    value:this.OBJ.co_presupuesto_movimiento});
//</ClavePrimaria>


this.co_partida = new Ext.form.ComboBox({
	fieldLabel:'Co partida',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb087_presupuesto_movimiento[co_partida]',
	//readOnly:(this.OBJ.co_partida!='')?true:false,
	//style:(this.main.OBJ.co_partida!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_partida',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_partida,
	value:  this.OBJ.co_partida,
	objStore: this.storeID
});

this.nu_monto = new Ext.form.NumberField({
	fieldLabel:'Nu monto',
	name:'tb087_presupuesto_movimiento[nu_monto]',
	value:this.OBJ.nu_monto,
	allowBlank:false
});

this.nu_anio = new Ext.form.NumberField({
	fieldLabel:'Nu anio',
	name:'tb087_presupuesto_movimiento[nu_anio]',
	value:this.OBJ.nu_anio,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tb087_presupuesto_movimiento[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tb087_presupuesto_movimiento[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.co_usuario = new Ext.form.ComboBox({
	fieldLabel:'Co usuario',
	store: this.storeCO_USUARIO,
	typeAhead: true,
	valueField: 'co_usuario',
	displayField:'co_usuario',
	hiddenName:'tb087_presupuesto_movimiento[co_usuario]',
	//readOnly:(this.OBJ.co_usuario!='')?true:false,
	//style:(this.main.OBJ.co_usuario!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_usuario',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_USUARIO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_usuario,
	value:  this.OBJ.co_usuario,
	objStore: this.storeCO_USUARIO
});

this.co_tipo_movimiento = new Ext.form.ComboBox({
	fieldLabel:'Co tipo movimiento',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb087_presupuesto_movimiento[co_tipo_movimiento]',
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

this.co_detalle_compra = new Ext.form.NumberField({
	fieldLabel:'Co detalle compra',
	name:'tb087_presupuesto_movimiento[co_detalle_compra]',
	value:this.OBJ.co_detalle_compra,
	allowBlank:false
});

this.tx_observacion = new Ext.form.TextField({
	fieldLabel:'Tx observacion',
	name:'tb087_presupuesto_movimiento[tx_observacion]',
	value:this.OBJ.tx_observacion,
	allowBlank:false,
	width:200
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tb087_presupuesto_movimiento[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.co_compra_servicio = new Ext.form.ComboBox({
	fieldLabel:'Co compra servicio',
	store: this.storeCO_COMPRAS,
	typeAhead: true,
	valueField: 'co_compras',
	displayField:'co_compras',
	hiddenName:'tb087_presupuesto_movimiento[co_compra_servicio]',
	//readOnly:(this.OBJ.co_compra_servicio!='')?true:false,
	//style:(this.main.OBJ.co_compra_servicio!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_compra_servicio',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_COMPRAS.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_compra_servicio,
	value:  this.OBJ.co_compra_servicio,
	objStore: this.storeCO_COMPRAS
});

this.co_factura = new Ext.form.NumberField({
	fieldLabel:'Co factura',
	name:'tb087_presupuesto_movimiento[co_factura]',
	value:this.OBJ.co_factura,
	allowBlank:false
});

this.mo_saldo_anterior = new Ext.form.NumberField({
	fieldLabel:'Mo saldo anterior',
	name:'tb087_presupuesto_movimiento[mo_saldo_anterior]',
	value:this.OBJ.mo_saldo_anterior,
	allowBlank:false
});

this.mo_saldo_nuevo = new Ext.form.NumberField({
	fieldLabel:'Mo saldo nuevo',
	name:'tb087_presupuesto_movimiento[mo_saldo_nuevo]',
	value:this.OBJ.mo_saldo_nuevo,
	allowBlank:false
});

this.co_solicitud_anular = new Ext.form.NumberField({
	fieldLabel:'Co solicitud anular',
	name:'tb087_presupuesto_movimiento[co_solicitud_anular]',
	value:this.OBJ.co_solicitud_anular,
	allowBlank:false
});

this.in_anular = new Ext.form.Checkbox({
	fieldLabel:'In anular',
	name:'tb087_presupuesto_movimiento[in_anular]',
	checked:(this.OBJ.in_anular=='0') ? true:false,
	allowBlank:false
});

this.in_cerrado = new Ext.form.Checkbox({
	fieldLabel:'In cerrado',
	name:'tb087_presupuesto_movimiento[in_cerrado]',
	checked:(this.OBJ.in_cerrado=='0') ? true:false,
	allowBlank:false
});

this.nu_monto_soberano = new Ext.form.NumberField({
	fieldLabel:'Nu monto soberano',
	name:'tb087_presupuesto_movimiento[nu_monto_soberano]',
	value:this.OBJ.nu_monto_soberano,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!MovimientoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        MovimientoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/guardar',
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
                 MovimientoLista.main.store_lista.load();
                 MovimientoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        MovimientoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_presupuesto_movimiento,
                    this.co_partida,
                    this.nu_monto,
                    this.nu_anio,
                    this.created_at,
                    this.updated_at,
                    this.co_usuario,
                    this.co_tipo_movimiento,
                    this.co_detalle_compra,
                    this.tx_observacion,
                    this.in_activo,
                    this.co_compra_servicio,
                    this.co_factura,
                    this.mo_saldo_anterior,
                    this.mo_saldo_nuevo,
                    this.co_solicitud_anular,
                    this.in_anular,
                    this.in_cerrado,
                    this.nu_monto_soberano,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Movimiento',
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
MovimientoLista.main.mascara.hide();
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/storefkcopartida',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreCO_USUARIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/storefkcousuario',
        root:'data',
        fields:[
            {name: 'co_usuario'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/storefkcotipomovimiento',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreCO_COMPRAS:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/storefkcocompraservicio',
        root:'data',
        fields:[
            {name: 'co_compras'}
            ]
    });
    return this.store;
}
};
Ext.onReady(MovimientoEditar.main.init, MovimientoEditar.main);
</script>
