<script type="text/javascript">
Ext.ns("ConceptoNominaPagoFrecuenciaEditar");
ConceptoNominaPagoFrecuenciaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_NOM_FRECUENCIA_PAGO = this.getStoreCO_NOM_FRECUENCIA_PAGO();
//<Stores de fk>

//<ClavePrimaria>
this.co_concep_frecuecia = new Ext.form.Hidden({
    name:'co_concep_frecuecia',
    value:this.OBJ.co_concep_frecuecia});
//</ClavePrimaria>

//<ClavePrimaria>
this.co_concepto = new Ext.form.Hidden({
    name:'tbrh051_concep_frecuecia[co_concepto]',
    value:this.OBJ.co_concepto});
//</ClavePrimaria>

this.co_nom_frecuencia_pago = new Ext.form.ComboBox({
	fieldLabel:'Frecuencia de Pago',
	store: this.storeCO_NOM_FRECUENCIA_PAGO,
	typeAhead: true,
	valueField: 'co_nom_frecuencia_pago',
	displayField:'tx_nom_frecuencia_pago',
	hiddenName:'tbrh051_concep_frecuecia[co_nom_frecuencia_pago]',
	//readOnly:(this.OBJ.co_nom_frecuencia_pago!='')?true:false,
	//style:(this.main.OBJ.co_nom_frecuencia_pago!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Frecuencia de Pago',
	selectOnFocus: true,
	mode: 'local',
	width:500,
	resizable:true,
	allowBlank:false
});
this.storeCO_NOM_FRECUENCIA_PAGO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_nom_frecuencia_pago,
	value:  this.OBJ.co_nom_frecuencia_pago,
	objStore: this.storeCO_NOM_FRECUENCIA_PAGO
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConceptoNominaPagoFrecuenciaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConceptoNominaPagoFrecuenciaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoFrecuencia/guardar',
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
                 ConceptoNominaPagoFrecuenciaLista.main.store_lista.load();
                 ConceptoNominaPagoFrecuenciaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConceptoNominaPagoFrecuenciaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:670,
autoHeight:true,  
    autoScroll:true,
    labelWidth: 120,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_concep_frecuecia,
                    this.co_concepto,
                    this.co_nom_frecuencia_pago,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Concepto Nomina Pago Frecuencia',
    modal:true,
    constrain:true,
width:684,
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
ConceptoNominaPagoFrecuenciaLista.main.mascara.hide();
}
,getStoreCO_NOM_FRECUENCIA_PAGO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoFrecuencia/storefkconomfrecuenciapago',
        root:'data',
        fields:[
            {name: 'co_nom_frecuencia_pago'},
            {name: 'tx_nom_frecuencia_pago'}
            ]
    });
    return this.store;
}
};
Ext.onReady(ConceptoNominaPagoFrecuenciaEditar.main.init, ConceptoNominaPagoFrecuenciaEditar.main);
</script>
