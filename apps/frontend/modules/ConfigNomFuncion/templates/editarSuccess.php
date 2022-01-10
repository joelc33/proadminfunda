<script type="text/javascript">
Ext.ns("ConfigNomFuncionEditar");
ConfigNomFuncionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_TP_FUNCION = this.getStoreCO_TP_FUNCION();
//<Stores de fk>

//<ClavePrimaria>
this.co_nom_funcion = new Ext.form.Hidden({
    name:'co_nom_funcion',
    value:this.OBJ.co_nom_funcion});
//</ClavePrimaria>


this.tx_nom_funcion = new Ext.form.TextField({
	fieldLabel:'Variable/Funcion',
	name:'tbrh035_nom_funcion[tx_nom_funcion]',
	value:this.OBJ.tx_nom_funcion,
	allowBlank:false,
	width:400
});

this.tx_nom_descripcion = new Ext.form.TextArea({
	fieldLabel:'Descripcion',
	name:'tbrh035_nom_funcion[tx_nom_descripcion]',
	value:this.OBJ.tx_nom_descripcion,
	allowBlank:false,
	width:400
});

this.tx_nom_parametro = new Ext.form.TextField({
	fieldLabel:'Parametros',
	name:'tbrh035_nom_funcion[tx_nom_parametro]',
	value:this.OBJ.tx_nom_parametro,
	//allowBlank:false,
	width:400
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tbrh035_nom_funcion[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tbrh035_nom_funcion[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tbrh035_nom_funcion[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.co_tp_funcion = new Ext.form.ComboBox({
	fieldLabel:'Tipo',
	store: this.storeCO_TP_FUNCION,
	typeAhead: true,
	valueField: 'co_tp_funcion',
	displayField:'tx_tp_funcion',
	hiddenName:'tbrh035_nom_funcion[co_tp_funcion]',
	//readOnly:(this.OBJ.co_tp_funcion!='')?true:false,
	//style:(this.main.OBJ.co_tp_funcion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Tipo',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TP_FUNCION.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tp_funcion,
	value:  this.OBJ.co_tp_funcion,
	objStore: this.storeCO_TP_FUNCION
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConfigNomFuncionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfigNomFuncionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigNomFuncion/guardar',
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
                 ConfigNomFuncionLista.main.store_lista.load();
                 ConfigNomFuncionEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigNomFuncionEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
        this.co_tp_funcion,
                    this.co_nom_funcion,
                    this.tx_nom_funcion,
                    this.tx_nom_descripcion,
                    this.tx_nom_parametro,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Config Nom Funcion',
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
ConfigNomFuncionLista.main.mascara.hide();
}
,getStoreCO_TP_FUNCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigNomFuncion/storefkcotpfuncion',
        root:'data',
        fields:[
            {name: 'co_tp_funcion'},
            {name: 'tx_tp_funcion'}
            ]
    });
    return this.store;
}
};
Ext.onReady(ConfigNomFuncionEditar.main.init, ConfigNomFuncionEditar.main);
</script>
