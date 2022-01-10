<script type="text/javascript">
Ext.ns("ConfigPrimaProfesionalizacionEditar");
ConfigPrimaProfesionalizacionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<Stores de fk>
this.storeCO_TP_NOMINA = this.getStoreCO_TP_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_GRUPO_NOMINA = this.getStoreCO_GRUPO_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_NIVEL_EDUCATIVO = this.getStoreCO_NIVEL_EDUCATIVO();
//<Stores de fk>

//<ClavePrimaria>
this.co_prima_nivel_edu = new Ext.form.Hidden({
    name:'co_prima_nivel_edu',
    value:this.OBJ.co_prima_nivel_edu});
//</ClavePrimaria>

this.co_tp_nomina = new Ext.form.ComboBox({
	fieldLabel:'Tipo de nomina',
	store: this.storeCO_TP_NOMINA,
	typeAhead: true,
	valueField: 'co_tp_nomina',
	displayField:'nomina',
	hiddenName:'tbrh094_prima_nivel_edu[co_tp_nomina]',
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
			ConfigPrimaProfesionalizacionEditar.main.co_grupo_nomina.clearValue();
			ConfigPrimaProfesionalizacionEditar.main.storeCO_GRUPO_NOMINA.load({
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
	hiddenName:'tbrh094_prima_nivel_edu[co_grupo_nomina]',
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
			ConfigPrimaProfesionalizacionEditar.main.co_grupo_nomina.setValue(ConfigPrimaProfesionalizacionEditar.main.OBJ.co_grupo_nomina);
		}
	});

}

this.co_nivel_educativo = new Ext.form.ComboBox({
	fieldLabel:'Nivel Educativo',
	store: this.storeCO_NIVEL_EDUCATIVO,
	typeAhead: true,
	valueField: 'co_nivel_educativo',
	displayField:'de_nivel_educativo',
	hiddenName:'tbrh094_prima_nivel_edu[co_nivel_educativo]',
	//readOnly:(this.OBJ.co_nivel_educativo!='')?true:false,
	//style:(this.main.OBJ.co_nivel_educativo!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Nivel Educativo',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false
});
this.storeCO_NIVEL_EDUCATIVO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_nivel_educativo,
	value:  this.OBJ.co_nivel_educativo,
	objStore: this.storeCO_NIVEL_EDUCATIVO
});

this.nu_porcentaje = new Ext.form.NumberField({
	fieldLabel:'Porcentaje',
	name:'tbrh094_prima_nivel_edu[nu_porcentaje]',
	value:this.OBJ.nu_porcentaje,
	allowBlank:false,
	width:100
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConfigPrimaProfesionalizacionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfigPrimaProfesionalizacionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaProfesionalizacion/guardar',
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
                 ConfigPrimaProfesionalizacionLista.main.store_lista.load();
                 ConfigPrimaProfesionalizacionEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigPrimaProfesionalizacionEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:500,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_prima_nivel_edu,
                    this.co_tp_nomina,
                    this.co_grupo_nomina,
                    this.co_nivel_educativo,
                    this.nu_porcentaje
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Prima Profesionalizacion',
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
ConfigPrimaProfesionalizacionLista.main.mascara.hide();
}
,getStoreCO_TP_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaProfesionalizacion/storefkcotpnomina',
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
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaProfesionalizacion/storefkcogruponomina',
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
,getStoreCO_NIVEL_EDUCATIVO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPrimaProfesionalizacion/storefkconiveleducativo',
        root:'data',
        fields:[
            {name: 'co_nivel_educativo'},
            {name: 'de_nivel_educativo'}
            ]
    });
    return this.store;
}
};
Ext.onReady(ConfigPrimaProfesionalizacionEditar.main.init, ConfigPrimaProfesionalizacionEditar.main);
</script>
