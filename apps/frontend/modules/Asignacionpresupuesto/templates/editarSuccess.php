<script type="text/javascript">
Ext.ns("AsignacionpresupuestoEditar");
AsignacionpresupuestoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ANIO_FISCAL = this.getStoreCO_ANIO_FISCAL();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.id_tb080_sector = new Ext.form.ComboBox({
	fieldLabel:'Id tb080 sector',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb083_proyecto_ac[id_tb080_sector]',
	//readOnly:(this.OBJ.id_tb080_sector!='')?true:false,
	//style:(this.main.OBJ.id_tb080_sector!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb080_sector',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb080_sector,
	value:  this.OBJ.id_tb080_sector,
	objStore: this.storeID
});

this.id_tb081_sub_sector = new Ext.form.ComboBox({
	fieldLabel:'Id tb081 sub sector',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb083_proyecto_ac[id_tb081_sub_sector]',
	//readOnly:(this.OBJ.id_tb081_sub_sector!='')?true:false,
	//style:(this.main.OBJ.id_tb081_sub_sector!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb081_sub_sector',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb081_sub_sector,
	value:  this.OBJ.id_tb081_sub_sector,
	objStore: this.storeID
});

this.id_tb082_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Id tb082 ejecutor',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb083_proyecto_ac[id_tb082_ejecutor]',
	//readOnly:(this.OBJ.id_tb082_ejecutor!='')?true:false,
	//style:(this.main.OBJ.id_tb082_ejecutor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb082_ejecutor',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb082_ejecutor,
	value:  this.OBJ.id_tb082_ejecutor,
	objStore: this.storeID
});

this.nu_proyecto_ac = new Ext.form.TextField({
	fieldLabel:'Nu proyecto ac',
	name:'tb083_proyecto_ac[nu_proyecto_ac]',
	value:this.OBJ.nu_proyecto_ac,
	allowBlank:false,
	width:200
});

this.de_proyecto_ac = new Ext.form.TextField({
	fieldLabel:'De proyecto ac',
	name:'tb083_proyecto_ac[de_proyecto_ac]',
	value:this.OBJ.de_proyecto_ac,
	allowBlank:false,
	width:200
});

this.id_tb013_anio_fiscal = new Ext.form.ComboBox({
	fieldLabel:'Id tb013 anio fiscal',
	store: this.storeCO_ANIO_FISCAL,
	typeAhead: true,
	valueField: 'co_anio_fiscal',
	displayField:'co_anio_fiscal',
	hiddenName:'tb083_proyecto_ac[id_tb013_anio_fiscal]',
	//readOnly:(this.OBJ.id_tb013_anio_fiscal!='')?true:false,
	//style:(this.main.OBJ.id_tb013_anio_fiscal!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb013_anio_fiscal',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ANIO_FISCAL.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb013_anio_fiscal,
	value:  this.OBJ.id_tb013_anio_fiscal,
	objStore: this.storeCO_ANIO_FISCAL
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tb083_proyecto_ac[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tb083_proyecto_ac[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tb083_proyecto_ac[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.id_tb086_tipo_prac = new Ext.form.ComboBox({
	fieldLabel:'Id tb086 tipo prac',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb083_proyecto_ac[id_tb086_tipo_prac]',
	//readOnly:(this.OBJ.id_tb086_tipo_prac!='')?true:false,
	//style:(this.main.OBJ.id_tb086_tipo_prac!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb086_tipo_prac',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb086_tipo_prac,
	value:  this.OBJ.id_tb086_tipo_prac,
	objStore: this.storeID
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!AsignacionpresupuestoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        AsignacionpresupuestoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/guardar',
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
                 AsignacionpresupuestoLista.main.store_lista.load();
                 AsignacionpresupuestoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        AsignacionpresupuestoEditar.main.winformPanel_.close();
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
                    this.id_tb080_sector,
                    this.id_tb081_sub_sector,
                    this.id_tb082_ejecutor,
                    this.nu_proyecto_ac,
                    this.de_proyecto_ac,
                    this.id_tb013_anio_fiscal,
                    this.in_activo,
                    this.created_at,
                    this.updated_at,
                    this.id_tb086_tipo_prac,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Asignacionpresupuesto',
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
AsignacionpresupuestoLista.main.mascara.hide();
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/storefkidtb080sector',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/storefkidtb081subsector',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/storefkidtb082ejecutor',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreCO_ANIO_FISCAL:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/storefkidtb013aniofiscal',
        root:'data',
        fields:[
            {name: 'co_anio_fiscal'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/storefkidtb086tipoprac',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
};
Ext.onReady(AsignacionpresupuestoEditar.main.init, AsignacionpresupuestoEditar.main);
</script>
