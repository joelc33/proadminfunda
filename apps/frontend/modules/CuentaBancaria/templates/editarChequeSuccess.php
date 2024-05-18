<script type="text/javascript">
Ext.ns("ChequeEditarIndividual");
ChequeEditarIndividual.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_cheque = new Ext.form.Hidden({
    name:'co_cheque',
    value:this.OBJ.co_cheque
});
//</ClavePrimaria>

this.co_chequera = new Ext.form.Hidden({
    name:'tb077_cheque[co_chequera]',
    value:this.OBJ.co_chequera
});

this.nb_titular = new Ext.form.TextField({
	fieldLabel:'Titular',
	name:'tb077_cheque[nb_titular]',
	value:this.OBJ.nb_titular,
	allowBlank:false,
	width:200
});

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'N° Cheque',
	name:'tb077_cheque[tx_descripcion]',
	value:this.OBJ.tx_descripcion,
	allowBlank:false,
	width:200
});

this.mo_cheque = new Ext.form.NumberField({
	fieldLabel:'Monto de Cheque',
	name:'tb077_cheque[mo_cheque]',
	value:this.OBJ.mo_cheque,
	allowBlank:false,
	width:200
});

this.fe_pago = new Ext.form.DateField({
	fieldLabel:'Fecha de Pago',
	name:'tb077_cheque[fe_pago]',
	value:this.OBJ.fe_pago,
	allowBlank:false,
	width:100
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ChequeEditarIndividual.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ChequeEditarIndividual.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/guardarCheque',
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
                 ChequeEditarIndividual.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ChequeEditarIndividual.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    labelWidth: 110,
    items:[
		this.co_cheque,
		this.co_chequera,
        this.nb_titular,
		this.tx_descripcion,
        this.mo_cheque,
        this.fe_pago
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Cheque',
    modal:true,
    constrain:true,
width:414,
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
};
Ext.onReady(ChequeEditarIndividual.main.init, ChequeEditarIndividual.main);
</script>
