<script type="text/javascript">
Ext.ns("PartidapresupuestoEditar");
PartidapresupuestoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeID_PARTIDA = this.getStoreID_PARTIDA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_APLICACION = this.getStoreCO_APLICACION();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_INGRESO = this.getStoreCO_TIPO_INGRESO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_AMBITO = this.getStoreCO_AMBITO();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>

this.id_tb084_accion_especifica = new Ext.form.Hidden({
    name:'tb085_presupuesto[id_tb084_accion_especifica]',
    value:this.OBJ.id_tb084_accion_especifica
});

this.co_partida = new Ext.form.Hidden({
    name:'tb085_presupuesto[co_partida]',
    value:this.OBJ.co_partida
});

this.nu_partida = new Ext.form.Hidden({
    name:'tb085_presupuesto[nu_partida]',
    value:this.OBJ.nu_partida
});

this.nu_pa = new Ext.form.Hidden({
    name:'tb085_presupuesto[nu_pa]',
    value:this.OBJ.nu_pa
});

this.nu_ge = new Ext.form.Hidden({
    name:'tb085_presupuesto[nu_ge]',
    value:this.OBJ.nu_ge
});

this.nu_es = new Ext.form.Hidden({
    name:'tb085_presupuesto[nu_es]',
    value:this.OBJ.nu_es
});

this.nu_se = new Ext.form.Hidden({
    name:'tb085_presupuesto[nu_se]',
    value:this.OBJ.nu_se
});

this.nu_sse = new Ext.form.TextField({
	fieldLabel:'SSE',
	name:'tb085_presupuesto[nu_sse]',
	value:this.OBJ.nu_sse,
	allowBlank:false,
	width:200
});

this.de_partida = new Ext.form.TextArea({
	fieldLabel:'Descripcion',
	name:'tb085_presupuesto[de_partida]',
	value:this.OBJ.de_partida,
	allowBlank:false,
	//readOnly:true,
	width:400
});

this.id_tb139_aplicacion = new Ext.form.ComboBox({
	fieldLabel:'Aplicacion',
	store: this.storeCO_APLICACION,
	typeAhead: true,
	valueField: 'co_aplicacion',
	displayField:'aplicacion',
	hiddenName:'tb085_presupuesto[id_tb139_aplicacion]',
	//readOnly:(this.OBJ.id_tb139_aplicacion!='')?true:false,
	//style:(this.main.OBJ.id_tb139_aplicacion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Aplicacion',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeCO_APLICACION.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb139_aplicacion,
	value:  this.OBJ.id_tb139_aplicacion,
	objStore: this.storeCO_APLICACION
});

this.id_tb091_partida = new Ext.form.ComboBox({
	fieldLabel:'Partida',
	store: this.storeID_PARTIDA,
	typeAhead: true,
	valueField: 'id',
	displayField:'partida',
	hiddenName:'tb085_presupuesto[id_tb091_partida]',
	//readOnly:(this.OBJ.id_tb091_partida!='')?true:false,
	//style:(this.main.OBJ.id_tb091_partida!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Partida',
	itemSelector: 'div.search-item',
	tpl: new Ext.XTemplate('<tpl for="."><div class="search-item"><div class="desc">{partida}</div></div></tpl>'),
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false,
	onSelect: function(record){
		PartidapresupuestoEditar.main.id_tb091_partida.setValue(record.data.id);
		PartidapresupuestoEditar.main.co_partida.setValue(record.data.nu_partida);
		PartidapresupuestoEditar.main.nu_partida.setValue(record.data.nu_partida);
		PartidapresupuestoEditar.main.nu_pa.setValue(record.data.nu_pa);
		PartidapresupuestoEditar.main.nu_ge.setValue(record.data.nu_ge);
		PartidapresupuestoEditar.main.nu_es.setValue(record.data.nu_es);
		PartidapresupuestoEditar.main.nu_se.setValue(record.data.nu_se);
		PartidapresupuestoEditar.main.de_partida.setValue(record.data.de_partida);
		this.collapse();
	}
});
this.storeID_PARTIDA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb091_partida,
	value:  this.OBJ.id_tb091_partida,
	objStore: this.storeID_PARTIDA
});

this.id_tb140_tipo_ingreso = new Ext.form.ComboBox({
	fieldLabel:'Tipo Ingreso',
	store: this.storeCO_TIPO_INGRESO,
	typeAhead: true,
	valueField: 'co_tipo_ingreso',
	displayField:'tipo_ingreso',
	hiddenName:'tb085_presupuesto[id_tb140_tipo_ingreso]',
	//readOnly:(this.OBJ.id_tb140_tipo_ingreso!='')?true:false,
	//style:(this.main.OBJ.id_tb140_tipo_ingreso!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Tipo Ingreso',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_INGRESO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb140_tipo_ingreso,
	value:  this.OBJ.id_tb140_tipo_ingreso,
	objStore: this.storeCO_TIPO_INGRESO
});

this.id_tb138_ambito = new Ext.form.ComboBox({
	fieldLabel:'Ambito',
	store: this.storeCO_AMBITO,
	typeAhead: true,
	valueField: 'co_ambito',
	displayField:'ambito',
	hiddenName:'tb085_presupuesto[id_tb138_ambito]',
	//readOnly:(this.OBJ.id_tb138_ambito!='')?true:false,
	//style:(this.main.OBJ.id_tb138_ambito!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Ambito',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeCO_AMBITO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb138_ambito,
	value:  this.OBJ.id_tb138_ambito,
	objStore: this.storeCO_AMBITO
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
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/guardar',
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
                 PartidapresupuestoLista.main.store_lista.load();
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
					this.id_tb084_accion_especifica,
					this.co_partida,
					this.nu_partida,
					this.nu_pa,
                    this.nu_ge,
                    this.nu_es,
                    this.nu_se,
					this.id_tb140_tipo_ingreso,
                    this.id_tb138_ambito,
					this.id_tb139_aplicacion,
					this.id_tb091_partida,
					this.nu_sse,
                    this.de_partida,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Partida',
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
PartidapresupuestoLista.main.mascara.hide();
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAePartida/storefkidtb166pacaetmp',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreCO_APLICACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAePartida/storefkidtb139aplicacion',
        root:'data',
        fields:[
            {name: 'co_aplicacion'},
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
,getStoreID_PARTIDA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAePartida/storefkidtb091partida',
        root:'data',
        fields:[
			{name: 'id'},
			{name: 'de_partida'},
			{name: 'nu_pa'},
			{name: 'nu_ge'},
			{name: 'nu_es'},
			{name: 'nu_se'},
			{name: 'nu_partida'},
            {
				name: 'partida',
				convert: function(v, r) {
						return r.co_partida + ' - ' + r.de_partida;
				}
		    }
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_INGRESO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAePartida/storefkidtb140tipoingreso',
        root:'data',
        fields:[
            {name: 'co_tipo_ingreso'},
            {
				name: 'tipo_ingreso',
				convert: function(v, r) {
						return r.tx_tip_ingreso + ' - ' + r.tx_descripcion;
				}
		    }
            ]
    });
    return this.store;
}
,getStoreCO_AMBITO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAePartida/storefkidtb138ambito',
        root:'data',
        fields:[
            {name: 'co_ambito'},
            {
				name: 'ambito',
				convert: function(v, r) {
						//return r.nu_anio + ' - ' + r.tx_ambito;
						return r.co_ambito + ' - ' + r.tx_ambito;
				}
		    }
            ]
    });
    return this.store;
}
};
Ext.onReady(PartidapresupuestoEditar.main.init, PartidapresupuestoEditar.main);
</script>
