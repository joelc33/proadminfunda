<script type="text/javascript">
Ext.ns("DescripcionCuentaEditar");
DescripcionCuentaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_descripcion_cuenta = new Ext.form.Hidden({
    name:'co_descripcion_cuenta',
    value:this.OBJ.co_descripcion_cuenta});
//</ClavePrimaria>


this.tx_descripcion_cuenta = new Ext.form.TextField({
	fieldLabel:'Descripcion Cuenta',
	name:'tb014_descripcion_cuenta[tx_descripcion_cuenta]',
	value:this.OBJ.tx_descripcion_cuenta,
	allowBlank:false,
	width:300
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'Activo',
	name:'tb014_descripcion_cuenta[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!DescripcionCuentaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        DescripcionCuentaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/DescripcionCuenta/guardar',
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
                 DescripcionCuentaLista.main.store_lista.load();
                 DescripcionCuentaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        DescripcionCuentaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:500,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_descripcion_cuenta,
                    this.tx_descripcion_cuenta,
                    this.in_activo,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Descripcion Cuenta Bancaria',
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
DescripcionCuentaLista.main.mascara.hide();
}
};
Ext.onReady(DescripcionCuentaEditar.main.init, DescripcionCuentaEditar.main);
</script>
