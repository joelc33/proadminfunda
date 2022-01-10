<script type="text/javascript">
Ext.ns("ConfigConceptoTiempoFiltro");
ConfigConceptoTiempoFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_TP_NOMINA = this.getStoreCO_TP_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_GRUPO_NOMINA = this.getStoreCO_GRUPO_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CONCEPTO = this.getStoreCO_CONCEPTO();
//<Stores de fk>



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

this.co_grupo_nomina = new Ext.form.ComboBox({
	fieldLabel:'Co grupo nomina',
	store: this.storeCO_GRUPO_NOMINA,
	typeAhead: true,
	valueField: 'co_grupo_nomina',
	displayField:'co_grupo_nomina',
	hiddenName:'co_grupo_nomina',
	//readOnly:(this.OBJ.co_grupo_nomina!='')?true:false,
	//style:(this.main.OBJ.co_grupo_nomina!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_grupo_nomina',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_GRUPO_NOMINA.load();

this.nu_mes = new Ext.form.NumberField({
	fieldLabel:'Nu mes',
name:'nu_mes',
	value:''
});

this.nu_concepto = new Ext.form.TextField({
	fieldLabel:'Nu concepto',
	name:'nu_concepto',
	value:''
});

this.co_concepto = new Ext.form.ComboBox({
	fieldLabel:'Co concepto',
	store: this.storeCO_CONCEPTO,
	typeAhead: true,
	valueField: 'co_concepto',
	displayField:'co_concepto',
	hiddenName:'co_concepto',
	//readOnly:(this.OBJ.co_concepto!='')?true:false,
	//style:(this.main.OBJ.co_concepto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_concepto',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_CONCEPTO.load();

this.nu_valor = new Ext.form.NumberField({
	fieldLabel:'Nu valor',
name:'nu_valor',
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

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_tp_nomina,
                                                                                this.co_grupo_nomina,
                                                                                this.nu_mes,
                                                                                this.nu_concepto,
                                                                                this.co_concepto,
                                                                                this.nu_valor,
                                                                                this.in_activo,
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
                     ConfigConceptoTiempoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConfigConceptoTiempoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConfigConceptoTiempoFiltro.main.win.close();
                    ConfigConceptoTiempoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConfigConceptoTiempoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfigConceptoTiempoFiltro.main.panelfiltro.getForm().reset();
    ConfigConceptoTiempoLista.main.store_lista.baseParams={}
    ConfigConceptoTiempoLista.main.store_lista.baseParams.paginar = 'si';
    ConfigConceptoTiempoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfigConceptoTiempoFiltro.main.panelfiltro.getForm().getValues();
    ConfigConceptoTiempoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfigConceptoTiempoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfigConceptoTiempoLista.main.store_lista.baseParams.paginar = 'si';
        ConfigConceptoTiempoLista.main.store_lista.baseParams.BuscarBy = true;
        ConfigConceptoTiempoLista.main.store_lista.load();


}
,getStoreCO_TP_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoTiempo/storefkcotpnomina',
        root:'data',
        fields:[
            {name: 'co_tp_nomina'}
            ]
    });
    return this.store;
}
,getStoreCO_GRUPO_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoTiempo/storefkcogruponomina',
        root:'data',
        fields:[
            {name: 'co_grupo_nomina'}
            ]
    });
    return this.store;
}
,getStoreCO_CONCEPTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoTiempo/storefkcoconcepto',
        root:'data',
        fields:[
            {name: 'co_concepto'}
            ]
    });
    return this.store;
}

};

Ext.onReady(ConfigConceptoTiempoFiltro.main.init,ConfigConceptoTiempoFiltro.main);
</script>