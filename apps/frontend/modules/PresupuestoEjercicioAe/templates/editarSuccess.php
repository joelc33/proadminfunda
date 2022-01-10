<script type="text/javascript">
Ext.ns("PresupuestoEjercicioAeEditar");
PresupuestoEjercicioAeEditar.main = {
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

this.id_tb165_pac_tmp = new Ext.form.Hidden({
    name:'tb166_pac_ae_tmp[id_tb165_pac_tmp]',
    value:this.OBJ.id_tb165_pac_tmp
});

this.nu_accion_especifica = new Ext.form.TextField({
	fieldLabel:'Nº A/E',
	name:'tb166_pac_ae_tmp[nu_accion_especifica]',
	value:this.OBJ.nu_accion_especifica,
	allowBlank:false,
	width:200
});

this.de_accion_especifica = new Ext.form.TextArea({
	fieldLabel:'Descripcion',
	name:'tb166_pac_ae_tmp[de_accion_especifica]',
	value:this.OBJ.de_accion_especifica,
	allowBlank:false,
	width:400
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PresupuestoEjercicioAeEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PresupuestoEjercicioAeEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAe/guardar',
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
                 PresupuestoEjercicioAeLista.main.store_lista.load();
                 PresupuestoEjercicioAeEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PresupuestoEjercicioAeEditar.main.winformPanel_.close();
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
                    this.id_tb165_pac_tmp,
                    this.nu_accion_especifica,
                    this.de_accion_especifica,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Presupuesto Ejercicio A/E',
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
PresupuestoEjercicioAeLista.main.mascara.hide();
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAe/storefkidtb165pactmp',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
};
Ext.onReady(PresupuestoEjercicioAeEditar.main.init, PresupuestoEjercicioAeEditar.main);
</script>
