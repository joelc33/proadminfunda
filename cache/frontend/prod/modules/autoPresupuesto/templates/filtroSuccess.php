<script type="text/javascript">
Ext.ns("PresupuestoFiltro");
PresupuestoFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_PARTIDA_PRESUPUESTARIA = this.getStoreCO_PARTIDA_PRESUPUESTARIA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ACTIVIDAD = this.getStoreCO_ACTIVIDAD();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ANIO_FISCAL = this.getStoreCO_ANIO_FISCAL();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CUENTA_CONTABLE = this.getStoreCO_CUENTA_CONTABLE();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_PRESUPUESTO = this.getStoreCO_TIPO_PRESUPUESTO();
//<Stores de fk>



this.co_partida_presupuestaria = new Ext.form.ComboBox({
	fieldLabel:'Co partida presupuestaria',
	store: this.storeCO_PARTIDA_PRESUPUESTARIA,
	typeAhead: true,
	valueField: 'co_partida_presupuestaria',
	displayField:'co_partida_presupuestaria',
	hiddenName:'co_partida_presupuestaria',
	//readOnly:(this.OBJ.co_partida_presupuestaria!='')?true:false,
	//style:(this.main.OBJ.co_partida_presupuestaria!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_partida_presupuestaria',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_PARTIDA_PRESUPUESTARIA.load();

this.co_actividad = new Ext.form.ComboBox({
	fieldLabel:'Co actividad',
	store: this.storeCO_ACTIVIDAD,
	typeAhead: true,
	valueField: 'co_actividad',
	displayField:'co_actividad',
	hiddenName:'co_actividad',
	//readOnly:(this.OBJ.co_actividad!='')?true:false,
	//style:(this.main.OBJ.co_actividad!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_actividad',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ACTIVIDAD.load();

this.mo_inicial = new Ext.form.NumberField({
	fieldLabel:'Mo inicial',
name:'mo_inicial',
	value:''
});

this.mo_autorizado = new Ext.form.NumberField({
	fieldLabel:'Mo autorizado',
name:'mo_autorizado',
	value:''
});

this.mo_comprometido = new Ext.form.NumberField({
	fieldLabel:'Mo comprometido',
name:'mo_comprometido',
	value:''
});

this.mo_causado = new Ext.form.NumberField({
	fieldLabel:'Mo causado',
name:'mo_causado',
	value:''
});

this.mo_pagado = new Ext.form.NumberField({
	fieldLabel:'Mo pagado',
name:'mo_pagado',
	value:''
});

this.co_anio_fiscal = new Ext.form.ComboBox({
	fieldLabel:'Co anio fiscal',
	store: this.storeCO_ANIO_FISCAL,
	typeAhead: true,
	valueField: 'co_anio_fiscal',
	displayField:'co_anio_fiscal',
	hiddenName:'co_anio_fiscal',
	//readOnly:(this.OBJ.co_anio_fiscal!='')?true:false,
	//style:(this.main.OBJ.co_anio_fiscal!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_anio_fiscal',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ANIO_FISCAL.load();

this.mo_disponible = new Ext.form.NumberField({
	fieldLabel:'Mo disponible',
name:'mo_disponible',
	value:''
});

this.mo_deuda = new Ext.form.NumberField({
	fieldLabel:'Mo deuda',
name:'mo_deuda',
	value:''
});

this.co_cuenta_contable = new Ext.form.ComboBox({
	fieldLabel:'Co cuenta contable',
	store: this.storeCO_CUENTA_CONTABLE,
	typeAhead: true,
	valueField: 'co_cuenta_contable',
	displayField:'co_cuenta_contable',
	hiddenName:'co_cuenta_contable',
	//readOnly:(this.OBJ.co_cuenta_contable!='')?true:false,
	//style:(this.main.OBJ.co_cuenta_contable!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_cuenta_contable',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_CUENTA_CONTABLE.load();

this.mo_debito = new Ext.form.NumberField({
	fieldLabel:'Mo debito',
name:'mo_debito',
	value:''
});

this.mo_credito = new Ext.form.NumberField({
	fieldLabel:'Mo credito',
name:'mo_credito',
	value:''
});

this.in_ordinal = new Ext.form.Checkbox({
	fieldLabel:'In ordinal',
	name:'in_ordinal',
	checked:true
});

this.co_tipo_presupuesto = new Ext.form.ComboBox({
	fieldLabel:'Co tipo presupuesto',
	store: this.storeCO_TIPO_PRESUPUESTO,
	typeAhead: true,
	valueField: 'co_tipo_presupuesto',
	displayField:'co_tipo_presupuesto',
	hiddenName:'co_tipo_presupuesto',
	//readOnly:(this.OBJ.co_tipo_presupuesto!='')?true:false,
	//style:(this.main.OBJ.co_tipo_presupuesto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_presupuesto',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_TIPO_PRESUPUESTO.load();

this.mo_aumento = new Ext.form.NumberField({
	fieldLabel:'Mo aumento',
name:'mo_aumento',
	value:''
});

this.mo_disminucion = new Ext.form.NumberField({
	fieldLabel:'Mo disminucion',
name:'mo_disminucion',
	value:''
});

this.mo_precomprometido = new Ext.form.NumberField({
	fieldLabel:'Mo precomprometido',
name:'mo_precomprometido',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_partida_presupuestaria,
                                                                                this.co_actividad,
                                                                                this.mo_inicial,
                                                                                this.mo_autorizado,
                                                                                this.mo_comprometido,
                                                                                this.mo_causado,
                                                                                this.mo_pagado,
                                                                                this.co_anio_fiscal,
                                                                                this.mo_disponible,
                                                                                this.mo_deuda,
                                                                                this.co_cuenta_contable,
                                                                                this.mo_debito,
                                                                                this.mo_credito,
                                                                                this.in_ordinal,
                                                                                this.co_tipo_presupuesto,
                                                                                this.mo_aumento,
                                                                                this.mo_disminucion,
                                                                                this.mo_precomprometido,
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
                     PresupuestoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PresupuestoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PresupuestoFiltro.main.win.close();
                    PresupuestoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PresupuestoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PresupuestoFiltro.main.panelfiltro.getForm().reset();
    PresupuestoLista.main.store_lista.baseParams={}
    PresupuestoLista.main.store_lista.baseParams.paginar = 'si';
    PresupuestoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PresupuestoFiltro.main.panelfiltro.getForm().getValues();
    PresupuestoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PresupuestoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PresupuestoLista.main.store_lista.baseParams.paginar = 'si';
        PresupuestoLista.main.store_lista.baseParams.BuscarBy = true;
        PresupuestoLista.main.store_lista.load();


}
,getStoreCO_PARTIDA_PRESUPUESTARIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcopartidapresupuestaria',
        root:'data',
        fields:[
            {name: 'co_partida_presupuestaria'}
            ]
    });
    return this.store;
}
,getStoreCO_ACTIVIDAD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcoactividad',
        root:'data',
        fields:[
            {name: 'co_actividad'}
            ]
    });
    return this.store;
}
,getStoreCO_ANIO_FISCAL:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcoaniofiscal',
        root:'data',
        fields:[
            {name: 'co_anio_fiscal'}
            ]
    });
    return this.store;
}
,getStoreCO_CUENTA_CONTABLE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcocuentacontable',
        root:'data',
        fields:[
            {name: 'co_cuenta_contable'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_PRESUPUESTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcotipopresupuesto',
        root:'data',
        fields:[
            {name: 'co_tipo_presupuesto'}
            ]
    });
    return this.store;
}

};

Ext.onReady(PresupuestoFiltro.main.init,PresupuestoFiltro.main);
</script>