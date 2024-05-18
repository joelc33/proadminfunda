<script type="text/javascript">
Ext.ns("ActividadEditar");
ActividadEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_actividad = new Ext.form.Hidden({
    name:'co_actividad',
    value:this.OBJ.co_actividad});
//</ClavePrimaria>

this.co_programa = new Ext.form.Hidden({
    name:'tb020_actividad[co_programa]',
    value:this.OBJ.co_programa});

this.tx_actividad = new Ext.form.TextField({
	fieldLabel:'Código',
	name:'tb020_actividad[tx_actividad]',
	value:this.OBJ.tx_actividad,
	allowBlank:false,
	width:100
});

this.tx_denominacion_act = new Ext.form.TextField({
	fieldLabel:'Descripción',
	name:'tb020_actividad[tx_denominacion_act]',
	value:this.OBJ.tx_denominacion_act,
	allowBlank:false,
	width:500
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ActividadEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ActividadEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Actividad/guardar',
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
                 ActividadLista.main.store_lista.load({
                    params:{
                        co_programa:ActividadEditar.main.OBJ.co_programa
                    }
                 });
                 ActividadEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ActividadEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:700,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_actividad,
                    this.co_programa,
                    this.tx_actividad,
                    this.tx_denominacion_act,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Actividad',
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
ActividadLista.main.mascara.hide();
}
};
Ext.onReady(ActividadEditar.main.init, ActividadEditar.main);
</script>
