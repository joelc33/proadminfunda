<script type="text/javascript">
Ext.ns("EjecutorEditar");
EjecutorEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.nu_ejecutor = new Ext.form.TextField({
	fieldLabel:'Codigo',
	name:'tb082_ejecutor[nu_ejecutor]',
	value:this.OBJ.nu_ejecutor,
	allowBlank:false,
	width:200
});

this.de_ejecutor = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tb082_ejecutor[de_ejecutor]',
	value:this.OBJ.de_ejecutor,
	allowBlank:false,
	width:400
});

this.tx_sigla = new Ext.form.TextField({
	fieldLabel:'Siglas',
	name:'tb082_ejecutor[tx_sigla]',
	value:this.OBJ.tx_sigla,
	//allowBlank:false,
	width:200
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!EjecutorEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        EjecutorEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ejecutor/guardar',
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
                 EjecutorLista.main.store_lista.load();
                 EjecutorEditar.main.winformPanel_.close();
             }
        });


    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        EjecutorEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
autoHeight:true,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
                    this.nu_ejecutor,
                    this.de_ejecutor,
                    this.tx_sigla
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Ejecutor',
    modal:true,
    constrain:true,
width:614,
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
EjecutorLista.main.mascara.hide();
}
};
Ext.onReady(EjecutorEditar.main.init, EjecutorEditar.main);
</script>
