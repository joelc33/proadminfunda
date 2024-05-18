<script type="text/javascript">
Ext.ns("CajaEditar");
CajaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_SOLICITUD = this.getStoreCO_SOLICITUD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_SOLICITUD = this.getStoreCO_TIPO_SOLICITUD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_PROCESO = this.getStoreCO_PROCESO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ESTATUS_RUTA = this.getStoreCO_ESTATUS_RUTA();
//<Stores de fk>

//<ClavePrimaria>
this.co_ruta = new Ext.form.Hidden({
    name:'co_ruta',
    value:this.OBJ.co_ruta});
//</ClavePrimaria>


this.co_solicitud = new Ext.form.ComboBox({
	fieldLabel:'Co solicitud',
	store: this.storeCO_SOLICITUD,
	typeAhead: true,
	valueField: 'co_solicitud',
	displayField:'co_solicitud',
	hiddenName:'tb030_ruta[co_solicitud]',
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
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_solicitud,
	value:  this.OBJ.co_solicitud,
	objStore: this.storeCO_SOLICITUD
});

this.co_tipo_solicitud = new Ext.form.ComboBox({
	fieldLabel:'Co tipo solicitud',
	store: this.storeCO_TIPO_SOLICITUD,
	typeAhead: true,
	valueField: 'co_tipo_solicitud',
	displayField:'co_tipo_solicitud',
	hiddenName:'tb030_ruta[co_tipo_solicitud]',
	//readOnly:(this.OBJ.co_tipo_solicitud!='')?true:false,
	//style:(this.main.OBJ.co_tipo_solicitud!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_solicitud',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_SOLICITUD.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tipo_solicitud,
	value:  this.OBJ.co_tipo_solicitud,
	objStore: this.storeCO_TIPO_SOLICITUD
});

this.co_proceso = new Ext.form.ComboBox({
	fieldLabel:'Co proceso',
	store: this.storeCO_PROCESO,
	typeAhead: true,
	valueField: 'co_proceso',
	displayField:'co_proceso',
	hiddenName:'tb030_ruta[co_proceso]',
	//readOnly:(this.OBJ.co_proceso!='')?true:false,
	//style:(this.main.OBJ.co_proceso!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_proceso',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_PROCESO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_proceso,
	value:  this.OBJ.co_proceso,
	objStore: this.storeCO_PROCESO
});

this.observacion = new Ext.form.TextField({
	fieldLabel:'Observacion',
	name:'tb030_ruta[observacion]',
	value:this.OBJ.observacion,
	allowBlank:false,
	width:200
});

this.co_estatus_ruta = new Ext.form.ComboBox({
	fieldLabel:'Co estatus ruta',
	store: this.storeCO_ESTATUS_RUTA,
	typeAhead: true,
	valueField: 'co_estatus_ruta',
	displayField:'co_estatus_ruta',
	hiddenName:'tb030_ruta[co_estatus_ruta]',
	//readOnly:(this.OBJ.co_estatus_ruta!='')?true:false,
	//style:(this.main.OBJ.co_estatus_ruta!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_estatus_ruta',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ESTATUS_RUTA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_estatus_ruta,
	value:  this.OBJ.co_estatus_ruta,
	objStore: this.storeCO_ESTATUS_RUTA
});

this.co_usuario = new Ext.form.NumberField({
	fieldLabel:'Co usuario',
	name:'tb030_ruta[co_usuario]',
	value:this.OBJ.co_usuario,
	allowBlank:false
});

this.nu_orden = new Ext.form.NumberField({
	fieldLabel:'Nu orden',
	name:'tb030_ruta[nu_orden]',
	value:this.OBJ.nu_orden,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tb030_ruta[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tb030_ruta[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.in_actual = new Ext.form.Checkbox({
	fieldLabel:'In actual',
	name:'tb030_ruta[in_actual]',
	checked:(this.OBJ.in_actual=='0') ? true:false,
	allowBlank:false
});

this.in_cargar_dato = new Ext.form.Checkbox({
	fieldLabel:'In cargar dato',
	name:'tb030_ruta[in_cargar_dato]',
	checked:(this.OBJ.in_cargar_dato=='0') ? true:false,
	allowBlank:false
});

this.tx_ruta_reporte = new Ext.form.TextField({
	fieldLabel:'Tx ruta reporte',
	name:'tb030_ruta[tx_ruta_reporte]',
	value:this.OBJ.tx_ruta_reporte,
	allowBlank:false,
	width:200
});

this.tx_imagen = new Ext.form.TextField({
	fieldLabel:'Tx imagen',
	name:'tb030_ruta[tx_imagen]',
	value:this.OBJ.tx_imagen,
	allowBlank:false,
	width:200
});

this.tx_documento = new Ext.form.TextField({
	fieldLabel:'Tx documento',
	name:'tb030_ruta[tx_documento]',
	value:this.OBJ.tx_documento,
	allowBlank:false,
	width:200
});

this.co_usuario_actualizo = new Ext.form.NumberField({
	fieldLabel:'Co usuario actualizo',
	name:'tb030_ruta[co_usuario_actualizo]',
	value:this.OBJ.co_usuario_actualizo,
	allowBlank:false
});

this.co_solicitud_anular = new Ext.form.NumberField({
	fieldLabel:'Co solicitud anular',
	name:'tb030_ruta[co_solicitud_anular]',
	value:this.OBJ.co_solicitud_anular,
	allowBlank:false
});

this.in_anular = new Ext.form.Checkbox({
	fieldLabel:'In anular',
	name:'tb030_ruta[in_anular]',
	checked:(this.OBJ.in_anular=='0') ? true:false,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!CajaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        CajaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Caja/guardar',
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
                 CajaLista.main.store_lista.load();
                 CajaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        CajaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_ruta,
                    this.co_solicitud,
                    this.co_tipo_solicitud,
                    this.co_proceso,
                    this.observacion,
                    this.co_estatus_ruta,
                    this.co_usuario,
                    this.nu_orden,
                    this.created_at,
                    this.updated_at,
                    this.in_actual,
                    this.in_cargar_dato,
                    this.tx_ruta_reporte,
                    this.tx_imagen,
                    this.tx_documento,
                    this.co_usuario_actualizo,
                    this.co_solicitud_anular,
                    this.in_anular,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Caja',
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
CajaLista.main.mascara.hide();
}
,getStoreCO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Caja/storefkcosolicitud',
        root:'data',
        fields:[
            {name: 'co_solicitud'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Caja/storefkcotiposolicitud',
        root:'data',
        fields:[
            {name: 'co_tipo_solicitud'}
            ]
    });
    return this.store;
}
,getStoreCO_PROCESO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Caja/storefkcoproceso',
        root:'data',
        fields:[
            {name: 'co_proceso'}
            ]
    });
    return this.store;
}
,getStoreCO_ESTATUS_RUTA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Caja/storefkcoestatusruta',
        root:'data',
        fields:[
            {name: 'co_estatus_ruta'}
            ]
    });
    return this.store;
}
};
Ext.onReady(CajaEditar.main.init, CajaEditar.main);
</script>
