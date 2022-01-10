<script type="text/javascript">
Ext.ns("ConceptoNominaPagoAcumulaEditar");
ConceptoNominaPagoAcumulaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_NOM_ACUMULADO = this.getStoreCO_NOM_ACUMULADO();
//<Stores de fk>

//<ClavePrimaria>
this.co_concep_acumulado = new Ext.form.Hidden({
    name:'co_concep_acumulado',
    value:this.OBJ.co_concep_acumulado});
//</ClavePrimaria>

this.co_concepto = new Ext.form.Hidden({
    name:'tbrh034_concep_acumulado[co_concepto]',
    value:this.OBJ.co_concepto});

this.co_nom_acumulado = new Ext.form.ComboBox({
	fieldLabel:'Acumula por',
	store: this.storeCO_NOM_ACUMULADO,
	typeAhead: true,
	valueField: 'co_nom_acumulado',
	displayField:'tx_nom_acumulado',
	hiddenName:'tbrh034_concep_acumulado[co_nom_acumulado]',
	//readOnly:(this.OBJ.co_nom_acumulado!='')?true:false,
	//style:(this.main.OBJ.co_nom_acumulado!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Acumula por',
	selectOnFocus: true,
	mode: 'local',
	width:500,
	resizable:true,
	allowBlank:false
});
this.storeCO_NOM_ACUMULADO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_nom_acumulado,
	value:  this.OBJ.co_nom_acumulado,
	objStore: this.storeCO_NOM_ACUMULADO
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConceptoNominaPagoAcumulaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConceptoNominaPagoAcumulaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoAcumula/guardar',
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
                 ConceptoNominaPagoAcumulaLista.main.store_lista.load();
                 ConceptoNominaPagoAcumulaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConceptoNominaPagoAcumulaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:670,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_concep_acumulado,
                    this.co_concepto,
                    this.co_nom_acumulado,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Concepto Nomina Pago Acumula',
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
ConceptoNominaPagoAcumulaLista.main.mascara.hide();
}
,getStoreCO_NOM_ACUMULADO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoAcumula/storefkconomacumulado',
        root:'data',
        fields:[
            {name: 'co_nom_acumulado'},
            {name: 'tx_nom_acumulado'}
            ]
    });
    return this.store;
}
};
Ext.onReady(ConceptoNominaPagoAcumulaEditar.main.init, ConceptoNominaPagoAcumulaEditar.main);
</script>
