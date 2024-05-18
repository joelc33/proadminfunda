<script type="text/javascript">
Ext.ns("AsignacionpresupuestoFiltro");
AsignacionpresupuestoFiltro.main = {
init:function(){

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
this.storeID = this.getStoreID();
//<Stores de fk>



this.id_tb080_sector = new Ext.form.ComboBox({
	fieldLabel:'Id tb080 sector',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb080_sector',
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

this.id_tb081_sub_sector = new Ext.form.ComboBox({
	fieldLabel:'Id tb081 sub sector',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb081_sub_sector',
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

this.id_tb082_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Id tb082 ejecutor',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb082_ejecutor',
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

this.nu_proyecto_ac = new Ext.form.TextField({
	fieldLabel:'Nu proyecto ac',
	name:'nu_proyecto_ac',
	value:''
});

this.de_proyecto_ac = new Ext.form.TextField({
	fieldLabel:'De proyecto ac',
	name:'de_proyecto_ac',
	value:''
});

this.id_tb013_anio_fiscal = new Ext.form.NumberField({
	fieldLabel:'Id tb013 anio fiscal',
	name:'id_tb013_anio_fiscal',
	value:''
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'in_activo',
	checked:true
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'updated_at'
});

this.id_tb086_tipo_prac = new Ext.form.ComboBox({
	fieldLabel:'Id tb086 tipo prac',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb086_tipo_prac',
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

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
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
               }
            ]
    });

    this.panelfiltro = new Ext.form.FormPanel({
        frame:true,
        autoWidth:true,
        border:false,
        items:[
            this.tabpanelfiltro
        ]
    });

    this.win = new Ext.Window({
        title:'Parametros de busqueda',
        iconCls: 'icon-buscar',
        width:600,
        autoHeight:true,
        constrain:true,
        closable:false,
        buttonAlign:'center',
        items:[
            this.panelfiltro
        ],
        buttons:[
            {
                text:'Filtrar',
                handler:function(){
                     AsignacionpresupuestoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    AsignacionpresupuestoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    AsignacionpresupuestoFiltro.main.win.close();
                    AsignacionpresupuestoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    AsignacionpresupuestoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    AsignacionpresupuestoFiltro.main.panelfiltro.getForm().reset();
    AsignacionpresupuestoLista.main.store_lista.baseParams={}
    AsignacionpresupuestoLista.main.store_lista.baseParams.paginar = 'si';
    AsignacionpresupuestoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = AsignacionpresupuestoFiltro.main.panelfiltro.getForm().getValues();
    AsignacionpresupuestoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("AsignacionpresupuestoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        AsignacionpresupuestoLista.main.store_lista.baseParams.paginar = 'si';
        AsignacionpresupuestoLista.main.store_lista.baseParams.BuscarBy = true;
        AsignacionpresupuestoLista.main.store_lista.load();


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

Ext.onReady(AsignacionpresupuestoFiltro.main.init,AsignacionpresupuestoFiltro.main);
</script>