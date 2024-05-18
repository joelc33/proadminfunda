<script type="text/javascript">
Ext.ns("ConfigConceptoTiempoEditar");
ConfigConceptoTiempoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_TP_NOMINA = this.getStoreCO_TP_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_GRUPO_NOMINA = this.getStoreCO_GRUPO_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CONCEPTO = this.getStoreCO_CONCEPTO();
//<Stores de fk>

//<ClavePrimaria>
this.co_concepto_tiempo = new Ext.form.Hidden({
    name:'co_concepto_tiempo',
    value:this.OBJ.co_concepto_tiempo});
//</ClavePrimaria>


this.co_tp_nomina = new Ext.form.ComboBox({
	fieldLabel:'Tipo de nomina',
	store: this.storeCO_TP_NOMINA,
	typeAhead: true,
	valueField: 'co_tp_nomina',
	displayField:'nomina',
	hiddenName:'tbrh098_concepto_tiempo[co_tp_nomina]',
	//readOnly:(this.OBJ.co_tp_nomina!='')?true:false,
	//style:(this.main.OBJ.co_tp_nomina!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Tipo',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false,
    listeners:{
		select: function(){
			ConfigConceptoTiempoEditar.main.co_grupo_nomina.clearValue();
			ConfigConceptoTiempoEditar.main.storeCO_GRUPO_NOMINA.load({
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
	fieldLabel:'Grupo de nomina',
	store: this.storeCO_GRUPO_NOMINA,
	typeAhead: true,
	valueField: 'co_grupo_nomina',
	displayField:'cod_grupo_nomina',
	hiddenName:'tbrh098_concepto_tiempo[co_grupo_nomina]',
	//readOnly:(this.OBJ.co_grupo_nomina!='')?true:false,
	//style:(this.main.OBJ.co_grupo_nomina!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Grupo',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false
});
/*this.storeCO_GRUPO_NOMINA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_grupo_nomina,
	value:  this.OBJ.co_grupo_nomina,
	objStore: this.storeCO_GRUPO_NOMINA
});*/
if(this.OBJ.co_tp_nomina){
  	this.storeCO_GRUPO_NOMINA.load({
		params: {
			tipo:this.OBJ.co_tp_nomina
		},
		callback: function(){
			ConfigConceptoTiempoEditar.main.co_grupo_nomina.setValue(ConfigConceptoTiempoEditar.main.OBJ.co_grupo_nomina);
		}
	});

}

this.nu_mes_ini = new Ext.form.NumberField({
	fieldLabel:'Cantidad Inicial (Mes)',
	name:'tbrh098_concepto_tiempo[nu_mes_ini]',
	value:this.OBJ.nu_mes_ini,
	allowBlank:false,
	width:100
});

this.nu_mes_fin = new Ext.form.NumberField({
	fieldLabel:'Cantidad Final (Mes)',
	name:'tbrh098_concepto_tiempo[nu_mes_fin]',
	value:this.OBJ.nu_mes_fin,
	allowBlank:false,
	width:100
});

this.nu_concepto = new Ext.form.Hidden({
    name:'tbrh098_concepto_tiempo[nu_concepto]',
    value:this.OBJ.nu_concepto});

this.co_concepto = new Ext.form.ComboBox({
	fieldLabel:'Concepto',
	store: this.storeCO_CONCEPTO,
	typeAhead: true,
	valueField: 'co_concepto',
	displayField:'concepto',
	hiddenName:'tbrh098_concepto_tiempo[co_concepto]',
	//readOnly:(this.OBJ.co_concepto!='')?true:false,
	//style:(this.main.OBJ.co_concepto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Concepto',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false,
    onSelect: function(record){
        ConfigConceptoTiempoEditar.main.nu_concepto.setValue(record.data.nu_concepto);
        ConfigConceptoTiempoEditar.main.co_concepto.setValue(record.data.co_concepto);
        this.collapse();
    }
});
this.storeCO_CONCEPTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_concepto,
	value:  this.OBJ.co_concepto,
	objStore: this.storeCO_CONCEPTO
});

this.nu_valor = new Ext.form.NumberField({
	fieldLabel:'Valor / Monto',
	name:'tbrh098_concepto_tiempo[nu_valor]',
	value:this.OBJ.nu_valor,
	allowBlank:false,
	width:200
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConfigConceptoTiempoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfigConceptoTiempoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoTiempo/guardar',
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
                 ConfigConceptoTiempoLista.main.store_lista.load();
                 ConfigConceptoTiempoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigConceptoTiempoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
	labelWidth: 150,
    width:500,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_concepto_tiempo,
                    this.co_tp_nomina,
                    this.co_grupo_nomina,
                    this.co_concepto,
                    this.nu_mes_ini,
					this.nu_mes_fin,
                    this.nu_concepto,
                    this.nu_valor,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Config Concepto Tiempo',
    modal:true,
    constrain:true,
width:514,
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
ConfigConceptoTiempoLista.main.mascara.hide();
}
,getStoreCO_TP_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoTiempo/storefkcotpnomina',
        root:'data',
        fields:[
            {name: 'co_tp_nomina'},
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
,getStoreCO_GRUPO_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoTiempo/storefkcogruponomina',
        root:'data',
        fields:[
            {name: 'co_grupo_nomina'},
            {name: 'cod_grupo_nomina'},
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
,getStoreCO_CONCEPTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoTiempo/storefkcoconcepto',
        root:'data',
        fields:[
            {name: 'co_concepto'},
            {name: 'nu_concepto'},
            {name: 'tx_concepto'},
            {
				name: 'concepto',
				convert: function(v, r) {
						return r.nu_concepto + ' - ' + r.tx_concepto;
				}
		    }
            ]
    });
    return this.store;
}
};
Ext.onReady(ConfigConceptoTiempoEditar.main.init, ConfigConceptoTiempoEditar.main);
</script>
