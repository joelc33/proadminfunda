<script type="text/javascript">
Ext.ns("ConceptoNominaPagoSituacionEditar");
ConceptoNominaPagoSituacionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_NOM_SITUACION = this.getStoreCO_NOM_SITUACION();
//<Stores de fk>

//<ClavePrimaria>
this.co_concepto_situacion = new Ext.form.Hidden({
    name:'co_concepto_situacion',
    value:this.OBJ.co_concepto_situacion});
//</ClavePrimaria>

//<ClavePrimaria>
this.co_concepto = new Ext.form.Hidden({
    name:'tbrh027_concepto_situacion[co_concepto]',
    value:this.OBJ.co_concepto});
//</ClavePrimaria>

this.co_situacion = new Ext.form.ComboBox({
	fieldLabel:'Situacion del Empleado',
	store: this.storeCO_NOM_SITUACION,
	typeAhead: true,
	valueField: 'co_nom_situacion',
	displayField:'tx_nom_situacion',
	hiddenName:'tbrh027_concepto_situacion[co_situacion]',
	//readOnly:(this.OBJ.co_situacion!='')?true:false,
	//style:(this.main.OBJ.co_situacion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Situacion',
	selectOnFocus: true,
	mode: 'local',
	width:500,
	resizable:true,
	allowBlank:false
});
this.storeCO_NOM_SITUACION.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_situacion,
	value:  this.OBJ.co_situacion,
	objStore: this.storeCO_NOM_SITUACION
});


this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConceptoNominaPagoSituacionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConceptoNominaPagoSituacionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoSituacion/guardar',
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
                 ConceptoNominaPagoSituacionLista.main.store_lista.load();
                 ConceptoNominaPagoSituacionEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConceptoNominaPagoSituacionEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:680,
autoHeight:true,  
    autoScroll:true,
    labelWidth: 150,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_concepto_situacion,
                    this.co_concepto,
                    this.co_situacion,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Concepto Nomina Pago Situacion',
    modal:true,
    constrain:true,
width:694,
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
ConceptoNominaPagoSituacionLista.main.mascara.hide();
}
,getStoreCO_NOM_SITUACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoSituacion/storefkcosituacion',
        root:'data',
        fields:[
            {name: 'co_nom_situacion'},
            {name: 'tx_nom_situacion'}
            ]
    });
    return this.store;
}
};
Ext.onReady(ConceptoNominaPagoSituacionEditar.main.init, ConceptoNominaPagoSituacionEditar.main);
</script>
