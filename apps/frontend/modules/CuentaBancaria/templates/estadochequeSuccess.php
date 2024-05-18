<script type="text/javascript">
Ext.ns("estadoEditar");
estadoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_ESTADO = this.getStoreCO_ESTADO();
//<Stores de fk>
//<Stores de fk>

//<ClavePrimaria>
this.co_cheque = new Ext.form.Hidden({
    name:'co_cheque',
    value:this.OBJ.co_cheque});



this.co_estado_cheque = new Ext.form.ComboBox({
	fieldLabel:'Estado',
	store: this.storeCO_ESTADO,
	typeAhead: true,
	valueField: 'co_estado_cheque',
	displayField:'tx_estado_cheque',
	hiddenName:'co_estado_cheque',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Estado',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	allowBlank:false
});
this.storeCO_ESTADO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_estado_cheque,
	value:  this.OBJ.co_estado_cheque,
	objStore: this.storeCO_ESTADO
});

this.tx_observacion = new Ext.form.TextArea({
	fieldLabel:'Observacion',
	name:'tx_observacion',
        width:500,
	allowBlank:false
});

this.fielset2 = new Ext.form.FieldSet({
              title:'Datos del Estado',width:670,
              items:[ 
		this.co_estado_cheque,
                this.tx_observacion
]});



this.guardar = new Ext.Button({
    text:'Procesar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!estadoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        estadoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/guardarestadocheque',
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
                 
                 ChequeEditar.main.store_lista.load();
                 ChequeEditar.main.estado.disable();
                 estadoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
    handler:function(){
        estadoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    width:700,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_cheque,
                    this.fielset2
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario de Cheque',
    modal:true,
    constrain:true,
    width:715,
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
ChequeEditar.main.mascara.hide();
}
,getStoreCO_ESTADO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/storefkcoestadocheque/co_estado_cheque/'+estadoEditar.main.OBJ.co_estado_cheque,
        root:'data',
        fields:[
            {name: 'co_estado_cheque'},{name: 'tx_estado_cheque'}
            ]
    });
    return this.store;
}
};
Ext.onReady(estadoEditar.main.init, estadoEditar.main);
</script>
<div id="requisito" ></div>
