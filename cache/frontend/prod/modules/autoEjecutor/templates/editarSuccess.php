<script type="text/javascript">
Ext.ns("EjecutorEditar");
EjecutorEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.nu_ejecutor = new Ext.form.TextField({
	fieldLabel:'Nu ejecutor',
	name:'tb082_ejecutor[nu_ejecutor]',
	value:this.OBJ.nu_ejecutor,
	allowBlank:false,
	width:200
});

this.de_ejecutor = new Ext.form.TextField({
	fieldLabel:'De ejecutor',
	name:'tb082_ejecutor[de_ejecutor]',
	value:this.OBJ.de_ejecutor,
	allowBlank:false,
	width:200
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tb082_ejecutor[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tb082_ejecutor[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tb082_ejecutor[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.tx_sigla = new Ext.form.TextField({
	fieldLabel:'Tx sigla',
	name:'tb082_ejecutor[tx_sigla]',
	value:this.OBJ.tx_sigla,
	allowBlank:false,
	width:200
});

this.co_sector = new Ext.form.ComboBox({
	fieldLabel:'Co sector',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb082_ejecutor[co_sector]',
	//readOnly:(this.OBJ.co_sector!='')?true:false,
	//style:(this.main.OBJ.co_sector!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_sector',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_sector,
	value:  this.OBJ.co_sector,
	objStore: this.storeID
});

this.id_tb151_tipo_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Id tb151 tipo ejecutor',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb082_ejecutor[id_tb151_tipo_ejecutor]',
	//readOnly:(this.OBJ.id_tb151_tipo_ejecutor!='')?true:false,
	//style:(this.main.OBJ.id_tb151_tipo_ejecutor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb151_tipo_ejecutor',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb151_tipo_ejecutor,
	value:  this.OBJ.id_tb151_tipo_ejecutor,
	objStore: this.storeID
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
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
                    this.nu_ejecutor,
                    this.de_ejecutor,
                    this.in_activo,
                    this.created_at,
                    this.updated_at,
                    this.tx_sigla,
                    this.co_sector,
                    this.id_tb151_tipo_ejecutor,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Ejecutor',
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
EjecutorLista.main.mascara.hide();
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ejecutor/storefkcosector',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ejecutor/storefkidtb151tipoejecutor',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
};
Ext.onReady(EjecutorEditar.main.init, EjecutorEditar.main);
</script>
