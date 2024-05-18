<script type="text/javascript">
Ext.ns("ejercicioEditar");
ejercicioEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_USUARIO = this.getStoreCO_USUARIO();
//<Stores de fk>

//<ClavePrimaria>
this.co_anio_fiscal = new Ext.form.Hidden({
    name:'co_anio_fiscal',
    value:this.OBJ.co_anio_fiscal});
//</ClavePrimaria>


this.tx_anio_fiscal = new Ext.form.TextField({
	fieldLabel:'Tx anio fiscal',
	name:'tb013_anio_fiscal[tx_anio_fiscal]',
	value:this.OBJ.tx_anio_fiscal,
	allowBlank:false,
	width:200
});

this.fe_apertura = new Ext.form.DateField({
	fieldLabel:'Fe apertura',
	name:'tb013_anio_fiscal[fe_apertura]',
	value:this.OBJ.fe_apertura,
	allowBlank:false,
	width:100
});

this.co_usuario = new Ext.form.ComboBox({
	fieldLabel:'Co usuario',
	store: this.storeCO_USUARIO,
	typeAhead: true,
	valueField: 'co_usuario',
	displayField:'co_usuario',
	hiddenName:'tb013_anio_fiscal[co_usuario]',
	//readOnly:(this.OBJ.co_usuario!='')?true:false,
	//style:(this.main.OBJ.co_usuario!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_usuario',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_USUARIO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_usuario,
	value:  this.OBJ.co_usuario,
	objStore: this.storeCO_USUARIO
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tb013_anio_fiscal[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ejercicioEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ejercicioEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ejercicio/guardar',
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
                 ejercicioLista.main.store_lista.load();
                 ejercicioEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ejercicioEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_anio_fiscal,
                    this.tx_anio_fiscal,
                    this.fe_apertura,
                    this.co_usuario,
                    this.in_activo,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: ejercicio',
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
ejercicioLista.main.mascara.hide();
}
,getStoreCO_USUARIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ejercicio/storefkcousuario',
        root:'data',
        fields:[
            {name: 'co_usuario'}
            ]
    });
    return this.store;
}
};
Ext.onReady(ejercicioEditar.main.init, ejercicioEditar.main);
</script>
