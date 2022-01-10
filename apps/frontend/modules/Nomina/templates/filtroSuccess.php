<script type="text/javascript">
Ext.ns("NominaFiltro");
NominaFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_TP_NOMINA = this.getStoreCO_TP_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_NOM_FRECUENCIA_PAGO = this.getStoreCO_NOM_FRECUENCIA_PAGO();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>



this.co_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co solicitud',
	name:'co_solicitud',
	value:''
});

this.co_tp_nomina = new Ext.form.ComboBox({
	fieldLabel:'Co tp nomina',
	store: this.storeCO_TP_NOMINA,
	typeAhead: true,
	valueField: 'co_tp_nomina',
	displayField:'co_tp_nomina',
	hiddenName:'co_tp_nomina',
	//readOnly:(this.OBJ.co_tp_nomina!='')?true:false,
	//style:(this.main.OBJ.co_tp_nomina!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tp_nomina',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TP_NOMINA.load();

this.co_nom_frecuencia_pago = new Ext.form.ComboBox({
	fieldLabel:'Co nom frecuencia pago',
	store: this.storeCO_NOM_FRECUENCIA_PAGO,
	typeAhead: true,
	valueField: 'co_nom_frecuencia_pago',
	displayField:'co_nom_frecuencia_pago',
	hiddenName:'co_nom_frecuencia_pago',
	//readOnly:(this.OBJ.co_nom_frecuencia_pago!='')?true:false,
	//style:(this.main.OBJ.co_nom_frecuencia_pago!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_nom_frecuencia_pago',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_NOM_FRECUENCIA_PAGO.load();

this.nu_nomina = new Ext.form.TextField({
	fieldLabel:'Nu nomina',
	name:'nu_nomina',
	value:''
});

this.de_nomina = new Ext.form.TextField({
	fieldLabel:'De nomina',
	name:'de_nomina',
	value:''
});

this.de_observacion = new Ext.form.TextField({
	fieldLabel:'De observacion',
	name:'de_observacion',
	value:''
});

this.fe_inicio = new Ext.form.DateField({
	fieldLabel:'Fe inicio',
	name:'fe_inicio'
});

this.fe_fin = new Ext.form.DateField({
	fieldLabel:'Fe fin',
	name:'fe_fin'
});

this.fe_pago = new Ext.form.DateField({
	fieldLabel:'Fe pago',
	name:'fe_pago'
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

this.in_procesado = new Ext.form.Checkbox({
	fieldLabel:'In procesado',
	name:'in_procesado',
	checked:true
});

this.id_tbrh060_nomina_estatus = new Ext.form.ComboBox({
	fieldLabel:'Id tbrh060 nomina estatus',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tbrh060_nomina_estatus',
	//readOnly:(this.OBJ.id_tbrh060_nomina_estatus!='')?true:false,
	//style:(this.main.OBJ.id_tbrh060_nomina_estatus!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tbrh060_nomina_estatus',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.co_grupo_nomina = new Ext.form.NumberField({
	fieldLabel:'Co grupo nomina',
	name:'co_grupo_nomina',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_solicitud,
                                                                                this.co_tp_nomina,
                                                                                this.co_nom_frecuencia_pago,
                                                                                this.nu_nomina,
                                                                                this.de_nomina,
                                                                                this.de_observacion,
                                                                                this.fe_inicio,
                                                                                this.fe_fin,
                                                                                this.fe_pago,
                                                                                this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
                                                                                this.in_procesado,
                                                                                this.id_tbrh060_nomina_estatus,
                                                                                this.co_grupo_nomina,
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
                     NominaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    NominaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    NominaFiltro.main.win.close();
                    NominaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    NominaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    NominaFiltro.main.panelfiltro.getForm().reset();
    NominaLista.main.store_lista.baseParams={}
    NominaLista.main.store_lista.baseParams.paginar = 'si';
    NominaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = NominaFiltro.main.panelfiltro.getForm().getValues();
    NominaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("NominaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        NominaLista.main.store_lista.baseParams.paginar = 'si';
        NominaLista.main.store_lista.baseParams.BuscarBy = true;
        NominaLista.main.store_lista.load();


}
,getStoreCO_TP_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/storefkcotpnomina',
        root:'data',
        fields:[
            {name: 'co_tp_nomina'}
            ]
    });
    return this.store;
}
,getStoreCO_NOM_FRECUENCIA_PAGO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/storefkconomfrecuenciapago',
        root:'data',
        fields:[
            {name: 'co_nom_frecuencia_pago'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/storefkidtbrh060nominaestatus',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(NominaFiltro.main.init,NominaFiltro.main);
</script>