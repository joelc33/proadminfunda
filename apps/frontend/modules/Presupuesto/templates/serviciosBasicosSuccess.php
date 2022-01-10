<script type="text/javascript">
Ext.ns("PagoServicioEditar");
PagoServicioEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_TIPO_SERVICIO = this.getStoreCO_TIPO_SERVICIO();
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
//<Stores de fk>

//<ClavePrimaria>
this.co_pago_servicio = new Ext.form.Hidden({
    name:'co_pago_servicio',
    value:this.OBJ.co_pago_servicio
});


this.co_solicitud = new Ext.form.Hidden({
    name:'tb135_pago_servicio[co_solicitud]',
    value:this.OBJ.co_solicitud
});

this.co_proveedor = new Ext.form.Hidden({
    name:'tb135_pago_servicio[co_proveedor]',
    value:this.OBJ.co_proveedor
});

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'tb008_proveedor[co_documento]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
//        readOnly:(this.OBJ.co_factura!='')?true:false,
//	style:(this.OBJ.co_factura!='')?'background:#c9c9c9;':'',
	mode: 'local',
	width:50,
	allowBlank:false
});
this.storeCO_DOCUMENTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_documento,
	value:  (this.OBJ.co_documento=='')?4:this.OBJ.co_documento,
	objStore: this.storeCO_DOCUMENTO
});

this.tx_rif = new Ext.form.TextField({
	name:'tb008_proveedor[tx_rif]',
	value:this.OBJ.tx_rif,
//        readOnly:(this.OBJ.co_factura!='')?true:false,
//	style:(this.OBJ.co_factura!='')?'background:#c9c9c9;':'',
	allowBlank:false,
	width:130
});
this.co_documento.on("blur",function(){
    if(PagoServicioEditar.main.tx_rif.getValue()!=''){
    PagoServicioEditar.main.verificarProveedor();
    }
});

this.tx_rif.on("blur",function(){
    PagoServicioEditar.main.verificarProveedor();
});

this.compositefieldCIRIF = new Ext.form.CompositeField({
fieldLabel: 'Cedula/Rif',
width:185,
items: [
	this.co_documento,
	this.tx_rif,
	]
});

this.tx_razon_social = new Ext.form.TextField({
	fieldLabel:'Razon Social',
	name:'tb008_proveedor[tx_razon_social]',
	value:this.OBJ.tx_razon_social,
//        readOnly:(this.OBJ.co_factura!='')?true:false,
//	style:(this.OBJ.co_factura!='')?'background:#c9c9c9;':'',
	allowBlank:false,
	width:600
});

this.tx_direccion = new Ext.form.TextField({
	fieldLabel:'Direccion',
	name:'tb008_proveedor[tx_direccion]',
	value:this.OBJ.tx_direccion,
	allowBlank:false,
//        readOnly:(this.OBJ.co_factura!='')?true:false,
//	style:(this.OBJ.co_factura!='')?'background:#c9c9c9;':'',
	width:600
});

this.fieldProveedor = new Ext.form.FieldSet({
        title: 'Datos del Proveedor',
        items:[
          this.compositefieldCIRIF,
          this.tx_razon_social,
          this.tx_direccion
       ]
});


this.co_tipo_servicio = new Ext.form.ComboBox({
	fieldLabel:'Tipo Servicio',
	store: this.storeCO_TIPO_SERVICIO,
	typeAhead: true,
	valueField: 'co_tipo_servicio',
	displayField:'tx_tipo_servicio',
	hiddenName:'tb135_pago_servicio[co_tipo_servicio]',
	//readOnly:(this.OBJ.co_tipo_servicio!='')?true:false,
	//style:(this.main.OBJ.co_tipo_servicio!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_SERVICIO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tipo_servicio,
	value:  this.OBJ.co_tipo_servicio,
	objStore: this.storeCO_TIPO_SERVICIO
});

this.nu_factura = new Ext.form.TextField({
	fieldLabel:'Nro. Factura',
	name:'tb135_pago_servicio[nu_factura]',
	value:this.OBJ.nu_factura,
	allowBlank:false,
	width:200
});

this.nu_control = new Ext.form.TextField({
	fieldLabel:'Nro. Control',
	name:'tb135_pago_servicio[nu_control]',
	value:this.OBJ.nu_control,
//	allowBlank:false,
	width:200
});

this.mo_factura = new Ext.form.NumberField({
	fieldLabel:'Monto',
	name:'tb135_pago_servicio[mo_factura]',
	value:this.OBJ.mo_factura,
	allowBlank:false
});

this.fe_desde = new Ext.form.DateField({
	fieldLabel:'Fecha Desde',
	name:'tb135_pago_servicio[fe_desde]',
	value:this.OBJ.fe_desde,
	allowBlank:false,
	width:100
});

this.fe_hasta = new Ext.form.DateField({
	fieldLabel:'Fecha Hasta',
	name:'tb135_pago_servicio[fe_hasta]',
	value:this.OBJ.fe_hasta,
	allowBlank:false,
	width:100
});

this.tx_observacion = new Ext.form.TextArea({
	fieldLabel:'Observación',
	name:'tb135_pago_servicio[tx_observacion]',
	value:this.OBJ.tx_observacion,
	allowBlank:false,
	width:600
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PagoServicioEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PagoServicioEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoServicio/guardar',
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
                 
                 PagoServicioEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PagoServicioEditar.main.winformPanel_.close();
    }
});

this.fieldFactura = new Ext.form.FieldSet({
        title: 'Datos de la Factura',
        items:[
                    this.co_tipo_servicio,
                    this.nu_factura,
                    this.nu_control,
                    this.mo_factura,
                    this.fe_desde,
                    this.fe_hasta,
                    this.tx_observacion
              ]
});


this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:800,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[         this.co_pago_servicio,
                    this.co_proveedor,
                    this.fieldProveedor,
                    this.co_solicitud,
                    this.fieldFactura]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: PagoServicio',
    modal:true,
    constrain:true,
    width:800,
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
//PagoServicioLista.main.mascara.hide();
},
verificarProveedor:function(){
            Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Compras/verificarProveedor',
                params:{
                    co_documento: PagoServicioEditar.main.co_documento.getValue(),
                    tx_rif: PagoServicioEditar.main.tx_rif.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        PagoServicioEditar.main.co_proveedor.setValue("");
                        PagoServicioEditar.main.co_documento.setValue("");
                        PagoServicioEditar.main.tx_rif.setValue("");
                        PagoServicioEditar.main.tx_razon_social.setValue("");
			PagoServicioEditar.main.tx_direccion.setValue("");

                        Ext.Msg.show({
                            title : 'ALERTA',
                            msg : 'El Proveedor no se encuentra registrado',
                            width : 400,
                            height : 800,
                            closable : false,
                            buttons : Ext.Msg.OK,
                            icon : Ext.Msg.INFO
                        });

                    }else{

                        PagoServicioEditar.main.co_proveedor.setValue(obj.data.co_proveedor);
                        PagoServicioEditar.main.tx_razon_social.setValue(obj.data.tx_razon_social);
                        PagoServicioEditar.main.tx_direccion.setValue(obj.data.tx_direccion);
                       
                    }
                }
 });
}
,getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'},
            {name: 'inicial'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_SERVICIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoServicio/storefkcotiposervicio',
        root:'data',
        fields:[
            {name: 'co_tipo_servicio'},
            {name: 'tx_tipo_servicio'}
            ]
    });
    return this.store;
}
};
Ext.onReady(PagoServicioEditar.main.init, PagoServicioEditar.main);
</script>
