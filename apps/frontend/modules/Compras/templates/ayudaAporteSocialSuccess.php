<script type="text/javascript">
Ext.ns("RegistroAyudaEditar");
RegistroAyudaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.storeCO_TIPO_AYUDA = this.getStoreCO_TIPO_AYUDA();
this.storeCO_DOCUMENTO  = this.getStoreCO_DOCUMENTO();
this.storeCO_PARTIDA    = this.getStoreCO_PARTIDA();

//<ClavePrimaria>
this.co_solicitud_ayuda = new Ext.form.Hidden({
    name:'co_solicitud_ayuda',
    value:this.OBJ.co_solicitud_ayuda
});

this.co_compras = new Ext.form.Hidden({
    name:'co_compras',
    value:this.OBJ.co_compras
});

this.co_detalle_compras = new Ext.form.Hidden({
    name:'co_detalle_compras',
    value:this.OBJ.co_detalle_compras
});
//</ClavePrimaria>

this.co_persona = new Ext.form.Hidden({
    name:'tb126_solicitud_ayuda[co_persona]',
    value:this.OBJ.co_persona
});
this.co_solicitud = new Ext.form.Hidden({
    name:'tb126_solicitud_ayuda[co_solicitud]',
    value:this.OBJ.co_solicitud
});
this.co_usuario = new Ext.form.Hidden({
    name:'tb126_solicitud_ayuda[co_usuario]',
    value:this.OBJ.co_usuario
});
    
this.nb_persona = new Ext.form.TextField({
	fieldLabel:'Nombres',
	name:'tb109_persona[nb_persona]',
	value:this.OBJ.nb_persona,
        readOnly:(this.OBJ.nb_persona!='')?true:false,
	style:(this.OBJ.nb_persona!='')?'background:#c9c9c9;':'',
	allowBlank:false,
	width:400
});

this.ap_persona = new Ext.form.TextField({
	fieldLabel:'Apellidos',
	name:'tb109_persona[ap_persona]',
	value:this.OBJ.ap_persona,
        readOnly:(this.OBJ.ap_persona!='')?true:false,
	style:(this.OBJ.ap_persona!='')?'background:#c9c9c9;':'',
	allowBlank:false,
	width:400
});

this.nu_cedula = new Ext.form.NumberField({
	fieldLabel:'Cédula',
	name:'tb109_persona[nu_cedula]',
	value:this.OBJ.nu_cedula,
        readOnly:(this.OBJ.nu_cedula!='')?true:false,
	style:(this.OBJ.nu_cedula!='')?'background:#c9c9c9;':'',
	allowBlank:false,
        maskRe: /[0-9]/, 
});
    
this.nu_celular = new Ext.form.TextField({
	fieldLabel:'Nro Celular',
	name:'tb109_persona[nu_celular]',
	value:this.OBJ.nu_celular,
        readOnly:(this.OBJ.nu_celular!='')?true:false,
	style:(this.OBJ.nu_celular!='')?'background:#c9c9c9;':'',
	allowBlank:false,
	width:200,
        maskRe: /[0-9]/, 
});

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'tb109_persona[co_documento]',
	readOnly:(this.OBJ.co_documento!='')?true:false,
	style:(this.OBJ.co_documento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'...',
	selectOnFocus: true,
	mode: 'local',
	width:40,
	resizable:true,
	allowBlank:false
});

this.storeCO_DOCUMENTO.load();

this.compositefieldCI = new Ext.form.CompositeField({
fieldLabel: 'Cedula',
items: [
	this.co_documento,
	this.nu_cedula
	]
});


this.co_documento.on("blur",function(){
    if(RegistroAyudaEditar.main.nu_cedula.getValue()!=''){
        RegistroAyudaEditar.main.verificarSolicitante();
    }
});

this.nu_cedula.on("blur",function(){
    RegistroAyudaEditar.main.verificarSolicitante();
});

this.fieldDatosSolicitante= new Ext.form.FieldSet({
        title: 'Datos del Solicitante',
        width:850,
        items:[this.compositefieldCI,
                this.nb_persona,
//                this.ap_persona,
                this.nu_celular]
});

this.co_tipo_ayuda = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Ayuda',
	store: this.storeCO_TIPO_AYUDA,
	typeAhead: true,
	valueField: 'co_tipo_ayuda',
	displayField:'tx_tipo_ayuda',
	hiddenName:'tb126_solicitud_ayuda[co_tipo_ayuda]',
	readOnly:(this.OBJ.co_tipo_ayuda!='')?true:false,
	style:(this.OBJ.co_tipo_ayuda!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_AYUDA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tipo_ayuda,
	value:  this.OBJ.co_tipo_ayuda,
	objStore: this.storeCO_TIPO_AYUDA
});


this.nu_resolucion = new Ext.form.TextField({
	fieldLabel:'Nro. Resolución',
	name:'tb126_solicitud_ayuda[nu_resolucion]',
	value:this.OBJ.nu_resolucion,
	allowBlank:false,
    readOnly:true,
	style:'background:#c9c9c9;',
});

this.fe_resolucion = new Ext.form.DateField({
	fieldLabel:'Fecha Resolución',
	name:'tb126_solicitud_ayuda[fe_resolucion]',
	value:this.OBJ.fe_resolucion,
	allowBlank:false,
	width:100
});

this.mo_ayuda = new Ext.form.NumberField({
	fieldLabel:'Monto',
	name:'tb126_solicitud_ayuda[mo_ayuda]',
	value:this.OBJ.monto,
	allowBlank:false,
        maskRe: /[0-9]/,
	width:300
});

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Descripción',
	name:'tb126_solicitud_ayuda[tx_descripcion]',
	value:this.OBJ.detalle,
	allowBlank:false,
	width:700
});

this.tx_observacion = new Ext.form.TextArea({
	fieldLabel:'Observacion',
	name:'tb126_solicitud_ayuda[tx_observacion]',
	value:this.OBJ.tx_observacion,
	allowBlank:false,
	width:700
});

this.fieldDatosAyuda= new Ext.form.FieldSet({
        title: 'Datos de la Ayuda',
        width:850,
        items:[this.co_tipo_ayuda,
               this.co_compras,
               this.co_detalle_compras,
               this.nu_resolucion,
               this.fe_resolucion,
               this.mo_ayuda,
               this.tx_descripcion,
               this.tx_observacion]
});



this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!RegistroAyudaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        RegistroAyudaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/guardarAyudaAporteSocial',
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
                 RegistroAyudaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        RegistroAyudaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    width:900,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[         this.co_solicitud_ayuda,
                    this.co_persona,
                    this.fieldDatosSolicitante,
                    this.fieldDatosAyuda,
                    this.co_solicitud,
                    this.co_usuario
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Registro de Ayuda',
    constrain:true,
    width:900,
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

if(this.OBJ.co_persona!=''){
    RegistroAyudaEditar.main.verificarSolicitante();
}

//SolicitudAyudaLista.main.mascara.hide();
},
getStoreCO_PARTIDA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcopartidaAyuda',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_partida',
            convert:function(v,r){
            return r.nu_partida+' - '+r.de_partida;
            }
            }
            ]
    });
    return this.store;
},
verificarSolicitante:function(){
            Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Viatico/verificarSolicitante',
                params:{
                    co_documento: RegistroAyudaEditar.main.co_documento.getValue(),
                    tx_rif: RegistroAyudaEditar.main.nu_cedula.getValue(),
                    co_proveedor: RegistroAyudaEditar.main.co_persona.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                            RegistroAyudaEditar.main.co_persona.setValue("");
                            RegistroAyudaEditar.main.nb_persona.setValue("");
                            RegistroAyudaEditar.main.ap_persona.setValue("");
                            RegistroAyudaEditar.main.nu_celular.setValue("");
                    }else{

                            RegistroAyudaEditar.main.co_persona.setValue(obj.data.co_proveedor);
                            RegistroAyudaEditar.main.nb_persona.setValue(obj.data.tx_razon_social);
                            RegistroAyudaEditar.main.nu_celular.setValue(obj.data.nu_celular);
                            RegistroAyudaEditar.main.nu_cedula.setValue(obj.data.tx_rif);
                            
                            RegistroAyudaEditar.main.storeCO_DOCUMENTO.load({
                                callback: function(){
                                    RegistroAyudaEditar.main.co_documento.setValue(obj.data.co_documento);
                                }
                            });
                            
                            
                    }
                }
 });
},getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'},
            {name: 'inicial'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_AYUDA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/storefkcotipoayuda',
        root:'data',
        fields:[
            {name: 'co_tipo_ayuda'},
            {name: 'tx_tipo_ayuda'}
            ]
    });
    return this.store;
}
};
Ext.onReady(RegistroAyudaEditar.main.init, RegistroAyudaEditar.main);
</script>

