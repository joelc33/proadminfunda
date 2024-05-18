<script type="text/javascript">
Ext.ns("PresupuestoIngresoFiltro");
PresupuestoIngresoFiltro.main = {
init:function(){




this.nu_partida = new Ext.form.TextField({
	fieldLabel:'Nu partida',
	name:'nu_partida',
	value:''
});

this.tx_partida = new Ext.form.TextField({
	fieldLabel:'Tx partida',
	name:'tx_partida',
	value:''
});

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Tx descripcion',
	name:'tx_descripcion',
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

this.nu_anio = new Ext.form.NumberField({
	fieldLabel:'Nu anio',
name:'nu_anio',
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

this.nu_nivel = new Ext.form.NumberField({
	fieldLabel:'Nu nivel',
name:'nu_nivel',
	value:''
});

this.do_cat = new Ext.form.TextField({
	fieldLabel:'Do cat',
	name:'do_cat',
	value:''
});

this.tip_apl = new Ext.form.TextField({
	fieldLabel:'Tip apl',
	name:'tip_apl',
	value:''
});

this.tip_gas = new Ext.form.TextField({
	fieldLabel:'Tip gas',
	name:'tip_gas',
	value:''
});

this.mo_comprometido_dia = new Ext.form.NumberField({
	fieldLabel:'Mo comprometido dia',
name:'mo_comprometido_dia',
	value:''
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

this.co_cuenta_contable = new Ext.form.NumberField({
	fieldLabel:'Co cuenta contable',
	name:'co_cuenta_contable',
	value:''
});

this.in_movimiento = new Ext.form.Checkbox({
	fieldLabel:'In movimiento',
	name:'in_movimiento',
	checked:true
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.nu_partida,
                                                                                this.tx_partida,
                                                                                this.tx_descripcion,
                                                                                this.mo_inicial,
                                                                                this.mo_actualizado,
                                                                                this.nu_anio,
                                                                                this.mo_comprometido,
                                                                                this.mo_causado,
                                                                                this.mo_pagado,
                                                                                this.mo_disponible,
                                                                                this.nu_nivel,
                                                                                this.do_cat,
                                                                                this.tip_apl,
                                                                                this.tip_gas,
                                                                                this.mo_comprometido_dia,
                                                                                this.nu_pa,
                                                                                this.nu_ge,
                                                                                this.nu_es,
                                                                                this.nu_se,
                                                                                this.nu_sse,
                                                                                this.co_cuenta_contable,
                                                                                this.in_movimiento,
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
                     PresupuestoIngresoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PresupuestoIngresoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PresupuestoIngresoFiltro.main.win.close();
                    PresupuestoIngresoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PresupuestoIngresoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PresupuestoIngresoFiltro.main.panelfiltro.getForm().reset();
    PresupuestoIngresoLista.main.store_lista.baseParams={}
    PresupuestoIngresoLista.main.store_lista.baseParams.paginar = 'si';
    PresupuestoIngresoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PresupuestoIngresoFiltro.main.panelfiltro.getForm().getValues();
    PresupuestoIngresoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PresupuestoIngresoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PresupuestoIngresoLista.main.store_lista.baseParams.paginar = 'si';
        PresupuestoIngresoLista.main.store_lista.baseParams.BuscarBy = true;
        PresupuestoIngresoLista.main.store_lista.load();


}

};

Ext.onReady(PresupuestoIngresoFiltro.main.init,PresupuestoIngresoFiltro.main);
</script>