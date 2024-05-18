<script type="text/javascript">
Ext.ns("PartidapresupuestoEditar");
PartidapresupuestoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeID_TB139_APLICACION = this.getStoreID_TB139_APLICACION();
this.storeTIPO_GASTO          = this.getStoreTIPO_GASTO();
this.storeCLASIFICACION_ECONOMICA          = this.getStoreCLASIFICACION_ECONOMICA();
this.storeAMBITO          = this.getStoreAMBITO();
this.storeAREA_ESTRATEGICA          = this.getStoreAREA_ESTRATEGICA();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>
//<ClavePrimaria>
this.co_ejecutor = new Ext.form.Hidden({
    name:'co_ejecutor',
    value:this.OBJ.co_ejecutor});
//</ClavePrimaria>
this.de_apl = new Ext.form.Hidden({
    name:'tb085_presupuesto[de_aplicacion]',
    value:this.OBJ.tip_apl});

this.nu_partida = new Ext.form.TextField({
	fieldLabel:'Partida',
	name:'tb085_presupuesto[nu_partida]',
	value:this.OBJ.nu_partida,
	allowBlank:false,
	width:200,
    readOnly:true,
    style:'background:#c9c9c9;',
});

this.de_partida = new Ext.form.TextArea({
	fieldLabel:'Descripcion',
	name:'tb085_presupuesto[de_partida]',
	value:this.OBJ.de_partida,
	allowBlank:false,
	width:400,
    readOnly:true,
    style:'background:#c9c9c9;',
});

this.mo_inicial = new Ext.form.NumberField({
	fieldLabel:'Inicial',
	name:'tb085_presupuesto[mo_inicial]',
	value:this.OBJ.mo_inicial,
	allowBlank:false,
	width:200,
    readOnly:true,
    style:'background:#c9c9c9;',
});

this.mo_actualizado = new Ext.form.NumberField({
	fieldLabel:'Actualizado',
	name:'tb085_presupuesto[mo_actualizado]',
	value:this.OBJ.mo_actualizado,
	allowBlank:false,
	width:200,
    readOnly:true,
    style:'background:#c9c9c9;',
});

this.mo_precomprometido = new Ext.form.NumberField({
	fieldLabel:'Precomprometido',
	name:'tb085_presupuesto[mo_precomprometido]',
	value:this.OBJ.mo_precomprometido,
	allowBlank:false,
	width:200,
    readOnly:true,
    style:'background:#c9c9c9;',
});

this.mo_comprometido = new Ext.form.NumberField({
	fieldLabel:'Comprometido',
	name:'tb085_presupuesto[mo_comprometido]',
	value:this.OBJ.mo_comprometido,
	allowBlank:false,
	width:200,
    readOnly:true,
    style:'background:#c9c9c9;',
});

this.mo_causado = new Ext.form.NumberField({
	fieldLabel:'Causado',
	name:'tb085_presupuesto[mo_causado]',
	value:this.OBJ.mo_causado,
	allowBlank:false,
	width:200,
    readOnly:true,
    style:'background:#c9c9c9;',
});

this.mo_pagado = new Ext.form.NumberField({
	fieldLabel:'Pagado',
	name:'tb085_presupuesto[mo_pagado]',
	value:this.OBJ.mo_pagado,
	allowBlank:false,
	width:200,
    readOnly:true,
    style:'background:#c9c9c9;',
});

this.mo_disponible = new Ext.form.NumberField({
	fieldLabel:'Disponible',
	name:'tb085_presupuesto[mo_disponible]',
	value:this.OBJ.mo_disponible,
	allowBlank:false,
    width:200,
    readOnly:true,
    style:'background:#c9c9c9;',
});

this.tip_apl = new Ext.form.TextField({
	fieldLabel:'Desc. Aplicacion',
	name:'tb085_presupuesto[tip_apl]',
	value:this.OBJ.tip_apl,
	//allowBlank:false,
    width:200,
    readOnly:true,
    style:'background:#c9c9c9;',
});

this.id_tb139_aplicacion = new Ext.form.ComboBox({
	fieldLabel:'Aplicacion',
	store: this.storeID_TB139_APLICACION,
	typeAhead: true,
	valueField: 'co_aplicacion',
	displayField:'aplicacion',
	hiddenName:'tb085_presupuesto[id_tb139_aplicacion]',
	//readOnly:(this.OBJ.id_tb139_aplicacion!='')?true:false,
	//style:(this.main.OBJ.id_tb084_accion_especifica!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Aplicacion',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
    allowBlank:false,
    onSelect: function(record){
		PartidapresupuestoEditar.main.id_tb139_aplicacion.setValue(record.data.co_aplicacion);
		PartidapresupuestoEditar.main.de_apl.setValue(record.data.tx_tip_aplicacion);
		this.collapse();
        }
});
/*this.storeID_TB139_APLICACION.load({
    params:{
        co_ejecutor: PartidapresupuestoListaDesagregada.main.co_ejecutor.getValue()
    }
});*/
this.storeID_TB139_APLICACION.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb139_aplicacion,
	value:  this.OBJ.id_tb139_aplicacion,
	objStore: this.storeID_TB139_APLICACION
});


this.tipo_gasto = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Gasto',
	store: this.storeTIPO_GASTO,
	typeAhead: true,
	valueField: 'tx_siglas',
	displayField:'tx_descripcion',
	hiddenName:'tb085_presupuesto[tipo_gasto]',
	//readOnly:(this.OBJ.id_tb139_aplicacion!='')?true:false,
	//style:(this.main.OBJ.id_tb084_accion_especifica!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
        allowBlank:false
});
/*this.storeID_TB139_APLICACION.load({
    params:{
        co_ejecutor: PartidapresupuestoListaDesagregada.main.co_ejecutor.getValue()
    }
});*/
this.storeTIPO_GASTO.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.tipo_gasto,
	value:  this.OBJ.tipo_gasto,
	objStore: this.storeTIPO_GASTO
});

this.co_clasificacion_economica = new Ext.form.ComboBox({
	fieldLabel:'Clasificacion Economica',
	store: this.storeCLASIFICACION_ECONOMICA,
	typeAhead: true,
	valueField: 'co_clasificacion_economica',
	displayField:'tx_descripcion',
	hiddenName:'tb085_presupuesto[co_clasificacion_economica]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
        allowBlank:false
});
this.storeCLASIFICACION_ECONOMICA.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_clasificacion_economica,
	value:  this.OBJ.co_clasificacion_economica,
	objStore: this.storeCLASIFICACION_ECONOMICA
});

this.co_ambito = new Ext.form.ComboBox({
	fieldLabel:'Ambito',
	store: this.storeAMBITO,
	typeAhead: true,
	valueField: 'co_ambito',
	displayField:'tx_ambito',
	hiddenName:'tb085_presupuesto[co_ambito]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
        allowBlank:false
});
this.storeAMBITO.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_ambito,
	value:  this.OBJ.co_ambito,
	objStore: this.storeAMBITO
});

this.co_area_estrategica = new Ext.form.ComboBox({
	fieldLabel:'Area Estrategica',
	store: this.storeAREA_ESTRATEGICA,
	typeAhead: true,
	valueField: 'co_area_estrategica',
	displayField:'tx_descripcion',
	hiddenName:'tb085_presupuesto[co_area_estrategica]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
        allowBlank:false
});
this.storeAREA_ESTRATEGICA.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_area_estrategica,
	value:  this.OBJ.co_area_estrategica,
	objStore: this.storeAREA_ESTRATEGICA
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PartidapresupuestoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PartidapresupuestoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/guardarAplicacion',
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
                 PartidapresupuestoListaDesagregada.main.store_lista.load();
                 PartidapresupuestoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PartidapresupuestoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
                    this.de_apl,
                    this.nu_partida,
                    this.de_partida,
                    this.mo_inicial,
                    this.mo_actualizado,
                    //this.mo_precomprometido,
                    this.mo_comprometido,
                    this.mo_causado,
                    this.mo_pagado,
                    this.mo_disponible,
                    this.tip_apl,
                    this.id_tb139_aplicacion,
                    this.tipo_gasto,
                    this.co_clasificacion_economica,
                    this.co_ambito,
                    this.co_area_estrategica
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Partida Presupuesto',
    modal:true,
    constrain:true,
width:614,
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
PartidapresupuestoListaDesagregada.main.mascara.hide();
}
,getStoreID_TB139_APLICACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storefkcoaplicacionTodo',
        root:'data',
        fields:[
            {name: 'co_aplicacion'},
            {name: 'nu_anio_fiscal'},
            {name: 'tx_tip_aplicacion'},
            {name: 'tx_aplicacion'},
            {
				name: 'aplicacion',
				convert: function(v, r) {
						return r.tx_tip_aplicacion + ' - ' + r.tx_aplicacion;
				}
		    }
            ]
    });
    return this.store;
}
,getStoreTIPO_GASTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storefkTipoGasto',
        root:'data',
        fields:[
            {name: 'tx_siglas'},
            {name: 'tx_descripcion'}
        ]
    });
    return this.store;
}
,getStoreCLASIFICACION_ECONOMICA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storefkClasificacionEconomica',
        root:'data',
        fields:[
            {name: 'co_clasificacion_economica'},
            {name: 'tx_descripcion'}
        ]
    });
    return this.store;
}
,getStoreAMBITO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storefkAmbito',
        root:'data',
        fields:[
            {name: 'co_ambito'},
            {name: 'tx_ambito'}
        ]
    });
    return this.store;
}
,getStoreAREA_ESTRATEGICA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storefkAreaEstrategica',
        root:'data',
        fields:[
            {name: 'co_area_estrategica'},
            {name: 'tx_descripcion'}
        ]
    });
    return this.store;
}
};
Ext.onReady(PartidapresupuestoEditar.main.init, PartidapresupuestoEditar.main);
</script>
