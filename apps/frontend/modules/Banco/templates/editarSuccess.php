<script type="text/javascript">
Ext.ns("BancoEditar");
BancoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_banco = new Ext.form.Hidden({
    name:'co_banco',
    value:this.OBJ.co_banco});
//</ClavePrimaria>


this.tx_banco = new Ext.form.TextField({
	fieldLabel:'Banco',
	name:'tb010_banco[tx_banco]',
	value:this.OBJ.tx_banco,
	allowBlank:false,
	width:300
});


this.in_banco_empresa = new Ext.form.TextField({
	fieldLabel:'Banco',
	name:'tb010_banco[in_banco_empresa]',
	value:this.OBJ.in_banco_empresa,
	width:300
});

this.in_banco_empresa = new Ext.form.Checkbox({
	fieldLabel:'Banco Ente?',
	name:'tb010_banco[in_banco_empresa]',
	checked:(this.OBJ.in_banco_empresa=='1') ? true:false,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!BancoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        BancoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Banco/guardar',
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
                 BancoLista.main.store_lista.load();
                 BancoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        BancoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:500,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_banco,
                    this.tx_banco,
                    this.in_banco_empresa
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Banco',
    modal:true,
    constrain:true,
    width:500,
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
BancoLista.main.mascara.hide();
}
};
Ext.onReady(BancoEditar.main.init, BancoEditar.main);
</script>
