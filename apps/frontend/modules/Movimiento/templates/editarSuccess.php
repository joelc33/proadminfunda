<script type="text/javascript">
Ext.ns("MovimientoEditar");
MovimientoEditar.main = {
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


this.id_tb085_presupuesto = new Ext.form.ComboBox({
	fieldLabel:'Id tb085 presupuesto',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb087_presupuesto_movimiento[id_tb085_presupuesto]',
	//readOnly:(this.OBJ.id_tb085_presupuesto!='')?true:false,
	//style:(this.main.OBJ.id_tb085_presupuesto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb085_presupuesto',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb085_presupuesto,
	value:  this.OBJ.id_tb085_presupuesto,
	objStore: this.storeID
});

this.mo_movimiento = new Ext.form.NumberField({
	fieldLabel:'Mo movimiento',
	name:'tb087_presupuesto_movimiento[mo_movimiento]',
	value:this.OBJ.mo_movimiento,
	allowBlank:false
});

this.id_tb088_tipo_movimiento = new Ext.form.ComboBox({
	fieldLabel:'Id tb088 tipo movimiento',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb087_presupuesto_movimiento[id_tb088_tipo_movimiento]',
	//readOnly:(this.OBJ.id_tb088_tipo_movimiento!='')?true:false,
	//style:(this.main.OBJ.id_tb088_tipo_movimiento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb088_tipo_movimiento',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb088_tipo_movimiento,
	value:  this.OBJ.id_tb088_tipo_movimiento,
	objStore: this.storeID
});

this.nu_referencia = new Ext.form.TextField({
	fieldLabel:'Nu referencia',
	name:'tb087_presupuesto_movimiento[nu_referencia]',
	value:this.OBJ.nu_referencia,
	allowBlank:false,
	width:200
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tb087_presupuesto_movimiento[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tb087_presupuesto_movimiento[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tb087_presupuesto_movimiento[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!MovimientoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        MovimientoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/guardar',
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
                 MovimientoLista.main.store_lista.load();
                 MovimientoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        MovimientoEditar.main.winformPanel_.close();
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
                    this.id_tb085_presupuesto,
                    this.mo_movimiento,
                    this.id_tb088_tipo_movimiento,
                    this.nu_referencia,
                    this.in_activo,
                    this.created_at,
                    this.updated_at,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Movimiento',
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
MovimientoLista.main.mascara.hide();
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/storefkidtb085presupuesto',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/storefkidtb088tipomovimiento',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
};
Ext.onReady(MovimientoEditar.main.init, MovimientoEditar.main);
</script>
