<script type="text/javascript">
Ext.ns("PresupuestoEjercicioFiltro");
PresupuestoEjercicioFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeID_EJECUTOR = this.getStoreID_EJECUTOR();
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
	fieldLabel:'Ejecutor',
	store: this.storeID_EJECUTOR,
	typeAhead: true,
	valueField: 'id',
	displayField:'ejecutor',
	hiddenName:'id_tb082_ejecutor',
	//readOnly:(this.OBJ.id_tb082_ejecutor!='')?true:false,
	//style:(this.main.OBJ.id_tb082_ejecutor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Ejecutor...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeID_EJECUTOR.load();

this.nu_proyecto_ac = new Ext.form.TextField({
	fieldLabel:'N° Proy / Ac',
	name:'nu_proyecto_ac',
	value:''
});

this.de_proyecto_ac = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'de_proyecto_ac',
	value:'',
	width:400
});

this.id_tb013_anio_fiscal = new Ext.form.NumberField({
	fieldLabel:'Año Fiscal',
	name:'id_tb013_anio_fiscal',
	value:''
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

this.in_cargado = new Ext.form.Checkbox({
	fieldLabel:'In cargado',
	name:'in_cargado',
	checked:true
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                this.id_tb082_ejecutor,
                                                                                this.nu_proyecto_ac,
                                                                                this.de_proyecto_ac,
                                                                                this.id_tb013_anio_fiscal,
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
                     PresupuestoEjercicioFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PresupuestoEjercicioFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PresupuestoEjercicioFiltro.main.win.close();
                    PresupuestoEjercicioLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PresupuestoEjercicioLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PresupuestoEjercicioFiltro.main.panelfiltro.getForm().reset();
    PresupuestoEjercicioLista.main.store_lista.baseParams={}
    PresupuestoEjercicioLista.main.store_lista.baseParams.paginar = 'si';
    PresupuestoEjercicioLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PresupuestoEjercicioFiltro.main.panelfiltro.getForm().getValues();
    PresupuestoEjercicioLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PresupuestoEjercicioLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PresupuestoEjercicioLista.main.store_lista.baseParams.paginar = 'si';
        PresupuestoEjercicioLista.main.store_lista.baseParams.BuscarBy = true;
        PresupuestoEjercicioLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicio/storefkidtb080sector',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicio/storefkidtb081subsector',
        root:'data',
        fields:[
            {name: 'id'}
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
            {name: 'nu_ejecutor'},
            {name: 'de_ejecutor'},
            {name: 'ejecutor',
                convert:function(v,r){
                return r.nu_ejecutor+' - '+r.de_ejecutor;
                }
            }
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicio/storefkidtb086tipoprac',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(PresupuestoEjercicioFiltro.main.init,PresupuestoEjercicioFiltro.main);
</script>