<script type="text/javascript">
Ext.ns("ConceptoNominaPagoEditar");
ConceptoNominaPagoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_concepto = new Ext.form.Hidden({
    name:'co_concepto',
    value:this.OBJ.co_concepto});
//</ClavePrimaria>


this.nu_concepto = new Ext.form.TextField({
	fieldLabel:'Codigo',
	name:'tbrh014_concepto[nu_concepto]',
	value:this.OBJ.nu_concepto,
	allowBlank:false,
	width:200
});

this.tx_concepto = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tbrh014_concepto[tx_concepto]',
	value:this.OBJ.tx_concepto,
	allowBlank:false,
	width:500
});

this.guardar = new Ext.Button({
    text:'Dupicar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConceptoNominaPagoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConceptoNominaPagoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/guardarDuplicar',
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
                 ConceptoNominaPagoLista.main.store_lista.load();
                 ConceptoNominaPagoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConceptoNominaPagoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:700,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_concepto,
                    this.nu_concepto,
                    this.tx_concepto,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Dupicar Concepto',
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
ConceptoNominaPagoLista.main.mascara.hide();
}
};
Ext.onReady(ConceptoNominaPagoEditar.main.init, ConceptoNominaPagoEditar.main);
</script>
