<script type="text/javascript">
Ext.ns("SolicitudEditar");
SolicitudEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();

//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
this.storeCO_CUENTA = this.getStoreCO_CUENTA();

//<ClavePrimaria>
this.co_solicitud_cuenta = new Ext.form.Hidden({
    name:'co_solicitud_cuenta',
    value:this.OBJ.co_solicitud_cuenta});
//</ClavePrimaria>


this.co_solicitud = new Ext.form.Hidden({
    name:'tb106_solicitud_cuenta_contable_proveedor[co_solicitud]',
    value:this.OBJ.co_solicitud});


this.co_proveedor  = new Ext.form.Hidden({
        name:'tb106_solicitud_cuenta_contable_proveedor[co_proveedor]',
        value:this.OBJ.co_proveedor
});

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'tb106_solicitud_cuenta_contable_proveedor[co_documento]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
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
	name:'tb106_solicitud_cuenta_contable_proveedor[tx_rif]',
	value:this.OBJ.tx_rif,
	allowBlank:false,
	width:130
});
this.co_documento.on("blur",function(){
    if(SolicitudEditar.main.tx_rif.getValue()!=''){
    SolicitudEditar.main.verificarProveedor();
    }
});

this.tx_rif.on("blur",function(){
    SolicitudEditar.main.verificarProveedor();
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
	name:'tb106_solicitud_cuenta_contable_proveedor[tx_razon_social]',
	value:this.OBJ.tx_razon_social,
        readOnly:true,
	style:'background:#c9c9c9;',
	allowBlank:false,
	width:600
});

this.tx_direccion = new Ext.form.TextField({
	fieldLabel:'Direccion',
	name:'tb106_solicitud_cuenta_contable_proveedor[tx_direccion]',
	value:this.OBJ.tx_direccion,
        readOnly:true,
	style:'background:#c9c9c9;',
	allowBlank:false,
	width:600
});


this.fieldProveedor= new Ext.form.FieldSet({
        title: 'Datos del Proveedor',
        items:[
          this.compositefieldCIRIF,
          this.tx_razon_social,
          this.tx_direccion
       ]
});


this.co_banco = new Ext.form.ComboBox({
	fieldLabel:'Banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'tx_banco',
	hiddenName:'tb106_solicitud_cuenta_contable_proveedor[co_banco]',
	//readOnly:(this.OBJ.co_banco!='')?true:false,
	//style:(this.main.OBJ.co_banco!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false,
	listeners:{
            select: function(){
                SolicitudEditar.main.storeCO_CUENTA.load({
                    params: {co_banco:this.getValue(),
                             co_proveedor:SolicitudEditar.main.co_proveedor.getValue()},
                    callback: function(){
                        SolicitudEditar.main.co_cuenta_bancaria.setValue('');
                    }
                });
            }
        }
        
});

if(this.OBJ.co_banco){
    this.storeCO_BANCO.load({
            params: {co_proveedor:SolicitudEditar.main.OBJ.co_proveedor},
            callback: function(){
                SolicitudEditar.main.co_banco.setValue(SolicitudEditar.main.OBJ.co_banco);
            }
        
    });
}

this.co_cuenta_bancaria = new Ext.form.ComboBox({
	fieldLabel:'Cuenta',
	store: this.storeCO_CUENTA,
	typeAhead: true,
	valueField: 'co_cuenta_proveedor',
	displayField:'tx_cuenta',
	hiddenName:'tb106_solicitud_cuenta_contable_proveedor[co_cuenta_bancaria]',
	//readOnly:(this.OBJ.co_tipo_cuenta!='')?true:false,
	//style:(this.main.OBJ.co_tipo_cuenta!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false
});

if(this.OBJ.co_cuenta){
    SolicitudEditar.main.storeCO_CUENTA.load({
        params: {co_banco:SolicitudEditar.main.OBJ.co_banco,
                 co_proveedor:SolicitudEditar.main.OBJ.co_proveedor},
        callback: function(){
            SolicitudEditar.main.co_cuenta_bancaria.setValue(SolicitudEditar.main.OBJ.co_cuenta);
        }
    });
}

this.fieldCuenta= new Ext.form.FieldSet({
        title: 'Datos de la Cuenta',
        items:[
         this.co_banco,
         this.co_cuenta_bancaria
       ]
});


this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!SolicitudEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        SolicitudEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/guardarSolicitudProveedor',
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
                 
                 Detalle.main.store_lista.baseParams.co_solicitud = action.result.co_solicitud;
                 Detalle.main.store_lista.load();
                 
               
                 SolicitudEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        SolicitudEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:800,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.co_solicitud_cuenta,
           this.co_solicitud,
           this.co_proveedor,
           this.fieldProveedor,
           this.fieldCuenta]
});

this.winformPanel_ = new Ext.Window({
    title:'Asignación de Cuenta Bancaria',
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
//CuentaBancariaLista.main.mascara.hide();
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
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/storefkcobancoproveedor',
        root:'data',
        fields:[
            {name: 'co_banco'},
            {name: 'tx_banco'}
            ]
    });
    return this.store;
}
,getStoreCO_CUENTA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/storefkcocuentaproveedor',
        root:'data',
        fields:[
            {name: 'co_cuenta_proveedor'},
            {name: 'tx_cuenta'}
            ]
    });
    return this.store;
},
verificarProveedor:function(){
            Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Compras/verificarProveedor',
                params:{
                    co_documento: SolicitudEditar.main.co_documento.getValue(),
                    tx_rif: SolicitudEditar.main.tx_rif.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        SolicitudEditar.main.co_proveedor.setValue("");
                        SolicitudEditar.main.co_documento.setValue("");
                        SolicitudEditar.main.tx_rif.setValue("");
                        SolicitudEditar.main.tx_razon_social.setValue("");
			SolicitudEditar.main.tx_direccion.setValue("");
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

                        SolicitudEditar.main.co_proveedor.setValue(obj.data.co_proveedor);
                        SolicitudEditar.main.tx_razon_social.setValue(obj.data.tx_razon_social);
                        SolicitudEditar.main.tx_direccion.setValue(obj.data.tx_direccion);
                        
                        SolicitudEditar.main.storeCO_BANCO.load({
                           params:{
                               co_proveedor:SolicitudEditar.main.co_proveedor.getValue()
                           } 
                        });
                    }
                }
 });
}
};
Ext.onReady(SolicitudEditar.main.init, SolicitudEditar.main);
</script>
