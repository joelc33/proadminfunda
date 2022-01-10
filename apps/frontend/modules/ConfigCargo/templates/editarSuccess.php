<script type="text/javascript">
Ext.ns("ConfigCargoEditar");
ConfigCargoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_TP_TABULADOR = this.getStoreCO_TP_TABULADOR();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TABULADOR = this.getStoreCO_TABULADOR();
//<Stores de fk>

//<ClavePrimaria>
this.co_cargo = new Ext.form.Hidden({
    name:'co_cargo',
    value:this.OBJ.co_cargo});
//</ClavePrimaria>


this.tx_cargo = new Ext.form.TextField({
	fieldLabel:'Cargo',
	name:'tbrh032_cargo[tx_cargo]',
	value:this.OBJ.tx_cargo,
	allowBlank:false,
	width:500
});

this.co_tabulador2 = new Ext.form.NumberField({
	fieldLabel:'Co tabulador2',
	name:'tbrh032_cargo[co_tabulador2]',
	value:this.OBJ.co_tabulador2,
	allowBlank:false,
	width:200
});

this.nu_codigo = new Ext.form.TextField({
	fieldLabel:'Codigo',
	name:'tbrh032_cargo[nu_codigo]',
	value:this.OBJ.nu_codigo,
	allowBlank:false,
	width:200
});

this.co_tp_tabulador = new Ext.form.ComboBox({
	fieldLabel:'Tipo Tabulador',
	store: this.storeCO_TP_TABULADOR,
	typeAhead: true,
	valueField: 'co_tp_tabulador',
	displayField:'tx_tp_tabulador',
	hiddenName:'tbrh032_cargo[co_tp_tabulador]',
	//readOnly:(this.OBJ.co_tp_tabulador!='')?true:false,
	//style:(this.main.OBJ.co_tp_tabulador!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Tipo Tabulador',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false,
    listeners:{
		select: function(){
			ConfigCargoEditar.main.co_tabulador.clearValue();
			ConfigCargoEditar.main.storeCO_TABULADOR.load({
				params: {
					tipo:this.getValue()
				}
			})
		}
  	}
});

this.storeCO_TP_TABULADOR.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tp_tabulador,
	value:  this.OBJ.co_tp_tabulador,
	objStore: this.storeCO_TP_TABULADOR
});

this.co_tabulador = new Ext.form.ComboBox({
	fieldLabel:'Tabulador',
	store: this.storeCO_TABULADOR,
	typeAhead: true,
	valueField: 'co_tabulador',
	displayField:'tabulador',
	hiddenName:'tbrh032_cargo[co_tabulador]',
	//readOnly:(this.OBJ.co_tp_tabulador!='')?true:false,
	//style:(this.main.OBJ.co_tp_tabulador!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Tabulador',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});

if(this.OBJ.co_tp_tabulador){
  	this.storeCO_TABULADOR.load({
		params: {
			tipo:this.OBJ.co_tp_tabulador
		},
		callback: function(){
			ConfigCargoEditar.main.co_tabulador.setValue(ConfigCargoEditar.main.OBJ.co_tabulador);
		}
	});

}



/*this.storeCO_TABULADOR.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tabulador,
	value:  this.OBJ.co_tabulador,
	objStore: this.storeCO_TABULADOR
});*/

this.in_compensacion = new Ext.form.Checkbox({
	fieldLabel:'¿Aplica compensacion?',
	name:'tbrh032_cargo[in_compensacion]',
	checked:this.OBJ.in_compensacion,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConfigCargoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfigCargoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigCargo/guardar',
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
                 ConfigCargoLista.main.store_lista.load();
                 ConfigCargoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigCargoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:700,
autoHeight:true,  
labelWidth: 150,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_cargo,
                    this.tx_cargo,
                    this.nu_codigo,
                    this.co_tp_tabulador,
                    this.co_tabulador,
                    this.in_compensacion
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Cargo',
    modal:true,
    constrain:true,
width:714,
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
ConfigCargoLista.main.mascara.hide();
},
getStoreCO_TP_TABULADOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigCargo/storefkcotptabulador',
        root:'data',
        fields:[
            {name: 'co_tp_tabulador'},
            {name: 'tx_tp_tabulador'}
            ]
    });
    return this.store;
},
getStoreCO_TABULADOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigCargo/storefkcotabulador',
        root:'data',
        fields:[
            {name: 'co_tabulador'},
            {name: 'mo_sueldo'},
            {name: 'nu_codigo_tab'},
            {name: 'tabulador',
                convert:function(v,r){
                    return r.nu_codigo_tab+' - '+paqueteComunJS.funcion.getNumeroFormateado(r.mo_sueldo);
                }
            }
            ]
    });
    return this.store;
}
};
Ext.onReady(ConfigCargoEditar.main.init, ConfigCargoEditar.main);
</script>
