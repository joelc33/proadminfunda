<script type="text/javascript">
Ext.ns("ConfigConceptoFijoFiltro");
ConfigConceptoFijoFiltro.main = {
init:function(){




this.co_nom_trabajador = new Ext.form.NumberField({
	fieldLabel:'Co nom trabajador',
	name:'co_nom_trabajador',
	value:''
});

this.nu_monto = new Ext.form.NumberField({
	fieldLabel:'Nu monto',
name:'nu_monto',
	value:''
});

this.nu_valor = new Ext.form.NumberField({
	fieldLabel:'Nu valor',
name:'nu_valor',
	value:''
});

this.mo_saldo = new Ext.form.NumberField({
	fieldLabel:'Mo saldo',
name:'mo_saldo',
	value:''
});

this.fe_movimiento = new Ext.form.DateField({
	fieldLabel:'Fe movimiento',
	name:'fe_movimiento'
});

this.fe_vencimiento = new Ext.form.DateField({
	fieldLabel:'Fe vencimiento',
	name:'fe_vencimiento'
});

this.co_embargo = new Ext.form.NumberField({
	fieldLabel:'Co embargo',
	name:'co_embargo',
	value:''
});

this.co_tp_formula = new Ext.form.NumberField({
	fieldLabel:'Co tp formula',
	name:'co_tp_formula',
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

this.tx_codigo_concepto = new Ext.form.TextField({
	fieldLabel:'Tx codigo concepto',
	name:'tx_codigo_concepto',
	value:''
});

this.co_concepto_formula = new Ext.form.NumberField({
	fieldLabel:'Co concepto formula',
	name:'co_concepto_formula',
	value:''
});

this.co_ficha = new Ext.form.NumberField({
	fieldLabel:'Co ficha',
	name:'co_ficha',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_nom_trabajador,
                                                                                this.nu_monto,
                                                                                this.nu_valor,
                                                                                this.mo_saldo,
                                                                                this.fe_movimiento,
                                                                                this.fe_vencimiento,
                                                                                this.co_embargo,
                                                                                this.co_tp_formula,
                                                                                this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
                                                                                this.tx_codigo_concepto,
                                                                                this.co_concepto_formula,
                                                                                this.co_ficha,
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
                     ConfigConceptoFijoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConfigConceptoFijoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConfigConceptoFijoFiltro.main.win.close();
                    ConfigConceptoFijoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConfigConceptoFijoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConfigConceptoFijoFiltro.main.panelfiltro.getForm().reset();
    ConfigConceptoFijoLista.main.store_lista.baseParams={}
    ConfigConceptoFijoLista.main.store_lista.baseParams.paginar = 'si';
    ConfigConceptoFijoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConfigConceptoFijoFiltro.main.panelfiltro.getForm().getValues();
    ConfigConceptoFijoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConfigConceptoFijoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConfigConceptoFijoLista.main.store_lista.baseParams.paginar = 'si';
        ConfigConceptoFijoLista.main.store_lista.baseParams.BuscarBy = true;
        ConfigConceptoFijoLista.main.store_lista.load();


}

};

Ext.onReady(ConfigConceptoFijoFiltro.main.init,ConfigConceptoFijoFiltro.main);
</script>