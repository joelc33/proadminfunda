<script type="text/javascript">
Ext.ns("PresupuestoEjercicioEditar");
PresupuestoEjercicioEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeID_SECTOR = this.getStoreID_SECTOR();
//<Stores de fk>
//<Stores de fk>
this.storeID_SUB_SECTOR = this.getStoreID_SUB_SECTOR();
//<Stores de fk>
//<Stores de fk>
this.storeID_EJECUTOR = this.getStoreID_EJECUTOR();
//<Stores de fk>
//<Stores de fk>
this.storeID_TIPO = this.getStoreID_TIPO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ANIO_FISCAL = this.getStoreCO_ANIO_FISCAL();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.id_tb080_sector = new Ext.form.ComboBox({
	fieldLabel:'Sector',
	store: this.storeID_SECTOR,
	typeAhead: true,
	valueField: 'id',
	displayField:'sector',
	hiddenName:'tb165_pac_tmp[id_tb080_sector]',
	//readOnly:(this.OBJ.id_tb080_sector!='')?true:false,
	//style:(this.main.OBJ.id_tb080_sector!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Sector',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false,
	listeners:{
        select: function(){
			PresupuestoEjercicioEditar.main.id_tb081_sub_sector.clearValue();
            PresupuestoEjercicioEditar.main.storeID_SUB_SECTOR.load({
                params:{
                    sector:this.getValue()
                }
            });
        }
    }
});
this.storeID_SECTOR.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb080_sector,
	value:  this.OBJ.id_tb080_sector,
	objStore: this.storeID_SECTOR
});

if(this.OBJ.id_tb080_sector){
  this.storeID_SUB_SECTOR.load({
		params: {
			sector:this.OBJ.id_tb080_sector
		},
		callback: function(){
			PresupuestoEjercicioEditar.main.id_tb081_sub_sector.setValue(PresupuestoEjercicioEditar.main.OBJ.id_tb081_sub_sector);
		}
	});

}

this.id_tb081_sub_sector = new Ext.form.ComboBox({
	fieldLabel:'Sub-Sector',
	store: this.storeID_SUB_SECTOR,
	typeAhead: true,
	valueField: 'id',
	displayField:'sub_sector',
	hiddenName:'tb165_pac_tmp[id_tb081_sub_sector]',
	//readOnly:(this.OBJ.id_tb081_sub_sector!='')?true:false,
	//style:(this.main.OBJ.id_tb081_sub_sector!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Sub-Sector',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
/*this.storeID_SUB_SECTOR.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb081_sub_sector,
	value:  this.OBJ.id_tb081_sub_sector,
	objStore: this.storeID_SUB_SECTOR
});*/

this.id_tb082_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Ejecutor',
	store: this.storeID_EJECUTOR,
	typeAhead: true,
	valueField: 'id',
	displayField:'ejecutor',
	hiddenName:'tb165_pac_tmp[id_tb082_ejecutor]',
	//readOnly:(this.OBJ.id_tb082_ejecutor!='')?true:false,
	//style:(this.main.OBJ.id_tb082_ejecutor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Ejecutor',
	itemSelector: 'div.search-item',
	tpl: new Ext.XTemplate('<tpl for="."><div class="search-item"><div class="desc">{ejecutor}</div></div></tpl>'),
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeID_EJECUTOR.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb082_ejecutor,
	value:  this.OBJ.id_tb082_ejecutor,
	objStore: this.storeID_EJECUTOR
});

this.nu_proyecto_ac = new Ext.form.TextField({
	fieldLabel:'N° Proy/AC',
	name:'tb165_pac_tmp[nu_proyecto_ac]',
	value:this.OBJ.nu_proyecto_ac,
	allowBlank:false,
	width:200
});

this.de_proyecto_ac = new Ext.form.TextArea({
	fieldLabel:'Descripcion Proy/AC',
	name:'tb165_pac_tmp[de_proyecto_ac]',
	value:this.OBJ.de_proyecto_ac,
	allowBlank:false,
	width:400
});

this.id_tb013_anio_fiscal = new Ext.form.ComboBox({
	fieldLabel:'Ejercicio Fiscal',
	store: this.storeCO_ANIO_FISCAL,
	typeAhead: true,
	valueField: 'co_anio_fiscal',
	displayField:'co_anio_fiscal',
	hiddenName:'tb165_pac_tmp[id_tb013_anio_fiscal]',
	//readOnly:(this.OBJ.id_tb013_anio_fiscal!='')?true:false,
	//style:(this.main.OBJ.id_tb013_anio_fiscal!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Ejercicio Fiscal',
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

this.id_tb086_tipo_prac = new Ext.form.ComboBox({
	fieldLabel:'Tipo Proy/AC',
	store: this.storeID_TIPO,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_tipo_prac',
	hiddenName:'tb165_pac_tmp[id_tb086_tipo_prac]',
	//readOnly:(this.OBJ.id_tb086_tipo_prac!='')?true:false,
	//style:(this.main.OBJ.id_tb086_tipo_prac!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Tipo Proy/AC',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID_TIPO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb086_tipo_prac,
	value:  this.OBJ.id_tb086_tipo_prac,
	objStore: this.storeID_TIPO
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tb165_pac_tmp[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tb165_pac_tmp[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tb165_pac_tmp[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.in_cargado = new Ext.form.Checkbox({
	fieldLabel:'In cargado',
	name:'tb165_pac_tmp[in_cargado]',
	checked:(this.OBJ.in_cargado=='0') ? true:false,
	allowBlank:false
});

this.mo_presupuesto = new Ext.form.NumberField({
	fieldLabel:'Monto Presupuestado',
	name:'tb165_pac_tmp[mo_presupuesto]',
	value:this.OBJ.mo_presupuesto,
	allowBlank:false,
	width:200
});


this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PresupuestoEjercicioEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PresupuestoEjercicioEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicio/guardar',
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
                 PresupuestoEjercicioLista.main.store_lista.load();
                 PresupuestoEjercicioEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PresupuestoEjercicioEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
autoHeight:true,  
    autoScroll:true,
	labelWidth: 150,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
					this.id_tb086_tipo_prac,
                    this.id_tb080_sector,
                    this.id_tb081_sub_sector,
                    this.id_tb082_ejecutor,
                    this.nu_proyecto_ac,
                    this.de_proyecto_ac,
                    this.id_tb013_anio_fiscal,
					this.mo_presupuesto
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Presupuesto Ejercicio',
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
PresupuestoEjercicioLista.main.mascara.hide();
}
,getStoreID_SECTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicio/storefkidtb080sector',
        root:'data',
        fields:[
            {name: 'id'},
            {
				name: 'sector',
				convert: function(v, r) {
						return r.nu_sector + ' - ' + r.de_sector;
				}
		    }
            ]
    });
    return this.store;
}
,getStoreID_SUB_SECTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicio/storefkidtb081subsector',
        root:'data',
        fields:[
            {name: 'id'},
            {
				name: 'sub_sector',
				convert: function(v, r) {
						return r.nu_sub_sector + ' - ' + r.de_sub_sector;
				}
		    }
            ]
    });
    return this.store;
}
,getStoreID_EJECUTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicio/storefkidtb082ejecutor',
        root:'data',
        fields:[
            {name: 'id'},
            {
				name: 'ejecutor',
				convert: function(v, r) {
						return r.nu_ejecutor + ' - ' + r.de_ejecutor;
				}
		    }
            ]
    });
    return this.store;
}
,getStoreID_TIPO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicio/storefkidtb086tipoprac',
        root:'data',
        fields:[
            {name: 'id'},
			{name: 'de_tipo_prac'}
            ]
    });
    return this.store;
}
,getStoreCO_ANIO_FISCAL:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicio/storefkidtb013aniofiscal',
        root:'data',
        fields:[
            {name: 'co_anio_fiscal'}
            ]
    });
    return this.store;
}
};
Ext.onReady(PresupuestoEjercicioEditar.main.init, PresupuestoEjercicioEditar.main);
</script>
