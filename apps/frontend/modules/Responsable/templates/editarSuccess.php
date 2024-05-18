<script type="text/javascript">
Ext.ns("ResponsableEditar");
ResponsableEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'tbbn010_responsables[co_responsables]',
    value:this.OBJ.co_responsables});
//</ClavePrimaria>
this.storeEstatus=new Ext.data.SimpleStore({
                        data : [[1, 'ACTIVO'],[0, 'INACTIVO']],
                        fields : ['in_activo', 'tx_activo']
                                                       });

this.list_estatus= new Ext.form.ComboBox({
    fieldLabel:'Estatus',
    store:this.storeEstatus,
    typeAhead: true,
    valueField: 'in_activo',
    displayField:'tx_activo',
    hiddenName:'tbbn010_responsables[in_activo]',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Estatus',
    selectOnFocus: true,
    mode: 'local',
    width:400,
    resizable:true,
    allowBlank:false,
});
if(this.OBJ.in_activo){
    ResponsableEditar.main.list_estatus.setValue(true);
}else if(this.OBJ.in_activo===false){
    ResponsableEditar.main.list_estatus.setValue(false);
}                                       
this.tx_nombres = new Ext.form.TextField({
	fieldLabel:'Nombres',
	name:'tbbn010_responsables[tx_nombres]',
	value:this.OBJ.tx_nombres,
	allowBlank:false,
	width:400
});

this.tx_apellidos = new Ext.form.TextField({
	fieldLabel:'Apellidos',
	name:'tbbn010_responsables[tx_apellidos]',
	value:this.OBJ.tx_apellidos,
	allowBlank:false,
	width:400
});

this.nu_cedula = new Ext.form.NumberField({
	fieldLabel:'Cedula',
	name:'tbbn010_responsables[nu_cedula]',
	value:this.OBJ.nu_cedula,
	allowBlank:false,
	width:400,
    minValue : 0,
    allowDecimals : false,
    allowNegative : false,
    tooltip : ''
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ResponsableEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ResponsableEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Responsable/guardar',
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
                 ResponsableLista.main.store_lista.load();
                 ResponsableEditar.main.winformPanel_.close();
             }
        });


    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ResponsableEditar.main.winformPanel_.close();
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
                    this.nu_cedula,
                    this.tx_nombres,
                    this.tx_apellidos,
                    this.list_estatus
                    
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Responsable',
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
ResponsableLista.main.mascara.hide();
}
};
Ext.onReady(ResponsableEditar.main.init, ResponsableEditar.main);
</script>
