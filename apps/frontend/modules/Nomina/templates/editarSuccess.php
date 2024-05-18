<script type="text/javascript">
Ext.ns("NominaEditar");
NominaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_TP_NOMINA = this.getStoreCO_TP_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_NOM_FRECUENCIA_PAGO = this.getStoreCO_NOM_FRECUENCIA_PAGO();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>

//<ClavePrimaria>
this.co_nomina = new Ext.form.Hidden({
    name:'co_nomina',
    value:this.OBJ.co_nomina});
//</ClavePrimaria>


this.co_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co solicitud',
	name:'tbrh013_nomina[co_solicitud]',
	value:this.OBJ.co_solicitud,
	allowBlank:false
});

this.co_tp_nomina = new Ext.form.ComboBox({
	fieldLabel:'Co tp nomina',
	store: this.storeCO_TP_NOMINA,
	typeAhead: true,
	valueField: 'co_tp_nomina',
	displayField:'co_tp_nomina',
	hiddenName:'tbrh013_nomina[co_tp_nomina]',
	//readOnly:(this.OBJ.co_tp_nomina!='')?true:false,
	//style:(this.main.OBJ.co_tp_nomina!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tp_nomina',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TP_NOMINA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tp_nomina,
	value:  this.OBJ.co_tp_nomina,
	objStore: this.storeCO_TP_NOMINA
});

this.co_nom_frecuencia_pago = new Ext.form.ComboBox({
	fieldLabel:'Co nom frecuencia pago',
	store: this.storeCO_NOM_FRECUENCIA_PAGO,
	typeAhead: true,
	valueField: 'co_nom_frecuencia_pago',
	displayField:'co_nom_frecuencia_pago',
	hiddenName:'tbrh013_nomina[co_nom_frecuencia_pago]',
	//readOnly:(this.OBJ.co_nom_frecuencia_pago!='')?true:false,
	//style:(this.main.OBJ.co_nom_frecuencia_pago!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_nom_frecuencia_pago',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_NOM_FRECUENCIA_PAGO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_nom_frecuencia_pago,
	value:  this.OBJ.co_nom_frecuencia_pago,
	objStore: this.storeCO_NOM_FRECUENCIA_PAGO
});

this.nu_nomina = new Ext.form.TextField({
	fieldLabel:'Nu nomina',
	name:'tbrh013_nomina[nu_nomina]',
	value:this.OBJ.nu_nomina,
	allowBlank:false,
	width:200
});

this.de_nomina = new Ext.form.TextField({
	fieldLabel:'De nomina',
	name:'tbrh013_nomina[de_nomina]',
	value:this.OBJ.de_nomina,
	allowBlank:false,
	width:200
});

this.de_observacion = new Ext.form.TextField({
	fieldLabel:'De observacion',
	name:'tbrh013_nomina[de_observacion]',
	value:this.OBJ.de_observacion,
	allowBlank:false,
	width:200
});

this.fe_inicio = new Ext.form.DateField({
	fieldLabel:'Fe inicio',
	name:'tbrh013_nomina[fe_inicio]',
	value:this.OBJ.fe_inicio,
	allowBlank:false,
	width:100
});

this.fe_fin = new Ext.form.DateField({
	fieldLabel:'Fe fin',
	name:'tbrh013_nomina[fe_fin]',
	value:this.OBJ.fe_fin,
	allowBlank:false,
	width:100
});

this.fe_pago = new Ext.form.DateField({
	fieldLabel:'Fe pago',
	name:'tbrh013_nomina[fe_pago]',
	value:this.OBJ.fe_pago,
	allowBlank:false,
	width:100
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tbrh013_nomina[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tbrh013_nomina[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tbrh013_nomina[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.in_procesado = new Ext.form.Checkbox({
	fieldLabel:'In procesado',
	name:'tbrh013_nomina[in_procesado]',
	checked:(this.OBJ.in_procesado=='0') ? true:false,
	allowBlank:false
});

this.id_tbrh060_nomina_estatus = new Ext.form.ComboBox({
	fieldLabel:'Id tbrh060 nomina estatus',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tbrh013_nomina[id_tbrh060_nomina_estatus]',
	//readOnly:(this.OBJ.id_tbrh060_nomina_estatus!='')?true:false,
	//style:(this.main.OBJ.id_tbrh060_nomina_estatus!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tbrh060_nomina_estatus',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tbrh060_nomina_estatus,
	value:  this.OBJ.id_tbrh060_nomina_estatus,
	objStore: this.storeID
});

this.co_grupo_nomina = new Ext.form.NumberField({
	fieldLabel:'Co grupo nomina',
	name:'tbrh013_nomina[co_grupo_nomina]',
	value:this.OBJ.co_grupo_nomina,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!NominaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        NominaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/guardar',
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
                 NominaLista.main.store_lista.load();
                 NominaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        NominaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_nomina,
                    this.co_solicitud,
                    this.co_tp_nomina,
                    this.co_nom_frecuencia_pago,
                    this.nu_nomina,
                    this.de_nomina,
                    this.de_observacion,
                    this.fe_inicio,
                    this.fe_fin,
                    this.fe_pago,
                    this.in_activo,
                    this.created_at,
                    this.updated_at,
                    this.in_procesado,
                    this.id_tbrh060_nomina_estatus,
                    this.co_grupo_nomina,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Nomina',
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
NominaLista.main.mascara.hide();
}
,getStoreCO_TP_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/storefkcotpnomina',
        root:'data',
        fields:[
            {name: 'co_tp_nomina'}
            ]
    });
    return this.store;
}
,getStoreCO_NOM_FRECUENCIA_PAGO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/storefkconomfrecuenciapago',
        root:'data',
        fields:[
            {name: 'co_nom_frecuencia_pago'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/storefkidtbrh060nominaestatus',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
};
Ext.onReady(NominaEditar.main.init, NominaEditar.main);
</script>
