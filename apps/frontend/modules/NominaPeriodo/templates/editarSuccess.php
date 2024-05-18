<script type="text/javascript">
Ext.ns("NominaPeriodoEditar");
NominaPeriodoEditar.main = {
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
//<Stores de fk>
this.storeCO_GRUPO_NOMINA = this.getStoreCO_GRUPO_NOMINA();
//<Stores de fk>

//<ClavePrimaria>
this.co_nomina = new Ext.form.Hidden({
    name:'co_nomina',
    value:this.OBJ.co_nomina});
//</ClavePrimaria>

//<ClavePrimaria>
this.co_solicitud = new Ext.form.Hidden({
    name:'tbrh013_nomina[co_solicitud]',
    value:this.OBJ.co_solicitud});
//</ClavePrimaria>

this.co_tp_nomina = new Ext.form.ComboBox({
	fieldLabel:'Nomina',
	store: this.storeCO_TP_NOMINA,
	typeAhead: true,
	valueField: 'co_tp_nomina',
	displayField:'nomina',
	hiddenName:'tbrh013_nomina[co_tp_nomina]',
	//readOnly:(this.OBJ.co_tp_nomina!='')?true:false,
	//style:(this.main.OBJ.co_tp_nomina!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Nomina...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false,
    listeners:{
		select: function(){
			NominaPeriodoEditar.main.co_grupo_nomina.clearValue();
			NominaPeriodoEditar.main.storeCO_GRUPO_NOMINA.load({
				params: {
					tipo:this.getValue()
				}
			})
		}
  	}
});
this.storeCO_TP_NOMINA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tp_nomina,
	value:  this.OBJ.co_tp_nomina,
	objStore: this.storeCO_TP_NOMINA
});

this.co_grupo_nomina = new Ext.form.ComboBox({
	fieldLabel:'Sub-Grupo',
	store: this.storeCO_GRUPO_NOMINA,
	typeAhead: true,
	valueField: 'co_grupo_nomina',
	displayField:'cod_grupo_nomina',
	hiddenName:'tbrh013_nomina[co_grupo_nomina]',
	//readOnly:(this.OBJ.co_grupo_nomina!='')?true:false,
	//style:(this.main.OBJ.co_grupo_nomina!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Grupo...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false,
	listeners:{
		select: function(){
			NominaPeriodoEditar.main.cargarDisponible(this.getValue());
		}
	}
});
/*
this.storeCO_CUENTA_BANCARIA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_grupo_nomina,
	value:  this.OBJ.co_grupo_nomina,
	objStore: this.storeCO_CUENTA_BANCARIA
});*/

if(this.OBJ.co_tp_nomina){
  	this.storeCO_GRUPO_NOMINA.load({
		params: {
			tipo:this.OBJ.co_tp_nomina
		},
		callback: function(){
			NominaPeriodoEditar.main.co_grupo_nomina.setValue(NominaPeriodoEditar.main.OBJ.co_grupo_nomina);
		}
	});

}

this.co_nom_frecuencia_pago = new Ext.form.ComboBox({
	fieldLabel:'Frecuencia de Pago',
	store: this.storeCO_NOM_FRECUENCIA_PAGO,
	typeAhead: true,
	valueField: 'co_nom_frecuencia_pago',
	displayField:'tx_nom_frecuencia_pago',
	hiddenName:'tbrh013_nomina[co_nom_frecuencia_pago]',
	//readOnly:(this.OBJ.co_nom_frecuencia_pago!='')?true:false,
	//style:(this.main.OBJ.co_nom_frecuencia_pago!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Frecuencia...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeCO_NOM_FRECUENCIA_PAGO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_nom_frecuencia_pago,
	value:  this.OBJ.co_nom_frecuencia_pago,
	objStore: this.storeCO_NOM_FRECUENCIA_PAGO
});

this.de_observacion = new Ext.form.TextArea({
	fieldLabel:'Observacion',
	name:'tbrh013_nomina[de_observacion]',
	value:this.OBJ.de_observacion,
	allowBlank:false,
	width:400
});

this.fe_inicio = new Ext.form.DateField({
	fieldLabel:'Fecha Inicio',
	name:'tbrh013_nomina[fe_inicio]',
	value:this.OBJ.fe_inicio,
	allowBlank:false,
	width:100
});

this.fe_fin = new Ext.form.DateField({
	fieldLabel:'Fecha Cierre',
	name:'tbrh013_nomina[fe_fin]',
	value:this.OBJ.fe_fin,
	allowBlank:false,
	width:100
});

this.fe_pago = new Ext.form.DateField({
	fieldLabel:'Fecha de Pago',
	name:'tbrh013_nomina[fe_pago]',
	value:this.OBJ.fe_pago,
	allowBlank:false,
	width:100
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

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!NominaPeriodoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        NominaPeriodoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/guardar',
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
                 NominaPeriodoLista.main.store_lista.load();
                 NominaPeriodoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        NominaPeriodoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
	labelWidth: 150,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_nomina,
                    this.co_solicitud,
                    this.co_tp_nomina,
					this.co_grupo_nomina,
                    this.co_nom_frecuencia_pago,
                    this.fe_inicio,
                    this.fe_fin,
                    this.fe_pago,
					this.de_observacion,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Nomina Periodo',
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
NominaPeriodoLista.main.mascara.hide();
}
,getStoreCO_TP_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/storefkcotpnomina',
        root:'data',
        fields:[
            {name: 'co_tp_nomina'},{name: 'tx_tp_nomina'},
			{
				name: 'nomina',
				convert: function(v, r) {
						return r.nu_nomina + ' - ' + r.tx_tp_nomina;
				}
		    }
            ]
    });
    return this.store;
}
,getStoreCO_NOM_FRECUENCIA_PAGO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/storefkconomfrecuenciapago',
        root:'data',
        fields:[
            {name: 'co_nom_frecuencia_pago'},{name: 'tx_nom_frecuencia_pago'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/storefkidtbrh060nominaestatus',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
},
getStoreCO_GRUPO_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoTipo/storefkcogruponomina',
        root:'data',
        fields:[
            {name: 'co_grupo_nomina'},
            {name: 'cod_grupo_nomina'},
            {name: 'tx_grupo_nomina'},
            {
				name: 'grupo',
				convert: function(v, r) {
						return r.cod_grupo_nomina + ' - ' + r.tx_grupo_nomina;
				}
		    }
            ]
    });
    return this.store;
}
};
Ext.onReady(NominaPeriodoEditar.main.init, NominaPeriodoEditar.main);
</script>
