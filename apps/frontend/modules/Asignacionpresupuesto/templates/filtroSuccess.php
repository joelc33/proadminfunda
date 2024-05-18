<script type="text/javascript">
Ext.ns("AsignacionpresupuestoFiltro");
AsignacionpresupuestoFiltro.main = {
init:function(){

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
this.storeCO_ANIO_FISCAL = this.getStoreCO_ANIO_FISCAL();
//<Stores de fk>
//<Stores de fk>
this.storeID_CLASE = this.getStoreID_CLASE();
//<Stores de fk>



this.id_tb080_sector = new Ext.form.ComboBox({
	fieldLabel:'Sector',
	store: this.storeID_SECTOR,
	typeAhead: true,
	valueField: 'id',
	displayField:'sector',
	hiddenName:'id_tb080_sector',
	//readOnly:(this.OBJ.id_tb080_sector!='')?true:false,
	//style:(this.main.OBJ.id_tb080_sector!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Sector',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false
});
this.storeID_SECTOR.load();

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
	emptyText:'Seleccione Ejecutor',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false
});
this.storeID_EJECUTOR.load();

this.nu_proyecto_ac = new Ext.form.TextField({
	fieldLabel:'Numero Proyecto / AC',
	name:'nu_proyecto_ac',
	value:'',
	width:200
});

this.de_proyecto_ac = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'de_proyecto_ac',
	value:'',
	width:200
});

this.id_tb013_anio_fiscal = new Ext.form.ComboBox({
	fieldLabel:'Ejercicio',
	store: this.storeCO_ANIO_FISCAL,
	typeAhead: true,
	valueField: 'co_anio_fiscal',
	displayField:'co_anio_fiscal',
	hiddenName:'id_tb013_anio_fiscal',
	//readOnly:(this.OBJ.id_tb013_anio_fiscal!='')?true:false,
	//style:(this.main.OBJ.id_tb013_anio_fiscal!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Ejercicio',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ANIO_FISCAL.load();

this.id_tb086_tipo_prac = new Ext.form.ComboBox({
	fieldLabel:'Clase',
	store: this.storeID_CLASE,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_tipo_prac',
	hiddenName:'id_tb086_tipo_prac',
	//readOnly:(this.OBJ.id_tb086_tipo_prac!='')?true:false,
	//style:(this.main.OBJ.id_tb086_tipo_prac!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Clase',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID_CLASE.load();

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.id_tb080_sector,
                                                                                this.id_tb082_ejecutor,
                                                                                this.nu_proyecto_ac,
                                                                                this.de_proyecto_ac,
                                                                                this.id_tb013_anio_fiscal,
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
,getStoreID_SECTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/storefkidtb080sector',
        root:'data',
        fields:[
            {name: 'id'},
						{name: 'nu_sector'},
						{name: 'de_sector'},
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
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/storefkidtb081subsector',
        root:'data',
        fields:[
            {name: 'id'},
						{name: 'nu_sub_sector'},
						{name: 'de_sub_sector'},
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
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/storefkidtb082ejecutor',
        root:'data',
        fields:[
            {name: 'id'},
						{name: 'nu_ejecutor'},
						{name: 'de_ejecutor'},
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
,getStoreID_CLASE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/storefkidtb086tipoprac',
        root:'data',
        fields:[
            {name: 'id'},
						{name: 'de_tipo_prac'}
            ]
    });
    return this.store;
}

};

Ext.onReady(AsignacionpresupuestoFiltro.main.init,AsignacionpresupuestoFiltro.main);
</script>
