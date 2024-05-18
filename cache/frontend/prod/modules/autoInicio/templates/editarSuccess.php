<script type="text/javascript">
Ext.ns("inicioEditar");
inicioEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_menu = new Ext.form.Hidden({
    name:'co_menu',
    value:this.OBJ.co_menu});
//</ClavePrimaria>


this.tx_menu = new Ext.form.TextField({
	fieldLabel:'Tx menu',
	name:'tb004_menu[tx_menu]',
	value:this.OBJ.tx_menu,
	allowBlank:false,
	width:200
});

this.co_padre = new Ext.form.NumberField({
	fieldLabel:'Co padre',
	name:'tb004_menu[co_padre]',
	value:this.OBJ.co_padre,
	allowBlank:false
});

this.tx_href = new Ext.form.TextField({
	fieldLabel:'Tx href',
	name:'tb004_menu[tx_href]',
	value:this.OBJ.tx_href,
	allowBlank:false,
	width:200
});

this.nu_orden = new Ext.form.NumberField({
	fieldLabel:'Nu orden',
	name:'tb004_menu[nu_orden]',
	value:this.OBJ.nu_orden,
	allowBlank:false
});

this.tx_icono = new Ext.form.TextField({
	fieldLabel:'Tx icono',
	name:'tb004_menu[tx_icono]',
	value:this.OBJ.tx_icono,
	allowBlank:false,
	width:200
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!inicioEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        inicioEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/inicio/guardar',
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
                 inicioLista.main.store_lista.load();
                 inicioEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        inicioEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_menu,
                    this.tx_menu,
                    this.co_padre,
                    this.tx_href,
                    this.nu_orden,
                    this.tx_icono,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: inicio',
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
inicioLista.main.mascara.hide();
}
};
Ext.onReady(inicioEditar.main.init, inicioEditar.main);
</script>
