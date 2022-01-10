<script type="text/javascript">
Ext.ns("AccionespecificaEditar");
AccionespecificaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>

this.id_tb083_proyecto_ac = new Ext.form.Hidden({
    name:'tb084_accion_especifica[id_tb083_proyecto_ac]',
    value:this.OBJ.id_tb083_proyecto_ac
});

this.nu_accion_especifica = new Ext.form.TextField({
	fieldLabel:'Codigo',
	name:'tb084_accion_especifica[nu_accion_especifica]',
	value:this.OBJ.nu_accion_especifica,
	allowBlank:false,
	width:100
});

this.de_accion_especifica = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tb084_accion_especifica[de_accion_especifica]',
	value:this.OBJ.de_accion_especifica,
	allowBlank:false,
	width:400
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tb084_accion_especifica[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tb084_accion_especifica[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tb084_accion_especifica[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!AccionespecificaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        AccionespecificaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Accionespecifica/guardar',
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
                 AccionespecificaLista.main.store_lista.load();
                 AccionespecificaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        AccionespecificaEditar.main.winformPanel_.close();
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
                    this.id_tb083_proyecto_ac,
                    this.nu_accion_especifica,
                    this.de_accion_especifica,
                    /*this.in_activo,
                    this.created_at,
                    this.updated_at,*/
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Accion Especifica',
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
AccionespecificaLista.main.mascara.hide();
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Accionespecifica/storefkidtb083proyectoac',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
};
Ext.onReady(AccionespecificaEditar.main.init, AccionespecificaEditar.main);
</script>
