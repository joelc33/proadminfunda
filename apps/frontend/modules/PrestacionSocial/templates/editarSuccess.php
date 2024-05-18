<script type="text/javascript">
Ext.ns("PrestacionSocialEditar");
PrestacionSocialEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();

this.storeCO_TIPO_TRABAJADOR = this.getStoreCO_TIPO_TRABAJADOR();

this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();

this.storeCO_SITUACION_TRABAJADOR = this.getStoreCO_SITUACION_TRABAJADOR();

this.storeCO_PRESTACION_RETIRO = this.getStoreCO_PRESTACION_RETIRO();
//objeto store
this.store_lista = this.getLista_detalle();

this.store_lista_tercero = this.getLista_tercero_detalle();

this.Registro = Ext.data.Record.create([
        {name: 'co_clase', type: 'number'},
        {name: 'co_unidad_producto', type: 'number'},
        {name: 'co_detalle_compras', type: 'number'},
        {name: 'tx_producto', type: 'string'},
        {name: 'co_producto', type: 'number'},  
        {name: 'mo_pago', type:'number'},
        {name: 'mo_deduccion', type:'number'},
        {name: 'mo_asignacion', type:'number'},
]);

this.RegistroTerceros = Ext.data.Record.create([
        {name: 'co_prestacion_terceros', type: 'number'},
        {name: 'nu_cedula', type: 'number'},
        {name: 'nombre', type: 'string'},
        {name: 'nu_cuenta', type: 'number'},
        {name: 'porcentaje', type: 'number'},  
        {name: 'mo_pagar', type:'number'},
]);

this.hiddenJsonDetalle  = new Ext.form.Hidden({
        name:'json_detalle',
        value:''
});

this.hiddenJsonDetalleTercero  = new Ext.form.Hidden({
        name:'json_detalle_tercero',
        value:''
});

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>
//<ClavePrimaria>
this.co_compras = new Ext.form.Hidden({
    name:'co_compras',
    value:this.OBJ.co_compras});
//</ClavePrimaria>

this.co_solicitud = new Ext.form.Hidden({
    name:'tb191_prestacion_social[co_solicitud]',
    value:this.OBJ.co_solicitud
});

this.co_usuario = new Ext.form.Hidden({
    name:'tb191_prestacion_social[co_usuario]',
    value:this.OBJ.co_usuario
});

this.co_proveedor = new Ext.form.Hidden({
    name:'tb191_prestacion_social[co_proveedor]',
    value:this.OBJ.co_proveedor
});

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'tb191_prestacion_social[co_documento]',
	//readOnly:(this.OBJ.co_documento!='')?true:false,
	//style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:50,
	resizable:true,
	allowBlank:false
});
this.storeCO_DOCUMENTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_documento,
	value:  this.OBJ.co_documento,
	objStore: this.storeCO_DOCUMENTO
});

this.nu_documento = new Ext.form.TextField({
	fieldLabel:'Nu documento',
	name:'tb191_prestacion_social[nu_documento]',
	value:this.OBJ.nu_documento,
	allowBlank:false,
	width:145
});

this.nu_documento.on("blur",function(){
    if(PrestacionSocialEditar.main.nu_documento.getValue()!=''){
         PrestacionSocialEditar.main.buscarProveedor();
    }
});

this.compositefieldCI = new Ext.form.CompositeField({
fieldLabel: 'N° Documento',
width:300,
items: [
	this.co_documento,
	this.nu_documento,
	]
});

this.nb_persona = new Ext.form.TextField({
	fieldLabel:'Nombre / Apellido',
	name:'tb191_prestacion_social[nb_persona]',
	value:this.OBJ.nb_persona,
	allowBlank:false,
	style:'background:#c9c9c9;',
	readOnly:true,
	width:400
});

this.ap_persona = new Ext.form.TextField({
	fieldLabel:'Apellido',
	name:'tb191_prestacion_social[ap_persona]',
	value:this.OBJ.ap_persona,
	allowBlank:false,
	style:'background:#c9c9c9;',
	readOnly:true,
	width:200
});

this.co_tipo_trabajador = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Trabajador',
	store: this.storeCO_TIPO_TRABAJADOR,
	typeAhead: true,
	valueField: 'id',
	displayField:'nomina',
	hiddenName:'tb191_prestacion_social[co_tipo_trabajador]',
	//readOnly:(this.OBJ.co_tipo_trabajador!='')?true:false,
	//style:(this.main.OBJ.co_tipo_trabajador!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Tipo de Trabajador...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_TRABAJADOR.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tipo_trabajador,
	value:  this.OBJ.co_tipo_trabajador,
	objStore: this.storeCO_TIPO_TRABAJADOR
});

this.co_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Unidad Administrativa',
	store: this.storeCO_EJECUTOR,
	typeAhead: true,
	valueField: 'id',
	displayField:'ejecutor',
	hiddenName:'tb191_prestacion_social[co_ejecutor]',
	//readOnly:(this.OBJ.co_tipo_trabajador!='')?true:false,
	//style:(this.main.OBJ.co_tipo_trabajador!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Unidad Administrativa...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeCO_EJECUTOR.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_ejecutor,
	value:  this.OBJ.co_ejecutor,
	objStore: this.storeCO_EJECUTOR
});

this.co_situacion_trabajador = new Ext.form.ComboBox({
	//fieldLabel:'Situacion Trabajador',
	fieldLabel:'Concepto de Pago',
	store: this.storeCO_SITUACION_TRABAJADOR,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_situacion_empleado',
	hiddenName:'tb191_prestacion_social[co_situacion_trabajador]',
	//readOnly:(this.OBJ.co_situacion_trabajador!='')?true:false,
	//style:(this.main.OBJ.co_situacion_trabajador!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	//emptyText:'Seleccione Situacion Trabajador...',
	emptyText:'Seleccione Concepto de Pago...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeCO_SITUACION_TRABAJADOR.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_situacion_trabajador,
	value:  this.OBJ.co_situacion_trabajador,
	objStore: this.storeCO_SITUACION_TRABAJADOR
});

this.co_prestacion_causa_retiro = new Ext.form.ComboBox({
	fieldLabel:'Causa del Retiro',
	store: this.storeCO_PRESTACION_RETIRO,
	typeAhead: true,
	valueField: 'co_prestacion_causa_retiro',
	displayField:'tx_prestacion_causa_retiro',
	hiddenName:'tb191_prestacion_social[co_prestacion_causa_retiro]',
	//readOnly:(this.OBJ.co_tipo_trabajador!='')?true:false,
	//style:(this.main.OBJ.co_tipo_trabajador!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione la causa del retiro',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeCO_PRESTACION_RETIRO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_prestacion_causa_retiro,
	value:  this.OBJ.co_prestacion_causa_retiro,
	objStore: this.storeCO_PRESTACION_RETIRO
});

this.fe_ingreso = new Ext.form.DateField({
	fieldLabel:'Fecha Ingreso',
	name:'tb191_prestacion_social[fe_ingreso]',
	value:this.OBJ.fe_ingreso,
	allowBlank:false,
	width:100
});

this.fe_egreso = new Ext.form.DateField({
	fieldLabel:'Fecha Egreso',
	name:'tb191_prestacion_social[fe_egreso]',
	value:this.OBJ.fe_egreso,
	allowBlank:false,
	width:100
});

this.fe_movimiento = new Ext.form.DateField({
	fieldLabel:'Fecha Movimiento',
	name:'tb191_prestacion_social[fe_movimiento]',
	value:this.OBJ.fe_movimiento,
	allowBlank:false,
	width:100
});

this.de_observacion = new Ext.form.TextField({
	fieldLabel:'Observacion',
	name:'tb191_prestacion_social[de_observacion]',
	value:this.OBJ.de_observacion,
	allowBlank:false,
	width:400
});

this.mo_pago = new Ext.form.NumberField({
	fieldLabel:'Monto a Pagar',
	name:'tb191_prestacion_social[mo_pago]',
	value:this.OBJ.mo_pago,
	style:'background:#c9c9c9;',
	readOnly:true,
	allowBlank:false,
	width:200
});

function formatoNro(val){
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}

this.agregar = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/agregar',
            scripts: true,
            text: "Cargando..",
            params:{
                co_solicitud: PrestacionSocialEditar.main.co_solicitud.getValue()
            }
        });
    }
});

this.botonEliminar = new Ext.Button({
                text:'Eliminar',
                iconCls: 'icon-eliminar',
                handler: function(){
                    PrestacionSocialEditar.main.eliminar();
                }
});

this.botonEliminar.disable();

//Grid principal
this.gridPanel_detalle = new Ext.grid.GridPanel({
    store: this.store_lista,
    loadMask:true,
    border:false,
    height:170,
	tbar:[
        this.agregar,'-',this.botonEliminar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_detalle_compras',hidden:true, menuDisabled:true,dataIndex: 'co_detalle_compras'},
    {header: 'co_producto',hidden:true, menuDisabled:true,dataIndex: 'co_producto'},
    {header: 'co_unidad_producto',hidden:true, menuDisabled:true,dataIndex: 'co_unidad_producto'},
    {header: 'mo_pago',hidden:true, menuDisabled:true,dataIndex: 'mo_pago'},
    {header: 'Concepto', width:380,  menuDisabled:true, sortable: true,  dataIndex: 'tx_producto'},
    {header: 'Asignacion', width:120,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_asignacion'},
    {header: 'Deduccion', width:120,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_deduccion'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
	listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
		PrestacionSocialEditar.main.botonEliminar.enable();
		}
	},
    /*bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })*/
});


this.agregarTercero = new Ext.Button({
    text: 'Nuevo',
    iconCls: 'icon-nuevo',
    handler: function () {
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/agregarTercero',
            scripts: true,
            text: "Cargando..",
            params:{
                co_solicitud: PrestacionSocialEditar.main.co_solicitud.getValue()
            }
        });
    }
});

this.botonEliminarTercero = new Ext.Button({
                text:'Eliminar',
                iconCls: 'icon-eliminar',
                handler: function(){
                    PrestacionSocialEditar.main.eliminarTercero();
                }
});
this.botonEliminarTercero.disable();

this.gridPanel_terceros = new Ext.grid.GridPanel({
    store: this.store_lista_tercero,
    loadMask:true,
    border:false,
    height:170,
	tbar:[
        this.agregarTercero,'-',this.botonEliminarTercero
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_prestacion_terceros',hidden:true, menuDisabled:true,dataIndex: 'co_prestacion_terceros'},
    {header: 'Cedula', menuDisabled:true,dataIndex: 'nu_cedula'},
    {header: 'Nombre y Apellido',width:160, menuDisabled:true,dataIndex: 'nombre'},
    {header: 'Nro Cuenta Bancaria',width:130, menuDisabled:true,dataIndex: 'nu_cuenta'},
    {header: 'Porcentaje', width:120,  menuDisabled:true, sortable: true,  dataIndex: 'porcentaje'},
    {header: 'Monto Retencion', width:120,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_pagar'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
	listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
		PrestacionSocialEditar.main.botonEliminarTercero.enable();
		}
	},
    /*bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })*/
});

this.panel_detalle = new Ext.TabPanel({
    activeTab:0,
    border:true,
    enableTabScroll:true,
    deferredRender: true,
	autoWidth:true,
	height:200,
    items:[
		{
			title: 'Detalle del Pago',
            autoScroll:true,
            border:false,
			items:[
                this.gridPanel_detalle
            ]
		},
		{
			title: 'Detalle Terceros',
                        autoScroll:true,
                        border:false,
			items:[
                this.gridPanel_terceros
            ]
		}                
	]
});

this.panelDatos2 = new Ext.Panel({
    autoHeight:true,
    border:false,
    bodyStyle:'padding:0px;',
    items:[
		this.panel_detalle
	]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PrestacionSocialEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }

        var list_detalle = paqueteComunJS.funcion.getJsonByObjStore({
                store:PrestacionSocialEditar.main.gridPanel_detalle.getStore()
        });
        
        var list_detalle_tercero = paqueteComunJS.funcion.getJsonByObjStore({
                store:PrestacionSocialEditar.main.gridPanel_terceros.getStore()
        });        
        
        PrestacionSocialEditar.main.hiddenJsonDetalle.setValue(list_detalle); 
        PrestacionSocialEditar.main.hiddenJsonDetalleTercero.setValue(list_detalle_tercero); 

        PrestacionSocialEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/guardar',
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
                 //PrestacionSocialEditar.main.store_lista.load();
                 PrestacionSocialEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PrestacionSocialEditar.main.winformPanel_.close();
    }
});

this.fieldDatos1 = new Ext.form.FieldSet({
	title: 'Datos del Trabajador',
	items:[   
			this.compositefieldCI,
			this.co_proveedor,
            this.nb_persona,
            //this.ap_persona,
			this.co_tipo_trabajador,
            this.co_ejecutor,
    ]
});

this.fieldDatos2 = new Ext.form.FieldSet({
	title: 'Datos del Egreso',
	items:[   
			this.co_situacion_trabajador,
                        this.co_prestacion_causa_retiro,
			this.fe_ingreso,
			this.fe_egreso,
			this.fe_movimiento,
			this.de_observacion,
			this.mo_pago
    ]
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:false,
    width:700,
autoHeight:true,  
    autoScroll:true,
	labelWidth: 130,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
                    this.co_solicitud,
                    this.hiddenJsonDetalle,
                    this.hiddenJsonDetalleTercero,
					this.co_compras,
                    this.co_usuario,
					this.fieldDatos1,
					this.fieldDatos2,
					this.panelDatos2
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Prestacion Social',
    modal:true,
    constrain:true,
width:714,
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
//PrestacionSocialEditar.main.mascara.hide();
PrestacionSocialEditar.main.store_lista.baseParams.co_solicitud=PrestacionSocialEditar.main.OBJ.co_solicitud;
PrestacionSocialEditar.main.store_lista.baseParams.co_compras=PrestacionSocialEditar.main.OBJ.co_compras;
this.store_lista.load({
    callback: function(){
PrestacionSocialEditar.main.calcular(); 
    }
    });
PrestacionSocialEditar.main.store_lista_tercero.baseParams.co_solicitud=PrestacionSocialEditar.main.OBJ.co_solicitud;
this.store_lista_tercero.load({
    callback: function(){
PrestacionSocialEditar.main.calcular(); 
    }
    });

},
eliminar:function(){
        var s = PrestacionSocialEditar.main.gridPanel_detalle.getSelectionModel().getSelections();
        
        var co_detalle_compras = PrestacionSocialEditar.main.gridPanel_detalle.getSelectionModel().getSelected().get('co_detalle_compras');
        var co_solicitud = PrestacionSocialEditar.main.OBJ.co_solicitud;
       
        if(co_detalle_compras!=''){
            
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/eliminar',
            params:{
                co_solicitud: co_solicitud,
                co_detalle_compras: co_detalle_compras
            },
            success:function(result, request ) {
               PrestacionSocialEditar.main.store_lista.load();
            }});
            
        }
       
        for(var i = 0, r; r = s[i]; i++){
              PrestacionSocialEditar.main.store_lista.remove(r);
        }

        PrestacionSocialEditar.main.calcular(); 
        
},
eliminarTercero:function(){
        var s = PrestacionSocialEditar.main.gridPanel_terceros.getSelectionModel().getSelections();
        
        var co_prestacion_terceros = PrestacionSocialEditar.main.gridPanel_terceros.getSelectionModel().getSelected().get('co_prestacion_terceros');
        var co_solicitud = PrestacionSocialEditar.main.OBJ.co_solicitud;
       
        if(co_prestacion_terceros!=''){
            
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/eliminarTercero',
            params:{
                co_solicitud: co_solicitud,
                co_prestacion_terceros: co_prestacion_terceros
            },
            success:function(result, request ) {
               PrestacionSocialEditar.main.store_lista_tercero.load();
            }});
            
        }
       
        for(var i = 0, r; r = s[i]; i++){
              PrestacionSocialEditar.main.store_lista_tercero.remove(r);
        }

        PrestacionSocialEditar.main.calcular(); 
        
},
calcular: function(){
        
    /*PrestacionSocialEditar.main.mo_total = paqueteComunJS.funcion.getSumaColumnaGrid({
        store:PrestacionSocialEditar.main.store_lista,
        campo:'mo_pago'
    });*/

    var asignacion = paqueteComunJS.funcion.getSumaColumnaGrid({
        store:PrestacionSocialEditar.main.store_lista,
        campo:'mo_asignacion'
    });

    var deduccion = paqueteComunJS.funcion.getSumaColumnaGrid({
        store:PrestacionSocialEditar.main.store_lista,
        campo:'mo_deduccion'
    });

    var terceros = paqueteComunJS.funcion.getSumaColumnaGrid({
        store:PrestacionSocialEditar.main.store_lista_tercero,
        campo:'mo_pagar'
    });


    PrestacionSocialEditar.main.mo_total = asignacion - deduccion - terceros;
                    
    PrestacionSocialEditar.main.mo_pago.setValue(PrestacionSocialEditar.main.mo_total);    

}
,getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'},
            {name: 'inicial'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_TRABAJADOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/storefkcotipotrabajador',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'nu_nomina'},
			{name: 'de_nomina'},
			{name: 'nomina',
                convert:function(v,r){
                    return r.nu_nomina+' - '+r.de_nomina;
                }
            }
            ]
    });
    return this.store;
}
,getStoreCO_EJECUTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/storefkcoejecutor',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'nu_ejecutor'},
			{name: 'de_ejecutor'},
			{name: 'ejecutor',
                convert:function(v,r){
                    return r.nu_ejecutor+' - '+r.de_ejecutor;
                }
            }
            ]
    });
    return this.store;
}
,getStoreCO_SITUACION_TRABAJADOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/storefkcosituaciontrabajador',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_situacion_empleado'},
            ]
    });
    return this.store;
}
,getStoreCO_PRESTACION_RETIRO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/storefkcoprestacionretiro',
        root:'data',
        fields:[
            {name: 'co_prestacion_causa_retiro'},
            {name: 'tx_prestacion_causa_retiro'},
            ]
    });
    return this.store;
},
buscarProveedor: function(){
         Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/PrestacionSocial/proveedor',
                params:{
                    co_documento: PrestacionSocialEditar.main.co_documento.getValue(),
					nu_documento: PrestacionSocialEditar.main.nu_documento.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        
                        PrestacionSocialEditar.main.nb_persona.setValue(null);
						PrestacionSocialEditar.main.ap_persona.setValue(null);

                        Ext.Msg.show({
                            title : 'ALERTA',
                            msg : 'La persona no se encuentra registrada como proveedor.',
                            width : 400,
                            height : 800,
                            closable : false,
                            buttons : Ext.Msg.OK,
                            icon : Ext.Msg.INFO
                        });

                    }else{
                        PrestacionSocialEditar.main.nb_persona.setValue(obj.data.tx_razon_social);                       
                        //PrestacionSocialEditar.main.ap_persona.setValue(obj.data.ap_persona);                       
                        PrestacionSocialEditar.main.co_proveedor.setValue(obj.data.co_proveedor);                       
                    }
                }
         });
},
getLista_detalle: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/storelistadetalle',
    root:'data',
    fields:[
    {name: 'co_detalle_compras'},
    {name: 'co_unidad_producto'},
    {name: 'co_producto'},
    {name: 'mo_asignacion'},
    {name: 'mo_deduccion'},
    {name: 'mo_pago'},
    {name: 'detalle'},
    {name: 'tx_producto'},
           ]
    });
    return this.store;
},
getLista_tercero_detalle: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/storelistadetalletercero',
    root:'data',
    fields:[
    {name: 'co_prestacion_terceros'},
    {name: 'nu_cedula'},
    {name: 'nombre'},
    {name: 'nu_cuenta'},
    {name: 'porcentaje'},
    {name: 'mo_pagar'},
    {name: 'co_solicitud'},
           ]
    });
    return this.store;
}
};
Ext.onReady(PrestacionSocialEditar.main.init, PrestacionSocialEditar.main);
</script>
<div id="formularioAgregar"></div>