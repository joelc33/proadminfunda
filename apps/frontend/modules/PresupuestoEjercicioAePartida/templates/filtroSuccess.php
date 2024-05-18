<script type="text/javascript">
Ext.ns("PresupuestoEjercicioAePartidaFiltro");
PresupuestoEjercicioAePartidaFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeCO_APLICACION = this.getStoreCO_APLICACION();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_INGRESO = this.getStoreCO_TIPO_INGRESO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_AMBITO = this.getStoreCO_AMBITO();
//<Stores de fk>



this.id_tb166_pac_ae_tmp = new Ext.form.ComboBox({
	fieldLabel:'Id tb166 pac ae tmp',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb166_pac_ae_tmp',
	//readOnly:(this.OBJ.id_tb166_pac_ae_tmp!='')?true:false,
	//style:(this.main.OBJ.id_tb166_pac_ae_tmp!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb166_pac_ae_tmp',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.nu_pa = new Ext.form.TextField({
	fieldLabel:'Nu pa',
	name:'nu_pa',
	value:''
});

this.nu_ge = new Ext.form.TextField({
	fieldLabel:'Nu ge',
	name:'nu_ge',
	value:''
});

this.nu_es = new Ext.form.TextField({
	fieldLabel:'Nu es',
	name:'nu_es',
	value:''
});

this.nu_se = new Ext.form.TextField({
	fieldLabel:'Nu se',
	name:'nu_se',
	value:''
});

this.nu_sse = new Ext.form.TextField({
	fieldLabel:'Nu sse',
	name:'nu_sse',
	value:''
});

this.de_partida = new Ext.form.TextField({
	fieldLabel:'De partida',
	name:'de_partida',
	value:''
});

this.in_movimiento = new Ext.form.Checkbox({
	fieldLabel:'In movimiento',
	name:'in_movimiento',
	checked:true
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'in_activo',
	checked:true
});

this.mo_partida = new Ext.form.NumberField({
	fieldLabel:'Mo partida',
name:'mo_partida',
	value:''
});

this.id_tb139_aplicacion = new Ext.form.ComboBox({
	fieldLabel:'Id tb139 aplicacion',
	store: this.storeCO_APLICACION,
	typeAhead: true,
	valueField: 'co_aplicacion',
	displayField:'co_aplicacion',
	hiddenName:'id_tb139_aplicacion',
	//readOnly:(this.OBJ.id_tb139_aplicacion!='')?true:false,
	//style:(this.main.OBJ.id_tb139_aplicacion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb139_aplicacion',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_APLICACION.load();

this.id_tb091_partida = new Ext.form.ComboBox({
	fieldLabel:'Id tb091 partida',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb091_partida',
	//readOnly:(this.OBJ.id_tb091_partida!='')?true:false,
	//style:(this.main.OBJ.id_tb091_partida!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb091_partida',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.id_tb140_tipo_ingreso = new Ext.form.ComboBox({
	fieldLabel:'Id tb140 tipo ingreso',
	store: this.storeCO_TIPO_INGRESO,
	typeAhead: true,
	valueField: 'co_tipo_ingreso',
	displayField:'co_tipo_ingreso',
	hiddenName:'id_tb140_tipo_ingreso',
	//readOnly:(this.OBJ.id_tb140_tipo_ingreso!='')?true:false,
	//style:(this.main.OBJ.id_tb140_tipo_ingreso!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb140_tipo_ingreso',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_INGRESO.load();

this.id_tb138_ambito = new Ext.form.ComboBox({
	fieldLabel:'Id tb138 ambito',
	store: this.storeCO_AMBITO,
	typeAhead: true,
	valueField: 'co_ambito',
	displayField:'co_ambito',
	hiddenName:'id_tb138_ambito',
	//readOnly:(this.OBJ.id_tb138_ambito!='')?true:false,
	//style:(this.main.OBJ.id_tb138_ambito!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb138_ambito',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_AMBITO.load();

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'updated_at'
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.id_tb166_pac_ae_tmp,
                                                                                this.nu_pa,
                                                                                this.nu_ge,
                                                                                this.nu_es,
                                                                                this.nu_se,
                                                                                this.nu_sse,
                                                                                this.de_partida,
                                                                                this.in_movimiento,
                                                                                this.in_activo,
                                                                                this.mo_partida,
                                                                                this.id_tb139_aplicacion,
                                                                                this.id_tb091_partida,
                                                                                this.id_tb140_tipo_ingreso,
                                                                                this.id_tb138_ambito,
                                                                                this.created_at,
                                                                                this.updated_at,
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
                     PresupuestoEjercicioAePartidaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PresupuestoEjercicioAePartidaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PresupuestoEjercicioAePartidaFiltro.main.win.close();
                    PresupuestoEjercicioAePartidaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PresupuestoEjercicioAePartidaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PresupuestoEjercicioAePartidaFiltro.main.panelfiltro.getForm().reset();
    PresupuestoEjercicioAePartidaLista.main.store_lista.baseParams={}
    PresupuestoEjercicioAePartidaLista.main.store_lista.baseParams.paginar = 'si';
    PresupuestoEjercicioAePartidaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PresupuestoEjercicioAePartidaFiltro.main.panelfiltro.getForm().getValues();
    PresupuestoEjercicioAePartidaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PresupuestoEjercicioAePartidaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PresupuestoEjercicioAePartidaLista.main.store_lista.baseParams.paginar = 'si';
        PresupuestoEjercicioAePartidaLista.main.store_lista.baseParams.BuscarBy = true;
        PresupuestoEjercicioAePartidaLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAePartida/storefkidtb166pacaetmp',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreCO_APLICACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAePartida/storefkidtb139aplicacion',
        root:'data',
        fields:[
            {name: 'co_aplicacion'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAePartida/storefkidtb091partida',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_INGRESO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAePartida/storefkidtb140tipoingreso',
        root:'data',
        fields:[
            {name: 'co_tipo_ingreso'}
            ]
    });
    return this.store;
}
,getStoreCO_AMBITO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoEjercicioAePartida/storefkidtb138ambito',
        root:'data',
        fields:[
            {name: 'co_ambito'}
            ]
    });
    return this.store;
}

};

Ext.onReady(PresupuestoEjercicioAePartidaFiltro.main.init,PresupuestoEjercicioAePartidaFiltro.main);
</script>