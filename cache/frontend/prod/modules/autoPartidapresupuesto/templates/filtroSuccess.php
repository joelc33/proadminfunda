<script type="text/javascript">
Ext.ns("PartidapresupuestoFiltro");
PartidapresupuestoFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CLASIFICACION_ECONOMICA = this.getStoreCO_CLASIFICACION_ECONOMICA();
//<Stores de fk>



this.id_tb084_accion_especifica = new Ext.form.ComboBox({
	fieldLabel:'Id tb084 accion especifica',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'id_tb084_accion_especifica',
	//readOnly:(this.OBJ.id_tb084_accion_especifica!='')?true:false,
	//style:(this.main.OBJ.id_tb084_accion_especifica!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb084_accion_especifica',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();

this.nu_partida = new Ext.form.TextField({
	fieldLabel:'Nu partida',
	name:'nu_partida',
	value:''
});

this.de_partida = new Ext.form.TextField({
	fieldLabel:'De partida',
	name:'de_partida',
	value:''
});

this.mo_inicial = new Ext.form.NumberField({
	fieldLabel:'Mo inicial',
name:'mo_inicial',
	value:''
});

this.mo_actualizado = new Ext.form.NumberField({
	fieldLabel:'Mo actualizado',
name:'mo_actualizado',
	value:''
});

this.mo_precomprometido = new Ext.form.NumberField({
	fieldLabel:'Mo precomprometido',
name:'mo_precomprometido',
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

this.mo_disponible = new Ext.form.NumberField({
	fieldLabel:'Mo disponible',
name:'mo_disponible',
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

this.in_movimiento = new Ext.form.Checkbox({
	fieldLabel:'In movimiento',
	name:'in_movimiento',
	checked:true
});

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

this.co_partida = new Ext.form.TextField({
	fieldLabel:'Co partida',
	name:'co_partida',
	value:''
});

this.nu_nivel = new Ext.form.NumberField({
	fieldLabel:'Nu nivel',
	name:'nu_nivel',
	value:''
});

this.nu_fi = new Ext.form.TextField({
	fieldLabel:'Nu fi',
	name:'nu_fi',
	value:''
});

this.co_categoria = new Ext.form.TextField({
	fieldLabel:'Co categoria',
	name:'co_categoria',
	value:''
});

this.nu_aplicacion = new Ext.form.TextField({
	fieldLabel:'Nu aplicacion',
	name:'nu_aplicacion',
	value:''
});

this.tp_ingreso = new Ext.form.TextField({
	fieldLabel:'Tp ingreso',
	name:'tp_ingreso',
	value:''
});

this.co_cuenta_contable = new Ext.form.NumberField({
	fieldLabel:'Co cuenta contable',
	name:'co_cuenta_contable',
	value:''
});

this.tip_apl = new Ext.form.TextField({
	fieldLabel:'Tip apl',
	name:'tip_apl',
	value:''
});

this.in_gen_cheque = new Ext.form.Checkbox({
	fieldLabel:'In gen cheque',
	name:'in_gen_cheque',
	checked:true
});

this.tip_gasto = new Ext.form.TextField({
	fieldLabel:'Tip gasto',
	name:'tip_gasto',
	value:''
});

this.tip_ing = new Ext.form.TextField({
	fieldLabel:'Tip ing',
	name:'tip_ing',
	value:''
});

this.cod_amb = new Ext.form.TextField({
	fieldLabel:'Cod amb',
	name:'cod_amb',
	value:''
});

this.co_ente = new Ext.form.NumberField({
	fieldLabel:'Co ente',
	name:'co_ente',
	value:''
});

this.nu_anio = new Ext.form.NumberField({
	fieldLabel:'Nu anio',
name:'nu_anio',
	value:''
});

this.mo_disponible_act = new Ext.form.NumberField({
	fieldLabel:'Mo disponible act',
name:'mo_disponible_act',
	value:''
});

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

this.mo_admon = new Ext.form.NumberField({
	fieldLabel:'Mo admon',
name:'mo_admon',
	value:''
});

this.mo_actualizado_ant = new Ext.form.NumberField({
	fieldLabel:'Mo actualizado ant',
name:'mo_actualizado_ant',
	value:''
});

this.comprometido_dia = new Ext.form.NumberField({
	fieldLabel:'Comprometido dia',
name:'comprometido_dia',
	value:''
});

this.causado_dia = new Ext.form.NumberField({
	fieldLabel:'Causado dia',
name:'causado_dia',
	value:''
});

this.pagado_dia = new Ext.form.NumberField({
	fieldLabel:'Pagado dia',
name:'pagado_dia',
	value:''
});

this.disponible = new Ext.form.NumberField({
	fieldLabel:'Disponible',
name:'disponible',
	value:''
});

this.cod_ente = new Ext.form.TextField({
	fieldLabel:'Cod ente',
	name:'cod_ente',
	value:''
});

this.nu_sector = new Ext.form.TextField({
	fieldLabel:'Nu sector',
	name:'nu_sector',
	value:''
});

this.id_tb139_aplicacion = new Ext.form.NumberField({
	fieldLabel:'Id tb139 aplicacion',
	name:'id_tb139_aplicacion',
	value:''
});

this.mo_admon_ant = new Ext.form.NumberField({
	fieldLabel:'Mo admon ant',
name:'mo_admon_ant',
	value:''
});

this.mo_modificado_admon = new Ext.form.NumberField({
	fieldLabel:'Mo modificado admon',
name:'mo_modificado_admon',
	value:''
});

this.co_clasificacion_economica = new Ext.form.ComboBox({
	fieldLabel:'Co clasificacion economica',
	store: this.storeCO_CLASIFICACION_ECONOMICA,
	typeAhead: true,
	valueField: 'co_clasificacion_economica',
	displayField:'co_clasificacion_economica',
	hiddenName:'co_clasificacion_economica',
	//readOnly:(this.OBJ.co_clasificacion_economica!='')?true:false,
	//style:(this.main.OBJ.co_clasificacion_economica!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_clasificacion_economica',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_CLASIFICACION_ECONOMICA.load();

this.co_area_estrategica = new Ext.form.NumberField({
	fieldLabel:'Co area estrategica',
	name:'co_area_estrategica',
	value:''
});

this.mo_inicial_soberano = new Ext.form.NumberField({
	fieldLabel:'Mo inicial soberano',
name:'mo_inicial_soberano',
	value:''
});

this.mo_actualizado_soberano = new Ext.form.NumberField({
	fieldLabel:'Mo actualizado soberano',
name:'mo_actualizado_soberano',
	value:''
});

this.mo_comprometido_soberano = new Ext.form.NumberField({
	fieldLabel:'Mo comprometido soberano',
name:'mo_comprometido_soberano',
	value:''
});

this.mo_causado_soberano = new Ext.form.NumberField({
	fieldLabel:'Mo causado soberano',
name:'mo_causado_soberano',
	value:''
});

this.mo_pagado_soberano = new Ext.form.NumberField({
	fieldLabel:'Mo pagado soberano',
name:'mo_pagado_soberano',
	value:''
});

this.mo_disponible_soberano = new Ext.form.NumberField({
	fieldLabel:'Mo disponible soberano',
name:'mo_disponible_soberano',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.id_tb084_accion_especifica,
                                                                                this.nu_partida,
                                                                                this.de_partida,
                                                                                this.mo_inicial,
                                                                                this.mo_actualizado,
                                                                                this.mo_precomprometido,
                                                                                this.mo_comprometido,
                                                                                this.mo_causado,
                                                                                this.mo_pagado,
                                                                                this.mo_disponible,
                                                                                this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
                                                                                this.in_movimiento,
                                                                                this.nu_pa,
                                                                                this.nu_ge,
                                                                                this.nu_es,
                                                                                this.nu_se,
                                                                                this.nu_sse,
                                                                                this.co_partida,
                                                                                this.nu_nivel,
                                                                                this.nu_fi,
                                                                                this.co_categoria,
                                                                                this.nu_aplicacion,
                                                                                this.tp_ingreso,
                                                                                this.co_cuenta_contable,
                                                                                this.tip_apl,
                                                                                this.in_gen_cheque,
                                                                                this.tip_gasto,
                                                                                this.tip_ing,
                                                                                this.cod_amb,
                                                                                this.co_ente,
                                                                                this.nu_anio,
                                                                                this.mo_disponible_act,
                                                                                this.mo_aumento,
                                                                                this.mo_disminucion,
                                                                                this.mo_admon,
                                                                                this.mo_actualizado_ant,
                                                                                this.comprometido_dia,
                                                                                this.causado_dia,
                                                                                this.pagado_dia,
                                                                                this.disponible,
                                                                                this.cod_ente,
                                                                                this.nu_sector,
                                                                                this.id_tb139_aplicacion,
                                                                                this.mo_admon_ant,
                                                                                this.mo_modificado_admon,
                                                                                this.co_clasificacion_economica,
                                                                                this.co_area_estrategica,
                                                                                this.mo_inicial_soberano,
                                                                                this.mo_actualizado_soberano,
                                                                                this.mo_comprometido_soberano,
                                                                                this.mo_causado_soberano,
                                                                                this.mo_pagado_soberano,
                                                                                this.mo_disponible_soberano,
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
                     PartidapresupuestoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PartidapresupuestoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PartidapresupuestoFiltro.main.win.close();
                    PartidapresupuestoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PartidapresupuestoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PartidapresupuestoFiltro.main.panelfiltro.getForm().reset();
    PartidapresupuestoLista.main.store_lista.baseParams={}
    PartidapresupuestoLista.main.store_lista.baseParams.paginar = 'si';
    PartidapresupuestoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PartidapresupuestoFiltro.main.panelfiltro.getForm().getValues();
    PartidapresupuestoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PartidapresupuestoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PartidapresupuestoLista.main.store_lista.baseParams.paginar = 'si';
        PartidapresupuestoLista.main.store_lista.baseParams.BuscarBy = true;
        PartidapresupuestoLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storefkidtb084accionespecifica',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreCO_CLASIFICACION_ECONOMICA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storefkcoclasificacioneconomica',
        root:'data',
        fields:[
            {name: 'co_clasificacion_economica'}
            ]
    });
    return this.store;
}

};

Ext.onReady(PartidapresupuestoFiltro.main.init,PartidapresupuestoFiltro.main);
</script>