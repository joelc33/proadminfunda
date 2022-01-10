<script type="text/javascript">
Ext.ns("ConfigPetroEditar");
ConfigPetroEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.mo_petro = new Ext.form.NumberField({
	fieldLabel:'Mo petro',
	name:'tbrh097_petro[mo_petro]',
	value:this.OBJ.mo_petro,
	allowBlank:false
});

this.fe_ini = new Ext.form.DateField({
	fieldLabel:'Fe ini',
	name:'tbrh097_petro[fe_ini]',
	value:this.OBJ.fe_ini,
	allowBlank:false,
	width:100
});

this.fe_fin = new Ext.form.DateField({
	fieldLabel:'Fe fin',
	name:'tbrh097_petro[fe_fin]',
	value:this.OBJ.fe_fin,
	allowBlank:false,
	width:100
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tbrh097_petro[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tbrh097_petro[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tbrh097_petro[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConfigPetroEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfigPetroEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigPetro/guardar',
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
                 ConfigPetroLista.main.store_lista.load();
                 ConfigPetroEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigPetroEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
                    this.mo_petro,
                    this.fe_ini,
                    this.fe_fin,
                    this.in_activo,
                    this.created_at,
                    this.updated_at,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: ConfigPetro',
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
ConfigPetroLista.main.mascara.hide();
}
};
Ext.onReady(ConfigPetroEditar.main.init, ConfigPetroEditar.main);
</script>
