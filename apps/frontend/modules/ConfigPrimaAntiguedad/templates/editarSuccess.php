<script type="text/javascript">
Ext.ns("ConfigPrimaAntiguedadEditar");
ConfigPrimaAntiguedadEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_TP_NOMINA = this.getStoreCO_TP_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_GRUPO_NOMINA = this.getStoreCO_GRUPO_NOMINA();
//<Stores de fk>

//<ClavePrimaria>
this.co_prima_antiguedad = new Ext.form.Hidden({
    name:'co_prima_antiguedad',
    value:this.OBJ.co_prima_antiguedad});
//</ClavePrimaria>


this.co_tp_nomina = new Ext.form.ComboBox({
	fieldLabel:'Tipo de nomina',
	store: this.storeCO_TP_NOMINA,
	typeAhead: true,
	valueField: 'co_tp_nomina',
	displayField:'nomina',
	hiddenName:'tbrh070_prima_antiguedad[co_tp_nomina]',
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
			ConfigPrimaAntiguedadEditar.main.co_grupo_nomina.clearValue();
			ConfigPrimaAntiguedadEditar.main.storeCO_GRUPO_NOMINA.load({
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
	hiddenName:'tbrh070_prima_antiguedad[co_grupo_nomina]',
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
			ConfigPrimaAntiguedadEditar.main.co_grupo_nomina.setValue(ConfigPrimaAntiguedadEditar.main.OBJ.co_grupo_nomina);
		}
	});

}

this.nu_anio = new Ext.form.NumberField({
	fieldLabel:'Años',
	name:'tbrh070_prima_antiguedad[nu_anio]',
	value:this.OBJ.nu_anio,
	allowBlank:false,
	width:100
});

this.nu_porcentaje = new Ext.form.NumberField({
	fieldLabel:'Porcentaje',
	name:'tbrh070_prima_antiguedad[nu_porcentaje]',
	value:this.OBJ.nu_porcentaje,
	allowBlank:false,
	width:100
});

this.de_condicional = new Ext.form.ComboBox({
    fieldLabel : 'Condicional',
    displayField:'de_condicional',
    typeAhead: true,
    store:new Ext.data.SimpleStore({
        data : [[1, '>'],[2, '<'],[3, '='],[4, '>='],[5, '<=']],
        fields : ['co_condicional', 'de_condicional']
    }),
    valueField: 'de_condicional',
    forceSelection:true,
    hiddenName:'tbrh070_prima_antiguedad[de_condicional]',
    name: 'de_condicional',
    triggerAction: 'all',
    selectOnFocus:true,
    mode:'local',
    width:100
});

this.de_condicional.setValue(this.OBJ.de_condicional);

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConfigPrimaAntiguedadEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfigPrimaAntiguedadEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaAntiguedad/guardar',
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
                 ConfigPrimaAntiguedadLista.main.store_lista.load();
                 ConfigPrimaAntiguedadEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigPrimaAntiguedadEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:500,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_prima_antiguedad,
                    this.co_tp_nomina,
                    this.co_grupo_nomina,
                    this.nu_anio,
                    this.nu_porcentaje,
                    this.de_condicional
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Configuracion Prima Antiguedad',
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
ConfigPrimaAntiguedadLista.main.mascara.hide();
}
,getStoreCO_TP_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaAntiguedad/storefkcotpnomina',
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
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaAntiguedad/storefkcogruponomina',
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
};
Ext.onReady(ConfigPrimaAntiguedadEditar.main.init, ConfigPrimaAntiguedadEditar.main);
</script>
