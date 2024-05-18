<script type="text/javascript">
Ext.ns("PlandecuentaEditar");
PlandecuentaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.storeCO_TIPO_CUENTA = this.getStoreCO_TIPO_CUENTA();

//<ClavePrimaria>
this.co_partida_presupuestaria = new Ext.form.Hidden({
    name:'co_partida_presupuestaria',
    value:this.OBJ.co_partida_presupuestaria});
//</ClavePrimaria>

this.tx_prefijo = new Ext.form.TextField({
	fieldLabel:'Cuenta Prefijo:',
	name:'tb009_partida_presupuestaria[tx_prefijo]',
        readOnly:true,
	style:'background:#c9c9c9;',
	value:this.OBJ.tx_prefijo,
	allowBlank:false,
	width:100
});

this.tx_codigo_cuenta = new Ext.form.NumberField({
	fieldLabel:'Cuenta',
	name:'tb009_partida_presupuestaria[tx_codigo_cuenta]',
	value:this.OBJ.tx_codigo_cuenta,
        readOnly:(this.OBJ.tx_codigo_cuenta!='')?true:false,
	style:(this.OBJ.tx_codigo_cuenta!='')?'background:#c9c9c9;':'',
	allowBlank:false,
	width:30
});

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Denominación',
	name:'tb009_partida_presupuestaria[tx_descripcion]',
	value:this.OBJ.tx_descripcion,
	allowBlank:false,
	width:550
});

this.tx_tipo = new Ext.form.ComboBox({
	fieldLabel:'Tipo',
	store: this.storeCO_TIPO_CUENTA,
	typeAhead: true,
	valueField: 'tx_sigla',
	displayField:'tx_tipo_partida_presupuestaria',
	hiddenName:'tb009_partida_presupuestaria[tx_tipo]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_CUENTA.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.tx_tipo,
	value:  this.OBJ.tx_tipo,
	objStore: this.storeCO_TIPO_CUENTA
});

this.co_tipo = new Ext.form.NumberField({
	fieldLabel:'Nivel',
	name:'tb009_partida_presupuestaria[co_tipo]',
	value:this.OBJ.co_tipo,
        width:30,
        readOnly:true,
	style:'background:#c9c9c9;',
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PlandecuentaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PlandecuentaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Plandecuenta/guardar',
            waitMsg: 'Enviando datos, por favor espere..',
            waitTitle:'Enviando',
            failure: function(form, action) {
                Ext.MessageBox.alert('Error en transacción', action.result.msg);
            },
            success: function(form, action) {
                 if(action.result.success){
                     Ext.utiles.msg('Mensaje', action.result.msg);
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
                 PlandecuentaLista.main.store_lista.load();
                 PlandecuentaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PlandecuentaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:700,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[         this.co_partida_presupuestaria,
                    this.tx_prefijo,
                    this.tx_codigo_cuenta,
                    this.tx_descripcion,                    
                    this.co_tipo,
                    this.tx_tipo
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Plandecuenta',
    modal:true,
    constrain:true,
    width:700,
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
PlandecuentaLista.main.mascara.hide();
},getStoreCO_TIPO_CUENTA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Plandecuenta/storefkcotipocuenta',
        root:'data',
        fields:[
            {name: 'co_partida_presupuestaria'},
            {name: 'tx_tipo_partida_presupuestaria'},
            {name: 'tx_sigla'}
            ]
    });
    return this.store;
}
};
Ext.onReady(PlandecuentaEditar.main.init, PlandecuentaEditar.main);
</script>
