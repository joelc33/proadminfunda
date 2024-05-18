<script type="text/javascript">
Ext.ns("PresupuestoPartidaFiltro");
PresupuestoPartidaFiltro.main = {
init:function(){

//<Stores de fk>
this.storeID = this.getStoreID();
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
                     PresupuestoPartidaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PresupuestoPartidaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PresupuestoPartidaFiltro.main.win.close();
                    PresupuestoPartidaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PresupuestoPartidaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PresupuestoPartidaFiltro.main.panelfiltro.getForm().reset();
    PresupuestoPartidaLista.main.store_lista.baseParams={}
    PresupuestoPartidaLista.main.store_lista.baseParams.paginar = 'si';
    PresupuestoPartidaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PresupuestoPartidaFiltro.main.panelfiltro.getForm().getValues();
    PresupuestoPartidaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PresupuestoPartidaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PresupuestoPartidaLista.main.store_lista.baseParams.paginar = 'si';
        PresupuestoPartidaLista.main.store_lista.baseParams.BuscarBy = true;
        PresupuestoPartidaLista.main.store_lista.load();


}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoPartida/storefkidtb084accionespecifica',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(PresupuestoPartidaFiltro.main.init,PresupuestoPartidaFiltro.main);
</script>