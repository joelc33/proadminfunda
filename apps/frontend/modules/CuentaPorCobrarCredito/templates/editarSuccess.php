<script type="text/javascript">
Ext.ns("CuentaPorCobrarCreditoEditar");
CuentaPorCobrarCreditoEditar.main = {
init:function(){

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeID_CONCEPTO = this.getStoreID_CONCEPTO();
//<Stores de fk>
//<Stores de fk>
this.storeID_CLASE = this.getStoreID_CLASE();
//<Stores de fk>
//<Stores de fk>
this.storeID_TIPO_CUOTA = this.getStoreID_TIPO_CUOTA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
//<Stores de fk>
//<Stores de fk>
this.store_lista = this.getStoreCO_DETALLE_PAGO();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.co_solicitud = new Ext.form.Hidden({
	name:'tb142_cuenta_cobrar[co_solicitud]',
	value:this.OBJ.co_solicitud
});

this.co_usuario = new Ext.form.Hidden({
	name:'tb142_cuenta_cobrar[co_usuario]',
	value:this.OBJ.co_usuario
});

this.co_proveedor = new Ext.form.Hidden({
	name:'tb142_cuenta_cobrar[co_proveedor]',
	value:this.OBJ.co_proveedor
});

this.de_soporte = new Ext.form.TextField({
	fieldLabel:'Soporte',
	name:'tb142_cuenta_cobrar[de_soporte]',
	value:this.OBJ.de_soporte,
	allowBlank:false,
	width:500
});

this.id_tb143_cuenta_concepto = new Ext.form.ComboBox({
	fieldLabel:'Concepto',
	store: this.storeID_CONCEPTO,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_cuenta_concepto',
	hiddenName:'tb142_cuenta_cobrar[id_tb143_cuenta_concepto]',
	//readOnly:(this.OBJ.id_tb143_cuenta_concepto!='')?true:false,
	//style:(this.main.OBJ.id_tb143_cuenta_concepto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Concepto',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeID_CONCEPTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb143_cuenta_concepto,
	value:  this.OBJ.id_tb143_cuenta_concepto,
	objStore: this.storeID_CONCEPTO
});

this.id_tb144_clase_ingreso = new Ext.form.ComboBox({
	fieldLabel:'Clase de Ingreso',
	store: this.storeID_CLASE,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_clase_ingreso',
	hiddenName:'tb142_cuenta_cobrar[id_tb144_clase_ingreso]',
	//readOnly:(this.OBJ.id_tb144_clase_ingreso!='')?true:false,
	//style:(this.main.OBJ.id_tb144_clase_ingreso!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Clase de Ingreso',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeID_CLASE.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb144_clase_ingreso,
	value:  this.OBJ.id_tb144_clase_ingreso,
	objStore: this.storeID_CLASE
});

this.de_descripcion = new Ext.form.TextArea({
	fieldLabel:'Descripcion',
	name:'tb142_cuenta_cobrar[de_descripcion]',
	value:this.OBJ.de_descripcion,
	allowBlank:false,
	width:500,
        listeners: {
        change: function(field, newValue, oldValue) {
        field.setValue(newValue.toUpperCase());
    }
}         
});

this.mo_cuenta = new Ext.form.NumberField({
	fieldLabel:'Monto',
	name:'tb142_cuenta_cobrar[mo_cuenta]',
	value:this.OBJ.mo_cuenta,
	allowBlank:false,
	width:200,
    readOnly:(this.OBJ.mo_cuenta!='')?true:false,
	style:(this.OBJ.mo_cuenta!='')?'background:#c9c9c9;':'',
});

this.fe_documento = new Ext.form.DateField({
	fieldLabel:'Fecha Doc.',
	name:'tb142_cuenta_cobrar[fe_documento]',
	value:this.OBJ.fe_documento,
        maxValue:this.OBJ.fe_documento?this.OBJ.fe_documento:new Date(),
	allowBlank:false,
	width:100
});

this.id_tb141_tipo_cuota = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Cuota',
	store: this.storeID_TIPO_CUOTA,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_tipo_cuota',
	hiddenName:'tb142_cuenta_cobrar[id_tb141_tipo_cuota]',
	//readOnly:(this.OBJ.id_tb141_tipo_cuota!='')?true:false,
	//style:(this.main.OBJ.id_tb141_tipo_cuota!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Tipo Cuota',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeID_TIPO_CUOTA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb141_tipo_cuota,
	value:  this.OBJ.id_tb141_tipo_cuota,
	objStore: this.storeID_TIPO_CUOTA
});

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'tb008_proveedor[co_documento]',
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
	value:  (this.OBJ.co_documento=='')?4:this.OBJ.co_documento,
	objStore: this.storeCO_DOCUMENTO
});

this.tx_rif = new Ext.form.TextField({
	name:'tb008_proveedor[tx_rif]',
	value:this.OBJ.tx_rif,
	allowBlank:false,
	width:130
});

this.tx_razon_social = new Ext.form.TextField({
	fieldLabel:'Deudor / Cliente',
	name:'tb008_proveedor[tx_razon_social]',
	value:this.OBJ.tx_razon_social,
	allowBlank:false,
	width:500
});

this.co_documento.on("blur",function(){
    if(CuentaPorCobrarCreditoEditar.main.tx_rif.getValue()!=''){
    CuentaPorCobrarCreditoEditar.main.verificarProveedor();
    }
});

this.tx_rif.on("blur",function(){
    CuentaPorCobrarCreditoEditar.main.verificarProveedor();
});

this.compositefieldCIRIF = new Ext.form.CompositeField({
fieldLabel: 'RIF',
width:300,
items: [
	this.co_documento,
	this.tx_rif,
	]
});

this.fieldDatos1 = new Ext.form.FieldSet({
        title: 'Datos del Tramite',
        items:[
            this.co_proveedor,
			this.compositefieldCIRIF,
			this.tx_razon_social,
//			this.de_soporte,
			this.id_tb143_cuenta_concepto,
			this.id_tb144_clase_ingreso,
			this.de_descripcion,
		]
});

this.fieldDatos2 = new Ext.form.FieldSet({
        title: 'Datos del Credito',
        items:[
			this.mo_cuenta,
			this.fe_documento,
			this.id_tb141_tipo_cuota,
		]
});

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        CuentaPorCobrarCreditoEditar.main.mascara.show();
        this.msg = Ext.get('formularioCuentaPorCobrarCreditoDetalle');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCreditoDetalle/editar',
         params:{
            id_tb142_cuenta_cobrar: CuentaPorCobrarCreditoEditar.main.id.getValue()
        },
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = CuentaPorCobrarCreditoEditar.main.gridPanel.getSelectionModel().getSelected().get('id');
	CuentaPorCobrarCreditoEditar.main.mascara.show();
        this.msg = Ext.get('formularioCuentaPorCobrarCreditoDetalle');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCreditoDetalle/editar/codigo/'+this.codigo,
         params:{
            id_tb142_cuenta_cobrar: CuentaPorCobrarCreditoEditar.main.id.getValue()
        },
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Eliminar un registro
this.eliminar= new Ext.Button({
    text:'Eliminar',
    iconCls: 'icon-eliminar',
    handler:function(){
	this.codigo  = CuentaPorCobrarCreditoEditar.main.gridPanel.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCreditoDetalle/eliminar',
            params:{
                id:CuentaPorCobrarCreditoEditar.main.gridPanel.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		            CuentaPorCobrarCreditoEditar.main.store_lista.load({
                        callback: function(){
                            CuentaPorCobrarCreditoEditar.main.getTotal();
                       }
                    });
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                CuentaPorCobrarCreditoEditar.main.mascara.hide();
            }});
	}});
    }
});

this.mo_pago = new Ext.form.DisplayField({
 value:"<span style='font-size:18px;'><b>Total Cuotas: </b>"+paqueteComunJS.funcion.getNumeroFormateado(0)+"</b></span>"
});

this.mo_diferencia = new Ext.form.DisplayField({
 value:"<span style='font-size:18px;'><b>Por Asignar: </b>"+paqueteComunJS.funcion.getNumeroFormateado(0)+"</b></span>"
});

this.bbar_monto = new Ext.ux.StatusBar({
  autoScroll:true,
  defaults:{
    style:'color:black;font-size:30px;',
    autoWidth:true
  },
  items:[
    this.mo_diferencia,'-',
    this.mo_pago
  ]
});

//this.nuevo.disable();
this.editar.disable();
this.eliminar.disable();

this.gridPanel = new Ext.grid.GridPanel({
        store: this.store_lista,
        loadMask:true,
        height:200,
        width:660,
        border:true,
        tbar:[
            this.nuevo,'-',this.editar,'-',this.eliminar
        ],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'id', hidden: true,width:80, menuDisabled:true,dataIndex: 'id'},
            {header: 'Cuota',width:200, menuDisabled:true,dataIndex: 'de_cuota'},
			{header: 'Monto',width:200, menuDisabled:true, renderer: formatoNumero, dataIndex: 'mo_cuota'},
            {header: 'Fecha de Pago',width:150, menuDisabled:true,dataIndex: 'fe_pago'}
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{
            cellclick:function(Grid, rowIndex, columnIndex,e ){
            if(CuentaPorCobrarCreditoEditar.main.gridPanel.getSelectionModel().getSelected().get('in_pago')==false){
            CuentaPorCobrarCreditoEditar.main.editar.enable();
            CuentaPorCobrarCreditoEditar.main.eliminar.enable();
            }
            }
        },
        bbar: new Ext.PagingToolbar({
            pageSize: 100,
            store: this.store_lista,
            displayInfo: true,
            displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
            emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
        })
});

if(this.OBJ.id){

this.store_lista.baseParams.id_tb142_cuenta_cobrar = this.OBJ.id;
this.store_lista.load({
  callback: function(){
    CuentaPorCobrarCreditoEditar.main.getTotal();
  }
});

}else{

 this.nuevo.disable();

}

this.store_lista.baseParams.id_tb142_cuenta_cobrar = this.OBJ.id;

this.store_lista.on('load',function(){
    CuentaPorCobrarCreditoEditar.main.getTotal();
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!CuentaPorCobrarCreditoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        CuentaPorCobrarCreditoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCredito/guardar',
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
                 //CuentaPorCobrarCreditoEditar.main.store_lista.load();
                 //CuentaPorCobrarCreditoEditar.main.winformPanel_.close();
                 CuentaPorCobrarCreditoEditar.main.id.setValue(action.result.codigo);
                 CuentaPorCobrarCreditoEditar.main.nuevo.enable();
                 CuentaPorCobrarCreditoEditar.main.store_lista.load();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        CuentaPorCobrarCreditoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:false,
    width:680,
	autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
			this.id,
			this.co_solicitud,
			this.co_usuario,
			this.fieldDatos1,
			this.fieldDatos2,
			this.gridPanel
    ],
    bbar: this.bbar_monto
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Cuenta Por Pagar Credito',
    modal:true,
    constrain:true,
	width:694,
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
//CuentaPorCobrarCreditoEditar.main.mascara.hide();
}
,getStoreID_CONCEPTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCredito/storefkidtb143cuentaconcepto',
        root:'data',
        fields:[
            {name: 'id'},
			{name: 'de_cuenta_concepto'}
            ]
    });
    return this.store;
}
,getStoreID_CLASE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCredito/storefkidtb144claseingreso',
        root:'data',
        fields:[
            {name: 'id'},
			{name: 'de_clase_ingreso'}
            ]
    });
    return this.store;
}
,getStoreID_TIPO_CUOTA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCredito/storefkidtb141tipocuota',
        root:'data',
        fields:[
            {name: 'id'},
			{name: 'de_tipo_cuota'}
            ]
    });
    return this.store;
}
,getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'},
            {name: 'inicial'}
            ]
    });
    return this.store;
}
,verificarProveedor:function(){
            Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Compras/verificarProveedor',
                params:{
                    co_documento: CuentaPorCobrarCreditoEditar.main.co_documento.getValue(),
                    tx_rif: CuentaPorCobrarCreditoEditar.main.tx_rif.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        CuentaPorCobrarCreditoEditar.main.co_proveedor.setValue("");
                        CuentaPorCobrarCreditoEditar.main.co_documento.setValue("");
                        CuentaPorCobrarCreditoEditar.main.tx_rif.setValue("");
                        CuentaPorCobrarCreditoEditar.main.tx_razon_social.setValue("");

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

                        CuentaPorCobrarCreditoEditar.main.co_proveedor.setValue(obj.data.co_proveedor);
                        CuentaPorCobrarCreditoEditar.main.tx_razon_social.setValue(obj.data.tx_razon_social);
                       
                    }
                }
 });
}
,getStoreCO_DETALLE_PAGO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaPorCobrarCreditoDetalle/storelista',
        root:'data',
        fields:[
			{name: 'id'},
			{name: 'id_tb142_cuenta_cobrar'},
			{name: 'de_cuota'},
			{name: 'mo_cuota'},
			{name: 'fe_pago'},
			{name: 'in_activo'},
                        {name: 'in_pago'},
			{name: 'created_at'},
			{name: 'updated_at'},
        ]
    });
    return this.store;
}
,getTotal:function(){

    this.monto_cuotas = 0;
    this.monto_total = CuentaPorCobrarCreditoEditar.main.mo_cuenta.getValue();
    this.monto_cuotas = paqueteComunJS.funcion.getSumaColumnaGrid({
        store:CuentaPorCobrarCreditoEditar.main.store_lista,
        campo:'mo_cuota'
    });

    this.mo_diponiblie = this.monto_total - this.monto_cuotas;

    CuentaPorCobrarCreditoEditar.main.mo_pago.setValue("<span style='font-size:18px;'><b>Total Cuotas: </b>"+paqueteComunJS.funcion.getNumeroFormateado(this.monto_cuotas)+"</b></span>");
    CuentaPorCobrarCreditoEditar.main.mo_diferencia.setValue("<span style='font-size:18px;'><b>Por Asignar: </b>"+paqueteComunJS.funcion.getNumeroFormateado(this.mo_diponiblie)+"</b></span>");

}
};
Ext.onReady(CuentaPorCobrarCreditoEditar.main.init, CuentaPorCobrarCreditoEditar.main);
</script>
<div id="formularioCuentaPorCobrarCreditoDetalle"></div>
