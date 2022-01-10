<script type="text/javascript">
Ext.ns("ConceptoNominaTipoCargoEditar");
ConceptoNominaTipoCargoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_TP_CARGO = this.getStoreCO_TP_CARGO();
//<Stores de fk>

//<ClavePrimaria>
this.co_concepto_tipo_cargo = new Ext.form.Hidden({
    name:'co_concepto_tipo_cargo',
    value:this.OBJ.co_concepto_tipo_cargo});
//</ClavePrimaria>


//<ClavePrimaria>
this.co_concepto = new Ext.form.Hidden({
    name:'tbrh085_concepto_tipo_cargo[co_concepto]',
    value:this.OBJ.co_concepto});
//</ClavePrimaria>

this.co_tp_cargo = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Cargo',
	store: this.storeCO_TP_CARGO,
	typeAhead: true,
	valueField: 'co_tp_cargo',
	displayField:'tx_tipo_cargo',
	hiddenName:'tbrh085_concepto_tipo_cargo[co_tp_cargo]',
	//readOnly:(this.OBJ.co_tp_cargo!='')?true:false,
	//style:(this.main.OBJ.co_tp_cargo!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Tipo de Cargo',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TP_CARGO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tp_cargo,
	value:  this.OBJ.co_tp_cargo,
	objStore: this.storeCO_TP_CARGO
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConceptoNominaTipoCargoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConceptoNominaTipoCargoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaTipoCargo/guardar',
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
                 ConceptoNominaTipoCargoLista.main.store_lista.load();
                 ConceptoNominaTipoCargoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConceptoNominaTipoCargoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_concepto_tipo_cargo,
                    this.co_concepto,
                    this.co_tp_cargo,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: ConceptoNomina Tipo Cargo',
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
ConceptoNominaTipoCargoLista.main.mascara.hide();
}
,getStoreCO_TP_CARGO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaTipoCargo/storefkcotpcargo',
        root:'data',
        fields:[
            {name: 'co_tp_cargo'},
            {name: 'tx_tipo_cargo'}
            ]
    });
    return this.store;
}
};
Ext.onReady(ConceptoNominaTipoCargoEditar.main.init, ConceptoNominaTipoCargoEditar.main);
</script>
