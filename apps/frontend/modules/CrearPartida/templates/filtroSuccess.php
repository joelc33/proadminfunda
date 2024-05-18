<script type="text/javascript">
Ext.ns("CrearPartidaFiltro");
CrearPartidaFiltro.main = {
init:function(){
 
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeCO_NUMERO_FUENTE = this.getStoreCO_NUMERO_FUENTE();
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
//<Stores de fk>
this.storeCO_USUARIO = this.getStoreCO_USUARIO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ESTATUS_RUTA = this.getStoreCO_ESTATUS_RUTA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_USUARIO = this.getStoreCO_USUARIO();
//<Stores de fk>



this.co_fuente_financiamiento = new Ext.form.ComboBox({
	fieldLabel:'Co fuente financiamiento',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'co_fuente_financiamiento',
	//readOnly:(this.OBJ.co_fuente_financiamiento!='')?true:false,
	//style:(this.main.OBJ.co_fuente_financiamiento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_fuente_financiamiento',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.co_numero_fuente = new Ext.form.ComboBox({
	fieldLabel:'Co numero fuente',
	store: this.storeCO_NUMERO_FUENTE,
	typeAhead: true,
	valueField: 'co_numero_fuente',
	displayField:'co_numero_fuente',
	hiddenName:'co_numero_fuente',
	//readOnly:(this.OBJ.co_numero_fuente!='')?true:false,
	//style:(this.main.OBJ.co_numero_fuente!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_numero_fuente',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_NUMERO_FUENTE.load();

this.co_ente_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Co ente ejecutor',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'co_ente_ejecutor',
	//readOnly:(this.OBJ.co_ente_ejecutor!='')?true:false,
	//style:(this.main.OBJ.co_ente_ejecutor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_ente_ejecutor',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.co_proyecto = new Ext.form.ComboBox({
	fieldLabel:'Co proyecto',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'co_proyecto',
	//readOnly:(this.OBJ.co_proyecto!='')?true:false,
	//style:(this.main.OBJ.co_proyecto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_proyecto',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.co_accion_especifica = new Ext.form.ComboBox({
	fieldLabel:'Co accion especifica',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'co_accion_especifica',
	//readOnly:(this.OBJ.co_accion_especifica!='')?true:false,
	//style:(this.main.OBJ.co_accion_especifica!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_accion_especifica',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.co_partida = new Ext.form.NumberField({
	fieldLabel:'Co partida',
	name:'co_partida',
	value:''
});

this.nu_anio = new Ext.form.NumberField({
	fieldLabel:'Nu anio',
name:'nu_anio',
	value:''
});

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Tx descripcion',
	name:'tx_descripcion',
	value:''
});

this.tx_partida = new Ext.form.TextField({
	fieldLabel:'Tx partida',
	name:'tx_partida',
	value:''
});

this.nu_monto = new Ext.form.NumberField({
	fieldLabel:'Nu monto',
name:'nu_monto',
	value:''
});

this.co_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co solicitud',
	name:'co_solicitud',
	value:''
});

this.co_usuario = new Ext.form.ComboBox({
	fieldLabel:'Co usuario',
	store: this.storeCO_USUARIO,
	typeAhead: true,
	valueField: 'co_usuario',
	displayField:'co_usuario',
	hiddenName:'co_usuario',
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

this.co_estatus = new Ext.form.ComboBox({
	fieldLabel:'Co estatus',
	store: this.storeCO_ESTATUS_RUTA,
	typeAhead: true,
	valueField: 'co_estatus_ruta',
	displayField:'co_estatus_ruta',
	hiddenName:'co_estatus',
	//readOnly:(this.OBJ.co_estatus!='')?true:false,
	//style:(this.main.OBJ.co_estatus!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_estatus',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ESTATUS_RUTA.load();

this.co_usuario_cambio = new Ext.form.ComboBox({
	fieldLabel:'Co usuario cambio',
	store: this.storeCO_USUARIO,
	typeAhead: true,
	valueField: 'co_usuario',
	displayField:'co_usuario',
	hiddenName:'co_usuario_cambio',
	//readOnly:(this.OBJ.co_usuario_cambio!='')?true:false,
	//style:(this.main.OBJ.co_usuario_cambio!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_usuario_cambio',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_USUARIO.load();

this.fe_cambio = new Ext.form.DateField({
	fieldLabel:'Fe cambio',
	name:'fe_cambio'
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_fuente_financiamiento,
                                                                                this.co_numero_fuente,
                                                                                this.co_ente_ejecutor,
                                                                                this.co_proyecto,
                                                                                this.co_accion_especifica,
                                                                                this.co_partida,
                                                                                this.nu_anio,
                                                                                this.tx_descripcion,
                                                                                this.tx_partida,
                                                                                this.nu_monto,
                                                                                this.co_solicitud,
                                                                                this.co_usuario,
                                                                                this.co_estatus,
                                                                                this.co_usuario_cambio,
                                                                                this.fe_cambio,
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
                     CrearPartidaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    CrearPartidaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    CrearPartidaFiltro.main.win.close();
                    CrearPartidaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    CrearPartidaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    CrearPartidaFiltro.main.panelfiltro.getForm().reset();
    CrearPartidaLista.main.store_lista.baseParams={}
    CrearPartidaLista.main.store_lista.baseParams.paginar = 'si';
    CrearPartidaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = CrearPartidaFiltro.main.panelfiltro.getForm().getValues();
    CrearPartidaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("CrearPartidaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        CrearPartidaLista.main.store_lista.baseParams.paginar = 'si';
        CrearPartidaLista.main.store_lista.baseParams.BuscarBy = true;
        CrearPartidaLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcofuentefinanciamiento',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreCO_NUMERO_FUENTE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkconumerofuente',
        root:'data',
        fields:[
            {name: 'co_numero_fuente'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcoenteejecutor',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcoproyecto',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcoaccionespecifica',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreCO_USUARIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcousuario',
        root:'data',
        fields:[
            {name: 'co_usuario'}
            ]
    });
    return this.store;
}
,getStoreCO_ESTATUS_RUTA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcoestatus',
        root:'data',
        fields:[
            {name: 'co_estatus_ruta'}
            ]
    });
    return this.store;
}
,getStoreCO_USUARIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcousuariocambio',
        root:'data',
        fields:[
            {name: 'co_usuario'}
            ]
    });
    return this.store;
}

};

Ext.onReady(CrearPartidaFiltro.main.init,CrearPartidaFiltro.main);
</script>